<?php
session_start();
include "../../conexionbd.php";

if (!isset($_SESSION['hospital'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_atencion = $_SESSION['hospital'];
    $usuario = $_SESSION['login'];

    // Get Id_exp from dat_ingreso
    $stmt = $conexion->prepare("SELECT Id_exp FROM dat_ingreso WHERE id_atencion = ?");
    $stmt->bind_param("i", $id_atencion);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id_exp = $row['Id_exp'] ?? null;
    $stmt->close();

    if (!$id_exp) {
        $_SESSION['message'] = "Error: No se encontró el expediente para esta atención.";
        $_SESSION['message_type'] = "danger";
        header("Location: recomendaciones.php");
        exit();
    }

    // Get form data
    $notas_internas = trim($_POST['notas_internas'] ?? '');
    $observaciones_od = trim($_POST['observaciones_od'] ?? '');
    $observaciones_oi = trim($_POST['observaciones_oi'] ?? '');
    $recomendaciones_od = trim($_POST['recomendaciones_od'] ?? '');
    $recomendaciones_oi = trim($_POST['recomendaciones_oi'] ?? '');
    $recomendaciones_general = trim($_POST['recomendaciones_general'] ?? '');
    $educacion_paciente = trim($_POST['educacion_paciente'] ?? '');
    $pronostico = !empty($_POST['pronostico']) ? implode(', ', $_POST['pronostico']) : '';
    $pronostico_text = trim($_POST['pronostico_text'] ?? '');
    $proxima_cita_date = trim($_POST['proxima_cita'] ?? '');
    $proxima_cita_time = trim($_POST['intervalo'] ?? '');
    $proxima_cita = !empty($proxima_cita_date) && !empty($proxima_cita_time) ? date('Y-m-d H:i:s', strtotime("$proxima_cita_date $proxima_cita_time")) : null;
    $con_resultados = isset($_POST['con_resultados']) ? 1 : 0;
    $cirugia = isset($_POST['cirugia']) ? 1 : 0;
    $especialista = !empty($_POST['especialista']) ? (int)$_POST['especialista'] : null;
    $doctor = !empty($_POST['doctor']) ? (int)$_POST['doctor'] : null;
    $interconsultas_text = trim($_POST['interconsultas_text'] ?? '');
    $observaciones_justificante = trim($_POST['observaciones_justificante'] ?? '');

    // Check if at least one field is filled
    $text_fields = [
        $notas_internas, $observaciones_od, $observaciones_oi, $recomendaciones_od, $recomendaciones_oi,
        $recomendaciones_general, $educacion_paciente, $pronostico, $pronostico_text, $interconsultas_text,
        $observaciones_justificante
    ];
    if (empty(array_filter($text_fields)) && empty($proxima_cita) && !$con_resultados && !$cirugia && !$especialista && !$doctor) {
        $_SESSION['message'] = "Error: Debe completar al menos un campo.";
        $_SESSION['message_type'] = "danger";
        header("Location: recomendaciones.php");
        exit();
    }

    // Insert into ocular_recomendaciones
    $stmt = $conexion->prepare("
        INSERT INTO ocular_recomendaciones (
            Id_exp, id_atencion, notas_internas, observaciones_od, observaciones_oi, recomendaciones_od,
            recomendaciones_oi, recomendaciones_general, educacion_paciente, pronostico, pronostico_text,
            proxima_cita, con_resultados, cirugia, especialista, doctor, interconsultas_text,
            observaciones_justificante, usuario_registro
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "iisssssssssssiiisss",
        $id_exp,
        $id_atencion,
        $notas_internas,
        $observaciones_od,
        $observaciones_oi,
        $recomendaciones_od,
        $recomendaciones_oi,
        $recomendaciones_general,
        $educacion_paciente,
        $pronostico,
        $pronostico_text,
        $proxima_cita,
        $con_resultados,
        $cirugia,
        $especialista,
        $doctor,
        $interconsultas_text,
        $observaciones_justificante,
        $usuario
    );

    if ($stmt->execute()) {
        $_SESSION['message'] = "Recomendaciones registradas exitosamente.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error al registrar las recomendaciones: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
    }

    $stmt->close();
    $conexion->close();
    header("Location: recomendaciones.php");
    exit();
} else {
    $_SESSION['message'] = "Método no permitido.";
    $_SESSION['message_type'] = "danger";
    header("Location: recomendaciones.php");
    exit();
}
?>