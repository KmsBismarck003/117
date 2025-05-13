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

    <title>AVISO DE ALTA </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
                
<div class="thead" style="background-color: #0c675e; color: white; font-size: 24px;">
  <center><strong>AVISO DE ALTA</strong></center><p>
</div> 
    
<?php

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);

?>
  <?php
                    while ($f1 = mysqli_fetch_array($resultado1)) {
                           

                        ?>
                      <div class="container"> 
                        <div class="row">
      <div class="col-sm-6">
 NO.EXPEDIENTE : <td><strong><?php echo $f1['Id_exp']; ?></strong></td><br>
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
$resultado2 = $conexion->query("select * from cat_camas WHERE id_atencion=" .$_SESSION['hospital']) or die($conexion->error);
while ($f2 = mysqli_fetch_array($resultado2)) {
?>
  <div class="col">
<?php  
 if(isset($f2)){
    $cama=$f2['num_cama'];
  }else{
    $cama='Sin Cama';
  }
 ?>
HABITACIÓN : <td><strong><?php echo $cama; ?></strong></td> 

<?php
}
?>
    </div>
    
    
  </div>

</div>

<hr>
 
            </div>
            <!--<div class="col-sm-3">
                <?php
                
                $fecha_actual = date("d-m-Y H:i:s");
                ?>
                
                <div class="form-group">
                    <label for="fecha">Fecha y Hora Actual:</label>
                    <input type="datetime" value="<?= $fecha_actual ?>" class="form-control" disabled>
                </div>
            </div>-->
        </div>



  
   <!--INICIO -->
<form action="" method="POST">

<div class="container">
    <div class="row">
     <?php

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);

?>
  <?php
                    while ($f1 = mysqli_fetch_array($resultado1)) {
                           

                        ?>
     <div class="col-sm-4">
        <div class="form-group">
            <label>FECHA Y HORA DE INGRESO</label>
            <input type="datetime" value="<?php echo date_format($date, "d/m/Y H:i:s"); ?>" class="form-control" name="" onkeypress="" disabled>
        </div>
     </div>
     <?php } ?>
      <?php 
$id_alta=$_GET['id_alta'];
$alta="SELECT * FROM alta where id_alta=$id_alta";
$result=$conexion->query($alta);
while ($row=$result->fetch_assoc()) {
 ?>
     <div class="col-sm-4">
        <div class="form-group">
            <label>FECHA Y HORA DE EGRESO</label>
            <input type="datetime" value="<?php echo $row['fech_alta'] ?>" class="form-control" name="" onkeypress="" disabled>
        </div>
        
     </div>   
<?php } ?>

<?php
$resultado3 = $conexion->query("select id_atencion,area from dat_ingreso
 WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);

?>
  <?php
                    while ($f3 = mysqli_fetch_array($resultado3)) {
                           

                        ?>
    <div class="col-sm-3">
        <div class="form-group">
          <label>AREA DE EGRESO</label>
            <input type="datetime" value="<?php echo $f3['area']; ?>" class="form-control" name="" onkeypress="" disabled>  
        </div>
    </div>
</div>

<?php
}
?> 
      <?php 
$id_alta=$_GET['id_alta'];
$alta="SELECT * FROM alta where id_alta=$id_alta";
$result=$conexion->query($alta);
while ($row=$result->fetch_assoc()) {
    $id_usua=$row['id_usua'];
 ?>
<div class="row">
    <?php 
    if($row['alta_por'] == "MEJORIA"){
     ?>
    <div class="col-sm-5">
        <div class="form-group">
           <center><label>ALTA POR :</label> </center>
           <div class="row">
              <div class="col">
                <input type="radio" name="alta_por" checked="" value="MEJORIA" required=""> <label>MÁXIMO BENEFICIO</label><br>
                <input type="radio" name="alta_por" value="CURACION"> <label>CURACIÓN</label><br>
                <input type="radio" name="alta_por" value="VOLUNTARIA"> <label>VOLUNTARIA</label><br>
                <input type="radio" name="alta_por" value="DEFUNCION"> <label>DEFUNCIÓN</label><br>
                <input type="radio" name="alta_por" value="TRANSLADO A OTRA INSTITUCION"> <label>  TRANSLADO A OTRA INSTITUCIÓN</label>
              </div>
            </div>    
        </div>
    </div>
<?php }elseif($row['alta_por'] == "CURACION"){ ?>
<div class="col-sm-5">
        <div class="form-group">
           <center><label>ALTA POR :</label> </center>
           <div class="row">
              <div class="col">
                <input type="radio" name="alta_por" value="MEJORIA" required=""> <label>MÁXIMO BENEFICIO</label><br>
                <input type="radio" name="alta_por" checked="" value="CURACION"> <label>CURACIÓN</label><br>
                <input type="radio" name="alta_por" value="VOLUNTARIA"> <label>VOLUNTARIA</label><br>
                <input type="radio" name="alta_por" value="DEFUNCION"> <label>DEFUNCIÓN</label><br>
                <input type="radio" name="alta_por" value="TRANSLADO A OTRA INSTITUCION"> <label>  TRANSLADO A OTRA INSTITUCIÓN</label>
              </div>
            </div>    
        </div>
    </div>
<?php }elseif($row['alta_por'] == "VOLUNTARIA"){ ?>
<div class="col-sm-5">
        <div class="form-group">
           <center><label>ALTA POR :</label> </center>
           <div class="row">
              <div class="col">
                <input type="radio" name="alta_por" value="MEJORIA" required=""> <label>MÁXIMO BENEFICIO</label><br>
                <input type="radio" name="alta_por" value="CURACION"> <label>CURACIÓN</label><br>
                <input type="radio" name="alta_por" checked="" value="VOLUNTARIA"> <label>VOLUNTARIA</label><br>
                <input type="radio" name="alta_por" value="DEFUNCION"> <label>DEFUNCIÓN</label><br>
                <input type="radio" name="alta_por" value="TRANSLADO A OTRA INSTITUCION"> <label>  TRANSLADO A OTRA INSTITUCIÓN</label>
              </div>
            </div>    
        </div>
    </div>
<?php }elseif($row['alta_por'] == "DEFUNCION"){ ?>
<div class="col-sm-5">
        <div class="form-group">
           <center><label>ALTA POR :</label> </center>
           <div class="row">
              <div class="col">
                <input type="radio" name="alta_por" value="MEJORIA" required=""> <label>MÁXIMO BENEFICIO</label><br>
                <input type="radio" name="alta_por" value="CURACION"> <label>CURACIÓN</label><br>
                <input type="radio" name="alta_por" value="VOLUNTARIA"> <label>VOLUNTARIA</label><br>
                <input type="radio" name="alta_por" checked="" value="DEFUNCION"> <label>DEFUNCIÓN</label><br>
                <input type="radio" name="alta_por" value="TRANSLADO A OTRA INSTITUCION"> <label>  TRANSLADO A OTRA INSTITUCIÓN</label>
              </div>
            </div>    
        </div>
    </div>
<?php }elseif($row['alta_por'] == "TRANSLADO A OTRA INSTITUCION"){ ?>
<div class="col-sm-5">
        <div class="form-group">
           <center><label>ALTA POR :</label> </center>
           <div class="row">
              <div class="col">
                <input type="radio" name="alta_por" value="MEJORIA" required=""> <label>MÁXIMO BENEFICIO</label><br>
                <input type="radio" name="alta_por" value="CURACION"> <label>CURACIÓN</label><br>
                <input type="radio" name="alta_por" value="VOLUNTARIA"> <label>VOLUNTARIA</label><br>
                <input type="radio" name="alta_por" value="DEFUNCION"> <label>DEFUNCIÓN</label><br>
                <input type="radio" name="alta_por" checked="" value="TRANSLADO A OTRA INSTITUCION"> <label>  TRANSLADO A OTRA INSTITUCIÓN</label>
              </div>
            </div>    
        </div>
    </div>
<?php } ?>

    <div class="col-sm-5">
        <div class="form-group">
            <center><label>ORDEN DE SALIDA :</label> </center>
             <label>FECHA :<br></label><input type="date" value="<?php echo $row['fech_alta'] ?>" class="form-control" name="fech_alta"><br>
             <label>HORA :<br></label><input type="time" class="form-control" value="<?php echo $row['hor_alta'] ?>" name="hor_alta"><br>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        OBSERVACIONES:<br>
        <textarea name="obs_med" class="form-control" rows="5"><?php echo $row['obs_med'] ?></textarea>
    </div>
</div>
    <?php 
$date=date_create($row['fecha_altamed']);
$id_usua=$row['id_usua'];
?>
      <div class="row">
          <div class="col-sm-4">
              <div class="form-group">
                 <strong> <label>FECHA REGISTRO : </label></strong><br>
                 <input type="date" name="fecha" value="<?php echo date_format($date,"Y-m-d") ?>" class="form-control">
             </div>
           </div>
           <div class="col-sm-4">
              <div class="form-group">
                 <strong> <label>HORA REGISTRO :</label></strong><br>
                 <input type="time" name="hora" value="<?php echo date_format($date,"H:i:s") ?>" class="form-control">
             </div>
           </div>
       <?php 
   }
$select="SELECT * FROM reg_usuarios where id_usua=$id_usua";
$resultado=$conexion->query($select);
while ($row_doc=$resultado->fetch_assoc()) {
    $doctor=$row_doc['nombre'].' '.$row_doc['papell'].' '.$row_doc['sapell'];
    $id_doc=$row_doc['id_usua'];
}

        ?>
          <div class="col-sm-4">
              <div class="form-group">
                 <strong> <label>MÉDICO QUE REGISTRÓ: </label></strong><br>
                 <select name="medico" class="form-control" >
                     <option value="<?php echo $id_doc ?>"><?php echo $doctor ?></option>
                     <option></option>
                     <option value=" ">SELECCIONAR MEDICO :</option>
                     <?php 
                      $select="SELECT * FROM reg_usuarios where id_rol=2 || id_rol=12";
                      $resultado=$conexion->query($select);
                      foreach ($resultado as $row ) {
                      ?>
                      <option value="<?php echo $row['id_usua'] ?>"><?php echo $row['nombre'].' '.$row['papell'].' '.$row['sapell']; ?></option>
                  <?php } ?>
                 </select>
             </div>
           </div>
       </div>
</div><hr>
<center>
    <div class="form-group col-6">
      <button type="submit" name="guardar" class="btn btn-primary">FIRMAR</button>
      <button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button>
    </div>
</center><br>
</form>
</div> <!--TERMINO DE div container-->

</div>
 <?php 
  if (isset($_POST['guardar'])) {

        $alta_por    = mysqli_real_escape_string($conexion, (strip_tags($_POST["alta_por"], ENT_QUOTES))); //Escanpando caracteres
        $fech_alta    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fech_alta"], ENT_QUOTES))); //Escanpando caracteres
        $hor_alta  = mysqli_real_escape_string($conexion, (strip_tags($_POST["hor_alta"], ENT_QUOTES)));
        $obs_med    = mysqli_real_escape_string($conexion, (strip_tags($_POST["obs_med"], ENT_QUOTES))); //Escanpando caracteres
        $glob_tras    = mysqli_real_escape_string($conexion, (strip_tags($_POST["glob_tras"], ENT_QUOTES)));
        $fecha= mysqli_real_escape_string($conexion,(strip_tags($_POST["fecha"], ENT_QUOTES)));
        $hora= mysqli_real_escape_string($conexion,(strip_tags($_POST["hora"], ENT_QUOTES)));
        $medico= mysqli_real_escape_string($conexion,(strip_tags($_POST["medico"], ENT_QUOTES)));

        $merge = $fecha.' '.$hora;


$fecha_actual = date("Y-m-d H:i:s");

        $sql2 = "UPDATE alta SET id_usua='$medico',fecha_altamed='$merge',alta_por='$alta_por', fech_alta='$fech_alta', hor_alta ='$hor_alta', obs_med='$obs_med' WHERE id_alta= $id_alta";
        $result = $conexion->query($sql2);



        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> DATO EDITADO CORRECTAMENTE...</p>";
        echo '<script type="text/javascript">window.location ="../cartas_consentimientos/consent_medico.php"</script>';
      }
  ?>
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



</body>
</html>