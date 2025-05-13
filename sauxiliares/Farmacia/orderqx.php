<?php
session_start();
include "../../conexionbd.php";
include "../header_farmacia.php";

date_default_timezone_set('America/Guatemala');
?>

<!DOCTYPE html>
<html>

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

<style>
     @media screen and (min-width: 320px) and (max-width: 980px){
   
h4{
    font-size:13px;
}
label{
    font-size:12px;
}
}
</style>

</head>

<body>


  <section class="content container-fluid">

    <div class="container box">
      <div class="content">


          <div class="row">
              <div class="col-sm-4"></div>
              
              <div class="col-sm-4"><a type="submit" class="btn btn-danger btn-block btn-sm"
                                       href="../../template/menu_farmacia.php">Regresar...</a>
              </div>
          </div>
          <br>
        <center>
          <h4>REGISTRO DE MEDICAMENTOS POR FARMACIA</h4>
        </center>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-sm-6 control-label">SELECCIONAR PACIENTE: </label>
           
                <!--  <select name="serv" class="selectpicker" data-live-search="true"> -->
                <select class="form-control col-sm-3"  data-live-search="true" name="paciente" required>
                    <option value="">SELECCIONAR</option>
                    <?php

                    $query = "SELECT * from paciente p, dat_ingreso di where p.Id_exp = di.Id_exp and di.activo='SI' ";
                    $result = $conexion->query($query);
                    
                    while ($row = $result->fetch_assoc()) {
                        $id_atencion = $row['id_atencion'];
                        $area= $row['area'];
                       
                        $cama = " ";
                        $queryc = "SELECT * from cat_camas c where c.id_atencion = $id_atencion";
                        $resultc = $conexion->query($queryc);
                        while ($rowc = $resultc->fetch_assoc()) {
                            $cama = $rowc['num_cama'];
                        }
                    echo "<option value='" . $row['id_atencion'] . "'> " . $cama . " " . $area . " - " . $row['papell'] . " " . $row['sapell'] . " " . $row['nom_pac'] ." </option>";
                    }
                    ?>
                </select>

            </div>
                 <input type="submit" name="btnpaciente" class="btn btn-block btn-success col-sm-2 btn-sm" value="SELECCIONAR">
                
        </form>
      </div>
    </div>
    <?php

    include "../../conexionbd.php";
    //    $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);

    if (isset($_POST['btnpaciente'])) {
      $paciente = mysqli_real_escape_string($conexion, (strip_tags($_POST["paciente"], ENT_QUOTES))); //Escanpando caracteres

      echo '<script type="text/javascript"> window.location.href="orderqx.php?paciente=' . $paciente . '";</script>';
    }

    if ((isset($_GET['paciente']))) {
      $paciente1 = $_GET['paciente'];
      $usuario = $_SESSION['login'];
      $usuario2 = $usuario['id_usua'];
      
      $sql_paciente = "SELECT p.nom_pac, p.papell, p.sapell, di.* FROM paciente p, dat_ingreso di WHERE p.Id_exp = di.Id_exp and di.id_atencion = $paciente1";

      $result_pac = $conexion->query($sql_paciente);
      while ($row_pac = $result_pac->fetch_assoc()) {
        $area =  $row_pac['area']; 
        if ($area == 'ALTA'){$area = 'CONSULTA';}
        if ($area == 'QUIROFANO'){$area = 'QUIRÓFANO';}
        $pac = $row_pac['papell'] . ' ' . $row_pac['sapell'] . ' ' . $row_pac['nom_pac'] ;
      }

        
    ?>
    
      <div class="container box">
        <div class="content">

          <center>
            <h3>PACIENTE: <?php echo $pac ?></h3>
          </center
          <br>

          <center>
            <h3>AGREGAR MEDICAMENTOS A: <?php echo $area ?></h3>
        
          </center>


          <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label class="control-label col-sm-3" for="">MEDICAMENTO:</label>
              <div class="col-md-12">
                <select class="selectpicker col-5" data-live-search="true" name="med" required>
<option value="">SELECCIONA UN MEDICAMENTO</option>
                  <?php
                  $sql = "SELECT * FROM item i, stock, item_type where controlado = 'NO' AND item_type.item_type_id=i.item_type_id and i.item_id = stock.item_id and stock.stock_qty != 0 ORDER BY i.item_name ASC";
                  $result = $conexion->query($sql);
                  while ($row_datos = $result->fetch_assoc()) {
                    echo "<option value='" . $row_datos['stock_id'] . "'>" . $row_datos['item_name'] .', '. $row_datos['item_grams'] . "</option>";
                  }
                  ?>
                  
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="">CANTIDAD SURTIDA:</label>
              <div class="col-sm-3">
                <input type="number" min="1" step="1" class="form-control" name="qty" placeholder="INGRESAR LA CANTIDAD" required="">
              </div>
            </div>
             
            <div class="col-sm-4">
              <input type="submit" name="btnserv" class="btn btn-block btn-success" value="AGREGAR">
            </div>
          </form>
          <br>
          <br>
          <br>

        </div>
      </div>
    <?php
    }


    if (isset($_POST['btnserv'])) {
      $stock_id = $_POST['med'];
      $sql = "SELECT * FROM item, stock, item_type where controlado = 'NO' AND item_type.item_type_id=item.item_type_id and item.item_id = stock.item_id and stock.stock_qty != 0 and stock_id = $stock_id";
      $result = $conexion->query($sql);
      while ($row_medicamentos = $result->fetch_assoc()) {
        $stock_qty = $row_medicamentos['stock_qty'];
        $stock_min = $row_medicamentos['stock_min'];
        $item_id = $row_medicamentos['item_id'];
        $medicam_mat = $row_medicamentos['item_name'].', '.$row_medicamentos['item_grams'];
         $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$paciente1";
            $result_aseg = $conexion->query($sql_aseg);
             while ($row_aseg = $result_aseg->fetch_assoc()) {
                $at=$row_aseg['aseg']; 
            }
            $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
            while($filat = mysqli_fetch_array($resultadot)){ 
                $tr=$filat["tip_precio"];
            }
            if ($tr==1) $precio = $row_medicamentos['item_price'];
            if ($tr==2) $precio = $row_medicamentos['item_price2'];
            if ($tr==3) $precio = $row_medicamentos['item_price3'];
      }
      $fecha_reg = date("Y-m-d H:i");
      $fecha = date("Y-m-d");
      $hora = date("H:i");
      $qty = mysqli_real_escape_string($conexion, (strip_tags($_POST["qty"], ENT_QUOTES))); //Escanpando
      $cart_qty=$qty;
      $cart_uniquid = uniqid();
      $stock = $stock_qty - $qty;
      if (!($stock < $stock_min)) {
          
           
          

        $sql2 = "INSERT INTO cart_almacen(item_id,cart_qty,cart_surtido,cart_stock_id,id_usua,cart_uniqid, paciente,enf_fecha,cart_hora,cart_fecha,medicam_mat,tipo,cart_price)VALUES
        ($item_id,$cart_qty,$qty, $stock_id,$usuario2,'$cart_uniquid', $paciente1,'$fecha','$hora','$fecha_reg','$medicam_mat','$area',$precio)";


        $result = $conexion->query($sql2);

        //$sql2 = "UPDATE stock set stock_qty=$stock where stock_id = $stock_id";
        //$result = $conexion->query($sql2);

        echo '<script>
              window.location.href = "orderqx.php?paciente=' . $paciente1 . '";
              </script>';
      } else {
        echo '<script>
              window.location.href = "orderqx.php?paciente=' . $paciente1 . '";
              </script>';
      }
    }

    if ((isset($_GET['paciente']))) {
    ?>


      <div class="container box">
        <div class="content">

          <center>
            <h3>VALE DE MEDICAMENTOS</h3>
          </center>

          <div class="form-group">
            <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
          </div>

          <div class="table-responsive">
            <!--<table id="myTable" class="table table-striped table-hover">-->

            <table class="table table-bordered table-striped" id="mytable">

              <thead class="thead" style="background-color: #2b2d7f;color:white;">
                <tr>
                  <th>Nombre</th>
                  <th>Cantidad Surtida</th>
                  <th>Cantidad Utilizada</th>
                  <?php 
                 $usuario=$_SESSION['login'];
                 $rol=$usuario['id_rol'];
                  if($rol== 5){ ?>
                  <th>SUB. TOTAL</th>
                  <th>TOTAL</th><?php } ?>
                  <th>SOLICITANTE</th>
                  <th>TIPO</th>
                  <th>PACIENTE</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $paciente1 = $_GET['paciente'];
                $resultado2 = $conexion->query("SELECT * from paciente p, dat_ingreso di, cart_almacen c, item i where di.id_atencion = c.paciente and di.Id_exp = p.Id_exp and di.id_atencion = $paciente1 and i.item_id = c.item_id") or die($conexion->error);
                $no = 1;
                $total = 0;
                while ($row = $resultado2->fetch_assoc()) {
                  $id_cart_almacen = $row['id'];
                  $area = $row['tipo'];
                  $id_usua = $row['id_usua'];
                  $sql4 = "SELECT id_usua, papell,sapell FROM reg_usuarios where id_usua = $id_usua ";
                  $result4 = $conexion->query($sql4);
                  while ($row_usua = $result4->fetch_assoc()) {
                    $solicitante = $row_usua['papell'] . ' ' . $row_usua['sapell'];
                  }

                  $subtotal = $row['item_price'] * $row['cart_surtido'];
                  $total += $subtotal;
                  if($rol== 5){
                  echo '<tr>'
                    . '<td>' . $row['item_name'] . '</td>'
                    . '<td>' . $row['cart_surtido'] . '</td>'
                    . '<td>' . $row['cart_qty'] . '</td>'
                    . '<td> $' . number_format($row['item_price'], 2) . '</td>'
                    . '<td>$ ' . number_format($subtotal, 2) . '</td>'
                    . '<td>' . $solicitante . '</td>'
                    . '<td>' . $area . '</td>'
                    . '<td>' . $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell'] . '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="manipulacarritoenf.php?q=del_car&paciente=' . $paciente1 . '&cart_id=' . $row['id'] . '"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $no++;
                }else{
                  echo '<tr>'
                    . '<td>' . $row['item_name'] . '</td>'
                    . '<td>' . $row['cart_surtido'] . '</td>'
                    . '<td>' . $solicitante . '</td>'
                    . '<td>' . $area . '</td>'
                    . '<td>' . $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell'] . '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="manipulacarritoenf.php?q=del_car&paciente=' . $paciente1 . '&cart_id=' . $row['id'] . '"><span class = "fa fa-trash"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $no++;
                }
                }
                ?>
              </tbody>
            </table>
            <?php 
            $usuario=$_SESSION['login'];
            $$rol=$usuario['id_rol'];
            if ($rol==5) {
             ?>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-3 control-label">Total: </label>
                <div class="col-md-6">
                  <center>
                    <input type="text" class="form-control pull-right" value="$ <?php echo number_format($total, 2) ?>" disabled>
                  </center>
                </div>
              </div>
            </div>
          <?php } ?>
            <div class="col-md-12">
              <br>
              <br>
              <center>
                <?php
                if ($area!='QUIROFANO' AND $area!='QUIRÓFANO') {
                    echo '<a type="submit" class="btn btn-success col-3 btn-block" href="manipula_carnew.php?paciente=' . $paciente1 . '"><span>CONFIRMAR INSUMOS</span></a>';
                }?>
              </center>
            </div>
          </div>
        </div>
      </div>
    <?php
    }
    ?>
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