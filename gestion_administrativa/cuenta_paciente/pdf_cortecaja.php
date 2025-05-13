<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';

$anio = @$_POST['anio'];
$aniofinal = @$_POST['aniofinal'];
$fec_real = date("Y-m-d",strtotime($aniofinal."+ 1 day"));

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
    $this->Ln(35);
  }}
  function Footer()
  {
    $this->SetFont('Arial', '', 8);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, 'CMSI-7.02', 0, 1, 'R');
  }
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 127);

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX(25);
$pdf->Cell(150, 5, utf8_decode('REPORTE CORTE DE CAJA '), 1, 0, 'C');
$pdf->Ln(11);

$fechai = date_create($anio);
$fechai = date_format($fechai, "d/m/Y");
$fechaf = date_create($aniofinal);
$fechaf = date_format($fechaf, "d/m/Y");
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 11, utf8_decode('Periódo del   '). $fechai. '  al  ' . $fechaf ,0, 'L');
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(150, 5, utf8_decode('PAGOS EN EFECTIVO'), 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 8, utf8_decode('#'), 1, 'L');
$pdf->Cell(25, 8, utf8_decode('Fecha'), 1, 'L');
$pdf->Cell(100, 8, utf8_decode('Nombre del Paciente'), 1, 'L');
$pdf->Cell(20, 8, utf8_decode('Monto'), 1, 'L');
$pdf->Cell(12, 8, utf8_decode('Tipo'), 1, 'L');
$pdf->Cell(34, 8, utf8_decode('Método de Pago'), 1, 'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 7);

$sql_tabla = "SELECT DISTINCT(m.id_pac), p.nombre, m.* FROM pago_serv p, depositos_pserv m WHERE 
    m.id_pac=p.id_pac and 
    (p.fecha BETWEEN '$anio' AND '$fec_real') and 
    (tipo_pago != 'DESCUENTO' and tipo_pago != 'ASEGURADORA') ORDER BY nombre ASC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->Cell(6, 8, utf8_decode($no), 1, 'L');
      $pdf->Cell(25, 8, utf8_decode($row_tabla['fecha']), 1, 'L');
      $pdf->Cell(100, 8, utf8_decode($row_tabla['nombre']), 1, 'L');
      $pdf->Cell(20, 8, utf8_decode('$'.number_format($row_tabla['deposito'],2)), 1, 'L');
      $pdf->Cell(12, 8, utf8_decode('SERV'), 1, 'L');
      $pdf->Cell(34, 8, utf8_decode($row_tabla['tipo_pago']), 1, 'L');
      $pdf->Ln(8);
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }
    
    
    $sql_tabla = "SELECT DISTINCT(f.id_atencion), i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE 
        f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
        (f.fecha BETWEEN '$anio' AND '$fec_real') and 
        (banco != 'DESCUENTO' and banco != 'ASEGURADORA') ORDER BY p.nom_pac ASC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $pdf->Cell(6, 8, utf8_decode($no), 1, 'L');
      $pdf->Cell(25, 8, utf8_decode($row_tabla['fecha']), 1, 'L');
      $pdf->Cell(100, 8, utf8_decode($row_tabla['nom_pac'].' '.$row_tabla['papell'].' '.$row_tabla['sapell']), 1, 'L');
      $pdf->Cell(20, 8, utf8_decode('$'.number_format($row_tabla['deposito'],2)), 1, 'L');
      $pdf->Cell(12, 8, utf8_decode('HOSP'), 1, 'L');
      $pdf->Cell(34, 8, utf8_decode($row_tabla['banco']), 1, 'L');
      $pdf->Ln(8);
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }
$pdf->SetFont('Arial', 'B', 9);
$tot_efectivo = $subtottal;
$pdf->Cell(197, 8, utf8_decode('TOTAL : $'.number_format($subtottal,2)), 1, 'L');
$pdf->Ln(15);


$sql_tabla = "SELECT DISTINCT(p.id_pac), p.nombre, m.* FROM pago_serv p, depositos_pserv m WHERE m.tipo_pago='EFECTIVO' and m.id_pac=p.id_pac and (p.fecha BETWEEN '$anio' AND '$fec_real') AND p.tipo = m.tipo ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }
    $sql_tabla = "SELECT DISTINCT(f.id_atencion), i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
    (f.fecha BETWEEN '$anio' AND '$fec_real') and f.banco='EFECTIVO' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }
$tot_efectivo = $subtottal;



$sql_tabla_mpserv = "SELECT DISTINCT(p.id_pac), p.nombre, m.* FROM pago_serv p , depositos_pserv m WHERE m.tipo_pago='TARJETA' and m.id_pac=p.id_pac and (m.fecha BETWEEN '$anio' AND '$fec_real') AND p.tipo = m.tipo ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla_mpserv);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }
 $sql_tabla_ftc = "SELECT DISTINCT(f.id_atencion), i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and (f.fecha BETWEEN '$anio' AND '$fec_real')and f.banco='TARJETA' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla_ftc);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
      }$tot_tarjeta = $subtottal;


$sql_tabla_ftc = "SELECT DISTINCT(f.id_atencion), i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and (f.fecha BETWEEN '$anio' AND '$fec_real') and f.banco='ASEGURADORA' ORDER BY f.deposito DESC";
       $no=1;
  $subtottal=0;
  $total=0;
  $result_tabla = $conexion->query($sql_tabla_ftc);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
      }    

$tot_seguros = $subtottal;


$sql_tabla = "SELECT DISTINCT(p.id_pac), p.nombre, m.* FROM pago_serv p , depositos_pserv m WHERE m.tipo_pago='DEPOSITO' and m.id_pac=p.id_pac and(m.fecha BETWEEN '$anio' AND '$fec_real') AND p.tipo = m.tipo ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
  
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }

 $sql_tabla = "SELECT DISTINCT(f.id_atencion), i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
   (f.fecha BETWEEN '$anio' AND '$fec_real')and f.banco='DEPOSITO' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
 }  
$tot_deposito = $subtottal;


$sql_tabla = "SELECT DISTINCT(p.id_pac), p.nombre, m.* FROM pago_serv p , depositos_pserv m WHERE m.tipo_pago='TRANSFERENCIA' and m.id_pac=p.id_pac and(m.fecha BETWEEN '$anio' AND '$aniofinal') AND p.tipo = m.tipo ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }

 $sql_tabla = "SELECT DISTINCT(f.id_atencion), i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
   (f.fecha BETWEEN '$anio' AND '$fec_real')and f.banco='TRANSFERENCIA' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }$tot_transferencia = $subtottal;  

//descuento
$sql_tabla = "SELECT DISTINCT(p.id_pac), p.nombre, m.* FROM pago_serv p , depositos_pserv m WHERE m.tipo_pago='DESCUENTO' and m.id_pac=p.id_pac and(m.fecha BETWEEN '$anio' AND '$fec_real') AND p.tipo = m.tipo ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }

$sql_tabla = "SELECT DISTINCT(f.id_atencion), i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
   (f.fecha BETWEEN '$anio' AND '$fec_real')and f.banco='DESCUENTO' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $no++;
    }$descuentot = $subtottal; 


$pdf->Cell(33, 8, utf8_decode('EFECTIVO'), 1, 'L');
$pdf->Cell(33, 8, utf8_decode('TARJETA'), 1, 'L');
$pdf->Cell(33, 8, utf8_decode('DEPOSITOS'), 1, 'L');
$pdf->Cell(32, 8, utf8_decode('TRANSFERENCIA'), 1, 'L');
$pdf->Cell(33, 8, utf8_decode('SEGUROS'), 1, 'L');
$pdf->Cell(33, 8, utf8_decode('DESCUENTO'), 1, 'L');
$pdf->Ln(8);
$pdf->Cell(33, 8, number_format($tot_efectivo,2), 1, 'L');
$pdf->Cell(33, 8, number_format($tot_tarjeta,2), 1, 'L');
$pdf->Cell(33, 8, number_format($tot_deposito,2), 1, 'L');
$pdf->Cell(32, 8, number_format($tot_transferencia,2), 1, 'L');
$pdf->Cell(33, 8, number_format($tot_seguros,2), 1, 'L');
$pdf->Cell(33, 8, number_format($descuentot,2), 1, 'L');

//efectivo count
$sql_tabla = "SELECT COUNT(p.id_pac) AS countefe, p.nombre, m.* FROM pago_serv p, depositos_pserv m WHERE m.tipo_pago='EFECTIVO' and m.id_pac=p.id_pac and (p.fecha BETWEEN '$anio' AND '$fec_real') AND p.tipo = m.tipo ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $countefe=$row_tabla['countefe'];
    
    }
    
    $sql_tabla = "SELECT COUNT(f.id_atencion) as countefe, i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
    (f.fecha BETWEEN '$anio' AND '$fec_real') and f.banco='EFECTIVO' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $countefe2=$row_tabla['countefe'];
      $countefet=$countefe+$countefe2;
      $no++;
    }

//tarjeta count
$sql_tabla = "SELECT COUNT(p.id_pac) AS countar, p.nombre, m.* FROM pago_serv p, depositos_pserv m WHERE m.tipo_pago='TARJETA' and m.id_pac=p.id_pac and (p.fecha BETWEEN '$anio' AND '$fec_real') AND p.tipo = m.tipo ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $countar=$row_tabla['countar'];
    
    }
    
    $sql_tabla = "SELECT COUNT(f.id_atencion) as countar, i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
    (f.fecha BETWEEN '$anio' AND '$fec_real') and f.banco='TARJETA' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $countar2=$row_tabla['countar'];
      $countart=$countar+$countar2;
      $no++;
    }
$pdf->Ln(13);

//asegura count

    $sql_tabla = "SELECT COUNT(f.id_atencion) as countAS, i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
    (f.fecha BETWEEN '$anio' AND '$fec_real') and f.banco='ASEGURADORA' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $countAS=$row_tabla['countAS'];
     
      $no++;
    }


//despoitos count
$sql_tabla = "SELECT COUNT(p.id_pac) AS countdep, p.nombre, m.* FROM pago_serv p, depositos_pserv m WHERE m.tipo_pago='DEPOSITO' and m.id_pac=p.id_pac and (p.fecha BETWEEN '$anio' AND '$fec_real') AND p.tipo = m.tipo ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $countdep=$row_tabla['countdep'];
    
    }
    
    $sql_tabla = "SELECT COUNT(f.id_atencion) as countdep, i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
    (f.fecha BETWEEN '$anio' AND '$fec_real') and f.banco='DEPOSITO' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $countdep2=$row_tabla['countdep'];
      $countdepT=$countdep+$countdep2;
      $no++;
    }


//TRANSEFERENCIA count
$sql_tabla = "SELECT COUNT(p.id_pac) AS counttrans, p.nombre, m.* FROM pago_serv p, depositos_pserv m WHERE m.tipo_pago='TRANSFERENCIA' and m.id_pac=p.id_pac and (p.fecha BETWEEN '$anio' AND '$fec_real') AND p.tipo = m.tipo ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $counttrans=$row_tabla['counttrans'];
    
    }
    
    $sql_tabla = "SELECT COUNT(f.id_atencion) as counttrans, i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
    (f.fecha BETWEEN '$anio' AND '$fec_real') and f.banco='TRANSFERENCIA' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $counttrans2=$row_tabla['counttrans'];
      $counttransT=$counttrans+$counttrans2;
      $no++;
    }
    
    
    //descuento count
$sql_tabla = "SELECT COUNT(p.id_pac) AS countdes, p.nombre, m.* FROM pago_serv p, depositos_pserv m WHERE m.tipo_pago='DESCUENTO' and m.id_pac=p.id_pac and (p.fecha BETWEEN '$anio' AND '$fec_real') AND p.tipo = m.tipo ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=1;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $countdes=$row_tabla['countdes'];
    
    }
    
    $sql_tabla = "SELECT COUNT(f.id_atencion) as countdes, i.*, p.*, f.fecha , f.deposito, f.banco FROM dat_financieros f , dat_ingreso i , paciente p WHERE f.deposito>0 and f.id_atencion=i.id_atencion and i.Id_exp=p.Id_exp and 
    (f.fecha BETWEEN '$anio' AND '$fec_real') and f.banco='DESCUENTO' ORDER BY f.deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $countdes2=$row_tabla['countdes'];
      $countdesT=$countdes+$countdes2;
      $no++;
    }
    
$pdf->Cell(33, 8, utf8_decode('EFECTIVO'), 1, 'L');
$pdf->Cell(33, 8, utf8_decode('TARJETA'), 1, 'L');

$pdf->Cell(33, 8, utf8_decode('DEPOSITOS'), 1, 'L');
$pdf->Cell(32, 8, utf8_decode('TRANSFERENCIA'), 1, 'L');
$pdf->Cell(33, 8, utf8_decode('SEGUROS'), 1, 'L');
$pdf->Cell(33, 8, utf8_decode('DESCUENTO'), 1, 'L');
$pdf->Ln(8);
$pdf->Cell(33, 8, ($countefet), 1, 'L');
$pdf->Cell(33, 8, ($countart), 1, 'L');

$pdf->Cell(33, 8, ($countdepT), 1, 'L');
$pdf->Cell(32, 8, ($counttransT), 1, 'L');
$pdf->Cell(33, 8, ($countAS), 1, 'L');
$pdf->Cell(33, 8, ($countdesT), 1, 'L');

$pdf->Output();
