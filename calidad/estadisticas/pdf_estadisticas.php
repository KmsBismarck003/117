<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_med = @$_GET['id_med'];
$id_exp = @$_GET['id_exp'];
$mes = @$_POST['mes'];
$anio = @$_POST['anio'];
$sql_dat_eg = "SELECT * from encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result_dat_eg = $conexion->query($sql_dat_eg);

while ($row_dat_eg = $result_dat_eg->fetch_assoc()) {
  $id_encuesta = $row_dat_eg['id_encuesta'];
}

if(isset($id_encuesta)){
    $id_encuesta = $id_encuesta;
  }else{
    $id_encuesta ='sin doc';
  }

if($id_encuesta=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTEN DATOS PARA EL REPORTE DE ESTE MES", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                                window.close();
                            }
                        });
                    });
                </script>';
}else{

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
    $mess='AGOSTO';
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

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(190, 6, utf8_decode('REPORTE DE OBSERVACIONES DEL MES DE ' . $mess), 1, 0, 'C');

$pdf->Ln(9);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 6, utf8_decode('#'), 1, 0, 'C'); 
$pdf->Cell(175, 6, utf8_decode('OBSERVACIONES'), 1, 0, 'C');

$pdf->Ln(6);


$res = "SELECT id_encuesta,fecenc,obs FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $obs = $f['obs'];
   $id_encuesta = $f['id_encuesta'];
   $pdf->SetFont('Arial', 'B', 7);
  $pdf->Cell(15, 6, utf8_decode($id_encuesta), 1, 0, 'C'); 
  $pdf->SetFont('Arial', '', 7);
  $pdf->Cell(175, 6, utf8_decode($obs), 1, 0, 'C');
    $pdf->Ln(6);
}















    


















$sql_med_id = "SELECT id_usua FROM encuestas ORDER by  fecenc DESC LIMIT 1";
    $result_med_id = $conexion->query($sql_med_id);

    while ($row_med_id = $result_med_id->fetch_assoc()) {
      $id_med = $row_med_id['id_usua'];
    }
    $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_med";
    $result_med = $conexion->query($sql_med);

    while ($row_med = $result_med->fetch_assoc()) {
      $nom = $row_med['nombre'];
      $app = $row_med['papell'];
      $apm = $row_med['sapell'];
      $pre = $row_med['pre'];
      $firma = $row_med['firma'];
      $ced_p = $row_med['cedp'];

}
      $pdf->SetY(-43);
      $pdf->SetFont('Arial', 'B', 9);
      $pdf->Image('../../imgfirma/' . $firma, 83, 240, 35);
      $pdf->Ln(6);
      $pdf->SetX(75);
      $pdf->Cell(50, 4, utf8_decode('MEDICO: '.$pre . ' .' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
      $pdf->Ln(6);
      $pdf->SetX(20);
      $pdf->Cell(150, 4, utf8_decode('Cédula Profesional: ' . $ced_p), 0, 0, 'C');
      $pdf->SetX(55);
      $pdf->Cell(90, 4, utf8_decode(''), 'B', 'C');
      $pdf->Ln(6);
      $pdf->Cell(180, 4, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
     
       
  
      
 $pdf->Output();
}