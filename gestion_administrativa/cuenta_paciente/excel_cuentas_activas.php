<?php 

header('Content-Type: application/vnd.ms-excel charset=iso-8859-1');
header("Content-Disposition: attachment; filename= cuentas_activas.xls");
include '../../conexionbd.php';
include '../../conn_almacen/Connection.php';

?>


?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1 " />

</head>
 <table class="table table-bordered table-striped" id="mytable">
    <thead class="thead" style="background-color: #0c675e">
        <tr>

            <th scope="col">Exp</th>
            <th scope="col">Hab</th>
            <th scope="col">Paciente</th>
            <th scope="col">Médico</th>
            <th scope="col">Especialidad</th>
            <th scope="col">Cliente</th>
            <th scope="col">Subtotal</th>
            <th scope="col">IVA</th>
            <th scope="col">Total</th>
            <th scope="col">Anticipos</th>
            <th scope="col">Honorarios</th>
            <th scope="col">Equipo <br> Médico</th>
            <th scope="col">Laboratorio</th>
            <th scope="col">Imagen</th>
            <th scope="col">Costo Insumos</th>
            <th scope="col">Gasto</th>
            <th scope="col">Margen de <br> Utilidad</th>
            <th scope="col">Fecha de Ingreso</th>
        </tr>
    </thead>
    <tbody>
    <?php
    include '../../conexionbd.php';
    $date = date("d/m/Y");
    
    $resultado = $conexion->query("SELECT * from cat_camas c, dat_ingreso di, paciente p  WHERE c.id_atencion=di.id_atencion and p.Id_exp=di.Id_exp and di.activo='SI'  ORDER BY c.habitacion") or die($conexion->error);
    while ($f = $resultado->fetch_assoc()) {
        $nombre=$f['papell'].' '.$f['sapell'].' ' .$f['nom_pac'];
        $id_atencion=$f['id_atencion'];
        $id_exp = $f['Id_exp'];
        $cama = $f['num_cama'];
        $date = date_create($f['fecha']);
        $fecing = date_format($date, "d/m/Y h:i A");
        $asegura = $f['aseg'];
        $medico = $f['id_usua'];
        $especialidad = $f['tipo_a'];
        $total = 0;
        $totalg12 = 0;
        $totalg12h = 0;
        $totaliva = 0;
        $Stotal = 0;
        $costo = 0;
        $subtotal_costo = 0;
        $total_costos = 0;
        $totallab = 0;
        $totalimg = 0;
        $total_gasto = 0;
        $num_gasto=0;
                            
                            
        $resultadom = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua = $medico ") or die($conexion->error);
        while($filam = $resultadom->fetch_assoc()){ 
            $nom_medico=$filam["pre"].'. '.$filam["papell"];
        }
        $resultadot = $conexion->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$asegura'")or die($conexion->error);
        while($filat = $resultadot->fetch_assoc()){ 
            $tr=$filat["tip_precio"];
        }
 $resultado3 = $conexion->query("SELECT * FROM dat_ctapac where id_atencion = $id_atencion ORDER BY id_atencion") or die($conexion->error);
                            while ($row3 = $resultado3->fetch_assoc()) {
                                $flag = $row3['prod_serv'];
                                $insumo = $row3['insumo'];
                                $cant = $row3['cta_cant'];
                                $precioh = $row3['cta_tot'];
                                $precio = 0;
                                $iva = 0;
                                $subtottal = 0;
                                $preciog12 = 0;
                                $subtotalg12 = 0;
                                $preciolab = 0;
                                $subtotallab = 0;
                                $precioimg = 0;
                                $subtotalimg = 0;
                                $preciog12h = 0;
                                $subtotalg12h = 0;
                                $costo = 0;
                                $subtotal_costo = 0;
                                $tip_s = ' ';
                                $tip_servi=' ';
                               
                             
                if ($insumo == 0 && 
                    $flag != 'S' && 
                    $flag != 'H' && 
                    $flag != 'P' && 
                    $flag != 'PC' ) {
                    $precio = $precioh;
                    $subtottal = $precio * $cant;
                    $iva =  $subtottal * 0.16;
                }elseif ($flag == 'H') {
                       $preciog12h = $precioh;
                       $subtotalg12h = $preciog12h * $cant;
                       $iva = 0.00;
                }elseif ($flag == 'S') {
                    $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo") or die($conexion->error);
                    while ($row_serv = $resultado_serv->fetch_assoc()) {
                        $tip_servi = $row_serv['tip_insumo'];
                    
                        if ($tr==1) $precio = $row_serv['serv_costo'];
                        if ($tr==2) $precio = $row_serv['serv_costo2'];
                        if ($tr==3) $precio = $row_serv['serv_costo3'];
                        if ($tr==4) $precio = $row_serv['serv_costo4'];
                        
                        if ($precio == 0) $precio = $precioh;
                        
                        $subtottal = $precio * $cant;
                        $iva = $subtottal * 0.16;
                        
                        $tip_s = $row_serv['tipo'];
                        
                        if ($insumo == 1 || $insumo == 3 ){
                            $num_gasto = $num_gasto + 1;
                        }
                        
                        if ($tip_servi=="RENTA EQUIPO"){
                            $preciog12 = $precioh;
                            $subtotalg12 = ($preciog12 * $cant) * 1.16;
                        }
                           
                        
                    }
                } else if ($flag == 'P' || $flag == 'PC' ) {
                    $costo = 0;
                    $resultado_i = $conexion_almacen->query("SELECT item_cost FROM item_almacen where item_id = $insumo and activo = 'SI' ") or die($conexion->error);
                    while ($row_i = $resultado_i->fetch_assoc()) {
                        $costo = $row_i['item_cost'];
                    }
                    $precio = $precioh;
                    $subtottal = $precio * $cant;
                    $iva =  $subtottal * 0.16;
                    $subtotal_costo = $costo * $cant;
                }
                
                $totalg12    = $totalg12 + $subtotalg12;
                $totalg12h   = $totalg12h + $subtotalg12h;
                
                $total      = $total + $subtottal;
                $totaliva   = $totaliva + $iva;
                
                if ($tip_s == '1') {$totallab = $totallab + $subtottal + $iva;}
                if ($tip_s == '2') {$totalimg = $totalimg + $subtottal + $iva;}
                $total_costos = $total_costos + $subtotal_costo;
                $total_gasto = $num_gasto * 2493;
        }
        $total = $total +  + $totalg12h; 
        $Stotal = ($total + $totaliva);
         
        $utilidad = (($Stotal - $totalg12h - $totalg12 - ($totallab * .07) - ($totalimg * .08) - $total_costos - $total_gasto) / $Stotal ) * 100 ;
        
        $sql_tabla = $conexion->query("SELECT deposito FROM dat_financieros WHERE id_atencion=$id_atencion ORDER BY id_atencion") or die($conexion->error);
   
        $subtottaldep=0;
        $totaldep=0;
        while ($row_tabla = $sql_tabla->fetch_assoc()) {
            $subtotaldep=$row_tabla['deposito'];
            $totaldep=$totaldep+$subtotaldep;
        }
        
        echo '<tr>'
            . '<td>' . $id_exp . '</td>'
            . '<td>' . $cama . '</td>'
            . '<td>' . utf8_decode($nombre) . '</td>'
            . '<td>' . utf8_decode($nom_medico). '</td>'
            . '<td>' . utf8_decode($especialidad). '</td>'
            . '<td>' . utf8_decode($asegura) . '</td>' 
            . '<td>' . number_format($total, 2) . '</td>'
            . '<td>' . number_format($totaliva, 2) . '</td>'
            . '<td>' . number_format($Stotal, 2) . '</td>'
            . '<td>' . number_format($totaldep, 2) . '</td>'
            . '<td>' . number_format($totalg12h, 2) . '</td>'
            . '<td>' . number_format($totalg12, 2) . '</td>'
            . '<td>' . number_format($totallab, 2) . '</td>'
            . '<td>' . number_format($totalimg, 2) . '</td>'
            . '<td>' . number_format($total_costos, 2) . '</td>'
            . '<td>' . number_format($total_gasto, 2) . '</td>'
            . '<td>' . number_format($utilidad, 2) . '</td>'
            . '<td>' . $fecing . '</td>'
            . '</tr>';
        }
    ?>
    </tbody>
</table>