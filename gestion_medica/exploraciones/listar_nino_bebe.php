<?php
include '../../conexionbd.php';
include("../header_medico.php");
$query = "
    SELECT nb.*, 
           p.nom_pac, 
           p.papell, 
           p.sapell 
    FROM ninobebe nb 
    JOIN paciente p ON nb.id_exp = p.Id_exp 
    ORDER BY nb.fecha_registro DESC
";

$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Exploraciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Exploraciones Niño/Bebe Registradas</h2>

  <table class="table table-bordered table-hover">
    <thead class="table-primary">
      <tr>
        <th>#</th>
        <th>Paciente</th>
        <th>Reflejo OD</th>
        <th>Eje Visual OD</th>
        <th>Fijación OD</th>
        <th>Esquiascopia OD</th>
        <th>Posición OD</th>
        <th>Reflejo OI</th>
        <th>Eje Visual OI</th>
        <th>Fijación OI</th>
        <th>Esquiascopia OI</th>
        <th>Posición OI</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($resultado) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($resultado)): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nom_pac'] . ' ' . $row['papell'] . ' ' . $row['sapell']) ?></td>
            <td><?= htmlspecialchars($row['reflejo_od']) ?></td>
            <td><?= htmlspecialchars($row['eje_visual_od']) ?></td>
            <td><?= htmlspecialchars($row['fijacion_od']) ?></td>
            <td><?= htmlspecialchars($row['esquiascopia_od']) ?></td>
            <td><?= htmlspecialchars($row['posicion_od']) ?></td>
            <td><?= htmlspecialchars($row['reflejo_oi']) ?></td>
            <td><?= htmlspecialchars($row['eje_visual_oi']) ?></td>
            <td><?= htmlspecialchars($row['fijacion_oi']) ?></td>
            <td><?= htmlspecialchars($row['esquiascopia_oi']) ?></td>
            <td><?= htmlspecialchars($row['posicion_oi']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($row['fecha_registro'])) ?></td>
            <td>
            <a href="editar_nino_bebe.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="eliminar_nino_bebe.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta exploración?')">Eliminar</a>
          </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="13" class="text-center">No hay registros disponibles.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <a href="formulario_nino_bebe.php" class="btn btn-success">Registrar Nueva Exploración</a>
</div>
</body>
</html>
