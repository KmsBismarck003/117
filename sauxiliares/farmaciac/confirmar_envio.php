<?php
include "../../conexionbd.php";
session_start();
ob_start();

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
date_default_timezone_set('America/Guatemala');

if (isset($usuario['id_rol'])) {
    if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
        include "../header_farmaciac.php";
    } else {
        session_unset();
        session_destroy();
        echo "<script>window.location='../../index.php';</script>";
        exit();
    }
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
        cart_recib AS cr ON c.id_recib = cr.id_recib AND cr.parcial = 'NO' -- Filtrar por parcial = 'NO'
    GROUP BY 
        c.id_recib, c.item_id, i.item_name, c.fecha, c.solicita
    ORDER BY 
        c.id_recib ASC;
";


$result = $conexion->query($query);


// Consulta para obtener las ubicaciones de la tabla ubicaciones_almacen
$ubicaciones_query = "SELECT ubicacion_id, nombre_ubicacion FROM ubicaciones_almacen";
$ubicaciones_result = $conexion->query($ubicaciones_query);
$ubicaciones = [];
if ($ubicaciones_result->num_rows > 0) {
    while ($ubicacion = $ubicaciones_result->fetch_assoc()) {
        $ubicaciones[] = $ubicacion;
    }
}

if (isset($_POST['confirmar'])) {
    // Validar y sanitizar los datos enviados por POST
    $id_recib = isset($_POST['id_recib']) ? intval($_POST['id_recib']) : null;
    $ubicacion_id = isset($_POST['ubicacion_id']) ? intval($_POST['ubicacion_id']) : null;
    $fecha_actual = date('Y-m-d H:i:s');

    if (!$id_recib || !$ubicacion_id) {
        echo "<script>alert('Error: Faltan datos obligatorios.');</script>";
        echo "<script>window.location.href = 'confirmar_envio.php';</script>";
        exit();
    }

    // Consultar el costo del ítem en item_almacen
    $query_costo = "SELECT item_costs FROM item_almacen WHERE item_id = ?";
    $stmt_costo = $conexion->prepare($query_costo);
    if (!$stmt_costo) {
        echo "<script>alert('Error al preparar la consulta de costo.');</script>";
        exit();
    }



    // Consulta para obtener los registros originales de `carrito_entradash`
    $query_insercion = "
        SELECT 
            c.id_recib,
            c.item_id,
            c.existe_lote,
            c.existe_caducidad,
            c.entrega
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
        // Preparar consulta de inserción en entradas_almacenh
        $insert_entrada = "
            INSERT INTO entradas_almacenh (
                entrada_fecha, 
                id_recib, 
                item_id, 
                entrada_lote, 
                entrada_caducidad, 
                entrada_unidosis, 
                entrada_costo, 
                id_usua, 
                ubicacion_id
            ) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt_entrada = $conexion->prepare($insert_entrada);

        // Preparar consulta de inserción en existencias_almacenh
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
        $stmt_existencia = $conexion->prepare(query: $insert_existencia);

        // Insertar en kardex_almacenh
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
                    id_usua
                ) VALUES (NOW(), ?, ?, ?, ?, ?, 0, ?, 0, 0, 'Entrada', ?, 'FARMACIA', ?)
                ";
        $stmt_kardex = $conexion->prepare(query: $insert_kardex);

        // Iterar sobre los registros originales e insertar en las dos tablas
        while ($row = $result_insercion->fetch_assoc()) {
            $item_id = $row['item_id'];
            $entrada_lote = $row['existe_lote'];
            $entrada_caducidad = $row['existe_caducidad'];
            $entrada_unidosis = $row['entrega'];

            // Obtener el costo del ítem
            $stmt_costo->bind_param("i", $item_id);
            $stmt_costo->execute();
            $result_costo = $stmt_costo->get_result();
            $row_costo = $result_costo->fetch_assoc();
            $entrada_costo = $row_costo['item_costs'];

            // Insertar en la tabla entradas_almacenh
            $stmt_entrada->bind_param(
                "iissiiii",
                $id_recib,
                $item_id,
                $entrada_lote,
                $entrada_caducidad,
                $entrada_unidosis,
                $entrada_costo,
                $id_usua, // Asumimos que ya está definido en tu código
                $ubicacion_id
            );
            $stmt_entrada->execute();

            // Insertar en la tabla existencias_almacenh
            $stmt_existencia->bind_param(
                "issiisii",
                $item_id,
                $entrada_lote,
                $entrada_caducidad,
                $entrada_unidosis, // existe_entradas es igual a la cantidad entregada
                $entrada_unidosis,
                $entrada_unidosis, // existe_qty es igual a la cantidad entregada
                // existe_qty es igual a la cantidad entregada
                $ubicacion_id,
                $id_usua
            );
            $stmt_existencia->execute();


            // Insertar en la tabla existencias_almacenh
            $stmt_kardex->bind_param(
                "issiisii",
                $item_id,
                $entrada_lote,
                $entrada_caducidad,
                $entrada_unidosis, // existe_entradas es igual a la cantidad entregada
                $entrada_unidosis,
                $entrada_unidosis, // existe_qty es igual a la cantidad entregada
                // existe_qty es igual a la cantidad entregada
                $ubicacion_id,
                $id_usua
            );
            $stmt_kardex->execute();

            // Consulta para obtener el valor actual de kardex_qty del lote seleccionado
            $selectKardexQtyQuery = "SELECT kardex_qty FROM kardex_almacen WHERE kardex_lote = ? AND item_id = ? ORDER BY kardex_id DESC LIMIT 1";
            $stmtSelectKardex = $conexion->prepare($selectKardexQtyQuery);
            $stmtSelectKardex->bind_param('si',$entrada_lote,$item_id );
            $stmtSelectKardex->execute();
            $resultSelectKardex = $stmtSelectKardex->get_result();


           
                $row = $resultSelectKardex->fetch_assoc();
                $kardexQtyActual = $row['kardex_qty'];

                // Calcular el nuevo valor de kardex_qty
                $nuevoKardexQty = $kardexQtyActual - $entrada_unidosis;


                // Insertar el nuevo registro en kardex_almacen
                $insertKardexQuery = "INSERT INTO kardex_almacen (
                    kardex_fecha, item_id, kardex_lote, kardex_caducidad, kardex_inicial, kardex_entradas,
                    kardex_salidas, kardex_qty, kardex_dev_stock, kardex_dev_merma, kardex_movimiento,
                    kardex_ubicacion, kardex_destino, id_usua
                ) VALUES (NOW(), ?, ?, ?, 0, 0, ?, ?, 0, 0, 'Salida', ?,'FARMACIA',?)";
                $stmtInsertKardex = $conexion->prepare($insertKardexQuery);
                $stmtInsertKardex->bind_param(
                    'issiiii',
                    $item_id,
                    $entrada_lote,
                    $entrada_caducidad,
                    $entrada_unidosis,
                    $nuevoKardexQty,
                    $ubicacion_id,
                    $id_usua


                );
                if ($stmtInsertKardex->execute()) {
                } else {
                    echo "Error al insertar en kardex_almacen: " . $stmtInsertKardex->error;
                }
           
        }


        echo "<script>alert('Registro confirmado e insertado correctamente.');</script>";
    } else {
        echo "<script>alert('No hay registros para insertar.');</script>";
    }

    // Cerrar recursos
    $stmt_entrada->close();
    $stmt_existencia->close();
    $stmt_costo->close();
    $stmt_insercion->close();
    $stmt_kardex->close();
    $stmtInsertKardex->close();
    $conexion->close();

    echo "<script>window.location.href = 'confirmar_envio.php';</script>";
    exit();
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
    <a href='menu_farmacia.php'
        style='color: white; margin-left: 30px; margin-bottom: 20px; background-color: #d9534f; 
          border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; display: inline-block;'>
        Regresar
    </a>

    <div class="container">
        <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
            <strong>
                <center>CONFIRMAR RECIBIDO</center>
            </strong>
        </div> <br>
        <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #0c675e">

                <tr>
                    <th class="col-fecha">
                        <font color="white">ID Recib</font>
                    </th>
                    <th>
                        <font color="white">Fecha.Envio</font>
                    </th>
                    <th class="col-medicamentos">
                        <font color="white">Medicamento</font>
                    </th>
                    <th>
                        <font color="white">Solicitado</font>
                    </th>
                    <th>
                        <font color="white">Entregado</font>
                    </th>
                    <th class="col-lote">
                        <font color="white">Lote</font>
                    </th>
                    <th>
                        <font color="white">Caducidad</font>
                    </th>
                    <th>
                        <font color="white">Ubicación</font>
                    </th>
                    <th>
                        <font color="white">Acciones</font>
                    </th>
                </tr>
            </thead>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
            <td>{$row['id_recib']}</td>
            <td>{$row['fecha']}</td>
            <td>{$row['item_name']}</td>
            <td>{$row['solicita']}</td>
            <td>{$row['total_entrega']}</td> <!-- Campo total entrega -->
            <td>{$row['lotes']}</td> <!-- Lotes concatenados -->
            <td>{$row['caducidades']}</td> <!-- Caducidades relacionadas -->
            <td>
                <form action='' method='POST' style='display:inline;'>
                    <input type='hidden' name='id_recib' value='{$row['id_recib']}'>
                    <select name='ubicacion_id' required>
                        <option value=''>ubicación</option>";
                    foreach ($ubicaciones as $ubicacion) {
                        echo "<option value='{$ubicacion['ubicacion_id']}'>{$ubicacion['nombre_ubicacion']}</option>";
                    }
                    echo "      </select>
            </td>
            <td>
                    <button type='submit' name='confirmar' class='enviar'>Confirmar</button>
                </form>
            </td>
        </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No se encontraron registros</td></tr>"; // Actualizado con el nuevo número de columnas
            }
            ?>

        </table>
    </div>



</html>


<?php
$conexion->close();
?>

<style>
    .container {
        width: 95%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 2px;
    }


    .enviar {
        padding: 5px 10px;
        background-color: #0c675e;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 14px;
    }

    .enviar:hover {
        background-color: #218838;
    }

    .col-medicamentos {
        width: 100px;
        text-align: center;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
    }

    .col-fecha {
        width: 100px;
        text-align: center;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
    }

    .col-lote {
        width: 100px;
        text-align: center;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
    }
</style>