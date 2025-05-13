<?php

use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
//require('../../fpdf/MultiCellBlt.php');
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
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
    $this->SetFont('Arial', 'B', 6);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('SIMA-001'), 0, 1, 'R');
  }
}

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $fecha_ing = $row_dat_ing['fecha'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $tipo_a = $row_dat_ing['tipo_a'];
}



$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua and id_rol=2";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pre = $row_reg_usrs['pre'];
  $user_papell = $row_reg_usrs['papell'];
  $user_sapell = $row_reg_usrs['sapell'];
  $user_nombre = $row_reg_usrs['nombre'];
  $user_cedula = $row_reg_usrs['cedp'];
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p , dat_ingreso di where p.Id_exp = di.Id_exp and di.id_atencion=$id_atencion";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $id_exp = $row_pac['Id_exp'];
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
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
$pdf->MultiCell(165, 9.5, utf8_decode('HOJA FRONTAL'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 55, 205, 55);
$pdf->Line(8, 55, 8, 280);
$pdf->Line(205, 55, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 6, 'SERVICIO: ', 0, 'L');  
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(132, 6, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y");
$pdf->Cell(13, 6, utf8_decode(' FECHA:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, $fecha_actual, 'B', 1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 6, utf8_decode('EXPEDIENTE: '), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 6, utf8_decode($id_exp), 'B', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(38, 6, ' NOMBRE DEL PACIENTE: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(122, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$date=date_create($fecha_ing);
$pdf->Cell(33, 6, utf8_decode('FECHA DE INGRESO:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, date_format($date,'d/m/Y'), 'B', 0, 'C');


$pdf->SetFont('Arial', '', 8);
$date=date_create($fecnac);
$pdf->Cell(37, 6, ' FECHA DE NACIMIENTO: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, date_format($date,"d/m/Y"), 'B', 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(14, 6, ' EDAD: ', 0, 'L');

$edad=calculaedad($fecnac);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6, utf8_decode($edad), 'B', 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(13, 6, ' SEXO: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6,  $sexo, 'B', 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 6, utf8_decode('DOMICILIO: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(92, 6, utf8_decode($dir), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(21, 6, utf8_decode(' OCUPACIÓN: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 6,  utf8_decode($ocup), 'B', 'L');

if(isset($num_cam)){
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(21, 6, utf8_decode(' HABITACIÓN: '),  0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(7, 6,  $num_cam, 'B', 'C');
}else{
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode(' HABITACIÓN: '),  0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(7, 6, 'S/H ', 'B', 'L');
}

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 8, utf8_decode('FECHA DIAGNÓSTICO'), 1, 0, 'C');
$pdf->Cell(88, 8, utf8_decode('DIAGNÓSTICO'), 1, 0, 'C');
$pdf->Cell(55, 8, utf8_decode('MÉDICO TRATANTE'), 1, 0, 'C');
$pdf->Cell(15, 8, utf8_decode('CÉDULA'), 1, 0, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(8);

$d = "SELECT DISTINCT(diag_paciente) as diag_paciente, fecha,id_usua,Id_exp from diag_pac where Id_exp=$id_atencion";
$res = $conexion->query($d);

while ($dr = $res->fetch_assoc()) {
  $diag_paciente = $dr['diag_paciente'];
  $fecha = $dr['fecha'];
  $id_usua1 = $dr['id_usua'];
 $id_exp = $dr['Id_exp'];
$fecha=date_create($fecha);
$pdf->Cell(35, 15, utf8_decode(date_format($fecha,"d-m-Y H:i:s")), 1, 0, 'C');
$pdf->Cell(88, 15, utf8_decode($diag_paciente), 1, 0, 'C');

$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua1";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pred = $row_reg_usrs['pre'];
  $user_papelld = $row_reg_usrs['papell'];
  $user_sapelld = $row_reg_usrs['sapell'];
  $user_nombred = $row_reg_usrs['nombre'];
  $user_cedulad = $row_reg_usrs['cedp'];
}


$pdf->Cell(55, 15, utf8_decode(' '.$user_pred.' '.$user_papelld.' '.$user_sapelld.' '.$user_nombred), 1, 0,'C');

$pdf->Cell(15, 15, utf8_decode($user_cedulad), 1, 0,'C');
$pdf->Ln(15);
}



$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua";
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
$pdf->Ln(50);


//inicio otro
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


$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(43, 45, 127);
$pdf->SetX(68);
$pdf->Cell(165, 5, utf8_decode('CONSENTIMIENTO BAJO INFORMACIÓN DE
'), 0, 'C');
$pdf->SetY(47);
$pdf->SetX(58.5);
$pdf->Cell(165, 5, utf8_decode('PROCEDIMIENTOS DIAGNÓSTICOS DE ALTO RIESGO
'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);


$pdf->Ln(9);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 205, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(205, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 6,utf8_decode('Metepec, México a '), 0, 'L');  
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d");
$pdf->Cell(50,5, $fecha_actual , 'B', 'L');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("m");
$pdf->Cell(18, 6, utf8_decode(' del mes de'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 5, $fecha_actual, 'B', 0, 'C');

$fecha_actual = date("Y");
$pdf->Cell(8, 6, utf8_decode(' de'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(39, 5, $fecha_actual, 'B', 1, 'C');

$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(13, 6, utf8_decode('Nombre: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(140, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 6, 'Edad: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);

  if($anos > "0" ){
  $pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 5, utf8_decode($anos . ' años' ), 'B', 'C');

}elseif($anos <="0" && $meses>"0"){
     $pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 5, utf8_decode($meses), 'B', 'C');
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    $pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 5, utf8_decode($dias), 'B', 'C');
}
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$date=date_create($fecha_ing);
$pdf->Cell(22, 6, utf8_decode('Identificado con:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(120, 5, date_format($date,'d/m/Y'), 'B', 0, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 6, ' No. de expediente: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23, 5,($id_exp), 'B',0, 'C');


$pdf->Ln(9);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 6, utf8_decode('Dirección: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(130, 5, utf8_decode($dir), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 6, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 5,  utf8_decode($tel), 'B', 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(44, 6, 'Nombre del familiar responsable: ' , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(148, 5, utf8_decode($resp), 'B', 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 6, utf8_decode('Identificado con: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(70, 5, utf8_decode($dir), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 6, utf8_decode(' Representante legal: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 5,  utf8_decode($resp), 'B', 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(6, 6, utf8_decode('Yo: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(137, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 6, utf8_decode('fuí enviado a Médica San isidro por el: '), 0, 0, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(6, 6, utf8_decode('Dr: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(152, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 6, utf8_decode('para que me practique un: '), 0, 0, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(16, 6, utf8_decode('Estudio de: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(135, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');



$pdf->Ln(8);
$pdf->MultiCell(191, 6, utf8_decode('Autorizo al personal médico y técnico para que se me administre contraste por vía sistémica estando consciente que existen posibles riesgos adversos de tipo quimiotóxicos como son náusea y vómito, así como reacción anafilactoide como hipotensión, crisis convulsivas, choque anafilactico o muerte.'), 0, 'J');
$pdf->Ln(2);
$pdf->MultiCell(191, 6, utf8_decode('Excluyo de toda responsabilidad penal y legal al personal médico y técnico de Médica San Isidro por las reacciones de dicho estudio.
'), 0, 'J');

$pdf->Ln(12);
$pdf->SetX(60);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(91, 6, utf8_decode('OTORGO MI CONSENTIMIENTO'), 0,1, 'C');
$pdf->Ln(8);
$pdf->SetX(70);
$pdf->Cell(70, 6, utf8_decode(''), 'B', 0, 'C');
$pdf->Ln(6);
$pdf->Cell(190, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');

$pdf->Ln(20);

$pdf->Cell(90, 6, utf8_decode('TESTIGO'), 0, 0, 'C');
$pdf->Cell(110, 6, utf8_decode('TESTIGO'), 0, 0, 'C');
$pdf->Ln(15);
$pdf->SetX(20);
$pdf->Cell(70, 6, utf8_decode(''), 'B', 0, 'C');

$pdf->SetX(119);
$pdf->Cell(70, 6, utf8_decode(''), 'B', 0, 'C');

$pdf->Ln(6);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');


$pdf->Ln(22);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 6, utf8_decode('QUIEN SE IDENTIFICA CON: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(53, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 6, utf8_decode('QUIEN SE IDENTIFICA CON: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(53, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 9);
$pdf->SetX(70);
$pdf->Cell(70, 6, utf8_decode(''), 'B', 0, 'C');
$pdf->Ln(6);
$pdf->Cell(190, 6, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
/*
PDF CARTA DE CONSENTIMIENTO BAJO INFORMACIÓN
 */

$pdf->Ln(30);

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

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p,dat_ingreso di where p.Id_exp = di.Id_exp and di.id_atencion=$id_atencion";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $id_exp = $row_pac['Id_exp'];
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

function calculaedad1($fechanacimiento)
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


$pdf->SetFont('Arial', 'B', 11);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('CARTA DE CONSENTIMIENTO BAJO INFORMACIÓN'), 0, 'C');


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

$pdf->SetFont('Arial', '', 8);
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

$edad=calculaedad1($fecnac);

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


$pdf->Ln(6);
$pdf->Cell(64, 6, 'Bajo protesta de decir verdad declaro que el / la: ', 0, 'L');
$pdf->Cell(75, 6, utf8_decode($user_pre . ' ' . $user_papell . ' ' . $user_sapell . ' ' . $user_nombre), 'B', 'L');
$pdf->Cell(33, 6, utf8_decode('me ha explicado que mi diagnóstico es : '), 0, 'L');

$pdf->Ln(6);
$pdf->Cell(191, 6, utf8_decode($motivo_atn), 'B', 'L');

$pdf->Ln(6);
$pdf->Cell(190, 6, utf8_decode('y que por tal motivo debe someterme al (los) siguiente (s) procedimiento (s) con fines diagnósticos y/o terapéuticos: '), 0, 'L');
$pdf->Ln(5);

$pdf->Cell(191, 6, utf8_decode($especialidad), 'B', 'L');

$pdf->Ln(6);
$pdf->MultiCell(191, 6, utf8_decode('Entiendo que todo acto médico o diagnóstico de tratamiento sea quirúrgico o no quirúrgico puede ocasionar una serie de complicaciones, mayores o menores, a veces potencialmente serias que incluyen cierto riesgo de muerte y que puede requerir tratamientos complementarios médicos y/o quirúrgicos, que aumenten la estancia hospitalaria. Dichas complicaciones a veces son derivadas directamente de la propia técnica, pero otras dependerán del procedimiento, del estado del paciente, de los tratamientos que ha recibido y de las posibles anomalías anatómicas y/o de la utilización de los equipos médicos. Reconozco que entre los posibles riesgos y complicaciones que pueden surgir se encuentra (n): '), 0, 'J');
$pdf->Ln(2);
$pdf->MultiCell(191, 6, utf8_decode('Sangrado, Hemorragia, Anafilaxia, Infección, Choque, Coma, Perforación, Seroma, Cicatriz patológica y otros.
'), 'B', 'J');


$pdf->Ln(2);
$pdf->Cell(191, 6, utf8_decode('Los probables beneficios esperados son: Esperamos Bueno.'), 0, 'L');

$pdf->Ln(6);
$pdf->Cell(24, 6, utf8_decode('El pronóstico es:  RESERVADO A EVOLUCIÓN DEL TRATAMIENTO'), 0, 'L');
$pdf->Cell(165, 6, utf8_decode(' '), 'B', 'L');
$pdf->Ln(6);
$pdf->MultiCell(191, 6, utf8_decode('Declaro que eh comprendido las explicaciones que se me han facilitado en un lenguaje claro y sencillo, el médico que me atiende me ha permitido realizar todas las observaciones y me he aclarado todas las dudas que le he planteado. También comprendo, que por escrito, en cualquier momento puedo revocar el consentimiento que ahora otorgo. Por ello manifiesto que estoy satisfecho(a) con la información recibida y que comprendo el alcance y los riesgos del procedimiento.
'), 0, 'J');


$pdf->Ln(2);
$pdf->Cell(40, 6, utf8_decode('Del mismo modo designo a: '), 0, 'L');
$pdf->Cell(150, 6, utf8_decode($resp), 'B', 'L');

$pdf->Ln(6);
$pdf->Cell(191, 6, utf8_decode('para que exclusivamente reciba información sobre mi estado de salud, diagnóstico, tratamiento y pronóstico. '), 0, 'L');

$pdf->Ln(6);
$pdf->Cell(191, 6, utf8_decode('En tales condiciones CONSIENTO en forma libre y espontánea y sin ningún tipo de presión en que se me realice: '), 0, 'L');

$pdf->Ln(6);
$pdf->Cell(191, 6, utf8_decode($especialidad), 'B', 'L');

$pdf->Ln(20);
$pdf->Cell(90, 6, utf8_decode($user_pre . ' ' . $user_papell . ' ' . $user_sapell . ' ' . $user_nombre), 'B', 0, 'C');

$pdf->SetX(110);
$pdf->Cell(90, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 0, 'C');

$pdf->Ln(6);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO INFORMANTE'), 0, 0, 'C');

$pdf->Ln(4);
$pdf->Cell(90, 6, utf8_decode($cargp . ' ' . 'CÉD. PROF. ' . $ced_p), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA DEL PACIENTE'), 0, 0, 'C');

$pdf->Ln(20);
$pdf->Cell(90, 6, utf8_decode($resp), 'B', 0, 'C');

$pdf->SetX(110);
$pdf->Cell(90, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 0, 'C');

$pdf->Ln(6);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA DEL TESTIGO'), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA DEL TESTIGO'), 0, 0, 'C');
$pdf->Ln(50);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p,dat_ingreso di where p.Id_exp = di.Id_exp and di.id_atencion=$id_atencion";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $id_exp = $row_pac['Id_exp'];
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  //$Id_exp = $row_pac['Id_exp'];
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

function calculaedad2($fechanacimiento)
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

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('CARTA DE CONSENTIMIENTO BAJO INFORMACIÓN PARA REALIZAR PROCEDIMIENTO ANESTÉSICO'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(30, 52, 192, 52);//labajo
$pdf->Line(30, 41, 30, 52); //li
$pdf->Line(192, 41, 192, 52);//ld
$pdf->Line(30, 41, 192, 41);//la

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 205, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(205, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->Ln(4);

$pdf->SetFont('Arial', '', 8);
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

$edad=calculaedad2($fecnac);

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
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(55, 6, utf8_decode('Carácter de la cirugía o procedimiento: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 6, utf8_decode('Electivo'), 0, 0, 'L');
$pdf->Cell(10, 6, utf8_decode(''), 1, 0, 'L');
$pdf->Cell(15, 6, utf8_decode('Urgente'), 0, 0, 'L');
$pdf->Cell(10, 6, utf8_decode(''), 1, 0, 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 6, utf8_decode('Diagnóstico Preoperatorio: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(152, 6, utf8_decode($motivo_atn), 'B', 'L');
$pdf->Ln(6);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 6, utf8_decode('Cirugía o Procedimiento planeado: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(142, 6, utf8_decode($especialidad), 'B', 'L');
$pdf->Ln(7);

$pdf->MultiCell(193, 4, utf8_decode('De acuerdo con la Norma Oficial Mexicana NOM-004-SSA3-2012 del Expediente Clínico y la Norma Oficial Mexicana NOM-006-SSA3-2011, para la práctica de la anestesiología, es presentado este documento, escrito y signado por el paciente y/o representante legal, así como por dos testigos, mediante el cual acepta, bajo la debida información de los riesgos y los beneficios esperados del procedimiento anestésico. Esta carta se sujetará a las disposiciones sanitarias en vigor y no obliga el médico a realizar y omitir procedimientos cuando ello entrañe un riesgo injustificado para el paciente.'), 0, 'J');
$pdf->Cell(0, 4, utf8_decode('Por consiguiente y en calidad de paciente:'), 0, 'L');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 4, utf8_decode('DECLARO'), 0, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(193, 4, utf8_decode('1. Que cuento con la información suficiente sobre los riesgos y beneficios durante mi procedimiento anestésico y que puede cambiar de acuerdo a mis condiciones físicas, emocionales o lo inherente al procedimiento quirúrgico'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('2. Que todo acto médico implica una serie de riesgos debido a mi estado físico actual, mis antecedentes, tratamientos previos y a la causa que da origen a la intervención quirúrgica, procedimientos de diagnóstico y tratamiento, o una combinación de ambos factores.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('3. Que existe la posibilidad de complicaciones, desde leves hasta severas, pudiendo causar secuelas permanentes e incluso complicaciones severas que lleven al fallecimiento.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('4. Que puedo requerir de tratamientos complementarios que aumenten mi estancia hospitalaria, con la participación de otros servicios o unidades médicas.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('5. Que existe la posibilidad de que mi procedimiento anestésico se retrase e incluso se suspenda por causas propias de la dinámica del procedimiento anestésico o causas de fuerza mayor (URGENCIAS).'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('6. Que se me ha informado que el personal médico de este servicio cuenta con amplia experiencia, con equipo electrónico para mí cuidado y manejo y aun así se pueden presentar complicaciones.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('7. Y que soy responsable de comunicar mi decisión y lo antes informado a mi familia.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('8. En caso de no existir este documento en mi expediente, no se podrá llevar a cabo mi operación.'), 0, 'J');

$pdf->Cell(122, 4, utf8_decode('En virtud de lo anterior, doy mi consentimiento por escrito para que el Médico Anestesiólogo Dr.'), 0, 0, 'L');
$pdf->Cell(70, 4, utf8_decode(''), 'B', 0, 'L');


$pdf->Ln(4);
$pdf->MultiCell(193, 4, utf8_decode('lleve a cabo los procedimientos que considere necesarios para realizar la cirugía o procedimiento médico al que he decidido someterme, habiendo entendido que si ocurren complicaciones en la aplicación de la técnica anestésica, no existe conducta dolosa.'), 0, 'J');

$pdf->Ln(2);
$pdf->Cell(0, 4, utf8_decode('ACEPTO'), 0, 0, 'C');
$pdf->Ln(12);
$pdf->SetX(65);
$pdf->Cell(80, 6, utf8_decode($user_pre . ' ' . $user_papell . ' ' . $user_sapell . ' ' . $user_nombre), 'B', 0, 'C');
$pdf->Ln(6);
$pdf->SetX(65);
$pdf->Cell(80, 6, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO TRATANTE'), 0, 0, 'C');

$pdf->Ln(5);
$pdf->SetX(70);
$pdf->Cell(39, 4, utf8_decode($cargp), 0, 0, 'C');
$pdf->Cell(35, 4, utf8_decode('CÉD. PROF. ' . $ced_p), 0, 0, 'C');


$pdf->Ln(15);
$pdf->SetX(20);
$pdf->Cell(80, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 0, 'C');

$pdf->SetX(110);
$pdf->Cell(80, 6, utf8_decode($resp), 'B', 0, 'C');

$pdf->Ln(6);
$pdf->SetX(20);
$pdf->Cell(80, 6, utf8_decode('NOMBRE Y FIRMA PACIENTE'), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(80, 6, utf8_decode('NOMBRE Y FIRMA DEL REPRESENTANTE LEGAL'), 0, 0, 'C');

$pdf->Ln(15);
$pdf->SetX(20);
$pdf->Cell(80, 6, utf8_decode(''), 'B', 0, 'C');

$pdf->SetX(110);
$pdf->Cell(80, 6, utf8_decode(''), 'B', 0, 'C');

$pdf->Ln(6);
$pdf->SetX(20);
$pdf->Cell(80, 6, utf8_decode('NOMBRE Y FIRMA DEL TESTIGO'), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(80, 6, utf8_decode('NOMBRE Y FIRMA DEL TESTIGO'), 0, 0, 'C');


$pdf->AddPage();


$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(8, 42, 205, 42);
$pdf->Line(8, 42, 8, 280);
$pdf->Line(205, 42, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 4, utf8_decode('POSIBLES COMPLICACIONES EN ANESTESIOLOGÍA'), 0, 0, 'C');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(0, 4, utf8_decode('CUADRO 1'), 0, 0, 'C');

$pdf->Ln(4);
$pdf->Cell(0, 4, utf8_decode('INICIO'), 0, 0, 'C');

$pdf->SetFont('Arial', '', 7);
$pdf->Ln(4);
$pdf->MultiCell(193, 4, utf8_decode('o DOLOR EN LOS SITIOS DE PUNCIÓN (APLICACIÓN DE SOLUCIONES).'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o MULTIPUNCIONES VASCULARES (DIFICULTAD PARA ENCONTRAR VENA ÚTIL PARA APLICAR SOLUCIONES, "MORETONES" POSPUNCIÓN VENOSA.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o EXTRAVASACIÓN DE SOLUCIONES (SALIDA DE SUERO POR LA VENA).'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o ALTERACIONES EN LA PIEL POR EL BRAZALETE DE TOMA DE PRESIÓN ARTERIAL O MATERIAL DE PEGAMENTO (TELA ADHESIVA).'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o EN CASO DE REQUERIR MONITORIZACIÓN MÁS ESPECIALIZADA (INVASIVA) DEBIDO A LA GRAVEDAD DEL PADECIMIENTO, SE UTILIZARÁN OTROS MÉTODOS, COMO SON:'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode(' 1.INSTALACIÓN DE CATÉTER CENTRAL (AL CORAZÓN) PARA MEDIR PRESIÓN VENOSA CENTRAL, CON LA POSIBILIDAD DE LESIONAR ESTRUCTURAS VECINAS COMO SON: NERVIO, ARTERIA, PULMÓN, O PROVOCAR TRASTORNOS CARDIACOS DE RITMO O DE SU PARED.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode(' 2.INSTALACIÓN DE CATÉTER EN ARTERIA PARA LA MEDICIÓN DE GASES SANGUÍNEOS Y PRESIÓN ARTERIAL CONTINUA, PUDIENDO LESIONAR NERVIOS, OBSTRUCCIÓN VASCULAR CON LESIÓN NEUROLÓGICA DE LA EXTREMIDAD.'), 0, 'J');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(0, 4, utf8_decode('CUADRO 2'), 0, 0, 'C');

$pdf->Ln(4);
$pdf->Cell(0, 4, utf8_decode('SEDACIÓN Y VIGILANCIA'), 0, 0, 'C');

$pdf->SetFont('Arial', '', 7);
$pdf->Ln(4);

$pdf->MultiCell(193, 4, utf8_decode('o EXTENSIÓN INSUFICIENTE DE LA INFILTRACIÓN DEL ANESTÉSICO LOCAL (FALLA DEL PROCEDIMIENTO), LO QUE CONDICIONA CAMBIO DE LA TÉCNICA ANESTÉSICA (CUADRO 4).'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o DEPRESIÓN RESPIRATORIA, CAMBIO DE LA TÉCNICA ANESTÉSICA (CUADRO 4).'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o RESPUESTA ADVERSA A LOS MEDICAMENTOS, CAMBIO DE LA TÉCNICA ANESTÉSICA (CUADRO 4).> EXTENSIÓN INSUFICIENTE DE LA INFILTRACIÓN DEL ANESTÉSICO LOCAL (FALLA DEL PROCEDIMIENTO), LO QUE CONDICIONA CAMBIO DE LA TÉCNICA ANESTÉSICA (CUADRO 4).'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o ADICIÓN DE EFECTOS INDESEABLES, PUEDE CAMBIAR LA TÉCNICA ANESTÉSICA.'), 0, 'J');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(0, 4, utf8_decode('CUADRO 3'), 0, 0, 'C');

$pdf->Ln(4);
$pdf->Cell(0, 4, utf8_decode('ANESTESIA REGIONAL'), 0, 0, 'C');

$pdf->SetFont('Arial', '', 7);
$pdf->Ln(4);

$pdf->MultiCell(193, 4, utf8_decode('o ARDOR EN EL SITIO DE LA INFILTRACIÓN.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o EFECTOS ALÉRGICOS DEL ANESTÉSICO LOCAL, DESDE RASH LOCALIZADO, HASTA CHOQUE ANAFILÁCTICO.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o DOLOR EN LA COLUMNA EN LA ZONA DE PUNCIÓN.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o EFECTO INSUFICIENTE DE LA INSTALACIÓN DEL ANESTÉSICO LOCAL (FALLA DEL PROCEDIMIENTO), LO QUE PROVOCA CAMBIO DE TÉCNICA ANESTÉSICA (CUADRO 4). '), 0, 'J');

$pdf->MultiCell(193, 4, utf8_decode('o DAÑO NEURAL, TRANSITORIO O PERMANENTE, RELACIONADO DIRECTAMENTE CON LA AGUJA DE APLICACIÓN DEL ANESTÉSICO LOCAL.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o ESTÍMULO Y/O DAÑO NEURAL, TRANSITORIO O PERMANENTE, RELACIONADO CON LA INSTALACIÓN O PRESENCIA DEL CATÉTER ESPIRAL.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o DOLOR DE CABEZA POSTERIOR A LA PUNCIÓN ACCIDENTAL DE LA DURAMADRE, EL TRATAMIENTO DEL DOLOR ES CON MEDICAMENTO O APLICACIÓN "DE PARCHE HEMÁTICO".'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o DIFUSIÓN NO DESEADA DEL ANESTÉSICO AL ESPACIO SUBDURAL, PUEDE CAMBIAR LA TÉCNICA ANESTÉSICA. '), 0, 'J');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(0, 4, utf8_decode('CUADRO 4'), 0, 0, 'C');

$pdf->Ln(4);
$pdf->Cell(0, 4, utf8_decode('ANESTESIA GENERAL'), 0, 0, 'C');

$pdf->SetFont('Arial', '', 7);
$pdf->Ln(4);
$pdf->MultiCell(193, 4, utf8_decode('o RESPUESTAS ADVERSAS DEL PACIENTE A LOS MEDICAMENTOS APLICADOS PARA INDUCCIÓN ANESTÉSICA Y MANTENIMIENTO QUE LLEVE A LA DECISIÓN DE SUSPENDER LA CIRUGÍA.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o RUPTURA O EXTRACCIÓN DE PIEZAS DENTALES.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o LESIÓN DE LA MUCOSA DE LA BOCA Y/O NARIZ.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o RONQUERA Y/O DOLOR DE LA GARGANTA, POSTERIOR A LA INTUBACIÓN TRAQUEAL.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o IMPOSIBILIDAD PARA COLOCAR EL TUBO EN LA TRÁQUEA.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o POSIBILIDAD DE TRAQUEOSTOMÍA.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o IMPOSIBILIDAD PARA OXIGENAR ADECUADAMENTE AL PACIENTE, CON PROBABILIDAD DE DAÑO ORGÁNICO Y SERIE DE COMPLICACIONES QUE PROVOQUEN EL FALLECIMIENTO.'), 0, 'J');

$pdf->MultiCell(193, 4, utf8_decode('o BRONCOASPIRACIÓN DE MATERIALES CONTENIDOS EN EL ESTÓMAGO.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o INTERNAMIENTO EN TERAPIA INTENSIVA.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o RESPUESTA INADECUADA DE LOS FÁRMACOS UTILIZADOS CON POSIBILIDAD DE DAÑO ORGÁNICO, CEREBRAL Y QUE EN CONJUNTO PUEDAN PROVOCAR EL FALLECIMIENTO.'), 0, 'J');


$pdf->Ln(10);
$pdf->SetX(20);
$pdf->Cell(80, 6, utf8_decode(''), 'B', 0, 'C');

$pdf->SetX(110);
$pdf->Cell(80, 6, utf8_decode(''), 'B', 0, 'C');

$pdf->Ln(6);

$pdf->SetX(20);
$pdf->Cell(80, 6, utf8_decode('NOMBRE Y FIRMA DEL ANESTESIÓLOGO'), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(80, 6, utf8_decode('NOMBRE Y FIRMA DEL PACIENTE / REPRESENTANTE LEGAL'), 0, 0, 'C');
$pdf->Ln(50);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p, dat_ingreso di where p.Id_exp = di.Id_exp and di.id_atencion=$id_atencion";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  $id_exp = $row_pac['Id_exp'];
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


function calculaedad3($fechanacimiento)
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
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
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

$edad=calculaedad3($fecnac);

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

$pdf->Ln(13);
$pdf->MultiCell(192, 5, utf8_decode('La información médica cambia constantemente. Este acuerdo con consentimiento informado COVID-19 establece las recomendaciones actuales, se proporciona solo con fines informativos y no establece un nuevo estándar de atención.'), 0, 'J');
$pdf->Ln(50);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sql_reg_usu = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.id_usua";

$result_reg_usu = $conexion->query($sql_reg_usu);
while ($row_reg_usu = $result_reg_usu->fetch_assoc()) {
  $pre = $row_reg_usu['pre'];
  $papell = $row_reg_usu['papell'];
  $sapell = $row_reg_usu['sapell'];
  $nombre = $row_reg_usu['nombre'];
  $id_exp = $row_reg_usu['Id_exp'];
}

$sql_dat_fin = "SELECT df.deposito, df.dep_l, df.resp, df.dir_resp, df.id_mun, df.tel, df.aval FROM dat_ingreso di, dat_financieros df WHERE di.id_atencion = df.id_atencion and df.id_atencion =$id_atencion";
$result_dat_fin = $conexion->query($sql_dat_fin);

while ($row_dat_fin = $result_dat_fin->fetch_assoc()) {
  $deposito = $row_dat_fin['deposito'];
  $dep_l = $row_dat_fin['dep_l'];
  $resp = $row_dat_fin['resp'];
  $dir_resp = $row_dat_fin['dir_resp'];
  $id_mun = $row_dat_fin['id_mun'];
  $tel = $row_dat_fin['tel'];
  $aval = $row_dat_fin['aval'];
 
}

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $pac_papell = $row_pac['papell'];
  $pac_sapell = $row_pac['sapell'];
  $pac_nom_pac = $row_pac['nom_pac'];
  $pac_dir = $row_pac['dir'];
  $pac_id_edo = $row_pac['id_edo'];
  $pac_id_mun = $row_pac['id_mun'];
  $pac_tel = $row_pac['tel'];
  $pac_fecnac = $row_pac['fecnac'];

}

$sql_mun = "SELECT nombre_m FROM municipios WHERE id_mun = $id_mun";
$result_mun = $conexion->query($sql_mun);

while ($row_mun = $result_mun->fetch_assoc()) {
  $nom_mun = $row_mun['nombre_m'];
}

$sql_mun_pac = "SELECT nombre_m FROM municipios WHERE id_mun = $pac_id_mun";
$result_mun_pac = $conexion->query($sql_mun_pac);

while ($row_mun_pac = $result_mun_pac->fetch_assoc()) {
  $nom_mun_pac = $row_mun_pac['nombre_m'];
}

$sql_edo_pac = "SELECT nombre FROM estados WHERE id_edo = $pac_id_edo";
$result_edo_pac = $conexion->query($sql_edo_pac);

while ($row_edo_pac = $result_edo_pac->fetch_assoc()) {
  $nom_edo_pac = $row_edo_pac['nombre'];
}

function calculaedad4($fechanacimiento)
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

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('CONTRATO DE PRESTACIÓN DE SERVICIOS HOSPITALARIOS'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 55, 205, 55);
$pdf->Line(8, 55, 8, 280);
$pdf->Line(205, 55, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(5);
$pdf->MultiCell(198, 6, utf8_decode('CELEBRADO POR "MÉDICA SAN ISIDRO", Y POR OTRA PARTE EL SR. (A):'), 0, 'J');
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(195, 6, utf8_decode($pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac), 'B', 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, utf8_decode('CON DOMILICIO EN: '), 0, 'L');
$pdf->Cell(165, 6, utf8_decode($pac_dir . ', ' . $nom_edo_pac /*. ',' . $nom_mun_pac*/), 'B', 'L');
$pdf->Ln(6);
$pdf->Cell(25, 6, utf8_decode('EXPEDIENTE: '), 0, 'L');
$pdf->Cell(15, 6, utf8_decode($id_exp),'B', 'L');
$pdf->Cell(20, 6, utf8_decode(' TELÉFONO: '), 0, 'L');
$pdf->Cell(22, 6, utf8_decode($pac_tel), 'B', 'L');
$pdf->Cell(40, 6, utf8_decode(' FECHA DE NACIMIENTO: '), 0, 'L');
$date = date_create($pac_fecnac);
$pdf->Cell(35, 6, utf8_decode(date_format($date,"d/m/Y")), 'B', 'L');
$pdf->Cell(12, 6, ' EDAD: ', 0, 'L');

$edad=calculaedad4($pac_fecnac);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6, utf8_decode($edad), 'B', 'C');

$pdf->Ln(5);
//$pdf->Cell(0, 1, '', 'B');
$pdf->Ln(1);
$pdf->MultiCell(180, 5, utf8_decode('A QUIEN POSTERIORMENTE SE LE DENOMINA "PACIENTE" Y QUE CELEBRAN CONFORME A LAS SIGUIENTES.'), 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->MultiCell(200, 5, utf8_decode('CLÁUSULAS'), 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode('PRIMERA.- "MÉDICA SAN ISIDRO" se obliga a solicitud del "PACIENTE" a proporcionarle los siguientes servicios hospitalarios: cuarto, servicios de enfermería, dieta prescrita por el Médico que atiende al "PACIENTE"'), 0, 'J');
$pdf->MultiCell(195, 5, utf8_decode('SEGUNDA.- El "PACIENTE" se obliga a pagar a "MÉDICA SAN ISIDRO" el importe de los servicios antes mencionados, además de los derivados de Rayos X, Laboratorio, Oncología, Medicinas, Material de Curación, Terapia Intensiva y aquellos que sean solicitados por el Médico del "PACIENTE", cuyos gastos se cargarán en forma adicional en la cuenta respectiva.'), 0, 'J'); 
$pdf->MultiCell(195, 5, utf8_decode('TERCERA.- El "PACIENTE" entrega en este acto a "MÉDICA SAN ISIDRO" en calidad de anticipa la cantidad de $                       pesos en Moneda Nacional y se obliga a hacer pagos diarios por los gastos incurr idos y liquidar el total de la cuenta al ser dado de ata por su Médico, o al retirarse de "MÉDICA SAN ISIDRO" por cualquier momento'), 0, 'J');
$pdf->SetY(115);
$pdf->SetX(160);
$pdf->MultiCell(17, 5, number_format($deposito,2), 'B', 'L');
$pdf->Ln(10);
$pdf->MultiCell(195, 5, utf8_decode('CUARTA.- El "PACIENTE" se obliga a cumplir con el Reglamento interno y demás disposiciones de "MÉDICA SAN ISIDRO" y como esta es una institución abierta al cuerpo Médico lo revela de cualquier responsabilidad médica.'), 0, 'J');
$pdf->MultiCell(195, 5, utf8_decode('QUINTA.- El "PACIENTE" autoriza al Médico Facultativo Dr.'.'                                                                                           '.' y a sus colaboradores para que prescriban, lleven a cabo el tratamiento Médico y/o quirúrgico que requiera su persona; así como la administración de medicamentos y anestésicos prescritos.'), 0, 'J');
$pdf->SetY(138);
$pdf->SetX(88);
$pdf->Cell(75,6, utf8_decode($papell.' '.$sapell.' '.$nombre), 'B','L');
$pdf->Ln(15);
$pdf->MultiCell(195, 5, utf8_decode('SEXTA.- Ambas partes convienen que en caso de que el "PACIENTE" este incapacitado para firmar este contrato, lo hará a su nombre y representación la persona que se responsabilice en el cumplimiento de las obligaciones anteriormente establecidas.'), 0, 'J');
$pdf->Ln(1);

$fecha_actual = date("d/m/Y");

$pdf->MultiCell(200, 5, utf8_decode('Metepec, México a ' . $fecha_actual), 0, 'C');
$pdf->Ln(1);
$pdf->Cell(67, 6, utf8_decode('MÉDICA SAN ISIDRO METEPEC'), 0, 0, 'C');
$pdf->Cell(65, 6, utf8_decode('PACIENTE'), 0, 0, 'C');
$pdf->Cell(65, 6, utf8_decode('RESPONSABLE'), 0, 0, 'C');
$pdf->Ln(6);
$pdf->SetX(40);
$pdf->Cell(140, 6, utf8_decode($pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac),0, 0, 'C');
$pdf->SetX(145);
$pdf->Cell(55, 6, utf8_decode($resp), 0, 0, 'C');
$pdf->Ln(6);
$pdf->SetX(15);
$pdf->Cell(60, 6, utf8_decode('NOMBRE Y FIRMA'), 'T', 0, 'C');
$pdf->SetX(85);
$pdf->Cell(50, 6, utf8_decode('NOMBRE Y FIRMA'), 'T', 0, 'C');
$pdf->SetX(145);
$pdf->Cell(50, 6, utf8_decode('NOMBRE Y FIRMA'), 'T', 0, 'C');

$pdf->Ln(8);
$pdf->Cell(30, 6, utf8_decode('NÚMERO'), 1, 0, 'C');
$pdf->Cell(80, 6, utf8_decode('LUGAR DE EXPEDICIÓN'), 1, 0, 'C');
$pdf->Cell(40, 6, utf8_decode('FECHA'), 1, 0, 'C');
$pdf->Cell(40, 6, utf8_decode('BUENO POR'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->Cell(30, 8, utf8_decode('1'), 1, 0, 'C');
$pdf->Cell(80, 8, utf8_decode('MÉDICA SAN ISIDRO METEPEC'), 1, 0, 'C');
$pdf->Cell(40, 8, date('d/m/Y'), 1, 0, 'C');
$pdf->Cell(40, 8, utf8_decode('$50,000.00'), 1, 0, 'C');
$pdf->Ln(9);
$pdf->MultiCell(190, 5, utf8_decode('DEBO (EMOS) Y PAGARE (EMOS) SIN PRETEXTO ESTE PAGARE EN EL LUGAR Y FECHA CITADAS DONDE ELIJA EL TENEDOR EL DÍA DE SU VENCIMENTO A LA ORDEN DE MÉDICA SAN ISIDRO VENECIA DE TOLUCA SA DE CV EL DÍA ' . date('d/m/Y')), 0, 'J');
$pdf->Cell(35, 6, utf8_decode('LA CANTIDAD DE: '), 0, 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(150, 6, utf8_decode('CINCUENTA MIL PESOS 00/100 M.N.'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(1);
$pdf->MultiCell(190,3, utf8_decode('VALOR RECIBIDO A MI (NUESTRA) ENTERA SATISFACCIÓN, ESTE PAGARE FORMA PARTE DE UNA SERIE NUMERADA DEL 1  AL 1 Y TODOS ESTÁN SUJETOS A LA CONDICIÓN DE QUE NO PAGARSE CUALQUIERA DE ELLOS A SU VENCIMIENTO, SERÁN EXIGIBLES TODOS LOS QUE LE SIGUEN EN NÚMERO, ADEMÁS DE LOS YA VENCIDOS DE ACUERDO AL ART. 79 DE LA LEY GENERAL DE TÍTULOS Y OPERACIONES DE CRÉDITO, CAUSARÁN INTERESES MORATORIOS DE % MES O FRACCIÓN PAGADERO JUNTAMENTE CON EL PRINCIPAL, DICHOS INTERESES SE CAUSARÁN SOBRE EL CAPITAL INSOLUTO, CONFORME A LO DISPUESTO POR EL ART. 152 INCISO I,II,III,IV DE LA LEY GENERAL DE TÍTULOS Y OPERACIONES DE CRÉDITO'), 0, 'J');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(1);
$pdf->Cell(20, 6, utf8_decode(''), 0, 0, 'C');
$pdf->Cell(60, 6, utf8_decode('NOMBRE Y DATOS DEL DEUDOR'), 0, 0, 'C');
$pdf->Cell(55, 6, utf8_decode('AVAL'), 0, 0, 'C');
$pdf->SetX(150);
$pdf->Cell(55, 6, utf8_decode('DEUDOR'), 0, 0, 'C');

$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode('NOMBRE: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(30);
$pdf->MultiCell(55, 6, utf8_decode($resp), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode('DOMICILIO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(55, 6, utf8_decode($pac_dir), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(20, 6, utf8_decode('MUNICIPIO: '), 0, 0, 'L');
//$pdf->SetFont('Arial', 'U', 8);
//$pdf->Cell(60, 6, utf8_decode($nom_mun), 0, 0, 'L');
$pdf->SetX(90);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(55, 6, utf8_decode(" "), 0, 0, 'C');
$pdf->SetX(150);
$pdf->Cell(55, 6, utf8_decode($resp), 0, 0, 'C');
$pdf->Ln(6);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode('TELÉFONO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(55, 6, utf8_decode($pac_tel), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(55, 6, utf8_decode('NOMBRE Y FIRMA '), 'T', 0, 'C');
$pdf->SetX(150);
$pdf->Cell(55, 6, utf8_decode('NOMBRE Y FIRMA '), 'T', 0, 'C');


$pdf->Ln(6);
/*
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetX(60);
$pdf->Cell(100, 6, utf8_decode('AVAL'), 0, 0, 'C');
$pdf->Ln(26);
$pdf->SetX(60);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(100, 6, utf8_decode($aval), 'T', 'C');
$pdf->SetX(60);
$pdf->Cell(100, 6, utf8_decode('NOMBRE Y FIRMA '), 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetX(60);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(100, 6, utf8_decode('DEUDOR'), 0, 0, 'C');
$pdf->Ln(26);
$pdf->SetX(60);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(100, 6, utf8_decode($resp), 'T', 'C');
$pdf->SetX(60);
$pdf->Cell(100, 6, utf8_decode('NOMBRE Y FIRMA '), 0, 0, 'C');
*/
$pdf->Ln(50);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $fecha_ing = $row_dat_ing['fecha'];
  $id_usua = $row_dat_ing['id_usua'];
  $tipo_a = $row_dat_ing['tipo_a'];
}



/*$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p where p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);*/

$sql_pac = "SELECT * FROM paciente p ,dat_ingreso di where p.Id_exp = di.Id_exp and di.id_atencion=$id_atencion";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  
  $sexo = $row_pac['sexo'];
  $id_exp = $row_pac['Id_exp'];
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

function calculaedad5($fechanacimiento)
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


$sql_hab = "SELECT * from cat_camas where id_atencion=$id_atencion";
$result_hab = $conexion->query($sql_hab);

while ($row_hab = $result_hab->fetch_assoc()) {
  $numcam = $row_hab['num_cama'];
  $tipo = $row_hab['tipo'];
}

if(isset($numcam)){
 $numcam=$numcam;
}else{
  $numcam='SIN CAMA';
}

$sql_fin = "SELECT * from dat_financieros where id_atencion=$id_atencion";
$result_fin = $conexion->query($sql_fin);

while ($row_fin = $result_fin->fetch_assoc()) {
  $deposito = $row_fin['deposito'];
  $metodo_pago = $row_fin['banco'];
  $dep_l=$row_fin['dep_l'];
  $aval=$row_fin['aval'];
  $usuario=$row_fin['id_usua'];
}

$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$usuario";
$result_reg_usrs = $conexion->query($sql_reg_usrs);

while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pre = $row_reg_usrs['pre'];
  $user_papell = $row_reg_usrs['papell'];
  $user_sapell = $row_reg_usrs['sapell'];
  $user_nombre = $row_reg_usrs['nombre'];
}


$fecha_actual = date("d-m-Y H:i:s");

 explode("-", $fecha_actual);
 $ano  = date("Y") ;
  $mes= date("m") ;
  $dia  = date("d") ;

   if ($mes==1) {
    $mes='ENERO';
  }

 if ($mes==2) {
    $mes='FEBRERO';
  }
   if ($mes==3) {
    $mes='MARZO';
  }
 if ($mes==4) {
    $mes='ABRIL';
  }
  if ($mes==5) {
    $mes='MAYO';
  }
   if ($mes==6) {
    $mes='JUNIO';
  }
   if ($mes==7) {
    $mes='JULIO';
  }
   if ($mes==8) {
    $mes='AOSTO';
  }
   if ($mes==9) {
    $mes='SEPTIEMBRE';
  }
   if ($mes==10) {
    $mes='OCTUBRE';
  }
   if ($mes==11) {
    $mes='NOVIEMBRE';
  }
   if ($mes==12) {
    $mes='DICIEMBRE';
  }

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('DEPÓSITO'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 55, 205, 55);
$pdf->Line(8, 55, 8, 280);
$pdf->Line(205, 55, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->SetFont('Arial', '', 8);


$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 6, 'SERVICIO: ', 0, 'L');  
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(175, 6, utf8_decode($tipo_a), 'B', 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 6, utf8_decode('EXPEDIENTE: '), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 6, utf8_decode($id_exp), 'B', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(38, 6, ' NOMBRE DEL PACIENTE: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(122, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$date=date_create($fecha_ing);
$pdf->Cell(33, 6, utf8_decode('FECHA DE INGRESO:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, date_format($date,'d/m/Y'), 'B', 0, 'C');


$pdf->SetFont('Arial', '', 8);
$date=date_create($fecnac);
$pdf->Cell(37, 6, ' FECHA DE NACIMIENTO: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, date_format($date,"d/m/Y"), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(14, 6, ' EDAD: ', 0, 'L');

$edad=calculaedad5($fecnac);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6, utf8_decode($edad), 'B', 0, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(13, 6, ' SEXO: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6,  $sexo, 'B', 0, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(6);
$pdf->Cell(25, 6, utf8_decode('DIAGNÓSTICO: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(125, 6,$motivo_atn, 'B', 'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 6, utf8_decode('MÉTODO DE PAGO : '), 0, 'L');
$pdf->SetX(50);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(58, 6, $metodo_pago, 'B', 'L');

$pdf->SetX(110);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 6, 'LA CANTIDAD DE : $', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(58, 6, number_format($deposito,2), 'B', 'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 6, 'CANTIDAD CON LETRA: ', 0, 'L');
$pdf->SetX(50);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(150, 6,$dep_l, 'B', 'L');

$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 5, utf8_decode('TOLUCA, MÉXICO A '. $dia.' '.$mes.' '.$ano ), 0, 1, 'C');

$pdf->Ln(6);
$pdf->SetX(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 6, 'DEPOSITA ', 0, 0, 'C');
$pdf->SetX(140);
$pdf->Cell(60, 6, 'RECIBE ', 0, 0, 'C');
$pdf->Ln(15);
$pdf->Cell(60, 4, '', 'B', 0, 'C');
$pdf->SetX(140);
$pdf->Cell(60, 4, '', 'B', 0, 'C');
$pdf->Ln(6);
$pdf->SetX(10);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 6, $aval, 0, 0, 'C');
$pdf->SetX(140);
$pdf->Cell(60, 6, ' '.$user_pre.' '.$user_papell.' '.$user_sapell.' '.$user_nombre, 0, 0, 'C');
$pdf->Ln(250);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sql_reg_usu = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp, di.tipo_a FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.id_usua";

$result_reg_usu = $conexion->query($sql_reg_usu);
while ($row_reg_usu = $result_reg_usu->fetch_assoc()) {
  $pre = $row_reg_usu['pre'];
  $papell = $row_reg_usu['papell'];
  $sapell = $row_reg_usu['sapell'];
  $nombre = $row_reg_usu['nombre'];
  $id_exp = $row_reg_usu['Id_exp'];
   $tipo_a = $row_reg_usu['tipo_a'];
}

$sql_pac = "SELECT p.*, di.*  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $id_exp = $row_pac['Id_exp'];
  $pac_papell = $row_pac['papell'];
  $pac_sapell = $row_pac['sapell'];
  $pac_nom_pac = $row_pac['nom_pac'];
  $pac_dir = $row_pac['dir'];
  $pac_id_edo = $row_pac['id_edo'];
  $pac_id_mun = $row_pac['id_mun'];
  $pac_tel = $row_pac['tel'];
  $pac_fecnac = $row_pac['fecnac'];
  $alergias = $row_pac['alergias'];
  $motivo_atn = $row_pac['motivo_atn'];
  $fecha = $row_pac['fecha'];
  $tip_san = $row_pac['tip_san'];
}
function calculaedad6($fechanacimiento)
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

$pdf->Ln(30);

$pdf->SetFont('Arial', 'B', 18);
$pdf->SetTextColor(43, 45, 127);
$pdf->Cell(0, 20, utf8_decode('FICHA DE IDENTIFICACIÓN'), 0, 0, 'C');
$pdf->SetFont('Arial', '', 17);

$pdf->Ln(20);
$pdf->SetX(20);
$pdf->Cell(80, 16, utf8_decode('EXP: ' . ' ' . $id_exp . ' ' .'            NOMBRE:   ' . $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac), 0, 1, 'L');

$pdf->SetX(20);
$pdf->Cell(75, 16, utf8_decode('FECHA DE NACIMIENTO:'), 0, 0, 'L');
$fecnac=date_create($pac_fecnac);
$pdf->MultiCell(150, 16, utf8_decode(date_format($fecnac,"d-m-Y")), 0, 'L');

$pdf->SetX(20);
$pdf->Cell(75, 16, utf8_decode('EDAD:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode(calculaedad6($pac_fecnac)), 0, 'L');


$pdf->SetX(20);
$pdf->Cell(75, 16, utf8_decode('MÉDICO:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($pre . ' ' . $papell . ' ' . $sapell . ' ' . $nombre), 0, 'L');

$pdf->SetX(20);
$pdf->Cell(75, 16, utf8_decode('SERVICIO:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($tipo_a), 0, 'L');

$pdf->SetX(20);
$pdf->Cell(75, 16, utf8_decode('DX:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($motivo_atn), 0, 'L');

$pdf->SetX(20);
$pdf->Cell(75, 16, utf8_decode('ALERGIAS:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($alergias), 0, 'L');

$pdf->SetX(20);
$pdf->Cell(75, 16, utf8_decode('FECHA DE INGRESO:'), 0, 0, 'L');
$fecha_ing=date_create($fecha);
$pdf->MultiCell(150, 16, utf8_decode(date_format($fecha_ing,"d-m-Y")), 0, 'L');

$pdf->SetX(20);
$pdf->Cell(75, 16, utf8_decode('TIPO DE SANGRE:'), 0, 0, 'L');
$pdf->MultiCell(150, 16, utf8_decode($tip_san), 0, 'L');
$pdf->Ln(50);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 $pdf->Output();
