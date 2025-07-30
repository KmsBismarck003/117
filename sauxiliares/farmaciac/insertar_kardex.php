<?php
session_start();
include "../../conexionbd.php";

$usuario = $_SESSION['login'];
$id_usuario = $usuario['id_usua'];

date_default_timezone_set('America/Guatemala');

// Verificar rol
if (isset($usuario['id_rol'])) {
    if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
        include "../header_farmaciac.php";
    } else {
        session_unset();
        session_destroy();
        echo "<script>window.location='../../index.php';</script>";
        exit();
    }
}

// Consultas para selects
$result_items = $conexion->query("SELECT item_id, item_name, item_grams FROM item_almacen");
$result_ubicaciones = $conexion->query("SELECT ubicacion_id, nombre_ubicacion FROM ubicaciones_almacen");

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $lote = $_POST['kardex_lote'];
    $caducidad = $_POST['kardex_caducidad'];
    $unidosis = $_POST['kardex_entradas'];
    $ubicacion_id = $_POST['kardex_ubicacion'];
    $factura = trim($_POST['factura']);

    // Validación: el campo factura no debe estar vacío
    if (empty($factura)) {
        echo "<script>alert('El campo Factura es obligatorio.'); history.back();</script>";
        exit();
    }

    // Para entradas directas, no asociamos con una orden de compra específica
    $id_compra = NULL; 
    $costo = 0.0; 
    $entrada_recibido = date("Y-m-d H:i:s");

    $query_insert = "
        INSERT INTO entradas_almacen (
            entrada_fecha, id_compra, item_id, entrada_lote, entrada_caducidad,
            entrada_unidosis, entrada_costo,factura,
            id_usua, ubicacion_id, entrada_recibido
        ) VALUES (
            NOW(), NULL, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?
        )
    ";

    $stmt = $conexion->prepare($query_insert);
    $stmt->bind_param("issiissis", $item_id, $lote, $caducidad, $unidosis, $costo, $factura, $id_usuario, $ubicacion_id, $entrada_recibido);
    
    if ($stmt->execute()) {
        echo "<script>alert('Registro insertado con éxito'); window.location.href='entradas.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Entrada</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-4">
<div class="container">
    <h2>Registrar Entrada Directa</h2>
    <form method="POST" class="mt-4">
        <div class="form-group">
            <label for="item_id">Medicamento:</label>
            <select name="item_id" class="form-control" required>
                <option value="">Selecciona un medicamento</option>
                <?php while ($row = $result_items->fetch_assoc()): ?>
                    <option value="<?= $row['item_id'] ?>"><?= $row['item_name'].', '.$row['item_grams'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Lote:</label>
            <input type="text" name="kardex_lote" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Caducidad:</label>
            <input type="date" name="kardex_caducidad" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Entrada (cantidad recibida):</label>
            <input type="number" name="kardex_entradas" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Documento de Entrada:</label>
            <input type="text" name="factura" class="form-control" placeholder="" required>
        </div>

        <div class="form-group">
            <label>Ubicación:</label>
            <select name="kardex_ubicacion" class="form-control" required>
                <option value="">Selecciona una ubicación</option>
                <?php while ($row = $result_ubicaciones->fetch_assoc()): ?>
                    <option value="<?= $row['ubicacion_id'] ?>"><?= $row['nombre_ubicacion'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar Registro</button>
        <a href="entradas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
