<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id'];

$resultado = $conexion->query("DELETE  from nota_enf_hosp WHERE id_nota_enf =$id") or die($conexion->error);


header('location: reg_clin.php');
?>