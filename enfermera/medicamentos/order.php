<?php
session_start();
include "../../conexionbd.php";
include("../header_enfermera.php");

$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];

?>

    <!DOCTYPE html>
    <html>

    <head>

        <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
              integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
              crossorigin="anonymous">
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
              integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
              crossorigin="anonymous">

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
                    <center>
                        <font id="letra"><i class="fa fa-plus-square"></i>Productos de Farmacia</font>
                </h2>
                </center>
                <hr>

            </div>
        </div>
    </div>


    <!-- Modal Insertar -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="exampleModalLabel">Agregar inventario</h5>
                </div>
                <div class="modal-body">
                    <!-- FORM -->
                    <form action="insertar_inventario.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="">Producto:</label>
                            <div class="col-sm-9">
                                <select class="btn btn-default" name="item-id" required>
                                    <?php
                                    $sql = "SELECT * from item ORDER BY item_name ASC";
                                    $result = $conexion->query($sql);
                                    while ($row_datos = $result->fetch_assoc()) {
                                        echo "<option value='" . $row_datos['item_id'] . "'>" . $row_datos['item_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="">Cantidad:</label>
                            <div class="col-sm-9">
                                <input type="number" min="1" class="form-control" name="qty"
                                       placeholder="Ingresa la cantidad" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="">Vence:</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="xDate" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="">Lote:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="manu" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-default">Guardar datos
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM -->
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->


    <div class="container box">
    <div class="content">


<?php

include "../../conexionbd.php";


// $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

//  $result = $conn->query($sql);

$resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);
?>


    <!--Fin de los filtros-->


    <div class="form-group">
        <input type="text" class="form-control pull-right" style="width:20%" id="search"
               placeholder="Buscar...">
    </div>

    <div class="table-responsive">
        <!--<table id="myTable" class="table table-striped table-hover">-->

        <table class="table table-bordered table-striped" id="mytable">

            <thead class="thead" style="background-color: #0c675e">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Fabricante</th>
                <th>Precio</th>
                <th>Paciente</th>
                <th>Cantidad</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
<?php
// $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
//  $result = $conn->query($sql);
$resultado2 = $conexion->query("SELECT * FROM item, stock, item_type where controlado = 'NO' AND item_type.item_type_id=item.item_type_id and item.item_id = stock.item_id and stock.stock_qty != 0") or die($conexion->error);
$no = 1;
while ($row = $resultado2->fetch_assoc()) {

    echo '<tr>'
        . '<td>' . $row['item_code'] . '</td>'
        . '<td>' . $row['item_name'] . '</td>'
        . '<td>' . $row['item_brand'] . '</td>'
        . '<td>$ ' . number_format($row['item_price'], 2) . '</td>'
        . '<td> <select class="btn btn-default" name="paciente" required> ';

    $sql = "SELECT * from paciente p, dat_ingreso di where p.Id_exp = di.Id_exp and di.activo='SI'";
    $result = $conexion->query($sql);
    while ($row_datos = $result->fetch_assoc()) {
        echo "<option value='" . $row_datos['id_atencion'] . "'>" . $row_datos['Id_exp'] . ' ' . $row_datos['nom_pac'] . ' ' . $row_datos['papell'] . ' ' . $row_datos['sapell'] . "</option>";
                  }

         echo  ' </select ></td > ';
                            echo '<td ><input type="number" min="1" step="1" class="form-control" name="qty" placeholder="Ingresa la cantidad" required=""></td > ';
                            echo '<td > <a href = "agregar_carrito.php?stock_id=' . $row['stock_id'] . '&stock_qty=' . $row['stock_qty'] . '&item_id=' . $row['item_id'] . '" class="btn btn-success btn-sm " ><span class="fa fa-shopping-cart" aria - hidden = "true" ></span ></a ></td > ';
                     
                        echo '</tr > ';
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
<script src=' ../../template / plugins / fastclick / fastclick . min . js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>

</html>