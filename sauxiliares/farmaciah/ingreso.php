<?php
session_start();
include "../../conexionbd.php";
include "../../sauxiliares/header_farmaciah.php";

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Verifica si existe id_atencion en la sesión
if (!isset($_SESSION['id_atencion'])) {
    // Manejo del error: redirigir o mostrar un mensaje
    echo "Error: No se ha encontrado 'id_atencion'.";
    exit; // Detener la ejecución del script
}

$id_atencion = $_SESSION['id_atencion']; // Asegúrate de que esto esté definido


// Obtener información del paciente, la fecha de ingreso, alergias y diagnóstico
$resultado_paciente = $conexion->query("
    SELECT pac.sapell, pac.papell, pac.nom_pac, pac.fecnac, di.fecha, di.alergias, di.motivo_atn, di.Id_exp 
    FROM paciente pac 
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp 
    WHERE di.id_atencion = $id_atencion
") or die($conexion->error);

$paciente = $resultado_paciente->fetch_assoc();

// Verifica que se haya encontrado un paciente
if (!$paciente) {
    echo "Error: Paciente no encontrado.";
    exit; // Detener la ejecución del script
}

// Obtener la fecha de ingreso, fecha de nacimiento y diagnóstico del paciente
$fecha_ingreso = $paciente['fecha']; // Fecha de ingreso desde la tabla dat_ingreso
$fecha_nacimiento = $paciente['fecnac']; // Fecha de nacimiento del paciente
$diagnostico = $paciente['motivo_atn']; // Diagnóstico del paciente
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
            background-color: #f8f9fa; /* Color de fondo suave */
        }

        .container {
            margin-top: 20px;
            background-color: white; /* Fondo blanco para el contenedor */
            padding: 20px;
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }

        h2 {
            color: #0c675e; /* Color del encabezado */
            margin-bottom: 10px; /* Espaciado inferior */
        }

        .btn-custom {
            background-color: #0c675e;
            color: white;
            border-radius: 5px; /* Bordes redondeados */
        }

        .btn-custom:hover {
            background-color: #0b5e51; /* Color al pasar el mouse */
        }

        .code-info {
            text-align: right;
            font-size: 14px;
            color: #343a40; /* Color del texto */
            margin-bottom: 20px; /* Espaciado inferior */
        }

        .patient-info {
            margin-top: 15px;
        }

        .patient-info p {
            margin: 0; /* Eliminar márgenes para compactar la visualización */
        }

        .text-right {
            text-align: right; /* Alinear texto a la derecha */
        }

        .no-margin {
            margin-bottom: 0; /* Eliminar margen inferior */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="code-info">
            <p>Código: FO-VEN20-FAR-001</p>
            <p>VERSIÓN: NUEVO</p>
        </div>

        <a href="conc_de_ingreso.php" class="btn btn-danger">Regresar</a> <!-- Botón para regresar -->
        <a href="generear_conc_pdf.php" class="btn btn-success" target="_blank">Descargar PDF</a>

        <h2>CONCILIACIÓN DE INGRESO</h2>
        <h4>Nombre: <?php echo $paciente['papell'] . ' ' . $paciente['sapell'] . ' ' . $paciente['nom_pac']; ?></h4>
        
        <p class="no-margin"><strong>Fecha de Nacimiento:</strong> <?php echo $fecha_nacimiento; ?></p> <!-- Mostrar fecha de nacimiento -->
        
        <!-- NUEVO BLOQUE: mostrar Id_atencion e Id_exp -->
<p class="no-margin"><strong>ID Atención:</strong> <?php echo $id_atencion; ?></p>
<p class="no-margin"><strong>ID Expediente:</strong> <?php echo $paciente['Id_exp']; ?></p>

        <div class="row">
            <div class="col text-right">
                <p><strong>Fecha de Ingreso:</strong> <?php echo $fecha_ingreso; ?></p> <!-- Mostrar fecha de ingreso -->
            </div>
        </div>
        
        <div class="row">
            <div class="col text-right">
                <p><strong>Alergias:</strong> <?php echo $paciente['alergias']; ?></p> <!-- Mostrar alergias -->
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <p><strong>Diagnóstico:</strong> <?php echo $diagnostico; ?></p> <!-- Mostrar diagnóstico -->
            </div>
        </div>
        
        <a href="enf_concomitantes.php" class="btn btn-custom mt-3">Enfermedades Concomitantes</a>
        <a href="trat_farmacologico.php" class="btn btn-custom mt-3">Tratamiento Farmacológico</a>
        <!-- <a href="cont_tratamiento.php" class="btn btn-custom mt-3">Continuidad De Tratamiento Crónico</a> -->
    </div>
</body>
</html>
