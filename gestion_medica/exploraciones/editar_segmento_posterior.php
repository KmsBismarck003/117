<?php
include("conexion.php");

$id = $_GET['id'];
$sql = "SELECT * FROM segmento_post WHERE id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Segmento Posterior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Editar Exploración - Segmento Posterior</h4>
        </div>
        <div class="card-body">
            <form action="actualizar_segmento_posterior.php" method="POST">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="bajo_dilatacion" class="form-label">Bajo dilatación</label>
                        <select name="bajo_dilatacion" class="form-select">
                            <option value="si" <?= $data['bajo_dilatacion'] == 'si' ? 'selected' : '' ?>>Sí</option>
                            <option value="no" <?= $data['bajo_dilatacion'] == 'no' ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                    <?php
                    $checkboxes = [
                        'bajo_do' => 'Bajo OD',
                        'bajo_dx' => 'Bajo OI',
                        'bajo_total' => 'Bajo Total',
                        'bajo_media' => 'Bajo Media',
                        'bajo_no_dilata' => 'No dilata',
                        'no_valorable_od' => 'No valorable OD',
                        'no_valorable_oi' => 'No valorable OI'
                    ];
                    foreach ($checkboxes as $campo => $etiqueta) {
                        echo "<div class='col-md-4 form-check mt-4'>
                                <input type='checkbox' class='form-check-input' id='$campo' name='$campo' value='1' " . ($data[$campo] ? 'checked' : '') . ">
                                <label class='form-check-label' for='$campo'>$etiqueta</label>
                              </div>";
                    }
                    ?>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Estructura</th>
                                <th>Ojo Derecho</th>
                                <th>Ojo Izquierdo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $estructuras = [
                                "vitreo" => "Vítreo",
                                "nervio_optico" => "Nervio óptico",
                                "retina_periferica" => "Retina Periférica",
                                "macula" => "Mácula"
                            ];
                            foreach ($estructuras as $clave => $etiqueta) {
                                echo "<tr>
                                    <td><label class='form-label'>$etiqueta</label></td>
                                    <td><textarea name='{$clave}_od' class='form-control' rows='2'>{$data[$clave . '_od']}</textarea></td>
                                    <td><textarea name='{$clave}_oi' class='form-control' rows='2'>{$data[$clave . '_oi']}</textarea></td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <label for="observaciones_dibujo" class="form-label">Observaciones y dibujo</label>
                    <textarea name="observaciones_dibujo" id="observaciones_dibujo" rows="4" class="form-control"><?= $data['observaciones_dibujo'] ?></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                    <a href="listar_segmento_posterior.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
