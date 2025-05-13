<?php
session_start();
//include "../../conexionbd.php";
include "../header_administrador.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);

$usuario = $_SESSION['login'];
$id_usua=$usuario['id_usua'];
$usuario1=$usuario['id_usua'];
$rol = $usuario['rol'];
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

  <title>Cuenta del paciente</title>
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
   //     $usuario1 = $_GET['id_usua'];
       $rol = $_GET['rol'];

        //$resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        
        $id_exp = $_GET['id_exp'];
        $id_atencion = $_GET['id_at'];


        $resultado_total = $conexion->query("SELECT * FROM dat_financieros where id_atencion = $id_atencion and banco != 'DESCUENTO'") or die($conexion->error);
        $total_dep = 0;
        
        while ($row_total = $resultado_total->fetch_assoc()) {
          $total_dep = $row_total['deposito'] + $total_dep;
        }
        
        $resultado_totald = $conexion->query("SELECT * FROM dat_financieros where id_atencion = $id_atencion and banco = 'DESCUENTO'") or die($conexion->error);
        $total_desc = 0;
       
        while ($row_totald = $resultado_totald->fetch_assoc()) {
          $total_desc = $row_totald['deposito'] + $total_desc;
        }
        //  $diferencia = $total - $total_dep;


        $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.*  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
          $fec_egreso = $row_pac['fec_egreso'];
          $area = $row_pac['area'];
          $alta_med = $row_pac['alta_med'];
          $alta_adm = $row_pac['alta_adm'];
          $valida = $row_pac['valida'];
          $area = $row_pac['area'];
          $id_exp=$row_pac['Id_exp'];
          $correo = $row_pac['correo'];
          $cama_alta = $row_pac['cama_alta'];
          $dat_now = $row_pac['fec_egreso'];
        }

        $sql_est = "SELECT DATEDIFF( fec_egreso , fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";
        $result_est = $conexion->query($sql_est);

        while ($row_est = $result_est->fetch_assoc()) {
          $estancia = $row_est['estancia'];
        }
        if ($estancia == 0) {
            $estancia = $estanca + 1;
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
        
 ?>
 
       
  
        <br>
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                         <tr><strong><center>CUENTA DEL PACIENTE</center></strong>
        </div>
        
        <div class="container">
           <div class="row">
             <div class="col-sm-8">
              <label class="control-label">Paciente: </label><strong> &nbsp; <?php echo $id_exp.' - '.$pac_papell.' ' .$pac_sapell.' '.$pac_nom_pac ?></strong>
             </div>

             <?php
            $pac_fecing=date_create($pac_fecing);
            $fec_egreso=date_create($fec_egreso);
             ?>

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
                      echo ' '.$tr;
                      }
                      ?></strong>
                
            </div>
            <div class="col-md-4">
          
                 <label class="control-label">Fecha de ingreso: </label><strong>  &nbsp; <?php echo date_format($pac_fecing,"d/m/Y H:i a") ?></strong>
              
            </div>
            <div class="col-md-4">
                 <label class="control-label">Fecha de egreso: </label><strong>  &nbsp; <?php echo date_format($fec_egreso,"d/m/Y H:i a") ?></strong>
            </div>

            <div class="col-md-3">
                <label class="control-label">Días de estancia: </label><strong> &nbsp; <?php echo $estancia ?> días</strong>
            </div>
            
            <div class="col-md-4">
                <label class="control-label">Cama: </label><strong> &nbsp; <?php echo $cama_alta .' - '.$area  ?></strong>
            </div>
          </div> 
        </div>
       </div>
      
      
     
        <!--/************************************************************************************/-->
        <div class="table-responsive">
          
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
                $iva = $precioh * 0.16;
       
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
   

<!--email-->



<?php 
$sql_cart = "SELECT * FROM cart where paciente = $id_atencion ORDER BY paciente";
$result_cart = $conexion->query($sql_cart);

while ($row_cart = $result_cart->fetch_assoc()) {
  $cart_id = $row_cart['cart_id'];
}

$id_encuesta = 'SI';

//echo $alta_med;
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
              <div class="alert alert-warning alert-dismissible fade show"><center><strong>Hay una diferencia en la cuenta por   $  <?php echo number_format($diferencia, 2); ?> </strong></center>
              </div>
           </div>
    <?php } ?>
      
    <div class="container box">
      <div class="content">

 
        <div class="thead" style="background-color: #006777; color: white; font-size: 20px;">
                         <tr><strong><center>PAGOS</center></strong>
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
              $resultado4 = $conexion->query("SELECT * FROM dat_financieros df, reg_usuarios reg where df.banco <> 'DESCUENTO' AND df.id_atencion = $id_atencion and df.id_usua=reg.id_usua") or die($conexion->error);
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
                  echo ' <td><a type="submit" class="btn btn-danger btn-sm" title="RECIBO"
                     href="pdf_deposito.php?id_exp=' . $id_exp . '&id_atencion=' . $id_atencion . '&id_datfin=' . $row4['id_datfin'] . '&id_usua=' . $id_usua . '" target="_blank"><span class="fa fa-file-pdf-o"</span></a>

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
              <td>Total pagos</td>
              <td><?php echo "$ " . number_format($total_dep, 2); ?></td>
              <td></td>
            </tbody>
          </table>
          
        </div>
        <div class="thead" style="background-color: #006777; color: white; font-size: 20px;">
                         <tr><strong><center>DESCUENTOS</center></strong>
        </div>
        

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #2b2d7f; color: white;">
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Detalle</th> 
                <th>Cantidad</th>
                <th>Personal </th>
              </tr>
            </thead>
            <tbody>

              <?php
             
              $resultado4d = $conexion->query("SELECT * FROM dat_financieros df, reg_usuarios reg where df.banco = 'DESCUENTO' AND df.id_atencion = $id_atencion and df.id_usua=reg.id_usua") or die($conexion->error);
              $total_desc = 0;
              $no = 1;
              while ($row4d = $resultado4d->fetch_assoc()) {
                $fecha=date_create($row4d['fecha']);
                $id_datfin=$row4d['id_datfin'];
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . date_format($fecha,"d-m-Y H:i:s") . '</td>'
                  . '<td> ' . $row4d['banco'] . '</td>'
                  . '<td>' . $row4d['resp'] . '</td>'
                  . '<td>$ ' . number_format($row4d['deposito'], 2) . '</td>'
                  . '<td>' .$row4d['papell'].' '.$row4d['sapell']. '</td>';
               if ($rol == 5 || $rol == 1) {
                 
               } else {
               
              }
                echo '</tr>';
                $total_desc = $row4d['deposito'] + $total_desc;
                $no++;
              }
              ?>
              <td></td>
              <td></td>
              <td></td>
              <td>Total descuentos</td>
              <td><?php echo "$ " . number_format($total_desc, 2); ?></td>
              <td></td>
            </tbody>
          </table>
          
        </div>
        <center>
        <div class="row">
         
                <div class="container">
          <div class="row">
            <?php $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua']; ?>
            
            <div class="col-sm">
              <center>
               <a type="submit" class="btn btn-primary btn-md" href="cuenta.php?id_atencion=<?php echo $id_atencion?>&id_usua= <?php echo $id_usua ?>" target="blank">Estado de cuenta</a>
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
            </div><br>
          </div>
        </div><br><br>
        </div>  
        </center>
      </div>
     <br>
 
  
  
        <!-- /***************************************************************/ -->
        <div class="thead" style="background-color: #006777; color: white; font-size: 20px;">
                         <tr><strong><center>DETALLE DE PRODUCTOS Y SERVICIOS</center></strong>
        </div>
        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:30%" id="search" placeholder="Buscar...">
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
                        $umed = 'Farmacia '.$row_prod['item_type_desc'];
                    } else {
                        $umed = 'Quirófano '.$row_prod['item_type_desc'];
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
                  . '<td> ' . number_format($precio2, 2) . '</td>'
                  . '<td> ' . number_format($subtottal, 2) . '</td>'
                 ;
                
                  


                
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


            </tbody>
          </table>

        </div>
        <br />
       

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



  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>
</html>