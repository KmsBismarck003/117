<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';

$anio = @$_POST['anio'];
$fec_inicial = date("Y-m-d",strtotime($anio."+ 1 day"));
$aniofinal = @$_POST['aniofinal'];
$fec_final = date("Y-m-d",strtotime($aniofinal."+ 1 day"));

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
    $this->Ln(33);
    $this->SetFont('Arial', 'B', 12);
    $this->SetTextColor(43, 45, 127);
    $this->SetDrawColor(43, 45, 127);
    $this->Cell(195, 8, utf8_decode('REPORTE DE CUENTAS POR COBRAR '), 1, 0, 'C');
    $this->Ln(12);
  }}
  function Footer()
  {
    $this->SetFont('Arial', '', 8);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, 'CMSI-7.02', 0, 1, 'R');
  }
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 127);

$fechai = date_create($anio);
$fechai = date_format($fechai, "d/m/Y");
$fechaf = date_create($aniofinal);
$fechaf = date_format($fechaf, "d/m/Y");

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 11, utf8_decode('Periódo del   '). $fechai. '  al  ' . $fechaf ,0, 'L');
$pdf->Ln(11);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(10, 7, utf8_decode('#'), 1, 0, 'C');
$pdf->Cell(10, 7, utf8_decode('Exp'), 1, 0, 'C');
$pdf->Cell(12, 7, utf8_decode('Id Atn'), 1, 0, 'C');
$pdf->Cell(15, 7, utf8_decode('Ingreso'), 1, 0, 'C');
$pdf->Cell(15, 7, utf8_decode('Alta'), 1, 0, 'C');
$pdf->Cell(82, 7, utf8_decode('Nombre del Paciente'), 1, 0, 'C');
$pdf->Cell(16, 7, utf8_decode('Importe'), 1, 0, 'C');
$pdf->Cell(35, 7, utf8_decode('Método de Pago'), 1, 0, 'C');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 7);

    $total = 0;
    $subtotal = 0;
    $no = 1;
    $sql_tabla = "SELECT DISTINCT(f.id_atencion), i.*, p.*, i.fecha as fec_ingreso, f.fecha, f.deposito, f.banco FROM dat_financieros f, dat_ingreso i, paciente p, cta_pagada c WHERE f.deposito > 0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and (i.fec_egreso BETWEEN '$fec_inicial' AND '$fec_final') and (f.banco='ASEGURADORA' OR f.banco='CUENTAS POR COBRAR') ORDER BY p.nom_pac ASC";
    $result_tabla = $conexion->query($sql_tabla);
    while ($row_tabla = $result_tabla->fetch_assoc()) {
        $total = 0;
        
        $Id_exp = $row_tabla['Id_exp'];
        $id_atencion = $row_tabla['id_atencion'];
        $fec_egr = date_create($row_tabla['fec_egreso']);
        $fec_ing = date_create($row_tabla['fec_ingreso']);
        $sql_cta = "SELECT total from cta_pagada c WHERE c.id_atencion = $id_atencion";
        $result_cta = $conexion->query($sql_cta);
        while ($row_cta = $result_cta->fetch_assoc()) {
            $total = $row_cta['total'];
            $subtotal=$subtotal+$total;
        }
        $pdf->Cell(10, 7, utf8_decode($no), 1, 'L');
        $pdf->Cell(10, 7, $Id_exp, 1, 'L');
        $pdf->Cell(12, 7, $id_atencion, 1, 'L');
        $pdf->Cell(15, 7, date_format($fec_ing,'d/m/Y'), 1, 'L');
        $pdf->Cell(15, 7, date_format($fec_egr,'d/m/Y'), 1, 'L');
        $pdf->Cell(82, 7, utf8_decode($row_tabla['nom_pac'].' '.$row_tabla['papell'].' '.$row_tabla['sapell']), 1, 'L');
        $pdf->Cell(16, 7, number_format($total,2), 1, 0, 'R');
        $pdf->Cell(35, 7, utf8_decode($row_tabla['aseg']), 1, 'L');
        $pdf->Ln(7);
        $no++;
    }
    $pdf->Cell(32, 7, 'TOTAL: $ '. number_format($subtotal,2), 1, 'L');
    

$pdf->Output();
