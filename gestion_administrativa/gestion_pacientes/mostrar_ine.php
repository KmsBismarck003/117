<?php
session_start();
include "../../conexionbd.php";
include "../header_administrador.php";
if( isset($_GET['Id_exp'])) {
$resultado = $conexion->query("select * FROM ine where id_exp=".$_GET['Id_exp']) or die($conexion->error);
}
?>
<!DOCTYPE html>
<html>
<head>
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


    <title>Creación de Paciente</title>
    <link rel="shortcut icon" href="logp.png">


</head>
    <div class="container">
 <center>
                    <a href="../gestion_pacientes/buscar_ine.php" class="btn btn-danger">REGRESAR</a>
                   
                </center><hr>
        <div class="row">
                        <div class="col col-12">

                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                              id="side"></i></a>
                <center>
                    <h5>
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                                      id="side"></i></a>
                        <font id="letra"> INE de Paciente </font></h5>
                    <hr>
                </center>

                <br>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="mytable">
                        <thead class="thead" style="background-color: seagreen">
                    <tr>
                     
                        <th scope="col"> No. Exp</th>
                        <th scope="col">INE Paciente</th>
                        <th scope="col">INE Paciente</th>
                        <th scope="col">INE Responsable</th>
                        <th scope="col">INE Responsable </th>
                        <th scope="col">Fecha de Registro </th>
                        
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    while ($f = mysqli_fetch_array($resultado)) {

                        ?>

                        <tr>       
                            <td><strong><?php echo $f[1]; ?></strong></td>
                            <td><strong><img src="../../ine_frontal/<?php echo $f['img_inef']; ?>" class="img-circle " alt="User Image" width="450" height="250" ></strong></td>
                            <td><strong><img src="../../ine_trasera/<?php echo $f['img_inet']; ?>" class="img-circle" alt="User Image" width="450" height="250"></strong></td>
                            <td><strong><img src="../../ine_frontalr/<?php echo $f['img_inefr']; ?>" class="img-circle" alt="User Image" width="450" height="250"></strong></td>
                            <td><strong><img src="../../ine_traserar/<?php echo $f['img_inetr']; ?>" class="img-circle" alt="User Image" width="450" height="250"></strong></td>
                            <td><strong><?php $date = date_create($f['fecha']);
                                    echo date_format($date, "d/m/Y"); ?></strong></td>
                        


                            
                        </tr>
                        <?php
                    }

                    ?>
                    </tbody>
                </table>
                </div>

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
</body>
</html>
