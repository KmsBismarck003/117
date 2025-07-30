<?php
session_start();
include "../../conexionbd.php";

// Verificar que se recibió información
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['cantidad']) || !isset($_POST['id_prov'])) {
        die("Error: Datos incompletos.");
    }

    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $fecha_solicitud = date('Y-m-d');
    $monto_total = 0;
    $productos = $_POST['cantidad'];
    $id_prov = $_POST['id_prov']; // El proveedor seleccionado

    // Calcular el monto total y verificar los productos
    foreach ($productos as $item_id => $cantidad) {
        if (is_numeric($cantidad) && $cantidad > 0) {
            $query_producto = "SELECT item_costs FROM item_almacen WHERE item_id = '$item_id'";
            $result_producto = $conexion->query($query_producto);

            if ($result_producto && $result_producto->num_rows > 0) {
                $producto = $result_producto->fetch_assoc();
                $item_costs = $producto['item_costs'];
                $monto_total += $item_costs * $cantidad;
            } else {
                echo "Error: No se encontró el producto con ID $item_id.";
                exit;
            }
        }
    }

    // Insertar la orden de compra en la tabla `ordenes_compra`
    $sql_insert_oc = "INSERT INTO ordenes_compra (id_prov, fecha_solicitud, monto, id_usua, estatus)
                      VALUES ('$id_prov', '$fecha_solicitud', '$monto_total', '$id_usua', 'PENDIENTE')";

    if ($conexion->query($sql_insert_oc)) {
        $id_compra = $conexion->insert_id;

        // Insertar los detalles de la orden de compra
        foreach ($productos as $item_id => $cantidad) {
            if (is_numeric($cantidad) && $cantidad > 0) {
                $sql_insert_detalle = "INSERT INTO orden_compra (id_compra, item_id, solicita)
                                       VALUES ('$id_compra', '$item_id', '$cantidad')";
                $conexion->query($sql_insert_detalle);
            }
        }

        // Confirmación de la orden generada
        echo "
        <script>
            window.onload = function() {
                alert('La orden de compra ha sido generada exitosamente.');
                window.location.href = 'ordenes_compra.php'; // Redirigir a la lista de órdenes de compra
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
