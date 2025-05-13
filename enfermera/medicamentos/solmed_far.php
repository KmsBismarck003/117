<?php
session_start();
include "../../conexionbd.php";
include "../header_enfermera.php";
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
<?php

    include "../../conexionbd.php";

    if (isset($_SESSION['pac'])) {
      $id_atencion = $_SESSION['pac'];
      $usuario = $_SESSION['login'];
      $usuario2 = $usuario['id_usua'];
      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias, di.activo, p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
        $pac_tip_sang = $row_pac['tip_san'];
        $pac_sexo = $row_pac['sexo'];
        $area = $row_pac['area'];
        $alta_med = $row_pac['alta_med'];
        $activo = $row_pac['activo'];
        $id_exp = $row_pac['Id_exp'];
        $alergias = $row_pac['alergias'];
        $folio = $row_pac['folio'];
      }

      $sql_pac = "SELECT * FROM  dat_ingreso WHERE id_atencion =$id_atencion";

          $result_pac = $conexion->query($sql_pac);

          while ($row_pac = $result_pac->fetch_assoc()) {
             $fingreso = $row_pac['fecha'];
             $fegreso = $row_pac['fec_egreso'];
             $alta_med = $row_pac['alta_med'];
             $alta_adm = $row_pac['alta_adm'];
             $activo = $row_pac['activo'];
             $valida = $row_pac['valida'];
          }

if($alta_med=='SI' && $alta_adm=='SI' && $activo=='NO' && $valida=='SI'){
    
    $sql_est = "SELECT DATEDIFF('$fegreso', '$fingreso') as estancia FROM dat_ingreso where id_atencion = $id_atencion";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
         $estancia = $row_est['estancia'];
       
      }
}else{
    
   $sql_now = "SELECT DATE_ADD(NOW(), INTERVAL 12 HOUR) as dat_now FROM dat_ingreso WHERE id_atencion = $id_atencion";

      $result_now = $conexion->query($sql_now);

      while ($row_now = $result_now->fetch_assoc()) {
        $dat_now = $row_now['dat_now'];
      }

      $sql_est = "SELECT DATEDIFF( '$dat_now' , fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
        $estancia = $row_est['estancia'];
      } 
}

  function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}

date_default_timezone_set('America/Guatemala');
$fecha_actual = date("Y-m-d");
$fecha_nac=$pac_fecnac;
$fecha_de_nacimiento =strval($fecha_nac);

// separamos en partes las fechas
$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
$array_actual = explode ( "-", $fecha_actual );

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

//ajuste de posible negativo en $días
if ($dias < 0)
{
    --$meses;

    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
    switch ($array_actual[1]) {
           case 1:     $dias_mes_anterior=31; break;
           case 2:     $dias_mes_anterior=31; break;
           case 3:     
               if (bisiesto($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
               
           case 4:     $dias_mes_anterior=31; break;
           case 5:     $dias_mes_anterior=30; break;
           case 6:     $dias_mes_anterior=31; break;
           case 7:     $dias_mes_anterior=30; break;
           case 8:     $dias_mes_anterior=31; break;
           case 9:     $dias_mes_anterior=31; break;
           case 10:     $dias_mes_anterior=30; break;
           case 11:     $dias_mes_anterior=31; break;
           case 12:     $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

//echo "<br>Tu edad es: $anos años con $meses meses y $dias días";

    ?>
    <div class="container">
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="../../template/menu_enfermera.php">Regresar</a>
                   </div>
               </div> 
              </div>
              <br>
<div class="container ">
        
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                 <tr><strong><center>SOLICITAR MEDICAMENTOS A FARMACIA</center></strong>
        </div>
           
         
 <font size="2">
         <div class="container">
  <div class="row">
    <div class="col-sm-6">
  
      Expediente: <strong><?php echo $folio?> </strong>
   
     Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    <div class="col-sm">
      Área: <strong><?php echo $area ?></strong>
    </div>
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm">
      Fecha de ingreso: <strong><?php echo date_format($date, "d/m/Y") ?></strong>
    </div>
  </div>
</div></font>

 <font size="2">
     <div class="container">
  <div class="row">
    <div class="col-sm">
       <?php $date1 = date_create($pac_fecnac);
   ?>
      Fecha de nacimiento: <strong><?php echo date_format($date1, "d/m/Y") ?></strong>
    </div>
    <div class="col-sm">
      Tipo de sangre: <strong><?php echo $pac_tip_sang ?></strong>
    </div>
   
    <div class="col-sm">
        Habitación: 
        <strong><?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
            $result_hab = $conexion->query($sql_hab);                                                                                    
            while ($row_hab = $result_hab->fetch_assoc()) {
                echo $row_hab['num_cama'];
            } ?>
        </strong>
    </div>
    <div class="col-sm">
      Tiempo estancia: <strong><?php echo $estancia ?> Dias</strong>
    </div>
  </div>
</div>
</font>
 <font size="2">
  <div class="container">
  <div class="row">
   <div class="col-sm-3">
      Edad: <strong><?php if($anos > "0" ){
   echo $anos." años";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." meses";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." dias";
}
?></strong>
    </div>
    <div class="col-sm-3">
Peso: <strong><?php $sql_vit = "SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_vit = $conexion->query($sql_vit);
while ($row_vit = $result_vit->fetch_assoc()) {
$peso=$row_vit['peso'];
}if(!isset($peso)){
    $peso=0;
}   echo $peso;?></strong>
    </div>
   <div class="col-sm">
      Talla: <strong><?php $sql_vitt =" SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_vitt = $conexion->query($sql_vitt); 
while ($row_vitt = $result_vitt->fetch_assoc()) {
$talla=$row_vitt['talla'];
}
if(!isset($talla)){
    $talla=0;
}   echo $talla;?></strong>
    </div>
    <div class="col-sm">
      Género: <strong><?php echo $pac_sexo ?></strong>
    </div>
  </div>
</div>
</font>
 <font size="2">
  <div class="container">
  <div class="row">
    <div class="col-sm-3">
      Alergias: <strong><?php echo $alergias ?></strong>
    </div>
    <div class="col-sm-6">
      Estado de salud: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud DESC LIMIT 1";
$result_edo = $conexion->query($sql_edo);                                                                                    while ($row_edo = $result_edo->fetch_assoc()) {
  echo $row_edo['edo_salud'];
} ?></strong>
    </div>
      
     <div class="col-sm">
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


               } ?></strong>
    </div>
  </div>
</div>
</font>
  <font size="2">
 <div class="col-sm-4">
  <?php 
$d="";
      $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by diagprob_i ASC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } ?>
    <?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
    $result_mot = $conexion->query($sql_mot);
    while ($row_mot = $result_mot->fetch_assoc()) {
    $m=$row_mot['motivo_atn'];
    } ?>

    <?php if ($d!=null) {
       echo '<td> Diagnóstico: <strong>' . $d .'</strong></td>';
    } else{
          echo '<td"> Motivo de atención: <strong>' . $m .'</strong></td>';
    }?>
    </div>
  </font>
        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../../template/select_pac_enf.php";</script>';
      }
        ?>
        </div>
    <p>
<body>

<?php
      if ($activo =='SI') {} 
      else {
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
        echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
        echo '<script>
                            $(document).ready(function() {
                                swal({
                                    title: "Cuenta del paciente cerrada, No es posible solicitar medicamentos a farmacia",
                                    type: "error",
                                    confirmButtonText: "ACEPTAR"
                                }, function(isConfirm) {
                                    if (isConfirm) {
                                        window.location.href = "../selectpac_sincama/select_pac.php";
                                    }
                                });
                            });
                        </script>';  
        
      }
      ?>

      <div class="container box">
        <div class="content">

          <center>
            <h4>Paciente: <?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></h4>
          </center>
          
        
          <center>
            <h5>Agregar medicamentos</h5>
          </center>


          <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label class="control-label col-sm-3" for="">Medicamento / Material:</label>
              <div class="col-md-12">
                <select class="selectpicker col-5" data-live-search="true" name="med" required>
                  <option value="">Seleccionar</option>
                  <?php
                  $sql = "SELECT * FROM item i, stock, item_type where controlado = 'NO' AND item_type.item_type_id=i.item_type_id and i.item_id = stock.item_id and stock.stock_qty != 0 ORDER BY i.item_name ASC";
                  $result = $conexion->query($sql);
                  while ($row_datos = $result->fetch_assoc()) {
                    echo "<option value='" . $row_datos['stock_id'] . "'>" . $row_datos['item_name'] . ', '.  $row_datos['item_grams'] . "</option>";
                  }
                  ?>
                  
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-3" for="">Cantidad:</label>
              <div class="col-sm-3">
                <input type="number" min="1" step="1" class="form-control" name="qty" required="">
              </div>
            </div>
            <div class="col-sm-4">
              <input type="submit" name="btnserv" class="btn btn-block btn-success" value="Agregar">
            </div>
          </form>
          <br>
          <br>
          <br>

        </div>
      </div>
<?php
if (isset($_POST['btnserv'])) {
      $stock_id = $_POST['med'];
      
      $qty = mysqli_real_escape_string($conexion, (strip_tags($_POST["qty"], ENT_QUOTES))); //Escanpando
      
      $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
      $result_aseg = $conexion->query($sql_aseg);
      while ($row_aseg = $result_aseg->fetch_assoc()) {
             $at=$row_aseg['aseg']; 
      }
      $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
      while($filat = mysqli_fetch_array($resultadot)){ 
            $tr=$filat["tip_precio"];
      }
      
      $sql = "SELECT * FROM item, stock, item_type where controlado = 'NO' AND item_type.item_type_id=item.item_type_id and item.item_id = stock.item_id and stock.stock_qty != 0 and stock_id = $stock_id";
      $result = $conexion->query($sql);
      while ($row_medicamentos = $result->fetch_assoc()) {
        $stock_qty = $row_medicamentos['stock_qty'];
        $stock_min = $row_medicamentos['item_min'];
        $item_id = $row_medicamentos['item_id'];
        if ($tr==1) $precio = $row_medicamentos['item_price'];
        if ($tr==2) $precio = $row_medicamentos['item_price2'];
        if ($tr==3) $precio = $row_medicamentos['item_price3'];
        if ($tr==4) $precio = $row_medicamentos['item_price4'];
      }

      
      

      $cart_uniquid = uniqid();
      $stock = $stock_qty - $qty;
      if (!($stock < $stock_min)) {

        $sql2 = "INSERT INTO cart_enf(item_id,cart_qty,cart_price,cart_stock_id,id_usua,cart_uniqid, paciente,tipo)VALUES($item_id,$qty,$precio, $stock_id,$usuario2,'$cart_uniquid', $id_atencion,'$area')";


        $result = $conexion->query($sql2);
/*
        $sql2 = "UPDATE stock set stock_qty=$stock where stock_id = $stock_id";
        $result = $conexion->query($sql2);
*/
        echo '<script>
              window.location.href = "solmed_far.php?paciente=' . $id_atencion . '";
              </script>';
      } else {
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
        echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
        echo '<script>
                            $(document).ready(function() {
                                swal({
                                    title: "Favor de verificar existencias con farmacia",
                                    type: "error",
                                    confirmButtonText: "ACEPTAR"
                                }, function(isConfirm) {
                                    if (isConfirm) {
                                        window.location.href = "solmed_far.php?paciente=' . $id_atencion . '";
                                    }
                                });
                            });
                        </script>';
      }
    }
    ?>

 <div class="container box">
        <div class="content">

          <center>
            <h4>Vale de medicamentos</h4>
          </center>

          <div class="form-group">
            <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
          </div>

          <div class="table-responsive">
            <!--<table id="myTable" class="table table-striped table-hover">-->

            <table class="table table-bordered table-striped" id="mytable">

              <thead class="thead" style="background-color: #2b2d7f;color:white;">
                <tr>
                  <th>Descripción</th>
                  <th>Cantidad</th>
                  <?php 
                 $usuario=$_SESSION['login'];
                 $rol=$usuario['id_rol'];
                  if($rol== 5){ ?>
                  <th>Sub. total</th>
                  <th>Total</th><?php } ?>
                  <th>Solicitante</th>
                  <th>Paciente</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
            
                $resultado2 = $conexion->query("SELECT * from paciente p, dat_ingreso di, cart_enf c, item i where di.id_atencion = c.paciente and di.Id_exp = p.Id_exp and di.id_atencion = $id_atencion and i.item_id = c.item_id") or die($conexion->error);
                $no = 1;
                $total = 0;
                while ($row = $resultado2->fetch_assoc()) {
                  $id_cart_enf = $row['cart_id'];
                  $id_usua = $row['id_usua'];
                  $sql4 = "SELECT papell FROM reg_usuarios where id_usua = $id_usua ";
                  $result4 = $conexion->query($sql4);
                  while ($row_usua = $result4->fetch_assoc()) {
                    $solicitante = $row_usua['papell'];
                  }
                  if ($tr==1) $precio = $row['item_price'];
                  if ($tr==2) $precio = $row['item_price2'];
                  if ($tr==3) $precio = $row['item_price3'];
                  if ($tr==4) $precio = $row['item_price4'];

                  $subtotal = $precio * $row['cart_qty'];
                  $total += $subtotal;
                  if($rol== 5){
                  echo '<tr>'
                    . '<td>' . $row['item_name'] . ', ' . $row['item_grams'] .'</td>'
                    . '<td>' . $row['cart_qty'] . '</td>'
                    . '<td> $' . number_format($precio, 2) . '</td>'
                    . '<td>$ ' . number_format($subtotal, 2) . '</td>'
                    . '<td>' . $solicitante . '</td>'
                    . '<td>' . $row['papell'] . " " . $row['sapell']  . " " . $row['nom_pac']. '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="manipulacar.php?q=del_car&cart_stock_id=' . $row['cart_stock_id'] . '&cart_qty=' . $row['cart_qty'] . '&paciente=' . $id_atencion . '&cart_id=' . $row['cart_id'] . '"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $no++;
                }else{
                  echo '<tr>'
                    . '<td>' . $row['item_name'] . ', ' . $row['item_grams'] .'</td>'
                    . '<td>' . $row['cart_qty'] . '</td>'
                    . '<td>' . $solicitante . '</td>'
                    . '<td>' . $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell'] . '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="manipulacar.php?q=del_car&cart_stock_id=' . $row['cart_stock_id'] . '&cart_qty=' . $row['cart_qty'] . '&paciente=' . $id_atencion . '&cart_id=' . $row['cart_id'] . '"><span class = "fa fa-trash"></span></a></td>';
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
                echo '<a type="submit" class="btn btn-success col-3 btn-block" href="manipulacar.php?q=comf_cart&paciente=' . $id_atencion . '&id_usua=' . $usuario2 . '"><span>Confirmar</span></a>';
                ?>
              </center>
            </div>
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