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
    error_log("Insertar signos vitales - Datos recibidos: " . json_encode($_POST));
    
    // Validate required fields
    $required_fields = ['sistg', 'diastg', 'fcardg', 'frespg', 'satg', 'tempg', 'hora_signos', 'id_usua', 'id_atencion'];
    
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            $field_names = [
                'sistg' => 'Presión Sistólica',
                'diastg' => 'Presión Diastólica', 
                'fcardg' => 'Frecuencia Cardíaca',
                'frespg' => 'Frecuencia Respiratoria',
                'satg' => 'Saturación de Oxígeno',
                'tempg' => 'Temperatura',
                'hora_signos' => 'Hora',
                'id_usua' => 'Usuario',
                'id_atencion' => 'ID de Atención'
            ];
            $friendly_name = $field_names[$field] ?? $field;
            echo json_encode([
                'success' => false, 
                'message' => "📝 El campo '$friendly_name' es obligatorio.",
                'type' => 'validation_error',
                'field' => $field
            ]);
            exit;
        }
    }

    // Sanitize and validate data
    $sistolica = filter_var($_POST['sistg'], FILTER_VALIDATE_INT);
    $diastolica = filter_var($_POST['diastg'], FILTER_VALIDATE_INT);
    $freq_cardiaca = filter_var($_POST['fcardg'], FILTER_VALIDATE_INT);
    $freq_respiratoria = filter_var($_POST['frespg'], FILTER_VALIDATE_INT);
    $saturacion = filter_var($_POST['satg'], FILTER_VALIDATE_INT);
    $temperatura = filter_var($_POST['tempg'], FILTER_VALIDATE_FLOAT);
    $hora_signos = htmlspecialchars(trim($_POST['hora_signos']), ENT_QUOTES, 'UTF-8');
    $id_usua = filter_var($_POST['id_usua'], FILTER_VALIDATE_INT);
    $id_atencion = filter_var($_POST['id_atencion'], FILTER_VALIDATE_INT);
    
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

    // Validate numeric ranges
    if ($sistolica === false || $sistolica < 50 || $sistolica > 200) {
        echo json_encode([
            'success' => false, 
            'message' => '💓 La presión sistólica debe estar entre 50 y 200 mmHg.',
            'type' => 'range_error',
            'field' => 'sistolica',
            'value' => $_POST['sistg'],
            'range' => '50-200 mmHg'
        ]);
        exit;
    }

    if ($diastolica === false || $diastolica < 30 || $diastolica > 120) {
        echo json_encode([
            'success' => false, 
            'message' => '💓 La presión diastólica debe estar entre 30 y 120 mmHg.',
            'type' => 'range_error',
            'field' => 'diastolica',
            'value' => $_POST['diastg'],
            'range' => '30-120 mmHg'
        ]);
        exit;
    }

    if ($freq_cardiaca === false || $freq_cardiaca < 30 || $freq_cardiaca > 200) {
        echo json_encode([
            'success' => false, 
            'message' => '💗 La frecuencia cardíaca debe estar entre 30 y 200 bpm.',
            'type' => 'range_error',
            'field' => 'freq_cardiaca',
            'value' => $_POST['fcardg'],
            'range' => '30-200 bpm'
        ]);
        exit;
    }

    if ($freq_respiratoria === false || $freq_respiratoria < 8 || $freq_respiratoria > 40) {
        echo json_encode([
            'success' => false, 
            'message' => '🫁 La frecuencia respiratoria debe estar entre 8 y 40 rpm.',
            'type' => 'range_error',
            'field' => 'freq_respiratoria',
            'value' => $_POST['frespg'],
            'range' => '8-40 rpm'
        ]);
        exit;
    }

    if ($saturacion === false || $saturacion < 50 || $saturacion > 100) {
        echo json_encode([
            'success' => false, 
            'message' => '🫁 La saturación de oxígeno debe estar entre 50% y 100%.',
            'type' => 'range_error',
            'field' => 'saturacion',
            'value' => $_POST['satg'],
            'range' => '50-100%'
        ]);
        exit;
    }

    if ($temperatura === false || $temperatura < 34 || $temperatura > 42) {
        echo json_encode([
            'success' => false, 
            'message' => '🌡️ La temperatura debe estar entre 34°C y 42°C.',
            'type' => 'range_error',
            'field' => 'temperatura',
            'value' => $_POST['tempg'],
            'range' => '34-42°C'
        ]);
        exit;
    }

    if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $hora_signos)) {
        echo json_encode([
            'success' => false, 
            'message' => '🕐 El formato de hora debe ser HH:MM (24 horas).',
            'type' => 'format_error',
            'field' => 'hora',
            'value' => $hora_signos,
            'format' => 'HH:MM (ejemplo: 14:30)'
        ]);
        exit;
    }

    // Validate IDs
    if ($id_usua === false || $id_atencion === false) {
        echo json_encode([
            'success' => false, 
            'message' => '🔢 Los identificadores no son válidos.',
            'type' => 'validation_error',
            'details' => 'Verifique que los IDs sean números correctos.'
        ]);
        exit;
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
        error_log("Actualización específica solicitada - ID: $id_trans_graf_especifico");
    }

    // Check if there are existing records for these treatments and time today
    // Solo si NO es una actualización específica
    $existing_treatments = [];
    
    if (!$es_actualizacion_especifica) {
        $sql_check = "SELECT id_tratamiento FROM dat_trans_grafico 
                      WHERE id_atencion = ? AND DATE(fecha_g) = CURDATE() 
                      AND hora = ?";
        
        $stmt_check = $conexion->prepare($sql_check);
        
        if ($stmt_check) {
            $stmt_check->bind_param("is", 
                $id_atencion, 
                $hora_signos
            );
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            
            while ($row = $result_check->fetch_assoc()) {
                $existing_treatments[] = (int)$row['id_tratamiento'];
            }
            $stmt_check->close();
            
            // Debug log
            error_log("Tratamientos existentes encontrados: " . json_encode($existing_treatments));
            error_log("Tratamientos seleccionados: " . json_encode($tratamientos_ids));
        }
    }

    $conexion->autocommit(false); // Start transaction
    $registros_actualizados = 0;
    $registros_insertados = 0;
    $errores = [];

    try {
        // Si es una actualización específica de un registro existente
        if ($es_actualizacion_especifica && $id_trans_graf_especifico) {
            error_log("Procesando actualización específica - ID: $id_trans_graf_especifico");
            
            $sql_update_especifico = "UPDATE dat_trans_grafico 
                                     SET sistg = ?, diastg = ?, fcardg = ?, frespg = ?, 
                                         satg = ?, tempg = ?, fecha_g = NOW()
                                     WHERE id_trans_graf = ?";
            
            $stmt_update_especifico = $conexion->prepare($sql_update_especifico);
            if ($stmt_update_especifico) {
                error_log("Actualizando registro específico - Valores: Sistólica: $sistolica, Diastólica: $diastolica, FC: $freq_cardiaca, FR: $freq_respiratoria, Sat: $saturacion, Temp: $temperatura");
                
                $stmt_update_especifico->bind_param("iiiiddi", 
                    $sistolica, 
                    $diastolica, 
                    $freq_cardiaca, 
                    $freq_respiratoria, 
                    $saturacion, 
                    $temperatura,
                    $id_trans_graf_especifico
                );

                if ($stmt_update_especifico->execute()) {
                    $filas_afectadas = $stmt_update_especifico->affected_rows;
                    error_log("Actualización específica ejecutada - Filas afectadas: $filas_afectadas");
                    if ($filas_afectadas > 0) {
                        $registros_actualizados++;
                    } else {
                        error_log("ADVERTENCIA: La actualización específica no afectó ninguna fila");
                    }
                } else {
                    $errores[] = "Error al actualizar registro específico ID $id_trans_graf_especifico: " . $stmt_update_especifico->error;
                    error_log("Error SQL en actualización específica: " . $stmt_update_especifico->error);
                }
                $stmt_update_especifico->close();
            } else {
                $errores[] = "Error al preparar consulta de actualización específica: " . $conexion->error;
            }
        }
        // Si NO es actualización específica, usar la lógica original
        else if (!empty($existing_treatments)) {
            $sql_update = "UPDATE dat_trans_grafico 
                          SET sistg = ?, diastg = ?, fcardg = ?, frespg = ?, 
                              satg = ?, tempg = ?, fecha_g = NOW()
                          WHERE id_atencion = ? AND id_tratamiento = ? AND hora = ? 
                          AND DATE(fecha_g) = CURDATE()";
            
            $stmt_update = $conexion->prepare($sql_update);
            if ($stmt_update) {
                // Update existing treatments
                foreach ($existing_treatments as $id_tratamiento) {
                    if (in_array($id_tratamiento, $tratamientos_ids)) {
                        error_log("Intentando actualizar - ID Atencion: $id_atencion, ID Tratamiento: $id_tratamiento, Hora: $hora_signos");
                        error_log("Valores a actualizar - Sistólica: $sistolica, Diastólica: $diastolica, FC: $freq_cardiaca, FR: $freq_respiratoria, Sat: $saturacion, Temp: $temperatura");
                        
                        $stmt_update->bind_param("iiiiddiis", 
                            $sistolica, 
                            $diastolica, 
                            $freq_cardiaca, 
                            $freq_respiratoria, 
                            $saturacion, 
                            $temperatura,
                            $id_atencion,
                            $id_tratamiento,
                            $hora_signos
                        );

                        if ($stmt_update->execute()) {
                            $filas_afectadas = $stmt_update->affected_rows;
                            error_log("Actualización ejecutada - Filas afectadas: $filas_afectadas");
                            if ($filas_afectadas > 0) {
                                $registros_actualizados++;
                            } else {
                                error_log("ADVERTENCIA: La consulta UPDATE no afectó ninguna fila");
                                // Verificar si realmente existe el registro
                                $sql_verify = "SELECT id_trans_graf FROM dat_trans_grafico 
                                              WHERE id_atencion = ? AND id_tratamiento = ? AND hora = ? 
                                              AND DATE(fecha_g) = CURDATE()";
                                $stmt_verify = $conexion->prepare($sql_verify);
                                if ($stmt_verify) {
                                    $stmt_verify->bind_param("iis", $id_atencion, $id_tratamiento, $hora_signos);
                                    $stmt_verify->execute();
                                    $result_verify = $stmt_verify->get_result();
                                    if ($result_verify->num_rows > 0) {
                                        error_log("El registro SÍ existe pero no se actualizó - posible problema con los valores");
                                    } else {
                                        error_log("El registro NO existe - se debería insertar");
                                    }
                                    $stmt_verify->close();
                                }
                            }
                        } else {
                            $errores[] = "Error al actualizar tratamiento ID $id_tratamiento: " . $stmt_update->error;
                            error_log("Error SQL en actualización: " . $stmt_update->error);
                        }
                    }
                }
                $stmt_update->close();
            }
        }

        // Insert new treatments that don't have existing records
        // Solo si NO es actualización específica
        if (!$es_actualizacion_especifica) {
            $new_treatments = array_diff($tratamientos_ids, $existing_treatments);
            
            if (!empty($new_treatments)) {
                $sql_insert = "INSERT INTO dat_trans_grafico 
                              (id_atencion, id_usua, id_tratamiento, hora, sistg, diastg, 
                               fcardg, frespg, satg, tempg, fecha_g, cuenta) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1)";
                
                $stmt_insert = $conexion->prepare($sql_insert);
                if ($stmt_insert) {
                    foreach ($new_treatments as $id_tratamiento) {
                        $stmt_insert->bind_param("iiisiiiidd", 
                            $id_atencion, 
                            $id_usua, 
                            $id_tratamiento,
                            $hora_signos,
                            $sistolica, 
                            $diastolica, 
                            $freq_cardiaca, 
                            $freq_respiratoria, 
                            $saturacion, 
                            $temperatura
                        );

                        if ($stmt_insert->execute()) {
                            $registros_insertados++;
                        } else {
                            $errores[] = "Error al insertar tratamiento ID $id_tratamiento: " . $stmt_insert->error;
                        }
                    }
                    $stmt_insert->close();
                }
            }
        }

        if (($registros_actualizados > 0 || $registros_insertados > 0) && empty($errores)) {
            $conexion->commit();
            
            // Crear mensaje personalizado basado en la operación realizada
            if ($es_actualizacion_especifica && $registros_actualizados > 0) {
                $mensaje = "🔄 Registro de signos vitales actualizado correctamente.";
                $detalles = "Se actualizó el registro específico ID $id_trans_graf_especifico con los nuevos valores.";
                $tipo_operacion = "Actualización específica";
            } elseif ($registros_actualizados > 0 && $registros_insertados > 0) {
                $mensaje = "✅ Signos vitales procesados correctamente.";
                $detalles = "Se actualizaron $registros_actualizados registro(s) existente(s) y se insertaron $registros_insertados registro(s) nuevo(s).";
                $tipo_operacion = "Mixta (actualización + inserción)";
            } elseif ($registros_actualizados > 0) {
                $mensaje = "🔄 Signos vitales actualizados correctamente.";
                $detalles = "Se actualizaron $registros_actualizados registro(s) existente(s) con los nuevos valores.";
                $tipo_operacion = "Actualización";
            } elseif ($registros_insertados > 0) {
                $mensaje = "💾 Signos vitales guardados correctamente.";
                $detalles = "Se insertaron $registros_insertados registro(s) nuevo(s) en el sistema.";
                $tipo_operacion = "Inserción";
            } else {
                $mensaje = "ℹ️ Operación completada.";
                $detalles = "No se requirieron cambios en los datos existentes.";
                $tipo_operacion = "Sin cambios";
            }
            
            echo json_encode([
                'success' => true, 
                'message' => $mensaje,
                'details' => $detalles,
                'type' => 'success',
                'operation_type' => $tipo_operacion,
                'registros_actualizados' => $registros_actualizados,
                'registros_insertados' => $registros_insertados,
                'tratamientos_ids' => $tratamientos_ids,
                'es_actualizacion_especifica' => $es_actualizacion_especifica,
                'id_trans_graf_actualizado' => $id_trans_graf_especifico,
                'timestamp' => date('Y-m-d H:i:s'),
                'data' => [
                    'sistolica' => $sistolica,
                    'diastolica' => $diastolica,
                    'freq_cardiaca' => $freq_cardiaca,
                    'freq_respiratoria' => $freq_respiratoria,
                    'saturacion' => $saturacion,
                    'temperatura' => $temperatura,
                    'hora' => $hora_signos
                ],
                'summary' => [
                    'total_tratamientos' => count($tratamientos_ids),
                    'operacion_exitosa' => true,
                    'datos_validados' => true
                ]
            ]);
        } else {
            $conexion->rollback();
            echo json_encode([
                'success' => false, 
                'message' => '❌ Error al procesar los signos vitales.',
                'type' => 'processing_error',
                'details' => 'Se produjeron errores durante el procesamiento: ' . implode(', ', $errores),
                'error_count' => count($errores),
                'registros_procesados' => $registros_actualizados + $registros_insertados,
                'suggestions' => [
                    'Verifique que todos los datos sean correctos',
                    'Intente nuevamente',
                    'Si el problema persiste, contacte al administrador'
                ]
            ]);
        }

    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode([
            'success' => false, 
            'message' => '🔥 Error crítico en la transacción de base de datos.',
            'type' => 'transaction_error',
            'details' => 'Error inesperado: ' . $e->getMessage(),
            'error_code' => $e->getCode(),
            'action' => 'retry_operation'
        ]);
    }

} catch (Exception $e) {
    error_log("Error en insertar_signos_vitales.php: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => '⚠️ Error interno del servidor.',
        'type' => 'server_error',
        'details' => 'Se ha producido un error interno. El equipo técnico ha sido notificado.',
        'timestamp' => date('Y-m-d H:i:s'),
        'action' => 'contact_support'
    ]);
} finally {
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>
