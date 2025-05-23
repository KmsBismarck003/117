<?php
include '../../conexionbd.php';
include("../header_medico.php");
$pacientes = mysqli_query($conexion, "SELECT Id_exp, nom_pac, papell, sapell FROM paciente WHERE p_activo = 'SI'");
?>
<!-- formulario_oftalmologico.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario Oftalmológico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Exploración NIÑO/BEBE</h2>
  <form action="guardar_ninoBebe.php" method="POST">
    <div class="row">
        <div class="mb-3">
  <label for="id_exp" class="form-label">Paciente</label>
  <select class="form-select" id="id_exp" name="id_exp" required>
    <option value="" disabled selected>Selecciona un paciente</option>
    <?php while ($paciente = mysqli_fetch_assoc($pacientes)): ?>
      <option value="<?= $paciente['Id_exp'] ?>">
        <?= $paciente['nom_pac'] . ' ' . $paciente['papell'] . ' ' . $paciente['sapell'] ?>
      </option>
    <?php endwhile; ?>
  </select>
</div>
      <!-- Ojo Derecho -->
      <div class="col-md-6">
        <h4>Ojo Derecho (OD)</h4>
        <div class="mb-3">
          <label for="reflejo_od" class="form-label">Reflejo Fotomotor</label>
          <input type="text" class="form-control" id="reflejo_od" name="reflejo_od" placeholder="Ej: Presente, Ausente">
        </div>
        <div class="mb-3">
          <label for="eje_visual_od" class="form-label">Eje Visual</label>
          <input type="text" class="form-control" id="eje_visual_od" name="eje_visual_od" placeholder="Ej: 0°, 15° exo">
        </div>
        <div class="mb-3">
          <label for="fijacion_od" class="form-label">Fijación</label>
          <select class="form-select" id="fijacion_od" name="fijacion_od">
            <option value="">Seleccione una opción</option>
            <option value="Central">Central</option>
            <option value="Excéntrica">Excéntrica</option>
            <option value="Inestable">Inestable</option>
            <option value="Ausente">Ausente</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="esquiascopia_od" class="form-label">Esquiascopia</label>
          <input type="text" class="form-control" id="esquiascopia_od" name="esquiascopia_od" placeholder="Ej: +1.00 -0.50 x 180">
        </div>
        <div class="mb-3">
          <label for="posicion_od" class="form-label">Posición Compensadora</label>
          <input type="text" class="form-control" id="posicion_od" name="posicion_od" placeholder="Ej: Inclinación de cabeza a la derecha">
        </div>
      </div>

      <!-- Ojo Izquierdo -->
      <div class="col-md-6">
        <h4>Ojo Izquierdo (OI)</h4>
        <div class="mb-3">
          <label for="reflejo_oi" class="form-label">Reflejo Fotomotor</label>
          <input type="text" class="form-control" id="reflejo_oi" name="reflejo_oi" placeholder="Ej: Presente, Ausente">
        </div>
        <div class="mb-3">
          <label for="eje_visual_oi" class="form-label">Eje Visual</label>
          <input type="text" class="form-control" id="eje_visual_oi" name="eje_visual_oi" placeholder="Ej: 0°, 10° eso">
        </div>
        <div class="mb-3">
          <label for="fijacion_oi" class="form-label">Fijación</label>
          <select class="form-select" id="fijacion_oi" name="fijacion_oi">
            <option value="">Seleccione una opción</option>
            <option value="Central">Central</option>
            <option value="Excéntrica">Excéntrica</option>
            <option value="Inestable">Inestable</option>
            <option value="Ausente">Ausente</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="esquiascopia_oi" class="form-label">Esquiascopia</label>
          <input type="text" class="form-control" id="esquiascopia_oi" name="esquiascopia_oi" placeholder="Ej: +0.50 -1.00 x 90">
        </div>
        <div class="mb-3">
          <label for="posicion_oi" class="form-label">Posición Compensadora</label>
          <input type="text" class="form-control" id="posicion_oi" name="posicion_oi" placeholder="Ej: Cabeza inclinada hacia izquierda">
        </div>
      </div>
    </div>
    <div class="mt-4">
      <button type="submit" class="btn btn-primary">Firmar Exploración</button>
      <a href="listar_nino_bebe.php" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</div>
</body>
</html>
