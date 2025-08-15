<?php
session_start();
include "../../conexionbd.php";

// Configuración de paginación
$records_per_page = 20; // Número de filas por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
$start_from = ($page - 1) * $records_per_page;

// Obtener el término de búsqueda
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Contar el total de filas con el filtro de búsqueda
$totalFilasQuery = $conexion->query("SELECT COUNT(*) as total FROM dat_ingreso 
    INNER JOIN paciente ON dat_ingreso.Id_exp = paciente.Id_exp
    WHERE paciente.nom_pac LIKE '%$searchTerm%' OR paciente.papell LIKE '%$searchTerm%' OR paciente.sapell LIKE '%$searchTerm%'");
$total_records = $totalFilasQuery->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_pages = ceil($total_records / $records_per_page);

// Consulta con filtro de búsqueda y límite para paginación
$query = "SELECT DISTINCT s.id_atencion=di.id_atencion, di.*, p.*
    FROM salidas_almacenq s
    INNER JOIN dat_ingreso di ON s.id_atencion = di.id_atencion
    INNER JOIN paciente p ON di.Id_exp = p.Id_exp
    WHERE p.nom_pac LIKE '%$searchTerm%' OR p.papell LIKE '%$searchTerm%' OR p.sapell LIKE '%$searchTerm%'
    ORDER BY di.id_atencion DESC
    LIMIT $start_from, $records_per_page";

$result = $conexion->query($query) or die($conexion->error);

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
    <title>Salidas de Medicamentos - Farmacia Quirófano</title>
    
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
            box-shadow: 0 8px 32px rgba(43,45,127,0.3);
            text-align: center;
        }
        
        .page-header h1 {
            margin: 0;
            font-size: 2.2rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
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
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .search-input {
            border-radius: 25px;
            border: 2px solid #e9ecef;
            padding: 12px 20px 12px 45px;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .search-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(43,45,127,0.25);
            border-color: var(--primary-light);
        }

        /* Estilos para el formulario de búsqueda */
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

        .filter-input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 16px;
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
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            height: fit-content;
            margin-right: 10px;
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
            padding: 12px 20px;
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
        
     
        
        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
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
            background-color: rgba(43,45,127,0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
        
        .btn-expediente {
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
            box-shadow: 0 4px 15px rgba(220,53,69,0.3);
        }
        
        .btn-expediente:hover {
            background: linear-gradient(45deg, #c82333, #bd2130);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220,53,69,0.4);
            color: white;
            text-decoration: none;
        }
        
        .patient-name {
            font-weight: 600;
            color: var(--primary-dark);
        }
        
        .stats-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .stat-card h4 {
            font-size: 2rem;
            font-weight: 700;
            margin: 8px 0 5px 0;
            line-height: 1.2;
        }

        .stat-card small {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
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
        
        /* Estilos para el paginador - Igual a select_fecha_vista */
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
        
        
        .page-item.active .page-link {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(43,45,127,0.3);
        }
        
        .no-data-message {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }
        
        .container-main {
            max-width: 95%;
            margin: 0 auto;
        }
        
        .back-button {
            background: linear-gradient(45deg, var(--danger-color), #c82333);
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
            box-shadow: 0 4px 15px rgba(220,53,69,0.3);
        }
        
        .back-button:hover {
            background: linear-gradient(45deg, #c82333, #bd2130);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220,53,69,0.4);
            color: white;
            text-decoration: none;
        }
        
        .search-results-info {
            background: linear-gradient(45deg, #e3f2fd, #bbdefb);
            border: none;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            color: var(--primary-dark);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="container-main">
            <!-- Encabezado de la página -->
            <div class="page-header">
                <h1><i class="fas fa-file-export"></i> SALIDAS DE MEDICAMENTOS</h1>
                <p>Consulta de dispensaciones desde farmacia quirófano</p>
            </div>

           <div class="d-flex justify-content-start" style="margin: 20px 0; margin-left: 4px;">
        <div class="d-flex">
            <!-- Botón Regresar -->
            <a href="../../template/menu_farmaciaq.php"
                style="color: white; background: linear-gradient(135deg, #2b2d7f 0%, #1a1c5a 100%);
            border: none; border-radius: 8px; padding: 10px 16px; cursor: pointer; display: inline-block; 
            text-decoration: none; box-shadow: 0 2px 8px rgba(43, 45, 127, 0.3); 
            transition: all 0.3s ease; margin-right: 10px;">
                ← Regresar
            </a>
        </div>
    </div>

            <!-- Buscador -->
            <div class="search-container">
                <h6><i class="fas fa-search"></i> Búsqueda de Pacientes</h6>
                <form method="GET" class="filter-form">
                    <div class="filter-group">
                        <input type="text" 
                               class="filter-input search-input" 
                               id="search" 
                               name="search"
                               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                               placeholder="Buscar por nombre o apellidos del paciente...">
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="filter-btn">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <a href="salidasq.php" class="clear-btn">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </form>
                <?php if (!empty($searchTerm)): ?>
                <div class="search-results-info mt-3">
                    <i class="fas fa-info-circle"></i> 
                    Mostrando resultados para: "<strong><?php echo htmlspecialchars($searchTerm); ?></strong>" 
                    (<?php echo $total_records; ?> paciente<?php echo $total_records != 1 ? 's' : ''; ?> encontrado<?php echo $total_records != 1 ? 's' : ''; ?>)
                    <a href="salidasq.php" class="float-right text-primary">
                        <i class="fas fa-times"></i> Limpiar búsqueda
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Tabla de pacientes -->
            <div class="table-container">
                <div class="table-header">
                    <h5><i class="fas fa-users"></i> Pacientes con Salidas de Medicamentos</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="mytable">
                        <thead>
                            <tr>
                                <th width="20%"><i class="fas fa-id-card"></i> EXPEDIENTE</th>
                                <th width="80%"><i class="fas fa-user"></i> PACIENTE</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center">
                                        <a href="select_fecha_vista.php?id_atencion=<?php echo $row['id_atencion']; ?>" 
                                           class="btn-expediente"
                                           title="Ver salidas del expediente <?php echo $row['Id_exp']; ?>">
                                            <i class="fas fa-folder-open"></i> <?php echo $row['Id_exp']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="patient-name">
                                            <i class="fas fa-user-circle"></i> 
                                            <?php echo $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">
                                    <div class="no-data-message">
                                        <i class="fas fa-search fa-3x mb-3" style="color: #6c757d;"></i>
                                        <h4>No se encontraron pacientes</h4>
                                        <?php if (!empty($searchTerm)): ?>
                                            <p>No hay pacientes que coincidan con la búsqueda "<strong><?php echo htmlspecialchars($searchTerm); ?></strong>"</p>
                                            <a href="salidasq.php" class="btn btn-primary">
                                                <i class="fas fa-redo"></i> Mostrar todos los pacientes
                                            </a>
                                        <?php else: ?>
                                            <p>No hay registros de salidas de medicamentos disponibles.</p>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Información de paginación -->
            <?php if ($total_records > 0): ?>
            <div class="pagination-info">
                Mostrando <?php echo (($page - 1) * $records_per_page + 1); ?> a 
                <?php echo min($page * $records_per_page, $total_records); ?> de 
                <?php echo $total_records; ?> pacientes
            </div>
            <?php endif; ?>
            
            <!-- Paginación -->
            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php
                // Construir parámetros para mantener filtros en paginación
                $filter_params = [];
                if (!empty($searchTerm)) {
                    $filter_params[] = "search=" . urlencode($searchTerm);
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

   

    <script>
        $(document).ready(function () {
            // Animaciones suaves para los botones
            $('.btn-expediente').hover(
                function() {
                    $(this).find('i').addClass('fa-bounce');
                },
                function() {
                    $(this).find('i').removeClass('fa-bounce');
                }
            );
            
            // Efecto de carga para las páginas
            $('.page-link').click(function(e) {
                if (!$(this).parent().hasClass('active')) {
                    $(this).html('<i class="fas fa-spinner fa-spin"></i>');
                }
            });
            
            // Auto-focus en el campo de búsqueda
            $("#search").focus();
        });
    </script>
</body>
</html>
