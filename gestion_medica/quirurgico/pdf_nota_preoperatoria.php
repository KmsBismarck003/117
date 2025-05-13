<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id'];
$id_preop = @$_GET['id_not_preop'];
$id_exp = @$_GET['id_exp'];
$id_med = @$_GET['id_med'];
$sql_preop = "SELECT * FROM dat_not_preop where id_atencion = $id_atencion";
$result_preop = $conexion->query($sql_preop);

while ($row_preop = $result_preop->fetch_assoc()) {
  $id_not_preop = $row_preop['id_not_preop']; 
}
if(isset($id_not_preop)){
    $id_not_preop = $id_not_preop;
  }else{
    $id_not_preop ='sin doc';
  }

if($id_not_preop=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE NOTA PREOPERATORIA PARA ESTE PACIENTE", 
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
    $this->Cell(0, 10, utf8_decode('CMSI-6.01'), 0, 1, 'R');
  }
}
$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.folio,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p where p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  $Id_exp = $row_pac['Id_exp'];
  $folio = $row_pac['folio'];
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

  


$sql_preop = "SELECT * FROM dat_ingreso where id_atencion = $id_atencion";
$result_preop = $conexion->query($sql_preop);

while ($row_preop = $result_preop->fetch_assoc()) {
 
    $tipo_a = $row_preop['tipo_a'];
    $fecha_ing = $row_preop['fecha'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,15);
$sql_ing = "SELECT * FROM dat_not_ingreso where id_atencion = $id_atencion";
$result_ing = $conexion->query($sql_ing);

while ($row_ing = $result_ing->fetch_assoc()) {
 $fecha_dat_ingreso=$row_ing['fecha_dat_ingreso'];
 $fecha_actual=$row_ing['fecha_dat_ingreso'];
 $mot_ingreso=$row_ing['mot_ingreso'];
 $resinterr_i=$row_ing['resinterr_i'];
 $expfis_i=$row_ing['expfis_i'];
 $resaux_i=$row_ing['resaux_i'];
 $diagprob_i=$row_ing['diagprob_i'];
 $plan_i=$row_ing['plan_i'];
 $des_diag=$row_ing['des_diag'];
 $pron_i=$row_ing['pron_i'];
  $guia=$row_ing['guia'];

}

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('NOTA PREOPERATORIA'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetX(170);

$pdf->SetFont('Arial', '', 6);

$date1=date_create($fecha_actual);
$pdf->Cell(35, -2, 'FECHA: ' . date_format($date1,"d/m/Y H:i"), 0, 1, 'R');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 207, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(207, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(6);

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
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$Id_exp ORDER by id_hc DESC LIMIT 1";
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
  $pdf->SetFont('Arial', '', 8);
     $pdf->Cell(175, 5, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 5, utf8_decode('Motivo de atención:') , 0, 'C');
         $pdf->SetFont('Arial', '', 8);
         $pdf->Cell(166, 5, utf8_decode($m) , 'B', 'C');
    }

$sql_sig ="select * from signos_vitales WHERE id_atencion=$id_atencion ORDER by id_sig DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_sig = $result_sig->fetch_assoc()) {
 $p_sistolica=$row_sig['p_sistol'];
 $p_diastolica=$row_sig['p_diastol'];
 $f_card=$row_sig['fcard'];
 $f_resp=$row_sig['fresp'];
 $temp=$row_sig['temper'];
 $sat_oxigeno=$row_sig['satoxi'];
 $niv_dolor=$row_sig['niv_dolor'];
}

$pdf->Ln(5.5);

$sql_pac = "SELECT * FROM paciente where Id_exp=$id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $fecnac = $row_pac['fecnac'];
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
  $edociv = $row_pac['edociv'];
}


$motivo_ing = " ";
$resumen_clin = " ";
$beneficios = " ";
$sql_noti = "SELECT * FROM dat_not_ingreso ning where ning.id_atencion = $id_atencion";
$result_noti = $conexion->query($sql_noti);

while ($row_noti = $result_noti->fetch_assoc()) {
  $motivo_ing = $row_noti['mot_ingreso'];
  $resumen_clin = $row_noti['resinterr_i'];
  $beneficios = $row_noti['expfis_i'];
}

$sql_ingreso = "SELECT * FROM dat_ingreso din where din.id_atencion = $id_atencion";
$result_ingreso = $conexion->query($sql_ingreso);

while ($row_ingreso = $result_ingreso->fetch_assoc()) {
  $tipo_a = $row_ingreso['tipo_a'];
  $fecha_ing = $row_ingreso['fecha'];
}

$sql_preop = "SELECT * FROM dat_not_preop pr where pr.id_not_preop=$id_preop";
$result_preop = $conexion->query($sql_preop);

while ($row_preop = $result_preop->fetch_assoc()) {
  $fecha_nota = $row_preop['fecha_preop'];
  $resumen_clin = $row_noti['resinterr_i'];
  $beneficios = $row_noti['expfis_i'];
  $tipo_cirugia_preop = $row_preop['tipo_cirugia_preop'];
  $cabeza = $row_preop['cabeza'];
  $cuello = $row_preop['cuello'];
  $torax = $row_preop['torax'];
  $abdomen = $row_preop['abdomen'];
  $extrem = $row_preop['extrem'];
  $colum_vert = $row_preop['colum_vert'];
//$resumen_clin = $row_preop['resumen_clin'];
//$beneficios = $row_preop['beneficios'];
//$result_lab_gab = $row_preop['result_lab_gab'];
  $diag_preop = $row_preop['diag_preop'];
  $pronostico = $row_preop['pronostico'];
  $riesgos = $row_preop['riesgos'];
  $cuidados = $row_preop['cuidados'];
  $tipo_inter_plan = $row_preop['tipo_inter_plan'];
  $fecha_cir = $row_preop['fecha_cir'];
  $hora_cir = $row_preop['hora_cir'];
  $tiempo_estimado = $row_preop['tiempo_estimado'];
  $nom_medi_cir = $row_preop['nom_medi_cir'];
  $anestesia_sug = $row_preop['anestesia_sug'];
  $sangrado_esp = $row_preop['sangrado_esp'];
  $observ = $row_preop['observ'];
  $fecha_preop = $row_preop['fecha_preop'];
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31, 4, utf8_decode('Tipo de intervención: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 4, utf8_decode($tipo_cirugia_preop), 'B',0,'C');


$sql_sig ="select * from signos_vitales WHERE id_atencion=$id_atencion ORDER by id_sig DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);

while ($row_sig = $result_sig->fetch_assoc()) {
 $p_sistolica=$row_sig['p_sistol'];
 $p_diastolica=$row_sig['p_diastol'];
 $f_card=$row_sig['fcard'];
 $f_resp=$row_sig['fresp'];
 $temp=$row_sig['temper'];
 $sat_oxigeno=$row_sig['satoxi'];
 $peso=$row_sig['peso'];
 $talla=$row_sig['talla'];
 $niv_dolor=$row_sig['niv_dolor'];
}

$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);

while ($row_hc = $result_sig->fetch_assoc()) {

 $pesoh=$row_hc['peso'];
 $tallah=$row_hc['talla'];

}

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(195, 5, utf8_decode('Signos Vitales:'), 0,0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7.2);
$pdf->Cell(38, 6, utf8_decode('Presión Arterial: ' .$p_sistolica.'/'.$p_diastolica).' mmHG', 1, 'L');
$pdf->Cell(44, 6, utf8_decode('Frecuencia Cardiaca: ' .$f_card.' Latidos/min'), 1, 'L');
$pdf->Cell(55, 6, utf8_decode('Frecuencia Respiratoria: ' .$f_resp.' Respiraciones/min'), 1, 'L');
$pdf->Cell(26, 6, utf8_decode('Temperatura: ' .$temp.' °C'), 1, 'L');
$pdf->Cell(34, 6, utf8_decode('Saturación de Oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 3, utf8_decode('Motivo de ingreso:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode( $motivo_ing), 1, 'L');
$pdf->Ln(1);

/*
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(38, 3, utf8_decode('RESULTADOS LAB. Y GABINETE: '), 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(158, 3, utf8_decode($result_lab_gab), 1, 'L');
$pdf->Ln(1);
*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 3, utf8_decode('Diagnóstico preoperatorio: '), 0,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($diag_preop), 1, 'L');
$pdf->Ln(1);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 3, utf8_decode('Material/equipo requerido: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($riesgos), 1, 'L');
$pdf->Ln(1);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 3, utf8_decode('Cirugía programada: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(105, 3, utf8_decode($tipo_inter_plan), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);

$date=date_create($fecha_cir);
$fecha_cir=date_format($date,"d/m/Y");
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(53, 3, utf8_decode('Programada: '.$fecha_cir.' Hora: '.$hora_cir), 1, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->Cell(38, 3, utf8_decode('Nombre del médico cirujano: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(105, 3, utf8_decode($nom_medi_cir), 1, 'L');

$pdf->Cell(53, 3, utf8_decode('Tiempo quirúrgico estimado: '.$tiempo_estimado), 1, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 3, utf8_decode('Estudios transoperatorios:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($cuidados), 1, 'L');
$pdf->Ln(1);


$pdf->SetFont('Arial', 'B', 7.7);
$pdf->Cell(38, 3, utf8_decode('Diagnóstico postoperatorio: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($pronostico), 1, 'L');
$pdf->Ln(1);

$sql_med_id = "SELECT id_usua FROM dat_not_preop WHERE id_not_preop = $id_preop ";

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

      $pdf->SetY(-60);
      $pdf->SetY(190);
      $pdf->SetX(10);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(190, 3, utf8_decode('Marcaje quirúrgico'), 0,0, 'C');

      $pdf->Image('../../img/marcaje_qx.jpg', 70, 193, 73);

      $pdf->SetFont('Arial', 'B', 7);
      //$pdf->Image('../../imgfirma/' . $firma, 94, 245, 25);
      
     if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 34, 247 , 25);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 34, 247 , 25);
}

      $pdf->SetY(266);
      $pdf->Cell(80, 3, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
       
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(80, 3, utf8_decode($cargp . ' ' . 'Céd. prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->Cell(80, 3, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
      
        $pdf->SetY(255);
       $pdf->SetX(115);
       $pdf->Cell(80, 3, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'C');
       $pdf->Ln(10);
    $pdf->SetX(115);
        $pdf->Cell(80, 3, utf8_decode(''), 'B', 0, 'C');
    $pdf->Ln(5);
    $pdf->SetX(115);
    $pdf->Cell(80, 3, utf8_decode('Paciente o familiar que autoriza'), 0, 0, 'C');
      
 $pdf->Output();
}