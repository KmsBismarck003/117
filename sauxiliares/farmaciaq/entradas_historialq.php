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

    // Consulta para obtener los datos de la tabla `entradas_almacenh` con JOIN y filtro de fechas
    $resultado = $conexion->query("
        SELECT 
            e.entrada_id, 
            e.entrada_fecha, 
           
            i.item_name, 
            e.entrada_lote, 
            e.entrada_caducidad, 
            e.entrada_qty, 
            e.entrada_unidosis, 
            e.entrada_costo, 
            
          
            e.id_usua, 
            u.nombre_ubicacion 
        FROM 
            entradas_almacenh e
        JOIN 
            item_almacen i ON e.item_id = i.item_id
        JOIN 
            ubicaciones_almacen u ON e.ubicacion_id = u.ubicacion_id
        WHERE 
            e.entrada_fecha >= '$inicial' AND e.entrada_fecha <= '$final'
    ") or die($conexion->error);
} else {
    // Consulta sin filtro de fechas si no se han enviado las fechas
    $resultado = $conexion->query("
        SELECT 
            e.entrada_id, 
            e.entrada_fecha, 
            i.item_name, 
            e.entrada_lote, 
            e.entrada_caducidad, 
            e.entrada_qty, 
            e.entrada_unidosis, 
            e.entrada_costo, 
        
            e.id_usua, 
            u.nombre_ubicacion 
        FROM 
            entradas_almacenh e
        JOIN 
            item_almacen i ON e.item_id = i.item_id
        JOIN 
            ubicaciones_almacen u ON e.ubicacion_id = u.ubicacion_id
    ") or die($conexion->error);
}






?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Entradas</title>
</head>

<body>
    <a href='kardexh.php' style='color: white;  margin-left: 20px; background-color: #d9534f; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer;'>Regresar</a>

    <div class="container">
        <h2 style="margin-top: 50px;">Registro de Entradas</h2>

        <!-- Formulario de filtro de fechas -->
        <form method="POST" action="">
            <div class="row">
                <div class="col-sm-2">
                    <label>Fecha Inicial:</label>
                    <input type="date" class="form-control" name="inicial" required>
                </div>
                <div class="col-sm-2">
                    <label>Fecha Final:</label>
                    <input type="date" class="form-control" name="final" required>
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success">Filtrar</button>
                </div>
            </div>
        </form>

        <?php if ($resultado->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID Entrada</th>
                    <th>Fecha</th>
                    
                    <th>Nombre Item</th>
                    <th>Lote</th>
                    <th>Caducidad</th>
                    <th>Cantidad</th>
                    <th>Unidosis</th>
                    <th>Costo</th>
                    
                    
                    <th>ID Usuario</th>
                    <th>Nombre Ubicación</th>
                </tr>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td class="disabled-field"><?php echo $row['entrada_id']; ?></td>
                        <td class="disabled-field"><?php echo date('d/m/Y', strtotime($row['entrada_fecha'])); ?></td>
                       
                        <td class="disabled-field"><?php echo $row['item_name']; ?></td>
                        <td class="disabled-field"><?php echo $row['entrada_lote']; ?></td>
                        <td class="disabled-field"><?php echo date('d/m/Y', strtotime($row['entrada_caducidad'])); ?></td>
                        <td class="disabled-field"><?php echo $row['entrada_qty']; ?></td>
                        <td class="disabled-field"><?php echo $row['entrada_unidosis']; ?></td>
                        <td class="disabled-field"><?php echo number_format($row['entrada_costo'], 2); ?></td>

                        <td class="disabled-field"><?php echo $row['id_usua']; ?></td>
                        <td class="disabled-field"><?php echo $row['nombre_ubicacion']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No se encontraron registros en el rango de fechas especificado.</p>
        <?php endif; ?>
    </div>
</body>

</html>



<style>
    body {
        font-family: Arial, sans-serif;
        /* Fuente general */
        background-color: #f9f9f9;
        /* Fondo general */
    }

    .container {
        background-color: white;
        /* Fondo blanco del contenedor */
        padding: 20px;
        /* Espaciado interno */
        border-radius: 8px;
        /* Bordes redondeados */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* Sombra suave */
        max-width: 1200px;
        /* Ancho máximo */
        margin: 20px auto;
        /* Centrado y margen superior/inferior */
        overflow-x: auto;
        /* Habilita el desplazamiento horizontal */


    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #0c675e;
        /* Color del encabezado */
        color: white;
        /* Color del texto en el encabezado */
    }

    tr:hover {
        background-color: #f1f1f1;
        /* Color al pasar el mouse */
    }

    .disabled-field {
        background-color: #f5f5f5;
        /* Color de fondo para campos deshabilitados */
        color: #1f1e1e;
        /* Color de texto para campos deshabilitados */
    }
</style>