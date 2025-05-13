<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';

$id_pos = @$_GET['id_notpos'];

if (@$_GET['id_exp']) {
  $id_exp = @$_GET['id_exp'];
}elseif(@$_GET['Id_exp']){
$id_exp = @$_GET['Id_exp'];
}

$id_atencion = @$_GET['id_atencion'];

$sql_sig ="select * from nota_posparto WHERE id_atencion=$id_atencion";
$result_sig = $conexion->query($sql_sig);

while ($row_sig = $result_sig->fetch_assoc()) {
 $id_notpos=$row_sig['id_notpos'];
}
if(isset($id_notpos)){
    $id_notpos = $id_notpos;
  }else{
    $id_notpos ='sin doc';
  }

if($id_notpos=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE NOTA DE POSPARTO PARA ESTE PACIENTE", 
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

    $this->Image('../../imagenes/SI.PNG', 5, 15, 65, 21);
    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
    $this->Cell(196, 9, utf8_decode(' Médica San Isidro'), 0, 0, 'C');
    $this->Ln(10);
    $this->SetDrawColor(43, 45, 180);
    $this->Line(50, 18, 170, 18);
    $this->SetFont('Arial', '', 8);
    $this->Cell(200, 8, utf8_decode('CALLE JOSEFA ORTIZ DE DOMÍNGUEZ #444'), 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(200, 8, utf8_decode('BARRIO COAXUSTENCO, METEPEC, ESTADO DE MÉXICO'), 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(200, 8, 'TEL: (01722) 235-01-75 / 235-02-12 / 902-03-90 / C.P. 52140', 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(200, 8, 'https://medicasanisidro.com/', 0, 0, 'C');
    $this->Ln(10);
    $this->Image('../../imagenes/en.png', 159, 22, 45, 15);
  }
   function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('SIMA-021'), 0, 1, 'R');
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

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $fecha_ing = $row_dat_ing['fecha'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $tipo_a = $row_dat_ing['tipo_a'];
}
$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('NOTA DE POST PARTO'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetX(170);
$pdf->SetFont('Arial', '', 6);

$fecha_actual = date("d/m/Y H:i");
$pdf->Cell(35, -2, 'FECHA: ' . $fecha_actual, 0, 1, 'R');

$pdf->Ln(6);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 207, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(207, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(17, 3, 'SERVICIO: ', 0, 'L');  
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(124, 3, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 6);
$date=date_create($fecha_ing);
$pdf->Cell(28, 3, utf8_decode('FECHA DE INGRESO:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(25, 3, date_format($date,'d-m-Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(20, 3, utf8_decode('EXPEDIENTE: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(8, 3, utf8_decode($Id_exp), 'B', 0, 'L');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(40, 3, ' NOMBRE DEL PACIENTE: ', 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(126, 3, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 6);

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 6);
$date=date_create($fecnac);
$pdf->Cell(37, 3, 'FECHA DE NACIMIENTO: ', 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(20, 3, date_format($date,"d/m/Y"), 'B', 'C');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(12, 3, ' EDAD: ', 0, 'L');

$edad=calculaedad($fecnac);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(20, 3, utf8_decode($edad), 'B', 'C');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(21, 3, utf8_decode(' OCUPACIÓN: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(31, 3,  utf8_decode($ocup), 'B', 'L');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('TELÉFONO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(25, 3,  utf8_decode($tel), 'B', 'L');

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(13, 3, 'SEXO: ', 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(22, 3,  $sexo, 'B', 'L');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(18, 3, utf8_decode(' DOMICILIO: '), 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(141, 3, utf8_decode($dir), 'B', 'L');

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(25, 3, utf8_decode('RESPONSABLE: '), 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(65, 3, utf8_decode($resp), 'B', 'L');
 
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(23, 3, utf8_decode('PARENTESCO: '), 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(28, 3, utf8_decode($paren), 'B', 'L');
  
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode('TELÉFONO RESP: '), 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(25, 3,  utf8_decode($tel_resp), 'B', 'L');

$pdf->SetFont('Arial', 'B', 6);
$pdf->Ln(5);
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
$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);

while ($row_hc = $result_sig->fetch_assoc()) {

 $pesoh=$row_hc['peso'];
 $tallah=$row_hc['talla'];

}
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(195, 3, utf8_decode('SIGNOS VITALES'), 0,0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(31, 3, utf8_decode('PRESIÓN ARTERIAL: ' .$p_sistolica.'/'.$p_diastolica), 1, 'L');
$pdf->Cell(26, 3, utf8_decode('FREC. CARDIACA: ' .$f_card), 1, 'L');
$pdf->Cell(30, 3, utf8_decode('FREC. RESPIRATORIA: ' .$f_resp), 1, 'L');
$pdf->Cell(26, 3, utf8_decode('TEMPERATURA: ' .$temp), 1, 'L');
$pdf->Cell(32, 3, utf8_decode('SATURACIÓN OXIGENO: ' .$sat_oxigeno), 1, 'L');
$pdf->Cell(15, 3, utf8_decode('PESO: ' .$pesoh), 1, 'L');
$pdf->Cell(15, 3, utf8_decode('TALLA: ' .$tallah), 1, 'L');
$pdf->Cell(20, 3, utf8_decode('ESCALA EVA: ' .$niv_dolor), 1, 'L');
$pdf->Ln(4);




$sql_ne ="SELECT * from nota_posparto WHERE id_notpos=$id_pos";
$result_ne = $conexion->query($sql_ne);

while ($row_ne = $result_ne->fetch_assoc()) {
 $problema=$row_ne['problema'];
 $subjetivo=$row_ne['subjetivo'];
 $objetivo=$row_ne['objetivo'];
 $analisis=$row_ne['analisis'];
 $plan=$row_ne['plan'];
 $px=$row_ne['px'];
 $edosalud=$row_ne['edosalud'];
  $guia=$row_ne['guia'];
}


$pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(30, 3, utf8_decode('PACIENTE: '), 0, 'L');
 $pdf->SetFont('Arial', '', 6);
 $pdf->MultiCell(165, 3, utf8_decode( $problema), 1, 'L');
 $pdf->Ln(1);

 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(30, 3, utf8_decode('SUBJETIVO: '), 0, 'L');
 $pdf->SetFont('Arial', '', 6);
 $pdf->MultiCell(165, 3, utf8_decode( $subjetivo), 1, 'L');
 $pdf->Ln(1);

 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(30, 3, utf8_decode('OBJETIVO: '), 0, 'L');
 $pdf->SetFont('Arial', '', 6);
 $pdf->MultiCell(165, 3, utf8_decode( $objetivo), 1, 'L');
 $pdf->Ln(1);

 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(30, 3, utf8_decode('ANÁLISIS: '), 0, 'L');
 $pdf->SetFont('Arial', '', 6);
 $pdf->MultiCell(165, 3, utf8_decode( $analisis), 1, 'L');
 $pdf->Ln(1);
 

 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(30, 3, utf8_decode('PLAN: '), 0, 'L');
 $pdf->SetFont('Arial', '', 6);
 $pdf->MultiCell(165, 3, utf8_decode( $plan), 1, 'L');
 $pdf->Ln(1);

 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(30, 3, utf8_decode('PRONÓSTICO: '), 0, 'L');
 $pdf->SetFont('Arial', '', 6);
 $pdf->MultiCell(165, 3, utf8_decode( $px), 1, 'L');
 $pdf->Ln(1);

 $pdf->SetFont('Arial', 'B', 6);
 $pdf->Cell(30, 3, utf8_decode('ESTADO DE SALUD: '), 0, 'L');
 $pdf->SetFont('Arial', '', 6);
 $pdf->MultiCell(165, 3, utf8_decode($edosalud), 1, 'L');
 $pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(30, 3, utf8_decode('GUÍA PRÁCTICA CLÍNICA: '),0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(165, 3, utf8_decode($guia),1, 'L');



$sql_med_id = "SELECT id_usua FROM nota_posparto WHERE id_notpos=$id_pos";
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
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Image('../../imgfirma/' . $firma, 95, 250, 30);
    
      $pdf->SetY(264);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'CÉD. PROF. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
 $pdf->Output();

}