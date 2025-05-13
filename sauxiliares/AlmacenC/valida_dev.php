<?php
include "../../conexionbd.php";


if (@$_GET['q'] == 'valida') {
    $dev = $_GET['dev_id'];
    $stock_id = $_GET['stock_id'];
    $dev_qty = $_GET['dev_qty'];
    $sql2 = "UPDATE devolucion SET dev_estatus = 'NO' WHERE dev_id = $dev";

    $result2 = $conexion->query($sql2);
    $sql3 = "SELECT * FROM stock where item_id = $stock_id";
    $result3 = $conexion->query($sql3);

    while ($row_stock = $result3->fetch_assoc()) {
        $stock = $row_stock['stock_qty'];
    }
    $stock_final = $stock + $dev_qty;
    $sql4 = "UPDATE stock set stock_qty=$stock_final where item_id= $stock_id";
    $result4 = $conexion->query($sql4);
    if ($result2) {
        echo '<script type="text/javascript"> window.location.href="devoluciones.php";</script>';
    } else {
        echo 'ERROR';
    }
}

