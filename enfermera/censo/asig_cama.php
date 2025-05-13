<?php
include "../../conexionbd.php";

$id_atencion = $_GET['id_atencion'];
$id_cam = $_GET['id_cam'];
$id_usua = $_GET['id_usua'];

$sql2 = "UPDATE cat_camas SET estatus = 'Ocupada', id_atencion= $id_atencion WHERE id = $id_cam";
$result = $conexion->query($sql2);

$sql3 = "UPDATE dat_ingreso SET cama='1' WHERE id_atencion = $id_atencion";
      $result = $conexion->query($sql3);

 $resultado3 = $conexion ->query("SELECT habitacion FROM cat_camas WHERE id = $id_cam ")or die($conexion->error);

  if(mysqli_num_rows($resultado3) > 0 ){ //se mostrara si existe mas de 1
      $f3=mysqli_fetch_row($resultado3);
      $habitacion=$f3[0];  
}


$fecha_actual = date("Y-m-d H:i:s");
            //// ingresar habitacion en insumo y id_atencion en id_atencion de la tabla dat_ctapac      
  $ingresar3=mysqli_query($conexion,'insert into dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,id_usua) values ('.$id_atencion.',"S","'.$habitacion.'","'.$fecha_actual.'","1",'.$id_usua.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato guadado correctamente...</p>";

header('Location:../censo/vista_habitacion.php');
