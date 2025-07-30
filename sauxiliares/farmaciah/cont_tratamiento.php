<?php
session_start();
include "../../conexionbd.php";
include "../../sauxiliares/header_farmaciah.php";

// Verifica que haya un paciente seleccionado en la sesión
if (!isset($_SESSION['id_atencion'])) {
    header("Location: seleccionar_paciente.php"); // Redirigir si no hay paciente seleccionado
    exit;
}

$id_atencion = $_SESSION['id_atencion'];

// Obtener información del paciente
$resultado_paciente = $conexion->query("
    SELECT pac.sapell, pac.papell, pac.nom_pac, pac.fecnac, di.fecha, di.alergias, di.motivo_atn , di.id_atencion 
    FROM paciente pac 
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp 
    WHERE di.id_atencion = $id_atencion
") or die($conexion->error);

$paciente = $resultado_paciente->fetch_assoc();

// Obtener la fecha de ingreso, fecha de nacimiento y diagnóstico del paciente
$fecha_ingreso = $paciente['fecha'];
$fecha_nacimiento = $paciente['fecnac'];
$diagnostico = $paciente['motivo_atn'];

// Guardar los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar'])) {
        // Eliminar el registro si se ha enviado una solicitud de eliminación
        $id = $_POST['id']; // Obtener el ID del registro
        $sql_eliminar = "DELETE FROM cont_tratamiento WHERE id = $id";
        if ($conexion->query($sql_eliminar)) {
            echo "<div class='alert alert-success'>Registro eliminado exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el registro: " . $conexion->error . "</div>";
        }
    } else {
        // Guardar datos del formulario
        $fecha = $_POST['fecha'];
        $medicamento = $_POST['medicamento'];
        $principio_activo = $_POST['principio_activo'];
        $dosis = $_POST['dosis'];
        $intervalo = $_POST['intervalo'];
        $horario = $_POST['horario'];
        $via_administracion = $_POST['via_administracion'];
        $medico = $_POST['medico'];
        $cambio_servicio_de = $_POST['cambio_servicio_de'];
        $cambio_servicio_a = $_POST['cambio_servicio_a'];

        // Validar que los campos obligatorios no estén vacíos
        if (!empty($fecha) && !empty($medicamento) && !empty($principio_activo) && !empty($dosis) && !empty($intervalo)) {
            // Insertar los datos en la tabla cont_tratamiento
            $sql_insert = "
                INSERT INTO cont_tratamiento 
                (id_atencion, fecha, medicamento, principio_activo, dosis, intervalo, horario, via_administracion, medico, cambio_servicio_de, cambio_servicio_a) 
                VALUES ('$id_atencion', '$fecha', '$medicamento', '$principio_activo', '$dosis', '$intervalo', '$horario', '$via_administracion', '$medico', '$cambio_servicio_de', '$cambio_servicio_a')
            ";

            if ($conexion->query($sql_insert)) {
                echo "<div class='alert alert-success'>Se guardó exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al guardar los datos: " . $conexion->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Por favor, rellena todos los campos obligatorios.</div>";
        }
    }
}

// Obtener las intervenciones ya guardadas
$resultado_intervenciones = $conexion->query("
    SELECT * FROM cont_tratamiento WHERE id_atencion = $id_atencion
") or die($conexion->error);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Ingreso</title>
    <style>
        .table {
            margin-top: 20px;
            background-color: white;
            color: #333;
        }

        .table thead th {
            background-color: #0c675e;
            color: white;
            vertical-align: middle;
            padding: 12px 8px;
            white-space: nowrap;
            font-size: 14px;
        }

        .table td {
            padding: 12px 8px;
            vertical-align: middle;
            max-width: 200px;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .table input.form-control {
            font-size: 14px;
            padding: 6px 8px;
            height: auto;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            max-width: 100%;
            margin-bottom: 1rem;
        }

        .container {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #f2f2f2;
        }

        .btn-danger.btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .alert {
            margin-bottom: 20px;
        }

        .code-info {
            text-align: right;
            font-size: 14px;
            color: #343a40;
            margin-bottom: 20px;
        }

        input[type="text"].form-control {
            min-width: 120px;
        }

        td {
            min-width: 120px;
            height: auto;
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
        <h2>CONCILIACIÓN DE INGRESO</h2>
        <h4>Nombre: <?php echo $paciente['papell'] . ' ' . $paciente['sapell'] . ' ' . $paciente['nom_pac']; ?></h4>
        
        <p class="no-margin"><strong>Fecha de Nacimiento:</strong> <?php echo $fecha_nacimiento; ?></p> <!-- Mostrar fecha de nacimiento -->
        
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

        <div class="container">
            <form action="" method="POST">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Medicamento</th>
                            <th>Principio Activo</th>
                            <th>Dosis</th>
                            <th>Intervalo</th>
                            <th>Horario</th>
                            <th>Via de Administración</th>
                            <th>Médico</th>
                            <th>Cambio Servicio De</th>
                            <th>Cambio Servicio A</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="date" name="fecha" class="form-control" required></td>
                            <td><input type="text" name="medicamento" class="form-control" required></td>
                            <td><input type="text" name="principio_activo" class="form-control" required></td>
                            <td><input type="text" name="dosis" class="form-control" required></td>
                            <td><input type="text" name="intervalo" class="form-control" required></td>
                            <td><input type="text" name="horario" class="form-control" required></td>
                            <td><input type="text" name="via_administracion" class="form-control"></td>
                            <td><input type="text" name="medico" class="form-control"></td>
                            <td><input type="text" name="cambio_servicio_de" class="form-control"></td>
                            <td><input type="text" name="cambio_servicio_a" class="form-control"></td>
                            <td><button type="submit" class="btn btn-primary">Guardar</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>

            <!-- Mostrar intervenciones guardadas -->
            <h4>Intervenciones Guardadas</h4>
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Medicamento</th>
                        <th>Principio Activo</th>
                        <th>Dosis</th>
                        <th>Intervalo</th>
                        <th>Horario</th>
                        <th>Via de Administración</th>
                        <th>Médico</th>
                        <th>Cambio Servicio De</th>
                        <th>Cambio Servicio A</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($intervencion = $resultado_intervenciones->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $intervencion['fecha']; ?></td>
                            <td><?php echo $intervencion['medicamento']; ?></td>
                            <td><?php echo $intervencion['principio_activo']; ?></td>
                            <td><?php echo $intervencion['dosis']; ?></td>
                            <td><?php echo $intervencion['intervalo']; ?></td>
                            <td><?php echo $intervencion['horario']; ?></td>
                            <td><?php echo $intervencion['via_administracion']; ?></td>
                            <td><?php echo $intervencion['medico']; ?></td>
                            <td><?php echo $intervencion['cambio_servicio_de']; ?></td>
                            <td><?php echo $intervencion['cambio_servicio_a']; ?></td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $intervencion['id']; ?>">
                                    <button type="submit" name="eliminar" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
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
