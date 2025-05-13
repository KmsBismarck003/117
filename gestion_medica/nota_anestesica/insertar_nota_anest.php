<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$result = $conexion->query("select * from dat_not_preop WHERE id_atencion=" .$_SESSION['hospital']." order by id_not_preop DESC LIMIT 1") or die($conexion->error); ?>   <?php
     while ($f2 = mysqli_fetch_array($result)) { 

$diagpre=$f2['diag_preop'];
$urg=$f2['tipo_cirugia_preop'];

}

$resul = $conexion->query("select * from dat_not_preop WHERE id_atencion=" .$_SESSION['hospital']." order by id_not_preop DESC LIMIT 1") or die($conexion->error);
                    while ($f = mysqli_fetch_array($resul)) {
$inter=$f['tipo_inter_plan'];
$med_proc=$f['nom_medi_cir'];
}
$area=$_POST['area'];
$proc_prog=$_POST['proc_prog'];
$anest=$_POST['anest'];
$inmun=$_POST['inmun'];
$tab=$_POST['tab'];
$alc=$_POST['alc'];
$trans=$_POST['trans'];
$alerg=$_POST['alerg'];
$toxi=$_POST['toxi'];
$gastro=$_POST['gastro'];
$neuro=$_POST['neuro'];
$neumo=$_POST['neumo'];
$ren=$_POST['ren'];
$card=$_POST['card'];
$tend=$_POST['end'];
$reu=$_POST['reu'];
$neo=$_POST['neo'];
$herma=$_POST['herma'];
$trau=$_POST['trau'];
$psi=$_POST['psi'];
$quir=$_POST['quir'];
$aneste=$_POST['aneste'];
$gin=$_POST['gin'];
$ped=$_POST['ped'];
$valant=$_POST['valant'];
$cons=$_POST['cons'];
$pad_act=$_POST['pad_act'];
$med_act=$_POST['med_act'];
$ayuno=$_POST['ayuno'];
$otro=$_POST['otro'];

if (isset($_POST['esp'])) {$esp=$_POST['esp'];}else{$esp='NO';}

$ta_sisto=$_POST['ta_sisto'];
$ta_diasto=$_POST['ta_diasto'];
$fc=$_POST['fc'];
$fr=$_POST['fr'];
$tempe=$_POST['tempe'];
$pes=$_POST['pes'];
$tall=$_POST['tall'];
$imc=$_POST['imc'];
$malla=$_POST['malla'];
$patil=$_POST['patil'];
$bell=$_POST['bell'];
$dist=$_POST['dist'];
$buco=$_POST['buco'];
$obserb=$_POST['obserb'];

/*$cabcue=$_POST['cabcue'];
$cardio=$_POST['cardio'];
$abdom=$_POST['abdom'];
$col=$_POST['col'];
$ext=$_POST['ext'];*/


$fecha=$_POST['fecha'];
$hb=$_POST['hb'];
$hto=$_POST['hto'];
$gb=$_POST['gb'];
$gr=$_POST['gr'];
$plaq=$_POST['plaq'];
$tp=$_POST['tp'];
$tpt=$_POST['tpt'];
$inr=$_POST['inr'];
$gluc=$_POST['gluc'];
$cr=$_POST['cr'];
$bun=$_POST['bun'];
$urea=$_POST['urea'];
$es=$_POST['es'];

if (isset($_POST['otros'])) {$otros=$_POST['otros'];}else{ $otros='no';}


$gab=$_POST['gab'];
$valcard=$_POST['valcard'];
$condfis=$_POST['condfis'];
$tipanest=$_POST['tipanest'];
$indpre=$_POST['indpre'];
$obs=$_POST['obs'];

$nomanest=$_POST['nomanest'];


$fecha_actual = date("Y-m-d H:i:s");

$hepatico=$_POST['hepatico'];
$aerea=$_POST['aerea'];
$tromboe=$_POST['tromboe'];
$quirur=$_POST['quirur'];
$nauv=$_POST['nauv'];
$otr=$_POST['otr'];

$ingresos=$_POST['ingresos'];
$ingresosc=$_POST['ingresosc'];
$egresos=$_POST['egresos'];
$egresosc=$_POST['egresosc'];


$ingresar = mysqli_query($conexion,'INSERT INTO dat_peri_anest (id_atencion,id_usua,diagpre,area,urg,inter,proc_prog,med_proc,anest,inmun,tab,alc,trans,alerg,toxi,gastro,neuro,neumo,ren,card,tend,reu,neo,herma,trau,psi,quir,aneste,gin,ped,valant,cons,pad_act,med_act,ayuno,otro,esp,ta_sisto,ta_diasto,fc,fr,tempe,pes,tall,imc,malla,patil,bell,dist,buco,obserb,fecha,hb,hto,gb,gr,plaq,tp,tpt,inr,gluc,cr,bun,urea,es,otros,gab,valcard,condfis,tipanest,indpre,obs,nomanest,fecha_nota,hepatico,aerea,tromboe,quirur,nauv,otr,ingresos,ingresosc,egresos,egresosc) values('.$id_atencion.','.$id_usua.',"'.$diagpre.'","'.$area.'","'.$urg.'","'.$inter.'","'.$proc_prog.'","'.$med_proc.'","'.$anest.'","'.$inmun.'","'.$tab.'","'.$alc.'","'.$trans.'","'.$alerg.'","'.$toxi.'","'.$gastro.'","'.$neuro.'","'.$neumo.'","'.$ren.'","'.$card.'","'.$tend.'","'.$reu.'","'.$neo.'","'.$herma.'","'.$trau.'","'.$psi.'","'.$quir.'","'.$aneste.'","'.$gin.'","'.$ped.'","'.$valant.'","'.$cons.'","'.$pad_act.'","'.$med_act.'","'.$ayuno.'","'.$otro.'","'.$esp.'","'.$ta_sisto.'","'.$ta_diasto.'","'.$fc.'","'.$fr.'","'.$tempe.'","'.$pes.'","'.$tall.'","'.$imc.'","'.$malla.'","'.$patil.'","'.$bell.'","'.$dist.'","'.$buco.'","'.$obserb.'","'.$fecha.'","'.$hb.'","'.$hto.'","'.$gb.'","'.$gr.'","'.$plaq.'","'.$tp.'","'.$tpt.'","'.$inr.'","'.$gluc.'","'.$cr.'","'.$bun.'","'.$urea.'","'.$es.'","'.$otros.'","'.$gab.'","'.$valcard.'","'.$condfis.'","'.$tipanest.'","'.$indpre.'","'.$obs.'","'.$nomanest.'","'.$fecha_actual.'","'.$hepatico.'","'.$aerea.'","'.$tromboe.'","'.$quirur.'","'.$nauv.'","'.$otr.'","'.$ingresos.'","'.$ingresosc.'","'.$egresos.'","'.$egresosc.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));



header('location: ../hospitalizacion/vista_pac_hosp.php');
?>