<?php
session_start();
include "../../conexionbd.php";
include "../../sauxiliares/header_farmaciaq.php";

// Verifica que haya un paciente seleccionado en la sesión
if (!isset($_SESSION['id_atencion'])) {
    header("Location: seleccionar_paciente.php"); // Redirigir si no hay paciente seleccionado
    exit;
}

$id_atencion = $_SESSION['id_atencion'];

// Obtener información del paciente
$resultado_paciente = $conexion->query("
    SELECT pac.sapell, pac.papell, pac.nom_pac, pac.fecnac, di.fecha, di.alergias, di.motivo_atn
    FROM paciente pac 
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp 
    WHERE di.id_atencion = $id_atencion
") or die($conexion->error);

$paciente = $resultado_paciente->fetch_assoc();

// Obtener la fecha de ingreso, fecha de nacimiento y diagnóstico del paciente
$fecha_ingreso = $paciente['fecha']; // Fecha de ingreso desde la tabla dat_ingreso
$fecha_nacimiento = $paciente['fecnac']; // Fecha de nacimiento del paciente
$diagnostico = $paciente['motivo_atn']; // Diagnóstico del paciente

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $diabetes_tipo = $_POST['diabetes_tipo'];
    $diabetes_detalle = $_POST['diabetes_detalle'];
    $hipertension = $_POST['hipertension'];
    $hipotiroidismo = $_POST['hipotiroidismo'];
    $insuficiencia_renal = $_POST['insuficiencia_renal'];
    $depresion_ansiedad = $_POST['depresion_ansiedad'];
    $enfermedad_prostata = $_POST['enfermedad_prostata'];
    $epoc = $_POST['epoc'];
    $insuficiencia_cardiaca = $_POST['insuficiencia_cardiaca'];
    $obesidad = $_POST['obesidad'];
    $artritis = $_POST['artritis'];
    $cancer = $_POST['cancer'];
    $otro_enfermedad = $_POST['otro_enfermedad'];

    // Inserción en la base de datos
    $query = "INSERT INTO enf_concomitantes (
        id_atencion, diabetes_tipo, diabetes_detalle, hipertension, hipotiroidismo, 
        insuficiencia_renal, depresion_ansiedad, enfermedad_prostata, epoc, 
        insuficiencia_cardiaca, obesidad, artritis, cancer, otro_enfermedad
    ) VALUES (
        '$id_atencion', '$diabetes_tipo', '$diabetes_detalle', '$hipertension', '$hipotiroidismo', 
        '$insuficiencia_renal', '$depresion_ansiedad', '$enfermedad_prostata', '$epoc', 
        '$insuficiencia_cardiaca', '$obesidad', '$artritis', '$cancer', '$otro_enfermedad'
    )";

    if ($conexion->query($query) === TRUE) {
        $mensaje = "Datos guardados exitosamente.";
    } else {
        $mensaje = "Error: " . $conexion->error;
    }
}

// Obtener los datos guardados solo del paciente seleccionado
$datos_guardados = $conexion->query("SELECT * FROM enf_concomitantes WHERE id_atencion = $id_atencion") or die($conexion->error);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Ingreso</title>
    <style>
        /* Estilos personalizados */
        table {
            margin-top: 20px;
            border: 1px solid #0c675e;
            background-color: #f8f9fa;
            color: #343a40;
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: center;
            padding: 10px;
        }

        th {
            background-color: #0c675e;
            color: white;
        }

        .alert {
            display: none;
        }

        .update-icon {
            cursor: pointer;
            color: #0c675e;
        }

        .update-icon:hover {
            color: #007bff;
        }

        .code-info {
            text-align: right;
            font-size: 14px;
            color: #343a40;
            margin-bottom: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .patient-info {
            margin-top: 15px;
        }

        .patient-info p {
            margin: 0;
        }

        .text-right {
            text-align: right;
        }

        .no-margin {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <a href="ingreso.php" class="btn btn-danger">Regresar</a>
    <section class="content container-fluid">
        <div class="container">
            <div class="code-info">
                <p>Código: FO-VEN20-FAR-001</p>
                <p>VERSIÓN: NUEVO</p>
            </div>
            <h2>CONCILIACÓN DE INGRESO</h2>
            <h4>Nombre: <?php echo $paciente['papell'] . ' ' . $paciente['sapell'] . ' ' . $paciente['nom_pac']; ?></h4>

            <p class="no-margin"><strong>Fecha de Nacimiento:</strong> <?php echo $fecha_nacimiento; ?></p>

            <div class="row">
                <div class="col text-right">
                    <p><strong>Fecha de Ingreso:</strong> <?php echo $fecha_ingreso; ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col text-right">
                    <p><strong>Alergias:</strong> <?php echo $paciente['alergias']; ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <p><strong>Diagnóstico:</strong> <?php echo $diagnostico; ?></p>
                </div>
            </div>

            <!-- Mensaje de éxito o error -->
            <?php if (isset($mensaje)): ?>
                <div class="alert alert-success" role="alert" id="success-message">
                    <?php echo $mensaje; ?>
                </div>
                <script>
                    // Mostrar el mensaje de éxito
                    document.getElementById('success-message').style.display = 'block';
                    // Desaparecer el mensaje después de 5 segundos
                    setTimeout(function() {
                        document.getElementById('success-message').style.display = 'none';
                    }, 5000);
                </script>
            <?php endif; ?>

            <!-- Formulario para guardar datos -->
            <form action="" method="POST">
                <!-- Tabla de Enfermedades -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Enfermedades</th>
                            <th>Tiempo Diagnosticado / Valores</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Diabetes Mellitus</td>
                            <td>
                                <select class="form-control" name="diabetes_tipo">
                                    <option value="">Seleccionar Tipo</option>
                                    <option value="Tipo I">Tipo I</option>
                                    <option value="Tipo II">Tipo II</option>
                                </select>
                                <input type="text" class="form-control mt-2" name="diabetes_detalle" placeholder="Detalles adicionales">
                            </td>
                        </tr>
                        <tr>
                            <td>Hipertensión</td>
                            <td><input type="text" class="form-control" name="hipertension" placeholder="Detalles"></td>
                        </tr>
                        <tr>
                            <td>Hipotiroidismo</td>
                            <td><input type="text" class="form-control" name="hipotiroidismo" placeholder="Detalles"></td>
                        </tr>
                        <tr>
                            <td>Insuficiencia Renal</td>
                            <td><input type="text" class="form-control" name="insuficiencia_renal" placeholder="Detalles"></td>
                        </tr>
                        <tr>
                            <td>Depresión / Ansiedad</td>
                            <td><input type="text" class="form-control" name="depresion_ansiedad" placeholder="Detalles"></td>
                        </tr>
                        <tr>
                            <td>Enfermedad de Próstata</td>
                            <td><input type="text" class="form-control" name="enfermedad_prostata" placeholder="Detalles"></td>
                        </tr>
                        <tr>
                            <td>EPOC</td>
                            <td><input type="text" class="form-control" name="epoc" placeholder="Detalles"></td>
                        </tr>
                        <tr>
                            <td>Insuficiencia Cardíaca</td>
                            <td><input type="text" class="form-control" name="insuficiencia_cardiaca" placeholder="Detalles"></td>
                        </tr>
                        <tr>
                            <td>Obesidad</td>
                            <td><input type="text" class="form-control" name="obesidad" placeholder="Detalles"></td>
                        </tr>
                        <tr>
                            <td>Artritis</td>
                            <td><input type="text" class="form-control" name="artritis" placeholder="Detalles"></td>
                        </tr>
                        <tr>
                            <td>Cáncer</td>
                            <td><input type="text" class="form-control" name="cancer" placeholder="Detalles"></td>
                        </tr>
                        <tr>
                            <td>Otra enfermedad</td>
                            <td><input type="text" class="form-control" name="otro_enfermedad" placeholder="Especificar"></td>
                        </tr>
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">Guardar Datos</button>
            </form>

            <!-- Tabla para mostrar los datos guardados -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Diabetes Tipo</th>
                            <th>Diabetes Detalle</th>
                            <th>Hipertensión</th>
                            <th>Hipotiroidismo</th>
                            <th>Insuficiencia Renal</th>
                            <th>Depresión / Ansiedad</th>
                            <th>Enfermedad de Próstata</th>
                            <th>EPOC</th>
                            <th>Insuficiencia Cardíaca</th>
                            <th>Obesidad</th>
                            <th>Artritis</th>
                            <th>Cáncer</th>
                            <th>Otra Enfermedad</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $datos_guardados->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['diabetes_tipo']; ?></td>
                                <td><?php echo $row['diabetes_detalle']; ?></td>
                                <td><?php echo $row['hipertension']; ?></td>
                                <td><?php echo $row['hipotiroidismo']; ?></td>
                                <td><?php echo $row['insuficiencia_renal']; ?></td>
                                <td><?php echo $row['depresion_ansiedad']; ?></td>
                                <td><?php echo $row['enfermedad_prostata']; ?></td>
                                <td><?php echo $row['epoc']; ?></td>
                                <td><?php echo $row['insuficiencia_cardiaca']; ?></td>
                                <td><?php echo $row['obesidad']; ?></td>
                                <td><?php echo $row['artritis']; ?></td>
                                <td><?php echo $row['cancer']; ?></td>
                                <td><?php echo $row['otro_enfermedad']; ?></td>
                                <td>
                                    
                                    <a href="edit_enf_concomitante.php?id_atencion=<?php echo $row['id_atencion']; ?>" class="update-icon">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
