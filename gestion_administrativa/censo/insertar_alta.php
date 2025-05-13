<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];

$id_atencion = $_GET['id_atencion'];

$alta_por=$_POST['alta_por'];
$fech_alta=$_POST['fech_alta'];
$hor_alta=$_POST['hor_alta'];
$nom_med=$_POST['nom_med'];
$obs_med=$_POST['obs_med'];

$fecha_actual = date("Y-m-d H:i:s");

$insert=mysqli_query($conexion,'INSERT INTO alta (id_atencion,id_usua,alta_por,fech_alta,hor_alta,nom_med,obs_med,fecha_altamed) VALUES ('.$id_atencion.','.$id_usua.',"'.$alta_por.'","'.$fech_alta.'","'.$hor_alta.'","'.$nom_med.'","'.$obs_med.'","'.$fecha_actual.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));


$sql2 = "UPDATE dat_ingreso SET alta_med = 'SI', fecha_alt_med = '$fech_alta', hora_alt_med = '$hor_alta', motivo_alta='".$alta_por."', edo_salud = '".$alta_por."' WHERE id_atencion = $id_atencion";
      $result = $conexion->query($sql2);

header('location: tabla_censo.php');