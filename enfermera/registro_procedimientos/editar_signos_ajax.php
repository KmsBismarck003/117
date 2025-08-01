<?php
session_start();
include "../../conexionbd.php";

// Configurar cabeceras para JSON
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

// Log para debug
error_log("=== EDITAR SIGNOS AJAX ===");
error_log("POST: " . print_r($_POST, true));

// Función para enviar respuesta JSON
function sendResponse($success, $message, $data = []) {
    $response = array_merge([
        'success' => $success,
        'message' => $message,
        'timestamp' => date('Y-m-d H:i:s')
    ], $data);
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Verificaciones básicas
    if (!isset($_SESSION['login'])) {
        sendResponse(false, 'Usuario no logueado');
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse(false, 'Método no permitido');
    }
    
    $action = $_POST['action'] ?? '';
    
    // === EDICIÓN EN TIEMPO REAL ===
    if ($action === 'editar_tiempo_real') {
        $id_trans_graf = $_POST['id_trans_graf'] ?? 0;
        $field = $_POST['field'] ?? '';
        $value = $_POST['value'] ?? '';
        
        // Validar datos
        if (!$id_trans_graf) {
            sendResponse(false, 'ID de registro no válido');
        }
        
        if (!$field) {
            sendResponse(false, 'Campo no especificado');
        }
        
        // Campos permitidos para edición
        $allowed_fields = ['hora', 'sistg', 'diastg', 'fcardg', 'frespg', 'tempg', 'satg'];
        
        if (!in_array($field, $allowed_fields)) {
            sendResponse(false, 'Campo no permitido para edición');
        }
        
        // Validaciones específicas por campo
        switch($field) {
            case 'hora':
                if (!preg_match('/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/', $value)) {
                    sendResponse(false, 'Formato de hora inválido (HH:MM)');
                }
                break;
            
            case 'sistg':
                $val = floatval($value);
                if ($val < 60 || $val > 250) {
                    sendResponse(false, 'Presión sistólica debe estar entre 60-250 mmHg');
                }
                break;
            
            case 'diastg':
                $val = floatval($value);
                if ($val < 30 || $val > 150) {
                    sendResponse(false, 'Presión diastólica debe estar entre 30-150 mmHg');
                }
                break;
            
            case 'fcardg':
                $val = floatval($value);
                if ($val < 30 || $val > 220) {
                    sendResponse(false, 'Frecuencia cardíaca debe estar entre 30-220 lpm');
                }
                break;
            
            case 'frespg':
                $val = floatval($value);
                if ($val < 8 || $val > 60) {
                    sendResponse(false, 'Frecuencia respiratoria debe estar entre 8-60 rpm');
                }
                break;
            
            case 'tempg':
                $val = floatval($value);
                if ($val < 34 || $val > 44) {
                    sendResponse(false, 'Temperatura debe estar entre 34-44°C');
                }
                break;
            
            case 'satg':
                $val = floatval($value);
                if ($val < 60 || $val > 100) {
                    sendResponse(false, 'Saturación debe estar entre 60-100%');
                }
                break;
        }
        
        // Verificar que el registro existe y pertenece al paciente actual
        $id_atencion = $_SESSION['pac'] ?? 0;
        if (!$id_atencion) {
            sendResponse(false, 'No hay paciente seleccionado en la sesión');
        }
        
        $sql_check = "SELECT id_trans_graf FROM dat_trans_grafico 
                      WHERE id_trans_graf = ? AND id_atencion = ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("ii", $id_trans_graf, $id_atencion);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        
        if ($result->num_rows === 0) {
            sendResponse(false, 'Registro no encontrado o no autorizado');
        }
        
        $stmt_check->close();
        
        // Actualizar el campo específico
        $sql_update = "UPDATE dat_trans_grafico SET $field = ? WHERE id_trans_graf = ?";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param("si", $value, $id_trans_graf);
        
        if (!$stmt_update->execute()) {
            sendResponse(false, 'Error al actualizar: ' . $conexion->error);
        }
        
        if ($stmt_update->affected_rows === 0) {
            sendResponse(false, 'No se realizaron cambios (valor idéntico)');
        }
        
        $stmt_update->close();
        
        error_log("Campo $field actualizado exitosamente: $value (ID: $id_trans_graf)");
        
        sendResponse(true, "Campo $field actualizado correctamente", [
            'field' => $field,
            'value' => $value,
            'id_trans_graf' => $id_trans_graf
        ]);
    }
    
    // === EDICIÓN TRADICIONAL (Modal) ===
    if ($action === 'editar' || !isset($_POST['action'])) {
        // Si no hay action, asumir que es edición tradicional del modal
        $id_trans_graf = $_POST['id_registro'] ?? $_POST['id_trans_graf'] ?? 0;
        $fecha_g = $_POST['fecha_g'] ?? $_POST['fecha_editar'] ?? '';
        $hora = $_POST['hora'] ?? $_POST['hora_editar'] ?? '';
        $sistg = $_POST['sistg'] ?? $_POST['sistg_editar'] ?? '';
        $diastg = $_POST['diastg'] ?? $_POST['diastg_editar'] ?? '';
        $fcardg = $_POST['fcardg'] ?? $_POST['fcardg_editar'] ?? '';
        $frespg = $_POST['frespg'] ?? $_POST['frespg_editar'] ?? '';
        $tempg = $_POST['tempg'] ?? $_POST['tempg_editar'] ?? '';
        $satg = $_POST['satg'] ?? $_POST['satg_editar'] ?? '';
        
        if (!$id_trans_graf) {
            sendResponse(false, 'ID de registro no válido');
        }
        
        // Validaciones básicas
        if (empty($fecha_g) || empty($hora)) {
            sendResponse(false, 'Fecha y hora son obligatorias');
        }
        
        // Verificar que el registro existe
        $id_atencion = $_SESSION['pac'] ?? 0;
        $sql_check = "SELECT id_trans_graf FROM dat_trans_grafico 
                      WHERE id_trans_graf = ? AND id_atencion = ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("ii", $id_trans_graf, $id_atencion);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        
        if ($result->num_rows === 0) {
            sendResponse(false, 'Registro no encontrado');
        }
        
        $stmt_check->close();
        
        // Actualizar todos los campos
        $sql_update = "UPDATE dat_trans_grafico 
                       SET fecha_g = ?, hora = ?, sistg = ?, diastg = ?, 
                           fcardg = ?, frespg = ?, tempg = ?, satg = ? 
                       WHERE id_trans_graf = ?";
        
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param("ssssssssi", $fecha_g, $hora, $sistg, $diastg, 
                                 $fcardg, $frespg, $tempg, $satg, $id_trans_graf);
        
        if (!$stmt_update->execute()) {
            sendResponse(false, 'Error al actualizar: ' . $conexion->error);
        }
        
        $stmt_update->close();
        
        sendResponse(true, 'Signos vitales actualizados correctamente', [
            'id_trans_graf' => $id_trans_graf,
            'datos' => [
                'fecha' => $fecha_g,
                'hora' => $hora,
                'sistg' => $sistg,
                'diastg' => $diastg,
                'fcardg' => $fcardg,
                'frespg' => $frespg,
                'tempg' => $tempg,
                'satg' => $satg
            ]
        ]);
    }
    
    // Si llegamos aquí, la acción no fue reconocida
    sendResponse(false, 'Acción no reconocida: ' . $action);
    
} catch (Exception $e) {
    error_log("Error en editar_signos_ajax.php: " . $e->getMessage());
    sendResponse(false, 'Error del servidor: ' . $e->getMessage());
}

// Limpiar conexión
if (isset($conexion)) {
    $conexion->close();
}
?>
