<?php
session_start();
include "../../conexionbd.php";


$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 7 || $usuario['id_rol'] == 1) {
    include "../header_farmacia.php";

} else if ($usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
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


  <section class="container-fluid">

           <?php
            if ($usuario1['id_rol'] == 4) {
                ?>
              <div class="container">
               <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger 
btn-sm"
                   href="../../template/menu_farmacia.php">Regresar</a>
                   </div>
               </div>
             </div>
                <?php
            } else if ($usuario1['id_rol'] == 7) {

                ?>
                <div class="container">
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_farmacia.php">Regresar</a>
                   </div>
               </div>
               </div> 

                <?php
            } else if ($usuario1['id_rol'] == 5) {

                ?>
                <div class="container">
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger 
btn-sm"
                   href="../../template/menu_farmacia.php">Regresar</a>
                   </div>
               </div> 
              </div>
                <?php
            }

            ?>
<br>

<div class="container">
  <div class="row">
    <div class="col-sm-6">
     <a href="pdf_inventario.php" class="btn btn-block btn-success 
btn-sm" 
     target="_blank">Imprimir reporte de existencias</a>
    </div>
    <div class="col-sm-6">
      <a href="pdf_general.php" class="btn btn-block btn-success 
btn-sm" 
      target="_blank">Imprimir reporte detallado</a>
    </div>
  </div>   
</div>

<section class="content container-fluid">

        <div class="content">
          <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
            <strong><center>EXISTENCIAS DE FARMACIA</center></strong>
          </div>
      <p>

  
        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
        </div>
        <br>


        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">

            <thead class="thead" style="background-color: #2b2d7f;color:white;">
              <tr>
                <th><font color="white">Código</th>
                <th><font color="white">Descripción</th>
                <th><font color="white">Presentación</th>
                <th><font color="white">Tipo</th>
                <th><font color="white">Inicial</th>
                <th><font color="white">Entradas</th>
                <th><font color="white">Salidas</th>
                <th><font color="white">Devoluciones</th>
                <th><font color="white">Existencias</th>
                <th><font color="white">Actualización</th>

              </tr>
            </thead>
            <tbody>
              <?php
              
               $resultado2 = $conexion->query("SELECT * FROM item, stock, item_type where item_type.item_type_id=item.item_type_id and item.item_id = stock.item_id order by item.item_id") or die($conexion->error);
              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                $eid = $row['item_id'];
                $actualiza=date_create($row['stock_added']); 
                echo '<tr>'
                  . '<td>' . $row['item_code'] . '</td>'
                  . '<td>' . $row['item_name'] . ', '. $row['item_grams'] . '</td>'
                  . '<td>' . $row['item_type_desc'] . '</td>'
                  . '<td>' . $row['grupo'] . '</td>'
                  . '<td>' . $row['stock_inicial'] . '</td>'
                  . '<td>' . $row['stock_entradas'] . '</td>'
                  . '<td>' . $row['stock_salidas'] . '</td>'
                  . '<td>' . $row['stock_devoluciones'] . '</td>'
                  . '<td>' . $row['stock_qty'] . '</td>'
                  . '<td>' . date_format($actualiza,"d/m/Y H:i"). '</td>'
                  .'</tr>';
                $no++;
            }
              ?>
            </tbody>
          </table>

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