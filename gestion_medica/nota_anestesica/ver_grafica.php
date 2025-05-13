<?php
session_start();
//include "../../conexionbd.php";
include "../header_medico.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);

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

  <!---
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
-->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/aos.js"></script>
    <script src="../js/main.js"></script>


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
  <script>
    // Write on keyup event of keyword input element
    $(document).ready(function() {
      $("#search_dep").keyup(function() {
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
  <title>SIGNOS VITALES</title>
  <style type="text/css">
    #contenido{
        display: none;
    }
     #contenido3{
        display: none;
    }
     #contenido4{
        display: none;
    }
</style>
  
</head>

<body>
 
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
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
          $ano_diferencia--;
        return $ano_diferencia;
      }

      $edad = calculaedad($pac_fecnac);

    ?>
  

<div class="container">
  <a href="javascript:window.print()">
<i class="fa fa-print" aria-hidden="true" alt="IMPRIMIR"></i>
</a>
  <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
  <div class="row">
    
       <div class="col-sm-3">
        <br><img src="../../imagenes/SI.PNG" height="60" width="185">
       </div>
       <div class="col-sm-7">
          <center><strong>  Josefa Ortiz de Domínguez, #444  </strong></center>
          <center><strong>Barrio Coaxustenco, Metepec</strong></center>
          <center><strong>Estado de México. C.P. 52140 TEL.: 7222350175
7229020390</strong></center>
          <center><strong>https://medicasanisidro.com/</strong></center>
          <center><strong>REGISTRO GRÁFICO TRANS-ANESTÉSICO</strong></center>
      </div>
      <div class="col-sm-1">
          <br><img src="../../imagenes/SI.PNG" height="60" width="165">
      </div>
    </div>
  </div>
</div><p>

 <font size="2">
         <div class="container">
  <div class="row">
    <div class="col-sm">
     Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    <div class="col-sm">
      Área: <strong><?php echo $area ?></strong>
    </div>
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm">
      Fecha de ingreso: <strong><?php echo date_format($date, "d-m-Y H:i:s") ?></strong>
    </div>
  </div>
</div></font>

 <font size="2">
     <div class="container">
  <div class="row">
    <div class="col-sm">
       <?php $date1 = date_create($pac_fecnac);
   ?>
    Fecha de nacimiento: <strong><?php echo date_format($date, "d-m-Y") ?></strong>
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
      Edad: <strong><?php echo $edad ?></strong>
    </div>
    <div class="col-sm-3">

      Peso: <strong><?php $sql_vit = "SELECT peso from signos_vitales where id_atencion=$id_atencion ORDER by peso ASC LIMIT 1";
$result_vit = $conexion->query($sql_vit);                                                                                    while ($row_vit = $result_vit->fetch_assoc()) {
  echo $row_vit['peso'];
} ?></strong>
    </div>
  
      <div class="col-sm">
      Talla: <strong><?php $sql_vitt = "SELECT talla from signos_vitales where id_atencion=$id_atencion ORDER by talla ASC LIMIT 1";
$result_vitt = $conexion->query($sql_vitt);                                                                                    while ($row_vitt = $result_vitt->fetch_assoc()) {
  echo $row_vitt['talla'];
} ?></strong>
    </div>

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
  </div>
</div>
</font>
 <font size="2">
  <div class="container">
  <div class="row">
    <div class="col-sm">
      Género: <strong><?php echo $pac_sexo ?></strong>
    </div>
    <div class="col-sm">
    Estado de salud: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud ASC LIMIT 1";
$result_edo = $conexion->query($sql_edo);                                                                                    while ($row_edo = $result_edo->fetch_assoc()) {
  echo $row_edo['edo_salud'];
} ?></strong>
    </div>
      <div class="col-sm">
      Expediente: <strong><?php echo $id_exp?> </strong>
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
<div class="container">
  <div class="row">
    <div class="col-sm">
      Alergias: <strong><?php echo $alergias ?></strong>
    </div>
   
  </div>
</div></font>
<hr>

        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
      }
        ?>
    
<body>
  
<div class="container">
    <div class="row">
        
            
            
         

            <!--<div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
            </div>-->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="container" >
  <div class="row">
  
 <div class="col-sm-12">
     
      <p>
   <?php

include "../../conexionbd.php";
$id_atencion=$_SESSION['hospital'];
$resultado = $conexion->query("SELECT * from dat_trans_grafico WHERE id_atencion=$id_atencion ORDER BY id_trans_graf ASC limit 1") or die($conexion->error);
$usuario = $_SESSION['login'];
?>
   <?php
                $no=1;
                while($f = mysqli_fetch_array($resultado)){
                   
                    ?>
<div class="container">
  <div class="row">
    <div class="col-sm"><br>
      <strong>Tipo de anestesia:</strong>
    </div>
    <div class="col-sm">
        Tiva
      <input value="<?php echo $f['tiva'];?>" class="form-control" disabled>
    </div>
    <div class="col-sm">
       Local:
     <input value="<?php echo $f['tanest'];?>" class="form-control" disabled>
       
    </div>
    <div class="col-sm">
     General:
           <input value="<?php echo $f['general'];?>" class="form-control" disabled>
    </div>
    <div class="col-sm">
        Rregonal:
        <input value="<?php echo $f['regional'];?>" class="form-control" disabled>
    </div>
  </div>
</div>

<hr>
<div class="container">
  <div class="row">
    <div class="col-sm">
    <strong>Inicio anestesia</strong>
<input value="<?php echo $f['ina'];?>" class="form-control" disabled>
    </div>
    <div class="col-sm">
       <strong>Inicio operación</strong>
<input value="<?php echo $f['ino'];?>" class="form-control" disabled>
    </div>
    <div class="col-sm">
      <strong> Término operación</strong>
<input value="<?php echo $f['top'];?>" class="form-control" disabled>
    </div>
     <div class="col-sm">
      <strong>Término anestesia</strong>
<input value="<?php echo $f['ta'];?>" class="form-control" disabled>
    </div>
  </div>
</div>
<hr>
<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
         <tr><strong><center>GRÁFICO / SIGNOS VITALES</center></strong>
</div>

                <?php
                }
                ?>
    <canvas id="grafica"></canvas>
    <script src="script.js"></script>
    </div>
    
   
  
  </div><p>
<div class="container">
  <div class="row">
    <div class="col-sm-9">
    </div>
    <div class="col-sm">
    </div>

    <div class="col-sm">
      <small><strong>CMSI-7.04</strong></small>
    </div>
  </div>
</div>

<hr>
  <center>
  <a href="../nota_anestesica/nota_registro_grafico.php" role="button" class="btn btn-danger">Regresar..</a></center><p>
  
</div>
   

        </div>
    </div>
    
</div>



<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>

<script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
      
 



<script>

const $grafica = document.querySelector("#grafica");
// Las etiquetas son las que van en el eje X. 
const etiquetas = ["1", "2", "3", "4","5", "6", "7", "8","9", "10", "11", "12","13", "14", "15", "16","17", "18", "19", "20","21", "22", "23", "24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48"]
// Podemos tener varios conjuntos de datos
const presion = {
    label: "Presión sistolica",
    data: [<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=34") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
    borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
    borderWidth: 1,// Ancho del borde
};
const frec = {
    label: "Presión diastolica",
   data: [<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=34") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(255, 159, 64, 0.2)',// Color de fondo
    borderColor: 'rgba(255, 159, 64, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

const fresp = {
    label: "Frecuencia cardiaca",
    data: [<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=34") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>],// La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(25, 159, 64, 0.2)',// Color de fondo
    borderColor: 'rgba(25, 159, 64, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

const temp = {
    label: "Frecuencia respiratoria",
    data: [<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=34") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>],// La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(255, 5, 164, 0.2)',// Color de fondo
    borderColor: 'rgba(255, 5, 164, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

const sat = {
    label: "Saturación oxígeno",
    data: [<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=34") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>],// La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(255, 5, 4, 0.2)',// Color de fondo
    borderColor: 'rgba(255, 5, 4, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

const niv = {
    label: "Temperatura",
    data: [<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>],// La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(155, 125, 224, 0.2)',// Color de fondo
    borderColor: 'rgba(155, 125, 224, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

new Chart($grafica, {
    type: 'line',// Tipo de gráfica
    data: {
        labels: etiquetas,
        datasets: [
            presion,
            frec,
            fresp,
            temp,
            sat,
            niv
            // Aquí más datos...
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
        },
    }
});
</script>


  
</body>
</html>