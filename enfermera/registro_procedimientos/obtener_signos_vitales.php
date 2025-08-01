<?php
session_start();
require_once '../../conexionbd.php';

// Set JSON header
header('Content-Type: application/json');

// Security: Validate session
if (!isset($_SESSION['login']) || !is_array($_SESSION['login']) || !isset($_SESSION['login']['id_usua'])) {
    echo json_encode([
        'success' => false, 
        'message' => '🔒 Su sesión ha expirado. Por favor, inicie sesión nuevamente.',
        'type' => 'session_expired'
    ]);
    exit;
}

// Validate required parameters
if (!isset($_GET['id_atencion'])) {
    echo json_encode([
        'success' => false, 
        'message' => '❌ Parámetro id_atencion requerido.',
        'type' => 'missing_parameter'
    ]);
    exit;
}

$id_atencion = filter_var($_GET['id_atencion'], FILTER_VALIDATE_INT);
if ($id_atencion === false) {
    echo json_encode([
        'success' => false, 
        'message' => '❌ ID de atención inválido.',
        'type' => 'invalid_parameter'
    ]);
    exit;
}

try {
    // Obtener signos vitales guardados para esta atención
    $sql = "SELECT DISTINCT 
                dtg.hora,
                dtg.sistg,
                dtg.diastg,
                dtg.fcardg,
                dtg.frespg,
                dtg.satg,
                dtg.tempg,
                DATE(dtg.fecha_g) as fecha,
                dtg.id_trans_graf,
                GROUP_CONCAT(DISTINCT t.tipo ORDER BY t.tipo SEPARATOR ', ') as tratamientos
            FROM dat_trans_grafico dtg
            INNER JOIN tratamientos t ON dtg.id_tratamiento = t.id
            WHERE dtg.id_atencion = ?
            AND DATE(dtg.fecha_g) = CURDATE()
            GROUP BY dtg.hora, dtg.sistg, dtg.diastg, dtg.fcardg, dtg.frespg, dtg.satg, dtg.tempg
            ORDER BY dtg.hora ASC";
    
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
    }
    
    $stmt->bind_param("i", $id_atencion);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $signos_vitales = [];
    while ($row = $result->fetch_assoc()) {
        $signos_vitales[] = [
            'id_trans_graf' => (int)$row['id_trans_graf'],
            'hora' => $row['hora'],
            'sistg' => (int)$row['sistg'],
            'diastg' => (int)$row['diastg'],
            'fcardg' => (int)$row['fcardg'],
            'frespg' => (int)$row['frespg'],
            'satg' => (int)$row['satg'],
            'tempg' => (float)$row['tempg'],
            'fecha' => $row['fecha'],
            'tratamientos' => $row['tratamientos']
        ];
    }
    
    $stmt->close();
    
    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => '✅ Signos vitales obtenidos correctamente.',
        'data' => $signos_vitales,
        'count' => count($signos_vitales),
        'fecha_consulta' => date('Y-m-d'),
        'id_atencion' => $id_atencion
    ]);
    
} catch (Exception $e) {
    error_log("Error en obtener_signos_vitales.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => '⚠️ Error al obtener los signos vitales.',
        'type' => 'database_error',
        'details' => 'Error interno del servidor.',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
} finally {
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>
