<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_atencion = @$_GET['id_atencion'];

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
  }}
  function Footer()
  {
    $this->SetFont('Arial', '', 8);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    $this->Cell(0, 10, 'MAC-022', 0, 1, 'R');
  }
}


$fecha_actual = date("d/m/Y");


 explode("-", $fecha_actual);
 $ano  = date("Y") ;
  $mes= date("m") ;
  $dia  = date("d") ;

   if ($mes==1) {
    $mes='enero';
  }

 if ($mes==2) {
    $mes='febrero';
  }
   if ($mes==3) {
    $mes='marzo';
  }
 if ($mes==4) {
    $mes='abril';
  }
  if ($mes==5) {
    $mes='mayo';
  }
   if ($mes==6) {
    $mes='junio';
  }
   if ($mes==7) {
    $mes='julio';
  }
   if ($mes==8) {
    $mes='agosto';
  }
   if ($mes==9) {
    $mes='septiembre';
  }
   if ($mes==10) {
    $mes='octubre';
  }
   if ($mes==11) {
    $mes='noviembre';
  }
   if ($mes==12) {
    $mes='diciembre';
  }

$sql_reg_usu = "SELECT ru.pre, ru.papell, ru.sapell, ru.nombre, di.Id_exp FROM dat_ingreso di, reg_usuarios ru where id_atencion=$id_atencion and ru.id_usua=di.id_usua";

$result_reg_usu = $conexion->query($sql_reg_usu);
while ($row_reg_usu = $result_reg_usu->fetch_assoc()) {
  $pre = $row_reg_usu['pre'];
  $papell = $row_reg_usu['papell'];
  $sapell = $row_reg_usu['sapell'];
  $nombre = $row_reg_usu['nombre'];
  $id_exp = $row_reg_usu['Id_exp'];
}

 $deposito = " ";
  $dep_l = " ";
  $resp = " ";
  $dir_resp = " ";
 // $id_mun = $row_dat_fin['id_mun'];
  $tel = " ";
  $aval = " ";
  
$sql_dat_fin = "SELECT df.deposito, df.dep_l, df.resp, df.dir_resp, df.id_mun, df.tel, df.aval FROM dat_ingreso di, dat_financieros df WHERE di.id_atencion = df.id_atencion and df.id_atencion =$id_atencion";
$result_dat_fin = $conexion->query($sql_dat_fin);

while ($row_dat_fin = $result_dat_fin->fetch_assoc()) {
  $deposito = $row_dat_fin['deposito'];
  $dep_l = $row_dat_fin['dep_l'];
  $resp = $row_dat_fin['resp'];
  $dir_resp = $row_dat_fin['dir_resp'];
 // $id_mun = $row_dat_fin['id_mun'];
  $tel = $row_dat_fin['tel'];
  $aval = $row_dat_fin['aval'];
 
}

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.edad, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $pac_papell = $row_pac['papell'];
  $pac_sapell = $row_pac['sapell'];
  $pac_nom_pac = $row_pac['nom_pac'];
  $pac_dir = $row_pac['dir'];
  $pac_id_edo = $row_pac['id_edo'];
  $pac_id_mun = $row_pac['id_mun'];
  $pac_tel = $row_pac['tel'];
  $pac_fecnac = $row_pac['fecnac'];
  $id_mun= $row_pac['id_mun'];
  $edad= $row_pac['edad'];
}

$sql_mun = "SELECT nombre_m FROM municipios WHERE id_mun = $id_mun";
$result_mun = $conexion->query($sql_mun);

while ($row_mun = $result_mun->fetch_assoc()) {
  $nom_mun = $row_mun['nombre_m'];
}

$sql_mun_pac = "SELECT nombre_m FROM municipios WHERE id_mun = $pac_id_mun";
$result_mun_pac = $conexion->query($sql_mun_pac);

while ($row_mun_pac = $result_mun_pac->fetch_assoc()) {
  $nom_mun_pac = $row_mun_pac['nombre_m'];
}

$sql_edo_pac = "SELECT nombre FROM estados WHERE id_edo = $pac_id_edo";
$result_edo_pac = $conexion->query($sql_edo_pac);

while ($row_edo_pac = $result_edo_pac->fetch_assoc()) {
  $nom_edo_pac = $row_edo_pac['nombre'];
}


$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);

$pdf->SetY(41);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(200, 9.5, utf8_decode('CONTRATO DE PRESTACIÓN DE SERVICIOS HOSPITALARIOS'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 55, 205, 55);
$pdf->Line(8, 55, 8, 280);
$pdf->Line(205, 55, 205, 280);
$pdf->Line(8, 280, 205, 280);

$pdf->SetY(50);
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(5);
$pdf->MultiCell(198, 6, utf8_decode('CELEBRADO POR "MÉDICA DEL ÁNGEL CUSTODIO", Y POR OTRA PARTE EL SR. (A):'), 0, 'J');
$pdf->SetFont('Arial', 'B', 10);
$pdf->MultiCell(194, 6, utf8_decode($pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac), 'B', 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, utf8_decode('CON DOMILICIO EN: '), 0, 'L');
$pdf->Cell(164, 6, utf8_decode($pac_dir . ', ' . $nom_edo_pac . ', ' . $nom_mun_pac), 'B', 'L');
$pdf->Ln(6);
$pdf->Cell(25, 6, utf8_decode('EXPEDIENTE: '), 0, 'L');
$pdf->Cell(15, 6, utf8_decode($id_exp),'B', 'L');
$pdf->Cell(20, 6, utf8_decode(' TELÉFONO: '), 0, 'L');
$pdf->Cell(22, 6, utf8_decode($pac_tel), 'B', 'L');
$pdf->Cell(40, 6, utf8_decode(' FECHA DE NACIMIENTO: '), 0, 'L');
$date = date_create($pac_fecnac);
$pdf->Cell(35, 6, utf8_decode(date_format($date,"d/m/Y")), 'B', 'L');
$pdf->Cell(12, 6, ' EDAD: ', 0, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 6, utf8_decode($edad), 'B', 'C');

$pdf->Ln(5);
//$pdf->Cell(0, 1, '', 'B');
$pdf->Ln(3);
$pdf->MultiCell(180, 6, utf8_decode('A QUIEN POSTERIORMENTE SE LE DENOMINA "PACIENTE" Y QUE CELEBRAN CONFORME A LAS SIGUIENTES.'), 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 11);
$pdf->MultiCell(200, 6, utf8_decode('CLÁUSULAS'), 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(195, 6, utf8_decode('P R I M E R A.- "MÉDICA DEL ÁNGEL CUSTODIO" obliga a solicitud del "PACIENTE" a proporcionarle los siguientes servicios hospitalarios: habitación, servicios de enfermería, dieta prescrita por el Médico tratante del "PACIENTE".'), 0, 'J');
$pdf->MultiCell(195, 6, utf8_decode('S E G U N D A.- El "PACIENTE" se obliga a pagar a "MÉDICA DEL ÁNGEL CUSTODIO" el importe de los servicios antes mencionados, además de los derivados de Rayos X, Laboratorio, Oncología, Medicinas, Material de Curación, Terapia Intensiva y aquellos que sean solicitados por el Médico tratante del "PACIENTE", cuyos gastos se cargarán a la cuenta respectiva.'), 0, 'J'); 
$pdf->MultiCell(195, 6, utf8_decode('T E R C E R A.- El "PACIENTE" entrega en este acto a  "MÉDICA DEL ÁNGEL CUSTODIO"  en  calidad  de  anticipo  la  cantidad  de    $                         pesos en Moneda Nacional y se obliga a hacer pagos diarios por los gastos incurridos y liquidar el total de la cuenta al ser dado de ata por su Médico, o al retirarse de "MÉDICA DEL ÁNGEL CUSTODIO" en caso de alta voluntaria.'), 0, 'J');
$pdf->SetY(135);
$pdf->SetX(14);
$pdf->MultiCell(20, 6, number_format($deposito,2), 'B', 'R');
$pdf->Ln(14);
$pdf->MultiCell(195, 6, utf8_decode('C U A R T A.- El "PACIENTE" se obliga a cumplir con el Reglamento interno y demás disposiciones de "MÉDICA DEL ÁNGEL CUSTODIO" y como esta es una institución abierta al cuerpo Médico lo revela de cualquier responsabilidad médica.'), 0, 'J');
$pdf->MultiCell(195, 6, utf8_decode('Q U I N T A.- El "PACIENTE" autoriza al Médico tratante Dr.'.'                                                                                           '.' y a sus colaboradores para que prescriban, lleven a cabo el tratamiento Médico y/o quirúrgico que requiera su persona; así como la administración de medicamentos y anestésicos prescritos.'), 0, 'J');
$pdf->SetY(167);
$pdf->SetX(98);
$pdf->Cell(93,6, utf8_decode($papell.' '.$sapell), 'B','L');
$pdf->Ln(18);
$pdf->MultiCell(195, 6, utf8_decode('S E X T A.- Ambas partes convienen que en caso de que el "PACIENTE" este incapacitado para firmar este contrato, lo hará a su nombre y representación la persona que se responsabilice en el cumplimiento de las obligaciones anteriormente establecidas.'), 0, 'J');


$fecha_actual = date("d/m/Y");
$pdf->Ln(8);
$pdf->Cell(195, 6, utf8_decode('Metepec, Méxco a '. $dia.' de '.$mes.' de '.$ano.'. ' ) ,0,0, 'C');
$pdf->Ln(8);
$pdf->Cell(100, 6, utf8_decode('PACIENTE'), 0, 0, 'C');
$pdf->Cell(100, 6, utf8_decode('RESPONSABLE'), 0, 0, 'C');
$pdf->Ln(8);

$pdf->Cell(100, 6, utf8_decode($pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac),0, 0, 'C');
$pdf->Cell(100, 6, utf8_decode($resp), 0, 0, 'C');
$pdf->Ln(3);
$pdf->Cell(100, 6, utf8_decode('___________________________________'), 0, 0, 'C');
$pdf->Cell(100, 6, utf8_decode('___________________________________'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(100, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');
$pdf->Cell(100, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');

$pdf->Ln(14);
$pdf->Cell(200, 6, utf8_decode('MÉDICA DEL ÁNGEL CUSTODIO'), 0, 0, 'C');
$pdf->Ln(10);
$pdf->Cell(200, 6, utf8_decode('___________________________________'), 0, 0, 'C');
$pdf->Ln(6);
$pdf->Cell(200, 6, utf8_decode('NOMBRE Y FIRMA'), 0, 0, 'C');
/*
$pdf->Ln(8);
$pdf->Cell(30, 6, utf8_decode('NÚMERO'), 1, 0, 'C');
$pdf->Cell(80, 6, utf8_decode('LUGAR DE EXPEDICIÓN'), 1, 0, 'C');
$pdf->Cell(40, 6, utf8_decode('FECHA'), 1, 0, 'C');

$pdf->Ln(6);
$pdf->Cell(30, 8, utf8_decode('1'), 1, 0, 'C');
$pdf->Cell(80, 8, utf8_decode('MÉDICA DEL ÁNGEL CUSTODIO METEPEC'), 1, 0, 'C');
$pdf->Cell(40, 8, date('d/m/Y'), 1, 0, 'C');

$pdf->Ln(9);


$pdf->MultiCell(190, 5, utf8_decode('DEBO (EMOS) Y PAGARE (EMOS) SIN PRETEXTO ESTE PAGARE EN EL LUGAR Y FECHA CITADAS DONDE ELIJA EL TENEDOR EL DÍA DE SU VENCIMENTO A LA ORDEN DE MÉDICA DEL ÁNGEL CUSTODIO METEPEC EL DÍA ' . date('d/m/Y')), 0, 'J');
$pdf->Cell(35, 6, utf8_decode('LA CANTIDAD DE: '), 0, 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(150, 6, utf8_decode('CINCUENTA MIL PESOS 00/100 M.N.'), 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(1);
$pdf->MultiCell(190,3, utf8_decode('VALOR RECIBIDO A MI (NUESTRA) ENTERA SATISFACCIÓN, ESTE PAGARE FORMA PARTE DE UNA SERIE NUMERADA DEL 1  AL 1 Y TODOS ESTÁN SUJETOS A LA CONDICIÓN DE QUE NO PAGARSE CUALQUIERA DE ELLOS A SU VENCIMIENTO, SERÁN EXIGIBLES TODOS LOS QUE LE SIGUEN EN NÚMERO, ADEMÁS DE LOS YA VENCIDOS DE ACUERDO AL ART. 79 DE LA LEY GENERAL DE TÍTULOS Y OPERACIONES DE CRÉDITO, CAUSARÁN INTERESES MORATORIOS DE % MES O FRACCIÓN PAGADERO JUNTAMENTE CON EL PRINCIPAL, DICHOS INTERESES SE CAUSARÁN SOBRE EL CAPITAL INSOLUTO, CONFORME A LO DISPUESTO POR EL ART. 152 INCISO I,II,III,IV DE LA LEY GENERAL DE TÍTULOS Y OPERACIONES DE CRÉDITO'), 0, 'J');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(1);
$pdf->Cell(20, 6, utf8_decode(''), 0, 0, 'C');
$pdf->Cell(60, 6, utf8_decode('NOMBRE Y DATOS DEL DEUDOR'), 0, 0, 'C');
$pdf->Cell(55, 6, utf8_decode('AVAL'), 0, 0, 'C');
$pdf->SetX(150);
$pdf->Cell(55, 6, utf8_decode('DEUDOR'), 0, 0, 'C');

$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode('NOMBRE: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(30);
$pdf->MultiCell(55, 6, utf8_decode($resp), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode('DOMICILIO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(55, 6, utf8_decode($pac_dir), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(20, 6, utf8_decode('MUNICIPIO: '), 0, 0, 'L');
//$pdf->SetFont('Arial', 'U', 8);
//$pdf->Cell(60, 6, utf8_decode($nom_mun), 0, 0, 'L');

$pdf->SetX(90);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(55, 6, utf8_decode(" "), 0, 0, 'C');
$pdf->SetX(150);
$pdf->Cell(55, 6, utf8_decode($resp), 0, 0, 'C');
$pdf->Ln(6);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 6, utf8_decode('TELÉFONO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(55, 6, utf8_decode($pac_tel), 'B', 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(55, 6, utf8_decode('NOMBRE Y FIRMA '), 'T', 0, 'C');
$pdf->SetX(130);
$pdf->Cell(55, 6, utf8_decode('NOMBRE Y FIRMA '), 'T', 0, 'C');
*/

$pdf->Ln(6);
/*
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetX(60);
$pdf->Cell(100, 6, utf8_decode('AVAL'), 0, 0, 'C');
$pdf->Ln(26);
$pdf->SetX(60);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(100, 6, utf8_decode($aval), 'T', 'C');
$pdf->SetX(60);
$pdf->Cell(100, 6, utf8_decode('NOMBRE Y FIRMA '), 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetX(60);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(100, 6, utf8_decode('DEUDOR'), 0, 0, 'C');
$pdf->Ln(26);
$pdf->SetX(60);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(100, 6, utf8_decode($resp), 'T', 'C');
$pdf->SetX(60);
$pdf->Cell(100, 6, utf8_decode('NOMBRE Y FIRMA '), 0, 0, 'C');
*/
$pdf->Output();
