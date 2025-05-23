<?php
require 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no válido.");
}

$id = $_GET['id'];
$sql = "SELECT * FROM exploraciones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$datos = $resultado->fetch_assoc();

if (!$datos) {
    die("Registro no encontrado.");
}

$pacientes = $conn->query("SELECT id_exp, nom_pac, papell FROM paciente");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Exploración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Editar Exploración: Párpados, Órbita y Vías Lagrimales</h4>
        </div>
        <div class="card-body">
            <form action="actualizar_exploracion.php" method="POST">
                <input type="hidden" name="id" value="<?= $datos['id'] ?>">

                <!-- Selección de paciente -->
                <div class="mb-3">
                    <label for="id_exp" class="form-label">Paciente</label>
                    <select class="form-select" name="id_exp" id="id_exp" required>
                        <option value="">Seleccione un paciente</option>
                        <?php while ($paciente = $pacientes->fetch_assoc()): ?>
                            <option value="<?= $paciente['id_exp'] ?>" <?= $paciente['id_exp'] == $datos['id_exp'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($paciente['nom_pac']) ?> (ApPat: <?= htmlspecialchars($paciente['papell']) ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Ojo Derecho -->
                <h5>Ojo Derecho</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Apertura Palpebral (mm)</label>
                        <input type="number" step="0.01" name="apertura_palpebral" class="form-control" value="<?= htmlspecialchars($datos['apertura_palpebral']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Hendidura Palpebral (mm)</label>
                        <input type="number" step="0.01" name="hendidura_palpebral" class="form-control" value="<?= htmlspecialchars($datos['hendidura_palpebral']) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Función del Músculo Elevador (mm)</label>
                        <input type="number" step="0.01" name="funcion_musculo_elevador" class="form-control" value="<?= htmlspecialchars($datos['funcion_musculo_elevador']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Fenómeno de Bell</label>
                        <select name="fenomeno_bell" class="form-select">
                            <option value="Normal" <?= $datos['fenomeno_bell'] == 'Normal' ? 'selected' : '' ?>>Normal</option>
                            <option value="Patológico" <?= $datos['fenomeno_bell'] == 'Patológico' ? 'selected' : '' ?>>Patológico</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Laxitud Horizontal</label>
                        <select name="laxitud_horizontal" class="form-select">
                            <?php foreach (['Normal', 'Leve', 'Moderada', 'Severa'] as $op): ?>
                                <option value="<?= $op ?>" <?= $datos['laxitud_horizontal'] == $op ? 'selected' : '' ?>><?= $op ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Laxitud Vertical</label>
                        <select name="laxitud_vertical" class="form-select">
                            <?php foreach (['Normal', 'Leve', 'Moderada', 'Severa'] as $op): ?>
                                <option value="<?= $op ?>" <?= $datos['laxitud_vertical'] == $op ? 'selected' : '' ?>><?= $op ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Desplazamiento Ocular</label>
                        <select name="desplazamiento_ocular" class="form-select">
                            <option value="Enoftalmos" <?= $datos['desplazamiento_ocular'] == 'Enoftalmos' ? 'selected' : '' ?>>Enoftalmos</option>
                            <option value="Exoftalmos" <?= $datos['desplazamiento_ocular'] == 'Exoftalmos' ? 'selected' : '' ?>>Exoftalmos</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Maniobra de Vatsalva</label>
                        <select name="maniobra_vatsaha" class="form-select">
                            <option value="Sí" <?= $datos['maniobra_vatsaha'] == 'Sí' ? 'selected' : '' ?>>Sí</option>
                            <option value="No" <?= $datos['maniobra_vatsaha'] == 'No' ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                </div>

                <!-- Ojo Izquierdo -->
                <h5 class="mt-4">Ojo Izquierdo</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Apertura Palpebral (mm)</label>
                        <input type="number" step="0.01" name="apertura_palpebral_oi" class="form-control" value="<?= htmlspecialchars($datos['apertura_palpebral_oi']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Hendidura Palpebral (mm)</label>
                        <input type="number" step="0.01" name="hendidura_palpebral_oi" class="form-control" value="<?= htmlspecialchars($datos['hendidura_palpebral_oi']) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Función del Músculo Elevador (mm)</label>
                        <input type="number" step="0.01" name="funcion_musculo_elevador_oi" class="form-control" value="<?= htmlspecialchars($datos['funcion_musculo_elevador_oi']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Fenómeno de Bell (OI)</label>
                        <select name="fenomeno_bell_oi" class="form-select">
                            <option value="Normal" <?= $datos['fenomeno_bell_oi'] == 'Normal' ? 'selected' : '' ?>>Normal</option>
                            <option value="Patológico" <?= $datos['fenomeno_bell_oi'] == 'Patológico' ? 'selected' : '' ?>>Patológico</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Laxitud Horizontal (OI)</label>
                        <select name="laxitud_horizontal_oi" class="form-select">
                            <?php foreach (['Normal', 'Leve', 'Moderada', 'Severa'] as $op): ?>
                                <option value="<?= $op ?>" <?= $datos['laxitud_horizontal_oi'] == $op ? 'selected' : '' ?>><?= $op ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Laxitud Vertical (OI)</label>
                        <select name="laxitud_vertical_oi" class="form-select">
                            <?php foreach (['Normal', 'Leve', 'Moderada', 'Severa'] as $op): ?>
                                <option value="<?= $op ?>" <?= $datos['laxitud_vertical_oi'] == $op ? 'selected' : '' ?>><?= $op ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Desplazamiento Ocular (OI)</label>
                        <select name="desplazamiento_ocular_oi" class="form-select">
                            <option value="Enoftalmos" <?= $datos['desplazamiento_ocular_oi'] == 'Enoftalmos' ? 'selected' : '' ?>>Enoftalmos</option>
                            <option value="Exoftalmos" <?= $datos['desplazamiento_ocular_oi'] == 'Exoftalmos' ? 'selected' : '' ?>>Exoftalmos</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Maniobra de Vatsalva (OI)</label>
                        <select name="maniobra_vatsaha_oi" class="form-select">
                            <option value="Sí" <?= $datos['maniobra_vatsaha_oi'] == 'Sí' ? 'selected' : '' ?>>Sí</option>
                            <option value="No" <?= $datos['maniobra_vatsaha_oi'] == 'No' ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="mb-3">
                    <label>Observaciones</label>
                    <textarea name="observaciones" class="form-control"><?= htmlspecialchars($datos['observaciones']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="listar_exploraciones.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
