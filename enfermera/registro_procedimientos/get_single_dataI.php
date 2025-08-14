<?php
include('../../conexionbd.php');
$id = $_POST['id'];

$stmt = $conexion->prepare("SELECT * FROM ingresos_quir WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'No se encontró el registro con ID: ' . $id]);
}
$stmt->close();
?>