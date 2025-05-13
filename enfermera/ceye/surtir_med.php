<?php
session_start();
include "../../conexionbd.php";
$paciente1 = $_GET['id_atencion'];

$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 7) {
    include "../header_ceye.php";

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_ceye.php";
} else{
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>

<!DOCTYPE html>
<html>

<head>

  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!--  Bootstrap  -->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

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

<body>

<div class="container">
         <?php
            if ($usuario1['id_rol'] == 4) {
                ?>
               <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="order.php">Regresar</a>
                   </div>
               </div>
                <?php
            } else if ($usuario1['id_rol'] == 7) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger" href="order.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            } else if ($usuario1['id_rol'] == 5) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="order.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            }

            ?>
            <br>
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>SALIDAS DE MEDICAMENTOS PENDIENTES DE SURTIR</center></strong>
      </div>
    </div>
<section class="content container-fluid">

    <div class="container box">
        <div class="content">
            


        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">

            <thead class="thead" style="background-color: #2b2d7f; color:white;">
              <tr>
                <?php 
                $usuario=$_SESSION['login'];
              $rol=$usuario['id_rol'];
              if ($rol == 5 || $rol == 7 || $rol == 4) {
                 ?>
                <th><font color="white">Paciente</th>
                <th><font color="white">Solicitó</th>
                <th><font color="white">Fecha</th>
                <th><font color="white">Medicamento</th>
                <th><font color="white">Precio</th>
                <th><font color="white">Cantidad</th>
                <th><font color="white">Total</th>
                <th><font color="white">Acción</th>
                
              <?php }else{?>
                <th><font color="white">Paciente</th>
                <th><font color="white">Solicitó</th>
                <th><font color="white">Fecha</th>
                <th><font color="white">Medicamento</th>
                <th><font color="white">Cantidad</th>
                <th><font color="white">Acción</th>
                
              <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $paciente1 = $_GET['id_atencion'];
              $usuario=$_SESSION['login'];
              $rol=$usuario['id_rol'];
              $resultado2 = $conexion->query("SELECT * from paciente p, dat_ingreso di, cart_ceye c, material_ceye i where di.id_atencion = c.paciente and di.Id_exp = p.Id_exp and di.id_atencion = $paciente1 and i.material_id = c.material_id ORDER BY c.cart_fecha ASC") or die($conexion->error);
              $no = 1;
              $total = 0;
              while ($row = $resultado2->fetch_assoc()) {
                $feccarro = date_create($row['cart_fecha']);
                
                if ($rol == 5 || $rol == 7 || $rol == 4) {
                  $id_usua = $row['id_usua'];
                  
                $sql4 = "SELECT id_usua, papell FROM reg_usuarios where id_usua = $id_usua ";
                $result4 = $conexion->query($sql4);
                while ($row_usua = $result4->fetch_assoc()) {
                  $solicitante = $row_usua['papell'] ;
                }

                $subtotal = $row['cart_price'] * $row['cart_qty'];
                $total += $subtotal;
                echo '<tr>'
                  . '<td>' . $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell'] . '</td>'
                  . '<td>' . $solicitante . '</td>'
                  . '<td>' . date_format($feccarro,"d/m/Y H:i") . '</td>'
                  . '<td>' . $row['material_nombre'] .', '. $row['material_gramos'] . '</td>'
                  . '<td> $' . number_format($row['cart_price'], 2) . '</td>'
                  . '<td>' . $row['cart_qty'] . '</td>'
                  . '<td>$ ' . number_format($subtotal, 2) . '</td>'
                  . '<td>
                  <a type="submit" class="btn btn-success btn-sm" href="manipula_carrito.php?q=comf_cart&paciente=' . $paciente1 . '&id_usua=' . $usuario1['id_usua'] . '&id_cart=' . $row['cart_id'] . '"><span class = "fa fa-check"></span></a>
                  <a type="submit" class="btn btn-danger btn-sm" href="manipula_carrito.php?q=del_car&cart_stock_id=' . $row['cart_stock_id'] . '&cart_qty=' . $row['cart_qty'] . '&paciente=' . $paciente1 . '&cart_id=' . $row['cart_id'] . '"><span class = "fa fa-trash-alt"></span></a>
                  </td>';
                echo '</tr>';
                $no++;
                }else{
                  $id_usua = $row['id_usua'];
                $sql4 = "SELECT id_usua, papell FROM reg_usuarios where id_usua = $id_usua ";
                $result4 = $conexion->query($sql4);
                while ($row_usua = $result4->fetch_assoc()) {
                  $solicitante = $row_usua['papell'] ;
                }

                $subtotal = $row['cart_price'] * $row['cart_qty'];
                $total += $subtotal;
                echo '<tr>'
                  . '<td>' . $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell'] . '</td>'
                  . '<td>' . $solicitante . '</td>'
                   . '<td>' . date_format($feccarro,"d/m/Y H:i") . '</td>'
                  . '<td>' . $row['material_nombre'] . '</td>'
                  . '<td>' . $row['cart_qty'] . '</td>'
                  . '<td>
                  <a type="submit" class="btn btn-success btn-sm" href="manipula_carrito.php?q=comf_cart&paciente=' . $paciente1 . '&id_usua=' . $usuario1['id_usua'] . '&id_cart=' . $row['cart_id'] . '"><span class = "fa fa-check"></span></a>
                  </td>';
                echo '</tr>';
                $no++;
                }
                
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