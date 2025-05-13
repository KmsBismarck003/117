<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$anest=$_POST['anest'];
$diagposto=$_POST['diagposto'];
$opreal=$_POST['opreal'];
$anestreal=$_POST['anestreal'];
$poscui=$_POST['poscui'];
$ind=$_POST['ind'];
$hora=$_POST['hora'];
$agdo=$_POST['agdo'];
$tin=$_POST['in'];
$masc=$_POST['masc'];
$can=$_POST['can'];
$otro=$_POST['otro'];
$larin=$_POST['larin'];
$venti=$_POST['venti'];
$cir=$_POST['cir'];
$esasme=$_POST['esasme'];
$mec=$_POST['mec'];
$modo=$_POST['modo'];
$fl=$_POST['fl'];
$vcor=$_POST['vcor'];
$fr=$_POST['fr'];
$rel=$_POST['rel'];
$peep=$_POST['peep'];
if (isset($_POST['com'])) {$com=$_POST['com'];} else {$com='NO';}
$mant=$_POST['mant'];
$relaj=$_POST['relaj'];
$agent=$_POST['agent'];
$dosis=$_POST['dosis'];
$ultdosis=$_POST['ultdosis'];
$ant=$_POST['ant'];
$agdos=$_POST['agdos'];
$monit=$_POST['monit'];
if (isset($_POST['comen'])) {$comen=$_POST['comen'];} else {$comen='NO';}
$bloq=$_POST['bloq'];
$agdosi=$_POST['agdosi'];
$tec=$_POST['tec'];
$cate=$_POST['cate'];
$posi=$_POST['posi'];
$lat=$_POST['lat'];
$asep=$_POST['asep'];
$dif=$_POST['dif'];
$aguja=$_POST['aguja'];
$bsim=$_POST['bsim'];
$bmotor=$_POST['bmotor'];
$bsen=$_POST['bsen'];
if (isset($_POST['coment'])) {$coment=$_POST['coment'];} else {$coment='NO';}
$caso=$_POST['caso'];
$emer=$_POST['emer'];
//$encaso=$_POST['encaso'];
//$fecha=$_POST['fecha'];
//$hora2=$_POST['hora2'];

 
 $fecha_actual = date("Y-m-d H:i:s");



$insertar= mysqli_query($conexion,'INSERT dat_trans_anest(id_atencion,id_usua,anest,diagposto,opreal,anestreal,poscui,ind,hora,agdo,tin,masc,can,otro,larin,venti,cir,esasme,mec,modo,fl,vcor,fr,rel,peep,com,mant,relaj,agent,dosis,ultdosis,ant,agdos,monit,comen,bloq,agdosi,tec,cate,posi,lat,asep,dif,aguja,bsim,bmotor,bsen,coment,caso,emer,fecha) values('.$id_atencion.','.$id_usua.',"'.$anest.'","'.$diagposto.'","'.$opreal.'","'.$anestreal.'","'.$poscui.'","'.$ind.'","'.$hora.'","'.$agdo.'","'.$tin.'","'.$masc.'","'.$can.'","'.$otro.'","'.$larin.'","'.$venti.'","'.$cir.'","'.$esasme.'","'.$mec.'","'.$modo.'","'.$fl.'","'.$vcor.'","'.$fr.'","'.$rel.'","'.$peep.'","'.$com.'","'.$mant.'","'.$relaj.'","'.$agent.'","'.$dosis.'","'.$ultdosis.'","'.$ant.'","'.$agdos.'","'.$monit.'","'.$comen.'","'.$bloq.'","'.$agdosi.'","'.$tec.'","'.$cate.'","'.$posi.'","'.$lat.'","'.$asep.'","'.$dif.'","'.$aguja.'","'.$bsim.'","'.$bmotor.'","'.$bsen.'","'.$coment.'","'.$caso.'","'.$emer.'","'.$fecha_actual.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

header('location: ../hospitalizacion/vista_pac_hosp.php');
?>