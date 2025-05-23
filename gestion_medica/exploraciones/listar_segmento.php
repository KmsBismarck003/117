<?php
include 'conexion.php';
include "../../conexionbd.php";
include("../header_medico.php");

$sql = "SELECT * FROM segmento_anterior ORDER BY fecha DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Segmento Anterior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Exploraciones del Segmento Anterior</h2>

    <a href="formulario_segmento.php" class="btn btn-success mb-3">Nueva exploración</a>

    <?php if ($resultado && $resultado->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Párpados OD</th>
                        <th>Párpados OI</th>
                        <th>Conj. Tarsal OD</th>
                        <th>Conj. Tarsal OI</th>
                        <th>Conj. Bulbar OD</th>
                        <th>Conj. Bulbar OI</th>
                        <th>Córnea OD</th>
                        <th>Córnea OI</th>
                        <th>Cámara Ant. OD</th>
                        <th>Cámara Ant. OI</th>
                        <th>Pupila OD</th>
                        <th>Pupila OI</th>
                        <th>Iris OD</th>
                        <th>Iris OI</th>
                        <th>Cristalino OD</th>
                        <th>Cristalino OI</th>
                        <th>LOCS OD</th>
                        <th>LOCS OI</th>
                        <th>Gonioscopía OD</th>
                        <th>Gonioscopía OI</th>
                        <th>Observaciones</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= $fila["id"] ?></td>
                            <td><?= htmlspecialchars($fila["parpados_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["parpados_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["conjuntiva_tarsal_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["conjuntiva_tarsal_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["conjuntiva_bulbar_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["conjuntiva_bulbar_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["cornea_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["cornea_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["camara_anterior_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["camara_anterior_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["pupila_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["pupila_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["iris_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["iris_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["cristalino_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["cristalino_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["locs_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["locs_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["gonioscopia_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["gonioscopia_oi"]) ?></td>
                            <td><?= nl2br(htmlspecialchars($fila["observaciones"])) ?></td>
                            <td><?= $fila["fecha"] ?></td>
                            <td>
                                <a href="editar_segmento.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="eliminar_segmento.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este registro?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">No hay registros encontrados.</div>
    <?php endif; ?>
</div>
</body>
</html>
