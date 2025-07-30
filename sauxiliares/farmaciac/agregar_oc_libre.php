<?php
session_start();
include "../../conexionbd.php";

if (!isset($_SESSION['login'])) {
    echo "<script>window.location='../../index.php';</script>";
    exit;
}

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

// Comprobar si se ha seleccionado un proveedor
if (isset($_POST['id_prov'])) {
    $id_prov = $_POST['id_prov'];

    // Consulta para obtener los productos del proveedor seleccionado
    $query = "SELECT item_almacen.item_id, item_almacen.item_name, item_almacen.item_code, item_almacen.item_grams, item_type.item_type_desc 
              FROM item_almacen 
              INNER JOIN item_type ON item_almacen.item_type_id = item_type.item_type_id
              WHERE item_almacen.id_prov = '$id_prov'";

    $result = $conexion->query($query) or die($conexion->error);
} else {
    // Si no se ha seleccionado un proveedor, obtener la lista de proveedores
    $query_proveedores = "SELECT DISTINCT id_prov FROM item_almacen";
    $result_proveedores = $conexion->query($query_proveedores) or die($conexion->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Generar Orden de Compra por Proveedor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="text-center">Generar Orden de Compra por Proveedor</h3>
        </div>
        <div class="card-body">
            <?php if (!isset($_POST['id_prov'])): ?>
                <!-- Formulario para seleccionar el proveedor -->
                <form method="post" action="genera_oc_proveedor.php">
                    <div class="form-group">
                        <label for="id_prov">Selecciona un Proveedor:</label>
                        <select class="form-control" id="id_prov" name="id_prov" required>
                            <option value="">Seleccione un proveedor</option>
                            <?php while ($row = $result_proveedores->fetch_assoc()): ?>
                                <option value="<?php echo $row['id_prov']; ?>"><?php echo $row['id_prov']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Mostrar Productos</button>
                </form>
            <?php else: ?>
                <!-- Formulario para mostrar y seleccionar productos del proveedor -->
                <form method="post" action="guardar_oc_proveedor.php">
                    <input type="hidden" name="id_prov" value="<?php echo $id_prov; ?>">
                    <div class="form-group">
                        <label>Proveedor Seleccionado: <strong><?php echo $id_prov; ?></strong></label>
                    </div>

                    <h4 class="text-center mb-3">Seleccione los productos a incluir en la orden de compra</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>Seleccionar</th>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Gramos</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><input type="checkbox" name="productos[]" value="<?php echo $row['item_id']; ?>"></td>
                                        <td><?php echo $row['item_id']; ?></td>
                                        <td><?php echo $row['item_name']; ?></td>
                                        <td><?php echo $row['item_code']; ?></td>
                                        <td><?php echo $row['item_grams']; ?></td>
                                        <td><?php echo $row['item_type_desc']; ?></td>
                                        <td><input type="number" name="cantidad_<?php echo $row['item_id']; ?>" class="form-control" min="1" required></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-danger">No hay productos disponibles para este proveedor.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Generar Orden de Compra</button>
                    <a href="genera_oc_proveedor.php" class="btn btn-danger btn-block mt-3">Cancelar</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
