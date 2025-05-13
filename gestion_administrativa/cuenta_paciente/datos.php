<?php 
include "conexionbdf.php";
//$conexion=mysqli_connect('localhost','root','','prueba');
$asenta=$_POST['asenta'];

	$sql="SELECT id_col,
			 c_Colonia,
			 c_CodigoPostal,Nombre_asen 
		from c_colonia 
		where c_CodigoPostal='$asenta'";

	$result=mysqli_query($conexion,$sql);

	$cadena="<strong>Asentamiento</strong>
			<select id='lista2' name='asenta' class='form-control'>";

	while ($ver=mysqli_fetch_row($result)) {
		$cadena=$cadena.'<option value='.$ver[3].'>'.utf8_encode($ver[3]).'</option>';
	}	

	echo  $cadena."</select>";
	

?>