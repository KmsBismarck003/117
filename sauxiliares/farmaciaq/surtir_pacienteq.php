<?php
include "../../conexionbd.php";
session_start();
ob_start();

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

date_default_timezone_set('America/Guatemala');

if (isset($usuario['id_rol'])) {
    if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
        include "../header_farmaciaq.php";
    } else {
        session_unset();
        session_destroy();
        echo "<script>window.location='../../index.php';</script>";
        exit();
    }
}

// Obtener los pacientes
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
        // Verificar si el paciente está seleccionado
        $selected = (isset($_SESSION['paciente_seleccionado']) && $_SESSION['paciente_seleccionado'] == $paciente['id_atencion']) ? 'selected' : '';
        $pacientesOptions .= "<option value='{$paciente['id_atencion']}' $selected>{$paciente['nombre_paciente']}</option>";
    }
}

// Guardar el id_atencion en la sesión cuando se seleccione el paciente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente'])) {
    $_SESSION['paciente_seleccionado'] = $_POST['paciente'];
}



// Obtener los medicamentos con los gramos concatenados
$queryMedicamentos = "SELECT DISTINCT 
    ea.item_id, 
    CONCAT(ia.item_name, ' ', ia.item_grams) AS item_name
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
        $medicamentosOptions .= "<option value='{$medicamento['item_id']}' $selected>{$medicamento['item_name']}</option>";
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
            $lotesOptions .= "<option value='{$lote['existe_id']}|{$lote['existe_lote']}' data-caducidad='{$lote['existe_caducidad']}' data-cantidad='{$lote['existe_qty']}'>
     {$lote['existe_lote']} / {$lote['existe_caducidad']} / {$lote['existe_qty']}
</option>";
        }
    } else {
        $lotesOptions .= "<option value='' disabled>No hay lotes disponibles</option>";
    }

    // Cerrar la declaración
    $stmt->close();
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

    // Obtener el nombre del medicamento
    $sqlMedicamentoNombre = "SELECT item_name FROM item_almacen WHERE item_id = ?";
    $stmtMedicamento = $conexion->prepare($sqlMedicamentoNombre);
    $stmtMedicamento->bind_param('i', $_POST['medicamento']);
    $stmtMedicamento->execute();
    $stmtMedicamento->bind_result($nombreMedicamento);
    $stmtMedicamento->fetch();
    $stmtMedicamento->close();


    // Verificar si el botón "Agregar" ha sido presionado
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
        // Captura del formulario


        // Si la variable de sesión no está inicializada, la creamos como un array vacío
        if (!isset($_SESSION['medicamento_seleccionado'])) {
            $_SESSION['medicamento_seleccionado'] = [];
        }

        // Agregar el nuevo registro al array de la sesión
        $_SESSION['medicamento_seleccionado'][] = [
            'paciente' => $nombrePaciente,
            'medicamento' => $nombreMedicamento,
            'lote' => $nombreLote, // Usar el nombre del lote
            'cantidad' => $_POST['cantidad'],
            'existe_id' => $existeId, // Aquí agregamos el existe_id del lote
            'id_atencion' => $idAtencion // Agregamos el id_atencion
        ];

        echo "<script>
      window.location.href = 'surtir_pacienteq.php';
    </script>";
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

    if (!isset($_SESSION['medicamento_seleccionado']) || empty($_SESSION['medicamento_seleccionado'])) {
        echo "<script>alert('No hay registros en la memoria para procesar.'); window.location.href = 'surtir_pacienteq.php';</script>";
        exit();
    }
    // Iniciar transacción
    $conexion->begin_transaction();

    try {
        foreach ($_SESSION['medicamento_seleccionado'] as $index => $medicamento) {
            $paciente = $medicamento['paciente'];
            $nombreMedicamento = $medicamento['medicamento'];
            $loteNombre = $medicamento['lote'];
            $cantidadLote = $medicamento['cantidad'];
            $existeId = $medicamento['existe_id'];
            $Id_Atencion = $medicamento['id_atencion'];

            // *** 1. Obtener el item_id del medicamento desde item_almacen ***
            $queryItemAlmacen = "SELECT item_id FROM item_almacen WHERE item_name = ?";
            $stmt = $conexion->prepare($queryItemAlmacen);
            $stmt->bind_param("s", $nombreMedicamento);
            $stmt->execute();
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
            }
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $itemData = $result->fetch_assoc();
                $itemId = $itemData['item_id'];
            } else {
                throw new Exception("Error: No se encontró el ítem con nombre '$nombreMedicamento'.");
            }



            $queryItemAlmacenn = "
            SELECT 
                item_name, 
                item_price 
            FROM 
                item_almacen 
            WHERE 
                item_id = ?
        ";
            $stmt = $conexion->prepare($queryItemAlmacenn);
            $stmt->bind_param("i", $itemId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $itemData = $result->fetch_assoc();
                $itemName = $itemData['item_name'];
                $salidaCostsu = $itemData['item_price'];
            } else {
                exit("Error: No se encontró el ítem con ID $itemId.");
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
               VALUES (NOW(), ?, ?, ?, 0, 0, ?, 0, 0, 0, 'Salida', 'QUIROFANO', ?)
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
                    solicita, 
                    fecha_solicitud
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?)
             ";
            $stmtInsertSalida = $conexion->prepare($queryInsercion);
            if (!$stmtInsertSalida) {
                throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
            }
            $stmtInsertSalida->bind_param(
                "issssdiiss",
                $itemId,
                $nombreMedicamento,
                $fechaActual,
                $loteNombre,
                $caducidad,
                $cantidadLote,
                $salidaCostsu,
                $id_usua,
                $Id_Atencion,
                $fechaActual
            );

            if (!$stmtInsertSalida->execute()) {
                throw new Exception("Error al insertar en salidas_almacenq: " . $stmtInsertSalida->error);
            }
            $salidaId = $stmtInsertSalida->insert_id; // Obtener el ID generado automáticamente
            $stmtInsertSalida->close();

            // *** 8. Insertar en dat_ctapac ***
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
                  existe_caducidad
              ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
           ";

            $stmtInsertDatCtapac = $conexion->prepare($insertDatCtapacQuery);
            if (!$stmtInsertDatCtapac) {
                throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
            }
            $prodServ = 'P';
            $ctaActivo = 'SI';

            $stmtInsertDatCtapac->bind_param(
                'isssddsssss',
                $Id_Atencion,
                $prodServ,
                $itemId,
                $fechaActual,
                $cantidadLote,
                $salidaCostsu,
                $id_usua,
                $ctaActivo,
                $salidaId,
                $loteNombre,
                $caducidad
            );

            if (!$stmtInsertDatCtapac->execute()) {
                throw new Exception("Error al insertar en dat_ctapac: " . $stmtInsertDatCtapac->error);
            }
            $stmtInsertDatCtapac->close();

            // *** 9. Insertar en cart_recib ***
            $ingresar2 = $conexion->query("INSERT INTO cart_recib(item_id, solicita, almacen, id_usua, confirma) VALUES ($itemId, $cantidadLote, 'QUIROFANO', $id_usua, 'SI')");
            if (!$ingresar2) {
                throw new Exception("Error al insertar en cart_recib: " . $conexion->error);
            }



            // *** 5. Actualizar existencias en la tabla existencias_almacenq ***
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
        }

        // Confirmar la transacción
        $conexion->commit();


        // Limpiar la sesión (opcional)
        unset($_SESSION['medicamento_seleccionado']);


        echo "<script>alert('Los medicamentos han sido registrados correctamente.'); window.location.href = 'surtir_pacienteq.php';</script>";
    } catch (Exception $e) {
        $conexion->rollback(); // Revertir cambios
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href = 'surtir_pacienteq.php';</script>";
    }
}





?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <a href="../../template/menu_farmaciaq.php"
        style='color: white; margin-left: 30px; margin-bottom: 20px; background-color: #d9534f; 
          border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; display: inline-block;'>
        Regresar
    </a>
    <div class="form-container">
        <div class="thead" style="background-color: #0c675e; margin: 5px auto; padding: 5px; color: white; width: fit-content; text-align: center; border-radius: 5px;">
            <h1 style="font-size: 26px; margin: 2;">SURTIR PACIENTE</h1>
        </div>
        <br><br>

        <form action="" method="post">


            <label for="paciente">Paciente</label>
            <select name="paciente" id="paciente">
                <option value="" disabled selected>Seleccionar Paciente</option>
                <?= $pacientesOptions ?>
            </select>

            <label for="medicamento">Medicamento</label>
            <select name="medicamento" id="medicamento" onchange="this.form.submit()">
                <option value="" disabled selected>Seleccionar Medicamento</option>
                <?= $medicamentosOptions ?>
            </select>



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
                <button type="submit" name="agregar" value="2">Agregar</button>

                <button type="submit" name="enviar_medicamentos" value="1">Enviar</button>
            </div>

        </form>

        <hr>

        <style>
            h3 {
                text-align: center;
            }
        </style>

        <h3>ITEMS A SURTIR</h3>

        <?php



        // Eliminar el registro si se envió el índice por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_index'])) {
            $index = intval($_POST['eliminar_index']); // Asegurar que el índice sea un entero
            if (isset($_SESSION['medicamento_seleccionado'][$index])) {
                unset($_SESSION['medicamento_seleccionado'][$index]); // Eliminar el registro
                $_SESSION['medicamento_seleccionado'] = array_values($_SESSION['medicamento_seleccionado']); // Reindexar el array
            }
        }

        if (isset($_SESSION['medicamento_seleccionado']) && is_array($_SESSION['medicamento_seleccionado'])) {
            echo "<table border='1' cellspacing='5' cellpadding='5' style='font-size: 18px; width: 90%; margin: 0 auto;'>";
            echo "<tr>
            <th>Paciente</th>
            <th>Medicamento</th>
            <th>Lote</th>
            <th>Cantidad</th>
            <th>Acciones</th> <!-- Nueva columna para el botón de eliminar -->
          </tr>";

            // Iterar sobre los medicamentos
            foreach ($_SESSION['medicamento_seleccionado'] as $index => $medicamento) { // Usar $index para identificar el registro
                // Verificamos si el elemento actual es un array con las claves esperadas
                if (is_array($medicamento) && isset($medicamento['paciente'], $medicamento['medicamento'], $medicamento['lote'], $medicamento['cantidad'])) {
                    echo "<tr>";
                    echo "<td>{$medicamento['paciente']}</td>";
                    echo "<td>{$medicamento['medicamento']}</td>";
                    echo "<td>{$medicamento['lote']}</td>";
                    echo "<td>{$medicamento['cantidad']}</td>";

                    // Botón para eliminar este registro (envía el índice $index por POST)
                    echo "<td>
                    <form action='' method='post' style='display:inline;'>
                        <input type='hidden' name='eliminar_index' value='$index'>
                        <button type='submit' style='background-color:red;color:white;border:none;padding:3px 8px;border-radius:5px;font-size:12px;'>Eliminar</button>
                    </form>
                  </td>";

                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='5'>Datos incompletos para el medicamento.</td></tr>";
                }
            }

            echo "</table>";
        } else {
            echo "<p>No hay medicamentos seleccionados.</p>";
        }
        ?>





    </div>

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

            // Mostrar estos valores en los inputs correspondientes
            document.getElementById('caducidad').value = caducidad;
            document.getElementById('cantidad-lote').value = cantidad;

            // Mostrar el existe_id en un lugar visible del formulario
            document.getElementById('existe_id_display').textContent = "Existe ID del lote seleccionado: " + existeId;

            // Imprimir el existe_id en la consola
            console.log("existe_id del lote seleccionado: " + existeId);
        }
    }
</script>
<style>
    .form-container {
        width: 60%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f4f4f9;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    select,
    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #0a4d44;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }


    .button-container {
        display: flex;
        justify-content: start;
        gap: 10px;
    }

    button:hover {
        background-color: #0a4d44;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 300px;
        /* Ancho fijo para que los elementos tengan el mismo tamaño */
        margin: 0 auto;
    }

    /* Estilos para los elementos select e input */
    select,
    input {
        width: 100%;
        /* Hace que los elementos ocupen todo el ancho del formulario */
        padding: 5px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    /* Estilos para las etiquetas */
    label {
        font-size: 20px;
        margin-bottom: 5px;
    }
</style>