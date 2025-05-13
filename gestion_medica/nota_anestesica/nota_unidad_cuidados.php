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
<strong><center>NOTA DE ANESTESIOLOGÍA</center></strong>
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

<nav>
  <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
   
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><h5>NOTA</h5></a>
     <a class="nav-item nav-link" id="nav-signos  -tab" data-toggle="tab" href="#nav-signos " role="tab" aria-controls="nav-signos " aria-selected="false"><h5>SIGNOS VITALES</h5></a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><h5>AGENTES</h5></a>
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><h5>INGRESOS</h5></a>
    <a class="nav-item nav-link" id="nav-egresos-tab" data-toggle="tab" href="#nav-egresos" role="tab" aria-controls="nav-egresos" aria-selected="false"><h5>EGRESOS</h5></a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">


  


  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <form action="insertar_unidcuid.php" method="POST">
<hr>
<div class="container">
  <div class="row">
    <div class="col-sm">
        <strong>
        Principio anestesia:</strong>
      <input type="time" name="p_an" class="form-control">
    </div>
    <div class="col-sm"><strong>Principio operación</strong>
     <input type="time" name="p_op" class="form-control">
    </div>
    <div class="col-sm"><strong>Fin anestésia</strong>
     <input type="time" name="fin_an" class="form-control">
    </div>
  </div>
</div>

<p>

<div class="container">
<div class="row">
  <div class="col-sm-6">
     <strong><button type="button" class="btn btn-success btn-sm" id="pla1"><i class="fas fa-play"></button></i> Cirujano:</strong><input type="text" name="cirujanoa" id="t1" class="form-control"> 
  </div>
<script type="text/javascript">
const t1 = document.getElementById('t1');
const btnPlayTex1 = document.getElementById('pla1');
btnPlayTex1.addEventListener('click', () => {
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
  <div class="col-sm">
  <strong><button type="button" class="btn btn-success btn-sm" id="pla2"><i class="fas fa-play"></button></i> Anestesiólogo:</strong><input type="text" name="anestesiologoa" id="t2" class="form-control"> 
  </div>
</div>
</div>
<script type="text/javascript">
const t2 = document.getElementById('t2');
const btnPlayTex2 = document.getElementById('pla2');
btnPlayTex2.addEventListener('click', () => {
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
<hr>
 
<div class="container">
  <div class="row">
    <div class="col-sm">
     <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <strong><center> INDUCCIÓN ANESTÉSICA</center></strong><p>
</div>
    </div>
    
    <div class="col-sm">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <strong><center> MASCARILLA</center></strong><p>
</div>
    </div>
  </div>
</div>
<center>
<div class="container">
<div class="row">
  <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="ind" id="Intramuscular" value="intramuscular" required>
  <label class="form-check-label" for="Intramuscular">
    <strong>Intramuscular</strong>
  </label>
</div>
  </div>
  <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="ind" id="Intravenosa" value="intravenosa">
  <label class="form-check-label" for="Intravenosa">
    <strong>Intravenosa</strong>
  </label>
</div>
  </div>
  <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="ind" id="Inhalatoria" value="inhalatoria">
  <label class="form-check-label" for="Inhalatoria">
    <strong>Inhalatoria</strong>
  </label>
</div>
  </div>
  <div class="col-sm-2">
  </div>
  <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="mascarilla" id="sim" value="si">
  <label class="form-check-label" for="sim">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="mascarilla" id="nom" value="no" checked>
  <label class="form-check-label" for="nom">
    <strong>No</strong>
  </label>
</div>
  </div>
</div>
</div>
</center>
<hr>

<div class="container">
  <div class="row">
    <div class="col-sm">
     <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <strong><center><button type="button" class="btn btn-success btn-sm" id="pla3"><i class="fas fa-play"></button></i> CÁNULA DE GÚDEL NO.</center></strong><p>
</div>
    </div>
    <div class="col-sm">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <strong><center> ANESTESIA GENERAL</center></strong><p>
</div>
    </div>
  </div>
</div>
<center>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <input type="text" name="canula" class="form-control" id="t3">
    </div>
<script type="text/javascript">
const t3 = document.getElementById('t3');
const btnPlayTex3 = document.getElementById('pla3');
btnPlayTex3.addEventListener('click', () => {
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
    <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="anest_general" id="Intramusculara" value="intramuscular" required>
  <label class="form-check-label" for="Intramusculara">
    <strong>Intramuscular</strong>
  </label>
</div>
  </div>
<div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="anest_general" id="venoa" name="intravenosa">
  <label class="form-check-label" for="venoa">
    <strong>Intravenosa</strong>
  </label>
</div>
  </div>
  <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="anest_general" id="inha" name="inhalatoria">
  <label class="form-check-label" for="inha">
    <strong>Inhalatoria</strong>
  </label>
</div>
  </div>
  </div>
</div>
</center>
<hr>
<div class="container">
  <div class="row">
    <div class="col-sm">
     <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 18px;">
  <strong><center><button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i> BALANCEADA</center></strong><p>
</div>
    </div>
    <!--<div class="col-sm">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 18px;">
  <strong><center><button type="button" class="btn btn-success btn-sm" id="pla5"><i class="fas fa-play"></button></i> AGENTES INHALADOS</center></strong><p>
</div>
    </div>-->
    <div class="col-sm">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 13.5px;">
  <strong><center><button type="button" class="btn btn-success btn-sm" id="pla6"><i class="fas fa-play"></button></i> DESFLUORANTE SEVOFLUORANE</center></strong><p>
</div>
    </div>
    <div class="col-sm">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 18px;">
  <strong><center><button type="button" class="btn btn-success btn-sm" id="pla7"><i class="fas fa-play"></button></i> INSOFLUORANE</center></strong><p>
</div>
    </div>
  </div>
</div>
<center>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <input type="text" name="balanceada" id="t4" class="form-control">
    </div>
<script type="text/javascript">
const t4 = document.getElementById('t4');
const btnPlayTex4 = document.getElementById('pla4');
btnPlayTex4.addEventListener('click', () => {
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
   <!-- <div class="col-sm">
    <input type="text" name="agentes_in" class="form-control" id="t5">
  </div>-->
<script type="text/javascript">
const t5 = document.getElementById('t5');
const btnPlayTex5 = document.getElementById('pla5');
btnPlayTex5.addEventListener('click', () => {
        leerTexto(t5.value);
});

function leerTexto(t5){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t5;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<div class="col-sm">
     <input type="text" name="desfluorante" class="form-control" id="t6">
  </div>
<script type="text/javascript">
const t6 = document.getElementById('t6');
const btnPlayTex6 = document.getElementById('pla6');
btnPlayTex6.addEventListener('click', () => {
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
  <div class="col-sm">
  <input type="text" name="insofluorane" class="form-control" id="t7">
  </div>
  </div>
</div>
</center>
<script type="text/javascript">
const t7 = document.getElementById('t7');
const btnPlayTex7 = document.getElementById('pla7');
btnPlayTex7.addEventListener('click', () => {
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
</script>
<hr>
<div class="container">
  <div class="row">
    <div class="col-sm-3">
     <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <strong><center>INTUBACIÓN</center></strong><p>
</div>
    </div>
    <div class="col-sm">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <strong><center><button type="button" class="btn btn-success btn-sm" id="pla8"><i class="fas fa-play"></button></i> TUBO NO.</center></strong><p>
</div>
    </div>
    <div class="col-sm">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <strong><center> HOJA</center></strong><p>
</div>
    </div>
    
  </div>
</div>

<center>
<div class="container">
  <div class="row">
     <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="intubacion" id="nasali" name="nasal" required>
  <label class="form-check-label" for="nasali">
    <strong>Nasal</strong>
  </label>
</div>
  </div>
   <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="intubacion" id="orali" value="oral">
  <label class="form-check-label" for="orali">
    <strong>Oral</strong>
  </label>
</div>
  </div>
    <div class="col-sm-5">
      <input type="text" name="tubglobal" class="form-control" id="t8">
    </div>
<script type="text/javascript">
const t8 = document.getElementById('t8');
const btnPlayTex8 = document.getElementById('pla8');
btnPlayTex8.addEventListener('click', () => {
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
   
 

<script type="text/javascript">
const t9 = document.getElementById('t9');
const btnPlayTex9 = document.getElementById('pla9');
btnPlayTex9.addEventListener('click', () => {
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
</script>
  <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="checkbox" name="hojar" id="recta" value="recta">
  <label class="form-check-label" for="recta">
    <strong>Recta</strong>
  </label>
</div>
  </div>
  <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="checkbox" name="hojar" id="curva" value="curva">
  <label class="form-check-label" for="curva">
    <strong>Curva</strong>
  </label>
</div>
  </div>
  </div>
</div>
</center>
<hr>
<div class="container">
  <div class="row">
    <div class="col-sm-5">
     <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <strong><center><button type="button" class="btn btn-success btn-sm" id="pla10"><i class="fas fa-play"></button></i> NO. DE INTENTOS</center></strong><p>
</div>
    </div>
    <div class="col-sm">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <strong><center><button type="button" class="btn btn-success btn-sm" id="pla11"><i class="fas fa-play"></button></i> INCIDENTES</center></strong><p>
</div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-2">
    <input type="text" name="noit" class="form-control" id="t10">
  </div>
<script type="text/javascript">
const t10 = document.getElementById('t10');
const btnPlayTex10 = document.getElementById('pla10');
btnPlayTex10.addEventListener('click', () => {
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
  <strong>Guía:</strong>
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="guiai" id="noisi" value="si">
  <label class="form-check-label" for="noisi">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="guiai" id="nointer" value="no" checked>
  <label class="form-check-label" for="nointer">
    <strong>No</strong>
  </label>
</div>
  </div>
   <div class="col-sm-7">
      <input type="text" name="incdentesf" class="form-control" id="t11">
    </div>
<script type="text/javascript">
const t11 = document.getElementById('t11');
const btnPlayTex11 = document.getElementById('pla11');
btnPlayTex11.addEventListener('click', () => {
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
</script>
  </div>
</div>
<hr>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
     <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <strong><center>CIRCUITO ANESTÉSICO</center></strong><p>
</div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm">
    <strong><button type="button" class="btn btn-success btn-sm" id="pla12"><i class="fas fa-play"></button></i> Rehinalación tipo</strong>
    <input type="text" name="reintipo" class="form-control" id="t12">
    </div>
<script type="text/javascript">
const t12 = document.getElementById('t12');
const btnPlayTex12 = document.getElementById('pla12');
btnPlayTex12.addEventListener('click', () => {
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
    <div class="col-sm">
    <strong><button type="button" class="btn btn-success btn-sm" id="pla13"><i class="fas fa-play"></button></i> No. Rehinalación circuito</strong>
    <input type="text" name="noreinc" id="t13" class="form-control">
    </div>
  <script type="text/javascript">
const t13 = document.getElementById('t13');
const btnPlayTex13 = document.getElementById('pla13');
btnPlayTex13.addEventListener('click', () => {
        leerTexto(t13.value);
});

function leerTexto(t13){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t13;
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
    <div class="col-sm">
    <div class="form-check">
  <input class="form-check-input" type="checkbox" value="cerrado" id="cerrado" name="cerrado">
  <label class="form-check-label" for="cerrado">
    Cerrado 
  </label>
</div>
    </div>
    <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="semicerrado" id="Semicerrado" name="semicerrado">
  <label class="form-check-label" for="Semicerrado">
    Semicerrado
  </label>
</div>
    </div>
    <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="ventilacion" id="Ventilacion" name="ventilacion">
  <label class="form-check-label" for="Ventilacion">
    Ventilación
  </label>
</div>
    </div>
    <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="manual" id="Manual" name="manual">
  <label class="form-check-label" for="Manual">
    Manual 
  </label>
</div>
    </div>
    <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="mecanica" id="Mecanica" name="mecanica">
  <label class="form-check-label" for="Mecanica">
    Mecánica 
  </label>
</div>
    </div>
    <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="espontanea" id="Espontanea" name="espontanea">
  <label class="form-check-label" for="Espontanea">
    Espontánea
  </label>
</div>
    </div>
    <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="asistida" id="Asistida" name="asistida">
  <label class="form-check-label" for="Asistida">
    Asistida 
  </label>
</div>
    </div>
    <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="controlada" id="Controlada" name="controlada">
  <label class="form-check-label" for="Controlada">
    Controlada 
  </label>
</div>
    </div>
  
  </div>
</div>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm">
    <strong><button type="button" class="btn btn-success btn-sm" id="pla14"><i class="fas fa-play"></button></i> VT</strong>
      <input type="text" name="vt" class="form-control" id="t14">
    </div>
<script type="text/javascript">
const t14 = document.getElementById('t14');
const btnPlayTex14 = document.getElementById('pla14');
btnPlayTex14.addEventListener('click', () => {
        leerTexto(t14.value);
});

function leerTexto(t14){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t14;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm">
    <strong><button type="button" class="btn btn-success btn-sm" id="pla15"><i class="fas fa-play"></button></i> FR</strong>
      <input type="text" name="fr" class="form-control" id="t15">
    </div>
    <script type="text/javascript">
const t15 = document.getElementById('t15');
const btnPlayTex15 = document.getElementById('pla15');
btnPlayTex15.addEventListener('click', () => {
        leerTexto(t15.value);
});

function leerTexto(t15){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t15;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm">
    <strong><button type="button" class="btn btn-success btn-sm" id="pla16"><i class="fas fa-play"></button></i> PWA</strong>
      <input type="text" name="pwa" class="form-control" id="t16">
    </div>
<script type="text/javascript">
const t16 = document.getElementById('t16');
const btnPlayTex16 = document.getElementById('pla16');
btnPlayTex16.addEventListener('click', () => {
        leerTexto(t16.value);
});

function leerTexto(t16){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t16;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm">
    <strong><button type="button" class="btn btn-success btn-sm" id="pla17"><i class="fas fa-play"></button></i> Ventilador</strong>
      <input type="text" name="ventilador" class="form-control" id="t17">
    </div>
  </div>
</div>
<script type="text/javascript">
const t17 = document.getElementById('t17');
const btnPlayTex17 = document.getElementById('pla17');
btnPlayTex17.addEventListener('click', () => {
        leerTexto(t17.value);
});

function leerTexto(t17){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t17;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<p>
<div class="container">
  <div class="row">
     <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="bloqueo" id="Bloqueo" name="bloqueo">
  <label class="form-check-label" for="Bloqueo">
    Bloqueo 
  </label>
</div>
    </div>
     <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="sub" id="Sub" name="sub">
  <label class="form-check-label" for="Sub">
    Sub 
  </label>
</div>
    </div>
     <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="aracnoideo" id="Aracnoideo" name="aracnoideo">
  <label class="form-check-label" for="Aracnoideo">
    Aracnoideo 
  </label>
</div>
    </div>
      <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="peridual" id="Peridual" name="peridual">
  <label class="form-check-label" for="Peridual">
    Peridual 
  </label>
</div>
    </div>
      <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" value="mixto" id="Mixto" name="mixto">
  <label class="form-check-label" for="Mixto">
    Mixto 
  </label>
</div>
    </div>
  </div>
</div>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm-1">
  <strong>Catéter:</strong>
</div>
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="cateter" id="caudalc" value="caudal" required>
  <label class="form-check-label" for="caudalc">
    <strong>Caudal</strong>
  </label>
</div>
  </div>
  <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="cateter" id="cefalicoc" value="cefalico">
  <label class="form-check-label" for="cefalicoc">
    <strong>Cefálico</strong>
  </label>
</div>
  </div>
  <strong><button type="button" class="btn btn-success btn-sm" id="pla18"><i class="fas fa-play"></button></i> Aguja de Tuohy No.:</strong>
   <div class="col-sm-2">
      <input type="text" name="tuohy" id="t18" class="form-control">
    </div>
<script type="text/javascript">
const t18 = document.getElementById('t18');
const btnPlayTex18 = document.getElementById('pla18');
btnPlayTex18.addEventListener('click', () => {
        leerTexto(t18.value);
});

function leerTexto(t18){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t18;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <strong><button type="button" class="btn btn-success btn-sm" id="pla19"><i class="fas fa-play"></button></i> Raquia No.:</strong>
    <div class="col-sm-3">
      <input type="text" name="raquia" class="form-control" id="t19">
    </div>
  </div>
</div>
<script type="text/javascript">
const t19 = document.getElementById('t19');
const btnPlayTex19 = document.getElementById('pla19');
btnPlayTex19.addEventListener('click', () => {
        leerTexto(t19.value);
});

function leerTexto(t19){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t19;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<p>
<div class="container">
  <div class="row">
  <div class="col-sm-1">
 <!-- <strong><button type="button" class="btn btn-success btn-sm" id="pla20"><i class="fas fa-play"></button></i> Nivel:</strong>
</div>-->
<!--<div class="col-sm-1">
  <input type="text" name="nivel" class="form-control" id="t20">
</div>-->
<script type="text/javascript">
const t20 = document.getElementById('t20');
const btnPlayTex20 = document.getElementById('pla20');
btnPlayTex20.addEventListener('click', () => {
        leerTexto(t20.value);
});

function leerTexto(t20){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t20;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<strong>Dificil:</strong>
</div>
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="dificil" id="sidif" value="si">
  <label class="form-check-label" for="sidif">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="dificil" id="nodif" value="no" checked>
  <label class="form-check-label" for="nodif">
    <strong>No</strong>
  </label>
</div>
  </div>
  <strong><button type="button" class="btn btn-success btn-sm" id="pla21"><i class="fas fa-play"></button></i> No. de intentos:</strong>
   <div class="col-sm-4">
      <input type="text" name="segnointen" class="form-control" id="t21">
    </div>
<script type="text/javascript">
const t21 = document.getElementById('t21');
const btnPlayTex21 = document.getElementById('pla21');
btnPlayTex21.addEventListener('click', () => {
        leerTexto(t21.value);
});

function leerTexto(t21){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t21;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <strong><button type="button" class="btn btn-success btn-sm" id="pla22"><i class="fas fa-play"></button></i> Analgesia:</strong>
    <div class="col-sm-2">
      <select class="form-control" name="analgesia" id="t22">
        <option value="">Selecciona</option>
        <option value="buena">Buena</option>
        <option value="regular">Regular</option>
        <option value="mala">Mala</option>
      </select>
    </div>
  </div>
</div>
<script type="text/javascript">
const t22 = document.getElementById('t22');
const btnPlayTex22 = document.getElementById('pla22');
btnPlayTex22.addEventListener('click', () => {
        leerTexto(t22.value);
});

function leerTexto(t22){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t22;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm-2">
  <strong><button type="button" class="btn btn-success btn-sm" id="pla23"><i class="fas fa-play"></button></i> Altura:</strong>
</div>
<div class="col-sm-2">
  <input type="text" name="altura" class="form-control" id="t23">
</div>
<script type="text/javascript">
const t23 = document.getElementById('t23');
const btnPlayTex23 = document.getElementById('pla23');
btnPlayTex23.addEventListener('click', () => {
        leerTexto(t23.value);
});

function leerTexto(t23){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t23;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<strong><button type="button" class="btn btn-success btn-sm" id="pla24"><i class="fas fa-play"></button></i> Monitoreo:</strong>
  <div class="col-sm-1">
      <select name="monitor" class="form-control" id="t24">
          <option value="">Selecionar monitoreo</option>
           <option value="I">I</option>
            <option value="II">II</option>
      </select>
      
 
  </div>
<script type="text/javascript">
const t24 = document.getElementById('t24');
const btnPlayTex24 = document.getElementById('pla24');
btnPlayTex24.addEventListener('click', () => {
        leerTexto(t24.value);
});

function leerTexto(t24){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t24;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
  <strong><button type="button" class="btn btn-success btn-sm" id="pla25"><i class="fas fa-play"></button></i> Tipo I:</strong>
   <div class="col-sm-2">
      <input type="text" name="tipoi" class="form-control" id="t25">
    </div>
<script type="text/javascript">
const t25 = document.getElementById('t25');
const btnPlayTex25 = document.getElementById('pla25');
btnPlayTex25.addEventListener('click', () => {
        leerTexto(t25.value);
});

function leerTexto(t25){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t25;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
      <div class="col-sm">
         <strong>ECG:</strong>
      </div>
   
    <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="ecg" id="siecg" value="si">
  <label class="form-check-label" for="siecg">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="ecg" id="noecg" value="no" checked>
  <label class="form-check-label" for="noecg">
    <strong>No</strong>
  </label>
</div>
  </div>
  </div>
</div>
<p>
  <center>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="cap" id="capnomac" value="capnomac">
  <label class="form-check-label" for="capnomac">
   <strong>Capnomac</strong>
  </label>
</div>
    </div>
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="ul" id="ultima" value="ultima">
  <label class="form-check-label" for="ultima">
   <strong>Última</strong>
  </label>
</div>
    </div>
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="capcap" id="capcap" value="capnocap">
  <label class="form-check-label" for="capcap">
   <strong>Capnocap</strong>
  </label>
</div>
    </div>
  </div>
</div>
</center>
<hr>
<div class="container">
  <div class="row">
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="checkbox" name="tiponac" id="parto" value="parto">
  <label class="form-check-label" for="parto">
    <strong>Parto</strong>
  </label>
</div>
  </div>
  <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="checkbox" name="tiponac" id="cesarea" value="cesarea">
  <label class="form-check-label" for="cesarea">
    <strong>Cesárea</strong>
  </label>
</div>
  </div>
  <div class="col-sm-1">
     <strong>Fecha:</strong>
  </div>
  <div class="col-sm-4">
  <input type="date" name="fechanac" class="form-control">
  </div>
  <div class="col-sm-1">
     <strong>Hora:</strong>
  </div>
<div class="col-sm-3">
<input type="time" name="horanac" class="form-control">
  </div>
  </div>
</div>

<p>
<div class="container">
  <div class="row">
    <div class="col-sm-1">
  <strong>Producto</strong>
</div>
<strong>Vivo:</strong>
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="vivo" id="vivosi" value="si">
  <label class="form-check-label" for="vivosi">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="vivo" id="vivono" value="no" checked>
  <label class="form-check-label" for="vivono">
    <strong>No</strong>
  </label>
</div>
  </div>
  <strong>Género:</strong>
   <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="checkbox" name="genero" id="hombreg" value="hombre">
  <label class="form-check-label" for="hombreg">
    <strong>Hombre</strong>
  </label>
</div>
  </div>
  <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="checkbox" name="genero" id="mujerg" value="mujer">
  <label class="form-check-label" for="mujerg">
    <strong>Mujer</strong>
  </label>
</div>
  </div>
    <strong><button type="button" class="btn btn-success btn-sm" id="pla26"><i class="fas fa-play"></button></i> Apgar:</strong>
    <div class="col-sm-3">
      <input type="text" name="apgar" class="form-control" id="t26">
    </div>
  </div>
</div>
<script type="text/javascript">
const t26 = document.getElementById('t26');
const btnPlayTex26 = document.getElementById('pla26');
btnPlayTex26.addEventListener('click', () => {
        leerTexto(t26.value);
});

function leerTexto(t26){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t26;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm-1">
  <strong>Asistencia:</strong>
</div>
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="asistencia" id="sias" value="si">
  <label class="form-check-label" for="sias">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="asistencia" id="noas" value="no" checked>
  <label class="form-check-label" for="noas">
    <strong>No</strong>
  </label>
</div>
  </div>
  <div class="col-sm-1">
  <strong>Ventilación:</strong>
</div>
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="ventilacionnac" id="sivent" value="si">
  <label class="form-check-label" for="sivent">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="ventilacionnac" id="novent" value="no" checked>
  <label class="form-check-label" for="novent">
    <strong>No</strong>
  </label>
</div>
  </div>
  <div class="col-sm-1">
  <strong>Intubación:</strong>
</div>
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="intubaneo" id="sineona" value="si">
  <label class="form-check-label" for="sineona">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="intubaneo" id="noneona" value="no" checked>
  <label class="form-check-label" for="noneona">
    <strong>No</strong>
  </label>
</div>
  </div>
  <div class="col-sm">
  <strong>Salpingoclasia:</strong>
</div>
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="sal" id="salsii" value="si">
  <label class="form-check-label" for="salsii">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="sal" id="salnoo" value="no" checked>
  <label class="form-check-label" for="salnoo">
    <strong>No</strong>
  </label>
</div>
  </div>
  </div>
</div>
<p>
<div class="container">
  <div class="row">
    <!-- <div class="col-sm-2">
       <strong><button type="button" class="btn btn-success btn-sm" id="pla27"><i class="fas fa-play"></button></i> Tiempo anestésico</strong>
       <input type="text" name="tiempoa" class="form-control" id="t27">
     </div>-->
<script type="text/javascript">
const t27 = document.getElementById('t27');
const btnPlayTex27 = document.getElementById('pla27');
btnPlayTex27.addEventListener('click', () => {
        leerTexto(t27.value);
});

function leerTexto(t27){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t27;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <!-- <div class="col-sm-2">
      <strong><button type="button" class="btn btn-success btn-sm" id="pla28"><i class="fas fa-play"></button></i> Tiempo quirúrgico</strong>
       <input type="text" name="tiempoq" class="form-control" id="t28">
     </div>-->
     <script type="text/javascript">
const t28 = document.getElementById('t28');
const btnPlayTex28 = document.getElementById('pla28');
btnPlayTex28.addEventListener('click', () => {
        leerTexto(t28.value);
});

function leerTexto(t28){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t28;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
     <div class="col-sm-2">
      <strong><button type="button" class="btn btn-success btn-sm" id="pla29"><i class="fas fa-play"></button></i> Posición</strong>
       <input type="text" name="posicion" class="form-control" id="t29">
     </div>
    <script type="text/javascript">
const t29 = document.getElementById('t29');
const btnPlayTex29 = document.getElementById('pla29');
btnPlayTex29.addEventListener('click', () => {
        leerTexto(t29.value);
});

function leerTexto(t29){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t29;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
     <div class="col-sm-2">
      <strong><button type="button" class="btn btn-success btn-sm" id="pla30"><i class="fas fa-play"></button></i> Cuenta de gasas</strong>
       <input type="text" name="cuentagasa" class="form-control" id="t30">
     </div>
<script type="text/javascript">
const t30 = document.getElementById('t30');
const btnPlayTex30 = document.getElementById('pla30');
btnPlayTex30.addEventListener('click', () => {
        leerTexto(t30.value);
});

function leerTexto(t30){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t30;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
     <div class="col-sm-3">
      <strong><button type="button" class="btn btn-success btn-sm" id="pla31"><i class="fas fa-play"></button></i> Cuenta de compresas</strong>
       <input type="text" name="cuentacom" class="form-control" id="t31">
     </div>
<script type="text/javascript">
const t31 = document.getElementById('t31');
const btnPlayTex31 = document.getElementById('pla31');
btnPlayTex31.addEventListener('click', () => {
        leerTexto(t31.value);
});

function leerTexto(t31){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t31;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
      <div class="col-sm-2">
      <strong><button type="button" class="btn btn-success btn-sm" id="pla32"><i class="fas fa-play"></button></i> No. de venoclisis</strong>
       <input type="text" name="noveno" class="form-control" id="t32">
     </div>
  </div>
</div>
<script type="text/javascript">
const t32 = document.getElementById('t32');
const btnPlayTex32 = document.getElementById('pla32');
btnPlayTex32.addEventListener('click', () => {
        leerTexto(t32.value);
});

function leerTexto(t32){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t32;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm-2">
  <strong>Punción arterial:</strong>
</div>
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="puncion" id="sipun" value="si">
  <label class="form-check-label" for="sipun">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="puncion" id="nopun" value="no" checked>
  <label class="form-check-label" for="nopun">
    <strong>No</strong>
  </label>
</div>
  </div>
  <div class="col-sm-2">
  <strong>Catéter central:</strong>
</div>
<div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="catcentral" id="sicatce" value="si">
  <label class="form-check-label" for="sicatce">
    <strong>Si</strong>
  </label>
</div>
  </div>
  <div class="col-sm-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="catcentral" id="nocacen" value="no" checked>
  <label class="form-check-label" for="nocacen">
    <strong>No</strong>
  </label>
</div>
  </div>
</div>
</div>



<hr>
<div class="col-12">
 <strong><button type="button" class="btn btn-success btn-sm" id="pla33"><i class="fas fa-play"></button></i> Diagnóstico Preoperatorio:</strong><input type="text" name="dxpre" id="t33" class="form-control"></div>
 <script type="text/javascript">
const t33 = document.getElementById('t33');
const btnPlayTex33 = document.getElementById('pla33');
btnPlayTex33.addEventListener('click', () => {
        leerTexto(t33.value);
});

function leerTexto(t33){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t33;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
  <div class="col-12"><strong><button type="button" class="btn btn-success btn-sm" id="pla34"><i class="fas fa-play"></button></i>Diagnóstico Post-operatorio:</strong><input type="text" id="t34" name="dcpost" class="form-control"></div>
   <script type="text/javascript">
const t34 = document.getElementById('t34');
const btnPlayTex34 = document.getElementById('pla34');
btnPlayTex34.addEventListener('click', () => {
        leerTexto(t34.value);
});

function leerTexto(t34){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t34;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
  <div class="col-12"><strong><button type="button" class="btn btn-success btn-sm" id="pla35"><i class="fas fa-play"></button></i> Cirugia programada:</strong><input type="text" id="t35" name="cirpro" class="form-control"></div>
  <script type="text/javascript">
const t35 = document.getElementById('t35');
const btnPlayTex35 = document.getElementById('pla35');
btnPlayTex35.addEventListener('click', () => {
        leerTexto(t35.value);
});

function leerTexto(t35){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t35;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
 <div class="col-12"> <strong><button type="button" class="btn btn-success btn-sm" id="pla36"><i class="fas fa-play"></button></i> Cirugia realizada:</strong><input type="text" id="t36" name="cirre" class="form-control"></div>
  <script type="text/javascript">
const t36 = document.getElementById('t36');
const btnPlayTex36 = document.getElementById('pla36');
btnPlayTex36.addEventListener('click', () => {
        leerTexto(t36.value);
});

function leerTexto(t36){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t36;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<hr>

<div class="form-group">
  <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>NOTA POST-ANESTÉSICA</strong></center><p>
</div> 

<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="veg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="cuarsto"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla37"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" name="notevo_un" id="txtnot" rows="3"></textarea>
<script type="text/javascript">
const veg = document.getElementById('veg');
const cuarsto = document.getElementById('cuarsto');
const txtnot = document.getElementById('txtnot');

const btnPlayTex37 = document.getElementById('pla37');
btnPlayTex37.addEventListener('click', () => {
        leerTexto(txtnot.value);
});

function leerTexto(txtnot){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtnot;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let revnot = new webkitSpeechRecognition();
      revnot.lang = "es-ES";
      revnot.continuous = true;
      revnot.interimResults = false;

      revnot.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtnot.value += frase;
      }

      veg.addEventListener('click', () => {
        revnot.start();
      });

      cuarsto.addEventListener('click', () => {
        revnot.abort();
      });
</script>
  </div><hr>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>VALORACIÓN DE LA RECUPERACIÓN ANESTÉSICA</strong></center><p>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm">
     <br><hr><br><strong>ACTIVIDAD MUSCULAR</strong>
     <br>
     
     <hr>
     <strong>RESPIRACIÓN</strong>
     <br><br>
     <hr><br>
     <strong>CIRCULACIÓN</strong>
     <br><br>
     <hr>
     <strong>ESTADO DE CONCIENCIA</strong>
     <hr>
     <strong>COLORACIÓN</strong>
     <hr>
     <br>
     <br>
     <br>
     <p></p>
     <strong>
<button type="button" class="btn btn-success btn-sm" id="pla39"><i class="fas fa-play"></button></i> Alta a su piso</strong>
     <hr>
     <strong><button type="button" class="btn btn-success btn-sm" id="pla40"><i class="fas fa-play"></button></i> Médico responsable</strong>
    </div>
    <div class="col-3"><strong><center>TIEMPO (MINUTOS)</center></strong><hr><br>
      <font size="1"><p>Movimientos voluntarios (4 extremidades)<br>
      Movimientos voluntarios (2 extremidades)
      Completamene inmóvl</p></font>
      <hr>
      <font size="1"><p>Respiraciones amplias y capaz de toser
      Respiraciones limitadas y tos débil<br>
    Apnea<br>(Frecuencia =F)</p></font><hr>
 
 <font size="1"><p>Tensión arterial + -20% de cifras control<br>
 Tensión arterial + -21 - 49% de cifras control<br>
Tensión arterial + -50% de cifras control <br>(Frecuencia de pulso =P) y (Tensión arterial= TAX)</p>
</font><hr>

 <font size="1"><p>
  Completamene despierto<br>
 Responde al ser llamado<br>
No responde</p></font><hr>


<font size="1"><p>Mucosas sonrosadas<br>
Pálida<br>
Cianosis</p></font><hr>

<font size="5"><p><strong><center>TOTAL:</center></strong></p></font><hr>
<input type="text" name="altapiso" class="form-control" id="t39"><hr>
<script type="text/javascript">
const t39 = document.getElementById('t39');
const btnPlayTex39 = document.getElementById('pla39');
btnPlayTex39.addEventListener('click', () => {
        leerTexto(t39.value);
});

function leerTexto(t39){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t39;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script> 
<input type="text" name="med_res" class="form-control" id="t41">
<script type="text/javascript">
const t41 = document.getElementById('t41');
const btnPlayTex41 = document.getElementById('pla40');
btnPlayTex41.addEventListener('click', () => {
        leerTexto(t41.value);
});

function leerTexto(t41){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t41;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    </div>
    <div class="col-sm col-1">
      <br>
      <hr><br>
     <font size="1"><strong><p>= 2<br>
     = 1<br>
   = 0</p></strong></font>
   <hr><p></p>
     <font size="1"><strong><p>= 2<br>
     = 1<br>
   = 0</p></strong></font>
   <hr>

     <font size="1"><strong><p><br>= 2<br>
     = 1<br>
   = 0</p></strong></font>

<hr>
      
     <font size="1"><strong><p><br>= 2<br>
     = 1<br>
   = 0</p></strong></font>
<hr>
    
     <font size="1"><strong><p>= 2<br>
     = 1<br>
   = 0</p></strong></font>









    </div>
   <div class="col-sm">
    <center>0</center><hr><br><div class="losInput">
      <input  type="text" name="nt" id="num1" class="form-control" maxlength="1" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
      <div class="inputTotal"><input type="text" name="t" value="" class="form-control" disabled="">
    </div>
  </div>
     <div class="col-sm">
    <center>5</center><hr><br><div class="losInput2">
      <input type="text" name="nt2" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt2" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt2" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct2" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st2" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
<div class="inputTotal2">
    <input type="text" name="t2" class="form-control" disabled="">
  </div>
    </div>
     <div class="col-sm">
    <center>10</center><hr><br>
<div class="losInput3">
    <input type="text" name="nt3" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
    <input type="text" name="dt3" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
    <input type="text" name="tt3" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
    <input type="text" name="ct3" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
    <input type="text" name="st3" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
<div class="inputTotal3">
    <input type="text" name="t3" class="form-control" disabled=""></div>
    </div>
    <div class="col-sm">
    <center>15</center><hr><br><div class="losInput4">
      <input type="text" name="nt4" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt4" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt4" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct4" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st4" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
      <div class="inputTotal4">
        <input type="text" name="t4" class="form-control" disabled=""></div>
    </div>
    <div class="col-sm">
    <center>20</center><hr><br><div class="losInput5">
      <input type="text" name="nt5" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt5" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt5" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct5" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st5" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
      <div class="inputTotal5"><input type="text" name="t5" class="form-control" disabled=""></div>
    </div>
    <div class="col-sm">
    <center>25</center><hr><br><div class="losInput6">
      <input type="text" name="nt6" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt6" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt6" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct6" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st6" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
      <div class="inputTotal6"><input type="text" name="t6" class="form-control" disabled=""></div>
    </div>
    <div class="col-sm">
    <center>30</center><hr><br><div class="losInput7">
      <input type="text" name="nt7" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt7" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt7" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct7" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st7" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
      <div class="inputTotal7"><input type="text" name="t7" class="form-control" disabled=""></div>
    </div>
  </div>
</div>


<hr>


<center>
                       <div class="form-group col-6">
                            <button type="submit" class="btn btn-primary">Firmar y guardar</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
                        </div>
</center>
                        <br>
                        
                        </form>
  </div>

<div class="tab-pane fade" id="nav-signos" role="tabpanel" aria-labelledby="nav-signos-tab">
  <form action="" method="POST" id="signos">
<!--  signos-->
  <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
        
    <tr class="table" style="background-color: #2b2d7f; color: white;">
    
    <!--<th scope="col" class="col-sm-2"><center>No registro</center></th>-->
      <th scope="col" class="col-sm-2"><center>Presión arterial</center></th>
      <th scope="col" class="col-sm-1"><center>Frecuencia cardiaca (Pulso)</center></th>

        <th scope="col" class="col-sm-1"><center>Temperatura</center></th>
     <th scope="col" class="col-sm-1"><center></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>

     <!--<td><select class="form-control" name="valor">
      
       <option value="">1</option>

     </select></td>-->

        <td>
     <div class="row">
   

  <div class="col"><input type="number" class="form-control" id="sist" name="sist_mat" required=""></div> /
  <div class="col"><input type="number" class="form-control" id="diast" name="diast_mat" required=""></div>
 
</div></td>
      <td><input type="number" class="form-control" name="freccard_mat" required="">
    </div></td>

    </div></td>
    <td><input type="number"  class="form-control col-sm-12" name="temp" required="">
    </div></td>
   <td><input type="submit" name="btnsignos" class="btn btn-block btn-success" value="Agregar"></td>
    </tr>
     
  </tbody>
</table>

</form>

<?php

          if (isset($_POST['btnsignos'])) {
            include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            //$id_atencion = $_SESSION['pac'];


  $sist_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["sist_mat"], ENT_QUOTES)));
  $diast_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["diast_mat"], ENT_QUOTES)));
  $freccard_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["freccard_mat"], ENT_QUOTES)));
  //$p_an =  mysqli_real_escape_string($conexion, (strip_tags($_POST["p_an"], ENT_QUOTES)));
  //$p_op =  mysqli_real_escape_string($conexion, (strip_tags($_POST["p_op"], ENT_QUOTES)));
  //$fin_an =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fin_an"], ENT_QUOTES)));
  $temp =  mysqli_real_escape_string($conexion, (strip_tags($_POST["temp"], ENT_QUOTES)));        

 

$fecha_actual = date("Y-m-d");




$no++;

       $ingresar9 = mysqli_query($conexion, 'INSERT INTO signos_anest (id_atencion,fecha_anest,sist_mat,diast_mat,freccard_mat,temp,id_usua,no) values (' . $id_atencion . ' , "' . $fecha_actual . '","' . $sist_mat . '","' . $diast_mat . '","' . $freccard_mat . '","' . $temp . '",' . $id_usua .',"'.$no.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

           echo '<script type="text/javascript">window.location.href = "nota_unidad_cuidados.php";</script>';



       

        }


          ?>
          <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
              <th scope="col">No</th>
                    <th scope="col">Gráfica</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Presión arterial</th>
                    <th scope="col">Frecuencia cardiaca (pulso)</th>
                    
                    <th scope="col">Temperatura</th>
                    <th scope="col">Registró</th>
                </tr>
                </thead>
                <tbody>

<?php
include "../../conexionbd.php";
//$id_atencion=$_SESSION['pac'];
$resultado = $conexion->query("SELECT * from  signos_anest m , reg_usuarios r WHERE m.id_atencion=$id_atencion and m.id_usua=r.id_usua ORDER BY id_sig_an DESC") or die($conexion->error);
$usuario = $_SESSION['login'];
$no=1;
$nov=1;
while($f = mysqli_fetch_array($resultado)){   

                 
    ?>
  <tr>
    <td class="fondo"><strong><?php echo $no++;?></strong></td>
<td class="fondo"><a href="grafica.php?id_ord=<?php echo $f['id_sig_an'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua']?>&fecha=<?php echo $f['fecha_anest'];?>&id_exp=<?php echo $id_exp?>&no=<?php echo $nov++?>"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></a></td>
 <td class="fondo"><strong><?php $date=date_create($f['fecha_anest']); echo date_format($date,"d/m/Y");?></strong></td>
      <td class="fondo"><strong><?php echo $f['sist_mat'] . "/" . $f['diast_mat'];?></strong></td>
      <td class="fondo"><strong><?php echo $f['freccard_mat'];?></strong></td>
   
      <td class="fondo"><strong><?php echo $f['temp'];?></strong></td>
      <td class="fondo"><strong><?php echo $f['nombre'].' '.$f['papell'].' '.$f['sapell']?></strong></td>
                    </tr>
                    <?php
                
                 }
                ?>
                
                </tbody>
              
            </table>
            </div>
</div>

  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
      <hr>

<br>
  <div class="container">
  <form action="" method="POST" id="medicamentos">
      <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-primary">
            <th colspan="7"><center><h5><strong>REGISTRAR AGENTES</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col-4"><center>Hora</center></th>
      <th scope="col-4"><center>Agentes</center></th>
      <th scope="col-4"><center>Cantidades</center></th>
      <th scope="col-1"><center>Métodos</center></th>
      
    
      <th scope="col"><center></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <input type="time" name="horaa" class="form-control">
      </td>
      <td>
        <select class="form-control" name="agentes" style="width : 100%; heigth : 100%" required="">
        <option value="">Seleccionar agentes</option>
         <option value="A">A</option>
  <option value="B">B</option>
  <option value="C">C </option>
  <option value="D">D</option>
    <option value="E">E</option>
      <option value="F">F</option>
        <option value="G">G</option>
          <option value="H">H</option>
          <option value="I">I</option>
        </select>
      </td>
      
      <td><input type="text" name="cantidades" class="form-control"></td>
      <td><input type="text" name="metodos" class="form-control"></td>
     
     
      
      <td><input type="submit" name="btnagentes" class="btn btn-block btn-success" value="Agregar"></td>
    </tr>
  </tbody>
</table>
     </div>
     
    </form>
</div>
<?php

          if (isset($_POST['btnagentes'])) {
            include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            //$id_atencion = $_SESSION['pac'];

      $horaa =  mysqli_real_escape_string($conexion, (strip_tags($_POST["horaa"], ENT_QUOTES)));
      $agentes =  mysqli_real_escape_string($conexion, (strip_tags($_POST["agentes"], ENT_QUOTES)));
      $cantidades =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidades"], ENT_QUOTES)));
      $metodos =  mysqli_real_escape_string($conexion, (strip_tags($_POST["metodos"], ENT_QUOTES)));
      
          

if($horaa=='9' || $horaa=='10' || $horaa=='11'|| $horaa=='12'|| $horaa=='13' || $horaa=='14'){
$turno="MATUTINO";
} else if ($horaa=='15' || $horaa=='16' || $horaa=='17'|| $horaa=='18'|| $horaa=='19' || $horaa=='20' || $horaa=='21') {
  $turno="VESPERTINO";
}else if ($horaa=='22' || $horaa=='23' || $horaa=='24'|| $horaa=='1'|| $horaa=='2' || $horaa=='3' || $horaa=='4' || $horaa=='5' || $horaa=='6' || $horaa=='7' || $horaa=='8') {
    $turno="NOCTURNO";
}


$fecha_actual = date("Y-m-d");

if ($horaa == '24' || $horaa == '1' || $horaa == '2' || $horaa == '3' || $horaa == '4' || $horaa == '5' || $horaa == '6' || $horaa == '7' || $horaa == '8') {
   // Restamos un día a la fecha actual
   $fecha_actual = date('Y-m-d', strtotime('-1 day')) ; 
} else { 
   $fecha_actual = date("Y-m-d"); 
}



$fechahora = date("Y-m-d H:i:s");
       $ingresar9 = mysqli_query($conexion, 'INSERT INTO agentes_anest (id_atencion,fecha_a,horaa,turno,agentes,cantidades,metodos,id_usua,agentes_fecha) values (' . $id_atencion . ' , "' . $fecha_actual . '","' . $horaa . '","' . $turno . '","' . $agentes . '","' . $cantidades . '","' . $metodos . '",' . $id_usua .',"' . $fechahora . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

           echo '<script type="text/javascript">window.location.href = "nota_unidad_cuidados.php";</script>';
          }
          ?>
          <div class="container-fluid">
          <div class="col col-12">

            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
            </div>
            
               <?php


?>
            <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
              
                    <th scope="col">Pdf</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Agentes</th>
                    <th scope="col">Cantidades</th>
                    <th scope="col">Métodos</th>
                    <th scope="col">Fecha</th> 
                    <th scope="col">Turno</th>
                    <th scope="col">Registró</th>
                </tr>
                </thead>
                <tbody>

<?php
include "../../conexionbd.php";
//$id_atencion=$_SESSION['pac'];
$resultado = $conexion->query("SELECT * from agentes_anest m , reg_usuarios r WHERE m.id_atencion=$id_atencion and m.id_usua=r.id_usua ORDER BY id_agentes DESC") or die($conexion->error);
$usuario = $_SESSION['login'];
while($f = mysqli_fetch_array($resultado)){   

    $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion") or die($conexion->error);

            
              while ($row = $resultado2->fetch_assoc()) {             
    ?>
                    <tr>
                        <td class="fondo"><a href="../pdf/pdf_agentes.php?id_ord=<?php echo $f['id_agentes'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua']?>&fecha=<?php echo $f['fecha_a'];?>&id_exp=<?php echo $row['Id_exp'];?>" target="_blank"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></a></td>
                        <td class="fondo"><strong><?php echo $f['horaa'];?></strong></td>
                         <td class="fondo"><strong><?php echo $f['agentes'];?></strong></td>
                         <td class="fondo"><strong><?php echo $f['cantidades'];?></strong></td>
                         <td class="fondo"><strong><?php echo $f['metodos'];?></strong></td>
                        <td class="fondo"><strong><?php $date=date_create($f['fecha_a']); echo date_format($date,"d/m/Y");?></strong></td>
                        <td class="fondo"><strong><?php echo $f['turno'];?></strong></td>
                        <td class="fondo"><strong><?php echo $f['nombre'].' '.$f['papell'].' '.$f['sapell']?></strong></td>
                    </tr>
                    <?php
                }
                 }
                ?>
                
                </tbody>
              
            </table>
            </div>

        </div>
    </div>
  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
  <!--INGRESOS-->
  <hr>

  <div class="container">
  <form action="" method="POST" id="medicamentos">
      <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-primary">
            <th colspan="7"><center><h5><strong>REGISTRAR INGRESOS</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col-4"><center>Hora</center></th>
      <th scope="col-4"><center>Descripción</center></th>
      <th scope="col-4"><center>Cantidad</center></th>
  
      
    
      <th scope="col"><center></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
<input type="time" name="horaa" class="form-control">
      </td>
      <td>
        <select class="form-control" name="descripcion" style="width : 100%; heigth : 100%" required="">
        <option value="">Seleccionar ingresos</option>
         <option value="Dx 5%">Dx 5%</option>
  <option value="Fisiol">Fisiol</option>
  <option value="Hartman">Hartman </option>
  <option value="Gelatina">Gelatina</option>
    <option value="Dextran">Dextran</option>
      <option value="Plasma">Plasma</option>
        <option value="Sangre">Sangre</option>
          <option value="Otros">Otros</option>
        
        </select>
      </td>
      
      <td><input type="text" name="cantidad" class="form-control"></td>
      
     
     
      
      <td><input type="submit" name="btnagregar" class="btn btn-block btn-success" value="Agregar"></td>
    </tr>
  </tbody>
</table>
     </div>
     
    </form>
</div>
<?php

          if (isset($_POST['btnagregar'])) {
            include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            //$id_atencion = $_SESSION['pac'];

    $horaa =  mysqli_real_escape_string($conexion, (strip_tags($_POST["horaa"], ENT_QUOTES)));
    $descripcion =  mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
    $cantidad =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));

if($horaa=='9' || $horaa=='10' || $horaa=='11'|| $horaa=='12'|| $horaa=='13' || $horaa=='14'){
$turno="MATUTINO";
} else if ($horaa=='15' || $horaa=='16' || $horaa=='17'|| $horaa=='18'|| $horaa=='19' || $horaa=='20' || $horaa=='21') {
  $turno="VESPERTINO";
}else if ($horaa=='22' || $horaa=='23' || $horaa=='24'|| $horaa=='1'|| $horaa=='2' || $horaa=='3' || $horaa=='4' || $horaa=='5' || $horaa=='6' || $horaa=='7' || $horaa=='8') {
    $turno="NOCTURNO";
}


$fecha_actual = date("Y-m-d");

if ($horaa == '24' || $horaa == '1' || $horaa == '2' || $horaa == '3' || $horaa == '4' || $horaa == '5' || $horaa == '6' || $horaa == '7' || $horaa == '8') {
   // Restamos un día a la fecha actual
   $fecha_actual = date('Y-m-d', strtotime('-1 day')) ; 
} else { 
   $fecha_actual = date("Y-m-d"); 
}



$fechahora = date("Y-m-d H:i:s");
       $ingresar9 = mysqli_query($conexion, 'INSERT INTO ingresos_anest (id_atencion,id_usua,horaa,descripcion,cantidad,fecha,turno) values (' . $id_atencion . ' , ' . $id_usua . ',"' . $horaa . '","' . $descripcion . '","' . $cantidad . '","' . $fecha_actual . '","' . $turno . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

           echo '<script type="text/javascript">window.location.href = "nota_unidad_cuidados.php";</script>';
          }
          ?>
 <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
              
                    <th scope="col">Fecha de registro</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Cantidad</th>
                   
                    <th scope="col">Registró</th>
                    <th scope="col">Editar</th>
                </tr>
                </thead>
                <tbody>

<?php
include "../../conexionbd.php";
//$id_atencion=$_SESSION['pac'];
$resultado = $conexion->query("SELECT * from ingresos_anest m , reg_usuarios r WHERE m.id_atencion=$id_atencion and m.id_usua=r.id_usua ORDER BY id_ing_anest DESC") or die($conexion->error);
$usuario = $_SESSION['login'];
while($f = mysqli_fetch_array($resultado)){   

    $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion") or die($conexion->error);

            
              while ($row = $resultado2->fetch_assoc()) {             
    ?>
                    <tr>
                        <!--<td class="fondo"><a href="../pdf/pdf_agentes.php?id_ord=<?php echo $f['id_agentes'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua']?>&fecha=<?php echo $f['fecha_a'];?>&id_exp=<?php echo $row['Id_exp'];?>" target="_blank"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></a></td>-->
                        <td class="fondo"><strong><?php $date=date_create($f['fecha']); echo date_format($date,"d/m/Y");?></strong></td>
                        <td class="fondo"><strong><?php echo $f['horaa'];?></strong></td>
                         <td class="fondo"><strong><?php echo $f['descripcion'];?></strong></td>
                         <td class="fondo"><strong><?php echo $f['cantidad'];?></strong></td>
                        
                        <td class="fondo"><strong><?php echo $f['nombre'].' '.$f['papell'].' '.$f['sapell']?></strong></td>

 <td><center><a href="editar_ingresos.php?id=<?php echo $f['id_ing_anest'];?>" title="Editar datos" class="btn btn-warning btn-sm "><span class="fa fa-edit" aria-hidden="true"></span></a></td></center>
                    </tr>
                    <?php
                }
                 }
                ?>
                
                </tbody>
              
            </table>
            <?php
$resultado3 = $conexion->query("SELECT SUM(cantidad) as can from ingresos_anest WHERE id_atencion=$id_atencion ORDER BY id_ing_anest DESC") or die($conexion->error);
?>

<table class="table table-bordered table-striped" id="mytable3">
       <thead class="thead">
         <?php
                while($f3 = mysqli_fetch_array($resultado3)){
                    
                    ?>
    <tr class="table-danger">
      <th scope="col" colspan="1"><center>Subtotal:</center></th>
      <th scope="col" colspan="1"><center><strong><?php echo $f3['can'] . " ML "?></strong></center></th>
    </tr>

  </thead>
  <tbody>
<?php
        }
?> 
  </tbody>
</table>
            </div>



  </div>
   <div class="tab-pane fade" id="nav-egresos" role="tabpanel" aria-labelledby="nav-egresos-tab">
     <!--egresos anestesia--><hr>

  <div class="container">
  <form action="" method="POST" id="medicamentos">
      <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-primary">
            <th colspan="7"><center><h5><strong>REGISTRAR EGRESOS</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col-4"><center>Hora</center></th>
      <th scope="col-4"><center>Descripción</center></th>
      <th scope="col-4"><center>Cantidad</center></th>
  
      
    
      <th scope="col"><center></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <input type="time" name="horaa" class="form-control">
      </td>
      <td>
        <select class="form-control" name="descripcion" style="width : 100%; heigth : 100%" required="">
        <option value="">Seleccionar ingresos</option>
         <option value="Ayuno">Ayuno</option>
  <option value="Diuresis">Diuresis</option>
  <option value="Sangrado">Sangrado </option>
  <option value="Exposicion">Exposición</option>
    <option value="Otros">Otros</option>

        
        </select>
      </td>
      
      <td><input type="text" name="cantidad" class="form-control"></td>
      
     
     
      
      <td><input type="submit" name="btnegresos" class="btn btn-block btn-success" value="Agregar"></td>
    </tr>
  </tbody>
</table>
     </div>
     
    </form>
</div>
<?php

          if (isset($_POST['btnegresos'])) {
            include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            //$id_atencion = $_SESSION['pac'];

    $horaa =  mysqli_real_escape_string($conexion, (strip_tags($_POST["horaa"], ENT_QUOTES)));
    $descripcion =  mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
    $cantidad =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));

if($horaa=='9' || $horaa=='10' || $horaa=='11'|| $horaa=='12'|| $horaa=='13' || $horaa=='14'){
$turno="MATUTINO";
} else if ($horaa=='15' || $horaa=='16' || $horaa=='17'|| $horaa=='18'|| $horaa=='19' || $horaa=='20' || $horaa=='21') {
  $turno="VESPERTINO";
}else if ($horaa=='22' || $horaa=='23' || $horaa=='24'|| $horaa=='1'|| $horaa=='2' || $horaa=='3' || $horaa=='4' || $horaa=='5' || $horaa=='6' || $horaa=='7' || $horaa=='8') {
    $turno="NOCTURNO";
}


$fecha_actual = date("Y-m-d");

if ($horaa == '24' || $horaa == '1' || $horaa == '2' || $horaa == '3' || $horaa == '4' || $horaa == '5' || $horaa == '6' || $horaa == '7' || $horaa == '8') {
   // Restamos un día a la fecha actual
   $fecha_actual = date('Y-m-d', strtotime('-1 day')) ; 
} else { 
   $fecha_actual = date("Y-m-d"); 
}



$fechahora = date("Y-m-d H:i:s");
       $ingresar10 = mysqli_query($conexion, 'INSERT INTO egresos_anest (id_atencion,id_usua,horaa,descripcion,cantidad,fecha,turno) values (' . $id_atencion . ' , ' . $id_usua . ',"' . $horaa . '","' . $descripcion . '","' . $cantidad . '","' . $fecha_actual . '","' . $turno . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

           echo '<script type="text/javascript">window.location.href = "nota_unidad_cuidados.php";</script>';
          }
          ?>
 <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
              
                    <th scope="col">Fecha de registro</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Cantidad</th>
                   
                    <th scope="col">Registró</th>
                    <th scope="col">Editar</th>
                </tr>
                </thead>
                <tbody>

<?php
include "../../conexionbd.php";
//$id_atencion=$_SESSION['pac'];
$resultado = $conexion->query("SELECT * from egresos_anest m , reg_usuarios r WHERE m.id_atencion=$id_atencion and m.id_usua=r.id_usua ORDER BY id_egresos_anest DESC") or die($conexion->error);
$usuario = $_SESSION['login'];
while($f = mysqli_fetch_array($resultado)){   

    $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion") or die($conexion->error);

            
              while ($row = $resultado2->fetch_assoc()) {             
    ?>
                    <tr>
                        <!--<td class="fondo"><a href="../pdf/pdf_agentes.php?id_ord=<?php echo $f['id_agentes'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua']?>&fecha=<?php echo $f['fecha_a'];?>&id_exp=<?php echo $row['Id_exp'];?>" target="_blank"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></a></td>-->
                        <td class="fondo"><strong><?php $date=date_create($f['fecha']); echo date_format($date,"d/m/Y");?></strong></td>
                        <td class="fondo"><strong><?php echo $f['horaa'];?></strong></td>
                         <td class="fondo"><strong><?php echo $f['descripcion'];?></strong></td>
                         <td class="fondo"><strong><?php echo $f['cantidad'];?></strong></td>
                        
                        <td class="fondo"><strong><?php echo $f['nombre'].' '.$f['papell'].' '.$f['sapell']?></strong></td>

 <td><center><a href="editar_egresos.php?id=<?php echo $f['id_egresos_anest'];?>" title="Editar datos" class="btn btn-warning btn-sm "><span class="fa fa-edit" aria-hidden="true"></span></a></td></center>
                    </tr>
                    <?php
                }
                 }
                ?>
                
                </tbody>
              
            </table>
            <?php
$resultado3 = $conexion->query("SELECT SUM(cantidad) as can from egresos_anest WHERE id_atencion=$id_atencion ORDER BY id_egresos_anest DESC") or die($conexion->error);
?>

<table class="table table-bordered table-striped" id="mytable3">
       <thead class="thead">
         <?php
                while($f3 = mysqli_fetch_array($resultado3)){
                    
                    ?>
    <tr class="table-danger">
      <th scope="col" colspan="1"><center>Subtotal:</center></th>
      <th scope="col" colspan="1"><center><strong><?php echo $f3['can'] . " ML "?></strong></center></th>
    </tr>

  </thead>
  <tbody>
<?php
        }
?> 
  </tbody>
</table>
            </div>



   </div>
</div>
   

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
<script>
$('.losInput input').on('change', function(){
  var total = 0;
  $('.losInput input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal input').val(total.toFixed());
});

$('.losInput2 input').on('change', function(){
  var total = 0;
  $('.losInput2 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal2 input').val(total.toFixed());
});

$('.losInput3 input').on('change', function(){
  var total = 0;
  $('.losInput3 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal3 input').val(total.toFixed());
});

$('.losInput4 input').on('change', function(){
  var total = 0;
  $('.losInput4 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal4 input').val(total.toFixed());
});
$('.losInput5 input').on('change', function(){
  var total = 0;
  $('.losInput5 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal5 input').val(total.toFixed());
});
$('.losInput6 input').on('change', function(){
  var total = 0;
  $('.losInput6 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal6 input').val(total.toFixed());
});
$('.losInput7 input').on('change', function(){
  var total = 0;
  $('.losInput7 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal7 input').val(total.toFixed());
});
function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;        
}
</script>


</body>
</html>