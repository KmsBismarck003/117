<?php
use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$sql_egreso = "SELECT * from alta where id_atencion=$id_atencion";
$result_egreso = $conexion->query($sql_egreso);

while ($row_egreso = $result_egreso->fetch_assoc()) {
  $id_alta = $row_egreso['id_alta'];
}

if(isset($id_alta)){
    $id_alta = $id_alta;
  }else{
    $id_alta ='sin doc';
  }

if($id_alta=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "No existe aviso de alta para este paciente", 
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

   
    $this->SetDrawColor(43, 45, 127);
    $this->Line(2, 8, 209, 8 );
    $this->Line(2, 8, 1, 130);
    $this->Line(1, 130, 209, 130);
    $this->Line(209, 8, 209, 130);
  include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 9, 48, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
}

   $this->Ln(32);
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
     $this->Cell(0, 10, utf8_decode('MAC-010'), 0, 1, 'R');
  }
  
}

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $fecha_ing=$row_dat_ing['fecha'];
   $tipo_a=$row_dat_ing['tipo_a'];
}


$sql_pac = "SELECT * FROM paciente where Id_exp = $id_exp";
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
    $folio = $row_pac['folio'];
}

$sql_camas = "SELECT * from cat_camas where id_atencion=$id_atencion";
$result_cama = $conexion->query($sql_camas);

while ($row_cama = $result_cama->fetch_assoc()) {
  $num_cama = $row_cama['num_cama'];
}

if(isset($num_cama)){
   $num_cama = $num_cama;
}else{
  $num_cama='SIN CAMA';
}
  $sql_est = "SELECT DATEDIFF(fec_egreso, fecha) as estancia FROM dat_ingreso where id_atencion = $id_atencion";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
          $estancia = $row_est['estancia'];
       
      }


$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetX(90);
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Cell(140, 6, utf8_decode('AVISO DE ALTA'), 0, 'C');
$pdf->SetFont('Arial', '', 8);

$fecha_actual = date("d/m/Y");
$pdf->Cell(36, 6, 'Metepec, Mex, ' . $fecha_actual, 0, 1, 'R');

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 6, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(176, 6, utf8_decode($tipo_a) , 'B', 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 6, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8, 6, utf8_decode($folio), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 6, ' Nombre del paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(136, 6, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecnac);
$pdf->Cell(40, 6, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6, date_format($date,"d/m/Y"), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 6, '  Edad: ', 0, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6, utf8_decode($edad), 'B', 'C');


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 6, utf8_decode('  Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6,  $sexo, 'B', 0, 'C');


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(26,6,utf8_decode('  Habitación: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(16, 6, utf8_decode($num_cama), 'B', 0, 'C');

/*
$sql_egreso = "SELECT * from dat_egreso where id_atencion=$id_atencion";
$result_egreso = $conexion->query($sql_egreso);

while ($row_egreso = $result_egreso->fetch_assoc()) {
  $alta_por = $row_egreso['cond'];
  $fech_alta = $row_egreso['fech_egreso'];
  $res_clin=$row_egreso['res_clin'];
  $dias=$row_egreso['dias'];
  $cuid=$row_egreso['cuid'];
  $trat=$row_egreso['trat'];
  $exes=$row_egreso['exes'];
  $pcita=$row_egreso['pcita'];
}
*/
$sql_egreso = "SELECT * from alta where id_atencion=$id_atencion";
$result_egreso = $conexion->query($sql_egreso);

while ($row_egreso = $result_egreso->fetch_assoc()) {
  $fech_alta = $row_egreso['fec_egreso'];
  $hor_alta = $row_egreso['hor_alta'];
  $alta_por = $row_egreso['alta_por'];
}

$sql_ing = "SELECT * FROM dat_ingreso  where Id_exp = $id_exp";
$result_ing = $conexion->query($sql_ing);
while ($row_ing = $result_ing->fetch_assoc()) {
$especialidad = $row_ing['especialidad'];
  $fechai = $row_ing['fec_egreso'];
  $area= $row_ing['area'];
    $tipo_a= $row_ing['tipo_a'];


}
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$fecha=date_create($fecha_ing);
$pdf->Cell(26, 6, utf8_decode('Fecha de ingreso: '),0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6, utf8_decode(date_format($fecha,'d-m-Y H:i')),'B', 'L');
$fecha_alt=date_create($fechai);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 6, utf8_decode('Fecha de egreso: '),0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 6, utf8_decode(date_format($fecha_alt,"d-m-Y")),'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(21, 6, utf8_decode('Días estancia: '),0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(6, 6, utf8_decode($estancia),'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 6, utf8_decode('Motivo de egreso: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(50, 6, utf8_decode($alta_por) , 'B', 'L');


$fecha_actual = date("d-m-Y H:i:s");

 explode("-", $fecha_actual);
 $ano  = date("Y") ;
  $mes= date("m") ;
  $dia  = date("d") ;

   if ($mes==1) {
    $mes='enero';
  }

 if ($mes==2) {
    $mes='febrero';
  }
   if ($mes==3) {
    $mes='marzo';
  }
 if ($mes==4) {
    $mes='abril';
  }
  if ($mes==5) {
    $mes='mayo';
  }
   if ($mes==6) {
    $mes='junio';
  }
   if ($mes==7) {
    $mes='julio';
  }
   if ($mes==8) {
    $mes='agosto';
  }
   if ($mes==9) {
    $mes='septiembre';
  }
   if ($mes==10) {
    $mes='octubre';
  }
   if ($mes==11) {
    $mes='noviembre';
  }
   if ($mes==12) {
    $mes='diciembre';
  }

$sql_med_id = "SELECT id_usua FROM alta WHERE id_atencion = $id_atencion ORDER by  id_alta DESC LIMIT 1";
    $result_med_id = $conexion->query($sql_med_id);

    while ($row_med_id = $result_med_id->fetch_assoc()) {
      $id_med = $row_med_id['id_usua'];
    }

    $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_med";
    $result_med = $conexion->query($sql_med);

while ($row_reg_usrs = $result_med->fetch_assoc()) {
  $user_pre = $row_reg_usrs['pre'];
  $user_papell = $row_reg_usrs['papell'];
  $user_sapell = $row_reg_usrs['sapell'];
  $user_nombre = $row_reg_usrs['nombre'];
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->ln(6);
$pdf->Cell(190, 6, utf8_decode('Metepec, México a, '. $dia.' '.$mes.' '.$ano ) , 0, 1, 'C');

$pdf->ln(4);
$pdf->SetX(5);
$pdf->Cell(200,6,utf8_decode('Autoriza'),0,0,'C');
$pdf->SetX(150);

$pdf->ln(15);

$pdf->SetX(5);
$pdf->Cell(200, 6, utf8_decode($user_pre . '. ' . $user_papell),  0, 0, 'C');

$pdf->Output();
}