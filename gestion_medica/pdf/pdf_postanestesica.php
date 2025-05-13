<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_med = @$_GET['id_med'];
$id_postanest = @$_GET['id_post_anest'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

$sql_post = "SELECT * FROM dat_post_anest  where id_atencion = $id_atencion";
$result_post = $conexion->query($sql_post);
while ($row_post = $result_post->fetch_assoc()) {
  $id_post_anest = $row_post['id_post_anest'];
}

if(isset($id_post_anest)){
    $id_post_anest = $id_post_anest;
  }else{
    $id_post_anest ='sin doc';
  }

if($id_post_anest=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE REGISTRO NOTA POST-ANESTÉSICA PARA ESTE PACIENTE", 
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

    $id_atencion = @$_GET['id_atencion'];;
 include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}
   $this->Ln(32);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-7.05'), 0, 1, 'R');
  }
}

$sql_pac = "SELECT * FROM paciente  where Id_exp = $id_exp";
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
}


$sql_ing = "SELECT * FROM dat_ingreso  where Id_exp = $id_exp";
$result_ing = $conexion->query($sql_ing);
while ($row_ing = $result_ing->fetch_assoc()) {
  $especialidad = $row_ing['especialidad'];
  $fecha_ing = $row_ing['fecha'];
  $tipo_a= $row_ing['tipo_a'];
}

$sql_camas = "SELECT * FROM cat_camas  where id_atencion = $id_atencion";
$result_camas = $conexion->query($sql_camas);
while ($row_camas = $result_camas->fetch_assoc()) {

  $num_cama = $row_camas['num_cama'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,32);

 $pdf->SetTextColor(43, 45, 127);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(50);
$pdf->Cell(120, 5, utf8_decode('NOTA POST-ANESTESICA'), 0, 0, 'C');
$pdf->SetFont('Arial', '', 6);

$fecha_actual = date("d/m/Y H:i");
$pdf->Cell(35, 5, 'Fecha: ' . $fecha_actual, 0, 1, 'R');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 50, 207, 50);
$pdf->Line(8, 50, 8, 280);
$pdf->Line(207, 50, 207, 280);
$pdf->Line(8, 280, 207, 280);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 5, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 5, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 5, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 5, utf8_decode($folio), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 5, ' Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(146, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$date1=date_create($fecnac);
$pdf->Cell(31, 5, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 5, date_format($date1,"d/m/Y"), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 5, ' Edad: ', 0, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(13, 5, utf8_decode($edad),'B', 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(19, 5, utf8_decode(' Ocupación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(36, 5,  utf8_decode($ocup), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 5, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 5,  utf8_decode($tel), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 5, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 5,  $sexo, 'B', 'L');
$pdf->Ln(5);
$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$id_atencion ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_hc = $result_sig->fetch_assoc()) {
$pesoh=$row_hc['peso'];
$tallah=$row_hc['talla'];
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 5, utf8_decode('Peso: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 5,  utf8_decode($pesoh.' Kilos'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 5, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 5,  utf8_decode($tallah.' Metros'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 5, utf8_decode(' Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(125, 5, utf8_decode($dir), 'B', 'L');

$pdf->Ln(5);


$sql_post = "SELECT * FROM dat_post_anest  where id_post_anest = $id_postanest";
$result_post = $conexion->query($sql_post);
while ($row_post = $result_post->fetch_assoc()) {

  $tecan_pos = $row_post['tecan_pos'];
  $tiem_pos = $row_post['tiem_pos'];
  $an_pos = $row_post['an_pos'];
  $ad_pos = $row_post['ad_pos'];
  $con_pos = $row_post['con_pos'];
  $bal_pos = $row_post['bal_pos'];
  $sist_pos = $row_post['sist_pos'];
  $dias_pos = $row_post['dias_pos'];
  $fc_pos = $row_post['fc_pos'];
  $fr_pos = $row_post['fr_pos'];
  $temp_pos = $row_post['temp_pos'];
  $pul_pos = $row_post['pul_pos'];
  $so_pos = $row_post['so_pos'];
  $ae_pos = $row_post['ae_pos'];
  $san_pos = $row_post['san_pos'];
  $ven_pos = $row_post['ven_pos'];
  $dre_pos = $row_post['dre_pos'];
  $tras_pos = $row_post['tras_pos'];
  $ob_pos = $row_post['ob_pos'];
  $plan_pos = $row_post['plan_pos'];
  $fecha_pos = $row_post['fecha_pos'];
  $hora_pos = $row_post['hora_pos'];
}


$pdf->SetFont('Arial', '', 8);
$pdf->Ln(2);$pdf->setx(10);
$pdf->Cell(100,6, utf8_decode('Técnica anestésica: '.$tecan_pos),1,'L');
$pdf->Cell(90,6, utf8_decode('Tiempo anestésico: '.$tiem_pos),1,'L');

$pdf->setY(80);
$pdf->setx(10);
$pdf->MultiCell(32,6, utf8_decode('Medicamentos administrados'),1,'L');
$pdf->setY(80);
$pdf->setx(42);
$pdf->MultiCell(32,6, utf8_decode('Anestésicos'),1,'L');
$pdf->setY(80);
$pdf->setx(74);
$pdf->MultiCell(126,6, utf8_decode($an_pos),1,'L');
$pdf->setY(86);
$pdf->setx(42);
$pdf->MultiCell(32,6, utf8_decode('Adyuvantes'),1,'L');
$pdf->setY(86);
$pdf->setx(74);
$pdf->MultiCell(126,6, utf8_decode($ad_pos),1,'L');

$pdf->setY(93);
$pdf->setx(10);
$pdf->MultiCell(52,12, utf8_decode('Contingencias accidentales e incidentes atribuibles a la anestesia'),1,'L');
$pdf->setY(93);
$pdf->setx(62);
$pdf->MultiCell(138,24, utf8_decode($con_pos),1,'L');


$pdf->setY(117);
$pdf->setx(10);
$pdf->MultiCell(52,24, utf8_decode('Balance hídrico'),1,'L');
$pdf->setY(117);
$pdf->setx(62);
$pdf->MultiCell(138,24, utf8_decode($bal_pos),1,'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(6);
$pdf->setx(68);
$pdf->Cell(115,6, utf8_decode('Estado clínico del paciente al egreso del quirófano'),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->setY(152);
$pdf->setx(10);
$pdf->MultiCell(35,6, utf8_decode('Signos vitales'),1,'L');
$pdf->setY(152);
$pdf->setx(45);
$pdf->MultiCell(25,6, utf8_decode('T/A : '.$sist_pos.'/'.$dias_pos),1,'L');
$pdf->setY(152);
$pdf->setx(70);
$pdf->MultiCell(20,6, utf8_decode('F.C : '.$fc_pos),1,'L');
$pdf->setY(152);
$pdf->setx(90);
$pdf->MultiCell(20,6, utf8_decode('F.R : '.$fr_pos),1,'L');
$pdf->setY(152);
$pdf->setx(110);
$pdf->MultiCell(25,6, utf8_decode('Temperatura : '.$temp_pos),1,'L');
$pdf->setY(152);
$pdf->setx(135);
$pdf->MultiCell(25,6, utf8_decode('Pulso : '.$pul_pos),1,'L');
$pdf->setY(152);
$pdf->setx(160);
$pdf->MultiCell(40,6, utf8_decode('Sat oxígeno : '.$so_pos),1,'L');
$pdf->setY(158);
$pdf->setx(10);
$pdf->MultiCell(99,6, utf8_decode('Vía área : '.$ae_pos),1,'L');
$pdf->setY(158);
$pdf->setx(109);
$pdf->MultiCell(91,6, utf8_decode('Sangrado activo anormal : '.$san_pos),1,'L');
$pdf->setY(164);
$pdf->setx(10);
$pdf->MultiCell(99,6, utf8_decode('Permeabilidad de venoclisis : '.$ven_pos),1,'L');
$pdf->setY(164);
$pdf->setx(109);
$pdf->MultiCell(91,6, utf8_decode('Permeabilidad de sondas y drenajes :'.$dre_pos),1,'L');
$pdf->setY(170);
$pdf->setx(10);
$pdf->MultiCell(190,6, utf8_decode('Lugar y condiciones de traslado (incluir aldrete) : '.$tras_pos),1,'L');
$pdf->setY(176);
$pdf->setx(10);
$pdf->MultiCell(80,20, utf8_decode('Observaciones : '.$ob_pos),1,'L');
$pdf->setY(176);
$pdf->setx(90);
$pdf->MultiCell(110,10, utf8_decode('Plan de manejo y tratamiento, incluyendo protocolo de analgesia : '.$plan_pos),1,'L');

$pdf->setY(196);
$pdf->setx(10);
$pdf->MultiCell(99,6, utf8_decode('Fecha '.$fecha_pos),1,'L');
$pdf->setY(196);
$pdf->setx(109);
$pdf->MultiCell(91,6, utf8_decode('Hora '.$hora_pos),1,'L');
///////////////////FIRMA DE MEDICO 

$sql_med_id = "SELECT id_usua FROM dat_post_anest WHERE id_post_anest = $id_postanest";
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


      $pdf->Ln(20);
   
      $pdf->SetFont('Arial', 'B', 7);
      //$pdf->Image('../../imgfirma/' . $firma, 95, 245, 25);
       if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 245 , 25);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 245 , 25);
}
      $pdf->Ln(30);
      $pdf->SetX(89);
      $pdf->Cell(50, 4, utf8_decode('Médico: '.$pre . ' .' . $app), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetX(39);
      $pdf->Cell(150, 4, utf8_decode('Cédula profesional: ' . $ced_p), 0, 0, 'C');
      $pdf->SetX(65);
      $pdf->Cell(90, 4, utf8_decode(''), 'B', 'C');
      $pdf->Ln(6);
        $pdf->SetX(25);
      $pdf->Cell(180, 4, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
      


 $pdf->Output();
}