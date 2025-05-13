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


<title>DATOS INDICACIONES MÉDICAS</title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
                 <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>INDICACIONES MÉDICAS</strong></center><p>
</div>
             
                <hr>
                <?php

                include "../../conexionbd.php";

                $resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion, dat_ingreso.alta_med, dat_ingreso.alergias
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);

                ?>
                <?php
                while ($f1 = mysqli_fetch_array($resultado1)) {
                    $id_atencion = $f1['id_atencion']; 
                    $pac_papell = $f1['papell'];
                    $pac_sapell = $f1['sapell'];
                    $pac_nom_pac = $f1['nom_pac'];
                    $pac_dir = $f1['dir'];
                    $pac_id_edo = $f1['id_edo'];
                    $pac_id_mun = $f1['id_mun'];
                    $pac_tel = $f1['tel'];
                    $pac_fecnac = $f1['fecnac'];
                    $pac_fecing = $f1['fecha'];
                    $pac_tip_sang = $f1['tip_san'];
                    $pac_sexo = $f1['sexo'];
                    $area = $f1['area'];
                    $alta_med = $f1['alta_med'];
                    $id_exp = $f1['Id_exp'];
                    $folio = $f1['folio'];
                    $alergias = $f1['alergias'];
                    $fecha_actual1 = date("Y-m-d");
                    

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
 <div class="col-sm-4">
      Habitación: <strong><?php $sql_hab = "SELECT num_cama,tipo from cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);                                                                                    while ($row_hab = $result_hab->fetch_assoc()) {
  echo $row_hab['num_cama'].' '.$row_hab['tipo'];
} ?></strong>
    </div>   
</div> 

    <div class="row">
   <?php
$d="";
$sql_motd = "SELECT diagprob_i from dat_not_ingreso where id_atencion=$id_atencion ORDER by id_not_ingreso DESC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } 
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
    <div class="col-sm-4">
      Talla: <strong><?php echo $talla ?></strong>
  </div>
  
</div>
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
  <center><strong>SIGNOS VITALES</strong></center>
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
        
    </div> mmHG   /   mmHG
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
  <center><strong>SIGNOS VITALES</strong></center>
</div>

<div class="container"> 
  <div class="row">
    <div class="col-sm-2"><center>Presión arterial:</center>
        <div class="row">
            <div class="col"><input type="text" class="form-control" name="p_sistol" ></div> /
            <div class="col"><input type="text" class="form-control" name="p_diastol"></div>
        </div>mmHG   /   mmHG
    </div>
    <div class="col-sm-2">
      Frecuencia cardiaca:<input type="text" class="form-control" name="fcard">
      Latidos por minuto
    </div>
    <div class="col-sm-3">
      Frecuencia respiratoria:<input type="text" class="form-control" name="fresp">
      Respiraciones por minuto
    </div>
    <div class="col-sm-2">
     Temperatura:<input type="text" class="form-control"  name="temper">°C
    </div>
    <div class="col-sm-2">
     Saturación oxígeno:<input type="text"  class="form-control" name="satoxi">%
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
$resultado5=$conexion->query("select * from dat_ordenes_med WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_ord_med DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
      $oatencion=$f5['id_ord_med'];
    }
    ?>
 <?php
if (isset($oatencion)) {
                        ?>
<?php 
include "../../conexionbd.php";
$resultado5=$conexion->query("select * from dat_ordenes_med WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_ord_med DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
    ?>

<?php 
//$id_ord=$_GET['id_ord'];
$tras=("SELECT * FROM dat_ordenes_med WHERE id_atencion=" . $_SESSION ['hospital']."  ORDER BY id_ord_med DESC LIMIT 1");
$result=$conexion->query($tras);
while ($row=$result->fetch_assoc()) {
    $perfillab=$row['perfillab'];
    $sol_estudios=$row['sol_estudios'];
    $solicitud_sang=$row['solicitud_sang'];
 ?>            
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>PRESCRIPCIÓN Y ÓRDENES: PREPARACIÓN DE CASOS QUIRÚRGICOS, DIETAS, ETC.</strong></center><p>
</div>
            <div class="row">
                <div class="col-2">
                    <center><p><p><strong><label for="exampleFormControlTextarea1"><font size="3" color="#2b2d7f">1.- Dieta: <button type="button" class="btn btn-success btn-sm" id="pla1"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                       <div class="col-sm-4">
                    <div class="form-group">
                        
                        <select class="form-control" name="dieta" required id="dieta">
                            <option value="<?php echo $row['dieta'] ?>"><?php echo $row['dieta'] ?></option>
                            
                             <?php
                            $sql_d = "SELECT DISTINCT id_dieta,dieta FROM cat_dietas WHERE dieta_activo='SI'ORDER by dieta";
                            $result_d = $conexion->query($sql_d);
                            while ($row_d = $result_d->fetch_assoc()) {
                                echo "<option value='" . $row_d['dieta'] . "'>" . $row_d['dieta'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
<script type="text/javascript">
const dieta = document.getElementById('dieta');
const btnPlayTex1 = document.getElementById('pla1');
btnPlayTex1.addEventListener('click', () => {
        leerTexto(dieta.value);
});

function leerTexto(dieta){
    const speech = new SpeechSynthesisUtterance();
    speech.text= dieta;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
            <div class="row">
                <div class="col-2">
                    <center><p><strong><label for="exampleFormControlTextarea1"><font size="3" color="#2b2d7f">Detalle de dieta: <button type="button" class="btn btn-success btn-sm" id="pla2"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                       <div class="form-group col-8">
                        <input type="text" name="det_dieta" value="<?php echo $row['det_dieta']?>" class="form-control" id="t1" >
                    </div>
            </div>
<script type="text/javascript">
const t1 = document.getElementById('t1');
const btnPlayTex2 = document.getElementById('pla2');
btnPlayTex2.addEventListener('click', () => {
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

<div class="col-3">
                    <center><p><p><strong><label for="exampleFormControlTextarea1"><font size="3" color="#2b2d7f">2.- Cuidados generales:</font></label></strong></center>
                </div>
<div class="container">

    <div class="row">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
        <strong><font color="#2b2d7f"><center>Detalle de indicaciones</center></font></strong><p>
        </div>
    </div>
</div>
 
<div class="container-fluid">
   
    <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Signos vitales por turno</font></strong>
                    </div>
                    <?php if ($row['signos'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="signos" id="signos" value="SI">
                            <label class="form-check-label" for="signos">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="signos" id="signos2" value="NO" checked>
                            <label class="form-check-label" for="signos2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="signos" id="signos" value="SI">
                            <label class="form-check-label" for="signos">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="signos" id="signos2" value="NO" checked>
                            <label class="form-check-label" for="signos2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detsignos" value="<?php echo $row['detsignos'] ?>" class="form-control">                                   
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Monitoreo constante</font></strong>
                    </div>
                     <?php if ($row['monitoreo'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="monitoreo" id="monitoreo" value="SI" checked>
                            <label class="form-check-label" for="monitoreo">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="monitoreo" id="monitoreo2" value="NO" >
                            <label class="form-check-label" for="monitoreo2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="monitoreo" value="SI">
                            <label class="form-check-label" for="monitoreo">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="monitoreo" value="NO" checked>
                            <label class="form-check-label" for="signos2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detmonitoreo" class="form-control" value="<?php echo $row['detmonitoreo'] ?>" >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Diuresis por turno</font></strong>
                    </div>
                     <?php if ($row['diuresis'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="diuresis" id="diuresis" value="SI" checked>
                            <label class="form-check-label" for="diuresis">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="diuresis" id="diuresis2" value="NO" >
                            <label class="form-check-label" for="diuresis2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="diuresis" value="SI">
                            <label class="form-check-label" for="diuresis">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="diuresis" value="NO" checked>
                            <label class="form-check-label" for="diuresis">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detdiuresis" class="form-control" value="<?php echo $row['detdiuresis'] ?>">
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Dextrostix por turno</font></strong>
                    </div>
                    <?php if ($row['dex'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dex" id="dex" value="SI" checked>
                            <label class="form-check-label" for="dex">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dex" id="dex2" value="NO" >
                            <label class="form-check-label" for="dex2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dex" value="SI">
                            <label class="form-check-label" for="dex">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dex" value="NO" checked>
                            <label class="form-check-label" for="dex">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detdex" class="form-control" value="<?php echo $row['detdex'] ?>" 
                                 >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Posición semifowler</font></strong>
                    </div>
                    <?php if ($row['semif'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="semif" id="semif" value="SI" checked>
                            <label class="form-check-label" for="semif">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="semif" id="semif2" value="NO" >
                            <label class="form-check-label" for="semif2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="semif" value="SI">
                            <label class="form-check-label" for="semif">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="semif" value="NO" checked>
                            <label class="form-check-label" for="semif">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detsemif" class="form-control" value="<?php echo $row['detsemif'] ?>" 
                                 >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Vigilar datos del paciente neurológico</font></strong>
                    </div>
                    <?php if ($row['vigilar'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="vigilar" id="vigilar" value="SI" checked>
                            <label class="form-check-label" for="vigilar">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="vigilar" id="vigilar2" value="NO" >
                            <label class="form-check-label" for="vigilar2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="vigilar" value="SI">
                            <label class="form-check-label" for="vigilar">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="vigilar" value="NO" checked>
                            <label class="form-check-label" for="vigilar">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detvigilar" class="form-control" value="<?php echo $row['detvigilar'] ?>" 
                                 >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Oxígeno</font></strong>
                    </div>
                    <?php if ($row['oxigeno'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="oxigeno" id="oxigeno" value="SI" checked>
                            <label class="form-check-label" for="oxigeno">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="oxigeno" id="oxigeno2" value="NO" >
                            <label class="form-check-label" for="oxigeno2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="oxigeno" value="SI">
                            <label class="form-check-label" for="oxigeno">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="oxigeno" value="NO" checked>
                            <label class="form-check-label" for="oxigeno">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
                     <input type="text" name="detoxigeno" class="form-control" value="<?php echo $row['detoxigeno'] ?>"  >
                     </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Nebulizaciones</font></strong>
                    </div>
                    <?php if ($row['nebulizacion'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="nebu" id="nebu" value="SI" checked>
                            <label class="form-check-label" for="nebu">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="nebu" id="nebu2" value="NO" >
                            <label class="form-check-label" for="nebu2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="nebu" value="SI">
                            <label class="form-check-label" for="nebu">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="nebu" value="NO" checked>
                            <label class="form-check-label" for="nebu">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detnebu" class="form-control" value="<?php echo $row['detnebu'] ?>" 
                                  >
                </div>
            </div>
            </div>
<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Barandales en alto</font></strong>
                    </div>
                    <?php if ($row['bar'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bar" id="bar" value="SI" checked>
                            <label class="form-check-label" for="bar">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bar" id="bar2" value="NO" >
                            <label class="form-check-label" for="bar2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bar" value="SI">
                            <label class="form-check-label" for="bar">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bar" value="NO" checked>
                            <label class="form-check-label" for="bar">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detbar" class="form-control" value="<?php echo $row['detbar'] ?>" 
                                 >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Baño diario y deambulación asistida</font></strong>
                    </div>
                    <?php if ($row['baño'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="baño" id="baño" value="SI" checked>
                            <label class="form-check-label" for="baño">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="baño" id="baño2" value="NO" >
                            <label class="form-check-label" for="baño2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="baño" value="SI">
                            <label class="form-check-label" for="baño">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="baño" value="NO" checked>
                            <label class="form-check-label" for="baño">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detbaño" class="form-control" value="<?php echo $row['detbaño'] ?>" 
                                 >
                </div>
            </div>
        </div>
<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Cuidados de sonda foley</font></strong>
                    </div>
                     <?php if ($row['foley'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="foley" id="foley" value="SI" checked>
                            <label class="form-check-label" for="foley">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="foley" id="foley2" value="NO" >
                            <label class="form-check-label" for="foley2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="foley" value="SI">
                            <label class="form-check-label" for="foley">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="foley" value="NO" checked>
                            <label class="form-check-label" for="foley">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detfoley" class="form-control" value="<?php echo $row['detfoley'] ?>" 
                                  >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Ejercicios respiratorios</font></strong>
                    </div>
                    <?php if ($row['ej'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ej" id="ej" value="SI" checked>
                            <label class="form-check-label" for="ej">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ej" id="ej2" value="NO" >
                            <label class="form-check-label" for="ej2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ej" value="SI">
                            <label class="form-check-label" for="ej">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ej" value="NO" checked>
                            <label class="form-check-label" for="ej">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                     <div class="col-sm-6">
     <input type="text" name="detej" class="form-control" value="<?php echo $row['detej'] ?>" 
                                  >
                </div>
                  
    </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Vigilar datos de sangrado</font></strong>
                    </div>
                    <?php if ($row['datsan'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="datsan" id="datsan" value="SI" checked>
                            <label class="form-check-label" for="datsan">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="datsan" id="datsan2" value="NO" >
                            <label class="form-check-label" for="datsan2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="datsan" value="SI">
                            <label class="form-check-label" for="datsan">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="datsan" value="NO" checked>
                            <label class="form-check-label" for="datsan">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
    <div class="col-sm-6">
     <input type="text" name="detsan" class="form-control" value="<?php echo $row['detsan'] ?>" 
                                 >
    </div>
                </div>
            </div>


<!--   
<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">CURVA TÉRMICA/CONTROL POR MEDIOS FÍSICOS</font></strong>
                    </div>
                    <?php if ($row['cur'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cur" id="cur" value="SI" checked>
                            <label class="form-check-label" for="cur">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cur" id="cur2" value="NO" >
                            <label class="form-check-label" for="cur2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else {?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cur" value="SI">
                            <label class="form-check-label" for="cur">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cur" value="NO" checked>
                            <label class="form-check-label" for="cur">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
    <div class="col-sm-6">
     <input type="text" name="curt" class="form-control" value="<?php echo $row['curt'] ?>" 
                                 >
    </div>
    </div>
    </div>

    



<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                       <strong><font color="#2b2d7f">CONTROL LÍQUIDOS/CUANTIFICAR URESIS ML</font></strong>
                    </div>
                    <?php if ($row['conl'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="conl" id="conl" value="SI" checked>
                            <label class="form-check-label" for="conl">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="conl" id="conl2" value="NO" >
                            <label class="form-check-label" for="conl2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="conl" value="SI">
                            <label class="form-check-label" for="conl">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="conl" value="NO" checked>
                            <label class="form-check-label" for="conl">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
    <div class="col-sm-6">
     <input type="text" name="conlt" class="form-control" value="<?php echo $row['conlt'] ?>" 
                                 >
    </div>
    </div>
    </div>

-->
  
  <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Glucometría capilar <br> Reportar < 80 ó > 180 mg/dl</font></strong>
                    </div>
                    <?php if ($row['gca'] == "SI") {?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gca" id="gca" value="SI" checked>
                            <label class="form-check-label" for="gca">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gca" id="gca2" value="NO" >
                            <label class="form-check-label" for="gca2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gca" value="SI">
                            <label class="form-check-label" for="gca">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gca" value="NO" checked>
                            <label class="form-check-label" for="gca">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                    <div class="col-sm-6">
     <input type="text" name="gcat" class="form-control" value="<?php echo $row['gcat'] ?>" 
                                 >
    </div>
                </div>
            </div>

  <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Sonda nasogástrica a derivación</font></strong>
                    </div>
                    <?php if ($row['son'] == "SI") { ?>
                    <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="son" id="son" value="SI" checked>
                            <label class="form-check-label" for="son">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="son" id="son2" value="NO" >
                            <label class="form-check-label" for="son2">
                                NO
                            </label>
                        </div>
                    </div>
                <?php }else { ?>
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="son" value="SI">
                            <label class="form-check-label" for="son">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="son" value="NO" checked>
                            <label class="form-check-label" for="son">
                                NO
                            </label>
                        </div>
                    </div>
                <?php } ?>
                    <div class="col-sm-6">
     <input type="text" name="sont" class="form-control" value="<?php echo $row['sont']; ?>" 
                                 >
    </div>
                </div>
            </div>
<p>
<div class="container">
                <div class="row">
                    <div class="col-sm">
                        <strong><label for="exampleFormControlTextarea1"><font size="3" color="#2b2d7f">
                                    OTROS: <button type="button" class="btn btn-success btn-sm" id="pla3"><i class="fas fa-play"></button></i>
 </font></label></strong>
                    </div>
           
                    <div class="col-sm-10">
      <input type="text" name="observ_be" value="<?php echo $row['observ_be'] ?>" class="form-control"  id="t3">
    </div>
                </div>
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
<br>


            

            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">3.- Medicamentos:
                                <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="medg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="toss"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla5"><i class="fas fa-play"></button></i>
</div></font></label></strong></center>
                </div>
                <div class=" col-10">

<div class="form-group">
    <textarea name="med_med" id="txt" class="form-control" rows="5"><?php echo $row['med_med'] ?></textarea>
                       <!-- <input type="text" name="med_med" class="form-control" value="<?php echo $row['med_med'] ?>" > -->
<script type="text/javascript">
const medg = document.getElementById('medg');
const toss = document.getElementById('toss');
const txt = document.getElementById('txt');

const btnPlayTex5 = document.getElementById('pla5');
btnPlayTex5.addEventListener('click', () => {
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


     let rem = new webkitSpeechRecognition();
      rem.lang = "es-ES";
      rem.continuous = true;
      rem.interimResults = false;

      rem.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txt.value += frase;
      }

      medg.addEventListener('click', () => {
        rem.start();
      });

      toss.addEventListener('click', () => {
        rem.abort();
      });
</script>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">4.- Soluciones: <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="solg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="ionesstop"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla6"><i class="fas fa-play"></button></i>
</div></font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group">
<textarea name="soluciones" id="txtseol" class="form-control" rows="5"><?php echo $row['soluciones'] ?></textarea>
                      <!--  <input type="text" name="soluciones" class="form-control" value="<?php echo $row['soluciones'] ?>" > -->
<script type="text/javascript">
const solg = document.getElementById('solg');
const ionesstop = document.getElementById('ionesstop');
const txtseol = document.getElementById('txtseol');

const btnPlayTex6 = document.getElementById('pla6');
btnPlayTex6.addEventListener('click', () => {
        leerTexto(txtseol.value);
});

function leerTexto(txtseol){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtseol;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let renesol = new webkitSpeechRecognition();
      renesol.lang = "es-ES";
      renesol.continuous = true;
      renesol.interimResults = false;

      renesol.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtseol.value += frase;
      }

      solg.addEventListener('click', () => {
        renesol.start();
      });

      ionesstop.addEventListener('click', () => {
        renesol.abort();
      });
</script>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">5.- Estudios Laboratorio: <button type="button" class="btn btn-success btn-sm" id="pla7"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                <div class="col-sm-5">
                    <div class="form-group"><br><br>
                       <p><strong><?php echo $row['perfillab'] ?></strong></p>
                      
                        <select id="l1" name="l1[]" multiple="multiple" class="form-control" required="" >
                            <option value="NINGUNO" selected="NINGUNO" >NINGUNO</option>
                            <?php
                            $sql_serv = "SELECT * FROM cat_servicios c where tipo = 1 and serv_activo = 'SI'";
                            $result_serv = $conexion->query($sql_serv);
                            while ($row_serv = $result_serv->fetch_assoc()) {
                                echo "<option value='" . $row_serv['serv_desc'] . "'>" . $row_serv['serv_desc'] . "</option>";
                            }
                            ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#l1').multiselect({
                                    nonSelectedText: 'SELECCIONA SERVICIO(S)',
                                    includeSelectAllOption: false,
                                    buttonWidth: 250,
                                    maxHeight: 200,
                                    enableFiltering: true,
                                    dropUp: false,
                                    enableCaseInsensitiveFiltering: true
                                   
                                });
                            });
                        </script>
                    </div>

                 <!--   <div class="form-group">
                        <label for="sol_estudios"><strong>SOLICITUD DE ESTUDIOS LABORATORIO:</strong></label>
                        <select class="form-control" data-live-search="true" name="perfillab">
                            <option value="NINGUNO">NINGUNO</option>
                            <?php
                            $sql_serv = "SELECT DISTINCT nombre FROM paquetes_labo p,cat_servicios c WHERE p.estudio_id=c.id_serv";
                            $result_serv = $conexion->query($sql_serv);
                            while ($row_serv = $result_serv->fetch_assoc()) {
                                echo "<option value='" . $row_serv['nombre'] . "'>" . $row_serv['nombre'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>-->
                </div>
<script type="text/javascript">
const l1 = document.getElementById('l1');
const btnPlayTex7 = document.getElementById('pla7');
btnPlayTex7.addEventListener('click', () => {
        leerTexto(l1.value);
});

function leerTexto(l1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= l1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
                 <div class="col-sm-5">Detalle estudios laboratorio<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="detalleg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="labos"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla8"><i class="fas fa-play"></button></i>
</div><br>
<textarea class="form-control" name="detalle_lab" id="txtl" rows="5"><?php echo $row['detalle_lab']?></textarea>
<script type="text/javascript">
const detalleg = document.getElementById('detalleg');
const labos = document.getElementById('labos');
const txtl = document.getElementById('txtl');

const btnPlayTex8 = document.getElementById('pla8');
btnPlayTex8.addEventListener('click', () => {
        leerTexto(txtl.value);
});

function leerTexto(txtl){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtl;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 

     let relav = new webkitSpeechRecognition();
      relav.lang = "es-ES";
      relav.continuous = true;
      relav.interimResults = false;

      relav.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtl.value += frase;
      }

      detalleg.addEventListener('click', () => {
        relav.start();
      });

      labos.addEventListener('click', () => {
        relav.abort();
      });
</script>
 </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">6.- Estudios imagenología: <button type="button" class="btn btn-success btn-sm" id="pla9"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                <div class="col-sm-5">

                    <div class="form-group">
                       <!-- <label for="sol_imagen"><strong>SOLICITUD DE ESTUDIOS IMAGENOLOGIA:</strong></label><br>--><br><p>
                        <p><strong><?php echo $row['sol_estudios']?></strong></p>
                        <select id="a1" name="a1[]" multiple="multiple" class="form-control" required="">
                            <option value="NINGUNO" selected="NINGUNO">NINGUNO</option>
                            <?php
                            $sql_serv = "SELECT * FROM cat_servicios where tipo =2 and serv_activo = 'SI'";
                            $result_serv = $conexion->query($sql_serv);
                            while ($row_serv = $result_serv->fetch_assoc()) {
                                echo "<option value='" . $row_serv['serv_desc'] . "'>" . $row_serv['serv_desc'] . "</option>";
                            }
                            ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#a1').multiselect({
                                    nonSelectedText: 'Selecciona servicio(s)',
                                    includeSelectAllOption: false,
                                    buttonWidth: 250,
                                    maxHeight: 200,
                                    enableFiltering: true,
                                    dropUp: false,
                                    enableCaseInsensitiveFiltering: true
                                });
                            });
                        </script>
                    </div>
                </div>
                                <div class="col-sm-5"><br><br>Detalle estudios imagenología:
          <input type="text" class="form-control" name="det_imagen" value="<?php echo $row['det_imagen']?>">
        </div>
            </div>
<script type="text/javascript">
const a1 = document.getElementById('a1');

const btnPlayTex9 = document.getElementById('pla9');
btnPlayTex9.addEventListener('click', () => {
        leerTexto(a1.value);
});

function leerTexto(a1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= a1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 

</script>
     <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">7.- Estudios patología: <button type="button" class="btn btn-success btn-sm" id="pla10"><i class="fas fa-play"></button></i> </font></label></strong></center>
                </div>
                <div class="col-sm-5">

                    <div class="form-group">
                        <br>
                       <p><strong><?php echo $row['sol_pato']?></strong></p>
                       <select id="p1" name="p1[]" multiple="multiple" class="form-control" required="">
                            <option value="NINGUNO" selected="NINGUNO">NINGUNO</option>
                            <?php
                            $sql_serv = "SELECT * FROM cat_servicios where tipo =6 and serv_activo = 'SI'";
                            $result_serv = $conexion->query($sql_serv);
                            while ($row_serv = $result_serv->fetch_assoc()) {
                                echo "<option value='" . $row_serv['serv_desc'] . "'>" . $row_serv['serv_desc'] . "</option>";
                            }
                            ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#p1').multiselect({
                                    nonSelectedText: 'Selecciona servicio(s)',
                                    includeSelectAllOption: false,
                                    buttonWidth: 250,
                                    maxHeight: 200,
                                    enableFiltering: true,
                                    dropUp: false,
                                    enableCaseInsensitiveFiltering: true
                                });
                            });
                        </script>
                    </div>
                </div>
<script type="text/javascript">
const p1 = document.getElementById('p1');

const btnPlayTex10 = document.getElementById('pla10');
btnPlayTex10.addEventListener('click', () => {
        leerTexto(p1.value);
});

function leerTexto(p1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= p1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 

</script>
        <div class="col-sm-5"><br>Detalle estudios patología: <button type="button" class="btn btn-success btn-sm" id="pla11"><i class="fas fa-play"></button></i><br>
          <input type="text" class="form-control" name="det_pato" id="tt1" value="<?php echo $row['det_pato']?>">
        </div>
    </div>
<script type="text/javascript">
const tt1 = document.getElementById('tt1');

const btnPlayTex11 = document.getElementById('pla11');
btnPlayTex11.addEventListener('click', () => {
        leerTexto(tt1.value);
});

function leerTexto(tt1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= tt1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 

</script>


            <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">8.- Solicitud transfusión sanguínea: <button type="button" class="btn btn-success btn-sm" id="pla12"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                <div class="col-sm-5">

                    <div class="form-group">
                        <!--<label for="sol_imagen"><strong> SOLICITUD DE TRANSFUSIÓN SANGUINEA:</strong></label>-->
                        <br><br>
                        <p><strong><?php echo $row['solicitud_sang'] ?></strong></p>
                        <select id="s1" name="s1[]" multiple="multiple" class="form-control" required="">
                            <option value="NINGUNO" selected="NINGUNO">NINGUNO</option>
                            <?php
                            $sql_serv = "SELECT * FROM cat_servicios where tipo =5 and serv_activo = 'SI'";
                            $result_serv = $conexion->query($sql_serv);
                            while ($row_serv = $result_serv->fetch_assoc()) {
                                echo "<option value='" . $row_serv['serv_desc'] . "'>" . $row_serv['serv_desc'] . "</option>";
                            }
                            ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#s1').multiselect({
                                    nonSelectedText: 'Selecciona servicio(s)',
                                    includeSelectAllOption: false,
                                    buttonWidth: 250,
                                    maxHeight: 200,
                                    enableFiltering: true,
                                    dropUp: false,
                                    enableCaseInsensitiveFiltering: true
                                });
                            });
                        </script>
                    </div>
                </div>
<script type="text/javascript">
const s1 = document.getElementById('s1');

const btnPlayTex12 = document.getElementById('pla12');
btnPlayTex12.addEventListener('click', () => {
        leerTexto(s1.value);
});

function leerTexto(s1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= s1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 

</script>
 <div class="col-sm-5">Detalle de transfusión sanguínea<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="sang"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopsa"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla13"><i class="fas fa-play"></button></i>
</div><br>
<textarea class="form-control" id="txtstr" name="det_sang" rows="5"><?php echo $row['det_sang']?></textarea>
<script type="text/javascript">
const sang = document.getElementById('sang');
const stopsa = document.getElementById('stopsa');
const txtstr = document.getElementById('txtstr');

const btnPlayTex13 = document.getElementById('pla13');
btnPlayTex13.addEventListener('click', () => {
        leerTexto(txtstr.value);
});

function leerTexto(txtstr){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtstr;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let reddts = new webkitSpeechRecognition();
      reddts.lang = "es-ES";
      reddts.continuous = true;
      reddts.interimResults = false;

      reddts.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtstr.value += frase;
      }

      sang.addEventListener('click', () => {
        reddts.start();
      });

      stopsa.addEventListener('click', () => {
        reddts.abort();
      });
</script>
 </div>


              
            </div>
            
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>PROCEDIMIENTOS EN MEDICINA DE TRATAMIENTO</strong></center><p>
</div>
<div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f"> Diálisis:<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i>
</div></font></label></strong></center>

                </div>

                <div class=" col-10">
                    <div class="form-group">
<textarea name="dialisis" class="form-control" id="texto" rows="5"><?php echo $row['dialisis'] ?></textarea>
        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f"> Fisioterapía:<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i>
</div></font></label></strong></center>

                </div>

                <div class=" col-10">
                    <div class="form-group">
<textarea name="fisio" class="form-control" id="texto" rows="5"><?php echo $row['fisio'] ?></textarea>
        
                    </div>
                </div>
            </div>
<div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f"> Inhaloterapia:<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i>
</div></font></label></strong></center>

                </div>

                <div class=" col-10">
                    <div class="form-group">
<textarea name="cuid_gen" class="form-control" id="texto" rows="5"><?php echo $row['cuid_gen'] ?></textarea>
                   <!--  <input type="text" name="cuid_gen" class="form-control" value="<?php echo $row['cuid_gen'] ?>" > -->
                   <script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btnPlayTex4 = document.getElementById('pla4');
btnPlayTex4.addEventListener('click', () => {
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
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f"> Rehabilitación:<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i>
</div></font></label></strong></center>

                </div>

                <div class=" col-10">
                    <div class="form-group">
<textarea name="reha" class="form-control" id="texto" rows="5"><?php echo $row['reha'] ?></textarea>
        
                    </div>
                </div>
            </div>
<?php } ?>
            <?php
            $usuario = $_SESSION['login'];
            ?>
            <hr>
 


            <div class="row">
                <div class="col align-self-start">
                    <strong>Médico:</strong> <input type="text" name="" class="form-control"
                                                    value="<?php echo $usuario['papell']; ?> <?php echo $usuario['sapell']; ?>"
                                                    disabled>
                </div>
                <div class="col align-self-center">
                    <strong>Cédula profesional:</strong><input type="text" name="" class="form-control"
                                                      value="<?php echo $usuario['cedp']; ?>" disabled="">

                </div>

            </div>
            <hr>
            <div class="container">
                <div class="row">
                    <div class="col align-self-start">
                    </div>
                    <button type="submit" name="guardar" class="btn btn-primary">Firmar</button> &nbsp;
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

        $dieta    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dieta"], ENT_QUOTES))); //Escanpando caracteres
       $cuid_gen    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cuid_gen"], ENT_QUOTES))); //Escanpando caracteres
        $signos   = mysqli_real_escape_string($conexion, (strip_tags($_POST["signos"], ENT_QUOTES)));
        $monitoreo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["monitoreo"], ENT_QUOTES))); //Escanpando caracteres
        $diuresis    = mysqli_real_escape_string($conexion, (strip_tags($_POST["diuresis"], ENT_QUOTES)));
        $dex    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dex"], ENT_QUOTES)));
        $semif    = mysqli_real_escape_string($conexion, (strip_tags($_POST["semif"], ENT_QUOTES)));
        $vigilar    = mysqli_real_escape_string($conexion, (strip_tags($_POST["vigilar"], ENT_QUOTES)));
        $oxigeno    = mysqli_real_escape_string($conexion, (strip_tags($_POST["oxigeno"], ENT_QUOTES)));
        $nebu    = mysqli_real_escape_string($conexion, (strip_tags($_POST["nebu"], ENT_QUOTES)));
        $bar    = mysqli_real_escape_string($conexion, (strip_tags($_POST["bar"], ENT_QUOTES)));
        $baño    = mysqli_real_escape_string($conexion, (strip_tags($_POST["baño"], ENT_QUOTES)));
        $foley   = mysqli_real_escape_string($conexion, (strip_tags($_POST["foley"], ENT_QUOTES)));
        $ej    = mysqli_real_escape_string($conexion, (strip_tags($_POST["ej"], ENT_QUOTES)));
        $datsan    = mysqli_real_escape_string($conexion, (strip_tags($_POST["datsan"], ENT_QUOTES)));
       
        $detsignos    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detsignos"], ENT_QUOTES)));
        $detmonitoreo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detmonitoreo"], ENT_QUOTES)));
        $detdiuresis    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detdiuresis"], ENT_QUOTES)));
        $detdex    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detdex"], ENT_QUOTES)));
        $detsemif    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detsemif"], ENT_QUOTES)));
        $detvigilar    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detvigilar"], ENT_QUOTES)));
        $detoxigeno    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detoxigeno"], ENT_QUOTES)));
        $detnebu    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detnebu"], ENT_QUOTES)));
        $detbar    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detbar"], ENT_QUOTES)));
        $detbaño    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detbaño"], ENT_QUOTES)));
        $detfoley    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detfoley"], ENT_QUOTES)));
        $detej    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detej"], ENT_QUOTES)));
        $detsan    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detsan"], ENT_QUOTES)));
        $med_med    =mysqli_real_escape_string($conexion, (strip_tags($_POST["med_med"], ENT_QUOTES)));
        $soluciones    = mysqli_real_escape_string($conexion, (strip_tags($_POST["soluciones"], ENT_QUOTES)));
   $det_dieta    = mysqli_real_escape_string($conexion, (strip_tags($_POST["det_dieta"], ENT_QUOTES)));
   $det_sang = mysqli_real_escape_string($conexion, (strip_tags($_POST['det_sang'], ENT_QUOTES)));
   $observ_be = mysqli_real_escape_string($conexion, (strip_tags($_POST['observ_be'], ENT_QUOTES)));

   $detalle_lab = mysqli_real_escape_string($conexion, (strip_tags($_POST['detalle_lab'], ENT_QUOTES)));
   /*
   $cur = mysqli_real_escape_string($conexion, (strip_tags($_POST['cur'], ENT_QUOTES)));
   $curt = mysqli_real_escape_string($conexion, (strip_tags($_POST['curt'], ENT_QUOTES)));
   $conl = mysqli_real_escape_string($conexion, (strip_tags($_POST['conl'], ENT_QUOTES)));
   $conlt = mysqli_real_escape_string($conexion, (strip_tags($_POST['conlt'], ENT_QUOTES)));*/
   $gca = mysqli_real_escape_string($conexion, (strip_tags($_POST['gca'], ENT_QUOTES)));
   $gcat = mysqli_real_escape_string($conexion, (strip_tags($_POST['gcat'], ENT_QUOTES)));
   $son = mysqli_real_escape_string($conexion, (strip_tags($_POST['son'], ENT_QUOTES)));
   $sont = mysqli_real_escape_string($conexion, (strip_tags($_POST['sont'], ENT_QUOTES)));
   $det_pato = mysqli_real_escape_string($conexion, (strip_tags($_POST['det_pato'], ENT_QUOTES)));
$det_imagen = mysqli_real_escape_string($conexion, (strip_tags($_POST['det_imagen'], ENT_QUOTES)));

$dialisis = mysqli_real_escape_string($conexion, (strip_tags($_POST['dialisis'], ENT_QUOTES)));
$fisio = mysqli_real_escape_string($conexion, (strip_tags($_POST['fisio'], ENT_QUOTES)));
$reha = mysqli_real_escape_string($conexion, (strip_tags($_POST['reha'], ENT_QUOTES)));

$fecha_actual = date("Y-m-d H:i:s");
$fecha_actual2 = date("Y-m-d H:i:s");
$hora_actual = date("H");

$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];
$resultado=$conexion->query("SELECT * from reg_usuarios WHERE id_usua= $id_usua") or die($conexion->error);
    while ($ROW = mysqli_fetch_array($resultado)) {
 $nombre=$ROW['nombre'];
 $papell=$ROW['papell'];
 $sapell=$ROW['sapell'];
}

$v1 = $_POST['a1'];
$sep = implode(",", $v1);
$servicio = json_encode($sep);
if ($servicio === 'NINGUNO') {
    $servicio = '"NINGUNO"';
}


$s1 = $_POST['s1'];
$sang = implode(",", $s1);
$serv_sang = json_encode($sang);
if ($serv_sang === 'NINGUNO') {
    $serv_sang = '"NINGUNO"';
}

$p1 = $_POST['p1'];
$sol_pato = implode(",", $p1);
$serv_pato = json_encode($sol_pato);
if ($serv_pato === 'NINGUNO') {
    $serv_pato = '"NINGUNO"';
}

$l1 = $_POST['l1'];
$id_laborato = $_POST['l1'];
$perfillab = implode(",", $l1);
$serv_perfillab = json_encode($perfillab);
if ($serv_perfillab === 'NINGUNO') {
    $serv_perfillab = '"NINGUNO"';
}
$sql_hab = "SELECT * FROM cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);
while ($row_hab = $result_hab->fetch_assoc()) {
    $hab = $row_hab['num_cama'];
}

$id_imagenologia = $_POST["a1"]; //Escanpando caracteres
$solicitud_sang = $_POST["s1"]; //Escanpando caracteres
$sol_pato = $_POST["p1"];
$id_patolo = $_POST["p1"];
$perfillab = $_POST["l1"];


$nombre_medico=$papell;

$hora_ord = date("H:i:s");

for ($i = 0; $i < count($id_imagenologia); $i++) {

    $id_imagenologia1 = $id_imagenologia[$i];
    $cta_cant = 1;
    $precio = 0;
    $activo = "SI";
    $prodserv = "S";
    if ($id_imagenologia1 === 'NINGUNO') {
    } else {
            $insertarnot=mysqli_query($conexion,'INSERT INTO notificaciones_imagen
            (id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado,det_imagen,interpretado) values 
            ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.',"'.$id_imagenologia1.'","NO","","'.$det_imagen.'","No")')
            or die('<p>Error al registrar imagen</p><br>' . mysqli_error($conexion));
            $sql_dat_ingi = "SELECT * from cat_servicios where serv_desc='$id_imagenologia1'";
            $result_dat_inga = $conexion->query($sql_dat_ingi);
                while ($row_dat_ingu = $result_dat_inga->fetch_assoc()) {
                    $id_cta = $row_dat_ingu['id_serv'];
                } 
        //   $registracta = mysqli_query($conexion,'INSERT INTO dat_ctapac
        //    (id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo)VALUES 
        //    ('.$id_atencion.',"'.$prodserv.'",'.$id_cta.',"'.$fecha_actual2.'",
        //        '.$cta_cant.','.$precio.','.$id_usua.',"'.$activo.'")')or die('<p>Error al registrar cuenta imagen</p><br>' . mysqli_error($conexion));
     
    }

}


$solicitud_sang1 = $serv_sang;
if ($solicitud_sang1 === '"NINGUNO"') {
    } else {
    $insertarnot=mysqli_query($conexion,'INSERT INTO notificaciones_sangre(id_atencion,habitacion,fecha_ord,id_usua,sol_sangre,realizado,resultado,det_sang) values 
    ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.','.$serv_sang.',"NO","","'.$det_sang.'")')
    or die('<p>Error al registrar sangre</p><br>' . mysqli_error($conexion));
}

$sol_pato1 = $serv_pato;
if ($sol_pato1 === '"NINGUNO"') {
    } else {
    $insertarpato=mysqli_query($conexion,'INSERT INTO notificaciones_pato(id_atencion,fecha,hora,id_usua,dispo_p,realizado,resultado,estudios_obser) values 
    ('.$id_atencion.',"'.$fecha_actual.'","'.$hora_ord.'",'.$id_usua.','.$serv_pato.',"NO","","'.$det_pato.'")')
    or die('<p>Error al registrar pato</p><br>' . mysqli_error($conexion));
}
for ($iii = 0; $iii < count( $id_patolo); $iii++) {
    $perfilpato =  $id_patolo[$iii];
    $cta_cant = 1;
    $precio = 0;
    $activo = "SI";
    $prodserv = "S";
    if ($perfilpato === 'NINGUNO') {
    } else {
            $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
            $result_aseg = $conexion->query($sql_aseg);
            while ($row_aseg = $result_aseg->fetch_assoc()) {
                $at=$row_aseg['aseg'];
            }
 
            $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
            while($filat = mysqli_fetch_array($resultadot)){ 
                $tr=$filat["tip_precio"];
            }
                    
            $sql_dat_ingp = "SELECT * from cat_servicios where serv_desc='$perfilpato'";
            $result_dat_ingp = $conexion->query($sql_dat_ingp);
                while ($row_dat_ingp = $result_dat_ingp->fetch_assoc()) {
                    $id_cta = $row_dat_ingp['id_serv'];
                    if ($tr==1) $precio = $row_dat_ingp['serv_costo'];
                    if ($tr==2) $precio = $row_dat_ingp['serv_costo2'];
                    if ($tr==3) $precio = $row_dat_ingp['serv_costo3'];
                    if ($tr==4) $precio = $row_dat_ingp['serv_costo4'];
                }
            $registracta = mysqli_query($conexion,'INSERT INTO dat_ctapac
            (id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo,centro_cto)VALUES 
            ('.$id_atencion.',"'.$prodserv.'",'.$id_cta.',"'.$fecha_actual.'",'.$cta_cant.','.$precio.','.$id_usua.',"'.$activo.'","'.$area.'")')
            or die('<p>Error al registrar cuenta patologia</p><br>' . mysqli_error($conexion));
    }
}


//* AQUI INICIA LABORATORIO *//
$lab_inmed = "";
$lab_ninmed = "";

for ($ii = 0; $ii < count( $id_laborato); $ii++) {
    $perfillab =  $id_laborato[$ii];
    if ($perfillab === 'NINGUNO') {
    } else {
            $sql_dat_ingl = "SELECT * from cat_servicios where serv_desc='$perfillab'";
            $result_dat_ingl = $conexion->query($sql_dat_ingl);
                while ($row_dat_ingl = $result_dat_ingl->fetch_assoc()) {
                    $id_cta = $row_dat_ingl['id_serv'];
                    $descrip = $row_dat_ingl['serv_desc']; 
            //        $inmediato = $row_dat_ingl['inmediato']; 
            //        if ($inmediato === 'SI'){ 
                        $lab_inmed = $lab_inmed .'/'. $descrip;
            //        }else {
                        $lab_ninmed = $lab_ninmed .'/'. $descrip;
            //        }
                } 
           }
}

 if ($perfillab === 'NINGUNO') {
    } else {
//          if ($lab_inmed<> "") {
            $insertarlabo=mysqli_query($conexion,'INSERT INTO notificaciones_labo(id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado,det_labo) values ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.',"' . $lab_inmed . '","NO","","'.$detalle_lab.'")')or die('<p>Error al registrar labo inmediatos</p><br>' . mysqli_error($conexion));
//            }
//            if ($lab_ninmed<> "") {
//            $insertarlabo=mysqli_query($conexion,'INSERT INTO notificaciones_labo(id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado,det_labo) values ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.',"' . $lab_ninmed . '","NO","","'.$detalle_lab.'")')or die('<p>Error al registrar labo no inmediatos</p><br>' . mysqli_error($conexion));
//            }
}

for ($ii = 0; $ii < count( $id_laborato); $ii++) {
    $perfillab =  $id_laborato[$ii];
    $cta_cant = 1;
    $precio = 0;
    $activo = "SI";
    $prodserv = "S";
    if ($perfillab === 'NINGUNO') {
    } else {
            $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
            $result_aseg = $conexion->query($sql_aseg);
            while ($row_aseg = $result_aseg->fetch_assoc()) {
                $at=$row_aseg['aseg'];
            }
            $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
            while($filat = mysqli_fetch_array($resultadot)){ 
                $tr=$filat["tip_precio"];
            }
            $sql_dat_ingl = "SELECT * from cat_servicios where serv_desc='$perfillab'";
            $result_dat_ingl = $conexion->query($sql_dat_ingl);
            while ($row_dat_ingl = $result_dat_ingl->fetch_assoc()) {
                $id_cta = $row_dat_ingl['id_serv'];
                if ($tr==1) $precio = $row_dat_ingl['serv_costo'];
                if ($tr==2) $precio = $row_dat_ingl['serv_costo2'];
                if ($tr==3) $precio = $row_dat_ingl['serv_costo3'];
                if ($tr==4) $precio = $row_dat_ingp['serv_costo4'];
            }
            $registracta = mysqli_query($conexion,'INSERT INTO dat_ctapac
            (id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo,centro_cto)VALUES 
            ('.$id_atencion.',"'.$prodserv.'",'.$id_cta.',"'.$fecha_actual.'",'.$cta_cant.','.$precio.','.$id_usua.',"'.$activo.'","'.$area.'")')
            or die('<p>Error al registrar cuenta laboratorios</p><br>' . mysqli_error($conexion));
    }
}

$insertar = mysqli_query($conexion, 'INSERT INTO dat_ordenes_med(id_atencion,id_usua,fecha_ord,hora_ord,dieta,cuid_gen,det_dieta,signos,monitoreo,diuresis,dex,semif,vigilar,oxigeno,nebulizacion,bar,baño,foley,ej,datsan,detsignos,detmonitoreo,detdiuresis,detdex,detsemif,detvigilar,detoxigeno,detnebu,detbar,detbaño,detfoley,detej,detsan,med_med,soluciones,perfillab,sol_estudios,solicitud_sang,det_sang,observ_be,medico,tipo,detalle_lab,gca,gcat,son,sont,sol_pato,det_pato,det_imagen,dialisis,fisio,reha) values (' . $id_atencion . ',' . $id_usua . ',"' . $fecha_actual . '","' . $hora_ord . '","' . $dieta . '","' . $cuid_gen . '","' . $det_dieta . '","' . $signos . '","' . $monitoreo . '","' . $diuresis . '","' . $dex . '","' . $semif . '","' . $vigilar . '","'.$oxigeno.'","'.$nebu.'","'.$bar.'","'.$baño.'","'.$foley.'","'.$ej.'","'.$datsan.'","'.$detsignos.'","'.$detmonitoreo.'","'.$detdiuresis.'","'.$detdex.'","'.$detsemif.'","'.$detvigilar.'","'.$detoxigeno.'","'.$detnebu.'","'.$detbar.'","'.$detbaño.'","'.$detfoley.'","'.$detej.'","'.$detsan.'","' . $med_med . '","' . $soluciones . '",' . $serv_perfillab . ','. $servicio. ',' . $serv_sang . ',"'.$det_sang.'","'.$observ_be.'","'.$nombre_medico.'","MEDICO","'.$detalle_lab.'","'.$gca.'","'.$gcat.'","'.$son.'","'.$sont.'",'.$serv_pato.',"'.$det_pato.'","'.$det_imagen.'","'.$dialisis.'","'.$fisio.'","'.$reha.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));



        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> DATO INSERTADO CORRECTAMENTE...</p>";
        echo '<script type="text/javascript">window.location ="ordenes_vista.php"</script>';
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
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>PRESCRIPCIÓN Y ÓRDENES: PREPARACIÓN DE CASOS QUIRÚRGICOS, DIETAS, ETC.</strong></center><p>
</div>
            <div class="row">
                <div class="col-2">
                    <center><p><p><strong><label for="exampleFormControlTextarea1"><font size="3" color="#2b2d7f">1.- Dieta: <button type="button" class="btn btn-success btn-sm" id="pla14"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                       <div class="col-sm-5">
                    <div class="form-group">
                       
                        <select class="form-control" name="dieta" required id="dieta">
                          
                                                      
                            <?php
                            $sql_d = "SELECT DISTINCT id_dieta,dieta FROM cat_dietas WHERE dieta_activo='SI'order by dieta";
                            $result_d = $conexion->query($sql_d);
                            while ($row_d = $result_d->fetch_assoc()) {
                                echo "<option value='" . $row_d['dieta'] . "'>" . $row_d['dieta'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
<script type="text/javascript">
const dieta = document.getElementById('dieta');
const btnPlayTex14 = document.getElementById('pla14');
btnPlayTex14.addEventListener('click', () => {
        leerTexto(dieta.value);
});

function leerTexto(dieta){
    const speech = new SpeechSynthesisUtterance();
    speech.text= dieta;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
            <div class="row">
                <div class="col-2">
                    <center><p><p><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">Detalle de dieta: <button type="button" class="btn btn-success btn-sm" id="pla15"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                       <div class="form-group col-8"><br>
                       <textarea name="det_dieta" class="form-control" rows="3" id="tx21"> </textarea>
                       
                    </div>
            </div>
<script type="text/javascript">
const tx21 = document.getElementById('tx21');
const btnPlayTex15 = document.getElementById('pla15');
btnPlayTex15.addEventListener('click', () => {
        leerTexto(tx21.value);
});

function leerTexto(tx21){
    const speech = new SpeechSynthesisUtterance();
    speech.text= tx21;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
         <div class="col-3">
                    <center><p><p><strong><label for="exampleFormControlTextarea1"><font size="3" color="#2b2d7f">2.- Cuidados generales:</font></label></strong></center>
                </div>
            


<div class="container">
    <div class="row">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
        <strong><font color="#2b2d7f"><center>Detalle de indicaciones</center></font></strong><p>
        </div>
    </div>
</div>
 

            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Signos vitales por turno</font></strong>
                    </div>
                    
                   
               
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="signos" id="signos" value="SI">
                            <label class="form-check-label" for="signos">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="signos" id="signos2" value="NO" checked>
                            <label class="form-check-label" for="signos2">
                                NO
                            </label>
                        </div>
                    </div>
               
                     <div class="col-sm-6">
     <input type="text" name="detsignos" class="form-control">
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Monitoreo constante</font></strong>
                    </div>
                
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="monitoreo" value="SI">
                            <label class="form-check-label" for="monitoreo">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="monitoreo" value="NO" checked>
                            <label class="form-check-label" for="signos2">
                                NO
                            </label>
                        </div>
                    </div>
            
                     <div class="col-sm-6">
     <input type="text" name="detmonitoreo" class="form-control" >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Diuresis por turno</font></strong>
                    </div>
                
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="diuresis" value="SI">
                            <label class="form-check-label" for="diuresis">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="diuresis" value="NO" checked>
                            <label class="form-check-label" for="diuresis">
                                NO
                            </label>
                        </div>
                    </div>
              
                     <div class="col-sm-6">
     <input type="text" name="detdiuresis" class="form-control" 
                                  >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Dextrostix por turno</font></strong>
                    </div>
                
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dex" value="SI">
                            <label class="form-check-label" for="dex">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dex" value="NO" checked>
                            <label class="form-check-label" for="dex">
                                NO
                            </label>
                        </div>
                    </div>
            
                     <div class="col-sm-6">
     <input type="text" name="detdex" class="form-control" 
                                  >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Posición semifowler</font></strong>
                    </div>
                 
               
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="semif" value="SI">
                            <label class="form-check-label" for="semif">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="semif" value="NO" checked>
                            <label class="form-check-label" for="semif">
                                NO
                            </label>
                        </div>
                    </div>
               
                     <div class="col-sm-6">
     <input type="text" name="detsemif" class="form-control" 
                                  >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Vigilar datos del paciente neurológico</font></strong>
                    </div>
                   
                
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="vigilar" value="SI">
                            <label class="form-check-label" for="vigilar">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="vigilar" value="NO" checked>
                            <label class="form-check-label" for="vigilar">
                                NO
                            </label>
                        </div>
                    </div>
                
                     <div class="col-sm-6">
     <input type="text" name="detvigilar" class="form-control" 
                                  >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Oxígeno</font></strong>
                    </div>
  
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="oxigeno" value="SI">
                            <label class="form-check-label" for="oxigeno">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="oxigeno" value="NO" checked>
                            <label class="form-check-label" for="oxigeno">
                                NO
                            </label>
                        </div>
                    </div>
             
                     <div class="col-sm-6">
                     <input type="text" name="detoxigeno" class="form-control"  >
                     </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Nebulizaciones</font></strong>
                    </div>
                   
               
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="nebu" value="SI">
                            <label class="form-check-label" for="nebu">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="nebu" value="NO" checked>
                            <label class="form-check-label" for="nebu">
                                NO
                            </label>
                        </div>
                    </div>
               
                     <div class="col-sm-6">
     <input type="text" name="detnebu" class="form-control" 
                                  >
                </div>
            </div>
            </div>
<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Barandales en alto</font></strong>
                    </div>
                 
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bar" value="SI">
                            <label class="form-check-label" for="bar">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bar" value="NO" checked>
                            <label class="form-check-label" for="bar">
                                NO
                            </label>
                        </div>
                    </div>
             
                     <div class="col-sm-6">
     <input type="text" name="detbar" class="form-control" 
                                  >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Baño diario y deambulación asistida</font></strong>
                    </div>
                  
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="baño" value="SI">
                            <label class="form-check-label" for="baño">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="baño" value="NO" checked>
                            <label class="form-check-label" for="baño">
                                NO
                            </label>
                        </div>
                    </div>
            
                     <div class="col-sm-6">
     <input type="text" name="detbaño" class="form-control" 
                                  >
                </div>
            </div>
        </div>
<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Cuidados de sonda foley</font></strong>
                    </div>
                    
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="foley" value="SI">
                            <label class="form-check-label" for="foley">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="foley" value="NO" checked>
                            <label class="form-check-label" for="foley">
                                NO
                            </label>
                        </div>
                    </div>
            
                     <div class="col-sm-6">
     <input type="text" name="detfoley" class="form-control"  
                                  >
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Ejercicios respiratorios</font></strong>
                    </div>
                  
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ej" value="SI">
                            <label class="form-check-label" for="ej">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ej" value="NO" checked>
                            <label class="form-check-label" for="ej">
                                NO
                            </label>
                        </div>
                    </div>
                
                     <div class="col-sm-6">
     <input type="text" name="detej" class="form-control" 
                                  >
                </div>
                  
    </div>
            </div>

 
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Vigilar datos de sangrado</font></strong>
                    </div>
                  
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="datsan" value="SI">
                            <label class="form-check-label" for="datsan">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="datsan" value="NO" checked>
                            <label class="form-check-label" for="datsan">
                                NO
                            </label>
                        </div>
                    </div>
              
                    <div class="col-sm-6">
     <input type="text" name="detsan" class="form-control"
                                  >
    </div>
                </div>
            </div>

<!--   

            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">CURVA TÉRMICA Y CONTROL POR MEDIOS FÍSICOS</font></strong>
                    </div>
                  
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cur" value="SI">
                            <label class="form-check-label" for="cur">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cur" value="NO" checked>
                            <label class="form-check-label" for="cur">
                                NO
                            </label>
                        </div>
                    </div>
              
                    <div class="col-sm-6">
                          <input type="text" name="curt" class="form-control">
                    </div>
                </div>
            </div>


<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">CONTROL DE LÍQUIDOS Y CUANTIFICAR URESIS HORARIA EN ML</font></strong>
                    </div>
                  
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="conl" value="SI">
                            <label class="form-check-label" for="conl">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="conl" value="NO" checked>
                            <label class="form-check-label" for="conl">
                                NO
                            </label>
                        </div>
                    </div>
              
                    <div class="col-sm-6">
     <input type="text" name="conlt" class="form-control"
                                  >
    </div>
                </div>
            </div>
-->

<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Glucometría capilar <br> Reportar <80 ó >180 mg/dl</font></strong>
                    </div>
                  
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gca" value="SI">
                            <label class="form-check-label" for="gca">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gca" value="NO" checked>
                            <label class="form-check-label" for="gca">
                                NO
                            </label>
                        </div>
                    </div>
              
                    <div class="col-sm-6">
     <input type="text" name="gcat" class="form-control"
                                  >
    </div>
                </div>
            </div>


<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Sonda nasogástrica a derivación</font></strong>
                    </div>
                  
                      <div class="col-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="son" value="SI">
                            <label class="form-check-label" for="son">
                                SI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="son" value="NO" checked>
                            <label class="form-check-label" for="son">
                                NO
                            </label>
                        </div>
                    </div>
              
                    <div class="col-sm-6">
     <input type="text" name="sont" class="form-control"
                                  >
    </div>
                </div>
            </div>
<p>
<div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <strong><label for="exampleFormControlTextarea1"><font size="3" color="#2b2d7f">
                                    OTROS: <button type="button" class="btn btn-success btn-sm" id="01"><i class="fas fa-play"></button></i></font></label></strong>
                    </div>
                
                    <div class="col-sm-10">
      <input type="text" name="observ_be" class="form-control"  id="t31">
    </div>
                </div>
            </div>
                   
<script type="text/javascript">

const t31 = document.getElementById('t31');

const btnPlayTex16 = document.getElementById('01');
btnPlayTex16.addEventListener('click', () => {
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
<br>


            
            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">3.- Medicamentos: <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="medg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="toss"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla5"><i class="fas fa-play"></button></i>
</div></font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group">
                        <textarea name="med_med" class="form-control"  id="txt" rows="3"> </textarea>
                    </div>
                </div>
            </div>
<script type="text/javascript">
const medg = document.getElementById('medg');
const toss = document.getElementById('toss');
const txt = document.getElementById('txt');

const btnPlayTex5 = document.getElementById('pla5');
btnPlayTex5.addEventListener('click', () => {
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


     let rem = new webkitSpeechRecognition();
      rem.lang = "es-ES";
      rem.continuous = true;
      rem.interimResults = false;

      rem.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txt.value += frase;
      }

      medg.addEventListener('click', () => {
        rem.start();
      });

      toss.addEventListener('click', () => {
        rem.abort();
      });
</script>
            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">4.- Soluciones: <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="solg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="ionesstop"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla6"><i class="fas fa-play"></button></i>
</div>
</font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group">
                           <textarea name="soluciones" class="form-control" id="txtseol"  rows="3"> </textarea>
                    </div>
                </div>
            </div>
<script type="text/javascript">
const solg = document.getElementById('solg');
const ionesstop = document.getElementById('ionesstop');
const txtseol = document.getElementById('txtseol');

const btnPlayTex6 = document.getElementById('pla6');
btnPlayTex6.addEventListener('click', () => {
        leerTexto(txtseol.value);
});

function leerTexto(txtseol){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtseol;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
     let renesol = new webkitSpeechRecognition();
      renesol.lang = "es-ES";
      renesol.continuous = true;
      renesol.interimResults = false;

      renesol.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtseol.value += frase;
      }

      solg.addEventListener('click', () => {
        renesol.start();
      });

      ionesstop.addEventListener('click', () => {
        renesol.abort();
      });
</script>
            <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">5.- Estudios laboratorio: <button type="button" class="btn btn-success btn-sm" id="t41"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                <div class="col-sm-5">
                    <div class="form-group"><br>
                        <select id="l1" name="l1[]" multiple="multiple" class="form-control" required="" >
                        <option value="NINGUNO" selected="NINGUNO" >NINGUNO</option>    
                            <?php
                            $sql_serv = "SELECT * FROM cat_servicios c where tipo = 1 and serv_activo = 'SI'";
                            $result_serv = $conexion->query($sql_serv);
                            while ($row_serv = $result_serv->fetch_assoc()) {
                                echo "<option value='" . $row_serv['serv_desc'] . "'>" . $row_serv['serv_desc'] . "</option>";

                            }
                            ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#l1').multiselect({
                                    nonSelectedText: 'SELECCIONA SERVICIO(S)',
                                    includeSelectAllOption: false,
                                    buttonWidth: 250,
                                    maxHeight: 200,
                                    enableFiltering: true,
                                    dropUp: false,
                                    enableCaseInsensitiveFiltering: true 
                                });
                            });
                        </script>
                    </div>
               
                </div>
<script type="text/javascript">
const l1 = document.getElementById('l1');
const btnPlayTex7 = document.getElementById('t41');
btnPlayTex7.addEventListener('click', () => {
        leerTexto(l1.value);
});

function leerTexto(l1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= l1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
                 <div class="col-sm-5">Detalle estudios laboratorio: <button type="button" class="btn btn-success btn-sm" id="t42"><i class="fas fa-play"></button></i><br>
<input type="text" class="form-control" name="detalle_lab" id="t55">
 </div>
            </div>
<script type="text/javascript">
const t55 = document.getElementById('t55');
const btnPlayTex8 = document.getElementById('t42');
btnPlayTex8.addEventListener('click', () => {
        leerTexto(t55.value);
});

function leerTexto(t55){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t55;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
            <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">6.- Estudios imagenología: <button type="button" class="btn btn-success btn-sm" id="t43"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                <div class="col-sm-6">

                    <div class="form-group">
                       <br><p>
                      
                        <select id="a1" name="a1[]" multiple="multiple" class="form-control" required="">
                            <option value="NINGUNO" selected="NINGUNO">NINGUNO</option>
                            <?php
                            $sql_serv = "SELECT * FROM cat_servicios where tipo =2 and serv_activo = 'SI'";
                            $result_serv = $conexion->query($sql_serv);
                            while ($row_serv = $result_serv->fetch_assoc()) {
                                echo "<option value='" . $row_serv['serv_desc'] . "'>" . $row_serv['serv_desc'].','. $row_serv['tip_insumo']. "</option>";
                            }
                            ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#a1').multiselect({
                                    nonSelectedText: 'Selecciona servicio(s)',
                                    includeSelectAllOption: false,
                                    buttonWidth: 250,
                                    maxHeight: 200,
                                    enableFiltering: true,
                                    dropUp: false,
                                    enableCaseInsensitiveFiltering: true
                                });
                            });
                        </script>
                    </div>
                </div>
                <div class="col-sm-5">Detalle estudios imagenología: <br>
<input type="text" class="form-control" name="det_imagen">
 </div>
            </div>
<script type="text/javascript">
const a1 = document.getElementById('a1');
const btnPlayTex9 = document.getElementById('t43');
btnPlayTex9.addEventListener('click', () => {
        leerTexto(a1.value);
});

function leerTexto(a1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= a1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
             <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">7.- Estudios patología:  <button type="button" class="btn btn-success btn-sm" id="t44"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                <div class="col-sm-5">

                    <div class="form-group">
                        <br>
                    
                       <select id="p1" name="p1[]" multiple="multiple" class="form-control" required="">
                            <option value="NINGUNO" selected="NINGUNO">NINGUNO</option>
                            <?php
                            $sql_serv = "SELECT * FROM cat_servicios where tipo = 6 and serv_activo = 'SI'";
                            $result_serv = $conexion->query($sql_serv);
                            while ($row_serv = $result_serv->fetch_assoc()) {
                                echo "<option value='" . $row_serv['serv_desc'] . "'>" . $row_serv['serv_desc'] . "</option>";
                            }
                            ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#p1').multiselect({
                                    nonSelectedText: 'Selecciona servicio(s)',
                                    includeSelectAllOption: false,
                                    buttonWidth: 250,
                                    maxHeight: 200,
                                    enableFiltering: true,
                                    dropUp: false,
                                    enableCaseInsensitiveFiltering: true
                                });
                            });
                        </script>
                    </div>
                </div>
<script type="text/javascript">
const p1 = document.getElementById('p1');
const btnPlayTex10 = document.getElementById('t44');
btnPlayTex10.addEventListener('click', () => {
        leerTexto(p1.value);
});

function leerTexto(p1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= p1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
 <div class="col-sm-5">Detalle estudios patología: <button type="button" class="btn btn-success btn-sm" id="t45"><i class="fas fa-play"></button></i><br>
<input type="text" class="form-control" name="det_pato" id="t76">
 </div>
</div>
<script type="text/javascript">
const t76 = document.getElementById('t76');
const btnPlayTex11 = document.getElementById('t45');
btnPlayTex11.addEventListener('click', () => {
        leerTexto(t76.value);
});

function leerTexto(t76){
    const speech = new SpeechSynthesisUtterance();
    speech.text= t76;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
            <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">8.- Solicitud transfusión sanguínea: <button type="button" class="btn btn-success btn-sm" id="t46"><i class="fas fa-play"></button></i></font></label></strong></center>
                </div>
                <div class="col-sm-5">

                    <div class="form-group">
                        <br>
                    
                       <select id="s1" name="s1[]" multiple="multiple" class="form-control" required="">
                            <option value="NINGUNO" selected="NINGUNO">NINGUNO</option>
                            <?php
                            $sql_serv = "SELECT * FROM cat_servicios where tipo =5 and serv_activo = 'SI'";
                            $result_serv = $conexion->query($sql_serv);
                            while ($row_serv = $result_serv->fetch_assoc()) {
                                echo "<option value='" . $row_serv['serv_desc'] . "'>" . $row_serv['serv_desc'] . "</option>";
                            }
                            ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#s1').multiselect({
                                    nonSelectedText: 'Selecciona servicio(s)',
                                    includeSelectAllOption: false,
                                    buttonWidth: 250,
                                    maxHeight: 200,
                                    enableFiltering: true,
                                    dropUp: false,
                                    enableCaseInsensitiveFiltering: true
                                });
                            });
                        </script>
                    </div>
                </div>
<script type="text/javascript">
const s1 = document.getElementById('s1');
const btnPlayTex112 = document.getElementById('t46');
btnPlayTex112.addEventListener('click', () => {
        leerTexto(s1.value);
});

function leerTexto(s1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= s1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>
 <div class="col-sm-5">Detalle de transfusión sanguínea: <button type="button" class="btn btn-success btn-sm" id="t47"><i class="fas fa-play"></button></i><br>
<input type="text" class="form-control" name="det_sang" id="txt64">
 </div>
</div>
<script type="text/javascript">
const txt64 = document.getElementById('txt64');
const btnPlayTex13 = document.getElementById('t47');
btnPlayTex13.addEventListener('click', () => {
        leerTexto(txt64.value);
});

function leerTexto(txt64){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txt64;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
} 
</script>


            <?php
            $usuario = $_SESSION['login'];
            ?>
            <hr>
<!--sección nueva cuando es la primera vez de registro de ordenes med-->
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>PROCEDIMIENTOS EN MEDICINA DE TRATAMIENTO</strong></center><p>
</div>

<div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">Diálisis: 
</font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group">
                      <textarea name="dialisis" class="form-control" id="texto" rows="3"> </textarea>   
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">Fisioterapía: 
</font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group">
                      <textarea name="fisio" class="form-control" id="texto" rows="3"> </textarea>   
                    </div>
                </div>
            </div>

<div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">Inhaloterapia: 
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="pla4"><i class="fas fa-play"></button></i>
</div>
</font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group">
                      <textarea name="cuid_gen" class="form-control" id="texto" rows="3"> </textarea>   
                    </div>
                </div>
            </div>
<script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btnPlayTex4 = document.getElementById('pla4');
btnPlayTex4.addEventListener('click', () => {
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
 <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">Rehabilitación: 
</font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group">
                      <textarea name="reha" class="form-control" id="texto" rows="3"> </textarea>   
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col align-self-start">
                    <strong>Médico:</strong> <input type="text" name="" class="form-control"
                                                    value="<?php echo $usuario['papell']; ?> <?php echo $usuario['sapell']; ?>"
                                                    disabled>
                </div>
                <div class="col align-self-center">
                    <strong>Cédula profesional:</strong><input type="text" name="" class="form-control"
                                                      value="<?php echo $usuario['cedp']; ?>" disabled="">

                </div>

            </div>
            <hr>
            <div class="container">
                <div class="row">
                    <div class="col align-self-start">
                    </div>
                    <button type="submit" name="guardar" class="btn btn-primary">Firmar</button> &nbsp;
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

        $dieta    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dieta"], ENT_QUOTES))); //Escanpando caracteres
        $cuid_gen    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cuid_gen"], ENT_QUOTES))); //Escanpando caracteres
        $signos   = mysqli_real_escape_string($conexion, (strip_tags($_POST["signos"], ENT_QUOTES)));
        $monitoreo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["monitoreo"], ENT_QUOTES))); //Escanpando caracteres
        $diuresis    = mysqli_real_escape_string($conexion, (strip_tags($_POST["diuresis"], ENT_QUOTES)));
        $dex    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dex"], ENT_QUOTES)));
        $semif    = mysqli_real_escape_string($conexion, (strip_tags($_POST["semif"], ENT_QUOTES)));
        $vigilar    = mysqli_real_escape_string($conexion, (strip_tags($_POST["vigilar"], ENT_QUOTES)));
        $oxigeno    = mysqli_real_escape_string($conexion, (strip_tags($_POST["oxigeno"], ENT_QUOTES)));
        $nebu    = mysqli_real_escape_string($conexion, (strip_tags($_POST["nebu"], ENT_QUOTES)));
        $bar    = mysqli_real_escape_string($conexion, (strip_tags($_POST["bar"], ENT_QUOTES)));
        $baño    = mysqli_real_escape_string($conexion, (strip_tags($_POST["baño"], ENT_QUOTES)));
        $foley   = mysqli_real_escape_string($conexion, (strip_tags($_POST["foley"], ENT_QUOTES)));
        $ej    = mysqli_real_escape_string($conexion, (strip_tags($_POST["ej"], ENT_QUOTES)));
        $datsan    = mysqli_real_escape_string($conexion, (strip_tags($_POST["datsan"], ENT_QUOTES)));
        
        $detsignos    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detsignos"], ENT_QUOTES)));
        $detmonitoreo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detmonitoreo"], ENT_QUOTES)));
        $detdiuresis    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detdiuresis"], ENT_QUOTES)));
        $detdex    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detdex"], ENT_QUOTES)));
        $detsemif    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detsemif"], ENT_QUOTES)));
        $detvigilar    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detvigilar"], ENT_QUOTES)));
        $detoxigeno    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detoxigeno"], ENT_QUOTES)));
        $detnebu    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detnebu"], ENT_QUOTES)));
        $detbar    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detbar"], ENT_QUOTES)));
        $detbaño    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detbaño"], ENT_QUOTES)));
        $detfoley    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detfoley"], ENT_QUOTES)));
        $detej    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detej"], ENT_QUOTES)));
        $detsan    = mysqli_real_escape_string($conexion, (strip_tags($_POST["detsan"], ENT_QUOTES)));
        $med_med    = mysqli_real_escape_string($conexion, (strip_tags($_POST["med_med"], ENT_QUOTES)));
        $soluciones    = mysqli_real_escape_string($conexion, (strip_tags($_POST["soluciones"], ENT_QUOTES)));
   $det_dieta    = mysqli_real_escape_string($conexion, (strip_tags($_POST["det_dieta"], ENT_QUOTES)));
   $det_sang = mysqli_real_escape_string($conexion, (strip_tags($_POST['det_sang'], ENT_QUOTES)));
   $observ_be = mysqli_real_escape_string($conexion, (strip_tags($_POST['observ_be'], ENT_QUOTES)));
   $detalle_lab = mysqli_real_escape_string($conexion, (strip_tags($_POST['detalle_lab'], ENT_QUOTES)));
/*
$cur = mysqli_real_escape_string($conexion, (strip_tags($_POST['cur'], ENT_QUOTES)));
$curt = mysqli_real_escape_string($conexion, (strip_tags($_POST['curt'], ENT_QUOTES)));
$conl = mysqli_real_escape_string($conexion, (strip_tags($_POST['conl'], ENT_QUOTES)));
$conlt = mysqli_real_escape_string($conexion, (strip_tags($_POST['conlt'], ENT_QUOTES)));*/
$gca = mysqli_real_escape_string($conexion, (strip_tags($_POST['gca'], ENT_QUOTES)));
$gcat = mysqli_real_escape_string($conexion, (strip_tags($_POST['gcat'], ENT_QUOTES)));
$son = mysqli_real_escape_string($conexion, (strip_tags($_POST['son'], ENT_QUOTES)));
$sont = mysqli_real_escape_string($conexion, (strip_tags($_POST['sont'], ENT_QUOTES)));
$det_pato = mysqli_real_escape_string($conexion, (strip_tags($_POST['det_pato'], ENT_QUOTES)));
$det_imagen = mysqli_real_escape_string($conexion, (strip_tags($_POST['det_imagen'], ENT_QUOTES)));

$dialisis = mysqli_real_escape_string($conexion, (strip_tags($_POST['dialisis'], ENT_QUOTES)));
$fisio = mysqli_real_escape_string($conexion, (strip_tags($_POST['fisio'], ENT_QUOTES)));
$reha = mysqli_real_escape_string($conexion, (strip_tags($_POST['reha'], ENT_QUOTES)));

$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];


$fecha_actual = date("Y-m-d H:i:s");
$hora_actual = intval(date("H"));

$v1 = $_POST['a1'];
$sep = implode(",", $v1);
$servicio = json_encode($sep);
if ($servicio === 'NINGUNO') {
    $servicio = '"NINGUNO"';
}


$s1 = $_POST['s1'];
$sang = implode(",", $s1);
$serv_sang = json_encode($sang);
if ($serv_sang === 'NINGUNO') {
    $serv_sang = '"NINGUNO"';
}

$p1 = $_POST['p1'];
$sol_pato = implode(",", $p1);
$serv_pato = json_encode($sol_pato);
if ($serv_pato === 'NINGUNO') {
    $serv_pato = '"NINGUNO"';
}

$l1 = $_POST['l1'];
$id_laborato = $_POST['l1'];
$perfillab = implode(",", $l1);
$serv_perfillab = json_encode($perfillab);
if ($serv_perfillab === 'NINGUNO') {
    $serv_perfillab = '"NINGUNO"';
}

$sql_hab = "SELECT * FROM cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);
while ($row_hab = $result_hab->fetch_assoc()) {
    $hab = $row_hab['num_cama'];
}

$id_imagenologia = $_POST["a1"]; //Escanpando caracteres
$solicitud_sang = $_POST["s1"]; //Escanpando caracteres
$sol_pato = $_POST["p1"];
$id_patolo = $_POST["p1"];
$perfillab = $_POST["l1"];

$nombre_medico=$papell;
$fecha_actual = date("Y-m-d H:i:s");
$hora_ord = date("H:i:s");

for ($i = 0; $i < count($id_imagenologia); $i++) {

    $id_imagenologia1 = $id_imagenologia[$i];
    $cta_cant = 1;
    $precio = 0;
    $activo = "SI";
    $prodserv = "S";
    if ($id_imagenologia1 === 'NINGUNO') {
    } else {
            $insertarnot=mysqli_query($conexion,'INSERT INTO notificaciones_imagen
            (id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado,det_imagen,interpretado) values 
            ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.',"'.$id_imagenologia1.'","NO","","'.$det_imagen.'","No")')or die('<p>Error al registrar imagen</p><br>' . mysqli_error($conexion));
            $sql_dat_ingi = "SELECT * from cat_servicios where serv_desc='$id_imagenologia1'";
            $result_dat_inga = $conexion->query($sql_dat_ingi);
                while ($row_dat_ingu = $result_dat_inga->fetch_assoc()) {
                    $id_cta = $row_dat_ingu['id_serv'];
                } 
        //   $registracta = mysqli_query($conexion,'INSERT INTO dat_ctapac
        //    (id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo)VALUES 
        //    ('.$id_atencion.',"'.$prodserv.'",'.$id_cta.',"'.$fecha_actual2.'",
        //        '.$cta_cant.','.$precio.','.$id_usua.',"'.$activo.'")')or die('<p>Error al registrar cuenta imagen</p><br>' . mysqli_error($conexion));
     
    }

}


$solicitud_sang1 = $serv_sang;
if ($solicitud_sang1 === '"NINGUNO"') {
    } else {
$insertarnot=mysqli_query($conexion,'INSERT INTO notificaciones_sangre(id_atencion,habitacion,fecha_ord,id_usua,sol_sangre,realizado,resultado,det_sang) values ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.','.$serv_sang.',"NO","","'.$det_sang.'")')or die('<p>Error al registrar sangre</p><br>' . mysqli_error($conexion));
}

$sol_pato1 = $serv_pato;
if ($sol_pato1 === '"NINGUNO"') {
    } else {
$insertarpato=mysqli_query($conexion,'INSERT INTO notificaciones_pato(id_atencion,fecha,hora,id_usua,dispo_p,realizado,resultado,estudios_obser) values ('.$id_atencion.',"'.$fecha_actual.'","'.$hora_ord.'",'.$id_usua.','.$serv_pato.',"NO","","'.$det_pato.'")')or die('<p>Error al registrar pato</p><br>' . mysqli_error($conexion));
}
for ($iii = 0; $iii < count( $id_patolo); $iii++) {
    $perfilpato =  $id_patolo[$iii];
    $cta_cant = 1;
    $precio = 0;
    $activo = "SI";
    $prodserv = "S";
    if ($perfilpato === 'NINGUNO') {
    } else {
            $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
            $result_aseg = $conexion->query($sql_aseg);
            while ($row_aseg = $result_aseg->fetch_assoc()) {
                $at=$row_aseg['aseg'];
            }
 
            $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
            while($filat = mysqli_fetch_array($resultadot)){ 
                $tr=$filat["tip_precio"];
            }
                    
            $sql_dat_ingp = "SELECT * from cat_servicios where serv_desc='$perfilpato'";
            $result_dat_ingp = $conexion->query($sql_dat_ingp);
                while ($row_dat_ingp = $result_dat_ingp->fetch_assoc()) {
                    $id_cta = $row_dat_ingp['id_serv'];
                    if ($tr==1) $precio = $row_dat_ingp['serv_costo'];
                    if ($tr==2) $precio = $row_dat_ingp['serv_costo2'];
                    if ($tr==3) $precio = $row_dat_ingp['serv_costo3'];
                    if ($tr==4) $precio = $row_dat_ingp['serv_costo4'];
                } 
            $registracta = mysqli_query($conexion,'INSERT INTO dat_ctapac
                (id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo,centro_cto)VALUES 
                ('.$id_atencion.',"'.$prodserv.'",'.$id_cta.',"'.$fecha_actual2.'",
                '.$cta_cant.','.$precio.','.$id_usua.',"'.$activo.'","'.$area.'")')or die('<p>Error al registrar cuenta patologia</p><br>' . mysqli_error($conexion));
    }
}

$perfillab1 = $serv_perfillab;
if ($perfillab1 === '"NINGUNO"') {
    } else {
$insertarlabo=mysqli_query($conexion,'INSERT INTO notificaciones_labo(id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado,det_labo) values ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.',' . $serv_perfillab . ',"NO","","'.$detalle_lab.'")')or die('<p>Error al registrar labo</p><br>' . mysqli_error($conexion));
}  

for ($ii = 0; $ii < count( $id_laborato); $ii++) {
    $perfillab =  $id_laborato[$ii];
    $cta_cant = 1;
    $precio = 0;
    $activo = "SI";
    $prodserv = "S";
    if ($perfillab === 'NINGUNO') {
    } else {
            $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
            $result_aseg = $conexion->query($sql_aseg);
            while ($row_aseg = $result_aseg->fetch_assoc()) {
                $at=$row_aseg['aseg'];
            }
 
            $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
            while($filat = mysqli_fetch_array($resultadot)){ 
                $tr=$filat["tip_precio"];
            }
                    
            $sql_dat_ingl = "SELECT * from cat_servicios where serv_desc='$perfillab'";
            $result_dat_ingl = $conexion->query($sql_dat_ingl);
                while ($row_dat_ingl = $result_dat_ingl->fetch_assoc()) {
                    $id_cta = $row_dat_ingl['id_serv'];
                    if ($tr==1) $precio = $row_dat_ingl['serv_costo'];
                    if ($tr==2) $precio = $row_dat_ingl['serv_costo2'];
                    if ($tr==3) $precio = $row_dat_ingl['serv_costo3'];
                    if ($tr==4) $precio = $row_dat_ingl['serv_costo4'];
                } 
            $registracta = mysqli_query($conexion,'INSERT INTO dat_ctapac
            (id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo,centro_cto)VALUES 
            ('.$id_atencion.',"'.$prodserv.'",'.$id_cta.',"'.$fecha_actual2.'",
                '.$cta_cant.','.$precio.','.$id_usua.',"'.$activo.'","'.$area.'")')or die('<p>Error al registrar cuenta laboratorios</p><br>' . mysqli_error($conexion));
    }
}



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
    $peso = ($_POST['peso']);
    $talla = ($_POST['talla']);

$ingresar = mysqli_query($conexion, 'INSERT INTO signos_vitales (id_atencion,id_usua,fecha,hora,p_sistol,p_diastol,fcard,fresp,temper,satoxi,tipo,peso,talla) values (' . $id_atencion . ' , ' . $id_usua . ' ," ' . $fecha_actual . '",' . $hora_actual . ', " ' . $p_sistol . '" , "' . $p_diastol . '" , "' .$fcard . '" , "' . $fresp . '" , "' . $temper . ' ", "' . $satoxi . ' " ,"HOSPITALIZACION","' . $peso . '", " ' . $talla . ' ") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

}


$resultado=$conexion->query("SELECT * from reg_usuarios WHERE id_usua= $id_usua") or die($conexion->error);
    while ($ROW = mysqli_fetch_array($resultado)) {
 $nombre=$ROW['nombre'];
 $papell=$ROW['papell'];
 $sapell=$ROW['sapell'];
}

$nombre_medico=$nombre.' '.$papell.' '.$sapell;
$fecha_actual = date("Y-m-d H:i:s");
$hora_ord = date("H:i:s");
$insertar = mysqli_query($conexion, 'INSERT INTO dat_ordenes_med(id_atencion,id_usua,fecha_ord,hora_ord,dieta,cuid_gen,det_dieta,signos,monitoreo,diuresis,dex,semif,vigilar,oxigeno,nebulizacion,bar,baño,foley,ej,datsan,detsignos,detmonitoreo,detdiuresis,detdex,detsemif,detvigilar,detoxigeno,detnebu,detbar,detbaño,detfoley,detej,detsan,med_med,soluciones,perfillab,sol_estudios,solicitud_sang,det_sang,observ_be,medico,tipo,detalle_lab,gca,gcat,son,sont,sol_pato,det_pato,det_imagen,dialisis,fisio,reha) values (' . $id_atencion . ',' . $id_usua . ',"' . $fecha_actual . '","' . $hora_ord . '","' . $dieta . '","' . $cuid_gen . '","' . $det_dieta . '","' . $signos . '","' . $monitoreo . '","' . $diuresis . '","' . $dex . '","' . $semif . '","' . $vigilar . '","'.$oxigeno.'","'.$nebu.'","'.$bar.'","'.$baño.'","'.$foley.'","'.$ej.'","'.$datsan.'","'.$detsignos.'","'.$detmonitoreo.'","'.$detdiuresis.'","'.$detdex.'","'.$detsemif.'","'.$detvigilar.'","'.$detoxigeno.'","'.$detnebu.'","'.$detbar.'","'.$detbaño.'","'.$detfoley.'","'.$detej.'","'.$detsan.'","' . $med_med . '","' . $soluciones . '",' . $serv_perfillab . ','. $servicio. ',' . $serv_sang . ',"'.$det_sang.'","'.$observ_be.'","'.$nombre_medico.'","MEDICO","'.$detalle_lab.'","'.$gca.'","'.$gcat.'","'.$son.'","'.$sont.'",'.$serv_pato.',"'.$det_pato.'","'.$det_imagen.'","'.$dialisis.'","'.$fisio.'","'.$reha.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> DATO INSERTADO CORRECTAMENTE...</p>";
        echo '<script type="text/javascript">window.location ="ordenes_vista.php"</script>';
      }
  ?>



  <?php } ?>
<!--termino ordenes med validacion si existe-->
   
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
</script>


</body>
</html>