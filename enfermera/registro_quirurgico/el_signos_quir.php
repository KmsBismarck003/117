<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

//$id_quir_graf = @$_GET['id'];
$id = $_REQUEST['id'];


$resultado = $conexion->query("DELETE  from dat_quir_grafico WHERE id_quir_graf=$id") or die($conexion->error);
echo mysqli_query($conexion,$resultado);

//header('location: vista_enf_quirurgico.php');
?>