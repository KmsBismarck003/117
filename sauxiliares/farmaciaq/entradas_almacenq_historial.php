<?php
session_start();
include "../../conexionbd.php";

ob_start();

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

// Incluir header de farmaciaq para mantener la misma apariencia que kardexq
if (isset($usuario['id_rol'])) {
    if ($usuario['id_rol'] == 7 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
        include "../header_farmaciaq.php";
    } else {
        session_unset();
        session_destroy();
        echo "<script>window.location='../../index.php';</script>";
        exit();
    }
}

// Inicializar variables del formulario
$inicial = isset($_POST['inicial']) ? $_POST['inicial'] : (isset($_GET['inicial']) ? $_GET['inicial'] : '');
$final = isset($_POST['final']) ? $_POST['final'] : (isset($_GET['final']) ? $_GET['final'] : '');
$item_id = isset($_POST['item_id']) ? $_POST['item_id'] : (isset($_GET['item_id']) ? $_GET['item_id'] : '');
$ubicacion_id = isset($_POST['ubicacion_id']) ? $_POST['ubicacion_id'] : (isset($_GET['ubicacion_id']) ? $_GET['ubicacion_id'] : '');
$lote = isset($_POST['lote']) ? $_POST['lote'] : (isset($_GET['lote']) ? $_GET['lote'] : '');

$where = "";
$condiciones = [];

if (!empty($inicial) && !empty($final)) {
    $inicial_sql = mysqli_real_escape_string($conexion, $inicial);
    $final_sql = mysqli_real_escape_string($conexion, $final);
    $final_sql = date("Y-m-d H:i:s", strtotime($final_sql . " + 1 day"));
    $condiciones[] = "e.entrada_fecha >= '$inicial_sql' AND e.entrada_fecha <= '$final_sql'";
}

if (!empty($item_id)) {
    $item_id_sql = intval($item_id);
    $condiciones[] = "e.item_id = $item_id_sql";
}

if (!empty($lote)) {
    $lote_sql = mysqli_real_escape_string($conexion, $lote);
    $condiciones[] = "e.entrada_lote LIKE '%$lote_sql%'";
}

if (!empty($condiciones)) {
    $where = "WHERE " . implode(" AND ", $condiciones);
}

// Paginación
$registros_por_pagina = 20;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) {
    $pagina = 1;  // Asegura que la página no sea menor que 1
}

// Calcular el número total de registros
$query_total = "
    SELECT COUNT(*) AS total 
    FROM entradas_almacenq e
    JOIN item_almacen i ON e.item_id = i.item_id
    JOIN ubicaciones_almacen u ON e.ubicacion_id = u.ubicacion_id
    $where
";
$resultado_total = $conexion->query($query_total);
$total_registros = $resultado_total->fetch_assoc()['total'];

// Calcular el total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Asegurar que la página esté dentro del rango
if ($pagina > $total_paginas) {
    $pagina = $total_paginas;
}

// Calcular el desplazamiento (OFFSET)
$offset = ($pagina - 1) * $registros_por_pagina;
if ($offset < 0) {
    $offset = 0;  // Asegura que el offset nunca sea negativo
}

// Consulta con LIMIT y OFFSET para obtener los registros paginados
$query = "
    SELECT 
        e.entrada_id, 
        e.entrada_fecha, 
        i.item_id,
        i.item_name,
        i.item_grams,
        e.entrada_lote, 
        e.entrada_caducidad, 
        e.entrada_qty, 
        e.entrada_unidosis, 
        i.item_costs AS entrada_costo,
        e.id_usua, 
        u.nombre_ubicacion 
    FROM 
        entradas_almacenq e
    JOIN 
        item_almacen i ON e.item_id = i.item_id
    JOIN 
        ubicaciones_almacen u ON e.ubicacion_id = u.ubicacion_id
    $where
    ORDER BY 
        e.entrada_fecha DESC
    LIMIT $registros_por_pagina OFFSET $offset
";

$resultado = $conexion->query($query) or die($conexion->error);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entradas</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Copiado estilos principales de kardexq para unificar apariencia -->
    <style>
        :root {
            --primary-color: #2b2d7f;
            --primary-dark: #1f2166;
            --primary-light: #3f418a;
        }

        .btn-custom {
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin: 5px;
        }

        .btn-danger-custom {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border: none;
            color: white;
        }

        .btn-success-custom {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            border: none;
            color: white;
        }

        .btn-warning-custom {
            background: linear-gradient(45deg, #ffc107, #e0a800);
            border: none;
            color: #212529;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(43, 45, 127, 0.3);
            text-align: center;
        }

        .table-responsive {
            max-height: 80vh;
            overflow-x: auto;
            overflow-y: auto;
            width: 100%;
        }

        .container.box {
            max-width: 98%;
            width: 98%;
            margin: 0 auto;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .table {
            font-size: 12px;
            min-width: 100%;
        }

        .table th,
        .table td {
            padding: 4px 6px;
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .pagination a {
            padding: 8px 12px;
            text-decoration: none;
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 5px;
            margin: 0 5px;
        }

        .pagination a:hover {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-color));
        }

        .pagination .current {
            background: linear-gradient(45deg, #ffc107, #e0a800);
            color: #212529;
            font-weight: bold;
        }

        /* Estilos de formulario y controles (coinciden con kardexq) */
        .form-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
            height: calc(1.5em + 1rem + 2px);
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(43, 45, 127, 0.25);
            border-color: var(--primary-light);
            outline: none;
        }

        .label-custom {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .btn-group-form {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(43, 45, 127, 0.3);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #545b62);
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            background: linear-gradient(45deg, #545b62, #495057);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
            color: white;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>


<div class="container-fluid">
    <div class="container-main">
        <div class="page-header">
            <h1><i class="fas fa-sync-alt"></i> RESURTIMIENTO</h1>
            </h1>
        </div>

        <!-- Botón superior con mismo margen arriba y abajo -->
        <div class="d-flex justify-content-end" style="margin: 20px 0;">
            <div class="d-flex">
                <!-- Botón Regresar -->
                <a href="kardexq.php"
                    style="color: white; background: linear-gradient(135deg, #2b2d7f 0%, #1a1c5a 100%);
            border: none; border-radius: 8px; padding: 10px 16px; cursor: pointer; display: inline-block; 
            text-decoration: none; box-shadow: 0 2px 8px rgba(43, 45, 127, 0.3); 
            transition: all 0.3s ease; margin-right: 10px;">
                    ← Regresar
                </a>
            </div>
        </div>



        <!-- Formulario de filtros -->
        <div class="form-container">
            <form method="POST" action="">
                <div class="row align-items-end">
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <label class="label-custom"><i class="fas fa-calendar-alt"></i> Fecha Inicial:</label>
                        <input type="date" class="form-control" name="inicial" value="<?= $fecha_inicial ?>">
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <label class="label-custom"><i class="fas fa-calendar-check"></i> Fecha Final:</label>
                        <input type="date" class="form-control" name="final" value="<?= $fecha_final ?>">
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <label class="label-custom"><i class="fas fa-pills"></i> Medicamento/Insumo:</label>
                        <select name="item_id" class="form-control" id="mibuscador">
                            <option value="">Seleccione un medicamento o insumo</option>
                            <?php
                            $sql = "SELECT * FROM item_almacen ORDER BY item_name";
                            $result = $conexion->query($sql);
                            while ($row_datos = $result->fetch_assoc()) {
                                $selected = ($item_id == $row_datos['item_id']) ? 'selected' : '';
                                echo "<option value='" . $row_datos['item_id'] . "' $selected>" . $row_datos['item_name'] . ', ' . $row_datos['item_grams'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <label class="label-custom"><i class="fas fa-tag"></i> Lote:</label>
                        <input type="text" class="form-control" name="lote" placeholder="Número de lote..." value="<?= $lote ?>">
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12">
                        <div class="btn-group-form">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="entradas_almacenq_historial.php" class="btn btn-secondary">
                                <i class="fas fa-eraser"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <br><br>

        <?php if ($resultado->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead" style="background-color: #0c675e; color:white;">
                        <tr>
                            <th>FECHA</th>
                            <th>ITEMID</th>
                            <th>MEDICAMENTO</th>
                            <th>LOTE</th>
                            <th>CADUCIDAD</th>
                            <th>CANTIDAD</th>
                            <th>COSTO</th>
                            <th>IDUSUARIO</th>
                            <th>UBICACIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($row['entrada_fecha'])); ?></td>
                                <td><?= $row['item_id']; ?></td>
                                <td><?= $row['item_name'] . ', ' . $row['item_grams']; ?></td>
                                <td><?= $row['entrada_lote']; ?></td>
                                <td><?= date('d/m/Y', strtotime($row['entrada_caducidad'])); ?></td>
                                <td><?= $row['entrada_unidosis']; ?></td>
                                <td><?= number_format($row['entrada_costo'], 2); ?></td>
                                <td><?= $row['id_usua']; ?></td>
                                <td><?= $row['nombre_ubicacion']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No se encontraron registros con los filtros aplicados.</p>
        <?php endif; ?>

        <!-- Paginación -->
        <div class="pagination">
            <?php
            // Crear parámetros para mantener los filtros
            $params = [];
            if (!empty($inicial)) $params[] = "inicial=" . urlencode($inicial);
            if (!empty($final)) $params[] = "final=" . urlencode($final);
            if (!empty($item_id)) $params[] = "item_id=" . urlencode($item_id);
            if (!empty($lote)) $params[] = "lote=" . urlencode($lote);
            $query_params = !empty($params) ? "&" . implode("&", $params) : "";

            // Mostrar enlaces para la primera, anteriores, página actual, posteriores y última página
            if ($pagina > 1) {
                echo "<a href='?pagina=1$query_params'>&laquo; Primera</a>";
            }

            // Mostrar páginas cercanas a la actual
            $pagina_inicio = max(1, $pagina - 5);
            $pagina_fin = min($total_paginas, $pagina + 5);

            for ($i = $pagina_inicio; $i < $pagina; $i++) {
                echo "<a href='?pagina=$i$query_params'>$i</a>";
            }

            // Página actual
            echo "<a href='?pagina=$pagina$query_params' class='current'>$pagina</a>";

            for ($i = $pagina + 1; $i <= $pagina_fin; $i++) {
                echo "<a href='?pagina=$i$query_params'>$i</a>";
            }

            if ($pagina < $total_paginas) {
                echo "<a href='?pagina=$total_paginas$query_params'>Última &raquo;</a>";
            }
            ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#mibuscador').select2({
                        placeholder: "🔍 Seleccione un medicamento...",
                        allowClear: true,
                        width: '100%'
                    });
        });
    </script>
    </body>

</html>