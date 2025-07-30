<?php
include('../../conexionbd.php');

$filename = 'existencias_almacenh_' . date('Ymd_His') . '.xls';

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table>";
echo "<tr>";
echo "<td colspan='8' style='text-align: center; font-size: 20px; font-weight: bold;'>Existencias Farmacia</td>";
echo "</tr>";
echo "</table>";

echo "<br>";

echo "<table border='1'>";
echo "<tr style='background-color: #4CAF50; color: white; text-align: center; font-weight: bold;'>";
echo "<th>ID</th>";
echo "<th>Medicamento</th>";
echo "<th>Lote</th>";
echo "<th>Caducidad</th>";
echo "<th>Cantidad</th>";
echo "<th>Fecha de Registro</th>";
echo "<th>Existencias</th>"; 
echo "<th>Ubicacion</th>"; 
echo "</tr>";

$query = "
    SELECT 
        ea.existe_id, 
        ia.item_name, 
        ea.existe_lote, 
        ea.existe_caducidad, 
        ea.existe_qty, 
        ea.existe_fecha 
    FROM 
        existencias_almacenh ea 
    INNER JOIN 
        item_almacen ia ON ea.item_id = ia.item_id 
    WHERE 
        ea.existe_qty > 0
    ORDER BY 
        ea.existe_fecha DESC
";

$result = $conexion->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='text-align: center; background-color: #f2f2f2;'>{$row['existe_id']}</td>";
        echo "<td style='text-align: center; background-color: #ffffff;'>{$row['item_name']}</td>";
        echo "<td style='text-align: center; background-color: #f2f2f2;'>{$row['existe_lote']}</td>";
        echo "<td style='text-align: center; background-color: #ffffff;'>{$row['existe_caducidad']}</td>";
        echo "<td style='text-align: center; background-color: #f2f2f2; font-weight: bold;'>{$row['existe_qty']}</td>";
        echo "<td style='text-align: center; background-color: #ffffff;'>{$row['existe_fecha']}</td>";
        echo "<td style='text-align: center; background-color: #f2f2f2;'>&nbsp;</td>"; 
        echo "<td style='text-align: center; background-color: #ffffff;'>&nbsp;</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8' style='text-align: center; font-weight: bold;'>No hay registros con cantidad mayor a 0</td></tr>";
}

echo "</table>";

$conexion->close();
