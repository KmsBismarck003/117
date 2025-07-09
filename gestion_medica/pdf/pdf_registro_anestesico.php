<?php
session_start();
include "../../conexionbd.php";
require '../../fpdf/fpdf.php';

if (!isset($_SESSION['login']) || !isset($_SESSION['hospital'])) {
    header("Location: ../login.php");
    exit();
}

$id_registro_anestesico = isset($_GET['id_registro_anestesico']) ? (int)$_GET['id_registro_anestesico'] : 0;
$id_exp = isset($_GET['id_exp']) ? (int)$_GET['id_exp'] : 0;
$id_atencion = isset($_GET['id_atencion']) ? (int)$_GET['id_atencion'] : 0;

if ($id_registro_anestesico <= 0 || $id_exp <= 0 || $id_atencion <= 0) {
    die("ID de registro anestésico, expediente o atención no válido.");
}

// Fetch anesthetic record data
$sql_anest = "SELECT * FROM registro_anestesico WHERE id_registro_anestesico = ? AND id_atencion = ? AND Id_exp = ?";
$stmt_anest = $conexion->prepare($sql_anest);
if (!$stmt_anest) {
    die("Error preparando consulta de registro anestésico: " . $conexion->error);
}
$stmt_anest->bind_param("iii", $id_registro_anestesico, $id_atencion, $id_exp);
$stmt_anest->execute();
$result_anest = $stmt_anest->get_result();
if (!$anest = $result_anest->fetch_assoc()) {
    die("Registro anestésico no encontrado.");
}
$stmt_anest->close();

// Fetch patient data
$sql_pac = "SELECT p.papell, p.sapell, p.nom_pac, p.fecnac, p.folio, p.sexo, p.tel, p.ocup, p.dir, di.fecha, di.tipo_a 
            FROM paciente p 
            JOIN dat_ingreso di ON p.Id_exp = di.Id_exp 
            WHERE di.id_atencion = ?";
$stmt_pac = $conexion->prepare($sql_pac);
if (!$stmt_pac) {
    die("Error preparando consulta de paciente: " . $conexion->error);
}
$stmt_pac->bind_param("i", $id_atencion);
$stmt_pac->execute();
$result_pac = $stmt_pac->get_result();
if (!$row_pac = $result_pac->fetch_assoc()) {
    die("Paciente no encontrado.");
}
$tipo_a = $row_pac['tipo_a'];
$pac_papell = $row_pac['papell'];
$pac_sapell = $row_pac['sapell'];
$pac_nom_pac = $row_pac['nom_pac'];
$pac_fecnac = $row_pac['fecnac'] ?? null;
$folio = $row_pac['folio'];
$pac_fecing = $row_pac['fecha'];
$pac_sexo = $row_pac['sexo'];
$pac_tel = $row_pac['tel'] ?? 'No especificado';
$pac_ocup = $row_pac['ocup'] ?? 'No especificado';
$pac_dir = $row_pac['dir'] ?? 'No especificado';
$stmt_pac->close();

// Prepare statement for fetching user data
$sql_doc = "SELECT pre, papell, sapell, nombre, firma, cedp, cargp FROM reg_usuarios WHERE id_usua = ?";
$stmt_doc = $conexion->prepare($sql_doc);
if (!$stmt_doc) {
    die("Error preparando consulta de usuario: " . $conexion->error);
}

// Fetch anesthesiologist data
$stmt_doc->bind_param("i", $anest['anestesiologo_id']);
$stmt_doc->execute();
$result_doc = $stmt_doc->get_result();
$anestesiologo = "Anestesiólogo no asignado";
$pre_anest = '';
$app_anest = '';
$apm_anest = '';
$nom_anest = '';
$firma_anest = '';
$ced_anest = '';
$carg_anest = '';
if ($row_doc = $result_doc->fetch_assoc()) {
    $pre_anest = $row_doc['pre'] ?? '';
    $app_anest = $row_doc['papell'] ?? '';
    $apm_anest = $row_doc['sapell'] ?? '';
    $nom_anest = $row_doc['nombre'] ?? '';
    $firma_anest = $row_doc['firma'] ?? '';
    $ced_anest = $row_doc['cedp'] ?? '';
    $carg_anest = $row_doc['cargp'] ?? '';
    $anestesiologo = ($pre_anest ? $pre_anest . ". " : "") . $app_anest . " " . $apm_anest . " " . $nom_anest;
}

// Fetch surgeon data
$stmt_doc->bind_param("i", $anest['cirujano_id']);
$stmt_doc->execute();
$result_doc = $stmt_doc->get_result();
$cirujano = "Cirujano no asignado";
if ($row_doc = $result_doc->fetch_assoc()) {
    $cirujano = ($row_doc['pre'] ? $row_doc['pre'] . ". " : "") . ($row_doc['papell'] ?? '') . " " . ($row_doc['sapell'] ?? '') . " " . ($row_doc['nombre'] ?? '');
}

// Fetch assistants data from registro_anestesico_ayudantes
$ayudantes = "No especificado";
$sql_ayudantes = "SELECT u.pre, u.papell, u.sapell, u.nombre 
                  FROM registro_anestesico_ayudantes ra 
                  JOIN reg_usuarios u ON ra.id_usua = u.id_usua 
                  WHERE ra.registro_anestesico_id = ?";
$stmt_ayudantes = $conexion->prepare($sql_ayudantes);
if (!$stmt_ayudantes) {
    die("Error preparando consulta de ayudantes: " . $conexion->error);
}
$stmt_ayudantes->bind_param("i", $id_registro_anestesico);
$stmt_ayudantes->execute();
$result_ayudantes = $stmt_ayudantes->get_result();
$ayudantes_list = [];
while ($row_ayudante = $result_ayudantes->fetch_assoc()) {
    $ayudantes_list[] = ($row_ayudante['pre'] ? $row_ayudante['pre'] . ". " : "") . 
                        ($row_ayudante['papell'] ?? '') . " " . 
                        ($row_ayudante['sapell'] ?? '') . " " . 
                        ($row_ayudante['nombre'] ?? '');
}
if (!empty($ayudantes_list)) {
    $ayudantes = implode(', ', $ayudantes_list);
}
$stmt_ayudantes->close();
$stmt_doc->close();

// Calculate age
function calculaedad($fechanacimiento) {
    if (!$fechanacimiento || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechanacimiento)) {
        return 'Edad no disponible';
    }
    $fecha_actual = date("Y-m-d");
    $arr_nac = explode("-", $fechanacimiento);
    $arr_act = explode("-", $fecha_actual);
    $anos = $arr_act[0] - $arr_nac[0];
    $meses = $arr_act[1] - $arr_nac[1];
    $dias = $arr_act[2] - $arr_nac[2];
    if ($dias < 0) {
        $meses--;
        $dias += date("t", strtotime("$arr_act[0]-$arr_act[1]-01"));
    }
    if ($meses < 0) {
        $anos--;
        $meses += 12;
    }
    if ($anos > 0) {
        return $anos . " años";
    } elseif ($meses > 0) {
        return $meses . " meses";
    } else {
        return $dias . " días";
    }
}
$edad = calculaedad($pac_fecnac);

// Current date and time
$fecha_actual = date("d/m/Y H:i");

// Create PDF class
class PDF extends FPDF {
    function Header() {
        global $conexion;
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(40, 40, 40);
        $resultado = $conexion->query("SELECT * FROM img_sistema ORDER BY id_simg DESC LIMIT 1");
        if ($resultado && $f = mysqli_fetch_assoc($resultado)) {
            $this->Image("../../configuracion/admin/img2/{$f['img_ipdf']}", 7, 11, 40, 25);
            $this->Image("../../configuracion/admin/img3/{$f['img_cpdf']}", 58, 15, 109, 24);
            $this->Image("../../configuracion/admin/img4/{$f['img_dpdf']}", 168, 16, 38, 14);
        }
        $this->SetY(35);
        $this->Cell(0, 8, utf8_decode('REGISTRO ANESTÉSICO'), 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 4, utf8_decode('Fecha: ') . date('d/m/Y H:i'), 0, 1, 'R');
        $this->Ln(1);
    }

    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
        $this->Cell(0, 10, utf8_decode('ANEST-000'), 0, 1, 'R');
    }
}

// Generate PDF
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(true, 25);

// Patient Data Section (Full Width)
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(230, 240, 255);
$pdf->Cell(0, 5, 'Datos del Paciente:', 0, 1, 'L', true);
$pdf->SetFont('Arial', '', 7);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(35, 4, 'Servicio:', 0, 0, 'L');
$pdf->Cell(55, 4, utf8_decode($tipo_a), 0, 0, 'L');
$pdf->Cell(35, 4, 'Fecha de registro:', 0, 0, 'L');
$pdf->Cell(0, 4, $pac_fecing ? date('d/m/Y H:i', strtotime($pac_fecing)) : 'N/A', 0, 1, 'L');
$pdf->Cell(35, 4, 'Paciente:', 0, 0, 'L');
$pdf->Cell(55, 4, utf8_decode($folio . ' - ' . $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac), 0, 0, 'L');
$pdf->Cell(35, 4, utf8_decode('Teléfono:'), 0, 0, 'L');
$pdf->Cell(0, 4, utf8_decode($pac_tel), 0, 1, 'L');
$pdf->Cell(35, 4, utf8_decode('Nacimiento:'), 0, 0, 'L');
$pdf->Cell(30, 4, $pac_fecnac ? date('d/m/Y', strtotime($pac_fecnac)) : 'N/A', 0, 0, 'L');
$pdf->Cell(10, 4, utf8_decode('Edad:'), 0, 0, 'L');
$pdf->Cell(15, 4, utf8_decode($edad), 0, 0, 'L');
$pdf->Cell(15, 4, utf8_decode('Género:'), 0, 0, 'L');
$pdf->Cell(20, 4, utf8_decode($pac_sexo), 0, 0, 'L');
$pdf->Cell(20, 4, utf8_decode('Ocupación:'), 0, 0, 'L');
$pdf->Cell(0, 4, utf8_decode($pac_ocup), 0, 1, 'L');
$pdf->Cell(20, 4, utf8_decode('Domicilio:'), 0, 0, 'L');
$pdf->Cell(0, 4, utf8_decode($pac_dir), 0, 1, 'L');
$pdf->Ln(1);

// Anesthetic Record Section
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(220, 230, 250);
$pdf->Cell(0, 5, utf8_decode('Registro Anestésico'), 0, 1, 'C', true);
$pdf->Ln(2);

// Define row height and table spacing
$row_height = 3;
$table_spacing = 3;

// Información General (Two Columns)
$info_general = [
    'Anestesiólogo' => $anestesiologo,
    'Tipo de Anestesia' => $anest['tipo_anestesia'] ?? 'N/A',
    'Diagnóstico Preoperatorio' => ($anest['diagnostico_preoperatorio'] ?? 'N/A') . ($anest['desc_diagnostico_preoperatorio'] ? ': ' . $anest['desc_diagnostico_preoperatorio'] : ''),
    'Cirugía Programada' => $anest['cirugia_programada'] ?? 'N/A',
    'Diagnóstico Postoperatorio' => ($anest['diagnostico_postoperatorio'] ?? 'N/A') . ($anest['desc_diagnostico_postoperatorio'] ? ': ' . $anest['desc_diagnostico_postoperatorio'] : ''),
    'Cirugía Realizada' => $anest['cirugia_realizada'] ?? 'N/A',
    'Cirujano' => $cirujano,
    'Ayudantes' => $ayudantes,
];
$info_general_left = array_slice($info_general, 0, ceil(count($info_general) / 2));
$info_general_right = array_slice($info_general, ceil(count($info_general) / 2));
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetX(15);
$pdf->Cell(90, $row_height, utf8_decode('Información General'), 1, 0, 'C', true);
$pdf->SetX(110);
$pdf->Cell(90, $row_height, utf8_decode('Información General'), 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 7);
$y_start = $pdf->GetY();
$y_left = $y_start;
foreach ($info_general_left as $label => $value) {
    if ($value !== 'N/A' && $value !== 'No especificado') {
        $pdf->SetXY(15, $y_left);
        $pdf->Cell(50, $row_height, utf8_decode($label), 1, 0, 'L');
        $pdf->MultiCell(40, $row_height, utf8_decode($value), 1, 'L');
        $y_left = $pdf->GetY();
    }
}
$y_right = $y_start;
foreach ($info_general_right as $label => $value) {
    if ($value !== 'N/A' && $value !== 'No especificado') {
        $pdf->SetXY(110, $y_right);
        $pdf->Cell(50, $row_height, utf8_decode($label), 1, 0, 'L');
        $pdf->MultiCell(40, $row_height, utf8_decode($value), 1, 'L');
        $y_right = $pdf->GetY();
    }
}
$pdf->SetY(max($y_left, $y_right));
$pdf->Ln($table_spacing);

// Detalles de Anestesia (Two Columns)
$detalles_anestesia = [
    'Revisión del Equipo Anestésico' => $anest['revision_equipo'] ?? 'N/A',
    'O2 (Hora)' => $anest['o2_hora'] ? date('H:i', strtotime($anest['o2_hora'])) : 'N/A',
    'Agente Inhalado' => $anest['agente_inhalado'] ?? 'N/A',
    'ECG Continua' => $anest['ecg_continua'] ? 'Sí' : 'No',
    'Pulsoximetría' => $anest['pulsoximetria'] ? 'Sí' : 'No',
    'Capnografía' => $anest['capnografia'] ? 'Sí' : 'No',
];
$detalles_anestesia_left = array_slice($detalles_anestesia, 0, ceil(count($detalles_anestesia) / 2));
$detalles_anestesia_right = array_slice($detalles_anestesia, ceil(count($detalles_anestesia) / 2));
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetX(15);
$pdf->Cell(90, $row_height, utf8_decode('Detalles de Anestesia'), 1, 0, 'C', true);
$pdf->SetX(110);
$pdf->Cell(90, $row_height, utf8_decode('Monitoreo Continuo:'), 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 7);
$y_start = $pdf->GetY();
$y_left = $y_start;
foreach ($detalles_anestesia_left as $label => $value) {
    if ($value !== 'N/A' && $value !== 'No especificado') {
        $pdf->SetXY(15, $y_left);
        $pdf->Cell(50, $row_height, utf8_decode($label), 1, 0, 'L');
        $pdf->MultiCell(40, $row_height, utf8_decode($value), 1, 'L');
        $y_left = $pdf->GetY();
    }
}
$y_right = $y_start;
foreach ($detalles_anestesia_right as $label => $value) {
    if ($value !== 'N/A' && $value !== 'No especificado') {
        $pdf->SetXY(110, $y_right);
        $pdf->Cell(50, $row_height, utf8_decode($label), 1, 0, 'L');
        $pdf->MultiCell(40, $row_height, utf8_decode($value), 1, 'L');
        $y_right = $pdf->GetY();
    }
}
$pdf->SetY(max($y_left, $y_right));
$pdf->Ln($table_spacing);

// Intubación y Ventilación (Two Columns)
$intubacion_ventilacion = [
    'Intubación' => $anest['intubacion'] ?? 'N/A',
    'Incidentes' => $anest['incidentes'] ?? 'N/A',
    'Cánula' => $anest['canula'] ?? 'N/A',
    'Dificultad Técnica' => $anest['dificultad_tecnica'] ?? 'N/A',
    'Ventilación' => $anest['ventilacion'] ?? 'N/A',
];
$intubacion_ventilacion_left = array_slice($intubacion_ventilacion, 0, ceil(count($intubacion_ventilacion) / 2));
$intubacion_ventilacion_right = array_slice($intubacion_ventilacion, ceil(count($intubacion_ventilacion) / 2));
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetX(15);
$pdf->Cell(90, $row_height, utf8_decode('Intubación y Ventilación'), 1, 0, 'C', true);
$pdf->SetX(110);
$pdf->Cell(90, $row_height, utf8_decode('Intubación y Ventilación'), 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 7);
$y_start = $pdf->GetY();
$y_left = $y_start;
foreach ($intubacion_ventilacion_left as $label => $value) {
    if ($value !== 'N/A' && $value !== 'No especificado') {
        $pdf->SetXY(15, $y_left);
        $pdf->Cell(50, $row_height, utf8_decode($label), 1, 0, 'L');
        $pdf->MultiCell(40, $row_height, utf8_decode($value), 1, 'L');
        $y_left = $pdf->GetY();
    }
}
$y_right = $y_start;
foreach ($intubacion_ventilacion_right as $label => $value) {
    if ($value !== 'N/A' && $value !== 'No especificado') {
        $pdf->SetXY(110, $y_right);
        $pdf->Cell(50, $row_height, utf8_decode($label), 1, 0, 'L');
        $pdf->MultiCell(40, $row_height, utf8_decode($value), 1, 'L');
        $y_right = $pdf->GetY();
    }
}
$pdf->SetY(max($y_left, $y_right));
$pdf->Ln($table_spacing);

// Tiempos (Single Table)
$tiempos = [
    'Llega a Quirófano' => $anest['llega_quirofano'] ? date('d/m/Y H:i', strtotime($anest['llega_quirofano'])) : 'N/A',
    'Inicia Anestesia' => $anest['inicia_anestesia'] ? date('d/m/Y H:i', strtotime($anest['inicia_anestesia'])) : 'N/A',
    'Inicia Cirugía' => $anest['inicia_cirugia'] ? date('d/m/Y H:i', strtotime($anest['inicia_cirugia'])) : 'N/A',
    'Termina Cirugía' => $anest['termina_cirugia'] ? date('d/m/Y H:i', strtotime($anest['termina_cirugia'])) : 'N/A',
    'Termina Anestesia' => $anest['termina_anestesia'] ? date('d/m/Y H:i', strtotime($anest['termina_anestesia'])) : 'N/A',
    'Pasa a Recuperación' => $anest['pasa_recuperacion'] ? date('d/m/Y H:i', strtotime($anest['pasa_recuperacion'])) : 'N/A',
    'Tiempo Anestésico' => $anest['tiempo_anestesico'] ? $anest['tiempo_anestesico'] . ' min' : 'N/A',
];
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetX(15);
$pdf->Cell(92, $row_height, utf8_decode('Tiempos'), 1, 0, 'C', true);
$pdf->Cell(92, $row_height, 'Fecha/Hora', 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 7);
foreach ($tiempos as $label => $value) {
    if ($value !== 'N/A') {
        $pdf->SetX(15);
        $pdf->Cell(92, $row_height, utf8_decode($label), 1, 0, 'L');
        $pdf->Cell(92, $row_height, utf8_decode($value), 1, 1, 'C');
    }
}
$pdf->Ln($table_spacing);

// Fluid Balance Section (Two Columns)
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(220, 230, 250);
$pdf->Cell(0, 4, utf8_decode('Balance de Líquidos'), 0, 1, 'C', true);
$pdf->Ln(2);

// Left Column (Ingresos)
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetX(15);
$pdf->Cell(45, 4, 'Ingresos', 1, 0, 'C', true);
$pdf->Cell(45, 4, 'Valor (mL)', 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 7);
$y_left = $pdf->GetY();
$ingresos = [
    'Hartmann' => $anest['hartmann'] ?? 'N/A',
    'Glucosa' => $anest['glucosa'] ?? 'N/A',
    'NaCl' => $anest['nacl'] ?? 'N/A',
    'Total Ingresos' => $anest['total_ingresos'] ?? 'N/A',
];
foreach ($ingresos as $label => $value) {
    if ($value !== 'N/A') {
        $pdf->SetX(15);
        $pdf->Cell(45, 3, utf8_decode($label), 1, 0, 'L');
        $pdf->Cell(45, 3, $value, 1, 1, 'C');
        $y_left = $pdf->GetY();
    }
}

// Right Column (Egresos and Balance)
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetXY(110, $pdf->GetY() - (count(array_filter($ingresos, fn($v) => $v !== 'N/A')) * 6 - 8));
$pdf->Cell(45, 4, 'Egresos', 1, 0, 'C', true);
$pdf->Cell(45, 4, 'Valor (mL)', 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 7);
$y_right = $pdf->GetY();
$egresos = [
    'Diuresis' => $anest['diuresis'] ?? 'N/A',
    'Sangrado' => $anest['sangrado'] ?? 'N/A',
    'Pérdidas Insensibles' => $anest['perdidas_insensibles'] ?? 'N/A',
    'Total Egresos' => $anest['total_egresos'] ?? 'N/A',
    'Balance' => $anest['balance'] ?? 'N/A',
];
foreach ($egresos as $label => $value) {
    if ($value !== 'N/A') {
        $pdf->SetX(110);
        $pdf->Cell(45, 3, utf8_decode($label), 1, 0, 'L');
        $pdf->Cell(45, 3, $value, 1, 1, 'C');
        $y_right = $pdf->GetY();
    }
}
$pdf->SetY(max($y_left, $y_right));
$pdf->Ln(2);

// Aldrete and Regional Anesthesia Section (Two Columns)
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(220, 230, 250);
$pdf->Cell(0, 4, utf8_decode('Puntuación Aldrete y Anestesia Regional'), 0, 1, 'C', true);
$pdf->Ln(2);

// Left Column (Aldrete)
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetX(15);
$pdf->Cell(45, 4, 'Criterio', 1, 0, 'C', true);
$pdf->Cell(45, 4, utf8_decode('Puntuación'), 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 7);
$y_left = $pdf->GetY();
$aldrete = [
    'Actividad' => $anest['aldrete_actividad'] ?? 'N/A',
    'Respiración' => $anest['aldrete_respiracion'] ?? 'N/A',
    'Circulación' => $anest['aldrete_circulacion'] ?? 'N/A',
    'Conciencia' => $anest['aldrete_conciencia'] ?? 'N/A',
    'Saturación' => $anest['aldrete_saturacion'] ?? 'N/A',
    'Total' => $anest['aldrete_total'] ?? 'N/A',
];
foreach ($aldrete as $label => $value) {
    if ($value !== 'N/A') {
        $pdf->SetX(15);
        $pdf->Cell(45, 3, utf8_decode($label), 1, 0, 'L');
        $pdf->Cell(45, 3, $value, 1, 1, 'C');
        $y_left = $pdf->GetY();
    }
}

// Right Column (Regional Anesthesia)
if ($anest['anestesia_regional_tipo']) {
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetFillColor(245, 245, 245);
    $pdf->SetXY(110, $pdf->GetY() - (count(array_filter($aldrete, fn($v) => $v !== 'N/A')) * 6 - 14));
    $pdf->Cell(45, 4, '', 1, 0, 'C', true);
    $pdf->Cell(45, 4, 'Datos', 1, 1, 'C', true);
    $pdf->SetFont('Arial', '', 7);
    $y_right = $pdf->GetY();
    $regional = [
        'Tipo de Anestesia Regional' => $anest['anestesia_regional_tipo'] ?? 'N/A',
        'Aguja' => $anest['aguja'] ?? 'N/A',
        'Nivel de Punción' => $anest['nivel_puncion'] ?? 'N/A',
        'Catéter' => $anest['cateter'] ?? 'N/A',
        'Agentes Administrados' => $anest['agentes_administrados'] ?? 'N/A',
    ];
    foreach ($regional as $label => $value) {
        if ($value !== 'N/A') {
            $pdf->SetX(110);
            $pdf->Cell(45, 3, utf8_decode($label), 1, 0, 'L');
            $pdf->MultiCell(45, 3, utf8_decode($value), 1, 'L');
            $y_right = $pdf->GetY();
        }
    }
} else {
    $y_right = $y_left;
}
$pdf->SetY(max($y_left, $y_right));
$pdf->Ln(4);

// Signature Section (Full Width)
$pdf->SetY(-38);
if (!empty($firma_anest) && file_exists('../../imgfirma/' . $firma_anest)) {
    $imgWidth = 40;
    $imgX = ($pdf->GetPageWidth() - $imgWidth) / 2;
    $pdf->Image('../../imgfirma/' . $firma_anest, $imgX, $pdf->GetY(), $imgWidth);
    $pdf->Ln(1);
}
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(0, 4, utf8_decode(trim($pre_anest . ' ' . $app_anest . ' ' . $apm_anest . ' ' . $nom_anest)), 0, 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(0, 4, utf8_decode($carg_anest), 0, 1, 'C');
$pdf->Cell(0, 4, utf8_decode('Céd. Prof. ' . $ced_anest), 0, 1, 'C');

// Output PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="registro_anestesico.pdf"');
$pdf->Output('I', 'registro_anestesico.pdf');
exit();
?>