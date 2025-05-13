<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id_cate_ter'];

$resultado = $conexion->query("DELETE  from cate_enf_ter WHERE id=$id") or die($conexion->error);


header('location: reg_terapeutico.php');
?>