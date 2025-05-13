<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id'];
$id_med = @$_GET['id_med'];
$id_rec = @$_GET['id_rec'];

$sql_rechosp = "SELECT * FROM recetaurgen where id_atencion = $id_atencion || id_rec_urgen = $id_rec ";
$result_rechosp = $conexion->query($sql_rechosp);

while ($row_rechosp = $result_rechosp->fetch_assoc()) {
  $id_rec_urgen = $row_rechosp['id_rec_urgen'];
}

if(isset($id_rec_urgen)){
    $id_rec_urgen = $id_rec_urgen;
  }else{
    $id_rec_urgen ='sin doc';
  }

if($id_rec_urgen=="sin doc"){
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
    $this->Cell(0, 10, utf8_decode('CMSI-4.03'), 0, 1, 'R');
  }
  
}


$sql_pac = "SELECT p.papell, p.nom_pac,p.fecnac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp,di.fecha,di.tipo_a,di.alergias FROM paciente p, dat_ingreso di where di.id_atencion = $id_atencion and di.Id_exp=p.Id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $fecha_ing = $row_pac['fecha'];
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
  $edad = $row_pac['edad']; 
  $alergias = $row_pac['alergias']; 
}

//consulta receta hosp
$sql_rechosp = "SELECT * FROM recetaurgen  where id_atencion = $id_atencion";
$result_rechosp = $conexion->query($sql_rechosp);

while ($row_rechosp = $result_rechosp->fetch_assoc()) {
 
  
  $detesp = $row_rechosp['detesp']; 
  $receta_urgen = $row_rechosp['receta_urgen']; 
  $med = $row_rechosp['med']; 
  $reg_ssa_urgen = $row_rechosp['reg_ssa_urgen']; 
  $fecha_recurgen = $row_rechosp['fecha_recurgen']; 
  
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
$pdf->MultiCell(165, 9.5, utf8_decode('RECETA MÉDICA'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 50, 172, 50);
$pdf->Line(48, 41, 48, 50);
$pdf->Line(172, 41, 172, 50);
$pdf->Line(48, 41, 172, 41);

$pdf->Ln(3);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 207, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(207, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);

$fecha_r_hosp=date_create($fecha_recurgen);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 5, utf8_decode('Fecha y hora de elaboración: '), 0,0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 5, date_format($fecha_r_hosp,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(35, 5, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 5, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');
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
$pdf->Cell(35, 5, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 5, date_format($date1,"d/m/Y"), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 5, ' Edad: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(28, 5, utf8_decode($edad),'B', 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(28, 5,  utf8_decode($tel), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 5, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 5,  $sexo, 'B', 'L');
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 5, utf8_decode('Alergías: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(89, 5, utf8_decode($alergias), 'B', 'L');
$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(200, 5, utf8_decode('SIGNOS VITALES: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7.2);
$pdf->Cell(38, 5, utf8_decode('Presión Arterial: ' .$p_sistolica.'/'.$p_diastolica).' mmHG', 1, 'L');
$pdf->Cell(43, 5, utf8_decode('Frecuencia Cardiaca: ' .$f_card.' Latidos/min'), 1, 'L');
$pdf->Cell(55, 5, utf8_decode('Frecuencia Respiratoria: ' .$f_resp.' Respiraciones/min'), 1, 'L');
$pdf->Cell(26, 5, utf8_decode('Temperatura: ' .$temp.' °C'), 1, 'L');
$pdf->Cell(34, 5, utf8_decode('Saturación de Oxígeno: ' .$sat_oxigeno.'%'), 1, 'L');

$pdf->Ln(9);
 
/*cuadro de medicamentos  */
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(10, 88, 204, 88);
$pdf->Line(10, 88, 10, 245);
$pdf->Line(204, 88, 204, 245);
$pdf->Line(10, 245, 204, 245);
/*cuadro de medicamentos  */
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(90);
$pdf->MultiCell(45, 8, 'TRATAMIENTO : ',0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(190, 7, utf8_decode($receta_urgen), 0, 'L');
$pdf->Ln(1);

$sql_med_id = "SELECT id_usua FROM recetaurgen WHERE id_atencion = $id_atencion ORDER by fecha_recurgen DESC LIMIT 1";
    $result_med_id = $conexion->query($sql_med_id);

    while ($row_med_id = $result_med_id->fetch_assoc()) {
      $id_med = $row_med_id['id_usua'];
    }
    $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_med";
    $result_med = $conexion->query($sql_med);

    while ($row_med = $result_med->fetch_assoc()) {
      
      $app = $row_med['papell'];
      
      $pre = $row_med['pre'];
      $firma = $row_med['firma'];
      $ced_p = $row_med['cedp'];
$cargp = $row_med['cargp'];
      }
    $pdf->SetY(-32);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Image('../../imgfirma/' . $firma, 88, 252, 35);
      $pdf->Ln(2);
      $pdf->SetX(80);
      $pdf->Cell(50, 3, utf8_decode($pre . ' .' . $app ), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetX(30);
      $pdf->Cell(150, 3, utf8_decode('Cédula Profesional: ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetX(15);
      $pdf->Cell(180, 3, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');

 $pdf->Output();
}