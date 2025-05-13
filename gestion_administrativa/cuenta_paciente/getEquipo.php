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
$seudonimo = $_GET['equipo'];
	
	$sql="SELECT * from c_cliente where razon_s LIKE '$seudonimo' LIMIT 1";
			$result=mysqli_query($conexion,$sql);
			if(mysqli_num_rows($result) > 0){

		$equipo = mysqli_fetch_object($result);
		$equipo->status = 200;
		echo json_encode($equipo);
	}else{
		$error = array('status' => 400);
		echo json_encode((object)$error);
	}
