<?php
session_start();
include "../../conexionbd.php";
include "../../sauxiliares/header_farmaciaq.php";

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener pacientes con camas ocupadas
$resultado_pacientes = $conexion->query("
    SELECT pac.Id_exp, pac.sapell, pac.papell, pac.nom_pac, cc.num_cama, di.id_atencion 
    FROM paciente pac 
    JOIN cat_camas cc ON pac.Id_exp = cc.Id
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp
    WHERE cc.estatus = 'ocupada' AND di.alta_med = 'no'
") or die($conexion->error);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Seleccionar Paciente</title>
    <style>
        .btn-custom {
            background-color: #0c675e;
            color: white;
        }
    </style>
</head>

<body>
    <section class="content container-fluid">
        <div class="container">
            <h2>Seleccionar Paciente</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="paciente">Seleccione un paciente:</label>
                    <select class="form-control" name="paciente" id="paciente" required>
                        <option value="">-- Seleccionar Paciente --</option>
                        <?php 
                        while ($row = $resultado_pacientes->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_atencion']; ?>">
                                <?php echo htmlspecialchars($row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nom_pac'] . ' - Cama: ' . $row['num_cama']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom">Continuar</button>
            </form>
        </div>

        <?php
        if (isset($_POST['paciente'])) {
            $id_atencion = $_POST['paciente'];
            $_SESSION['pac'] = $id_atencion; // Guardar el ID de atención en la sesión

            // Redirigir a la página principal con el paciente seleccionado
            echo '<script type="text/javascript">window.location.href="quirofano.php";</script>';
        }
        ?>
    </section>
</body>
</html>
