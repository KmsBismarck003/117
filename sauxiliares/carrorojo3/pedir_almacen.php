<?php
session_start();
//include "../../conexionbd.php";
include "../header_rojo3.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
             <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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

    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>



   
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
                   href="../../template/menu_rojo3.php">Regresar</a>
                   </div>
               </div>
                <?php
            } else if ($usuario1['id_rol'] == 8) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger" href="../../template/menu_rojo3.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            } else if ($usuario1['id_rol'] == 5) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="../../template/menu_rojo3.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            }

            ?>
                <br>
          
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>SOLICITAR AL ALMACÉN</center></strong></tr>
      </div><br>
 </div> 
<section class="content container-fluid">
<hr>
<!--INICIO MEDICAMENTOS,ETC-->
   
<!-- inicio seccion de medicamentos -->
<div class="container">
  <form action="manipula_envio.php?a=agregar" method="POST" id="medicamentos">
      <div class="row">
        <div class="col-sm-4">
          <label>Materiales</label>
            <select name="item_id" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%">
                  <?php
             
                  $sql = "SELECT * FROM material_rojo3" ;
                  $result = $conexion->query($sql);
                  while ($row_datos = $result->fetch_assoc()) {
                    echo "<option value='" . $row_datos['material_id'] . "'>" . $row_datos['material_nombre'] .', '. $row_datos['material_contenido'] . "</option>";
                  }
                  ?>
                </select>
        </div>
        <div class="col-sm-4">
          <label>Cantidad:</label>
          <input type="number" name="qty" class="form-control">
        </div>
        <div class="col-sm-4">
          <br>
         <button type="submit" class="btn btn-success">Agregar</button>
        </div>
     </div>
    </form>
</div>

<!--TERMINO MEDICAMENTOS,ETC-->

 <!--CONSULTA DE MEDICAMENTOS PEDIDOS-->       
    <hr>
    <div class="container">
           <div class="table-responsive">
            <!--<table id="myTable" class="table table-striped table-hover">-->

            <table class="table table-bordered table-striped" id="mytable">

              <thead class="thead" style="background-color: #2b2d7f;color:white;">
                <tr>
                  <th><font color="white">No.</th>
                  <th><font color="white">Nombre del material</th>
                  <th><font color="white">Cantidad</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                 include "../../conn_almacen/Connection.php";
                $resultado2 = $conexion_almacen->query("SELECT * from cart_recib c, item_almacen i where i.item_id = c.item_id and c.confirma='NO' AND c.almacen='CARRO ROJO3'") or die($conexion_almacen->error);
                $no = 1;
                while ($row_lista = $resultado2->fetch_assoc()) {
                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . $row_lista['item_name'] . '</td>'
                    . '<td>' . $row_lista['cart_qty'] . '</td>'
                    . '<td> 
                    <a type="submit" class="btn btn-success btn-sm" href="manipula_envio.php?q=conf&cart_id=' . $row_lista['id_recib']  . '"><span class = "fa fa-check"></span></a>
                    <a type="submit" class="btn btn-danger btn-sm" href="manipula_envio.php?q=eliminar&cart_id=' . $row_lista['id_recib']  . '"><span class = "fa fa-trash"></span></a></td>';
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
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
<script>
    document.oncontextmenu = function () {
        return false;
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador2').select2();
    });
</script>


</body>

</html>