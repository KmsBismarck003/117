<?php
session_start();
include "../../conexionbd.php";
include("../header_medico.php");


?>
<!DOCTYPE html>
<html>

<head>
     <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <link rel="stylesheet" type="text/css" href="../../css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="../../js/select2.js"></script>
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

<title>NOTA INTERVENCIÓN QUIRÚRGICA</title>
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
<strong><center>NOTA INTERVENCIÓN QUIRÚRGICA</center></strong>
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
      Expediente: <strong><?php echo $id_exp?> </strong>
    </div>
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm-4">
      Fecha de ingreso: <strong><?php echo date_format($date, "d-m-Y") ?></strong>
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
      Talla : <strong><?php echo $talla ?></strong>
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
<hr>

<div class="container">  <!--INICIO DE NOTAS QUIRÚRGICAS-->
  <form action="insertar_not_inquir.php" method="POST">
                
 
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

$resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_sig DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
     
    
    ?>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
<div class="container"> 
  <div class="row">   
    
    <div class="col-sm-3"><br><center><button type="button" class="btn btn-success btn-sm" id="pla1"><i class="fas fa-play"></button></i> Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" id="p_sistol" value="<?php echo $f5['p_sistol'];?>" disabled></div> /
  <div class="col"><input type="text" class="form-control" id="p_diastol" value="<?php echo $f5['p_diastol'];?>" disabled></div>
 
</div>
    </div>
<script type="text/javascript">
const p_sistol = document.getElementById('p_sistol');
const btnPlayTex1 = document.getElementById('pla1');
btnPlayTex1.addEventListener('click', () => {
        leerTexto(p_sistol.value);
});

function leerTexto(p_sistol){
    const speech = new SpeechSynthesisUtterance();
    speech.text= p_sistol;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
const p_diastol = document.getElementById('p_diastol');
const btnPlayTex11 = document.getElementById('pla1');
btnPlayTex11.addEventListener('click', () => {
        leerTexto(p_diastol.value);
});

function leerTexto(p_diastol){
    const speech = new SpeechSynthesisUtterance();
    speech.text= p_diastol;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="pla2"><i class="fas fa-play"></button></i> Frecuencia cardiaca:<input type="text" class="form-control" id="fcard" value="<?php echo $f5['fcard'];?>" disabled>
    </div>
<script type="text/javascript">
const fcard = document.getElementById('fcard');
const btnPlayTex2 = document.getElementById('pla2');
btnPlayTex2.addEventListener('click', () => {
        leerTexto(fcard.value);
});

function leerTexto(fcard){
    const speech = new SpeechSynthesisUtterance();
    speech.text= fcard;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="pla3"><i class="fas fa-play"></button></i>  Frecuencia respiratoria:<input type="text" id="fresp" class="form-control" value="<?php echo $f5['fresp'];?>" disabled>
    </div>
<script type="text/javascript">
const fresp = document.getElementById('fresp');
const btnPlayTex3 = document.getElementById('pla3');
btnPlayTex3.addEventListener('click', () => {
        leerTexto(fresp.value);
});

function leerTexto(fresp){
    const speech = new SpeechSynthesisUtterance();
    speech.text= fresp;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm-2">
     <br><button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i>  Temperatura:<input type="text" class="form-control" id="temper" value="<?php echo $f5['temper'];?>" disabled>
    </div>
<script type="text/javascript">
const temper = document.getElementById('temper');
const btnPlayTex4 = document.getElementById('pla4');
btnPlayTex4.addEventListener('click', () => {
        leerTexto(temper.value);
});

function leerTexto(temper){
    const speech = new SpeechSynthesisUtterance();
    speech.text= temper;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm-2">
    <button type="button" class="btn btn-success btn-sm" id="pla5"><i class="fas fa-play"></button></i> Saturación oxígeno:<input type="text" id="satoxi" class="form-control" value="<?php echo $f5['satoxi'];?>" disabled>
    </div>
    <script type="text/javascript">
const satoxi = document.getElementById('satoxi');
const btnPlayTex5 = document.getElementById('pla5');
btnPlayTex5.addEventListener('click', () => {
        leerTexto(satoxi.value);
});

function leerTexto(satoxi){
    const speech = new SpeechSynthesisUtterance();
    speech.text= satoxi;
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
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
<div class="container"> 
  <div class="row">
    <div class="col-sm-2"><br><center><button type="button" class="btn btn-success btn-sm" id="pla1"><i class="fas fa-play"></button></i> Presión arterial:</center>
     <div class="row">
       <div class="col"><input type="text" id="p_sistol" class="form-control" name="ta_sist" ></div> /
       <div class="col"><input type="text" id="p_diastol" class="form-control" name="ta_diast"></div>
     </div>
    </div>
<script type="text/javascript">
const p_sistol = document.getElementById('p_sistol');
const btnPlayTex1 = document.getElementById('pla1');
btnPlayTex1.addEventListener('click', () => {
        leerTexto(p_sistol.value);
});

function leerTexto(p_sistol){
    const speech = new SpeechSynthesisUtterance();
    speech.text= p_sistol;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
const p_diastol = document.getElementById('p_diastol');
const btnPlayTex11 = document.getElementById('pla1');
btnPlayTex11.addEventListener('click', () => {
        leerTexto(p_diastol.value);
});

function leerTexto(p_diastol){
    const speech = new SpeechSynthesisUtterance();
    speech.text= p_diastol;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="pla2"><i class="fas fa-play"></button></i>
 Frecuencia cardiaca:<input type="text" class="form-control" name="frec_card" id="fcard">
    </div>
<script type="text/javascript">
const fcard = document.getElementById('fcard');
const btnPlayTex2 = document.getElementById('pla2');
btnPlayTex2.addEventListener('click', () => {
        leerTexto(fcard.value);
});

function leerTexto(fcard){
    const speech = new SpeechSynthesisUtterance();
    speech.text= fcard;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="pla3"><i class="fas fa-play"></button></i> Frecuencia respiratoria:<input type="text" class="form-control" name="frec_resp" id="fresp">
    </div>
    <script type="text/javascript">
const fresp = document.getElementById('fresp');
const btnPlayTex3 = document.getElementById('pla3');
btnPlayTex3.addEventListener('click', () => {
        leerTexto(fresp.value);
});

function leerTexto(fresp){
    const speech = new SpeechSynthesisUtterance();
    speech.text= fresp;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script> 
    <div class="col-sm-2">
     <br><button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i> Temperatura:<input type="text" class="form-control"  name="preop_temp" id="temper">
    </div>
    <script type="text/javascript">
const temper = document.getElementById('temper');
const btnPlayTex4 = document.getElementById('pla4');
btnPlayTex4.addEventListener('click', () => {
        leerTexto(temper.value);
});

function leerTexto(temper){
    const speech = new SpeechSynthesisUtterance();
    speech.text= temper;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm-2">
    <button type="button" class="btn btn-success btn-sm" id="pla5"><i class="fas fa-play"></button></i> Saturación oxígeno:<input type="text"  class="form-control" name="sat_oxi" id="satoxi">
    </div>
   
  </div>
</div>
<script type="text/javascript">
const satoxi = document.getElementById('satoxi');
const btnPlayTex5 = document.getElementById('pla5');
btnPlayTex5.addEventListener('click', () => {
        leerTexto(satoxi.value);
});

function leerTexto(satoxi){
    const speech = new SpeechSynthesisUtterance();
    speech.text= satoxi;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<?php } ?>
  <hr>

   <div class="row">
    <div class="col-sm">
        <center><strong><p>Tipo de intervención:</p></strong></center>
      
    </div>
    <div class="col-sm-5">
    <div class="form-check">
           <input class="form-check-input" type="radio" name="tipo_intervencion" id="URGENCIAS" value="URGENCIA" name="tipocir" required="">
           <label class="form-check-label"  for="URGENCIAS">Urgencia</label>
    </div>
    </div>
    <div class="col-sm-2">
    <div class="form-check">
           <input class="form-check-input" type="radio" id="electiva" name="tipo_intervencion" value="ELECTIVA" name="tipocir">
           <label class="form-check-label" for="electiva">Electiva</label>
      </div>
    </div>
  </div>
  <hr>



    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
        <center><strong>PRE QUIRÚRGICA</strong></center><p>
    </div> 

  <?php

$resultado2 = $conexion->query("select * from dat_not_preop WHERE id_atencion=" .$_SESSION['hospital']." order by id_not_preop DESC LIMIT 1") or die($conexion->error);

?>
  <?php
                    while ($f2 = mysqli_fetch_array($resultado2)) {
                   $id_not_preop=$f2['id_not_preop'];
    }
    ?>
    <?php
if (isset($id_not_preop)) {
                        ?>
<?php 


$resultado2 = $conexion->query("select * from dat_not_preop WHERE id_atencion=" .$_SESSION['hospital']." order by id_not_preop DESC LIMIT 1") or die($conexion->error);

?>
  <?php
                    while ($f2 = mysqli_fetch_array($resultado2)) {



?>
<div class="row">
  <div class="col-8">
    <div class="form-group">
      <label for="txt1"><strong><button type="button" class="btn btn-success btn-sm" id="pla6"><i class="fas fa-play"></button></i> Cirugía programada</strong></label>
      <input type="text" class="form-control" name="intervencion_quir" id="txt1" required value="<?php echo $f2['tipo_inter_plan']?>" disabled>
    </div>
  </div>
<script type="text/javascript">
const txt1 = document.getElementById('txt1');
const btnPlayTex6 = document.getElementById('pla6');
btnPlayTex6.addEventListener('click', () => {
        leerTexto(txt1.value);
});

function leerTexto(txt1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txt1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
  <div class="col-3">
    <div class="form-group">
      <label for="e"><strong> Fecha y hora de cirugía:</strong></label>
      <input type="text" name="fecha_cir" class="form-control" id="e" required="" value="<?php echo $f2['fecha_cir']?>" disabled>
  </div>
</div>
 
</div>
  
    
</div>
    <div class="col-sm">
      <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="pla8"><i class="fas fa-play"></button></i> Diagnóstico pre operatorio:</strong></label>
        <select name="diag_preop" class="form-control" id="txt2" disabled>
          <option value="<?php echo $f2['diag_preop']?>"> <?php echo $f2['diag_preop']?></option> 
         </select> 
    </div>
<script type="text/javascript">
const txt2 = document.getElementById('txt2');
const btnPlayTex71 = document.getElementById('pla8');
btnPlayTex71.addEventListener('click', () => {
        leerTexto(txt2.value);
});

function leerTexto(txt2){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txt2;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<div class="container"><p></p>
  <div class="row">
   

    <div class="col-sm">
      <label for="exampleFormControlInput1"><strong><button type="button" class="btn btn-success btn-sm" id="pla10"><i class="fas fa-play"></button></i> Material y equipo requerido</strong></label>
      <textarea class="form-control" id="riesgos" name="riesgos" required rows="3" value="" disabled><?php echo $f2['material']?></textarea>
    </div>
</div>
<script type="text/javascript">
const riesgos = document.getElementById('riesgos');
const btnPlayTex9 = document.getElementById('pla10');
btnPlayTex9.addEventListener('click', () => {
        leerTexto(riesgos.value);
});

function leerTexto(riesgos){
    const speech = new SpeechSynthesisUtterance();
    speech.text= riesgos;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<p>
  <div class="row">
    <div class="col-sm">
      <label for="exampleFormControlInput1"><strong><button type="button" class="btn btn-success btn-sm" id="pla11"><i class="fas fa-play"></button></i> Estudios transoperatorios:</strong></label>
      <textarea class="form-control" name="cuidados" id="cuidados" required rows="3" value="" disabled><?php echo $f2['est_transo']?></textarea>   
    </div>
<script type="text/javascript">
const cuidados = document.getElementById('cuidados');
const btnPlayTex10 = document.getElementById('pla11');
btnPlayTex10.addEventListener('click', () => {
        leerTexto(cuidados.value);
});

function leerTexto(cuidados){
    const speech = new SpeechSynthesisUtterance();
    speech.text= cuidados;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
    <div class="col-sm">
      <label for="exampleFormControlInput1"><strong><button type="button" class="btn btn-success btn-sm" id="pla12"><i class="fas fa-play"></button></i> Diagnóstico postoperatorio:</strong></label>
      <textarea class="form-control" name="pronostico" id="pronostico2" required rows="3" value="" disabled> <?php echo $f2['d_postoperatorio']?></textarea>
    </div>
</div>
<script type="text/javascript">
const pronostico2 = document.getElementById('pronostico2');
const btnPlayTex13 = document.getElementById('pla12');
btnPlayTex13.addEventListener('click', () => {
        leerTexto(pronostico2.value);
});

function leerTexto(pronostico2){
    const speech = new SpeechSynthesisUtterance();
    speech.text= pronostico2;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
<p>
 

<?php }
?>
<?php 
}else{
                        
  ?>


<div class="row">
   <div class="col-sm">
      <label for="exampleFormControlTextarea1"><strong><button type="button" class="btn btn-success btn-sm" id="playprocirg"><i class="fas fa-play"></button></i> Cirugía programada:</strong></label>

     <select name="intervencion_quir" class="form-control" data-live-search="true" id="mib1" style="width : 100%; heigth : 100%">
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
  <script type="text/javascript">
const txt1 = document.getElementById('txt1');
const btnPlayTex6 = document.getElementById('pla6');
btnPlayTex6.addEventListener('click', () => {
        leerTexto(txt1.value);
});

function leerTexto(txt1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txt1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
  <div class="col-2">
    <div class="form-group">
      <label for="exampleFormControlInput1"><strong> Fecha de cirugía:</strong></label>
      <input type="date" name="fecha_cir" class="form-control" id="exampleFormControlInput1" required="" value="<">
  </div>
</div>
  <div class="col-2">
    <div class="form-group">
      <label for="exampleFormControlInput1"><strong> Hora de cirugía:</strong></label>
      <input type="time" name="hora_cir" class="form-control" id="exampleFormControlInput1" required="" value="" >
  </div>
</div>
</div>
  
    
</div>
    <div class="col-sm">
      <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="pla01"><i class="fas fa-play"></button></i> Diagnóstico pre operatorio:</strong></label>
        <select name="diag_preop" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%">
          <option value="">Seleccionar Diagnóstico pre operatorio</option>
            <?php
            include "../../conexionbd.php";
            $sql_diag="SELECT * FROM cat_diag ";
            $result_diag=$conexion->query($sql_diag);
            while($row=$result_diag->fetch_assoc()){
              echo "<option value='" . $row['diagnostico'] . "'>" . $row['id_cie10'] ."- " . $row['diagnostico'] . "</option>";}
          ?>
        </select>
    </div>
<script type="text/javascript">
const mibuscador = document.getElementById('mibuscador');
const btnPlayTex01 = document.getElementById('pla01');
btnPlayTex01.addEventListener('click', () => {
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

<div class="container"><p></p>
  <div class="row">
    <div class="col-sm">
      <label for="exampleFormControlInput1"><strong>Plan quirúrgico:</strong></label>
      <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="pqg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stop"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla02"><i class="fas fa-play"></button></i>
</div>

      <textarea class="form-control" name="tipo_inter_plan" id="txtpq" required rows="3" value="" ></textarea>
      <script type="text/javascript">
const pqg = document.getElementById('pqg');
const stop = document.getElementById('stop');
const txtpq = document.getElementById('txtpq');

const btnPlayTex02 = document.getElementById('pla02');
btnPlayTex02.addEventListener('click', () => {
        leerTexto(txtpq.value);
});

function leerTexto(txtpq){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtpq;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 

     let q = new webkitSpeechRecognition();
      q.lang = "es-ES";
      q.continuous = true;
      q.interimResults = false;

      q.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtpq.value += frase;
      }

      pqg.addEventListener('click', () => {
        q.start();
      });

      stop.addEventListener('click', () => {
        q.abort();
      });
</script>
    </div>
    <div class="col-sm">
      <label for="exampleFormControlInput1"><strong>Riesgo quirúrgico:</strong></label>
      <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="riesgg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="sr"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla03"><i class="fas fa-play"></button></i>
</div> 

      <textarea class="form-control" name="riesgos" id="txtrqr" required rows="3" value="" ></textarea>
      <script type="text/javascript">
const riesgg = document.getElementById('riesgg');
const sr = document.getElementById('sr');
const txtrqr = document.getElementById('txtrqr');

const btnPlayTex03 = document.getElementById('pla03');
btnPlayTex03.addEventListener('click', () => {
        leerTexto(txtrqr.value);
});

function leerTexto(txtrqr){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtrqr;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let gico = new webkitSpeechRecognition();
      gico.lang = "es-ES";
      gico.continuous = true;
      gico.interimResults = false;

      gico.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtrqr.value += frase;
      }

      riesgg.addEventListener('click', () => {
        gico.start();
      });

      sr.addEventListener('click', () => {
        gico.abort();
      });
</script>
    </div>

</div>


  <div class="row">
    <div class="col-sm">
      <label for="exampleFormControlInput1"><strong>Cuidados y plan terapeútico pre operatorio:</strong></label>
      <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="preg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detprrr"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla04"><i class="fas fa-play"></button></i>
</div>

      <textarea class="form-control" name="cuidados" id="txtui" required rows="3" value="" ></textarea>
      <script type="text/javascript">
const preg = document.getElementById('preg');
const detprrr = document.getElementById('detprrr');
const txtui = document.getElementById('txtui');

const btnPlayTex04 = document.getElementById('pla04');
btnPlayTex04.addEventListener('click', () => {
        leerTexto(txtui.value);
});

function leerTexto(txtui){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtui;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 

     let yp = new webkitSpeechRecognition();
      yp.lang = "es-ES";
      yp.continuous = true;
      yp.interimResults = false;

      yp.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtui.value += frase;
      }

      preg.addEventListener('click', () => {
        yp.start();
      });

      detprrr.addEventListener('click', () => {
        yp.abort();
      });
</script>
    </div>
    <div class="col-sm">
      <label for="exampleFormControlInput1"><strong>Pronóstico pre operatorio:</strong></label>
      <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="opg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stoppr"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla05"><i class="fas fa-play"></button></i>
</div>
  
      <textarea class="form-control" name="pronostico" id="txtipr" required rows="3" value="" ></textarea>
      <script type="text/javascript">
const opg = document.getElementById('opg');
const stoppr = document.getElementById('stoppr');
const txtipr = document.getElementById('txtipr');

const btnPlayTex05 = document.getElementById('pla05');
btnPlayTex05.addEventListener('click', () => {
        leerTexto(txtipr.value);
});

function leerTexto(txtipr){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtipr;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let ticopre = new webkitSpeechRecognition();
      ticopre.lang = "es-ES";
      ticopre.continuous = true;
      ticopre.interimResults = false;

      ticopre.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtipr.value += frase;
      }

      opg.addEventListener('click', () => {
        ticopre.start();
      });

      stoppr.addEventListener('click', () => {
        ticopre.abort();
      });
</script>
    </div>
</div>
 <div class="row">
    <div class="col-sm">
      <label for="exampleFormControlInput1"><strong>Observaciones:</strong></label>
      <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="ordg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stob"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla06"><i class="fas fa-play"></button></i>
</div>
 
      <textarea class="form-control" name="observ" id="txtciones" required rows="5" value="" ></textarea><script type="text/javascript">
const ordg = document.getElementById('ordg');
const stob = document.getElementById('stob');
const txtciones = document.getElementById('txtciones');

const btnPlayTex06 = document.getElementById('pla06');
btnPlayTex06.addEventListener('click', () => {
        leerTexto(txtciones.value);
});

function leerTexto(txtciones){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtciones;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let observa = new webkitSpeechRecognition();
      observa.lang = "es-ES";
      observa.continuous = true;
      observa.interimResults = false;

      observa.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtciones.value += frase;
      }

      ordg.addEventListener('click', () => {
        observa.start();
      });

      stob.addEventListener('click', () => {
        observa.abort();
      });
</script>
    </div>
</div>


<?php } ?>


<br>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
        <center><strong>NOTA  POST  QUIRÚRGICA  Y  DESCRIPCIÓN  QUIRÚRGICA</strong></center><p>
</div> 

<div class="container">
 <div class="row">

  <div class="col"><strong><center>SANGRE EN</center></strong><hr>
    
  <div class="row">
    <div class="col-sm">
      <label for="tx1"><button type="button" class="btn btn-success btn-sm" id="pla07"><i class="fas fa-play"></button></i> Quirófano:</label>
    <input type="number" class="form-control" name="quirofano"  id="tx1" placeholder="ml.">
    </div>
<script type="text/javascript">
const tx1 = document.getElementById('tx1');
const btnPlayTex07 = document.getElementById('pla07');
btnPlayTex07.addEventListener('click', () => {
        leerTexto(tx1.value);
});

function leerTexto(tx1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= tx1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm">
      <label for="tx2"><button type="button" class="btn btn-success btn-sm" id="pla08"><i class="fas fa-play"></button></i> Reserva:</label>
    <input type="number" class="form-control" name="reserva" id="tx2" placeholder="ml.">
    </div>
  </div>
<script type="text/javascript">
const tx2 = document.getElementById('tx2');
const btnPlayTex08 = document.getElementById('pla08');
btnPlayTex08.addEventListener('click', () => {
        leerTexto(tx2.value);
});

function leerTexto(tx2){
    const speech = new SpeechSynthesisUtterance();
    speech.text= tx2;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<hr>
  </div>

  <div class="col"><strong><center>Anestesia</center></strong><hr>
  <div class="row">
    <div class="col-sm-4">
    <label for="local">Local</label>
    <input type="checkbox"  name="local" value="SI" id="local" > 
    </div>
    <div class="col-sm-4">
      <label for="regional">Regional</label>
    <input type="checkbox"  name="regional" value="SI" id="regional"> 
    </div>
    <div class="col-sm-4">
      <label for="general">General</label>
    <input type="checkbox" name="general" value="SI" id="general" >
    </div>
  </div>
  <hr>
  </div>
  
  <div class="col"><hr>

<div class="row">
    
    <?php
$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);
?>
  <?php
                    while ($f1 = mysqli_fetch_array($resultado1)) {

                        ?>
    <div class="col-sm">
      <label for="tx3"><button type="button" class="btn btn-success btn-sm" id="pla09"><i class="fas fa-play"></button></i> Tipo de sangre:</label>
<input type="text" class="form-control" name="tipo_sangre" id="tx3" value="<?php echo $f1['tip_san']?>"disabled>
<script type="text/javascript">
const tx3 = document.getElementById('tx3');
const btnPlayTex09 = document.getElementById('pla09');
btnPlayTex09.addEventListener('click', () => {
        leerTexto(tx3.value);
});

function leerTexto(tx3){
    const speech = new SpeechSynthesisUtterance();
    speech.text= tx3;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    </div>
    <?php
}
?>
  </div>
<hr>
  </div>

</div>
</div>


<div class="container">
  <div class="row">
    <div class="col-sm-3">
      <label for="exampleFormControlTextarea1"><strong><button type="button" class="btn btn-success btn-sm" id="pla010"><i class="fas fa-play"></button></i> Cuenta de gasas y compresas</strong></label>
      <select class="form-control" aria-label="CUENTA DE GASAS Y COMPRESAS" name="inst_necesario" id="tx4">
       
       <option value="COMPLETA">Completa</option>
       <option value="INCOMPLETA">Incompleta</option>
      </select>
    </div>
<script type="text/javascript">
const tx4 = document.getElementById('tx4');
const btnPlayTex010 = document.getElementById('pla010');
btnPlayTex010.addEventListener('click', () => {
        leerTexto(tx4.value);
});

function leerTexto(tx4){
    const speech = new SpeechSynthesisUtterance();
    speech.text= tx4;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm">
      <label for="exampleFormControlTextarea5"><strong>Observaciones</strong></label>
      <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla011"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" name="medmat_necesario" id="texto" required rows="3"></textarea>
 <script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btnPlayTex011 = document.getElementById('pla011');
btnPlayTex011.addEventListener('click', () => {
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


  <?php

$resultado2 = $conexion->query("select * from dat_not_preop WHERE id_atencion=" .$_SESSION['hospital']." order by id_not_preop DESC LIMIT 1") or die($conexion->error);

?>
  <?php
                    while ($f2 = mysqli_fetch_array($resultado2)) {

?>

<div class="row">
  <div class="col-6">
    <div class="form-group">
      <label for="tx6"><strong><button type="button" class="btn btn-success btn-sm" id="pla012"><i class="fas fa-play"></button></i> Cirugía programada</strong></label>
      <input type="text" class="form-control" name="intervencion_quir" id="tx6" required value="<?php echo $f2['tipo_inter_plan']?>" disabled>
    </div>
  </div>
<script type="text/javascript">
const tx6 = document.getElementById('tx6');
const btnPlayTex012 = document.getElementById('pla012');
btnPlayTex012.addEventListener('click', () => {
        leerTexto(tx6.value);
});

function leerTexto(tx6){
    const speech = new SpeechSynthesisUtterance();
    speech.text= tx6;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
 
</script>
  <div class="col-3">
      <label for="exampleFormControlInput1"><strong> Fecha de cirugía:</strong></label>
      <input type="date" name="fecha_cir" class="form-control" id="exampleFormControlInput1" required="" value="<?php echo $f2['fecha_cir']?>" disabled>
  </div>
  <div class="col-3">
      <label for="exampleFormControlInput1"><strong> Hora de cirugía:</strong></label>
      <input type="time" name="hora_cir" class="form-control" id="exampleFormControlInput1" required="" value="<?php echo $f2['hora_cir']?>" disabled>
  </div>
  
    <?php } ?>
</div>

<hr>
<div class="container">
  <div class="row">
    <div class="col-sm-6">

  <div class="form-group">
<label for="diag_postop"><strong><button type="button" class="btn btn-success btn-sm" id="pla013"><i class="fas fa-play"></button></i> Diagnóstico post operatorio:</strong></label>
<select class="form-control" name="diag_postop" required id="diag_postop">
          <option value="">Seleccionar diagnóstico post operatorio</option>
                          
    <?php
    $sql_d = "SELECT DISTINCT id_diag,diagnostico,id_cie10 FROM cat_diag";
    $result_d = $conexion->query($sql_d);
    while ($row_d = $result_d->fetch_assoc()) {
  echo "<option value='" . $row_d['id_diag'] . "'>". $row_d['id_cie10'] ."- " .$row_d['diagnostico'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>       
    </div>
<script type="text/javascript">
const diag_postop = document.getElementById('diag_postop');
const btnPlayTex013 = document.getElementById('pla013');
btnPlayTex013.addEventListener('click', () => {
        leerTexto(diag_postop.value);
});

function leerTexto(diag_postop){
    const speech = new SpeechSynthesisUtterance();
    speech.text= diag_postop;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
 
</script>
    <div class="col-sm-6">

  <div class="form-group">
<label for="diag_postop"><strong><button type="button" class="btn btn-success btn-sm" id="pla013"><i class="fas fa-play"></button></i> Cirugía realizada:</strong></label>

     <select name="cirrealizada" class="form-control" data-live-search="true" id="mib" style="width : 100%; heigth : 100%">
            <option value="">Seleccionar cirugía realizada</option>
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_proc ";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['procedimiento'] . "'>"  . $row['cie9'] ."- " . $row['procedimiento'] . "</option>";
}
 ?></select>
                        </select>
                    </div>       
    </div>
    <div class="col-sm-9">
      <label for="exampleFormControlTextarea1"><strong>Descripción de Cirugía realizada técnica:</strong></label>
      <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="cirg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detrea"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla014"><i class="fas fa-play"></button></i>
</div> 
      <textarea class="form-control" name="cir_realizada" id="txtcr" required rows="10"></textarea>
 <script type="text/javascript">
const cirg = document.getElementById('cirg');
const detrea = document.getElementById('detrea');
const txtcr = document.getElementById('txtcr');

const btnPlayTex014 = document.getElementById('pla014');
btnPlayTex014.addEventListener('click', () => {
        leerTexto(txtcr.value);
});

function leerTexto(txtcr){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtcr;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
     let rcr = new webkitSpeechRecognition();
      rcr.lang = "es-ES";
      rcr.continuous = true;
      rcr.interimResults = false;

      rcr.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtcr.value += frase;
      }

      cirg.addEventListener('click', () => {
        rcr.start();
      });

      detrea.addEventListener('click', () => {
        rcr.abort();
      });
</script>
    </div>
    <div class="col-2">
      <div class="form-group">
        <label for="exampleFormControlInput1"><strong>Inicio</strong></label>
        <input type="time" class="form-control" name="inicio"  id="exampleFormControlInput1" required>
      </div>
      <div class="form-group">
        <label for="exampleFormControlInput1"><strong>Término</strong></label>
        <input type="time" class="form-control" name="termino"  id="exampleFormControlInput1" required >
      </div>
    </div>
 </div>
</div>

<!--<label><strong><center>ESTUDIOS DE PATOLOGÍA</center></strong></label>-->

<div class="container"><p></p>
  <div class="row">
    <div class="col-sm">
      
      <div class="row">
               <div class="col"><label><strong>Estudios Trans operatorios</strong></label>
                <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="tg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detop"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla015"><i class="fas fa-play"></button></i>
</div> 
<textarea class="form-control" name="trans" id="txtts" required rows="4"></textarea>
<script type="text/javascript">
const tg = document.getElementById('tg');
const detop = document.getElementById('detop');
const txtts = document.getElementById('txtts');

const btnPlayTex015 = document.getElementById('pla015');
btnPlayTex015.addEventListener('click', () => {
        leerTexto(txtts.value);
});

function leerTexto(txtts){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtts;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
     let rtra = new webkitSpeechRecognition();
      rtra.lang = "es-ES";
      rtra.continuous = true;
      rtra.interimResults = false;

      rtra.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtts.value += frase;
      }

      tg.addEventListener('click', () => {
        rtra.start();
      });

      detop.addEventListener('click', () => {
        rtra.abort();
      });
</script></div>
       <!--  <div class="col"><label><strong>Post operatorios</strong></label>
                  <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="postg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detrat"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla016"><i class="fas fa-play"></button></i>
</div> 
<textarea  class="form-control" name="posto" id="txtpt" required rows="8"></textarea>
</div>-->
      </div>
    </div>
  </div>
</div>

<div class="container"><p>
  <div class="row">

    <div class="col-sm">
    
    <label for="t01"><strong><button type="button" class="btn btn-success btn-sm" id="pla017"><i class="fas fa-play"></button></i> Accidenes o incidentes</strong></label>
    <input type="text" class="form-control" name="accident_incident" id="t01" required >
    </div>
<script type="text/javascript">
const t01 = document.getElementById('t01');

const btnPlayTex017 = document.getElementById('pla017');
btnPlayTex017.addEventListener('click', () => {
        leerTexto(t01.value);
});

function leerTexto(t01){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t01;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
     <div class="col-sm">
    <label for="t02"><strong><button type="button" class="btn btn-success btn-sm" id="pla018"><i class="fas fa-play"></button></i> Complicaciones</strong></label>
    <input type="text" class="form-control" name="realizada_por" id="t02" required >
    </div>
</div>
</div>
<script type="text/javascript">
const t02 = document.getElementById('t02');

const btnPlayTex018 = document.getElementById('pla018');
btnPlayTex018.addEventListener('click', () => {
        leerTexto(t02.value);
});

function leerTexto(t02){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t02;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>

<div class="container"><p>
  <div class="row">
    <div class="col-sm-3">
       <div class="form-group">
    <label for="t03"><strong><button type="button" class="btn btn-success btn-sm" id="pla019"><i class="fas fa-play"></button></i> Pérdida hemática (ml)</strong></label>
    <input type="number" class="form-control" name="perd_hema" id="t03" required >
  </div>
    </div>
<script type="text/javascript">
const t03 = document.getElementById('t03');

const btnPlayTex019 = document.getElementById('pla019');
btnPlayTex019.addEventListener('click', () => {
        leerTexto(t03.value);
});

function leerTexto(t03){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t03;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
     <div class="col-sm-3">
      <div class="form-group">
    <label for="t04"><strong><button type="button" class="btn btn-success btn-sm" id="pla020"><i class="fas fa-play"></button></i> Anestesia administrada</strong></label>
    <input type="text" class="form-control" name="anestesia_admin" id="t04" required >
  </div>
    </div>
<script type="text/javascript">
const t04 = document.getElementById('t04');

const btnPlayTex020 = document.getElementById('pla020');
btnPlayTex020.addEventListener('click', () => {
        leerTexto(t04.value);
});

function leerTexto(t04){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t04;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  
     <div class="col-sm">
       <div class="form-group">
    <label for="t05"><strong><button type="button" class="btn btn-success btn-sm" id="pla021"><i class="fas fa-play"></button></i> Duración de la anestesia</strong></label>
    <input type="text" class="form-control" name="anestesia_dur" id="t05" required >
  </div>
    </div>
  </div>
</div>
<script type="text/javascript">
const t05 = document.getElementById('t05');

const btnPlayTex021 = document.getElementById('pla021');
btnPlayTex021.addEventListener('click', () => {
        leerTexto(t05.value);
});

function leerTexto(t05){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t05;
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
    <div class="form-group">
    <label for="t06"><strong><button type="button" class="btn btn-success btn-sm" id="pla022"><i class="fas fa-play"></button></i> Cirujano</strong></label>
    <input type="text" class="form-control" name="cirujano" id="t06" required >
  </div>
  </div>
<script type="text/javascript">
const t06 = document.getElementById('t06');

const btnPlayTex022 = document.getElementById('pla022');
btnPlayTex022.addEventListener('click', () => {
        leerTexto(t06.value);
});

function leerTexto(t06){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t06;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  <div class="col-sm">
    <div class="form-group">
    <label for="t07"><strong><button type="button" class="btn btn-success btn-sm" id="pla023"><i class="fas fa-play"></button></i>Primer ayudante</strong></label>
    <input type="text" class="form-control" name="prim_ayudante" id="t07" required >
  </div>
  </div>
<script type="text/javascript">
const t07 = document.getElementById('t07');

const btnPlayTex023 = document.getElementById('pla023');
btnPlayTex023.addEventListener('click', () => {
        leerTexto(t07.value);
});

function leerTexto(t07){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t07;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  <div class="col-sm">
    <div class="form-group">
    <label for="t08"><strong><button type="button" class="btn btn-success btn-sm" id="pla024"><i class="fas fa-play"></button></i> Segundo ayudante</strong></label>
    <input type="text" class="form-control" name="seg_ayudante" id="t08" required >
  </div>
  </div>
<script type="text/javascript">
const t08 = document.getElementById('t08');

const btnPlayTex024 = document.getElementById('pla024');
btnPlayTex024.addEventListener('click', () => {
        leerTexto(t08.value);
});

function leerTexto(t08){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t08;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  <div class="col-sm">
    <div class="form-group">
    <label for="t09"><strong><button type="button" class="btn btn-success btn-sm" id="pla025"><i class="fas fa-play"></button></i> Tercer ayudante</strong></label>
    <input type="text" class="form-control" name="ter_ayudante" id="t09" required >
  </div>
  </div>
</div>
</div>
<script type="text/javascript">
const t09 = document.getElementById('t09');

const btnPlayTex025 = document.getElementById('pla025');
btnPlayTex025.addEventListener('click', () => {
        leerTexto(t09.value);
});

function leerTexto(t09){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t09;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<div class="container">
  <div class="row">
  <div class="col">
    <div class="form-group">
    <label for="t10"><strong><button type="button" class="btn btn-success btn-sm" id="pla026"><i class="fas fa-play"></button></i> Anestesiólogo</strong></label>
    <input type="text" class="form-control" name="anestesiologo" id="t10" required >
  </div>
  </div>
<script type="text/javascript">
const t10 = document.getElementById('t10');

const btnPlayTex026 = document.getElementById('pla026');
btnPlayTex026.addEventListener('click', () => {
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
  <div class="col">
    <div class="form-group">
    <label for="t11"><strong><button type="button" class="btn btn-success btn-sm" id="pla027"><i class="fas fa-play"></button></i> Circulante</strong></label>
    <input type="text" class="form-control" name="circulante" id="t11" required>
  </div>
  </div>
<script type="text/javascript">
const t11 = document.getElementById('t11');

const btnPlayTex027 = document.getElementById('pla027');
btnPlayTex027.addEventListener('click', () => {
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
  <div class="col">
    <div class="form-group">
    <label for="t12"><strong><button type="button" class="btn btn-success btn-sm" id="pla028"><i class="fas fa-play"></button></i> Instrumentista</strong></label>
    <input type="text" class="form-control" name="instrumentista" id="t12" required >
  </div>
  </div>
</div>
</div>
<script type="text/javascript">
const t12 = document.getElementById('t12');

const btnPlayTex028 = document.getElementById('pla028');
btnPlayTex028.addEventListener('click', () => {
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
<!--<div class="row">
  <div class="col-sm-6">
    <div class="container"><center><strong>Quirófano</strong></center>
  <div class="row">
    <div class="col-sm-4">
     <div class="form-group">
       <br><label><button type="button" class="btn btn-success btn-sm" id="pla029"><i class="fas fa-play"></button></i> SALA</label>
       <select id="quir" name="quir" class="form-control">
          <option>Seleccionar sala</option>
          <option value="SALA 1">Sala 1</option>
           <option value="SALA 2">Sala 2</option>
            <option value="SALA 3">Sala 3</option>
             <option value="SALA 4">Sala 4</option>
          <option value="SALA DE PARTO">Sala de parto</option>
       </select>
     </div>
    </div>
    <script type="text/javascript">
const quir = document.getElementById('quir');

const btnPlayTex029 = document.getElementById('pla029');
btnPlayTex029.addEventListener('click', () => {
        leerTexto(quir.value);
});

function leerTexto(quir){
    const speech = new SpeechSynthesisUtterance();
    speech.text= quir;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-4">
      <div class="form-group">
    <label for="exampleFormControlInput1"><br>Hora llegada</label>
    <input type="time" class="form-control" name="hora_llegada_quir" required>
  </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
    <label for="exampleFormControlInput1"><br>Hora salida</label>
    <input type="time" class="form-control" name="hora_salida_quir" required >
  </div>
    </div>
  </div>
</div>
  </div>
  <div class="col-6">
    <div class="container"><center><strong>Sala de recuperación</strong></center>
  <div class="row">
    <div class="col-sm-5">
      <div class="form-group">
    <label for="exampleFormControlInput1"><br>Hora llegada</label>
    <input type="time" class="form-control" name="hora_entrada_recup" id="exampleFormControlInput1" required>
  </div>
    </div>
    <div class="col-sm-5">
     <div class="form-group">
    <label for="exampleFormControlInput1"><br>Hora salida</label>
    <input type="time" class="form-control" name="hora_salida_recup" id="exampleFormControlInput1" required >
  </div>
    </div>
  </div>
</div>
  </div>
 
</div>-->
<hr>
<div class="container">
<div class="form-group">
    <label for="exampleFormControlTextarea1"><strong> Hallazgos:</strong></label><div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="hag"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="dettec"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla030"><i class="fas fa-play"></button></i>
</div> 
    <textarea class="form-control" id="txthtc" name="nota_preop" rows="8" required></textarea>
    <script type="text/javascript">
const hag = document.getElementById('hag');
const dettec = document.getElementById('dettec');
const txthtc = document.getElementById('txthtc');

const btnPlayTex030 = document.getElementById('pla030');
btnPlayTex030.addEventListener('click', () => {
        leerTexto(txthtc.value);
});

function leerTexto(txthtc){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txthtc;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
     let rh = new webkitSpeechRecognition();
      rh.lang = "es-ES";
      rh.continuous = true;
      rh.interimResults = false;

      rh.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txthtc.value += frase;
      }

      hag.addEventListener('click', () => {
        rh.start();
      });

      dettec.addEventListener('click', () => {
        rh.abort();
      });
</script>
  </div>
</div>

<hr>
<div class="container">
<div class="row">
  <div class="col-sm-4"><strong>Estado post quirúrgico inmediato:</strong></div>
  <div class="col">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="buen" name="estado_postop" value="BUENO">
  <label class="form-check-label" for="buen">
    Bueno
  </label>
</div>
  </div>
  <div class="col">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="delicadoe" name="estado_postop" value="DELICADO" name="estado_postop">
  <label class="form-check-label" for="delicadoe">
    Delicado
  </label>
</div>
  </div>
  <div class="col">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="estado_postop" id="gravee" value="GRAVE" name="estado_postop">
  <label class="form-check-label" for="gravee">
    Grave
  </label>
</div>
  </div>
  <div class="col">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="estado_postop" id="muygravee" value="MUY GRAVE" name="estado_postop">
  <label class="form-check-label" for="muygravee">
    Muy grave
  </label>
</div>
  </div>
</div>
</div>


<div class="container"><hr>
<div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>Comentario final y pronóstico:</strong></label>
    <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="fing"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detyf"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla031"><i class="fas fa-play"></button></i>
</div> 
<textarea class="form-control" name="comentario_final" id="txtfy" required rows="8" ></textarea>
<script type="text/javascript">
const fing = document.getElementById('fing');
const detyf = document.getElementById('detyf');
const txtfy = document.getElementById('txtfy');

const btnPlayTex031 = document.getElementById('pla031');
btnPlayTex031.addEventListener('click', () => {
        leerTexto(txtfy.value);
});

function leerTexto(txtfy){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtfy;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
     let ry = new webkitSpeechRecognition();
      ry.lang = "es-ES";
      ry.continuous = true;
      ry.interimResults = false;

      ry.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtfy.value += frase;
      }

      fing.addEventListener('click', () => {
        ry.start();
      });

      detyf.addEventListener('click', () => {
        ry.abort();
      });
</script>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>Plan terapeútico (post quirúrgico):</strong></label><div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="terga"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detquir"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla032"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" name="plan_tera" id="txtqd" required rows="8" ></textarea>
<script type="text/javascript">
const terga = document.getElementById('terga');
const detquir = document.getElementById('detquir');
const txtqd = document.getElementById('txtqd');

const btnPlayTex032 = document.getElementById('pla032');
btnPlayTex032.addEventListener('click', () => {
        leerTexto(txtqd.value);
});

function leerTexto(txtqd){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtqd;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
     let rq = new webkitSpeechRecognition();
      rq.lang = "es-ES";
      rq.continuous = true;
      rq.interimResults = false;

      rq.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtqd.value += frase;
      }

      terga.addEventListener('click', () => {
        rq.start();
      });

      detquir.addEventListener('click', () => {
        rq.abort();
      });
</script>
  </div>
</div>

<div class="container">
<div class="row">
    <div class=" col-sm-9">
<strong><button type="button" class="btn btn-success btn-sm" id="pla033"><i class="fas fa-play"></button></i> Guía de práctica clínica:</strong>

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
const btnPlayTex033 = document.getElementById('pla033');
btnPlayTex033.addEventListener('click', () => {
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

    <div class="modal-footer">
        <button rol="button" class="btn btn-danger" data-dismiss="modal">Regresar</button>
      </div>
    </div>
  </div>
</div>

</div>

</div>


</div>


  <div class="row">
    <div class="col">
       <div class="form-group">
    <label for="txx1"><strong><button type="button" class="btn btn-success btn-sm" id="pla034"><i class="fas fa-play"></button></i> Describió la operación</strong></label>
    <input type="text" class="form-control" name="descripcion_op" id="txx1" required >
  </div>
    </div>
<script type="text/javascript">
const txx1 = document.getElementById('txx1');
const btnPlayTex034 = document.getElementById('pla034');
btnPlayTex034.addEventListener('click', () => {
        leerTexto(txx1.value);
});
function leerTexto(txx1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txx1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col">
      <?php 
$usuario = $_SESSION['login'];
//$resultado = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='" . $usuario . "'") or die($conexion->error);
 ?>

<div class="form-group">
    <label for="txxx2"><strong><button type="button" class="btn btn-success btn-sm" id="pla035"><i class="fas fa-play"></button></i> Nombre del médico cirujano:</strong></label>
    <input type="text" class="form-control" name="nombre_med_cir"  id="txxx2" required>

  </div>
  </div>
  </div>
<script type="text/javascript">
const txxx2 = document.getElementById('txxx2');
const btnPlayTex035 = document.getElementById('pla035');
btnPlayTex035.addEventListener('click', () => {
        leerTexto(txxx2.value);
});
function leerTexto(txxx2){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txxx2;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>

<!--<?php //echo $usuario['nombre']; ?> <?php// echo $usuario['papell']; ?> <?php// echo $usuario['sapell']; ?>-->


<hr>

<center>
  <div class="form-group">
      <button type="submit" class="btn btn-primary">Firmar y guardar</button>
      <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
  </div>
</center>

<br>

</form>
</div> <!--TERMINO DE NOTA DESCRIPCIÓN QUIRÚRGICA-->
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
        $('#diag_postop').select2();
    });
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
      $(document).ready(function () {
        $('#mibuscador11').select2();
    });
     $(document).ready(function () {
        $('#mib').select2();
    });
     $(document).ready(function () {
        $('#mib1').select2();
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