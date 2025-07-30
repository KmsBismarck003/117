<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
  include "../header_farmaciac.php";
} else {
  echo "<script>window.Location='../../index.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      $("#search").keyup(function() {
        var _this = this;
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
  <div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <a class="btn btn-danger" href="../../template/menu_farmaciacentral.php">Regresar</a>
        </div>
      </div>
    </div>

    <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
      <center><strong>EXISTENCIAS DE FARMACIA CENTRAL</strong></center>
    </div>

    <div class="form-group">
      <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="mytable">
        <thead class="thead" style="background-color: #0c675e; color: white;">
          <tr>
            <th>Código</th>
            <th>Medicamento / Insumo</th>
            <th>Lote</th>
            <th>Caducidad</th>
            <th>Máximo</th>
            <th>P.reorden</th>
            <th>Mínimo</th>
            <th>Existencias Totales</th>
            <th>Ubicación</th>
            <th>Proveedor</th>
            <th>Generar OC</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $proveedor_anterior = null;

          $resultado2 = $conexion->query("SELECT 
                  item_almacen.item_id, 
                  item_almacen.item_code, 
                  item_almacen.item_name, 
                  item_almacen.item_grams, 
                  item_type.item_type_desc, 
                  SUM(existencias_almacen.existe_qty) AS total_existencias, 
                  item_almacen.item_max, 
                  item_almacen.reorden, 
                  item_almacen.item_min, 
                  existencias_almacen.existe_lote, 
                  existencias_almacen.existe_caducidad, 
                  ubicaciones_almacen.nombre_ubicacion, 
                  proveedores.nom_prov 
              FROM item_almacen
              JOIN existencias_almacen ON item_almacen.item_id = existencias_almacen.item_id
              JOIN item_type ON item_almacen.item_type_id = item_type.item_type_id
              JOIN ubicaciones_almacen ON existencias_almacen.ubicacion_id = ubicaciones_almacen.ubicacion_id
              JOIN proveedores ON item_almacen.id_prov = proveedores.id_prov
              GROUP BY item_almacen.item_id
              ORDER BY proveedores.nom_prov, item_almacen.item_id
          ") or die($conexion->error);


          while ($row = $resultado2->fetch_assoc()) {
            $item_id = $row['item_id'];
            $existencias = $row['total_existencias'];
            $maximo = $row['item_max'];
            $minimo = $row['item_min'];
            $reordena = $row['reorden'];
            $caduca = date_create($row['existe_caducidad']);
            $ubicacion = $row['nombre_ubicacion'];
            $proveedor = $row['nombre_proveedor'];

            // Encabezado por proveedor
            if ($proveedor !== $proveedor_anterior) {
              echo '<tr class="table-primary"><td colspan="10"><strong>Proveedor: ' . $proveedor . '</strong></td>'
                . '<td><a href="genera_oc_proveedor.php?proveedor=' . urlencode($proveedor) . '" class="btn btn-success btn-sm">Generar OC por Proveedor</a></td></tr>';
              $proveedor_anterior = $proveedor;
            }

            // Código para cada fila de producto
            echo '<tr>'
              . '<td>' . $row['item_code'] . '</td>'
              . '<td>' . $row['item_name'] . ', ' . $row['item_grams'] . ', ' . $row['item_type_desc'] . '</td>'
              . '<td>' . $row['existe_lote'] . '</td>'
              . '<td>' . date_format($caduca, "d/m/Y") . '</td>'
              . '<td>' . $maximo . '</td>'
              . '<td>' . $reordena . '</td>'
              . '<td>' . $minimo . '</td>';

            if ($existencias >= $maximo) {
              echo '<td bgcolor="green">' . $existencias . '</td>';
            } else if ($existencias <= $minimo) {
              echo '<td bgcolor="red">' . $existencias . '</td>';
            } else if ($existencias <= $reordena) {
              echo '<td bgcolor="yellow">' . $existencias . '</td>';
            }

            echo '<td>' . $ubicacion . '</td>'
              . '<td>' . $proveedor . '</td>';

            if ($existencias <= $reordena) {
              echo '<td><a class="btn btn-warning btn-sm" href="genera_oc.php?id=' . $item_id . '&id_usua=' . $id_usua . '" target="_blank"><span class="fa fa-check"></span></a></td>';
            } else {
              echo '<td></td>';
            }

            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer class="main-footer">
    <?php include("../../template/footer.php"); ?>
  </footer>

  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
</body>

</html>