<?php 
include '../../conexionbd.php';
include '../../conn_almacen/Connection.php';

$date1 = $_POST['date1'];
$date2 = $_POST['date2'];

if(isset($_POST['btnexcel']))
{
 //   header('Content-Type: application/xls; charset="UTF-8"');
    header('Content-Type: application/vnd.ms-excel charset=iso-8859-1');
    header('Content-Disposition: attachment; filename="cuentas_pagadas.xls"');
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1 " />
</head>

<table class="table table-bordered table-striped" id="mytable">
    <thead class="thead" style="background-color: #0c675e">
        <tr>
        <th scope="col">Exp</th>
        <th scope="col">Id atencion</th>
        <th scope="col">Paciente</th>
        <th scope="col">Medico</th>
        <th scope="col">Especialidad</th>
        <th scope="col">Ingreso</th>
        <th scope="col">Alta</th>
        <th scope="col">Referido</th>
        <th scope="col">Dias Estancia</th>
        <th scope="col">Cliente</th>
        <th scope="col">Total</th>
        <th scope="col">Descuento</th>
        <th scope="col">Real Pagado</th>
        <th scope="col">Honorarios</th>
        <th scope="col">Equipo Medico</th>
        <th scope="col">Laboratorio</th>
        <th scope="col">Imagen</th>
        <th scope="col">Costo Insumos</th>
        <th scope="col">Gasto</th>
        <th scope="col">Margen Utilidad</th>
        <th scope="col">Urgencias</th>
        <th scope="col">Hospitalizacion</th>
        <th scope="col">Quirofano</th>
        <th scope="col">Terapia</th>
        <th scope="col">Consulta</th>
        <th scope="col">Facturada</th>
        <th scope="col">RFC receptor</th>
    </tr>
</thead>

<tbody>
    <?php
    $date = date("d/m/Y");
    $resultado = $conexion->query("SELECT di.fecha as ingreso, di.* from dat_ingreso di WHERE 
    (fec_egreso BETWEEN '$date1' and '$date2') AND valida='SI' ORDER BY di.fec_egreso DESC") or die($conexion->error);
    while ($f = $resultado->fetch_assoc()) {
        $id_atencion    = $f['id_atencion'];
        $id_exp         = $f['Id_exp'];
        
        $sql_pac = "SELECT p.* from paciente p WHERE p.Id_exp=$id_exp";
        $result_pac = $conexion->query($sql_pac);
        while ($pac = $result_pac->fetch_assoc()) {
            $nombre=$pac['papell'].' '.$pac['sapell'].' ' .$pac['nom_pac'];
        }
        
        $area           = $f['area'];
        //$cama         = $f['num_cama'];
        $fecingreso     = date_create($f['ingreso']);
        $fecing         = date_format($fecingreso, "d/m/Y h:i A");
        $datei          = date_create($f['ingreso']);
        $datei          = date_format($datei, "d/m/Y h:i A");
        $referido       = $f['referido'];
        $datee          = date_create($f['fec_egreso']);
        $datee          = date_format($datee, "d/m/Y h:i A");
        $asegura        = $f['aseg'];
        $medico         = $f['id_usua'];
        $especialidad   = $f['tipo_a'];
        
        $total          = 0;
        $iva            = 0;
        $totalg12       = 0;
        $totalg12h      = 0;
        $totaliva       = 0;
        $Stotal         = 0;
        $costo          = 0;
        $subtotal_costo = 0;
        $total_costos   = 0;
        $totallab       = 0;
        $totalimg       = 0;
        $total_gasto    = 0;
        $num_gasto      = 0;
        $total_urg      = 0;
        $total_qui      = 0;
        $total_hos      = 0;
        $total_con      = 0;
        $total_ter      = 0;
        $centro_costo   = ' ';
                    
        $sql_est = "SELECT DATEDIFF(fec_egreso, fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";
        $result_est = $conexion->query($sql_est);
        while ($row_est = $result_est->fetch_assoc()) {
            $estancia = $row_est['estancia'];
        } 
                            
        $resultadom = $conexion ->query("SELECT * FROM reg_usuarios WHERE id_usua = $medico ") or die($conexion->error);
        while($filam = mysqli_fetch_array($resultadom)){ 
            $nom_medico=$filam["pre"].'. '.$filam["papell"];
        }
                         
        $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$asegura'")or die($conexion->error);
        while($filat = mysqli_fetch_array($resultadot)){ 
            $tr=$filat["tip_precio"];
        }
       
        $resultado3 = $conexion->query("SELECT * FROM dat_ctapac where id_atencion = $id_atencion") or die($conexion->error);
        while ($row3 = $resultado3->fetch_assoc()) {
            $flag           = $row3['prod_serv'];
            $insumo         = $row3['insumo'];
            $cant           = $row3['cta_cant'];
            $precioh        = $row3['cta_tot'];
            $centro_costo   = $row3['centro_cto'];
            $precio         = 0;
            $iva            = 0;
            $subtottal      = 0;
            $preciog12      = 0;
            $subtotalg12    = 0;
            $preciolab      = 0;
            $subtotallab    = 0;
            $precioimg      = 0;
            $subtotalimg    = 0;
            $preciog12h     = 0;
            $subtotalg12h   = 0;
            $costo          = 0;
            $subtotal_costo = 0;
            $tip_s          = ' ';
            $tip_servi      = ' ';
            $Stotal         = 0;
            if ($insumo == 0 && 
                $flag != 'S' && 
                $flag != 'H' && 
                $flag != 'P' && 
                $flag != 'PC' ) {
                $precio    = $precioh;
                $subtottal = $precio * $cant;
                $iva       =  $subtottal * 0.16;
            }elseif ($flag == 'H') {
                $preciog12h   = $precioh;
                $subtotalg12h = $preciog12h * $cant;
                $iva          = 0.00;
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
                    $iva       = $subtottal * 0.16;
                    $tip_s     = $row_serv['tipo'];
                    if ($insumo == 1 || $insumo == 3 ){
                        $num_gasto = $num_gasto + 1;
                    }
                    if ($tip_servi=="RENTA EQUIPO"){
                        $preciog12 = $precioh;
                        $subtotalg12 = ($preciog12 * $cant) * 1.16;
                    }
                }
            } elseif ($flag == 'P' || $flag == 'PC' ) {
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
                
            $totalg12   = $totalg12 + $subtotalg12;
            $totalg12h  = $totalg12h + $subtotalg12h;
            $total      = $total + $subtottal;
            $totaliva   = $totaliva + $iva;
                
            if ($tip_s == '1') {$totallab = $totallab + $subtottal + $iva;}
            if ($tip_s == '2') {$totalimg = $totalimg + $subtottal + $iva;}
            $total_costos = $total_costos + $subtotal_costo;
            $total_gasto = $num_gasto * 2493;
                
            if ($centro_costo == 'OBSERVACION' || $centro_costo == 'OBSERVACIÓN')
                {$total_urg = $total_urg + $subtottal + $iva + $subtotalg12h;}
            elseif ($centro_costo == 'HOSPITALIZACION' || $centro_costo == 'HOSPITALIZACIÓN')
                {$total_hos = $total_hos + $subtottal + $iva + $subtotalg12h;}
            elseif ($centro_costo == 'QUIROFANO' || $centro_costo == 'QUIRÓFANO')
                {$total_qui = $total_qui + $subtottal + $iva + $subtotalg12h;}
            elseif ($centro_costo == 'TERAPIA INTENSIVA')
                {$total_ter = $total_ter + $subtottal + $iva + $subtotalg12h;}
            elseif ($centro_costo == 'CONSULTA')
                {$total_con = $total_con + $subtottal + $iva + $subtotalg12h;}
            else
                {$total_hos = $total_hos + $subtottal + $iva + $subtotalg12h;}
        }
        
        $utilidad = 0;    
        $total = $total +  + $totalg12h; 
        $Stotal = ($total + $totaliva);
    
        $resultado_total = $conexion->query("SELECT * FROM dat_financieros where id_atencion = $id_atencion and banco != 'DESCUENTO'") or die($conexion->error);
        $total_dep = 0;
        while ($row_total = $resultado_total->fetch_assoc()) {
            $total_dep = $row_total['deposito'] + $total_dep;
        }
        $resultado_totald = $conexion->query("SELECT * FROM dat_financieros where id_atencion = $id_atencion and banco = 'DESCUENTO'") or die($conexion->error);
        $total_desc = 0;
        while ($row_totald = $resultado_totald->fetch_assoc()) {
            $total_desc = $row_totald['deposito'] + $total_desc;
        }
        if ($area == 'HOSPITALIZACIÓN'){
            $area = 'HOSPITALIZACION';
        }
        if ($area == 'ALTA'){
            $area = 'CONSULTA';
        }
        if ($area == 'OBSERVACIÓN'){
            $area = 'OBSERVACION';
        }
        
        $utilidad = (($total_dep - $totalg12h - $totalg12 - ($totallab * .3) - ($totalimg * .1) - $total_costos - $total_gasto) / $total_dep ) * 100 ;
        
        echo '<tr>'
            . '<td>' . $id_exp . '</td>'
            . '<td>' . $id_atencion . '</td>'
            . '<td>' . utf8_decode($nombre) . '</td>'
            . '<td>' . utf8_decode($nom_medico). '</td>'
            . '<td>' . utf8_decode($especialidad). '</td>'
            . '<td>' . $datei . '</td>'
            . '<td>' . $datee . '</td>'
            . '<td>' . $referido . '</td>'
            . '<td>' . $estancia . '</td>'
            . '<td>' . utf8_decode($asegura) . '</td>' 
            . '<td>' . number_format($Stotal, 2) . '</td>'
            . '<td>' . number_format($total_desc, 2) . '</td>'
            . '<td>' . number_format($total_dep, 2) . '</td>'
            . '<td>' . number_format($totalg12h, 2) . '</td>'
            . '<td>' . number_format($totalg12, 2) . '</td>'
            . '<td>' . number_format($totallab, 2) . '</td>'
            . '<td>' . number_format($totalimg, 2) . '</td>'
            . '<td>' . number_format($total_costos, 2) . '</td>'
            . '<td>' . number_format($total_gasto, 2) . '</td>'
            . '<td>' . number_format($utilidad, 2) . '</td>'
            . '<td>' . number_format($total_urg, 2) . '</td>'
            . '<td>' . number_format($total_hos, 2) . '</td>'
            . '<td>' . number_format($total_qui, 2) . '</td>'
            . '<td>' . number_format($total_ter, 2) . '</td>'
            . '<td>' . number_format($total_con, 2) . '</td>';
            
            $servidor="localhost";
            $nombreBd="u542863078_facturacion";
            $usuario="u542863078_sima_fac";
            $pass="Lh?0y=;/";
            $conexion=new mysqli($servidor,$usuario,$pass,$nombreBd);
            $conexion -> set_charset("utf8");
            if ($conexion-> connect_error){
                die("No se pudo conectar");
            }
            $rfc = "";    
            $resultado341 = $conexion->query("SELECT * from comprobantes where id_atencion=$id_atencion limit 1") or die($conexion->error);
            while($f341 = mysqli_fetch_array($resultado341)){
                $valid=$f341['id_atencion'];
                $rfc = $f341['rfc_receptor'];
                if(isset($f341['id_atencion'])){
                    echo '<td style="text-align: center;"><font size ="3">Si</td>';
                    echo '<td>' . $rfc . '</td>'; 
                }else{
                    echo '<td style="text-align: center;"><font size ="3">No</td>'; 
                }
            }
            include "../../conexionbd.php";
            include '../../conn_almacen/Connection.php';
            echo '</tr>';
        }
    }
    ?>
    </tbody>
</table>