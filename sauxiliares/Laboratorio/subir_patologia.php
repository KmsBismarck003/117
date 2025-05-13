<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 10) {
    include "../header_labo.php";

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_labo.php";
} else {
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


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
                        <h1>SUBIR RESULTADOS DE PATOLOGIA</h1>
                        <?php
                        $id = $_GET['id_notp'];

                        $sql = "SELECT * FROM notificaciones_pato where realizado = 'NO'";
                        $result = $conexion->query($sql);

                        ?>
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">


                            <div class="form-group">
                                <label for="exampleFormControlFile1">Seleccionar archivo PDF</label>
                                <input type="file" class="form-control-file" id="pdf_resultadopat"
                                       name="pdf_resultadopat">
                            </div>


                         

                    <br>
                    <hr>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-12">
                            <a href="../../template/menu_laboratorio.php" class="btn btn-danger">Cancelar</a>
                            <input type="submit" name="edit" class="btn btn-success" value="Guardar">
                        </div>
                    </div>

                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php

$fecha_actual = date("Y-m-d H:i:s");


        if (isset($_POST['edit'])) {
            //$terminado = mysqli_real_escape_string($conexion, (strip_tags($_POST["realizado"], ENT_QUOTES))); //Escanpando caracteres

//PDF
$name6 = $_FILES['pdf_resultadopat']['name'];
$carpeta6='./resultadospat/';
$temp6=explode('.' ,$name6);
$extension6= end($temp6);
$nombreFinal6=time().'.'.$extension6;

if($extension6=='jpg' || $extension6=='png' || $extension6=='dcm' || $extension6=='pdf' || $extension6=='jpeg' || $extension6=='PDF'){
 if(move_uploaded_file($_FILES['pdf_resultadopat']['tmp_name'], $carpeta6.$nombreFinal6)){

            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
         
               $sql2 = "UPDATE notificaciones_pato SET realizado = 'SI',resultado = '$nombreFinal6',fecha_resul = '$fecha_actual' ,id_usua_resul ='.$id_usua.' WHERE id_notp = $id";   
              
                $result = $conexion->query($sql2);
                echo '<script type="text/javascript">window.location ="../../template/menu_laboratorio.php"</script>';


            }
        }
        }
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