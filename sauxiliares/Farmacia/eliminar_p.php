<?php
session_start();
include "../../conn_almacen/Connection.php";

$id = @$_GET['cart_id'];

$resultado = $conexion_almacen->query("DELETE  from cart_recib WHERE id_recib=$id") or die($conexion->error);


header('location: confirmar_envio.php');
?>