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

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css"
          type="text/css"/>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>


    <title>DATOS NUEVA NOTA DE EVOLUCIÓN </title>
    <style type="text/css">
    .modal-lg { max-width: 65% !important; }
</style>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
                 <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 22px;">
  <center><strong>NUEVA NOTA DE EVOLUCIÓN</strong></center><p>
</div>
             
                <?php

                include "../../conexionbd.php";

                $resultado1 = $conexion->query("select paciente.*, paciente.fecnac, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);

                ?>
                <?php
                while ($f1 = mysqli_fetch_array($resultado1)) {

                   $id_atencion =  $_SESSION['hospital'];


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
  $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by id_ne DESC LIMIT 1";
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

                    <hr>
                    <?php
                }
                ?>

            </div>
           
        </div>

 
 
        <form action="" method="POST">
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
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>

<div class="container"> 
     <div class="row">
        
    <div class="col-sm-2"><center>Presión arterial:</center>
     <div class="row">
         <div class="col">
            <input type="text" class="form-control" value="<?php echo $f5['p_sistol'];?>" disabled>
         </div> /
         <div class="col">
            <input type="text" class="form-control" value="<?php echo $f5['p_diastol'];?>" disabled>
         </div>
        
    </div> mmHG / mmHG
    </div>
    <div class="col-sm-2">
      Frecuencia cardiaca:<input type="text" class="form-control" value="<?php echo $f5['fcard'];?>" disabled> Latidos por minuto
    </div>
    <div class="col-sm-3">
      Frecuencia respiratoria:<input type="text" class="form-control" value="<?php echo $f5['fresp'];?>" disabled> Respiraciones por minuto
    </div>
    <div class="col-sm-2">
     Temperatura:<input type="text" class="form-control" value="<?php echo $f5['temper'];?>" disabled>°C
    </div>
    <div class="col-sm-3">
     Saturación de oxígeno:<input type="text"  class="form-control" value="<?php echo $f5['satoxi'];?>" disabled>%
    </div>
  </div>
</div>
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
    <div class="col-sm-2"><br><center>Presión Arterial:</center>
     <div class="row">
       <div class="col"><input type="text" class="form-control" name="p_sistol" ></div> /
      <div class="col"><input type="text" class="form-control" name="p_diastol"></div>
 
    </div> mmHG / mmHG
    </div>
    <div class="col-sm-2">
      Frecuencia Cardiaca:<input type="text" class="form-control" name="fcard">
    </div>
    <div class="col-sm-2">
      Frecuencia Respiratoria:<input type="text" class="form-control" name="fresp">
    </div>
    <div class="col-sm-2">
     <br>Temperatura:<input type="text" class="form-control"  name="temper">
    </div>
    <div class="col-sm-2">
     Saturación de oxígeno:<input type="text"  class="form-control" name="satoxi">
    </div>
    
  </div>
</div>

<?php } ?>
<hr>
<!--<?php
                          
                            //$fecha_actual2 = date("d-m-Y H:i:s");
                            ?>

            <div class="row">
                <div class="col-sm-3">
                    FECHA Y HORA: <input class="form-control" disabled value="<?php// $fecha_actual2 ?>*/" >
                </div>
                <div class="col-sm-3">
                    HORA: <input type="time" name="hora_ord" class="form-control">
                </div>
            </div>-->

<!--validacion si existe nota ordenes med-->
<?php 

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from dat_nevol WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_ne DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
      $oatencion=$f5['id_ne'];
    }
    ?>
 <?php
if (isset($oatencion)) {
                        ?>
<?php 
include "../../conexionbd.php";
$resultado5=$conexion->query("select * from dat_nevol WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_ne DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
    ?>

<?php 
//$id_ord=$_GET['id_ord'];
$tras=("SELECT * FROM dat_nevol WHERE id_atencion=" . $_SESSION ['hospital']."  ORDER BY id_ne DESC LIMIT 1");
$result=$conexion->query($tras);
while ($row=$result->fetch_assoc()) {
    
 ?>            


<div class="col-sm-4">
   <strong> <font size="4" color="#2b2d7f"><button type="button" class="btn btn-success btn-sm" id="play9"><i class="fas fa-play"></button></i> Especialidad:</font></strong>
        <select name="servi" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%" required="">
            
<option value="<?php echo $row['servi'] ?>"><?php echo $row['servi'] ?></option>
<option value="" disabled>Seleccionar</option>

<?php

$sql_diag="SELECT * FROM cat_espec";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['espec'] . "'>" . $row['espec'] . "</option>";
}
 ?>
</select>
  </div><p></p>
<script type="text/javascript">
const mibuscador = document.getElementById('mibuscador');
const btnPlayTex9 = document.getElementById('play9');

btnPlayTex9.addEventListener('click', () => {
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
           <div class="row">           
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#2b2d7f"><br>P</font></label></strong></center>
    </div>
     
    <div class=" col-10">
     <strong> <font size="4" color="#2b2d7f">Paciente:</font></strong>
     <strong><font color="black">Describir al paciente (Edad, Género, Dianósticos y tratamientos previos)</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play"><i class="fas fa-play"></button></i>
</div> 
<div class="form-group">                            
<textarea name="problema" class="form-control" id="texto" required="" rows="5"><?php echo $f5['problema'] ?></textarea>
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

const btnPlayText = document.getElementById('play');

btnPlayText.addEventListener('click', () => {
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
</script>
  </div>
    </div>
</div>
           
<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#2b2d7f"><br>S</font></label></strong></center>
</div>
<div class=" col-10">
  <strong> <font size="4" color="#2b2d7f">Subjetivo:</font></strong>
  <strong><font color="black">Describir la sintomatología del paciente, hábitos, a qué atribuye el padecimiento actual, etc. </font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="subg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="dets"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play2"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea name="subjetivo" class="form-control" id="txts" required="" rows="5"><?php echo $f5['subjetivo'] ?></textarea>
<script type="text/javascript">
const subg = document.getElementById('subg');
const dets = document.getElementById('dets');
const txts = document.getElementById('txts');

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

      dets.addEventListener('click', () => {
        rs.abort();
      });

const btnPlayText2 = document.getElementById('play2');

btnPlayText2.addEventListener('click', () => {
        leerTexto(txts.value);
});

function leerTexto(txts){
    const speech2 = new SpeechSynthesisUtterance();
    speech2.text= txts;
    speech2.volume=1;
    speech2.rate=1;
    speech2.pitch=0;
    window.speechSynthesis.speak(speech2);
}
</script>
</div>
</div>
</div>
         
            
<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f"><br>O</font></label></strong></center>
</div>
<div class=" col-10">
<strong> <font size="4" color="#2b2d7f">Objetivo:</font></strong>
<strong><font color="black">Describir la exploración física</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="objg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="deto"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play3"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea name="objetivo" class="form-control" id="txto" required="" rows="5"><?php echo $f5['objetivo'] ?></textarea>
<script type="text/javascript">
const objg = document.getElementById('objg');
const deto = document.getElementById('deto');
const txto = document.getElementById('txto');

     let ro = new webkitSpeechRecognition();
      ro.lang = "es-ES";
      ro.continuous = true;
      ro.interimResults = false;

      ro.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txto.value += frase;
      }

      objg.addEventListener('click', () => {
        ro.start();
      });

      deto.addEventListener('click', () => {
        ro.abort();
      });

const btnPlayText3 = document.getElementById('play3');

btnPlayText3.addEventListener('click', () => {
        leerTexto(txto.value);
});

function leerTexto(txto){
    const speech3 = new SpeechSynthesisUtterance();
    speech3.text= txto;
    speech3.volume=1;
    speech3.rate=1;
    speech3.pitch=0;
    window.speechSynthesis.speak(speech3);
}

</script>
</div>
</div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f"><br>A</font></label></strong></center>
</div>
<div class=" col-10">
<strong> <font size="4" color="#2b2d7f">Análisis:</font></strong>
<strong><font color="black">Los diagnósticos probables y definitivos y los argumentos, correlación de los estudios de laboratorio y gabinete con el padecimiento actual</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="ang"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detal"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play4"><i class="fas fa-play"></button></i>
</div>
     <div class="form-group">
      <textarea name="analisis" class="form-control" id="txtpr" required="" rows="5"><?php echo $f5['analisis'] ?></textarea>
<script type="text/javascript">
const ang = document.getElementById('ang');
const detal = document.getElementById('detal');
const txtpr = document.getElementById('txtpr');

     let roadp = new webkitSpeechRecognition();
      roadp.lang = "es-ES";
      roadp.continuous = true;
      roadp.interimResults = false;

      roadp.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtpr.value += frase;
      }

      ang.addEventListener('click', () => {
        roadp.start();
      });

      detal.addEventListener('click', () => {
        roadp.abort();
      });

const btnPlayText4 = document.getElementById('play4');

btnPlayText4.addEventListener('click', () => {
        leerTexto(txtpr.value);
});

function leerTexto(txtpr){
    const speech4 = new SpeechSynthesisUtterance();
    speech4.text= txtpr;
    speech4.volume=1;
    speech4.rate=1;
    speech4.pitch=0;
    window.speechSynthesis.speak(speech4);
}
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f"><br>P</font></label></strong></center>
    </div>
    <div class=" col-10">
<strong> <font size="4" color="#2b2d7f">Plan:</font></strong>
<strong><font color="black">Describir tratamiento y recomendaciones indicadas al paciente, anotar los medicamentos con sus dosis de manera detallada</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="pang"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detrec"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play5"><i class="fas fa-play"></button></i>
</div>
     <div class="form-group">
      <textarea name="plan" class="form-control" id="txtip" required="" rows="5"><?php echo $f5['plan'] ?></textarea>
      <script type="text/javascript">
const pang = document.getElementById('pang');
const detrec = document.getElementById('detrec');
const txtip = document.getElementById('txtip');

     let remd = new webkitSpeechRecognition();
      remd.lang = "es-ES";
      remd.continuous = true;
      remd.interimResults = false;

      remd.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtip.value += frase;
      }

      pang.addEventListener('click', () => {
        remd.start();
      });

      detrec.addEventListener('click', () => {
        remd.abort();
      });

const btnPlayText5 = document.getElementById('play5');

btnPlayText5.addEventListener('click', () => {
        leerTexto(txtip.value);
});

function leerTexto(txtip){
    const speech5 = new SpeechSynthesisUtterance();
    speech5.text= txtip;
    speech5.volume=1;
    speech5.rate=1;
    speech5.pitch=0;
    window.speechSynthesis.speak(speech5);
}
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f"><br>PX</font></label></strong></center>
</div>
<div class=" col-10">
<strong> <font size="4" color="#2b2d7f">Pronóstico:</font></strong>
<strong><font color="black">Para la vida y para la función</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="pxg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detpx"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play6"><i class="fas fa-play"></button></i>
</div>
<div class="form-group">
<textarea name="px" class="form-control" id="txtx" required="" rows="5"><?php echo $f5['px'] ?></textarea>
<script type="text/javascript">
const pxg = document.getElementById('pxg');
const detpx = document.getElementById('detpx');
const txtx = document.getElementById('txtx');

     let rex = new webkitSpeechRecognition();
      rex.lang = "es-ES";
      rex.continuous = true;
      rex.interimResults = false;

      rex.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtx.value += frase;
      }

      pxg.addEventListener('click', () => {
        rex.start();
      });

      detpx.addEventListener('click', () => {
        rex.abort();
      });

const btnPlayText6 = document.getElementById('play6');

btnPlayText6.addEventListener('click', () => {
        leerTexto(txtx.value);
});

function leerTexto(txtx){
    const speech6 = new SpeechSynthesisUtterance();
    speech6.text= txtx;
    speech6.volume=1;
    speech6.rate=1;
    speech6.pitch=0;
    window.speechSynthesis.speak(speech6);
}
</script>
</div>
</div>
</div>

<div class="row">
    <div class=" col-6"><STRONG>Diagnóstico: </STRONG><button type="button" class="btn btn-success btn-sm" id="play7"><i class="fas fa-play"></button></i>
     <div class="form-group">
        <select name="diagprob_i" class="form-control" data-live-search="true" id="mibuscador9" style="width : 100%; heigth : 100%" required="">
            <option value="<?php echo $f5['diagprob_i'] ?>"><?php echo $f5['diagprob_i'] ?></option>
            <option value="" disabled>Seleccionar otro diagnóstico</option>
<?php

include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_diag ORDER by id_cie10";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['diagnostico'] . "'>" . $row['id_cie10'] .'- '. $row['diagnostico'] . "</option>";
}
 ?></select>
 <script type="text/javascript">

const mibuscador9 = document.getElementById('mibuscador9');

const btnPlayText7 = document.getElementById('play7');

btnPlayText7.addEventListener('click', () => {
        leerTexto(mibuscador9.value);
});

function leerTexto(mibuscador9){
    const speech7 = new SpeechSynthesisUtterance();
    speech7.text= mibuscador9;
    speech7.volume=1;
    speech7.rate=1;
    speech7.pitch=0;
    window.speechSynthesis.speak(speech7);
}
</script>
</div>
</div>
<div class="col-6">
<strong>Describir: </strong><button type="button" class="btn btn-danger btn-sm" id="describirdg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopdescri"><i class="fas fa-microphone-slash"></button></i> <button type="button" class="btn btn-success btn-sm" id="btnhablar"><i class="fas fa-play"></button></i>
<textarea class="form-control" name="des_diag" id="desgiag"><?php echo $f5['des_diag'] ?></textarea>
<script type="text/javascript">
const describirdg = document.getElementById('describirdg');
const stopdescri = document.getElementById('stopdescri');
const desgiag = document.getElementById('desgiag');

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

const btnplay = document.getElementById('btnhablar');

btnplay.addEventListener('click', () => {
        leerTexto(desgiag.value);
});

function leerTexto(desgiag){
    const speech11 = new SpeechSynthesisUtterance();
    speech11.text= desgiag;
    speech11.volume=1;
    speech11.rate=1;
    speech11.pitch=0;
    window.speechSynthesis.speak(speech11);
}

    
</script>
</div>
</div>

<div class="row">
<div class=" col-8">
<STRONG>Guía de práctica clínica:</STRONG>


<button type="button" class="btn btn-success btn-sm" id="play8"><i class="fas fa-play"></button></i>

<div class="form-group">
<select name="guia" class="form-control" data-live-search="true" id="vozguia"style="width : 100%; heigth : 100%">
            <option value="<?php echo $f5['guia']; ?>"><?php echo $f5['guia'];?></option>

<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM gpclinica ORDER by id_gpc";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){



echo "<option value='" . $row['gpc'] . "'>" . $row['cve_gpc'] . "- " .$row['gpc']."</option>";
}
 ?></select>

<script type="text/javascript">

const vozguia = document.getElementById('vozguia');

const btnp8 = document.getElementById('play8');

btnp8.addEventListener('click', () => {
        leerTexto(vozguia.value);
});

function leerTexto(vozguia){
    const speech228 = new SpeechSynthesisUtterance();
    speech228.text= vozguia;
    speech228.volume=1;
    speech228.rate=1;
    speech228.pitch=0;
    window.speechSynthesis.speak(speech228);
}
</script>
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

<div class="row">
<div class="col-3">
<center><strong><label for="edosalud"><font size="4"color="#2b2d7f"><button type="button" class="btn btn-success btn-sm" id="play10"><i class="fas fa-play"></button></i>
 Estado de salud:</font></label></strong></center>
</div>
<div class=" col-5">
<select class="form-control" aria-label="edosalud" name="edosalud" id="edosalud">
 
  <option value="<?php echo $f5['edosalud'] ?>"><?php echo $f5['edosalud']?></option>
  <option value="Estable">Estable</option>
  <option value="Delicado">Delicado</option>
  <option value="Grave">Grave</option>
  <option value="Alta médica">Alta médica</option>
</select>
</div>
</div>
<script type="text/javascript">
const edosalud = document.getElementById('edosalud');
const btnPlayTex10 = document.getElementById('play10');

btnPlayTex10.addEventListener('click', () => {
        leerTexto(edosalud.value);
});

function leerTexto(edosalud){
    const speech = new SpeechSynthesisUtterance();
    speech.text= edosalud;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<?php } ?>
            <?php
            $usuario = $_SESSION['login'];
            ?>
            <hr>
            <div class="container">
                <div class="row">
                    <div class="col align-self-start">
                    </div>
                    <button type="submit" name="guardar" class="btn btn-primary">Firmar e imprimir</button> &nbsp;
                    <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
                    <div class="col align-self-end">
                    </div>
                </div>
            </div>
            <br>
            <br>
        </form>
 <?php 
  if (isset($_POST['guardar'])) {

        $problema    = mysqli_real_escape_string($conexion, (strip_tags($_POST["problema"], ENT_QUOTES)));
        $subjetivo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["subjetivo"], ENT_QUOTES)));
        $objetivo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["objetivo"], ENT_QUOTES)));
        $analisis    =mysqli_real_escape_string($conexion, (strip_tags($_POST["analisis"], ENT_QUOTES)));
        $plan    = mysqli_real_escape_string($conexion, (strip_tags($_POST["plan"], ENT_QUOTES)));
   $px    = mysqli_real_escape_string($conexion, (strip_tags($_POST["px"], ENT_QUOTES)));
   $guia = mysqli_real_escape_string($conexion, (strip_tags($_POST['guia'], ENT_QUOTES)));
   $edosalud = mysqli_real_escape_string($conexion, (strip_tags($_POST['edosalud'], ENT_QUOTES)));
   $diagprob_i = mysqli_real_escape_string($conexion, (strip_tags($_POST['diagprob_i'], ENT_QUOTES)));
 $servi = mysqli_real_escape_string($conexion, (strip_tags($_POST['servi'], ENT_QUOTES)));
$des_diag = mysqli_real_escape_string($conexion, (strip_tags($_POST['des_diag'], ENT_QUOTES)));


$fecha_actual = date("Y-m-d H:i:s");
$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];
$resultado=$conexion->query("SELECT * from reg_usuarios WHERE id_usua= $id_usua") or die($conexion->error);
    while ($ROW = mysqli_fetch_array($resultado)) {
 $nombre=$ROW['nombre'];
 $papell=$ROW['papell'];
 $sapell=$ROW['sapell'];
}



$nombre_medico=$nombre.' '.$papell.' '.$sapell;

$hora_ord = date("H:i:s");
$insertar = mysqli_query($conexion, 'INSERT INTO dat_nevol(fecha_nu,id_atencion,problema,subjetivo,objetivo,analisis,plan,px,guia,edosalud,id_usua,diagprob_i,servi,des_diag) values ("' . $fecha_actual . '",' . $id_atencion . ',"' . $problema . '","' . $subjetivo . '","' . $objetivo . '","' . $analisis . '","' . $plan . '","' . $px . '","' . $guia . '","' . $edosalud . '",' . $id_usua . ',"' . $diagprob_i . '","' . $servi . '","' . $des_diag . '")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


    $select="SELECT * FROM dat_nevol order by id_ne DESC LIMIT 1";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $id_ne=$row['id_ne'];
    }

    $select="SELECT * FROM dat_ingreso where id_atencion=$id_atencion";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $id_exp=$row['Id_exp'];
   
    $ingresar=mysqli_query($conexion,'UPDATE dat_ingreso SET edo_salud = "'.$edosalud.'" WHERE dat_ingreso.id_atencion = "'.$id_atencion.'" ');
     }

echo '<script >window.open("../pdf/pdf_not_evo.php?id_ne='.$id_ne.'&id_exp='.$id_exp.'&id_atencion='.$id_atencion.'", "RECETA AMBULATORIA", "width=1000, height=1000")</script>'.
 '<script type="text/javascript">window.location.href ="../hospitalizacion/vista_pac_hosp.php" ;</script>';
      //  echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> DATO INSERTADO CORRECTAMENTE...</p>";
      //  echo '<script type="text/javascript">window.location ="nota_de_evolucion.php"</script>';
      }
  ?>
    </div>

</div>

<?php }
?>
<?php 
}else{
                        
  ?>
<!--CONTENIDO SI NO EXISTE ORDEN MEDICA HACER UNA NUEVA POR PRIMER VEZ -->
 <form action="" method="POST">
<!--<strong>TIPO DE NOTA DE EVOLUCIÓN</strong>
<input type="text" name="" class="form-control"  name="tip_ev"><br>-->
<div class=" col">
    <strong> <font size="4" color="#2b2d7f"><button type="button" class="btn btn-success btn-sm" id="play9"><i class="fas fa-play"></button></i> Especialidad:</font></strong>
    
     <div class="form-group">
        <select name="servi" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%" required="">
            <option value="">Seleccionar</option>
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
    <script type="text/javascript">
const mibuscador = document.getElementById('mibuscador');
const btnPlayTex9 = document.getElementById('play9');

btnPlayTex9.addEventListener('click', () => {
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
  <div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#2b2d7f ">P</font></label></strong></center>
    </div>
    <div class=" col-10">
     <strong> <font size="4" color="#2b2d7f"> Paciente:</font></strong>
     <strong><font color="black">Describir al paciente (Edad, Género, Dianósticos y tratamientos previos)</font></strong>
    <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="dgdtg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="tratstoppp"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play"><i class="fas fa-play"></button></i>
</div>

     <div class="form-group">
<textarea class="form-control" id="txt2p" name="problema" rows="3" required=""></textarea>
<script type="text/javascript">
const dgdtg = document.getElementById('dgdtg');
const tratstoppp = document.getElementById('tratstoppp');
const txt2p = document.getElementById('txt2p');

const btnPlayText = document.getElementById('play');
btnPlayText.addEventListener('click', () => {
        leerTexto(txt2p.value);
});

function leerTexto(txt2p){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txt2p;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let r2p = new webkitSpeechRecognition();
      r2p.lang = "es-ES";
      r2p.continuous = true;
      r2p.interimResults = false;

      r2p.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txt2p.value += frase;
      }

      dgdtg.addEventListener('click', () => {
        r2p.start();
      });

      tratstoppp.addEventListener('click', () => {
        r2p.abort();
      });
</script>
  </div>
    </div>
</div>

 <div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#2b2d7f ">S</font></label></strong></center>
    </div>
    <div class=" col-10">
      <strong> <font size="4" color="#2b2d7f">Subjetivo:</font></strong>
      <strong><font color="black">Describir la sintomatología del paciente, hábitos, a qué atribuye el padecimiento actual, etc.  </font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="subjetivograbar"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="ivosubsti"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla1"><i class="fas fa-play"></button></i>
</div>
     
     <div class="form-group">           
    <textarea class="form-control" id="txt2su" rows="3" name="subjetivo" class="form-control" id="txt2su" rows="3" name="subjetivo" required=""></textarea>
    <script type="text/javascript">
const subjetivograbar = document.getElementById('subjetivograbar');
const ivosubsti = document.getElementById('ivosubsti');
const txt2su = document.getElementById('txt2su');

const btnPlayTex1 = document.getElementById('pla1');
btnPlayTex1.addEventListener('click', () => {
        leerTexto(txt2su.value);
});

function leerTexto(txt2su){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txt2su;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let r2su = new webkitSpeechRecognition();
      r2su.lang = "es-ES";
      r2su.continuous = true;
      r2su.interimResults = false;

      r2su.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txt2su.value += frase;
      }

      subjetivograbar.addEventListener('click', () => {
        r2su.start();
      });

      ivosubsti.addEventListener('click', () => {
        r2su.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f ">O</font></label></strong></center>
    </div>
    <div class=" col-10">
      <strong> <font size="4" color="#2b2d7f">Objetivo:</font></strong>
<strong><font color="black">Describir la exploración física</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="objetivogr"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="expobjetivostop"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla2"><i class="fas fa-play"></button></i>
</div>
      
     <div class="form-group">
    <textarea class="form-control" id="txt2on" rows="3" name="objetivo" required=""></textarea>
 <script type="text/javascript">
const objetivogr = document.getElementById('objetivogr');
const expobjetivostop = document.getElementById('expobjetivostop');
const txt2on = document.getElementById('txt2on');

const btnPlayTex2 = document.getElementById('pla2');
btnPlayTex2.addEventListener('click', () => {
        leerTexto(txt2on.value);
});

function leerTexto(txt2on){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txt2on;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 

     let rob2 = new webkitSpeechRecognition();
      rob2.lang = "es-ES";
      rob2.continuous = true;
      rob2.interimResults = false;

      rob2.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txt2on.value += frase;
      }

      objetivogr.addEventListener('click', () => {
        rob2.start();
      });

      expobjetivostop.addEventListener('click', () => {
        rob2.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f ">A</font></label></strong></center>
    </div>
    <div class=" col-10">
        <strong> <font size="4" color="#2b2d7f">Análisis:</font></strong>
        <strong><font color="black">Los diagnósticos probables y definitivos y los argumentos, correlación de los estudios de laboratorio y gabinete con el padecimiento actual</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="analisisgr"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="actualpgstop"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla3"><i class="fas fa-play"></button></i>
</div>

     <div class="form-group">
    <textarea class="form-control" id="txtaldpy" rows="3" name="analisis" required=""></textarea>
<script type="text/javascript">
const analisisgr = document.getElementById('analisisgr');
const actualpgstop = document.getElementById('actualpgstop');
const txtaldpy = document.getElementById('txtaldpy');

const btnPlayTex3 = document.getElementById('pla3');
btnPlayTex3.addEventListener('click', () => {
        leerTexto(txtaldpy.value);
});

function leerTexto(txtaldpy){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtaldpy;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let rald = new webkitSpeechRecognition();
      rald.lang = "es-ES";
      rald.continuous = true;
      rald.interimResults = false;

      rald.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtaldpy.value += frase;
      }

      analisisgr.addEventListener('click', () => {
        rald.start();
      });

      actualpgstop.addEventListener('click', () => {
        rald.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f ">P</font></label></strong></center>
    </div>
    <div class=" col-10">
<strong> <font size="4" color="#2b2d7f">Plan:</font></strong>
<strong><font color="black">Describir tratamiento y recomendaciones indicadas al paciente, anotar los medicamentos con sus dosis de manera detallada</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="plandtr"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="ripastop"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i>
</div>
     
     <div class="form-group">
<textarea class="form-control" id="txtpiepe" rows="3" name="plan" required=""></textarea>
<script type="text/javascript">
const plandtr = document.getElementById('plandtr');
const ripastop = document.getElementById('ripastop');
const txtpiepe = document.getElementById('txtpiepe');

const btnPlayTex4 = document.getElementById('pla4');
btnPlayTex4.addEventListener('click', () => {
        leerTexto(txtpiepe.value);
});

function leerTexto(txtpiepe){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtpiepe;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let rpdtyriap = new webkitSpeechRecognition();
      rpdtyriap.lang = "es-ES";
      rpdtyriap.continuous = true;
      rpdtyriap.interimResults = false;

      rpdtyriap.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtpiepe.value += frase;
      }

      plandtr.addEventListener('click', () => {
        rpdtyriap.start();
      });

      ripastop.addEventListener('click', () => {
        rpdtyriap.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f ">PX</font></label></strong></center>
    </div>
    <div class=" col-10">
        <strong> <font size="4" color="#2b2d7f">Pronóstico:</font></strong>
        <strong><font color="black">Para la vida y para la función</font></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="pplvy"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="osprofunstp"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla5"><i class="fas fa-play"></button></i>
</div>
      
     <div class="form-group">
    <textarea class="form-control" id="txtno2vida" rows="3" name="px" required=""></textarea>
<script type="text/javascript">
const pplvy = document.getElementById('pplvy');
const osprofunstp = document.getElementById('osprofunstp');
const txtno2vida = document.getElementById('txtno2vida');

const btnPlayTex5 = document.getElementById('pla5');
btnPlayTex5.addEventListener('click', () => {
        leerTexto(txtno2vida.value);
});

function leerTexto(txtno2vida){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtno2vida;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let pronrevida = new webkitSpeechRecognition();
      pronrevida.lang = "es-ES";
      pronrevida.continuous = true;
      pronrevida.interimResults = false;

      pronrevida.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtno2vida.value += frase;
      }

      pplvy.addEventListener('click', () => {
        pronrevida.start();
      });

      osprofunstp.addEventListener('click', () => {
        pronrevida.abort();
      });
</script>
  </div>
    </div>
</div>


<div class="row">

    <div class=" col-6"><STRONG><button type="button" class="btn btn-success btn-sm" id="pla6"><i class="fas fa-play"></button></i> Diagnóstico:</STRONG>
     <div class="form-group">
        <select name="diagprob_i" class="form-control" data-live-search="true" id="mibuscador8" style="width : 100%; heigth : 100%" required="">
          
            <option value="">Seleccionar</option>
<?php

include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_diag ORDER by id_cie10";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['diagnostico'] . "'>" . $row['id_cie10'] .'- '. $row['diagnostico'] . "</option>";
}
 ?></select>
 
  </div>
    </div>
   
  

  
  
<script type="text/javascript">
const mibuscador8 = document.getElementById('mibuscador8');
const btnPlayTex6 = document.getElementById('pla6');
btnPlayTex6.addEventListener('click', () => {
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
    <div class="col-6">
<strong>Describir: </strong><button type="button" class="btn btn-danger btn-sm" id="desc2d"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detdes2"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla7"><i class="fas fa-play"></button></i>
<textarea class="form-control" name="des_diag" id="destexte2"></textarea>
<script type="text/javascript">
const desc2d = document.getElementById('desc2d');
const detdes2 = document.getElementById('detdes2');
const destexte2 = document.getElementById('destexte2');

const btnPlayTex7 = document.getElementById('pla7');
btnPlayTex7.addEventListener('click', () => {
        leerTexto(destexte2.value);
});

function leerTexto(destexte2){
    const speech = new SpeechSynthesisUtterance();
    speech.text= destexte2;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let re2descri = new webkitSpeechRecognition();
      re2descri.lang = "es-ES";
      re2descri.continuous = true;
      re2descri.interimResults = false;

      re2descri.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        destexte2.value += frase;
      }

      desc2d.addEventListener('click', () => {
        re2descri.start();
      });

      detdes2.addEventListener('click', () => {
        re2descri.abort();
      });
</script>
</div>
</div>
<div class="row">
<div class=" col-sm-9">
<strong><button type="button" class="btn btn-success btn-sm" id="pla8"><i class="fas fa-play"></button></i> Guía de práctica clínica:</strong>

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
const btnPlayTex8 = document.getElementById('pla8');
btnPlayTex8.addEventListener('click', () => {
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
<div class="row">
<div class="col-3">
<center><strong><label for="edosalud"><font size="4"color="#2b2d7f "><button type="button" class="btn btn-success btn-sm" id="pla9"><i class="fas fa-play"></button></i> Estado de Salud:</font></label></strong></center>
    </div>
<div class=" col-5">
<select class="form-control" aria-label="edosalud" name="edosalud" required="" id="edosalud34">
  <option value="">Seleccionar</option>
  <option value="Estable">Estable</option>
  <option value="Delicado">Delicado</option>
  <option value="Grave">Grave</option>
  <option value="Alta médica">Alta médica</option>
</select>
</div>
</div>
<script type="text/javascript">
const edosalud34 = document.getElementById('edosalud34');
const btnPlayTex10 = document.getElementById('pla9');
btnPlayTex10.addEventListener('click', () => {
        leerTexto(edosalud34.value);
});

function leerTexto(edosalud34){
    const speech = new SpeechSynthesisUtterance();
    speech.text= edosalud34;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
            <hr>
            <div class="container">
                <div class="row">
                    <div class="col align-self-start">
                    </div>
                    <button type="submit" name="guardar" class="btn btn-primary">Firmar e imprimir</button> &nbsp;
                    <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
                    <div class="col align-self-end">
                    </div>
                </div>
            </div>


            <br>
            <br>
        </form>

 <?php 
  if (isset($_POST['guardar'])) {
 $problema    = mysqli_real_escape_string($conexion, (strip_tags($_POST["problema"], ENT_QUOTES)));
        $subjetivo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["subjetivo"], ENT_QUOTES)));
        $objetivo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["objetivo"], ENT_QUOTES)));
        $analisis    =mysqli_real_escape_string($conexion, (strip_tags($_POST["analisis"], ENT_QUOTES)));
        $plan    = mysqli_real_escape_string($conexion, (strip_tags($_POST["plan"], ENT_QUOTES)));
   $px    = mysqli_real_escape_string($conexion, (strip_tags($_POST["px"], ENT_QUOTES)));
   $guia = mysqli_real_escape_string($conexion, (strip_tags($_POST['guia'], ENT_QUOTES)));
   $edosalud = mysqli_real_escape_string($conexion, (strip_tags($_POST['edosalud'], ENT_QUOTES)));
   $diagprob_i = mysqli_real_escape_string($conexion, (strip_tags($_POST['diagprob_i'], ENT_QUOTES)));

    $servi = mysqli_real_escape_string($conexion, (strip_tags($_POST['servi'], ENT_QUOTES)));
      $des_diag = mysqli_real_escape_string($conexion, (strip_tags($_POST['des_diag'], ENT_QUOTES))); 



$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$fecha_actual = date("Y-m-d H:i:s");
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];
    $resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_sig DESC LIMIT 1") or die($conexion->error);
    while ($f5 = mysqli_fetch_array($resultado5)) {
 $atencion=$f5['id_sig'];
}
if ($atencion == NULL) {

$p_sistol = ($_POST['p_sistol']);
    $p_diastol = ($_POST['p_diastol']);
    $fcard = ($_POST['fcard']);
    $fresp = ($_POST['fresp']);
    $temper = ($_POST['temper']);
    $satoxi = ($_POST['satoxi']);
    

$ingresar = mysqli_query($conexion, 'INSERT INTO signos_vitales (id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi) values (' . $id_atencion . ' , ' . $id_usua . ' ," ' . $fecha_actual . '", " ' . $p_sistol . '" , "' . $p_diastol . '" , "' .$fcard . '" , "' . $fresp . '" , "' . $temper . ' ", "' . $satoxi . ' ") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

}


$resultado=$conexion->query("SELECT * from reg_usuarios WHERE id_usua= $id_usua") or die($conexion->error);
    while ($ROW = mysqli_fetch_array($resultado)) {
 $nombre=$ROW['nombre'];
 $papell=$ROW['papell'];
 $sapell=$ROW['sapell'];
}

$nombre_medico=$nombre.' '.$papell.' '.$sapell;


$insertar = mysqli_query($conexion, 'INSERT INTO dat_nevol(fecha_nu,id_atencion,problema,subjetivo,objetivo,analisis,plan,px,guia,edosalud,id_usua,diagprob_i,servi,des_diag) values ("' . $fecha_actual . '",' . $id_atencion . ',"' . $problema . '","' . $subjetivo . '","' . $objetivo . '","' . $analisis . '","' . $plan . '","' . $px . '","' . $guia . '","' . $edosalud . '",' . $id_usua . ',"' . $diagprob_i . '","'.$servi.'","'.$des_diag.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


    $select="SELECT * FROM dat_nevol order by id_ne DESC LIMIT 1";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $id_ne=$row['id_ne'];
    }

    $select="SELECT * FROM dat_ingreso where id_atencion=$id_atencion";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $id_exp=$row['Id_exp'];

    $ingresar=mysqli_query($conexion,'UPDATE dat_ingreso SET edo_salud = "'.$edosalud.'" WHERE dat_ingreso.id_atencion = "'.$id_atencion.'" ');
     
    }

echo '<script >window.open("../pdf/pdf_not_evo.php?id_ne='.$id_ne.'&id_exp='.$id_exp.'&id_atencion='.$id_atencion.'", "RECETA AMBULATORIA", "width=1000, height=1000")</script>'.
 '<script type="text/javascript">window.location.href ="../hospitalizacion/vista_pac_hosp.php" ;</script>';
 //       echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> DATO INSERTADO CORRECTAMENTE...</p>";
   //     echo '<script type="text/javascript">window.location ="nota_de_evolucion.php"</script>';
      }
  ?>



  <?php } ?>
<!--termino ordenes med validacion si existe-->
   
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
        $('#mibuscador9').select2();
    });
    $(document).ready(function () {
        $('#mibuscador8').select2();
    });
    $(document).ready(function () {
        $('#mibuscador11').select2();
    });
    $(document).ready(function () {
        $('#vozguia').select2();
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