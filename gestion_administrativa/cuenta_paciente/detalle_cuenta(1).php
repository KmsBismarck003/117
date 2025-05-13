<?php
session_start();
//include "../../conexionbd.php";
include "../header_administrador.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);

$usuario = $_SESSION['login'];
$id_usua=$usuario['id_usua'];
?>
<!DOCTYPE html>F
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

  <title>Detalle de la cuenta del paciente</title>
  <style>
    hr.new4 {
      border: 1px solid red;
    }
  </style>
</head>

<body>
  <section class="content container-fluid">

    <div class="container box">
      <div class="content">

        <?php

        include "../../conexionbd.php";
        $usuario1 = $_GET['id_usua'];
        $rol = $_GET['rol'];

        //$resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        
        $id_exp = $_GET['id_exp'];
        $id_atencion = $_GET['id_at'];


        $resultado_total = $conexion->query("SELECT * FROM dat_financieros where id_atencion = $id_atencion") or die($conexion->error);
        $total_dep = 0;
        $no = 1;
        while ($row_total = $resultado_total->fetch_assoc()) {
          $total_dep = $row_total['deposito'] + $total_dep;
        }
        //  $diferencia = $total - $total_dep;


        $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.fecha, di.area, di.alta_med, di.alta_adm, di.valida, di.correo FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

        $result_pac = $conexion->query($sql_pac);

        while ($row_pac = $result_pac->fetch_assoc()) {
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
          $alta_adm = $row_pac['alta_adm'];
          $valida = $row_pac['valida'];
          $area = $row_pac['area'];
          $id_exp=$row_pac['Id_exp'];
          $correo = $row_pac['correo'];
         
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

        $sql_est = "SELECT DATEDIFF( '$dat_now' , fecha_cama) as dia_hab FROM dat_ingreso WHERE id_atencion = $id_atencion";
        $result_est = $conexion->query($sql_est);

        while ($row_est = $result_est->fetch_assoc()) {
          $dia_hab = $row_est['dia_hab'];
        }
        
        $sql_dia_hab = "SELECT * FROM dat_ctapac WHERE
        id_atencion = $id_atencion and prod_serv='S' and insumo= 1 or 
        id_atencion = $id_atencion and prod_serv='S' and insumo= 2 or 
        id_atencion = $id_atencion and prod_serv='S' and insumo= 3 or 
        id_atencion = $id_atencion and prod_serv='S' and insumo= 8 or 
        id_atencion = $id_atencion and prod_serv='S' and insumo= 4  
        Order by id_ctapac DESC LIMIT 1";
        $result_dia_hab = $conexion->query($sql_dia_hab);
         while ($row_dia_hab = $result_dia_hab->fetch_assoc()) {
          $id_cta=$row_dia_hab['id_ctapac'];
          $cta_cant = $row_dia_hab['cta_cant'];
          $insumo = $row_dia_hab['insumo'];
        }
        
        if(isset($id_cta)){
            
            /*
        if ($cta_cant <= $dia_hab && $insumo==1) {
          $sql_dia_hab = "UPDATE dat_ctapac SET cta_cant = $dia_hab  WHERE id_atencion = $id_atencion and prod_serv='S' and insumo=$insumo ";
        $result_dia_hab = $conexion->query($sql_dia_hab);
        }elseif($cta_cant <= $dia_hab && $insumo==2){
              $sql_dia_hab = "UPDATE dat_ctapac SET cta_cant = $dia_hab  WHERE id_atencion = $id_atencion and prod_serv='S' and insumo=$insumo ";
        $result_dia_hab = $conexion->query($sql_dia_hab);
        }elseif($cta_cant <= $dia_hab && $insumo==3){
              $sql_dia_hab = "UPDATE dat_ctapac SET cta_cant = $dia_hab  WHERE id_atencion = $id_atencion and prod_serv='S' and insumo=$insumo ";
        $result_dia_hab = $conexion->query($sql_dia_hab);
        }elseif($cta_cant <= $dia_hab && $insumo==4){
              $sql_dia_hab = "UPDATE dat_ctapac SET cta_cant = $dia_hab  WHERE id_atencion = $id_atencion and prod_serv='S' and insumo=$insumo ";
        $result_dia_hab = $conexion->query($sql_dia_hab);
        }elseif($cta_cant <= $dia_hab && $insumo==8){
              $sql_dia_hab = "UPDATE dat_ctapac SET cta_cant = $dia_hab  WHERE id_atencion = $id_atencion and prod_serv='S' and insumo=$insumo ";
        $result_dia_hab = $conexion->query($sql_dia_hab);
        }*/
        
      }else{
        ?>
    <div class="col-md-12">
         <!--   <div class="alert alert-danger alert-dismissible fade show"><center><strong>PACIENTE SIN HABITACIÓN</strong></center></div>
          </div>-->
        <?php } ?>


        <div class="row">
          <button type="button"class="btn btn-danger btn-sm" onclick="history.back()">Regresar</button>
        </div>
  
        <br>
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                         <tr><strong><center>CUENTA DEL PACIENTE</center></strong>
        </div>
        
        <div class="container">
           <div class="row">
                <div class="col-sm-6">
                    <label class="control-label">Paciente: </label><strong> &nbsp; <?php echo $id_exp.' - '.$pac_papell.' ' .$pac_sapell.' '.$pac_nom_pac  ?></strong>
                </div>
            
                <?php
                    $pac_fecing=date_create($pac_fecing);
                ?>
                <div class="col-md-6">
                    <label class="control-label">Fecha de ingreso: </label><strong>  &nbsp; <?php echo date_format($pac_fecing,"d/m/Y H:i a") ?></strong>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Aseguradora: </label><strong>  &nbsp; 
                    <?php $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
                    $result_aseg = $conexion->query($sql_aseg);
                     while ($row_aseg = $result_aseg->fetch_assoc()) {
                         echo $row_aseg['aseg'];
                         $at=$row_aseg['aseg'];
                    }
                    $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
                    while($filat = mysqli_fetch_array($resultadot)){ 
                        $tr=$filat["tip_precio"];
                     }
                    ?></strong>
                </div>
                <div class="col-md-3">
                    <label class="control-label">Habitación: </label><strong> &nbsp; <?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
                    $result_hab = $conexion->query($sql_hab);
                    while ($row_hab = $result_hab->fetch_assoc()) {
                        echo $row_hab['num_cama'];
                    } ?></strong>
             
                </div>
                <div class="col-md-3">
                    <label class="control-label">Área: </label><strong> &nbsp; <?php echo $area ?></strong>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Días de estancia: </label><strong> &nbsp; <?php echo $estancia ?> días</strong>
                </div>
    
            </div> 
        </div>
       </div>
      </div>
      
    <!--/************************************************************************************/-->
        <div class="container">
          
          <table class="table table-bordered table-striped" id="mytable">
      
            <tbody>

          <?php
              $total = 0;
            

              $resultado3 = $conexion->query("SELECT * FROM dat_ctapac where id_atencion = $id_atencion ORDER BY cta_fec ASC") or die($conexion->error);
            
              while ($row3 = $resultado3->fetch_assoc()) {

                $flag = $row3['prod_serv'];
                $insumo = $row3['insumo'];
                $id_ctapac = $row3['id_ctapac'];
                $precioh = $row3['cta_tot'];
                $iva = 0;
       
               if ($insumo == 0 && $flag != 'S' && $flag != 'H' && 
                    $flag != 'P' && 
                    $flag != 'PC' ) {
                    $precio = $row3['cta_tot'];
                    $iva = $precio * 0.16;
               }elseif ($flag == 'H' ) {
                  $resultado_servi = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
                  while ($row_servi = $resultado_servi->fetch_assoc()) {
                  $precio = $precioh;
                  $iva = 0.00;
               }}elseif ($flag == 'S') {
                    $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
                    while ($row_serv = $resultado_serv->fetch_assoc()) {
                        if ($tr==1) $precio = $row_serv['serv_costo'];
                        if ($tr==2) $precio = $row_serv['serv_costo2'];
                        if ($tr==3) $precio = $row_serv['serv_costo3'];
                        if ($tr==4) $precio = $row_serv['serv_costo4'];
                        if ($precio == 0) $precio = $precioh;
                        $iva = $precio * 0.16;        
               }} elseif ($flag == 'P' || $flag == 'PC' ) {
                    $precio = $precioh;
                    $iva = $precio * 0.16;
               }
                 
                $cant = $row3['cta_cant'];
                $precio2 = $precio + $iva;
                $subtottal = $precio2 * $cant;
                $subtottalsi = $preciosiva * $cant;
                
                $cta_fec=date_create($row3['cta_fec']);
           
                $total = $subtottal + $total;
               
           
              }
              ?>
              
              <center>
          
          <div class="col-md-6">
            <strong><input type="text" class="form-control pull-right" value="$ <?php $diferencia = ($total + $totalsi)  - $total_dep - $total_desc; 
              $diferencia = round($diferencia, 2, PHP_ROUND_HALF_DOWN);?>"  hidden></strong>
          </div>
        </center>
              
              <td style="text-align: center">Total de la cuenta:</td>
              <td style="text-align: center; font-weight:bold;"><font size ="3", color ="black"><?php echo number_format($total, 2); ?></td>
              <td style="text-align: center">Total de pagos :</td>
              <td style="text-align: center; font-weight:bold;"><font size ="3", color ="black"><?php echo number_format($total_dep, 2); ?></td>
              <td style="text-align: center">Total descuentos :</td>
              <td style="text-align: center; font-weight:bold;"><font size ="3", color ="black"><?php echo number_format($total_desc, 2); ?></td>
              <td style="text-align: center">Saldo :</td>
              <td style="text-align: center; font-weight:bold;"><font size ="3", color ="red"><?php echo number_format($diferencia, 2); ?></td>
              

            </tbody>
          </table>

        </div>
      
      
      <div class="container">
        <?php 
         if($alta_adm=="NO"){
         ?>
        <div class="container">
           <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                         <tr><strong><center>AGREGAR SERVICIOS A LA CUENTA</center></strong> 
           </div>
        <br>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          <div class="row">
              <label>Servicio: </label>
            <div class="col-sm-4">
            <select class="selectpicker" data-live-search="true" name="serv" id="serv" onchange="return otros();" >
              <?php
              $query = "SELECT * FROM `cat_servicios` where serv_activo = 'SI' and tipo != 7";
              $result = $conexion->query($query);
              //$result = mysql_query($query);
              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id_serv'] . "'>" . $row['serv_desc'] . "</option>";
              }
              ?>
            </select>
            </div>
          <br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<label>Cantidad:</label>
            <div class="col-sm-3">
            <input id="cant" name="cant" placeholder="INSERTAR CANTIDAD" class="form-control" type="number" min="0" step="1" required>
            </div>
            <center><div class="col-sm-15"><input type="submit" name="btnserv"  class="btn btn-block btn-sm btn-success" value="Guardar"></div></center>
          </div>
          </div>
        </form>
        
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
        if (isset($_POST['btnserv_hono'])) {
          $desc_hono = mysqli_real_escape_string($conexion, (strip_tags($_POST["desc_hono"], ENT_QUOTES))); //Escanpando caracteres
          $cant_hono = mysqli_real_escape_string($conexion, (strip_tags($_POST["cant_hono"], ENT_QUOTES))); //Escanpando
          $precio_hono = mysqli_real_escape_string($conexion, (strip_tags($_POST["precio_hono"], ENT_QUOTES))); //Escanpando

          

$fecha_actual = date("Y-m-d H:i:s");
          $sql5 = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo,centro_cto)VALUES($id_atencion,'H',$desc_hono,'$fecha_actual',$cant_hono,$precio_hono,$usuario1,'SI','$area')";
          
          $result = $conexion->query($sql5);


          echo '<script type="text/javascript"> window.location.href="detalle_cuenta.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '";</script>';
        }
        ?>

        <hr class="new4">

        <center>
        <div class="row">
          <div class="col-sm-2">
             <a type="submit" class="btn btn-primary btn-sm" href="cuenta.php?id_atencion=<?php echo $id_atencion ?>&id_usua=<?php echo $usuario1 ?>" target="blank"><h5>Estado de Cuenta</h5></a>
          </div>
          <div class="col-sm">
             <a href="excel.php?id_atencion=<?php echo $id_atencion ?>&id_usua=<?php echo $usuario1 ?>">
              <button type="button" class="btn btn-warning"><img src="https://img.icons8.com/color/48/000000/ms-excel.png"/><strong>Exporta a excel</strong></a>
          </div>
         
        </div>
        
       
        </center>
<?php } ?>
        <hr class="new4">
        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
        </div>


        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #2b2d7f; color: white;">
              <tr>
                <th>#</th>
                <th>Fecha de registro</th>
                <th>Área/Tipo</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <?php
                if ($rol == 5 || $rol == 1 ) {
                  echo '<th></th>';
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

              $resultado3 = $conexion->query("SELECT * FROM dat_ctapac where id_atencion = $id_atencion ORDER BY cta_fec ASC") or die($conexion->error);
            
              while ($row3 = $resultado3->fetch_assoc()) {

                $flag = $row3['prod_serv'];
                $insumo = $row3['insumo'];
                $id_ctapac = $row3['id_ctapac'];
               
                $precioh = $row3['cta_tot'];
                $iva = $precioh * 0.16;
       
               if ($insumo == 0 && $flag != 'S' && $flag != 'H' && 
                    $flag != 'P' && 
                    $flag != 'PC' ) {
                    $descripcion = $row3['prod_serv'];
                    $umed = "OTROS";
                    $precio = $row3['cta_tot'];
                    $iva = $precio * 0.16;
               }elseif ($flag == 'H' ) {
                  $resultado_servi = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
                  while ($row_servi = $resultado_servi->fetch_assoc()) {
                               
                  $descripcion = $row_servi['serv_desc'];
                  $umed = $row_servi['serv_umed'];
                  $precio = $precioh;
                  $iva = 0.00;
                 
               }}elseif ($flag == 'S') {
                  $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
                  while ($row_serv = $resultado_serv->fetch_assoc()) {
          
                  if ($tr==1) $precio = $row_serv['serv_costo'];
                  if ($tr==2) $precio = $row_serv['serv_costo2'];
                  if ($tr==3) $precio = $row_serv['serv_costo3'];
                  if ($tr==4) $precio = $row_serv['serv_costo4'];
                  
                  if ($precio == 0) $precio = $precioh;
                  $descripcion = $row_serv['serv_desc'];
                  $umed = $row_serv['serv_umed'];
                  $iva = $precio * 0.16;
                  
                  $tip_serv = $row_serv['tipo'];
                    
                  if ($tip_serv == "1") {$umed = 'LABORATORIO';}
                  if ($tip_serv == "2") {$umed = 'IMAGENOLOGIA';}
                  }
                } else if ($flag == 'P'||$flag == 'PC') {
                  $resultado_prod = $conexion->query("SELECT * FROM item i, item_type it where 
                    i.item_id = $insumo and it.item_type_id=i.item_type_id ") or die($conexion->error);
                  while ($row_prod = $resultado_prod->fetch_assoc()) {
                    
                    $descripcion = $row_prod['item_name'];
                     if ($flag == 'P') {
                        $umed = 'FARMACIA, '.$row_prod['item_type_desc'];
                    } else {
                        $umed = 'QUIRÓFANO, '.$row_prod['item_type_desc'];
                    }
                    $precio = $precioh;
                    $iva = $precio * 0.16;
                    
                  }
                } 
                 

                $cant = $row3['cta_cant'];
                $precio2 = $precio + $iva;
                $subtottal = $precio2 * $cant;
                $subtottalsi = $preciosiva * $cant;
                
                $cta_fec=date_create($row3['cta_fec']);
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . date_format($cta_fec,"d-m-Y H:i:s") . '</td>'
                  . '<td>' . $umed . '</td>'
                  . '<td>' . $descripcion . '</td>'
                  . '<td>' . $cant . '</td>'
                  . '<td> ' . number_format($precio, 2) . '</td>'
                  . '<td> ' . number_format($subtottal, 2) . '</td>'
                 ;
                
                   echo ' <td> <a type="submit" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal'.$id_ctapac.'" ><font color="white"><span class = "fa fa-trash"></span></font></a></td>';

                  echo '<div class="modal fade" id="exampleModal'.$id_ctapac.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel'.$id_ctapac.'" aria-hidden="true">
  
  <form action="" method="GET">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel'.$id_ctapac.'">¿Seguro que desea eliminar <strong><br>'.$descripcion.'?</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <input type="hidden" class="form-control" value="'.$id_ctapac.'" name="id_ctapac">
        <input type="hidden" class="form-control" value="'.$umed.'" name="umed">
        <input type="hidden" class="form-control" value="'.$cant.'" name="cant">
        <input type="hidden" class="form-control" value="'.$id_atencion.'" name="id_at">
        <input type="hidden" class="form-control" value="'.$id_exp.'" name="cant">
        <input type="hidden" class="form-control" value="'.$usuario1.'" name="id_usua">
        <input type="hidden" class="form-control" value="'.$rol.'" name="rol">
        <input type="hidden" class="form-control" value="'.$descripcion.'" name="descrip">
        <div class="container">Motivo
            <input type="text" class="form-control" name="motivo" class="form-control" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Regresar</button>
            <button type="submit" class="btn btn-danger" name="del_cta_dev"><font color="white">Eliminar</font></button>
        </div>
    </div>
  </div>
</div></form>';




if ($precio == 0 ) {
        
  echo ' <td> <a href="editarcuenta.php?id='.$id_ctapac.'&des='.$descripcion.'&id_at='.$id_atencion.'&id_exp='.$id_exp.'&id_usua='.$usuario1.'&rol='.$rol.'" type="button" class="btn btn-info btn-sm"><font color="white"><span class = "fa fa-edit"></span></font></a></td>';
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
              <td><?php echo number_format($total, 2); ?></td>
             
              <td></td>

            </tbody>
          </table>

        </div>
        <br />
       
        <center>
          <strong><h3 class="col-sm-3 control-label">Diferencia: </h3></strong>
          <div class="col-md-6">
            <strong><input type="text" class="form-control pull-right" value="$ <?php $diferencia = ($total + $totalsi)  - $total_dep; 
              $diferencia = round($diferencia, 2, PHP_ROUND_HALF_DOWN);
            echo number_format($diferencia, 2) ?>"  disabled></strong>
          </div>
        </center>
<!--eliminar-->

<?php 
if (isset($_GET['del_cta_dev'])) {

    $id_ctapac = $_GET['id_ctapac'];
    $fecha= date("Y-m-d H:i:s");

    $sql_cta = "SELECT * FROM dat_ctapac WHERE id_ctapac=$id_ctapac";
    $result_cta = $conexion->query($sql_cta);
        while ($row_cta = $result_cta->fetch_assoc()) {
          $prod_serv = $row_cta['prod_serv'];
          $insumo = $row_cta['insumo'];
          $cta_cant = $row_cta['cta_cant'];
        }

$paci=$pac_papell.' ' .$pac_sapell.' '.$pac_nom_pac;

$fecha_actual = date("Y-m-d H:i:s");
if($prod_serv == 'P'){
    $sql_dev = "INSERT INTO devolucion(dev_item,dev_qty,dev_estatus,fecha,id_usua,paciente)VALUES($insumo,$cta_cant,'SI','$fecha_actual',$id_usua,'$paci')";
    $result_dev = $conexion->query($sql_dev);
    $sql2 = "DELETE FROM dat_ctapac WHERE id_ctapac = $id_ctapac"; $result_dev1 = $conexion->query($sql2);
}elseif ($prod_serv == 'PC') {
    $sql_dev_ceye = "INSERT INTO devolucion_ceye(dev_producto,dev_cantidad,dev_estatus,fecha,id_usua,paciente)VALUES($insumo,$cta_cant,'SI','$fecha_actual',$id_usua,'$paci')"; $result_dev_ceye = $conexion->query($sql_dev_ceye);
    $sql2 = "DELETE FROM dat_ctapac WHERE id_ctapac = $id_ctapac"; $result = $conexion->query($sql2);
}else {
    $sql3 = "DELETE FROM dat_ctapac WHERE id_ctapac = $id_ctapac"; $result_serv = $conexion->query($sql3);
}

$motivo=$_GET['motivo'];
$cant=$_GET['cant'];
$umed=$_GET['umed'];
$id_at=$_GET['id_at'];
$id_usua=$_GET['id_usua'];
$descripcion=$_GET['descrip'];

$sql_reporte = "INSERT INTO cuentas_reporte(id_atencion,id_usua,id_ctapac,descripcion,servicio,cantidad,motivo,fecha)VALUES($id_at,$id_usua,$id_ctapac,'$descripcion',$umed,$cant,'$motivo','$fecha_actual')"; 
$result_dev_ceyere = $conexion->query($sql_reporte);
   
        echo '<script type="text/javascript"> window.location.href="detalle_cuenta.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '";</script>';
    
}
?>

<br/>
<br/>
<br/>

<?php 
$sql_cart = "SELECT * FROM cart where paciente = $id_atencion ORDER BY paciente";
$result_cart = $conexion->query($sql_cart);

while ($row_cart = $result_cart->fetch_assoc()) {
  $cart_id = $row_cart['cart_id'];
}

if(isset($cart_id)){
    $cart_id = $cart_id;
  }else{
    $cart_id ='nada';
  }


//echo $alta_med;
?>

        <?php
        if ($alta_med == "SI" && $alta_adm== "NO" && $diferencia== 0 && 
        $cartf_id == "nada" && 
        $carth_id == "nada" &&
        $cartq_id == "nada" && 
        $carte_id == "nada" && 
        $cartm_id == "nada" && 
        $cartc_id == "nada" 
        ){
         
            
        ?>
          <center>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Cerrar Cuenta
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Favor de verificar que el paciente egresa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     ¿Esta seguro de cerrar la cuenta?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">No, regresar</button>
         <a type="submit" class="btn btn-primary btn-md" href="valida_cuenta.php?q=cerrar&id_atencion=<?php echo $id_atencion ?>&id_usua=<?php echo $usuario1 ?>&dif=<?php echo $diferencia ?>&total=<?php echo $total ?>">Si, cerrar cuenta.</a>
       
      </div>
    </div>
  </div>
</div>
           
          </center><br>
        <?php
        }elseif ($alta_med == "SI" && $alta_adm== "SI"){
        ?>
        <div class="container">
          <div class="row">
            <?php $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua']; ?>
          <!--  <div class="col-sm-1">
             <a type="submit" class="btn btn-danger btn-sm" href="facturacion.php?id_atencion=<?php echo $id_atencion ?>" target="blank">Facturación</a>
          </div>-->
            <div class="col-sm">
              <center>
               <a type="submit" class="btn btn-primary btn-md" href="cuenta.php?id_atencion=<?php echo $id_atencion?>&id_usua= <?php echo $id_usua ?>" target="blank">Cuenta final</a>
              </center>
            </div>
            <div class="col-sm">
             <a href="excel.php?id_atencion=<?php echo $id_atencion ?>&id_usua=<?php echo $usuario1 ?>">
              <button type="button" class="btn btn-warning"><img src="https://img.icons8.com/color/48/000000/ms-excel.png"/><strong>Exporta a excel</strong></a>
          </div>
            <div class="col-sm">
              <center>
               <a type="submit" class="btn btn-primary btn-md" href="pdf/pdf_recibo_pago.php?id_exp= <?php echo $id_exp ?>&id_atencion= <?php echo $id_atencion ?>" target="blank">Recibo de pago</a>
              </center>
            </div>
            <div class="col">
              <center>
               <a type="submit" class="btn btn-primary btn-md" href="pdf/pase.php?id_atencion=<?php echo $id_atencion?>&id_exp= <?php echo $id_exp ?>" target="blank">Pase de salida</a>
              </center>
            </div>
          </div>
        </div><br>
        <?php 
        }elseif ($alta_med == "NO" && $diferencia == 0){
        ?>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show"><center><strong>Falta Alta Médica </strong></center></div>
          </div>
          </div>
        </div><br>
        <?php 
        }
        ?>

        <?php

       // echo $diferencia; 
        
       if($diferencia == 0){
        ?>
          <div class="col-md-12">
            <div class="alert alert-success alert-dismissible fade show"><center><strong>Cuenta sin diferencias </strong></center></div>
          </div>
          <?php
        }elseif($diferencia != 0){ ?>
            <div class="col-md-12">
              <div class="alert alert-warning alert-dismissible fade show"><center><strong>Hay una diferencia en la cuenta por   $  <?php echo $diferencia; ?> </strong></center>
              </div>
           </div>
    <?php } ?>
      
    <?php

    if (isset($_POST['btnserv'])) {
      $serv = mysqli_real_escape_string($conexion, (strip_tags($_POST["serv"], ENT_QUOTES))); //Escanpando caracteres
      $cant = mysqli_real_escape_string($conexion, (strip_tags($_POST["cant"], ENT_QUOTES))); //Escanpando

$fecha_actual = date("Y-m-d H:i:s");
if ($serv == 1 || $serv == 2 || $serv == 3 || $serv == 4 || $serv == 8 || $serv == 11){

$sql_dia_hab = "UPDATE dat_ingreso SET fecha_cama='$fecha_actual' WHERE id_atencion = $id_atencion";
        $result_dia_hab = $conexion->query($sql_dia_hab);

   $sql2 = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo,centro_cto)VALUES($id_atencion,'S', $serv,'$fecha_actual',$cant,0,$usuario1,'SI','$area')";
      $result = $conexion->query($sql2);
}else{
      $sql2 = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo,centro_cto)VALUES($id_atencion,'S', $serv,'$fecha_actual',$cant,0,$usuario1,'SI','$area')";
      $result = $conexion->query($sql2);
}

      echo '<script type="text/javascript"> window.location.href="detalle_cuenta.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '";</script>';
    }
    ?>


    <div class="container box">
      <div class="content">



           <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                         <tr><strong><center>AGREGAR PAGOS A LA CUENTA</strong> 
        </div>

        <form class="form-horizontal" id="fff" name="depocta" action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-4">
                <label>Forma de pago: </label>
                  <select name="banco" class="form-control" >
                    <option value="">Seleccionar</option>
                    <option value="EFECTIVO">EFECTIVO</option>
                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                    <option value="DEPOSITO">DEPOSITO</option>
                    <option value="TARJETA">TARJETA</option>
                    <option value="ASEGURADORA">ASEGURADORA</option>
                    <option value="CUENTAS POR COBRAR">CUENTAS POR COBRAR</option>     
                    <option value="COASEGURO">COASEGURO</option>   
                    <option value="DESCUENTO">DESCUENTO</option>
                    <option value="DEDUCIBLE">DEDUCIBLE</option>
                    <option value="COASEGURO H.">COASEGURO H.</option>
                    <option value="COPAGO">COPAGO</option>
                  </select>
            </div>
             <div class="col-md-4">
                <label for="resp">Detalle: </label><br>
                <input type="text" name="resp" placeholder="Banco, tipo de tarjeta, No. de tarjeta, etc." id="resp" maxlength="60" class="form-control" >
            </div>
            <div class="col-md-4">
                <label>Cantidad $:</label>
                <input type="text" name="deposito" class="form-control" onkeypress="return SoloNumeros(event);"  class="form-control">
            </div>
          </div>
          <br>
            <center>
               <input type="submit" name="btndatfin" id="depocta" class="btn btn-block btn-success col-sm-3" value="GUARDAR DEPÓSITO">
            </center>
        </form>
       

       


        <hr class="new4">
        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search_dep" placeholder="Buscar...">
        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #2b2d7f; color: white;">
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Forma de pago</th>
                <th>Detalle</th> 
                <th>Cantidad</th>
                <th>Personal </th>
                <th></th>
              </tr>
            </thead>
            <tbody>

              <?php
              $usuario = $_SESSION['login'];
              $id_usua=$usuario['id_usua'];
              $resultado4 = $conexion->query("SELECT * FROM dat_financieros df,reg_usuarios reg where df.id_atencion = $id_atencion and df.id_usua=reg.id_usua") or die($conexion->error);
              $total_dep = 0;
              $no = 1;
              while ($row4 = $resultado4->fetch_assoc()) {
                $fecha=date_create($row4['fecha']);
                $id_datfin=$row4['id_datfin'];
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . date_format($fecha,"d-m-Y H:i:s") . '</td>'
                  . '<td> ' . $row4['banco'] . '</td>'
                  . '<td>' . $row4['resp'] . '</td>'
                  . '<td>$ ' . number_format($row4['deposito'], 2) . '</td>'
                  . '<td>' .$row4['papell'].' '.$row4['sapell']. '</td>';
               if ($rol == 5 || $rol == 1) {
                  echo ' <td><a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_deposito.php?id_exp=' . $id_exp . '&id_atencion=' . $id_atencion . '&id_datfin=' . $row4['id_datfin'] . '&id_usua=' . $id_usua . '" target="_blank"><span class="fa fa-file-pdf-o"</span></a>
                   
                   <a type="submit" class="btn btn-danger btn-sm" href="elimina_detallecta.php?q=del_dep&id_datfin=' . $row4['id_datfin'] . '&id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '"><span class = "fa fa-trash"></span></a>
                   
                                         <a type="submit" class="btn btn-success btn-sm" title="ANTICIPO"
                     href="facturacion_i.php?id_exp=' . $id_exp . '&id_atencion=' . $id_atencion . '&id_datfin=' . $row4['id_datfin'] . '&id_usua=' . $id_usua . '&deposito=' . $row4['deposito'] . '" target="_blank"><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i></a>
                     
                     <a type="submit" class="btn btn-primary btn-sm" title="FACTURA NORMAL"
                     href="facturacion_pnormal.php?id_exp=' . $id_exp . '&id_atencion=' . $id_atencion . '&id_datfin=' . $row4['id_datfin'] . '&id_usua=' . $id_usua . '&deposito=' . $row4['deposito'] . '" target="_blank"><span class="fa fa-file-o"</span></a>
                   </td>';
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

      </div>
      <?php

      if (isset($_POST['btndatfin'])) {
        $usuario = $_SESSION['login'];
        $id_usua=$usuario['id_usua'];
        $resp = mysqli_real_escape_string($conexion, (strip_tags($_POST["resp"], ENT_QUOTES))); 
        $dir_resp = mysqli_real_escape_string($conexion, (strip_tags($_POST["dir_resp"], ENT_QUOTES))); 
        $tel = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel"], ENT_QUOTES))); 
        $banco = mysqli_real_escape_string($conexion, (strip_tags($_POST["banco"], ENT_QUOTES))); 
        $deposito = mysqli_real_escape_string($conexion, (strip_tags($_POST["deposito"], ENT_QUOTES))); 
        //$dep_l = mysqli_real_escape_string($conexion, (strip_tags($_POST["dep_l"], ENT_QUOTES))); 
   
//Incluímos la clase pago
$deposito;
require_once "CifrasEnLetras.php";
$v=new CifrasEnLetras(); 
//Convertimos el total en letras
$letra=($v->convertirEurosEnLetras($deposito));
$dep_l=strtoupper($letra);


$fecha_actual = date("Y-m-d H:i:s");
if($banco=="DEVOLUCION" && $deposito <0){
$sql_df = "INSERT INTO dat_financieros(id_atencion,aseg,resp,dir_resp,tel,aval,banco,deposito,dep_l,fec_deposito,total_cta,saldo,fecha,id_usua)values($id_atencion,'NINGUNA','$resp','$dir_resp','$tel','$resp','$banco',$deposito,'$dep_l','$fecha_actual', 0.00,0.00,'$fecha_actual',$id_usua)";
$result_df = $conexion->query($sql_df);
}elseif( $banco=="DEVOLUCION" && $deposito > 0){
  $deposito=$deposito*-1;
$sql_df = "INSERT INTO dat_financieros(id_atencion,aseg,resp,dir_resp,tel,aval,banco,deposito,dep_l,fec_deposito,total_cta,saldo,fecha,id_usua)values($id_atencion,'NINGUNA','$resp','$dir_resp','$tel','$resp','$banco',$deposito,'$dep_l','$fecha_actual', 0.00,0.00,'$fecha_actual',$id_usua)";
$result_df = $conexion->query($sql_df);
}else{
  $sql_df = "INSERT INTO dat_financieros(id_atencion,aseg,resp,dir_resp,tel,aval,banco,deposito,dep_l,fec_deposito,total_cta,saldo,fecha,id_usua)values($id_atencion,'NINGUNA','$resp','$dir_resp','$tel','$resp','$banco',$deposito,'$dep_l','$fecha_actual', 0.00,0.00,'$fecha_actual',$id_usua)";
$result_df = $conexion->query($sql_df);
}


        
        if ($result_df) {
          echo '<script type="text/javascript"> window.location.href="detalle_cuenta.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '";</script>';
        } else {
          echo $sql_df;
          echo '<h1>ERROR AL INSERTAR';
        }
      }
      ?>
  </section>
  
  </div>
  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>

  <script type="text/javascript">
    function otros() {
      var option1 = document.getElementById('serv').value;
      var form_otros = document.getElementById('form_otros');
      <?php
      $query_1 = "SELECT * FROM `cat_servicios` where serv_desc = 'OTROS'";
      $result_1 = $conexion->query($query_1);
      //$result = mysql_query($query);
      while ($row_1 = $result_1->fetch_assoc()) {
        $otros_opc = $row_1['id_serv'];
      }
      $query_2 = "SELECT * FROM `cat_servicios` where serv_desc = 'HONORARIOS'";
      $result_2 = $conexion->query($query_2);
      //$result = mysql_query($query);
      while ($row_2 = $result_2->fetch_assoc()) {
        $otros_opc2 = $row_2['id_serv'];
      }
      ?>

      var opc_otr1 = <?php echo $otros_opc ?>; // otros
      var opc_otr2 = <?php echo $otros_opc2 ?>; //honorarios
      if (option1 == opc_otr1) {
        form_otros.innerHTML = '<hr class="new4">' +
          '<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">' +
          '<center> <h4> DESCRIBIR OTROS SERVICIOS </h4></center>'+
          '<div class="row">'+
          '<div class="col-md-6">' +
          '<label>DESCRIPCIÓN (OTROS): </label>' +
          '<input tipe"text" class="form-control"  name="desc_otros" id="desc_otros" required>'+
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
      }else if(option1 == opc_otr2){
form_otros.innerHTML = '<hr class="new4">' +
          '<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">' +
          '<center> <h4> DESCRIBIR HONORARIOS </h4></center>'+
          '<div class="row">'+
          '<div class="col-md-6">' +
          '<label>DESCRIPCIÓN (HONORARIOS): </label>' +
          '<select name="desc_hono" id="desc_hono" class="form-control" required><?php
              $sqlh = "SELECT * FROM cat_servicios where tipo = 7";
              $result = $conexion->query($sqlh);
              while ($rowh = $result->fetch_assoc()) {
                echo "<option value= ".$rowh['id_serv'] .">". $rowh['serv_desc'] . "</option>";
                 
              }
              ?>
            </select>'+
          '</div>' +
          '</div>' +
          '<div class="row">'+
          '<div class="col-md-6">'+
          '<label>CANTIDAD (HONORARIOS):</label>' +
          '<input id="cant_hono" name="cant_hono" placeholder="Inserta la cantidad" class="form-control input-md" type="number" min="0" step="1" required>' +
          '</div>' +
          '<div class="col-md-6">'+
          '<label>PRECIO (HONORARIOS):</label>' +
          ' <input id="precio_otros" name="precio_hono" placeholder="Inserta el precio" class="form-control input-md" type="number" min="0" step="0.01" required>' +
          '</div>' +
          '</div><br>'+
          ' <div class="col-sm-4">' +
          '<input type="submit" name="btnserv_hono" class="btn btn-block btn-success" value="GUARDAR HONORARIOS">' +
          '</div>' +
          '</form>';
      }
    }
  </script>

 <?php
      
        if (isset($_POST['btnserv_otros'])) {
          $desc_otros = mysqli_real_escape_string($conexion, (strip_tags($_POST["desc_otros"], ENT_QUOTES))); //Escanpando caracteres
          $cant_otros = mysqli_real_escape_string($conexion, (strip_tags($_POST["cant_otros"], ENT_QUOTES))); //Escanpando
          $precio_otros = mysqli_real_escape_string($conexion, (strip_tags($_POST["precio_otros"], ENT_QUOTES))); //Escanpando

          // $sql6 = "INSERT INTO serv_otros(desc_otros,cant_otros,precio_otros)VALUES('$desc_otros',$cant_otros,$precio_otros)";
          // $result = $conexion->query($sql6);

$fecha_actual = date("Y-m-d H:i:s");
          $sql5 = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo,centro_cto)VALUES($id_atencion,'$desc_otros', 0,'$fecha_actual',$cant_otros,$precio_otros,$usuario1,'SI','$area')";
          $result = $conexion->query($sql5);


          echo '<script type="text/javascript"> window.location.href="detalle_cuenta.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '";</script>';
        }
        ?>

  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>
</html>