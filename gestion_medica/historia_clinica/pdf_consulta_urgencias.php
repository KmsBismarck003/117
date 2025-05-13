<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id = @$_GET['id'];
$nur = @$_GET['nur'];
$id_med = @$_GET['id_med'];

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id = @$_GET['id'];;

    $this->Image('../../imagenes/SI.PNG', 5, 15, 65, 21);
    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
    $this->Cell(196, 9, utf8_decode(' Médica San Isidro'), 0, 0, 'C');
    $this->Ln(10);
    $this->SetDrawColor(43, 45, 180);
    $this->Line(50, 18, 170, 18);
    $this->SetFont('Arial', '', 8);
    $this->Cell(200, 8, utf8_decode('CALLE JOSEFA ORTIZ DE DOMÍNGUEZ #444'), 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(200, 8, utf8_decode('BARRIO COAXUSTENCO, METEPEC, ESTADO DE MÉXICO'), 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(200, 8, 'TEL: (01722) 235-01-75 / 235-02-12 / 902-03-90 / C.P. 52140', 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(200, 8, 'https://medicasanisidro.com/', 0, 0, 'C');
    $this->Ln(10);
    $this->Image('../../imagenes/en.png', 159, 22, 45, 15);
  
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-003'), 0, 1, 'R');
  }
}


$sql_triage = "SELECT t.fecha_t,t.urgencia,t.id_atencion,t.p_sistolica, t.p_diastolica, t.f_card,t.f_resp, t.temp,t.sat_oxigeno,t.peso,t.talla,t.niv_dolor,t.diab,t.h_arterial,t.enf_card_pulm,t.cancer,t.emb,t.otro,t.val_total,t.edo_clin,t.imp_diag, di.area, di.tipo_a, di.fecha FROM triage t, dat_ingreso di where t.id_atencion = di.id_atencion and t.id_atencion = $id ORDER by t.fecha_t DESC LIMIT 1 ";
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
  $h_arterial = $row_triage['h_arterial'];
  $enf_card_pulm = $row_triage['enf_card_pulm'];
  $cancer = $row_triage['cancer'];
  $emb = $row_triage['emb'];
  $otro = $row_triage['otro'];
  $val_total = $row_triage['val_total'];
  $edo_clin = $row_triage['edo_clin'];
  $imp_diag = $row_triage['imp_diag'];
  $area = $row_triage['area'];
  $tipo_a = $row_triage['tipo_a'];
  $fecha_ing = $row_triage['fecha'];
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.fecnac,p.sapell,p.edad,p.sexo,p.Id_exp,p.folio,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp FROM paciente p, dat_ingreso di where di.id_atencion = $id_atencion and di.Id_exp=p.Id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $fecnac = $row_pac['fecnac'];
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
}

$sql_urgen = "SELECT * FROM dat_c_urgen u, dat_ingreso din where din.id_atencion = $id_atencion and u.id_c_urgen=$nur";
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
   $alco_cu = $row_urgen['alco_cu'];
    $tab_cu = $row_urgen['tab_cu'];
     $otro_cu = $row_urgen['otro_cu'];
  $quir_cu = $row_urgen['quir_cu'];
  $despatol = $row_urgen['despatol'];
  $pad_cu = $row_urgen['pad_cu'];
  $exp_cu = $row_urgen['exp_cu'];
  $diag_cu = $row_urgen['diag_cu'];
  $diag2 = $row_urgen['diag2'];

$men_cu = $row_urgen['hc_men'];
$ritmo_cu = $row_urgen['hc_ritmo'];
  $gestas_cu = $row_urgen['gestas_cu'];
  $partos_cu = $row_urgen['partos_cu'];
  $ces_cu = $row_urgen['ces_cu'];
  $abo_cu = $row_urgen['abo_cu'];
  $fecha_fur = $row_urgen['fecha_fur'];

  $hc_desc_hom = $row_urgen['hc_desc_hom'];

  

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

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->Ln(-1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('CONSULTA (OBSERVACIÓN)'), 0, 'C');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 49.5, 172, 49.5);//arriba
$pdf->Line(48, 41, 48, 49.5);//isq
$pdf->Line(172, 41, 172, 49.5); //derecha
$pdf->Line(48, 41, 172, 41); //abajo


$pdf->SetDrawColor(43, 45, 127);

$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y");


$pdf->Ln(2);

$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(8, 52, 207, 52);
$pdf->Line(8, 52, 8, 280);
$pdf->Line(207, 52, 207, 280);
$pdf->Line(8, 280, 207, 280);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(17, 3, 'SERVICIO: ', 0, 'L');  
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(124, 3, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 6);
$date=date_create($fecha_ing);
$pdf->Cell(28, 3, utf8_decode('FECHA DE INGRESO:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(25, 3, date_format($date,'d-m-Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(20, 3, utf8_decode('EXPEDIENTE: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(8, 3, utf8_decode($folio), 'B', 0, 'L');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(40, 3, ' NOMBRE DEL PACIENTE: ', 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(126, 3, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 6);

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 6);
$date=date_create($fecnac);
$pdf->Cell(37, 3, 'FECHA DE NACIMIENTO: ', 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(20, 3, date_format($date,"d/m/Y"), 'B', 'C');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(12, 3, ' EDAD: ', 0, 'L');

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(20, 3, utf8_decode($edad), 'B', 'C');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(21, 3, utf8_decode(' OCUPACIÓN: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(31, 3,  utf8_decode($ocup), 'B', 'L');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('TELÉFONO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(25, 3,  utf8_decode($tel), 'B', 'L');

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(13, 3, 'SEXO: ', 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(22, 3,  $sexo, 'B', 'L');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(18, 3, utf8_decode(' DOMICILIO: '), 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(141, 3, utf8_decode($dir), 'B', 'L');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(195, 3, utf8_decode('SIGNOS VITALES'), 0,0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(31, 3, utf8_decode('PRESIÓN ARTERIAL: ' .$p_sistolica.'/'.$p_diastolica), 1, 'L');
$pdf->Cell(26, 3, utf8_decode('FREC. CARDIACA: ' .$f_card), 1, 'L');
$pdf->Cell(30, 3, utf8_decode('FREC. RESPIRATORIA: ' .$f_resp), 1, 'L');
$pdf->Cell(26, 3, utf8_decode('TEMPERATURA: ' .$temp), 1, 'L');
$pdf->Cell(32, 3, utf8_decode('SATURACIÓN OXIGENO: ' .$sat_oxigeno), 1, 'L');
$pdf->Cell(15, 3, utf8_decode('PESO: ' .$peso), 1, 'L');
$pdf->Cell(15, 3, utf8_decode('TALLA: ' .$talla), 1, 'L');
$pdf->Cell(20, 3, utf8_decode('ESCALA EVA: ' .$niv_dolor), 1, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('MOTIVO DE CONSULTA: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($motcon_cu), 1, 'J');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(195, 3, utf8_decode('ANTECEDENTES HEREDO FAMILIARES: '), 0, 0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(28, 3, utf8_decode('DIABETES '), 1, 'L');
$pdf->Cell(56, 3, utf8_decode('PADRE: ' . $diab_pa), 1, 'L');
$pdf->Cell(56, 3, utf8_decode('MADRE: ' . $diab_ma), 1, 'L');
$pdf->Cell(55, 3, utf8_decode('ABUELOS: ' . $diab_ab), 1, 'L');

$pdf->Ln(3);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(28, 3, utf8_decode('HIPERTENSIÓN '), 1, 'C');
$pdf->Cell(56, 3, utf8_decode('PADRE: ' . $hip_pa), 1, 'L');
$pdf->Cell(56, 3, utf8_decode('MADRE: ' . $hip_ma), 1, 'L');
$pdf->Cell(55, 3, utf8_decode('ABUELOS: ' . $hip_ab), 1, 'L');

$pdf->Ln(3);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(28, 3, utf8_decode('CÁNCER '), 1, 'C');
$pdf->Cell(56, 3, utf8_decode('PADRE: ' . $can_pa), 1, 'L');
$pdf->Cell(56, 3, utf8_decode('MADRE: ' . $can_ma), 1, 'L');
$pdf->Cell(55, 3, utf8_decode('ABUELOS: ' . $can_ab), 1, 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(55, 3, utf8_decode('ANTECEDENTES PERSONALES NO PATOLÓGICOS: '), 0, 0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('ADICCIONES: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($adic_cu.' '.$alco_cu.' '.$tab_cu), 1, 'J');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('OTROS: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($otro_cu), 1, 'J');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(58, 3, utf8_decode('ANTECEDENTES PERSONALES PATOLÓGICOS: '), 0, 0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('QUIRÚRGICOS: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($quir_cu), 1, 'J');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('TRAUMÁTICOS: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($trau_cu), 1, 'J');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('OTROS: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($despatol), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('PADECIMIENTO ACTUAL: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($pad_cu), 1, 'J');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('EXPLORACIÓN FÍSICA: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($exp_cu), 1, 'J');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('DIAGNÓSTICO PPAL: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($diag_cu), 1, 'J');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('DIAGNÓSTICO SEC: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($diag2), 1, 'J');
$pdf->Ln(1);

if($sexo=='MUJER')
{
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(195, 3, utf8_decode('ANTECEDENTES GINECO-OBSTÉTRICOS: '), 0, 0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 6);

$pdf->Cell(34, 3, utf8_decode('MENARCA: ' . $men_cu), 1, 'L');
$pdf->Cell(33, 3, utf8_decode('RITMO: ' . $ritmo_cu), 1, 'L');
$pdf->Cell(20, 3, utf8_decode('GESTAS: ' . $gestas_cu), 1, 'L');
$pdf->Cell(20, 3, utf8_decode('PARTOS: ' . $partos_cu), 1, 'L');
$pdf->Cell(20, 3, utf8_decode('CESÁREAS: ' . $ces_cu), 1, 'L');
$pdf->Cell(20, 3, utf8_decode('ABORTOS: ' . $abo_cu), 1, 'L');
$date=date_create($fecha_fur);
$pdf->Cell(48, 3, utf8_decode('FECHA ÚLTIMA REGLA: ' . date_format($date,"d/m/Y")), 1, 'L');
}
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('MEDICAMENTO(S): '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($med_cu), 1, 'J');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('ANÁLISIS Y PRONÓST: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($anproc_cu), 1, 'J');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('TRATAMIENTO Y PLAN: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($trat_cu), 1, 'J');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('OBSERV. Y ESTUDIOS: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($do_cu), 1, 'J');


$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('DESTINO DEL PACIENTE: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(167, 3, utf8_decode($area), 1, 'J');

$pdf->Ln(1);


$sql_med_id = "SELECT id_usua FROM dat_c_urgen WHERE id_atencion = $id and id_c_urgen=$nur";
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
      $cargp = $row_med['cargp'];
      $ced_p = $row_med['cedp'];

}
      $pdf->SetY(-60);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Image('../../imgfirma/' . $firma, 95, 250, 30);
    
      $pdf->SetY(264);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'CÉD. PROF. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
  
 $pdf->Output();