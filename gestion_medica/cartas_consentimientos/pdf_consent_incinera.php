<?php

use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$amp = @$_POST['amp'];
$fechade = @$_POST['fechade'];
$aceptan = @$_POST['aceptan'];
$tesuno = @$_POST['tesuno'];
$tesdos = @$_POST['tesdos'];
$vobo = @$_POST['vobo'];


$amp = @$_GET['amp'];
$fechade = @$_GET['fechade'];
$aceptan = @$_GET['aceptan'];
$tesuno = @$_GET['tesuno'];
$tesdos = @$_GET['tesdos'];
$vobo = @$_GET['vobo'];
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
   $this->Ln(32);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-12.08'), 0, 1, 'R');
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
$pdf->MultiCell(165, 9.5, utf8_decode('RESPONSIVA DE INCINERACIÓN'), 0, 'C');


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
$pdf->Cell(135, 5.5, utf8_decode(' '),0 , 0, 'L');

$fecha_actual = date("d");
$fecha_actualm = date("m");
$fecha_actualy = date("Y");
$pdf->Cell(23, 5.5, utf8_decode('Metepec, México a'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(5, 5, $fecha_actual, 'B', 0, 'L');
$pdf->Cell(5, 5.5, utf8_decode('de'),0 , 0, 'L');
$pdf->Cell(5, 5, $fecha_actualm, 'B', 0, 'L');
$pdf->Cell(10, 5.5, utf8_decode('del año'),0 , 0, 'L');
$pdf->Cell(8, 5, $fecha_actualy, 'B', 0, 'L');
$pdf->Ln(12);
$pdf->Cell(202, 5.5, utf8_decode('CARTA RESPONSIVA'),0 , 0, 'C');
$pdf->Ln(15);

$pdf->Cell(93, 5.5, utf8_decode('Por medio de la presente me dirijo a usted y certifico que el (la) paciente '),0 , 0, 'J');
$pdf->Cell(66, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac) , 'B', 'C');
$pdf->Cell(5, 5.5, utf8_decode('de'),0 , 0, 'J');

$pdf->Cell(12, 5, utf8_decode($edad), 'B', 'C');

$pdf->Cell(55, 5.5, utf8_decode('se encuentra'),0 , 0, 'J');
$pdf->Ln(8);
$pdf->Cell(110, 5.5, utf8_decode('Hospitalizado en ésta Unidad Médica Hospitalaria Clínica Médica S.I.S.C desde el día'),0 , 0, 'J');

$dated=date_create($fecha_ing);
$datem=date_create($fecha_ing);
$datey=date_create($fecha_ing);
$pdf->Cell(7, 5, date_format($dated, "d") , 'B', 'C');
$pdf->Cell(15, 5.5, utf8_decode('del mes de'),0 , 0, 'J');
$pdf->Cell(7, 5, date_format($datem, "m") , 'B', 'C');
$pdf->Cell(11, 5.5, utf8_decode('del año'),0 , 0, 'J');
$pdf->Cell(8, 5, date_format($datey, "Y") , 'B', 'C');
$pdf->Cell(11, 5.5, utf8_decode('con diagnóstico de'),0 , 0, 'J');
$pdf->Ln(8);
$d="";
      $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by diagprob_i ASC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } ?>
    <?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
    $result_mot = $conexion->query($sql_mot);
    while ($row_mot = $result_mot->fetch_assoc()) {
    $m=$row_mot['motivo_atn'];
    } 
if ($d!=null) {
  $pdf->Cell(192, 4, ($d) , 'B', 'C');
     
    } else{
         $pdf->Cell(192, 4, ($m) , 'B', 'C');
    }

$pdf->Ln(8);
$pdf->Cell(55, 5.5, utf8_decode('Motivo por el cual se decide realizar amputación'),0 , 0, 'J');
$pdf->Cell(137, 5, ($amp) , 'B', 'C');
$pdf->Ln(8);
$pdf->Cell(9, 5.5, utf8_decode('el dia'),0 , 0, 'J');
$pdf->Cell(16, 5, ($fechade) , 'B', 'C');
$pdf->Cell(73, 5.5, utf8_decode('Actualmente el (la) paciente y familiares aceptan que su'),0 , 0, 'J');
$pdf->Cell(55, 5, ($aceptan) , 'B', 'C');
$pdf->MultiCell(42, 4, utf8_decode('quede a cargo de ésta unidad hospitalaria'),0 , 'J');
$pdf->Ln(-1);
$pdf->Cell(95, 5.5, utf8_decode('para realizar su manejo y disposición final de acuerdo a la Norma Oficial Mexicana aplicable.'),0 , 0, 'J');



$pdf->Ln(30);
$pdf->Cell(17, 5.5, utf8_decode('PACIENTE:'),0 , 0, 'J');
$pdf->Cell(60, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac) , 'B', 'C');
$pdf->Ln(20);
$pdf->Cell(17, 5.5, utf8_decode('TESTIGO 1:'),0 , 0, 'J');
$pdf->Cell(60, 5, utf8_decode($tesuno) , 'B', 'C');
$pdf->Ln(20);
$pdf->Cell(17, 5.5, utf8_decode('TESTIGO 2:'),0 , 0, 'J');
$pdf->Cell(60, 5, utf8_decode($tesdos) , 'B', 'C');
$pdf->Ln(20);
$pdf->Cell(30, 5.5, utf8_decode('MÉDICO TRATANTE:'),0 , 0, 'J');
$pdf->Cell(60, 5, utf8_decode($user_pre . ' ' . $user_papell) , 'B', 'C');
$pdf->Ln(20);
$pdf->Cell(52, 5.5, utf8_decode('VoBo. Dirección clínica médica S.I.S.C:'),0 , 0, 'J');
$pdf->Cell(60, 5, utf8_decode($vobo) , 'B', 'C');
$pdf->Ln(20);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(45, 5.5, utf8_decode('NOTA: se anexa copia de identificaciones oficiales del paciente, testigos, y Médico tratante al presente documento.'),0 , 0, 'J');

$pdf->Output();
