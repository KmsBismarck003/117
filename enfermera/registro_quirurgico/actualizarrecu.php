<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];

$fecha = date("Y-m-d");
$id_recu =  mysqli_real_escape_string($conexion, (strip_tags($_POST["id_recu"], ENT_QUOTES)));

$not_recu2 =  mysqli_real_escape_string($conexion, (strip_tags($_POST["not_recu2"], ENT_QUOTES)));
$imagen2 =  mysqli_real_escape_string($conexion, (strip_tags($_POST["imagen2"], ENT_QUOTES)));
$incidentes2 =  mysqli_real_escape_string($conexion, (strip_tags($_POST["incidentes2"], ENT_QUOTES)));

$inicio_cir =  mysqli_real_escape_string($conexion, (strip_tags($_POST["inicio_cir"], ENT_QUOTES)));
$ter_cir =  mysqli_real_escape_string($conexion, (strip_tags($_POST["ter_cir"], ENT_QUOTES)));

if(isset($_POST['cirujano2'])){$cirujano2=$_POST['cirujano2'];}else{$cirujano2='';}
if(isset($_POST['anestesiologo2'])){$anestesiologo2=$_POST['anestesiologo2'];}else{$anestesiologo2='';}
if(isset($_POST['instrumentista2'])){$instrumentista2=$_POST['instrumentista2'];}else{$instrumentista2='';}

if(isset($_POST['circulante'])){$circulante=$_POST['circulante'];}else{$circulante='';}


if(isset($_POST['trauma2'])){$trauma2=$_POST['trauma2'];}else{$trauma2='';}
if(isset($_POST['neuro2'])){$neuro2=$_POST['neuro2'];}else{$neuro2='';}
if(isset($_POST['maxi2'])){$maxi2=$_POST['maxi2'];}else{$maxi2='';}
if(isset($_POST['gastro2'])){$gastro2=$_POST['gastro2'];}else{$gastro2='';}
if(isset($_POST['onco2'])){$onco2=$_POST['onco2'];}else{$onco2='';}
if(isset($_POST['gine2'])){$gine2=$_POST['gine2'];}else{$gine2='';}
if(isset($_POST['bari2'])){$bari2=$_POST['bari2'];}else{$bari2='';}

if(isset($_POST['p_a2'])){$p_a2=$_POST['p_a2'];}else{ $p_a2='';}
if(isset($_POST['s_a2'])){$s_a2=$_POST['s_a2'];}else{ $s_a2='';}
if(isset($_POST['t_a2'])){$t_a2=$_POST['t_a2'];}else{ $t_a2='';}


$actualizar = mysqli_query($conexion,"UPDATE recu SET not_recu=CONCAT(not_recu,'".", ".$not_recu2."'),text_fecha = '$fecha', inicio_cir='$inicio_cir',imagen=CONCAT(imagen,'".", ".$imagen2."'),incidentes=CONCAT(incidentes,'".", ".$incidentes2."'),ter_cir='$ter_cir',cirujano=CONCAT(cirujano,'".", ".$cirujano2."'),anestesiologo=CONCAT(anestesiologo,'".", ".$anestesiologo2."'),instrumentista=CONCAT(instrumentista,'".", ".$instrumentista2."'),circulante='$circulante',p_a=CONCAT(p_a,'".", ".$p_a2."'),s_a=CONCAT(s_a,'".", ".$s_a2."'),t_a=CONCAT(t_a,'".", ".$t_a2."'),trauma=CONCAT(trauma,'".", ".$trauma2."'),neuro=CONCAT(neuro,'".", ".$neuro2."'),maxi=CONCAT(maxi,'".", ".$maxi2."'),gastro=CONCAT(gastro,'".", ".$gastro2."'),onco=CONCAT(onco,'".", ".$onco2."'),gine=CONCAT(gine,'".", ".$gine2."'),bari=CONCAT(bari,'".", ".$bari2."'),id_usua2='$id_usua',sala=sala WHERE id_recu = $id_recu");
echo mysqli_query($conexion,$actualizar);

$resultado = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='$id_usua'") or die($conexion->error);
$usuario = $_SESSION['login'];
while($f = mysqli_fetch_array($resultado)){   
     $id_us=$f['papell'];
}

$fechactr = date("Y-m-d H:i");
$ingresar2 = mysqli_query($conexion, 'INSERT INTO control_enf (nom_enf,id_usua,id_atencion,nota,fecha) values ("' . $id_us . '",' . $id_usua . ' ,' . $id_atencion . ',"Nota transoperatoria","' . $fechactr . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
echo mysqli_query($conexion,$ingresar2);