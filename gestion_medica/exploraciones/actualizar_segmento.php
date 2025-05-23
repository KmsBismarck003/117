<?php
include("conexion.php");

$id = $_POST['id'];

// Recoger datos
$campos = [
    "parpados", "conjuntiva_tarsal", "conjuntiva_bulbar", "cornea",
    "camara_anterior", "iris", "pupila", "cristalino", "gonioscopia"
];

$updates = [];

foreach ($campos as $campo) {
    $od = mysqli_real_escape_string($conn, $_POST["{$campo}_od"]);
    $oi = mysqli_real_escape_string($conn, $_POST["{$campo}_oi"]);
    $updates[] = "{$campo}_od = '$od'";
    $updates[] = "{$campo}_oi = '$oi'";
}

$locs_od = mysqli_real_escape_string($conn, $_POST["locs_od"]);
$locs_oi = mysqli_real_escape_string($conn, $_POST["locs_oi"]);
$observaciones = mysqli_real_escape_string($conn, $_POST["observaciones"]);

$updates[] = "locs_od = '$locs_od'";
$updates[] = "locs_oi = '$locs_oi'";
$updates[] = "observaciones = '$observaciones'";

$update_query = "UPDATE segmento_anterior SET " . implode(", ", $updates) . " WHERE id = $id";

if (mysqli_query($conn, $update_query)) {
    header("Location: listar_segmento.php?actualizado=1");
    exit();
} else {
    echo "Error al actualizar: " . mysqli_error($conn);
}
?>
