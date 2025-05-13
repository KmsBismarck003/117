<?php
session_start();
include "../../conexionbd.php";


$usuario = $_SESSION['login'];
if ($usuario['id_rol'] == 7) {
    include "../header_farmacia.php";

} else if ($usuario['id_rol'] == 4) {
    include "../header_farmacia.php";
} else if ($usuario['id_rol'] == 5) {
    include "../header_farmacia.php";
} else{
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>

<!DOCTYPE html>
<html>
<head>
   <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="../../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="../../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
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

<?php
$cart_id=0;
$resultado1 = $conexion->query("SELECT * FROM cart order by cart_id DESC limit 1" ) or die($conexion->error);
        while ($f1 = mysqli_fetch_array($resultado1)) {
         $cart_id=$f1['cart_id'];
          
            if($cart_id<>0 && $usuario['id_rol']==4 || $cart_id<>0 && $usuario['id_rol']==7)
            {
            }?>
<audio >
    <source src="alerta.mp3" type="audio/mp3" autoplay>
</audio>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <script>
$(document).ready(function() {
 var myAudio= document.createElement('audio');
 var myMessageAlert = "";
 myAudio.src = './alerta.mp3';
 myAudio.addEventListener('ended', function(){
    alert(myMessageAlert);
 });
function Myalert(message) { 
    myAudio.play();
    myMessageAlert = message;
} 
Myalert("Mensaje");
function alert(message) { 
  myAudio.play();
  myMessageAlert = message;
} 
alert("Mensaje");

                        swal({
                            title: "SURTIR VALES DE FARMACIA", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                                window.location.href = "./order.php";
                            }
                        });
                    });
 function refrescar(tiempo){
    //Cuando pase el tiempo elegido la página se refrescará 
    setTimeout("location.reload(true);", tiempo);
  }
  //Podemos ejecutar la función de este modo
  //La página se actualizará dentro de 10 segundos
  refrescar(180000);
                </script>
                
                
<?php } ?>

</head>

<body>

<div class="container-fluid">

     <?php
            if ($usuario1['id_rol'] == 4) {
                ?>
               <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="../../template/menu_farmacia.php">Regresar</a>
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



<!-- Modal Insertar -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="exampleModalLabel">NUEVO PRODUCTO</h5>
            </div>
            <div class="modal-body">
                <form action="insertar_item.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="item-id">
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="">DESCRIPCIÓN:</label>
                        <div class="col-sm-9">
                            <input type="text" maxlength="50" name="nomitem" class="form-control" id="item-name" placeholder="Ingresa el nombre generico" required="" autofocus="">
                        </div>
                    </div>
                      <div class="form-group">
                        <label class="control-label col-sm-6" for="">CONTENIDO:</label>
                        <div class="col-sm-9">
                            <input type="text" min="0" name="contenido" maxlength="50" class="form-control" id="grams" placeholder="Ingresa la cantidad" required="" autofocus="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="">PRECIO:</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.1" name="precio" step="any" class="form-control" id="item-price" placeholder="Ingresa el precio" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="">CÓDIGO:</label>
                        <div class="col-sm-9">
                            <input type="text" maxlength="50" name="codigo" class="form-control" id="code" placeholder="Ingresa el código" required="" autofocus="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="">FABRICANTE:</label>
                        <div class="col-sm-9">
                            <input type="text" maxlength="50" name="fabricante" class="form-control" id="brand" placeholder="Ingresa el fabricante" required="" autofocus="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="">TIPO:</label>
                        <div class="col-sm-9">
                            <select id="item-type" class="btn btn-default" name="tipo">
                                <?php
                                $query = "SELECT * FROM `item_type`";
                                $result = $conexion->query($query);
                                //$result = mysql_query($query);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['item_type_id'] . "'>" . $row['item_type_desc'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="">CONTROLADO.?:</label>
                        <div class="col-sm-9">
                            <select name="controlado" id="controlado">
                                <option value="SI">Si</option>
                                <option value="NO">No</option>

                            </select>
                        </div>
                    </div>
                    <center>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" class="btn btn-primary">GUARDAR</button>
                        </div>
                    </center>


                </form>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<?php 
$usuario = $_SESSION['login'];
if ($usuario['id_rol'] == 4 || $usuario['id_rol'] == 5 ) {
 ?>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <a href="excelmed.php"><button type="button" class="btn btn-warning"><img src="https://img.icons8.com/color/48/000000/ms-excel.png"/><strong>EXPORTAR A EXCEL</strong></button></a>
        </div>
    </div>
</div>
<?php } ?>
<section class="content container-fluid">


    <div class="container box">
        <div class="content">


            <?php

            include "../../conexionbd.php";


            // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

            //  $result = $conn->query($sql);

          //  $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);
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
                        <th><font color="white">#</th>
                        <th><font color="white">Descripción</th>
                        <th><font color="white">Costo</th>
                        <th><font color="white">Precio Venta 1</th>
                        <th><font color="white">Precio Venta 2</th>
                        <th><font color="white">Precio Venta 3</th>
                        <th><font color="white">Presentación</th>
                        <th><font color="white">Tipo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
                    //  $result = $conn->query($sql);
                    $resultado2 = $conexion->query("SELECT * FROM item i, item_type it where i.item_type_id=it.item_type_id") or die($conexion->error);
                    $no = 1;
                    $usuario = $_SESSION['login'];
                        
                    while ($row = $resultado2->fetch_assoc()) {
                        $eid = $row['item_id'];
                        echo '<tr>'
                            . '<td>' . $row['item_id'] . '</td>'
                            . '<td>' . $row['item_name'] .', '. $row['item_grams'] . '</td>'
                            . '<td>' . '$'. number_format($row['item_cost'],2) . '</td>'
                            . '<td>' . '$'. number_format($row['item_price'],2) . '</td>'
                            . '<td>' . '$'. number_format($row['item_price2'],2) . '</td>'
                            . '<td>' . '$'. number_format($row['item_price3'],2) . '</td>'
                            . '<td>' . $row['item_type_desc'] . '</td>'
                            . '<td>' . $row['tip_insumo'] . '</td>'
                           
                         /*   .'<td><a href="edit_producto.php?id=' . $row['item_id'] . '" title="Editar datos" class="btn btn-warning btn-sm "><span class="fa fa-edit" aria-hidden="true"></span></a></td>'*/
                            .'</tr>';
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