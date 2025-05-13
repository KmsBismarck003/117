<?php
session_start();
include "../../conexionbd.php";
include("../header_medico.php");
?>
<!DOCTYPE html>
<html>
<head>
   <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <link rel="stylesheet" type="text/css" href="../hospitalizacion/css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="../hospitalizacion/js/select2.js"></script>
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




    <title>HOJA DE PROGRAMACIÓN QUIRÚRGICA </title>
    <style type="text/css">
    .modal-lg { max-width: 65% !important; }
    
    $spacing: 12px;
$module: 48px;
:root {
  --progressW: 50%;
}
label {
  display: block;
  width: 90%;
  vertical-align: baseline;
}
.sliderBar {
  position: relative;
  margin: 0 $spacing;
}
[type=range] {
  -webkit-appearance: none;
  width: calc(100% - 50px);
  vertical-align: middle;
  border: none;
  outline: none;
}
@mixin track() { 
  -webkit-appearance: slider-horizontal;
  height: 2px;
  padding: 0;
  cursor: pointer;
  background: linear-gradient(to right, #99F 0%, #99F var(--progressW), #ccc var(--progressW), #ccc 100%);
}
@mixin thumb() { 
  box-sizing: border-box;/*FF*/
  -webkit-appearance: none;
  width: $module/2;
  height: $module/2;
  margin-top: -$spacing;
  border: $spacing/2 solid #eee;
  border-radius: 50%;
  background: #999;
  box-shadow: 0 1px 4px rgba(0, 0, 0, .5)
}
@mixin active() {
    width: $module*0.75;
    height: $module*0.75;
    margin-top: -$spacing*1.5;
    background: #99F;
}
@mixin progress() {
    background: #99F;
}


[type=range] {
  &::-webkit-slider-runnable-track { @include track }
  &::-moz-range-track { @include track }
  &::-ms-track { @include track }

  &::-webkit-slider-thumb { @include thumb }
  &::-moz-range-thumb { @include thumb }
  &::-ms-thumb { @include thumb }

  &:active::-webkit-slider-thumb { @include active }
  &:active::-moz-range-thumb { @include active }
  &:active::-ms-thumb { @include active }
  
  &::-moz-range-progress { @include progress }
  &::-ms-fill-upper { @include progress }
}
</style>
</head>
<body>

<div class="col-sm-12">
<div class="container">
<div class="row">
<div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>HOJA DE PROGRAMACIÓN QUIRÚRGICA</center></strong>
</div>
                <hr>
<?php

    include "../../conexionbd.php";

    if (isset($_SESSION['hospital'])) {
      $id_atencion = $_SESSION['hospital'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias, p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
        $folio = $row_pac['folio'];
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
    
    <div class="col-sm-4">
     Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    <div class="col-sm">
      Expediente: <strong><?php echo $folio?> </strong>
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
<hr>
</div>
        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
      }
        ?>



  
<div class="container">  <!--INICIO DE NOTA PREOPERATORIA-->
<form action="insert_hojaprog.php" method="POST" name="insert_hojaprog">

  <div class="row">
    <div class="col-sm">
      <strong><p>Tipo de cirugía:</p></strong>
      <div class="form-check">
        <input class="form-check-input" type="radio" id="Urgencia" value="Urgencia" name="tipo_cir" required="">
        <label class="form-check-label" for="Urgencia">Urgencia</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" id="Programada" value="Programada" name="tipo_cir">
        <label class="form-check-label" for="Programada">Programada</label>
      </div>
    </div>
    <div class="col-sm">
       <strong><p><button type="button" class="btn btn-success btn-sm" id="playa"><i class="fas fa-play"></button></i> Fecha solicitada:</p></strong>
       <input type="date" name="fecha_sol" class="form-control" id="txtpa">
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
    <div class="col-sm">
       <strong><p><button type="button" class="btn btn-success btn-sm" id="playhemato"><i class="fas fa-play"></button></i> Hora solicitada:</p></strong>
      <input type="time" name="hora_sol" class="form-control" id="txthtto">
      <script type="text/javascript">
const txthtto = document.getElementById('txthtto');
const btnPlaymato = document.getElementById('playhemato');

btnPlaymato.addEventListener('click', () => {
        leerTexto(txthtto.value);
});

function leerTexto(txthtto){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txthtto;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script> 
    </div>
     <div class="col-sm">
        <strong><p><button type="button" class="btn btn-success btn-sm" id="playrh"><i class="fas fa-play"></button></i> Hemoglobina</p></strong>
        <input type="text" name="hb" id="txtrhg" class="form-control">
<script type="text/javascript">
const txtrhg = document.getElementById('txtrhg');
const btnPlaymgsrh = document.getElementById('playrh');

btnPlaymgsrh.addEventListener('click', () => {
        leerTexto(txtrhg.value);
});

function leerTexto(txtrhg){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtrhg;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script> 
     </div>
        <div class="col-sm">
        <strong><p><button type="button" class="btn btn-success btn-sm" id="playrh"><i class="fas fa-play"></button></i> Hematocrito </p></strong>
        <input type="text" name="ht" id="txtrhg" class="form-control">
<script type="text/javascript">
const txtrhg = document.getElementById('txtrhg');
const btnPlaymgsrh = document.getElementById('playrh');

btnPlaymgsrh.addEventListener('click', () => {
        leerTexto(txtrhg.value);
});

function leerTexto(txtrhg){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtrhg;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script> 
     </div>
  </div>
    

<hr>
<div class="container">
  <div class="row">
    <div class="col-sm-7">
      <div class="form-group">
          <?php $fr = date("Y-m-d H:i");?>

       <label for="exampleFormControlInput1"><strong> PERSONA RESPONSABLE DE PROGRAMACIÓN:</strong></label>
       <input type="text" name="persona" class="form-control" id="exampleFormControlInput1" required="">

     </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
       <label for="exampleFormControlInput1"><strong><button type="button" class="btn btn-success btn-sm" id="playqx"><i class="fas fa-play"></button></i> TIEMPO QUIRÚRGICO ESTIMADO:</strong></label>
       <input type="text" class="form-control" name="tiempo_estimado" required >

      </div>
    </div>
   
    <div class="col-sm-7">
      <div class="form-group">
   
       <label for="exampleFormControlInput1"><strong> MATERIAL Y EQUIPO REQUERIDO:</strong></label>
       <input type="text" name="matye" class="form-control" id="exampleFormControlInput12" required="">
   
     </div>
    </div>
  
<script type="text/javascript">
    function changeVar(value, min, max){
  var range = max - min;
  var progressW = (value-min)/range*100 +'%';
  $('#rangeField').css('--progressW', progressW);
}
</script>
    
<script type="text/javascript">
const txtxq = document.getElementById('txtxq');
const btnPlayesq = document.getElementById('playqx');

btnPlayesq.addEventListener('click', () => {
        leerTexto(txtxq.value);
});

function leerTexto(txtxq){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtxq;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
   <div class="col-sm">
      <label for="exampleFormControlTextarea1"><strong><button type="button" class="btn btn-success btn-sm" id="playprocirg"><i class="fas fa-play"></button></i> OPERACIÓN PROYECTADA:</strong></label>

     <select name="ope_proyectada" class="form-control" data-live-search="true" id="mibuscador9" style="width : 100%; heigth : 100%">
            <option value="">Seleccionar procedimiento</option>
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_proc ";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['procedimiento'] . "'>"  . $row['cie9'] ."- " . $row['procedimiento'] . "</option>";
}
 ?></select>
    </div>
  </div>
</div>

  <p>
  
    <script type="text/javascript">
const mibuscador9 = document.getElementById('mibuscador9');
const btnPlaygiapada = document.getElementById('playprocirg');

btnPlaygiapada.addEventListener('click', () => {
        leerTexto(mibuscador9.value);
});

function leerTexto(mibuscador9){
    const speech = new SpeechSynthesisUtterance();
    speech.text= mibuscador9;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <p>
    <div class="container">
  <div class="row">
    <div class="col-sm-7">
        <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="playtransoes"><i class="fas fa-play"></button></i> ESTUDIOS TRANSOPERATORIOS:</strong></label>
        <input type="text" class="form-control" name="est_transo" id="txtrioses">
</div>
<div class="col-sm">
        <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="playprepdiag"><i class="fas fa-play"></button></i> DIAGNÓSTICO PREOPERATORIO:</strong></label>
        <select name="diag_preop" class="form-control" data-live-search="true" id="mibuscador8" style="width : 100%; heigth : 100%">
           <option value="">Seleccionar diagnóstico</option>
            <?php
            include "../../conexionbd.php";
            $sql_diag="SELECT * FROM cat_diag ";
            $result_diag=$conexion->query($sql_diag);
            while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['diagnostico'] . "'>" . $row['id_cie10'] ."- " . $row['diagnostico'] . "</option>";}
          ?>
        </select>
    </div>
    </div>
  </div>
  <script type="text/javascript">
const txtrioses = document.getElementById('txtrioses');
const btnPlaydiosrios = document.getElementById('playtransoes');

btnPlaydiosrios.addEventListener('click', () => {
        leerTexto(txtrioses.value);
});

function leerTexto(txtrioses){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtrioses;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>

  <p>
<div class="container">
  <div class="row">
  
    
<script type="text/javascript">
const mibuscador8 = document.getElementById('mibuscador8');
const btnPlay8 = document.getElementById('playprepdiag');

btnPlay8.addEventListener('click', () => {
        leerTexto(mibuscador8.value);
});

function leerTexto(mibuscador8){
    const speech = new SpeechSynthesisUtterance();
    speech.text= mibuscador8;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    
  </div>
</div>
<p>
<div class="container">
  <div class="row">
  
    <div class="col-sm-7">
        <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="playpostopreod"><i class="fas fa-play"></button></i> DIAGNÓSTICO POSTOPERATORIO:</strong></label>
        <select name="d_posto" class="form-control" data-live-search="true" id="mibuscador7" style="width : 100%; heigth : 100%">
           <option value="">Seleccionar diagnóstico</option>
            <?php
            include "../../conexionbd.php";
            $sql_diag="SELECT * FROM cat_diag ";
            $result_diag=$conexion->query($sql_diag);
            while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['diagnostico'] . "'>" . $row['id_cie10'] ."- " . $row['diagnostico'] . "</option>";}
          ?>
        </select>
    </div>
 <div class="col-sm">
      <label for="exampleFormControlTextarea1"><strong><button type="button" class="btn btn-success btn-sm" id="playprocirg"><i class="fas fa-play"></button></i> OPERACIÓN REALIZADA:</strong></label>

     <select name="ope_realizada" class="form-control" data-live-search="true" id="mibuscador19" style="width : 100%; heigth : 100%">
            <option value="">Seleccionar procedimiento</option>
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_proc ";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['procedimiento'] . "'>"  . $row['cie9'] ."- " . $row['procedimiento'] . "</option>";
}
 ?></select>
    </div>
    <div class="col-sm-7"><p></p>
        <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="playtransoes"><i class="fas fa-play"></button></i> CIRUJANO:</strong></label>
        <input type="text" class="form-control" name="cirujano" id="txtrioses">
</div>
  <div class="col-sm-5"><p></p>
        <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="playtransoes"><i class="fas fa-play"></button></i> ANESTESIÓLOGO:</strong></label>
        <input type="text" class="form-control" name="anest" id="txtrioses">
</div>

  </div>
</div>
<p>
<script type="text/javascript">
const mibuscador7 = document.getElementById('mibuscador7');
const btnPlay9 = document.getElementById('playpostopreod');

btnPlay9.addEventListener('click', () => {
        leerTexto(mibuscador7.value);
});

function leerTexto(mibuscador7){
    const speech = new SpeechSynthesisUtterance();
    speech.text= mibuscador7;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  <p>
   
<br>

<!--<div class="container">
  <div class="row">
    <div class="col-sm">
       <label for="exampleFormControlTextarea1"><strong>PRONÓSTICOS PARA LA VIDA Y LA FUNCIÓN</strong><div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
       <button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
      </div></label>
       

       <textarea class="form-control" name="pronostico" id="texto" required rows="3"></textarea>
       <script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

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
    <div class="col-sm">
       <label for="exampleFormControlTextarea1"><strong>RIESGOS QUIRÚRGICOS</strong>  <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="btnStartRecordd"><i class="fas fa-microphone"></button></i>
       <button type="button" class="btn btn-primary btn-sm" id="btnStopRecordd"><i class="fas fa-microphone-slash"></button></i>
      </div></label>
     
    <textarea class="form-control" name="riesgos" id="riesgos" required rows="3"></textarea>
       <script type="text/javascript">
const btnStartRecordd = document.getElementById('btnStartRecordd');
const btnStopRecordd = document.getElementById('btnStopRecordd');
const riesgos = document.getElementById('riesgos');

     let r = new webkitSpeechRecognition();
      r.lang = "es-ES";
      r.continuous = true;
      r.interimResults = false;

      r.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        riesgos.value += frase;
      }

      btnStartRecordd.addEventListener('click', () => {
        r.start();
      });

      btnStopRecordd.addEventListener('click', () => {
        r.abort();
      });
</script>
    </div>  
  </div>
</div>
<br>

<div class="container">
  <div class="row">
    <div class="col-sm">
       <label for="exampleFormControlTextarea1"><strong>CUIDADOS Y PLAN TERAPÉUTICO PREOPERATORIO</strong><div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="btnStartRecordc"><i class="fas fa-microphone"></button></i>
       <button type="button" class="btn btn-primary btn-sm" id="btnStopRecordc"><i class="fas fa-microphone-slash"></button></i>
      </div></label>
    <textarea class="form-control" name="cuidados" id="cuidados" required rows="3" ></textarea>
     <script type="text/javascript">
const btnStartRecordc = document.getElementById('btnStartRecordc');
const btnStopRecordc = document.getElementById('btnStopRecordc');
const cuidados = document.getElementById('cuidados');

     let c = new webkitSpeechRecognition();
      c.lang = "es-ES";
      c.continuous = true;
      c.interimResults = false;

      c.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        cuidados.value += frase;
      }

      btnStartRecordc.addEventListener('click', () => {
        c.start();
      });

      btnStopRecordc.addEventListener('click', () => {
        c.abort();
      });
</script>
    </div>
    
  </div>
</div>  
<br>



<div class="container">
  <div class="row">
    <div class="col-sm">
        <label for="exampleFormControlTextarea1"><strong>ANESTESIA SUGERIDA<div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="ansugeg"><i class="fas fa-microphone"></button></i>
       <button type="button" class="btn btn-primary btn-sm" id="ridastop"><i class="fas fa-microphone-slash"></button></i>
      </div></strong></label>
<textarea class="form-control" name="anestesia_sug" id="txttesi" required rows="3" ></textarea>
<script type="text/javascript">
const ansugeg = document.getElementById('ansugeg');
const ridastop = document.getElementById('ridastop');
const txttesi = document.getElementById('txttesi');

     let reanestesia = new webkitSpeechRecognition();
      reanestesia.lang = "es-ES";
      reanestesia.continuous = true;
      reanestesia.interimResults = false;

      reanestesia.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txttesi.value += frase;
      }

      ansugeg.addEventListener('click', () => {
        reanestesia.start();
      });

      ridastop.addEventListener('click', () => {
        reanestesia.abort();
      });
</script>
    </div>
      <div class="col-sm">
     <div class="form-group">
    <label for="exampleFormControlInput1"><strong>SANGRADO ESPERADO (ML):</strong></label>
    <input type="text" class="form-control" name="sangrado_esp" required id="exampleFormControlInput1">
  </div>
    </div>
  </div>
</div> 
<p>
<div class="container">
  <div class="row">
    <div class="col-sm">
        <label for="id_cie_10"><strong>OPERACIÓN REALIZADA</strong></label>
        <select name="oper_real" class="form-control" data-live-search="true" id="mibuscador6" style="width : 100%; heigth : 100%">
            <option value="">SELECCIONAR PROCEDIMIENTO</option>
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_proc ";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['procedimiento'] . "'>" . $row['cie9'] . "- " . $row['procedimiento'] . "</option>";
}
 ?></select>
</div>
    </div>
  </div>
  <p>
  <div class="container">
  <div class="row">
    <div class="col-sm">
        <label for="id_cie_10"><strong>INCIDENTES Y HALLAZGOS</strong></label>
        <input type="text" class="form-control" name="incidentes">
</div>
    </div>
  </div>
  <p>
<div class="container">
<div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>DESCRIPCIÓN DE LA TÉCNICA QUIRÚRGICA:</strong>
    <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="btnStartRecordo"><i class="fas fa-microphone">
</button></i>
       <button type="button" class="btn btn-primary btn-sm" id="btnStopRecordo"><i class="fas fa-microphone-slash"></button></i>
      </div></label>
    <textarea class="form-control" name="observ" id="observaciones" required rows="3"></textarea>
    <script type="text/javascript">
const btnStartRecordo = document.getElementById('btnStartRecordo');
const btnStopRecordo = document.getElementById('btnStopRecordo');
const observaciones = document.getElementById('observaciones');

     let o = new webkitSpeechRecognition();
      o.lang = "es-ES";
      o.continuous = true;
      o.interimResults = false;

      o.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        observaciones.value += frase;
      }

      btnStartRecordo.addEventListener('click', () => {
        o.start();
      });

      btnStopRecordo.addEventListener('click', () => {
        o.abort();
      });
</script>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm">
        <label for="id_cie_10"><strong>COMPLICACIONES</strong></label>
        <input type="text" class="form-control" name="complicaciones">
</div>
    </div>
  </div>
  <p>
  <div class="container">
  <div class="row">
    <div class="col-sm">
        <label for="id_cie_10"><strong>PIEZA QUIRÚRGICA</strong></label>
        <input type="text" class="form-control" name="pieza_quir">
</div>
    </div>
  </div>
  <p>
  <div class="container">
  <div class="row">
    <div class="col-sm">
        <label for="id_cie_10"><strong>1ER AYUDANTE</strong></label>
        <input type="text" class="form-control" name="primer_a">
</div>
    </div>
  </div>
  <p>
<div class="container">
  <div class="row">
    <div class="col-sm">
        <label for="id_cie_10"><strong>2DO AYUDANTE</strong></label>
        <input type="text" class="form-control" name="segundo_a">
</div>
    </div>
  </div>
  <p>
  <div class="container">
  <div class="row">
    <div class="col-sm">
        <label for="id_cie_10"><strong>ANESTESIÓLOGO</strong></label>
        <input type="text" class="form-control" name="anestesiologo">
</div>
    </div>
  </div>
<p>
<div class="container">
<div class="row">
<div class=" col-sm-9">
<strong>Guía de práctica clínica:</strong>

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
</div>

<hr>

-->

<center>
    <div class="form-group col-6">
        <button type="submit" class="btn btn-primary" id="btn-enviar">Firmar y guardar</button>
        <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
    </div>
</center>
<br>
<script>
    
</script>
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
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador9').select2();
    });

    $(document).ready(function () {
        $('#mibuscador8').select2();
    });

    $(document).ready(function () {
        $('#mibuscador7').select2();
    });

    $(document).ready(function () {
        $('#mibuscador6').select2();
    });
    $(document).ready(function () {
        $('#mibuscador11').select2();
    });
 $(document).ready(function () {
        $('#mibuscador19').select2();
    });
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