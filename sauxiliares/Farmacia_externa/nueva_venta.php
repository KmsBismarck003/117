<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 7) {
    include "../header_farmacia_externa.php";

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_farmacia_externa.php";
} else {
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>

<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="imagenes/SIF.PNG">
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function () {
            $("#search").keyup(function () {
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function () {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
    </script>
    
    <style>
        td.fondo {
            background-color: red !important;
        }
    </style>

</head>

<body>
<div class="alert alert-danger" role="alert">
  FARMARCIA EXTERNA EN CONSTRUCCIÓN!!! 
</div>
            <?php/*
            if ($usuario1['id_rol'] == 4) {
                ?>
               <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger btn-sm"
                   href="../../template/menu_farmacia_ext.php">Regresar</a>
                   </div>
               </div>
                <?php
            } else if ($usuario1['id_rol'] == 7) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_farmacia_ext.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            } else if ($usuario1['id_rol'] == 5) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger btn-sm"
                   href="../../template/menu_farmacia_ext.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            }

            */?> 
<section class="content container-fluid">

    <div class="container box">
        <div class="content">


            <br>

<form action="" method="POST">
<div class="container">
  <div class="row">
      
    <?php 
    $resultadof = $conexion->query("SELECT * from registro_cf") or die($conexion->error);

                while($f3f = mysqli_fetch_array($resultadof)){

$id_cf=$f3f['id_cf'];
                }
                
  if($id_cf==null){
  
    ?>
<div class="col-sm-2">
    <strong>Venta No</strong>
    <input type="text" name="folio"class="form-control" value="1" disabled>
    </div>

<?php }
else if($id_cf>0){
$resultado34 = $conexion->query("SELECT * from registro_cf") or die($conexion->error);

                while($f34 = mysqli_fetch_array($resultado34)){
$id_cf=$f34['id_cf'];
$id_cf++;
                }
                 
            ?>
<div class="col-sm-2">
    <strong>Venta No</strong>
    <input type="text" name="folio"class="form-control" value="<?php echo $id_cf ?>" disabled>
    </div>

<?php
           }
               
    ?>
<!--div class="col-sm-5">
    <strong>Nombre completo cliente</strong>
    <input type="text" name="nombre_c"class="form-control" required>
    </div>-->
        </div>
        <br>
        <div class="container">
   <center>
       <div class="row">
         <div class="col-sm">
<input type="submit" name="guardreg" class="btn btn-primary btn-sm" value="Guardar cliente">
    </div>
     </div>
     </center>
     </div>
    </div>
    </form>
    
<?php 
if (isset($_POST['guardreg'])) {

$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$fecha_actual = date("Y-m-d H:i:s");

//$nombre_c= mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre_c"], ENT_QUOTES)));

$insertfac=mysqli_query($conexion,'INSERT INTO registro_cf(fecha,id_usua) values ("'.$fecha_actual.'",'.$id_usua.')') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));
   
$rescf = $conexion->query("SELECT * from registro_cf") or die($conexion->error);
while($row = mysqli_fetch_array($rescf)){
$id_cfr=$row['id_cf'];
                }


 
   echo '<script type="text/javascript">window.location.href ="det_ctafe.php?id_venta='.$id_cfr.'" ;</script>';
   
}
    ?>
    
</section>
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

</body>

</html>