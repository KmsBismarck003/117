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
    include "../header_farmacia.php";

} else if ($usuario['id_rol'] == 4 or $usuario['id_rol'] == 5) {
    include "../header_farmacia.php";
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

<section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->
    <div class="container box">
        <div class="content">


            <?php
            if ($usuario1['id_rol'] == 4) {
                ?>
               <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="../../template/menu_farmacia.php">Regresar</a>
                   </div>
               </div>
                <?php
            } else if ($usuario1['id_rol'] == 7) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger" href="../../template/menu_farmacia.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            } else if ($usuario1['id_rol'] == 5) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="../../template/menu_sauxiliares.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            }

            ?>
            <br>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
         <strong><center>PACIENTES PENDIENTES DE SURTIR</center></strong>
      </div><br>


            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>

            <div class="table-responsive">
                <!--<table id="myTable" class="table table-striped table-hover">-->

                <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #0c675e; color:white;">
                    <tr>
                        <th><font color="white">EXPEDIENTE</th>
                        <th><font color="white">PACIENTE</th>
                        <th><font color="white">FECHA Y HORA</th>
                        <th><font color="white">SOLICITANTE</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    include "../../conexionbd.php";

                    $query = "SELECT DISTINCTROW di.id_atencion, p.nom_pac, p.papell, p.sapell, p.Id_exp, u.nombre, u.papell as papell_usua, u.sapell as sapell_usua, c.cart_fecha FROM cart c, dat_ingreso di, paciente p, reg_usuarios u WHERE c.paciente = di.id_atencion and di.Id_exp = p.Id_exp AND u.id_usua = c.id_usua  ";
                    $result = $conexion->query($query);
                    //$result = mysql_query($query);
                    while ($row = $result->fetch_assoc()) {

                        echo '<tr>'
                            . '<td class="fondo" style="color:white;"><a type="submit" class="btn btn-danger btn-sm" href="surtir_med.php?id_atencion=' . $row['id_atencion'] . '">' . $row['Id_exp'] . '</a></td>'
                            . '<td class="fondo" style="color:white;">' . $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell'] . '</td>'
                            . '<td class="fondo" style="color:white;">' . $row['cart_fecha'] . '</td>'
                            . ' <td class="fondo" style="color:white;">' . $row['nombre'] . " " . $row['papell_usua'] . " " . $row['sapell_usua'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
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