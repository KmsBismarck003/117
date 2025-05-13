<?php

use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
//require('../../fpdf/MultiCellBlt.php');
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

mysqli_set_charset($conexion, "utf8");

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

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 28);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
  }}
  function Footer()
  {
    $this->SetFont('Arial', '', 8);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, 'MAC-004', 0, 1, 'R');
  }
}

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $tipo_a = $row_dat_ing['tipo_a'];
  $fecha_ing = $row_dat_ing['fecha'];
}

$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pre = $row_reg_usrs['pre'];
  $user_papell = $row_reg_usrs['papell'];
  $user_sapell = $row_reg_usrs['sapell'];
  $user_nombre = $row_reg_usrs['nombre'];
   $ced_p = $row_reg_usrs['cedp'];
  $cargp = $row_reg_usrs['cargp'];

}

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p where p.Id_exp = $id_exp";
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

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

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

$sql_cam = "SELECT * FROM cat_camas WHERE id_atencion= $id_atencion";
$result_cam = $conexion->query($sql_cam);

while ($row_cam = $result_cam->fetch_assoc()) {
  $num_cam = $row_cam['num_cama'];
}

$sql_mun = "SELECT nombre_m FROM municipios WHERE id_mun = $id_mun";
$result_mun = $conexion->query($sql_mun);

while ($row_mun = $result_mun->fetch_assoc()) {
  $nom_mun = $row_mun['nombre_m'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('CARTA DE CONSENTIMIENTO COVID-19
'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 205, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(205, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(3);
$pdf->Cell(17, 6, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(132, 6, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y");
$pdf->Cell(13, 6, utf8_decode(' Fecha:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, $fecha_actual, 'B', 1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 6, utf8_decode($id_exp), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 6, 'Nombre del Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(129, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 6, utf8_decode('Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23, 6, date_format($date,'d/m/Y'), 'B', 0, 'C');

$pdf->SetFont('Arial', '', 8);
$date=date_create($fecnac);
$pdf->Cell(34, 6, ' Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23, 6, date_format($date,"d/m/Y"), 'B',0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(14, 6, ' Edad: ', 0, 'L');

$edad=calculaedad($fecnac);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 6, utf8_decode($edad), 'B', 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(13, 6, ' Sexo: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6,  $sexo, 'B', 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(16, 6, utf8_decode('Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(92, 6, utf8_decode($dir), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(19, 6, utf8_decode(' Ocupación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 6,  utf8_decode($ocup), 'B', 'L');
if(isset($num_cam)){
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(19, 6, utf8_decode(' Habitación: '),  0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6,  $num_cam, 'B', 'C');
}else{
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(19, 6, utf8_decode(' Habitación: '),  0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, 'S/H ', 'B', 'L');
}
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(47, 6, 'Nombre del Representante legal: ' , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(103, 6, utf8_decode($resp), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 6, 'Parentesco: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(24, 6, utf8_decode($paren), 'B', 'L');



$pdf->Ln(8);
$pdf->MultiCell(192, 5, utf8_decode('Doy mi consentimiento para una consulta en persona y/o para que mi médico y/o su personal (en adelante, "mi médico") realicen procedimientos médicos y quirúrgicos, ya sea que se considere necesario, electivo o estético, durante el tiempo de la pandemia COVID-19 y posteriores. Entiendo que las consultas en persona y/o que mi procedimiento se realice en este momento, a pesar de mis propios esfuerzos y los de mi médico, pueden aumentar el riesgo de mi exposición al COVID-19. Soy consciente de que la exposición al COVID-19 puede provocar enfermedades graves, terapias intensivas, intubación prolongada y/o asistencia respiratoria, cambios que alteran mi vida e incluso la muerte. También soy consciente de la posibilidad de que el procedimiento en si ya sea que se realice en el consultorio de mi médico o en un hospital, pueda provocar un caso más grave de COVID-19 del que podría haber tenido sin el procedimiento.'), 0, 'J');

$pdf->MultiCell(192, 5, utf8_decode('También entiendo que las consultas en persona y/o que me realicen el procedimiento quirúrgico en este momento aumentan el riesgo de transmisión de COVID-19 a mi médico. Este virus tiene un largo periodo de incubación, puede haber aspectos aún desconocidos de su transmisión, y me doy cuenta de que puedo ser contagioso, ya sea que me hayan hecho una prueba o no o que tenga síntomas. Para reducir la posibilidad de exposición o transmisión de COVID-19 en el consultorio de mi médico, acepto que mi médico implementará procedimientos de control de infecciones con los que debo cumplir, antes, durante y después de mi consulta y/o procedimiento, para mi propia protección como bien como el de mi doctor. Entiendo que mi cooperación es obligatoria, independientemente de si personalmente considero que tales procedimientos COVID-19 y/o medidas preventivas son necesarias.'), 0, 'J');

$pdf->MultiCell(192, 5, utf8_decode('Le he informado a mi médico sobre cualquier prueba COVID-19 que yo o cualquier persona que haya vivido conmigo durante los últimos 14 días haya recibido, así como los resultados de esa prueba, y si me hago la prueba entre ahora y la fecha de mi procedimiento, yo le proporcionaré de inmediato los resultados de esa prueba a mi médico. Entiendo que mi médico puede requerir que me haga la prueba, posiblemente a mi propio costo e independientemente de cualquier prueba previa, y que los resultados de esa prueba deben ser satisfactorios para mi médico, antes de que pueda recibir mi procedimiento.'), 0, 'J');

$pdf->MultiCell(192, 5, utf8_decode('Confirmo que ni yo ni ninguna persona que viva conmigo tiene ninguno de los síntomas de COVID-19 enumerados por los Centros para el Control de Enfermedades https://www.cdc.gov/coronavirus/2019-ncov/downloads/COVID19-symptoms.pdf, sitio web que he consultado; ni yo ni ninguna persona que haya vivido conmigo durante los últimos 14 días ha experimentado alguno de estos síntomas; y que yo y todas las personas que vivieron conmigo durante los últimos 14 días hemos practicado todas las recomendaciones de higiene personal, distanciamiento social y otras recomendaciones de COVID 19 contenidas en todas las órdenes gubernamentales emitidas por mi ciudad y estado. Entiendo que honestamente debo revelar esta información para evitar ponerme a mi yo otros en riesgo.'), 0, 'J');

$pdf->MultiCell(192, 5, utf8_decode('Todos los temas anteriores han sido discutidos conmigo, y todas mis preguntas han sido respondidas a mi entera satisfacción. Al estar completamente informado, acepto el riesgo de exposición a COVID-19 y asumiré el costo de cualquier tratamiento con COVID-19 requerido. Se me ha dado la oportunidad de posponer mi consulta y/o procedimiento en persona hasta que la pandemia COVID-19 sea menos frecuente, pero elijo que mi consulta y/o procedimiento en persona se realicen ahora. Si soy el padre o tutor del paciente, tengo su poder de atención médica He leído este acuerdo de consentimiento informado COVID-19 y estoy autorizado a dar el consentimiento en nombre del paciente.'), 0, 'J');

$pdf->Ln(10);
$pdf->Cell(90, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 0, 'C');

$pdf->SetX(110);

$pdf->Cell(90, 6, utf8_decode($resp), 'B', 0, 'C');

$pdf->Ln(6);
$pdf->Cell(90, 6, utf8_decode('Nombre y Fírma del Paciente/Representante legal'), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(90, 6, utf8_decode('Nombre y Fírma del Testigo/Acompañante'), 0, 0, 'C');

$pdf->Ln(14);
$pdf->MultiCell(192, 5, utf8_decode('La información médica cambia constantemente. Este acuerdo con consentimiento informado COVID-19 establece las recomendaciones actuales, se proporciona solo con fines informativos y no establece un nuevo estándar de atención.'), 0, 'J');

$pdf->Output();
