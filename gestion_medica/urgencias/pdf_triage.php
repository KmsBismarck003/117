<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id = @$_GET['id'];
$tri = @$_GET['tri'];
$id_med = @$_GET['id_med'];
$rec = @$_GET['rec'];
mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id = @$_GET['id'];
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

$sql_triage = "SELECT * FROM triage t,dat_ingreso di where t.id_triage = $tri and di.id_atencion=$id";
$result_triage = $conexion->query($sql_triage);

while ($row_triage = $result_triage->fetch_assoc()) {
  $fecha_t = $row_triage['fecha_t'];
  $urgencia = $row_triage['urgencia'];
  $id_atencion = $row_triage['id_atencion'];
  $p_sistolica = $row_triage['p_sistolica'];
  $p_diastolica = $row_triage['p_diastolica'];
  $f_card = $row_triage['f_card'];
  $f_resp = $row_triage['f_resp'];
  $temp = $row_triage['temp'];
  $sat_oxigeno = $row_triage['sat_oxigeno'];
  $peso = $row_triage['peso'];
  $talla = $row_triage['talla'];
  $niv_dolor = $row_triage['niv_dolor'];


  $diab = $row_triage['diab'];
  if ($diab == 'SI') $diab = 'Si'; 
  else $diab = 'No';

  $h_arterial = $row_triage['h_arterial'];
  if ($h_arterial == 'SI') $h_arterial = 'Si';
  else $h_arterial = 'No';

  $enf_card_pulm = $row_triage['enf_card_pulm'];
  if ($enf_card_pulm == 'SI') $enf_card_pulm = 'Si';
  else $enf_card_pulm = 'No';

  $cancer = $row_triage['cancer'];
  if ($cancer == 'SI') $cancer = 'Si';
  else $cancer = 'No';

  $emb = $row_triage['emb'];
  if ($emb == 'SI') $emb = 'Si';
  else $emb = 'No';

  $otro = $row_triage['otro'];
  $val_total = $row_triage['val_total'];
  $edo_clin = $row_triage['edo_clin'];
  $imp_diag = $row_triage['imp_diag'];
  $area = $row_triage['area'];
  $id_usua = $row_triage['id_usua'];
  
}


$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.fecnac,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.folio FROM paciente p, dat_ingreso di where di.id_atencion = $id_atencion and di.Id_exp=p.Id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $fecnac = $row_pac['fecnac'];
  $fecha_nac = $row_pac['fecnac'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  $sexog = $row_pac['sexo'];
  $Id_exp = $row_pac['Id_exp'];
  $dir = $row_pac['dir'];
  $id_edo = $row_pac['id_edo'];
  $id_mun = $row_pac['id_mun'];
  $tel = $row_pac['tel'];
  $ocup = $row_pac['ocup'];
  $resp = $row_pac['resp'];
  $paren = $row_pac['paren'];
  $tel_resp = $row_pac['tel_resp'];
  $folio = $row_pac['folio'];
}

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $fecha_ing = $row_dat_ing['fecha'];
  $especialidad = $row_dat_ing['especialidad'];
 
  $tipo_a = $row_dat_ing['tipo_a'];
}

$sql_dat_tri = "SELECT * from triage where id_atencion = $id_atencion";
$result_dat_tri= $conexion->query($sql_dat_tri);

while ($row_dat_tri = $result_dat_tri->fetch_assoc()) {
  $id_usu = $row_dat_tri['id_usua'];
}


$sql_edo = "SELECT nombre FROM estados WHERE id_edo = $id_edo";
$result_edo = $conexion->query($sql_edo);

while ($row_edo = $result_edo->fetch_assoc()) {
  $nom_edo = $row_edo['nombre'];
}

$sql_mun = "SELECT nombre_m FROM municipios WHERE id_mun = $id_mun";
$result_mun = $conexion->query($sql_mun);

while ($row_mun = $result_mun->fetch_assoc()) {
  $nom_mun = $row_mun['nombre_m'];
}


$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetMargins(8, 10, 10, 90);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,30); 

$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 180);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(50);
$pdf->Cell(120, 6, utf8_decode('NOTA DE TRIAGE'), 1, 0, 'C');
$pdf->SetFont('Arial', '', 7);


$fecha_t = date_create($fecha_t);
$fecha_t = date_format($fecha_t,'d-m-Y H:i:s');



$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(100, 5, utf8_decode('Urgencia: ' . $urgencia), 1, 'C');
$f=date_create($fecha_t);

$pdf->Cell(95, 5, utf8_decode('Fecha de registro: ' . date_format($f,'d/m/Y H:i:s')), 1, 'L');

$pdf->Ln(6);


$pdf->Line(7, 50, 205, 50);
$pdf->Line(7, 50, 7, 280);
$pdf->Line(205, 50, 205, 280);
$pdf->Line(7, 280, 205, 280);

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
/*
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 5, utf8_decode('Peso: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 5,  utf8_decode($pesoh.' Kilos'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 5, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 5,  utf8_decode($tallah.' Metros'), 'B', 'L');
*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 5, utf8_decode('Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(178, 5, utf8_decode($dir), 'B', 'L');

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
$pdf->Cell(197, 3, utf8_decode('SIGNOS VITALES'), 0,0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell(42, 3, utf8_decode('Presión arterial: ' .$p_sistolica.'/'.$p_diastolica.''), 1, 'L');
$pdf->Cell(42, 3, utf8_decode('Frecuencia cardiaca: ' .$f_card.' Lat/min'), 1, 'L');
$pdf->Cell(49, 3, utf8_decode('Frecuencia respiratoria: ' .$f_resp.' Resp/min'), 1, 'L');
$pdf->Cell(28, 3, utf8_decode('Temperatura: ' .$temp.'°C'), 1, 'L');
$pdf->Cell(33, 3, utf8_decode('Saturación oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Ln(4);

$pdf->Cell(21, 3, utf8_decode('Peso: ' .$peso.' kg'), 1, 'L');
$pdf->Cell(21, 3, utf8_decode('Talla: ' .$talla.'m'), 1, 'L');

$pdf->Cell(42, 3, utf8_decode('Nivel de dolor (Escala EVA): ' .$niv_dolor ), 1, 'L');
$pdf->Cell(110, 3, utf8_decode('Valoración total (Escala Glasgow): ' . $val_total ), 1, 'L');
$pdf->Ln(4);
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(197, 6, utf8_decode('ANTECEDENTES '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(26, 4, utf8_decode('Diabetes: ' . $diab), 1, 'L');
$pdf->Cell(40, 4, utf8_decode('Hipertensión arterial: ' . $h_arterial), 1, 'L');
$pdf->Cell(33, 4, utf8_decode('Cáncer: ' . $cancer), 1, 'L');
$pdf->Cell(56, 4, utf8_decode('Enfermedades cardiacas / pulmonares: ' . $enf_card_pulm), 1, 'L');
$pdf->Cell(40, 4, utf8_decode('Embarazo: ' . $emb), 1, 'L');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Otros antecedentes: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($otro), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Motivo de atención: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($edo_clin), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Estado neurológico: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($imp_diag), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Destino del paciente: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($area), 1, 'J');
$pdf->Ln(1);

$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usu";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $pre = $row_reg_usrs['pre'];
  $app = $row_reg_usrs['papell'];
  $apm = $row_reg_usrs['sapell'];
  $nom = $row_reg_usrs['nombre'];
    $firma= $row_reg_usrs['firma'];
      $cargp = $row_reg_usrs['cargp'];
      $ced_p = $row_reg_usrs['cedp'];

}
      
      $pdf->SetFont('Arial', 'B', 8);

      $pdf->Image('../../imagenes/triage.jpg', 75,190, 70);
      $pdf->Image('../../imgfirma/' . $firma, 97, 247, 25);
    
      $pdf->SetY(258);
      $pdf->Cell(200, 3, utf8_decode($pre . '. ' . $app ), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 3, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetX(60);
      $pdf->Cell(100, 3, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
      $pdf->SetX(180);
      $pdf->Cell(20, 3, utf8_decode('CMSI-4.01'), 0, 0, 'R');
  

//nota



$sql_urgen = "SELECT * FROM dat_c_urgen where dat_c_urgen.id_atencion = $id_atencion";
$result_urgen = $conexion->query($sql_urgen);

while ($row_urgen = $result_urgen->fetch_assoc()) {
 $diab_pa = $row_urgen['diab_pa'];
 $diab_ma = $row_urgen['diab_ma'];
 $diab_ab = $row_urgen['diab_ab'];

 $hip_pa = $row_urgen['hip_pa'];
 $hip_ma = $row_urgen['hip_ma'];
 $hip_ab = $row_urgen['hip_ab'];

 $can_pa = $row_urgen['can_pa'];
 $can_ma = $row_urgen['can_ma'];
 $can_ab = $row_urgen['can_ab'];


  $motcon_cu = $row_urgen['motcon_cu'];
  $trau_cu = $row_urgen['trau_cu'];
  $trans_cu = $row_urgen['trans_cu'];
  $adic_cu = $row_urgen['adic_cu'];
  $otro_cu = $row_urgen['otro_cu'];
  $despatol = $row_urgen['despatol'];

  $quir_cu = $row_urgen['quir_cu'];
  $aler_cu = $row_urgen['aler_cu'];
  $pad_cu = $row_urgen['pad_cu'];
  $exp_cu = $row_urgen['exp_cu'];
  $diag_cu = $row_urgen['diag_cu'];
  $des_diag = $row_urgen['des_diag'];
  $diag2 = $row_urgen['diag2'];
 
  $hc_men = $row_urgen['hc_men'];
  $hc_ritmo = $row_urgen['hc_ritmo'];
  $gestas_cu = $row_urgen['gestas_cu'];
  $partos_cu = $row_urgen['partos_cu'];
  $ces_cu = $row_urgen['ces_cu'];
  $abo_cu = $row_urgen['abo_cu'];
  $fecha_fur = $row_urgen['fecha_fur'];

  $proc_cu = $row_urgen['proc_cu'];
  $med_cu = $row_urgen['med_cu'];
  $anproc_cu = $row_urgen['anproc_cu'];
  $trat_cu = $row_urgen['trat_cu'];
  $do_cu = $row_urgen['do_cu'];
  $dis_cu = $row_urgen['dis_cu'];
  $fecha_urgen = $row_urgen['fecha_urgen'];
  
}

$sql_edo = "SELECT nombre FROM estados WHERE id_edo = $id_edo";
$result_edo = $conexion->query($sql_edo);

while ($row_edo = $result_edo->fetch_assoc()) {
  $nom_edo = $row_edo['nombre'];
}

$sql_mun = "SELECT nombre_m FROM municipios WHERE id_mun = $id_mun";
$result_mun = $conexion->query($sql_mun);

while ($row_mun = $result_mun->fetch_assoc()) {
  $nom_mun = $row_mun['nombre_m'];
}


$pdf->AddPage();
$pdf->SetTextColor(43, 45, 127);


$pdf->SetFont('Arial', 'B', 11);
$pdf->SETX(35);
$pdf->MultiCell(150, 6, utf8_decode('NOTA DE CONSULTA DE OBSERVACIÓN'), 1, 'C');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);

$f1=date_create($fecha_urgen);


$pdf->Cell(75, 5, utf8_decode('Fecha de registro: ' . date_format($f1,'d/m/Y H:i:s')), 1,0, 'C');


$date=date_create($fecha_ing);
$pdf->Cell(75, 5, utf8_decode(' Fecha de ingreso:'. date_format($date,'d/m/Y H:i:s')), 1, 0, 'C');


$pdf->Cell(45, 5, 'Expediente: ' . $folio, 1,1, 'C');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 4, utf8_decode('FICHA DE IDENTIFICACIÓN: '), 0, 0, 'L');
$pdf->Ln(4);


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 59, 206, 59);
$pdf->Line(8, 59, 8, 75);
$pdf->Line(206, 59, 206, 75);
$pdf->Line(8, 75, 206, 75);
$pdf->SetFont('Arial', '', 8);


$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31, 3, 'Nombre del paciente: ', 0, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(163, 3, utf8_decode($pappel. ' '. $sapell . ' ' . $nom_pac), 'B', 'L');


$pdf->Ln(3.5);
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecnac);
$pdf->Cell(31, 3, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 3, date_format($date,"d/m/Y"), 'B', 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(12, 3, ' Edad: ', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 3, utf8_decode($edad), 'B', 'C');


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 3, utf8_decode(' Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(31, 3,  $sexo, 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 3, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(41, 3,  utf8_decode($tel), 'B', 'L');

$pdf->Ln(3.5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 3, utf8_decode('Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(177, 3, utf8_decode($dir), 'B', 'L');

$pdf->Ln(3.5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(21, 3, utf8_decode('Responsable: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(70, 3, utf8_decode($resp), 'B', 'L');
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 3, utf8_decode(' Parentesco: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 3, utf8_decode($paren), 'B', 'L');
  
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 3, utf8_decode(' Teléfono del responsable: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 3,  utf8_decode($tel_resp), 'B', 'L');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 4, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell(43, 3, utf8_decode('Presión arterial: ' .$p_sistolica.'/'.$p_diastolica.' mmHG/mmHG'), 1, 'L');
$pdf->Cell(35, 3, utf8_decode('Frecuencia cardiaca: ' .$f_card.' Lat/min'), 1, 'L');
$pdf->Cell(40, 3, utf8_decode('Frecuencia respiratoria: ' .$f_resp.' Resp/min'), 1, 'L');
$pdf->Cell(23, 3, utf8_decode('Temperatura: ' .$temp.'°C'), 1, 'L');
$pdf->Cell(27, 3, utf8_decode('Saturación oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Cell(16, 3, utf8_decode('Peso: ' .$peso.' kg'), 1, 'L');
$pdf->Cell(14, 3, utf8_decode('Talla: ' .$talla.'m'), 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 4, utf8_decode('MOTIVO DE ATENCIÓN: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(197, 3, utf8_decode($motcon_cu), 1, 'L');
$pdf->Ln(1);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 4, utf8_decode('ANTECEDENTES HEREDO FAMILIARES: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(197, 3, utf8_decode($diab_pa), 1, 'L');

$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 4, utf8_decode('ANTECEDENTES PERSONALES NO PÁTOLOGICOS: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(197, 3, utf8_decode($otro_cu), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 4, utf8_decode('ANTECEDENTES PERSONALES PÁTOLOGICOS: '), 0, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 3, utf8_decode('Quirúrgicos: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($quir_cu), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 3, utf8_decode('Traumáticos: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($trau_cu), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 3, utf8_decode('Otros antecedentes: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($despatol), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 4, utf8_decode('PADECIMIENTO ACTUAL: '), 0, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 3, utf8_decode('Padecimiento actual: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($pad_cu), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 3, utf8_decode('Exploración física: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($exp_cu), 1, 'J');
$pdf->Ln(1);



$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 4, utf8_decode('DIAGNÓSTICO: '), 0, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 3, utf8_decode('Diagnóstico principal: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($diag_cu), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 3, utf8_decode('Describir diagnóstico: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($des_diag), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 3, utf8_decode('Diagnósticos previos: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(165, 3, utf8_decode($diag2), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 4, utf8_decode('MEDICAMENTO(S): '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(197, 3, utf8_decode($med_cu), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 4, utf8_decode('ANÁLISIS Y PRONÓSTICOS: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(197, 3, utf8_decode($anproc_cu), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 4, utf8_decode('TRATAMIENTO Y PLAN: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(197, 3, utf8_decode($trat_cu), 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 4, utf8_decode('OBSERVACIONES Y ESTUDIOS: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(197, 3, utf8_decode($do_cu), 1, 'L');
$pdf->Ln(1);

$pdf->Ln(8);

$sql_med_id = "SELECT id_usua FROM dat_c_urgen WHERE id_atencion = $tri ORDER by fecha_urgen DESC LIMIT 1";
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
      $pdf->SetFont('Arial', 'B', 7);

    
      $pdf->Image('../../imgfirma/' . $firma, 97, 247, 25);
    
      $pdf->SetY(258);
      $pdf->Cell(200, 3, utf8_decode($pre . '. ' . $app ), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 3, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetX(60);
      $pdf->Cell(100, 3, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
      $pdf->SetX(180);
      $pdf->Cell(20, 3, utf8_decode('CMSI-4.02'), 0, 0, 'R');
//fin nota      


  //receta
 

 
//consulta receta urgen
$sql_recurgen = "SELECT * FROM recetaurgen  where id_rec_urgen=$rec";
$result_recurgen = $conexion->query($sql_recurgen);

while ($row_recurgen = $result_recurgen->fetch_assoc()) {
  $especialidad = $row_recurgen['especialidad'];
  $detesp = $row_recurgen['detesp'];
  $alergias = $row_recurgen['alergias'];
  $receta_urgen = $row_recurgen['receta_urgen'];

  $fec_pcita=$row_recurgen['fec_pcita'];
  $hor_pcita=$row_recurgen['hor_pcita'];

  $med = $row_recurgen['med'];
  $reg_ssa_urgen = $row_recurgen['reg_ssa_urgen'];
  $fecha_recurgen = $row_recurgen['fecha_recurgen'];  
}

//termino receta urgen


if($receta_urgen==!null){
$pdf->AddPage();

$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 180);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(50);
$pdf->Cell(120, 5, utf8_decode('RECETA MÉDICA'), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y");
$pdf->Cell(35, 5, 'Metepec, Mex, ' . $fecha_actual, 0, 1, 'R');


$pdf->Ln(5);

$pdf->Line(7, 50, 206, 50);
$pdf->Line(7, 50, 7, 280);
$pdf->Line(206, 50, 206, 280);
$pdf->Line(7, 280, 206, 280);


if($especialidad=="OTROS"){
   $pdf->SetFont('Arial', 'B', 7);
   $pdf->Cell(25, 3, utf8_decode('Especialidad : '), 0, 'L'); 
   $pdf->SetFont('Arial', '', 7);
   $pdf->Cell(110, 3, utf8_decode($detesp) , 'B', 'L');
}else{
   $pdf->SetFont('Arial', 'B', 7);
   $pdf->Cell(25, 3, utf8_decode('Especialidad : '), 0, 'L'); 
   $pdf->SetFont('Arial', '', 7);
   $pdf->Cell(118, 3, utf8_decode($especialidad) , 'B', 'L');
}

 $pdf->SetFont('Arial', 'B', 7);
 $fecha_recurgen=date_create($fecha_recurgen);
 $pdf->Cell(25, 3, utf8_decode(' Fecha de registro: '), 0, 'L'); 
 $pdf->SetFont('Arial', '', 7);
 $pdf->Cell(25, 3, date_format($fecha_recurgen,"d/m/Y  H:i"), 'B', 'L');
 $pdf->Ln(3);

 $pdf->SetFont('Arial', 'B', 7);
 $pdf->Cell(25, 3, utf8_decode('Paciente: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 7);
 $pdf->Cell(118, 3, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
 $pdf->SetFont('Arial', 'B', 7);
 $pdf->Cell(25, 3, utf8_decode(' Género: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 7);
 $pdf->Cell(25, 3, utf8_decode($sexo), 'B', 'L');
 $pdf->Ln(3);

 $pdf->SetFont('Arial', 'B', 7);
 $fecnac=date_create($fecnac);
 $pdf->Cell(27, 3, utf8_decode('Fecha de nacimiento: '), 0, 'L'); 
 $pdf->SetFont('Arial', '', 7);
 $pdf->Cell(26, 3, date_format($fecnac,"d/m/Y"), 'B', 'C');
 
 $pdf->SetFont('Arial', 'B', 7);
 
 $pdf->Cell(13, 3, utf8_decode('  Edad: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 7);
 $pdf->Cell(20, 3, utf8_decode($edad), 'B', 'C');
 
$pdf->SetFont('Arial', '', 7);
if($anos > "0" ){
  $pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 3, utf8_decode($anos . ' años' ), 'B', 'C');
}elseif($anos <="0" && $meses>"0"){
     $pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 3, utf8_decode($meses), 'B', 'C');
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    $pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 3, utf8_decode($dias), 'B', 'C');
}

  $aseguradora="";
 $sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha ASC limit 1";
$result_aseg = $conexion->query($sql_aseg);
while ($row_aseg = $result_aseg->fetch_assoc()) {
  $aseguradora = $row_aseg['aseg'];
}
 $pdf->SetFont('Arial', 'B', 7);
 $pdf->Cell(30,3,utf8_decode('  Aseguradora: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 7);
 $pdf->Cell(57, 3, utf8_decode($aseguradora), 'B','L');
 
 $pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 6.5);
$pdf->Cell(200, 4, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(38, 3, utf8_decode('Presión arterial: ' .$p_sistolica.'/'.$p_diastolica.' mmHG/mmHG'), 1, 'L');
$pdf->Cell(36, 3, utf8_decode('Frecuencia cardiaca: ' .$f_card.' Latidos/min'), 1, 'L');
$pdf->Cell(45, 3, utf8_decode('Frecuencia respiratoria: ' .$f_resp.' Respiraciones/min'), 1, 'L');
$pdf->Cell(22, 3, utf8_decode('Temperatura: ' .$temp.'°C'), 1, 'L');
$pdf->Cell(26, 3, utf8_decode('Saturación oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Cell(16, 3, utf8_decode('Peso: ' .$peso.' kg'), 1, 'L');
$pdf->Cell(14, 3, utf8_decode('Talla: ' .$talla.'m'), 1, 'L');

$pdf->Ln(5);
/*$pdf->Ln(5);
 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(20, 3, utf8_decode('ALERGIAS: '),0, 'C');
 $pdf->SetFont('Arial', '', 6);
 $pdf->MultiCell(173, 3, utf8_decode($alergias), 1, 'L');*/
 $pdf->Ln(1);


$pdf->Line(8, 80, 205, 80);
$pdf->Line(8, 80, 8, 238);
$pdf->Line(205, 80, 205, 238);
$pdf->Line(8, 238, 205, 238);

$pdf->SetX(90);
 $pdf->SetFont('Arial', 'B', 9);
 $pdf->MultiCell(45, 6, utf8_decode('TRATAMIENTO:  '),0, 'C');
 $pdf->SetFont('Arial', '', 12);
 $pdf->MultiCell(194, 6, utf8_decode($receta_urgen), 0, 'L');
 $pdf->Ln(1);

/*$pdf->SetY(238);
$pdf->SetX(10);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(57, 6, utf8_decode('MEDIDAS HIGIÉNICAS-DIETÉTICAS:'),0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(137, 4.5, utf8_decode($med), 'B', 'L');

$date=date_create($fec_pcita);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(10);
$pdf->Cell(29, 6, utf8_decode('PRÓXIMA CITA: '),0,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 4.5, date_format($date,"d-m-Y") . ' ' . $hor_pcita, 'B', 'L');
*/

 $pdf->Ln(2);
// $pdf->Cell(190, 6, utf8_decode('REG S.S.A: ' . ' ' .$reg_ssa_urgen), 0,0, 'C');

$sql_med_id = "SELECT id_usua FROM recetaurgen WHERE id_atencion = $id and id_rec_urgen=$rec";
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
     
  
      $pdf->SetFont('Arial', 'B', 7);

    
      $pdf->Image('../../imgfirma/' . $firma, 97, 247, 25);
    
      $pdf->SetY(258);
      $pdf->Cell(200, 3, utf8_decode($pre . '. ' . $app ), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 3, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetX(60);
      $pdf->Cell(100, 3, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
      $pdf->SetX(180);
      $pdf->Cell(20, 3, utf8_decode('CMSI-4.03'), 0, 0, 'R');
       }   
$pdf->Output();
