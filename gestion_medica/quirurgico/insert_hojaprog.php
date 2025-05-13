<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];
$fecha_actual = date("Y-m-d H:i:s");

/*if (isset($_POST['tipo_cirugia_preop'])) {
	if($tipo_cirugia_preop="URGENCIA"){
$tipo_cirugia_preop= $_POST['tipo_cirugia_preop'];
	}
	if($tipo_cirugia_preop="ELECTIVA"){
$tipo_cirugia_preop= $_POST['tipo_cirugia_preop'];
	}

}*/
$tipo_cir=$_POST['tipo_cir'];
$fecha_sol=$_POST['fecha_sol'];
$hora_sol=$_POST['hora_sol'];
$hb=$_POST['hb'];
$ht=$_POST['ht'];
$persona=$_POST['persona'];
$tiempo_estimado=$_POST['tiempo_estimado'];
$matye=$_POST['matye'];
$ope_proyectada=$_POST['ope_proyectada'];
$est_transo=$_POST['est_transo'];
$diag_preop=$_POST['diag_preop'];
$d_posto=$_POST['d_posto'];
$ope_realizada=$_POST['ope_realizada'];
$cirujano=$_POST['cirujano'];
$anest=$_POST['anest'];
//$tipo_ane=$_POST['tipo_ane'];

// tipo de sangre
  $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias, p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";
      $result_pac = $conexion->query($sql_pac);
      while ($row_pac = $result_pac->fetch_assoc()) {
        $tip_san=$row_pac['tip_san'];
      }

$result=mysqli_query($conexion,'INSERT INTO hprog_quir (id_usua,id_atencion,fecha_registro,tipo_cir,fecha_sol,hora_sol,hb,ht,persona,tiempo_estimado,matye,ope_proyectada,est_transo,diag_preop,d_posto,ope_realizada,cirujano,anest,tip_sangre) 
	VALUES('.$id_usua.','.$id_atencion.',"'.$fecha_actual.'","'.$tipo_cir.'","'.$fecha_sol.'","'.$hora_sol.'","'.$hb.'","'.$ht.'","'.$persona.'","'.$tiempo_estimado.'","'.$matye.'","'.$ope_proyectada.'","'.$est_transo.'","'.$diag_preop.'","'.$d_posto.'","'.$ope_realizada.'","'.$cirujano.'","'.$anest.'","'.$tip_san.'")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


header('location: ../hospitalizacion/vista_pac_hosp.php');


?>