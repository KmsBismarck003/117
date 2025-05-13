<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_med = @$_GET['id_med'];
$id_transanest = @$_GET['id_trans_anest'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$fechar = @$_GET['fecha'];
$sql_trans = "SELECT * FROM dat_trans_anest  where id_atencion = $id_atencion";
$result_trans = $conexion->query($sql_trans);

while ($row_trans = $result_trans->fetch_assoc()) {
  $id_trans_anest = $row_trans['id_trans_anest'];
}

if(isset($id_trans_anest)){
    $id_trans_anest = $id_trans_anest;
  }else{
    $id_trans_anest ='sin doc';
  }

if($id_trans_anest=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE REGISTRO DESCRIPTIVO TRANS-ANESTÉSICO PARA ESTE PACIENTE", 
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
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-7.03'), 0, 1, 'R');
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
  $fecha_ing = $row_ing['fecha'];
  $tipo_a= $row_ing['tipo_a'];
}


$sql_camas = "SELECT * FROM cat_camas  where id_atencion = $id_atencion";
$result_camas = $conexion->query($sql_camas);
while ($row_camas = $result_camas->fetch_assoc()) {

  $num_cama = $row_camas['num_cama'];
}

//consulta TRANS ANESTESICA
$sql_trans = "SELECT * FROM dat_trans_anest  where id_trans_anest = $id_transanest";
$result_trans = $conexion->query($sql_trans);

while ($row_trans = $result_trans->fetch_assoc()) {
  $anest = $row_trans['anest'];
  
  $anestreal = $row_trans['anestreal'];  
  $poscui = $row_trans['poscui'];
  $ind = $row_trans['ind']; 
  $hora = $row_trans['hora']; 
  $agdo = $row_trans['agdo']; 
  $tin = $row_trans['tin'];  

  $masc = $row_trans['masc'];
  $can = $row_trans['can'];
  $otro = $row_trans['otro'];  
  $larin = $row_trans['larin'];  
  $venti = $row_trans['venti'];
  $cir = $row_trans['cir']; 
  $esasme = $row_trans['esasme']; 
  $mec = $row_trans['mec']; 
  $modo = $row_trans['modo'];  

  $fl = $row_trans['fl'];
  $vcor = $row_trans['vcor'];
  $fr = $row_trans['fr'];  
  $rel = $row_trans['rel'];  
  $peep = $row_trans['peep'];
  $com = $row_trans['com']; 
  $mant = $row_trans['mant']; 
  $relaj = $row_trans['relaj']; 
  $agent = $row_trans['agent'];  

  $dosis = $row_trans['dosis'];
  $ultdosis = $row_trans['ultdosis'];
  $ant = $row_trans['ant'];  
  $agdos = $row_trans['agdos'];  
  $monit = $row_trans['monit'];
  $comen = $row_trans['comen']; 
  $bloq = $row_trans['bloq']; 
  $agdosi = $row_trans['agdosi']; 
  $tec = $row_trans['tec'];  

  $cate = $row_trans['cate'];
  $posi = $row_trans['posi'];
  $lat = $row_trans['lat'];  
  $asep = $row_trans['asep'];  
  $dif = $row_trans['dif'];
  $aguja = $row_trans['aguja']; 
  $bsim = $row_trans['bsim']; 
  $bmotor = $row_trans['bmotor']; 
  $bsen = $row_trans['bsen']; 

  $coment = $row_trans['coment']; 
  $caso = $row_trans['caso']; 
  $emer = $row_trans['emer']; 
  $fecha_nota = $row_trans['fecha'];
}
//termino


 $diagposto=" ";
  $opreal=" ";
$sql_inquir = "SELECT * FROM dat_not_inquir  where id_atencion = $id_atencion
order by id_not_inquir DESC LIMIT 1";
$result_inquir = $conexion->query($sql_inquir);
while ($row_inquir = $result_inquir->fetch_assoc()) {
 $opreal = $row_inquir['cir_realizada']; 
 $diagposto = $row_inquir['diag_postop'];
}


$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,20);
    $pdf->SetTextColor(43, 45, 127);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(50);
$pdf->Cell(120, 5, utf8_decode('REGISTRO DESCRIPTIVO TRANS-ANESTÉSICO'), 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date_create($fecha_nota);
$pdf->Cell(35, 5, 'FECHA: ' . date_format($fecha_actual,"d/m/Y H:i a"), 0, 1, 'R');

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
$pdf->Cell(32, 5, date_format($date,'d/m/Y H:i a'), 'B', 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 5, utf8_decode($Id_exp), 'B', 0, 'C');
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
/***********************/

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 4, utf8_decode('Anestesiólogo: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(169, 4, utf8_decode($anest), 1, 'L');
$pdf->SetFont('Arial', 'B', 7.7);
$pdf->Cell(37, 4, utf8_decode('Diagnóstico posoperatorio: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(159, 4, utf8_decode($diagposto), 1, 'L');
$pdf->Ln(4);
/*
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(27, 4, utf8_decode('Cirugía realizada: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(196, 4, utf8_decode($opreal), 1, 'J');*/

$pdf->SetFont('Arial', 'B', 7.5);
$pdf->Cell(27, 3, utf8_decode('Anestesia realizada: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(169, 3, utf8_decode($anestreal), 1, 'L');
$pdf-
$pdf->SetFont('Arial', 'B', 7.3);
$pdf->Cell(27, 3, utf8_decode('Posición y cuidados: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(169, 3, utf8_decode($poscui), 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Inducción: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(121, 3, utf8_decode($ind), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 3, utf8_decode('Hora: ' ), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 3, utf8_decode($hora), 1, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Agentes y dosis: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(169, 3, utf8_decode($agdo), 1, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190, 3, utf8_decode('Vía aerea'), 0,0, 'L');

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Intubación: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(169, 3, utf8_decode($tin), 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Mascarilla: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 3, utf8_decode($masc), 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 3, utf8_decode('Cánula: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(124, 3, utf8_decode($can), 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Otro: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(169, 3, utf8_decode($otro), 1, 'L');

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Laringoscopía: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(169, 3, utf8_decode($larin), 1, 'L');

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Ventilación: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 3, utf8_decode($venti), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 3, utf8_decode('Circuito: ' ), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(72, 3, utf8_decode($cir), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 3, utf8_decode('Tipo: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 3, utf8_decode($esasme), 1, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Mecánica: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 3, utf8_decode($mec), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 3, utf8_decode('Modo: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 3, utf8_decode($modo), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 3, utf8_decode('Fi O2:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 3, utf8_decode($fl), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 3, utf8_decode('Fr: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 3, utf8_decode($fr), 1, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('V.Corriente: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 3, utf8_decode($vcor), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 3, utf8_decode('Rel. I:E: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 3, utf8_decode($rel), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 3, utf8_decode('PEEP: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(76, 3, utf8_decode($peep), 1, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Comentarios: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(169, 3, utf8_decode($com), 1, 'L');

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Mantenimiento: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(169, 3, utf8_decode($mant), 1, 'L');

$pdf->SetFont('Arial', 'B', 7.2);
$pdf->Cell(27, 3, utf8_decode('Relajación muscular:'), 1, 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23, 3, utf8_decode($relaj), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 3, utf8_decode('Agentes: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 3, utf8_decode($agent), 1, 'L');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 3, utf8_decode('Dosis total:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(34, 3, utf8_decode($dosis), 1, 'L');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(16, 3, utf8_decode('Última dosis:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 3, utf8_decode($ultdosis), 1, 'L');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Antagonismo:'), 1, 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23, 3, utf8_decode($ant), 1, 'L');
$pdf->SetFont('Arial', 'B', 7.2);
$pdf->Cell(18, 3, utf8_decode('Agente/dosis:'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 3, utf8_decode($agdos), 1, 'L');
$pdf->SetFont('Arial', 'B', 7.6);
$pdf->Cell(29, 3, utf8_decode('Monitoreo (opcional):'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(69, 3, utf8_decode($monit), 1, 'L');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Comentarios: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(169, 3, utf8_decode($comen), 1, 'L');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(95, 3, utf8_decode('Anestesia regional: '),0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Bloqueo: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($bloq), 1,0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Técnica: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($tec), 1,0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Posición: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($posi), 1,0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Asep y antisep: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($asep), 1,0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Aguja: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($aguja), 1,0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Agentes y dosis: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($agdosi), 1,0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Catéter: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($cate), 1,0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Latencia: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($lat), 1,0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Difusión: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($dif), 1,0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('B. Simpático: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($bsim), 1,0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('B. Sensitivo: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($bsen), 1,0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('B. Motor: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(71, 3, utf8_decode($bmotor), 1,0, 'L');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Comentarios: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(169, 3, utf8_decode($coment), 1, 'L');


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 3, utf8_decode('Emersión: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(169, 3, utf8_decode($emer), 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(100, 3, utf8_decode('Datos del producto / caso obstétrico: '),0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(196, 3, utf8_decode($caso), 1, 'L');

$a="";
$b="";
$c="";
$d="";
$e="";
$f="";
$g="";
$h="";
$i="";
$j="";
$k="";
$l="";
$m="";
$n="";
$o="";
$p="";
$q="";
$r="";
$s="";
$t="";
$gc = "SELECT * FROM dat_trans_grafico  where id_atencion = $id_atencion order by id_trans_graf DESC limit 1";
$resg = $conexion->query($gc);
while ($row_g = $resg->fetch_assoc()) {
  $a = $row_g['a'];
  $b = $row_g['b'];
  $c = $row_g['c'];
  $d = $row_g['d'];
  $e = $row_g['e'];
  $f = $row_g['f'];
  $g = $row_g['g'];
  $h = $row_g['h'];
  $i = $row_g['i'];
  $j = $row_g['j'];
  $k = $row_g['k'];
  $l = $row_g['l'];
  $m = $row_g['m'];
  $n = $row_g['n'];
  $o = $row_g['o'];
  $p = $row_g['p'];
  $q = $row_g['q'];
  $r = $row_g['r'];
  $s = $row_g['s'];
  $t = $row_g['t'];  
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190, 3, utf8_decode('Medicamentos'), 0,0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(25, 4, utf8_decode('Fecha registro'), 1,0, 'L');
$pdf->Cell(19, 4, utf8_decode('Fecha reporte'), 1,0, 'L');
$pdf->Cell(12, 4, utf8_decode('Hora'), 1,0, 'C');
$pdf->Cell(70, 4, utf8_decode('Medicamento'), 1,0, 'L');
$pdf->Cell(20, 4, utf8_decode('Dosis'), 1,0, 'L');
$pdf->Cell(21, 4, utf8_decode('Via'), 1,0, 'L');
$pdf->Cell(25, 4, utf8_decode('Otro'), 1,0, 'L');
$pdf->Cell(29, 4, utf8_decode('Registró'), 1,0, 'L');
$pdf->Ln(4);
$gct = "SELECT * FROM medica_trans m, reg_usuarios r where id_atencion = $id_atencion and m.id_usua=r.id_usua and m.fecha='$fechar' order by id_mtrans DESC";
$resgt = $conexion->query($gct);
while ($row_gt = $resgt->fetch_assoc()) {
 $pdf->SetFont('Arial', '', 7);
 $fr=date_create($row_gt['fecha_registro']);
 $fre=date_create($row_gt['fecha']);
 $hr=date_create($row_gt['hora']);
 
//$pdf->Cell(25, 4, utf8_decode(date_format($fr,'d-m-Y H:i a')), 1,0, 'L');
$pdf->Cell(19, 4, utf8_decode(date_format($fre,'d-m-Y')), 1,0, 'C');
$pdf->Cell(12, 4, utf8_decode(date_format($hr,'H:i a')), 1,0, 'L');

$pdf->Cell(70, 4, utf8_decode($row_gt['medicamento']), 1,0, 'L');
$pdf->Cell(20, 4, utf8_decode($row_gt['dosis'] . ' ' . $row_gt['unimed']), 1,0, 'L');
$pdf->Cell(21, 4, utf8_decode($row_gt['via']), 1,0, 'L');
$pdf->Cell(25, 4, utf8_decode($row_gt['otro']), 1,0, 'L');
$pdf->Cell(29, 4, utf8_decode($row_gt['papell']), 1,0, 'L');
$pdf->Ln(4);
    
}




$sql_med_id = "SELECT id_usua FROM dat_trans_anest WHERE id_trans_anest = $id_transanest";
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

     $pdf->Ln(20);
   
      $pdf->SetFont('Arial', 'B', 7);
      //$pdf->Image('../../imgfirma/' . $firma, 95, 245, 25);
     if ($firma==null) {
// $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 255 , 25);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 255 , 25);
}
      $pdf->SetY(268);
      $pdf->Cell(200, 1, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(200, 1, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->Cell(200, 1, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
 $pdf->Output();
}