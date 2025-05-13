<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id = @$_GET['id'];
$tri = @$_GET['tri'];
$id_med = @$_GET['id_med'];

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id = @$_GET['id'];
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
    $this->Cell(0, 10, utf8_decode('SIMA-011'), 0, 1, 'R');
  }
 
}

$sql_triage = "SELECT * FROM triage t,dat_ingreso di where t.id_atencion = $id and di.id_atencion=$id";
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
  $id_usua = $row_triage['id_usua'];
  
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.fecnac,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.folio FROM paciente p, dat_ingreso di where di.id_atencion = $id and di.Id_exp=p.Id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $fecnac = $row_pac['fecnac'];
  $fecha_nac = $row_pac['fecnac'];
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
  $folio = $row_pac['folio'];
}

$sql_urgen = "SELECT * FROM dat_c_urgen u, dat_ingreso din where din.id_atencion = $id";
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
  $quir_cu = $row_urgen['quir_cu'];
    $aler_cu = $row_urgen['aler_cu'];
  $pad_cu = $row_urgen['pad_cu'];
  $exp_cu = $row_urgen['exp_cu'];
  $diag_cu = $row_urgen['diag_cu'];
  $des_diag  = $row_urgen['des_diag'];
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

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(43, 45, 127);


$pdf->SetFont('Arial', 'B', 11);
$pdf->SETX(35);
$pdf->MultiCell(150, 6, utf8_decode('NOTA DE CONSULTA DE OBSERVACIÓN / HISTORIA CLÍNICA'), 1, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell(158, 6, utf8_decode('Fecha y hora: ' . $fecha_urgen), 1,0, 'L');
$pdf->Cell(40, 6, 'Expediente: ' . $folio, 1,1, 'C');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 5, utf8_decode('FICHA DE IDENTIFICACIÓN DEL PACIENTE: '), 0, 0, 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell(128, 6, utf8_decode('Paciente: ' . $papell . ' ' . $sapell . ' ' . $nom_pac), 1, 'L');
$pdf->Cell(30, 6, utf8_decode('Edad: ' . $edad), 1, 'C');
$pdf->Cell(40, 6, utf8_decode('Género: ' . $sexo), 1,1, 'C');
$pdf->SetFont('Arial', '', 8);
$fecnac=date_create($fecnac);
$pdf->MultiCell(198, 6, utf8_decode('Fecha de nacimiento: ' .date_format($fecnac,"d-m-Y")), 1, 'L');


$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 5, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell(35, 6, utf8_decode('Frecuencia cardiaca: ' . $f_card), 1, 'L');
$pdf->Cell(40, 6, utf8_decode('Frecuencia respiratoria: ' . $f_resp), 1, 'L');
$pdf->Cell(32, 6, utf8_decode('Presión arterial: ' . $p_sistolica . '/' . $p_diastolica), 1, 'L');
$pdf->Cell(25, 6, utf8_decode('Temperatura: ' . $temp), 1, 'L');
$pdf->Cell(15, 6, utf8_decode('Peso: ' . $peso), 1, 'L');
$pdf->Cell(17, 6, utf8_decode('Talla: ' . $talla), 1, 'L');
$pdf->Cell(34, 6, utf8_decode('Área: ' . $area), 1, 'L');
$pdf->Ln(8);


$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('MOTIVO DE LA CONSULTA: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(198, 6, utf8_decode($motcon_cu), 1, 'L');
$pdf->Ln(2);


$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 5, utf8_decode('ANTECEDENTES HEREDO FAMILIARES: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(198, 6, utf8_decode($diab_pa), 1, 'L');

$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 5, utf8_decode('ANTECEDENTES PERSONALES NO PÁTOLOGICOS: '), 0, 0, 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode('Adicciones: ' . $adic_cu), 1, 'L');
$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 5, utf8_decode('ANTECEDENTES PERSONALES PÁTOLOGICOS: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(49, 6, utf8_decode('Quirúrgicos: ' . $quir_cu), 1, 'L');
$pdf->Cell(49, 6, utf8_decode('Traumáticos: ' . $trau_cu), 1, 'L');
$pdf->Cell(50, 6, utf8_decode('Transfusionales: ' . $trans_cu), 1, 'L');
$pdf->Cell(50, 6, utf8_decode('Alergicos: ' . $aler_cu), 1, 'L');
$pdf->Ln(8);


$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('PADECIMIENTO ACTUAL: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(198, 6, utf8_decode($pad_cu), 1, 'L');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('EXPLORACIÓN FÍSICA: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(198, 6, utf8_decode($exp_cu), 1, 'L');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('DIAGNOSTICO: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode($diag_cu), 1, 'L');
$pdf->Ln(7);

if($des_diag!=null){
  $pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('DESCRIBIR DIAGNÓSTICO: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode($des_diag), 1, 'L');
$pdf->Ln(7);
}



$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('PROCEDIMIENTO(S): '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode($proc_cu), 1, 'L');
$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('MEDICAMENTO(S): '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode($med_cu), 1, 'L');
$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('ANÁLISIS Y PRONÓSTICOS: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode($anproc_cu), 1, 'L');
$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('TRATAMIENTO Y PLAN: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode($trat_cu), 1, 'L');
$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('OBSERVACIONES Y ESTUDIOS: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode($do_cu), 1, 'L');
$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 5, utf8_decode('DISCAPACIDADES: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode($dis_cu), 1, 'L');
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
       $pdf->SetY(-43);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Image('../../imgfirma/' . $firma, 100, 255, 10);
      $pdf->Ln(4);
      $pdf->SetX(80);
      $pdf->Cell(50, 4, utf8_decode('MEDICO : '.$pre . ' .' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetX(30);
      $pdf->Cell(150, 4, utf8_decode('Cédula Profesional: ' . $ced_p), 0, 0, 'C');
      $pdf->SetX(60);
      $pdf->Cell(90, 4, utf8_decode(''), 'B', 'C');
      $pdf->Ln(4);
       $pdf->SetX(15);
      $pdf->Cell(180, 4, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
 $pdf->Output();