<?php
session_start();
include "../../conexionbd.php";




$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 7 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5 || $usuario['id_rol'] == 1 || $usuario['id_rol'] == 9) {
    include "../header_farmaciah.php";
} else {
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>

<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="css/select2.css">
<link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet"
      integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFMw5uZjQz4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/select2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldLv/Pr4nhuBviF5jGqQK/5i2Q5iZ64dxBl+zOZ" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
</script>
<script src="../../js/jquery-ui.js"></script>
<script src="../../js/jquery.magnific-popup.min.js"></script>
<script src="../../js/aos.js"></script>
<script src="../../js/main.js"></script>
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

    <div class="container box">
        <div class="content">


            <?php
            if ($usuario1['id_rol'] == 4 || $usuario1['id_rol'] == 7 || $usuario1['id_rol'] == 5 || $usuario1['id_rol'] == 1 || $usuario1['id_rol'] == 9) {

                ?>
                <div class="row">
                    <div class="col-sm-4">
                        <a type="submit" class="btn btn-danger"
                           href="../../template/menu_farmaciahosp.php">Regresar</a>
                    </div>
                </div>


                <?php
            }

            ?>
            <br>
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                <strong><center>PACIENTES CON MEDICAMENTOS PENDIENTES DE SURTIR</center></strong>
            </div><br>


            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>

            <div class="table-responsive">
                <!--<table id="myTable" class="table table-striped table-hover">-->

                <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #2b2d7f; color:white;">
                    <tr>
                        <th><font color="white">Cama</th>
                        <th><font color="white">Solicitud</th>
                        <th><font color="white">Paciente</th>
                        <th><font color="white">Fecha de<br>nacimiento</th>
                        <th><font color="white">Solicitante</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    include "../../conexionbd.php";

                    $query = "SELECT DISTINCTROW di.id_atencion, p.fecnac, p.nom_pac, p.papell, p.sapell, p.Id_exp, u.papell as papell_usua, ca.id_atencion, ca.num_cama, c.id_atencion
                    FROM cart_fh c, dat_ingreso di, paciente p, reg_usuarios u, cat_camas ca WHERE c.id_atencion = di.id_atencion and di.Id_exp = p.Id_exp AND 
                    u.id_usua = c.id_usua and ca.id_atencion=di.id_atencion ";
                    $result = $conexion->query($query);
                    //$result = mysql_query($query);
                    while ($row = $result->fetch_assoc()) {
                        $fecnac = date_create($row['fecnac']);
                        echo '<tr>'
                                . ' <td class="fondo" style="color:white;">' . $row['num_cama']  . '</td>'
                                . '<td class="fondo" style="color:white;"><a type="submit" class="btn btn-success btn-sm" 
                            href="surtir_med.php?id_atencion=' . $row['id_atencion'] . '"> Ver materiales </a></td>'
                                . '<td class="fondo" style="color:white;">' . $row['Id_exp'] . ' ' . $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell'] . '</td>'
                                . '<td class="fondo" style="color:white;">' . date_format($fecnac,"d-m-Y") . '</td>'
                                . ' <td class="fondo" style="color:white;">' . $row['papell_usua']  . '</td>';
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