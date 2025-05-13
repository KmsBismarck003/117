<?php
use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$sql_egreso = "SELECT * from alta where id_atencion=$id_atencion";
$result_egreso = $conexion->query($sql_egreso);

while ($row_egreso = $result_egreso->fetch_assoc()) {
  $id_alta = $row_egreso['id_alta'];
}

if(isset($id_alta)){
    $id_alta = $id_alta;
  }else{
    $id_alta ='sin doc';
  }

if($id_alta=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "No existe aviso de alta para este paciente", 
                            type: "error",
                            confirmButtonText: "Aceptar"
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

   
    $this->SetDrawColor(43, 45, 127);
    
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
    $this->SetDrawColor(43, 45, 127);
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
     $this->Cell(0, 10, utf8_decode('CMSI-010'), 0, 1, 'R');
  }
  
}

$sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
$result_dat_ing = $conexion->query($sql_dat_ing);

while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
  $motivo_atn = $row_dat_ing['motivo_atn'];
  $especialidad = $row_dat_ing['especialidad'];
  $id_usua = $row_dat_ing['id_usua'];
  $fecha_ing=$row_dat_ing['fecha'];
   $tipo_a=$row_dat_ing['tipo_a'];
}


$sql_pac = "SELECT * FROM paciente where Id_exp = $id_exp";
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
    $folio = $row_pac['folio'];
}

$sql_camas = "SELECT * from cat_camas where id_atencion=$id_atencion";
$result_cama = $conexion->query($sql_camas);

while ($row_cama = $result_cama->fetch_assoc()) {
  $num_cama = $row_cama['num_cama'];
}

if(isset($num_cama)){
   $num_cama = $num_cama;
}else{
  $num_cama='Sin habitación';
}

$select_doc = $conexion->query("SELECT * from reg_usuarios WHERE id_usua=$id_usua") or die($conexion->error);
while ($row = mysqli_fetch_array($select_doc)) {
$doctor=$row['papell'];

///inicio bisiesto
function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}
}

$fecha_actual = date("Y-m-d");
$fecha_nac=$fecnac;
$fecha_de_nacimiento =strval($fecha_nac);

// separamos en partes las fechas
$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
$array_actual = explode ( "-", $fecha_actual );

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

//ajuste de posible negativo en $días
if ($dias < 0)
{
    --$meses;

    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
    switch ($array_actual[1]) {
           case 1:     $dias_mes_anterior=31; break;
           case 2:     $dias_mes_anterior=31; break;
           case 3:     
               if (bisiesto($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
               
           case 4:     $dias_mes_anterior=31; break;
           case 5:     $dias_mes_anterior=30; break;
           case 6:     $dias_mes_anterior=31; break;
           case 7:     $dias_mes_anterior=30; break;
           case 8:     $dias_mes_anterior=31; break;
           case 9:     $dias_mes_anterior=31; break;
           case 10:     $dias_mes_anterior=30; break;
           case 11:     $dias_mes_anterior=31; break;
           case 12:     $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

//echo "<br>Tu edad es: $anos años con $meses meses y $dias días";



$sql_egreso = "SELECT * from alta where id_atencion=$id_atencion";
$result_egreso = $conexion->query($sql_egreso);

while ($row_egreso = $result_egreso->fetch_assoc()) {
  $fech_alta = $row_egreso['fech_alta'];
  $hor_alta = $row_egreso['hor_alta'];
  $alta_por = $row_egreso['alta_por'];
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(43, 45, 127);
$pdf->SetDrawColor(43, 45, 180);
 
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetX(45);
$pdf->Cell(130, 8, utf8_decode('PASE DE SALIDA'), 0, 0, 'C');

$pdf->Ln(11);
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetX(8);
$pdf->Cell(198, 8, utf8_decode('Datos del Paciente'), 1,0, 'C');
$pdf->Ln(10);

$pdf->SetX(8);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(21, 8, utf8_decode('Paciente: '),0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(177, 8, utf8_decode($nom_pac . ' ' . $papell . ' ' . $sapell),1,'B', 'L');


$pdf->Ln(10);
$pdf->SetX(8);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(21,8,utf8_decode('Habitación: '),0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25,8,utf8_decode($num_cama),1,'B','C');

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(25, 8, utf8_decode('  Expediente: '), 0, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 8, utf8_decode($folio),1,'B','C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(19,8,utf8_decode('  Alta por: '),0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(83,8,utf8_decode($alta_por),1,'B','L');

$pdf->Ln(10);
$pdf->SetX(8);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(21,8,utf8_decode('Médico(s): '),0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(107,8,utf8_decode($doctor),1,'B','L');

$pdf->SetX(138);
$fec_ing=date_create($fecha_ing);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30,8,utf8_decode('Fecha de ingreso: '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(38,8,utf8_decode(date_format($fec_ing,"d/m/Y H:i:s")), 1,'B','L');

$pdf->Ln(10);
$pdf->SetX(138);
$fecha_alt=date_create($fech_alta);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30,8,utf8_decode(' Fecha de egreso: '),0,'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(38,8,utf8_decode(date_format($fecha_alt,"d/m/Y "). ' '. $hor_alta),1,'B','L');


$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetX(8);
$pdf->Cell(198, 8, utf8_decode('Verificación de Salida'), 1,0, 'C');
$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(8);
$pdf->Cell(198, 10, utf8_decode('Estudios, materiales y/o medicamentos entregados:'), 0,0, 'L');
$pdf->Ln(11);
$pdf->SetX(8);
$pdf->cell(198, 11, utf8_decode(''), 1,0, 'L');
$pdf->Ln(12);
$pdf->SetX(8);
$pdf->cell(198, 11, utf8_decode(''), 1,0, 'L');
$pdf->Ln(12);
$pdf->SetX(8);
$pdf->Cell(198, 11, utf8_decode(''), 1,0, 'L');
$pdf->Ln(12);
$pdf->SetX(8);
$pdf->Cell(198, 11, utf8_decode(''), 1,0, 'L');
$pdf->Ln(12);
$pdf->SetX(8);
$pdf->cell(198, 11, utf8_decode(''), 1,0, 'L');
$pdf->Ln(12);
$pdf->SetX(8);
$pdf->Cell(198, 11, utf8_decode(''), 1,0, 'L');
$pdf->Ln(12);
$pdf->SetX(8);
$pdf->Cell(198, 11, utf8_decode(''), 1,0, 'L');


$fecha_actual = date("d-m-Y H:i:s");

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




$sql_med_id = "SELECT id_usua FROM alta WHERE id_atencion = $id_atencion ORDER by  id_alta DESC LIMIT 1";
    $result_med_id = $conexion->query($sql_med_id);

    while ($row_med_id = $result_med_id->fetch_assoc()) {
      $id_med= $row_med_id['id_usua'];
    }

    $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_med";
    $result_med = $conexion->query($sql_med);

while ($row_reg_usrs = $result_med->fetch_assoc()) {
  $user_pre = $row_reg_usrs['pre'];
  $user_papell = $row_reg_usrs['papell'];
  $user_sapell = $row_reg_usrs['sapell'];
  $user_nombre = $row_reg_usrs['nombre'];
}



$pdf->ln(18);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195, 6, utf8_decode('Metepec, México '. $dia.' '.$mes.' '.$ano ) ,0,0, 'C');

$pdf->ln(40);
$pdf->SetX(8);
$pdf->cell(90,6,utf8_decode(''),'B','L');
$pdf->SetX(110);
$pdf->cell(90,6,utf8_decode(''),'B','L');
$pdf->SetFont('Arial', '', 10);
$pdf->ln(6);
$pdf->SetX(8);
$pdf->Cell(90, 6, utf8_decode('Nombre y Firma del(a)'),0, 0, 'C');
$pdf->SetX(150);
$pdf->Cell(20,6,utf8_decode('Nombre y Firma de quien'),0, 0, 'C');


$pdf->ln(6);
$pdf->SetX(8);
$pdf->Cell(90, 6, utf8_decode('enfermero(a) que asiste el alta'),0, 0, 'C');
$pdf->SetX(150);
$pdf->Cell(20,6,utf8_decode('recibe los medicamentos y estudios'),0,0,'C');


$pdf->Output();
}