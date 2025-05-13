<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id_sig = @$_GET['id_sig'];

$resultado = $conexion->query("DELETE  from signos_vitales WHERE id_sig=$id_sig") or die($conexion->error);


header('location: signos.php');
?>