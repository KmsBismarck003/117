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

<!DOCTYPE html>
<html>

<head>

    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


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


</head>

<body>

<div class="container-fluid">

    <?php
    if ($usuario1['id_rol'] == 4) {
        ?>

        <a type="submit" class="btn btn-primary" href="../../template/menu_sauxiliares.php">Regresar</a>

        <?php
    } else if ($usuario1['id_rol'] == 10) {

        ?>
        <a type="submit" class="btn btn-primary" href="../../template/menu_laboratorio.php">Regresar</a>

        <?php
    } else if ($usuario1['id_rol'] == 5) {

        ?>
        <a type="submit" class="btn btn-primary" href="../../template/menu_gerencia.php">Regresar</a>

        <?php
    }else

    ?>
    <div class="row">

        <div class="col  col-12">
            <h2>
                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                              id="side"></i></a>
                <center><font id="letra"><i class="fa fa-plus-square"></i> Editar Resultados de Patologia</font>
            </h2>
            </center>
            <hr>


        </div>
    </div>
</div>

<section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->


    <div class="container box">
        <div class="content">
            <div class="col-md-10">

                <?php
                include "../../conexionbd.php";

                $id = $_GET['id_notp'];
                //  echo $id;
                $file_doc = "SELECT * FROM `notificaciones_pato` WHERE id_notp = $id";
              // echo $file_doc;
                $result = $conexion->query($file_doc);
              $row = $result->fetch_assoc();
              //  $id_file = $row['resultado'];
                ?>
                 <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
<div class="container">
  <div class="row">
    <div class="col-sm">
   <iframe src="resultadospat/<?php echo $row['resultado'] ?>" width="450px" height="400px"></iframe>
    </div>
    <div class="col-sm">
      <label for="resultado"><strong><font size="2">SELECCIONAR UN ARCHIVO PDF</font></strong></label>
    <input type="file" class="form-control-file" id="resultado" name="resultado">
    </div>
 
  </div>
</div>
<center>
          <div class="form-group">
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-12">
                            <a href="../Laboratorio/resultados_pato.php" class="btn btn-danger">Cancelar</a>
                            <input type="submit" name="edit" class="btn btn-success" value="Guardar Datos">
                        </div>
                    </div>  
                    </center>   
</form>

            </div>


<?php
if (isset($_POST['edit'])) {
$id = $_GET['id_notp'];

     //imagen 6 PDF  EDITAR
        if($_FILES['resultado']['name']!=''){
    $nombr6= $_FILES['resultado']['name'];
    $carpeta6="./resultadospat/";
//imagen1.jpg
            $temp6=explode('.' ,$nombr6);
        $extension6= end($temp6);
        $img6=time().'.'.$extension6;

    if($extension6=='jpg' || $extension6=='png' || $extension6=='dcm' ||$extension6=='jpeg' || $extension6=='pdf'){

        if(move_uploaded_file($_FILES['resultado']['tmp_name'], $carpeta6.$img6)){
            $fila6=$conexion->query("select resultado from notificaciones_pato where id_notp = $id");
            $idd6=mysqli_fetch_row($fila6);
            if(file_exists('./resultadospat/'.$idd6[0])){
            unlink('./resultadospat/'.$idd6[0]);
                }
            $conexion->query("UPDATE notificaciones_pato SET resultado='$img6' where id_notp = $id");
                }
            }//llave tipo archivo
        }    //llave si no esta vacio


                echo '<script type="text/javascript">window.location ="../Laboratorio/resultados_pato.php"</script>';


} //edit

        ?>

        </div>
    </div>

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