<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
       
$id=$_REQUEST['id'];

$fecha= mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
$soluciones= mysqli_real_escape_string($conexion, (strip_tags($_POST["soluciones"], ENT_QUOTES))); 
$hora = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES))); 
$volumen = mysqli_real_escape_string($conexion, (strip_tags($_POST["volumen"], ENT_QUOTES)));


$sql2ing = "UPDATE ingresos_quir SET id_usua = '$id_usua', fecha = '$fecha',soluciones = '$soluciones',hora = '$hora',volumen='$volumen' WHERE id_ing_quir=$id";
  
  echo mysqli_query($conexion,$sql2ing);
  
  ?>