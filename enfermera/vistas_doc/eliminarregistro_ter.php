<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id_clinreg'];

$resultado = $conexion->query("DELETE  from enf_ter WHERE id_enf_mat=$id") or die($conexion->error);


header('location: vista_cuid_inten.php');


?>