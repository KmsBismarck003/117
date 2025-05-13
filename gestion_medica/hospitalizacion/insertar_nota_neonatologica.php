<?php
//se establece una conexion a la base de datos
session_start();
include '../../conexionbd.php';
//si se han enviado datos
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

$fecha_actual = date("Y-m-d H:i:s");

    $idrecien_nacido = ($_POST['idrecien_nacido']);
    
    $fecnacimiento = ($_POST['fecnacimiento']);
    $horanac = ($_POST['horanac']);

    $pac_neon = ($_POST['pac_neon']);
    $subjetivo_neon = ($_POST['subjetivo_neon']);
    $objetivo_neon = ($_POST['objetivo_neon']);
    $analisis_neon = ($_POST['analisis_neon']);
    $plan_neon = ($_POST['plan_neon']);
    $px_neon = ($_POST['px_neon']);
    $edosalud_neon = ($_POST['edosalud_neon']);

    //signos bebe
    $p_sistol = ($_POST['p_sistol']);
    $p_diastol = ($_POST['p_diastol']);
    $fcard = ($_POST['fcard']);
    $fresp = ($_POST['fresp']);
    $temper = ($_POST['temper']);
    $satoxi = ($_POST['satoxi']);
    $peso = ($_POST['peso']);
    $talla = ($_POST['talla']);
      $apgar = ($_POST['apgar']);
    $silver = ($_POST['silver']);
    $an = ($_POST['an']);
      $guia = ($_POST['guia']);
    

$ingresar = mysqli_query($conexion, 'INSERT INTO dat_not_neona (id_atencion,id_usua,fecha_neona,idrecien_nacido,pac_neon,subjetivo_neon,objetivo_neon,analisis_neon,plan_neon,px_neon,guia,edosalud_neon,p_sistol,p_diastol,fcard,fresp,temper,satoxi,peso,talla,apgar,silver,an,fecnacimiento,horanac) values (' . $id_atencion . ' , ' . $id_usua . ' ,"' . $fecha_actual . '", "' . $idrecien_nacido . '" , "' . $pac_neon . '" , "' . $subjetivo_neon . '" , "' . $objetivo_neon . ' ", "' . $analisis_neon . ' " ,"' . $plan_neon . '","' . $px_neon . '","' . $guia . '","' . $edosalud_neon . '","' . $p_sistol . '","' . $p_diastol . '","' . $fcard . '","' . $fresp . '","' . $temper . '","' . $satoxi . '","' . $peso . '","' . $talla . '","' . $apgar. '","' . $silver . '","' . $an . '","' . $fecnacimiento. '","' .$horanac . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

    
    //redirección
    header('location: ../hospitalizacion/vista_pac_hosp.php');
 //si no se enviaron datos


