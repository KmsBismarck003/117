<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$id_sang=@$_GET['id_sang'];
$sql_sig ="select * from dat_trasfucion WHERE id_atencion=$id_atencion ORDER by fec_tras DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);

while ($row_sig = $result_sig->fetch_assoc()) {
 $id_tras=$row_sig['id_tras'];
}

if(isset($id_tras)){
    $id_tras = $id_tras;
  }else{
    $id_tras ='sin doc';
  }

if($id_tras=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE NOTA DE TRANSFUSIÓN PARA ESTE PACIENTE", 
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
    $this->Cell(0, 10, utf8_decode('CMSI-006'), 0, 1, 'R');
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
  $tip_san = $row_pac['tip_san'];
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

$sql_trans = "SELECT * FROM dat_ingreso where id_atencion = $id_atencion";
$result_trans = $conexion->query($sql_trans);

while ($row_trans = $result_trans->fetch_assoc()) {
 
    $tipo_a = $row_trans['tipo_a'];
    $fecha_ing = $row_trans['fecha'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('NOTA DE TRANSFUSIÓN '), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetX(170);
$pdf->SetFont('Arial', '', 6);

$fecha_actual = date("d/m/Y H:i");
$pdf->Cell(35, -2, 'FECHA: ' . $fecha_actual, 0, 1, 'R');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 207, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(207, 53, 205, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(7);
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
$pdf->Cell(126, 3, utf8_decode($nom_pac . ' ' . $papell . ' ' . $sapell), 'B', 'L');
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
$pdf->Cell(10, 3, 'SEXO: ', 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(14, 3,  $sexo, 'B', 'L');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(15, 3, utf8_decode(' DOMICILIO: '), 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(102, 3, utf8_decode($dir), 'B', 'L');
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(28, 3, utf8_decode(' TIPO DE SANGRE: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(25, 3,  utf8_decode($tip_san), 'B', 'L');


$sql_sig ="select * from dat_trasfucion WHERE id_atencion=$id_atencion ORDER by fec_tras DESC LIMIT 1";

$sql_sig ="SELECT * from dat_trasfucion WHERE id_tras=$id_sang";

$result_sig = $conexion->query($sql_sig);

while ($row_sig = $result_sig->fetch_assoc()) {
$fec_tras=$row_sig['fec_tras'];
$num_tras=$row_sig['num_tras'];
$cont_tras=$row_sig['cont_tras'];
$fol_tras=$row_sig['fol_tras'];
$glob_tras=$row_sig['glob_tras'];
$pla_tras=$row_sig['pla_tras'];
$crio_tras=$row_sig['crio_tras'];
$hb_tras=$row_sig['hb_tras'];
$hto_tras=$row_sig['hto_tras'];
$san_tras=$row_sig['san_tras'];

$sisto_pre=$row_sig['sisto_pre'];
$diasto_pre=$row_sig['diasto_pre'];
$fc_pre=$row_sig['fc_pre'];
$temp_pre=$row_sig['temp_pre'];

$inicio_tras=$row_sig['inicio_tras'];
$med_tras=$row_sig['med_tras'];
$medi_tras=$row_sig['medi_tras'];
$ev_tras=$row_sig['ev_tras'];
$ev_traspost=$row_sig['ev_traspost'];
$edo_tras = $row_sig['edo_tras'];
$com_tras=$row_sig['com_tras'];
$com_traspost=$row_sig['com_traspost'];

$vol_tras=$row_sig['vol_tras'];
$fin_tras=$row_sig['fin_tras'];
$edo_tras=$row_sig['edo_tras'];
$ob_tras=$row_sig['ob_tras'];
$sisto_tras=$row_sig['sisto_tras'];
$diasto_tras=$row_sig['diasto_tras'];
$fc_tras=$row_sig['fc_tras'];
$temp_tras=$row_sig['temp_tras'];

$p_sistol = ($row_sig['p_sistol']);
$p_diastol = ($row_sig['p_diastol']);
$fcard = ($row_sig['fcard']);
$temper = ($row_sig['temper']);
 
}
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(195, 5, utf8_decode('PRE-TRANSFUSIONAL'), 0, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(30, 4, utf8_decode('SIGNOS VITALES:'), 1,'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(55, 4, utf8_decode('PRESIÓN ARTERIAL: ' .$sisto_pre.'/'.$diasto_pre), 1, 'L');
$pdf->Cell(55, 4, utf8_decode('FRECUENCIA CARDIACA: ' .$fc_pre), 1, 'L');
$pdf->Cell(55, 4, utf8_decode('TEMPERATURA: ' .$temp_pre), 1, 'L');
$pdf->Ln(4);
$fec_tras=date_create($fec_tras);
$pdf->Cell(95, 4, utf8_decode('FECHA DE TRANSFUSIÓN: '.date_format($fec_tras,"d/m/Y")), 1, 'L');
$pdf->Cell(100, 4, utf8_decode('NÚMERO DE UNIDADES: '.$num_tras), 1, 'L');
$pdf->Ln(4);
$pdf->Cell(95, 4, utf8_decode('CONTENIDO (CANTIDAD): '.$cont_tras), 1, 'L');
$pdf->Cell(100, 4, utf8_decode('FOLIO: '.$fol_tras), 1, 'L');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 7);
$pdf->MultiCell(195, 4, utf8_decode('COMPONENTE SANGUINEO'), 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(95, 4, utf8_decode('COMPONENTE SANGUINEO: '.$glob_tras), 1, 'L');
$pdf->Cell(52, 4, utf8_decode('HB: '.$hb_tras), 1, 'L');
$pdf->Cell(48, 4, utf8_decode('HTO: '.$hto_tras), 1, 'L');
$pdf->Ln(4);

$pdf->Cell(95, 4, utf8_decode('GRUPO SANGUINEO: '.$san_tras), 1, 'L');
$pdf->Cell(100, 4, utf8_decode('HORA DE INICIO: '.$inicio_tras), 1, 'L');

$pdf->Ln(4);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(195, 4, utf8_decode('NOMBRE COMPLETO DEL MEDICO QUE INDICA LA TRANSFUSIÓN : '.$med_tras), 1, 'L');
$pdf->Ln(4);
$pdf->Cell(195, 4, utf8_decode('NOMBRE COMPLETO DEL MEDICO QUE REALIZA LA TRANSFUSIÓN : '.$medi_tras), 1, 'L');
$pdf->Ln(4);
$pdf->MultiCell(195, 4, utf8_decode('ESTADO GENERAL DEL PACIENTE : '.$edo_tras), 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(195, 5, utf8_decode('TRANSFUSIONAL'), 0, 'C');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(30, 4, utf8_decode('SIGNOS VITALES'), 1, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(55, 4, utf8_decode('PRESIÓN ARTERIAL: '.$sisto_tras.'/'.$diasto_tras), 1, 'L');
$pdf->Cell(55, 4, utf8_decode('FRECUENCIA CARDIACA: '.$fc_tras), 1, 'L');
$pdf->Cell(55, 4, utf8_decode('TEMPERATURA: '.$temp_tras), 1, 'L');

$pdf->Ln(4);
$pdf->MultiCell(195, 4, utf8_decode('EVOLUCIÓN : '.$ev_tras), 1, 'J');
$pdf->MultiCell(195, 4, utf8_decode('COMPLICACIONES : '.$com_tras), 1, 'J');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(195, 5, utf8_decode('POST-TRANSFUSIONAL'), 0, 'C');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(30, 4, utf8_decode('SIGNOS VITALES:'), 1,'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(55, 4, utf8_decode('PRESIÓN ARTERIAL: ' .$p_sistol.'/'.$p_diastol), 1, 'L');
$pdf->Cell(55, 4, utf8_decode('FRECUENCIA CARDIACA: ' .$fcard), 1, 'L');
$pdf->Cell(55, 4, utf8_decode('TEMPERATURA: ' .$temper), 1, 'L');
$pdf->Ln(4);
$pdf->Cell(95, 4, utf8_decode('VOLUMEN TRANSFUNDIDO:'.$vol_tras), 1, 'L');
$pdf->Cell(100, 4, utf8_decode('HORA DE TERMINO:'.$fin_tras), 1, 'L');
$pdf->Ln(4);
$pdf->MultiCell(195, 4, utf8_decode('EVOLUCIÓN:'.$ev_traspost), 1, 'J');
$pdf->MultiCell(195, 4, utf8_decode('COMPLICACIONES : '.$com_traspost), 1, 'J');
$pdf->MultiCell(195, 4, utf8_decode('OBSERVACIONES:'.$ob_tras), 1, 'J');
$pdf->Ln(4);

$sql_med_id = "SELECT id_usua FROM dat_trasfucion WHERE id_atencion = $id_atencion ORDER by fec_tras DESC LIMIT 1";
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

}    $pdf->SetY(220);
     $pdf->SetFont('Arial', '', 5.5);
     $pdf->MultiCell(195,3,utf8_decode('1. EL SERVICIO CLINICO DEBERA MANTENER LA UNIDAD EN TEMPERATURAS Y CONDICIONES ADECUADAS QUE ASEGUREN SU VIABILIDAD.
2. ANTES DE CADA TRANSFUSIÓN DEBERA VERIFICARSE LA IDENTIDAD DEL RECEPTOR Y DE LA UNIDAD DESIGNADA PARA ESTE.
3. NO SE DEBERA AGREGAR A LA UNIDAD NINGUN MEDICAMENTO O SOLUCIÓN, INCLUSO LAS DESTINADAS PARA USO INTRAVENOSO, CON EXCEPCIÓN DE SOLUCIÓN SALINA AL 0.9% CUANDO ASI SEA NECESARIO.
4. LA TRANSFUSIÓN DE CADA UNIDAD NO DEBERA EXCEDER DE 4 HORAS.
5. LOS FILTROS DEBERÁN CAMBIARSE CADA 6 HRS. O CUANDO HUBIESEN TRANSFUNDIDO 4 UNIDADES.
6. DE PRESENTARSE UNA REACCIÓN TRANSFUSIONAL,SUSPENDER INMEDIATAMENTE LA TRANSFUSIÓN, NOTIFICAR AL MEDICO ENCARGADO Y REPORTAR AL BANCO DE SANGRE, SIGUIENDO LAS INSTRUCCIONES SEÑALADAS EN EL FORMATO DE REPORTE QUE ACOMPAÑA A LA UNIDAD.
7. EN CASO DE NO TRANSFUNDIR LA UNIDAD, REGRESARLA AL BANCO DE SANGRE O SERVICIO DE TRANSFUSIÓN PREFERENTEMENTE ANTES DE TRANSCURRIDAS 2 HORAS A PARTIR DE QUE LA UNIDAD SALIO DEL BANCO DE SANGRE O DEL SERVICIO DE TRANSFUSIÓN. '),0,'J');

      $pdf->SetY(-60);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Image('../../imgfirma/' . $firma, 95, 250, 30);
    
      $pdf->SetY(264);
      $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'CÉD. PROF. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(4);
      $pdf->Cell(200, 4, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
 $pdf->Output();

}