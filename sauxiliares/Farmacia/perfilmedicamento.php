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

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_farmacia.php";
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
            if ($usuario1['id_rol'] == 4) {
                ?>
               <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="../../template/menu_sauxiliares.php">Regresar</a>
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
                   href="../../template/menu_farmacia.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            }

            ?>
          <br>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>PRODUCTOS DE FARMACIA</center></strong>
      </div><br>
</div>
    <div class="row">
      <div class="col  col-12">
        
        <hr>
        <div class="row">

          <div class="col-sm-12">
            <center>
              <button type="button" class="btn btn-primary col-md-" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i>
                <font id="letra">AGREGAR INVENTARIO</font>
              </button>
            </center>


          </div>

        </div>
      </div>
    </div>


    <!-- Modal Insertar -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">AGREGAR A INVENTARIO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          
          </div>
          <div class="modal-body">
            <!-- FORM -->
            <form action="insertar_inventario.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label col-sm-3" for="">Producto:</label>
                <div class="col-sm-9">
                  <select  class="selectpicker" data-live-search="true" name="item-id" required>
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
                  <input type="number" min="1" class="form-control" name="qty" placeholder="Ingresa la cantidad" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="">Stock Mínimo:</label>
                <div class="col-sm-9">
                  <input type="number" min="0" class="form-control" name="stock_min" placeholder="Ingresa la cantidad" required="">
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
                  <button type="submit" class="btn btn-primary">GUARDAR
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
            <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
          </div>

          <div class="table-responsive">
            <!--<table id="myTable" class="table table-striped table-hover">-->

            <table class="table table-bordered table-striped" id="mytable">

              <thead class="thead" style="background-color: #2b2d7f">
                <tr>
                  <th><font color="white">Código</th>
                  <th><font color="white">Nombre</th>
                  <th><font color="white">Tipo</th>
                  <th><font color="white">Fecha de entrada</th>
                  <th><font color="white">Lote</th>
                  <th><font color="white">Precio</th>
                  <th><font color="white">Cantidad</th>
                  <th><font color="white">Fecha caducidad</th>
                  <th><font color="white">Entrada de productos</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
                //  $result = $conn->query($sql);
                $resultado2 = $conexion->query("SELECT * FROM item, stock, item_type where item_type.item_type_id=item.item_type_id and item.item_id = stock.item_id and stock.stock_qty != 0") or die($conexion->error);
                $no = 1;
                while ($row = $resultado2->fetch_assoc()) {

                  echo '<tr>'
                    . '<td>' . $row['item_code'] . '</td>'
                    . '<td>' . $row['item_name'] . '</td>'
                    . '<td>' . $row['item_type_desc'] . '</td>'
                    . '<td>' . $row['stock_manufactured'] . '</td>'
                    . '<td>' . $row['stock_purchased'] . '</td>'
                    . '<td>$' . number_format($row['item_price'], 2) . '</td>'
                    . '<td>' . $row['stock_qty'] . '</td>'
                    . '<td>' . $row['stock_expiry'] . '</td>'
                    . '<td> <a href="edit_stock.php?id=' . $row['stock_id'] . '" title="Editar datos" class="btn btn-warning btn-sm "><span class="fa fa-edit" aria-hidden="true"></span></a></td>';
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