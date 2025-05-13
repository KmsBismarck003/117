<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 9) {
    include "../header_imagen.php";

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_imagen.php";
} else {
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}
$id_usua = $_GET['id_usua'];

?>

<head>
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

    <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- FastClick -->
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</head>

<div>
    <section class="content container-fluid">
        <div class="container box">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <h1>Subir interpretación</h1>
                        <?php
                        $id = $_GET['not_id'];

                        $sql = "SELECT * FROM notificaciones_labo where realizado = 'NO'";
                        $result = $conexion->query($sql);

                        ?>
                       


 
<hr>
                           
<form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value=" <?php echo $id ?> ">
            <input type="hidden" name="id_usua" value=" <?php echo $id_usua;?> ">
                    <input type="file" name="inter" id="inter" class="form-control" required=""><br>
                    <input type="submit" class="btn btn-md btn-block btn-success" value="Guardar interpretación" name="edit">
                    
                </form>
<p>

                            <p>
                            <!--<div class="col-auto my-1">
                                <label class="mr-sm-2" for="realizado"><strong>ESTUDIOS:</strong></label>
                                <select class="custom-select mr-sm-2" id="realizado" name="realizado">
                                   
                                    <option value="SI" selected="">Realizado</option>

                                </select>
                            </div>--> 
                                        <p>
                        
                    <br>
                    <hr>

                  

                   
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php



if (isset($_POST['edit'])) {
$id = $_GET['not_id'];
//$terminado = mysqli_real_escape_string($conexion, (strip_tags($_POST["realizado"], ENT_QUOTES))); //Escanpando caracteres

//PDF
$name6 = $_FILES['inter']['name'];
$carpeta6='./resultados6/';
$temp6=explode('.' ,$name6);
$extension6= end($temp6);
$nombreFinal6=time().'.'.$extension6;

if($extension6=='jpg' || $extension6=='png' || $extension6=='dcm' || $extension6=='pdf' || $extension6=='jpeg' || $extension6=='PDF' ){

if(move_uploaded_file($_FILES['inter']['tmp_name'], $carpeta6.$nombreFinal6)){



$usuario = $_SESSION['login'];
  $id_usua= $usuario['id_usua'];
  $interpretacion= $_POST['interpretacion'];
date_default_timezone_set('America/Mexico_City');
$fecha_actual = date("Y-m-d H:i:s");
   $sql2 = "UPDATE notificaciones_imagen SET interpretado = 'Si',interpretacion = '$nombreFinal6' ,fecha_resul = '$fecha_actual' ,id_usua_resul ='.$id_usua.' WHERE not_id = $id";   

                $result = $conexion->query($sql2);
                echo '<script type="text/javascript">window.location ="../../template/menu_imagenologia.php"</script>';

                    } //move upload 6
                } // move upload 5
            } // move upload 4 
        
                  
             

        ?>
        



</div>
</section>
</div>
</div>


<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>

</body>

</html>