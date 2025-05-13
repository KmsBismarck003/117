<?php
include "../../conexionbd.php";


if (@$_GET['q'] == 'eliminar_serv') {
  $id_presupuesto = $_GET['id_presupuesto'];
  $nombre=$_GET['nombre'];
  $id_pac=$_GET['id_pac'];

  $sql2 = "DELETE FROM presupuesto WHERE id_presupuesto = $id_presupuesto";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript">window.location.href = "presupuesto.php?id_pac='.$id_pac.'&nombre='.$nombre.'";</script>';
  } else {
    echo 'ERROR';
  }
}

if (@$_GET['q'] == 'comp') {
  $id_pac=$_GET['id_pac'];
  $sql2 = "DELETE FROM presupuesto WHERE id_pac = $id_pac";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript">window.location.href = "presupuesto.php";</script>';
  } else {
    echo 'ERROR';
  }
}
