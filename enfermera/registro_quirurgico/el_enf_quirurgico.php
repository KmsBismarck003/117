<?php
session_start();
include "../../conexionbd.php";
//include "../header_enfermera.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
//$usuario = $_SESSION['login'];

//$id = @$_GET['id_sol_enf'];

$id = $_REQUEST['id_quir'];
$resultado = $conexion->query("DELETE  from enf_quirurgico WHERE id_quir =$id") or die($conexion->error);

echo mysqli_query($conexion,$resultado);
header('location: ../vistas_doc/vista_quir_area.php');
?>