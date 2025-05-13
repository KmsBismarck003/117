<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];

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
<?php
$resultado1 = $conexion->query("SELECT * FROM cart order by cart_id DESC" ) or die($conexion->error);
        while ($f1 = mysqli_fetch_array($resultado1)) {
         $cart_id=$f1['cart_id'];
          $confirmado=$f1['confirmado'];
        if($confirmado=='No' && $usuario['id_rol']==4 || $confirmado=='No' && $usuario['id_rol']==7)
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

<section class="content container-fluid">

        <div class="content">


            <?php

            include "../../conexionbd.php";

            ?>

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
            <center>
                <div class="row">
                <div class="col-md-3">
                    <a href="pdf_devoluciones.php" class="btn btn-md btn-md btn-block btn-success" target="_blank">IMPRIMIR REPORTE</a>
                </div>
                
                 <a href="exceldevoluciones.php">
                  <div class="col-sm">
              <button type="button" class="btn btn-success"><img src="https://img.icons8.com/color/48/000000/ms-excel.png" width="22"/><strong>Exportar a excel devoluciones</strong>
          </div>
          </a>
          
                <div class="col-md-5">
                    <a href="pdf_devoluciones_r.php" class="btn btn-md btn-md btn-block btn-warning" target="_blank">IMPRIMIR REPORTE DE RASTREO DE DEVOLUCIONES</a>
                </div>
                </div>
                <!--Fin de los filtros-->
                <br/>

                          <br>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
    <tr><strong><center>DEVOLUCIÓNES PENDIENTES</center></strong>
    </div><br>
            </center>
            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>

            <div class="table-responsive">
                <!--<table id="myTable" class="table table-striped table-hover">-->

                <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #2b2d7f;color:white;">
                    <tr>
                        <th><font color="white">Fecha</th>
                        <th><font color="white">Código</th>
                        <th><font color="white">Descripción</th>
                        <th><font color="white">Presentación</th>
                        <th><font color="white">Devolución Total</th>
                        <th><font color="white">Devolución Inventario</th>
                        <th><font color="white">Devolución Merma</th>
                        <th><font color="white">Paciente</th>
                        <th><font color="white">A inventario</th>
                        <th><font color="white">A merma</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php
                   
                    $resultado2 = $conexion->query("SELECT * FROM devolucion d, item i,item_type it WHERE i.item_id = d.dev_item and d.dev_estatus = 'SI' and it.item_type_id=i.item_type_id") or die($conexion->error);
                    $no = 1;
                    while ($row = $resultado2->fetch_assoc()) {
                        $id_dev = $row['dev_id'];
                        $item_code = $row['item_id'];
                        $item_id = $row['dev_item'];
                        $dev_qty = $row['dev_qty'];
                        $fecha = date_create($row['fecha']);
                        $fecha = date_format($fecha,'d/m/Y H:i');
                        $paciente =$row['paciente'];
                        echo '<tr>'
                            . '<td>' . $fecha . '</td>'
                            . '<td>' . $row['item_code'] . '</td>'
                            . '<td>' . $row['item_name'] .', ' . $row['item_grams'] . '</td>'
                            . '<td>' . $row['item_type_desc'] . '</td>'
                            . '<td><center>' . $row['dev_qty'] . '</center></td>'
                            . '<td><center>' . $row['cant_inv'] . '</center></td>'
                            . '<td><center>' . $row['cant_mer'] . '</center></td>'
                            . '<td>' . $row['paciente'] . '</td>'

                            . '<td> <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal'.$row['dev_id'].'">
                                <span class = "fa fa-check"></span>
                                </button></td>'
                            . '<td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalLong'.$row['dev_id'].'">
                                <span class = "fa fa-check"></span>
                                </button> </td>'
                             .' </td>
                             
                            <!-- Modal -->
<div class="modal fade" id="exampleModal'.$row['dev_id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar para inventario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="valida_dev.php" method="POST">
        <div class="modal-body">
            <input type="hidden" name="id_dev" value="'.$id_dev.'">
            <input type="hidden" name="item_id" value="'.$item_id.'">
            <input type="hidden" name="dev_qty" value="'.$dev_qty.'">
            <input type="hidden" name="paciente" value="'.$paciente.'">
            <input type="hidden" name="id_usua" value="'.$id_usua.'">
            <input type="hidden" id="tip" name="tip" value="inventario">
            <strong> Cantidad: <input type="number" class="form-control" name="cant_inv" required></strong>
            <strong> Motivo: <input type="text" class="form-control" name="motivoi" required></strong>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success btn-sm">Confirmar</button>
        </div>
      </form>
    </div>
  </div>
</div></td></form>'

.'
<td>
<form action="valida_dev.php" method="POST">
<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalLong">
  <span class = "fa fa-check"></span>
</button>
<div class="modal fade" id="exampleModalLong'.$row['dev_id  '].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmar para merma</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <input type="hidden" name="id_dev" value="'.$id_dev.'">
            <input type="hidden" name="item_id" value="'.$item_id.'">
            <input type="hidden" name="dev_qty" value="'.$dev_qty.'">
            <input type="hidden" name="paciente" value="'.$paciente.'">
            <input type="hidden" name="id_usua" value="'.$id_usua.'">
            <input type="hidden" id="tip" name="tip" value="merma">
            <strong> Cantidad: <input type="number" class="form-control" name="cant_mer" required></strong>
            <strong> Motivo <input type="text" class="form-control" name="motivom" required></strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary btn-sm">Confirmar</button>
      </div>
    </div>
  </div>
</div>
</td>
</form>
                           ';

                        ?>
                        <?PHP

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