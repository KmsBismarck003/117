<?php 
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename= cuenta.xls");
include '../../conexionbd.php';
$id_atencion = @$_GET['id_atencion'];
$id_usua_log = @$_GET['id_usua'];
 ?>
<head>
	<meta charset="UTF-8"/>
</head>
 <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #0c675e">
                    <tr>
                        <th>No.</th>
                        <th>Fecha registro</th>
                        <th>u.de medida</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th>codigo_sat</th>
                        <th>centro de costo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include '../../conexionbd.php';

    $date = date("d/m/Y");

    $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
    $result_aseg = $conexion->query($sql_aseg);
    while ($row_aseg = $result_aseg->fetch_assoc()) {
        $aseg = 'Particular';
        $at= 'Particular';
    }
    $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
    while($filat = mysqli_fetch_array($resultadot)){ 
        $tr=1;
    }                  

$resultado3 = $conexion->query("SELECT * FROM dat_ctapac dc, paciente p, dat_ingreso di where di.id_atencion=$id_atencion and p.Id_exp=di.Id_exp and dc.id_atencion = $id_atencion ORDER BY cta_fec ASC") or die($conexion->error);
$total = 0;
$totallab = 0;
$totalimg = 0;
$no = 1;
while ($row3 = $resultado3->fetch_assoc()) {

  $flag = $row3['prod_serv'];
  $insumo = $row3['insumo'];
  $id_ctapac = $row3['id_ctapac'];
  $id_exp = $row3['Id_exp'];
  $precioh = $row3['cta_tot'];
  $tip_s = ' ';
  $tip_servi=' ';
  $cto = $row3['centro_cto'];

   if ($insumo == 0 && $flag != 'S' && $flag != 'P' && $flag != 'PC' && $flag != 'H') {
                $descripcion = $row3['prod_serv'];
                $umed = "OTROS";
                $precio = $row3['cta_tot'];
                $iva = $precio * 0.16;
                $sat='85101502';
               }elseif ($flag == 'H' ) {
                  $resultado_servi = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
                  while ($row_servi = $resultado_servi->fetch_assoc()) {
                                
                  $descripcion = $row_servi['serv_desc'];
                  $umed = $row_servi['serv_umed'];
                  $precio = $precioh;
                  $iva = 0;
                  $sat=$row_serv['codigo_sat'];
               }}elseif ($flag == 'S') {
                   
                  $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
                  while ($row_serv = $resultado_serv->fetch_assoc()) {
                 
                    if ($tr==1) $precio = $row_serv['serv_costo'];
                    if ($tr==2) $precio = $row_serv['serv_costo2'];
                    if ($tr==3) $precio = $row_serv['serv_costo3'];
                    if ($tr==4) $precio = $row_serv['serv_costo4'];
                  
                    if ($precio == 0) $precio = $precioh;
                    $descripcion = $row_serv['serv_desc'];
                    $umed = $row_serv['serv_umed'];
                  
                    $tip_s = $row_serv['tipo'];
                    if ($tip_s == '1') {$umed = 'LABORATORIO';}
                    if ($tip_s == '2') {$umed = 'IMAGENOLOGIA';}
                    
                    $tip_servi = $row_serv['tip_insumo'];
                    if ($tip_servi =="RENTA EQUIPO"){
                        $preciog12 = $precioh;
                        $subtotalg12 = ($preciog12 * $cant) * 1.16;
                    }
                    
                    $iva = $precio * 0.16;
                    $sat=$row_serv['codigo_sat'];
                  }
                } elseif ($flag == 'P') {
                  $resultado_prod = $conexion->query("SELECT * FROM item i where i.item_id = $insumo") or die($conexion->error);
                  while ($row_prod = $resultado_prod->fetch_assoc()) {
                    $precio = $row_prod['item_price'];
                    $descripcion = $row_prod['item_name'];
                    $umed = 'Farmacia ';
                    $iva = $precio * 0.16;
                  }
                } elseif ($flag == 'PC') {
                  $resultado_cy = $conexion->query("SELECT * FROM material_ceye m where m.material_id = $insumo") or die($conexion->error);
                   while ($row_prod = $resultado_cy->fetch_assoc()) {
                   $precio = $row_prod['material_precio'];
                   $descripcion = $row_prod['material_nombre'];
                   $umed = 'Quirófano ';
                   $iva = $precio * 0.16;
                  }
                 }

  $cant = $row3['cta_cant'];
  $precio =$precio + $iva;
  $subtottal = $precio * $cant;
    $fecha_cta = date_create($row3['cta_fec']);
  echo '<tr>'
                        . '<td>' . utf8_decode($no) . '</td>'
                        . '<td>' . date_format($fecha_cta,'d/m/Y') . '</td>'
                        . '<td>' . utf8_decode($umed) . '</td>'
                        . '<td>' . utf8_decode($descripcion). '</td>'
                        . '<td>' . utf8_decode($cant). '</td>'
                        . '<td>' . utf8_decode(number_format($precio, 2)) . '</td>' 
                        . '<td>' . utf8_decode(number_format($subtottal, 2)) . '</td>'
                        . '<td>' . utf8_decode($sat). '</td>'
                        . '<td>' . utf8_decode($cto). '</td>'
                        .'</tr>';
                        $no++;
                    }
                    ?>
                    </tbody>
                </table>