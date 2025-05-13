<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id_dialisis'];

$resultado = $conexion->query("DELETE  from dialisis_p WHERE id_dialisis=$id") or die($conexion->error);


header('location: nota_dialisis.php');
?>