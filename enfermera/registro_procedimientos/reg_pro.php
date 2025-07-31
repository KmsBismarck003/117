<?php
session_start();
require_once '../../conexionbd.php';
include '../header_enfermera.php';

// Security: Validate session
if (!isset($_SESSION['login']) || !is_array($_SESSION['login']) || !isset($_SESSION['login']['id_usua'])) {
    header('Location: ../../../../index.php');
    exit;
}

$usuario_actual = '';
$rol_usuario = '';
$id_usuario = '';
if (isset($_SESSION['login'])) {
    $usuario = $_SESSION['login'];
    $id_usuario = $usuario['id_usua'];
    $usuario_actual = trim($usuario['nombre'] . ' ' . $usuario['papell'] . ' ' . $usuario['sapell']);
    $rol_usuario = $usuario['id_rol'];
}

// Generate CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoja de Programación Quirúrgica</title>
    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
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
        .thead {
            background-color: #2b2d7f;
            color: white;
            font-size: 20px;
            padding: 10px;
            text-align: center;
        }

        .card-container {
            display: flex;
            gap: 25px;
            margin: 20px 0;
        }

        .card {
            flex: 1;
            padding: 20px;
            border: 2px solid #e3e6f0;
            border-radius: 15px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
            box-shadow: 0 4px 15px rgba(43, 45, 127, 0.1);
        }

        .checkbox-group {
            margin-bottom: 15px;
        }

        .nav-tabs .nav-link {
            background: #2b2d7f;
            color: #fff;
            border: none;
        }

        .nav-tabs .nav-link.active {
            background: #4a4ed1;
            color: #fff;
        }

        .tab-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 15px 15px;
        }

        .table-signos-vitales th,
        .table-signos-vitales td {
            vertical-align: middle;
            text-align: center;
        }

        .form-check-label {
            font-size: 16px;
            font-weight: 500;
            color: #2b2d7f;
        }
    </style>
</head>

<body>
    <?php
    // Display messages
    $messages = [
        'tratamiento_exito' => ['type' => 'success', 'format' => 'Formulario de <strong>%s</strong> enviado correctamente.'],
        'exito_multiples' => ['type' => 'success', 'format' => '<i class="fas fa-check-circle"></i> %s<br><a href="ver_grafica.php" class="btn btn-primary btn-sm mt-2"><i class="fas fa-chart-line"></i> Ver Gráficas de Signos Vitales</a>'],
        'error' => ['type' => 'danger', 'format' => '<i class="fas fa-exclamation-triangle"></i> Error: %s']
    ];

    foreach ($messages as $key => $config) {
        if (isset($_GET[$key]) && !empty($_GET[$key])) {
            printf(
                '<div class="alert alert-%s mt-3" role="alert" style="font-size:18px; text-align:center;">%s</div>',
                $config['type'],
                sprintf($config['format'], htmlspecialchars($_GET[$key], ENT_QUOTES, 'UTF-8'))
            );
        }
    }

    if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
        printf(
            '<div class="alert alert-%s alert-dismissible fade show" role="alert">%s<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
            htmlspecialchars($_SESSION['message_type'], ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8')
        );
        unset($_SESSION['message'], $_SESSION['message_type']);
    }
    ?>

    <div class="container">
        <div class="thead"><strong>DATOS DEL PACIENTE</strong></div>
        <?php
        // Validate patient session
        if (!isset($_SESSION['pac']) || !is_numeric($_SESSION['pac'])) {
            header('Location: ../../../../index.php');
            exit;
        }

        $id_atencion = $_SESSION['pac'];

        // Fetch patient data
        $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.folio, p.tel, 
                           p.fecnac, p.tip_san, di.fecha, di.area, di.alta_med, di.activo, p.sexo, di.alergias, p.ocup 
                    FROM paciente p 
                    INNER JOIN dat_ingreso di ON p.Id_exp = di.Id_exp 
                    WHERE di.id_atencion = ?";

        $stmt = $conexion->prepare($sql_pac);
        if (!$stmt) {
            die("Prepare failed: " . $conexion->error);
        }

        $stmt->bind_param("i", $id_atencion);
        $stmt->execute();
        $result_pac = $stmt->get_result();
        $pac_data = $result_pac->fetch_assoc();
        $stmt->close();

        if (!$pac_data) {
            header('Location: ../../../../index.php');
            exit;
        }

        // Sanitize patient data
        $pac_papell = htmlspecialchars($pac_data['papell'], ENT_QUOTES, 'UTF-8');
        $pac_sapell = htmlspecialchars($pac_data['sapell'], ENT_QUOTES, 'UTF-8');
        $pac_nom_pac = htmlspecialchars($pac_data['nom_pac'], ENT_QUOTES, 'UTF-8');
        $pac_dir = htmlspecialchars($pac_data['dir'], ENT_QUOTES, 'UTF-8');
        $pac_id_edo = htmlspecialchars($pac_data['id_edo'], ENT_QUOTES, 'UTF-8');
        $pac_id_mun = htmlspecialchars($pac_data['id_mun'], ENT_QUOTES, 'UTF-8');
        $pac_tel = htmlspecialchars($pac_data['tel'], ENT_QUOTES, 'UTF-8');
        $pac_fecnac = htmlspecialchars($pac_data['fecnac'], ENT_QUOTES, 'UTF-8');
        $pac_fecing = htmlspecialchars($pac_data['fecha'], ENT_QUOTES, 'UTF-8');
        $pac_tip_sang = htmlspecialchars($pac_data['tip_san'], ENT_QUOTES, 'UTF-8');
        $pac_sexo = htmlspecialchars($pac_data['sexo'], ENT_QUOTES, 'UTF-8');
        $area = htmlspecialchars($pac_data['area'], ENT_QUOTES, 'UTF-8');
        $alta_med = htmlspecialchars($pac_data['alta_med'], ENT_QUOTES, 'UTF-8');
        $id_exp = htmlspecialchars($pac_data['Id_exp'], ENT_QUOTES, 'UTF-8');
        $folio = htmlspecialchars($pac_data['folio'], ENT_QUOTES, 'UTF-8');
        $alergias = htmlspecialchars($pac_data['alergias'], ENT_QUOTES, 'UTF-8');
        $ocup = htmlspecialchars($pac_data['ocup'], ENT_QUOTES, 'UTF-8');
        $activo = htmlspecialchars($pac_data['activo'], ENT_QUOTES, 'UTF-8');

        // Calculate hospital stay
        $estancia = 0;
        if ($activo === 'SI') {
            $sql_now = "SELECT DATE_ADD(NOW(), INTERVAL 12 HOUR) as dat_now FROM dat_ingreso WHERE id_atencion = ?";
            $stmt = $conexion->prepare($sql_now);
            $stmt->bind_param("i", $id_atencion);
            $stmt->execute();
            $dat_now = $stmt->get_result()->fetch_assoc()['dat_now'] ?? date('Y-m-d H:i:s');
            $stmt->close();

            $sql_est = "SELECT DATEDIFF(?, fecha) as estancia FROM dat_ingreso WHERE id_atencion = ?";
            $stmt = $conexion->prepare($sql_est);
            $stmt->bind_param("si", $dat_now, $id_atencion);
            $stmt->execute();
            $estancia = $stmt->get_result()->fetch_assoc()['estancia'] ?? 0;
            $stmt->close();
        } else {
            $sql_est = "SELECT DATEDIFF(fec_egreso, fecha) as estancia FROM dat_ingreso WHERE id_atencion = ?";
            $stmt = $conexion->prepare($sql_est);
            $stmt->bind_param("i", $id_atencion);
            $stmt->execute();
            $estancia = ($stmt->get_result()->fetch_assoc()['estancia'] ?? 0) ?: 1;
            $stmt->close();
        }

        // Get diagnosis or motive
        $d = '';
        $sql_motd = "SELECT diagprob_i FROM dat_not_ingreso WHERE id_atencion = ? ORDER BY id_not_ingreso DESC LIMIT 1";
        $stmt = $conexion->prepare($sql_motd);
        $stmt->bind_param("i", $id_atencion);
        $stmt->execute();
        if ($row_motd = $stmt->get_result()->fetch_assoc()) {
            $d = htmlspecialchars($row_motd['diagprob_i'], ENT_QUOTES, 'UTF-8');
        }
        $stmt->close();

        if (!$d) {
            $sql_motd = "SELECT diagprob_i FROM dat_nevol WHERE id_atencion = ? ORDER BY id_ne DESC LIMIT 1";
            $stmt = $conexion->prepare($sql_motd);
            $stmt->bind_param("i", $id_atencion);
            $stmt->execute();
            if ($row_motd = $stmt->get_result()->fetch_assoc()) {
                $d = htmlspecialchars($row_motd['diagprob_i'], ENT_QUOTES, 'UTF-8');
            }
            $stmt->close();
        }

        $m = '';
        $sql_mot = "SELECT motivo_atn FROM dat_ingreso WHERE id_atencion = ? LIMIT 1";
        $stmt = $conexion->prepare($sql_mot);
        $stmt->bind_param("i", $id_atencion);
        $stmt->execute();
        if ($row_mot = $stmt->get_result()->fetch_assoc()) {
            $m = htmlspecialchars($row_mot['motivo_atn'], ENT_QUOTES, 'UTF-8');
        }
        $stmt->close();

        $edo_salud = '';
        $sql_edo = "SELECT edo_salud FROM dat_ingreso WHERE id_atencion = ? LIMIT 1";
        $stmt = $conexion->prepare($sql_edo);
        $stmt->bind_param("i", $id_atencion);
        $stmt->execute();
        if ($row_edo = $stmt->get_result()->fetch_assoc()) {
            $edo_salud = htmlspecialchars($row_edo['edo_salud'], ENT_QUOTES, 'UTF-8');
        }
        $stmt->close();

        $num_cama = '';
        $sql_hab = "SELECT num_cama FROM cat_camas WHERE id_atencion = ?";
        $stmt = $conexion->prepare($sql_hab);
        $stmt->bind_param("i", $id_atencion);
        $stmt->execute();
        $num_cama = htmlspecialchars($stmt->get_result()->fetch_assoc()['num_cama'] ?? '', ENT_QUOTES, 'UTF-8');
        $stmt->close();

        $peso = 0;
        $talla = 0;
        $sql_hclinica = "SELECT peso, talla FROM dat_hclinica WHERE Id_exp = ? ORDER BY id_hc DESC LIMIT 1";
        $stmt = $conexion->prepare($sql_hclinica);
        $stmt->bind_param("s", $id_exp);
        $stmt->execute();
        if ($row_hclinica = $stmt->get_result()->fetch_assoc()) {
            $peso = htmlspecialchars($row_hclinica['peso'] ?? 0, ENT_QUOTES, 'UTF-8');
            $talla = htmlspecialchars($row_hclinica['talla'] ?? 0, ENT_QUOTES, 'UTF-8');
        }
        $stmt->close();

        // Calculate age
        $fecha_nac = new DateTime($pac_fecnac);
        $fecha_actual = new DateTime();
        $edad = $fecha_nac->diff($fecha_actual);
        $edad_text = $edad->y > 0 ? $edad->y . " Años" : ($edad->m > 0 ? $edad->m . " Meses" : $edad->d . " Días");
        ?>
        <div class="row fs-6">
            <div class="col-md-6">
                Expediente: <strong><?php echo $folio; ?></strong><br>
                Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac; ?></strong>
            </div>
            <div class="col-md-3">
                Área: <strong><?php echo $area; ?></strong>
            </div>
            <div class="col-md-3">
                Fecha de Ingreso: <strong><?php echo date_format(date_create($pac_fecing), "d/m/Y"); ?></strong>
            </div>
        </div>
        <div class="row fs-6">
            <div class="col-md-3">
                Fecha de nacimiento: <strong><?php echo date_format(date_create($pac_fecnac), "d/m/Y"); ?></strong>
            </div>
            <div class="col-md-3">
                Tipo de sangre: <strong><?php echo $pac_tip_sang; ?></strong>
            </div>
            <div class="col-md-3">
                Habitación: <strong><?php echo $num_cama; ?></strong>
            </div>
            <div class="col-md-3">
                Tiempo estancia: <strong><?php echo $estancia; ?> Días</strong>
            </div>
        </div>
        <div class="row fs-6">
            <div class="col-md-3">
                Edad: <strong><?php echo $edad_text; ?></strong>
            </div>
            <div class="col-md-3">
                Peso: <strong><?php echo $peso; ?></strong>
            </div>
            <div class="col-md-3">
                Talla: <strong><?php echo $talla; ?></strong>
            </div>
            <div class="col-md-3">
                Género: <strong><?php echo $pac_sexo; ?></strong>
            </div>
        </div>
        <div class="row fs-6">
            <div class="col-md-3">
                Alergias: <strong><?php echo $alergias; ?></strong>
            </div>
            <div class="col-md-6">
                Estado de Salud: <strong><?php echo $edo_salud; ?></strong>
            </div>
            <div class="col-md-3">
                <?php echo $d ? "Diagnóstico: <strong>$d</strong>" : "Motivo de atención: <strong>$m</strong>"; ?>
            </div>
        </div>
        <hr>
        <div class="thead"><strong>HOJA DE PROGRAMACIÓN QUIRÚRGICA</strong></div>
        <div class="card mt-3">
            <ul class="nav nav-tabs nav-fill" id="menuRegistroTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="cirugia-tab" data-bs-toggle="tab" href="#cirugia" role="tab">Cirugía Segura</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="signos-tab" data-bs-toggle="tab" href="#signos" role="tab">Signos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="nota-tab" data-bs-toggle="tab" href="#nota" role="tab">Nota Enfermería</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ingresos-tab" data-bs-toggle="tab" href="#ingresos" role="tab">Ingresos / Egresos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="insumos-tab" data-bs-toggle="tab" href="#insumos" role="tab">Insumos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="equipos-tab" data-bs-toggle="tab" href="#equipos" role="tab">Equipos</a>
                </li>
            </ul>
            <div class="tab-content" id="menuRegistroTabsContent">
                <div class="tab-pane fade show active" id="cirugia" role="tabpanel">
                    <div class="thead"><strong>HOJA DE CIRUGÍA SEGURA</strong></div>
                    <hr>
                    <form action="../../enfermera/registro_quirurgico/insertar_cir_seg.php" method="POST">
                        <input type="hidden" name="id_exp" value="<?php echo htmlspecialchars($id_exp); ?>">
                        <input type="hidden" name="id_usua" value="<?php echo htmlspecialchars($id_usuario); ?>">
                        <input type="hidden" name="id_atencion" value="<?php echo htmlspecialchars($id_atencion); ?>">
                        <div class="card-container" style="display: flex; gap: 25px; margin: 20px 0;">
                            <!-- Sección 1 -->
                            <div class="card" style="flex: 1; padding: 20px; border: 2px solid #e3e6f0; border-radius: 15px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%); box-shadow: 0 4px 15px rgba(43, 45, 127, 0.1); transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <h4 style="margin-bottom: 20px; color: #2b2d7f; font-weight: 600; font-size: 18px; padding-bottom: 10px; border-bottom: 2px solid #e3e6f0;">Con el enfermero y el anestesista</h4>
                                <div class="checkbox-group">
                                    <strong>¿Ha confirmado el paciente su identidad, el sitio quirúrgico, el procedimiento y su consentimiento?</strong><br>
                                    <input type="checkbox" name="confirmacion_identidad" value="Sí"> Sí
                                </div>
                                <hr>
                                <div class="checkbox-group">
                                    <strong>¿Se ha marcado el sitio quirúrgico?</strong><br>
                                    <input type="checkbox" name="sitio_marcado[]" value="Sí"> Sí<br>
                                    <input type="checkbox" name="sitio_marcado[]" value="No procede"> No procede
                                </div>
                                <hr>
                                <div class="checkbox-group">
                                    <strong>¿Se ha completado la comprobación de los aparatos de anestesia y la medicación anestésica?</strong><br>
                                    <input type="checkbox" name="verificacion_anestesia" value="Sí"> Sí
                                </div>
                                <hr>
                                <div class="checkbox-group">
                                    <strong>¿Se ha colocado el pulsioximetro al paciente y funciona?</strong><br>
                                    <input type="checkbox" name="pulsioximetro" value="Sí"> Sí
                                </div>
                                <hr>
                                <div class="checkbox-group">
                                    <strong>¿Tiene el paciente alergias conocidas?</strong><br>
                                    <input type="checkbox" name="alergias[]" value="No"> No<br>
                                    <input type="checkbox" name="alergias[]" value="Sí"> Sí
                                </div>
                                <div class="checkbox-group">
                                    <strong>¿Tiene el paciente vía aérea difícil / riesgo de aspiración?</strong><br>
                                    <input type="checkbox" name="via_aerea_dificil[]" value="No"> No<br>
                                    <input type="checkbox" name="via_aerea_dificil[]" value="Sí, y hay materiales y equipos / ayuda disponible"> Sí, y hay materiales y equipos / ayuda disponible
                                </div>
                                <div class="checkbox-group">
                                    <strong>¿Riesgo de hemorragia &gt; 500 ml (7 ml/kg en niños)?</strong><br>
                                    <input type="checkbox" name="riesgo_hemorragia[]" value="No"> No<br>
                                    <input type="checkbox" name="riesgo_hemorragia[]" value="Sí, y se ha previsto la disponibilidad de líquidos y dos vías IV o centrales"> Sí, y se ha previsto la disponibilidad de líquidos y dos vías IV o centrales
                                </div>
                            </div>
                            <!-- Sección 2 -->
                            <div class="card" style="flex: 1; padding: 20px; border: 2px solid #e3e6f0; border-radius: 15px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%); box-shadow: 0 4px 15px rgba(43, 45, 127, 0.1); transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <h4 style="margin-bottom: 20px; color: #2b2d7f; font-weight: 600; font-size: 18px; padding-bottom: 10px; border-bottom: 2px solid #e3e6f0;">Con el enfermero, el anestesista y el cirujano</h4>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" name="miembros_presentados" value="1">
                                        <strong>Confirmar que todos los miembros del equipo se hayan presentado por su nombre</strong>
                                    </label>
                                </div>
                                <hr>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" name="confirmacion_identidad_equipo" value="1">
                                        <strong>Confirmar la identidad del paciente, el sitio quirúrgico y el procedimiento</strong>
                                    </label>
                                </div>
                                <hr>
                                <div class="checkbox-group">
                                    <strong>¿Se ha administrado profilaxis antibiótica en los últimos 60 minutos?</strong><br>
                                    <input type="checkbox" name="profilaxis_antibiotica_si" value="1"> Sí<br>
                                    <input type="checkbox" name="profilaxis_antibiotica_np" value="1"> No procede
                                </div>
                                <hr>
                                <strong>Previsión de eventos críticos</strong>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" name="problemas_instrumental" value="1">
                                        <strong>¿Hay dudas o problemas relacionados con el instrumental y los equipos?</strong>
                                    </label>
                                </div>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" name="duracion_operacion" value="1">
                                        <strong>Cirujano: ¿Cuánto durará la operación?</strong>
                                    </label>
                                </div>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" name="perdida_sangre" value="1">
                                        <strong>Cirujano: ¿Cuál es la pérdida de sangre prevista?</strong>
                                    </label>
                                </div>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" name="problemas_paciente" value="1">
                                        <strong>Anestesista: ¿Presenta el paciente algún problema específico?</strong>
                                    </label>
                                </div>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" name="esterilidad_confirmada" value="1">
                                        <strong>¿Se ha confirmado la esterilidad (con resultados de los indicadores)?</strong>
                                    </label>
                                </div>
                                <div class="checkbox-group">
                                    <strong>¿Pueden visualizarse las imágenes diagnósticas esenciales?</strong><br>
                                    <input type="checkbox" name="imagenes_visibles_si" value="1"> Sí<br>
                                    <input type="checkbox" name="imagenes_visibles_np" value="1"> No procede
                                </div>
                            </div>
                            <!-- Sección 3 -->
                            <div class="card" style="flex: 1; padding: 20px; border: 2px solid #e3e6f0; border-radius: 15px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%); box-shadow: 0 4px 15px rgba(43, 45, 127, 0.1); transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <h4 style="margin-bottom: 20px; color: #2b2d7f; font-weight: 600; font-size: 18px; padding-bottom: 10px; border-bottom: 2px solid #e3e6f0;">Antes de salir del quirófano</h4>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" name="nombre_procedimiento" value="1">
                                        <strong>El enfermero confirma verbalmente: El nombre del procedimiento</strong>
                                    </label>
                                </div>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" name="recuento_instrumental" value="1">
                                        <strong>El recuento de instrumentos, gasas y agujas</strong>
                                    </label>
                                </div>
                                <div class="checkbox-group">
                                    <label>
                                        <input type="checkbox" name="etiquetado_muestras" value="1">
                                        <strong>El etiquetado de las muestras (lectura de la etiqueta en voz alta, incluido el nombre del paciente)</strong>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <strong>Cirujano, anestesista y enfermero:</strong><br>
                                        <input type="checkbox" name="aspectos_recuperacion" value="1">
                                        ¿Cuáles son los aspectos críticos de la recuperación y el tratamiento del paciente?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">FIRMAR</button>
                            <a href="../../template/select_pac_enf.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="signos" role="tabpanel">
                    <div class="card mt-3">
                        <div class="thead">Seleccione los tratamientos a realizar:</div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <div class="row">
                                    <?php
                                    $sql_trat = "SELECT id, tipo FROM tratamientos ORDER BY tipo";
                                    $stmt = $conexion->prepare($sql_trat);
                                    if (!$stmt) {
                                        die("Prepare failed: " . $conexion->error);
                                    }
                                    $stmt->execute();
                                    $result_trat = $stmt->get_result();
                                    $contador = 0;
                                    while ($row_trat = $result_trat->fetch_assoc()) {
                                        $tipo = htmlspecialchars($row_trat['tipo'], ENT_QUOTES, 'UTF-8');
                                        $id = htmlspecialchars($row_trat['id'], ENT_QUOTES, 'UTF-8');
                                        $contador++;
                                        if ($contador % 2 == 1) {
                                            echo '<div class="col-md-6 mb-3">';
                                        }
                                        $es_lasik = (strtoupper($tipo) === 'CIRUGÍA LASIK' || strtoupper($tipo) === 'CIRUGIA LASIK');
                                        $clase_adicional = $es_lasik ? ' lasik-checkbox' : ' general-checkbox';
                                        echo '<div class="form-check" style="margin-bottom: 8px;">';
                                        echo '<input class="form-check-input tratamiento-checkbox' . $clase_adicional . '" type="checkbox" value="' . $id . '" id="trat_' . $id . '" data-tipo="' . $tipo . '" style="transform: scale(1.3); margin-right: 10px;">';
                                        echo '<label class="form-check-label" for="trat_' . $id . '">' . strtoupper($tipo) . '</label>';
                                        echo '</div>';
                                        if ($contador % 2 == 0) {
                                            echo '</div>';
                                        }
                                    }
                                    if ($contador % 2 == 1) {
                                        echo '</div>';
                                    }
                                    $stmt->close();
                                    ?>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-primary btn-lg" id="btn_cargar_tratamientos" style="display:none;">
                                        <i class="fas fa-clipboard-check"></i> Cargar Formularios Seleccionados
                                    </button>
                                </div>
                            </div>
                            <div id="formulario_contenedor" style="display: none;">
                                <div class="card formulario-tratamiento" id="formulario_general" style="display: none;">
                                    <div class="thead">FORMULARIO DE TRATAMIENTOS SELECCIONADOS</div>
                                    <div class="card-body">
                                        <form action="insertar_tratamientos_multiples.php" method="POST" id="formulario_unificado">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="id_exp" value="<?php echo $id_exp; ?>">
                                            <input type="hidden" name="id_usua" value="<?php echo $id_usuario; ?>">
                                            <input type="hidden" name="id_atencion" value="<?php echo $id_atencion; ?>">
                                            <input type="hidden" name="tratamientos_seleccionados" id="tratamientos_seleccionados_input">
                                            <div class="form-group">
                                                <label>Nombre del médico tratante:</label>
                                                <select class="form-control" name="medico_tratante" required>
                                                    <option value="">Seleccione un médico tratante</option>
                                                    <?php
                                                    $sql_med = "SELECT id_usua, nombre, papell, sapell FROM reg_usuarios WHERE id_rol = '2' AND u_activo = 'SI'";
                                                    $stmt = $conexion->prepare($sql_med);
                                                    $stmt->execute();
                                                    $result_med = $stmt->get_result();
                                                    while ($med = $result_med->fetch_assoc()) {
                                                        $nombre_med = trim($med['nombre'] . ' ' . $med['papell'] . ' ' . $med['sapell']);
                                                        echo '<option value="' . htmlspecialchars($nombre_med, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($nombre_med, ENT_QUOTES, 'UTF-8') . '</option>';
                                                    }
                                                    $stmt->close();
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Anestesiólogo:</label>
                                                <select class="form-control" name="anestesiologo" required>
                                                    <option value="">Seleccione un anestesiólogo</option>
                                                    <?php
                                                    $sql_anes = "SELECT id_usua, nombre, papell, sapell FROM reg_usuarios WHERE cargp LIKE '%ANESTESIOLOGO%' AND u_activo = 'SI'";
                                                    $stmt = $conexion->prepare($sql_anes);
                                                    $stmt->execute();
                                                    $result_anes = $stmt->get_result();
                                                    while ($anes = $result_anes->fetch_assoc()) {
                                                        $nombre_anes = trim($anes['nombre'] . ' ' . $anes['papell'] . ' ' . $anes['sapell']);
                                                        echo '<option value="' . htmlspecialchars($nombre_anes, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($nombre_anes, ENT_QUOTES, 'UTF-8') . '</option>';
                                                    }
                                                    $stmt->close();
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Anestesia:</label>
                                                <select class="form-control" name="anestesia" required>
                                                    <option value="">Seleccione tipo de anestesia</option>
                                                    <option value="LOCAL">LOCAL</option>
                                                    <option value="SEDACIÓN">SEDACIÓN</option>
                                                </select>
                                            </div>
                                            <div class="row" id="campos_lasik" style="display:none;">
                                                <div class="col-md-6">
                                                    <label>OD</label>
                                                    <input type="text" class="form-control mb-1" name="od_queratometria" placeholder="QUERATOMETRIA">
                                                    <input type="text" class="form-control mb-1" name="od_microqueratomo" placeholder="MICROQUERATOMO">
                                                    <input type="text" class="form-control mb-1" name="od_anillo" placeholder="ANILLO">
                                                    <input type="text" class="form-control mb-1" name="od_tope" placeholder="TOPE">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>OI</label>
                                                    <input type="text" class="form-control mb-1" name="oi_queratometria" placeholder="QUERATOMETRIA">
                                                    <input type="text" class="form-control mb-1" name="oi_microqueratomo" placeholder="MICROQUERATOMO">
                                                    <input type="text" class="form-control mb-1" name="oi_anillo" placeholder="ANILLO">
                                                    <input type="text" class="form-control mb-1" name="oi_tope" placeholder="TOPE">
                                                </div>
                                            </div>
                                            <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-primary btn-lg">Enviar Formulario</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="thead">Registro de Signos Vitales</div>
                        <div class="card-body">
                            <form action="insertar_signos_vitales.php" method="POST" id="form_signos_vitales">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="id_exp" value="<?php echo $id_exp; ?>">
                                <input type="hidden" name="id_usua" value="<?php echo $id_usuario; ?>">
                                <input type="hidden" name="id_atencion" value="<?php echo $id_atencion; ?>">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-signos-vitales" id="tabla-signos-unico">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%;">Momento</th>
                                                <th style="width: 12%;">Presión Sistólica</th>
                                                <th style="width: 12%;">Presión Diastólica</th>
                                                <th style="width: 10%;">Frecuencia Cardiaca</th>
                                                <th style="width: 10%;">Frecuencia Respiratoria</th>
                                                <th style="width: 11%;">Saturación O2</th>
                                                <th style="width: 12%;">Temperatura</th>
                                                <th style="width: 8%;">Hora</th>
                                                <th style="width: 10%;">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Signos Vitales</strong><br><small>registro actual</small></td>
                                                <td><input type="text" class="form-control" name="sistg" placeholder="ej: 120" required></td>
                                                <td><input type="text" class="form-control" name="diastg" placeholder="ej: 80" required></td>
                                                <td><input type="text" class="form-control" name="fcardg" placeholder="ej: 75" required></td>
                                                <td><input type="text" class="form-control" name="frespg" placeholder="ej: 20" required></td>
                                                <td><input type="text" class="form-control" name="satg" placeholder="ej: 98%" required></td>
                                                <td><input type="text" class="form-control" name="tempg" placeholder="ej: 36.5" required></td>
                                                <td><input type="time" class="form-control" name="hora_signos" required></td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-save"></i> Guardar
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nota" role="tabpanel">
                    <div class="card mt-3">
                        <div class="thead">Nota de Enfermería</div>
                        <div class="card-body">
                            <form action="insertar_nota_enfermeria.php" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="id_exp" value="<?php echo $id_exp; ?>">
                                <input type="hidden" name="id_usua" value="<?php echo $id_usuario; ?>">
                                <input type="hidden" name="id_atencion" value="<?php echo $id_atencion; ?>">
                                <div class="form-group mt-3">
                                    <label>Nota de enfermería:</label>
                                    <div class="btn-group mb-2">
                                        <button type="button" class="btn btn-danger btn-sm grabar-nota"><i class="fas fa-microphone"></i></button>
                                        <button type="button" class="btn btn-primary btn-sm detener-nota"><i class="fas fa-microphone-slash"></i></button>
                                        <button type="button" class="btn btn-success btn-sm reproducir-nota"><i class="fas fa-play"></i></button>
                                    </div>
                                    <textarea class="form-control nota-enfermeria" rows="5" name="nota_enfermeria" required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>ENFERMERA RESPONSABLE:</label>
                                        <input type="text" class="form-control" name="enfermera_responsable" value="<?php echo $usuario_actual; ?>" readonly style="background-color: #e9ecef;">
                                    </div>
                                    <div class="col-md-6" id="medico_responsable_container">
                                        <div class="d-flex align-items-center">
                                            <label style="font-size:16px; margin-bottom:0; margin-right:8px;">MÉDICO RESPONSABLE:</label>
                                            <button type="button" class="btn btn-outline-primary btn-sm" id="btn_toggle_medico_responsable" style="margin-right:8px;">
                                                <i class="fas fa-user-md"></i> Seleccionar
                                            </button>
                                        </div>
                                        <div id="select_medico_responsable_wrap" style="display:none; margin-top:8px;">
                                            <select class="form-control" name="medico_responsable" id="select_medico_responsable" required>
                                                <option value="">Seleccione un médico responsable</option>
                                                <?php
                                                $sql_med2 = "SELECT id_usua, nombre, papell, sapell FROM reg_usuarios WHERE id_rol = 2 AND u_activo = 'SI'";
                                                $result_med2 = $conexion->query($sql_med2);
                                                if ($result_med2 && $result_med2->num_rows > 0) {
                                                    while ($med2 = $result_med2->fetch_assoc()) {
                                                        $nombre_med2 = trim($med2['nombre'] . ' ' . $med2['papell'] . ' ' . $med2['sapell']);
                                                        echo '<option value="' . htmlspecialchars($nombre_med2) . '">' . htmlspecialchars($nombre_med2) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save"></i> Guardar Nota
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ingresos" role="tabpanel">
                    <div class="thead"><strong>INGRESOS</strong></div>
                    <div class="container mt-3">
                        <div class="text-center mb-3">
                            <a href="#!" data-bs-toggle="modal" data-bs-target="#addUserModalI" class="btn btn-success">Agregar nuevos ingresos</a>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" style="width:25%" id="search_nuevoI" placeholder="Buscar...">
                        </div>
                        <table id="exampleI" class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fecha de registro</th>
                                    <th>Fecha de reporte</th>
                                    <th>Hora</th>
                                    <th>Soluciones</th>
                                    <th>Volumen</th>
                                    <th>Registró</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <!-- Ingresos Modal -->
                    <div class="modal fade" id="addUserModalI" tabindex="-1" aria-labelledby="addUserModalLabelI" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUserModalLabelI">Agregar nuevos ingresos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addUserI">
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="id_usua" value="<?php echo $id_usuario; ?>">
                                        <input type="hidden" name="id_atencion" value="<?php echo $id_atencion; ?>">
                                        <div class="mb-3 row">
                                            <label for="addfechaiField" class="col-md-3 form-label">Fecha de reporte</label>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" id="addfechaiField" name="fechai" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="addhoraiField" class="col-md-3 form-label">Hora</label>
                                            <div class="col-md-9">
                                                <input type="time" class="form-control" id="addhoraiField" name="horai">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="addsolucionesField" class="col-md-3 form-label">Describir ingresos</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="addsolucionesField" name="soluciones">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="addvolumenField" class="col-md-3 form-label">Volumen</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="addvolumenField" name="volumen">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="exampleModalI" tabindex="-1" aria-labelledby="exampleModalLabelI" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabelI">Editar registro</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="updateUserI">
                                        <input type="hidden" name="id" id="id">
                                        <input type="hidden" name="trid" id="trid">
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="fecha_registro" id="fecha_registroField">
                                        <input type="hidden" name="id_usua" id="id_usuaField" value="<?php echo $id_usuario; ?>">
                                        <div class="mb-3 row">
                                            <label for="fechaiField" class="col-md-3 form-label">Fecha de reporte</label>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" id="fechaiField" name="fechai">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="horaiField" class="col-md-3 form-label">Hora</label>
                                            <div class="col-md-9">
                                                <input type="time" class="form-control" id="horaiField" name="horai">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="solucionesField" class="col-md-3 form-label">Describir ingresos</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="solucionesField" name="soluciones">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="volumenField" class="col-md-3 form-label">Volumen</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="volumenField" name="volumen">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Editar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="thead mt-4"><strong>EGRESOS</strong></div>
                    <div class="container mt-3">
                        <div class="text-center mb-3">
                            <a href="#!" data-bs-toggle="modal" data-bs-target="#addUserModalE" class="btn btn-success">Agregar nuevos egresos</a>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" style="width:25%" id="search_nuevoE" placeholder="Buscar...">
                        </div>
                        <table id="exampleE" class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fecha de registro</th>
                                    <th>Fecha de reporte</th>
                                    <th>Hora</th>
                                    <th>Soluciones</th>
                                    <th>Volumen</th>
                                    <th>Registró</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <!-- Egresos Modal -->
                    <div class="modal fade" id="addUserModalE" tabindex="-1" aria-labelledby="addUserModalLabelE" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUserModalLabelE">Agregar nuevos egresos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addUserE">
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="id_usua" value="<?php echo $id_usuario; ?>">
                                        <input type="hidden" name="id_atencion" value="<?php echo $id_atencion; ?>">
                                        <div class="mb-3 row">
                                            <label for="addfechaeField" class="col-md-3 form-label">Fecha de reporte</label>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" id="addfechaeField" name="fechae" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="addhoraeField" class="col-md-3 form-label">Hora</label>
                                            <div class="col-md-9">
                                                <input type="time" class="form-control" id="addhoraeField" name="horae">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="addsolucioneseField" class="col-md-3 form-label">Describir egresos</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="addsolucioneseField" name="solucionese">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="addvolumeneField" class="col-md-3 form-label">Volumen</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="addvolumeneField" name="volumene">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="exampleModalE" tabindex="-1" aria-labelledby="exampleModalLabelE" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabelE">Editar registro</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="updateUserE">
                                        <input type="hidden" name="id" id="id">
                                        <input type="hidden" name="trid" id="trid">
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="fecha_registro" id="fecha_registroeField">
                                        <input type="hidden" name="id_usua" id="id_usuaeField" value="<?php echo $id_usuario; ?>">
                                        <div class="mb-3 row">
                                            <label for="fechaeField" class="col-md-3 form-label">Fecha de reporte</label>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" id="fechaeField" name="fechae">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="horaeField" class="col-md-3 form-label">Hora</label>
                                            <div class="col-md-9">
                                                <input type="time" class="form-control" id="horaeField" name="horae">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="solucioneseField" class="col-md-3 form-label">Describir egresos</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="solucioneseField" name="solucionese">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="volumeneField" class="col-md-3 form-label">Volumen</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="volumeneField" name="volumene">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Editar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="insumos" role="tabpanel">
                    <h5 class="text-primary font-weight-bold"><i class="fas fa-box-open"></i> Insumos</h5>
                    <p class="text-muted">Control y registro de insumos utilizados.</p>
                </div>
                <div class="tab-pane fade" id="equipos" role="tabpanel">
                    <div class="thead"><strong>REGISTRAR EQUIPOS</strong></div>
                    <hr>
                    <!-- Dropdown Menu -->
                    <div class="mb-3">
                        <label for="serviceSelect" class="form-label">Seleccionar Equipo:</label>
                        <select class="custom-select" id="serviceSelect" onchange="addService()">
                            <option value="">Seleccione un equipo</option>
                            <?php
                            $sql = "SELECT id_serv, serv_desc, serv_costo FROM cat_servicios WHERE tip_insumo = 'CEYE' AND serv_activo = 'SI'";
                            $result = $conexion->query($sql);
                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id_serv']}' data-desc='" . htmlspecialchars($row['serv_desc'], ENT_QUOTES, 'UTF-8') . "' data-cost='{$row['serv_costo']}'>" . htmlspecialchars($row['serv_desc'], ENT_QUOTES, 'UTF-8') . "</option>";
                                }
                                $result->free();
                            } else {
                                echo "<option value=''>Error al cargar servicios</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Table for Selected Services -->
                    <table class="table table-bordered table-hover" id="selectedServicesTable">
                        <thead class="table-light">
                            <tr>
                                <th>Descripción</th>
                                <th>Costo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="selectedServicesBody"></tbody>
                    </table>

                    <!-- Submit Button -->
                    <button class="btn btn-primary mt-3" onclick="submitServices()">Registrar Equipos</button>
                    <BR></BR>
                    <!-- Table for Registered Services -->
                    <div class="thead"><strong>EQUIPOS REGISTRADOS</strong></div>
                    <hr>
                    <table class="table table-bordered table-hover" id="registeredServicesTable">
                        <thead class="table-light">
                            <tr>
                                <th>Descripción</th>
                                <th>Costo</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="registeredServicesBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <footer class="main-footer mt-4">
            <div class="fs-6">
                <?php include '../../template/footer.php'; ?>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            // Initialize tabs
            $('#menuRegistroTabs a').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            // Initialize DataTables for Ingresos
            $('#exampleI').DataTable({
                language: {
                    decimal: "",
                    emptyTable: "No hay información",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
                    infoFiltered: "(Filtrado de _MAX_ total entradas)",
                    infoPostFix: "",
                    thousands: ",",
                    lengthMenu: "Mostrar _MENU_ Entradas",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    zeroRecords: "Sin resultados encontrados",
                    paginate: {
                        first: "Primero",
                        last: "Ultimo",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                fnCreatedRow: function(nRow, aData) {
                    $(nRow).attr('id', aData[0]);
                },
                serverSide: true,
                processing: true,
                paging: true,
                searching: false,
                order: [],
                ajax: {
                    url: 'fetch_dataI.php',
                    type: 'POST',
                    data: function(d) {
                        d.id_atencion = '<?php echo $id_atencion; ?>';
                        d.csrf_token = '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>';
                    }
                }
            });

            // Initialize DataTables for Egresos
            $('#exampleE').DataTable({
                language: {
                    decimal: "",
                    emptyTable: "No hay información",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
                    infoFiltered: "(Filtrado de _MAX_ total entradas)",
                    infoPostFix: "",
                    thousands: ",",
                    lengthMenu: "Mostrar _MENU_ Entradas",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    zeroRecords: "Sin resultados encontrados",
                    paginate: {
                        first: "Primero",
                        last: "Ultimo",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                fnCreatedRow: function(nRow, aData) {
                    $(nRow).attr('id', aData[0]);
                },
                serverSide: true,
                processing: true,
                paging: true,
                searching: false,
                order: [],
                ajax: {
                    url: 'fetch_dataE.php',
                    type: 'POST',
                    data: {
                        id_atencion: '<?php echo $id_atencion; ?>'
                    }
                },
                columnDefs: [{
                    targets: [7],
                    orderable: false
                }]
            });

            // Handle Ingresos form submission
            $('#addUserI').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                if ($('#addhoraiField').val() && $('#addfechaiField').val() &&
                    $('#addsolucionesField').val() && $('#addvolumenField').val()) {
                    $.ajax({
                        url: "add_userI.php",
                        type: "POST",
                        data: formData,
                        success: function(data) {
                            try {
                                const json = JSON.parse(data);
                                if (json.status === 'true') {
                                    $('#exampleI').DataTable().draw();
                                    $('#addUserI')[0].reset();
                                    $('#addUserModalI').modal('hide');
                                    alertify.success("Registro agregado correctamente");
                                } else {
                                    alertify.error("Error al agregar el registro");
                                }
                            } catch (e) {
                                alertify.error("Error en la respuesta del servidor");
                            }
                        },
                        error: function() {
                            alertify.error("Error en la comunicación con el servidor");
                        }
                    });
                } else {
                    alertify.warning("Completa todos los campos por favor!");
                }
            });

            // Handle Egresos form submission
            $('#addUserE').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                if ($('#addhoraeField').val() && $('#addfechaeField').val() &&
                    $('#addsolucioneseField').val() && $('#addvolumeneField').val()) {
                    $.ajax({
                        url: "add_userE.php",
                        type: "POST",
                        data: formData,
                        success: function(data) {
                            try {
                                const json = JSON.parse(data);
                                if (json.status === 'true') {
                                    $('#exampleE').DataTable().draw();
                                    $('#addUserE')[0].reset();
                                    $('#addUserModalE').modal('hide');
                                    alertify.success("Registro agregado correctamente");
                                } else {
                                    alertify.error("Error al agregar el registro");
                                }
                            } catch (e) {
                                alertify.error("Error en la respuesta del servidor");
                            }
                        },
                        error: function() {
                            alertify.error("Error en la comunicación con el servidor");
                        }
                    });
                } else {
                    alertify.warning("Completa todos los campos por favor!");
                }
            });

            // Handle Ingresos edit
            $('#exampleI').on('click', '.editbtnI', function() {
                const id = $(this).data('id');
                const trid = $(this).closest('tr').attr('id');
                $.ajax({
                    url: "get_single_dataI.php",
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        try {
                            const json = JSON.parse(data);
                            $('#horaiField').val(json.hora);
                            $('#fechaiField').val(json.fecha);
                            $('#solucionesField').val(json.soluciones);
                            $('#volumenField').val(json.volumen);
                            $('#id_usuaField').val(json.id_usua);
                            $('#fecha_registroField').val(json.fecha_registro);
                            $('#id').val(id);
                            $('#trid').val(trid);
                            $('#exampleModalI').modal('show');
                        } catch (e) {
                            alertify.error("Error en la respuesta del servidor");
                        }
                    }
                });
            });

            // Handle Egresos edit
            $('#exampleE').on('click', '.editbtnE', function() {
                const id = $(this).data('id');
                const trid = $(this).closest('tr').attr('id');
                $.ajax({
                    url: "get_single_dataE.php",
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        try {
                            const json = JSON.parse(data);
                            $('#horaeField').val(json.hora);
                            $('#fechaeField').val(json.fecha);
                            $('#solucioneseField').val(json.soluciones);
                            $('#volumeneField').val(json.volumen);
                            $('#id_usuaeField').val(json.id_usua);
                            $('#fecha_registroeField').val(json.fecha_registro);
                            $('#id').val(id);
                            $('#trid').val(trid);
                            $('#exampleModalE').modal('show');
                        } catch (e) {
                            alertify.error("Error en la respuesta del servidor");
                        }
                    }
                });
            });

            // Handle Ingresos update
            $('#updateUserI').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                if ($('#horaiField').val() && $('#fechaiField').val() &&
                    $('#solucionesField').val() && $('#volumenField').val()) {
                    $.ajax({
                        url: "update_userI.php",
                        type: "POST",
                        data: formData,
                        success: function(data) {
                            try {
                                const json = JSON.parse(data);
                                if (json.status === 'true') {
                                    const table = $('#exampleI').DataTable();
                                    const id = $('#id').val();
                                    const trid = $('#trid').val();
                                    const button = `<td>
                                        <a href="javascript:void(0);" data-id="${id}" class="btn btn-warning btn-sm editbtnI">Editar</a>
                                        <a href="javascript:void(0);" data-id="${id}" class="btn btn-danger btn-sm deleteBtnI">Eliminar</a>
                                    </td>`;
                                    const rowData = [
                                        id,
                                        $('#fecha_registroField').val(),
                                        $('#fechaiField').val(),
                                        $('#horaiField').val(),
                                        $('#solucionesField').val(),
                                        $('#volumenField').val(),
                                        $('#id_usuaField').val(),
                                        button
                                    ];
                                    table.row(`[id='${trid}']`).data(rowData);
                                    $('#exampleModalI').modal('hide');
                                    alertify.success("Registro editado correctamente");
                                } else {
                                    alertify.error("Error al editar el registro");
                                }
                            } catch (e) {
                                alertify.error("Error en la respuesta del servidor");
                            }
                        }
                    });
                } else {
                    alertify.warning("Completa todos los campos por favor!");
                }
            });

            // Handle Egresos update
            $('#updateUserE').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                if ($('#horaeField').val() && $('#fechaeField').val() &&
                    $('#solucioneseField').val() && $('#volumeneField').val()) {
                    $.ajax({
                        url: "update_userE.php",
                        type: "POST",
                        data: formData,
                        success: function(data) {
                            try {
                                const json = JSON.parse(data);
                                if (json.status === 'true') {
                                    const table = $('#exampleE').DataTable();
                                    const id = $('#id').val();
                                    const trid = $('#trid').val();
                                    const button = `<td>
                                        <a href="javascript:void(0);" data-id="${id}" class="btn btn-warning btn-sm editbtnE">Editar</a>
                                        <a href="javascript:void(0);" data-id="${id}" class="btn btn-danger btn-sm deleteBtnE">Eliminar</a>
                                    </td>`;
                                    const rowData = [
                                        id,
                                        $('#fecha_registroeField').val(),
                                        $('#fechaeField').val(),
                                        $('#horaeField').val(),
                                        $('#solucioneseField').val(),
                                        $('#volumeneField').val(),
                                        $('#id_usuaeField').val(),
                                        button
                                    ];
                                    table.row(`[id='${trid}']`).data(rowData);
                                    $('#exampleModalE').modal('hide');
                                    alertify.success("Registro editado correctamente");
                                } else {
                                    alertify.error("Error al editar el registro");
                                }
                            } catch (e) {
                                alertify.error("Error en la respuesta del servidor");
                            }
                        }
                    });
                } else {
                    alertify.warning("Completa todos los campos por favor!");
                }
            });

            // Handle Ingresos delete
            $('#exampleI').on('click', '.deleteBtnI', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                if (confirm("¿Estás seguro de eliminar este registro?")) {
                    $.ajax({
                        url: "delete_userI.php",
                        type: "POST",
                        data: {
                            id: id,
                            csrf_token: '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>'
                        },
                        success: function(data) {
                            try {
                                const json = JSON.parse(data);
                                if (json.status === 'success') {
                                    $("#" + id).closest('tr').remove();
                                    alertify.success("Registro eliminado correctamente");
                                } else {
                                    alertify.error("Error al eliminar el registro");
                                }
                            } catch (e) {
                                alertify.error("Error en la respuesta del servidor");
                            }
                        }
                    });
                }
            });

            // Handle Egresos delete
            $('#exampleE').on('click', '.deleteBtnE', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                if (confirm("¿Estás seguro de eliminar este registro?")) {
                    $.ajax({
                        url: "delete_userE.php",
                        type: "POST",
                        data: {
                            id: id,
                            csrf_token: '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>'
                        },
                        success: function(data) {
                            try {
                                const json = JSON.parse(data);
                                if (json.status === 'success') {
                                    $("#" + id).closest('tr').remove();
                                    alertify.success("Registro eliminado correctamente");
                                } else {
                                    alertify.error("Error al eliminar el registro");
                                }
                            } catch (e) {
                                alertify.error("Error en la respuesta del servidor");
                            }
                        }
                    });
                }
            });

            // Search functionality
            $('#search_nuevoI').on('keyup', function() {
                $('#exampleI').DataTable().search(this.value).draw();
            });

            $('#search_nuevoE').on('keyup', function() {
                $('#exampleE').DataTable().search(this.value).draw();
            });

            // Toggle medico responsable
            $('#btn_toggle_medico_responsable').on('click', function() {
                $('#select_medico_responsable_wrap').toggle();
            });
        });
    </script>

    <script>
        // Equipos
        let selectedServices = [];

        // Load registered services on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOMContentLoaded: Attempting to load registered services');
            loadRegisteredServices();
        });

        function addService() {
            const select = document.getElementById('serviceSelect');
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption.value) {
                const service = {
                    id: selectedOption.value,
                    desc: selectedOption.getAttribute('data-desc'),
                    cost: parseFloat(selectedOption.getAttribute('data-cost'))
                };

                // Avoid duplicates
                if (!selectedServices.some(s => s.id === service.id)) {
                    selectedServices.push(service);
                    updateTable();
                } else {
                    alertify.warning('Este equipo ya está seleccionado.');
                }
                select.value = ''; // Reset dropdown
            }
        }

        function updateTable() {
            const tbody = document.getElementById('selectedServicesBody');
            tbody.innerHTML = '';
            selectedServices.forEach((service, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${service.desc}</td>
            <td>$${service.cost.toFixed(2)}</td>
            <td>
                <button class="btn btn-sm btn-danger" onclick="deleteServices(${index})">Eliminar</button>
            </td>
        `;
                tbody.appendChild(row);
            });
        }

        function deleteServices(index) {
            if (confirm('¿Está seguro de eliminar este equipo?')) {
                selectedServices.splice(index, 1);
                updateTable();
            }
        }

        function submitServices() {
            if (selectedServices.length === 0) {
                alertify.warning('Por favor, seleccione al menos un equipo.');
                return;
            }

            const formData = new FormData();
            formData.append('id_usua', <?php echo json_encode($id_usuario); ?>);
            formData.append('id_atencion', <?php echo json_encode($id_atencion); ?>);
            formData.append('csrf_token', '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>');
            selectedServices.forEach((service) => {
                formData.append(`services[${service.id}]`, service.cost);
            });

            // Log FormData for debugging
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            fetch('process_services.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Submit Services Response Status:', response.status);
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP error! Status: ${response.status}, Response: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Submit Services Response Data:', data);
                    if (data.success) {
                        alertify.success(data.message);
                        selectedServices = [];
                        updateTable();
                        loadRegisteredServices(); // Refresh registered services table
                    } else {
                        alertify.error(`Error al registrar equipos: ${data.message}`);
                    }
                })
                .catch(error => {
                    console.error('Submit Services Fetch Error:', error);
                    alertify.error('Error al registrar equipos: ' + error.message);
                });
        }

        function loadRegisteredServices() {
            console.log('Loading registered services...');
            fetch('services_handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'get',
                        id_usua: <?php echo json_encode($_SESSION['login']['id_usua'] ?? 0); ?>,
                        id_atencion: <?php echo json_encode($_SESSION['pac'] ?? 0); ?>,
                        csrf_token: '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>'
                    })
                })
                .then(response => {
                    console.log('Load Services Response Status:', response.status);
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP error! Status: ${response.status}, Response: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Load Services Response Data:', data);
                    const tbody = document.getElementById('registeredServicesBody');
                    tbody.innerHTML = '';
                    if (data.success && data.services && data.services.length > 0) {
                        data.services.forEach(service => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                    <td>${service.serv_desc}</td>
                    <td>$${parseFloat(service.cta_tot).toFixed(2)}</td>
                    <td>${service.cta_fec}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="deleteService(${service.id_ctapac})">Eliminar</button>
                    </td>
                `;
                            tbody.appendChild(row);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="4">No hay servicios registrados.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Load Services Fetch Error:', error);
                    document.getElementById('registeredServicesBody').innerHTML = '<tr><td colspan="4">Error al cargar servicios: ' + error.message + '</td></tr>';
                });
        }

        function deleteService(id_ctapac) {
            if (confirm('¿Estás seguro de eliminar este equipo?')) {
                fetch('services_handler.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            action: 'delete',
                            id_ctapac: id_ctapac,
                            csrf_token: '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>'
                        })
                    })
                    .then(response => {
                        console.log('Delete Service Response Status:', response.status);
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP error! Status: ${response.status}, Response: ${text}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Delete Service Response Data:', data);
                        if (data.success) {
                            alertify.success('Equipo eliminado correctamente.');
                            loadRegisteredServices();
                        } else {
                            alertify.error('Error al eliminar equipo: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Delete Service Fetch Error:', error);
                        alertify.error('Error al eliminar equipo: ' + error.message);
                    });
            }
        }
    </script>
</body>

</html>
<?php
$conexion->close();
?>