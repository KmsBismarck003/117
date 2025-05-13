<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$fecha_actual = date("Y-m-d H:i:s");

$horenv=$_POST['horenv'];
$horec=$_POST['horec'];
$rec=$_POST['rec'];
$docenv=$_POST['docenv'];
$docrec=$_POST['docrec'];
$resumclin=$_POST['resumclin'];
$motenv=$_POST['motenv'];
$imdiagn=$_POST['imdiagn'];
$ter=$_POST['ter'];
$guia=$_POST['guia'];
  //signos vitales   
    

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

$ingresar = mysqli_query($conexion, 'INSERT INTO signos_vitales (id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,peso,talla) values (' . $id_atencion . ' , ' . $id_usua . ' ," ' . $fecha_actual . '", " ' . $p_sistol . '" , "' . $p_diastol . '" , "' .$fcard . '" , "' . $fresp . '" , "' . $temper . ' ", "' . $satoxi . ' " ,"' . $peso . '", " ' . $talla . ' ") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

}

$insert=mysqli_query($conexion,'INSERT INTO dat_traslado(id_atencion,id_usua,horenv,env,rec,docenv,docrec,resumclin,motenv,imdiagn,ter,guia) VALUES('.$id_atencion.','.$id_usua.'," ' . $fecha_actual . '","MÉDICA SAN ISIDRO","'.$rec.'","'.$docenv.'","'.$docrec.'","'.$resumclin.'","'.$motenv.'","'.$imdiagn.'","'.$ter.'","'.$guia.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

header('location: ../hospitalizacion/vista_pac_hosp.php');

//header('location: ../hospitalizacion/vista_pac_hosp.php');