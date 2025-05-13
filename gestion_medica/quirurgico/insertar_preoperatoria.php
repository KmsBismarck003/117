<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];


$fecha_actual = date("Y-m-d H:i:s");

if (isset($_POST['tipo_cirugia_preop'])) {
	if($tipo_cirugia_preop="URGENCIA"){
$tipo_cirugia_preop= $_POST['tipo_cirugia_preop'];
	}

	if($tipo_cirugia_preop="ELECTIVA"){
$tipo_cirugia_preop= $_POST['tipo_cirugia_preop'];
	}

}

//$cama_preop=$_POST['cama_preop'];
$ta_sist=$_POST['ta_sist'];
$ta_diast=$_POST['ta_diast'];
$frec_card=$_POST['frec_card'];
$frec_resp=$_POST['frec_resp'];
$sat_oxi=$_POST['sat_oxi'];
$preop_temp=$_POST['preop_temp'];
$preop_peso=$_POST['preop_peso'];
$preop_talla=$_POST['preop_talla'];
$cabeza=$_POST['cabeza'];
$cuello=$_POST['cuello'];

$torax=$_POST['torax'];
$abdomen=$_POST['abdomen'];
$extrem=$_POST['extrem'];
$colum_vert=$_POST['colum_vert'];

$resumen_clin=$_POST['resumen_clin'];
$beneficios=$_POST['beneficios'];
$result_lab_gab=$_POST['result_lab_gab'];
$diag_preop=$_POST['diag_preop'];
$pronostico=$_POST['pronostico'];
$riesgos=$_POST['riesgos'];
$cuidados=$_POST['cuidados'];
$tipo_inter_plan=$_POST['tipo_inter_plan'];
$fecha_cir=$_POST['fecha_cir'];
$fecha_end=$_POST['fecha_end'];
//$hora_cir=$_POST['hora_cir'];
$tiempo_estimado=$_POST['tiempo_estimado'];
$nom_medi_cir=$_POST['nom_medi_cir'];
$anestesia_sug=$_POST['anestesia_sug'];
$sangrado_esp=$_POST['sangrado_esp'];
$observ=$_POST['observ'];

$hb=$_POST['hb'];
$ht=$_POST['ht'];
//sangre
  $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias, p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";
      $result_pac = $conexion->query($sql_pac);
      while ($row_pac = $result_pac->fetch_assoc()) {
        $rh = $row_pac['tip_san'];
      }
$d_postoperatorio=$_POST['d_postoperatorio'];
$res_pro=$_POST['res_pro'];
$material=$_POST['material'];
$oper_real=$_POST['oper_real'];
$incidentes=$_POST['incidentes'];
$est_transo=$_POST['est_transo'];
//$complicaciones=$_POST['complicaciones'];
//$pieza_quir=$_POST['pieza_quir'];
//$primer_a=$_POST['primer_a'];
//$segundo_a=$_POST['segundo_a'];
//$anestesiologo=$_POST['anestesiologo'];
//$fecha_preop=$_POST['fecha_preop'];
//$guia=$_POST['guia'];

$resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_sig DESC LIMIT 1") or die($conexion->error);
     while ($f5 = mysqli_fetch_array($resultado5)) {
    $p_sistol=$f5['p_sistol'];
    $p_diastol=$f5['p_diastol'];
    $fcard=$f5['fcard'];
    $fresp=$f5['fresp'];
    $temper=$f5['temper'];
    $satoxi=$f5['satoxi'];
    $peso=$f5['peso'];
    $talla=$f5['talla'];
    }


//insert a agenda

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias, p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

      $result_pac = $conexion->query($sql_pac);

      while ($row_pac = $result_pac->fetch_assoc()) {
        $pac_papell = $row_pac['papell'];
        $pac_sapell = $row_pac['sapell'];
        $pac_nom_pac = $row_pac['nom_pac'];
        
      }

$nompac=$pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac;

// Conversión a UTF8 para que se visualice en FULLCALENDAR
$nom_paciente = utf8_encode($nompac);
$nom_medico = utf8_encode($nom_medi_cir);
$materiales = utf8_encode($material);
$cirugia = utf8_encode($tipo_inter_plan);


/*if($tiempo_estimado==0){
    $fecha_cir;
$NuevaFecha = strtotime ('+0 hour' , strtotime ($fecha_cir) ) ; 
$NuevaFecha = strtotime ( '+59 minute' , $NuevaFecha ) ; 
$NuevaFecha = strtotime ( '+00 second' , $NuevaFecha ) ; 
$NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 
echo $NuevaFecha;
}else if($tiempo_estimado==1){
    $fecha_cir;
$NuevaFecha = strtotime ('+1 hour' , strtotime ($fecha_cir) ) ; 
$NuevaFecha = strtotime ( '+59 minute' , $NuevaFecha ) ; 
$NuevaFecha = strtotime ( '+00 second' , $NuevaFecha ) ; 
$NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 
echo $NuevaFecha;
}*/

if($fecha_cir==$fecha_end){
    header('location: nota_preoperatoria.php?error=Fechasiguales');
}else{

$result=mysqli_query($conexion,'INSERT INTO dat_not_preop (id_atencion,id_usua,tipo_cirugia_preop,ta_sist,ta_diast,frec_card,frec_resp,sat_oxi,preop_temp,preop_peso,preop_talla,cabeza,cuello,torax,abdomen,extrem,colum_vert,observ,diag_preop,fecha_cir,tipo_inter_plan,beneficios,riesgos,cuidados,d_postoperatorio,material,est_transo,fecha_preop) 
	VALUES('.$id_atencion.','.$id_usua.',"'.$tipo_cirugia_preop.'","'.$p_sistol.'","'.$p_diastol.'","'.$fcard.'","'.$fresp.'","'.$satoxi.'","'.$temper.'","'.$peso.'","'.$talla.'","'.$cabeza.'","'.$cuello.'","'.$torax.'","'.$abdomen.'","'.$extrem.'","'.$colum_vert.'","'.$observ.'","'.$diag_preop.'","'.$fecha_cir.'","'.$tipo_inter_plan.'","'.$beneficios.'","'.$riesgos.'","'.$cuidados.'","'.$d_postoperatorio.'","'.$material.'","'.$est_transo.'","'.$fecha_actual.'")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

$sql_agenda=mysqli_query($conexion,'INSERT INTO agenda (title,descripcion,color,textColor,start,end,tipo,medico,duracion,estatus)
  VALUES("'.$nom_paciente.'","'.$materiales.'","#B01405","#FFFFFF","'.$fecha_cir.'","'.$fecha_end.'","'.$cirugia.'","'.$nom_medico.'","'.$tiempo_estimado.'","en preparacion")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
header('location: ../hospitalizacion/vista_pac_hosp.php');
}

?>