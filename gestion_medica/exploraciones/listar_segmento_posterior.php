<?php
include 'conexion.php';
include "../../conexionbd.php";
include("../header_medico.php");

$sql = "SELECT * FROM segmento_post ORDER BY creado_en DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Segmento Posterior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Exploraciones del Segmento Posterior</h2>

    <a href="formulario_segmento_posterior.php" class="btn btn-success mb-3">Nueva exploración</a>

    <?php if ($resultado && $resultado->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Bajo Dilatación</th>
                        <th>Do</th>
                        <th>Dx</th>
                        <th>Total</th>
                        <th>Media</th>
                        <th>No Dilata</th>
                        <th>No Valorables OD</th>
                        <th>No Valorables OI</th>
                        <th>Vítreo OD</th>
                        <th>Vítreo OI</th>
                        <th>Nervio Óptico OD</th>
                        <th>Nervio Óptico OI</th>
                        <th>Retina Periférica OD</th>
                        <th>Retina Periférica OI</th>
                        <th>Mácula OD</th>
                        <th>Mácula OI</th>
                        <th>Observaciones Dibujo</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= $fila["id"] ?></td>
                            <td><?= htmlspecialchars($fila["bajo_dilatacion"]) ?></td>
                            <td><?= $fila["bajo_do"] ?></td>
                            <td><?= $fila["bajo_dx"] ?></td>
                            <td><?= $fila["bajo_total"] ?></td>
                            <td><?= $fila["bajo_media"] ?></td>
                            <td><?= $fila["bajo_no_dilata"] ?></td>
                            <td><?= $fila["no_valorable_od"] ? 'Sí' : 'No' ?></td>
                            <td><?= $fila["no_valorable_oi"] ? 'Sí' : 'No' ?></td>
                            <td><?= htmlspecialchars($fila["vitreo_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["vitreo_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["nervio_optico_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["nervio_optico_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["retina_periferica_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["retina_periferica_oi"]) ?></td>
                            <td><?= htmlspecialchars($fila["macula_od"]) ?></td>
                            <td><?= htmlspecialchars($fila["macula_oi"]) ?></td>
                            <td><?= nl2br(htmlspecialchars($fila["observaciones_dibujo"])) ?></td>
                            <td><?= $fila["creado_en"] ?></td>
                            <td>
                                <a href="editar_segmento_posterior.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="eliminar_segmento_posterior.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este registro?');">Eliminar</a>
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
