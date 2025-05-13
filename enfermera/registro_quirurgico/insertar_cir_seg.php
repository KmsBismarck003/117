<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];




if(isset($_POST['identidad'])){$identidad=$_POST['identidad'];}else{$identidad='No';}
if(isset($_POST['sitquir'])){$sitquir=$_POST['sitquir'];}else{$sitquir='No';}
if(isset($_POST['procquir'])){$procquir=$_POST['procquir'];}else{$procquir='No';}
if(isset($_POST['suconsen'])){$suconsen=$_POST['suconsen'];}else{$suconsen='No';}
if(isset($_POST['lug_noproc'])){$lug_noproc=$_POST['lug_noproc'];}else{$lug_noproc='No procede';}
if(isset($_POST['circonfase'])){$circonfase=$_POST['circonfase'];}else{$circonfase='No';}
if(isset($_POST['conseg'])){$conseg=$_POST['conseg'];}else{$conseg='No';}
if(isset($_POST['oximetro'])){$oximetro=$_POST['oximetro'];}else{$oximetro='No';}
if(isset($_POST['alerg_con'])){$alerg_con=$_POST['alerg_con'];}else{$alerg_con='No';}
if(isset($_POST['dif_via_aerea'])){$dif_via_aerea=$_POST['dif_via_aerea'];}else{$dif_via_aerea='No';}
if(isset($_POST['reishemo'])){$reishemo=$_POST['reishemo'];}else{$reishemo='No';}
if(isset($_POST['nechemo'])){$nechemo=$_POST['nechemo'];}else{$nechemo='No';}
if(isset($_POST['fcirujano'])){$fcirujano=$_POST['fcirujano'];}else{ $fcirujano='No';}
if(isset($_POST['fayucir'])){$fayucir=$_POST['fayucir'];}else{ $fayucir='No';}
if(isset($_POST['fanest'])){$fanest=$_POST['fanest'];}else{ $fanest='No';}
if(isset($_POST['instrumentista'])){$instrumentista=$_POST['instrumentista'];}else{ $instrumentista='No';}
if(isset($_POST['fotros'])){$fotros=$_POST['fotros'];}else{ $fotros='No';}
if(isset($_POST['paccorr'])){$paccorr=$_POST['paccorr'];}else{ $paccorr='No';}
if(isset($_POST['proccorr'])){$proccorr=$_POST['proccorr'];}else{ $proccorr='No';}
if(isset($_POST['sitquird'])){$sitquird=$_POST['sitquird'];}else{ $sitquird='No';}
if(isset($_POST['encas'])){$encas=$_POST['encas'];}else{ $encas='No';}
if(isset($_POST['casmul'])){$casmul=$_POST['casmul'];}else{ $casmul='No';}
if(isset($_POST['poscpac'])){$poscpac=$_POST['poscpac'];}else{ $poscpac='No';}
if(isset($_POST['anverpro'])){$anverpro=$_POST['anverpro'];}else{ $anverpro='No procede';}
if(isset($_POST['img_diag'])){$img_diag=$_POST['img_diag'];}else{ $img_diag='No procede';}
if(isset($_POST['pasocri'])){$pasocri=$_POST['pasocri'];}else{$pasocri='No';}
if(isset($_POST['durope'])){$durope=$_POST['durope'];}else{$durope='No';}
if(isset($_POST['persangre'])){$persangre=$_POST['persangre'];}else{$persangre='No';}
if(isset($_POST['exriesen'])){$exriesen=$_POST['exriesen'];}else{$exriesen='No';}
if(isset($_POST['fechm'])){$fechm=$_POST['fechm'];}else{$fechm='No';}
if(isset($_POST['exproble'])){$exproble=$_POST['exproble'];}else{ $exproble='No';}
if(isset($_POST['nomprocre'])){$nomprocre=$_POST['nomprocre'];}else{$nomprocre='No';}
if(isset($_POST['recuento'])){$recuento=$_POST['recuento'];}else{$recuento='No';}
if(isset($_POST['etqmu'])){$etqmu=$_POST['etqmu'];}else{$etqmu='No';}
if(isset($_POST['proineq'])){$proineq=$_POST['proineq'];}else{$proineq='No';}
if(isset($_POST['prinrecpost'])){$prinrecpost=$_POST['prinrecpost'];}else{$prinrecpost='No';}
if(isset($_POST['plantrat'])){$plantrat=$_POST['plantrat'];}else{$plantrat='No';}
if(isset($_POST['riesgpaci'])){$riesgpaci=$_POST['riesgpaci'];}else{$riesgpaci='No';}
if(isset($_POST['eventosad'])){$eventosad=$_POST['eventosad'];}else{$eventosad='No';}
if(isset($_POST['reieventad'])){$reieventad=$_POST['reieventad'];}else{$reieventad='No';}

if(isset($_POST['donde'])){$donde=$_POST['donde'];}else{$donde='';}
if(isset($_POST['fir_cir'])){$fir_cir=$_POST['fir_cir'];}else{$fir_cir='';}
if(isset($_POST['fir_anest'])){$fir_anest=$_POST['fir_anest'];}else{$fir_anest='';}
if(isset($_POST['fir_enf'])){$fir_enf=$_POST['fir_enf'];}else{$fir_enf='';}

$fecha_registro = date("Y-m-d H:i");

$result=mysqli_query($conexion,'INSERT INTO dat_cir_seg (id_atencion,id_usua,identidad,sitquir,procquir,suconsen,lug_noproc,circonfase,conseg,oximetro,alerg_con,dif_via_aerea,reishemo,nechemo,fcirujano,fayucir,fanest,instrumentista,fotros,paccorr,proccorr,sitquird,encas,casmul,poscpac,anverpro,img_diag,pasocri,durope,persangre,exriesen,fechm,exproble,nomprocre,recuento,etqmu,proineq,prinrecpost,plantrat,riesgpaci,eventosad,reieventad,donde,fir_cir,fir_anest,fir_enf,fecha_registro) 
	VALUES('.$id_atencion.','.$id_usua.',"'.$identidad.'","'.$sitquir.'","'.$procquir.'","'.$suconsen.'","'.$lug_noproc.'","'.$circonfase.'","'.$conseg.'","'.$oximetro.'","'.$alerg_con.'","'.$dif_via_aerea.'","'.$reishemo.'","'.$nechemo.'","'.$fcirujano.'","'.$fayucir.'","'.$fanest.'","'.$instrumentista.'","'.$fotros.'","'.$paccorr.'","'.$proccorr.'","'.$sitquird.'","'.$encas.'","'.$casmul.'","'.$poscpac.'","'.$anverpro.'","'.$img_diag.'","'.$pasocri.'","'.$durope.'","'.$persangre.'","'.$exriesen.'","'.$fechm.'","'.$exproble.'","'.$nomprocre.'","'.$recuento.'","'.$etqmu.'","'.$proineq.'","'.$prinrecpost.'","'.$plantrat.'","'.$riesgpaci.'","'.$eventosad.'","'.$reieventad.'","'.$donde.'","'.$fir_cir.'","'.$fir_anest.'","'.$fir_enf.'","'.$fecha_registro.'")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


echo mysqli_query($conexion,$result);

?>