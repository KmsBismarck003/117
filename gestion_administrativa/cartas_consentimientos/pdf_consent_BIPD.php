<?php

use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

mysqli_set_charset($conexion, "utf-8");

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
    $this->Cell(0, 10, utf8_decode('MAC-12.05'), 0, 1, 'R');
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

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac, p.folio FROM paciente p where p.Id_exp = $id_exp";
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

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(43, 45, 127);
$pdf->SetX(68);
$pdf->Cell(165, 5, utf8_decode('CONSENTIMIENTO BAJO INFORMACIÓN DE
'), 0, 'C');
$pdf->SetY(47);
$pdf->SetX(58.5);
$pdf->Cell(165, 5, utf8_decode('PROCEDIMIENTOS DIAGNÓSTICOS DE ALTO RIESGO
'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);


$pdf->Ln(9);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 205, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(205, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 6,utf8_decode('Metepec, México a '), 0, 'L');  
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d");
$pdf->Cell(50,5, $fecha_actual , 'B', 'L');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("m");
$pdf->Cell(18, 6, utf8_decode(' del mes de'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 5, $fecha_actual, 'B', 0, 'C');

$fecha_actual = date("Y");
$pdf->Cell(8, 6, utf8_decode(' de'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(39, 5, $fecha_actual, 'B', 1, 'C');

$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(13, 6, utf8_decode('Nombre: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(140, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 6, 'Edad: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);

  ;
$pdf->Cell(29, 5, utf8_decode($edad), 'B',0, 'C');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$date=date_create($fecha_ing);
$pdf->Cell(23, 6, utf8_decode('Identificado con:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(122, 5, ' ', 'B', 0, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 6, ' Expediente:', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 5,($folio), 'B',0, 'C');


$pdf->Ln(9);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 6, utf8_decode('Dirección: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(130, 5, utf8_decode($dir), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 6, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 5,  utf8_decode($tel), 'B', 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(44, 6, 'Nombre del familiar responsable: ' , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(148, 5, utf8_decode($resp), 'B', 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(24, 6, utf8_decode('Con domicilio en: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(168, 5, utf8_decode($dir), 'B', 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(28, 6, utf8_decode('Representante legal: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(164, 5,  utf8_decode($resp), 'B', 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(6, 6, utf8_decode('Yo: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(135, 5, utf8_decode($nom_pac . ' ' . $papell . ' ' . $sapell), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 6, utf8_decode('enviado a Médica del Angel Custodio por:'), 0, 0, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(6, 6, utf8_decode('Dr: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(152, 5, utf8_decode($user_papell), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 6, utf8_decode('para que me practique un: '), 0, 0, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(16, 6, utf8_decode('Estudio de: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(176, 5, ' ', 'B', 'L');



$pdf->Ln(8);
$pdf->MultiCell(191, 6, utf8_decode('Autorizo al personal médico y técnico para que se me administre contraste por vía sistémica estando consciente que existen posibles riesgos adversos de tipo quimiotóxicos como son náusea y vómito, así como reacción anafilactoide como hipotensión, crisis convulsivas, choque anafilactico o muerte.'), 0, 'J');
$pdf->Ln(2);
$pdf->MultiCell(191, 6, utf8_decode('Excluyo de toda responsabilidad penal y legal al personal médico y técnico de Médica del Angel Custodio por las reacciones de dicho estudio.
'), 0, 'J');

$pdf->Ln(12);
$pdf->SetX(60);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(91, 6, utf8_decode('OTORGO MI CONSENTIMIENTO'), 0,1, 'C');
$pdf->Ln(8);
$pdf->SetX(70);
$pdf->Cell(70, 6, utf8_decode(''), 'B', 0, 'C');
$pdf->Ln(6);
$pdf->Cell(190, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');

$pdf->Ln(20);

$pdf->Cell(90, 6, utf8_decode('TESTIGO'), 0, 0, 'C');
$pdf->Cell(110, 6, utf8_decode('TESTIGO'), 0, 0, 'C');
$pdf->Ln(15);
$pdf->SetX(20);
$pdf->Cell(70, 6, utf8_decode(''), 'B', 0, 'C');

$pdf->SetX(119);
$pdf->Cell(70, 6, utf8_decode(''), 'B', 0, 'C');

$pdf->Ln(6);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');


$pdf->Ln(22);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 6, utf8_decode('QUIEN SE IDENTIFICA CON: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(53, 5, ' ', 'B', 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 6, utf8_decode('QUIEN SE IDENTIFICA CON: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(53, 5, ' ', 'B', 'L');

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 9);
$pdf->SetX(70);
$pdf->Cell(70, 6, utf8_decode(''), 'B', 0, 'C');
$pdf->Ln(6);
$pdf->Cell(190, 6, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
$pdf->Ln(-4);
$pdf->SetX(59);
$pdf->Cell(94, 4, utf8_decode($cargp) . ' ' .  utf8_decode('CÉD. PROF. ' . $ced_p), 0, 0, 'C');
$pdf->Ln(-5);
$pdf->SetX(59);
$pdf->Cell(94, 6, utf8_decode($user_pre . ' ' . $user_papell), 0, 0, 'C');
$pdf->Output();
