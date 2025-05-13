<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id_atencion'];

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id = @$_GET['id'];

     include '../../conexionbd.php';
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 20, 5, 35, 15);
    //$this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],57,1, 100, 25);
    //$this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 238, 14, 40, 18);
}   $this->Ln(-8);
    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
    $this->Cell(0, 20, utf8_decode('TARJETA DE IDENTIFICACIÓN'), 0, 0, 'C');
    $this->SetDrawColor(43, 45, 127);
    
    $this->Line(60, 16, 160,16);
    $this->Line(60, 17, 160,17);
  }
  function Footer()
  {

    $this->SetFont('Arial', 'B', 7);
    $this->Ln(19);
    $this->SetY(-15);
    
    $fecha_actual = date("d/m/Y");

    $this->Cell(0, 10, utf8_decode('Fecha: ' . $fecha_actual), 0, 0, 'L');
    $this->SetX(100);
    $this->Cell(110, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-14.02'), 0, 1, 'R');
  }
}

$sql_reg_usu = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp, di.tipo_a FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.id_usua";

$result_reg_usu = $conexion->query($sql_reg_usu);
while ($row_reg_usu = $result_reg_usu->fetch_assoc()) {
  $pre = $row_reg_usu['pre'];
  $papell = $row_reg_usu['papell'];
  $sapell = $row_reg_usu['sapell'];
  $nombre = $row_reg_usu['nombre'];
  $id_exp = $row_reg_usu['Id_exp'];
   $tipo_a = $row_reg_usu['tipo_a'];
}

$sql_pac = "SELECT p.*, di.*  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $folio = $row_pac['folio'];
  $pac_papell = $row_pac['papell'];
  $pac_sapell = $row_pac['sapell'];
  $pac_nom_pac = $row_pac['nom_pac'];
  $pac_dir = $row_pac['dir'];
  $pac_id_edo = $row_pac['id_edo'];
  $pac_id_mun = $row_pac['id_mun'];
  $pac_tel = $row_pac['tel'];
  $pac_fecnac = $row_pac['fecnac'];
  $alergias = $row_pac['alergias'];
  $motivo_atn = $row_pac['motivo_atn'];
  $fecha = $row_pac['fecha'];
  $tip_san = $row_pac['tip_san'];
  $religion = $row_pac['religion'];
  $edad = $row_pac['edad'];
  $curp = $row_pac['curp'];
  $sexo = $row_pac['sexo'];
}


//$pdf = new PDF('L');
$pdf = new PDF('L', 'mm', array(216,140));

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(20);
$pdf->SetTextColor(43, 45, 127);
$pdf->SetFont('Arial', '', 14);

$pdf->SetX(20);
$pdf->Cell(76, 8, utf8_decode('PACIENTE No. ' . $folio . ' - ' .$pac_papell . ' ' . $pac_sapell  . ' ' . $pac_nom_pac), 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(1);
$pdf->SetX(20);
$pdf->Cell(13, 8, utf8_decode('CURP:'), 0, 0, 'L');
$pdf->Cell(50, 8, utf8_decode($curp), 0, 'L');
$pdf->Cell(43, 8, utf8_decode('FECHA DE NACIMIENTO:'), 0, 0, 'L');
$fecnac=date_create($pac_fecnac);
$pdf->Cell(22, 8, utf8_decode(date_format($fecnac,"d/m/Y")), 0, 'L');
$pdf->Cell(13, 8, utf8_decode('SEXO:'), 0, 0, 'L');
$pdf->Cell(20, 8, utf8_decode($sexo), 0, 'C');
$pdf->Cell(4, 8, utf8_decode('EDAD:'), 0, 0, 'L');
$pdf->MultiCell(30, 8, utf8_decode($edad), 0, 'C');
$pdf->Ln(1);
$pdf->SetX(20);
$pdf->Cell(63, 8, utf8_decode('FECHA Y HORA DE INGRESO:'), 0, 0, 'L');
$fecha_ing=date_create($fecha);
$pdf->MultiCell(150, 8, utf8_decode(date_format($fecha_ing,"d/m/Y H:i") . ' horas'), 0, 'L');
$pdf->Ln(1);
$pdf->SetX(20);
$pdf->Cell(63, 8, utf8_decode('MÉDICO TRATANTE:'), 0, 0, 'L');
$pdf->MultiCell(150, 8, utf8_decode($pre . '. ' . $papell), 0, 'L');
$pdf->Ln(1);
$pdf->SetX(20);
$pdf->Cell(63, 8, utf8_decode('SERVICIO:'), 0, 0, 'L');
$pdf->MultiCell(150, 8, utf8_decode($tipo_a), 0, 'L');
$pdf->Ln(1);
$pdf->SetX(20);
$pdf->Cell(63, 8, utf8_decode('DX:'), 0, 0, 'L');
$pdf->MultiCell(100, 8, utf8_decode($motivo_atn), 0, 'L');

$pdf->Ln(1);
$pdf->SetX(20);

$pdf->Cell(63, 8, utf8_decode('ALERGIAS:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(150, 8, utf8_decode($alergias), 0, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 11);
$pdf->SetX(20);
$pdf->Cell(63, 8, utf8_decode('TIPO DE SANGRE:'), 0, 0, 'L');
$pdf->MultiCell(150, 8, utf8_decode($tip_san), 0, 'L');
$pdf->Ln(1);
$pdf->SetX(20);
$pdf->Cell(63, 8, utf8_decode('RELIGIÓN:'), 0, 0, 'L');
$pdf->MultiCell(150, 8, utf8_decode($religion), 0, 'L');

$pdf->SetX(25);
$pdf->Cell(43, 9, utf8_decode('RIESGO DE CAIDAS:  _______________                      RIESGO DE UUP:  _______________'), 0, 0, 'L');


$pdf->Output();
