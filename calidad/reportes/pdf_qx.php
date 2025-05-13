<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';

$anio = @$_POST['anio'];

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
   

   
    $this->Ln(35);
  }}
  function Footer()
  {
    $this->SetFont('Arial', '', 8);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 5, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 5, 'SIMA-7.02', 0, 1, 'R');
  }
}
 

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 127);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX(25);
$pdf->Cell(160, 8, utf8_decode('REPORTE DE ESPECIALIDAD'), 1, 0, 'C');
$pdf->Ln(11);

$aniofinal = @$_POST['aniofinal'];
$finicio=date_create($anio);
$ffin=date_create($aniofinal);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(153, 7, utf8_decode('Reporte del ' . date_format($finicio,'d-m-Y') . ' al ' . date_format($ffin,'d-m-Y')),0, 'L');


$pdf->SetFont('Arial', 'B', 7);

$pdf->Ln(11);

$pdf->Cell(5, 8, utf8_decode('#'), 1, 'L');
$pdf->Cell(160, 8, utf8_decode('DIAGNÓSTICO'), 1, 'L');
$pdf->Cell(25, 8, utf8_decode('CANTIDAD'), 1, 'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 7);
$sql_tabla = "SELECT tipo_a, COUNT(id_atencion) as cuantos FROM `dat_INGRESO` WHERE (fech_egreso BETWEEN '2025/01/01' AND '2025/01/31' )  GROUP BY 1 HAVING COUNT(id_atencion)>=1 ORDER BY cuantos DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->Cell(5, 5, utf8_decode($no), 1, 'L');
      $pdf->Cell(160, 5, utf8_decode($row_tabla['tipo_a']), 1, 'L');
      $pdf->Cell(25, 5, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $total = $total + $row_tabla['cuantos'];
      $pdf->Ln(5);
      $no++;
    }

$pdf->Setx(175);
$pdf->Cell(25, 5, utf8_decode('Total: '.$total),1, 0,'L');

$pdf->Output();