<?php
include "../../conexionbd.php";


if (@$_GET['q'] == 'eliminar_serv') {
  $pago_id = $_GET['pago_id'];
  $nombre=$_GET['nombre'];
  $id_pac=$_GET['id_pac'];

  $sql2 = "DELETE FROM pago_serv WHERE pago_id = $pago_id";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript">window.location.href = "pago_servicios.php?id_pac='.$id_pac.'&nombre='.$nombre.'";</script>';

  } else {
    echo 'ERROR';
  }
}

if (@$_GET['q'] == 'eliminar_registro') {
    $id_pac=$_GET['id_pac'];
 
  $sql2 = "DELETE FROM pserv WHERE id_pac = $id_pac";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript">window.location.href = "pago_servicios.php";</script>';

  } else {
    echo 'ERROR';
  }
}

if (@$_GET['q'] == 'eliminar_serv_con') {
  $pago_id = $_GET['pago_id'];
  $nombre=$_GET['nombre'];
  $id_pac=$_GET['id_pac'];
  $id_amb=$_GET['id_amb'];

  $sql2 = "DELETE FROM pago_serv WHERE pago_id = $pago_id";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript">window.location.href = "pago_consulta_externa.php?id_pac='.$id_pac.'&nombre='.$nombre.'&id_amb='.$id_amb.'";</script>';

  } else {
    echo 'ERROR';
  }
}

if (@$_GET['q'] == 'eliminar_serv_val') {
  $pago_id = $_GET['pago_id'];
  $nombre=$_GET['nombre'];
  $id_pac=$_GET['id_pac'];

  $sql2 = "DELETE FROM pago_serv WHERE pago_id = $pago_id";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript">window.location.href = "../cuenta_paciente/val_c_serv.php?id_pac_serv='.$id_pac.'";</script>';
  } else {
    echo 'ERROR';
  }
}

if (@$_GET['q'] == 'comp') {
  $id_pac=$_GET['id_pac'];
  $sql2 = "DELETE FROM pago_serv WHERE id_pac = $id_pac";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript">window.location.href = "pago_servicios.php";</script>';
  } else {
    echo 'ERROR';
  }
}
