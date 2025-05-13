<?php
session_start();
include "../../conexionbd.php";
include("../../gestion_medica/header_medico.php");

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
                        <center><p>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 24px;">
<font id="letra"><strong>RECETARIO MÉDICO</strong></font></div>
                 
                    </center>


                    <div class="text-center">
                    </div>
                
                    <h2>
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                                      id="side"></i></a>
                    </h2>


                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search"
                               placeholder="BUSCAR...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead">
                            <tr>
                                
                                <th scope="col">NO° DE RECETA</th>
                                <th scope="col">NOMBRE(S)</th>
                                <th scope="col">FECHA DE NACIMIENTO</th>
                                <th scope="col">EDAD</th>
                                <th scope="col">FECHA </th>
                                <th>TIPO</th>
                                <th scope="col">NUEVA CONSULTA</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                           $resultado = $conexion->query("select * from receta_ambulatoria order by id_rec_amb desc ") or die($conexion->error);
                            while ($f = mysqli_fetch_array($resultado)) {

                                ?>

                                <tr>
                                    <td><center><strong><?php echo $f['id_rec_amb']; ?></strong></center></td>
                                    <td><strong><?php echo $f['nombre_rec'].' '.$f['papell_rec'].' '.$f['sapell_rec'] ?></strong></td>
                                    <td><strong><?php $date = date_create($f['fecnac_rec']);
                                    echo date_format($date, "d/m/Y"); ?></strong></td>
                                    <td><strong><?php echo $f['edad']; ?></strong></td>
                                    <td><strong><?php $date = date_create($f['fecha']);
                                            echo date_format($date, "d/m/Y H:i"); ?></strong></td>
                                    <td>CONSULTA EXTERNA</td>
                                    <td><a href="nueva_receta.php?id=<?php echo $f['id_rec_amb']; ?>"><button type="button" class="btn btn-danger "><i class="fa fa-hand-o-up" aria-hidden="true"></i></button></a></td>
                                </tr>
                                <?php
                            }

                            ?>
                            <?php
                         $resultado = $conexion->query("SELECT p.*, d.* from paciente p, dat_ingreso d WHERE d.Id_exp=p.Id_exp and d.cama=0 order by d.id_atencion DESC") or die($conexion->error);

                        while ($f = mysqli_fetch_array($resultado)) {

                            ?>

                            <tr>     
                                <td><center><strong><?php echo $f['Id_exp']; ?></strong></center></td>
                                <td><strong><?php echo $f['papell'].' '.$f['sapell'].' '.$f['nom_pac']; ?></strong></td>
                                <td><strong><?php $date = date_create($f[5]);echo date_format($date, "d/m/Y"); ?></strong></td> 
                                <td><strong><?php echo $f['edad']; ?></strong></td>
                                <td><strong><?php $date = date_create($f['fec_egreso']);echo date_format($date, "d/m/Y"); ?></strong></td>
                                <td>HOSPITALIZACIÓN</td>
                                <td><a href="nueva_receta_hosp.php?id_atencion=<?php echo $f['id_atencion']; ?>"><button type="button" class="btn btn-danger "><i class="fa fa-hand-o-up" aria-hidden="true"></i></button></a></td>  
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