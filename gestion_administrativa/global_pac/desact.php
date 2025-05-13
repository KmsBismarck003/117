<?php 
include '../../conexionbd.php';

$id_exp=$_POST['id'];

$select="SELECT * FROM paciente p , dat_ingreso d WHERE p.Id_exp=$id_exp and d.Id_exp=p.Id_exp";
$resultado_pac=$conexion->query($select);
while ($row=$resultado_pac->fetch_assoc()) {
	$id_atencion=$row['id_atencion'];
}

$update="UPDATE dat_ingreso SET area=' ',motivo_atn=' ',alta_med='DS', alta_adm='DS',activo='DS', valida='DS', cama_alta=0 WHERE id_atencion=$id_atencion";
$resultado=$conexion->query($update);

/*$update_diag="DELETE FROM diag_pac WHERE Id_exp=$id_atencion";
$resultado=$conexion->query($update_diag);

$update_diag="DELETE FROM dat_financieros WHERE id_atencion=$id_atencion";
$resultado=$conexion->query($update_diag);*/

$sql2 = "UPDATE cat_camas SET estatus = 'LIBRE', id_atencion=0 WHERE id_atencion = $id_atencion";
$result = $conexion->query($sql2);

echo '<script type="text/javascript">window.location.href = "pac_global.php";</script>';

 ?>