<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id'];
$id_inquir = @$_GET['id_not_inquir'];
$id_med = @$_GET['id_med'];
$id_exp = @$_GET['id_exp'];

$sql_inter = "SELECT * FROM dat_not_inquir where id_atencion = $id_atencion";
$result_inter = $conexion->query($sql_inter);

while ($row_inter = $result_inter->fetch_assoc()) {
$id_not_inquir = $row_inter['id_not_inquir'];
}

if(isset($id_not_inquir)){
    $id_not_inquir = $id_not_inquir;
  }else{
    $id_not_inquir ='sin doc';
  }

if($id_not_inquir=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE NOTA DE INTERVENCIÓN QUIRÚRGICA PARA ESTE PACIENTE", 
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
    
  }
}



$sql_pac = "SELECT * FROM paciente p, dat_ingreso di where di.id_atencion = $id_atencion and di.Id_exp=p.Id_exp";
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
  $tipo_sangre = $row_pac['tip_san'];
  $tipo_a = $row_pac['tipo_a'];
}


$sql_inter = "SELECT *, iq.fecha as fec_ciru, din.fecha as fecha_ing FROM dat_not_inquir iq, dat_ingreso din where iq.id_not_inquir=$id_inquir and din.id_atencion = iq.id_atencion ORDER BY id_not_inquir DESC limit 1";
$result_inter = $conexion->query($sql_inter);

while ($row_inter = $result_inter->fetch_assoc()) {
$tipo_intervencion = $row_inter['tipo_intervencion'];
$fecha_cir = $row_inter['fec_ciru'];
$hora_solicitud = $row_inter['hora_solicitud'];
$intervencion_sol = $row_inter['intervencion_sol'];

$quirofano = $row_inter['quirofano'];
$reserva = $row_inter['reserva'];
$local = $row_inter['local'];
$regional = $row_inter['regional'];
$general = $row_inter['general'];
$fecha_s = $row_inter['fecha'];
  $hb = $row_inter['hb'];
  $hto = $row_inter['hto'];
  $peso = $row_inter['peso'];
  
  $inst_necesario = $row_inter['inst_necesario'];
  $medmat_necesario = $row_inter['medmat_necesario'];
  $nom_jefe_serv = $row_inter['nom_jefe_serv'];
 
  $sala = $row_inter['sala'];
  $jefe_cirugia = $row_inter['jefe_cirugia'];
  
  $inicio = $row_inter['inicio'];
  $termino = $row_inter['termino'];
  $diag_postop = $row_inter['diag_postop'];
  $cir_realizada = $row_inter['cir_realizada'];
  $trans = $row_inter['trans'];
  $posto = $row_inter['posto'];
  $perd_hema = $row_inter['perd_hema'];
  $gasas = $row_inter['gasas'];
  $compresas = $row_inter['compresas'];
  $accident_incident = $row_inter['accident_incident'];
  $anestesia_admin = $row_inter['anestesia_admin'];
  $anestesia_dur = $row_inter['anestesia_dur'];
  $realizada_por = $row_inter['realizada_por'];
  $cirujano = $row_inter['cirujano'];
  $prim_ayudante = $row_inter['prim_ayudante'];
  $seg_ayudante = $row_inter['seg_ayudante'];
  $ter_ayudante = $row_inter['ter_ayudante'];
  $anestesiologo = $row_inter['anestesiologo'];
  $resid_anest = $row_inter['resid_anest'];
  $circulante = $row_inter['circulante'];
  $instrumentista = $row_inter['instrumentista'];
  $quir = $row_inter['quir'];
  $hora_llegada_quir = $row_inter['hora_llegada_quir'];


  $hora_salida_quir = $row_inter['hora_salida_quir'];
  $hora_entrada_recup = $row_inter['hora_entrada_recup'];
  $hora_salida_recup = $row_inter['hora_salida_recup'];
  $nota_preop = $row_inter['nota_preop'];
  $estado_postop = $row_inter['estado_postop'];
  $comentario_final = $row_inter['comentario_final'];
  $descripcion_op = $row_inter['descripcion_op'];
  $nombre_med_cir = $row_inter['nombre_med_cir'];
  $plan_ter = $row_inter['plan_ter'];
  $fecha_ing = $row_inter['fecha_ing'];
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
  $pdf->Cell(120, 5, utf8_decode('DESCRIPCIÓN DE INTERVENCIÓN QUIRÚRGICA'), 0, 0, 'C');
  $pdf->SetFont('Arial', '', 8);

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
$pdf->MultiCell(165, 9.5, utf8_decode('DESCRIPCIÓN DE INTERVENCIÓN QUIRÚRGICA '), 0, 'C');


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
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 4, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 4, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 4, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 4, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 4, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 4, utf8_decode($folio), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 4, ' Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(146, 4, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(4);
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
  $pdf->SetFont('Arial', '', 9);
     $pdf->Cell(175, 5, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 5, utf8_decode('Motivo de atención:') , 0, 'C');
         $pdf->SetFont('Arial', '', 9);
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
 $peso=$row_sig['peso'];
 $talla=$row_sig['talla'];
 $niv_dolor=$row_sig['niv_dolor'];
}

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(29, 4, utf8_decode('Tipo de cirugía: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 4, utf8_decode($tipo_intervencion), 'B',0,'C');

 $p_sistolica=" ";
 $p_diastolica=" ";
 $f_card=" ";
 $f_resp=" ";
 $temp=" ";
 $sat_oxigeno=" ";
 $peso=" ";
 $talla=" ";
 $diag_preop = " ";
 $cirugia_prog = " ";
 $fecha_progra = " ";
 $hora_progra = " ";

$sql_sig1 ="SELECT * FROM dat_not_preop WHERE id_atencion=$id_atencion order by id_not_preop DESC LIMIT 1";
$result_sig1 = $conexion->query($sql_sig1);
while ($row_sig1 = $result_sig1->fetch_assoc()) {
 $p_sistolica=$row_sig1['ta_sist'];
 $p_diastolica=$row_sig1['ta_diast'];
 $f_card=$row_sig1['frec_card'];
 $f_resp=$row_sig1['frec_resp'];
 $temp=$row_sig1['preop_temp'];
 $sat_oxigeno=$row_sig1['sat_oxi'];
 $peso=$row_sig1['preop_peso'];
 $talla=$row_sig1['preop_talla'];
 $diag_preop = $row_sig1['diag_preop'];
 $cirugia_prog = $row_sig1['tipo_inter_plan'];
 $fecha_progra = $row_sig1['fecha_preop'];
 $hora_progra = $row_sig1['hora_cir'];

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
 $peso=$row_sig['peso'];
 $talla=$row_sig['talla'];
 $niv_dolor=$row_sig['niv_dolor'];
}
$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$Id_exp ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);

while ($row_hc = $result_sig->fetch_assoc()) {

 $pesoh=$row_hc['peso'];
 $tallah=$row_hc['talla'];

}


$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 4, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell(41, 3, utf8_decode('Presión arterial: ' .$p_sistolica.'/'.$p_diastolica.' mmHG/mmHG'), 1, 'L');
$pdf->Cell(35, 3, utf8_decode('Frecuencia cardiaca: ' .$f_card.' Lat/min'), 1, 'L');
$pdf->Cell(40, 3, utf8_decode('Frecuencia respiratoria: ' .$f_resp.' Resp/min'), 1, 'L');
$pdf->Cell(23, 3, utf8_decode('Temperatura: ' .$temp.'°C'), 1, 'L');
$pdf->Cell(27, 3, utf8_decode('Saturación oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Cell(16, 3, utf8_decode('Peso: ' .$pesoh.' kg'), 1, 'L');
$pdf->Cell(14, 3, utf8_decode('Talla: ' .$tallah.'m'), 1, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Diagnóstico preoperatorio: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($diag_preop), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 3, utf8_decode('Sangre en: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 3, utf8_decode('quirófano: ' .$quirofano . ' ML'), 1,'C');
$pdf->Cell(21, 3, utf8_decode('Reserva: ' .$reserva. ' ML'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 3, utf8_decode('Anestesia: '), 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(21, 3, utf8_decode('Local: '. $local), 1, 'C');
$pdf->Cell(19, 3, utf8_decode('Regional: ' . $regional), 1, 'C');
$pdf->Cell(19, 3, utf8_decode('General: '. $general), 1,'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(24, 3, utf8_decode('Grupo sanguíneo:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(36, 3, utf8_decode($tipo_sangre), 1, 'L');
$pdf->Ln(1);



$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 3, utf8_decode('Programación en quirófano: '), 0,0, 'L');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Cirugía programada'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($cirugia_prog), 1, 'L');
$pdf->Ln(1);
$fecha_progra=date_create($fecha_progra);
$fecha_progra=date_format($fecha_progra,"d/m/Y");
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 3, utf8_decode('Programada:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(177, 3, utf8_decode($fecha_s. ' Hora:' .$hora_solicitud), 1, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Diagnóstico postoperatorio: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($diag_postop), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(40, 3, utf8_decode('Cirugía realizada: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 3, utf8_decode($cir_realizada), 1, 'J');

$pdf->Ln(1);
$fecha_cir=date_create($fecha_cir);
$fecha_cir=date_format($fecha_cir,"d/m/Y");
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 3, utf8_decode('Realizada:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(177, 3, utf8_decode($fecha_cir.' '. $inicio.' - '.$termino), 1, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
//$pdf->Cell(40, 3, utf8_decode('Estudios de patología: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(195, 3, utf8_decode('Estudios Transoperatorios: '.$trans), 1, 'L');
//$pdf->Cell(77, 3, utf8_decode('Postoperatorio: '.$posto), 1, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 7.4);
$pdf->Cell(40, 3, utf8_decode('Cuenta de gasas y compresas: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 3, utf8_decode($inst_necesario), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22, 3, utf8_decode('Observaciones: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(108, 3, utf8_decode($medmat_necesario), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Hallazgos: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($accident_incident), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Complicaciones: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($realizada_por), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Pérdida hemática (ml): '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(12, 3, utf8_decode($perd_hema.' ML'), 1, 'L');

$pdf->SetFont('Arial', 'B', 7.6);
$pdf->Cell(33, 3, utf8_decode('Anestesia administrada: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(85, 3, utf8_decode($anestesia_admin), 1, 'L');
$pdf->SetFont('Arial', 'B', 7.6);
$pdf->Cell(14, 3, utf8_decode('Duración: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 3, utf8_decode($anestesia_dur), 1,0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Cirujano'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(155, 3, utf8_decode($cirujano), 1, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(65, 3, utf8_decode('Primer ayudante '), 1,0, 'C');
$pdf->Cell(65, 3, utf8_decode('Segundo ayudante'), 1,0, 'C');
$pdf->Cell(65, 3, utf8_decode('Tercer ayudante'), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(65, 3, $prim_ayudante, 1,0, 'C');
$pdf->Cell(65, 3, $seg_ayudante, 1,0, 'C');
$pdf->Cell(65, 3, $ter_ayudante, 1,0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(65, 3, utf8_decode('Anestesiólogo '), 1,0, 'C');
$pdf->Cell(65, 3, utf8_decode('Circulante '), 1,0, 'C');
$pdf->Cell(65, 3, utf8_decode('Instrumentista'), 1,0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(65, 3, $anestesiologo, 1,0, 'C');
$pdf->Cell(65, 3, $circulante, 1,0, 'C');
$pdf->Cell(65, 3, $instrumentista, 1,0, 'C');
$pdf->Ln(4);
/*
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(99, 3, utf8_decode('Quirófano '), 0, 0, 'C');
$pdf->Cell(99, 3, utf8_decode('Sala de recuperación '), 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(39, 3, utf8_decode('Sala '), 1,0, 'C');
$pdf->Cell(39, 3, utf8_decode('Hora llegada '), 1,0, 'C');
$pdf->Cell(39, 3, utf8_decode('Hora salida '), 1,0, 'C');
$pdf->Cell(39, 3, utf8_decode('Hora llegada'), 1,0, 'C');
$pdf->Cell(39, 3, utf8_decode('Hora salida '), 1,1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(39, 3, $quir, 1,0, 'C');
$pdf->Cell(39, 3, $hora_llegada_quir, 1,0, 'C');
$pdf->Cell(39, 3, $hora_salida_quir, 1,0, 'C');
$pdf->Cell(39, 3, $hora_entrada_recup, 1,0, 'C');
$pdf->Cell(39, 3, $hora_salida_recup, 1,0, 'C');
$pdf->Ln(3);
*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(200, 5, utf8_decode('Hallazgos-técnica (descripción quirurgica)-complicaciones y observaciones: '), 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(47, 3, utf8_decode('Nota operatoria:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(148, 3, utf8_decode($nota_preop), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(47, 3, utf8_decode('Estado postoperatorio inmediato '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(148, 3, utf8_decode($estado_postop), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(47, 3, utf8_decode('Comentario final y pronóstico: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(148, 3, utf8_decode($comentario_final), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(47, 3, utf8_decode('Describió operación: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(148, 3, utf8_decode($descripcion_op), 1, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(47, 3, utf8_decode('Nombre del médico cirujano:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(148, 3, utf8_decode($nombre_med_cir), 1, 'L');
$pdf->Ln(3);


$sql_med_id = "SELECT id_usua FROM dat_not_inquir WHERE id_not_inquir = $id_inquir ";

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
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 245 , 25);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 245 , 25);
}
       $pdf->SetY(258);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'Céd. prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('Nombre y firma del médico'), 0, 0,  'C');
      $pdf->SetX(170);
      $pdf->Cell(20, 10, utf8_decode('CMSI-6.02'), 0, 0, 'R');
      $pdf->ln(10);

$pdf->Ln(20);
 $pdf->SetTextColor(43, 45, 127);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(50);
$pdf->Cell(120, 5, utf8_decode('NOTA POSTOPERATORIA'), 0, 0, 'C');
$pdf->Ln(9);
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
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 4, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 4, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 4, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 4, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 4, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 4, utf8_decode($folio), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 4, ' Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(146, 4, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(4);
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
  $pdf->SetFont('Arial', '', 9);
     $pdf->Cell(175, 5, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 5, utf8_decode('Motivo de atención:') , 0, 'C');
         $pdf->SetFont('Arial', '', 9);
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
 $peso=$row_sig['peso'];
 $talla=$row_sig['talla'];
 $niv_dolor=$row_sig['niv_dolor'];
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(29, 4, utf8_decode('Tipo de  cirugía: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 4, utf8_decode($tipo_intervencion), 'B',0,'C');

$sql_sig1 ="SELECT * FROM dat_not_preop WHERE id_atencion=$id_atencion order by id_not_preop DESC LIMIT 1";
$result_sig1 = $conexion->query($sql_sig1);
while ($row_sig1 = $result_sig1->fetch_assoc()) {
 $p_sistolica=$row_sig1['ta_sist'];
 $p_diastolica=$row_sig1['ta_diast'];
 $f_card=$row_sig1['frec_card'];
 $f_resp=$row_sig1['frec_resp'];
 $temp=$row_sig1['preop_temp'];
 $sat_oxigeno=$row_sig1['sat_oxi'];
 $peso=$row_sig1['preop_peso'];
 $talla=$row_sig1['preop_talla'];
 $diag_preop = $row_sig1['diag_preop'];
 $cirugia_prog = $row_sig1['tipo_inter_plan'];
 $fecha_progra = $row_sig1['fecha_cir'];
 $hora_progra = $row_sig1['hora_cir'];
}

$sql_sig ="select * from signos_vitales WHERE id_atencion=$id_atencion ORDER by id_sig DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);

while ($row_sig = $result_sig->fetch_assoc()) {
 $peso=$row_sig['peso'];
 $talla=$row_sig['talla'];
 $niv_dolor=$row_sig['niv_dolor'];
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 4, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell(41, 3, utf8_decode('Presión arterial: ' .$p_sistolica.'/'.$p_diastolica.' mmHG/mmHG'), 1, 'L');
$pdf->Cell(35, 3, utf8_decode('Frecuencia cardiaca: ' .$f_card.' Lat/min'), 1, 'L');
$pdf->Cell(40, 3, utf8_decode('Frecuencia respiratoria: ' .$f_resp.' Resp/min'), 1, 'L');
$pdf->Cell(23, 3, utf8_decode('Temperatura: ' .$temp.'°C'), 1, 'L');
$pdf->Cell(27, 3, utf8_decode('Saturación oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Cell(16, 3, utf8_decode('Peso: ' .$pesoh.' kg'), 1, 'L');
$pdf->Cell(14, 3, utf8_decode('Talla: ' .$tallah.'m'), 1, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Diagnóstico preoperatorio: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($diag_preop), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Diagnóstico postoperatorio: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($diag_postop), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Cirugía programada: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($cirugia_prog), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(40, 3, utf8_decode('Cirugía realizada: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 3, utf8_decode($cir_realizada), 1, 'J');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Cirujano'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($cirujano), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(65, 3, utf8_decode('Primer ayudante '), 1,0, 'C');
$pdf->Cell(65, 3, utf8_decode('Segundo ayudante'), 1,0, 'C');
$pdf->Cell(65, 3, utf8_decode('Tercer ayudante'), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(65, 3, $prim_ayudante, 1,0, 'C');
$pdf->Cell(65, 3, $seg_ayudante, 1,0, 'C');
$pdf->Cell(65, 3, $ter_ayudante, 1,0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(65, 3, utf8_decode('Antestesiólogo '), 1,0, 'C');
$pdf->Cell(65, 3, utf8_decode('Circulante '), 1,0, 'C');
$pdf->Cell(65, 3, utf8_decode('Instrumentista'), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(65, 3, $anestesiologo, 1,0, 'C');
$pdf->Cell(65, 3, $circulante, 1,0, 'C');
$pdf->Cell(65, 3, $instrumentista, 1,0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Pérdida hemática (ml): '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(12, 3, utf8_decode($perd_hema.' ml'), 1, 'L');
$pdf->SetFont('Arial', 'B', 7.3);
$pdf->Cell(32, 3, utf8_decode('Accidentes o incidentes: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(111, 3, utf8_decode($accident_incident), 1, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 7.2);
$pdf->Cell(40, 3, utf8_decode('Ccuenta de gasas y compresas: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 3, utf8_decode($inst_necesario), 1, 'L');
$pdf->SetFont('Arial', 'B', 7.8);
$pdf->Cell(22, 3, utf8_decode('Observaciones: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(108, 3, utf8_decode($medmat_necesario), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(200, 5, utf8_decode('Hallazgos-técnica (descripción quirúrgica)-complicaciones y observaciones:'), 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Nota operatoria:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($nota_preop), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Plan terapeútica: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($plan_ter), 1, 'L');

$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 3, utf8_decode('Estudios de patología: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(78, 3, utf8_decode('Transoperatorios: '.$trans), 1, 'L');
$pdf->Cell(77, 3, utf8_decode('Postoperatorios: '.$posto), 1, 'L');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(40, 3, utf8_decode('Estado postoperatorio inmediato '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($estado_postop), 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->Cell(40, 3, utf8_decode('Comentario final y pronóstico: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155, 3, utf8_decode($comentario_final), 1, 'L');

$sql_med_id = "SELECT id_usua FROM dat_not_inquir WHERE id_not_inquir = $id_inquir ";

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
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 245 , 25);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 245 , 25);
}
       $pdf->SetY(258);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'Céd. prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('Nombre y firma del médico'), 0, 0,  'C');
      $pdf->SetX(170);
      $pdf->Cell(20, 10, utf8_decode('CMSI-6.03'), 0, 0, 'R');
      $pdf->ln(10);

 $pdf->Output();
}


