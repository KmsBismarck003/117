<?PHP
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_GET['id_atencion'];
 
 $tecan_pos=$_POST['tecan_pos'];
 $tiem_pos=$_POST['tiem_pos'];
 $an_pos=$_POST['an_pos'];
 $ad_pos=$_POST['ad_pos'];
 $con_pos=$_POST['con_pos'];
 $bal_pos=$_POST['bal_pos'];
 $sist_pos=$_POST['sist_pos'];
 $dias_pos=$_POST['dias_pos'];
 $fc_pos=$_POST['fc_pos'];
 $fr_pos=$_POST['fr_pos'];
 $temp_pos=$_POST['temp_pos'];
 $pul_pos=$_POST['pul_pos'];
 $so_pos=$_POST['so_pos'];
 $ae_pos=$_POST['ae_pos'];
 $san_pos=$_POST['san_pos'];
 //$ven_pos=$_POST['ven_pos'];
 //$dre_pos=$_POST['dre_pos'];
 $tras_pos=$_POST['tras_pos'];
 $ob_pos=$_POST['ob_pos'];
 $plan_pos=$_POST['plan_pos'];


$fecha_actual = date("Y-m-d H:i:s");

$insert=mysqli_query($conexion,'INSERT INTO dat_post_anest_amb(id_atencion,id_usua,tecan_pos,tiem_pos,an_pos,ad_pos,con_pos,bal_pos,sist_pos,dias_pos,fc_pos,fr_pos,temp_pos,pul_pos,so_pos,ae_pos,san_pos,tras_pos,ob_pos,plan_pos,fecha_pos) VALUE ('.$id_atencion.','.$id_usua.',"'.$tecan_pos.'","'.$tiem_pos.'","'.$an_pos.'","'.$ad_pos.'","'.$con_pos.'","'.$bal_pos.'","'.$sist_pos.'","'.$dias_pos.'","'.$fc_pos.'","'.$fr_pos.'","'.$temp_pos.'","'.$pul_pos.'","'.$so_pos.'","'.$ae_pos.'","'.$san_pos.'","'.$tras_pos.'","'.$ob_pos.'","'.$plan_pos.'","'.$fecha_actual.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

header('location: ../../template/menu_medico.php');


?>