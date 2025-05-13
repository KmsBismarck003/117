<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

$id_atencion = $_REQUEST['paciente'];

$sql2 = "SELECT * FROM cart_mat WHERE paciente = $id_atencion";
$result = $conexion->query($sql2);

while ($row_stock = $result->fetch_assoc()) {
    $cart_id = $row_stock['id'];
    $cart_qty = $row_stock['cart_qty'];
    $cart_price = $row_stock['cart_price'];
    $cart_stock_id = $row_stock['cart_stock_id'];
    $cart_uniqid = $row_stock['cart_uniqid'];
    $material_id = $row_stock['material_id'];
    $cart_fecha = $row_stock['cart_fecha'];
   
    $qty=$cart_qty;
    $qty_salida=$cart_qty;
    
    $sql3 = "SELECT * FROM material_ceye WHERE material_id = $material_id";
    $resulti = $conexion->query($sql3);
    while ($row_stocki = $resulti->fetch_assoc()) {

    $item_code = $row_stocki['material_codigo'];
    $item_name = $row_stocki['material_nombre'];
    $item_brand = $row_stocki['material_fabricante'];
    $item_grams = $row_stocki['material_contenido'];
    $item_type = $row_stocki['material_tipo'];
    
    
    $fecha_actual = date("Y-m-d H:i:s");

    $sql_insert = "INSERT INTO cart_ceye
    (material_id,
    cart_qty,
    cart_price,
    cart_stock_id,
    id_usua,
    cart_uniqid,
    paciente,
    cart_fecha
    ) VALUES 
    ('".$material_id."',
     '".$cart_qty."',
     '".$cart_price."',
     '".$cart_stock_id."',
     '".$id_usua."',
     '".$cart_uniqid."',
     '".$id_atencion."',
     '".$fecha_actual."'
    )";
    
    echo mysqli_query($conexion,$sql_insert);
  
  }
   
$sql_delCart = "DELETE FROM cart_mat WHERE id = $cart_id";

echo mysqli_query($conexion,$sql_delCart);
}
?>