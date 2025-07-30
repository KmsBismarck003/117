<?php
session_start();
include "../../conexionbd.php";
include "../../sauxiliares/header_farmaciah.php";

// Obtener datos del usuario desde la sesión
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

// Establecer zona horaria
date_default_timezone_set('America/Guatemala');


// Verifica que haya un paciente seleccionado
if (!isset($_SESSION['id_atencion'])) {
    header("Location: seleccionar_paciente.php");
    exit;
}

$id_atencion = $_SESSION['id_atencion'];
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

// Obtener información del paciente y su Id_exp
$resultado_paciente = $conexion->query("
    SELECT pac.sapell, pac.papell, pac.nom_pac, pac.fecnac, di.fecha, di.alergias, di.motivo_atn, di.Id_exp 
    FROM paciente pac 
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp 
    WHERE di.id_atencion = $id_atencion
") or die($conexion->error);
$paciente = $resultado_paciente->fetch_assoc();
$id_exp = $paciente['Id_exp'];

$fecha_ingreso = date('Y-m-d');
$fecha_nacimiento = $paciente['fecnac'];

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicamento = $_POST['medicamento'];
    $dosis = $_POST['dosis'];
    $intervalo = $_POST['intervalo'];
    $horario = $_POST['horario'];
    $via_administracion = $_POST['via_administracion'];
    $ultima_dosis = $_POST['ultima_dosis'];
    $continuidad = $_POST['continuidad'];
    $fecha_actual = date('Y-m-d H:i:s');

    $query = "INSERT INTO trat_farma (
        id_atencion, medicamento, principio_activo, dosis, intervalo, horario, via_administracion, lote, caducidad, ultima_dosis, continuidad, fecha_registro, id_usua
    ) VALUES (
        '$id_atencion', '$medicamento', 'NO APLICA', '$dosis', '$intervalo', '$horario', '$via_administracion', 'NO APLICA', '0000-00-00', '$ultima_dosis', '$continuidad', '$fecha_actual', '$id_usua'
    )";

    if ($conexion->query($query) === TRUE) {
        $mensaje = "Datos guardados exitosamente.";
    } else {
        $mensaje = "Error: " . $conexion->error;
    }
}

// Eliminar un registro
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM trat_farma WHERE id_tratamiento = '$delete_id'";

    if ($conexion->query($delete_query) === TRUE) {
        $mensaje = "Datos eliminados exitosamente.";
    } else {
        $mensaje = "Error: " . $conexion->error;
    }
}

// Obtener tratamientos registrados
$resultado_tratamientos = $conexion->query("
    SELECT id_tratamiento, medicamento, dosis, intervalo, horario, via_administracion, ultima_dosis, continuidad 
    FROM trat_farma 
    WHERE id_atencion = '$id_atencion'
") or die($conexion->error);
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Ingreso</title>
    <style>
        table {
            margin-top: 20px;
            border: 1px solid #0c675e;
            background-color: #0c675e;
            color: white;
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
        .code-info {
            text-align: right;
            font-size: 14px;
            color: #343a40;
            margin-bottom: 20px;
        }
        .container {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<a href="ingreso.php" class="btn btn-danger">Regresar</a>

<body>
    <section class="content container-fluid">
        <div class="container">
            <div class="code-info">
                <p>Código: FO-VEN20-FAR-001</p>
                <p>VERSIÓN: NUEVO</p>
            </div>
            <h2>CONCILIACIÓN DE INGRESO</h2>
            <h4>Nombre: <?php echo $paciente['papell'] . ' ' . $paciente['sapell'] . ' ' . $paciente['nom_pac']; ?></h4>
            <p><strong>Fecha de Ingreso:</strong> <?php echo $fecha_ingreso; ?></p>
            <p><strong>Fecha de Nacimiento:</strong> <?php echo $fecha_nacimiento; ?></p>

            <?php if (isset($mensaje)): ?>
                <div class="alert alert-success" role="alert" id="success-message">
                    <?php echo $mensaje; ?>
                </div>
                <script>
                    document.getElementById('success-message').style.display = 'block';
                    setTimeout(function() {
                        document.getElementById('success-message').style.display = 'none';
                    }, 5000);
                </script>
            <?php endif; ?>

            <!-- Formulario -->
            <form action="" method="POST">
                <h4>Tratamiento Farmacológico (últimos 30 días)</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Dosis</th>
                            <th>Intervalo</th>
                            <th>Horario</th>
                            <th>Vía de Administración</th>
                            <th>Última Dosis</th>
                            <th>Continuidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control" name="medicamento" required></td>
                            <td><input type="text" class="form-control" name="dosis" required></td>
                            <td><input type="text" class="form-control" name="intervalo" required></td>
                            <td><input type="text" class="form-control" name="horario" required></td>
                            <td><input type="text" class="form-control" name="via_administracion" required></td>
                            <td><input type="text" class="form-control" name="ultima_dosis" required></td>
                            <td>
                                <select name="continuidad" class="form-control" required>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Guardar Datos</button>
            </form>

            <!-- Datos guardados -->
            <h4>Datos Guardados</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Medicamento</th>
                        <th>Dosis</th>
                        <th>Intervalo</th>
                        <th>Horario</th>
                        <th>Vía de Administración</th>
                        <th>Última Dosis</th>
                        <th>Continuidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado_tratamientos->num_rows > 0): ?>
                        <?php while ($fila = $resultado_tratamientos->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $fila['medicamento']; ?></td>
                                <td><?php echo $fila['dosis']; ?></td>
                                <td><?php echo $fila['intervalo']; ?></td>
                                <td><?php echo $fila['horario']; ?></td>
                                <td><?php echo $fila['via_administracion']; ?></td>
                                <td><?php echo $fila['ultima_dosis']; ?></td>
                                <td><?php echo $fila['continuidad']; ?></td>
                                <td>
                                    <a href="?delete_id=<?php echo $fila['id_tratamiento']; ?>" class="btn btn-danger">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No hay datos disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
