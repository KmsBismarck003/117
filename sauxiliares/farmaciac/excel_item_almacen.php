<?php 
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=productos_almacen.xls");
?>
<head>
    <meta charset="UTF-8"/>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #0c675e;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #d0e2e0;
        }
        td {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<table>
    <thead>
        <tr>
            <th>Item ID</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Nombre Comercial</th>
            <th>Presentación (g)</th>
            <th>Proveedor</th>
            <th>Factor</th>
            <th>ID Tipo</th>
            <th>Máximo</th>
            <th>Reorden</th>
            <th>Mínimo</th>
            <th>Precio</th>
            <th>Subfamilia</th>
            <th>Grupo</th>
            <th>Costo</th>
            <th>Costo Unitario</th>
            <th>Tipo</th>
            <th>Activo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "../../conexionbd.php";

        $resultado2 = $conexion->query("SELECT i.item_id, i.item_code, i.item_name, i.item_comercial, i.item_grams, i.id_prov, i.factor, i.item_price, i.item_type_id, i.item_max, i.reorden, i.item_min, it.item_type_desc, i.subfamilia, i.grupo, i.activo,i.item_costs,i.cost_unit FROM item_almacen i JOIN item_type it ON i.item_type_id = it.item_type_id") or die($conexion->error);

        while ($row = $resultado2->fetch_assoc()) {
            echo '<tr>'
                . '<td>' . $row['item_id'] . '</td>'
                . '<td>' . $row['item_code'] . '</td>'
                . '<td>' . $row['item_name'] . '</td>'
                . '<td>' . $row['item_comercial'] . '</td>'
                . '<td>' . $row['item_grams'] . '</td>'
                . '<td>' . $row['id_prov'] . '</td>'
                . '<td>' . $row['factor'] . '</td>'
                . '<td>' . $row['item_type_id'] . '</td>'
                . '<td>' . $row['item_max'] . '</td>'
                . '<td>' . $row['reorden'] . '</td>'
                . '<td>' . $row['item_min'] . '</td>'
                . '<td>$' . number_format($row['item_price'], 2) . '</td>'
                . '<td>' . $row['subfamilia'] . '</td>'
                . '<td>' . $row['grupo'] . '</td>'
                . '<td>' . $row['item_costs'] . '</td>'
                . '<td>' . $row['cost_unit'] . '</td>'
                . '<td>' . $row['item_type_desc'] . '</td>'
                . '<td>' . ($row['activo'] ? 'Sí' : 'No') . '</td>'
                . '</tr>';
        }
        ?>
    </tbody>
</table>
