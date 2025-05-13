<?php

use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
//require('../../fpdf/MultiCellBlt.php');
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
        $bas=$f['img_ipdf'];
        $this->Image("../../configuracion/admin/img2/".$bas, 10, 12, 58, 22);
        //$this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],57,1, 100, 25);
        $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 14, 35, 15);
}
  
    $this->SetFont('Arial', 'B', 25);
    $this->SetTextColor(43, 45, 127);
    $this->Ln(10);
    $this->Cell(200, 9, utf8_decode(' HOJA INICIAL'), 0, 0, 'C');
    $this->Ln(10);
    $this->SetDrawColor(43, 45, 127);
    $this->Line(68, 28, 158, 28);
    $this->SetFont('Arial', '', 8);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-001'), 0, 1, 'R');
  }
}

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $fecha_ing = $row_dat_ing['fecha'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua  = $row_dat_ing['id_usua'];
  $id_usua1 = $row_dat_ing['id_usua'];
  $id_usua2 = $row_dat_ing['id_usua2'];
  $id_usua3 = $row_dat_ing['id_usua3'];
  $id_usua4 = $row_dat_ing['id_usua4'];
  $id_usua5 = $row_dat_ing['id_usua5'];
  $tipo_a = $row_dat_ing['tipo_a'];
  $aseg = $row_dat_ing['aseg'];
  $alergias = $row_dat_ing['alergias'];
  
  $motivo_recepcion = $row_dat_ing['motivo_recepcion'];
  
}

$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua ";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pre = $row_reg_usrs['pre'];
  $user_papell = $row_reg_usrs['papell'];
  $user_sapell = $row_reg_usrs['sapell'];
  $user_nombre = $row_reg_usrs['nombre'];
  $user_cedula = $row_reg_usrs['cedp'];
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.sexo,p.Id_exp,p.folio,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac, p.edad FROM paciente p where p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $sexo = $row_pac['sexo'];
  $Id_exp = $row_pac['Id_exp'];
  $folio = $row_pac['folio'];
  $dir = $row_pac['dir'];
  $id_edo = $row_pac['id_edo'];
  $id_mun = $row_pac['id_mun'];
  $tel = $row_pac['tel'];
  $ocup = $row_pac['ocup'];
  $resp = $row_pac['resp'];
  $paren = $row_pac['paren'];
  $tel_resp = $row_pac['tel_resp'];
  $fecnac = $row_pac['fecnac'];
  $edad  = $row_pac['edad'];
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
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(158, 9.5, utf8_decode('DATOS DEL PACIENTE'), 0, 'C');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 5, 205, 5);

$pdf->Line(8, 5, 8, 280);
$pdf->Line(205, 5, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->SetFont('Arial', '', 10);
$pdf->Ln(5);
$pdf->Cell(21, 6, 'PACIENTE: ', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(150, 5.5, utf8_decode($folio .' - '. $papell. ' ' .$sapell . ' ' . $nom_pac ), 'B', 'L');
$pdf->Cell(8, 6, utf8_decode(' ID: '), 0,0,'L');
$pdf->Cell(13, 5, utf8_decode($id_atencion), 'B', 0, 'C');
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 10);
$date=date_create($fecnac);
$pdf->Cell(45, 6, 'FECHA DE NACIMIENTO: ', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(85, 5.5, date_format($date,"d/m/Y"), 'B', 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(14, 6, 'EDAD: ', 0, 'L');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(48, 5, utf8_decode($edad), 'B', 'C');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(22, 6, utf8_decode('DOMICILIO: '), 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(170.5, 5.5, utf8_decode($dir), 'B', 'L');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 10);
$date=date_create($fecha_ing);
$pdf->Cell(38, 6, utf8_decode('FECHA DE INGRESO:'),0 , 0, 'L');

$pdf->Cell(38, 5.5, date_format($date,'d/m/Y H:i a'), 'B', 0, 'C');

$pdf->Cell(32, 6, utf8_decode(' ASEGURADORA:'), 0, 'L');

$pdf->Cell(84.5, 5.5, utf8_decode($aseg), 'B', 'L');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 6, utf8_decode('MOTIVO DE INGRESO: '), 0, 'L');  
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(152, 5, utf8_decode($motivo_atn) , 'B', 'L');
$pdf->Ln(15);

$d = "SELECT DISTINCT(diag_paciente) as diag_paciente, fecha,id_usua,Id_exp from diag_pac where Id_exp=$id_atencion order by fecha DESC LIMIT 1";
$res = $conexion->query($d);

while ($dr = $res->fetch_assoc()) {
  $diag_paciente = $dr['diag_paciente'];
  $fecha = $dr['fecha'];
  $id_exp = $dr['Id_exp'];
}

$sql_reg_u1 = "SELECT * from reg_usuarios where id_usua=$id_usua1";
$result_reg_u1 = $conexion->query($sql_reg_u1);

while ($row_reg_u1 = $result_reg_u1->fetch_assoc()) {
  $user_pred = $row_reg_u1['pre'];
  $user_papelld = $row_reg_u1['papell'];
  $user_sapelld = $row_reg_u1['sapell'];
  $user_nombred = $row_reg_u1['nombre'];
  $user_cedulad = $row_reg_u1['cedp'];
}


$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua2";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pred2 = $row_reg_usrs['pre'];
  $user_papelld2 = $row_reg_usrs['papell'];
}

$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua3";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pred3 = $row_reg_usrs['pre'];
  $user_papelld3 = $row_reg_usrs['papell'];
 }

$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua4";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pred4 = $row_reg_usrs['pre'];
  $user_papelld4 = $row_reg_usrs['papell'];
}
$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua5";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pred5 = $row_reg_usrs['pre'];
  $user_papelld5 = $row_reg_usrs['papell'];
}

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(21, 6, utf8_decode('MÉDICOS:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(171.5, 5.5, utf8_decode($user_pred.' '.$user_papelld.'  '. 
  $user_pred2.' '.$user_papelld2.'  '. 
  $user_pred3.' '.$user_papelld3.'  '. 
  $user_pred4.' '.$user_papelld4.'  '. 
  $user_pred5.' '.$user_papelld5), 'B','L');

$pdf->Ln(10);

$pdf->Cell(35, 6, utf8_decode('ALERGIAS: '), 0, 0, 'L');
$pdf->Cell(157, 5.5, utf8_decode($alergias), 'B', 'L');

$pdf->Ln(20);
$pdf->Cell(35, 6, utf8_decode('OBSERVACIONES: '), 0, 0, 'L');
$pdf->Cell(157, 5.5, utf8_decode(''), 'B', 'L');

$pdf->Ln(10);


$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua1";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $pre = $row_reg_usrs['pre'];
  $app = $row_reg_usrs['papell'];
  $apm = $row_reg_usrs['sapell'];
  $nom = $row_reg_usrs['nombre'];
  $firma= $row_reg_usrs['firma'];
  $cargp = $row_reg_usrs['cargp'];
  $ced_p = $row_reg_usrs['cedp'];
}

      $pdf->SetY(-60);
      $pdf->SetFont('Arial', 'B', 8);
     //$pdf->Image('../../imgfirma/' . $firma, 95, 240, 30);
    
    if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 240 , 30);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 240 , 30);
}
    
    
       $pdf->SetY(264);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
 $pdf->Output();
