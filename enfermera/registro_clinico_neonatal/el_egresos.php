<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id'];

$resultado = $conexion->query("DELETE  from eg_enf_quir WHERE id_eg=$id") or die($conexion->error);


header('location: nota_bebes.php');
?>