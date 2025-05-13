<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");
if (isset($_GET['id_atencion'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
    $resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp  WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);
    if (mysqli_num_rows($resultado) > 0) { //se mostrara si existe mas de 1
        $f = mysqli_fetch_row($resultado);

    } else {
        header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
    }
} else {
    header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
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

    <title>AVISO DE ALTA DE URGENCIAS </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
                
<h2><strong>AVISO DE ALTA DE URGENCIAS</strong></h2>
    <hr>
<?php

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);

?>
  <?php
                    while ($f1 = mysqli_fetch_array($resultado1)) {
                           

                        ?>
                   <!--   <div class="container">
  <div class="row">
    <div class="col-sm-5">
        NO.EXPEDIENTE: <td><strong><?php// echo $f1['Id_exp']; ?></strong></td><br><br>
    </div>
  </div>
</div>
<div class="container">      
                           
  <div class="row">
    <div class="col-sm-5">
       PACIENTE:
<td><strong><?php// echo $f1['papell']; ?></strong></td>
<td><strong><?php// echo $f1['sapell']; ?></strong></td>
<td><strong><?php// echo $f1['nom_pac']; ?></strong></td><br>
SEXO: <td><strong><?php// echo $f1['sexo']; ?></strong></td><br>
EDAD:<td><strong><?php// echo $f1['edad']; ?></strong></td><br>    
    </div>

    <div class="col-sm-4">
<?php $date = date_create($f1['fecha']);
                                     ?>
      FECHA Y HORA DE INGRESO: <strong><?php// echo date_format($date, "d/m/Y H:i:s"); ?></strong> 
    
    </div>-->


  </div>
</div>
             
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
<form action="insertar_alta_u.php?id_atencion=<?php echo $_GET['id_atencion'] ?>&id_usua=<?php echo $_GET['id_usua'] ?>" method="POST">

<div class="container">
    <div class="row">
     
     <div class="col-sm-4">
        <div class="form-group">
            <label>FECHA Y HORA DE INGRESO</label>
            <input type="datetime" value="<?php echo date_format($date, "d/m/Y H:i:s"); ?>" class="form-control" name="" onkeypress="" disabled>
        </div>
     </div>
     <div class="col-sm-4">
        <div class="form-group">
            <label>FECHA Y HORA DE EGRESO</label>
            <input type="datetime" value="<?= $fecha_actual ?>" class="form-control" name="" onkeypress="" disabled>
        </div>
     </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label>NOMBRE DEL PACIENTE</label>
            <input type="datetime" value="<?php echo $f1['papell']; ?> <?php echo $f1['sapell']; ?> <?php echo $f1['nom_pac']; ?>" class="form-control" name="" onkeypress="" disabled>
        </div>  
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label>NUMERO DE EXPEDIENTE</label>
            <input type="datetime" value="<?php echo $f1['Id_exp']; ?>" class="form-control" name="" onkeypress="" disabled>
        </div>  
        </div>
    </div>
        <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            <label>EDAD DEL PACIENTE</label>
            <input type="datetime" value="<?php echo $f1['edad']; ?>" class="form-control" name="" onkeypress="" disabled>
        </div>  
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label>GENERO</label>
            <input type="datetime" value="<?php echo $f1['sexo']; ?>" class="form-control" name="" onkeypress="" disabled>
        </div> <?php  
                    }
                    ?>  
        </div>
        
<?php
$resultado2 = $conexion->query("select num_cama from cat_camas WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);
if (mysqli_num_rows($resultado2) > 0) { //se mostrara si existe mas de 1
        $f2 = mysqli_fetch_row($resultado2);
         $cama=$f2[0];
    } 

?>
  <div class="col-sm-3">
<?php  
 if(isset($cama)){
    $cama=$f2[0];
  }else{
    $cama='Sin Cama';
  }
 ?>
        <div class="form-group">
            <label>CUARTO</label>
            <input type="datetime" value="<?php echo $cama ?>" class="form-control" name=""  disabled>


        </div>

    </div>
      
  <?php

$resultado3 = $conexion->query("select id_atencion,area from dat_ingreso
 WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);

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
<div class="row">
    <div class="col-sm-5">
        <div class="form-group">
           <center><label>ALTA POR :</label> </center>
           <div class="row">
              <div class="col">
                <label>MEJORIA.................................................................</label><input type="radio" name="alta_por_u" value="MEJORIA" ><br>
                <label>CURACIÓN...............................................................</label><input type="radio" name="alta_por_u" value="CURACION"><br>
                <label>VOLUNTARIA...........................................................</label><input type="radio" name="alta_por_u" value="VOLUNTARIA"><br>
                <label>DEFUNCIÓN.............................................................</label><input type="radio" name="alta_por_u" value="DEFUNCION"><br>
                <label>TRANSLADO A OTRA INSTITUCIÓN.......................</label><input type="radio" name="alta_por_u" value="TRANSLADO A OTRA INSTITUCION">
              </div>
            </div>    
        </div>
    </div>

    <div class="col-sm-5">
        <div class="form-group">
            <center><label>ORDEN DE SALIDA :</label> </center>
             <label>FECHA :<br></label><input type="date" value="" class="form-control" name="fech_alta_u"><br>
             <label>HORA :<br></label><input type="time" class="form-control" name="hor_alta_u"><br>
        </div>
    </div>
</div>
</div><hr>
    <div class="form-group col-6">
      <button type="submit" class="btn btn-primary">FIRMAR</button>
      <button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button>
    </div><br>
</form>
</div> <!--TERMINO DE div container-->
                  
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


<script>
    document.oncontextmenu = function () {
        return false;
    }
</script>



</body>
</html>}