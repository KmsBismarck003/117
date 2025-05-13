<?php
session_start();
include "../../conexionbd.php";
include("../header_enfermera.php");
 
if (isset($_SESSION['pac'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
    $resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp  WHERE id_atencion=" . $_SESSION['pac']) or die($conexion->error);
    if (mysqli_num_rows($resultado) > 0) { //se mostrara si existe mas de 1
        $f = mysqli_fetch_row($resultado);

    } else {
        header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
    }
}

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

    <title>BANCO DE SANGRE </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>NOTA DE TRANSFUCIÓN</center></strong>
</div>
                <hr>
<?php

    include "../../conexionbd.php";

    if (isset($_SESSION['pac'])) {
      $id_atencion = $_SESSION['pac'];

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

     $sql_pac = "SELECT * FROM  dat_ingreso WHERE id_atencion =$id_atencion";

          $result_pac = $conexion->query($sql_pac);

          while ($row_pac = $result_pac->fetch_assoc()) {
            $fingreso = $row_pac['fecha'];
             $fegreso = $row_pac['fec_egreso'];
             $alta_med = $row_pac['alta_med'];
             $alta_adm = $row_pac['alta_adm'];
             $activo = $row_pac['activo'];
             $valida = $row_pac['valida'];
          }

if($alta_med=='SI' && $alta_adm=='SI' && $activo=='NO' && $valida=='SI'){
    
    $sql_est = "SELECT DATEDIFF('$fegreso', '$fingreso') as estancia FROM dat_ingreso where id_atencion = $id_atencion";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
          $estancia = $row_est['estancia'];
      }
}else{
    
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
 <font size="2">
         <div class="container">
  <div class="row">
    <div class="col-sm-6">
  
      Expediente: <strong><?php echo $folio?> </strong>
   
     Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    <div class="col-sm">
      Área: <strong><?php echo $area ?></strong>
    </div>
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm">
      Fecha de ingreso: <strong><?php echo date_format($date, "d-m-Y") ?></strong>
    </div>
  </div>
</div></font>
  <font size="2">
     <div class="container">
  <div class="row">
    <div class="col-sm">
       <?php $date1 = date_create($pac_fecnac);
   ?>
      Fecha de nacimiento: <strong><?php echo date_format($date1, "d-m-Y") ?></strong>
    </div>
    <div class="col-sm">
      Tipo de sangre: <strong><?php echo $pac_tip_sang ?></strong>
    </div>
   
      <div class="col-sm">
      Habitación: <strong><?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);                                                                                    while ($row_hab = $result_hab->fetch_assoc()) {
  echo $row_hab['num_cama'];
} ?></strong>
    </div>
    <div class="col-sm">
      Tiempo estancia: <strong><?php echo $estancia ?> Dias</strong>
    </div>
  </div>
</div>
</font>
 <font size="2">
  <div class="container">
  <div class="row">
   <div class="col-sm-3">
      Edad: <strong><?php if($anos > "0" ){
   echo $anos." años";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." meses";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." dias";
}
?></strong>
    </div>
    <div class="col-sm-3">
Peso: <strong><?php $sql_vit = "SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_vit = $conexion->query($sql_vit);
while ($row_vit = $result_vit->fetch_assoc()) {
$peso=$row_vit['peso'];
}if(!isset($peso)){
    $peso=0;
}   echo $peso;?></strong>
    </div>
   <div class="col-sm">
      Talla: <strong><?php $sql_vitt =" SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_vitt = $conexion->query($sql_vitt); 
while ($row_vitt = $result_vitt->fetch_assoc()) {
$talla=$row_vitt['talla'];
}
if(!isset($talla)){
    $talla=0;
}   echo $talla;?></strong>
    </div>
    <div class="col-sm">
      Género: <strong><?php echo $pac_sexo ?></strong>
    </div>
  </div>
</div>
</font>
<font size="2">
  <div class="container">
  <div class="row">
    <div class="col-sm-3">
      Alergias: <strong><?php echo $alergias ?></strong>
    </div>
    <div class="col-sm-6">
      Estado de salud: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud DESC LIMIT 1";
$result_edo = $conexion->query($sql_edo);                                                                                    while ($row_edo = $result_edo->fetch_assoc()) {
  echo $row_edo['edo_salud'];
} ?></strong>
    </div>
      
     <div class="col-sm">
    Aseguradora: <strong><?php $sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha DESC limit 1";
                                                                                  $result_aseg = $conexion->query($sql_aseg);
                                                                                  while ($row_aseg = $result_aseg->fetch_assoc()) {
                                                                                    echo $row_aseg['aseg'];
                                                                                  } ?></strong>
    </div>
  </div>
</div>
</font>
 <font size="2">
 <div class="col-sm-4">
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
       echo '<td> Diagnóstico: <strong>' . $d .'</strong></td>';
    } else{
          echo '<td"> Motivo de atención: <strong>' . $m .'</strong></td>';
    }?>
    </div>
  </font>
<hr>
</div>
        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
      }
        ?>
 
 <div class="container">  <!--INICIO -->

<form action="insert_tras_new.php" method="POST">

<div class="container">
  <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>PRE-TRANSFUSIONAL</strong></center><p>
</div>
  <div class="row">
    <div class="col-sm">
        <div class="form-group">
           <label>Fecha de transfusión:</label><br>
           <input type="date" name="fec_tras" class="form-control">
        </div>
    </div>
    <div class="col-sm">
        <div class="form-group">
           <label><button type="button" class="btn btn-success btn-sm" id="play"><i class="fas fa-play"></button></i> Número de unidades:</label><br>
           <input type="number" name="num_tras" class="form-control" id="texto">
        </div>
    </div>
<script type="text/javascript">
const texto = document.getElementById('texto');
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
    <div class="col-sm">
        <div class="form-group">
           <label><button type="button" class="btn btn-success btn-sm" id="playcc"><i class="fas fa-play"></button></i>  Contenido (cantidad):</label><br>
           <input type="text" name="cont_tras" class="form-control" id="txtcont">
        </div>
    </div>
<script type="text/javascript">
const txtcont = document.getElementById('txtcont');
const btnPlayTextcc = document.getElementById('playcc');

btnPlayTextcc.addEventListener('click', () => {
        leerTexto(txtcont.value);
});

function leerTexto(txtcont){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtcont;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>

        <div class="col-sm-3">
          <div class="form-group">
             <label><button type="button" class="btn btn-success btn-sm" id="playfol"><i class="fas fa-play"></button></i> Folio:</label><br>
             <input type="text" name="fol_tras" class="form-control" id="txtf">
          </div>
        </div>
    </div><hr>
    <script type="text/javascript">
const txtf = document.getElementById('txtf');
const btnPlayTextff = document.getElementById('playfol');

btnPlayTextff.addEventListener('click', () => {
        leerTexto(txtf.value);
});

function leerTexto(txtf){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtf;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="row">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>COMPONENTE SANGUINEO</strong></center><p>
</div>
          </div>
        </div>
        <div class="row">
         <div class="col-sm-3">
          <label>Paquete globular </label>
          <input type="radio" name="comp_sang" value="PAQUETE GLOBULAR" >
         </div>
         <div class="col-sm-3">
          <label>Plasma</label>
          <input type="radio" name="comp_sang" value="PLASMA">
         </div>
         <div class="col-sm-3">
          <label>Crioprecipitado</label>
          <input type="radio" name="comp_sang" value="CRIOPRECIPITADO">
         </div>
         <div class="col-sm-3">
          <label>Aferesis</label>
          <input type="radio" name="comp_sang" value="AFERESIS">
         </div>
       </div><hr>
        </div>
    </div>
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label><button type="button" class="btn btn-success btn-sm" id="playhe"><i class="fas fa-play"></button></i> Hemoglobina:</label>
        <input type="cm-number" name="hb_tras" class="form-control" id="txth">
      </div>
    </div>
<script type="text/javascript">
const txth = document.getElementById('txth');
const btnPlayTexthm = document.getElementById('playhe');

btnPlayTexthm.addEventListener('click', () => {
        leerTexto(txth.value);
});

function leerTexto(txth){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txth;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col">
      <div class="form-group">
        <label><button type="button" class="btn btn-success btn-sm" id="playhemato"><i class="fas fa-play"></button></i> Hematocrito:</label>
        <input type="cm-number" name="hto_tras" class="form-control" id="txtcrito">
      </div>
    </div>
<script type="text/javascript">
const txtcrito = document.getElementById('txtcrito');
const btnPlayTexthrito = document.getElementById('playhemato');

btnPlayTexthrito.addEventListener('click', () => {
        leerTexto(txtcrito.value);
});

function leerTexto(txtcrito){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtcrito;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col">
      <div class="form-group">
        <label><button type="button" class="btn btn-success btn-sm" id="playsanguineo"><i class="fas fa-play"></button></i> Grupo sanguineo:</label>
                            <select id="san_tras" class="form-control" name="san_tras" id="txtsneo" required>
                                <option value="">Seleccionar</option>
                                <option value="O Rh(-)">O Rh(-)</option>
                                <option value="O Rh(+)">O Rh(+)</option>
                                <option value="A Rh(-)">A Rh(-)</option>
                                <option value="A Rh(+)">A Rh(+)</option>
                                <option value="B Rh(-)">B Rh(-)</option>
                                <option value="B Rh(+)">B Rh(+)</option>
                                <option value="AB Rh(-)">AB Rh(-)</option>
                                <option value="AB Rh(+)">AB Rh(+)</option>
                                <option value="No especificado">No especificado</option>
                            </select>
       
       
      </div>
    </div>
  </div><hr>
  

  
  
<script type="text/javascript">
const txtsneo = document.getElementById('txtsneo');
const btnPlayTextgrou = document.getElementById('playsanguineo');

btnPlayTextgrou.addEventListener('click', () => {
        leerTexto(txtsneo.value);
});

function leerTexto(txtsneo){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtsneo;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
 <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
 <div class="container"> 
   <div class="row">
    <div class="col-sm-4">
      <center>Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" name="sisto_pre" class="form-control"></div> /
  <div class="col"><input type="text" name="diasto_pre" class="form-control"></div>
 
</div>
    </div>
    <div class="col-sm-4">
      Frecuencia cardiaca:<input type="text" name="fc_pre" class="form-control" value="">
    </div>
   <!-- <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" name="fr_tras" class="form-control" value="">
    </div>-->
    <div class="col-sm-4">
     Temperatura:<input type="text" name="temp_pre" class="form-control" value="">
    </div>
   <!-- <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="text" name="sat_tras"  class="form-control" value="">
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" name="peso_tras" class="form-control" value="" >
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" name="talla_tras" class="form-control" value="" >
    </div>-->
  </div>
</div>
<p>
  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label>Hora de inicio</label><br>
        <input type="time" name="inicio_tras" class="form-control">
        
      </div>
    </div>
  </div>
    <div class="row">
    <div class="col">
      <div class="form-group">
        <div class="form-group">
        <label><button type="button" class="btn btn-success btn-sm" id="playncdm"><i class="fas fa-play"></button></i>
 Nombre completo del médico que indica la transfusión:</label><br>
        <input type="text" name="med_tras" class="form-control" id="txtmqit">
      </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
const txtmqit = document.getElementById('txtmqit');
const btnPlayTextindi = document.getElementById('playncdm');

btnPlayTextindi.addEventListener('click', () => {
        leerTexto(txtmqit.value);
});

function leerTexto(txtmqit){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtmqit;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="row">
    <div class="col">
      <div class="form-group">
        <label><button type="button" class="btn btn-success btn-sm" id="playqrt"><i class="fas fa-play"></button></i> Nombre completo de quien realiza la transfusión:</label><br>
        <input type="text" name="medi_tras" class="form-control" id="txtnomquien">
      </div>
    </div>
  </div>
  <script type="text/javascript">
const txtnomquien = document.getElementById('txtnomquien');
const btnPlayTexttransfusion = document.getElementById('playqrt');

btnPlayTexttransfusion.addEventListener('click', () => {
        leerTexto(txtnomquien.value);
});

function leerTexto(txtnomquien){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtnomquien;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  <hr>
  <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>TRANSFUSIONAL</strong></center><p>
</div>
 
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
                <div class="container"> 
  <div class="row">
    <div class="col-sm-4">
      <center>Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" name="sisto_tras" class="form-control"></div> /
  <div class="col"><input type="text" name="diasto_tras" class="form-control"></div>
 
</div>
    </div>
    <div class="col-sm-4">
      Frecuencia cardiaca:<input type="text" name="fc_tras" class="form-control" value="">
    </div>
   <!-- <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" name="fr_tras" class="form-control" value="">
    </div>-->
    <div class="col-sm-4">
     Temperatura:<input type="text" name="temp_tras" class="form-control" value="">
    </div>
   <!-- <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="text" name="sat_tras"  class="form-control" value="">
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" name="peso_tras" class="form-control" value="" >
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" name="talla_tras" class="form-control" value="" >
    </div>-->
  </div>
</div><hr>
   

   <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>POST-TRANSFUSIONAL</strong></center><p>
</div>
 
 <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
              
  <div class="row">
    <div class="col-sm-4"><br><center>Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" name="p_sistol"></div> /
  <div class="col"><input type="text" class="form-control" name="p_diastol"></div>
 
</div>
    </div>
    <div class="col-sm-4">
     <br>Frecuencia cardiaca:<input type="text" class="form-control" name="fcard">
    </div>
   <!-- <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" class="form-control" name="fresp">
    </div>-->
    <div class="col-sm-4">
     <br>Temperatura:<input type="text" class="form-control"  name="temper">
    </div>
   <!-- <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="text"  class="form-control" name="satoxi">
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" class="form-control"  name="peso">
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" class="form-control" name="talla" >
    </div>-->
  </div>
<hr>
    <div class="row">
    <div class="col">
      <div class="form-group">
        <br><button type="button" class="btn btn-success btn-sm" id="playtransfun"><i class="fas fa-play"></button></i> Volumen transfundido:<input type="text" class="form-control" value="" name="vol_tras" id="txtfundido">
      </div>
    </div>
<script type="text/javascript">
const txtfundido = document.getElementById('txtfundido');

const btnPlayTexttravol = document.getElementById('playtransfun');

btnPlayTexttravol.addEventListener('click', () => {
        leerTexto(txtfundido.value);
});

function leerTexto(txtfundido){
    const speeche = new SpeechSynthesisUtterance();
    speeche.text= txtfundido;
    speeche.volume=1;
    speeche.rate=1;
    speeche.pitch=0;
    window.speechSynthesis.speak(speeche);
}
</script>
    <div class="col">
      <div class="form-group">
        <br>Hora de término:
<input type="time" name="fin_tras" class="form-control">

      </div>
    </div>
    
  </div>  


 
  
  <div class="row">
    <div class="col">
      <div class="form-group">
        <br>Observaciones y estado general del paciente:
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="obsedosg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="vacs"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playobob"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" value="" rows="3" name="ob_tras" id="txtdobv"></textarea>
<script type="text/javascript">
const obsedosg = document.getElementById('obsedosg');
const vacs = document.getElementById('vacs');
const txtdobv = document.getElementById('txtdobv');

const btnPlayonob = document.getElementById('playobob');

btnPlayonob.addEventListener('click', () => {
        leerTexto(txtdobv.value);
});

function leerTexto(txtdobv){
    const speeche = new SpeechSynthesisUtterance();
    speeche.text= txtdobv;
    speeche.volume=1;
    speeche.rate=1;
    speeche.pitch=0;
    window.speechSynthesis.speak(speeche);
}

     let obsedosre = new webkitSpeechRecognition();
      obsedosre.lang = "es-ES";
      obsedosre.continuous = true;
      obsedosre.interimResults = false;

      obsedosre.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtdobv.value += frase;
      }

      obsedosg.addEventListener('click', () => {
        obsedosre.start();
      });

      vacs.addEventListener('click', () => {
        obsedosre.abort();
      });
</script>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="container">
  <div class="row">
    <div class="col-sm">  
    <p style = "font-family:arial; font-size:14px;">
       <strong>RECOMENDACIONES :</strong><br>
       1.-El servicio clinico debera mantener la unidad en temperaturas y condiciones adecuadas que aseguren su viabilidad.<br>
       2.-Antes de cada transfusión debera verificarse la identidad del receptor y de la unidad designada para este.<br>
       3.-No se debera agregar a la unidad ningun medicamento o solución, incluso las destinadas para uso intravenoso, con excepción de solución salina al 0.9% cuando asi sea necesario.<br>
       4.-La transfusión de cada unidad no debera exceder de 4 horas.<br>
       5.-Los filtros deberán cambiarse cada 6 hrs. O cuando hubiesen transfundido 4 unidades.<br>
       6.-De presentarse una reacción transfucional,suspender inmediatamente la transfución, notificar al medico encargado y reportar al banco de sangre, siguiendo las instrucciones señaladas en el formato de reporte que acompaña a la unidad.<br>
       7.-En caso de no transfundir la unidad, regresarla al banco de sangre o servicio de transfusión preferentemente antes de transcurridas 2 horas a partir de que la unidad salio del banco de sangre o del servicio de transfusión.  
   <hr>  
    </div>
  </div> 
  
</div>

</div>
<hr>

<div class="container">
  <div class="row">
              <div class="col-sm"> <center>
<button type="submit" class="btn btn-primary">Firmar</button>
<button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
         </div>   </center>      
</div>
</div>

<p><br>
                        <br>
                        </form>
</div> <!--TERMINO DE div container-->
    </p>
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





</body>
</html>