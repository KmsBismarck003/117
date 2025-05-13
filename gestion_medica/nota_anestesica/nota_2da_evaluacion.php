<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");

$usuario = $_SESSION['login'];
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

    <title>NOTA ANESTESICA </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>EVALUACIÓN, INMEDIATAMENTE ANTES DEL PROCEDIMIENTO ANESTÉSICO</center></strong>
</div>
                <hr>
<?php

    include "../../conexionbd.php";

    if (isset($_SESSION['hospital'])) {
      $id_atencion = $_SESSION['hospital'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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


    ?>
 <font size="2">
         
  <div class="row">
    <div class="col-sm-2">
      Expediente: <strong><?php echo $id_exp?> </strong>
    </div>
    <div class="col-sm-6">
     Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm-4">
      Fecha de ingreso: <strong><?php echo date_format($date, "d/m/Y H:i:s") ?></strong>
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
               
                    $dias_mes_anterior=28; break;
               
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

function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}

 ?>
 <!-- TERMINO DE FUNCION DE CALCULAR EDAD -->
      Fecha de nacimiento: <strong><?php echo date_format($date1, "d/m/Y") ?></strong>
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
} if (!isset($peso)){
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
<hr>
</div>
        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
      }
        ?>
      <div class="container">  <!--INICIO DE CONSULTA DE URGENCIAS-->


    
<form action="insertar_2da_evaluacion.php" method="POST">

<div class="container">
  <div class="row">
    <div class="col-sm-6">
     Fecha: <input type="date" name="fecha2" id="fecha2" required class="form-control col-sm-5">
    </div>
    <div class="col-sm-4">
     Hora: <input type="time" name="hora2" id="hora2" required class="form-control col-sm-8">
    </div>
  </div>
</div><hr>
<div class="container">
  <div class="row">
    <div class="col-sm-7">
     Se corrobo la identificación del paciente, su estado actual, el diagnóstico y el procedimiento programado antes del inicio de la anestesia
    </div>
    <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="diaproc" id="anest" value="SI" required>
  <label class="form-check-label" for="anest">
   Si
  </label>
</div>
    </div>
    <div class="col-sm-3">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="diaproc" id="anest2" value="NO" required>
  <label class="form-check-label" for="anest2">
    No
  </label>
</div>
    </div>
  </div>
</div>
<hr>
<div class="col">
    <br><strong>Signos vitales:</strong></div>
<div class="row">

  <div class="col col-sm-5">
    <br>
      <center><button type="button" class="btn btn-success btn-sm" id="pla1"><i class="fas fa-play"></button></i> Presión arterial:</center><input required type="number" name="sist" placeholder="mmHg"  id="p_sistolica"  value=""   required> / <label for="p_sistolica"><input required type="number" name="diast"   placeholder="mmHg" id="p_diastolica"   value="" required>
    </div>
<script type="text/javascript">
const p_sistolica = document.getElementById('p_sistolica');
const btnPlayTex1 = document.getElementById('pla1');
btnPlayTex1.addEventListener('click', () => {
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
const btnPlayTex2 = document.getElementById('pla1');
btnPlayTex2.addEventListener('click', () => {
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
  <div class="col"><button type="button" class="btn btn-success btn-sm" id="pla2"><i class="fas fa-play"></button></i>  Frecuencia cardiaca: <input type="text" id="t1" name="freccard" class="form-control" required></div>
<script type="text/javascript">
const t1 = document.getElementById('t1');
const btnPlayTet2 = document.getElementById('pla2');
btnPlayTet2.addEventListener('click', () => {
        leerTexto(t1.value);
});

function leerTexto(t1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
  <div class="col"><button type="button" class="btn btn-success btn-sm" id="pla3"><i class="fas fa-play"></button></i> Frecuencia respiratoria: <input type="text" id="t2" name="frecresp" class="form-control" required></div>
<script type="text/javascript">
const t2 = document.getElementById('t2');
const btnPlayTet3 = document.getElementById('pla3');
btnPlayTet3.addEventListener('click', () => {
        leerTexto(t2.value);
});

function leerTexto(t2){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t2;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col"><br><button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i> Temperatura: <input type="text" id="t3" name="temp" class="form-control" required></div>
<script type="text/javascript">
const t3 = document.getElementById('t3');
const btnPlayTet4 = document.getElementById('pla4');
btnPlayTet4.addEventListener('click', () => {
        leerTexto(t3.value);
});

function leerTexto(t3){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t3;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
  <div class="col"><button type="button" class="btn btn-success btn-sm" id="pla5"><i class="fas fa-play"></button></i> Saturación oxígeno: <input type="text" name="spo2" id="t4" class="form-control" required></div>
</div>
<script type="text/javascript">
const t4 = document.getElementById('t4');
const btnPlayTet5 = document.getElementById('pla5');
btnPlayTet5.addEventListener('click', () => {
        leerTexto(t4.value);
});

function leerTexto(t4){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t4;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<hr>
<div class="row">
  <div class="col"><button type="button" class="btn btn-success btn-sm" id="pla6"><i class="fas fa-play"></button></i> Medicación preanestésica <input required type="text" id="txt5" name="med_pre" class="form-control">
    <input  type="text" name="med_pre2" id="t6" class="form-control">
  </div>
<script type="text/javascript">
const txt5 = document.getElementById('txt5');
const btnPlayTet6 = document.getElementById('pla6');
btnPlayTet6.addEventListener('click', () => {
        leerTexto(txt5.value);
});

function leerTexto(txt5){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txt5;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
const t6 = document.getElementById('t6');
const btnPlayTet7 = document.getElementById('pla6');
btnPlayTet7.addEventListener('click', () => {
        leerTexto(t6.value);
});

function leerTexto(t6){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t6;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
  <div class="col"><br><button type="button" class="btn btn-success btn-sm" id="pla7"><i class="fas fa-play"></button></i> Dosis 
    <input required type="text" name="dosis" id="t7" class="form-control" >
    <input type="text" name="dosis2" id="t8" class="form-control" >
  </div>
<script type="text/javascript">
const t7 = document.getElementById('t7');
const btnPlayTet8 = document.getElementById('pla7');
btnPlayTet8.addEventListener('click', () => {
        leerTexto(t7.value);
});

function leerTexto(t7){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t7;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
const t8 = document.getElementById('t8');
const btnPlayTet9 = document.getElementById('pla7');
btnPlayTet9.addEventListener('click', () => {
        leerTexto(t8.value);
});

function leerTexto(t8){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t8;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
  <div class="col"><br><button type="button" class="btn btn-success btn-sm" id="pla8"><i class="fas fa-play"></button></i> Vía 
    <input required type="text" name="via" id="t9" class="form-control" >
    <input type="text" name="via2" id="t10" class="form-control" >
  </div>
<script type="text/javascript">
const t9 = document.getElementById('t9');
const btnPlayTet10 = document.getElementById('pla8');
btnPlayTet10.addEventListener('click', () => {
        leerTexto(t9.value);
});

function leerTexto(t9){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t9;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
const t10 = document.getElementById('t10');
const btnPlayTet11 = document.getElementById('pla8');
btnPlayTet11.addEventListener('click', () => {
        leerTexto(t10.value);
});

function leerTexto(t10){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t10;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>

  <div class="col"><br>Fecha <input required type="date" name="fechamedi" class="form-control">
    <input type="date" name="fechamedi2" class="form-control">
  </div>
   <div class="col"><br>Hora <input required type="time" name="horamedi" class="form-control">
    <input type="time" name="horamedi2" class="form-control">
  </div>
  <div class="col"><br><button type="button" class="btn btn-success btn-sm" id="pla9"><i class="fas fa-play"></button></i> Efecto 
    <input required type="text" id="t11" name="efect" class="form-control" >
    <input type="text" name="efect2" id="t12" class="form-control" ></div>
</div>
<script type="text/javascript">
const t11 = document.getElementById('t11');
const btnPlayTet112 = document.getElementById('pla9');
btnPlayTet112.addEventListener('click', () => {
        leerTexto(t11.value);
});

function leerTexto(t11){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t11;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
const t12 = document.getElementById('t12');
const btnPlayTet13 = document.getElementById('pla9');
btnPlayTet13.addEventListener('click', () => {
        leerTexto(t12.value);
});

function leerTexto(t12){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t12;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<hr>
<div class="row">
  <div class="col"><h6><br><strong>Verificación del equipo y monitoreo antes de la anestesia</strong></div>
    <div class="col"><label>Hora:</label> <input type="time" name="hora_ver" class="form-control-small col-4"></div>
  </div>
<hr>

<div class="row">
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="apan" id="apar" value="SI" >
  <label class="form-check-label" for="apar">
   Aparato anestesia
  </label>
</div>
</div>
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="circ" id="circuito" value="SI">
  <label class="form-check-label" for="circuito">
   Circuito
  </label>
</div>
</div>
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="fugas" id="fugas" value="SI">
  <label class="form-check-label" for="fugas">
   Fugas
  </label>
</div>
</div>
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="cal" id="cal" value="SI">
  <label class="form-check-label" for="cal">
   Cal sodada
  </label>
</div>
</div>
</div>

<div class="row">
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="vent" id="venti" value="SI">
  <label class="form-check-label" for="vent">
   Ventilador
  </label>
</div>
</div>
    <div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="para" id="parame" value="SI">
  <label class="form-check-label" for="parame">
   Parámetros ventilatorios
  </label>
</div>
</div>
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="flujo" id="flujo" value="SI">
  <label class="form-check-label" for="flujo">
   Flujómetros
  </label>
</div>
</div>
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="vapo" id="vap" value="SI">
  <label class="form-check-label" for="vap0">
   Vaporizadores
  </label>
</div>
</div>
</div>

<div class="row">
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="fuen" id="fuentea" value="SI">
  <label class="form-check-label" for="fuentea">
   Fuente de O2 y alarmas
  </label>
</div>
</div>
    <div class="col-9">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="fuent" id="fuentee" value="SI">
  <label class="form-check-label" for="fuentee">
   Fuente de energía y alarmas
  </label>
</div>
</div>
</div>

<div class="row">
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="ecg" id="ecg" value="SI">
  <label class="form-check-label" for="ecg">
   Ecg
  </label>
</div>
</div>
    <div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="pani" id="pani" value="SI">
  <label class="form-check-label" for="pani">
   Pani
  </label>
</div>
</div>
<div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="spo" id="sp" value="SI">
  <label class="form-check-label" for="sp">
   Sp O2
  </label>
</div>
</div>
<div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="co2" id="co" value="SI">
  <label class="form-check-label" for="co">
   CO2FE
  </label>
</div>
</div>
</div><p></p>
<strong>Opcionales:</strong>
<div class="row">
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="ana" id="ana" value="SI">
  <label class="form-check-label" for="ana">
   Analizador de gases resp
  </label>
</div>
</div>
    <div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="indice" id="indi" value="SI">
  <label class="form-check-label" for="indi">
   Índice biespectral
  </label>
</div>
</div>
<div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="bomba" id="bomba" value="SI">
  <label class="form-check-label" for="bomba">
   Bomba de infusión
  </label>
</div>
</div>
<div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="moni" id="mon" value="SI">
  <label class="form-check-label" for="mon">
   Monitor de relajación
  </label>
</div>
</div>
</div><br>
<label for="exampleFormControlTextarea1">Observaciones:</label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla13"><i class="fas fa-play"></button></i>
</div> 
<textarea class="form-control" name="obser" id="texto" required rows="4"></textarea>
<script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btnPlayTet16 = document.getElementById('pla13');
btnPlayTet16.addEventListener('click', () => {
        leerTexto(texto.value);
});

function leerTexto(texto){
    const speech = new SpeechSynthesisUtterance();
    speech.text= texto;
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
    <hr>
    

 <center>

                       <div class="form-group col-6">
                            <button type="submit" class="btn btn-primary">Firmar y guardar</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
                        </div>
</center>
                        <br>
                        
                        </form>
</div> <!--TERMINO DE NOTA MEDICA div container-->
  
  
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


<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>


</body>
</html>