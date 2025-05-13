<?php
session_start();
//include "../../conexionbd.php";
include "../header_administrador.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];
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

  <title>Detalle de la cuenta</title>
  <style>
    hr.new4 {
      border: 1px solid red;
    }
  </style>
</head>

<body>
  <section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->
<?php 
$id_pac=$_GET['id_pac_serv'];
$serv="SELECT * FROM pago_serv where id_pac=$id_pac";
$result=$conexion->query($serv);
while ($row=$result->fetch_assoc()) {
  $nombre=$row['nombre'];
}
 ?>
    <div class="container box">
      <div class="content">
        <div class="row">
          <a type="submit" class="btn btn-danger btn-block" href="valida_cta_serv.php">REGRESAR</a>
        </div>

        <center>
          <h3>DETALLE DE LA CUENTA</h3>
        </center>
        <div class="form-group">
          <label class="col-sm-3 control-label"> NOMBRE DEL PACIENTE: </label>
          <div class="col-md-6">
            <input type="text" name="paciente" class="form-control" value="<?php echo $nombre ?>" disabled>
          </div>
        </div>
        <div class="container">
           <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                         <tr><strong><center>AGREGAR SERVICIOS A LA CUENTA</center></strong> 
           </div>
        <br>
        </tr></div>
<div class="row">
        <div class="col-sm-1"></div>
        <form action="" method="POST">
         <div class="row">
            <div class="col-sm-7">
              SERVICIO:<br><select data-live-search="true" id="mibuscador" name="serv" class="form-control" onchange="return mostrar();">
             <?php
               $sql_serv = "SELECT * FROM cat_servicios where serv_activo = 'SI'";
                   $result_serv = $conexion->query($sql_serv);
                    while ($row_serv = $result_serv->fetch_assoc()) {
                       echo "<option value='" . $row_serv['id_serv'] . "'>" . $row_serv['serv_desc'] . "</option>";
                                    }
              ?>
                </select>  
            </div>
            <div class="col-sm-2">
            CANTIDAD:<br><input type="number" name="cantidad" class="form-control" value="">
            </div>
            <div class="col-sm-2">
            <br><input type="submit" name="btnserv" class="btn btn-block btn-success" value="AGREGAR">
            </div> 
          </div>
        </form>
    </div><hr>
    <div class="row">
        <div class="col-sm-1"></div>
        <form action="" method="POST">
         <div class="row">
            <div class="col-sm-7">
              MEDICAMENTOS Y MATERIALES:<br><select data-live-search="true" id="mibuscador2" name="med" class="form-control" required>
             <?php
               $sql_serv = "SELECT * FROM item ";
                   $result_serv = $conexion->query($sql_serv);
                    while ($row_serv = $result_serv->fetch_assoc()) {
                       echo "<option value='" . $row_serv['item_id'] . "'>" . $row_serv['item_name'] . "</option>";
                                    }
              ?>
                </select>  
            </div>
            <div class="col-sm-2">
            CANTIDAD:<br><input type="number" name="cantidad" class="form-control" value="">
            </div>
            <div class="col-sm-2">
            <br><input type="submit" name="btnmed" class="btn btn-block btn-success" value="AGREGAR">
            </div> 
          </div>
        </form>
    </div><hr>
   <div class="row">
        <div class="col-sm-1"></div>
        <form action="" method="POST">
            <label><strong>OTROS:</strong></label><br>
         <div class="row">
            <div class="col-sm-4">
              
              <label>DESCRIPCIÓN</label><br>
              <input type="text" name="desc" class="form-control" placeholder="DESCRIPCIÓN" class="form-control">  
            </div>
            <div class="col-sm-3">
            <label>CANTIDAD:</label><br><input type="number" placeholder="CANTIDAD" name="cant" class="form-control" value="">
            </div>
            <div class="col-sm-2">
            <label>PRECIO:</label><br><input type="number" name="prec" placeholder="PRECIO" class="form-control" value="">
            </div>
            <div class="col-sm-2">
            <br><input type="submit" name="btnotros" class="btn btn-block btn-success" value="AGREGAR">
            </div> 
          </div>
        </form>
    </div> <br>   
        <center>
          <a type="submit" class="btn btn-primary btn-md" href="../pago_servicios/pdf_pago_servicios.php?id_pac=<?php echo $id_pac ?>" target="blank">Imprimir cuenta</a>
        </center>


    <?php 
    $usuario=$_SESSION['login'];
    $id_usua=$usuario['id_usua'];
    if (isset($_POST['btnserv'])) {
        include "../../conexionbd.php";
        $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac_serv"], ENT_QUOTES)));
        $serv_id =  mysqli_real_escape_string($conexion, (strip_tags($_POST["serv"], ENT_QUOTES)));
        $cantidad =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));
$resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $serv_id") or die($conexion->error);
                  while ($row_serv = $resultado_serv->fetch_assoc()) {
                    $descripcion = $row_serv['serv_desc'];
                    $serv_costo = $row_serv['serv_costo'];
                  }
                  
$fecha_actual = date("Y-m-d H:i:s");

        $ingresar2 = mysqli_query($conexion, 'INSERT INTO pago_serv (id_pac,nombre,id_serv,servicio,cantidad,precio,fecha,usuario) values ('.$id_pac.',"'.$nombre.'","' . $serv_id . '","' . $descripcion .'",' . $cantidad . ',' . $serv_costo . ',"'.$fecha_actual.'",'.$id_usua.') ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

           echo '<script type="text/javascript">window.location.href = "val_c_serv.php?id_pac_serv='.$id_pac.'";</script>';
    }

    if (isset($_POST['btnmed'])) {
        include "../../conexionbd.php";
        $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac_serv"], ENT_QUOTES)));
        $item_id =  mysqli_real_escape_string($conexion, (strip_tags($_POST["med"], ENT_QUOTES)));
        $cantidad =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));

$resultado_serv = $conexion->query("SELECT * FROM item where item_id = $item_id") or die($conexion->error);
                  while ($row_serv = $resultado_serv->fetch_assoc()) {
                    $item_code = $row_serv['item_code'];
                    $descripcion = $row_serv['item_name'];
                    $item_price = $row_serv['item_price'];
                  }
                  
$fecha_actual = date("Y-m-d H:i:s");
        $ingresar2 = mysqli_query($conexion, 'INSERT INTO pago_serv (id_pac,nombre,id_serv,servicio,cantidad,precio,fecha,usuario) values ('.$id_pac.',"'.$nombre.'","'. $item_code .'","' . $descripcion .'",' . $cantidad . ',' . $item_price . ',"'.$fecha_actual.'",'.$id_usua.') ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

          echo '<script type="text/javascript">window.location.href = "val_c_serv.php?id_pac_serv='.$id_pac.'";</script>';
    }
if (isset($_POST['btnotros'])) {
        include "../../conexionbd.php";
        $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac_serv"], ENT_QUOTES)));
        $desc = strtoupper(mysqli_real_escape_string($conexion, (strip_tags($_POST["desc"], ENT_QUOTES))));
        $cant =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cant"], ENT_QUOTES)));
        $prec =  mysqli_real_escape_string($conexion, (strip_tags($_POST["prec"], ENT_QUOTES)));


                  
$fecha_actual = date("Y-m-d H:i:s");
        $ingresar2 = mysqli_query($conexion, 'INSERT INTO pago_serv (id_pac,nombre,id_serv,servicio,cantidad,precio,fecha,usuario) values ('.$id_pac.',"'.$nombre.'",135,"' . $desc .'",' . $cant. ','.$prec.',"'.$fecha_actual.'",'.$id_usua.') ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

          echo '<script type="text/javascript">window.location.href = "val_c_serv.php?id_pac_serv='.$id_pac.'";</script>';
    }

     ?>

        <hr class="new4">
        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->


        <div class="row">
        <div class="col">
            <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mytable">
              <thead class="thead" style="background-color: seagreen; color: white;">
               <tr>
                <th>#</th>
                <th>FECHA</th>
                <th>DESCRIPCIÓN</th>
                <th>CANTIDAD</th>
                <th>PRECIO</th>
                <th>SUB TOTAL</th>
                <th></th>
              </tr>
             </thead>
            
            <tbody>
                 <?php
                 $total = 0;
                 if (isset($_GET['id_pac_serv'])) {
 include "../../conexionbd.php";
                
                $id_pac=$_GET['id_pac_serv'];
     $resultado_total = $conexion->query("SELECT * FROM depositos_pserv where id_pac = $id_pac") or die($conexion->error);
        $total_dep = 0;
        $no = 1;
        while ($row_total = $resultado_total->fetch_assoc()) {
          $total_dep = $row_total['deposito'] + $total_dep;
        }
                  
$resultado3 = $conexion->query("SELECT * from pago_serv p, cat_servicios c where $id_pac=p.id_pac and c.id_serv=p.id_serv and c.id_serv!=135 and p.activo='SI'") or die($conexion->error);

                 $no = 1;
                while ($row_lista_serv = $resultado3->fetch_assoc()) {
                    $fecha=date_create($row_lista_serv['fecha']);
                    $subtottal=$row_lista_serv['serv_costo']*$row_lista_serv['cantidad'];
                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . date_format($fecha,"d-m-Y") . '</td>'
                    . '<td>' . $row_lista_serv['servicio'] . '</td>'
                    . '<td>' . $row_lista_serv['cantidad'] . '</td>'
                    . '<td>$' . number_format($row_lista_serv['serv_costo'],2) . '</td>'
                    . '<td>$' . number_format($subtottal, 2). '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="../pago_servicios/manipula_pago.php?q=eliminar_serv_val&pago_id= ' . $row_lista_serv['pago_id'] . '&id_pac='.$row_lista_serv['id_pac'].'&nombre='.$nombre.'"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $total= $subtottal + $total;
                  $no++;
                } 
          $resultado3 = $conexion->query("SELECT * from pago_serv p, item i where $id_pac=p.id_pac and i.item_code=p.id_serv and p.activo='SI'") or die($conexion->error);
                while ($row_lista_serv = $resultado3->fetch_assoc()) {
                    $fecha=date_create($row_lista_serv['fecha']);
                    $subtottal=$row_lista_serv['item_price']*$row_lista_serv['cantidad'];
                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . date_format($fecha,"d-m-Y") . '</td>'
                    . '<td>' . $row_lista_serv['servicio'] . '</td>'
                    . '<td>' . $row_lista_serv['cantidad'] . '</td>'
                    . '<td>$' . number_format($row_lista_serv['item_price'],2) . '</td>'
                    . '<td>$' . number_format($subtottal, 2). '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="../pago_servicios/manipula_pago.php?q=eliminar_serv_val&pago_id= ' . $row_lista_serv['pago_id'] . '&id_pac='.$row_lista_serv['id_pac'].'&nombre='.$nombre.'"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $total= $subtottal + $total;
                  $no++;
                } 

                $resultado3 = $conexion->query("SELECT * from pago_serv p where $id_pac=p.id_pac and p.id_serv=135 and p.activo='SI'") or die($conexion->error);
                while ($row_lista_serv = $resultado3->fetch_assoc()) {
                    $fecha=date_create($row_lista_serv['fecha']);
                    $subtottal=$row_lista_serv['precio']*$row_lista_serv['cantidad'];
                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . date_format($fecha,"d-m-Y") . '</td>'
                    . '<td>' . $row_lista_serv['servicio'] . '</td>'
                    . '<td>' . $row_lista_serv['cantidad'] . '</td>'
                    . '<td>$' . number_format($row_lista_serv['precio'],2) . '</td>'
                    . '<td>$' . number_format($subtottal, 2). '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="../pago_servicios/manipula_pago.php?q=eliminar_serv_val&pago_id= ' . $row_lista_serv['pago_id'] . '&id_pac='.$row_lista_serv['id_pac'].'&nombre='.$nombre.'"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $total= $subtottal + $total;
                  $no++;
                } 


                 }
                
                ?>
                <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>TOTAL:</td>
              <td><?php echo "$ " . number_format($total, 2); ?></td>
              <td></td>
            </tbody>
            </table>
           </div>
        </div>
    </div>

        </div>
        <br>
        <hr class="new4">
        <div class="container box">
      <div class="content">
    <div class="container">
        <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                         <tr><strong><center>AGREGAR DEPOSITO A PAGO DE SERVICIOS</strong> 
        </div>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-4">
             
                <label for="resp">NOMBRE DE QUIEN DEPOSITA: </label><br>
                <input type="text" name="resp" placeholder="NOMBRE COMPLETO DE QUIEN DEPOSITA" id="resp" style="text-transform:uppercase;" maxlength="50" onkeypress="return SoloLetras(event);" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control">
             
            </div>
            <div class="col-md-4">
              
                <label>FORMA DE PAGO: </label>
                  <select name="tipo" class="form-control" required>
                    <option value="">SELECCIONAR</option>
                    <option value="EFECTIVO">EFECTIVO</option>
                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                    <option value="TARJETA">TARJETA</option>
                  </select>
            </div>
            <div class="col-md-4">
                <label>Cantidad $:</label>
                <input type="text" name="deposito" class="form-control" onkeypress="return SoloNumeroscuenta(event);" required class="form-control">
            
            </div>
          </div>
          <br>
            <center>
               <input type="submit" name="btnpago" class="btn btn-block btn-success col-sm-3" value="GUARDAR DEPÓSITO">
            </center>
        </form>
    </div><br>
          <?php
      if (isset($_POST['btnpago'])) {
        $usuario = $_SESSION['login'];
        $id_usua=$usuario['id_usua'];
        $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac_serv"], ENT_QUOTES)));
        $resp = mysqli_real_escape_string($conexion, (strip_tags($_POST["resp"], ENT_QUOTES)));
        $tipo = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES)));
        $deposito = mysqli_real_escape_string($conexion, (strip_tags($_POST["deposito"], ENT_QUOTES)));

$fecha_actual = date("Y-m-d H:i:s");
       
       $sql_df = "INSERT INTO depositos_pserv(id_pac,deposito,tipo,id_usua,fecha,responsable)values($id_pac,$deposito,'$tipo',$id_usua,'$fecha_actual','$resp')";
        $result_df = $conexion->query($sql_df);

        if ($result_df) {
          echo '<script type="text/javascript">window.location.href = "val_c_serv.php?id_pac_serv='.$id_pac.'";</script>';
        } else {
          echo $sql_df;
          echo '<h1>ERROR AL INSERTAR';
        }
      }
      ?>
      <div class="container">
          <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search_dep" placeholder="BUSCAR...">
        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #0c675e; color: white;">
              <tr>
                <th>#</th>
                <th>FECHA DEPÓSITO</th>
                <th>NOMBRE</th>
                <th>FORMA DE PAGO</th>
                <th>CANTIDAD</th>
                <th></th>
              </tr>
            </thead>
            <tbody>

              <?php
              $usuario = $_SESSION['login'];
              $id_usua=$usuario['id_usua'];
              $id_pac=$_GET['id_pac_serv'];
              $resultado4 = $conexion->query("SELECT * FROM depositos_pserv where id_pac = $id_pac") or die($conexion->error);
              $total_dep = 0;
              $no = 1;
              while ($row4 = $resultado4->fetch_assoc()) {
                $fecha=date_create($row4['fecha']);
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . date_format($fecha,"d-m-Y H:i:s") . '</td>'
                  . '<td>' . $row4['responsable'] . '</td>'
                  . '<td> ' . $row4['tipo'] . '</td>'
                  . '<td>$ ' . number_format($row4['deposito'], 2) . '</td>';

                  echo '<td><strong><a type="submit" class="btn btn-danger btn-sm" href="../pago_servicios/elimina_depserv.php?q=del_dep_val&id_pac=' . $id_pac . '&id_depserv=' . $row4['id_depserv'] . '"><span class = "fa fa-trash"></span></a></td>';
                echo '</tr>';
                $total_dep = $row4['deposito'] + $total_dep;
                $no++;
              }
              ?>
              <td></td>
              <td></td>
              <td></td>
              <td>Total</td>
              <td><?php echo "$ " . number_format($total_dep, 2); ?></td>
              <td></td>
            </tbody>
          </table>

        </div>
      </div>
<?php 
if(isset($_POST['btnpag'])){
    $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac_serv"], ENT_QUOTES)));
    $id_cta=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_cta"], ENT_QUOTES)));
    $id_usua=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_usua"], ENT_QUOTES)));
    $nom_pag=mysqli_real_escape_string($conexion, (strip_tags($_POST["nom_pag"], ENT_QUOTES)));
    $efect=mysqli_real_escape_string($conexion, (strip_tags($_POST["efect"], ENT_QUOTES)));
    $transf=mysqli_real_escape_string($conexion, (strip_tags($_POST["transf"], ENT_QUOTES)));
    $tarj=mysqli_real_escape_string($conexion, (strip_tags($_POST["tarj"], ENT_QUOTES)));

$usuario=$_SESSION['login'];
$id_usuario=$usuario['id_usua'];

$total=$efect+$transf+$tarj;


$fecha_actual = date("Y-m-d H:i:s");

$sql = "UPDATE metodo_pserv SET nom_pag='$nom_pag',total='$total', efectivo='$efect', transferencia='$transf', tarjeta='$tarj'    WHERE id_pac = $id_pac";
$result = $conexion->query($sql);

$sql = "UPDATE cta_pagada_serv SET total='$total' WHERE id_atencion = $id_pac";
$result = $conexion->query($sql);

/*$sql = "UPDATE cta_pagada_serv SET total='$total', fecha_cierre='$fecha_actual', id_usua='$id_usuario', cta_cerrada='SI' WHERE id_atencion = $id_pac";
$result = $conexion->query($sql);

$valida= "INSERT INTO cta_pagada_serv(id_atencion,total,fecha_cierre,id_usua) values($id_pac,'$total','$fecha_actual',$id_usua)";
$result_valida=$conexion->query($valida);*/
      
echo '<script type="text/javascript">window.location.href = "val_c_serv.php?id_pac_serv='.$id_pac.'&id_usua='.$id_usua.'&id_cta='.$id_cta.'";</script>';
      
}
 ?>
        <hr class="new4">

<br><br><hr class="new4">
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          <center>
            <div class="col-sm-4">
              <input type="submit" name="btnctapag" class="btn btn-block btn-success" value="Cuenta validada">
            </div>
          </center>
        </form>
        <?php

        if (isset($_POST['btnctapag'])) {
          $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac_serv"], ENT_QUOTES)));
$usuario=$_SESSION['login'];
$id_usua=$usuario['id_usua'];
      
      $fecha_actual = date("Y-m-d H:i:s");

       $resultado_total = $conexion->query("SELECT * FROM cta_pagada_serv where id_atencion = $id_pac") or die($conexion->error);
        while ($row_total = $resultado_total->fetch_assoc()) {
          $id_cta = $row_total['id_cta_pag_serv'];
        }

      $sql_up = "UPDATE cta_pagada_serv SET diferencia = 0, fecha_cierre = '$fecha_actual', id_usua=$id_usua, cta_cerrada='SI' WHERE id_cta_pag_serv = $id_cta";
      $result_up = $conexion->query($sql_up);

          echo '<script type="text/javascript"> window.location.href="valida_cta_serv.php";</script>';
        }

        /*if (isset($_POST['btnctapagada'])) {
          $t_pago = mysqli_real_escape_string($conexion, (strip_tags($_POST["t_pago"], ENT_QUOTES))); //Escanpando caracteres
          $sql_up = "UPDATE cta_pagada SET t_pago = '$t_pago', fecha_cierre = NOW(), id_usua=$usuario1, cta_cerrada='SI' WHERE id_cta_pag = $id_cta_pag";


          $sql_up = "UPDATE cta_pagada SET diferencia = 0, fecha_cierre = NOW(), id_usua=$usuario1, cta_cerrada='SI' WHERE id_cta_pag = $id_cta_pag";

          $sql_ing = "UPDATE dat_ingreso SET valida = 'SI', activo='NO' WHERE id_atencion = $id_atencion";
 
          $result_up = $conexion->query($sql_up);
          $result_ing = $conexion->query($sql_ing);

          $sql_camas = "UPDATE cat_camas set estatus='LIBRE', id_atencion = 0 WHERE id_atencion = $id_atencion";
          $result_camas = $conexion->query($sql_camas);

          echo '<script type="text/javascript"> window.location.href="valida_cta.php";</script>';
        }*/
        ?>
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