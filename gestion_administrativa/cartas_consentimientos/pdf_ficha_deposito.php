<?php

use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
//require('../../fpdf/MultiCellBlt.php');
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$id_usua=@$_GET['id_usua'];

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id = @$_GET['id'];;

     include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 28);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
  }}
  function Footer()
  {
    $this->SetFont('Arial', '', 8);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, 'MAC-008', 0, 1, 'R');
  }
}


$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $fecha_ing = $row_dat_ing['fecha'];
  $id_usua = $row_dat_ing['id_usua'];
  $tipo_a = $row_dat_ing['tipo_a'];
}



/*$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p where p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);*/

$sql_pac = "SELECT * FROM paciente  where Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  
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

function calculaedad5($fechanacimiento)
{
  list($ano, $mes, $dia) = explode("-", $fechanacimiento);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($ano_diferencia > 0 )
      return ($ano_diferencia . ' AÑOS');
  else if ($mes_diferencia > 0 || $ano_diferencia < 0)
      return ($mes_diferencia . ' MESES');
   else if ($dia_diferencia > 0 || $mes_diferencia < 0 || $ano_diferencia < 0)
      return ($dia_diferencia . ' DÍAS');
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
  $numcam='SIN CAMA';
}

$sql_fin = "SELECT * from dat_financieros where id_atencion=$id_atencion";
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
    $mes='ENERO';
  }

 if ($mes==2) {
    $mes='FEBRERO';
  }
   if ($mes==3) {
    $mes='MARZO';
  }
 if ($mes==4) {
    $mes='ABRIL';
  }
  if ($mes==5) {
    $mes='MAYO';
  }
   if ($mes==6) {
    $mes='JUNIO';
  }
   if ($mes==7) {
    $mes='JULIO';
  }
   if ($mes==8) {
    $mes='AOSTO';
  }
   if ($mes==9) {
    $mes='SEPTIEMBRE';
  }
   if ($mes==10) {
    $mes='OCTUBRE';
  }
   if ($mes==11) {
    $mes='NOVIEMBRE';
  }
   if ($mes==12) {
    $mes='DICIEMBRE';
  }

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('DEPÓSITO'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 55, 205, 55);
$pdf->Line(8, 55, 8, 280);
$pdf->Line(205, 55, 205, 280);
$pdf->Line(8, 280, 205, 280);


$pdf->SetFont('Arial', '', 8);


$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 6, 'SERVICIO: ', 0, 'L');  
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(175, 6, utf8_decode($tipo_a), 'B', 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 6, utf8_decode('EXPEDIENTE: '), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 6, utf8_decode($id_exp), 'B', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(38, 6, ' NOMBRE DEL PACIENTE: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(122, 6, utf8_decode($nom_pac.' '.$papell . ' ' . $sapell ), 'B', 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$date=date_create($fecha_ing);
$pdf->Cell(33, 6, utf8_decode('FECHA DE INGRESO:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, date_format($date,'d/m/Y'), 'B', 0, 'C');


$pdf->SetFont('Arial', '', 8);
$date=date_create($fecnac);
$pdf->Cell(37, 6, ' FECHA DE NACIMIENTO: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, date_format($date,"d/m/Y"), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(14, 6, ' EDAD: ', 0, 'L');

$edad=calculaedad5($fecnac);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6, utf8_decode($edad), 'B', 0, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(13, 6, ' SEXO: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6,  $sexo, 'B', 0, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(6);
$pdf->Cell(25, 6, utf8_decode('DIAGNÓSTICO: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(125, 6,$motivo_atn, 'B', 'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 6, utf8_decode('MÉTODO DE PAGO : '), 0, 'L');
$pdf->SetX(50);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(58, 6, $metodo_pago, 'B', 'L');

$pdf->SetX(110);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 6, 'LA CANTIDAD DE : $', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(58, 6, number_format($deposito,2), 'B', 'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 6, 'CANTIDAD CON LETRA: ', 0, 'L');
$pdf->SetX(50);
$pdf->SetFont('Arial', '', 8);
$letra = strtoupper($dep_l);
$pdf->Cell(150, 6,utf8_decode($letra), 'B', 'L');

$pdf->Ln(12);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 5, utf8_decode('TOLUCA, MÉXICO A '. $dia.' '.$mes.' '.$ano ), 0, 1, 'C');

$pdf->Ln(6);
$pdf->SetX(10);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 6, 'DEPOSITA ', 0, 0, 'C');
$pdf->SetX(140);
$pdf->Cell(60, 6, 'RECIBE ', 0, 0, 'C');
$pdf->Ln(15);
$pdf->Cell(60, 4, '', 'B', 0, 'C');
$pdf->SetX(140);
$pdf->Cell(60, 4, '', 'B', 0, 'C');
$pdf->Ln(6);
$pdf->SetX(10);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 6, $aval, 0, 0, 'C');
$pdf->SetX(140);
$pdf->Cell(60, 6, ' '.$user_pre.' '.$user_papell.' '.$user_sapell.' '.$user_nombre, 0, 0, 'C');

$pdf->Output();
