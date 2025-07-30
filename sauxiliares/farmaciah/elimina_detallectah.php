<?php
session_start();
include "../../conexionbd.php";

// Sanitizar y validar los datos de entrada
$id_ctapac = intval($_GET['id_ctapac']);
$id_atencion = intval($_GET['id_at']);
$id_exp = $conexion->real_escape_string($_GET['id_exp']);
$id_usua = intval($_GET['id_usua']);
$rol = intval($_GET['rol']);
$item_id = isset($_GET['item_id']) ? intval($_GET['item_id']) : null; // Capturar el item_id

if ($rol == 5 || $rol == 1) {
    // Obtener detalles del registro en `dat_ctapac`
    $sql_prod_serv = "SELECT prod_serv, insumo, cta_cant, salida_id, existe_lote, existe_caducidad FROM dat_ctapac WHERE id_ctapac = ?";
    $stmt = $conexion->prepare($sql_prod_serv);
    $stmt->bind_param("i", $id_ctapac);
    $stmt->execute();
    $resultado_prod_serv = $stmt->get_result();

    if ($resultado_prod_serv->num_rows > 0) {
        $row = $resultado_prod_serv->fetch_assoc();
        $prod_serv = $row['prod_serv'];
        $cta_cant = floatval($row['cta_cant']);
        $item_id = $item_id ?? intval($row['insumo']); // Usar parámetro recibido o insumo del registro
        $lote = $row['existe_lote'] ?? "N/A"; 
        $caducidad = $row['existe_caducidad'] ?? "2024-01-01";
        
        $dev_estatus = "SI"; 
        $cant_inv = 0;
        $cant_mer = 0;
        $motivoi = "";
        $motivom = "";

        // Insertar nueva devolución en `devoluciones_almacenh`
        $sql_insert_devolucion = "INSERT INTO devoluciones_almacenh (dev_id, item_id, salida_id,existe_lote, existe_caducidad, dev_qty, cant_inv, cant_mer, dev_estatus, fecha, id_usua, motivoi, motivom, id_atencion, id_usua2) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ? )";
        $stmt_devolucion = $conexion->prepare($sql_insert_devolucion);
        $stmt_devolucion->bind_param("iisssiiissisi",$item_id,$row['salida_id'],$lote,$caducidad,$cta_cant,$cant_inv,$cant_mer,$dev_estatus,$id_usua,$motivoi,$motivom,$id_atencion,$id_usua);

        if ($stmt_devolucion->execute()) {
            echo "<script>
                alert('Devolución registrada exitosamente.');
            </script>";
        } else {
            echo "<script>
                alert('Error al registrar la devolución: " . $conexion->error . "');
            </script>";
        }

        // Eliminar el registro de `dat_ctapac` después de la operación
        $sql_eliminar = "DELETE FROM dat_ctapac WHERE id_ctapac = ?";
        $stmt_delete = $conexion->prepare($sql_eliminar);
        $stmt_delete->bind_param("i", $id_ctapac);

        if ($stmt_delete->execute()) {
            echo "<script>
                alert('Registro eliminado de dat_ctapac exitosamente.');
                window.location.href = document.referrer; // Redirige a la misma página
            </script>";
        } else {
            echo "<script>
                alert('Error al eliminar el registro de dat_ctapac: " . $conexion->error . "');
                window.location.href = document.referrer; // Redirige a la misma página
            </script>";
        }
    } else {
        echo "<script>
            alert('No se encontró el registro con el id_ctapac proporcionado.');
            window.location.href = document.referrer; // Redirige a la misma página
        </script>";
    }
} else {
    echo "<script>
        alert('No tiene permisos para realizar esta acción.');
        window.location.href = document.referrer; // Redirige a la misma página
    </script>";
}
?>
