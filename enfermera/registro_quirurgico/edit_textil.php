<?php
session_start();
include "../../conexionbd.php";



$id=$_REQUEST['id'];
//$id=$_POST['id'];
$fecha_reporte= mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_reporte"], ENT_QUOTES)));
$mat= mysqli_real_escape_string($conexion, (strip_tags($_POST["mat"], ENT_QUOTES))); 
$inicio = mysqli_real_escape_string($conexion, (strip_tags($_POST["inicio"], ENT_QUOTES))); 
$dentro = mysqli_real_escape_string($conexion, (strip_tags($_POST["dentro"], ENT_QUOTES)));
$fuera = mysqli_real_escape_string($conexion, (strip_tags($_POST["fuera"], ENT_QUOTES))); 
$cultivo = mysqli_real_escape_string($conexion, (strip_tags($_POST["cultivo"], ENT_QUOTES)));

$sql2 = "UPDATE textiles SET mat = '$mat', inicio = '$inicio',dentro = '$dentro',fuera = '$fuera',fechare='$fecha_reporte',total=$inicio,iniciototal=$inicio WHERE id_text =$id";
  
  echo mysqli_query($conexion,$sql2);
  
  ?>