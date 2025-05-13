  <?php
  require '../../fpdf/fpdf.php';
  include '../../conexionbd.php';
  $id_in = @$_GET['id_in'];
  $id_med = @$_GET['id_med'];
  $id_not_nutri = @$_GET['id_not_nutri'];


  $id_exp = @$_GET['id_exp'];
  $id_atencion = @$_GET['id_atencion'];
  $sql_dat_eg = "SELECT * from dat_not_nutricion where id_not_nutri=$id_in and id_atencion = $id_atencion";
  $result_dat_eg = $conexion->query($sql_dat_eg);

  while ($row_dat_eg = $result_dat_eg->fetch_assoc()) {
    $id_not_nutri = $row_dat_eg['id_not_nutri'];
  }
  if(isset($id_not_nutri)){
      $id_not_nutri = $id_not_nutri;
    }else{
      $id_not_nutri ='sin doc';
    }

  if($id_not_nutri=="sin doc"){
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
      echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
      echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
      echo '<script>
                      $(document).ready(function() {
                          swal({
                              title: "NO EXISTE NOTA DE NUTRICIÓN PARA ESTE PACIENTE", 
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

    $this->Image("../../configuracion/admin/img2/".$bas, 7, 15, 50, 22);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],60,15, 100, 25);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 161, 18, 45, 20);
}
    $this->Ln(32);
   
    }
     function Footer()
  {
    $this->Ln(8);
    $this->SetFont('Arial', '', 7);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
     $this->Cell(0, 4, utf8_decode('MAC-5.08'), 0, 1, 'R');
  }
  }

  $sql_pac = "SELECT * FROM paciente  where Id_exp = $id_exp";
  $result_pac = $conexion->query($sql_pac);

  while ($row_pac = $result_pac->fetch_assoc()) {
    $papell = $row_pac['papell'];
    $nom_pac = $row_pac['nom_pac'];
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
    $fecnac = $row_pac['fecnac'];
    $folio = $row_pac['folio'];
  }

  $sql_dat_ing = "SELECT * from dat_ingreso where id_atencion = $id_atencion";
  $result_dat_ing = $conexion->query($sql_dat_ing);

  while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
    $motivo_atn = $row_dat_ing['motivo_atn'];
    $especialidad = $row_dat_ing['especialidad'];
    $id_usua = $row_dat_ing['id_usua'];
    $fecha_ing=$row_dat_ing['fecha'];
    $tipo_a=$row_dat_ing['tipo_a'];
    $area=$row_dat_ing['area'];
  
  }

 $sqln = "SELECT * from dat_not_nutricion where id_not_nutri=$id_in and id_atencion = $id_atencion";
  $resn = $conexion->query($sqln);

  while ($rown = $resn->fetch_assoc()) {
    $fecha_not_nutri  = $rown['fecha_not_nutri'];
    
        $imc  = $rown['imc'];
        $ppeso  = $rown['ppeso'];
        $dis  = $rown['dis'];
        $grave  = $rown['grave'];
        $edopun  = $rown['edopun'];
        $edomas  = $rown['edomas'];
        $sepun  = $rown['sepun'];
        $ptot  = $rown['ptot'];
        $sintomas_gas  = $rown['sintomas_gas'];
        $dias_ayuno  = $rown['dias_ayuno'];
        $cambio_peso  = $rown['cambio_peso'];
        $funcionalidad  = $rown['funcionalidad'];
        $historia_d  = $rown['historia_d'];
        $malestares  = $rown['malestares'];
        
        $antropo  = $rown['antropo'];
        $composicion  = $rown['composicion'];
        $p_sistolica  = $rown['p_sistolica'];
        $p_diastolica  = $rown['p_diastolica'];
        $f_card  = $rown['f_card'];
        $f_resp  = $rown['f_resp'];
        $temp  = $rown['temp'];
        $sat_oxigeno  = $rown['sat_oxigeno'];
$peso  = $rown['peso'];
$talla  = $rown['talla'];
        $sat_oxigeno  = $rown['sat_oxigeno'];
        $estudioslab  = $rown['estudioslab'];
        $hidrico  = $rown['hidrico'];
        $ingeg  = $rown['ingeg'];

$rnutricional  = $rown['rnutricional'];
        $evanutri  = $rown['evanutri'];
        $diagnutri  = $rown['diagnutri'];
        $limitantes  = $rown['limitantes'];
        $requerimientos  = $rown['requerimientos'];


$conque  = $rown['conque'];
        $pordonde  = $rown['pordonde'];
        $cuanto  = $rown['cuanto'];
        $cuando  = $rown['cuando'];
        $quemonitoreo  = $rown['quemonitoreo'];
 $como  = $rown['como'];

 $minter  = $rown['minter'];

 $egrenut  = $rown['egrenut'];
  $balineg  = $rown['balineg'];





  }

  $pdf = new PDF('P');
  $pdf->AliasNbPages();
  $pdf->AddPage();
    $pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,32);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetX(30);
$pdf->SetTextColor(43, 45, 127);
$pdf->MultiCell(165, 9.5, utf8_decode('NUTRICIÓN CLÍNICA'), 0, 'C');


$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(48, 52, 172, 52);
$pdf->Line(48, 41, 48, 52);
$pdf->Line(172, 41, 172, 52);
$pdf->Line(48, 41, 172, 41);

$pdf->SetX(170);
$pdf->SetFont('Arial', '', 6);
//
//$fecha_actual = date("d/m/Y H:i");

$daten=date_create($fecha_not_nutri);
$pdf->Cell(35, -2, 'Fecha: '. date_format($daten,'d-m-Y H:i:s'), 0, 1, 'R');

$pdf->SetFont('Arial', '', 6);
$pdf->SetDrawColor(43, 45, 127);
$pdf->Line(8, 53, 207, 53);
$pdf->Line(8, 53, 8, 280);
$pdf->Line(207, 53, 207, 280);
$pdf->Line(8, 280, 205, 280);
$pdf->Ln(5);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 5, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(124, 5, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecha_ing);
$pdf->Cell(28, 5, utf8_decode('Fecha de ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, date_format($date,'d-m-Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8, 5, utf8_decode($folio), 'B', 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 5, ' Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(152, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$date=date_create($fecnac);
$pdf->Cell(30, 5, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 5, date_format($date,"d/m/Y"), 'B', 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 5, ' Edad: ', 0, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(12, 5, utf8_decode($edad), 'B', 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, utf8_decode(' Ocupación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 5,  utf8_decode($ocup), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(14, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(18, 5,  utf8_decode($tel), 'B', 'L');
$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$Id_exp ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_hc = $result_sig->fetch_assoc()) {
$pesoh=$row_hc['peso'];
$tallah=$row_hc['talla'];
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 5, utf8_decode(' Peso: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(13, 5,  utf8_decode($pesoh.' Kilos'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 5, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 5,  utf8_decode($tallah.' Metros'), 'B', 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 5, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(22, 5,  $sexo, 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, utf8_decode(' Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(141, 5, utf8_decode($dir), 'B', 'L');

$pdf->Ln(5);

$d="";
      $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by diagprob_i ASC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } ?>
    <?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
    $result_mot = $conexion->query($sql_mot);
    while ($row_mot = $result_mot->fetch_assoc()) {
    $m=$row_mot['motivo_atn'];
    } 
if ($d!=null) {
    $pdf->SetFont('Arial', 'B', 8);
  $pdf->Cell(20, 5, utf8_decode('Diagnóstico:') , 0, 'C');
  $pdf->SetFont('Arial', '', 9);
     $pdf->Cell(175, 5, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 5, utf8_decode('Motivo de atención:') , 0, 'C');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(166, 5, utf8_decode($m) , 'B', 'C');
    }
$pdf->Ln(6);

$pdf->Cell(135, 5, utf8_decode('SCREENING INICIAL '), 1,0, 'C');
$pdf->Cell(30, 5, utf8_decode('SI '), 1,0, 'C');
$pdf->Cell(30, 5, utf8_decode('NO '), 1,0, 'C');
$pdf->Ln(5);
$pdf->Cell(30, 5, utf8_decode('1'), 1,0, 'C');
$pdf->Cell(105, 5, utf8_decode('IMC <20.5'), 1,0, 'C');

      


if($imc=="SI"){
  $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode(' X'), 1,0, 'C');
$pdf->Cell(30, 5, utf8_decode(''), 1,0, 'C');
}else if($imc=="NO"){
  $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode(''), 1,0, 'C');
$pdf->Cell(30, 5, utf8_decode(' X '), 1,0, 'C');
}
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(5);
$pdf->Cell(30, 5, utf8_decode('2'), 1,0, 'C');
$pdf->Cell(105, 5, utf8_decode('El paciente ha perdido peso en los últimos 3 meses'), 1,0, 'C');
if($ppeso=="SI"){
  $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode(' X'), 1,0, 'C');
$pdf->Cell(30, 5, utf8_decode(''), 1,0, 'C');
}else if($ppeso=="NO"){
  $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode(''), 1,0, 'C');
$pdf->Cell(30, 5, utf8_decode(' X '), 1,0, 'C');
}
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(5);
$pdf->Cell(30, 5, utf8_decode('3'), 1,0, 'C');
$pdf->Cell(105, 5, utf8_decode('El paciente ha disminuido su ingesta en la última semana'), 1,0, 'C');
if($dis=="SI"){
  $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode(' X'), 1,0, 'C');
$pdf->Cell(30, 5, utf8_decode(''), 1,0, 'C');
}else if($dis=="NO"){
  $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode(''), 1,0, 'C');
$pdf->Cell(30, 5, utf8_decode(' X '), 1,0, 'C');
}
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(5);
$pdf->Cell(30, 5, utf8_decode('4'), 1,0, 'C');
$pdf->Cell(105, 5, utf8_decode('Está el paciente gravemente enfermo'), 1,0, 'C');
if($grave=="SI"){
  $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode(' X '), 1,0, 'C');
$pdf->Cell(30, 5, utf8_decode(''), 1,0, 'C');
}else if($grave=="NO"){
  $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode(''), 1,0, 'C');
$pdf->Cell(30, 5, utf8_decode(' X '), 1,0, 'C');
}
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(6.5);
$pdf->MultiCell(195, 5, utf8_decode('Si la respuesta es afirmativa en alguno de los 4 apartados, realice el screening final (tabla 2.)
Si la respuesta es negativa en los 4 apartados, reevalue al paciente semanalmente. En caso de que el paciente vaya a ser sometido a una intervención de cirugía mayor, valorar la posibilidad de soporte nutricional perioperatorio para evitar el riesgo de malanutrición.'), 1, 'J');
$pdf->SetFont('Arial', '', 7);
$pdf->Ln(5);
$pdf->Cell(97.5, 5, utf8_decode('ESTADO NUTRICIONAL'), 1,0, 'C');
$pdf->Cell(97.5, 5, utf8_decode('SEVERIDAD DE LA ENFERMEDAD (INCREMENTA REQUERIMENTOS)'), 1,0, 'C');
$pdf->Ln(5);
$pdf->Cell(48.5, 5, utf8_decode('NORMAL PUNTUACIÓN: 0'), 1,0, 'C');
$pdf->Cell(49, 5, utf8_decode('Normal'), 1,0, 'C');
$pdf->Cell(48.5, 5, utf8_decode('Ausente Puntuación: 0'), 1,0, 'C');
$pdf->Cell(49, 5, utf8_decode('Requerimientos nutricionales normales'), 1,0, 'C');

$pdf->Ln(5);
$pdf->Cell(48.5, 10.5, utf8_decode('DESNUTRICIÓN LEVE PUNTUACIÓN: 1'), 1,0, 'C');
$pdf->MultiCell(49, 3.5, utf8_decode('Pérdida de peso >5% en los últimos 3 meses o ingesta inferor al 50-75% en la última semana'),1, 'J');
$pdf->SetY(137);
$pdf->SetX(105.5);
$pdf->Cell(48.5, 10.5, utf8_decode('Leve Puntuación: 1'), 1,0, 'C');

$pdf->SetX(154);
$pdf->MultiCell(49, 2.6, utf8_decode('Fractura de cadera, pacientes crónicos, complicaciones agudas de cirrosis, EPOC, hemodiálisis, diabetes, enfermos oncológicos'), 1, 'C');
$pdf->SetFont('Arial', '', 6.1);
$pdf->Cell(48.5, 12, utf8_decode('DESNUTRICIÓN MODERADO PUNTUACIÓN: 2'), 1,0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->MultiCell(49, 3, utf8_decode('Pérdida de peso >5% en los últimos 2 meses o IMC 18,5-20.5 + estado general deteriorado o ngsta entre 25%-60% de los requerimientos en la última semana'),1, 'J');
$pdf->SetY(147.5);
$pdf->SetX(105.5);
$pdf->Cell(48.5, 12, utf8_decode('Moderada Puntuación: 2'), 1,0, 'C');
$pdf->MultiCell(49, 6, utf8_decode('Cirugía mayor abdominal AVC, neumonía severa y tmores hematológicos'), 1, 'C');
$pdf->SetFont('Arial', '', 6.5);

$pdf->Cell(48.5, 15, utf8_decode('DESNUTRICIÓN GRAVE PUNTUACIÓN: 3'), 1,0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->MultiCell(49, 3, utf8_decode('Pérdida de peso mayor del 5% en un mes (>15% en 3 meses) o IMC <18-5 + estado general deteriorado o ingesta de 0-25% de los requermientos normales la semana previa'), 1, 'C');
$pdf->SetY(159.5);
$pdf->SetX(105.5);
$pdf->Cell(48.5, 15, utf8_decode('Grave Puntuación: 3'), 1,0, 'C');
$pdf->MultiCell(49, 5, utf8_decode('Traumatismo craneoencefálico, transplante médular. Pacientes en cuidados intensivos (APACHE>10).'), 1, 'C');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(48.5, 5, utf8_decode('Puntuación: ' . $edopun), 1,0, 'C');
$pdf->Cell(49, 5, utf8_decode('+ ' . $edomas), 1,0, 'C');
$pdf->Cell(48.5, 5, utf8_decode('Puntuación: ' . $sepun), 1,0, 'C');
$pdf->Cell(49, 5, utf8_decode('Puntuación Total: ' . $ptot), 1,0, 'C');

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(195, 5, utf8_decode('Edad si el paciente es > 70 años sumar 1 a la puntuación obtenida = puntuación ajustada por la edad'), 1,0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 7);
$pdf->MultiCell(195, 4.5, utf8_decode('Si la puntuación es >=3 el paciente está e un riesgo de malnutrición y es necesario iniciar soporte nutricional. Si la puntuación es <3 es necesario reevaluar semanalmente. Si el paciente va a ser sometido a cirugía mayor, iniciar soporte nutricional perioperatorio.'), 1, 'J');
$pdf->SetFont('Arial', '', 7);
$pdf->MultiCell(195, 4.5, utf8_decode('NOTA: Prototipos para clasificar la severidad de la enfermedad:
Puntuación 1: Paciente cn enfermedad crónica ingresado en el hospital debido a complicaciones. El paciente esta debil pero no encamado. Los requerimientos proteicos están incrementados, pero pueden ser cubiertos mdiante ladeta oral o suplementos.
Puntuación 2: Paciente encamado debido a la enfermedad, or ejemplo, cirugía mayor abdominal. Los requerimientos proteicos están incrementados notablemente pero pueden ser cubiertos, aunque la nutrición artificial se requiere en muchos casos.
Puntuación 3: Pacientes e cuidados intensivos, con ventlación mecánica, etc. Los requerimientos proteicos están incrementados y no pueden ser cubiertos a psar del uso de nutrición artificial. El cataboliso proteico y las pérdidas de nitrógeno puden ser atenuadas de forma significativa.'), 1, 'J');
$pdf->SetFont('Arial', 'B', 5);
$pdf->MultiCell(195, 4.5, utf8_decode('Kondrup J et al, Nutritional Risk Screening (NRS 2002): Clin Nutr, 2003.'), 1, 'J');

$pdf->Ln(495);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(195, 5, utf8_decode('PSOAP: Método que nos permite organizar la información para tener una comunicación clara mediante las notas y como indicar la calidad'), 1,0, 'C');
$pdf->Ln(7);
$pdf->Cell(195, 5, utf8_decode('PRESENTACIÓN ¿Quién es?'),0,0, 'L');
$pdf->Ln(5);
$pdf->Cell(195, 5, utf8_decode('1. Sexo: ' . $sexo),0,0, 'L');
$pdf->Ln(4);
$pdf->Cell(11, 5, utf8_decode('2. Edad: '),0,0, 'L');
if($anos > "0" ){
  $pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 5, utf8_decode($anos . ' años' ), 'C');
}elseif($anos <="0" && $meses>"0"){
     $pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 5, utf8_decode($meses), 'C');
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    $pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 5, utf8_decode($dias), 'C');
}

$sql_now = "SELECT DATE_ADD(NOW(), INTERVAL 12 HOUR) as dat_now FROM dat_ingreso WHERE id_atencion = $id_atencion";

      $result_now = $conexion->query($sql_now);

      while ($row_now = $result_now->fetch_assoc()) {
        $dat_now = $row_now['dat_now'];
      }

      $sql_est = "SELECT DATEDIFF( '$dat_now' , fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
        $estancia = $row_est['estancia'];
      }
$pdf->Ln(4);
$pdf->Cell(195, 5, utf8_decode('3. Diagnóstico(s) medico(s): ' . $motivo_atn),0,0, 'L');
$pdf->Ln(4);
$pdf->Cell(195, 5, utf8_decode('4. Días de estancia: ' . $estancia . ' dias'),0,0, 'L');
$pdf->Ln(4);
$pdf->Cell(195, 5, utf8_decode('5. Motivo de interconsulta: ' . $minter),0,0, 'L');
$pdf->Ln(5);

$pdf->Cell(195, 5, utf8_decode('SUBJETIVO ¿Qué refiere?'),0,0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('1. Síntomas gastrointestinales:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($sintomas_gas),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('2. Días de ayuno:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($dias_ayuno),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('3. Cambios de peso/peso actual:
'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($cambio_peso),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('4. Funcionalidad/dependencia:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($funcionalidad),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('5. Historia dietética:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($historia_d),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(65, 4, utf8_decode('6. Malestares relacionados con nutrición/alimentación:'),0,0, 'L');
$pdf->MultiCell(130, 4, utf8_decode($malestares),1, 'L');

$pdf->Ln(2);
  $pdf->SetFont('Arial', '', 8);
$pdf->Cell(195, 5, utf8_decode('Objetivo ¿Qué medimos?'),0,0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('1. Antropometría:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($antropo),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('2. Composición corporal:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($composicion),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 4, utf8_decode('3. Signos vitales:'),0,0, 'L');
$pdf->Ln(5);
$pdf->Cell(19, 4, utf8_decode('Presión arterial:'),0,0, 'L');
$pdf->Cell(12, 4, utf8_decode($p_sistolica.'/'.$p_diastolica),1, 'L');
$pdf->Cell(25, 4, utf8_decode('Frecuencia cardiaca:'),0,0, 'L');
$pdf->Cell(10, 4, utf8_decode($f_card),1, 'L');
$pdf->Cell(28, 4, utf8_decode('Frecuencia respiratoria:'),0,0, 'L');
$pdf->Cell(10, 4, utf8_decode($f_resp),1, 'L');
$pdf->Cell(17, 4, utf8_decode('Temperatura:'),0,0, 'L');
$pdf->Cell(8, 4, utf8_decode($temp),1, 'L');
$pdf->Cell(10, 4, utf8_decode('SatO2:'),0,0, 'L');
$pdf->Cell(8, 4, utf8_decode($sat_oxigeno),1, 'L');
$pdf->Cell(15, 4, utf8_decode('Peso(kilos):'),0,0, 'L');
$pdf->Cell(8, 4, utf8_decode($peso),1, 'L');
$pdf->Cell(17, 4, utf8_decode('Talla(metros):'),0,0, 'L');
$pdf->Cell(8, 4, utf8_decode($talla),1, 'L');


$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('4. Balance hídrico:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($hidrico),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 4, utf8_decode('5. Control de liquidos:'),0,0, 'L');
$pdf->Cell(17, 4, utf8_decode('Ingresos:'),0,0, 'L');
$pdf->Cell(15, 4, utf8_decode($ingeg),1, 'L');
$pdf->Cell(31, 4, utf8_decode(''),0, 'L');
$pdf->Cell(19, 4, utf8_decode('Egresos:'),0,0, 'L');
$pdf->Cell(15, 4, utf8_decode($egrenut),1, 'L');
$pdf->Cell(25, 4, utf8_decode(''),0, 'L');
$pdf->Cell(25, 4, utf8_decode('Balance total:'),0,0, 'L');
$pdf->Cell(15, 4, utf8_decode($balineg),1, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('6. Estudios de laboratorio:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($estudioslab),1, 'L');


$pdf->Ln(2);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(195, 5, utf8_decode('ANÁLISIS ¿Qué sucede con el paciente?'),0,0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('1. Riesgo nutricional:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($rnutricional),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('2. Evaluación nutricional:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($evanutri),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('3. Diagnóstico nutricional:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($diagnutri),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('4. Limitantes alimentarias:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($limitantes),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('5. Estimación de requerimientos:'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($requerimientos),1, 'L');

$pdf->Ln(2);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(195, 5, utf8_decode('Plan ¿Cómo prescribo?'),0,0, 'L');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('1. ¿Con que alimento?'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($conque),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('2. ¿Por dónde alimento?'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($pordonde),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('3. ¿Cuánto le indico?'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($cuanto),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('4. ¿Cuándo inicio/termino?'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($cuando),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('5. ¿Qué monitoreo?'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($quemonitoreo),1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 4, utf8_decode('6. ¿Cómo progreso?'),0,0, 'L');
$pdf->MultiCell(145, 4, utf8_decode($como),1, 'L');











  $sql_med_id = "SELECT id_usua FROM dat_not_nutricion WHERE id_not_nutri=$id_in and id_atencion=$id_atencion order by id_not_nutri limit 1";
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

      $pdf->Ln(20);
     
      $pdf->SetFont('Arial', 'B', 7);
      //$pdf->Image('../../imgfirma/' . $firma, 95, 245, 25);
  if ($firma==null) {
 $pdf->Image('../../imgfirma/FIRMA.jpg', 94, 240 , 30);
} else {
    $pdf->Image('../../imgfirma/' . $firma, 94, 240 , 30);
}
      $pdf->sety(256);
      $pdf->Cell(200, 3, utf8_decode($pre . '. ' . $app ), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->SetFont('Arial', 'B', 7);
      $pdf->Cell(200, 3, utf8_decode($cargp . ' ' . 'Céd. Prof. ' . $ced_p), 0, 0, 'C');
      $pdf->Ln(3);
      $pdf->Cell(200, 3, utf8_decode('Nombre y firma del médico'), 0, 0, 'C');





 $pdf->Output();
  }