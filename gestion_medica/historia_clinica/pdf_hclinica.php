<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_hc = @$_GET['id_hc'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$sql_hclinica = "SELECT * from dat_hclinica  where id_hc=$id_hc and Id_exp=$id_exp ";

$result_hclinica = $conexion->query($sql_hclinica);

while ($row_hclinica = $result_hclinica->fetch_assoc()) {
  $id_hc = $row_hclinica['id_hc'];
}

  if(isset($id_hc)){
    $id_hc = $id_hc;
  }else{
    $id_hc ='sin doc';
  }

if($id_hc=="sin doc"){
 echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "No existe historia clínica para este paciente", 
                            type: "error",
                            confirmButtonText: "Aceptar"
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

    $id = @$_GET['id'];;

    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}
    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
 
    $this->Ln(10);
    
    
    $this->Ln(4);
 
    $this->Ln(4);
    
    $this->Ln(4);
    
    $this->Ln(10);
    
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-003'), 0, 1, 'R');
  }
}

$sql_hclinica = "SELECT * from dat_hclinica where id_hc=$id_hc and Id_exp=$id_exp ";

$result_hclinica = $conexion->query($sql_hclinica);

while ($row_hclinica = $result_hclinica->fetch_assoc()) {
  $id_hc = $row_hclinica['id_hc'];
  $fec_hc = $row_hclinica['fec_hc'];
  $tip_hc = $row_hclinica['tip_hc'];
  $hc_abu = $row_hclinica['hc_abu'];
  $hc_pad = $row_hclinica['hc_pad'];
  $hc_her = $row_hclinica['hc_her'];
  $hc_zoo = $row_hclinica['hc_zoo'];
  $des_diag = $row_hclinica['des_diag'];

  $hc_zoo_cual = $row_hclinica['hc_zoo_cual'];
 // $hc_nac = $row_hclinica['hc_nac'];
  $hc_ali = $row_hclinica['hc_ali'];
  $hc_act = $row_hclinica['hc_act'];
  $hc_otro = $row_hclinica['hc_otro'];
  $hc_adic = $row_hclinica['hc_adic'];
 // $hc_adic_cual = $row_hclinica['hc_adic_cual'];
  
  
  $hc_enf = $row_hclinica['hc_enf'];
  $hc_enf_cual = $row_hclinica['hc_enf_cual'];
//CHECK BOX
  $hc_pato = $row_hclinica['hc_pato'];
  $hc_pato_cual = $row_hclinica['hc_pato_cual'];
  $hc_tra = $row_hclinica['hc_tra'];
  $hc_ale = $row_hclinica['hc_ale'];
  $cro = $row_hclinica['cro'];
  $crog = $row_hclinica['crog'];
//FIN CHECK

  $hc_men  = $row_hclinica['hc_men'];
  $hc_ritmo  = $row_hclinica['hc_ritmo'];

  $hc_ges = $row_hclinica['hc_ges'];
  $hc_par = $row_hclinica['hc_par'];
  $hc_ces = $row_hclinica['hc_ces'];
  $hc_abo = $row_hclinica['hc_abo'];
  $hc_fechafur = $row_hclinica['hc_fechafur'];

  $hc_desc_hom = $row_hclinica['hc_desc_hom'];

  $hc_pade = $row_hclinica['hc_pade'];
 // $hc_apa = $row_hclinica['hc_apa'];
  $p_sistolica = $row_hclinica['p_sistolica'];
  $p_diastolica = $row_hclinica['p_diastolica'];
  $f_card = $row_hclinica['f_card'];
  $f_resp = $row_hclinica['f_resp'];
  $temp = $row_hclinica['temp'];
  $sat_oxigeno = $row_hclinica['sat_oxigeno'];
  $peso = $row_hclinica['peso'];
  $talla = $row_hclinica['talla'];
  
  $cardio = $row_hclinica['cardio'];
  $respira = $row_hclinica['respira'];
  $gastro = $row_hclinica['gastro'];
  $genito = $row_hclinica['genito'];
  $hematico = $row_hclinica['hematico'];
  $endocrino = $row_hclinica['endocrino'];
  $nervioso = $row_hclinica['nervioso'];
  $musculo = $row_hclinica['musculo'];
  $anexos = $row_hclinica['anexos'];

  $habitus = $row_hclinica['habitus'];
  $cabeza = $row_hclinica['cabeza'];
  $neuro = $row_hclinica['neuro'];
  $cuello = $row_hclinica['cuello'];
  $torax= $row_hclinica['torax'];
  $abdomen = $row_hclinica['abdomen'];
  $genitales = $row_hclinica['genitales'];
  $extrem = $row_hclinica['extrem'];
  $piel= $row_hclinica['piel'];


  $explora = $row_hclinica['hc_explora'];
  $lab = $row_hclinica['hc_lab'];
  $gab = $row_hclinica['hc_gabi'];
  $hc_res_o = $row_hclinica['hc_res_o'];
  $id_cie_10 = $row_hclinica['id_cie_10'];
  $hc_te = $row_hclinica['hc_te'];
  $hc_ta = $row_hclinica['hc_ta'];
  $hc_vid = $row_hclinica['hc_vid'];
  $hc_def = $row_hclinica['hc_def'];
  $hc_dis = $row_hclinica['hc_dis'];
  $hc_her_o = $row_hclinica['hc_her_o'];
  $diag_prev = $row_hclinica['diag_prev'];
}

$sql_pac = "SELECT * FROM paciente where Id_exp=$id_exp";

$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $fecnac = $row_pac['fecnac'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
 
  $Id_exp = $row_pac['Id_exp'];
  $dir = $row_pac['dir'];
  $id_edo = $row_pac['id_edo'];
  $id_mun = $row_pac['id_mun'];
  $tel = $row_pac['tel'];
  $ocup = $row_pac['ocup'];
  $tip_san = $row_pac['tip_san'];
  $resp = $row_pac['resp'];
  $paren = $row_pac['paren'];
  $tel_resp = $row_pac['tel_resp'];
  $edociv = $row_pac['edociv'];
  $religion = $row_pac['religion']; 
  $folio = $row_pac['folio']; 
}

$sql_edo = "SELECT nombre FROM estados WHERE id_edo = $id_edo";
$result_edo = $conexion->query($sql_edo);

while ($row_edo = $result_edo->fetch_assoc()) {
  $nom_edo = $row_edo['nombre'];
}

$sql_cie = "SELECT * FROM cat_diagnosticos WHERE id_cie_10 = $id_cie_10";
$result_cie = $conexion->query($sql_cie);

/*while ($row_cie = $result_cie->fetch_assoc()) {
  $id_cie10 = $row_cie['id_cie10'];
  $desc_cie10 = $row_cie['descripcion_cie10'];
}*/

$sql_mun = "SELECT nombre_m FROM municipios WHERE id_mun = $id_mun";
$result_mun = $conexion->query($sql_mun);

while ($row_mun = $result_mun->fetch_assoc()) {
  $nom_mun = $row_mun['nombre_m'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,29); 

$pdf->SetDrawColor(43, 45, 127);
$pdf->Ln(-1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(40);
$pdf->SetTextColor(43, 45, 127);
$pdf->Cell(140, 8, utf8_decode('HISTORIA CLÍNICA'), 1, 0, 'C');
$pdf->Ln(9);



$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y");


$pdf->SetFont('Arial', '', 9);
$pdf->SetDrawColor(43, 45, 127);
$fec_hc=date_create($fec_hc);
$pdf->Cell(66, 6, utf8_decode('Fecha de elaboración: ' .date_format($fec_hc,"d/m/Y") . " " . date_format($fec_hc,"H:i a")), 1, 'C');
//$pdf->Cell(33, 6, utf8_decode('Hora: ' .date_format($fec_hc,"H:i a") ), 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 6, utf8_decode('Expediente: '. $folio), 1, 'C');

$pdf->Cell(98, 6, utf8_decode('Interrogatorio: ' . $tip_hc), 1, 'C');

$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(2);
$pdf->Cell(200, 6, utf8_decode('I. FICHA DE IDENTIFICACIÓN: '), 0, 0, 'L');
$pdf->Ln(5);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 63, 207, 63);
$pdf->Line(8, 63, 8, 86);
$pdf->Line(207, 63, 207, 86);
$pdf->Line(8, 86, 207, 86);

$sql_dat_ing = "SELECT * from dat_ingreso where Id_exp=$id_exp";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $id_atencion = $row_dat_ing['id_atencion'];     
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $fecha_ing = $row_dat_ing['fecha'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $tipo_a = $row_dat_ing['tipo_a'];
}



//echo "<br>Tu edad es: $anos años con $meses meses y $dias días";
/*$pdf->SetFont('Arial', '', 8);
$date=date_create($fecha_ing);
$pdf->Cell(32, 6, utf8_decode('FECHA DE INGRESO:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6, date_format($date,'d-m-Y H:i:s'), 'B', 0, 'C'); */


$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 5, 'Nombre del paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(167, 5, utf8_decode($papell . ' ' . $sapell.' '.$nom_pac), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 8);
$date=date_create($fecnac);
$pdf->Cell(29, 5, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 5, date_format($date,"d/m/Y"), 'B', 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 5, ' Edad: ', 0, 'L');

 
  $pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 5, utf8_decode($edad), 'B', 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(12, 5, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, 5,  $sexo, 'B', 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 5, utf8_decode('Estado civil: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 5,  utf8_decode($edociv), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 5, utf8_decode('Ocupación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(47, 5,  utf8_decode($ocup), 'B', 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(13, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(19, 5,  utf8_decode($tel), 'B', 'L');
$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE id_hc=$id_hc and Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_hc = $result_sig->fetch_assoc()) {
$pesoh=$row_hc['peso'];
$tallah=$row_hc['talla'];
}

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 5, utf8_decode(' Peso: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 5,  utf8_decode($pesoh.' Kilos'), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 5, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 5,  utf8_decode($tallah.' Metros'), 'B', 'L');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(14, 5, utf8_decode('Dirección: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(136, 5, utf8_decode($dir), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 5, utf8_decode(' Tipo de sangre: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(24, 5,  utf8_decode($tip_san), 'B', 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(10);

$d="";
$m="";
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
  $pdf->Cell(199, 6, utf8_decode('Diagnóstico: ' . $d) , 1, 'C');
     
    } else{
         $pdf->Cell(199, 6, utf8_decode('Motivo de atención: ' . $m) , 1, 'C');
    }
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(2);
$pdf->Cell(200, 6, utf8_decode('II. ANTECEDENTES HEREDO FAMILIARES: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(6); 
$pdf->MultiCell(199, 6, utf8_decode($hc_her_o), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(2);
$pdf->Cell(200, 6, utf8_decode('III. ANTECEDENTES PERSONALES NO PATOLÓGICOS: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(6);
$pdf->MultiCell(199, 6, utf8_decode($hc_otro), 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(2);
$pdf->Cell(200, 6, utf8_decode('IV. ANTECEDENTES PERSONALES PATOLÓGICOS: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(6);
$pdf->MultiCell(199, 6, utf8_decode($hc_pato), 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(2);
$pdf->Cell(190, 6, utf8_decode('V. ANTECEDENTES GINECO-OBSTÉTRICOS: '), 0, 0, 'L');
$pdf->Ln(6);

if($sexo==='MUJER' or $sexo==='Mujer')
{

$pdf->SetFont('Arial', '', 9);

$pdf->Cell(34, 6, utf8_decode('Menarca: ' . $hc_men), 1, 'L');
$pdf->Cell(33, 6, utf8_decode('Ritmo: ' . $hc_ritmo), 1, 'L');
$pdf->Cell(20, 6, utf8_decode('Gestas: ' . $hc_ges), 1, 'L');
$pdf->Cell(20, 6, utf8_decode('Partos: ' . $hc_par), 1, 'L');
$pdf->Cell(22, 6, utf8_decode('Cesáreas: ' . $hc_ces), 1, 'L');
$pdf->Cell(20, 6, utf8_decode('Abortos: ' . $hc_abo), 1, 'L');
$date=date_create($hc_fechafur);
$pdf->Cell(50, 6, utf8_decode('Fecha última regla: ' . date_format($date,"d/m/Y")), 1, 'L');
}else{
  $pdf->SetFont('Arial', '', 9);
  $pdf->Cell(199, 6, 'No aplica', 1, 'L');
}

$pdf->Ln(6);
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 6, utf8_decode('VI. PADECIMIENTO ACTUAL: '), 0, 0, 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 9);

$pdf->MultiCell(199, 6, utf8_decode($hc_pade), 1, 'J');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(2);
$pdf->Cell(200, 6, utf8_decode('VII. INTERROGATORIO POR APARATOS Y SISTEMAS: '), 0, 0, 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', '', 9);

$pdf->MultiCell(199, 6, utf8_decode($cardio), 1, 'J');

$pdf->Ln(2);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 6, utf8_decode('VIII. EXPLORACIÓN FÍSICA: '), 0, 0, 'L');
$pdf->Ln(6);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(167, 6, utf8_decode($habitus), 1, 'J');
$pdf->Ln(2);



$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 6, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(6);

$pdf->SetFont('Arial', '', 7.2);
$pdf->Cell(39, 6, utf8_decode('Presión Arterial: ' .$p_sistolica.'/'.$p_diastolica).' mmHG', 1, 'L');
$pdf->Cell(45, 6, utf8_decode('Frecuencia Cardiaca: ' .$f_card.' Latidos/min'), 1, 'L');
$pdf->Cell(55, 6, utf8_decode('Frecuencia Respiratoria: ' .$f_resp.' Respiraciones/min'), 1, 'L');
$pdf->Cell(26, 6, utf8_decode('Temperatura: ' .$temp.' °C'), 1, 'L');
$pdf->Cell(34, 6, utf8_decode('Saturación de Oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(2);
$pdf->Cell(200, 6, utf8_decode('IX. RESULTADOS PREVIOS Y ACTUALES DE ESTUDIOS: '), 0, 0, 'L');
$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode('Laboratorio: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(167, 6, utf8_decode($lab), 1, 'J');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode('Gabinete: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(167, 6, utf8_decode($gab), 1, 'J');


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode('Otros resultados: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(167, 6, utf8_decode($hc_res_o), 1, 'J');


$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(2);
$pdf->Cell(200, 6, utf8_decode('X. TRATAMIENTO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode('Terapéutica previa: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(167, 6, utf8_decode($hc_te), 1, 'J');


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode('Terapéutica actual: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(167, 6, utf8_decode($hc_ta), 1, 'J');
$pdf->Ln(1);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(2);
$pdf->Cell(200, 6, utf8_decode('XI. DIAGNÓSTICOS: '), 0, 0, 'L');

$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode('Diagnóstico principal: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(167, 6, utf8_decode($id_cie_10), 1, 'J');


if($des_diag!=null){
  $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode('Describir diagnóstico: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(167, 6, utf8_decode($des_diag), 1, 'L');
$pdf->Ln(6);
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode('Diagnósticos previos: '), 0, 'L'); 
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(167, 6, utf8_decode($diag_prev), 1, 'J');
$pdf->Ln(2);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 6, utf8_decode('XII. PRONÓSTICOS: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode('Para la vida:'), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 6, utf8_decode($hc_vid), 1, 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, utf8_decode('Para la función:'), 0, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 6, utf8_decode($hc_def), 1, 'L');

//$pdf->Cell(118, 6, utf8_decode('DISCAPACIDAD : '.$hc_dis), 1, 'L');

$pdf->Ln(1);

$sql_med_id = "SELECT id_usua FROM dat_hclinica WHERE id_hc=$id_hc and Id_exp=$id_exp ORDER by fec_hc DESC LIMIT 1";
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
   
      
      $pdf->SetFont('Arial', 'B', 7.5);
      //$pdf->Image('../../imgfirma/' . $firma, 95, 245, 25);
       if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 240 , 30);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 240 , 30);
}
      
      $pdf->sety(258);

      $pdf->Cell(200, 5, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(2.5);
      $pdf->SetFont('Arial', 'B', 7.5);
      $pdf->Cell(200, 5, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(2.5);
      $pdf->Cell(200, 5, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');


$pdf->Output();
}