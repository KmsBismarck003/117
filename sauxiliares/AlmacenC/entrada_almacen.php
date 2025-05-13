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


  <head>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
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
<style>
    
      @media screen and (min-width: 320px) and (max-width: 980px){
    .content{
        width:100%;
       margin-left:-0px;
       margin-top:-10px;
   }
      #exampleModal{
 width:100%;
 height: 100%;
font-size:10px;

      }
      
      .options{
padding:5px;
         font-size:10px;
            text-align:right;
       
      }
      
      .tablar{
          font-size:8px;
            width:120%;
       margin-left:-25px;
      }
      
      .buscado{
       margin-left:-450px;
      }
      
      #search{
    font-size:8px; 

      }
      }
</style>

  </head>


  <div class="container-fluid">

<?php
    if ($usuario1['id_rol'] == 11) {
        ?>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
           <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_almacencentral.php">Regresar</a> 
        </div>
    </div>
</div>

        <?php
    } else if ($usuario1['id_rol'] == 4) {

        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_almacencentral.php">Regresar</a>   
                </div>
            </div>
        </div>
        

        <?php
    }
    else if ($usuario1['id_rol'] == 5) {

        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_almacencentral.php">Regresar</a>   
                </div>
            </div>
        </div>
        

        <?php
    }else

    ?>
    <br>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>ENTRADAS DE ALMACEN CENTRAL</center></strong>
      </div>

      <br>
      
      <div class="container">
    <center>
    <div class="row">
        
        <div class="form-group"> 
            <a href="excelentradas.php"><button type="button" class="btn btn-warning btn-sm"><img 
                src="https://img.icons8.com/color/48/000000/ms-excel.png" width="42"/><strong>Exportar a excel</strong></button></a>
                
           <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i>
                <font id="letra">Registrar entradas</font>
              </button>
                   
          
        </div>
      
    </div>   
</div>


    <!-- Modal Insertar -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">REGISTRAR ENTRADAS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            
          </div>
          <div class="modal-body">
            <!-- FORM -->
            <form action="insertar_inventario.php" method="POST" enctype="multipart/form-data">
              
                      
              <div class="form-group selectd">
                <label class="control-label" for="">Seleccionar Producto:</label>
                <div class="col-sm-12">
                  <select class="selectpicker select" data-live-search="true" name="item-id" required>
                    <?php
                    $sql = "SELECT * from item_almacen WHERE activo = 'SI' ORDER BY item_name ASC";
                    $result = $conexion_almacen->query($sql);
                    while ($row_datos = $result->fetch_assoc()) {
                      echo "<option class='options' value='" . $row_datos['item_id'] . "'>" 
                       . $row_datos['item_name'] .', ' . $row_datos['item_grams'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-sm-6" for="">Lote:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="manu" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-6" for="">Fecha de caducidad:</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" name="xDate" required="">
                </div>
              </div>
               <div class="form-group">
                <label class="control-label col-sm-6" for="">Factura:</label>
                <div class="col-sm-9">
                  <input type="text" min="0" class="form-control" name="factura" placeholder="Ingresa la factura" required="">
                </div>
              </div>
               <div class="form-group">
                <label class="control-label col-sm-6" for="">Fecha de factura:</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" name="fec_compra" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-6" for="">Precio Unitario:</label>
                <div class="col-sm-9">
                  <input type="number" min="0.1" class="form-control" name="precio" step="any" class="form-control" id="precio"placeholder="Ingresa el precio" required="">                  
                </div>
              </div>
               <div class="form-group">
                <label class="control-label col-sm-6" for="">Cantidad:</label>
                <div class="col-sm-9">
                  <input type="number" min="1" class="form-control" name="qty" placeholder="Ingresa la cantidad" required="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-success">GUARDAR
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
          include '../../conn_almacen/Connection.php';


          $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);
          ?>


          <!--Fin de los filtros-->


          <div class="form-group buscado">
            <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
          </div>

          <div class="table-responsive tablar">
            <!--<table id="myTable" class="table table-striped table-hover">-->

            <table class="table table-bordered table-striped" id="mytable">

              <thead class="thead" style="background-color: #2b2d7f">
                <tr>
                  <th><font color="white">Fecha de entrada</th>
                  <th><font color="white">Código</th>
                  <th><font color="white">Descripción</th>
                  <th><font color="white">Presentación</th>
                  <th><font color="white">Lote</th>
                  <th><font color="white">Caducidad</th>
                  <th><font color="white">Factura</th>
                  <th><font color="white">Fecha factura</th>
                  <th><font color="white">Precio Unitario entrada</th>
                  <th><font color="white">Cantidad Unitaria</th>
                  <th><font color="white">Registró</th>
                </tr>
              </thead>
              <tbody>
                <?php
               
                $resultado2 = $conexion_almacen->query("SELECT * FROM item_almacen, entradas, item_type where item_type.item_type_id=item_almacen.item_type_id and item_almacen.item_id = entradas.item_id order by entrada_added desc") or die($conexion->error);
                $no = 1;
                while ($row = $resultado2->fetch_assoc()) {
                  $date=date_create($row['entrada_added']); 
                  $caduca=date_create($row['entrada_expiry']); 
                  $compra=date_create($row['entrada_purchased']); 
                  $id_usua=$row['id_usua'];
      $resultado_usua = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua=$id_usua") or die($conexion->error);
        while($row1 = mysqli_fetch_array($resultado_usua)){
                  echo '<tr>'
                    . '<td>' . date_format($date,"d-m-Y") . '</td>'
                    . '<td>' . $row['item_code'] . '</td>'
                    . '<td>' . $row['item_name'] .', '. $row['item_grams'] . '</td>'
                    . '<td>' . $row['item_type_desc'] . '</td>'
                    . '<td>' . $row['entrada_lote'] . '</td>'
                    . '<td>' . date_format($caduca,"d/m/Y"). '</td>'
                    . '<td>' . $row['entrada_factura'] . '</td>'
                    . '<td>' . date_format($compra,"d-m-Y") . '</td>'
                    . '<td>' .'$'. $row['entrada_price'] . '</td>'
                    . '<td>' . $row['entrada_qty'] . '</td>'
                    . '<td>' . $row1['papell'] . '</td>'
                   ;
                  $no++;
                }}
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