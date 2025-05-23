<?php
include '../../conexionbd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $reflejo_od = $_POST['reflejo_od'];
    $eje_visual_od = $_POST['eje_visual_od'];
    $fijacion_od = $_POST['fijacion_od'];
    $esquiascopia_od = $_POST['esquiascopia_od'];
    $posicion_od = $_POST['posicion_od'];
    $reflejo_oi = $_POST['reflejo_oi'];
    $eje_visual_oi = $_POST['eje_visual_oi'];
    $fijacion_oi = $_POST['fijacion_oi'];
    $esquiascopia_oi = $_POST['esquiascopia_oi'];
    $posicion_oi = $_POST['posicion_oi'];

    $sql_update = "UPDATE ninobebe SET 
        reflejo_od = ?, eje_visual_od = ?, fijacion_od = ?, esquiascopia_od = ?, posicion_od = ?, 
        reflejo_oi = ?, eje_visual_oi = ?, fijacion_oi = ?, esquiascopia_oi = ?, posicion_oi = ? 
        WHERE id = ?";

    $stmt = mysqli_prepare($conexion, $sql_update);
    mysqli_stmt_bind_param($stmt, "ssssssssssi", 
        $reflejo_od, $eje_visual_od, $fijacion_od, $esquiascopia_od, $posicion_od,
        $reflejo_oi, $eje_visual_oi, $fijacion_oi, $esquiascopia_oi, $posicion_oi,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Exploración actualizada correctamente.'); window.location.href='listar_nino_bebe.php';</script>";
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso no válido.";
}
