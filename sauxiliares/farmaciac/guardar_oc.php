<?php
session_start();
include "../../conexionbd.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica que se reciban los datos necesarios
    if (!isset($_POST['item_id']) || !isset($_POST['cantidad'])) {
        die("Error: Datos incompletos.");
    }

    $item_id = intval($_POST['item_id']);
    $cantidad = intval($_POST['cantidad']);
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $fecha_solicitud = date('Y-m-d');
    $monto_total = 0;

    // Obtener el precio del producto
    $query_precio = "SELECT item_cost FROM item_almacen WHERE item_id = '$item_id'";
    $result_precio = $conexion->query($query_precio);

    if ($result_precio && $result_precio->num_rows > 0) {
        $item_cost = $result_precio->fetch_assoc()['item_cost'];
        $monto_total = $item_cost * $cantidad;
    } else {
        echo "Error: No se encontró el precio del producto con ID $item_id.";
        exit;
    }

    // Insertar la orden de compra
    $sql_insert_oc = "INSERT INTO ordenes_compra (fecha_solicitud, monto, id_usua, estatus) 
                      VALUES ('$fecha_solicitud', '$monto_total', '$id_usua', 'PENDIENTE')";

    if ($conexion->query($sql_insert_oc)) {
        $id_compra = $conexion->insert_id;

        // Insertar el detalle de la orden de compra
        $sql_insert_detalle = "INSERT INTO detalles_orden (id_compra, item_id, cantidad) 
                                VALUES ('$id_compra', '$item_id', '$cantidad')";
        $conexion->query($sql_insert_detalle);

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
