<?php
include './conexionbd.php';

$Id_exp=mysqli_fetch_row($fila);
$conexion->query("delete from paciente where Id_exp=".$_POST['Id_exp']);
echo 'Listo';

?>