<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = @$_GET['id_sol_enf'];

$resultado = $conexion->query("DELETE  from liquidos_quir WHERE id_liquidos =$id") or die($conexion->error);


header('location: vista_enf_quirurgico.php');
?>