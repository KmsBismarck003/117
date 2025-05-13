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

    include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 24);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}
    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
 
    $this->Ln(10);
    
    
    $this->Ln(4);
 
    $this->Ln(4);
    
    $this->Ln(4);
    
    $this->Ln(10);
    
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-002'), 0, 1, 'R');
  }
}

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $fecha_ing = $row_dat_ing['fecha'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $id_tratante = $row_dat_ing['id_usua'];
  $tipo_a = $row_dat_ing['tipo_a'];
  $alergias = $row_dat_ing['alergias'];
}


$sqlh = "SELECT * from dat_hclinica where Id_exp = $id_exp";
$rh = $conexion->query($sqlh);

while ($rowh = $rh->fetch_assoc()) {
  $diag_prev = $rowh['diag_prev'];
 
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

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac,p.tip_san, p.folio,p.edad FROM paciente p where p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
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
  $tip_san = $row_pac['tip_san'];
  $folio = $row_pac['folio'];
    $edad = $row_pac['edad'];
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
$pdf->Ln(6);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 6, 'PACIENTE: ', 0, 'L');  
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(115, 5.5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac ) , 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$date=date_create($fecnac);
$pdf->Cell(37, 6, ' FECHA DE NACIMIENTO: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23, 5.5, date_format($date,"d/m/Y"), 'B', 'C');
$pdf->Ln(7.5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 6, 'GENERO: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5.5,  $sexo, 'B', 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(12, 6, ' EDAD: ', 0, 'L');

$pdf->SetFont('Arial', '', 8);

$pdf->Cell(20, 5, utf8_decode($edad), 'B', 'C');


if(isset($num_cam)){
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20.5, 6, utf8_decode(' HABITACIÓN: '),  0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(9, 5.5,  $num_cam, 'B', 'C');
}else{
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20.5, 6, utf8_decode(' HABITACIÓN: '),  0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(9, 5.5, 'S/H ', 'B', 'L');
}
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 6, utf8_decode('EXPEDIENTE: '), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 5.5, utf8_decode($folio), 'B', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 6, utf8_decode('TELÉFONO: '), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30.5, 5.5, utf8_decode($tel), 'B', 0, 'L');
$pdf->Ln(7.5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 6, utf8_decode('ALERGIAS: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(115, 5.5, utf8_decode($alergias), 'B', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, utf8_decode('GRUPO SANGUINEO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30.5, 5.5, utf8_decode($tip_san), 'B', 0, 'L');
$pdf->Ln(7.5);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 6, utf8_decode('DIRECCIÓN: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(175, 5.5, utf8_decode($dir), 'B', 'L');
$pdf->Ln(7.5);

$pdf->SetFont('Arial', '', 8);
$date=date_create($fecha_ing);
$pdf->Cell(35, 6, utf8_decode('FECHA DE INGRESO:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(84.5, 5.5, date_format($date,'d/m/Y'), 'B', 0, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(39, 6, utf8_decode('  HORA DE INGRESO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(34, 5.5,  date_format($date,'H:i a'), 'B',0, 'C');
$pdf->Ln(7);


$d = "SELECT DISTINCT(diag_paciente) as diag_paciente, fecha,id_usua,Id_exp from diag_pac where Id_exp=$id_atencion order by fecha DESC LIMIT 1";
$res = $conexion->query($d);

while ($dr = $res->fetch_assoc()) {
  $diag_paciente = $dr['diag_paciente'];
  $fecha = $dr['fecha'];
  $id_usua1 = $dr['id_usua'];
  $id_exp = $dr['Id_exp'];

$sql_reg_usrs = "SELECT * from reg_usuarios where id_usua=$id_usua1";
$result_reg_usrs = $conexion->query($sql_reg_usrs);
while ($row_reg_usrs = $result_reg_usrs->fetch_assoc()) {
  $user_pred = $row_reg_usrs['pre'];
  $user_papelld = $row_reg_usrs['papell'];
  $user_sapelld = $row_reg_usrs['sapell'];
  $user_nombred = $row_reg_usrs['nombre'];
  $user_cedulad = $row_reg_usrs['cedp'];
}}

$sql_reg_usrt = "SELECT * from reg_usuarios where id_usua=$id_usua";
$result_reg_usrt = $conexion->query($sql_reg_usrt);
while ($row_reg_usrt = $result_reg_usrt->fetch_assoc()) {
  $user_prefijo = $row_reg_usrt['pre'];
  $user_tratante = $row_reg_usrt['papell'];
}


$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, utf8_decode('MÉDICO TRATANTE:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(162.5, 5.5, utf8_decode(' '.$user_prefijo.'. '.$user_tratante), 'B', 'C');
$pdf->Ln(7.5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 6, utf8_decode('MÉDICO QUE REALIZA EL INGRESO:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(142.5, 5.5, utf8_decode(' '.$user_pred.' '.$user_papelld), 'B', 'C');
$pdf->Ln(7.5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 6, utf8_decode('DIAGNÓSTICO DE INGRESO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(153, 5.5, utf8_decode($diag_paciente), 'B', 'C');
$pdf->Ln(6.5);
$pdf->Cell(193, 5.5, utf8_decode(''), 'B', 'L');
$pdf->Ln(7.5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(37, 6, utf8_decode('DIAGNÓSTICO PREVIOS: '), 0, 0, 'L');

if(isset ($diag_prev)){
$pdf->Cell(156, 5.5, utf8_decode($diag_prev), 'B', 'L');
$pdf->Ln(6.5);
$pdf->Cell(193, 5.5, utf8_decode(''), 'B', 'L');
}else{

$diag_prev = ' ' ;

$pdf->Cell(156, 5.5, utf8_decode($diag_prev), 'B', 'L');
$pdf->Ln(6.5);
$pdf->Cell(193, 5.5, utf8_decode(''), 'B', 'L');
}
/*
$pdf->Ln(9);
$pdf->SetFont('Arial', '', 9);
$pdf->SetX(23);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('ORDEN DEL EXPEDIENTE CLINICO'), 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(73, 9.5, utf8_decode('1.- HOJA INICIAL.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('9.- CONSENTIMIENTOS.'), 0, 'C');
$pdf->Cell(68.5, 9.5, utf8_decode('12.- REPORTE MINISTERIO PÚBLICO'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('2.- HOJA FRONTAL.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - C. QUIRÚRGICA.'), 0, 'C');
$pdf->Cell(68.5, 9.5, utf8_decode('13.- HOJA DE AMBULANCIA'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('3.- HISTORIA CLÍNICA.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - C. ANESTESIA.'), 0, 'C');
$pdf->Cell(68.5, 9.5, utf8_decode('14.- HOJA DE INTERNAMIENTO'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('4.- NOTAS DE EVOLUCIÓN.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - C. INFORMADO.'), 0, 'C');
$pdf->Cell(68.5, 9.5, utf8_decode('15.- ALTA VOLUNTARIA'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('   - NOTAS DE INGRESO.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - C. TRANSFUSIÓN SANGUINEA.'), 0, 'C');
$pdf->Cell(68.5, 9.5, utf8_decode('16.- OTROS DOCUMENTOS'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('   - NOTA DE URGENCIA.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - C. ALTO RIESGO.'), 0, 'C');
$pdf->Cell(68.5, 9.5, utf8_decode('17.- PASE DE SALIDA'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('   - NOTAS PREOPERATORIAS.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - C. INTERNAMIENTO.'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(71.5, 9.5, utf8_decode('   - NOTAS POSTOPERATORIAS.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('10.- INDICACIONES MÉDICAS.'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(71.5, 9.5, utf8_decode('   - NOTA PREANESTÉSICA.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('11.- HOJAS DE ENFERMERÍA.'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('   - NOTA POSTOANESTÉSICA.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - H. CURVA TÉRMICA.'), 0, 'C');
$pdf->Cell(68.5, 9.5, utf8_decode('*TODOS LOS DOCUMENTOS VAN'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('5.- ESTUDIOS.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - H. DIÁLISIS PERITÓNEAL.'), 0, 'C');
$pdf->Cell(68.5, 9.5, utf8_decode('ORDENADOS DEL MÁS RECIENTE'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('   - LABORATORIO.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - H. IRRIGACIÓN.'), 0, 'C');
$pdf->Cell(68.5, 9.5, utf8_decode('AL MÁS ANTIGUO'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('   - GABINETE.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - H. TENSIÓN ARTERIAL.'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('6.- HOJA DE TRANSFUSIÓN SANGUÍNEO.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - H. PIEZA QUIRÚRGICA.'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('7.- HOJA DE REGISTRO DE ANESTESIA.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - H. REGISTRO QUIRÚRGICO.'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode('8.- HOJA QUIRÚRGICA.'), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - H. HOJA HOSPITALIZACIÓN.'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode(''), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - H. UCI.'), 0, 'C');
$pdf->Ln(4.5);
$pdf->Cell(73, 9.5, utf8_decode(''), 0, 'C');
$pdf->Cell(66, 9.5, utf8_decode('   - H. URGENCIAS.'), 0, 'C');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(203, 235, 203, 141); //derecha
$pdf->Line(10, 141, 10, 235);//isqierda
$pdf->Line(10, 141, 203, 141); //ARRIBA
$pdf->Line(10, 235, 203, 235); //Abajo

*/


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
      //$pdf->Image('../../imgfirma/' . $firma, 94, 240 , 20);
     if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 240 , 30);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 240 , 30);
}


       $pdf->SetY(264);
      $pdf->Cell(189, 4, utf8_decode($pre . '. ' . $app ), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(190, 4, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(190, 4, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
      
      
      
      
      
      
      
      
 $pdf->Output();
