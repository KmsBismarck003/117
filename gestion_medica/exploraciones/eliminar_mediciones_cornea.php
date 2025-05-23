<?php
include '../../conexionbd.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM exploracion_oftalmologica WHERE id = $id";
    if (mysqli_query($conexion, $sql)) {
        header("Location: listar_exploraciones.php");
    } else {
        echo "Error al eliminar el registro.";
    }
}
?>
