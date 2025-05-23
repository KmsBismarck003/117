<?php
include("conexion.php");

$id = $_GET['id']; // ID del registro a editar
$sql = "SELECT * FROM segmento_anterior WHERE id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Segmento Anterior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Editar Exploración - Segmento Anterior</h4>
        </div>
        <div class="card-body">
            <form action="actualizar_segmento.php" method="POST">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">

                <div class="table-responsive">
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
                            $campos = [
                                "parpados" => "Párpados",
                                "conjuntiva_tarsal" => "Conjuntiva Tarsal",
                                "conjuntiva_bulbar" => "Conjuntiva Bulbar",
                                "cornea" => "Córnea",
                                "camara_anterior" => "Cámara Anterior",
                                "iris" => "Iris",
                                "pupila" => "Pupila",
                                "cristalino" => "Cristalino",
                                "gonioscopia" => "Gonioscopía"
                            ];

                            foreach ($campos as $campo => $etiqueta) {
                                echo "<tr>
                                    <td><label class='form-label'>$etiqueta</label></td>
                                    <td><input type='text' name='{$campo}_od' class='form-control' value='{$data[$campo . "_od"]}' required></td>
                                    <td><input type='text' name='{$campo}_oi' class='form-control' value='{$data[$campo . "_oi"]}' required></td>
                                </tr>";
                            }
                            ?>
                            <tr>
                                <td><label class="form-label">LOCS III</label></td>
                                <td>
                                    <select name="locs_od" class="form-select">
                                        <?php
                                        $locs_options = ["No seleccionado", "NC", "C", "P"];
                                        foreach ($locs_options as $opt) {
                                            $selected = $data["locs_od"] === $opt ? "selected" : "";
                                            echo "<option value='$opt' $selected>$opt</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="locs_oi" class="form-select">
                                        <?php
                                        foreach ($locs_options as $opt) {
                                            $selected = $data["locs_oi"] === $opt ? "selected" : "";
                                            echo "<option value='$opt' $selected>$opt</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" rows="4" class="form-control" required><?= $data['observaciones'] ?></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                    <a href="listar_segmento.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
