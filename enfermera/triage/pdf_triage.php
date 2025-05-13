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

$sql_triage = "SELECT * FROM triage t, dat_ingreso di where t.id_triage = $tri and di.id_atencion=$id";
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
  $destino = $row_triage['destino'];
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

$pdf->SetTextColor(44, 45, 127);
$pdf->SetDrawColor(44, 45, 180);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(50);
$pdf->Cell(120, 6, utf8_decode('REGISTRO DE TRIAGE - ENFERMERÍA'), 1, 0, 'C');
$pdf->SetFont('Arial', '', 7);


$fecha_t = date_create($fecha_t);
$fecha_t = date_format($fecha_t,'d-m-Y H:i:s');



$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(106, 5, utf8_decode('CLASIFICACIÓN DE TRIAGE: ' . $urgencia), 1, 'C');
$f=date_create($fecha_t);

$pdf->Cell(90, 5, utf8_decode('Fecha de registro: ' . date_format($f,'d/m/Y H:i:s')), 1, 'L');

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
$pdf->Cell(34, 5, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(31, 5, date_format($date1,"d/m/Y"), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(14, 5, ' Edad: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 5, utf8_decode($edad),'B', 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(19, 5, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(31, 5,  utf8_decode($tel), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 5,  $sexo, 'B', 'L');
$pdf->Ln(5);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 5, utf8_decode('Peso: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 5,  utf8_decode($peso.' Kilos'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 5, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 5,  utf8_decode($talla.' Metros'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 5, utf8_decode(' Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(125, 5, utf8_decode($dir), 'B', 'L');


$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(197, 5, utf8_decode('SIGNOS VITALES'), 0,0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell(42, 4, utf8_decode('Presión arterial: ' .$p_sistolica.'/'.$p_diastolica.''), 1, 'L');
$pdf->Cell(42, 4, utf8_decode('Frecuencia cardiaca: ' .$f_card.' Lat/min'), 1, 'L');
$pdf->Cell(49, 4, utf8_decode('Frecuencia respiratoria: ' .$f_resp.' Resp/min'), 1, 'L');
$pdf->Cell(28, 4, utf8_decode('Temperatura: ' .$temp.'°C'), 1, 'L');
$pdf->Cell(34, 4, utf8_decode('Saturación oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Ln(4);

$pdf->Cell(42, 4, utf8_decode('Escala EVA (Niv dolor: ' .$niv_dolor ), 1, 'L');
$pdf->Cell(42, 4, utf8_decode('Escala Glasgow (Val total): ' . $val_total ), 1, 'L');
$pdf->Ln(4);
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(197, 6, utf8_decode('ANTECEDENTES '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(26, 4, utf8_decode('Diabetes: ' . $diab), 1, 'L');
$pdf->Cell(40, 4, utf8_decode('Hipertensión arterial: ' . $h_arterial), 1, 'L');
$pdf->Cell(34, 4, utf8_decode('Cáncer: ' . $cancer), 1, 'L');
$pdf->Cell(56, 4, utf8_decode('Enfermedades cardiacas / pulmonares: ' . $enf_card_pulm), 1, 'L');
$pdf->Cell(40, 4, utf8_decode('Embarazo: ' . $emb), 1, 'L');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, utf8_decode('Otros antecedentes: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(166, 4, utf8_decode($otro), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, utf8_decode('Motivo de atención: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(166, 4, utf8_decode($edo_clin), 1, 'J');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, utf8_decode('Estado neurológico: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(166, 4, utf8_decode($imp_diag), 1, 'J');
$pdf->Ln(1);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, utf8_decode('Destino del paciente: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(166, 4, utf8_decode($destino), 1, 'J');
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
    
      $pdf->SetY(257);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app ), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetX(60);
      $pdf->Cell(100, 4, utf8_decode('Nombre y firma'), 0, 0, 'C');
      $pdf->SetX(180);
      $pdf->Cell(20, 4, utf8_decode('CMSI-4.01'), 0, 0, 'R');
  

//nota

$pdf->Output();
