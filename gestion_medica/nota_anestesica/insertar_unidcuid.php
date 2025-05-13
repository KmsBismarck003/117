<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];


$cirujanoa=$_POST['cirujanoa'];
$anestesiologoa=$_POST['anestesiologoa'];
$canula=$_POST['canula'];
$balanceada=$_POST['balanceada'];
$agentes_in=$_POST['agentes_in'];
$desfluorante=$_POST['desfluorante'];
$insofluorane=$_POST['insofluorane'];
$noit=$_POST['noit'];
$incdentesf=$_POST['incdentesf'];
$reintipo=$_POST['reintipo'];
$noreinc=$_POST['noreinc'];
$vt=$_POST['vt'];
$fr=$_POST['fr'];
$pwa=$_POST['pwa'];
$ventilador=$_POST['ventilador'];
$tuohy=$_POST['tuohy'];
$raquia=$_POST['raquia'];
$segnointen=$_POST['segnointen'];
$analgesia=$_POST['analgesia'];
$altura=$_POST['altura'];
$monitor=$_POST['monitor'];
$tipoi=$_POST['tipoi'];
$fechanac=$_POST['fechanac'];
$horanac=$_POST['horanac'];
$apgar=$_POST['apgar'];
$tiempoa=$_POST['tiempoa'];
$tiempoq=$_POST['tiempoq'];
$posicion=$_POST['posicion'];
$cuentagasa=$_POST['cuentagasa'];
$cuentacom=$_POST['cuentacom'];
$noveno=$_POST['noveno'];
$dxpre=$_POST['dxpre'];
$dcpost=$_POST['dcpost'];
$cirpro=$_POST['cirpro'];
$cirre=$_POST['cirre'];
$altapiso=$_POST['altapiso'];
$med_res=$_POST['med_res'];



//radio
if($_POST['ind']){$ind=$_POST['ind'];}else{$ind="sin induccion";}
if($_POST['mascarilla']){$mascarilla=$_POST['mascarilla'];}else{$mascarilla="";}
if($_POST['anest_general']){$anest_general=$_POST['anest_general'];}else{$anest_general="";}
if($_POST['intubacion']){$intubacion=$_POST['intubacion'];}else{$intubacion="";}
if($_POST['tubglobal']){$tubglobal=$_POST['tubglobal'];}else{$tubglobal="";}
if($_POST['hojar']){$hojar=$_POST['hojar'];}else{$hojar="";}
if($_POST['guiai']){$guiai=$_POST['guiai'];}else{$guiai="";}
if($_POST['cateter']){$cateter=$_POST['cateter'];}else{$cateter="";}
if($_POST['dificil']){$dificil=$_POST['dificil'];}else{$dificil="";}
if($_POST['ecg']){$ecg=$_POST['ecg'];}else{$ecg="";}
if($_POST['tiponac']){$tiponac=$_POST['tiponac'];}else{$tiponac="";}
if($_POST['vivo']){$vivo=$_POST['vivo'];}else{$vivo="";}
if($_POST['genero']){$genero=$_POST['genero'];}else{$genero="";}
if($_POST['asistencia']){$asistencia=$_POST['asistencia'];}else{$asistencia="";}
if($_POST['ventilacionnac']){$ventilacionnac=$_POST['ventilacionnac'];}else{$ventilacionnac="";}
if($_POST['intubaneo']){$intubaneo=$_POST['intubaneo'];}else{$intubaneo="";}
if($_POST['sal']){$sal=$_POST['sal'];}else{$sal="";}
if($_POST['puncion']){$puncion=$_POST['puncion'];}else{$puncion="";}
if($_POST['catcentral']){$catcentral=$_POST['catcentral'];}else{$catcentral="";}


//check
if($_POST['cerrado']){$cerrado=$_POST['cerrado'];}else{$cerrado="";}
if($_POST['semicerrado']){$semicerrado=$_POST['semicerrado'];}else{$semicerrado="";}
if($_POST['ventilacion']){$ventilacion=$_POST['ventilacion'];}else{$ventilacion="";}
if($_POST['manual']){$manual=$_POST['manual'];}else{$manual="";}
if($_POST['mecanica']){$mecanica=$_POST['mecanica'];}else{$mecanica="";}
if($_POST['espontanea']){$espontanea=$_POST['espontanea'];}else{$espontanea="";}
if($_POST['asistida']){$asistida=$_POST['asistida'];}else{$asistida="";}
if($_POST['controlada']){$controlada=$_POST['controlada'];}else{$controlada="";}
if($_POST['bloqueo']){$bloqueo=$_POST['bloqueo'];}else{$bloqueo="";}
if($_POST['sub']){$sub=$_POST['sub'];}else{$sub="";}
if($_POST['aracnoideo']){$aracnoideo=$_POST['aracnoideo'];}else{$aracnoideo="";}
if($_POST['peridual']){$peridual=$_POST['peridual'];}else{$peridual="";}
if($_POST['mixto']){$mixto=$_POST['mixto'];}else{$mixto="";}
if($_POST['cap']){$cap=$_POST['cap'];}else{$cap="";}
if($_POST['ul']){$ul=$_POST['ul'];}else{$ul="";}
if($_POST['capcap']){$capcap=$_POST['capcap'];}else{$capcap="no";}

if($_POST['p_an']){$p_an=$_POST['p_an'];}else{$p_an="";}
if($_POST['p_op']){$p_op=$_POST['p_op'];}else{$p_op="";}
if($_POST['fin_an']){$fin_an=$_POST['fin_an'];}else{$fin_an="";}



$notevo_un=$_POST['notevo_un'];
if($_POST['nt']){$nt=$_POST['nt'];}else{ $nt=0;}
if($_POST['dt']){$dt=$_POST['dt'];}else{ $dt=0;}
if($_POST['tt']){$tt=$_POST['tt'];}else{ $tt=0;}
if($_POST['ct']){$ct=$_POST['ct'];}else{ $ct=0;}
if($_POST['st']){$st=$_POST['st'];}else{ $st=0;}
$t=$nt+$dt+$tt+$ct+$st;
if($_POST['nt2']){$nt2=$_POST['nt2'];}else{ $nt2=0;}
if($_POST['dt2']){$dt2=$_POST['dt2'];}else{ $dt2=0;}
if($_POST['tt2']){$tt2=$_POST['tt2'];}else{ $tt2=0;}
if($_POST['ct2']){$ct2=$_POST['ct2'];}else{ $ct2=0;}
if($_POST['st2']){$st2=$_POST['st2'];}else{ $st2=0;}
$t2=$nt2+$dt2+$tt2+$ct2+$st2;
if($_POST['nt3']){$nt3=$_POST['nt3'];}else{ $nt3=0;}
if($_POST['dt3']){$dt3=$_POST['dt3'];}else{ $dt3=0;}
if($_POST['tt3']){$tt3=$_POST['tt3'];}else{ $tt3=0;}
if($_POST['ct3']){$ct3=$_POST['ct3'];}else{ $ct3=0;}
if($_POST['st3']){$st3=$_POST['st3'];}else{ $st3=0;}
$t3=$nt3+$dt3+$tt3+$ct3+$st3;
if($_POST['nt4']){$nt4=$_POST['nt4'];}else{ $nt4=0;}
if($_POST['dt4']){$dt4=$_POST['dt4'];}else{ $dt4=0;}
if($_POST['tt4']){$tt4=$_POST['tt4'];}else{ $tt4=0;}
if($_POST['ct4']){$ct4=$_POST['ct4'];}else{ $ct4=0;}
if($_POST['st4']){$st4=$_POST['st4'];}else{ $st4=0;}
$t4=$nt4+$dt4+$tt4+$ct4+$st4;
if($_POST['nt5']){$nt5=$_POST['nt5'];}else{ $nt5=0;}
if($_POST['dt5']){$dt5=$_POST['dt5'];}else{ $dt5=0;}
if($_POST['tt5']){$tt5=$_POST['tt5'];}else{ $tt5=0;}
if($_POST['ct5']){$ct5=$_POST['ct5'];}else{ $ct5=0;}
if($_POST['st5']){$st5=$_POST['st5'];}else{ $st5=0;}
$t5=$nt5+$dt5+$tt5+$ct5+$st5;
if($_POST['nt6']){$nt6=$_POST['nt6'];}else{ $nt6=0;}
if($_POST['dt6']){$dt6=$_POST['dt6'];}else{ $dt6=0;}
if($_POST['tt6']){$tt6=$_POST['tt6'];}else{ $tt6=0;}
if($_POST['ct6']){$ct6=$_POST['ct6'];}else{ $ct6=0;}
if($_POST['st6']){$st6=$_POST['st6'];}else{ $st6=0;}
$t6=$nt6+$dt6+$tt6+$ct6+$st6;
if($_POST['nt7']){$nt7=$_POST['nt7'];}else{ $nt7=0;}
if($_POST['dt7']){$dt7=$_POST['dt7'];}else{ $dt7=0;}
if($_POST['tt7']){$tt7=$_POST['tt7'];}else{ $tt7=0;}
if($_POST['ct7']){$ct7=$_POST['ct7'];}else{ $ct7=0;}
if($_POST['st7']){$st7=$_POST['st7'];}else{ $st7=0;}
$t7=$nt7+$dt7+$tt7+$ct7+$st7;


$fecha_actual=date("Y-m-d H:i:s");


$insert=mysqli_query($conexion,'INSERT INTO dat_unid_cuid(id_atencion,id_usua,cirujanoa,anestesiologoa,canula,balanceada,agentes_in,desfluorante,insofluorane,noit,incdentesf,reintipo,noreinc,vt,fr,pwa,ventilador,tuohy,raquia,segnointen,analgesia,altura,monitor,tipoi,fechanac,horanac,apgar,tiempoa,tiempoq,posicion,cuentagasa,cuentacom,noveno,dxpre,dcpost,cirpro,cirre,altapiso,med_res,ind,mascarilla,anest_general,intubacion,tubglobal,hojar,guiai,cateter,dificil,ecg,tiponac,vivo,genero,asistencia,ventilacionnac,intubaneo,sal,puncion,catcentral,cerrado,semicerrado,ventilacion,manual,mecanica,espontanea,asistida,controlada,bloqueo,sub,aracnoideo,peridual,mixto,cap,ul,capcap,notevo_un,01t,02t,03t,04t,05t,0t,51t,52t,53t,54t,55t,5t,101t,102t,103t,104t,105t,10t,151t,152t,153t,154t,155t,15t,201t,202t,203t,204t,205t,20t,251t,252t,253t,254t,255t,25t,301t,302t,303t,304t,305t,30t,fecha_nota,p_an,p_op,fin_an) VALUES('.$id_atencion.','.$id_usua.',"'.$cirujanoa.'","'.$anestesiologoa.'","'.$canula.'","'.$balanceada.'","'.$agentes_in.'","'.$desfluorante.'","'.$insofluorane.'","'.$noit.'","'.$incdentesf.'","'.$reintipo.'","'.$noreinc.'","'.$vt.'","'.$fr.'","'.$pwa.'","'.$ventilador.'","'.$tuohy.'","'.$raquia.'","'.$segnointen.'","'.$analgesia.'","'.$altura.'","'.$monitor.'","'.$tipoi.'","'.$fechanac.'","'.$horanac.'","'.$apgar.'","'.$tiempoa.'","'.$tiempoq.'","'.$posicion.'","'.$cuentagasa.'","'.$cuentacom.'","'.$noveno.'","'.$dxpre.'","'.$dcpost.'","'.$cirpro.'","'.$cirre.'","'.$altapiso.'","'.$med_res.'","'.$ind.'","'.$mascarilla.'","'.$anest_general.'","'.$intubacion.'","'.$tubglobal.'","'.$hojar.'","'.$guiai.'","'.$cateter.'","'.$dificil.'","'.$ecg.'","'.$tiponac.'","'.$vivo.'","'.$genero.'","'.$asistencia.'","'.$ventilacionnac.'","'.$intubaneo.'","'.$sal.'","'.$puncion.'","'.$catcentral.'","'.$cerrado.'","'.$semicerrado.'","'.$ventilacion.'","'.$manual.'","'.$mecanica.'","'.$espontanea.'","'.$asistida.'","'.$controlada.'","'.$bloqueo.'","'.$sub.'","'.$aracnoideo.'","'.$peridual.'","'.$mixto.'","'.$cap.'","'.$ul.'","'.$capcap.'","'.$notevo_un.'","'.$nt.'","'.$dt.'","'.$tt.'","'.$ct.'","'.$st.'","'.$t.'","'.$nt2.'","'.$dt2.'","'.$tt2.'","'.$ct2.'","'.$st2.'","'.$t2.'","'.$nt3.'","'.$dt3.'","'.$tt3.'","'.$ct3.'","'.$st3.'","'.$t3.'","'.$nt4.'","'.$dt4.'","'.$tt4.'","'.$ct4.'","'.$st4.'","'.$t4.'","'.$nt5.'","'.$dt5.'","'.$tt5.'","'.$ct5.'","'.$st5.'","'.$t5.'","'.$nt6.'","'.$dt6.'","'.$tt6.'","'.$ct6.'","'.$st6.'","'.$t6.'","'.$nt7.'","'.$dt7.'","'.$tt7.'","'.$ct7.'","'.$st7.'","'.$t7.'","'.$fecha_actual.'","'.$p_an.'","'.$p_op.'","'.$fin_an.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));

header('location: ../hospitalizacion/vista_pac_hosp.php');
?>	