<?php
//se establece una conexion a la base de datos
session_start();
include '../../conexionbd.php';
//si se han enviado datos
$usuario = $_SESSION['login'];
$id_usu= $usuario['id_usua'];
$id_atencion=$_SESSION['hospital'];

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);
   while ($f1 = mysqli_fetch_array($resultado1)) {
   $id_exp=$f1['Id_exp'];                          
}

if(isset($_POST['hc_her_o'])){
    $hc_her_o = $_POST['hc_her_o'];
  }else{
    $hc_her_o = "";
  }

if(isset($_POST['hc_otro'])){
    $hc_otro = ($_POST['hc_otro']);
}else{
    $hc_otro = "";
}

if (isset($_POST['hc_pato'])) {
    $hc_pato = ($_POST['hc_pato']);
} else {
    $hc_pato = "";
}
/*
if (isset($_POST['hc_pato_cual'])) {
    $hc_pato_cual = ($_POST['hc_pato_cual']);
} else {
    $hc_pato_cual ="";
}

if (isset($_POST['hc_enf_cual'])) {
    $hc_enf_cual = ($_POST['hc_enf_cual']);
} else {
    $hc_enf_cual ="";
}
*/

if(isset($_POST['hc_men'])){
    $hc_men = ($_POST['hc_men']);
}else{
        $hc_men = "";
    }

if(isset($_POST['hc_ritmo'])){
    $hc_ritmo = ($_POST['hc_ritmo']);
}else{
        $hc_ritmo = "";
    }
if (isset($_POST['hc_ges'])) {
    $hc_ges = $_POST['hc_ges'];
} else {
    $hc_ges = " ";
}

if (isset($_POST['hc_par'])) {
    $hc_par = $_POST['hc_par'];
} else {
    $hc_par = " ";
}

if (isset($_POST['hc_ces'])) {
    $hc_ces = $_POST['hc_ces'];
} else {
    $hc_ces = " ";
}

if (isset($_POST['hc_abo'])) {
    $hc_abo = $_POST['hc_abo'];
} else {
    $hc_abo = " ";
}

  if(isset($_POST['hc_fechafur'])){
    $hc_fechafur = ($_POST['hc_fechafur']);
    }else{
    $hc_fechafur = "";
    }

if (isset($_POST['hc_tra'])) {
    $hc_tra = ($_POST['hc_tra']);
} else {
    $hc_tra ="NO";
}

if(isset($_POST['hc_ale'])){
    $hc_ale = ($_POST['hc_ale']);
}else{
        $hc_ale ="NO";
    }



if(isset($_POST['hc_desc_hom'])){
    $hc_desc_hom = ($_POST['hc_desc_hom']);
}else{
        $hc_desc_hom = "";
    }
  

if(isset($_POST['cro'])){
     $cro = ($_POST['cro']);
}else{
        $cro ="NO";
    }

if(isset($_POST['crog'])){
    $crog = ($_POST['crog']);
}else{
        $crog ="NO";
    }

    $tip_hc = ($_POST['tip_hc']);
    $ocupa   = mysqli_real_escape_string($conexion, (strip_tags($_POST["ocupa"], ENT_QUOTES)));
    $tip_san   = mysqli_real_escape_string($conexion, (strip_tags($_POST["tip_sang"], ENT_QUOTES)));

    $hc_pade = ($_POST['hc_pade']);
    $cardio = ($_POST['cardio']);
   

    $habitus = ($_POST['habitus']);
   

    $hc_lab = ($_POST['hc_lab']);
    $hc_gabi = ($_POST['hc_gabi']);
    $hc_res_o = ($_POST['hc_res_o']);
    $diagprob_i = ($_POST['id_cie_10']);
    $des_diag  = ($_POST['des_diag']);
    $diag_prev = ($_POST['diag_prev']);
    
    $hc_vid = ($_POST['hc_vid']);
    $hc_def = ($_POST['hc_def']);
   
    $guia = ($_POST['guia']);

    $hc_te = ($_POST['hc_te']);
    $hc_ta = ($_POST['hc_ta']);

  
    $peso = "";
    $talla = "";

    $p_sistolica = ($_POST['p_sistol']);
    $p_diastolica = ($_POST['p_diastol']);
    $f_card = ($_POST['fcard']);
    $f_resp = ($_POST['fresp']);
    $temp = ($_POST['temper']);
    $sat_oxigeno = ($_POST['satoxi']);
    if(isset($_POST['peso'])){ 
    $peso = ($_POST['peso']);}
    else {
    $peso = "";}
    if(isset($_POST['talla'])){ 
    $talla = ($_POST['talla']);}
    else {
    $talla = "";} 
    

$fecha_actual = date("Y-m-d H:i:s");

 $area = "HOSPITALIZACIÓN";
 $fecha_actual3 = date("Y-m-d H:i:s");
 $fecha_actual2 = date("Y-m-d");
 $fecha_actual4 = date("H");
 
 $ingresar = mysqli_query($conexion, 'INSERT INTO signos_vitales (id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,tipo,fecha_registro,hora) values (' . $id_atencion . ' , ' . $id_usu . ' ,"'.$fecha_actual2.'", " ' . $p_sistolica . '" , "' . $p_diastolica . '" , "' .$f_card . '" , "' . $f_resp . '" , "' . $temp . ' ", "' . $sat_oxigeno . ' ", "' . $area . ' ","'.$fecha_actual3.'","'.$fecha_actual4.'") ') or die('<p>Error al registrar Signos Vitales</p><br>' . mysqli_error($conexion));


    $ingresar = mysqli_query($conexion, 'insert into  dat_hclinica 
        (Id_exp,
        fec_hc,
        tip_hc,
        hc_her_o,
        hc_otro,
        hc_pato,
        hc_ges,
        hc_par,
        hc_ces,
        hc_abo,
        hc_fechafur,
        hc_pade,
        p_sistolica,
        p_diastolica,
        f_card,
        f_resp,
        temp,
        sat_oxigeno,
        peso,
        talla,
        hc_lab,
        hc_gabi,
        hc_res_o,
        id_cie_10,
        hc_te,
        hc_ta,
        hc_vid,
        hc_def,
        id_usua,
        hc_men,
        hc_ritmo,
        hc_desc_hom,
        diag_prev,
        cardio,
        habitus,
        des_diag,
        guia) values ( 
        ' . $id_exp . ',
        "' . $fecha_actual . '" ,
        "' . $tip_hc . '" ,
        "' . $hc_her_o . '" ,
        "' . $hc_otro . '", 
        "' . $hc_pato . '", 
        "' . $hc_ges . '", 
        "' . $hc_par . '" , 
        "' . $hc_ces . '" ,
        "' . $hc_abo . '",
        "' . $hc_fechafur . '" , 
        "' . $hc_pade . '" ,
        "' . $p_sistolica . '" , 
        "' . $p_diastolica . '" , 
        "' . $f_card . '" , 
        "' . $f_resp . '" , 
        "' . $temp . '" , 
        "' . $sat_oxigeno . '" , 
        ' . $peso . ' , 
        ' . $talla . ' , 
        "' . $hc_lab . '" ,
        "' . $hc_gabi . '", 
        "' . $hc_res_o . '" , 
        "' . $diagprob_i . '" , 
        "' . $hc_te . '" ,
        "' . $hc_ta . '" , 
        "' . $hc_vid . '" ,
        "' . $hc_def . '" ,
        ' . $id_usu . ',
        "' . $hc_men . '", 
        "' . $hc_ritmo . '", 
        "' . $hc_desc_hom . '",
        "' . $diag_prev . '", 
        "' . $cardio . '", 
        "' . $habitus . '",
        "' . $des_diag . '",
        "' . $guia . '") ') or die('<p>Error al registrar Hclinica</p><br>' . mysqli_error($conexion));
    
    $sql2 = "UPDATE paciente SET ocup ='$ocupa', tip_san ='$tip_san', h_clinica = 'SI'  WHERE Id_exp= $id_exp";
    $result = $conexion->query($sql2);

    //redirección
    header('location: ../hospitalizacion/vista_pac_hosp.php');

