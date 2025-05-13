<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$fecha_actual = date("Y-m-d H:i:s");

$receta=$_POST['receta'];
//$alerg=$_POST['alerg'];
$medi=$_POST['medi'];
$reg_ssa=$_POST['reg_ssa'];
//$fecha_r_hosp=$_POST['fecha_r_hosp'];
$fec_pcita=$_POST['fec_pcita'];
$hor_pcita=$_POST['hor_pcita'];



$result= $conexion->query("SELECT alergias FROM dat_ingreso WHERE id_atencion=$id_atencion") or die($conexion->error);
   while ($row = mysqli_fetch_array($result)) {
      $alerg=$row['alergias'];
     }


$insertar=mysqli_query($conexion,'INSERT INTO receta(id_atencion,id_usua,alerg,receta,medi,reg_ssa,fecha_r_hosp,fec_pcita,hor_pcita) values ('.$id_atencion.','.$id_usua.',"'.$alerg.'","'.$receta.'","'.$medi.'","'.$reg_ssa.'","'.$fecha_actual.'","'.$fec_pcita.'","'.$hor_pcita.'")')  or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

    //redirección
    header('location: ../hospitalizacion/vista_pac_hosp.php');
 //si no se enviaron datos


?>