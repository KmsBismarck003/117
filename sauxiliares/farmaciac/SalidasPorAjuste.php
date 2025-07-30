<?php
session_start();
include "../../conexionbd.php";
include "../header_farmaciac.php";

$id_usua = $_SESSION['login']['id_usua'];
// Validar conexión antes de ejecutar consultas
if (!$conexion) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Inicializar variables
$total_general = 0;
$filasPorPagina = 15;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual > 1) ? ($paginaActual * $filasPorPagina) - $filasPorPagina : 0;
$searchTerm = isset($_GET['search']) ? trim(htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8')) : '';
$likeSearchTerm = "%" . $searchTerm . "%";

// Obtener lista de medicamentos
$queryMedicamentos = "SELECT item_id, item_name FROM item_almacen";
$resultMedicamentos = $conexion->query($queryMedicamentos);

// Contar total de registros de salida por ajuste
$stmt = $conexion->prepare("
    SELECT COUNT(*) as total 
    FROM salidas_almacen 
    WHERE salida_destino LIKE ?
");
$stmt->bind_param('s', $likeSearchTerm);
$stmt->execute();
$result = $stmt->get_result();
$totalFilas = $result->fetch_assoc()['total'];

// Calcular total de páginas
$totalPaginas = ceil($totalFilas / $filasPorPagina);
$inicioRango = max(1, $paginaActual - 2);
$finRango = min($totalPaginas, $paginaActual + 2);
if ($totalPaginas < 5) {
    $inicioRango = 1;
    $finRango = $totalPaginas;
}

// Consulta para obtener las salidas por ajuste con paginación
$query = "
    SELECT s.salida_id, s.salida_fecha, s.salida_qty, s.salida_destino, s.salida_costsu, 
           i.item_name, i.item_comercial, s.id_usua
    FROM salidas_almacen s
    INNER JOIN item_almacen i ON s.item_id = i.item_id
    WHERE s.salida_destino LIKE ?
    ORDER BY s.salida_fecha DESC
    LIMIT ?, ?
";
$stmt = $conexion->prepare($query);
$stmt->bind_param('sii', $likeSearchTerm, $inicio, $filasPorPagina);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Salidas por Ajuste</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <section class="content container-fluid">
        <div class="container box">
            <div class="content">
                <br>
                <a class="btn btn-danger" href="../../template/menu_farmaciahosp.php">Regresar...</a>
                <div class="thead mt-3 text-white text-center" style="background-color: #0c675e; font-size: 20px;">
                    <strong>SALIDAS POR AJUSTE</strong>
                </div>

                <br>
<!-- FORMULARIO DE REGISTRO DE SALIDA POR AJUSTE -->
<div class="container mt-4 p-3 bg-white border rounded">
    <h5 class="text-dark">Registrar Salida por Ajuste</h5>
    <form action="procesar_salida.php" method="POST">
        <table class="table table-bordered">
            <tr>
                <td><label for="medicamento">Medicamento:</label></td>
                <td>
                    <select name="medicamento" id="medicamento" class="form-control" required>
                        <option value="">Seleccione un medicamento</option>
                        <?php
                        $queryMedicamentos = "
                            SELECT 
                                e.item_id, 
                                i.item_name, 
                                i.item_grams, 
                                e.existe_lote, 
                                e.existe_caducidad, 
                                e.existe_qty
                            FROM existencias_almacen e
                            INNER JOIN item_almacen i ON e.item_id = i.item_id
                            WHERE e.existe_qty > 0
                            ORDER BY i.item_name, e.existe_caducidad ASC
                        ";
                        $resultMedicamentos = $conexion->query($queryMedicamentos);
                        while ($row = $resultMedicamentos->fetch_assoc()):
                            $value = $row['item_id'] . "|" . $row['existe_lote'] . "|" . $row['existe_caducidad'];
                            $label = "{$row['item_name']} ({$row['item_grams']}) - Lote: {$row['existe_lote']} - Vence: {$row['existe_caducidad']} - Stock: {$row['existe_qty']}";
                        ?>
                            <option value="<?= htmlspecialchars($value); ?>"><?= htmlspecialchars($label); ?></option>
                        <?php endwhile; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="motivo">Motivo:</label></td>
                <td>
                    <select name="motivo" id="motivo" class="form-control" required>
                        <option value="Caducidad">Caducidad</option>
                        <option value="Ajuste de Inventario">Ajuste de Inventario</option>
                        <option value="Consumo Interno">Consumo Interno</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="cantidad">Cantidad:</label></td>
                <td><input type="number" name="cantidad" id="cantidad" class="form-control" required min="1"></td>
            </tr>
        </table>
        <button type="submit" class="btn btn-success mt-2">Registrar Ajuste</button>
    </form>
</div>


                <br>

                <!-- Tabla de Ajuste de Medicamentos -->
                <div class="container mt-4 p-3 bg-white border rounded">
                    <h5 class="text-dark">AJUSTE DE MEDICAMENTOS</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Total</th>
                                    <th>Solicitante</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <?php $total_general += ($row['salida_qty'] * $row['salida_costsu']); ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['item_name']); ?></td>
                                        <td><?= intval($row['salida_qty']); ?></td>
                                        <td>$<?= number_format($row['salida_costsu'], 2); ?></td>
                                        <td>$<?= number_format($row['salida_qty'] * $row['salida_costsu'], 2); ?></td>
                                        <td><?= htmlspecialchars($row['id_usua']); ?></td>
                                        <td><?= htmlspecialchars($row['salida_destino']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right font-weight-bold">
                        Total General: <input type="text" class="form-control d-inline-block" style="width: 150px;" readonly value="$<?= number_format($total_general, 2); ?>">
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
