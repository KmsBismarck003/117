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
            include "../header_farmaciah.php";
        } catch (Exception $e) {
            error_log("Error incluyendo header_farmaciah.php: " . $e->getMessage());
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
    c.id_recib,
    c.item_id,
    i.item_name,
    c.fecha,
    c.solicita,
    SUM(c.entrega) AS total_entrega,
    GROUP_CONCAT(c.existe_lote ORDER BY c.existe_caducidad ASC) AS lotes,
    GROUP_CONCAT(CONCAT(c.existe_lote, ': ', c.existe_caducidad) ORDER BY c.existe_caducidad ASC) AS caducidades
FROM 
    carrito_entradash AS c
JOIN 
    item_almacen AS i ON c.item_id = i.item_id
JOIN 
    cart_recib AS cr ON c.id_recib = cr.id_recib AND cr.parcial = 'NO'
WHERE 
    c.almacen = 'FARMACIA' 
GROUP BY 
    c.id_recib, c.item_id, i.item_name, c.fecha, c.solicita
ORDER BY 
    c.id_recib ASC;

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
        error_log("Iniciando proceso de confirmación");
        
        $id_recib_array = isset($_POST['seleccionados']) ? $_POST['seleccionados'] : [];
        $ubicaciones_array = isset($_POST['ubicaciones']) ? $_POST['ubicaciones'] : [];

        error_log("IDs recibidos: " . print_r($id_recib_array, true));
        error_log("Ubicaciones: " . print_r($ubicaciones_array, true));

        if (empty($id_recib_array) || empty($ubicaciones_array)) {
            error_log("Error: Faltan datos obligatorios - IDs: " . count($id_recib_array) . ", Ubicaciones: " . count($ubicaciones_array));
            echo "<script>alert('Error: Faltan datos obligatorios.');</script>";
            echo "<script>window.location.href = 'confirmar_envio.php';</script>";
            exit();
        }

    foreach ($id_recib_array as $id_recib) {
        try {
            error_log("Procesando ID recib: " . $id_recib);
            
            $id_recib = intval($id_recib);
            $ubicacion_id = isset($ubicaciones_array[$id_recib]) ? intval($ubicaciones_array[$id_recib]) : null;

            if (!$ubicacion_id) {
                error_log("Error: Falta la ubicación para el ID {$id_recib}");
                echo "<script>alert('Error: Falta la ubicación para el ID {$id_recib}');</script>";
                continue;
            }

        $query_validacion = "
            SELECT c.item_id, i.item_name, c.solicita, SUM(c.entrega) AS total_entrega
            FROM carrito_entradash c
            JOIN item_almacen i ON c.item_id = i.item_id
            WHERE c.id_recib = ?
            GROUP BY c.item_id, i.item_name, c.solicita
        ";
        $stmt_validacion = $conexion->prepare($query_validacion);
        if (!$stmt_validacion) {
            echo "<script>alert('Error al preparar la consulta de validación.');</script>";
            exit();
        }
        $stmt_validacion->bind_param("i", $id_recib);
        $stmt_validacion->execute();
        $result = $stmt_validacion->get_result();

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $solicita = $fila['solicita'];
                $total_entrega = $fila['total_entrega'];

                if ($solicita != $total_entrega) {
                    echo "<script>alert('Error: La entrega es parcial para el ítem {$fila['item_name']} (ID: {$fila['item_id']}).');</script>";
                    echo "<script>window.location.href = 'confirmar_envio.php';</script>";
                    exit();
                }
            }
        }

        $query_costo = "SELECT item_costs FROM item_almacen WHERE item_id = ?";
        $stmt_costo = $conexion->prepare($query_costo);
        if (!$stmt_costo) {
            echo "<script>alert('Error al preparar la consulta de costo.');</script>";
            exit();
        }

        $query_insercion = "
            SELECT 
                c.id_recib,
                c.item_id,
                c.existe_lote,
                c.existe_caducidad,
                c.entrega,
                cr.id_usua AS Surte
            FROM 
                carrito_entradash AS c
            JOIN 
                cart_recib AS cr ON c.id_recib = cr.id_recib AND cr.parcial = 'NO'
            WHERE 
                c.id_recib = ?
            ORDER BY 
                c.id_recib ASC, c.existe_caducidad ASC;
        ";
        $stmt_insercion = $conexion->prepare($query_insercion);
        $stmt_insercion->bind_param("i", $id_recib);
        $stmt_insercion->execute();
        $result_insercion = $stmt_insercion->get_result();

        if ($result_insercion->num_rows > 0) {
            while ($row = $result_insercion->fetch_assoc()) {
                $item_id = $row['item_id'];
                $entrada_lote = $row['existe_lote'];
                $entrada_caducidad = $row['existe_caducidad'];
                $entrada_unidosis = $row['entrega'];
                $Surte = $row['Surte'];

                $stmt_costo->bind_param("i", $item_id);
                $stmt_costo->execute();
                $result_costo = $stmt_costo->get_result();
                $row_costo = $result_costo->fetch_assoc();
                $entrada_costo = $row_costo['item_costs'];

                $insert_entrada = "
                    INSERT INTO entradas_almacenh (
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
                    exit('Error al insertar en entradas_almacenh: ' . $stmt_entrada->error);
                }

                $insert_kardex = "
                    INSERT INTO kardex_almacenh (
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
                    ) VALUES (NOW(), ?, ?, ?, 0, ?, 0, 0, 0, 0, 'Resurtimiento', ?, 'FARMACIA', ?, ?);
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
                    exit('Error al insertar en kardex_almacenh: ' . $stmt_kardex->error);
                }

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
                    ) VALUES (NOW(), ?, ?, ?, 0, 0, ?, 0, 0,0, 'Salida', ?, 'FARMACIA', ?);
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
                    error_log('Error al insertar en kardex_almacen: ' . $stmt_kardexc->error);
                    exit('Error al insertar en kardex_almacen: ' . $stmt_kardexc->error);
                }

                $select_existencia = "
                    SELECT existe_entradas, existe_qty 
                    FROM existencias_almacenh 
                    WHERE item_id = ? AND existe_lote = ? AND existe_caducidad = ?
                ";
                $stmt_select_existencia = $conexion->prepare($select_existencia);

                $stmt_select_existencia->bind_param("iss", $item_id, $entrada_lote, $entrada_caducidad);
                $stmt_select_existencia->execute();
                $result_existencia = $stmt_select_existencia->get_result();

                $update_existencia = "
                    UPDATE existencias_almacenh 
                    SET existe_entradas = existe_entradas + ?, 
                        existe_qty = existe_qty + ?,
                        existe_fecha = NOW()
                    WHERE item_id = ? AND existe_lote = ? AND existe_caducidad = ?
                ";
                $stmt_update_existencia = $conexion->prepare($update_existencia);

                $insert_existencia = "
                    INSERT INTO existencias_almacenh (
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
                    ) VALUES (?, ?, ?, ?, ?, 0, ?, 0, NOW(), ?, ?)
                ";
                $stmt_insert_existencia = $conexion->prepare($insert_existencia);

                if ($result_existencia->num_rows > 0) {
                    $stmt_update_existencia->bind_param("iiiss", $entrada_unidosis, $entrada_unidosis, $item_id, $entrada_lote, $entrada_caducidad);
                    if (!$stmt_update_existencia->execute()) {
                        exit('Error al actualizar existencias_almacenh ' . $stmt_update_existencia->error);
                    }
                } else {
                    $stmt_insert_existencia->bind_param(
                        "issiiiii",
                        $item_id,
                        $entrada_lote,
                        $entrada_caducidad,
                        $entrada_unidosis,
                        $entrada_unidosis,
                        $entrada_unidosis,
                        $ubicacion_id,
                        $id_usua
                    );
                    if (!$stmt_insert_existencia->execute()) {
                        exit('Error al insertar en existencias_almacenh: ' . $stmt_insert_existencia->error);
                    }
                }

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
                    ) VALUES (NOW(), ?, ?, ?, 'FARMACIA', ?, ?, ?)
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
                    exit('Error al insertar en salidas_almacen: ' . $stmt_salida->error);
                }

                // Eliminar registros ya procesados
                $delete_cart_recib = "DELETE FROM cart_recib WHERE id_recib = ?";
                $stmt_delete_cart_recib = $conexion->prepare($delete_cart_recib);
                if (!$stmt_delete_cart_recib) {
                    error_log('Error preparando delete cart_recib: ' . $conexion->error);
                    exit('Error preparando delete cart_recib');
                }
                $stmt_delete_cart_recib->bind_param("i", $id_recib);
                if (!$stmt_delete_cart_recib->execute()) {
                    error_log('Error ejecutando delete cart_recib: ' . $stmt_delete_cart_recib->error);
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
                }
            }
        }
        } catch (Exception $e) {
            error_log("Error procesando ID recib {$id_recib}: " . $e->getMessage());
            echo "<script>alert('Error procesando registro {$id_recib}: " . $e->getMessage() . "');</script>";
            continue;
        }
    }
    
    error_log("Proceso de confirmación completado exitosamente");
    header("Location: confirmar_envio.php?success=1");
    exit();
    
    } catch (Exception $e) {
        error_log("Error general en confirmación: " . $e->getMessage());
        echo "<script>alert('Error en el proceso: " . $e->getMessage() . "');</script>";
        echo "<script>window.location.href = 'confirmar_envio.php';</script>";
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
</head>

<body>
    <a href="../../template/menu_farmaciahosp.php"
        style='color: white; margin-left: 30px; margin-bottom: 20px; background-color: #d9534f; 
        border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; display: inline-block;'>
        Regresar
    </a>

    <div class="container">
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
            <strong>
                <center>CONFIRMAR RECIBIDO</center>
            </strong>
        </div> <br>

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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td><input type='checkbox' name='seleccionados[]' value='{$row['id_recib']}' disabled id='chk_{$row['id_recib']}'></td>
                                    <td>{$row['id_recib']}</td>
                                    <td>{$row['fecha']}</td>
                                    <td>{$row['item_name']}</td>
                                    <td>{$row['solicita']}</td>
                                    <td>{$row['total_entrega']}</td>
                                    <td>{$row['lotes']}</td>
                                    <td>{$row['caducidades']}</td>
                                    <td>
                                        <select name='ubicaciones[{$row['id_recib']}]' onchange='habilitarCheckbox({$row['id_recib']})' required>";
                                $primera = true;
                                foreach ($ubicaciones as $ubicacion) {
                                    $selected = $primera ? "selected" : "";
                                    echo "<option value='{$ubicacion['ubicacion_id']}' $selected>{$ubicacion['nombre_ubicacion']}</option>";
                                    $primera = false;
                                }
                                echo "</select>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>No se encontraron registros</td></tr>";
                        }
                    } catch (Exception $e) {
                        error_log("Error generando tabla HTML: " . $e->getMessage());
                        echo "<tr><td colspan='9'>Error cargando datos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div style="margin-top: 10px;">
                <button type="submit" name="confirmar" class="enviar">Confirmar seleccionados</button>
            </div>
        </form>
    </div>

    <script>
        function habilitarCheckbox(id) {
            const select = document.querySelector(`select[name="ubicaciones[${id}]"]`);
            const checkbox = document.getElementById(`chk_${id}`);
            const selectAll = document.getElementById('select-all');

            checkbox.disabled = (select.value === "");
            if (select.value === "") {
                checkbox.checked = false;
                checkbox.required = false; // checkbox no requiere ubicación
                select.required = false; // select no requerido si no hay checkbox marcado
            } else {
                // no forzamos required al select porque solo es requerido si checkbox está marcado
                select.required = checkbox.checked;
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
                    select.required = false;
                } else {
                    // Si está marcado, select es requerido
                    select.required = this.checked;
                }
            });
        });

        // Select all solo marca los habilitados
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

        window.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('select[name^="ubicaciones"]').forEach(select => {
                const id = select.name.match(/\[(\d+)\]/)[1];
                habilitarCheckbox(id);
            });
        });
    </script>
    <script>
        function confirmarEnvio() {
            return confirm('¿Estás seguro de confirmar los registros seleccionados?');
        }
    </script>
    <style>
        .container {
            width: 95%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2px;
        }

        .enviar {
            padding: 5px 10px;
            background-color: #2b2d7f;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .enviar:hover {
            background-color: #218838;
        }

        th,
        td {
            text-align: center;
            vertical-align: middle;
        }

        select {
            width: 100%;
        }
    </style>

</body>

</html>