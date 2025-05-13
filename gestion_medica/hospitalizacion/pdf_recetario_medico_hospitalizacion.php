<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id'];
$id_med = @$_GET['id_med'];
$id_exp = @$_GET['id_exp'];
$id_rec = @$_GET['id_rec'];


$sql_rechosp = "SELECT * FROM receta where id_atencion = $id_atencion and id_rec=$id_rec";
$result_rechosp = $conexion->query($sql_rechosp);

while ($row_rechosp = $result_rechosp->fetch_assoc()) {
  $id_rec = $row_rechosp['id_rec'];
}

if(isset($id_rec)){
    $id_rec = $id_rec;
  }else{
    $id_rec ='sin doc';
  }

if($id_rec=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE RECETA PARA ESTE PACIENTE", 
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

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}

   $this->Ln(32);
  }
   function Footer()
  {
    $this->SetFont('Arial', '', 8);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-011'), 0, 1, 'R');
  }
}


$sql_pac = "SELECT p.papell, p.nom_pac,p.fecnac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp,di.tipo_a FROM paciente p, dat_ingreso di where di.id_atencion = $id_atencion and di.Id_exp=p.Id_exp";
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
  $tipo_a = $row_pac['tipo_a'];
}

function calculaedad($fechanacimiento)
{
  list($ano, $mes, $dia) = explode("-", $fechanacimiento);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($ano_diferencia > 0 )
      return ($ano_diferencia . ' AÑOS');
  else if ($mes_diferencia > 0 || $ano_diferencia < 0)
      return ($mes_diferencia . ' MESES');
  else if ($dia_diferencia > 0 || $mes_diferencia < 0 || $ano_diferencia < 0)
      return ($dia_diferencia . ' DÍAS');
}
//consulta receta hosp
$sql_rechosp = "SELECT * FROM receta  where id_atencion = $id_atencion and id_rec=$id_rec";
$result_rechosp = $conexion->query($sql_rechosp);

while ($row_rechosp = $result_rechosp->fetch_assoc()) {
  $alerg = $row_rechosp['alerg'];
  $medi = $row_rechosp['medi'];
  $receta = $row_rechosp['receta'];
  $reg_ssa = $row_rechosp['reg_ssa'];
  $fecha_r_hosp = $row_rechosp['fecha_r_hosp']; 
  $f_pcita = $row_rechosp['fec_pcita']; 
  $h_pcita = $row_rechosp['hor_pcita']; 
}

$financi = "SELECT * FROM dat_financieros  where id_atencion = $id_atencion ORDER by id_datfin ASC LIMIT 1";
$result_rechosp = $conexion->query($financi);

while ($row_fin = $result_rechosp->fetch_assoc()) {
  $aseguradora = $row_fin['aseg']; 
}


$sql = "SELECT * FROM signos_vitales where id_atencion=$id_atencion ORDER by id_sig DESC limit 1";
$result = $conexion->query($sql);

while ($rowtriage = $result->fetch_assoc()) {
     $p_sistolica = $rowtriage['p_sistol'];
  $p_diastolica = $rowtriage['p_diastol'];
  $f_card = $rowtriage['fcard'];
  $f_resp = $rowtriage['fresp'];
  $temp = $rowtriage['temper'];
  $sat_oxigeno = $rowtriage['satoxi'];
  $peso = $rowtriage['peso'];
  $talla = $rowtriage['talla'];
}

//termino receta hosp

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('RECETARIO MÉDICO'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetX(170);
$pdf->SetFont('Arial', '', 6);

$fech=date_create($fecha_r_hosp);
$pdf->Cell(35, -2, 'Fecha: ' . date_format($fech,"d/m/Y H:i"), 0, 1, 'R');


$pdf->Ln(4);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 207, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(207, 53, 207, 280);
$pdf->Line(8, 280, 207, 280);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 4, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 4, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 4, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 4, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 4, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 4, utf8_decode($folio), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 4, ' Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(146, 4, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$date1=date_create($fecnac);
$pdf->Cell(31, 4, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 4, date_format($date1,"d/m/Y"), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 4, ' Edad: ', 0, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(13, 4, utf8_decode($edad),'B', 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(19, 4, utf8_decode(' Ocupación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(36, 4,  utf8_decode($ocup), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 4, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 4,  utf8_decode($tel), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 4, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 4,  $sexo, 'B', 'L');
$pdf->Ln(5);
$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$Id_exp ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_hc = $result_sig->fetch_assoc()) {
$pesoh=$row_hc['peso'];
$tallah=$row_hc['talla'];
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, utf8_decode('Peso: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 4,  utf8_decode($pesoh.' Kilos'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 4, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 4,  utf8_decode($tallah.' Metros'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 4, utf8_decode(' Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(125, 4, utf8_decode($dir), 'B', 'L');

$pdf->Ln(4);

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
    
$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$Id_exp ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);

while ($row_hc = $result_sig->fetch_assoc()) {

 $pesoh=$row_hc['peso'];
 $tallah=$row_hc['talla'];

}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(195, 5, utf8_decode('Signos Vitales:'), 0,0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(38, 6, utf8_decode('Presión Arterial: ' .$p_sistolica.'/'.$p_diastolica).' mmHG', 1, 'L');
$pdf->Cell(43, 6, utf8_decode('Frecuencia Cardiaca: ' .$f_card.' Latidos/min'), 1, 'L');
$pdf->Cell(54, 6, utf8_decode('Frecuencia Respiratoria: ' .$f_resp.' Respiraciones/min'), 1, 'L');
$pdf->Cell(26, 6, utf8_decode('Temperatura: ' .$temp.' °C'), 1, 'L');
$pdf->Cell(34, 6, utf8_decode('Saturación de Oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Ln(7);

 $pdf->SetFont('Arial', 'B', 8);

 $pdf->Cell(20, 6, utf8_decode('Alergias: '),0, 'C');
 $pdf->SetFont('Arial', '', 8);
 $pdf->MultiCell(174, 4.5, utf8_decode($alerg), 'B', 'L');
 $pdf->Ln(1);
/*cuadro de medicamentos  */
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(10, 88, 204, 88);
$pdf->Line(10, 88, 10, 238);
$pdf->Line(205, 88, 204, 238);
$pdf->Line(10, 238, 204, 238);
/*cuadro de medicamentos  */
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetX(90);
//$pdf->Cell(45, 8, 'Tratamiento : ',0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(190, 3.5, utf8_decode($receta), 0, 'L');
$pdf->Ln(1);

$pdf->SetY(238);
$pdf->SetX(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(43, 6, utf8_decode('Medidas higiénicas-dietéticas:'),0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(150, 4.5, utf8_decode($medi), 'B', 'L');

$date=date_create($f_pcita);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetX(10);
$pdf->Ln(1);
$pdf->Cell(20, 6, utf8_decode('Próxima cita: '),0,0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, date_format($date,"d-m-Y") . ' ' . $h_pcita, 'B', 'L');


$sql_med_id = "SELECT id_usua FROM receta WHERE id_atencion = $id_atencion ORDER by fecha_r_hosp DESC LIMIT 1";
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
    $pdf->SetFont('Arial', 'B', 8);
      $pdf->SetY(-50);
      $pdf->SetFont('Arial', 'B', 8);
      //$pdf->Image('../../imgfirma/' . $firma, 95, 245, 30);
     if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 245 , 25);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 245 , 25);
}
       $pdf->SetY(264);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'Céd. prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');

 $pdf->Output();
}