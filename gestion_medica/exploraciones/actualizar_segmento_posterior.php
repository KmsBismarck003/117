<?php
include '../../conexionbd.php';

if (!isset($_POST['id'])) {
    echo "ID no especificado.";
    exit;
}

$id = intval($_POST['id']);

// Campos binarios
$campos_binarios = [
    'bajo_do', 'bajo_dx', 'bajo_total', 'bajo_media',
    'bajo_no_dilata', 'no_valorable_od', 'no_valorable_oi'
];

$valores = [];

foreach ($campos_binarios as $campo) {
    $valores[$campo] = isset($_POST[$campo]) ? 1 : 0;
}

// Campos enum y text
$bajo_dilatacion = $_POST['bajo_dilatacion'] ?? 'si';
$valores['bajo_dilatacion'] = $bajo_dilatacion;

$campos_texto = [
    'vitreo_od', 'vitreo_oi',
    'nervio_optico_od', 'nervio_optico_oi',
    'retina_periferica_od', 'retina_periferica_oi',
    'macula_od', 'macula_oi',
    'observaciones_dibujo'
];

foreach ($campos_texto as $campo) {
    $valores[$campo] = mysqli_real_escape_string($conexion, $_POST[$campo] ?? '');
}

// Crear consulta UPDATE dinámicamente
$set = [];
foreach ($valores as $campo => $valor) {
    $set[] = "`$campo` = " . (is_numeric($valor) ? $valor : "'$valor'");
}
$set_query = implode(", ", $set);

$query = "UPDATE segmento_post SET $set_query WHERE id = $id";

if (mysqli_query($conexion, $query)) {
    header("Location: listar_segmento_posterior.php?mensaje=guardado");
} else {
    echo "Error al actualizar: " . mysqli_error($conexion);
}
