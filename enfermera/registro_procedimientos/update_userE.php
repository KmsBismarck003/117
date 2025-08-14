<?php
session_start();
include('../../conexionbd.php');

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $data = ['status' => 'false', 'error' => 'Invalid CSRF token'];
    echo json_encode($data);
    exit;
}

$id_usua = $_POST['id_usua'];
$horae = $_POST['horae'];
$fechae = $_POST['fechae'];
$solucionese = $_POST['solucionese'];
$volumene = $_POST['volumene'];
$fr = date("Y-m-d H:i");
$id = $_POST['id'];

$stmt = $conexion->prepare("UPDATE `egresos_quir` SET `id_usua`=?, `fecha`=?, `soluciones`=?, `hora`=?, `volumen`=?, `fecha_registro`=? WHERE id=?");
$stmt->bind_param("ssssssi", $id_usua, $fechae, $solucionese, $horae, $volumene, $fr, $id);

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