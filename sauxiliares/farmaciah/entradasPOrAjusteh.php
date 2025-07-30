<?php
include "conexionbd.php";
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

$usuario = $_SESSION['login'];
date_default_timezone_set('America/Guatemala');

// Consulta para obtener las órdenes de compra activas
$ordenes = $conexion->query("SELECT id_compra FROM ordenes_compra WHERE activo = 'SI'");

// Variables para el formulario
$ordenSeleccionada = isset($_POST['id_compra']) ? $_POST['id_compra'] : '';
$mostrarFormulario = false;
$proveedorNombre = '';

if ($ordenSeleccionada) {
    // Obtener detalles de la orden y el proveedor
    $detallesOrden = $conexion->query("SELECT oc.*, p.nom_prov 
        FROM orden_compra oc 
        INNER JOIN ordenes_compra o ON oc.id_compra = o.id_compra 
        INNER JOIN proveedores p ON o.id_prov = p.id_prov 
        WHERE oc.id_compra = '$ordenSeleccionada'");

    if ($detallesOrden->num_rows > 0) {
        $detalle = $detallesOrden->fetch_assoc();
        $proveedorNombre = $detalle['nom_prov'];
        $mostrarFormulario = true;
        // Regresar al inicio del resultado para usarlo después
        $detallesOrden->data_seek(0);
    }
}

// Procesar el formulario de entrada
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['guardar'])) {
    $id_compra = $_POST['id_compra'];
    $item_ids = $_POST['item_ids'];
    $cantidades = $_POST['cantidad'];
    $lotes = $_POST['lote'];
    $fecha = date('Y-m-d H:i:s');

    foreach ($item_ids as $index => $item_id) {
        // Insertar en la tabla de entradas
        $query = "INSERT INTO entradas (id_compra, item_id, cantidad, lote, fecha) 
                 VALUES ('$id_compra', '$item_id', '{$cantidades[$index]}', '{$lotes[$index]}', '$fecha')";
        $conexion->query($query);
    }

    // Actualizar estado de la orden
    $conexion->query("UPDATE ordenes_compra SET activo = 'NO' WHERE id_compra = '$id_compra'");
    
    header('Location: entradas.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Entradas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-header {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .form-group {
            flex: 1;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        input[type="text"], 
        input[type="number"], 
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sistema de Entradas</h2>
        
        <?php if (!$mostrarFormulario) { ?>
            <form method="POST">
                <div class="form-group">
                    <label>Seleccione una orden:</label>
                    <select name="id_compra" required>
                        <option value="">-- Seleccione --</option>
                        <?php while ($row = $ordenes->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_compra']; ?>">
                                Orden #<?php echo $row['id_compra']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn">Cargar Orden</button>
            </form>
        <?php } else { ?>
            <form method="POST">
                <input type="hidden" name="id_compra" value="<?php echo $ordenSeleccionada; ?>">
                
                <!-- Información básica -->
                <div class="form-header">
                    <div class="form-group">
                        <label>Proveedor:</label>
                        <input type="text" value="<?php echo $proveedorNombre; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Orden #:</label>
                        <input type="text" value="<?php echo $ordenSeleccionada; ?>" readonly>
                    </div>
                </div>

                <!-- Tabla de Items -->
                <table>
                    <tr>
                        <th>ID Item</th>
                        <th>Lote</th>
                        <th>Cantidad</th>
                    </tr>
                    <?php while ($item = $detallesOrden->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <?php echo $item['item_id']; ?>
                                <input type="hidden" name="item_ids[]" value="<?php echo $item['item_id']; ?>">
                            </td>
                            <td>
                                <input type="text" name="lote[]" required placeholder="Número de lote">
                            </td>
                            <td>
                                <input type="number" name="cantidad[]" required placeholder="Cantidad">
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <button type="submit" name="guardar" class="btn">Guardar Entrada</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>
