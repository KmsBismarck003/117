<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id_med_reg'];

$resultado = $conexion->query("DELETE  from medica_enf WHERE id_med_reg=$id") or die($conexion->error);


header('location: materiales.php');
?>