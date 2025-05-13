<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

$sql_partograma = "SELECT * FROM partograma p WHERE p.id_atencion= $id_atencion";
$result__p = $conexion->query($sql_partograma);

while ($row_p = $result__p->fetch_assoc()) {
  $id_partograma = $row_p['id_partograma'];
}

if (isset($id_partograma)) {
  $id_partograma = $id_partograma;
} else {
  $id_partograma = 'sin doc';
}

if ($id_partograma == "sin doc") {
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
  echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
  echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
  echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE PARTOGRAMA PARA ESTA PACIENTE", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                                window.close();
                            }
                        });
                    });
                </script>';
} else {

  mysqli_set_charset($conexion, "utf8");

  class PDF extends FPDF
  {
    function Header()
    {
      $id = @$_GET['id'];
      $id_med = @$_GET['id_med'];
      include '../../conexionbd.php';

      $id = @$_GET['id'];

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
      include '../../conexionbd.php';

      $this->Ln(5);
      $this->SetY(-15);
      $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
      $this->SetX(100);
      $this->Cell(0, 10, utf8_decode('SIMA-020'), 0, 1, 'R');
    }
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


  $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.fecha, di.area, di.alta_med, p.sexo, p.tip_san, p.religion  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

  $result_pac = $conexion->query($sql_pac);

  while ($row_pac = $result_pac->fetch_assoc()) {
    $pac_nom =  $row_pac['papell'] . ' ' . $row_pac['sapell'] . ' ' . $row_pac['nom_pac'];
    $pac_fecnac = $row_pac['fecnac'];
    $pac_fecnac1 = '"' . $row_pac['fecnac'] . '"';
    $pac_fecing = $row_pac['fecha'];
    $area = $row_pac['area'];
    $alta_med = $row_pac['alta_med'];
    $exp = $row_pac['Id_exp'];
    $sexo = $row_pac['sexo'];
    $tipo_sang = $row_pac['tip_san'];
    $religion = $row_pac['religion'];
  }

  $date = date_create($pac_fecnac);
 
  $edad = calculaedad($pac_fecnac);


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

  $sql_partograma = "SELECT * FROM partograma p WHERE p.id_atencion= $id_atencion";
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

  $pdf = new PDF('P');
  $pdf->AliasNbPages();
  $pdf->AddPage();

 $pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('PARTOGRAMA'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetX(170);

  $pdf->SetFont('Arial', '', 6);

  
  $fecha_actual = date("d/m/Y H:i");
  $pdf->Cell(35, -2, 'FECHA: ' . $fecha_actual, 0, 1, 'R');
$pdf->Ln(5);
  
  $pdf->SetFont('Arial', '', 7);
  $pdf->Cell(30, 5, utf8_decode('EXPEDIENTE: ' . $id_exp), 1, 0, 'L');
  $pdf->Cell(110, 5, utf8_decode('NOMBRE: ' . $pac_nom), 1, 0, 'L');
  $pdf->Cell(55, 5, utf8_decode('FECHA: ' . date_format($fecreg,'d-m-Y H:i:s')), 1, 0, 'L');
 
  $pdf->Ln(5);
  $pdf->Cell(60, 5, utf8_decode('FECHA DE NACIMIENTO: ' . date_format($date, "d/m/Y")), 1, 0, 'L');
  $pdf->Cell(30, 5, utf8_decode('EDAD: ' . $edad),1, 0, 'L');
  $pdf->Cell(50, 5, utf8_decode('RELIGIÓN: ' . $religion), 1, 0, 'L'); 
  $pdf->Cell(55, 5, utf8_decode('TIPO SANGRE: ' . $tipo_sang), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(25, 5, utf8_decode('GESTAS: ' . $gestas), 1, 0, 'L');
  $pdf->Cell(25, 5, utf8_decode('PARTOS: ' . $partos), 1, 0, 'L');
  $pdf->Cell(25, 5, utf8_decode('CESÁREAS: ' . $cesareas), 1, 0, 'L');
  $pdf->Cell(25, 5, utf8_decode('ABORTOS: ' . $abortos), 1, 0, 'L');
 
 
  $pdf->Cell(40, 5, utf8_decode('NO.  DE HIJOS VIVOS: ' . $no_hijos), 1, 0, 'L');
  $pdf->Cell(55, 5, utf8_decode('MALFORMACIONES: ' . $malformaciones), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(90, 5, utf8_decode('FECHA ÚLTIMO PARTO CESÁREA: ' . date_format($fec_ucesarea, "d/m/Y")), 1, 0, 'L');
  $pdf->Cell(50, 5, utf8_decode('FEC. ÚLTIMA REGLA: ' . date_format($fecur, "d/m/Y")), 1, 0, 'L');
  $pdf->Cell(55, 5, utf8_decode('FECHA PROBABLE DE PARTO: ' . date_format($fecpp, "d/m/Y")), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(90, 5, utf8_decode('EMBARAZO ACTUAL - SEMANAS DE GESTACIÓN: ' . $sem_gestacion), 1, 0, 'L');
  
  $pdf->Cell(50, 5, utf8_decode('NO. DE CONSULTAS: ' . $no_consultas), 1, 0, 'L');

  $pdf->Cell(55, 5, utf8_decode('CONTROL PERINATAL: ' . $c_perinatal), 1, 0, 'L');
   $pdf->Ln(5);
  $pdf->Cell(90, 5, utf8_decode('UNIDAD: ' . $unidad), 1, 0, 'L');
  $pdf->Cell(105, 5, utf8_decode('LAV. PREV. REC. : ' . $lab_prev_rec), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->MultiCell(195, 5, utf8_decode('COMPLICACIONES DEL EMBARAZO ACTUAL: ' . $comp_emb_act), 1, 'L');
  $pdf->MultiCell(195, 5, utf8_decode('TRATAMIENTO: ' . $tratamiento), 1, 'L');
  $pdf->Cell(140, 5, utf8_decode('CONTRACTILIDAD UTERINA : ' . $c_uterina), 1, 0, 'L');
  $pdf->Cell(55, 5, utf8_decode('INICIA EN 10 MIN.'), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(100, 5, utf8_decode('SANGRADO TV : ' . $sang_tv), 1, 0, 'L');
  $pdf->Cell(95, 5, utf8_decode('INICIO FECHA: ' . date_format($fec_inicio,"d/m/Y") . ' HORA:  ' . $hora_inicio), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(100, 5, utf8_decode('ROMPIMIENTO PREMATURO DE MEMBRANAS: ' . $rpm), 1, 0, 'L');
  $pdf->Cell(95, 5, utf8_decode('FECHA: ' . date_format($fec_rpm,"d/m/Y") . ' HORA ' . $hora_rpm), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(60, 5, utf8_decode('NO. CONSULTAS DE URGENCIAS: ' . $no_consul_urg), 1, 0, 'L');
  $pdf->Cell(40, 5, utf8_decode('MOTILIDAD FETAL: ' . $mot_fetal), 1, 0, 'L');
  $pdf->Cell(50, 5, utf8_decode('DISM: ' . $dism), 1, 0, 'L');
  $pdf->Cell(45, 5, utf8_decode('NL: ' . $nl), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(60, 5, utf8_decode('TA: ' . $p_sistolica . '/' . $p_diastolica), 1, 0, 'L');
  $pdf->Cell(40, 5, utf8_decode('TEMP: ' . $temp), 1, 0, 'L');
  $pdf->Cell(25, 5, utf8_decode('FC.: ' . $fc), 1, 0, 'L');
  $pdf->Cell(25, 5, utf8_decode('FR: ' . $fr), 1, 0, 'L');
  $pdf->Cell(45, 5, utf8_decode('EDEMA: ' . $edema), 1, 0, 'L');
  $pdf->Ln(10);
  $pdf->Image('../../img/altura_utero.jpeg', 10, $pdf->GetY(), 60, 40);
  $pdf->Image('../../img/dilatacion_pocision.jpeg', 75, $pdf->GetY(), 60, 40);
  $pdf->Image('../../img/altura_presentacion.jpg', 140, $pdf->GetY(), 60, 40);
  $pdf->Ln(40);
  $pdf->SetFont('Arial', 'B', 7);
  $pdf->Cell(65, 5, utf8_decode('ALTURA ÚTERO : ' . $alt_utero), 1, 0, 'C');
  $pdf->Cell(65, 5, utf8_decode('DILATRACIÓN Y POSICIÓN'), 1, 0, 'C');
  $pdf->Cell(65, 5, utf8_decode('ALTURA DE LA PRESENTACIÓN'), 1, 0, 'C');
  $pdf->Ln(5);
  $pdf->SetFont('Arial', '', 7);
  $pdf->Cell(65, 5, utf8_decode('F.C.F.: ' . $fcf), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('RITMO: ' . $ritmo), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('TONO UTERO: ' . $t_uterino), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(65, 5, utf8_decode('MEMBRANAS INTERGAS: ' . $memb_int), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('ROTAS: ' . $rotas), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('ASPECTO DEL LIQUIDO AMNIOTICO: ' . $asp_la), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(65, 5, utf8_decode('CERVIX:BORRAMIENTO ' . $cervix), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('DILATACIÓN: ' . $dilatacion), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('PRESENTACIÓN: ' . $presentacion), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->Cell(65, 5, utf8_decode('PELVIS: ' . $pelvis), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('ÚTIL: ' . $util), 1, 0, 'L');
  $pdf->Cell(65, 5, utf8_decode('NO ÚTIL: ' . $n_util), 1, 0, 'L');
  $pdf->Ln(5);
  $pdf->MultiCell(195, 5, utf8_decode('IMPRESIÓN DIAGNÓSTICA: ' . $imp_diag), 1, 'L');
  $pdf->MultiCell(195, 5, utf8_decode('PLAN DE TRATAMIENTO: ' . $p_trat), 1, 'L');
  $pdf->Ln(5);
   
  $pdf->SetY(-60);
  $pdf->SetFont('Arial', 'B', 8);
  $pdf->Image('../../imgfirma/' . $firma, 95, 250, 30);
    
  $pdf->SetY(263);
  $pdf->Cell(200, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
  $pdf->Ln(4);
  $pdf->SetFont('Arial', 'B', 8);
  $pdf->Cell(200, 4, utf8_decode($cargp . ' ' . 'CÉD. PROF. ' . $ced_p), 0, 0, 'C');
  $pdf->Ln(4);
  $pdf->Cell(200, 4, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
  $pdf->Output();
}
