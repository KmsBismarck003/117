<?php 
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename= entradas_almacen.xls");
 ?>
<head>
	<meta charset="UTF-8"/>
</head>
<table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #0c675e">
                    <tr>
                        <th>Fecha de entrada</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Presentación</th>
                        <th>Lote</th>
                        <th>Caducidad</th>
                        <th>Factura</th>
                        <th>Fecha factura</th>
                        <th>Precio entrada</th>
                        <th>Cantidad</th>
                        
                    </tr>
                    </thead>
                    
                    
                    <tbody>
                    <?php
                  
                    include '../../conexionalma.php';
           
                   
                   
                $resultado2 = $conexion_almacen->query("SELECT * FROM item_almacen, entradas, item_type where item_type.item_type_id=item_almacen.item_type_id and item_almacen.item_id = entradas.item_id order by entrada_added desc") or die($conexion->error);
              
                while ($row = $resultado2->fetch_assoc()) {
                  $date=date_create($row['entrada_added']); 
                  $caduca=date_create($row['entrada_expiry']); 
                  $compra=date_create($row['entrada_purchased']); 
                  $id_usua=$row['id_usua'];
                  
                  
                  echo '<tr>'
                    . '<td>' . date_format($date,"d-m-Y") . '</td>'
                    . '<td>' . $row['item_code'] . '</td>'
                    . '<td>' . $row['item_name'] .', '. $row['item_grams'] . '</td>'
                    . '<td>' . $row['item_type_desc'] . '</td>'
                    . '<td>' . $row['entrada_lote'] . '</td>'
                    . '<td>' . date_format($caduca,"d/m/Y"). '</td>'
                    . '<td>' . $row['entrada_factura'] . '</td>'
                    . '<td>' . date_format($compra,"d-m-Y") . '</td>'
                    . '<td>' .'$'. $row['entrada_price'] . '</td>'
                    . '<td>' . $row['entrada_qty'] . '</td>'
                   
                   ;
               
                }
                ?>
              </tbody>
                    
                    
                    
                    
                </table>