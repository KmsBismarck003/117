<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id_clinreg'];

$resultado = $conexion->query("DELETE  from enf_reg_clin WHERE id_clinreg=$id") or die($conexion->error);


header('location: vista_regclin.php');


?>