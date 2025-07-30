<?php
session_start();
include "../../conexionbd.php";

if (!isset($_SESSION['login'])) {
    echo "<script>window.location='../../index.php';</script>";
    exit;
}

include "../header_farmaciac.php";

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

// Asegúrate de obtener el ID del producto de forma segura
$item_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($item_id === null) {
    echo "<script>alert('ID de producto no válido.'); window.location='vista_existencias.php';</script>";
    exit;
}

// Consulta para obtener la información del producto
$resultado = $conexion->query("SELECT item_almacen.*, item_type.item_type_desc FROM item_almacen JOIN item_type ON item_almacen.item_type_id = item_type.item_type_id WHERE item_almacen.item_id = '$item_id'") or die($conexion->error);

if ($resultado->num_rows === 0) {
    echo "<script>alert('Producto no encontrado.'); window.location='vista_existencias.php';</script>";
    exit;
}

$item = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar Orden de Compra</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="text-center">Generar Orden de Compra</h2>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form method="post" action="guardar_oc.php">
                <div class="form-group">
                    <label for="item_name">Medicamento / Insumo</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo htmlspecialchars($item['item_name'] . ', ' . $item['item_grams'] . ', ' . $item['item_type_desc']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="item_code">Código del Medicamento</label>
                    <input type="text" class="form-control" id="item_code" name="item_code" value="<?php echo htmlspecialchars($item['item_code']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad a ordenar</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" required min="1">
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha de la Orden</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item_id); ?>">
                <input type="hidden" name="id_usua" value="<?php echo htmlspecialchars($id_usua); ?>">

                <button type="submit" class="btn btn-success btn-block">Generar Orden de Compra</button>
            </form>
            <a href="javascript:history.back()" class="btn btn-danger mt-3">Cancelar</a>
        </div>
    </div>
</div>

<footer class="main-footer">
    <?php include("../../template/footer.php"); ?>
</footer>
</body>
</html>
