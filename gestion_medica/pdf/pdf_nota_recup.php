<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_med = @$_GET['id_med'];
$id_unidcuid = @$_GET['id_unid_cuid'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

$sql_post = "SELECT * FROM dat_unid_cuid  where id_atencion = $id_atencion";
$result_post = $conexion->query($sql_post);
while ($row_post = $result_post->fetch_assoc()) {
  $id_unid_cuid = $row_post['id_unid_cuid'];
}
if(isset($id_unid_cuid)){
    $id_unid_cuid = $id_unid_cuid;
  }else{
    $id_unid_cuid ='sin doc';
  }

if($id_unid_cuid=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE REGISTRO NOTA DE RECUPERACIÓN PARA ESTE PACIENTE", 
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

    $id_atencion = @$_GET['id_atencion'];;

     include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 24);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}
   $this->Ln(32);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-7.01'), 0, 1, 'R');
  }
}

$sql_pac = "SELECT * FROM paciente  where Id_exp = $id_exp";
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
}


$sql_ing = "SELECT * FROM dat_ingreso  where Id_exp = $id_exp";
$result_ing = $conexion->query($sql_ing);
while ($row_ing = $result_ing->fetch_assoc()) {
$especialidad = $row_ing['especialidad'];
  $fecha = $row_ing['fecha'];
}

$sql_camas = "SELECT * FROM cat_camas  where id_atencion = $id_atencion";
$result_camas = $conexion->query($sql_camas);
while ($row_camas = $result_camas->fetch_assoc()) {

  $num_cama = $row_camas['num_cama'];
}

$sql_ing = "SELECT * FROM dat_ingreso  where Id_exp = $id_exp";
$result_ing = $conexion->query($sql_ing);
while ($row_ing = $result_ing->fetch_assoc()) {
$especialidad = $row_ing['especialidad'];
  $fecha_ing = $row_ing['fecha'];
  $tipo_a= $row_ing['tipo_a'];
}



$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,22);

 $pdf->SetTextColor(43, 45, 127);
$pdf->SetFont('Arial', 'B', 9.5);
$pdf->SetX(50);
$pdf->Cell(120, 5, utf8_decode('HOJA ANESTÉSIA COMPLETA'), 0, 0, 'C');
$pdf->SetFont('Arial', '', 6);

$fecha_actual = date("d/m/Y");
$pdf->Cell(35, 5, 'FECHA: ' . $fecha_actual, 0, 1, 'R');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 50, 207, 50);
$pdf->Line(8, 50, 8, 280);
$pdf->Line(207, 50, 207, 280);
$pdf->Line(8, 280, 207, 280);
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 5, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 5, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 5, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 5, utf8_decode($folio), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 5, ' Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(146, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$date1=date_create($fecnac);
$pdf->Cell(31, 5, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 5, date_format($date1,"d/m/Y"), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 5, ' Edad: ', 0, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(13, 5, utf8_decode($edad),'B', 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(19, 5, utf8_decode(' Ocupación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(36, 5,  utf8_decode($ocup), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 5, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 5,  utf8_decode($tel), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 5, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 5,  $sexo, 'B', 'L');
$pdf->Ln(5);
$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$id_atencion ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_hc = $result_sig->fetch_assoc()) {
$pesoh=$row_hc['peso'];
$tallah=$row_hc['talla'];
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 5, utf8_decode('Peso: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 5,  utf8_decode($pesoh.' Kilos'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 5, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 5,  utf8_decode($tallah.' Metros'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 5, utf8_decode(' Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(125, 5, utf8_decode($dir), 'B', 'L');

$pdf->Ln(5);

$d="";
    $sql_motd = "SELECT diagprob_i from dat_not_ingreso where id_atencion=$id_atencion ORDER by id_not_ingreso DESC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } 
    $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by diagprob_i DESC LIMIT 1";
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
    $pdf->SetFont('Arial', 'B', 8);
  $pdf->Cell(20, 5, utf8_decode('Diagnóstico:') , 0, 'C');
  $pdf->SetFont('Arial', '', 9);
     $pdf->Cell(175, 5, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 5, utf8_decode('Motivo de atención:') , 0, 'C');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(166, 5, utf8_decode($m) , 'B', 'C');
    }

$sql_post = "SELECT * FROM dat_unid_cuid where id_unid_cuid=$id_unidcuid and id_atencion = $id_atencion order by id_unid_cuid DESC";
$result_post = $conexion->query($sql_post);
while ($row_post = $result_post->fetch_assoc()) {

  $notevo_un = $row_post['notevo_un'];
  $t01 = $row_post['01t'];
  $t02 = $row_post['02t'];
  $t03 = $row_post['03t'];
  $t04 = $row_post['04t'];
  $t05 = $row_post['05t'];
  $t0 = $row_post['0t'];

  $t51 = $row_post['51t'];
  $t52 = $row_post['52t'];
  $t53 = $row_post['53t'];
  $t54 = $row_post['54t'];
  $t55 = $row_post['55t'];
  $t5 = $row_post['5t'];

  $t101= $row_post['101t'];
  $t102 = $row_post['102t'];
  $t103 = $row_post['103t'];
  $t104 = $row_post['104t'];
  $t105 = $row_post['105t'];
  $t10 = $row_post['10t'];

  $t151 = $row_post['151t'];
  $t152 = $row_post['152t'];
  $t153 = $row_post['153t'];
  $t154 = $row_post['154t'];
  $t155 = $row_post['155t'];
  $t15 = $row_post['15t'];

  $t201 = $row_post['201t'];
  $t202 = $row_post['202t'];
  $t203 = $row_post['203t'];
  $t204 = $row_post['204t'];
  $t205 = $row_post['205t'];
  $t20 = $row_post['20t'];

  $t251 = $row_post['251t'];
  $t252 = $row_post['252t'];
  $t253 = $row_post['253t'];
  $t254 = $row_post['254t'];
  $t255 = $row_post['255t'];
  $t25 = $row_post['25t'];

  $t301 = $row_post['301t'];
  $t302 = $row_post['302t'];
  $t303 = $row_post['303t'];
  $t304 = $row_post['304t'];
  $t305 = $row_post['305t'];
  $t30 = $row_post['30t'];
  $cirujanoa = $row_post['cirujanoa'];
 $anestesiologoa = $row_post['anestesiologoa'];
$ind = $row_post['ind'];
$mascarilla = $row_post['mascarilla'];
$canula = $row_post['canula'];
$anest_general = $row_post['anest_general'];
$balanceada = $row_post['balanceada'];
$agentes_in = $row_post['agentes_in'];
$desfluorante = $row_post['desfluorante'];
$insofluorane = $row_post['insofluorane'];
$intubacion = $row_post['intubacion'];
$tubglobal = $row_post['tubglobal'];
$hojar = $row_post['hojar'];
$noit = $row_post['noit'];
$guiai = $row_post['guiai'];
$incdentesf = $row_post['incdentesf'];
$reintipo = $row_post['reintipo'];
$noreinc = $row_post['noreinc'];
$cerrado = $row_post['cerrado'];
$semicerrado = $row_post['semicerrado'];
$ventilacion = $row_post['ventilacion'];
$manual = $row_post['manual'];
$mecanica = $row_post['mecanica'];
$espontanea = $row_post['espontanea'];
$asistida = $row_post['asistida'];
$controlada = $row_post['controlada'];
$vt = $row_post['vt'];
$fr = $row_post['fr'];
$pwa = $row_post['pwa'];
$ventilador = $row_post['ventilador'];

$bloqueo = $row_post['bloqueo'];
$sub = $row_post['sub'];
$aracnoideo = $row_post['aracnoideo'];
$peridual = $row_post['peridual'];
$mixto = $row_post['mixto'];
$cateter = $row_post['cateter'];
$tuohy = $row_post['tuohy'];
$raquia = $row_post['raquia'];
$dificil = $row_post['dificil'];
$segnointen = $row_post['segnointen'];
$analgesia = $row_post['analgesia'];
$altura = $row_post['altura'];
$monitor = $row_post['monitor'];
$tipoi = $row_post['tipoi'];
$ecg = $row_post['ecg'];
$cap = $row_post['cap'];
$ul = $row_post['ul'];
$capcap = $row_post['capcap'];
$tiponac = $row_post['tiponac'];
$fechanac = $row_post['fechanac'];
$horanac = $row_post['horanac'];
$vivo = $row_post['vivo'];
$genero = $row_post['genero'];
$apgar = $row_post['apgar'];
$asistencia = $row_post['asistencia'];
$ventilacionnac = $row_post['ventilacionnac'];
$intubaneo = $row_post['intubaneo'];
$sal = $row_post['sal'];
$tiempoa = $row_post['tiempoa'];
$tiempoq = $row_post['tiempoq'];
$posicion = $row_post['posicion'];
$cuentagasa = $row_post['cuentagasa'];
$cuentacom = $row_post['cuentacom'];
$noveno = $row_post['noveno'];
$puncion = $row_post['puncion'];
$catcentral = $row_post['catcentral'];
$dxpre = $row_post['dxpre'];
$dcpost = $row_post['dcpost'];
$cirpro = $row_post['cirpro'];
$cirre = $row_post['cirre'];


}

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,3, utf8_decode('Hora'),1,0,'C');
$pdf->Cell(40,3, utf8_decode('Agentes'),1,0,'C');
$pdf->Cell(41,3, utf8_decode('Cantidades'),1,0,'C');
$pdf->Cell(41,3, utf8_decode('Métodos'),1,0,'C');
$pdf->Cell(41,3, utf8_decode('Fecha'),1,0,'C');
$sql_agen = "SELECT * FROM agentes_anest where id_atencion = $id_atencion order by fecha_a DESC";
$result_ag = $conexion->query($sql_agen);
while ($row_age = $result_ag->fetch_assoc()) {
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(31,3, utf8_decode($row_age['horaa']),1,'L');
$pdf->Cell(40,3, utf8_decode($row_age['agentes']),1,'L');
$pdf->Cell(41,3, utf8_decode($row_age['cantidades']),1,'L');  
$pdf->Cell(41,3, utf8_decode($row_age['metodos']),1,'L');
$fecaa=date_create($row_age['fecha_a']);
$pdf->Cell(41,3, utf8_decode(date_format($fecaa,"d-m-Y")),1,'L');  
  
}

//signos
$pdf->Ln(6);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,4, utf8_decode('Presión arterial'),1,0,'L');
$sql_agens = "SELECT * FROM signos_anest where id_atencion = $id_atencion order by id_sig_an DESC";
$result_as = $conexion->query($sql_agens);
while ($row_ages = $result_as->fetch_assoc()) {
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8,4, utf8_decode($row_ages['sist_mat'].'/'.$row_ages['diast_mat']),1,'L');
}
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,4, utf8_decode('Pulso'),1,0,'L');
$sql_agens = "SELECT * FROM signos_anest where id_atencion = $id_atencion order by id_sig_an DESC";
$result_as = $conexion->query($sql_agens);
while ($row_ages = $result_as->fetch_assoc()) {
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8,4, utf8_decode($row_ages['freccard_mat']),1,'L');
}
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,4, utf8_decode('Princ. Anest'),1,0,'L');
$sql_agens = "SELECT * FROM signos_anest where id_atencion = $id_atencion order by id_sig_an DESC";
$result_as = $conexion->query($sql_agens);
while ($row_ages = $result_as->fetch_assoc()) {
$pdf->SetFont('Arial', '', 8);
$pan=date_create($row_ages['p_an']);
$pdf->Cell(8,4, utf8_decode(date_format($pan,"H:i")),1,'L');
}

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,4, utf8_decode('Princ. oper'),1,0,'L');
$sql_agens = "SELECT * FROM signos_anest where id_atencion = $id_atencion order by id_sig_an DESC";
$result_as = $conexion->query($sql_agens);
while ($row_ages = $result_as->fetch_assoc()) {
$pdf->SetFont('Arial', '', 8);
$pop=date_create($row_ages['p_op']);
$pdf->Cell(8,4, utf8_decode(date_format($pop,"H:i")),1,'L');
}

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,4, utf8_decode('Fin Anest'),1,0,'L');
$sql_agens = "SELECT * FROM signos_anest where id_atencion = $id_atencion order by id_sig_an DESC";
$result_as = $conexion->query($sql_agens);
while ($row_ages = $result_as->fetch_assoc()) {
$pdf->SetFont('Arial', '', 8);
$fan=date_create($row_ages['fin_an']);
$pdf->Cell(8,4, utf8_decode(date_format($fan,"H:i")),1,'L');
}

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,4, utf8_decode('Temperatura'),1,0,'L');
$sql_agens = "SELECT * FROM signos_anest where id_atencion = $id_atencion order by id_sig_an DESC";
$result_as = $conexion->query($sql_agens);
while ($row_ages = $result_as->fetch_assoc()) {
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8,4, utf8_decode($row_ages['temp']),1,'L');
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(6);
$pdf->Cell(31,3, utf8_decode('Balance de líquidos:'),0,'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,3, utf8_decode('Ingresos'),1,0,'C');

$pdf->setx(42);
$pdf->Cell(12,3, utf8_decode('Cirujano:'),0,'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(67,3, utf8_decode($cirujanoa),'B','C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18,3, utf8_decode('Anestesiólogo:'),0,'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(64.5,3, utf8_decode($anestesiologoa),'B','C');


$sql_ageni = "SELECT * FROM ingresos_anest where id_atencion = $id_atencion order by fecha DESC";
$result_agi = $conexion->query($sql_ageni);

while ($row_agei = $result_agi->fetch_assoc()) {
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(31,3, utf8_decode($row_agei['descripcion'] .': ' .$row_agei['cantidad']),1,'L');
}
$resultado3 = $conexion->query("SELECT SUM(cantidad) as can from ingresos_anest WHERE id_atencion=$id_atencion ORDER BY id_ing_anest DESC") or die($conexion->error);
 while($f3 = mysqli_fetch_array($resultado3)){
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,3, utf8_decode('Total: ' . $f3['can']),1,0,'l');
$ingrtot=$f3['can'];
}
$pdf->Ln(3);
$pdf->Cell(31,3, utf8_decode('Egresos'),1,0,'C');

$sql_ageni = "SELECT * FROM egresos_anest where id_atencion = $id_atencion order by fecha DESC";
$result_agi = $conexion->query($sql_ageni);
while ($row_agei = $result_agi->fetch_assoc()) {

$pdf->Ln(3);
 
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(31,3, utf8_decode($row_agei['descripcion'] .': ' .$row_agei['cantidad']),1,'L');
}
$resultado3 = $conexion->query("SELECT SUM(cantidad) as can from egresos_anest WHERE id_atencion=$id_atencion ORDER BY id_egresos_anest DESC") or die($conexion->error);
 while($f3 = mysqli_fetch_array($resultado3)){
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,3, utf8_decode('Total: ' . $f3['can']),1,0,'l');
$egretot=$f3['can'];
$ballt=$ingrtot-$egretot;
$pdf->Ln(3);
$pdf->Cell(31,3, utf8_decode('Balance Total: ' . $ballt),1,0,'l');
}
$pdf->Ln(5);
$pdf->Cell(31,3, utf8_decode('Circuito anestésico: '),0,0,'l');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(20,3, utf8_decode('Rehinalación tipo: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(11,3, utf8_decode($reintipo),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28,3, utf8_decode('No. Rehinalación circuito: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(5,3, utf8_decode($noreinc),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(10,3, utf8_decode('Cerrado: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($cerrado=="cerrado"){
  $cerrado='X';
}
$pdf->Cell(4,3, utf8_decode($cerrado),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(15,3, utf8_decode('Semicerrado: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($semicerrado=="semicerrado"){
  $semicerrado='X';
}
$pdf->Cell(4,3, utf8_decode($semicerrado),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(13.5,3, utf8_decode('Ventilación: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($ventilacion=="ventilacion"){
  $ventilacion='X';
}
$pdf->Cell(4,3, utf8_decode($ventilacion),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(9.5,3, utf8_decode('Manual: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($manual=="manual"){
  $manual='X';
}
$pdf->Cell(4,3, utf8_decode($manual),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(11.5,3, utf8_decode('Mecánica: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($mecanica=="mecanica"){
  $mecanica='X';
}
$pdf->Cell(4,3, utf8_decode($mecanica),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(14,3, utf8_decode('Espontánea: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($espontanea=="espontanea"){
  $espontanea='X';
}
$pdf->Cell(4,3, utf8_decode($espontanea),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(10,3, utf8_decode('Asistida: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($asistida=="asistida"){
  $asistida='X';
}
$pdf->Cell(4,3, utf8_decode($asistida),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(14,3, utf8_decode('Controlada: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($controlada=="controlada"){
  $controlada='X';
}
$pdf->Cell(4,3, utf8_decode($controlada),'B',0,'l');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(5,3, utf8_decode('Vt: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(10,3, utf8_decode($vt),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(5,3, utf8_decode('Fr: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(11,3, utf8_decode($fr),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(7,3, utf8_decode('Pwa: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(9,3, utf8_decode($pwa),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(13,3, utf8_decode('Ventilador: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(11,3, utf8_decode($ventilador),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(10,3, utf8_decode('Bloqueo: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($bloqueo=="bloqueo"){
  $bloqueo='X';
}
$pdf->Cell(4,3, utf8_decode($bloqueo),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(8,3, utf8_decode('Sub: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($sub=="sub"){
  $sub='X';
}
$pdf->Cell(4,3, utf8_decode($sub),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(14,3, utf8_decode('Aracnoideo: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($aracnoideo=="aracnoideo"){
  $aracnoideo='X';
}
$pdf->Cell(4,3, utf8_decode($aracnoideo),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(11,3, utf8_decode('Peridual: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($peridual=="peridual"){
  $peridual='X';
}
$pdf->Cell(4,3, utf8_decode($peridual),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(9,3, utf8_decode('Mixto: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($mixto=="mixto"){
  $mixto='X';
}
$pdf->Cell(7,3, utf8_decode($mixto),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(10,3, utf8_decode('Catéter: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(10,3, utf8_decode($cateter),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(22,3, utf8_decode('Aguja de Tuohy No: '),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(7,3, utf8_decode($tuohy),'B',0,'l');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(14,3, utf8_decode('Raquia No.:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(7,3, utf8_decode($raquia),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(8,3, utf8_decode('Dificil:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(4,3, utf8_decode($dificil),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(18,3, utf8_decode('No de intentos:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(6,3, utf8_decode($segnointen),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(13,3, utf8_decode('Analgesia:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(9,3, utf8_decode($analgesia),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(9,3, utf8_decode('Altura:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(9.3,3, utf8_decode($altura),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(12,3, utf8_decode('Monitoreo:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(6,3, utf8_decode($monitor),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(8,3, utf8_decode('Tipo I:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(7,3, utf8_decode($tipoi),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(7,3, utf8_decode('Ecg:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(9,3, utf8_decode($ecg),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(13,3, utf8_decode('Capnomac:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($cap=="capnomac"){
  $cap='X';
}
$pdf->Cell(4,3, utf8_decode($cap),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(9,3, utf8_decode('Última:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($ul=="ultima"){
  $ul='X';
}
$pdf->Cell(4,3, utf8_decode($ul),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(13,3, utf8_decode('Capnocap:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
if($capcap=="capnocap"){
  $capcap='X';
}
$pdf->Cell(5,3, utf8_decode($capcap),'B',0,'l');


$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(18,3, utf8_decode('Tipo nacimiento:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(10,3, utf8_decode($tiponac),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(9,3, utf8_decode('Fecha:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$fn=date_create($fechanac);
$pdf->Cell(14,3, utf8_decode(date_format($fn,"d-m-Y")),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(7,3, utf8_decode('Hora:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$hn=date_create($horanac);
$pdf->Cell(7,3, utf8_decode(date_format($hn,"H:i")),'B',0,'L');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(16.5,3, utf8_decode('Producto vivo:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(4,3, utf8_decode($vivo),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(9.5,3, utf8_decode('Género:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(10,3, utf8_decode($genero),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(9,3, utf8_decode('Apgar:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(7,3, utf8_decode($apgar),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(13,3, utf8_decode('Asistencia:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(4,3, utf8_decode($asistencia),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(13.5,3, utf8_decode('Ventilación:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(4,3, utf8_decode($ventilacionnac),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(13.5,3, utf8_decode('Intubación:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(4,3, utf8_decode($intubaneo),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(17,3, utf8_decode('Salpingoclasia:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(4.5,3, utf8_decode($sal),'B',0,'l');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(21.5,3, utf8_decode('Tiempo anestésico:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(11,3, utf8_decode($tiempoa),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(22,3, utf8_decode('Tiempo quirúrgico:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(10.5,3, utf8_decode($tiempoq),'B',0,'l');

 $pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(11,3, utf8_decode('Posición:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(10,3, utf8_decode($posicion),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(19,3, utf8_decode('Cuenta de gasas:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(8,3, utf8_decode($cuentagasa),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(24.5,3, utf8_decode('Cuenta de compresas:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(8,3, utf8_decode($cuentacom),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(19.5,3, utf8_decode('No. de venoclisis:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(7,3, utf8_decode($noveno),'B',0,'l');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(18,3, utf8_decode('Punción arterial:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(4.5,3, utf8_decode($puncion),'B',0,'l');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(18,3, utf8_decode('Catéter central:'),0,0,'l');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(14.5,3, utf8_decode($catcentral),'B',0,'l');

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40,3, utf8_decode('Diagnóstico Preoperatorio:'),0,0,'l');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155,3, utf8_decode($dxpre),'B','l');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40,3, utf8_decode('Diagnóstico Post-operatorio:'),0,0,'l');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155,3, utf8_decode($dcpost),'B','l');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40,3, utf8_decode('Cirugia programada:'),0,0,'l');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155,3, utf8_decode($cirpro),'B','l');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40,3, utf8_decode('Cirugia realizada:'),0,0,'l');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(155,3, utf8_decode($cirre),'B','l');







$pdf->sety(124);
$pdf->setx(42);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(25,3, utf8_decode('Inducción anestésica:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(18,3, utf8_decode($ind),'B','C');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(14,3, utf8_decode('Mascarilla:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(18,3, utf8_decode($mascarilla),'B','C');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(25,3, utf8_decode('Cánula de Gúdel NO.:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(18,3, utf8_decode($canula),'B','C');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(22,3, utf8_decode('Anestesia general:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(21.5,3, utf8_decode($anest_general),'B','C');

$pdf->sety(129.5);
$pdf->setx(42);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(16,3, utf8_decode('Balanceada:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(27,3, utf8_decode($balanceada),'B','C');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(22,3, utf8_decode('Agentes inhalados:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(10,3, utf8_decode($agentes_in),'B','C');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(30,3, utf8_decode('Desfluorante sevofluorane:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(13,3, utf8_decode($desfluorante),'B','C');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(16,3, utf8_decode('Insofluorane:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(27.5,3, utf8_decode($insofluorane),'B','C');

$pdf->sety(134.5);
$pdf->setx(42);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(16,3, utf8_decode('Intubación:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(27.5,3, utf8_decode($intubacion),'B','C');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(12,3, utf8_decode('Tubo No:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(19.5,3, utf8_decode($tubglobal),'B','C');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(8,3, utf8_decode('Hoja:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(19.5,3, utf8_decode($hojar),'B','C');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(18,3, utf8_decode('No de intentos:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(5.5,3, utf8_decode($noit),'B','C');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(8,3, utf8_decode('Guía:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(28,3, utf8_decode($guiai),'B','C');

$pdf->sety(139.5);
$pdf->setx(42);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(16,3, utf8_decode('Incidentes:'),0,'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(146,3, utf8_decode($incdentesf),'B','C');


$pdf->Ln(71);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31,3, utf8_decode('Nota Post-anestésica:'),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(163,3, utf8_decode($notevo_un),'B','L');

$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->setY(45);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195,8, utf8_decode('ALDRETE'),0,1,'C');
$pdf->Ln(5);

$pdf->setY(55);
$pdf->setx(10);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(90,7, utf8_decode('Tiempo'),1,0,'C');
$pdf->setY(55);
$pdf->setx(100);
$pdf->Cell(15,7, utf8_decode('0'),1,0,'C');
$pdf->setY(55);
$pdf->setx(115);
$pdf->Cell(15,7, utf8_decode('5'),1,0,'C');
$pdf->setY(55);
$pdf->setx(130);
$pdf->Cell(15,7, utf8_decode('10'),1,0,'C');
$pdf->setY(55);
$pdf->setx(145);
$pdf->Cell(15,7, utf8_decode('15'),1,0,'C');
$pdf->setY(55);
$pdf->setx(160);
$pdf->Cell(15,7, utf8_decode('20'),1,0,'C');
$pdf->setY(55);
$pdf->setx(175);
$pdf->Cell(15,7, utf8_decode('25'),1,0,'C');
$pdf->setY(55);
$pdf->setx(190);
$pdf->Cell(15,7, utf8_decode('30'),1,0,'C');

$pdf->setY(62);
$pdf->setx(10);
$pdf->SetFont('Arial', 'B',7);
$pdf->MultiCell(25,6, utf8_decode('Actividad muscular'),1,'C');
$pdf->setY(62);
$pdf->setx(35);
$pdf->SetFont('Arial', '',6);
$pdf->MultiCell(65,3, utf8_decode('Movs. Voluntarios al llamado (4 extremidades) movs. Voluntarios al llamado (2 extremidades) completamente inmóvil'),1,'L');
$pdf->setY(62);
$pdf->setx(100);
$pdf->MultiCell(15,6, utf8_decode($t01),1,'C');
$pdf->setY(62);
$pdf->setx(115);
$pdf->MultiCell(15,6, utf8_decode($t51),1,'C');
$pdf->setY(62);
$pdf->setx(130);
$pdf->MultiCell(15,6, utf8_decode($t101),1,'C');
$pdf->setY(62);
$pdf->setx(145);
$pdf->MultiCell(15,6, utf8_decode($t151),1,'C');
$pdf->setY(62);
$pdf->setx(160);
$pdf->MultiCell(15,6, utf8_decode($t201),1,'C'); 
$pdf->setY(62);
$pdf->setx(175);
$pdf->MultiCell(15,6, utf8_decode($t251),1,'C');
$pdf->setY(62);
$pdf->setx(190);
$pdf->MultiCell(15,6, utf8_decode($t301),1,'C');

$pdf->setY(68);
$pdf->setx(10);
$pdf->SetFont('Arial', 'B',7);
$pdf->MultiCell(25,6, utf8_decode('Respiración'),1,'C');
$pdf->setY(68);
$pdf->setx(35);
$pdf->SetFont('Arial', '',6);
$pdf->MultiCell(65,3, utf8_decode('Respiraciones amplias y capaz de toser respiraciones limitadas
apnea'),1,'L');
$pdf->setY(68);
$pdf->setx(100);
$pdf->MultiCell(15,6, utf8_decode($t02),1,'C');
$pdf->setY(68);
$pdf->setx(115);
$pdf->MultiCell(15,6, utf8_decode($t52),1,'C');
$pdf->setY(68);
$pdf->setx(130);
$pdf->MultiCell(15,6, utf8_decode($t102),1,'C');
$pdf->setY(68);
$pdf->setx(145);
$pdf->MultiCell(15,6, utf8_decode($t152),1,'C');
$pdf->setY(68);
$pdf->setx(160);
$pdf->MultiCell(15,6, utf8_decode($t202),1,'C'); 
$pdf->setY(68);
$pdf->setx(175);
$pdf->MultiCell(15,6, utf8_decode($t252),1,'C');
$pdf->setY(68);
$pdf->setx(190);
$pdf->MultiCell(15,6, utf8_decode($t302),1,'C');

$pdf->setY(74);
$pdf->setx(10);
$pdf->SetFont('Arial', 'B',7);
$pdf->MultiCell(25,6, utf8_decode('Circulación'),1,'C');
$pdf->setY(74);
$pdf->setx(35);
$pdf->SetFont('Arial', '',6);
$pdf->MultiCell(65,3, utf8_decode('Presión arterial + -20% del nivel basal presión arterial + -21 - 49% del nivel basal presión arterial + -50% del nivel basal'),1,'L');
$pdf->setY(74);
$pdf->setx(100);
$pdf->MultiCell(15,6, utf8_decode($t03),1,'C');
$pdf->setY(74);
$pdf->setx(115);
$pdf->MultiCell(15,6, utf8_decode($t53),1,'C');
$pdf->setY(74);
$pdf->setx(130);
$pdf->MultiCell(15,6, utf8_decode($t103),1,'C');
$pdf->setY(74);
$pdf->setx(145);
$pdf->MultiCell(15,6, utf8_decode($t153),1,'C');
$pdf->setY(74);
$pdf->setx(160);
$pdf->MultiCell(15,6, utf8_decode($t203),1,'C'); 
$pdf->setY(74);
$pdf->setx(175);
$pdf->MultiCell(15,6, utf8_decode($t253),1,'C');
$pdf->setY(74);
$pdf->setx(190);
$pdf->MultiCell(15,6, utf8_decode($t303),1,'C');

$pdf->setY(80);
$pdf->setx(10);
$pdf->SetFont('Arial', 'B',7);
$pdf->MultiCell(25,4.5, utf8_decode('Estado de contingencia'),1,'C');
$pdf->setY(80);
$pdf->setx(35);
$pdf->SetFont('Arial', '',6);
$pdf->MultiCell(65,3, utf8_decode('Completamente despierto
responde al ser llamado
no responde'),1,'L');
$pdf->setY(80);
$pdf->setx(100);
$pdf->MultiCell(15,9, utf8_decode($t04),1,'C');
$pdf->setY(80);
$pdf->setx(115);
$pdf->MultiCell(15,9, utf8_decode($t54),1,'C');
$pdf->setY(80);
$pdf->setx(130);
$pdf->MultiCell(15,9, utf8_decode($t104),1,'C');
$pdf->setY(80);
$pdf->setx(145);
$pdf->MultiCell(15,9, utf8_decode($t154),1,'C');
$pdf->setY(80);
$pdf->setx(160);
$pdf->MultiCell(15,9, utf8_decode($t204),1,'C'); 
$pdf->setY(80);
$pdf->setx(175);
$pdf->MultiCell(15,9, utf8_decode($t254),1,'C');
$pdf->setY(80);
$pdf->setx(190);
$pdf->MultiCell(15,9, utf8_decode($t304),1,'C');

$pdf->setY(89);
$pdf->setx(10);
$pdf->SetFont('Arial', 'B',7);
$pdf->MultiCell(25,4.5, utf8_decode('Saturación de oxigeno'),1,'C');
$pdf->setY(89);
$pdf->setx(35);
$pdf->SetFont('Arial', '',6);
$pdf->MultiCell(65,3, utf8_decode('Mantiene sat. De o2 > 92% con aire ambiente necesita o2 para mantener la sat de o2 > 90% saturación de o2 < 90% con suplemento de oxígeno'),1,'L');
$pdf->setY(89);
$pdf->setx(100);
$pdf->MultiCell(15,9, utf8_decode($t05),1,'C');
$pdf->setY(89);
$pdf->setx(115);
$pdf->MultiCell(15,9, utf8_decode($t55),1,'C');
$pdf->setY(89);
$pdf->setx(130);
$pdf->MultiCell(15,9, utf8_decode($t105),1,'C');
$pdf->setY(89);
$pdf->setx(145);
$pdf->MultiCell(15,9, utf8_decode($t155),1,'C');
$pdf->setY(89);
$pdf->setx(160);
$pdf->MultiCell(15,9, utf8_decode($t205),1,'C'); 
$pdf->setY(89);
$pdf->setx(175);
$pdf->MultiCell(15,9, utf8_decode($t255),1,'C');
$pdf->setY(89);
$pdf->setx(190);
$pdf->MultiCell(15,9, utf8_decode($t305),1,'C');

$pdf->setY(98);
$pdf->setx(10);
$pdf->SetFont('Arial', 'B',7);
$pdf->Cell(90,8, utf8_decode('Total de aldrete'),1,0,'C');
$pdf->setY(98);
$pdf->setx(100);
$pdf->SetFont('Arial', 'B',7);
$pdf->MultiCell(15,8, utf8_decode($t0),1,'C');
$pdf->setY(98);
$pdf->setx(115);
$pdf->MultiCell(15,8, utf8_decode($t5),1,'C');
$pdf->setY(98);
$pdf->setx(130);
$pdf->MultiCell(15,8, utf8_decode($t10),1,'C');
$pdf->setY(98);
$pdf->setx(145);
$pdf->MultiCell(15,8, utf8_decode($t15),1,'C');
$pdf->setY(98);
$pdf->setx(160);
$pdf->MultiCell(15,8, utf8_decode($t20),1,'C'); 
$pdf->setY(98);
$pdf->setx(175);
$pdf->MultiCell(15,8, utf8_decode($t25),1,'C');
$pdf->setY(98);
$pdf->setx(190);
$pdf->MultiCell(15,8, utf8_decode($t30),1,'C');
///////////////////FIRMA DE MEDICO 

$sql_med_id = "SELECT id_usua FROM dat_unid_cuid WHERE id_atencion = $id_atencion";
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
      $cedp = $row_med['cedp'];
      $cargp = $row_med['cargp'];
}


      
   $pdf->Ln(20);
   
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Image('../../imgfirma/' . $firma, 95, 245, 25);
    
      $pdf->SetY(264);
      $pdf->Cell(200, 3, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(200, 3, utf8_decode($cargp . ' ' . 'CÉD. PROF. ' . $cedp), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 3, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');


 $pdf->Output();
}