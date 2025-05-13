<?php
session_start();
include "../../conexionbd.php";

$id=$_REQUEST['id'];
//$id=$_POST['id'];
$hora= mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES))); 
$sistg = mysqli_real_escape_string($conexion, (strip_tags($_POST["sistg"], ENT_QUOTES))); 
$diastg = mysqli_real_escape_string($conexion, (strip_tags($_POST["diastg"], ENT_QUOTES)));
$fcardg = mysqli_real_escape_string($conexion, (strip_tags($_POST["fcardg"], ENT_QUOTES))); 
$satg = mysqli_real_escape_string($conexion, (strip_tags($_POST["satg"], ENT_QUOTES)));
$glic = mysqli_real_escape_string($conexion, (strip_tags($_POST["glic"], ENT_QUOTES)));
$fechare= mysqli_real_escape_string($conexion, (strip_tags($_POST["fechare"], ENT_QUOTES)));

$sql2e = "UPDATE dat_quir_grafico SET hora = '$hora', sistg = '$sistg',diastg = '$diastg',fcardg = '$fcardg',satg='$satg',glic='$glic',fechare='$fechare' WHERE id_quir_graf =$id";
  
  echo mysqli_query($conexion,$sql2e);
  
  ?>