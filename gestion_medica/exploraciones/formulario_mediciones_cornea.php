<?php
include '../../conexionbd.php';
include '../header_medico.php';

$query = "SELECT Id_exp, nom_pac, papell, sapell FROM paciente WHERE p_activo = 'SI'";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Mediciones de la cornea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"> Mediciones de la cornea</h4>
        </div>
        <div class="card-body">
<!-- ...encabezado y conexión igual... -->
<form action="guardar_mediciones_cornea.php" method="POST">

    <div class="mb-3">
        <label class="form-label">Selecciona un paciente:</label>
        <select name="paciente_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <option value="<?= $row['Id_exp'] ?>">
                    <?= $row['nom_pac'] . ' ' . $row['papell'] . ' ' . $row['sapell'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <h5 class="text-primary">Ojo Derecho (OD)</h5>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Diámetro corneal vertical</label>
            <input type="text" name="od_dcv" class="form-control" placeholder="Ej: 11.5 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Diámetro corneal horizontal</label>
            <input type="text" name="od_dch" class="form-control" placeholder="Ej: 12.0 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Pupilar fotópico</label>
            <input type="text" name="od_dpf" class="form-control" placeholder="Ej: 3.0 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Pupilar mesópico</label>
            <input type="text" name="od_dpm" class="form-control" placeholder="Ej: 5.5 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Microscopía</label>
            <input type="text" name="od_micro" class="form-control" placeholder="Ej: Endotelio 2600 cels/mm²" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Paquimetría</label>
            <input type="text" name="od_paq" class="form-control" placeholder="Ej: 540 µm" required>
        </div>
    </div>

    <h5 class="text-success">Ojo Izquierdo (OI)</h5>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Diámetro corneal vertical</label>
            <input type="text" name="oi_dcv" class="form-control" placeholder="Ej: 11.7 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Diámetro corneal horizontal</label>
            <input type="text" name="oi_dch" class="form-control" placeholder="Ej: 12.1 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Pupilar fotópico</label>
            <input type="text" name="oi_dpf" class="form-control" placeholder="Ej: 3.2 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Pupilar mesópico</label>
            <input type="text" name="oi_dpm" class="form-control" placeholder="Ej: 5.7 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Microscopía</label>
            <input type="text" name="oi_micro" class="form-control" placeholder="Ej: Endotelio 2550 cels/mm²" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Paquimetría</label>
            <input type="text" name="oi_paq" class="form-control" placeholder="Ej: 530 µm" required>
        </div>
    </div>

    <div class="d-flex justify-content-between">
    <button type="submit" class="btn btn-success">Guardar Registro</button>
    <a href="listar_mediciones_cornea.php" class="btn btn-secondary">Cancelar</a>
</div>

</form>

        </div>
    </div>
</div>
</body>
<footer class="main-footer">
        <?php
        include("../../template/footer.php");
        ?>
    </footer>
</html>
    
