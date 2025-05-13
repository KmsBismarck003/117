<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_med = @$_GET['id_med'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$id_quir = @$_GET['id_quir'];
$fec = @$_GET['fec'];

$fechar = @$_GET['fechar'];
$horar = @$_GET['horar'];


$sql_clin = "SELECT * FROM enf_quirurgico  where  id_atencion = $id_atencion";
$result_clin = $conexion->query($sql_clin);
while ($row_clinreg = $result_clin->fetch_assoc()) {
  $id_quir = $row_clinreg['id_quir'];
}
if(isset($id_quir)){
    $id_quir = $id_quir;
  }else{
    $id_quir ='sin doc';
  }
if($id_quir=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE REGISTRO CLÍNICO DE ENFERMERÍA DEL ÁREA QUIRÚRGICA PARA ESTE PACIENTE", 
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

    $id_atencion = @$_GET['id_atencion'];
include '../../conexionbd.php';
 $id_exped = @$_GET['id_exp'];
$fechar = @$_GET['fechar'];
$hora_mat = @$_GET['hora_mat'];
$fec = @$_GET['fec'];

$fechar = @$_GET['fechar'];
$horar = @$_GET['horar'];
$sql_pac = "SELECT * FROM paciente  where Id_exp = $id_exped";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $Id_exp = $row_pac['Id_exp'];
 
}

$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 10, 15, 45, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],57,15, 100, 25);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 159, 18, 50, 20);
}
    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
  
    $this->Ln(10);
    $this->SetDrawColor(43, 45, 180);
    //$this->Line(50, 18, 170, 18);
    $this->SetFont('Arial', '', 8);
    
    $this->Ln(4);
  
    $this->Ln(4);
   
    $this->Ln(4);
  
   $this->Ln(6);
  $this->SetFont('Arial', 'B', 7);
    $this->SetTextColor(43, 45, 127);
        $this->Cell(160, 5, utf8_decode($Id_exp . '-' . $papell . ' ' . $sapell . ' ' . $nom_pac), 0, 'L');
     $sql_q = "SELECT * from enf_quirurgico where id_atencion=$id_atencion";
$result_q = $conexion->query($sql_q); 
while ($row_q = $result_q->fetch_assoc()) {
  $fecha_quirr = $row_q['fecha'];
    
} 
$date2 = date_create($fecha_quirr);
$this->Cell(80, 5, utf8_decode('Fecha de registro: '.date_format($date2, "d/m/Y")),0, 'L');
        
        $this->Ln(4);
  
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-15.03'), 0, 1, 'R');
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
   $tip_san = $row_pac['tip_san'];
      $folio = $row_pac['folio'];
        $fecha_ing=$row_pac['fecha'];
}


$sql_ing = "SELECT * FROM dat_ingreso  where Id_exp = $id_exp";
$result_ing = $conexion->query($sql_ing);
while ($row_ing = $result_ing->fetch_assoc()) {
$especialidad = $row_ing['especialidad'];
  $fechai = $row_ing['fecha'];
  $area= $row_ing['area'];
    $tipo_a= $row_ing['tipo_a'];


}

$sql_f = "SELECT * FROM enf_quirurgico  where fecha='$fechar' and hora='$horar' and id_atencion = $id_atencion";
$result_f = $conexion->query($sql_f);
while ($row_f = $result_f->fetch_assoc()) {
$fecha = $row_f['fecha'];

  

}

$sql_camas = "SELECT * FROM cat_camas  where id_atencion = $id_atencion";
$result_camas = $conexion->query($sql_camas);
while ($row_camas = $result_camas->fetch_assoc()) {

  $num_cama = $row_camas['num_cama'];
}



     $sql_est = "SELECT DATEDIFF(fecha, '$fechai') as estancia FROM enf_quirurgico where id_atencion = $id_atencion and fecha='$fechar'";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
          $estancia = $row_est['estancia'];
       
      }

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
    $pdf->SetTextColor(43, 45, 127);

  $pdf->SetDrawColor(43, 45, 180);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(55);
$pdf->Cell(107, 5, utf8_decode('REGISTRO CLÍNICO DE ENFERMERÍA DEL ÁREA QUIRÚRGICA'), 0, 0, 'C');


$fecha_quir = date("d/m/Y H:i a");
$pdf->SetFont('Arial', '', 6.5);
///$pdf->Cell(25, 5, utf8_decode('Fecha de impresión: '.$fecha_quir), 0, 1, 'L');

$pdf->SetFont('Arial', '', 7);
$pdf->Ln(3);

$pdf->Ln(5);
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 5, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$datei=date_create($fechai);
$pdf->Cell(28, 5, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 5, date_format($datei,'d/m/Y H:i a'), 'B', 0, 'C');
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
  $pdf->SetFont('Arial', '', 9);
     $pdf->Cell(175, 5, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 5, utf8_decode('Motivo de atención:') , 0, 'C');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(166, 5, utf8_decode($m) , 'B', 'C');
    }

$pdf->Ln(6);

$sql_edo = "SELECT edo_salud,alergias from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud DESC LIMIT 1";
$result_edo = $conexion->query($sql_edo);                                                                                    while ($row_edo = $result_edo->fetch_assoc()) {
  $edo_salud=$row_edo['edo_salud'];
  $alergias=$row_edo['alergias'];
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25,3, utf8_decode('Grupo sanguineo: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23,3, utf8_decode($tip_san),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17,3, utf8_decode('Habitación: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8,3, utf8_decode($num_cama),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 3, 'Tiempo estancia: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(12, 3, $estancia . ' dias', 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25,3, utf8_decode('Estado de salud: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(59,3, utf8_decode($edo_salud),'B','L');
$pdf->Ln(3);


$sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha DESC limit 1";
  $result_aseg = $conexion->query($sql_aseg);
  while ($row_aseg = $result_aseg->fetch_assoc()) {
 $aseg= $row_aseg['aseg'];
}                      
$pdf->SetFont('Arial', 'B', 8);                                               
$pdf->Cell(20,5, utf8_decode('Aseguradora: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60,5, utf8_decode($aseg),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15,5, utf8_decode('Alergias: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100,5, utf8_decode($alergias),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(9);


//CONSULA A ENF QUIR CONSULTA A ENF QUIR CONSULTA A ENF QUIR CONSULTA A ENF QUIR CONSULTA ENF QUIR CONSULTA A ENF 
$sql_q = "SELECT * from enf_quirurgico where fecha='$fechar' and id_atencion=$id_atencion";
$result_q = $conexion->query($sql_q); 
while ($row_q = $result_q->fetch_assoc()) {
  $fecha = $row_q['fecha'];
  $hora = $row_q['hora'];
  $habitus = $row_q['habitus'];
  $trans = $row_q['trans'];
  $cur = $row_q['cur'];
  $cir = $row_q['cir'];
  $in_isq = $row_q['in_isq'];
  $ter_isq = $row_q['ter_isq'];
  $in_ren = $row_q['in_ren'];
  $in_fria = $row_q['in_fria'];
  $ter_ren = $row_q['ter_ren'];
  $ter_fria = $row_q['ter_fria'];
  $elect = $row_q['elect'];
  $pos = $row_q['pos'];
  $ant = $row_q['ant'];
  $areaquir = $row_q['areaquir'];
 $tip_cir = $row_q['tip_cir'];
 $pipat = $row_q['pipat'];
$pdiast=$row_q['pdiast'];
$psist=$row_q['psist'];
$f_card=$row_q['f_card'];
$f_resp=$row_q['f_resp'];
$temp=$row_q['temp'];
$spo2=$row_q['spo2'];
$viapar=$row_q['viapar'];
$hemod=$row_q['hemod'];
$egotro=$row_q['egotro'];

$p_a=$row_q['p_a'];
$s_a=$row_q['s_a'];
$t_a=$row_q['t_a'];

$tipan=$row_q['tipan'];
$nom_enf_tipan=$row_q['nom_enf_tipan'];

$gasasdentro=$row_q['gasasdentro'];
$gasasfuera=$row_q['gasasfuera'];
$gasastotal=$row_q['gasastotal'];
$compdentro=$row_q['compdentro'];
$compfuera=$row_q['compfuera'];
$comptotal=$row_q['comptotal'];
$pudentro=$row_q['pudentro'];
$pufuera=$row_q['pufuera'];
$putotal=$row_q['putotal'];
$cotdentro=$row_q['cotdentro'];
$cotfuera=$row_q['cotfuera'];
$cottotal=$row_q['cottotal'];
$linodentro=$row_q['linodentro'];
$linofuera=$row_q['linofuera'];
$linototal=$row_q['linototal'];
$nasdentro=$row_q['nasdentro'];
$nasfuera=$row_q['nasfuera'];
$nastotal=$row_q['nastotal'];
$ob_matdentro=$row_q['ob_matdentro'];
$ob_matfuera=$row_q['ob_matfuera'];
$ob_mattotal=$row_q['ob_mattotal'];

$gasas = $row_q['gasas'];
$comp = $row_q['comp'];
$cot = $row_q['cot'];
$lino=$row_q['lino'];
$nas=$row_q['nas'];
$pu=$row_q['pu'];
$ob_mat=$row_q['ob_mat'];
$glice=$row_q['glice'];

$diu = $row_q['diu'];
$eva = $row_q['eva'];
$sang = $row_q['sang'];
$vom=$row_q['vom'];
$aspboc=$row_q['aspboc'];
$gast=$row_q['gast'];
$dren=$row_q['dren'];
$perd=$row_q['perd'];
$egpar_t=$row_q['egpar_t'];

$imagen=$row_q['imagen'];
$incidentes=$row_q['incidentes'];

$p_a=$row_q['p_a'];
$s_a=$row_q['s_a'];
$t_a=$row_q['t_a'];


$caidas=$row_q['caidas'];
$medi=$row_q['medi'];
$defic=$row_q['defic'];
$estement=$row_q['estement'];
$deamb=$row_q['deamb'];
$total=$row_q['total'];
$classresg=$row_q['classresg'];
$nom_enf=$row_q['nom_enf'];
$interv_m=$row_q['interv_m'];
$not_recu=$row_q['not_recu'];
//VAL PIEL VAL PIEL VAL PIEL VLA PIEL VAL PIEL VAL PIEL VAL PIEL VAL PIEL VAL PIEL VAL PIEL VAL PIEL VAL PIEL
$quem_m=$row_q['quem_m'];
$uls_m=$row_q['uls_m'];
$nec_m=$row_q['nec_m'];
$her_m=$row_q['her_m'];
$tub_m=$row_q['tub_m'];
$der_m=$row_q['der_m'];
$ras_m=$row_q['ras_m'];
$eq_m=$row_q['eq_m'];
$enf_m=$row_q['enf_m'];
$ema_m=$row_q['ema_m'];
$frac_m=$row_q['frac_m'];
$acc_m=$row_q['acc_m'];
$pete_m=$row_q['pete_m'];
$ede_m=$row_q['ede_m'];

$fron_m=$row_q['fron_m'];
$mal_m=$row_q['mal_m'];
$man_m=$row_q['man_m'];
$del_m=$row_q['del_m'];
$pec_m=$row_q['pec_m'];
$est_m=$row_q['est_m'];
$ant_m=$row_q['ant_m'];
$mu_m=$row_q['mu_m'];
$mano_m=$row_q['mano_m'];
$mus_m=$row_q['mus_m'];
$rod_m=$row_q['rod_m'];
$pier_m=$row_q['pier_m'];
$pri_m=$row_q['pri_m'];
$max_m=$row_q['max_m'];
$men_m=$row_q['men_m'];
$ac_m=$row_q['ac_m'];
$bra_m=$row_q['bra_m'];
$pli_m=$row_q['pli_m'];
$abd_m=$row_q['abd_m'];
$reg_m=$row_q['reg_m'];
$pub_m=$row_q['pub_m'];
$pde_m=$row_q['pde_m'];
$sde_m=$row_q['sde_m'];
$tde_m=$row_q['tde_m'];
$cde_m=$row_q['cde_m'];
$qde_m=$row_q['qde_m'];
$tob_m=$row_q['tob_m'];
$pie_m=$row_q['pie_m'];
$par_m=$row_q['par_m'];
$occ_m=$row_q['occ_m'];
$nuca_m=$row_q['nuca_m'];
$braz_m=$row_q['braz_m'];
$codo_m=$row_q['codo_m'];
$ante_m=$row_q['ante_m'];
$mune_m=$row_q['mune_m'];
$mane_m=$row_q['mane_m'];
$plieg_m=$row_q['plieg_m'];
$piern_m=$row_q['piern_m'];
$piep_m=$row_q['piep_m'];
$cuello_m=$row_q['cuello_m'];
$regin_m=$row_q['regin_m'];
$regesc_m=$row_q['regesc_m'];
$reginf_m=$row_q['reginf_m'];
$lum_m=$row_q['lum_m'];
$glut_m=$row_q['glut_m'];
$musl_m=$row_q['musl_m'];
$talon_m=$row_q['talon_m'];

//ESCALA DOLOR
$ingrecup=$row_q['ingrecup'];
$dol1=$row_q['dol1'];
$dol2=$row_q['dol2'];
$dol3=$row_q['dol3'];
$dol4=$row_q['dol4'];
$dol5=$row_q['dol5'];
$egrecup=$row_q['egrecup'];
$medol=$row_q['medol'];
//atencion despues de la cirugia
$oxi=$row_q['oxi'];
$con=$row_q['con'];
$muc=$row_q['muc'];
$vent=$row_q['vent'];
$est=$row_q['est'];
$cito=$row_q['cito'];
$yeso=$row_q['yeso'];
$herquir=$row_q['herquir'];
$quema=$row_q['quema'];
$ext=$row_q['ext'];
$riesg=$row_q['riesg'];
$prec=$row_q['prec'];
$dena=$row_q['dena'];
$bloq=$row_q['bloq'];
$movil=$row_q['movil'];
$const=$row_q['const'];

$not_preop=$row_q['not_preop'];
$nom_enf_preop=$row_q['nom_enf_preop'];
$not_trans=$row_q['not_trans'];
$nom_enf_trans=$row_q['nom_enf_trans'];
$not_post=$row_q['not_post'];
$nom_enf_post=$row_q['nom_enf_post'];
//MARCAJE
$mara=$row_q['mara'];
$marb=$row_q['marb'];
$marc=$row_q['marc'];
$mard=$row_q['mard'];
$mare=$row_q['mare'];
$marf=$row_q['marf'];
$marg=$row_q['marg'];
$marh=$row_q['marh'];

$frenteizquierda=$row_q['frenteizquierda'];
$frentederecha=$row_q['frentederecha'];
$narizc=$row_q['narizc'];
$mejderecha=$row_q['mejderecha'];
$mandiizqui=$row_q['mandiizqui'];
$mandiderr=$row_q['mandiderr'];
$mandicentroo=$row_q['mandicentroo'];
$cvi=$row_q['cvi'];
$homi=$row_q['homi'];
$hombrod=$row_q['hombrod'];
$pecti=$row_q['pecti'];
$pectd=$row_q['pectd'];
$peci=$row_q['peci'];
$brazci=$row_q['brazci'];
$cconder=$row_q['cconder'];
$brazi=$row_q['brazi'];
$annbraz=$row_q['annbraz'];
$derbraz=$row_q['derbraz'];
$muñei=$row_q['munei'];
$muñecad=$row_q['munecad'];
$palmai=$row_q['palmai'];
$palmad=$row_q['palmad'];
$ddi=$row_q['ddi'];
$ddoderu=$row_q['ddoderu'];
$ddidos=$row_q['ddidos'];
$dedodos=$row_q['dedodos'];
$dditres=$row_q['dditres'];
$dedotres=$row_q['dedotres'];
$dedocuatro=$row_q['dedocuatro'];
$ddicuatro=$row_q['ddicuatro'];
$ddicinco=$row_q['ddicinco'];
$dedocincoo=$row_q['dedocincoo'];
$iabdomen=$row_q['iabdomen'];
$inglei=$row_q['inglei'];
$musloi=$row_q['musloi'];
$muslod=$row_q['muslod'];
$rodd=$row_q['rodd'];
$rodi=$row_q['rodi'];
$tod=$row_q['tod'];
$toi=$row_q['toi'];
$pied=$row_q['pied'];
$pie=$row_q['pie'];
$plantapiea=$row_q['plantapiea'];
$plantapieader=$row_q['plantapieader'];
$tobilloatd=$row_q['tobilloatd'];
$tobilloati=$row_q['tobilloati'];
$ptiatras=$row_q['ptiatras'];
$ptdatras=$row_q['ptdatras'];
$pierespaldad=$row_q['pierespaldad'];
$pierespaldai=$row_q['pierespaldai'];
$musloatrasiz=$row_q['musloatrasiz'];
$musloatrasder=$row_q['musloatrasder'];
$dorsaliz=$row_q['dorsaliz'];
$dorsalder=$row_q['dorsalder'];
$munecaatrasiz=$row_q['munecaatrasiz'];
$munecaatrasder=$row_q['munecaatrasder'];
$antebdesp=$row_q['antebdesp'];
$antebiesp=$row_q['antebiesp'];
$casicodoi=$row_q['casicodoi'];
$casicododer=$row_q['casicododer'];
$brazaltder=$row_q['brazaltder'];
$brazalti=$row_q['brazalti'];
$glutiz=$row_q['glutiz'];
$glutder=$row_q['glutder'];
$cinturader=$row_q['cinturader'];
$cinturaiz=$row_q['cinturaiz'];
$costilliz=$row_q['costilliz'];
$costillder=$row_q['costillder'];
$espaldaarribader=$row_q['espaldaarribader'];
$espaldarribaiz=$row_q['espaldarribaiz'];
$espaldaalta=$row_q['espaldaalta'];
$cuellatrasb=$row_q['cuellatrasb'];
$cuellatrasmedio=$row_q['cuellatrasmedio'];
$cabedorsalm=$row_q['cabedorsalm'];
$cabealtaizqu=$row_q['cabealtaizqu'];
$cabezaaltader=$row_q['cabezaaltader'];

$nuevo1=$row_q['nuevo1'];
$nuevo2=$row_q['nuevo2'];
$nuevo3=$row_q['nuevo3'];
$nuevo4=$row_q['nuevo4'];
$nuevo5=$row_q['nuevo5'];
$nuevo6=$row_q['nuevo6'];
$nuevo7=$row_q['nuevo7'];
$nuevo8=$row_q['nuevo8'];

$espizq=$row_q['espizq'];
$espder=$row_q['espder'];
$coxis=$row_q['coxis'];

$asepsia=$row_q['asepsia'];

$horac=$row_q['horac'];
$horaas=$row_q['horaas'];
$otros=$row_q['otros'];
$cir_prog=$row_q['cir_prog'];
} 

$horf=date_create($hora);
//$pdf->Cell(50,5, utf8_decode('Fecha: ' .date_format($fechaq, 'd-m-Y')),1,0,'C');
$pdf->Cell(45,5, utf8_decode('Hora: ' . date_format($horf, 'H:i a')),1,0,'C');
$pdf->Ln(5);


//consukta PREOP CONSULTA PREOP CONSULTA PREOP CONSULTA PREOP CONSULTA PREOP CONSULTA PREOP CONSULTA PREOP


//consulta inquir consuklta inquir consulta inquir consulta inquir consulta inquir consukta inquir consulta inquir
$sala="";
$cir_realizada="";
$prim_ayudante="";
$seg_ayudante="";
$ter_ayudante="";
$anestesiologo="";
$instrumentista="";
$circulante="";
$hora_salida_quir="";
$hora_llegada_quir="";
$nota_preop="";

$local="";
$regional="";
$general="";

$sql_s = "SELECT * from dat_not_inquir where id_atencion=$id_atencion ORDER BY id_not_inquir DESC LIMIT 1";
$result_s = $conexion->query($sql_s); 
while ($row_s = $result_s->fetch_assoc()) {
  $sala = $row_s['sala'];
  $cir_realizada = $row_s['cir_realizada'];
 $prim_ayudante = $row_s['prim_ayudante'];
$seg_ayudante=$row_s['seg_ayudante'];
$ter_ayudante=$row_s['ter_ayudante'];
$anestesiologo=$row_s['anestesiologo'];
$instrumentista=$row_s['instrumentista'];
$circulante=$row_s['circulante'];
$hora_llegada_quir=$row_s['hora_llegada_quir'];
$local=$row_s['local'];
$regional=$row_s['regional'];
$general=$row_s['general'];
$hora_salida_quir=$row_s['hora_salida_quir'];
$nota_preop=$row_s['nota_preop'];



} 



$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,5, utf8_decode('PREOPERATORIO'),0,0,'C');
$pdf->Ln(6);


$pdf->Cell(30,5, utf8_decode('Cirugía programada:'),0,0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(164,5, utf8_decode($cir_prog),'B',0,'L');

$horanca=date_create($horaas);//ANES
$horan=date_create($in_isq);
$pdf->Ln(6);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25,5, utf8_decode('Hora: ' .date_format($horanca, 'H:i a')),'B',0,'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15,5, utf8_decode('Asepsia:'),0,0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(155,5, utf8_decode($asepsia),'B',0,'L');
$pdf->Ln(7);

$horanc=date_create($horac);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25,5, utf8_decode('Hora: ' .date_format($horanc, 'H:i a')),'B',0,'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25,5, utf8_decode('Condición inicial: '),0,0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(145,5, utf8_decode($not_preop),'B','L');
$pdf->Ln(2);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25,5, utf8_decode('Hora: ' .date_format($horan, 'H:i a')),'B',0,'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(26,5, utf8_decode('Tipo de anestesia: '),0,0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(144,5, utf8_decode($tipan),'B',0,'L');

$pdf->Ln(7);
$pdf->Cell(25,4, utf8_decode(''),0,0,'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(12,4, utf8_decode('Otros:'),0,0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(158,3, utf8_decode($otros),'B',0,'L');

$pdf->Ln(7);

/*
if($espizq!=NULL || $espder!=NULL || $nuevo!=NULL ||$nuevo1!=NULL ||$nuevo2!=NULL ||$nuevo3!=NULL ||$nuevo4!=NULL ||$nuevo5!=NULL ||$nuevo6!=NULL ||$nuevo7!=NULL ||$frenteizquierda!=NULL ||$frentederecha!=NULL ||$narizc!=NULL ||$mejderecha!=NULL ||$marf!=NULL ||$mare!=NULL ||$mandiizqui!=NULL ||$mandiderr!=NULL ||$mandicentroo!=NULL ||$cvi!=NULL ||$mard!=NULL ||$homi!=NULL ||$hombrod!=NULL ||$pecti!=NULL ||$pectd!=NULL ||$peci!=NULL ||$marc!=NULL ||$brazci!=NULL ||$cconder!=NULL ||$brazi!=NULL ||$annbraz!=NULL ||$marg!=NULL ||$derbraz!=NULL ||$muñei!=NULL ||$muñecad!=NULL ||$palmai!=NULL ||$palmad!=NULL ||$ddi!=NULL ||$ddoderu!=NULL ||$ddidos!=NULL ||$dedodos!=NULL ||$dditres!=NULL ||$dedotres!=NULL ||$dedocuatro!=NULL ||$ddicuatro!=NULL ||$ddicinco!=NULL ||$dedocincoo!=NULL ||$iabdomen!=NULL ||$marb!=NULL ||$inglei!=NULL ||$mara!=NULL ||$musloi!=NULL ||$muslod!=NULL ||$rodd!=NULL ||$rodi!=NULL ||$tod!=NULL ||$toi!=NULL ||$pied!=NULL ||$pie!=NULL || $coxis!=NULL || $plantapiea!=NULL || $plantapieader!=NULL || $tobilloatd!=NULL ||$tobilloati!=NULL ||$ptiatras!=NULL ||$ptdatras!=NULL ||$pierespaldad!=NULL ||$pierespaldai!=NULL ||$musloatrasiz!=NULL ||$musloatrasder!=NULL ||$dorsalder!=NULL ||$dorsaliz!=NULL ||$munecaatrasiz!=NULL ||$munecaatrasder!=NULL ||$antebdesp!=NULL ||$antebiesp!=NULL ||$casicodoi!=NULL ||$casicododer!=NULL ||$brazaltder!=NULL ||$brazalti!=NULL ||$glutiz!=NULL ||$glutder!=NULL ||$cinturader!=NULL ||$cinturaiz!=NULL ||$marh!=NULL ||$costilliz!=NULL ||$costillder!=NULL ||$espaldaarribader!=NULL ||$espaldarribaiz!=NULL ||$espaldaalta!=NULL ||$cuellatrasb!=NULL ||$cuellatrasmedio!=NULL ||$cabedorsalm!=NULL ||$cabealtaizqu!=NULL || $cabezaaltader!=NULL){
    $pdf->Ln(11);
    $pdf->SetFont('Arial', 'B',8);
$pdf->Cell(190, 5, utf8_decode('VALORACIÓN DE LA PIEL INICIAL'), 0, 0, 'C');
$pdf->Ln(8);
$pdf->Cell(20,5, utf8_decode(''),0,0,'L');
$pdf->Cell(100,10, $pdf->Image('../../img/cuerpof.jpg', $pdf->GetX(), $pdf->GetY(),45),0);

//IMAGEN TRASERA IMAGEN TARSERA TRASERA TRASEA TRASERA TRASERA TRASERA TRASERA TRASERA TRASERA TRASERA TRASERA TRASEA
$pdf->Cell(15,5, utf8_decode(''),0,0,'L');
$pdf->Cell(100,10, $pdf->Image('../../img/cuerpot.jpg', $pdf->GetX(), $pdf->GetY(),41),0);
//$pdf->Image('../../img/cuerpof.jpg' , 79, 103, 56);
if($espizq!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(205);
$pdf->SetX(13);
$pdf->Cell(25, 6, utf8_decode($espizq), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 13, 209, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(183);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($espder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(205);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($espder), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 58, 209, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(183);
$pdf->SetX(101);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($nuevo1!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(173);
$pdf->SetX(56);
$pdf->Cell(25, 6, utf8_decode($nuevo1), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 57, 176.6, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142);
$pdf->SetX(99);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}


if($nuevo2!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(173);
$pdf->SetX(19);
$pdf->Cell(25, 6, utf8_decode($nuevo2), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 20, 176.7, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142);
$pdf->SetX(89);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($nuevo3!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(167.7);
$pdf->SetX(10);
$pdf->Cell(25, 6, utf8_decode($nuevo3), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 171.5, 38, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(138);
$pdf->SetX(89);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($nuevo4!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(167.4);
$pdf->SetX(28.3);
$pdf->Cell(25, 6, utf8_decode($nuevo4), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 20, 170.8, 33, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(135.5);
$pdf->SetX(94.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($nuevo5!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(167);
$pdf->SetX(56.5);
$pdf->Cell(25, 6, utf8_decode($nuevo5), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 57, 170.8, 37, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(138.5);
$pdf->SetX(99);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}


if($nuevo6!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(164);
$pdf->SetX(56.2);
$pdf->Cell(25, 6, utf8_decode($nuevo6), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 57, 168, 20, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(132);
$pdf->SetX(99);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($nuevo7!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(165);
$pdf->SetX(28);
$pdf->Cell(25, 6, utf8_decode($nuevo7), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 32, 169, 20, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(130);
$pdf->SetX(95);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}


if($nuevo8!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(164);
$pdf->SetX(23.5);
$pdf->Cell(25, 6, utf8_decode($nuevo8), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 28, 168, 20, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(132);
$pdf->SetX(89);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}


if($frenteizquierda!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(140);
$pdf->SetX(16);
$pdf->Cell(25, 6, utf8_decode($frenteizquierda), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 16.5, 144.5, 35, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(141.4);
$pdf->SetX(39);
//$pdf->Cell(25, 6, utf8_decode('x'), 0,0, 'C');
}

if($frentederecha!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(140);
$pdf->SetX(53);
$pdf->Cell(25, 6, utf8_decode($frentederecha), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 53.5, 144.5, 35, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(103.2);
$pdf->SetX(96);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($narizc!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(143);
$pdf->SetX(52);
$pdf->Cell(25, 6, utf8_decode($narizc), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 52.5, 147, 35, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(105.7);
$pdf->SetX(94.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mejderecha!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(145);
$pdf->SetX(54);
$pdf->Cell(25, 6, utf8_decode($mejderecha), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 54.5, 148.8, 33.5, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(108.4);
$pdf->SetX(97.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($marf!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(144);
$pdf->SetX(16);
$pdf->Cell(25, 6, utf8_decode($marf), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 16, 148, 35, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(108.5);
$pdf->SetX(92.1);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mare!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(146.6);
$pdf->SetX(16);
$pdf->Cell(25, 6, utf8_decode($mare), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 16, 150.5, 37, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(110.4);
$pdf->SetX(94.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mandiizqui!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(148.3);
$pdf->SetX(16);
$pdf->Cell(25, 6, utf8_decode($mandiizqui), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 16, 151.9, 35.5, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(112.4);
$pdf->SetX(92.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mandiderr!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(147.5);
$pdf->SetX(53.5);
$pdf->Cell(25, 6, utf8_decode($mandiderr), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 54, 151.5, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(111.4);
$pdf->SetX(97.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mandicentroo!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(149.5);
$pdf->SetX(52);
$pdf->Cell(25, 6, utf8_decode($mandicentroo), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 52.5, 153.2, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(113.6);
$pdf->SetX(94.9);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cvi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(152.5);
$pdf->SetX(14.5);
$pdf->Cell(25, 6, utf8_decode($cvi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 15, 156.5, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(118.3);
$pdf->SetX(90.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mard!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(152.5);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($mard), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 56, 156.5, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(118.3);
$pdf->SetX(98.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($homi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(155);
$pdf->SetX(14.5);
$pdf->Cell(25, 6, utf8_decode($homi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 15, 159, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(122.1);
$pdf->SetX(81.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($hombrod!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(155);
$pdf->SetX(60.8);
$pdf->Cell(25, 6, utf8_decode($hombrod), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 61.5, 159, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(122.1);
$pdf->SetX(107.3);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($pecti!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(158);
$pdf->SetX(14.5);
$pdf->Cell(25, 6, utf8_decode($pecti), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 15, 162, 33, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(125.1);
$pdf->SetX(89.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($pectd!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(158);
$pdf->SetX(57);
$pdf->Cell(25, 6, utf8_decode($pectd), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 56, 162, 33, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(125.1);
$pdf->SetX(100.2);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($peci!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(161);
$pdf->SetX(10);
$pdf->Cell(25, 6, utf8_decode($peci), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 165.5, 41, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(128);
$pdf->SetX(92.9);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($marc!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(161);
$pdf->SetX(70);
$pdf->Cell(25, 6, utf8_decode($marc), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 53.5, 165.5, 41, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(128);
$pdf->SetX(97.6);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($brazci!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(160.2);
$pdf->SetX(10);
$pdf->Cell(25, 6, utf8_decode($brazci), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 164.5, 33, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(130);
$pdf->SetX(80.9);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cconder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(160.5);
$pdf->SetX(62.5);
$pdf->Cell(25, 6, utf8_decode($cconder), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 63, 164.5, 33, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(130);
$pdf->SetX(109.1);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($brazi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(165);
$pdf->SetX(10);
$pdf->Cell(25, 6, utf8_decode($brazi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 169.5, 31, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(133);
$pdf->SetX(80);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($annbraz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(165);
$pdf->SetX(70);
$pdf->Cell(25, 6, utf8_decode($annbraz), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 65, 169, 29, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(133);
$pdf->SetX(110);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($marg!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(170.5);
$pdf->SetX(9.5);
$pdf->Cell(25, 6, utf8_decode($marg), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 174.5, 29, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142.1);
$pdf->SetX(76);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($derbraz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(170);
$pdf->SetX(55);
$pdf->Cell(25, 6, utf8_decode($derbraz), 0,0, 'C');
$pdf->Image('../registro_clinico/linea.png', 65, 174, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142.1);
$pdf->SetX(113.1);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($muñei!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(174.4);
$pdf->SetX(9.5);
$pdf->Cell(25, 6, utf8_decode($muñei), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 178.5, 27, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(145.6);
$pdf->SetX(74.9);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($muñecad!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(174.4);
$pdf->SetX(68);
$pdf->Cell(25, 6, utf8_decode($muñecad), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 68.5, 178.5, 27, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(145.6);
$pdf->SetX(114.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($palmai!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(179.2);
$pdf->SetX(4);
$pdf->Cell(25, 6, utf8_decode($palmai), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 5, 183, 30.2, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(148);
$pdf->SetX(73.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($palmad!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(179.2);
$pdf->SetX(69.5);
$pdf->Cell(25, 6, utf8_decode($palmad), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 70.2, 183, 30.2, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(148);
$pdf->SetX(115.3);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($ddi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(177.4);
$pdf->SetX(4.5);
$pdf->Cell(25, 6, utf8_decode($ddi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 5, 181.1, 27, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(149.7);
$pdf->SetX(67.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($ddoderu!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(177.3);
$pdf->SetX(72.5);
$pdf->Cell(25, 6, utf8_decode($ddoderu), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 73.5, 181.1, 30.2, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(149.7);
$pdf->SetX(121.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($ddidos!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(181);
$pdf->SetX(2);
$pdf->Cell(25, 6, utf8_decode($ddidos), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 2.5, 185.1, 30.2, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(153);
$pdf->SetX(69.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dedodos!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(181.7);
$pdf->SetX(72);
$pdf->Cell(25, 6, utf8_decode($dedodos), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 72.8, 185.5, 19, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(153);
$pdf->SetX(119.6);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dditres!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(183.2);
$pdf->SetX(1.7);
$pdf->Cell(25, 6, utf8_decode($dditres), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 2.5, 186.9, 30.9, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(155);
$pdf->SetX(70.9);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dedotres!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(183.7);
$pdf->SetX(65.5);
$pdf->Cell(25, 6, utf8_decode($dedotres), 0,0, 'C');
$pdf->Image('../registro_clinico/linea.png', 72, 187.4, 19, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(155);
$pdf->SetX(118.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dedocuatro!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(183.7);
$pdf->SetX(54);
$pdf->Cell(25, 6, utf8_decode($dedocuatro), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 55.1, 187.3, 16, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(156.5);
$pdf->SetX(117.3);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($ddicuatro!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(183.7);
$pdf->SetX(34);
$pdf->Cell(25, 6, utf8_decode($ddicuatro), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 34.1, 187.3, 20, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(156.5);
$pdf->SetX(72);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($ddicinco!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(181);
$pdf->SetX(35.5);
$pdf->Cell(25, 6, utf8_decode($ddicinco), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 36.1, 184.9, 20, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(155.3);
$pdf->SetX(73.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dedocincoo!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(180.7);
$pdf->SetX(52);
$pdf->Cell(25, 6, utf8_decode($dedocincoo), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 53, 184.6, 16, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(155.3);
$pdf->SetX(115.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($iabdomen!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(171.9);
$pdf->SetX(24.8);
$pdf->Cell(25, 6, utf8_decode($iabdomen), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 25, 175.6, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(140.1);
$pdf->SetX(95);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($marb!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(177);
$pdf->SetX(53.5);
$pdf->Cell(25, 6, utf8_decode($marb), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 54.5, 180.6, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(149);
$pdf->SetX(97.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}


if($inglei!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(177);
$pdf->SetX(26.8);
$pdf->Cell(25, 6, utf8_decode($inglei), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 23, 180.6, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(149);
$pdf->SetX(93);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mara!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(180);
$pdf->SetX(29);
$pdf->Cell(25, 6, utf8_decode($mara), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 25, 183.5, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(152.3);
$pdf->SetX(94.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($musloi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(189.5);
$pdf->SetX(13);
$pdf->Cell(25, 6, utf8_decode($musloi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 13, 194, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(162.1);
$pdf->SetX(87.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($muslod!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(189);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($muslod), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 58, 194, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(162.1);
$pdf->SetX(102.2);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($rodd!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(196);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($rodd), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 58, 200, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(172.1);
$pdf->SetX(102.2);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($rodi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(196);
$pdf->SetX(13);
$pdf->Cell(25, 6, utf8_decode($rodi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 13, 200, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(172.1);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($tod!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(212);
$pdf->SetX(13);
$pdf->Cell(25, 6, utf8_decode($tod), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 13, 216, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(192.1);
$pdf->SetX(89);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($toi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(212);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($toi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 58, 216, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(192.1);
$pdf->SetX(100);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($pied!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(216);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($pied), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 58, 220, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(197);
$pdf->SetX(102);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($pie!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(216);
$pdf->SetX(13);
$pdf->Cell(25, 6, utf8_decode($pie), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 13, 220, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(197);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

//$pdf->Ln(110);

//terminomarcaje frontal

//$pdf->Cell(189, 6, utf8_decode(''), 0,0, 'C');

//$pdf->Image('../../img/cuerpot.jpg' , 79, 42, 56);



if($coxis!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(176.3);
$pdf->SetX(135);
$pdf->Cell(25, 6, utf8_decode($coxis), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 135.6, 180, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(88);
$pdf->SetX(94);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

//marcaje trasero
if($plantapiea!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(215);
$pdf->SetX(128);
$pdf->Cell(25, 6, utf8_decode($plantapiea), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 129, 219, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142);
$pdf->SetX(86.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($plantapieader!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(215);
$pdf->SetX(176);
$pdf->Cell(25, 6, utf8_decode($plantapieader), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 170, 219, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142);
$pdf->SetX(101);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($tobilloatd!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(210);
$pdf->SetX(176);
$pdf->Cell(25, 6, utf8_decode($tobilloatd), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 170, 214, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(137);
$pdf->SetX(101);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($tobilloati!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(210);
$pdf->SetX(128);
$pdf->Cell(25, 6, utf8_decode($tobilloati), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 129, 214, 31, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(137);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($ptiatras!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(203);
$pdf->SetX(128.5);
$pdf->Cell(25, 6, utf8_decode($ptiatras), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 129, 207, 31, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(126);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($ptdatras!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(203);
$pdf->SetX(176);
$pdf->Cell(25, 6, utf8_decode($ptdatras), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 170, 207, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(126);
$pdf->SetX(100.6);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($pierespaldad!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(196);
$pdf->SetX(176);
$pdf->Cell(25, 6, utf8_decode($pierespaldad), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 170, 200, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(114);
$pdf->SetX(100.6);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($pierespaldai!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(196);
$pdf->SetX(129);
$pdf->Cell(25, 6, utf8_decode($pierespaldai), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 130, 200, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(114);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($musloatrasiz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(187);
$pdf->SetX(129);
$pdf->Cell(25, 6, utf8_decode($musloatrasiz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 130, 191, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(107);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($musloatrasder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(187);
$pdf->SetX(176);
$pdf->Cell(25, 6, utf8_decode($musloatrasder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 170, 191, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(107);
$pdf->SetX(100.3);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($dorsalder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(177.5);
$pdf->SetX(183.6);
$pdf->Cell(25, 6, utf8_decode($dorsalder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 181.5, 181.4, 26, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(91);
$pdf->SetX(117.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dorsaliz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(177.7);
$pdf->SetX(117);
$pdf->Cell(25, 6, utf8_decode($dorsaliz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 118, 181.4, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(91);
$pdf->SetX(70);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($munecaatrasiz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(174.2);
$pdf->SetX(119);
$pdf->Cell(25, 6, utf8_decode($munecaatrasiz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 119.6, 177.9, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(87);
$pdf->SetX(72);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($munecaatrasder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(174.2);
$pdf->SetX(183.5);
$pdf->Cell(25, 6, utf8_decode($munecaatrasder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 179.6, 177.9, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(87);
$pdf->SetX(115);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($antebdesp!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(171.4);
$pdf->SetX(183);
$pdf->Cell(25, 6, utf8_decode($antebdesp), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 179, 175, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(83);
$pdf->SetX(113);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($antebiesp!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(171);
$pdf->SetX(120);
$pdf->Cell(25, 6, utf8_decode($antebiesp), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 120, 175, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(83);
$pdf->SetX(74);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($casicodoi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(167);
$pdf->SetX(120.5);
$pdf->Cell(25, 6, utf8_decode($casicodoi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 121, 171.1, 31, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(77);
$pdf->SetX(76);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($casicododer!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(166);
$pdf->SetX(182);
$pdf->Cell(25, 6, utf8_decode($casicododer), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 177, 170, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(77);
$pdf->SetX(111);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($brazaltder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(162);
$pdf->SetX(179.5);
$pdf->Cell(25, 6, utf8_decode($brazaltder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 176, 166.1, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(71);
$pdf->SetX(110);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($brazalti!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(162);
$pdf->SetX(120);
$pdf->Cell(25, 6, utf8_decode($brazalti), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 120, 166, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(71);
$pdf->SetX(77);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($glutiz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(179.6);
$pdf->SetX(130);
$pdf->Cell(25, 6, utf8_decode($glutiz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 131, 183.3, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(94.5);
$pdf->SetX(90);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($glutder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(179.6);
$pdf->SetX(174);
$pdf->Cell(25, 6, utf8_decode($glutder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 168, 183.3, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(94.5);
$pdf->SetX(97.2);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cinturader!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(169.4);
$pdf->SetX(174);
$pdf->Cell(25, 6, utf8_decode($cinturader), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 168, 173, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(84.5);
$pdf->SetX(96.6);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cinturaiz!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(169.4);
$pdf->SetX(131);
$pdf->Cell(25, 6, utf8_decode($cinturaiz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 132, 173, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(84.5);
$pdf->SetX(91);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($marh!=NULL){
  $pdf->SetFont('Arial', 'B',5);
$pdf->SetY(165);
$pdf->SetX(133.5);
$pdf->Cell(25, 6, utf8_decode($marh), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 134, 169, 31, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(80);
$pdf->SetX(94);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($costilliz!=NULL){
  $pdf->SetFont('Arial', 'B',5);
$pdf->SetY(164.2);
$pdf->SetX(127.7);
$pdf->Cell(25, 6, utf8_decode($costilliz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 128, 168.1, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(73);
$pdf->SetX(90);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($costillder!=NULL){
  $pdf->SetFont('Arial', 'B',5);
$pdf->SetY(164.2);
$pdf->SetX(177.7);
$pdf->Cell(25, 6, utf8_decode($costillder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 168, 168.1, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(73);
$pdf->SetX(97);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($espaldaarribader!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(157);
$pdf->SetX(177);
$pdf->Cell(25, 6, utf8_decode($espaldaarribader), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 168, 161, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(64);
$pdf->SetX(100);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($espaldarribaiz!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(156.9);
$pdf->SetX(126);
$pdf->Cell(25, 6, utf8_decode($espaldarribaiz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 127, 161, 34, 0.1);

$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(64);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($espaldaalta!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(152);
$pdf->SetX(175);
$pdf->Cell(25, 6, utf8_decode($espaldaalta), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 165, 155.8, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(57);
$pdf->SetX(93.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cuellatrasb!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(148.5);
$pdf->SetX(175);
$pdf->Cell(25, 6, utf8_decode($cuellatrasb), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 165, 152.6, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(52);
$pdf->SetX(93.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cuellatrasmedio!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(146.4);
$pdf->SetX(175);
$pdf->Cell(25, 6, utf8_decode($cuellatrasmedio), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 165, 150.1, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(48.5);
$pdf->SetX(93.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cabedorsalm!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(144);
$pdf->SetX(175);
$pdf->Cell(25, 6, utf8_decode($cabedorsalm), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 165, 148, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(45.5);
$pdf->SetX(93.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cabealtaizqu!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(142.1);
$pdf->SetX(129);
$pdf->Cell(25, 6, utf8_decode($cabealtaizqu), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 129, 146, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(42.5);
$pdf->SetX(91);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cabezaaltader!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(142.1);
$pdf->SetX(177);
$pdf->Cell(25, 6, utf8_decode($cabezaaltader), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 167, 146, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(42.5);
$pdf->SetX(96);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
  
}

$pdf->Ln(192); 
}else{
  $pdf->Ln(11);  
}*/








//termino marcaje atras

//$pdf->Ln(190);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,5, utf8_decode('Control de Textiles'),1,0,'C');
$pdf->Ln(5);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30,5, utf8_decode('Material'),1,0,'C');
$pdf->Cell(25,5, utf8_decode('Inicio'),1,0,'C');
$pdf->Cell(25,5, utf8_decode('Dentro'),1,0,'C');
$pdf->Cell(25,5, utf8_decode('Fuera'),1,0,'C');
$pdf->Cell(25,5, utf8_decode('Total'),1,0,'C');
$pdf->Cell(60,5, utf8_decode('Registró'),1,0,'C');
$pdf->Ln(5);
$sql_qit = "SELECT * from textiles where id_atencion=$id_atencion and fechare='$fechar'";
$result_qit = $conexion->query($sql_qit); 
while ($row_te = $result_qit->fetch_assoc()) {
    
     $id_usua2=$row_te['id_usua2'];
  $id_usua=$row_te['id_usua'];
    $pdf->SetFont('Arial', '', 8);
$pdf->Cell(30,5, utf8_decode($row_te['mat']),1,0,'C');
$pdf->Cell(25,5, utf8_decode($row_te['inicio']),1,0,'C');
$pdf->Cell(25,5, utf8_decode($row_te['dentro']),1,0,'C');
$pdf->Cell(25,5, utf8_decode($row_te['fuera']),1,0,'C');
$pdf->Cell(25,5, utf8_decode($row_te['total']),1,0,'C');

 if($id_usua2==null){
        $pdf->Cell(60,5, utf8_decode($row_te['id_usua']),1,0,'C');
    $pdf->Ln(5);
 }else  if($id_usua2!=null){
     
   $pdf->Cell(60,5, utf8_decode($row_te['id_usua2']),1,0,'C');
    $pdf->Ln(5);
 }
}


$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,5, utf8_decode('Signos vitales'),1,0,'C');
$pdf->Ln(5);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50,5, utf8_decode('Hora'),1,0,'C');
$pdf->Cell(70,5, utf8_decode('Presión arterial'),1,0,'C');
$pdf->Cell(35,5, utf8_decode('Frecuencia cardiaca'),1,0,'C');

//$pdf->Cell(35,5, utf8_decode('Temp'),1,0,'C');
$pdf->Cell(35,5, utf8_decode('Saturación de oxígeno'),1,0,'C');
$pdf->Ln(5);
$sql_qits = "SELECT * from dat_quir_grafico where id_atencion=$id_atencion and fechare='$fechar'";
$result_qits = $conexion->query($sql_qits); 
while ($row_tes = $result_qits->fetch_assoc()) {
    
$pdf->Cell(50,5, utf8_decode($row_tes['hora']),1,0,'C');
$pdf->Cell(70,5, $row_tes['sistg'].'/'.$row_tes['diastg'],1,0,'C');
$pdf->Cell(35,5, utf8_decode($row_tes['fcardg']),1,0,'C');
$pdf->Cell(35,5, utf8_decode($row_tes['satg']),1,0,'C');
//$pdf->Cell(35,5, utf8_decode($row_tes['total']),1,0,'C');
    $pdf->Ln(5);
    
}


$pdf->Ln(4);



$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190,5, utf8_decode('Ingresos'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(125,5, utf8_decode('Soluciones'),1,0,'C');
$pdf->Cell(30,5, utf8_decode('Hora'),1,0,'C');
$pdf->Cell(35,5, utf8_decode('Volumen'),1,0,'C');
//$pdf->Cell(35,5, utf8_decode('Ingreso parcial total'),1,0,'C');
$pdf->Ln(5);
$sql_qi = "SELECT * from ingresos_quir where id_atencion=$id_atencion and fecha='$fechar'";
$result_qi = $conexion->query($sql_qi); 
while ($row_q = $result_qi->fetch_assoc()) {
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(125,5, utf8_decode($row_q['soluciones']),1,0,'C');
$pdf->Cell(30,5, utf8_decode($row_q['hora']),1,0,'C');
$pdf->Cell(35,5, utf8_decode($row_q['volumen']),1,0,'C');

$pdf->Ln(5);
}
$sql_qiv = "SELECT SUM(volumen) as volt, fecha, id_atencion from ingresos_quir where id_atencion=$id_atencion and fecha='$fechar'";
$result_qiv = $conexion->query($sql_qiv); 
while ($row_qv = $result_qiv->fetch_assoc()) {
    $volt=$row_qv['volt'];
    
   $ingpt= $volt;
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,5, utf8_decode('Ingreso parcial Total: ' . $ingpt),1,0,'R');




$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190,5, utf8_decode('Egresos'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(65,5, utf8_decode('Tipo'),1,0,'C');
$pdf->Cell(65,5, utf8_decode('Hora'),1,0,'C');
$pdf->Cell(60,5, utf8_decode('Volumen'),1,0,'C');

  $pdf->Ln(5);
$sql_qir = "SELECT * from egresos_quir where id_atencion=$id_atencion and fecha='$fechar' ORDER BY id";
$result_qir = $conexion->query($sql_qir); 
while ($row_qr = $result_qir->fetch_assoc()) {

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(65,5, utf8_decode($row_qr['soluciones']),1,0,'C');

$pdf->Cell(65,5, utf8_decode($row_qr['hora']),1,0,'C');

$pdf->Cell(60,5, utf8_decode($row_qr['volumen']),1,0,'C');
     $pdf->Ln(5);
}
$sql_qiv = "SELECT SUM(volumen) as voltt, fecha, id_atencion from egresos_quir where id_atencion=$id_atencion and fecha='$fechar'";
$result_qiv = $conexion->query($sql_qiv); 
while ($row_qv = $result_qiv->fetch_assoc()) {
    $voltt=$row_qv['voltt'];
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,5, utf8_decode('Egreso parcial Total: ' . $voltt),1,0,'R');

$balance=$ingpt-$voltt;

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,5, utf8_decode('Balance Total: ' . $balance),1,0,'R');



   $pdf->Ln(8);
$pdf->Cell(190,5, utf8_decode('Glicemia capilar'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(95,5, utf8_decode('Hora'),1,0,'C');
$pdf->Cell(95,5, utf8_decode('Volumen'),1,0,'C');
$pdf->Ln(5);
$sql_qitsh = "SELECT * from dat_quir_grafico where id_atencion=$id_atencion and fechare='$fechar'";
$result_qitsh = $conexion->query($sql_qitsh); 
while ($row_tesh = $result_qitsh->fetch_assoc()) {
    
    if($row_tesh['glic']!=null){
$pdf->Cell(95,5, utf8_decode($row_tesh['hora']),1,0,'C');
$pdf->Cell(95,5, utf8_decode($row_tesh['glic']),1,0,'C');
$pdf->Ln(5);
    }
    



}

 $pdf->Ln(5);
 $pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190,5, utf8_decode('Sondas y catéteres'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(35,5, utf8_decode('Dispositivo'),1,0,'C');
$pdf->Cell(25,5, utf8_decode('Calibre'),1,0,'C');
$pdf->Cell(25,5, utf8_decode('Fecha instalación'),1,0,'C');
$pdf->Cell(35,5, utf8_decode('Instaló'),1,0,'C');
$pdf->Cell(70,5, utf8_decode('Observaciones'),1,0,'C');
$pdf->Ln(5);
$sql_qirgc = "SELECT * from cate_enf_ter where id_atencion=$id_atencion and fecha_inst='$fechar' and tip='Quirofano' ORDER BY id desc";
$result_qirgc = $conexion->query($sql_qirgc); 
while ($row_qrgc = $result_qirgc->fetch_assoc()) {
$pdf->Cell(35,5, utf8_decode($row_qrgc['dispositivos']),1,0,'C');
$pdf->Cell(25,5, utf8_decode($row_qrgc['tipo']),1,0,'C');
$dateca = date_create($row_qrgc['fecha_inst']);
$pdf->Cell(25,5, date_format($dateca, "d-m-Y"),1,0,'C');
$pdf->Cell(35,5, utf8_decode($row_qrgc['instalo']),1,0,'C');
$pdf->Cell(70,5, utf8_decode($row_qrgc['cultivo']),1,0,'C');
$pdf->Ln(5);

}
/*
 $pdf->Ln(5);
 $pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190,5, utf8_decode('MEDICAMENTOS'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(155,5, utf8_decode('Material'),1,0,'C');
$pdf->Cell(155,5, utf8_decode('Hora'),1,0,'C');
$pdf->Cell(35,5, utf8_decode('Cantidad'),1,0,'C');
$pdf->Ln(5);
$sql_qirgc = "SELECT * from medica_enf where id_atencion=$id_atencion and fecha_mat='$fechar' and tipo='QUIROFANO' and material='No' ORDER BY id_med_reg desc";
$result_qirgc = $conexion->query($sql_qirgc); 
while ($row_qrgc = $result_qirgc->fetch_assoc()) {
$pdf->Cell(155,5, utf8_decode($row_qrgc['medicam_mat']),1,0,'C');

$pdf->Cell(35,5, utf8_decode($row_qrgc['cantidad']),1,0,'C');
$pdf->Ln(5);
}

*/
/*
 $pdf->Ln(5);
 $pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190,5, utf8_decode('MATERIALES'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(155,5, utf8_decode('Material'),1,0,'C');

$pdf->Cell(35,5, utf8_decode('Cantidad'),1,0,'C');
$pdf->Ln(5);
$sql_qirgc = "SELECT * from medica_enf where id_atencion=$id_atencion and fecha_mat='$fechar' and tipo='QUIROFANO' and material='Si' ORDER BY id_med_reg desc";
$result_qirgc = $conexion->query($sql_qirgc); 
while ($row_qrgc = $result_qirgc->fetch_assoc()) {
$pdf->Cell(155,5, utf8_decode($row_qrgc['medicam_mat']),1,0,'C');

$pdf->Cell(35,5, utf8_decode($row_qrgc['cantidad']),1,0,'C');
$pdf->Ln(5);

}*/
/*

 $pdf->Ln(2);
 $pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190,5, utf8_decode('EQUIPOS'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(130,5, utf8_decode('Equipo'),1,0,'C');
$pdf->Cell(25,5, utf8_decode('Cantidad'),1,0,'C');
$pdf->Cell(35,5, utf8_decode('Fecha'),1,0,'C');
$pdf->Ln(5);
$sql_qirgc = "SELECT * from equipos_ceye where id_atencion=$id_atencion and fecha_registro='$fechar' ORDER BY id_equipceye desc";
$result_qirgc = $conexion->query($sql_qirgc); 
while ($row_qrgc = $result_qirgc->fetch_assoc()) {
$pdf->Cell(130,5, utf8_decode($row_qrgc['nombre']),1,0,'C');
$pdf->Cell(25,5, utf8_decode($row_qrgc['tiempo']),1,0,'C');
$pdf->Cell(35,5, utf8_decode($row_qrgc['fecha_registro']),1,0,'C');

$pdf->Ln(5);

}
*/



$sql_qir = "SELECT * from recu where id_atencion=$id_atencion and text_fecha='$fechar'";
$result_qir = $conexion->query($sql_qir); 
while ($row_qr = $result_qir->fetch_assoc()) {
    $salac=$row_qr['sala'];
$inicio_cir=$row_qr['inicio_cir'];
$imagen=$row_qr['imagen'];
$incidentes=$row_qr['incidentes'];
$not_recu=$row_qr['not_recu'];
$ter_cir=$row_qr['ter_cir'];

$cirujano=$row_qr['cirujano'];
$anestesiologo=$row_qr['anestesiologo'];
$instrumentista=$row_qr['instrumentista'];
$circulante=$row_qr['circulante'];

$circulante2=$row_qr['circulante2'];
$circulante3=$row_qr['circulante3'];

$trauma=$row_qr['trauma'];
$neuro=$row_qr['neuro'];
$maxi=$row_qr['maxi'];
$gastro=$row_qr['gastro'];
$onco=$row_qr['onco'];
$gine=$row_qr['gine'];
$bari=$row_qr['bari'];


$p_a=$row_qr['p_a'];
$s_a=$row_qr['s_a'];
$t_a=$row_qr['t_a'];
}
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,5, utf8_decode('TRANSOPERATORIO / POSTOPERATORIO'),0,0,'C');


$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,5, utf8_decode('Hora de inicio de cirugía:'),0,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(150,5, utf8_decode($inicio_cir),'B',0,'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25,5, utf8_decode('Imagenología:'),0,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(165,5, utf8_decode($imagen),'B','L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25,5, utf8_decode('Incidentes:'),0,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Multicell(165,5, utf8_decode($incidentes),'B','L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,5, utf8_decode('Nota Transoperatoria:'),0,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Multicell(155,5, utf8_decode($not_recu),'B','L');



$sql_qir = "SELECT * from enf_posto where id_atencion=$id_atencion and fecha='$fechar'";
$result_qir = $conexion->query($sql_qir); 
while ($row_qr = $result_qir->fetch_assoc()) {
$ter_anes=$row_qr['ter_anes'];
//$ter_cir=$row_qr['ter_cir'];
$tip_cir=$row_qr['tip_cir'];

$p_medico=$row_qr['p_medico'];
$p_anato=$row_qr['p_anato'];

$oxi=$row_qr['oxi'];
$con=$row_qr['con'];
$muc=$row_qr['muc'];
$vent=$row_qr['vent'];
$est=$row_qr['est'];


$notapost=$row_qr['notapost'];


//marcaje final var

$mara=$row_qr['mara'];
$marb=$row_qr['marb'];
$marc=$row_qr['marc'];
$mard=$row_qr['mard'];
$mare=$row_qr['mare'];
$marf=$row_qr['marf'];
$marg=$row_qr['marg'];
$marh=$row_qr['marh'];

$frenteizquierda=$row_qr['frenteizquierda'];
$frentederecha=$row_qr['frentederecha'];
$narizc=$row_qr['narizc'];
$mejderecha=$row_qr['mejderecha'];
$mandiizqui=$row_qr['mandiizqui'];
$mandiderr=$row_qr['mandiderr'];
$mandicentroo=$row_qr['mandicentroo'];
$cvi=$row_qr['cvi'];
$homi=$row_qr['homi'];
$hombrod=$row_qr['hombrod'];
$pecti=$row_qr['pecti'];
$pectd=$row_qr['pectd'];
$peci=$row_qr['peci'];
$brazci=$row_qr['brazci'];
$cconder=$row_qr['cconder'];
$brazi=$row_qr['brazi'];
$annbraz=$row_qr['annbraz'];
$derbraz=$row_qr['derbraz'];
$muñei=$row_qr['munei'];
$muñecad=$row_qr['munecad'];
$palmai=$row_qr['palmai'];
$palmad=$row_qr['palmad'];
$ddi=$row_qr['ddi'];
$ddoderu=$row_qr['ddoderu'];
$ddidos=$row_qr['ddidos'];
$dedodos=$row_qr['dedodos'];
$dditres=$row_qr['dditres'];
$dedotres=$row_qr['dedotres'];
$dedocuatro=$row_qr['dedocuatro'];
$ddicuatro=$row_qr['ddicuatro'];
$ddicinco=$row_qr['ddicinco'];
$dedocincoo=$row_qr['dedocincoo'];
$iabdomen=$row_qr['iabdomen'];
$inglei=$row_qr['inglei'];
$musloi=$row_qr['musloi'];
$muslod=$row_qr['muslod'];
$rodd=$row_qr['rodd'];
$rodi=$row_qr['rodi'];
$tod=$row_qr['tod'];
$toi=$row_qr['toi'];
$pied=$row_qr['pied'];
$pie=$row_qr['pie'];
$plantapiea=$row_qr['plantapiea'];
$plantapieader=$row_qr['plantapieader'];
$tobilloatd=$row_qr['tobilloatd'];
$tobilloati=$row_qr['tobilloati'];
$ptiatras=$row_qr['ptiatras'];
$ptdatras=$row_qr['ptdatras'];
$pierespaldad=$row_qr['pierespaldad'];
$pierespaldai=$row_qr['pierespaldai'];
$musloatrasiz=$row_qr['musloatrasiz'];
$musloatrasder=$row_qr['musloatrasder'];
$dorsaliz=$row_qr['dorsaliz'];
$dorsalder=$row_qr['dorsalder'];
$munecaatrasiz=$row_qr['munecaatrasiz'];
$munecaatrasder=$row_qr['munecaatrasder'];
$antebdesp=$row_qr['antebdesp'];
$antebiesp=$row_qr['antebiesp'];
$casicodoi=$row_qr['casicodoi'];
$casicododer=$row_qr['casicododer'];
$brazaltder=$row_qr['brazaltder'];
$brazalti=$row_qr['brazalti'];
$glutiz=$row_qr['glutiz'];
$glutder=$row_qr['glutder'];
$cinturader=$row_qr['cinturader'];
$cinturaiz=$row_qr['cinturaiz'];
$costilliz=$row_qr['costilliz'];
$costillder=$row_qr['costillder'];
$espaldaarribader=$row_qr['espaldaarribader'];
$espaldarribaiz=$row_qr['espaldarribaiz'];
$espaldaalta=$row_qr['espaldaalta'];
$cuellatrasb=$row_qr['cuellatrasb'];
$cuellatrasmedio=$row_qr['cuellatrasmedio'];
$cabedorsalm=$row_qr['cabedorsalm'];
$cabealtaizqu=$row_qr['cabealtaizqu'];
$cabezaaltader=$row_qr['cabezaaltader'];

$nuevo1=$row_qr['nuevo1'];
$nuevo2=$row_qr['nuevo2'];
$nuevo3=$row_qr['nuevo3'];
$nuevo4=$row_qr['nuevo4'];
$nuevo5=$row_qr['nuevo5'];
$nuevo6=$row_qr['nuevo6'];
$nuevo7=$row_qr['nuevo7'];
$nuevo8=$row_qr['nuevo8'];

$espizq=$row_qr['espizq'];
$espder=$row_qr['espder'];
$coxis=$row_qr['coxis'];
//marcaje final variables

$cir_real=$row_qr['cir_real'];
}

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50,5, utf8_decode('Hora de término de anestesia:'),0,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(140,5, utf8_decode($ter_anes),'B',0,'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(28,5, utf8_decode('Cirugía realizada:'),0,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(162,5, utf8_decode($cir_real),'B','L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(45,5, utf8_decode('Hora de término de cirugía:'),0,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25,5, utf8_decode($ter_cir),'B','L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25,5, utf8_decode('Tipo de cirugía:'),0,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Multicell(95,5, utf8_decode($tip_cir),'B','L');


if($p_medico!=NULL){
    $pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(29,5, utf8_decode('Pieza patológica:'),0,0,'L');
$pdf->Multicell(161,5, utf8_decode('Si'. ': '. $p_anato),'B','L');
 
}else{
        $pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(29,5, utf8_decode('Pieza patológica:'),0,0,'L');
$pdf->Multicell(161,5, utf8_decode('No'),'B','L');
}

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,5, utf8_decode('MEDIDAS PARA LA PREVENCIÓN DE RIESGO DE CAÍDAS'),0,0,'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,5, utf8_decode('Recuerda que un paciente en quirófano y recuperación siempre tendrá un risgo ALTO'),0,0,'C');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(150,4, utf8_decode('1.- ¿Barandales de cama o camilla elevados?'),1,0,'C');
if($oxi=='SI'){
$oxi='SI';
}
$pdf->Cell(40,4, utf8_decode('( ' . $oxi . ' )'),1,0,'C');

$pdf->Ln(4);
$pdf->Cell(150,4, utf8_decode('2.- ¿Vigilado por el personal de área?'),1,0,'C');
if($con=='SI'){
$con='SI';
}
$pdf->Cell(40,4, utf8_decode('( ' . $con . ' )'),1,0,'C');

$pdf->Ln(4);
$pdf->Cell(150,4, utf8_decode('3.- ¿Se colocaron sujetadores?'),1,0,'C');
if($muc=='SI'){
$muc='SI';
}
$pdf->Cell(40,4, utf8_decode('( ' . $muc . ' )'),1,0,'C');

$pdf->Ln(4);
$pdf->Cell(150,4, utf8_decode('4.- ¿Se aseguró al paciente antes de cambio de cama o camilla?'),1,0,'C');
if($vent=='SI'){
$vent='SI';
}
$pdf->Cell(40,4, utf8_decode('( ' . $vent . ' )'),1,0,'C');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->Cell(150,4, utf8_decode('5.- ¿Se asguró al paciente antes de realizar movimiento de cambio de posición del paciente o de la mesa quirúrgica?'),1,0,'C');
if($est=='SI'){
    $pdf->SetFont('Arial', 'B', 8);
$est='SI';
}
$pdf->Cell(40,4, utf8_decode('( ' . $est . ' )'),1,0,'C');


$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,4, utf8_decode('Personal que participo'),1,0,'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);

$pdf->MultiCell(190,4, utf8_decode('Cirujano :' .$cirujano),1,'L');

$pdf->Ln(1);
$pdf->MultiCell(190,4, utf8_decode('Antestesiologo :' .$anestesiologo),1,'L');
$pdf->Ln(1);

$pdf->MultiCell(190,4, utf8_decode('Instrumentista :' .$instrumentista),1,'L');
$pdf->Ln(1);


$pdf->SetFont('Arial', 'B', 8);

if($circulante==null){
    $circulante='';
}else{

$sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $circulante";
    $result_med = $conexion->query($sql_med);

    while ($row_med = $result_med->fetch_assoc()) {
      
      $appc = $row_med['papell'];
      $apmc = $row_med['sapell'];
      $prec = $row_med['pre'];
      $firmac = $row_med['firma'];
      $ced_pc = $row_med['cedp'];
$cargpc = $row_med['cargp'];
}
}
if($circulante2==null){
    $circulante2='';
}else{
$sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $circulante2";
    $result_med = $conexion->query($sql_med);

    while ($row_med = $result_med->fetch_assoc()) {
      
      $appc2 = $row_med['papell'];
      $apmc2 = $row_med['sapell'];
      $prec2 = $row_med['pre'];
    $firmac2 = $row_med['firma'];
      $ced_pc2 = $row_med['cedp'];
$cargpc2 = $row_med['cargp'];
} 
}
if($circulante3==null){
    $circulante3='';
}else{
   $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $circulante3";
    $result_med = $conexion->query($sql_med);

    while ($row_med = $result_med->fetch_assoc()) {
      
      $appc3 = $row_med['papell'];
      $apmc3 = $row_med['sapell'];
      $prec3 = $row_med['pre'];
    $firmac3 = $row_med['firma'];
      $ced_pc3 = $row_med['cedp'];
$cargpc3 = $row_med['cargp'];
} 
}


$pdf->Cell(190,4, utf8_decode('Circulante: ' .$appc),1,0,'L');
$pdf->Ln(5);
$pdf->Cell(190,4, utf8_decode('Circulante 2: ' .$appc2),1,0,'L');
$pdf->Ln(5);
$pdf->Cell(190,4, utf8_decode('Circulante 3: ' .$appc3),1,0,'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(95,4, utf8_decode('Traumatólogo'),1,0,'C');
$pdf->Cell(95,4, utf8_decode('Neurocirujano'),1,0,'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(4);
$pdf->Cell(95,4, utf8_decode($trauma),1,0,'C');
$pdf->Cell(95,4, utf8_decode($neuro),1,0,'C');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(95,4, utf8_decode('Maxilofacial'),1,0,'C');
$pdf->Cell(95,4, utf8_decode('Gastroenterólogo'),1,0,'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(4);
$pdf->Cell(95,4, utf8_decode($maxi),1,0,'C');
$pdf->Cell(95,4, utf8_decode($gastro),1,0,'C');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(95,4, utf8_decode('Oncólogo'),1,0,'C');
$pdf->Cell(95,4, utf8_decode('Ginecólogo'),1,0,'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(4);
$pdf->Cell(95,4, utf8_decode($onco),1,0,'C');
$pdf->Cell(95,4, utf8_decode($gine),1,0,'C');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(95,4, utf8_decode('Bariatra'),1,0,'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(4);
$pdf->Cell(95,4, utf8_decode($bari),1,0,'C');


$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(190,5, utf8_decode('Primer ayudante: '. $p_a),1,'L');
$pdf->Ln(1);
$pdf->MultiCell(190,5, utf8_decode('Segundo ayudante: ' .$s_a),1,'L');
$pdf->Ln(1);
$pdf->MultiCell(190,5, utf8_decode('Tercer ayudante: ' .$t_a),1,'L');


$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,5, utf8_decode('Nota de recuperación:'),0,0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155,5, utf8_decode($notapost),'B','L');

$pdf->AddPage();
$pdf->Ln(2);
//$pdf->Ln(11);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(195, 6, utf8_decode('MEDICAMENTOS APLICADOS'), 0, 'C');

$pdf->Cell(100,4, utf8_decode('Medicamentos'),1,0,'C');
$pdf->Cell(35,4, utf8_decode('Otros'),1,0,'C');
$pdf->Cell(18,4, utf8_decode('Turno'),1,0,'C');
$pdf->Cell(15,4, utf8_decode('Dósis'),1,0,'C');
$pdf->Cell(20,4, utf8_decode('Vía'),1,0,'C');
$pdf->Cell(10,4, utf8_decode('Hora'),1,0,'C');


$pdf->Ln(4);
$medica = $conexion->query("select * from medica_enf WHERE fecha_mat='$fechar' and id_atencion=$id_atencion and tipo='QUIROFANO' and material !='Si' ORDER BY id_med_reg DESC") or die($conexion->error);
while ($row_m = $medica->fetch_assoc()) {
$hora_mat=$row_m['hora_mat'];


$hora_med = strval($hora_mat);
    
    if( ($hora_med>='08:00'and $hora_med<='08:59') || 
        ($hora_med>='09:00'and $hora_med<='09:59') || 
        ($hora_med>='10:00'and $hora_med<='10:59') || 
        ($hora_med>='11:00'and $hora_med<='11:59') || 
        ($hora_med>='12:00'and $hora_med<='12:59') || 
        ($hora_med>='13:00'and $hora_med<='13:59')){
        $turno="MATUTINO";
    } else if ( ($hora_med>='14:00'and $hora_med<='14:59') || 
        ($hora_med>='15:00'and $hora_med<='15:59') || 
        ($hora_med>='16:00'and $hora_med<='16:59') || 
        ($hora_med>='17:00'and $hora_med<='17:59') || 
        ($hora_med>='18:00'and $hora_med<='18:59') || 
        ($hora_med>='19:00'and $hora_med<='19:59') ||
        ($hora_med>='20:00'and $hora_med<='20:59') ){
        $turno="VESPERTINO";
    }else if ( ($hora_med>='21:00'and $hora_med<='21:59') || 
        ($hora_med>='22:00'and $hora_med<='22:59') || 
        ($hora_med>='23:00'and $hora_med<='23:59') || 
        ($hora_med>='24:00'and $hora_med<='24:59') || 
        ($hora_med>='01:00'and $hora_med<='01:59') || 
        ($hora_med>='02:00'and $hora_med<='02:59') ||
        ($hora_med>='03:00'and $hora_med<='03:59') ||
        ($hora_med>='04:00'and $hora_med<='04:59') ||
        ($hora_med>='05:00'and $hora_med<='5:59') || 
        ($hora_med>='06:00'and $hora_med<='006:59') ||
        ($hora_med>='07:00'and $hora_med<='07:59') ){
        $turno="NOCTURNO";
    }
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(100,4, utf8_decode($row_m['medicam_mat']),1,0,'C');
$pdf->Cell(35,4, utf8_decode($row_m['cantidad'].' - '.$row_m['otro']),1,0,'C');
$pdf->Cell(18,4, $turno,1,0,'C');
$pdf->Cell(15,4, $row_m['dosis_mat'],1,0,'C');
$pdf->Cell(20,4, $row_m['via_mat'],1,0,'C');
$pdf->Cell(10,4, $row_m['hora_mat'],1,1,'C');

}


$sql_med_id = "SELECT * FROM enf_quirurgico WHERE fecha='$fechar' and id_atencion = $id_atencion ORDER by id_quir DESC ";

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

 if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 25, 257 , 19);
} else {
$pdf->Image('../../imgfirma/' . $firma, 25, 258, 19);
}

  $pdf->SetY(-29);
   $pdf->Cell(6, 4, utf8_decode(''), 0, 0, 'L');
   $pdf->Cell(110, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
      $pdf->SetX(4);
      $pdf->Cell(60, 4, utf8_decode(''), 'B', 'C');
        $pdf->SetY(-24);
        
      $pdf->Cell(49, 3, utf8_decode('Firma de enfermeria'), 0, 0, 'C');
      
      
      
// segunda firma enfermera inicio  
$sql_med_id = "SELECT * FROM enf_quirurgico WHERE fecha='$fechar' and id_atencion = $id_atencion ORDER by id_quir DESC ";

    $result_med_id = $conexion->query($sql_med_id);

    while ($row_med_id = $result_med_id->fetch_assoc()) {
      $id_med2 = $row_med_id['id_usua2'];
    }
    
    if($id_med2!=0){
      
         $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_med2";
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

 if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 95, 259 , 19);
} else {
$pdf->Image('../../imgfirma/' . $firma, 95, 259, 19);
}

    $pdf->SetY(-29);
    $pdf->Cell(74, 4, utf8_decode(''), 0, 0, 'L');
    $pdf->Cell(190, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetX(75);
    $pdf->Cell(60, 4, utf8_decode(''), 'B', 'C');
    $pdf->SetY(-24);
        
      $pdf->Cell(187, 3, utf8_decode('Firma de enfermería'), 0, 0, 'C');
    }else{
        
    }
    
   
      
      
//segunda firma enfermera fin
 if($circulante==null){
          
      }else{
  $pdf->SetY(-53);
      $pdf->SetFont('Arial', 'B', 8);
 if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 75, 257, 15);
} else {
$pdf->Image('../../imgfirma/' . $firma, 75, 257, 15);
}
 
      $pdf->Ln(20);
      $pdf->SetX(65); 
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(190, 4, utf8_decode($prec . '. ' . $appc . ' ' . $apmc), 0, 0, 'L');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->SetX(65);
      $pdf->SetFont('Arial', '', 8);
      //$pdf->Cell(190, 4, utf8_decode($cargpc ), 0, 0, 'L');
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Ln(4);
          $pdf->SetX(65);
          
      $pdf->Cell(190, 4, utf8_decode('Firma de enfermería'), 0, 0, 'L');
      }
      //circulante 2
      if($circulante2==null){
          
      }else{
       $pdf->SetY(-53);
      $pdf->SetFont('Arial', 'B', 8);
 if ($firmac2==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 118, 257, 15);
} else {
$pdf->Image('../../imgfirma/' . $firmac2, 118, 257, 15);
}
 
      $pdf->Ln(20);
      $pdf->SetX(107); 
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(190, 4, utf8_decode($prec2 . '. ' . $appc2 . ' ' . $apmc2), 0, 0, 'L');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
       $pdf->SetX(107);
       $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(190, 4, utf8_decode("-"), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
      $pdf->Ln(4);
          $pdf->SetX(107);
      $pdf->Cell(190, 4, utf8_decode('Firma de enfermería'), 0, 0, 'L');
      
      }
      
      
       //circulante 3
      if($circulante3==null){
          
      }else{
       $pdf->SetY(-53);
      $pdf->SetFont('Arial', 'B', 8);
 if ($firmac3==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 168, 257, 15);
} else {
$pdf->Image('../../imgfirma/' . $firmac3, 168, 257, 15);
}


      $pdf->Ln(20);
      $pdf->SetX(155); 
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(190, 4, utf8_decode($prec3 . '. ' . $appc3 . ' ' . $apmc3), 0, 0, 'L');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
       $pdf->SetX(155);
       $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(190, 4, utf8_decode($cargpc3 . ' ' .'CÉD. PROF. ' . $ced_pc3), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
      $pdf->Ln(4);
          $pdf->SetX(155);
      $pdf->Cell(190, 4, utf8_decode('Firma de enfermera circulante 3'), 0, 0, 'L');
      
      }
     
      
      
      // marcaje final marcaje final marcaje final marcaje final marcaje final final final marcaje marcaje marcaje marcaje marcaje final


if($espizq!=NULL || $espder!=NULL || $nuevo!=NULL ||$nuevo1!=NULL ||$nuevo2!=NULL ||$nuevo3!=NULL ||$nuevo4!=NULL ||$nuevo5!=NULL ||$nuevo6!=NULL ||$nuevo7!=NULL ||$frenteizquierda!=NULL ||$frentederecha!=NULL ||$narizc!=NULL ||$mejderecha!=NULL ||$marf!=NULL ||$mare!=NULL ||$mandiizqui!=NULL ||$mandiderr!=NULL ||$mandicentroo!=NULL ||$cvi!=NULL ||$mard!=NULL ||$homi!=NULL ||$hombrod!=NULL ||$pecti!=NULL ||$pectd!=NULL ||$peci!=NULL ||$marc!=NULL ||$brazci!=NULL ||$cconder!=NULL ||$brazi!=NULL ||$annbraz!=NULL ||$marg!=NULL ||$derbraz!=NULL ||$muñei!=NULL ||$muñecad!=NULL ||$palmai!=NULL ||$palmad!=NULL ||$ddi!=NULL ||$ddoderu!=NULL ||$ddidos!=NULL ||$dedodos!=NULL ||$dditres!=NULL ||$dedotres!=NULL ||$dedocuatro!=NULL ||$ddicuatro!=NULL ||$ddicinco!=NULL ||$dedocincoo!=NULL ||$iabdomen!=NULL ||$marb!=NULL ||$inglei!=NULL ||$mara!=NULL ||$musloi!=NULL ||$muslod!=NULL ||$rodd!=NULL ||$rodi!=NULL ||$tod!=NULL ||$toi!=NULL ||$pied!=NULL ||$pie!=NULL || $coxis!=NULL || $plantapiea!=NULL || $plantapieader!=NULL || $tobilloatd!=NULL ||$tobilloati!=NULL ||$ptiatras!=NULL ||$ptdatras!=NULL ||$pierespaldad!=NULL ||$pierespaldai!=NULL ||$musloatrasiz!=NULL ||$musloatrasder!=NULL ||$dorsalder!=NULL ||$dorsaliz!=NULL ||$munecaatrasiz!=NULL ||$munecaatrasder!=NULL ||$antebdesp!=NULL ||$antebiesp!=NULL ||$casicodoi!=NULL ||$casicododer!=NULL ||$brazaltder!=NULL ||$brazalti!=NULL ||$glutiz!=NULL ||$glutder!=NULL ||$cinturader!=NULL ||$cinturaiz!=NULL ||$marh!=NULL ||$costilliz!=NULL ||$costillder!=NULL ||$espaldaarribader!=NULL ||$espaldarribaiz!=NULL ||$espaldaalta!=NULL ||$cuellatrasb!=NULL ||$cuellatrasmedio!=NULL ||$cabedorsalm!=NULL ||$cabealtaizqu!=NULL || $cabezaaltader!=NULL){
    $pdf->Ln(11);
    $pdf->SetFont('Arial', 'B',8);
   
$pdf->Cell(190, 175, utf8_decode('VALORACIÓN DE LA PIEL FINAL'), 0, 0, 'C');
$pdf->Ln(98);
$pdf->Cell(20,5, utf8_decode(''),0,0,'L');
$pdf->Cell(100,10, $pdf->Image('../../img/cuerpof.jpg', $pdf->GetX(), $pdf->GetY(),45),0);

//IMAGEN TRASERA IMAGEN TARSERA TRASERA TRASEA TRASERA TRASERA TRASERA TRASERA TRASERA TRASERA TRASERA TRASERA TRASEA
$pdf->Cell(15,5, utf8_decode(''),0,0,'L');
$pdf->Cell(100,10, $pdf->Image('../../img/cuerpot.jpg', $pdf->GetX(), $pdf->GetY(),41),0);
//$pdf->Image('../../img/cuerpof.jpg' , 79, 103, 56);
if($espizq!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(205);
$pdf->SetX(13);
$pdf->Cell(25, 6, utf8_decode($espizq), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 13, 209, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(183);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($espder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(205);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($espder), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 58, 209, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(183);
$pdf->SetX(101);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($nuevo1!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(173);
$pdf->SetX(56);
$pdf->Cell(25, 6, utf8_decode($nuevo1), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 57, 176.6, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142);
$pdf->SetX(99);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}


if($nuevo2!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(173);
$pdf->SetX(19);
$pdf->Cell(25, 6, utf8_decode($nuevo2), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 20, 176.7, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142);
$pdf->SetX(89);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($nuevo3!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(167.7);
$pdf->SetX(10);
$pdf->Cell(25, 6, utf8_decode($nuevo3), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 171.5, 38, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(138);
$pdf->SetX(89);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($nuevo4!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(167.4);
$pdf->SetX(28.3);
$pdf->Cell(25, 6, utf8_decode($nuevo4), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 20, 170.8, 33, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(135.5);
$pdf->SetX(94.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($nuevo5!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(167);
$pdf->SetX(56.5);
$pdf->Cell(25, 6, utf8_decode($nuevo5), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 57, 170.8, 37, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(138.5);
$pdf->SetX(99);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}


if($nuevo6!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(164);
$pdf->SetX(56.2);
$pdf->Cell(25, 6, utf8_decode($nuevo6), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 57, 168, 20, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(132);
$pdf->SetX(99);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($nuevo7!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(165);
$pdf->SetX(28);
$pdf->Cell(25, 6, utf8_decode($nuevo7), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 32, 169, 20, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(130);
$pdf->SetX(95);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}


if($nuevo8!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(164);
$pdf->SetX(23.5);
$pdf->Cell(25, 6, utf8_decode($nuevo8), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 28, 168, 20, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(132);
$pdf->SetX(89);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}


if($frenteizquierda!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(140);
$pdf->SetX(16);
$pdf->Cell(25, 6, utf8_decode($frenteizquierda), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 16.5, 144.5, 35, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(141.4);
$pdf->SetX(39);
//$pdf->Cell(25, 6, utf8_decode('x'), 0,0, 'C');
}

if($frentederecha!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(140);
$pdf->SetX(53);
$pdf->Cell(25, 6, utf8_decode($frentederecha), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 53.5, 144.5, 35, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(103.2);
$pdf->SetX(96);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($narizc!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(143);
$pdf->SetX(52);
$pdf->Cell(25, 6, utf8_decode($narizc), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 52.5, 147, 35, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(105.7);
$pdf->SetX(94.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mejderecha!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(145);
$pdf->SetX(54);
$pdf->Cell(25, 6, utf8_decode($mejderecha), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 54.5, 148.8, 33.5, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(108.4);
$pdf->SetX(97.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($marf!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(144);
$pdf->SetX(16);
$pdf->Cell(25, 6, utf8_decode($marf), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 16, 148, 35, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(108.5);
$pdf->SetX(92.1);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mare!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(146.6);
$pdf->SetX(16);
$pdf->Cell(25, 6, utf8_decode($mare), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 16, 150.5, 37, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(110.4);
$pdf->SetX(94.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mandiizqui!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(148.3);
$pdf->SetX(16);
$pdf->Cell(25, 6, utf8_decode($mandiizqui), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 16, 151.9, 35.5, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(112.4);
$pdf->SetX(92.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mandiderr!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(147.5);
$pdf->SetX(53.5);
$pdf->Cell(25, 6, utf8_decode($mandiderr), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 54, 151.5, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(111.4);
$pdf->SetX(97.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mandicentroo!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(149.5);
$pdf->SetX(52);
$pdf->Cell(25, 6, utf8_decode($mandicentroo), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 52.5, 153.2, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(113.6);
$pdf->SetX(94.9);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cvi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(152.5);
$pdf->SetX(14.5);
$pdf->Cell(25, 6, utf8_decode($cvi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 15, 156.5, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(118.3);
$pdf->SetX(90.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mard!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(152.5);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($mard), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 56, 156.5, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(118.3);
$pdf->SetX(98.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($homi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(155);
$pdf->SetX(14.5);
$pdf->Cell(25, 6, utf8_decode($homi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 15, 159, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(122.1);
$pdf->SetX(81.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($hombrod!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(155);
$pdf->SetX(60.8);
$pdf->Cell(25, 6, utf8_decode($hombrod), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 61.5, 159, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(122.1);
$pdf->SetX(107.3);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($pecti!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(158);
$pdf->SetX(14.5);
$pdf->Cell(25, 6, utf8_decode($pecti), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 15, 162, 33, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(125.1);
$pdf->SetX(89.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($pectd!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(158);
$pdf->SetX(57);
$pdf->Cell(25, 6, utf8_decode($pectd), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 56, 162, 33, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(125.1);
$pdf->SetX(100.2);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($peci!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(161);
$pdf->SetX(10);
$pdf->Cell(25, 6, utf8_decode($peci), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 165.5, 41, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(128);
$pdf->SetX(92.9);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($marc!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(161);
$pdf->SetX(70);
$pdf->Cell(25, 6, utf8_decode($marc), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 53.5, 165.5, 41, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(128);
$pdf->SetX(97.6);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($brazci!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(160.2);
$pdf->SetX(10);
$pdf->Cell(25, 6, utf8_decode($brazci), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 164.5, 33, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(130);
$pdf->SetX(80.9);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cconder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(160.5);
$pdf->SetX(62.5);
$pdf->Cell(25, 6, utf8_decode($cconder), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 63, 164.5, 33, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(130);
$pdf->SetX(109.1);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($brazi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(165);
$pdf->SetX(10);
$pdf->Cell(25, 6, utf8_decode($brazi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 169.5, 31, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(133);
$pdf->SetX(80);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($annbraz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(165);
$pdf->SetX(70);
$pdf->Cell(25, 6, utf8_decode($annbraz), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 65, 169, 29, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(133);
$pdf->SetX(110);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($marg!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(170.5);
$pdf->SetX(9.5);
$pdf->Cell(25, 6, utf8_decode($marg), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 174.5, 29, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142.1);
$pdf->SetX(76);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($derbraz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(170);
$pdf->SetX(55);
$pdf->Cell(25, 6, utf8_decode($derbraz), 0,0, 'C');
$pdf->Image('../registro_clinico/linea.png', 65, 174, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142.1);
$pdf->SetX(113.1);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($muñei!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(174.4);
$pdf->SetX(9.5);
$pdf->Cell(25, 6, utf8_decode($muñei), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 10, 178.5, 27, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(145.6);
$pdf->SetX(74.9);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($muñecad!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(174.4);
$pdf->SetX(68);
$pdf->Cell(25, 6, utf8_decode($muñecad), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 68.5, 178.5, 27, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(145.6);
$pdf->SetX(114.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($palmai!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(179.2);
$pdf->SetX(4);
$pdf->Cell(25, 6, utf8_decode($palmai), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 5, 183, 30.2, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(148);
$pdf->SetX(73.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($palmad!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(179.2);
$pdf->SetX(69.5);
$pdf->Cell(25, 6, utf8_decode($palmad), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 70.2, 183, 30.2, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(148);
$pdf->SetX(115.3);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($ddi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(177.4);
$pdf->SetX(4.5);
$pdf->Cell(25, 6, utf8_decode($ddi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 5, 181.1, 27, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(149.7);
$pdf->SetX(67.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($ddoderu!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(177.3);
$pdf->SetX(72.5);
$pdf->Cell(25, 6, utf8_decode($ddoderu), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 73.5, 181.1, 30.2, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(149.7);
$pdf->SetX(121.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($ddidos!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(181);
$pdf->SetX(2);
$pdf->Cell(25, 6, utf8_decode($ddidos), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 2.5, 185.1, 30.2, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(153);
$pdf->SetX(69.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dedodos!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(181.7);
$pdf->SetX(72);
$pdf->Cell(25, 6, utf8_decode($dedodos), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 72.8, 185.5, 19, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(153);
$pdf->SetX(119.6);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dditres!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(183.2);
$pdf->SetX(1.7);
$pdf->Cell(25, 6, utf8_decode($dditres), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 2.5, 186.9, 30.9, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(155);
$pdf->SetX(70.9);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dedotres!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(183.7);
$pdf->SetX(65.5);
$pdf->Cell(25, 6, utf8_decode($dedotres), 0,0, 'C');
$pdf->Image('../registro_clinico/linea.png', 72, 187.4, 19, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(155);
$pdf->SetX(118.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dedocuatro!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(183.7);
$pdf->SetX(54);
$pdf->Cell(25, 6, utf8_decode($dedocuatro), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 55.1, 187.3, 16, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(156.5);
$pdf->SetX(117.3);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($ddicuatro!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(183.7);
$pdf->SetX(34);
$pdf->Cell(25, 6, utf8_decode($ddicuatro), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 34.1, 187.3, 20, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(156.5);
$pdf->SetX(72);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($ddicinco!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(181);
$pdf->SetX(35.5);
$pdf->Cell(25, 6, utf8_decode($ddicinco), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 36.1, 184.9, 20, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(155.3);
$pdf->SetX(73.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dedocincoo!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(180.7);
$pdf->SetX(52);
$pdf->Cell(25, 6, utf8_decode($dedocincoo), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 53, 184.6, 16, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(155.3);
$pdf->SetX(115.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($iabdomen!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(171.9);
$pdf->SetX(24.8);
$pdf->Cell(25, 6, utf8_decode($iabdomen), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 25, 175.6, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(140.1);
$pdf->SetX(95);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($marb!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(177);
$pdf->SetX(53.5);
$pdf->Cell(25, 6, utf8_decode($marb), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 54.5, 180.6, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(149);
$pdf->SetX(97.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}


if($inglei!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(177);
$pdf->SetX(26.8);
$pdf->Cell(25, 6, utf8_decode($inglei), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 23, 180.6, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(149);
$pdf->SetX(93);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($mara!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(180);
$pdf->SetX(29);
$pdf->Cell(25, 6, utf8_decode($mara), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 25, 183.5, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(152.3);
$pdf->SetX(94.7);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($musloi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(189.5);
$pdf->SetX(13);
$pdf->Cell(25, 6, utf8_decode($musloi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 13, 194, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(162.1);
$pdf->SetX(87.8);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($muslod!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(189);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($muslod), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 58, 194, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(162.1);
$pdf->SetX(102.2);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($rodd!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(196);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($rodd), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 58, 200, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(172.1);
$pdf->SetX(102.2);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($rodi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(196);
$pdf->SetX(13);
$pdf->Cell(25, 6, utf8_decode($rodi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 13, 200, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(172.1);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($tod!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(212);
$pdf->SetX(13);
$pdf->Cell(25, 6, utf8_decode($tod), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 13, 216, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(192.1);
$pdf->SetX(89);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($toi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(212);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($toi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 58, 216, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(192.1);
$pdf->SetX(100);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($pied!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(216);
$pdf->SetX(58);
$pdf->Cell(25, 6, utf8_decode($pied), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 58, 220, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(197);
$pdf->SetX(102);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($pie!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(216);
$pdf->SetX(13);
$pdf->Cell(25, 6, utf8_decode($pie), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 13, 220, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(197);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

//$pdf->Ln(110);

//terminomarcaje frontal

//$pdf->Cell(189, 6, utf8_decode(''), 0,0, 'C');

//$pdf->Image('../../img/cuerpot.jpg' , 79, 42, 56);



if($coxis!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(176.3);
$pdf->SetX(135);
$pdf->Cell(25, 6, utf8_decode($coxis), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 135.6, 180, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(88);
$pdf->SetX(94);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

//marcaje trasero
if($plantapiea!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(215);
$pdf->SetX(128);
$pdf->Cell(25, 6, utf8_decode($plantapiea), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 129, 219, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142);
$pdf->SetX(86.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($plantapieader!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(215);
$pdf->SetX(176);
$pdf->Cell(25, 6, utf8_decode($plantapieader), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 170, 219, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(142);
$pdf->SetX(101);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($tobilloatd!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(210);
$pdf->SetX(176);
$pdf->Cell(25, 6, utf8_decode($tobilloatd), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 170, 214, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(137);
$pdf->SetX(101);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($tobilloati!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(210);
$pdf->SetX(128);
$pdf->Cell(25, 6, utf8_decode($tobilloati), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 129, 214, 31, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(137);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($ptiatras!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(203);
$pdf->SetX(128.5);
$pdf->Cell(25, 6, utf8_decode($ptiatras), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 129, 207, 31, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(126);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($ptdatras!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(203);
$pdf->SetX(176);
$pdf->Cell(25, 6, utf8_decode($ptdatras), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 170, 207, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(126);
$pdf->SetX(100.6);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($pierespaldad!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(196);
$pdf->SetX(176);
$pdf->Cell(25, 6, utf8_decode($pierespaldad), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 170, 200, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(114);
$pdf->SetX(100.6);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($pierespaldai!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(196);
$pdf->SetX(129);
$pdf->Cell(25, 6, utf8_decode($pierespaldai), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 130, 200, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(114);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($musloatrasiz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(187);
$pdf->SetX(129);
$pdf->Cell(25, 6, utf8_decode($musloatrasiz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 130, 191, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(107);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($musloatrasder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(187);
$pdf->SetX(176);
$pdf->Cell(25, 6, utf8_decode($musloatrasder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 170, 191, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(107);
$pdf->SetX(100.3);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
} 

if($dorsalder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(177.5);
$pdf->SetX(183.6);
$pdf->Cell(25, 6, utf8_decode($dorsalder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 181.5, 181.4, 26, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(91);
$pdf->SetX(117.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($dorsaliz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(177.7);
$pdf->SetX(117);
$pdf->Cell(25, 6, utf8_decode($dorsaliz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 118, 181.4, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(91);
$pdf->SetX(70);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($munecaatrasiz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(174.2);
$pdf->SetX(119);
$pdf->Cell(25, 6, utf8_decode($munecaatrasiz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 119.6, 177.9, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(87);
$pdf->SetX(72);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($munecaatrasder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(174.2);
$pdf->SetX(183.5);
$pdf->Cell(25, 6, utf8_decode($munecaatrasder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 179.6, 177.9, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(87);
$pdf->SetX(115);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($antebdesp!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(171.4);
$pdf->SetX(183);
$pdf->Cell(25, 6, utf8_decode($antebdesp), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 179, 175, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(83);
$pdf->SetX(113);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($antebiesp!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(171);
$pdf->SetX(120);
$pdf->Cell(25, 6, utf8_decode($antebiesp), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 120, 175, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(83);
$pdf->SetX(74);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($casicodoi!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(167);
$pdf->SetX(120.5);
$pdf->Cell(25, 6, utf8_decode($casicodoi), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 121, 171.1, 31, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(77);
$pdf->SetX(76);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($casicododer!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(166);
$pdf->SetX(182);
$pdf->Cell(25, 6, utf8_decode($casicododer), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 177, 170, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(77);
$pdf->SetX(111);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($brazaltder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(162);
$pdf->SetX(179.5);
$pdf->Cell(25, 6, utf8_decode($brazaltder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 176, 166.1, 28, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(71);
$pdf->SetX(110);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($brazalti!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(162);
$pdf->SetX(120);
$pdf->Cell(25, 6, utf8_decode($brazalti), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 120, 166, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(71);
$pdf->SetX(77);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($glutiz!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(179.6);
$pdf->SetX(130);
$pdf->Cell(25, 6, utf8_decode($glutiz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 131, 183.3, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(94.5);
$pdf->SetX(90);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($glutder!=NULL){
$pdf->SetFont('Arial', 'B',6);
$pdf->SetY(179.6);
$pdf->SetX(174);
$pdf->Cell(25, 6, utf8_decode($glutder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 168, 183.3, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(94.5);
$pdf->SetX(97.2);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cinturader!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(169.4);
$pdf->SetX(174);
$pdf->Cell(25, 6, utf8_decode($cinturader), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 168, 173, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(84.5);
$pdf->SetX(96.6);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cinturaiz!=NULL){
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(169.4);
$pdf->SetX(131);
$pdf->Cell(25, 6, utf8_decode($cinturaiz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 132, 173, 30, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(84.5);
$pdf->SetX(91);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($marh!=NULL){
  $pdf->SetFont('Arial', 'B',5);
$pdf->SetY(165);
$pdf->SetX(133.5);
$pdf->Cell(25, 6, utf8_decode($marh), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 134, 169, 31, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(80);
$pdf->SetX(94);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($costilliz!=NULL){
  $pdf->SetFont('Arial', 'B',5);
$pdf->SetY(164.2);
$pdf->SetX(127.7);
$pdf->Cell(25, 6, utf8_decode($costilliz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 128, 168.1, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(73);
$pdf->SetX(90);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($costillder!=NULL){
  $pdf->SetFont('Arial', 'B',5);
$pdf->SetY(164.2);
$pdf->SetX(177.7);
$pdf->Cell(25, 6, utf8_decode($costillder), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 168, 168.1, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(73);
$pdf->SetX(97);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($espaldaarribader!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(157);
$pdf->SetX(177);
$pdf->Cell(25, 6, utf8_decode($espaldaarribader), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 168, 161, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(64);
$pdf->SetX(100);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($espaldarribaiz!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(156.9);
$pdf->SetX(126);
$pdf->Cell(25, 6, utf8_decode($espaldarribaiz), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 127, 161, 34, 0.1);

$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(64);
$pdf->SetX(88);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($espaldaalta!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(152);
$pdf->SetX(175);
$pdf->Cell(25, 6, utf8_decode($espaldaalta), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 165, 155.8, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(57);
$pdf->SetX(93.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cuellatrasb!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(148.5);
$pdf->SetX(175);
$pdf->Cell(25, 6, utf8_decode($cuellatrasb), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 165, 152.6, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(52);
$pdf->SetX(93.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cuellatrasmedio!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(146.4);
$pdf->SetX(175);
$pdf->Cell(25, 6, utf8_decode($cuellatrasmedio), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 165, 150.1, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(48.5);
$pdf->SetX(93.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cabedorsalm!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(144);
$pdf->SetX(175);
$pdf->Cell(25, 6, utf8_decode($cabedorsalm), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 165, 148, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(45.5);
$pdf->SetX(93.5);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cabealtaizqu!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(142.1);
$pdf->SetX(129);
$pdf->Cell(25, 6, utf8_decode($cabealtaizqu), 0,0, 'L');
$pdf->Image('../registro_clinico/linea.png', 129, 146, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(42.5);
$pdf->SetX(91);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
}

if($cabezaaltader!=NULL){
  $pdf->SetFont('Arial', 'B',6);
$pdf->SetY(142.1);
$pdf->SetX(177);
$pdf->Cell(25, 6, utf8_decode($cabezaaltader), 0,0, 'R');
$pdf->Image('../registro_clinico/linea.png', 167, 146, 34, 0.1);
$pdf->SetFont('Arial', 'B',5);
$pdf->SetY(42.5);
$pdf->SetX(96);
//$pdf->Cell(25, 6, utf8_decode('X'), 0,0, 'C');
  
}

$pdf->Ln(192); 
}else{
  $pdf->Ln(11);  
}
    
$pdf->AddPage();



$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 180);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(3);
$pdf->SetX(55);

$pdf->Cell(107, 5, utf8_decode('HOJA DE CONSUMO QUIRÚRGICO'), 0, 0, 'C');


$fecha_quir = date("d/m/Y H:i a");
$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell(25, 5, utf8_decode('Fecha de impresión: '.$fecha_quir), 0, 1, 'L');

$pdf->SetFont('Arial', '', 7);
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(9, 5, 'Sala: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(22, 5, utf8_decode($salac) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(89, 5, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$datei=date_create($fecha_ing);
$pdf->Cell(28, 5, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 5, date_format($datei,'d/m/Y H:i a'), 'B', 0, 'C');
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

$pdf->Ln(6);

$sql_edo = "SELECT edo_salud,alergias from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud DESC LIMIT 1";
$result_edo = $conexion->query($sql_edo);                                                                                    while ($row_edo = $result_edo->fetch_assoc()) {
  $edo_salud=$row_edo['edo_salud'];
  $alergias=$row_edo['alergias'];
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(23,3, utf8_decode('Tipo de sangre: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23,3, utf8_decode($tip_san),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17,3, utf8_decode('Habitación: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8,3, utf8_decode($num_cama),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 3, 'Tiempo estancia: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(12, 3, $estancia . ' dias', 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18,3, utf8_decode('Expediente: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(7,3, utf8_decode($folio),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25,3, utf8_decode('Estado de salud: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(37,3, utf8_decode($edo_salud),'B','L');
$pdf->Ln(3);


$sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha DESC limit 1";
  $result_aseg = $conexion->query($sql_aseg);
  while ($row_aseg = $result_aseg->fetch_assoc()) {
 $aseg= $row_aseg['aseg'];
}                      
$pdf->SetFont('Arial', 'B', 8);                                               
$pdf->Cell(20,5, utf8_decode('Aseguradora: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60,5, utf8_decode($aseg),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15,5, utf8_decode('Alergias: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100,5, utf8_decode($alergias),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(9);

$pdf->Cell(195,5, utf8_decode('MEDICAMENTOS'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30,4, utf8_decode('Fecha'),1,0,'C');
$pdf->Cell(105,4, utf8_decode('Medicamentos'),1,0,'C');
$pdf->Cell(24,4, utf8_decode('Dosis'),1,0,'C');
$pdf->Cell(23,4, utf8_decode('Via'),1,0,'C');

$pdf->Cell(13,4, utf8_decode('Cantidad'),1,0,'C');
$cis = $conexion->query("select * from medica_enf where id_atencion=$id_atencion and material ='No' and fecha_mat = '$fechar' and material_id<>'1124' ORDER BY id_med_reg") or die($conexion->error);
while ($cis_s = $cis->fetch_assoc()) {
  $pdf->SetFont('Arial', '', 8);
$pdf->Ln(4);
$fm=$cis_s['fecha_mat'];
$hm=$cis_s['hora_mat'];
$fcis=date_create($fm);
$pdf->Cell(30,4, date_format($fcis,"d-m-Y").' '. $hm.' hrs',1,0,'C');
$pdf->Cell(105,4, utf8_decode($cis_s['medicam_mat']),1,0,'C');
$pdf->Cell(24,4, utf8_decode($cis_s['dosis_mat'] . ' ' .$cis_s['unimed']),1,0,'C');
$pdf->Cell(23,4, utf8_decode($cis_s['via_mat']),1,0,'C');

$pdf->Cell(13,4, utf8_decode($cis_s['cantidad']),1,0,'C');
}

$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(8);
$pdf->Cell(195,5, utf8_decode('MATERIALES'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(35,4, utf8_decode('Fecha'),1,0,'C');
$pdf->Cell(128,4, utf8_decode('Medicamentos'),1,0,'C');
$pdf->Cell(32,4, utf8_decode('Cantidad ceye'),1,0,'C');
$cis = $conexion->query("select * from medica_enf where id_atencion=$id_atencion and material ='Si' and fecha_mat = '$fechar' ORDER BY id_med_reg") or die($conexion->error);
while ($cis_s = $cis->fetch_assoc()) {
  $pdf->SetFont('Arial', '', 8);
$pdf->Ln(4);
$fn=$cis_s['fecha_mat'];
$fcis=date_create($fn);
$pdf->Cell(35,4, date_format($fcis,"d-m-Y"),1,0,'C');
$pdf->Cell(128,4, utf8_decode($cis_s['medicam_mat']),1,0,'C');

$pdf->Cell(32,4, utf8_decode($cis_s['cantidad']),1,0,'C');
}

$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(8);
$pdf->Cell(195,5, utf8_decode('EQUIPOS/SERVICIOS'),1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(35,4, utf8_decode('Fecha'),1,0,'C');
$pdf->Cell(128,4, utf8_decode('Equipo'),1,0,'C');
$pdf->Cell(32,4, utf8_decode('Cantidad horas'),1,0,'C');
$cis = $conexion->query("select * from equipos_ceye where id_atencion=$id_atencion and fecha_registro = '$fechar' ORDER BY id_equipceye") or die($conexion->error);
while ($cis_s = $cis->fetch_assoc()) {
  $pdf->SetFont('Arial', '', 8);
$pdf->Ln(4);
$fn=$cis_s['fecha'];
$fcis=date_create($fn);
$pdf->Cell(35,4, date_format($fcis,"d-m-Y"),1,0,'C');
$pdf->Cell(128,4, utf8_decode($cis_s['nombre']),1,0,'C');
$pdf->Cell(32,4, utf8_decode($cis_s['tiempo']),1,0,'C');

}

$pdf->Output();
    
    
}

