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
    <link rel="stylesheet" href="notificaciones-mejoradas.css" />
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

        /* Estilos para la tabla de signos vitales */
        .table-signos-vitales {
            border: 2px solid #2b2d7f;
        }

        .table-signos-vitales thead th {
            background-color: #2b2d7f !important;
            color: white !important;
            font-weight: bold;
            border: 1px solid #1a1d5f;
        }

        .table-signos-vitales tbody tr {
            border: 1px solid #dee2e6;
        }

        .table-signos-vitales tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table-signos-vitales tbody tr:hover {
            background-color: #e3f2fd;
        }

        .signos-input {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px 8px;
            font-size: 14px;
        }

        .signos-input:focus {
            border-color: #4a4ed1;
            box-shadow: 0 0 0 0.2rem rgba(74, 78, 209, 0.25);
        }

        .signos-input.bg-light {
            background-color: #e9ecef !important;
            color: #6c757d;
        }

        .fila-signos-vitales td {
            padding: 8px;
            vertical-align: middle;
        }

        #agregar-signos-adicionales {
            background: linear-gradient(45deg, #2b2d7f, #2b2d7f);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        #agregar-signos-adicionales:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        }

        /* Estilos para formulario de nota de enfermería */
        .nota-enfermeria-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
            border-radius: 15px;
            padding: 20px;
            border: 2px solid #e3e6f0;
            box-shadow: 0 4px 15px rgba(43, 45, 127, 0.1);
        }

        .form-group label {
            font-weight: 600;
            color: #2b2d7f;
            margin-bottom: 5px;
        }

        .form-control:focus {
            border-color: #4a4ed1;
            box-shadow: 0 0 0 0.2rem rgba(74, 78, 209, 0.25);
        }

        .btn-outline-primary {
            border-color: #2b2d7f;
            color: #2b2d7f;
        }

        .btn-outline-primary:hover {
            background-color: #2b2d7f;
            border-color: #2b2d7f;
        }

        .btn-primary {
            background-color: #2b2d7f;
            border-color: #2b2d7f;
        }

        .btn-primary:hover {
            background-color: #1e2070;
            border-color: #1e2070;
        }

        /* Animación para elementos que se muestran/ocultan */
        #select_medico_responsable_wrap {
            transition: all 0.3s ease;
        }

        /* Estilo para campos requeridos */
        .form-control:invalid {
            border-color: #e74c3c;
        }

        .form-control:valid {
            border-color: #27ae60;
        }

        /* Estilos para los botones de grabación de audio */
        .btn-group .btn {
            margin-right: 5px;
        }

        .grabar-nota {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }

        .detener-nota {
            background-color: #3498db;
            border-color: #3498db;
        }

        .reproducir-nota {
            background-color: #27ae60;
            border-color: #27ae60;
        }

        /* Estilos adicionales para botones de voz */
        .btn-group .btn {
            position: relative;
            overflow: hidden;
        }

        .btn-group .btn:active {
            transform: scale(0.95);
        }

        .recording-indicator {
            font-size: 12px;
            font-weight: bold;
            color: #dc3545;
            vertical-align: middle;
            margin-left: 10px;
        }

        /* Animación de pulso para el indicador de grabación */
        @keyframes pulse-recording {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.1); }
            100% { opacity: 1; transform: scale(1); }
        }

        .pulse-animation {
            animation: pulse-recording 1.5s infinite;
        }

        /* Mejorar el aspecto del textarea durante dictado */
        .nota-enfermeria.dictating {
            border-color: #dc3545;
            box-shadow: 0 0 10px rgba(220, 53, 69, 0.3);
            background-color: #fff5f5;
        }

        /* Tooltips mejorados para botones de voz */
        .btn-group .btn[title] {
            position: relative;
        }

        /* Estados hover para botones de voz */
        .grabar-nota:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .detener-nota:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .reproducir-nota:hover {
            background-color: #219a52;
            transform: scale(1.05);
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
                        <div class="thead">Registro de Signos Vitales</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-signos-vitales" id="tabla-signos-multiples">
                                    <thead style="background-color: #2b2d7f; color: white;">
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
                                    <tbody id="signos-vitales-tbody">
                                        <tr class="fila-signos-vitales">
                                            <td><strong>Signos Vitales</strong><br><small class="text-muted">registro actual</small></td>
                                            <td><input type="text" class="form-control signos-input" name="sistg[]" placeholder="ej: 120" required></td>
                                            <td><input type="text" class="form-control signos-input" name="diastg[]" placeholder="ej: 80" required></td>
                                            <td><input type="text" class="form-control signos-input" name="fcardg[]" placeholder="ej: 75" required></td>
                                            <td><input type="text" class="form-control signos-input" name="frespg[]" placeholder="ej: 20" required></td>
                                            <td><input type="text" class="form-control signos-input" name="satg[]" placeholder="ej: 98%" required></td>
                                            <td><input type="text" class="form-control signos-input" name="tempg[]" placeholder="ej: 36.5" required></td>
                                            <td><input type="time" class="form-control signos-input" name="hora_signos[]" required></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm guardar-signos" data-fila="0">
                                                    <i class="fas fa-save"></i> Guardar
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-info btn-lg me-3" id="agregar-signos-adicionales">
                                    <i class="fas fa-plus"></i> Agregar signos vitales adicionales
                                </button>
                                <button type="button" class="btn btn-success btn-lg" id="guardar-todos-signos">
                                    <i class="fas fa-save"></i> Guardar todos los signos vitales
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nota" role="tabpanel">
                    <!-- Sección de Tratamientos -->
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
                                        echo '<input class="form-check-input tratamiento-checkbox' . $clase_adicional . '" type="checkbox" value="' . $id . '" id="trat_nota_' . $id . '" data-tipo="' . $tipo . '" style="transform: scale(1.3); margin-right: 10px;">';
                                        echo '<label class="form-check-label" for="trat_nota_' . $id . '">' . strtoupper($tipo) . '</label>';
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
                            </div>
                            <div id="formulario_contenedor_nota" style="display: none;">
                                <div class="card formulario-tratamiento" id="formulario_general_nota" style="display: none;">
                                    <div class="thead" id="titulo_tratamientos_dinamico_nota">FORMULARIO DE TRATAMIENTOS SELECCIONADOS</div>
                                    <div class="card-body">
                                        <form action="insertar_tratamientos_multiples.php" method="POST" id="formulario_unificado_nota">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="id_exp" value="<?php echo $id_exp; ?>">
                                            <input type="hidden" name="id_usua" value="<?php echo $id_usuario; ?>">
                                            <input type="hidden" name="id_atencion" value="<?php echo $id_atencion; ?>">
                                            <input type="hidden" name="tratamientos_seleccionados" id="tratamientos_seleccionados_input_nota">
                                            <div class="form-group">
                                                <label>Nombre del médico tratante:</label>
                                                <select class="form-control" name="medico_tratante" required>
                                                    <option value="">Seleccione un médico tratante</option>
                                                    <?php
                                                    $sql_med_form = "SELECT id_usua, nombre, papell, sapell FROM reg_usuarios WHERE id_rol = '2' AND u_activo = 'SI'";
                                                    $stmt_form = $conexion->prepare($sql_med_form);
                                                    $stmt_form->execute();
                                                    $result_med_form = $stmt_form->get_result();
                                                    while ($med_form = $result_med_form->fetch_assoc()) {
                                                        $nombre_med_form = trim($med_form['nombre'] . ' ' . $med_form['papell'] . ' ' . $med_form['sapell']);
                                                        echo '<option value="' . htmlspecialchars($nombre_med_form, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($nombre_med_form, ENT_QUOTES, 'UTF-8') . '</option>';
                                                    }
                                                    $stmt_form->close();
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Anestesiólogo:</label>
                                                <select class="form-control" name="anestesiologo" required>
                                                    <option value="">Seleccione un anestesiólogo</option>
                                                    <?php
                                                    $sql_anes_form = "SELECT id_usua, nombre, papell, sapell FROM reg_usuarios WHERE cargp LIKE '%ANESTESIOLOGO%' AND u_activo = 'SI'";
                                                    $stmt_anes_form = $conexion->prepare($sql_anes_form);
                                                    $stmt_anes_form->execute();
                                                    $result_anes_form = $stmt_anes_form->get_result();
                                                    while ($anes_form = $result_anes_form->fetch_assoc()) {
                                                        $nombre_anes_form = trim($anes_form['nombre'] . ' ' . $anes_form['papell'] . ' ' . $anes_form['sapell']);
                                                        echo '<option value="' . htmlspecialchars($nombre_anes_form, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($nombre_anes_form, ENT_QUOTES, 'UTF-8') . '</option>';
                                                    }
                                                    $stmt_anes_form->close();
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Anestesia:</label>
                                                <select class="form-control" name="anestesia" required>
                                                    <option value="">Seleccione tipo de anestesia</option>
                                                    <option value="LOCAL">LOCAL</option>
                                                    <option value="SEDACIÓN">SEDACIÓN</option>
                                                    <option value="GENERAL">GENERAL</option>
                                                    <option value="REGIONAL">REGIONAL</option>
                                                </select>
                                            </div>
                                            <div class="row" id="campos_lasik_nota" style="display:none;">
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
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sección de Nota de Enfermería -->
                    <div class="card mt-3">
                        <div class="thead">Nota de Enfermería</div>
                        <div class="card-body">
                            <form action="insertar_nota_enfermeria.php" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="id_exp" value="<?php echo $id_exp; ?>">
                                <input type="hidden" name="id_usua" value="<?php echo $id_usuario; ?>">
                                <input type="hidden" name="id_atencion" value="<?php echo $id_atencion; ?>">
                                
                                <!-- Campos ocultos para capturar datos de tratamientos desde el formulario principal -->
                                <input type="hidden" name="tratamientos_seleccionados" id="tratamientos_seleccionados_nota" value="">
                                <input type="hidden" name="medico_tratante" id="medico_tratante_nota" value="">
                                <input type="hidden" name="anestesiologo" id="anestesiologo_nota" value="">
                                <input type="hidden" name="anestesia" id="anestesia_nota" value="">

                                <div class="form-group mt-3">
                                    <label>Nota de enfermería:</label>
                                    <div class="btn-group mb-2">
                                        <button type="button" class="btn btn-danger btn-sm grabar-nota" title="Iniciar dictado por voz (Ctrl+Shift+R)">
                                            <i class="fas fa-microphone"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm detener-nota" title="Detener dictado por voz (Ctrl+Shift+S)" disabled>
                                            <i class="fas fa-microphone-slash"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm reproducir-nota" title="Reproducir texto escrito (Ctrl+Shift+P)">
                                            <i class="fas fa-play"></i>
                                        </button>
                                    </div>
                                    <textarea class="form-control nota-enfermeria" rows="5" name="nota_enfermeria" required placeholder="Escriba aquí la nota de enfermería o use el dictado por voz..."></textarea>
                                    <small class="form-text text-muted">
                                        💡 <strong>Tip:</strong> Use los botones de arriba para dictar por voz o reproducir el texto. Funciona mejor en navegadores Chrome, Edge o Safari.
                                    </small>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <label>ENFERMERA RESPONSABLE:</label>
                                        <input type="text" class="form-control" name="enfermera_responsable" value="<?php echo $usuario_actual; ?>" readonly style="background-color: #e9ecef;">
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
                            $sql = "SELECT id_serv, serv_desc, serv_costo FROM cat_servicios WHERE grupo = 'CEYE' AND serv_activo = 'SI'";
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

            // Cargar signos vitales existentes cuando se abra la pestaña de signos
            $('#signos-tab').on('shown.bs.tab', function(e) {
                cargarSignosVitalesExistentes();
            });

            // Variable global para tracking de signos vitales cargados
            let signosVitalesCargados = false;

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

        // Manejar selección de tratamientos en pestaña Nota de Enfermería
        $(document).ready(function() {
            // Función común para manejar tratamientos
            function manejarTratamientos(contexto) {
                var tratamientosSeleccionados = $('.tratamiento-checkbox:checked');
                
                // Elementos específicos del contexto (nota)
                var formularioContenedor = $('#formulario_contenedor_nota');
                var formularioGeneral = $('#formulario_general_nota');
                var tituloTratamientos = $('#titulo_tratamientos_dinamico_nota');
                var camposLasik = $('#campos_lasik_nota');
                var inputTratamientos = $('#tratamientos_seleccionados_input_nota');
                
                if (tratamientosSeleccionados.length > 0) {
                    // Obtener nombres de tratamientos seleccionados
                    var nombresTratamientos = [];
                    tratamientosSeleccionados.each(function() {
                        var nombreTratamiento = $(this).data('tipo');
                        nombresTratamientos.push(nombreTratamiento.toUpperCase());
                    });
                    
                    // Actualizar título dinámicamente
                    var tituloCompleto = 'FORMULARIO DE TRATAMIENTOS SELECCIONADOS<br><span style="color: #4a4ed1; font-weight: bold; font-size: 16px;">' + nombresTratamientos.join(' - ') + '</span>';
                    tituloTratamientos.html(tituloCompleto);
                    
                    // Mostrar formulario inmediatamente
                    formularioContenedor.show();
                    formularioGeneral.show();
                    
                    // Verificar si hay tratamientos LASIK seleccionados
                    var hayLasik = false;
                    tratamientosSeleccionados.each(function() {
                        if ($(this).hasClass('lasik-checkbox')) {
                            hayLasik = true;
                            return false;
                        }
                    });
                    
                    // Mostrar/ocultar campos específicos de LASIK
                    if (hayLasik) {
                        camposLasik.show();
                    } else {
                        camposLasik.hide();
                    }
                    
                    // Actualizar input hidden con tratamientos seleccionados
                    var tratamientosIds = [];
                    tratamientosSeleccionados.each(function() {
                        tratamientosIds.push($(this).val());
                    });
                    inputTratamientos.val(tratamientosIds.join(','));
                    
                } else {
                    // Restaurar título original y ocultar formulario
                    tituloTratamientos.html('FORMULARIO DE TRATAMIENTOS SELECCIONADOS');
                    formularioContenedor.hide();
                    formularioGeneral.hide();
                    camposLasik.hide();
                }
            }
            
            // Event listener para checkboxes de tratamiento en pestaña nota
            $(document).on('change', '.tratamiento-checkbox', function() {
                manejarTratamientos('nota');
            });
        });

        // Configuración mejorada de Alertify
        $(document).ready(function() {
            // Configurar Alertify con opciones mejoradas
            alertify.set('notifier', 'position', 'top-right');
            alertify.set('notifier', 'delay', 5);
            
            // Configurar diálogos
            alertify.defaults.theme.ok = "btn btn-primary";
            alertify.defaults.theme.cancel = "btn btn-secondary";
            alertify.defaults.theme.input = "form-control";
            
            // Personalizar textos
            alertify.defaults.glossary.title = 'Sistema de Signos Vitales';
            alertify.defaults.glossary.ok = 'Aceptar';
            alertify.defaults.glossary.cancel = 'Cancelar';
            
            console.log('🎨 Sistema de notificaciones mejoradas inicializado');
        });

        // Funcionalidad para signos vitales múltiples
        let contadorFilasSignos = 1; // Solo tenemos 1 fila por defecto
        
        // Agregar nueva fila de signos vitales
        $('#agregar-signos-adicionales').on('click', function() {
            contadorFilasSignos++;
            const nuevaFila = `
                <tr class="fila-signos-vitales">
                    <td><strong>Signos Vitales</strong><br><small class="text-muted">registro actual #${contadorFilasSignos}</small></td>
                    <td><input type="text" class="form-control signos-input" name="sistg[]" placeholder="ej: 120"></td>
                    <td><input type="text" class="form-control signos-input" name="diastg[]" placeholder="ej: 80"></td>
                    <td><input type="text" class="form-control signos-input" name="fcardg[]" placeholder="ej: 75"></td>
                    <td><input type="text" class="form-control signos-input" name="frespg[]" placeholder="ej: 20"></td>
                    <td><input type="text" class="form-control signos-input" name="satg[]" placeholder="ej: 98%"></td>
                    <td><input type="text" class="form-control signos-input" name="tempg[]" placeholder="ej: 36.5"></td>
                    <td><input type="time" class="form-control signos-input" name="hora_signos[]"></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm guardar-signos" data-fila="${contadorFilasSignos - 1}">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-danger btn-sm ml-1 eliminar-fila">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#signos-vitales-tbody').append(nuevaFila);
        });

        // Eliminar fila de signos vitales
        $(document).on('click', '.eliminar-fila', function() {
            if (confirm('¿Estás seguro de eliminar esta fila?')) {
                $(this).closest('tr').remove();
            }
        });

        // Función para cargar signos vitales existentes
        function cargarSignosVitalesExistentes() {
            if (signosVitalesCargados) {
                console.log('Signos vitales ya cargados, omitiendo recarga...');
                return;
            }

            console.log('Cargando signos vitales existentes...');
            
            fetch(`obtener_signos_vitales.php?id_atencion=<?php echo $id_atencion; ?>`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Respuesta de signos vitales:', data);
                
                if (data.success && data.data && data.data.length > 0) {
                    // Limpiar tabla actual (mantener solo la fila base)
                    $('#signos-vitales-tbody tr.fila-signos-existente').remove();
                    
                    // Agregar signos vitales existentes
                    data.data.forEach((signo, index) => {
                        contadorFilasSignos++;
                        const filaExistente = `
                            <tr class="fila-signos-vitales fila-signos-existente" data-id-trans-graf="${signo.id_trans_graf}">
                                <td><strong>Registro Guardado</strong><br><small class="text-muted">${signo.fecha} - ${signo.tratamientos}</small></td>
                                <td><input type="text" class="form-control signos-input bg-light" name="sistg[]" value="${signo.sistg}" readonly></td>
                                <td><input type="text" class="form-control signos-input bg-light" name="diastg[]" value="${signo.diastg}" readonly></td>
                                <td><input type="text" class="form-control signos-input bg-light" name="fcardg[]" value="${signo.fcardg}" readonly></td>
                                <td><input type="text" class="form-control signos-input bg-light" name="frespg[]" value="${signo.frespg}" readonly></td>
                                <td><input type="text" class="form-control signos-input bg-light" name="satg[]" value="${signo.satg}" readonly></td>
                                <td><input type="text" class="form-control signos-input bg-light" name="tempg[]" value="${signo.tempg}" readonly></td>
                                <td><input type="time" class="form-control signos-input bg-light" name="hora_signos[]" value="${signo.hora}" readonly></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm editar-signos" data-id-trans-graf="${signo.id_trans_graf}">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm guardar-signos" data-fila="${contadorFilasSignos - 1}" data-id-trans-graf="${signo.id_trans_graf}" style="display: none;">
                                        <i class="fas fa-save"></i> Actualizar
                                    </button>
                                </td>
                            </tr>
                        `;
                        $('#signos-vitales-tbody').append(filaExistente);
                    });
                    
                    alertify.success(`📊 Se cargaron ${data.data.length} registro(s) de signos vitales existentes.`);
                    signosVitalesCargados = true;
                } else {
                    console.log('No hay signos vitales guardados para hoy');
                    alertify.message('ℹ️ No hay signos vitales registrados para el día de hoy.');
                }
            })
            .catch(error => {
                console.error('Error al cargar signos vitales:', error);
                alertify.error('❌ Error al cargar signos vitales existentes: ' + error.message);
            });
        }

        // Editar signos vitales guardados
        $(document).on('click', '.editar-signos', function() {
            const fila = $(this).closest('tr');
            const inputs = fila.find('input');
            const btnEditar = $(this);
            const btnGuardar = fila.find('.guardar-signos');
            
            // Habilitar inputs para edición
            inputs.prop('readonly', false).removeClass('bg-light');
            
            // Ocultar botón editar y mostrar botón guardar
            btnEditar.hide();
            btnGuardar.show().removeClass('btn-success').addClass('btn-primary');
            btnGuardar.html('<i class="fas fa-save"></i> Actualizar');
            
            alertify.success('Modo de edición activado. Modifique los valores y presione "Actualizar".');
        });

        // Guardar signos vitales individuales
        $(document).on('click', '.guardar-signos', function() {
            const fila = $(this).closest('tr');
            const inputs = fila.find('input');
            const btn = $(this);
            const btnEditar = fila.find('.editar-signos');
            
            // Verificar si estamos en modo de actualización - mejora de detección
            const esActualizacion = btn.html().includes('Actualizar') || 
                                   fila.hasClass('fila-signos-existente') || 
                                   btn.data('id-trans-graf');
            const idTransGraf = btn.data('id-trans-graf') || fila.data('id-trans-graf');
            
            console.log('Modo de operación:', esActualizacion ? 'ACTUALIZACIÓN' : 'NUEVO REGISTRO');
            console.log('ID Trans Graf:', idTransGraf);
            console.log('Es fila existente:', fila.hasClass('fila-signos-existente'));
            
            // Validar que todos los campos estén llenos
            let todosLlenos = true;
            inputs.each(function() {
                if ($(this).val().trim() === '') {
                    todosLlenos = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!todosLlenos) {
                alertify.warning('Por favor, complete todos los campos de signos vitales.');
                return;
            }

            // Validar rangos normales
            const sistolica = parseInt(fila.find('input[name="sistg[]"]').val());
            const diastolica = parseInt(fila.find('input[name="diastg[]"]').val());
            const frecCardiaca = parseInt(fila.find('input[name="fcardg[]"]').val());
            const frecRespiratoria = parseInt(fila.find('input[name="frespg[]"]').val());
            const saturacion = parseInt(fila.find('input[name="satg[]"]').val().replace('%', ''));
            const temperatura = parseFloat(fila.find('input[name="tempg[]"]').val());

            if (sistolica < 50 || sistolica > 200) {
                alertify.error('La presión sistólica debe estar entre 50 y 200 mmHg');
                return;
            }
            if (diastolica < 30 || diastolica > 120) {
                alertify.error('La presión diastólica debe estar entre 30 y 120 mmHg');
                return;
            }
            if (frecCardiaca < 30 || frecCardiaca > 200) {
                alertify.error('La frecuencia cardíaca debe estar entre 30 y 200 bpm');
                return;
            }
            if (frecRespiratoria < 8 || frecRespiratoria > 40) {
                alertify.error('La frecuencia respiratoria debe estar entre 8 y 40 rpm');
                return;
            }
            if (saturacion < 50 || saturacion > 100) {
                alertify.error('La saturación de oxígeno debe estar entre 50% y 100%');
                return;
            }
            if (temperatura < 34 || temperatura > 42) {
                alertify.error('La temperatura debe estar entre 34°C y 42°C');
                return;
            }

            // Cambiar estado del botón
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

            // Preparar datos para envío
            const formData = new FormData();
            formData.append('sistg', sistolica);
            formData.append('diastg', diastolica);
            formData.append('fcardg', frecCardiaca);
            formData.append('frespg', frecRespiratoria);
            formData.append('satg', saturacion);
            formData.append('tempg', temperatura);
            formData.append('hora_signos', fila.find('input[name="hora_signos[]"]').val());
            formData.append('id_usua', '<?php echo $id_usuario; ?>');
            formData.append('id_atencion', '<?php echo $id_atencion; ?>');
            
            // Agregar ID del registro si es una actualización
            if (esActualizacion && idTransGraf) {
                formData.append('id_trans_graf', idTransGraf);
                formData.append('es_actualizacion', '1');
            }
            
            // Obtener tratamientos seleccionados
            const tratamientosSeleccionados = $('.tratamiento-checkbox:checked');
            let tratamientosIds = [];
            tratamientosSeleccionados.each(function() {
                tratamientosIds.push($(this).val());
            });
            
            // Si no hay tratamientos seleccionados, usar ID por defecto
            if (tratamientosIds.length === 0) {
                tratamientosIds = ['1']; // ID por defecto para signos vitales
            }
            
            formData.append('tratamientos_ids', tratamientosIds.join(','));
            formData.append('csrf_token', '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>');

            // Debug: Log what we're sending
            console.log('Enviando datos:', {
                modo: esActualizacion ? 'ACTUALIZACIÓN' : 'NUEVO',
                id_trans_graf: idTransGraf,
                es_actualizacion: esActualizacion ? '1' : '0',
                sistg: sistolica,
                diastg: diastolica,
                fcardg: frecCardiaca,
                frespg: frecRespiratoria,
                satg: saturacion,
                tempg: temperatura,
                hora_signos: fila.find('input[name="hora_signos[]"]').val(),
                tratamientos_ids: tratamientosIds.join(','),
                button_text: btn.html(),
                id_atencion: '<?php echo $id_atencion; ?>',
                id_usua: '<?php echo $id_usuario; ?>'
            });

            // Enviar por AJAX
            fetch('insertar_signos_vitales.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del servidor:', data);
                
                if (data.success) {
                    btn.removeClass('btn-primary').addClass('btn-success');
                    btn.html('<i class="fas fa-check"></i> Guardado');
                    btn.hide(); // Ocultar botón guardar
                    
                    // Crear y mostrar botón editar
                    if (btnEditar.length === 0) {
                        const botonEditar = $('<button type="button" class="btn btn-warning btn-sm ml-1 editar-signos"><i class="fas fa-edit"></i> Editar</button>');
                        btn.parent().append(botonEditar);
                    } else {
                        btnEditar.show();
                    }
                    
                    // Deshabilitar inputs de la fila
                    inputs.prop('readonly', true).addClass('bg-light');
                    
                    // Mensajes específicos según el tipo de operación
                    let mensaje = data.message;
                    if (data.details) {
                        mensaje += ' ' + data.details;
                    }
                    
                    if (data.registros_actualizados > 0) {
                        alertify.success(`🔄 ${mensaje}`);
                        console.log(`✅ Registros actualizados: ${data.registros_actualizados}`);
                    } else if (data.registros_insertados > 0) {
                        alertify.success(`💾 ${mensaje}`);
                        console.log(`✅ Registros insertados: ${data.registros_insertados}`);
                    } else {
                        alertify.success(`✅ ${mensaje}`);
                    }
                    
                    // Log adicional para debugging
                    if (data.summary) {
                        console.log('Resumen de la operación:', data.summary);
                    }
                    
                    // Preguntar si quiere ir a nota de registro gráfico
                    setTimeout(() => {
                        alertify.confirm('Signos Vitales Guardados', 
                            `✅ Los signos vitales se han guardado correctamente.<br><br>¿Desea ir a la página de Nota de Registro Gráfico?`,
                            function() {
                                // Sí, ir a la página
                                window.open('nota_registro_grafico.php', '_blank');
                            },
                            function() {
                                // No, permanecer en la página actual
                                console.log('Usuario decidió permanecer en la página actual');
                            }
                        );
                    }, 1000);
                    
                } else {
                    throw new Error(data.message || 'Error desconocido');
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                console.error('Modo era:', esActualizacion ? 'ACTUALIZACIÓN' : 'NUEVO REGISTRO');
                
                // Mostrar mensaje de error más informativo
                let mensajeError = 'Error al ' + (esActualizacion ? 'actualizar' : 'guardar') + ' signos vitales';
                
                // Si hay información adicional en el error, mostrarla
                if (error.message) {
                    mensajeError += ': ' + error.message;
                }
                
                alertify.error(mensajeError);
                
                // Restaurar estado del botón
                btn.prop('disabled', false);
                if (esActualizacion) {
                    btn.html('<i class="fas fa-save"></i> Actualizar');
                } else {
                    btn.html('<i class="fas fa-save"></i> Guardar');
                }
            });
        });

        // Guardar todos los signos vitales de una vez
        $(document).on('click', '#guardar-todos-signos', function() {
            const btn = $(this);
            const todasLasFilas = $('#signos-vitales-tbody tr.fila-signos-vitales');
            let signosParaGuardar = [];
            let erroresValidacion = [];
            
            console.log('🔄 Iniciando validación de todos los signos vitales...');
            
            // Validar todas las filas y recopilar datos
            todasLasFilas.each(function(index) {
                const fila = $(this);
                const sistg = fila.find('input[name="sistg[]"]').val();
                const diastg = fila.find('input[name="diastg[]"]').val();
                const fcardg = fila.find('input[name="fcardg[]"]').val();
                const frespg = fila.find('input[name="frespg[]"]').val();
                const satg = fila.find('input[name="satg[]"]').val();
                const tempg = fila.find('input[name="tempg[]"]').val();
                const hora_signos = fila.find('input[name="hora_signos[]"]').val();
                
                // Verificar si la fila tiene datos
                const tieneAlgunDato = sistg || diastg || fcardg || frespg || satg || tempg || hora_signos;
                
                if (tieneAlgunDato) {
                    // Validar que todos los campos estén completos
                    if (!sistg || !diastg || !fcardg || !frespg || !satg || !tempg || !hora_signos) {
                        erroresValidacion.push(`Fila ${index + 1}: Todos los campos son obligatorios`);
                        fila.find('input').each(function() {
                            if (!$(this).val()) {
                                $(this).addClass('is-invalid');
                            } else {
                                $(this).removeClass('is-invalid');
                            }
                        });
                    } else {
                        // Validar rangos
                        const sistolica = parseInt(sistg);
                        const diastolica = parseInt(diastg);
                        const frecCardiaca = parseInt(fcardg);
                        const frecRespiratoria = parseInt(frespg);
                        const saturacion = parseInt(satg.replace('%', ''));
                        const temperatura = parseFloat(tempg);
                        
                        if (sistolica < 50 || sistolica > 200) {
                            erroresValidacion.push(`Fila ${index + 1}: Presión sistólica debe estar entre 50 y 200 mmHg`);
                        }
                        if (diastolica < 30 || diastolica > 120) {
                            erroresValidacion.push(`Fila ${index + 1}: Presión diastólica debe estar entre 30 y 120 mmHg`);
                        }
                        if (frecCardiaca < 30 || frecCardiaca > 200) {
                            erroresValidacion.push(`Fila ${index + 1}: Frecuencia cardíaca debe estar entre 30 y 200 bpm`);
                        }
                        if (frecRespiratoria < 8 || frecRespiratoria > 40) {
                            erroresValidacion.push(`Fila ${index + 1}: Frecuencia respiratoria debe estar entre 8 y 40 rpm`);
                        }
                        if (saturacion < 50 || saturacion > 100) {
                            erroresValidacion.push(`Fila ${index + 1}: Saturación debe estar entre 50% y 100%`);
                        }
                        if (temperatura < 34 || temperatura > 42) {
                            erroresValidacion.push(`Fila ${index + 1}: Temperatura debe estar entre 34°C y 42°C`);
                        }
                        
                        if (erroresValidacion.length === 0 || !erroresValidacion.some(error => error.includes(`Fila ${index + 1}`))) {
                            // Solo agregar si no hay errores para esta fila
                            signosParaGuardar.push({
                                sistg: sistolica,
                                diastg: diastolica,
                                fcardg: frecCardiaca,
                                frespg: frecRespiratoria,
                                satg: saturacion,
                                tempg: temperatura,
                                hora_signos: hora_signos,
                                fila_index: index,
                                es_actualizacion: fila.hasClass('fila-signos-existente'),
                                id_trans_graf: fila.data('id-trans-graf') || null
                            });
                            
                            // Remover clases de error
                            fila.find('input').removeClass('is-invalid');
                        }
                    }
                }
            });
            
            console.log(`📊 Signos para guardar: ${signosParaGuardar.length}`);
            console.log(`⚠️ Errores de validación: ${erroresValidacion.length}`);
            
            if (erroresValidacion.length > 0) {
                alertify.alert('Errores de Validación', 
                    '⚠️ Se encontraron los siguientes errores:<br><br>• ' + erroresValidacion.join('<br>• '),
                    function() {
                        // Focus en el primer campo con error
                        $('#signos-vitales-tbody .is-invalid').first().focus();
                    }
                );
                return;
            }
            
            if (signosParaGuardar.length === 0) {
                alertify.warning('📝 No hay signos vitales para guardar. Complete al menos una fila con todos los datos.');
                return;
            }
            
            // Confirmar antes de proceder
            alertify.confirm('Guardar Múltiples Registros', 
                `🔄 ¿Está seguro de guardar ${signosParaGuardar.length} registro(s) de signos vitales?<br><br>Esta operación puede tardar unos momentos...`,
                function() {
                    procesarSignosMultiples(signosParaGuardar, btn);
                },
                function() {
                    alertify.message('❌ Operación cancelada.');
                }
            );
        });

        // Función para procesar múltiples signos vitales
        function procesarSignosMultiples(signosParaGuardar, btn) {
            const totalSignos = signosParaGuardar.length;
            
            // Cambiar estado del botón
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
            
            console.log(`🚀 Iniciando procesamiento de ${totalSignos} signos vitales...`);
            
            // Obtener tratamientos seleccionados
            const tratamientosSeleccionados = $('.tratamiento-checkbox:checked');
            let tratamientosIds = [];
            tratamientosSeleccionados.each(function() {
                tratamientosIds.push($(this).val());
            });
            
            // Si no hay tratamientos seleccionados, usar ID por defecto
            if (tratamientosIds.length === 0) {
                tratamientosIds = ['1']; // ID por defecto para signos vitales
            }
            
            // Preparar datos para envío múltiple
            const formData = new FormData();
            formData.append('id_usua', '<?php echo $id_usuario; ?>');
            formData.append('id_atencion', '<?php echo $id_atencion; ?>');
            formData.append('tratamientos_ids', tratamientosIds.join(','));
            formData.append('csrf_token', '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>');
            
            // Agregar cada signo vital como array estructurado
            signosParaGuardar.forEach((signo, index) => {
                formData.append(`signos_vitales[${index}][sistg]`, signo.sistg);
                formData.append(`signos_vitales[${index}][diastg]`, signo.diastg);
                formData.append(`signos_vitales[${index}][fcardg]`, signo.fcardg);
                formData.append(`signos_vitales[${index}][frespg]`, signo.frespg);
                formData.append(`signos_vitales[${index}][satg]`, signo.satg);
                formData.append(`signos_vitales[${index}][tempg]`, signo.tempg);
                formData.append(`signos_vitales[${index}][hora_signos]`, signo.hora_signos);
            });
            
            // Enviar todo de una vez
            fetch('guardar_signos_multiples.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('📊 Respuesta del procesamiento múltiple:', data);
                
                if (data.success) {
                    // Marcar todas las filas como guardadas
                    signosParaGuardar.forEach(signo => {
                        const fila = $(`#signos-vitales-tbody tr.fila-signos-vitales:eq(${signo.fila_index})`);
                        fila.find('.guardar-signos').hide();
                        fila.find('input').prop('readonly', true).addClass('bg-light');
                        
                        // Agregar botón de editar si no existe
                        if (fila.find('.editar-signos').length === 0) {
                            const botonEditar = $('<button type="button" class="btn btn-warning btn-sm ml-1 editar-signos"><i class="fas fa-edit"></i> Editar</button>');
                            fila.find('td:last').append(botonEditar);
                        }
                    });
                    
                    // Mensaje de éxito detallado
                    let mensajeCompleto = data.message;
                    if (data.details) {
                        mensajeCompleto += `<br><small>${data.details}</small>`;
                    }
                    
                    alertify.success(`🎉 ${mensajeCompleto}`);
                    
                    // Log detallado
                    console.log(`✅ Procesamiento exitoso:`);
                    console.log(`   - Total procesados: ${data.registros_procesados}`);
                    console.log(`   - Exitosos: ${data.registros_exitosos}`);
                    console.log(`   - Actualizados: ${data.registros_actualizados}`);
                    console.log(`   - Insertados: ${data.registros_insertados}`);
                    
                    // Preguntar si quiere ir a nota de registro gráfico
                    alertify.confirm('Signos Vitales Guardados', 
                        `🎉 Se han guardado exitosamente ${data.registros_procesados} registro(s) de signos vitales.<br><br>¿Desea ir a la página de Nota de Registro Gráfico?`,
                        function() {
                            // Sí, ir a la página
                            window.open('http://127.0.0.1:8000/enfermera/registro_procedimientos/nota_registro_grafico.php', '_blank');
                            // También recargar después de abrir la nueva página
                            setTimeout(() => {
                                if (typeof cargarSignosVitalesExistentes === 'function') {
                                    cargarSignosVitalesExistentes();
                                }
                            }, 1000);
                        },
                        function() {
                            // No, solo recargar
                            setTimeout(() => {
                                if (typeof cargarSignosVitalesExistentes === 'function') {
                                    cargarSignosVitalesExistentes();
                                }
                            }, 1000);
                        }
                    );
                    
                } else {
                    throw new Error(data.message || 'Error desconocido en el procesamiento múltiple');
                }
            })
            .catch(error => {
                console.error('❌ Error en procesamiento múltiple:', error);
                alertify.alert('Error de Procesamiento', 
                    `❌ Error al guardar los signos vitales:<br><br>${error.message}`,
                    function() {
                        // Permitir al usuario intentar nuevamente
                        console.log('🔄 Usuario puede intentar nuevamente');
                    }
                );
            })
            .finally(() => {
                // Restaurar estado del botón
                btn.prop('disabled', false);
                btn.html('<i class="fas fa-save"></i> Guardar todos los signos vitales');
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

        // Enviar formulario completo
        $(document).on('click', '#enviar-formulario-completo', function() {
            const btn = $(this);
            
            // Validar que haya tratamientos seleccionados
            const tratamientosSeleccionados = $('.tratamiento-checkbox:checked');
            if (tratamientosSeleccionados.length === 0) {
                alertify.warning('⚠️ Por favor, seleccione al menos un tratamiento para proceder.');
                return;
            }

            // Validar que haya datos del formulario de tratamientos
            const medicoTratante = $('select[name="medico_tratante"]').val();
            const anestesiologo = $('select[name="anestesiologo"]').val();
            const anestesia = $('select[name="anestesia"]').val();

            if (!medicoTratante || !anestesiologo || !anestesia) {
                alertify.warning('📝 Por favor, complete todos los campos del formulario de tratamientos (médico tratante, anestesiólogo, anestesia).');
                return;
            }

            // Recopilar signos vitales de todas las filas
            const signosVitales = [];
            $('#signos-vitales-tbody tr.fila-signos-vitales').each(function() {
                const fila = $(this);
                const sistg = fila.find('input[name="sistg[]"]').val();
                const diastg = fila.find('input[name="diastg[]"]').val();
                const fcardg = fila.find('input[name="fcardg[]"]').val();
                const frespg = fila.find('input[name="frespg[]"]').val();
                const satg = fila.find('input[name="satg[]"]').val();
                const tempg = fila.find('input[name="tempg[]"]').val();
                const hora_signos = fila.find('input[name="hora_signos[]"]').val();

                // Solo agregar si todos los campos están llenos
                if (sistg && diastg && fcardg && frespg && satg && tempg && hora_signos) {
                    signosVitales.push({
                        sistg: sistg,
                        diastg: diastg,
                        fcardg: fcardg,
                        frespg: frespg,
                        satg: satg,
                        tempg: tempg,
                        hora_signos: hora_signos
                    });
                }
            });

            if (signosVitales.length === 0) {
                // Si no hay signos vitales en el formulario, verificar si el usuario quiere usar los guardados previamente
                alertify.confirm('📊 Signos Vitales', 
                    'No hay signos vitales completados en el formulario actual.<br><br>¿Desea enviar el formulario utilizando los signos vitales guardados previamente?',
                    function() {
                        // Usuario acepta usar signos vitales previos
                        procederConEnvio();
                    },
                    function() {
                        // Usuario cancela
                        alertify.message('📝 Por favor, complete los signos vitales antes de continuar.');
                    }
                );
                return;
            }
            
            procederConEnvio();
            
            function procederConEnvio() {
                // Confirmar envío
                let mensajeConfirmacion;
                if (signosVitales.length > 0) {
                    mensajeConfirmacion = '📤 ¿Está seguro de enviar el formulario completo?<br><br>Se procesarán <strong>' + (signosVitales.length * tratamientosSeleccionados.length) + ' registros</strong><br>(' + signosVitales.length + ' signos vitales × ' + tratamientosSeleccionados.length + ' tratamientos)';
                } else {
                    mensajeConfirmacion = '📤 ¿Está seguro de enviar el formulario completo?<br><br>Se utilizarán los signos vitales guardados previamente para los <strong>' + tratamientosSeleccionados.length + ' tratamiento(s)</strong> seleccionado(s).';
                }
                
                alertify.confirm('🚀 Confirmación de Envío', mensajeConfirmacion,
                    function() {
                        // Usuario confirma el envío
                        ejecutarEnvio();
                    },
                    function() {
                        // Usuario cancela
                        alertify.message('📋 Envío cancelado.');
                    }
                );
            }
            
            function ejecutarEnvio() {
                // Cambiar estado del botón
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin"></i> Enviando...');

                // Preparar datos para envío
                const formData = new FormData();
                formData.append('id_usua', '<?php echo $id_usuario; ?>');
                formData.append('id_atencion', '<?php echo $id_atencion; ?>');
                formData.append('medico_tratante', medicoTratante);
                formData.append('anestesiologo', anestesiologo);
                formData.append('anestesia', anestesia);

                // Agregar tratamientos seleccionados
                let tratamientosIds = [];
                tratamientosSeleccionados.each(function() {
                    tratamientosIds.push($(this).val());
                });
                formData.append('tratamientos_seleccionados', tratamientosIds.join(','));

                // Agregar signos vitales solo si los hay en el formulario
                if (signosVitales.length > 0) {
                    signosVitales.forEach(function(signo, index) {
                        formData.append(`signos_vitales[${index}][sistg]`, signo.sistg);
                        formData.append(`signos_vitales[${index}][diastg]`, signo.diastg);
                        formData.append(`signos_vitales[${index}][fcardg]`, signo.fcardg);
                        formData.append(`signos_vitales[${index}][frespg]`, signo.frespg);
                        formData.append(`signos_vitales[${index}][satg]`, signo.satg);
                        formData.append(`signos_vitales[${index}][tempg]`, signo.tempg);
                        formData.append(`signos_vitales[${index}][hora_signos]`, signo.hora_signos);
                    });
                }
                // Si no hay signos vitales en el formulario, el backend buscará los guardados previamente

                // Agregar campos LASIK si están presentes
                if ($('#campos_lasik').is(':visible')) {
                    formData.append('od_queratometria', $('input[name="od_queratometria"]').val());
                    formData.append('od_microqueratomo', $('input[name="od_microqueratomo"]').val());
                    formData.append('od_anillo', $('input[name="od_anillo"]').val());
                    formData.append('od_tope', $('input[name="od_tope"]').val());
                    formData.append('oi_queratometria', $('input[name="oi_queratometria"]').val());
                    formData.append('oi_microqueratomo', $('input[name="oi_microqueratomo"]').val());
                    formData.append('oi_anillo', $('input[name="oi_anillo"]').val());
                    formData.append('oi_tope', $('input[name="oi_tope"]').val());
                }

                formData.append('csrf_token', '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>');

                // Enviar por AJAX
                fetch('enviar_formulario_completo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Respuesta completa del servidor:', data);
                    
                    if (data.success) {
                        btn.removeClass('btn-success').addClass('btn-primary');
                        btn.html('<i class="fas fa-check"></i> Enviado Correctamente');
                        
                        // Mostrar mensaje de éxito con detalles
                        let mensaje = data.message;
                        if (data.details) {
                            mensaje += '<br><small>' + data.details + '</small>';
                        }
                        
                        alertify.alert('✅ Formulario Enviado', mensaje, function() {
                            // Preguntar sobre próximos pasos
                            alertify.confirm('📊 Opciones', 
                                '¿Qué desea hacer a continuación?<br><br>• <strong>Ver Gráficas:</strong> Consultar los signos vitales registrados<br>• <strong>Nuevo Registro:</strong> Recargar para registrar otro caso',
                                function() {
                                    // Ir a ver gráficas
                                    window.location.href = 'ver_grafica.php';
                                },
                                function() {
                                    // Recargar página
                                    window.location.reload();
                                }
                            ).set('labels', {ok:'📊 Ver Gráficas', cancel:'🔄 Nuevo Registro'});
                        });
                        
                        // Log detallado para debugging
                        if (data.summary) {
                            console.log('📊 Resumen de la operación:', data.summary);
                        }
                        
                    } else {
                        throw new Error(data.message || 'Error desconocido');
                    }
                })
                .catch(error => {
                    console.error('❌ Error completo:', error);
                    
                    let mensajeError = '❌ Error al enviar formulario';
                    if (error.message) {
                        mensajeError += ':<br>' + error.message;
                    }
                    
                    alertify.alert('Error', mensajeError, function() {
                        btn.prop('disabled', false);
                        btn.html('<i class="fas fa-paper-plane"></i> Enviar Formulario Completo');
                    });
                });
            }
        });

        // Manejo del formulario de nota de enfermería
        $('form[action="insertar_nota_enfermeria.php"]').on('submit', function(e) {
            console.log('🚀 Formulario de nota de enfermería enviado');
            e.preventDefault();
            
            const form = $(this);
            const btn = form.find('button[type="submit"]');
            const originalHtml = btn.html();
            
            console.log('📋 Datos del formulario:', {
                nota: $('textarea[name="nota_enfermeria"]').val(),
                enfermera: $('input[name="enfermera_responsable"]').val(),
                id_exp: $('input[name="id_exp"]').val(),
                id_usua: $('input[name="id_usua"]').val(),
                id_atencion: $('input[name="id_atencion"]').val()
            });
            
            // Validar campos requeridos
            let errores = [];
            
            if (!$('textarea[name="nota_enfermeria"]').val().trim()) {
                errores.push('Nota de enfermería es requerida');
            }
            
            console.log('⚠️ Errores encontrados:', errores);
            
            if (errores.length > 0) {
                alertify.alert('Campos Requeridos', '⚠️ ' + errores.join('<br>• '), function() {
                    // Focus en el primer campo con error
                    if (!$('textarea[name="nota_enfermeria"]').val().trim()) {
                        $('textarea[name="nota_enfermeria"]').focus();
                    }
                });
                return;
            }
            
            // Capturar datos de tratamientos del formulario principal antes de enviar
            capturarDatosTratamientos();
            
            // Deshabilitar botón y mostrar loading
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
            
            console.log('🔄 Enviando formulario...');
            
            // Preparar datos del formulario
            const formData = new FormData(this);
            
            // Debug: Mostrar todos los datos que se envían
            console.log('📤 Datos a enviar:');
            for (let [key, value] of formData.entries()) {
                console.log(`  ${key}: ${value}`);
            }
            
            // Enviar datos por AJAX
            $.ajax({
                url: 'insertar_nota_enfermeria.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                timeout: 30000
            })
            .done(function(response) {
                console.log('✅ Respuesta recibida:', response);
                
                if (response.success) {
                    // Mostrar notificación de éxito
                    alertify.success(response.message || '✅ Nota de enfermería guardada exitosamente');
                    
                    // Limpiar formulario excepto campos que deben mantenerse
                    $('textarea[name="nota_enfermeria"]').val('');
                    
                    // Opcional: mostrar detalles adicionales si están disponibles
                    if (response.data) {
                        console.log('📋 Datos guardados:', response.data);
                    }
                    
                } else {
                    console.error('❌ Error del servidor:', response);
                    // Mostrar error
                    alertify.alert('Error', response.message || '❌ Error al guardar nota de enfermería');
                }
            })
            .fail(function(xhr, status, error) {
                console.error('❌ Error AJAX completo:', {
                    xhr: xhr,
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    responseJSON: xhr.responseJSON
                });
                
                let mensajeError = '❌ Error de conexión al guardar la nota de enfermería';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensajeError = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    console.error('Respuesta del servidor:', xhr.responseText);
                    mensajeError = '❌ Error del servidor: ' + xhr.responseText.substring(0, 200);
                } else if (status === 'timeout') {
                    mensajeError = '⏱️ Tiempo de espera agotado. Verifique su conexión.';
                } else if (status === 'error') {
                    mensajeError = '🔌 Error de conexión con el servidor.';
                }
                
                alertify.alert('Error de Conexión', mensajeError);
            })
            .always(function() {
                // Rehabilitar botón
                btn.prop('disabled', false);
                btn.html(originalHtml);
            });
        });

        // Función para capturar datos de tratamientos del formulario principal
        function capturarDatosTratamientos() {
            console.log('📋 Capturando datos de tratamientos...');
            
            // Capturar tratamientos seleccionados
            const tratamientosSeleccionados = $('.tratamiento-checkbox:checked');
            let tratamientosIds = [];
            let nombresTratamientos = [];
            
            tratamientosSeleccionados.each(function() {
                tratamientosIds.push($(this).val());
                nombresTratamientos.push($(this).data('tipo'));
            });
            
            // Capturar datos del formulario de tratamientos (si está visible)
            const medicoTratante = $('select[name="medico_tratante"]').val() || 'Sin asignar';
            const anestesiologo = $('select[name="anestesiologo"]').val() || 'Sin asignar';
            const anestesia = $('select[name="anestesia"]').val() || 'Sin asignar';
            
            // Actualizar campos ocultos en el formulario de nota
            $('#tratamientos_seleccionados_nota').val(nombresTratamientos.join(', '));
            $('#medico_tratante_nota').val(medicoTratante);
            $('#anestesiologo_nota').val(anestesiologo);
            $('#anestesia_nota').val(anestesia);
            
            console.log('✅ Datos capturados:', {
                tratamientos: nombresTratamientos.join(', '),
                medico_tratante: medicoTratante,
                anestesiologo: anestesiologo,
                anestesia: anestesia
            });
        }

        // Event listener adicional para el botón de guardar nota (por si el submit falla)
        $(document).on('click', 'form[action="insertar_nota_enfermeria.php"] button[type="submit"]', function(e) {
            console.log('🖱️ Clic en botón Guardar Nota detectado');
            console.log('📋 Estado del formulario:', {
                form_exists: $('form[action="insertar_nota_enfermeria.php"]').length,
                button_exists: $('form[action="insertar_nota_enfermeria.php"] button[type="submit"]').length,
                nota_value: $('textarea[name="nota_enfermeria"]').val(),
                medico_value: $('select[name="medico_responsable"]').val()
            });
            // El evento submit se encargará del resto
        });

        // Verificar que el formulario esté disponible al cargar la página
        $(document).ready(function() {
            console.log('🚀 Verificando elementos del formulario de nota de enfermería...');
            console.log('📋 Elementos encontrados:', {
                form: $('form[action="insertar_nota_enfermeria.php"]').length,
                submit_button: $('form[action="insertar_nota_enfermeria.php"] button[type="submit"]').length,
                textarea: $('textarea[name="nota_enfermeria"]').length,
                select_medico: $('select[name="medico_responsable"]').length
            });
            
            if ($('form[action="insertar_nota_enfermeria.php"]').length === 0) {
                console.error('❌ PROBLEMA: No se encontró el formulario de nota de enfermería');
            } else {
                console.log('✅ Formulario de nota de enfermería encontrado correctamente');
            }
        });



        // =========================================
        // FUNCIONALIDAD DE DICTADO POR VOZ
        // =========================================
        
        // Variables globales para el reconocimiento de voz
        let recognition = null;
        let isRecording = false;
        let recordedText = '';
        let speechSynthesis = window.speechSynthesis;

        // Verificar soporte para Web Speech API
        const initializeSpeechRecognition = () => {
            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                recognition = new SpeechRecognition();
                
                // Configuración del reconocimiento
                recognition.continuous = true;
                recognition.interimResults = true;
                recognition.lang = 'es-ES'; // Español
                recognition.maxAlternatives = 1;
                
                // Eventos del reconocimiento
                recognition.onstart = function() {
                    console.log('🎤 Dictado iniciado');
                    isRecording = true;
                    updateRecordingUI(true);
                };
                
                recognition.onresult = function(event) {
                    let finalTranscript = '';
                    let interimTranscript = '';
                    
                    for (let i = event.resultIndex; i < event.results.length; i++) {
                        const transcript = event.results[i][0].transcript;
                        if (event.results[i].isFinal) {
                            finalTranscript += transcript + ' ';
                        } else {
                            interimTranscript += transcript;
                        }
                    }
                    
                    // Solo agregar el texto final nuevo al texto base
                    if (finalTranscript) {
                        recordedText += finalTranscript;
                    }
                    
                    // Mostrar texto base + texto final + texto temporal
                    $('.nota-enfermeria').val(recordedText + interimTranscript);
                    
                    // Auto-scroll del textarea
                    const textarea = $('.nota-enfermeria')[0];
                    textarea.scrollTop = textarea.scrollHeight;
                };
                
                recognition.onerror = function(event) {
                    console.error('❌ Error en el reconocimiento de voz:', event.error);
                    let errorMessage = 'Error en el reconocimiento de voz';
                    
                    switch(event.error) {
                        case 'network':
                            errorMessage = 'Error de conexión. Verifique su conexión a internet.';
                            break;
                        case 'not-allowed':
                            errorMessage = 'Micrófono bloqueado. Por favor, permita el acceso al micrófono.';
                            break;
                        case 'no-speech':
                            errorMessage = 'No se detectó voz. Intente hablar más cerca del micrófono.';
                            break;
                        case 'audio-capture':
                            errorMessage = 'No se puede acceder al micrófono.';
                            break;
                        case 'service-not-allowed':
                            errorMessage = 'Servicio de reconocimiento de voz no disponible.';
                            break;
                    }
                    
                    alertify.alert('Error de Dictado', '🎤 ' + errorMessage);
                    stopRecording();
                };
                
                recognition.onend = function() {
                    console.log('🛑 Dictado finalizado');
                    isRecording = false;
                    updateRecordingUI(false);
                    
                    // Asegurar que el texto final se guarde sin duplicaciones
                    $('.nota-enfermeria').val(recordedText);
                };
                
            } else {
                console.warn('⚠️ Web Speech API no soportada en este navegador');
                $('.grabar-nota, .detener-nota').prop('disabled', true).attr('title', 'Dictado no soportado en este navegador');
            }
        };

        // Actualizar interfaz durante grabación
        const updateRecordingUI = (recording) => {
            if (recording) {
                $('.grabar-nota')
                    .removeClass('btn-danger')
                    .addClass('btn-warning')
                    .html('<i class="fas fa-microphone-slash"></i>')
                    .attr('title', 'Detener grabación');
                
                $('.detener-nota').prop('disabled', false);
                
                // Agregar indicador visual de grabación
                if (!$('.recording-indicator').length) {
                    $('.btn-group').append('<span class="recording-indicator ml-2 text-danger"><i class="fas fa-circle" style="animation: pulse 1s infinite;"></i> Grabando...</span>');
                }
            } else {
                $('.grabar-nota')
                    .removeClass('btn-warning')
                    .addClass('btn-danger')
                    .html('<i class="fas fa-microphone"></i>')
                    .attr('title', 'Iniciar dictado');
                
                $('.detener-nota').prop('disabled', true);
                $('.recording-indicator').remove();
            }
        };

        // Función para iniciar grabación
        const startRecording = () => {
            if (!recognition) {
                alertify.alert('No Soportado', '🎤 El dictado por voz no está disponible en este navegador.<br><br>💡 <strong>Navegadores compatibles:</strong><br>• Google Chrome<br>• Microsoft Edge<br>• Safari (macOS/iOS)');
                return;
            }
            
            if (isRecording) {
                stopRecording();
                return;
            }
            
            try {
                // Guardar el texto actual como base (sin duplicar)
                recordedText = $('.nota-enfermeria').val();
                recognition.start();
                
                alertify.success('🎤 Dictado iniciado. Hable claramente hacia el micrófono.');
                
            } catch (error) {
                console.error('Error al iniciar grabación:', error);
                alertify.alert('Error', '🎤 No se pudo iniciar el dictado. Verifique los permisos del micrófono.');
            }
        };

        // Función para detener grabación
        const stopRecording = () => {
            if (recognition && isRecording) {
                recognition.stop();
                alertify.success('🛑 Dictado finalizado.');
            }
        };

        // Función para reproducir texto
        const playText = () => {
            const text = $('.nota-enfermeria').val().trim();
            
            if (!text) {
                alertify.alert('Sin Texto', '📝 No hay texto para reproducir en la nota de enfermería.');
                return;
            }
            
            if (!speechSynthesis) {
                alertify.alert('No Soportado', '🔊 La síntesis de voz no está disponible en este navegador.');
                return;
            }
            
            // Detener cualquier reproducción anterior
            speechSynthesis.cancel();
            
            // Crear nueva utterance
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'es-ES';
            utterance.rate = 0.9;
            utterance.pitch = 1;
            utterance.volume = 0.8;
            
            // Eventos de la síntesis
            utterance.onstart = function() {
                $('.reproducir-nota')
                    .removeClass('btn-success')
                    .addClass('btn-warning')
                    .html('<i class="fas fa-stop"></i>')
                    .attr('title', 'Detener reproducción');
                
                alertify.success('🔊 Reproduciendo nota de enfermería...');
            };
            
            utterance.onend = function() {
                $('.reproducir-nota')
                    .removeClass('btn-warning')
                    .addClass('btn-success')
                    .html('<i class="fas fa-play"></i>')
                    .attr('title', 'Reproducir texto');
                
                alertify.success('✅ Reproducción finalizada.');
            };
            
            utterance.onerror = function(event) {
                console.error('Error en síntesis de voz:', event.error);
                alertify.alert('Error de Reproducción', '🔊 Error al reproducir el texto: ' + event.error);
                
                $('.reproducir-nota')
                    .removeClass('btn-warning')
                    .addClass('btn-success')
                    .html('<i class="fas fa-play"></i>')
                    .attr('title', 'Reproducir texto');
            };
            
            // Iniciar síntesis
            speechSynthesis.speak(utterance);
        };

        // Event listeners para los botones de voz
        $('.grabar-nota').on('click', function(e) {
            e.preventDefault();
            startRecording();
        });

        $('.detener-nota').on('click', function(e) {
            e.preventDefault();
            stopRecording();
        });

        $('.reproducir-nota').on('click', function(e) {
            e.preventDefault();
            
            // Si ya está reproduciendo, detener
            if (speechSynthesis.speaking) {
                speechSynthesis.cancel();
                $(this)
                    .removeClass('btn-warning')
                    .addClass('btn-success')
                    .html('<i class="fas fa-play"></i>')
                    .attr('title', 'Reproducir texto');
                
                alertify.success('🛑 Reproducción detenida.');
            } else {
                playText();
            }
        });

        // Inicializar reconocimiento de voz al cargar la página
        initializeSpeechRecognition();

        // Atajos de teclado para funcionalidad de voz
        $(document).on('keydown', function(e) {
            // Ctrl+Shift+R para iniciar/detener grabación
            if (e.ctrlKey && e.shiftKey && e.key === 'R') {
                e.preventDefault();
                if (isRecording) {
                    stopRecording();
                } else {
                    startRecording();
                }
            }
            
            // Ctrl+Shift+S para detener grabación
            if (e.ctrlKey && e.shiftKey && e.key === 'S') {
                e.preventDefault();
                stopRecording();
            }
            
            // Ctrl+Shift+P para reproducir/detener reproducción
            if (e.ctrlKey && e.shiftKey && e.key === 'P') {
                e.preventDefault();
                if (speechSynthesis.speaking) {
                    speechSynthesis.cancel();
                    $('.reproducir-nota')
                        .removeClass('btn-warning')
                        .addClass('btn-success')
                        .html('<i class="fas fa-play"></i>')
                        .attr('title', 'Reproducir texto escrito (Ctrl+Shift+P)');
                    alertify.success('🛑 Reproducción detenida.');
                } else {
                    playText();
                }
            }
        });

        // Mejorar la experiencia visual durante el dictado
        const enhanceRecordingExperience = (isRecording) => {
            const textarea = $('.nota-enfermeria');
            if (isRecording) {
                textarea.addClass('dictating');
                textarea.attr('placeholder', '🎤 Dictando... Hable claramente hacia el micrófono');
            } else {
                textarea.removeClass('dictating');
                textarea.attr('placeholder', 'Escriba aquí la nota de enfermería o use el dictado por voz...');
            }
        };

        // Actualizar la función updateRecordingUI para incluir mejoras visuales
        const originalUpdateRecordingUI = updateRecordingUI;
        updateRecordingUI = function(recording) {
            originalUpdateRecordingUI(recording);
            enhanceRecordingExperience(recording);
        };

        // Agregar estilos CSS para la animación de pulso
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { opacity: 1; }
                50% { opacity: 0.5; }
                100% { opacity: 1; }
            }
            .recording-indicator {
                font-size: 14px;
                font-weight: bold;
                color: #dc3545 !important;
            }
            .btn-group .btn {
                transition: all 0.3s ease;
            }
            .btn-group .btn:hover {
                transform: scale(1.05);
            }
        `;
        document.head.appendChild(style);

        console.log('🎤 Sistema de dictado por voz iniciado');
        console.log('💡 Funciones disponibles:');
        console.log('   • Botón rojo: Iniciar/Detener dictado');
        console.log('   • Botón azul: Detener dictado manualmente');
        console.log('   • Botón verde: Reproducir texto escrito');
    </script>
</body>

</html>
<?php
$conexion->close();
?>