<?php
//se establece una conexion a la base de datos
session_start();
include '../../conexionbd.php';
//si se han enviado datos
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$fecha_actual = date("Y-m-d H:i:s");

    //$Id_exp = ($_POST['Id_exp']);
    //  $fec_hc = ($_POST['fec_hc']);
    $problema = ($_POST['problema']);
    $subjetivo = ($_POST['subjetivo']);
    $objetivo = ($_POST['objetivo']);
    $analisis = ($_POST['analisis']);
    $plan = ($_POST['plan']);
    $px = ($_POST['px']);
     $guia = ($_POST['guia']);
    //$tip_ev = ($_POST['tip_ev']);
    $edosalud = ($_POST['edosalud']);

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

$ingresar = mysqli_query($conexion, 'INSERT INTO nota_posparto (fecha_nu,id_atencion,problema,subjetivo,objetivo,analisis,plan,px,guia,edosalud,id_usua) values (" ' . $fecha_actual . '",' . $id_atencion . '," ' . $problema . '" ," ' . $subjetivo . '" , "' . $objetivo . '" , "' . $analisis . '" , "' . $plan . '" , "' . $px . ' ","' . $guia . ' ", "' . $edosalud . ' " ,' . $id_usua . ') ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

$sql2 = "UPDATE dat_ingreso SET edo_salud ='$edosalud' WHERE id_atencion = $id_atencion";
      $result = $conexion->query($sql2);


    //redirección
    header('location: ../hospitalizacion/vista_pac_hosp.php');
 //si no se enviaron datos


