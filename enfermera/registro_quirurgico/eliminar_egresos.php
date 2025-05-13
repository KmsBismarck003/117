<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

//$id = @$_GET['id_sol_enf'];

$id = $_REQUEST['id'];
$resultado = $conexion->query("DELETE  from egresos_quir WHERE id_equir=$id") or die($conexion->error);

echo mysqli_query($conexion,$resultado);
//header('location: vista_enf_quirurgico.php');
?>