<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_med = @$_GET['id_med'];
$id_pernest = @$_GET['id_peranest'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

$sql_pre = "SELECT * FROM dat_peri_anest  where id_atencion = $id_atencion";
$result_pre = $conexion->query($sql_pre);

while ($row_pre = $result_pre->fetch_assoc()) {
  $id_peranest = $row_pre['id_peranest'];
}

if(isset($id_peranest)){
    $id_peranest = $id_peranest;
  }else{
    $id_peranest ='sin doc';
  }

if($id_peranest=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE NOTA PRE-ANESTÉSICA PARA ESTE PACIENTE", 
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
    $this->Cell(0, 10, utf8_decode('MAC-7.01'), 0, 1, 'R');
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

//consulta nota pre anestesica
$sql_pre = "SELECT * FROM dat_peri_anest  where id_peranest = $id_pernest";
$result_pre = $conexion->query($sql_pre);

while ($row_pre = $result_pre->fetch_assoc()) {
  $diagpre = $row_pre['diagpre'];
  $area = $row_pre['area'];
  $tipo_intervencion = $row_pre['urg'];  
  $inter = $row_pre['inter'];  
  $proc_prog = $row_pre['proc_prog'];  
  $med_proc = $row_pre['med_proc']; 
  $anest = $row_pre['anest']; 
  $inmun = $row_pre['inmun']; 
  $tab = $row_pre['tab'];  
  $alc = $row_pre['alc'];

  $trans = $row_pre['trans'];  
  $alerg = $row_pre['alerg'];  
  $toxi = $row_pre['toxi'];  
  $gastro = $row_pre['gastro'];  
  $neuro = $row_pre['neuro'];  
  $neumo = $row_pre['neumo'];  
  $ren = $row_pre['ren'];  
  $card = $row_pre['card'];  
  $tend = $row_pre['tend'];
  $reu = $row_pre['reu'];  
  $neo = $row_pre['neo'];  
  $herma = $row_pre['herma'];  
  $trau = $row_pre['trau'];  
  $psi = $row_pre['psi'];  
  $quir = $row_pre['quir'];  
  $aneste = $row_pre['aneste'];  
  $gin = $row_pre['gin'];  
  $ped = $row_pre['ped'];  
  $valant = $row_pre['valant'];  
  $cons = $row_pre['cons'];  
  $pad_act = $row_pre['pad_act'];  
  $med_act = $row_pre['med_act'];  
  $ayuno = $row_pre['ayuno'];  
  $otro = $row_pre['otro'];  
  $esp = $row_pre['esp'];  
  $ta_sisto = $row_pre['ta_sisto'];  
  $ta_diasto = $row_pre['ta_diasto'];    
  $fc = $row_pre['fc'];  
  $fr = $row_pre['fr']; 

  $tempe = $row_pre['tempe'];  
  $pes = $row_pre['pes']; 
  $tall = $row_pre['tall'];  
  $imc = $row_pre['imc']; 
  $malla = $row_pre['malla'];  
  $patil = $row_pre['patil']; 
  $bell = $row_pre['bell'];  
  $dist = $row_pre['dist']; 
  $buco = $row_pre['buco'];  
  $obserb = $row_pre['obserb']; 
  $fecha = $row_pre['fecha'];
  $fecha_nota = $row_pre['fecha_nota'];
  $hb = $row_pre['hb']; 
  $hto = $row_pre['hto'];  
  $gb = $row_pre['gb']; 
  $gr = $row_pre['gr'];  
  $plaq = $row_pre['plaq']; 
  $tp = $row_pre['tp'];  
  $tpt = $row_pre['tpt']; 
  $inr = $row_pre['inr'];  
  $gluc = $row_pre['gluc'];
  $cr = $row_pre['cr']; 
  $bun = $row_pre['bun'];  
  $urea = $row_pre['urea'];
  $es = $row_pre['es']; 
  $otros = $row_pre['otros'];  

  $gab = $row_pre['gab']; 
  $valcard = $row_pre['valcard']; 
  $condfis = $row_pre['condfis'];  
  $tipanest = $row_pre['tipanest'];
  $indpre = $row_pre['indpre'];
  $obs = $row_pre['obs'];
  $nomanest = $row_pre['nomanest'];
  
  
  $hepatico = $row_pre['hepatico']; 
  $aerea = $row_pre['aerea']; 
  $tromboe = $row_pre['tromboe'];  
  $quirur = $row_pre['quirur'];
  $nauv = $row_pre['nauv'];
  $otr = $row_pre['otr'];
  $ingresos = $row_pre['ingresos'];
  
    $ingresosc = $row_pre['ingresosc'];
  $egresos = $row_pre['egresos'];
  $egresosc = $row_pre['egresosc'];

}
//termino nota pre anestesica

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
$pdf->SetAutoPageBreak(true,20);
$pdf->SetTextColor(43, 45, 127);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(50);
$pdf->Cell(120, 5, utf8_decode('VALORACIÓN PRE-ANESTÉSICA'), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date_create($fecha_nota);
$pdf->Cell(35, 5, 'Fecha: ' . date_format($fecha_actual,"d/m/Y H:i a"), 0, 1, 'R');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 50, 207, 50);
$pdf->Line(8, 50, 8, 280);
$pdf->Line(207, 50, 207, 280);
$pdf->Line(8, 280, 207, 280);

$pdf->Line(83, 95, 203, 95);
$pdf->Line(83, 95, 83, 170);
$pdf->Line(203, 95, 203, 170);
$pdf->Line(83, 170, 203, 170);

$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 5, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 5, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 5, date_format($date,'d/m/Y H:i a'), 'B', 0, 'C');
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
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 4, utf8_decode('Tipo de cirugía: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(63, 4, utf8_decode($tipo_intervencion), 1,'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, utf8_decode('Interrogatorio: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(65, 4, utf8_decode($inter), 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 7.8);
$pdf->Cell(37, 3, utf8_decode('Diagnóstico preoperatorio: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($diagpre), 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 3, utf8_decode('Cirugía programada: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($proc_prog), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 3, utf8_decode('Medico responsable: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(63, 3, utf8_decode($med_proc), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Anestesiólogo: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(65, 3, utf8_decode($anest), 1, 'L');

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 3, utf8_decode('Antecedentes no patológicos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode('Si / No'), 1,0, 'C');

$pdf->Cell(120, 3, utf8_decode('Valoración de antecedentes'), 1,0, 'C');
$pdf->Ln(3);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Inmunizaciones'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($inmun), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Tabaquismo'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($tab), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Alcoholismo'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($alc), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Transfusiones'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($trans), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Alergias'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($alerg), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Toxicomanias'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($toxi), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 3, utf8_decode('Antecedentes patológicos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode('SI / NO'), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Gastro/hepáticos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($gastro), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Neurológicos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($neuro), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Neumológicos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($neumo), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Renales'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($ren), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Cardiológicos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($card), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Endócrinos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($tend), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Reumáticos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($reu), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Neoplásicos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($neo), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Hematológicos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($herma), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Traumáticos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($trau), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Psiquiátricos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($psi), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Quirúrgicos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($quir), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Anestésicos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($aneste), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Gineco-obstétricos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($gin), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Pediátricos'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($ped), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 3, utf8_decode('Estado neurológico'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode('SI / NO'), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Consciente'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($cons), 1,0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 3, utf8_decode('Otro'), 1,0, 'C');
$pdf->Cell(15, 3, utf8_decode($otro), 1,0, 'C');

$pdf->SetY(95);
$pdf->SetX(83);


$pdf->MultiCell(120, 5, utf8_decode($valant),0, 'J');

$pdf->SetX(10);
$pdf->SetY(172);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 3, utf8_decode('Padecimiento actual:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($pad_act), 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 3, utf8_decode('Medicación actual:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($med_act), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 4, utf8_decode('Ayuno: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(63, 4, utf8_decode($ayuno), 1,'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, utf8_decode('Especificar (otro):'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(65, 4, utf8_decode($esp), 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 3, utf8_decode('SIGNOS VITALES'), 0,0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(37, 3, utf8_decode('Presión arterial: ' .$ta_sisto.'/'.$ta_diasto), 1, 'L');
$pdf->Cell(36, 3, utf8_decode('Frecuencia cardiaca: ' .$fc), 1, 'L');
$pdf->Cell(36, 3, utf8_decode('Frecuencia respiratoria: ' .$fr), 1, 'L');
$pdf->Cell(26, 3, utf8_decode('Temperatura: ' .$tempe), 1, 'L');
$pdf->Cell(35, 3, utf8_decode('Peso: ' .$pes), 1, 'L');
$pdf->Cell(25, 3, utf8_decode('Talla: ' .$tall), 1, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 3, utf8_decode('Vía área'), 1,0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(36, 3, utf8_decode('Mellampati: ' .$malla), 1,0, 'L');
$pdf->Cell(36, 3, utf8_decode('Patil aldreti: ' .$patil), 1,0, 'L');
$pdf->Cell(26, 3, utf8_decode('Bellhouse-dore: ' .$bell), 1,0, 'L');
$pdf->Cell(35, 3, utf8_decode('Dist esternomentoniana: ' .$dist), 1,0, 'L');
$pdf->Cell(25, 3, utf8_decode('Buco-dental: ' .$buco), 1,0, 'L');
$pdf->Ln(3);
$pdf->Cell(195, 3, utf8_decode('Observaciones: ' .$obserb), 1,0, 'L');

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190, 3, utf8_decode('Laboratorio'), 0, 'L');
$pdf->Ln(3);
$pdf->Cell(37, 3, utf8_decode('Fecha' .' : '.$fecha), 1,0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(72, 3, utf8_decode('Biometría: ' .$hb), 1,0, 'L');
$pdf->Cell(86, 3, utf8_decode('Química: ' .$hto), 1,0, 'L');
$pdf->Ln(3);
$pdf->Cell(65, 3, utf8_decode('Pruebas de funcionamiento: ' .$gb), 1,0, 'L');
$pdf->Cell(65, 3, utf8_decode('Tiempos de coagulación: ' .$gr), 1,0, 'L');
$pdf->Cell(65, 3, utf8_decode('Tiempos de procesado: ' .$plaq), 1,0, 'L');



$pdf->Ln(4);

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 3, utf8_decode('Gabinete:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($gab), 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 7.8);
$pdf->Cell(37, 3, utf8_decode('Valoración cardiovascular:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($valcard), 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 3, utf8_decode('Condición física asa:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($condfis), 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 3, utf8_decode('Tipo anestesia propuesta:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($tipanest), 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 3, utf8_decode('Indicación preanestésica:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($indpre), 1, 'L');


$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 3, utf8_decode('Observaciones:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(158, 3, utf8_decode($obs), 1, 'L');

$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(39, 3, utf8_decode('Hepatico: ' . $hepatico), 1, 'L');
$pdf->Cell(39, 3, utf8_decode('Vía aérea: ' . $aerea), 1, 'L');
$pdf->Cell(39, 3, utf8_decode('Tromboembolica: ' . $tromboe), 1, 'L');
$pdf->Cell(39, 3, utf8_decode('Quirúrgico: ' . $quirur), 1, 'L');
$pdf->Cell(39, 3, utf8_decode('Nauseas vomito: ' . $nauv), 1, 'L');
$pdf->Ln(3);
$pdf->Cell(195, 3, utf8_decode('Otros riesgos: ' . $otr), 1, 'L');

$pdf->Ln(4);
$pdf->Cell(195, 3, utf8_decode('Soluciones'),0,1, 'C');
$pdf->Cell(78, 3, utf8_decode('Ingresos: ' . $ingresos . ' ' . $ingresosc), 1, 'L');
$pdf->Cell(78, 3, utf8_decode('Egresos: ' . $egresos . ' ' . $egresosc), 1, 'L');

$ba=$ingresosc-$egresosc;

$pdf->Cell(39, 3, utf8_decode('Balance hidrico: ' . $ba), 1, 'L');


$pdf->SetFont('Arial', 'B', 8);
$sql_med_id = "SELECT id_usua FROM dat_peri_anest WHERE id_peranest=$id_pernest";
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
     // $pdf->Image('../../imgfirma/' . $firma, 95, 245, 25);
 if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 253 , 25);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 253 , 25);
}
      $pdf->SetY(267);
      $pdf->Cell(200, 1, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(200, 1, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->Cell(200, 1, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
 $pdf->Output();
}