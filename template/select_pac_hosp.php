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
if (!($usuario['id_rol'] == 2 || $usuario['id_rol'] == 5 || $usuario['id_rol'] == 12)) {
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
  <link rel="icon" href="../imagenes/SIF.PNG">
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
  <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />


  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

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
   2. HEADER Y NAVEGACIÓN
   ======================================== */

.main-header {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
    border-bottom: 2px solid #40E0FF !important;
    box-shadow: 0 4px 20px rgba(64, 224, 255, 0.2);
}

.main-header .logo {
    background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
    border-right: 2px solid #40E0FF !important;
    color: #40E0FF !important;
}

.main-header .navbar {
    background: transparent !important;
}

/* ========================================
   3. SIDEBAR
   ======================================== */

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

/* ========================================
   4. CONTENT WRAPPER
   ======================================== */

.content-wrapper {
    background: transparent !important;
    min-height: 100vh;
}

/* ========================================
   5. BREADCRUMB
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
   6. CARDS/TARJETAS
   ======================================== */

.content.box {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
}

.card {
    background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
    border: 2px solid #40E0FF !important;
    border-radius: 20px !important;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    position: relative;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5),
                0 0 30px rgba(64, 224, 255, 0.2) !important;
    margin-bottom: 30px !important;
}

.card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        45deg,
        transparent,
        rgba(64, 224, 255, 0.1),
        transparent
    );
    transform: rotate(45deg);
    transition: all 0.6s ease;
}

.card:hover::before {
    left: 100%;
}

.card:hover {
    transform: translateY(-15px) scale(1.02) !important;
    border-color: #00D9FF !important;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7),
                0 0 50px rgba(64, 224, 255, 0.5),
                inset 0 0 20px rgba(64, 224, 255, 0.1) !important;
}

.card a {
    text-decoration: none !important;
    display: block;
}

.card-body {
    padding: 40px 20px !important;
    position: relative;
    z-index: 1;
}

/* ========================================
   7. ICONOS Y CÍRCULOS
   ======================================== */

.icon-circle {
    background: linear-gradient(135deg, rgba(64, 224, 255, 0.2) 0%, rgba(0, 217, 255, 0.3) 100%) !important;
    width: 140px !important;
    height: 140px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin: 0 auto 20px !important;
    border: 3px solid #40E0FF !important;
    box-shadow: 0 10px 30px rgba(64, 224, 255, 0.3),
                inset 0 0 20px rgba(64, 224, 255, 0.1) !important;
    transition: all 0.4s ease !important;
    position: relative;
}

.icon-circle::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 2px solid #40E0FF;
    opacity: 0;
    animation: ripple 2s ease-out infinite;
}

.card:hover .icon-circle {
    transform: scale(1.1) rotate(360deg) !important;
    box-shadow: 0 15px 40px rgba(64, 224, 255, 0.5),
                inset 0 0 30px rgba(64, 224, 255, 0.2) !important;
    background: linear-gradient(135deg, rgba(64, 224, 255, 0.3) 0%, rgba(0, 217, 255, 0.4) 100%) !important;
}

.card .fa {
    font-size: 56px !important;
    color: #40E0FF !important;
    text-shadow: 0 0 20px rgba(64, 224, 255, 0.8);
    transition: all 0.4s ease !important;
}

.card:hover .fa {
    transform: scale(1.2) !important;
    text-shadow: 0 0 30px rgba(64, 224, 255, 1),
                 0 0 40px rgba(64, 224, 255, 0.8);
}

/* Para imágenes en cards */
.card-img-top {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    display: block;
    border-radius: 50%;
    border: 3px solid #40E0FF;
    box-shadow: 0 10px 30px rgba(64, 224, 255, 0.3);
    transition: all 0.4s ease;
}

.card:hover .card-img-top {
    transform: scale(1.1) rotate(360deg);
    box-shadow: 0 15px 40px rgba(64, 224, 255, 0.5);
}

/* ========================================
   8. TÍTULOS Y TEXTO
   ======================================== */

.card h3,
.card h4 {
    color: #ffffff !important;
    font-weight: 700 !important;
    margin: 20px 0 0 0 !important;
    font-size: 1.1rem !important;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5),
                 0 0 20px rgba(64, 224, 255, 0.3);
    transition: all 0.3s ease;
}

.card:hover h3,
.card:hover h4 {
    color: #40E0FF !important;
    text-shadow: 0 0 20px rgba(64, 224, 255, 0.8),
                 0 0 30px rgba(64, 224, 255, 0.5);
}

/* ========================================
   9. TABLAS
   ======================================== */

.table {
    background: transparent !important;
    color: #ffffff;
}

.table-bordered {
    border: 2px solid #40E0FF !important;
    border-radius: 15px !important;
    overflow: hidden;
}

.thead {
    background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
    color: #ffffff !important;
}

.table > tbody > tr {
    transition: all 0.3s ease;
}

.table > tbody > tr:hover {
    background: rgba(64, 224, 255, 0.1) !important;
    transform: scale(1.01);
}

/* Estilos para filas rojas (urgentes) */
.fondosan {
    background: linear-gradient(135deg, #8B0000 0%, #B22222 100%) !important;
    color: white !important;
    border: 1px solid #FF4444 !important;
}

.fondosan:hover {
    background: linear-gradient(135deg, #A00000 0%, #DC143C 100%) !important;
    box-shadow: 0 0 20px rgba(255, 68, 68, 0.5);
}

/* ========================================
   10. BOTONES
   ======================================== */

.btn {
    border-radius: 25px !important;
    padding: 10px 30px !important;
    font-weight: 600 !important;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease !important;
    border: 2px solid #40E0FF !important;
    background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
    color: #ffffff !important;
}

.btn:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 10px 25px rgba(64, 224, 255, 0.4) !important;
    background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
    border-color: #00D9FF !important;
    color: #ffffff !important;
}

.btn-success {
    background: linear-gradient(135deg, #0f6040 0%, #16a162 100%) !important;
    border-color: #40FFE0 !important;
}

.btn-success:hover {
    background: linear-gradient(135deg, #16a162 0%, #0f6040 100%) !important;
    border-color: #00FFD9 !important;
}

.btn-danger {
    background: linear-gradient(135deg, #8B0000 0%, #B22222 100%) !important;
    border-color: #FF4444 !important;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #A00000 0%, #DC143C 100%) !important;
    border-color: #FF6666 !important;
}

/* ========================================
   11. MODALES
   ======================================== */

.modal-content {
    background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
    border: 2px solid #40E0FF !important;
    border-radius: 20px !important;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.9),
                0 0 40px rgba(64, 224, 255, 0.4);
}

.modal-header {
    background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
    border-bottom: 2px solid #40E0FF !important;
    border-radius: 20px 20px 0 0 !important;
}

.modal-title {
    color: #ffffff !important;
    font-weight: 600 !important;
    text-shadow: 0 0 15px rgba(64, 224, 255, 0.5);
}

.modal-body {
    background: transparent !important;
    color: #ffffff;
}

.modal-footer {
    border-top: 2px solid #40E0FF !important;
    background: rgba(15, 52, 96, 0.5) !important;
}

.close {
    color: #ffffff !important;
    text-shadow: 0 0 15px rgba(64, 224, 255, 0.5);
    opacity: 1 !important;
}

/* ========================================
   12. FORMULARIOS
   ======================================== */

.form-control {
    background: rgba(22, 33, 62, 0.5) !important;
    border: 2px solid #40E0FF !important;
    color: #ffffff !important;
    border-radius: 10px !important;
}

.form-control:focus {
    box-shadow: 0 0 20px rgba(64, 224, 255, 0.5) !important;
    border-color: #00D9FF !important;
    background: rgba(22, 33, 62, 0.7) !important;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.5) !important;
}

/* ========================================
   13. ALERTAS (CAMAS/ESTADOS)
   ======================================== */

.alert {
    border-radius: 15px !important;
    border: 2px solid !important;
    font-weight: 600;
    text-align: center;
    padding: 15px;
    transition: all 0.3s ease;
}

.alert-success {
    background: linear-gradient(135deg, #0f6040 0%, #16a162 100%) !important;
    border-color: #40FFE0 !important;
    color: white !important;
}

.alert-success:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(64, 255, 224, 0.4);
}

.alert-danger {
    background: linear-gradient(135deg, #8B0000 0%, #B22222 100%) !important;
    border-color: #FF4444 !important;
    color: white !important;
}

.alert-danger:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(255, 68, 68, 0.4);
}

.alert-warning {
    background: linear-gradient(135deg, #FF8C00 0%, #FFA500 100%) !important;
    border-color: #FFD700 !important;
    color: white !important;
}

.alert-warning:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(255, 215, 0, 0.4);
}

/* Alerta especial cyan */
.alert[style*="background-color: #00CDFF"] {
    background: linear-gradient(135deg, #0099CC 0%, #00CDFF 100%) !important;
    border-color: #40E0FF !important;
}

/* ========================================
   14. FOOTER
   ======================================== */

.main-footer {
    background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
    border-top: 2px solid #40E0FF !important;
    color: #ffffff !important;
    box-shadow: 0 -4px 20px rgba(64, 224, 255, 0.2);
}

/* ========================================
   15. ANIMACIONES
   ======================================== */

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.5;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
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

@keyframes glow {
    0%, 100% {
        box-shadow: 0 0 20px rgba(64, 224, 255, 0.3);
    }
    50% {
        box-shadow: 0 0 40px rgba(64, 224, 255, 0.6);
    }
}

/* Aplicar animaciones */
.card {
    animation: fadeInUp 0.8s ease-out backwards;
}

.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
.card:nth-child(4) { animation-delay: 0.4s; }
.card:nth-child(5) { animation-delay: 0.5s; }
.card:nth-child(6) { animation-delay: 0.6s; }
.card:nth-child(7) { animation-delay: 0.7s; }
.card:nth-child(8) { animation-delay: 0.8s; }
.card:nth-child(9) { animation-delay: 0.9s; }

.col-lg-4,
.col-lg-6 {
    animation: fadeInUp 0.8s ease-out backwards;
}

.col-lg-4:nth-child(1),
.col-lg-6:nth-child(1) { animation-delay: 0.1s; }
.col-lg-4:nth-child(2),
.col-lg-6:nth-child(2) { animation-delay: 0.2s; }
.col-lg-4:nth-child(3),
.col-lg-6:nth-child(3) { animation-delay: 0.3s; }
.col-lg-4:nth-child(4) { animation-delay: 0.4s; }
.col-lg-4:nth-child(5) { animation-delay: 0.5s; }
.col-lg-4:nth-child(6) { animation-delay: 0.6s; }

/* ========================================
   16. SCROLLBAR PERSONALIZADO
   ======================================== */

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

/* ========================================
   17. RESPONSIVE
   ======================================== */

@media screen and (max-width: 980px) {
    .container {
        width: 610px;
        margin-left: -20px;
    }

    .alert {
        padding: 10px;
        font-size: 0.9rem;
    }

    .card h3, .card h4 {
        font-size: 0.9rem !important;
    }
}

@media screen and (max-width: 768px) {
    .card h3, .card h4 {
        font-size: 0.9rem !important;
    }

    .icon-circle,
    .card-img-top {
        width: 100px !important;
        height: 100px !important;
    }

    .card .fa {
        font-size: 40px !important;
    }

    .breadcrumb {
        padding: 15px 20px !important;
    }

    .breadcrumb h4 {
        font-size: 1.1rem;
        letter-spacing: 1px;
    }
}

@media screen and (max-width: 576px) {
    .icon-circle,
    .card-img-top {
        width: 80px !important;
        height: 80px !important;
    }

    .card .fa {
        font-size: 32px !important;
    }

    .card h3, .card h4 {
        font-size: 0.8rem !important;
    }
}

/* ========================================
   18. UTILIDADES
   ======================================== */

/* Efectos de hover adicionales */
.card:hover {
    animation: glow 2s ease-in-out infinite;
}

/* Overlay oscuro para contenido */
.content-overlay {
    background: rgba(10, 10, 10, 0.8);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 20px;
    border: 2px solid #40E0FF;
}

/* Separador con efecto glow */
.divider-glow {
    height: 2px;
    background: linear-gradient(90deg, transparent, #40E0FF, transparent);
    margin: 30px 0;
    box-shadow: 0 0 20px rgba(64, 224, 255, 0.5);
}

/* Texto con efecto glow */
.text-glow {
    text-shadow: 0 0 20px rgba(64, 224, 255, 0.8);
    color: #40E0FF;
}

    </style>
</head>

<body class=" hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <!-- <img src="dist/img/logo.jpg" alt="logo">-->
      <?php
      if ($usuario['id_rol'] == 2) {
      ?>

        <a href="menu_medico.php" class="logo">

          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><img src="../imagenes/SI.PNG" height="30" width="120"></b></span>
        </a>
      <?php
      } else if ($usuario['id_rol'] == 5) {

      ?>
        <a href="menu_gerencia.php" class="logo">

          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><img src="../imagenes/SI.PNG" height="30" width="120"></b></span>
        </a>
        <?php }elseif($usuario['id_rol'] == 12) { ?>
         <a href="menu_residente.php" class="logo">

          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><img src="../imagenes/SI.PNG" height="30" width="120"></b></span>
        </a>

      <?php
      } else {
        //session_unset();
        session_destroy();
        echo "<script>window.Location='../index.php';</script>";
      }
      ?>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>



        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <!--<div class="col-2"><br>
    <div class="dropdown">
        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <?php //echo $usuario['nombre'];
    ?> <?php //echo $usuario['papell'];
        ?> <?php //echo $usuario['sapell'];
            ?>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <center><img src="imagenes/logo.jpg" height="45" class="rounded"></center><hr>
      <a class="dropdown-item">ID: <?php //echo $usuario['id_usua'];
                                    ?></a>
      <a class="dropdown-item">Matricula: <?php //echo $usuario['mat'];
                                          ?></a>
      <hr>
    <center><a class="btn btn-danger col-12" href="cerrar_sesion.php">Cerrar sesión</a></center>

  </div>
</div>
    </div>-->



            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="user-image" alt="User Image">
                <span class="hidden-xs"> <?php echo $usuario['nombre']; ?> <?php echo $usuario['papell']; ?> <?php echo $usuario['sapell']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">

                  <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="img-circle" alt="User Image">

                  <p>
                    <?php echo $usuario['nombre']; ?> <?php echo $usuario['papell']; ?> <?php echo $usuario['sapell']; ?>

                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                  </div>
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
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">


            <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $usuario['nombre']; ?> <?php echo $usuario['papell']; ?></p>

            <a href="#"><i class="fa fa-circle text-success"></i> ACTIVO</a>
          </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="treeview">

              <?php
              if (isset($_SESSION['hospital'])) {
              ?>
                <li><a href="../gestion_medica/cartas_consentimientos/consent_lista.php"><i class="fa fa-print" ></i>IMPRIMIR DOCUMENTOS</a></li>
              <?php
              } else {
              ?>
                <li><a href="select_pac_hosp.php"><i class="fa fa-print" ></i>IMPRIMIR DOCUMENTOS</a></li>
              <?php
              }
              ?>

          </li>




           <?php
          if (isset($_SESSION['hospital'])) {
          ?>
           <li class="treeview">
                <a href="../historia_clinica/h_clinica.php">
                   <i class="fa fa-address-book" aria-hidden="true"></i> <span><font size ="2">HISTORIA CLÍNICA</font></span>
                </a>

            </li>

           <li class="treeview">
              <a href="#">
                <i class="fa fa-stethoscope"></i> <span>NOTAS MÉDICAS</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">


                <li><a href="../gestion_medica/hospitalizacion/nota_ingreso.php">
                   <i class="fa fa-bed" aria-hidden="true"></i> NOTA DE INGRESO</a></li>
                <li><a href="../gestion_medica/hospitalizacion/vista_nota_evolucion.php">
                   <i class="fa fa-address-card" aria-hidden="true"></i> NOTA DE EVOLUCIÓN</a></li>

                <li><a href="../gestion_medica/hospitalizacion/nota_interconsulta.php">
                   <i class="fa fa-hospital-o" aria-hidden="true"></i> NOTA INTERCONSULTA</a></li>
                <li><a href="../gestion_medica/hospitalizacion/nota_translado.php">
                   <i class="fa fa-ambulance" aria-hidden="true"></i> NOTA REFERENCIA/TRASLADO</a></li>
                <li><a href="../gestion_medica/hospitalizacion/nota_neonatologica.php">
                   <i class="fas fa-baby"></i> NOTA NEONATOLÓGICA</a></li>
                <li><a href="../gestion_medica/hospitalizacion/partograma.php">
                   <i class="fa fa-female"></i> NOTA PARTOGRAMA</a></li>

                <li><a href="../gestion_medica/hospitalizacion/nota_posparto.php">
                   <i class="fa fa-female"></i> NOTA POST-PARTO</a></li>

                <li><a href="../gestion_medica/hospitalizacion/vista_de_transfuciones.php">
                   <i class="fa fa-angle-double-right" aria-hidden="true"></i> NOTA DE TRANSFUSIÓN </a></li>
                <li><a href="../gestion_medica/hospitalizacion/nota_egreso.php">
                   <i class="fa fa-check-square" aria-hidden="true"></i> NOTA DE EGRESO</a></li>


        <!-- NOTAS QUIRÚRGICAS-->
                <li><center><strong>QUIRÚRGICAS</strong></center></li>
                <li><a href="../gestion_medica/quirurgico/nota_preoperatoria.php">
                   <i class="fa fa-bed" aria-hidden="true"></i> PRE-OPERATORIA </a></li>
                <li><a href="../gestion_medica/quirurgico/nota_cirugia_segura.php">
                   <i class="fa fa-medkit" aria-hidden="true"></i> CIRUGÍA SEGURA</a></li>
                <li><a href="../gestion_medica/quirurgico/nota_postoperatoria.php">
                   <i class="fa fa-plus-square" aria-hidden="true"></i> POST-OPERATORIA</a></li>
                <li><a href="../gestion_medica/quirurgico/nota_intervencion_quirurgica.php">
                   <i class="fa fa-user-md" aria-hidden="true"></i> DESCRIPCIÓN INTERVENCIÓN <br> QUIRÚRGICA</a></li>

        <!-- NOTAS ANESTÉSICAS-->
                 <li class="treeview">
                    <a href="#">
                       <i class="fa fa-stethoscope"></i> <span>NOTAS ANESTÉSICAS</span>
                       <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                       <li><a href="../gestion_medica/nota_anestesica/nota_anestesica.php"><i class="fa fa-circle"></i> PRE-ANESTÉSICA</a></li>
                       <li><a href="../gestion_medica/nota_anestesica/nota_2da_evaluacion.php"><i class="fa fa-circle"></i>EVALUACIÓN <br> PRE-ANESTÉSICA</a></li>
                       <li><a href="../gestion_medica/nota_anestesica/nota_registro_descriptivo.php">
                        <i class="fa fa-circle"></i> REGISTRO DESCRIPTIVO <br> TRANS-ANESTÉSICO</a></li>
                       <li><a href="../gestion_medica/nota_anestesica/nota_unidad_cuidados.php"><i class="fa fa-circle"></i> CUIDADOS <br>POST ANESTÉSICOS<br>(NOTA DE RECUPERACIÓN)</a></li>
                       <li><a href="../gestion_medica/nota_anestesica/nota_post_anestesica.php"><i class="fa fa-circle"></i>  POST-ANESTÉSICA</a></li>
                    </ul>
                 </li>
               </ul>
            </li>

            <li class="treeview">

              <?php
              if (isset($_SESSION['hospital'])) {
              ?>
                <li><a href="../gestion_medica/hospitalizacion/recetario_medico.php"><i class="fa fa-files-o"></i>RECETA HOSPITALIZACIÓN</a></li>
              <?php
              } else {
              ?>
                <li><a href="select_pac_hosp.php"><i class="fa fa-files-o"></i>RECETA HOSPITALIZACIÓN</a></li>
              <?php
              }
              ?>

          </li>

            <li class="treeview">
                <a href="../gestion_medica/hospitalizacion/signos_vitales.php">
                  <i class="fa fa-heartbeat" aria-hidden="true"></i> <span>VISUALIZAR SIGNOS VITALES</span>
                </a>

            </li>

             <li class="treeview">
                <a href="../gestion_medica/hospitalizacion/ordenes_medico_form.php">
                  <i class="fa fa-files-o" aria-hidden="true"></i> <span>INDICACIONES MÉDICAS</span>
                </a>

            </li>


            <li class="treeview">
                <a href="../gestion_medica/estudios/estudios.php">
                   <i class="fa fa-flask" aria-hidden="true"></i> <span>RESULTADO DE ESTUDIOS</span>
                </a>
            </li>

            <li class="treeview">
                <a href="../gestion_medica/hospitalizacion/hoja_alta_medica.php">
                   <i class="fa fa-street-view" aria-hidden="true"></i> <span>AVISO DE ALTA MÉDICA</span>
                </a>
            </li>


          <li class="treeview">
              <a href="../gestion_medica/selectpac_sincama/select_pac.php">
                <i class="fa fa-print" aria-hidden="true"></i> <span>SELECCIONAR <br>OTROS PACIENTES</span>
              </a>
          </li>


      <?php

}else {
 ?>

           <li class="treeview">
                <a href="select_pac_hosp.php">
                   <i class="fa fa-folder" aria-hidden="true"></i> <span>HISTORIA CLÍNICA</span>
                </a>

            </li>


            <li class="treeview">
              <a href="#">
               <i class="fa fa-stethoscope"></i> <span>NOTAS MÉDICAS</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">

                 <li><a href="select_pac_hosp.php">
                   <i class="fa fa-bed" aria-hidden="true"></i> NOTA DE INGRESO</a></li>
                <li><a href="select_pac_hosp.php">
                   <i class="fa fa-address-card" aria-hidden="true"></i> NOTA DE EVOLUCIÓN</a></li>
                <li><a href="select_pac_hosp.php">
                     <i class="fa fa-female"></i> NOTA POST-PARTO</a></li>
                <li><a href="select_pac_hosp.php">
                     <i class="fa fa-hospital-o" aria-hidden="true"></i> NOTA INTERCONSULTA</a></li>
                <li><a href="select_pac_hosp.php">
                     <i class="fa fa-ambulance" aria-hidden="true"></i> NOTA REFERENCIA/TRASLADO</a></li>
                <li><a href="select_pac_hosp.php">
                      <i class="fas fa-baby"></i> NOTA NEONATOLÓGICA</a></li>
                <li><a href="select_pac_hosp.php">
                     <i class="fa fa-female"></i> NOTA PARTOGRAMA</a></li>
                <li><a href="select_pac_hosp.php">
                     <i class="fa fa-angle-double-right" aria-hidden="true"></i> NOTA DE TRANSFUSIÓN </a></li>
                <li><a href="select_pac_hosp.php">
                     <i class="fa fa-check-square" aria-hidden="true"></i> NOTA DE EGRESO</a></li>
          <!-- NOTAS QUIRÚRGICAS-->
                <li><center><strong>QUIRÚRGICAS</strong></center></li>
                <li><a href="select_pac_hosp.php">
                   <i class="fa fa-bed" aria-hidden="true"></i> PRE-OPERATORIA </a></li>
                <li><a href="select_pac_hosp.php">
                   <i class="fa fa-medkit" aria-hidden="true"></i> CIRUGÍA SEGURA</a></li>
                <li><a href="select_pac_hosp.php">
                   <i class="fa fa-plus-square" aria-hidden="true"></i> POST-OPERATORIA</a></li>
               <li><a href="select_pac_hosp.php">
                   <i class="fa fa-user-md" aria-hidden="true"></i> DESCRIPCIÓN INTERVENCIÓN <br> QUIRÚRGICA</a></li>

        <!-- NOTAS ANESTÉSICAS-->
                 <li class="treeview">
                    <a href="#">
                       <i class="fa fa-stethoscope"></i> <span>NOTAS ANESTÉSICAS</span>
                       <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                       <li><a href="select_pac_hosp.php"><i class="fa fa-circle"></i> PRE-ANESTÉSICA</a></li>
                       <li><a href="select_pac_hosp.php"><i class="fa fa-circle"></i> EVALUACIÓN <br> PRE-ANESTÉSICA</a></li>
                       <li><a href="select_pac_hosp.php"><i class="fa fa-circle"></i> REGISTRO DESCRIPTIVO <br> TRANS-ANESTÉSICO</a></li>
                       <li><a href="select_pac_hosp.php"><i class="fa fa-circle"></i> CUIDADOS <br>POST ANESTÉSICOS<br>(NOTA DE RECUPERACIÓN)</a></li>
                       <li><a href="select_pac_hosp.php"><i class="fa fa-circle"></i> POST-ANESTÉSICA</a></li>
                   </ul>
               </li>
              </ul>

            </li>

            <li class="treeview">
                <a href="select_pac_hosp.php">
                  <i class="fa fa-files-o"></i>  <span> RECETA HOSPITALIZACIÓN</span>
                </a>
            </li>

            <li class="treeview">
                <a href="select_pac_hosp.php">
                   <i class="fa fa-heartbeat" aria-hidden="true"></i> <span>VISUALIZAR SIGNOS VITALES</span>
                </a>
            </li>

            <li class="treeview">
                <a href="select_pac_hosp.php">
                   <i class="fa fa-files-o" aria-hidden="true"></i> <span>INDICACIONES MÉDICAS</span>
                </a>
            </li>

            <li class="treeview">
                <a href="select_pac_hosp.php">
                  <i class="fa fa-flask" aria-hidden="true"></i> <span>RESULTADO DE ESTUDIOS</span>
                </a>
            </li>

             <li class="treeview">
                <a href="select_pac_hosp.php">
                   <i class="fa fa-street-view" aria-hidden="true"></i> <span>AVISO DE ALTA MÉDICA</span>
                </a>
            </li>


          <li class="treeview">
              <a href="select_pac_hosp.php">
                <i class="fa fa-print" aria-hidden="true"></i> <span>SELECCIONAR <br>OTROS PACIENTES</span>
              </a>
          </li>




          <?php
          }
          ?>




        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <!--AQUI VA QUE PUESTO TIENE-->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page"><STRONG>
              <h4>PANEL DEL MÉDICO</h4>
            </STRONG></li>
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
                                window.location.href = "menu_medico.php";
                            }
                        });
                    });
                </script>

<div class="container">
                    <div class="row">

                        <?php
            if ($usuario['id_rol'] == 5 || $usuario['id_rol'] == 2 || $usuario['id_rol'] == 12) {

            ?>
<br>
                        <div class="col-sm-3">
                            <a href="../gestion_medica/selectpac_sincama/select_pac.php"><button type="button"
                                    class="btn btn-default">PACIENTES ANTENDIDOS <i
                                        class="fa fa-user"></i></button></a>
                        </div>

                        <?php
            } else {
              //session_unset();
              session_destroy();
              echo "<script>window.Location='../index.php';</script>";
            }
            ?>

                    </div>
                </div>

                <hr>


<div class="thead" style=" color: black; font-size: 20px;">
                <strong>PACIENTES EN CONSULTA EXTERNA</strong><p>
            </div>
                <p></p>

            <div class="container box">
                    <div class="row">


                        <?php
            $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=1 and seccion=1 ORDER BY num_cama ASC';
            $result = $conexion->query($sql);
            //  $id_atencion = $_GET['id_atencion'];
            while ($row = $result->fetch_assoc()) {
              $num_cama = $row['num_cama'];
              $id_atencion = $row['id_atencion'];
              $estaus = $row['estatus'];
              if ($estaus == "LIBRE") {
            ?>
                        <div class="ancholi">
                            <div class="alert alert ancholi2" role="alert"
                                    style="background-color: lightgrey; color:white;">
                                <div><a href="#" class="small-box-footer"><i style="font-size:18px;"
                                            class="fa fa-eye"></i></a>
                                    <h7>
                                        <font size="2"><?php echo $num_cama ?> </font>
                                    </h7>
                                </div>
                                <div>
                                    <h7>
                                        <font size="2"><?php echo $estaus ?></font>
                                    </h7>
                                </div><br><br>
                            </div>
                        </div>
                        <?php
              } elseif ($estaus == "MANTENIMIENTO") {
                $esta = "NO DISPONIBLE";
              ?>
                         <div class="ancholi">
                            <div class="alert alert-danger ancholi2" role="alert">
                                <!-- <a href="../enfermera/censo/edita_cama.php?id=<?php echo $row['id'] ?>" class="small-box-footer">--><i
                                    style="font-size:18px;" class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="2"><?php echo $num_cama ?> <br>
                                        <h7>
                                            <font size="2" class="nod"><?php echo $esta ?></font>
                                        </h7>
                                    </font>
                                </h7>
                                <br><br><br>
                            </div>
                        </div>
                        <?php
              } elseif ($estaus == "EN PROCESO DE LIBERACION" or $estaus == "EN PROCESO DE LIBERA") {
                $pr = "POR LIBERAR";
              ?>
                        <div class="ancholi">
                            <div class="alert alert-warning ancholi2">
                                <a href="#" class="small-box-footer"><i style="font-size:18px;"
                                        class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="2"><?php echo $num_cama ?></font>
                                </h7>
                                <br>
                                <h7>
                                    <font size="1"><?php echo $pr ?></font>
                                </h7>
                                <br><br>
                                <br>
                            </div>
                        </div>
                        <?php
              } else {
              ?>
                        <?php
                $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp,di.id_usua,di.id_usua2,di.id_usua3,di.id_usua4,di.id_usua5 from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp  order by di.fecha DESC";
                $result_pac = $conexion->query($sql_pac);
                while ($row_cam = $result_pac->fetch_assoc()) {
                  $nombre_pac = $row_cam['papell'] . ' ' . $row_cam['nom_pac'];
                  $id_exp = $row_cam['Id_exp'];
                  $id_usua1 = $row_cam['id_usua'];

                  $id_usua2 = $row_cam['id_usua2'];
                  $id_usua3 = $row_cam['id_usua3'];
                  $id_usua4 = $row_cam['id_usua4'];
                  $id_usua5 = $row_cam['id_usua5'];
                }
                ?>
                        <a href="../gestion_medica/hospitalizacion/select_pac.php?id_atencion=<?php echo $id_atencion ?>&id_exp=<?php echo $id_exp ?>&usuareg=<?php echo $usuario['id_usua'] ?>&usuapac=<?php echo $id_usua1 ?>&usuareg2=<?php echo $id_usua2 ?>&usuareg3=<?php echo $id_usua3 ?>&usuareg4=<?php echo $id_usua4 ?>&usuareg5=<?php echo $id_usua5 ?>"
                            class="small-box-footer">
                            <div class="ancholi">
                                <div class="alert alert ancholi2" role="alert"
                                    style="background-color: #D4F0FC; color:black;">

                                    <i style="font-size:18px;" class="fa fa-eye"></i>

                                    <h7>
                                        <font size="2"><?php echo $num_cama ?></font>
                                    </h7>
                                    <!--  <h7>Estatus: OCUPADA</h7>-->

                                    <?php
                      $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp,di.id_usua,di.id_usua2,di.id_usua3,di.id_usua4,di.id_usua5 from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp and alta_adm='NO' order by di.fecha DESC";
                      $result_pac = $conexion->query($sql_pac);
                      while ($row_cam = $result_pac->fetch_assoc()) {
                        $nombre_pac = $row_cam['nom_pac'];
                        $papell = $row_cam['papell'];
                        $id_exp = $row_cam['Id_exp'];
                        $id_usua1 = $row_cam['id_usua'];

                        $id_usua2 = $row_cam['id_usua2'];
                        $id_usua3 = $row_cam['id_usua3'];
                        $id_usua4 = $row_cam['id_usua4'];
                        $id_usua5 = $row_cam['id_usua5'];
                      }
                      ?>
                                    <br>
                                    <h7 class="nompac"><?php echo $papell ?></h7><br>
                                    <h7 class="nompac"><?php echo $nombre_pac ?></h7>
                                    <br><br>

                                </div>
                            </div>
                        </a>
                        <?php
              }
            }
            ?>


                        <?php
            $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=1 and seccion=2 ORDER BY num_cama ASC';
            $result = $conexion->query($sql);
            //  $id_atencion = $_GET['id_atencion'];
            while ($row = $result->fetch_assoc()) {
              $num_cama = $row['num_cama'];
              $id_atencion = $row['id_atencion'];
              $estaus = $row['estatus'];
              if ($estaus == "LIBRE") {
            ?>
                        <div class="col-lg-1.5 col-xs-1">
                            <div class="alert alert-success" role="alert">
                                <a href="#" class="small-box-footer"><i style="font-size:25px;"
                                        class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="3"><?php echo $num_cama ?></font>
                                </h7>
                                <br>
                                <h7>
                                    <font size="2"><?php echo $estaus ?></font>
                                </h7>
                                <br>
                                <br>
                            </div>
                        </div>
                        <?php
              } elseif ($estaus == "MANTENIMIENTO") {
                $esta = "NO DISPONIBLE";
              ?>
                        <div class="col-lg-1.5 col-xs-1">
                            <div class="alert alert-danger" role="alert">
                                <a href="#" class="small-box-footer"><i style="font-size:20px;"
                                        class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="3"><?php echo $num_cama ?></font>
                                </h7>
                                <br>
                                <h7>
                                    <font size="2"><?php echo $esta ?></font>
                                </h7>
                                <br>

                            </div>
                        </div>
                        <?php
              } else {
              ?>
                        <?php
                $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp,di.id_usua,di.id_usua2,di.id_usua3,di.id_usua4,di.id_usua5  from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp and alta_adm='NO' order by di.id_atencion DESC";
                $result_pac = $conexion->query($sql_pac);
                while ($row_cam = $result_pac->fetch_assoc()) {
                  $nombre_pac = $row_cam['papell'] . ' ' . $row_cam['nom_pac'];
                  $id_exp = $row_cam['Id_exp'];
                  $id_usua1 = $row_cam['id_usua'];
                  $id_usua2 = $row_cam['id_usua2'];
                  $id_usua3 = $row_cam['id_usua3'];
                  $id_usua4 = $row_cam['id_usua4'];
                  $id_usua5 = $row_cam['id_usua5'];
                }
                ?>
                        <a href="../gestion_medica/hospitalizacion/select_pac.php?id_atencion=<?php echo $id_atencion ?>&id_exp=<?php echo $id_exp ?>&usuareg=<?php echo $usuario['id_usua'] ?>&usuapac=<?php echo $id_usua1 ?>&usuareg2=<?php echo $id_usua2 ?>&usuareg3=<?php echo $id_usua3 ?>&usuareg4=<?php echo $id_usua4 ?>&usuareg5=<?php echo $id_usua5 ?>"
                            class="small-box-footer">
                            <div class="col-lg-1.5 col-xs-1">
                                <div class="alert alert-danger" role="alert">

                                    <i style="font-size:25px;" class="fa fa-eye"></i>

                                    <h7>
                                        <font size="3"><?php echo $num_cama ?></font>
                                    </h7><br>
                                    <!--  <h7>Estatus: OCUPADA</h7>-->
                                    <?php
                      $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp,di.id_usua,di.id_usua2,di.id_usua3,di.id_usua4,di.id_usua5 from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp";
                      $result_pac = $conexion->query($sql_pac);
                      while ($row_cam = $result_pac->fetch_assoc()) {
                        $nombre_pac = $row_cam['papell'] . ' ' . $row_cam['nom_pac'];
                        $id_usua1 = $row_cam['id_usua'];
                        $id_exp = $row_cam['Id_exp'];
                        $id_usua2 = $row_cam['id_usua2'];
                        $id_usua3 = $row_cam['id_usua3'];
                        $id_usua4 = $row_cam['id_usua4'];
                        $id_usua5 = $row_cam['id_usua5'];
                      }
                      ?>
                                    <font size="2"><?php echo $nombre_pac ?></font>
                                    <br />

                                </div>
                            </div>
                        </a>
                        <?php
              }
            }
            ?>
                    </div>
                </div>

            <div class="thead" style=" color: black; font-size: 20px;">
                <strong>PACIENTES EN PREPARACIÓN</strong><p>
            </div>

            <div class="container box col-12">
                    <div class="row">

                        <?php
            $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=2 and seccion=1 ORDER BY num_cama ASC';
            $result = $conexion->query($sql);
            //  $id_atencion = $_GET['id_atencion'];
            while ($row = $result->fetch_assoc()) {
              $num_cama = $row['num_cama'];
              $id_atencion = $row['id_atencion'];
              $estaus = $row['estatus'];
              if ($estaus == "LIBRE") {
            ?>
                        <div class="ancholi">
                            <div class="alert alert ancholi2" role="alert"
                                    style="background-color: lightgrey; color:white;">
                                <div><a href="#" class="small-box-footer"><i style="font-size:18px;"
                                            class="fa fa-eye"></i></a>
                                    <h7>
                                        <font size="2"><?php echo $num_cama ?> </font>
                                    </h7>
                                </div>
                                <div>
                                    <h7>
                                        <font size="2"><?php echo $estaus ?></font>
                                    </h7>
                                </div><br><br>
                            </div>
                        </div>
                        <?php
              } elseif ($estaus == "MANTENIMIENTO") {
                $esta = "NO DISPONIBLE";
              ?>
                        <div class="ancholi">
                            <div class="alert alert-danger ancholi2" role="alert">
                                <!-- <a href="../enfermera/censo/edita_cama.php?id=<?php echo $row['id'] ?>" class="small-box-footer">--><i
                                    style="font-size:18px;" class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="2"><?php echo $num_cama ?> <br>
                                        <h7>
                                            <font size="2" class="nod"><?php echo $esta ?></font>
                                        </h7>
                                    </font>
                                </h7>
                                <br><br><br>
                            </div>
                        </div>
                        <?php
              } elseif ($estaus == "EN PROCESO DE LIBERACION" or $estaus == "EN PROCESO DE LIBERA") {
                $pr = "POR LIBERAR";
              ?>
                        <div class="ancholi">
                            <div class="alert alert-warning ancholi2" role="alert">
                                <a href="#" class="small-box-footer"><i style="font-size:18px;"
                                        class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="2"><?php echo $num_cama ?></font>
                                </h7>
                                <br>
                                <h7>
                                    <font size="1"><?php echo $pr ?></font>
                                </h7>
                                <br><br>
                                <br>
                            </div>
                        </div>
                        <?php
              } else {
              ?>
                        <?php
                $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp,di.id_usua,di.id_usua2,di.id_usua3,di.id_usua4,di.id_usua5 from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp";
                $result_pac = $conexion->query($sql_pac);
                while ($row_cam = $result_pac->fetch_assoc()) {
                  $nombre_pac = $row_cam['papell'] . ' ' . $row_cam['nom_pac'];
                  $id_usua1 = $row_cam['id_usua'];

                  $id_usua2 = $row_cam['id_usua2'];
                  $id_usua3 = $row_cam['id_usua3'];
                  $id_usua4 = $row_cam['id_usua4'];
                  $id_usua5 = $row_cam['id_usua5'];
                }
                ?>
                        <a href="../gestion_medica/hospitalizacion/select_pac.php?id_atencion=<?php echo $id_atencion ?>&usuareg=<?php echo $usuario['id_usua'] ?>&usuapac=<?php echo $id_usua1 ?>&usuareg2=<?php echo $id_usua2 ?>&usuareg3=<?php echo $id_usua3 ?>&usuareg4=<?php echo $id_usua4 ?>&usuareg5=<?php echo $id_usua5 ?>"
                            class="small-box-footer">
                            <div class="ancholi">
                                <div class="alert alert ancholi2" role="alert"
                                    style="background-color: #D4F0FC; color:black;">

                                    <i style="font-size:18px;" class="fa fa-eye"></i>

                                    <h7>
                                        <font size="2"><?php echo $num_cama ?></font>
                                    </h7>
                                    <!--  <h7>Estatus: OCUPADA</h7>-->
                                    <?php
                      $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp,di.id_usua,di.id_usua2,di.id_usua3,di.id_usua4,di.id_usua5 from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp";
                      $result_pac = $conexion->query($sql_pac);
                      while ($row_cam = $result_pac->fetch_assoc()) {
                        $nombre_pac = $row_cam['nom_pac'];
                        $papell = $row_cam['papell'];
                        $id_exp = $row_cam['Id_exp'];
                        $id_usua1 = $row_cam['id_usua'];
                        $id_usua2 = $row_cam['id_usua2'];
                        $id_usua3 = $row_cam['id_usua3'];
                        $id_usua4 = $row_cam['id_usua4'];
                        $id_usua5 = $row_cam['id_usua5'];
                      }
                      ?>
                                    <br>
                                    <h7 class="nompac"><?php echo $papell ?></h7><br>
                                    <h7 class="nompac"><?php echo $nombre_pac ?></h7>
                                    <br><br>
                                </div>
                            </div>
                        </a>
                        <?php
              }
            }
            ?>

                        <?php
            $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=2 and seccion=2 ORDER BY num_cama ASC';
            $result = $conexion->query($sql);
            //  $id_atencion = $_GET['id_atencion'];
            while ($row = $result->fetch_assoc()) {
              $num_cama = $row['num_cama'];
              $id_atencion = $row['id_atencion'];
              $estaus = $row['estatus'];
              if ($estaus == "LIBRE") {
            ?>
                        <div class="col-lg-1.5 col-xs-1">
                            <div class="alert alert-success" role="alert">
                                <a href="#" class="small-box-footer"><i style="font-size:25px;"
                                        class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="3"><?php echo $num_cama ?></font>
                                </h7>
                                <br>
                                <h7>
                                    <font size="2"><?php echo $estaus ?></font>
                                </h7>
                                <br>
                                <br>
                            </div>
                        </div>
                        <?php
              } elseif ($estaus == "MANTENIMIENTO") {
                $esta = "NO DISPONIBLE";
              ?>
                        <div class="col-lg-1.5 col-xs-1">
                            <div class="alert alert-warning" role="alert">
                                <a href="#" class="small-box-footer"><i style="font-size:20px;"
                                        class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="3"><?php echo $num_cama ?></font>
                                </h7>
                                <br>
                                <h7>
                                    <font size="2" class="nod"><?php echo $esta ?></font>
                                </h7>
                                <br>

                            </div>
                        </div>
                        <?php
              } else {
              ?>
                        <a href="../gestion_medica/hospitalizacion/select_pac.php?id_atencion=<?php echo $id_atencion ?>&usuareg=<?php echo $usuario['id_usua'] ?>&usuapac=<?php echo $id_usua1 ?>&usuareg2=<?php echo $id_usua2 ?>&usuareg3=<?php echo $id_usua3 ?>&usuareg4=<?php echo $id_usua4 ?>&usuareg5=<?php echo $id_usua5 ?>"
                            class="small-box-footer">
                            <div class="col-lg-1.5 col-xs-1">
                                <div class="alert alert-danger" role="alert">

                                    <i style="font-size:25px;" class="fa fa-eye"></i>

                                    <h7>
                                        <font size="3"><?php echo $num_cama ?></font>
                                    </h7><br>
                                    <!--  <h7>Estatus: OCUPADA</h7>-->
                                    <?php
                      $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp";
                      $result_pac = $conexion->query($sql_pac);
                      while ($row_cam = $result_pac->fetch_assoc()) {
                        $nombre_pac = $row_cam['papell'] . ' ' . $row_cam['nom_pac'];
                      }
                      ?>
                                    <font size="2" class="nompac"><?php echo $nombre_pac ?></font>
                                    <br />

                                </div>
                            </div>
                        </a>
                        <?php
              }
            }
            ?>
                    </div>
                </div>

           <div class="thead" style=" color: black; font-size: 20px;">
                <strong>PACIENTES EN RECUPERACIÓN</strong><p>
            </div>

            <div class="container box col-12">
                    <div class="row">

                        <?php
            $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=3 and seccion=1 ORDER BY num_cama ASC';
            $result = $conexion->query($sql);
            //  $id_atencion = $_GET['id_atencion'];
            while ($row = $result->fetch_assoc()) {
              $num_cama = $row['num_cama'];
              $id_atencion = $row['id_atencion'];
              $estaus = $row['estatus'];
              if ($estaus == "LIBRE") {
            ?>
                        <div class="ancholi">
                            <div class="alert alert ancholi2" role="alert"
                                    style="background-color: lightgrey; color:white;">
                                <div><a href="#" class="small-box-footer"><i style="font-size:18px;"
                                            class="fa fa-eye"></i></a>
                                    <h7>
                                        <font size="2"><?php echo $num_cama ?> </font>
                                    </h7>
                                </div>
                                <div>
                                    <h7>
                                        <font size="2"><?php echo $estaus ?></font>
                                    </h7>
                                </div><br><br>
                            </div>
                        </div>
                        <?php
              } elseif ($estaus == "MANTENIMIENTO") {
                $esta = "NO DISPONIBLE";
              ?>
                        <div class="ancholi">
                            <div class="alert alert-danger ancholi2" role="alert">
                                <!-- <a href="../enfermera/censo/edita_cama.php?id=<?php echo $row['id'] ?>" class="small-box-footer">--><i
                                    style="font-size:18px;" class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="2"><?php echo $num_cama ?> <br>
                                        <h7>
                                            <font size="2" class="nod"><?php echo $esta ?></font>
                                        </h7>
                                    </font>
                                </h7>
                                <br><br><br>
                            </div>
                        </div>
                        <?php
              } elseif ($estaus == "EN PROCESO DE LIBERACION" or $estaus == "EN PROCESO DE LIBERA") {
                $pr = "POR LIBERAR";
              ?>
                        <div class="ancholi">
                            <div class="alert alert-warning ancholi2" role="alert">
                                <a href="#" class="small-box-footer"><i style="font-size:18px;"
                                        class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="2"><?php echo $num_cama ?></font>
                                </h7>
                                <br>
                                <h7>
                                    <font size="1"><?php echo $pr ?></font>
                                </h7>
                                <br><br>
                                <br>
                            </div>
                        </div>
                        <?php
              } else {
              ?>
                        <?php
                $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp,di.id_usua,di.id_usua2,di.id_usua3,di.id_usua4,di.id_usua5 from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp";
                $result_pac = $conexion->query($sql_pac);
                while ($row_cam = $result_pac->fetch_assoc()) {
                  $nombre_pac = $row_cam['papell'] . ' ' . $row_cam['nom_pac'];
                  $id_usua1 = $row_cam['id_usua'];

                  $id_usua2 = $row_cam['id_usua2'];
                  $id_usua3 = $row_cam['id_usua3'];
                  $id_usua4 = $row_cam['id_usua4'];
                  $id_usua5 = $row_cam['id_usua5'];
                }
                ?>
                        <a href="../gestion_medica/hospitalizacion/select_pac.php?id_atencion=<?php echo $id_atencion ?>&usuareg=<?php echo $usuario['id_usua'] ?>&usuapac=<?php echo $id_usua1 ?>&usuareg2=<?php echo $id_usua2 ?>&usuareg3=<?php echo $id_usua3 ?>&usuareg4=<?php echo $id_usua4 ?>&usuareg5=<?php echo $id_usua5 ?>"
                            class="small-box-footer">
                            <div class="ancholi">
                                <div class="alert alert ancholi2" role="alert"
                                    style="background-color: #D4F0FC; color:black;">

                                    <i style="font-size:18px;" class="fa fa-eye"></i>

                                    <h7>
                                        <font size="2"><?php echo $num_cama ?></font>
                                    </h7>
                                    <!--  <h7>Estatus: OCUPADA</h7>-->
                                    <?php
                      $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp,di.id_usua,di.id_usua2,di.id_usua3,di.id_usua4,di.id_usua5 from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp";
                      $result_pac = $conexion->query($sql_pac);
                      while ($row_cam = $result_pac->fetch_assoc()) {
                        $nombre_pac = $row_cam['nom_pac'];
                        $papell = $row_cam['papell'];
                        $id_exp = $row_cam['Id_exp'];
                        $id_usua1 = $row_cam['id_usua'];
                        $id_usua2 = $row_cam['id_usua2'];
                        $id_usua3 = $row_cam['id_usua3'];
                        $id_usua4 = $row_cam['id_usua4'];
                        $id_usua5 = $row_cam['id_usua5'];
                      }
                      ?>
                                    <br>
                                    <h7 class="nompac"><?php echo $papell ?></h7><br>
                                    <h7 class="nompac"><?php echo $nombre_pac ?></h7>
                                    <br><br>
                                </div>
                            </div>
                        </a>
                        <?php
              }
            }
            ?>

                        <?php
            $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=2 and seccion=2 ORDER BY num_cama ASC';
            $result = $conexion->query($sql);
            //  $id_atencion = $_GET['id_atencion'];
            while ($row = $result->fetch_assoc()) {
              $num_cama = $row['num_cama'];
              $id_atencion = $row['id_atencion'];
              $estaus = $row['estatus'];
              if ($estaus == "LIBRE") {
            ?>
                        <div class="col-lg-1.5 col-xs-1">
                            <div class="alert alert-success" role="alert">
                                <a href="#" class="small-box-footer"><i style="font-size:25px;"
                                        class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="3"><?php echo $num_cama ?></font>
                                </h7>
                                <br>
                                <h7>
                                    <font size="2"><?php echo $estaus ?></font>
                                </h7>
                                <br>
                                <br>
                            </div>
                        </div>
                        <?php
              } elseif ($estaus == "MANTENIMIENTO") {
                $esta = "NO DISPONIBLE";
              ?>
                        <div class="col-lg-1.5 col-xs-1">
                            <div class="alert alert-warning" role="alert">
                                <a href="#" class="small-box-footer"><i style="font-size:20px;"
                                        class="fa fa-eye"></i></a>
                                <h7>
                                    <font size="3"><?php echo $num_cama ?></font>
                                </h7>
                                <br>
                                <h7>
                                    <font size="2" class="nod"><?php echo $esta ?></font>
                                </h7>
                                <br>

                            </div>
                        </div>
                        <?php
              } else {
              ?>
                        <a href="../gestion_medica/hospitalizacion/select_pac.php?id_atencion=<?php echo $id_atencion ?>&usuareg=<?php echo $usuario['id_usua'] ?>&usuapac=<?php echo $id_usua1 ?>&usuareg2=<?php echo $id_usua2 ?>&usuareg3=<?php echo $id_usua3 ?>&usuareg4=<?php echo $id_usua4 ?>&usuareg5=<?php echo $id_usua5 ?>"
                            class="small-box-footer">
                            <div class="col-lg-1.5 col-xs-1">
                                <div class="alert alert-danger" role="alert">

                                    <i style="font-size:25px;" class="fa fa-eye"></i>

                                    <h7>
                                        <font size="3"><?php echo $num_cama ?></font>
                                    </h7><br>
                                    <!--  <h7>Estatus: OCUPADA</h7>-->
                                    <?php
                      $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp";
                      $result_pac = $conexion->query($sql_pac);
                      while ($row_cam = $result_pac->fetch_assoc()) {
                        $nombre_pac = $row_cam['papell'] . ' ' . $row_cam['nom_pac'];
                      }
                      ?>
                                    <font size="2" class="nompac"><?php echo $nombre_pac ?></font>
                                    <br />

                                </div>
                            </div>
                        </a>
                        <?php
              }
            }
            ?>
                    </div>
            </div>

        </div>
    </div>

</section>


     <!-- </section> --><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
      <?php
      include("footer.php");
      ?>
    </footer>

  </div><!-- ./wrapper -->

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

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard2.js" type="text/javascript"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js" type="text/javascript"></script>




</body>

</html>
