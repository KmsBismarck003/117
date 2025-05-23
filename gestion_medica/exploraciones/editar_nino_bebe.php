<?php
include '../../conexionbd.php';
include("../header_medico.php");


$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID no proporcionado.";
    exit;
}

$sql = "SELECT nb.*, CONCAT(p.nom_pac, ' ', p.papell, ' ', p.sapell) AS nombre_completo
        FROM ninobebe nb
        JOIN paciente p ON nb.id_exp = p.Id_exp
        WHERE nb.id = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (!$fila = mysqli_fetch_assoc($resultado)) {
    echo "Exploración no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Exploración Niño/Bebé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Editar Exploración Paciente: <?= htmlspecialchars($fila['nombre_completo']) ?></h2>

    <form method="POST" action="actualizar_nino_bebe.php">
        <input type="hidden" name="id" value="<?= $fila['id'] ?>">
        
        <div class="row mb-3">
            <div class="col">
                <label>Reflejo OD</label>
                <input type="text" name="reflejo_od" class="form-control" value="<?= $fila['reflejo_od'] ?>">
            </div>
            <div class="col">
                <label>Eje Visual OD</label>
                <input type="text" name="eje_visual_od" class="form-control" value="<?= $fila['eje_visual_od'] ?>">
            </div>
            <div class="col">
                <label>Fijación OD</label>
                <input type="text" name="fijacion_od" class="form-control" value="<?= $fila['fijacion_od'] ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Esquiascopía OD</label>
                <input type="text" name="esquiascopia_od" class="form-control" value="<?= $fila['esquiascopia_od'] ?>">
            </div>
            <div class="col">
                <label>Posición OD</label>
                <input type="text" name="posicion_od" class="form-control" value="<?= $fila['posicion_od'] ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Reflejo OI</label>
                <input type="text" name="reflejo_oi" class="form-control" value="<?= $fila['reflejo_oi'] ?>">
            </div>
            <div class="col">
                <label>Eje Visual OI</label>
                <input type="text" name="eje_visual_oi" class="form-control" value="<?= $fila['eje_visual_oi'] ?>">
            </div>
            <div class="col">
                <label>Fijación OI</label>
                <input type="text" name="fijacion_oi" class="form-control" value="<?= $fila['fijacion_oi'] ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Esquiascopía OI</label>
                <input type="text" name="esquiascopia_oi" class="form-control" value="<?= $fila['esquiascopia_oi'] ?>">
            </div>
            <div class="col">
                <label>Posición OI</label>
                <input type="text" name="posicion_oi" class="form-control" value="<?= $fila['posicion_oi'] ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="listar_nino_bebe.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
