<?php
session_start();
include "../../conexionbd.php";

// Sanitizar entradas
list($item_id, $lote, $caducidad) = explode('|', $_POST['medicamento'] ?? '||');
$motivo = $conexion->real_escape_string($_POST['motivo']);
$cantidad_solicitada = intval($_POST['cantidad']);
$id_usua = $_SESSION['login']['id_usua'];
$restante = $cantidad_solicitada;

// Obtener nombre y costo unitario
$r = $conexion->query("SELECT item_name, cost_unit FROM item_almacen WHERE item_id = $item_id");
if (!$r || $r->num_rows === 0) {
    die("Medicamento no encontrado.");
}
$itemData = $r->fetch_assoc();
$item_name = $itemData['item_name'];
$costo_unitario = $itemData['cost_unit'];

// Buscar lotes disponibles
$lotes = $conexion->query("
    SELECT existe_lote, existe_caducidad, existe_qty, existe_salidas, ubicacion_id 
    FROM existencias_almacenh 
    WHERE item_id = $item_id AND existe_qty > 0 AND 
    existe_lote = '$lote' AND 
    existe_caducidad = '$caducidad'
");

if (!$lotes || $lotes->num_rows === 0) {
    die("No hay existencias disponibles para este medicamento.");
}

// Verificar stock total
$total_disponible = 0;
while ($row = $lotes->fetch_assoc()) {
    $total_disponible += $row['existe_qty'];
}
if ($total_disponible < $cantidad_solicitada) {
    die("Existencias insuficientes. Solo hay disponibles: $total_disponible unidades.");
}

// Reiniciar puntero
$lotes->data_seek(0);

// Procesar salida lote por lote
while ($restante > 0 && ($row = $lotes->fetch_assoc())) {
  //  $lote = $row['existe_lote'];
  //  $caducidad = $row['existe_caducidad'];
    $disponible = (int)$row['existe_qty'];
    $salidas_previas = (int)$row['existe_salidas'];
    $ubicacion_id = (int)$row['ubicacion_id'];

    $usar = min($restante, $disponible);
    $stock_inicial = $disponible;
    $stock_final = $stock_inicial - $usar;

    //  Insertar en salidas_almacenh
    $conexion->query("INSERT INTO salidas_almacenh (
        item_id, item_name, salida_lote, salida_caducidad,
        salida_qty, salida_costsu, id_usua, id_atencion,
        solicita, fecha_solicitud, salio
    ) VALUES (
        $item_id, '$item_name', '$lote', '$caducidad',
        $usar, $costo_unitario, $id_usua, 0,
        $id_usua, NOW(), '$motivo'
    )");

    // Actualizar existencias_almacenh
    $conexion->query("UPDATE existencias_almacenh SET 
        existe_qty = $stock_final,
        existe_salidas = $salidas_previas + $usar,
        existe_fecha = NOW()
        WHERE item_id = $item_id 
        AND existe_lote = '$lote' 
        AND existe_caducidad = '$caducidad'
        AND ubicacion_id = $ubicacion_id
        LIMIT 1
    ");

    // Insertar en kardex_almacenh
    $conexion->query("INSERT INTO kardex_almacenh (
        kardex_fecha, item_id, kardex_lote, kardex_caducidad,
        kardex_inicial, kardex_entradas, kardex_salidas, kardex_qty,
        kardex_dev_stock, kardex_dev_merma, kardex_movimiento,
        kardex_ubicacion, kardex_destino, id_usua, id_surte
    ) VALUES (
        NOW(), $item_id, '$lote', '$caducidad',
        $stock_inicial, 0, $usar, $stock_final,
        0, 0, '$motivo',
        '$ubicacion_id', '$motivo', $id_usua, $id_usua
    )");

    $restante -= $usar;
}

header("Location: salidasPorAjusteh.php?msg=success");
exit;
?>
