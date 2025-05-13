<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';



mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $this->Image('../../imagenes/logo PDF.jpg', 10, 10, 28, 30);
    $this->SetFont('Arial', 'B', 14);
    $this->Cell(200, 8, 'Sanatorio Venecia', 0, 0, 'C');
    $this->Ln(10);
    $this->SetDrawColor(0, 0, 0);
    $this->Line(50, 18, 170, 18);
    $this->Line(50, 19, 170, 19);
    $this->SetFont('Arial', '', 10);
    $this->Cell(200, 8, 'PASEO TOLLOCAN NO. 113 COL. UNIVERSIDAD', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(200, 8, utf8_decode('C.P. 50130 TOLUCA, MÉX'), 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(200, 8, 'TEL.: (01 722) 280 5672', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(200, 8, 'www.sanatoriovenecia.com.mx', 0, 0, 'C');
    $this->Ln(10);
    $this->Image('../../imagenes/logo PDF 2.jpg', 160, 20, 40, 20);
  }
}

 


$anio = @$_POST['anio'];
$id_usua = @$_POST['id_usua'];
$mes = @$_POST['mes'];

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
if ($mes==1) {
    $mess='ENERO';
  }

 if ($mes==2) {
    $mess='FEBRERO';
  }
   if ($mes==3) {
    $mess='MARZO';
  }
 if ($mes==4) {
    $mess='ABRIL';
  }
  if ($mes==5) {
    $mess='MAYO';
  }
   if ($mes==6) {
    $mess='JUNIO';
  }
   if ($mes==7) {
    $mess='JULIO';
  }
   if ($mes==8) {
    $mess='Agosto';
  }
   if ($mes==9) {
    $mess='SEPTIMBRE';
  }
   if ($mes==10) {
    $mess='OCTUBRE';
  }
   if ($mes==11) {
    $mess='NOVIEMBRE';
  }
   if ($mes==12) {
    $mess='DICIEMBRE';
  }

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(25);
$pdf->Cell(150, 5, utf8_decode('REPORTE DE QUIRÚRGICO MENSUAL'), 1, 0, 'C');
$pdf->Ln(3);
$sql_usua = "SELECT * FROM reg_usuarios WHERE id_usua=$id_usua";
  $result = $conexion->query($sql_usua);
  while ($row_usuario= $result->fetch_assoc()) {
    $pre=$row_usuario['pre'];
    $nom_usua=$row_usuario['nombre'];
    $papell_usua=$row_usuario['papell'];
    $sapell_usua=$row_usuario['sapell'];
  }
$medico=$pre.'. '.$nom_usua.' '.$papell_usua.' '.$sapell_usua;
$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(30, 7, utf8_decode('MÉDICO: '.$medico),0, 'L');
$pdf->Ln(7);
$pdf->Cell(30, 7, utf8_decode($anio),0, 'L');
$pdf->Ln(7);
$pdf->Cell(90, 7, utf8_decode('MEDICO'), 1, 'L');
$pdf->Cell(90, 7, utf8_decode('TOTAL DE INTERVENCIÓN QUIRÚRGICAS'), 1, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$sql_tabla = "SELECT id_usua, COUNT(id_usua) as cuantos FROM `dat_not_inquir` WHERE id_usua=$id_usua GROUP BY 1 HAVING COUNT(id_usua)>=1 ORDER BY cuantos DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
    $total=$row_tabla['cuantos'];
      $pdf->Cell(90, 7, utf8_decode($medico), 1, 'L');
      $pdf->Cell(90, 7, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $pdf->Ln(7);
      $no++;
    }
   $sql = "SELECT DATEDIFF(fecha,fec_egreso)* -1 as estancia FROM dat_ingreso WHERE id_usua=$id_usua";
     $result_now = $conexion->query($sql);
     $dias_est=0;
    while ($row_now = $result_now->fetch_assoc()) {
      $dias_est=$dias_est+$row_now['estancia'];
    }

if ($dias_est != 0 && isset($total)) {
  $dias_est=($dias_est/$total); 
  
    $pdf->Cell(90, 7, utf8_decode('PROMEDIO DIAS ESTANCIA : '.number_format($dias_est,1).' DIAS'), 1, 'L');  
  }else{
    $pdf->Cell(90, 7, utf8_decode('PROMEDIO DIAS ESTANCIA : 0 DIAS'), 1, 'L');  

  }  

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(90, 7, utf8_decode('INTERVENCIONES QUIRÚRGICAS'),0, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(10, 7, utf8_decode('#'), 1, 'L');
$pdf->Cell(90, 7, utf8_decode('DIAGNÓSTICO'), 1, 'L');
$pdf->Cell(20, 7, utf8_decode('CANTIDAD'), 1, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$sql_tabla = "SELECT diag_postop, COUNT(diag_postop) as cuantos FROM `dat_not_inquir` WHERE id_usua=$id_usua GROUP BY 1 HAVING COUNT(diag_postop)>=1 ORDER BY cuantos DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $tot_cir=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->Cell(10, 7, utf8_decode($no), 1, 'L');
      $pdf->SetFont('Arial', '', 6);
      $pdf->Cell(90, 7, utf8_decode($row_tabla['diag_postop']), 1, 'L');
      $pdf->SetFont('Arial', '', 8);

      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(20, 7, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $pdf->Ln(7);
      $no++;
      $tot_cir=$tot_cir+$row_tabla['cuantos'];
    }
     $pdf->Cell(100, 7, utf8_decode('TOTAL  DE INTERVENCIONES QUIRÚRGICAS : '), 1, 'L');
  $pdf->Cell(20, 7, utf8_decode($tot_cir), 1, 'L');

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(90, 7, utf8_decode('INGRESOS'),0, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(10, 7, utf8_decode('#'), 1, 'L');
$pdf->Cell(90, 7, utf8_decode('DIAGNÓSTICO'), 1, 'L');
$pdf->Cell(20, 7, utf8_decode('CANTIDAD'), 1, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$sql_tabla = "SELECT motivo_atn, COUNT(motivo_atn) as cuantos, fecha as fecha_ing, fec_egreso FROM `dat_ingreso` WHERE id_usua=$id_usua GROUP BY 1 HAVING COUNT(motivo_atn)>=1 ORDER BY cuantos DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $tot_ing=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
  $ingreso=date_create($row_tabla['fecha_ing']);
  $ingreso=date_format($ingreso,"yyyy-mm-dd");

  $egreso=date_create($row_tabla['fec_egreso']);
  $egreso=date_format($egreso,"yyyy-mm-dd");
      $pdf->Cell(10, 7, utf8_decode($no), 1, 'L');
      $pdf->SetFont('Arial', '', 6);
      $pdf->Cell(90, 7, utf8_decode($row_tabla['motivo_atn']), 1, 'L');
      $pdf->SetFont('Arial', '', 8);

      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(20, 7, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $pdf->Ln(7);
      $no++;
      $tot_ing=$tot_ing+$row_tabla['cuantos'];
    }
  $pdf->Cell(70, 7, utf8_decode(' '), 1, 'L');
  $pdf->Cell(50, 7, utf8_decode('TOTAL  DE INGRESOS : '.$tot_ing), 1, 'L');


  /*

$sql_tabla = "SELECT motivo_atn, COUNT(motivo_atn) as cuantos, fecha as fecha_ing, fec_egreso FROM `dat_ingreso` WHERE MONTH(fecha)=$mes and YEAR(fecha)=$anio and id_usua=$id_usua GROUP BY 1 HAVING COUNT(motivo_atn)>=1 ORDER BY cuantos DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $dias_est=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
  $ingreso=date_create($row_tabla['fecha_ing']);
  $ingreso=date_format($ingreso,"yyyy-mm-dd");

  $egreso=date_create($row_tabla['fec_egreso']);
  $egreso=date_format($egreso,"yyyy-mm-dd");

  $sql_now = "SELECT DATEDIFF(day, '$ingreso', '$egreso') as estancia FROM dat_ingreso WHERE MONTH(fecha)=$mes and YEAR(fecha)=$anio and id_usua=$id_usua";
     $result_now = $conexion->query($sql_now);
    while ($row_now = $result_now->fetch_assoc()) {
          $estancia = $row_now['estancia'];
      $pdf->Cell(10, 7, utf8_decode($no), 1, 'L');
      $pdf->SetFont('Arial', '', 6);
      $pdf->Cell(90, 7, utf8_decode($row_tabla['motivo_atn']), 1, 'L');
      $pdf->SetFont('Arial', '', 8);

      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(20, 7, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $pdf->Ln(7);
      $no++;
      $dias_est=$dias_est+$estancia;
    }
  }
  */


   $pdf->Output();
