<?php
session_start();
include "../../conexionbd.php";
include "../header_medico.php";

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
$usuario = $_SESSION['login'];


            ?>
            <center><button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button></center>
            <br>

            <center>
                <h1>INSUMOS QUIRÚRGICOS CEYE</h1>
            </center>

            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>

            <div class="table-responsive">
                <!--<table id="myTable" class="table table-striped table-hover">-->

                <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #0c675e; color:white;">
                    <tr>
                        <th>Paciente</th>
                <th>Solicitante</th>
                <th>Fecha</th>
                <th>Medicamento</th>
                <th>Precio</th>
                <th>Ctd.</th>
                <th>Total</th>
                <th>Confirmar / Rechazar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include "../../conexionbd.php";
                   $usuario = $_SESSION['login'];
                   $id_exp=$_GET['id_exp'];

      $sql_pac = "SELECT p.*, di.* FROM paciente p, dat_ingreso di WHERE p.Id_exp=$id_exp and di.Id_exp=$id_exp";

      $result_pac = $conexion->query($sql_pac);

      while ($row_pac = $result_pac->fetch_assoc()) {
        $id_exp = $row_pac['Id_exp'];
        $id_atencion = $row_pac['id_atencion'];
      }

                    $resultado2 = $conexion->query("SELECT * from paciente p, dat_ingreso di, cart_ceye c, material_ceye i 
                where di.Id_exp = c.paciente and p.Id_exp = di.Id_exp and i.material_id = c.material_id AND c.paciente=$id_exp
                ORDER BY c.cart_id ASC") or die($conexion->error);
              $no = 1;
              $total = 0;
              while ($row = $resultado2->fetch_assoc()) {
                $id_usua = $row['id_usua'];
                $sql4 = "SELECT id_usua, nombre, papell,sapell FROM reg_usuarios where id_usua = $id_usua ";
                $result4 = $conexion->query($sql4);
                while ($row_usua = $result4->fetch_assoc()) {
                  $solicitante = $row_usua['nombre'] . ' ' . $row_usua['papell'] . ' ' . $row_usua['sapell'];
                }

                $subtotal = $row['material_precio'] * $row['cart_qty'];
                $total += $subtotal;
                echo '<tr>'
                  . '<td>' .  $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell'] . '</td>'
                  . '<td>' . $solicitante . '</td>'
                  . '<td>' . $row['cart_fecha'] . '</td>'
                  . '<td>' . $row['material_nombre'] . '</td>'
                  . '<td> $' . number_format($row['material_precio'], 2) . '</td>'
                  
                  . '<td>' . $row['cart_qty'] . '</td>'
                  . '<td>$ ' . number_format($subtotal, 2) . '</td>'
                  . '<td> 
                  <a type="submit" class="btn btn-success btn-sm" href="manipula_carrito.php?q=comf_cart&paciente=' . $id_exp. '&id_atencion=' . $id_atencion. '&id_usua=' . $usuario['id_usua'] . '&id_cart=' . $row['cart_id'] . '"><span class = "fa fa-check"></span></a>
                  <a type="submit" class="btn btn-danger btn-sm" href="manipula_carrito.php?q=del_car&cart_stock_id=' . $row['cart_stock_id'] . '&cart_qty=' . $row['cart_qty'] . '&paciente=' . $id_exp . '&id_atencion=' . $id_atencion. '&cart_id=' . $row['cart_id'] . '"><span class = "fa fa-trash-alt"></span></a>
                  </td>';
                echo '</tr>';
                $no++;
              }

              $resultado3 = $conexion->query("SELECT * from paciente p, dat_ingreso di, cart_serv c, cat_servicios i 
                where di.Id_exp = c.paciente and p.Id_exp = di.Id_exp and i.id_serv = c.servicio_id AND c.paciente=$id_exp
                ORDER BY c.cart_id ASC") or die($conexion->error);
            
                while ($row_lista_serv = $resultado3->fetch_assoc()) {
                  $cart_id = $row_lista_serv['cart_id'];
                  $cart_qty = $row_lista_serv['cart_qty'];
                  $id_usua = $row_lista_serv['id_usua'];
                $sql4 = "SELECT id_usua, nombre, papell,sapell FROM reg_usuarios where id_usua = $id_usua ";
                $result4 = $conexion->query($sql4);
                while ($row_usua = $result4->fetch_assoc()) {
                  $solicitante = $row_usua['nombre'] . ' ' . $row_usua['papell'] . ' ' . $row_usua['sapell'];
                }
                $subtotal = $row_lista_serv['serv_costo'] * $row_lista_serv['cart_qty'];
                $total += $subtotal;
                  echo '<tr>'
                    . '<td>' .  $row_lista_serv['nom_pac'] . " " . $row_lista_serv['papell'] . " " . $row_lista_serv['sapell'] . '</td>'
                    . '<td>' . $solicitante . '</td>'
                    . '<td>' . $row_lista_serv['cart_fecha'] . '</td>'
                    . '<td>' . $row_lista_serv['serv_desc'] . '</td>'
                    . '<td> $' . number_format($row_lista_serv['serv_costo'], 2) . '</td>'
                    . '<td>' . $cart_qty . 'hrs.</td>'
                    . '<td>$ ' . number_format($subtotal, 2) . '</td>'
                    . '<td> 
                    <a type="submit" class="btn btn-success btn-sm" href="manipula_carrito.php?q=comf_cartserv&paciente=' . $id_exp. '&id_atencion=' . $id_atencion. '&id_usua=' . $usuario['id_usua'] . '&id_cart=' . $cart_id .'"><span class = "fa fa-check"></span></a>
                   <a type="submit" class="btn btn-danger btn-sm" href="manipula_carrito.php?q=eliminar_serv&paciente= ' . $id_exp . '&cart_id=' . $cart_id . '&cart_qty=' . $cart_qty . '"><span class = "fa fa-trash"></span></a></td>';
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