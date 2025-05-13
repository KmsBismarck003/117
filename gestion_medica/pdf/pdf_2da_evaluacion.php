<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_med = @$_GET['id_med'];
$id_segevol = @$_GET['id_seg_evol'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$sql_seg = "SELECT * FROM dat_seg_evol  where id_atencion = $id_atencion";
$result_seg = $conexion->query($sql_seg);

while ($row_seg = $result_seg->fetch_assoc()) {
  $id_seg_evol = $row_seg['id_seg_evol'];
}

if(isset($id_seg_evol)){
    $id_seg_evol = $id_seg_evol;
  }else{
    $id_seg_evol ='sin doc';
  }

if($id_seg_evol=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE EVALUACIÓN ANTES DEL PROCEDIMIENTO ANESTÉSICO PARA ESTE PACIENTE", 
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
    $this->Cell(0, 10, utf8_decode('MAC-7.02'), 0, 1, 'R');
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

//consulta observacion
$sql_seg = "SELECT * FROM dat_seg_evol  where id_seg_evol = $id_segevol";
$result_seg = $conexion->query($sql_seg);

while ($row_seg = $result_seg->fetch_assoc()) {
  $fecha2 = $row_seg['fecha2'];
  $hora2 = $row_seg['hora2'];
  $ansed = $row_seg['ansed'];  
  $diaproc = $row_seg['diaproc'];  
  $sist = $row_seg['sist'];  
  $diast = $row_seg['diast']; 
  $freccard = $row_seg['freccard']; 
  $frecresp = $row_seg['frecresp']; 
  $temp = $row_seg['temp'];  
  $spo2 = $row_seg['spo2'];

 $med_pre = $row_seg['med_pre'];
  $dosis = $row_seg['dosis'];
  $via = $row_seg['via'];  
  $fechamedi = $row_seg['fechamedi'];  
  $horamedi = $row_seg['horamedi'];  
  $efect = $row_seg['efect']; 

  $med_pre2 = $row_seg['med_pre2']; 
  $dosis2 = $row_seg['dosis2']; 
  $via2 = $row_seg['via2'];  
  $fechamedi2 = $row_seg['fechamedi2'];
  $horamedi2 = $row_seg['horamedi2'];
  $efect2 = $row_seg['efect2'];
  $hora_ver = $row_seg['hora_ver'];  
  $apan = $row_seg['apan'];  
  $vent = $row_seg['vent'];  
  $fuen = $row_seg['fuen']; 
  $ecg = $row_seg['ecg']; 
  $circ = $row_seg['circ']; 
  $para = $row_seg['para'];  
  $fuent = $row_seg['fuent'];


  $pani = $row_seg['pani']; 
  $fugas = $row_seg['fugas']; 
  $flujo = $row_seg['flujo'];  
  $spo = $row_seg['spo'];
  $cal = $row_seg['cal'];
  $vapo = $row_seg['vapo'];
  $co2 = $row_seg['co2'];  
  $ana = $row_seg['ana'];  
  $indice = $row_seg['indice'];  
  $bomba = $row_seg['bomba']; 
  $moni = $row_seg['moni']; 
  $obser = $row_seg['obser']; 
  $noanest = $row_seg['noanest'];  
  $fecha_nota = $row_seg['fecha_nota'];

}
//termino observacion


$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,20);
$pdf->SetTextColor(43, 45, 127);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(50);
$pdf->Cell(120, 5, utf8_decode('EVALUACIÓN ANTES DEL PROCEDIMIENTO ANESTÉSICO'), 0, 0, 'C');
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

$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(5);

$pdf->Cell(95, 4, utf8_decode('Fecha: ' .$fecha2.' Hora: ' .$hora2), 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(189, 4, utf8_decode('Se corroboró la identificación del paciente, su estado actual, el diagnóstico y el procedmiento programado antes del inicio de la anestesia: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(6, 4, utf8_decode($diaproc), 1, 'C');
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 3, utf8_decode('SIGNOS VITALES'), 0,0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(37, 3, utf8_decode('Presión arterial: ' .$sist.'/'.$diast), 1, 'L');
$pdf->Cell(40, 3, utf8_decode('Frecuencia cardiaca: ' .$freccard), 1, 'L');
$pdf->Cell(40, 3, utf8_decode('Frecuencia respiratoria: ' .$frecresp), 1, 'L');
$pdf->Cell(38, 3, utf8_decode('Temperatura: ' .$temp), 1, 'L');
$pdf->Cell(40, 3, utf8_decode('Saturación de oxígeno: ' .$spo2), 1, 'L');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 4, utf8_decode('Medicación preanestésica'), 1,0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 4, utf8_decode('Dosis'), 1,0, 'C');
$pdf->Cell(25, 4, utf8_decode('Vía' ), 1,0, 'C');
$pdf->Cell(25, 4, utf8_decode('Fecha' ), 1,0, 'C');
$pdf->Cell(25, 4, utf8_decode('Hora' ), 1,0, 'C');
$pdf->Cell(58, 4, utf8_decode('Efecto'), 1,0, 'C');
$pdf->Ln(4);
$pdf->Cell(37, 4, utf8_decode($med_pre), 1,0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 4, utf8_decode($dosis), 1,0, 'C');
$pdf->Cell(25, 4, utf8_decode($via), 1,0, 'C');
$pdf->Cell(25, 4, utf8_decode($fechamedi), 1,0, 'C');
$pdf->Cell(25, 4, utf8_decode($horamedi), 1,0, 'C');
$pdf->Cell(58, 4, utf8_decode($efect), 1,0, 'C');
$pdf->Ln(4);
$pdf->Cell(37, 6, utf8_decode($med_pre2), 1,0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6, utf8_decode($dosis2), 1,0, 'C');
$pdf->Cell(25, 6, utf8_decode($via2), 1,0, 'C');
$pdf->Cell(25, 6, utf8_decode($fechamedi2), 1,0, 'C');
$pdf->Cell(25, 6, utf8_decode($horamedi2), 1,0, 'C');
$pdf->Cell(58, 6, utf8_decode($efect2), 1,0, 'C');

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(140, 6, utf8_decode('Verificación del equipo y monitoreo antes de la anestesia'), 0,0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(55, 6, utf8_decode('Hora: '.$hora_ver), 0,0, 'C');

$pdf->Ln(6); 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 6, utf8_decode('Aparato de anestesia: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($apan), 1,0, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Circuito: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($circ), 1,0, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Fugas: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($fugas), 1,0, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Cal sonda: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($cal), 1,0, 'C');

$pdf->Ln(6); 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 6, utf8_decode('Ventilador: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($vent), 1,0, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Parámetros ventilatorios: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($para), 1,0, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Flujómetro:'), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($flujo), 1,0, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Vaporizadores: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($vapo), 1,0, 'C');

$pdf->Ln(6); 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 6, utf8_decode('Ecg: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($ecg), 1,0, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Pani: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($pani), 1,0, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Spo2:'), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($spo), 1,0, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Co2fe: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($co2), 1,0, 'C');


$pdf->Ln(6); 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 6, utf8_decode('Fuente de o2 y alarmas: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($fuen), 1,0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Fuente de energía y alarmas: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($fuent), 1,0, 'C');


$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(140, 6, utf8_decode('Opcionales'), 0,0, 'L');
$pdf->Ln(6); 

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 6, utf8_decode('Analizador de gases resp: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($ana), 1,0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Índice biespectral: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($indice), 1,0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Bomba de infusión:'), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($bomba), 1,0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 6, utf8_decode('Monitor de relajación: '), 1,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(11, 6, utf8_decode($moni), 1,0, 'C');

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190, 6, utf8_decode('Observaciones:'), 0, 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 6, utf8_decode($obser),1, 'l');



$sql_med_id = "SELECT id_usua FROM dat_seg_evol WHERE id_seg_evol = $id_segevol";
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
 //$pdf->Image('../../imgfirma/FIRMA.jpg', 94, 250 , 25);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 250 , 25);
}
      $pdf->SetY(264);
      $pdf->Cell(200, 1, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 1, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->Cell(200, 1, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
 $pdf->Output();
}