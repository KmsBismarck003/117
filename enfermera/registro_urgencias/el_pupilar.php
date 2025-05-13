<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id_mon_s'];

$resultado = $conexion->query("DELETE  from d_pupilar WHERE id_pupilar=$id") or die($conexion->error);


header('location: reg_urgn.php');
?>