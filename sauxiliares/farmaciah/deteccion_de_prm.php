<?php
session_start();
include "../../conexionbd.php"; 
include "../header_farmaciah.php";


$id_atencion = $_SESSION['id_atencion'];

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

$resultado_enfermedades = $conexion->query("SELECT diabetes_tipo, diabetes_detalle, hipertension, hipotiroidismo, insuficiencia_renal, 
    depresion_ansiedad, enfermedad_prostata, epoc, insuficiencia_cardiaca, obesidad, 
    artritis, cancer, otro_enfermedad FROM enf_concomitantes WHERE id_atencion = (SELECT Id_atencion FROM dat_ingreso WHERE id_atencion = $id_atencion)") or die($conexion->error);

$enfermedades = $resultado_enfermedades->fetch_assoc();
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
            transition: background-color 0.3s ease; /* Transición suave para el hover */
        }

        .btn-custom:hover {
            background-color: #0b5e51; /* Color al pasar el mouse */
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
        <a href="perfil.php" class="btn btn-danger">Regresar</a>
        <a href="pdf.php" class="btn btn-success">Descargar PDF</a>
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

        <div class="text-center mt-3">
            <a href="prm_identificacion.php" class="btn btn-custom mx-2">Detección de PRM</a>
            <a href="soluciones.php" class="btn btn-custom mx-2">Soluciones</a>
            <a href="medicamentos.php" class="btn btn-custom mx-2">Medicamentos</a>
        </div>

    </div>
</body>
</html>
