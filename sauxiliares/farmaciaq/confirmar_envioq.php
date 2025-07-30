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
    c.almacen = 'QUIROFANO' 
GROUP BY 
    c.id_recib, c.item_id, i.item_name, c.fecha, c.solicita
ORDER BY 
    c.id_recib ASC;

";



$result = $conexion->query($query);
if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}

$ubicaciones_query = "SELECT ubicacion_id, nombre_ubicacion FROM ubicaciones_almacen";
$ubicaciones_result = $conexion->query($ubicaciones_query);
$ubicaciones = [];
if ($ubicaciones_result && $ubicaciones_result->num_rows > 0) {
    while ($ubicacion = $ubicaciones_result->fetch_assoc()) {
        $ubicaciones[] = $ubicacion;
    }
} else {
    die("Error al consultar ubicaciones: " . $conexion->error);
}


if (isset($_POST['confirmar'])) {
    $id_recib = isset($_POST['id_recib']) ? intval($_POST['id_recib']) : null;
    $ubicacion_id = isset($_POST['ubicacion_id']) ? intval($_POST['ubicacion_id']) : null;
    $fecha_actual = date('Y-m-d H:i:s');

    if (is_null($id_recib) || is_null($ubicacion_id)) {
        echo "<script>alert('Error: Faltan datos obligatorios.');</script>";
        echo "<script>window.location.href = 'confirmar_envio.php';</script>";
        exit();
    }

    $query_costo = "SELECT item_costs FROM item_almacen WHERE item_id = ?";
    $stmt_costo = $conexion->prepare($query_costo);
    if (!$stmt_costo) {
        echo "<script>alert('Error al preparar la consulta de costo.');</script>";
        exit();
    }

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
                ) VALUES (NOW(), ?, ?, ?, 0, ?, 0, 0, 0, 0, 'Resurtimiento', ?, 'QUIROFANO', ?,?)
                ";
        $stmt_kardex = $conexion->prepare($insert_kardex);


        $select_existencia = "
        SELECT existe_entradas, existe_qty 
        FROM existencias_almacenq 
        WHERE item_id = ? AND existe_lote = ? AND existe_caducidad = ?
        ";
        $stmt_select_existencia = $conexion->prepare($select_existencia);

        $update_existencia = "
        UPDATE existencias_almacenq 
        SET existe_entradas = existe_entradas + ?, 
            existe_qty = existe_qty + ?,
            existe_fecha = NOW()
        WHERE item_id = ? AND existe_lote = ? AND existe_caducidad = ?
        ";
        $stmt_update_existencia = $conexion->prepare($update_existencia);

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
        
        ) VALUES (?, ?, ?, ?, ?, 0, ?, 0, NOW(), ?, ?)
        ";
        $stmt_insert_existencia = $conexion->prepare($insert_existencia);

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



        while ($row = $result_insercion->fetch_assoc()) {
            $item_id = $row['item_id'];
            $entrada_lote = $row['existe_lote'];
            $entrada_caducidad = $row['existe_caducidad'];
            $entrada_unidosis = $row['entrega'];
            $Surte = $row['Surte'];

            // Obtener el costo del ítem
            $stmt_costo->bind_param("i", $item_id);
            $stmt_costo->execute();
            $result_costo = $stmt_costo->get_result();
            $row_costo = $result_costo->fetch_assoc();
            $entrada_costo = $row_costo['item_costs'];

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
            if ($stmt_entrada->execute()) {
            } else {
                exit('Error al insertar en entradas_almacenq: ' . $stmt_entrada->error);
            }


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
            if ($stmt_kardex->execute()) {
            } else {
                exit('Error al insertar en kardex_almacenq: ' . $stmt_kardex->error);
            }


            $insertKardexQuery = "INSERT INTO kardex_almacen (
                    kardex_fecha, item_id, kardex_lote, kardex_caducidad, kardex_inicial, kardex_entradas,
                    kardex_salidas, kardex_qty, kardex_dev_stock, kardex_dev_merma, kardex_movimiento,
                    kardex_ubicacion, kardex_destino, id_usua
                ) VALUES (NOW(), ?, ?, ?, 0, 0, ?, 0, 0, 0, 'Salida', ?,'QUIROFANO',?)";
            $stmtInsertKardex = $conexion->prepare($insertKardexQuery);
            $stmtInsertKardex->bind_param(
                'issiii',
                $item_id,
                $entrada_lote,
                $entrada_caducidad,
                $entrada_unidosis,
                $ubicacion_id,
                $id_usua


            );
            if ($stmtInsertKardex->execute()) {
            } else {
                exit('Error al insertar en kardex_almacen: ' . $stmtInsertKardex->error);
            }


            $stmt_salida->bind_param(
                "ssiiii",
                $entrada_lote,
                $entrada_caducidad,
                $entrada_unidosis,
                $id_usua,
                $item_id,
                $ubicacion_id
            );

            if ($stmt_salida->execute()) {
            } else {
                exit('Error al insertar en salidas_almacen: ' . $stmt_salida->error);
            }




            // Asociar los parámetros
            if (!$stmt_select_existencia->bind_param("iss", $item_id, $entrada_lote, $entrada_caducidad)) {
                exit("Error al asociar los parámetros de la consulta SELECT en existencias_almacen: " . $stmt_select_existencia->error);
            }

            // Ejecutar la consulta
            if (!$stmt_select_existencia->execute()) {
                exit("Error al ejecutar la consulta SELECT en existencias_almacen: " . $stmt_select_existencia->error);
            }

            // Obtener el resultado
            $result_existencia = $stmt_select_existencia->get_result();

            // Validar si la obtención del resultado fue exitosa
            if (!$result_existencia) {
                exit("Error al obtener el resultado de la consulta SELECT en existencias_almacen: " . $stmt_select_existencia->error);
            }




            if ($result_existencia->num_rows > 0) {
                $stmt_update_existencia->bind_param("iiiss", $entrada_unidosis, $entrada_unidosis, $item_id, $entrada_lote, $entrada_caducidad);
                $stmt_update_existencia->execute();

                if ($stmt_update_existencia->execute()) {
                } else {
                    exit('Error al actualizar existencias_almacenq ' . $stmt_update_existencia->error);
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
                if ($stmt_insert_existencia->execute()) {
                } else {
                    exit('Error al insertar en existencias_almacenq: ' . $stmt_insert_existencia->error);
                }
            }



            $delete_cart_recib = "DELETE FROM cart_recib WHERE id_recib = ?";
            $stmt_delete_cart_recib = $conexion->prepare($delete_cart_recib);
            $stmt_delete_cart_recib->bind_param("i", $id_recib);
            $stmt_delete_cart_recib->execute();
            $delete_carrito_entradash = "DELETE FROM carrito_entradash WHERE id_recib = ?";
            $stmt_delete_carrito_entradash = $conexion->prepare($delete_carrito_entradash);
            $stmt_delete_carrito_entradash->bind_param("i", $id_recib);
            $stmt_delete_carrito_entradash->execute();
        }

        $stmt_costo->close();
        $stmt_entrada->close();
        $stmt_kardex->close();
        $stmt_select_existencia->close();
        $stmt_update_existencia->close();
        $stmt_insert_existencia->close();
        $stmt_salida->close();


        echo "<script>
        alert('Surtido Confirmado Correctamente');
        window.location.href = 'confirmar_envioq.php';
      </script>";
        exit();
    } else {
        echo "<script>alert('No hay registros para insertar.');</script>";
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
    <a href="../../template/menu_farmaciaq.php"
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
                    <th class="col-caducidad">
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
            <td>{$row['total_entrega']}</td> 
            <td>{$row['lotes']}</td> 
            <td>{$row['caducidades']}</td>
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

    .col-caducidad {
        width: 125px;
        text-align: center;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
    }
</style>