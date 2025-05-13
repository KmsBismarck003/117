<?php
//se establece una conexion a la base de datos
include '../../conexionbd.php';
//si se han enviado datos
$id_usua = $_GET['id_usua'];
$id_atencion = $_GET['id_atencion'];


$fecha_actual = date("Y-m-d H:i:s");

    //$Id_exp = ($_POST['Id_exp']);
    //  $fec_hc = ($_POST['fec_hc']);
    $problemach = ($_POST['problemach']);
    $subjetivoch = ($_POST['subjetivoch']);
    $objetivoch = ($_POST['objetivoch']);
    $analisisch = ($_POST['analisisch']);
    $planch = ($_POST['planch']);
    $pxch = ($_POST['pxch']);
    $tip_ech = ($_POST['tip_ech']);
     $dest_cu_choque = ($_POST['dest_cu_choque']);

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

      $resultado1 = $conexion->query("select paciente.*, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=id_atencion" ) or die($conexion->error);
   while ($f1 = mysqli_fetch_array($resultado1)) {
    $tipo_sangrey=$f1['tip_san'];
   }

$ingresar = mysqli_query($conexion, 'INSERT INTO dat_choque (fecha_ch,id_atencion,tip_ech,problemach,subjetivoch,objetivoch,analisisch,planch,pxch,dest_cu_choque,id_usua) values ( "' . $fecha_actual . '" ,' . $id_atencion . ' ," ' . $tip_ech . '" ," ' . $problemach . '" ," ' . $subjetivoch . '" , "' . $objetivoch . '" , "' . $analisisch . '" , "' . $planch . '" , "' . $pxch . ' ","' . $dest_cu_choque . ' ",' . $id_usua . ') ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

$ingresar=mysqli_query($conexion,'UPDATE dat_ingreso SET area = "'.$dest_cu_choque.'" WHERE id_atencion = "'.$id_atencion.'" ');


if($dest_cu_choque="QUIROFANO"){
$ingresarsol = mysqli_query($conexion, 'INSERT INTO solicitud_interv_quir (id_atencion,id_usua,tipo_intervenciony,fechay,hora_solicitudy,intervencion_soly,diag_preopy,cirugia_progy,quirofanoy,reservay,localy,regionaly,generaly,hby,htoy,pesoy,tipo_sangrey,inst_necesarioy,medmat_necesarioy,nom_jefe_servy,fecha_progray,hora_progray,salay,intervencion_quiry,inicioy,terminoy) values (' . $id_atencion . ' , ' . $id_usua . ' ," ' . $tipo_intervenciony . '" ," ' . $fechay . '" , "' . $hora_solicitudy . '" , "' . $intervencion_soly . '" , "' . $diag_preopy . '" , "' . $cirugia_progy . ' ","' . $quirofanoy . ' ","' . $reservay . '","' . $localy . '","' . $regionaly . '","' . $generaly . '","' . $hby . '", " ' . $htoy . ' ","' . $pesoy . '","' . $tipo_sangrey . '","' . $inst_necesarioy . '","' . $medmat_necesarioy . '","' . $nom_jefe_servy . '","' . $fecha_progray . '","' . $hora_progray . '","' . $salay . '","' . $intervencion_quiry . '","' . $inicioy . '","' . $terminoy . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
}


    //redirección

/*if($dest_cu_choque="EGRESO DE URGENCIAS"){
$sql2 = "UPDATE cat_camas SET estatus = 'LIBRE', id_atencion= '0' WHERE id_atencion = $id_atencion";
      $result = $conexion->query($sql2);
}*/

    
    header('location: choque.php');
 //si no se enviaron datos


