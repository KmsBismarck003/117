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
include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}
   $this->Ln(35);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-12.02'), 0, 1, 'R');
  }
} 


//consulta receta hosp
$sql_rechosp = "SELECT * FROM receta_ambulatoria  where id_rec_amb = $id";
$result_rechosp = $conexion->query($sql_rechosp);

while ($row_rechosp = $result_rechosp->fetch_assoc()) {
  $fecha_r_hosp = $row_rechosp['fecha'];
  $nom_pac = $row_rechosp['nombre_rec'];
  $papell = $row_rechosp['papell_rec'];
  $sapell = $row_rechosp['sapell_rec'];
  $fecnac = $row_rechosp['fecnac_rec']; 
  $fecha_nacimiento = $row_rechosp['fecnac_rec']; 
  $edad = $row_rechosp['edad'];
  $sexo = $row_rechosp['sexo_rec'];
  $especialidad = $row_rechosp['especialidad'];
  $detesp = $row_rechosp['detesp'];
  $alerg = $row_rechosp['alerg_rec'];

   $p_sistolica = $row_rechosp['p_sistolica'];
  $p_diastolica = $row_rechosp['p_diastolica'];
  $f_card = $row_rechosp['f_card'];
  $f_resp = $row_rechosp['f_resp'];
  $temp = $row_rechosp['temp'];
  $sat_oxigeno = $row_rechosp['sat_oxigeno'];
  $peso = $row_rechosp['peso'];
  $talla = $row_rechosp['talla'];

  $medi = $row_rechosp['med_rec'];
  $receta = $row_rechosp['receta_rec'];
  $reg_ssa = $row_rechosp['reg_ssa_rec']; 
  
  $aseguradora = $row_rechosp['aseguradora'];
  $fec_pcita = $row_rechosp['fec_pcita'];
  $hor_pcita = $row_rechosp['hor_pcita'];
  $problema=$row_rechosp['problema'];
$subjetivo=$row_rechosp['subjetivo'];
$objetivo=$row_rechosp['objetivo'];
$analisis=$row_rechosp['analisis'];
$plan=$row_rechosp['plan'];
$px=$row_rechosp['px'];

$telefono = $row_rechosp['telefono'];
  $localidad = $row_rechosp['localidad'];
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


//termino receta hosp


$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(50);
$pdf->Cell(120, 5, utf8_decode('NOTA DE CONSULTA'), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);


$fecha_actual = date("d/m/Y");

$pdf->Ln(5);
$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(8, 50, 205, 50);
$pdf->Line(8, 50, 8, 280);
$pdf->Line(205, 50, 205, 280);
$pdf->Line(8, 280, 205, 280);

if($especialidad=="OTROS"){
   $pdf->SetFont('Arial', 'B', 8);
   $pdf->Cell(25, 6, utf8_decode('ESPECIALIDAD : '), 0, 'L'); 
   $pdf->SetFont('Arial', '', 9);
   $pdf->Cell(110, 6, utf8_decode($detesp) , 'B', 'L');
}else{
   $pdf->SetFont('Arial', 'B', 8);
   $pdf->Cell(25, 6, utf8_decode('ESPECIALIDAD : '), 0, 'L'); 
   $pdf->SetFont('Arial', '', 9);
   $pdf->Cell(110, 6, utf8_decode($especialidad) , 'B', 'L');
}

 $pdf->SetFont('Arial', 'B', 8);
 $fecha_r_hosp=date_create($fecha_r_hosp);
 $pdf->Cell(33, 6, utf8_decode(' FECHA DE REGISTRO: '), 0, 'L'); 
 $pdf->SetFont('Arial', '', 9);
 $pdf->Cell(25, 6, date_format($fecha_r_hosp,"d/m/Y  H:i"), 'B', 'L');
 $pdf->Ln(6);

 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(37, 6, utf8_decode('NOMBRE DEL PACIENTE: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 9);
 $pdf->Cell(98, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(10, 6, utf8_decode(' SEXO: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 9);
 $pdf->Cell(48, 6, utf8_decode($sexo), 'B', 'L');
 $pdf->Ln(6);

 $pdf->SetFont('Arial', 'B', 8);
 $fecnac=date_create($fecnac);
 $pdf->Cell(37, 6, utf8_decode('FECHA DE NACIMIENTO: '), 0, 'L'); 
 $pdf->SetFont('Arial', '', 9);
 $pdf->Cell(28, 6, date_format($fecnac,"d/m/Y"), 'B', 'C');
 
 $pdf->SetFont('Arial', 'B', 8);
 $edad=calculaedad($fecha_nacimiento);
 $pdf->Cell(13, 6, utf8_decode('  EDAD: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 9);
 $pdf->Cell(28, 6, utf8_decode($edad), 'B', 'C');
 
 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(30,6,utf8_decode(' ASEGURADORA: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 9);
 $pdf->Cell(57, 6, utf8_decode($aseguradora), 'B','L');
 $pdf->Ln(5);
 
 $pdf->SetFont('Arial', 'B', 8);

 $pdf->Cell(37, 6, utf8_decode('TELEFONO: '), 0, 'L'); 
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(28, 6, $telefono, 'B', 'C');
 
 $pdf->SetFont('Arial', 'B', 8);

 $pdf->Cell(23, 6, utf8_decode('  LOCALIDAD: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(68, 6, utf8_decode($localidad), 'B', 'C');
 $pdf->Ln(5);

 
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(200, 6, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(35, 6, utf8_decode('PRESIÓN ARTERIAL: ' .$p_sistolica.'/'.$p_diastolica), 1, 'L');
$pdf->Cell(27, 6, utf8_decode('FREC. CARDIACA: ' .$f_card), 1, 'L');
$pdf->Cell(32, 6, utf8_decode('FREC. RESPIRATORIA: ' .$f_resp), 1, 'L');
$pdf->Cell(27, 6, utf8_decode('TEMPERATURA: ' .$temp), 1, 'L');
$pdf->Cell(38, 6, utf8_decode('SATURACIÓN OXIGENO: ' .$sat_oxigeno), 1, 'L');
$pdf->Cell(16, 6, utf8_decode('PESO: ' .$peso), 1, 'L');
$pdf->Cell(18, 6, utf8_decode('TALLA: ' .$talla), 1, 'L');
$pdf->Ln(7);
 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(24, 6, utf8_decode('ALERGIAS: '),0, 'C');
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(170, 6, utf8_decode($alerg), 1, 'L');
 $pdf->Ln(1);
/*
 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(20, 6, utf8_decode('PACIENTE: '), 0, 'L');
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(173, 6, utf8_decode( $problema), 1, 'L');
 $pdf->Ln(1);
*/
 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(24, 6, utf8_decode('SUBJETIVO: '), 0, 'L');
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(170, 6, utf8_decode( $subjetivo), 1, 'L');
 $pdf->Ln(1);

 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(24, 6, utf8_decode('OBJETIVO: '), 0, 'L');
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(170, 6, utf8_decode( $objetivo), 1, 'L');
 $pdf->Ln(1);

 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(24, 6, utf8_decode('ANÁLISIS: '), 0, 'L');
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(170, 6, utf8_decode( $analisis), 1, 'L');
 $pdf->Ln(1);
 

 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(24, 6, utf8_decode('PLAN: '), 0, 'L');
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(170, 6, utf8_decode( $plan), 1, 'L');
 $pdf->Ln(1);

 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(24, 6, utf8_decode('PRONÓSTICO: '), 0, 'L');
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(170, 6, utf8_decode( $px), 1, 'L');
 $pdf->Ln(1);

 $sql_med_id = "SELECT id_usua FROM receta_ambulatoria WHERE id_rec_amb= $id ORDER by fecha DESC LIMIT 1";
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
    
      $pdf->SetY(-50);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Image('../../imgfirma/' . $firma, 95, 243, 30);
    
      $pdf->SetY(258);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'CÉD. PROF. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
    
      
      $pdf->ln(5);

$sql_rechosp = "SELECT * FROM receta_ambulatoria  where id_rec_amb = $id";
$result_rechosp = $conexion->query($sql_rechosp);

while ($row_rechosp = $result_rechosp->fetch_assoc()) {
  $fecha_r_hosp = $row_rechosp['fecha'];
  $nom_pac = $row_rechosp['nombre_rec'];
  $papell = $row_rechosp['papell_rec'];
  $sapell = $row_rechosp['sapell_rec'];
  $fecnac = $row_rechosp['fecnac_rec']; 
  $edad = $row_rechosp['edad'];
  $sexo = $row_rechosp['sexo_rec'];
  $alerg = $row_rechosp['alerg_rec'];
  $medi = $row_rechosp['med_rec'];
  $receta = $row_rechosp['receta_rec'];
  $reg_ssa = $row_rechosp['reg_ssa_rec']; 
  
  $aseguradora = $row_rechosp['aseguradora'];
  $especialidad = $row_rechosp['especialidad'];
  $detesp = $row_rechosp['detesp'];
  $fec_pcita = $row_rechosp['fec_pcita'];
  $hor_pcita = $row_rechosp['hor_pcita'];
  
  $telefono = $row_rechosp['telefono'];
  $localidad = $row_rechosp['localidad'];
}


$pdf->SetX(50);
$pdf->Cell(120, 6, utf8_decode('RECETA MÉDICA'), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);


$pdf->Ln(6);
$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(8, 50, 205, 50);
$pdf->Line(8, 50, 8, 280);
$pdf->Line(205, 50, 205, 280);
$pdf->Line(8, 280, 205, 280);

if($especialidad=="OTROS"){
   $pdf->SetFont('Arial', 'B', 8);
   $pdf->Cell(25, 6, utf8_decode('ESPECIALIDAD : '), 0, 'L'); 
   $pdf->SetFont('Arial', '', 8);
   $pdf->Cell(110, 6, utf8_decode($detesp) , 'B', 'L');
}else{
   $pdf->SetFont('Arial', 'B', 8);
   $pdf->Cell(25, 6, utf8_decode('ESPECIALIDAD : '), 0, 'L'); 
   $pdf->SetFont('Arial', '', 8);
   $pdf->Cell(110, 6, utf8_decode($especialidad) , 'B', 'L');
}

 $pdf->SetFont('Arial', 'B', 8);
 $fecha_r_hosp=date_create($fecha_r_hosp);
 $pdf->Cell(33, 6, utf8_decode(' FECHA: '), 0, 'L'); 
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(25, 6, date_format($fecha_r_hosp,"d/m/Y  H:i"), 'B', 'L');
 $pdf->Ln(6);

 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(37, 6, utf8_decode('NOMBRE DEL PACIENTE: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(98, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(10, 6, utf8_decode(' SEXO: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(48, 6, utf8_decode($sexo), 'B', 'L');
 $pdf->Ln(6);

 $pdf->SetFont('Arial', 'B', 8);
 $fecnac=date_create($fecnac);
 $pdf->Cell(37, 6, utf8_decode('FECHA DE NACIMIENTO: '), 0, 'L'); 
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(28, 6, date_format($fecnac,"d/m/Y"), 'B', 'C');
 
 $pdf->SetFont('Arial', 'B', 8);
 $edad=calculaedad($fecha_nacimiento);
 $pdf->Cell(13, 6, utf8_decode('  EDAD: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(28, 6, utf8_decode($edad), 'B', 'C');
 
 $pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(30, 6,utf8_decode(' ASEGURADORA: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(57, 6, utf8_decode($aseguradora), 'B','L');
 $pdf->Ln(5);

 $pdf->SetFont('Arial', 'B', 8);

 $pdf->Cell(37, 6, utf8_decode('TELEFONO: '), 0, 'L'); 
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(28, 6, $telefono, 'B', 'C');
 
 $pdf->SetFont('Arial', 'B', 8);

 $pdf->Cell(23, 6, utf8_decode('  LOCALIDAD: '), 0, 'L');  
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(68, 6, utf8_decode($localidad), 'B', 'C');
 $pdf->Ln(5);
 
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(200, 6, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(35, 6, utf8_decode('PRESIÓN ARTERIAL: ' .$p_sistolica.'/'.$p_diastolica), 1, 'L');
$pdf->Cell(28, 6, utf8_decode('FREC. CARDIACA: ' .$f_card), 1, 'L');
$pdf->Cell(33, 6, utf8_decode('FREC. RESPIRATORIA: ' .$f_resp), 1, 'L');
$pdf->Cell(29, 6, utf8_decode('TEMPERATURA: ' .$temp), 1, 'L');
$pdf->Cell(37, 6, utf8_decode('SATURACIÓN OXIGENO: ' .$sat_oxigeno), 1, 'L');
$pdf->Cell(14, 6, utf8_decode('PESO: ' .$peso), 1, 'L');
$pdf->Cell(18, 6, utf8_decode('TALLA: ' .$talla), 1, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 9);
 $pdf->Cell(20, 6, utf8_decode('ALERGIAS: '),0, 'C');
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(174, 6, utf8_decode($alerg), 'B', 'L');
 $pdf->Ln(1);



$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(10, 93, 204, 93);
$pdf->Line(10, 93, 10, 243);
$pdf->Line(204, 93, 204, 243);
$pdf->Line(10, 243, 204, 243);

$pdf->SetX(90);
 $pdf->SetFont('Arial', 'B', 9);
 $pdf->MultiCell(45, 6, utf8_decode('TRATAMIENTO:  '),0, 'C');
 $pdf->SetFont('Arial', '', 12);
 $pdf->MultiCell(194, 6, utf8_decode($receta), 0, 'L');
 $pdf->Ln(1);


$pdf->SetY(242);
$pdf->SetX(10);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(57, 6, utf8_decode('MEDIDAS HIGIÉNICAS-DIETÉTICAS:'),0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(137, 6, utf8_decode($medi), 'B', 'L');
$date=date_create($fec_pcita);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(10);

if ($fec_pcita <> "0000-00-00 00:00:00"){
    $date=date_create($fec_pcita);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetX(10);
    $pdf->Cell(29, 6, utf8_decode('PRÓXIMA CITA: '),0,0, 'L');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(35, 6, date_format($date,"d/m/Y H:i a"),  'B', 'L');
}
else
{
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetX(10);
    $pdf->Cell(29, 6, utf8_decode('CITA ABIERTA  '),0,0, 'L');
    $pdf->SetFont('Arial', '', 9);
}
 
 
$sql_med_id = "SELECT id_usua FROM receta_ambulatoria WHERE id_rec_amb= $id ORDER by fecha DESC LIMIT 1";
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
      $pdf->SetY(-50);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Image('../../imgfirma/' . $firma, 95, 249, 30);
    
       $pdf->SetY(263);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'CÉD. PROF. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
    
      
 $pdf->Output();

?>