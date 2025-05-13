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


    <title>DATOS NURGEN </title>
    <style type="text/css">
    #contenido{
        display: none;
    }
    .modal-lg { max-width: 65% !important; }
</style>

</head>
<?php if(isset($_SESSION['hospital'])){ ?>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
             
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 22px;">
  <strong><center>NOTA DE OBSERVACIÓN</center></strong>
</div>
             
<?php

include "../../conexionbd.php";

 $id_atencion = $_SESSION['hospital'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.folio, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, di.activo, p.sexo, di.alergias FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
        $activo = $row_pac['activo'];
      }

      if ($activo === 'SI') {
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
      }
      else {
          $sql_est = "SELECT DATEDIFF(fec_egreso, fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";
          $result_est = $conexion->query($sql_est);
          while ($row_est = $result_est->fetch_assoc()) {
            if($row_est['estancia']==0){
               $estancia = $row_est['estancia']+1;
            }else{
              $estancia = $row_est['estancia'];
            }
          }
      }

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);

while ($f1 = mysqli_fetch_array($resultado1)) {
$area=$f1['area'];
$pac_fecnac=$f1['fecnac'];

 ?>
<div class="container">
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
      Fecha de ingreso: <strong><?php echo date_format($date, "d/m/Y H:i:s") ?></strong>
    </div>
  </div>
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
      Fecha de nacimiento: <strong><?php echo date_format($date1, "d/m/Y") ?></strong>
    </div>
    <div class="col-sm-4">
      Edad: <strong><?php if($anos > "0" ){
   echo $anos." años";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." meses";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." días";
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
      Días estancia: <strong><?php echo $estancia ?> Dias</strong>
    </div>
  </div>


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
 
  <div class="row">
     <div class="col-sm-4">
      Peso: <strong><?php echo $peso ?></strong>
    </div>
    <div class="col-sm-3">
      Talla: <strong><?php echo $talla ?></strong>
    </div>
  </div>
    
  </div>
</div>

    <?php  
    }
    ?>             
                        
</div>

<form action="insertar_nota_observacion.php" method="POST">


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
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
    <center><strong>SIGNOS VITALES</strong></center>
</div>

  <div class="container"> 
      <div class="row">
        
    <div class="col-sm-2"><center><button type="button" class="btn btn-success btn-sm" id="playpasrt"><i class="fas fa-play"></button></i> Presión arterial:</center>
     <div class="row">
         <div class="col">
            <input type="text" class="form-control" value="<?php echo $f5['p_sistol'];?>" id="txtrias" disabled>
         </div> /
         <div class="col">
            <input type="text" class="form-control" id="txtdiasppa" value="<?php echo $f5['p_diastol'];?>" disabled>
         </div>
        
    </div> mmHG / mmHG
    </div>
<script type="text/javascript">
const txtrias = document.getElementById('txtrias');
const btnPlaysispre = document.getElementById('playpasrt');

btnPlaysispre.addEventListener('click', () => {
        leerTexto(txtrias.value);
});

function leerTexto(txtrias){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtrias;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

const txtdiasppa = document.getElementById('txtdiasppa');
const btnPlaydays = document.getElementById('playpasrt');

btnPlaydays.addEventListener('click', () => {
        leerTexto(txtdiasppa.value);
});

function leerTexto(txtdiasppa){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtdiasppa;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="playciaaac"><i class="fas fa-play"></button></i> Frecuencia cardiaca:<input type="text" class="form-control" id="txtlarporm" value="<?php echo $f5['fcard'];?>" disabled> Latidos por minuto
    </div>
<script type="text/javascript">
const txtlarporm = document.getElementById('txtlarporm');
const btnPlaycamo = document.getElementById('playciaaac');

btnPlaycamo.addEventListener('click', () => {
        leerTexto(txtlarporm.value);
});

function leerTexto(txtlarporm){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtlarporm;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-3">
     <button type="button" class="btn btn-success btn-sm" id="playrespom"><i class="fas fa-play"></button></i> Frecuencia respiratoria:<input type="text" class="form-control" id="txtfrerms" value="<?php echo $f5['fresp'];?>" disabled> Respiraciones por minuto
    </div>
<script type="text/javascript">
const txtfrerms = document.getElementById('txtfrerms');
const btnPlaytoriafa = document.getElementById('playrespom');

btnPlaytoriafa.addEventListener('click', () => {
        leerTexto(txtfrerms.value);
});

function leerTexto(txtfrerms){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtfrerms;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
    <button type="button" class="btn btn-success btn-sm" id="playturr"><i class="fas fa-play"></button></i> Temperatura:<input type="text" class="form-control" id="peraa" value="<?php echo $f5['temper'];?>" disabled>°C
    </div>
<script type="text/javascript">
const peraa = document.getElementById('peraa');
const btnPlaytas = document.getElementById('playturr');

btnPlaytas.addEventListener('click', () => {
        leerTexto(peraa.value);
});

function leerTexto(peraa){
    const speech = new SpeechSynthesisUtterance();
    speech.text= peraa;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-3">
    <button type="button" class="btn btn-success btn-sm" id="playsat1"><i class="fas fa-play"></button></i> Saturación de oxígeno:<input type="text" id="txtoxias" class="form-control" value="<?php echo $f5['satoxi'];?>" disabled>%
    </div>
  </div>
</div>
<script type="text/javascript">
const txtoxias = document.getElementById('txtoxias');
const btnPlayhd1 = document.getElementById('playsat1');

btnPlayhd1.addEventListener('click', () => {
        leerTexto(txtoxias.value);
});

function leerTexto(txtoxias){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtoxias;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<?php }
?>
<?php 
}else{
                        
  ?>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>

<div class="container"> 
  <div class="row">
    <div class="col-sm-2"><center><button type="button" class="btn btn-success btn-sm" id="playpasrt"><i class="fas fa-play"></button></i>
Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" name="p_sistol" required></div> /
  <div class="col"><input type="text" class="form-control" name="p_diastol" required></div>
 
</div>mmHG / mmHG
    </div>
    <script type="text/javascript">
const txtrias = document.getElementById('txtrias');
const btnPlaysispre = document.getElementById('playpasrt');

btnPlaysispre.addEventListener('click', () => {
        leerTexto(txtrias.value);
});

function leerTexto(txtrias){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtrias;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

const txtdiasppa = document.getElementById('txtdiasppa');
const btnPlaydays = document.getElementById('playpasrt');

btnPlaydays.addEventListener('click', () => {
        leerTexto(txtdiasppa.value);
});

function leerTexto(txtdiasppa){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtdiasppa;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script><div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="playciaaac"><i class="fas fa-play"></button></i>
 Frecuencia cardiaca:<input type="text" class="form-control" name="fcard" required>
      Latidos por minuto
    </div>
<script type="text/javascript">
const txtlarporm = document.getElementById('txtlarporm');
const btnPlaycamo = document.getElementById('playciaaac');

btnPlaycamo.addEventListener('click', () => {
        leerTexto(txtlarporm.value);
});

function leerTexto(txtlarporm){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtlarporm;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-3">
     <button type="button" class="btn btn-success btn-sm" id="playrespom"><i class="fas fa-play"></button></i>
 Frecuencia respiratoria:<input type="text" class="form-control" name="fresp" required>
      Respiraciones por minuto
    </div>
<script type="text/javascript">
const txtfrerms = document.getElementById('txtfrerms');
const btnPlaytoriafa = document.getElementById('playrespom');

btnPlaytoriafa.addEventListener('click', () => {
        leerTexto(txtfrerms.value);
});

function leerTexto(txtfrerms){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtfrerms;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
    <button type="button" class="btn btn-success btn-sm" id="playturr"><i class="fas fa-play"></button></i>
 Temperatura:<input type="text" class="form-control"  name="temper" required>°C
    </div>
<script type="text/javascript">
const peraa = document.getElementById('peraa');
const btnPlaytas = document.getElementById('playturr');

btnPlaytas.addEventListener('click', () => {
        leerTexto(peraa.value);
});

function leerTexto(peraa){
    const speech = new SpeechSynthesisUtterance();
    speech.text= peraa;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
    <button type="button" class="btn btn-success btn-sm" id="playsat1"><i class="fas fa-play"></button></i>
 Saturación oxígeno:<input type="text"  class="form-control" name="satoxi" required>%
    </div>
    
  </div>
</div>
<script type="text/javascript">
const txtoxias = document.getElementById('txtoxias');
const btnPlayhd1 = document.getElementById('playsat1');

btnPlayhd1.addEventListener('click', () => {
        leerTexto(txtoxias.value);
});

function leerTexto(txtoxias){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtoxias;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<?php } ?>
 
 <hr>

 <div class="row">

    <div class=" col-12">
        <strong> Motivo de atención:</strong>
        <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playmotcii"><i class="fas fa-play"></button></i>
</div>

     <div class="form-group">
    <textarea class="form-control" id="texto" name="problemao" rows="3"></textarea>
    <script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btnPlayTextaaa = document.getElementById('playmotcii');

btnPlayTextaaa.addEventListener('click', () => {
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
 <div class="row">

    <div class=" col-12">
<strong>Resumen del interrogatorio, exploración física y estado mental:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="resg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="edodet"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playriedm"><i class="fas fa-play"></button></i>
</div> 
<div class="form-group">
<textarea class="form-control" id="txtr" rows="3" name="subjetivob"></textarea>
<script type="text/javascript">
const resg = document.getElementById('resg');
const edodet = document.getElementById('edodet');
const txtr = document.getElementById('txtr');

const btnPlay1 = document.getElementById('playriedm');

btnPlay1.addEventListener('click', () => {
        leerTexto(txtr.value);
});

function leerTexto(txtr){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtr;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let rf = new webkitSpeechRecognition();
      rf.lang = "es-ES";
      rf.continuous = true;
      rf.interimResults = false;

      rf.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtr.value += frase;
      }

      resg.addEventListener('click', () => {
        rf.start();
      });

      edodet.addEventListener('click', () => {
        rf.abort();
      });
</script>
</div>
</div>
</div>

<div class="row">
    <div class=" col-12">
        <strong>Resultados relevantes de los estudios de servicios auxiliares de diagnóstico y tratamiento previos:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="releg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detser"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playrrelevesanasa"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txtau" rows="3" name="objetivob"></textarea>
<script type="text/javascript">
const releg = document.getElementById('releg');
const detser = document.getElementById('detser');
const txtau = document.getElementById('txtau');

const btnPlay2 = document.getElementById('playrrelevesanasa');

btnPlay2.addEventListener('click', () => {
        leerTexto(txtau.value);
});

function leerTexto(txtau){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtau;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let redelo = new webkitSpeechRecognition();
      redelo.lang = "es-ES";
      redelo.continuous = true;
      redelo.interimResults = false;

      redelo.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtau.value += frase;
      }

      releg.addEventListener('click', () => {
        redelo.start();
      });

      detser.addEventListener('click', () => {
        redelo.abort();
      });
</script>
</div>
</div>
</div>


<div class="row">

    <div class="col-6"><STRONG><button type="button" class="btn btn-success btn-sm" id="pladiiiia"><i class="fas fa-play"></button></i> Diagnóstico</STRONG>
     <div class="form-group">
        <select name="analisiso" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%">
            <option value="">Seleccionar</option>
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_diag ORDER by id_cie10";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['diagnostico'] . "'>" . $row['id_cie10'] . "- " . $row['diagnostico'] . "</option>";
}
 ?></select>
  </div>
    </div>
<script type="text/javascript">
const mibuscador = document.getElementById('mibuscador');
const btnPlay3 = document.getElementById('pladiiiia');

btnPlay3.addEventListener('click', () => {
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
    <div class="col-6">
<strong>Describir: </strong><button type="button" class="btn btn-danger btn-sm" id="describirdg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopdescri"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pladdesss"><i class="fas fa-play"></button></i>
<textarea class="form-control" name="des_diag" id="desgiag"></textarea>
<script type="text/javascript">
const describirdg = document.getElementById('describirdg');
const stopdescri = document.getElementById('stopdescri');
const desgiag = document.getElementById('desgiag');

const btnPlay4 = document.getElementById('pladdesss');

btnPlay4.addEventListener('click', () => {
        leerTexto(desgiag.value);
});

function leerTexto(desgiag){
    const speech = new SpeechSynthesisUtterance();
    speech.text= desgiag;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let rdesdi = new webkitSpeechRecognition();
      rdesdi.lang = "es-ES";
      rdesdi.continuous = true;
      rdesdi.interimResults = false;

      rdesdi.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        desgiag.value += frase;
      }

      describirdg.addEventListener('click', () => {
        rdesdi.start();
      });

      stopdescri.addEventListener('click', () => {
        rdesdi.abort();
      });
</script>
</div>
</div>


<div class="row">
<div class=" col-12">
<strong>Tratamiento y plan:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="pyg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detta"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="platrpalan"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txttoy" rows="3" name="trat_noturgen"></textarea>
<script type="text/javascript">
const pyg = document.getElementById('pyg');
const detta = document.getElementById('detta');
const txttoy = document.getElementById('txttoy');

const btnPlay5 = document.getElementById('platrpalan');

btnPlay5.addEventListener('click', () => {
        leerTexto(txttoy.value);
});

function leerTexto(txttoy){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txttoy;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let reat = new webkitSpeechRecognition();
      reat.lang = "es-ES";
      reat.continuous = true;
      reat.interimResults = false;

      reat.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txttoy.value += frase;
      }

      pyg.addEventListener('click', () => {
        reat.start();
      });

      detta.addEventListener('click', () => {
        reat.abort();
      });
</script>
</div>
</div>
</div>

<div class="row">
<div class=" col-12">
<strong>Pronóstico para la vida / para la función:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="ticog"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detfun"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="plalavida"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txtpl" rows="3" name="plano"></textarea>
<script type="text/javascript">
const ticog = document.getElementById('ticog');
const detfun = document.getElementById('detfun');
const txtpl = document.getElementById('txtpl');

const btnPlay6 = document.getElementById('plalavida');

btnPlay6.addEventListener('click', () => {
        leerTexto(txtpl.value);
});

function leerTexto(txtpl){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtpl;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let reppl = new webkitSpeechRecognition();
      reppl.lang = "es-ES";
      reppl.continuous = true;
      reppl.interimResults = false;

      reppl.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtpl.value += frase;
      }

      ticog.addEventListener('click', () => {
        reppl.start();
      });

      detfun.addEventListener('click', () => {
        reppl.abort();
      });
</script>
</div>
</div>
</div>

<div class="row">
<div class=" col-12"> <strong>Observaciones y análisis:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="lig"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detvas"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pobanlss"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea class="form-control" id="txtses" rows="3" name="pxo"></textarea>
<script type="text/javascript">
const lig = document.getElementById('lig');
const detvas = document.getElementById('detvas');
const txtses = document.getElementById('txtses');

const btnPlay7 = document.getElementById('pobanlss');

btnPlay7.addEventListener('click', () => {
        leerTexto(txtses.value);
});

function leerTexto(txtses){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtses;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let rsya = new webkitSpeechRecognition();
      rsya.lang = "es-ES";
      rsya.continuous = true;
      rsya.interimResults = false;

      rsya.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtses.value += frase;
      }

      lig.addEventListener('click', () => {
        rsya.start();
      });

      detvas.addEventListener('click', () => {
        rsya.abort();
      });
</script>
</div>
</div>
</div>

<div class="row">
<div class=" col-sm-9">
<strong><button type="button" class="btn btn-success btn-sm" id="pguaii"><i class="fas fa-play"></button></i> Guía de práctica clínica:</strong>

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
const btnPlay8 = document.getElementById('pguaii');

btnPlay8.addEventListener('click', () => {
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




<hr>
<?php if ($area ==='HOSPITALIZACION' or $area ==='Hospitalización') { ?>
    <div class="col">
<div class="form-group">
 <label for=""><strong><button type="button" class="btn btn-success btn-sm" id="pdestino1"><i class="fas fa-play"></button></i> Destino: </strong></label>
 <input type="text" name="" value="Hospitalización" disabled="" id="txtdesdisab">
    </div>
</div>
<script type="text/javascript">
const txtdesdisab = document.getElementById('txtdesdisab');
const btnPlay9 = document.getElementById('pdestino1');

btnPlay9.addEventListener('click', () => {
        leerTexto(txtdesdisab.value);
});

function leerTexto(txtdesdisab){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtdesdisab;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<?php }else{ ?>
<div class="col">
<div class="form-group">
 <label for="dest_cu_ob"><strong><button type="button" class="btn btn-success btn-sm" id="pdestino1"><i class="fas fa-play"></button></i> Destino: </strong></label>
   <input type="text" name="dest_cu_ob" class="form-control" id="txtdesdisab">
    </div>
</div>
<script type="text/javascript">
const txtdesdisab = document.getElementById('txtdesdisab');
const btnPlay9 = document.getElementById('pdestino1');

btnPlay9.addEventListener('click', () => {
        leerTexto(txtdesdisab.value);
});

function leerTexto(txtdesdisab){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtdesdisab;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <?php } ?>
<hr>

<!--
<div class="row" id="contenido">
    <div class="col-sm">
     
      <strong><p>TIPO DE INTERVENCIÓN:</p></strong>
     <div class="form-check">
  <input class="form-check-input" type="radio" name="tipo_intervenciony" value="URGENCIA" name="tipocir">
  <label class="form-check-label"  for="URGENCIAS">
    URGENCIA
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio"  name="tipo_intervenciony" value="ELECTIVA" name="tipocir">
  <label class="form-check-label" for="URGENCIAS">
    ELECTIVA
  </label>
</div>
    </div>

  <hr>
  
  <div class="row">
    <div class="col-sm">
     
    <label for="exampleFormControlInput1"><strong>FECHA DE SOLICITUD:</strong></label>
    <input type="date" class="form-control" name="fechay"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="">
  
    </div>
    <div class="col-sm">
     <div class="form-group">
    <label for="exampleFormControlInput1"><strong>HORA DESEADA:</strong></label>
    <input type="time" class="form-control" name="hora_solicitudy"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
    </div>
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlInput1"><strong>INTERVENCIÓN SOLICITADA:</strong></label>
    <input type="text" class="form-control" name="intervencion_soly"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
    </div>
  </div>

  
 
<div class="form-group">
        <label for="id_cie_10"><strong> DIAGNÓSTICO PREOPERATORIO:</strong></label>
        <input type="text" class="form-control" name="diag_preopy"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>


<div class="form-group">
        <label for="cirugia_prog"><strong>CIRUGÍA PROGRAMADA:</strong></label>
        <input type="text" class="form-control" name="cirugia_progy"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>


<hr id="contenido">

<div class="row">

  <div class="col"><strong><center>SANGRE EN</center></strong><hr>
    
  <div class="row">
    <div class="col-sm">
      <label for="exampleFormControlInput1">QUIROFANO:</label>
    <input type="text" class="form-control" name="quirofanoy"  id="exampleFormControlInput1" placeholder="ml." style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    <div class="col-sm">
      <label for="exampleFormControlInput1">RESERVA:</label>
    <input type="text" class="form-control" name="reservay" id="exampleFormControlInput1"  placeholder="ml." style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
  </div>
<hr >
  </div>
  <div class="col"><strong><center>ANESTESIA</center></strong><hr>
  <div class="row">
    <div class="col-sm-4">
    <label for="exampleFormControlInput1">LOCAL</label>
    <input type="text" class="form-control" name="localy" id="exampleFormControlInput1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"> 
    </div>
    <div class="col-sm-4">
      <label for="exampleFormControlInput1">REGIONAL</label>
    <input type="text" class="form-control" name="regionaly" id="exampleFormControlInput1"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"> 
    </div>
    <div class="col-sm-4">
      <label for="exampleFormControlInput1">GENERAL</label>
    <input type="text" class="form-control" name="generaly" id="exampleFormControlInput1"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
  </div>
  <hr>
  </div>
  <div class="col"><br><hr>
<div class="row">
    <div class="col-sm">
      <div class="col-sm">
    <label for="exampleFormControlInput1">Hb:</label>
    <input type="text" class="form-control" name="hby" id="exampleFormControlInput1"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    </div>
    <div class="col-sm">
      <div class="col-sm">
    <label for="exampleFormControlInput1">HTO:</label>
    <input type="text" class="form-control" name="htoy" id="exampleFormControlInput1"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    </div>
  </div>
<hr >
  </div>
  <div class="col"><hr>

<div class="row">
    <div class="col-sm"><br>
       <label for="exampleFormControlInput1">PESO:</label>
    <input type="text" class="form-control" name="pesoy" id="exampleFormControlInput1"  placeholder="KG" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    
  </div>
<hr>
  </div>

</div>

<br>

  <div class="row">
    <div class="col-sm">
      <label for="exampleFormControlTextarea1"><strong>INSTRUMENTAL NECESARIO</strong></label>
    <textarea class="form-control" name="inst_necesarioy" id="exampleFormControlTextarea1" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
    </div>
    <div class="col-sm">
      <label for="exampleFormControlTextarea5"><strong>MEDICAMENTOS Y MATERIAL NECESARIO</strong></label>
    <textarea class="form-control" name="medmat_necesarioy" id="exampleFormControlTextarea5" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
    </div>
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlInput1"><strong>NOMBRE DEL JEFE DE SERVICIO</strong></label>
    <input type="text" class="form-control" name="nom_jefe_servy" id="exampleFormControlInput1" placeholder="Nombre" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
    </div>
  </div>

<hr id="contenido">
<strong><center id="contenido">PROGRAMACIÓN EN QUIROFANO</center></strong><br>

<div class="row">
  <div class="col">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>FECHA DE PROGRAMACIÓN</strong></label>
    <input type="date" class="form-control" name="fecha_progray" id="exampleFormControlInput1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</div>
  <div class="col">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>HORA</strong></label>
    <input type="time" class="form-control" name="hora_progray"  id="exampleFormControlInput1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  </div>
  <div class="col">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>SALA</strong></label>
    <select class="form-control" id="sala" name="salay">
                                        <option value="">Seleccionar opción</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
  </div>
  </div>
</div>

<div class="row" >
  <div class="col-6">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>INTERVENCIÓN</strong></label>
    <input type="text" class="form-control" name="intervencion_quiry" id="exampleFormControlInput1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</div>
  <div class="col">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>INICIO</strong></label>
    <input type="time" class="form-control" name="inicioy"  id="exampleFormControlInput1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  
  </div>
</div>
  <div class="col">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>TÉRMINO</strong></label>
    <input type="time" class="form-control" name="terminoy"  id="exampleFormControlInput1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
</div>
  
</div>


    <hr>

    </div> 
</div>  -->


<div class="form-group col-12">
<center><button type="submit" class="btn btn-primary">Firmar</button> <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button></center>
</div>


<br>
<br>
</form>


   <!--TERMINO DE NOTA DE EVOLUCION-->

</div>
</div>
<?php }else{
echo '<script type="text/javascript"> window.location.href="../../template/select_pac_hosp.php";</script>';

} ?>
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

<script>
    document.oncontextmenu = function () {
        return false;
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
    $(document).ready(function () {
        $('#mibuscador11').select2();
    });
</script>
<script type="text/javascript">
        function mostrar(value)
        {
            if(value=="QUIROFANO" || value==true)
            {
                // habilitamos
                document.getElementById('contenido').style.display = 'block';
            }else if(value=="HOSPITALIZACION" || value=="EGRESO DE URGENCIAS"  || value==false){
                // deshabilitamos
                document.getElementById('contenido').style.display = 'none';
            }
        }
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