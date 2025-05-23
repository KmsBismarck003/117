<?php
include '../../conexionbd.php';
include '../header_medico.php';

$sql = "SELECT 
            e.id,
            e.id_exp,
            p.nom_pac, p.papell, p.sapell,
            e.od_dcv, e.od_dch, e.od_dpf, e.od_dpm, e.od_micro, e.od_paq,
            e.oi_dcv, e.oi_dch, e.oi_dpf, e.oi_dpm, e.oi_micro, e.oi_paq,
            e.fecha_registro
        FROM exploracion_oftalmologica e
        JOIN paciente p ON e.id_exp = p.Id_exp
        ORDER BY e.fecha_registro DESC";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mediciones de la córnea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="d-flex flex-column min-vh-100">
    <div class="container mt-4 flex-grow-1">
        <h2 class="mb-4">Lista de Mediciones de la córnea</h2>
        <a href="formulario_mediciones_cornea.php" class="btn btn-sm btn-success">Nuevo</a><br><br>

        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Paciente</th>
                        <th>OD - D.C.V</th>
                        <th>OD - D.C.H</th>
                        <th>OD - D.P.F</th>
                        <th>OD - D.P.M</th>
                        <th>OD - Microscopia</th>
                        <th>OD - Paquimetría</th>
                        <th>OI - D.C.V</th>
                        <th>OI - D.C.H</th>
                        <th>OI - D.P.F</th>
                        <th>OI - D.P.M</th>
                        <th>OI - Microscopia</th>
                        <th>OI - Paquimetría</th>
                        <th>Fecha</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nom_pac'] . ' ' . $row['papell'] . ' ' . $row['sapell']) ?></td>
                            <td><?= htmlspecialchars($row['od_dcv']) ?></td>
                            <td><?= htmlspecialchars($row['od_dch']) ?></td>
                            <td><?= htmlspecialchars($row['od_dpf']) ?></td>
                            <td><?= htmlspecialchars($row['od_dpm']) ?></td>
                            <td><?= htmlspecialchars($row['od_micro']) ?></td>
                            <td><?= htmlspecialchars($row['od_paq']) ?></td>
                            <td><?= htmlspecialchars($row['oi_dcv']) ?></td>
                            <td><?= htmlspecialchars($row['oi_dch']) ?></td>
                            <td><?= htmlspecialchars($row['oi_dpf']) ?></td>
                            <td><?= htmlspecialchars($row['oi_dpm']) ?></td>
                            <td><?= htmlspecialchars($row['oi_micro']) ?></td>
                            <td><?= htmlspecialchars($row['oi_paq']) ?></td>
                            <td><?= htmlspecialchars($row['fecha_registro']) ?></td>
                            <td>
                                <a href="editar_mediciones_cornea.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="eliminar_mediciones_cornea.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta exploración?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No hay registros de exploraciones oftalmológicas.</div>
        <?php endif; ?>
    </div>

    <footer class="main-footer">
        <?php
        include("../../template/footer.php");
        ?>
    </footer>
</div>
</body>
</html>
