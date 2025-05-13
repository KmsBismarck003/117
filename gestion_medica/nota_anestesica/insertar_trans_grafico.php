<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$hora=$_POST['hora'];
$ina=$_POST['ina'];
$ino=$_POST['ino'];
$top=$_POST['top'];
$ta=$_POST['ta'];
$tanest=$_POST['tanest'];
$regional=$_POST['regional'];
$general=$_POST['general'];
$tiva=$_POST['tiva'];
$sistg=$_POST['sistg'];
$diastg=$_POST['diastg'];
$fcardg=$_POST['fcardg'];
$frespg=$_POST['frespg'];
$satg=$_POST['satg'];
$tempg=$_POST['tempg'];
$a=$_POST['a'];
$b=$_POST['b'];
$c=$_POST['c'];
$d=$_POST['d'];
$e=$_POST['e'];
$f=$_POST['f'];
$g=$_POST['g'];
$h=$_POST['h'];
$i=$_POST['i'];
$j=$_POST['j'];
$k=$_POST['k'];
$l=$_POST['l'];
$m=$_POST['m'];
$n=$_POST['n'];
$o=$_POST['o'];
$p=$_POST['p'];
$q=$_POST['q'];
$r=$_POST['r'];
$s=$_POST['s'];
$t=$_POST['t'];


$fecha_actual = date("Y-m-d H:i:s");


$resultado3 = $conexion->query("SELECT * from dat_trans_grafico WHERE id_atencion=$id_atencion ORDER BY id_trans_graf Desc") or die($conexion->error);

                while($f3 = mysqli_fetch_array($resultado3)){
$id_quir_graff=$f3['id_trans_graf'];
                }
                   
if($id_quir_graff==null){
$insertar= mysqli_query($conexion,'INSERT dat_trans_grafico(id_atencion,id_usua,hora,ina,ino,top,ta,tanest,regional,general,tiva,sistg,diastg,fcardg,frespg,satg,tempg,fecha_g,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,cuenta) values('.$id_atencion.','.$id_usua.',1,"'.$ina.'","'.$ino.'","'.$top.'","'.$ta.'","'.$tanest.'","'.$regional.'","'.$general.'","'.$tiva.'","'.$sistg.'","'.$diastg.'","'.$fcardg.'","'.$frespg.'","'.$satg.'","'.$tempg.'","'.$fecha_actual.'","'.$a.'","'.$b.'","'.$c.'","'.$d.'","'.$e.'","'.$f.'","'.$g.'","'.$h.'","'.$i.'","'.$j.'","'.$k.'","'.$l.'","'.$m.'","'.$n.'","'.$o.'","'.$p.'","'.$q.'","'.$r.'","'.$s.'","'.$t.'",1)') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

header('location: ../nota_anestesica/nota_registro_grafico.php');
}else if($id_quir_graff>0){

$resultado3 = $conexion->query("SELECT * from dat_trans_grafico WHERE id_atencion=$id_atencion ORDER BY cuenta Desc limit 1") or die($conexion->error);

                while($f3 = mysqli_fetch_array($resultado3)){
$cuenta=$f3['cuenta'];
                }
            $cuenta++;
$insertar= mysqli_query($conexion,'INSERT dat_trans_grafico(id_atencion,id_usua,hora,ina,ino,top,ta,tanest,regional,general,tiva,sistg,diastg,fcardg,frespg,satg,tempg,fecha_g,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,cuenta) values('.$id_atencion.','.$id_usua.',"'.$cuenta.'","'.$ina.'","'.$ino.'","'.$top.'","'.$ta.'","'.$tanest.'","'.$regional.'","'.$general.'","'.$tiva.'","'.$sistg.'","'.$diastg.'","'.$fcardg.'","'.$frespg.'","'.$satg.'","'.$tempg.'","'.$fecha_actual.'","'.$a.'","'.$b.'","'.$c.'","'.$d.'","'.$e.'","'.$f.'","'.$g.'","'.$h.'","'.$i.'","'.$j.'","'.$k.'","'.$l.'","'.$m.'","'.$n.'","'.$o.'","'.$p.'","'.$q.'","'.$r.'","'.$s.'","'.$t.'","'.$cuenta.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

header('location: ../nota_anestesica/nota_registro_grafico.php');
}
?>