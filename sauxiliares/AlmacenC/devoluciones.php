<?php
session_start();
include "../../conexionbd.php";
include '../../conn_almacen/Connection.php';

$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 11) {
    include "../header_almacenC.php";
} else if ($usuario['id_rol'] == 4) {
    include "../header_almacenC.php";
} else if ($usuario['id_rol'] == 5) {
    include "../header_almacenC.php";
} else{
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>
<!DOCTYPE html>
<div>

    <head>

        <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />


        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script>
            // Write on keyup event of keyword input element
            $(document).ready(function() {
                $("#search").keyup(function() {
                    _this = this;
                    // Show only matching TR, hide rest of them
                    $.each($("#mytable tbody tr"), function() {
                        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                            $(this).hide();
                        else
                            $(this).show();
                    });
                });
            });
        </script>


    </head>


    <div class="container-fluid">

        <?php
        if ($usuario1['id_rol'] == 11) {

            ?>
            <div class="container">
    <div class="row">
        <div class="col-sm-4">
            <a type="submit" class="btn btn-danger" href="../../template/menu_almacencentral.php">Regresar</a>
</div></div></div>
            <?php
        } else if ($usuario1['id_rol'] == 4) {

            ?>
            <div class="container">
    <div class="row">
        <div class="col-sm-4">
            <a type="submit" class="btn btn-danger" href="../../template/menu_almacencentral.php">Regresar</a>
</div></div></div>
            <?php
        }else if ($usuario1['id_rol'] == 5) {

            ?>
            <div class="container">
    <div class="row">
        <div class="col-sm-4">
            <a type="submit" class="btn btn-danger" href="../../template/menu_almacencentral.php">Regresar</a>
</div></div></div>
            <?php
        }else

        ?>
        <br>
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>DEVOLUCIONES DE ALMACEN CENTRAL</center></strong>
      </div><br>
        <div class="row">
            <div class="col  col-12">
                <hr>


                <div class="row">

                    <div class="col-sm-6">
                        <center>
                            <button type="button" class="btn btn-primary col-md-" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i>
                                <font id="letra">Agregar devolución</font>
                            </button>
                        </center>

                    </div>
                    <div class="col-md-3">
                        <a href="pdf_devoluciones.php" class="btn btn-md btn-md btn-block btn-success" target="_blank">Imprimir reporte</a>
                    </div>
                    <br>
                        <div class="col-sm-6">

                    </div>

                </div>
            </div>
        </div>


        <!-- Modal Insertar -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">AGREGAR DEVOLUCIÓN</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                        <!-- FORM -->
                        <form action="insertar_devolucion.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="">Descripción:</label>
                                <div class="col-sm-9">
                                    <select  class="selectpicker" data-live-search="true" name="item_id" required>
                                        <?php
                                        $sql = "SELECT * from item_almacen ORDER BY item_name ASC";
                                        $result = $conexion_almacen->query($sql);
                                        while ($row_datos = $result->fetch_assoc()) {
                                            echo "<option value='" . $row_datos['item_id'] . "'>" . $row_datos['item_name'] .', ' . $row_datos['item_grams'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="">Cantidad:</label>
                                <div class="col-sm-9">
                                    <input type="number" min="1" class="form-control" name="qty" placeholder="Ingresa la cantidad" required="">
                                </div>
                            </div>
                           
                            
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="">Almacén:</label>
                                <div class="col-sm-9">
                                <select class="selectpicker" name="alma" id="alma" required="">
                                    <option value="">Seleccionar</option>
                                    <option value="FARMACIA">FARMACIA</option>
                                    <option value="CEYE">QUIRÓFANO</option>
                                </select>   
                            </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-8" for="">Motivo de devolución:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="devol" id="exampleFormControlTextarea1" rows="3" required=""></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-sm-3" for="">Lote:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="lote" id="exampleFormControlTextarea1" rows="1" required=""></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="">Caducidad:</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="caduca" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-primary">Guardar datos
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM -->
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <section class="content container-fluid">

            <div class="container box">
                <div class="content">


                    <?php

                    include "../../conexionbd.php";
                    include '../../conn_almacen/Connection.php';


                    // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

                    //  $result = $conn->query($sql);

                    $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);
                    ?>


                    <!--Fin de los filtros-->


                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
                    </div>

                    <div class="table-responsive">
                        <!--<table id="myTable" class="table table-striped table-hover">-->

                        <table class="table table-bordered table-striped" id="mytable">

                            <thead class="thead" style="background-color: #2b2d7f">
                            <tr>
                                <th><font color="white">Código</th>
                                <th><font color="white">Descripción</th>
                                <th><font color="white">Presentación</th>
                                <th><font color="white">Fecha de registro</th>
                                <th><font color="white">Cantidad</th>
                                <th><font color="white">Almacén</th>
                                <th><font color="white">Lote</th>
                                <th><font color="white">Caducidad</th>
                                <th><font color="white">Motivo</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
                            //  $result = $conn->query($sql);
                            $resultado2 = $conexion_almacen->query("SELECT * FROM item_almacen, devolucion_almacen, item_type where item_type.item_type_id=item_almacen.item_type_id and item_almacen.item_id = devolucion_almacen.item_id and devolucion_almacen.stock_qty != 0 ORDER BY stock_added DESC") or die($conexion->error);
                            $no = 1;
                            while ($row = $resultado2->fetch_assoc()) {
                                $added=date_create($row['stock_added']);
                                $caduca=date_create($row['stock_expiry']);
                                echo '<tr>'
                                    . '<td>' . $row['item_code'] . '</td>'
                                    . '<td>' . $row['item_name'] .', ' . $row['item_grams'] . '</td>'
                                   
                                    . '<td>' . $row['item_type_desc'] . '</td>'
                                    . '<td>' . date_format($added,"d/m/Y H:i") . '</td>'
                                    . '<td>' . $row['stock_qty'] . '</td>'
                                    . '<td>' . $row['almacen'] . '</td>'
                                    . '<td>' . $row['stock_lote'] . '</td>'
                                    . '<td>' . date_format($caduca,"d/m/Y") . '</td>'
                                    . '<td>' . $row['motivo'] . '</td>';
                                echo '</tr>';
                                $no++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
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