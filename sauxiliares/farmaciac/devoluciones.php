<?php
session_start();

ob_start();
include "../../conexionbd.php";



$usuario = $_SESSION['login'];

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

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}



// Consulta para obtener las facturas
$query_facturass = "SELECT id_compra, factura FROM ordenes_compra";
$result_facturass = mysqli_query($conexion, $query_facturass);






$fecha_movimiento = isset($_POST['fecha_movimiento']) ? $_POST['fecha_movimiento'] : null;
$factura = isset($_POST['factura']) ? $_POST['factura'] : null;
$Facturas = isset($_POST['factura']) ? $_POST['factura'] : null;
$id_compra = isset($_POST['factura']) ? $_POST['factura'] : null; // Asegúrate de que esto ya está capturado

$proveedor = isset($_POST['proveedor']) ? $_POST['proveedor'] : null;
$folio = isset($_POST['folio']) ? $_POST['folio'] : null;
$movimiento = isset($_POST['Movimiento']) ? $_POST['Movimiento'] : null;
$id_usua = $_SESSION['login']['id_usua']; // Id del usuario logeado
$responsable = isset($_POST['responsable_movimiento']) ? $_POST['responsable_movimiento'] : null;
$resolucion = isset($_POST['resolucion_solicitud']) ? $_POST['resolucion_solicitud'] : null;
$areas = isset($_POST['area']) ? $_POST['area'] : null;

if (isset($_POST['guardar']) && isset($_POST['factura'])) {

    foreach ($_POST['seleccionar_item'] as $entrada_id => $seleccionado) {
        if ($seleccionado) {
            $motivo_seleccionado = isset($_POST['motivo_seleccionado'][$entrada_id]) ? $_POST['motivo_seleccionado'][$entrada_id] : '';
            $otro_motivo = isset($_POST['otro_motivo'][$entrada_id]) ? $_POST['otro_motivo'][$entrada_id] : '';
            $cantidad_a_devolver = isset($_POST['devolver_qty'][$entrada_id]) ? $_POST['devolver_qty'][$entrada_id] : 0;

            // Consultar el item_id, lote y caducidad usando el entrada_id
            $query_item_info = "SELECT item_id, entrada_lote, entrada_caducidad FROM entradas_almacen WHERE entrada_id = ?";
            $stmt_item = $conexion->prepare($query_item_info);
            $stmt_item->bind_param("i", $entrada_id);
            $stmt_item->execute();
            $result_item_info = $stmt_item->get_result();

            if ($result_item_info->num_rows > 0) {
                $row_item_info = $result_item_info->fetch_assoc();
                $item_id = $row_item_info['item_id'];
                $lote = $row_item_info['entrada_lote'];
                $caducidad = $row_item_info['entrada_caducidad'];

                // Insertar la devolución
                $motivo = ($motivo_seleccionado == "Otro") ? $otro_motivo : $motivo_seleccionado;
                if (empty($motivo)) {
                    echo "<script>alert('Por favor, ingresa un motivo para el ítem ID $item_id.');</script>";
                    continue;
                }

                if ($cantidad_a_devolver > 0) {
                    $query_insert_dev = "INSERT INTO dev_proveedor (item_id, dev_fecha, dev_lote, dev_caducidad, dev_qty, dev_motivo, id_usua, dev_factura, dev_proveedor, dev_folio, dev_movimiento, dev_responsable, dev_resolucion, ubicacion_id) 
                                         VALUES ('$item_id', NOW(), '$lote', '$caducidad', '$cantidad_a_devolver', '$motivo', '$id_usua', '$factura', '$proveedor', '$folio', '$movimiento', '$responsable', '$resolucion', '$areas')";
                    mysqli_query($conexion, $query_insert_dev);
                }
            }
        }
    }

    echo "<script>alert('Devoluciones guardadas exitosamente.'); window.location='kardex.php';</script>";
}




// Consulta para obtener los proveedores
$query = "SELECT id_prov, nom_prov FROM proveedores";
$result = mysqli_query($conexion, $query);

// Consulta para obtener las facturas
$query_facturas = "SELECT DISTINCT factura FROM entradas_almacen";
$result_facturas = mysqli_query($conexion, $query_facturas);

// Inicializa $result_items como un objeto vacío si no se ha enviado ninguna factura
$result_items = $conexion->query("SELECT * FROM entradas_almacen WHERE 1=0");

// Verificar si se ha enviado una factura para buscar los ítems asociados
if (isset($_POST['factura'])) {
    $factura = $_POST['factura'];

    // Consulta para obtener los ítems asociados a la factura seleccionada
    $query_items = "SELECT entrada_id, item_id, entrada_qty, entrada_lote, entrada_caducidad 
                    FROM entradas_almacen 
                    WHERE factura = ?";
    $stmt = $conexion->prepare($query_items);
    $stmt->bind_param("s", $factura);
    $stmt->execute();
    $result_items = $stmt->get_result();
}

if (isset($_POST['generar_pdf'])) {
    require_once '../../vendor/autoload.php';

    ob_end_clean(); // Limpiar el búfer de salida antes de generar el PDF

    // Crear una instancia del PDF
    $pdf = new TCPDF();

    // Configurar el PDF
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nombre del Autor');
    $pdf->SetTitle('Formato para Devolución a Proveedor / Merma');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    // Consulta para obtener el nombre del proveedor usando id_prov
    $query_proveedor = "SELECT nom_prov FROM proveedores WHERE id_prov = ?";
    $stmt_proveedor = $conexion->prepare($query_proveedor);
    $stmt_proveedor->bind_param("i", $proveedor); // $proveedor contiene el id_prov aquí
    $stmt_proveedor->execute();
    $result_proveedor = $stmt_proveedor->get_result();
    $row_proveedor = $result_proveedor->fetch_assoc();

    // Asignar el nombre del proveedor a la variable
    $proveedor = $row_proveedor['nom_prov'] ?? '';



    // Comprobar si se ha seleccionado un id_compra
    if ($id_compra !== null && !empty($id_compra)) {
        // Consulta para obtener la factura correspondiente al id_compra
        $query_factura = "SELECT id_compra, factura FROM ordenes_compra WHERE id_compra = ?";
        $stmt_factura = $conexion->prepare($query_factura);
        $stmt_factura->bind_param("i", $id_compra); // Usamos el id_compra para buscar
        $stmt_factura->execute();
        $result_factura = $stmt_factura->get_result();
        $row_factura = $result_factura->fetch_assoc();

        // Asignar la factura recuperada
        $factura = htmlspecialchars($row_factura['factura'] ?? ''); // Nombre de la factura
    } else {
        $factura = null; // Si no se selecciona, establece como null
    }
    // Definir el contenido HTML con estilos CSS
    $html = '
    <div style="border: 2px solid black; padding: 10px; text-align: center; width: 300px; margin: 0 auto; margin-bottom: 20px;">
        <h2 style="font-size: 18px;">Formato para Devolución a Proveedor / Merma</h2>
        <p style="font-size: 12px;">Código: FO-VEN07-FAR-001</p>
    </div>
    <p style="text-align: center; font-size: 10px; margin-top: 20px;">
        La información contenida en este formato es de tipo confidencial y para uso exclusivo del SANATORIO VENECIA.
        Queda prohibida su reproducción parcial, total o la transmisión por cualquier sistema de recuperación y
        almacenaje de información, en ninguna forma, por ningún medio sin previa autorización de la Dirección General.
    </p>';

    // Añadir datos adicionales al PDF
    $html .= '<br><table cellpadding="4">
        <tr><td>Fecha:</td><td>' . $fecha_movimiento . '</td></tr>
        <tr><td>Movimiento:</td><td>' . $movimiento . '</td></tr>
    <tr><td>Factura:</td><td>' . $factura . '</td></tr> <!-- Aquí se utiliza la factura recuperada -->
    <tr><td>Proveedor:</td><td>' . htmlspecialchars($proveedor) . '</td></tr>
        <tr><td>Folio:</td><td>' . $folio . '</td></tr>
        <tr><td>Responsable:</td><td>' . $responsable . '</td></tr>
        <tr><td>Resolución:</td><td>' . $resolucion . '</td></tr>
        <tr><td>Área:</td><td>' . $areas . '</td></tr>
    </table><br>';

    // Agregar la tabla con los detalles de devolución
    $html .= '<table border="1" cellpadding="5">
        <tr>
            <th>Item</th>
            <th>Motivo</th>
            <th>Datos</th>
            <th>Cantidad a Devolver</th>
        </tr>';

    if (isset($_POST['motivo_seleccionado']) && isset($_POST['devolver_qty'])) {
        foreach ($_POST['motivo_seleccionado'] as $entrada_id => $motivo) {
            $cantidadDevolver = $_POST['devolver_qty'][$entrada_id] ?? '0';

            // Verificar si el motivo es "Otro" y obtener el valor del campo de texto
            if ($motivo === 'Otro') {
                $motivo = $_POST['otro_motivo'][$entrada_id] ?? ''; // Captura el motivo "otro"
            }

            // Consulta para obtener lote y caducidad desde la base de datos
            $query_lote_caducidad = "SELECT entrada_lote, item_id, entrada_caducidad FROM entradas_almacen WHERE entrada_id = ?";
            $stmt_lote_caducidad = $conexion->prepare($query_lote_caducidad);
            $stmt_lote_caducidad->bind_param("i", $entrada_id);
            $stmt_lote_caducidad->execute();
            $result_lote_caducidad = $stmt_lote_caducidad->get_result();
            $row_lote_caducidad = $result_lote_caducidad->fetch_assoc();

            $lote = htmlspecialchars($row_lote_caducidad['entrada_lote'] ?? '');
            $caducidad = htmlspecialchars($row_lote_caducidad['entrada_caducidad'] ?? '');
            $itemId = htmlspecialchars($row_lote_caducidad['item_id'] ?? '');

            // Consulta para obtener el nombre del ítem (item_name) desde la tabla item_almacen
            $query_item_name = "SELECT item_name FROM item_almacen WHERE item_id = ?";
            $stmt_item_name = $conexion->prepare($query_item_name);
            $stmt_item_name->bind_param("i", $itemId);
            $stmt_item_name->execute();
            $result_item_name = $stmt_item_name->get_result();
            $row_item_name = $result_item_name->fetch_assoc();

            $itemName = htmlspecialchars($row_item_name['item_name'] ?? ''); // Nombre del ítem

            // Generar la fila de la tabla con el nombre del ítem
            $html .= '<tr>
                    <td>' . $itemName . '</td> <!-- Mostrar el nombre del ítem aquí -->
                    <td>' . htmlspecialchars($motivo) . '</td>
                    <td> (Lote: ' . $lote . ', Caducidad: ' . $caducidad . ')</td>
                    <td>' . htmlspecialchars($cantidadDevolver) . '</td>
                </tr>';
        }
    }
    $html .= '</table>';
    // Escribir el contenido HTML en el PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Añadir espacio debajo de la tabla
    $pdf->Ln(10);

    // Configuración de las coordenadas y tamaño del cuadro grande
    $yPos = $pdf->GetY(); // Posición en Y actual después de la tabla
    $pageWidth = $pdf->getPageWidth(); // Ancho de la página
    $totalWidth = 200; // Ancho total del cuadro (ajustado según sea necesario)
    $height = 45; // Alto del cuadro (incrementado para más espacio)
    $numColumns = 5; // Número de columnas dentro del cuadro
    $columnWidth = $totalWidth / $numColumns; // Ancho de cada columna
    $xPos = ($pageWidth - $totalWidth) / 2; // Calcular la posición X para centrar el cuadro

    // Ajuste del tamaño de la fuente para que el texto entre en cada columna
    $pdf->SetFont('helvetica', '', 8); // Tamaño de fuente reducido a 8

    // Dibujar el cuadro grande
    $pdf->Rect($xPos, $yPos, $totalWidth, $height);

    // Textos de cada columna
    $signLabels = [
        'Nombre y firma del proveedor',
        'Nombre y firma del responsable del movimiento',
        'Nombre y firma de coordinación de farmacia',
        'Nombre y firma administración',
        'Nombre y firma responsable sanitario'
    ];

    // Dibujar las líneas de las columnas y el texto en cada sección
    for ($i = 0; $i < $numColumns; $i++) {
        // Coordenada X para cada columna
        $currentX = $xPos + ($i * $columnWidth);

        // Dibujar la línea de separación de columnas (excepto la primera)
        if ($i > 0) {
            $pdf->Line($currentX, $yPos, $currentX, $yPos + $height);
        }

        // Añadir el texto alineado en la parte superior de cada columna
        $pdf->MultiCell($columnWidth - 4, $height, $signLabels[$i], 0, 'C', 0, 1, $currentX + 2, $yPos + 0, true, 0, false, true, $height, 'B');
    }

    // Generar el PDF
    $pdf->Output('devolucion_proveedor_merma.pdf', 'I');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function mostrarOtroMotivo(selectElement, itemId) {
            const otroMotivoInput = document.getElementById("otro_motivo_" + itemId);
            otroMotivoInput.disabled = selectElement.value !== "Otro";
            if (otroMotivoInput.disabled) {
                otroMotivoInput.value = ""; // Limpiar si se deshabilita
            }
        }
    </script>
</head>

<body>
    <a href="kardex.php" class="btn btn-danger" style="margin-left: 10px; margin-bottom: 10px;">Regresar</a>

    <div class="form-container">
        <div style="border: 2px solid black; padding: 10px; text-align: center; width: 300px; margin: 0 auto; margin-bottom: 50px;">
            <h2>Formato para Devolución a Proveedor / Merma</h2>
            <p>Código: FO-VEN07-FAR-001</p>
        </div>

        <p style="text-align: center; margin-top: 20px;">
            La información contenida en este formato es de tipo confidencial y para uso exclusivo del SANATORIO VENECIA.
            Queda prohibida su reproducción parcial, total o la transmisión por cualquier sistema de recuperación y
            almacenaje de información, en ninguna forma, por ningún medio sin previa autorización de la Dirección General.
        </p>

        <form method="post" action="">


            <h3>Detalles del Movimiento</h3>
            <table>
                <tr>
                    <td>FECHA:</td>
                    <td><input type="date" name="fecha_movimiento"></td>
                </tr>
                <tr>
                    <td>MOVIMIENTO:</td>
                    <td>
                        <select name="Movimiento">
                            <option value="" selected disabled>Seleccione un movimiento</option>
                            <option value="Devolucion">Devolucion</option>
                            <option value="Merma">Merma</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>FACTURA:</td>
                    <td>
                        <select name="factura">
                            <option value="">Seleccione una factura</option>
                            <?php
                            // Generar las opciones para el select de facturas
                            while ($row_factura = mysqli_fetch_assoc($result_facturass)) {
                                echo '<option value="' . $row_factura['id_compra'] . '">' . $row_factura['factura'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr></tr>
                <td>ÁREA:</td>
                <td>
                    <select name="area">
                        <option value="">Seleccione un área</option>
                        <?php
                        // Consulta para obtener las ubicaciones
                        $ubicaciones = $conexion->query("SELECT ubicacion_id, nombre_ubicacion FROM ubicaciones_almacen") or die("Error al obtener ubicaciones: " . $conexion->error);


                        // Generar las opciones para el select de ubicaciones
                        while ($row_ubicacion = mysqli_fetch_assoc($ubicaciones)) {
                            echo '<option value="' . $row_ubicacion['ubicacion_id'] . '">' . $row_ubicacion['nombre_ubicacion'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
                </tr>
                <tr>
                    <td>RESPONSABLE DEL MOVIMIENTO:</td>
                    <td><input type="text" name="responsable_movimiento"></td>
                </tr>
                <tr>
                    <td>PROVEEDOR:</td>
                    <td>
                        <select name="proveedor">
                            <option value="">Seleccione un proveedor</option>
                            <?php
                            // Generar las opciones para el select de proveedores
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['id_prov'] . '">' . $row['nom_prov'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>FOLIO:</td>
                    <td><input type="text" name="folio"></td>
                </tr>
                <tr>
                    <td>RESOLUCIÓN DE LA SOLICITUD</td>
                    <td>
                        <select name="resolucion_solicitud">
                            <option value="">Seleccione una opción</option>
                            <option value="Aprobada">Aprobada</option>
                            <option value="Rechazada">Rechazada</option>
                            <option value="Reemplazo">Reemplazo</option>
                            <option value="Pendiente">Pendiente</option>
                        </select>
                    </td>
                </tr>
            </table>


            <label for="factura">Factura:</label>
            <select name="factura" id="factura" onchange="this.form.submit();">
                <option value="">Seleccione una factura</option>
                <?php if ($result_facturas->num_rows > 0) : ?>
                    <?php while ($row = $result_facturas->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($row['factura']); ?>">
                            <?php echo htmlspecialchars($row['factura']); ?>
                        </option>
                    <?php endwhile; ?>
                <?php else : ?>
                    <option value="">No hay facturas disponibles</option>
                <?php endif; ?>
            </select>

            <?php if (isset($_POST['factura']) && $result_items->num_rows > 0) : ?>
                <h3>Items de la Factura: <?php echo htmlspecialchars($factura); ?></h3>

                <table>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Motivo</th>
                        <th>Ítem</th>
                        <th>Cantidad a Devolver</th>
                    </tr>
                    <?php while ($row_item = $result_items->fetch_assoc()) : ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="seleccionar_item[<?php echo $row_item['entrada_id']; ?>]" value="1">
                            </td>
                            <td>
                                <select name="motivo_seleccionado[<?php echo $row_item['entrada_id']; ?>]" onchange="mostrarOtroMotivo(this, <?php echo $row_item['entrada_id']; ?>)">
                                    <option value="" selected disabled>Seleccione un motivo</option>
                                    <option value="Ruptura del envase">Ruptura del envase</option>
                                    <option value="Cambios de coloración o apariencia">Cambios de coloración o apariencia</option>
                                    <option value="Producto decolorado">Producto decolorado</option>
                                    <option value="Tabletas rotas o pulverizadas">Tabletas rotas o pulverizadas</option>
                                    <option value="Líquidos transparentes con partículas anormales">Líquidos transparentes con partículas anormales</option>
                                    <option value="Merma">Merma</option>
                                    <option value="Producto inflado">Producto inflado</option>
                                    <option value="Producto manchado">Producto manchado</option>
                                    <option value="Producto caducado">Producto caducado</option>
                                    <option value="Ausencia lote y caducidad">Ausencia lote y caducidad</option>
                                    <option value="Caducidad menor a un año">Caducidad menor a un año</option>
                                    <option value="Producto no solicitado">Producto no solicitado</option>
                                    <option value="Otro">Otro (especifique abajo)</option>
                                </select>
                                <input type="text" name="otro_motivo[<?php echo $row_item['entrada_id']; ?>]" id="otro_motivo_<?php echo $row_item['entrada_id']; ?>" placeholder="OTRO: especifique si seleccionó Otro" disabled>
                            </td>
                            <td><?php echo htmlspecialchars($row_item['item_id']) . " (Lote: " . htmlspecialchars($row_item['entrada_lote']) . ", Caducidad: " . htmlspecialchars($row_item['entrada_caducidad']) . ")"; ?></td>
                            <td>
                                <input type="number" name="devolver_qty[<?php echo $row_item['entrada_id']; ?>]" min="0" max="<?php echo htmlspecialchars($row_item['entrada_qty']); ?>">
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>


            <?php elseif (isset($_POST['factura'])) : ?>
                <p>No hay ítems disponibles para esta factura.</p>
            <?php endif; ?>


            <input type="submit" name="guardar" value="Enviar Devoluciones">
            <button type="submit" name="generar_pdf">Generar PDF</button>

        </form>
    </div>
</body>

</html>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .form-container {
        width: 80%;
        margin: 20px auto;
        background-color: #fdfdfd;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2,
    h3 {
        color: #0c675e;
        text-align: center;
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #0c675e;
        color: white;
    }

    td {
        background-color: #e8f6f4;
        vertical-align: middle;
    }

    input[type="text"],
    input[type="date"],
    select {
        width: calc(100% - 32px);
        padding: 15px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input[type="submit"],
    .btn-calcular {
        background-color: #0c675e;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10px;
    }

    input[type="submit"]:hover,
    .btn-calcular:hover {
        background-color: #084c47;
    }

    .scrollable-area {
        overflow-x: auto;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        background-color: #ffffff;
        white-space: nowrap;
    }

    .scrollable-area table {
        width: 100%;
        table-layout: auto;
    }
</style>