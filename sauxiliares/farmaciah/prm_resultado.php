<?php
session_start();
include "../../conexionbd.php";
include "../../sauxiliares/header_farmaciah.php";

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
    $fecha = $_POST['fecha'];
    $intervencion = $_POST['intervencion'];
    $problema = $_POST['problema'];
    $resultado = $_POST['resultado'];
    $salud_resuelto = $_POST['salud_resuelto'];
    $salud_no_resuelto = $_POST['salud_no_resuelto'];

    // Preparar la consulta SQL
    $query = "INSERT INTO prm_resultado (fecha, intervencion, problema, resultado, salud_resuelto, salud_no_resuelto) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Vincular los parámetros
        $stmt->bind_param("ssssss", $fecha, $intervencion, $problema, $resultado, $salud_resuelto, $salud_no_resuelto);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>alert('Registro guardado exitosamente.'); window.location.href='prm_identificacion.php';</script>";
            exit;
        } else {
            echo "<script>alert('Error al guardar el registro: " . $stmt->error . "');</script>";
            exit;
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error en la preparación de la consulta: " . $conexion->error . "');</script>";
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

        .row-divider {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="code-info">
            <p>Código: FO-VEN20-FAR-001</p>
            <p>VERSIÓN: NUEVO</p>
        </div>
        <a href="deteccion_de_prm.php" class="btn btn-danger">Regresar</a>
        <div class="header-bar">
            PERFIL FARMACOTERAPEUTICO
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Datos del Paciente</h4>
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
                    <h4>Registro de PRM (RESULTADO)</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="fecha">Fecha fin de la intervención:</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                        <div class="form-group">
                            <label>¿Qué ocurrió con la intervención?:</label>
                            <input type="text" class="form-control" name="intervencion" required>
                        </div>
                        <div class="form-group">
                            <label>¿Qué ocurrió con el problema de salud?:</label>
                            <input type="text" class="form-control" name="problema" required>
                        </div>
                        <div class="form-group">
                            <label for="resultado">Resultado:</label>
                            <select class="form-control" id="resultado" name="resultado" required>
                                <option value="I Aceptado">I Aceptado</option>
                                <option value="II No Aceptado">II No Aceptado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>P. Salud resuelto:</label>
                            <input type="text" class="form-control" name="salud_resuelto" required>
                        </div>
                        <div class="form-group">
                            <label>P. Salud No resuelto:</label>
                            <input type="text" class="form-control" name="salud_no_resuelto" required>
                        </div>
                        <button type="submit" class="btn btn-custom mt-3">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
