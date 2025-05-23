<?php
include '../../conexionbd.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  die("ID no proporcionado.");
}

$query = "DELETE FROM ninobebe WHERE id = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
  header("Location: listar_nino_bebe.php?msg=eliminado");
  exit;
} else {
  echo "Error al eliminar: " . mysqli_error($conexion);
}
