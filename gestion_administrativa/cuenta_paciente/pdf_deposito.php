<?php

//use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id_atencion'];
$id_exp = @$_GET['id_exp'];
$id_datfin=@$_GET['id_datfin'];
//$id_usua=@$_GET['id_usua'];


mysqli_set_charset($conexion, "utf8");
class PDF extends FPDF
{
  function Header()
  {

    include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 28);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}
    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
 
    $this->Ln(10);
    
    
    $this->Ln(4);
 
    $this->Ln(4);
    
    $this->Ln(4);
    
    $this->Ln(10);
    
  }
 
}


$date = date("d/m/Y");

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p where p.Id_exp = $id_exp";
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
}

$sql_hab = "SELECT * from cat_camas where id_atencion=$id_atencion";
$result_hab = $conexion->query($sql_hab);

while ($row_hab = $result_hab->fetch_assoc()) {
  $numcam = $row_hab['num_cama'];
  $tipo = $row_hab['tipo'];
}
if(isset($numcam)){
 $numcam=$numcam;
}else{
  $numcam='Sin Cama';
}

$sql_fin = "SELECT * from dat_financieros where id_atencion=$id_atencion AND id_datfin=$id_datfin ";
$result_fin = $conexion->query($sql_fin);

while ($row_fin = $result_fin->fetch_assoc()) {
  $deposito = $row_fin['deposito'];
  $metodo_pago = $row_fin['banco'];
  $dep_l=$row_fin['dep_l'];
  $aval=$row_fin['aval'];
  $usuario=$row_fin['id_usua'];
}
$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$usuario";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pre = $row_reg_usrs['pre'];
  $user_papell = $row_reg_usrs['papell'];
  $user_sapell = $row_reg_usrs['sapell'];
  $user_nombre = $row_reg_usrs['nombre'];
}


$fecha_actual = date("d-m-Y H:i:s");

 explode("-", $fecha_actual);
 $ano  = date("Y") ;
  $mes= date("m") ;
  $dia  = date("d") ;

   if ($mes==1) {
    $mes='Enero';
  }

 if ($mes==2) {
    $mes='Febrero';
  }
   if ($mes==3) {
    $mes='Marzo';
  }
 if ($mes==4) {
    $mes='Abril';
  }
  if ($mes==5) {
    $mes='Mayo';
  }
   if ($mes==6) {
    $mes='Junio';
  }
   if ($mes==7) {
    $mes='Julio';
  }
   if ($mes==8) {
    $mes='Agosto';
  }
   if ($mes==9) {
    $mes='Septiembre';
  }
   if ($mes==10) {
    $mes='Octubre';
  }
   if ($mes==11) {
    $mes='Noviembre';
  }
   if ($mes==12) {
    $mes='Diciembre';
  }

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->SetX(30);
$pdf->MultiCell(160, 6, utf8_decode('R E C I B O'),0, 'C');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 50, 172, 50);
$pdf->Line(48, 40, 48, 50);
$pdf->Line(172, 40, 172, 50);
$pdf->Line(48, 40, 172, 40);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 52, 205, 52);
$pdf->Line(8, 52, 8, 140);
$pdf->Line(205, 52, 205, 140);
$pdf->Line(8, 140, 205, 140);

$pdf->SetFont('Arial', '', 8);


$pdf->Ln(5);
$pdf->Cell(40, 6, 'Nombre del paciente: ', 0, 'L');
$pdf->Cell(90, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac),'B', 'L');
$pdf->Cell(40, 6, 'Fecha de nacimiento: ', 0, 'L');
$fecnac=date_create($fecnac);
$pdf->Cell(20, 6, utf8_decode(date_format($fecnac,"d-m-Y")),'B', 'L');


$pdf->Ln(6);
$pdf->Cell(20, 6, utf8_decode('Habitación: '), 0, 'L');
$pdf->Cell(15, 6, utf8_decode($numcam), 'B', 'L');
$pdf->SetX(50);
$pdf->Cell(25, 6, utf8_decode('Diagnóstico: '), 0, 'L');
$pdf->Cell(125, 6,$motivo_atn, 'B', 'L');
$pdf->Ln(8);
$pdf->Cell(28, 6, 'La cantidad de : $', 0, 'L');
$pdf->Cell(30, 6, number_format($deposito,2), 'B', 'L');
$pdf->SetX(75);
$pdf->Cell(28, 6, utf8_decode('Forma de pago : '), 0, 'L');
$pdf->Cell(98, 6, utf8_decode($metodo_pago.', '.$aval), 'B', 'L');
$pdf->Ln(8);
/*
$pdf->Cell(22, 6, 'Con letra : ', 0, 'L');
$pdf->Cell(169, 6,$dep_l, 'B', 'L');
*/
$pdf->Ln(8);
$pdf->Cell(0, 5, utf8_decode('Metepec, México a, '). $dia.' '.$mes.' '.$ano , 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetX(10);
$pdf->Cell(75, 6, utf8_decode('Responsable'), 0, 0, 'C');
$pdf->SetX(160);
$pdf->Cell(40, 6, utf8_decode('Recibió '), 0, 'C');
$pdf->Ln(14);
$pdf->Cell(70, 4, '', 'B', 0, 'L');
$pdf->SetX(130);
$pdf->Cell(70, 4, '', 'B', 0, 'L');
$pdf->Ln(6);
//$pdf->Cell(75, 4, utf8_decode($aval), 0, 0, 'C');
$pdf->SetX(137);
$pdf->Cell(90, 6, ' '.utf8_decode($user_pre.' '.$user_papell), 0, 'C');

$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 8, utf8_decode('PÁGINA: ' . $pdf->PageNo() . '/{nb}'), 0, 0, 'C');
$pdf->Cell(0, 8, utf8_decode('CMSI-022'), 0, 1, 'R');

$pdf->Output();
