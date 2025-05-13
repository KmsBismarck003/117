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
    $guia=($_POST['guia']);
    //$tip_ev = ($_POST['tip_ev']);
    $edosalud = ($_POST['edosalud']);
     $diagprob_i = ($_POST['diagprob_i']);

    
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

$ingresar = mysqli_query($conexion, 'INSERT INTO dat_nevol (fecha_nu,id_atencion,problema,subjetivo,objetivo,analisis,plan,px,guia,edosalud,id_usua,diagprob_i) values (" ' . $fecha_actual . ' ",' . $id_atencion . '," ' . $problema . '" ," ' . $subjetivo . '" , "' . $objetivo . '" , "' . $analisis . '" , "' . $plan . '" , "' . $px . ' ", "' . $guia . ' ", "' . $edosalud . ' " ,' . $id_usua . ',"' . $diagprob_i . ' ") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

//diagnosticos tabla

$diag="SELECT * FROM dat_ingreso where id_atencion=$id_atencion";
$result=$conexion->query($diag);
while ($row=$result->fetch_assoc()) {
  $motivo_atn=$row['motivo_atn'];
}

if ($diagprob_i !== $motivo_atn) {
     $diag=mysqli_query($conexion,'insert into diag_pac(Id_exp,id_usua,diag_paciente,fecha) values ('.$id_atencion.','.$id_usua.',"'.$diagprob_i.'","'.$fecha_actual.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));
}

$sql2 = "UPDATE dat_ingreso SET edo_salud ='$edosalud', motivo_atn = '$diagprob_i' WHERE id_atencion = $id_atencion";
      $result = $conexion->query($sql2);

    //redirección
    header('location: ../hospitalizacion/vista_pac_hosp.php');
 //si no se enviaron datos


