<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id_atencion'];

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id = @$_GET['id'];;

    include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 28);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
  }}
  function Footer()
  {
    $this->SetFont('Arial', '', 8);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, 'MAC-021', 0, 1, 'R');
  }
}

$sql_reg_usu = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.id_usua";

$result_reg_usu = $conexion->query($sql_reg_usu);
while ($row_reg_usu = $result_reg_usu->fetch_assoc()) {
  $pre = $row_reg_usu['pre'];
  $papell = $row_reg_usu['papell'];
  $sapell = $row_reg_usu['sapell'];
  $nombre = $row_reg_usu['nombre'];
  $id_exp = $row_reg_usu['Id_exp'];
}

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.edad, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";
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
  $id_mun= $row_pac['id_mun'];
  $edad= $row_pac['edad'];
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

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(28, 52, 192, 52);
$pdf->Line(28, 41, 28, 52);
$pdf->Line(192, 41, 192, 52);
$pdf->Line(28, 41, 192, 41);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 55, 205, 55);
$pdf->Line(8, 55, 8, 280);
$pdf->Line(205, 55, 205, 280);
$pdf->Line(8, 280, 205, 280);


$pdf->SetFont('Arial', 'B', 11);

$pdf->SetY(41);
$pdf->SetTextColor(43, 45, 187);
$pdf->MultiCell(200, 9.5, utf8_decode('CARTA DE CONSENTIMIENTO PARA TRATAMIENTO DE DATOS PERSONALES'), 0, 'C');

$fecha_actual = date("d/m/Y");


 explode("-", $fecha_actual);
 $ano  = date("Y") ;
  $mes= date("m") ;
  $dia  = date("d") ;


   if ($mes==1) {
    $mes='enero';
  }

 if ($mes==2) {
    $mes='febrero';
  }
   if ($mes==3) {
    $mes='marzo';
  }
 if ($mes==4) {
    $mes='abril';
  }
  if ($mes==5) {
    $mes='mayo';
  }
   if ($mes==6) {
    $mes='junio';
  }
   if ($mes==7) {
    $mes='julio';
  }
   if ($mes==8) {
    $mes='agosto';
  }
   if ($mes==9) {
    $mes='septiembre';
  }
   if ($mes==10) {
    $mes='octubre';
  }
   if ($mes==11) {
    $mes='noviembre';
  }
   if ($mes==12) {
    $mes='diciembre';
  }

$pdf->Ln(8);

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(34, 6, utf8_decode('El (la) que suscribe : '), 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(160, 6, utf8_decode($pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac), 'B', 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(34, 6, utf8_decode('Con domicilio en: '), 0, 'L');
$pdf->Cell(160, 6, utf8_decode($pac_dir . ', ' . $nom_edo_pac . ', ' . $nom_mun_pac), 'B', 'L');
$pdf->Ln(8);

$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(195, 8, utf8_decode('OTORGO MI CONSENTIMIENTO EXPRESO a efecto de que MÉDICA DEL ÁNGEL CUSTODIO, recabe, almacene, proteja y trate mis datos personales, que son necesarios para brindarme una atención médica.'), 0, 'J');

$pdf->Ln(2);
$pdf->MultiCell(195, 8, utf8_decode('Para tales efectos, manifiesto que tengo pleno conocimiento del contenido del Aviso de Privacidad Integral relativo al tratamiento de mis datos personales, el cual también es público y consultable a través del portal de internet https://medicasanisidro.com/privacidad y que me encuentro plenamente informado del nombre, domicilio y teléfono del Responsable del tratamiento de mis datos personales; del fundamento legal que lo faculta para llevarlo a cabo; de los datos personales que serán recabados, según sea el caso; de la finalidad de su tratamiento; del ciclo de vida de los mismos; de los mecanismos, medios y procedimientos disponibles para ejercer mis derechos de Acceso, Rectificación, Cancelación y Oposición (derechos ARCO). Asimismo, en este acto manifiesto que me encuentro informado que derivado de la atención médica se requieren estudios de diagnóstico y tratamiento que se me realicen; y documentos que integren mi expediente. Finalmente, de manera voluntaria, libre y expedita SI otorgo mi consentimiento para que, por razones de control de calidad y transparencia, la atención médica que en su caso me realice MÉDICA DEL ÁNGEL CUSTODIO con motivo de mejorar mi estado de salud, puedan ser registradas en medios electrónicos e impresos, quedando bajo su más estricto resguardo y protección en un Expediente Clínico, los cuales estarán almacenados durante el tiempo que establece la Ley para tal efecto, en términos de las disposiciones jurídicas aplicables en materia de Protección de Datos Personales y de Normas oficiales Mexicanas.'), 0, 'J');

$fecha_actual = date("d/m/Y");
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(195, 6, utf8_decode('Metepec, Méxco a '. $dia.' de '.$mes.' de '.$ano.'. ' ) ,0,0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100, 6, utf8_decode('PACIENTE'), 0, 0, 'C');
$pdf->Cell(100, 6, utf8_decode('RESPONSABLE'), 0, 0, 'C');
$pdf->Ln(8);

$pdf->Cell(100, 6, utf8_decode($pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac),0, 0, 'C');
$pdf->Cell(100, 6, utf8_decode($resp), 0, 0, 'C');
$pdf->Ln(3);
$pdf->Cell(100, 6, utf8_decode('_________________________________________'), 0, 0, 'C');
$pdf->Cell(100, 6, utf8_decode('_________________________________________'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(100, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');
$pdf->Cell(100, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');

$pdf->Output();
