<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $id_exp = $_POST['id_exp'];

    $apertura_palpebral = $_POST['apertura_palpebral'];
    $hendidura_palpebral = $_POST['hendidura_palpebral'];
    $funcion_musculo_elevador = $_POST['funcion_musculo_elevador'];
    $fenomeno_bell = $_POST['fenomeno_bell'];
    $laxitud_horizontal = $_POST['laxitud_horizontal'];
    $laxitud_vertical = $_POST['laxitud_vertical'];
    $desplazamiento_ocular = $_POST['desplazamiento_ocular'];
    $maniobra_vatsaha = $_POST['maniobra_vatsaha'];

    $apertura_palpebral_oi = $_POST['apertura_palpebral_oi'];
    $hendidura_palpebral_oi = $_POST['hendidura_palpebral_oi'];
    $funcion_musculo_elevador_oi = $_POST['funcion_musculo_elevador_oi'];
    $fenomeno_bell_oi = $_POST['fenomeno_bell_oi'];
    $laxitud_horizontal_oi = $_POST['laxitud_horizontal_oi'];
    $laxitud_vertical_oi = $_POST['laxitud_vertical_oi'];
    $desplazamiento_ocular_oi = $_POST['desplazamiento_ocular_oi'];
    $maniobra_vatsaha_oi = $_POST['maniobra_vatsaha_oi'];

    $observaciones = $_POST['observaciones'];

    $sql = "UPDATE exploraciones SET 
        id_exp = ?, 
        apertura_palpebral = ?, 
        hendidura_palpebral = ?, 
        funcion_musculo_elevador = ?, 
        fenomeno_bell = ?, 
        laxitud_horizontal = ?, 
        laxitud_vertical = ?, 
        desplazamiento_ocular = ?, 
        maniobra_vatsaha = ?, 
        apertura_palpebral_oi = ?, 
        hendidura_palpebral_oi = ?, 
        funcion_musculo_elevador_oi = ?, 
        fenomeno_bell_oi = ?, 
        laxitud_horizontal_oi = ?, 
        laxitud_vertical_oi = ?, 
        desplazamiento_ocular_oi = ?, 
        maniobra_vatsaha_oi = ?, 
        observaciones = ?
        WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idddssssssssssssssi",  
        $id_exp, 
        $apertura_palpebral, 
        $hendidura_palpebral, 
        $funcion_musculo_elevador, 
        $fenomeno_bell, 
        $laxitud_horizontal, 
        $laxitud_vertical, 
        $desplazamiento_ocular, 
        $maniobra_vatsaha, 
        $apertura_palpebral_oi, 
        $hendidura_palpebral_oi, 
        $funcion_musculo_elevador_oi, 
        $fenomeno_bell_oi, 
        $laxitud_horizontal_oi, 
        $laxitud_vertical_oi, 
        $desplazamiento_ocular_oi, 
        $maniobra_vatsaha_oi, 
        $observaciones,
        $id
    );

    if ($stmt->execute()) {
        echo "<script>alert('Exploración actualizada correctamente'); window.location.href='listar_exploraciones.php';</script>";
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
