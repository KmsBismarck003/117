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
    $this->Ln(7);
    $this->Image('../../imagenes/logo PDF 2.jpg', 160, 20, 40, 20);
  }
}

 


$anio = @$_POST['anio'];
$diagn = @$_POST['diag'];
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

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX(25);
$pdf->Cell(150, 5, utf8_decode('10 PRINCIPALES CAUSAS DE MORBILIDAD'), 1, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 7, utf8_decode($anio),0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(10, 7, utf8_decode('#'), 1, 'L');
$pdf->Cell(90, 7, utf8_decode('DIAGNÓSTICO'), 1, 'L');
$pdf->Cell(20, 7, utf8_decode('CANTIDAD'), 1, 'L');
$pdf->Ln(7);$sql_tabla = "SELECT motivo_atn, COUNT(motivo_atn) as cuantos FROM `dat_ingreso` WHERE YEAR(fecha)=$anio GROUP BY 1 HAVING COUNT(motivo_atn)>=0 ORDER BY cuantos DESC LIMIT 10";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;

 while ($row_tabla = $result_tabla->fetch_assoc()) {
  $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(10, 7, utf8_decode($no), 1, 'L');
      $pdf->SetFont('Arial', '', 6);
      $pdf->Cell(90, 7, utf8_decode($row_tabla['motivo_atn']), 1, 'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(20, 7, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $pdf->Ln(7);
      $no++;
    }

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(90, 7, utf8_decode('10 INTERVENCIONES QUIRÚRGICAS'),0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(10, 5, utf8_decode('#'), 1, 'L');
$pdf->Cell(90, 5, utf8_decode('DIAGNÓSTICO'), 1, 'L');
$pdf->Cell(20, 5, utf8_decode('CANTIDAD'), 1, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$sql_tabla = "SELECT diag_postop, COUNT(diag_postop) as cuantos FROM `dat_not_inquir` WHERE YEAR(fecha)=$anio GROUP BY 1 HAVING COUNT(diag_postop)>=1 ORDER BY cuantos DESC LIMIT 10";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->Cell(10, 7, utf8_decode($no), 1, 'L');
      $pdf->SetFont('Arial', '', 6);
      $pdf->Cell(90, 7, utf8_decode($row_tabla['diag_postop']), 1, 'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(20, 7, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $pdf->Ln(7);
      $no++;
    }

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(90, 7, utf8_decode('NÚMERO DE DEFUNCIÓNES'),0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(100, 5, utf8_decode(''), 1, 'L');
$pdf->Cell(20, 5, utf8_decode('CANTIDAD'), 1, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$sql_tabla = "SELECT COUNT(id_egreso) as cuantos FROM `dat_egreso` WHERE cond='DEFUNCION' and YEAR(fech_egreso)=$anio ";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(100, 7, utf8_decode('TOTAL DE DEFUNCIÓNES EN EL AÑO DE '.$anio), 1, 'L');
      $pdf->Cell(20, 7, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $pdf->Ln(7);
      $no++;
    }
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(90, 7, utf8_decode('NÚMERO DE NACIMIENTOS'),0, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(100, 7, utf8_decode(''), 1, 'L');
$pdf->Cell(20, 7, utf8_decode('CANTIDAD'), 1, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$sql_tabla = "SELECT COUNT( DISTINCT(idrecien_nacido)) as cuantos FROM `dat_not_neona` WHERE YEAR(fecha_neona)=$anio ";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(100, 7, utf8_decode('TOTAL DE NACIMIENTOS EN EL AÑO DE '.$anio), 1, 'L');
      $pdf->Cell(20, 7, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $pdf->Ln(7);
      $no++;
    }

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(90, 7, utf8_decode('NUMERO TOTAL DE INGRESOS'),0, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(100, 7, utf8_decode(''), 1, 'L');
$pdf->Cell(20, 7, utf8_decode('CANTIDAD'), 1, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$sql_tabla = "SELECT COUNT(id_atencion) as cuantos FROM `dat_ingreso` WHERE YEAR(fecha)=$anio ";
  $result_tabla = $conexion->query($sql_tabla); 
 while ($row_tabla = $result_tabla->fetch_assoc()) {
  $pdf->Cell(100, 7, utf8_decode('TOTAL  DE INGRESOS EN EL AÑO DE '.$anio), 1, 'L');
  $pdf->Cell(20, 7, utf8_decode($row_tabla['cuantos']), 1, 'L');
    }

   $pdf->Output();
