<?php
session_start();
include '../../conexionbd.php';

$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];

$id_atencion = $_SESSION['hospital'];

$defuncion=$_POST['defuncion'];

$sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_usua";
    $result_med = $conexion->query($sql_med);

    while ($row_med = $result_med->fetch_assoc()) {
      $nom = $row_med['nombre'];
      $app = $row_med['papell'];
      $apm = $row_med['sapell'];
      }
$nombre_medico=$nom.' '.$app.' '.$apm;

$fecha_actual = date("Y-m-d H:i:s");

$insert=mysqli_query($conexion,'INSERT INTO defuncion (id_atencion,id_usua,defuncion,fecha) VALUES ('.$id_atencion.','.$id_usua.',"'.$defuncion.'","'.$fecha_actual.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));




header('location: ../hospitalizacion/vista_pac_hosp.php');