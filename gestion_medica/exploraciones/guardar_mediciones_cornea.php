<?php
include '../../conexionbd.php';

// Verifica si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar y obtener datos
    $id_exp = mysqli_real_escape_string($conexion, $_POST['paciente_id']);

    $od_dcv = $_POST['od_dcv'];
    $od_dch = $_POST['od_dch'];
    $od_dpf = $_POST['od_dpf'];
    $od_dpm = $_POST['od_dpm'];
    $od_micro = $_POST['od_micro'];
    $od_paq = $_POST['od_paq'];

    $oi_dcv = $_POST['oi_dcv'];
    $oi_dch = $_POST['oi_dch'];
    $oi_dpf = $_POST['oi_dpf'];
    $oi_dpm = $_POST['oi_dpm'];
    $oi_micro = $_POST['oi_micro'];
    $oi_paq = $_POST['oi_paq'];

    // Aquí debes tener previamente creada una tabla para almacenar estos datos, por ejemplo: `exploracion_oftalmologica`

    $sql = "INSERT INTO exploracion_oftalmologica (
                id_exp, 
                od_dcv, od_dch, od_dpf, od_dpm, od_micro, od_paq, 
                oi_dcv, oi_dch, oi_dpf, oi_dpm, oi_micro, oi_paq
            ) VALUES (
                '$id_exp',
                '$od_dcv', '$od_dch', '$od_dpf', '$od_dpm', '$od_micro', '$od_paq',
                '$oi_dcv', '$oi_dch', '$oi_dpf', '$oi_dpm', '$oi_micro', '$oi_paq'
            )";

    $success = false;
    if (mysqli_query($conexion, $sql)) {
        header("Location: listar_mediciones_cornea.php?mensaje=guardado");
        exit;
    } else {
        echo "<div class='alert alert-danger text-center mt-4'>Error: " . mysqli_error($conexion) . "</div>";
    }
}
?>

