<?php
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '512M');
ini_set('max_execution_time', '300');

session_start();
include "../../conexionbd.php";
require('../../fpdf/fpdf.php');

if (!isset($_SESSION['id_atencion'])) {
    echo "Error: No se ha encontrado 'id_atencion'.";
    exit;
}

$id_atencion = $_SESSION['id_atencion'];

class PDF extends FPDF {
    function Header() {
        $this->Image('../../imagenes/logo_pdf.jpg', 10, 8, 30, 33);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, utf8_decode('Conciliación de Ingreso'), 0, 1, 'C');
        $this->SetFont('Arial', '', 8);
        $this->Cell(140);
        $this->Cell(50, 5, utf8_decode('Código: FO-VEN20-FAR-001'), 1, 1, 'C');
        $this->Cell(140);
        $this->Cell(50, 5, utf8_decode('Versión: Nuevo'), 1, 1, 'C');
        $this->Ln(10);
    }
    
    function CellWithBackground($w, $h, $txt, $border=1, $ln=0, $align='C', $fill=false, $bg_color=array(217,217,217)) {
        if($fill) {
            $this->SetFillColor($bg_color[0], $bg_color[1], $bg_color[2]);
        }
        $this->Cell($w, $h, utf8_decode($txt), $border, $ln, $align, $fill);
    }
}

$stmt = $conexion->prepare("SELECT pac.sapell, pac.papell, pac.nom_pac, pac.fecnac, di.fecha, di.alergias, di.motivo_atn FROM dat_ingreso di JOIN paciente pac ON di.Id_exp = pac.Id_exp WHERE di.id_atencion = ?");
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$resultado_paciente = $stmt->get_result();

if ($resultado_paciente->num_rows === 0) {
    die("No se encontró información del paciente.");
}

$paciente = $resultado_paciente->fetch_assoc();

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Datos del Paciente'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 8);
$fecnac = date_create($paciente['fecnac']);
$pdf->Cell(95, 5, utf8_decode('Nombre: ' . $paciente['papell'] . ' ' . $paciente['sapell'] . ' ' . $paciente['nom_pac']), 1);
$pdf->Cell(95, 5, 'Fecha de Nacimiento: ' . date_format($fecnac,'d-m-Y') , 1);
$pdf->Ln(5);
$pdf->Cell(95, 5, 'Alergias: ' . utf8_decode($paciente['alergias']), 1);
$pdf->Cell(95, 5, utf8_decode('Diagnóstico: ' . $paciente['motivo_atn']), 1);
$pdf->Ln(5);
$ingreso = date_create($paciente['fecha']);
$pdf->Cell(190, 5, 'Fecha de Ingreso: ' . date_format($ingreso,'d-m-Y H:i'), 1);
$pdf->Ln(7);

$stmt = $conexion->prepare("SELECT * FROM enf_concomitantes WHERE id_atencion = ?");
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$datos_guardados = $stmt->get_result();
$enfermedades = $datos_guardados->fetch_assoc();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Enfermedades Concomitantes'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 6);

$w = 63;
$pdf->CellWithBackground($w, 5, 'Diabetes Mellitus', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Hipertensión', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Hipotiroidismo', 1, 0, 'C', true);
$pdf->Ln(5);
$pdf->Cell($w, 5, utf8_decode($enfermedades['diabetes_tipo'] . ': ' . $enfermedades['diabetes_detalle']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['hipertension']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['hipotiroidismo']), 1);
$pdf->Ln(5);

$pdf->CellWithBackground($w, 5, 'Insuf. Renal', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Depresión/Ansiedad', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Enf. Próstata', 1, 1, 'C', true);
$pdf->Cell($w, 5, utf8_decode($enfermedades['insuficiencia_renal']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['depresion_ansiedad']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['enfermedad_prostata']), 1);
$pdf->Ln(5);

$pdf->CellWithBackground($w, 5, 'EPOC', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Insuf. Cardíaca', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Obesidad', 1, 0, 'C', true);
$pdf->Ln(5);
$pdf->Cell($w, 5, utf8_decode($enfermedades['epoc']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['insuficiencia_cardiaca']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['obesidad']), 1);
$pdf->Ln(5);

$pdf->CellWithBackground($w, 5, 'Artritis', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Cáncer', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Otro', 1, 1, 'C', true);
$pdf->Cell($w, 5, utf8_decode($enfermedades['artritis']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['cancer']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['otro_enfermedad']), 1);
$pdf->Ln(7);

$stmt = $conexion->prepare("SELECT medicamento, dosis, intervalo, horario, via_administracion, ultima_dosis, continuidad FROM trat_farma WHERE id_atencion = ?");
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$resultado_tratamientos = $stmt->get_result();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Tratamiento Farmacológico (De los últimos 30 días)'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 6);

$headers_trat = array('Medicamento', 'Dosis', 'Intervalo', 'Horario', 'Vía Admin.', 'Última Dosis', 'Continuidad');
$w_trat = array(34, 25, 25, 25, 25, 30, 25);

foreach($headers_trat as $i => $header) {
    $pdf->CellWithBackground($w_trat[$i], 5, $header, 1, 0, 'C', true);
}
$pdf->Ln(5);

while($fila = $resultado_tratamientos->fetch_assoc()) {
    $pdf->Cell(34, 5, utf8_decode($fila['medicamento']), 1);
    $pdf->Cell(25, 5, utf8_decode($fila['dosis']), 1);
    $pdf->Cell(25, 5, utf8_decode($fila['intervalo']), 1);
    $pdf->Cell(25, 5, utf8_decode($fila['horario']), 1);
    $pdf->Cell(25, 5, utf8_decode($fila['via_administracion']), 1);
    $pdf->Cell(30, 5, utf8_decode($fila['ultima_dosis']), 1);
    $pdf->Cell(25, 5, utf8_decode($fila['continuidad']), 1);
    $pdf->Ln(5);
}

$stmt = $conexion->prepare("SELECT sa.item_name, sa.salida_fecha, sa.salida_lote, sa.salida_caducidad FROM salidas_almacenh sa JOIN item_almacen ia ON sa.item_id = ia.item_id WHERE ia.grupo = 'MEDICAMENTOS' AND sa.id_atencion = ? ORDER BY sa.salida_fecha DESC");
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$resultado_medicamentos = $stmt->get_result();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Tratamiento en el Hospital'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 8);
$headers_trat = array('Medicamento', 'Fecha de Salida', 'Lote', 'Caducidad');
$w_trat = array(60, 40, 45, 45);

foreach($headers_trat as $i => $header) {
    $pdf->CellWithBackground($w_trat[$i], 5, $header, 1, 0, 'C', true);
}
$pdf->Ln(5);

while ($fila = $resultado_medicamentos->fetch_assoc()) {
    $pdf->Cell(60, 5, utf8_decode($fila['item_name']), 1);
    $pdf->Cell(40, 5, date('d-m-Y', strtotime($fila['salida_fecha'])), 1);
    $pdf->Cell(45, 5, utf8_decode($fila['salida_lote']), 1);
    $pdf->Cell(45, 5, date('d-m-Y', strtotime($fila['salida_caducidad'])), 1);
    $pdf->Ln(5);
}

$pdf->SetY(260);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(95, 5, '_______________________________', 0, 0, 'C');
$pdf->Cell(95, 5, '_______________________________', 0, 1, 'C');
$pdf->Cell(95, 5, utf8_decode('Nombre y Firma del Profesional'), 0, 0, 'C');
$pdf->Cell(95, 5, utf8_decode('Nombre y Firma del Paciente'), 0, 1, 'C');
$pdf->Cell(95, 5, 'Farmacéutico', 0, 0, 'C');
$pdf->Cell(95, 5, 'o Familiar', 0, 1, 'C');

ob_end_clean();
$pdf->Output('CONCILIACION_DE_INGRESO.pdf', 'I');
exit;
?>
