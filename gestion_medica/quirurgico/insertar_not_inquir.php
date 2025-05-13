<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['hospital'];

if (isset($_POST['tipo_intervencion'])) {
	if($tipo_intervencion="URGENCIAS"){
$tipo_intervencion= $_POST['tipo_intervencion'];
	}

	if($tipo_intervencion="ELECTIVA"){
$tipo_intervencion= $_POST['tipo_intervencion'];
	}

}

$quirofano=$_POST['quirofano'];
$reserva=$_POST['reserva'];
$local=$_POST['local'];
$regional=$_POST['regional'];
$general=$_POST['general'];

$inst_necesario=$_POST['inst_necesario'];
$medmat_necesario=$_POST['medmat_necesario'];

$intervencion_quir=$_POST['intervencion_quir'];
$inicio=$_POST['inicio'];
$termino=$_POST['termino'];
$diag_postop=$_POST['diag_postop'];
$cir_realizada=$_POST['cir_realizada'];
$trans=$_POST['trans'];
$posto=$_POST['posto'];
$perd_hema=$_POST['perd_hema'];

$accident_incident=$_POST['accident_incident'];
$anestesia_admin=$_POST['anestesia_admin'];
$anestesia_dur=$_POST['anestesia_dur'];
$realizada_por	=$_POST['realizada_por'];
$cirujano=$_POST['cirujano'];
$prim_ayudante=$_POST['prim_ayudante'];
$seg_ayudante=$_POST['seg_ayudante'];
$ter_ayudante=$_POST['ter_ayudante'];
$anestesiologo=$_POST['anestesiologo'];

$circulante=$_POST['circulante'];
$instrumentista=$_POST['instrumentista'];
$quir=$_POST['quir'];
$hora_llegada_quir=$_POST['hora_llegada_quir'];
$hora_salida_quir=$_POST['hora_salida_quir'];
$tiempo_qx = "";
$hora_entrada_recup=$_POST['hora_entrada_recup'];
$hora_salida_recup=$_POST['hora_salida_recup'];
$nota_preop=$_POST['nota_preop'];

if(isset($_POST['estado_postop'])){
   if($estado_postop="BUENO"){
       $estado_postop=$_POST['estado_postop'];
   }
   
   if($estado_postop="DELICADO"){
       $estado_postop=$_POST['estado_postop'];
   }

   if($estado_postop="GRAVE"){
       $estado_postop=$_POST['estado_postop'];
   }

   if($estado_postop="MUY GRAVE"){
       $estado_postop=$_POST['estado_postop'];
   }


}

$estado_postop=$_POST['estado_postop'];
$comentario_final=$_POST['comentario_final'];
$plan_ter=$_POST['plan_tera'];

$descripcion_op=$_POST['descripcion_op'];
$nombre_med_cir=$_POST['nombre_med_cir'];
$guia=$_POST['guia'];
$cirrealizada=$_POST['cirrealizada'];


$resultado1 = $conexion->query("select paciente.*, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=id_atencion" ) or die($conexion->error);
   while ($f1 = mysqli_fetch_array($resultado1)) {
   	$tipo_sangre=$f1['tip_san'];
   }

$fecha_actual = date("Y-m-d ");

$hora_actual = date("H:i:s");

$resultado4i=$conexion->query("SELECT * from cat_diag WHERE id_diag='$diag_postop'") or die($conexion->error);
    while ($fd = mysqli_fetch_array($resultado4i)) {
        $id_inegi=$fd["id_inegi"];
        $diag_eg =$fd["diagnostico"];
    }


$result=mysqli_query($conexion,'INSERT INTO dat_not_inquir (id_atencion,id_usua,tipo_intervencion,fecha,hora_solicitud,diag_preop,quirofano,reserva,local,regional,general,tipo_sangre,inst_necesario,medmat_necesario,jefe_cirugia,intervencion_quir,inicio,termino,diag_postop,cir_realizada,trans,posto,perd_hema,accident_incident,anestesia_admin,anestesia_dur,realizada_por,cirujano,prim_ayudante,seg_ayudante,ter_ayudante,anestesiologo,circulante,instrumentista,quir,hora_llegada_quir,hora_salida_quir,hora_entrada_recup,hora_salida_recup,nota_preop,estado_postop,comentario_final,plan_ter,descripcion_op,nombre_med_cir,guia,cirrealizada,id_inegi) 
    VALUES('.$id_atencion.','.$id_usua.',"'.$tipo_intervencion.'","'.$fecha_actual.'","'.$hora_actual.'","'.$diag_preop.'","'.$quirofano.'","'.$reserva.'","'.$local.'","'.$regional.'","'.$general.'","'.$tipo_sangre.'","'.$inst_necesario.'","'.$medmat_necesario.'","'.$jefe_cirugia.'","'.$intervencion_quir.'","'.$inicio.'","'.$termino.'","'.$diag_eg.'","'.$cir_realizada.'","'.$trans.'","'.$posto.'","'.$perd_hema.'","'.$accident_incident.'","'.$anestesia_admin.'","'.$anestesia_dur.'","'.$realizada_por.'","'.$cirujano.'","'.$prim_ayudante.'","'.$seg_ayudante.'","'.$ter_ayudante.'","'.$anestesiologo.'","'.$circulante.'","'.$instrumentista.'","'.$quir.'","'.$hora_llegada_quir.'","'.$hora_salida_quir.'","'.$hora_entrada_recup.'","'.$hora_salida_recup.'","'.$nota_preop.'","'.$estado_postop.'","'.$comentario_final.'","'.$plan_ter.'","'.$descripcion_op.'","'.$nombre_med_cir.'","'.$guia.'","'.$cirrealizada.'","'.$id_inegi.'")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));



$resultado_pre = $conexion->query("SELECT * from dat_not_preop WHERE id_atencion=$id_atencion order by id_not_preop DESC LIMIT 1") or die($conexion->error);

while ($pre = mysqli_fetch_array($resultado_pre)) {
        $id_not_preop=$pre['id_not_preop'];
     }

if (!isset($id_not_preop)) {

$resultado1 = $conexion ->query("SELECT TIMESTAMPDIFF(MINUTE,hora_llegada_quir,hora_salida_quir) as MINUTEs FROM `dat_not_inquir` WHERE id_atencion=$id_atencion order by id_not_inquir desc limit 1")or die($conexion->error);
  
  if(mysqli_num_rows($resultado1) > 0 ){ //se mostrara si existe mas de 1
    $fila=mysqli_fetch_row($resultado1);
     $resultado=$fila[0];
  }
$res=$resultado/60;
$decimales=explode(".", $res);

if(isset($decimales[1])){

  if($decimales[1] >= 0){
  $horas=$decimales[0]+1;
  //echo "<br>el resultado final es:".$horas."horas";
  }
}else{
      if($res%2 <= 0)
  
  $decimales[0];
   $horas=$decimales[0];
   // echo "<br> el resultado es exacto:".$horas."horas";
}
    
$diag_preop=$_POST['diag_preop'];
$pronostico=$_POST['pronostico'];
$riesgos=$_POST['riesgos'];
$cuidados=$_POST['cuidados'];
$tipo_inter_plan=$_POST['tipo_inter_plan'];
$observ=$_POST['observ'];

$result=mysqli_query($conexion,'INSERT INTO dat_not_preop (id_atencion,id_usua,tipo_cirugia_preop,observ,diag_preop,fecha_cir,hora_cir,tipo_inter_plan,riesgos,cuidados,pronostico,anestesia_sug,nom_medi_cir,tiempo_estimado,sangrado_esp,fecha_preop) 
    VALUES('.$id_atencion.','.$id_usua.',"'.$tipo_intervencion.'","'.$observ.'","'.$diag_preop.'","'.$fecha_actual.'","'.$hora_actual.'","'.$tipo_inter_plan.'","'.$riesgos.'","'.$cuidados.'","'.$pronostico.'","'.$anestesia_dur.'","'.$cirujano.'",'.$horas.',"'.$perd_hema.'","'.$fecha_actual.'")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

}
/////FIN DE LA INSERCION A PREOPERATORIA Y FIN DE LA VALIDACION DE LAS HORAS 

/*   $resultado1 = $conexion ->query("SELECT TIMESTAMPDIFF(MINUTE,hora_llegada_quir,hora_salida_quir) as MINUTEs FROM `dat_not_inquir` WHERE id_atencion=$id_atencion order by id_not_inquir desc limit 1")or die($conexion->error);
  
  if(mysqli_num_rows($resultado1) > 0 ){ //se mostrara si existe mas de 1
    $fila=mysqli_fetch_row($resultado1);
     $resultado=$fila[0];
  }
$res=$resultado/60;
$decimales=explode(".", $res);

if(isset($decimales[1])){

  if($decimales[1] >= 0){
  $horas=$decimales[0]+1;
  //echo "<br>el resultado final es:".$horas."horas";
  }
}else{
      if($res%2 <= 0)
  
  $decimales[0];
   $horas=$decimales[0];
   // echo "<br> el resultado es exacto:".$horas."horas";
}


$fecha_act = date("Y-m-d H:i:s");
 if($quir=='SALA 1' || $quir=='SALA 2' || $quir=='SALA 3' || $quir=='SALA 4'){ 
   $ingresar2=mysqli_query($conexion,'insert into dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,id_usua) values ('.$id_atencion.',"S","5","'.$fecha_act.'",'.$horas.','.$id_usua.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

 }
  if($quir=='SALA DE PARTO'){
   $ingresar3=mysqli_query($conexion,'insert into dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,id_usua) values ('.$id_atencion.',"S","6","'.$fecha_act.'",'.$horas.','.$id_usua.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

 }*/

header('location: ../hospitalizacion/vista_pac_hosp.php');


?>