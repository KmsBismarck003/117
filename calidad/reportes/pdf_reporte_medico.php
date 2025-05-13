<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';

$mes = @$_POST['mes'];
$anio = @$_POST['anio'];

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

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX(25);
$pdf->Cell(150, 5, utf8_decode('REPORTE DE DIAGNÓSTICOS MENSUAL'), 1, 0, 'C');
$pdf->Ln(11);

$pdf->Cell(30, 11, utf8_decode($mess.' '.$anio),0, 'L');
$pdf->Ln(11);

$pdf->Cell(10, 11, utf8_decode('#
    '), 1, 'L');
$pdf->Cell(150, 11, utf8_decode('DIAGNÓSTICO'), 1, 'L');
$pdf->Cell(30, 11, utf8_decode('CANTIDAD'), 1, 'L');
$pdf->Ln(11);
$pdf->SetFont('Arial', '', 10);
$sql_tabla = "SELECT motivo_atn, COUNT(motivo_atn) as cuantos FROM `dat_ingreso`

 WHERE MONTH(fecha)=$mes and YEAR(fecha)=$anio GROUP BY 1 HAVING COUNT(motivo_atn)>=1 ORDER BY cuantos DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->Cell(10, 11, utf8_decode($no), 1, 'L');
      $pdf->Cell(150, 11, utf8_decode($row_tabla['motivo_atn']), 1, 'L');
      $pdf->Cell(30, 11, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $pdf->Ln(11);
      $no++;
    }

   $pdf->Output();