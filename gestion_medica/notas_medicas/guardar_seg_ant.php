<?php
session_start();
include "../../conexionbd.php";

// Función para obtener campos de forma segura
function getPost($key) {
    return isset($_POST[$key]) ? trim($_POST[$key]) : null;
}

// Función para subir imágenes
function guardarImagen($fileInput, $folder = "img/") {
    if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] === UPLOAD_ERR_OK) {
        $nombre = basename($_FILES[$fileInput]['name']);
        $rutaRelativa = $folder . time() . "_" . $nombre;

        // ✅ SOLO UNA VEZ "INEOUpdate"
        $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . "/INEOUpdate/" . $rutaRelativa;

        // Crear carpeta si no existe
        if (!is_dir(dirname($rutaAbsoluta))) {
            mkdir(dirname($rutaAbsoluta), 0755, true);
        }

        if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $rutaAbsoluta)) {
            return $rutaRelativa;
        }
    }
    return null;
}
if ($conexion) {
    $id_exp = getPost('id_exp');
    $id_usua = getPost('id_usua');
    $id_atencion = getPost('id_atencion');
    $observaciones = getPost('observaciones');

    // Validación mínima
    if (!$id_exp || !$id_usua || !$id_atencion) {
        die("Faltan datos obligatorios.");
    }

    // Campos del segmento anterior
    $campos = [
        "parpados", "conj_tarsal", "conj_bulbar", "cornea",
        "camara_anterior", "iris", "pupila", "cristalino", "gonioscopia"
    ];
    $locs = ["no", "nc", "c", "p"];

    $datos = [];

    foreach ($campos as $campo) {
        $datos[$campo . "_od"] = getPost($campo . "_od");
        $datos[$campo . "_oi"] = getPost($campo . "_oi");
    }

    foreach ($locs as $tipo) {
        $datos["locs_" . $tipo . "_od"] = getPost("locs_" . $tipo . "_od");
        $datos["locs_" . $tipo . "_oi"] = getPost("locs_" . $tipo . "_oi");
    }

    // Manejo de imágenes
    $dibujo_od = guardarImagen('dibujo_od');
    $dibujo_oi = guardarImagen('dibujo_oi');

    // Armamos el INSERT dinámico
    $columnas = "id_atencion, id_exp, id_usua, observaciones";
    $valores = "'$id_atencion', '$id_exp', '$id_usua', " . ($observaciones ? "'" . $conexion->real_escape_string($observaciones) . "'" : "NULL");

    foreach ($datos as $col => $val) {
        $columnas .= ", $col";
        $valores .= ", " . ($val ? "'" . $conexion->real_escape_string($val) . "'" : "NULL");
    }

    $columnas .= ", dibujo_od, dibujo_oi";
    $valores .= ", " . ($dibujo_od ? "'$dibujo_od'" : "NULL") . ", " . ($dibujo_oi ? "'$dibujo_oi'" : "NULL");

    $sql = "INSERT INTO seg_ant ($columnas) VALUES ($valores)";

    if ($conexion->query($sql)) {
        header("Location: formulario_seg_ant.php");
    } else {
        echo "Error al guardar: " . $conexion->error;
    }

    $conexion->close();
} else {
    echo "Error de conexión a la base de datos.";
}
?>
