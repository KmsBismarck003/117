<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id_cateh'];

$resultado = $conexion->query("DELETE  from cate_enf_hosp WHERE id_cateh=$id") or die($conexion->error);


header('location: reg_clin.php');
?>