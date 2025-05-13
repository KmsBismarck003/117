<?php 
include "../../conexionbd.php";

if (@$_GET['q'] == 'del_dep') {
  $id_depserv = $_GET['id_depserv'];
  $id_pac = $_GET['id_pac'];
  $nombre = $_GET['nombre'];

  $sql2 = "DELETE FROM depositos_pserv WHERE id_depserv = $id_depserv";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript">window.location.href = "pago_servicios.php?id_pac='.$id_pac.'&nombre='.$nombre.'";</script>';
  } else {
    echo 'ERROR';
  }
}

if (@$_GET['q'] == 'del_dep_con') {
  $id_depserv = $_GET['id_depserv'];
  $id_pac = $_GET['id_pac'];
  $nombre = $_GET['nombre'];
  $id_amb = $_GET['id_amb'];

  $sql2 = "DELETE FROM depositos_pserv WHERE id_depserv = $id_depserv";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript">window.location.href = "pago_consulta_externa.php?id_pac='.$id_pac.'&nombre='.$nombre.'&id_amb='.$id_amb.'";</script>';
  } else {
    echo 'ERROR';
  }
}

if (@$_GET['q'] == 'del_dep_val') {
  $id_depserv = $_GET['id_depserv'];
  $id_pac = $_GET['id_pac'];

  $sql2 = "DELETE FROM depositos_pserv WHERE id_depserv = $id_depserv";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript">window.location.href = "../cuenta_paciente/val_c_serv.php?id_pac_serv='.$id_pac.'";</script>';
  } else {
    echo 'ERROR';
  }
}

 ?>