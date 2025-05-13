<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];

$fechab=$_POST['fechab'];
$horab=$_POST['horab'];

if($_POST['sondab']){$sondab=$_POST['sondab'];}else{$sondab='';}
if($_POST['dietab']){$dietab=$_POST['dietab'];}else{$dietab='';}
if($_POST['glucocab']){$glucocab=$_POST['glucocab'];}else{$glucocab='';}
if($_POST['glucob']){$glucob=$_POST['glucob'];}else{$glucob='';}
if($_POST['insulinab']){$insulinab=$_POST['insulinab'];}else{$insulinab='';}
if($_POST['canalizab']){$canalizab=$_POST['canalizab'];}else{$canalizab='';}
if($_POST['solparenb']){$solparenb=$_POST['solparenb'];}else{$solparenb='';}

if($_POST['edad']){$edad=$_POST['edad'];}else{$edad=0;}
if($_POST['gen']){$gen=$_POST['gen'];}else{$gen=0;}
if($_POST['dico']){$dico=$_POST['dico'];}else{$dico=0;}
if($_POST['deter']){$deter=$_POST['deter'];}else{$deter=0;}
if($_POST['facam']){$facam=$_POST['facam'];}else{$facam=0;}
if($_POST['cirose']){$cirose=$_POST['cirose'];}else{$cirose=0;}
if($_POST['medicac']){$medicac=$_POST['medicac'];}else{$medicac=0;}

$tot=$edad+$gen+$dico+$deter+$facam+$cirose+$medicac;

$fecha_actual = date("Y-m-d H:i:s");

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

$ingresarrecnac = mysqli_query($conexion,'INSERT INTO iden_recnac 
(id_atencion,id_usua,fechab,horab,sondab,edoconb,dietab,glucocab,glucob,insulinab,canalizab,solparenb,fechasistb,edad,gen,dico,deter,facam,cirose,medicac,tot,apellidos,nombremadre,fecnac,horanac,sexo,peso,talla,pie,apgar,silverman,capurro) values 
('.$id_atencion.','.$id_usua.',"'.$fechab.'","'.$horab.'","'.$sondab.'","'.$edoconb.'","'.$dietab.'","'.$glucocab.'","'.$glucob.'","'.$insulinab.'","'.$canalizab.'","'.$solparenb.'","'.$fecha_actual.'",'.$edad.','.$gen.','.$dico.','.$deter.','.$facam.','.$cirose.','.$medicac.','.$tot.',"'.$apellidos.'","'.$nombremadre.'","'.$fecnac.'","'.$horanac.'","'.$sexo.'","'.$peso.'","'.$talla.'","'.$pie.'","'.$apgar.'","'.$silverman.'","'.$capurro.'")') or die('<p>Error al registrar iden</p><br>' . mysqli_error($conexion));

header('location: ../lista_pacientes/vista_pac_enf.php');

