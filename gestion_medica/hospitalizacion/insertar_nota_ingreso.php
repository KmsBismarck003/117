<?php
//se establece una conexion a la base de datos
session_start();
include '../../conexionbd.php';
//si se han enviado datos
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$fecha_actual = date("Y-m-d H:i:s");

$mot_ingreso = ($_POST['mot_ingreso']);
$resinterr_i = ($_POST['resinterr_i']);
$expfis_i = ($_POST['expfis_i']);
$resaux_i = ($_POST['resaux_i']);
$diagprob_i = ($_POST['diagprob_i']);
$des_diag = ($_POST['des_diag']);
$plan_i = ($_POST['plan_i']);
$pron_i = ($_POST['pron_i']);
$guia = ($_POST['guia']);

    $p_sistol = ($_POST['p_sistol']);
    $p_diastol = ($_POST['p_diastol']);
    $fcard = ($_POST['fcard']);
    $fresp = ($_POST['fresp']);
    $temper = ($_POST['temper']);
    $satoxi = ($_POST['satoxi']);
    
    $fecha_actual = date("Y-m-d H:i:s");

    
    $fecha_actual3 = date("Y-m-d H:i:s");
    $fecha_actual2 = date("Y-m-d");
    $fecha_actual4 = date("H");
 
 //diagnosticos tabla
$diag="SELECT * FROM dat_ingreso where id_atencion=$id_atencion";
$result=$conexion->query($diag);
while ($row=$result->fetch_assoc()) {
  $motivo_atn=$row['motivo_atn'];
  $area = $row['area'];
}

if ($diagprob_i !== $motivo_atn) {
     $diag=mysqli_query($conexion,'insert into diag_pac(Id_exp,id_usua,diag_paciente,fecha) values ('.$id_atencion.','.$id_usua.',"'.$diagprob_i.'","'.$fecha_actual.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));
}

$sql2 = "UPDATE dat_ingreso SET motivo_atn = '$diagprob_i' WHERE id_atencion = $id_atencion";
      $result = $conexion->query($sql2);
$ingresar = mysqli_query($conexion, 'INSERT INTO signos_vitales 
(id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,tipo,fecha_registro,hora) values 
('.$id_atencion.','.$id_usua.',"'.$fecha_actual.'","'.$p_sistol.'","'.$p_diastol.'","'.$fcard.'","'.$fresp.'","'.$temper.'","'.$satoxi.'","'.$area.'","'.$fecha_actual3.'","'.$fecha_actual4.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));




$ingresaringreso = mysqli_query($conexion, 'INSERT INTO dat_not_ingreso (id_atencion,id_usua,fecha_dat_ingreso,mot_ingreso,resinterr_i,expfis_i,resaux_i,diagprob_i,plan_i,pron_i,guia,des_diag) values (' . $id_atencion . ' , ' . $id_usua . ' ,"' . $fecha_actual . '", "' . $mot_ingreso . '" , "' . $resinterr_i . '" , "' . $expfis_i . '" , "' . $resaux_i . ' ", "' . $diagprob_i . ' " ,"' . $plan_i . '", "' . $pron_i . '","' . $guia . '","' . $des_diag . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));



    //redirección
    header('location: ../hospitalizacion/vista_pac_hosp.php');
 //si no se enviaron datos


