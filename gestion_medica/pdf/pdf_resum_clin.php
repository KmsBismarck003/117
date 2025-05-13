  <?php
  require '../../fpdf/fpdf.php';
  include '../../conexionbd.php';
$id_in = @$_GET['id_in'];
  $id_med = @$_GET['id_med'];
  $id_exp = @$_GET['id_exp'];
  $id_atencion = @$_GET['id_atencion'];
  $sql_dat_eg = "SELECT * from resumen_clinico where id_atencion = $id_atencion";
  $result_dat_eg = $conexion->query($sql_dat_eg);
  

  while ($row_dat_eg = $result_dat_eg->fetch_assoc()) {
    $id_resum = $row_dat_eg['id_resum'];
  }
  if(isset($id_resum)){
      $id_resum = $id_resum;
    }else{
      $id_resum ='sin doc';
    }

  if($id_resum=="sin doc"){
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
      echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
      echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
      echo '<script>
                      $(document).ready(function() {
                          swal({
                              title: "NO EXISTE RESUMEN CLÍNICO PARA ESTE PACIENTE", 
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
    $this->Cell(0, 10, utf8_decode('MAC-5.10'), 0, 1, 'R');
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
    $folio = $row_pac['folio'];
  }


  $sql_dat_eg = "SELECT * from diag_pac where id_exp = $id_atencion order by id_diag DESC limit 1";
  $result_dat_eg = $conexion->query($sql_dat_eg);

  while ($row_dat_eg = $result_dat_eg->fetch_assoc()) {

    $diagfinal=$row_dat_eg['diag_paciente'];
  }

 $sql_dat_eg = "SELECT * from resumen_clinico where id_resum=$id_in and id_atencion = $id_atencion";
  $result = $conexion->query($sql_dat_eg);

  while ($row_def = $result->fetch_assoc()) {
    $resum_clinico=$row_def['resum_clinico'];
    $fecha_resum=$row_def['fecha'];
  }





  $sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
  $result_dat_ing = $conexion->query($sql_dat_ing);

  while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
    $motivo_atn = $row_dat_ing['motivo_atn'];
    $especialidad = $row_dat_ing['especialidad'];
    $id_usua = $row_dat_ing['id_usua'];
    $fecha_ing=$row_dat_ing['fecha'];
    $tipo_a=$row_dat_ing['tipo_a'];
    $fech_egreso = $row_dat_ing['fec_egreso'];
  }
  $pdf = new PDF('P');
  $pdf->AliasNbPages();
  $pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,15);


$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('RESUMEN CLÍNICO'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetX(170);
$pdf->SetFont('Arial', '', 6);
$fecha_actual = date_create($fecha_resum);
$pdf->Cell(35, -2, 'Fecha: ' . utf8_decode(date_format($fecha_actual,'d-m-Y H:i')), 0, 1, 'R');
$pdf->Ln(6);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 207, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(207, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);

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
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$Id_exp ORDER by id_hc DESC LIMIT 1";
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
$pdf->Cell(18, 5,  utf8_decode($tallah.' metros'), 'B', 'L');

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
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$fecha=date_create($fecha_ing);
$pdf->Cell(70, 4, utf8_decode('Fecha de ingreso: '),1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 4, utf8_decode(date_format($fecha,'d-m-Y H:i:s')),1, 'L');
if($fech_egreso == null){
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(70, 4, utf8_decode('Fecha de egreso: '),1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(28, 4, utf8_decode(''),1, 'L');
$pdf->Ln(6);
}else{
$fecha_egreso=date_create($fech_egreso);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(70, 4, utf8_decode('Fecha de egreso: '),1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(28, 4, utf8_decode(date_format($fecha_egreso,"d-m-Y H:i:s")),1, 'L');
$pdf->Ln(6);
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 3, utf8_decode('Diagnóstico de ingreso: '), 0, 'L');
$pdf->Ln(3.5);
$pdf->SetFont('Arial', '', 8);
include "../../conexionbd.php";

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
     $pdf->MultiCell(195, 3, utf8_decode($d) , 'B', 'C');
    } else{
      $pdf->MultiCell(195, 3, utf8_decode($m) , 'B', 'C');
    }
    
    /*
$resultado5=$conexion->query("select * from diag_pac WHERE Id_exp=" . $id_exp.".ORDER by Id_exp DESC") or die($conexion->error);
     while ($f5 = mysqli_fetch_array($resultado5)) {
      $pdf->MultiCell(195, 3, utf8_decode($f5['diag_paciente']),1, 'L');  
    }*/
$pdf->Ln(1);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 3, utf8_decode('Resumen clínico: '), 0,1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 3, utf8_decode($resum_clinico),1, 'L');
$pdf->Ln(1);



  $sql_med_id = "SELECT id_usua FROM resumen_clinico WHERE id_atencion = $id_atencion ORDER by id_resum DESC LIMIT 1";
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
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 240 , 30);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 240 , 30);
}
      $pdf->SetY(264);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm ), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'Céd. prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('Nombre y firma de médico'), 0, 0, 'C');




 $pdf->Output();
  }