<?php
session_start();
//include "../../conexionbd.php";
include "../../configuracion/header_configuracion.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="gb18030">
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


</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col  col-12">
            <h2>
                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                              id="side"></i></a>
                <center><font id="letra"><i class="fa fa-plus-square"></i> CATÁLOGO DE DIAGNÓSTICOS</font>
            </h2>
            </center>
            <hr>


            <div class="row">

                <div class="col-6">
                    <center>
                        <button type="button" class="btn btn-primary col-md-" data-toggle="modal"
                                data-target="#exampleModal"><i class="fa fa-plus"></i><font id="letra"> Nuevo diagnóstico</font></button>
                </div>
                <!--<div class="col-6">
                    <center>
                        <a href="excel.php"><button type="button" class="btn btn-warning"><img src="https://img.icons8.com/color/48/000000/ms-excel.png"/><strong>Exportar a Excel</strong></a>
                </div>-->
                </center>
            </div>

        </div>
    </div>
</div>

<!-- Modal Insertar -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="insertar_diag.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo diagnóstico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="descripcion">Diagnóstico:</label>
                        <input type="text" name="diag" id="descripcion" placeholder="Descripción" 
                               value="" required>
                    </div>
                      <div class="form-group">
                        <label for="descripcion">CIE_10:</label>
                        <input type="text" name="id_cie10" id="id_cie10" maxlength="20" placeholder="Clave CIE_10" 
                               value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                   
                   
                </div>
        </div>
        </form>

    </div>
</div>

<section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->


    <div class="container box">
        <div class="content">




            <!--Fin de los filtros-->


            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>

            <div class="table-responsive">
                <!--<table id="myTable" class="table table-striped table-hover">-->

                <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #2b2d7f;color:white;">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>CIE 10</th>
                        <th>Editar</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
                    //  $result = $conn->query($sql);
                    $resultado2 = $conexion->query("SELECT * FROM cat_diag ") or die($conexion->error);

                    $no = 1;
                    while ($row = $resultado2->fetch_assoc()) {
                    $eid = $row['id_diag'];

                    echo '<tr>'
                        . '<td>' . $no . '</td>'
                        . '<td>' . $row['diagnostico'] 
                        . '<td>' . $row['id_cie10'] . '</td>'
                    ?>
                    <form class="form-horizontal title1" name="form" action="insertar_diag.php?q=estatus"
                          method="POST" enctype="multipart/form-data">
                        <?php
                        echo '</td>'
                            . '<td> <a href="edit_diag.php?id=' . $row['id_diag'] . '" title="Editar datos" class="btn btn-warning btn-sm "><span class="fa fa-edit" aria-hidden="true"></span></a></td>';

                        echo '</tr>';

                        $no++;
                        }
                        ?>


                    </tbody>
                </table>

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