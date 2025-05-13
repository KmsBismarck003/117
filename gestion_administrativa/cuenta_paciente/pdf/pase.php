<?php
use PDF as GlobalPDF;
require '../../../fpdf/fpdf.php';
include '../../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$sql_egreso = "SELECT * from alta where id_atencion=$id_atencion";
$result_egreso = $conexion->query($sql_egreso);
while ($row_egreso = $result_egreso->fetch_assoc()) {
  $id_alta = $row_egreso['id_alta'];
}

if(isset($id_alta)){
    $id_alta = $id_alta;
  }else{
    $id_alta ='sin doc';
  }

if($id_alta=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE AVISO DE ALTA PARA ESTE PACIENTE", 
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
    include '../../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];
    $this->Image("../../../configuracion/admin/img2/".$bas, 7, 8, 48, 28);
    $this->Image("../../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}
    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
    $this->Ln(10);
    $this->Ln(4);
    $this->Ln(4);
    $this->Ln(4);
    $this->Ln(10);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-022'), 0, 1, 'R');
  }
}


$date = date("d/m/Y");
$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);
while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $fecha_ing=$row_dat_ing['fecha'];
  $cama_alta=$row_dat_ing['cama_alta'];
 
}

$sql_pac = "SELECT * FROM paciente where Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);
while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  $Id_exp = $row_pac['Id_exp'];
  $dir = $row_pac['dir'];
  $id_edo = $row_pac['id_edo'];
  $id_mun = $row_pac['id_mun'];
  $tel = $row_pac['tel'];
  $ocup = $row_pac['ocup'];
  $resp = $row_pac['resp'];
  $paren = $row_pac['paren'];
  $tel_resp = $row_pac['tel_resp'];
  $fecnac = $row_pac['fecnac'];
  $fechanac=date_create($fecnac);
  $folio = $row_pac['folio'];
}


$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 127);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Ln(3);
$pdf->SetX(88);
$pdf->Cell(150, 5, utf8_decode('PASE DE SALIDA'), 0, 'C');
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 55, 205, 55);
$pdf->Line(8, 55, 8, 280);
$pdf->Line(205, 55, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(87);
$pdf->Cell(150, 5, utf8_decode('DATOS DEL PACIENTE'), 0, 'C');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(21, 6, utf8_decode('PACIENTE: '),0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(171, 5, utf8_decode($papell . ' ' . $sapell.' '.$nom_pac ),'B', 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45,6,utf8_decode('FECHA DE NACIMIENTO: '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28,5,date_format($fechanac,'d/m/Y'),'B',0,'C');
$pdf->SetX(90);
$pdf->Cell(26,6,utf8_decode('HABITACIÓN: '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15,5,utf8_decode($cama_alta),'B',0,'C');
$pdf->SetX(135);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(26, 6, utf8_decode('EXPEDIENTE: '), 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(15, 5, utf8_decode($folio),'B',0, 'C');
$pdf->Ln(2);


$fech_alta = date_create("Y-m-d");
$sql_egreso = "SELECT * from alta where id_atencion=$id_atencion";
$result_egreso = $conexion->query($sql_egreso);
while ($row_egreso = $result_egreso->fetch_assoc()) {
  $fech_alta = $row_egreso['fecha_altamed'];
  $alta_por = $row_egreso['alta_por'];
}

$pdf->Ln(6);
$pdf->SetX(10);
$fec_ing=date_create($fecha_ing);

$fecha_actual = date("d-m-Y H:i a");
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(39,6,utf8_decode('FECHA DE INGRESO: '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(44,6,utf8_decode(date_format($fec_ing,"d/m/Y H:i a")),'B','L');
$pdf->SetX(120);
//$fecha_alt=date_create($fec_egreso);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(38,6,utf8_decode('FECHA DE EGRESO: '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(44,6,utf8_decode($fecha_actual),'B','L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(39,6,utf8_decode('MÉDICO TRATANTE:   '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$sql_medee = "SELECT * from reg_usuarios where id_usua=$id_usua";
$result_ico = $conexion->query($sql_medee);
while ($r_me = $result_ico->fetch_assoc()) {
    $nomc=$r_me['papell'];
}

$pdf->Cell(153,6,utf8_decode($nomc),'B','L');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(39,6,utf8_decode('MOTIVO DE ALTA: '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(153,6,utf8_decode($alta_por),'B','L'); 


$fecha_actual = date("d-m-Y H:i a");


$pdf->ln(12);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(195, 6, utf8_decode('VERIFICACIÓN DE SALIDA' ) ,0,0, 'C');
$pdf->ln(12);


$fecha_alt=date_create($fech_alta);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(107,6,utf8_decode('ESTUDIOS, MATERIALES Y/O MEDICAMENTOS ENTREGADOS:   '),0,'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(85,5,utf8_decode(""),'B','L');
$pdf->ln(6);
$pdf->Cell(192,5,utf8_decode(""),'B','L');
$pdf->ln(6);
$pdf->Cell(192,5,utf8_decode(""),'B','L');
$pdf->ln(6);
$pdf->Cell(192,5,utf8_decode(""),'B','L');
$pdf->ln(6);
$pdf->Cell(192,5,utf8_decode(""),'B','L');
$pdf->ln(6);
$pdf->Cell(192,5,utf8_decode(""),'B','L');

$pdf->ln(20);
$pdf->SetX(10);
$pdf->cell(90,6,utf8_decode(''),'B','L');
$pdf->SetX(108);
$pdf->cell(95,6,utf8_decode(''),'B','L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->ln(7);
$pdf->SetX(24);
$pdf->Cell(60,6,utf8_decode('NOMBRE Y FIRMA DE QUIEN ASISTE EL ALTA'),0,'C');

$pdf->SetX(108);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20,6,utf8_decode('NOMBRE Y FIRMA DE QUIEN RECIBE MEDICAMENTOS Y ESTUDIOS'),0,'C');
$pdf->ln(10);
$pdf->SetX(6.8);
$pdf->Cell(1,6,utf8_decode('------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'),0,'C');
$pdf->ln(14);
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetX(67);
$pdf->Cell(150, 5, utf8_decode('PASE DE SALIDA (VIGILANCIA)'), 0, 'C');
$pdf->Ln(15);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 205, 172, 205);
$pdf->Line(48, 194, 48, 205);
$pdf->Line(172, 194, 172, 205);
$pdf->Line(48, 194, 172, 194);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(87);
$pdf->Cell(150, 5, utf8_decode('DATOS DEL PACIENTE'), 0, 'C');
$pdf->ln(15);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(22, 6, utf8_decode('PACIENTE: '),0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(171, 5, utf8_decode($papell . ' ' . $sapell. ' ' .$nom_pac),'B', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->ln(11);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45,6,utf8_decode('FECHA DE NACIMIENTO: '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28,5,date_format($fechanac,'d/m/Y'),'B',0,'C');
$pdf->SetX(110);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(26,6,utf8_decode('HABITACIÓN: '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(22,5,utf8_decode($cama_alta),'B',0,'C');
$pdf->ln(8);
$fecha_alt=date_create($fech_alta);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(39,6,utf8_decode('FECHA DE INGRESO: '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(44,6,utf8_decode(date_format($fec_ing,"d/m/Y H:i a")),'B','L');
$pdf->SetX(110);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50,6,utf8_decode('FECHA Y HORA DE SALIDA:   '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40,6,utf8_decode(date_format($fecha_alt,"d/m/Y H:i a")),'B',0,'C');



$pdf->Output();
}