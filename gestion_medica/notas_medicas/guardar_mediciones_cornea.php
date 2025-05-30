<?php
session_start();
include '../../conexionbd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['paciente_id']) || empty($_POST['paciente_id'])) {
        die("Error: No se recibió el ID del paciente.");
    }

    $id_exp   = $_POST['paciente_id'];
    $od_dcv   = $_POST['od_dcv'] ?? null;
    $od_dch   = $_POST['od_dch'] ?? null;
    $od_dpf   = $_POST['od_dpf'] ?? null;
    $od_dpm   = $_POST['od_dpm'] ?? null;
    $od_micro = $_POST['od_micro'] ?? null;
    $od_paq   = $_POST['od_paq'] ?? null;

    $oi_dcv   = $_POST['oi_dcv'] ?? null;
    $oi_dch   = $_POST['oi_dch'] ?? null;
    $oi_dpf   = $_POST['oi_dpf'] ?? null;
    $oi_dpm   = $_POST['oi_dpm'] ?? null;
    $oi_micro = $_POST['oi_micro'] ?? null;
    $oi_paq   = $_POST['oi_paq'] ?? null;

    $sql = "INSERT INTO mediciones_cornea (
                id_exp, od_dcv, od_dch, od_dpf, od_dpm, od_micro, od_paq,
                oi_dcv, oi_dch, oi_dpf, oi_dpm, oi_micro, oi_paq, fecha_registro
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssssssssss",
        $id_exp, $od_dcv, $od_dch, $od_dpf, $od_dpm, $od_micro, $od_paq,
        $oi_dcv, $oi_dch, $oi_dpf, $oi_dpm, $oi_micro, $oi_paq
    );

    if ($stmt->execute()) {
        // Mostrar alerta y redirigir
        echo "<script>
            alert('✅ Mediciones guardadas correctamente');
            window.location.href = 'formulario_mediciones_cornea.php?paciente_id=$id_exp';
        </script>";
        exit();
    } else {
        echo "❌ Error al guardar los datos: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: formulario_mediciones_cornea.php");
    exit();
}
