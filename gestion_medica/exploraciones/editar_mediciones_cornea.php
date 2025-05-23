<?php
include '../../conexionbd.php';
include '../header_medico.php';

$id = $_GET['id'];
$sql = "SELECT e.*, CONCAT(p.nom_pac, ' ', p.papell, ' ', p.sapell) AS nombre_completo 
        FROM exploracion_oftalmologica e
        JOIN paciente p ON e.id_exp = p.Id_exp
        WHERE e.id = $id";
$res = mysqli_query($conexion, $sql);
$data = mysqli_fetch_assoc($res);

if (!$data) {
    echo "Exploración no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Exploración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="d-flex flex-column min-vh-100">
    <div class="container mt-5 flex-grow-1">
        <h4 class="mb-4">Editando la exploración de <strong><?= htmlspecialchars($data['nombre_completo']) ?></strong></h4>
        <form action="actualizar_mediciones_cornea.php" method="POST" class="row g-3">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">

            <?php
            $campos = [
                'od_dcv' => 'OD - Diámetro Corneal Vertical',
                'od_dch' => 'OD - Diámetro Corneal Horizontal',
                'od_dpf' => 'OD - Diámetro Pupilar Fotópico',
                'od_dpm' => 'OD - Diámetro Pupilar Mesópico',
                'od_micro' => 'OD - Microscopia',
                'od_paq' => 'OD - Paquimetría',
                'oi_dcv' => 'OI - Diámetro Corneal Vertical',
                'oi_dch' => 'OI - Diámetro Corneal Horizontal',
                'oi_dpf' => 'OI - Diámetro Pupilar Fotópico',
                'oi_dpm' => 'OI - Diámetro Pupilar Mesópico',
                'oi_micro' => 'OI - Microscopia',
                'oi_paq' => 'OI - Paquimetría'
            ];
            foreach ($campos as $clave => $label): ?>
                <div class="col-md-4">
                    <label class="form-label"><?= $label ?></label>
                    <input type="text" name="<?= $clave ?>" class="form-control"
                           value="<?= htmlspecialchars($data[$clave]) ?>" placeholder="Ej: 11.5 mm">
                </div>
            <?php endforeach; ?>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="listar_mediciones_cornea.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <footer class="main-footer">
        <?php
        include("../../template/footer.php");
        ?>
    </footer>
</div>
</body>
</html>
