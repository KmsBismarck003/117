<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];
$entrada_pac_confirm=$_POST['entrada_pac_confirm'];
$lug_noproc=$_POST['lug_noproc'];
$verificado=$_POST['verificado'];
$pulsioximetro=$_POST['pulsioximetro'];
$ver_inst=$_POST['ver_inst'];
$alerg_con=$_POST['alerg_con'];
$profilaxis=$_POST['profilaxis'];
$dif_via_aerea=$_POST['dif_via_aerea'];
$con_hematies=$_POST['con_hematies'];
$confirm_presentes=$_POST['confirm_presentes'];
$confirm_verb=$_POST['confirm_verb'];
$cir_rep=$_POST['cir_rep'];
$anest_resp=$_POST['anest_resp'];
$enf_rep=$_POST['enf_rep'];
$img_diag=$_POST['img_diag'];
$proced=$_POST['proced'];
$especialidad=$_POST['especialidad'];
$fecha=$_POST['fecha'];
$enf_confirm=$_POST['enf_confirm'];
$cont_comp_inst=$_POST['cont_comp_inst'];
$ident_gest=$_POST['ident_gest'];
$problema=$_POST['problema'];
$rev_cir_enf_anest=$_POST['rev_cir_enf_anest'];
$prof_trombo=$_POST['prof_trombo'];
$ident_pac=$_POST['ident_pac'];
$fir_cir=$_POST['fir_cir'];
$fir_anest=$_POST['fir_anest'];
$fir_enf=$_POST['fir_enf'];


$result=mysqli_query($conexion,'INSERT INTO dat_cir_seg (id_atencion,id_usua,entrada_pac_confirm,lug_noproc,verificado,pulsioximetro,ver_inst,alerg_con,profilaxis,dif_via_aerea,con_hematies,confirm_presentes,confirm_verb,cir_rep,anest_resp,enf_rep,img_diag,proced,especialidad,fecha,enf_confirm,cont_comp_inst,ident_gest,problema,rev_cir_enf_anest,prof_trombo,ident_pac,fir_cir,fir_anest,fir_enf) 
	VALUES('.$id_atencion.','.$id_usua.',"'.$entrada_pac_confirm.'","'.$lug_noproc.'","'.$verificado.'","'.$pulsioximetro.'","'.$ver_inst.'","'.$alerg_con.'","'.$profilaxis.'","'.$dif_via_aerea.'","'.$con_hematies.'","'.$confirm_presentes.'","'.$confirm_verb.'","'.$cir_rep.'","'.$anest_resp.'","'.$enf_rep.'","'.$img_diag.'","'.$proced.'","'.$especialidad.'","'.$fecha.'","'.$enf_confirm.'","'.$cont_comp_inst.'","'.$ident_gest.'","'.$problema.'","'.$rev_cir_enf_anest.'","'.$prof_trombo.'","'.$ident_pac.'","'.$fir_cir.'","'.$fir_anest.'","'.$fir_enf.'")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


header('location: ../hospitalizacion/vista_pac_hosp.php');

?>