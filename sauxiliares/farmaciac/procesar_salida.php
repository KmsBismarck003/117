<?php
session_start();
include "../../conexionbd.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id_usua = $_SESSION['login']['id_usua'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
list($item_id, $lote, $caducidad) = explode('|', $_POST['medicamento'] ?? '||');
    $motivo = trim($_POST['motivo'] ?? '');
    $cantidad = intval($_POST['cantidad'] ?? 0);

    if ($item_id > 0 && $cantidad > 0 && !empty($motivo) && $id_usua > 0 && $lote && $caducidad) {
        $stmt = $conexion->prepare("SELECT existe_qty, existe_salidas, ubicacion_id 
            FROM existencias_almacen 
            WHERE item_id = ? AND existe_lote = ? AND existe_caducidad = ?");
        $stmt->bind_param("iss", $item_id, $lote, $caducidad);
        $stmt->execute();
        $res = $stmt->get_result();
        $loteData = $res->fetch_assoc();
        $stmt->close();

        if (!$loteData) {
            die("El lote seleccionado no existe o no tiene stock.");
        }

        $stock_inicial = (int)$loteData['existe_qty'];
        $salidas_previas = (int)$loteData['existe_salidas'];
        $ubicacion_id = (int)$loteData['ubicacion_id'];

        if ($stock_inicial < $cantidad) {
            die("La cantidad solicitada excede el stock disponible del lote seleccionado.");
        }

        $stock_final = $stock_inicial - $cantidad;

        $stmtPrecio = $conexion->prepare("SELECT cost_unit FROM item_almacen WHERE item_id = ?");
        $stmtPrecio->bind_param("i", $item_id);
        $stmtPrecio->execute();
        $resultPrecio = $stmtPrecio->get_result();
        $precio = ($resultPrecio->num_rows > 0) ? floatval($resultPrecio->fetch_assoc()['cost_unit']) : 0;
        $stmtPrecio->close();

        $almacen = "ALMACÉN H";
        $insert = $conexion->prepare("INSERT INTO salidas_almacen (
            item_id, salida_lote, salida_caducidad, salida_qty,
            salida_destino, salida_costsu, salida_almacen,
            id_usua, ubicacion_id, id_surte
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param(
            "issdsssiii",
            $item_id,
            $lote,
            $caducidad,
            $cantidad,
            $motivo,
            $precio,
            $almacen,
            $id_usua,
            $ubicacion_id,
            $id_usua
        );
        $insert->execute();
        $insert->close();

        $nueva_salida = $salidas_previas + $cantidad;
        $update = $conexion->prepare("UPDATE existencias_almacen SET 
            existe_qty = ?, 
            existe_salidas = ?, 
            existe_fecha = NOW()
            WHERE item_id = ? AND existe_lote = ? AND existe_caducidad = ? AND ubicacion_id = ?");
        $update->bind_param(
            "iiiisi",
            $stock_final,
            $nueva_salida,
            $item_id,
            $lote,
            $caducidad,
            $ubicacion_id
        );
        $update->execute();
        $update->close();

        $kardex_salidas = $cantidad;
        $kardex_qty = $stock_final;
        $kardex_movimiento = $motivo;
        $kardex_ubicacion = (string)$ubicacion_id;
        $kardex_destino = $motivo;
        $id_compra = 0;

        $insertKardex = $conexion->prepare("INSERT INTO kardex_almacen (
            kardex_fecha, item_id, kardex_lote, kardex_caducidad,
            kardex_inicial, kardex_entradas, kardex_salidas, kardex_qty,
            kardex_dev_stock, kardex_dev_merma, kardex_movimiento,
            kardex_ubicacion, kardex_destino, id_usua, id_compra
        ) VALUES (
            NOW(), ?, ?, ?, ?, 0, ?, ?, 0, 0, ?, ?, ?, ?, ?
        )");
        $insertKardex->bind_param(
            "issiiisssii",
            $item_id,
            $lote,
            $caducidad,
            $stock_inicial,
            $kardex_salidas,
            $kardex_qty,
            $kardex_movimiento,
            $kardex_ubicacion,
            $kardex_destino,
            $id_usua,
            $id_compra
        );
        $insertKardex->execute();
        $insertKardex->close();

        header("Location: SalidasPorAjuste.php?msg=success");
        exit;
    } else {
        die("Datos incompletos o inválidos.");
    }
}

// AJAX: obtener precio unitario
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['item_id'])) {
    $itemId = intval($_GET['item_id']);
    $stmtPrecio = $conexion->prepare("SELECT cost_unit FROM item_almacen WHERE item_id = ?");
    $stmtPrecio->bind_param("i", $itemId);
    $stmtPrecio->execute();
    $result = $stmtPrecio->get_result();
    $precio = ($result->num_rows > 0) ? floatval($result->fetch_assoc()['cost_unit']) : 0;
    $stmtPrecio->close();
    echo json_encode(["precio" => $precio]);
}
?>
