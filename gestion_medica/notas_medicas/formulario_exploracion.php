<?php
session_start();
include '../../conexionbd.php';
include '../header_medico.php';

if (!isset($_SESSION['hospital'])) {
    header("Location: ../login.php");
    exit();
}

// Obtener información del paciente
$id_atencion = $_SESSION['hospital'];
$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.fecnac, di.fecha, di.activo FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp AND di.id_atencion = ?";
$stmt = $conexion->prepare($sql_pac);
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$result_pac = $stmt->get_result();
$row_pac = $result_pac->fetch_assoc();
$stmt->close();

$pac_nom_pac = $row_pac['nom_pac'] ?? 'No disponible';
$pac_papell = $row_pac['papell'] ?? 'No disponible';
$pac_sapell = $row_pac['sapell'] ?? 'No disponible';
$pac_fecnac = $row_pac['fecnac'] ?? 'No disponible';
$pac_fecha_ingreso = $row_pac['fecha'] ?? 'No disponible';
$activo = $row_pac['activo'] ?? 'No disponible';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario - Exploración</title>
    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFMw5uZjQz4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/select2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldLv/Pr4nhuBviF5jGqQK/5i2Q5iZ64dxBl+zOZ" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>
        <style>
        .modal-lg {
            max-width: 70% !important;
        }

        .botones {
            margin-bottom: 5px;
        }

        .thead {
            background-color: #2b2d7f;
            color: white;
            font-size: 22px;
            padding: 10px;
            text-align: center;
        }

        .accordion .card {
            border: none;
        }

        .accordion .card-header {
            background-color: #e9ecef;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <!-- Encabezado con información del paciente -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Información del Paciente</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">Nombre: <strong><?php echo htmlspecialchars($pac_nom_pac); ?></strong></div>
                    <div class="col-sm-4">Apellido Paterno: <strong><?php echo htmlspecialchars($pac_papell); ?></strong></div>
                    <div class="col-sm-4">Apellido Materno: <strong><?php echo htmlspecialchars($pac_sapell); ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Fecha de Nacimiento: <strong><?php echo date_format(date_create($pac_fecnac), "d/m/Y"); ?></strong></div>
                    <div class="col-sm-4">Fecha de Ingreso: <strong><?php echo date_format(date_create($pac_fecha_ingreso), "d/m/Y H:i:s"); ?></strong></div>
                    <div class="col-sm-4">Estado: <strong><?php echo $activo === 'SI' ? 'Activo' : 'Inactivo'; ?></strong></div>
                </div>
            </div>
        </div>
        <br>

        <!-- Formulario de exploración -->
        <div class="card shadow-lg mt-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Nueva Exploración: Párpados, Órbita y Vías Lagrimales</h4>
            </div>
            <div class="card-body">
                <form action="procesar_formulario.php" method="POST">
                    <!-- Ojo Derecho -->
                    <h5>Ojo Derecho</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Apertura Palpebral (mm)</label>
                            <input type="number" step="0.01" name="apertura_palpebral" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Hendidura Palpebral (mm)</label>
                            <input type="number" step="0.01" name="hendidura_palpebral" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Función del Músculo Elevador (mm)</label>
                            <input type="number" step="0.01" name="funcion_musculo_elevador" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Fenómeno de Bell</label>
                            <select name="fenomeno_bell" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Normal">Normal</option>
                                <option value="Patológico">Patológico</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Laxitud Horizontal</label>
                            <select name="laxitud_horizontal" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Normal">Normal</option>
                                <option value="Leve">Leve</option>
                                <option value="Moderada">Moderada</option>
                                <option value="Severa">Severa</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Laxitud Vertical</label>
                            <select name="laxitud_vertical" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Normal">Normal</option>
                                <option value="Leve">Leve</option>
                                <option value="Moderada">Moderada</option>
                                <option value="Severa">Severa</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Desplazamiento Ocular</label>
                            <select name="desplazamiento_ocular" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Enoftalmos">Enoftalmos</option>
                                <option value="Exoftalmos">Exoftalmos</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Maniobra de Valsalva</label>
                            <select name="maniobra_vatsaha" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Ojo Izquierdo -->
                    <h5 class="mt-4">Ojo Izquierdo</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Apertura Palpebral (mm)</label>
                            <input type="number" step="0.01" name="apertura_palpebral_oi" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Hendidura Palpebral (mm)</label>
                            <input type="number" step="0.01" name="hendidura_palpebral_oi" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Función del Músculo Elevador (mm)</label>
                            <input type="number" step="0.01" name="funcion_musculo_elevador_oi" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Fenómeno de Bell</label>
                            <select name="fenomeno_bell_oi" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Normal">Normal</option>
                                <option value="Patológico">Patológico</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Laxitud Horizontal</label>
                            <select name="laxitud_horizontal_oi" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Normal">Normal</option>
                                <option value="Leve">Leve</option>
                                <option value="Moderada">Moderada</option>
                                <option value="Severa">Severa</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Laxitud Vertical</label>
                            <select name="laxitud_vertical_oi" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Normal">Normal</option>
                                <option value="Leve">Leve</option>
                                <option value="Moderada">Moderada</option>
                                <option value="Severa">Severa</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Desplazamiento Ocular</label>
                            <select name="desplazamiento_ocular_oi" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Enoftalmos">Enoftalmos</option>
                                <option value="Exoftalmos">Exoftalmos</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Maniobra de Valsalva</label>
                            <select name="maniobra_vatsaha_oi" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" name="observaciones" rows="4" placeholder="Detalles adicionales del examen..."></textarea>
                    </div>

                    <!-- Botones -->
                    <button type="submit" class="btn btn-success">FIRMAR</button>
                    <a href="../hospitalizacion/vista_pac_hosp.php" class="btn btn-danger">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    <footer class="main-footer">
        <?php
        include("../../template/footer.php");
        ?>
    </footer>

    <!-- FastClick -->
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>
</html>
