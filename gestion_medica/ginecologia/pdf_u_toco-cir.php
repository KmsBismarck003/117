<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

$sql_nota = "SELECT * from u_toco_cir where id_atencion = $id_atencion";
$result_nota = $conexion->query($sql_nota);
$no = 1;
while ($row_nota = $result_nota->fetch_assoc()) {
  $id_toco_cir = $row_nota['id_toco_cir'];
  }

if(isset($id_toco_cir)){
    $id_toco_cir = $id_toco_cir;
  }else{
    $id_toco_cir ='sin doc';
  }

if($id_toco_cir=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE NOTA DE TOCO-CIRUGÍA PARA ESTE PACIENTE", 
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

    $id = @$_GET['id'];

    $this->Image('../../imagenes/logo PDF.jpeg', 10, 10, 28, 30);
    $this->SetFont('Arial', 'B', 14);
    $this->Cell(280, 8, 'Sanatorio Venecia', 0, 0, 'C');
    $this->Ln(10);
    $this->SetDrawColor(0, 0, 0);
    $this->Line(90, 20, 200, 20);
    $this->Line(90, 21, 200, 21);
    $this->SetFont('Arial', '', 10);
    $this->Cell(280, 8, 'PASEO TOLLOCAN NO. 113 COL. UNIVERSIDAD', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(280, 8, utf8_decode('C.P. 50130 TOLUCA, MÉX'), 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(280, 8, 'TEL.: (01 722) 280 5672', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(280, 8, 'www.sanatoriovenecia.com.mx', 0, 0, 'C');
    $this->Ln(10);
    $this->Image('../../imagenes/logo PDF 2.jpg', 240, 20, 40, 20);
  }
  function Footer()
  {
    include '../../conexionbd.php';

    $this->Ln(5);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->SetX(200);
    $this->Cell(85, 5, date('d/m/Y'), 0, 1, 'R');
  }

  function myCell($w, $h, $x, $t)
  {
    $height = $h / 3;
    $first = $height + 2;
    $second = $height + $height + $height + 3;
    $len = strlen($t);
    if ($len > 13) {
      $txt = str_split($t, 13);
      $this->SetX($x);
      $this->Cell($w, $first, $txt[0], '', '', 'C');
      $this->SetX($x);
      $this->Cell($w, $second, $txt[1], '', '', 'C');
      $this->SetX($x);
      $this->Cell($w, $h, '', 'LTRB', 0, 'C', 0);
    } else {
      $this->SetX($x);
      $this->Cell($w, $h, $t, 'LTRB', 0, 'C', 0);
    }
  }
}


function calculaedad($fechanacimiento)
{
  list($ano, $mes, $dia) = explode("-", $fechanacimiento);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($dia_diferencia < 0 || $mes_diferencia < 0)
    $ano_diferencia--;
  return $ano_diferencia;
}


$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.fecha, di.area, di.alta_med, p.sexo, p.tip_san  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
  $ced_p = $row_med['cedp'];
}




$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(280, 5, utf8_decode('UNIDAD TOCO-CIRUGÍA'), 1, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(280, 5, utf8_decode('NOMBRE: ' . $pac_nom), 1, 0, 'L');
$pdf->Ln(5);
$pdf->Cell(70, 5, utf8_decode('FECHA DE NACIMIENTO: ' . date_format($date, "d/m/Y")), 1, 0, 'L');
$pdf->Cell(70, 5, utf8_decode('EXPEDIENTE: ' . $id_exp), 1, 0, 'L');
$pdf->Cell(70, 5, utf8_decode('EDAD: ' . $edad), 1, 0, 'L');
$pdf->Cell(70, 5, utf8_decode('TIPO SANG./R.H.: ' . $tipo_sang), 1, 0, 'L');

$pdf->Ln(10);
$w = 25;
$h = 10;

$x = $pdf->GetX();
$pdf->myCell($w, $h, $x, 'HORAS DE     LABOR');
$x = $pdf->GetX();
$pdf->myCell($w, $h, $x, 'FECHA');
$x = $pdf->GetX();
$pdf->myCell($w, $h, $x, 'F.C.R.');
$x = $pdf->GetX();
$pdf->myCell($w, $h, $x, 'F.C. FETAL');
$x = $pdf->GetX();
$pdf->myCell(27, $h, $x, 'CONTRACIONES  EN 10/MIN.');
$x = $pdf->GetX();
$pdf->myCell($w, $h, $x, '   MU /         OXITOCINA');
$x = $pdf->GetX();
$pdf->myCell($w, $h, $x, 'T.A.');
$x = $pdf->GetX();
$pdf->myCell($w, $h, $x, 'PULSO');
$x = $pdf->GetX();
$pdf->myCell($w, $h, $x, 'TEMP');
$x = $pdf->GetX();
$pdf->myCell($w, $h, $x, utf8_decode('DILATACIÓN'));
$x = $pdf->GetX();
$pdf->myCell(28, $h, $x, utf8_decode('ALTURA DE    PRESENTACIÓN'));
$pdf->Ln(10);


$sql_nota = "SELECT * from u_toco_cir where id_atencion = $id_atencion";
$result_nota = $conexion->query($sql_nota);
$no = 1;
while ($row_nota = $result_nota->fetch_assoc()) {
  $fecha = $row_nota['fecha'];
  $frec_car = $row_nota['frec_car'];
  $frec_car_fet = $row_nota['frec_car_fet'];
  $contracciones = $row_nota['contracciones'];
  $mu_oxitocina = $row_nota['mu_oxitocina'];
  $p_sistolica = $row_nota['p_sistolica'];
  $p_diastolica = $row_nota['p_diastolica'];
  $pulso = $row_nota['pulso'];
  $temp = $row_nota['temp'];
  $dilatacion = $row_nota['dilatacion'];
  $a_presentacion = $row_nota['a_presentacion'];



  $x = $pdf->GetX();
  $pdf->myCell($w, $h, $x, $no);
  $x = $pdf->GetX();
  $pdf->myCell($w, $h, $x, $fecha);
  $x = $pdf->GetX();
  $pdf->myCell($w, $h, $x, $frec_car);
  $x = $pdf->GetX();
  $pdf->myCell($w, $h, $x, $frec_car_fet);
  $x = $pdf->GetX();
  $pdf->myCell(27, $h, $x, $contracciones);
  $x = $pdf->GetX();
  $pdf->myCell($w, $h, $x, $mu_oxitocina);
  $x = $pdf->GetX();
  $pdf->myCell($w, $h, $x, $p_sistolica . ' / ' . $p_diastolica);
  $x = $pdf->GetX();
  $pdf->myCell($w, $h, $x, $pulso);
  $x = $pdf->GetX();
  $pdf->myCell($w, $h, $x, $temp);
  $x = $pdf->GetX();
  $pdf->myCell($w, $h, $x, utf8_decode($dilatacion));
  $x = $pdf->GetX();
  $pdf->myCell(28, $h, $x, utf8_decode($a_presentacion));
  $pdf->Ln(10);


  $no++;
}





/*

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 5, utf8_decode('NOMBRE Y FIRMA DEL MÉDICO'), 0, 0, 'C');
$pdf->Ln(6);
$pdf->Image('../../imgfirma/' . $firma, 95, $pdf->GetY(), 30, 10);
$pdf->Ln(10);
$pdf->Cell(200, 5, utf8_decode($pre . '. ' . $app . ' ' . $apm . ' ' . $nom), 0, 0, 'C');
$pdf->Ln(6);
$pdf->Cell(200, 5, utf8_decode('Céd. Prof.: ' . $ced_p), 0, 0, 'C');
*/
$pdf->Output();
}