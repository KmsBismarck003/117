<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {

  
include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 59, 30);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],120,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 290, 16, 50, 20);
}

$this->Ln(33);
    $this->SetTextColor(43, 45, 127);
    
    $this->SetDrawColor(43, 45, 180);
    

     $this->SetFont('Arial', 'B', 10);
    $this->SetX(98);
    $this->Cell(145, 10, utf8_decode('DEVOLUCIONES DE FARMACIA'), 1, 0, 'C');
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
      
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
        $this->Cell(0, 10, utf8_decode('CMSI-38'), 0, 1, 'R');
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


$sql = "SELECT * FROM item i, devolucion d WHERE i.item_id = d.dev_item and d.dev_estatus = 'NO' order by d.fecha desc";
$result = $conexion->query($sql);

$rowcount = mysqli_num_rows($result);
if ($rowcount != 0) {
    while ($row_tabla = $result->fetch_assoc()) {
    $fecdev=date_create($row_tabla['fecha']);
    $item_name = $row_tabla['item_name'];
    $item_grams = $row_tabla['item_grams'];
    $item_code = $row_tabla['item_code'];

    $pdf->Cell(24, 5, date_format($fecdev,"d/m/Y H:i"), 1, 0, 'L');
    $pdf->Cell(125, 5, utf8_decode($item_code .'-' .$item_name .', '. $item_grams), 1, 0, 'L'); 
    $pdf->Cell(18, 5, utf8_decode($row_tabla['dev_qty']), 1, 0, 'R');
    $pdf->Cell(20, 5, utf8_decode($row_tabla['cant_inv']), 1, 0, 'R');
    $pdf->Cell(18, 5, utf8_decode($row_tabla['cant_mer']), 1, 0, 'R');
    $pdf->Cell(120, 5, utf8_decode($row_tabla['paciente'].', ' .$row_tabla['motivoi'].', ' .$row_tabla['motivom']), 1, 0, 'L');

    $pdf->Ln(5);
    }
  } else {


  }

$pdf->Ln(8);
$pdf->SetX(30);



$pdf->Output();
