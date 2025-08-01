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

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode([
        'success' => false, 
        'message' => '🛡️ Token de seguridad inválido. Recargue la página e intente nuevamente.',
        'type' => 'security_error'
    ]);
    exit;
}

try {
    // Debug: Log received data
    error_log("Procesamiento múltiple de signos vitales - Datos recibidos: " . json_encode($_POST));
    
    // Verificar si se recibieron múltiples signos vitales
    $signos_vitales = [];
    
    if (isset($_POST['signos_vitales']) && is_array($_POST['signos_vitales'])) {
        // Datos enviados como array estructurado
        $signos_vitales = $_POST['signos_vitales'];
    } else {
        // Crear un array con un solo registro
        $signos_vitales[] = [
            'sistg' => $_POST['sistg'] ?? '',
            'diastg' => $_POST['diastg'] ?? '',
            'fcardg' => $_POST['fcardg'] ?? '',
            'frespg' => $_POST['frespg'] ?? '',
            'satg' => $_POST['satg'] ?? '',
            'tempg' => $_POST['tempg'] ?? '',
            'hora_signos' => $_POST['hora_signos'] ?? ''
        ];
    }
    
    // Validar que hay signos vitales para procesar
    if (empty($signos_vitales)) {
        echo json_encode([
            'success' => false,
            'message' => '📝 No se encontraron signos vitales para procesar.',
            'type' => 'validation_error'
        ]);
        exit;
    }
    
    // Obtener datos comunes
    $id_usua = filter_var($_POST['id_usua'] ?? 0, FILTER_VALIDATE_INT);
    $id_atencion = filter_var($_POST['id_atencion'] ?? 0, FILTER_VALIDATE_INT);
    
    // Validar IDs comunes
    if ($id_usua === false || $id_atencion === false || $id_usua <= 0 || $id_atencion <= 0) {
        echo json_encode([
            'success' => false,
            'message' => '🔢 Los identificadores de usuario y atención son requeridos.',
            'type' => 'validation_error'
        ]);
        exit;
    }
    
    // Procesar tratamientos seleccionados
    $tratamientos_ids = [];
    if (isset($_POST['tratamientos_ids']) && !empty($_POST['tratamientos_ids'])) {
        $tratamientos_str = trim($_POST['tratamientos_ids']);
        $tratamientos_array = explode(',', $tratamientos_str);
        foreach ($tratamientos_array as $tratamiento_id) {
            $id_tratamiento = filter_var(trim($tratamiento_id), FILTER_VALIDATE_INT);
            if ($id_tratamiento !== false && $id_tratamiento > 0) {
                $tratamientos_ids[] = $id_tratamiento;
            }
        }
    }
    
    // Si no hay tratamientos válidos, usar ID por defecto
    if (empty($tratamientos_ids)) {
        $tratamientos_ids = [1]; // ID por defecto para signos vitales
    }
    
    // Verificar si es una actualización específica de un registro existente
    $es_actualizacion_especifica = isset($_POST['es_actualizacion']) && $_POST['es_actualizacion'] === '1';
    $id_trans_graf_especifico = null;
    
    if ($es_actualizacion_especifica && isset($_POST['id_trans_graf'])) {
        $id_trans_graf_especifico = filter_var($_POST['id_trans_graf'], FILTER_VALIDATE_INT);
        if ($id_trans_graf_especifico === false) {
            echo json_encode([
                'success' => false,
                'message' => '🔢 ID de registro inválido para actualización.',
                'type' => 'validation_error'
            ]);
            exit;
        }
    }
    
    $conexion->autocommit(false); // Start transaction
    $registros_procesados = 0;
    $registros_exitosos = 0;
    $registros_actualizados = 0;
    $registros_insertados = 0;
    $errores = [];
    $detalles_procesamiento = [];
    
    try {
        foreach ($signos_vitales as $index => $signo) {
            $registros_procesados++;
            
            // Validar y sanitizar cada signo vital
            $sistolica = filter_var($signo['sistg'], FILTER_VALIDATE_INT);
            $diastolica = filter_var($signo['diastg'], FILTER_VALIDATE_INT);
            $freq_cardiaca = filter_var($signo['fcardg'], FILTER_VALIDATE_INT);
            $freq_respiratoria = filter_var($signo['frespg'], FILTER_VALIDATE_INT);
            $saturacion = filter_var($signo['satg'], FILTER_VALIDATE_INT);
            $temperatura = filter_var($signo['tempg'], FILTER_VALIDATE_FLOAT);
            $hora_signos = htmlspecialchars(trim($signo['hora_signos']), ENT_QUOTES, 'UTF-8');
            
            // Validar rangos
            $errores_signo = [];
            
            if ($sistolica === false || $sistolica < 50 || $sistolica > 200) {
                $errores_signo[] = "Presión sistólica inválida (50-200 mmHg)";
            }
            if ($diastolica === false || $diastolica < 30 || $diastolica > 120) {
                $errores_signo[] = "Presión diastólica inválida (30-120 mmHg)";
            }
            if ($freq_cardiaca === false || $freq_cardiaca < 30 || $freq_cardiaca > 200) {
                $errores_signo[] = "Frecuencia cardíaca inválida (30-200 bpm)";
            }
            if ($freq_respiratoria === false || $freq_respiratoria < 8 || $freq_respiratoria > 40) {
                $errores_signo[] = "Frecuencia respiratoria inválida (8-40 rpm)";
            }
            if ($saturacion === false || $saturacion < 50 || $saturacion > 100) {
                $errores_signo[] = "Saturación inválida (50-100%)";
            }
            if ($temperatura === false || $temperatura < 34 || $temperatura > 42) {
                $errores_signo[] = "Temperatura inválida (34-42°C)";
            }
            if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $hora_signos)) {
                $errores_signo[] = "Formato de hora inválido (HH:MM)";
            }
            
            if (!empty($errores_signo)) {
                $errores[] = "Registro " . ($index + 1) . " ($hora_signos): " . implode(', ', $errores_signo);
                continue;
            }
            
            // Si es una actualización específica
            if ($es_actualizacion_especifica && $id_trans_graf_especifico && count($signos_vitales) === 1) {
                $sql_update_especifico = "UPDATE dat_trans_grafico 
                                         SET sistg = ?, diastg = ?, fcardg = ?, frespg = ?, 
                                             satg = ?, tempg = ?, fecha_g = NOW()
                                         WHERE id_trans_graf = ?";
                
                $stmt_update_especifico = $conexion->prepare($sql_update_especifico);
                if ($stmt_update_especifico) {
                    $stmt_update_especifico->bind_param("iiiiddi", 
                        $sistolica, $diastolica, $freq_cardiaca, $freq_respiratoria, 
                        $saturacion, $temperatura, $id_trans_graf_especifico
                    );
                    
                    if ($stmt_update_especifico->execute() && $stmt_update_especifico->affected_rows > 0) {
                        $registros_exitosos++;
                        $registros_actualizados++;
                        $detalles_procesamiento[] = "Actualizado registro ID $id_trans_graf_especifico ($hora_signos)";
                    } else {
                        $errores[] = "Registro " . ($index + 1) . ": No se pudo actualizar el registro específico";
                    }
                    $stmt_update_especifico->close();
                } else {
                    $errores[] = "Registro " . ($index + 1) . ": Error al preparar consulta de actualización";
                }
            } else {
                // Inserción normal para cada tratamiento
                foreach ($tratamientos_ids as $id_tratamiento) {
                    // Verificar si ya existe un registro para este tratamiento, hora y fecha
                    $sql_check = "SELECT id_trans_graf FROM dat_trans_grafico 
                                  WHERE id_atencion = ? AND id_tratamiento = ? 
                                  AND hora = ? AND DATE(fecha_g) = CURDATE()";
                    
                    $stmt_check = $conexion->prepare($sql_check);
                    $registro_existente = null;
                    
                    if ($stmt_check) {
                        $stmt_check->bind_param("iis", $id_atencion, $id_tratamiento, $hora_signos);
                        $stmt_check->execute();
                        $result_check = $stmt_check->get_result();
                        if ($row = $result_check->fetch_assoc()) {
                            $registro_existente = $row['id_trans_graf'];
                        }
                        $stmt_check->close();
                    }
                    
                    if ($registro_existente) {
                        // Actualizar registro existente
                        $sql_update = "UPDATE dat_trans_grafico 
                                      SET sistg = ?, diastg = ?, fcardg = ?, frespg = ?, 
                                          satg = ?, tempg = ?, fecha_g = NOW()
                                      WHERE id_trans_graf = ?";
                        
                        $stmt_update = $conexion->prepare($sql_update);
                        if ($stmt_update) {
                            $stmt_update->bind_param("iiiiddi", 
                                $sistolica, $diastolica, $freq_cardiaca, $freq_respiratoria, 
                                $saturacion, $temperatura, $registro_existente
                            );
                            
                            if ($stmt_update->execute() && $stmt_update->affected_rows > 0) {
                                $registros_actualizados++;
                                $detalles_procesamiento[] = "Actualizado: Tratamiento $id_tratamiento a las $hora_signos";
                            }
                            $stmt_update->close();
                        }
                    } else {
                        // Insertar nuevo registro
                        $sql_insert = "INSERT INTO dat_trans_grafico 
                                      (id_atencion, id_usua, id_tratamiento, hora, sistg, diastg, 
                                       fcardg, frespg, satg, tempg, fecha_g, cuenta) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1)";
                        
                        $stmt_insert = $conexion->prepare($sql_insert);
                        if ($stmt_insert) {
                            $stmt_insert->bind_param("iiisiiiidd", 
                                $id_atencion, $id_usua, $id_tratamiento, $hora_signos,
                                $sistolica, $diastolica, $freq_cardiaca, $freq_respiratoria, 
                                $saturacion, $temperatura
                            );
                            
                            if ($stmt_insert->execute()) {
                                $registros_insertados++;
                                $detalles_procesamiento[] = "Insertado: Tratamiento $id_tratamiento a las $hora_signos";
                            }
                            $stmt_insert->close();
                        }
                    }
                }
                
                if ($registros_actualizados > 0 || $registros_insertados > 0) {
                    $registros_exitosos++;
                }
            }
        }
        
        $total_operaciones = $registros_actualizados + $registros_insertados;
        
        if ($total_operaciones > 0 && empty($errores)) {
            $conexion->commit();
            
            // Crear mensaje de éxito
            if ($es_actualizacion_especifica) {
                $mensaje = "🔄 Registro actualizado correctamente.";
                $detalles = "Se actualizó el registro específico con los nuevos valores.";
            } else if ($registros_actualizados > 0 && $registros_insertados > 0) {
                $mensaje = "✅ Signos vitales procesados correctamente.";
                $detalles = "Se actualizaron $registros_actualizados y se insertaron $registros_insertados registros.";
            } else if ($registros_actualizados > 0) {
                $mensaje = "🔄 Signos vitales actualizados correctamente.";
                $detalles = "Se actualizaron $registros_actualizados registros existentes.";
            } else {
                $mensaje = "💾 Signos vitales guardados correctamente.";
                $detalles = "Se insertaron $registros_insertados nuevos registros.";
            }
            
            echo json_encode([
                'success' => true,
                'message' => $mensaje,
                'details' => $detalles,
                'type' => 'success',
                'registros_procesados' => $registros_procesados,
                'registros_exitosos' => $registros_exitosos,
                'registros_actualizados' => $registros_actualizados,
                'registros_insertados' => $registros_insertados,
                'total_operaciones' => $total_operaciones,
                'detalles_procesamiento' => $detalles_procesamiento,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
        } else {
            $conexion->rollback();
            
            $mensaje_error = "❌ Error al procesar signos vitales.";
            if (!empty($errores)) {
                $mensaje_error .= "\n\nErrores encontrados:\n• " . implode("\n• ", $errores);
            }
            
            echo json_encode([
                'success' => false,
                'message' => $mensaje_error,
                'type' => 'processing_error',
                'registros_procesados' => $registros_procesados,
                'registros_exitosos' => $registros_exitosos,
                'errores' => $errores
            ]);
        }
        
    } catch (Exception $e) {
        $conexion->rollback();
        error_log("Error en transacción múltiple: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => '🔥 Error crítico en el procesamiento múltiple.',
            'type' => 'transaction_error',
            'details' => $e->getMessage()
        ]);
    }
    
} catch (Exception $e) {
    error_log("Error en guardar_signos_multiples.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => '⚠️ Error interno del servidor.',
        'type' => 'server_error',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
} finally {
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>
