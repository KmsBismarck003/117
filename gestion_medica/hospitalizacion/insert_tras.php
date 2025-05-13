<?php
session_start();
include '../../conexionbd.php';

$id_sang=$_GET['id_sang'];

$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];

$id_atencion = $_SESSION['hospital'];

$fec_tras=$_POST['fec_tras'];
$num_tras=$_POST['num_tras'];
$cont_tras=$_POST['cont_tras'];
$fol_tras=$_POST['fol_tras'];
$glob_tras=$_POST['comp_sang'];
//$pla_tras=$_POST['pla_tras'];
//$crio_tras=$_POST['crio_tras'];
$hb_tras=$_POST['hb_tras'];
$hto_tras=$_POST['hto_tras'];
//$san_tras=$_POST['san_tras'];
//$inicio_tras=$_POST['inicio_tras'];
$med_tras=$_POST['med_tras'];
$medi_tras=$_POST['medi_tras'];
$ev_tras=$_POST['ev_tras'];
$com_tras=$_POST['com_tras'];
//$vol_tras=$_POST['vol_tras'];
//$fin_tras=$_POST['fin_tras'];
$com_traspost=$_POST['com_traspost'];
$ev_traspost=$_POST['ev_traspost'];


$edo_tras=$_POST['edo_tras'];
$ob_tras=$_POST['ob_tras'];
$sisto_tras=$_POST['sisto_tras'];
$diasto_tras=$_POST['diasto_tras'];
$fc_tras=$_POST['fc_tras'];
//$fr_tras=$_POST['fr_tras'];
$temp_tras=$_POST['temp_tras'];
//$sat_tras=$_POST['sat_tras'];
//$peso_tras=$_POST['peso_tras'];
//$talla_tras=$_POST['talla_tras'];


 $p_sistol = ($_POST['p_sistol']);
    $p_diastol = ($_POST['p_diastol']);
    $fcard = ($_POST['fcard']);
    //$fresp = ($_POST['fresp']);
    $temper = ($_POST['temper']);
 //   $satoxi = ($_POST['satoxi']);
  //  $peso = ($_POST['peso']);
    //$talla = ($_POST['talla']);

$resultado5=$conexion->query("SELECT * from dat_trans_sangre WHERE id_sangre=$id_sang") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {

$t=$f5['t'];
$a=$f5['a'];
$fc=$f5['fc'];
$temp_t=$f5['temp_t'];


$sist1=$f5['td'];
$diast1=$f5['ad'];
$frec1=$f5['fcd'];
$temp1=$f5['temp_td'];


$sist2=$f5['tde'];
$diast2=$f5['ade'];
$frec2=$f5['fcde'];
$temp2=$f5['temp_tde'];

$inicio_tras=$f5['hor_in'];
$fin_tras=$f5['hor_t'];
$vol_tras=$f5['vol'];

$folio=$f5['numt'];
$cont=$f5['cont'];
$fecht=$f5['fecht'];

 } 

$resultado1 = $conexion->query("SELECT paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn,dat_ingreso.fecha, dat_ingreso.id_atencion from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);
  while ($f1 = mysqli_fetch_array($resultado1)) {
         $sang=$f1['tip_san'];
        }


$fecha_actual = date("Y-m-d H:i:s");

if($sist1 == null and $diast1 == null and $frec1 == null and $temp1 == null){
 $sist1=$_POST['sist1'];
 $diast1=$_POST['diast1'];
 $frec1=$_POST['frec1'];
 $temp1=$_POST['temp1'];

 $update="UPDATE dat_trans_sangre set td='$sist1', ad='$diast1', fcd='$frec1', temp_td='$temp1' WHERE id_sangre=$id_sang";
 $result_update=$conexion->query($update);
}

if($sist2 == null and $diast2 == null and $frec2 == null and $temp2 == null and $fecht == null){
 $sist2=$_POST['sist2'];
 $diast2=$_POST['diast2'];
 $frec2=$_POST['frec2'];
 $temp2=$_POST['temp2'];

 $update="UPDATE dat_trans_sangre set tde='$sist2', ade='$diast2', fcde='$frec2', temp_tde='$temp2' WHERE id_sangre=$id_sang";
 $result_update=$conexion->query($update);
}

$insert=mysqli_query($conexion,'INSERT INTO dat_trasfucion(id_atencion,id_usua,fec_tras,num_tras,cont_tras,fol_tras,glob_tras,hb_tras,hto_tras,san_tras,sisto_pre,diasto_pre,fc_pre,temp_pre,inicio_tras,med_tras,medi_tras,ev_tras,com_tras,vol_tras,fin_tras,com_traspost,ev_traspost,edo_tras,ob_tras,sisto_tras,diasto_tras,fc_tras,temp_tras,p_sistol,p_diastol,fcard,temper,fecha_act) VALUES ('.$id_atencion.','.$id_usua.',"'.$fecht.'","'.$num_tras.'","'.$cont.'","'.$folio.'","'.$glob_tras.'","'.$hb_tras.'","'.$hto_tras.'","'.$sang.'",'.$t.','.$a.','.$fc.',"'.$temp_t.'","'.$inicio_tras.'","'.$med_tras.'","'.$medi_tras.'","'.$ev_tras.'","'.$com_tras.'","'.$vol_tras.'","'.$fin_tras.'","'.$com_traspost.'","'.$ev_traspost.'","'.$edo_tras.'","'.$ob_tras.'", " ' . $sist1 . '" , "' . $diast1 . '" , "' .$frec1. '", "' . $temp1 . ' ", " ' . $sist2 . '" , "' . $diast2 . '" , "' .$frec2 . '" ,"' . $temp2 . ' ","' . $fecha_actual . ' ")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));



 header('location: ../hospitalizacion/vista_pac_hosp.php');