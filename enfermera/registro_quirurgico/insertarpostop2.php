<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];

$fecha = date("Y-m-d");
if(isset($_POST['fecha_reporte'])){$fecha_reporte=$_POST['fecha_reporte'];}else{ $fecha_reporte='';}

if(isset($_POST['ter_anes'])){$ter_anes=$_POST['ter_anes'];}else{ $ter_anes='';}
if(isset($_POST['ter_cir'])){$ter_cir=$_POST['ter_cir'];}else{ $ter_cir='';}
if(isset($_POST['tip_cir'])){$tip_cir=$_POST['tip_cir'];}else{ $tip_cir='';}


if(isset($_POST['p_medico'])){$p_medico=$_POST['p_medico'];}else{ $p_medico='';}
if(isset($_POST['dispo_p'])){$dispo_p=$_POST['dispo_p'];}else{ $dispo_p='';}
if(isset($_POST['diagyodc'])){$diagyodc=$_POST['diagyodc'];}else{ $diagyodc='';}
if(isset($_POST['p_anato'])){$p_anato=$_POST['p_anato'];}else{ $p_anato='';}
if(isset($_POST['tipo_de_i'])){$tipo_de_i=$_POST['tipo_de_i'];}else{ $tipo_de_i='';}
if(isset($_POST['sitio_ob'])){$sitio_ob=$_POST['sitio_ob'];}else{ $sitio_ob='';}
if(isset($_POST['estudios_obser'])){$estudios_obser=$_POST['estudios_obser'];}else{ $estudios_obser='';}

if(isset($_POST['p_a'])){$p_a=$_POST['p_a'];}else{ $p_a='';}
if(isset($_POST['s_a'])){$s_a=$_POST['s_a'];}else{ $s_a='';}
if(isset($_POST['t_a'])){$t_a=$_POST['t_a'];}else{ $t_a='';}

if(isset($_POST['oxi'])){$oxi=$_POST['oxi'];}else{ $oxi='NO';}
if(isset($_POST['con'])){$con=$_POST['con'];}else{ $con='NO';}
if(isset($_POST['muc'])){$muc=$_POST['muc'];}else{ $muc='NO';}
if(isset($_POST['vent'])){$vent=$_POST['vent'];}else{ $vent='NO';}
if(isset($_POST['est'])){$est=$_POST['est'];}else{ $est='NO';}

if(isset($_POST['cirujano'])){$cirujano=$_POST['cirujano'];}else{$cirujano='';}
if(isset($_POST['anestesiologo'])){$anestesiologo=$_POST['anestesiologo'];}else{$anestesiologo='';}
if(isset($_POST['instrumentista'])){$instrumentista=$_POST['instrumentista'];}else{$instrumentista='';}
if(isset($_POST['circulante'])){$circulante=$_POST['circulante'];}else{$circulante='';}


//marcaje
if(isset($_POST['mara'])){$mara=$_POST['mara'];}else{ $mara='';}
if(isset($_POST['marb'])){$marb=$_POST['marb'];}else{ $marb='';}
if(isset($_POST['marc'])){$marc=$_POST['marc'];}else{ $marc='';}
if(isset($_POST['mard'])){$mard=$_POST['mard'];}else{ $mard='';}
if(isset($_POST['mare'])){$mare=$_POST['mare'];}else{ $mare='';}
if(isset($_POST['marf'])){$marf=$_POST['marf'];}else{ $marf='';}
if(isset($_POST['marg'])){$marg=$_POST['marg'];}else{ $marg='';}
if(isset($_POST['marh'])){$marh=$_POST['marh'];}else{ $marh='';}
if(isset($_POST['pie'])){$pie=$_POST['pie'];}else{ $pie='';}
if(isset($_POST['pied'])){$pied=$_POST['pied'];}else{ $pied='';}
if(isset($_POST['tod'])){$tod=$_POST['tod'];}else{ $tod='';}
if(isset($_POST['toi'])){$toi=$_POST['toi'];}else{ $toi='';}
if(isset($_POST['rodi'])){$rodi=$_POST['rodi'];}else{ $rodi='';}
if(isset($_POST['rodd'])){$rodd=$_POST['rodd'];}else{ $rodd='';}
if(isset($_POST['musloi'])){$musloi=$_POST['musloi'];}else{ $musloi='';}
if(isset($_POST['muslod'])){$muslod=$_POST['muslod'];}else{ $muslod='';}
if(isset($_POST['inglei'])){$inglei=$_POST['inglei'];}else{ $inglei='';}
if(isset($_POST['iabdomen'])){$iabdomen=$_POST['iabdomen'];}else{ $iabdomen='';}
if(isset($_POST['ddi'])){$ddi=$_POST['ddi'];}else{ $ddi='';}

if(isset($_POST['ddidos'])){$ddidos=$_POST['ddidos'];}else{ $ddidos='';} 
if(isset($_POST['dditres'])){$dditres=$_POST['dditres'];}else{ $dditres='';} 
if(isset($_POST['ddicuatro'])){$ddicuatro=$_POST['ddicuatro'];}else{ $ddicuatro='';} 
if(isset($_POST['ddicinco'])){$ddicinco=$_POST['ddicinco'];}else{ $ddicinco='';} 
if(isset($_POST['ddoderu'])){$ddoderu=$_POST['ddoderu'];}else{ $ddoderu='';} 
if(isset($_POST['palmai'])){$palmai=$_POST['palmai'];}else{ $palmai='';} 
if(isset($_POST['munei'])){$munei=$_POST['munei'];}else{ $munei='';} 
if(isset($_POST['brazi'])){$brazi=$_POST['brazi'];}else{ $brazi='';} 
if(isset($_POST['brazci'])){$brazci=$_POST['brazci'];}else{ $brazci='';} 
if(isset($_POST['homi'])){$homi=$_POST['homi'];}else{ $homi='';} 
if(isset($_POST['peci'])){$peci=$_POST['peci'];}else{ $peci='';} 
if(isset($_POST['pecti'])){$pecti=$_POST['pecti'];}else{ $pecti='';} 
if(isset($_POST['pectd'])){$pectd=$_POST['pectd'];}else{ $pectd='';} 
if(isset($_POST['cvi'])){$cvi=$_POST['cvi'];}else{$cvi='';} 
if(isset($_POST['dedodos'])){$dedodos=$_POST['dedodos'];}else{ $dedodos='';} 
if(isset($_POST['dedotres'])){$dedotres=$_POST['dedotres'];}else{ $dedotres='';} 
if(isset($_POST['dedocuatro'])){$dedocuatro=$_POST['dedocuatro'];}else{ $dedocuatro='';} 
if(isset($_POST['dedocincoo'])){$dedocincoo=$_POST['dedocincoo'];}else{ $dedocincoo='';}

if(isset($_POST['palmad'])){$palmad=$_POST['palmad'];}else{ $palmad='';}
if(isset($_POST['munecad'])){$munecad=$_POST['munecad'];}else{ $munecad='';}
if(isset($_POST['derbraz'])){$derbraz=$_POST['derbraz'];}else{ $derbraz='';}
if(isset($_POST['annbraz'])){$annbraz=$_POST['annbraz'];}else{ $annbraz='';}
if(isset($_POST['cconder'])){$cconder=$_POST['cconder'];}else{ $cconder='';}
if(isset($_POST['hombrod'])){$hombrod=$_POST['hombrod'];}else{ $hombrod='';}
if(isset($_POST['mandiderr'])){$mandiderr=$_POST['mandiderr'];}else{ $mandiderr='';}
if(isset($_POST['mandicentroo'])){$mandicentroo=$_POST['mandicentroo'];}else{ $mandicentroo='';}
if(isset($_POST['mandiizqui'])){$mandiizqui=$_POST['mandiizqui'];}else{ $mandiizqui='';}
if(isset($_POST['mejderecha'])){$mejderecha=$_POST['mejderecha'];}else{ $mejderecha='';}
if(isset($_POST['narizc'])){$narizc=$_POST['narizc'];}else{ $narizc='';}
if(isset($_POST['frenteizquierda'])){$frenteizquierda=$_POST['frenteizquierda'];}else{ $frenteizquierda='';}
if(isset($_POST['frentederecha'])){$frentederecha=$_POST['frentederecha'];}else{ $frentederecha='';}

if(isset($_POST['nuevo1'])){$nuevo1=$_POST['nuevo1'];}else{$nuevo1='';}
if(isset($_POST['nuevo2'])){$nuevo2=$_POST['nuevo2'];}else{$nuevo2='';}
if(isset($_POST['nuevo3'])){$nuevo3=$_POST['nuevo3'];}else{$nuevo3='';}
if(isset($_POST['nuevo4'])){$nuevo4=$_POST['nuevo4'];}else{$nuevo4='';}
if(isset($_POST['nuevo5'])){$nuevo5=$_POST['nuevo5'];}else{$nuevo5='';}
if(isset($_POST['nuevo6'])){$nuevo6=$_POST['nuevo6'];}else{$nuevo6='';}
if(isset($_POST['nuevo7'])){$nuevo7=$_POST['nuevo7'];}else{$nuevo7='';}
if(isset($_POST['nuevo8'])){$nuevo8=$_POST['nuevo8'];}else{$nuevo8='';}


//espalda
if(isset($_POST['plantapiea'])){$plantapiea=$_POST['plantapiea'];}else{ $plantapiea='';}
if(isset($_POST['plantapieader'])){$plantapieader=$_POST['plantapieader'];}else{ $plantapieader='';}
if(isset($_POST['tobilloati'])){$tobilloati=$_POST['tobilloati'];}else{ $tobilloati='';}
if(isset($_POST['tobilloatd'])){$tobilloatd=$_POST['tobilloatd'];}else{ $tobilloatd='';}
if(isset($_POST['ptiatras'])){$ptiatras=$_POST['ptiatras'];}else{ $ptiatras='';}
if(isset($_POST['ptdatras'])){$ptdatras=$_POST['ptdatras'];}else{ $ptdatras='';}
if(isset($_POST['pierespaldai'])){$pierespaldai=$_POST['pierespaldai'];}else{ $pierespaldai='';}
if(isset($_POST['pierespaldad'])){$pierespaldad=$_POST['pierespaldad'];}else{ $pierespaldad='';}
if(isset($_POST['musloatrasiz'])){$musloatrasiz=$_POST['musloatrasiz'];}else{ $musloatrasiz='';}
if(isset($_POST['musloatrasder'])){$musloatrasder=$_POST['musloatrasder'];}else{ $musloatrasder='';}
if(isset($_POST['glutiz'])){$glutiz=$_POST['glutiz'];}else{ $glutiz='';}
if(isset($_POST['glutder'])){$glutder=$_POST['glutder'];}else{ $glutder='';}
if(isset($_POST['cinturaiz'])){$cinturaiz=$_POST['cinturaiz'];}else{ $cinturaiz='';}
if(isset($_POST['cinturader'])){$cinturader=$_POST['cinturader'];}else{ $cinturader='';}
if(isset($_POST['costilliz'])){$costilliz=$_POST['costilliz'];}else{ $costilliz='';}
if(isset($_POST['costillder'])){$costillder=$_POST['costillder'];}else{ $costillder='';}

if(isset($_POST['espaldarribaiz'])){$espaldarribaiz=$_POST['espaldarribaiz'];}else{ $espaldarribaiz='';}
if(isset($_POST['espaldaarribader'])){$espaldaarribader=$_POST['espaldaarribader'];}else{ $espaldaarribader='';}
if(isset($_POST['espaldaalta'])){$espaldaalta=$_POST['espaldaalta'];}else{ $espaldaalta='';}
if(isset($_POST['dorsaliz'])){$dorsaliz=$_POST['dorsaliz'];}else{ $dorsaliz='';}
if(isset($_POST['dorsalder'])){$dorsalder=$_POST['dorsalder'];}else{ $dorsalder='';}
if(isset($_POST['munecaatrasiz'])){$munecaatrasiz=$_POST['munecaatrasiz'];}else{ $munecaatrasiz='';}
if(isset($_POST['munecaatrasder'])){$munecaatrasder=$_POST['munecaatrasder'];}else{ $munecaatrasder='';}
if(isset($_POST['antebiesp'])){$antebiesp=$_POST['antebiesp'];}else{ $antebiesp='';}
if(isset($_POST['antebdesp'])){$antebdesp=$_POST['antebdesp'];}else{ $antebdesp='';}
if(isset($_POST['casicodoi'])){$casicodoi=$_POST['casicodoi'];}else{ $casicodoi='';}
if(isset($_POST['casicododer'])){$casicododer=$_POST['casicododer'];}else{ $casicododer='';}
if(isset($_POST['brazalti'])){$brazalti=$_POST['brazalti'];}else{ $brazalti='';}
if(isset($_POST['brazaltder'])){$brazaltder=$_POST['brazaltder'];}else{ $brazaltder='';}

if(isset($_POST['cuellatrasb'])){$cuellatrasb=$_POST['cuellatrasb'];}else{ $cuellatrasb='';}
if(isset($_POST['cuellatrasmedio'])){$cuellatrasmedio=$_POST['cuellatrasmedio'];}else{ $cuellatrasmedio='';}
if(isset($_POST['cabedorsalm'])){$cabedorsalm=$_POST['cabedorsalm'];}else{ $cabedorsalm='';}
if(isset($_POST['cabealtaizqu'])){$cabealtaizqu=$_POST['cabealtaizqu'];}else{ $cabealtaizqu='';}
if(isset($_POST['cabezaaltader'])){$cabezaaltader=$_POST['cabezaaltader'];}else{ $cabezaaltader='';}

if(isset($_POST['espizq'])){$espizq=$_POST['espizq'];}else{ $espizq='';}
if(isset($_POST['espder'])){$espder=$_POST['espder'];}else{ $espder='';}
if(isset($_POST['coxis'])){$coxis=$_POST['coxis'];}else{ $coxis='';}

if(isset($_POST['notapost'])){$notapost=$_POST['notapost'];}else{ $notapost='';}
if(isset($_POST['cir_real'])){$cir_real=$_POST['cir_real'];}else{ $cir_real='';}

$ingresar = mysqli_query($conexion, 'INSERT INTO enf_posto (id_usua,id_atencion,fecha,ter_anes,ter_cir,tip_cir,p_medico,dispo_p,diagyodc,p_anato,tipo_de_i,sitio_ob,estudios_obser,p_a,s_a,t_a,oxi,con,muc,vent,est,cirujano,anestesiologo,instrumentista,circulante,mara,marb,marc,mard,mare,marf,marg,marh,pie,pied,tod,toi,rodi,rodd,musloi,muslod,inglei,iabdomen,ddi,ddidos,dditres,ddicuatro,ddicinco,ddoderu,palmai,munei,brazi,brazci,homi,peci,pecti,pectd,cvi,dedodos,dedotres,dedocuatro,dedocincoo,palmad,munecad,derbraz,annbraz,cconder,hombrod,mandiderr,mandicentroo,mandiizqui,mejderecha,narizc,frenteizquierda,frentederecha,nuevo1,nuevo2,nuevo3,nuevo4,nuevo5,nuevo6,nuevo7,nuevo8,plantapiea,plantapieader,tobilloati,tobilloatd,ptiatras,ptdatras,pierespaldai,pierespaldad,musloatrasiz,musloatrasder,glutiz,glutder,cinturaiz,cinturader,costilliz,costillder,espaldarribaiz,espaldaarribader,espaldaalta,dorsaliz,dorsalder,munecaatrasiz,munecaatrasder,antebiesp,antebdesp,casicodoi,casicododer,brazalti,brazaltder,cuellatrasb,cuellatrasmedio,cabedorsalm,cabealtaizqu,cabezaaltader,espizq,espder,coxis,notapost,cir_real,nociru) values (' . $id_usua . ' ,' . $id_atencion . ',"' . $fecha_reporte . '","' . $ter_anes . '","' . $ter_cir . '","' . $tip_cir . '"       ,"' . $p_medico . '","' . $dispo_p . '","' . $diagyodc . '","' . $p_anato . '","' . $tipo_de_i . '","' . $sitio_ob . '","' . $estudios_obser . '","' . $p_a . '","' . $s_a . '","' . $t_a . '","' . $oxi . '","' . $con . '","' . $muc . '","' . $vent . '","' . $est . '","' . $cirujano . '","' . $anestesiologo . '","' . $instrumentista . '","' . $circulante . '" ,"' . $mara .'","' . $marb .'","' . $marc .'","' . $mard .'","' . $mare .'","' . $marf .'","' . $marg .'","' . $marh .'","' . $pie .'","' . $pied .'","' . $tod .'","' . $toi .'","' . $rodi .'","' . $rodd .'","' . $musloi .'","' . $muslod .'","' . $inglei .'"  ,"' . $iabdomen .'","' . $ddi .'","' . $ddidos .'","' . $dditres .'","' . $ddicuatro .'","' . $ddicinco .'","' . $ddoderu .'","' . $palmai .'","' . $munei .'","' . $brazi .'","' . $brazci .'","' . $homi .'","' . $peci .'","' . $pecti .'","' . $pectd .'","' . $cvi .'","' . $dedodos .'","' . $dedotres .'","' . $dedocuatro .'","' . $dedocincoo .'","' . $palmad .'","' . $munecad .'","' . $derbraz .'","' . $annbraz .'","' . $cconder .'","' . $hombrod .'","' . $mandiderr .'","' . $mandicentroo .'","' . $mandiizqui .'","' . $mejderecha .'","' . $narizc .'","' . $frenteizquierda .'","' . $frentederecha .'","' . $nuevo1 .'","' . $nuevo2 .'","' . $nuevo3 .'","' . $nuevo4 .'","' . $nuevo5 .'","' . $nuevo6 .'","' . $nuevo7 .'","' . $nuevo8 .'","' . $plantapiea .'","' . $plantapieader .'","' . $tobilloati .'","' . $tobilloatd .'","' . $ptiatras .'","' . $ptdatras .'","' . $pierespaldai .'","' . $pierespaldad .'","' . $musloatrasiz .'","' . $musloatrasder .'","' . $glutiz .'","' . $glutder .'","' . $cinturaiz .'","' . $cinturader .'","' . $costilliz .'","' . $costillder .'","' . $espaldarribaiz .'","' . $espaldaarribader .'","' . $espaldaalta .'","' . $dorsaliz .'","' . $dorsalder .'","' . $munecaatrasiz .'","' . $munecaatrasder .'","' . $antebiesp .'","' . $antebdesp .'","' . $casicodoi .'","' . $casicododer .'","' . $brazalti .'","' . $brazaltder .'","' . $cuellatrasb .'","' . $cuellatrasmedio .'","' . $cabedorsalm .'","' . $cabealtaizqu .'","' . $cabezaaltader .'","' . $espizq . '","' . $espder . '","' . $coxis . '","' . $notapost . '","' . $cir_real . '","2") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
    
    echo mysqli_query($conexion,$ingresar);
    
    
    $resultado = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='$id_usua'") or die($conexion->error);
$usuario = $_SESSION['login'];
while($f = mysqli_fetch_array($resultado)){   
     $id_us=$f['papell'];
}

$fechactr = date("Y-m-d H:i");
$ingresar2 = mysqli_query($conexion, 'INSERT INTO control_enf (nom_enf,id_usua,id_atencion,nota,fecha) values ("' . $id_us . '",' . $id_usua . ' ,' . $id_atencion . ',"Nota postoperatoria","' . $fechactr . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
echo mysqli_query($conexion,$ingresar2);
    



