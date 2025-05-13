<?php
session_start();
//include "../../conexionbd.php";
include "../header_rojo1.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
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

    <!---
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
  -->
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
    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function () {
            $("#search_dep").keyup(function () {
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
        hr.new4 {
            border: 1px solid red;
        }
    </style>
</head>

<body>
    <div class="container">
         <?php
            if ($usuario1['id_rol'] == 4) {
                ?>
               <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="../../template/menu_rojo1.php">Regresar</a>
                   </div>
               </div>
                <?php
            } else if ($usuario1['id_rol'] == 8) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger" href="../../template/menu_rojo1.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            } else if ($usuario1['id_rol'] == 5) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="../../template/menu_rojo1.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            }

            ?>
            <br>
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>CONFIRMAR DE RECIBIDO</center></strong>
      </div>
    </div>
<section class="content container-fluid">
<hr>

 <!--CONSULTA DE MEDICAMENTOS PEDIDOS-->


    <div class="container">
           <div class="table-responsive">
            <!--<table id="myTable" class="table table-striped table-hover">-->

            <table class="table table-bordered table-striped" id="mytable">

              <thead class="thead" style="background-color: #2b2d7f;color:white;">
                <tr>
                  <th><font color="white">No.</th>
                  <th><font color="white">Descripción</th>
                  <th><font color="white">Presentación</th>
                  <th><font color="white">Solicitado</th>
                  <th><font color="white">Recibido</th>
                  <th><font color="white">Confirmar</th>
                </tr>
              </thead>
              <tbody>
                <?php
                 include "../../conn_almacen/Connection.php";
                $resultado2 = $conexion_almacen->query("SELECT * from cart_recib c, item_almacen i, item_type t where i.item_id = c.item_id and c.confirma='SI' and c.enviado='SI' and c.almacen='CARRO ROJO1' and t.item_type_id = i.item_type_id") or die($conexion_almacen->error);
 

                $no = 1;
                while ($row_lista = $resultado2->fetch_assoc()) {
                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . $row_lista['item_name'] . '</td>' 
                    . '<td>' . $row_lista['item_type_desc'] . '</td>'
                    . '<td>' . $row_lista['cart_qty'] . '</td>'
                    . '<td>' . $row_lista['envio_qty'] .'</td>'
                    . '<td><a type="submit" class="btn btn-success btn-sm" href="manipula_recibir.php?q=conf&cart_id='.$row_lista['id_recib'].'&qty='.$row_lista['envio_qty'].'"><span class = "fa fa-check"></span></a></td>';
                  echo '</tr>';
                  $no++;
                }
                ?>
              </tbody>
            </table>
         </div> 
  </div>
  <!--TERMINO CONSULTA DE MEDICAMENTOS PEDIDOS-->
 

</div>
</section>


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