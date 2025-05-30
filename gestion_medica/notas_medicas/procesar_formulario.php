<?php
session_start();
include '../../conexionbd.php';

if (!isset($_SESSION['hospital'])) {
    header("Location: ../login.php");
    exit();
}

$id_atencion = $_SESSION['hospital'];

// Obtener id_exp a partir de id_atencion
$sql = "SELECT Id_exp FROM dat_ingreso WHERE id_atencion = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "No se encontró el paciente para esta atención.";
    exit();
}

$id_exp = $row['Id_exp'];
$stmt->close();

// Recolectar datos del formulario
$apertura_palpebral = $_POST['apertura_palpebral'] ?? null;
$hendidura_palpebral = $_POST['hendidura_palpebral'] ?? null;
$funcion_musculo_elevador = $_POST['funcion_musculo_elevador'] ?? null;
$fenomeno_bell = $_POST['fenomeno_bell'] ?? null;
$laxitud_horizontal = $_POST['laxitud_horizontal'] ?? null;
$laxitud_vertical = $_POST['laxitud_vertical'] ?? null;
$desplazamiento_ocular = $_POST['desplazamiento_ocular'] ?? null;
$maniobra_vatsaha = $_POST['maniobra_vatsaha'] ?? null;

$apertura_palpebral_oi = $_POST['apertura_palpebral_oi'] ?? null;
$hendidura_palpebral_oi = $_POST['hendidura_palpebral_oi'] ?? null;
$funcion_musculo_elevador_oi = $_POST['funcion_musculo_elevador_oi'] ?? null;
$fenomeno_bell_oi = $_POST['fenomeno_bell_oi'] ?? null;
$laxitud_horizontal_oi = $_POST['laxitud_horizontal_oi'] ?? null;
$laxitud_vertical_oi = $_POST['laxitud_vertical_oi'] ?? null;
$desplazamiento_ocular_oi = $_POST['desplazamiento_ocular_oi'] ?? null;
$maniobra_vatsaha_oi = $_POST['maniobra_vatsaha_oi'] ?? null;

$observaciones = $_POST['observaciones'] ?? null;

// Insertar en la base de datos
$sql_insert = "INSERT INTO exploraciones (
    id_exp, 
    apertura_palpebral, hendidura_palpebral, funcion_musculo_elevador,
    fenomeno_bell, laxitud_horizontal, laxitud_vertical, desplazamiento_ocular,
    maniobra_vatsaha, apertura_palpebral_oi, hendidura_palpebral_oi, funcion_musculo_elevador_oi,
    fenomeno_bell_oi, laxitud_horizontal_oi, laxitud_vertical_oi, desplazamiento_ocular_oi,
    maniobra_vatsaha_oi, observaciones
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt_insert = $conexion->prepare($sql_insert);
$stmt_insert->bind_param(
    "idddssssddddssssss",
    $id_exp,
    $apertura_palpebral, $hendidura_palpebral, $funcion_musculo_elevador,
    $fenomeno_bell, $laxitud_horizontal, $laxitud_vertical, $desplazamiento_ocular,
    $maniobra_vatsaha, $apertura_palpebral_oi, $hendidura_palpebral_oi, $funcion_musculo_elevador_oi,
    $fenomeno_bell_oi, $laxitud_horizontal_oi, $laxitud_vertical_oi, $desplazamiento_ocular_oi,
    $maniobra_vatsaha_oi, $observaciones
);

if ($stmt_insert->execute()) {
    header("Location: formulario_exploracion.php");
    exit();
} else {
    echo "Error al guardar la exploración: " . $stmt_insert->error;
}

$stmt_insert->close();
$conexion->close();
?>
