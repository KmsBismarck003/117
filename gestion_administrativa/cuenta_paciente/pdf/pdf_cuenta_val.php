<?php
require '../../../fpdf/fpdf.php';
include '../../../conexionbd.php';
$id_atencion = @$_GET['id_atencion'];
$id_usua_log = @$_GET['id_usua'];

mysqli_set_charset($conexion, "utf-8");

class PDF extends FPDF
{
  function Header()
  {

    include '../../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../../configuracion/admin/img2/".$bas, 7, 8, 50, 26);
    $this->Image("../../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
      $this->Ln(33);
}
  }
  function Footer()
  {
    $this->SetFont('Arial', 'B', 8);
    $this->SetY(-15);
    $this->Cell(0, 8, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-023'), 0, 1, 'R');
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


$sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha ASC limit 1";
$result_aseg = $conexion->query($sql_aseg);
while ($row_aseg = $result_aseg->fetch_assoc()) {
  $aseg = $row_aseg['aseg'];
}

if ($alta_adm == 'SI' and $aseg == 'NINGUNA') {
  $pdf->SetFont('Arial', 'B', 14);
  $pdf->Cell(202, 15, utf8_decode('DETALLE DE LA CUENTA'), 0, 0, 'L');
  $pdf->Ln(15);
  $pdf->SetFont('Arial', '', 6);

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
}

  $pdf->SetDrawColor(0, 0, 0);
  $pdf->Line(10, 60, 205, 60);
  $pdf->Line(10, 60, 10, 77);
  $pdf->Line(205, 60, 205, 77);
  $pdf->Line(10, 77, 205, 77);

  $pdf->Cell(145, 8, utf8_decode('EXPEDIENTE: '.'  ' . $id_exp .'  '. ' NOMBRE: '.'    ' . $pac_nom_pac . ' ' . $pac_papell . ' ' . $pac_sapell), 0, 0, 'L');


  $pdf->Cell(14, 8, utf8_decode('FECHA: '), 0, 0, 'L');
  $pdf->Cell(50, 8, utf8_decode(date('d/m/Y h:i:s a', time())), 0, 0, 'L');
  $pdf->Ln(4);

  $pdf->Cell(88, 6, utf8_decode('MEDICO TRATANTE:'.'    '.$nombre_med. ' ' . $papell_med . ' ' . $sapell_med), 0, 0, 'L');
  $pdf->Cell(48, 6, utf8_decode('DIAGNOSTICO:'.' '.$motivo_atn), 0, 0, 'L');
  $pdf->Ln(4);
 $pdf->Cell(88, 6, utf8_decode('PERSONAL:'.'    '.$papell_caj . ' ' . $sapell_caj), 0, 0, 'L');
 $pdf->Cell(57, 6, utf8_decode('SEGURO: ' . ' ' . $aseg), 0, 0, 'L');
  $pdf->Cell(48, 6, utf8_decode('HABITACION:'.' '.$cama), 0, 0, 'L');
  $pdf->Ln(8);


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
}
  $pdf->SetFont('Arial', 'B', 14);
  $pdf->Cell(202, 15, utf8_decode('DESGLOSE DE GASTOS MÉDICOS'), 0, 0, 'L');
  $pdf->Ln(15);
  $pdf->SetFont('Arial', '', 6);


  $pdf->SetDrawColor(0, 0, 0);
  $pdf->Line(10, 60, 205, 60);
  $pdf->Line(10, 60, 10, 77);
  $pdf->Line(205, 60, 205, 77);
  $pdf->Line(10, 77, 205, 77);

  $pdf->Cell(145, 8, utf8_decode('EXPEDIENTE: '.'  ' . $id_exp .'  '. ' NOMBRE: '.'    ' . $pac_nom_pac . ' ' . $pac_papell . ' ' . $pac_sapell), 0, 0, 'L');


  $pdf->Cell(14, 8, utf8_decode('FECHA: '), 0, 0, 'L');
  $pdf->Cell(50, 8, utf8_decode(date('d/m/Y h:i:s a', time())), 0, 0, 'L');
  $pdf->Ln(4);

  $pdf->Cell(88, 6, utf8_decode('MEDICO TRATANTE:'.'    '.$nombre_med. ' ' . $papell_med . ' ' . $sapell_med), 0, 0, 'L');
  $pdf->Cell(48, 6, utf8_decode('DIAGNOSTICO:'.' '.$motivo_atn), 0, 0, 'L');
  $pdf->Ln(4);
 $pdf->Cell(88, 6, utf8_decode('PERSONAL:'.'    '.$papell_caj . ' ' . $sapell_caj), 0, 0, 'L');
  $pdf->Cell(57, 6, utf8_decode('SEGURO: ' . ' ' . $aseg), 0, 0, 'L');
  $pdf->Cell(48, 6, utf8_decode('HABITACION:'.' '.$cama), 0, 0, 'L');
  $pdf->Ln(8);
} else {
  $sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha DESC limit 1";
$result_aseg = $conexion->query($sql_aseg);
while ($row_aseg = $result_aseg->fetch_assoc()) {
  $aseg = $row_aseg['aseg'];
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
  $pdf->Cell(202, 15, utf8_decode('CUENTA PRELIMINAR'), 0, 0, 'L');
  $pdf->Ln(15);
  $pdf->SetFont('Arial', '', 6);


  $pdf->SetDrawColor(0, 0, 0);
  $pdf->Line(10, 60, 205, 60);
  $pdf->Line(10, 60, 10, 77);
  $pdf->Line(205, 60, 205, 77);
  $pdf->Line(10, 77, 205, 77);

  $pdf->Cell(145, 8, utf8_decode('EXPEDIENTE: '.'  ' . $id_exp .'  '. ' NOMBRE: '.'    ' . $pac_nom_pac . ' ' . $pac_papell . ' ' . $pac_sapell), 0, 0, 'L');


  $pdf->Cell(14, 8, utf8_decode('FECHA: '), 0, 0, 'L');
  $pdf->Cell(50, 8, utf8_decode(date('d/m/Y h:i:s a', time())), 0, 0, 'L');
  $pdf->Ln(4);

  $pdf->Cell(88, 6, utf8_decode('MEDICO TRATANTE:'.'    '.$nombre_med. ' ' . $papell_med . ' ' . $sapell_med), 0, 0, 'L');
  $pdf->Cell(48, 6, utf8_decode('DIAGNOSTICO:'.' '.$motivo_atn), 0, 0, 'L');
  $pdf->Ln(4);
 $pdf->Cell(88, 6, utf8_decode('PERSONAL:'.'    '.$papell_caj . ' ' . $sapell_caj), 0, 0, 'L');
  $pdf->Cell(57, 6, utf8_decode('SEGURO: ' . ' ' . $aseg), 0, 0, 'L');
  $pdf->Cell(48, 6, utf8_decode('HABITACION:'.' '.$cama), 0, 0, 'L');
  $pdf->Ln(8);
}




/*$pdf->Cell(30, 8, utf8_decode('Nombre del Paciente:'), 0, 0, 'L');
$pdf->Cell(100, 8, utf8_decode($pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac), 0, 0, 'L');

$pdf->Cell(10, 8, utf8_decode('Fecha: '), 0, 0, 'L');
$pdf->Cell(50, 8, utf8_decode(date('m-d-Y h:i:s a', time())), 0, 0, 'L');
$pdf->Ln(8);

$pdf->Cell(40, 8, utf8_decode('Personal:'), 0, 0, 'L');
$pdf->Cell(90, 8, utf8_decode($papell . ' ' . $sapell . ' ' . $nombre), 0, 0, 'L');

$pdf->Cell(12, 8, utf8_decode('Seguro: '), 0, 0, 'L');
$pdf->Cell(50, 8, utf8_decode($aseg), 0, 0, 'L');
$pdf->Ln(8);*/
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(7, 8, utf8_decode('No. '), 1, 0, 'C');
$pdf->Cell(23, 8, utf8_decode('FECHA REGISTRO'), 1,0, 'C');
$pdf->Cell(20, 8, utf8_decode('U. DE MEDIDA'), 1, 0,'C');
$pdf->Cell(80, 8, utf8_decode('DESCRIPCIÓN'), 1, 0,'C');
$pdf->Cell(15, 8, utf8_decode('CANTIDAD'), 1, 0,'C');
$pdf->Cell(25, 8, utf8_decode('PRECIO'), 1, 0,'C');
$pdf->Cell(25, 8, utf8_decode('SUBTOTAL'),1,0, 'C');
$pdf->Ln(8);

$pdf->SetFont('Arial', '', 8);

$resultado3 = $conexion->query("SELECT * FROM cuenta_pag where id_atencion=$id_atencion order by fecha ASC") or die($conexion->error);
$total = 0;
$no = 1;
while ($row3 = $resultado3->fetch_assoc()) {

  $date = date_create($row3['fecha']);
  $pdf->Cell(7, 8, utf8_decode($no), 1, 0,'C');
  $pdf->Cell(23, 8, date_format($date, 'd/m/Y'),1, 0,'C');
  $pdf->Cell(20, 8, utf8_decode($row3['tipo']),1, 'L');
  $pdf->Cell(80, 8, utf8_decode($row3['nombre']), 1, 'L');
  $pdf->Cell(15, 8, utf8_decode($row3['cantidad']),1, 0,'C');
  $pdf->Cell(25, 8, '$ ' . utf8_decode(number_format($row3['precio'], 2)), 1,0, 'R');
  $pdf->Cell(25, 8, '$ ' . utf8_decode(number_format($row3['subtotal'], 2)), 1,0, 'R');
  $pdf->Ln(8);
  $total = $row3['subtotal'] + $total;
  $no++;
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(5, 8, '', 0, 'C');
$pdf->Cell(25, 8, '', 0, 'L');
$pdf->Cell(20, 8, '', 0, 'L');
$pdf->Cell(80, 8, '', 0, 'L');
$pdf->Cell(15, 8, '', 0, 'C');
$pdf->Cell(25, 8, 'Total: ', 1, 'R');
$pdf->Cell(25, 8, '$ ' . number_format($total, 2), 1,0, 'R');
$pdf->Ln(10);


$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(202, 10, utf8_decode('DEPÓSITOS'), 0, 0, 'L');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 7);

$pdf->Cell(60, 8, utf8_decode('DEPOSITA'), 1,0, 'C');
$pdf->Cell(60, 8, utf8_decode('COBRÓ'), 1,0, 'C');
$pdf->Cell(20, 8, utf8_decode('CANTIDAD'), 1,0, 'C');
$pdf->Cell(28, 8, utf8_decode('TIPO DE DÉPÓSITO'), 1,0, 'C');
$pdf->Cell(30, 8, utf8_decode('FECHA Y HORA'), 1, 0,'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(8);

$resultado4 = $conexion->query("SELECT * FROM dat_financieros df, reg_usuarios r where df.id_atencion = $id_atencion and df.id_usua=r.id_usua") or die($conexion->error);
$total_dep = 0;
$no = 1;
while ($row4 = $resultado4->fetch_assoc()) {
  $pdf->SetFont('Arial', '', 7);
  $pdf->Cell(60, 8, utf8_decode($row4['resp']), 1, 'L');
  $pdf->Cell(60, 8, utf8_decode($row4['papell'].' '.$row4['sapell']), 1, 'L');
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(20, 8, number_format(utf8_decode($row4['deposito']), 2),1,0, 'R');
  $pdf->Cell(28, 8, utf8_decode($row4['banco']),1, 'L');
  $pdf->Cell(30, 8, utf8_decode($row4['fecha']), 1, 'L');
  $pdf->Ln(8);
  $total_dep = $row4['deposito'] + $total_dep;
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(120, 8, 'Total: ', 1, 'R');
$pdf->Cell(20, 8, '$ ' . number_format($total_dep, 2),1,0, 'R');
$pdf->Ln(8);
$pdf->Output();
