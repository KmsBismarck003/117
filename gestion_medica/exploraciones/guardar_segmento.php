<?php
include 'conexion.php'; // Archivo que contiene la conexión a la base de datos

// Lista de campos esperados del formulario
$campos = [
    'parpados_od', 'parpados_oi',
    'conjuntiva_tarsal_od', 'conjuntiva_tarsal_oi',
    'conjuntiva_bulbar_od', 'conjuntiva_bulbar_oi',
    'cornea_od', 'cornea_oi',
    'camara_anterior_od', 'camara_anterior_oi',
    'iris_od', 'iris_oi',
    'pupila_od', 'pupila_oi',
    'cristalino_od', 'cristalino_oi',
    'locs_od', 'locs_oi',
    'gonioscopia_od', 'gonioscopia_oi',
    'observaciones'
];

// Escapar datos
$data = [];
foreach ($campos as $campo) {
    $data[$campo] = isset($_POST[$campo]) ? $conn->real_escape_string($_POST[$campo]) : '';
}

// Insertar en la tabla segmento_anterior
$sql = "INSERT INTO segmento_anterior (" . implode(',', array_keys($data)) . ")
        VALUES ('" . implode("','", array_values($data)) . "')";

if ($conn->query($sql) === TRUE) {
    header("Location: listar_segmento.php?mensaje=guardado");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
