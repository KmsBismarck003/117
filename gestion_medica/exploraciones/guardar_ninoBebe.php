<?php
// Incluir conexión a la base de datos
include '../../conexionbd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Escapar y guardar los datos del formulario
    $id_exp = mysqli_real_escape_string($conexion, $_POST['id_exp']);
    $reflejo_od = mysqli_real_escape_string($conexion, $_POST['reflejo_od']);
    $eje_visual_od = mysqli_real_escape_string($conexion, $_POST['eje_visual_od']);
    $fijacion_od = mysqli_real_escape_string($conexion, $_POST['fijacion_od']);
    $esquiascopia_od = mysqli_real_escape_string($conexion, $_POST['esquiascopia_od']);
    $posicion_od = mysqli_real_escape_string($conexion, $_POST['posicion_od']);

    $reflejo_oi = mysqli_real_escape_string($conexion, $_POST['reflejo_oi']);
    $eje_visual_oi = mysqli_real_escape_string($conexion, $_POST['eje_visual_oi']);
    $fijacion_oi = mysqli_real_escape_string($conexion, $_POST['fijacion_oi']);
    $esquiascopia_oi = mysqli_real_escape_string($conexion, $_POST['esquiascopia_oi']);
    $posicion_oi = mysqli_real_escape_string($conexion, $_POST['posicion_oi']);

    // Insertar en la base de datos
    $sql = "INSERT INTO ninobebe (
        id_exp, reflejo_od, eje_visual_od, fijacion_od, esquiascopia_od, posicion_od,
        reflejo_oi, eje_visual_oi, fijacion_oi, esquiascopia_oi, posicion_oi
    ) VALUES (
        '$id_exp', '$reflejo_od', '$eje_visual_od', '$fijacion_od', '$esquiascopia_od', '$posicion_od',
        '$reflejo_oi', '$eje_visual_oi', '$fijacion_oi', '$esquiascopia_oi', '$posicion_oi'
    )";

    if (mysqli_query($conexion, $sql)) {
        header("Location: listar_nino_bebe.php?mensaje=guardado");
        exit;
    } else {
        echo "<div class='alert alert-danger text-center mt-4'>Error: " . mysqli_error($conexion) . "</div>";
    }

    // Cerrar conexión
    mysqli_close($conexion);
}
?>
