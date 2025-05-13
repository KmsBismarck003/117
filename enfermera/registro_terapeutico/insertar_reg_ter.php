<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];

//$turno=$_POST['turno'];
//$fecha_m=$_POST['fecha_m'];
$hora_m=$_POST['hora_m'];
//$peso_m=$_POST['peso_m'];
//$talla_m=$_POST['talla_m'];
$medlegal_m=$_POST['medlegal_m'];
$codigomater_m=$_POST['codigomater_m'];

//$oxigenacion_m=$_POST['oxigenacion_m'];
$hidratacion_m=$_POST['hidratacion_m'];

//llenado capilar
if(isset($_POST['sitn_m'])){$sitn_m=$_POST['sitn_m'];}else{ $sitn_m='';}

//IE Y FIO2
if(isset($_POST['nomn_m'])){$nomn_m=$_POST['nomn_m'];}else{ $nomn_m='';}
if(isset($_POST['datn_m'])){$datn_m=$_POST['datn_m'];}else{ $datn_m='';}



if(isset($_POST['quem_m'])){$quem_m=$_POST['quem_m'];}else{ $quem_m='';}
if(isset($_POST['uls_m'])){$uls_m=$_POST['uls_m'];}else{ $uls_m='';}
if(isset($_POST['nec_m'])){$nec_m=$_POST['nec_m'];}else{ $nec_m='';}
if(isset($_POST['her_m'])){$her_m=$_POST['her_m'];}else{ $her_m='';}
if(isset($_POST['tub_m'])){$tub_m=$_POST['tub_m'];}else{ $tub_m='';}
if(isset($_POST['der_m'])){$der_m=$_POST['der_m'];}else{ $der_m='';}
if(isset($_POST['ras_m'])){$ras_m=$_POST['ras_m'];}else{ $ras_m='';}
if(isset($_POST['eq_m'])){$eq_m=$_POST['eq_m'];}else{ $eq_m='';}
if(isset($_POST['enf_m'])){$enf_m=$_POST['enf_m'];}else{ $enf_m='';}
if(isset($_POST['ema_m'])){$ema_m=$_POST['ema_m'];}else{ $ema_m='';}
if(isset($_POST['frac_m'])){$frac_m=$_POST['frac_m'];}else{ $frac_m='';}
if(isset($_POST['acc_m'])){$acc_m=$_POST['acc_m'];}else{ $acc_m='';}
if(isset($_POST['pete_m'])){$pete_m=$_POST['pete_m'];}else{ $pete_m='';}
if(isset($_POST['ede_m'])){$ede_m=$_POST['ede_m'];}else{ $ede_m='';}
if(isset($_POST['fron_m'])){$fron_m=$_POST['fron_m'];}else{ $fron_m='';}
if(isset($_POST['mal_m'])){$mal_m=$_POST['mal_m'];}else{ $mal_m='';}
if(isset($_POST['man_m'])){$man_m=$_POST['man_m'];}else{ $man_m='';}
if(isset($_POST['del_m'])){$del_m=$_POST['del_m'];}else{ $del_m='';}
if(isset($_POST['pec_m'])){$pec_m=$_POST['pec_m'];}else{ $pec_m='';}
if(isset($_POST['est_m'])){$est_m=$_POST['est_m'];}else{ $est_m='';}
if(isset($_POST['ant_m'])){$ant_m=$_POST['ant_m'];}else{ $ant_m='';}
if(isset($_POST['mu_m'])){$mu_m=$_POST['mu_m'];}else{ $mu_m='';}
if(isset($_POST['mano_m'])){$mano_m=$_POST['mano_m'];}else{ $mano_m='';}
if(isset($_POST['mus_m'])){$mus_m=$_POST['mus_m'];}else{ $mus_m='';}
if(isset($_POST['rod_m'])){$rod_m=$_POST['rod_m'];}else{ $rod_m='';}
if(isset($_POST['pier_m'])){$pier_m=$_POST['pier_m'];}else{ $pier_m='';}
if(isset($_POST['pri_m'])){$pri_m=$_POST['pri_m'];}else{ $pri_m='';}
if(isset($_POST['max_m'])){$max_m=$_POST['max_m'];}else{ $max_m='';}
if(isset($_POST['men_m'])){$men_m=$_POST['men_m'];}else{ $men_m='';}
if(isset($_POST['ac_m'])){$ac_m=$_POST['ac_m'];}else{ $ac_m='';}
if(isset($_POST['bra_m'])){$bra_m=$_POST['bra_m'];}else{ $bra_m='';}
if(isset($_POST['pli_m'])){$pli_m=$_POST['pli_m'];}else{ $pli_m='';}
if(isset($_POST['abd_m'])){$abd_m=$_POST['abd_m'];}else{ $abd_m='';}
if(isset($_POST['reg_m'])){$reg_m=$_POST['reg_m'];}else{ $reg_m='';}
if(isset($_POST['pub_m'])){$pub_m=$_POST['pub_m'];}else{ $pub_m='';}
if(isset($_POST['pde'])){$pde=$_POST['pde'];}else{ $pde='';}
if(isset($_POST['sde_m'])){$sde_m=$_POST['sde_m'];}else{ $sde_m='';}
if(isset($_POST['tde_m'])){$tde_m=$_POST['tde_m'];}else{ $tde_m='';}
if(isset($_POST['cde_m'])){$cde_m=$_POST['cde_m'];}else{ $cde_m='';}
if(isset($_POST['qde_m'])){$qde_m=$_POST['qde_m'];}else{ $qde_m='';}
if(isset($_POST['tob_m'])){$tob_m=$_POST['tob_m'];}else{ $tob_m='';}
if(isset($_POST['pie_m'])){$pie_m=$_POST['pie_m'];}else{ $pie_m='';}
if(isset($_POST['par_m'])){$par_m=$_POST['par_m'];}else{ $par_m='';}
if(isset($_POST['occ_m'])){$occ_m=$_POST['occ_m'];}else{ $occ_m='';}
if(isset($_POST['nuca_m'])){$nuca_m=$_POST['nuca_m'];}else{ $nuca_m='';}
if(isset($_POST['braz_m'])){$braz_m=$_POST['braz_m'];}else{ $braz_m='';}
if(isset($_POST['codo_m'])){$codo_m=$_POST['codo_m'];}else{ $codo_m='';}
if(isset($_POST['ante_m'])){$ante_m=$_POST['ante_m'];}else{ $ante_m='';}
if(isset($_POST['mune_m'])){$mune_m=$_POST['mune_m'];}else{ $mune_m='';}
if(isset($_POST['mano2_m'])){$mano2_m=$_POST['mano2_m'];}else{ $mano2_m='';}
if(isset($_POST['plieg_m'])){$plieg_m=$_POST['plieg_m'];}else{ $plieg_m='';}
if(isset($_POST['piern_m'])){$piern_m=$_POST['piern_m'];}else{ $piern_m='';}
if(isset($_POST['piep_m'])){$piep_m=$_POST['piep_m'];}else{ $piep_m='';}
if(isset($_POST['cuello_m'])){$cuello_m=$_POST['cuello_m'];}else{ $cuello_m='';}
if(isset($_POST['regin_m'])){$regin_m=$_POST['regin_m'];}else{ $regin_m='';}
if(isset($_POST['regesc_m'])){$regesc_m=$_POST['regesc_m'];}else{ $regesc_m='';}
if(isset($_POST['reginf_m'])){$reginf_m=$_POST['reginf_m'];}else{ $reginf_m='';}
if(isset($_POST['lum_m'])){$lum_m=$_POST['lum_m'];}else{ $lum_m='';}
if(isset($_POST['glut_m'])){$glut_m=$_POST['glut_m'];}else{ $glut_m='';}
if(isset($_POST['musl_m'])){$musl_m=$_POST['musl_m'];}else{ $musl_m='';}
if(isset($_POST['talon_m'])){$talon_m=$_POST['talon_m'];}else{ $talon_m='';}
//$f_card_m=$_POST['f_card_m'];
//$temp_m=$_POST['temp_m'];
//$f_resp_m=$_POST['f_resp_m'];
//$sat_oxigeno_m=$_POST['sat_oxigeno_m'];
$glas_m=$_POST['glas_m'];
$glic_m=$_POST['glic_m'];
$pres_m=$_POST['pres_m'];
$presper_m=$_POST['presper_m'];
$presint_m=$_POST['presint_m'];
$per_m=$_POST['per_m'];
$preper_m=$_POST['preper_m'];
$tamd_m=$_POST['tamd_m'];
$tami_m=$_POST['tami_m'];
$simd_m=$_POST['simd_m'];
$simi_m=$_POST['simi_m'];
$agit_m=$_POST['agit_m'];
$pdiast_m=0;
$psist_m=0;
$pdiast_m=$_POST['pdiast_m'];
$psist_m=$_POST['psist_m'];
$tam_m=0;
$tam_m=($pdiast_m+$psist_m)/2;

$pvc_m=$_POST['pvc_m'];
//$peri_m=$_POST['peri_m'];

$vent_m=$_POST['vent_m'];
$vol_m=$_POST['vol_m'];
$frec_m=$_POST['frec_m'];
$fio_m=$_POST['fio_m'];
$peep_m=$_POST['peep_m'];
$presins_m=$_POST['presins_m'];
$prespico_m=$_POST['prespico_m'];
$diet_m=$_POST['diet_m'];

if(isset($_POST['oral_m'])){$oral_m=$_POST['oral_m'];}else{ $oral_m=0;}
if(isset($_POST['ent_m'])){$ent_m=$_POST['ent_m'];}else{ $ent_m=0;}
if(isset($_POST['hemo_m'])){$hemo_m=$_POST['hemo_m'];}else{ $hemo_m=0;}
if(isset($_POST['parent_m'])){$parent_m=$_POST['parent_m'];}else{ $parent_m=0;}
if(isset($_POST['med_m'])){$med_m=$_POST['med_m'];}else{ $med_m=0;}
if(isset($_POST['esp_m'])){$esp_m=$_POST['esp_m'];}else{ $esp_m=0;}
$ing_m=0;
$ing_m=$oral_m+$ent_m+$hemo_m+$parent_m+$med_m+$esp_m;


if(isset($_POST['diu_m'])){$diu_m=$_POST['diu_m'];}else{ $diu_m=0;}
if(isset($_POST['eva_m'])){$eva_m=$_POST['eva_m'];}else{ $eva_m=0;}
if(isset($_POST['sang_m'])){$sang_m=$_POST['sang_m'];}else{ $sang_m=0;}
if(isset($_POST['vom_m'])){$vom_m=$_POST['vom_m'];}else{ $vom_m=0;}
if(isset($_POST['aspboc_m'])){$aspboc_m=$_POST['aspboc_m'];}else{ $aspboc_m=0;}
if(isset($_POST['gast_m'])){$gast_m=$_POST['gast_m'];}else{ $gast_m=0;}
if(isset($_POST['dren_m'])){$dren_m=$_POST['dren_m'];}else{ $dren_m=0;}
if(isset($_POST['perd_m'])){$perd_m=$_POST['perd_m'];}else{ $perd_m=0;}

$egpar_m=$diu_m+$eva_m+$sang_m+$vom_m+$aspboc_m+$gast_m+$dren_m+$perd_m;

$balt_m=$ing_m-$egpar_m;
$estfis_m=$_POST['estfis_m'];
$estmen_m=$_POST['estmen_m'];
$act_m=$_POST['act_m'];
$mov_m=$_POST['mov_m'];
$inc_m=$_POST['inc_m'];
$tot_m=$estfis_m+$estmen_m+$act_m+$mov_m+$inc_m;


//$clasriesg_m=$_POST['clasriesg_m'];
$nomenf_m=$_POST['nomenf_m'];

if(isset($_POST['caidas_m'])){$caidas_m=$_POST['caidas_m'];}else{ $caidas_m=0;}
if(isset($_POST['medi_m'])){$medi_m=$_POST['medi_m'];}else{ $medi_m=0;}
if(isset($_POST['defic_m'])){$defic_m=$_POST['defic_m'];}else{ $defic_m=0;}
if(isset($_POST['estement_m'])){$estement_m=$_POST['estement_m'];}else{ $estement_m=0;}
if(isset($_POST['deamb_m'])){$deamb_m=$_POST['deamb_m'];}else{ $deamb_m=0;}
$total_m=$caidas_m+$medi_m+$defic_m+$estement_m+$deamb_m;





//$classresg_m=$_POST['classresg_m'];
$nom_enf_m=$_POST['nom_enf_m'];
$interv_m=$_POST['interv_m'];
$cuidenf=$_POST['cuidenf'];

$sara=$_POST['sara'];
$ure_h=$_POST['ure_h'];

$mnb=$_POST['mnb'];

//marcaje
$mara=$_POST['mara'];
$marb=$_POST['marb']; 
$marc=$_POST['marc'];   
$mard=$_POST['mard']; 
$mare=$_POST['mare'];  
$marf=$_POST['marf']; 
$marg=$_POST['marg']; 
$marh=$_POST['marh']; 

$pie=$_POST['pie'];
$pied=$_POST['pied']; 
$tod=$_POST['tod'];   
$toi=$_POST['toi']; 
$rodi=$_POST['rodi'];  
$rodd=$_POST['rodd']; 
$musloi=$_POST['musloi']; 
$muslod=$_POST['muslod']; 
$inglei=$_POST['inglei'];
$iabdomen=$_POST['iabdomen']; 
$ddi=$_POST['ddi'];   
$ddidos=$_POST['ddidos']; 
$dditres=$_POST['dditres'];  
$ddicuatro=$_POST['ddicuatro']; 
$ddicinco=$_POST['ddicinco']; 
$ddoderu=$_POST['ddoderu']; 
$palmai=$_POST['palmai'];
$muñei=$_POST['munei']; 
$brazi=$_POST['brazi'];   
$brazci=$_POST['brazci']; 
$homi=$_POST['homi'];  
$peci=$_POST['peci']; 
$pecti=$_POST['pecti']; 
$pectd=$_POST['pectd']; 
$cvi=$_POST['cvi'];
$dedodos=$_POST['dedodos']; 
$dedotres=$_POST['dedotres'];   
$dedocuatro=$_POST['dedocuatro']; 
$dedocincoo=$_POST['dedocincoo'];  
$palmad=$_POST['palmad']; 
$muñecad=$_POST['munecad']; 
$derbraz=$_POST['derbraz']; 
$annbraz=$_POST['annbraz']; 
$cconder=$_POST['cconder'];   
$hombrod=$_POST['hombrod']; 
$mandiderr=$_POST['mandiderr'];  
$mandicentroo=$_POST['mandicentroo'];
$mandiizqui=$_POST['mandiizqui']; 
$mejderecha=$_POST['mejderecha'];
$narizc=$_POST['narizc']; 
$frenteizquierda=$_POST['frenteizquierda'];   
$frentederecha=$_POST['frentederecha']; 

//espalda
$plantapiea=$_POST['plantapiea'];  
$plantapieader=$_POST['plantapieader'];
$tobilloati=$_POST['tobilloati']; 
$tobilloatd=$_POST['tobilloatd'];
$ptiatras=$_POST['ptiatras'];  
$ptdatras=$_POST['ptdatras'];
$pierespaldai=$_POST['pierespaldai']; 
$pierespaldad=$_POST['pierespaldad'];
$musloatrasiz=$_POST['musloatrasiz'];  
$musloatrasder=$_POST['musloatrasder'];
$glutiz=$_POST['glutiz']; 
$glutder=$_POST['glutder'];
$cinturaiz=$_POST['cinturaiz'];  
$cinturader=$_POST['cinturader'];
$costilliz=$_POST['costilliz']; 
$costillder=$_POST['costillder'];
$espaldarribaiz=$_POST['espaldarribaiz'];  
$espaldaarribader=$_POST['espaldaarribader'];
$espaldaalta=$_POST['espaldaalta']; 
$dorsaliz=$_POST['dorsaliz'];
$dorsalder=$_POST['dorsalder'];  
$munecaatrasiz=$_POST['munecaatrasiz'];
$munecaatrasder=$_POST['munecaatrasder']; 
$antebiesp=$_POST['antebiesp'];
$antebdesp=$_POST['antebdesp'];
$casicodoi=$_POST['casicodoi'];
$casicododer=$_POST['casicododer'];
$brazalti=$_POST['brazalti'];
$brazaltder=$_POST['brazaltder'];
$cuellatrasb=$_POST['cuellatrasb'];
$cuellatrasmedio=$_POST['cuellatrasmedio'];
$cabedorsalm=$_POST['cabedorsalm'];
$cabealtaizqu=$_POST['cabealtaizqu'];
$cabezaaltader=$_POST['cabezaaltader'];

$espizq=$_POST['espizq'];
$espder=$_POST['espder'];
$coxis=$_POST['coxis'];


$nuevo=$_POST['nuevo'];
$nuevo1=$_POST['nuevo1'];
$nuevo2=$_POST['nuevo2'];
$nuevo3=$_POST['nuevo3'];
$nuevo4=$_POST['nuevo4'];
$nuevo5=$_POST['nuevo5'];
$nuevo6=$_POST['nuevo6'];
$nuevo7=$_POST['nuevo7'];

if($hora_m=='8' ||$hora_m=='9' || $hora_m=='10' || $hora_m=='11'|| $hora_m=='12'|| $hora_m=='13' || $hora_m=='14'){
$turno="MATUTINO";
} else if ($hora_m=='15' || $hora_m=='16' || $hora_m=='17'|| $hora_m=='18'|| $hora_m=='19' || $hora_m=='20' || $hora_m=='21') {
  $turno="VESPERTINO";
}else if ($hora_m=='22' || $hora_m=='23' || $hora_m=='24'|| $hora_m=='1'|| $hora_m=='2' || $hora_m=='3' || $hora_m=='4' || $hora_m=='5' || $hora_m=='6' || $hora_m=='7') {
    $turno="NOCTURNO";
}


$fecha_actual = date("Y-m-d H:i:s");
$fecha_registro = date("Y-m-d H:i:s");
 //$ingresarsignos = mysqli_query($conexion, 'INSERT INTO signos_vitales (id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,tam,tipo) values (' . $id_atencion . ' , ' . $id_usua . ',"'.$fecha_actual.'","' . $psist_m . '","' . $pdiast_m . '","' . $f_card_m . '","' . $f_resp_m . '","' . $temp_m . '","' . $sat_oxigeno_m . '","'.$tam_m.'","TERAPIA INTENSIVA")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

$fecha_actuald = date("Y-m-d");
	$ingresar = mysqli_query($conexion, 'INSERT INTO enf_ter (id_atencion,turno,fecha_m,hora_m,medlegal_m,codigomater_m,hidratacion_m,sitn_m,nomn_m,datn_m,quem_m,uls_m,nec_m,her_m,tub_m,der_m,ras_m,eq_m,enf_m,ema_m,frac_m,acc_m,pete_m,ede_m,fron_m,mal_m,man_m,del_m,pec_m,est_m,ant_m,mu_m,mano_m,mus_m,rod_m,pier_m,pri_m,max_m,men_m,ac_m,bra_m,pli_m,abd_m,reg_m,pub_m,pde_m,sde_m,tde_m,cde_m,qde_m,tob_m,pie_m,par_m,occ_m,nuca_m,braz_m,codo_m,ante_m,mune_m,mane_m,plieg_m,piern_m,piep_m,cuello_m,regin_m,regesc_m,reginf_m,lum_m,glut_m,musl_m,talon_m,glas_m,glic_m,pres_m,presper_m,presint_m,per_m,preper_m,tamd_m,tami_m,simd_m,simi_m,agit_m,pvc_m,vent_m,vol_m,frec_m,fio_m,peep_m,presins_m,prespico_m,diet_m,oral_m,ent_m,hemo_m,parent_m,med_m,esp_m,ing_m,diu_m,eva_m,sang_m,vom_m,aspboc_m,gast_m,dren_m,perd_m,egpar_m,balt_m,estfis_m,estmen_m,act_m,mov_m,inc_m,tot_m,nomenf_m,caidas_m,medi_m,defic_m,estement_m,deamb_m,total_m,nom_enf_m,interv_m,id_usua,cuidenf,fecha_act,sara,ure_h,mnb,mara,marb,marc,mard,mare,marf,marg,marh,pie,pied,tod,toi,rodi,rodd,musloi,muslod,inglei,iabdomen,ddi,ddidos,dditres,ddicuatro,ddicinco,ddoderu,palmai,muñei,brazi,brazci,homi,peci,pecti,pectd,cvi,dedodos,dedotres,dedocuatro,dedocincoo,palmad,muñecad,derbraz,annbraz,cconder,hombrod,mandiderr,mandicentroo,mandiizqui,mejderecha,narizc,frenteizquierda,frentederecha,plantapiea,plantapieader,tobilloati,tobilloatd,ptiatras,ptdatras,pierespaldai,pierespaldad,musloatrasiz,musloatrasder,glutiz,glutder,cinturaiz,cinturader,costilliz,costillder,espaldarribaiz,espaldaarribader,espaldaalta,dorsaliz,dorsalder,munecaatrasiz,munecaatrasder,antebiesp,antebdesp,casicodoi,casicododer,brazalti,brazaltder,cuellatrasb,cuellatrasmedio,cabedorsalm,cabealtaizqu,cabezaaltader,espizq,espder,coxis,nuevo,nuevo1,nuevo2,nuevo3,nuevo4,nuevo5,nuevo6,nuevo7) values (' . $id_atencion . ' , "' . $turno . '", " ' . $fecha_actuald . '" , "' . $hora_m . '","'.$medlegal_m.'","'.$codigomater_m.'","'.$hidratacion_m.'","'.$sitn_m.'","'.$nomn_m.'","'.$datn_m.'","'.$quem_m.'","'.$uls_m.'","'.$nec_m.'","'.$her_m.'","'.$tub_m.'","'.$der_m.'","'.$ras_m.'","'.$eq_m.'","'.$enf_m.'","'.$ema_m.'","'.$frac_m.'","'.$acc_m.'","'.$pete_m.'","'.$ede_m.'","'.$fron_m.'","'.$mal_m.'","'.$man_m.'","'.$del_m.'","'.$pec_m.'","'.$est_m.'","'.$ant_m.'","'.$mu_m.'","'.$mano_m.'","'.$mus_m.'","'.$rod_m.'","'.$pier_m.'","'.$pri_m.'","'.$max_m.'","'.$men_m.'","'.$ac_m.'","'.$bra_m.'","'.$pli_m.'","'.$abd_m.'","'.$reg_m.'","'.$pub_m.'","'.$pde.'","'.$sde_m.'","'.$tde_m.'","'.$cde_m.'","'.$qde_m.'","'.$tob_m.'","'.$pie_m.'","'.$par_m.'","'.$occ_m.'","'.$nuca_m.'","'.$braz_m.'","'.$codo_m.'","'.$ante_m.'","'.$mune_m.'","'.$mano2_m.'","'.$plieg_m.'","'.$piern_m.'","'.$piep_m.'","'.$cuello_m.'","'.$regin_m.'","'.$regesc_m.'","'.$reginf_m.'","'.$lum_m.'","'.$glut_m.'","'.$musl_m.'","'.$talon_m.'","'.$glas_m.'","'.$glic_m.'","'.$pres_m.'","'.$presper_m.'","'.$presint_m.'","'.$per_m.'","'.$preper_m.'","'.$tamd_m.'","'.$tami_m.'","'.$simd_m.'","'.$simi_m.'","'.$agit_m.'","'.$pvc_m.'","'.$vent_m.'","'.$vol_m.'","'.$frec_m.'","'.$fio_m.'","'.$peep_m.'","'.$presins_m.'","'.$prespico_m.'","'.$diet_m.'","'.$oral_m.'","'.$ent_m.'","'.$hemo_m.'","'.$parent_m.'","'.$med_m.'","'.$esp_m.'","'.$ing_m.'","'.$diu_m.'","'.$eva_m.'","'.$sang_m.'","'.$vom_m.'","'.$aspboc_m.'","'.$gast_m.'","'.$dren_m.'","'.$perd_m.'","'.$egpar_m.'","'.$balt_m.'","'.$estfis_m.'","'.$estmen_m.'","'.$act_m.'","'.$mov_m.'","'.$inc_m.'","'.$tot_m.'","'.$nomenf_m.'","'.$caidas_m.'","'.$medi_m.'","'.$defic_m.'","'.$estement_m.'","'.$deamb_m.'","'.$total_m.'","'.$nom_enf_m.'","'.$interv_m.'",'.$id_usua.',"'.$cuidenf.'","'.$fecha_registro.'","'.$sara.'","'.$ure_h.'","'.$mnb.'","' . $mara .'","' . $marb .'","' . $marc .'","' . $mard .'","' . $mare .'","' . $marf .'","' . $marg .'","' . $marh .'","' . $pie .'","' . $pied .'","' . $tod .'","' . $toi .'","' . $rodi .'","' . $rodd .'","' . $musloi .'","' . $muslod .'","' . $inglei .'","' . $iabdomen .'","' . $ddi .'","' . $ddidos .'","' . $dditres .'","' . $ddicuatro .'","' . $ddicinco .'","' . $ddoderu .'","' . $palmai .'","' . $muñei .'","' . $brazi .'","' . $brazci .'","' . $homi .'","' . $peci .'","' . $pecti .'","' . $pectd .'","' . $cvi .'","' . $dedodos .'","' . $dedotres .'","' . $dedocuatro .'","' . $dedocincoo .'","' . $palmad .'","' . $muñecad .'","' . $derbraz .'","' . $annbraz .'","' . $cconder .'","' . $hombrod .'","' . $mandiderr .'","' . $mandicentroo .'","' . $mandiizqui .'","' . $mejderecha .'","' . $narizc .'","' . $frenteizquierda .'","' . $frentederecha .'","' . $plantapiea .'","' . $plantapieader .'","' . $tobilloati .'","' . $tobilloatd .'","' . $ptiatras .'","' . $ptdatras .'","' . $pierespaldai .'","' . $pierespaldad .'","' . $musloatrasiz .'","' . $musloatrasder .'","' . $glutiz .'","' . $glutder .'","' . $cinturaiz .'","' . $cinturader .'","' . $costilliz .'","' . $costillder .'","' . $espaldarribaiz .'","' . $espaldaarribader .'","' . $espaldaalta .'","' . $dorsaliz .'","' . $dorsalder .'","' . $munecaatrasiz .'","' . $munecaatrasder .'","' . $antebiesp .'","' . $antebdesp .'","' . $casicodoi .'","' . $casicododer .'","' . $brazalti .'","' . $brazaltder .'","' . $cuellatrasb .'","' . $cuellatrasmedio .'","' . $cabedorsalm .'","' . $cabealtaizqu .'","' . $cabezaaltader .'","' . $espizq .'","' . $espder .'","' . $coxis .'","' . $nuevo .'","' . $nuevo1 .'","' . $nuevo2 .'","' . $nuevo3 .'","' . $nuevo4 .'","' . $nuevo5 .'","' . $nuevo6.'","' . $nuevo7.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


header('location: ../lista_pacientes/vista_pac_enf.php');