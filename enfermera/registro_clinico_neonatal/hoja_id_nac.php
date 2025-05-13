<?php

use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
//require('../../fpdf/MultiCellBlt.php');
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
    
  function Header()
  {
      include '../../conexionbd.php';
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 16, 8, 50, 20);
    //$this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],57,1, 100, 25);
    //$this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 14, 35, 15);
}
  
    $this->SetFont('Arial', 'B', 24);
    $this->SetTextColor(43, 45, 127);
    $this->Ln(2);
        $this->Cell(68, 9, utf8_decode(''), 0, 'C');
    $this->MultiCell(115, 9, utf8_decode('HOJA DE IDENTIFICACIÓN DEL RECIÉN NACIDO'), 0, 'C');
    $this->Ln(11);
   // $this->SetDrawColor(43, 45, 127);
    //$this->Line(68, 28, 158, 28);
  }
   function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('SIMA-14.01'), 0, 1, 'R');
  }
}



$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 17);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(158, 9.5, utf8_decode('Huella del pie derecho'), 0, 'C');
$pdf->Image('cuadro.png',15,52.5,184);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 5, 205, 5);

$pdf->Line(8, 5, 8, 280);
$pdf->Line(205, 5, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(101);
$pdf->SetX(18);
$pdf->Cell(60, 6, utf8_decode('APELLIDOS DEL RECIÉN NACIDO:'), 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(120, 5.5, utf8_decode(''), 'B', 'L');
$pdf->Ln(8);
$pdf->SetX(18);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(44, 6, utf8_decode('NOMBRE DE LA MADRE:'), 0,0,'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(136, 5, utf8_decode(''), 'B', 0, 'L');
$pdf->Ln(8);
$pdf->SetX(18);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 6, 'FECHA DE NACIMIENTO: ', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 5.5, '', 'B', 'C');
$pdf->Cell(20, 5.5, '', '', 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(43, 6, 'HORA DE NACIMIENTO: ', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(32, 5, utf8_decode(''), 'B', 'C');
$pdf->Ln(8);
$pdf->SetX(18);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(49, 6, utf8_decode('SEXO:  ' . 'H             ' . 'M'), 0, 'L');
$pdf->Image('cir.png',36.5,175.5,5.5); //H
$pdf->Image('cir.png',52.5,175.5,5.5); //M

$pdf->Cell(13, 6, utf8_decode('PESO:  ' . '                        ' . 'Kg'), 0, 'L');
$pdf->Cell(23, 4.5, utf8_decode(''), 'B', 'C');

$pdf->Cell(10, 4.5, utf8_decode(''), '', 'C');

$pdf->Cell(14.5, 6, utf8_decode('TALLA:  ' . '                     ' . 'cm'), 0, 'L');
$pdf->Cell(21.5, 4.5, utf8_decode(''), 'B', 'C');

$pdf->Cell(11, 4.5, utf8_decode(''), '', 'C');
$pdf->Cell(9, 6, utf8_decode('PIE:  ' . '                        ' . 'cm'), 0, 'L');
$pdf->Cell(24, 4.5, utf8_decode(''), 'B', 'C');

$pdf->Ln(8);
$pdf->SetX(18);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(16, 6, utf8_decode('APGAR: '), 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(27, 5, utf8_decode(''), 'B', 'L');

$pdf->Cell(10, 5, utf8_decode(''), '', 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(24, 6, utf8_decode('SILVERMAN: '), 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(32, 5, utf8_decode(''), 'B', 'L');

$pdf->Cell(10, 5, utf8_decode(''), '', 'L');


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(21, 6, utf8_decode('CAPURRO: '), 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 5, utf8_decode(''), 'B', 'L');

$pdf->Ln(8);
$pdf->SetX(18);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(43, 6, utf8_decode('PERÍMETRO CEFÁLICO:                                     ' .'cm'), 0, 'L');  
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 5, utf8_decode('') , 'B', 'L');
$pdf->Cell(15, 5, utf8_decode('') , '', 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(44, 6, utf8_decode('PERÍMETRO TORÁXICO:                                        '.'cm'), 0, 'L');  
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(38.5, 5, utf8_decode('') , 'B', 'L');

$pdf->Ln(8);
$pdf->SetX(18);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(46.5, 6, utf8_decode('PERÍMETRO ABDOMINAL:                                     ' .'cm'), 0, 'L');  
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 5, utf8_decode('') , 'B', 'L');

$pdf->Ln(8);
$pdf->SetX(18);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(54, 6, utf8_decode('NOMBRE DE LA ENFERMERA:'), 0, 'L');  
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(126, 5, utf8_decode('') , 'B', 'L');

$pdf->Ln(8);
$pdf->SetX(18);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(61, 6, utf8_decode('NOMBRE Y FIRMA DEL PEDIATRA:'), 0, 'L');  
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(119, 5, utf8_decode('') , 'B', 'L');

$pdf->Ln(8);
$pdf->SetX(18);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(49, 6, utf8_decode('VITAMINA K:    ' . 'SI             ' . 'NO'), 0, 'L');
$pdf->Image('cir.png',50,223.5,5.5); //SI
$pdf->Image('cir.png',68,223.5,5.5); //NO

$pdf->Cell(12, 5, utf8_decode('') , '', 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(49, 6, utf8_decode('CLORANFENICOL:    ' . 'SI             ' . 'NO'), 0, 'L');
$pdf->Image('cir.png',121,223.5,5.5); //SI
$pdf->Image('cir.png',139,223.5,5.5); //NO

$pdf->Ln(8);
$pdf->SetX(18);
$pdf->Cell(35, 6, utf8_decode('OBSERVACIONES: '), 0, 0, 'L');
$pdf->Cell(145, 5.5, utf8_decode(''), 'B', 'L');

$pdf->Ln(23);
$pdf->SetFont('Arial', '', 6.7);
$pdf->SetX(23.5);
$pdf->MultiCell(110, 3, utf8_decode('PRIMERA EDICIÓN Documento controlado. Prohibida su reproducción parcial o total.
La información contenida es de tipo confidencial y para uso exclusivo de CLÍNICA MÉDICA SI,
S.C. Josefa Ortiz de Domínguez #444 Barrio Coaxustenco, C.P. 52140 Metepec, Méx.
TEL. 722 235 0175 correo: msm@medicasanisidro.org'), 0, 'C');

$pdf->SetY(253.5);
$pdf->SetX(113.5);
$pdf->MultiCell(110, 3, utf8_decode('M.C. Eva María Ortiz Ramírez
Especialidad en Anestesiología y Algología
R.F.P. 3081665 C.E. 4860451
Universidad Nacional Autónoma de México
Licencia Sanitaria 17-AM-15-054-0003'), 0, 'C');

 $pdf->Output();
