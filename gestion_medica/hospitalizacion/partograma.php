<?php
session_start();
include "../../conexionbd.php";
include("../header_medico.php");
$resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE dat_ingreso.area='EGRESO DE URGENCIAS'") or die($conexion->error);
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!--  Bootstrap  -->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

  <script src="../../js/jquery-3.3.1.min.js"></script>
  <script src="../../js/jquery-ui.js"></script>
  <script src="../../js/popper.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/jquery.magnific-popup.min.js"></script>
  <script src="../../js/aos.js"></script>
  <script src="../../js/main.js"></script>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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
  <title>Menu Gestión Médica </title>
  <link rel="shortcut icon" href="logp.png">
</head>
<div class="container">
</div>

<body>
<div class="container">
  <div class="row">
    <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>PARTOGRAMA</center></strong>
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
  </div>
</div>
  <?php
  
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

     


  $id_atencion = $_SESSION['hospital'];


  $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.fecha, di.area, di.alta_med, p.sexo, p.tip_san  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

  $result_pac = $conexion->query($sql_pac);

  while ($row_pac = $result_pac->fetch_assoc()) {
    $pac_nom =  $row_pac['papell'] . ' ' . $row_pac['sapell'] . ' ' . $row_pac['nom_pac'];
    $pac_fecnac = $row_pac['fecnac'];
    $pac_fecnac1 = '"' . $row_pac['fecnac'] . '"';
    $pac_fecing = $row_pac['fecha'];
    $area = $row_pac['area'];
    $alta_med = $row_pac['alta_med'];
    $exp = $row_pac['Id_exp'];
    $sexo = $row_pac['sexo'];
    $tipo_sang = $row_pac['tip_san'];
  }

  $date = date_create($pac_fecnac);
  $edad = calculaedad($pac_fecnac);

  $usuario = $_SESSION['login'];
  $usuario2 = $usuario['id_usua'];
  if ($sexo == "Mujer" || $sexo == "MUJER") {
  ?>
    <section class="content container-fluid">
      <div class="container box">
        <div class="content">
          <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-sm">
                <label for="hc_ges"><button type="button" class="btn btn-success btn-sm" id="play"><i class="fas fa-play"></button></i> Gesta</label><br>
                <input type="number" value="0" min="0" step="1"  name="gestaciones" id="gestaciones" required class="form-control">
<script type="text/javascript">
const gestaciones = document.getElementById('gestaciones');
const btnPlayTextg = document.getElementById('play');

btnPlayTextg.addEventListener('click', () => {
        leerTexto(gestaciones.value);
});

function leerTexto(gestaciones){
    const speech = new SpeechSynthesisUtterance();
    speech.text= gestaciones;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              </div>
              <div class="col-sm">
                <label for="hc_par"><button type="button" class="btn btn-success btn-sm" id="playpaa"><i class="fas fa-play"></button></i> Partos</label><br>
                <input type="number" value="0" min="0" step="1" name="partos"  id="partos" required class="form-control">
<script type="text/javascript">
const partos = document.getElementById('partos');
const btnPlayTextp = document.getElementById('playpaa');

btnPlayTextp.addEventListener('click', () => {
        leerTexto(partos.value);
});

function leerTexto(partos){
    const speech = new SpeechSynthesisUtterance();
    speech.text= partos;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              </div>
              <div class="col-sm">
                <label for="hc_ces"><button type="button" class="btn btn-success btn-sm" id="playpacc"><i class="fas fa-play"></button></i> Cesáreas</label><br>
                <input type="number" min="0" value="0" step="1"  name="cesareas" id="cesareas" required class="form-control">
<script type="text/javascript">
const cesareas = document.getElementById('cesareas');
const btnPlaycs = document.getElementById('playpacc');

btnPlaycs.addEventListener('click', () => {
        leerTexto(cesareas.value);
});

function leerTexto(cesareas){
    const speech = new SpeechSynthesisUtterance();
    speech.text= cesareas;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              </div>
              <div class="col-sm">
                <label for="hc_abo"><button type="button" class="btn btn-success btn-sm" id="playab"><i class="fas fa-play"></button></i> Abortos</label><br>
                <input type="number" min="0" value="0" step="1"  name="abortos" id="abortos" required class="form-control">
                <script type="text/javascript">
const abortos = document.getElementById('abortos');
const btnPlaytos = document.getElementById('playab');

btnPlaytos.addEventListener('click', () => {
        leerTexto(abortos.value);
});

function leerTexto(abortos){
    const speech = new SpeechSynthesisUtterance();
    speech.text= abortos;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              </div>
              <div class="col-sm">
                <label for="hc_fechafur">Fecha última regla</label><br>
                <input type="date" min="0" step="1" name="fur" id="fur" required class="form-control">

              </div>
            </div>
            <p>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="no_hijos"><button type="button" class="btn btn-success btn-sm" id="playhijos"><i class="fas fa-play"></button></i>  No. de hijos vivos: </label><br>
                  <input type="number" min="0" value="0" step="1" name="no_hijos" id="no_hijos" class="form-control">
                </div>
              </div>
<script type="text/javascript">
const no_hijos = document.getElementById('no_hijos');
const btnPlanoh = document.getElementById('playhijos');

btnPlanoh.addEventListener('click', () => {
        leerTexto(no_hijos.value);
});

function leerTexto(no_hijos){
    const speech = new SpeechSynthesisUtterance();
    speech.text= no_hijos;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="malformaciones"><button type="button" class="btn btn-success btn-sm" id="playmalfo"><i class="fas fa-play"></button></i> Malformados: </label><br>
                  <input type="number" min="0" value="0" step="1" name="malformaciones" id="malformaciones" class="form-control">
                </div>
              </div>
<script type="text/javascript">
const malformaciones = document.getElementById('malformaciones');
const btnPlaciomal = document.getElementById('playmalfo');

btnPlaciomal.addEventListener('click', () => {
        leerTexto(malformaciones.value);
});

function leerTexto(malformaciones){
    const speech = new SpeechSynthesisUtterance();
    speech.text= malformaciones;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="f_ucesarea">Fecha de último parto cesárea: </label><br>
                  <input type="date" name="f_ucesarea" id="f_ucesarea" class="form-control">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fpp">Fecha de probable parto: </label><br>
                  <input type="date" min="0" step="1" name="fpp" id="fpp"  required class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="sem_gestacion"><button type="button" class="btn btn-success btn-sm" id="playemcsg"><i class="fas fa-play"></button></i> Embarazo actual-semanas gestación: </label><br>
                  <input type="number" min="0" step="0.1" max="50" name="sem_gestacion" id="sem_gestacion" required class="form-control">
                </div>
              </div>
            </div>
<script type="text/javascript">
const sem_gestacion = document.getElementById('sem_gestacion');
const btnPlacsema = document.getElementById('playemcsg');

btnPlacsema.addEventListener('click', () => {
        leerTexto(sem_gestacion.value);
});

function leerTexto(sem_gestacion){
    const speech = new SpeechSynthesisUtterance();
    speech.text= sem_gestacion;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>

            <?php
            if ($tipo_sang == "NO ESPECIFICADO") {
            ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Tipo de sangre:</label>
                    <select id="tip_san" class="form-control" name="tip_san" required>
                      <option value="">Seleccionar tipo de sangre</option>
                      <option value="O Rh(-)">O Rh(-)</option>
                      <option value="O Rh(+)">O Rh(+)</option>
                      <option value="A Rh(-)">A Rh(-)</option>
                      <option value="A Rh(+)">A Rh(+)</option>
                      <option value="B Rh(-)">B Rh(-)</option>
                      <option value="B Rh(+)">B Rh(+)</option>
                      <option value="AB Rh(-)">AB Rh(-)</option>
                      <option value="AB Rh(+)">AB Rh(+)</option>
                      <option value="NO ESPECIFICADO">No especificado</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="no_consultas">No. de consultas: </label><br>
                    <input type="number" min="0" step="1" value="0" max="50" name="no_consultas" id="no_consultas" required class="form-control">
                  </div>
                </div>
              </div>

            <?php
            } else {
            ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="no_consultas"><button type="button" class="btn btn-success btn-sm" id="playnoc"><i class="fas fa-play"></button></i> No. de consultas: </label><br>
                  <input type="number" min="0" step="1" value="0" max="50" name="no_consultas"  id="no_consultas" required class="form-control">
                </div>
              </div>
            </div>
<script type="text/javascript">
const no_consultas = document.getElementById('no_consultas');
const btnPlacsemac = document.getElementById('playnoc');

btnPlacsemac.addEventListener('click', () => {
        leerTexto(no_consultas.value);
});

function leerTexto(no_consultas){
    const speech = new SpeechSynthesisUtterance();
    speech.text= no_consultas;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
            <?php
            }
            ?>
<div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="c_perinatal">Control perinatal: </label><br>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="c_perinatal" id="c_perinatal1" value="NO" checked required>
                    <label class="form-check-label" for="exampleRadios1">
                      No
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="c_perinatal" id="c_perinatal2" value="SI">
                    <label class="form-check-label" for="exampleRadios2">
                      Si
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="unidad"><button type="button" class="btn btn-success btn-sm" id="playunidaaa"><i class="fas fa-play"></button></i> Unidad</label><br>
                  <input type="text" min="0" step="1" max="50" name="unidad" id="unidad" onkeypress="return SoloLetras(event);" class="form-control">
                </div>
              </div>
            </div>
</div>
<script type="text/javascript">
const unidad = document.getElementById('unidad');
const btnPlacdadun = document.getElementById('playunidaaa');

btnPlacdadun.addEventListener('click', () => {
        leerTexto(unidad.value);
});

function leerTexto(unidad){
    const speech = new SpeechSynthesisUtterance();
    speech.text= unidad;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="lab_prev">Laboratorios previos: </label><div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playlpre"><i class="fas fa-play"></button></i>
</div> 
<textarea class="form-control" rows="3" cols="100" name="lab_prev" id="texto"></textarea>
<script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btnPlacdrecpe = document.getElementById('playlpre');

btnPlacdrecpe.addEventListener('click', () => {
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
        
            <div class="col-md-12">
              <label for="complicaciones_actual">Complicaciones del embarazo actual:</label></strong>
              <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="comg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="embs"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playcomdemac"><i class="fas fa-play"></button></i>
</div> 
<textarea class="form-control" rows="3" cols="100" name="complicaciones_actual" id="txt"></textarea>
<script type="text/javascript">
const comg = document.getElementById('comg');
const embs = document.getElementById('embs');
const txt = document.getElementById('txt');

const btnPlacdamcuad = document.getElementById('playcomdemac');

btnPlacdamcuad.addEventListener('click', () => {
        leerTexto(txt.value);
});

function leerTexto(txt){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txt;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let rea = new webkitSpeechRecognition();
      rea.lang = "es-ES";
      rea.continuous = true;
      rea.interimResults = false;

      rea.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txt.value += frase;
      }

      comg.addEventListener('click', () => {
        rea.start();
      });

      embs.addEventListener('click', () => {
        rea.abort();
      });
</script>
            </div>
            <div class="col-md-12">
              <label for="tratamiento">Tratamiento:</label></strong>
               <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="trag"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="entos"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playtarue"><i class="fas fa-play"></button></i>
</div> 
              <textarea class="form-control" rows="3" cols="100" name="tratamiento" id="txttre"></textarea>
<script type="text/javascript">
const trag = document.getElementById('trag');
const entos = document.getElementById('entos');
const txttre = document.getElementById('txttre');

const btnPlacmiento = document.getElementById('playtarue');

btnPlacmiento.addEventListener('click', () => {
        leerTexto(txttre.value);
});

function leerTexto(txttre){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txttre;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let reta = new webkitSpeechRecognition();
      reta.lang = "es-ES";
      reta.continuous = true;
      reta.interimResults = false;

      reta.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txttre.value += frase;
      }

      trag.addEventListener('click', () => {
        reta.start();
      });

      entos.addEventListener('click', () => {
        reta.abort();
      });
</script>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="c_uterina"><button type="button" class="btn btn-success btn-sm" id="playcontrau"><i class="fas fa-play"></button></i> Contractilidad uterina: </label><br>
                <input type="text" name="c_uterina" id="c_uterina" class="form-control">
<script type="text/javascript">
const c_uterina = document.getElementById('c_uterina');
const btnPlacnatil = document.getElementById('playcontrau');

btnPlacnatil.addEventListener('click', () => {
        leerTexto(c_uterina.value);
});

function leerTexto(c_uterina){
    const speech = new SpeechSynthesisUtterance();
    speech.text= c_uterina;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

</script>
                <label for="c_uterina">Inicia en 10 min.</label><br>
              </div>
            </div>
          </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="sangrado_tv">Sangrado trasversal: </label><br>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sangrado_tv" id="sangrado_tv1" value="NO" checked>
                    <label class="form-check-label" for="sangrado_tv">
                      No
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sangrado_tv" id="sangrado_tv2" value="SI">
                    <label class="form-check-label" for="sangrado_tv">
                      Si
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fecha_inicio">Inicio fecha</label><br>
                      <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="hora_inicio">Hora</label><br>
                      <input type="time" name="hora_inicio" id="hora_inicio" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="r_p_m">Ruptura prematura de membranas: </label><br>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="r_p_m" id="r_p_m1" value="NO" checked>
                    <label class="form-check-label" for="r_p_m1">
                      No
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="r_p_m" id="r_p_m2" value="SI">
                    <label class="form-check-label" for="r_p_m2">
                      Si
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fecha_rpm">Fecha</label><br>
                      <input type="date" name="fecha_rpm" id="fecha_rpm" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="hora_rpm">Hora</label><br>
                      <input type="time" name="hora_rpm" id="hora_rpm" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="no_consultas_urg"><button type="button" class="btn btn-success btn-sm" id="playconurga"><i class="fas fa-play"></button></i> No. de consulta de urgencias: </label><br>
                  <input type="number" min="0" step="1" max="50" name="no_consultas_urg" id="no_consultas_urg" required class="form-control">
                </div>
              </div>
<script type="text/javascript">
const no_consultas_urg = document.getElementById('no_consultas_urg');
const btnPlanodegen = document.getElementById('playconurga');
btnPlanodegen.addEventListener('click', () => {
        leerTexto(no_consultas_urg.value);
});

function leerTexto(no_consultas_urg){
    const speech = new SpeechSynthesisUtterance();
    speech.text= no_consultas_urg;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

</script>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="motilidad">Motilidad fetal: </label><br>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="motilidad" id="motilidad1" value="NO" checked>
                    <label class="form-check-label" for="motilidad">
                      No
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="motilidad" id="motilidad2" value="SI">
                    <label class="form-check-label" for="motilidad">
                      Si
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="dism"><button type="button" class="btn btn-success btn-sm" id="playdism"><i class="fas fa-play"></button></i> Dism: </label><br>
                  <input type="text" name="dism" id="dism" class="form-control">
                </div>
              </div>
<script type="text/javascript">
const dism = document.getElementById('dism');
const btnPlanmsid = document.getElementById('playdism');
btnPlanmsid.addEventListener('click', () => {
        leerTexto(dism.value);
});

function leerTexto(dism){
    const speech = new SpeechSynthesisUtterance();
    speech.text= dism;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

</script>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="nl"><button type="button" class="btn btn-success btn-sm" id="playnls"><i class="fas fa-play"></button></i> Nl: </label><br>
                  <input type="text" name="nl" id="nl" class="form-control">
                </div>
              </div>
            </div>
<script type="text/javascript">
const nl = document.getElementById('nl');
const btnPlanlddl = document.getElementById('playnls');
btnPlanlddl.addEventListener('click', () => {
        leerTexto(nl.value);
});

function leerTexto(nl){
    const speech = new SpeechSynthesisUtterance();
    speech.text= nl;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

</script>
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
    
      
    
    <div class="col-sm-3"><br><center><button type="button" class="btn btn-success btn-sm" id="playpresart2"><i class="fas fa-play"></button></i> Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" id="txtpsistol1" value="<?php echo $f5['p_sistol'];?>" disabled></div> /
  <div class="col"><input type="text" class="form-control" value="<?php echo $f5['p_diastol'];?>" id="txtdias2tol" disabled></div>
<script type="text/javascript">
const txtpsistol1 = document.getElementById('txtpsistol1');
const btnPlanartpres = document.getElementById('playpresart2');
btnPlanartpres.addEventListener('click', () => {
        leerTexto(txtpsistol1.value);
});

function leerTexto(txtpsistol1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtpsistol1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

const txtdias2tol = document.getElementById('txtdias2tol');
const btnPlanartpres2 = document.getElementById('playpresart2');
btnPlanartpres2.addEventListener('click', () => {
        leerTexto(txtdias2tol.value);
});

function leerTexto(txtdias2tol){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtdias2tol;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
</div>mmHG / mmHG
    </div>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="playdref"><i class="fas fa-play"></button></i> Frecuencia cardiaca:<input type="text" class="form-control" id="fretxtc" value="<?php echo $f5['fcard'];?>" disabled>Latidos por minuto
<script type="text/javascript">
const fretxtc = document.getElementById('fretxtc');
const btnPlaypafc = document.getElementById('playdref');
btnPlaypafc.addEventListener('click', () => {
        leerTexto(fretxtc.value);
});

function leerTexto(fretxtc){
    const speech = new SpeechSynthesisUtterance();
    speech.text= fretxtc;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    </div>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="playressf"><i class="fas fa-play"></button></i> Frecuencia respiratoria:<input type="text" id="txftx" class="form-control" value="<?php echo $f5['fresp'];?>" disabled>Respiraciones por minuto
<script type="text/javascript">
const txftx = document.getElementById('txftx');
const btnPlayfrerespiratora = document.getElementById('playressf');
btnPlayfrerespiratora.addEventListener('click', () => {
        leerTexto(txftx.value);
});

function leerTexto(txftx){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txftx;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    </div>
    <div class="col-sm-2">
     <br><button type="button" class="btn btn-success btn-sm" id="playtemti"><i class="fas fa-play"></button></i> Temperatura:<input type="text" class="form-control" id="ttemptx" value="<?php echo $f5['temper'];?>" disabled>°C
    </div>
   <script type="text/javascript">
const ttemptx = document.getElementById('ttemptx');
const btnPtemper = document.getElementById('playtemti');
btnPtemper.addEventListener('click', () => {
        leerTexto(ttemptx.value);
});

function leerTexto(ttemptx){
    const speech = new SpeechSynthesisUtterance();
    speech.text= ttemptx;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
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
    <div class="col-sm-2"><br><center><button type="button" class="btn btn-success btn-sm" id="playpresart2"><i class="fas fa-play"></button></i>  Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" name="p_sistolica" ></div> /
  <div class="col"><input type="text" class="form-control" name="p_diastolica"></div>
 <script type="text/javascript">
const txtpsistol1 = document.getElementById('txtpsistol1');
const btnPlanartpres = document.getElementById('playpresart2');
btnPlanartpres.addEventListener('click', () => {
        leerTexto(txtpsistol1.value);
});

function leerTexto(txtpsistol1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtpsistol1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

const txtdias2tol = document.getElementById('txtdias2tol');
const btnPlanartpres2 = document.getElementById('playpresart2');
btnPlanartpres2.addEventListener('click', () => {
        leerTexto(txtdias2tol.value);
});

function leerTexto(txtdias2tol){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtdias2tol;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
</div>mmHG / mmHG
    </div>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="playdref"><i class="fas fa-play"></button></i> Frecuencia cardiaca:<input type="text" class="form-control" name="f_card">
    </div>Latidos por minuto
<script type="text/javascript">
const fretxtc = document.getElementById('fretxtc');
const btnPlaypafc = document.getElementById('playdref');
btnPlaypafc.addEventListener('click', () => {
        leerTexto(fretxtc.value);
});

function leerTexto(fretxtc){
    const speech = new SpeechSynthesisUtterance();
    speech.text= fretxtc;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="playressf"><i class="fas fa-play"></button></i>  Frecuencia respiratoria:<input type="text" class="form-control" name="f_resp">
    </div>Respiraciones por minuto
    <script type="text/javascript">
const txftx = document.getElementById('txftx');
const btnPlayfrerespiratora = document.getElementById('playressf');
btnPlayfrerespiratora.addEventListener('click', () => {
        leerTexto(txftx.value);
});

function leerTexto(txftx){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txftx;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
     <br><button type="button" class="btn btn-success btn-sm" id="playtemti"><i class="fas fa-play"></button></i> Temperatura:<input type="text" class="form-control"  name="temp">
    </div>°C
   <script type="text/javascript">
const ttemptx = document.getElementById('ttemptx');
const btnPtemper = document.getElementById('playtemti');
btnPtemper.addEventListener('click', () => {
        leerTexto(ttemptx.value);
});

function leerTexto(ttemptx){
    const speech = new SpeechSynthesisUtterance();
    speech.text= ttemptx;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  </div>
</div>

<?php } ?>
<hr>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="edema"><button type="button" class="btn btn-success btn-sm" id="playedemaaa"><i class="fas fa-play"></button></i> Edema: </label><br>
                  <input type="text" name="edema"  id="edema"  class="form-control">
                </div>
              </div>
            </div>
<script type="text/javascript">
const edema = document.getElementById('edema');
const btnPmaed = document.getElementById('playedemaaa');
btnPmaed.addEventListener('click', () => {
        leerTexto(edema.value);
});

function leerTexto(edema){
    const speech = new SpeechSynthesisUtterance();
    speech.text= edema;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
            <div class="row">
              <div class="col-md-4">
                <center>
                  <label><button type="button" class="btn btn-success btn-sm" id="playalutro"><i class="fas fa-play"></button></i>Altura de utero. : </label><br>
                  <select class="form-control" name="a_utero" id="a_utero" required>
                    <option value="16">16</option>
                    <option value="18">18</option>
                    <option value="20">20</option>
                    <option value="22">22</option>
                    <option value="24">24</option>
                    <option value="26">26</option>
                    <option value="28">28</option>
                    <option value="30">30</option>
                  </select>
                  <img src="../../img/altura_utero.jpeg" width="200px" />
                </center>
              </div>
<script type="text/javascript">
const a_utero = document.getElementById('a_utero');
const btnPmrout = document.getElementById('playalutro');
btnPmrout.addEventListener('click', () => {
        leerTexto(a_utero.value);
});

function leerTexto(a_utero){
    const speech = new SpeechSynthesisUtterance();
    speech.text= a_utero;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              <div class="col-md-4">
                <center>
                  <label>Dilatación y posición : </label><br>
                  <img src="../../img/dilatacion_pocision.jpeg" width="200px" />
                </center>
              </div>

              <div class="col-md-4">
                <center>
                  <label for="altura_p">Altura de la presentación: </label><br>
                  <img src="../../img/altura_presentacion.jpg" width="200px" />
                </center>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fcf"><button type="button" class="btn btn-success btn-sm" id="playfetalcar"><i class="fas fa-play"></button></i> Frecuencia cardiaca fetal: </label><br>
                  <input type="number" min="0" step="1" name="fcf" id="fcf" required class="form-control">
                </div>
              </div>
<script type="text/javascript">
const fcf = document.getElementById('fcf');
const btnffcff = document.getElementById('playfetalcar');
btnffcff.addEventListener('click', () => {
        leerTexto(fcf.value);
});

function leerTexto(fcf){
    const speech = new SpeechSynthesisUtterance();
    speech.text= fcf;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="ritmo"><button type="button" class="btn btn-success btn-sm" id="playritmm"><i class="fas fa-play"></button></i>  Rítmo: </label><br>
                  <input type="text" name="ritmo" id="fritmocf" class="form-control">
                </div>
              </div>
<script type="text/javascript">
const fritmocf = document.getElementById('fritmocf');
const btnriam = document.getElementById('playritmm');
btnriam.addEventListener('click', () => {
        leerTexto(fritmocf.value);
});

function leerTexto(fritmocf){
    const speech = new SpeechSynthesisUtterance();
    speech.text= fritmocf;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tono_u"><button type="button" class="btn btn-success btn-sm" id="playrtonut"><i class="fas fa-play"></button></i> Tono uterino: </label><br>
                  <input type="text" name="tono_u" id="tono_u" class="form-control">
                </div>
              </div>
            </div>
<script type="text/javascript">
const tono_u = document.getElementById('tono_u');
const btnrurit = document.getElementById('playrtonut');
btnrurit.addEventListener('click', () => {
        leerTexto(tono_u.value);
});

function leerTexto(tono_u){
    const speech = new SpeechSynthesisUtterance();
    speech.text= tono_u;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="membranas"><button type="button" class="btn btn-success btn-sm" id="playmemin"><i class="fas fa-play"></button></i> Membranas integras: </label><br>
                  <input type="text" name="membranas" id="membranas" class="form-control">
<script type="text/javascript">
const membranas = document.getElementById('membranas');
const btnrnasmem = document.getElementById('playmemin');
btnrnasmem.addEventListener('click', () => {
        leerTexto(membranas.value);
});

function leerTexto(membranas){
    const speech = new SpeechSynthesisUtterance();
    speech.text= membranas;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="rotas"><button type="button" class="btn btn-success btn-sm" id="playrotasss"><i class="fas fa-play"></button></i> Rotas: </label><br>
                  <input type="text" name="rotas" id="rotas" class="form-control">
                </div>
              </div>
              <script type="text/javascript">
const rotas = document.getElementById('rotas');
const btnrntas = document.getElementById('playrotasss');
btnrntas.addEventListener('click', () => {
        leerTexto(rotas.value);
});

function leerTexto(rotas){
    const speech = new SpeechSynthesisUtterance();
    speech.text= rotas;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="aspecto_la"><button type="button" class="btn btn-success btn-sm" id="playraspliam"><i class="fas fa-play"></button></i> Aspecto del liquido amniotico L.A: </label><br>
                  <input type="text" name="aspecto_la" id="aspecto_la" class="form-control">
                </div>
              </div>
            </div>
      <script type="text/javascript">
const aspecto_la = document.getElementById('aspecto_la');
const btnrnnitoanmi = document.getElementById('playraspliam');
btnrnnitoanmi.addEventListener('click', () => {
        leerTexto(aspecto_la.value);
});

function leerTexto(aspecto_la){
    const speech = new SpeechSynthesisUtterance();
    speech.text= aspecto_la;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cervix"><button type="button" class="btn btn-success btn-sm" id="playceviz"><i class="fas fa-play"></button></i> Cervix:borramiento: </label><br>
                  <input type="text" name="cervix" id="cervix" class="form-control">
                </div>
              </div>
<script type="text/javascript">
const cervix = document.getElementById('cervix');
const btnrxvix = document.getElementById('playceviz');
btnrxvix.addEventListener('click', () => {
        leerTexto(cervix.value);
});

function leerTexto(cervix){
    const speech = new SpeechSynthesisUtterance();
    speech.text= cervix;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="dilatacion"><button type="button" class="btn btn-success btn-sm" id="playdilan"><i class="fas fa-play"></button></i> Dilatación: </label><br>
                  <select class="form-control" name="dilatacion_p" required id="dilatacion_p">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                  </select>
                </div>
              </div>
<script type="text/javascript">
const dilatacion_p = document.getElementById('dilatacion_p');
const btnrxtaciondi = document.getElementById('playdilan');
btnrxtaciondi.addEventListener('click', () => {
        leerTexto(dilatacion_p.value);
});

function leerTexto(dilatacion_p){
    const speech = new SpeechSynthesisUtterance();
    speech.text= dilatacion_p;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="presentacion"><button type="button" class="btn btn-success btn-sm" id="playdtapre"><i class="fas fa-play"></button></i> Presentación: </label><br>
                  <select class="form-control" name="altura_p" required id="prestxt">
                    <option value="I">I</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
                    <option value="IV">IV</option>
                  </select>
                </div>
              </div>
            </div>
<script type="text/javascript">
const prestxt = document.getElementById('prestxt');
const btnrxpress = document.getElementById('playdtapre');
btnrxpress.addEventListener('click', () => {
        leerTexto(prestxt.value);
});

function leerTexto(prestxt){
    const speech = new SpeechSynthesisUtterance();
    speech.text= prestxt;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="pelvis"><button type="button" class="btn btn-success btn-sm" id="playdlisp"><i class="fas fa-play"></button></i> Pelvis</label><br>
                  <input type="text" name="pelvis" id="pelvis" class="form-control">
                </div>
              </div>
<script type="text/javascript">
const pelvis = document.getElementById('pelvis');
const btnrxpelvz = document.getElementById('playdlisp');
btnrxpelvz.addEventListener('click', () => {
        leerTexto(pelvis.value);
});

function leerTexto(pelvis){
    const speech = new SpeechSynthesisUtterance();
    speech.text= pelvis;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="util"><button type="button" class="btn btn-success btn-sm" id="playduti"><i class="fas fa-play"></button></i> Útil: </label><br>
                  <input type="text" name="util" id="util" class="form-control">
                </div>
              </div>
<script type="text/javascript">
const util = document.getElementById('util');
const btnrxtil = document.getElementById('playduti');
btnrxtil.addEventListener('click', () => {
        leerTexto(util.value);
});

function leerTexto(util){
    const speech = new SpeechSynthesisUtterance();
    speech.text= util;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="no_util"><button type="button" class="btn btn-success btn-sm" id="playdnolad"><i class="fas fa-play"></button></i> No útil: </label><br>
                  <input type="text" name="no_util" id="no_util" class="form-control">
                </div>
              </div>
            </div>
<script type="text/javascript">
const no_util = document.getElementById('no_util');
const btnrxtilno = document.getElementById('playdnolad');
btnrxtilno.addEventListener('click', () => {
        leerTexto(no_util.value);
});

function leerTexto(no_util){
    const speech = new SpeechSynthesisUtterance();
    speech.text= no_util;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<div class="row">
            <div class="col-md-12">
              <label for="impresion_diag">Impresión diagnóstica:</label></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="img"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="pres"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playdimmmas"><i class="fas fa-play"></button></i>
</div> 
<textarea class="form-control" rows="3" cols="100" name="impresion_diag" id="txtid"></textarea>
<script type="text/javascript">
const img = document.getElementById('img');
const pres = document.getElementById('pres');
const txtid = document.getElementById('txtid');

const btnrxtilnoa = document.getElementById('playdimmmas');
btnrxtilnoa.addEventListener('click', () => {
        leerTexto(txtid.value);
});

function leerTexto(txtid){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtid;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let reid = new webkitSpeechRecognition();
      reid.lang = "es-ES";
      reid.continuous = true;
      reid.interimResults = false;

      reid.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtid.value += frase;
      }

      img.addEventListener('click', () => {
        reid.start();
      });

      pres.addEventListener('click', () => {
        reid.abort();
      });
</script>
            </div>

            <div class="col-md-12">
              <label for="plan_t">Plan de tratamiento:</label></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="pdtg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="andos"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="plapptr"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" rows="3" cols="100" name="plan_t" id="txtpl"></textarea>
<script type="text/javascript">
const pdtg = document.getElementById('pdtg');
const andos = document.getElementById('andos');
const txtpl = document.getElementById('txtpl');

const bttra = document.getElementById('plapptr');
bttra.addEventListener('click', () => {
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

     let repdtd = new webkitSpeechRecognition();
      repdtd.lang = "es-ES";
      repdtd.continuous = true;
      repdtd.interimResults = false;

      repdtd.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtpl.value += frase;
      }

      pdtg.addEventListener('click', () => {
        repdtd.start();
      });

      andos.addEventListener('click', () => {
        repdtd.abort();
      });
</script>
            </div>
          </div>
            <br>
            <center>
              <div class="col-sm-4">
                <input type="submit" name="btnpartograma" class="btn btn-block btn-success" value="Firmar y guardar">
              </div>
            </center>
          </form>
        </div>
      </div>
      <?php
      if (isset($_POST['btnpartograma'])) {
$gestaciones = mysqli_real_escape_string($conexion, (strip_tags($_POST["gestaciones"],ENT_QUOTES))); //Escanpando caracteres
        $partos = mysqli_real_escape_string($conexion, (strip_tags($_POST["partos"], ENT_QUOTES))); //Escanpando caracteres
        $cesareas = mysqli_real_escape_string($conexion, (strip_tags($_POST["cesareas"], ENT_QUOTES))); //Escanpando caracteres
        $abortos = mysqli_real_escape_string($conexion, (strip_tags($_POST["abortos"], ENT_QUOTES))); //Escanpando caracteres
        $fur = mysqli_real_escape_string($conexion, (strip_tags($_POST["fur"], ENT_QUOTES))); //Escanpando caracteres
        $no_hijos = mysqli_real_escape_string($conexion, (strip_tags($_POST["no_hijos"], ENT_QUOTES))); //Escanpando caracteres
        $malformaciones = mysqli_real_escape_string($conexion, (strip_tags($_POST["malformaciones"], ENT_QUOTES))); //Escanpando caracteres
        $f_ucesarea = mysqli_real_escape_string($conexion, (strip_tags($_POST["f_ucesarea"], ENT_QUOTES))); //Escanpando caracteres
        $fpp = mysqli_real_escape_string($conexion, (strip_tags($_POST["fpp"], ENT_QUOTES))); //Escanpando caracteres
        $sem_gestacion = mysqli_real_escape_string($conexion, (strip_tags($_POST["sem_gestacion"], ENT_QUOTES))); //Escanpando caracteres
        $no_consultas = mysqli_real_escape_string($conexion, (strip_tags($_POST["no_consultas"], ENT_QUOTES))); //Escanpando caracteres
        $c_perinatal = mysqli_real_escape_string($conexion, (strip_tags($_POST["c_perinatal"], ENT_QUOTES))); //Escanpando caracteres
        $lab_prev = mysqli_real_escape_string($conexion, (strip_tags($_POST["lab_prev"], ENT_QUOTES))); //Escanpando caracteres
        $complicaciones_actual = mysqli_real_escape_string($conexion, (strip_tags($_POST["complicaciones_actual"], ENT_QUOTES))); //Escanpando caracteres
        $tratamiento = mysqli_real_escape_string($conexion, (strip_tags($_POST["tratamiento"], ENT_QUOTES))); //Escanpando caracteres
        $c_uterina = mysqli_real_escape_string($conexion, (strip_tags($_POST["c_uterina"], ENT_QUOTES))); //Escanpando caracteres
        $sangrado_tv = mysqli_real_escape_string($conexion, (strip_tags($_POST["sangrado_tv"], ENT_QUOTES))); //Escanpando caracteres
        $r_p_m = mysqli_real_escape_string($conexion, (strip_tags($_POST["r_p_m"], ENT_QUOTES))); //Escanpando caracteres
        $no_consultas_urg = mysqli_real_escape_string($conexion, (strip_tags($_POST["no_consultas_urg"], ENT_QUOTES))); //Escanpando caracteres
        $motilidad = mysqli_real_escape_string($conexion, (strip_tags($_POST["motilidad"], ENT_QUOTES))); //Escanpando caracteres
        $dism = mysqli_real_escape_string($conexion, (strip_tags($_POST["dism"], ENT_QUOTES))); //Escanpando caracteres
        $nl = mysqli_real_escape_string($conexion, (strip_tags($_POST["nl"], ENT_QUOTES))); //Escanpando caracteres
        //$p_sistolica = mysqli_real_escape_string($conexion, (strip_tags($_POST["p_sistolica"], ENT_QUOTES))); //Escanpando caracteres
        //$p_diastolica = mysqli_real_escape_string($conexion, (strip_tags($_POST["p_diastolica"], ENT_QUOTES))); //Escanpando caracteres
        //$temp = mysqli_real_escape_string($conexion, (strip_tags($_POST["temp"], ENT_QUOTES))); //Escanpando caracteres
        //$f_card = mysqli_real_escape_string($conexion, (strip_tags($_POST["f_card"], ENT_QUOTES))); //Escanpando caracteres
        //$f_resp = mysqli_real_escape_string($conexion, (strip_tags($_POST["f_resp"], ENT_QUOTES))); //Escanpando caracteres
        $edema = mysqli_real_escape_string($conexion, (strip_tags($_POST["edema"], ENT_QUOTES))); //Escanpando caracteres
        $a_utero = mysqli_real_escape_string($conexion, (strip_tags($_POST["a_utero"], ENT_QUOTES))); //Escanpando caracteres
        $fcf = mysqli_real_escape_string($conexion, (strip_tags($_POST["fcf"], ENT_QUOTES))); //Escanpando caracteres
        $ritmo = mysqli_real_escape_string($conexion, (strip_tags($_POST["ritmo"], ENT_QUOTES))); //Escanpando caracteres
        $tono_u = mysqli_real_escape_string($conexion, (strip_tags($_POST["tono_u"], ENT_QUOTES))); //Escanpando caracteres
        $membranas = mysqli_real_escape_string($conexion, (strip_tags($_POST["membranas"], ENT_QUOTES))); //Escanpando caracteres
        $rotas = mysqli_real_escape_string($conexion, (strip_tags($_POST["rotas"], ENT_QUOTES))); //Escanpando caracteres
        $aspecto_la = mysqli_real_escape_string($conexion, (strip_tags($_POST["aspecto_la"], ENT_QUOTES))); //Escanpando caracteres
        $cervix = mysqli_real_escape_string($conexion, (strip_tags($_POST["cervix"], ENT_QUOTES))); //Escanpando caracteres
        $dilatacion_p = mysqli_real_escape_string($conexion, (strip_tags($_POST["dilatacion_p"], ENT_QUOTES))); //Escanpando caracteres
        $altura_p = mysqli_real_escape_string($conexion, (strip_tags($_POST["altura_p"], ENT_QUOTES))); //Escanpando caracteres
        $pelvis = mysqli_real_escape_string($conexion, (strip_tags($_POST["pelvis"], ENT_QUOTES))); //Escanpando caracteres
        $util = mysqli_real_escape_string($conexion, (strip_tags($_POST["util"], ENT_QUOTES))); //Escanpando caracteres
        $no_util = mysqli_real_escape_string($conexion, (strip_tags($_POST["no_util"], ENT_QUOTES))); //Escanpando caracteres
        $impresion_diag = mysqli_real_escape_string($conexion, (strip_tags($_POST["impresion_diag"], ENT_QUOTES))); //Escanpando caracteres
        $plan_t = mysqli_real_escape_string($conexion, (strip_tags($_POST["plan_t"], ENT_QUOTES))); //Escanpando caracteres
        $t_sang = mysqli_real_escape_string($conexion, (strip_tags($_POST["tip_san"], ENT_QUOTES))); //Escanpando caracteres
        

       
          $unidad = mysqli_real_escape_string($conexion, (strip_tags($_POST["unidad"], ENT_QUOTES))); 

        
          $fecha_inicio = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_inicio"], ENT_QUOTES))); //Escanpando caracteres
          $hora_inicio = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_inicio"], ENT_QUOTES))); //Escanpando caracteres
        

        
          $fecha_rpm = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_rpm"], ENT_QUOTES))); //Escanpando caracteres
          $hora_rpm = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_rpm"], ENT_QUOTES))); //Escanpando caracteres
       


$resultado6=$conexion->query("select * from signos_vitales WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_sig DESC LIMIT 1") or die($conexion->error);

     while ($f6 = mysqli_fetch_array($resultado6)) {
$p_sistolica=$f6['p_sistol'];
$p_diastolica=$f6['p_diastol'];
$temp=$f6['temper'];
$fc=$f6['fcard'];
$fr=$f6['fresp'];
     }

$sql_partograma=mysqli_query($conexion,'INSERT INTO partograma(id_atencion,fecha,gestas,f_ucesarea,partos,cesareas,abortos,fur,no_hijos,malformaciones,fpp,sem_gestacion,no_consultas,c_perinatal,unidad,lab_prev_rec,comp_emb_act,tratamiento,c_uterina,sang_tv,inicio_fecha,inicio_hora,rpm,fecha_rpm,hora_rpm,no_consul_urg,mot_fetal,dism,nl,p_sistolica,p_diastolica,temp,fc,fr,edema,alt_utero,fcf,ritmo,t_uterino,memb_int,rotas,asp_la,cervix,dilatacion,presentacion,pelvis,util,n_util,imp_diag,p_trat,id_usua) values (' . $id_atencion . ',Now(),' . $gestaciones . ',"' . $f_ucesarea . '",' . $partos . ',' . $cesareas . ',' . $abortos . ',"' . $fur . '",' . $no_hijos . ',' . $malformaciones . ',"' . $fpp . '",' . $sem_gestacion . ',' . $no_consultas . ',"' . $c_perinatal . '","' . $unidad . '","' . $lab_prev . '","' . $complicaciones_actual . '","' . $tratamiento . '","' . $c_uterina . '","' . $sangrado_tv . '","' . $fecha_inicio . '","' . $hora_inicio . '","' . $r_p_m . '","' . $fecha_rpm . '","' . $hora_rpm . '",' . $no_consultas_urg . ',"' . $motilidad . '","' . $dism . '","' . $nl . '","' . $p_sistolica . '","' . $p_diastolica . '","' . $temp . '","' . $fc . '","' . $fr . '","' . $edema . '",' . $a_utero . ',"' . $fcf . '","' . $ritmo . '","' . $tono_u . '","' . $membranas . '","' . $rotas . '","' . $aspecto_la . '","' . $cervix . '","' . $dilatacion_p . '","' . $altura_p . '","' . $pelvis . '","' . $util . '","' . $no_util . '","' . $impresion_diag . '","' . $plan_t . '",' . $usuario2 . ')')  or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

       // $sql_partograma = 'INSERT INTO partograma(id_atencion,gestas,f_ucesarea,partos,cesareas,abortos,fur,no_hijos,malformaciones,fpp,sem_gestacion,no_consultas,c_perinatal,unidad,lab_prev_rec,comp_emb_act,tratamiento,c_uterina,sang_tv,inicio_fecha,inicio_hora,rpm,fecha_rpm,hora_rpm,no_consul_urg,mot_fetal,dism,nl,p_sistolica,p_diastolica,temp,fc,fr, edema,alt_utero,fcf,ritmo,t_uterino,memb_int,rotas,asp_la,cervix,dilatacion,presentacion,pelvis,util,n_util,imp_diag,p_trat,id_usua)VALUES(' . $id_atencion . ',' . $gestaciones . ',"' . $f_ucesarea . '",' . $partos . ',' . $cesareas . ',' . $abortos . ',"' . $fur . '",' . $no_hijos . ',' . $malformaciones . ',"' . $fpp . '",' . $sem_gestacion . ',' . $no_consultas . ',"' . $c_perinatal . '","' . $unidad . '","' . $lab_prev . '","' . $complicaciones_actual . '","' . $tratamiento . '","' . $c_uterina . '","' . $sangrado_tv . '","' . $fecha_inicio . '","' . $hora_inicio . '","' . $r_p_m . '","' . $fecha_rpm . '","' . $hora_rpm . '",' . $no_consultas_urg . ',"' . $motilidad . '","' . $dism . '","' . $nl . '",' . $p_sistolica . ',' . $p_diastolica . ',' . $temp . ',' . $f_card . ',' . $f_resp . ',"' . $edema . '",' . $a_utero . ',"' . $fcf . '","' . $ritmo . '","' . $tono_u . '","' . $membranas . '","' . $rotas . '","' . $aspecto_la . '","' . $cervix . '","' . $dilatacion_p . '","' . $altura_p . '","' . $pelvis . '","' . $util . '","' . $no_util . '","' . $impresion_diag . '","' . $plan_t . '",' . $usuario2 . ')';

        //  echo $sql_partograma;
        $result_pac = $conexion->query($sql_partograma);

        if (isset($t_sang)) {
          $sql_sangre = 'UPDATE paciente set tip_san="' . $t_sang . '" WHERE Id_exp =' . $exp . ';';
          $result_sang = $conexion->query($sql_sangre);
        }

        echo '<script type="text/javascript"> window.location.href="../../template/menu_medico.php";</script>';
      }

      ?>
    </section>
    </div>

    <footer class="main-footer">
      <?php
      include("../../template/footer.php");
      ?>
    </footer>



  <?php
  } else {

    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "SOLO SE PERMITE SELECCIONAR MUJERES", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                                window.location.href = "../../template/menu_medico.php";
                            }
                        });
                    });
                </script>';
  }
  ?>


  <script>
    document.oncontextmenu = function() {
      return false;
    }
  </script>
  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>

</html>