<?php
session_start();
include "../../conexionbd.php";
include("../header_medico.php");
?>
<!DOCTYPE html>
<html>
<head>
  
   <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>



    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>


<style type="text/css">
   
    .modal-lg { max-width: 65% !important; }
</style>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>NUTRICIÓN CLÍNICA</center></strong>
</div>
             
<?php

    include "../../conexionbd.php";

    if (isset($_SESSION['hospital'])) {
      $id_atencion = $_SESSION['hospital'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.folio, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
        $pac_fecing = $row_pac['fecha'];
        $pac_tip_sang = $row_pac['tip_san'];
        $pac_sexo = $row_pac['sexo'];
        $area = $row_pac['area'];
        $alta_med = $row_pac['alta_med'];
        $id_exp = $row_pac['Id_exp'];
        $folio = $row_pac['folio'];
        $alergias = $row_pac['alergias'];
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

      function calculaedad($fechanacimiento)
{
  list($ano, $mes, $dia) = explode("-", $fechanacimiento);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($ano_diferencia > 0 )
      return ($ano_diferencia . ' AÑOS');
  else if ($mes_diferencia > 0 || $ano_diferencia < 0)
      return ($mes_diferencia . ' MESES');
   else if ($dia_diferencia > 0 || $mes_diferencia < 0 || $ano_diferencia < 0)
      return ($dia_diferencia . ' DÍAS');
}

      $edad = calculaedad($pac_fecnac);

    ?>
 <font size="2">
         
  <div class="row">
    <div class="col-sm-2">
      Expediente: <strong><?php echo $folio?> </strong>
    </div>
    <div class="col-sm-6">
     Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm-4">
      Fecha de ingreso: <strong><?php echo date_format($date, "d-m-Y H:i:s") ?></strong>
    </div>
  </div>
</font>
 <font size="2">
     
  <div class="row">
    <div class="col-sm-4">
       <?php $date1 = date_create($pac_fecnac);
   ?>
    <!-- INICIO DE FUNCION DE CALCULAR EDAD -->
<?php 

function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}


$fecha_actual = date("Y-m-d");
$fecha_nac=$pac_fecnac;
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


 ?>
 <!-- TERMINO DE FUNCION DE CALCULAR EDAD -->
      Fecha de nacimiento: <strong><?php echo date_format($date1, "d-m-Y") ?></strong>
    </div>
    <div class="col-sm-4">
      Edad: <strong><?php if($anos > "0" ){
   echo $anos." años";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." meses";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." dias";
}
?></strong>
    </div>
    
   
      <div class="col-sm-2">
      Habitación: <strong><?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);                                                                                    while ($row_hab = $result_hab->fetch_assoc()) {
  echo $row_hab['num_cama'];
} ?></strong>
    </div>
    
  </div>

</font>
 <font size="2">
  <div class="row">
  <?php
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
} ?>

<?php if ($d!=null) {
   echo '<div class="col-sm-8"> Diagnóstico: <strong>' . $d .'</strong></div>';
} else{
      echo '<div class="col-sm-8"> Motivo de atención: <strong>' . $m .'</strong></div>';
}?>
    <div class="col-sm">
      Tiempo estancia: <strong><?php echo $estancia ?> Dias</strong>
    </div>
  </div>

</font>
 <font size="2">
  <div class="row">
    <div class="col-sm-4">
      Alergias: <strong><?php echo $alergias ?></strong>
    </div>
     <div class="col-sm-4">
      Estado de salud: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud ASC LIMIT 1";
$result_edo = $conexion->query($sql_edo);while ($row_edo = $result_edo->fetch_assoc()) {
  echo $row_edo['edo_salud'];
} ?></strong>
    </div>
    <div class="col-sm-3">
      Tipo de sangre: <strong><?php echo $pac_tip_sang ?></strong>
    </div>
  </div>
</font>
<?php $sql_edo = "SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_edo = $conexion->query($sql_edo);
while ($row_edo = $result_edo->fetch_assoc()) {
  $peso=$row_edo['peso'];
  $talla=$row_edo['talla'];
} 
if (!isset($peso)){
    $peso=0;
    $talla=0;
}?>
 <font size="2">
  <div class="row">
     <div class="col-sm-4">
      Peso: <strong><?php echo $peso ?></strong>
    </div>
    <div class="col-sm-3">
      Talla: <strong><?php echo $talla ?></strong>
    </div>
  </div>
</font>

</div>
        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
      }
        ?>


  <form action="" method="POST" name="form" onsubmit="return validar();">
<div class="container">
 
</div>
<div class="container">
<table class="table">
  <thead style="background-color: #2b2d7f; color:white;">
    <tr>
      <th scope="col">SCREENING INICIAL</th>
    <th scope="col"></th>
      <th scope="col">&nbsp;&nbsp; SI</th>
      <th scope="col">&nbsp;&nbsp; NO</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
     <td>IMC <20.5</td>
      <td>
        <div class="input-group mb-12">
  <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="radio" name="imc" value="SI" required>
    </div>
  </div>
</td>
      <td><div class="input-group mb-12">
  <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="radio" name="imc" value="NO">
    </div>
  </div>
</div></td>
    </tr>
    <tr>
      <th scope="row">2</th>
     <td>El paciente ha perdido peso en los últimos 3 meses</td>
      <td><div class="input-group mb-12">
  <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="radio" name="ppeso" value="SI" required>
    </div>
  </div>
</div></td>
      <td><div class="input-group mb-12">
  <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="radio" name="ppeso" value="NO">
    </div>
  </div>
</div></td>
    </tr>
    <tr>
      <th scope="row">3</th>
   <td>El paciente ha disminuido su ingesta en la última semana</td>
      <td><div class="input-group mb-12">
  <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="radio" name="dis" value="SI" required>
    </div>
  </div>
</div></td>
      <td><div class="input-group mb-12">
  <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="radio" name="dis" value="NO">
    </div>
  </div>
</div></td>
    </tr>
     <tr>
      <th scope="row">4</th>
   <td>Está el paciente gravemente enfermo</td>
      <td><div class="input-group mb-12">
  <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="radio" name="grave" value="SI" required>
    </div>
  </div>
</div></td>
      <td><div class="input-group mb-12">
  <div class="input-group-prepend">
    <div class="input-group-text">
      <input type="radio" name="grave" value="NO">
    </div>
  </div>
</div></td>
    </tr>
     <tr>
      <td colspan="4">Si la respuesta es afirmativa en alguno de los 4 apartados, realice el screening final (tabla 2.)
<br>
Si la respuesta es negativa en los 4 apartados, reevalue al paciente semanalmente. En caso de que el paciente vaya a ser sometido a una intervención de cirugía mayor, valorar la posibilidad de soporte nutricional perioperatorio para evitar el riesgo de malanutrición.
      </td>
 
    </tr>
  </tbody>
</table>
     
<table class="table table-bordered">
  <thead style="background-color: #2b2d7f; color:white;">
    <tr>
      <th colspan="2">ESTADO NUTRICIONAL</th>
      <th colspan="2">SEVERIDAD DE LA ENFERMEDAD (INCREMENTA REQUERIMENTOS)</th>
     
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>NORMAL PUNTUACIÓN: 0</td>
      <td>Normal</td>
      <td>Ausente<p> Puntuación: 0</td>
      <td>Requerimientos nutricionales normales</td>
    </tr>
    <tr>
      <td>DESNUTRICIÓN LEVE PUNTUACIÓN: 1</td>
      <td>Pérdida de peso >5% en los últimos 3 meses o ingesta inferor al 50-75% en la última semana</td>
      <td>Leve Puntuación: 1</td>
      <td>Fractura de cadera, pacientes crónicos, complicaciones agudas de cirrosis, EPOC, hemodiálisis, diabetes, enfermos oncológicos</td>
    </tr>
    <tr>
      <td>DESNUTRICIÓN MODERADO PUNTUACIÓN: 2</td>
      <td>Pérdida de peso >5% en los últimos 2 meses o IMC 18,5-20.5 + estado general deteriorado o ngsta entre 25%-60% de los requerimientos en la última semana</td>
      <td>Moderada Puntuación: 2</td>
      <td>Cirugía mayor abdominal AVC, neumonía severa y tmores hematológicos</td>
    </tr>
    <tr>
      <td>DESNUTRICIÓN GRAVE PUNTUACIÓN: 3</td>
      <td>Pérdida de peso mayor del 5% en un mes (>15% en 3 meses) o IMC <18-5 + estado general deteriorado o ingesta de 0-25% de los requermientos normales la semana previa</td>
      <td>Grave Puntuación: 3</td>
      <td>Traumatismo craneoencefálico, transplante médular. Pacientes en cuidados intensivos (APACHE>10).</td>
    </tr>
    <tr>
      <td>

  <div class="row">
    <div class="col-sm-6">
       <strong> Puntuación: </strong>
    </div>
    <div class="col">
      <div class="losInputn2">
       <input type="number" name="edopun" class="form-control" required>
     </div>
     
    </div>
  </div>




    </td>
      <td>
 <div class="row">
    <div class="col-sm-2">
        &nbsp;&nbsp;&nbsp;&nbsp; <strong>+</strong>
    </div>
    <div class="col-sm-3">
       <div class="losInputn2">
       <input type="number" name="edomas" class="form-control" required>
     </div>
    </div>
  </div>


      </td>
      <td>
 <div class="row">
    <div class="col-sm-6">
       <strong> Puntuación:</strong>
    </div>
    <div class="col">
       <div class="losInputn2">
       <input type="number" name="sepun" class="form-control" required Onchange = "mostrar('num')" id="num">
     </div>
    
    </div>
  </div>
   </td>



      <td>
<div class="row">
    <div class="col-sm-7">
      <strong> = Puntuación total:</strong>
    </div>
    <div class="col-sm-4">
      <div class="inputTotaln2">
       <input type="number" name="ptot" class="form-control" disabled>
     </div>
    </div>
  </div>
    </td>
    </tr>

    <tr>
      <td colspan="4">
         Edad si el paciente es > 70 años sumar 1 a la puntuación obtenida = puntuación ajustada por la edad
      </td>
    </tr>
<tr>
      <td colspan="4">
         <strong>Si la puntuación es >=3 el paciente está e un riesgo de malnutrición y es necesario iniciar soporte nutricional.
          Si la puntuación es <3 es necesario reevaluar semanalmente. Si el paciente va a ser sometido a cirugía mayor, iniciar soporte nutricional perioperatorio.</strong>
      </td>
    </tr>
  </tbody>
</table>
<div class="container">
NOTA: Prototipos para clasificar la severidad de la enfermedad:<p></p>
Puntuación 1:  Paciente cn enfermedad crónica ingresado en el hospital debido a complicaciones. El paciente esta debil pero no encamado. Los requerimientos proteicos están incrementados, pero pueden ser cubiertos mdiante ladeta oral o suplementos.
<p></p>
Puntuación 2: Paciente encamado debido a la enfermedad, or ejemplo, cirugía mayor abdominal. Los requerimientos proteicos están incrementados notablemente pero pueden ser cubiertos, aunque la nutrición artificial se requiere en muchos casos.
<p></p>
Puntuación 3: Pacientes e cuidados intensivos, con ventlación mecánica, etc. Los requerimientos proteicos están incrementados y no pueden ser cubiertos a psar del uso de nutrición artificial. El cataboliso proteico y las pérdidas de nitrógeno puden ser atenuadas de forma significativa.
<p></p>
<strong>Kondrup J et al, Nutritional Risk Screening (NRS 2002): Clin Nutr, 2003.</strong>
</div>
</div>

<hr>
<div class="col-sm" style="background-color: #2b2d7f; color:white;">
    PSOAP: Método que nos permite organizar la información para tener una comunicación clara mediante las notas y como indicar la calidad
    </div>
    <hr>
  <div class="row">
    <div class="col-1">
<center><strong><p><p><p><br><p><font size="5" color="#2b2d7f">P</font></strong></center>
    </div>
    <div class="col-sm-10" style="font-size: 17px;">
     <font size="5" color="#2b2d7f"><strong>Presentación</strong></font> <strong>¿Quién es?</strong>
     <br>
      1. Sexo: <strong><?php echo $pac_sexo?></strong>
      <br>
      2. Edad: <strong><?php if($anos > "0" ){
   echo $anos." años";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." meses";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." dias";
}
?></strong>
<br>
3. Diagnóstico(s) medico(s): <strong><?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
$result_mot = $conexion->query($sql_mot);
while ($row_mot = $result_mot->fetch_assoc()) {
echo $row_mot['motivo_atn'];
} ?></strong>
<br>
 4. Días de estancia: <strong><?php echo $estancia ?> Dias</strong>
 <br>
 
  <div class="row">
    <div class="col-sm-4">
    5. <button type="button" class="btn btn-success btn-sm" id="playa"><i class="fas fa-play"></button></i> Motivo de interconsulta:
    </div>
    <div class="col-sm-5">
     <input type="text" name="minter" class="form-control input-sm" id="txtpa"></nav>
    </div>
  </div>
<script type="text/javascript">
  const txtpa = document.getElementById('txtpa');
  const btnPlayTexta = document.getElementById('playa');

  btnPlayTexta.addEventListener('click', () => {
          leerTexto(txtpa.value);
  });

  function leerTexto(txtpa){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtpa;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
  </script> 
  
    </div>
  </div>

<hr>

  <div class="row">
    <div class="col-1">
<center><strong><br><br><br><br><br><br><br><br><br><br><font size="5" color="#2b2d7f">S</font></strong></center>
    </div>
    <div class="col-sm-10" style="font-size: 16.5px;">
     <font size="5" color="#2b2d7f"><strong>Subjetivo</strong></font> <strong>¿Qué refiere?</strong>
     <p>
    
  <div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playssgg"><i class="fas fa-play"></button></i> 1. Síntomas gastrointestinales: 
    </div>
    <div class="col-sm">
      <textarea class="form-control" id="textolesasas" name="sintomas_gas"></textarea>
<script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const textolesasas = document.getElementById('textolesasas');

 const btnPlayTextao = document.getElementById('playssgg');

  btnPlayTextao.addEventListener('click', () => {
          leerTexto(textolesasas.value);
  });

  function leerTexto(textolesasas){
      const speech = new SpeechSynthesisUtterance();
      speech.text= textolesasas;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let recognition = new webkitSpeechRecognition();
      recognition.lang = "es-ES";
      recognition.continuous = true;
      recognition.interimResults = false;

      recognition.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        texto.value += frase;
      }

      btnStartRecord.addEventListener('click', () => {
        recognition.start();
      });

      btnStopRecord.addEventListener('click', () => {
        recognition.abort();
      });
</script>
    </div>
  </div>
<p></p>
<div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="didag"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopdd"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playddayu"><i class="fas fa-play"></button></i> 2. Días de ayuno:
    </div>
    <div class="col-sm">
     <textarea class="form-control" id="txtdda" name="dias_ayuno"></textarea>
<script type="text/javascript">
const didag = document.getElementById('didag');
const stopdd = document.getElementById('stopdd');
const txtdda = document.getElementById('txtdda');

 const btnPlaydias = document.getElementById('playddayu');

  btnPlaydias.addEventListener('click', () => {
          leerTexto(txtdda.value);
  });

  function leerTexto(txtdda){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtdda;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let radd = new webkitSpeechRecognition();
      radd.lang = "es-ES";
      radd.continuous = true;
      radd.interimResults = false;

      radd.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtdda.value += frase;
      }

      didag.addEventListener('click', () => {
        radd.start();
      });

      stopdd.addEventListener('click', () => {
        radd.abort();
      });
</script>
    </div>
  </div>
  <p></p>
  <div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="cpag"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopcdp"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playcdppa"><i class="fas fa-play"></button></i> 3. Cambios de peso/peso actual:
    </div>
    <div class="col-sm">
    <textarea class="form-control" id="txtcdppa" name="cambio_peso"></textarea>
<script type="text/javascript">
const cpag = document.getElementById('cpag');
const stopcdp = document.getElementById('stopcdp');
const txtcdppa = document.getElementById('txtcdppa');

const btnPlaypesoca = document.getElementById('playcdppa');

  btnPlaypesoca.addEventListener('click', () => {
          leerTexto(txtcdppa.value);
  });

  function leerTexto(txtcdppa){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtcdppa;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rcdr = new webkitSpeechRecognition();
      rcdr.lang = "es-ES";
      rcdr.continuous = true;
      rcdr.interimResults = false;

      rcdr.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtcdppa.value += frase;
      }

      cpag.addEventListener('click', () => {
        rcdr.start();
      });

      stopcdp.addEventListener('click', () => {
        rcdr.abort();
      });
</script>
    </div>
  </div>
      <p></p>
  <div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="funcg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopf"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playcuncc"><i class="fas fa-play"></button></i> 4. Funcionalidad/dependencia:
    </div>
    <div class="col-sm">
    <textarea class="form-control" id="txtfd" name="funcionalidad"></textarea>
<script type="text/javascript">
const funcg = document.getElementById('funcg');
const stopf = document.getElementById('stopf');
const txtfd = document.getElementById('txtfd');

const btnPlaydep = document.getElementById('playcuncc');

  btnPlaydep.addEventListener('click', () => {
          leerTexto(txtfd.value);
  });

  function leerTexto(txtfd){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtfd;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rfunr = new webkitSpeechRecognition();
      rfunr.lang = "es-ES";
      rfunr.continuous = true;
      rfunr.interimResults = false;

      rfunr.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtfd.value += frase;
      }

      funcg.addEventListener('click', () => {
        rfunr.start();
      });

      stopf.addEventListener('click', () => {
        rfunr.abort();
      });
</script>
    </div>
  </div>
<p></p>
  <div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="dietg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stophd"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playdietecia"><i class="fas fa-play"></button></i> 5. Historia dietética:
    </div>
    <div class="col-sm">
   <textarea class="form-control" id="txthd" name="historia_d"></textarea>
<script type="text/javascript">
const dietg = document.getElementById('dietg');
const stophd = document.getElementById('stophd');
const txthd = document.getElementById('txthd');

const btnPlaydietatica = document.getElementById('playdietecia');

  btnPlaydietatica.addEventListener('click', () => {
          leerTexto(txthd.value);
  });

  function leerTexto(txthd){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txthd;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rhisr = new webkitSpeechRecognition();
      rhisr.lang = "es-ES";
      rhisr.continuous = true;
      rhisr.interimResults = false;

      rhisr.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txthd.value += frase;
      }

      dietg.addEventListener('click', () => {
        rhisr.start();
      });

      stophd.addEventListener('click', () => {
        rhisr.abort();
      });
</script>
    </div>
  </div>
<p></p>
  <div class="row">
    <div class="col-sm-4">
<button type="button" class="btn btn-danger btn-sm" id="margan"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopanc"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playalimm"><i class="fas fa-play"></button></i> 6. Malestares relacionados con nutrición/alimentación:
    </div>
    <div class="col-sm">
  <textarea class="form-control" id="txtmrc" name="malestares"></textarea>
<script type="text/javascript">
const margan = document.getElementById('margan');
const stopanc = document.getElementById('stopanc');
const txtmrc = document.getElementById('txtmrc');

const btnPlayall = document.getElementById('playalimm');

  btnPlayall.addEventListener('click', () => {
          leerTexto(txtmrc.value);
  });

  function leerTexto(txtmrc){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtmrc;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rmalr = new webkitSpeechRecognition();
      rmalr.lang = "es-ES";
      rmalr.continuous = true;
      rmalr.interimResults = false;

      rmalr.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtmrc.value += frase;
      }

      margan.addEventListener('click', () => {
        rmalr.start();
      });

      stopanc.addEventListener('click', () => {
        rmalr.abort();
      });
</script>
    </div>
  </div>
       <p></p>
    </div>
  </div>
<hr>

 <div class="row">
    <div class="col-1">
<center><strong><br><br><br><br><br><br><br><br><br><br><font size="5" color="#2b2d7f">O</font></strong></center>
    </div>
    <div class="col-sm-10" style="font-size: 17px;">
     <font size="5" color="#2b2d7f"><strong>Objetivo</strong></font> <strong>¿Qué medimos?</strong>
     <p>
    
  <div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="antrog"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopnan"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playantrooo"><i class="fas fa-play"></button></i> 1. Antropometría: 
    </div>
    <div class="col-sm">
      <textarea class="form-control" id="txtantro" name="antropo"></textarea>
<script type="text/javascript">
const antrog = document.getElementById('antrog');
const stopnan = document.getElementById('stopnan');
const txtantro = document.getElementById('txtantro');

const btnPlayatron = document.getElementById('playantrooo');

  btnPlayatron.addEventListener('click', () => {
          leerTexto(txtantro.value);
  });

  function leerTexto(txtantro){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtantro;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rantror = new webkitSpeechRecognition();
      rantror.lang = "es-ES";
      rantror.continuous = true;
      rantror.interimResults = false;

      rantror.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtantro.value += frase;
      }

      antrog.addEventListener('click', () => {
        rantror.start();
      });

      stopnan.addEventListener('click', () => {
        rantror.abort();
      });
</script>
    </div>
  </div>
<p></p>
<div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="compog"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopcorc"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playcomcoa"><i class="fas fa-play"></button></i> 2. Composición corporal:
    </div>
    <div class="col-sm">
     <textarea class="form-control" id="txtcc" name="composicion"></textarea>
<script type="text/javascript">
const compog = document.getElementById('compog');
const stopcorc = document.getElementById('stopcorc');
const txtcc = document.getElementById('txtcc');

const btnPlaycaac = document.getElementById('playcomcoa');

  btnPlaycaac.addEventListener('click', () => {
          leerTexto(txtcc.value);
  });

  function leerTexto(txtcc){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtcc;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }


     let rcorp = new webkitSpeechRecognition();
      rcorp.lang = "es-ES";
      rcorp.continuous = true;
      rcorp.interimResults = false;

      rcorp.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtcc.value += frase;
      }

      compog.addEventListener('click', () => {
        rcorp.start();
      });

      stopcorc.addEventListener('click', () => {
        rcorp.abort();
      });
</script>
    </div>
  </div>
  <p></p>
  <div class="row">
    <div class="col-sm-2">
      <p></p>
3. Signos vitales:
    </div>
  </div>
  
<div class="row">
  <div class="col-sm-3"><center><br><button type="button" class="btn btn-success btn-sm" id="playpreartt"><i class="fas fa-play"></button></i> Presión arterial: <h7 id='resultado'></h7></center>
             <div class="row">
                <div class="col"><input type="text" name="p_sistolica" id="p_sistolica"  class="form-control" value="" min="0"  max="250" onkeyup="validarEmail(this)" required></div> /
                <div class="col"> <input type="text" name="p_diastolica" id="p_diastolica" class="form-control" value="" min="0" max="180" required onkeyup="validarEmail(this)"></div>
<script type="text/javascript">
const p_sistolica = document.getElementById('p_sistolica');
const btnPlays = document.getElementById('playpreartt');

  btnPlays.addEventListener('click', () => {
          leerTexto(p_sistolica.value);
  });

  function leerTexto(p_sistolica){
      const speech = new SpeechSynthesisUtterance();
      speech.text= p_sistolica;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

const p_diastolica = document.getElementById('p_diastolica');
const btnPlaysd = document.getElementById('playpreartt');

  btnPlaysd.addEventListener('click', () => {
          leerTexto(p_diastolica.value);
  });

  function leerTexto(p_diastolica){
      const speech = new SpeechSynthesisUtterance();
      speech.text= p_diastolica;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
            </div>
        </div>
        <div class="col-sm-2"><button type="button" class="btn btn-success btn-sm" id="play10"><i class="fas fa-play"></button></i> Frecuencia cardiaca: <h7 id='resultado2'></h7>
                <input type="text" name="f_card" id="f_card" class="form-control" value="" min="0" max="150" required onkeyup="validarfreccar(this)">   
        </div>
<script type="text/javascript">
const f_card = document.getElementById('f_card');
const btnPlayfca = document.getElementById('play10');

  btnPlayfca.addEventListener('click', () => {
          leerTexto(f_card.value);
  });

  function leerTexto(f_card){
      const speech = new SpeechSynthesisUtterance();
      speech.text= f_card;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
        <div class="col-sm"><button type="button" class="btn btn-success btn-sm" id="play11"><i class="fas fa-play"></button></i> Frecuencia respiratoria: <h7 id='resultado3'></h7>
                <input type="text" name="f_resp" id="f_resp" min="0" max="100" class="form-control" value="" onkeyup="validarfrecresp(this)" required >
        </div>
<script type="text/javascript">
const f_resp = document.getElementById('f_resp');
const btnPlayfres = document.getElementById('play11');

  btnPlayfres.addEventListener('click', () => {
          leerTexto(f_resp.value);
  });

  function leerTexto(f_resp){
      const speech = new SpeechSynthesisUtterance();
      speech.text= f_resp;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
        <div class="col-sm"><br><button type="button" class="btn btn-success btn-sm" id="play112"><i class="fas fa-play"></button></i> Temperatura: <h7 id='resultado4'></h7>
             <input type="cm-number" name="temp" id="temp" class="form-control" 
             value="" min="0" max="46"required onkeyup="validartem(this)">
        </div>
<script type="text/javascript">
const temp = document.getElementById('temp');
const btnPlaytemte = document.getElementById('play112');

  btnPlaytemte.addEventListener('click', () => {
          leerTexto(temp.value);
  });

  function leerTexto(temp){
      const speech = new SpeechSynthesisUtterance();
      speech.text= temp;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
        <div class="col-sm"><button type="button" class="btn btn-success btn-sm" id="plays2"><i class="fas fa-play"></button></i> Saturación oxígeno: <h7 id='resultado5'></h7>
            <input type="texto" name="sat_oxigeno" min="0" max="100" id="sat_oxigeno" class="form-control" value="" required onkeyup="validarsat(this)">
           
        </div>
<script type="text/javascript">
const sat_oxigeno = document.getElementById('sat_oxigeno');
const btnPlaysat_o = document.getElementById('plays2');

  btnPlaysat_o.addEventListener('click', () => {
          leerTexto(sat_oxigeno.value);
  });

  function leerTexto(sat_oxigeno){
      const speech = new SpeechSynthesisUtterance();
      speech.text= sat_oxigeno;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
         <div class="col-sm"><button type="button" class="btn btn-success btn-sm" id="plays2peso"><i class="fas fa-play"></button></i> Peso <br>(kilos):
            <input type="cm-number" name="peso"  id="peso" class="form-control" required>
        </div>
<script type="text/javascript">
const peso = document.getElementById('peso');
const btnPlaypso = document.getElementById('plays2peso');

  btnPlaypso.addEventListener('click', () => {
          leerTexto(peso.value);
  });

  function leerTexto(peso){
      const speech = new SpeechSynthesisUtterance();
      speech.text= peso;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
        <div class="col-sm"><button type="button" class="btn btn-success btn-sm" id="plays2talla"><i class="fas fa-play"></button></i>Talla <br> (metros): 
            <input type="cm-number" name="talla"  id="talla" class="form-control"  required>
        </div>
</div>
<script type="text/javascript">
const talla = document.getElementById('talla');
const btnPlayllata = document.getElementById('plays2talla');

  btnPlayllata.addEventListener('click', () => {
          leerTexto(talla.value);
  });

  function leerTexto(talla){
      const speech = new SpeechSynthesisUtterance();
      speech.text= talla;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
      <p></p>
  <div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="balg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopceh"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playdrib"><i class="fas fa-play"></button></i> 4. Balance hídrico:
    </div>
    <div class="col-sm">
    <textarea class="form-control" id="txtbalh" name="hidrico"></textarea>
<script>
const balg = document.getElementById('balg');
const stopceh = document.getElementById('stopceh');
const txtbalh = document.getElementById('txtbalh');

const btnPlayhha = document.getElementById('playdrib');

  btnPlayhha.addEventListener('click', () => {
          leerTexto(txtbalh.value);
  });

  function leerTexto(txtbalh){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtbalh;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let ridr = new webkitSpeechRecognition();
      ridr.lang = "es-ES";
      ridr.continuous = true;
      ridr.interimResults = false;

      ridr.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtbalh.value += frase;
      }

      balg.addEventListener('click', () => {
        ridr.start();
      });

      stopceh.addEventListener('click', () => {
        ridr.abort();
      });
</script>
    </div>
  </div>
<p></p>
  <div class="row">
      <div class="col-sm-2">
  <button type="button" class="btn btn-success btn-sm" id="playiiiiiii"><i class="fas fa-play"></button></i>   5. Ingresos:
    </div>
    <div class="col-sm">
  <input type="number" name="ingeg" class="form-control input-sm" id="ingresos">
    </div>


    <div class="col-sm-2">
<button type="button" class="btn btn-success btn-sm" id="playegggre"><i class="fas fa-play"></button></i> Egresos:
    </div>
    <div class="col-sm">
        
  <input type="number" name="egrenut" class="form-control input-sm" id="egresos">
    </div>
   <script>

const btnPlaynniaeg = document.getElementById('playegggre');

  btnPlaynniaeg.addEventListener('click', () => {
          leerTexto(egresos.value);
  });

  function leerTexto(egresos){
      const speech = new SpeechSynthesisUtterance();
      speech.text= egresos;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
    <div class="col-sm-2">
<button type="button" class="btn btn-success btn-sm" id="playebaltot"><i class="fas fa-play"></button></i> Total (Balance):
    </div>
    <div class="col-sm">
 
  <input type="number" name="" class="form-control input-sm" disabled id="totineg">

    </div>
  </div>
  <script>

const btnPlaytoteginval = document.getElementById('playebaltot');

  btnPlaytoteginval.addEventListener('click', () => {
          leerTexto(totineg.value);
  });

  function leerTexto(totineg){
      const speech = new SpeechSynthesisUtterance();
      speech.text= totineg;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
  <script type="text/javascript">
  
let ingresos = document.getElementById("ingresos")
        let egresos = document.getElementById("egresos")
        let totineg = document.getElementById("totineg")
        
        egresos.addEventListener("change", () =>{
            totineg.value = parseFloat(ingresos.value) - parseFloat(egresos.value)

        });
</script>

<script>

const btnPlaynnin = document.getElementById('playiiiiiii');

  btnPlaynnin.addEventListener('click', () => {
          leerTexto(ingresos.value);
  });

  function leerTexto(ingresos){
      const speech = new SpeechSynthesisUtterance();
      speech.text= ingresos;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>

<script type="text/javascript">
const totineg = document.getElementById('totineg');
const btnPlayasas = document.getElementById('playasas');

  btnPlayasas.addEventListener('click', () => {
          leerTexto(totineg.value);
  });

  function leerTexto(totineg){
      const speech = new SpeechSynthesisUtterance();
      speech.text= totineg;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
<p></p>
  <div class="row">
    <div class="col-sm-4">
<button type="button" class="btn btn-danger btn-sm" id="labesg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopesla"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playlabbb"><i class="fas fa-play"></button></i>
 6. Estudios de laboratorio:
    </div>
    <div class="col-sm">
  <textarea class="form-control" id="txtesdl" name="estudioslab"></textarea>
<script type="text/javascript">
const labesg = document.getElementById('labesg');
const stopesla = document.getElementById('stopesla');
const txtesdl = document.getElementById('txtesdl');

const btnPlayasaslab = document.getElementById('playlabbb');

  btnPlayasaslab.addEventListener('click', () => {
          leerTexto(txtesdl.value);
  });

  function leerTexto(txtesdl){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtesdl;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }


     let resrlab = new webkitSpeechRecognition();
      resrlab.lang = "es-ES";
      resrlab.continuous = true;
      resrlab.interimResults = false;

      resrlab.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtesdl.value += frase;
      }

      labesg.addEventListener('click', () => {
        resrlab.start();
      });

      stopesla.addEventListener('click', () => {
        resrlab.abort();
      });
</script>
    </div>
  </div>
       <p></p>
    </div>
  </div>
<hr>
<div class="row">
    <div class="col-1">
<center><strong><br><br><br><br><br><br><br><br><br><font size="5" color="#2b2d7f">A</font></strong></center>
    </div>
    <div class="col-sm-10" style="font-size: 17px;">
     <font size="5" color="#2b2d7f"><strong>Análisis</strong></font> <strong> ¿Qué sucede con el paciente?</strong>
     <p>
    
  <div class="row">
    <div class="col-sm-1">
       </div>
    <div class="col-sm-3">
      <p></p>

<!--<button type="button" class="btn btn-danger btn-sm" id="riesgntg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopnutri"><i class="fas fa-microphone-slash"></button></i>--><button type="button" class="btn btn-success btn-sm" id="playrrnn"><i class="fas fa-play"></button></i> 1. Riesgo nutricional: 
    </div>
    <div class="col-sm-4"><p>
       
<div class="inputTotaln22"><input type="text" name="rnutricional" id="txtriesn" class="form-control input-sm" disabled></div>
<script type="text/javascript">

const txtriesn = document.getElementById('txtriesn');

const btnPlayriesgnn = document.getElementById('playrrnn');

  btnPlayriesgnn.addEventListener('click', () => {
          leerTexto(txtriesn.value);
  });

  function leerTexto(txtriesn){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtriesn;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

</script>


<script type="text/javascript">
const riesgntg = document.getElementById('riesgntg');
const stopnutri = document.getElementById('stopnutri');
const txtriesn = document.getElementById('txtriesn');

     let rrn = new webkitSpeechRecognition();
      rrn.lang = "es-ES";
      rrn.continuous = true;
      rrn.interimResults = false;

      rrn.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtriesn.value += frase;
      }

      riesgntg.addEventListener('click', () => {
        rrn.start();
      });

      stopnutri.addEventListener('click', () => {
        rrn.abort();
      });
</script>
    </div>
  </div>
<p></p>
<div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="evanutrig"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopnutrieva"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playevvv"><i class="fas fa-play"></button></i> 2. Evaluación nutricional:
    </div>
    <div class="col-sm">
     <textarea class="form-control" id="txtevan" name="evanutri"></textarea>
<script type="text/javascript">
const evanutrig = document.getElementById('evanutrig');
const stopnutrieva = document.getElementById('stopnutrieva');
const txtevan = document.getElementById('txtevan');

const btnPlayevvaa = document.getElementById('playevvv');

  btnPlayevvaa.addEventListener('click', () => {
          leerTexto(txtevan.value);
  });

  function leerTexto(txtevan){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtevan;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let revar = new webkitSpeechRecognition();
      revar.lang = "es-ES";
      revar.continuous = true;
      revar.interimResults = false;

      revar.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtevan.value += frase;
      }

      evanutrig.addEventListener('click', () => {
        revar.start();
      });

      stopnutrieva.addEventListener('click', () => {
        revar.abort();
      });
</script>
    </div>
  </div>
  <p></p>
  <div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="dng"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopcinal"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playdiinna"><i class="fas fa-play"></button></i>  3. Diagnóstico nutricional:
    </div>
    <div class="col-sm">
    <textarea class="form-control" id="txtdiagnutr" name="diagnutri"></textarea>
<script type="text/javascript">
const dng = document.getElementById('dng');
const stopcinal = document.getElementById('stopcinal');
const txtdiagnutr = document.getElementById('txtdiagnutr');

const btnPlayevvaaa = document.getElementById('playdiinna');

  btnPlayevvaaa.addEventListener('click', () => {
          leerTexto(txtdiagnutr.value);
  });

  function leerTexto(txtdiagnutr){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtdiagnutr;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rdnrd = new webkitSpeechRecognition();
      rdnrd.lang = "es-ES";
      rdnrd.continuous = true;
      rdnrd.interimResults = false;

      rdnrd.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtdiagnutr.value += frase;
      }

      dng.addEventListener('click', () => {
        rdnrd.start();
      });

      stopcinal.addEventListener('click', () => {
        rdnrd.abort();
      });
</script>
    </div>
  </div>
      <p></p>
  <div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="limg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopalime"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playallli"><i class="fas fa-play"></button></i> 4. Limitantes alimentarias:
    </div>
    <div class="col-sm">
    <textarea class="form-control" id="txtlima" name="limitantes"></textarea>
<script type="text/javascript">
const limg = document.getElementById('limg');
const stopalime = document.getElementById('stopalime');
const txtlima = document.getElementById('txtlima');

const btnPlli = document.getElementById('playallli');

  btnPlli.addEventListener('click', () => {
          leerTexto(txtlima.value);
  });

  function leerTexto(txtlima){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtlima;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rlar = new webkitSpeechRecognition();
      rlar.lang = "es-ES";
      rlar.continuous = true;
      rlar.interimResults = false;

      rlar.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtlima.value += frase;
      }

      limg.addEventListener('click', () => {
        rlar.start();
      });

      stopalime.addEventListener('click', () => {
        rlar.abort();
      });
</script>
    </div>
  </div>
<p></p>
  <div class="row">
    <div class="col-sm-4">
      <p></p>
<button type="button" class="btn btn-danger btn-sm" id="edrg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stoprde"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playrquemaa"><i class="fas fa-play"></button></i> 5. Estimación de requerimientos:
    </div>
    <div class="col-sm">
   <textarea class="form-control" id="txtesdr" name="requerimientos"></textarea>
<script type="text/javascript">
const edrg = document.getElementById('edrg');
const stoprde = document.getElementById('stoprde');
const txtesdr = document.getElementById('txtesdr');

const btnPllali = document.getElementById('playrquemaa');

  btnPllali.addEventListener('click', () => {
          leerTexto(txtesdr.value);
  });

  function leerTexto(txtesdr){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtesdr;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let resrr = new webkitSpeechRecognition();
      resrr.lang = "es-ES";
      resrr.continuous = true;
      resrr.interimResults = false;

      resrr.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtesdr.value += frase;
      }

      edrg.addEventListener('click', () => {
        resrr.start();
      });

      stoprde.addEventListener('click', () => {
        resrr.abort();
      });
</script>
    </div>
  </div>
       <p></p>
    </div>
  </div>
 <hr>

 <div class="row">
    <div class="col-1">
<center><strong><br><br><br><br><br><br><br><br><br><br><font size="5" color="#2b2d7f">P</font></strong></center>
    </div>
    <div class="col-sm-10" style="font-size: 17px;">
     <font size="5" color="#2b2d7f"><strong>Plan</strong></font> <strong> ¿Cómo prescribo?</strong>
     <p>
    
  <div class="row">
    <div class="col-sm-4">
      <p></p>
   <button type="button" class="btn btn-danger btn-sm" id="ccgq"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopquecon"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playcqall"><i class="fas fa-play"></button></i> 1. ¿Con que alimento?
    </div>
    <div class="col-sm">
      <textarea class="form-control" id="txtcqa" name="conque"></textarea>
<script type="text/javascript">
const ccgq = document.getElementById('ccgq');
const stopquecon = document.getElementById('stopquecon');
const txtcqa = document.getElementById('txtcqa');

const btncon = document.getElementById('playcqall');

  btncon.addEventListener('click', () => {
          leerTexto(txtcqa.value);
  });

  function leerTexto(txtcqa){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtcqa;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rcquer = new webkitSpeechRecognition();
      rcquer.lang = "es-ES";
      rcquer.continuous = true;
      rcquer.interimResults = false;

      rcquer.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtcqa.value += frase;
      }

      ccgq.addEventListener('click', () => {
        rcquer.start();
      });

      stopquecon.addEventListener('click', () => {
        rcquer.abort();
      });
</script>
    </div>
  </div>
<p></p>
<div class="row">
    <div class="col-sm-4">
      <p></p>
    <button type="button" class="btn btn-danger btn-sm" id="pdaga"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopaldnde"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playadondee"><i class="fas fa-play"></button></i> 2. ¿Por dónde alimento?
    </div>
    <div class="col-sm">
     <textarea class="form-control" id="txtpda" name="pordonde"></textarea>
<script type="text/javascript">
const pdaga = document.getElementById('pdaga');
const stopaldnde = document.getElementById('stopaldnde');
const txtpda = document.getElementById('txtpda');

const btnconala = document.getElementById('playadondee');

  btnconala.addEventListener('click', () => {
          leerTexto(txtpda.value);
  });

  function leerTexto(txtpda){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtpda;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rporrr = new webkitSpeechRecognition();
      rporrr.lang = "es-ES";
      rporrr.continuous = true;
      rporrr.interimResults = false;

      rporrr.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtpda.value += frase;
      }

      pdaga.addEventListener('click', () => {
        rporrr.start();
      });

      stopaldnde.addEventListener('click', () => {
        rporrr.abort();
      });
</script>
    </div>
  </div>
  <p></p>
  <div class="row">
    <div class="col-sm-4">
      <p></p>
   <button type="button" class="btn btn-danger btn-sm" id="cualig"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopindico"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playindicoooo"><i class="fas fa-play"></button></i> 3. ¿Cuánto le indico?
    </div>
    <div class="col-sm">
    <textarea class="form-control" id="cindico" name="cuanto"></textarea>
<script type="text/javascript">
const cualig = document.getElementById('cualig');
const stopindico = document.getElementById('stopindico');
const cindico = document.getElementById('cindico');

const btncinddd = document.getElementById('playindicoooo');

  btncinddd.addEventListener('click', () => {
          leerTexto(cindico.value);
  });

  function leerTexto(cindico){
      const speech = new SpeechSynthesisUtterance();
      speech.text= cindico;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rcuar = new webkitSpeechRecognition();
      rcuar.lang = "es-ES";
      rcuar.continuous = true;
      rcuar.interimResults = false;

      rcuar.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        cindico.value += frase;
      }

      cualig.addEventListener('click', () => {
        rcuar.start();
      });

      stopindico.addEventListener('click', () => {
        rcuar.abort();
      });
</script>
    </div>
  </div>
      <p></p>
  <div class="row">
    <div class="col-sm-4">
      <p></p>
   <button type="button" class="btn btn-danger btn-sm" id="cuandoig"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopterm"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playunite"><i class="fas fa-play"></button></i> 4. ¿Cuándo inicio/termino?
    </div>
    <div class="col-sm">
    <textarea class="form-control" id="txtcuando" name="cuando"></textarea>
<script type="text/javascript">
const cuandoig = document.getElementById('cuandoig');
const stopterm = document.getElementById('stopterm');
const txtcuando = document.getElementById('txtcuando');

const btncuandooo = document.getElementById('playunite');

  btncuandooo.addEventListener('click', () => {
          leerTexto(txtcuando.value);
  });

  function leerTexto(txtcuando){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtcuando;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rintr = new webkitSpeechRecognition();
      rintr.lang = "es-ES";
      rintr.continuous = true;
      rintr.interimResults = false;

      rintr.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtcuando.value += frase;
      }

      cuandoig.addEventListener('click', () => {
        rintr.start();
      });

      stopterm.addEventListener('click', () => {
        rintr.abort();
      });
</script>
    </div>
  </div>
<p></p>
  <div class="row">
    <div class="col-sm-4">
      <p></p>
    <button type="button" class="btn btn-danger btn-sm" id="quemong"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopmonque"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playquemonnn"><i class="fas fa-play"></button></i> 5. ¿Qué monitoreo?
    </div>
    <div class="col-sm">
   <textarea class="form-control" id="txtque" name="quemonitoreo"></textarea>
<script type="text/javascript">
const quemong = document.getElementById('quemong');
const stopmonque = document.getElementById('stopmonque');
const txtque = document.getElementById('txtque');

const btncasaas = document.getElementById('playquemonnn');

  btncasaas.addEventListener('click', () => {
          leerTexto(txtque.value);
  });

  function leerTexto(txtque){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtque;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
     let remonquer = new webkitSpeechRecognition();
      remonquer.lang = "es-ES";
      remonquer.continuous = true;
      remonquer.interimResults = false;

      remonquer.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtque.value += frase;
      }

      quemong.addEventListener('click', () => {
        remonquer.start();
      });

      stopmonque.addEventListener('click', () => {
        remonquer.abort();
      });
</script>
    </div>
  </div>
       <p></p>
       <div class="row">
    <div class="col-sm-4">
      <p></p>
 <button type="button" class="btn btn-danger btn-sm" id="comoprogreso"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopprogr"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="playprogress"><i class="fas fa-play"></button></i> 6. ¿Cómo progreso?
    </div>
    <div class="col-sm">
   <textarea class="form-control" id="txtcomo" name="como"></textarea>
<script type="text/javascript">
const comoprogreso = document.getElementById('comoprogreso');
const stopprogr = document.getElementById('stopprogr');
const txtcomo = document.getElementById('txtcomo');

const btncomasmo = document.getElementById('playprogress');

  btncomasmo.addEventListener('click', () => {
          leerTexto(txtcomo.value);
  });

  function leerTexto(txtcomo){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtcomo;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
     let recopror = new webkitSpeechRecognition();
      recopror.lang = "es-ES";
      recopror.continuous = true;
      recopror.interimResults = false;

      recopror.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtcomo.value += frase;
      }

      comoprogreso.addEventListener('click', () => {
        recopror.start();
      });

      stopprogr.addEventListener('click', () => {
        recopror.abort();
      });
</script>
    </div>
  </div>
       <p></p>
    </div>

  </div>
<hr>
<div class="row">
 <div class=" col-sm-1">
 </div>
    <div class=" col-sm-7">
<strong><button type="button" class="btn btn-success btn-sm" id="plaguiaaa"><i class="fas fa-play"></button></i> Guía de práctica clínica:</strong>

<div class="form-group">

     <div class="form-group">
        <select name="guia" class="form-control" data-live-search="true" id="mibuscador11" onchange="ShowSelected();" style="width : 100%; heigth : 100%">
            <option value="">Seleccionar guía clínica</option>
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM gpclinica ORDER by id_gpc";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
echo "<option value='" . $row['gpc'] . "'>" . $row['cve_gpc'] . "- " .$row['gpc']."</option>";
}
 ?></select>
  </div>

</div>
</div>
<script type="text/javascript">
const mibuscador11 = document.getElementById('mibuscador11');
const btncomasm1 = document.getElementById('plaguiaaa');
  btncomasm1.addEventListener('click', () => {
          leerTexto(mibuscador11.value);
  });

  function leerTexto(mibuscador11){
      const speech = new SpeechSynthesisUtterance();
      speech.text= mibuscador11;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
<div class="col-sm-3">
<p></p>
<button type="button" class="btn btn bg-navy" data-toggle="modal" data-target=".bd-example-modal-lg"><strong>Links de guía de práctica clínica</strong></button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header content-center">
        <h4><b>Guía de práctica clínica</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
         <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
            </div>
     <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
                    <th scope="col"><center>Clave</center></th>
                    <th scope="col"><center>Guía & Link</center></th>
                </tr>
                </thead>
                <tbody>
<?php
$sql_diag="SELECT * FROM gpclinica ORDER by id_gpc";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){            
    ?>
                    <tr> 
<td class="fondo"><strong><?php echo $row['cve_gpc'];?></strong></td>
<td class="fondo"><a href="<?php echo $row['link']?>" target=”_blank”><strong><?php echo $row['gpc'];?></strong></td></a>   
                    </tr>
                <?php
                }
                ?>
                </tbody>
              
            </table>
            </div>
  </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Regresar</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>




<div class="form-group"><center>
<center><button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
<button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button></center>

</div>


<br>
<br>
  </form>


   <!--TERMINO DE NOTA DE NUTRICIÓN-->
<?php 
  if (isset($_POST['guardar'])) {

  $sintomas_gas = mysqli_real_escape_string($conexion, (strip_tags($_POST['sintomas_gas'], ENT_QUOTES)));
  $dias_ayuno = mysqli_real_escape_string($conexion, (strip_tags($_POST['dias_ayuno'], ENT_QUOTES)));
  $cambio_peso = mysqli_real_escape_string($conexion, (strip_tags($_POST['cambio_peso'], ENT_QUOTES)));
  $funcionalidad = mysqli_real_escape_string($conexion, (strip_tags($_POST['funcionalidad'], ENT_QUOTES)));
  $historia_d = mysqli_real_escape_string($conexion, (strip_tags($_POST['historia_d'], ENT_QUOTES)));
  $malestares = mysqli_real_escape_string($conexion, (strip_tags($_POST['malestares'], ENT_QUOTES)));
  $antropo = mysqli_real_escape_string($conexion, (strip_tags($_POST['antropo'], ENT_QUOTES)));
  $composicion = mysqli_real_escape_string($conexion, (strip_tags($_POST['composicion'], ENT_QUOTES)));
  $p_sistolica = mysqli_real_escape_string($conexion, (strip_tags($_POST['p_sistolica'], ENT_QUOTES)));

$p_sistolica = mysqli_real_escape_string($conexion, (strip_tags($_POST['p_sistolica'], ENT_QUOTES)));
$p_diastolica = mysqli_real_escape_string($conexion, (strip_tags($_POST['p_diastolica'], ENT_QUOTES)));
$f_card = mysqli_real_escape_string($conexion, (strip_tags($_POST['f_card'], ENT_QUOTES)));
$f_resp = mysqli_real_escape_string($conexion, (strip_tags($_POST['f_resp'], ENT_QUOTES)));
$temp = mysqli_real_escape_string($conexion, (strip_tags($_POST['temp'], ENT_QUOTES)));
$sat_oxigeno = mysqli_real_escape_string($conexion, (strip_tags($_POST['sat_oxigeno'], ENT_QUOTES)));
$peso = mysqli_real_escape_string($conexion, (strip_tags($_POST['peso'], ENT_QUOTES)));
$talla = mysqli_real_escape_string($conexion, (strip_tags($_POST['talla'], ENT_QUOTES)));
$minter = mysqli_real_escape_string($conexion, (strip_tags($_POST['minter'], ENT_QUOTES)));



  $hidrico = mysqli_real_escape_string($conexion, (strip_tags($_POST['hidrico'], ENT_QUOTES)));
  $ingeg = mysqli_real_escape_string($conexion, (strip_tags($_POST['ingeg'], ENT_QUOTES)));
  $estudioslab = mysqli_real_escape_string($conexion, (strip_tags($_POST['estudioslab'], ENT_QUOTES)));
  //$rnutricional = mysqli_real_escape_string($conexion, (strip_tags($_POST['rnutricional'], ENT_QUOTES)));
  $evanutri = mysqli_real_escape_string($conexion, (strip_tags($_POST['evanutri'], ENT_QUOTES)));
  $diagnutri = mysqli_real_escape_string($conexion, (strip_tags($_POST['diagnutri'], ENT_QUOTES)));
  $limitantes = mysqli_real_escape_string($conexion, (strip_tags($_POST['limitantes'], ENT_QUOTES)));
  $requerimientos = mysqli_real_escape_string($conexion, (strip_tags($_POST['requerimientos'], ENT_QUOTES)));
  $conque = mysqli_real_escape_string($conexion, (strip_tags($_POST['conque'], ENT_QUOTES)));
  $pordonde = mysqli_real_escape_string($conexion, (strip_tags($_POST['pordonde'], ENT_QUOTES)));
  $cuanto = mysqli_real_escape_string($conexion, (strip_tags($_POST['cuanto'], ENT_QUOTES)));
  $cuando = mysqli_real_escape_string($conexion, (strip_tags($_POST['cuando'], ENT_QUOTES)));
  $quemonitoreo = mysqli_real_escape_string($conexion, (strip_tags($_POST['quemonitoreo'], ENT_QUOTES)));
  $como = mysqli_real_escape_string($conexion, (strip_tags($_POST['como'], ENT_QUOTES)));
  $imc    = mysqli_real_escape_string($conexion, (strip_tags($_POST["imc"], ENT_QUOTES)));
  $ppeso    = mysqli_real_escape_string($conexion, (strip_tags($_POST["ppeso"], ENT_QUOTES)));
  $dis    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dis"], ENT_QUOTES)));
  $grave    =mysqli_real_escape_string($conexion, (strip_tags($_POST["grave"], ENT_QUOTES)));
  $edopun    = mysqli_real_escape_string($conexion, (strip_tags($_POST["edopun"], ENT_QUOTES)));
  $edomas    = mysqli_real_escape_string($conexion, (strip_tags($_POST["edomas"], ENT_QUOTES)));
  $sepun = mysqli_real_escape_string($conexion, (strip_tags($_POST['sepun'], ENT_QUOTES)));
if($sepun==1){
  $resultadorn="Leve";
}else
if($sepun==2){
  $resultadorn="Moderado";
}else
if($sepun==3){
  $resultadorn="Grave";
}

  $ptot = $edopun+$edomas+$sepun;
  
$egrenut = mysqli_real_escape_string($conexion, (strip_tags($_POST['egrenut'], ENT_QUOTES)));
$guia = mysqli_real_escape_string($conexion, (strip_tags($_POST['guia'], ENT_QUOTES)));
$balineg = $ingeg - $egrenut;

$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$fecha_actual = date("Y-m-d H:i:s");
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];


$nombre_medico=$nombre.' '.$papell.' '.$sapell;


$insertar = mysqli_query($conexion, 'INSERT INTO dat_not_nutricion(id_atencion,id_usua,fecha_not_nutri,imc,ppeso,dis,grave,edopun,edomas,sepun,ptot,sintomas_gas,dias_ayuno,cambio_peso,funcionalidad,historia_d,malestares,antropo,composicion,p_sistolica,p_diastolica,f_card,f_resp,temp,sat_oxigeno,peso,talla,hidrico,ingeg,estudioslab,rnutricional,evanutri,diagnutri,limitantes,requerimientos,conque,pordonde,cuanto,cuando,quemonitoreo,como,minter,egrenut,balineg,guia) values (' . $id_atencion . ',' . $id_usua . ',"' . $fecha_actual . '","' . $imc . '","' . $ppeso . '","' . $dis . '","' . $grave . '","' . $edopun . '","' . $edomas . '","' . $sepun . '","' . $ptot . '","' . $sintomas_gas . '","' . $dias_ayuno . '","' . $cambio_peso . '","' . $funcionalidad . '","' . $historia_d . '","' . $malestares . '","' . $antropo . '","' . $composicion . '","' . $p_sistolica . '","' . $p_diastolica . '","' . $f_card . '","' . $f_resp . '","' . $temp . '","' . $sat_oxigeno . '","' . $peso . '","' . $talla . '","' . $hidrico . '","' . $ingeg . '","' . $estudioslab . '","' . $resultadorn . '","' . $evanutri . '","' . $diagnutri . '","' . $limitantes . '","' . $requerimientos . '","' . $conque . '","' . $pordonde . '","' . $cuanto . '","' . $cuando . '","' . $quemonitoreo . '","' . $como . '","' . $minter . '","' . $egrenut . '","' . $balineg . '","' . $guia . '")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


echo '<script type="text/javascript">window.location.href ="../hospitalizacion/vista_pac_hosp.php" ;</script>';
      }


//echo '<script type="text/javascript">window.location.href ="nota_nutricion.php?error=Credenciales incorrectas" ;</script>';
    
      
  ?>



 

<!-- TERMINO INSERT-->
</div>
</div>

</div>
</div>
<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <script>
  function validarEmail(elemento){ 
  var texto = document.getElementById("p_sistolica").value;
  var texto2 = document.getElementById("p_diastolica").value; 

if(texto >250 || texto2>180 || texto<0 || texto2<0) {
document.getElementById("resultado").innerHTML = '<font color="red">inválido </font>';

  } else {
document.getElementById("resultado").innerHTML = '<font color="green">válido </font>';
  }
}

function validarfreccar(elemento){ 
  var texto3 = document.getElementById("f_card").value;

if(texto3 >150 || texto3 <0 ) {
document.getElementById("resultado2").innerHTML = '<font color="red">inválido </font>';
  texto3.focus();
  } else {
document.getElementById("resultado2").innerHTML = '<font color="green">válido </font>';
  }
}

function validarfrecresp(elemento){ 
  var texto4 = document.getElementById("f_resp").value;

if(texto4 >100 || texto4 <0 ) {
document.getElementById("resultado3").innerHTML = '<font color="red">inválido </font>';
  texto4.focus();
  } else {
document.getElementById("resultado3").innerHTML = '<font color="green">válido </font>';
  }
}

function validartem(elemento){ 
  var texto5 = document.getElementById("temp").value;

if(texto5 >46 || texto5 <0 ) {
document.getElementById("resultado4").innerHTML = '<font color="red">inválido </font>';
  texto5.focus();
  } else {
document.getElementById("resultado4").innerHTML = '<font color="green">válido </font>';
  }
}

function validarsat(elemento){ 
  var texto6 = document.getElementById("sat_oxigeno").value;

if(texto6 >100 || texto6 <0 ) {
document.getElementById("resultado5").innerHTML = '<font color="red">inválido </font>';
  texto6.focus();
  } else {
document.getElementById("resultado5").innerHTML = '<font color="green">válido </font>';
  }
}



</script>
<script>

$('.losInputn2 input').on('change', function(){
  var total = 0;
 
  $('.losInputn2 input').each(function() {
    if($( this ).val() != "")
    {

      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotaln2 input').val(total.toFixed());
});

//leve grave
function mostrar(num) {
         var x = $("#num").val();
 if($("#num").val()==1){
 var num="Leve";
        // alert(num);
$('.inputTotaln22 input').val(num.toString());
       } else 
       if($("#num").val()==2){
 var num="Moderado";
         //alert(num);
$('.inputTotaln22 input').val(num.toString());
       }else 
       if($("#num").val()==3){
 var num="Grave";
         //alert(num);
$('.inputTotaln22 input').val(num.toString());
       }

        }


        $(document).ready(function () {
        $('#mibuscador11').select2();
    });
</script>

<script>
    // Write on keyup event of keyword input element
    $(document).ready(function() {
      $("#search").keyup(function() {
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#mytable tbody tr"), function() {
          if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
          else
            $(this).show();
        });
      });
    });
  </script>



</body>
</html>