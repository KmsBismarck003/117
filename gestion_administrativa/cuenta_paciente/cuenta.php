<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id_atencion'];
$id_usua_log = @$_GET['id_usua'];

mysqli_set_charset($conexion, "utf-8");

class PDF extends FPDF
{
  function Header()
  {

  include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 50, 26);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
    $this->Ln(30);
}
  }
  function Footer()
  {
    $this->SetFont('Arial', 'B', 8);
    $this->SetY(-15);
    $this->Cell(0, 8, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-20'), 0, 1, 'R');
  }
}

$date = date("d/m/Y");

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
 
$sql_reg_usu = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp, di.alta_adm FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.id_usua";

$result_reg_usu = $conexion->query($sql_reg_usu);
while ($row_reg_usu = $result_reg_usu->fetch_assoc()) {
  $papell = $row_reg_usu['papell'];
  $sapell = $row_reg_usu['sapell'];
  $nombre = $row_reg_usu['nombre'];
  $alta_adm = $row_reg_usu['alta_adm'];
}


$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.fecha, di.area  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $pac_papell = $row_pac['papell'];
  $pac_sapell = $row_pac['sapell'];
  $pac_nom_pac = $row_pac['nom_pac'];
  $id_exp = $row_pac['Id_exp'];
}


$sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
    $result_aseg = $conexion->query($sql_aseg);
        while ($row_aseg = $result_aseg->fetch_assoc()) {
              $aseg = $row_aseg['aseg'];
              $at= $row_aseg['aseg'];
                      }
                      $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
                      while($filat = mysqli_fetch_array($resultadot)){ 
                      $tr=$filat["tip_precio"];
                      
                      }

if ($alta_adm == 'SI' and $aseg == 'NINGUNA') {
  $pdf->SetFont('Arial', 'B', 14);
  $pdf->Cell(202, 15, utf8_decode('ESTADO DE CUENTA'), 0, 0, 'C');
  $pdf->Ln(17);
  $pdf->SetFont('Arial', '', 6);

  $sql_cajero = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp, di.alta_adm FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.cajero";

  $result_cajero = $conexion->query($sql_cajero);
  while ($row_cajero = $result_cajero->fetch_assoc()) {
    $papell_caj = $row_cajero['papell'];
  
  }

    $sql_cajero = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp, di.alta_adm FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.id_usua";

  $result_cajero = $conexion->query($sql_cajero);
  while ($row_cajero = $result_cajero->fetch_assoc()) {
    $papell_med = $row_cajero['papell'];
  
  }

  $sql_aseg = "SELECT * from dat_ingreso where id_atencion =$id_atencion";
$result_aseg = $conexion->query($sql_aseg);
while ($row_aseg = $result_aseg->fetch_assoc()) {
  $motivo_atn = $row_aseg['motivo_atn'];
  $cama = $row_aseg['cama_alta'];
}
  
  $pdf->SetDrawColor(43, 45, 127);
  
  $pdf->Cell(145, 5, utf8_decode('PACIENTE: '.$id_exp . ' - '. $pac_nom_pac . ' ' . $pac_papell . ' ' . $pac_sapell), 0, 0, 'L');
  $pdf->Cell(14, 5, utf8_decode('FECHA: '), 0, 0, 'L');
  $pdf->Cell(50, 5, utf8_decode(date('d/m/Y h:i a', time())), 0, 0, 'L');
  $pdf->Ln(4);
  $pdf->MultiCell(190, 5, utf8_decode('MÉDICO TRATANTE: '. $papell_med . ' ' . $sapell_med), 0, 'L');
  $pdf->MultiCell(190, 5, utf8_decode('MOTIVO DE INGRESO: '.$motivo_atn), 0, 'L');
  $pdf->Cell(88, 5, utf8_decode('PERSONAL: '. $papell_caj ), 0, 0, 'L');
  $pdf->Cell(57, 5, utf8_decode('ASEGURADORA: ' .  $aseg), 0, 0, 'L');
  $pdf->Cell(48, 5, utf8_decode('HABITACIÓN: '.$cama), 0, 0, 'L');
  $pdf->Ln(4);

} else if ($alta_adm == 'SI' and $aseg != 'NINGUNA') {


$sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha ASC limit 1";
$result_aseg = $conexion->query($sql_aseg);
while ($row_aseg = $result_aseg->fetch_assoc()) {
  $aseg = $row_aseg['aseg'];
}
  $sql_cajero = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp, di.alta_adm FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.cajero";

  $result_cajero = $conexion->query($sql_cajero);
  while ($row_cajero = $result_cajero->fetch_assoc()) {
    $papell_caj = $row_cajero['papell'];
    $sapell_caj = $row_cajero['sapell'];
    $nombre_caj = $row_cajero['nombre'];
  }

    $sql_cajero = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp, di.alta_adm FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.id_usua";

  $result_cajero = $conexion->query($sql_cajero);
  while ($row_cajero = $result_cajero->fetch_assoc()) {
    $papell_med = $row_cajero['papell'];
    $sapell_med = $row_cajero['sapell'];
    $nombre_med = $row_cajero['nombre'];
  }

  $sql_aseg = "SELECT * from dat_ingreso where id_atencion =$id_atencion";
$result_aseg = $conexion->query($sql_aseg);
while ($row_aseg = $result_aseg->fetch_assoc()) {
  $motivo_atn = $row_aseg['motivo_atn'];
  $cama = $row_aseg['cama_alta'];
  $aseg= $row_aseg['aseg'];
}
  
 
  $pdf->SetFont('Arial', 'B', 14);
  $pdf->Cell(202, 15, utf8_decode('ESTADO DE CUENTA'), 0, 0, 'C');
  $pdf->Ln(10);
  $pdf->SetFont('Arial', '', 7);
  
 
  $pdf->SetDrawColor(43, 45, 127);
  $pdf->Line(10, 50, 205, 50);
  $pdf->Line(10, 50, 10, 68);
  $pdf->Line(205, 50, 205, 68);
  $pdf->Line(10, 68, 205, 68);

  $pdf->Cell(145, 5, utf8_decode('PACIENTE: '.$id_exp . ' - '. $pac_nom_pac . ' ' . $pac_papell . ' ' . $pac_sapell), 0, 0, 'L');
  $pdf->Cell(14, 5, utf8_decode('FECHA: '), 0, 0, 'L');
  $pdf->Cell(50, 5, utf8_decode(date('d/m/Y h:i a', time())), 0, 0, 'L');
  $pdf->Ln(4);
  $pdf->MultiCell(190, 5, utf8_decode('MÉDICO TRATANTE: '. $papell_med . ' ' . $sapell_med), 0, 'L');
  $pdf->MultiCell(190, 5, utf8_decode('MOTIVO DE INGRESO: '.$motivo_atn), 0, 'L');
  $pdf->Cell(88, 5, utf8_decode('PERSONAL MSI: '. $papell_caj ), 0, 0, 'L');
  $pdf->Cell(57, 5, utf8_decode('ASEGURADORA: ' .  $aseg), 0, 0, 'L');
  $pdf->Cell(48, 5, utf8_decode('HABITACIÓN: '.$cama), 0, 0, 'L');
  $pdf->Ln(4);
} else {

  $sql_cajero = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp, di.alta_adm FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.id_usua";

  $result_cajero = $conexion->query($sql_cajero);
  while ($row_cajero = $result_cajero->fetch_assoc()) {
    $papell_med = $row_cajero['papell'];
    $sapell_med = $row_cajero['sapell'];
    $nombre_med = $row_cajero['nombre'];
  }
$sql_aseg = "SELECT * from dat_ingreso where id_atencion =$id_atencion";
$result_aseg = $conexion->query($sql_aseg);
while ($row_aseg = $result_aseg->fetch_assoc()) {
  $motivo_atn = $row_aseg['motivo_atn'];
}

$sql_aseg = "SELECT * from cat_camas where id_atencion =$id_atencion";
$result_aseg = $conexion->query($sql_aseg);
while ($row_aseg = $result_aseg->fetch_assoc()) {
  $cama = $row_aseg['num_cama'];
}

  $sql_cajero = "SELECT * FROM reg_usuarios ru where ru.id_usua=$id_usua_log";

  $result_cajero = $conexion->query($sql_cajero);
  while ($row_cajero = $result_cajero->fetch_assoc()) {
    $papell_caj = $row_cajero['papell'];
    $sapell_caj = $row_cajero['sapell'];
    $nombre_caj = $row_cajero['nombre'];
  }
   
  $pdf->SetFont('Arial', 'B', 14);
  $pdf->Cell(202, 12, utf8_decode('ESTADO DE CUENTA'), 0, 0, 'C');
  $pdf->Ln(10);
  $pdf->SetFont('Arial', '', 7);

  $pdf->SetDrawColor(43, 45, 127);
  $pdf->Line(10, 50, 205, 50);
  $pdf->Line(10, 50, 10, 68);
  $pdf->Line(205, 50, 205, 68);
  $pdf->Line(10, 68, 205, 68);

  $pdf->Cell(145, 5, utf8_decode('PACIENTE: '.$id_exp . ' - '. $pac_nom_pac . ' ' . $pac_papell . ' ' . $pac_sapell), 0, 0, 'L');
  $pdf->Cell(14, 5, utf8_decode('FECHA: '), 0, 0, 'L');
  $pdf->Cell(50, 5, utf8_decode(date('d/m/Y h:i a', time())), 0, 0, 'L');
  $pdf->Ln(4);
  $pdf->MultiCell(190, 5, utf8_decode('MÉDICO TRATANTE: '. $papell_med . ' ' . $sapell_med), 0, 'L');
  $pdf->MultiCell(190, 5, utf8_decode('MOTIVO DE INGRESO: '.$motivo_atn), 0, 'L');
  $pdf->Cell(88, 5, utf8_decode('PERSONAL: '. $papell_caj ), 0, 0, 'L');
  $pdf->Cell(57, 5, utf8_decode('ASEGURADORA: ' .  $aseg), 0, 0, 'L');
  $pdf->Cell(48, 5, utf8_decode('HABITACIÓN: '.$cama), 0, 0, 'L');
  $pdf->Ln(6);
}

/**********************************************/

/**********************************************/

$precio = 0;
$iva = 0;
$subtottal = 0;
$preciog12 = 0;
$subtotalg12 = 0;
$totalg12=0;
$preciolab = 0;
$subtotallab = 0;
$totallab=0;
$precioimg = 0;
$subtotalimg = 0;
$totalimg=0;
$preciog12h = 0;
$subtotalg12h = 0;
$costo = 0;
$subtotal_costo = 0;
$totalsh=0;
$tip_s = ' ';
$tip_servi=' ';
$Stotal=0;
$totalhono =0;
$total_dep = 0;

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(5, 5, utf8_decode('No. '), 1, 0, 'C');
$pdf->Cell(17, 5, utf8_decode('FECHA'), 1,0, 'C');
$pdf->Cell(80, 5, utf8_decode('DESCRIPCIÓN'), 1, 0,'C');
$pdf->Cell(18, 5, utf8_decode('U. DE MEDIDA'), 1, 0,'C');
$pdf->Cell(15, 5, utf8_decode('CANTIDAD'), 1, 0,'C');
$pdf->Cell(20, 5, utf8_decode('P. U.'), 1, 0,'C');
$pdf->Cell(20, 5, utf8_decode('IVA'), 1, 0,'C');
$pdf->Cell(20, 5, utf8_decode('SUBTOTAL'),1,0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 6);

$resultado3 = $conexion->query("SELECT * FROM dat_ctapac dc, paciente p, dat_ingreso di where di.id_atencion=$id_atencion and p.Id_exp=di.Id_exp and dc.id_atencion = $id_atencion ORDER BY cta_fec ASC") or die($conexion->error);
$total = 0;
$totiva = 0;
$Stotiva = 0;
$totallab = 0;
$totalimg = 0;
$no = 1;
while ($row3 = $resultado3->fetch_assoc()) {

  $flag = $row3['prod_serv'];
  $insumo = $row3['insumo'];
  $id_ctapac = $row3['id_ctapac'];
  $id_exp = $row3['Id_exp'];
  $precioh = $row3['cta_tot'];
  $tip_s = ' ';
  $tip_servi=' ';

   if ($insumo == 0 && $flag != 'S' && $flag != 'P' && $flag != 'PC' && $flag != 'H') {
                 $descripcion = $row3['prod_serv'];
                  $umed = "OTROS";
                  $precio = $row3['cta_tot'];
                  $iva = $precio * 0.16;
               }elseif ($flag == 'H' ) {
                  $resultado_servi = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
                  while ($row_servi = $resultado_servi->fetch_assoc()) {
                                
                  $descripcion = $row_servi['serv_desc'];
                  $umed = $row_servi['serv_umed'];
                  $precio = $precioh;
                  $iva = 0;
               }}elseif ($flag == 'S') {
                   
                  $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
                  while ($row_serv = $resultado_serv->fetch_assoc()) {
                 
                    if ($tr==1) $precio = $row_serv['serv_costo'];
                    if ($tr==2) $precio = $row_serv['serv_costo2'];
                    if ($tr==3) $precio = $row_serv['serv_costo3'];
                    if ($tr==4) $precio = $row_serv['serv_costo4'];
                  
                    if ($precio == 0) $precio = $precioh;
                    $descripcion = $row_serv['serv_desc'];
                    $umed = $row_serv['serv_umed'];
                  
                    $tip_s = $row_serv['tipo'];
                    if ($tip_s == '1') {$umed = 'LABORATORIO';}
                    if ($tip_s == '2') {$umed = 'IMAGENOLOGIA';}
                    
                    $tip_servi = $row_serv['tip_insumo'];
                    if ($tip_servi =="RENTA EQUIPO"){
                        $preciog12 = $precioh;
                        $subtotalg12 = ($preciog12 * $cant) * 1.16;
                    }
                    
                    $iva = $precio * 0.16;
                  }
                } else if ($flag == 'P'||$flag == 'PC') {
                  $resultado_prod = $conexion->query("SELECT * FROM item i, item_type it where 
                    i.item_id = $insumo and it.item_type_id=i.item_type_id ") or die($conexion->error);
                  while ($row_prod = $resultado_prod->fetch_assoc()) {
                    
                    $descripcion = $row_prod['item_name'];
                    $umed = 'Farmacia '.$row_prod['item_type_desc'];
                    $precio = $precioh;
                    $iva = $precio * 0.16;
                    
                  }
                } 

  $cant = $row3['cta_cant'];
  $precio =$precio + $iva;
  $subtottal = $precio * $cant;

  $totiva = $iva * $cant;
  $Stotiva =  $Stotiva + $totiva;
  
  $date = date_create($row3['cta_fec']);
  $pdf->Cell(5, 5, utf8_decode($no), 1, 0,'C');
  $pdf->Cell(17, 5, date_format($date, 'd/m/Y'),1, 0,'C');
  $pdf->Cell(80, 5, utf8_decode($descripcion), 1, 'L');
  $pdf->Cell(18, 5, utf8_decode($umed),1, 'L');

  $pdf->Cell(15, 5, utf8_decode($cant),1, 0,'C');
  $pdf->Cell(20, 5, '$ ' . utf8_decode(number_format($precio, 2)), 1,0, 'R');
  $pdf->Cell(20, 5, '$ ' . utf8_decode(number_format($totiva, 2)), 1,0, 'R');

  $pdf->Cell(20, 5, '$ ' . utf8_decode(number_format($subtottal, 2)), 1,0, 'R');
  $pdf->Ln(5);
  $total = $subtottal + $total;
  
  if ($tip_s == '1') {$totallab = $subtottal + $totallab;}
  if ($tip_s == '2') {$totalimg = $subtottal + $totalimg;}
  if ($tip_servi =="RENTA EQUIPO") {$totalg12 = $subtottal + $totalg12;}
  if ($flag == 'H' ) {$totalhono = $precioh + $totalhono;}
  
  $totalsh = $total - $totallab - $totalimg - $totalhono - $totalg12;
  
  $no++;
}
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(5, 5, '', 0, 'C');
$pdf->Cell(17, 5, '', 0, 'L');

$pdf->Cell(80, 5, '', 0, 'L');
$pdf->Cell(18, 5, '', 0, 'L');
$pdf->Cell(15, 5, '', 0, 'C');
$pdf->Cell(20, 5, 'Total: ', 1, 'R');
$pdf->Cell(20, 5, '$ ' . number_format($Stotiva, 2), 1,0, 'R');
$pdf->Cell(20, 5, '$ ' . number_format($total, 2), 1,0, 'R');
$pdf->Ln(5);


$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(202, 10, utf8_decode('PAGOS O ABONOS'), 0, 0, 'C');
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 6);

$pdf->Cell(28, 5, utf8_decode('FORMA DE PAGO'), 1,0, 'C');
$pdf->Cell(60, 5, utf8_decode('DETALLE '), 1,0, 'C');
$pdf->Cell(62, 5, utf8_decode('RECIBIÓ'), 1,0, 'C');
$pdf->Cell(18, 5, utf8_decode('CANTIDAD'), 1,0, 'C');

$pdf->Cell(27, 5, utf8_decode('FECHA Y HORA'), 1, 0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Ln(5);

$resultado4 = $conexion->query("SELECT * FROM dat_financieros df, reg_usuarios r where df.banco <> 'DESCUENTO' AND df.id_atencion = $id_atencion and df.id_usua=r.id_usua") or die($conexion->error);
$total_dep = 0;
$no = 1;
while ($row4 = $resultado4->fetch_assoc()) {
  $fecha1 = date_create($row4['fecha']);
  $pdf->SetFont('Arial', '', 6);
  $pdf->Cell(28, 5, utf8_decode($row4['banco']),1, 'L');
  $pdf->Cell(60, 5, utf8_decode($row4['resp']), 1, 'L');
  $pdf->Cell(62, 5, utf8_decode($row4['papell']), 1, 'L');
  $pdf->SetFont('Arial', '', 6);
  $pdf->Cell(18, 5, number_format(utf8_decode($row4['deposito']), 2),1,0, 'R');
  
  $pdf->Cell(27, 5, date_format($fecha1, 'd/m/Y H:i A'), 1, 'L');
  $pdf->Ln(5);
  $total_dep = $row4['deposito'] + $total_dep;
}

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(150, 5, 'Total: ', 1, 'R');
$pdf->Cell(18, 5, '$ ' . number_format($total_dep, 2),1,0, 'R');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(202, 10, utf8_decode('DESCUENTOS'), 0, 0, 'C');
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 6);

$pdf->Cell(28, 5, utf8_decode('TIPO'), 1,0, 'C');
$pdf->Cell(60, 5, utf8_decode('DETALLE '), 1,0, 'C');
$pdf->Cell(62, 5, utf8_decode('REGISTRÓ'), 1,0, 'C');
$pdf->Cell(18, 5, utf8_decode('CANTIDAD'), 1,0, 'C');

$pdf->Cell(27, 5, utf8_decode('FECHA Y HORA'), 1, 0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Ln(5);

$resultado4 = $conexion->query("SELECT * FROM dat_financieros df, reg_usuarios r where df.banco = 'DESCUENTO' AND df.id_atencion = $id_atencion and df.id_usua=r.id_usua") or die($conexion->error);
$total_desc = 0;
$no = 1;
while ($row4 = $resultado4->fetch_assoc()) {
  $fecha1 = date_create($row4['fecha']);
  $pdf->SetFont('Arial', '', 6);
  $pdf->Cell(28, 5, utf8_decode($row4['banco']),1, 'L');
  $pdf->Cell(60, 5, utf8_decode($row4['resp']), 1, 'L');
  $pdf->Cell(62, 5, utf8_decode($row4['papell']), 1, 'L');
  $pdf->SetFont('Arial', '', 6);
  $pdf->Cell(18, 5, number_format(utf8_decode($row4['deposito']), 2),1,0, 'R');
  
  $pdf->Cell(27, 5, date_format($fecha1, 'd/m/Y H:i A'), 1, 'L');
  $pdf->Ln(5);
  $total_desc = $row4['deposito'] + $total_desc;
}

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(150, 5, 'Total: ', 1, 'R');
$pdf->Cell(18, 5, '$ ' . number_format($total_desc, 2),1,0, 'R');
$pdf->Ln(10);
$saldo = $total - $total_desc;

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(145);
$pdf->Cell(30, 5, 'Subtotal: ', 0, 'R');
$pdf->MultiCell(30, 5, '$ ' . number_format($total, 2),0, 'R');

if($total_desc <> '0'){
$pdf->SetX(145);
$pdf->Cell(30, 5, 'Descuento: ', 0, 'R');
$pdf->MultiCell(30, 5, '$ ' . number_format($total_desc, 2),0, 'R');
}

$pdf->SetX(175);
$pdf->MultiCell(30, 3, '_____________', 0, 'R');
$pdf->SetX(145);
$pdf->Cell(30, 5, 'Total: ', 0, 'R');
$pdf->MultiCell(30, 5, '$ ' . number_format($saldo, 2),0, 'R');

if($total_dep <> '0'){
$pdf->SetX(145);
$pdf->Cell(30, 5, 'Pagos/Abonos: ', 0, 'R');
$pdf->MultiCell(30, 5, '$ ' . number_format($total_dep, 2),0, 'R');
$total_cta = $saldo - $total_dep;
$pdf->SetX(145);
if ($total_cta < 0) { $total_cta = $total_cta * -1;}
$pdf->Cell(30, 5, 'Saldo actual: ', 0, 'R');
$pdf->MultiCell(30, 5, '$ ' . number_format($total_cta, 2),0, 'R');
}
$pdf->Ln(5);

$pdf->Output();
