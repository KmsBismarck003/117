<?php
//se establece una conexion a la base de datos
session_start();
include '../../conexionbd.php';
//si se han enviado datos
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$fecha_actual = date("Y-m-d H:i:s");

if(isset($_POST['p_sistolica'])){$p_sistolica = $_POST['p_sistolica'];}else{$p_sistolica = "";}
if(isset($_POST['p_diastolica'])){$p_diastolica = $_POST['p_diastolica'];}else{$p_diastolica= "";}
if(isset($_POST['f_card'])){$f_card = $_POST['f_card'];}else{$f_card = "";}
if(isset($_POST['f_resp'])){$f_resp = $_POST['f_resp'];}else{$f_resp = "";}
if(isset($_POST['temp'])){$temp = $_POST['temp'];}else{$temp = "";}
if(isset($_POST['sat_oxigeno'])){$sat_oxigeno = $_POST['sat_oxigeno'];}else{$sat_oxigeno = "";}

$referido = "NO";
if(isset($_POST['subjetivo'])){$subjetivo = $_POST['subjetivo'];}else{$subjetivo = "";}
if(isset($_POST['objetivo'])){$objetivo = $_POST['objetivo'];}else{$objetivo = "";}
if(isset($_POST['analisis'])){$analisis = $_POST['analisis'];}else{$analisis = "";}
if(isset($_POST['plan'])){$plan = $_POST['plan'];}else{$plan = "";}
if(isset($_POST['pronostico'])){$pronostico = $_POST['pronostico'];}else{$pronostico = "";}
if(isset($_POST['diagno'])){$diagno=$_POST['diagno'];}else{$diagno= "";}
if(isset($_POST['diagno_desc'])){$diagno_desc = $_POST['diagno_desc'];}else{$diagno_desc = "";}
if(isset($_POST['receta'])){$receta = $_POST['receta'];}else{$receta = "";}
if(isset($_POST['destino'])){$destino = $_POST['destino'];}else{$destino = "";}
if(isset($_POST['habitacion'])){$habitacion = $_POST['habitacion'];}else{$habitacion = "";}


if(isset($_POST['referido'])){$referido = $_POST['referido'];}else{$referido = "NO";}
if(isset($_POST['espec'])){$espec = $_POST['espec']; $referido="SI";}else{$espec = "OTRA";$referido = "NO";}
if(isset($_POST['id_usua2'])){$id_usua2 = $_POST['id_usua2'];$referido="SI";}else{$id_usua2= "0";$referido = "NO";}


$ingresar6 = mysqli_query($conexion, 'INSERT INTO dat_c_obs (
id_atencion,fecha_t,id_usua,p_sistolica,p_diastolica,f_card,f_resp,temp,sat_oxigeno,subjetivo,objetivo,analisis,plan,pronostico,diagno,diagno_desc,receta,destino,referido,espec,id_usua2) values 
('.$id_atencion.',"'.$fecha_actual.'",'.$id_usua.','.$p_sistolica.','.$p_diastolica.','.$f_card.','.$f_resp.','.$temp.','.$sat_oxigeno.',
"'.$subjetivo.'","'.$objetivo.'","'.$analisis.'","'.$plan.'","'.$pronostico.'","'.$diagno.'","'.$diagno_desc.'","'.$receta.'","'.$destino.'","'.$referido.'",
"'.$espec.'",'.$id_usua2.')') or die('<p>Error al registrar CONSULTA</p><br>' . mysqli_error($conexion));

$insertar=mysqli_query($conexion,'INSERT INTO recetaurgen(id_atencion,id_usua,receta_urgen,fecha_recurgen) values ('.$id_atencion.','.$id_usua.',"'.$receta.'","'.$fecha_actual.'")')  or die('<p>Error al registrar RECETA</p><br>' . mysqli_error($conexion));

//diagnosticos tabla
$diag=mysqli_query($conexion,'INSERT INTO diag_pac(Id_exp,id_usua,diag_paciente,fecha) values ('.$id_atencion.','.$id_usua.',"'.$diagno.'","'.$fecha_actual.'")') or die ('<p>Error al registrar DIAGNOSTICO</p><br>'.mysqli_error($conexion));

//signos vitales tabla
$fecha_actual3 = date("Y-m-d H:i:s");
$fecha_actual2 = date("Y-m-d");
$ingresar=mysqli_query($conexion,'INSERT INTO signos_vitales(id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,tipo,fecha_registro) values
    ("'.$id_atencion.'",' . $id_usua . ',"'.$fecha_actual2.'","'.$p_sistolica.'","'.$p_diastolica.'","'.$f_card.'","'.$f_resp.'","'.$temp.'","'.$sat_oxigeno.'","OBSERVACIÓN","'.$fecha_actual3.'")') or die ('<p>Error al registrar SIGNOS</p><br>'.mysqli_error($conexion));
    
if ($destino == 'ALTA'){
    $ingresar=mysqli_query($conexion,'UPDATE dat_ingreso SET area = "'.$destino.'", alta_med = "SI", cama="0"  WHERE dat_ingreso.id_atencion = "'.$id_atencion.'" ');
}
else {
    $id_cam = $_POST['habitacion'];
    $sqlc = "SELECT tipo FROM cat_camas WHERE id = $id_cam";
    $resultc = $conexion->query($sqlc);
    while($row=$resultc->fetch_assoc()){
        $tipo = $row['tipo'];
    } 
    $ingresar=mysqli_query($conexion,'UPDATE dat_ingreso SET area = "'.$tipo.'"cama="1", WHERE dat_ingreso.id_atencion = "'.$id_atencion.'" ');
}

if(isset($_POST['habitacion'])){
    
    $sql_hab = "UPDATE cat_camas cc SET estatus = 'LIBRE', id_atencion = 0 WHERE cc.id_atencion = $id_atencion";
    $result_hab = $conexion->query($sql_hab);                                                                                    
    
    $id_cam = $_POST['habitacion'];
    //// update de  camas id_atencion
    $sql2 = "UPDATE cat_camas SET estatus = 'OCUPADA', id_atencion= $id_atencion WHERE id = $id_cam";
    $result = $conexion->query($sql2);
    $sql3 = "UPDATE dat_ingreso SET cama='1', area = $tipo WHERE id_atencion = $id_atencion";
    $result = $conexion->query($sql3);
}  
else { $sql3 = "UPDATE dat_ingreso SET alta_med='SI', area = 'ALTA', cama='0' WHERE id_atencion = $id_atencion";}

 header('location: ../hospitalizacion/vista_pac_hosp.php');

?>