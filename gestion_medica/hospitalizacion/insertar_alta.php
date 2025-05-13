<?php
session_start();
include '../../conexionbd.php';

$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];

$id_atencion = $_SESSION['hospital'];

$alta_por=$_POST['alta_por'];
$fech_alta=$_POST['fech_alta'];
$hor_alta=$_POST['hor_alta'];
$obs_med=$_POST['obs_med'];

$sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_usua";
    $result_med = $conexion->query($sql_med);

    while ($row_med = $result_med->fetch_assoc()) {
      $nom = $row_med['nombre'];
      $app = $row_med['papell'];
      $apm = $row_med['sapell'];
      }
$nombre_medico=$app.' '.$apm;

$insert=mysqli_query($conexion,'INSERT INTO alta (id_atencion,id_usua,alta_por,fech_alta,hor_alta,nom_med,obs_med) VALUES ('.$id_atencion.','.$id_usua.',"'.$alta_por.'","'.$fech_alta.'","'.$hor_alta.'","'.$nombre_medico.'", "'.$obs_med.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));


$sql2 = "UPDATE dat_ingreso SET alta_med = 'SI', fecha_alt_med = '$fech_alta', hora_alt_med = '$hor_alta', motivo_alta='".$alta_por."', edo_salud = '".$alta_por."' WHERE id_atencion = $id_atencion";
      $result = $conexion->query($sql2);



header('location: ../hospitalizacion/vista_pac_hosp.php');