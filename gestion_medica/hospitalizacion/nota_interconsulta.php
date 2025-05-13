<?php
session_start();
include "../../conexionbd.php";
include("../header_medico.php");
?>

<!DOCTYPE html>
<div>
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



  
        <script>
            // Write on keyup event of keyword input element
            $(document).ready(function () {
                $("#search").keyup(function () {
                    _this = this;
                    // Show only matching TR, hide rest of them
                    $.each($("#mytable tbody tr"), function () {
                        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                            $(this).hide();
                        else
                            $(this).show();
                    });
                });
            });
        </script>


        <title>Historia Clinica </title>
         <style type="text/css">
   
    .modal-lg { max-width: 65% !important; }
</style>
    </head>


    <div class="col-sm">
        <form action="insertar_nota_inter.php"
              method="POST">
            <div class="container">
                <div class="row">
                   <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>NOTA DE INTERCONSULTA</center></strong>
</div>

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
        ?><hr>
 <?php 

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_sig DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
      $atencion=$f5['id_sig'];
    }
    ?>
    <?php
if (isset($atencion)) {
                        ?>
<?php 

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_sig DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
     
    
    ?>
    <div class="container">
   <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
</div>
                <div class="container"> 
  <div class="row">
    
      
    
    <div class="col-sm-2"><center>Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" value="<?php echo $f5['p_sistol'];?>" disabled></div> /
  <div class="col"><input type="text" class="form-control" value="<?php echo $f5['p_diastol'];?>" disabled></div>
 
</div>
    </div>
    <div class="col-sm-2">
      Frecuencia cardiaca:<input type="text" class="form-control" value="<?php echo $f5['fcard'];?>" disabled>
    </div>
    <div class="col-sm-2">
      Frecuencia respiratoria:<input type="text" class="form-control" value="<?php echo $f5['fresp'];?>" disabled>
    </div>
    <div class="col-sm-2">
     <br>Temperatura:<input type="text" class="form-control" value="<?php echo $f5['temper'];?>" disabled>
    </div>
    <div class="col-sm-2">
     Saturación oxígeno:<input type="text"  class="form-control" value="<?php echo $f5['satoxi'];?>" disabled>
    </div>
    
  </div>
</div>
<?php }
?>
<?php 
}else{
                        
  ?>
  <div class="container">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
</div>
                <div class="container"> 
  <div class="row">
    <div class="col-sm-2"><br><center>Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" name="p_sistol" ></div> /
  <div class="col"><input type="text" class="form-control" name="p_diastol"></div>
 
</div>
    </div>
    <div class="col-sm-2">
      Frecuencia cardiaca:<input type="text" class="form-control" name="fcard">
    </div>
    <div class="col-sm-2">
      Frecuencia respiratoria:<input type="text" class="form-control" name="fresp">
    </div>
    <div class="col-sm-2">
     <br>Temperatura:<input type="text" class="form-control"  name="temper">
    </div>
    <div class="col-sm-2">
     Saturación oxígeno:<input type="text"  class="form-control" name="satoxi">
    </div>
    
  </div>
</div>

<?php } ?>
 <br>
 <hr>
 <div class="container">
 <div class="row">
    <div class=" col-12">
       
      
<div class="form-group">
<label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="playa"><i class="fas fa-play"></button></i> Especialidad:</strong></label>
<select name="espec" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%" required="">
    <option value="">Seleccionar una especialidad</option>
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_espec ";
$result_diag=$conexion->query($sql_diag);

while($row=$result_diag->fetch_assoc()){
   
    echo "<option value='" . $row['espec'] . "'>" . $row['espec'] . "</option>";
}
 ?></select>
                                </div>
                    
    </div>
</div>
</div>
<script type="text/javascript">
  const mibuscador = document.getElementById('mibuscador');
  const btnPlayTexta = document.getElementById('playa');

  btnPlayTexta.addEventListener('click', () => {
          leerTexto(mibuscador.value);
  });

  function leerTexto(mibuscador){
      const speech = new SpeechSynthesisUtterance();
      speech.text= mibuscador;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
  </script> 
 <div class="container">
 <div class="row">
<div class=" col-12">
<strong>Motivo de la interconsulta:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playmotv"><i class="fas fa-play"></button></i>
</div> 
<div class="form-group">
<textarea class="form-control" id="texto" name="motinter" rows="3"></textarea>
<script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btnPlayTextaa = document.getElementById('playmotv');

  btnPlayTextaa.addEventListener('click', () => {
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
</div>
</div>
</div>
</div>
 <div class="container">
 <div class="row">
    <div class=" col-12">
<strong>Resumen del interrogatorio, exploración física y estado mental:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="resg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="deti"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playedoexp"><i class="fas fa-play"></button></i>
</div> 
     <div class="form-group">
    <textarea class="form-control" id="txtef" rows="3" name="riefeinter"></textarea>
    <script type="text/javascript">
const resg = document.getElementById('resg');
const deti = document.getElementById('deti');
const txtef = document.getElementById('txtef');

const btnPlayTexta2 = document.getElementById('playedoexp');

  btnPlayTexta2.addEventListener('click', () => {
          leerTexto(txtef.value);
  });

  function leerTexto(txtef){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtef;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let r = new webkitSpeechRecognition();
      r.lang = "es-ES";
      r.continuous = true;
      r.interimResults = false;

      r.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtef.value += frase;
      }

      resg.addEventListener('click', () => {
        r.start();
      });

      deti.addEventListener('click', () => {
        r.abort();
      });
</script>
  </div>
    </div>
</div>
</div>
<div class="container">
<div class="row">
    <div class=" col-12">
<strong>Resultados relevantes de los estudios de los servicios auxiliares de diagnóstico y tratamiento solicitado previamen:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="relg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detl"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play5"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txtrr" rows="3" name="revlinter"></textarea>
<script type="text/javascript">
const relg = document.getElementById('relg');
const detl = document.getElementById('detl');
const txtrr = document.getElementById('txtrr');

const btnPlayTextservaz = document.getElementById('play5');

  btnPlayTextservaz.addEventListener('click', () => {
          leerTexto(txtrr.value);
  });

  function leerTexto(txtrr){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtrr;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rd = new webkitSpeechRecognition();
      rd.lang = "es-ES";
      rd.continuous = true;
      rd.interimResults = false;

      rd.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtrr.value += frase;
      }

      relg.addEventListener('click', () => {
        rd.start();
      });

      detl.addEventListener('click', () => {
        rd.abort();
      });
</script>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
    <div class=" col-12"><strong>Diagnósticos o problemas clínicos:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="pg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detdop"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playprocl"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txtcd" rows="3" name="probinter"></textarea>
<script type="text/javascript">
const pg = document.getElementById('pg');
const detdop = document.getElementById('detdop');
const txtcd = document.getElementById('txtcd');

const btnPlayTextticosc = document.getElementById('playprocl');

  btnPlayTextticosc.addEventListener('click', () => {
          leerTexto(txtcd.value);
  });

  function leerTexto(txtcd){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtcd;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let red = new webkitSpeechRecognition();
      red.lang = "es-ES";
      red.continuous = true;
      red.interimResults = false;

      red.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtcd.value += frase;
      }

      pg.addEventListener('click', () => {
        red.start();
      });

      detdop.addEventListener('click', () => {
        red.abort();
      });
</script>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class=" col-12">
<strong>Tratamiento:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="tag"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detie"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playtrattt"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txttt" rows="3" name="tratprocinter"></textarea>
<script type="text/javascript">
const tag = document.getElementById('tag');
const detie = document.getElementById('detie');
const txttt = document.getElementById('txttt');

const btnPlayTextmientoo = document.getElementById('playtrattt');

  btnPlayTextmientoo.addEventListener('click', () => {
          leerTexto(txttt.value);
  });

  function leerTexto(txttt){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txttt;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rtt = new webkitSpeechRecognition();
      rtt.lang = "es-ES";
      rtt.continuous = true;
      rtt.interimResults = false;

      rtt.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txttt.value += frase;
      }

      tag.addEventListener('click', () => {
        rtt.start();
      });

      detie.addEventListener('click', () => {
        rtt.abort();
      });
</script>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class=" col-12">
<strong>Pronóstico:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="png"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detnost"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playnospp"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txtpco" rows="3" name="proninter"></textarea>
<script type="text/javascript">
const png = document.getElementById('png');
const detnost = document.getElementById('detnost');
const txtpco = document.getElementById('txtpco');

const btnPlayTico = document.getElementById('playnospp');

  btnPlayTico.addEventListener('click', () => {
          leerTexto(txtpco.value);
  });

  function leerTexto(txtpco){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtpco;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rero = new webkitSpeechRecognition();
      rero.lang = "es-ES";
      rero.continuous = true;
      rero.interimResults = false;

      rero.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtpco.value += frase;
      }

      png.addEventListener('click', () => {
        rero.start();
      });

      detnost.addEventListener('click', () => {
        rero.abort();
      });
</script>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class=" col-12"> <strong>Criterios diagnósticos:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="crig"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detiod"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playcriterios"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txtcri" rows="3" name="criteinter"></textarea>
<script type="text/javascript">
const crig = document.getElementById('crig');
const detiod = document.getElementById('detiod');
const txtcri = document.getElementById('txtcri');

const btnPlaycri = document.getElementById('playcriterios');

  btnPlaycri.addEventListener('click', () => {
          leerTexto(txtcri.value);
  });

  function leerTexto(txtcri){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtcri;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let retci = new webkitSpeechRecognition();
      retci.lang = "es-ES";
      retci.continuous = true;
      retci.interimResults = false;

      retci.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtcri.value += frase;
      }

      crig.addEventListener('click', () => {
        retci.start();
      });

      detiod.addEventListener('click', () => {
        retci.abort();
      });
</script>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class=" col-12"> <strong>Plan de estudios:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="pdeg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detane"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playplanna"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txtlan" rows="3" name="planinter"></textarea>
<script type="text/javascript">
const pdeg = document.getElementById('pdeg');
const detane = document.getElementById('detane');
const txtlan = document.getElementById('txtlan');

const btnPlayplanes = document.getElementById('playplanna');

  btnPlayplanes.addEventListener('click', () => {
          leerTexto(txtlan.value);
  });

  function leerTexto(txtlan){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtlan;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let reles = new webkitSpeechRecognition();
      reles.lang = "es-ES";
      reles.continuous = true;
      reles.interimResults = false;

      reles.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtlan.value += frase;
      }

      pdeg.addEventListener('click', () => {
        reles.start();
      });

      detane.addEventListener('click', () => {
        reles.abort();
      });
</script>
</div>
</div>
</div>
</div>

<div class="container">
<div class="row">
<div class=" col-12"> <strong>Sugerencias diagnósticas y tratamiento:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="sugg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detsdt"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playsugta"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txtsu" rows="3" name="sugdiaginter"></textarea>
<script type="text/javascript">
const sugg = document.getElementById('sugg');
const detsdt = document.getElementById('detsdt');
const txtsu = document.getElementById('txtsu');

const btnPlayrencias = document.getElementById('playsugta');

  btnPlayrencias.addEventListener('click', () => {
          leerTexto(txtsu.value);
  });

  function leerTexto(txtsu){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtsu;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let ressd = new webkitSpeechRecognition();
      ressd.lang = "es-ES";
      ressd.continuous = true;
      ressd.interimResults = false;

      ressd.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtsu.value += frase;
      }

      sugg.addEventListener('click', () => {
        ressd.start();
      });

      detsdt.addEventListener('click', () => {
        ressd.abort();
      });
</script>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
    <div class=" col-sm-9">
<strong><button type="button" class="btn btn-success btn-sm" id="playgia"><i class="fas fa-play"></button></i> Guía de práctica clínica:</strong>

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
const btnPlayrenciasguia = document.getElementById('playgia');

  btnPlayrenciasguia.addEventListener('click', () => {
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
</div>
<hr>
<div class="container">
<center><button type="submit" class="btn btn-primary"><font size="3">Firmar y guardar</font></button>
<button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button><br><br></center>
</div>
</div>       
</form>
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
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
            $('#mibuscador').select2();
    });
    $(document).ready(function () {
        $('#mibuscador11').select2();
    });
</script>


</body>

</html>