<?php
session_start();
include "../../conexionbd.php";
include("../header_enfermera.php");

$usuario_actual = '';
$rol_usuario = '';
$id_usuario = '';
if (isset($_SESSION['login'])) {
    $usuario = $_SESSION['login'];
    $id_usuario = $usuario['id_usua'];
    $usuario_actual = trim($usuario['nombre'] . ' ' . $usuario['papell'] . ' ' . $usuario['sapell']);
    $rol_usuario = $usuario['id_rol'];
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
 


    <title>HOJA DE PROGRAMACIÓN QUIRÚRGICA </title>
    <style type="text/css>
        .modal-lg {
            max-width: 65% !important;
        .modal-lg {}
        .container-fluid {}
        .card {}
        .card-header {}
        .card-body {}
        .table-responsive {}
        .table-bordered {}
        .table-bordered th,
        .table-bordered td {}
        .table-bordered th {}
        .table-bordered td {}
        .table-bordered input.form-control {}
        .table-bordered input.form-control:focus {}
        .btn-agregar-row td {}
        .btn-agregar-row .btn {}
        .btn-agregar-row .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }
        .btn-agregar-row .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
        input[readonly] {
            background-color: #e9ecef !important;
            cursor: not-allowed;
        }
        small.text-muted {
            font-style: italic;
            color: #6c757d !important;
        }
        input[type="time"] {
            min-width: 100px;
        }
        .durante-cirugia-row.guardado {
            background-color: #d4edda !important;
        }
        .durante-cirugia-row.guardado td {
            background-color: #d4edda !important;
            border-color: #c3e6cb !important;
        }
        .durante-cirugia-row.guardado input[readonly] {
            background-color: #c3e6cb !important;
            color: #155724 !important;
            font-weight: 500;
        }
        .btn-guardado {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: white !important;
            cursor: not-allowed !important;
        }
        .btn-guardado:hover {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
        @keyframes guardarExito {
            0% { background-color: #ffffff; }
            50% { background-color: #d1ecf1; }
            100% { background-color: #d4edda; }
        }
        .durante-cirugia-row.guardando {
            animation: guardarExito 1s ease-in-out;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .form-control {
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .botones {
            display: flex;
            gap: 5px;
            margin-bottom: 10px;
        }
        .botones .btn {
            padding: 5px 10px;
            font-size: 12px;
        }
        #selector_tratamiento {
            font-size: 18px;
            font-weight: bold;
            padding: 12px 15px;
            border: 2px solid #2b2d7f;
            border-radius: 8px;
            background-color: #ffffff;
            color: #2b2d7f;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            min-height: 50px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%232b2d7f" viewBox="0 0 16 16"><path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 40px;
        }
        #selector_tratamiento:focus {
            border-color: #1a1d5f;
            box-shadow: 0 0 0 0.2rem rgba(43, 45, 127, 0.25);
            outline: none;
        }
        #selector_tratamiento option {
            font-size: 16px;
            font-weight: normal;
            padding: 8px;
            color: #333;
            background-color: #ffffff;
        }
        #selector_tratamiento option:hover {
            background-color: #f8f9fa;
        }
        .formulario-tratamiento {
            margin-top: 20px;
            animation: fadeIn 0.3s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .formulario-tratamiento .card-header {
            background-color: #2b2d7f;
            color: white;
            font-weight: bold;
            border-bottom: 2px solid #1a1d5f;
        }
        .formulario-tratamiento .card-body {
            padding: 20px;
        }
        .card-header {
            padding: 15px 20px;
        }
        .card-header label {
            margin-bottom: 10px;
            display: block;
        }
        .table-signos-vitales {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .table-signos-vitales th {
            background-color: #2b2d7f;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 10px 8px;
            font-size: 13px;
        }
        .table-signos-vitales td {
            padding: 8px 6px;
            vertical-align: middle;
        }
        .table-signos-vitales td strong {
            color: #2b2d7f;
        }
        .table-signos-vitales tbody tr:hover {
            background-color: #f8f9fa;
        }
        .table-signos-vitales input[type="text"],
        .table-signos-vitales input[type="time"] {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            transition: border-color 0.15s ease-in-out;
        }
        .table-signos-vitales input[type="text"]:focus,
        .table-signos-vitales input[type="time"]:focus {
            border-color: #2b2d7f;
            box-shadow: 0 0 0 0.1rem rgba(43, 45, 127, 0.25);
        }
        @media (max-width: 768px) {
            .table-bordered {}
            .table-bordered th,
            .table-bordered td {}
            .table-bordered input.form-control {}
        }
        }

        .table-signos-vitales th {
            background-color: #2b2d7f;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 10px 8px;
            font-size: 13px;
        }

        .table-signos-vitales td {
            padding: 8px 6px;
            vertical-align: middle;
        }

        .table-signos-vitales td strong {
            color: #2b2d7f;
        }

        /* Efecto hover para las filas */
        .table-signos-vitales tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Estilos para inputs dentro de la tabla */
        .table-signos-vitales input[type="text"],
        .table-signos-vitales input[type="time"] {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            transition: border-color 0.15s ease-in-out;
        }

        .table-signos-vitales input[type="text"]:focus,
        .table-signos-vitales input[type="time"]:focus {
            border-color: #2b2d7f;
            box-shadow: 0 0 0 0.1rem rgba(43, 45, 127, 0.25);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .table-bordered {
                font-size: 10px;
            }
            
            .table-bordered th,
            .table-bordered td {
                padding: 4px 2px;
            }
            
            .table-bordered input.form-control {
                min-width: 60px;
                font-size: 10px;
            }
        }
    </style>
</head>

<body>
    

    <?php
    if (isset($_GET['tratamiento_exito']) && !empty($_GET['tratamiento_exito'])) {
        $tratamiento_exito = htmlspecialchars($_GET['tratamiento_exito']);
        echo '<div class="alert alert-success mt-3" role="alert" style="font-size:18px; text-align:center;">';
        echo 'Formulario de <strong>' . strtoupper($tratamiento_exito) . '</strong> enviado correctamente.';
        echo '</div>';
    }
    
    if (isset($_GET['exito_multiples']) && !empty($_GET['exito_multiples'])) {
        $mensaje_exito = htmlspecialchars($_GET['exito_multiples']);
        echo '<div class="alert alert-success mt-3" role="alert" style="font-size:18px; text-align:center;">';
        echo '<i class="fas fa-check-circle"></i> ' . $mensaje_exito;
        echo '<br><a href="ver_grafica.php" class="btn btn-primary btn-sm mt-2">';
        echo '<i class="fas fa-chart-line"></i> Ver Gráficas de Signos Vitales</a>';
        echo '</div>';
    }
    
    if (isset($_GET['error']) && !empty($_GET['error'])) {
        $error = htmlspecialchars($_GET['error']);
        echo '<div class="alert alert-danger mt-3" role="alert" style="font-size:18px; text-align:center;">';
        echo '<i class="fas fa-exclamation-triangle"></i> Error: ' . $error;
        echo '</div>';
    }
    ?>
    <div class="container">
        <div class="mt-3">
            <?php if (isset($_SESSION['message']) && isset($_SESSION['message_type'])): ?>
            <div class="alert alert-<?php echo htmlspecialchars($_SESSION['message_type']); ?> alert-dismissible fade show"
                role="alert">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        // Limpiar el mensaje
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        ?>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col">
                <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;"><strong>
                        <center>DATOS DEL PACIENTE</center>
                    </strong></div>
                    <?php
                    include "../../conexionbd.php";
                    if (isset($_SESSION['pac'])) {
                        $id_atencion = $_SESSION['pac'];
                        $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.folio, p.tel, p.fecnac, p.tip_san, di.fecha, di.area, di.alta_med, di.activo, p.sexo, di.alergias, p.ocup FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp AND di.id_atencion = ?";
                        $stmt = $conexion->prepare($sql_pac);
                        $stmt->bind_param("i", $id_atencion);
                        $stmt->execute();
                        $result_pac = $stmt->get_result();
                        while ($row_pac = $result_pac->fetch_assoc()) {
                            $pac_papell = $row_pac['papell'];
                            $pac_sapell = $row_pac['sapell'];
                            $pac_nom_pac = $row_pac['nom_pac'];
                            $pac_dir = $row_pac['dir'];
                            $pac_id_edo = $row_pac['id_edo'];
                            $pac_id_mun = $row_pac['id_mun'];
                            $pac_tel = $row_pac['tel'];
                            $pac_fecnac = $row_pac['fecnac'];
                            $pac_fecing = $row_pac['fecha'];
                            $pac_tip_sang = $row_pac['tip_san'];
                            $pac_sexo = $row_pac['sexo'];
                            $area = $row_pac['area'];
                            $alta_med = $row_pac['alta_med'];
                            $id_exp = $row_pac['Id_exp'];
                            $folio = $row_pac['folio'];
                            $alergias = $row_pac['alergias'];
                            $ocup = $row_pac['ocup'];
                            $activo = $row_pac['activo'];
                        }
                        $stmt->close();
                        $stmt = $conexion->prepare("SELECT area FROM dat_ingreso WHERE id_atencion = ?");
                        $stmt->bind_param("i", $id_atencion);
                        $stmt->execute();
                        $resultado1 = $stmt->get_result();

                        $area = "No asignada"; // Default value
                        if ($f1 = $resultado1->fetch_assoc()) {
                            $area = $f1['area'];
                        }
                        $stmt->close();

                        if ($activo === 'SI') {
                            $sql_now = "SELECT DATE_ADD(NOW(), INTERVAL 12 HOUR) as dat_now FROM dat_ingreso WHERE id_atencion = ?";
                            $stmt = $conexion->prepare($sql_now);
                            $stmt->bind_param("i", $id_atencion);
                            $stmt->execute();
                            $result_now = $stmt->get_result();
                            while ($row_now = $result_now->fetch_assoc()) {
                                $dat_now = $row_now['dat_now'];
                            }
                            $stmt->close();
                            $sql_est = "SELECT DATEDIFF( ?, fecha) as estancia FROM dat_ingreso WHERE id_atencion = ?";
                            $stmt = $conexion->prepare($sql_est);
                            $stmt->bind_param("si", $dat_now, $id_atencion);
                            $stmt->execute();
                            $result_est = $stmt->get_result();
                            while ($row_est = $result_est->fetch_assoc()) {
                                $estancia = $row_est['estancia'];
                            }
                            $stmt->close();
                        } else {
                            $sql_est = "SELECT DATEDIFF(fec_egreso, fecha) as estancia FROM dat_ingreso WHERE id_atencion = ?";
                            $stmt = $conexion->prepare($sql_est);
                            $stmt->bind_param("i", $id_atencion);
                            $stmt->execute();
                            $result_est = $stmt->get_result();
                            while ($row_est = $result_est->fetch_assoc()) {
                                $estancia = ($row_est['estancia'] == 0) ? 1 : $row_est['estancia'];
                            }
                            $stmt->close();
                        }

                        $d = "";
                        $sql_motd = "SELECT diagprob_i FROM dat_not_ingreso WHERE id_atencion = ? ORDER BY id_not_ingreso DESC LIMIT 1";
                        $stmt = $conexion->prepare($sql_motd);
                        $stmt->bind_param("i", $id_atencion);
                        $stmt->execute();
                        $result_motd = $stmt->get_result();
                        while ($row_motd = $result_motd->fetch_assoc()) {
                            $d = $row_motd['diagprob_i'];
                        }
                        $stmt->close();

                        if (!$d) {
                            $sql_motd = "SELECT diagprob_i FROM dat_nevol WHERE id_atencion = ? ORDER BY id_ne DESC LIMIT 1";
                            $stmt = $conexion->prepare($sql_motd);
                            $stmt->bind_param("i", $id_atencion);
                            $stmt->execute();
                            $result_motd = $stmt->get_result();
                            while ($row_motd = $result_motd->fetch_assoc()) {
                                $d = $row_motd['diagprob_i'];
                            }
                            $stmt->close();
                        }

                        $sql_mot = "SELECT motivo_atn FROM dat_ingreso WHERE id_atencion = ? ORDER BY motivo_atn ASC LIMIT 1";
                        $stmt = $conexion->prepare($sql_mot);
                        $stmt->bind_param("i", $id_atencion);
                        $stmt->execute();
                        $result_mot = $stmt->get_result();
                        while ($row_mot = $result_mot->fetch_assoc()) {
                            $m = $row_mot['motivo_atn'];
                        }
                        $stmt->close();

                        $sql_edo = "SELECT edo_salud FROM dat_ingreso WHERE id_atencion = ? ORDER BY edo_salud ASC LIMIT 1";
                        $stmt = $conexion->prepare($sql_edo);
                        $stmt->bind_param("i", $id_atencion);
                        $stmt->execute();
                        $result_edo = $stmt->get_result();
                        while ($row_edo = $result_edo->fetch_assoc()) {
                            $edo_salud = $row_edo['edo_salud'];
                        }
                        $stmt->close();

                        $sql_hab = "SELECT num_cama FROM cat_camas WHERE id_atencion = ?";
                        $stmt = $conexion->prepare($sql_hab);
                        $stmt->bind_param("i", $id_atencion);
                        $stmt->execute();
                        $result_hab = $stmt->get_result();
                        $num_cama = $result_hab->fetch_assoc()['num_cama'] ?? '';
                        $stmt->close();

                        $sql_hclinica = "SELECT peso, talla FROM dat_hclinica WHERE Id_exp = ? ORDER BY id_hc DESC LIMIT 1";
                        $stmt = $conexion->prepare($sql_hclinica);
                        $stmt->bind_param("s", $id_exp);
                        $stmt->execute();
                        $result_hclinica = $stmt->get_result();
                        $peso = 0;
                        $talla = 0;
                        while ($row_hclinica = $result_hclinica->fetch_assoc()) {
                            $peso = $row_hclinica['peso'] ?? 0;
                            $talla = $row_hclinica['talla'] ?? 0;
                        }
                        $stmt->close();
                    } else {
                        echo '<script type="text/javascript">window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
                    }
                    ?>
                <div class="row">
                    <div class="col-sm-4">Expediente: <strong><?php echo $folio; ?></strong></div>
                    <div class="col-sm-4">Paciente:
                        <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac; ?></strong>
                    </div>
                    <div class="col-sm-4">Fecha de atención:
                        <strong><?php echo date_format(date_create($pac_fecing), "d/m/Y H:i:s"); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Fecha de nacimiento:
                        <strong><?php echo date_format(date_create($pac_fecnac), "d/m/Y"); ?></strong>
                    </div>
                    <div class="col-sm-4">Edad: <strong><?php
                        $fecha_actual = date("Y-m-d");
                        $fecha_nac = $pac_fecnac;
                        $array_nacimiento = explode("-", $fecha_nac);
                        $array_actual = explode("-", $fecha_actual);
                        $anos = $array_actual[0] - $array_nacimiento[0];
                        $meses = $array_actual[1] - $array_nacimiento[1];
                        $dias = $array_actual[2] - $array_nacimiento[2];
                        if ($dias < 0) { --$meses; $dias += ($array_actual[1] == 3 && date("L", strtotime($fecha_actual)) ? 29 : 28); }
                        if ($meses < 0) { --$anos; $meses += 12; }
                        echo ($anos > 0 ? $anos . " años" : ($meses > 0 ? $meses . " meses" : $dias . " días"));
                    ?></strong></div>
                    <div class="col-sm-4">Área: <strong><?php echo $num_cama .' - '.$area;?> </strong></div> 
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <?php echo $d ? "Diagnóstico: <strong>$d</strong>" : "Motivo de atención: <strong>$m</strong>"; 
                        ?>
                    </div>

                    <div class="col-sm-4">Alergias: <strong><?php echo $alergias; ?></strong></div>
                   
                    
                </div>

            </div>
        </div>
    </div>
     <!-- Separación visual entre datos del paciente y menú -->
            <div style="height: 32px;"></div>
            <div class="container">
                <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
                    <strong>
                        <center>HOJA DE PROGRAMACIÓN QUIRÚRGICA</center>
                    </strong>
                </div>

            <!-- Apartado de selección de tratamientos arriba del menú principal -->
            
                <div class="container mb-4">
                    <div class="card" style="border-radius: 15px; box-shadow: 0 4px 16px rgba(43,45,127,0.08); border: none;">
                        <div class="card-body p-0">
                            <ul class="nav nav-tabs nav-fill" id="menuRegistroTabs" style="background: linear-gradient(90deg, #2b2d7f 0%, #4a4ed1 100%); border-radius: 15px 15px 0 0;">
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold active" id="cirugia-tab" data-toggle="tab" href="#cirugia" role="tab" aria-controls="cirugia" aria-selected="true" style="color: #fff; background: #2b2d7f;">Cirugía Segura</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="signos-tab" data-toggle="tab" href="#signos" role="tab" aria-controls="signos" aria-selected="false" style="color: #fff;">Signos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="nota-tab" data-toggle="tab" href="#nota" role="tab" aria-controls="nota" aria-selected="false" style="color: #fff;">Nota Enfermería</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="ingresos-tab" data-toggle="tab" href="#ingresos" role="tab" aria-controls="ingresos" aria-selected="false" style="color: #fff;">Ingresos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="insumos-tab" data-toggle="tab" href="#insumos" role="tab" aria-controls="insumos" aria-selected="false" style="color: #fff;">Insumos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="equipos-tab" data-toggle="tab" href="#equipos" role="tab" aria-controls="equipos" aria-selected="false" style="color: #fff;">Equipos</a>
                                </li>
                            </ul>
                            <div class="tab-content p-4" id="menuRegistroTabsContent" style="background: #f8f9fa; border-radius: 0 0 15px 15px;">
                                <div class="tab-pane fade show active" id="cirugia" role="tabpanel" aria-labelledby="cirugia-tab">
                                    <!-- INICIO: Código completo de enf_cirugia_segura.php -->
                                    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
                                        <strong><center>HOJA DE CIRUGIA SEGURA</center></strong>
                                    </div>
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
                                    <!-- FIN: Código completo de enf_cirugia_segura.php -->
                                </div>
                                <div class="tab-pane fade" id="signos" role="tabpanel" aria-labelledby="signos-tab">
            <!-- Apartado de selección de tratamientos arriba del menú principal -->
            <div class="d-flex justify-content-center mt-3">
                <div class="card" style="max-width: 900px; width: 100%; border-radius: 15px; box-shadow: 0 4px 16px rgba(43,45,127,0.08); border: none;">
                    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #2b2d7f;">
                        <div class="form-group mb-0">
                            <label style="font-size:20px; font-weight:bold; color:#2b2d7f; margin-bottom:15px;">
                                <i class="fa-solid fa-stethoscope"></i> Seleccione los tratamientos a realizar:
                            </label>
                            <div class="row">
                                <?php
                                $sql_trat = "SELECT * FROM tratamientos ORDER BY tipo";
                                $result_trat = $conexion->query($sql_trat);
                                $contador = 0;
                                $tratamientos_data = [];
                                while ($row_trat = $result_trat->fetch_assoc()) {
            $tipo = $row_trat['tipo'];
            $id = $row_trat['id'];
            $tratamientos_data[] = $row_trat; 
            $contador++;
            if ($contador % 2 == 1) {
                echo '<div class="col-md-6 mb-3">';
            }
            echo '<div class="form-check" style="margin-bottom: 8px;">';
            // Agregar clase especial para Cirugía Lasik
            $es_lasik = (strtoupper($tipo) == 'CIRUGÍA LASIK' || strtoupper($tipo) == 'CIRUGIA LASIK');
            $clase_adicional = $es_lasik ? ' lasik-checkbox' : ' general-checkbox';
            echo '<input class="form-check-input tratamiento-checkbox' . $clase_adicional . '" type="checkbox" value="' . $id . '" id="trat_' . $id . '" data-tipo="' . htmlspecialchars($tipo) . '" style="transform: scale(1.3); margin-right: 10px;">';
            echo '<label class="form-check-label" for="trat_' . $id . '" style="font-size: 16px; font-weight: 500; color: #2b2d7f; cursor: pointer;">';
            echo strtoupper($tipo);
            echo '</label>';
            echo '</div>';
            if ($contador % 2 == 0) {
                echo '</div>';
            }
        }
        // Verificar si CIRUGÍA LASIK está en la lista, si no, agregarla manualmente
        $lasik_existe = false;
        foreach ($tratamientos_data as $trat) {
            if (strtoupper($trat['tipo']) == 'CIRUGÍA LASIK' || strtoupper($trat['tipo']) == 'CIRUGIA LASIK') {
                $lasik_existe = true;
                break;
            }
        }
        if (!$lasik_existe) {
            // Si el contador es impar, abrir columna
            if ($contador % 2 == 1) {
                // Ya hay una columna abierta
            } else {
                echo '<div class="col-md-6 mb-3">';
            }
            echo '<div class="form-check" style="margin-bottom: 8px;">';
            echo '<input class="form-check-input tratamiento-checkbox lasik-checkbox" type="checkbox" value="LASIK_MANUAL" id="trat_lasik_manual" data-tipo="CIRUGÍA LASIK" style="transform: scale(1.3); margin-right: 10px;">';
            echo '<label class="form-check-label" for="trat_lasik_manual" style="font-size: 16px; font-weight: 500; color: #2b2d7f; cursor: pointer;">CIRUGÍA LASIK</label>';
            echo '</div>';
            echo '</div>';
            // Forzar despliegue inmediato si se selecciona
            echo '<script>\n$(function(){\n  $("#trat_lasik_manual").on("change", function(){\n    if(this.checked){\n      $("#btn_cargar_tratamientos").show();\n    } else {\n      if($(".tratamiento-checkbox:checked").length == 0){\n        $("#btn_cargar_tratamientos").hide();\n      }\n    }\n  });\n});\n</script>';
        }
        if ($contador % 2 == 1) {
            echo '</div>';
        }
                                ?>
                            </div>
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-primary btn-lg" id="btn_cargar_tratamientos" style="display:none;">
                                    <i class="fa-solid fa-clipboard-check"></i> Cargar Formularios Seleccionados
                                </button>
                            </div>
                        </div>
                        <!-- Contenedor para formularios -->
                        <div id="formulario_contenedor" style="display: none;">
                            <!-- Formulario General Unificado -->
                            <div class="card formulario-tratamiento" id="formulario_general" style="display: none;">
                                <div class="card-header" style="background-color: #2b2d7f; color: white;">
                                    <h4 class="mb-0 text-center">FORMULARIO DE TRATAMIENTOS SELECCIONADOS</h4>
                                    <div class="text-center mt-2" id="tratamientos_seleccionados_lista">
                                        <!-- Aquí se mostrarán los tratamientos seleccionados -->
                                    </div>
                                </div>
                                <div class="card-body">
            <form action="insertar_tratamientos_multiples.php" method="POST" onsubmit="return enviarFormularioUnificado(event);">
                <div class="form-group">
                    <label style="font-size:16px;">Nombre del médico tratante:</label>
                    <select class="form-control" name="medico_tratante" required>
                        <option value="">Seleccione un médico tratante</option>
                        <?php
                        $sql_med = "SELECT id_usua, nombre, papell, sapell FROM reg_usuarios WHERE id_rol ='2' AND u_activo = 'SI'";
                        $result_med = $conexion->query($sql_med);
                        if ($result_med && $result_med->num_rows > 0) {
                            while ($med = $result_med->fetch_assoc()) {
                                $nombre_med = trim($med['nombre'] . ' ' . $med['papell'] . ' ' . $med['sapell']);
                                echo '<option value="' . htmlspecialchars($nombre_med) . '">' . htmlspecialchars($nombre_med) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label style="font-size:16px;">Anestesiólogo:</label>
                    <select class="form-control" name="anestesiologo" required>
                        <option value="">Seleccione un anestesiólogo</option>
                        <?php
                        $sql_anes = "SELECT id_usua, nombre, papell, sapell FROM reg_usuarios WHERE cargp LIKE '%ANESTESIOLOGO%' AND u_activo = 'SI'";
                        $result_anes = $conexion->query($sql_anes);
                        if ($result_anes && $result_anes->num_rows > 0) {
                            while ($anes = $result_anes->fetch_assoc()) {
                                $nombre_anes = trim($anes['nombre'] . ' ' . $anes['papell'] . ' ' . $anes['sapell']);
                                echo '<option value="' . htmlspecialchars($nombre_anes) . '">' . htmlspecialchars($nombre_anes) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label style="font-size:16px;">Anestesia:</label>
                    <select class="form-control" name="anestesia" required>
                        <option value="">Seleccione tipo de anestesia</option>
                        <option value="LOCAL">LOCAL</option>
                        <option value="SEDACIÓN">SEDACIÓN</option>
                    </select>
                </div>
                <!-- Campos LASIK, ocultos por defecto -->
                <div class="row" id="campos_lasik" style="display:none; margin-top:20px;">
                    <div class="col-md-6">
                        <label style="font-size:16px;">OD</label>
                        <input type="text" class="form-control mb-1" name="od_queratometria" placeholder="QUERATOMETRIA">
                        <input type="text" class="form-control mb-1" name="od_microqueratomo" placeholder="MICROQUERATOMO">
                        <input type="text" class="form-control mb-1" name="od_anillo" placeholder="ANILLO">
                        <input type="text" class="form-control mb-1" name="od_tope" placeholder="TOPE">
                    </div>
                    <div class="col-md-6">
                        <label style="font-size:16px;">OI</label>
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
            </div>

            <div class="card mt-2">
                <div class="card-header" style="background-color: #2b2d7f; color: white;">
                    <h4 class="mb-0 text-center"><i class="fa-solid fa-heart-pulse"></i> Registro de Signos Vitales</h4>
                </div>
                <div class="card-body">
                    <form action="insertar_signos_vitales.php" method="POST">
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
                                        <td><input type="text" class="form-control" name="sistg" placeholder="ej: 120"></td>
                                        <td><input type="text" class="form-control" name="diastg" placeholder="ej: 80"></td>
                                        <td><input type="text" class="form-control" name="fcardg" placeholder="ej: 75"></td>
                                        <td><input type="text" class="form-control" name="frespg" placeholder="ej: 20"></td>
                                        <td><input type="text" class="form-control" name="satg" placeholder="ej: 98%"></td>
                                        <td><input type="text" class="form-control" name="tempg" placeholder="ej: 36.5"></td>
                                        <td><input type="time" class="form-control" name="hora_signos"></td>
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
                                <div class="tab-pane fade" id="nota" role="tabpanel" aria-labelledby="nota-tab">
                                    <div class="card mt-2">
                                        <div class="card-header" style="background-color: #2b2d7f; color: white;">
                                            <h4 class="mb-0 text-center"><i class="fas fa-notes-medical"></i> Nota de Enfermería</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="insertar_nota_enfermeria.php" method="POST">
                                                <div class="form-group mt-3">
                                                    <label style="font-size:16px;">Nota de enfermería:</label>
                                                    <div class="botones mb-2">
                                                        <button type="button" class="btn btn-danger btn-sm grabar-nota"><i class="fas fa-microphone"></i></button>
                                                        <button type="button" class="btn btn-primary btn-sm detener-nota"><i class="fas fa-microphone-slash"></i></button>
                                                        <button type="button" class="btn btn-success btn-sm reproducir-nota"><i class="fas fa-play"></i></button>
                                                    </div>
                                                    <textarea class="form-control nota-enfermeria" rows="5" name="nota_enfermeria"><?php echo (isset($nota) && $nota !== null ? htmlspecialchars($nota) : ''); ?></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label style="font-size:16px;">ENFERMERA RESPONSABLE:</label>
                                                        <input type="text" class="form-control" name="enfermera_responsable" value="<?php echo htmlspecialchars($usuario_actual); ?>" readonly style="background-color: #e9ecef;">
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
                                                <center class="mt-3">
                                                    <button type="submit" class="btn btn-primary btn-lg">
                                                        <i class="fas fa-save"></i> Guardar Nota
                                                    </button>
                                                </center>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="ingresos" role="tabpanel" aria-labelledby="ingresos-tab">
                                    <h5 class="text-primary font-weight-bold"><i class="fas fa-sign-in-alt"></i> Ingresos</h5>
                                    <p class="text-muted">Registro de ingresos y egresos del paciente.</p>
                                </div>
                                <div class="tab-pane fade" id="insumos" role="tabpanel" aria-labelledby="insumos-tab">
                                    <h5 class="text-primary font-weight-bold"><i class="fas fa-box-open"></i> Insumos</h5>
                                    <p class="text-muted">Control y registro de insumos utilizados.</p>
                                </div>
                                <div class="tab-pane fade" id="equipos" role="tabpanel" aria-labelledby="equipos-tab">
                                    <h5 class="text-primary font-weight-bold"><i class="fas fa-tools"></i> Equipos</h5>
                                    <p class="text-muted">Registro y control de equipos médicos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
                
                <div class="card mt-3">
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>


    <script>
        // Botón para mostrar/ocultar el select de médico responsable en Nota de Enfermería
        document.addEventListener('DOMContentLoaded', function() {
            var btnToggleMedico = document.getElementById('btn_toggle_medico_responsable');
            var selectWrap = document.getElementById('select_medico_responsable_wrap');
            if(btnToggleMedico && selectWrap) {
                btnToggleMedico.addEventListener('click', function() {
                    if(selectWrap.style.display === 'none' || selectWrap.style.display === '') {
                        selectWrap.style.display = 'block';
                    } else {
                        selectWrap.style.display = 'none';
                    }
                });
            }
        });
        let enviandoFormulario = false;
        
        // Estilos CSS para las filas de signos vitales
        const styles = `
            <style>
                .guardado {
                    background-color: #f8f9fa !important;
                }
                .guardando {
                    animation: pulse 1s infinite;
                }
                @keyframes pulse {
                    0% { background-color: #d4edda; }
                    50% { background-color: #c3e6cb; }
                    100% { background-color: #d4edda; }
                }
                .btn-guardado {
                    cursor: default;
                }
                .editar-signos {
                    margin-left: 5px;
                }
            </style>
        `;
        document.head.insertAdjacentHTML('beforeend', styles);
        
        function enviarFormularioUnificado(event) {
            event.preventDefault(); // Prevenir el envío normal del formulario
            
            if (!checkSubmit()) {
                return false;
            }
            
            const formulario = event.target;
            const tratamientosSeleccionados = JSON.parse(document.getElementById('tratamientos_seleccionados_input').value || '[]');
            
            if (tratamientosSeleccionados.length === 0) {
                alert('No hay tratamientos seleccionados');
                return false;
            }
            
            // Recopilar los datos del formulario unificado
            const datosFormulario = recopilarDatosFormulario(formulario);
            
            // Crear objeto de datos por tratamiento (todos los tratamientos usan los mismos datos)
            const datosFormularios = {};
            tratamientosSeleccionados.forEach(idTratamiento => {
                datosFormularios[idTratamiento] = { ...datosFormulario };
            });
            
            // Crear formulario oculto para enviar
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'insertar_tratamientos_multiples.php';
            form.style.display = 'none';
            
            // Agregar datos al formulario
            const inputTratamientos = document.createElement('input');
            inputTratamientos.type = 'hidden';
            inputTratamientos.name = 'tratamientos_seleccionados';
            inputTratamientos.value = JSON.stringify(tratamientosSeleccionados);
            form.appendChild(inputTratamientos);
            
            const inputDatos = document.createElement('input');
            inputDatos.type = 'hidden';
            inputDatos.name = 'datos_formularios';
            inputDatos.value = JSON.stringify(datosFormularios);
            form.appendChild(inputDatos);
            
            // Agregar formulario al DOM y enviarlo
            document.body.appendChild(form);
            form.submit();
            
            return false;
        }

        function checkSubmit() {
            if (!enviandoFormulario) {
                enviandoFormulario = true;
                return true;
            } else {
                alert("El formulario ya se está enviando");
                return false;
            }
        }

        function initVoiceRecognition() {
            document.querySelectorAll('.botones').forEach(function(botonesDiv) {
                const grabarBtn = botonesDiv.querySelector('.grabar-nota');
                const detenerBtn = botonesDiv.querySelector('.detener-nota');
                const reproducirBtn = botonesDiv.querySelector('.reproducir-nota');
                const campoNota = botonesDiv.parentElement.querySelector('.nota-enfermeria');

                if (!grabarBtn || !detenerBtn || !reproducirBtn || !campoNota) return;

                const newGrabarBtn = grabarBtn.cloneNode(true);
                const newDetenerBtn = detenerBtn.cloneNode(true);
                const newReproducirBtn = reproducirBtn.cloneNode(true);
                
                grabarBtn.parentNode.replaceChild(newGrabarBtn, grabarBtn);
                detenerBtn.parentNode.replaceChild(newDetenerBtn, detenerBtn);
                reproducirBtn.parentNode.replaceChild(newReproducirBtn, reproducirBtn);

                newReproducirBtn.addEventListener('click', () => {
                    const speech = new SpeechSynthesisUtterance(campoNota.value);
                    window.speechSynthesis.speak(speech);
                });

                let reconocimiento;
                if (window.webkitSpeechRecognition) {
                    reconocimiento = new webkitSpeechRecognition();
                    reconocimiento.lang = "es-ES";
                    reconocimiento.continuous = true;
                    reconocimiento.interimResults = false;

                    reconocimiento.onresult = (event) => {
                        const results = event.results;
                        const frase = results[results.length - 1][0].transcript;
                        campoNota.value += frase + ' ';
                    };
                }

                newGrabarBtn.addEventListener('click', () => {
                    if (reconocimiento) reconocimiento.start();
                });
                newDetenerBtn.addEventListener('click', () => {
                    if (reconocimiento) reconocimiento.abort();
                });
            });
        }

        function agregarFilaSignosVitales(btnAgregar, idTratamiento) {
            console.log('Agregando fila de signos vitales para tratamiento:', idTratamiento);
            
            var tabla = btnAgregar.closest('table');
            if (!tabla) {
                console.error('No se encontró la tabla');
                return;
            }
            var tbody = tabla.getElementsByTagName('tbody')[0];
            
            var btnRow = btnAgregar.closest('.btn-agregar-row');
            if (!btnRow) {
                console.error('No se encontró la fila del botón');
                return;
            }
            
            var nuevaFila = document.createElement('tr');
            nuevaFila.className = 'durante-cirugia-row';
            nuevaFila.innerHTML = `
                <td><strong>Signos Vitales</strong><br><small class="text-muted">Registro adicional #${tbody.querySelectorAll('.durante-cirugia-row').length + 1}</small></td>
                <td><input type="text" class="form-control" name="sistg" placeholder="ej: 120" required></td>
                <td><input type="text" class="form-control" name="diastg" placeholder="ej: 80" required></td>
                <td><input type="text" class="form-control" name="fcardg" placeholder="ej: 75" required></td>
                <td><input type="text" class="form-control" name="frespg" placeholder="ej: 20" required></td>
                <td><input type="text" class="form-control" name="satg" placeholder="ej: 98" required></td>
                <td><input type="text" class="form-control" name="tempg" placeholder="ej: 36.5" required></td>
                <td><input type="time" class="form-control" name="hora_signos" required></td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm enviar-signos" data-tratamiento="${idTratamiento}">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-warning btn-sm editar-signos" style="display: none; margin-left: 5px;" data-tratamiento="${idTratamiento}">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                </td>
            `;
            
            tbody.insertBefore(nuevaFila, btnRow);
            console.log('Fila agregada exitosamente');
            
            var btnGuardar = nuevaFila.querySelector('.enviar-signos');
            var btnEditar = nuevaFila.querySelector('.editar-signos');
            
            btnGuardar.addEventListener('click', function() {
                enviarSignosVitales(nuevaFila, idTratamiento);
            });
            
            btnEditar.addEventListener('click', function() {
                editarSignosVitales(nuevaFila, idTratamiento);
            });
        }

        function initializarFormulario() {
            console.log('Inicializando formulario...');
            initVoiceRecognition();
            
            const botonesAgregar = document.querySelectorAll('.agregar-signos');
            console.log('Botones de agregar signos encontrados:', botonesAgregar.length);
            
            botonesAgregar.forEach(function(btn, index) {
                console.log('Procesando botón', index + 1);
                
                if (!btn.hasAttribute('data-initialized')) {
                    btn.setAttribute('data-initialized', 'true');
                    console.log('Botón no estaba inicializado, agregando evento');
                    
                    var formulario = btn.closest('.formulario-tratamiento');
                    if (formulario) {
                        var idTratamiento = formulario.id.replace('formulario_', '');
                        console.log('ID del tratamiento:', idTratamiento);
                        
                        btn.addEventListener('click', function() {
                            console.log('Click en botón agregar signos para tratamiento:', idTratamiento);
                            agregarFilaSignosVitales(btn, idTratamiento);
                        });
                    } else {
                        console.error('No se encontró el formulario para el botón');
                    }
                } else {
                    console.log('Botón ya estaba inicializado');
                }
            });
            
            console.log('Inicialización completada');
        }

        function enviarSignosVitales(fila, idTratamiento) {
            const inputs = fila.querySelectorAll('input[required]');
            let datosCompletos = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    datosCompletos = false;
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = '';
                }
            });
            
            if (!datosCompletos) {
                alert('Por favor complete todos los campos de signos vitales');
                return;
            }
            
            const btnGuardar = fila.querySelector('.enviar-signos');
            const textoOriginal = btnGuardar.innerHTML;
            btnGuardar.disabled = true;
            btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            
            const datos = new FormData();
            inputs.forEach(input => {
                datos.append(input.name, input.value);
            });
            datos.append('id_tratamiento', idTratamiento);
            
            fetch('insertar_trans_grafico.php', {
                method: 'POST',
                body: datos
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    fila.classList.add('guardando');
                    
                    alert('Signos vitales guardados correctamente');
                    
                    btnGuardar.innerHTML = '<i class="fas fa-check"></i> Guardado';
                    btnGuardar.className = 'btn btn-success btn-sm btn-guardado';
                    btnGuardar.disabled = true;
                    
                    // Mostrar el botón de editar
                    const btnEditar = fila.querySelector('.editar-signos');
                    if (btnEditar) {
                        btnEditar.style.display = 'inline-block';
                    }
                    
                    inputs.forEach(input => {
                        input.readOnly = true;
                        input.style.backgroundColor = '#c3e6cb';
                        input.style.color = '#155724';
                        input.style.fontWeight = '500';
                    });
                    
                    // Aplicar estilo de fila guardada después de la animación
                    setTimeout(() => {
                        fila.classList.remove('guardando');
                        fila.classList.add('guardado');
                    }, 1000);
                    
                } else {
                    throw new Error(data.message || 'Error desconocido');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar los signos vitales: ' + error.message);
                
                // Restaurar el botón
                btnGuardar.disabled = false;
                btnGuardar.innerHTML = textoOriginal;
            });
        }

        function editarSignosVitales(fila, idTratamiento) {
            const inputs = fila.querySelectorAll('input[required]');
            const btnEditar = fila.querySelector('.editar-signos');
            const btnGuardar = fila.querySelector('.enviar-signos');
            
            // Habilitar edición de los campos
            inputs.forEach(input => {
                input.readOnly = false;
                input.style.backgroundColor = '';
                input.style.color = '';
                input.style.fontWeight = '';
            });
            
            // Ocultar botón editar y mostrar botón guardar
            btnEditar.style.display = 'none';
            btnGuardar.disabled = false;
            btnGuardar.innerHTML = '<i class="fas fa-save"></i> Actualizar';
            btnGuardar.className = 'btn btn-primary btn-sm enviar-signos';
            
            // Remover estilos de fila guardada
            fila.classList.remove('guardado');
        }

        function recopilarDatosFormulario(formulario) {
            const datos = {};
            const inputs = formulario.querySelectorAll('input, select, textarea');
            
            // Arrays para almacenar múltiples signos vitales
            const signosVitales = [];
            
            inputs.forEach(input => {
                if (input.name && input.name !== 'tratamientos_seleccionados' && input.name !== 'es_formulario_unificado') {
                    // Si es un campo de signos vitales, recopilar todos los valores
                    if (['sistg', 'diastg', 'fcardg', 'frespg', 'satg', 'tempg', 'hora_signos'].includes(input.name)) {
                        // Buscar la fila más cercana para asociar todos los signos vitales de esa fila
                        const fila = input.closest('tr');
                        if (fila && !fila.classList.contains('btn-agregar-row')) {
                            let signosActuales = signosVitales.find(signos => signos.fila === fila);
                            if (!signosActuales) {
                                signosActuales = { fila: fila };
                                signosVitales.push(signosActuales);
                            }
                            signosActuales[input.name] = input.value;
                        }
                    } else if (input.name.endsWith('[]')) {
                        const baseName = input.name.slice(0, -2);
                        if (!datos[baseName]) {
                            datos[baseName] = [];
                        }
                        datos[baseName].push(input.value);
                    } else {
                        datos[input.name] = input.value;
                    }
                }
            });
            
            // Agregar todos los signos vitales al objeto de datos
            if (signosVitales.length > 0) {
                datos.signos_vitales_multiples = signosVitales.map(signos => {
                    const { fila, ...signosLimpios } = signos;
                    return signosLimpios;
                });
                console.log('Signos vitales múltiples recopilados:', datos.signos_vitales_multiples);
            }
            
            return datos;
        }

        // Función para enviar múltiples tratamientos
        function enviarTratamientosMultiples() {
            const checkboxes = document.querySelectorAll('.tratamiento-checkbox:checked');
            
            if (checkboxes.length === 0) {
                alert('Por favor seleccione al menos un tratamiento');
                return;
            }
            
            const tratamientosSeleccionados = [];
            const datosFormularios = {};
            let formulariosIncompletos = [];
            
            checkboxes.forEach(checkbox => {
                const idTratamiento = checkbox.value;
                const formulario = document.getElementById('formulario_' + idTratamiento);
                
                if (formulario && formulario.style.display !== 'none') {
                    // Validar campos requeridos
                    const camposRequeridos = formulario.querySelectorAll('input[required], select[required]');
                    let formularioCompleto = true;
                    
                    camposRequeridos.forEach(campo => {
                        if (!campo.value.trim()) {
                            formularioCompleto = false;
                        }
                    });
                    
                    if (!formularioCompleto) {
                        const tipoTratamiento = formulario.querySelector('.card-header h4').textContent;
                        formulariosIncompletos.push(tipoTratamiento);
                    } else {
                        tratamientosSeleccionados.push(idTratamiento);
                        datosFormularios[idTratamiento] = recopilarDatosFormulario(formulario);
                    }
                }
            });
            
            if (formulariosIncompletos.length > 0) {
                alert('Por favor complete los campos requeridos en: ' + formulariosIncompletos.join(', '));
                return;
            }
            
            if (tratamientosSeleccionados.length === 0) {
                alert('No hay formularios válidos para enviar');
                return;
            }
            
            // Crear formulario oculto para enviar datos
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'insertar_tratamientos_multiples.php';
            form.style.display = 'none';
            
            // Agregar datos al formulario
            const inputTratamientos = document.createElement('input');
            inputTratamientos.type = 'hidden';
            inputTratamientos.name = 'tratamientos_seleccionados';
            inputTratamientos.value = JSON.stringify(tratamientosSeleccionados);
            form.appendChild(inputTratamientos);
            
            const inputDatos = document.createElement('input');
            inputDatos.type = 'hidden';
            inputDatos.name = 'datos_formularios';
            inputDatos.value = JSON.stringify(datosFormularios);
            form.appendChild(inputDatos);
            
            // Agregar formulario al DOM y enviarlo
            document.body.appendChild(form);
            form.submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.tratamiento-checkbox');
            const btnCargar = document.getElementById('btn_cargar_tratamientos');
            const contenedor = document.getElementById('formulario_contenedor');
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const haySeleccionados = document.querySelectorAll('.tratamiento-checkbox:checked').length > 0;
                    btnCargar.style.display = haySeleccionados ? 'block' : 'none';
                });
            });
            
            btnCargar.addEventListener('click', function() {
                const checkboxesSeleccionados = document.querySelectorAll('.tratamiento-checkbox:checked');
                const formularioGeneral = document.getElementById('formulario_general');
                const tratamientosLista = document.getElementById('tratamientos_seleccionados_lista');
                const tratamientosInput = document.getElementById('tratamientos_seleccionados_input');
                
                // Ocultar todos los formularios
                document.querySelectorAll('.formulario-tratamiento').forEach(form => {
                    form.style.display = 'none';
                });
                
        let enviandoFormulario = false;
        // Mostrar campos LASIK si se selecciona la opción
        $(document).ready(function(){
            function mostrarCamposLasik(){
                let lasikChecked = false;
                $(".tratamiento-checkbox").each(function(){
                    if($(this).is(":checked") && $(this).data("tipo").toUpperCase().includes("LASIK")){
                        lasikChecked = true;
                    }
                });
                if(lasikChecked){
                    $("#campos_lasik").show();
                    $("#medico_responsable_container").show();
                }else{
                    $("#campos_lasik").hide();
                    $("#medico_responsable_container").show();
                }
            }
            $(".tratamiento-checkbox").on("change", mostrarCamposLasik);
            mostrarCamposLasik();
        });
        // Estilos CSS para las filas de signos vitales
        const styles = `
            <style>
            </style>
        `;
        document.head.insertAdjacentHTML('beforeend', styles);
                        if (esLasik) {
                            tieneClasik = true;
                            idLasik = checkbox.value;
                        } else {
                            tratamientosGenerales.push({
                                id: checkbox.value,
                                tipo: checkbox.getAttribute('data-tipo')
                            });
                        }
                    });
                    
                    if (tratamientosGenerales.length > 0) {
                        formularioGeneral.style.display = 'block';
                        
                        const listaTipos = tratamientosGenerales.map(t => '<span class="badge badge-primary mr-1">' + t.tipo.toUpperCase() + '</span>').join(' ');
                        tratamientosLista.innerHTML = listaTipos;
                        
                        const idsSeleccionados = tratamientosGenerales.map(t => t.id);
                        tratamientosInput.value = JSON.stringify(idsSeleccionados);
                    }
                    
                    if (tieneClasik) {
                        const formularioLasik = document.getElementById('formulario_' + idLasik);
                        if (formularioLasik) {
                            formularioLasik.style.display = 'block';
                        }
                    }
                    
                    setTimeout(() => {
                        initializarFormulario();
                    }, 200);
                    
                    contenedor.scrollIntoView({ behavior: 'smooth' });
                } else {
                    contenedor.style.display = 'none';
                }
            });
            initializarFormulario();
        // Fin del eventListener principal

        document.oncontextmenu = function() {
            return false;
        }
    </script>

    <footer class="main-footer">
        <div style="font-size:16px;">
            <?php include("../../template/footer.php"); ?>
        </div>
    </footer>

    <!-- FastClick -->
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>
</html>
