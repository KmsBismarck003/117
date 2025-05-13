<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];


$fecha_actual = date("Y-m-d H:i:s");
$diag_ingreso=$_POST['diag_ingreso'];
$diag_eg=$_POST['diag_eg'];

$res_clin=$_POST['res_clin'];

$reingreso=$_POST['reingreso'];
$cond=$_POST['cond'];
//$dias=$_POST['dias'];
$manejodur=$_POST['manejodur'];
$probclip=$_POST['probclip'];
$cuid=$_POST['cuid'];
$trat=$_POST['trat'];
$exes=$_POST['exes'];
$pcita=$_POST['pcita'];
$hcita=$_POST['hcita'];
//$nota_defuncion=$_POST['nota_defuncion'];
  //signos vitales   
    
$fech_alta=$_POST['fech_alta'];
$hor_alta=$_POST['hor_alta'];
$obs_med=$_POST['obs_med'];
$guia=$_POST['guia'];




    $resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_sig DESC LIMIT 1") or die($conexion->error);
    while ($f5 = mysqli_fetch_array($resultado5)) {
 $atencion=$f5['id_sig'];
}
if ($atencion == NULL) {

$p_sistol = ($_POST['p_sistol']);
    $p_diastol = ($_POST['p_diastol']);
    $fcard = ($_POST['fcard']);
    $fresp = ($_POST['fresp']);
    $temper = ($_POST['temper']);
    $satoxi = ($_POST['satoxi']);
    $peso = ($_POST['peso']);
    $talla = ($_POST['talla']);

$ingresar = mysqli_query($conexion, 'INSERT INTO signos_vitales (id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,peso,talla) values (' . $id_atencion . ' , ' . $id_usua . ' , " ' . $fecha_actual . '", " ' . $p_sistol . '" , "' . $p_diastol . '" , "' .$fcard . '" , "' . $fresp . '" , "' . $temper . ' ", "' . $satoxi . ' " ,"' . $peso . '", " ' . $talla . ' ") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

}


$resultado1 = $conexion ->query("SELECT diag_paciente FROM diag_pac WHERE id_exp=$id_atencion")or die($conexion->error);
           if(mysqli_num_rows($resultado1) > 0 ){ //se mostrara si existe mas de 1
               $fila=mysqli_fetch_row($resultado1);
               $diagfinal=$fila[0];
                }
            



$sql_now = "SELECT DATE_ADD(NOW(), INTERVAL 12 HOUR) as dat_now FROM dat_ingreso WHERE id_atencion = " . $_SESSION['hospital'];

      $result_now = $conexion->query($sql_now);

      while ($row_now = $result_now->fetch_assoc()) {
        $dat_now = $row_now['dat_now'];
      }

      $sql_est = "SELECT DATEDIFF( '$dat_now' , fecha) as estancia FROM dat_ingreso WHERE id_atencion =" . $_SESSION['hospital'];

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
        $estancia = $row_est['estancia'];
      }








$sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_usua";
    $result_med = $conexion->query($sql_med);

    while ($row_med = $result_med->fetch_assoc()) {
      $nom = $row_med['nombre'];
      $app = $row_med['papell'];
      $apm = $row_med['sapell'];
      }
$nombre_medico=$app.' '.$apm;

$ialta=mysqli_query($conexion,'INSERT INTO alta(id_atencion,id_usua,alta_por,fech_alta,hor_alta,obs_med) values ('.$id_atencion.','.$id_usua.',"'.$cond.'","'.$fech_alta.'","'.$hor_alta.'","'.$nombre_medico.'","'.$obs_med.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));

$sql22 = "UPDATE dat_ingreso SET alta_med = 'SI', fecha_alt_med = '$fech_alta', hora_alt_med = '$hor_alta', motivo_alta='".$cond."', edo_salud = '".$cond."' WHERE id_atencion = $id_atencion";
      $result = $conexion->query($sql22);



$insertar=mysqli_query($conexion,'INSERT INTO dat_egreso(id_atencion,id_usua,fech_egreso,diag_eg,res_clin,diagfinal,reingreso,cond,dias,manejodur,probclip,cuid,trat,exes,pcita,hcita,guia) values ('.$id_atencion.','.$id_usua.',"'.$fecha_actual.'","'.$diag_eg.'","'.$res_clin.'","'.$diagfinal.'","'.$reingreso.'","'.$cond.'","'.$estancia.'","'.$manejodur.'","'.$probclip.'","'.$cuid.'","'.$trat.'","'.$exes.'","'.$pcita.'","'.$hcita.'","'.$guia.'")')  or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

    //redirección

    $select="SELECT * FROM dat_egreso order by id_egreso DESC LIMIT 1";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $id_egreso=$row['id_egreso'];
    }

      $select="SELECT * FROM dat_ingreso where id_atencion=$id_atencion";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $id_exp=$row['Id_exp'];
    }




//echo '<script type="text/javascript">window.location.href = "receta_ambulatoria.php";</script>';

echo '<script >window.open("../pdf/pdf_egreso.php?id_egreso='.$id_egreso.'&id_exp='.$id_exp.'&id_atencion='.$id_atencion.'", "RECETA AMBULATORIA", "width=1000, height=1000")</script>'.
 '<script type="text/javascript">window.location.href ="../hospitalizacion/vista_pac_hosp.php" ;</script>';


  //  header('location: ../hospitalizacion/vista_pac_hosp.php');
 //si no se enviaron datos


?>