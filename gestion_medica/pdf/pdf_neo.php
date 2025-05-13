<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_med = @$_GET['id_med'];
$id_neona = @$_GET['id_neona'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

$sql_inter = "SELECT * FROM dat_not_neona  where id_atencion = $id_atencion";
$result_inter = $conexion->query($sql_inter);

while ($row_inter = $result_inter->fetch_assoc()) {
$id_neona=$row_inter['id_neona'];
}
if(isset($id_neona)){
    $id_neona = $id_neona;
  }else{
    $id_neona ='sin doc';
  }

if($id_neona=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE NOTA NEONATOLOGICA PARA ESTA PACIENTE", 
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
    $this->Cell(0, 10, utf8_decode('MAC-5.05'), 0, 1, 'R');
  }
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac, p.folio FROM paciente p where p.Id_exp = $id_atencion";
$result_pac = $conexion->query($sql_pac);
while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  $id_exp = $row_pac['Id_exp'];
  $dir = $row_pac['dir'];
  $id_edo = $row_pac['id_edo'];
  $id_mun = $row_pac['id_mun'];
  $tel = $row_pac['tel'];
  $ocup = $row_pac['ocup'];
  $resp = $row_pac['resp'];
  $paren = $row_pac['paren'];
  $tel_resp = $row_pac['tel_resp'];
  $fecnac = $row_pac['fecnac'];
  $folio = $row_pac['folio'];
}



$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $fecha_ing=$row_dat_ing['fecha'];
  $tipo_a=$row_dat_ing['tipo_a'];
}
$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,32);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('NOTA DE RECIÉN NACIDO / NEONATOLOGÍA '), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);
$pdf->SetX(170);
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y H:i");
$pdf->Cell(35, -2, 'Fecha: ' . $fecha_actual, 0, 1, 'R');

$pdf->SetFont('Arial', '', 6);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 207, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(207, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(185, 3, utf8_decode('DATOS DE LA MADRE: '), 0, 'L');
$pdf->Ln(1);
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

$d="";
    $sql_motd = "SELECT diagprob_i from dat_not_ingreso where id_atencion=$id_atencion ORDER by id_not_ingreso DESC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } 
    $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by diagprob_i DESC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } ?>
    <?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
    $result_mot = $conexion->query($sql_mot);
    while ($row_mot = $result_mot->fetch_assoc()) {
    $m=$row_mot['motivo_atn'];
    } 
if ($d!=null) {
    $pdf->SetFont('Arial', 'B', 8);
  $pdf->Cell(20, 5, utf8_decode('Diagnóstico:') , 0, 'C');
  $pdf->SetFont('Arial', '', 9);
     $pdf->Cell(175, 5, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 5, utf8_decode('Motivo de atención:') , 0, 'C');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(166, 5, utf8_decode($m) , 'B', 'C');
    }



$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(5);

$sql_neo = "SELECT * FROM dat_not_neona where id_neona=$id_neona and id_atencion=$id_atencion";
$result_neo = $conexion->query($sql_neo);

while ($row_neo = $result_neo->fetch_assoc()) {
  $fecha_neona = $row_neo['fecha_neona'];
  $idrecien_nacido   = $row_neo['idrecien_nacido'];
  $pac_neon = $row_neo['pac_neon'];
  $subjetivo_neon = $row_neo['subjetivo_neon'];
  $objetivo_neon = $row_neo['objetivo_neon'];
  $analisis_neon = $row_neo['analisis_neon'];
  $plan_neon = $row_neo['plan_neon'];
  $px_neon = $row_neo['px_neon'];
  $edosalud_neon = $row_neo['edosalud_neon'];
  $guia_neon = $row_neo['guia'];

$p_sistol = $row_neo['p_sistol'];
$p_diastol = $row_neo['p_diastol'];
$fcard = $row_neo['fcard'];
$fresp = $row_neo['fresp'];
$temper = $row_neo['temper'];
$satoxi = $row_neo['satoxi'];

$peso = $row_neo['peso'];
$talla = $row_neo['talla'];
$apgar = $row_neo['apgar'];
$silver = $row_neo['silver'];
$an = $row_neo['an'];
$fnac = $row_neo['fecnacimiento'];
$hnac = $row_neo['horanac'];
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(185, 6, utf8_decode('DATOS DEL RECIEN NACIDO: '), 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(132, 4, utf8_decode('Identificación:' .' ' .$idrecien_nacido), 1, 'L');
$fnac=date_create($fnac);
$fnac=date_format($fnac,"d/m/Y");
$pdf->Cell(63, 4, 'Fecha de nacimiento: '. $fnac. ' Hora: '. $hnac, 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(185, 6, utf8_decode('SIGNOS VITALES DEL RECIEN NACIDO '), 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell(41, 3, utf8_decode('Presión arterial: ' .$p_sistol.'/'.$p_diastol.' mmHG/mmHG'), 1, 'L');
$pdf->Cell(34, 3, utf8_decode('Frecuencia cardiaca: ' .$fcard.' Lat/min'), 1, 'L');
$pdf->Cell(40, 3, utf8_decode('Frecuencia respiratoria: ' .$fresp.' Resp/min'), 1, 'L');
$pdf->Cell(23, 3, utf8_decode('Temperatura: ' .$temper.'°C'), 1, 'L');
$pdf->Cell(27, 3, utf8_decode('Saturación oxígeno: ' .$satoxi.'%'), 1, 'L');
$pdf->Cell(15, 3, utf8_decode('Peso: ' .$peso.' kg'), 1, 'L');
$pdf->Cell(16, 3, utf8_decode('Talla: ' .$talla) . ' cm', 1, 'L');


$pdf->Ln(3);
$pdf->Cell(41, 3, utf8_decode('Apgar: ' .$apgar), 1, 'L');
$pdf->Cell(34, 3, utf8_decode('Silverman: ' .$silver), 1, 'L');
$pdf->MultiCell(121, 3, utf8_decode('Anomalías congénitas: ' .$an), 1, 'L');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Paciente neonato: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode( $pac_neon), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Subjetivo: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode( $subjetivo_neon), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Objetivo: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode( $objetivo_neon), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Análisis: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode( $analisis_neon), 1, 'L');
$pdf->Ln(1);
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Plan: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode( $plan_neon), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Prónostico: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode( $px_neon), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Estado de salud: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($edosalud_neon), 1, 'L');
$pdf->Ln(1);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Guía práctica clínica: '),0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($guia_neon),1, 'L');



$sql_med_id = "SELECT id_usua FROM dat_not_neona WHERE id_neona = $id_neona";
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
 $cargp = $row_med['cargp'];
}
     
$pdf->Ln(20);
     
      $pdf->SetFont('Arial', 'B', 7);
      //$pdf->Image('../../imgfirma/' . $firma, 95, 245, 25);
  if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 240 , 30);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 240 , 30);
}
      $pdf->sety(256);
      $pdf->Cell(200, 3, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(200, 3, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->Cell(200, 3, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');

 $pdf->Output();
}