<?php
//se establece una conexion a la base de datos
session_start();
include '../../conexionbd.php';
//si se han enviado datos

$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];


$fecha_actual = date("Y-m-d H:i:s");
         $guia = ($_POST['guia']);              
      $espec = ($_POST['espec']);
    $motinter = ($_POST['motinter']);
    $riefeinter = ($_POST['riefeinter']);
    $revlinter = ($_POST['revlinter']);
    $probinter = ($_POST['probinter']);
    $tratprocinter = ($_POST['tratprocinter']);
    $procinter = ($_POST['proninter']);

    $criteinter = ($_POST['criteinter']);
    $planinter = ($_POST['planinter']);
    $sugdiaginter = ($_POST['sugdiaginter']);
    
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

$ingresar = mysqli_query($conexion, 'INSERT INTO signos_vitales (id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,peso,talla) values (' . $id_atencion . ' , ' . $id_usua . ' ,"'.$fecha_actual.'", " ' . $p_sistol . '" , "' . $p_diastol . '" , "' .$fcard . '" , "' . $fresp . '" , "' . $temper . ' ", "' . $satoxi . ' " ,"' . $peso . '", " ' . $talla . ' ") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

}
    

    $ingresar = mysqli_query($conexion, 'insert into  dat_not_inter (id_atencion,id_usua,fecha_inter,motinter,riefeinter,revlinter,probinter,tratprocinter,procinter,criteinter,planinter,sugdiaginter,espec,guia) values ( ' . $id_atencion . ', ' . $id_usua . ' , "'.$fecha_actual.'" ," ' . $motinter . '" ," ' . $riefeinter . '" ," ' . $revlinter . '" , "' . $probinter . '" , "' . $tratprocinter . '" , " ' . $procinter . ' " , "' . $criteinter . ' ", "' . $planinter . ' ", "' . $sugdiaginter . '","' . $espec . '","' . $guia . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


    //redirección
    header('location: ../hospitalizacion/vista_pac_hosp.php');

