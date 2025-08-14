<?php
session_start();
include "../../conexionbd.php";
include "../../sauxiliares/header_farmaciah.php";

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener pacientes que están dados de alta en alta_adm junto con el id_atencion
$resultado_pacientes = $conexion->query("
    SELECT pac.Id_exp, pac.sapell, pac.papell, pac.nom_pac, di.id_atencion 
    FROM paciente pac 
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp
    WHERE di.activo = 'SI'
") or die($conexion->error);

// Consulta para obtener pacientes que están dados de alta en alta_adm junto con el id_atencion
$resultado_historico = $conexion->query("
    SELECT pac.Id_exp, pac.sapell, pac.papell, pac.nom_pac, di.id_atencion 
    FROM paciente pac 
    JOIN dat_ingreso di ON pac.Id_exp = di.Id_exp
    WHERE di.activo = 'NO'
") or die($conexion->error);
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Seleccionar Paciente</title>
    <style>
        .btn-custom {
            background-color: #2b2d7f;
            color: white;
        }
    </style>
</head>

<body>
    <section class="content container-fluid">
        <a href="../../template/menu_farmaciahosp.php"
        style='color: white; margin-left: 30px; margin-bottom: 20px; background-color: #d9534f; 
          border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; display: inline-block;'>
        Regresar
    </a>
        <div class="container">
            <h2>Seleccionar Paciente Activo</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="paciente">Seleccione un paciente:</label>
                    <select class="form-control" name="paciente" id="paciente" required>
                        <option value="">-- Seleccionar Paciente --</option>
                        <?php while ($row = $resultado_pacientes->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_atencion']; ?>">
                                <?php echo $row['id_atencion']. ' - ' . $row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nom_pac']; ?>
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
            $_SESSION['id_atencion'] = $id_atencion; // Guardar el ID de atención en la sesión con el nombre correcto

            // Redirigir a la página principal con el paciente seleccionado
            echo '<script type="text/javascript">window.location.href="ingreso.php";</script>';
        }
        ?>
    </section>
    
     <section class="content container-fluid">
        <div class="container">
            <h2>Seleccionar Paciente Histórico</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="paciente">Seleccione un paciente:</label>
                    <select class="form-control" name="paciente" id="paciente" required>
                        <option value="">-- Seleccionar Paciente --</option>
                        <?php while ($row2 = $resultado_historico->fetch_assoc()) { ?>
                            <option value="<?php echo $row2['id_atencion']; ?>">
                                <?php echo $row2['id_atencion']. ' - ' . $row2['papell'] . ' ' . $row2['sapell'] . ' ' . $row2['nom_pac']; ?>
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
            $_SESSION['id_atencion'] = $id_atencion; // Guardar el ID de atención en la sesión con el nombre correcto

            // Redirigir a la página principal con el paciente seleccionado
            echo '<script type="text/javascript">window.location.href="ingreso.php";</script>';
        }
        ?>
    </section>
</body>
</html>
