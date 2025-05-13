<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_partograma = @$_GET['id_partograma'];
$id_med = @$_GET['id_med'];
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

   $this->Ln(31.5);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-5.06'), 0, 1, 'R');
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
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,32);
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

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('NOTA DE PARTOGRAMA'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetX(170);

$pdf->SetFont('Arial', '', 6);

$date1=date_create($fecha_actual);
$pdf->Cell(35, -2, 'Fecha: ' . date_format($date1,"d/m/Y H:i"), 0, 1, 'R');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 207, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(207, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(6);

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



$pdf->SetTextColor(43, 45, 127);



$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);



  $pdf->SetFont('Arial', '', 8);


$pdf->Ln(5);
  $sql_partograma = "SELECT * FROM partograma WHERE id_partograma=$id_partograma and id_atencion= $id_atencion";
  $result__p = $conexion->query($sql_partograma);

  while ($row_p = $result__p->fetch_assoc()) {
    $fecha = $row_p['fecha'];
    $gestas = $row_p['gestas'];
    $f_ucesarea = $row_p['f_ucesarea'];
    $cesareas = $row_p['cesareas'];
    $partos = $row_p['partos'];
    $abortos = $row_p['abortos'];
    $no_hijos = $row_p['no_hijos'];
    $abortos = $row_p['abortos'];
    $malformaciones = $row_p['malformaciones'];
    $fur = $row_p['fur'];
    $fpp = $row_p['fpp'];
    $malformaciones = $row_p['malformaciones'];
    $sem_gestacion = $row_p['sem_gestacion'];
    $no_consultas = $row_p['no_consultas'];
    $c_perinatal = $row_p['c_perinatal'];
    $unidad = $row_p['unidad'];
    $lab_prev_rec = $row_p['lab_prev_rec'];
    $comp_emb_act = $row_p['comp_emb_act'];
    $tratamiento = $row_p['tratamiento'];
    $c_uterina = $row_p['c_uterina'];
    $sang_tv = $row_p['sang_tv'];
    $fecha_inicio = $row_p['inicio_fecha'];
    $hora_inicio = $row_p['inicio_hora'];
    $rpm = $row_p['rpm'];
    $fecha_rpm = $row_p['fecha_rpm'];
    $hora_rpm = $row_p['hora_rpm'];
    $no_consul_urg = $row_p['no_consul_urg'];
    $mot_fetal = $row_p['mot_fetal'];
    $dism = $row_p['dism'];
    $nl = $row_p['nl'];
    $p_sistolica = $row_p['p_sistolica'];
    $p_diastolica = $row_p['p_diastolica'];
    $temp = $row_p['temp'];
    $fc = $row_p['fc'];
    $fr = $row_p['fr'];
    $edema = $row_p['edema'];
    $alt_utero = $row_p['alt_utero'];
    $fcf = $row_p['fcf'];
    $ritmo = $row_p['ritmo'];
    $t_uterino = $row_p['t_uterino'];
    $memb_int = $row_p['memb_int'];
    $rotas = $row_p['rotas'];
    $asp_la = $row_p['asp_la'];
    $cervix = $row_p['cervix'];
    $dilatacion = $row_p['dilatacion'];
    $presentacion = $row_p['presentacion'];
    $util = $row_p['util'];
    $n_util = $row_p['n_util'];
    $pelvis = $row_p['pelvis'];
    $imp_diag = $row_p['imp_diag'];
    $p_trat = $row_p['p_trat'];
  }
  $fecreg = date_create($fecha);
  $fecur = date_create($fur);
  $fecpp = date_create($fpp);
  $fec_ucesarea = date_create($f_ucesarea);
  $fec_inicio =  date_create($fecha_inicio);
  $fec_rpm =  date_create($fecha_rpm);
  
  $pdf->Ln(4);
  $pdf->Cell(25, 5, utf8_decode('Gestas: ' . $gestas), 1, 0, 'L');
  $pdf->Cell(25, 5, utf8_decode('Partos: ' . $partos), 1, 0, 'L');
  $pdf->Cell(25, 5, utf8_decode('Cesáreas: ' . $cesareas), 1, 0, 'L');
  $pdf->Cell(25, 5, utf8_decode('Abortos: ' . $abortos), 1, 0, 'L');
 
 
  $pdf->Cell(40, 5, utf8_decode('No. de hijos vivos: ' . $no_hijos), 1, 0, 'L');
  $pdf->Cell(55, 5, utf8_decode('Malformaciones: ' . $malformaciones), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(90, 5, utf8_decode('Fecha último parto cesárea: ' . date_format($fec_ucesarea, "d/m/Y")), 1, 0, 'L');
  $pdf->Cell(50, 5, utf8_decode('Fec. última regla: ' . date_format($fecur, "d/m/Y")), 1, 0, 'L');
  $pdf->Cell(55, 5, utf8_decode('Fecha probable de parto: ' . date_format($fecpp, "d/m/Y")), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(90, 5, utf8_decode('Embarazo acutal - semanas gestación: ' . $sem_gestacion), 1, 0, 'L');
  
  $pdf->Cell(50, 5, utf8_decode('No. de consultas: ' . $no_consultas), 1, 0, 'L');

  $pdf->Cell(55, 5, utf8_decode('Control perinatal: ' . $c_perinatal), 1, 0, 'L');
   $pdf->Ln(5);
  $pdf->Cell(90, 5, utf8_decode('Unidad: ' . $unidad), 1, 0, 'L');
  $pdf->Cell(105, 5, utf8_decode('Lav. prev. rec. : ' . $lab_prev_rec), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->MultiCell(195, 5, utf8_decode('Complicaciones del embarazo actual: ' . $comp_emb_act), 1, 'L');
  $pdf->MultiCell(195, 5, utf8_decode('Tratamiento: ' . $tratamiento), 1, 'L');
  $pdf->Cell(140, 5, utf8_decode('Contractilidad uterina : ' . $c_uterina), 1, 0, 'L');
  $pdf->Cell(55, 5, utf8_decode('Inicia en 10 min.'), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(100, 5, utf8_decode('Sangrado tv : ' . $sang_tv), 1, 0, 'L');
  $pdf->Cell(95, 5, utf8_decode('Inicio fecha: ' . date_format($fec_inicio,"d/m/Y") . ' HORA:  ' . $hora_inicio), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(100, 5, utf8_decode('Rompimiento prematuro de membranas: ' . $rpm), 1, 0, 'L');
  $pdf->Cell(95, 5, utf8_decode('Fecha: ' . date_format($fec_rpm,"d/m/Y") . ' HORA ' . $hora_rpm), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(60, 5, utf8_decode('No. Consultas de urgencias: ' . $no_consul_urg), 1, 0, 'L');
  $pdf->Cell(40, 5, utf8_decode('Motilidad fetal: ' . $mot_fetal), 1, 0, 'L');
  $pdf->Cell(50, 5, utf8_decode('Dism: ' . $dism), 1, 0, 'L');
  $pdf->Cell(45, 5, utf8_decode('Nl: ' . $nl), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(60, 5, utf8_decode('Ta: ' . $p_sistolica . '/' . $p_diastolica), 1, 0, 'L');
  $pdf->Cell(40, 5, utf8_decode('Temperatura: ' . $temp), 1, 0, 'L');
  $pdf->Cell(25, 5, utf8_decode('Fc.: ' . $fc), 1, 0, 'L');
  $pdf->Cell(25, 5, utf8_decode('Fr: ' . $fr), 1, 0, 'L');
  $pdf->Cell(45, 5, utf8_decode('Edema: ' . $edema), 1, 0, 'L');
  $pdf->Ln(10);
  $pdf->Image('../../img/altura_utero.jpeg', 10, $pdf->GetY(), 60, 40);
  $pdf->Image('../../img/dilatacion_pocision.jpeg', 75, $pdf->GetY(), 60, 40);
  $pdf->Image('../../img/altura_presentacion.jpg', 140, $pdf->GetY(), 60, 40);
  $pdf->Ln(40);
  $pdf->SetFont('Arial', 'B', 8);
  $pdf->Cell(65, 5, utf8_decode('Altura útero : ' . $alt_utero), 1, 0, 'C');
  $pdf->Cell(65, 5, utf8_decode('Dilatración y posición'), 1, 0, 'C');
  $pdf->Cell(65, 5, utf8_decode('Altura de la presentación'), 1, 0, 'C');
  $pdf->Ln(5);
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(65, 5, utf8_decode('F.c.f.: ' . $fcf), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('Ritmo: ' . $ritmo), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('Tono utero: ' . $t_uterino), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(65, 5, utf8_decode('Membranas intergas: ' . $memb_int), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('Rotas: ' . $rotas), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('Aspecto del liquido amniotico: ' . $asp_la), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(65, 5, utf8_decode('Cervix:borramiento ' . $cervix), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('Dilatación: ' . $dilatacion), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('Presentación: ' . $presentacion), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(65, 5, utf8_decode('Pelvis: ' . $pelvis), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('Útil: ' . $util), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('No útil: ' . $n_util), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->MultiCell(195, 5, utf8_decode('Impresión diagnóstica: ' . $imp_diag), 1, 'L');
  $pdf->MultiCell(195, 5, utf8_decode('Plan de tratamiento: ' . $p_trat), 1, 'L');
  $pdf->Ln(5);
   $sql_med = "SELECT * FROM reg_usuarios u, partograma p WHERE u.id_usua = p.id_usua and p.id_atencion= $id_atencion";
  $result_med = $conexion->query($sql_med);

  while ($row_med = $result_med->fetch_assoc()) {
    $nom = $row_med['nombre'];
    $app = $row_med['papell'];
    $apm = $row_med['sapell'];
    $pre = $row_med['pre'];
    $firma = $row_med['firma'];
    $cargp = $row_med['cargp'];
    $ced_p = $row_med['cedp'];
  }
 $pdf->Ln(20);
     
      $pdf->SetFont('Arial', 'B', 7);
      //$pdf->Image('../../imgfirma/' . $firma, 95, 245, 25);
  if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 240 , 30);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 240 , 30);
}
      $pdf->sety(256);
      $pdf->Cell(200, 3, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(200, 3, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->Cell(200, 3, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');



 $pdf->Output();