
<?php
date_default_timezone_set('America/Guatemala');

$servidor="localhost";
$nombreBd="u542863078_facturacion";
$usuario="u542863078_sima_fac";
$pass="Lh?0y=;/";
$conexion=new mysqli($servidor,$usuario,$pass,$nombreBd);
$conexion -> set_charset("utf8");
if($conexion-> connect_error){
die("No se pudo conectar");
}
?>
