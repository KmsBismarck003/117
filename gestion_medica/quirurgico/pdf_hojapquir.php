<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id'];
$id_hpq = @$_GET['id_hpq'];
$id_exp = @$_GET['id_exp'];
$id_med = @$_GET['id_med'];
$sql_preop = "SELECT * FROM hprog_quir where id_atencion = $id_atencion AND id_hpq=$id_hpq";
$result_preop = $conexion->query($sql_preop);

while ($row_preop = $result_preop->fetch_assoc()) {
  $id_hpq = $row_preop['id_hpq']; 
}
if(isset($id_hpq)){
    $id_hpq = $id_hpq;
  }else{
    $id_hpq ='sin doc';
  }

if($id_hpq=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE HOJA DE PROGRAMACIÓN QUIRÚRGICA PARA ESTE PACIENTE", 
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

    $id = @$_GET['id'];;
include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 8, 8, 55, 30);
   // $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    //$this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
    
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 65, 10, 50, 23);
}
   $this->Ln(29);

  }
   function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('MAC-6.05'), 0, 1, 'R');
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
$pdf->SetAutoPageBreak(true,15);
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

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX(17);
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Cell(90, 7, utf8_decode('HOJA DE PROGRAMACIÓN QUIRÚRGICA'), 1,0, 'C');

$pdf->SetY(48);
$pdf->SetX(8);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(14.5, 5, 'SERVICIO: ', 0, 'L');  
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(93.5, 4, utf8_decode($tipo_a) , 'B', 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 7);
$date=date_create($fecha_ing);
$pdf->Cell(27, 5, utf8_decode('FECHA DE INGRESO:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 4, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(18, 5, utf8_decode('EXPEDIENTE: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23, 4, utf8_decode($folio), 'B', 0, 'C');
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
    $pdf->SetFont('Arial', 'B', 7);
  $pdf->Cell(20, 5, utf8_decode('DIAGNÓSTICO:') , 0, 'C');
  $pdf->SetFont('Arial', '', 6);
     $pdf->Cell(81, 4, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',7);
         $pdf->Cell(26, 5, utf8_decode('MOTIVO ATENCIÓN:') , 0, 'C');
         $pdf->SetFont('Arial', '', 6);
         $pdf->Cell(82, 4, utf8_decode($m) , 'B', 'C');
    }


$sql_preop = "SELECT * FROM hprog_quir where id_hpq =$id_hpq";
$result_preop = $conexion->query($sql_preop);

while ($row_preop = $result_preop->fetch_assoc()) {
  $fecha_registro = $row_preop['fecha_registro'];
  $tipo_cir=$row_preop['tipo_cir'];
  $fecha_sol= $row_preop['fecha_sol'];
  $hora_sol= $row_preop['hora_sol'];
  $hb= $row_preop['hb'];
  $ht= $row_preop['ht'];
  $persona= $row_preop['persona'];
  $tiempo_estimado= $row_preop['tiempo_estimado'];
  $matye= $row_preop['matye'];
  $ope_proyectada= $row_preop['ope_proyectada'];
  $est_transo= $row_preop['est_transo'];
  $diag_preop= $row_preop['diag_preop'];
  $d_posto= $row_preop['d_posto'];
  $ope_realizada= $row_preop['ope_realizada'];
  $cirujano= $row_preop['cirujano'];
  $anest= $row_preop['anest'];
  $tipo_ane= $row_preop['tipo_ane'];
  $tip_sangre=$row_preop['tip_sangre'];
  

}


$pdf->SetY(8);
$pdf->SetX(117);
$pdf->Cell(90, 67, utf8_decode(''),1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->SetY(10);
$pdf->SetX(118);
$pdf->Cell(90, 6, utf8_decode('DATOS DEL PACIENTE'),0, 1, 'C');

$pdf->SetY(19);
$pdf->SetX(117);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(14, 5, ' NOMBRE: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(73.5, 4, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');


$pdf->SetY(26);
$pdf->SetX(117.7);
$pdf->SetFont('Arial', 'B', 7);
$date1=date_create($fecnac);
$pdf->Cell(31, 5, 'FECHA DE NACIMIENTO: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(55.5, 4, date_format($date1,"d/m/Y"), 'B', 'L');


$pdf->SetY(33);
$pdf->SetX(117);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(11, 5, ' EDAD: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 4, utf8_decode($edad),'B', 'C');

$pdf->SetY(33);
$pdf->SetX(150);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, utf8_decode('GÉNERO: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(39, 4,  $sexo, 'B', 'L');

$pdf->SetY(40);
$pdf->SetX(117.7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, utf8_decode('CIRUJANO: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(68.4, 4,  utf8_decode($cirujano), 'B', 'L');


$pdf->SetY(47);
$pdf->SetX(117.7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 5, utf8_decode('ANESTESIÓLOGO: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 4,  utf8_decode($anest), 'B', 'L');


$pdf->SetY(55);
$pdf->SetX(145);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 5, utf8_decode('FIRMA AUTORIZACIÓN: '), 0, 'L');

$pdf->SetY(59);
$pdf->SetX(118);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 5, utf8_decode('PACIENTE: '), 0, 'L');
$pdf->Cell(69.8, 4,  (''), 'B', 'L');

$pdf->SetY(62);
$pdf->SetX(124);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 5, utf8_decode('O'), 0, 'L');

$pdf->SetY(65);
$pdf->SetX(118);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(38, 5, utf8_decode('FAMILIAR RESPONSABLE: '), 0, 'L');
$pdf->Cell(49, 4,  (''), 'B', 'L');

$pdf->SetY(75);
$pdf->SetX(170);

$pdf->SetFont('Arial', '', 6);
$date1=date_create($fecha_actual);
$pdf->Cell(35, -2, 'FECHA: ' . date_format($date1,"d/m/Y H:i"), 0, 1, 'R');

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 8, 207, 8);
$pdf->Line(8, 8, 8, 280);
$pdf->Line(207, 8, 207, 280);
$pdf->Line(8, 280, 207, 280);
$pdf->Ln(-8);



if($tipo_cir=="Urgencia"){
    $pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(16, 4, utf8_decode('URGENCIA:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 4, utf8_decode(' X '), 'B',0,'C');


$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(21, 4, utf8_decode('PROGRAMADA:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35.5, 4, utf8_decode(' '), 'B',0,'C');
} else if($tipo_cir=="Programada"){
    $pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(16, 4, utf8_decode('URGENCIA:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 4, utf8_decode(' '), 'B',0,'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(21, 4, utf8_decode('PROGRAMADA:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35.5, 4, utf8_decode(' X '), 'B',0,'C');
}

$pdf->Ln(6);
$date_sl=date_create($fecha_sol);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(27, 4, utf8_decode('FECHA SOLICITADA:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80.5, 4, date_format($date_sl,"d/m/Y"), 'B',0,'C');

$pdf->Ln(6);
$hora_sol=date_create($hora_sol);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(27, 4, utf8_decode('HORA SOLICITADA:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80.5, 4, date_format($hora_sol,"H:i  a"), 'B',0,'C');

$pdf->Cell(3, 4, utf8_decode(''), 0, 'L');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(6, 4, utf8_decode('HB:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 4, utf8_decode($hb), 'B',0,'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(6, 4, utf8_decode('HT:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 4, utf8_decode($ht), 'B',0,'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(17, 4, utf8_decode('GPO. Y R.H.:'), 0, 'L');
$pdf->SetFont('Arial', '', 7);

if($tip_sangre==null){
    $pdf->Cell(28.5, 4, utf8_decode("No especificado"), 'B',0,'C');
}else{
    $pdf->Cell(28.5, 4, utf8_decode($tip_sangre), 'B',0,'C');
}



$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(60, 4, utf8_decode('PERSONA RESPONSABLE DE PROGRAMACIÓN:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(138, 4, utf8_decode($persona), 'B',0,'L');


$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(42, 4, utf8_decode('TIEMPO QUIRÚRGICO ESTIMADO:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(156, 4, utf8_decode($tiempo_estimado), 'B',0,'L');


$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(44, 4, utf8_decode('MATERIAL Y EQUIPO REQUERIDO:'), 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(154, 4, utf8_decode($matye), 'B',0,'L');


$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(36, 4, utf8_decode('OPERACIÓN PROYECTADA:'), 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(162, 4, utf8_decode($ope_proyectada), 'B',0,'L');

$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(43, 4, utf8_decode('ESTUDIOS TRANSOPERATORIOS:'), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(155, 4, utf8_decode($est_transo), 'B',0,'L');


$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(43, 4, utf8_decode('DIAGNÓSTICO PREOPERATORIO:'), 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(155, 4, utf8_decode($diag_preop), 'B',0,'L');

$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(44, 4, utf8_decode('DIAGNÓSTICO POSTOPERATORIO:'), 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(154, 4, utf8_decode($d_posto), 'B',0,'L');

$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(33, 4, utf8_decode('OPERACION REALIZADA:'), 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(165, 4, utf8_decode($ope_realizada), 'B',0,'L');




// FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS // FIRMAS
// FIRMAS


$sql_med_id = "SELECT id_usua FROM hprog_quir WHERE id_hpq  = $id_hpq  ";

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
      $pdf->SetY(190);
      $pdf->SetX(10);
      $pdf->SetFont('Arial', 'B', 7);
      //$pdf->Cell(190, 3, utf8_decode('Marcaje quirúrgico'), 0,0, 'C');

      //$pdf->Image('../../img/marcaje_qx.jpg', 70, 193, 73);

      $pdf->SetFont('Arial', 'B', 7);
      //$pdf->Image('../../imgfirma/' . $firma, 94, 245, 25);
      
     if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 34, 247 , 25);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 34, 247 , 25);
}

      $pdf->SetY(266);
      $pdf->Cell(80, 3, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
       
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(80, 3, utf8_decode($cargp . ' ' . 'Céd. prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->Cell(80, 3, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');
      
        $pdf->SetY(255);
       $pdf->SetX(115);
       $pdf->Cell(80, 3, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'C');
       $pdf->Ln(10);
    $pdf->SetX(115);
        $pdf->Cell(80, 3, utf8_decode(''), 'B', 0, 'C');
    $pdf->Ln(5);
    $pdf->SetX(115);
    $pdf->Cell(80, 3, utf8_decode('Paciente o familiar que autoriza'), 0, 0, 'C');
      
 $pdf->Output();
}