<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';

mysqli_set_charset($conexion, "utf8");

date_default_timezone_set('America/Mexico_City');

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id = @$_GET['id'];

  $this->Image('../../imagenes/SI.PNG', 5, 15, 65, 21);
    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
    $this->Cell(320, 9, utf8_decode(' Médica San Isidro'), 0, 0, 'C');
    $this->Ln(10);
    $this->SetDrawColor(43, 45, 180);
    $this->Line(85, 18, 250, 18);
    $this->SetFont('Arial', '', 8);
    $this->Cell(320, 8, utf8_decode('CALLE JOSEFA ORTIZ DE DOMÍNGUEZ #444'), 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(320, 8, utf8_decode('BARRIO COAXUSTENCO, METEPEC, ESTADO DE MÉXICO'), 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(320, 8, 'TEL: (01722) 235-01-75 / 235-02-12 / 902-03-90 / C.P. 52140', 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(320, 8, 'https://medicasanisidro.com/', 0, 0, 'C');
    $this->Ln(10);
    $this->Image('../../imagenes/en.png', 290, 22, 45, 15);
  
    $this->SetFont('Arial', 'B', 10);
    $this->SetX(98);
    $this->Cell(145, 10, utf8_decode('DEVOLUCIONES DE CARRO ROJO OBSERVACIÓN'), 1, 0, 'C');
    $this->SetFont('Arial', '', 10);
    $this->SetX(300);
    $fecha_actual = date("Y-m-d H:i");
    $date1=date_create($fecha_actual);

    $this->Cell(35, 10, 'FECHA: ' . date_format($date1,"d/m/Y H:i"), 0, 1, 'R');
    $this->Ln(4);  
    $this->SetFont('Arial', '', 8);
    $this->Cell(24, 5, utf8_decode('Fecha y hora'), 1, 0, 'C');
    $this->Cell(125, 5, utf8_decode('Descripción'), 1, 0, 'C');
    $this->Cell(18, 5, utf8_decode('Cantidad'), 1, 0, 'C');
    $this->Cell(20, 5, utf8_decode('Inventario'), 1, 0, 'C');
    $this->Cell(18, 5, utf8_decode('Merma'), 1, 0, 'C');
    $this->Cell(120, 5, utf8_decode('Paciente y Motivo'), 1, 0, 'C');
    $this->Ln(5);
   
   
  }
     function Footer()
  {
    $this->Ln(8);
    $this->SetFont('Arial', '', 7);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-44'), 0, 1, 'R');
  }
  }

$pdf = new PDF('L','mm','legal');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetMargins(10, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,20); 

$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 180);

$sql = "SELECT * FROM material_ceye i, devolucion_ceye d WHERE i.material_id = d.id_dev_ceye and d.dev_estatus = 'NO'";
$result = $conexion->query($sql);

$rowcount = mysqli_num_rows($result);
if ($rowcount != 0) {
    while ($row_tabla = $result->fetch_assoc()) {
       $fecdev=date_create($row_tabla['fecha']);
       $item_name = $row_tabla['material_nombre'];
       $item_grams = $row_tabla['material_contenido'];
       $item_code = $row_tabla['material_codigo'];

       $pdf->Cell(24, 5, date_format($fecdev,"d/m/Y H:i"), 1, 0, 'L');
       $pdf->Cell(125, 5, utf8_decode($item_code .'-' .$item_name .', '. $item_grams), 1, 0, 'L'); 
 
       $pdf->Cell(18, 5, utf8_decode($row_tabla['dev_cantidad']), 1, 0, 'R');
       $pdf->Cell(20, 5, utf8_decode($row_tabla['cant_inv']), 1, 0, 'R');
       $pdf->Cell(18, 5, utf8_decode($row_tabla['cant_mer']), 1, 0, 'R');
       $pdf->Cell(120, 5, utf8_decode($row_tabla['paciente'].', ' .$row_tabla['motivoi']), 1, 0, 'L');

       $pdf->Ln(5);
     }
  } else {


  }

$pdf->Ln(8);
$pdf->SetX(30);



$pdf->Output();
