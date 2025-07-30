<?php

ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '512M');
ini_set('max_execution_time', '300');

session_start();
include "../../conexionbd.php";
require('../../fpdf/fpdf.php');

// Verifica que haya un paciente seleccionado en la sesión
if (!isset($_SESSION['pac'])) {
    header("Location: seleccionar_paciente.php"); // Redirigir si no hay paciente seleccionado
    exit;
}

// Verifica si existe id_atencion en la sesión
if (!isset($_SESSION['id_atencion'])) {
    // Manejo del error: redirigir o mostrar un mensaje
    echo "Error: No se ha encontrado 'id_atencion'.";
    exit; // Detener la ejecución del script
}

$id_atencion = $_SESSION['id_atencion']; // Asegúrate de que esto esté definido

echo $id_atencion;

class PDF extends FPDF {
    function Header() {
        $this->Image('../../imagenes/logo_pdf.jpg', 10, 8, 30, 33);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Conciliacion de Ingreso', 0, 1, 'C');
        
        $this->SetFont('Arial', '', 8);
        $this->Cell(140);
        $this->Cell(50, 5, 'Codigo: FO-VEN20-FAR-001', 1, 1, 'C');
        $this->Cell(140);
        $this->Cell(50, 5, 'Version: Nuevo', 1, 1, 'C');
        $this->Ln(10);
    }
    
    function CellWithBackground($w, $h, $txt, $border=1, $ln=0, $align='C', $fill=false, $bg_color=array(217,217,217)) {
        if($fill) {
            $this->SetFillColor($bg_color[0], $bg_color[1], $bg_color[2]);
        }
        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill);
    }
}

// Modificada la consulta para partir desde dat_ingreso
$stmt = $conexion->prepare("SELECT pac.sapell, pac.papell, pac.nom_pac, pac.fecnac, 
                                  di.fecha, di.alergias, di.motivo_atn 
                           FROM dat_ingreso di
                           JOIN paciente pac ON di.Id_exp = pac.Id_exp 
                           WHERE di.id_atencion = ? ");
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

// Patient Data Section
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Datos del Paciente', 0, 1, 'L');
$pdf->SetFont('Arial', '', 8);
$fecnac = date_create($paciente['fecnac']);
$pdf->Cell(95, 5, 'Nombre: ' . utf8_decode($paciente['papell'] . ' ' . $paciente['sapell'] . ' ' . $paciente['nom_pac']), 1);
$pdf->Cell(95, 5, 'Fecha de Nacimiento: ' . date_format($fecnac,'d-m-Y') , 1);
$pdf->Ln(5);
$pdf->Cell(95, 5, 'Alergias: ' . utf8_decode($paciente['alergias']), 1);
$pdf->Cell(95, 5, 'Diagnostico: ' . utf8_decode($paciente['motivo_atn']), 1);
$pdf->Ln(5);
$ingreso = date_create($paciente['fecha']);
$pdf->Cell(190, 5, 'Fecha de Ingreso: ' . date_format ($ingreso,'d-m-Y H:i'), 1);
$pdf->Ln(7);

// Modified query for concomitant diseases
$stmt = $conexion->prepare("SELECT ec.* 
                           FROM enf_concomitantes ec
                           JOIN dat_ingreso di ON ec.id_atencion = di.id_atencion
                           WHERE di.id_atencion = ?");
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$datos_guardados = $stmt->get_result();
$enfermedades = $datos_guardados->fetch_assoc();

// Concomitant Diseases Section
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Enfermedades Concomitantes', 0, 1, 'L');
$pdf->SetFont('Arial', '', 6);

$w = 63;
$pdf->CellWithBackground($w, 5, 'Diabetes Mellitus', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Hipertension', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Hipotiroidismo', 1, 0, 'C', true);
$pdf->Ln(5);
$pdf->Cell($w, 5, utf8_decode($enfermedades['diabetes_tipo'] . ': ' . $enfermedades['diabetes_detalle']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['hipertension']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['hipotiroidismo']), 1);

$pdf->Ln(5);
$pdf->CellWithBackground($w, 5, 'Insuf. Renal', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Depresion/Ansiedad', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Enf. Prostata', 1, 1, 'C', true);
$pdf->Cell($w, 5, utf8_decode($enfermedades['insuficiencia_renal']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['depresion_ansiedad']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['enfermedad_prostata']), 1);
$pdf->Ln(5);

$pdf->CellWithBackground($w, 5, 'EPOC', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Insuf. Cardiaca', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Obesidad', 1, 0, 'C', true);
$pdf->Ln(5);
$pdf->Cell($w, 5, utf8_decode($enfermedades['epoc']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['insuficiencia_cardiaca']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['obesidad']), 1);

$pdf->Ln(5);
$pdf->CellWithBackground($w, 5, 'Artritis', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Cancer', 1, 0, 'C', true);
$pdf->CellWithBackground($w, 5, 'Otro', 1, 1, 'C', true);
$pdf->Cell($w, 5, utf8_decode($enfermedades['artritis']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['cancer']), 1);
$pdf->Cell($w, 5, utf8_decode($enfermedades['otro_enfermedad']), 1);
$pdf->Ln(7);

// Modified query for pharmacological treatments
$stmt = $conexion->prepare("SELECT tf.* 
                           FROM trat_farma tf
                           JOIN dat_ingreso di ON tf.id_atencion = di.id_atencion
                           WHERE di.id_atencion = ?");
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$resultado_tratamientos = $stmt->get_result();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Tratamiento Farmacologico', 0, 1, 'L');
$pdf->SetFont('Arial', '', 6);

$w_trat = array(32, 32, 12, 30, 13, 17, 20, 13, 20);
$headers_trat = array('Medicamento', 'Principio Activo', 'Dosis', 'Intervalo', 'Horario', 'Via Admin.', 'Lote', 'Caducidad', 'Ultima Dosis');

foreach($headers_trat as $i => $header) {
    $pdf->CellWithBackground($w_trat[$i], 5, $header, 1, 0, 'C', true);
}
$pdf->Ln(5);

$w_trat = array(32, 32, 32, 32, 12, 30, 13, 17, 20, 13, 20);
while($fila = $resultado_tratamientos->fetch_assoc()) {
    
    foreach($w_trat as $i => $w) {
        if ($i != 0 and $i != 1) {
            $campo = array_values($fila)[$i];
            $pdf->Cell($w, 5, utf8_decode($campo), 1);
        }
    }
    $pdf->Ln(5);
}

// Modified query for treatment continuity
$stmt = $conexion->prepare("SELECT ct.* 
                           FROM cont_tratamiento ct
                           JOIN dat_ingreso di ON ct.id_atencion = di.id_atencion
                           WHERE di.id_atencion = ?");
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$resultado_tratamientos_guardados = $stmt->get_result();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Continuidad de tratamiento', 0, 1, 'L');
$pdf->SetFont('Arial', '', 6);

$w_cont = array(20, 20, 15, 15, 15, 20, 20, 20, 20, 25);
$headers_cont = array('Medicamento', 'Principio Activo', 'Dosis', 'Intervalo', 'Horario', 'Via Admin.', 'Medico', 'Servicio De', 'Servicio A', 'Fecha');

foreach($headers_cont as $i => $header) {
    $pdf->CellWithBackground($w_cont[$i], 5, $header, 1, 0, 'C', true);
}
$pdf->Ln(5);

$w_cont = array(20, 20, 20, 20, 15, 15, 15, 20, 20, 20, 20, 25);
while($fila = $resultado_tratamientos_guardados->fetch_assoc()) {
    foreach($w_cont as $i => $w) {
        if ($i != 0 and $i != 1) {
            $campo = array_values($fila)[$i];
            $pdf->Cell($w, 5, utf8_decode($campo), 1);
        }
    }
    $pdf->Ln(5);
}

// Signature section
$pdf->SetY(260);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(95, 5, '_______________________________', 0, 0, 'C');
$pdf->Cell(95, 5, '_______________________________', 0, 1, 'C');
$pdf->Cell(95, 5, 'Nombre y Firma del Profesional', 0, 0, 'C');
$pdf->Cell(95, 5, 'Nombre y Firma del Paciente', 0, 1, 'C');
$pdf->Cell(95, 5, 'Farmaceutico', 0, 0, 'C');
$pdf->Cell(95, 5, 'o Familiar', 0, 1, 'C');

ob_end_clean();

$pdf->Output('CONCILIACION_DE_INGRESO.pdf', 'I');
exit;
?>