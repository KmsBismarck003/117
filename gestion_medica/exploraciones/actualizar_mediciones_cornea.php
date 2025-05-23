<?php
include '../../conexionbd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $campos = [
        'od_dcv', 'od_dch', 'od_dpf', 'od_dpm', 'od_micro', 'od_paq',
        'oi_dcv', 'oi_dch', 'oi_dpf', 'oi_dpm', 'oi_micro', 'oi_paq'
    ];

    $actualiza = [];
    foreach ($campos as $campo) {
        $valor = mysqli_real_escape_string($conexion, $_POST[$campo]);
        $actualiza[] = "$campo = '$valor'";
    }

    $sql = "UPDATE exploracion_oftalmologica SET " . implode(", ", $actualiza) . " WHERE id = $id";
    if (mysqli_query($conexion, $sql)) {
        header("Location: listar_mediciones_cornea.php?msg=actualizado");
        exit;
    } else {
        echo "Error al actualizar la exploración: " . mysqli_error($conexion);
    }
} else {
    echo "Datos inválidos.";
}
