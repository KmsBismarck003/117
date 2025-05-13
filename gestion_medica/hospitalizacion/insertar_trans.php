<?php
//se establece una conexion a la base de datos
include '../../conexionbd.php';
//si se han enviado datos
$id_usua = $_GET['id_usua'];
$id_atencion = $_GET['id_atencion'];

$fecha_actual = date("Y-m-d H:i:s");

	$fecht=$_POST['fecht'];
	$numt=$_POST['numt'];
	$cont=$_POST['cont'];
	$hor_in=$_POST['hor_in'];
	$t=$_POST['t'];
	$td=$_POST['td'];
	$tde=$_POST['tde'];
	$a=$_POST['a'];
	$ad=$_POST['ad'];
	$ade=$_POST['ade'];
	$fc=$_POST['fc'];
	$fcd=$_POST['fcd'];
	$fcde=$_POST['fcde'];
	$temp_t=$_POST['temp_t'];
	$temp_td=$_POST['temp_td'];
	$temp_tde=$_POST['temp_tde'];
	$hor_t=$_POST['hor_t'];
	$vol=$_POST['vol'];
	$nom=$_POST['nom'];
	$estgen=$_POST['estgen'];
	//////////////////////////////////////////////
	$fecht2=$_POST['fecht2'];
	$numt2=$_POST['numt2'];
	$cont2=$_POST['cont2'];
	$hor_in2=$_POST['hor_in2'];
	$t2=$_POST['t2'];
	$td2=$_POST['td2'];
	$tde2=$_POST['tde2'];
	$a2=$_POST['a2'];
	$ad2=$_POST['ad2'];
	$ade2=$_POST['ade2'];
	$fc2=$_POST['fc2'];
	$fcd2=$_POST['fcd2'];
	$fcde2=$_POST['fcde2'];
	$temp_t2=$_POST['temp_t2'];
	$temp_td2=$_POST['temp_td2'];
	$temp_tde2=$_POST['temp_tde2'];
	$hor_t2=$_POST['hor_t2'];
	$vol2=$_POST['vol2'];
	$nom2=$_POST['nom2'];
	$estgen2=$_POST['estgen2'];
	/////////////////////////////////////////////
     $fecht3=$_POST['fecht3'];
	$numt3=$_POST['numt3'];
	$cont3=$_POST['cont3'];
	$hor_in3=$_POST['hor_in3'];
	$t3=$_POST['t3'];
	$td3=$_POST['td3'];
	$tde3=$_POST['tde3'];
	$a3=$_POST['a3'];
	$ad3=$_POST['ad3'];
	$ade3=$_POST['ade3'];
	$fc3=$_POST['fc3'];
	$fcd3=$_POST['fcd3'];
	$fcde3=$_POST['fcde3'];
	$temp_t3=$_POST['temp_t3'];
	$temp_td3=$_POST['temp_td3'];
	$temp_tde3=$_POST['temp_tde3'];
	$hor_t3=$_POST['hor_t3'];
	$vol3=$_POST['vol3'];
	$nom3=$_POST['nom3'];
	$estgen3=$_POST['estgen3'];
	////////////////////////////////////////////////

/*	$fecht4=$_POST['fecht4'];
	$numt4=$_POST['numt4'];
	$cont4=$_POST['cont4'];
	$hor_in4=$_POST['hor_in4'];
	$t4=$_POST['t4'];
	$td4=$_POST['td4'];
	$tde4=$_POST['tde4'];
	$a4=$_POST['a4'];
	$ad4=$_POST['ad4'];
	$ade4=$_POST['ade4'];
	$fc4=$_POST['fc4'];
	$fcd4=$_POST['fcd4'];
	$fcde4=$_POST['fcde4'];
	$temp_t4=$_POST['temp_t4'];
	$temp_td4=$_POST['temp_td4'];
	$temp_tde4=$_POST['temp_tde4'];
	$hor_t4=$_POST['hor_t4'];
	$vol4=$_POST['vol4'];
	$nom4=$_POST['nom4'];
	$estgen4=$_POST['estgen4'];
	///////////////////////////////////////////
	$fecht5=$_POST['fecht5'];
	$numt5=$_POST['numt5'];
	$cont5=$_POST['cont5'];
	$hor_in5=$_POST['hor_in5'];
	$t5=$_POST['t5'];
	$td5=$_POST['td5'];
	$tde5=$_POST['tde5'];
	$a5=$_POST['a5'];
	$ad5=$_POST['ad5'];
	$ade5=$_POST['ade5'];
	$fc5=$_POST['fc5'];
	$fcd5=$_POST['fcd5'];
	$fcde5=$_POST['fcde5'];
	$temp_t5=$_POST['temp_t5'];
	$temp_td5=$_POST['temp_td5'];
	$temp_tde5=$_POST['temp_tde5'];
	$hor_t5=$_POST['hor_t5'];
	$vol5=$_POST['vol5'];
	$nom5=$_POST['nom5'];
	$estgen5=$_POST['estgen5'];*/
	////////////////////////////////////

  //signos vitales   
    

    $resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_sig DESC LIMIT 1") or die($conexion->error);
    while ($f5 = mysqli_fetch_array($resultado5)) {
 $atencion=$f5['id_sig'];
}
if ($atencion == NULL) {

$p_sistol = ($_POST['p_sistol']);
    $p_diastol = ($_POST['p_diastol']);
    $fcard = ($_POST['fcard']);
    $fresp = ($_POST['fresp']);
    $temper = ($_POST['temper']);
    $satoxi = ($_POST['satoxi']);
    $peso = ($_POST['peso']);
    $talla = ($_POST['talla']);

$ingresar = mysqli_query($conexion, 'INSERT INTO signos_vitales (id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,peso,talla) values (' . $id_atencion . ' , ' . $id_usua . ' ," ' . $fecha_actual . '", " ' . $p_sistol . '" , "' . $p_diastol . '" , "' .$fcard . '" , "' . $fresp . '" , "' . $temper . ' ", "' . $satoxi . ' " ,"' . $peso . '", " ' . $talla . ' ") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

}

$insert=mysqli_query($conexion,'INSERT INTO dat_trans_sangre(id_atencion,id_usua,fecht,numt,cont,hor_in,t,td,tde,a,ad,ade,fc,fcd,fcde,temp_t,temp_td,temp_tde,hor_t,vol,nom,estgen) VALUE('.$id_atencion.','.$id_usua.',"'.$fecht.'","'.$numt.'","'.$cont.'","'.$hor_in.'","'.$t.'","'.$td.'","'.$tde.'","'.$a.'","'.$ad.'","'.$ade.'","'.$fc.'","'.$fcd.'","'.$fcde.'","'.$temp_t.'","'.$temp_td.'","'.$temp_tde.'","'.$hor_t.'","'.$vol.'","'.$nom.'","'.$estgen.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


if($_POST['fecht2'] != NULL){
    $id_usua2 = $_GET['id_usua'];
    $id_atencion2 = $_GET['id_atencion'];

	$insert1=mysqli_query($conexion,'INSERT INTO dat_trans_sangre(id_atencion,id_usua,fecht,numt,cont,hor_in,t,td,tde,a,ad,ade,fc,fcd,fcde,temp_t,temp_td,temp_tde,hor_t,vol,nom,estgen) VALUE('.$id_atencion2.','.$id_usua2.',"'.$fecht2.'","'.$numt2.'","'.$cont2.'","'.$hor_in2.'","'.$t2.'","'.$td2.'","'.$tde2.'","'.$a2.'","'.$ad2.'","'.$ade2.'","'.$fc2.'","'.$fcd2.'","'.$fcde2.'","'.$temp_t2.'","'.$temp_td2.'","'.$temp_tde2.'","'.$hor_t2.'","'.$vol2.'","'.$nom2.'","'.$estgen2.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


}else{

	header('location: ../hospitalizacion/vista_pac_hosp.php');
}
	

if($_POST['fecht3'] != NULL){

	$id_usua3 = $_GET['id_usua'];
$id_atencion3 = $_GET['id_atencion'];


$insert2=mysqli_query($conexion,'INSERT INTO dat_trans_sangre(id_atencion,id_usua,fecht,numt,cont,hor_in,t,td,tde,a,ad,ade,fc,fcd,fcde,temp_t,temp_td,temp_tde,hor_t,vol,nom,estgen) VALUE('.$id_atencion3.','.$id_usua3.',"'.$fecht3.'","'.$numt3.'","'.$cont3.'","'.$hor_in3.'","'.$t3.'","'.$td3.'","'.$tde3.'","'.$a3.'","'.$ad3.'","'.$ade3.'","'.$fc3.'","'.$fcd3.'","'.$fcde3.'","'.$temp_t3.'","'.$temp_td3.'","'.$temp_tde3.'","'.$hor_t3.'","'.$vol3.'","'.$nom3.'","'.$estgen3.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


}else{

	header('location: ../hospitalizacion/vista_pac_hosp.php');
}

/*
if($_POST['fecht4']!= NULL){

$id_usua4 = $_GET['id_usua'];
$id_atencion4 = $_GET['id_atencion'];

$insert3=mysqli_query($conexion,'INSERT INTO dat_trans_sangre(id_atencion,id_usua,fecht,numt,cont,hor_in,t,td,tde,a,ad,ade,fc,fcd,fcde,temp_t,temp_td,temp_tde,hor_t,vol,nom,estgen) VALUE('.$id_atencion4.','.$id_usua4.',"'.$fecht4.'","'.$numt4.'","'.$cont4.'","'.$hor_in4.'","'.$t4.'","'.$td4.'","'.$tde4.'","'.$a4.'","'.$ad4.'","'.$ade4.'","'.$fc4.'","'.$fcd4.'","'.$fcde4.'","'.$temp_t4.'","'.$temp_td4.'","'.$temp_tde4.'","'.$hor_t4.'","'.$vol4.'","'.$nom4.'","'.$estgen4.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


}else{

	header('location: vista_recetario_medico.php');
}


if($_POST['fecht4']!= NULL){

	$id_usua5 = $_GET['id_usua'];
$id_atencion5 = $_GET['id_atencion'];

$insert4=mysqli_query($conexion,'INSERT INTO dat_trans_sangre(id_atencion,id_usua,fecht,numt,cont,hor_in,t,td,tde,a,ad,ade,fc,fcd,fcde,temp_t,temp_td,temp_tde,hor_t,vol,nom,estgen) VALUE('.$id_atencion5.','.$id_usua5.',"'.$fecht5.'","'.$numt5.'","'.$cont5.'","'.$hor_in5.'","'.$t5.'","'.$td5.'","'.$tde5.'","'.$a5.'","'.$ad5.'","'.$ade5.'","'.$fc5.'","'.$fcd5.'","'.$fcde5.'","'.$temp_t5.'","'.$temp_td5.'","'.$temp_tde5.'","'.$hor_t5.'","'.$vol5.'","'.$nom5.'","'.$estgen5.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


}else{

	header('location: vista_recetario_medico.php');
}*/


header('location: ../hospitalizacion/vista_pac_hosp.php');
