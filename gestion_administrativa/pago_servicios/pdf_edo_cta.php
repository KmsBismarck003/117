<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_pac = @$_GET['id_pac'];
$tipo = @$_GET['tipo'];


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
$pdf->MultiCell(150, 6, utf8_decode('ESTADO DE CUENTA (CONSULTA)'), 0, 'C');
//$pdf->Ln(1);
$pdf->SetFont('Arial', '', 7);

$sql_cta = "SELECT * from pago_serv where id_pac = $id_pac and tipo = '$tipo' ";
$result_cta = $conexion->query($sql_cta);

while ($row_cta = $result_cta->fetch_assoc()) {
  $nombre=$row_cta['nombre'];
}
/*
$sql_total = "SELECT * FROM depositos_pserv where id_pac = $id_pac and tipo ='Consulta' ";
$result_total = $conexion->query($sql_total);

while ($row_total = $result_total->fetch_assoc()) {
  $total_dep = $row_total['deposito'] + $total_dep;
  $nom_pag=$row_cta['responsable'];
  $id_usua=$row_cta['id_usua'];
}
*/

$pdf->cell(30,6,utf8_decode('FOLIO:  '.$id_pac),1,'L');
$pdf->cell(167,6,utf8_decode('USUARIO:  '.$nombre),1,'L');

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
$resultado3 = $conexion->query("SELECT * from pago_serv p, cat_servicios c where p.id_pac=$id_pac and c.id_serv=p.id_serv and (c.id_serv!=1472) and p.activo='SI' and p.tipo = 'Consulta' ") or die($conexion->error);

$no = 1;
while ($row_cta= $resultado3->fetch_assoc()) {
    $fecha=date_create($row_cta['fecha']);
    $precio = $row_cta['serv_costo'] * 1.16;
    $subtottal=$precio*$row_cta['cantidad'];

    $pdf->cell(5,6,utf8_decode($no),1,'L');
    $date=date_create($row_cta['fecha']);
    $pdf->cell(25,6,utf8_decode(date_format($date,"d-m-Y H:i")),1,'L');
    $pdf->cell(100,6,utf8_decode($row_cta['servicio']),1,'L');
    $pdf->cell(17,6,utf8_decode($row_cta['cantidad']),1,'L');
    $pdf->cell(25,6,utf8_decode('$'.number_format($precio,2)),1,0,'R');
    $pdf->cell(25,6,utf8_decode('$'.number_format($subtottal,2)),1,0,'R');
    $total= $subtottal + $total;
    $no++;
    $pdf->ln(6);
}

$pdf->SetX(157);
$pdf->cell(50,6,utf8_decode('TOTAL : '.'$'.number_format($total,2).' MXN'),1,0,'R');
$pdf->ln(2);

/*
$sql_cta = "SELECT * FROM depositos_pserv d where d.id_pac = $id_pac and d.tipo ='$tipo'";
$result_cta = $conexion->query($sql_cta);

while ($row_cta = $result_cta->fetch_assoc()) {
    $nom_pag=$row_cta['responsable'];
    $id_usua=$row_cta['id_usua'];


    $pdf->SetFont('Arial', 'B', 7);
    $pdf->ln(5);
    $pdf->cell(5,6,utf8_decode('No.'),1,'L');
    $pdf->cell(25,6,utf8_decode('FECHA'),1,'L');
    $pdf->cell(100,6,utf8_decode('RESPONSABLE'),1,'L');
    $pdf->cell(42,6,utf8_decode('TIPO'),1,'L');
    $pdf->cell(25,6,utf8_decode('MONTO'),1,'L');
    $pdf->ln(6);

    $pdf->SetFont('Arial', '', 7);
    $sql_cta = "SELECT * FROM depositos_pserv m where m.id_pac=$id_pac and m.tipo ='$tipo'";
    $result_cta = $conexion->query($sql_cta);
    $no=1;
    $total = 0;
    while ($row_cta = $result_cta->fetch_assoc()) {
        $pdf->cell(5,6,utf8_decode($no),1,'L');
        $date=date_create($row_cta['fecha']);
        $pdf->cell(25,6,utf8_decode(date_format($date,"d-m-Y H:i:s")),1,'L');
        $pdf->cell(100,6,utf8_decode($row_cta['responsable']),1,'L');
        $pdf->cell(42,6,utf8_decode($row_cta['tipo_pago']),1,'L');
        $pdf->cell(25,6,utf8_decode('$'.number_format($row_cta['deposito'],2)),1,0,'R');
        $total= $row_cta['deposito'] + $total;
        $no++;
        $pdf->ln(6);
    }
    $pdf->SetX(157);
    $pdf->cell(50,6,utf8_decode('TOTAL : '.'$'.number_format($total,2).' MXN'),1,0,'R');
    $pdf->ln(3);
}
    $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_usua";
    $result_med = $conexion->query($sql_med);
    while ($row_med = $result_med->fetch_assoc()) {
      $admin=$row_med['papell'].' '.$row_med['sapell'];
    }
$pdf->ln(10);
$pdf->SetX(10);
$pdf->cell(75,7,utf8_decode($nom_pag),0, 0,'C');
$pdf->SetX(115);
$pdf->cell(75,7,utf8_decode($admin),0,0,'C');
$pdf->ln(2);
$pdf->SetX(15);
$pdf->cell(75,7,utf8_decode(''),'B','L');
$pdf->SetX(115);
$pdf->cell(75,7,utf8_decode(''),'B','L');
$pdf->ln(7);
$pdf->SetX(10);
$pdf->cell(75,7,utf8_decode('RESPONSABLE DE PAGO'),0,0,'C');
$pdf->SetX(115);
$pdf->cell(75,7,utf8_decode('PERSONAL'),0,0,'C');
$pdf->ln(8);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 8, utf8_decode('PÁGINA: ' . $pdf->PageNo() . '/{nb}'), 0, 0, 'C');
$pdf->Cell(0, 10, utf8_decode('SIMA-066'), 0, 1, 'R');*/

$pdf->Output();