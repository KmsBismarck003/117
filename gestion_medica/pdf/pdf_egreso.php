  <?php
  require '../../fpdf/fpdf.php';
  include '../../conexionbd.php';
  $id_in = @$_GET['id_in'];
  $id_med = @$_GET['id_med'];
  $id_egreso = @$_GET['id_in'];

  $id_exp = @$_GET['id_exp'];
  $id_atencion = @$_GET['id_atencion'];
  
  $sql_dat_eg = "SELECT * from dat_egreso where id_atencion = $id_atencion and id_egreso=$id_in";
  $result_dat_eg = $conexion->query($sql_dat_eg);

  while ($row_dat_eg = $result_dat_eg->fetch_assoc()) {
    $id_egreso = $row_dat_eg['id_egreso'];
  }
  if(isset($id_egreso)){
      $id_egreso = $id_egreso;
    }else{
      $id_egreso ='sin doc';
    }

  if($id_egreso=="sin doc"){
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
        $(document).ready(function() {
            swal({
                title: "No existe nota de egreso para este paciente", 
                type: "error",
                confirmButtonText: "Aceptar"
                }, function(isConfirm) 
            { 
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
    include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}

   $this->Ln(30);
    }
     function Footer()
  {
    $this->Ln(8);
    $this->SetFont('Arial', '', 7);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 4, utf8_decode('MAC-5.07'), 0, 1, 'R');
  }
  }

  $sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.folio,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p where p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  $Id_exp = $row_pac['Id_exp'];
  $folio = $row_pac['folio'];
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

$sql_preop = "SELECT * FROM dat_ingreso where id_atencion = $id_atencion";
$result_preop = $conexion->query($sql_preop);

while ($row_preop = $result_preop->fetch_assoc()) {
 
    $tipo_a = $row_preop['tipo_a'];
    $fecha_ing = $row_preop['fecha'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$sql_ing = "SELECT * FROM dat_not_ingreso where id_atencion = $id_atencion";
$result_ing = $conexion->query($sql_ing);

while ($row_ing = $result_ing->fetch_assoc()) {
 $fecha_dat_ingreso=$row_ing['fecha_dat_ingreso'];
 $fecha_actual=$row_ing['fecha_dat_ingreso'];
 $mot_ingreso=$row_ing['mot_ingreso'];
 $resinterr_i=$row_ing['resinterr_i'];
 $expfis_i=$row_ing['expfis_i'];
 $resaux_i=$row_ing['resaux_i'];
 $diagprob_i=$row_ing['diagprob_i'];
 $plan_i=$row_ing['plan_i'];
 $des_diag=$row_ing['des_diag'];
 $pron_i=$row_ing['pron_i'];
 $guia=$row_ing['guia'];

}
$sql_dat_eg = "SELECT * from dat_egreso where id_egreso=$id_in and id_atencion = $id_atencion";
  $result_dat_eg = $conexion->query($sql_dat_eg);

  while ($row_dat_eg = $result_dat_eg->fetch_assoc()) {
    $fech_egreso = $row_dat_eg['fech_egreso'];
    $id_med = $row_dat_eg['id_usua'];
  }

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(64);
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Cell(100, 5, utf8_decode('NOTA DE EGRESO'),1, 0, 'C');

/*
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 47, 172, 47);
$pdf->Line(48, 41, 48, 47);
$pdf->Line(172, 41, 172, 47);
$pdf->Line(48, 41, 172, 41);
*/
$pdf->SetX(170);

$pdf->SetFont('Arial', '', 6);

$date1=date_create($fech_egreso);
$pdf->Cell(35, -2, 'FECHA: ' . date_format($date1,"d/m/Y H:i a"), 0, 1, 'R');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 46, 207, 46);
$pdf->Line(8, 46, 8, 280);
$pdf->Line(207, 46, 207, 280);
$pdf->Line(8, 280, 207, 280);
$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 4, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 4, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 4, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 4, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 4, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 4, utf8_decode($folio), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 4, ' Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(146, 4, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$fechanac=date_create($fecnac);
$pdf->Cell(31, 4, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 4, date_format($fechanac,"d/m/Y"), 'B', 'L');
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
$pdf->Ln(4);

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
/*
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
    $pdf->Cell(20, 4, utf8_decode('Diagnóstico:') , 0, 'C');
    $pdf->SetFont('Arial', '', 9);
     $pdf->Cell(175, 4, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 4, utf8_decode('Motivo de atención:') , 0, 'C');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(166, 4, utf8_decode($m) , 'B', 'C');
    }

*/
$sql_sig ="select * from signos_vitales WHERE id_atencion=$id_atencion ORDER by id_sig DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_sig = $result_sig->fetch_assoc()) {
 $p_sistolica=$row_sig['p_sistol'];
 $p_diastolica=$row_sig['p_diastol'];
 $f_card=$row_sig['fcard'];
 $f_resp=$row_sig['fresp'];
 $temp=$row_sig['temper'];
 $sat_oxigeno=$row_sig['satoxi'];
 $niv_dolor=$row_sig['niv_dolor'];
}

$pdf->Ln(4);

$sql_sig ="select * from signos_vitales WHERE id_atencion=$id_atencion ORDER by id_sig DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);

while ($row_sig = $result_sig->fetch_assoc()) {
 $p_sistolica=$row_sig['p_sistol'];
 $p_diastolica=$row_sig['p_diastol'];
 $f_card=$row_sig['fcard'];
 $f_resp=$row_sig['fresp'];
 $temp=$row_sig['temper'];
 $sat_oxigeno=$row_sig['satoxi'];
 $peso=$row_sig['peso'];
 $talla=$row_sig['talla'];
 $niv_dolor=$row_sig['niv_dolor'];
}

 $sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
  $result_dat_ing = $conexion->query($sql_dat_ing);

  while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
    $motivo_atn = $row_dat_ing['motivo_atn'];
    $especialidad = $row_dat_ing['especialidad'];
    $id_usua = $row_dat_ing['id_usua'];
    $fecha_ing=$row_dat_ing['fecha'];
  }

if(@$_GET['id_egreso'] != NULL){
$sql_dat_eg = "SELECT * from dat_egreso where id_egreso = $id_in and id_atencion=$id_antencion;";
  $result_dat_eg = $conexion->query($sql_dat_eg);

  while ($row_dat_eg = $result_dat_eg->fetch_assoc()) {
    $reingreso = $row_dat_eg['reingreso'];
    $diag_eg = $row_dat_eg['diag_eg'];
    $fech_egreso = $row_dat_eg['fech_egreso'];
    $res_clin = $row_dat_eg['res_clin'];
    $diagfinal=$row_dat_eg['diagfinal'];
    $reingreso=$row_dat_eg['reingreso'];
    $cond=$row_dat_eg['cond'];
    $dias=$row_dat_eg['dias'];
    $manejodur=$row_dat_eg['manejodur'];
    $probclip=$row_dat_eg['probclip'];
    $cuid=$row_dat_eg['cuid'];
    $trat=$row_dat_eg['trat'];
    $exes=$row_dat_eg['exes'];
    $pcita=$row_dat_eg['pcita'];
    $hcita=$row_dat_eg['hcita'];
    $id_med = $row_med_id['id_usua'];
  }
}else{
  $sql_dat_eg = "SELECT * from dat_egreso where id_egreso=$id_in and id_atencion = $id_atencion";
  $result_dat_eg = $conexion->query($sql_dat_eg);

  while ($row_dat_eg = $result_dat_eg->fetch_assoc()) {
    $reingreso = $row_dat_eg['reingreso'];
    $diag_eg = $row_dat_eg['diag_eg'];
    $fech_egreso = $row_dat_eg['fech_egreso'];
    $res_clin = $row_dat_eg['res_clin'];
    $diagfinal=$row_dat_eg['diagfinal'];
    $reingreso=$row_dat_eg['reingreso'];
    $cond=$row_dat_eg['cond'];
    $dias=$row_dat_eg['dias'];
    $manejodur=$row_dat_eg['manejodur'];
    $probclip=$row_dat_eg['probclip'];
    $cuid=$row_dat_eg['cuid'];
    $trat=$row_dat_eg['trat'];
    $exes=$row_dat_eg['exes'];
    $pcita=$row_dat_eg['pcita'];
    $hcita=$row_dat_eg['hcita'];
    $id_med= $row_dat_eg['id_usua'];
    $edo= $row_dat_eg['edo'];
    $px= $row_dat_eg['px'];
  }
}

$fecha_egreso=date_create($fech_egreso);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(28, 4, utf8_decode('Fecha de egreso: '),1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 4, utf8_decode(date_format($fecha_egreso,"d/m/Y")),1, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(23, 4, utf8_decode('Dias estancia: '),1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(7, 4, utf8_decode($dias),1, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 4, utf8_decode('Motivo del egreso: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode($cond) , 1, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 4, utf8_decode('Reingreso: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(18, 4, utf8_decode($reingreso),1, 'C');

$pdf->Ln(1);
$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$Id_exp ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_hc = $result_sig->fetch_assoc()) {
 $pesoh=$row_hc['peso'];
 $tallah=$row_hc['talla'];
}

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(200, 3, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell(39, 3, utf8_decode('Presión Arterial: ' .$p_sistolica.'/'.$p_diastolica).' mmHG', 1, 'L');
$pdf->Cell(44, 3, utf8_decode('Frecuencia Cardiaca: ' .$f_card.' Latidos/min'), 1, 'L');
$pdf->Cell(54, 3, utf8_decode('Frecuencia Respiratoria: ' .$f_resp.' Respiraciones/min'), 1, 'L');
$pdf->Cell(26, 3, utf8_decode('Temperatura: ' .$temp.' °C'), 1, 'L');
$pdf->Cell(33, 3, utf8_decode('Saturación de Oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(47, 5, utf8_decode('Resumen de la evolución: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(196, 5, utf8_decode($res_clin),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(35, 5, utf8_decode('Diagnóstico de Egreso: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(161, 5, utf8_decode($diag_eg),1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(35, 5, utf8_decode('Diagnóstico(s) Final(es): '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(161, 5, utf8_decode($diagfinal),1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(110, 5, utf8_decode('Medicamentos relevantes administrados durante el proceso de atención: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(196, 5, utf8_decode($manejodur),1, 'J');
$pdf->Ln(1);/*
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(148,5, utf8_decode('Medicamento'),1,0,'C');
$pdf->Cell(20,5, utf8_decode('Dósis'),1,0,'C');
$pdf->MultiCell(27,5, utf8_decode('Vía'),1,'C');

$medica = $conexion->query("select * from medica_enf WHERE id_atencion=$id_atencion and neonato!='Si' and material!='Si' group by medicam_mat ORDER BY id_med_reg DESC") or die($conexion->error);
while ($row_m = $medica->fetch_assoc()) {

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(148,5, utf8_decode($row_m['medicam_mat']),1,0,'L');
$pdf->Cell(20,5, $row_m['dosis_mat'],1,0,'C');
$pdf->MultiCell(27,5, $row_m['via_mat'],1,'C');
}
*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(110, 5, utf8_decode('Medicamentos prescritos al egreso (Receta médica): '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(196, 5, utf8_decode($trat),1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(110, 5, utf8_decode('Estado del paciente al momento del alta: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(196, 5, utf8_decode($edo),1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Multicell(110, 5, utf8_decode('Problemas clínicos pendientes:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(196, 5, utf8_decode($probclip),1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(42, 5, utf8_decode('Pronóstico: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(196, 5, utf8_decode($px),1, 'J');

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(110, 5, utf8_decode('Plan de manejo y tratamiento: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(196, 5, utf8_decode($exes),1, 'J');

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(110, 5, utf8_decode('Recomendaciones para vigilancia ambulatoria: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(196, 5, utf8_decode($cuid),1, 'J');
$pdf->Ln(1);

if ($pcita <> 0000-00-00) 
{
  $pcita=date_create($pcita);
  $pcita = date_format($pcita,"d/m/Y");
}
else { 
  $pcita = "Cita abierta";
  $hcita = " ";
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode('Fecha próxima cita: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(166, 5, utf8_decode($pcita. ' ' . $hcita),1, 'L');

if ($cond == "VOLUNTARIA") {
  $pdf->Ln(2);
  $pdf->SetFont('Arial', 'B', 6);
  $pdf->Cell(99, 6, utf8_decode('Nota de alta voluntara del familiar: '), 0, 'L');
  $pdf->Ln(5);
  $pdf->MultiCell(195, 16, ' ',1, 'L');
  $pdf->Ln(1);
}

if(@$_GET['id_egreso'] != NULL){
  $sql_med_id = "SELECT id_usua FROM dat_egreso WHERE id_egreso = $id_in and id_atencion=$id_atencion";
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
}else{
  $sql_med_id = "SELECT id_usua FROM dat_egreso WHERE id_egreso = $id_in and id_atencion=$id_atencion";
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
}

$pdf->SetY(-65);
$pdf->SetFont('Arial', 'B', 7);
      //$pdf->Image('../../imgfirma/' . $firma, 95, 245, 30);
     if ($firma==null) {
$pdf->Image('../../imgfirma/FIRMA.jpg', 95, 257 , 22);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 95, 257 , 22);
}
      $pdf->SetY(267);
      $pdf->Cell(195, 1, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(195, 1, utf8_decode($cargp . ' ' . 'Céd. prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(195, 1, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');

/*********** AQUI INICIA LA HOJA DE EGRESO PARA EL PACIENTE    ***************/
  $pdf->AddPage();


$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(64);
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Cell(100, 5, utf8_decode('HOJA DE EGRESO PARA EL PACIENTE'),1, 0, 'C');

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.folio,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p where p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  $Id_exp = $row_pac['Id_exp'];
  $folio = $row_pac['folio'];
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


$sql_preop = "SELECT * FROM dat_ingreso where id_atencion = $id_atencion";
$result_preop = $conexion->query($sql_preop);

while ($row_preop = $result_preop->fetch_assoc()) {
 
    $tipo_a = $row_preop['tipo_a'];
    $fecha_ing = $row_preop['fecha'];
}

$sql_ing = "SELECT * FROM dat_not_ingreso where id_atencion = $id_atencion";
$result_ing = $conexion->query($sql_ing);

while ($row_ing = $result_ing->fetch_assoc()) {
 $fecha_dat_ingreso=$row_ing['fecha_dat_ingreso'];
 $fecha_actual=$row_ing['fecha_dat_ingreso'];
 $mot_ingreso=$row_ing['mot_ingreso'];
 $resinterr_i=$row_ing['resinterr_i'];
 $expfis_i=$row_ing['expfis_i'];
 $resaux_i=$row_ing['resaux_i'];
 $diagprob_i=$row_ing['diagprob_i'];
 $plan_i=$row_ing['plan_i'];
 $des_diag=$row_ing['des_diag'];
 $pron_i=$row_ing['pron_i'];
  $guia=$row_ing['guia'];

}
/*
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 47, 172, 47);
$pdf->Line(48, 41, 48, 47);
$pdf->Line(172, 41, 172, 47);
$pdf->Line(48, 41, 172, 41);
*/
$pdf->SetX(170);

$pdf->SetFont('Arial', '', 6);

$date1=date_create($fech_egreso);
$pdf->Cell(35, -2, 'FECHA: ' . date_format($date1,"d/m/Y H:i a"), 0, 1, 'R');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 46, 207, 46);
$pdf->Line(8, 46, 8, 280);
$pdf->Line(207, 46, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(8);

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
$fechanac=date_create($fecnac);
$pdf->Cell(31, 4, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 4, date_format($fechanac,"d/m/Y"), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 4, ' Edad: ', 0, 'L');

$pdf->SetFont('Arial', '', 8);
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
$pdf->Ln(4);
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
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(14, 4,  utf8_decode($pesoh.' Kilos'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 4, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 4,  utf8_decode($tallah.' Metros'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 4, utf8_decode(' Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(126, 4, utf8_decode($dir), 'B', 'L');

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
  $pdf->Cell(20, 4, utf8_decode('Diagnóstico:') , 0, 'C');
  $pdf->SetFont('Arial', '', 9);
     $pdf->Cell(176, 4, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 4, utf8_decode('Motivo del ingreso:') , 0, 'C');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(167, 4, utf8_decode($m) , 'B', 'C');
    }

$sql_sig ="select * from signos_vitales WHERE id_atencion=$id_atencion ORDER by id_sig DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_sig = $result_sig->fetch_assoc()) {
 $p_sistolica=$row_sig['p_sistol'];
 $p_diastolica=$row_sig['p_diastol'];
 $f_card=$row_sig['fcard'];
 $f_resp=$row_sig['fresp'];
 $temp=$row_sig['temper'];
 $sat_oxigeno=$row_sig['satoxi'];
 $niv_dolor=$row_sig['niv_dolor'];
}

$pdf->Ln(6);

$fecha_egreso=date_create($fech_egreso);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31, 4, utf8_decode('Fecha de egreso: '),1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(24, 4, utf8_decode(date_format($fecha_egreso,"d/m/Y")),1, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(23, 4, utf8_decode('Dias estancia: '),1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8, 4, utf8_decode($dias),1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(28, 4, utf8_decode('Motivo del egreso: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(82, 4, utf8_decode($cond) , 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(200, 3, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell(39, 3, utf8_decode('Presión Arterial: ' .$p_sistolica.'/'.$p_diastolica).' mmHG', 1, 'L');
$pdf->Cell(44, 3, utf8_decode('Frecuencia Cardiaca: ' .$f_card.' Latidos/min'), 1, 'L');
$pdf->Cell(54, 3, utf8_decode('Frecuencia Respiratoria: ' .$f_resp.' Respiraciones/min'), 1, 'L');
$pdf->Cell(26, 3, utf8_decode('Temperatura: ' .$temp.' °C'), 1, 'L');
$pdf->Cell(33, 3, utf8_decode('Saturación de Oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(47, 5, utf8_decode('Resumen de la evolución: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode($res_clin),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(35, 5, utf8_decode('Diagnóstico de Egreso: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(160, 5, utf8_decode($diag_eg),1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(35, 5, utf8_decode('Diagnóstico(s) Final(es): '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(160, 5, utf8_decode($diagfinal),1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(110, 5, utf8_decode('Medicamentos relevantes administrados durante el proceso de atención: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode($manejodur),1, 'J');
$pdf->Ln(1);
/*$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(148,5, utf8_decode('Medicamento'),1,0,'C');
$pdf->Cell(20,5, utf8_decode('Dósis'),1,0,'C');
$pdf->MultiCell(27,5, utf8_decode('Vía'),1,'C');

$medica = $conexion->query("select * from medica_enf WHERE id_atencion=$id_atencion and neonato!='Si' and material!='Si' group by medicam_mat ORDER BY id_med_reg DESC") or die($conexion->error);
while ($row_m = $medica->fetch_assoc()) {

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(148,5, utf8_decode($row_m['medicam_mat']),1,0,'L');
$pdf->Cell(20,5, $row_m['dosis_mat'],1,0,'C');
$pdf->MultiCell(27,5, $row_m['via_mat'],1,'C');
}
*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(110, 5, utf8_decode('Medicamentos prescritos al egreso (Receta médica): '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode($trat),1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(110, 5, utf8_decode('Estado del paciente al momento del alta: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode($edo),1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Multicell(110, 5, utf8_decode('Problemas clínicos pendientes:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode($probclip),1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(42, 5, utf8_decode('Pronóstico: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode($px),1, 'J');

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(110, 5, utf8_decode('Plan de manejo y tratamiento: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode($exes),1, 'J');

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(110, 5, utf8_decode('Recomendaciones para vigilancia ambulatoria: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode($cuid),1, 'J');
$pdf->Ln(1);

if ($pcita <> 0000-00-00) 
{
  $pcita=date_create($pcita);
  $pcita = date_format($pcita,"d/m/Y");
}
else { 
  $pcita = "Cita abierta  ";
  $hcita = " ";
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode('Fecha próxima cita: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(165, 5, utf8_decode($pcita. ' ' . $hcita),1, 'L');

$pdf->Ln(20);

if(@$_GET['id_egreso'] != NULL){
  $sql_med_id = "SELECT id_usua FROM dat_egreso WHERE id_egreso = $id_in and id_atencion=$id_atencion";
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
}else{
  $sql_med_id = "SELECT id_usua FROM dat_egreso WHERE id_egreso = $id_in and id_atencion=$id_atencion";
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
}
       
  
$pdf->SetY(-65);
$pdf->SetFont('Arial', 'B', 7);
      //$pdf->Image('../../imgfirma/' . $firma, 95, 245, 30);
     if ($firma==null) {
$pdf->Image('../../imgfirma/FIRMA.jpg', 95, 256 , 22);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 95, 256 , 22);
}
      $pdf->SetY(267);
      $pdf->Cell(195, 1, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(195, 1, utf8_decode($cargp . ' ' . 'Céd. prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->Cell(195, 1, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');

  $pdf->SetX(145);
  $pdf->Cell(60, 1, utf8_decode('Copia para el paciente '), 0, 1, 'R');
      
$pdf->Ln(20);
  

/************* INICIA IMPRESION DE RECETA *******************/

$pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,32);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(60);
$pdf->SetTextColor(43, 45, 127);
$pdf->Cell(100, 5, utf8_decode('RECETA MÉDICA'), 1,0,'C');

$pdf->SetDrawColor(43, 45, 127);
/*$pdf->Line(48, 50, 172, 50);
$pdf->Line(48, 41, 48, 50);
$pdf->Line(172, 41, 172, 50);
$pdf->Line(48, 41, 172, 41);
*/
$pdf->SetX(170);

$sql_pac = "SELECT p.papell, p.nom_pac,p.sapell,p.edad,p.sexo,p.Id_exp,p.folio,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp, p.fecnac FROM paciente p where p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  $Id_exp = $row_pac['Id_exp'];
  $folio = $row_pac['folio'];
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


$sql_preop = "SELECT * FROM dat_ingreso where id_atencion = $id_atencion";
$result_preop = $conexion->query($sql_preop);

while ($row_preop = $result_preop->fetch_assoc()) {
 
    $tipo_a = $row_preop['tipo_a'];
    $fecha_ing = $row_preop['fecha'];
}


$sql_ing = "SELECT * FROM dat_not_ingreso where id_atencion = $id_atencion";
$result_ing = $conexion->query($sql_ing);

while ($row_ing = $result_ing->fetch_assoc()) {
 $fecha_dat_ingreso=$row_ing['fecha_dat_ingreso'];
 $fecha_actual=$row_ing['fecha_dat_ingreso'];
 $mot_ingreso=$row_ing['mot_ingreso'];
 $resinterr_i=$row_ing['resinterr_i'];
 $expfis_i=$row_ing['expfis_i'];
 $resaux_i=$row_ing['resaux_i'];
 $diagprob_i=$row_ing['diagprob_i'];
 $plan_i=$row_ing['plan_i'];
 $des_diag=$row_ing['des_diag'];
 $pron_i=$row_ing['pron_i'];
 $guia=$row_ing['guia'];
}
/*
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 46, 172, 46);
$pdf->Line(48, 41, 48, 46);
$pdf->Line(172, 41, 172, 46);
$pdf->Line(48, 41, 172, 41);
*/
$pdf->SetX(170);

$pdf->SetFont('Arial', '', 6);

$date1=date_create($fech_egreso);
$pdf->Cell(35, -2, 'FECHA: ' . date_format($date1,"d/m/Y H:i a"), 0, 1, 'R');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 46, 207, 46);
$pdf->Line(8, 46, 8, 280);
$pdf->Line(207, 46, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(9);
/*
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 50, 207, 50);
$pdf->Line(8, 50, 8, 280);
$pdf->Line(207, 50, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(6);
*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 3, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 3, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 3, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 3, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 3, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 3, utf8_decode($folio), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 3, ' Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(146, 3, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$fechanac=date_create($fecnac);
$pdf->Cell(31, 3, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 3, date_format($fechanac,"d/m/Y"), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 3, ' Edad: ', 0, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(13, 3, utf8_decode($edad),'B', 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(19, 3, utf8_decode(' Ocupación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(36, 3,  utf8_decode($ocup), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 3, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 3,  utf8_decode($tel), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 3, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 3,  $sexo, 'B', 'L');
$pdf->Ln(3);

$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$Id_exp ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_hc = $result_sig->fetch_assoc()) {
$pesoh=$row_hc['peso'];
$tallah=$row_hc['talla'];
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 3, utf8_decode('Peso: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 3,  utf8_decode($pesoh.' Kilos'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 3, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 3,  utf8_decode($tallah.' Metros'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 3, utf8_decode(' Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(125, 3, utf8_decode($dir), 'B', 'L');

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
  $pdf->Cell(20, 3, utf8_decode('Diagnóstico:') , 0, 'C');
  $pdf->SetFont('Arial', '', 9);
     $pdf->Cell(175, 3, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 3, utf8_decode('Motivo de atención:') , 0, 'C');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(166, 3, utf8_decode($m) , 'B', 'C');
    }


$sql_sig ="select * from signos_vitales WHERE id_atencion=$id_atencion ORDER by id_sig DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_sig = $result_sig->fetch_assoc()) {
 $p_sistolica=$row_sig['p_sistol'];
 $p_diastolica=$row_sig['p_diastol'];
 $f_card=$row_sig['fcard'];
 $f_resp=$row_sig['fresp'];
 $temp=$row_sig['temper'];
 $sat_oxigeno=$row_sig['satoxi'];
 $peso=$row_sig['peso'];
 $talla=$row_sig['talla'];
 $niv_dolor=$row_sig['niv_dolor'];
}

$pdf->Ln(4);

$fecha_egreso=date_create($fech_egreso);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Fecha de egreso: '),1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 3, utf8_decode(date_format($fecha_egreso,"d/m/Y")),1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22, 3, utf8_decode('Dias estancia: '),1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(6, 3, utf8_decode($dias),1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 3, utf8_decode('Motivo del egreso: '), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(90, 3, utf8_decode($cond) , 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(200, 3, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell(39, 3, utf8_decode('Presión Arterial: ' .$p_sistolica.'/'.$p_diastolica).' mmHG', 1, 'L');
$pdf->Cell(44, 3, utf8_decode('Frecuencia Cardiaca: ' .$f_card.' Latidos/min'), 1, 'L');
$pdf->Cell(54, 3, utf8_decode('Frecuencia Respiratoria: ' .$f_resp.' Respiraciones/min'), 1, 'L');
$pdf->Cell(26, 3, utf8_decode('Temperatura: ' .$temp.' °C'), 1, 'L');
$pdf->Cell(33, 3, utf8_decode('Saturación de Oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');
$pdf->Ln(4);


$pdf->Line(10, 88, 204, 88);
$pdf->Line(10, 88, 10, 237);
$pdf->Line(204, 88, 204, 237);
$pdf->Line(10, 237, 204, 237);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Ln(1);
$pdf->SetX(10.5);
$pdf->MultiCell(110, 5, utf8_decode('Medicamentos prescritos al egreso (Receta médica): '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->SetX(10.5);
$pdf->MultiCell(190, 5, utf8_decode($trat),0, 'L');
$pdf->Ln(1);


$pdf->SetY(239);
$pdf->SetX(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(34, 4, utf8_decode('Fecha próxima cita: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(160, 4, utf8_decode($pcita. ' ' . $hcita),1, 'L');
      
 $pdf->Ln(20);
     
     
$pdf->SetY(-60);
$pdf->SetFont('Arial', 'B', 7);
      //$pdf->Image('../../imgfirma/' . $firma, 95, 245, 30);
     if ($firma==null) {
$pdf->Image('../../imgfirma/FIRMA.jpg', 95, 247 , 22);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 95, 247 , 22);
}
      $pdf->SetY(258);
      $pdf->Cell(195, 1, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(195, 1, utf8_decode($cargp . ' ' . 'Céd. prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->Cell(195, 1, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');

 
 $pdf->Output();
  }