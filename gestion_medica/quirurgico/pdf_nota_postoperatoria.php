<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id'];
$id_postp = @$_GET['id_not_postp'];
$id_med = @$_GET['id_med'];

$sql_posto = "SELECT * FROM dat_not_postop where id_atencion = $id_atencion";
$result_posto = $conexion->query($sql_posto);

while ($row_posto = $result_posto->fetch_assoc()) {
$id_not_postp = $row_posto['id_not_postp'];
}

if(isset($id_not_postp)){
    $id_not_postp = $id_not_postp;
  }else{
    $id_not_postp ='sin doc';
  }

if($id_not_postp=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE NOTA POSTOPERATORIA PARA ESTE PACIENTE", 
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

    $this->Image('../../imagenes/logo PDF.jpg', 10, 10, 28, 30);
    $this->SetFont('Arial', 'B', 14);
    $this->Cell(200, 8, 'Sanatorio Venecia', 0, 0, 'C');
    $this->Ln(10);
    $this->SetDrawColor(0, 0, 0);
    $this->Line(50, 18, 170, 18);
    $this->Line(50, 19, 170, 19);
    $this->SetFont('Arial', '', 10);
    $this->Cell(200, 8, 'PASEO TOLLOCAN NO. 113 COL. UNIVERSIDAD', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(200, 8, utf8_decode('C.P. 50130 TOLUCA, MÉX'), 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(200, 8, 'TEL.: (01 722) 280 5672', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(200, 8, 'www.sanatoriovenecia.com.mx', 0, 0, 'C');
    $this->Ln(10);
    $this->Image('../../imagenes/logo PDF 2.jpg', 165, 20, 40, 20);
  }
   function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('SIMA-032'), 0, 1, 'R');
  }
  
}


$sql_pac = "SELECT p.papell, p.nom_pac,p.fecnac,p.sapell,p.edad,p.sexo,p.Id_exp,p.dir,p.id_edo,p.id_mun,p.tel,p.ocup,p.resp,p.paren,p.tel_resp,p.edociv FROM paciente p, dat_ingreso di where di.id_atencion = $id_atencion and di.Id_exp=p.Id_exp";
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
    $edociv = $row_pac['edociv'];
}



$sql_inter = "SELECT * FROM dat_not_inquir iq, dat_ingreso din where iq.id_atencion=$id_atencion and din.id_atencion = iq.id_atencion";
$result_inter = $conexion->query($sql_inter);

while ($row_inter = $result_inter->fetch_assoc()) {
$tipo_intervencion = $row_inter['tipo_intervencion'];
$fecha = $row_inter['fecha'];
$hora_solicitud = $row_inter['hora_solicitud'];
$intervencion_sol = $row_inter['intervencion_sol'];
$diag_preop = $row_inter['diag_preop'];
 $cirugia_prog = $row_inter['cirugia_prog'];
$quirofano = $row_inter['quirofano'];
$reserva = $row_inter['reserva'];
$local = $row_inter['local'];
$regional = $row_inter['regional'];
$general = $row_inter['general'];

  $hb = $row_inter['hb'];
  $hto = $row_inter['hto'];
  $peso = $row_inter['peso'];
  $tipo_sangre = $row_inter['tipo_sangre'];
  $inst_necesario = $row_inter['inst_necesario'];
  $nom_jefe_serv = $row_inter['nom_jefe_serv'];
  $fecha_progra = $row_inter['fecha_progra'];
  $hora_progra = $row_inter['hora_progra'];

  $sala = $row_inter['sala'];
  $jefe_cirugia = $row_inter['jefe_cirugia'];
  $intervencion_quir = $row_inter['intervencion_quir'];
  $inicio = $row_inter['inicio'];
  $termino = $row_inter['termino'];
  $diag_postop = $row_inter['diag_postop'];
  $cir_realizada = $row_inter['cir_realizada'];
  $trans = $row_inter['trans'];
  $posto = $row_inter['posto'];
  $perd_hema = $row_inter['perd_hema'];
  $gasas = $row_inter['gasas'];
  $compresas = $row_inter['compresas'];
  $accident_incident = $row_inter['accident_incident'];
  $anestesia_admin = $row_inter['anestesia_admin'];
  $anestesia_dur = $row_inter['anestesia_dur'];
  $realizada_por = $row_inter['realizada_por'];
  $cirujano = $row_inter['cirujano'];
  $prim_ayudante = $row_inter['prim_ayudante'];
  $seg_ayudante = $row_inter['seg_ayudante'];
  $ter_ayudante = $row_inter['ter_ayudante'];
  $anestesiologo = $row_inter['anestesiologo'];
  $resid_anest = $row_inter['resid_anest'];
  $circulante = $row_inter['circulante'];
  $instrumentista = $row_inter['instrumentista'];
  $quir = $row_inter['quir'];
  $hora_llegada_quir = $row_inter['hora_llegada_quir'];


$hora_salida_quir = $row_inter['hora_salida_quir'];
  $hora_entrada_recup = $row_inter['hora_entrada_recup'];
  $hora_salida_recup = $row_inter['hora_salida_recup'];
  $nota_preop = $row_inter['nota_preop'];
  $estado_postop = $row_inter['estado_postop'];
  $comentario_final = $row_inter['comentario_final'];
  $descripcion_op = $row_inter['descripcion_op'];
  $nombre_med_cir = $row_inter['nombre_med_cir'];
   $tipo_a = $row_inter['tipo_a'];
  
}
 
//CONSULTA POSTOPERATORIA
$sql_posto = "SELECT * FROM dat_not_postop po, dat_ingreso din where po.id_not_postp=$id_postp and din.id_atencion = po.id_atencion";
$result_posto = $conexion->query($sql_posto);

while ($row_posto = $result_posto->fetch_assoc()) {
$diag_preop = $row_posto['diag_preop'];
$diag_postop = $row_posto['diag_postop'];
$cir_progra = $row_posto['cir_progra'];
$cir_real = $row_posto['cir_real'];
$cirujano = $row_posto['cirujano'];

$ayud1 = $row_posto['ayud1'];
$ayud2 = $row_posto['ayud2'];
$ayud3 = $row_posto['ayud3'];
$anest = $row_posto['anest'];
$inst = $row_posto['inst'];
$circu = $row_posto['circu'];

  $sang = $row_posto['sang'];
  $complic = $row_posto['complic'];
  $in_ac = $row_posto['in_ac'];
  $cuent_tex = $row_posto['cuent_tex'];
  $biops = $row_posto['biops'];
  $envio = $row_posto['envio'];
  $hallazgos = $row_posto['hallazgos'];
  $estado_post = $row_posto['estado_post'];

  $exp_fis = $row_posto['exp_fis'];
  $ten_sist = $row_posto['ten_sist'];
  $ten_diast = $row_posto['ten_diast'];
  $frec = $row_posto['frec'];
  $frecresp = $row_posto['frecresp'];
  $tempera = $row_posto['tempera'];
  $lab = $row_posto['lab'];
  $tec = $row_posto['tec'];
  $plan_tera = $row_posto['plan_tera'];

  $pron = $row_posto['pron'];
  $resum_clin = $row_posto['resum_clin'];
  $fecha_post = $row_posto['fecha_post'];
 
  
}
//TERMINO CONSULTA POSTOPERATORIA


$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);
$pdf->SETX(35);
$pdf->MultiCell(150, 6, utf8_decode('NOTA POSTOPERATORIA'), 0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);

$pdf->Cell(198, 6, utf8_decode('SERVICIO: ' . $tipo_a), 1,0, 'L');
$pdf->Ln(6);
$pdf->Cell(132, 6, utf8_decode('FECHA Y HORA: ' . $fecha_post), 1,0, 'L');
$pdf->Cell(66, 6, utf8_decode('NÚMERO DE EXPEDIENTE: ' . $Id_exp) , 1,1, 'C');

$pdf->SetFont('Arial', '', 8);

$pdf->Cell(132, 6, utf8_decode('NOMBRE DEL PACIENTE: ' . $papell . ' ' . $sapell . ' ' . $nom_pac), 1,0, 'L');
$pdf->Cell(33, 6, utf8_decode('EDAD: '  . $edad), 1, 'L');
$pdf->Cell(33, 6, utf8_decode('SEXO: ' . $sexo), 1, 'C');

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(198, 5, utf8_decode('DIAGNÓSTICO PREOPERATORIO: ' .$diag_preop), 1, 0, 'L');


$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(198, 5, utf8_decode('DIAGNÓSTICO POSTOPERATORIO: ' .$diag_postop), 1, 0, 'L');


$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(99, 5, utf8_decode('CIRUGÍA PROGRAMADA: ' .$cir_progra), 1, 0, 'L');
$pdf->Cell(99, 5, utf8_decode('CIRUGÍA REALIZADA: '. $cir_realizada), 1, 0, 'L');


$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(198, 5, utf8_decode('CIRUJANO: ' .$cirujano), 1, 0, 'L');


$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(99, 5, utf8_decode('AYUDANTES: '), 0, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(198, 6, utf8_decode('AYUDANTE 1: '. $ayud1 ), 1,1, 'L');
$pdf->Cell(198, 6, utf8_decode('AYUDANTE 2: '.$ayud2), 1,1, 'L');
$pdf->Cell(198, 6, utf8_decode('AYUDANTE 3: '.$ayud3 ), 1, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(99, 5, utf8_decode('ANESTESIÓLOGO: '), 1, 0, 'L');
$pdf->Cell(99, 5, utf8_decode('INSTRUMENTISTA: '), 1, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(99, 6, utf8_decode($anest), 1, 'L');
$pdf->Cell(99, 6, utf8_decode($inst), 1, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(99, 5, utf8_decode('CIRCULANTE: '), 1, 0, 'L');
$pdf->Cell(99, 5, utf8_decode('SANGRADO: '), 1, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(99, 6, utf8_decode($circu), 1, 'L');
$pdf->Cell(99, 6, utf8_decode($sang), 1, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(99, 5, utf8_decode('COMPLICACIONES: '), 1, 0, 'L');
$pdf->Cell(99, 5, utf8_decode('INCIDENTES Y ACCIDENTES: '), 1, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(99, 6, utf8_decode($complic), 1, 'L');
$pdf->Cell(99, 6, utf8_decode($in_ac), 1, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(99, 5, utf8_decode('CUENTA DE TEXTILES Y MATERIAL: '), 1, 0, 'L');
$pdf->Cell(99, 5, utf8_decode('BIOPSIA ESTUDIOS TRANSOPERATORIOS: '), 1, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(99, 6, utf8_decode($cuent_tex), 1, 'L');
$pdf->Cell(99, 6, utf8_decode($biops), 1, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(99, 5, utf8_decode('ENVÍO DE PIEZAS A PATOLOGÍA: '), 1, 0, 'L');
$pdf->Cell(99, 5, utf8_decode('HALLAZGOS: '), 1, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(99, 6, utf8_decode($envio), 1, 'L');
$pdf->Cell(99, 6, utf8_decode($hallazgos), 1, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(49, 5, utf8_decode('TENSIÓN ARTERIAL: '), 1, 0, 'L');
$pdf->Cell(50, 5, utf8_decode('FRECUENCIA CARDIACA: '), 1, 0, 'L');
$pdf->Cell(60, 5, utf8_decode('FRECUENCIA RESPIRATORIA: '), 1, 0, 'L');
$pdf->Cell(39, 5, utf8_decode('TEMPERATURA: '), 1, 0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(49, 6, utf8_decode($ten_sist. ' / ' .$ten_diast), 1, 'L');
$pdf->Cell(50, 6, utf8_decode($frec), 1, 'L');
$pdf->Cell(60, 6, utf8_decode($frecresp), 1, 'L');
$pdf->Cell(39, 6, utf8_decode($tempera), 1, 'L');

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(198, 5, utf8_decode('TÉCNICA: ' .$tec), 1, 0, 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(198, 5, utf8_decode('PLAN TERAPÉUTICO: ' .$plan_tera ), 1, 0, 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(198, 5, utf8_decode('PRONÓSTICO: ' .$pron), 1, 0, 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(198, 5, utf8_decode('RESUMEN CLÍNICO: ' .$resum_clin ), 1, 'L');



$sql_med_id = "SELECT id_usua FROM dat_not_postop WHERE id_not_postp = $id_postp";

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