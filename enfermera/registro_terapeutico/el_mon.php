<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id_mon_s'];

$resultado = $conexion->query("DELETE  from monitoreo_sust WHERE id_mon_s=$id") or die($conexion->error);
header('location: reg_terapeutico.php');
?>