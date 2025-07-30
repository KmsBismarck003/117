<?php
ob_start(); // Comienza el almacenamiento en búfer
session_start();
include "../../conexionbd.php";
include "../../sauxiliares/header_farmaciaq.php";

if (!isset($_SESSION['pac'])) {
    header("Location: seleccionar_paciente.php");
    exit;
}

$id_atencion = $_SESSION['id_atencion'];

// Obtener datos del paciente
$resultado_paciente = $conexion->query("SELECT pac.sapell, pac.papell, pac.nom_pac, pac.fecnac, pac.edad, pac.sexo, di.area, di.fecha, di.alergias, di.motivo_atn 
    FROM paciente pac 
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp 
    WHERE di.id_atencion = $id_atencion") or die($conexion->error);

$paciente = $resultado_paciente->fetch_assoc();

if (!$paciente) {
    die("No se encontró información del paciente.");
}

$fecha_ingreso = $paciente['fecha'];
$fecha_nacimiento = $paciente['fecnac'];
$diagnostico = $paciente['motivo_atn'];
$sexo = $paciente['sexo'];
$edad = $paciente['edad'];
$motivo_ingreso = $paciente['area'];

// Obtener datos de enfermedades
$resultado_enfermedades = $conexion->query("SELECT diabetes_tipo, diabetes_detalle, hipertension, hipotiroidismo, insuficiencia_renal, 
    depresion_ansiedad, enfermedad_prostata, epoc, insuficiencia_cardiaca, obesidad, 
    artritis, cancer, otro_enfermedad 
    FROM enf_concomitantes WHERE id_atencion = (SELECT Id_atencion FROM dat_ingreso WHERE id_atencion = $id_atencion)") 
    or die($conexion->error);

$enfermedades = $resultado_enfermedades->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica que todos los campos requeridos estén presentes
    if (isset($_POST['solucion'], $_POST['medicamento'], $_POST['vol_total'], $_POST['tiempo'], $_POST['velocidad'])) {
        // Obtén los datos del formulario
        $solucion = $conexion->real_escape_string($_POST['solucion']);
        $medicamento = $conexion->real_escape_string($_POST['medicamento']);
        $vol_total = $conexion->real_escape_string($_POST['vol_total']); // Mantener como VARCHAR
        $tiempo = $conexion->real_escape_string($_POST['tiempo']); // Mantener como VARCHAR
        $velocidad = $conexion->real_escape_string($_POST['velocidad']); // Mantener como VARCHAR

        // Inserta los datos en la tabla farma_soluciones
        $query = "INSERT INTO farma_soluciones (solucion, medicamento, vol_total, tiempo, velocidad) 
                  VALUES ('$solucion', '$medicamento', '$vol_total', '$tiempo', '$velocidad')";

        if ($conexion->query($query) === TRUE) {
            // Si se inserta correctamente, redirige con mensaje de éxito
            header("Location: soluciones.php?mensaje=exito");
            exit;
        } else {
            echo "Error al guardar los datos: " . $conexion->error;
        }
    } else {
        echo "Por favor completa todos los campos.";
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

        <!-- Formulario para agregar soluciones -->
        <form action="" method="POST">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead style="background-color: #0c675e; color: white;">
                <tr>
                    <th colspan="5" class="text-center">Datos de Soluciones y Medicamentos</th>
                </tr>
                <tr>
                    <th>Solución</th>
                    <th>Medicamento</th>
                    <th>Volumen Total (ml)</th>
                    <th>Tiempo (min)</th>
                    <th>Velocidad</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="solucion" class="form-control" required></td>
                    <td><input type="text" name="medicamento" class="form-control" required></td>
                    <td><input type="text" name="vol_total" class="form-control" required></td>
                    <td><input type="text" name="tiempo" class="form-control" required></td>
                    <td><input type="text" name="velocidad" class="form-control" required></td>
                </tr>
            </tbody>
        </table>
    </div>

    <button type="submit" class="btn btn-custom btn-block">Guardar</button>
</form>


        <!-- Mostrar mensaje de éxito si está presente -->
        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'exito') : ?>
            <div class="alert alert-success mt-3" role="alert">
                Se guardó exitosamente.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
