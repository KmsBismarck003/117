<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];

if(isset($_POST['area'])){$area=$_POST['area'];}else{ $area='';}
$sql2 = "UPDATE dat_ingreso SET area = '$area' WHERE id_atencion = $id_atencion";
        $result = $conexion->query($sql2);

?>