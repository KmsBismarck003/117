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
<strong><center>NOTA DE VALORACIÓN PRE-ANESTESICA</center></strong>
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
} ?>
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
      <div class="container">  <!--INICIO DE CONSULTA DE URGENCIAS-->
<form action="insertar_nota_anest.php" method="POST">
<div class="container">
  <div class="row">
   <?php

    $resultado2 = $conexion->query("select * from dat_not_preop WHERE id_atencion=" .$_SESSION['hospital']." order by id_not_preop DESC LIMIT 1") or die($conexion->error); ?>   <?php
     while ($f2 = mysqli_fetch_array($resultado2)) {   ?>

    <div class="col col-9">
     <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="pla1"><i class="fas fa-play"></button></i> Diagnóstico preoperatorio:</strong></label>
     <input type="text" class="form-control" id="t1" name="diag_pre" required value=" <?php echo $f2['diag_preop'];?>" disabled>
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
    <div class="col col-3">
     <label for=""><strong><button type="button" class="btn btn-success btn-sm" id="pla2"><i class="fas fa-play"></button></i> Tipo (urgencia/electiva):</strong></label>
     <input type="text" class="form-control" name="urg" id="t2" required  value= " <?php echo $f2['tipo_cirugia_preop'];?>" disabled>
      <?php } ?>
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
<div class="container">

<hr>

  <?php

$resultado2 = $conexion->query("select * from dat_not_preop WHERE id_atencion=" .$_SESSION['hospital']." order by id_not_preop DESC LIMIT 1") or die($conexion->error);
                    while ($f2 = mysqli_fetch_array($resultado2)) {

                        ?>
<div class="row">
   <div class="col col-6">
      <label for="t3"><strong><button type="button" class="btn btn-success btn-sm" id="pla3"><i class="fas fa-play"></button></i> Cirugía programada</strong></label>
      <input type="text" class="form-control" name="inter" id="t3" required value="<?php echo $f2['tipo_inter_plan']?>" disabled>
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
   <div class="col col-6">
      <label for="t4"><strong><button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i> Nombre del cirujano:</strong></label>
      <input type="text" class="form-control" name="med_proc" id="t4" required value="<?php echo $f2['nom_medi_cir']?>" disabled>
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

     <?php } ?>
</div>

</div>
<hr>
<div class=container>
<div class="row">
 
      <div class="col "> <strong>Interrogatorio:</strong></div>
      <div class="col">  
        <div class="form-check">
         <input class="form-check-input" type="radio" name="inter" id="flexRadioDefault5" value="DIRECTO" required>
         <label class="form-check-label" for="flexRadioDefault5">Directo</label>
        </div> 
      </div>
      <div class="col">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="inter" id="flexRadioDefault6" value="INDIRECTO" required>
          <label class="form-check-label" for="flexRadioDefault6">Indirecto</label>
        </div>
      </div>

   <div class="col col-6">
     <label><strong><button type="button" class="btn btn-success btn-sm" id="pla5"><i class="fas fa-play"></button></i> Antestesiólogo</strong></label>
     <input type="text" name="anest" class="form-control" required id="t5">
   </div> 
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
<div class="container">
<div class="row">
    

  <div class="col">
    <table class="table table-bordered">
  <thead>
    <tr color="red">
      <th scope="col" class="col-1">Antecedentes no patologicos</th>
   
      <th scope="col"> &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp;Si</th>
      <th scope="col">No</th>
 
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Inmunizaciones</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="inmun" id="in">
  <label class="form-check-label" for="in">

  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="inmun" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
     
    </tr>
    <tr>
      <td>Tabaquismo</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="tab" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="tab" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
    <tr>
      <td>Alcoholismo</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="alc" id="in2" >
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="alc" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
    <tr>
      <td>Transfusionales</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="trans" id="in2" >
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="trans" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
    <tr>
      <td>Alergias</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="alerg" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="alerg" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
    <tr>
      <td>Toxicomanias</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="toxi" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="toxi" id="in2" value="NO" >
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>

     <tr>
      <th>Antecedentes patologicos</th>
 
    </tr>

 <tr>
      <td>Gastro/hepáticos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="gastro" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="gastro" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>Neurológicos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="neuro" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="neuro" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>Neumológicos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="neumo" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="neumo" id="in2" value="NO" >
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>Renales</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="ren" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="ren" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>Cardiológicos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="card" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="card" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>Endócrinos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="end" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="end" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>Reumáticos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="reu" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="reu" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
   
     <tr>
      <td>Neoplasicos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="neo" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="neo" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>Hematologicos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="herma" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="herma" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>Traumáticos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="trau" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="trau" id="in2" value="NO" >
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>Psiquiátricos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="psi" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="psi" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
      <tr>
      <td>Quirúrgicos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="quir" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="quir" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
      <tr>
      <td>Anestésicos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="aneste" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="aneste" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
      <tr>
      <td>Gineco-obstétricos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="gin" id="in2" >
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="gin" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
      <tr>
      <td>Pediátricos</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="ped" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="ped" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
    <th>Antecedentes neurológicos</th>
     <tr>
      <td>Consciente</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="cons" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="cons" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>Otro</td>
      <td><div class="form-check">
  <input class="form-control" type="text" name="otro" id="in2">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="otro" id="in2" value="NO">
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
  </tbody>
</table>
  </div>

  <div class="col">
    <center><h6><strong>Valoración de antecedentes:</strong></h6></center>
    <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
</div>
     <div class="form-group">
<textarea class="form-control" id="texto" rows="36" name="valant" required></textarea>
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
 <center><h6><strong>Padecimiento actual:</strong></h6></center>
 <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="padeg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopac"><i class="fas fa-microphone-slash"></button></i>
</div>
   <div class="form-group">
<textarea class="form-control" id="txt" rows="3" name="pad_act" required></textarea>
<script type="text/javascript">
const padeg = document.getElementById('padeg');
const stopac = document.getElementById('stopac');
const txt = document.getElementById('txt');

     let rede = new webkitSpeechRecognition();
      rede.lang = "es-ES";
      rede.continuous = true;
      rede.interimResults = false;

      rede.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txt.value += frase;
      }

      padeg.addEventListener('click', () => {
        rede.start();
      });

      stopac.addEventListener('click', () => {
        rede.abort();
      });
</script>
  </div>

<center><h6><strong>Medicación actual:</strong></h6></center>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="medg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="actstop"><i class="fas fa-microphone-slash"></button></i>
</div>
   <div class="form-group">
<textarea class="form-control" id="txtma" rows="3" name="med_act" required></textarea>
<script type="text/javascript">
const medg = document.getElementById('medg');
const actstop = document.getElementById('actstop');
const txtma = document.getElementById('txtma');

     let medacre = new webkitSpeechRecognition();
      medacre.lang = "es-ES";
      medacre.continuous = true;
      medacre.interimResults = false;

      medacre.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtma.value += frase;
      }

      medg.addEventListener('click', () => {
        medacre.start();
      });

      actstop.addEventListener('click', () => {
        medacre.abort();
      });
</script>
  </div>
<div class="row">
  <div class="col-12">
    <h6><strong>Ayuno:</strong></h6>
    <div class="form-group">
   <input type="text"  class="form-control" name="ayuno" required>
 </div>
</div>
  <div class="col"><h6><strong>Especificar (otro):</strong></h6>
  <div class="form-group">
   <input type="text" class="form-control" name="esp">
 </div>
 </div>
</div>
  </div>
</div>

<hr>
<center><h6><strong>Exploración física</strong></h6></center>
<div class="row">
  <div class="col"><strong><br>SIGNOS VITALES</strong></div>
    <div class="row">
      <div class="col">
      TA:<br><input type="number" name="ta_sisto" placeholder="mmHg"  id="p_sistolica"  value=""   required> / <label for="p_sistolica"><input type="number" name="ta_diasto"   placeholder="mmHg" id="p_diastolica"   value="" required>
      </div>
    </div>
  <div class="col">FC:<input type="text" name="fc" class="form-control" placeholder="FC:" required></div>
  <div class="col">FR:<input type="text" name="fr" class="form-control" placeholder="FR:" required></div>
  <div class="col">TEMP:<input type="text" name="tempe" class="form-control" placeholder="TEMP:" required></div>


<div class="col losInput">Peso:<input type="text" name="pes" class="form-control" placeholder="PESO:" required id="pes" minlength="2" maxlength="7"></div>
<div class="col losInput">Talla (m):<input type="text" name="tall" class="form-control" placeholder="TALLA:" required id="tall" maxlength="4"></div>

<div class="col inputTotal">IMC:<input type="text" name="imc" class="form-control" placeholder="IMC:" required id="imc" disabled="">
</div>

</div>


            <hr>
<div class="row">
  <div class="col col-2"><strong><br><br>VÍA ÁREA</strong></div>
  <div class="col"><br>Mallampati<input type="text" name="malla" class="form-control" required></div>
  <div class="col"><br>Patil aldreti<input type="text" name="patil" class="form-control" required></div>
  <div class="col"><br>Bellhouse-dore<input type="text" name="bell" class="form-control" required></div>
  <div class="col">Distancia esternomentoneana<input type="text" name="dist" class="form-control"required ></div>
  <div class="col"><br>Buco-dental<input type="text" name="buco" class="form-control" required></div>
</div>
                    Observaciones<input type="text" name="obserb" class="form-control" required>
        <hr>

<div class="container">
    <div class="row">
<div class="col-sm-3">
    Goldman riesgo cardiovascular:
</div>
<div class="col-sm-3">
    <select class="form-control" name="goldman">
    <option value="">Seleccionar goldman</option>

<option value="I">I</option>
<option value="II">II</option>
<option value="III">III</option>
<option value="IV">IV</option>

</select>

</div>
<div class="col-sm-1">
    </div>
<div class="col-sm-1">
    Asa:
</div>
    <div class="col-sm-3">

<select class="form-control" name="asa">
    <option value="">Seleccionar Asa</option>
    <option value="I">I</option>
    <option value="II">II</option>
    <option value="III">III</option>
    <option value="IV">IV</option>
    <option value="V">V</option>
    <option value="VI">VI</option>
</select>
</div>

    </div>
</div>
<p></p>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
        Hepatico
        <input type="text" name="hepatico" class="form-control">
        </div>
         <div class="col-sm-3">
        Vía aérea
        <input type="text" name="aerea" class="form-control">
        </div>
         <div class="col-sm-3">
        Tromboembolica
        <input type="text" name="tromboe" class="form-control">
        </div>
         <div class="col-sm-3">
        Quirúrgico
        <input type="text" name="quirur" class="form-control">
        </div>
         <div class="col-sm-3">
        Nauseas vomito
        <input type="text" name="nauv" class="form-control">
        </div>
        <div class="col-sm-3">
        Otros riesgos
        <input type="text" name="otr" class="form-control">
        </div>
        </div>
        </div>
        <hr>
       <center><strong>Soluciones</strong></center> 
        <div class="container">
    <div class="row">
        <div class="col-sm-3">
            Ingresos (Descripción) <input type="text" name="ingresos" class="form-control">
            </div>
             <div class="col-sm-3">
            Cantidad <input type="text" name="ingresosc" class="form-control">
            </div>
              <div class="col-sm-3">
            Egresos (Descripción) <input type="text" name="egresos" class="form-control">
            </div>
             <div class="col-sm-3">
            Cantidad <input type="text" name="egresosc" class="form-control">
            </div>
         </div>
          </div>

<hr>
  <div class="row">
    <div class="col-sm-3">
   <br><hr>Fecha <input type="date" name="fecha" class="form-control" required>
    </div>
  <div class="col-sm-9">
   <center><strong>Laboratorio</strong></center><hr>
    <div class="row">
  <div class="col">Biometría<input type="text" name="hb" class="form-control" required></div>
  <div class="col">Química<input type="text" name="hto" class="form-control" required></div>
  <div class="col">Pruebas de funcionamiento<input type="text" name="gb" class="form-control" required></div>
  <div class="col">Tiempos de coagulación<input type="text" name="gr" class="form-control" required></div>
  <div class="col">Tiempos de procesado<input type="text" name="plaq" class="form-control" required></div>
  <!--<div class="col">TP<input type="text" name="tp" class="form-control" required></div>
  <div class="col">TPT<input type="text" name="tpt" class="form-control" required></div>
  
</div>
  <div class="row">
  <div class="col">INR<input type="text" name="inr" class="form-control" required></div>
  <div class="col">GLUC<input type="text" name="gluc" class="form-control" required></div>
  <div class="col">CR<input type="text" name="cr" class="form-control"required></div>
  <div class="col">BUN<input type="text" name="bun" class="form-control" required></div>
  <div class="col">UREA<input type="text" name="urea" class="form-control" required></div>
  <div class="col">E.S.<input type="text" name="es" class="form-control" required></div>-->
  
</div>
  <!--<div class="row">
  <div class="col">Otros<input type="text" name="otros" class="form-control"></div>

  
</div>-->

    </div>

</div>

<hr>
<div class="row">
  <div class="col"><strong>Gabinete: </strong><input required type="text" name="gab" class="form-control"></div>
  <div class="col"><strong>Valoración cardiovascular: </strong><input required type="text" name="valcard" class="form-control"></div>
</div><br>
<div class="row">
  <div class="col"><strong>Condición física asa: </strong><input required type="text" name="condfis" class="form-control"></div>
  <div class="col"><strong>Tipo de anestesia propuesta: </strong><input required type="text" name="tipanest" class="form-control"></div>
</div><br>
<div class="row">
  <div class="col"><strong>Indicación preanestésica: </strong><input required type="text" name="indpre" class="form-control"></div>
  <div class="col"><strong>Observaciones: </strong><input required type="text" name="obs" class="form-control" ></div>
</div>
<br>
<!--<strong>NOMBRE COMPLETO DEL RESIDENTE QUE COLABORA EN LA VALORACIÓN: </strong><input required type="text" name="nomres" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

 <strong>NOMBRE COMPLETO DEL ANESTÉSIOLOGO: </strong><input required type="text" name="nomanest" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
 -->

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

$('.losInput input').on('change', function(){
  var total = 0;
  var pes, tall, imc;
   pes=document.getElementById("pes").value;
  tall=document.getElementById("tall").value;
  $('.losInput input').each(function() {
    if($( this ).val() != "")
    {
        parseInt(total=pes/(tall*tall));
    }
  });
   
  $('.inputTotal input').val(total.toFixed(2));

});

</script>


</body>
</html>