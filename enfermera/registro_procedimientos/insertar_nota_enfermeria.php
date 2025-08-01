<?php
// Iniciar sesión y configuración de seguridad
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=utf-8');

// Incluir conexión a la base de datos
require_once '../../conexionbd.php';

// Verificar que el usuario esté logueado
if (!isset($_SESSION['login']) || !isset($_SESSION['login']['id_usua'])) {
    error_log("ERROR: Sesión no válida - " . print_r($_SESSION, true));
    echo json_encode([
        'success' => false,
        'message' => '🔒 Sesión expirada. Por favor, inicie sesión nuevamente.',
        'type' => 'error'
    ]);
    exit;
}

// Validar token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode([
        'success' => false,
        'message' => '🛡️ Token de seguridad inválido. Recargue la página e intente nuevamente.',
        'type' => 'error'
    ]);
    exit;
}

// Validar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => '❌ Método de solicitud no válido.',
        'type' => 'error'
    ]);
    exit;
}

try {
    // Debug: Log datos recibidos
    error_log("=== DEBUG NOTA ENFERMERÍA ===");
    error_log("POST data: " . print_r($_POST, true));
    
    // Obtener y validar datos del formulario
    $id_exp = isset($_POST['id_exp']) ? trim($_POST['id_exp']) : '';
    $id_usua = filter_input(INPUT_POST, 'id_usua', FILTER_VALIDATE_INT);
    $id_atencion = filter_input(INPUT_POST, 'id_atencion', FILTER_VALIDATE_INT);
    $nota_enfermeria = isset($_POST['nota_enfermeria']) ? trim($_POST['nota_enfermeria']) : '';
    
    // Obtener datos de sesión para enfermera responsable
    $enfermera_responsable = isset($_SESSION['login']['nombre']) ? $_SESSION['login']['nombre'] : 'Sistema';
    
    // Obtener datos de tratamientos del formulario (si están disponibles)
    $tratamientos_seleccionados = isset($_POST['tratamientos_seleccionados']) ? trim($_POST['tratamientos_seleccionados']) : '';
    $medico_tratante = isset($_POST['medico_tratante']) ? trim($_POST['medico_tratante']) : 'Sin asignar';
    $anestesiologo = isset($_POST['anestesiologo']) ? trim($_POST['anestesiologo']) : '';
    $anestesia = isset($_POST['anestesia']) ? trim($_POST['anestesia']) : '';
    
    // Si hay tratamientos seleccionados, actualizar el tipo de tratamiento
    if (!empty($tratamientos_seleccionados)) {
        $tipo_tratamiento = $tratamientos_seleccionados;
    } else {
        $tipo_tratamiento = 'NOTA DE ENFERMERÍA';
    }

    // Debug: Log datos filtrados
    error_log("id_exp: $id_exp");
    error_log("id_usua: $id_usua");
    error_log("id_atencion: $id_atencion");
    error_log("nota_enfermeria: $nota_enfermeria");
    error_log("enfermera_responsable: $enfermera_responsable");
    error_log("tratamientos_seleccionados: $tratamientos_seleccionados");
    error_log("medico_tratante: $medico_tratante");
    error_log("anestesiologo: $anestesiologo");
    error_log("anestesia: $anestesia");
    error_log("tipo_tratamiento: $tipo_tratamiento");

    // Validaciones de campos requeridos
    $errores = [];

    if (empty($id_exp)) {
        $errores[] = "ID de expediente es requerido";
    }

    if (empty($id_usua) || !is_numeric($id_usua)) {
        $errores[] = "ID de usuario es requerido";
    }

    if (empty($id_atencion) || !is_numeric($id_atencion)) {
        $errores[] = "ID de atención es requerido";
    }

    if (empty($nota_enfermeria)) {
        $errores[] = "Nota de enfermería es requerida";
    }

    // Si hay errores, devolver mensaje
    if (!empty($errores)) {
        echo json_encode([
            'success' => false,
            'message' => '⚠️ Errores de validación: ' . implode(', ', $errores),
            'type' => 'warning',
            'errors' => $errores
        ]);
        exit;
    }

    // Validar longitud de campos
    if (strlen($nota_enfermeria) > 1000) {
        echo json_encode([
            'success' => false,
            'message' => '📝 La nota de enfermería no puede exceder 1000 caracteres.',
            'type' => 'warning'
        ]);
        exit;
    }

    // Verificar que la conexión a la BD esté disponible
    if (!$conexion) {
        throw new Exception("Error de conexión a la base de datos");
    }

    // Verificar que el ID de atención existe
    $sql_check = "SELECT COUNT(*) as count FROM dat_ingreso WHERE id_atencion = ?";
    $stmt_check = $conexion->prepare($sql_check);
    if (!$stmt_check) {
        throw new Exception("Error al preparar consulta de verificación: " . $conexion->error);
    }

    $stmt_check->bind_param("i", $id_atencion);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['count'] == 0) {
        echo json_encode([
            'success' => false,
            'message' => '❌ El ID de atención no existe en el sistema.',
            'type' => 'error'
        ]);
        exit;
    }

    $stmt_check->close();

    // Siempre insertar un nuevo registro para nota de enfermería
    // Cada nota debe ser un registro independiente con timestamp único
    $sql_insert = "INSERT INTO dat_tratamientos_genericos (
                  id_atencion, 
                  id_usua, 
                  tipo_tratamiento, 
                  medico_tratante, 
                  anestesiologo, 
                  anestesia, 
                  nota_enfermeria, 
                  enfermera_responsable, 
                  fecha_registro
               ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt_insert = $conexion->prepare($sql_insert);
    if (!$stmt_insert) {
        throw new Exception("Error al preparar consulta de inserción: " . $conexion->error);
    }

    $stmt_insert->bind_param("iissssss", 
        $id_atencion, 
        $id_usua, 
        $tipo_tratamiento, 
        $medico_tratante, 
        $anestesiologo, 
        $anestesia, 
        $nota_enfermeria, 
        $enfermera_responsable
    );

    if ($stmt_insert->execute()) {
        $nuevo_id = $conexion->insert_id;
        
        echo json_encode([
            'success' => true,
            'message' => '🎉 Nota de enfermería registrada exitosamente.',
            'type' => 'success',
            'action' => 'insert',
            'data' => [
                'id' => $nuevo_id,
                'id_atencion' => $id_atencion,
                'tipo_tratamiento' => $tipo_tratamiento,
                'medico_tratante' => $medico_tratante,
                'anestesiologo' => $anestesiologo,
                'anestesia' => $anestesia,
                'nota_enfermeria' => substr($nota_enfermeria, 0, 100) . (strlen($nota_enfermeria) > 100 ? '...' : ''),
                'enfermera_responsable' => $enfermera_responsable,
                'fecha_registro' => date('Y-m-d H:i:s')
            ]
        ]);
    } else {
        throw new Exception("Error al insertar el registro: " . $stmt_insert->error);
    }

    $stmt_insert->close();

} catch (Exception $e) {
    // Log del error para debugging
    error_log("Error en insertar_nota_enfermeria.php: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => '💥 Error interno del servidor: ' . $e->getMessage(),
        'type' => 'error',
        'debug' => [
            'file' => __FILE__,
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]
    ]);

} finally {
    // Cerrar conexión si existe
    if (isset($conexion) && $conexion) {
        $conexion->close();
    }
}
?>
