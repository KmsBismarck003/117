<?php
global $conexion;
ob_start();
session_start();
include "../../conexionbd.php";
require('../../fpdf/fpdf.php'); // Ajusta la ruta según la ubicación real

if (isset($_GET['id_compra'])) {
    $id_compra = $_GET['id_compra'];

    // Consulta para obtener la information de la orden de compra
    $query_orden = "SELECT * FROM ordenes_compra WHERE id_compra = '$id_compra'";
    $result_orden = $conexion->query($query_orden);
    $orden = $result_orden->fetch_assoc();

    // Consulta para obtener el nombre del proveedor
    $query_proveedor = "SELECT nom_prov FROM proveedores WHERE id_prov = '" . $orden['id_prov'] . "'";
    $result_proveedor = $conexion->query($query_proveedor);
    $proveedor = $result_proveedor->fetch_assoc();

    // Consulta para obtener los detalles de los productos de la orden de compra
    $query_detalles = "SELECT orden_compra.solicita, item_almacen.item_id, item_almacen.item_name, item_almacen.item_code, item_almacen.item_costs
                        FROM orden_compra
                        INNER JOIN item_almacen ON orden_compra.item_id = item_almacen.item_id
                        WHERE orden_compra.id_compra = '$id_compra'";
    $result_detalles = $conexion->query($query_detalles);

    if (!$orden) {
        echo "<script>alert('No se encontró la orden de compra');</script>";
        echo "<script>window.location='vista_ordenes.php';</script>";
        exit;
    }

    // Creación del PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);

    // Header
    $pdf->Image('../../imagenes/logo_pdf.jpg', 10, 8, 20, 23);

    // Título
    $pdf->Cell(0, 8, 'Detalles de la Orden de Compra #' . $id_compra, 0, 1, 'C');
    $pdf->Ln(15); // Espacio

    // Información de la Orden
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(30, 8, 'Proveedor:', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 8, htmlspecialchars($proveedor['nom_prov']), 0, 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(30, 8, 'Fecha de Solicitud:', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 8, htmlspecialchars($orden['fecha_solicitud']), 0, 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(30, 8, 'Monto Total:', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 8, "$" . htmlspecialchars(number_format($orden['monto'], 2)), 0, 1);

    $pdf->Ln(5); // Espacio

    // Tabla de Productos centrada
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(20, 6, '', 0, 0); // Espacio para centrar la tabla
    $pdf->Cell(20, 6, 'ID Item', 1, 0, 'C');
    $pdf->Cell(60, 6, 'Nombre', 1, 0, 'C');
    $pdf->Cell(25, 6, 'Codigo', 1, 0, 'C');
    $pdf->Cell(25, 6, 'Precio', 1, 0, 'C');
    $pdf->Cell(20, 6, 'Cantidad', 1, 0, 'C');
    $pdf->Cell(20, 6, 'Subtotal', 1, 0, 'C');
    $pdf->Ln();

    // Cuerpo de la tabla
    $pdf->SetFont('Arial', '', 8);
    $total = 0;
    if ($result_detalles->num_rows > 0) {
        while ($detalle = $result_detalles->fetch_assoc()) {
            $subtot = $detalle['item_costs'] * $detalle['solicita'];
            $total += $subtot;
            $pdf->Cell(20, 6, '', 0, 0); // Espacio para centrar la fila
            $pdf->Cell(20, 6, htmlspecialchars($detalle['item_id']), 1, 0, 'C');
            $pdf->Cell(60, 6, htmlspecialchars($detalle['item_name']), 1, 0, 'C');
            $pdf->Cell(25, 6, htmlspecialchars($detalle['item_code']), 1, 0, 'C');
            $pdf->Cell(25, 6, "$" . htmlspecialchars(number_format($detalle['item_costs'], 2)), 1, 0, 'C');
            $pdf->Cell(20, 6, htmlspecialchars($detalle['solicita']), 1, 0, 'C');
            $pdf->Cell(20, 6, "$" . htmlspecialchars(number_format($subtot, 2)), 1, 0, 'C');
            $pdf->Ln();
        }
        $pdf->SetX(30);
        $pdf->Cell(170, 6, "Total: $" . number_format($total, 2), 1, 0, 'R');
    } else {
        $pdf->Cell(0, 6, 'No se encontraron productos en esta orden de compra.', 0, 1, 'C');
    }

    // Guardar el PDF
    $output_path = './storage/detalle_orden_compra_' . $id_compra . '.pdf';
    $pdf->Output('F', $output_path);

    // Configuración del correo
    //$to = "cynthia_rogel@hotmail.com";
    $to = "bellagenio68@gmail.com";
    $subject = 'Detalles de la Orden de Compra #' . $id_compra;
    $boundary = md5(time()); // Crear un boundary único para separar partes del correo
    $headers = 'From: farmacia@metepec.simavenecia.com' . "\r\n" ."MIME-Version: 1.0\r\n";
    //$headers .= 'Cc: perla.s@sanatoriovenecia.com' . "\r\n";
    //$headers .= 'Cc: al222010075@gmail.com' . "\r\n";
    $headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";  // Cambiar a multipart/mixed

    // Construcción del mensaje
    $message = "--$boundary\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $message .= "Buen día,\n\nAdjunto encontrarás los detalles de la orden de compra enviado por farmacia del Sanatorio Venecia Metepec.\n\n";

    // Adjuntar el archivo PDF
    $file_content = file_get_contents($output_path);
    $encoded_file = chunk_split(base64_encode($file_content));
    $message .= "--$boundary\r\n";
    $message .= "Content-Type: application/pdf; name=\"detalle_orden_compra_$id_compra.pdf\"\r\n";
    $message .= "Content-Transfer-Encoding: base64\r\n";
    $message .= "Content-Disposition: attachment; filename=\"detalle_orden_compra_$id_compra.pdf\"\r\n\r\n";
    $message .= $encoded_file . "\r\n";
    $message .= "--$boundary--";

    // Enviar el correo
    if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('La orden de compra se ha actualizado y se ha enviado el correo con el PDF.'); window.location.href = 'ordenes_compra.php';</script>";
    } else {
        echo "<script>alert('No se pudo enviar el email'); window.location.href = 'ordenes_compra.php';</script>";
    }
}
?>