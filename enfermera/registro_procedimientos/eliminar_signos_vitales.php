<?php
session_start();
include "../../conexionbd.php";
include "verificar_cirugia.php"; // Incluir funciones de verificación

// Verificar que el usuario esté logueado
if (!isset($_SESSION['login'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'No autorizado']);
    } else {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>No Autorizado</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css' rel='stylesheet'>
            <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' rel='stylesheet'>
            <style>
                body { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
                .notification-card { background: white; border-radius: 15px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); padding: 40px; text-align: center; max-width: 400px; }
                .icon-error { color: #e74c3c; font-size: 60px; margin-bottom: 20px; }
                .title { color: #2c3e50; font-size: 24px; font-weight: bold; margin-bottom: 15px; }
                .message { color: #7f8c8d; font-size: 16px; margin-bottom: 30px; line-height: 1.5; }
                .btn-back { background: linear-gradient(45deg, #e74c3c, #c0392b); border: none; border-radius: 25px; padding: 12px 30px; color: white; font-weight: bold; transition: all 0.3s; }
                .btn-back:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
            </style>
        </head>
        <body>
            <div class='notification-card'>
                <i class='fas fa-user-times icon-error'></i>
                <div class='title'>Sesión No Autorizada</div>
                <div class='message'>Debe iniciar sesión para realizar esta operación.</div>
                <button class='btn btn-back' onclick='window.location.href=\"../../index.php\"'>
                    <i class='fas fa-sign-in-alt'></i> Iniciar Sesión
                </button>
            </div>
        </body>
        </html>";
    }
    exit;
}

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Configurar cabeceras para JSON si es AJAX
if (isset($_POST['ajax']) || isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');
}

// VERIFICAR ESTADO DE LA CIRUGÍA ANTES DE PERMITIR ELIMINAR
if (isset($_SESSION['pac'])) {
    $id_atencion = $_SESSION['pac'];
    
    // Verificar si la cirugía fue cancelada
    $sql_cancelada = "SELECT cancelada FROM dat_ingreso WHERE id_atencion = $id_atencion";
    $result_cancelada = $conexion->query($sql_cancelada);
    $cirugia_cancelada = false;
    if ($result_cancelada) {
        $row_cancelada = $result_cancelada->fetch_assoc();
        $cirugia_cancelada = ($row_cancelada['cancelada'] == 'SI');
    }
    
    // Verificar si la cirugía ha terminado (pero NO está cancelada)
    $cirugia_terminada = cirugiaTerminada($conexion, $id_atencion);
    
    // SOLO bloquear si la cirugía está terminada Y NO está cancelada
    // Si está cancelada, permitir eliminar (para permitir correcciones)
    if ($cirugia_terminada && !$cirugia_cancelada) {
        echo json_encode([
            'success' => false, 
            'message' => '� No se puede eliminar registros de una cirugía terminada',
            'bloqueado' => true
        ]);
        exit;
    }
}

// Obtener y validar datos (mantener compatibilidad con ambos formatos)
$id_registro = isset($_POST['id_registro']) ? (int)$_POST['id_registro'] : 
              (isset($_POST['id']) ? (int)$_POST['id'] : 0);
$action = isset($_POST['action']) ? $_POST['action'] : 'eliminar'; // Default action

// Log para debugging
error_log("ELIMINAR SIGNOS VITALES DEBUG:");
error_log("ID registro: " . $id_registro);
error_log("Action: " . $action);
error_log("POST data: " . print_r($_POST, true));

if (!$id_registro) {
    echo json_encode(['success' => false, 'message' => 'ID de registro no valido - ID: ' . $id_registro]);
    exit;
}

try {
    // Verificar que el registro existe y pertenece al paciente actual
    $verificar_sql = "SELECT id_trans_graf, fecha_g, hora, id_atencion FROM dat_trans_grafico WHERE id_trans_graf = ?";
    $stmt_verificar = $conexion->prepare($verificar_sql);
    
    if (!$stmt_verificar) {
        error_log("Error preparando consulta de verificación: " . $conexion->error);
        echo json_encode(['success' => false, 'message' => 'Error preparando consulta: ' . $conexion->error]);
        exit;
    }
    
    $stmt_verificar->bind_param("i", $id_registro);
    $stmt_verificar->execute();
    $resultado_verificacion = $stmt_verificar->get_result();
    
    error_log("Registros encontrados para ID $id_registro: " . $resultado_verificacion->num_rows);
    
    if ($resultado_verificacion->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'El registro no existe']);
        exit;
    }
    
    $registro_info = $resultado_verificacion->fetch_assoc();
    $stmt_verificar->close();
    
    // Validar que el registro pertenece al paciente actual (seguridad)
    if (isset($_SESSION['pac']) && $registro_info['id_atencion'] != $_SESSION['pac']) {
        error_log("Intento de eliminar registro que no pertenece al paciente actual. Registro: " . $registro_info['id_atencion'] . ", Sesión: " . $_SESSION['pac']);
        echo json_encode(['success' => false, 'message' => 'No tiene permisos para eliminar este registro']);
        exit;
    }
    
    error_log("Registro encontrado: " . print_r($registro_info, true));
    
    // Eliminar el registro usando prepared statement
    $eliminar_sql = "DELETE FROM dat_trans_grafico WHERE id_trans_graf = ?";
    $stmt_eliminar = $conexion->prepare($eliminar_sql);
    
    if (!$stmt_eliminar) {
        error_log("Error preparando consulta de eliminación: " . $conexion->error);
        echo json_encode(['success' => false, 'message' => 'Error preparando eliminación: ' . $conexion->error]);
        exit;
    }
    
    $stmt_eliminar->bind_param("i", $id_registro);
    
    if ($stmt_eliminar->execute()) {
        $filas_afectadas = $stmt_eliminar->affected_rows;
        error_log("Filas afectadas en eliminación: " . $filas_afectadas);
        
        if ($filas_afectadas > 0) {
            echo json_encode([
                'success' => true, 
                'message' => '✅ Registro eliminado correctamente',
                'id_eliminado' => $id_registro,
                'fecha_eliminada' => $registro_info['fecha_g'],
                'hora_eliminada' => $registro_info['hora']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el registro - no hay filas afectadas']);
        }
        $stmt_eliminar->close();
    } else {
        error_log("Error ejecutando eliminación: " . $stmt_eliminar->error);
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $stmt_eliminar->error]);
    }
    
} catch (Exception $e) {
    error_log("Excepción en eliminación: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor: ' . $e->getMessage()]);
}

$conexion->close();
?>
