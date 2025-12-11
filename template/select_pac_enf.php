<?php
include "../conexionbd.php";
session_start();
//
if (!isset($_SESSION['login'])) {
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
    header('Location: ../index.php');
}
$usuario = $_SESSION['login'];
//$resultado = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='" . $usuario . "'") or die($conexion->error);
if (!($usuario['id_rol'] == 3 || $usuario['id_rol'] == 5 || $usuario['id_rol'] == 12 || $usuario['id_rol'] == 1)) {
    session_unset();
    session_destroy();
    // echo "<script>window.Location='../index.php';</script>";
    header('Location: ../index.php');
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>INEO Metepec</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #0a0a0a 100%) !important;
            font-family: 'Roboto', sans-serif !important;
            min-height: 100vh;
        }

        /* Efecto de partículas en el fondo */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(64, 224, 255, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(64, 224, 255, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(64, 224, 255, 0.02) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .wrapper {
            position: relative;
            z-index: 1;
        }

        /* Header personalizado */
        .main-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border-bottom: 2px solid #40E0FF !important;
            box-shadow: 0 4px 20px rgba(64, 224, 255, 0.2);
        }

        .main-header .logo {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
            border-right: 2px solid #40E0FF !important;
        }

        .main-header .navbar {
            background: transparent !important;
        }

        /* Sidebar personalizado */
        .main-sidebar {
            background: linear-gradient(180deg, #16213e 0%, #0f3460 100%) !important;
            border-right: 2px solid #40E0FF !important;
            box-shadow: 4px 0 20px rgba(64, 224, 255, 0.15);
        }

        .sidebar-menu > li > a {
            color: #ffffff !important;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar-menu > li > a:hover,
        .sidebar-menu > li.active > a {
            background: rgba(64, 224, 255, 0.1) !important;
            border-left: 3px solid #40E0FF !important;
            color: #40E0FF !important;
        }

        .user-panel {
            border-bottom: 1px solid rgba(64, 224, 255, 0.2);
        }

        .user-panel .info {
            color: #ffffff !important;
        }

        /* Content wrapper */
        .content-wrapper {
            background: transparent !important;
            min-height: 100vh;
        }

        /* Breadcrumb mejorado */
        .breadcrumb {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
            border: 2px solid #40E0FF !important;
            border-radius: 15px !important;
            padding: 20px 30px !important;
            margin-bottom: 30px !important;
            box-shadow: 0 8px 30px rgba(64, 224, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .breadcrumb::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(64, 224, 255, 0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .breadcrumb h4 {
            color: #ffffff !important;
            margin: 0;
            font-weight: 600 !important;
            letter-spacing: 2px;
            text-shadow: 0 0 20px rgba(64, 224, 255, 0.5);
            position: relative;
            z-index: 1;
        }

        /* Container principal */
        .container {
            position: relative;
            z-index: 1;
        }

        /* Header de sección */
        .thead {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
            border: 2px solid #40E0FF !important;
            border-radius: 15px !important;
            padding: 20px !important;
            margin-bottom: 30px !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            letter-spacing: 2px !important;
            text-transform: uppercase !important;
            box-shadow: 0 8px 25px rgba(64, 224, 255, 0.3),
                        inset 0 0 20px rgba(64, 224, 255, 0.1) !important;
            position: relative;
            overflow: hidden;
        }

        .thead::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(64, 224, 255, 0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }

        .thead strong {
            position: relative;
            z-index: 1;
            text-shadow: 0 0 20px rgba(64, 224, 255, 0.5);
        }

        /* Botones mejorados */
        .btn {
            border-radius: 25px !important;
            padding: 10px 25px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            transition: all 0.3s ease !important;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-warning {
            border: 2px solid #ff9940 !important;
            background: linear-gradient(135deg, #4d3a1a 0%, #3a2a0f 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 5px 15px rgba(255, 153, 64, 0.3) !important;
        }

        .btn-warning:hover {
            transform: translateY(-3px) scale(1.05) !important;
            box-shadow: 0 10px 30px rgba(255, 153, 64, 0.5) !important;
            border-color: #ffaa55 !important;
            color: #ffffff !important;
        }

        .btn i {
            position: relative;
            z-index: 1;
        }

        /* Tarjetas de camas mejoradas */
        .alert {
            border-radius: 15px !important;
            padding: 20px 15px !important;
            margin-bottom: 15px !important;
            text-align: center !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            overflow: hidden !important;
            border: 2px solid !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3) !important;
            min-height: 140px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            transform: rotate(45deg);
            transition: all 0.6s ease;
        }

        .alert:hover::before {
            left: 100%;
        }

        .alert:hover {
            transform: translateY(-10px) scale(1.05) !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5) !important;
        }

        .alert i,
        .alert h7,
        .alert font {
            position: relative;
            z-index: 1;
        }

        /* Cama LIBRE - Verde neón */
        .alert-success {
            background: linear-gradient(135deg, #1a4d2e 0%, #0f3a1f 100%) !important;
            border-color: #00ff88 !important;
            color: #ffffff !important;
            box-shadow: 0 5px 15px rgba(0, 255, 136, 0.3) !important;
        }

        .alert-success:hover {
            box-shadow: 0 15px 40px rgba(0, 255, 136, 0.5),
                        0 0 30px rgba(0, 255, 136, 0.3) !important;
            border-color: #00ffaa !important;
        }

        .alert-success i {
            color: #00ff88 !important;
            text-shadow: 0 0 20px rgba(0, 255, 136, 0.8);
        }

        /* Cama NO DISPONIBLE / MANTENIMIENTO - Rojo neón */
        .alert-danger {
            background: linear-gradient(135deg, #4d1a1a 0%, #3a0f0f 100%) !important;
            border-color: #ff4040 !important;
            color: #ffffff !important;
            box-shadow: 0 5px 15px rgba(255, 64, 64, 0.3) !important;
        }

        .alert-danger:hover {
            box-shadow: 0 15px 40px rgba(255, 64, 64, 0.5),
                        0 0 30px rgba(255, 64, 64, 0.3) !important;
            border-color: #ff5555 !important;
        }

        .alert-danger i {
            color: #ff4040 !important;
            text-shadow: 0 0 20px rgba(255, 64, 64, 0.8);
        }

        /* Cama OCUPADA - Azul oscuro */
        .alert[style*="background-color: #2b2d7f"] {
            background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
            border-color: #40E0FF !important;
            color: #ffffff !important;
            box-shadow: 0 5px 15px rgba(64, 224, 255, 0.3) !important;
        }

        .alert[style*="background-color: #2b2d7f"]:hover {
            box-shadow: 0 15px 40px rgba(64, 224, 255, 0.5),
                        0 0 30px rgba(64, 224, 255, 0.3) !important;
            border-color: #00D9FF !important;
        }

        .alert[style*="background-color: #2b2d7f"] i {
            color: #40E0FF !important;
            text-shadow: 0 0 20px rgba(64, 224, 255, 0.8);
        }

        /* Cama POR LIBERAR - Naranja/Amarillo */
        .alert-warning {
            background: linear-gradient(135deg, #4d3a1a 0%, #3a2a0f 100%) !important;
            border-color: #ff9940 !important;
            color: #ffffff !important;
            box-shadow: 0 5px 15px rgba(255, 153, 64, 0.3) !important;
        }

        .alert-warning:hover {
            box-shadow: 0 15px 40px rgba(255, 153, 64, 0.5),
                        0 0 30px rgba(255, 153, 64, 0.3) !important;
            border-color: #ffaa55 !important;
        }

        .alert-warning i {
            color: #ff9940 !important;
            text-shadow: 0 0 20px rgba(255, 153, 64, 0.8);
        }

        /* Cama LISTA - Magenta */
        .alert[style*="background-color:#E00884"] {
            background: linear-gradient(135deg, #4d1a3a 0%, #3a0f2a 100%) !important;
            border-color: #E00884 !important;
            color: #ffffff !important;
            box-shadow: 0 5px 15px rgba(224, 8, 132, 0.3) !important;
        }

        .alert[style*="background-color:#E00884"]:hover {
            box-shadow: 0 15px 40px rgba(224, 8, 132, 0.5),
                        0 0 30px rgba(224, 8, 132, 0.3) !important;
            border-color: #ff0099 !important;
        }

        .alert[style*="background-color:#E00884"] i {
            color: #E00884 !important;
            text-shadow: 0 0 20px rgba(224, 8, 132, 0.8);
        }

        /* Iconos de cama */
        .alert .fa-bed {
            display: block;
            margin: 0 auto 10px;
            transition: all 0.3s ease;
        }

        .alert:hover .fa-bed {
            transform: scale(1.2) rotate(5deg);
        }

        /* Texto de las camas */
        .alert h7 {
            display: block;
            margin: 5px 0;
            font-weight: 600;
        }

        .alert .nompac {
            display: block;
            margin-top: 8px;
            font-size: 11px !important;
            opacity: 0.9;
            line-height: 1.3;
        }

        .alert .nod {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Grid de camas */
        .col-lg-1\.9 {
            width: 16.66%;
            float: left;
            padding: 0 7.5px;
        }

        @media (max-width: 1200px) {
            .col-lg-1\.9 {
                width: 20%;
            }
        }

        @media (max-width: 992px) {
            .col-lg-1\.9 {
                width: 25%;
            }
        }

        @media (max-width: 768px) {
            .col-lg-1\.9 {
                width: 33.33%;
            }
        }

        @media (max-width: 576px) {
            .col-lg-1\.9 {
                width: 50%;
            }
        }

        /* Enlaces sin subrayado */
        a {
            text-decoration: none !important;
        }

        a:hover {
            text-decoration: none !important;
        }

        /* Container box */
        .container.box {
            background: transparent !important;
            border: none !important;
            padding: 15px !important;
        }

        /* Animaciones de entrada */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert {
            animation: fadeInUp 0.5s ease-out backwards;
        }

        /* Escalonamiento de animaciones */
        .col-lg-1\.9:nth-child(1) .alert { animation-delay: 0.05s; }
        .col-lg-1\.9:nth-child(2) .alert { animation-delay: 0.1s; }
        .col-lg-1\.9:nth-child(3) .alert { animation-delay: 0.15s; }
        .col-lg-1\.9:nth-child(4) .alert { animation-delay: 0.2s; }
        .col-lg-1\.9:nth-child(5) .alert { animation-delay: 0.25s; }
        .col-lg-1\.9:nth-child(6) .alert { animation-delay: 0.3s; }

        /* Footer */
        .main-footer {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
            border-top: 2px solid #40E0FF !important;
            color: #ffffff !important;
            box-shadow: 0 -4px 20px rgba(64, 224, 255, 0.2);
        }

        /* Dropdown menu personalizado */
        .dropdwn-content {
            background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
            border: 2px solid #40E0FF !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5),
                        0 0 20px rgba(64, 224, 255, 0.3) !important;
        }

        .dropdwn-content a {
            color: #ffffff !important;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .dropdwn-content a:hover {
            background: rgba(64, 224, 255, 0.1) !important;
            border-left: 3px solid #40E0FF !important;
            color: #40E0FF !important;
        }

        /* Scrollbar personalizado */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0a;
            border-left: 1px solid #40E0FF;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #40E0FF 0%, #0f3460 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #00D9FF 0%, #40E0FF 100%);
        }

        /* SweetAlert personalizado */
        .sweet-alert {
            background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
            border: 2px solid #40E0FF !important;
            border-radius: 20px !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.9),
                        0 0 40px rgba(64, 224, 255, 0.4);
        }

        .sweet-alert h2 {
            color: #ffffff !important;
            text-shadow: 0 0 15px rgba(64, 224, 255, 0.5);
        }

        .sweet-alert p {
            color: #ffffff !important;
        }

        .sweet-alert button {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
            border: 2px solid #40E0FF !important;
            border-radius: 25px !important;
            box-shadow: 0 5px 15px rgba(64, 224, 255, 0.3) !important;
        }

        .sweet-alert button:hover {
            background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
            border-color: #00D9FF !important;
            box-shadow: 0 10px 25px rgba(64, 224, 255, 0.5) !important;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">

        <header class="main-header">
            <?php
            if ($usuario['id_rol'] == 3) {
            ?>
                <a href="menu_enfermera.php" class="logo">
                    <span class="logo-lg"><b><img src="../imagenes/SI.PNG" height="30" width="120"></b> </span>
                </a>
            <?php
            } else if ($usuario['id_rol'] == 5) {
            ?>
                <a href="menu_gerencia.php" class="logo">
                    <span class="logo-lg"><b><img src="../imagenes/SI.PNG" height="30" width="120"></b></span>
                </a>
            <?php
            } else if ($usuario['id_rol'] == 12) {
            ?>
                <a href="menu_residente.php" class="logo">
                    <span class="logo-lg"><b><img src="../imagenes/SI.PNG" height="30" width="120"></b> </span>
                </a>
            <?php
            } else if ($usuario['id_rol'] == 1) {
            ?>
                <a href="menu_administrativo.php" class="logo">
                    <span class="logo-lg"><b><img src="../imagenes/SI.PNG" height="30" width="120"></b></span>
                </a>
            <?php
            } else
                session_destroy();
            echo "<script>window.Location='../index.php';</script>";
            ?>

            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="user-image" alt="User Image" />
                                <span class="hidden-xs"> <?php echo $usuario['nombre']; ?> <?php echo $usuario['papell']; ?> <?php echo $usuario['sapell']; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="img-circle" alt="User Image" />
                                    <p><?php echo $usuario['nombre']; ?> <?php echo $usuario['papell']; ?> <?php echo $usuario['sapell']; ?></p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="../cerrar_sesion.php" class="btn btn-default btn-flat">CERRAR SESIÓN</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p><?php echo $usuario['nombre']; ?> <?php echo $usuario['papell']; ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> ACTIVO</a>
                    </div>
                </div>

<?php
if (isset($_SESSION['pac']) && $usuario['id_rol'] == 5 || $usuario['id_rol'] == 3) {
?>
<ul class="sidebar-menu">
                <li class="treeview">
                     <a href="../pdf/vista_pdf.php">
                            <i class="fa fa-print" aria-hidden="true"></i><span>IMPRIMIR DOCUMENTOS</span>
                     </a>
                </li>
                <li class="treeview">
                   <a href="#">
                    <i class="fa fa-bed"></i><font size ="2"><span>GESTIÓN DE CAMAS</span></font><i class="fa fa-angle-left pull-right"></i>
                   </a>
                </li>
                <li class="treeview">
                     <a href="../ordenes_medico/vista_ordenes.php">
                            <i class="fa fa-stethoscope"></i> <span>INDICACIONES DEL MÉDICO </span>
                     </a>
                </li>

        <li class=" treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>REGISTRO CLÍNICO</span><i class="fa fa-angle-left pull-right"></i>
            </a>
              <ul class="treeview-menu">
              <li><a href="../registro_clinico/reg_clin.php"><i class="fa fa-folder"></i> <span>HOSPITALIZACIÓN</span></a></li>
              <li><a href="../registro_quirurgico/vista_enf_quirurgico.php"><i class="fa fa-folder"></i> <span>QUIRÓFANO</span></a></li>
              <li><a href="../registro_terapeutico/reg_terapeutico.php"><i class="fa fa-folder"></i> <span>CUIDADOS INTENSIVOS </span></a></li>
              <li><a href="../registro_clinico_neonatal/nota_bebes.php"><i class="fa fa-folder"></i> <span>NEONATAL </span></a></li>
              <li><a href="..transfucion_de_sangre/nota_transfuciones.php"><i class="fa fa-folder"></i> <span>TRANSFUSIONES<br>SANGUÍNEAS</span></a></li>
            </ul>
        </li>
        <li class="treeview">
                <a href="../signos_vitales/signos.php">
                <i class="fa fa-heartbeat" aria-hidden="true"></i> <span>SIGNOS VITALES</span>
                </a>
                </li>
                 <li class="treeview">
                <a href="../medicamentos/medicamentos.php">
                 <i class="fa fa-medkit" aria-hidden="true"></i><span>REGISTRO DE MEDICAMENTOS</span>
                </a>
                </li>

                <li class="treeview">
                <a href="../dolor/val_dolor.php">
                 <i class="fa fa-medkit" aria-hidden="true"></i><span>REGISTRO DE SOLUCIONES/<br>AMINAS</span>
                </a>
            </li>
</ul>
<?php
}else{
?>
<ul class="sidebar-menu">
                   <li class="treeview">
                       <a href="select_pac_enf.php">
                        <i class="fa fa-print" aria-hidden="true"></i> <span>IMPRIMIR DOCUMENTOS</span>
                       </a>
            </li>
             <li class="treeview">
                   <a href="#">
                    <i class="fa fa-bed"></i><font size ="2"><span>GESTIÓN DE CAMAS</span></font><i class="fa fa-angle-left pull-right"></i>
                   </a>
                </li>
            <li class="treeview">
                        <a href="select_pac_enf.php">
                            <i class="fa fa-stethoscope"></i> <span>INDICACIONES DEL MÉDICO</span>
                        </a>
            </li>

            <li class=" treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>REGISTRO CLÍNICO</span><i class="fa fa-angle-left pull-right"></i>
            </a>
              <ul class="treeview-menu">
                <li><a href="select_pac_enf.php"><i class="fa fa-folder"></i> <span>HOSPITALIZACIÓN</span></a></li>
                <li><a href="select_pac_enf.php"><i class="fa fa-folder"></i> <span>QUIRÓFANO</span></a></li>
                <li><a href="select_pac_enf.php"><i class="fa fa-folder"></i> <span>CUIDADOS INTENSIVOS </span></a></li>
                <li><a href="select_pac_enf.php"><i class="fa fa-folder"></i> <span>NEONATAL </span></a></li>
                <li><a href="select_pac_enf.php"><i class="fa fa-folder"></i> <span>TRANSFUSIONES<br>SANGUÍNEAS</span></a></li>
              </ul>
            </li>
            <li class="treeview">
                <a href="select_pac_enf.php">
                  <i class="fa fa-heartbeat" aria-hidden="true"></i> <span>SIGNOS VITALES</span>
                </a>
            </li>
            <li class="treeview">
                <a href="select_pac_enf.php">
                  <i class="fa fa-medkit" aria-hidden="true"></i><span>REGISTRO DE MEDICAMENTOS</span>
                </a>
            </li><li class="treeview">
                <a href="select_pac_enf.php">
                  <i class="fa fa-medkit" aria-hidden="true"></i><span>REGISTRO DE SOLUCIONES/<br>AMINAS</span>
                </a>
            </li>
</ul>
<?php
}
?>
<?php
if (isset($_SESSION['pac']) && $usuario['id_rol'] == 12) {
?>
<ul class="sidebar-menu">
                    <li class="treeview">
                        <a href="../ordenes_medico/vista_ordenes.php">
                            <i class="fa fa-stethoscope"></i> INDICACIONES DEL MÉDICO </span>
                        </a>
                    </li>
</ul>
<?php
}
?>
      </section>
    </aside>

    <div class="content-wrapper">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
              <h4><i class="fa fa-heart"></i> ENFERMERÍA</h4>
          </li>
        </ol>
      </nav>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <script>
                    $(document).ready(function() {
                        swal({
                            title: "Favor de seleccionar un paciente",
                            type: "error",
                            confirmButtonText: "Aceptar"
                        }, function(isConfirm) {
                            if (isConfirm) {
                                window.location.href = "menu_enfermera.php";
                            }
                        });
                    });
                </script>


<section class="content container-fluid">
    <div class="container">
          <div class="row">
              <div class="col-sm-4">
                <a href="../enfermera/censo/tabla_censo.php"><button type="button" class="btn btn-warning"><i class="fa fa-bed"></i> VER CENSO</button></a>
              </div>
            </div>
    </div>


<div class="thead">
  <center><strong><i class="fa fa-hospital-o"></i> HOSPITALIZACIÓN</strong></center><p>
</div>
<div class="container box col-12">
        <div class= "row">

        <?php
        $sql = 'SELECT * from cat_camas where piso=1 and seccion=1 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
$intendencia = $row['intendencia'] ?? '';

          if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <i style="font-size:23px;" class="fa fa-bed"></i>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2" class="nod"><?php echo $esta ?></font></h7>
                <br>
              </div>
            </div>
          <?php
          } elseif ($biomedica == "Liberada" and $mantenimiento == "Liberada" and $serv_generales == "Liberada"){
$pr="CAMA LISTA";
?>
<div class="col-lg-1.9 col-xs-1">
              <div class="alert" role="alert" style="background-color:#E00884; color: white;">
                <a href="../enfermera/censo/liberacion_camas.php?num_cama=<?php echo $num_cama ?>" class="small-box-footer"><i style="font-size:24px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
              </div>
            </div>
<?php
          }elseif ($estaus == "EN PROCESO DE LIBERA"){
$pr="POR LIBERAR";
?>
<div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="../enfermera/censo/liberacion_camas.php?num_cama=<?php echo $num_cama ?>" class="small-box-footer"><i style="font-size:24px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
          <a href="../enfermera/lista_pacientes/select_pac.php?id_atencion=<?php echo $id_atencion ?>" class="small-box-footer">
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">
                <i style="font-size:25px;" class="fa fa-bed"></i>
                <h7><font size="3"><?php echo $num_cama ?></font></h7><br>
                <?php
                $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp";
                $result_pac = $conexion->query($sql_pac);
                while ($row_cam = $result_pac->fetch_assoc()) {
                  $nombre_pac = $row_cam['nom_pac'] . ' ' . $row_cam['papell'];
                }
                ?>
                <font size="2" class="nompac"><?php echo $nombre_pac ?></font>
                <br>
              </div>
            </div></a>
        <?php
          }
        }
        ?>

        <?php
        $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=1 and seccion=2 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
$intendencia = $row['intendencia'] ?? '';
          if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
         <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <i style="font-size:20px;" class="fa fa-bed"></i>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2" class="nod"><?php echo $esta ?></font></h7>
                <br>
              </div>
            </div>
            <?php
          } else {
          ?>
            <a href="../enfermera/lista_pacientes/select_pac.php?id_atencion=<?php echo $id_atencion ?>" class="small-box-footer">
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <i style="font-size:25px;" class="fa fa-bed"></i>
                <h7><font size="3"><?php echo $num_cama ?></font></h7><br>
                <?php
                $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp";
                $result_pac = $conexion->query($sql_pac);
                while ($row_cam = $result_pac->fetch_assoc()) {
                  $nombre_pac = $row_cam['nom_pac'] . ' ' . $row_cam['papell'];
                }
                ?>
                <font size="2" class="nompac"><?php echo $nombre_pac ?></font>
                <br />
              </div>
            </div></a>
        <?php
          }
        }
        ?>
</div>
</div>

</section>
    </div>

        <footer class="main-footer">
            <?php
            include("footer.php");
            ?>
        </footer>

    </div>

    <!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>
    <!-- AdminLTE dashboard demo -->
    <script src="dist/js/pages/dashboard2.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>

</body>

</html>
