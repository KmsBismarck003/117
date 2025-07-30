<?php
session_start();
include "../../conexionbd.php";
include "../../sauxiliares/header_farmaciaq.php";

// Verifica que haya un paciente seleccionado en la sesión
if (!isset($_SESSION['pac'])) {
    header("Location: seleccionar_paciente.php"); // Redirigir si no hay paciente seleccionado
    exit; // Asegúrate de usar exit después de header
}

$id_atencion = $_SESSION['id_atencion'];

// Obtener información del paciente, la fecha de ingreso, alergias y diagnóstico
$resultado_paciente = $conexion->query("SELECT pac.sapell, pac.papell, pac.nom_pac, pac.fecnac, pac.edad, pac.sexo, di.area, di.fecha, di.alergias, di.motivo_atn 
    FROM paciente pac 
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp 
    WHERE di.id_atencion = $id_atencion") or die($conexion->error);

$paciente = $resultado_paciente->fetch_assoc();

// Asegúrate de que la consulta devolvió resultados
if (!$paciente) {
    die("No se encontró información del paciente.");
}

// Obtener la fecha de ingreso, fecha de nacimiento y diagnóstico del paciente
$fecha_ingreso = $paciente['fecha'];
$fecha_nacimiento = $paciente['fecnac'];
$diagnostico = $paciente['motivo_atn'];
$sexo = $paciente['sexo'];
$edad = $paciente['edad'];
$motivo_ingreso = $paciente['area'];

// Obtener enfermedades concomitantes del paciente
$resultado_enfermedades = $conexion->query("SELECT diabetes_tipo, diabetes_detalle, hipertension, hipotiroidismo, insuficiencia_renal, 
    depresion_ansiedad, enfermedad_prostata, epoc, insuficiencia_cardiaca, obesidad, 
    artritis, cancer, otro_enfermedad FROM enf_concomitantes WHERE id_atencion = (SELECT Id_atencion FROM dat_ingreso WHERE id_atencion = $id_atencion)") or die($conexion->error);

$enfermedades = $resultado_enfermedades->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $fecha_revision = $_POST['fecha_revision'];
    $inter_cantidad = $_POST['inter_cantidad'];
    $inter_estrategia = $_POST['inter_estrategia'];
    $inter_educacion = $_POST['inter_educacion'];
    $via_comunicacion = $_POST['via_comunicacion'];
    

    // Preparar la consulta SQL
    $query = "INSERT INTO accion_resolver (fecha_revision, inter_cantidad, inter_estrategia, inter_educacion,via_comunicacion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Vincular los parámetros
        $stmt->bind_param("sssss", $fecha_revision, $inter_cantidad, $inter_estrategia, $inter_educacion, $via_comunicacion);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>alert('Registro guardado exitosamente.'); window.location.href='prm_identificacion.php';</script>";
            exit;
        } else {
            echo "<script>alert('Error al guardar el registro: " . $stmt->error . "'); window.history.back();</script>";
            exit;
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error en la preparación de la consulta: " . $conexion->error . "'); window.history.back();</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Ingreso</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header-bar {
            background-color: #0c675e;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-custom {
            background-color: #0c675e;
            color: white;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #0b5e51;
        }

        .code-info {
            text-align: right;
            font-size: 14px;
            color: #343a40;
            margin-bottom: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #0c675e;
            color: white;
        }

        .card-body {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="code-info">
            <p>Código: FO-VEN20-FAR-001</p>
            <p>VERSIÓN: NUEVO</p>
        </div>
        
        <div class="action-buttons">
            <a href="deteccion_de_prm.php" class="btn btn-danger back-btn">Regresar</a>
        </div>

        <div class="header-bar">
            PERFIL FARMACOTERAPEUTICO
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Datos del Paciente</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> <?php echo $paciente['papell'] . ' ' . $paciente['sapell'] . ' ' . $paciente['nom_pac']; ?></p>
                        <p><strong>Fecha de Nacimiento:</strong> <?php echo $fecha_nacimiento; ?></p>
                        <p><strong>Edad:</strong> <?php echo $edad; ?></p>
                        <p><strong>Sexo:</strong> <?php echo $sexo; ?></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p><strong>Fecha de Ingreso:</strong> <?php echo $fecha_ingreso; ?></p>
                        <p><strong>Motivo de Ingreso:</strong> <?php echo $motivo_ingreso; ?></p>
                        <p><strong>Alergias:</strong> <?php echo $paciente['alergias']; ?></p>
                        <p><strong>Diagnóstico:</strong> <?php echo $diagnostico; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <a href="prm_identificacion.php" class="btn btn-custom mt-3">Detección de PRM (Identificación)</a>
        <a href="prm_accion.php" class="btn btn-custom mt-3">Detección de PRM (Accion)</a>
        <a href="prm_resultado.php" class="btn btn-custom mt-3">Detección de PRM (Resultado)</a>
        <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Registro de PRM (ACCION)</h4>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="fecha">Fecha de Revisión:</label>
                        <input type="date" class="form-control" id="fecha_revision" name="fecha_revision" required>
                    </div>

                    <div class="form-group">
                        <label>Intervención sobre la cantidad de medicamento:</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="inter_cantidad1" name="inter_cantidad" value="Modificar la dosis" required>
                                <label for="inter_cantidad1">Modificar la dosis</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="inter_cantidad2" name="inter_cantidad" value="Modificar la dosificación">
                                <label for="inter_cantidad2">Modificar la dosificación</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="inter_cantidad3" name="inter_cantidad" value="Modificar la pauta de administración">
                                <label for="inter_cantidad3">Modificar la pauta de administración</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Intervenir sobre la estrategia farmacológica:</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="inter_estrategia1" name="inter_estrategia" value="Añadir medicamento" required>
                                <label for="inter_estrategia1">Añadir medicamento</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="inter_estrategia2" name="inter_estrategia" value="Retirar medicamento">
                                <label for="inter_estrategia2">Retirar medicamento</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="inter_estrategia3" name="inter_estrategia" value="Sustituir medicamento">
                                <label for="inter_estrategia3">Sustituir medicamento</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Intervenir en la educación del paciente:</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="inter_educacion1" name="inter_educacion" value="Disminuir el incumplimiento involuntario" required>
                                <label for="inter_educacion1">Disminuir el incumplimiento involuntario</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="inter_educacion2" name="inter_educacion" value="Disminuir el incumplimiento voluntario">
                                <label for="inter_educacion2">Disminuir el incumplimiento voluntario</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="inter_educacion3" name="inter_educacion" value="Educar en medidas no farmacológicas">
                                <label for="inter_educacion3">Educar en medidas no farmacológicas</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Vía de comunicación:</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="via_comunicacion1" name="via_comunicacion" value="Verbal para el paciente" required>
                                <label for="via_comunicacion1">Verbal para el paciente</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="via_comunicacion2" name="via_comunicacion" value="Escrita para el paciente">
                                <label for="via_comunicacion2">Escrita para el paciente</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="via_comunicacion3" name="via_comunicacion" value="Verbal para el médico">
                                <label for="via_comunicacion3">Verbal para el médico</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="via_comunicacion4" name="via_comunicacion" value="Escrita para el médico">
                                <label for="via_comunicacion4">Escrita para el médico</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-custom btn-lg btn-block">Guardar Registro</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>