<?php 
session_start();
include "../header_almacenC.php";
 ?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title></title>
</head>
<body>
<?php

 if (@$_GET['a']== 'agregar') {
    include "../../conexionbd.php";
    $item_id=$_POST['item_id'];
 $qty=$_POST['qty'];
 $cart_uniquid = uniqid();

/*$sql2 = "INSERT INTO cart_recib(item_id,cart_qty,destino,cart_uniqid,almacen)VALUES($item_id,$qty,'TOLUCA','$cart_uniquid','FARMACIA');";
            //  echo $sql2;
              $result_cart = $conexion->query($sql2);*/

              $ingresar2 = mysqli_query($conexion, "INSERT INTO cart_recib(item_id, solicita, almacen) VALUES ($item_id, $qty, 'FARMACIA')") 
              or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
          
 echo '<script type="text/javascript">window.location.href = "pedir_almacen.php";</script>';

 }
 
       
              /*      . '<td> <a type="submit" class="btn btn-danger btn-sm" href="../../sauxiliares/Ceye/cargar_paquete.php?q=eliminarquir&paciente= ' . $paciente1 . '&cart_id=' . $cart_id . '&cart_stock_id=' . $cart_stock_id . '&cart_qty=' . $cart_qty . '"><span class = "fa fa-trash"></span></a></td>'; */

if(@$_GET['q']== 'eliminar'){
    include "../../conexionbd.php";
    $id_recib=$_GET['cart_id'];
$sql2 = "DELETE FROM cart_recib WHERE id_recib=$id_recib";
$result_cart = $conexion->query($sql2);
echo '<script type="text/javascript">window.location.href = "pedir_almacen.php";</script>';
}

if(@$_GET['q']== 'conf'){
    include "../../conexionbd.php";
    $id_recib=$_GET['cart_id'];
$sql2 = "UPDATE cart_recib SET confirma='SI' WHERE id_recib=$id_recib";
$result_cart = $conexion->query($sql2);
echo '<script type="text/javascript">window.location.href = "pedir_almacen.php";</script>';
}

if(@$_GET['q']== 'env'){
    include "../../conexionbd.php";
    $id_recib=$_GET['cart_id'];
  $env_qty=$_POST['surt'];
//saber cuantos pidio
$sql1 = "SELECT * FROM cart_recib WHERE id_recib=$id_recib";
$result_qty = $conexion->query($sql1);
while ($row_stock = $result_qty->fetch_assoc()) {
   $cart_qty=$row_stock['cart_qty'];
   $item_id=$row_stock['item_id'];
}
//saber cuantos hay en stock
$sql2 = "SELECT * FROM stock_almacen WHERE item_id=$item_id";
$result_cart = $conexion->query($sql2);
while ($row_stock = $result_cart->fetch_assoc()) {
   $stock_id=$row_stock['stock_id'];
   $stock_qty=$row_stock['stock_qty'];
}

$sql3 = "SELECT * FROM item_almacen i, item_type it WHERE item_id=$item_id and i.item_type_id=it.item_type_id";
$result_item = $conexion->query($sql3);
while ($row_item = $result_item->fetch_assoc()) {
   $item_id=$row_item['item_id'];
   $item_name=$row_item['item_name'];
   $item_code=$row_item['item_code'];
   $item_brand=$row_item['item_brand'];
   $item_grams=$row_item['item_grams'];
   $item_type_desc=$row_item['item_type_desc'];
}

//update de lo que pidio
if(isset($stock_id)){
if($cart_qty<= $stock_qty){

$sql3 = "UPDATE cart_recib SET envio_qty=$env_qty, enviado='SI' WHERE id_recib=$id_recib";
$result_cart = $conexion->query($sql3);

$total=$stock_qty-$cart_qty;

$sql4 = "UPDATE stock_almacen SET stock_qty=$total WHERE item_id=$item_id";
$result_cart = $conexion->query($sql4);

$sales= mysqli_query($conexion, 'INSERT INTO sales_almacen(item_code,generic_name,brand,gram,type,qty,destino,almacen) 
   values ("'.$item_code.'","' . $item_name . '","'.$item_brand.'","' . $item_grams . '","'.$item_type_desc.'",'.$cart_qty.',"TOLUCA","FARMACIA") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

echo '<script type="text/javascript">window.location.href = "../AlmacenC/surtir_almacen.php";</script>';
}else{
   echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO HAY EXISTECIAS DE ESTE MEDICAMENTO", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                                window.location.href = "../AlmacenC/surtir_almacen.php";
                            }
                        });
                    });
                </script>';
}
}else{
   echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO SE ENCONTRO EL MEDICAMENTO EN EL STOCK", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                                window.location.href = "../AlmacenC/surtir_almacen.php";
                            }
                        });
                    });
                </script>';
}
//echo '<script type="text/javascript">window.location.href = "../AlmacenC/surtir_almacen.php";</script>';
}

/*if(@$_GET['q']== 'search'){
   include "../../conn_almacen/Connection.php";
  $id_item=$_GET['item_id'];
$sql2 = "SELECT * FROM stock_almacen WHERE item_id=$id_item";
$result_cart = $conexion->query($sql2);
while ($row_stock = $result_cart->fetch_assoc()) {
   $stock_id=$row_stock['stock_id'];
}

echo '<script type="text/javascript">window.location.href = "../AlmacenC/surtir_almacen.php";</script>';
}*/

?>
</body>
</html>
