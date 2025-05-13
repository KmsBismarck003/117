<?php
session_start();
include "../../conexionbd.php";
include "../header_almacenC.php";
include '../../conn_almacen/Connection.php';

$usuario = $_SESSION['login'];

$id_usua1=$usuario['id_usua'];
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


<section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->

    <?php

    include "../../conexionbd.php";
    //    $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);

    ?>

    <div class="container box">
        <div class="content">
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4"></div>
                <div class="col-sm-4"><a type="submit" class="btn btn-primary btn-block"
                                         href="../../template/menu_almacencentral.php">REGRESAR</a>
                </div>
            </div>
            <center>
                <h3>ORDEN DE SALIDA DE MEDICAMENTOS</h3>
            </center>
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="">MEDICAMENTO:</label>
                    <div class="col-md-9">
                        <select class="selectpicker" data-live-search="true" name="med" required>
                            <?php
                            $sql = "SELECT * FROM item_almacen, stock_almacen, item_type where controlado = 'NO' AND item_type.item_type_id=item_almacen.item_type_id and item_almacen.item_id = stock_almacen.item_id and stock_almacen.stock_qty != 0";
                            $result = $conexion_almacen->query($sql);
                            while ($row_datos = $result->fetch_assoc()) {
                                echo "<option value='" . $row_datos['stock_id'] . "'>" . $row_datos['item_code'] . ' ' . $row_datos['item_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="">CANTIDAD:</label>
                    <div class="col-sm-3">
                        <input type="number" min="1" step="1" class="form-control" name="qty"
                               placeholder="Ingresa la cantidad" required="">
                    </div>
                </div>
                <div class="row">
                    <?php
                    if (isset($_SESSION['destino'])) {
                        ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="">CLÍNICA DESTINO?:</label>
                            <div class="col-sm-9">
                                <input disabled type="text" value="<?php echo $_SESSION['destino'] ?>" class="form-control" name="destino">
                            </div>
                        </div>
                    </div>
                        <?php
                    } else {
                        ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="">Clínica Destino?:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="destino" id="destino">
                                        <option value="TOLUCA">TOLUCA</option>
                                        <option value="METEPEC">METEPEC</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>


                    <?php
                    if (isset($_SESSION['destino'])) {
                        ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="">ALMACEN?:</label>
                                <div class="col-sm-9">
                                    <input disabled type="text" value="<?php echo $_SESSION['almacen'] ?>" class="form-control" name="almacen">
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="">ALMACEN?:</label>
                                <div class="col-sm-9">
                                    <select name="almacen" class="form-control" id="almacen">
                                        <option value="FARMACIA">FARMACIA</option>
                                        <option value="CEYE">CEyE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>



                </div>


                <div class="col-sm-4">
                    <input type="submit" name="btnserv" class="btn btn-block btn-success" value="Agregar">
                </div>
            </form>
            <br>
            <br>
            <br>

        </div>
    </div>
    <?php


    if (isset($_POST['btnserv'])) {
        $stock_id = $_POST['med'];
        $sql = "SELECT * FROM item_almacen, stock_almacen, item_type where controlado = 'NO' AND item_type.item_type_id=item_almacen.item_type_id and item_almacen.item_id = stock_almacen.item_id and stock_almacen.stock_qty != 0 and stock_id = $stock_id";
        $result = $conexion_almacen->query($sql);
        while ($row_medicamentos = $result->fetch_assoc()) {
            $stock_qty = $row_medicamentos['stock_qty'];
            $stock_min = $row_medicamentos['stock_min'];
            $item_id = $row_medicamentos['item_id'];

        }

        if(isset($_SESSION['almacen'])&&isset($_SESSION['destino'])){
            $destino = $_SESSION['destino'];
            $almacen = $_SESSION['almacen'];
        }else{
            $destino = $_POST['destino'];
            $almacen = $_POST['almacen'];
        }


        $qty = mysqli_real_escape_string($conexion_almacen, (strip_tags($_POST["qty"], ENT_QUOTES))); //Escanpando
        $cart_uniquid = uniqid();
        $stock = $stock_qty - $qty;
        if (!($stock < $stock_min)) {

            $sql2 = "INSERT INTO cart_almacen(item_id,cart_qty,cart_stock_id,destino,cart_uniqid,almacen)VALUES($item_id,$qty, $stock_id,'$destino','$cart_uniquid', '$almacen')";
//echo $sql2;


            $result = $conexion_almacen->query($sql2);

            $sql2 = "UPDATE stock_almacen set stock_qty=$stock where stock_id = $stock_id";
            $result = $conexion_almacen->query($sql2);

            $_SESSION['destino'] = $destino;
            $_SESSION['almacen'] = $almacen;

            echo '<script>
             window.location.href = "order.php";
             </script>';
        } else {
            echo '<script>
              window.location.href = "order.php";
              </script>';
        }
    }


    ?>


    <div class="container box">
        <div class="content">

            <center>
                <h3>ORDEN DE SALIDA DE MEDICAMENTOS</h3>
            </center>

            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>

                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-hover">

            <table class="table table-bordered table-striped" id="mytable">

                <thead class="thead" style="background-color: #0c675e">
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Destino</th>
                    <th>Almacen</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php

                $resultado2 = $conexion_almacen->query("SELECT * from cart_almacen c, item_almacen i where i.item_id = c.item_id") or die($conexion->error);
                $no = 1;
                $total = 0;
                while ($row = $resultado2->fetch_assoc()) {
                    $id_cart_almacen = $row['cart_id'];

                    echo '<tr>'
                        . '<td>' . $row['item_name'] . '</td>'
                        . '<td>' . $row['cart_qty'] . '</td>'
                        . '<td>' . $row['destino'] . '</td>'
                        . '<td>' . $row['almacen']. '</td>'
                        . '<td> <a type="submit" class="btn btn-danger btn-sm" href="manipula_carrito.php?q=del_car&cart_stock_id=' . $row['cart_stock_id'] . '&cart_qty=' . $row['cart_qty'] . '&cart_id=' . $row['cart_id'] . '"><span class = "fa fa-trash"></span></a></td>';
                    echo '</tr>';
                    $no++;
                }
                ?>
                </tbody>
            </table>
            <div class="col-md-12">
                <br>
                <br>
                <center>
                    <?php
                    echo '<a type="submit" class="btn btn-success btn-block" href="manipula_carrito.php?q=comf_cart&id_usua=' . $id_usua1 . '"><span>Confirmar</span></a>';
                    ?>
                </center>
            </div>
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