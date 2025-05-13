<?php
session_start();

include "../../conexionbd.php";

$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 12) {
     include "../../gestion_medica/header_medico.php";
}else if ($usuario['id_rol'] == 2) {
     include "../../gestion_medica/header_medico.php";
}else{
 
        include "../header_ceye.php";
}
?>
<!DOCTYPE html>
<html>
<head>

<meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

   

          <!--BOOTSTRAP CALENDAR-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<!--js CALENDAR-->
<script src="js/jquery.min.js"></script>
<script src="js/moment.min.js"></script>

<!--full CALENDAR-->

<link rel="stylesheet" href="css/fullcalendar.min.css">
<script src="js/fullcalendar.min.js"></script>
<script src="js/es.js"></script> <!--Idioma español Fullcalendar-->
   
<!--relog-->
<script src="js/bootstrap-clockpicker.js"></script>
<link rel="stylesheet" href="css/bootstrap-clockpicker.css">

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</head>

<body>
     <?php
    if ($usuario1['id_rol'] == 4) {
        ?>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
           <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_sauxiliares.php">Regresar</a> 
        </div>
    </div>
</div>
        

        <?php
    } else if ($usuario1['id_rol'] == 8) {

        ?>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
         <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_ceye.php">Regresar</a>   
        </div>
    </div>
</div>
        

        <?php
    }else if ($usuario1['id_rol'] == 5) {

        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_ceye.php">Regresar</a>    
                </div>
            </div>
        </div>
        

        <?php
    } else if ($usuario1['id_rol'] == 12) {

        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_residente.php">Regresar</a>    
                </div>
            </div>
        </div>
        

        <?php
    }else if ($usuario1['id_rol'] == 3) {

        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_enfermera.php">Regresar</a>    
                </div>
            </div>
        </div>
        

        <?php
    }else if ($usuario['id_rol'] == 2) {

        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger btn-sm" href="../../../template/menu_medico.php">Regresar</a>    
                </div>
            </div>
        </div>
        

        <?php
    }


    ?>
        <br>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>PROGRAMACIÓN QUIRÚRGICA</center></strong>
      </div>
<hr>





<form action="" method="GET">

 <input type="time" value="" name="txtHora" id="txtHora" class="form-control">
     <strong>Duración aproximada:</strong><input type="text" id="txtdur" name="txtdur" class="form-control">
 <button type="submit" name="env">enviar</button>
 </form>
 
 <?php 
 if(isset($_GET['env'])){
    
    $horai=$_GET['txtHora'];
    $txtdur=$_GET['txtdur'];
    
     $fecha = new DateTime($horai);
$fecha2 = clone $fecha;

$intervalo = new DateInterval('PT'.$txtdur.'H');

echo $fecha->format('G:i:s a');
echo '<br>';
$fecha->add($intervalo);
echo $fecha->format('G:i:s a'); 
  
 }else{
     echo"no";
 }
 ?>
 
 
 

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

</body>
</html>