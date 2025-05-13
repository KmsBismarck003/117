<?php
//use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';


$id_atencion = @$_GET['id_atencion'];
$id_exp = @$_GET['id_exp'];
$id_datfin=@$_GET['id_datfin'];
//$id_usua=@$_GET['id_usua'];
include "conexionbdf.php";

mysqli_set_charset($conexion, "utf8");


class PDF extends FPDF
{
    
  function Header()
  {


   $id_atencion = @$_GET['id_atencion'];
   include "conexionbdf.php";
   
   $resultadof= $conexion->query("SELECT * from gen_factura where id_atencion='$id_atencion'") or die($conexion->error);
while($ff = mysqli_fetch_array($resultadof)){
      $serie = $ff['serie'];
  $folio = $ff['folio'];
  $fecha = $ff['fecha'];
  $reg_fiscal = $ff['reg_fiscal'];
  $rfc = $ff['rfc'];
  $uso_cfdi = $ff['uso_cfdi'];
$tip_cfdi = $ff['tip_cfdi'];
$metodo_pago = $ff['metodo_pago'];
$forma_pago = $ff['forma_pago'];
}

$sql_dat_ingca = "SELECT * from comprobantes where id_atencion = $id_atencion";
$result_dat_ingca = $conexion->query($sql_dat_ingca);
while ($row_dat_ingca= $result_dat_ingca->fetch_assoc()) {
    $cadenaor=$row_dat_ingca['cadenaor'];
     $fechatim=$row_dat_ingca['fecha'];
     
     $uuid=$row_dat_ingca['uuid'];
     $nocertificado=$row_dat_ingca['nocertificado'];
     $sellocfd=$row_dat_ingca['sellocfd'];
     $sellosat=$row_dat_ingca['sellosat'];
     
      $version=$row_dat_ingca['version'];
      $rfc_receptor=$row_dat_ingca['rfc_receptor'];
     
}
 
$sql_compl = "SELECT * from Complemento where id_atencion = $id_atencion";
$result_comple = $conexion->query($sql_compl);
while ($row_com= $result_comple->fetch_assoc()) {
    
     $fecha=$row_com['fecha'];
     $bancoor=$row_com['bancoor'];
     $cuentaor=$row_com['cuentaor'];
     $montoant=$row_com['montoant'];
     $saldoant=$row_com['saldoant'];
     $noparcialidad=$row_com['noparcialidad'];
     $comentario=$row_com['comentario'];
     $serie=$row_com['serie'];
     $folio=$row_com['folio'];
     $moneda=$row_com['moneda'];
     $formapago=$row_com['formapago'];
     $objetoimp=$row_com['objetoimp'];
     $id_documento=$row_com['id_documento'];
     $clave_unidad=$row_com['clave_unidad'];
     $unidad=$row_com['unidad'];
     $codigo=$row_com['codigo'];
}

    $this->Image('../../imagenes/SI.PNG', 3, 10, 50, 17);
    $this->SetFont('Arial', 'B', 9);
    $this->Cell(42.5, 8, '', 0, 0, 'C');
    $this->Cell(17.5, 8, 'EMISOR:', 0, 0, 'C');
    $this->SetFont('Arial', '', 9);
    $this->Cell(1, 8, 'CLINICA MEDICA SI SC', 0, 0, 'L');
    $this->Ln(4);
    $this->SetFont('Arial', 'B', 9);
    $this->Cell(36, 8, '', 0, 0, 'C');
    $this->Cell(24.5, 8, 'RFC:', 0, 0, 'C');
    $this->SetFont('Arial', '', 9);
    $this->Cell(1, 8, 'CMS1501012H9', 0, 0, 'L');

 $this->Ln(4);
    $this->SetFont('Arial', 'B', 9);
    $this->Cell(44, 8, '', 0, 0, 'C');
    $this->Cell(30, 8, 'REGIMEN FISCAL: ', 0, 0, 'C');
     $this->SetFont('Arial', '', 9);
        $this->Cell(30, 8, $reg_fiscal, 0, 0, 'L');
        
$this->Ln(5.5);
    $this->SetFont('Arial', 'B', 9);
$this->Cell(43.5, 6, utf8_decode(""),0, 'C');
$this->Cell(22, 6, utf8_decode("RECEPTOR:"),0, 'L');
    $this->SetFont('Arial', '', 9);
$this->Cell(22, 6, utf8_decode($rfc_receptor),0, 'L');

$this->Ln(5);
$this->SetFont('Arial', 'B', 9);
$this->Cell(43.5, 6, utf8_decode(""),0, 'C');
$this->Cell(10, 6, utf8_decode("RFC:"),0, 'C');
$this->SetFont('Arial', '', 9);
$this->Cell(21, 6, utf8_decode($rfc),0, 'L');




$this->SetY(4);
 $this->SetFont('Arial', 'B', 13);
 $this->SetFillColor(155, 194, 255);
 $this->Cell(135, 8, utf8_decode(''), 0, 0, 'C');
$this->Cell(60, 6, utf8_decode('Médica San Isidro'), 0, 0, 'C',True);
$this->Ln(6);
$this->SetFont('Arial', 'B', 9);
$this->Cell(140, 8, utf8_decode(""), 0, 0, 'C');
$this->Cell(18, 8, utf8_decode('FACTURA:' . $serie . ' ' . $folio), 0, 0, 'C');
$this->Cell(5, 8, utf8_decode(""), 0, 0, 'C');
$this->Cell(35, 8, utf8_decode('Versión: ' . '4.0' ), 0, 0, 'C');

$this->Ln(11);
$this->SetFont('Arial', 'B', 9);
$this->Cell(142.4, 8, utf8_decode(""), 0, 0, 'C');
$this->Cell(13, 6, utf8_decode("LUGAR: "),0, 'C');
$this->SetFont('Arial', '', 9);
$this->Cell(10, 6, utf8_decode("52140"),0, 'C');
$this->Ln(5);

$this->SetFont('Arial', 'B', 9);
$this->Cell(142.4, 8, utf8_decode(""), 0, 0, 'C');
$this->Cell(13, 6, utf8_decode("FECHA: "),0, 'C');
$this->SetFont('Arial', '', 9);
$fec=date_create($fecha);
$this->Cell(10, 6, utf8_decode(date_format($fec,'d/m/Y H:i:s a')),0, 'C');


$this->Ln(9);

if($uso_cfdi=="G03"){
    $usoc="GASTOS EN GENERAL";
}else if($uso_cfdi=="D02"){
    $usoc="GASTOS MÉDICOS POR INCAPACIDAD O DISCAPACIDAD";
}else if($uso_cfdi=="D01"){
    $usoc="HONORARIOS MÉDICOS, DENTALES Y GASTOS HOSPITALARIOS";
}else if($uso_cfdi=="CP01"){
    $usoc="PAGOS";
}

$this->SetFont('Arial', 'B', 9);
$this->Cell(18, 6, utf8_decode("USO CFDI:"),0, 'C');
$this->SetFont('Arial', '', 8);
$this->Cell(124.5, 6, utf8_decode($uso_cfdi . " - " .$usoc),0, 'L');

$this->SetFont('Arial', 'B', 9);
$this->Cell(20, 6, utf8_decode("TIPO CFDI:"),0, 'C');
$this->SetFont('Arial', '', 9);
if ($tip_cfdi=="I") {
  $tip_cfdi="I -INGRESO";
}else if ($tip_cfdi=="E") {
  $tip_cfdi="E -EGRESO";
}else if ($tip_cfdi=="T") {
  $tip_cfdi="T -TRASLADO";
}else if ($tip_cfdi=="N") {
  $tip_cfdi="N -NOMINA";
}else if ($tip_cfdi=="P") {
  $tip_cfdi="P -PAGO";
}

$this->Cell(37, 6, utf8_decode($tip_cfdi),0, 'C');
$this->SetFont('Arial', 'B', 8);
$this->Ln(5);
$this->Cell(122, 6, utf8_decode(""),0, 'C');
$this->Cell(22, 6, utf8_decode("FOLIO FISCAL: "),0, 'C');
$this->SetFont('Arial', '', 8);
$this->Cell(10, 6, utf8_decode($uuid),0, 'C');


include '../../conexionbd.php';

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $pac_papell = $row_pac['papell'];
  $pac_sapell = $row_pac['sapell'];
  $pac_nom_pac = $row_pac['nom_pac'];
  
}
$this->Ln(6);

$this->SetFont('Arial', 'B', 9);
$this->Cell(20, 6, utf8_decode("PACIENTE:"),0, 'C');
$this->SetFont('Arial', '', 9);
$this->Cell(45, 6, utf8_decode($pac_nom_pac. ' ' .$pac_papell. ' ' .$pac_sapell),0, 'L');

include "conexionbdf.php";


$this->SetFont('Arial', 'B', 8);
$this->Cell(57.3, 6, utf8_decode(""),0, 'C');
$this->Cell(27, 6, utf8_decode("No. CERTIFICADO: "),0, 'C');
$this->SetFont('Arial', '', 8);
$this->Cell(10, 6, utf8_decode($nocertificado),0, 'L');


   $this->SetDrawColor(0, 0, 0);
    $this->Line(69, 7, 140, 7);
    $this->Line(69, 8, 140, 8);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
     $this->Cell(0, 10, utf8_decode('Este documento es una representación impresa de un CFDI'), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
  }
}
include "conexionbdf.php";
$sql_dat_ing = "SELECT * from gen_factura where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);
while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $serie= $row_dat_ing['serie'];
  $folio = $row_dat_ing['folio'];
  $fecha = $row_dat_ing['fecha'];
  $reg_fiscal = $row_dat_ing['reg_fiscal'];
  $rfc = $row_dat_ing['rfc'];
  $uso_cfdi = $row_dat_ing['uso_cfdi'];
$tip_cfdi = $row_dat_ing['tip_cfdi'];
$metodo_pago = $row_dat_ing['metodo_pago'];
$forma_pago = $row_dat_ing['forma_pago'];

}

$sql_dat_ingca = "SELECT * from comprobantes where id_atencion = $id_atencion";
$result_dat_ingca = $conexion->query($sql_dat_ingca);
while ($row_dat_ingca= $result_dat_ingca->fetch_assoc()) {
    $cadenaor=$row_dat_ingca['cadenaor'];
     $fechatim=$row_dat_ingca['fecha'];
     
     $uuid=$row_dat_ingca['uuid'];
     $nocertificado=$row_dat_ingca['nocertificado'];
     $sellocfd=$row_dat_ingca['sellocfd'];
     $sellosat=$row_dat_ingca['sellosat'];
     
}





$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

include "conexionbdf.php";

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(155, 194, 255); // establece el color del fondo de la celda (en este caso es AZUL
$pdf->Cell(15, 4, utf8_decode("Código"),0,0, 'L','True');
$pdf->Cell(104, 4, utf8_decode("Descripción"),0,0, 'L','True');
$pdf->Cell(10, 4, utf8_decode("U.M."),0,0, 'L','True');
$pdf->Cell(15, 4, utf8_decode("Cantidad"),0,0, 'L','True');
$pdf->Cell(25, 4, utf8_decode("P.U."),0,0, 'L','True');
$pdf->Cell(25, 4, utf8_decode("APLICA IVA"),0,0, 'L','True');


$sql_dat_ingf = "SELECT * from gen_concepto_fact WHERE id_atencion= $id_atencion";
$result_dat_ingf = $conexion->query($sql_dat_ingf);
while ($row_dat_ingf = $result_dat_ingf->fetch_assoc()) {
   $tip_concepto=$row_dat_ingf["tip_concepto"];
}

 $sql_compl = "SELECT * from Complemento where id_atencion = $id_atencion";
$result_comple = $conexion->query($sql_compl);
while ($row_com= $result_comple->fetch_assoc()) {
    
     $fecha=$row_com['fecha'];
     $bancoor=$row_com['bancoor'];
     $cuentaor=$row_com['cuentaor'];
     $montoant=$row_com['montoant'];
     $saldoant=$row_com['saldoant'];
     $noparcialidad=$row_com['noparcialidad'];
     $comentario=$row_com['comentario'];
     $serie=$row_com['serie'];
     $folio=$row_com['folio'];
     $moneda=$row_com['moneda'];
     $formapago=$row_com['formapago'];
     $objetoimp=$row_com['objetoimp'];
     $id_documento=$row_com['id_documento'];
     $clave_unidad=$row_com['clave_unidad'];
     $unidad=$row_com['unidad'];
     $codigo=$row_com['codigo'];
}
      
include "conexionbdf.php";
$sql_dat_ing = "SELECT * from gen_concepto_fact WHERE id_atencion=$id_atencion  group by id_atencion ORDER BY id_con_sat DESC";
$result_dat_ing = $conexion->query($sql_dat_ing);
while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
$subpre=$row_dat_ing['precio'];
  $pdf->Ln(3);
  $pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 6, utf8_decode("84111506"),0, 'C');
$pdf->Cell(104, 6, utf8_decode("PAGO"),0, 'C');
$pdf->Cell(10, 6, utf8_decode("ACT"),0, 'C');
$pdf->Cell(15, 6, utf8_decode($row_dat_ing['cantidad']),0, 'C');
$pdf->Cell(25, 6, utf8_decode(number_format($montoant, 2)),0, 'C');
$pdf->Cell(25, 6, utf8_decode("NO APLICA"),0, 'C');
$descuento=$row_dat_ing['descuento'];
 $pdf->Ln(3);
}





include "conexionbdf.php";
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 10);
$pdf->Line(5, 283, 205, 283);//DE HASTA ABAJO LINEA

 $pdf->SetFillColor(107, 109, 111);
 $pdf->Cell(195, 0.5, utf8_decode(''), 0, 0, 'C','True');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 7);
$fechacoma=date_create($fecha);
$fsa=date_format($fechacoma,"Y-m-d");

$fechacomh=date_create($fecha);
$has=date_format($fechacomh,"H:i:s");

if($formapago==01){
    $fpc="EFECTIVO";
}else if($formapago==99){
    $fpc="POR DEFINIR";
}else if($formapago==04){
    $fpc="TARJETA DE CRÉDITO";
}else if($formapago==28){
    $fpc="TARJETA DE DÉBITO";
}else if($formapago==03){
    $fpc="TRANSFERENCIA ELECTRÓNICA DE FONDOS";
}

$pdf->Cell(45, 6, utf8_decode("FECHA PAGO: " .$fsa.'T'.$has),0, 'R');
$pdf->Cell(80, 6, utf8_decode(" "),0, 'R');
$pdf->Cell(39, 6, utf8_decode("CUENTA ORDENANTE: " .$bancoor.'-'.$cuentaor),0, 'R');
$pdf->Ln(3.5);
$pdf->Cell(22, 6, utf8_decode("MONEDA: " .$moneda),0, 'R');
$pdf->Cell(80, 6, utf8_decode("MONTO: $" .number_format($montoant, 2)),0, 'R');
$pdf->Ln(3.5);
$pdf->Cell(22, 6, utf8_decode("--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"),0, 'R');
$pdf->Ln(3);
$pdf->Cell(22, 6, utf8_decode("D O C U M E N T O S   R E L A C I O N A D O S"),0, 'R');
$pdf->Ln(3);
$pdf->Cell(22, 6, utf8_decode("--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"),0, 'R');
$pdf->Ln(3.5);
$pdf->Cell(80, 6, utf8_decode("UUID: " .$uuid),0, 'R');
$pdf->Ln(3.5);
$pdf->Cell(17, 6, utf8_decode("FOLIO: " .$serie.'-'.$folio),0, 'R');
$pdf->Cell(30, 6, utf8_decode("SALDO ANT: $" .number_format($saldoant, 2)),0, 'R');
$pdf->Cell(22, 6, utf8_decode("PAGO: $" .number_format($montoant, 2)),0, 'R');
$pdf->Cell(28, 6, utf8_decode("SALDO NV0: " .number_format($saldoant-$montoant, 2)),0, 'R');
$pdf->Cell(23, 6, utf8_decode("PARCIALIDAD: " .$noparcialidad),0, 'R');

$pdf->Ln(6);
 $pdf->Cell(195, 0.5, utf8_decode(''), 0, 0, 'C','True');

$pdf->Ln(4);
$pdf->Cell(30.5,79, $pdf->Image('../cuenta_paciente/codigoQr.jpg', $pdf->GetX(), $pdf->GetY(),30),0);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(4);



 $pdf->Cell(32,1, utf8_decode(''), 0, 'C','True');
 $pdf->Cell(12,1, utf8_decode('Total con letra:'), 0, 'C','True');
 
$formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
$n=$montoant;
$izquierda = intval(floor($n));
$derecha = intval(($n - floor($n)) * 100);
$pdf->Ln(2);
 $pdf->Cell(31,1, utf8_decode(''), 0, 'C','True');
 $pdf->Cell(98, 6, utf8_decode(" ( " .$formatterES->format($izquierda) . " pesos con " . $formatterES->format($derecha). " centavos M.N. ) " ),0, 'R');



$pdf->Cell(39, 6, utf8_decode("SUBTOTAL PAGO:"),0, 'R');

$sql_dat_ing = "SELECT * from gen_concepto_fact where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);
while ($row_dat_ing= $result_dat_ing->fetch_assoc()) {
    $tota=$row_dat_ing['total'];
}

  $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(10, 6, utf8_decode(""),0, 'C');
  $pdf->Cell(20, 6, utf8_decode("$".number_format($montoant, 2)),0, 'R');

$pdf->Ln(9);
 $pdf->Cell(130, 0.5, utf8_decode(''), 0, 0, 'C');
$pdf->SetFillColor(107, 109, 111);
 $pdf->Cell(65, 0.5, utf8_decode(''), 0, 0, 'C','True');
 $pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode(""),0, 'C');

 $pdf->Cell(-0.1,1, utf8_decode(''), 0, 'C','True');
 $pdf->Cell(1,0.1, utf8_decode('Comentario:'), 0, 'C','True');

$pdf->Cell(97, 6, utf8_decode("**$comentario**"),0, 'R');

$pdf->Cell(49, 6, utf8_decode("TOTAL:"),0, 'R');


$pdf->SetFont('Arial', '', 8);
$sql_dat_ing = "SELECT * from gen_concepto_fact where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);
while ($row_dat_ing= $result_dat_ing->fetch_assoc()) {
    $tota=$row_dat_ing['total'];
}
$pdf->Cell(129, 6, utf8_decode("$".$english_format_number = number_format($montoant, 2)),0, 'R');


$pdf->Ln(12);

if($metodo_pago=="PUE"){
    $metp="PAGO EN UNA SOLA EXHIBICIÓN";
}else if($metodo_pago=="PPD"){
    $metp="PAGO EN PARCIALIDADES O DIFERIDO";
}


/*$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("MÉTODO DE PAGO:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
//$pdf->Cell(29, 6, utf8_decode($metodo_pago . " - " . $metp),0, 'C');

$pdf->Ln(4);

if($forma_pago==01){
    $fp="EFECTIVO";
}else if($forma_pago==99){
    $fp="POR DEFINIR";
}else if($forma_pago==04){
    $fp="TARJETA DE CRÉDITO";
}else if($forma_pago==28){
    $fp="TARJETA DE DÉBITO";
}else if($forma_pago==03){
    $fp="TRANSFERENCIA ELECTRÓNICA DE FONDOS";
}

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("FORMA DE PAGO:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
//$pdf->Cell(29, 6, utf8_decode($forma_pago . ' - ' . $fp),0, 'C');
*/

$pdf->Ln(6);
 $pdf->SetFillColor(107, 109, 111);
 $pdf->Cell(195, 0.5, utf8_decode(''), 0, 0, 'C','True');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(85, 6, utf8_decode("SELLO DIGITAL CFD:"),0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(194, 3, utf8_decode($sellocfd),0, 'J');


$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(85, 6, utf8_decode("SELLO DIGITAL DEL SAT:"),0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(194, 3, utf8_decode($sellosat),0, 'J');


$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(85, 6, utf8_decode("CADENA ORIGINAL DEL COMPLEMENTO DE CERTIFICACIÓN DEL SAT:"),0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(194, 3, utf8_decode($cadenaor),0, 'J');
$pdf->Ln(1);
$pdf->SetFillColor(107, 109, 111);
 $pdf->Cell(195, 0.5, utf8_decode(''), 0, 0, 'C','True');

$ftim=date_create($fechatim);
$fs=date_format($ftim,"Y-m-d");

$htim=date_create($fechatim);
$hs=date_format($htim,"H:i:s");


$fs;
list($anio, $mes, $dia) = explode("-",$fs);
$Fs=$anio.'-'.$mes.'-'.$dia;
$FechaCompleta=$Fs.'T'.$hs;

$pdf->Ln(1);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(85, 6, utf8_decode("FECHA Y HORA DE TIMBRADO: " .$FechaCompleta),0, 'C');



$pdf->Output();
