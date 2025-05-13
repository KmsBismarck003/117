<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

$id = $_REQUEST['id'];

$resultado = $conexion->query("DELETE  from textiles WHERE id_text=$id") or die($conexion->error);

echo mysqli_query($conexion,$resultado);
//header('location: vista_enf_quirurgico.php');
?>