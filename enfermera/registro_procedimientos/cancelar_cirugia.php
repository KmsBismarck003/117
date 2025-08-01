<?php
session_start();
include "../../conexionbd.php";

// Log para debugging
error_log("=== CANCELAR CIRUGÍA INICIADO ===");
error_log("POST data: " . print_r($_POST, true));
error_log("SESSION data: " . print_r($_SESSION, true));

// Verificar que el usuario esté logueado
if (!isset($_SESSION['login'])) {
    error_log("Error: Usuario no logueado");
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No autorizado. Debe iniciar sesión.']);
    exit;
}

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("Error: Método no es POST: " . $_SERVER['REQUEST_METHOD']);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Configurar cabeceras para JSON
header('Content-Type: application/json');

try {
    // Obtener datos de la sesión
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    
    // Obtener id_atencion del POST o de la sesión
    $id_atencion = isset($_POST['id_atencion']) ? $_POST['id_atencion'] : $_SESSION['pac'];
    
    error_log("Usuario: $id_usua, ID Atención: $id_atencion");
    
    if (!$id_atencion) {
        throw new Exception('No se encontró la atención del paciente');
    }
    
    // Verificar que la cirugía no esté ya cancelada
    $sql_check = "SELECT cancelada FROM dat_ingreso WHERE id_atencion = ?";
    $stmt_check = $conexion->prepare($sql_check);
    if (!$stmt_check) {
        throw new Exception('Error en la consulta: ' . $conexion->error);
    }
    
    $stmt_check->bind_param("i", $id_atencion);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows === 0) {
        throw new Exception('No se encontró la atención especificada');
    }
    
    $row_check = $result_check->fetch_assoc();
    if ($row_check['cancelada'] === 'SI') {
        throw new Exception('La cirugía ya está cancelada');
    }
    
    $stmt_check->close();
    
    // Verificar que la cirugía esté terminada antes de permitir cancelación
    $sql_terminada = "SELECT COUNT(*) as tiene_termino FROM dat_trans_grafico 
                      WHERE id_atencion = ? AND (top IS NOT NULL AND top != '')";
    $stmt_terminada = $conexion->prepare($sql_terminada);
    $stmt_terminada->bind_param("i", $id_atencion);
    $stmt_terminada->execute();
    $result_terminada = $stmt_terminada->get_result();
    $row_terminada = $result_terminada->fetch_assoc();
    $stmt_terminada->close();
    
    if ($row_terminada['tiene_termino'] == 0) {
        throw new Exception('Solo se pueden cancelar cirugías que hayan terminado');
    }
    
    // Proceder con la cancelación
    $fecha_cancelacion = date("Y-m-d H:i:s");
    
    $sql_cancelar = "UPDATE dat_ingreso 
                     SET cancelada = 'SI', 
                         fecha_cancelacion = ?, 
                         usuario_cancelacion = ? 
                     WHERE id_atencion = ?";
    
    $stmt_cancelar = $conexion->prepare($sql_cancelar);
    $stmt_cancelar->bind_param("sii", $fecha_cancelacion, $id_usua, $id_atencion);
    
    if (!$stmt_cancelar->execute()) {
        throw new Exception('Error al cancelar la cirugía: ' . $conexion->error);
    }
    
    if ($stmt_cancelar->affected_rows === 0) {
        throw new Exception('No se pudo actualizar el registro de la cirugía');
    }
    
    $stmt_cancelar->close();
    
    // Registrar la acción en un log (opcional)
    $log_message = "Cirugía cancelada - Atención: $id_atencion, Usuario: $id_usua, Fecha: $fecha_cancelacion";
    error_log($log_message);
    
    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => '✅ Cirugía cancelada exitosamente',
        'fecha_cancelacion' => $fecha_cancelacion,
        'id_atencion' => $id_atencion
    ]);
    
} catch (Exception $e) {
    // Registrar el error
    error_log("Error al cancelar cirugía: " . $e->getMessage());
    
    // Respuesta de error
    echo json_encode([
        'success' => false,
        'message' => '❌ Error: ' . $e->getMessage()
    ]);
} finally {
    // Cerrar conexión
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>
