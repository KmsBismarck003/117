<?php
//use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';


$id_atencion = @$_GET['id_atencion'];
$id_exp = @$_GET['id_exp'];
$id_datfin=@$_GET['id_datfin'];
$id_f=@$_GET['id_f'];



//$id_usua=@$_GET['id_usua'];
include "conexionbdf.php";

mysqli_set_charset($conexion, "utf8");


class PDF extends FPDF
{
    
  function Header()
  {


   $id_atencion = @$_GET['id_atencion'];
   include "conexionbdf.php";
   $id_f=@$_GET['id_f'];

   
   $resultadof= $conexion->query("SELECT * from gen_factura where id_atencion='$id_atencion' and id_dat_gen_f='$id_f'") or die($conexion->error);
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

$razon_s = $ff['razon_s'];

}
    $id_comp=@$_GET['id_comp'];
$sql_dat_ingca = "SELECT c.descuento as descu, c.* from comprobantes c where id_atencion = $id_atencion and id_comp='$id_comp'";
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
    $externo=$row_dat_ingca['externo'];
    $descuento = $row_dat_ingca['descu']; 
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
$this->Cell(20, 6, utf8_decode("RECEPTOR:"),0, 'L');
    $this->SetFont('Arial', '', 7.2);
$this->Cell(22, 6, utf8_decode($razon_s),0, 'L');

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
$this->Cell(35, 8, utf8_decode('Versión: ' . $version), 0, 0, 'C');

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
}else if($uso_cfdi=="S01") {
     $usoc="SIN EFECTOS FISCALES";
}else if($uso_cfdi=="CP01") {
     $usoc="PAGOS";
}else if($uso_cfdi=="P01") {
     $usoc="POR DEFINIR";
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

if($externo=="Si"){
    
    $sql_pac = "SELECT * FROM pserv WHERE id_pac =$id_atencion";

$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $nombree = $row_pac['nombre'];
 
  
}
$this->SetFont('Arial', 'B', 9);
$this->Cell(20, 6, utf8_decode("PACIENTE:"),0, 'C');
$this->SetFont('Arial', '', 9);
$this->Cell(45, 6, utf8_decode($nombree),0, 'L');
}else if($externo==null){

$this->SetFont('Arial', 'B', 9);
$this->Cell(20, 6, utf8_decode("PACIENTE:"),0, 'C');
$this->SetFont('Arial', '', 9);
$this->Cell(45, 6, utf8_decode($pac_nom_pac. ' ' .$pac_papell. ' ' .$pac_sapell),0, 'L');
}
include "conexionbdf.php";


$this->SetFont('Arial', 'B', 8);
$this->Cell(57.3, 6, utf8_decode(""),0, 'C');
$this->Cell(27, 6, utf8_decode("No. CERTIFICADO: "),0, 'C');
$this->SetFont('Arial', '', 8);
$this->Cell(10, 6, utf8_decode($nocertificado),0, 'L');

$this->Ln(5);
$this->SetFont('Arial', 'B', 8);
$this->SetFillColor(155, 194, 255); // establece el color del fondo de la celda (en este caso es AZUL
$this->Cell(15, 4, utf8_decode(""),0,0, 'L','True');
$this->Cell(104, 4, utf8_decode(""),0,0, 'L','True');
$this->Cell(10, 4, utf8_decode(""),0,0, 'L','True');
$this->Cell(15, 4, utf8_decode(""),0,0, 'L','True');
$this->Cell(25, 4, utf8_decode(""),0,0, 'L','True');
$this->Cell(25, 4, utf8_decode(""),0,0, 'L','True');
$this->Ln(3);

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

 $id_f=@$_GET['id_f'];


$sql_dat_ing = "SELECT * from gen_factura where id_atencion = $id_atencion and id_dat_gen_f='$id_f'";
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
$id_comp=@$_GET['id_comp'];

$sql_dat_ingca = "SELECT c.descuento as descu, c.* from comprobantes c where id_atencion = $id_atencion and id_comp='$id_comp'";
$result_dat_ingca = $conexion->query($sql_dat_ingca);
while ($row_dat_ingca= $result_dat_ingca->fetch_assoc()) {
    $cadenaor=$row_dat_ingca['cadenaor'];
     $fechatim=$row_dat_ingca['fecha'];
     
     $uuid=$row_dat_ingca['uuid'];
     $nocertificado=$row_dat_ingca['nocertificado'];
     $sellocfd=$row_dat_ingca['sellocfd'];
     $sellosat=$row_dat_ingca['sellosat'];
     $descuento=$row_dat_ingca['descu'];
}





$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

include "conexionbdf.php";

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(155, 194, 255); // establece el color del fondo de la celda (en este caso es AZUL
$pdf->Cell(15, 4, utf8_decode("Código"),0,0, 'L','True');
$pdf->Cell(104, 4, utf8_decode("Descripción"),0,0, 'L','True');
$pdf->Cell(10, 4, utf8_decode("U.M."),0,0, 'L','True');
$pdf->Cell(15, 4, utf8_decode("Cantidad"),0,0, 'L','True');
$pdf->Cell(25, 4, utf8_decode("P.U."),0,0, 'L','True');
$pdf->Cell(25, 4, utf8_decode("APLICA IVA"),0,0, 'L','True');
$pdf->Ln(3);


$sql_dat_ingf = "SELECT * from gen_concepto_fact WHERE id_atencion= $id_atencion";
$result_dat_ingf = $conexion->query($sql_dat_ingf);
while ($row_dat_ingf = $result_dat_ingf->fetch_assoc()) {
   $tip_concepto=$row_dat_ingf["tip_concepto"];
}

$pdf->Ln(1);


if($tip_concepto=="Global" or $tip_concepto=="Global A"){
      
include "conexionbdf.php";
$sql_dat_ing = "SELECT c.descuento as descu, g.*, c.* from gen_concepto_fact g, comprobantes c WHERE g.id_atencion=c.id_atencion and c.id_comp='$id_comp'  ORDER BY g.id_con_sat DESC";
$result_dat_ing = $conexion->query($sql_dat_ing);
while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
    $cod=$row_dat_ing['codigo'];
     
     $tipof=$row_dat_ing['tipof'];
    $cunidad=$row_dat_ing['clave_unidad'];
    $canti=$row_dat_ing['cantidad'];
    $totta=$row_dat_ing['total'];
     $PU=$row_dat_ing['precio'];
     $preciou=$row_dat_ing['subtotal'];
     $descuento=$row_dat_ing['descu'];
     $total_desc=$row_dat_ing['total_desc'];
}
//echo 'Este es el descuento: ' . $descuento;
  $pdf->Ln(3);
  $pdf->SetFont('Arial', '', 7);
  
 if($tipof == "pago" and $tip_concepto=="Global A"){
  $pdf->Cell(15, 6, utf8_decode("84111506"),0, 'C');
   $pdf->Cell(104, 6, utf8_decode("ANTICIPO DEL BIEN O SERVICIO"),0, 'C');
   $pdf->Cell(10, 6, utf8_decode("ACT"),0, 'C');
}else {
  $pdf->Cell(15, 6, utf8_decode("85101501"),0, 'C');
      $pdf->Cell(104, 6, utf8_decode("SERVICIOS HOSPITALARIOS DE EMERGENCIA O QUIRÚRGICOS"),0, 'C');
       $pdf->Cell(10, 6, utf8_decode("E48"),0, 'C');
}




$pdf->Cell(15, 6, utf8_decode($canti),0, 'C');
$pdf->Cell(25, 6, utf8_decode("$".$preciou),0, 'C');
$pdf->Cell(25, 6, utf8_decode("$".$preciou),0, 'C');
//$descuento=$row_dat_ing['descuento'];
 $pdf->Ln(3);


}else{
include "conexionbdf.php";
$sql_dat_ing = "SELECT * from gen_concepto where id_atencion=$id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);
while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $pdf->Ln(3);
  $pdf->SetFont('Arial', '', 7);
  
$pdf->Cell(15, 6, utf8_decode($row_dat_ing['codigo']),0, 'C');
$pdf->Cell(104, 6, utf8_decode($row_dat_ing['descripcion']),0, 'C');
$pdf->Cell(10, 6, utf8_decode($row_dat_ing['clave_unidad']),0, 'C');
$pdf->Cell(15, 6, utf8_decode($row_dat_ing['cantidad']),0, 'C');
$pdf->Cell(25, 6, utf8_decode("$".number_format($row_dat_ing['importe'],2)),0, 'C');

if($row_dat_ing['prod_serv']=="H"){
    $pdf->Cell(25, 6, utf8_decode("$ 0.00"),0, 'C');
   //$pdf->Cell(25, 6, utf8_decode("$".$row_dat_ing['cantidad']*$row_dat_ing['precio']),0, 'C');
}else{
     $pdf->Cell(25, 6, utf8_decode("$".number_format($row_dat_ing['cantidad']*$row_dat_ing['importe'],2)),0, 'C');
      $pdf->Cell(25, 6, utf8_decode(""),0, 'C');
}

//$descuento=$row_dat_ing['descuento'];
}

}



include "conexionbdf.php";
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 10);
$pdf->Line(5, 283, 205, 283);//DE HASTA ABAJO LINEA

 $pdf->SetFillColor(107, 109, 111);
 $pdf->Cell(195, 0.5, utf8_decode(''), 0, 0, 'C','True');

$pdf->Ln(4);
$pdf->Cell(-0.5,11, $pdf->Image('../cuenta_paciente/codigoQr.jpg', $pdf->GetX(), $pdf->GetY(),30),0);

//$pdf->Cell(11,11, $pdf->Image('images/prueba.jpg', $pdf->GetX(), $pdf->GetY(),11),1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(130, 6, utf8_decode(""),0, 'C');


$pdf->Cell(39, 6, utf8_decode("SUBTOTAL CUENTA:"),0, 'R');
$id_comp=@$_GET['id_comp'];

$sql_dat_ing = "SELECT c.descuento as descu, c.* from comprobantes c where id_atencion = $id_atencion and id_comp='$id_comp'";
$result_dat_ing = $conexion->query($sql_dat_ing);
while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
    
    $descuento= $row_dat_ing['descu'];
    $iva= $row_dat_ing['iva'];
    $to= $row_dat_ing['total'];
    $descuento_aseg= $row_dat_ing['descuento_aseg'];
    
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(10, 6, utf8_decode(""),0, 'C');
    $pdf->Cell(20, 6, utf8_decode("$".number_format($row_dat_ing['subtotal'], 2)),0, 'R');
    $pdf->Ln(4);
    
     if($row_dat_ing['descu']==null){
         $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(130, 6, utf8_decode(""),0, 'C');
$pdf->Cell(39, 6, utf8_decode("DESCUENTO:"),0, 'R');
$pdf->Cell(10, 6, utf8_decode(""),0, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode("$ 0.00"),0, 'R'); 
     }else{
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(130, 6, utf8_decode(""),0, 'C');
$pdf->Cell(39, 6, utf8_decode("DESCUENTO:"),0, 'R');
$pdf->Cell(10, 6, utf8_decode(""),0, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode("$ ".number_format($row_dat_ing['descu'], 2)),0, 'R'); 
}
}

$pdf->Ln(0);

if($descuento_aseg!=null){
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(130, 6, utf8_decode(""),0, 'C');
$pdf->Cell(39, 6, utf8_decode("DESC. ASEGURADORA:"),0, 'R');
$pdf->Cell(10, 6, utf8_decode(""),0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode("$".$english_format_number = number_format($descuento_aseg, 2)),0, 'R');
}else{
     $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(20, 6, utf8_decode("$".$english_format_number = number_format(0, 2)),0, 'R');
}


$pdf->Ln(0);

if($descuento_aseg!=null){
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(130, 6, utf8_decode(""),0, 'C');
$pdf->Cell(39, 6, utf8_decode("DESC. COASEG. Y DEDUC.:"),0, 'R');
$pdf->Cell(10, 6, utf8_decode(""),0, 'C');

    $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(20, 6, utf8_decode("$".$english_format_number = number_format($descuento, 2)),0, 'R');
}else{
     $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(20, 6, utf8_decode("$".$english_format_number = number_format(0, 2, '.', '')),0, 'R');
}

$pdf->Ln(3);
 include "../../conexionbd.php";
$resultadoas = $conexion->query("SELECT * from dat_financieros WHERE id_atencion=$id_atencion") or die($conexion->error);
              while ($rowas = $resultadoas->fetch_assoc()) {
                $banco=$rowas['banco'];
                $deposito=$rowas['deposito'];
              }
        

    
include "conexionbdf.php";

  $pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(130, 6, utf8_decode(""),0, 'C');
$pdf->Cell(39, 6, utf8_decode("IVA:"),0, 'R');
$pdf->Cell(10, 6, utf8_decode(""),0, 'C');

$pdf->SetFont('Arial', '', 8);
  $pdf->Cell(20, 6, utf8_decode("$".$english_format_number = number_format($iva, 2)),0, 'R');

$pdf->Ln(6);
 $pdf->Cell(130, 0.5, utf8_decode(''), 0, 0, 'C');
$pdf->SetFillColor(107, 109, 111);
 $pdf->Cell(65, 0.5, utf8_decode(''), 0, 0, 'C','True');
 $pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(130, 6, utf8_decode(""),0, 'C');
$pdf->Cell(49, 6, utf8_decode("TOTAL:"),0, 'R');



$pdf->SetFont('Arial', '', 8);
$sql_dat_ing = "SELECT * from gen_concepto_fact where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);
while ($row_dat_ing= $result_dat_ing->fetch_assoc()) {
    $tota=$row_dat_ing['total'];
}
$pdf->Cell(29, 6, utf8_decode("$".$english_format_number = number_format($to, 2)),0, 'R');


$pdf->Ln(12);

if($metodo_pago=="PUE"){
    $metp="PAGO EN UNA SOLA EXHIBICIÓN";
}else if($metodo_pago=="PPD"){
    $metp="PAGO EN PARCIALIDADES O DIFERIDO";
}


$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("MÉTODO DE PAGO:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(29, 6, utf8_decode($metodo_pago . " - " . $metp),0, 'C');

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
$pdf->Cell(29, 6, utf8_decode($forma_pago . ' - ' . $fp),0, 'C');
$pdf->Ln(6);



$pdf->SetFont('Arial', '', 8);


$resultadofr= $conexion->query("SELECT * from relacion_cfdi where id_dat_gen_f=$id_f") or die($conexion->error);
while($row_dat_ing1=mysqli_fetch_array($resultadofr)){
    
$cfdi_relacionado=$row_dat_ing1['cfdi_relacionado'];
$tipo_relacion_a=$row_dat_ing1['tipo_relacion_a'];
      
        $cfdi_relacionado2=$row_dat_ing1['cfdi_relacionado2'];
          $tipo_relacion_a2=$row_dat_ing1['tipo_relacion_a2'];
          
            $cfdi_relacionado3=$row_dat_ing1['cfdi_relacionado3'];
              $tipo_relacion_a3=$row_dat_ing1['tipo_relacion_a3'];



if($cfdi_relacionado==""){
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Ln(10);
$pdf->Cell(129, 6, utf8_decode("SIN DATOS RELACIONADOS"),0, 'C');
}else if($cfdi_relacionado!="" and $cfdi_relacionado2=="" and $cfdi_relacionado3==""){
$pdf->Ln(10);
$pdf->SetFillColor(107, 109, 111);
$pdf->Cell(195, 0.5, utf8_decode(''), 0, 0, 'C','True');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(129, 6, utf8_decode("DATOS RELACIONADOS"),0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("TIPO RELACIÓN:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(55, 6, utf8_decode($tipo_relacion_a. " -  CFDI POR APLICACIÓN DE ANTICIPO"),0, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("CFDI RELACIONADO:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(29, 6, utf8_decode($cfdi_relacionado),0, 'C'); 
    
}else if($cfdi_relacionado!="" and $cfdi_relacionado2!="" and $cfdi_relacionado3==""){
$pdf->Ln(10);
$pdf->SetFillColor(107, 109, 111);
$pdf->Cell(195, 0.5, utf8_decode(''), 0, 0, 'C','True');
$pdf->Ln(1);
 $pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(129, 6, utf8_decode("DATOS RELACIONADOS"),0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("TIPO RELACIÓN:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(55, 6, utf8_decode($tipo_relacion_a. " -  CFDI POR APLICACIÓN DE ANTICIPO"),0, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("CFDI RELACIONADO:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(29, 6, utf8_decode($cfdi_relacionado),0, 'C'); 
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("TIPO RELACIÓN:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(55, 6, utf8_decode($tipo_relacion_a2. " -  CFDI POR APLICACIÓN DE ANTICIPO"),0, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("CFDI RELACIONADO:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(29, 6, utf8_decode($cfdi_relacionado2),0, 'C');

}else if($cfdi_relacionado!="" and $cfdi_relacionado2!="" and $cfdi_relacionado3!=""){
    
$pdf->Ln(10);
$pdf->SetFillColor(107, 109, 111);
$pdf->Cell(195, 0.5, utf8_decode(''), 0, 0, 'C','True');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(129, 6, utf8_decode("DATOS RELACIONADOS"),0, 'C');
$pdf->Ln(4.5);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("TIPO RELACIÓN:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(55, 6, utf8_decode($tipo_relacion_a. " -  CFDI POR APLICACIÓN DE ANTICIPO"),0, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("CFDI RELACIONADO:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(29, 6, utf8_decode($cfdi_relacionado),0, 'C'); 
$pdf->Ln(3.5);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("TIPO RELACIÓN:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(55, 6, utf8_decode($tipo_relacion_a2. " -  CFDI POR APLICACIÓN DE ANTICIPO"),0, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("CFDI RELACIONADO:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(29, 6, utf8_decode($cfdi_relacionado2),0, 'C');


$pdf->Ln(3.5);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("TIPO RELACIÓN:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(55, 6, utf8_decode($tipo_relacion_a3. " -  CFDI POR APLICACIÓN DE ANTICIPO"),0, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(29, 6, utf8_decode("CFDI RELACIONADO:"),0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(29, 6, utf8_decode($cfdi_relacionado3),0, 'C');
}


}



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
