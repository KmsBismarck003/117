<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];


$fecha_actual = date("Y-m-d H:i:s");

//$fecha_ord = $_POST['fecha_ord'];
//$hora_ord = $_POST['hora_ord'];
if (isset($_POST['sangre'])) {
    $sangre = $_POST['sangre'];
    $select_idexp="SELECT * FROM dat_ingreso d, paciente p where d.id_atencion=$id_atencion and d.Id_exp=p.Id_exp";
    $result_id=$conexion->query($select_idexp);
    while ($row_id=$result_id->fetch_assoc()) {
        $id_exp=$row_id['Id_exp'];
    }
    $update_sangre="UPDATE paciente SET tip_san='$sangre' where Id_exp=$id_exp";
    $resultupdate=$conexion->query($update_sangre);
}else{
    $select_idexp="SELECT * FROM dat_ingreso d, paciente p where d.id_atencion=$id_atencion and d.Id_exp=p.Id_exp";
    $result_id=$conexion->query($select_idexp);
    while ($row_id=$result_id->fetch_assoc()) {
        $id_exp=$row_id['Id_exp'];
        $tip_san=$row_id['tip_san'];
    }
    $update_sangre="UPDATE paciente SET tip_san='$tip_san' where Id_exp=$id_exp";
    $resultupdate=$conexion->query($update_sangre);
}


$dieta = $_POST['dieta'];
$det_dieta = $_POST['det_dieta'];
$detalle_lab = $_POST['detalle_lab'];
$cuid_gen = $_POST['cuid_gen'];
$signos = $_POST['signos'];
$monitoreo = $_POST['monitoreo'];
$diuresis = $_POST['diuresis'];
$dex = $_POST['dex'];
$semif = $_POST['semif'];
$vigilar = $_POST['vigilar'];
$oxigeno = $_POST['oxigeno'];
$nebu = $_POST['nebu'];

$bar = $_POST['bar'];
$baño = $_POST['baño'];
$foley = $_POST['foley'];
$ej = $_POST['ej'];
$datsan = $_POST['datsan'];

/*
$cur = $_POST['cur'];
$curt = $_POST['curt'];
$conl = $_POST['conl'];
$conlt = $_POST['conlt'];  
*/

$gca = $_POST['gca'];
$gcat = $_POST['gcat'];
$son = $_POST['sont'];
$solt = $_POST['solt'];



//detalles
$detsignos = $_POST['detsignos'];
$detmonitoreo = $_POST['detmonitoreo'];
$detdiuresis = $_POST['detdiuresis'];
$detdex = $_POST['detdex'];
$detsemif = $_POST['detsemif'];
$detvigilar = $_POST['detvigilar'];
$detoxigeno = $_POST['detoxigeno'];

$detnebu = $_POST['detnebu'];
$detbar = $_POST['detbar'];
$detbaño = $_POST['detbaño'];
$detfoley = $_POST['detfoley'];
$detej = $_POST['detej'];
$detsan = $_POST['detsan'];

$med_med = $_POST['med_med'];
$soluciones = $_POST['soluciones'];
//$perfillab = $_POST['perfillab'];
$observ_be = $_POST['observ_be'];

$det_sang = $_POST['det_sang'];



$v1 = $_POST['a1'];
$sep = implode(",", $v1);
$servicio = json_encode($sep);
if ($servicio === 'NINGUNO') {
    $servicio = '"NINGUNO"';
}


$s1 = $_POST['s1'];
$sang = implode(",", $s1);
$serv_sang = json_encode($sang);
if ($serv_sang === 'NINGUNO') {
    $serv_sang = '"NINGUNO"';
}

$l1 = $_POST['l1'];
$perfillab = implode(",", $l1);
$serv_perfillab = json_encode($perfillab);
if ($serv_perfillab === 'NINGUNO') {
    $serv_perfillab = '"NINGUNO"';
}

$sql_hab = "SELECT * FROM cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);
while ($row_hab = $result_hab->fetch_assoc()) {
    $hab = $row_hab['num_cama'];
}


$id_imagenologia = $_POST["a1"]; //Escanpando caracteres
$solicitud_sang = $_POST["s1"]; //Escanpando caracteres
$perfillab = $_POST["l1"];

for ($i = 0; $i < count($id_imagenologia); $i++) {

    $id_imagenologia1 = $id_imagenologia[$i];
    if ($id_imagenologia1 === 'NINGUNO') {
    } else {
           $insertarnot=mysqli_query($conexion,'INSERT INTO notificaciones_imagen(id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado,interpretado) values ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.',"'.$id_imagenologia1.'","NO","","NO")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
     //   echo 'INSERT INTO notificaciones_imagen(id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado) values (' . $id_atencion . ',' . $hab . ',NOW(),' . $id_usua . ',' . $id_imagenologia1 . ',"NO","")';

    }

}

for ($i = 0; $i < count($solicitud_sang); $i++) {

    $solicitud_sang1 = $solicitud_sang[$i];
    if ($solicitud_sang1 === 'NINGUNO') {
    } else {
          $insertarnot=mysqli_query($conexion,'INSERT INTO notificaciones_sangre(id_atencion,habitacion,fecha_ord,id_usua,sol_sangre,realizado,resultado,det_sang) values ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.',"'.$solicitud_sang1.'","NO","","'.$det_sang.'")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
      //  echo 'INSERT INTO notificaciones_sangre(id_atencion,habitacion,fecha_ord,id_usua,sol_sangre,realizado,resultado) values (' . $id_atencion . ',' . $hab . ',NOW(),' . $id_usua . ',' . $solicitud_sang1 . ',"NO","")';

    }

}

for ($i = 0; $i < count($perfillab); $i++) {

    $perfillab1 = $perfillab[$i];
    if ($perfillab1 === 'NINGUNO') {
    } else {
$insertarnotlabo=mysqli_query($conexion,'INSERT INTO notificaciones_labo(id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado) values ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.',"'.$perfillab1.'","NO","")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
 }

}

   /* if ($perfillab === 'NINGUNO') {
    } else {
$insertarnotlabo=mysqli_query($conexion,'INSERT INTO notificaciones_labo(id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado) values ('.$id_atencion.','.$hab.',"'.$fecha_actual.'",'.$id_usua.',"'.$perfillab.'","NO","")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

       // echo 'INSERT INTO notificaciones_labo(id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado) values (' . $id_atencion . ',' . $hab . ',NOW(),' . $id_usua . ',"' . $perfillab . '","NO","")';

    }*/

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

$fecha_actual = date("Y-m-d");


$hora_ord = date("H:i:s");

$resultado=$conexion->query("SELECT * from reg_usuarios WHERE id_usua= $id_usua") or die($conexion->error);
    while ($ROW = mysqli_fetch_array($resultado)) {
 $nombre=$ROW['nombre'];
 $papell=$ROW['papell'];
 $sapell=$ROW['sapell'];
}

$nombre_medico=$nombre.' '.$papell.' '.$sapell;

$insertar = mysqli_query($conexion, 'INSERT INTO dat_ordenes_med(id_atencion,id_usua,fecha_ord,hora_ord,dieta,det_dieta,cuid_gen,signos,monitoreo,diuresis,dex,semif,vigilar,oxigeno,nebulizacion,bar,baño,foley,ej,datsan,detsignos,detmonitoreo,detdiuresis,detdex,detsemif,detvigilar,detoxigeno,detnebu,detbar,detbaño,detfoley,detej,detsan,med_med,soluciones,perfillab,sol_estudios,solicitud_sang,det_sang,observ_be,medico,tipo,detalle_lab,gca,gcat,son,sont) values (' . $id_atencion . ',' . $id_usua . ',"' . $fecha_actual . '","' . $hora_ord . '","' . $dieta . '","' . $det_dieta . '","' . $cuid_gen . '","' . $signos . '","' . $monitoreo . '","' . $diuresis . '","' . $dex . '","' . $semif . '","' . $vigilar . '","'.$oxigeno.'","'.$nebu.'","'.$bar.'","'.$baño.'","'.$foley.'","'.$ej.'","'.$datsan.'","'.$detsignos.'","'.$detmonitoreo.'","'.$detdiuresis.'","'.$detdex.'","'.$detsemif.'","'.$detvigilar.'","'.$detoxigeno.'","'.$detnebu.'","'.$detbar.'","'.$detbaño.'","'.$detfoley.'","'.$detej.'","'.$detsan.'","' . $med_med . '","' . $soluciones . '",' . $serv_perfillab . ','. $servicio. ',' . $serv_sang . ',"'.$det_sang.'","'.$observ_be.'","'.$nombre_medico.'","MEDICO","'.$detalle_lab.'","'.$gca.'","'.$gcat.'","'.$son.'","'.$sont.'")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

       // echo 'INSERT INTO dat_ordenes_med(id_atencion,id_usua,fecha_ord,hora_ord,dieta,cuid_gen,signos,monitoreo,diuresis,dex,semif,vigilar,med_med,soluciones,perfillab,sol_estudios,solicitud_sang) values (' . $id_atencion . ',' . $id_usua . ',"' . $fecha_ord . '","' . $hora_ord . '","' . $dieta . '","' . $cuid_gen . '","' . $signos . '","' . $monitoreo . '","' . $diuresis . '","' . $dex . '","' . $semif . '","' . $vigilar . '","' . $med_med . '","' . $soluciones . '","' . $perfillab . '",' . $id_imagenologia1 . ',' . $solicitud_sang1 . ')';

header('location: ../hospitalizacion/vista_pac_hosp.php');

        ?>