<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_pac = @$_GET['id_pac'];

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
    $this->Cell(0, 10, '', 0, 1, 'R');
  }
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 180);
$pdf->SetFont('Arial', 'B', 11);
$pdf->SETX(33);
$pdf->MultiCell(150, 6, utf8_decode('PRESUPUESTO'), 1, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 11);

$sql_rechosp = "SELECT * FROM presupuesto  where id_pac = $id_pac";
$result_rechosp = $conexion->query($sql_rechosp);

while ($row_rechosp = $result_rechosp->fetch_assoc()) {
  $nombre=$row_rechosp['nombre'];
}
$pdf->cell(195,6,utf8_decode('PACIENTE:        '.$nombre),1,'L');
$pdf->ln(10);

$pdf->SetFont('Arial', 'B', 11);
  $pdf->cell(10,6,utf8_decode(''),1,'L');
  $pdf->cell(30,6,utf8_decode('FECHA'),1,'L');
  $pdf->cell(80,6,utf8_decode('SERVICIO'),1,'L');
  $pdf->cell(25,6,utf8_decode('CANTIDAD'),1,'L');
  $pdf->cell(25,6,utf8_decode('PRECIO'),1,'L');
  $pdf->cell(25,6,utf8_decode('SUBTOTAL'),1,'L');
$pdf->ln(6);

$pdf->SetFont('Arial', '', 11);
$sql_rechosp = "SELECT * FROM presupuesto p,cat_servicios s where p.id_pac = $id_pac and p.id_serv=s.id_serv";
$result_rechosp = $conexion->query($sql_rechosp);
$no=1;
$total = 0;
while ($row_rechosp = $result_rechosp->fetch_assoc()) {
  $subtottal=$row_rechosp['serv_costo']*$row_rechosp['cantidad'];
  $pdf->cell(10,6,utf8_decode($no),1,'L');
  $date=date_create($row_rechosp['fecha']);
  $pdf->cell(30,6,utf8_decode(date_format($date,"d-m-Y")),1,'L');
  $pdf->cell(80,6,utf8_decode($row_rechosp['servicio']),1,'L');
  $pdf->cell(25,6,utf8_decode($row_rechosp['cantidad']),1,'L');
  $pdf->cell(25,6,utf8_decode('$'.number_format($row_rechosp['serv_costo'],2)),1,'L');
  $pdf->cell(25,6,utf8_decode('$'.number_format($subtottal,2)),1,'L');
  $total= $subtottal + $total;
  $no++;
$pdf->ln(6);
}

$sql_rechosp = "SELECT * FROM presupuesto p,item i where p.id_pac = $id_pac and p.id_serv=i.item_code";
$result_rechosp = $conexion->query($sql_rechosp);
while ($row_rechosp = $result_rechosp->fetch_assoc()) {
  $subtottal=$row_rechosp['item_price']*$row_rechosp['cantidad'];
  $pdf->cell(10,6,utf8_decode($no),1,'L');
  $date=date_create($row_rechosp['fecha']);
  $pdf->cell(30,6,utf8_decode(date_format($date,"d-m-Y")),1,'L');
  $pdf->cell(80,6,utf8_decode($row_rechosp['servicio']),1,'L');
  $pdf->cell(25,6,utf8_decode($row_rechosp['cantidad']),1,'L');
  $pdf->cell(25,6,utf8_decode('$'.number_format($row_rechosp['item_price'],2)),1,'L');
  $pdf->cell(25,6,utf8_decode('$'.number_format($subtottal,2)),1,'L');
  $total= $subtottal + $total;
  $no++;
$pdf->ln(6);
}
$pdf->SetX(165);
$pdf->cell(40,6,utf8_decode('TOTAL : '.'$'.number_format($total,2)),1,'L');

 $pdf->Output();