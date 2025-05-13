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
  <title>BANCO DE SANGRE</title>
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

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
                
<div class="container">
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                 <tr><strong><center>REGISTRO DE TRANSFUSIONES EN EL EXPEDIENTE CLÍNICO</center></strong>
</div>
    <hr>
<?php

include "../../conexionbd.php";
if (isset($_SESSION['pac'])) {
$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['pac']) or die($conexion->error);

?>
  <?php
                    while ($f1 = mysqli_fetch_array($resultado1)) {
                           $sangre=$f1['tip_san'];

                        ?>
 
                      <div class="container"> 
                        <div class="row">
      <div class="col-sm-6">
EXPEDIENTE : <td><strong><?php echo $f1['Id_exp']; ?></strong></td><br>
PACIENTE : <td><strong><?php echo $f1['papell']; ?></strong></td>
<td><strong><?php echo $f1['sapell']; ?></strong></td>
<td><strong><?php echo $f1['nom_pac']; ?></strong></td><br>
SEXO : <td><strong><?php echo $f1['sexo']; ?></strong></td><br>
   
    </div>

    <div class="col-sm-4">
<?php $date = date_create($f1['fecha']);
$date1 = date_create($f1['fecnac']);
                                     ?>
      FECHA DE INGRESO : <td><strong><?php echo date_format($date, "d/m/Y"); ?></strong></td><br>
      FECHA DE NACIMIENTO : <td><strong><?php echo date_format($date1, "d/m/Y"); ?></strong></td><br>
      EDAD : <td><strong><?php echo $f1['edad']; ?></strong></td><br>  
    <?php  
                    }
                    ?> 
    </div>

<?php
$resultado2 = $conexion->query("select * from cat_camas WHERE id_atencion=" .$_SESSION['pac']) or die($conexion->error);
while ($f2 = mysqli_fetch_array($resultado2)) {
?>
  <div class="col">
<?php  
 if(isset($f2)){
    $cama=$f2['num_cama'];
  }else{
    $cama=' ';
  }
 ?>
HABITACIÓN : <td><strong><?php echo $cama; ?></strong></td>

<?php
}
?>
    </div>
    </div>
    
  </div>

</div>
<hr>
</div><hr>
    <?php 
    $id_sang=$_GET['id_sang'];
    $select_sig="SELECT * FROM dat_trans_sangre WHERE id_sangre=$id_sang";
    $res_sig=$conexion->query($select_sig);
    while ($row=$res_sig->fetch_assoc()) {
      $numt=$row['numt'];
      $cont=$row['cont'];

      $t=$row['t'];
      $td=$row['td'];
      $tde=$row['tde'];
      $a=$row['a'];
      $ad=$row['ad'];
      $ade=$row['ade'];
      $fc=$row['fc'];
      $fcd=$row['fcd'];
      $fcde=$row['fcde'];
      $temp_t=$row['temp_t'];
      $temp_td=$row['temp_td'];
      $temp_tde=$row['temp_tde'];
    }
     ?>
  <form action="" method="POST">
    <div class="row">
    <label><strong>TIPO DE SANGRE : <?php echo $sangre; ?></label></strong>
  </div>
  <div class="row">
    <label><strong>FOLIO  : <?php echo $numt; ?></label></strong>
  </div>
  <div class="row">
    <label><strong>CONTENIDO : <?php echo $cont; ?></label></strong>
  </div>  
    <hr>
    </div><br>
 <div class="container">  <!--INICIO -->
<div class="container">
  <strong><label>SIGNOS VITALES PRE-TRANSFUSIÓN</label></strong>
  <div class="row">
    <div class="col-sm-3">
      <label>PRESIÓN SISTOLICA</label>
      <input type="number" name="t" class="form-control" value="<?php echo $t ?>">
    </div>
    <div class="col-sm-3">
      <label>PRESIÓN DIASTOLICA</label>
      <input type="number" name="a" class="form-control" value="<?php echo $a ?>">
    </div>
    <div class="col-sm-3">
      <label>FRECUENCIA CARDIACA</label>
      <input type="number" name="fc" class="form-control" value="<?php echo $fc ?>">
    </div>
    <div class="col-sm-3">
      <label>TEMPERATURA</label>
      <input type="cm-number" name="temp_t" class="form-control" value="<?php echo $temp_t ?>">
    </div>
  </div><hr>
  <strong><label>SIGNOS VITALES TRANSFUSIÓN</label></strong>
  <div class="row">
    <div class="col-sm-3">
      <label>PRESIÓN SISTOLICA</label>
      <input type="number" name="td" class="form-control" value="<?php echo $td ?>">
    </div>
    <div class="col-sm-3">
      <label>PRESIÓN DIASTOLICA</label>
      <input type="number" name="ad" class="form-control" value="<?php echo $ad ?>">
    </div>
    <div class="col-sm-3">
      <label>FRECUENCIA CARDIACA</label>
      <input type="number" name="fcd" class="form-control" value="<?php echo $fcd ?>">
    </div>
    <div class="col-sm-3">
      <label>TEMPERATURA</label>
      <input type="cm-number" name="temp_td" class="form-control" value="<?php echo $temp_td ?>">
    </div>
  </div><hr>
 <strong><label>SIGNOS VITALES POST-TRANSFUSIÓN</label></strong>
  <div class="row">
    <div class="col-sm-3">
      <label>PRESIÓN SISTOLICA</label>
      <input type="number" name="tde" class="form-control" value="<?php echo $tde ?>">
    </div>
    <div class="col-sm-3">
      <label>PRESIÓN DIASTOLICA</label>
      <input type="number" name="ade" class="form-control" value="<?php echo $ade ?>">
    </div>
    <div class="col-sm-3">
      <label>FRECUENCIA CARDIACA</label>
      <input type="number" name="fcde" class="form-control" value="<?php echo $fcde ?>">
    </div>
    <div class="col-sm-3">
      <label>TEMPERATURA</label>
      <input type="cm-number" name="temp_tde" class="form-control" value="<?php echo $temp_tde ?>">
    </div>
  </div>
</div><br>
<div class="row">
  <div class="col-sm-3"></div>
  <div class="col-sm-5">
    <label>HORA DE TERMINO</label>
    <input type="time" name="hora_t" class="form-control">
  </div>
</div><br>
<div class="row">
  <div class="col-sm-4"></div>
  <div class="col-sm-7">
    <input type="submit" name="btnsig" value="GUARDAR" class="btn btn-success">
    <button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button>
  </div>
</div>
  </form><br>
</div> <!--TERMINO DE div container-->
    <?php 
    if (isset($_POST['btnsig'])) {
       $id_sang    = mysqli_real_escape_string($conexion, (strip_tags($_GET["id_sang"], ENT_QUOTES)));
        $t    = mysqli_real_escape_string($conexion, (strip_tags($_POST["t"], ENT_QUOTES)));
        if (isset($_POST["td"])) {
    $td= mysqli_real_escape_string($conexion, (strip_tags($_POST["td"], ENT_QUOTES))); 
  }else{
    $td=" ";
  }

   if (isset($_POST["tde"])) {
    $tde= mysqli_real_escape_string($conexion, (strip_tags($_POST["tde"], ENT_QUOTES)));
  }else{
    $tde=" ";
  }
   if (isset($_POST["a"])) {
    $a= mysqli_real_escape_string($conexion, (strip_tags($_POST["a"], ENT_QUOTES)));
  }else{
    $a=" ";
  }
  if (isset($_POST["ad"])) {
    $ad= mysqli_real_escape_string($conexion, (strip_tags($_POST["ad"], ENT_QUOTES)));
  }else{
    $ad=" ";
  }
  if (isset($_POST["ade"])) {
    $ade    = mysqli_real_escape_string($conexion, (strip_tags($_POST["ade"], ENT_QUOTES)));
  }else{
    $ade=" ";
  }
  if (isset($_POST["fc"])) {
    $fc   = mysqli_real_escape_string($conexion, (strip_tags($_POST["fc"], ENT_QUOTES)));
  }else{
    $fc=" ";
  }
   if (isset($_POST["fcd"])) {
    $fcd    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fcd"], ENT_QUOTES)));
  }else{
    $fcd=" ";
  }
  if (isset($_POST["fcde"])) {
    $fcde    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fcde"], ENT_QUOTES)));
  }else{
    $fcde=" ";
  }
  if (isset($_POST["temp_t"])) {
    $temp_t    = mysqli_real_escape_string($conexion, (strip_tags($_POST["temp_t"], ENT_QUOTES)));
  }else{
    $temp_t=" ";
  }
  if (isset($_POST["temp_td"])) {
    $temp_td    = mysqli_real_escape_string($conexion, (strip_tags($_POST["temp_td"], ENT_QUOTES)));
  }else{
    $temp_td=" ";
  }
  if (isset($_POST["temp_tde"])) {
    $temp_tde   = mysqli_real_escape_string($conexion, (strip_tags($_POST["temp_tde"], ENT_QUOTES)));
  }else{
    $temp_tde=" ";
  }

   if (isset($_POST["hora_t"])) {
    $hora_t   = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_t"], ENT_QUOTES)));
  }else{
    $hora_t="";
  }

  

    $upd_sig="UPDATE dat_trans_sangre SET t='$t', td='$td', tde='$tde', a='$a', ad='$ad', ade='$ade', fc='$fc', fcd='$fcd' ,fcde='$fcde' , temp_t='$temp_t', temp_td='$temp_td' , temp_tde='$temp_tde', hor_t='$hora_t' WHERE id_sangre=$id_sang";
    $result=$conexion->query($upd_sig);

    echo '<script type="text/javascript">window.location ="signos_vitales_transf.php"</script>';
    }
     ?>              
</div>
</div>
 <?php
            } else {
                echo '<script type="text/javascript"> window.location.href="../../template/select_pac_enf.php";</script>';
            }
            ?>

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



</body>
</html>