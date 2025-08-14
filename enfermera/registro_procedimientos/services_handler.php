<?php
ob_start();
session_start();
include '../../conexionbd.php';

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Helper function to log errors to a file
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, dirname(__DIR__, 2) . '/logs/services_handler_errors.log');
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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    logError("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    ob_end_flush();
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['csrf_token']) || $data['csrf_token'] !== $_SESSION['csrf_token']) {
    logError("CSRF token validation failed. Received: " . ($data['csrf_token'] ?? 'none') . ", Expected: " . ($_SESSION['csrf_token'] ?? 'none'));
    echo json_encode(['success' => false, 'message' => 'Token CSRF no válido']);
    ob_end_flush();
    exit();
}

$action = $data['action'] ?? '';
$id_usua = (int)$_SESSION['login']['id_usua'];
$id_atencion = (int)$_SESSION['pac'];

logError("Processing action: $action, id_usua: $id_usua, id_atencion: $id_atencion");

switch ($action) {
    case 'get':
        // Fetch registered services
        $sql = "SELECT c.id_ctapac, c.insumo, c.cta_tot, c.cta_fec, c.hora, s.serv_desc 
                FROM dat_ctapac c 
                LEFT JOIN cat_servicios s ON c.insumo = s.id_serv 
                WHERE c.id_usua = ? AND c.id_atencion = ? AND c.cta_activo = 'SI' AND s.tip_insumo = 'CEYE'";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            logError("Prepare failed for get services: " . $conexion->error);
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta']);
            ob_end_flush();
            exit();
        }
        $stmt->bind_param("ii", $id_usua, $id_atencion);
        if (!$stmt->execute()) {
            logError("Execute failed for get services: id_usua=$id_usua, id_atencion=$id_atencion, error=" . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Error al obtener servicios']);
            $stmt->close();
            ob_end_flush();
            exit();
        }
        $result = $stmt->get_result();
        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = [
                'id_ctapac' => $row['id_ctapac'],
                'serv_desc' => $row['serv_desc'] ?? 'Desconocido',
                'cta_tot' => $row['cta_tot'],
                'cta_fec' => $row['cta_fec'],
                'hora' => $row['hora'] ?? 'N/A'
            ];
        }
        $stmt->close();
        logError("Fetched " . count($services) . " services for id_usua=$id_usua, id_atencion=$id_atencion");
        echo json_encode(['success' => true, 'services' => $services]);
        break;

    case 'delete':
        // Delete a service
        $id_ctapac = (int)($data['id_ctapac'] ?? 0);
        if ($id_ctapac <= 0) {
            logError("Invalid id_ctapac: $id_ctapac");
            echo json_encode(['success' => false, 'message' => 'ID de servicio inválido']);
            ob_end_flush();
            exit();
        }
        $sql = "DELETE c FROM dat_ctapac c
                INNER JOIN cat_servicios s ON c.insumo = s.id_serv
                WHERE c.id_ctapac = ? AND c.id_usua = ? AND c.id_atencion = ? AND s.tip_insumo = 'CEYE'";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            logError("Prepare failed for delete: " . $conexion->error);
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta']);
            ob_end_flush();
            exit();
        }
        $stmt->bind_param("iii", $id_ctapac, $id_usua, $id_atencion);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                logError("Service deleted: id_ctapac=$id_ctapac");
                echo json_encode(['success' => true, 'message' => 'Equipo eliminado correctamente']);
            } else {
                logError("Delete failed: No service found with id_ctapac=$id_ctapac for user/attention/group CEYE or already deleted.");
                echo json_encode(['success' => false, 'message' => 'No se encontró el servicio para eliminar o ya fue eliminado.']);
            }
        } else {
            logError("Delete failed: id_ctapac=$id_ctapac, error=" . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Error al eliminar servicio']);
        }
        $stmt->close();
        break;

    default:
        logError("Invalid action: $action");
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}

ob_end_flush();
$conexion->close();
?>