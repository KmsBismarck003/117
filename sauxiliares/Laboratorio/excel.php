<?php 
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename= servicios.xls");
 ?>
<head>
	<meta charset="UTF-8"/>
</head>
 <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #0c675e">
                    <tr>
                        <th>Id</th>
                        <th>Clave</th>
                        <th>Descripción</th>
                        <th>Precio 1 Particular</th>
                        <th>Precio 2 Axa</th>
                        <th>Precio 3 GNP</th>
                        <th>Precio 4 Otros</th>
                        <th>Unidad de medida</th>
                        <th>Activo</th>
                        <th>Tipo</th>
                        <th>tip_insumo</th>
                        <th>Proveedor</th>
                        <th>Grupo</th>
                        <th>Codigo SAT</th>
                        <th>UM</th>
                        <th>Nombre UM</th>
                        <th>Inmediato</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include '../../conexionbd.php';
                    $resultado2 = $conexion->query("SELECT s.*,t.ser_type_desc as tipo FROM cat_servicios s, service_type t where s.tipo = t.ser_type_id order by id_serv and s.c_nombre='LABORATORIO'") or die($conexion->error);

                    $no = 1;
                    while ($row = $resultado2->fetch_assoc()) {
                    $eid = $row['id_serv'];

                    echo '<tr>'
                        . '<td>' . $row['id_serv'] . '</td>'
                        . '<td>' . $row['serv_cve'] . '</td>'
                        . '<td>' . $row['serv_desc'] . '</td>'
                        . '<td>$ ' . number_format($row['serv_costo'],2). '</td>'
                        . '<td>$ ' . number_format($row['serv_costo2'],2). '</td>'
                        . '<td>$ ' . number_format($row['serv_costo3'],2). '</td>'
                        . '<td>$ ' . number_format($row['serv_costo4'],2). '</td>'
                        . '<td>' . $row['serv_umed'] . '</td>' 
                        . '<td>' . $row['serv_activo'] . '</td>'
                        . '<td>' . $row['tipo'] . '</td>'
                        . '<td>' . $row['tip_insumo'] . '</td>'
                        . '<td>' . $row['proveedor'] . '</td>'
                        . '<td>' . $row['grupo'] . '</td>'
                        . '<td>' . $row['codigo_sat'] . '</td>'
                        . '<td>' . $row['c_cveuni'] . '</td>'
                        . '<td>' . $row['c_nombre'] . '</td>'
                         . '<td>' . $row['inmediato'] . '</td>'
                        .'</tr>';
                        $no++;
                    }
                    ?>
                    </tbody>
                </table>