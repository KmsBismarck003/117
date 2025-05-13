<?php
include '../../conexionbd.php';
$not_id=$_POST['not_id'];
$serv="DELETE FROM notificaciones_labo WHERE not_id=$not_id";
$resultado=$conexion->query($serv);
header ('location: resultados_labo.php');

       

?>