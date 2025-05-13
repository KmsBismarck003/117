<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';



mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
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
    $this->Image('../../imagenes/logo PDF 2.jpg', 160, 20, 40, 20);
  }
}

 


$anio = @$_POST['anio'];
$diagn = @$_POST['diag'];
$mes = @$_POST['mes'];

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
 if ($mes==1) {
    $mess='ENERO';
  }

 if ($mes==2) {
    $mess='FEBRERO';
  }
   if ($mes==3) {
    $mess='MARZO';
  }
 if ($mes==4) {
    $mess='ABRIL';
  }
  if ($mes==5) {
    $mess='MAYO';
  }
   if ($mes==6) {
    $mess='JUNIO';
  }
   if ($mes==7) {
    $mess='JULIO';
  }
   if ($mes==8) {
    $mess='Agosto';
  }
   if ($mes==9) {
    $mess='SEPTIMBRE';
  }
   if ($mes==10) {
    $mess='OCTUBRE';
  }
   if ($mes==11) {
    $mess='NOVIEMBRE';
  }
   if ($mes==12) {
    $mess='DICIEMBRE';
  }

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX(25);
$pdf->Cell(150, 5, utf8_decode('REPORTE ADMINISTRATIVO MENSUAL'), 1, 0, 'C');
$pdf->Ln(11);

$pdf->Cell(30, 11, utf8_decode($mess.' '.$anio),0, 'L');
$pdf->Ln(11);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(10, 9, utf8_decode('#'), 1, 'L');
$pdf->Cell(80, 9, utf8_decode('NOMBRE DEL PACIENTE'), 1, 'L');
$pdf->Cell(30, 9, utf8_decode('DEPOSITOS'), 1, 'L');
$pdf->Cell(30, 9, utf8_decode('TOTAL'), 1, 'L');
$pdf->Cell(40, 9, utf8_decode('TIPO'), 1, 'L');
$pdf->Ln(9);
$pdf->SetFont('Arial', '', 7);

$sql_tabla = "SELECT di.*,p.*,df.*,COUNT(df.id_atencion) as cuantos, SUM(deposito) as total FROM dat_financieros df,dat_ingreso di, paciente p WHERE p.Id_exp=di.Id_exp and di.id_atencion=df.id_atencion and MONTH(df.fecha)=$mes and YEAR(df.fecha)=$anio GROUP BY 1 HAVING COUNT(df.id_atencion)>=1 ORDER BY total DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
  
      $pdf->Cell(10, 7, utf8_decode($no), 1, 'L');
      $pdf->Cell(80, 7, utf8_decode($row_tabla['nom_pac'].' '.$row_tabla['papell'].' '.$row_tabla['sapell']), 1, 'L');
      $pdf->Cell(30, 7, utf8_decode($row_tabla['cuantos']), 1, 'L');
      $pdf->Cell(30, 7, utf8_decode('$'.number_format($row_tabla['total'],2)), 1, 'L');
      $pdf->Cell(40, 7, utf8_decode('HOSPITALIZACIÓN'), 1, 'L');
      $pdf->Ln(7);
      $total=$row_tabla['total'];
      $subtottal=$subtottal+$total;
      $no++;
    }
$sql_tabla = "SELECT DISTINCT(p.id_pac), p.nombre, m.* FROM pago_serv p , depositos_pserv m WHERE m.tipo='EFECTIVO' and m.id_pac=p.id_pac and MONTH(m.fecha)=$mes and YEAR(m.fecha)=$anio ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->Cell(10, 7, utf8_decode($no), 1, 'L');
      $pdf->Cell(80, 7, utf8_decode($row_tabla['nombre']), 1, 'L');
      $pdf->Cell(30, 7, utf8_decode('1'), 1, 'L');
      $pdf->Cell(30, 7, utf8_decode('$'.number_format($row_tabla['deposito'],2)), 1, 'L');
      $pdf->Cell(40, 7, utf8_decode('PAGO DE SERVICIOS'), 1, 'L');
      $pdf->Ln(7);
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }

    $sql_tabla = "SELECT DISTINCT(p.id_pac), p.nombre, m.* FROM pago_serv p , depositos_pserv m WHERE m.tipo='TRANSFERENCIA'  and p.id_pac=m.id_pac and MONTH(m.fecha)=$mes and YEAR(m.fecha)=$anio ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->Cell(10, 7, utf8_decode($no), 1, 'L');
      $pdf->Cell(80, 7, utf8_decode($row_tabla['nombre']), 1, 'L');
      $pdf->Cell(30, 7, utf8_decode('1'), 1, 'L');
      $pdf->Cell(30, 7, utf8_decode('$'.number_format($row_tabla['deposito'],2)), 1, 'L');
      $pdf->Cell(40, 7, utf8_decode('PAGO DE SERVICIOS'), 1, 'L');
      $pdf->Ln(7);
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }
    $sql_tabla_mpserv = "SELECT DISTINCT(p.id_pac), p.nombre, m.*  FROM pago_serv p , depositos_pserv m WHERE  m.tipo='TARJETA' and p.id_pac=m.id_pac and MONTH(m.fecha)=$mes and YEAR(m.fecha)=$anio ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla_mpserv);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->Cell(10, 7, utf8_decode($no), 1, 'L');
      $pdf->Cell(80, 7, utf8_decode($row_tabla['nombre']), 1, 'L');
      $pdf->Cell(30, 7, utf8_decode('1'), 1, 'L');
      $pdf->Cell(30, 7, utf8_decode('$'.number_format($row_tabla['deposito'],2)), 1, 'L');
      $pdf->Cell(40, 7, utf8_decode('PAGO DE SERVICIOS'), 1, 'L');
      $pdf->Ln(7);
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }
$pdf->Cell(190, 7, utf8_decode('TOTAL ANUAL : $'.number_format($subtottal,2)), 1, 'L');

   $pdf->Output();
