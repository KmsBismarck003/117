<?php

use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$medico = @$_POST['medico'];
$estudios = @$_POST['estudios'];
$diagnostico_pdf = @$_POST['diagnostico_pdf'];
$actos = @$_POST['actos'];
$trat = @$_POST['trat'];
$tratquir = @$_POST['tratquir'];
$ries = @$_POST['ries'];

$marc = @$_POST['marc'];
$yo = @$_POST['yo'];
$como = @$_POST['como'];
$nomtes = @$_POST['nomtes'];
$exp = @$_POST['exp'];
$ries = @$_POST['ries'];
$diagnostico = @$_POST['diagnostico'];



mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {

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
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-12.09'), 0, 1, 'R');
  }
}

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $tipo_a = $row_dat_ing['tipo_a'];
  $fecha_ing = $row_dat_ing['fecha'];
  $alergias = $row_dat_ing['alergias'];
}

$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pre = $row_reg_usrs['pre'];
  $user_papell = $row_reg_usrs['papell'];
  $user_sapell = $row_reg_usrs['sapell'];
  $user_nombre = $row_reg_usrs['nombre'];
  $ced_p = $row_reg_usrs['cedp'];
  $cargp = $row_reg_usrs['cargp'];
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac, p.edociv,p.loc, p.folio FROM paciente p where p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
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
  $fecnac = $row_pac['fecnac'];
   $edociv = $row_pac['edociv'];
   $loc = $row_pac['loc'];
   $folio = $row_pac['folio'];
}





$sql_cam = "SELECT * FROM cat_camas WHERE id_atencion= $id_atencion";
$result_cam = $conexion->query($sql_cam);

while ($row_cam = $result_cam->fetch_assoc()) {
  $num_cam = $row_cam['num_cama'];
}

$sql_mun = "SELECT nombre_m FROM municipios WHERE id_mun = $id_mun";
$result_mun = $conexion->query($sql_mun);

while ($row_mun = $result_mun->fetch_assoc()) {
  $nom_mun = $row_mun['nombre_m'];
}

$sql_mun2 = "SELECT nombre FROM estados WHERE id_edo = $id_edo";
$result_mun2 = $conexion->query($sql_mun2);

while ($row_mun2 = $result_mun2->fetch_assoc()) {
  $nom_es = $row_mun2['nombre'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(159, 9.5, utf8_decode('Consentimiento de Marcaje Quirúrgico Físico y documentado'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 205, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(205, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 6, 'Lugar: ', 0, 'L');  
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(88.5, 6, utf8_decode('Metepec, México') , 'B', 'L');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y H:i a");
$pdf->Cell(19, 6, utf8_decode(' Fecha y hora:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(67, 6, $fecha_actual, 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);

$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, 'Nombre del paciente:', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(74.3, 5.5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac) , 'B', 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 6, 'Fecha de nacimiento: ', 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$date=date_create($fecnac);

//$fecha_actual = date("d/m/Y");
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 5.5, date_format($date,"d/m/Y"), 'B', 0, 'L'); 

$pdf->Cell(13, 5.5, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5.5,  $sexo, 'B', 'L');

$pdf->Ln(7);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10.5, 5.5, 'Edad: ', 0, 'L');

$pdf->Cell(25, 5.5, utf8_decode($edad), 'B', 'C');


if(isset($num_cam)){
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 5.5, utf8_decode(' Habitación: '),  0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 5.5,  $num_cam, 'B', 'C');
}else{
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 5.5, utf8_decode(' Habitación: '),  0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 5.5, 'S/H ', 'B', 'L');
}

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 5.5, utf8_decode('Diagnóstico: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(111, 5.5, utf8_decode($diagnostico), 'B', 'L');
    


$pdf->Ln(2);
$pdf->Cell(12, 5.5, utf8_decode('Médico: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(53, 5.5,  utf8_decode($user_papell . ' ' . $user_sapell), 'B', 'L');



$pdf->Cell(13, 5.5, utf8_decode('Alergias: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(39, 5.5,  utf8_decode($alergias), 'B', 'L');
$pdf->Cell(5, 5.5, utf8_decode(' '), 0, 0, 'L');
$pdf->MultiCell(71.5, 4.5, utf8_decode('Imagen para el marcaje del sitio quirúrgico empleado en Clínica Médica S.I., S.C. es de un " tache". X'), 0, 'L');

$pdf->Ln(-1);

$pdf->Cell(37, 6, utf8_decode('1.-¿Se realizó marcaje quirúrgico físico?'), 0, 'L');
$pdf->Ln(6);
if ($marc=="Si") {
  $pdf->Cell(5.5, 3, utf8_decode(''),0, 'L');
 $pdf->Cell(3.5, 3, utf8_decode('X'), 1,0, 'L');
$pdf->Cell(10, 3, utf8_decode($marc), 0, 'L');
$pdf->Cell(3.5, 3, utf8_decode(''), 1,0, 'L');
$pdf->Cell(10, 3, utf8_decode("No"), 0, 'L');
$pdf->Cell(3.5, 3, utf8_decode(''), 1,0, 'L');
$pdf->Cell(37, 3, utf8_decode("No aplica"), 0, 'L');
}else if ($marc=="No") {
 $pdf->Cell(5.5, 3, utf8_decode(''),0, 'L');
 $pdf->Cell(3.5, 3, utf8_decode(''), 1,0, 'L');
$pdf->Cell(10, 3, utf8_decode("Si"), 0, 'L');
$pdf->Cell(3.5, 3, utf8_decode('X'), 1,0, 'L');
$pdf->Cell(10, 3, utf8_decode($marc), 0, 'L');
$pdf->Cell(3.5, 3, utf8_decode(''), 1,0, 'L');
$pdf->Cell(37, 3, utf8_decode("No aplica"), 0, 'L');
}else if ($marc=="No aplica") {
 $pdf->Cell(5.5, 3, utf8_decode(''),0, 'L');
 $pdf->Cell(3.5, 3, utf8_decode(''), 1,0, 'L');
$pdf->Cell(10, 3, utf8_decode("Si"), 0, 'L');
$pdf->Cell(3.5, 3, utf8_decode(''), 1,0, 'L');
$pdf->Cell(10, 3, utf8_decode("No"), 0, 'L');
$pdf->Cell(3.5, 3, utf8_decode('X'), 1,0, 'L');
$pdf->Cell(37, 3, utf8_decode($marc), 0, 'L');
}


$pdf->Ln(8);

$pdf->Cell(6, 3, utf8_decode('Yo'), 0, 'L');
$pdf->Cell(110, 3, utf8_decode($yo), 'B', 'L');
$pdf->Cell(12, 3, utf8_decode('como:'), 0, 'L');

if ($como=="Paciente") {
  $pdf->Cell(3.5, 3, utf8_decode('X'), 1,0, 'L');
 $pdf->Cell(16, 3, utf8_decode($como), 0, 'L');
 $pdf->Cell(3.5, 3, utf8_decode(''), 1,0, 'L');
 $pdf->Cell(33, 3, utf8_decode('Responsable legal'), 0, 'L');
}else if ($como=="Responsable legal") {
  $pdf->Cell(3.5, 3, utf8_decode(''), 1,0, 'L');
 $pdf->Cell(16, 3, utf8_decode('Paciente'), 0, 'L');
 $pdf->Cell(3.5, 3, utf8_decode('X'), 1,0, 'L');
 $pdf->Cell(33, 3, utf8_decode($como), 0, 'L');
}


$pdf->Ln(4);

$pdf->MultiCell(190, 5, utf8_decode('manifiesto que doy autorización para que se realice en mi cuerpo o en el de mi representado, el marcaje del sitio para la realización de la cirugía, así mismo he sido informado en que consiste el procedimiento de marcaje que es conveniente para la mayor seguridad. Corroboro que coincide la marca del cuerpo con la del esquema.'), 0, 'L');


$pdf->Ln(1);
$pdf->Cell(36, 6, utf8_decode('Nombre y firma de testigo:'), 0, 'J');
$pdf->Cell(155.5, 5.5, utf8_decode($nomtes), 'B', 'L');
$pdf->Ln(6);

$pdf->Cell(52, 6, utf8_decode('En caso de no aceptar, explicar motivo:'), 0, 'J');
$pdf->MultiCell(139.5, 5, utf8_decode($exp), 'B', 'J');
$pdf->Ln(1);
$pdf->Cell(35, 6, utf8_decode('Instrucciones:'), 0, 'J');

$pdf->Ln(7);
$pdf->MultiCell(190, 5, utf8_decode('a) El marcado del sitio quirúrgico aplica en los casos de bilateralidad (izquierda o derecha), en caso de estructuras múltiples o múltiples niveles (ejemplo: una lesión cutánea, un dedo, una vértebra, etc.). Se realizará antes de ingresar al quirófano, el cual se llevará a cabo con la participación del paciente y con ayuda del médico tratante, o en su defecto con la enfermera o médico de guardia; marcando un tache con un plumón de tinta indeleble, y se documentará en la presente hoja, misma que adjuntara al expediente clínico.'), 0, 'L');

$pdf->Ln(3);
$pdf->MultiCell(190, 5, utf8_decode('b) El marcaje solo será documental en los siguientes casos: en el caso de que el paciente no acepte el marcaje quirúrgico físico. Por lo cual, Clínica Médica S.I., S.C. cumpliendo con los estándares de consejo de Salubridad General (paciente correcto, lugar correcto y procedimiento correcto) implementa el marcaje quirúrgico documentado.'), 0, 'L');

$pdf->Ln(3);
$pdf->MultiCell(190, 5, utf8_decode('c) El marcado del sitio quirúrgico puede omitirse, cuando la lesión es claramente visible (fracturas expuestas o tumoraciones evidentes), procedimientos de mínima invasión (acceso percutáneo o por orificios naturales), procedimientos que impliquen intervención de un órgano interno bilateral, en pacientes prematuros o neonatos (por riesgo de tatuaje permanente), cuando el procedimiento quirúrgico es en un sitio anatómico imposible de marcar (mucosas o perineo).'), 0, 'L');
$pdf->Cell(10, 6, utf8_decode(''), 0,0, 'C');
$pdf->Cell(48, 6, utf8_decode('MASCULINO:'), 0,0, 'C');
$pdf->Cell(1, 6, utf8_decode(''), 0,0, 'C');
$pdf->Cell(80, 6, utf8_decode('FEMENINO:'), 0,0, 'C');
$pdf->Cell(35, 6, utf8_decode('NEONATO O PEDIÁTRICO:'), 0,0, 'C');
 $pdf->Image('enfrente.jpg', 15, 210, 60, 50);
 
$pdf->Image('atras.jpg', 78, 210, 60, 50);

$pdf->Image('neonato.jpg', 140, 210, 60, 50);

$pdf->Output();
