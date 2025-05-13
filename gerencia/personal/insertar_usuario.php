<?php
include '../conexionbd.php';
//se establece una conexion a la base de datos

//si se han enviado datos
if (isset($_POST['curp_u']) and isset($_POST['rfc']) and isset($_POST['nombre']) and isset($_POST['papell']) and isset($_POST['sapell']) and isset($_POST['fecnac']) and isset($_POST['sexo']) and isset($_POST['mat']) and isset($_POST['cedp']) and isset($_POST['cargp']) and isset($_POST['tel']) and isset($_POST['email']) and isset($_POST['nac']) and isset($_POST['pre']) and isset($_POST['rol']) and isset($_POST['pass']) and isset($_POST['id_rol'])){

$name = $_FILES['img_perfil']['name'];
$carpeta="../imagenes/";
$temp=explode('.' ,$name);
$extension= end($temp);
$nombreFinal=time().'.'.$extension;

$fir = $_FILES['firma']['name'];
$carpetafirma="../imgfirma/";
$tempfirma=explode('.' ,$fir);
$extensionfirma= end($tempfirma);
$nombreFinalfirma=time().'.'.$extensionfirma;

if($extension=='jpg' || $extension=='png'){
	if(move_uploaded_file($_FILES['img_perfil']['tmp_name'], $carpeta.$nombreFinal)){
		if(move_uploaded_file($_FILES['firma']['tmp_name'], $carpetafirma.$nombreFinalfirma)){

$curp_u=($_POST['curp_u']);
$rfc=($_POST['rfc']);
$nombre=($_POST['nombre']);
$papell=($_POST['papell']);
$sapell=($_POST['sapell']);
$fecnac=($_POST['fecnac']);
$sexo=($_POST['sexo']);
$mat=($_POST['mat']);
$cedp=($_POST['cedp']);
$cargp=($_POST['cargp']);
$tel=($_POST['tel']);
$email=($_POST['email']);
$nac=($_POST['nac']);
$pre=($_POST['pre']);
$rol=($_POST['rol']);
$pass=($_POST['pass']);
$id_rol=($_POST['id_rol']);

    $ingresar=mysqli_query($conexion,'insert into reg_usuarios (curp_u,rfc,nombre,papell,sapell,fecnac,sexo,mat,cedp,cargp,tel,email,nac,pre,rol,pass,id_rol,img_perfil,firma) values
    ("'.$curp_u.'","'.$rfc.'","'.$nombre.'","'.$papell.'","'.$sapell.'","'.$fecnac.'","'.$sexo.'","'.$mat.'","'.$cedp.'","'.$cargp.'","'.$tel.'","'.$email.'","'.$nac.'","'.$pre.'","'.$rol.'","'.$pass.'","'.$id_rol.'","'.$nombreFinal.'","'.$nombreFinalfirma.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

header ('location: alta_usuarios.php');

}//si no se enviaron datos
}
}
}
else{
    header ('location: /alta_usuarios.php');
}
?>

