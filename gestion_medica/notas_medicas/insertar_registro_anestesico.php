<?php
session_start();
include "../../conexionbd.php"; // Ensure this file sets mysqli_set_charset($conexion, 'utf8mb4')

// Redirect if user not logged in or hospital session not set
if (!isset($_SESSION['login']['id_usua']) || !isset($_SESSION['hospital'])) {
    header("Location: ../../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize error array
    $errors = [];
    $data = [];

    // --- Sanitize and Collect POST Data ---
    // IDs and Foreign Keys
    $data['id_atencion'] = filter_var($_POST['id_atencion'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $data['Id_exp'] = filter_var($_POST['Id_exp'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $data['id_usua'] = filter_var($_POST['id_usua'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $data['anestesiologo_id'] = filter_var($_POST['anestesiologo_id'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $data['cirujano_id'] = filter_var($_POST['cirujano_id'] ?? '', FILTER_SANITIZE_NUMBER_INT);

    // Ayudantes (multiple selection)
    $data['ayudantes_ids'] = isset($_POST['ayudantes_ids']) && is_array($_POST['ayudantes_ids']) 
        ? array_map('intval', $_POST['ayudantes_ids']) : [];

    // General Information
    $data['tipo_anestesia'] = filter_var($_POST['tipo_anestesia'] ?? '', FILTER_SANITIZE_STRING);
    $data['diagnostico_preoperatorio'] = filter_var($_POST['diagnostico_preoperatorio'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['desc_diagnostico_preoperatorio'] = filter_var($_POST['desc_diagnostico_preoperatorio'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['cirugia_programada'] = filter_var($_POST['cirugia_programada'] ?? '', FILTER_SANITIZE_STRING);
    $data['diagnostico_postoperatorio'] = filter_var($_POST['diagnostico_postoperatorio'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['desc_diagnostico_postoperatorio'] = filter_var($_POST['desc_diagnostico_postoperatorio'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['cirugia_realizada'] = filter_var($_POST['cirugia_realizada'] ?? '', FILTER_SANITIZE_STRING) ?: null;

    // Anesthesia Details
    $data['revision_equipo'] = filter_var($_POST['revision_equipo'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['o2_hora'] = !empty($_POST['o2_hora']) ? date('H:i:s', strtotime($_POST['o2_hora'])) : null;
    $data['agente_inhalado'] = filter_var($_POST['agente_inhalado'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    // Monitoreo Continuo (Checkboxes)
    $data['ecg_continua'] = isset($_POST['ecg_continua']) && $_POST['ecg_continua'] === '1' ? 1 : 0;
    $data['pulsoximetria'] = isset($_POST['pulsoximetria']) && $_POST['pulsoximetria'] === '1' ? 1 : 0;
    $data['capnografia'] = isset($_POST['capnografia']) && $_POST['capnografia'] === '1' ? 1 : 0;

    // Intubation and Ventilation
    $data['intubacion'] = filter_var($_POST['intubacion'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['incidentes'] = filter_var($_POST['incidentes'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['canula'] = filter_var($_POST['canula'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['dificultad_tecnica'] = filter_var($_POST['dificultad_tecnica'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['ventilacion'] = filter_var($_POST['ventilacion'] ?? '', FILTER_SANITIZE_STRING) ?: null;

    // Fluids Balance
    $fluid_fields = ['hartmann', 'glucosa', 'nacl', 'diuresis', 'sangrado', 'perdidas_insensibles', 'total_ingresos', 'total_egresos', 'balance'];
    foreach ($fluid_fields as $field) {
        $data[$field] = filter_var($_POST[$field] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) ?: null;
    }

    // Aldrete Score
    $aldrete_fields = ['aldrete_actividad', 'aldrete_respiracion', 'aldrete_circulacion', 'aldrete_conciencia', 'aldrete_saturacion'];
    foreach ($aldrete_fields as $field) {
        $value = filter_var($_POST[$field] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 2]]) ?: null;
        $data[$field] = $value;
    }
    $data['aldrete_total'] = filter_var($_POST['aldrete_total'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 10]]) ?: null;

    // Regional Anesthesia
    $data['anestesia_regional_tipo'] = filter_var($_POST['anestesia_regional_tipo'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['aguja'] = filter_var($_POST['aguja'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['nivel_puncion'] = filter_var($_POST['nivel_puncion'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['cateter'] = filter_var($_POST['cateter'] ?? '', FILTER_SANITIZE_STRING) ?: null;
    $data['agentes_administrados'] = filter_var($_POST['agentes_administrados'] ?? '', FILTER_SANITIZE_STRING) ?: null;

    // Timings
    $time_fields = ['llega_quirofano', 'inicia_anestesia', 'inicia_cirugia', 'termina_cirugia', 'termina_anestesia', 'pasa_recuperacion'];
    foreach ($time_fields as $field) {
        $time_str = $_POST[$field] ?? '';
        $data[$field] = !empty($time_str) ? date('Y-m-d H:i:s', strtotime($time_str)) : null;
    }
    $data['tiempo_anestesico'] = filter_var($_POST['tiempo_anestesico'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) ?: null;

    // Date Field
    $data['fecha_registro'] = date('Y-m-d H:i:s'); // Current timestamp

    // --- Validate Required Fields ---
    if (empty($data['id_atencion'])) $errors[] = "El ID de atención es obligatorio.";
    if (empty($data['Id_exp'])) $errors[] = "El ID de expediente es obligatorio.";
    if (empty($data['id_usua'])) $errors[] = "El ID de usuario es obligatorio.";
    if (empty($data['anestesiologo_id'])) $errors[] = "El anestesiólogo es obligatorio.";
    if (empty($data['cirujano_id'])) $errors[] = "El cirujano es obligatorio.";
    if (empty($data['tipo_anestesia'])) $errors[] = "El tipo de anestesia es obligatorio.";
    /* if (empty($data['cirugia_programada'])) $errors[] = "La cirugía programada es obligatoria."; */

    // Validate specific fields
    if (!empty($data['tipo_anestesia']) && !in_array($data['tipo_anestesia'], ['General', 'Regional', 'Local', 'Sedación'])) {
        $errors[] = "Seleccione un tipo de anestesia válido: General, Regional, Local, Sedación.";
    }
    if (!empty($data['revision_equipo']) && !in_array($data['revision_equipo'], ['OK', 'No OK'])) {
        $errors[] = "Seleccione un estado válido para la revisión del equipo: OK o No OK.";
    }
    if (!empty($data['dificultad_tecnica']) && !in_array($data['dificultad_tecnica'], ['Sí', 'No'])) {
        $errors[] = "Seleccione un valor válido para dificultad técnica: Sí o No.";
    }
    if (!empty($data['cateter']) && !in_array($data['cateter'], ['Sí', 'No'])) {
        $errors[] = "Seleccione un valor válido para catéter: Sí o No.";
    }
    if (!empty($data['anestesia_regional_tipo']) && !in_array($data['anestesia_regional_tipo'], ['Ninguna', 'Peribulbar', 'Retrobulbar', 'Subtenoniana'])) {
        $errors[] = "Seleccione un tipo de anestesia regional válido.";
    }

    // Validate numeric fields if provided
    $numeric_fields = [
        'hartmann' => ['min' => 0, 'max' => 10000, 'label' => 'Hartmann'],
        'glucosa' => ['min' => 0, 'max' => 10000, 'label' => 'Glucosa'],
        'nacl' => ['min' => 0, 'max' => 10000, 'label' => 'NaCl'],
        'diuresis' => ['min' => 0, 'max' => 10000, 'label' => 'Diuresis'],
        'sangrado' => ['min' => 0, 'max' => 10000, 'label' => 'Sangrado'],
        'perdidas_insensibles' => ['min' => 0, 'max' => 10000, 'label' => 'Pérdidas Insensibles'],
        'total_ingresos' => ['min' => 0, 'max' => 30000, 'label' => 'Total Ingresos'],
        'total_egresos' => ['min' => 0, 'max' => 30000, 'label' => 'Total Egresos'],
        'balance' => ['min' => -30000, 'max' => 30000, 'label' => 'Balance'],
        'aldrete_total' => ['min' => 0, 'max' => 10, 'label' => 'Puntuación Aldrete Total'],
        'tiempo_anestesico' => ['min' => 0, 'max' => 1440, 'label' => 'Tiempo Anestésico']
    ];
    foreach ($numeric_fields as $field => $constraints) {
        if (!is_null($data[$field]) && ($data[$field] < $constraints['min'] || $data[$field] > $constraints['max'])) {
            $errors[] = "{$constraints['label']} debe estar entre {$constraints['min']} y {$constraints['max']}.";
        }
    }

    // Validate Aldrete fields if provided
    foreach ($aldrete_fields as $field) {
        if (!is_null($data[$field]) && !in_array($data[$field], [0, 1, 2])) {
            $errors[] = "El campo '{$field}' del score Aldrete debe ser 0, 1 o 2.";
        }
    }

    // --- Insert Data into Database ---
    if (empty($errors)) {
        $conexion->begin_transaction();
        try {
            // Define main table columns
            $columns = [
                'id_atencion', 'Id_exp', 'id_usua', 'anestesiologo_id', 'cirujano_id', 'tipo_anestesia',
                'diagnostico_preoperatorio', 'desc_diagnostico_preoperatorio', 'cirugia_programada',
                'diagnostico_postoperatorio', 'desc_diagnostico_postoperatorio', 'cirugia_realizada',
                'revision_equipo', 'o2_hora', 'agente_inhalado', 'ecg_continua', 'pulsoximetria', 'capnografia',
                'intubacion', 'incidentes', 'canula', 'dificultad_tecnica', 'ventilacion',
                'hartmann', 'glucosa', 'nacl', 'diuresis', 'sangrado', 'perdidas_insensibles',
                'total_ingresos', 'total_egresos', 'balance',
                'aldrete_actividad', 'aldrete_respiracion', 'aldrete_circulacion', 'aldrete_conciencia', 'aldrete_saturacion', 'aldrete_total',
                'anestesia_regional_tipo', 'aguja', 'nivel_puncion', 'cateter', 'agentes_administrados',
                'llega_quirofano', 'inicia_anestesia', 'inicia_cirugia', 'termina_cirugia', 'termina_anestesia', 'pasa_recuperacion',
                'tiempo_anestesico', 'fecha_registro'
            ];

            // Prepare values and types for main table
            $placeholders = implode(', ', array_fill(0, count($columns), '?'));
            $sql = "INSERT INTO registro_anestesico (" . implode(', ', $columns) . ") VALUES ($placeholders)";
            $stmt = $conexion->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error preparando consulta principal: " . $conexion->error);
            }

            // Prepare values and types
            $values = [];
            $types = '';
            foreach ($columns as $col) {
                $val = $data[$col];
                $values[] = $val;
                if (in_array($col, ['id_atencion', 'Id_exp', 'id_usua', 'anestesiologo_id', 'cirujano_id', 'ecg_continua', 'pulsoximetria', 'capnografia', 'hartmann', 'glucosa', 'nacl', 'diuresis', 'sangrado', 'perdidas_insensibles', 'total_ingresos', 'total_egresos', 'balance', 'aldrete_actividad', 'aldrete_respiracion', 'aldrete_circulacion', 'aldrete_conciencia', 'aldrete_saturacion', 'aldrete_total', 'tiempo_anestesico'])) {
                    $types .= 'i'; // Integer
                } else {
                    $types .= 's'; // String or NULL
                }
            }

            // Bind parameters
            $bind_params = array_merge([$types], $values);
            call_user_func_array([$stmt, 'bind_param'], refValues($bind_params));

            // Execute main query
            if (!$stmt->execute()) {
                throw new Exception("Error ejecutando consulta principal: " . $stmt->error);
            }
            $registro_anestesico_id = $conexion->insert_id;
            $stmt->close();

            // Insert ayudantes into related table
            if (!empty($data['ayudantes_ids'])) {
                $sql_ayudantes = "INSERT INTO registro_anestesico_ayudantes (registro_anestesico_id, id_usua) VALUES (?, ?)";
                $stmt_ayudantes = $conexion->prepare($sql_ayudantes);
                if ($stmt_ayudantes === false) {
                    throw new Exception("Error preparando consulta de ayudantes: " . $conexion->error);
                }

                foreach ($data['ayudantes_ids'] as $ayudante_id) {
                    $stmt_ayudantes->bind_param('ii', $registro_anestesico_id, $ayudante_id);
                    if (!$stmt_ayudantes->execute()) {
                        throw new Exception("Error insertando ayudante ID $ayudante_id: " . $stmt_ayudantes->error);
                    }
                }
                $stmt_ayudantes->close();
            }

            // Commit transaction
            $conexion->commit();
            $_SESSION['message'] = "Registro anestésico guardado exitosamente.";
            $_SESSION['message_type'] = "success";
            header("Location: reg_anestesia.php");
        } catch (Exception $e) {
            $conexion->rollback();
            error_log("Error: " . $e->getMessage(), 3, 'sql_error.log');
            $_SESSION['message'] = "Error al guardar el registro: " . $e->getMessage();
            $_SESSION['message_type'] = "danger";
            header("Location: reg_anestesia.php");
        }
    } else {
        $_SESSION['message'] = implode("<br>", $errors);
        $_SESSION['message_type'] = "danger";
        header("Location: reg_anestesia.php");
    }
} else {
    $_SESSION['message'] = "Método de solicitud no válido.";
    $_SESSION['message_type'] = "danger";
    header("Location: reg_anestesia.php");
}

// Helper function for bind_param
function refValues($arr) {
    if (strnatcmp(phpversion(), '5.3') >= 0) {
        $refs = [];
        foreach ($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }
    return $arr;
}

$conexion->close();
?>