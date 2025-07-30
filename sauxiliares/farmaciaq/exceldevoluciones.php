<?php 
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename= reportedevoluciones.xls");
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
                        <th>Fecha</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Presentación</th>
                        <th>Devolución Total</th>
                        <th>Devolución Inventario</th>
                        <th>Devolución Merma</th>
                        <th>Paciente</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
                      include '../../conexionbd.php';
                    $resultado2 = $conexion->query("SELECT * FROM devolucion d, item i,item_type it WHERE i.item_id = d.dev_item and d.dev_estatus = 'SI' and it.item_type_id=i.item_type_id") or die($conexion->error);
                    $no = 1;
                    while ($row = $resultado2->fetch_assoc()) {
                        $id_dev = $row['dev_id'];
                        $item_code = $row['item_id'];
                        $item_id = $row['dev_item'];
                        $dev_qty = $row['dev_qty'];
                        $fecha = date_create($row['fecha']);
                        $fecha = date_format($fecha,'d/m/Y H:i');
                        $paciente =$row['paciente'];
                        echo '<tr>'
                            . '<td>' . $fecha . '</td>'
                            . '<td>' . $row['item_code'] . '</td>'
                            . '<td>' . $row['item_name'] .', ' . $row['item_grams'] . '</td>'
                            . '<td>' . $row['item_type_desc'] . '</td>'
                            . '<td><center>' . $row['dev_qty'] . '</center></td>'
                            . '<td><center>' . $row['cant_inv'] . '</center></td>'
                            . '<td><center>' . $row['cant_mer'] . '</center></td>'
                            . '<td>' . $row['paciente'] . '</td>';

                        ?>
                        <?PHP

                        echo '</tr>';
                        $no++;

                    }
                    ?>
                 

                    </tbody>
                </table>