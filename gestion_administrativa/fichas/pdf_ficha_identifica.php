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

    $id = @$_GET['id'];;

    $this->Image('../../imagenes/logo PDF.jpg', 10, 10, 28, 30);
    $this->SetFont('Arial', 'B', 18);
    $this->Cell(0, 20, utf8_decode('FICHA DE IDENTIFICACIÓN'), 0, 0, 'C');
    $this->SetDrawColor(0, 0, 0);
    $this->Line(90, 28, 200, 28);
    $this->Line(90, 29, 200, 29);
  }
  function Footer()
  {
    $this->SetFont('Arial', 'B', 10);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 5, date('d/m/Y'), 0, 1, 'R');
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
}
function calculaedad($fechanacimiento)
{
  list($ano, $mes, $dia) = explode("-", $fechanacimiento);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($dia_diferencia < 0 || $mes_diferencia < 0)
    $ano_diferencia--;
  return $ano_diferencia;
}

$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetX(25);
$pdf->Cell(75, 16, utf8_decode('NOMBRE:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac), 0, 'L');

$pdf->SetX(25);
$pdf->Cell(75, 16, utf8_decode('EDAD:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode(calculaedad($pac_fecnac) . ' AÑOS'), 0, 'L');

$pdf->SetX(25);
$pdf->Cell(75, 16, utf8_decode('FECHA DE NACIMIENTO:'), 0, 0, 'L');
$fecnac=date_create($pac_fecnac);
$pdf->MultiCell(150, 16, utf8_decode(date_format($fecnac,"d-m-Y")), 0, 'L');

$pdf->SetX(25);
$pdf->Cell(75, 16, utf8_decode('MÉDICO:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($pre . ' ' . $papell . ' ' . $sapell . ' ' . $nombre), 0, 'L');

$pdf->SetX(25);
$pdf->Cell(75, 16, utf8_decode('SERVICIO:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($tipo_a), 0, 'L');

$pdf->SetX(25);
$pdf->Cell(75, 16, utf8_decode('DX:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($motivo_atn), 0, 'L');

$pdf->SetX(25);
$pdf->Cell(75, 16, utf8_decode('ALERGIAS:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($alergias), 0, 'L');

$pdf->SetX(25);
$pdf->Cell(75, 16, utf8_decode('FECHA DE INGRESO:'), 0, 0, 'L');
$fecha_ing=date_create($fecha);
$pdf->MultiCell(150, 16, utf8_decode(date_format($fecha_ing,"d-m-Y")), 0, 'L');

$pdf->SetX(25);
$pdf->Cell(75, 16, utf8_decode('TIPO DE SANGRE:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($tip_san), 0, 'L');

$pdf->Output();
