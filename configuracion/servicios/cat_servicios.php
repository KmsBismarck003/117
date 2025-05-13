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
                <center><font id="letra"><i class="fa fa-plus-square"></i> CATÁLOGO DE SERVICIOS</font>
            </h2>
            </center>
            <hr>


            <div class="row">

                <div class="col-6">
                    <center>
                        <button type="button" class="btn btn-primary col-md-" data-toggle="modal"
                                data-target="#exampleModal"><i class="fa fa-plus"></i><font id="letra"> Nuevo servicio</font></button>
                </div>
                <div class="col-6">
                    <center>
                        <a href="excel.php"><button type="button" class="btn btn-warning"><img src="https://img.icons8.com/color/48/000000/ms-excel.png"/><strong>Exportar a Excel</strong></a>
                </div>
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
            <form action="insertar_servicio.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="clave">Clave:</label>
                    <input type="text" size="30" name="clave" id="clave" value="" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Nombre:</label>
                        <input type="text" name="descripcion" id="descripcion" 
                               class="form-control"  value="" required>
                    </div>
                    <div class="form-group">
                        <label for="costo">Precio:</label>
                        <input type="number" step="0.01" min="0" name="costo"  id="costo" 
                               class="form-control"value="" required>
                    </div>
                     
                    <div class="form-group">
                        <label for="med">Unidad de medida:</label>
                        <select name="med" class="form-control" required>
                            <option value="">Seleccionar</option>
                            <option value="CONSULTA">CONSULTA</option>
                            <option value="DIA">DIA</option>
                            <option value="EQUIPO">EQUIPO</option>
                            <option value="ESTUDIO">ESTUDIO</option>
                            <option value="HORA">HORA</option>
                            <option value="MATERIAL">MATERIAL</option>
                            <option value="SERVICIO">SERVICIO</option>
                            <option value="TOMOGRAFIA">TOMOGRAFIA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="">Tipo:</label>
                        <div class="col-sm-9">
                            <select id="item-type" class="btn btn-default" name="tipo">
                                <?php
                                $query = "SELECT * FROM `service_type`";
                                $result = $conexion->query($query);
                                //$result = mysql_query($query);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['ser_type_id'] . "'>" . $row['ser_type_desc'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
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


   <div class="table-responsive">
        <div class="content">


            <?php

            include "../../conexionbd.php";


            // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

            //  $result = $conn->query($sql);

            $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios  order by id_serv" ) or die($conexion->error);
            ?>


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
                        <th>Clave</th>
                        <th>Nombre</th>
                        <th>Precio </th>
                        <th>U.M.</th>
                        <th>Tipo</th>
                        <th>Activo</th>
                    <?php $usuario=$_SESSION['login'];
                    $rol=$usuario['id_rol'];
                    $id_usua=$usuario['id_usua'];

                    if ($rol==5 ) { ?>
                        <th>Edita</th>
                       <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
                    //  $result = $conn->query($sql);
                    $resultado2 = $conexion->query("SELECT id_serv, serv_cve,serv_desc, serv_costo, serv_costo2, serv_costo3,serv_costo4, serv_umed,serv_activo,t.ser_type_desc as tipo FROM cat_servicios s, service_type t where s.tipo = t.ser_type_id order by id_serv") or die($conexion->error);

                    $no = 1;
                    while ($row = $resultado2->fetch_assoc()) {
                    $eid = $row['id_serv'];
                   if ($rol==5) { 
                    echo '<tr>'
                        . '<td>' . $row['id_serv'] . '</td>'
                        . '<td>' . $row['serv_cve'] . '</td>'
                        . '<td>' . $row['serv_desc'] . '</td>'
                        . '<td>' . $row['serv_costo'] . '</td>'
                        . '<td>' . $row['serv_umed'] . '</td>
                        ' . '<td>' . $row['tipo'] . '</td>'

                    ?>
                    <form class="form-horizontal title1" name="form" action="insertar_servicio.php?q=estatus"
                          method="POST" enctype="multipart/form-data">
                        <?php
                        echo '<td>';
                        if ((strpos($row['serv_activo'], 'NO') !== false)) {
                            echo '<a type="submit" class="btn btn-danger btn-sm" href="insertar_servicio.php?q=estatus&eid=' . $eid . '&est=' . $row['serv_activo'] . '"><span class = "fa fa-power-off"></span></a>';

                        } else {
                            echo '<a type="submit" class="btn btn-success btn-sm" href="insertar_servicio.php?q=estatus&eid=' . $eid . '&est=' . $row['serv_activo'] . '"><span class = "fa fa-power-off"></span></a>';
                        }
                        echo '</td>'
                            . '<td> <a href="edit_servicios.php?id=' . $row['id_serv'] . '" title="Editar datos" class="btn btn-warning btn-sm "><span class="fa fa-edit" aria-hidden="true"></span></a></td>';

                        echo '</tr>';

                        $no++;
                   }else{
                    echo '<tr>'
                        . '<td>' . $row['id_serv'] . '</td>'
                        . '<td>' . $row['serv_cve'] . '</td>'
                        . '<td>' . $row['serv_desc'] . '</td>'
                        . '<td>' . $row['serv_costo'] . '</td>'
                        . '<td>' . $row['serv_umed'] . '</td>
                        ' . '<td>' . $row['tipo'] . '</td>'

                    ?>
                    <form class="form-horizontal title1" name="form" action="insertar_servicio.php?q=estatus"
                          method="POST" enctype="multipart/form-data">
                        <?php
                        echo '<td>';
                        if ((strpos($row['serv_activo'], 'NO') !== false)) {
                            echo '<a type="submit" class="btn btn-danger btn-sm" href="insertar_servicio.php?q=estatus&eid=' . $eid . '&est=' . $row['serv_activo'] . '"><span class = "fa fa-power-off"></span></a>';

                        } else {
                            echo '<a type="submit" class="btn btn-success btn-sm" href="insertar_servicio.php?q=estatus&eid=' . $eid . '&est=' . $row['serv_activo'] . '"><span class = "fa fa-power-off"></span></a>';
                        }

                        echo '</tr>';

                        $no++;
                   }
                    
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