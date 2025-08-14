<?php
ob_start();
session_start();
include '../../conexionbd.php'; // Assumes MySQLi connection in $conexion

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Helper function to log errors to a file
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, dirname(__DIR__, 2) . '/logs/error.log');
}

// Set JSON header
header('Content-Type: application/json; charset=utf-8');

// Security: Validate session
if (!isset($_SESSION['login']) || !is_array($_SESSION['login']) || !isset($_SESSION['login']['id_usua']) || !isset($_SESSION['pac'])) {
    logError("Session validation failed: login or pac not set");
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    ob_end_flush();
    exit();
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    logError("CSRF token validation failed");
    echo json_encode(['success' => false, 'message' => 'Token CSRF no válido']);
    ob_end_flush();
    exit();
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    logError("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    ob_end_flush();
    exit();
}

// Retrieve and sanitize form data
$id_atencion = (int)$_SESSION['pac'];
$id_usua = (int)$_SESSION['login']['id_usua'];
$id_exp = filter_input(INPUT_POST, 'id_exp', FILTER_SANITIZE_NUMBER_INT);
$confirmacion_identidad = isset($_POST['confirmacion_identidad']) ? 1 : 0;
$sitio_marcado_si = isset($_POST['sitio_marcado']) && in_array('Sí', $_POST['sitio_marcado']) ? 1 : 0;
$sitio_marcado_np = isset($_POST['sitio_marcado']) && in_array('No procede', $_POST['sitio_marcado']) ? 1 : 0;
$verificacion_anestesia = isset($_POST['verificacion_anestesia']) ? 1 : 0;
$pulsioximetro = isset($_POST['pulsioximetro']) ? 1 : 0;
$alergias_no = isset($_POST['alergias']) && in_array('No', $_POST['alergias']) ? 1 : 0;
$alergias_si = isset($_POST['alergias']) && in_array('Sí', $_POST['alergias']) ? 1 : 0;
$via_aerea_no = isset($_POST['via_aerea_dificil']) && in_array('No', $_POST['via_aerea_dificil']) ? 1 : 0;
$via_aerea_si = isset($_POST['via_aerea_dificil']) && in_array('Sí, y hay materiales y equipos / ayuda disponible', $_POST['via_aerea_dificil']) ? 1 : 0;
$riesgo_hemo_no = isset($_POST['riesgo_hemorragia']) && in_array('No', $_POST['riesgo_hemorragia']) ? 1 : 0;
$riesgo_hemo_si = isset($_POST['riesgo_hemorragia']) && in_array('Sí, y se ha previsto la disponibilidad de líquidos y dos vías IV o centrales', $_POST['riesgo_hemorragia']) ? 1 : 0;
$miembros_presentados = isset($_POST['miembros_presentados']) ? 1 : 0;
$confirmacion_identidad_equipo = isset($_POST['confirmacion_identidad_equipo']) ? 1 : 0;
$profilaxis_antibiotica_si = isset($_POST['profilaxis_antibiotica_si']) ? 1 : 0;
$profilaxis_antibiotica_np = isset($_POST['profilaxis_antibiotica_np']) ? 1 : 0;
$problemas_instrumental = isset($_POST['problemas_instrumental']) ? 1 : 0;
$duracion_operacion = isset($_POST['duracion_operacion']) ? 1 : 0;
$perdida_sangre = isset($_POST['perdida_sangre']) ? 1 : 0;
$problemas_paciente = isset($_POST['problemas_paciente']) ? 1 : 0;
$esterilidad_confirmada = isset($_POST['esterilidad_confirmada']) ? 1 : 0;
$imagenes_visibles_si = isset($_POST['imagenes_visibles_si']) ? 1 : 0;
$imagenes_visibles_np = isset($_POST['imagenes_visibles_np']) ? 1 : 0;
$nombre_procedimiento = isset($_POST['nombre_procedimiento']) ? 1 : 0;
$recuento_instrumental = isset($_POST['recuento_instrumental']) ? 1 : 0;
$etiquetado_muestras = isset($_POST['etiquetado_muestras']) ? 1 : 0;
$aspectos_recuperacion = isset($_POST['aspectos_recuperacion']) ? 1 : 0;
// Fields not in the form, set to 0
$pasos_criticos = 0;
$problemas_instrumental_final = 0;

// Validate required fields
if (!$id_exp || !$id_atencion || !$id_usua) {
    logError("Missing required fields: id_exp=$id_exp, id_atencion=$id_atencion, id_usua=$id_usua");
    echo json_encode(['success' => false, 'message' => 'Datos requeridos incompletos']);
    ob_end_flush();
    exit();
}

// Prepare the insert query
$sql = "INSERT INTO dat_cir_seg (
    id_exp, id_usua, id_atencion, confirmacion_identidad, sitio_marcado_si, sitio_marcado_np,
    verificacion_anestesia, pulsioximetro, alergias_no, alergias_si, via_aerea_no, via_aerea_si,
    riesgo_hemo_no, riesgo_hemo_si, miembros_presentados, confirmacion_identidad_equipo,
    profilaxis_antibiotica_si, profilaxis_antibiotica_np, pasos_criticos, duracion_operacion,
    perdida_sangre, problemas_paciente, esterilidad_confirmada, problemas_instrumental,
    imagenes_visibles_si, imagenes_visibles_np, nombre_procedimiento, recuento_instrumental,
    etiquetado_muestras, problemas_instrumental_final, aspectos_recuperacion
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    logError("Prepare failed: " . $conexion->error);
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta']);
    ob_end_flush();
    exit();
}

// Bind parameters
$stmt->bind_param(
    "iiiiiiiiiiiiiiiiiiiiiiiiiiiiiii",
    $id_exp,
    $id_usua,
    $id_atencion,
    $confirmacion_identidad,
    $sitio_marcado_si,
    $sitio_marcado_np,
    $verificacion_anestesia,
    $pulsioximetro,
    $alergias_no,
    $alergias_si,
    $via_aerea_no,
    $via_aerea_si,
    $riesgo_hemo_no,
    $riesgo_hemo_si,
    $miembros_presentados,
    $confirmacion_identidad_equipo,
    $profilaxis_antibiotica_si,
    $profilaxis_antibiotica_np,
    $pasos_criticos,
    $duracion_operacion,
    $perdida_sangre,
    $problemas_paciente,
    $esterilidad_confirmada,
    $problemas_instrumental,
    $imagenes_visibles_si,
    $imagenes_visibles_np,
    $nombre_procedimiento,
    $recuento_instrumental,
    $etiquetado_muestras,
    $problemas_instrumental_final,
    $aspectos_recuperacion
);

// Execute the query
if (!$stmt->execute()) {
    logError("Insert failed: " . $stmt->error);
    echo json_encode(['success' => false, 'message' => 'Error al registrar la hoja de cirugía segura']);
    $stmt->close();
    ob_end_flush();
    exit();
}

$stmt->close();

// Success response
echo json_encode(['success' => true, 'message' => 'Hoja de cirugía segura registrada con éxito']);
ob_end_flush();
$conexion->close();
?>