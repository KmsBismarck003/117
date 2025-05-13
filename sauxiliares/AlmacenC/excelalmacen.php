<?php 
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename= productos_almacen.xls");
 ?>
<head>
	<meta charset="UTF-8"/>
</head>
<table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #0c675e">
                    <tr>
                        <th>ID</th>
                        <th>CODIGO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>CONTENIDO</th>
                        <th>COSTO</th>
                        <th>PRECIO 1</th>
                        <th>PRECIO 2</th>
                        <th>PRECIO 3</th>
                        <th>PRECIO 4</th>
                        <th>PRESENTACIÓN</th>        
                        <th>MINIMO</th>
                        <th>MAXIMO</th>
                        <th>TIPO</th>
                        <th>FABRICANTE</th>
                        <th>GRUPO</th>
                        <th>CODIGO SAT</th>
                        <th>CLAVE</th>
                        <th>UNIDAD</th>
                        <th>ACTIVO</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                  
                    include '../../conexionalma.php';
                   
                    $resultado2 = $conexion_almacen->query("SELECT * FROM item_almacen i, item_type it where i.item_type_id=it.item_type_id") or die($conexion->error);
                    $no = 1;
                    while ($row = $resultado2->fetch_assoc()) {
                        $eid = $row['item_id'];
                        echo '<tr>'
                            . '<td>' . $row['item_id'] . '</td>'
                            . '<td>' . $row['item_code'] . '</td>'
                            . '<td>' . $row['item_name'] . '</td>'
                            . '<td>' . $row['item_grams'] . '</td>'
                            . '<td>$' . number_format($row['item_cost'],2) . '</td>'
                            . '<td>$' . number_format($row['item_price'],2) . '</td>'
                            . '<td>$' . number_format($row['item_price2'],2) . '</td>'
                            . '<td>$' . number_format($row['item_price3'],2) . '</td>'
                            . '<td>$' . number_format($row['item_price4'],2) . '</td>'
                            . '<td>' . $row['item_type_desc'] . '</td>'
                            . '<td>' . $row['item_min'] . '</td>'
                            . '<td>' . $row['item_max'] . '</td>'
                            . '<td>' . $row['tip_insumo'] . '</td>'
                            . '<td>' . $row['item_brand'] . '</td>'
                            . '<td>' . $row['grupo'] . '</td>'
                            . '<td>' . $row['codigo_sat'] . '</td>'
                            . '<td>' . $row['c_cveuni'] . '</td>'
                            . '<td>' . $row['c_nombre'] . '</td>'
                            . '<td>' . $row['activo'] . '</td>'
                            .'</tr>';
                        $no++;
                    }
                    ?>
                    </tbody>
                </table>