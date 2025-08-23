<?php
// Habilitar reporte de errores para debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log de errores personalizado
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log_confirmar_envio.txt');

try {
    include "../../conexionbd.php";
    session_start();
    ob_start();

    if (!isset($_SESSION['login']) || !isset($_SESSION['login']['id_usua'])) {
        error_log("Error: Usuario no logueado o sesión inválida");
        echo "<script>alert('Sesión no válida'); window.location='../../index.php';</script>";
        exit();
    }

    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    date_default_timezone_set('America/Guatemala');
} catch (Exception $e) {
    error_log("Error en inicialización: " . $e->getMessage());
    echo "<script>alert('Error de inicialización: " . $e->getMessage() . "');</script>";
    exit();
}

if (isset($usuario['id_rol'])) {
    if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5 || $usuario['id_rol'] == 1) {
        try {
            include "../header_farmaciaq.php";
        } catch (Exception $e) {
            error_log("Error incluyendo header_farmaciaq.php: " . $e->getMessage());
            echo "<script>alert('Error cargando header');</script>";
        }
    } else {
        error_log("Acceso denegado - Rol no autorizado: " . $usuario['id_rol']);
        session_unset();
        session_destroy();
        echo "<script>window.location='../../index.php';</script>";
        exit();
    }
} else {
    error_log("Error: id_rol no está definido en la sesión");
    session_unset();
    session_destroy();
    echo "<script>window.location='../../index.php';</script>";
    exit();
}

$query = "
   SELECT 
    MIN(c.id) as id,
    c.id_recib,
    c.item_id,
    i.item_name,
    c.fecha,
    cr.solicita,
    SUM(c.entrega) as entrega_total,
    GROUP_CONCAT(c.existe_lote ORDER BY c.existe_caducidad ASC) as lotes,
    GROUP_CONCAT(c.existe_caducidad ORDER BY c.existe_caducidad ASC) as caducidades,
    GROUP_CONCAT(c.entrega ORDER BY c.existe_caducidad ASC) as entregas_individuales,
    c.confirmado,
    cr.parcial,
    CASE 
        WHEN cr.solicita = SUM(c.entrega) THEN 'Completo'
        ELSE 'Parcial' 
    END as estado_real
FROM 
    carrito_entradash AS c
JOIN 
    item_almacen AS i ON c.item_id = i.item_id
JOIN 
    cart_recib AS cr ON c.id_recib = cr.id_recib
WHERE 
    c.almacen = 'QUIROFANO' 
    AND (c.confirmado IS NULL OR c.confirmado != 'SI')
GROUP BY 
    c.id_recib, c.item_id, i.item_name, c.fecha, cr.solicita, c.confirmado, cr.parcial
ORDER BY 
    c.id_recib ASC, MIN(c.existe_caducidad) ASC;

";

try {
    $result = $conexion->query($query);
    if (!$result) {
        error_log("Error en consulta principal: " . $conexion->error);
        die("Error en la consulta: " . $conexion->error);
    }
} catch (Exception $e) {
    error_log("Excepción en consulta principal: " . $e->getMessage());
    die("Error en la consulta: " . $e->getMessage());
}

$ubicaciones_query = "SELECT ubicacion_id, nombre_ubicacion FROM ubicaciones_almacen";
try {
    $ubicaciones_result = $conexion->query($ubicaciones_query);
    $ubicaciones = [];
    if ($ubicaciones_result && $ubicaciones_result->num_rows > 0) {
        while ($ubicacion = $ubicaciones_result->fetch_assoc()) {
            $ubicaciones[] = $ubicacion;
        }
    }
} catch (Exception $e) {
    error_log("Error consultando ubicaciones: " . $e->getMessage());
    $ubicaciones = [];
}


if (isset($_POST['confirmar'])) {
    try {
        error_log("=== INICIANDO PROCESO DE CONFIRMACIÓN ===");
        error_log("POST data: " . print_r($_POST, true));

        $id_carrito_array = isset($_POST['seleccionados']) ? $_POST['seleccionados'] : [];
        $ubicaciones_array = isset($_POST['ubicaciones']) ? $_POST['ubicaciones'] : [];

        error_log("IDs de carrito recibidos: " . print_r($id_carrito_array, true));
        error_log("Ubicaciones recibidas: " . print_r($ubicaciones_array, true));

        if (empty($id_carrito_array)) {
            error_log("ERROR: No se seleccionaron registros");
            echo "<script>alert('Error: Debe seleccionar al menos un registro.');</script>";
            echo "<script>window.location.href = 'confirmar_envioq.php';</script>";
            exit();
        }

        if (empty($ubicaciones_array)) {
            error_log("ERROR: No se recibieron ubicaciones");
            echo "<script>alert('Error: Faltan las ubicaciones.');</script>";
            echo "<script>window.location.href = 'confirmar_envioq.php';</script>";
            exit();
        }

        foreach ($id_carrito_array as $id_carrito) {
            try {
                error_log("Procesando ID carrito: " . $id_carrito);

                $id_carrito = intval($id_carrito);
                $ubicacion_id = isset($ubicaciones_array[$id_carrito]) ? intval($ubicaciones_array[$id_carrito]) : null;

                if (!$ubicacion_id) {
                    error_log("Error: Falta la ubicación para el ID carrito {$id_carrito}");
                    echo "<script>alert('Error: Falta la ubicación para el ID carrito {$id_carrito}');</script>";
                    continue;
                }

                // Obtener el id_recib e item_id del registro agrupado
                $query_grupo = "
                    SELECT c.id_recib, c.item_id 
                    FROM carrito_entradash c
                    WHERE c.id = ?
                ";
                $stmt_grupo = $conexion->prepare($query_grupo);
                $stmt_grupo->bind_param("i", $id_carrito);
                $stmt_grupo->execute();
                $result_grupo = $stmt_grupo->get_result();

                if ($result_grupo->num_rows == 0) {
                    error_log("ERROR: No se encontró el registro agrupado con ID {$id_carrito}");
                    continue;
                }

                $grupo = $result_grupo->fetch_assoc();
                $id_recib = $grupo['id_recib'];
                $item_id = $grupo['item_id'];

                // Obtener TODOS los registros individuales de este grupo (id_recib + item_id)
                $query_registros_individuales = "
                    SELECT c.id, c.id_recib, c.item_id, c.existe_lote, c.existe_caducidad, 
                           c.entrega, c.solicita, cr.id_usua AS Surte
                    FROM carrito_entradash c
                    JOIN cart_recib cr ON c.id_recib = cr.id_recib
                    WHERE c.id_recib = ? AND c.item_id = ? 
                    AND c.almacen = 'QUIROFANO' 
                    AND (c.confirmado IS NULL OR c.confirmado != 'SI')
                ";
                $stmt_registros = $conexion->prepare($query_registros_individuales);
                $stmt_registros->bind_param("ii", $id_recib, $item_id);
                $stmt_registros->execute();
                $result_registros = $stmt_registros->get_result();

                if ($result_registros->num_rows == 0) {
                    error_log("ERROR: No se encontraron registros individuales para id_recib: {$id_recib}, item_id: {$item_id}");
                    continue;
                }

                // Procesar cada registro individual
                while ($registro = $result_registros->fetch_assoc()) {
                    $id_registro_individual = $registro['id'];
                    $entrada_lote = $registro['existe_lote'];
                    $entrada_caducidad = $registro['existe_caducidad'];
                    $entrada_unidosis = $registro['entrega'];
                    $Surte = $registro['Surte'];

                    error_log("Procesando registro individual ID: {$id_registro_individual}, Lote: {$entrada_lote}, Cantidad: {$entrada_unidosis}");

                    // Actualizar el campo confirmado para este registro individual
                    $update_confirmado = "UPDATE carrito_entradash SET confirmado = 'SI' WHERE id = ?";
                    $stmt_update_confirmado = $conexion->prepare($update_confirmado);
                    $stmt_update_confirmado->bind_param("i", $id_registro_individual);
                    if (!$stmt_update_confirmado->execute()) {
                        error_log('Error ejecutando update confirmado para ID: ' . $id_registro_individual);
                        continue;
                    }

                    // Obtener costo del item
                    $query_costo = "SELECT item_costs FROM item_almacen WHERE item_id = ?";
                    $stmt_costo = $conexion->prepare($query_costo);
                    $stmt_costo->bind_param("i", $item_id);
                    $stmt_costo->execute();
                    $result_costo = $stmt_costo->get_result();
                    $row_costo = $result_costo->fetch_assoc();
                    $entrada_costo = $row_costo['item_costs'];

                    // Insertar en entradas_almacenq para cada registro individual
                    $insert_entrada = "
                        INSERT INTO entradas_almacenq (
                            entrada_fecha, 
                            item_id, 
                            entrada_lote, 
                            entrada_caducidad, 
                            entrada_unidosis, 
                            entrada_costo, 
                            id_usua, 
                            ubicacion_id,
                            id_surte
                        ) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)
                    ";
                    $stmt_entrada = $conexion->prepare($insert_entrada);
                    $stmt_entrada->bind_param(
                        "issiiiii",
                        $item_id,
                        $entrada_lote,
                        $entrada_caducidad,
                        $entrada_unidosis,
                        $entrada_costo,
                        $id_usua,
                        $ubicacion_id,
                        $Surte
                    );
                    if (!$stmt_entrada->execute()) {
                        error_log('Error al insertar en entradas_almacenq para lote: ' . $entrada_lote . ' - ' . $stmt_entrada->error);
                        continue;
                    }

                    // Insertar en kardex_almacenq para cada registro individual
                    $insert_kardex = "
                        INSERT INTO kardex_almacenq (
                            kardex_fecha,
                            item_id,
                            kardex_lote,
                            kardex_caducidad,
                            kardex_inicial,
                            kardex_entradas,
                            kardex_salidas,
                            kardex_qty,
                            kardex_dev_stock,
                            kardex_dev_merma,
                            kardex_movimiento,
                            kardex_ubicacion,
                            kardex_destino,
                            id_usua,
                            id_surte
                        ) VALUES (NOW(), ?, ?, ?, 0, ?, 0, 0, 0, 0, 'Resurtimiento', ?, 'QUIROFANO', ?, ?);
                    ";
                    $stmt_kardex = $conexion->prepare($insert_kardex);
                    $stmt_kardex->bind_param(
                        "issisii",
                        $item_id,
                        $entrada_lote,
                        $entrada_caducidad,
                        $entrada_unidosis,
                        $ubicacion_id,
                        $id_usua,
                        $Surte
                    );
                    if (!$stmt_kardex->execute()) {
                        error_log('Error al insertar en kardex_almacenq para lote: ' . $entrada_lote . ' - ' . $stmt_kardex->error);
                        continue;
                    }

                    // Insertar en kardex_almacen para cada registro individual
                    $insert_kardexc = "
                        INSERT INTO kardex_almacen (
                            kardex_fecha,
                            item_id,
                            kardex_lote,
                            kardex_caducidad,
                            kardex_inicial,
                            kardex_entradas,
                            kardex_salidas,
                            kardex_qty,
                            kardex_dev_stock,
                            kardex_dev_merma,
                            kardex_movimiento,
                            kardex_ubicacion,
                            kardex_destino,
                            id_usua
                        ) VALUES (NOW(), ?, ?, ?, 0, 0, ?, 0, 0,0, 'Salida', ?, 'QUIROFANO', ?);
                    ";
                    $stmt_kardexc = $conexion->prepare($insert_kardexc);
                    $stmt_kardexc->bind_param(
                        "issiii",
                        $item_id,
                        $entrada_lote,
                        $entrada_caducidad,
                        $entrada_unidosis,
                        $ubicacion_id,
                        $id_usua
                    );
                    if (!$stmt_kardexc->execute()) {
                        error_log('Error al insertar en kardex_almacen para lote: ' . $entrada_lote . ' - ' . $stmt_kardexc->error);
                        continue;
                    }

                    // Verificar/actualizar existencias_almacenq para cada lote individual
                    $select_existencia = "
                        SELECT existe_entradas, existe_qty 
                        FROM existencias_almacenq 
                        WHERE item_id = ? AND existe_lote = ? AND existe_caducidad = ?
                    ";
                    $stmt_select_existencia = $conexion->prepare($select_existencia);
                    $stmt_select_existencia->bind_param("iss", $item_id, $entrada_lote, $entrada_caducidad);
                    $stmt_select_existencia->execute();
                    $result_existencia = $stmt_select_existencia->get_result();

                    if ($result_existencia->num_rows > 0) {
                        // Actualizar existencia existente
                        $update_existencia = "
                            UPDATE existencias_almacenq 
                            SET existe_entradas = existe_entradas + ?, 
                                existe_qty = existe_qty + ?,
                                existe_fecha = NOW()
                            WHERE item_id = ? AND existe_lote = ? AND existe_caducidad = ?
                        ";
                        $stmt_update_existencia = $conexion->prepare($update_existencia);
                        $stmt_update_existencia->bind_param("iiiss", $entrada_unidosis, $entrada_unidosis, $item_id, $entrada_lote, $entrada_caducidad);
                        if (!$stmt_update_existencia->execute()) {
                            error_log('Error al actualizar existencias_almacenq para lote: ' . $entrada_lote . ' - ' . $stmt_update_existencia->error);
                            continue;
                        }
                    } else {
                        // Insertar nueva existencia
                        $insert_existencia = "
                            INSERT INTO existencias_almacenq (
                                item_id, 
                                existe_lote, 
                                existe_caducidad, 
                                existe_inicial, 
                                existe_entradas, 
                                existe_salidas, 
                                existe_qty, 
                                existe_devoluciones, 
                                existe_fecha, 
                                ubicacion_id, 
                                id_usua
                            ) VALUES (?, ?, ?, ?, 0, 0, ?, 0, NOW(), ?, ?)
                        ";
                        $stmt_insert_existencia = $conexion->prepare($insert_existencia);
                        $stmt_insert_existencia->bind_param(
                            "issiiii",
                            $item_id,
                            $entrada_lote,
                            $entrada_caducidad,
                            $entrada_unidosis,
                            $entrada_unidosis,
                            $ubicacion_id,
                            $id_usua
                        );
                        if (!$stmt_insert_existencia->execute()) {
                            error_log('Error al insertar en existencias_almacenq para lote: ' . $entrada_lote . ' - ' . $stmt_insert_existencia->error);
                            continue;
                        }
                    }

                    // Insertar en salidas_almacen para cada registro individual
                    $insert_salida = "
                        INSERT INTO salidas_almacen (
                            salida_fecha, 
                            salida_lote, 
                            salida_caducidad, 
                            salida_qty, 
                            salida_destino, 
                            id_usua, 
                            item_id, 
                            ubicacion_id
                        ) VALUES (NOW(), ?, ?, ?, 'QUIROFANO', ?, ?, ?)
                    ";
                    $stmt_salida = $conexion->prepare($insert_salida);
                    $stmt_salida->bind_param(
                        "ssiiii",
                        $entrada_lote,
                        $entrada_caducidad,
                        $entrada_unidosis,
                        $id_usua,
                        $item_id,
                        $ubicacion_id
                    );
                    if (!$stmt_salida->execute()) {
                        error_log('Error al insertar en salidas_almacen para lote: ' . $entrada_lote . ' - ' . $stmt_salida->error);
                        continue;
                    }

                    error_log("✓ Procesamiento completado para lote: {$entrada_lote}, cantidad: {$entrada_unidosis}");
                }

                // Verificar si la entrega está completa para este id_recib e item_id específicos DESPUÉS de procesar todos los lotes
                $query_validacion = "
                    SELECT c.item_id, i.item_name, cr.solicita, SUM(c.entrega) AS total_entrega
                    FROM carrito_entradash c
                    JOIN item_almacen i ON c.item_id = i.item_id
                    JOIN cart_recib cr ON c.id_recib = cr.id_recib AND c.item_id = cr.item_id
                    WHERE c.id_recib = ? AND c.item_id = ?
                    GROUP BY c.item_id, i.item_name, cr.solicita
                ";
                $stmt_validacion = $conexion->prepare($query_validacion);
                if (!$stmt_validacion) {
                    echo "<script>alert('Error al preparar la consulta de validación.');</script>";
                    exit();
                }
                $stmt_validacion->bind_param("ii", $id_recib, $item_id);
                $stmt_validacion->execute();
                $result_validacion = $stmt_validacion->get_result();

                $es_entrega_completa = false;
                if ($result_validacion->num_rows > 0) {
                    $fila = $result_validacion->fetch_assoc();
                    $solicita = $fila['solicita'];
                    $total_entrega = $fila['total_entrega'];

                    // Verificar si la entrega está completa para este item específico
                    $es_entrega_completa = ($solicita == $total_entrega);

                    error_log("ID recib: {$id_recib}, Item ID: {$item_id}, Solicitado: {$solicita}, Entregado: {$total_entrega}, Completa: " . ($es_entrega_completa ? 'SI' : 'NO'));
                }

                // Verificar si TODOS los items del id_recib están completos
                $query_validacion_total = "
                    SELECT 
                        c.item_id, 
                        cr.solicita, 
                        SUM(c.entrega) AS total_entrega,
                        CASE WHEN cr.solicita = SUM(c.entrega) THEN 1 ELSE 0 END AS es_completo
                    FROM carrito_entradash c
                    JOIN cart_recib cr ON c.id_recib = cr.id_recib AND c.item_id = cr.item_id
                    WHERE c.id_recib = ?
                    GROUP BY c.item_id, cr.solicita
                ";
                $stmt_validacion_total = $conexion->prepare($query_validacion_total);
                if (!$stmt_validacion_total) {
                    echo "<script>alert('Error al preparar la consulta de validación total.');</script>";
                    exit();
                }
                $stmt_validacion_total->bind_param("i", $id_recib);
                $stmt_validacion_total->execute();
                $result_validacion_total = $stmt_validacion_total->get_result();

                $todos_completos = true;
                if ($result_validacion_total->num_rows > 0) {
                    while ($fila_total = $result_validacion_total->fetch_assoc()) {
                        if ($fila_total['es_completo'] == 0) {
                            $todos_completos = false;
                            break;
                        }
                    }
                }

                error_log("ID recib: {$id_recib} - Todos los items completos: " . ($todos_completos ? 'SI' : 'NO'));

                // Solo actualizar parcial a 'NO' si TODOS los items del id_recib están completos
                if ($todos_completos) {
                    $update_parcial = "UPDATE cart_recib SET parcial = 'NO' WHERE id_recib = ?";
                    $stmt_update_parcial = $conexion->prepare($update_parcial);
                    if (!$stmt_update_parcial) {
                        error_log("Error preparando update parcial: " . $conexion->error);
                        echo "<script>alert('Error al preparar actualización de estado parcial.');</script>";
                        exit();
                    }
                    $stmt_update_parcial->bind_param("i", $id_recib);
                    if (!$stmt_update_parcial->execute()) {
                        error_log("Error ejecutando update parcial: " . $stmt_update_parcial->error);
                        echo "<script>alert('Error al actualizar estado parcial.');</script>";
                        exit();
                    }
                    error_log("Estado actualizado a completo para ID recib: {$id_recib}");
                } else {
                    // Mantener como parcial si no todos los items están completos
                    $update_parcial = "UPDATE cart_recib SET parcial = 'SI' WHERE id_recib = ?";
                    $stmt_update_parcial = $conexion->prepare($update_parcial);
                    if (!$stmt_update_parcial) {
                        error_log("Error preparando update parcial: " . $conexion->error);
                        echo "<script>alert('Error al preparar actualización de estado parcial.');</script>";
                        exit();
                    }
                    $stmt_update_parcial->bind_param("i", $id_recib);
                    if (!$stmt_update_parcial->execute()) {
                        error_log("Error ejecutando update parcial: " . $stmt_update_parcial->error);
                        echo "<script>alert('Error al actualizar estado parcial.');</script>";
                        exit();
                    }
                    error_log("Manteniendo estado parcial para ID recib: {$id_recib}");
                }

                error_log("✓ Todas las inserciones completadas para el grupo id_recib: {$id_recib}, item_id: {$item_id}");

                // Solo eliminar registros si TODOS los items del id_recib están completos
                if ($todos_completos) {
                    $delete_cart_recib = "DELETE FROM cart_recib WHERE id_recib = ?";
                    $stmt_delete_cart_recib = $conexion->prepare($delete_cart_recib);
                    if (!$stmt_delete_cart_recib) {
                        error_log('Error preparando delete cart_recib: ' . $conexion->error);
                        exit('Error preparando delete cart_recib');
                    }
                    $stmt_delete_cart_recib->bind_param("i", $id_recib);
                    if (!$stmt_delete_cart_recib->execute()) {
                        error_log('Error ejecutando delete cart_recib: ' . $stmt_delete_cart_recib->error);
                    } else {
                        error_log("Registro eliminado de cart_recib para ID: {$id_recib} (todos los items completos)");
                    }

                    $delete_carrito_entrada = "DELETE FROM carrito_entradash WHERE id_recib = ?";
                    $stmt_delete_carrito_entrada = $conexion->prepare($delete_carrito_entrada);
                    if (!$stmt_delete_carrito_entrada) {
                        error_log('Error preparando delete carrito_entradash: ' . $conexion->error);
                        exit('Error preparando delete carrito_entradash');
                    }
                    $stmt_delete_carrito_entrada->bind_param("i", $id_recib);
                    if (!$stmt_delete_carrito_entrada->execute()) {
                        error_log('Error ejecutando delete carrito_entradash: ' . $stmt_delete_carrito_entrada->error);
                    } else {
                        error_log("Registro eliminado de carrito_entradash para ID: {$id_recib} (todos los items completos)");
                    }
                } else {
                    error_log("Manteniendo registros en cart_recib y carrito_entradash para ID recib: {$id_recib} (entrega parcial en uno o más items)");
                }
            } catch (Exception $e) {
                error_log("Error procesando ID carrito {$id_carrito}: " . $e->getMessage());
                echo "<script>alert('Error procesando registro carrito {$id_carrito}: " . $e->getMessage() . "');</script>";
                continue;
            }
        }

        error_log("Proceso de confirmación completado exitosamente");
        header("Location: confirmar_envioq.php?success=1");
        exit();
    } catch (Exception $e) {
        error_log("Error general en confirmación: " . $e->getMessage());
        echo "<script>alert('Error en el proceso: " . $e->getMessage() . "');</script>";
        echo "<script>window.location.href = 'confirmar_envioq.php';</script>";
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Carritos Entradas</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2b2d7f;
            --primary-dark: #1e1f5a;
            --primary-light: #4a4db8;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px 0;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 10px;
            margin: 0 0 16px 0;
            text-align: center;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem !important;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            /* permitir scroll horizontal para tablas anchas; dejar overflow-y visible para evitar recorte */
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 12px 12px 18px 12px;
            /* espacio extra abajo para la barra de scroll */
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 14px 12px;
            font-weight: 700;
            font-size: 15px;
            /* aumentado para mejor legibilidad */
            text-transform: uppercase;
        }

        .table tbody td {
            padding: 14px 12px;
            vertical-align: middle;
            text-align: center;
            font-size: 15px;
            /* tamaño mayor para celdas */
        }

        /* Forzar ancho mínimo para activar la barra horizontal cuando la tabla excede el contenedor */
        .table {
            min-width: 1200px;
            /* mantiene un ancho mínimo para evitar compactar columnas */
            width: auto;
            /* permitir que la tabla sea más ancha que el contenedor y se pueda scrollear */
            table-layout: auto;
            border-collapse: collapse;
            box-sizing: border-box;
        }

        /* Evitar que la última columna quede recortada al scrollear: añadir espacio extra al final */
        .table::after {
            content: "";
            display: inline-block;
            width: 48px;
            /* espacio suficiente para ver el texto completo en la mayoría de casos */
            height: 1px;
        }

        /* Aumentar padding de la última celda/encabezado para que el texto no pegue al borde */
        .table th:last-child,
        .table td:last-child {
            padding-right: 30px;
        }

        /* Columna 'Código' (ID Recib): hacer registros más grandes y destacados */
        .table th:nth-child(2),
        .table td:nth-child(2) {
            font-size: 17px;
            /* más grande que el resto */
            font-weight: 700;
            padding-left: 16px;
            padding-right: 16px;
            white-space: nowrap;
            /* evitar salto de línea en el código */
        }

        .lote-badge {
            background: linear-gradient(45deg, #17a2b8, #117a8b);
            color: #fff;
            padding: 6px 10px;
            border-radius: 12px;
            display: inline-block;
            margin: 2px;
            font-weight: 600;
        }

        .caducidad-info {
            color: #495057;
            font-size: 0.9rem;
        }

        .btn-return {
            color: white;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(43, 45, 127, 0.18);
        }

        .enviar {
            padding: 6px 12px;
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        @media (max-width: 900px) {
            .table thead th {
                font-size: 13px;
            }

            .table tbody td {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <div class="container" style="max-width:1200px; margin:0 auto;">
        <div class="page-header">
            <h1><i class="fas fa-clipboard-check"></i> CONFIRMAR RECIBIDO</h1>
        </div>

        <div style="margin-bottom:12px;">
            <a href="../../template/menu_farmaciaq.php" class="btn-return">&#8592; Regresar</a>
        </div>

        <div class="table-container">
            <!-- Mantengo el formulario y la tabla tal cual, solo estilizo el encabezado abajo -->

            <form method="POST" action="" onsubmit="return confirmarEnvio();">
                <table class="table table-bordered table-striped" id="mytable">
                    <thead class="thead" style="background-color: #2b2d7f">
                        <tr>
                            <th><input type="checkbox" id="select-all" disabled></th>
                            <th>
                                <font color="white">ID Recib</font>
                            </th>
                            <th>
                                <font color="white">Fecha.Envio</font>
                            </th>
                            <th>
                                <font color="white">Medicamento</font>
                            </th>
                            <th>
                                <font color="white">Solicitado</font>
                            </th>
                            <th>
                                <font color="white">Entregado</font>
                            </th>
                            <th>
                                <font color="white">Lote</font>
                            </th>
                            <th>
                                <font color="white">Caducidad</font>
                            </th>
                            <th>
                                <font color="white">Ubicación</font>
                            </th>
                            <th>
                                <font color="white">Estado</font>
                            </th>
                            <th>
                                <font color="white">Confirmado</font>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $es_completo = ($row['solicita'] == $row['entrega_total']);
                                    $estado_texto = $es_completo ? 'Completo' : 'Parcial';
                                    $row_class = $es_completo ? 'table-success' : 'table-warning';
                                    $confirmado_texto = ($row['confirmado'] == 'SI') ? 'Confirmado' : 'Pendiente';
                                    $confirmado_class = ($row['confirmado'] == 'SI') ? 'success' : 'secondary';

                                    // Mostrar información de lotes
                                    $lotes_array = explode(',', $row['lotes']);
                                    $caducidades_array = explode(',', $row['caducidades']);
                                    $entregas_array = explode(',', $row['entregas_individuales']);

                                    $lotes_info = "";
                                    for ($i = 0; $i < count($lotes_array); $i++) {
                                        if ($i > 0) $lotes_info .= "<br>";
                                        $lotes_info .= $lotes_array[$i] . " (" . $entregas_array[$i] . ")";
                                    }

                                    $caducidades_info = "";
                                    for ($i = 0; $i < count($caducidades_array); $i++) {
                                        if ($i > 0) $caducidades_info .= "<br>";
                                        $caducidades_info .= $caducidades_array[$i];
                                    }

                                    echo "<tr class='{$row_class}'>
                                    <td>
                                        <input type='checkbox' name='seleccionados[]' value='{$row['id']}' disabled id='chk_{$row['id']}'>
                                    </td>
                                    <td>{$row['id_recib']}</td>
                                    <td>{$row['fecha']}</td>
                                    <td>{$row['item_name']}</td>
                                    <td>{$row['solicita']}</td>
                                    <td>{$row['entrega_total']}</td>
                                    <td>{$lotes_info}</td>
                                    <td>{$caducidades_info}</td>
                                    <td>
                                        <select name='ubicaciones[{$row['id']}]' onchange='habilitarCheckbox({$row['id']})' required>";
                                    $primera = true;
                                    foreach ($ubicaciones as $ubicacion) {
                                        $selected = $primera ? "selected" : "";
                                        echo "<option value='{$ubicacion['ubicacion_id']}' $selected>{$ubicacion['nombre_ubicacion']}</option>";
                                        $primera = false;
                                    }
                                    echo "</select>
                                    </td>
                                    <td><span class='badge badge-" . ($es_completo ? "success" : "warning") . "'>{$estado_texto}</span></td>
                                    <td><span class='badge badge-{$confirmado_class}'>{$confirmado_texto}</span></td>
                                </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11'>No se encontraron registros</td></tr>";
                            }
                        } catch (Exception $e) {
                            error_log("Error generando tabla HTML: " . $e->getMessage());
                            echo "<tr><td colspan='11'>Error cargando datos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div style="margin-top: 10px;">
                    <button type="submit" name="confirmar" class="enviar">Confirmar seleccionados</button>
                </div>
            </form>
        </div> <!-- .table-container -->
    </div> <!-- .container -->

    <script>
        function habilitarCheckbox(id) {
            const select = document.querySelector(`select[name="ubicaciones[${id}]"]`);
            const checkbox = document.getElementById(`chk_${id}`);
            const selectAll = document.getElementById('select-all');

            // Habilitar el checkbox si hay una ubicación seleccionada (no vacía)
            if (select.value && select.value !== "") {
                checkbox.disabled = false;
            } else {
                checkbox.disabled = true;
                checkbox.checked = false;
            }

            // Habilitar el select-all si hay al menos un checkbox habilitado
            const checkboxes = document.querySelectorAll('input[name="seleccionados[]"]');
            const hayHabilitado = Array.from(checkboxes).some(cb => !cb.disabled);
            selectAll.disabled = !hayHabilitado;
        }

        document.querySelectorAll('input[name="seleccionados[]"]').forEach(cb => {
            cb.addEventListener('change', function() {
                const id = this.value;
                const select = document.querySelector(`select[name="ubicaciones[${id}]"]`);

                if (this.checked && select.value === "") {
                    alert("Debe seleccionar una ubicación antes de marcar este registro.");
                    this.checked = false;
                } else {
                    select.required = this.checked;
                }
            });
        });

        // Select all marca todos los habilitados
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="seleccionados[]"]');
            checkboxes.forEach(cb => {
                if (!cb.disabled) {
                    cb.checked = this.checked;
                    const id = cb.value;
                    const select = document.querySelector(`select[name="ubicaciones[${id}]"]`);
                    select.required = cb.checked;
                }
            });
        });

        // Inicializar checkboxes al cargar la página
        window.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('select[name^="ubicaciones"]').forEach(select => {
                const id = select.name.match(/\[(\d+)\]/)[1];
                habilitarCheckbox(id);

                // Como ya hay una ubicación preseleccionada, habilitar el checkbox
                const checkbox = document.getElementById(`chk_${id}`);
                if (select.value && select.value !== "") {
                    checkbox.disabled = false;
                }
            });
        });
    </script>
    <script>
        function confirmarEnvio() {
            // Debug: Mostrar qué checkboxes están marcados
            const checkboxesMarcados = document.querySelectorAll('input[name="seleccionados[]"]:checked');
            const ubicacionesSeleccionadas = [];

            checkboxesMarcados.forEach(cb => {
                const id = cb.value;
                const select = document.querySelector(`select[name="ubicaciones[${id}]"]`);
                ubicacionesSeleccionadas.push({
                    id: id,
                    ubicacion: select.value
                });
            });

            console.log("Checkboxes marcados:", checkboxesMarcados.length);
            console.log("Datos a enviar:", ubicacionesSeleccionadas);

            if (checkboxesMarcados.length === 0) {
                alert("Debe seleccionar al menos un registro para confirmar.");
                return false;
            }

            return confirm(`¿Estás seguro de confirmar ${checkboxesMarcados.length} registro(s) seleccionado(s)?`);
        }
    </script>

</body>

</html>