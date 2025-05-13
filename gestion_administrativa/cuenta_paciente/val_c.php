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


    <div class="container box">
      <div class="content">


        <?php

        include "../../conexionbd.php";
        $usuario1 = $_GET['id_usua'];
        $id_cta_pag = $_GET['id_cta'];

        $resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        $id_atencion = $_GET['id_at'];


        $resultado_total = $conexion->query("SELECT * FROM dat_financieros where id_atencion = $id_atencion") or die($conexion->error);
        $total_dep = 0;
        $no = 1;
        while ($row_total = $resultado_total->fetch_assoc()) {
          $total_dep = $row_total['deposito'] + $total_dep;
        }
        //  $diferencia = $total - $total_dep;


        $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.fecha, di.area, di.alta_med  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

        $result_pac = $conexion->query($sql_pac);

        while ($row_pac = $result_pac->fetch_assoc()) {
          $id_exp = $row_pac['Id_exp'];
          $pac_papell = $row_pac['papell'];
          $pac_sapell = $row_pac['sapell'];
          $pac_nom_pac = $row_pac['nom_pac'];
          $pac_dir = $row_pac['dir'];
          $pac_id_edo = $row_pac['id_edo'];
          $pac_id_mun = $row_pac['id_mun'];
          $pac_tel = $row_pac['tel'];
          $pac_fecnac = $row_pac['fecnac'];
          $pac_fecing = $row_pac['fecha'];
          $area = $row_pac['area'];
          $alta_med = $row_pac['alta_med'];
        }
        /*
           
            function evento()
            {
              time();
              $today = strtotime('today 12:00');
              $tomorrow = strtotime('tomorrow 12:00');
              $time_now = time();
              $timeLeft = ($time_now > $today ? $tomorrow : $today) - $time_now;
              return strftime("%H Horas, %M minutos, %S segundos", $timeLeft);
            }

            $tz = new DateTimeZone("America/New_York");
            $date_1 = new DateTime("2019-10-30 15:00:00", $tz);
            $date_2 = new DateTime("2019-11-21 14:30:20", $tz);

            echo $date_2->diff($date_1)->format("%a:%h:%i:%s");
    */
            
$fecha_actual = date("Y-m-d H:i:s");
        $sql_now = "SELECT DATE_ADD('$fecha_actual', INTERVAL 11 HOUR) as dat_now FROM dat_ingreso WHERE id_atencion = $id_atencion";

        $result_now = $conexion->query($sql_now);

        while ($row_now = $result_now->fetch_assoc()) {
          $dat_now = $row_now['dat_now'];
        }

        $sql_est = "SELECT DATEDIFF( '$dat_now' , fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";

        $result_est = $conexion->query($sql_est);

        while ($row_est = $result_est->fetch_assoc()) {
          $estancia = $row_est['estancia'];
        }

        ?>

        <div class="row">
          <a type="submit" class="btn btn-danger btn-block" href="valida_cta.php">REGRESAR</a>
        </div>

        <center>
          <h3>DETALLE DE LA CUENTA</h3>
        </center>
        <div class="form-group">
          <label class="col-sm-3 control-label"> NOMBRE DEL PACIENTE: </label>
          <div class="col-md-6">
            <input type="text" name="paciente" class="form-control" value="<?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?>" disabled>
          </div>
        </div>
        <div class="container">
           <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                         <tr><strong><center>AGREGAR SERVICIOS A LA CUENTA</center></strong> 
           </div>
        <br>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          <div class="row">
              <label>SERVICIO: </label>
            <div class="col-sm-4">
            <select class="selectpicker" data-live-search="true" name="serv" id="serv" onchange="return otros();" >
              <?php
              $query = "SELECT * FROM `cat_servicios` where serv_activo = 'SI'";
              $result = $conexion->query($query);
              //$result = mysql_query($query);
              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id_serv'] . "'>" . $row['serv_desc'] . "</option>";
              }
              ?>
            </select>
            </div>
          <br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<label>CANTIDAD:</label>
            <div class="col-sm-3">
            <input id="cant" name="cant" placeholder="INSERTAR CANTIDAD" class="form-control" type="number" min="0" step="1" required>
            </div>
            <center><div class="col-sm-15"><input type="submit" name="btnserv"  class="btn btn-block btn-success" value="GUARDAR"></div></center>
          </div>
         
        </form>
        </div>

           <?php
        /*    if (isset($_GET['opc'])) {
          $id_ser = $_GET['opc'];
          $resultado_ser = $conexion->query("SELECT * FROM cat_servicios where id_serv = $id_ser") or die($conexion->error);

          while ($row_s = $resultado_ser->fetch_assoc()) {
            $id_s = $row_s['serv_cve'];
          }
          if ($id_s == 'OTROS') {
*/
        ?>
        <div id="form_otros"></div>
        <?php
        /* }       
        }*/
        if (isset($_POST['btnserv_otros'])) {
          $desc_otros = mysqli_real_escape_string($conexion, (strip_tags($_POST["desc_otros"], ENT_QUOTES))); //Escanpando caracteres
          $cant_otros = mysqli_real_escape_string($conexion, (strip_tags($_POST["cant_otros"], ENT_QUOTES))); //Escanpando
          $precio_otros = mysqli_real_escape_string($conexion, (strip_tags($_POST["precio_otros"], ENT_QUOTES))); //Escanpando

          // $sql6 = "INSERT INTO serv_otros(desc_otros,cant_otros,precio_otros)VALUES('$desc_otros',$cant_otros,$precio_otros)";
          // $result = $conexion->query($sql6);

$fecha_actual = date("Y-m-d H:i:s");
          $sql5 = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo)VALUES($id_atencion,'$desc_otros', 0,'$fecha_actual',$cant_otros,$precio_otros,$usuario1,'SI')";
          $result = $conexion->query($sql5);


    echo '<script type="text/javascript"> window.location.href="val_c.php?id_at=' . $id_atencion . '&id_usua=' . $usuario1 . '&id_cta=' . $id_cta_pag . '";</script>';
        }
        ?>
         <?php

    if (isset($_POST['btnserv'])) {
      $serv = mysqli_real_escape_string($conexion, (strip_tags($_POST["serv"], ENT_QUOTES))); //Escanpando caracteres
      $cant = mysqli_real_escape_string($conexion, (strip_tags($_POST["cant"], ENT_QUOTES))); //Escanpando

$fecha_actual = date("Y-m-d H:i:s");
      $sql2 = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo)VALUES($id_atencion,'S', $serv,'$fecha_actual',$cant,0,$usuario1,'SI')";
      $result = $conexion->query($sql2);


      echo '<script type="text/javascript"> window.location.href="val_c.php?id_at=' . $id_atencion . '&id_usua=' . $usuario1 . '&id_cta=' . $id_cta_pag . '";</script>';
    }
    ?>
        <center>
          <a type="submit" class="btn btn-primary btn-md" href="cuenta.php?id_atencion=<?php echo $id_atencion ?>&id_usua=<?php echo $usuario1 ?>" target="blank">IMPRIMIR CUENTA VALIDADA</a>
        </center>

        <hr class="new4">
        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->


          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #0c675e; color: white;">
              <tr>
                <th>#</th>
                <th>FECHA REGISTRO</th>
                <th>TIPO</th>
                <th>DESCRIPCIÓN</th>
                <th>CANT.</th>
                <th>PRECIO</th>
                <th>SUBTOTAL</th>
                <?php
                 $usuario=$_SESSION['login'];
 $rol=$usuario['id_rol'];
                if ($rol == 5 || $rol == 1 ) {
                  echo '<th></th>';
                } else {
                }
                ?>
              </tr>
            </thead>
            <tbody>

          <?php
              $total = 0;
              $no = 1;
              $resultado8 = $conexion->query("SELECT * FROM dat_ctapac where id_atencion = $id_atencion and prod_serv <> 'P' and prod_serv <> 'S' and prod_serv <> 'PC' ORDER BY cta_fec ASC") or die($conexion->error);
              while ($row8 = $resultado8->fetch_assoc()) {

                $flag = $row8['prod_serv'];
                $insumo = $row8['insumo'];
                $id_ctapac = $row8['id_ctapac'];
               
               if ($insumo == 0) {
                 $descripcion = $row8['prod_serv'];
                  $umed = "N/A";
                  $precio = $row8['cta_tot'];
               }

                $cant = $row8['cta_cant'];
                $subtottal = ($precio * $cant);
                $cta_fec=date_create($row8['cta_fec']);
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . date_format($cta_fec,"d-m-Y H:i:s") . '</td>'
                  . '<td>' . $umed . '</td>'
                  . '<td> ' . $descripcion . '</td>'
                  . '<td>' . $cant . '</td>'
                  . '<td>$ ' . number_format($precio, 2) . '</td>'
                  . '<td>$ ' . number_format($subtottal, 2) . '</td>';
                if ($rol == 5 ) {
                  echo ' <td> <a type="submit" class="btn btn-danger btn-sm" href="elimina_detallecta.php?q=del_cta_dev&id_ctapac=' . $id_ctapac . '&id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '"><span class = "fa fa-trash"></span></a></td>';
                }
                echo '</tr>';
                $total = $subtottal + $total;
                $no++;
              }
              ?>
              <?php
              $resultado3 = $conexion->query("SELECT * FROM dat_ctapac where id_atencion = $id_atencion and (prod_serv = 'P' || prod_serv = 'S' || prod_serv = 'PC') ORDER BY cta_fec ASC") or die($conexion->error);
            
              while ($row3 = $resultado3->fetch_assoc()) {

                $flag = $row3['prod_serv'];
                $insumo = $row3['insumo'];
                $id_ctapac = $row3['id_ctapac'];
               
               if ($insumo == 0 && $flag != 'S' && $flag != 'P' && $flag != 'PC') {
                 $descripcion = $row3['prod_serv'];
                  $umed = "N/A";
                  $precio = $row3['cta_tot'];
               }elseif ($flag == 'S') {
                  $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo ") or die($conexion->error);
                  while ($row_serv = $resultado_serv->fetch_assoc()) {
                    $precio = $row_serv['serv_costo'];
                    $descripcion = $row_serv['serv_desc'];
                    $umed = $row_serv['serv_umed'];
                  }
                } else if ($flag == 'P') {
                  $resultado_prod = $conexion->query("SELECT * FROM sales s, item i where i.item_id = $insumo and i.item_code = s.item_code and s.paciente = $id_atencion") or die($conexion->error);
                  while ($row_prod = $resultado_prod->fetch_assoc()) {
                    $precio = $row_prod['price'];
                    $descripcion = $row_prod['generic_name'];
                    $umed = $row_prod['type'];
                  }
                } else if ($flag == 'PC') {
                  $resultado_cy = $conexion->query("SELECT * FROM sales_ceye s, material_ceye m, item_type i where m.material_id = $insumo and  m.material_codigo=s.item_code and s.paciente = $id_atencion and m.material_tipo=i.item_type_id") or die($conexion->error);
                   while ($row_prod = $resultado_cy->fetch_assoc()) {
                   $precio = $row_prod['price'];
                   $descripcion = $row_prod['generic_name'];
                   $umed = $row_prod['item_type_desc'];
                 }
                }

                $cant = $row3['cta_cant'];
                $subtottal = ($precio * $cant);
                $cta_fec=date_create($row3['cta_fec']);
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . date_format($cta_fec,"d-m-Y H:i:s") . '</td>'
                  . '<td>' . $umed . '</td>'
                  . '<td> ' . $descripcion . '</td>'
                  . '<td>' . $cant . '</td>'
                  . '<td>$ ' . number_format($precio, 2) . '</td>'
                  . '<td>$ ' . number_format($subtottal, 2) . '</td>';
                if ($rol == 5 ) {
                  echo ' <td> <a type="submit" class="btn btn-danger btn-sm" href="elimina_detallecta.php?q=del_cta_dev&id_ctapac=' . $id_ctapac . '&id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '"><span class = "fa fa-trash"></span></a></td>';
                }
                echo '</tr>';
                $total = $subtottal + $total;
                $no++;
              }
              ?>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>Total</td>
              <td><?php echo "$ " . number_format($total, 2); ?></td>
              <td></td>

            </tbody>
          </table>

        </div>
        <br>
        <hr class="new4">
        <div class="container box">
      <div class="content">
         <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                         <tr><strong><center>AGREGAR DEPÓSITOS A LA CUENTA</strong> 
        </div>

        <?php
       /* $sql_datfin = "SELECT * from dat_financieros where id_atencion = $id_atencion ORDER BY fecha DESC LIMIT 1";
        $result_datfin = $conexion->query($sql_datfin);
        while ($row_datfin = $result_datfin->fetch_assoc()) {
          $aseg = $row_datfin['aseg'];
          $cob = $row_datfin['cob'];
          $id_edo = $row_datfin['id_edo'];
          $id_mun = $row_datfin['id_mun'];
          $aval = $row_datfin['aval'];
          $cta_banco = $row_datfin['cta_banco'];
          $id_mun = $row_datfin['id_mun'];
        }*/
        ?>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-4">
             
                <label for="resp">NOMBRE DE QUIEN DEPOSITA: </label><br>
                <input type="text" name="resp" placeholder="NOMBRE COMPLETO DE QUIEN DEPOSITA" id="resp" style="text-transform:uppercase;" maxlength="50" onkeypress="return SoloLetras(event);" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control">
             
            </div>
       <!--     <div class="col-md-4">
             
                <label for="dir_resp">DIRECCIÓN: </label><br>
                <input type="text" name="dir_resp" placeholder="DIRECCIÓN DE QUIEN DEPOSITA" id="dir_resp" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required class="form-control">
             
            </div>
            <div class="col-md-4">
              
                <label for="tel">TELÉFONO DE QUIEN REALIZA EN DEPÓSITO: </label><br>
                <input type="text" name="tel" placeholder="TELÉFONO A 10 DÍGITOS"  id="tel" style="text-transform:uppercase;" maxlength="12" minlength="12" onkeypress="return SoloNumeros(event);" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control">
             
            </div>-->
            <div class="col-md-4">
              
                <label>FORMA DE PAGO: </label>
                  <select name="banco" class="form-control" required>
                    <option value="">SELECCIONAR</option>
                    <option value="EFECTIVO">EFECTIVO</option>
                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                    <option value="DEPOSITO">DEPOSITO</option>
                    <option value="TARJETA">TARJETA</option>
                    <option value="ASEGURADORA">ASEGURADORA</option>
                    <option value="PAQUETE">PAQUETE</option>
                    <option value="COASEGURO">COASEGURO</option>
                    <option value="DEDUCIBLE">DEDUCIBLE</option>
                    <option value="DEVOLUCION">DEVOLUCIÓN</option>
                  </select>
              
            </div>
            <div class="col-md-4">
              
                <label>Cantidad $:</label>
                  <input type="text" name="deposito" class="form-control" onkeypress="return SoloNumeroscuenta(event);" required class="form-control">
            
            </div>
          <!--  <div class="col-md-4">
              
              <label>Cantidad con letra $:</label>
              <input type="text" name="dep_l"  id="dep_l" style="text-transform:uppercase;" value="" maxlength="150" onkeypress="return SoloLetras(event);" onkeyup="javascript:this.value=this.value.toUpperCase();" required class="form-control">
           
            </div> -->
          </div>
          <br>
         
            
            <center>
               <input type="submit" name="btndatfin" class="btn btn-block btn-success col-sm-3" value="GUARDAR DEPÓSITO">
            </center>
          
          
        </form>
<?php

      if (isset($_POST['btndatfin'])) {
        $usuario = $_SESSION['login'];
        $id_usua=$usuario['id_usua'];
        $resp = mysqli_real_escape_string($conexion, (strip_tags($_POST["resp"], ENT_QUOTES))); //Escanpando caracteres
        $dir_resp = mysqli_real_escape_string($conexion, (strip_tags($_POST["dir_resp"], ENT_QUOTES))); //Escanpando caracteres
        $tel = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel"], ENT_QUOTES))); //Escanpando caracteres
        $banco = mysqli_real_escape_string($conexion, (strip_tags($_POST["banco"], ENT_QUOTES))); //Escanpando caracteres
        $deposito = mysqli_real_escape_string($conexion, (strip_tags($_POST["deposito"], ENT_QUOTES))); //Escanpando
        //$dep_l = mysqli_real_escape_string($conexion, (strip_tags($_POST["dep_l"], ENT_QUOTES))); //Escanpando

        $deposito;
require_once "CifrasEnLetras.php";
$v=new CifrasEnLetras(); 
//Convertimos el total en letras
$letra=($v->convertirEurosEnLetras($deposito));
$dep_l=strtoupper($letra);

$fecha_actual = date("Y-m-d H:i:s");
        $sql_df = "INSERT INTO dat_financieros(id_atencion,aseg,resp,dir_resp,tel,aval,banco,deposito,dep_l,fec_deposito,total_cta,saldo,fecha,id_usua)values($id_atencion,'NINGUNA','$resp','$dir_resp','$tel','$resp','$banco',$deposito,'$dep_l','$fecha_actual', 0.00,0.00,'$fecha_actual',$id_usua)";
        $result_df = $conexion->query($sql_df);
        if ($result_df) {
          echo '<script type="text/javascript"> window.location.href="val_c.php?id_at=' . $id_atencion . '&id_usua=' . $usuario1 . '&id_cta=' . $id_cta_pag . '";</script>';
        } else {
          echo $sql_df;
          echo '<h1>ERROR AL INSERTAR';
        }
      }
      ?>
        <hr class="new4">
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
              $resultado4 = $conexion->query("SELECT * FROM dat_financieros where id_atencion = $id_atencion") or die($conexion->error);
              $total_dep = 0;
              $no = 1;
              while ($row4 = $resultado4->fetch_assoc()) {
                $fecha=date_create($row4['fecha']);
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . date_format($fecha,"d-m-Y H:i:s") . '</td>'
                  . '<td>' . $row4['resp'] . '</td>'
                  . '<td> ' . $row4['banco'] . '</td>'
                  . '<td>$ ' . number_format($row4['deposito'], 2) . '</td>';
                if ($rol == 5) {
                  echo ' <td><a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_deposito.php?id_exp=' . $id_exp . '&id_atencion=' . $id_atencion . '&id_datfin=' . $row4['id_datfin'] . '&id_usua=' . $id_usua . '" target="_blank"><span class="fa fa-file-pdf-o"</span></a>
                   
                   <a type="submit" class="btn btn-danger btn-sm" href="elimina_detallecta.php?q=del_dep&id_datfin=' . $row4['id_datfin'] . '&id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '"><span class = "fa fa-trash"></span></a></td>';
                } else {
                  echo '<td><strong><a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_deposito.php?id_exp=' . $id_exp . '&id_atencion=' . $id_atencion . '&id_datfin=' . $row4['id_datfin'] . '&id_usua=' . $id_usua . '"
                     target="_blank"><span class="fa fa-file-pdf-o"</span></a></strong></td>';
                }
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
<br><br><hr class="new4">
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <!--  <div class="form-group">
            <label class="col-sm-3 control-label">Tipo de pago: </label>
            <div class="col-md-6">
              <select name="t_pago" class="form-control" required>
                <option value="">Seleccionar Fórma de Pago</option>
                <option value="EFECTIVO">EFECTIVO</option>
                <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                <option value="DEPOSITO">DEPOSITO</option>
              </select>
            </div>
          </div>-->

          <center>
            <div class="col-sm-4">
              <input type="submit" name="btnctapag" class="btn btn-block btn-success" value="VALIDAR CUENTA">
            </div>
          </center>
        </form>
        <?php

        if (isset($_POST['btnctapag'])) {
      
$fecha_actual = date("Y-m-d H:i:s");
      $sql_up = "UPDATE cta_pagada SET diferencia = 0, fecha_cierre = '$fecha_actual', id_usua=$usuario1, cta_cerrada='SI' WHERE id_cta_pag = $id_cta_pag";

          $sql_ing = "UPDATE dat_ingreso SET valida = 'SI', activo='NO' WHERE id_atencion = $id_atencion";
 
          $result_up = $conexion->query($sql_up);
          $result_ing = $conexion->query($sql_ing);

          $sql_camas = "UPDATE cat_camas set estatus='LIBRE', id_atencion = 0 WHERE id_atencion = $id_atencion";
          $result_camas = $conexion->query($sql_camas);

          $resultado3 = $conexion->query("SELECT * FROM dat_ctapac dc, paciente p, dat_ingreso di where di.id_atencion=$id_atencion and p.Id_exp=di.Id_exp and dc.id_atencion = $id_atencion ORDER BY cta_fec ASC") or die($conexion->error);
$total = 0;
$no = 1;
while ($row3 = $resultado3->fetch_assoc()) {

  $flag = $row3['prod_serv'];
  $insumo = $row3['insumo'];
  $id_ctapac = $row3['id_ctapac'];
  $id_exp = $row3['Id_exp'];

  if ($flag == 'S') {
    $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
    while ($row_serv = $resultado_serv->fetch_assoc()) {
      $precio = $row_serv['serv_costo'];
      $descripcion = $row_serv['serv_desc'];
      $umed = $row_serv['serv_umed'];
    }
  } else if ($flag == 'P') {
    $resultado_prod = $conexion->query("SELECT * FROM sales s, item i where i.item_id = $insumo and i.item_code = s.item_code and s.paciente = $id_atencion") or die($conexion->error);
    while ($row_prod = $resultado_prod->fetch_assoc()) {
      $precio = $row_prod['price'];
      $descripcion = $row_prod['generic_name'];
      $umed = $row_prod['type'];
    }
  }else if ($flag == 'PC') {
     $resultado_cy = $conexion->query("SELECT * FROM sales_ceye s, material_ceye m, item_type i where m.material_id = $insumo and  m.material_codigo = s.item_code and s.paciente = $id_atencion and m.material_tipo=i.item_type_id") or die($conexion->error);
      while ($row_prod = $resultado_cy->fetch_assoc()) {
          $precio = $row_prod['price'];
          $descripcion = $row_prod['generic_name'];
          $umed = $row_prod['item_type_desc'];
    }
   } else {
    $descripcion = $row3['prod_serv'];
    $umed = "N/A";
    $precio = $row3['cta_tot'];
  }

  $cant = $row3['cta_cant'];
  $subtottal = ($precio * $cant);
  $fecha=$row3['cta_fec'];
  $date = date_create($row3['cta_fec']);

$insert_cuenta_pagada="INSERT INTO cuenta_pag(id_atencion,fecha,tipo,nombre,cantidad,precio,subtotal) values($id_atencion,'$fecha','$umed','$descripcion',$cant,$precio,$subtottal)";
$result_insrt_cuenta=$conexion->query($insert_cuenta_pagada);
}

          echo '<script type="text/javascript"> window.location.href="valida_cta.php";</script>';
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
<script type="text/javascript">
    function otros() {
      var option = document.getElementById('serv').value;
      var form_otros = document.getElementById('form_otros');
      <?php
      $query_1 = "SELECT * FROM `cat_servicios` where serv_desc = 'OTROS'";
      $result_1 = $conexion->query($query_1);
      //$result = mysql_query($query);
      while ($row_1 = $result_1->fetch_assoc()) {
        $otros_opc = $row_1['id_serv'];
      }
      ?>

      var opc_otr = <?php echo $otros_opc ?>;
      if (option == opc_otr) {
        form_otros.innerHTML = '<hr class="new4">' +
          '<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">' +
          '<center> <h4> DESCRIBIR OTROS SERVICIOS </h4></center>'+
          '<div class="row">'+
          '<div class="col-md-6">' +
          '<label>DESCRIPCIÓN (OTROS): </label>' +
          '<input id="desc_otros" name="desc_otros" placeholder="Inserta la descripción" class="form-control input-md" type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" required>' +
          '</div>' +
          '</div>' +
          '<div class="row">'+
          '<div class="col-md-6">'+
          '<label>CANTIDAD (OTROS):</label>' +
          '<input id="cant_otros" name="cant_otros" placeholder="Inserta la cantidad" class="form-control input-md" type="number" min="0" step="1" required>' +
          '</div>' +
          '<div class="col-md-6">'+
          '<label>PRECIO (OTROS):</label>' +
          ' <input id="precio_otros" name="precio_otros" placeholder="Inserta el precio" class="form-control input-md" type="number" min="0" step="0.01" required>' +
          '</div>' +
          '</div><br>'+
          ' <div class="col-sm-4">' +
          '<input type="submit" name="btnserv_otros" class="btn btn-block btn-success" value="GUARDAR OTROS SERVICIOS">' +
          '</div>' +
          '</form>';
      }
    }
  </script>
  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
</body>

</html>