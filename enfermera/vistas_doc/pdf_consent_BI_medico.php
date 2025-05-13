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
    $this->Cell(0, 10, utf8_decode('CMSI-12.03'), 0, 1, 'R');
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
$pdf->MultiCell(165, 9.5, utf8_decode('CARTA DE CONSENTIMIENTO INFORMADO'), 0, 'C');


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
$pdf->Cell(17, 6, 'Lugar: ', 0, 'L');  
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(88.5, 6, utf8_decode('Metepec') , 'B', 'L');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date_create();
$fecha_actual = date_format($fecha_actual,"d/m/Y H:i a");
$pdf->Cell(19, 6, utf8_decode(' Fecha y hora:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(67, 6, $fecha_actual, 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(4);

$pdf->Ln(4);


$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 6, 'Paciente:', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(98, 5.5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac) , 'B', 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, 'Fecha de nacimiento: ', 0, 'L'); 
$pdf->SetFont('Arial', '', 8);
$date=date_create($fecnac);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 5.5, date_format($date,"d/m/Y"), 'B', 0, 'C');; 
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 6, 'Expediente: ', 0, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 5.5, utf8_decode($folio), 'B', 1, 'C');


$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10.5, 6, 'Edad: ', 0, 'L');

$pdf->Cell(25, 6, utf8_decode($edad), 'B', 'C');

$pdf->Cell(15.5, 6, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6,  $sexo, 'B', 'L');
$pdf->Cell(20.5, 6, utf8_decode('Ocupación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 6,  utf8_decode($ocup), 'B', 'L');
$pdf->Cell(20.5, 6, utf8_decode('Estado civil: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 6,  utf8_decode($edociv), 'B', 'L');

/*
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
*/


$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 5, utf8_decode('Domicilio (calle, número, colonia, localidad, municipio, estado: '), 0,1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(192, 5, utf8_decode($dir. ' ' .$loc . ', ' .$nom_mun . ', ' . $nom_es), 'B', 'L');
$pdf->SetFont('Arial', '', 8);

/*if(isset($num_cam)){
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(19, 6, utf8_decode(' Habitación: '),  0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6,  $num_cam, 'B', 'C');
}else{
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(19, 6, utf8_decode(' Habitación: '),  0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, 'S/H ', 'B', 'L');
}*/
$pdf->Ln(3);
/*
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(47, 6, 'Nombre del Representante legal: ' , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(103, 6, utf8_decode($resp), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 6, 'Parentesco: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(24, 6, utf8_decode($paren), 'B', 'L');

*/

$pdf->Ln(6);
$pdf->Cell(37, 6, utf8_decode('Los médicos del servicio de: '), 0, 'L');
$pdf->Cell(120, 6, utf8_decode($medico), 'B', 'L');
$pdf->Cell(33, 6, utf8_decode('me han informado de mi(s)'), 0, 'L');

$pdf->Ln(6);

$pdf->MultiCell(190, 6, utf8_decode('padecimiento(s), por lo que necesito someterme a estudios de laboratorio, gabinete,histopatológicos, y de procedmientos anestésicos, asi como tratamiento(s) médico(s) y/o quirúrgico(s) considerados como indispensables para recuperar mi salud.'), 0, 'L');

$pdf->MultiCell(190, 6, utf8_decode('Los médicos me informaron de los riesgos y de las posibles cmplicaciones de los medios de diagnóstico y tratamientos médico y/o quirúrgicos, por lo que por este medio, libremente y sin presión alguna acepto a someterme a: '), 0, 'L');
$pdf->Ln(2);
$pdf->Cell(32, 6, utf8_decode('Diagnóstico(s) clinico(s)'), 0, 'L');
$pdf->Cell(160, 5.5, utf8_decode($diagnostico_pdf), 'B', 'L');

$pdf->Ln(7);
$pdf->Cell(67, 6, utf8_decode('Estudios de laboratorio, gabinete e histopatológicos:'), 0, 'J');
$pdf->Cell(125, 5.5, utf8_decode($estudios), 'B', 'L');
$pdf->Ln(7);

$pdf->Cell(25, 6, utf8_decode('Actos anestésicos:'), 0, 'J');
$pdf->Cell(167, 5.5, utf8_decode($actos), 'B', 'L');
$pdf->Ln(7);
$pdf->Cell(35, 6, utf8_decode('Tratamiento(s) médico(s):'), 0, 'J');
$pdf->Cell(157, 5.5, utf8_decode($trat), 'B', 'L');
$pdf->Ln(7);

$pdf->Cell(37, 6, utf8_decode('Tratamiento(s) quirúrgico(s):'), 0, 'J');
$pdf->Cell(155, 5.5, utf8_decode($tratquir), 'B', 'L');
$pdf->Ln(7);

$pdf->Cell(35, 6, utf8_decode('Riesgos y complicaciones:'), 0, 'J');
$pdf->Cell(157, 5.5, utf8_decode($ries), 'B', 'L');
$pdf->Ln(7);

$pdf->MultiCell(191, 6, utf8_decode('He sido informado de los riesgos que entraña el procedimiento, por lo que acepto los riesgos que implica el mismo.
Autorizo a los médicos de este hospital para que realicen los estudios y tratamientos convenientes.
En igual sentido, autorizo ante cualquier complicación o efecto adverso durante el procedimiento, especialmente ante una urgencia médica, que se apliquen las técnicas y procedimientos necesarios.
Tengo la plena librtad de evocar la autorización de los estudios y tratamientos en cualquier momento, antes de realizarse.
En caso de ser menor de edad o con capacidades diferentes, se informó y autoriza el responsable del paciente.'), 0, 'J');


$pdf->Ln(5);
$pdf->SetX(60);
$pdf->Cell(90, 6, utf8_decode($nom_pac . ' ' . $papell . ' ' . $sapell), 'B', 0, 'C');



$pdf->Ln(6);
$pdf->SetX(60);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA DE QUIEN AUTORIZA'), 0, 0, 'C');





$pdf->Ln(20);

$pdf->Cell(90, 6, utf8_decode($resp), 'B', 0, 'C');

$pdf->SetX(109);
$pdf->Cell(90, 6, utf8_decode($user_pre . ' ' . $user_papell), 'B', 0, 'C');
$pdf->Ln(5);
$pdf->SetX(109);
$pdf->Cell(90, 6, utf8_decode($cargp . ' ' . 'CÉD. PROF. ' . $ced_p), 0, 0, 'C');
$pdf->Ln(3.5);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA DEL TESTIGO'), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(90, 6, utf8_decode('NOMBRE Y FIRMA DEL TESTIGO'), 0, 0, 'C');

$pdf->Output();
