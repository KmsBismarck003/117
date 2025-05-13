<?php

use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$medico = @$_POST['medico'];
$estudios = @$_POST['estudios'];
$diagnostico_pdf = @$_POST['diagnostico_pdf'];
$actos = @$_POST['actos'];
$trat = @$_POST['trat'];
$tratquir = @$_POST['tratquir'];
$ries = @$_POST['ries'];

$acto = @$_POST['acto'];
$reporte = @$_POST['reporte'];
$agencia = @$_POST['agencia'];
$persona = @$_POST['persona'];
mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {

  include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 9, 48, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}

   $this->Ln(32);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
     $this->Cell(0, 10, utf8_decode('MAC-12-07'), 0, 1, 'R');
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

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac, p.edociv,p.loc, p.folio FROM paciente p where p.Id_exp = $id_exp";
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
   $edociv = $row_pac['edociv'];
   $loc = $row_pac['loc'];
   $folio = $row_pac['folio'];
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

///inicio bisiesto



function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}

$fecha_actual = date("Y-m-d");
$fecha_nac=$fecnac;
$fecha_de_nacimiento =strval($fecha_nac);

// separamos en partes las fechas
$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
$array_actual = explode ( "-", $fecha_actual );

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

//ajuste de posible negativo en $días
if ($dias < 0)
{
    --$meses;

    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
    switch ($array_actual[1]) {
           case 1:     $dias_mes_anterior=31; break;
           case 2:     $dias_mes_anterior=31; break;
           case 3:     
               if (bisiesto($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
               
           case 4:     $dias_mes_anterior=31; break;
           case 5:     $dias_mes_anterior=30; break;
           case 6:     $dias_mes_anterior=31; break;
           case 7:     $dias_mes_anterior=30; break;
           case 8:     $dias_mes_anterior=31; break;
           case 9:     $dias_mes_anterior=31; break;
           case 10:     $dias_mes_anterior=30; break;
           case 11:     $dias_mes_anterior=31; break;
           case 12:     $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

//echo "<br>Tu edad es: $anos años con $meses meses y $dias días";

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

$sql_mun2 = "SELECT nombre FROM estados WHERE id_edo = $id_edo";
$result_mun2 = $conexion->query($sql_mun2);

while ($row_mun2 = $result_mun2->fetch_assoc()) {
  $nom_es = $row_mun2['nombre'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('NOTIFICACIÓN A MINISTERIO PÚBLICO'), 0, 'C');


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
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 7);

$fecha_actual = date("d/m/Y H:s");
$pdf->Cell(17, 5.5, utf8_decode('Fecha y hora:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(67, 5, $fecha_actual, 'B', 0, 'L');

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=$id_atencion") or die($conexion->error);
                    while ($f1 = mysqli_fetch_array($resultado1)) {
                        $ocup=$f1['ocup'];
                        $resp=$f1['resp'];
                        $paren=$f1['paren'];
                        $id_exp=$f1['Id_exp'];
                        $pac_fecnac = $f1['fecnac'];
                      }
$date3=date_create($fecha_ing);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(22, 5.5, utf8_decode('Fecha de ingreso:'),0 , 0, 'L');
$pdf->Cell(86, 5, date_format($date3, "d/m/Y"), 'B', 0, 'L');
$pdf->Ln(7);

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(26, 5.5, 'Nombre del paciente:', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(166, 5, utf8_decode($nom_pac . ' ' . $papell . ' ' . $sapell) , 'B', 'C');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(9, 5.5, 'Edad: ', 0, 'L');
if($anos > "0" ){
  $pdf->SetFont('Arial', '', 7);
$pdf->Cell(50, 5, utf8_decode($anos . ' años' ), 'B', 'C');
}elseif($anos <="0" && $meses>"0"){
     $pdf->SetFont('Arial', '', 7);
$pdf->Cell(50, 5, utf8_decode($meses), 'B', 'C');
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    $pdf->SetFont('Arial', '', 7);
$pdf->Cell(50, 5, utf8_decode($dias), 'B', 'C');
}

$pdf->Cell(12, 5.5, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(38, 5,  $sexo, 'B', 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(27, 5.5, 'Fecha de nacimiento: ', 0, 'L'); 
$pdf->SetFont('Arial', '', 7);
$date=date_create($fecnac);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(56, 5, date_format($date,"d/m/Y"), 'B', 'C');
$pdf->Ln(7);
if(isset($num_cam)){
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 5.5, utf8_decode('Habitación: '),  0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(95, 5,  $num_cam, 'B', 'C');
}else{
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 5.5, utf8_decode('Habitación: '),  0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(95, 5, 'S/H ', 'B', 'L');
}

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(21, 5.5, 'No. expediente: ', 0, 'L');

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(61, 5, utf8_decode($folio), 'B', 1, 'L');


$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(190, 6, utf8_decode('Acto notificado'), 0, 0, 'C');
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(10, 86, 202, 86); //ARRIBA
$pdf->Line(10, 86.1, 10, 93); //IZQ
$pdf->Line(202, 86.1, 202, 93); //DER
$pdf->Line(10, 93, 202, 93); //ABAJO
$pdf->Ln(8);
$pdf->Cell(10, 5.5, '', 'C');
$pdf->MultiCell(170, 5, utf8_decode($acto),'B', 'C');
$pdf->Ln(6);

$pdf->Cell(21, 6, utf8_decode('No. de reporte:'), 0, 'L');
$pdf->Cell(159, 5, utf8_decode($reporte), 'B', 'L');
$pdf->Ln(7);

$pdf->Cell(61, 6, utf8_decode('Agencia del ministerio público a la que notifica:'), 0, 'L');
$pdf->Cell(119, 5, utf8_decode($agencia), 'B', 'L');

$pdf->Ln(7);

$pdf->Cell(41, 6, utf8_decode('Persona que recibe el reporte:'), 0, 'L');
$pdf->Cell(139, 5, utf8_decode($persona), 'B', 'L');

$pdf->Sety(-50);
$pdf->SetX(58);
$pdf->Cell(90, 6, utf8_decode($user_pre . ' ' . $user_papell), 'B', 0, 'C');
$pdf->Ln(5);
$pdf->SetX(58);
$pdf->Cell(90, 6, utf8_decode($cargp . ' ' . $ced_p), 0, 0, 'C');
$pdf->Ln(3.5);


$pdf->SetX(57);
$pdf->Cell(90, 6, utf8_decode('Nombre completo, cédula profesional y firma del médico que realiza la notificación'), 0, 0, 'C');

$pdf->Output();
