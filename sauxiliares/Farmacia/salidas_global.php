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
} else if ($usuario['id_rol'] == 3) {
    include "../../enfermera/header_enfermera.php";
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
                   href="../Farmacia/salidas.php">Regresar</a>
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
         <tr><strong><center>DETALLE DE SALIDAS DE MEDICAMENTOS</center></strong>
      </div>
    </div>
  <section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->



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
                <th><font color="white">Paciente</th>
                <th><font color="white">Fecha surtido</th>
                <th><font color="white">Item</th>
                <th><font color="white">Medicamento</th>
                <th><font color="white">Cantidad surtida</th>
                <th><font color="white">Precio</th>
                <th><font color="white">Costo</th>
              </tr>
            </thead>
            <tbody>
              <?php
              

              $resultado2 = $conexion->query("SELECT s.* from sales s") or die($conexion->error);
              while ($row = $resultado2->fetch_assoc()) {
                $id_atencion = $row['paciente'];
                $id_usua = $row['id_usua'];
                $date1=date_create($row['date_sold'] );
                $item_id = $row['item_id'];
                
                $sql1 ="SELECT * from dat_ingreso where id_atencion = $id_atencion";
                $result1 = $conexion->query($sql1);
                while ($row_di = $result1->fetch_assoc()) {
                    $Id_exp = $row_di['Id_exp'];
                }
                
                $sql3 = "SELECT * from paciente p where p.Id_exp=$Id_exp";
                $result3 = $conexion->query($sql3);
                while ($row_pac = $result3->fetch_assoc()) {
                    $paciente=$row_pac['papell'] . " " . $row_pac['sapell'] . " " .$row_pac['nom_pac'] ;
                }
                $sql2 = "SELECT * from item i where i.item_id=$item_id";
                $result2 = $conexion->query($sql2);
                while ($row_item = $result2->fetch_assoc()) {
                    $costo=$row_item['item_cost'];
                }
                
                echo '<tr>'
                  . '<td bgcolor="red"><font color="white">' . $paciente . '</td>'
                  . '<td bgcolor="green"><font color="white">' . date_format($date1,"d/m/Y h:i:s") . '</td>'
                  . '<td bgcolor="darkblue"><font color="white">' . $row['item_id'] .  '</td>'
                  . '<td bgcolor="darkblue"><font color="white">' . $row['generic_name'] .', '.$row['gram'] .  '</td>'
                  . '<td bgcolor="darkblue"><font color="white">' . $row['qty'] . '</td>'
                  . '<td bgcolor="darkblue"><font color="white">' . $row['price'] . '</td>'
                  . '<td bgcolor="darkblue"><font color="white">' . $costo . '</td>'
                 ;
                echo '</tr>';
         
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