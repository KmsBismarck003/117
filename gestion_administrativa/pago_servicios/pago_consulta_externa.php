<?php
session_start();
include "../../conexionbd.php";
include "../../gestion_administrativa/header_administrador.php";
$resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE  dat_ingreso.activo='SI' AND alta_adm = 'NO'") or die($conexion->error);
?>
<!DOCTYPE html>
<html>
<head>
      <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>



    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>

<style type="text/css">
    #contenido{
        display: none;
    }
</style>
    <title>Menu Gestión Administrativa </title>
    <link rel="shortcut icon" href="logp.png">
</head><?php 
if (isset($_GET['nombre'])) {
    
}else{
 ?>
<div class="container">
    <div class="row">
     <div class="col-sm-4">
            <a href="vista_pago_consulta.php"><button type="button" class="btn btn-danger" >CONSULTAS REGISTRADAS PENDIENTES DE PAGO</button></a>
    </div>
    </div>
</div><br>
<div class="container">
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                 <tr><strong><center>PAGO DE SERVICIOS</center></strong>
</div>

<div class="container box">
    <form action="" method="POST">
    <div class="row">
        <div class="col-sm-2"></div><br>
       
        <div class="col-sm-4">
        
        <input type="text" name="nombre"  class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
        </div>
         <div class="col-sm-4">
        <br><input type="submit" name="btnpac" class="btn btn-block btn-alert" value="ELABORAR PAGO DE SERVICIOS">
        </div>
    </div></form><br>
</div>
<?php }
if (isset($_POST['btnpac'])) {
    include "../../conexionbd.php";
    $usuario=$_SESSION['login'];
    $id_usua=$usuario['id_usua'];
    
$fecha= date("Y-m-d H:i:s");
    $select="SELECT * FROM reg_usuarios where id_usua=$id_usua";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $usuario=$row['papell'].' '.$row['sapell'];
    }
    
    $nombre =  mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES)));

$insert="INSERT INTO pserv(nombre,fecha,usuario,tipo) values('$nombre','$fecha','$usuario','Consulta')";
$result_insert=$conexion->query($insert);

$select_pac="SELECT * FROM pserv ORDER BY id_pac DESC LIMIT 1";
    $result_pac=$conexion->query($select_pac);
    while ($row=$result_pac->fetch_assoc()) {
    $id_pac=$row['id_pac'];
    }

echo '<script type="text/javascript">window.location.href = "pago_consulta_externa.php?nombre='.$nombre.'&id_pac='.$id_pac.'";</script>';
}

if (isset($_GET['nombre'])) { $nombre=$_GET['nombre'];?>
<div class="container box">
    <a href="vista_pago_consulta.php"><button type="button" class="btn btn-danger">REGRESAR</button></center></a>
    <center><h3>Nombre del paciente<?php echo ':  '. $nombre; ?></h3></center><br>
    <div class="row">
        <div class="col-sm-1"></div>
        <form action="" method="POST">
         <div class="row">
            <div class="col-sm-8">
              Servicio:<br><select data-live-search="true" id="mibuscador" name="serv" class="form-control" onchange="return mostrar();">
                <option value="">Seleccionar</option>
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
            Cantidad:<br><input type="number" name="cantidad" class="form-control" value="">
            </div>
            <div class="col-sm-2">
            <br><input type="submit" name="btnserv" class="btn btn-block btn-success" value="Agregar">
            </div> 
          </div>
        </form>
    </div>
    <div class="row">
        <form action="" method="POST">
         <div class="row">
            <div class="col-sm-8">
              Medicamentos y materiales:<br><select data-live-search="true" id="mibuscador2" name="med" class="form-control" required>
                <option value="">Seleccionar</option>
             <?php
               $sql_serv = "SELECT * FROM item ";
                   $result_serv = $conexion->query($sql_serv);
                    while ($row_serv = $result_serv->fetch_assoc()) {
                       echo "<option value='" . $row_serv['item_id'] . "'>" . $row_serv['item_name'] .', '. $row_serv['item_grams'] . "</option>";
                                    }
              ?>
                </select>  
            </div>
            <div class="col-sm-2">
            Cantidad:<br><input type="number" name="cantidad" class="form-control" value="">
            </div>
            <div class="col-sm-2">
            <br><input type="submit" name="btnmed" class="btn btn-block btn-success" value="Agregar">
            </div> 
          </div>
        </form>
    </div>    
<!--    <div class="row">
        <div class="col-sm-1"></div>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <label >MEDICAMENTO DE FARMACIA:</label>
        <div class="row">
            
              <div class="col-md-7">
                <select class="form-control" id="mibuscador3" data-live-search="true" name="med" required>
                   <option value="">SELECCIONA UN MEDICAMENTO</option>
                  <?php
                  $sql = "SELECT * FROM item i, stock, item_type where controlado = 'NO' AND item_type.item_type_id=i.item_type_id and i.item_id = stock.item_id and stock.stock_qty != 0 ORDER BY i.item_name ASC";
                  $result = $conexion->query($sql);
                  while ($row_datos = $result->fetch_assoc()) {
                    echo "<option value='" . $row_datos['stock_id'] . "'>" . $row_datos['item_name'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-2">
                CANTIDAD:<br><input type="number" class="form-control" name="qty" required="">
              </div>
            <div class="col-sm-2">
              <input type="submit" name="btnfar" class="btn btn-block btn-success" value="AGREGAR">
            </div>
        </div>
          </form>
    </div>-->
    <hr>
   <div class="row">
        
        <form action="" method="POST">
            <label><strong>OTROS:</strong></label><br>
         <div class="row">
            <div class="col-sm-6">
              <label>Descripción:</label><br>
              <input type="text" name="desc" class="form-control" placeholder="Describir otros servicios" class="form-control">  
            </div>
            <div class="col-sm-2">
            <label>Cantidad:</label><br><input type="number" placeholder="Cantidad" name="cant" class="form-control" value="">
            </div>
            <div class="col-sm-2">
            <label>Precio:</label><br><input type="number" name="prec" placeholder="Precio"  min="0" step="0.01" class="form-control" value="">
            </div>
            <div class="col-sm-2">
            <br><input type="submit" name="btnotros" class="btn btn-block btn-success" value="Agregar">
            </div> 
          </div>
        </form>
    </div> <br>   

<!--  inicio de insertar al carrito de pago de servicios -->
    <?php 
    $usuario=$_SESSION['login'];
    $id_usua=$usuario['id_usua'];
    if (isset($_POST['btnserv'])) {
        include "../../conexionbd.php";
        $nombre=mysqli_real_escape_string($conexion, (strip_tags($_GET["nombre"], ENT_QUOTES)));
        $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac"], ENT_QUOTES)));
        $id_amb=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_amb"], ENT_QUOTES)));
        $serv_id =  mysqli_real_escape_string($conexion, (strip_tags($_POST["serv"], ENT_QUOTES)));
        $cantidad =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));
        $tipo = "Consulta";
        $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $serv_id") or die($conexion->error);
        while ($row_serv = $resultado_serv->fetch_assoc()) {
                    $descripcion = $row_serv['serv_desc'];
                    $serv_costo = $row_serv['serv_costo'];
                  }
                  
        $fecha_actual = date("Y-m-d H:i:s");

        $ingresar2 = mysqli_query($conexion, 'INSERT INTO pago_serv (id_pac,nombre,id_serv,servicio,cantidad,precio,fecha,usuario,tipo) values ('.$id_pac.',"'.$nombre.'","' . $serv_id . '","' . $descripcion .'",' . $cantidad . ',' . $serv_costo . ',"'.$fecha_actual.'",'.$id_usua.',"'.$tipo.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

echo '<script type="text/javascript">window.location.href = "pago_consulta_externa.php?id_pac='.$id_pac.'&nombre='.$nombre.'&id_amb='.$id_amb.'";</script>';
    }
/*MEDICAMENTOS */
    if (isset($_POST['btnmed'])) {
        include "../../conexionbd.php";
        $nombre=mysqli_real_escape_string($conexion, (strip_tags($_GET["nombre"], ENT_QUOTES)));
        $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac"], ENT_QUOTES)));
        $id_amb=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_amb"], ENT_QUOTES)));
        $item_id =  mysqli_real_escape_string($conexion, (strip_tags($_POST["med"], ENT_QUOTES)));
        $cantidad =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));
        $tipo = "Consulta";
$resultado_serv = $conexion->query("SELECT * FROM item where item_id = $item_id") or die($conexion->error);
                  while ($row_serv = $resultado_serv->fetch_assoc()) {
                    $item_code = $row_serv['item_code'];
                    $descripcion = $row_serv['item_name'];
                    $item_price = $row_serv['item_price'];
                  }
                  
$fecha_actual = date("Y-m-d H:i:s");
        $ingresar2 = mysqli_query($conexion, 'INSERT INTO pago_serv (id_pac,nombre,id_serv,servicio,cantidad,precio,fecha,usuario,tipo) values ('.$id_pac.',"'.$nombre.'","'. $item_code .'","' . $descripcion .'",' . $cantidad . ',' . $item_price . ',"'.$fecha_actual.'",'.$id_usua.',"'.$tipo.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

echo '<script type="text/javascript">window.location.href = "pago_consulta_externa.php?id_pac='.$id_pac.'&nombre='.$nombre.'&id_amb='.$id_amb.'";</script>';
    }

/*MEDICAMENTOS DE FARMACIA   */

if (isset($_POST['btnfar'])) {

    include "../../conexionbd.php";
        $nombre=mysqli_real_escape_string($conexion, (strip_tags($_GET["nombre"], ENT_QUOTES)));
        $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac"], ENT_QUOTES)));
        $id_amb=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_amb"], ENT_QUOTES)));
        $item_id =  mysqli_real_escape_string($conexion, (strip_tags($_POST["med"], ENT_QUOTES)));
        $cantidad = mysqli_real_escape_string($conexion, (strip_tags($_POST["qty"], ENT_QUOTES)));
        $tipo = "Consulta";
      $stock_id = mysqli_real_escape_string($conexion, (strip_tags($_POST["med"], ENT_QUOTES)));
      $sql = "SELECT * FROM item, stock, item_type where controlado = 'NO' AND item_type.item_type_id=item.item_type_id and item.item_id = stock.item_id and stock.stock_qty != 0 and stock_id = $stock_id";
      $result = $conexion->query($sql);
      while ($row_medicamentos = $result->fetch_assoc()) {
        $stock_qty = $row_medicamentos['stock_qty'];
        $stock_min = $row_medicamentos['stock_min'];
        $item_id = $row_medicamentos['item_id'];
        $descripcion = $row_medicamentos['item_name'];
        $item_code = $row_medicamentos['item_code'];
        $item_price = $row_medicamentos['item_price'];
      }

      
      $cart_uniquid = uniqid();
      $stock = $stock_qty - $cantidad;
      if (!($stock < $stock_min)) {

          
$fecha_actual = date("Y-m-d H:i:s");
        $ingresar2 = mysqli_query($conexion, 'INSERT INTO pago_serv (id_pac,nombre,id_serv,servicio,cantidad,precio,fecha,usuario,tipo) values ('.$id_pac.',"'.$nombre.'","'. $item_code .'","' . $descripcion .'",' . $cantidad . ',' . $item_price . ',"'.$fecha_actual.'",'.$id_usua.',"'.$tipo.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

   /*     $sql2 = "INSERT INTO cart_enf(item_id,cart_qty,cart_stock_id,id_usua,cart_uniqid, paciente)VALUES($item_id,$qty, $stock_id,$usuario2,'$cart_uniquid', $id_atencion)";
        $result = $conexion->query($sql2);*/

        $sql2 = "UPDATE stock set stock_qty=$stock where stock_id = $stock_id";
        $result = $conexion->query($sql2);

        echo '<script type="text/javascript">window.location.href = "pago_consulta_externa.php?id_pac='.$id_pac.'&nombre='.$nombre.'&id_amb='.$id_amb.'";</script>';
      } else {
        echo '<script type="text/javascript">window.location.href = "pago_consulta_externa.php?id_pac='.$id_pac.'&nombre='.$nombre.'&id_amb='.$id_amb.'";</script>';
      }
    }
/* otros  */
if (isset($_POST['btnotros'])) {
        include "../../conexionbd.php";
        $nombre=mysqli_real_escape_string($conexion, (strip_tags($_GET["nombre"], ENT_QUOTES)));
        $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac"], ENT_QUOTES)));
        $id_amb=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_amb"], ENT_QUOTES)));
        $desc = strtoupper(mysqli_real_escape_string($conexion, (strip_tags($_POST["desc"], ENT_QUOTES))));
        $cant =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cant"], ENT_QUOTES)));
        $prec =  mysqli_real_escape_string($conexion, (strip_tags($_POST["prec"], ENT_QUOTES)));
        $tipo="Consulta";
        $idotro=1472;

                  
$fecha_actual = date("Y-m-d H:i:s");
        $ingresar2 = mysqli_query($conexion, 'INSERT INTO pago_serv (id_pac,nombre,id_serv,servicio,cantidad,precio,fecha,usuario,tipo) values ('.$id_pac.',"'.$nombre.'",'.$idotro.',"' . $desc .'",' . $cant. ','.$prec.',"'.$fecha_actual.'",'.$id_usua.',"'.$tipo.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

echo '<script type="text/javascript">window.location.href = "pago_consulta_externa.php?id_pac='.$id_pac.'&nombre='.$nombre.'&id_amb='.$id_amb.'";</script>';
    }

     ?>
      <div class="col-sm-1">
        <?php 
         $id_pac=$_GET['id_pac'];
         $tipo = 'Consulta';
         echo '<tr>' .'<td> <a <a type="submit" class="btn btn-primary btn-sm" href="pdf_edo_cta.php?id_pac='.$id_pac.'&tipo='.$tipo.'" target="blank">Imprimir estado de cuenta</a></td>';
          ?>
    </div>
     <div class="row">
        <div class="col">
            <div class="table-responsive">
             <table class="table table-bordered table-striped" id="mytable">
              <thead class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
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
                 if (isset($_GET['id_pac'])) {
 include "../../conexionbd.php";
                $id_amb=$_GET['id_amb'];
                $id_pac=$_GET['id_pac'];
     $resultado_total = $conexion->query("SELECT * FROM depositos_pserv where id_pac = $id_pac and tipo = 'Consulta' ") or die($conexion->error);
        $total_dep = 0;
        $no = 1;
        while ($row_total = $resultado_total->fetch_assoc()) {
          $total_dep = $row_total['deposito'] + $total_dep;
        }
                  
$resultado3 = $conexion->query("SELECT * from pago_serv p, cat_servicios c where $id_pac=p.id_pac and c.id_serv=p.id_serv and (c.id_serv!=1472) and p.activo='SI' and p.tipo = 'Consulta' ") or die($conexion->error);

                 $no = 1;
                while ($row_lista_serv = $resultado3->fetch_assoc()) {
                    $fecha=date_create($row_lista_serv['fecha']);
                    $precio = $row_lista_serv['serv_costo'] * 1.16; 
                    $subtottal=$precio*$row_lista_serv['cantidad'];
                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . date_format($fecha,"d-m-Y") . '</td>'
                    . '<td>' . $row_lista_serv['servicio'] . '</td>'
                    . '<td>' . $row_lista_serv['cantidad'] . '</td>'
                    . '<td>$' . number_format($precio,2) . '</td>'
                    . '<td>$' . number_format($subtottal, 2). '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="manipula_pago.php?q=eliminar_serv_con&pago_id= ' . $row_lista_serv['pago_id'] . '&id_pac='.$row_lista_serv['id_pac'].'&nombre='.$nombre.'&id_amb='.$id_amb.'"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $total= $subtottal + $total;
                  $no++;
                } 
          $resultado3 = $conexion->query("SELECT * from pago_serv p, item i where $id_pac=p.id_pac and i.item_code=p.id_serv and p.activo='SI' and p.tipo = 'Consulta' ") or die($conexion->error);
                while ($row_lista_serv = $resultado3->fetch_assoc()) {
                    $fecha=date_create($row_lista_serv['fecha']);
                    $precio = $row_lista_serv['item_price'] * 1.16; 
                    $subtottal=$precio*$row_lista_serv['cantidad'];
                   
                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . date_format($fecha,"d-m-Y") . '</td>'
                    . '<td>' . $row_lista_serv['servicio'] . '</td>'
                    . '<td>' . $row_lista_serv['cantidad'] . '</td>'
                    . '<td>$' . number_format($precio,2) . '</td>'
                    . '<td>$' . number_format($subtottal, 2). '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="manipula_pago.php?q=eliminar_serv_con&id_pac='.$row_lista_serv['id_pac'].'&nombre='.$nombre.'&pago_id= ' . $row_lista_serv['pago_id'].'&id_amb='.$id_amb.'"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $total= $subtottal + $total;
                
                  $no++;
                } 

                $resultado3 = $conexion->query("SELECT * from pago_serv p where $id_pac=p.id_pac and p.id_serv=1472 and p.activo='SI'") or die($conexion->error);
                while ($row_lista_serv = $resultado3->fetch_assoc()) {
                    $fecha=date_create($row_lista_serv['fecha']);
                    $precio = $row_lista_serv['precio'] * 1.16; 
                    $subtottal=$precio*$row_lista_serv['cantidad'];
                    $subtotal = number_format($subtotal, 2);
                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . date_format($fecha,"d-m-Y") . '</td>'
                    . '<td>' . $row_lista_serv['servicio'] . '</td>'
                    . '<td>' . $row_lista_serv['cantidad'] . '</td>'
                    . '<td>$' . number_format($precio,2) . '</td>'
                    . '<td>$' . number_format($subtottal, 2). '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="manipula_pago.php?q=eliminar_serv_con&id_pac='.$row_lista_serv['id_pac'].'&nombre='.$nombre.'&pago_id= ' . $row_lista_serv['pago_id'] . '&id_amb='.$id_amb.'"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $total= $subtottal + $total;
                 /* $total = number_format($total, 2);*/
                  $no++;
                } 
               

                 }
                
                ?>
                <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>TOTAL SERVICIOS:</td>
              <td><?php 
              echo "$ " . number_format($total, 2); ?></td>
              <td></td>
            </tbody>
            </table>
           </div>
        </div>
    </div><br>


        <!-- aqui va la validacion de la cuenta en 0 -->
<?php 
$total = round($total,2);
$total_dep = round($total_dep,2);
$diferencia = $total - $total_dep;
// echo ' Total: '. $total . '  ' . $total_dep .'  ' .$diferencia;
if($total_dep > $total){ ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible fade show"><center><strong>HAY UNA DIFERENCIA DE: $  <?php echo '  ' .number_format($diferencia, 2);?></strong></center></div>
         </div>
</div>
<div class="row">
    <div class="col-md-12">
            <div class="alert alert-success alert-dismissible fade show"><center><strong>ELIMINAR DEPOSITO Y AGREGAR MONTO CORRECTO</strong></center></div>
          </div>
</div><br>
<?php }elseif($total_dep == $total and $total != 0){ ?>
    <form action="" method="POST">
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible fade show"><center><strong>YA NO EXISTEN DIFERENCIAS </strong></center></div>
    </div>
</div>
<center>
<div class="row">
        <div class="col-sm-12">
            <input type="submit" name="btnpag" class="btn btn-danger" value="CERRAR PAGO DE SERVICIOS">
        </div>
    </form>
</div>
</center><br>
<?php }else{?>
<div class="row">
    <div class="col-sm-4"></div>
        <div class="col-md-12">
            <?php $diferenia = 0.00;
            $diferencia = $total - $total_dep;?>
            <div class="alert alert-danger alert-dismissible fade show">
                <center><strong>HAY UNA DIFERENCIA DE: $  <?php echo '  ' .number_format($diferencia, 2);?></strong></center>
                
            </div>
        </div>
</div><br>
        <!-- aqui va la validacion de la cuenta en 0 -->
    
    <div class="container">
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                         <tr><strong><center>AGREGAR PAGOS</strong> 
        </div>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-4">
             
                <label for="resp">Nombre de quien paga: </label><br>
                <input type="text" name="resp" placeholder="Nombre completo" id="resp" style="text-transform:uppercase;" maxlength="50" onkeypress="return SoloLetras(event);" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" required="">
             
            </div>
            <div class="col-md-4">
              
                <label>Forma de pago: </label>
                  <select name="tipo_pago" class="form-control" required="">
                   <option value="">Seleccionar</option>
                    <option value="EFECTIVO">EFECTIVO</option>
                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                    <option value="DEPOSITO">DEPOSITO</option>
                    <option value="TARJETA">TARJETA</option>
                    <option value="ASEGURADORA">ASEGURADORA</option>
                    <option value="CUENTAS POR COBRAR">CUENTAS POR COBRAR</option>
                    <option value="DESCUENTO">DESCUENTO</option>
                  </select>
            </div>
            <div class="col-md-4">
                <label>Cantidad $:</label>
                <input type="number" name="deposito" placeholder="Precio"  min="0" step="0.01" class="form-control" value="">
               
            </div>
          </div>
          <br>
            <center>
               <input type="submit" name="btnpago" class="btn btn-block btn-success col-sm-3" value="GUARDAR">
            </center>
        </form>
    </div><br>
          <?php
      if (isset($_POST['btnpago'])) {
        $usuario = $_SESSION['login'];
        $id_usua=$usuario['id_usua'];
        $nombre=mysqli_real_escape_string($conexion, (strip_tags($_GET["nombre"], ENT_QUOTES)));
        $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac"], ENT_QUOTES)));
        $id_amb=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_amb"], ENT_QUOTES)));
        $resp = mysqli_real_escape_string($conexion, (strip_tags($_POST["resp"], ENT_QUOTES)));
        $tipo_pago = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo_pago"], ENT_QUOTES)));
        $deposito = mysqli_real_escape_string($conexion, (strip_tags($_POST["deposito"], ENT_QUOTES)));
        $tipo = "Consulta";
$fecha_actual = date("Y-m-d H:i:s");
       
       $sql_df = "INSERT INTO depositos_pserv(id_pac,deposito,tipo_pago,id_usua,fecha,responsable,tipo)values($id_pac,$deposito,'$tipo_pago',$id_usua,'$fecha_actual','$resp','$tipo')";
        $result_df = $conexion->query($sql_df);

        if ($result_df) {
          echo '<script type="text/javascript">window.location.href = "pago_consulta_externa.php?id_pac='.$id_pac.'&nombre='.$nombre.'&id_amb='.$id_amb.'";</script>';
        } else {
          echo $sql_df;
          echo '<h1>ERROR AL INSERTAR';
        }
      }
      ?>
      <?php } ?>
      <?php 
if(isset($_POST['btnpag'])){
    $usuario = $_SESSION['login'];
    $id_usua=$usuario['id_usua'] ;

    $id_pac=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_pac"], ENT_QUOTES)));
    
    $nombre=mysqli_real_escape_string($conexion, (strip_tags($_GET["nombre"], ENT_QUOTES)));
    $id_amb=mysqli_real_escape_string($conexion, (strip_tags($_GET["id_amb"], ENT_QUOTES)));
    $nom_pag=mysqli_real_escape_string($conexion, (strip_tags($_POST["nom_pag"], ENT_QUOTES)));
    $efect=mysqli_real_escape_string($conexion, (strip_tags($_POST["efect"], ENT_QUOTES)));
    $transf=mysqli_real_escape_string($conexion, (strip_tags($_POST["transf"], ENT_QUOTES)));
    $tarj=mysqli_real_escape_string($conexion, (strip_tags($_POST["tarj"], ENT_QUOTES)));
    $tipo="Consulta";


$fecha_actual = date("Y-m-d H:i:s");

$sql = "UPDATE pserv SET activo = 'NO' WHERE id_pac = $id_pac and tipo ='Consulta'";
$result = $conexion->query($sql);


/*$metodo= "INSERT INTO metodo_pserv(id_pac,nom_pag,total,efectivo,transferencia,tarjeta,fecha,id_usua) values($id_pac,'$nom_pag','$total','$efect','$transf','$tarj','$fecha_actual',$id_usua)";
$result_metodo=$conexion->query($metodo); */

$valida= "INSERT INTO cta_pagada_serv(id_atencion,nombre,total,fecha_cierre,id_usua,tipo) values($id_pac,'$nombre','$total','$fecha_actual',$id_usua,'$tipo')";
$result_valida=$conexion->query($valida);

$sql = "UPDATE receta_ambulatoria SET pagado = 'SI' WHERE id_rec_amb = $id_amb";
$result = $conexion->query($sql);
      
echo '<script type="text/javascript">window.location.href = "vista_pago_consulta.php";</script>';
      
}
 ?>
      <div class="container">
          <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search_dep" placeholder="BUSCAR...">
        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #2b2d7f; color: white; ">
              <tr>
                <th>#</th>
                <th>FECHA DE PAGO</th>
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
              $nombre=$_GET['nombre'];
              $id_pac=$_GET['id_pac'];
              $id_amb=$_GET['id_amb'];
              $resultado4 = $conexion->query("SELECT * FROM depositos_pserv where id_pac = $id_pac and tipo = 'Consulta' ") or die($conexion->error);
              $total_dep = 0;
              $no = 1;
              while ($row4 = $resultado4->fetch_assoc()) {
                $fecha=date_create($row4['fecha']);
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . date_format($fecha,"d-m-Y H:i:s") . '</td>'
                  . '<td>' . $row4['responsable'] . '</td>'
                  . '<td>' . $row4['tipo_pago'] . '</td>'
                  . '<td>$ ' . number_format($row4['deposito'], 2) . '</td>';

                echo '<td><strong><a type="submit" class="btn btn-danger btn-sm" href="elimina_depserv.php?q=del_dep_con&id_pac=' . $id_pac . '&id_depserv=' . $row4['id_depserv'] . '&nombre=' . $nombre . '&id_amb='.$id_amb.'"><span class = "fa fa-trash"></span></a></td>';
                echo '</tr>';
                $total_dep = $row4['deposito'] + $total_dep;
                $no++;
              }
              ?>
              <td></td>
              <td></td>
              <td></td>
              <td>TOTAL PAGOS:</td>
              <td><?php echo "$ " . number_format($total_dep, 2); ?></td>
              <td></td>
            </tbody>
          </table>

        </div>
      </div>

<!-- final de insertar pago de servicios -->   
</div>
<?php }else{?> <!-- final de isset(nombre) -->
      <div class="container">
          <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search_dep" placeholder="BUSCAR...">
        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
              <tr>
                <th>#</th>
                <th>FECHA</th>
                <th>NOMBRE</th>
                <th>PERSONAL</th>
                <th>PAGAR</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $usuario = $_SESSION['login'];
              $id_usua=$usuario['id_usua'];
              $resultado4 = $conexion->query("SELECT * FROM pserv where activo='SI' and tipo = 'Consulta' ") or die($conexion->error);
              $total_dep = 0;
              $no = 1;
              while ($row4 = $resultado4->fetch_assoc()) {
                $fecha=date_create($row4['fecha']);
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . date_format($fecha,"d-m-Y H:i:s") . '</td>'
                  . '<td>' . $row4['nombre'] . '</td>'
                  . '<td>' . $row4['usuario'] . '</td>';
                  echo '<td><strong><a type="submit" class="btn btn-danger btn-sm" href="pago_servicios.php?q=del_dep&id_pac=' . $row4['id_pac'] . '&nombre=' . $row4['nombre'] . '"><span class = "fa fa-file-text"></span></a></td>';
                echo '</tr>';
              }
              ?>
            </tbody>
          </table>

        </div>
      </div>
<?php } ?>
</div>
<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>

<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>


<script>
    document.oncontextmenu = function () {
        return false;
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
            $('#mibuscador').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
            $('#mibuscador2').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
            $('#mibuscador3').select2();
    });
</script>
  <script type="text/javascript">
        function mostrar(value)
        {
            if(value=="OTROS" || value==true)
            {
                // habilitamos
                document.getElementById('contenido').style.display = 'block';
            }else if(value==false){
                // deshabilitamos
                document.getElementById('contenido').style.display = 'none';
            }
        }
    </script>
</body>

</html>