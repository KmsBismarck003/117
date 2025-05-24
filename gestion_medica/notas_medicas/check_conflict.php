<?php
session_start();
include "../../conexionbd.php";

if (isset($_POST['id_atencion']) && isset($_POST['date']) && isset($_POST['time'])) {
    $id_atencion = $_POST['id_atencion'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $datetime = date('Y-m-d H:i:s', strtotime("$date $time"));

    $stmt = $conexion->prepare("SELECT COUNT(*) as count FROM dat_ingreso WHERE id_atencion = ? AND fecha BETWEEN DATE_SUB(?, INTERVAL 1 HOUR) AND DATE_ADD(?, INTERVAL 1 HOUR)");
    $stmt->bind_param("iss", $id_atencion, $datetime, $datetime);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    echo $row['count'] > 0 ? 'true' : 'false';
}

$conexion->close();
?>