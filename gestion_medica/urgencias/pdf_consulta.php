<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id = @$_GET['id'];
$tri = @$_GET['tri'];
$id_med = @$_GET['id_med'];

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id_atencion = @$_GET['id_atencion'];;
include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}
$this->Ln(32);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-4.02'), 0, 1, 'R');
  }
  
}

$sql_triage = "SELECT * FROM dat_c_obs t,dat_ingreso di where t.id_atencion = $id and di.id_atencion=$id";
$result_triage = $conexion->query($sql_triage);

while ($row_triage = $result_triage->fetch_assoc()) {
  $fecha_t = $row_triage['fecha_t'];
  $id_atencion = $row_triage['id_atencion'];
  
  $p_sistolica = $row_triage['p_sistolica'];
  $p_diastolica = $row_triage['p_diastolica'];
  $f_card = $row_triage['f_card'];
  $f_resp = $row_triage['f_resp'];
  $temp = $row_triage['temp'];
  $sat_oxigeno = $row_triage['sat_oxigeno'];
 
  $subjetivo = $row_triage['subjetivo'];
  $objetivo = $row_triage['objetivo'];
  $analisis = $row_triage['analisis'];
  $plan = $row_triage['plan'];
  $pronostico = $row_triage['pronostico'];
  $diagno = $row_triage['diagno'];
  $diagno_desc = $row_triage['diagno_desc'];
  
  $receta = $row_triage['receta'];
  $destino = $row_triage['destino'];
  $referido = $row_triage['referido'];
  $espec = $row_triage['espec'];
  
  $id_usua2 = $row_triage['id_usua2'];
  $id_usua = $row_triage['id_usua'];
  
}

$sql_pac = "SELECT * FROM paciente p, dat_ingreso di where di.id_atencion = $id and di.Id_exp=p.Id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $fecha_ing = $row_pac['fecha'];
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $fecnac = $row_pac['fecnac'];
  $fecha_nac = $row_pac['fecnac'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  $Id_exp = $row_pac['Id_exp'];
  $dir = $row_pac['dir'];
  $id_edo = $row_pac['id_edo'];
  $id_mun = $row_pac['id_mun'];
  $tel = $row_pac['tel'];
  $ocup = $row_pac['ocup'];
  $resp = $row_pac['resp'];
  $paren = $row_pac['paren'];
  $tel_resp = $row_pac['tel_resp'];
  $folio = $row_pac['folio'];
  $alergias = $row_pac['alergias'];
}

$sql_edo = "SELECT nombre FROM estados WHERE id_edo = $id_edo";
$result_edo = $conexion->query($sql_edo);

while ($row_edo = $result_edo->fetch_assoc()) {
  $nom_edo = $row_edo['nombre'];
}

$sql_mun = "SELECT nombre_m FROM municipios WHERE id_mun = $id_mun";
$result_mun = $conexion->query($sql_mun);

while ($row_mun = $result_mun->fetch_assoc()) {
  $nom_mun = $row_mun['nombre_m'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(43, 45, 127);


$pdf->SetFont('Arial', 'B', 11);
$pdf->SETX(35);
$pdf->MultiCell(150, 6, utf8_decode('N O T A   D E   C O N S U L T A'), 1, 'C');
$pdf->Ln(2);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 50, 207, 50);
$pdf->Line(8, 50, 8, 67);
$pdf->Line(207, 50, 207, 67);
$pdf->Line(8, 67, 207, 67);

$date3=date_create($fecha_t);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 6, utf8_decode('Fecha y hora de elaboración: '), 0,0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 4, date_format($date3,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(35, 4, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 4, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 4, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 4, utf8_decode($Id_exp), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 4, ' Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(146, 4, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$date1=date_create($fecnac);
$pdf->Cell(35, 4, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 4, date_format($date1,"d/m/Y"), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 4, ' Edad: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(28, 4, utf8_decode($edad),'B', 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 4, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(28, 4,  utf8_decode($tel), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 4, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 4,  $sexo, 'B', 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 4, utf8_decode('Alergías: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(89, 4, utf8_decode($alergias), 'B', 'L');


$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 4, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 7.2);
$pdf->Cell(38, 4, utf8_decode('Presión Arterial: ' .$p_sistolica.'/'.$p_diastolica).' mmHG', 1, 'L');
$pdf->Cell(44, 4, utf8_decode('Frecuencia Cardiaca: ' .$f_card.' Latidos/min'), 1, 'L');
$pdf->Cell(55, 4, utf8_decode('Frecuencia Respiratoria: ' .$f_resp.' Respiraciones/min'), 1, 'L');
$pdf->Cell(26, 4, utf8_decode('Temperatura: ' .$temp.' °C'), 1, 'L');
$pdf->Cell(34, 4, utf8_decode('Saturación de Oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Ln(4);


$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 4, utf8_decode('SUBJETIVO: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(198, 6, utf8_decode($subjetivo), 1, 'L');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 4, utf8_decode('OBJETIVO: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(198, 6, utf8_decode($objetivo), 1, 'L');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 4, utf8_decode('ANALISIS: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(198, 6, utf8_decode($analisis), 1, 'L');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 4, utf8_decode('PLAN: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(198, 6, utf8_decode($plan), 1, 'L');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 4, utf8_decode('PRONOSTICO: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(198, 6, utf8_decode($pronostico), 1, 'L');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 4, utf8_decode('RECETA: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(198, 6, utf8_decode($receta), 1, 'L');


$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 4, utf8_decode('DIAGNÓSTICO: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode($diagno), 1, 'L');
$pdf->Ln(7);
$pdf->Cell(198, 6, utf8_decode($diagno_desc), 1, 'L');
$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 4, utf8_decode('DESTINO: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode($destino), 1, 'L');



$pdf->Ln(8);

$sql_med_id = "SELECT id_usua FROM dat_c_urgen WHERE id_atencion = $tri ORDER by fecha_urgen DESC LIMIT 1";
    $result_med_id = $conexion->query($sql_med_id);

    while ($row_med_id = $result_med_id->fetch_assoc()) {
      $id_med = $row_med_id['id_usua'];
    }
    $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_med";
    $result_med = $conexion->query($sql_med);

    while ($row_med = $result_med->fetch_assoc()) {
      $nom = $row_med['nombre'];
      $app = $row_med['papell'];
      $apm = $row_med['sapell'];
      $pre = $row_med['pre'];
      $firma = $row_med['firma'];
      $ced_p = $row_med['cedp'];

}
      $pdf->SetY(-32);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Image('../../imgfirma/' . $firma, 88, 252, 35);
      $pdf->Ln(2);
      $pdf->SetX(80);
      $pdf->Cell(50, 3, utf8_decode($pre . ' .' . $app . ' ' . $apm ), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetX(30);
      $pdf->Cell(150, 3, utf8_decode('Cédula Profesional: ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetX(15);
      $pdf->Cell(180, 3, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');


$pdf->Output();
