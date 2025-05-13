<?php
session_start();
include "../../conexionbd.php";
include "../header_ceye.php";
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


</head>

<body>


  <section class="content container-fluid">
    <div class="container box">
      
          <div class="row">
              
              <div class="col-sm-2"><a type="submit" class="btn btn-danger btn-block"
                                       href="../../template/menu_ceye.php">REGRESAR</a>
              </div>
          </div>
          <br>
        <center>
          <h4>REGISTRAR MATERIALES ENTREGADOS A QUIRÓFANO</h4>
        </center>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <label class="col-sm-1 control-label">PACIENTE: </label>
           
                <!--  <select name="serv" class="selectpicker" data-live-search="true"> -->
                <select  class="form-control col-4"  data-live-search="true" name="paciente" required>
                    <option value="">SELECCIONAR</option>
                    <?php

                    $query = "SELECT * from paciente p, dat_ingreso di, cat_camas ca where p.Id_exp = di.Id_exp and di.activo='SI' and ca.id_atencion = di.id_atencion";
                    $result = $conexion->query($query);

                    while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_atencion'] . "'> " . $row['num_cama'] . " - " . $row['papell'] . " " . $row['sapell'] . " " . $row['nom_pac'] ." </option>";
                    }
                    ?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
                 <input type="submit" name="btnpaciente" class="btn btn-block btn-success col-2" value="CONFIRMAR">
                 
            </div>
            <br>
        </form>
      
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
      $sql_paciente = "SELECT p.nom_pac, p.papell, p.sapell FROM paciente p, dat_ingreso di WHERE p.Id_exp = di.Id_exp and di.id_atencion = $paciente1";

      $result_pac = $conexion->query($sql_paciente);
      while ($row_pac = $result_pac->fetch_assoc()) {
        $pac = $row_pac['papell'] . ' ' . $row_pac['sapell'] . ' ' . $row_pac['nom_pac'] ;
      }

    ?>

      <div class="container box">
        <div class="content">

          <center>
            <h3>PACIENTE: <?php echo $pac ?></h3>
          </center
          <br>

<div class="container">
 <div class="row">
  <div class="col">
     <strong>Cargar paquetes?</strong>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI &nbsp;<input type="radio" value="SI" name="pipat" class="pago">&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;NO &nbsp;<input type="radio" value="NO" name="pipat" checked="" class="pago">&nbsp;&nbsp;&nbsp;&nbsp;
  </div>
 </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
        $(".pago").click(function(evento){
          
            var valor = $(this).val();
          
            if(valor == 'SI'){
                $("#div1").css("display", "block");
                $("#div2").css("display", "none");
            }else{
                $("#div1").css("display", "none");
                $("#div2").css("display", "block");
            }
    });
});

</script>

<!-- PAQUETES / PAQUETES / PAQUETES / PAQUETES / PAQUETES / PAQUETES / PAQUETES / PAQUETES / PAQUETES / PAQUETES -->
<div class="collapse" id="div1" style="display:none;">
    <div class="card card-body">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
        <strong><center>AGREGAR PAQUETES</center></strong>
        </div><p></p>
        
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label class="control-label col-sm-3" for="">PAQUETE:</label>
              <div class="col-md-12">
                <select class="selectpicker col-5" data-live-search="true" name="paque" required>
<option value="">SELECCIONA UN PAQUETE</option>
                  <?php
                  $sql = "SELECT DISTINCT(nombre) FROM paquetes_ceye GROUP BY nombre ";
                  $result = $conexion->query($sql);
                  while ($row_datos = $result->fetch_assoc()) {
                    echo "<option value='" . $row_datos['nombre'] . "'>" . $row_datos['nombre'] . "</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <!--
            <div class="form-group">
              <label class="control-label col-sm-3" for="">CANTIDAD SURTIDA:</label>
              <div class="col-sm-3">
                <input type="number" min="1" step="1" class="form-control" name="qty" placeholder="INGRESAR LA CANTIDAD" required="">
              </div>
            </div> -->
            <div class="col-sm-4">
              <input type="submit" name="btnpaque" class="btn btn-block btn-success" value="AGREGAR">
            </div>
          </form>
          <br>
          <br>
          <br>

        </div>
      </div>
    

<div class="collapse" id="div2" style="display:block;">
    <div class="card card-body">
    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
        <strong><center>AGREGAR MATERIALES</center></strong>
    </div><br>
        
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="row">
              <label class="control-label col-md-1.5" for="">Material:</label>
              <div class="col-md-4">
                <select class="selectpicker " data-live-search="true" name="med" required>
                  <option value="">Seleccionar material</option>
                  <?php
                  $sql = "SELECT * FROM material_ceye i, stock_ceye s where i.material_controlado = 'NO' and i.material_id = s.item_id and s.stock_qty > 0 ORDER BY i.material_nombre ASC";
                  $result = $conexion->query($sql);
                  while ($row_datos = $result->fetch_assoc()) {
                    echo "<option value='" . $row_datos['material_id'] . "'>" . $row_datos['material_nombre'] .' Existencias: '. $row_datos['stock_qty'] .
                    "</option>";
                  }
                  ?>
                  
                </select>
              </div>
              <label class="control-label col-sm-1.5" for="">Cantidad:</label>
              <div class="col-md-3">
                <input type="number" min="1" step="1" class="form-control" name="qty" placeholder="Cantidad surtida" required="">
              </div>
              <div class="col-sm-1.5">
                <input type="submit" name="btnserv" class="btn btn-block btn-success" value="Agregar">
              </div>
            </div>
          </form>
          
         

        </div>
      </div>
      </div>
       </div>
    <?php
    }

 if (isset($_POST['btnpaque'])) {
     $nomp = $_POST['paque'];
     
      $i=0;
      $material_id = null;
      $cantidad = null;
      $medicam_mat=null;
      
      $sqlp = "SELECT pc.nombre, pc.material_id, pc.cantidad, mc.material_nombre, mc.material_precio, mc.material_precio2, mc.material_precio3 
      FROM paquetes_ceye pc, material_ceye mc WHERE mc.material_id = pc.material_id and pc.nombre LIKE '%$nomp%' ORDER BY nombre ASC";
      $result = $conexion->query($sqlp);
      while ($row_mat = $result->fetch_assoc()) {
     
      $material_id[] = $row_mat['material_id'];
      $cantidad[] = $row_mat['cantidad'];
      $medicam_mat[]=$row_mat['material_nombre'];
      
      $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$paciente1";
      $result_aseg = $conexion->query($sql_aseg);
       while ($row_aseg = $result_aseg->fetch_assoc()) {
            $at=$row_aseg['aseg']; 
      }
      $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
      while($filat = mysqli_fetch_array($resultadot)){ 
           $tr=$filat["tip_precio"];
      }
       if ($tr==1) $precio[] = $row_mat['material_precio'];
       if ($tr==2) $precio[] = $row_mat['material_precio2'];
       if ($tr==3) $precio[] = $row_mat['material_precio3'];
     
      
      $i++;
      }
      
    
for ($ii = 0; $ii < count($material_id); $ii++) {
    $cart_uniquid = uniqid();
    $material_id1 = $material_id[$ii];
    $cantidad1 = $cantidad[$ii];
    $cantidad2 = $cantidad[$ii];
    $medicam_mat1 = $medicam_mat[$ii];
    $precio1 = $precio[$ii];
    echo $material_id1 .' '. $cantidad1. ' '.$medicam_mat1. ' '. $precio1."<br />";
    $sql2p = "INSERT INTO cart_mat
       (material_id,cart_surtido,cart_qty,cart_price,id_usua,cart_uniqid,paciente,medicam_mat)VALUES
       ('$material_id1',$cantidad1,$cantidad2,$precio1,$usuario2,'$cart_uniquid',$paciente1,'$medicam_mat1')";
     $result = $conexion->query($sql2p);       

}
    
       
     
      echo '<script> 
              window.location.href = "orderqx.php?paciente=' . $paciente1 . '";
             </script>';

}

    if (isset($_POST['btnserv'])) {
      $item_id = $_POST['med'];
      $sql = "SELECT * FROM material_ceye mc, stock_ceye sc where mc.material_controlado = 'NO' and mc.material_id = sc.item_id and sc.stock_qty != 0 and mc.material_id = $item_id";
      $result = $conexion->query($sql);
      while ($row_mat = $result->fetch_assoc()) {
        $stock_id = $row_mat['stock_id'];
        $stock_qty = $row_mat['stock_qty'];
        $material_id = $row_mat['material_id'];
        $medicam_mat = $row_mat['material_nombre'].', '.$row_mat['material_contenido'];
        
        $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$paciente1";
        $result_aseg = $conexion->query($sql_aseg);
        while ($row_aseg = $result_aseg->fetch_assoc()) {
            $at=$row_aseg['aseg']; 
        }
        $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
        while($filat = mysqli_fetch_array($resultadot)){ 
            $tr=$filat["tip_precio"];
        }
        if ($tr==1) $precio = $row_mat['material_precio'];
        if ($tr==2) $precio = $row_mat['material_precio2'];
        if ($tr==3) $precio = $row_mat['material_precio3'];
      }
      
      $fecha_reg = date("Y-m-d H:i");
      $fecha = date("Y-m-d");
      $hora = date("H:i");
      $qty = mysqli_real_escape_string($conexion, (strip_tags($_POST["qty"], ENT_QUOTES))); //Escanpando
      $qty2 = $qty;
      $cart_uniquid = uniqid();
      $stock_ceye = $stock_qty - $qty;
      if ($stock_ceye >= 0) {

        $sql2 = "INSERT INTO cart_mat(
        material_id,cart_surtido,cart_qty,cart_price,cart_stock_id,id_usua,cart_uniqid,paciente,cart_fecha,medicam_mat)VALUES
        ($material_id,$qty,$qty2,$precio,$stock_id,$usuario2,'$cart_uniquid',$paciente1,'$fecha','$medicam_mat')";

        $result = $conexion->query($sql2);

       // $sql2 = "UPDATE stock_ceye set stock_ceye_qty=$stock_ceye where stock_ceye_id = $stock_ceye_id";
       // $result = $conexion->query($sql2);

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
            <h3>VALE DE MATERIALES</h3>
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
                   <th>Cantidad surtida</th>
                  <th>Cantidad utilizada</th>
                  <?php 
                 $usuario=$_SESSION['login'];
                 $rol=$usuario['id_rol'];
                  if($rol== 5){ ?>
                  <th>Sub total</th>
                  <th>Total</th><?php } ?>
                  <th>Solicitante</th>
                  <th>Paciente</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $paciente1 = $_GET['paciente'];
                $resultado2 = $conexion->query("SELECT * from paciente p, dat_ingreso di, cart_mat c, material_ceye i where di.id_atencion = c.paciente and di.Id_exp = p.Id_exp and di.id_atencion = $paciente1 and i.material_id = c.material_id") or die($conexion->error);
                $no = 1;
                $total = 0;
                while ($row = $resultado2->fetch_assoc()) {
                  $id_cart_mat = $row['id'];
                  $id_usua = $usuario2;
                  $paci =  $row['nom_pac'] . ' ' . $row['papell'] . ' ' . $row['sapell'];
                  
                  $sql4 = "SELECT id_usua, papell,sapell FROM reg_usuarios where id_usua = $id_usua ";
                  $result4 = $conexion->query($sql4);
                  while ($row_usua = $result4->fetch_assoc()) {
                    $solicitante = $row_usua['papell'] . ' ' . $row_usua['sapell'];
                  }

                  $subtotal = $row['material_precio'] * $row['cart_surtido'];
                  $total += $subtotal;
                  if($rol== 5){
                  echo '<tr>'
                    . '<td>' . $row['material_nombre'] . '</td>'
                    . '<td>' . $row['cart_surtido'] . '</td>'
                    . '<td>' . $row['cart_qty'] . '</td>'
                    . '<td> $' . number_format($row['material_precio'], 2) . '</td>'
                    . '<td>$ ' . number_format($subtotal, 2) . '</td>'
                    . '<td>' . $solicitante . '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="manipula_borrarcarro.php?q=del_car&cart_qty=' . $row['cart_qty'] . '&paciente=' . $paciente1 . '&cart_id=' . $row['id'] . '"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $no++;
                }else{
                  echo '<tr>'
                     . '<td>' . $row['material_nombre'] . '</td>'
                    . '<td>' . $row['cart_qty'] . '</td>'
                    . '<td>' . $solicitante . '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="manipula_borrarcarro.php?q=del_car&cart_qty=' . $row['cart_qty'] . '&paciente=' . $paciente1 . '&cart_id=' . $row['id'] . '"><span class = "fa fa-trash"></span></a></td>';
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
          <!--    <center>
                <?php
                echo '<a type="submit" class="btn btn-success col-3 btn-block" href="manipulacarrito.php?q=comf_cart&paciente=' . $paciente1 . '&id_usua=' . $usuario2 . '"><span>CONFIRMAR</span></a>';
                ?>
              </center>-->
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
                