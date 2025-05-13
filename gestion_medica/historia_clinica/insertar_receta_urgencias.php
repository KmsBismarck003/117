<?php
//se establece una conexion a la base de datos
include '../../conexionbd.php';
//si se han enviado datos
$id_usua = $_GET['id_usua'];
$id_atencion = $_GET['id_atencion'];


$fecha_actual = date("Y-m-d H:i:s");

$receta_urgen=$_POST['receta_urgen'];

$fec_pcita=$_POST['fec_pcita'];
$hor_pcita=$_POST['hor_pcita'];

$esp=$_POST['esp'];
if (isset($_POST['detesp'])) {
  $detesp=$_POST['detesp'];
}else{
  $detesp=' ';
}

$alergias=$_POST['alergias'];
$med=$_POST['med'];
$reg_ssa_urgen=$_POST['reg_ssa_urgen'];


$fecha_actual = date("Y-m-d H:i:s");

$insertar=mysqli_query($conexion,'INSERT INTO recetaurgen(id_atencion,id_usua,alergias,especialidad,detesp,receta_urgen,med,reg_ssa_urgen,fecha_recurgen,fec_pcita,hor_pcita) values ('.$id_atencion.','.$id_usua.',"'.$alergias.'","'.$esp.'","'.$detesp.'","'.$receta_urgen.'","'.$med.'","'.$reg_ssa_urgen.'","'.$fecha_actual.'","'.$fec_pcita.'","'.$hor_pcita.'")')  or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

    //redirección
    header('location: vista_recetario.php');
 //si no se enviaron datos


?>