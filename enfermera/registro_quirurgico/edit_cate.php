<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
       
$id=$_REQUEST['id'];

$dispositivos= mysqli_real_escape_string($conexion, (strip_tags($_POST["dispositivos"], ENT_QUOTES)));
$tipo= mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES))); 
$fecha_inst = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_inst"], ENT_QUOTES))); 
$instalo = mysqli_real_escape_string($conexion, (strip_tags($_POST["instalo"], ENT_QUOTES)));
$cultivo = mysqli_real_escape_string($conexion, (strip_tags($_POST["cultivo"], ENT_QUOTES)));

$sql2cat = "UPDATE cate_enf_ter SET id_usua = '$id_usua',dispositivos='$dispositivos', tipo = '$tipo',fecha_inst = '$fecha_inst',instalo = '$instalo',cultivo='$cultivo' WHERE id_cate_ter=$id";
  
  echo mysqli_query($conexion,$sql2cat);
  
  ?>