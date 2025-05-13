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
    $this->Cell(0, 10, utf8_decode('MAC-12.01'), 0, 1, 'R');
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

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac, p.folio FROM paciente p where p.Id_exp = $id_exp";
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

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

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
$pdf->Cell(20, 6, 'Luga y fecha: ', 0, 'L');  
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y H:i a");
$pdf->Cell(44, 5.5, utf8_decode('Metepec' . ' ' . $fecha_actual) , 'B', 'L');
$pdf->SetFont('Arial', '', 8);

if(isset($num_cam)){
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode(' Habitación: '),  0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(12, 5.5,  $num_cam, 'B',0, 'C');
}else{
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(21, 6, utf8_decode(' Habitación: '),  0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 5.5, 'S/H ', 'B', 'L');
}
$pdf->Cell(21, 6, ' Expediente: ', 0, 'L');
$pdf->Cell(15, 5.5, $folio, 'B',0, 'C');

$pdf->SetFont('Arial', '', 8);
$date=date_create($fecnac);
$pdf->Cell(36, 6, ' Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23, 5.5, date_format($date,"d/m/Y"), 'B',0, 'C');
$pdf->Ln(7);


$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 6, 'Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(102, 5.5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 6, 'Edad: ', 0, 'L');

$pdf->Cell(22, 5.5, utf8_decode($edad), 'B',0, 'C');


$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 6, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(28, 5.5,  $sexo, 'B', 'L');


$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(77, 6, utf8_decode('Carácter de la cirugía o procedimiento: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 6, utf8_decode('Electivo'), 0, 0, 'L');
$pdf->Cell(10, 6, utf8_decode(''), 1, 0, 'L');
$pdf->Cell(18, 6, utf8_decode('Urgente'), 0, 0, 'L');
$pdf->Cell(10, 6, utf8_decode(''), 1, 0, 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(48, 6, utf8_decode('Diagnóstico preoperatorio: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(144, 5.5, utf8_decode(''), 'B', 'L');
$pdf->Ln(6.5);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(48, 6, utf8_decode('Cirugía o procedimiento planeado: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(144, 5.5, utf8_decode($especialidad), 'B', 'L');
$pdf->Ln(8);

$pdf->MultiCell(193, 4, utf8_decode('De acuerdo con la Norma Oficial Mexicana NOM-004-SSA3-2012 del Expediente Clínico Médico, publicado el 15 de Octubre de 2012 en el Diario Oficial de la Federación y la Norma Oficial Mexicana NOM-006-SSA3-2011, para la práctica de la anestesiología publicada en el Diario Oficial de la Federación el dia 23 de Marzo de 2012, es presentado este documento, escrito y signado por el paciente y/o representante legal, así como por dos testigos, mediante el cual acepta, bajo la debida información de los riesgos y los beneficios esperados del procedimiento anestésico. Esta carta se sujetará a las disposiciones sanitarias en vigor y no obliga el médico a realizar y omitir procedimientos cuando ello entrañe un riesgo injustificado para el paciente.'), 0, 'J');
$pdf->Ln(4);
$pdf->Cell(0, 4, utf8_decode('Por consiguiente y en calidad de paciente:'), 0, 'L');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 8);
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

$pdf->Cell(125, 4, utf8_decode('En virtud de lo anterior, doy mi consentimiento por escrito para que los médicos anestesiólogos de'), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(67, 4, utf8_decode('Médica del Ángel Custodio'), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);

$pdf->Ln(4);
$pdf->MultiCell(193, 4, utf8_decode('lleve a cabo los procedimientos que considere necesarios para realizar la cirugía o procedimiento médico al que he decidido someterme, habiendo entendido que si ocurren complicaciones en la aplicación de la técnica anestésica, no existe conducta dolosa.'), 0, 'J');

$pdf->Ln(9);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 4, utf8_decode('ACEPTO'), 0, 0, 'C');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);


$pdf->Ln(15);
$pdf->SetX(20);
$pdf->Cell(80, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 0, 'C');

$pdf->SetX(110);
$pdf->Cell(80, 6, utf8_decode($resp), 'B', 0, 'C');

$pdf->Ln(6);
$pdf->SetX(20);
$pdf->Cell(80, 6, utf8_decode('NOMBRE Y FIRMA PACIENTE'), 0, 0, 'C');

$pdf->SetX(110);
$pdf->Cell(80, 6, utf8_decode('NOMBRE Y FIRMA DE QUIEN AUTORIZA'), 0, 0, 'C');

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

$pdf->Ln(-10);
$pdf->SetX(110);
$pdf->Cell(80, 6, utf8_decode($user_pre . ' ' . $user_papell), 0,0, 'C');
$pdf->Ln(5);
$pdf->SetX(145);
$pdf->Cell(10, 4, utf8_decode($cargp.' CÉD. PROF. ' . $ced_p), 0, 0, 'C');


$pdf->AddPage();


$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(8, 42, 205, 42);
$pdf->Line(8, 42, 8, 280);
$pdf->Line(205, 42, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(3);
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
$pdf->MultiCell(193, 4, utf8_decode('o MULTIPUNCIONES VASCULARES (DIFICULTAD PARA ENCONTRAR VENA ÚTIL PARA APLICAR SOLUCIONES.'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o "MORETONES" POSPUNCIÓN VENOSA.'), 0, 'J');
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
$pdf->MultiCell(193, 4, utf8_decode('o INYECCIÓN INTRA VASCULAR INADVERTIDA DEL ANESTÉSICO CON EFECTOS INDESEABLES, PUEDE CAMBIAR LA TÉCNICA ANESTÉSICA (CUADRO 4).'), 0, 'J');
$pdf->MultiCell(193, 4, utf8_decode('o RESUESTA ADVERSA DEL PACIENTE A LOS MEDICAMENTOS APLICADOS PARA ANESTESIA REGIONAL QUE PUEDEN PROVOCAR EL FALLECIMIENTO. '), 0, 'J');


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


$pdf->Ln(4.5);
$pdf->SetX(70);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Cell(80, 6, utf8_decode(''), 'B', 0, 'C');
$pdf->Ln(6);
$pdf->SetX(71);
$pdf->Cell(80, 6, utf8_decode('NOMBRE Y FIRMA DEL ANESTESIÓLOGO QUE INFORMA'), 0, 0, 'C');




$pdf->Output();
