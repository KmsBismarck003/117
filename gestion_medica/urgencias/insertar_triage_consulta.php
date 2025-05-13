<?php
//se establece una conexion a la base de datos
include '../../conexionbd.php';
//si se han enviado datos
$id_usu = $_GET['id_usu'];
$id_atencion=$_POST['id_atencion'];
if(isset($_POST['diab'])){
	$diab=$_POST['diab'];
	}else{
		$diab= "";
		
	}
	
	if(isset($_POST['quir_cu'])){
    $quir_cu = $_POST['quir_cu'];
}else{
    $quir_cu = "";
}

if(isset($_POST['trau_cu'])){
    $trau_cu = $_POST['trau_cu'];
}else{
        $trau_cu = "";
}
if(isset($_POST['otro_cu'])){$otro_cu = $_POST['otro_cu'];}else{$otro_cu = "";}
if(isset($_POST['despatol'])){$despatol = $_POST['despatol'];}else{$despatol = "";}
if(isset($_POST['pad_cu'])){$pad_cu = $_POST['pad_cu'];}else{$pad_cu = "";}
if(isset($_POST['exp_cu'])){$exp_cu = $_POST['exp_cu'];}else{$exp_cu = "";}
if(isset($_POST['des_diag'])){$des_diag = $_POST['des_diag'];}else{$des_diag = "";}
if(isset($_POST['diag2'])){$diag2 = $_POST['diag2'];}else{$diag2 = "";}
if(isset($_POST['med_cu'])){$med_cu = $_POST['med_cu'];}else{$med_cu = "";}
if(isset($_POST['anproc_cu'])){$anproc_cu = $_POST['anproc_cu'];}else{$anproc_cu = "";}
if(isset($_POST['trat_cu'])){$trat_cu = $_POST['trat_cu'];}else{$trat_cu= "";}
if(isset($_POST['do_cu'])){$do_cu = $_POST['do_cu'];}else{$do_cu= "";}
if(isset($_POST['diag_cu'])){$diag_cu = $_POST['diag_cu'];}else{$diag_cu= "";}

$fecha_actual = date("Y-m-d H:i:s");
$ingresar6 = mysqli_query($conexion, 'insert into dat_c_urgen (id_atencion,diab_pa,diab_ma,diab_ab,hip_pa,hip_ma,hip_ab,can_pa,can_ma,can_ab,motcon_cu,trau_cu,trans_cu,adic_cu,tab_cu,alco_cu,otro_cu,quir_cu,aler_cu,pad_cu,exp_cu,diag_cu,hc_men,hc_ritmo,gestas_cu,partos_cu,ces_cu,abo_cu,fecha_fur,hc_desc_hom,proc_cu,med_cu,anproc_cu,trat_cu,do_cu,dis_cu,fecha_urgen,id_usua,despatol,diag2,des_diag) values ('.$id_atencion.'," ' . $diab_pa . '" ," ' . $diab_ma . '" ," ' . $diab_ab . '" ," ' . $hip_pa . '" ," ' . $hip_ma . '" ," ' . $hip_ab . '" , "' . $can_pa . '" ,"' . $can_ma . '" ,"' . $can_ab . '" ,"' . $edo_clin . '", "' . $trau_cu  . '" , "' . $trans_cu . '" , "' . $adic_cu . ' " ,"' . $tab_cu . ' ","' . $alco_cu . ' ","' . $otro_cu . ' ", "' . $quir_cu . ' " ,"' . $aler_cu . ' ", "' . $pad_cu . ' " , "' . $exp_cu . ' " , "' . $diag_cu . ' ", "' . $hc_men . ' " , "' . $hc_ritmo . ' ","' . $gestas_cu . ' ","' . $partos_cu . ' ","' . $ces_cu . ' ","' . $abo_cu . ' ","' . $fecha_fur . ' ","' . $hc_desc_hom . ' ", "' . $proc_cu . ' ","' . $med_cu . ' " , "' . $anproc_cu . ' " , "' . $trat_cu . ' " , "' . $do_cu . ' " , "' . $dis_cu . ' ","' . $fecha_actual . ' ", ' . $id_usu . ',"' . $despatol . '","' . $diag2 . '", "'.$des_diag.'" ) ')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

$insertar=mysqli_query($conexion,'INSERT INTO recetaurgen(id_atencion,id_usua,receta_urgen,fecha_recurgen) values ('.$id_atencion.','.$id_usu.',"'.$med_cu.'","'.$fecha_actual.'")')  or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

//diagnosticos tabla
   $diag=mysqli_query($conexion,'insert into diag_pac(Id_exp,id_usua,diag_paciente,fecha) values ('.$id_atencion.','.$id_usu.',"'.$diag_cu.'","'.$fecha_actual.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));
   
    header ('location: ./vista_usuario_triage.php');


?>