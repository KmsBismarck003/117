<?php
require 'conexion.php'; // Ajusta la ruta si es necesario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bajo_dilatacion = $_POST['bajo_dilatacion'];
    $bajo_do = isset($_POST['bajo_do']) ? 1 : 0;
    $bajo_dx = isset($_POST['bajo_dx']) ? 1 : 0;
    $bajo_total = isset($_POST['bajo_total']) ? 1 : 0;
    $bajo_media = isset($_POST['bajo_media']) ? 1 : 0;
    $bajo_no_dilata = isset($_POST['bajo_no_dilata']) ? 1 : 0;
    $no_valorable_od = isset($_POST['no_valorable_od']) ? 1 : 0;
    $no_valorable_oi = isset($_POST['no_valorable_oi']) ? 1 : 0;

    $vitreo_od = $_POST['vitreo_od'];
    $vitreo_oi = $_POST['vitreo_oi'];
    $nervio_optico_od = $_POST['nervio_optico_od'];
    $nervio_optico_oi = $_POST['nervio_optico_oi'];
    $retina_periferica_od = $_POST['retina_periferica_od'];
    $retina_periferica_oi = $_POST['retina_periferica_oi'];
    $macula_od = $_POST['macula_od'];
    $macula_oi = $_POST['macula_oi'];
    $observaciones_dibujo = $_POST['observaciones_dibujo'];

    $stmt = $conn->prepare("INSERT INTO segmento_post (
        bajo_dilatacion, bajo_do, bajo_dx, bajo_total, bajo_media, bajo_no_dilata, 
        no_valorable_od, no_valorable_oi, vitreo_od, vitreo_oi, nervio_optico_od, 
        nervio_optico_oi, retina_periferica_od, retina_periferica_oi, 
        macula_od, macula_oi, observaciones_dibujo
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param('siiiiiiisssssssss',
        $bajo_dilatacion, $bajo_do, $bajo_dx, $bajo_total, $bajo_media, $bajo_no_dilata,
        $no_valorable_od, $no_valorable_oi, $vitreo_od, $vitreo_oi, $nervio_optico_od,
        $nervio_optico_oi, $retina_periferica_od, $retina_periferica_oi,
        $macula_od, $macula_oi, $observaciones_dibujo
    );

    if ($stmt->execute()) {
    header("Location: listar_segmento_posterior.php?mensaje=guardado");
    } else {
        echo "<div style='padding:1rem; background:#f8d7da; color:#721c24;'>Error al insertar: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
