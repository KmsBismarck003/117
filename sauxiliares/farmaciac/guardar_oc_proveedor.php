<?php
session_start();
include "../../conexionbd.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['id_prov']) || !isset($_POST['cantidad'])) {
        die("Error: Datos incompletos.");
    }

    $id_prov = $_POST['id_prov'];
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $fecha_solicitud = date('Y-m-d');
    $monto_total = 0;
    $productos = $_POST['cantidad'];

    // Calcular el monto total
    foreach ($productos as $item_id => $cantidad) {
        if (is_numeric($cantidad) && $cantidad > 0) {
            $query_precio = "SELECT item_costs FROM item_almacen WHERE item_id = '$item_id'";
            $result_precio = $conexion->query($query_precio);

            if ($result_precio && $result_precio->num_rows > 0) {
                $item_costs = $result_precio->fetch_assoc()['item_costs'];
                $monto_total += $item_costs * $cantidad;
            } else {
                echo "Error: No se encontró el precio del producto con ID $item_id.";
                exit;
            }
        }
    }

    // Insertar orden de compra
    $sql_insert_oc = "INSERT INTO ordenes_compra (id_prov, fecha_solicitud, monto, id_usua, estatus) 
                      VALUES ('$id_prov', '$fecha_solicitud', '$monto_total', '$id_usua', 'PENDIENTE')";

    if ($conexion->query($sql_insert_oc)) {
        $id_compra = $conexion->insert_id;

        // Insertar detalles de la orden de compra
        foreach ($productos as $item_id => $cantidad) {
            if (is_numeric($cantidad) && $cantidad > 0) {
                $sql_insert_detalle = "INSERT INTO orden_compra (id_compra, item_id, solicita) 
                                       VALUES ('$id_compra', '$item_id', '$cantidad')";
                $conexion->query($sql_insert_detalle);
            }
        }

        // Mostrar modal de confirmación
        echo "
        <script>
            window.onload = function() {
                $('#confirmacionModal').modal('show');
            }
        </script>";
    } else {
        echo "Error al guardar la orden: " . $conexion->error;
    }
} else {
    echo "Error: Método de solicitud no válido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar Orden de Compra</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<!-- Modal de confirmación -->
<div class="modal fade" id="confirmacionModal" tabindex="-1" role="dialog" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmacionModalLabel">Orden Generada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                La orden de compra ha sido generada exitosamente.
            </div>
            <div class="modal-footer">
                <a href="ordenes_compra.php" class="btn btn-primary">Ver Órdenes de Compra</a>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2>Procesando la orden de compra...</h2>
    <p>Espere un momento mientras se genera la orden.</p>
</div>
</body>
</html>
