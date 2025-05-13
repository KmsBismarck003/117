<?php
//se establece una conexion a la base de datos
include '../../conexionbd.php';
//si se han enviado datos
$id_usua = $_GET['id_usua'];
$id_atencion = $_GET['id_atencion'];


if(isset($_POST['adic_cu'])){
    $adic_cu = $_POST['adic_cu'];
  }else{
    $adic_cu = "";
  }

  if(isset($_POST['tab_cu'])){
    $tab_cu = $_POST['tab_cu'];
  }else{
    $tab_cu = "";
  }

  if(isset($_POST['alco_cu'])){
    $alco_cu = $_POST['alco_cu'];
  }else{
    $alco_cu = "";
  }

  if(isset($_POST['otro_cu'])){
    $otro_cu = $_POST['otro_cu'];
  }else{
    $otro_cu = "";
  }

if(isset($_POST['quir_cu'])){
    $quir_cu = $_POST['quir_cu'];
}else{
    $quir_cu = "";
}

if(isset($_POST['aler_cu'])){
    $aler_cu = $_POST['aler_cu'];
}else{
    $aler_cu = "";
}

if(isset($_POST['trau_cu'])){
    $trau_cu = $_POST['trau_cu'];
}else{
        $trau_cu = "";
}

if(isset($_POST['trans_cu'])){
    $trans_cu = $_POST['trans_cu'];
}else{
        $trans_cu = "";
    }

    if(isset($_POST['diab_pa'])){
    $diab_pa = $_POST['diab_pa'];
}else{
        $diab_pa = "";
    }

    if(isset($_POST['diab_ma'])){
    $diab_ma = $_POST['diab_ma'];
}else{
        $diab_ma = "";
    }

    if(isset($_POST['diab_ab'])){
    $diab_ab = $_POST['diab_ab'];
}else{
        $diab_ab = "";
    }

 if(isset($_POST['hip_pa'])){
    $hip_pa = $_POST['hip_pa'];
}else{
        $hip_pa = "";
    }

 if(isset($_POST['hip_ma'])){
    $hip_ma = $_POST['hip_ma'];
}else{
        $hip_ma = "";
    }

     if(isset($_POST['hip_ab'])){
    $hip_ab = $_POST['hip_ab'];
}else{
        $hip_ab = "";
    }

    if(isset($_POST['can_pa'])){
    $can_pa = $_POST['can_pa'];
}else{
        $can_pa = "";
    }
    if(isset($_POST['can_ma'])){
    $can_ma = $_POST['can_ma'];
}else{
        $can_ma = "";
    }
   
    if(isset($_POST['can_ab'])){
    $can_ab = $_POST['can_ab'];
}else{
        $can_ab = "";
    }

        if(isset($_POST['hc_desc_hom'])){
    $hc_desc_hom = $_POST['hc_desc_hom'];
}else{
        $hc_desc_hom = "";
    }

    //$Id_exp = ($_POST['Id_exp']);
    //  $fec_hc = ($_POST['fec_hc']);
    $diab_pa = ($_POST['diab_pa']);
       $diab_ma = ($_POST['diab_ma']);
          $diab_ab = ($_POST['diab_ab']);

  $hip_pa = ($_POST['hip_pa']);
       $hip_ma = ($_POST['hip_ma']);
          $hip_ab = ($_POST['hip_ab']);

$can_pa = ($_POST['can_pa']);
       $can_ma = ($_POST['can_ma']);
          $can_ab = ($_POST['can_ab']);

    $motcon_cu = ($_POST['motcon_cu']);
    $trau_cu = ($_POST['trau_cu']);
    $trans_cu = ($_POST['trans_cu']);
        $aler_cu = ($_POST['aler_cu']);
    $adic_cu = ($_POST['adic_cu']);
    $quir_cu = ($_POST['quir_cu']);
    $pad_cu = ($_POST['pad_cu']);
    $exp_cu = ($_POST['exp_cu']);
    $diag_cu = ($_POST['diag_cu']);
    $diag2 = ($_POST['diag2']);

$hc_men = ($_POST['hc_men']);
$hc_ritmo = ($_POST['hc_ritmo']);
$gestas_cu = ($_POST['gestas_cu']);
$partos_cu = ($_POST['partos_cu']);
$ces_cu = ($_POST['ces_cu']);
$abo_cu = ($_POST['abo_cu']);
$fecha_fur = ($_POST['fecha_fur']);
   
    $proc_cu = ($_POST['proc_cu']);
    $med_cu = ($_POST['med_cu']);
    $anproc_cu = ($_POST['anproc_cu']);
    $trat_cu = ($_POST['trat_cu']);
    $do_cu = ($_POST['do_cu']);
    $dis_cu = ($_POST['dis_cu']);
    $dest_cu = ($_POST['dest_cu']);
    $despatol = ($_POST['despatol']);

    //tabla de solicitud_interv
    //$tipo_intervenciony = ($_POST['tipo_intervenciony']);
    //$fechay = ($_POST['fechay']);
    //$hora_solicitudy = ($_POST['hora_solicitudy']);
  /*  $intervencion_soly = ($_POST['intervencion_soly']);
    $diag_preopy = ($_POST['diag_preopy']);
  //  $cirugia_progy = ($_POST['cirugia_progy']);
    $quirofanoy = ($_POST['quirofanoy']);
    $reservay = ($_POST['reservay']);

    $localy = ($_POST['localy']);
    $regionaly = ($_POST['regionaly']);
    $generaly = ($_POST['generaly']);
    //$hby = ($_POST['hby']);
    //$htoy = ($_POST['htoy']);
    //$pesoy = ($_POST['pesoy']);
    $inst_necesarioy = ($_POST['inst_necesarioy']);

 $medmat_necesarioy = ($_POST['medmat_necesarioy']);
    $nom_jefe_servy = ($_POST['nom_jefe_servy']);
    //$fecha_progray = ($_POST['fecha_progray']);
    //$hora_progray = ($_POST['hora_progray']);
    //$salay = ($_POST['salay']);

    //$intervencion_quiry = ($_POST['intervencion_quiry']);
    //$inicioy = ($_POST['inicioy']);
    //$terminoy = ($_POST['terminoy']);*/

    $resultado1 = $conexion->query("select paciente.*, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=id_atencion" ) or die($conexion->error);
   while ($f1 = mysqli_fetch_array($resultado1)) {
    $tipo_sangrey=$f1['tip_san'];
   }
  
$fecha_actual = date("Y-m-d H:i:s");
$ingresar = mysqli_query($conexion, 'INSERT INTO dat_c_urgen (id_atencion,diab_pa,diab_ma,diab_ab,hip_pa,hip_ma,hip_ab,can_pa,can_ma,can_ab,motcon_cu,trau_cu,trans_cu,adic_cu,tab_cu,alco_cu,otro_cu,quir_cu,aler_cu,pad_cu,exp_cu,diag_cu,hc_men,hc_ritmo,gestas_cu,partos_cu,ces_cu,abo_cu,fecha_fur,hc_desc_hom,proc_cu,med_cu,anproc_cu,trat_cu,do_cu,dis_cu,dest_cu,fecha_urgen,id_usua,despatol) values (' . $id_atencion . ' ," ' . $diab_pa . '" ," ' . $diab_ma . '" ," ' . $diab_ab . '" ," ' . $hip_pa . '" ," ' . $hip_ma . '" ," ' . $hip_ab . '" , "' . $can_pa . '" ,"' . $can_ma . '" ,"' . $can_ab . '" ,"' . $motcon_cu . '", "' . $trau_cu  . '" , "' . $trans_cu . '" , "' . $adic_cu . ' " ,"' . $tab_cu . ' ","' . $alco_cu . ' ","' . $otro_cu . ' ", "' . $quir_cu . ' " ,"' . $aler_cu . ' ", "' . $pad_cu . ' " , "' . $exp_cu . ' " , "' . $diag_cu . ' ", "' . $hc_men . ' " , "' . $hc_ritmo . ' ","' . $gestas_cu . ' ","' . $partos_cu . ' ","' . $ces_cu . ' ","' . $abo_cu . ' ","' . $fecha_fur . ' ","' . $hc_desc_hom . ' ", "' . $proc_cu . ' ","' . $med_cu . ' " , "' . $anproc_cu . ' " , "' . $trat_cu . ' " , "' . $do_cu . ' " , "' . $dis_cu . ' ", "' . $dest_cu . ' ","' . $fecha_actual . ' ", ' . $id_usua . ',"' . $despatol . '" ) ')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

//diagnosticos tabla
   $diag=mysqli_query($conexion,'insert into diag_pac(Id_exp,id_usua,diag_paciente,fecha) values ('.$id_atencion.','.$id_usua.',"'.$diag_cu.'","'.$fecha_actual.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

/*if($dest_cu=="QUIROFANO"){
$ingresarsol = mysqli_query($conexion, 'INSERT INTO solicitud_interv_quir (id_atencion,id_usua,tipo_intervenciony,diag_preopy,quirofanoy,reservay,localy,regionaly,generaly,tipo_sangrey,inst_necesarioy,medmat_necesarioy,nom_jefe_servy) values (' . $id_atencion . ' , ' . $id_usua . ' ," ' . $tipo_intervenciony . '"  , "' . $diag_preopy . '" ,"' . $quirofanoy . ' ","' . $reservay . '","' . $localy . '","' . $regionaly . '","' . $generaly . '","' . $tipo_sangrey . '","' . $inst_necesarioy . '","' . $medmat_necesarioy . '","' . $nom_jefe_servy . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
}*/


 $fecha_actual = date("Y-m-d");


 $hora_actual = date("H:i:s");

/*if($dest_cu="EGRESO DE URGENCIAS"){
$sql2 = "UPDATE dat_ingreso SET alta_med = 'SI', fecha_alt_med = '".$fecha_actual."', hora_alt_med = '".$hora_actual."'WHERE id_atencion = $id_atencion";
      $result = $conexion->query($sql2);
}*/
    //redirección
    header('location: consulta_urgencias.php');
 //si no se enviaron datos


