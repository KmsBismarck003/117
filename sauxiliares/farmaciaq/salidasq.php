<?php
session_start();
include "../../conexionbd.php";

// Configuración de paginación
$filasPorPagina = 15; // Número de filas por página
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Página actual
$inicio = ($paginaActual > 1) ? ($paginaActual * $filasPorPagina) - $filasPorPagina : 0;

// Obtener el término de búsqueda
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Contar el total de filas con el filtro de búsqueda
$totalFilasQuery = $conexion->query("SELECT COUNT(*) as total FROM dat_ingreso 
    INNER JOIN paciente ON dat_ingreso.Id_exp = paciente.Id_exp
    WHERE paciente.nom_pac LIKE '%$searchTerm%' OR paciente.papell LIKE '%$searchTerm%' OR paciente.sapell LIKE '%$searchTerm%'");
$totalFilas = $totalFilasQuery->fetch_assoc()['total'];

// Calcular el número total de páginas
$totalPaginas = ceil($totalFilas / $filasPorPagina);

// Calcular el rango de páginas para mostrar de a 5 páginas
$inicioRango = max(1, $paginaActual - 2);
$finRango = min($totalPaginas, $paginaActual + 2);

// Si el total de páginas es menor a 5, mostramos todas
if ($totalPaginas < 5) {
    $inicioRango = 1;
    $finRango = $totalPaginas;
}

// Consulta con filtro de búsqueda y límite para paginación
$query = "SELECT DISTINCT s.id_atencion=di.id_atencion, di.*, p.*
    FROM salidas_almacenq s
    INNER JOIN dat_ingreso di ON s.id_atencion = di.id_atencion
    INNER JOIN paciente p ON di.Id_exp = p.Id_exp
    WHERE p.nom_pac LIKE '%$searchTerm%' OR p.papell LIKE '%$searchTerm%' OR p.sapell LIKE '%$searchTerm%'
    ORDER BY di.id_atencion DESC
    LIMIT $inicio, $filasPorPagina";

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
    <title>Paginación y Búsqueda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<section class="content container-fluid">
    <div class="container box">
        <div class="content">
            <br>
            <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                <strong><center>SALIDAS DE MEDICAMENTO DE FARMACIA</center></strong>
            </div><br>

            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                       placeholder="Buscar...">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="mytable">
                    <thead class="thead" style="background-color: #0c675e; color:white;">
                    <tr>
                        <th>EXPEDIENTE</th>
                        <th>PACIENTE</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <a type="submit" class=" center btn btn-danger btn-sm"href="select_fecha_vista.php?id_atencion=<?php echo $row['id_atencion']; ?>">
                                    <?php echo $row['Id_exp']; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell']; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($paginaActual > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $paginaActual - 1; ?>&search=<?php echo urlencode($searchTerm); ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $inicioRango; $i <= $finRango; $i++): ?>
                        <li class="page-item <?php echo ($paginaActual == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>&search=<?php echo urlencode($searchTerm); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($paginaActual < $totalPaginas): ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $paginaActual + 1; ?>&search=<?php echo urlencode($searchTerm); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>

<footer class="main-footer">
    <?php include("../../template/footer.php"); ?>
</footer>

<script>
    $(document).ready(function () {
        $("#search").keyup(function () {
            var searchTerm = $(this).val().toLowerCase();
            window.location.href = "?pagina=1&search=" + encodeURIComponent(searchTerm);
        });
    });
</script>

</body>
</html>
