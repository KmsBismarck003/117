<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usu = $usuario['id_usua'];

$usuario1 = $_GET['id_usua'];
$rol = $_GET['rol'];
$id_exp = $_GET['id_exp'];
$id_atencion = $_GET['id_at'];

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac FROM paciente p WHERE p.Id_exp=$id_exp";
$result_pac = $conexion->query($sql_pac);
while ($row_pac = $result_pac->fetch_assoc()) {
          $paciente =  $pac_nom_pac = $row_pac['nom_pac'] .' ' . $row_pac['papell'] .' '. $row_pac['sapell'] ;
}


if (@$_GET['q'] == 'del_cta') {
  $id_ctapac = $_GET['id_ctapac'];
  
  $sql2 = "DELETE FROM dat_ctapac WHERE id_ctapac = $id_ctapac";

  $result = $conexion->query($sql2);

  if ($result && $result_dev) {
    echo '<script type="text/javascript"> window.location.href="detalle_cuenta.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '";</script>';
  } else {
    echo 'ERROR';
  }
}


if (@$_GET['q'] == 'del_cta_val') {

    $id_ctapac = $_GET['id_ctapac'];
    $fecha= date("Y-m-d H:i:s");

$sql_cta = "SELECT * FROM dat_ctapac WHERE id_ctapac=$id_ctapac";$result_cta = $conexion->query($sql_cta);
        while ($row_cta = $result_cta->fetch_assoc()) {
          $prod_serv = $row_cta['prod_serv'];
          $insumo = $row_cta['insumo'];
          $cta_cant = $row_cta['cta_cant'];
        }


if($prod_serv == 'P'){

$fecha_actual = date("Y-m-d H:i:s");

$sql_dev = "INSERT INTO devolucion(dev_item,dev_qty,dev_estatus,fecha,id_usua,paciente)VALUES($insumo,$cta_cant,'SI','$fecha_actual',$id_usu,'$paciente')"; $result_dev = $conexion->query($sql_dev);
$sql2 = "DELETE FROM dat_ctapac WHERE id_ctapac = $id_ctapac"; $result_dev1 = $conexion->query($sql2);

}elseif ($prod_serv == 'PC') {
  
$fecha_actual = date("Y-m-d H:i:s");

  $sql_dev_ceye = "INSERT INTO devolucion_ceye(dev_producto,dev_cantidad,dev_estatus,fecha,id_usua,paciente)VALUES($insumo,$cta_cant,'SI','$fecha_actual',$id_usu,'$paciente')"; $result_dev_ceye = $conexion->query($sql_dev_ceye);
  $sql2 = "DELETE FROM dat_ctapac WHERE id_ctapac = $id_ctapac"; $result = $conexion->query($sql2);
}elseif ($prod_serv == 'S') {

  $sql3 = "DELETE FROM dat_ctapac WHERE id_ctapac = $id_ctapac"; $result_serv = $conexion->query($sql3);
}elseif ($prod_serv != 'S' && $prod_serv != 'PC' && $prod_serv != 'P') {

  $sql3 = "DELETE FROM dat_ctapac WHERE id_ctapac = $id_ctapac"; $result_otro = $conexion->query($sql3);
}
   
        echo '<script type="text/javascript"> window.location.href="val_c.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '&id_cta='.$id_ctapac.'";</script>';
    
}


if (@$_GET['q'] == 'del_dep') {
  $id_datfin = $_GET['id_datfin'];

  $sql2 = "DELETE FROM dat_financieros WHERE id_datfin = $id_datfin";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript"> window.location.href="detalle_cuenta.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '";</script>';
  } else {
    echo 'ERROR';
  }
}

if (@$_GET['q'] == 'del_dep_val') {
  $id_datfin = $_GET['id_datfin'];

  $sql2 = "DELETE FROM dat_financieros WHERE id_datfin = $id_datfin";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript"> window.location.href="val_c.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '&id_cta='.$id_ctapac.'";</script>';
  } else {
    echo 'ERROR';
  }
}
