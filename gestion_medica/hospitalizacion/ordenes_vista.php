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


    <title>DATOS NURGEN </title>
</head>
<body>


<div class="col-sm-12">
    <div class="container">
        <div class="row">

            <div class="col">
                 <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>INDICACIONES MÉDICAS</strong></center><p>
</div>
             
                <?php

    include "../../conexionbd.php";

    if (isset($_SESSION['hospital'])) {
      $id_atencion = $_SESSION['hospital'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.folio, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
         
  <div class="row">
    <div class="col-sm-2">
      Expediente: <strong><?php echo $folio?> </strong>
    </div>
    <div class="col-sm-6">
     Paciente: <strong><?php echo $pac_nom_pac . ' ' . $pac_papell . ' ' .$pac_sapell  ?></strong>
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
$result_hab = $conexion->query($sql_hab);   
while ($row_hab = $result_hab->fetch_assoc()) {
  echo $row_hab['num_cama'];
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
$sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by diagprob_i DESC LIMIT 1";
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
        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
      }
        ?>
</div>
<hr>
</p>
<div class="row">
   
 <div class="container">
    <hr>
    <div class="row">
        <center><a href="ordenes_medico.php"><button type="button" class="btn btn-danger">Registrar Nuevas Indicaciones</button></a></center>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       
  </div>
</div>
           


        </div>

            </div>
        </div>

 
 <p>
        <form action="insertar_ordenes_medico.php" method="POST">
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
  <!--
   <div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
                <div class="container"> 
  <div class="row">
    <div class="col-sm-2"><br><center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" name="p_sistol" ></div> /
  <div class="col"><input type="text" class="form-control" name="p_diastol"></div>
 
</div>
    </div>
    <div class="col-sm-2">
      FRECUENCIA CARDIACA:<input type="text" class="form-control" name="fcard">
    </div>
    <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" class="form-control" name="fresp">
    </div>
    <div class="col-sm-2">
     <br>TEMPERATURA:<input type="text" class="form-control"  name="temper">
    </div>
    <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="text"  class="form-control" name="satoxi">
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" class="form-control"  name="peso">
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" class="form-control" name="talla" >
    </div>
  </div>
</div>


-->
<?php } ?>

<!--<?php
                            //
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
            



<?php 

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from dat_ordenes_med WHERE id_atencion=" . $_SESSION['hospital']." ORDER BY id_ord_med DESC") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
     
    
    ?>
<hr>
    <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 24px;">
  <center><strong>PRESCRIPCIÓN Y ÓRDENES: PREPARACIÓN DE CASOS QUIRÚRGICOS, DIETAS, ETC.</strong></center><p>
</div>

<div class="container box"><br>
    <div class="container">
  <div class="row">
        <div class=" col">
                    Tipo: <strong><?php echo $f5['tipo']; ?></strong>
                </div>
                <div class="col-sm-3">
                    <?php $fech=date_create($f5['fecha_ord']) ?>
                    Fecha: <strong><?php echo date_format($fech, 'd-m-Y'); ?></strong> 
                </div>
                <div class="col-sm-3">
                    Hora: <strong><?php echo $f5['hora_ord']; ?></strong>
                </div>
       </div>
          <hr>
    </div>
         

    <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">1.- Dieta:</font></label></strong></center>
                </div>
                <div class="col-2">
                      <strong><br><?php echo $f5['dieta']; ?></strong>
                    </div>
                </div>

            </div>

        <div class="container">
             <div class="row">
                 <div class="col-2">
                        <p style="color:#2b2d7f";><strong>Detalle de dieta:</strong></p>
                    </div>
                 <div class="col-8">
                      <strong><?php echo $f5['det_dieta']; ?></strong>
                 </div>
            </div>
            <div class="col-3">
            <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f">2.- Cuidados generales:</font></label></strong></center>
        </div>
        </div>
        
        
<?php
         if($f5['tipo']=='MEDICO'){

         

         ?>

        
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Signos vitales por turno</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['signos']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detsignos']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Monitoreo constante</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['monitoreo']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detmonitoreo']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Diuresis por turno</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['diuresis']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detdiuresis']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Dextrostix por turno</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['dex']; ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <strong><?php echo $f5['detdex']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Posición semifowler</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['semif']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detsemif']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Vigilar datos del paciente neurológico</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['vigilar']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detvigilar']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Oxígeno</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['oxigeno']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detoxigeno']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Nebulizaciones</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['nebulizacion']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detnebu']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Barandales en alto</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['bar']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detbar']; ?></strong>
                    </div>

                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Baño diario y deambulación asistida</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['baño']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detbaño']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Cuidados de sonda foley</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['foley']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detfoley']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Ejercicios respiratorios</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['ej']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detej']; ?></strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Vigilar datos de sangrado</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['datsan']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['detsan']; ?></strong>
                    </div>
                </div>
            </div>


<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Glucometría capilar<br>Reportar < 80 o > 180</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['gca']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['gcat']; ?></strong>
                    </div>
                </div>
            </div>

<div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <strong><font color="#2b2d7f">Sonda nasogástrica a derivación</font></strong>
                    </div>
                    <div class="col-sm-1">
                        <strong><?php echo $f5['son']; ?></strong>
                    </div>
                    <div class="col-sm-5">
                        <strong><?php echo $f5['sont']; ?></strong>
                    </div>
                </div>
            </div>
  <?php
             } else if($f5['tipo']=='VERB'){


             ?>

<?php }
?>
            <div class="container">
             <div class="row">
                <div class="col-sm-1">
                    <center><strong><label><font size="3" color="#2b2d7f">Otros:</font></label></strong></center>
                </div>
                 <div class="col-sm-3">
                        
                    </div>
                <div class="col-sm-5">
                        <strong><?php echo $f5['observ_be']; ?></strong>
                </div>
            </div>
        </div>
          


           <div class="container">
             
            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f ">3.- Medicamentos:</font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group"><br>
                        <textarea class="form-control" rows="5" disabled><?php echo $f5['med_med']; ?></textarea>
                        
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f ">4.- Soluciones:</font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group"><br>
                        <textarea class="form-control" rows="5" disabled><?php echo $f5['soluciones']; ?></textarea>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f ">5.- Estudios Laboratorio:</font></label></strong></center>
                </div>
                <div class="col-sm-5">
<br>
                    <div class="form-group"><br>
                        <strong><?php echo $f5['perfillab']; ?></strong>
                    </div>
                </div>
                   <div class="col-sm-5">Detalle de estudios laboratorio<br>
<textarea class="form-control" name="detalle_lab" rows="5" disabled><?php echo $f5['detalle_lab']?></textarea>
 </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f ">6.- Estudios imagenología:</font></label></strong></center>
                </div>
                <div class="col-sm-5">
                    <div class="form-group"><br><br>
                        <strong><?php echo $f5['sol_estudios']; ?></strong>
                    </div>
                </div>      
<div class="col-sm-5">Detalle estudios imagenología<br>
<textarea class="form-control" name="det_pato" rows="5" disabled><?php echo $f5['det_imagen']?></textarea>
 </div>
                      </div>

             <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f ">7.- Estudios patología:</font></label></strong></center>
                </div>
                <div class="col-sm-5">

                    <div class="form-group"><br><br>
                        <strong><?php echo $f5['sol_pato']; ?></strong>
                    </div>
                </div>
                <div class="col-sm-5">Detalle estudios patología<br>
<textarea class="form-control" name="det_pato" rows="5" disabled><?php echo $f5['det_pato']?></textarea>
 </div>
            </div>

            <div class="row">
                <div class="col-sm-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f ">8.- Solicitud de transfusión sabguínea:</font></label></strong></center>
                </div>
                <div class="col-sm-5">

                    <div class="form-group"><br><br>
                        <strong><?php echo $f5['solicitud_sang']; ?></strong>
                    </div>
                </div>
                <div class="col-sm-5">Detalle de transfusión sanguínea<br>
<textarea class="form-control" name="det_sang" rows="5" disabled><?php echo $f5['det_sang']?></textarea>
 </div>
            </div>
           </div>
           <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>PROCEDIMIENTOS EN MEDICINA DE TRATAMIENTO</strong></center><p>
</div>

 <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f "> Diálisis:</font></label></strong></center>
                </div>
                <div class=" col-sm-10">
                    <div class="form-group"><br>
                        <textarea class="form-control" rows="5" disabled><?php echo $f5['dialisis']; ?></textarea>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f "> Fisioterapía:</font></label></strong></center>
                </div>
                <div class=" col-sm-10">
                    <div class="form-group"><br>
                        <textarea class="form-control" rows="5" disabled><?php echo $f5['fisio']; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f "> Inhaloterapia:</font></label></strong></center>
                </div>
                <div class=" col-sm-10">
                    <div class="form-group"><br>
                        <textarea class="form-control" rows="5" disabled><?php echo $f5['cuid_gen']; ?></textarea>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f "> Rehabilitación:</font></label></strong></center>
                </div>
                <div class=" col-sm-10">
                    <div class="form-group"><br>
                        <textarea class="form-control" rows="5" disabled><?php echo $f5['reha']; ?></textarea>
                    </div>
                </div>
            </div>
           
            <?php
}
?>
      <hr>
<br><br>
<div class="form-group col-12">
  <center>
<button type="button" class="btn btn-danger" onclick="history.back()">Regresar...</button></center>
</div><br>
      


            <br>
            <br>
        </form>


        <!--TERMINO DE NOTA DE EVOLUCION-->


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