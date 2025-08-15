<?php
session_start();
include "../../conexionbd.php";

// Configuración de paginación
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

// Obtener filtros
$fecha_filter = isset($_GET['fecha_filter']) ? $_GET['fecha_filter'] : '';
$id_atencion = isset($_GET['id_atencion']) ? (int)$_GET['id_atencion'] : 0;

$resultado = $conexion->query("SELECT paciente.*, dat_ingreso.id_atencion, triage.id_triage
FROM paciente 
INNER JOIN dat_ingreso ON paciente.Id_exp=dat_ingreso.Id_exp
INNER JOIN triage ON dat_ingreso.id_atencion=triage.id_atencion WHERE id_triage=id_triage
") or die($conexion->error);

// Verifica el rol del usuario para incluir la cabecera adecuada
$usuario = $_SESSION['login'];

if ($usuario['id_rol'] == 7) {
    include "../header_farmaciaq.php";
} elseif ($usuario['id_rol'] == 3) {
    include "../../enfermera/header_enfermera.php";
} elseif ($usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
    include "../header_farmaciaq.php";
} else {
    echo "<script>window.Location='../../index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Fecha - Farmacia Quirófano</title>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #2b2d7f;
            --primary-dark: #1e1f5a;
            --primary-light: #4a4db8;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 20px 0;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 8px 32px rgba(43, 45, 127, 0.3);
            text-align: center;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2.2rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .page-header p {
            margin: 10px 0 0 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .search-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            border-radius: 25px;
            border: 2px solid #e9ecef;
            padding: 12px 20px 12px 45px;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .search-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(43, 45, 127, 0.25);
            border-color: var(--primary-light);
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 18px;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .table-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 20px;
            margin: 0;
        }

        .table-header h5 {
            margin: 0;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 18px 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-size: 14px;
            position: sticky;
            top: 0;
            z-index: 10;
            text-align: center;
            white-space: nowrap;
        }

        .table thead th i {
            margin-right: 8px;
            font-size: 16px;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border: none;
        }

        .table tbody tr:hover {
            background-color: rgba(43, 45, 127, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table tbody td {
            padding: 16px 15px;
            vertical-align: middle;
            font-size: 15px;
            font-weight: 500;
            border: none;
            text-align: center;
            line-height: 1.4;
        }

        .table tbody td:first-child {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 16px;
        }

        .table tbody td:nth-child(2) {
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            max-width: 300px;
            word-wrap: break-word;
        }

        .btn-fecha {
            background: linear-gradient(45deg, var(--danger-color), #c82333);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-fecha:hover {
            background: linear-gradient(45deg, #c82333, #bd2130);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
            color: white;
            text-decoration: none;
        }

        .patient-info {
            background: linear-gradient(45deg, #e3f2fd, #bbdefb);
            border: none;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            color: var(--primary-dark);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .patient-info h4 {
            margin: 0;
            font-weight: 700;
            color: var(--primary-color);
        }

        .container-main {
            max-width: 95%;
            margin: 0 auto;
        }

        .back-button {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(43, 45, 127, 0.3);
        }

        .back-button:hover {
            background: linear-gradient(45deg, var(--primary-dark), #1a1c5a);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(43, 45, 127, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Ocultar elementos no deseados del sidebar y resolver conflictos de iconos */
        .sidebar .sidebar-menu li.header {
            display: none !important;
        }

        .sidebar .sidebar-search {
            display: none !important;
        }

        /* Asegurar que no haya iconos de búsqueda flotando */
        .sidebar .fa-search,
        .sidebar .fas.fa-search,
        .main-sidebar .fa-search,
        .main-sidebar .fas.fa-search {
            display: none !important;
        }

        /* Ocultar cualquier elemento con clase search en el sidebar */
        .sidebar *[class*="search"],
        .main-sidebar *[class*="search"] {
            display: none !important;
        }

        /* Ocultar iconos de lupa específicamente */
        .sidebar i.fa-search,
        .sidebar i.fas.fa-search,
        .main-sidebar i.fa-search,
        .main-sidebar i.fas.fa-search {
            display: none !important;
            visibility: hidden !important;
        }

        /* Resolver conflictos de Font Awesome */
        .search-icon {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
        }

        /* Asegurar que los iconos del contenido principal usen FA6 */
        .content-wrapper .fas {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
        }

        /* Limpiar completamente el sidebar de elementos de búsqueda */
        .main-sidebar::before,
        .main-sidebar::after,
        .sidebar::before,
        .sidebar::after {
            content: none !important;
        }

        /* Ocultar cualquier pseudo-elemento que pueda mostrar iconos */
        .sidebar-menu li::before,
        .sidebar-menu li::after,
        .sidebar-menu a::before,
        .sidebar-menu a::after {
            display: none !important;
        }

        /* Asegurar que solo los iconos permitidos sean visibles en el sidebar */
        .sidebar .fa-folder,
        .sidebar .fa-angle-left {
            display: inline-block !important;
        }

        .no-data-message {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .no-data-message h4 {
            color: #495057;
            margin-bottom: 15px;
        }

        .no-data-message p {
            color: #6c757d;
            margin-bottom: 0;
        }

        /* Estilos para las tablas de salidas expandibles */
        .salidas-detail {
            background-color: #f8f9fa !important;
        }

        .salidas-container {
            padding: 15px;
            background: white;
            border-radius: 8px;
            margin: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .salidas-table {
            margin-bottom: 0;
            font-size: 0.85rem;
        }

        .salidas-header th {
            background: linear-gradient(135deg, #0c675e 0%, #0a5249 100%) !important;
            color: white !important;
            font-size: 0.8rem;
            padding: 8px 6px;
            text-align: center;
            border: 1px solid #dee2e6;
        }

        .salidas-table td {
            padding: 6px 8px;
            font-size: 0.8rem;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .salidas-table .total-row {
            background-color: #e9ecef !important;
            font-weight: bold;
        }

        .btn-fecha {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
            justify-content: center;
        }

        .btn-fecha:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(43, 45, 127, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-fecha i.fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .btn-fecha.expanded i.fa-chevron-down {
            transform: rotate(180deg);
        }

        /* Responsive para las tablas de salidas */
        @media (max-width: 1200px) {
            .salidas-table {
                font-size: 0.75rem;
            }

            .salidas-header th,
            .salidas-table td {
                padding: 4px 6px;
            }
        }

        @media (max-width: 768px) {
            .salidas-container {
                padding: 8px;
                margin: 5px;
                overflow-x: auto;
            }

            .salidas-table {
                font-size: 0.7rem;
                min-width: 800px;
            }

            .salidas-header th,
            .salidas-table td {
                padding: 3px 4px;
                white-space: nowrap;
            }
        }

        /* Estilos para el filtro de fecha */
        .date-filter-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .date-filter-container h4 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .filter-form {
            display: flex;
            gap: 15px;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .filter-input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .filter-input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(43, 45, 127, 0.1);
        }

        .filter-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            height: fit-content;
        }

        .filter-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(43, 45, 127, 0.3);
        }

        .clear-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            height: fit-content;
        }

        .clear-btn:hover {
            background: #545b62;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Estilos para el paginador - Igual a existencias_almacenq */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            width: 100%;
        }

        .pagination a {
            padding: 8px 12px;
            text-decoration: none;
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 8px;
            margin: 0 5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .pagination a:hover {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(43, 45, 127, 0.3);
            color: white;
            text-decoration: none;
        }

        .pagination .current {
            background: linear-gradient(45deg, #ffc107, #e0a800);
            color: #212529;
            font-weight: bold;
        }

        .pagination-info {
            text-align: center;
            margin: 15px 0;
            color: #6c757d;
            font-size: 14px;
        }

        /* Responsive para filtros y paginación */
        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                min-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="container-main">
            <!-- Encabezado de la página -->
            <div class="page-header">
                <h1><i class="fas fa-calendar-alt"></i> SELECCIONAR FECHA DE SALIDAS</h1>
                <p>Fechas disponibles de salidas de medicamentos desde farmacia quirófano</p>
            </div>

            <div class="d-flex justify-content-start" style="margin: 20px 0; margin-left: 4px;">
                <div class="d-flex">
                    <!-- Botón Regresar -->
                    <a href="salidasq.php" class="back-button">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
            </div>

            <?php
            $id_atencion = $_GET['id_atencion'];
            $resultado1 = $conexion->query("SELECT * from dat_ingreso di, paciente p where di.id_atencion=$id_atencion and di.Id_exp=p.Id_exp") or die($conexion->error);

            // Inicializar variables
            $paciente = "No encontrado";
            $expediente = "N/A";

            if ($row_pac = $resultado1->fetch_assoc()) {
                $paciente = $row_pac['nom_pac'] . " " . $row_pac['papell'] . " " . $row_pac['sapell'];
                $expediente = $row_pac['Id_exp'];
            }
            ?>

            <!-- Información del paciente -->
            <div class="patient-info">
                <h4><i class="fas fa-user-circle"></i> PACIENTE: <?php echo $paciente; ?></h4>
                <p><strong>Expediente:</strong> <?php echo $expediente; ?> | <strong>ID Atención:</strong> <?php echo $id_atencion; ?></p>
            </div>

            <!-- Filtro de fecha -->
            <div class="date-filter-container">
                <h4><i class="fas fa-filter"></i> Filtrar por Fecha</h4>
                <form method="GET" class="filter-form">
                    <input type="hidden" name="id_atencion" value="<?php echo $id_atencion; ?>">

                    <div class="filter-group">
                        <label for="fecha_filter">
                            <i class="fas fa-calendar-alt"></i> Buscar por Fecha
                        </label>
                        <input type="date"
                            id="fecha_filter"
                            name="fecha_filter"
                            class="filter-input"
                            value="<?php echo htmlspecialchars($fecha_filter); ?>"
                            placeholder="Seleccionar fecha">
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="filter-btn">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <a href="?id_atencion=<?php echo $id_atencion; ?>" class="clear-btn">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>


            <!-- Tabla de fechas -->
            <div class="table-container">
                <div class="table-header">
                    <h5><i class="fas fa-calendar-check"></i> Fechas con Salidas de Medicamentos</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="mytable">
                        <thead>
                            <tr>
                                <th width="100%"><i class="fas fa-calendar-day"></i> FECHA SOLICITUD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Construir la cláusula WHERE para el filtro
                            $whereClause = "WHERE s.id_atencion = $id_atencion";
                            if (!empty($fecha_filter)) {
                                $whereClause .= " AND DATE(s.salida_fecha) = '" . $conexion->real_escape_string($fecha_filter) . "'";
                            }

                            // Consulta para contar el total de fechas
                            $query_count = "SELECT COUNT(DISTINCT DATE(s.salida_fecha)) as total 
                                           FROM salidas_almacenq s 
                                           $whereClause";
                            $result_count = $conexion->query($query_count);
                            $total_records = $result_count->fetch_assoc()['total'];
                            $total_pages = ceil($total_records / $records_per_page);

                            // Consulta principal con paginación
                            $query_fechas = "SELECT DISTINCT DATE(s.salida_fecha) AS salida_fecha 
                                            FROM salidas_almacenq s 
                                            $whereClause
                                            ORDER BY s.salida_fecha DESC
                                            LIMIT $start_from, $records_per_page";

                            $resultado2 = $conexion->query($query_fechas) or die($conexion->error);

                            if ($resultado2->num_rows > 0) {
                                while ($row = $resultado2->fetch_assoc()) {
                                    $fecha_salida = $row['salida_fecha'];
                                    echo '<tr>';
                                    echo '<td class="text-center">';
                                    echo '<button class="btn-fecha" onclick="toggleSalidas(\'' . $fecha_salida . '\')" 
                                           title="Ver/Ocultar salidas del ' . $fecha_salida . '">';
                                    echo '<i class="fas fa-calendar-alt"></i> ' . date('d/m/Y', strtotime($fecha_salida));
                                    echo ' <i class="fas fa-chevron-down" id="icon-' . $fecha_salida . '"></i>';
                                    echo '</button>';
                                    echo '</td>';
                                    echo '</tr>';

                                    // Fila oculta con los detalles de salidas
                                    echo '<tr id="salidas-' . $fecha_salida . '" class="salidas-detail" style="display: none;">';
                                    echo '<td colspan="1">';
                                    echo '<div class="salidas-container">';

                                    // Consulta para obtener todas las salidas de esta fecha
                                    $resultado_salidas = $conexion->query("
                                        SELECT 
                                            s.salida_id,
                                            s.item_id,
                                            s.item_name,
                                            s.salida_fecha,
                                            s.salida_lote,
                                            s.salida_caducidad,
                                            s.salida_qty,
                                            s.salida_costsu,
                                            s.id_usua,
                                            s.id_atencion,
                                            s.solicita,
                                            s.fecha_solicitud,
                                            di.Id_exp,
                                            p.nom_pac,
                                            p.papell,
                                            p.sapell,
                                            u.nombre as usuario_nombre,
                                            u.papell as usuario_apellido1,
                                            u.sapell as usuario_apellido2
                                        FROM salidas_almacenq s 
                                        INNER JOIN dat_ingreso di ON s.id_atencion = di.id_atencion 
                                        INNER JOIN paciente p ON di.Id_exp = p.Id_exp 
                                        LEFT JOIN reg_usuarios u ON s.id_usua = u.id_usua
                                        WHERE s.id_atencion = $id_atencion 
                                        AND DATE(s.salida_fecha) = '$fecha_salida' 
                                        ORDER BY s.id_atencion, s.salida_fecha DESC, s.salida_id DESC
                                    ");

                                    if ($resultado_salidas && $resultado_salidas->num_rows > 0) {
                                        echo '<table class="table table-sm table-bordered salidas-table">';
                                        echo '<thead class="salidas-header">';
                                        echo '<tr>';
                                        echo '<th>ID Item</th>';
                                        echo '<th>Medicamento</th>';
                                        echo '<th>Fecha Salida</th>';
                                        echo '<th>Lote</th>';
                                        echo '<th>Caducidad</th>';
                                        echo '<th>Cantidad</th>';
                                        echo '<th>Costo</th>';
                                        echo '<th>Usuario</th>';
                                        echo '<th>ID Atención</th>';
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';

                                        $total_fecha = 0;
                                        while ($salida = $resultado_salidas->fetch_assoc()) {
                                            $usuario_completo = $salida['usuario_nombre'] . ' ' . $salida['usuario_apellido1'] . ' ' . $salida['usuario_apellido2'];

                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($salida['item_id']) . '</td>';
                                            echo '<td>' . htmlspecialchars($salida['item_name']) . '</td>';
                                            echo '<td>' . date('d/m/Y H:i', strtotime($salida['salida_fecha'])) . '</td>';
                                            echo '<td>' . htmlspecialchars($salida['salida_lote']) . '</td>';
                                            echo '<td>' . date('d/m/Y', strtotime($salida['salida_caducidad'])) . '</td>';
                                            echo '<td class="text-center">' . htmlspecialchars($salida['salida_qty']) . '</td>';
                                            echo '<td class="text-right">$' . number_format($salida['salida_costsu'], 2) . '</td>';
                                            echo '<td>' . htmlspecialchars($usuario_completo) . '</td>';
                                            echo '<td>' . htmlspecialchars($salida['id_atencion']) . '</td>';
                                            echo '</tr>';

                                            $total_fecha += $salida['salida_costsu'] * $salida['salida_qty'];
                                        }

                                        // Fila de total
                                        echo '<tr class="total-row">';
                                        echo '<td colspan="7" class="text-right"><strong>TOTAL:</strong></td>';
                                        echo '<td class="text-right"><strong>$' . number_format($total_fecha, 2) . '</strong></td>';
                                        echo '<td colspan="4"></td>';
                                        echo '</tr>';

                                        echo '</tbody>';
                                        echo '</table>';
                                    } else {
                                        echo '<p class="text-muted">No hay detalles de salidas disponibles.</p>';
                                    }

                                    echo '</div>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr>';
                                echo '<td>';
                                echo '<div class="no-data-message">';
                                echo '<i class="fas fa-calendar-times fa-3x mb-3" style="color: #6c757d;"></i>';
                                echo '<h4>No se encontraron fechas</h4>';
                                echo '<p>No hay fechas de salidas de medicamentos disponibles para este paciente.</p>';
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Información de paginación -->
                <?php if ($total_records > 0): ?>
                    <div class="pagination-info">
                        Mostrando <?php echo (($page - 1) * $records_per_page + 1); ?> a
                        <?php echo min($page * $records_per_page, $total_records); ?> de
                        <?php echo $total_records; ?> fechas
                    </div>
                <?php endif; ?>

                <!-- Paginación -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php
                        // Construir parámetros para mantener filtros en paginación
                        $filter_params = [];
                        $filter_params[] = "id_atencion=" . $id_atencion;
                        if (!empty($fecha_filter)) {
                            $filter_params[] = "fecha_filter=" . urlencode($fecha_filter);
                        }
                        $filter_string = !empty($filter_params) ? "&" . implode("&", $filter_params) : "";

                        // Establecer el rango de páginas a mostrar
                        $rango = 3;
                        $inicio = max(1, $page - $rango);
                        $fin = min($total_pages, $page + $rango);

                        // Mostrar el enlace a la primera página
                        if ($page > 1) {
                            echo '<a href="?page=1' . $filter_string . '" title="Primera página">&laquo; Primero</a>';
                            echo '<a href="?page=' . ($page - 1) . $filter_string . '" title="Página anterior">&lt; Anterior</a>';
                        }

                        // Mostrar las páginas dentro del rango
                        for ($i = $inicio; $i <= $fin; $i++) {
                            echo '<a href="?page=' . $i . $filter_string . '" class="' . ($i == $page ? 'current' : '') . '" title="Página ' . $i . '">' . $i . '</a>';
                        }

                        // Mostrar el enlace a la siguiente página
                        if ($page < $total_pages) {
                            echo '<a href="?page=' . ($page + 1) . $filter_string . '" title="Página siguiente">Siguiente &gt;</a>';
                            echo '<a href="?page=' . $total_pages . $filter_string . '" title="Última página">Último &raquo;</a>';
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Auto-focus en el campo de fecha
            $("#fecha_filter").focus();

            // Animaciones suaves para los botones
            $('.btn-fecha').hover(
                function() {
                    $(this).find('i.fa-calendar-alt').addClass('fa-bounce');
                },
                function() {
                    $(this).find('i.fa-calendar-alt').removeClass('fa-bounce');
                }
            );
        });

        // Función para expandir/contraer las tablas de salidas
        function toggleSalidas(fecha) {
            const salidasRow = document.getElementById('salidas-' + fecha);
            const icon = document.getElementById('icon-' + fecha);
            const button = icon.closest('.btn-fecha');

            if (salidasRow.style.display === 'none' || salidasRow.style.display === '') {
                // Mostrar con animación
                salidasRow.style.display = 'table-row';
                setTimeout(() => {
                    salidasRow.style.opacity = '1';
                }, 10);

                // Cambiar icono y clase del botón
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
                button.classList.add('expanded');
            } else {
                // Ocultar con animación
                salidasRow.style.opacity = '0';
                setTimeout(() => {
                    salidasRow.style.display = 'none';
                }, 300);

                // Cambiar icono y clase del botón
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
                button.classList.remove('expanded');
            }
        }

        // Agregar estilos de transición dinámicamente
        document.addEventListener('DOMContentLoaded', function() {
            const style = document.createElement('style');
            style.textContent = `
                .salidas-detail {
                    transition: opacity 0.3s ease;
                    opacity: 0;
                }
                .salidas-detail[style*="table-row"] {
                    opacity: 1;
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>

</html>