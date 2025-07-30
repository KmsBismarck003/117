<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua=$usuario['id_usua'];

if ($usuario['id_rol'] == 11) {
    include "../header_farmaciah.php";
} else if ($usuario['id_rol'] == 4) {
    include "../header_farmaciah.php";
} else if ($usuario['id_rol'] == 5) {
    include "../header_farmaciah.php";
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

<div class="container">
    <div class="row">
        <div class="col-sm-4">
           <a type="submit" class="btn btn-danger" href="existenciash.php">Regresar</a> 
        </div>
    </div>
</div>
       <p>
            <div class="thead" style="background-color:  #0c675e; color: white; font-size: 20px;">
                <tr><strong><center>EXISTENCIAS GLOBALES DE FARMACIA HOSPITALARIA</center></strong>
            </div>
            <p>
          <!--Fin de los filtros-->
          <div class="form-group">
            <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
          </div>
         <div class="table-responsive">
          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #0c675e; color: white;">
              <tr>
                    <th><font color="white">Código</th>
                    <th><font color="white">Medicamento / Insumo</th>
                    <th><font color="white">Grupo</th>
                    <th><font color="white">Máximo</th>
                    <th><font color="white">P.reorden</th>
                    <th><font color="white">Mínimo</th>
                    <th><font color="white">Existencias</th>

                </tr>
            </thead>
            <tbody>
                <?php
                  $resultado2 = $conexion->query("SELECT *, SUM(existe_qty) as cuantos FROM existencias_almacenh GROUP BY item_id") or die($conexion->error);
                $no = 1;
                while ($row = $resultado2->fetch_assoc()) {
                    $item_id = $row['item_id'];
                    $existencias = $row['cuantos'];
                    
                    $resultado3 = $conexion->query("SELECT * FROM item_almacen WHERE item_id = $item_id") or die($conexion->error);
                    while ($row3 = $resultado3->fetch_assoc()) { 
                     
                     
                
                  $date=date_create($row['existe_fecha']); 
                  
                  $grupo = $row3['grupo'];
                  $maximo = $row3['item_max'];
                  $minimo = $row3['item_min'];
                  $reordena = $row3['reorden'];

                  if ($existencias >= $maximo) {
                  echo '<tr>'
                    . '<td>' . $row3['item_code'] . '</td>'
                    . '<td>' . $row3['item_name'].', '.$row3['item_grams'] . '</td>'
                    . '<td>' . $grupo . '</td>'
                    . '<td>' . $maximo . '</td>'
                    . '<td>' . $reordena . '</td>'
                    . '<td>' . $minimo . '</td>'
                    . '<td bgcolor="green">' . $existencias . '</td>';
                  }
                  else if ($existencias <= $minimo) {
                  echo '<tr>'
                    . '<td>' . $row3['item_code'] . '</td>'
                    . '<td>' . $row3['item_name'].', '.$row3['item_grams'] . '</td>'
                    . '<td>' . $grupo . '</td>'
                    . '<td>' . $grupo . '</td>'
                    . '<td>' . $maximo . '</td>'
                    . '<td>' . $reordena . '</td>'
                    . '<td>' . $minimo . '</td>'
                    . '<td bgcolor="red">' . $existencias . '</td>';
                  }
                  else if ($existencias <= $reordena) {
                  echo '<tr>'
                    . '<td>' . $row3['item_code'] . '</td>'
                    . '<td>' . $row3['item_name'].', '.$row3['item_grams'] . '</td>'
                    . '<td>' . $grupo . '</td>'
                    . '<td>' . $maximo . '</td>'
                    . '<td>' . $reordena . '</td>'
                    . '<td>' . $minimo . '</td>'
                    . '<td bgcolor="yellow">' . $existencias . '</td>';
                  }
                  else  {
                  echo '<tr>'
                    . '<td>' . $row3['item_code'] . '</td>'
                    . '<td>' . $row3['item_name'].', '.$row3['item_grams'] . '</td>'
                    . '<td>' . $grupo . '</td>'
                    . '<td>' . $maximo . '</td>'
                    . '<td>' . $reordena . '</td>'
                    . '<td>' . $minimo . '</td>'
                    . '<td bgcolor="yellow">' . $existencias . '</td>';
                  }
                   
                    }    
                }
                ?>
              </tbody>
            </table>
          </div>
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