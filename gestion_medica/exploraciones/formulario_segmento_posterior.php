<?php
include("../header_medico.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Segmento Posterior</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Segmento Posterior</h2>
    <form action="guardar_segmento_posterior.php" method="POST">
        <div class="mb-3">
            <label>Bajo dilatación:</label>
            <select name="bajo_dilatacion" class="form-select">
                <option value="si">Sí</option>
                <option value="no">No</option>
            </select>
        </div>

        <!-- Checkbox para campos tinyint -->
        <?php
        $checkboxes = [
            'bajo_do' => 'Bajo DO',
            'bajo_dx' => 'Bajo DX',
            'bajo_total' => 'Bajo Total',
            'bajo_media' => 'Bajo Media',
            'bajo_no_dilata' => 'Bajo No Dilata',
            'no_valorable_od' => 'No Valorable OD',
            'no_valorable_oi' => 'No Valorable OI'
        ];

        foreach ($checkboxes as $name => $label) {
            echo "<div class='form-check'>
                    <input class='form-check-input' type='checkbox' name='$name' id='$name'>
                    <label class='form-check-label' for='$name'>$label</label>
                  </div>";
        }
        ?>

        <!-- Campos de texto -->
        <?php
        $textareas = [
            'vitreo_od' => 'Vítreo OD',
            'vitreo_oi' => 'Vítreo OI',
            'nervio_optico_od' => 'Nervio Óptico OD',
            'nervio_optico_oi' => 'Nervio Óptico OI',
            'retina_periferica_od' => 'Retina Periférica OD',
            'retina_periferica_oi' => 'Retina Periférica OI',
            'macula_od' => 'Mácula OD',
            'macula_oi' => 'Mácula OI',
            'observaciones_dibujo' => 'Observaciones / Dibujo'
        ];

        foreach ($textareas as $name => $label) {
            echo "<div class='mb-3'>
                    <label for='$name' class='form-label'>$label</label>
                    <textarea class='form-control' name='$name' id='$name' rows='2'></textarea>
                  </div>";
        }
        ?>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</body>
</html>
