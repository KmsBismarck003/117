<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id = @$_GET['id'];
$rec = @$_GET['rec'];
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
    $this->SetFont('Arial', '', 8);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('SIMA-010'), 0, 1, 'R');
  }
  
}


$sql_triage = "SELECT t.fecha_t,t.urgencia,t.id_atencion,t.p_sistolica, t.p_diastolica, t.f_card,t.f_resp, t.temp,t.sat_oxigeno,t.peso,t.talla,t.niv_dolor,t.diab,t.h_arterial,t.enf_card_pulm,t.cancer,t.emb,t.otro,t.val_total,t.edo_clin,t.imp_diag, di.area FROM triage t, dat_ingreso di where t.id_atencion = di.id_atencion and t.id_atencion = $id ORDER by t.fecha_t DESC LIMIT 1 ";
$result_triage = $conexion->query($sql_triage);

while ($row_triage = $result_triage->fetch_assoc()) {
  $fecha_t = $row_triage['fecha_t'];
  $urgencia = $row_triage['urgencia'];
  $id_atencion = $row_triage['id_atencion'];

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

$sql = "SELECT * FROM triage where id_atencion=$id ORDER by id_triage DESC limit 1";
$result = $conexion->query($sql);

while ($rowtriage = $result->fetch_assoc()) {
     $p_sistolica = $rowtriage['p_sistolica'];
  $p_diastolica = $rowtriage['p_diastolica'];
  $f_card = $rowtriage['f_card'];
  $f_resp = $rowtriage['f_resp'];
  $temp = $rowtriage['temp'];
  $sat_oxigeno = $rowtriage['sat_oxigeno'];
  $peso = $rowtriage['peso'];
  $talla = $rowtriage['talla'];
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.fecnac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp FROM paciente p, dat_ingreso di where di.id_atencion = $id_atencion and di.Id_exp=p.Id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $fecnac = $row_pac['fecnac'];
  $fecha_nacimiento = $row_pac['fecnac']; 
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

function calculaedad($fechanacimiento)
{
  list($ano, $mes, $dia) = explode("-", $fechanacimiento);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($ano_diferencia > 0 )
      return ($ano_diferencia . ' AÑOS');
  else if ($mes_diferencia > 0 || $ano_diferencia < 0)
      return ($mes_diferencia . ' MESES');
  else if ($dia_diferencia > 0 || $mes_diferencia < 0 || $ano_diferencia < 0)
      return ($dia_diferencia . ' DÍAS');
}
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
$pdf->SetDrawColor(43, 45, 180);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(50);
$pdf->Cell(120, 5, utf8_decode('RECETA MÉDICA'), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y");
$pdf->Cell(35, 5, 'Toluca, Mex, ' . $fecha_actual, 0, 1, 'R');


$pdf->Ln(10);

$pdf->Line(8, 55, 205, 55);
$pdf->Line(8, 55, 8, 280);
$pdf->Line(205, 55, 205, 280);
$pdf->Line(8, 280, 205, 280);


if($especialidad=="OTROS"){
   $pdf->SetFont('Arial', 'B', 6);
   $pdf->Cell(25, 3, utf8_decode('ESPECIALIDAD : '), 0, 'L'); 
   $pdf->SetFont('Arial', '', 6);
   $pdf->Cell(110, 3, utf8_decode($detesp) , 'B', 'L');
}else{
   $pdf->SetFont('Arial', 'B', 6);
   $pdf->Cell(25, 3, utf8_decode('ESPECIALIDAD : '), 0, 'L'); 
   $pdf->SetFont('Arial', '', 6);
   $pdf->Cell(110, 3, utf8_decode($especialidad) , 'B', 'L');
}

 $pdf->SetFont('Arial', 'B', 6);
 $fecha_recurgen=date_create($fecha_recurgen);
 $pdf->Cell(33, 3, utf8_decode(' FECHA DE REGISTRO: '), 0, 'L'); 
 $pdf->SetFont('Arial', '', 6);
 $pdf->Cell(25, 3, date_format($fecha_recurgen,"d-m-Y  H:i"), 'B', 'L');
 $pdf->Ln(3);

 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(37, 3, utf8_decode('NOMBRE DEL PACIENTE: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 6);
 $pdf->Cell(98, 3, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(10, 3, utf8_decode(' SEXO: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 6);
 $pdf->Cell(48, 3, utf8_decode($sexo), 'B', 'L');
 $pdf->Ln(3);

 $pdf->SetFont('Arial', 'B', 6);
 $fecnac=date_create($fecnac);
 $pdf->Cell(37, 3, utf8_decode('FECHA DE NACIMIENTO: '), 0, 'L'); 
 $pdf->SetFont('Arial', '', 6);
 $pdf->Cell(28, 3, date_format($fecnac,"d-m-Y"), 'B', 'C');
 
 $pdf->SetFont('Arial', 'B', 6);
 $edad=calculaedad($fecha_nacimiento);
 $pdf->Cell(13, 3, utf8_decode('  EDAD: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 7);
 $pdf->Cell(28, 3, utf8_decode($edad), 'B', 'C');
 $aseguradora="";
 $sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha ASC limit 1";
$result_aseg = $conexion->query($sql_aseg);
while ($row_aseg = $result_aseg->fetch_assoc()) {
  $aseguradora = $row_aseg['aseg'];
}
 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(30,3,utf8_decode(' ASEGURADORA: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 6);
 $pdf->Cell(57, 3, utf8_decode($aseguradora), 'B','L');
 
 $pdf->Ln(5);

 $pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(200, 4, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(33, 3, utf8_decode('PRESIÓN ARTERIAL: ' .$p_sistolica.'/'.$p_diastolica), 1, 'L');
$pdf->Cell(27, 3, utf8_decode('FREC. CARDIACA: ' .$f_card), 1, 'L');
$pdf->Cell(33, 3, utf8_decode('FREC. RESPIRATORIA: ' .$f_resp), 1, 'L');
$pdf->Cell(30, 3, utf8_decode('TEMPERATURA: ' .$temp), 1, 'L');
$pdf->Cell(36, 3, utf8_decode('SATURACIÓN OXIGENO: ' .$sat_oxigeno), 1, 'L');
$pdf->Cell(17, 3, utf8_decode('PESO: ' .$peso), 1, 'L');
$pdf->Cell(17, 3, utf8_decode('TALLA: ' .$talla), 1, 'L');
$pdf->Ln(5);
 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(20, 3, utf8_decode('ALERGIAS: '),0, 'C');
 $pdf->SetFont('Arial', '', 6);
 $pdf->MultiCell(173, 3, utf8_decode($alergias), 1, 'L');
 $pdf->Ln(1);


$pdf->Line(10, 80, 204, 80);
$pdf->Line(10, 80, 10, 238);
$pdf->Line(204, 80, 204, 238);
$pdf->Line(10, 238, 204, 238);

$pdf->SetX(90);
 $pdf->SetFont('Arial', 'B', 9);
 $pdf->MultiCell(45, 6, utf8_decode('TRATAMIENTO:  '),0, 'C');
 $pdf->SetFont('Arial', '', 12);
 $pdf->MultiCell(194, 6, utf8_decode($receta_urgen), 0, 'L');
 $pdf->Ln(1);

$pdf->SetY(238);
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


 $pdf->Ln(2);
 $pdf->Cell(190, 6, utf8_decode('REG S.S.A: ' . ' ' .$reg_ssa_urgen), 0,0, 'C');

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
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->SetY(-60);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Image('../../imgfirma/' . $firma, 95, 250, 23);
    
       $pdf->SetY(264);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'CÉD. PROF. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
 $pdf->Output();