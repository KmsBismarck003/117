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
    SELECT pac.sapell, pac.papell, pac.nom_pac, pac.fecnac, pac.edad, pac.sexo, di.area, di.fecha, di.alergias, di.motivo_atn 
    FROM paciente pac 
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp 
    WHERE di.id_atencion = '$id_atencion' /* Cambiado para usar id_atencion */
") or die($conexion->error);

$paciente = $resultado_paciente->fetch_assoc();

// Obtener la fecha de ingreso, fecha de nacimiento y diagnóstico del paciente
$fecha_ingreso = $paciente['fecha']; // Fecha de ingreso desde la tabla dat_ingreso
$fecha_nacimiento = $paciente['fecnac']; // Fecha de nacimiento del paciente
$diagnostico = $paciente['motivo_atn']; // Diagnóstico del paciente
$sexo = $paciente['sexo'];
$edad = $paciente['edad'];
$motivo_ingreso = $paciente['area'];

$enfermedades=NULL;
// Obtener enfermedades concomitantes del paciente
$resultado_enfermedades = $conexion->query("
    SELECT diabetes_tipo, diabetes_detalle, hipertension, hipotiroidismo, insuficiencia_renal, 
           depresion_ansiedad, enfermedad_prostata, epoc, insuficiencia_cardiaca, obesidad, 
           artritis, cancer, otro_enfermedad 
    FROM enf_concomitantes 
    WHERE id_atencion = '$id_atencion' 
") or die($conexion->error);

$enfermedades = $resultado_enfermedades->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Perfil del Paciente</title>
    <style>
        :root {
            --primary-color: #0c675e;
            --secondary-color: #0b5e51;
            --accent-color: #17a2b8;
            --light-bg: #f8f9fa;
            --border-radius: 10px;
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0;
        }

        .main-content {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .header-title {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .patient-info-card {
            margin: 2rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            font-size: 1.25rem;
            font-weight: 500;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(to right, #f8f9fa, white);
        }

        .info-item {
            padding: 1rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .info-item:hover {
            transform: translateY(-2px);
        }

        .info-icon {
            color: var(--primary-color);
            margin-right: 0.5rem;
        }

        .diseases-section {
            margin: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .diseases-title {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .diseases-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .disease-item {
            background: var(--light-bg);
            padding: 1rem;
            border-radius: var(--border-radius);
            border-left: 4px solid var(--primary-color);
            transition: transform 0.2s;
        }

        .disease-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .patient-status-section {
            margin: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .status-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .form-check {
            background: var(--light-bg);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin: 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-check:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check-label {
            margin-left: 0.5rem;
            font-weight: 500;
        }

        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 2rem auto;
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .diseases-grid {
                grid-template-columns: 1fr;
            }

            .status-options {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    
    <div class="container">
        <a href="select_pac.php" class="btn btn-danger">Regresar</a>
        <div class="main-content">
            <div class="header-section">
                <h1 class="header-title">Perfil del Paciente</h1>
            </div>
            <div class="patient-info-card">
                <div class="card-header">Información del Paciente</div>
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-user info-icon"></i>
                        <strong>Nombre:</strong> <?php echo $paciente['nom_pac'] . ' ' . $paciente['papell'] . ' ' . $paciente['sapell']; ?>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar-alt info-icon"></i>
                        <strong>Fecha de nacimiento:</strong> <?php echo $fecha_nacimiento; ?>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-venus-mars info-icon"></i>
                        <strong>Sexo:</strong> <?php echo $sexo; ?>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-birthday-cake info-icon"></i>
                        <strong>Edad:</strong> <?php echo $edad; ?>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-hospital info-icon"></i>
                        <strong>Motivo de ingreso:</strong> <?php echo $motivo_ingreso; ?>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar-day info-icon"></i>
                        <strong>Fecha de ingreso:</strong> <?php echo $fecha_ingreso; ?>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-info-circle info-icon"></i>
                        <strong>Diagnóstico:</strong> <?php echo $diagnostico; ?>
                    </div>
                </div>
            </div>

            <div class="diseases-section">
                <h2 class="diseases-title">Enfermedades Concomitantes</h2>
                <div class="diseases-grid">
                    <?php if ($enfermedades<>NULL): ?>
                        <div class="disease-item"><strong>Diabetes:</strong> <?php echo $enfermedades['diabetes_tipo'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>Hipertensión:</strong> <?php echo $enfermedades['hipertension'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>Hipotiroidismo:</strong> <?php echo $enfermedades['hipotiroidismo'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>Insuficiencia Renal:</strong> <?php echo $enfermedades['insuficiencia_renal'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>Depresión/Ansiedad:</strong> <?php echo $enfermedades['depresion_ansiedad'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>Enfermedad Prostática:</strong> <?php echo $enfermedades['enfermedad_prostata'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>EPOC:</strong> <?php echo $enfermedades['epoc'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>Insuficiencia Cardíaca:</strong> <?php echo $enfermedades['insuficiencia_cardiaca'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>Obesidad:</strong> <?php echo $enfermedades['obesidad'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>Artritis:</strong> <?php echo $enfermedades['artritis'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>Cáncer:</strong> <?php echo $enfermedades['cancer'] ? 'Sí' : 'No'; ?></div>
                        <div class="disease-item"><strong>Otra Enfermedad:</strong> <?php echo $enfermedades['otro_enfermedad']; ?></div>
                    <?php else: ?>
                        <p>No se encontraron enfermedades concomitantes.</p>
                    <?php endif; ?>
                </div>
            </div>

            <a href="deteccion_de_prm.php" class="btn btn-custom">Continuar</a>
        </div>
    </div>
</body>
</html>
