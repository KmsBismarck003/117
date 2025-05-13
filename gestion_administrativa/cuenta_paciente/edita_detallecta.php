<?php

  session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usu = $usuario['id_usua'];

$usuario1 = $_GET['id_usua'];
$rol = $_GET['rol'];
$id_exp = $_GET['id_exp'];
$id_atencion = $_GET['id_at'];
  $id_ctapac=$_GET['id_ctapac'];
  $editprecio=$_GET['editprecio'];
  
$sql2 = "UPDATE dat_ctapac SET cta_tot='$editprecio' WHERE id_ctapac= $id_ctapac";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript"> window.location.href="detalle_cuenta.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '";</script>';
  } else {
    echo 'ERROR';
  }




   
     
    

