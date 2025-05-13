<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id = @$_GET['id'];
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

    $this->Image('../../imagenes/logo PDF.jpg', 10, 10, 28, 30);
    $this->SetFont('Arial', 'B', 14);
    $this->Cell(200, 8, 'Sanatorio Venecia', 0, 0, 'C');
    $this->Ln(10);
    $this->SetDrawColor(0, 0, 0);
    $this->Line(50, 18, 170, 18);
    $this->Line(50, 19, 170, 19);
    $this->SetFont('Arial', '', 10);
    $this->Cell(200, 8, 'PASEO TOLLOCAN NO. 113 COL. UNIVERSIDAD', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(200, 8, utf8_decode('C.P. 50130 TOLUCA, MÉX'), 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(200, 8, 'TEL.: (01 722) 280 5672', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(200, 8, 'www.sanatoriovenecia.com.mx', 0, 0, 'C');
    $this->Ln(10);
    $this->Image('../../imagenes/logo PDF 2.jpg', 170, 20, 40, 20);
  }
  function Footer()
  {
    include '../../conexionbd.php';
    $id = @$_GET['id'];

    $sql_med_id = "SELECT id_usua FROM triage WHERE id_atencion = $id ORDER by fecha_t ASC LIMIT 1";
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


      $this->SetY(-55);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(200, 5, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
      $this->Ln(6);
      $this->Image('../../imgfirma/' . $firma, 95, $this->SetY(-45), 30, 10);
      $this->Ln(6);
      $this->Cell(200, 5, utf8_decode($pre . ': ' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
      $this->Ln(6);
      $this->Cell(200, 5, utf8_decode('Céd. Prof.: ' . $ced_p), 0, 0, 'C');
      $this->Ln(5);
      $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
      $this->SetX(100);
      $this->Cell(85, 5, date('d/m/Y'), 0, 1, 'R');
    }
  }
}

$sql_triage = "SELECT t.fecha_t,t.urgencia,t.id_atencion,t.p_sistolica, t.p_diastolica, t.f_card,t.f_resp, t.temp,t.sat_oxigeno,t.peso,t.talla,t.niv_dolor,t.diab,t.h_arterial,t.enf_card_pulm,t.cancer,t.emb,t.otro,t.val_total,t.edo_clin,t.imp_diag, di.area FROM triage t, dat_ingreso di where t.id_atencion = di.id_atencion and t.id_atencion = $id ORDER by t.fecha_t DESC LIMIT 1 ";
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
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.fecnac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp FROM paciente p, dat_ingreso di where di.id_atencion = $id_atencion and di.Id_exp=p.Id_exp";
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
}

$sql_urgen = "SELECT u.diab_pa,u.diab_ma,u.diab_ab, u.hip_pa,u.hip_ma,u.hip_ab,u.can_pa,u.can_ma,u.can_ab,u.motcon_cu,u.trau_cu,u.trans_cu,u.adic_cu,u.quir_cu,u.pad_cu,u.exp_cu,u.diag_cu,u.gestas_cu,u.partos_cu,u.ces_cu,u.abo_cu,u.fecha_fur,u.proc_cu,u.med_cu,u.anproc_cu,u.trat_cu,u.do_cu,u.dis_cu,u.fecha_urgen FROM dat_c_urgen u, dat_ingreso din where din.id_atencion = $id_atencion";
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
  $pad_cu = $row_urgen['pad_cu'];
  $exp_cu = $row_urgen['exp_cu'];
  $diag_cu = $row_urgen['diag_cu'];

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


//consulta receta urgen
$sql_recurgen = "SELECT rec.receta_urgen,rec.reg_ssa_urgen,rec.fecha_recurgen FROM recetaurgen rec, dat_ingreso din where din.id_atencion = $id_atencion";
$result_recurgen = $conexion->query($sql_recurgen);

while ($row_recurgen = $result_recurgen->fetch_assoc()) {
  $receta_urgen = $row_recurgen['receta_urgen'];
  $reg_ssa_urgen = $row_recurgen['reg_ssa_urgen'];
  $fecha_recurgen = $row_recurgen['fecha_recurgen'];  
}

//termino receta urgen

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

$sql_dati = "SELECT motivo_atn FROM dat_ingreso WHERE id_atencion = $id_atencion";
$result_dati = $conexion->query($sql_dati);

while ($row_dati = $result_dati->fetch_assoc()) {
  $motivo_atn = $row_dati['motivo_atn'];
}

//consulta ordenes
$sql_ormed = "SELECT orm.fecha_ord,orm.hora_ord,orm.dieta,orm.cuid_gen,orm.med_med,orm.soluciones,orm.sol_estudios FROM dat_ordenes_med orm, dat_ingreso din where din.id_atencion = $id_atencion";
$result_ormed = $conexion->query($sql_ormed);

while ($row_ormed = $result_ormed->fetch_assoc()) {
  $fecha_ord = $row_ormed['fecha_ord'];
  $hora_ord = $row_ormed['hora_ord'];
  $dieta = $row_ormed['dieta'];  

  $cuid_gen = $row_ormed['cuid_gen'];  
  $med_med = $row_ormed['med_med'];  
  $soluciones = $row_ormed['soluciones']; 
  $sol_estudios = $row_ormed['sol_estudios'];  
}
//termino ordenes

//consulta choque
$sql_ch = "SELECT cho.fecha_ch,cho.tip_ech,cho.problemach,cho.subjetivoch,cho.objetivoch,cho.analisisch,cho.planch,cho.pxch,cho.dest_cu_choque FROM dat_choque cho, dat_ingreso din where din.id_atencion = $id_atencion";
$result_ch = $conexion->query($sql_ch);

while ($row_ch = $result_ch->fetch_assoc()) {
  $fecha_ch = $row_ch['fecha_ch'];
  $tip_ech = $row_ch['tip_ech'];
  $problemach = $row_ch['problemach'];  

  $subjetivoch = $row_ch['subjetivoch'];  
  $objetivoch = $row_ch['objetivoch'];  
  $analisisch = $row_ch['analisisch']; 
  $planch = $row_ch['planch']; 
  $pxch = $row_ch['pxch'];  
  $dest_cu_choque = $row_ch['dest_cu_choque'];  

}
//termino choque


$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);
$pdf->SETX(33);
$pdf->MultiCell(150, 6, utf8_decode('NOTAS DE EVOLUCIÓN'), 1, 'C');
$pdf->Ln(3);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(120, 6, utf8_decode('NOMBRE DEL PACIENTE: ' . $papell . ' ' . $sapell . ' ' . $nom_pac), 1,0, 'L');
$pdf->Cell(70, 6, utf8_decode('IDENTIFICACIÓN DEL PACIENTE: ' . $Id_exp), 1,1, 'L');

$pdf->Cell(45, 6, 'EDAD: ' . $edad, 1,0, 'C');
$pdf->Cell(100, 6, 'FECHA DE NACIMIENTO: ' . $fecnac, 1,0, 'C');
$pdf->Cell(45, 6, 'SERVICIO: ' . $id_atencion, 1,1, 'C');
$pdf->Cell(190, 6, utf8_decode('DIAGNÓSTICO: ' . $motivo_atn), 1,1, 'L');
$pdf->Ln(4);


$pdf->Cell(50, 6, utf8_decode('FECHA: ' . ' ' . $fecha_ch), 1,1, 'C');


$pdf->SetFont('Arial', 'B', 10);
$pdf->MultiCell(190, 6, utf8_decode('NOTAS'), 1, 'C');
$pdf->MultiCell(190, 6, utf8_decode($tip_ech), 1, 'C');


$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(190, 6, utf8_decode($problemach), 1, 'L');
$pdf->MultiCell(190, 6, utf8_decode($subjetivoch), 1, 'L');
$pdf->MultiCell(190, 6, utf8_decode($objetivoch), 1, 'L');
$pdf->MultiCell(190, 6, utf8_decode($analisisch), 1, 'L');

$pdf->MultiCell(190, 6, utf8_decode($planch), 1, 'L');

$pdf->MultiCell(190, 6, utf8_decode($pxch), 1, 'L');
$pdf->Ln(3);

 $pdf->Output();