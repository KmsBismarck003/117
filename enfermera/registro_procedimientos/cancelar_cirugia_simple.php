<?php
session_start();
include "../../conexionbd.php";

// Detectar si es envío directo o AJAX
$is_direct_submit = isset($_POST['direct_submit']) && $_POST['direct_submit'] == '1';

// Configurar cabeceras según el tipo de solicitud
if (!$is_direct_submit) {
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-cache, must-revalidate');
}

// Log básico
error_log("=== CANCELAR CIRUGÍA SIMPLE ===");
error_log("POST: " . print_r($_POST, true));
error_log("Tipo: " . ($is_direct_submit ? 'DIRECTO' : 'AJAX'));

// Función para enviar respuesta según el tipo
function sendResponse($success, $message, $data = [], $is_direct = false) {
    global $is_direct_submit;
    
    if ($is_direct_submit || $is_direct) {
        // Para envío directo, establecer mensaje en sesión y redireccionar
        if ($success) {
            $_SESSION['mensaje_exito'] = $message;
        } else {
            $_SESSION['mensaje_error'] = $message;
        }
        header('Location: nota_registro_grafico.php');
        exit;
    } else {
        // Para AJAX, enviar JSON
        $response = array_merge([
            'success' => $success,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ], $data);
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
}

try {
    // Verificaciones básicas
    if (!isset($_SESSION['login'])) {
        sendResponse(false, 'Usuario no logueado', [], $is_direct_submit);
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse(false, 'Método no permitido', [], $is_direct_submit);
    }
    
    // Obtener datos
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = isset($_POST['id_atencion']) ? $_POST['id_atencion'] : $_SESSION['pac'];
    
    if (!$id_atencion) {
        sendResponse(false, 'No se encontró ID de atención', [], $is_direct_submit);
    }
    
    error_log("Procesando cancelación - Usuario: $id_usua, Atención: $id_atencion");
    
    // Verificar que la cirugía existe
    $sql_check = "SELECT id_atencion, cancelada FROM dat_ingreso WHERE id_atencion = ?";
    $stmt_check = $conexion->prepare($sql_check);
    
    if (!$stmt_check) {
        sendResponse(false, 'Error preparando consulta: ' . $conexion->error, [], $is_direct_submit);
    }
    
    $stmt_check->bind_param("i", $id_atencion);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    
    if ($result->num_rows === 0) {
        sendResponse(false, 'No se encontró la atención', [], $is_direct_submit);
    }
    
    $row = $result->fetch_assoc();
    
    // Agregar información de debug sobre el estado actual
    error_log("Estado actual de la cirugía - ID: $id_atencion, Cancelada: " . $row['cancelada']);
    
    if ($row['cancelada'] === 'SI') {
        sendResponse(false, 'La cirugía ya está cancelada', [], $is_direct_submit);
    }
    
    $stmt_check->close();
    
    // Proceder con la cancelación
    $fecha_cancelacion = date("Y-m-d H:i:s");
    
    $sql_update = "UPDATE dat_ingreso 
                   SET cancelada = 'SI', 
                       fecha_cancelacion = ?, 
                       usuario_cancelacion = ? 
                   WHERE id_atencion = ?";
    
    $stmt_update = $conexion->prepare($sql_update);
    
    if (!$stmt_update) {
        sendResponse(false, 'Error preparando actualización: ' . $conexion->error, [], $is_direct_submit);
    }
    
    $stmt_update->bind_param("sii", $fecha_cancelacion, $id_usua, $id_atencion);
    
    if (!$stmt_update->execute()) {
        sendResponse(false, 'Error ejecutando actualización: ' . $conexion->error, [], $is_direct_submit);
    }
    
    if ($stmt_update->affected_rows === 0) {
        sendResponse(false, 'No se actualizó ningún registro', [], $is_direct_submit);
    }
    
    $stmt_update->close();
    
    error_log("Cirugía cancelada exitosamente - Atención: $id_atencion");
    
    // Respuesta exitosa
    sendResponse(true, 'Cirugía cancelada exitosamente', [
        'id_atencion' => $id_atencion,
        'fecha_cancelacion' => $fecha_cancelacion
    ], $is_direct_submit);
    
} catch (Exception $e) {
    error_log("Error cancelando cirugía: " . $e->getMessage());
    sendResponse(false, $e->getMessage(), [], $is_direct_submit);
}
// Limpiar conexión
if (isset($conexion)) {
    $conexion->close();
}
?>
