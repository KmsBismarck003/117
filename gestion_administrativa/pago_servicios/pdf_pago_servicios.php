<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_cta = @$_GET['id_cta'];


mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    include '../../conexionbd.php';

    $id = @$_GET['id'];;

    include '../../conexionbd.php';
    $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
    while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 8, 48, 28);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],58,15, 109, 24);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 168, 16, 38, 14);
  }
   $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
 
    $this->Ln(10);
    
    
    $this->Ln(4);
 
    $this->Ln(4);
    
    $this->Ln(4);
    
    $this->Ln(10);
 }
}

$date = date("d/m/Y");
$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 180);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SETX(35);
$pdf->MultiCell(150, 6, utf8_decode('RECIBO DE PAGO SERVICIOS'), 0, 'C');
//$pdf->Ln(1);
$pdf->SetFont('Arial', '', 7);

$sql_cta = "SELECT * FROM cta_pagada_serv where id_cta_pag_serv = $id_cta Order By fecha_cierre";
$result_cta = $conexion->query($sql_cta);

while ($row_cta = $result_cta->fetch_assoc()) {
  $nombre=$row_cta['nombre'];
  $id_pac=$row_cta['id_atencion'];
  $tipo = $row_cta['tipo'];
}
$sql_cta = "SELECT * FROM depositos_pserv where id_pac = $id_pac and tipo ='$tipo' ";
$result_cta = $conexion->query($sql_cta);

while ($row_cta = $result_cta->fetch_assoc()) {
  $nom_pag=$row_cta['responsable'];
  $id_usua=$row_cta['id_usua'];
}
$pdf->SetFont('Arial', 'B', 7);
$pdf->cell(30,6,utf8_decode('RECIBO:  '.$id_cta),1,'L');
$pdf->cell(167,6,utf8_decode('USUARIO:  '.$id_pac.' - '.$nombre),1,'L');
$pdf->SetFont('Arial', '', 7);
$pdf->ln(8);

$pdf->SetFont('Arial', 'B', 7);
$pdf->cell(5,6,utf8_decode('No.'),1,'L');
$pdf->cell(25,6,utf8_decode('FECHA'),1,'L');
$pdf->cell(100,6,utf8_decode('SERVICIO'),1,'L');
$pdf->cell(17,6,utf8_decode('CANTIDAD'),1,'L');
$pdf->cell(25,6,utf8_decode('PRECIO'),1,'L');
$pdf->cell(25,6,utf8_decode('SUBTOTAL'),1,'L');
$pdf->ln(6);

$pdf->SetFont('Arial', '', 7);
$sql_cta = "SELECT * FROM pago_serv p where p.id_pac = $id_pac and p.tipo ='$tipo' and p.nombre = '$nombre' Order By fecha";
$result_cta = $conexion->query($sql_cta);
$no=1;
$total = 0;
while ($row_cta = $result_cta->fetch_assoc()) {
    $precio=$row_cta['precio']*1.16;
    $subtottal=$precio*$row_cta['cantidad'];
    $date=date_create($row_cta['fecha']);
    $pdf->cell(5,6,utf8_decode($no),1,'L');
    $pdf->cell(25,6,utf8_decode(date_format($date,"d-m-Y H:i")),1,'L');
    $pdf->cell(100,6,utf8_decode($row_cta['servicio']),1,'L');
    $pdf->cell(17,6,utf8_decode($row_cta['cantidad']),1,'L');
    $pdf->cell(25,6,utf8_decode('$'.number_format($precio,2)),1,0,'R');
    $pdf->cell(25,6,utf8_decode('$'.number_format($subtottal,2)),1,0,'R');
    $tot_cta= $subtottal + $tot_cta;
    $no++;
    $pdf->ln(6);
}


$pdf->SetX(157);
$pdf->cell(50,6,utf8_decode('TOTAL SERVICIOS: '.'$'.number_format($tot_cta,2).' MXN'),1,0,'R');
$pdf->ln(2);


/* DESCUENTOS */
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->ln(5);
    $pdf->cell(5,6,utf8_decode('No.'),1,'L');
    $pdf->cell(25,6,utf8_decode('FECHA'),1,'L');
    $pdf->cell(42,6,utf8_decode('TIPO'),1,'L');
    $pdf->cell(100,6,utf8_decode('DETALLE'),1,'L');
    $pdf->cell(25,6,utf8_decode('DESCUENTO'),1,'L');
    $pdf->ln(6);

    $pdf->SetFont('Arial', '', 7);
    $sql_cta = "SELECT * FROM depositos_pserv m where m.id_pac=$id_pac and m.tipo ='$tipo' and tipo_pago = 'DESCUENTO'";
    $result_cta = $conexion->query($sql_cta);
    $no=1;
    $tot_pag = 0;
    while ($row_cta = $result_cta->fetch_assoc()) {
        $pdf->cell(5,6,utf8_decode($no),1,'L');
        $date=date_create($row_cta['fecha']);
        $pdf->cell(25,6,utf8_decode(date_format($date,"d-m-Y H:i:s")),1,'L');
        $pdf->cell(42,6,utf8_decode($row_cta['tipo_pago']),1,'L');
        $pdf->cell(100,6,utf8_decode($row_cta['responsable']),1,'L');
        
        $pdf->cell(25,6,utf8_decode('$'.number_format($row_cta['deposito'],2)),1,0,'R');
        $tot_pag = $row_cta['deposito'] + $tot_pag;
        $no++;
        $pdf->ln(6);
    }
    $pdf->SetX(157);
    $pdf->cell(50,6,utf8_decode('DESCUENTOS : '.'$'.number_format($tot_pag,2).' MXN'),1,0,'R');
    $pdf->ln(3);

/* PAGO */
$sql_cta = "SELECT * FROM depositos_pserv d where d.id_pac = $id_pac and d.tipo ='$tipo'";
$result_cta = $conexion->query($sql_cta);

while ($row_cta = $result_cta->fetch_assoc()) {
    $nom_pag=$row_cta['responsable'];
    $id_usua=$row_cta['id_usua'];

/* PAGOS */
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->ln(5);
    $pdf->cell(5,6,utf8_decode('No.'),1,'L');
    $pdf->cell(25,6,utf8_decode('FECHA'),1,'L');
    $pdf->cell(42,6,utf8_decode('TIPO DE PAGO'),1,'L');
    $pdf->cell(100,6,utf8_decode('DETALLE'),1,'L');
    
    $pdf->cell(25,6,utf8_decode('PAGOS'),1,'L');
    $pdf->ln(6);

    $pdf->SetFont('Arial', '', 7);
    $sql_cta = "SELECT * FROM depositos_pserv m where m.id_pac=$id_pac and m.tipo ='$tipo' and tipo_pago != 'DESCUENTO'";
    $result_cta = $conexion->query($sql_cta);
    $no=1;
    $tot_pag = 0;
    while ($row_cta = $result_cta->fetch_assoc()) {
        $pdf->cell(5,6,utf8_decode($no),1,'L');
        $date=date_create($row_cta['fecha']);
        $pdf->cell(25,6,utf8_decode(date_format($date,"d-m-Y H:i:s")),1,'L');
        $pdf->cell(42,6,utf8_decode($row_cta['tipo_pago']),1,'L');
        $pdf->cell(100,6,utf8_decode($row_cta['responsable']),1,'L');
        
        $pdf->cell(25,6,utf8_decode('$'.number_format($row_cta['deposito'],2)),1,0,'R');
        $tot_pag = $row_cta['deposito'] + $tot_pag;
        $no++;
        $pdf->ln(6);
    }
    $pdf->SetX(157);
    $pdf->cell(50,6,utf8_decode('TOTAL DE LA CUENTA : '.'$'.number_format($tot_pag,2).' MXN'),1,0,'R');
    $pdf->ln(3);
}

    $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_usua";
    $result_med = $conexion->query($sql_med);
    while ($row_med = $result_med->fetch_assoc()) {
      $admin=$row_med['papell'].' '.$row_med['sapell'];
    }
$pdf->ln(10);
$pdf->SetX(10);
$pdf->cell(75,7,utf8_decode(''),0, 0,'C');
$pdf->SetX(115);
$pdf->cell(75,7,utf8_decode($admin),0,0,'C');
$pdf->ln(2);
$pdf->SetX(15);
$pdf->cell(75,7,utf8_decode(''),'B','L');
$pdf->SetX(115);
$pdf->cell(75,7,utf8_decode(''),'B','L');
$pdf->ln(7);
$pdf->SetX(10);
$pdf->cell(75,7,utf8_decode('RESPONSABLE'),0,0,'C');
$pdf->SetX(115);
$pdf->cell(75,7,utf8_decode('RECIBIÓ'),0,0,'C');
$pdf->ln(8);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 8, utf8_decode('PÁGINA: ' . $pdf->PageNo() . '/{nb}'), 0, 0, 'C');
$pdf->Cell(0, 10, utf8_decode('SIMA-066'), 0, 1, 'R');

$pdf->Output();