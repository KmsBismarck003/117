<?php
include "../../conexionbd.php";

session_start();
ob_start();

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
date_default_timezone_set('America/Guatemala');


if (isset($usuario['id_rol'])) {
    if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
        include "../header_farmaciah.php";
    } else {
        // Si el usuario no tiene un rol permitido, destruir la sesión y redirigir
        session_unset();
        session_destroy();
        echo "<script>window.location='../../index.php';</script>";
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_compra = isset($_POST['id_compra']) ? $_POST['id_compra'] : '';
    $coinciden = true;

    // Verifica si 'solicita' y 'entrega' coinciden en todos los ítems de la orden de compra para el id_compra
    $query_verificar = "SELECT solicita, entrega FROM orden_compra WHERE id_compra = ?";
    $stmt_verificar = $conexion->prepare($query_verificar);
    $stmt_verificar->bind_param("i", $id_compra);
    $stmt_verificar->execute();
    $result = $stmt_verificar->get_result();

    // Compara cada registro; si alguno no coincide o si alguno de los campos está vacío, establece $coinciden en false
    while ($row = $result->fetch_assoc()) {
        $solicita = $row['solicita'];
        $entrega = $row['entrega'];

        // Verifica si 'solicita' o 'entrega' están vacíos
        if (empty($solicita) || empty($entrega)) {
            $coinciden = false; // Si algún campo está vacío, no coinciden
            break; // Sal del ciclo
        }

        // Compara las cantidades
        if (intval($solicita) !== intval($entrega)) {
            $coinciden = false;
            break; // Sal del ciclo si no coinciden
        }
    }

    if ($coinciden) {
        // Si coinciden, procede con la inserción en entradas_almacen y la actualización en ordenes_compra
        if (isset($_POST['enviar_datos'])) {
            $fecha_actual = date('Y-m-d H:i:s');
            // 1. Obtener datos de carrito_entradas filtrando por id_compra
            $query_carrito = "SELECT entrada_fecha, id_compra, item_id, entrada_lote, entrada_caducidad, entrada_qty, entrada_unidosis, entrada_costo, ubicacion_id FROM carrito_entradas WHERE id_compra = ?";
            $stmt_carrito = $conexion->prepare($query_carrito);
            $stmt_carrito->bind_param('i', $id_compra);
            $stmt_carrito->execute();
            $result_carrito = $stmt_carrito->get_result();

            if ($result_carrito->num_rows > 0) {
                while ($row = $result_carrito->fetch_assoc()) {
                    // Asigna variables desde carrito_entradas
                    $entrada_fecha =  $fecha_actual;
                    $Entrega_Recibido =  $fecha_actual;

                    $item_id = $row['item_id'];
                    $entrada_lote = $row['entrada_lote'];
                    $entrada_caducidad = $row['entrada_caducidad'];
                    $entrada_qty = $row['entrada_qty'];
                    $entrada_unidosis = $row['entrada_unidosis'];
                    $entrada_costo = $row['entrada_costo'];
                    $ubicacion_id = $row['ubicacion_id'];

                    // 2. Obtener datos de transacciones
                    $query_transaccion = "SELECT factura, id_usuario, monto_total, descuento_total, iva_total, total FROM transacciones WHERE id_compra = ?";
                    $stmt_transaccion = $conexion->prepare($query_transaccion);
                    $stmt_transaccion->bind_param('i', $id_compra);
                    $stmt_transaccion->execute();
                    $result_transaccion = $stmt_transaccion->get_result();
                    $transaccion = $result_transaccion->fetch_assoc();

                    // Asigna datos de transacción
                    $Entrada_Factura = $transaccion['factura'];
                    $entrada_factura = $transaccion['factura'];
                    $id_usuario = $transaccion['id_usuario'];


                    $query_entrada = "INSERT INTO entradas_almacen (
                        entrada_fecha, id_compra, item_id, entrada_lote, entrada_caducidad, 
                        entrada_qty, entrada_unidosis, entrada_costo, ubicacion_id, 
                        entrada_recibido, entrada_factura, id_usua
                    ) VALUES (
                        ?, ?, ?, ?, ?, ?, ?, ?,?, '$Entrega_Recibido', '$Entrada_Factura', ?)";

                    $stmt_entrada = $conexion->prepare($query_entrada);

                    // Ajuste de tipos y parámetros para bind_param
                    $stmt_entrada->bind_param(
                        'siissiisii', // Ocho tipos, uno por cada parámetro que realmente estamos pasando
                        $entrada_fecha,
                        $id_compra,
                        $item_id,
                        $entrada_lote,
                        $entrada_caducidad,
                        $entrada_qty,
                        $entrada_unidosis,
                        $entrada_costo,
                        $ubicacion_id,
                        $id_usuario
                    );

                    if (!$stmt_entrada->execute()) {
                        die("Error en la inserción en entradas_almacen: " . $stmt_entrada->error);
                    }

                    // 5. Actualizar en ordenes_compra
                    $query_actualizar_ordenes = "UPDATE ordenes_compra SET fecha_entrega = ?, id_usua = ?, factura = ?, monto = ?, descuento = ?, iva = ?, total = ? , estatus = 'ENTREGADO' WHERE id_compra = ?";
                    $stmt_actualizar_ordenes = $conexion->prepare($query_actualizar_ordenes);
                    $stmt_actualizar_ordenes->bind_param(
                        'sssssisi',
                        $fecha_actual,
                        $id_usuario,
                        $entrada_factura,
                        $transaccion['monto_total'],
                        $transaccion['descuento_total'],
                        $transaccion['iva_total'],
                        $transaccion['total'],
                        $id_compra
                    );

                    if (!$stmt_actualizar_ordenes->execute()) {
                        die("Error en la actualización de ordenes_compra: " . $stmt_actualizar_ordenes->error);
                    }
                    // Actualizar el campo fecha_entrega en la tabla orden_compra para el id_compra específico
                    $query_actualizar_orden = "UPDATE orden_compra SET fecha_entrega = ? WHERE id_compra = ?";
                    $stmt_actualizar_orden = $conexion->prepare($query_actualizar_orden);
                    $stmt_actualizar_orden->bind_param("si", $fecha_actual, $id_compra);

                    if (!$stmt_actualizar_orden->execute()) {
                        die("Error al actualizar en orden_compra: " . $stmt_actualizar_orden->error);
                    }
                }

                // Eliminar la orden del carrito de entradas después de la inserción
                $query_eliminar_carrito = "DELETE FROM carrito_entradas WHERE id_compra = ?";
                $stmt_eliminar_carrito = $conexion->prepare($query_eliminar_carrito);
                $stmt_eliminar_carrito->bind_param('i', $id_compra);

                if (!$stmt_eliminar_carrito->execute()) {
                    die("Error al eliminar la orden de carrito_entradas: " . $stmt_eliminar_carrito->error);
                }
                // Redirige después de insertar
                header("Location: entradas.php"); // Cambia a la URL que desees
                exit(); // Termina el script
            }
        }
    } else {
        // Si no coinciden, almacena el mensaje de error en la sesión
        $_SESSION['mensaje_error'] = 'La orden esta en estado parcial';
        // Redirige a la misma página para evitar reenvío del formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Muestra el mensaje de error si existe
if (isset($_SESSION['mensaje_error'])) {
    echo "<script>alert('" . $_SESSION['mensaje_error'] . "');</script>";
    unset($_SESSION['mensaje_error']); // Elimina el mensaje después de mostrarlo
}


// Manejar la actualización de datos
$input = json_decode(file_get_contents('php://input'), true);

// Variables esenciales
$item_id = $input['item_id'] ?? null;
$id_compra = $input['id_compra'] ?? null;
$updates = [];
$params = [];

// Verifica cada campo individualmente y construye la consulta
if (isset($input['entrada_lote'])) {
    $updates[] = "entrada_lote = ?";
    $params[] = $input['entrada_lote'];
}
if (isset($input['entrada_caducidad'])) {
    $updates[] = "entrada_caducidad = ?";
    $params[] = date('Y-m-d', strtotime($input['entrada_caducidad']));
}
if (isset($input['entrada_qty'])) {
    $updates[] = "entrada_qty = ?";
    $params[] = $input['entrada_qty'];
}
if (isset($input['entrada_unidosis'])) {
    $updates[] = "entrada_unidosis = ?";
    $params[] = $input['entrada_unidosis'];
}
if (isset($input['entrada_costo'])) {
    $updates[] = "entrada_costo = ?";
    $params[] = $input['entrada_costo'];
}
if (isset($input['ubicacion_id'])) {
    $updates[] = "ubicacion_id = ?";
    $params[] = $input['ubicacion_id'];
}
if (isset($input['entrada_iva'])) {
    $updates[] = "entrada_iva = ?";
    $params[] = $input['entrada_iva'];
}
if (isset($input['entrada_descuento'])) {
    $updates[] = "entrada_descuento = ?";
    $params[] = $input['entrada_descuento'];
}
if (isset($input['Total'])) {
    $updates[] = "Total = ?";
    $params[] = $input['Total'];
}

// Solo procede si hay campos para actualizar
if (!empty($updates)) {
    $params[] = $id_compra;
    $params[] = $item_id;

    // Crear consulta dinámica
    $sql = "UPDATE carrito_entradas SET " . implode(", ", $updates) . " WHERE id_compra = ? AND item_id = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die(json_encode(["status" => "error", "message" => "Error al preparar la consulta: " . $conexion->error]));
    }

    $stmt->bind_param(str_repeat("s", count($params)), ...$params);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Actualizar el campo 'entrega' en la tabla 'orden_compra'
        $new_entrega = isset($input['entrada_qty']) ? $input['entrada_qty'] : 0; // Cambia según la lógica que necesites
        $query_actualizar_orden = "UPDATE orden_compra SET entrega = ? WHERE id_compra = ? AND item_id = ?";
        $stmt_actualizar_orden = $conexion->prepare($query_actualizar_orden);
        if (!$stmt_actualizar_orden) {
            die(json_encode(["status" => "error", "message" => "Error al preparar la consulta de actualización en orden_compra: " . $conexion->error]));
        }

        // Usamos 'i' para integer ya que 'entrada_qty' es numérico
        $stmt_actualizar_orden->bind_param('iis', $new_entrega, $id_compra, $item_id);

        if ($stmt_actualizar_orden->execute()) {
            echo json_encode(["status" => "success", "message" => "Actualización realizada con éxito y se actualizó el campo 'entrega' en orden_compra."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error en la actualización de entrega: " . $stmt_actualizar_orden->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error en la actualización: " . $stmt->error]);
    }
}





// Parámetros de configuración de paginación
$registros_por_pagina = 6; // Número de órdenes por página (ajustar aquí para pruebas)
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Verificar si se ha recibido un ID de compra para eliminar
if (isset($_GET['id_compra'])) {
    $id_compra = $_GET['id_compra'];

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Eliminar de carrito_entradas
        $sql1 = "DELETE FROM carrito_entradas WHERE id_compra = ?";
        $stmt1 = $conexion->prepare($sql1);
        $stmt1->bind_param("i", $id_compra);
        $stmt1->execute();

        // Eliminar de transaccioUnes
        $sql2 = "DELETE FROM transacciones WHERE id_compra = ?";
        $stmt2 = $conexion->prepare($sql2);
        $stmt2->bind_param("i", $id_compra);
        $stmt2->execute();

        // Actualizar estatus en ordenes_compra
        $sql3 = "UPDATE ordenes_compra SET activo = 'SI', estatus = '' WHERE id_compra = ?";
        $stmt3 = $conexion->prepare($sql3);
        $stmt3->bind_param("i", $id_compra);
        $stmt3->execute();


        // Confirmar la transacción
        $conexion->commit();

        // Redirigir a la misma página para evitar reenvío del formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        // Si hay un error, revertir la transacción
        $conexion->rollback();
        echo "Error al eliminar la compra: " . $e->getMessage();
    }
}
// Consulta para obtener las ubicaciones desde la base de datos
$ubicaciones = [];
$query = "SELECT ubicacion_id, nombre_ubicacion FROM ubicaciones_almacen";
$result = mysqli_query($conexion, $query); // Asegúrate de que $conexion esté correctamente configurado

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ubicaciones[] = $row; // Guardar cada fila de resultado en el array $ubicaciones
    }
} else {
    echo "Error al obtener las ubicaciones: " . mysqli_error($conexion);
}

// Contar el número total de órdenes para la paginación
$query_total = "SELECT COUNT(DISTINCT id_compra) AS total FROM carrito_entradas";
$result_total = $conexion->query($query_total);
$total_registros = $result_total->fetch_assoc()['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Consulta para obtener los IDs de las órdenes con paginación
$query_ordenes = "SELECT DISTINCT id_compra FROM carrito_entradas LIMIT $offset, $registros_por_pagina";
$result_ordenes = $conexion->query($query_ordenes);
echo "<a href='entradas.php'  style='color: white;  margin-left: 20px;background-color: #d9534f; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer;'>Regresar</a>";

// Verificar si hay órdenes
if ($result_ordenes->num_rows > 0) {
    echo "<div style='background-color: white; padding: 50px; border-radius: 30px;margin-top: 15px;'>";

    echo "<h2 style='margin-top: 40px;color: #0c675e;text-align: center;'>Carrito de Compras</h2>";
    echo "<div style='display: flex; flex-direction: column;'>"; // Cambié a flexbox para un mejor alineamiento vertical

    while ($row_orden = $result_ordenes->fetch_assoc()) {
        $id_compra = $row_orden['id_compra'];

        // Consulta para obtener todos los ítems de la orden actual
        $query_items = "SELECT 
        ce.`entrada_fecha`, 
        ce.`item_id`, 
        ia.`item_name`, 
        ce.`entrada_lote`, 
        ce.`entrada_caducidad`, 
        ce.`entrada_qty`, 
        ce.`entrada_unidosis`, 
        ce.`entrada_iva`, 
        ce.`entrada_descuento`, 
        ce.`Total`, 
        ce.`entrada_costo`, 
        ce.`ubicacion_id`, 
        ia.`factor`, 
        oc.`solicita`, 
        t.`factura`, 
        t.`monto_total`, 
        t.`descuento_total`, 
        t.`iva_total`, 
        t.`total`, 
        t.`id_usuario`
    FROM 
        `carrito_entradas` AS ce
    JOIN 
        `transacciones` AS t ON ce.`id_compra` = t.`id_compra`
    JOIN 
        `item_almacen` AS ia ON ce.`item_id` = ia.`item_id`
    JOIN 
        `orden_compra` AS oc ON ce.`id_compra` = oc.`id_compra` AND ce.`item_id` = oc.`item_id`
    WHERE 
        ce.`id_compra` = ?
    GROUP BY 
        ce.`id_compra`, ce.`item_id`";



        $stmt_items = $conexion->prepare($query_items);
        $stmt_items->bind_param("i", $id_compra);
        $stmt_items->execute();
        $result_items = $stmt_items->get_result();

        // Detalles de la orden
        $row_items = $result_items->fetch_assoc();
        // Mostrar información de la orden
        // Mostrar información de la orden
        echo "<div class='compra-item'>
        <h3 onclick='toggleDetails(\"compra_{$id_compra}\")' style='cursor: pointer; color: #007bff;'>
            Compra ID: {$id_compra} - Click para ver detalles
        </h3>
        <p>
            <strong>Factura:</strong> {$row_items['factura']} | 
            <strong>Monto Total:</strong> \${$row_items['monto_total']} | 
            <strong>Descuento Total:</strong> \${$row_items['descuento_total']} | 
            <strong>IVA Total:</strong> \${$row_items['iva_total']} | 
            <strong>Total:</strong> \${$row_items['total']} | 
            <strong>ID Usuario:</strong> {$row_items['id_usuario']}
        </p>
        <button onclick='confirmDelete($id_compra)' style='color: white; background-color: #d9534f; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer;'>Eliminar</button>

        <div id='compra_{$id_compra}' class='compra-details' style='display: none;'>
        <form id='formActualizar_{$id_compra}' method='POST' >

                    <div class='table-responsive'>

                <table class='carrito-table'>
                    <thead>
                        <tr>
                            <th>Fecha Entrada</th>
                            <th>Ítem</th>
                            <th>Lote</th>
                            <th>Caducidad</th>
                            <th>Solicitado</th>
                            <th>Cantidad</th>
                            <th>Factor</th>
                            <th>Unidosis</th>
                            <th>Costo Unitario</th>
                           <th>Costo*Cantidad</th>
                            <th>Ubicación</th>
                            <th>IVA </th> 
                             <th>Descuento</th> 
                            <th>Costo Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";

        $result_items->data_seek(0);
        while ($item_row = $result_items->fetch_assoc()) {
            $costoTotalItem = $item_row['entrada_qty'] * $item_row['entrada_costo'];
            $factor = isset($item_row['factor']) ? $item_row['factor'] : 1; // Asigna 1 o el valor necesario si 'factor' está vacío o no existe
            $Totales = isset($item_row['Total']) ? $item_row['Total'] : 1;
            $Ivas = isset($item_row['entrada_iva']) ? $item_row['entrada_iva'] : 1;
            $Descuentos = isset($item_row['entrada_descuento']) ? $item_row['entrada_descuento'] : 1;

            echo "<tr style='height: 50px;'>
    <td>{$item_row['entrada_fecha']}</td>
    <td>{$item_row['item_name']}</td>
    <td><input type='text' id='lote_{$item_row['item_id']}' value='{$item_row['entrada_lote']}' style='width: 80px;'></td>
    <td><input type='date' id='caducidad_{$item_row['item_id']}' value='{$item_row['entrada_caducidad']}' style='width: 100px;'></td>
            <td><input type='number' id='solicitado_{$item_row['item_id']}' value='{$item_row['solicita']}' style='width: 70px;' readonly></td> <!-- Campo solicitado -->

    <td><input type='number' id='cantidad_{$item_row['item_id']}' value='{$item_row['entrada_qty']}' style='width: 70px;'></td>
    <td><input type='number' id='factor_{$item_row['item_id']}' name='factor[]' value='{$factor}' readonly style='width: 50px;'></td>
    <td><input type='number' id='unidosis_{$item_row['item_id']}' value='{$item_row['entrada_unidosis']}' style='width: 80px;'></td>
    <td><input type='number' id='costo_{$item_row['item_id']}' value='{$item_row['entrada_costo']}' style='width: 80px;'></td>
     <td id='costo_cantidad_{$item_row['item_id']}'>\${$costoTotalItem}</td>

    <td>
        <select id='ubicacion_{$item_row['item_id']}' style='width: 100px;'>";

            foreach ($ubicaciones as $ubicacion) {
                $selected = ($ubicacion['ubicacion_id'] == $item_row['ubicacion_id']) ? 'selected' : '';
                echo "<option value='{$ubicacion['ubicacion_id']}' $selected>{$ubicacion['nombre_ubicacion']}</option>";
            }

            echo "</select>
    </td>
</td>
    <td><input type='number' id='iva_{$item_row['item_id']}' name='iva[]' value='{$Ivas}'  style='width: 80px;'></td> 
    <td><input type='number' id='descuento_{$item_row['item_id']}' name='descuento[]' value='{$Descuentos}'  style='width: 80px;'></td> 
  <td><input type='number' id='costo_total_{$item_row['item_id']}' name='costo_total[]' value='{$Totales}' readonly style='width: 80px;'></td> 


<td>

    <button type='button' id='btnCalcular_{$item_row['item_id']}' style='color: white; margin-bottom: 10px; background-color: #0c675e; border: none; border-radius: 5px; gap: 20px; padding: 5px 10px; cursor: pointer;' onclick='calcularTotales({$item_row['item_id']})'>Calcular</button>
    <button type='button' id='btnActualizar_{$item_row['item_id']}' style='color: white; background-color: #0c675e; border: none; border-radius: 5px; gap: 2010px; padding: 5px 10px; cursor: pointer;' onclick='updateItemWithAlert(\"{$item_row['item_id']}\", \"formActualizar_{$id_compra}\")' disabled>Actualizar</button>

</tr>";
        }
        echo "</tbody>
<tfoot>
    <tr>
        <td colspan='9'></td> <!-- Espacios hasta la columna de Descuento -->
        <td colspan='3' style='text-align: right; padding-top: 15px;'>
     <input type='hidden' name='id_compra' value='{$id_compra}'> 
    <button type='submit' name='enviar_datos' style='color: white; background-color: #0c675e; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer;'>Enviar a Entradas</button>
                  </td>
                    </tr>
                </tfoot>
            </table>
        </div></form></div></div>";
    }

    echo "</div>"; // Cierra el contenedor de órdenes


    // Navegación de páginas
    echo "<div style='text-align: center; margin-top: 20px;'>";

    // Botón de página anterior
    if ($pagina_actual > 1) {
        $pagina_anterior = $pagina_actual - 1;
        echo "<a href='?pagina=$pagina_anterior' style='margin-right: 10px;'>Página Anterior</a>";
    }

    // Mostrar los enlaces de número de página
    for ($i = 1; $i <= $total_paginas; $i++) {
        if ($i == $pagina_actual) {
            echo "<strong style='margin: 0 5px;'>$i</strong>";
        } else {
            echo "<a href='?pagina=$i' style='margin: 0 5px;'>$i</a>";
        }
    }

    // Botón de página siguiente
    if ($pagina_actual < $total_paginas) {
        $pagina_siguiente = $pagina_actual + 1;
        echo "<a href='?pagina=$pagina_siguiente' style='margin-left: 10px;'>Página Siguiente</a>";
    }

    echo "</div>";
} else {
    // Mensaje cuando no hay registros
    echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
    <p style='color: #0c675e; font-size: 50px; text-align: center;'>No hay registros en el carrito de compras.</p>
          </div>";
    echo "</div>"; // Cerrar el contenedor

}
// Cierra el contenedor principal
echo "</div>";
?>

<script>
    function toggleDetails(id) {
        var element = document.getElementById(id);
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }

    function confirmDelete(id_compra) {
        if (confirm("¿Estás seguro de que deseas eliminar esta compra?")) {
            window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?id_compra=" + id_compra;
        }
    }
</script>
<script>
    function updateItem(itemId, formId) {
        const form = document.getElementById(formId);
        if (!form) {
            console.error(`Formulario con ID ${formId} no encontrado.`);
            return;
        }


        // Capturar valores de los inputs cuando se presiona el botón de actualizar
        const lote = document.getElementById(`lote_${itemId}`).value;
        const caducidad = document.getElementById(`caducidad_${itemId}`).value;
        const cantidad = document.getElementById(`cantidad_${itemId}`).value;
        const unidosis = document.getElementById(`unidosis_${itemId}`).value;
        const costo = document.getElementById(`costo_${itemId}`).value;
        const ubicacion = document.getElementById(`ubicacion_${itemId}`).value;
        const ivaa = document.getElementById(`iva_${itemId}`).value;
        const descuentoo = document.getElementById(`descuento_${itemId}`).value;
        const costo_total = document.getElementById(`costo_total_${itemId}`).value;
        let data = {
            action: 'update_item',
            item_id: itemId,
            id_compra: formId.split('_')[1],
            entrada_lote: lote,
            entrada_caducidad: caducidad,
            entrada_qty: cantidad,
            entrada_unidosis: unidosis,
            entrada_costo: costo,
            ubicacion_id: ubicacion,
            entrada_iva: ivaa,
            entrada_descuento: descuentoo,
            Total: costo_total
        };

        // Hacer la solicitud de actualización
        fetch("carrito_entradas.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === "success") {
                    alert("Actualización realizada con éxito.");
                } else {
                    alert("Error en la actualización: " + result.message);
                }
            })

            .catch(error => {
                console.error("Error:", error);
            })
            .finally(() => {
                alert("Actualización realizada con éxito.");
                window.location.href = "carrito_entradas.php"; // Redirige a la URL deseada
                exit(); // Termina el script
            });

    }

    let calculado = false; // Variable para verificar si se ha dado en calcular

    // Función para habilitar/deshabilitar el botón de actualizar
    function toggleActualizarButton(itemId) {
        const btnActualizar = document.getElementById(`btnActualizar_${itemId}`);

        // Obtener otros inputs relevantes
        const cantidad = document.getElementById(`cantidad_${itemId}`).value;
        const costoUnitario = document.getElementById(`costo_${itemId}`).value;
        const iva = document.getElementById(`iva_${itemId}`).value;
        const descuento = document.getElementById(`descuento_${itemId}`).value;

        // Habilitar el botón si hay cambios en los campos habilitados
        if (cantidad || costoUnitario || iva || descuento) {
            btnActualizar.disabled = false; // Habilitar botón
        } else {
            btnActualizar.disabled = true; // Deshabilitar botón
        }
    }

    function calcularTotales(itemId) {
        // Obtener la fila correspondiente al item_id
        const row = document.querySelector(`#costo_total_${itemId}`).closest('tr');

        // Obtener elementos relevantes de la fila
        const cantidad = parseFloat(row.querySelector(`#cantidad_${itemId}`).value) || 0;
        const costoUnitario = parseFloat(row.querySelector(`#costo_${itemId}`).value) || 0;
        const iva = parseFloat(row.querySelector(`#iva_${itemId}`).value) || 0;
        const descuento = parseFloat(row.querySelector(`#descuento_${itemId}`).value) || 0;
        const factor = parseFloat(row.querySelector(`#factor_${itemId}`).value) || 1;

        // Verificar si se han realizado cambios relevantes
        if (cantidad || costoUnitario || iva || descuento) {
            // Calcular Costo * Cantidad
            const costoCantidad = cantidad * costoUnitario;
            row.querySelector(`#costo_cantidad_${itemId}`).textContent = `$${costoCantidad.toFixed(2)}`;

            // Calcular subtotal, IVA y costo total
            const subtotal = costoCantidad - descuento;
            const ivaTotal = subtotal * iva;
            const costoTotal = subtotal + ivaTotal;

            // Calcular unidosis (cantidad * factor)
            const unidosis = cantidad * factor;

            // Actualizar el costo total en el campo de entrada correspondiente
            row.querySelector(`#costo_total_${itemId}`).value = costoTotal.toFixed(2);

            // Actualizar el campo de unidosis
            const unidosisField = row.querySelector(`#unidosis_${itemId}`);
            if (unidosisField) {
                unidosisField.value = unidosis.toFixed(2);
            }

            // Habilitar el botón de actualizar si se han hecho cambios
            toggleActualizarButton(itemId);

            // Actualizar el mensaje del botón Calcular
            const btnCalcular = document.getElementById(`btnCalcular_${itemId}`);
            btnCalcular.textContent = "Dar en Actualizar";

            // Cambiar color del botón Calcular (opcional)
            btnCalcular.style.backgroundColor = "#4CAF50"; // Color verde para indicar éxito
            btnCalcular.style.color = "white"; // Texto blanco

            // Marcar que se ha calculado
            calculado = true; // Indicar que el cálculo se ha realizado
        } else {
            alert("No se han realizado cambios que requieran cálculo."); // Mensaje si no hay cambios
        }
    }

    // Nueva función para actualizar con alerta
    function updateItemWithAlert(itemId, formId) {
        // Verificar si se están actualizando campos relevantes
        const lote = document.getElementById(`lote_${itemId}`).value;
        const caducidad = document.getElementById(`caducidad_${itemId}`).value;
        const ubicacion = document.getElementById(`ubicacion_${itemId}`).value;
        const cantidad = document.getElementById(`cantidad_${itemId}`).value;
        const costoUnitario = document.getElementById(`costo_${itemId}`).value;
        const iva = document.getElementById(`iva_${itemId}`).value;
        const descuento = document.getElementById(`descuento_${itemId}`).value;

        // Verificar si se están actualizando campos no relevantes
        if (!lote && !caducidad && !ubicacion) {
            // Verificar si se ha dado en calcular antes de actualizar
            if (!calculado) {
                alert("Debes dar en Calcular antes de actualizar."); // Mensaje si no se ha calculado
                return; // No continuar con la actualización
            }
        }

        // Si hay cambios en campos relevantes, se actualiza
        updateItem(itemId, formId); // Llama a la función de actualización
    }

    // Agregar listeners de eventos a los campos habilitados
    document.querySelectorAll('[id^="lote_"], [id^="caducidad_"], [id^="ubicacion_"]').forEach((input) => {
        input.addEventListener('input', function() {
            toggleActualizarButton(input.id.split('_')[1]);
        });
    });
</script>







<style>
    .compra-item {
        margin-bottom: 20px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
    }

    .compra-details {
        margin-top: 10px;
    }

    .carrito-table {
        width: 100%;
        border-collapse: collapse;
    }

    .carrito-table th {
        background-color: #007bff;
        color: white;
        padding: 10px;
    }

    .carrito-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }
</style>
<style>
    .compra-item {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .compra-details {
        margin-top: 10px;
    }

    .carrito-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
    }

    .carrito-table th {
        background-color: #0c675e;
        color: #ffffff;
        padding: 10px;
        border: 1px solid #0c675e;
    }

    .carrito-table td {
        border: 1px solid #ddd;
        padding: 8px;
        color: #333;
        text-align: center;
    }

    .carrito-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Añadir el estilo para la paginación */
    a {
        color: #0c675e;
        text-decoration: none;
        /* Elimina el subrayado */
    }

    a:hover {
        text-decoration: underline;
        /* Agrega subrayado al pasar el mouse */
    }

    strong {
        color: #0c675e;
        /* Color para el número de página actual */
    }

    .table-responsive {
        overflow-x: auto;
        /* Permitir desplazamiento horizontal */
        width: 100%;
        /* Ancho del contenedor */
    }

    .carrito-table {
        width: 100%;
        /* Ancho de la tabla */
        border-collapse: collapse;
        /* Para que las bordes no se dupliquen */
    }

    th,
    td {
        padding: 8px;
        /* Espaciado interno */
        text-align: left;
        /* Alinear texto a la izquierda */
        border: 1px solid #ddd;
        /* Bordes de las celdas */
    }
</style>