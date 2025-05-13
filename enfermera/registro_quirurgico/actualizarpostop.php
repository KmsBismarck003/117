<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];

$fecha = date("Y-m-d");

$ter_anes=$_POST['ter_anes'];
$tip_cir=$_POST['tip_cir'];

$p_medico2=$_POST['p_medico2'];
$dispo_p=$_POST['dispo_p'];

$diagyodc2=$_POST['diagyodc2'];

$p_anato2=$_POST['p_anato2'];
$tipo_de_i2=$_POST['tipo_de_i2'];

$sitio_ob2=$_POST['sitio_ob2'];
$estudios_obser2=$_POST['estudios_obser2'];



if(isset($_POST["id_enf_post"])){$id_enf_post=$_POST["id_enf_post"];}else{$id_enf_post="";}

if(isset($_POST["oxi"])){$oxi=$_POST["oxi"];}else{$oxi="";}
if(isset($_POST["con"])){$con=$_POST["con"];}else{$con="";}
if(isset($_POST["muc"])){$muc=$_POST["muc"];}else{$muc="";}
if(isset($_POST["vent"])){$vent=$_POST["vent"];}else{$vent="";}
if(isset($_POST["est"])){$est=$_POST["est"];}else{$est="";}

$notapost2=$_POST['notapost2'];

if(isset($_POST["cir_real"])){$cir_real=$_POST["cir_real"];}else{$cir_real="";}

$actualizar = mysqli_query($conexion,"UPDATE enf_posto SET fecha = '$fecha', ter_anes='$ter_anes',tip_cir='$tip_cir',p_medico=CONCAT(p_medico,'".", ".$p_medico2."'),dispo_p='$dispo_p',diagyodc=CONCAT(diagyodc,'".", ".$diagyodc2."'),p_anato=CONCAT(p_anato,'".", ".$p_anato2."'),tipo_de_i=CONCAT(tipo_de_i,'".", ".$tipo_de_i2."'),sitio_ob=CONCAT(sitio_ob,'".", ".$sitio_ob2."'),estudios_obser=CONCAT(estudios_obser,'".", ".$estudios_obser2."'),oxi='$oxi',con='$con',muc='$muc',vent='$vent',est='$est',notapost=CONCAT(notapost,'".", ".$notapost2."'),id_usua2='$id_usua',cir_real='$cir_real' WHERE id_enf_post = $id_enf_post");
echo mysqli_query($conexion,$actualizar);

$resultado = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='$id_usua'") or die($conexion->error);
$usuario = $_SESSION['login'];
while($f = mysqli_fetch_array($resultado)){   
     $id_us=$f['papell'];
}

$fechactr = date("Y-m-d H:i");
$ingresar2 = mysqli_query($conexion, 'INSERT INTO control_enf (nom_enf,id_usua,id_atencion,nota,fecha) values ("' . $id_us . '",' . $id_usua . ' ,' . $id_atencion . ',"Nota postoperatoria","' . $fechactr . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
echo mysqli_query($conexion,$ingresar2);