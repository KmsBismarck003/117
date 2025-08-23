<?php
include "../../conexionbd.php";
session_start();
ob_start();

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

date_default_timezone_set('America/Guatemala');

// Guardar selección de paciente lo más pronto posible para que la vista refleje el cambio inmediatamente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente'])) {
    $_SESSION['paciente_seleccionado'] = $_POST['paciente'];
}

// Helper: dado id_atencion (paciente) y item_id, devuelve array con precio aplicado, etiqueta y aseguradora
function getPriceForPacienteItem($conexion, $id_atencion, $item_id)
{
    $result = ['precio' => 0.0, 'label' => 'item_price', 'aseguradora' => ''];

    // 1) obtener id_aseg desde dat_ingreso
    $idAseg = null;
    $stmt = $conexion->prepare("SELECT id_aseg FROM dat_ingreso WHERE id_atencion = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('i', $id_atencion);
        $stmt->execute();
        $stmt->bind_result($idAseg);
        $stmt->fetch();
        $stmt->close();
    }

    $tipPrecio = null;
    // 2) obtener aseguradora y tip_precio
    if (!empty($idAseg)) {
        $stmt = $conexion->prepare("SELECT aseg, tip_precio FROM cat_aseg WHERE id_aseg = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('i', $idAseg);
            $stmt->execute();
            $asegNombre = null;
            $tipPrecio = null;
            $stmt->bind_result($asegNombre, $tipPrecio);
            $stmt->fetch();
            $stmt->close();
            $result['aseguradora'] = isset($asegNombre) ? $asegNombre : '';
        }
    }

    // 3) obtener precios del ítem (no existe campo item_price en esta tabla)
    $stmt = $conexion->prepare("SELECT item_price1, item_price2, item_price3, item_price4, item_price5, item_price6, item_price7, item_price8 FROM item_almacen WHERE item_id = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('i', $item_id);
        $stmt->execute();
        $tp1 = null;
        $tp2 = null;
        $tp3 = null;
        $tp4 = null;
        $tp5 = null;
        $tp6 = null;
        $tp7 = null;
        $tp8 = null;
        $stmt->bind_result($tp1, $tp2, $tp3, $tp4, $tp5, $tp6, $tp7, $tp8);
        $stmt->fetch();
        $stmt->close();

        // elegir precio según tip_precio
        if (is_numeric($tipPrecio)) {
            switch (intval($tipPrecio)) {
                case 1:
                    if (is_numeric($tp1)) {
                        $result['precio'] = floatval($tp1);
                        $result['label'] = 'item_price1';
                    }
                    break;
                case 2:
                    if (is_numeric($tp2)) {
                        $result['precio'] = floatval($tp2);
                        $result['label'] = 'item_price2';
                    }
                    break;
                case 3:
                    if (is_numeric($tp3)) {
                        $result['precio'] = floatval($tp3);
                        $result['label'] = 'item_price3';
                    }
                    break;
                case 4:
                    if (is_numeric($tp4)) {
                        $result['precio'] = floatval($tp4);
                        $result['label'] = 'item_price4';
                    }
                    break;
                case 5:
                    if (is_numeric($tp5)) {
                        $result['precio'] = floatval($tp5);
                        $result['label'] = 'item_price5';
                    }
                    break;
                case 6:
                    if (is_numeric($tp6)) {
                        $result['precio'] = floatval($tp6);
                        $result['label'] = 'item_price6';
                    }
                    break;
                case 7:
                    if (is_numeric($tp7)) {
                        $result['precio'] = floatval($tp7);
                        $result['label'] = 'item_price7';
                    }
                    break;
                case 8:
                    if (is_numeric($tp8)) {
                        $result['precio'] = floatval($tp8);
                        $result['label'] = 'item_price8';
                    }
                    break;
            }
        }

        // fallback: si no se determinó precio por tip_precio, buscar el primer item_priceN numérico (1..8)
        if ($result['precio'] === 0.0) {
            $tpList = [$tp1, $tp2, $tp3, $tp4, $tp5, $tp6, $tp7, $tp8];
            foreach ($tpList as $idx => $val) {
                if (is_numeric($val)) {
                    $result['precio'] = floatval($val);
                    $result['label'] = 'item_price' . ($idx + 1);
                    break;
                }
            }
            if ($result['precio'] === 0.0) {
                $result['label'] = 'none';
            }
        }
    }

    return $result;
}

if (isset($usuario['id_rol'])) {
    if ($usuario['id_rol'] == 7 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5 || $usuario['id_rol'] == 1 || $usuario['id_rol'] == 9) {
        include "../header_farmaciaq.php";
    } else {
        session_unset();
        session_destroy();
        echo "<script>window.location='../../index.php';</script>";
        exit();
    }
}

$sqlPac = "
    SELECT 
        di.id_atencion, 
        CONCAT(p.nom_pac, ' ', p.papell, ' ', p.sapell) AS nombre_paciente
    FROM 
        dat_ingreso di
    JOIN 
        paciente p ON di.Id_exp = p.Id_exp
    WHERE 
        di.activo = 'SI'
";
$resultPac = $conexion->query($sqlPac);


$pacientesOptions = '';
if ($resultPac && $resultPac->num_rows > 0) {
    while ($paciente = $resultPac->fetch_assoc()) {
        // Preferir el valor enviado por POST en esta misma carga; sino usar el de sesión
        $isSelected = false;
        if (isset($_POST['paciente']) && $_POST['paciente'] == $paciente['id_atencion']) {
            $isSelected = true;
        } elseif (isset($_SESSION['paciente_seleccionado']) && $_SESSION['paciente_seleccionado'] == $paciente['id_atencion']) {
            $isSelected = true;
        }
        $selected = $isSelected ? 'selected' : '';
        $pacientesOptions .= "<option value='{$paciente['id_atencion']}' $selected>{$paciente['nombre_paciente']}</option>";
    }
}

// (El guardado de la selección ya se realiza antes de construir las opciones)




$queryMedicamentos = "SELECT DISTINCT 
    ea.item_id, 
    ia.item_name,
    ia.item_grams
    FROM existencias_almacenq ea 
    JOIN item_almacen ia ON ea.item_id = ia.item_id 
    ORDER BY ia.item_name
";
$resultMedicamentos = $conexion->query($queryMedicamentos);

$medicamentosOptions = '';
if ($resultMedicamentos && $resultMedicamentos->num_rows > 0) {
    while ($medicamento = $resultMedicamentos->fetch_assoc()) {
        // Mantener seleccionado el medicamento si ya ha sido seleccionado en una recarga de página
        $selected = (isset($_POST['medicamento']) && $_POST['medicamento'] == $medicamento['item_id']) ? 'selected' : '';
        $grams = isset($medicamento['item_grams']) ? trim($medicamento['item_grams']) : '';
        $displayName = $medicamento['item_name'] . ($grams !== '' ? ' ' . $grams : '');
        $medicamentosOptions .= "<option value='" . htmlspecialchars($medicamento['item_id']) . "' $selected>" . htmlspecialchars($displayName) . "</option>";
    }
}

// Obtener los lotes y la suma total de existencias para el medicamento seleccionado
$lotesOptions = '';
$totalExistencias = 0; // Variable para el total de existencias
if (isset($_POST['medicamento'])) {
    $itemId = intval($_POST['medicamento']);

    // Primero, obtener el total de existencias de este medicamento
    $sqlTotalExistencias = "
        SELECT SUM(ea.existe_qty) AS total_existencias
        FROM existencias_almacenq ea
        WHERE ea.item_id = $itemId
    ";
    $resultTotalExistencias = $conexion->query($sqlTotalExistencias);
    if ($resultTotalExistencias && $resultTotalExistencias->num_rows > 0) {
        $row = $resultTotalExistencias->fetch_assoc();
        $totalExistencias = $row['total_existencias'];
    }

    // Ahora obtenemos los lotes disponibles para este medicamento
    $sqlLotes = "
    SELECT 
        ea.existe_lote, ea.existe_caducidad, ea.existe_qty, ea.existe_id
    FROM 
        existencias_almacenq ea
    WHERE 
        ea.item_id = ? AND ea.existe_qty > 0
    ORDER BY 
        ea.existe_caducidad ASC
    ";

    // Preparar la consulta
    $stmt = $conexion->prepare($sqlLotes);
    // Vincular el parámetro de entrada (el id del medicamento)
    $stmt->bind_param('i', $itemId); // 'i' indica que el parámetro es un entero
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener los resultados
    $resultLotes = $stmt->get_result();
    // Comprobar si hay resultados
    $lotesOptions = '';
    if ($resultLotes && $resultLotes->num_rows > 0) {
        while ($lote = $resultLotes->fetch_assoc()) {
            $lotesOptions .= "<option value='{$lote['existe_id']}|{$lote['existe_lote']}' data-caducidad='{$lote['existe_caducidad']}' data-cantidad='{$lote['existe_qty']}'>\n     {$lote['existe_lote']} / {$lote['existe_caducidad']} / {$lote['existe_qty']}\n</option>";
        }
    } else {
        $lotesOptions .= "<option value='' disabled>No hay lotes disponibles</option>";
    }

    // Cerrar la declaración
    $stmt->close();
}

// Preparar variables para mostrar aseguradora y precio aplicado en la vista
$aseguradoraNombre = '';
$precioAplicado = null;
$precioLabel = '';

// Determinar paciente y medicamento seleccionados (puede venir por POST o sesión)
$selectedPaciente = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente'])) {
    $selectedPaciente = intval($_POST['paciente']);
} elseif (isset($_SESSION['paciente_seleccionado'])) {
    $selectedPaciente = intval($_SESSION['paciente_seleccionado']);
}
$selectedMedicamento = isset($_POST['medicamento']) ? intval($_POST['medicamento']) : null;

if (!empty($selectedPaciente) && !empty($selectedMedicamento)) {
    // Usar helper para determinar precio aplicado y aseguradora
    $priceInfo = getPriceForPacienteItem($conexion, $selectedPaciente, $selectedMedicamento);
    $precioAplicado = $priceInfo['precio'];
    $precioLabel = $priceInfo['label'];
    $aseguradoraNombre = $priceInfo['aseguradora'];

    // Obtener el IVA del item para mostrar en la vista (campo en item_almacen suele ser decimal, ej 0.16)
    $itemIva = 0.0;
    $stmtIva = $conexion->prepare("SELECT iva FROM item_almacen WHERE item_id = ? LIMIT 1");
    if ($stmtIva) {
        $stmtIva->bind_param('i', $selectedMedicamento);
        $stmtIva->execute();
        $stmtIva->bind_result($tmpIva);
        $stmtIva->fetch();
        $stmtIva->close();
        if (is_numeric($tmpIva)) {
            $itemIva = floatval($tmpIva);
        }
    }
}

// Captura del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente']) && isset($_POST['medicamento']) && isset($_POST['lote']) && isset($_POST['cantidad'])) {
    list($existeId, $nombreLote) = explode('|', $_POST['lote']); // Extraer existe_id y nombre del lote

    // Consulta para obtener el id_atencion
    $sqlAtencion = "SELECT id_atencion FROM dat_ingreso WHERE Id_exp = (SELECT Id_exp FROM dat_ingreso WHERE id_atencion = ?)";
    $stmtAtencion = $conexion->prepare($sqlAtencion);
    $stmtAtencion->bind_param('i', $_POST['paciente']);
    $stmtAtencion->execute();
    $stmtAtencion->bind_result($idAtencion);
    $stmtAtencion->fetch();
    $stmtAtencion->close();

    // Guardar el id_atencion en la sesión
    $_SESSION['id_atencion'] = $idAtencion;


    $sqlPacienteNombre = "SELECT CONCAT(nom_pac, ' ', papell, ' ', sapell) AS nombre_paciente FROM paciente WHERE Id_exp = (SELECT Id_exp FROM dat_ingreso WHERE id_atencion = ?)";
    $stmtPaciente = $conexion->prepare($sqlPacienteNombre);
    $stmtPaciente->bind_param('i', $_POST['paciente']);
    $stmtPaciente->execute();
    $stmtPaciente->bind_result($nombrePaciente);
    $stmtPaciente->fetch();
    $stmtPaciente->close();

    // Obtener el nombre, precio y gramos del medicamento
    $itemId = intval($_POST['medicamento']);
    // Primero obtener el id_aseg del paciente seleccionado (desde dat_ingreso)
    $idAseg = null;
    $stmtAseg = $conexion->prepare("SELECT id_aseg FROM dat_ingreso WHERE id_atencion = ? LIMIT 1");
    if ($stmtAseg) {
        $stmtAseg->bind_param('i', $_POST['paciente']);
        $stmtAseg->execute();
        $stmtAseg->bind_result($idAseg);
        $stmtAseg->fetch();
        $stmtAseg->close();
    }

    // Obtener tip_precio desde cat_aseg usando id_aseg
    $tipPrecio = null;
    if (!empty($idAseg)) {
        $stmtTip = $conexion->prepare("SELECT tip_precio FROM cat_aseg WHERE id_aseg = ? LIMIT 1");
        if ($stmtTip) {
            $stmtTip->bind_param('i', $idAseg);
            $stmtTip->execute();
            $stmtTip->bind_result($tipPrecio);
            $stmtTip->fetch();
            $stmtTip->close();
        }
    }

    // Obtener datos básicos del ítem (nombre, gramos, iva) y precio usando helper
    $sqlMedicamentoNombre = "SELECT item_name, item_grams, iva FROM item_almacen WHERE item_id = ? LIMIT 1";
    $stmtMedicamento = $conexion->prepare($sqlMedicamentoNombre);
    if ($stmtMedicamento) {
        $stmtMedicamento->bind_param('i', $itemId);
        $stmtMedicamento->execute();
        $stmtMedicamento->bind_result($nombreMedicamento, $itemGrams, $itemIva);
        $stmtMedicamento->fetch();
        $stmtMedicamento->close();

        // Obtener precio aplicado usando helper centralizado
        $priceInfoForm = getPriceForPacienteItem($conexion, intval($_POST['paciente']), $itemId);
        $precioMedicamento = $priceInfoForm['precio'];
        $itemIva = isset($itemIva) ? floatval($itemIva) : 0.0; // porcentaje, ej. 12
    } else {
        error_log('Error preparar consulta medicamento: ' . $conexion->error);
        $nombreMedicamento = '';
        $precioMedicamento = 0.0;
        $itemGrams = '';
    }


    // Verificar si el botón "Agregar" ha sido presionado
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
        // Captura del formulario


        // Insertar en tabla carrito_surtir_paciente
        $cantidadAgregar = intval($_POST['cantidad']);
        if ($cantidadAgregar <= 0) {
            echo "<script>alert('Cantidad inválida'); window.location.href='surtir_pacienteq.php';</script>";
            exit();
        }

        // Obtener stock actual del lote en existencias_almacenq
        $existeQty = 0;
        $stmtStock = $conexion->prepare("SELECT existe_qty FROM existencias_almacenq WHERE existe_id = ?");
        if ($stmtStock) {
            $stmtStock->bind_param('i', $existeId);
            $stmtStock->execute();
            $stmtStock->bind_result($existeQty);
            $stmtStock->fetch();
            $stmtStock->close();
        }

        // Obtener la suma de cantidades ya presentes en el carrito para este existe_id
        $sumInCart = 0;
        $stmtCartSum = $conexion->prepare("SELECT COALESCE(SUM(cantidad),0) FROM carrito_surtir_paciente WHERE existe_id = ?");
        if ($stmtCartSum) {
            $stmtCartSum->bind_param('i', $existeId);
            $stmtCartSum->execute();
            $stmtCartSum->bind_result($sumInCart);
            $stmtCartSum->fetch();
            $stmtCartSum->close();
        }

        // Validar que la suma (en carrito + nueva) no exceda el stock disponible
        if (!is_numeric($existeQty)) {
            echo "<script>alert('Error: no se pudo obtener el stock del lote seleccionado.'); window.location.href='surtir_pacienteq.php';</script>";
            exit();
        }

        if (($sumInCart + $cantidadAgregar) > intval($existeQty)) {
            $available = intval($existeQty) - intval($sumInCart);
            if ($available < 0) $available = 0;
            echo "<script>alert('No hay suficiente stock. En existencias: $existeQty. Ya en carrito: $sumInCart. Disponible para agregar: $available.'); window.location.href='surtir_pacienteq.php';</script>";
            exit();
        }

        $insertCart = "INSERT INTO carrito_surtir_paciente (id_usua, id_atencion, id_aseg, paciente, item_id, medicamento, item_grams, lote, existe_id, cantidad, precio, iva, subtotal, total, creado_en) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmtCart = $conexion->prepare($insertCart);
    if ($stmtCart) {
            // asegurar precio como double y tipos correctos: i(id_usua), i(id_atencion), s(paciente), i(item_id), s(medicamento), s(lote), i(existe_id), i(cantidad), d(precio)
            $precioMedicamento = isset($precioMedicamento) ? floatval($precioMedicamento) : 0.0;
            // calcular subtotal, iva y total
            // Regla: IVA = (iva de item_almacen) * subtotal; Total = subtotal + IVA
            $subtotal = floatval($cantidadAgregar) * $precioMedicamento;
            $ivaAmount = 0.0;
            if (is_numeric($itemIva) && floatval($itemIva) != 0.0) {
                $ivaAmount = $subtotal * floatval($itemIva);
            }
            $totalLinea = $subtotal + $ivaAmount;
            // tipos: i(id_usua), i(id_atencion), s(paciente), i(item_id), s(medicamento), s(item_grams), s(lote), i(existe_id), i(cantidad), d(precio)
            // nuevos tipos: i,i,i,s,i,s,s,s,i,i,d,d,d,d
            $stmtCart->bind_param('iiisisssiidddd', $id_usua, $idAtencion, $idAseg, $nombrePaciente, $itemId, $nombreMedicamento, $itemGrams, $nombreLote, $existeId, $cantidadAgregar, $precioMedicamento, $ivaAmount, $subtotal, $totalLinea);
            if (!$stmtCart->execute()) {
                $msg = 'Error al insertar en carrito_surtir_paciente: ' . $stmtCart->error;
                error_log($msg);
                header('Location: surtir_pacienteq.php?envio=error&mensaje=' . urlencode($msg));
                exit();
            }
            $stmtCart->close();
        } else {
            $msg = 'Error al preparar insert carrito: ' . $conexion->error;
            error_log($msg);
            header('Location: surtir_pacienteq.php?envio=error&mensaje=' . urlencode($msg));
            exit();
        }

        header('Location: surtir_pacienteq.php?success=1');
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_index'])) {
    $index = intval($_POST['eliminar_index']); // Asegurarse de que sea un número entero
    if (isset($_SESSION['medicamento_seleccionado'][$index])) {
        unset($_SESSION['medicamento_seleccionado'][$index]); // Eliminar el registro
        $_SESSION['medicamento_seleccionado'] = array_values($_SESSION['medicamento_seleccionado']); // Reindexar array
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['enviar_medicamentos'])) {
    $fechaActual = date('Y-m-d H:i:s');

    // Obtener registros únicamente desde la tabla carrito_surtir_paciente
    $carritoItems = [];
    $carritoProcessedIds = [];
    $sqlCarrito = "SELECT id, id_usua, id_atencion, id_aseg, paciente, item_id, medicamento, lote, existe_id, cantidad, precio, iva, subtotal, total FROM carrito_surtir_paciente ORDER BY creado_en";
    $resCarrito = $conexion->query($sqlCarrito);
    if ($resCarrito && $resCarrito->num_rows > 0) {
        while ($r = $resCarrito->fetch_assoc()) {
            $carritoItems[] = [
                'carrito_id' => $r['id'],
                'id_usua' => $r['id_usua'],
                'id_atencion' => $r['id_atencion'],
                'id_aseg' => isset($r['id_aseg']) ? $r['id_aseg'] : null,
                'paciente' => $r['paciente'],
                'medicamento' => $r['medicamento'],
                'item_id' => $r['item_id'],
                'lote' => $r['lote'],
                'existe_id' => $r['existe_id'],
                'cantidad' => $r['cantidad'],
                'precio' => $r['precio'],
                'iva' => isset($r['iva']) ? $r['iva'] : 0,
                'subtotal' => isset($r['subtotal']) ? $r['subtotal'] : 0
            ];
        }
    }

    if (empty($carritoItems)) {
        echo "<script>alert('No hay registros en la memoria para procesar.'); window.location.href = 'surtir_pacienteq.php';</script>";
        exit();
    }

    // Iniciar transacción
    $conexion->begin_transaction();

    try {
        foreach ($carritoItems as $index => $medicamento) {
            $paciente = $medicamento['paciente'];
            $nombreMedicamento = $medicamento['medicamento'];
            $loteNombre = $medicamento['lote'];
            $cantidadLote = $medicamento['cantidad'];
            $existeId = $medicamento['existe_id'];
            $Id_Atencion = $medicamento['id_atencion'];

            // *** 1. Usar el item_id tal como viene almacenado en carrito_surtir_paciente ***
            // El registro proviene de la tabla `carrito_surtir_paciente` y ya contiene el campo item_id,
            // por lo que no es necesario volver a buscarlo por nombre.
            $itemId = isset($medicamento['item_id']) ? intval($medicamento['item_id']) : null;
            if (empty($itemId)) {
                // Si por algún motivo no existe item_id en el carrito, abortar la transacción
                $carritoIdInfo = isset($medicamento['carrito_id']) ? $medicamento['carrito_id'] : 'desconocido';
                throw new Exception("Error: item_id no presente en registro del carrito (carrito_id: $carritoIdInfo).");
            }

            // Obtener nombre del ítem
            $queryItemAlmacenn = "SELECT item_name FROM item_almacen WHERE item_id = ?";
            $stmt = $conexion->prepare($queryItemAlmacenn);
            $stmt->bind_param("i", $itemId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $itemData = $result->fetch_assoc();
                $itemName = $itemData['item_name'];
            } else {
                exit("Error: No se encontró el ítem con ID $itemId.");
            }

            // Determinar costo de salida: preferir el precio guardado en el carrito, si existe
            $salidaCostsu = 0.0;
            if (isset($medicamento['precio']) && is_numeric($medicamento['precio'])) {
                $salidaCostsu = floatval($medicamento['precio']);
            } else {
                // Calcular precio según aseguradora y tip_precio
                $priceInfoK = getPriceForPacienteItem($conexion, $Id_Atencion, $itemId);
                $salidaCostsu = isset($priceInfoK['precio']) ? floatval($priceInfoK['precio']) : 0.0;
            }


            // *** 2. Obtener existencias actuales del lote desde existencias_almacenq ***
            $selectExistenciasQuery = "SELECT existe_qty, existe_caducidad, existe_salidas FROM existencias_almacenq WHERE existe_id = ?";
            $stmtSelect = $conexion->prepare($selectExistenciasQuery);
            $stmtSelect->bind_param('i', $existeId);
            $stmtSelect->execute();
            if (!$stmtSelect) {
                throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
            }
            $stmtSelect->bind_result($existeQty, $caducidad, $existeSalidas);
            $stmtSelect->fetch();
            $stmtSelect->close();


            // *** 4. Calcular nuevos valores para existencias ***
            $nuevaExistenciaQty = $existeQty - $cantidadLote;
            $nuevaExistenciaSalidas = $existeSalidas + $cantidadLote;


            // Validar si hay suficiente stock
            if ($existeQty < $cantidadLote) {
                echo "<script>
                alert('Error: El lote \"$loteNombre\" no tiene suficiente stock. Disponible: $existeQty, requerido: $cantidadLote.');
                window.location.href = 'surtir_pacienteq.php';
                </script>";
                exit;
            }


            // *** 6. Insertar en kardex_almacenq ***
            $insert_kardex = "
               INSERT INTO kardex_almacenq (
                   kardex_fecha, item_id, kardex_lote, kardex_caducidad, kardex_inicial, kardex_entradas, kardex_salidas, kardex_qty, 
                   kardex_dev_stock, kardex_dev_merma, kardex_movimiento, kardex_destino, id_surte
               ) 
               VALUES (NOW(), ?, ?, ?, 0, 0, ?, 0, 0, 0, 'Surtir Paciente', 'QUIROFANO', ?)
           ";
            $stmt_kardex = $conexion->prepare($insert_kardex);
            if (!$stmt_kardex) {
                throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
            }
            $stmt_kardex->bind_param('issii', $itemId, $loteNombre, $caducidad, $cantidadLote, $id_usua);
            if (!$stmt_kardex->execute()) {
                throw new Exception("Error al insertar en kardex_almacenq: " . $stmt_kardex->error);
            }
            $stmt_kardex->close();



            // *** 7. Insertar en salidas_almacenq ***
            $queryInsercion = "
                INSERT INTO salidas_almacenq (
                    item_id, 
                    item_name, 
                    salida_fecha, 
                    salida_lote, 
                    salida_caducidad, 
                    salida_qty, 
                    salida_costsu, 
                    id_usua, 
                    id_atencion,
                    id_aseg,
                    solicita, 
                    fecha_solicitud,
                    tipo,
                    salio
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NULL, ?, ?)
             ";
            $stmtInsertSalida = $conexion->prepare($queryInsercion);
            if (!$stmtInsertSalida) {
                throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
            }

            // Valores fijos solicitados
            $tipoSalida = 'Surtir Paciente';
            $salioDestino = 'QUIROFANO';

            $idAsegCar = isset($medicamento['id_aseg']) ? intval($medicamento['id_aseg']) : null;

            $stmtInsertSalida->bind_param(
                "issssidiiiss",
                $itemId,
                $nombreMedicamento,
                $fechaActual,
                $loteNombre,
                $caducidad,
                $cantidadLote,
                $salidaCostsu,
                $id_usua,
                $Id_Atencion,
                $idAsegCar,
                $tipoSalida,
                $salioDestino
            );

            if (!$stmtInsertSalida->execute()) {
                throw new Exception("Error al insertar en salidas_almacenq: " . $stmtInsertSalida->error);
            }
            $salidaId = $conexion->insert_id;
            $stmtInsertSalida->close();

            $insertDatCtapacQuery = "
                            INSERT INTO dat_ctapac (
                                    id_atencion, 
                                    prod_serv, 
                                    insumo, 
                                    cta_fec, 
                                    cta_cant, 
                                    cta_tot, 
                                    id_usua, 
                                    cta_activo, 
                                    salida_id, 
                                    existe_lote, 
                                    existe_caducidad,
                                    importe_iva,
                                    subtotal
                            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                     ";

            $stmtInsertDatCtapac = $conexion->prepare($insertDatCtapacQuery);
            if (!$stmtInsertDatCtapac) {
                throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
            }
            $prodServ = 'P';
            $ctaActivo = 'SI';

            $precioCarrito = isset($medicamento['precio']) ? floatval($medicamento['precio']) : (isset($salidaCostsu) ? floatval($salidaCostsu) : 0.0);
            $ctaTot = floatval($cantidadLote) * $precioCarrito;
            $importeIva = isset($medicamento['iva']) ? floatval($medicamento['iva']) : 0.0;
            $subtotalLinea = isset($medicamento['subtotal']) ? floatval($medicamento['subtotal']) : (floatval($cantidadLote) * $precioCarrito);

            $stmtInsertDatCtapac->bind_param(
                'isisidisissdd',
                $Id_Atencion,
                $prodServ,
                $itemId,
                $fechaActual,
                $cantidadLote,
                $ctaTot,
                $id_usua,
                $ctaActivo,
                $salidaId,
                $loteNombre,
                $caducidad,
                $importeIva,
                $subtotalLinea
            );

            if (!$stmtInsertDatCtapac->execute()) {
                throw new Exception("Error al insertar en dat_ctapac: " . $stmtInsertDatCtapac->error);
            }
            $stmtInsertDatCtapac->close();

            $updateExistenciasQuery = "UPDATE existencias_almacenq SET existe_qty = ?, existe_fecha = ?, existe_salidas = ? WHERE existe_id = ?";
            $stmtUpdateExistencias = $conexion->prepare($updateExistenciasQuery);
            if (!$stmtUpdateExistencias) {
                throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
            }
            $stmtUpdateExistencias->bind_param('isii', $nuevaExistenciaQty, $fechaActual, $nuevaExistenciaSalidas, $existeId);
            if (!$stmtUpdateExistencias->execute()) {
                throw new Exception("Error al actualizar las existencias: " . $stmtUpdateExistencias->error);
            }
            $stmtUpdateExistencias->close();

            // Si el item provino de la tabla carrito, almacenar su id para marcarlo como procesado
            if (isset($medicamento['carrito_id'])) {
                $carritoProcessedIds[] = intval($medicamento['carrito_id']);
            }
        }

    // Confirmar la transacción
    $conexion->commit();


        // Eliminar registros procesados del carrito si aplica
        if (!empty($carritoProcessedIds)) {
            $placeholders = implode(',', array_fill(0, count($carritoProcessedIds), '?'));
            $types = str_repeat('i', count($carritoProcessedIds));
            $sqlDel = "DELETE FROM carrito_surtir_paciente WHERE id IN ($placeholders)";
            $stmtDel = $conexion->prepare($sqlDel);
            if ($stmtDel) {
                // bind_param requires references
                $params = array_map('intval', $carritoProcessedIds);
                $bindNames = [];
                $bindNames[] = $types;
                foreach ($params as $k => $v) {
                    $bindNames[] = &$params[$k];
                }
                call_user_func_array(array($stmtDel, 'bind_param'), $bindNames);
                $stmtDel->execute();
                $stmtDel->close();
            }
        }

        // Limpiar la sesión (opcional)
        unset($_SESSION['medicamento_seleccionado']);

    header("Location: surtir_pacienteq.php?envio=success");
    exit();
    } catch (Exception $e) {
    $conexion->rollback(); // Revertir cambios
    $msg = 'Error al procesar el envío: ' . $e->getMessage();
    error_log($msg);
    header('Location: surtir_pacienteq.php?envio=error&mensaje=' . urlencode($msg));
    exit();
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Copiado exactamente desde surtir.php */
        .form-container {
            /* Hacer el contenedor más ancho y centrado */
            width: 95%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(43, 45, 127, 0.15);
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2b2d7f, #4a4eb7, #2b2d7f);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2b2d7f;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        label::before {
            content: '•';
            color: #2b2d7f;
            font-weight: bold;
            font-size: 18px;
        }

        select,
        input {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 20px;
            border: 2px solid #e8ebff;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
            box-sizing: border-box;
        }

        select:focus,
        input:focus {
            outline: none;
            border-color: #2b2d7f;
            box-shadow: 0 0 0 3px rgba(43, 45, 127, 0.1);
            transform: translateY(-1px);
        }

        select:hover,
        input:hover {
            border-color: #4a4eb7;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2b2d7f 0%, #1a1c5a 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(43, 45, 127, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 160px;
            justify-content: center;
            flex: 1;
            max-width: 200px;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #16a085 0%, #138d75 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(22, 160, 133, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 160px;
            justify-content: center;
            flex: 1;
            max-width: 200px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(43, 45, 127, 0.4);
            background: linear-gradient(135deg, #3a3d8f 0%, #2a2c6a 100%);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(22, 160, 133, 0.4);
            background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
        }

        button:disabled {
            background: #bdc3c7 !important;
            cursor: not-allowed !important;
            transform: none !important;
            box-shadow: none !important;
        }

        .top-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
            margin: 0 auto;
        }

        /* Estilos para iconos */
        .fas {
            margin-right: 8px;
        }

        .btn-primary .fas,
        .btn-secondary .fas {
            margin-right: 8px;
            font-size: 14px;
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Estilos de tabla mejorados */
        /* Contenedor general ancho y centrado para secciones de tabla */
        .container-main {
            /* Ocupa todo el ancho disponible del contenedor padre */
            width: 100%;
            margin: 0 auto;
        }

        table {
            width: 100% !important;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(43, 45, 127, 0.15);
            animation: fadeInUp 0.6s ease-out;
            /* Forzar que todas las columnas entren en el ancho disponible */
            table-layout: fixed;
        }

        table thead {
            background: linear-gradient(135deg, #2b2d7f 0%, #1a1c5a 100%);
            color: white;
        }

        table thead th {
            padding: 16px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            border-bottom: none;
            position: relative;
            white-space: normal;
            /* Permitir salto de línea */
            word-break: break-word;
            /* Romper palabras largas */
            overflow-wrap: anywhere;
            /* Ajustar contenido */
        }

        table thead th:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 20%;
            height: 60%;
            width: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e8ebff;
        }

        table tbody tr:nth-child(odd) {
            background: #f8f9ff;
        }

        table tbody tr:hover {
            background: #e8ebff !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(43, 45, 127, 0.1);
        }

        table tbody td {
            padding: 16px 15px;
            font-size: 15px;
            color: #333;
            vertical-align: middle;
            border-bottom: 1px solid #e8ebff;
            word-break: break-word;
            overflow-wrap: anywhere;
            white-space: normal;
        }

        table tbody td:first-child {
            font-weight: 600;
            color: #2b2d7f;
        }

        /* Contenedor y alineación para la tabla del carrito (similar a existenciasq) */
        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow-x: hidden;
            /* Sin barra horizontal */
            width: 100%;
            margin: 0 auto;
            /* Centrar el contenedor */
        }

        /* Asegurar que el body no muestre scroll horizontal por estilos heredados */
        body {
            overflow-x: hidden;
        }

        /* Alineación de columnas específicas */
        #cart-table thead th:nth-child(2),
        #cart-table thead th:nth-child(3),
        #cart-table thead th:nth-child(4) {
            text-align: left;
        }

        #cart-table tbody td:nth-child(2),
        #cart-table tbody td:nth-child(3),
        #cart-table tbody td:nth-child(4) {
            text-align: left;
        }

        #cart-table thead th:nth-child(1),
        #cart-table thead th:nth-child(5),
        #cart-table thead th:nth-child(6),
        #cart-table thead th:nth-child(7),
        #cart-table thead th:nth-child(8),
        #cart-table thead th:nth-child(9),
        #cart-table thead th:nth-child(10) {
            text-align: center;
        }

        #cart-table tbody td:nth-child(1),
        #cart-table tbody td:nth-child(5),
        #cart-table tbody td:nth-child(6),
        #cart-table tbody td:nth-child(7),
        #cart-table tbody td:nth-child(8),
        #cart-table tbody td:nth-child(9),
        #cart-table tbody td:nth-child(10) {
            text-align: center;
        }

        /* Dejar que el navegador distribuya los anchos para evitar overflow */
        #cart-table thead th,
        #cart-table tbody td {
            width: auto !important;
        }

        /* Botón rojo estilo existencias */
        .btn-danger-custom {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
        }

        .btn-danger-custom:hover {
            background: linear-gradient(45deg, #c82333, #bd2130);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.35);
            color: #fff;
        }

        .actions-row {
            display: flex;
            justify-content: center;
            /* Centrar botón eliminar seleccionados */
            margin: 10px 0;
        }

        /* Botones dentro de tabla */
        .btn-sm {
            padding: 10px 16px !important;
            font-size: 14px !important;
            min-width: 100px !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            margin: 2px !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                margin: 10px;
                padding: 20px;
            }

            .button-container {
                flex-direction: column;
                align-items: center;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                max-width: none;
                margin-bottom: 10px;
            }

            .btn-secondary {
                margin-bottom: 0;
            }

            table thead th,
            table tbody td {
                padding: 12px 10px;
                font-size: 14px;
            }

            .btn-sm {
                padding: 8px 12px !important;
                font-size: 12px !important;
                min-width: 80px !important;
            }

            /* En móviles evitar scroll horizontal, permitir ajuste */
            table {
                table-layout: auto;
            }

            .container-main {
                max-width: 100%;
                padding: 0 10px;
            }
        }
    </style>

</head>

<body>
    <!-- Botón superior con mismo margen arriba y abajo -->
    <div class="d-flex justify-content-start" style="margin: 20px 0; margin-left: 20px;">
        <div class="d-flex">
            <!-- Botón Regresar -->
            <a href="../../template/menu_farmaciahosp.php"
                style="color: white; background: linear-gradient(135deg, #2b2d7f 0%, #1a1c5a 100%);
            border: none; border-radius: 8px; padding: 10px 16px; cursor: pointer; display: inline-block; 
            text-decoration: none; box-shadow: 0 2px 8px rgba(43, 45, 127, 0.3); 
            transition: all 0.3s ease; margin-right: 10px;">
                ← Regresar
            </a>
        </div>
    </div>


    <div class="form-container">
        <div class="thead" style="background: linear-gradient(135deg, #2b2d7f 0%, #1a1c5a 100%); margin: 5px auto; padding: 15px 25px; color: white; width: fit-content; text-align: center; border-radius: 15px; box-shadow: 0 4px 15px rgba(43, 45, 127, 0.3);">
            <h1 style="font-size: 28px; margin: 0; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"><i class="fas fa-pills"></i> SURTIR PACIENTE</h1>
        </div>
        <br>

        <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '<i class="fas fa-check-circle" style="color: #28a745;"></i> Agregado correctamente',
                        html: '<div style="text-align: center; font-size: 16px;">' +
                            '<i class="fas fa-pills" style="color: #2b2d7f; font-size: 24px; margin-bottom: 10px;"></i><br>' +
                            'El medicamento se ha agregado al carrito exitosamente.' +
                            '</div>',
                        icon: 'success',
                        timer: 7000,
                        showConfirmButton: false,
                        timerProgressBar: true
                    });
                });
            </script>
        <?php endif; ?>

        <?php
        $showElim = false;
        if (isset($_SESSION['flash_eliminated']) && $_SESSION['flash_eliminated'] == 1) {
            $showElim = true;
            unset($_SESSION['flash_eliminated']);
        }
        if (isset($_GET['eliminated']) && $_GET['eliminated'] == '1') {
            // Compatibilidad con enlaces antiguos: mostrar y limpiar querystring
            $showElim = true;
        }
        ?>
        <?php if ($showElim): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '<i class="fas fa-trash-alt" style="color: #dc3545;"></i> Eliminado correctamente',
                        html: '<div style="text-align: center; font-size: 16px;">' +
                            '<i class="fas fa-trash" style="color: #dc3545; font-size: 24px; margin-bottom: 10px;"></i><br>' +
                            'El medicamento se ha eliminado del carrito exitosamente.' +
                            '</div>',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false,
                        timerProgressBar: true
                    });
                    // Quitar parámetros de la URL para evitar que reaparezca al enviar selects
                    if (window.history.replaceState) {
                        const url = new URL(window.location.href);
                        url.searchParams.delete('eliminated');
                        window.history.replaceState({}, document.title, url.pathname + (url.search ? '?' + url.search : '') + url.hash);
                    }
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'stock'): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '⚠️ Stock insuficiente',
                        html: '<div style="text-align: left; font-size: 16px;">' +
                            '<p style="margin-bottom: 15px;">No puedes agregar <strong><?= htmlspecialchars($_GET['cantidad_solicitada'] ?? '0') ?></strong> unidades.</p>' +
                            '<div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545;">' +
                            '<p style="margin: 5px 0;"><i class="fas fa-boxes" style="color: #28a745; margin-right: 8px;"></i><strong>Stock disponible:</strong> <?= htmlspecialchars($_GET['stock_disponible'] ?? '0') ?></p>' +
                            '<p style="margin: 5px 0;"><i class="fas fa-shopping-cart" style="color: #ffc107; margin-right: 8px;"></i><strong>Ya en carrito:</strong> <?= htmlspecialchars($_GET['en_carrito'] ?? '0') ?></p>' +
                            '<p style="margin: 5px 0;"><i class="fas fa-check-circle" style="color: #17a2b8; margin-right: 8px;"></i><strong>Cantidad máxima permitida:</strong> <?= htmlspecialchars($_GET['cantidad_permitida'] ?? '0') ?></p>' +
                            '</div>' +
                            '</div>',
                        icon: 'error',
                        timer: 7000,
                        showConfirmButton: true,
                        confirmButtonText: '<i class="fas fa-check"></i> Entendido',
                        timerProgressBar: true,
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'cantidad_invalida'): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: '<i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i> Cantidad inválida',
                        html: '<div style="text-align: center; font-size: 16px;">' +
                            '<i class="fas fa-calculator" style="color: #dc3545; font-size: 24px; margin-bottom: 10px;"></i><br>' +
                            'La cantidad debe ser mayor a <strong>0</strong>.<br>' +
                            '<small style="color: #6c757d;">Por favor, ingresa una cantidad válida.</small>' +
                            '</div>',
                        icon: 'warning',
                        timer: 5000,
                        showConfirmButton: true,
                        confirmButtonText: '<i class="fas fa-check"></i> Entendido',
                        timerProgressBar: true,
                        customClass: {
                            confirmButton: 'btn btn-warning'
                        }
                    });
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_GET['envio'])): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    <?php if ($_GET['envio'] == 'success'): ?>
                        Swal.fire({
                            title: '<i class="fas fa-rocket" style="color: #28a745;"></i> ¡Éxito!',
                            html: '<div style="text-align: center; font-size: 16px;">' +
                                '<i class="fas fa-check-double" style="color: #28a745; font-size: 24px; margin-bottom: 10px;"></i><br>' +
                                'Todos los medicamentos se han registrado correctamente.' +
                                '</div>',
                            icon: 'success',
                            timer: 7000,
                            showConfirmButton: true,
                            confirmButtonText: '<i class="fas fa-thumbs-up"></i> Perfecto',
                            timerProgressBar: true,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    <?php elseif ($_GET['envio'] == 'error'): ?>
                        <?php
                        $mensajeError = isset($_GET['mensaje']) ? htmlspecialchars(urldecode($_GET['mensaje'])) : 'Error desconocido';
                        // Detectar y resaltar el nombre de la tabla
                        $tablas = ['ITEM_ALMACEN', 'EXISTENCIAS_ALMACENQ', 'KARDEX_ALMACENQ', 'SALIDAS_ALMACENQ', 'DAT_CTAPAC'];
                        $mensajeFormateado = $mensajeError;
                        foreach ($tablas as $tabla) {
                            $mensajeFormateado = str_replace($tabla, '<span style="background: #dc3545; color: white; padding: 2px 6px; border-radius: 4px; font-weight: bold; font-family: monospace;">' . $tabla . '</span>', $mensajeFormateado);
                        }
                        ?>
                        Swal.fire({
                            title: '<i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i> Error en Base de Datos',
                            html: '<div style="text-align: left; font-size: 15px; background: #fff5f5; padding: 20px; border-radius: 8px; border: 1px solid #fed7d7;">' +
                                '<div style="margin-bottom: 15px; text-align: center;">' +
                                '<i class="fas fa-database" style="color: #dc3545; font-size: 32px; margin-bottom: 10px;"></i>' +
                                '</div>' +
                                '<?= addslashes($mensajeFormateado) ?>' +
                                '<div style="margin-top: 15px; padding: 10px; background: #f7fafc; border-radius: 6px; border-left: 4px solid #4299e1;">' +
                                '<p style="margin: 0; font-size: 13px; color: #2d3748;"><i class="fas fa-info-circle" style="color: #4299e1; margin-right: 5px;"></i><strong>Recomendación:</strong> Verifica la integridad de los datos y contacta al administrador si el problema persiste.</p>' +
                                '</div>' +
                                '</div>',
                            icon: 'error',
                            timer: 10000,
                            showConfirmButton: true,
                            confirmButtonText: '<i class="fas fa-redo"></i> Reintentar',
                            timerProgressBar: true,
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    <?php elseif ($_GET['envio'] == 'empty'): ?>
                        Swal.fire({
                            title: '<i class="fas fa-shopping-cart" style="color: #ffc107;"></i> Carrito vacío',
                            html: '<div style="text-align: center; font-size: 16px;">' +
                                '<i class="fas fa-inbox" style="color: #ffc107; font-size: 24px; margin-bottom: 10px;"></i><br>' +
                                'No hay registros en la memoria para procesar.' +
                                '</div>',
                            icon: 'warning',
                            timer: 7000,
                            showConfirmButton: true,
                            confirmButtonText: '<i class="fas fa-plus"></i> Agregar medicamentos',
                            timerProgressBar: true,
                            customClass: {
                                confirmButton: 'btn btn-warning'
                            }
                        });
                    <?php endif; ?>
                });
            </script>
        <?php endif; ?>

        <form action="" method="post">


            <label for="paciente">Paciente</label>
            <select name="paciente" id="paciente" onchange="this.form.submit()">
                <option value="" disabled selected>Seleccionar Paciente</option>
                <?= $pacientesOptions ?>
            </select>

            <label for="medicamento">Medicamento</label>
            <select name="medicamento" id="medicamento" onchange="this.form.submit()">
                <option value="" disabled selected>Seleccionar Medicamento</option>
                <?= $medicamentosOptions ?>
            </select>

            <?php if (!empty($aseguradoraNombre) || $precioAplicado !== null): ?>
                <div style="width:100%; background:#eef7f6; padding:8px; border-radius:6px; margin-bottom:10px;">
                    <?php if (!empty($aseguradoraNombre)): ?>
                        <div><strong>Aseguradora:</strong> <?= htmlspecialchars($aseguradoraNombre) ?></div>
                    <?php endif; ?>
                    <?php if ($precioAplicado !== null): ?>
                        <div><strong>Precio aplicado (<?= htmlspecialchars($precioLabel) ?>):</strong> $ <?= number_format(floatval($precioAplicado), 2) ?></div>
                        <?php if (isset($itemIva) && is_numeric($itemIva) && floatval($itemIva) > 0): ?>
                            <div><strong>IVA:</strong> <?= rtrim(rtrim(number_format(floatval($itemIva) * 100, 2), '0'), '.') ?>%</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>



            <label for="lote">Lote</label>
            <select name="lote" id="lote" onchange="actualizarLote()">
                <option value="" disabled selected>Lote/Caducidad/Total</option>
                <?= $lotesOptions ?>
            </select>

            <label for="cantidad">Cantidad</label>
            <input type="number" id="cantidad" name="cantidad" min="1">
            <!-- Mostrar el existe_id del lote seleccionado -->
            <div id="existe_id_display" style="margin-top: 10px; font-weight: bold;"></div>

            <!-- Contenedor de los botones -->
            <div class="button-container">
                <button type="submit" name="agregar" value="2" class="btn-primary">
                    <i class="fas fa-plus"></i> Agregar a Lista
                </button>
                <button type="submit" name="enviar_medicamentos" value="1" class="btn-secondary">
                    <i class="fas fa-rocket"></i> Enviar Todo
                </button>
            </div>

        </form>
        <!-- Sección de tabla dentro del mismo contenedor para ocupar mayor ancho -->
        <div class="container-main">
            <hr style="border: none; height: 2px; background: linear-gradient(90deg, transparent, #2b2d7f, transparent); margin: 30px 0;">

            <div style="text-align: center; margin-bottom: 20px;">
                <h3 style="color: #2b2d7f; font-size: 24px; margin: 0; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <span style="background: #2b2d7f; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 14px;"><i class="fas fa-clipboard-list"></i></span>
                    ITEMS A SURTIR
                </h3>
            </div>

            <?php
            // Leer el carrito desde la tabla `carrito_surtir_paciente` (todos los usuarios)
            // ahora incluimos item_grams, iva, subtotal, total para mostrar
            // Traer también el id_aseg y el nombre de la aseguradora desde cat_aseg
            $selectCart = "SELECT c.id, c.paciente, c.medicamento, c.item_grams, c.lote, c.cantidad, c.precio, c.iva, c.subtotal, c.total, c.id_aseg, a.aseg AS aseguradora_nombre FROM carrito_surtir_paciente c LEFT JOIN cat_aseg a ON c.id_aseg = a.id_aseg ORDER BY c.creado_en";
            $resCart = $conexion->query($selectCart);

            if ($resCart && $resCart->num_rows > 0) {
                echo "<form method='post' action=''>";
                echo "<div class='table-container'>";
                echo "<table class='table table-bordered table-striped' id='cart-table'>";
                echo "<thead class='thead'>";
                echo "<tr>\n";
                echo "<th title='Seleccionar todos'><input type=\"checkbox\" id=\"checkAll\" onclick=\"toggleAllCheckboxes(this)\"></th>\n";
                echo "<th><i class='fas fa-user-injured'></i> Paciente</th>\n";
                echo "<th><i class='fas fa-shield-alt'></i> Aseguradora</th>\n";
                echo "<th><i class='fas fa-pills'></i> Medicamento</th>\n";
                echo "<th><i class='fas fa-tag'></i> Lote</th>\n";
                echo "<th><i class='fas fa-hashtag'></i> Cantidad</th>\n";
                echo "<th><i class='fas fa-dollar-sign'></i> Precio</th>\n";
                echo "<th><i class='fas fa-percent'></i> IVA</th>\n";
                echo "<th><i class='fas fa-calculator'></i> Subtotal</th>\n";
                echo "<th><i class='fas fa-receipt'></i> Total</th>\n";
                echo "</tr>";
                echo "</thead><tbody>";

                while ($row = $resCart->fetch_assoc()) {
                    $id = intval($row['id']);
                    $paciente = htmlspecialchars($row['paciente']);
                    // Usar item_grams guardado en la tabla para mostrar junto al nombre
                    $item_grams = isset($row['item_grams']) ? $row['item_grams'] : '';
                    $aseguradoraNombreRow = isset($row['aseguradora_nombre']) ? htmlspecialchars($row['aseguradora_nombre']) : '';
                    $medicamento = htmlspecialchars($row['medicamento'] . ($item_grams !== '' ? ' ' . $item_grams : ''));
                    $lote = htmlspecialchars($row['lote']);
                    $cantidad = intval($row['cantidad']);
                    $precio = number_format(floatval($row['precio']), 2);
                    $iva = number_format(floatval($row['iva']), 2);
                    $subtotalRow = number_format(floatval($row['subtotal']), 2);
                    $totalRow = number_format(floatval($row['total']), 2);
                    echo "<tr id='row_$id'>";
                    echo "<td><input type='checkbox' name='eliminar_checkbox[]' value='$id' aria-label='Seleccionar fila'></td>";
                    echo "<td>$paciente</td>";
                    echo "<td>$aseguradoraNombreRow</td>";
                    echo "<td>$medicamento</td>";
                    echo "<td>$lote</td>";
                    echo "<td>$cantidad</td>";
                    echo "<td>$precio</td>";
                    echo "<td>$iva</td>";
                    echo "<td>$subtotalRow</td>";
                    echo "<td>$totalRow</td>";
                    echo "</tr>";
                }

                // Calcular total general
                $resTotal = $conexion->query("SELECT COALESCE(SUM(total),0) AS grand_total FROM carrito_surtir_paciente");
                $grandTotal = 0.0;
                if ($resTotal && $resTotal->num_rows > 0) {
                    $rowT = $resTotal->fetch_assoc();
                    $grandTotal = floatval($rowT['grand_total']);
                }

                echo "</tbody></table></div>";
                echo "<div style='text-align:center; margin-top:15px; font-weight:bold; font-size:18px;'><i class='fas fa-coins' style='color:#2b2d7f'></i> Total general: $ " . number_format($grandTotal, 2) . "</div>";

                echo "<div class='actions-row'>";
                // Mostrar total general centrado con icono

                echo "<button type='submit' name='eliminar_seleccionados' class='btn-danger-custom'><i class='fas fa-trash-alt'></i> Eliminar seleccionados</button>";
                echo "</div>";
                echo "</form>";
            } else {
                echo "<p>No hay medicamentos en el carrito.</p>";
            }

            // Manejar eliminación múltiple: eliminar por id (sin filtrar por usuario)
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_seleccionados']) && isset($_POST['eliminar_checkbox'])) {
                $ids = $_POST['eliminar_checkbox'];
                if (is_array($ids) && count($ids) > 0) {
                    // Construir placeholders y tipos para los IDs
                    $placeholders = implode(',', array_fill(0, count($ids), '?'));
                    $types = str_repeat('i', count($ids));

                    // Preparar la consulta DELETE por ids
                    $sql = "DELETE FROM carrito_surtir_paciente WHERE id IN ($placeholders)";
                    $stmtUpd = $conexion->prepare($sql);
                    if ($stmtUpd) {
                        // Convertir valores a enteros y crear referencias para bind_param
                        $params = array_map('intval', $ids);
                        $bindNames = [];
                        $bindNames[] = $types;
                        // bind_param requiere referencias
                        foreach ($params as $key => $val) {
                            $bindNames[] = &$params[$key];
                        }
                        call_user_func_array(array($stmtUpd, 'bind_param'), $bindNames);
                        $stmtUpd->execute();
                        $stmtUpd->close();
                    }
                    // Usar "flash" en sesión para mostrar el mensaje una sola vez y sin querystring
                    $_SESSION['flash_eliminated'] = 1;
                    header('Location: surtir_pacienteq.php');
                    exit();
                }
            }
            ?>

        </div> <!-- /.container-main -->

    </div> <!-- Cierra .form-container englobando también la tabla -->

</body>

</html>



<script>
    function actualizarLote() {
        const loteSelect = document.getElementById('lote');
        const selectedOption = loteSelect.options[loteSelect.selectedIndex];

        if (selectedOption) {
            // Obtener la fecha de caducidad, la cantidad y el existe_id del lote seleccionado
            const caducidad = selectedOption.getAttribute('data-caducidad');
            const cantidad = selectedOption.getAttribute('data-cantidad');
            const existeId = selectedOption.value; // El existe_id del lote seleccionado

            // Mostrar estos valores en los inputs correspondientes (si existen)
            const cadInput = document.getElementById('caducidad');
            if (cadInput) cadInput.value = caducidad;
            const cantInput = document.getElementById('cantidad-lote');
            if (cantInput) cantInput.value = cantidad;

            // Mostrar el existe_id en un lugar visible del formulario
            const display = document.getElementById('existe_id_display');
            if (display) display.textContent = "ExisteID: " + existeId;

            
        }
    }

    function toggleAllCheckboxes(master) {
        const checkboxes = document.querySelectorAll("input[name='eliminar_checkbox[]']");
        checkboxes.forEach(cb => cb.checked = master.checked);
    }
</script>