<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];

$id_quir2=$_POST['id_quir2'];


$fecha = date("Y-m-d");
$hora=$_POST['hora'];
$horac=$_POST['horac'];

$not_preop=$_POST['not_preop'];
$not_preop2=$_POST['not_preop2'];

$in_isq=$_POST['in_isq'];

$tipan=$_POST['tipan'];
$tipan2=$_POST['tipan2'];

$horaas=$_POST['horaas'];
$asepsia=$_POST['asepsia'];


if(isset($_POST["otros_asep"])){$otros_asep=$_POST["otros_asep"];}else{$otros_asep="";}
if(isset($_POST["otros_asep2"])){$otros_asep2=$_POST["otros_asep2"];}else{$otros_asep2="";}
if(isset($_POST["cir_prog"])){$cir_prog=$_POST["cir_prog"];}else{$cir_prog="";}

$actualizar = mysqli_query($conexion,"UPDATE enf_quirurgico SET fecha = '$fecha', hora='$hora',in_isq='$in_isq',not_preop=CONCAT(not_preop,'".", ".$not_preop2."'),tipan=CONCAT(tipan,'".", ".$tipan2."'),asepsia='$asepsia',horac='$horac',horaas='$horaas',otros_asep=CONCAT(otros_asep,'".", ".$otros_asep2."'),id_usua2='$id_usua',cir_prog='$cir_prog' WHERE id_quir = $id_quir2");
echo mysqli_query($conexion,$actualizar);

$resultado = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='$id_usua'") or die($conexion->error);
$usuario = $_SESSION['login'];
while($f = mysqli_fetch_array($resultado)){   
     $id_us=$f['papell'];
}

$fechactr = date("Y-m-d H:i");
$ingresar2 = mysqli_query($conexion, 'INSERT INTO control_enf (nom_enf,id_usua,id_atencion,nota,fecha) values ("' . $id_us . '",' . $id_usua . ' ,' . $id_atencion . ',"Nota preoperatoria","' . $fechactr . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
echo mysqli_query($conexion,$ingresar2);