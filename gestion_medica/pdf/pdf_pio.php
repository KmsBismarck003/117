<?php
use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_in=@$_GET['id'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

$sql_tras = "SELECT * from pio_examen where id_exp=$id_exp";
$result_tras = $conexion->query($sql_tras);

while ($row_tras = $result_tras->fetch_assoc()) {
  $id = $row_tras['id'];
}

if(isset($id)){
    $id = $id;
  }else{
    $id ='sin doc';
  }

if($id=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE NOTA PARA ESTE PACIENTE", 
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

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 9, 40, 25);
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
     $this->Cell(0, 10, utf8_decode('INEO-000'), 0, 1, 'R');
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
    $id_usua = $row_preop['id_usua'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,32);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(55);
$pdf->SetTextColor(43, 45, 127);
$pdf->Cell(110, 9, utf8_decode('NOTA PRESION INTRAOCULAR'), 1, 0, 'C');
$pdf->SetX(160);
$pdf->SetFont('Arial', '', 6);
date_default_timezone_set('America/Mexico_City');
$date1 = date_create(date("Y-m-d H:i:s"));
$pdf->Cell(35, 9, 'FECHA: ' . date_format($date1,"d/m/Y H:i"), 0, 1, 'R');
$pdf->Ln(5);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 207, 53);
$pdf->Line(8, 53, 8, 80);
$pdf->Line(207, 53, 207, 80);
$pdf->Line(8, 80, 207, 80);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, 'Servicio: ',0 , 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 5, utf8_decode($tipo_a) , 'B',0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 5, utf8_decode('Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 5, date_format($date,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, utf8_decode('Paciente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(180, 5, utf8_decode($folio. ' - '. $papell . ' ' . $sapell . ' ' . $nom_pac),'B' , 0, 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$date1=date_create($fecnac);
$pdf->Cell(31, 5, 'Fecha de nacimiento: ', 0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 5, date_format($date1,"d/m/Y"),'B' , 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 5, ' Edad: ', 0 , 0, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(13, 5, utf8_decode($edad), 'B' , 0, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(19, 5, utf8_decode(' Ocupación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(36, 5,  utf8_decode($ocup), 'B', 0,'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 5, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 5,  utf8_decode($tel), 'B',0, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 5, utf8_decode('Género: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 5,  $sexo, 'B', 0,'L');
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
$pdf->Cell(14, 5,  utf8_decode($pesoh.' Kilos'), 'B', 0,'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 5, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 5,  utf8_decode($tallah.' Metros'), 'B', 0,'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 5, utf8_decode(' Domicilio: '), 0, 0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(125, 5, utf8_decode($dir), 'B', 0,'L');

$pdf->Ln(11);

// Consultar datos de PIO
$sql_pio = "SELECT * FROM pio_examen WHERE id_atencion = $id_atencion AND Id_exp = $id_exp LIMIT 1";
$result_pio = $conexion->query($sql_pio);

if ($row_pio = $result_pio->fetch_assoc()) {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 6, utf8_decode('Presión Intraocular (PIO)'), 1, 1, 'C');

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(70, 6, '', 1);
    $pdf->Cell(60, 6, 'Ojo Derecho', 1, 0, 'C');
    $pdf->Cell(60, 6, 'Ojo Izquierdo', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(70, 6, 'PIO Aplanacion Previa', 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['pio_aplanacion_previa_OD']), 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['pio_aplanacion_previa_OI']), 1, 1);

    $pdf->Cell(70, 6, 'PIO TnG Previa', 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['pio_tng_previa_OD']), 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['pio_tng_previa_OI']), 1, 1);

    $pdf->Cell(70, 6, 'PIO Aplanacion', 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['pio_aplanacion_OD']), 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['pio_aplanacion_OI']), 1, 1);

    $pdf->Cell(70, 6, 'Tipo TnC', 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['pio_tnc_tipo_OD']), 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['pio_tnc_tipo_OI']), 1, 1);

    $pdf->Cell(70, 6, 'PIO TnC', 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['pio_tnc_OD']), 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['pio_tnc_OI']), 1, 1);

    $pdf->Cell(70, 6, 'Tratamiento', 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['tratamiento_pio_OD']), 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['tratamiento_pio_OI']), 1, 1);

    $pdf->Cell(70, 6, 'Correlacion Paquimetrica', 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['correlacion_paquimetrica_OD']), 1);
    $pdf->Cell(60, 6, utf8_decode($row_pio['correlacion_paquimetrica_OI']), 1, 1);

    $pdf->Cell(190, 6, utf8_decode('Registrado en: ' . $row_pio['creado_en']), 1, 1, 'R');
}


/*$sql_med_id = "SELECT id_usua FROM ninobebe WHERE id_atencion = $id_atencion ORDER by id DESC LIMIT 1";
    $result_med_id = $conexion->query($sql_med_id);

    while ($row_med_id = $result_med_id->fetch_assoc()) {
      $id_med = $row_med_id['id_usua'];
    }
    
    */
    $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_usua";
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
     
// --- Firma del médico (centrada y válida)
$pdf->Ln(20);
$pdf->SetFont('Arial', 'B', 7);

// Verifica si hay firma cargada
$firma_path = (!empty($firma) && file_exists('../../imgfirma/' . $firma))
    ? '../../imgfirma/' . $firma
    : '../../imgfirma/FIRMA.jpg';

$pdf->Image($firma_path, 90, 240, 30);

// Texto debajo de la firma
$pdf->SetY(253);
$pdf->SetFont('Arial', 'B', 7);

// Usamos ancho 210 para que esté centrado horizontalmente en la hoja
$pdf->Cell(194, 4, utf8_decode($pre . '. ' . $app . ' ' . $apm), 0, 1, 'C');
$pdf->Cell(194, 4, utf8_decode($cargp . ' - Céd. Prof. ' . $ced_p), 0, 1, 'C');
$pdf->Cell(194, 4, utf8_decode('Nombre y firma del médico'), 0, 1, 'C');



$pdf->Output();
}