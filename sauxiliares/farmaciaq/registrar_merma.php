<?php
session_start();
include "../../conexionbd.php";

// Verifica si la sesión está activa
if (!isset($_SESSION['login'])) {
    echo "<script>
        window.location = '../../index.php';
    </script>";
    exit;
}

// Obtiene los valores del formulario
$id_dev = $_POST['id_dev'];
$item_id = $_POST['item_id'];
$dev_qty = $_POST['dev_qty'];
$existe_lote = $_POST['existe_lote'];
$existe_caducidad = $_POST['existe_caducidad'];
$id_usua = $_SESSION['login']['id_usua'];
$merma_qty = $_POST['merma_qty'];
$merma_motivo = $_POST['merma_motivo'];

// Verifica si la cantidad de merma es mayor a 0
if ($merma_qty > 0) {
    // Prepara la consulta SQL para insertar los datos en la tabla merma_almacenq
    $query_merma = "INSERT INTO merma_almacenq (item_id, merma_lote, merma_caducidad, merma_qty, merma_motivo, id_usua)
                    VALUES (?, ?, ?, ?, ?, ?)";

    // Prepara la sentencia para la merma
    if ($stmt_merma = $conexion->prepare($query_merma)) {
        // Enlaza los parámetros
        $stmt_merma->bind_param("issdsi", $item_id, $existe_lote, $existe_caducidad, $merma_qty, $merma_motivo, $id_usua);

        // Ejecuta la sentencia de la merma
        if ($stmt_merma->execute()) {
            // Ahora, actualiza el kardex_almacenq
            // Primero, obtiene la cantidad actual del producto en el kardex
            $query_kardex = "SELECT kardex_qty FROM kardex_almacenq WHERE item_id = ? AND kardex_lote = ? AND kardex_caducidad = ? ORDER BY kardex_fecha DESC LIMIT 1";
            
            if ($stmt_kardex = $conexion->prepare($query_kardex)) {
                $stmt_kardex->bind_param("iss", $item_id, $existe_lote, $existe_caducidad);
                $stmt_kardex->execute();
                $stmt_kardex->store_result();
                
                // Si ya existe un registro en el kardex para el lote y la caducidad, se obtiene la cantidad actual
                if ($stmt_kardex->num_rows > 0) {
                    $stmt_kardex->bind_result($kardex_qty);
                    $stmt_kardex->fetch();
                } else {
                    $kardex_qty = 0;  // Si no existe, se asume que la cantidad inicial es 0
                }
                $stmt_kardex->close();

                // Calcula el nuevo valor de la cantidad en el kardex
                $nueva_qty = $kardex_qty - $merma_qty;

                // Inserta el movimiento en el kardex
                $query_kardex_insert = "INSERT INTO kardex_almacenq (item_id, kardex_lote, kardex_caducidad, kardex_qty, kardex_dev_merma, kardex_movimiento, id_usua, kardex_ubicacion, kardex_destino)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt_kardex_insert = $conexion->prepare($query_kardex_insert)) {
                    $kardex_movimiento = 'Merma';  // Tipo de movimiento
                    $kardex_ubicacion = 'Merma'; // O puedes obtener esta información de algún lado si aplica
                    $kardex_destino = 'Merma';     // O también puedes modificar según corresponda

                    // Enlaza los parámetros y ejecuta
                    $stmt_kardex_insert->bind_param("issiiisss", $item_id, $existe_lote, $existe_caducidad, $nueva_qty, $merma_qty, $kardex_movimiento, $id_usua, $kardex_ubicacion, $kardex_destino);

                    if ($stmt_kardex_insert->execute()) {
                        // Si todo es exitoso, redirige con mensaje de éxito
                        echo "<script>
                            alert('Merma registrada y Kardex actualizado correctamente.');
                            window.location = 'devolucionesh.php';
                        </script>";
                    } else {
                        echo "<script>
                            alert('Error al actualizar el Kardex.');
                            window.location = 'devolucionesh.php';
                        </script>";
                    }
                    $stmt_kardex_insert->close();
                } else {
                    echo "<script>
                        alert('Error al preparar la consulta de Kardex.');
                        window.location = 'devolucionesh.php';
                    </script>";
                }
            } else {
                echo "<script>
                    alert('Error al obtener el Kardex.');
                    window.location = 'devolucionesh.php';
                </script>";
            }

        } else {
            // Muestra un mensaje de error si la inserción de la merma falla
            echo "<script>
                alert('Error al registrar la merma.');
                window.location = 'devolucionesh.php';
            </script>";
        }
        $stmt_merma->close();
    } else {
        // Muestra un mensaje de error si la preparación de la consulta falla
        echo "<script>
            alert('Error en la preparación de la consulta de merma.');
            window.location = 'devolucionesh.php';
        </script>";
    }
} else {
    // Muestra un mensaje si la cantidad de merma es inválida
    echo "<script>
        alert('La cantidad de merma debe ser mayor a 0.');
        window.location = 'devolucionesh.php';
    </script>";
}
?>
