<?php

//use PDF as GlobalPDF;

require '../../../fpdf/fpdf.php';
include '../../../conexionbd.php';
$id_atencion = @$_GET['id_atencion'];
$id_exp = @$_GET['id_exp'];
$id_datfin=@$_GET['id_datfin'];
//$id_usua=@$_GET['id_usua'];


mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {

    include '../../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../../configuracion/admin/img2/".$bas, 7, 8, 48, 28);
    $this->Image("../../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
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

function calculaedad($fechanacimiento)
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


$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $fecha = $row_dat_ing['fecha'];
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $cajero = $row_dat_ing['cajero'];
  $cama_alta=$row_dat_ing['cama_alta'];
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p where p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $expediente = $row_pac['Id_exp'];
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
/*
$sql_hab = "SELECT * from cat_camas where id_atencion=$id_atencion";
$result_hab = $conexion->query($sql_hab);

while ($row_hab = $result_hab->fetch_assoc()) {
  $numcam = $row_hab['num_cama'];
  $tipo = $row_hab['tipo'];
}
if(isset($numcam)){
 $numcam=$numcam;
}else{
  $numcam='SIN HABITACIÓN';
}
*/
$sql_fin = "SELECT * from cta_pagada where id_atencion=$id_atencion ";
$result_fin = $conexion->query($sql_fin);

while ($row_fin = $result_fin->fetch_assoc()) {
  $total = $row_fin['total'];
  $usuario=$row_fin['id_usua'];
}

$resultado_total = $conexion->query("SELECT * FROM dat_financieros where id_atencion = $id_atencion AND BANCO = 'DESCUENTO'") or die($conexion->error);
        $total_dep = 0;
        $no = 1;
        while ($row_total = $resultado_total->fetch_assoc()) {
          $total_dep = $row_total['deposito'] + $total_dep;
        }

$total = $total - $total_dep;         

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
    $mes='AGOSTO';
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
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 127);
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetX(35);
$pdf->MultiCell(150, 7, utf8_decode('RECIBO DE PAGO'),0, 'C');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 50, 172, 50);
$pdf->Line(48, 41, 48, 50);
$pdf->Line(172, 41, 172, 50);
$pdf->Line(48, 41, 172, 41);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 52, 205, 52);
$pdf->Line(8, 52, 8, 140);
$pdf->Line(205, 52, 205, 140);
$pdf->Line(8, 140, 205, 140);


$pdf->SetFont('Arial', '', 8);

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode('EXPEDIENTE: '), 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(7, 6, utf8_decode($id_exp),'B',0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 6, utf8_decode('PACIENTE: '),0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(145, 6, utf8_decode($papell . ' ' . $sapell . ' ' .$nom_pac ),'B', 'L');

$nac=date_create($fecnac);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(37, 6,'FECHA DE NACIMIENTO: ',0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 6,date_format($nac,"d/m/Y"),'B',0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 6, 'EDAD: ', 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 6,utf8_decode(calculaedad($fecnac)),'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10,6,'SEXO: ',0,'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17,6,$sexo,'B','L');
$pdf->SetX(135);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25,6,utf8_decode('HABITACIÓN: '),0,'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40,6,utf8_decode($cama_alta),'B',0,'C');

$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pre = $row_reg_usrs['pre'];
  $user_papell = $row_reg_usrs['papell'];
  $user_sapell = $row_reg_usrs['sapell'];
  $user_nombre = $row_reg_usrs['nombre'];
}

$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 6, utf8_decode('DIAGNÓSTICO: '), 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 6,utf8_decode($motivo_atn), 'B', 'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 6, 'LA CANTIDAD DE :', 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6,utf8_decode("$ ".number_format($total,2)) , 'B', 'L');
$pdf->SetX(90);
$date=date_create($fecha);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 6, 'FECHA DE INGRESO : ', 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(78, 6, date_format($date,"d/m/Y H:i a"), 'B', 'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 6, 'MEDICO TRATANTE', 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 6,utf8_decode($user_pre.". ".$user_papell." ".$user_sapell), 'B', 'L');

$pdf->ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 6, utf8_decode('METEPEC, MÉXICO A, '. $dia.' '.$mes.' '.$ano ) ,0,0, 'C');
$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$cajero";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pre = $row_reg_usrs['pre'];
  $user_papell = $row_reg_usrs['papell'];
  $user_sapell = $row_reg_usrs['sapell'];
  $user_nombre = $row_reg_usrs['nombre'];
}
$pdf->Ln(12);
$pdf->SetX(8);
$pdf->Cell(80, 6, 'PAGA ', 0,0, 'C');
$pdf->SetX(120);
$pdf->Cell(80, 6,utf8_decode("RECIBE"), 0,0, 'C');
$pdf->Ln(8);
$pdf->Cell(80, 4, '', 'B', 0, 'L');
$pdf->SetX(120);
$pdf->Cell(80, 4, '', 'B', 0, 'L');
$pdf->Ln(6);
$pdf->SetX(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80, 4,utf8_decode("NOMBRE COMPLETO Y FIRMA"), 0, 0, 'C');
$pdf->SetX(120);
$pdf->Cell(80, 6, utf8_decode(' '.$user_pre.' '.$user_papell.' '.$user_sapell.' '.$user_nombre), 0,0, 'C');
$pdf->Ln(12);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 8, utf8_decode('PÁGINA: ' . $pdf->PageNo() . '/{nb}'), 0, 0, 'C');
$pdf->Cell(0, 8, utf8_decode('CMSI-021'), 0, 1, 'R');

$pdf->Output();
