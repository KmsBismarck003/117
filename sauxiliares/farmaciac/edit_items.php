<?php
session_start();
include "../../conexionbd.php";

// Verifica si se especificó el ID del producto
if (!isset($_GET['id'])) {
    echo "<script>alert('ID del producto no especificado.'); window.location='index.php';</script>";
    exit();
}

$id = $_GET['id'];

// Obtiene los datos del producto
$resultado = $conexion->query("SELECT * FROM item_almacen WHERE item_id = $id") or die($conexion->error);
$row = $resultado->fetch_assoc();

if (!$row) {
    echo "<script>alert('Producto no encontrado.'); window.location='index.php';</script>";
    exit();
}

// Verifica el rol del usuario
$usuario = $_SESSION['login'];
if (!in_array($usuario['id_rol'], [4, 5, 11])) {
    echo "<script>window.location='../../index.php';</script>";
    exit();
}

// Procesa el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_code = $conexion->real_escape_string($_POST['item_code']);
    $item_name = $conexion->real_escape_string($_POST['item_name']);
    $item_comercial = $conexion->real_escape_string($_POST['item_comercial']);
    $item_grams = $conexion->real_escape_string($_POST['item_grams']);
    $id_prov = $conexion->real_escape_string($_POST['id_prov']);
    $factor = $conexion->real_escape_string($_POST['factor']);
    $item_max = $conexion->real_escape_string($_POST['item_max']);
    $reorden = $conexion->real_escape_string($_POST['reorden']);
    $item_min = $conexion->real_escape_string($_POST['item_min']);
    $item_costs = $conexion->real_escape_string($_POST['item_costs']);
    $item_price = $conexion->real_escape_string($_POST['item_price']);
    $subfamilia = $conexion->real_escape_string($_POST['subfamilia']);
    $grupo = $conexion->real_escape_string($_POST['grupo']);
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $activo = $conexion->real_escape_string($_POST['activo']);

    // Calcula el costo unitario dividiendo el costo total entre el factor
    if ($factor > 0) {
        $cost_unit = $item_costs / $factor;
    } else {
        echo "<script>alert('El factor debe ser mayor a 0.');</script>";
        exit();
    }

    // Actualiza el producto en la base de datos
    $query = "UPDATE item_almacen SET 
        item_code='$item_code', 
        item_name='$item_name', 
        item_comercial='$item_comercial', 
        item_grams='$item_grams', 
        id_prov='$id_prov', 
        factor='$factor', 
        item_max='$item_max', 
        reorden='$reorden', 
        item_min='$item_min', 
        cost_unit=$cost_unit,
        item_costs='$item_costs', 
        item_price='$item_price', 
        subfamilia='$subfamilia', 
        grupo='$grupo', 
        tipo='$tipo', 
        activo='$activo' 
        WHERE item_id=$id";

    if ($conexion->query($query)) {
        echo "<script>alert('Producto actualizado correctamente.'); window.location='cat_maestro.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el producto.');</script>";
    }
}

$id_prov = $row['id_prov'];

// Asegúrate de que id_prov sea un valor numérico para evitar inyecciones SQL
if (is_numeric($id_prov)) {
    // Escapamos el id_prov para protegerlo de inyecciones SQL
    $id_prov = $conexion->real_escape_string($id_prov);

    // Realiza la consulta para obtener el nombre del proveedor
    $resultado_proveedor = $conexion->query("SELECT nom_prov FROM proveedores WHERE id_prov = '$id_prov'");

    if ($resultado_proveedor) {
        // Verifica si el proveedor existe
        if ($prov_row = $resultado_proveedor->fetch_assoc()) {
            // Asigna el nombre del proveedor, si se encuentra
            $nombre_proveedor = $prov_row['nom_prov'];
        } else {
            // Si no se encuentra el proveedor
            $nombre_proveedor = 'Proveedor no encontrado';
        }
    } else {
        // Si ocurre un error en la consulta
        $nombre_proveedor = 'Error en la consulta: ' . $conexion->error;
    }
} else {
    // Si el id_prov no es un valor numérico
    $nombre_proveedor = 'ID de proveedor inválido';
}

include "../header_farmaciac.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f7f7;
        }

        .container {
            background-color: white;
            padding: 20px;
            margin-top: 50px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary,
        .btn-secondary {
            padding: 10px 20px;
        }

        .btn-primary {
            background-color: #0c675e;
            border-color: #0c675e;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Editar Producto</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="item-code">Código:</label>
                <input type="text" name="item_code" class="form-control" id="item-code" value="<?= $row['item_code'] ?>" required>
            </div>
            <div class="form-group">
                <label for="item-name">Descripción:</label>
                <input type="text" name="item_name" class="form-control" id="item-name" value="<?= $row['item_name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="item-comercial">Nombre Comercial:</label>
                <input type="text" name="item_comercial" class="form-control" id="item-comercial" value="<?= $row['item_comercial'] ?>" required>
            </div>
            <div class="form-group">
                <label for="item-grams">Presentación (g):</label>
                <input type="text" name="item_grams" class="form-control" id="item-grams" value="<?= $row['item_grams'] ?>" placeholder="Presentación en gramos" required>
            </div>
            <div class="form-group">
                <label for="item-type">Surte:</label>
                <select name="item_type_id" class="form-control" id="item-type" required>
                    <option value="">Selecciona un tipo</option>
                    <?php
                    // Consulta para obtener los tipos
                    $tipo_resultado = $conexion->query("SELECT item_type_id, item_type_desc FROM item_type") or die($conexion->error);
                    while ($tipo = $tipo_resultado->fetch_assoc()) {
                        echo '<option value="' . $tipo['item_type_id'] . '" ' . ($row['item_type_id'] == $tipo['item_type_id'] ? 'selected' : '') . '>' . $tipo['item_type_desc'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_prov">Proveedor:</label>
                <select name="id_prov" class="form-control" id="id_prov" required>
                    <option value="">Selecciona un proveedor</option>
                    <?php
                    // Consulta para obtener los proveedores
                    $resultado_proveedores = $conexion->query("SELECT id_prov, nom_prov FROM proveedores") or die($conexion->error);

                    // Si se está editando un item, obtén el proveedor actual
                    $selected_id_prov = $row['id_prov'] ?? null;

                    while ($row_prov = $resultado_proveedores->fetch_assoc()) {
                        // Verifica si el proveedor actual es el que se está editando
                        $selected = isset($selected_id_prov) && $selected_id_prov == $row_prov['id_prov'] ? 'selected' : '';
                        echo '<option value="' . $row_prov['id_prov'] . '" ' . $selected . '>' . htmlspecialchars($row_prov['nom_prov']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="factor">Factor:</label>
                <input type="number" name="factor" class="form-control" id="factor" value="<?= $row['factor'] ?>" min="1" step="any" required>
            </div>
            <div class="form-group">
                <label for="item-costs">Costo Total:</label>
                <input type="number" name="item_costs" class="form-control" id="item-costs" value="<?= $row['item_costs'] ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="item-price">Precio Unitario:</label>
                <input type="number" name="item_price" class="form-control" id="item-price" value="<?= $row['item_price'] ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="item-max">Máximo:</label>
                <input type="number" name="item_max" class="form-control" id="item-max" value="<?= $row['item_max'] ?>" min="0" required>
            </div>
            <div class="form-group">
                <label for="item-min">Mínimo:</label>
                <input type="number" name="item_min" class="form-control" id="item-min" value="<?= $row['item_min'] ?>" min="0" required>
            </div>
            <div class="form-group">
                <label for="reorden">Punto de Reorden:</label>
                <input type="number" name="reorden" class="form-control" id="reorden" value="<?= $row['reorden'] ?>" min="0" required>
            </div>
            <div class="form-group">
                <label for="subfamilia">Subfamilia:</label>
                <input type="text" name="subfamilia" class="form-control" id="subfamilia" value="<?= $row['subfamilia'] ?>" required>
            </div>
            <div class="form-group">
                <label for="grupo">Grupo:</label>
                <input type="text" name="grupo" class="form-control" id="grupo" value="<?= $row['grupo'] ?>" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <input type="text" name="tipo" class="form-control" id="tipo" value="<?= $row['tipo'] ?>" required>
            </div>
            <div class="form-group">
                <label for="activo">Activo:</label>
                <select name="activo" class="form-control" id="activo" required>
                    <option value="SI" <?= $row['activo'] == 'SI' ? 'selected' : '' ?>>SI</option>
                    <option value="NO" <?= $row['activo'] == 'NO' ? 'selected' : '' ?>>NO</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="cat_maestro.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
