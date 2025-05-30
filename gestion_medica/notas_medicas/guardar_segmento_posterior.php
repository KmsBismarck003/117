<?php
include "../../conexionbd.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bajo_dilatacion = $_POST['bajo_dilatacion'] ?? 'no';

    // Checkbox (tinyint)
    $checkbox_fields = [
        'bajo_do', 'bajo_dx', 'bajo_total', 'bajo_media',
        'bajo_no_dilata', 'no_valorable_od', 'no_valorable_oi'
    ];

    $checkbox_values = [];
    foreach ($checkbox_fields as $field) {
        $checkbox_values[$field] = isset($_POST[$field]) ? 1 : 0;
    }

    // Textarea
    $vitreo_od = $_POST['vitreo_od'] ?? '';
    $vitreo_oi = $_POST['vitreo_oi'] ?? '';
    $nervio_optico_od = $_POST['nervio_optico_od'] ?? '';
    $nervio_optico_oi = $_POST['nervio_optico_oi'] ?? '';
    $retina_periferica_od = $_POST['retina_periferica_od'] ?? '';
    $retina_periferica_oi = $_POST['retina_periferica_oi'] ?? '';
    $macula_od = $_POST['macula_od'] ?? '';
    $macula_oi = $_POST['macula_oi'] ?? '';
    $observaciones_dibujo = $_POST['observaciones_dibujo'] ?? '';

    if ($conexion) {
        $sql = "INSERT INTO segmento_post (
            bajo_dilatacion, bajo_do, bajo_dx, bajo_total, bajo_media,
            bajo_no_dilata, no_valorable_od, no_valorable_oi,
            vitreo_od, vitreo_oi, nervio_optico_od, nervio_optico_oi,
            retina_periferica_od, retina_periferica_oi,
            macula_od, macula_oi, observaciones_dibujo
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param(
            'siiiiiiisssssssss',
            $bajo_dilatacion,
            $checkbox_values['bajo_do'],
            $checkbox_values['bajo_dx'],
            $checkbox_values['bajo_total'],
            $checkbox_values['bajo_media'],
            $checkbox_values['bajo_no_dilata'],
            $checkbox_values['no_valorable_od'],
            $checkbox_values['no_valorable_oi'],
            $vitreo_od,
            $vitreo_oi,
            $nervio_optico_od,
            $nervio_optico_oi,
            $retina_periferica_od,
            $retina_periferica_oi,
            $macula_od,
            $macula_oi,
            $observaciones_dibujo
        );

        if ($stmt->execute()) {
            echo "<script>alert('Formulario guardado correctamente.'); window.location.href = 'formulario_segmento_posterior.php';</script>";
        } else {
            echo "<p>Error al guardar: " . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
        $conexion->close();
    } else {
        echo "<p>Error de conexión.</p>";
    }
}
?>
