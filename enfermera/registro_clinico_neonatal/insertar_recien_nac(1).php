<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usu = $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];

$fechab=$_POST['fechab'];
$horab=$_POST['horab'];

if($_POST['tempb']){$tempb=$_POST['tempb'];}else{$tempb='';}
if($_POST['pulsob']){$pulsob=$_POST['pulsob'];}else{$pulsob='';}
if($_POST['respb']){$respb=$_POST['respb'];}else{$respb='';}
if($_POST['sistb']){$sistb=$_POST['dietab'];}else{$sistb='';}
if($_POST['diastb']){$diastb=$_POST['diastb'];}else{$diastb='';}
if($_POST['caidab']){$caidab=$_POST['caidab'];}else{$caidab='';}
if($_POST['dolorb']){$dolorb=$_POST['dolorb'];}else{$dolorb='';}
if($_POST['sondab']){$sondab=$_POST['sondab'];}else{$sondab='';}
if($_POST['edoconb']){$edoconb=$_POST['edoconb'];}else{$edoconb='';}

if($_POST['dietab']){$dietab=$_POST['dietab'];}else{$dietab='';}
if($_POST['glucocab']){$glucocab=$_POST['glucocab'];}else{$glucocab='';}
if($_POST['glucob']){$glucob=$_POST['glucob'];}else{$glucob='';}
if($_POST['insulinab']){$insulinab=$_POST['insulinab'];}else{$insulinab='';}
if($_POST['canalizab']){$canalizab=$_POST['canalizab'];}else{$canalizab='';}
if($_POST['solparenb']){$solparenb=$_POST['solparenb'];}else{$solparenb='';}

//validaciones para 0 ingresos
if($_POST['solparb']){$solparb=$_POST['solparb'];}else{ $solparb=0;}
if($_POST['ingmedb']){$ingmedb=$_POST['ingmedb'];}else{ $ingmedb=0;}
if($_POST['viaoralb']){$viaoralb=$_POST['viaoralb'];}else{ $viaoralb=0;}
if($_POST['otrosb']){$otrosb=$_POST['otrosb'];}else{ $otrosb=0;}
if($_POST['formb']){$formb=$_POST['formb'];}else{ $formb=0;}
$ingtotb=$solparb+$ingmedb+$viaoralb+$otrosb+$formb;

//validaciones para 0 egresos
if($_POST['diuresisb']){$diuresisb=$_POST['diuresisb'];}else{ $diuresisb=0;}
if($_POST['evacuab']){$evacuab=$_POST['evacuab'];}else{ $evacuab=0;}
if($_POST['vomitob']){$vomitob=$_POST['vomitob'];}else{ $vomitob=0;}
if($_POST['canalb']){$canalb=$_POST['canalb'];}else{ $canalb=0;}
if($_POST['perinsenb']){$perinsenb=$_POST['perinsenb'];}else{ $perinsenb=0;}
$egtotb=$diuresisb+$evacuab+$vomitob+$canalb+$perinsenb;

if(isset($_POST['baltotb'])){$baltotb=$ingtotb-$egtotb;}else{$baltotb=0;}
$baltotb=$ingtotb-$egtotb;

$cuideb=$_POST['cuideb'];
$noteb=$_POST['noteb'];



//campos medicamento recien nacido
$medicab=$_POST['medicab'];
$dosisb=$_POST['dosisb'];
$viab=$_POST['viab'];

$medicab2=$_POST['medicab2'];
$dosisb2=$_POST['dosisb2'];
$viab2=$_POST['viab2'];

$medicab3=$_POST['medicab3'];
$dosisb3=$_POST['dosisb3'];
$viab3=$_POST['viab3'];



$edad=$_POST['edad'];
$gen=$_POST['gen'];
$dico=$_POST['dico'];
$deter=$_POST['deter'];
$facam=$_POST['facam'];
$cirose=$_POST['cirose'];
$medicac=$_POST['medicac'];

$tot=$edad+$gen+$dico+$deter+$facam+$cirose+$medicac;
$fecha_actual = date("Y-m-d H:i:s");
//insercion a id recien nacido


if($_POST['apellidos']){$apellidos=$_POST['apellidos'];}else{$apellidos='';}
if($_POST['nombremadre']){$nombremadre=$_POST['nombremadre'];}else{$nombremadre='';}
if($_POST['fecnac']){$fecnac=$_POST['fecnac'];}else{$fecnac='';}
if($_POST['horanac']){$horanac=$_POST['horanac'];}else{$horanac='';}
if($_POST['sexo']){$sexo=$_POST['sexo'];}else{$sexo='';}
if($_POST['peso']){$peso=$_POST['peso'];}else{$peso='';}
if($_POST['talla']){$talla=$_POST['talla'];}else{$talla='';}
if($_POST['pie']){$pie=$_POST['pie'];}else{$pie='';}
if($_POST['apgar']){$apgar=$_POST['apgar'];}else{$apgar='';}
if($_POST['silverman']){$silverman=$_POST['silverman'];}else{$silverman='';}
if($_POST['capurro']){$capurro=$_POST['capurro'];}else{$capurro='';}

$ingresarrecnac = mysqli_query($conexion, 'INSERT INTO iden_recnac 
(id_atencion,
id_usua,
fechab,
horab,
tempb,
pulsob,
respb,
sistb,
diastb,caidab,dolorb,sondab,edoconb,dietab,glucocab,glucob,insulinab,canalizab,solparenb,solparb,ingmedb,viaoralb,otrosb,formb,ingtotb,diuresisb,evacuab,vomitob,canalb,perinsenb,egtotb,baltotb,cuideb,noteb,fechasistb,edad,gen,dico,deter,facam,cirose,medicac,tot,apellidos,nombremadre,fecnac,horanac,sexo,peso,talla,pie,apgar,silverman,capurro) values 
(' . $id_atencion . ' , 
' . $id_usua . ',
"' . $fechab . '",
"' . $horab . '",
"' . $tempb . '",
"' . $pulsob . '",
"' . $respb . '",
"' . $sistb . '",
"' . $diastb .'",
"' . $caidab . '",
"'.$dolorb.'",
"'.$sondab.'",
"'.$edoconb.'",
"'.$dietab.'","'.$glucocab.'","'.$glucob.'","'.$insulinab.'","'.$canalizab.'","'.$solparenb.'","'.$solparb.'","'.$ingmedb.'","'.$viaoralb.'","'.$otrosb.'","'.$formb.'","'.$ingtotb.'","'.$diuresisb.'","'.$evacuab.'","'.$vomitob.'","'.$canalb.'","'.$perinsenb.'","'.$egtotb.'","'.$baltotb.'","'.$cuideb.'","'.$noteb.'","'.$fecha_actual.'","'.$edad.'","'.$gen.'","'.$dico.'","'.$deter.'","'.$facam.'","'.$cirose.'","'.$medicac.'","'.$tot.'","'.$apellidos.'","'.$nombremadre.'","'.$fecnac.'","'.$horanac.'","'.$sexo.'","'.$peso.'","'.$talla.'","'.$pie.'","'.$apgar.'","'.$silverman.'","'.$capurro.'")') or die('<p>Error al registrar iden</p><br>' . mysqli_error($conexion));

//insercion a medicamentos del recien nacido
if($_POST['medicab'] != NULL){
	$usuario = $_SESSION['login'];
$id_usua1= $usuario['id_usua'];

$id_atencion1 = $_SESSION['pac'];
$ingresar2 = mysqli_query($conexion, 'INSERT INTO medica_recnac (id_atencion,id_usua,horanac,medicab,dosisb,viab) values (' . $id_atencion1 . ' ,' . $id_usua1 .',"' . $horab . '","' . $medicab . '","' . $dosisb . '","' . $viab . '")') or die('<p>Error al registrar medica</p><br>' . mysqli_error($conexion));
}



if($_POST['medicab2'] != NULL){
	$usuario = $_SESSION['login'];
$id_usua2= $usuario['id_usua'];
$id_atencion2 = $_SESSION['pac'];

$ingresar3 = mysqli_query($conexion, 'INSERT INTO medica_recnac (id_atencion,id_usua,horanac,medicab,dosisb,viab) values (' . $id_atencion2 . ' ,' . $id_usua2 .',"' . $horab . '","' . $medicab2 . '","' . $dosisb2 . '","' . $viab2 . '")') or die('<p>Error al registrar medica2</p><br>' . mysqli_error($conexion));


}else{

	header('location: ../lista_pacientes/vista_pac_enf.php');
}
	
if($_POST['medicab3'] != NULL){
	$usuario = $_SESSION['login'];
$id_usua3= $usuario['id_usua'];

$id_atencion3=$_SESSION['pac'];

$ingresar4 = mysqli_query($conexion, 'INSERT INTO medica_recnac (id_atencion,id_usua,horanac,medicab,dosisb,viab) values (' . $id_atencion3 . ' ,' . $id_usua3 .',"' . $horab . '","' . $medicab3 . '","' . $dosisb3 . '","' . $viab3 . '")') or die('<p>Error al registrar medica3</p><br>' . mysqli_error($conexion));


}else{

	header('location: ../lista_pacientes/vista_pac_enf.php');
}
	
header('location: ../lista_pacientes/vista_pac_enf.php');

