<?php

use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
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
    $this->Cell(0, 10, utf8_decode('MAC-12.04'), 0, 1, 'R');
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
   $cargp = $row_reg_usrs['cargp'];
   $cedp = $row_reg_usrs['cedp'];
}

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac,p.tip_san, p.folio FROM paciente p where p.Id_exp = $id_exp";
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
  $tip_san = $row_pac['tip_san'];
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

$sql_san = "SELECT solicitud_sang FROM dat_ordenes_med WHERE id_atencion= $id_atencion || solicitud_sang <> 'NINGUNO'";
$result_san = $conexion->query($sql_san);

while ($row_san = $result_san->fetch_assoc()) {
  $solicitud_sang = $row_san['solicitud_sang'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('CARTA DE CONSENTIMIENTO INFORMADO PARA LA TRANSFUSIÓN SANGUÍNEA
'), 0, 'C');


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

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(200, 5, utf8_decode('DATOS DEL PACIENTE QUE RECIBE LA TRANSFUSIÓN'), 0, 0,'C');
$pdf->Ln(8);

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
$pdf->Cell(10, 6, utf8_decode($folio), 'B', 0, 'C');
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

$pdf->Cell(27, 6, utf8_decode($edad), 'B', 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(13, 6, utf8_decode('Género: '), 0, 'L');
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

$pdf->Ln(7.5);
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
    $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(20, 4, utf8_decode('Diagnóstico:') , 0, 'C');
  $pdf->SetFont('Arial', '', 8);
     $pdf->Cell(172, 4, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', '', 8);
         $pdf->Cell(26, 4, utf8_decode('Motivo de atención:') , 1, 'C');
         $pdf->SetFont('Arial', '', 7);
         $pdf->Cell(168, 4, utf8_decode($m) , 1, 'C');
    }
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(200, 5, utf8_decode('DATOS DE LA TRANSFUSIÓN'), 0, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(45, 6, utf8_decode('Tipo de sangre del Paciencte : '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(146, 6, utf8_decode($tip_san), 'B', 'L');
$pdf->Ln(8);
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(63, 6, utf8_decode('Componente(s) sanguíneo(s) a transfundir: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(128, 6, utf8_decode($solicitud_sang), 'B', 'L');
$pdf->Ln(8);


$pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(190, 6, utf8_decode('YO: ' . ' ' . $papell . ' ' . $sapell . ' ' . $nom_pac) , 'B', 'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(60, 6, 'BAJO PROTESTA DE DECIR VERDAD DECLARO QUE: ', 0, 'L');

$pdf->Ln(8);
$pdf->multiCell(190, 6, utf8_decode('1. He recibido información a mi entera satisfacción sobre los riesgos y consecuencias de la transfusión de componentes sanguíneos, se me brindo la oportunidad de hacer preguntas y fueron contestadas a mi agrado por un profesional capacitado.'), 0, 'J');

$pdf->Ln(4);
$pdf->multiCell(190, 6, utf8_decode('2. Me considero informado de las ventajas e inconvenientes del procedimiento de transfusión sanguínea que se llevará a cabo.'), 0, 'J');

$pdf->Ln(4);
$pdf->multiCell(190, 6, utf8_decode('3.Por propia voluntad y con pleno conocimiento de causa, consiento la transfusión que se me ha indicado y autorizo al personal de salud atender las contingencias derivadas del acto consentido, atendiendo al principio de autoridad prescriptiva.'), 0, 'J');


$pdf->SetFont('Arial', '', 8);
$pdf->Ln(60);

$pdf->SetX(10);
$pdf->Cell(94, 6, utf8_decode($user_pre . ' ' . $user_papell), 0, 0, 'C');
$pdf->SetX(110);
$pdf->Cell(94, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 0, 0, 'C');

$pdf->Ln(5);

$pdf->SetX(10);
$pdf->Cell(94, 4, utf8_decode($cargp) . ' ' .  utf8_decode('CÉD. PROF. ' . $cedp), 0, 0, 'C');
$pdf->SetX(110);
$pdf->MultiCell(94, 4, utf8_decode('Paciente, familiar o persona legalmente responsable del paciente'), 0, 'C');

$pdf->SetX(10);
$pdf->Cell(94, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(94, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');
$pdf->Ln(-5);
$pdf->SetX(22);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Cell(70, 6, utf8_decode(''), 'B', 0, 'C');

$pdf->SetX(112.5);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Cell(90, 6, utf8_decode(''), 'B', 0, 'C');

$pdf->Output();
