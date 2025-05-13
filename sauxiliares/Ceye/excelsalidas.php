<?php 

include '../../conexionbd.php';
include '../../conn_almacen/Connection.php';

$date1 = $_POST['date1'];
$date2 = $_POST['date2'];

$date2 = date("Y-m-d",strtotime($date2."+ 1 day")); 

if(isset($_POST['btnexcel']))
{
 //   header('Content-Type: application/xls; charset="UTF-8"');
    header('Content-Type: application/vnd.ms-excel charset=iso-8859-1');
    header('Content-Disposition: attachment; filename="salidas _qx.xls"');
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1 " />

</head>

<table class="table table-bordered table-striped" id="mytable">

    <thead class="thead" style="background-color: #0c675e">
        <tr>
                        <th><font color="black">Paciente</th>
                        <th><font color="black">Fecha surtido</th>
                        <th><font color="black">Item</th>
                        <th><font color="black">Medicamento</th>
                        <th><font color="black">Grupo</th>
                        <th><font color="black">Cantidad surtida</th>
                        <th><font color="black">Precio</th>
                        <th><font color="black">Costo</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../../conexionbd.php';
                        $resultado2 = $conexion->query("SELECT s.* from sales_ceye s WHERE (date_sold BETWEEN '$date1' and '$date2')") or die($conexion->error);
                        while ($row = $resultado2->fetch_assoc()) {
                          $id_atencion = $row['paciente'];
                            $id_usua = $row['id_usua'];
                            $date1=date_create($row['date_sold'] );
                            $item_id = $row['item_id'];
                
                            $sql1 ="SELECT * from dat_ingreso where id_atencion = $id_atencion";
                            $result1 = $conexion->query($sql1);
                            while ($row_di = $result1->fetch_assoc()) {
                                $Id_exp = $row_di['Id_exp'];
                            }
                
                            $sql3 = "SELECT * from paciente p where p.Id_exp=$Id_exp";
                            $result3 = $conexion->query($sql3);
                            while ($row_pac = $result3->fetch_assoc()) {
                                $paciente=$row_pac['papell'] . " " . $row_pac['sapell'] . " " .$row_pac['nom_pac'] ;
                            }
                            $sql2 = "SELECT * from item i where i.item_id=$item_id";
                            $result2 = $conexion->query($sql2);
                            while ($row_item = $result2->fetch_assoc()) {
                                $costo=$row_item['item_cost'];
                                $grupo=$row_item['grupo'];
                            }
                            echo '<tr>'
                                . '<td ><font color="black">' . utf8_decode($paciente) . '</td>'
                                . '<td ><font color="black">' . date_format($date1,"d/m/Y h:i:s") . '</td>'
                                . '<td ><font color="black">' . $row['item_id'] .  '</td>'
                                . '<td ><font color="black">' . utf8_decode($row['generic_name'] .', '.$row['gram']) .  '</td>'
                                . '<td ><font color="black">' . $grupo .  '</td>'
                                . '<td ><font color="black">' . $row['qty'] . '</td>'
                                . '<td><font color="black">'  . $row['price'] . '</td>'
                                . '<td ><font color="black">' . $costo . '</td>'
                                .'</tr>';
                        }
                        ?>
                    </tbody>
</table>
 <?php
}
 ?>