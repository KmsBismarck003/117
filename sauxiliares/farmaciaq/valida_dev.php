<?php
include "../../conexionbd.php";
date_default_timezone_set('America/Guatemala');
$fecha_actual = date("Y-m-d H:i:s");

// Recuperar los datos enviados por el formulario
$id_devi = $_POST['id_dev']; // ID de la devolución
$item_idi = $_POST['item_id']; // ID del ítem
$dev_qtyi = $_POST['dev_qty']; // Cantidad total devuelta
$cant_invi = $_POST['cant_inv']; // Cantidad ingresada por el usuario para inventario
$motivoi = $_POST['motivoi']; // Motivo ingresado
$id_usua = $_POST['id_usua']; // ID del usuario que realiza la acción
$lote = $_POST['existe_lote']; // Lote del producto
$caducidad = $_POST['existe_caducidad']; // Fecha de caducidad

// Verificar si el ítem existe en existencias_almacenh
$existe = "NO";
$total = 0;
$totdevol = 0;

$sql = "SELECT * FROM existencias_almacenhq WHERE item_id = $item_idi";
$result_existencias_almacenh = $conexion->query($sql);

while ($row_existencias_almacenh = $result_existencias_almacenh->fetch_assoc()) {
    $existe_id = $row_existencias_almacenh['existe_id'];
    $existe_qty = $row_existencias_almacenh['existe_qty'];
    $existe_devoluciones = $row_existencias_almacenh['existe_devoluciones'];
    $existe = "SI";
}

// Actualizar o insertar en existencias_almacenq
if ($existe === "SI") {
    $total = $existe_qty + $cant_invi;
    $totdevol = $existe_devoluciones + $cant_invi;
    $sql1 = "UPDATE existencias_almacenq
            SET existe_qty = $total, 
                existe_devoluciones = $totdevol, 
                existe_lote = '$lote',
                existe_caducidad = '$caducidad'
            WHERE existe_id = $existe_id";
    $result_existencias_almacenq = $conexion->query($sql1);
} else {
    $existencias_almacenq = mysqli_query(
        $conexion,
        "INSERT INTO existencias_almacenq(item_id, existe_qty, existe_devoluciones, existe_fecha, id_usua, existe_lote, existe_caducidad) VALUES ($item_idi, $cant_invi, $cant_invi, '$fecha_actual', $id_usua, '$lote', '$caducidad')"
    ) or die('<p>Error al registrar en existencias_almacenq</p>' . mysqli_error($conexion));
}

// Obtenemos la cantidad disponible actual en existencias_almacenh (existe_qty)
$sql_existencias = "SELECT existe_qty FROM existencias_almacenq WHERE item_id = $item_idi";
$result_existencias = $conexion->query($sql_existencias);

if ($row_existencias = $result_existencias->fetch_assoc()) {
    $existe_qty = $row_existencias['existe_qty']; // Cantidad disponible actual
} else {
    die('Error al obtener las existencias de existencias_almacenq: ' . mysqli_error($conexion));
}

// Calcular la nueva cantidad devuelta
$new_qty = $dev_qtyi - $cant_invi;

// **Validación de la cantidad**: No permitir actualización si la nueva cantidad devuelta es menor a 0
if ($new_qty < 0) {
    die('Error: La cantidad devuelta no puede ser menor a cero.');
}

// Actualizar la cantidad devuelta y otros campos en devoluciones_almacenh
$sql2 = "UPDATE devoluciones_almacenq 
        SET cant_inv = '$cant_invi', 
            motivoi = '$motivoi', 
            dev_qty = '$new_qty',
            id_usua = '$id_usua' 
        WHERE dev_id = $id_devi";
$result2 = $conexion->query($sql2);

// Verificar si ya no queda cantidad pendiente
if ($new_qty === 0) {
    $sql3 = "UPDATE devoluciones_almacenq 
            SET dev_estatus = 'NO' 
            WHERE dev_id = $id_devi";
    $result3 = $conexion->query($sql3);
}

// Insertar movimiento en el kardex_almacenh
$sql_kardex = "INSERT INTO kardex_almacenq (item_id, kardex_fecha, kardex_lote, kardex_caducidad, kardex_inicial, kardex_entradas, kardex_salidas, kardex_qty, kardex_dev_stock, kardex_dev_merma, kardex_movimiento, kardex_ubicacion, kardex_destino, id_usua
) VALUES ($item_idi, '$fecha_actual', '$lote', '$caducidad', 0, $cant_invi,  $cant_invi,  $existe_qty, $cant_invi,  '',  'Devolución',  'Ubicación_Almacén',  'Devolución',  $id_usua )";

// Ejecutar el INSERT en la tabla kardex_almacenq
$result_kardex = $conexion->query($sql_kardex);

if (!$result_kardex) {
    die('Error al registrar en kardex_almacenq: ' . mysqli_error($conexion));
}

// Redirigir al usuario
echo '<script type="text/javascript"> window.location.href="devolucionesq.php";</script>';
?>
