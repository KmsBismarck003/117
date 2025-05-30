<?php
session_start();
include '../../conexionbd.php';
include '../header_medico.php';

if (!isset($_SESSION['hospital'])) {
    header("Location: ../login.php");
    exit();
}

// Obtener información del paciente
$id_atencion = $_SESSION['hospital'];
$sql_pac = "SELECT p.Id_exp, p.sapell, p.papell, p.nom_pac, p.fecnac, di.fecha, di.activo 
            FROM paciente p, dat_ingreso di 
            WHERE p.Id_exp = di.Id_exp AND di.id_atencion = ?";
$stmt = $conexion->prepare($sql_pac);
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$result_pac = $stmt->get_result();
$row_pac = $result_pac->fetch_assoc();
$stmt->close();

$pac_id_exp = $row_pac['Id_exp'] ?? null;
$pac_nom_pac = $row_pac['nom_pac'] ?? 'No disponible';
$pac_papell = $row_pac['papell'] ?? 'No disponible';
$pac_sapell = $row_pac['sapell'] ?? 'No disponible';
$pac_fecnac = $row_pac['fecnac'] ?? 'No disponible';
$pac_fecha_ingreso = $row_pac['fecha'] ?? 'No disponible';
$activo = $row_pac['activo'] ?? 'No disponible';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Mediciones de la córnea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .thead { background-color: #2b2d7f; color: white; font-size: 22px; padding: 10px; text-align: center; }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <!-- Información del Paciente -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Información del Paciente</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">Nombre: <strong><?= htmlspecialchars($pac_nom_pac) ?></strong></div>
                <div class="col-sm-4">Apellido Paterno: <strong><?= htmlspecialchars($pac_papell) ?></strong></div>
                <div class="col-sm-4">Apellido Materno: <strong><?= htmlspecialchars($pac_sapell) ?></strong></div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-4">Fecha de Nacimiento: <strong><?= date_format(date_create($pac_fecnac), "d/m/Y") ?></strong></div>
                <div class="col-sm-4">Fecha de Ingreso: <strong><?= date_format(date_create($pac_fecha_ingreso), "d/m/Y H:i:s") ?></strong></div>
                <div class="col-sm-4">Estado: <strong><?= $activo === 'SI' ? 'Activo' : 'Inactivo' ?></strong></div>
            </div>
        </div>
    </div>

    <!-- Formulario de Mediciones -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Mediciones de la Córnea</h4>
        </div>
        <div class="card-body">
            <form action="guardar_mediciones_cornea.php" method="POST">
                <!-- Campo oculto con el ID del paciente -->
                <input type="hidden" name="paciente_id" value="<?= htmlspecialchars($pac_id_exp) ?>">

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
                    <a href="../hospitalizacion/vista_pac_hosp.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="main-footer mt-5">
    <?php include("../../template/footer.php"); ?>
</footer>

</body>
</html>
