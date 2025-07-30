<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua=$usuario['id_usua'];

if ($usuario['id_rol'] == 11) {
    include "../header_farmaciac.php";
} else if ($usuario['id_rol'] == 4) {
    include "../header_farmaciac.php";
} else if ($usuario['id_rol'] == 5) {
    include "../header_farmaciac.php";
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
    if ($usuario1['id_rol'] == 11) {
        ?>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
           <a type="submit" class="btn btn-danger" href="../../template/menu_farmaciacentral.php">Regresar</a> 
        </div>
    </div>
</div>
        <?php
    } else if ($usuario1['id_rol'] == 4) {
        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger" href="../../template/menu_farmaciacentral.php">Regresar</a>   
                </div>
            </div>
        </div>
        <?php
    }else if ($usuario1['id_rol'] == 5) {
        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger" href="../../template/menu_farmaciacentral.php">Regresar</a>   
                </div>
            </div>
        </div>
        <?php
    }else
    ?><p>
            <div class="thead" style="background-color:  #0c675e; color: white; font-size: 20px;">
                <tr><strong><center>EXISTENCIAS DE FARMACIA CENTRAL</center></strong>
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
                    <th><font color="white">Proveedor</th>
                    <th><font color="white">Máximo</th>
                    <th><font color="white">P.reorden</th>
                    <th><font color="white">Mínimo</th>
                    <th><font color="white">Existencias</th>
                    <th><font color="white">Generar OC</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  $resultado2 = $conexion->query("SELECT item_almacen.item_id, item_almacen.id_prov, item_almacen.item_code, item_almacen.item_name, item_almacen.item_grams, item_type.item_type_desc, SUM(existencias_almacen.existe_qty) as total_existencias, item_almacen.item_max, item_almacen.reorden, item_almacen.item_min
  FROM item_almacen
  JOIN existencias_almacen ON item_almacen.item_id = existencias_almacen.item_id
  JOIN item_type ON item_almacen.item_type_id = item_type.item_type_id
  GROUP BY item_almacen.item_id
  ORDER BY item_almacen.item_id 
") or die($conexion->error);
                $no = 1;
                while ($row = $resultado2->fetch_assoc()) {
                  $item_id = $row['item_id'];
                  $date=date_create($row['existe_fecha']); 

                  $existencias = $row['existe_qty'];
                  $maximo = $row['item_max'];
                  $minimo = $row['item_min'];
                  $reordena = $row['reorden'];

                  $total_existencias = $row['total_existencias'];
                  
                  if ($total_existencias >= $maximo) {
                  echo '<tr>'
                    . '<td>' . $row['item_code'] . '</td>'
                    . '<td>' . $row['item_name'].', '.$row['item_grams'] . ', ' . $row['item_type_desc'] . '</td>'
                    . '<td>' . $row['id_prov'] . '</td>'
                    . '<td>' . $maximo . '</td>'
                    . '<td>' . $reordena . '</td>'
                    . '<td>' . $minimo . '</td>'
                    . '<td bgcolor="green">' . $total_existencias . '</td>'
;
                  }
                  else if ($total_existencias <= $minimo) {
                  echo '<tr>'
                    . '<td>' . $row['item_code'] . '</td>'
                    . '<td>' . $row['item_name'].', '.$row['item_grams'] . ', ' . $row['item_type_desc'] . '</td>'
                    . '<td>' . $row['id_prov'] . '</td>'
                    . '<td>' . $maximo . '</td>'
                    . '<td>' . $reordena . '</td>'
                    . '<td>' . $minimo . '</td>'
                    . '<td bgcolor="red">' . $total_existencias . '</td>'
;
                  }
                  else if ($total_existencias <= $reordena) {
                  echo '<tr>'
                    . '<td>' . $row['item_code'] . '</td>'
                    . '<td>' . $row['item_name'].', '.$row['item_grams'] . ', ' . $row['item_type_desc'] . '</td>'
                     . '<td>' . $row['id_prov'] . '</td>'
                    . '<td>' . $maximo . '</td>'
                    . '<td>' . $reordena . '</td>'
                    . '<td>' . $minimo . '</td>'
                    . '<td bgcolor="yellow">' . $total_existencias . '</td>'
;
                  }
                  else  {
                  echo '<tr>'
                    . '<td>' . $row['item_code'] . '</td>'
                    . '<td>' . $row['item_name'].', '.$row['item_grams'] . ', ' . $row['item_type_desc'] . '</td>'
                     . '<td>' . $row['id_prov'] . '</td>'
                    . '<td>' . $maximo . '</td>'
                    . '<td>' . $reordena . '</td>'
                    . '<td>' . $minimo . '</td>'
                    . '<td bgcolor="yellow">' . $total_existencias . '</td>';
                  }
                    if ($total_existencias <= $reordena) {
                        echo ' <td><a type="submit" class="btn btn-warning btn-sm"
                        href="genera_oc.php?id=' . $item_id . '&id_usua=' . $id_usua . '" target="_blank"><span class="fa fa-check"></span></a></td>';

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