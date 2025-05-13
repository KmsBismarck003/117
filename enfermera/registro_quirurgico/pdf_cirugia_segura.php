<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id'];
$id_exp = @$_GET['id_exp'];
$id_cirseg = @$_GET['id_cir_seg'];
$id_med = @$_GET['id_med'];

$sql_seg = "SELECT * FROM dat_cir_seg  where id_atencion = $id_atencion";
$result_seg = $conexion->query($sql_seg);

while ($row_seg = $result_seg->fetch_assoc()) {
$id_cir_seg = $row_seg['id_cir_seg'];
}

if(isset($id_cir_seg)){
    $id_cir_seg = $id_cir_seg;
  }else{
    $id_cir_seg ='sin doc';
  }

if($id_cir_seg=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE NOTA DE CIRUGÍA SEGURA QUIRÚRGICA PARA ESTE PACIENTE", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                                window.close();
                            }
                        });
                    });
                </script>';
}else{
mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id = @$_GET['id'];

include '../../conexionbd.php';
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 10, 1, 55, 30);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],95,5, 100, 25);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 235, 7, 55, 20);
}

    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
    
    $this->Ln(10);
    $this->SetDrawColor(43, 45, 180);
    //$this->Line(78, 18, 220, 18);
   
   
    $this->Ln(12);
 
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-15.02'), 0, 1, 'R');
  }
}




$sql_pac = "SELECT * FROM paciente where Id_exp=$id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $fecnac = $row_pac['fecnac'];
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
    $edociv = $row_pac['edociv'];
    $edad=$row_pac['edad'];
}

//INICIO CONSULTA CIRUGIA SEGURA
$sql_seg = "SELECT * FROM dat_cir_seg where id_atencion =$id_atencion";
$result_seg = $conexion->query($sql_seg);

while ($row_seg = $result_seg->fetch_assoc()) {
$identidad = $row_seg['identidad'];
$sitquir = $row_seg['sitquir'];
$procquir = $row_seg['procquir'];
$suconsen = $row_seg['suconsen'];
$lug_noproc = $row_seg['lug_noproc'];
$fecha_registro= $row_seg['fecha_registro'];
$circonfase = $row_seg['circonfase'];
$conseg = $row_seg['conseg'];
$oximetro = $row_seg['oximetro'];
$alerg_con = $row_seg['alerg_con'];
$dif_via_aerea = $row_seg['dif_via_aerea'];
$reishemo = $row_seg['reishemo'];

  $nechemo = $row_seg['nechemo'];
  $fcirujano = $row_seg['fcirujano'];
  $fayucir = $row_seg['fayucir'];
  $fanest = $row_seg['fanest'];
  $instrumentista = $row_seg['instrumentista'];
  $fotros = $row_seg['fotros'];
  $paccorr = $row_seg['paccorr'];
  $proccorr = $row_seg['proccorr'];

  $sitquird = $row_seg['sitquird'];
  $encas = $row_seg['encas'];
  $casmul = $row_seg['casmul'];
  $poscpac = $row_seg['poscpac'];
  $anverpro = $row_seg['anverpro'];
  $img_diag = $row_seg['img_diag'];

 $pasocri = $row_seg['pasocri'];
  $durope = $row_seg['durope'];
  $persangre = $row_seg['persangre'];
  $exriesen = $row_seg['exriesen'];
  $fechm = $row_seg['fechm'];
  $exproble = $row_seg['exproble'];

  $nomprocre = $row_seg['nomprocre'];
  $recuento = $row_seg['recuento'];
  $etqmu = $row_seg['etqmu'];
  $proineq = $row_seg['proineq'];
  $prinrecpost = $row_seg['prinrecpost'];
  $plantrat = $row_seg['plantrat'];


 $riesgpaci = $row_seg['riesgpaci'];
  $eventosad = $row_seg['eventosad'];
  $reieventad = $row_seg['reieventad'];
  $donde = $row_seg['donde'];
  

  $fir_cir = $row_seg['fir_cir'];
  $fir_anest = $row_seg['fir_anest'];
  $fir_enf = $row_seg['fir_enf'];




}
 
//TERMINO CONSULTA CIRUGIA SEGURA
$sql_pac = "SELECT tipo_a FROM dat_ingreso where id_atencion = $id_atencion and Id_exp=Id_exp";
$result_pac = $conexion->query($sql_pac);
while ($row_pac = $result_pac->fetch_assoc()) {
  $tipo_a = $row_pac['tipo_a'];
}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(43, 45, 127);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(280, 6, utf8_decode('Hoja de cirugía segura'), 1,1, 'C');
$pdf->Setx(255);
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y H:i");
$pdf->Cell(35, 5, 'Fecha: ' . $fecha_actual, 0, 1, 'R');
$pdf->Ln(-4);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 6, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(126, 6, utf8_decode($tipo_a) , 'B', 'L');

$sql_ing = "SELECT * FROM dat_ingreso  where Id_exp = $id_exp";
$result_ing = $conexion->query($sql_ing);
while ($row_ing = $result_ing->fetch_assoc()) {
$especialidad = $row_ing['especialidad'];
  $fechai = $row_ing['fecha'];
  $area= $row_ing['area'];
    $tipo_a= $row_ing['tipo_a'];


}

$date=date_create($fechai);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(26, 6, utf8_decode(' Fecha de ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, date_format($date,'d/m/Y'), 'B', 0, 'C');

$fech_registro=date_create($fecha_registro);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(23, 6, utf8_decode(' Fecha de nota:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(31, 6, date_format($fech_registro,'d/m/Y H:i a'), 'B', 0, 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22, 6, utf8_decode('Expediente: '), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8, 6, utf8_decode($id_exp), 'B', 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 6, ' Nombre: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(96, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$date=date_create($fecnac);
$pdf->Cell(37, 6, ' Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 6, date_format($date,"d/m/Y"), 'B', 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(14, 6, ' Edad: ', 0, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 6, utf8_decode($edad), 'B', 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 6, utf8_decode(' Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(39, 6,  $sexo, 'B', 'L');

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(94, 4, utf8_decode('Fase 1:
Entrada'), 1,0, 'C');
$pdf->Cell(94, 4, utf8_decode('Fase 2: Pausa quirúrgica') , 1,0, 'C');
$pdf->Cell(94, 4, utf8_decode('Fase 3: Salida') , 1,1, 'C');
$pdf->SetFont('Arial', 'B', 7);

$pdf->Cell(94, 4, utf8_decode('Antes de la inducción de la anestesia'), 1,0, 'C');
$pdf->Cell(94, 4, utf8_decode('Antes de la incisión cutánea') , 1,0, 'C');
$pdf->Cell(94, 4, utf8_decode('Antes de que el paciente salga de quirófano') , 1,1, 'C');


//contenido
$pdf->SetY(62); /* Inicio */
$pdf->MultiCell(94, 3.5, utf8_decode('El cirujano, el anestesiólogo y el personal de enfermería en presencia del paciente han confirmado:'),0, 'J');


$pdf->SetFont('Arial', '', 7.5);
$pdf->SetY(69);
$pdf->SetX(5);
$pdf->MultiCell(93.9, 4, utf8_decode('Su identidad.'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($identidad=='Si'){
$pdf->SetY(69.5);
$pdf->SetX(35);
$identidad= 'X';
$pdf->Cell(3.5, 3, utf8_decode($identidad),1, 'L');
}else if ($identidad=='No') {
$pdf->SetY(69.5);
$pdf->SetX(35);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7.5);
$pdf->SetY(73);
$pdf->SetX(8);
$pdf->MultiCell(93.9, 4, utf8_decode('El sitio quirúrgico.'), 0, 'C'); 


$pdf->SetFont('Arial', 'B', 7.5);
if($sitquir=='Si'){
$pdf->SetY(73.5);
$pdf->SetX(35);
$sitquir= 'X';
$pdf->Cell(3.5, 3, utf8_decode($sitquir),1, 'L');
}else if ($sitquir=='No') {
$pdf->SetY(73.5);
$pdf->SetX(35);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(77);
$pdf->SetX(13);
$pdf->MultiCell(93.9, 4, utf8_decode('El procedimiento quirúrgico.'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($procquir=='Si'){
$pdf->SetY(77.5);
$pdf->SetX(35);
$procquir= 'X';
$pdf->Cell(3.5, 3, utf8_decode($procquir),1, 'L');
}else if ($procquir=='No') {
$pdf->SetY(77.5);
$pdf->SetX(35);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(81);
$pdf->SetX(8.3);
$pdf->MultiCell(93.9, 4, utf8_decode('Su consentimiento.'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($suconsen=='Si'){
$pdf->SetY(81.5);
$pdf->SetX(35);
$suconsen= 'X';
$pdf->Cell(3.5, 3, utf8_decode($suconsen),1, 'L');
}else if ($suconsen=='No') {
$pdf->SetY(81.5);
$pdf->SetX(35);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(85);
$pdf->MultiCell(93.9, 2.8, utf8_decode('¿El personal de enfermería ha confirmado con el cirujano que esté marcado el sitio quirúrgico?'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($lug_noproc=='Si'){
$pdf->SetY(91.5);
$pdf->SetX(35);
$lug_noproc= 'X';
$pdf->Cell(3.5, 3, utf8_decode($lug_noproc),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(91.5);
$pdf->SetX(55);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No procede'),0, 'C');
}else if ($lug_noproc=='No procede') {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetY(91.5);
$pdf->SetX(35);
$lug_noproc= 'X';
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(91.5);
$pdf->SetX(55);
$pdf->Cell(3.5, 3, utf8_decode($lug_noproc),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No procede'),0, 'C');
}

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(95.5);
$pdf->MultiCell(93.9, 2.9, utf8_decode('El cirujano ha confirmado la realización de asepsia en el sitio quirúrgico:'), 0, 'J'); 


if($circonfase=='Si'){
$pdf->SetY(99.9);
$pdf->SetX(35);
$circonfase= 'X';
$pdf->Cell(3.5, 3, utf8_decode($circonfase),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(99.9);
$pdf->SetX(55);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}else if ($circonfase=='No') {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetY(99.9);
$pdf->SetX(35);
$circonfase= 'X';
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(99.9);
$pdf->SetX(55);
$pdf->Cell(3.5, 3, utf8_decode($circonfase),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}


$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(104);
$pdf->MultiCell(93.9, 2.9, utf8_decode('El anestesiólogo ha completado el control de la seguridad de la anestesia al revisar: medicamentos, equipo (funcionalidad y condiciones óptimas) y el riesgo anestésico del paciente.'), 0, 'J'); 

if($conseg=='Si'){
$pdf->SetY(114);
$pdf->SetX(35);
$conseg= 'X';
$pdf->Cell(3.5, 3, utf8_decode($conseg),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(114);
$pdf->SetX(55);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}else if ($conseg=='No') {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetY(114);
$pdf->SetX(35);
$conseg= 'X';
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(114);
$pdf->SetX(55);
$pdf->Cell(3.5, 3, utf8_decode($conseg),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(118);
$pdf->MultiCell(93.9, 2.9, utf8_decode('El anestesiólogo ha colocado y comprobado que funcione el oxímetro de pulso correctamente.'), 0, 'J'); 


if($oximetro=='Si'){
$pdf->SetY(124.5);
$pdf->SetX(35);
$oximetro= 'X';
$pdf->Cell(3.5, 3, utf8_decode($oximetro),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(124.5);
$pdf->SetX(55);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}else if ($oximetro=='No') {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetY(124.5);
$pdf->SetX(35);
$oximetro= 'X';
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(124.5);
$pdf->SetX(55);
$pdf->Cell(3.5, 3, utf8_decode($oximetro),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(128);
$pdf->MultiCell(93.9, 2.9, utf8_decode('El anestesiólogo ha confirmado si el paciente tiene: ¿Alergias conocidas?'), 0, 'J'); 

if($alerg_con=='Si'){
$pdf->SetY(131.5);
$pdf->SetX(35);
$alerg_con= 'X';
$pdf->Cell(3.5, 3, utf8_decode($alerg_con),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(131.5);
$pdf->SetX(55);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}else if ($alerg_con=='No') {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetY(131.5);
$pdf->SetX(35);
$alerg_con= 'X';
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(131.5);
$pdf->SetX(55);
$pdf->Cell(3.5, 3, utf8_decode($alerg_con),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(135.5);
$pdf->MultiCell(93.9, 2.9, utf8_decode('¿Vía aérea difícil y/o riesgo de aspiración?'), 0, 'J'); 

if($dif_via_aerea=='Si'){
$pdf->SetY(139);
$pdf->SetX(35);
$dif_via_aerea= 'X';
$pdf->Cell(3.5, 3, utf8_decode($dif_via_aerea),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->MultiCell(35, 3, utf8_decode('Si, y se cuenta con material, equipo y ayuda disponible.'),0, 'J');
$pdf->SetY(139);
$pdf->SetX(80);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}else if ($dif_via_aerea=='No') {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetY(139);
$pdf->SetX(35);
$dif_via_aerea= 'X';
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->mULTICell(35, 3, utf8_decode('Si, y se cuenta con material, equipo y ayuda disponible.'),0, 'J');
$pdf->SetY(139);
$pdf->SetX(80);
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->Cell(3.5, 3, utf8_decode($dif_via_aerea),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}


$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(148.5);
$pdf->MultiCell(93.9, 2.9, utf8_decode('¿Riesgo de hemorragia en adultos >500 ml. (niños >7 ml / kg)?'), 0, 'J');

if($reishemo=='Si'){
$pdf->SetY(152.5);
$pdf->SetX(35);
$reishemo= 'X';
$pdf->Cell(3.5, 3, utf8_decode($reishemo),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->MultiCell(35, 3, utf8_decode('Si, y se ha previsto la disponibilidad de líquidos y dos vías centrales.'),0, 'J');
$pdf->SetY(152.5);
$pdf->SetX(80);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}else if ($reishemo=='No') {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetY(152.5);
$pdf->SetX(35);
$reishemo= 'X';
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->mULTICell(35, 3, utf8_decode('Si, y se ha previsto la disponibilidad de líquidos y dos vías centrales.'),0, 'J');
$pdf->SetY(152.5);
$pdf->SetX(80);
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->Cell(3.5, 3, utf8_decode($reishemo),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(161.5);
$pdf->MultiCell(93.9, 2.9, utf8_decode('¿Posible necesidad de hemoderivados y soluciones disponibles?'), 0, 'J');

if($nechemo=='Si'){
$pdf->SetY(166);
$pdf->SetX(35);
$nechemo= 'X';
$pdf->Cell(3.5, 3, utf8_decode($nechemo),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->MultiCell(35, 3, utf8_decode('Si, y ya se ha realizado el cruce de sangre'),0, 'J');
$pdf->SetY(166);
$pdf->SetX(80);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}else if ($nechemo=='No') {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetY(166);
$pdf->SetX(35);
$nechemo= 'X';
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->mULTICell(35, 3, utf8_decode('Si, y ya se ha realizado el cruce de sangre'),0, 'J');
$pdf->SetY(166);
$pdf->SetX(80);
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->Cell(3.5, 3, utf8_decode($nechemo),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}












$pdf->SetY(62);
$pdf->SetX(104); 
 /* 2da culomn */
 $pdf->SetFont('Arial', 'B', 7.0);
$pdf->MultiCell(94, 3.5, utf8_decode('El circulante ha identificado a cada uno de los miembros del quipo quirúrgico para se presenten por su nombre y función, sin omisiones.'),0, 'J');


$pdf->SetFont('Arial', '', 7.5);
$pdf->SetY(69);
$pdf->SetX(96.3);
$pdf->MultiCell(93.9, 4, utf8_decode('Cirujano.'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($fcirujano=='Si'){
$pdf->SetY(69.5);
$pdf->SetX(130);
$fcirujano= 'X';
$pdf->Cell(3.5, 3, utf8_decode($fcirujano),1, 'L');
}else if ($fcirujano=='No') {
$pdf->SetY(69.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7.5);
$pdf->SetY(73);
$pdf->SetX(104);
$pdf->MultiCell(93.9, 4, utf8_decode('Ayudante de cirujano.'), 0, 'C'); 


$pdf->SetFont('Arial', 'B', 7.5);
if($fayucir=='Si'){
$pdf->SetY(73.5);
$pdf->SetX(130);
$fayucir= 'X';
$pdf->Cell(3.5, 3, utf8_decode($fayucir),1, 'L');
}else if ($fayucir=='No') {
$pdf->SetY(73.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(77);
$pdf->SetX(99.4);
$pdf->MultiCell(93.9, 4, utf8_decode('Antestesiólogo'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($fanest=='Si'){
$pdf->SetY(77.5);
$pdf->SetX(130);
$fanest= 'X';
$pdf->Cell(3.5, 3, utf8_decode($fanest),1, 'L');
}else if ($fanest=='No') {
$pdf->SetY(77.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(81);
$pdf->SetX(99.2);
$pdf->MultiCell(93.9, 4, utf8_decode('Instrumentista'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($instrumentista=='Si'){
$pdf->SetY(81.5);
$pdf->SetX(130);
$instrumentista= 'X';
$pdf->Cell(3.5, 3, utf8_decode($instrumentista),1, 'L');
}else if ($instrumentista=='No') {
$pdf->SetY(81.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7);
$pdf->SetY(85);
$pdf->SetX(94.5);
$pdf->MultiCell(93.9, 4, utf8_decode('Otros'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($fotros=='Si'){
$pdf->SetY(85.5);
$pdf->SetX(130);
$fotros= 'X';
$pdf->Cell(3.5, 3, utf8_decode($fotros),1, 'L');
}else if ($fotros=='No') {
$pdf->SetY(85.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetY(89.5);
$pdf->SetX(104); 
 /* 2da culomn */
 $pdf->SetFont('Arial', 'B', 7.0);
$pdf->MultiCell(94, 3.5, utf8_decode('El cirujano, ha confirmado de manera verbal con el anestesiólogo y el personal de enfermería:'),0, 'J');


$pdf->SetFont('Arial', '', 7.5);
$pdf->SetY(96);
$pdf->SetX(101);
$pdf->MultiCell(93.9, 4, utf8_decode('Paciente correcto.'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($paccorr=='Si'){
$pdf->SetY(96.5);
$pdf->SetX(130);
$paccorr= 'X';
$pdf->Cell(3.5, 3, utf8_decode($paccorr),1, 'L');
}else if ($paccorr=='No') {
$pdf->SetY(96.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7.5);
$pdf->SetY(100);
$pdf->SetX(104);
$pdf->MultiCell(93.9, 4, utf8_decode('Procedimiento correcto'), 0, 'C'); 


$pdf->SetFont('Arial', 'B', 7.5);
if($proccorr=='Si'){
$pdf->SetY(100.5);
$pdf->SetX(130);
$proccorr= 'X';
$pdf->Cell(3.5, 3, utf8_decode($proccorr),1, 'L');
}else if ($proccorr=='No') {
$pdf->SetY(100.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(104);
$pdf->SetX(98.5);
$pdf->MultiCell(93.9, 4, utf8_decode('Sitio quirúrgico'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($sitquird=='Si'){
$pdf->SetY(104.5);
$pdf->SetX(130);
$sitquird= 'X';
$pdf->Cell(3.5, 3, utf8_decode($sitquird),1, 'L');
}else if ($sitquird=='No') {
$pdf->SetY(104.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(108);
$pdf->SetX(136.3);
$pdf->MultiCell(61, 3, utf8_decode('En caso de órgano bilateral, ha marcado derecho o izquierdo, según corresponda'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($encas=='Si'){
$pdf->SetY(108.5);
$pdf->SetX(130);
$encas= 'X';
$pdf->Cell(3.5, 3, utf8_decode($encas),1, 'L');
}else if ($encas=='No') {
$pdf->SetY(108.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7);
$pdf->SetY(114.5);
$pdf->SetX(136.3);
$pdf->MultiCell(61, 3, utf8_decode('En caso de estructura múltiple, ha especificado el nivel a operar.'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($casmul=='Si'){
$pdf->SetY(115.5);
$pdf->SetX(130);
$casmul= 'X';
$pdf->Cell(3.5, 3, utf8_decode($casmul),1, 'L');
}else if ($casmul=='No') {
$pdf->SetY(115.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(120);
$pdf->SetX(107.2);
$pdf->MultiCell(93.9, 4, utf8_decode('Posición correcta del paciente.'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($poscpac=='Si'){
$pdf->SetY(120.5);
$pdf->SetX(130);
$poscpac= 'X';
$pdf->Cell(3.5, 3, utf8_decode($poscpac),1, 'L');
}else if ($poscpac=='No') {
$pdf->SetY(120.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(125);
$pdf->SetX(104);
$pdf->MultiCell(93.9, 2.8, utf8_decode('¿El anestesiólogo y el personal de enfermería han verificado que se haya aplicado la profilaxis antibiótica conforme a las indicaciones médicas?'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($anverpro=='Si'){
$pdf->SetY(132);
$pdf->SetX(130);
$anverpro= 'X';
$pdf->Cell(3.5, 3, utf8_decode($anverpro),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(132);
$pdf->SetX(148);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
$pdf->SetY(132);
$pdf->SetX(165);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No procede'),0, 'C');

}else if ($anverpro=='No') {
$pdf->SetY(132);
$pdf->SetX(130);
$anverpro= 'X';
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(132);
$pdf->SetX(148);
$pdf->Cell(3.5, 3, utf8_decode($anverpro),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
$pdf->SetY(132);
$pdf->SetX(165);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No procede'),0, 'C');

}else if ($anverpro=='No procede') {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetY(132);
$pdf->SetX(130);
$anverpro= 'X';
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(132);
$pdf->SetX(148);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
$pdf->SetY(132);
$pdf->SetX(165);
$pdf->Cell(3.5, 3, utf8_decode($anverpro),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No procede'),0, 'C');
}


$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(137);
$pdf->SetX(104);
$pdf->MultiCell(93.9, 2.8, utf8_decode('El cirujano y el personal de enfermería han verificado que cuenta con los estudios de imagen que requiere?'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($img_diag=='Si'){
$pdf->SetY(143.9);
$pdf->SetX(130);
$img_diag= 'X';
$pdf->Cell(3.5, 3, utf8_decode($img_diag),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(143.9);
$pdf->SetX(165);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No procede'),0, 'C');
}else if ($img_diag=='No procede') {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->SetY(143.9);
$pdf->SetX(130);
$img_diag= 'X';
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(143.9);
$pdf->SetX(165);
$pdf->Cell(3.5, 3, utf8_decode($img_diag),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No procede'),0, 'C');
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetY(148.5);
$pdf->SetX(104);
$pdf->MultiCell(90, 2.8, utf8_decode('Previsión de Eventos Críticos:'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(151);
$pdf->SetX(104);
$pdf->MultiCell(93.9, 2.8, utf8_decode('El cirujano ha informado:'), 0, 'J'); 



$pdf->SetFont('Arial', '', 7.5);
$pdf->SetY(153.5);
$pdf->SetX(136.5);
$pdf->MultiCell(93.9, 4, utf8_decode('Los pasos críticos o no sistematizados.'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($pasocri=='Si'){
$pdf->SetY(154);
$pdf->SetX(130);
$pasocri= 'X';
$pdf->Cell(3.5, 3, utf8_decode($pasocri),1, 'L');
}else if ($pasocri=='No') {
$pdf->SetY(154);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7.5);
$pdf->SetY(158);
$pdf->SetX(107.5);
$pdf->MultiCell(93.9, 4, utf8_decode('La duración de la operación.'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($durope=='Si'){
$pdf->SetY(158.5);
$pdf->SetX(130);
$durope= 'X';
$pdf->Cell(3.5, 3, utf8_decode($durope),1, 'L');
}else if ($durope=='No') {
$pdf->SetY(158.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(162);
$pdf->SetX(107.5);
$pdf->MultiCell(93.9, 4, utf8_decode('La pérdida de sangre prevista.'), 0, 'C'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($persangre=='Si'){
$pdf->SetY(162.5);
$pdf->SetX(130);
$persangre= 'X';
$pdf->Cell(3.5, 3, utf8_decode($persangre),1, 'L');
}else if ($persangre=='No') {
$pdf->SetY(162.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(166);
$pdf->SetX(104);
$pdf->MultiCell(93.9, 2.8, utf8_decode('El anestesiólogo ha informado:'), 0, 'J'); 

$pdf->SetFont('Arial', '', 7);
$pdf->SetY(168.5);
$pdf->SetX(137);
$pdf->MultiCell(60.5, 2.5, utf8_decode('La existencia de algún riesgo o enfermedad en el paciente que pueda complicar la cirugía.'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($exriesen=='Si'){
$pdf->SetY(169.5);
$pdf->SetX(130);
$exriesen= 'X';
$pdf->Cell(3.5, 3, utf8_decode($exriesen),1, 'L');
}else if ($exriesen=='No') {
$pdf->SetY(169.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(173.9);
$pdf->SetX(104);
$pdf->MultiCell(93.9, 2.8, utf8_decode('El personal de enfermería ha informado:'), 0, 'J'); 


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(176.5);
$pdf->SetX(137);
$pdf->MultiCell(60.5, 2.5, utf8_decode('La fecha y método de esterilización del equipo y el instrumental.'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($fechm=='Si'){
$pdf->SetY(177.5);
$pdf->SetX(130);
$fechm= 'X';
$pdf->Cell(3.5, 3, utf8_decode($fechm),1, 'L');
}else if ($fechm=='No') {
$pdf->SetY(177.5);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7);
$pdf->SetY(182);
$pdf->SetX(137);
$pdf->MultiCell(60.5, 2.5, utf8_decode('La existencia de algún problema con el instrumental, los equipos y el conteo del mismo.'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($exproble=='Si'){
$pdf->SetY(182.9);
$pdf->SetX(130);
$exproble= 'X';
$pdf->Cell(3.5, 3, utf8_decode($exproble),1, 'L');
}else if ($exproble=='No') {
$pdf->SetY(182.9);
$pdf->SetX(130);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

//$f=date_create($fecha);

//$pdf->Cell(94, 4, 'Fecha: ' . date_format($f,"d-m-Y"), 1, 'L');



$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(62.5); 
$pdf->SetX(198); 
$pdf->MultiCell(94.5, 2.8, utf8_decode('El cirujano responsable de la atención del paciente, en presencia del anestesiólogo y el personal de enfermería, ha aplicado la Lista de Verificación de la Seguridad de la Cirugía y ha confirmado verbalmente:'), 0, 'J'); 


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(73);
$pdf->SetX(225);
$pdf->MultiCell(60.5, 2.5, utf8_decode('El nombre del procedimiento realizado:'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($nomprocre=='Si'){
$pdf->SetY(72.6);
$pdf->SetX(218);
$nomprocre= 'X';
$pdf->Cell(3.5, 3, utf8_decode($nomprocre),1, 'L');
}else if ($nomprocre=='No') {
$pdf->SetY(72.6);
$pdf->SetX(218);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7);
$pdf->SetY(77);
$pdf->SetX(225);
$pdf->MultiCell(90.5, 2.5, utf8_decode('El recuento completo del instrumental, gasas y agujas.'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($recuento=='Si'){
$pdf->SetY(76.7);
$pdf->SetX(218);
$recuento= 'X';
$pdf->Cell(3.5, 3, utf8_decode($recuento),1, 'L');
}else if ($recuento=='No') {
$pdf->SetY(76.7);
$pdf->SetX(218);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7);
$pdf->SetY(81);
$pdf->SetX(225);
$pdf->MultiCell(67.5, 2.5, utf8_decode('El etiquetado de las muestras (nombre completo del paciente, fecha de nacimiento, fecha de cirugía y descripción general).'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($etqmu=='Si'){
$pdf->SetY(81.5);
$pdf->SetX(218);
$etqmu= 'X';
$pdf->Cell(3.5, 3, utf8_decode($etqmu),1, 'L');
}else if ($etqmu=='No') {
$pdf->SetY(81.5);
$pdf->SetX(218);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}


$pdf->SetFont('Arial', '', 7);
$pdf->SetY(89.5);
$pdf->SetX(225);
$pdf->MultiCell(67.5, 2.5, utf8_decode('Los problemas con el instrumental y los equipos que deben ser notificados y resueltos.'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($proineq=='Si'){
$pdf->SetY(90);
$pdf->SetX(218);
$proineq= 'X';
$pdf->Cell(3.5, 3, utf8_decode($proineq),1, 'L');
}else if ($proineq=='No') {
$pdf->SetY(90);
$pdf->SetX(218);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}




$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(96); 
$pdf->SetX(198); 
$pdf->MultiCell(94.5, 2.8, utf8_decode('El cirujano y el anestesiólogo han comentado al personal de enfermería circulante:'), 0, 'J');

$pdf->SetFont('Arial', '', 7);
$pdf->SetY(102);
$pdf->SetX(225);
$pdf->MultiCell(67.5, 2.5, utf8_decode('Los principales aspectos de la recuperación postoperatoria.'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($prinrecpost=='Si'){
$pdf->SetY(102);
$pdf->SetX(218);
$prinrecpost= 'X';
$pdf->Cell(3.5, 3, utf8_decode($prinrecpost),1, 'L');
}else if ($prinrecpost=='No') {
$pdf->SetY(102);
$pdf->SetX(218);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7);
$pdf->SetY(106.9);
$pdf->SetX(225);
$pdf->MultiCell(67.5, 2.5, utf8_decode('El plan de tratamiento.'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($plantrat=='Si'){
$pdf->SetY(106.5);
$pdf->SetX(218);
$plantrat= 'X';
$pdf->Cell(3.5, 3, utf8_decode($plantrat),1, 'L');
}else if ($plantrat=='No') {
$pdf->SetY(106.5);
$pdf->SetX(218);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}

$pdf->SetFont('Arial', '', 7);
$pdf->SetY(111);
$pdf->SetX(225);
$pdf->MultiCell(67.5, 2.5, utf8_decode('Los riesgos del paciente.'), 0, 'J'); 

$pdf->SetFont('Arial', 'B', 7.5);
if($riesgpaci=='Si'){
$pdf->SetY(110.7);
$pdf->SetX(218);
$riesgpaci= 'X';
$pdf->Cell(3.5, 3, utf8_decode($riesgpaci),1, 'L');
}else if ($riesgpaci=='No') {
$pdf->SetY(110.7);
$pdf->SetX(218);
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'C');
}



$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(115.5); 
$pdf->SetX(198); 
$pdf->MultiCell(94.5, 2.8, utf8_decode('¿Ocurrieron eventos adversos?'), 0, 'J');


$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(119); 
$pdf->SetX(198);
if($eventosad=='Si'){
$pdf->SetY(119);
$pdf->SetX(218);
$eventosad= 'X';
$pdf->Cell(3.5, 3, utf8_decode($eventosad),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(119);
$pdf->SetX(245);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');

}else if ($eventosad=='No') {
$pdf->SetFont('Arial', '', 7.5);
$pdf->SetY(119);
$pdf->SetX(218);
$eventosad= 'X';
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(119);
$pdf->SetX(245);
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->Cell(3.5, 3, utf8_decode($eventosad),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(124); 
$pdf->SetX(198); 
$pdf->MultiCell(94.5, 2.8, utf8_decode('¿Se registro el evento adverso?'), 0, 'J');

$pdf->SetFont('Arial', 'B', 7);
if($reieventad=='Si'){
$pdf->SetY(128);
$pdf->SetX(218);
$reieventad= 'X';
$pdf->Cell(3.5, 3, utf8_decode($reieventad),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(128);
$pdf->SetX(245);
$pdf->Cell(3.5, 3, utf8_decode(' '),1, 'L');
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}else if ($reieventad=='No') {
$pdf->SetFont('Arial', '', 7.5);
$pdf->SetY(128);
$pdf->SetX(218);
$reieventad= 'X';
$pdf->Cell(3.5, 3, utf8_decode(''),1, 'L');
$pdf->Cell(5, 4, utf8_decode('Si'),0, 'C');
$pdf->SetY(128);
$pdf->SetX(245);
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->Cell(3.5, 3, utf8_decode($reieventad),1, 'L');
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(5, 4, utf8_decode('No'),0, 'C');
}

$pdf->SetFont('Arial', 'B', 7);
$pdf->SetY(133); 
$pdf->SetX(199); 
$pdf->Cell(12, 2.8, utf8_decode('¿Dónde?'), 0, 'J');
$pdf->Cell(81, 2.8, utf8_decode($donde), 'B', 'J');



$pdf->SetY(139); 
$pdf->SetX(200); 
$pdf->MultiCell(92, 5, utf8_decode('Cirujano(s)' ) , 0,'C');

$pdf->SetY(144); 
$pdf->SetX(200); 
$pdf->Cell(15, 3, utf8_decode('Nombre(s):' ) , 0,'C');
$pdf->MultiCell(77, 3, utf8_decode($fir_cir) , 'B', 'L');


$pdf->SetY(148); 
$pdf->SetX(200); 
$pdf->MultiCell(92, 5, utf8_decode('Antestesiólogo(s)' ) , 0,'C');

$pdf->SetY(152); 
$pdf->SetX(200); 
$pdf->Cell(15, 3, utf8_decode('Nombre(s):' ) , 0,'C');
$pdf->MultiCell(77, 3, utf8_decode($fir_anest) , 'B', 'L');





$pdf->SetY(159); 
$pdf->SetX(200); 
$pdf->MultiCell(92, 5, utf8_decode('Personal de enfermería' ) , 0,'C');

$pdf->SetY(161); 
$pdf->SetX(200); 
$pdf->Cell(15, 3, utf8_decode('Nombre(s):' ) , 0,'C');
$pdf->MultiCell(77, 3, utf8_decode($fir_enf) , 'B', 'L');



$sql_med_id = "SELECT id_usua FROM dat_cir_seg WHERE id_atencion = $id_atencion";
    $result_med_id = $conexion->query($sql_med_id);

    while ($row_med_id = $result_med_id->fetch_assoc()) {
      $id_med = $row_med_id['id_usua'];
    }
    $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_med";
    $result_med = $conexion->query($sql_med);
 while ($row_med = $result_med->fetch_assoc()) {
      $nom = $row_med['nombre'];
      $app = $row_med['papell'];
      $apm = $row_med['sapell'];
      $pre = $row_med['pre'];
      $firma = $row_med['firma'];
      $ced_p = $row_med['cedp'];
  $cargp = $row_med['cargp'];
}
      $pdf->SetY(-60);
      $pdf->SetFont('Arial', 'B', 6);
      $pdf->Image('../../imgfirma/' . $firma, 241, $pdf->SetY(-45), 15, 10);
      
       if ($firma==null) {
 
 $pdf->Image('../../imgfirma/FIRMA.jpg', 241, $pdf->SetY(-45), 15, 10);
} else {
  $pdf->Image('../../imgfirma/' . $firma, 241, $pdf->SetY(-45), 15, 10);
}
      
      $pdf->Ln(2);
      $pdf->SetX(225);
      $pdf->Cell(50, 3, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(3);
     $pdf->SetFont('Arial', 'B', 6);
      $pdf->SetX(200);
      $pdf->Cell(100, 3, utf8_decode($cargp . ' ' .'Céd. prof. ' . $ced_p), 0, 0, 'C');
      
      $pdf->Ln(3);
       $pdf->SetX(160);
      $pdf->Cell(180, 3, utf8_decode('Nombre y firma de enfermera'), 0, 0, 'C');
      $pdf->Ln(3);
       $pdf->SetX(160);
      
      $pdf->Cell(180, 3, utf8_decode('Coordinador de lista de verificación'), 0, 0, 'C');
   

 $pdf->Output();
}