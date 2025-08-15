<?php
session_start();
include('../../conexionbd.php');

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $data = ['status' => 'false', 'error' => 'Invalid CSRF token'];
    echo json_encode($data);
    exit;
}

// Validate ID
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    $data = ['status' => 'false', 'error' => 'ID inválido o no proporcionado'];
    echo json_encode($data);
    exit;
}

$id_usua = $_POST['id_usua'];
$horai = $_POST['horai'];
$fechai = $_POST['fechai'];
$soluciones = $_POST['soluciones'];
$volumen = $_POST['volumen'];
$fr = date("Y-m-d H:i");
$id = $_POST['id'];

$stmt = $conexion->prepare("UPDATE `ingresos_quir` SET `id_usua`=?, `fecha`=?, `soluciones`=?, `hora`=?, `volumen`=?, `fecha_registro`=? WHERE id=?");
$stmt->bind_param("ssssssi", $id_usua, $fechai, $soluciones, $horai, $volumen, $fr, $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $data = ['status' => 'true'];
    } else {
        $data = ['status' => 'false', 'error' => 'No se actualizó ninguna fila (ID no encontrado o datos iguales)'];
    }
} else {
    $data = ['status' => 'false', 'error' => $conexion->error];
}
$stmt->close();
echo json_encode($data);
?>