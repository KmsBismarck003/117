<?php
session_start();
include "../../conexionbd.php";
include("../../gestion_medica/header_medico.php");
$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, dat_not_inquir.*
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp

inner join dat_not_inquir on dat_ingreso.id_atencion=dat_not_inquir.id_atencion
") or die($conexion->error);
$usuario = $_SESSION['login'];
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

    <title>Menu Gestión Médica </title>
    <link rel="shortcut icon" href="logp.png">
</head>
<div class="container">

</div>

<div>

    <!-- Right side column. Contains the navbar and content of the page -->

    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col col-12">

                     <button type="button" class="btn btn-danger btn-sm" onclick="history.back()">REGRESAR</button>
            
                 
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                        <center>
                            <p>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>CONSULTAR INTERVENCIÓN QUIRÚRGICA</strong></center><p>
</div> 
                    
                    </center>


                    <div class="text-center">
                    </div>
                    
                    <h2>
<a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"                                                             id="side"></i></a>
                    </h2>

                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search"
                               placeholder="Buscar...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead">
                            <tr>
                                <center>
                                    <th scope="col"> FECHA DE SOLICITUD</th>
                                </center>
                                <th scope="col">N° DE EXPEDIENTE</th>
                                <th scope="col">PRIMER APELLIDO</th>
                                <th scope="col">SEGUNDO APELLIDO</th>
                                <th scope="col">NOMBRE(S)</th>
                                <th scope="col">FECHA DE NACIMIENTO</th>
                                <th scope="col">EDAD</th>
                                <th scope="col">PDF</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            while ($f = mysqli_fetch_array($resultado)) {

                                ?>

                                <tr>
                                   <td><center><strong><?php $date = date_create($f['fecha']);
                                            echo date_format($date, "d/m/Y"); ?>
                                                <?php $date = date_create($f['hora_solicitud']);
                                            echo date_format($date, "H:i"); ?>
                                            </strong></center>
                                        </td>
                                    <td><center><strong><?php echo $f['Id_exp']; ?></strong></center></td>
                                    <td><strong><?php echo $f['papell']; ?></strong></td>
                                    <td><strong><?php echo $f['sapell']; ?></strong></td>
                                    <td><strong><?php echo $f['nom_pac']; ?></strong></td>
                                    <td><strong><?php $date = date_create($f[5]);
                                            echo date_format($date, "d/m/Y"); ?></strong></td>
                                    <td><strong>
                                            <center><?php echo $f['edad']; ?></center>
                                        </strong></td>
                                    <td><strong>
                                            <a type="submit" class="btn btn-danger btn-sm"
                                               href="pdf_intervencion_quirurgica.php?id=<?php echo $f['id_atencion']; ?>&id_med=<?php echo $usuario['id_usua'] ?>"
                                               target="_blank"><span class="fa fa-file-pdf-o"
                                                                     style="font-size:28px"></span></a>
                                        </strong></td>


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

    </section><!-- /.content -->


</div><!-- ./wrapper -->
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