<?php
session_start();
include "../../conexionbd.php";

$id = $_REQUEST['id'];
//$resultado = $conexion->query("DELETE  from medica_enf WHERE id_med_reg =$id") or die($conexion->error);

$sql1 = "DELETE FROM cart_serv WHERE cart_id = $id";
$sql2 = "DELETE FROM equipos_ceye WHERE cart_id = $id";
echo mysqli_query($conexion,$sql1);
echo mysqli_query($conexion,$sql2);

//header('location: vista_enf_quirurgico.php');
?>

