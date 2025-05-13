<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$fecha = @$_GET['fecha'];


$sql_dat_sang = "SELECT * FROM dat_trans_sangre where id_atencion = $id_atencion and fecht = '$fecha'";
$result_dat_sang = $conexion->query($sql_dat_sang);

while ($row_dat_sang = $result_dat_sang->fetch_assoc()) {
  $id_sangre = $row_dat_sang['id_sangre'];
}

if(isset($id_sangre)){
    $id_sangre = $id_sangre;
  }else{
    $id_sangre ='sin doc';
  }

if($id_sangre=="sin doc"){
 echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "ESTE PACIENTE NO CUENTA CON REGISTROS DE TRANSFUSIÓN SANGUINEA", 
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
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id = @$_GET['id'];;
   include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 55, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],98,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 250, 16, 38, 14);
}

   $this->Ln(33);
  }  
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-15.07'), 0, 1, 'R');
  } 
}

$sql_pac = "SELECT * FROM paciente where  Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $resp = $row_pac['resp'];
  $fecnac = $row_pac['fecnac'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
}

$sql_camas = "SELECT * from cat_camas where id_atencion=$id_atencion";
$result_cama = $conexion->query($sql_camas);

while ($row_cama = $result_cama->fetch_assoc()) {
  $num_cama = $row_cama['num_cama'];
}

if(isset($num_cama)){
   $num_cama = $num_cama;
}else{
  $num_cama='SIN CAMA';
}

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $tipo_a = $row_dat_ing['tipo_a'];
  $id_usua = $row_dat_ing['id_usua'];
}

$resultado1 = $conexion ->query("SELECT * FROM dat_trasfucion where id_atencion = $id_atencion and fec_tras = '$fecha' order by id_tras ASC")or die($conexion->error);
while ($row_dat_sang = $resultado1->fetch_assoc()) {
$co=$row_dat_sang['glob_tras'];
$fol_tras=$row_dat_sang['fol_tras'];
$hb_tras=$row_dat_sang['hb_tras'];
$hto_tras=$row_dat_sang['hto_tras'];
$san_tras=$row_dat_sang['san_tras'];
}


$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
$pdf->sety(40);
$pdf->SetX(90);
    $pdf->SetTextColor(43, 45, 127);
$pdf->Cell(115, 5, utf8_decode('HOJA DE REGISTRO DE TRANSFUSIONES EN EL EXPEDIENTE CLINICO'), 0, 0, 'C');
$pdf->SetFont('Arial', '', 7);
date_default_timezone_set('America/Guatemala');
$fecha_act = date("d/m/Y H:i a");
$pdf->SetX(254);
$pdf->Cell(35, 5, utf8_decode('FECHA: '.$fecha_act), 0, 1, 'L');




$pdf->sety(46.5);
$pdf->SETX(9.5);

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 6, 'PACIENTE: ', 0, 'L');
$pdf->Cell(80, 5.5, utf8_decode($id_atencion . ' - ' .$papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->Cell(10, 6, ' EDAD: ', 0, 'L');
//$edad=calculaedad($fecnac);
$pdf->Cell(16, 5.5, utf8_decode($edad), 'B', 'C');
$pdf->Cell(14, 6,utf8_decode(' GÉNERO: '), 0, 'L');
$pdf->Cell(18, 5.5,  $sexo, 'B', 'L');
$pdf->Cell(18,6,utf8_decode(' HABITACIÓN: '),0,'L');
$pdf->Cell(13,5.5,utf8_decode($num_cama),'B','L');
$pdf->Cell(32,6,utf8_decode(' FECHA DE NACIMIENTO: '),0,'L');
$fecnac=date_create($fecnac);
$pdf->Cell(15,5.5,utf8_decode(date_format($fecnac,"d/m/Y")),'B','L');
$pdf->Cell(29,6, utf8_decode(' GRUPO SANGUÍNEO:'), 0, 'L');
$pdf->Cell(16,5.5, utf8_decode($san_tras), 'B', 'L');
$pdf->Ln(7);
$pdf->Cell(19,6,utf8_decode('DIAGNÓSTICO: '),0,'L');
$pdf->Cell(102,5.5,utf8_decode($motivo_atn),'B','L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(36,6, utf8_decode(' COMPONENTE SANGUÍNEO:'), 0, 'L');
$pdf->Cell(27,5.5, utf8_decode($co), 'B', 'L');
$pdf->Cell(11.5,6, utf8_decode(' FOLIO:'), 0, 'L');
$pdf->Cell(12,5.5, utf8_decode($fol_tras), 'B', 'L');
$pdf->Cell(22,6, utf8_decode(' HEMOGLOBINA:'), 0, 'L');
$pdf->Cell(12,5.5, utf8_decode($hb_tras), 'B', 'L');
$pdf->Cell(22,6, utf8_decode(' HEMATOCRITO:'), 0, 'L');
$pdf->Cell(12,5.5, utf8_decode($hto_tras), 'B', 'L');


 
$pdf->sety(60);
$pdf->SetFont('Arial', 'B', 6);
$pdf->MultiCell(15,3, utf8_decode('Fecha de transfusión'), 1, 'C');
$pdf->sety(60);
$pdf->setx(25);
$pdf->MultiCell(12,3, utf8_decode('No. de la unidad'), 1, 'C');
$pdf->sety(60);
$pdf->setx(37);
$pdf->MultiCell(31,6, utf8_decode('Contenido'), 1, 'C');
$pdf->sety(60);
$pdf->setx(68);
$pdf->MultiCell(14,6, utf8_decode('Hora inicio'), 1, 'C');
$pdf->sety(60);
$pdf->setx(82);
$pdf->MultiCell(65,3, utf8_decode('Signos vitales'), 1, 'C');
$pdf->sety(63);
$pdf->setx(82);
$pdf->MultiCell(15,3, utf8_decode('Secuencia'), 1, 'C');
$pdf->sety(63);
$pdf->setx(97);
$pdf->MultiCell(15,3, utf8_decode('TA'), 1, 'C');
$pdf->sety(63);
$pdf->setx(112);
$pdf->MultiCell(20,3, utf8_decode('F.C'), 1, 'C');
$pdf->sety(63);
$pdf->setx(132);
$pdf->MultiCell(15,3, utf8_decode('Temp.'), 1, 'C');
$pdf->sety(60);
$pdf->setx(147);
$pdf->MultiCell(17,6, utf8_decode('Hora término'), 1, 'C');
$pdf->sety(60);
$pdf->setx(164);
$pdf->MultiCell(18,6, utf8_decode('Volumen Trans.'), 1, 'C');
$pdf->sety(60);
$pdf->setx(182);
$pdf->MultiCell(19,3, utf8_decode('Nombre de quien la aplicó'), 1, 'C');
$pdf->sety(60);
$pdf->setx(201);
$pdf->MultiCell(90,6, utf8_decode('Estado general del paciente y observaciones'), 1, 'C');
$pdf->SetFont('Arial', '', 6);
$resultado1 = $conexion ->query("SELECT * FROM dat_trans_sangre where id_atencion = $id_atencion and fecht = '$fecha' ")or die($conexion->error);

foreach ($resultado1 as $fech) {
     $pdf->Cell(15,15, utf8_decode($fech['fecht']), 1, 0, 'C');
     $pdf->Cell(12,15, utf8_decode($fech['numt']), 1, 0, 'C');
     $pdf->Cell(31,15, utf8_decode($fech['cont']), 1, 0, 'C');
     $pdf->Cell(14,15, utf8_decode($fech['hor_in']), 1, 0, 'C');
     $pdf->Ln(15);
   }
 $pdf->sety(66);
  $pdf->setx(97);
  foreach ($resultado1 as $ta) {

    $pdf->setx(97);
     $pdf->Cell(15,5, utf8_decode($ta['t'].'/'.$ta['a']), 1,0, 'C');
     $pdf->Ln(5);
     $pdf->setx(97);
     $pdf->Cell(15,5, utf8_decode($ta['td'].'/'.$ta['ad']), 1,0, 'C');
     $pdf->Ln(5);
     $pdf->setx(97);
     $pdf->Cell(15,5, utf8_decode($ta['tde'].'/'.$ta['ade']), 1,0, 'C');
     $pdf->Ln(5);
     
     
   } 

  $pdf->sety(66);
  $pdf->setx(82);
  foreach ($resultado1 as $ta) {
    $pdf->setx(82);
    $pdf->Cell(15,5, utf8_decode('ANTES'), 1,0, 'L');
    $pdf->Ln(5);
    $pdf->setx(82);
    $pdf->Cell(15,5, utf8_decode('DURANTE'), 1,0, 'L');
    $pdf->Ln(5);
    $pdf->setx(82);
    $pdf->Cell(15,5, utf8_decode('DESPUES'), 1,0, 'L');
    $pdf->Ln(5);
}

  $pdf->sety(66);
  $pdf->setx(112);
foreach ($resultado1 as $fc) {
  $pdf->setx(112);
  $pdf->Cell(20,5, utf8_decode($fc['fc']), 1,0, 'C');
  $pdf->Ln(5);
  $pdf->setx(112);
  $pdf->Cell(20,5, utf8_decode($fc['fcd']), 1,0, 'C');
  $pdf->Ln(5);
  $pdf->setx(112);
  $pdf->Cell(20,5, utf8_decode($fc['fcde']), 1,0, 'C');
  $pdf->Ln(5);
}

  $pdf->sety(66);
  $pdf->setx(122);
foreach ($resultado1 as $temp) {
  $pdf->setx(132);
  $pdf->Cell(15,5, utf8_decode($temp['temp_t']), 1,0, 'C');
  $pdf->Ln(5);
  $pdf->setx(132);
  $pdf->Cell(15,5, utf8_decode($temp['temp_td']), 1,0, 'C');
  $pdf->Ln(5);
  $pdf->setx(132);
  $pdf->Cell(15,5, utf8_decode($temp['temp_tde']), 1,0, 'C');
  $pdf->Ln(5);
}
  $pdf->sety(66);
  $pdf->setx(147);
foreach ($resultado1 as $hort) {
  $pdf->setx(147);
  $pdf->Cell(17,15, utf8_decode($hort['hor_t']), 1, 0, 'C');
  $pdf->Cell(18,15, utf8_decode($hort['vol']), 1, 0, 'C');
  $pdf->Cell(19,15, utf8_decode($hort['nom']), 1, 0, 'C');
  $pdf->MultiCell(90,3, utf8_decode($hort['estgen']), 1,'J');
  $pdf->Ln(6);
}
$pdf->Ln(6);

$pdf->sety(130);
$pdf->setx(10);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(288,6,utf8_decode('RECOMENDACIONES : '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(6);
$pdf->MultiCell(280.5,4,utf8_decode('1.-EL SERVICIO CLINICO DEBERA MANTENER LA UNIDAD EN TEMPERATURAS Y CONDICIONES ADECUADAS QUE ASEGUREN SU VIABILIDAD.
2.-ANTES DE CADA TRANSFUSIÓN DEBERA VERIFICARSE LA IDENTIDAD DEL RECEPTOR Y DE LA UNIDAD DESIGNADA PARA ESTE.
3.-NO SE DEBERA AGREGAR A LA UNIDAD NINGUN MEDICAMENTO O SOLUCIÓN, INCLUSO LAS DESTINADAS PARA USO INTRAVENOSO, CON EXCEPCIÓN DE SOLUCIÓN SALINA AL 0.9% CUANDO ASI SEA NECESARIO.
4.-LA TRANSFUSIÓN DE CADA UNIDAD NO DEBERA EXCEDER DE 4 HORAS.
5.-LOS FILTROS DEBERÁN CAMBIARSE CADA 6 HRS. O CUANDO HUBIESEN TRANSFUNDIDO 4 UNIDADES.
6.-DE PRESENTARSE UNA REACCIÓN TRANSFUCIONAL,SUSPENDER INMEDIATAMENTE LA TRANSFUCIÓN, NOTIFICAR AL MEDICO ENCARGADO Y REPORTAR AL BANCO DE SANGRE, SIGUIENDO LAS INSTRUCCIONES SEÑALADAS EN EL FORMATO DE REPORTE QUE ACOMPAÑA A LA UNIDAD.
7.-EN CASO DE NO TRANSFUNDIR LA UNIDAD, REGRESARLA AL BANCO DE SANGRE O SERVICIO DE TRANSFUSIÓN PREFERENTEMENTE ANTES DE TRANSCURRIDAS 2 HORAS A PARTIR DE QUE LA UNIDAD SALIO DEL BANCO DE SANGRE O DEL SERVICIO DE TRANSFUSIÓN. '),0,'J');
 $pdf->Output();
}