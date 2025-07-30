<?php
session_start();
include "../../conexionbd.php";

// Iniciar el buffer de salida para prevenir errores de encabezado
ob_start();

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

if (isset($usuario['id_rol'])) {
    if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
        include "../header_farmaciaq.php";
    } else {
        // Si el usuario no tiene un rol permitido, destruir la sesión y redirigir
        session_unset();
        session_destroy();
        echo "<script>window.location='../../index.php';</script>";
        exit();
    }
}

// Verificar si se han enviado las fechas inicial y final
if (isset($_POST['inicial']) && isset($_POST['final'])) {
    $inicial = mysqli_real_escape_string($conexion, $_POST['inicial']);
    $final = mysqli_real_escape_string($conexion, $_POST['final']);

    // Añadir un día a la fecha final para incluirla en el filtro
    $final = date("Y-m-d H:i:s", strtotime($final . " + 1 day"));

    // Consulta para obtener los datos de la tabla `merma_almacenq` con JOIN y filtro de fechas
    $resultado = $conexion->query("
        SELECT 
            m.merma_id,
            m.merma_fecha,
            i.item_code,
            i.item_name,
            m.merma_lote,
            m.merma_caducidad,
            m.merma_qty,
            m.merma_motivo,
            u.nombre_ubicacion,
            m.id_usua
        FROM 
            merma_almacenq m
        JOIN 
            item_almacen i ON m.item_id = i.item_id
        JOIN 
            ubicaciones_almacen u ON m.ubicacion_id = u.ubicacion_id
        WHERE 
            m.merma_fecha >= '$inicial' AND m.merma_fecha <= '$final'
    ") or die($conexion->error);
} else {
    // Consulta sin filtro de fechas si no se han enviado las fechas
    $resultado = $conexion->query("
        SELECT 
            m.merma_id,
            m.merma_fecha,
            i.item_code,
            i.item_name,
            m.merma_lote,
            m.merma_caducidad,
            m.merma_qty,
            m.merma_motivo,
            u.nombre_ubicacion,
            m.id_usua
        FROM 
            merma_almacenq m
        JOIN 
            item_almacen i ON m.item_id = i.item_id
        JOIN 
            ubicaciones_almacen u ON m.ubicacion_id = u.ubicacion_id
        ORDER BY 
            m.merma_fecha DESC
        LIMIT 50
    ") or die($conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <a href='kardexq.php' style='color: white; margin-left: 33px; background-color: #d9534f; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer;'>Regresar</a>

    <div class="container">
        <div class="thead" style="background-color: #0c675e; margin: 5px auto; padding: 5px; color: white; width: fit-content; text-align: center; border-radius: 5px;">
            <h1 style="font-size: 26px; margin: 0;">MERMAS</h1>
        </div>

        <br><br>

        <!-- Formulario de filtro de fechas -->
        <form method="POST" action="">
            <div class="row">
                <div class="col-sm-2">
                    <label>Fecha Inicial:</label>
                    <input type="date" class="form-control" name="inicial">
                </div>
                <div class="col-sm-2">
                    <label>Fecha Final:</label>
                    <input type="date" class="form-control" name="final">
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success">Filtrar</button>
                </div>
            </div>
        </form>
        <br><br>

        <?php if ($resultado->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead" style="background-color: #0c675e; color:white;">
                        <tr>
                            <th>ID Merma</th>
                            <th>Fecha</th>
                            <th>Código Item</th>
                            <th>Nombre Item</th>
                            <th>Lote</th>
                            <th>Caducidad</th>
                            <th>Cantidad Merma</th>
                            <th>Motivo Merma</th>
                            <th>Nombre Ubicación</th>
                            <th>ID Usuario</th>
                        </tr>
                    </thead>

                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td class="disabled-field"><?php echo $row['merma_id']; ?></td>
                            <td class="disabled-field"><?php echo date('d/m/Y', strtotime($row['merma_fecha'])); ?></td>
                            <td class="disabled-field"><?php echo $row['item_code']; ?></td>
                            <td class="disabled-field"><?php echo $row['item_name']; ?></td>
                            <td class="disabled-field"><?php echo $row['merma_lote']; ?></td>
                            <td class="disabled-field"><?php echo date('d/m/Y', strtotime($row['merma_caducidad'])); ?></td>
                            <td class="disabled-field"><?php echo $row['merma_qty']; ?></td>
                            <td class="disabled-field"><?php echo $row['merma_motivo']; ?></td>
                            <td class="disabled-field"><?php echo $row['nombre_ubicacion']; ?></td>
                            <td class="disabled-field"><?php echo $row['id_usua']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No se encontraron registros.</p>
            <?php endif; ?>
            </div>
</body>

</html>

<style>
    .container {
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        max-width: 1050px;
        margin: 15px auto;
        overflow-x: auto;
    }
</style>