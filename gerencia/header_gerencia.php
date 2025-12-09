<?php
// Verificar si la sesión ya está iniciada antes de llamar session_start()
if (session_status() === PHP_SESSION_NONE) {
    $lifetime = 86400;
    session_set_cookie_params($lifetime);
    session_start();
}

include "../../conexionbd.php";

if (!isset($_SESSION['login'])) {
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
    header('Location: ../../index.php');
    exit();
}
$usuario = $_SESSION['login'];

if (!($usuario['id_rol'] == 5)) {
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
    echo "<div class='alert alert-danger mt-4' role='alert'>No tienes permiso para ingresar aquí!
  <p><a href='../../index.php'><strong>Por favor, intente de nuevo!</strong></a></p></div>";
    header('Location: ../../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SIMA</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="../../template/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../../template/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="../../template/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../../template/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins -->
    <link href="../../template/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <!-- jQuery 2.1.3 -->
    <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- FastClick -->
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <!-- Sparkline -->
    <script src="../../template/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../../template/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../../template/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="../../template/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="../../template/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="../../template/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../../template/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../../template/plugins/chartjs/Chart.min.js" type="text/javascript"></script>
    <!-- AdminLTE dashboard demo -->
    <script src="../../template/dist/js/pages/dashboard2.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../template/dist/js/demo.js" type="text/javascript"></script>

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

        /* ========================================
           HEADER Y NAVEGACIÓN
           ======================================== */

        .main-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border-bottom: 2px solid #40E0FF !important;
            box-shadow: 0 4px 20px rgba(64, 224, 255, 0.2);
            position: fixed !important;
            top: 0 !important;
            right: 0 !important;
            left: 230px !important;
            z-index: 800 !important;
            transition: left 0.3s ease-in-out !important;
        }

        /* Cuando el sidebar está colapsado */
        .sidebar-collapse .main-header {
            left: 50px !important;
        }

        /* En móviles */
        @media (max-width: 767px) {
            .main-header {
                left: 0 !important;
            }
        }

        .main-header .logo {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
            border-right: 2px solid #40E0FF !important;
            color: #40E0FF !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 230px !important;
            height: 50px !important;
            z-index: 850 !important;
            transition: width 0.3s ease-in-out !important;
        }

        /* Cuando el sidebar está colapsado */
        .sidebar-collapse .main-header .logo {
            width: 50px !important;
        }

        /* En móviles */
        @media (max-width: 767px) {
            .main-header .logo {
                width: 50px !important;
            }
        }

        .main-header .navbar {
            background: transparent !important;
        }

        /* ========================================
           SIDEBAR
           ======================================== */

        .main-sidebar {
            background: linear-gradient(180deg, #16213e 0%, #0f3460 100%) !important;
            border-right: 2px solid #40E0FF !important;
            box-shadow: 4px 0 20px rgba(64, 224, 255, 0.15);
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            height: 100% !important;
            z-index: 810 !important;
        }

        /* Ajuste para el content cuando el sidebar está abierto */
        .sidebar-open .content-wrapper {
            margin-left: 230px !important;
        }

        /* Ajuste para cuando el sidebar está cerrado (sidebar-collapse) */
        .sidebar-collapse .content-wrapper {
            margin-left: 50px !important;
        }

        /* En móviles, el sidebar se superpone */
        @media (max-width: 767px) {
            .content-wrapper {
                margin-left: 0 !important;
            }

            .main-sidebar {
                transform: translate(-230px, 0) !important;
                transition: transform 0.3s ease-in-out !important;
            }

            .sidebar-open .main-sidebar {
                transform: translate(0, 0) !important;
            }
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

        .sidebar-menu > li.active {
            background: rgba(64, 224, 255, 0.05) !important;
        }

        .user-panel {
            border-bottom: 1px solid rgba(64, 224, 255, 0.2);
        }

        .user-panel .info {
            color: #ffffff !important;
        }

        .user-panel .info p {
            color: #ffffff !important;
            font-weight: 600;
        }

        .user-panel .info a {
            color: #00ff88 !important;
        }

        /* ========================================
           CONTENT WRAPPER
           ======================================== */

        .content-wrapper {
            background: transparent !important;
            min-height: 100vh;
            margin-left: 230px !important;
            padding-top: 50px !important;
            transition: margin-left 0.3s ease-in-out !important;
        }

        /* Cuando el sidebar está colapsado */
        .sidebar-collapse .content-wrapper {
            margin-left: 50px !important;
        }

        /* ========================================
           BREADCRUMB
           ======================================== */

        .breadcrumb {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
            border: 2px solid #40E0FF !important;
            border-radius: 15px !important;
            padding: 20px 30px !important;
            margin-bottom: 40px !important;
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

        /* ========================================
           DROPDOWN MENU
           ======================================== */

        .dropdwn {
            float: left;
            overflow: hidden;
        }

        .dropdwn .dropbtn {
            cursor: pointer;
            font-size: 16px;
            border: none;
            outline: none;
            color: white;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
            transition: all 0.3s ease;
        }

        .navbar a:hover,
        .dropdwn:hover .dropbtn,
        .dropbtn:focus {
            background-color: rgba(64, 224, 255, 0.2) !important;
        }

        .dropdwn-content {
            display: none;
            position: absolute;
            background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border: 2px solid #40E0FF;
            border-radius: 10px;
            overflow: hidden;
        }

        .dropdwn-content a {
            float: none;
            color: #ffffff !important;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .dropdwn-content a:hover {
            background: rgba(64, 224, 255, 0.1) !important;
            border-left: 3px solid #40E0FF;
        }

        .show {
            display: block;
        }

        /* ========================================
           USER DROPDOWN MENU
           ======================================== */

        .dropdown-menu {
            background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
            border: 2px solid #40E0FF !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5),
                        0 0 20px rgba(64, 224, 255, 0.3) !important;
        }

        .user-header {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
            border-bottom: 2px solid #40E0FF !important;
        }

        .user-header p {
            color: #ffffff !important;
            text-shadow: 0 0 10px rgba(64, 224, 255, 0.5);
        }

        .user-footer {
            background: rgba(15, 52, 96, 0.5) !important;
            border-top: 2px solid #40E0FF !important;
        }

        .user-footer .btn {
            border-radius: 20px !important;
            padding: 8px 20px !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease !important;
            border: 2px solid #40E0FF !important;
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
            color: #ffffff !important;
        }

        .user-footer .btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(64, 224, 255, 0.4) !important;
            border-color: #00D9FF !important;
        }

        /* ========================================
           NAVBAR CUSTOM MENU
           ======================================== */

        .navbar-custom-menu .user-menu > a {
            color: #ffffff !important;
        }

        .navbar-custom-menu .user-menu .user-image {
            border: 2px solid #40E0FF !important;
            box-shadow: 0 0 10px rgba(64, 224, 255, 0.5);
        }

        /* ========================================
           SIDEBAR MENU TREEVIEW
           ======================================== */

        .treeview-menu {
            background: rgba(10, 10, 10, 0.3) !important;
        }

        .treeview-menu > li > a {
            color: rgba(255, 255, 255, 0.8) !important;
            padding-left: 25px !important;
        }

        .treeview-menu > li > a:hover {
            color: #40E0FF !important;
            background: rgba(64, 224, 255, 0.1) !important;
        }

        /* ========================================
           IMÁGENES
           ======================================== */

        .img-circle {
            border: 2px solid #40E0FF !important;
            box-shadow: 0 0 15px rgba(64, 224, 255, 0.5) !important;
        }

        .img-fluid {
            filter: drop-shadow(0 0 10px rgba(64, 224, 255, 0.3));
        }

        /* ========================================
           ANIMACIONES
           ======================================== */

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

        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1.3);
                opacity: 0;
            }
        }

        /* ========================================
           TODO CONTAINER
           ======================================== */

        .todo-container {
            max-width: 15000px;
            height: auto;
            display: flex;
            overflow-y: scroll;
            column-gap: 0.5em;
            column-rule: 1px solid rgba(64, 224, 255, 0.3);
            column-width: 140px;
            column-count: 7;
        }

        .status {
            width: 25%;
            background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
            border: 2px solid #40E0FF;
            border-radius: 15px;
            position: relative;
            padding: 60px 1rem 0.5rem;
            height: 100%;
            box-shadow: 0 5px 15px rgba(64, 224, 255, 0.2);
        }

        .status h4 {
            position: absolute;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
            color: #40E0FF !important;
            margin: 0;
            width: 100%;
            padding: 0.5rem 1rem;
            text-shadow: 0 0 15px rgba(64, 224, 255, 0.5);
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* ========================================
           SCROLLBAR PERSONALIZADO
           ======================================== */

        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
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

        /* ========================================
           ALERTAS
           ======================================== */

        .alert {
            border-radius: 15px !important;
            border: 2px solid !important;
            font-weight: 600;
            animation: fadeInUp 0.5s ease-out;
        }

        .alert-danger {
            background: linear-gradient(135deg, #3a0f0f 0%, #4d1a1a 100%) !important;
            border-color: #ff4040 !important;
            color: white !important;
            box-shadow: 0 5px 20px rgba(255, 64, 64, 0.3);
        }

        .alert-danger a {
            color: #40E0FF !important;
            text-decoration: underline;
        }

        /* ========================================
           RESPONSIVE
           ======================================== */

        @media screen and (max-width: 768px) {
            .breadcrumb {
                padding: 15px 20px !important;
            }

            .breadcrumb h4 {
                font-size: 1.1rem;
                letter-spacing: 1px;
            }

            .main-sidebar {
                box-shadow: 2px 0 10px rgba(64, 224, 255, 0.15);
            }
        }

        @media screen and (max-width: 576px) {
            .breadcrumb h4 {
                font-size: 1rem;
            }

            .sidebar-menu > li > a {
                font-size: 0.9rem;
            }
        }

        /* ========================================
           EFECTOS ADICIONALES
           ======================================== */

        /* Glow effect en hover para links */
        a {
            transition: all 0.3s ease;
        }

        a:hover {
            text-shadow: 0 0 10px rgba(64, 224, 255, 0.5);
        }

        /* Sidebar toggle button */
        .sidebar-toggle {
            color: #ffffff !important;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(64, 224, 255, 0.1) !important;
            color: #40E0FF !important;
        }

        /* Hidden-xs text */
        .hidden-xs {
            color: #ffffff !important;
            font-weight: 600;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <a href="../../template/menu_gerencia.php" class="logo">
          <?php
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_simg=$f['id_simg'];
?>
            <center><span class="fondo"><img src="../../configuracion/admin/img/<?php echo $f['img_base']?>" alt="imgsistema" class="img-fluid" width="112"></span></center>
          <?php
}
?>
        </a>

        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="../../imagenes/<?php echo $usuario['img_perfil'];?>" class="user-image" alt="User Image">
                            <span class="hidden-xs"> <?php echo $usuario['papell'];?> </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="../../imagenes/<?php echo $usuario['img_perfil'];?>" class="img-circle" alt="User Image">
                                <p><?php echo $usuario['papell'];?></p>
                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="../../gerencia/editar_perfil/editar_perfil.php?id_usua=<?php echo $usuario['id_usua'];?>" class="btn btn-default btn-flat">MIS DATOS</a>
                                </div>
                                <div class="pull-right">
                                    <a href="../../cerrar_sesion.php" class="btn btn-default btn-flat">CERRAR SESIÓN</a>
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
                    <img src="../../imagenes/<?php echo $usuario['img_perfil']; ?>" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p><?php echo $usuario['papell'];?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-user-friends"></i> <span><strong>MENÚ GERENTE GENERAL</strong></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../../template/menu_administrativo.php"><i class="fa fa-folder"></i> ADMINISTRATIVO</a></li>
                        <li><a href="../../template/menu_sauxiliares.php"><i class="fa fa-folder"></i> SERVICIOS AUXILIARES</a></li>
                        <li><a href="../../template/menu_enfermera.php"><i class="fa fa-heart"></i> ENFERMERÍA</a></li>
                        <li><a href="../../template/menu_medico.php"><i class="fa fa-stethoscope"></i> MÉDICO</a></li>
                        <li><a href="../../template/menu_configuracion.php"><i class="fa fa-cogs"></i> CONFIGURACIÓN</a></li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <h4><i class="fa fa-briefcase"></i> GERENCIA</h4>
                </li>
            </ol>
        </nav>
