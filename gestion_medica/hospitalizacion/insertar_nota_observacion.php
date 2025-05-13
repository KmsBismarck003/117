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
    $problemao = ($_POST['problemao']);
    $subjetivob = ($_POST['subjetivob']);
    $objetivob = ($_POST['objetivob']);
    $analisiso = ($_POST['analisiso']);
$des_diag = ($_POST['des_diag']);

    $trat_noturgen = ($_POST['trat_noturgen']);
    $plano = ($_POST['plano']);
 $guia = ($_POST['guia']);
   
    $pxo = ($_POST['pxo']);

      $resultado1 = $conexion->query("select * from dat_ingreso WHERE id_atencion=$id_atencion" ) or die($conexion->error);
   while ($f1 = mysqli_fetch_array($resultado1)) {
    
    $area=$f1['area'];
   }

/*
//tabla de solicitud_interv
    $tipo_intervenciony = ($_POST['tipo_intervenciony']);
    $fechay = ($_POST['fechay']);
    $hora_solicitudy = ($_POST['hora_solicitudy']);
    $intervencion_soly = ($_POST['intervencion_soly']);
    $diag_preopy = ($_POST['diag_preopy']);
    $cirugia_progy = ($_POST['cirugia_progy']);
    $quirofanoy = ($_POST['quirofanoy']);
    $reservay = ($_POST['reservay']);

    $localy = ($_POST['localy']);
    $regionaly = ($_POST['regionaly']);
    $generaly = ($_POST['generaly']);
    $hby = ($_POST['hby']);
    $htoy = ($_POST['htoy']);
    $pesoy = ($_POST['pesoy']);
    $inst_necesarioy = ($_POST['inst_necesarioy']);

 $medmat_necesarioy = ($_POST['medmat_necesarioy']);
    $nom_jefe_servy = ($_POST['nom_jefe_servy']);
    $fecha_progray = ($_POST['fecha_progray']);
    $hora_progray = ($_POST['hora_progray']);
    $salay = ($_POST['salay']);

    $intervencion_quiry = ($_POST['intervencion_quiry']);
    $inicioy = ($_POST['inicioy']);
    $terminoy = ($_POST['terminoy']);
*/
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

$ingresar = mysqli_query($conexion, 'INSERT INTO signos_vitales (id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,peso,talla,fecha_registro) values (' . $id_atencion . ' , ' . $id_usua . ' ," ' . $fecha_actual . '", " ' . $p_sistol . '" , "' . $p_diastol . '" , "' .$fcard . '" , "' . $fresp . '" , "' . $temper . ' ", "' . $satoxi . ' " ,"' . $peso . '", " ' . $talla . ' ","'.$fecha_actual.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

}


 if (isset($_POST['dest_cu_ob'])) {
    $dest_cu_ob = ($_POST['dest_cu_ob']);

    $ingresar = mysqli_query($conexion, 'INSERT INTO dat_ob (fecha_ob,id_atencion,problemao,subjetivob,objetivob,analisiso,trat_noturgen,plano,guia,pxo,dest_cu_ob,id_usua,des_diag) values (" ' . $fecha_actual . '",' . $id_atencion . ' ," ' . $problemao . '" ," ' . $subjetivob . '" , "' . $objetivob . '" , "' . $analisiso . '" , " ' . $trat_noturgen . ' " , "' . $plano . '" ,"' . $guia . '", "' . $pxo . ' ","' . $dest_cu_ob . ' ",' . $id_usua . ',"'.$des_diag.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

$ingresar=mysqli_query($conexion,'UPDATE dat_ingreso SET area = "'.$dest_cu_ob.'" WHERE id_atencion = "'.$id_atencion.'" ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


/*if($dest_cu_ob=="QUIROFANO"){
$ingresarsol = mysqli_query($conexion, 'INSERT INTO solicitud_interv_quir (id_atencion,id_usua,tipo_intervenciony,fechay,hora_solicitudy,intervencion_soly,diag_preopy,cirugia_progy,quirofanoy,reservay,localy,regionaly,generaly,hby,htoy,pesoy,tipo_sangrey,inst_necesarioy,medmat_necesarioy,nom_jefe_servy,fecha_progray,hora_progray,salay,intervencion_quiry,inicioy,terminoy) values (' . $id_atencion . ' , ' . $id_usua . ' ," ' . $tipo_intervenciony . '" ," ' . $fechay . '" , "' . $hora_solicitudy . '" , "' . $intervencion_soly . '" , "' . $diag_preopy . '" , "' . $cirugia_progy . ' ","' . $quirofanoy . ' ","' . $reservay . '","' . $localy . '","' . $regionaly . '","' . $generaly . '","' . $hby . '", " ' . $htoy . ' ","' . $pesoy . '","' . $tipo_sangrey . '","' . $inst_necesarioy . '","' . $medmat_necesarioy . '","' . $nom_jefe_servy . '","' . $fecha_progray . '","' . $hora_progray . '","' . $salay . '","' . $intervencion_quiry . '","' . $inicioy . '","' . $terminoy . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
}

*/


}else{

    $ingresar = mysqli_query($conexion, 'INSERT INTO dat_ob (fecha_ob,id_atencion,problemao,subjetivob,objetivob,analisiso,trat_noturgen,plano,guia,pxo,dest_cu_ob,id_usua) values (" ' . $fecha_actual . '",' . $id_atencion . ' ," ' . $problemao . '" ," ' . $subjetivob . '" , "' . $objetivob . '" , "' . $analisiso . '" , " ' . $trat_noturgen . ' " , "' . $plano . '" ,"' . $guia . '", "' . $pxo . ' ","' . $area . ' ",' . $id_usua . ') ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

    $ingresar=mysqli_query($conexion,'UPDATE dat_ingreso SET area = "'.$area.'" WHERE id_atencion = "'.$id_atencion.'" ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
}
       



    header('location: ../hospitalizacion/vista_pac_hosp.php');
 //si no se enviaron datos


