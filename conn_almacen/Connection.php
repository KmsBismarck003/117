<?php
date_default_timezone_set('America/Guatemala');

$servidor="localhost";
$nombreBd="u542863078_almacen_mac";
$usuario="u542863078_almacenMAC";
$pass="#4lm4c3nM@C";
$conexion_almacen=new mysqli($servidor,$usuario,$pass,$nombreBd);
$conexion_almacen -> set_charset("utf8");
if($conexion_almacen-> connect_error){
die("No se pudo conectar a la base de datos almacen_msis");
}
?>

