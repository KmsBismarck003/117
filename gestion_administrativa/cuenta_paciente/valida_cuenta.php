<?php
include "../../conexionbd.php";
if(@$_GET['q'] == 'cerrar'){
$id_atencion = $_GET['id_atencion'];
$id_usua = $_GET['id_usua'];
$diferencia = $_GET['dif'];
$total = $_GET['total'];
$totalsiva = $_GET['totalsiva'];

$fecha_actual = date("Y-m-d H:i:s");

$resultado1 = $conexion->query("SELECT * from cat_camas WHERE id_atencion=$id_atencion") or die($conexion->error);
  while ($f = $resultado1->fetch_assoc()) {
    $num_cama=$f['num_cama'];
    $tipo=$f['tipo'];
}

$resultadoe = $conexion->query("SELECT * from dat_ingreso WHERE id_atencion=$id_atencion") or die($conexion->error);
  while ($fe = $resultadoe->fetch_assoc()) {
$motivo_alta=$fe['motivo_alta'];
$area = $fe['area'];
}

// SE BUSCA LA ASEGURADORA PARA SABER EL NIVEL DEL PRECIO QUE LE CORRESPONDE, SOLO APLICA PARA SERVICIOS
$sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
  $result_aseg = $conexion->query($sql_aseg);
  while ($row_aseg = $result_aseg->fetch_assoc()) {
       $at=$row_aseg['aseg'];
  }
  $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
  while($filat = mysqli_fetch_array($resultadot)){ 
    $tr=$filat["tip_precio"];
  }
// TERMINA BUSCAR NIVEL DE PRECIO

$sql = 'UPDATE dat_ingreso set  activo="NO",cama=0, cama_alta=' . $num_cama . ', alta_adm="SI", fec_egreso ="' . $fecha_actual . '", fecha_cama ="0000-00-00 00:00:00", cajero =' . $id_usua . ' where id_atencion = ' . $id_atencion . ';';
$result = $conexion->query($sql);

$sql_camas = "UPDATE cat_camas SET estatus = 'LIBRE', id_atencion = 0, motivo = '$motivo_alta'  WHERE id_atencion = $id_atencion ";
$result_camas = $conexion->query($sql_camas);

/**************** AQUI INICIA LA GESTION DE CAMAS PARA SERVICIOS GENERALES, BIOMEDICA Y MANTENIMIENTO ***************/
/*
 $sql_camas = "UPDATE cat_camas SET estatus = 'LIBRE', id_atencion = 0, motivo = '$motivo_alta'  WHERE id_atencion = $id_atencion ";
    $result_camas = $conexion->query($sql_camas);

if ($area == 'CONSULTA' || $area == 'ALTA' || $area == 'ENDOSCOPÍA') {
    $sql_camas = "UPDATE cat_camas SET estatus = 'LIBRE', id_atencion = 0 WHERE id_atencion = $id_atencion";
    $result_camas = $conexion->query($sql_camas);
    
}
elseif  ($area != 'CONSULTA' || $area != 'ALTA' and $area != 'ENDOSCOPÍA')
{
    $fecha_actual4 = date("Y-m-d H:i:s");
    $fecha_actual5 = date("Y-m-d H:i:s");

    $sql_camas = "UPDATE cat_camas SET estatus = 'EN PROCESO DE LIBERACIÓN', id_atencion = 0, motivo = '$motivo_alta' ,mantenimiento='No liberada',biomedica='No liberada',serv_generales='No liberada' WHERE id_atencion = $id_atencion and tipo != 'CONSULTA'";
    $result_camas = $conexion->query($sql_camas);

    $sql_servge = "INSERT INTO servicios_generales(fecha,cama,seguropac,realizado,fecha_egreso)VALUES('$fecha_actual4',$num_cama,'No','No','$fecha_actual5')";
    $result_genser = $conexion->query($sql_servge);

    $sql_mant = "INSERT INTO mantenimiento(fecha,cama,seguropac,realizado,fecha_egreso)VALUES('$fecha_actual4',$num_cama,'No','No','$fecha_actual5')";
    $result_iento = $conexion->query($sql_mant);

    $sql_bio = "INSERT INTO biomedica(fecha,cama,seguropac,realizado,fecha_egreso)VALUES('$fecha_actual4',$num_cama,'No','No','$fecha_actual5')";
     $result_bioo = $conexion->query($sql_bio);
// TERMINA GESTION DE CAMAS

$result_camas = $conexion->query($sql_camas);
}
*/

$resultado = $conexion->query("SELECT * from dat_financieros WHERE id_atencion=$id_atencion") or die($conexion->error);
  while ($f = mysqli_fetch_array($resultado)) {
$banco=$f['banco'];
$depcoas=$f['deposito'];
}

if ($diferencia == 0 and $banco=="COASEGURO") {
   $depcoas;
  
$fecha_actual = date("Y-m-d H:i:s");
  $sql_cta_cerrada = "INSERT INTO cta_pagada(id_atencion,diferencia,total,coaseguro, t_pago, fecha_cierre,id_usua,cta_cerrada)VALUES($id_atencion,$diferencia,$total,'$depcoas','NINGUNO','$fecha_actual',$id_usua,'SI')";
  $result_cta_cerrada = $conexion->query($sql_cta_cerrada);
}elseif($diferencia == 0 and $banco!="COASEGURO"){
  
$fecha_actual = date("Y-m-d H:i:s");
  $sql_cta_cerrada = "INSERT INTO cta_pagada(id_atencion,diferencia,total,t_pago, fecha_cierre,id_usua,cta_cerrada)VALUES($id_atencion,$diferencia,$total,'NINGUNO','$fecha_actual',$id_usua,'SI')";
  $result_cta_cerrada = $conexion->query($sql_cta_cerrada);
}

$resultado = $conexion->query("SELECT * from dat_ctapac WHERE id_atencion=$id_atencion") or die($conexion->error);
  while ($f = mysqli_fetch_array($resultado)) {
$prod_serv=$f['prod_serv'];
$cta_totiva=$f['cta_tot'];
}

$resultado = $conexion->query("SELECT * from paciente p, dat_ingreso di WHERE  di.id_atencion=$id_atencion AND di.Id_exp =p.Id_exp") or die($conexion->error);
  while ($f = mysqli_fetch_array($resultado)) {
$id_exp=$f['Id_exp'];
}

$resultado = $conexion->query("SELECT * from reg_usuarios WHERE id_usua=$id_usua") or die($conexion->error);
  while ($f = mysqli_fetch_array($resultado)) {
$id_rol=$f['id_rol'];
}

include "../../conexionbd.php";

echo '<script type="text/javascript">window.location ="vista_df.php"</script>';
}

//
$fecha_actual = date("Y-m-d H:i:s");
$sql_up = "UPDATE cta_pagada SET diferencia = 0, fecha_cierre = '$fecha_actual', id_usua=$usuario1, cta_cerrada='SI' WHERE id_cta_pag = $id_cta_pag";

$sql_ing = "UPDATE dat_ingreso SET valida = 'SI', alta_adm='SI', activo='NO' WHERE id_atencion = $id_atencion";
$resultado1 = $conexion->query("SELECT * from cat_camas WHERE id_atencion=$id_atencion") or die($conexion->error);
while ($f = $resultado1->fetch_assoc()) {
     $num_cama=$f['num_cama'];
}
$result_up = $conexion->query($sql_up);
$result_ing = $conexion->query($sql_ing);


/************************* AQUI INICIA EL PROCESO DE INSERCIÓN DE LA CUENTA A CUENTA_PAG  ***********************************************/
$resultado3 = $conexion->query("SELECT * FROM dat_ctapac dc, paciente p, dat_ingreso di where di.id_atencion=$id_atencion and p.Id_exp=di.Id_exp and dc.id_atencion = $id_atencion ORDER BY cta_fec ASC") or die($conexion->error);
$total = 0;
$no = 1;
while ($row3 = $resultado3->fetch_assoc()) {

  $flag = $row3['prod_serv'];
  $prod_serv = $row3['prod_serv'];
  $insumo = $row3['insumo'];
  $id_ctapac = $row3['id_ctapac'];
  $id_exp = $row3['Id_exp'];

  $precioh = $row3['cta_tot'];
       
    if ($insumo == 0 && $flag != 'S' && $flag != 'P' && $flag != 'PC' && $flag != 'H') {
        $descripcion = $row3['prod_serv'];
        $umed = "OTROS";
        $precio = $row3['cta_tot'];
        
        $c_cveuni = 'E48';
        $codigo = '85101502';
        $c_nombre = 'SE';
        $codigo_msi = 'S01472';
        $insumo = '1472';
    } elseif ($flag == 'H' ) {
       // $sqliv = 'UPDATE cta_pagada set  total_noiva=' . $cta_totiva . ' where id_atencion = ' . $id_atencion . ';';
       // $resultiva = $conexion->query($sqliv);

        $resultado_servi = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
        while ($row_servi = $resultado_servi->fetch_assoc()) {
            $descripcion = $row_servi['serv_desc'];
            $umed = $row_servi['serv_umed'];
            $precio = $precioh;
            
            $c_cveuni = $row_servi['c_cveuni'];
            $codigo = $row_servi['codigo_sat'];
            $c_nombre = $row_servi['c_nombre'];
            $codigo_msi = $row_servi['serv_cve'];
            $insumo = $row_servi['id_serv'];
       }
    } elseif ($flag == 'S') {
    $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
    while ($row_serv = $resultado_serv->fetch_assoc()) {
        if ($tr==1){$precio = $row_serv['serv_costo'];}
        elseif ($tr==2){$precio = $row_serv['serv_costo2'];} 
        else if ($tr==3) {$precio = $row_serv['serv_costo3'];}
          else if ($tr==4) {$precio = $row_serv['serv_costo4'];}
       
        
        if ($precio == 0){ $precio = $precioh;}
        $descripcion = $row_serv['serv_desc'];
        $umed = $row_serv['serv_umed'];
        
        $c_cveuni = $row_serv['c_cveuni'];
        $codigo = $row_serv['codigo_sat'];
        $c_nombre = $row_serv['c_nombre'];
        $codigo_msi = $row_serv['serv_cve'];
        $insumo = $row_serv['id_serv'];
      }
    } else if ($flag == 'P') {
    $resultado_prod = $conexion->query("SELECT * FROM sales s, item i where i.item_id = $insumo and i.item_code = s.item_code and s.paciente = $id_atencion") or die($conexion->error);
    while ($row_prod = $resultado_prod->fetch_assoc()) {
        $precio = $precioh;
        $descripcion = $row_prod['generic_name'];
        $umed = $row_prod['type'];
    
        $c_cveuni = $row_prod['c_cveuni'];
        $codigo = $row_prod['codigo_sat'];
        $c_nombre = $row_prod['c_nombre'];
        $codigo_msi = $row_prod['item_code'];
        $insumo = $row_prod['item_id'];
      }
    }else if ($flag == 'PC') {
    $resultado_cy = $conexion->query("SELECT * FROM sales_ceye s, material_ceye m, item_type i where m.material_id = $insumo and  m.material_codigo = s.item_code and s.paciente = $id_atencion and m.material_tipo=i.item_type_id") or die($conexion->error);
    while ($row_prod = $resultado_cy->fetch_assoc()) {
        $precio = $precioh;
        $descripcion = $row_prod['generic_name'];
        $umed = $row_prod['item_type_desc'];
          
        $c_cveuni = $row_prod['c_cveuni'];
        $codigo = $row_prod['codigo_sat'];
        $c_nombre = $row_prod['c_nombre'];
        $codigo_msi = $row_prod['material_codigo'];
        $insumo = $row_prod['material_id'];
      }
    } 

   if ($flag != 'H' ) {
    $cant = $row3['cta_cant'];
    $subtottal = ($precio * $cant);
    $fecha=$row3['cta_fec'];
    $date = date_create($row3['cta_fec']);
    
    $insert_cuenta_pagada="INSERT INTO cuenta_pag(id_atencion,fecha,tipo,nombre,cantidad,precio,subtotal,noIVA,prod_serv,insumo) 
    values($id_atencion,'$fecha','$umed','$descripcion',$cant,$precio,$subtottal,0,'$prod_serv',$insumo)";
    $result_insrt_cuenta=$conexion->query($insert_cuenta_pagada);
   }else {
    $cant = $row3['cta_cant'];
    $subtottal = ($precio * $cant);
    $fecha=$row3['cta_fec'];
    $date = date_create($row3['cta_fec']);
    $insert_cuenta_pagada="INSERT INTO cuenta_pag(id_atencion,fecha,tipo,nombre,cantidad,precio,subtotal,noIVA,prod_serv,insumo) 
    values($id_atencion,'$fecha','$umed','$descripcion',$cant,0,$subtottal,$precio,'$prod_serv',$insumo)";
    $result_insrt_cuenta=$conexion->query($insert_cuenta_pagada);   
   }
   

   $resultado = $conexion->query("SELECT * from dat_financieros WHERE id_atencion=$id_atencion") or die($conexion->error);
   while ($f = mysqli_fetch_array($resultado)) {
       $banco=$f['banco'];
       $deposito=$f['deposito'];
   }



}
          echo '<script type="text/javascript"> window.location.href="valida_cta.php";</script>';
        

        ?>