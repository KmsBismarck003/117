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

// Obtener la información actual del paciente
$resultado_paciente = $conexion->query("
    SELECT pac.sapell, pac.papell, pac.nom_pac, pac.fecnac, di.fecha, di.alergias, di.motivo_atn 
    FROM paciente pac 
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp 
    WHERE di.id_atencion = $id_atencion
") or die($conexion->error);
$paciente = $resultado_paciente->fetch_assoc();

// Obtener la información actual de enfermedades concomitantes del paciente
$query_enfermedades = $conexion->query("SELECT * FROM enf_concomitantes WHERE id_atencion = '$id_atencion'") or die($conexion->error);
$enfermedades = $query_enfermedades->fetch_assoc();

$mensaje = ''; // Variable para almacenar el mensaje de actualización

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir datos del formulario y sanitizarlos
    $diabetes_tipo = $conexion->real_escape_string($_POST['diabetes_tipo'] ?? '');
    $diabetes_detalle = $conexion->real_escape_string($_POST['diabetes_detalle'] ?? '');
    $hipertension = $conexion->real_escape_string($_POST['hipertension'] ?? '');
    $hipotiroidismo = $conexion->real_escape_string($_POST['hipotiroidismo'] ?? '');
    $insuficiencia_renal = $conexion->real_escape_string($_POST['insuficiencia_renal'] ?? '');
    $depresion_ansiedad = $conexion->real_escape_string($_POST['depresion_ansiedad'] ?? '');
    $enfermedad_prostata = $conexion->real_escape_string($_POST['enfermedad_prostata'] ?? '');
    $epoc = $conexion->real_escape_string($_POST['epoc'] ?? '');
    $insuficiencia_cardiaca = $conexion->real_escape_string($_POST['insuficiencia_cardiaca'] ?? '');
    $obesidad = $conexion->real_escape_string($_POST['obesidad'] ?? '');
    $artritis = $conexion->real_escape_string($_POST['artritis'] ?? '');
    $cancer = $conexion->real_escape_string($_POST['cancer'] ?? '');
    $otro_enfermedad = $conexion->real_escape_string($_POST['otro_enfermedad'] ?? '');

    // Verificar si hay un registro existente
    if ($enfermedades) {
        // Actualizar los datos existentes
        $sql_update = "UPDATE enf_concomitantes SET 
diabetes_tipo = '$diabetes_tipo', 
diabetes_detalle = '$diabetes_detalle',
hipertension = '$hipertension', 
hipotiroidismo = '$hipotiroidismo',
insuficiencia_renal = '$insuficiencia_renal',
depresion_ansiedad = '$depresion_ansiedad',
enfermedad_prostata = '$enfermedad_prostata',
epoc = '$epoc',
insuficiencia_cardiaca = '$insuficiencia_cardiaca',
obesidad = '$obesidad',
artritis = '$artritis',
cancer = '$cancer',
otro_enfermedad = '$otro_enfermedad' 
WHERE id_atencion = '$id_atencion'"; // Cambiado de id_exp a id_atencion


        if ($conexion->query($sql_update)) {
            // Mensaje de éxito
            $mensaje = "Datos actualizados correctamente.";
        } else {
            echo "Error al actualizar: " . $conexion->error;
        }
    } else {
        // Mensaje de error si no se encuentra el registro
        echo "No se encontró el registro para actualizar.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Actualizar Enfermedades</title>
    <style>
        .btn-custom {
            background-color: #0c675e;
            color: white;
            /* Cambiar color del texto si es necesario */
        }

        .btn-danger {
            background-color: red;
            /* Cambiar el color de fondo del botón regresar */
            border-color: red;
            /* Cambiar el color del borde del botón regresar */
        }

        .code-info {
            text-align: right;
            font-size: 14px;
            color: #343a40;
            /* Color del texto */
            margin-bottom: 20px;
            /* Espaciado inferior */
        }

        .container {
            margin-top: 20px;
            background-color: white;
            /* Fondo blanco para el contenedor */
            padding: 20px;
            border-radius: 8px;
            /* Bordes redondeados */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Sombra suave */
        }
    </style>
</head>
<a href="enf_concomitantes.php" class="btn btn-danger">Regresar</a> <!-- Botón para regresar -->

<body>
    <section class="content container-fluid">
        <div class="container">
            <div class="code-info">
                <p>Código: FO-VEN20-FAR-001</p>
                <p>VERSIÓN: NUEVO</p>
            </div>
            <h2>CONCILIACÓN DE INGRESO</h2>
            <h4>Nombre: <?php echo $paciente['papell'] . ' ' . $paciente['sapell'] . ' ' . $paciente['nom_pac']; ?></h4>
            <p><strong>Fecha de Nacimiento:</strong> <?php echo $paciente['fecnac']; ?></p>

            <?php if ($mensaje): ?>
                <div class="alert alert-success">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="diabetes_tipo">Diabetes Mellitus:</label>
                    <input type="text" class="form-control" id="diabetes_tipo" name="diabetes_tipo" value="<?php echo $enfermedades['diabetes_tipo'] ?? ''; ?>">
                    <label for="diabetes_detalle">Detalle:</label>
                    <input type="text" class="form-control" id="diabetes_detalle" name="diabetes_detalle" value="<?php echo $enfermedades['diabetes_detalle'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="hipertension">Hipertensión:</label>
                    <input type="text" class="form-control" id="hipertension" name="hipertension" value="<?php echo $enfermedades['hipertension'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="hipotiroidismo">Hipotiroidismo:</label>
                    <input type="text" class="form-control" id="hipotiroidismo" name="hipotiroidismo" value="<?php echo $enfermedades['hipotiroidismo'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="insuficiencia_renal">Insuficiencia Renal:</label>
                    <input type="text" class="form-control" id="insuficiencia_renal" name="insuficiencia_renal" value="<?php echo $enfermedades['insuficiencia_renal'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="depresion_ansiedad">Depresión / Ansiedad:</label>
                    <input type="text" class="form-control" id="depresion_ansiedad" name="depresion_ansiedad" value="<?php echo $enfermedades['depresion_ansiedad'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="enfermedad_prostata">Enfermedad de Próstata:</label>
                    <input type="text" class="form-control" id="enfermedad_prostata" name="enfermedad_prostata" value="<?php echo $enfermedades['enfermedad_prostata'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="epoc">EPOC:</label>
                    <input type="text" class="form-control" id="epoc" name="epoc" value="<?php echo $enfermedades['epoc'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="insuficiencia_cardiaca">Insuficiencia Cardiaca:</label>
                    <input type="text" class="form-control" id="insuficiencia_cardiaca" name="insuficiencia_cardiaca" value="<?php echo $enfermedades['insuficiencia_cardiaca'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="obesidad">Obesidad:</label>
                    <input type="text" class="form-control" id="obesidad" name="obesidad" value="<?php echo $enfermedades['obesidad'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="artritis">Artritis:</label>
                    <input type="text" class="form-control" id="artritis" name="artritis" value="<?php echo $enfermedades['artritis'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="cancer">Cáncer:</label>
                    <input type="text" class="form-control" id="cancer" name="cancer" value="<?php echo $enfermedades['cancer'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="otro_enfermedad">Otra Enfermedad:</label>
                    <input type="text" class="form-control" id="otro_enfermedad" name="otro_enfermedad" value="<?php echo $enfermedades['otro_enfermedad'] ?? ''; ?>">
                </div>

                <button type="submit" class="btn btn-custom">Actualizar</button>

            </form>
        </div>
    </section>
</body>

</html>