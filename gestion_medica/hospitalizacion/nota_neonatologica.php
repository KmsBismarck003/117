<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");
if (isset($_SESSION['hospital'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
    $resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp  WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);
    if (mysqli_num_rows($resultado) > 0) { //se mostrara si existe mas de 1
        $f = mysqli_fetch_row($resultado);

    } else {
        header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
    }
} else {
    header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
}
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
    
    .modal-lg { max-width: 65% !important; }
</style>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>NOTA DE NEONATOLÓGICA</center></strong>
</div>
            
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
      Expediente: <strong><?php echo $id_exp?> </strong>
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
} ?>
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
<div class="tab-content" id="nav-tabContent">
   <!--INICIO DE NOTA DE EVOLUCION-->
<div class="tab-pane fade show active" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">


          <form action="insertar_nota_neonatologica.php" method="POST">

<div class="container -12">
                <div class="row col-6">
                    <div class="col-sm">
                      
                        <!--<strong>No. Admisión:</strong>-->
                        
                        <input type="hidden" name="id_atencion" class="form-control" value="<?php echo $_SESSION['hospital'] ?>"
                               readonly placeholder="No. De expediente">
                    </div>
                </div>
            </div>
<div class="row">
<div class="col-5">
   <strong><label for="idrecien_nacido"><font size="5" color="#2b2d7f"><button type="button" class="btn btn-success btn-sm" id="play"><i class="fas fa-play"></button></i> Identificación del recien nacido: </font></label></strong>
</div>
    <div class=" col-6">
     <div class="form-group">
       <input type="text" name="idrecien_nacido" class="form-control" required id="textop">
       <script type="text/javascript">

const textop = document.getElementById('textop');
const btnPlayText = document.getElementById('play');

btnPlayText.addEventListener('click', () => {
        leerTexto(textop.value);
});

function leerTexto(textop){
    const speech = new SpeechSynthesisUtterance();
    speech.text= textop;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script> 
       <strong><label> Fecha y hora de nacimiento</label></strong>
       <div class="row">
         <div class="col-sm-4">
         <input type="date" name="fecnacimiento" class="form-control" required>
        </div>
        <div class="col-sm-4">
          <input type="time" name="horanac" class="form-control" required>
        </div>
</div>
     </div>
    </div>
</div>  
  <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES DEL RECIEN NACIDO</strong></center><p>
</div>
                <div class="container"> 
  <div class="row">
    <div class="col-sm-2"><br><center><button type="button" class="btn btn-success btn-sm" id="playpata"><i class="fas fa-play"></button></i> Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" name="p_sistol" required id="txtpsia"></div> /
  <div class="col"><input type="text" class="form-control" name="p_diastol" required id="txtartpress"></div>mmHG / mmHG
 <script type="text/javascript">

const txtpsia = document.getElementById('txtpsia');
const btnPlaytols = document.getElementById('playpata');

btnPlaytols.addEventListener('click', () => {
        leerTexto(txtpsia.value);
});

function leerTexto(txtpsia){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtpsia;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

const txtartpress = document.getElementById('txtartpress');
const btnPlaydiaspress = document.getElementById('playpata');

btnPlaydiaspress.addEventListener('click', () => {
        leerTexto(txtartpress.value);
});

function leerTexto(txtartpress){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtartpress;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script> 
</div>
    </div>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="playcardiacaaa"><i class="fas fa-play"></button></i> Frecuencia cardiaca:<input type="text" class="form-control" name="fcard" id="txtdiacacuen" required >Latidos por minuto
    </div>
     <script type="text/javascript">
const txtdiacacuen = document.getElementById('txtdiacacuen');
const btnPlayiaa = document.getElementById('playcardiacaaa');

btnPlayiaa.addEventListener('click', () => {
        leerTexto(txtdiacacuen.value);
});

function leerTexto(txtdiacacuen){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtdiacacuen;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script> 
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="playrespfeee"><i class="fas fa-play"></button></i> Frecuencia respiratoria:<input type="text" id="txttoriapira" class="form-control" name="fresp" required>Respiraciones por minuto
        <script type="text/javascript">
const txttoriapira = document.getElementById('txttoriapira');
const btnPlaycufad = document.getElementById('playrespfeee');

btnPlaycufad.addEventListener('click', () => {
        leerTexto(txttoriapira.value);
});

function leerTexto(txttoriapira){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txttoriapira;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script> 
    </div>
    <div class="col-sm-2">
     <br><button type="button" class="btn btn-success btn-sm" id="playtteu"><i class="fas fa-play"></button></i> Temperatura:<input type="text" class="form-control" id="txttttt"  name="temper" required>°C 
    </div>
    <script type="text/javascript">
const txttttt = document.getElementById('txttttt');
const btnPlaysoltura = document.getElementById('playtteu');

btnPlaysoltura.addEventListener('click', () => {
        leerTexto(txttttt.value);
});

function leerTexto(txttttt){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txttttt;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
    <button type="button" class="btn btn-success btn-sm" id="playcionox"><i class="fas fa-play"></button></i>  Saturación oxígeno:<input type="text"  class="form-control" id="ixitxt" name="satoxi" required>%
    </div>
<script type="text/javascript">
const ixitxt = document.getElementById('ixitxt');
const btnPlaytxtasofhf = document.getElementById('playcionox');

btnPlaytxtasofhf.addEventListener('click', () => {
        leerTexto(ixitxt.value);
});

function leerTexto(ixitxt){
    const speech = new SpeechSynthesisUtterance();
    speech.text= ixitxt;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-1">
     <br><button type="button" class="btn btn-success btn-sm" id="playpeso"><i class="fas fa-play"></button></i> Peso:<input type="text" class="form-control" id="pstxt"  name="peso" required>
    </div>
    <script type="text/javascript">
const pstxt = document.getElementById('pstxt');
const btnPlaypess = document.getElementById('playpeso');

btnPlaypess.addEventListener('click', () => {
        leerTexto(pstxt.value);
});

function leerTexto(pstxt){
    const speech = new SpeechSynthesisUtterance();
    speech.text= pstxt;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-1">
    <button type="button" class="btn btn-success btn-sm" id="playtcm"><i class="fas fa-play"></button></i> Talla (cm):<input type="text" class="form-control" name="talla" id="txtcmtal" required>
    </div>
    <script type="text/javascript">
const txtcmtal = document.getElementById('txtcmtal');
const btnPlaytalll = document.getElementById('playtcm');

btnPlaytalll.addEventListener('click', () => {
        leerTexto(txtcmtal.value);
});

function leerTexto(txtcmtal){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtcmtal;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
     <br><button type="button" class="btn btn-success btn-sm" id="playapgar"><i class="fas fa-play"></button></i> Apgar:<input type="text" class="form-control" id="txtappp" name="apgar" required>
    </div>
<script type="text/javascript">
const txtappp = document.getElementById('txtappp');
const btnPlaygara = document.getElementById('playapgar');

btnPlaygara.addEventListener('click', () => {
        leerTexto(txtappp.value);
});

function leerTexto(txtappp){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtappp;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
     <br><button type="button" class="btn btn-success btn-sm" id="playmansil"><i class="fas fa-play"></button></i> Silverman:<input type="text" class="form-control" id="txtsill" name="silver" required>
    </div>
<script type="text/javascript">
const txtsill = document.getElementById('txtsill');
const btnPlaymansa = document.getElementById('playmansil');

btnPlaymansa.addEventListener('click', () => {
        leerTexto(txtsill.value);
});

function leerTexto(txtsill){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtsill;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
     <div class="col-sm-4">
     <br><button type="button" class="btn btn-success btn-sm" id="playanomal"><i class="fas fa-play"></button></i> Anomalias congenitas:<input type="text" id="txtconnda" class="form-control" name="an" value="Ninguna aparente">
    </div>
  </div>
</div>
<script type="text/javascript">
const txtconnda = document.getElementById('txtconnda');
const btnPlaymtascon = document.getElementById('playanomal');

btnPlaymtascon.addEventListener('click', () => {
        leerTexto(txtconnda.value);
});

function leerTexto(txtconnda){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtconnda;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<hr>

  <div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#2b2d7f">P</font></label></strong></center>
    </div>
    <div class=" col-10">
  <strong><font color="black">Paciente: describir al paciente (edad,género, diagnósticos y tratamientos previos)pronóstico: para la vida y para la función</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playedgage"><i class="fas fa-play"></button></i>
</div>
     <div class="form-group">
    <textarea class="form-control" id="texto" name="pac_neon" rows="3" ></textarea>
    <script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btnPlaypacditp = document.getElementById('playedgage');

btnPlaypacditp.addEventListener('click', () => {
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
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#2b2d7f">S</font></label></strong></center>
    </div>
    <div class=" col-10">
        <strong><font color="black">Subjetivo: describir la sintomatología del paciente, hábitos, a que atribuye el padecimiento actual, etc.</font></strong>
        <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="subg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detd"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playsubje"><i class="fas fa-play"></button></i>
</div>
     <div class="form-group">
    <textarea class="form-control" id="txts" rows="3" name="subjetivo_neon"></textarea>
    <script type="text/javascript">
const subg = document.getElementById('subg');
const detd = document.getElementById('detd');
const txts = document.getElementById('txts');

const btnPlayetcpad = document.getElementById('playsubje');

btnPlayetcpad.addEventListener('click', () => {
        leerTexto(txts.value);
});

function leerTexto(txts){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txts;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let rs = new webkitSpeechRecognition();
      rs.lang = "es-ES";
      rs.continuous = true;
      rs.interimResults = false;

      rs.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txts.value += frase;
      }

      subg.addEventListener('click', () => {
        rs.start();
      });

      detd.addEventListener('click', () => {
        rs.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f">O</font></label></strong></center>
    </div>
    <div class=" col-10">
         <strong><font color="black">Objetivo: describir la exploración física</font></strong>
         <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="obg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="deto"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playobjdex"><i class="fas fa-play"></button></i>
</div>
     <div class="form-group">
    <textarea class="form-control" id="txtoe" rows="3" name="objetivo_neon"></textarea>
    <script type="text/javascript">
const obg = document.getElementById('obg');
const deto = document.getElementById('deto');
const txtoe = document.getElementById('txtoe');

const btnPlayexfiss = document.getElementById('playobjdex');

btnPlayexfiss.addEventListener('click', () => {
        leerTexto(txtoe.value);
});

function leerTexto(txtoe){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtoe;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let reod = new webkitSpeechRecognition();
      reod.lang = "es-ES";
      reod.continuous = true;
      reod.interimResults = false;

      reod.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtoe.value += frase;
      }

      obg.addEventListener('click', () => {
        reod.start();
      });

      deto.addEventListener('click', () => {
        reod.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f">A</font></label></strong></center>
    </div>
    <div class=" col-10">
<strong><font color="black">Análisis: los diagnósticos probables y definitivos y los argumentos, correlación de los estudios de laboratorio y gabinete con el padecimiento actual.</font></strong>
 <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="arg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detcorr"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playanalisisa"><i class="fas fa-play"></button></i>
</div>
     <div class="form-group">
    <textarea class="form-control" id="txtana" rows="3" name="analisis_neon"></textarea>
    <script type="text/javascript">
const arg = document.getElementById('arg');
const detcorr = document.getElementById('detcorr');
const txtana = document.getElementById('txtana');

const btnPlayeslabgapad = document.getElementById('playanalisisa');

btnPlayeslabgapad.addEventListener('click', () => {
        leerTexto(txtana.value);
});

function leerTexto(txtana){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtana;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let reanaa = new webkitSpeechRecognition();
      reanaa.lang = "es-ES";
      reanaa.continuous = true;
      reanaa.interimResults = false;

      reanaa.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtana.value += frase;
      }

      arg.addEventListener('click', () => {
        reanaa.start();
      });

      detcorr.addEventListener('click', () => {
        reanaa.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f">P</font></label></strong></center>
    </div>
    <div class=" col-10">
<strong><font color="black">Plan: describir tratamiento y recomendaciones indicadas al paciente, anotar los medicamentos con su dosis de manera detallada.</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="pdgt"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detreco"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playplannna"><i class="fas fa-play"></button></i>
</div>        
     <div class="form-group">
    <textarea class="form-control" id="txtdos" rows="3" name="plan_neon"></textarea>
    <script type="text/javascript">
const pdgt = document.getElementById('pdgt');
const detreco = document.getElementById('detreco');
const txtdos = document.getElementById('txtdos');

const btnPlayreccin = document.getElementById('playplannna');

btnPlayreccin.addEventListener('click', () => {
        leerTexto(txtdos.value);
});

function leerTexto(txtdos){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtdos;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let rede = new webkitSpeechRecognition();
      rede.lang = "es-ES";
      rede.continuous = true;
      rede.interimResults = false;

      rede.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtdos.value += frase;
      }

      pdgt.addEventListener('click', () => {
        rede.start();
      });

      detreco.addEventListener('click', () => {
        rede.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f">PX</font></label></strong></center>
    </div>
    <div class=" col-10">
        <strong><font color="black">Pronóstico: para la vida y para la función</font></strong>
        <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="fung"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="deton"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playvidafunca"><i class="fas fa-play"></button></i>
</div> 
     <div class="form-group">
    <textarea class="form-control" id="txtti" rows="3" name="px_neon"></textarea>
    <script type="text/javascript">
const fung = document.getElementById('fung');
const deton = document.getElementById('deton');
const txtti = document.getElementById('txtti');

const btnPlaypronasas = document.getElementById('playvidafunca');

btnPlaypronasas.addEventListener('click', () => {
        leerTexto(txtti.value);
});

function leerTexto(txtti){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtti;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let repro = new webkitSpeechRecognition();
      repro.lang = "es-ES";
      repro.continuous = true;
      repro.interimResults = false;

      repro.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtti.value += frase;
      }

      fung.addEventListener('click', () => {
        repro.start();
      });

      deton.addEventListener('click', () => {
        repro.abort();
      });
</script>
</div>
</div>
</div>
<div class="row">
<div class=" col-sm-9">
<strong><button type="button" class="btn btn-success btn-sm" id="playgiacl"><i class="fas fa-play"></button></i> Guía de práctica clínica:</strong>

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
const btnPlay12 = document.getElementById('playgiacl');

btnPlay12.addEventListener('click', () => {
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
<div class="row">
<div class="col-3">
<center><strong><label for="edosalud_neon"><font size="5"color="#2b2d7f"><button type="button" class="btn btn-success btn-sm" id="playedonacido"><i class="fas fa-play"></button></i> Estado de salud del recien nacido:</font></label></strong></center>
    </div>
<div class=" col-5">
<select class="form-control" aria-label="edosalud" name="edosalud_neon" id="txtnrenac">
  <option selected>SELECCIONAR ESTADO DE SALUD</option>
  <option value="ESTABLE">ESTABLE</option>
  <option value="DELICADO">DELICADO</option>
  <option value="GRAVE">GRAVE</option>
  <option value="ALTA MEDICA">ALTA MÉDICA</option>
</select>
</div>
</div>
<script type="text/javascript">
const txtnrenac = document.getElementById('txtnrenac');
const btnPlanac = document.getElementById('playedonacido');

btnPlanac.addEventListener('click', () => {
        leerTexto(txtnrenac.value);
});

function leerTexto(txtnrenac){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtnrenac;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

</script>
<hr>
<div class="form-group col-12">
<center><button type="submit" class="btn btn-primary">Firmar y guardar</button>
<button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button></center>
</div>


<br>
<br>
</form>
</div>

   <!--TERMINO DE NOTA DE EVOLUCION-->

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