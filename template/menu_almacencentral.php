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
if (!($usuario['id_rol'] == 11 || $usuario['id_rol'] == 5 || $usuario['id_rol'] == 4)) {
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
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Morris chart -->
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css"/>
    <!-- jvectormap -->
    <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css"/>
    <!-- Daterange picker -->
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>


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
        radial-gradient(circle at 80% 80%, rgba(64, 224, 255, 0.03) 0%, transparent 50%);
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
    color: #40E0FF !important;
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

/* Contenedor de imágenes/tarjetas */
.content.box {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
}

.row .col-lg-4,
.row .col-xs-6 {
    margin-bottom: 30px;
}

/* Efecto en las imágenes */
.card-img-top {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border-radius: 15px;
    border: 2px solid #40E0FF;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5),
                0 0 30px rgba(64, 224, 255, 0.2);
}

.card-img-top:hover {
    transform: translateY(-10px) scale(1.05);
    border-color: #00D9FF;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7),
                0 0 50px rgba(64, 224, 255, 0.5);
}

/* Títulos bajo las imágenes */
h3 {
    color: #ffffff !important;
    font-weight: 600 !important;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    text-shadow: 0 0 15px rgba(64, 224, 255, 0.5);
    transition: all 0.3s ease;
    text-align: center;
}

h3:hover {
    color: #40E0FF !important;
    text-shadow: 0 0 25px rgba(64, 224, 255, 0.8);
}

/* Animaciones de entrada */
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

.col-lg-4,
.col-xs-6 {
    animation: fadeInUp 0.8s ease-out backwards;
}

.col-lg-4:nth-child(1),
.col-xs-6:nth-child(1) { animation-delay: 0.1s; }
.col-lg-4:nth-child(2),
.col-xs-6:nth-child(2) { animation-delay: 0.2s; }
.col-lg-4:nth-child(3),
.col-xs-6:nth-child(3) { animation-delay: 0.3s; }
.col-lg-4:nth-child(4),
.col-xs-6:nth-child(4) { animation-delay: 0.4s; }
.col-lg-4:nth-child(5),
.col-xs-6:nth-child(5) { animation-delay: 0.5s; }
.col-lg-4:nth-child(6),
.col-xs-6:nth-child(6) { animation-delay: 0.6s; }
.col-lg-4:nth-child(7),
.col-xs-6:nth-child(7) { animation-delay: 0.7s; }

/* Footer */
.main-footer {
    background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
    border-top: 2px solid #40E0FF !important;
    color: #ffffff !important;
    box-shadow: 0 -4px 20px rgba(64, 224, 255, 0.2);
}

/* Modal mejorado */
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
}

.modal-footer {
    border-top: 2px solid #40E0FF !important;
    background: rgba(15, 52, 96, 0.5) !important;
}

/* Botones */
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

/* Responsive */
@media screen and (max-width: 768px) {
    h3 {
        font-size: 0.9rem !important;
    }

    .breadcrumb {
        padding: 15px 20px !important;
    }

    .breadcrumb h4 {
        font-size: 1.1rem;
        letter-spacing: 1px;
    }
}
</style>
</head>

<body class=" hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <!-- <img src="dist/img/logo.jpg" alt="logo">-->
        <?php
        if ($usuario['id_rol'] == 11) {
            ?>

            <a href="menu_almacencentral.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->

                <!-- logo for regular state and mobile devices -->
                <?php
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_simg=$f['id_simg'];
?>
            <center><span class="fondo"><img src="../configuracion/admin/img/<?php echo $f['img_base']?>" alt="imgsistema" class="img-fluid" width="112"></span></center>
          <?php
}
?>
            </a>
            <?php
        } else if ($usuario['id_rol'] == 5) {

            ?>
            <a href="menu_gerencia.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->

                <!-- logo for regular state and mobile devices -->
               <?php
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_simg=$f['id_simg'];
?>
            <center><span class="fondo"><img src="../configuracion/admin/img/<?php echo $f['img_base']?>" alt="imgsistema" class="img-fluid" width="112"></span></center>
          <?php
}
?>
            </a>
            <?php
        } else if ($usuario['id_rol'] == 4) {

            ?>
            <a href="menu_sauxiliares.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->

                <!-- logo for regular state and mobile devices -->
                <?php
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_simg=$f['id_simg'];
?>
            <center><span class="fondo"><img src="../configuracion/admin/img/<?php echo $f['img_base']?>" alt="imgsistema" class="img-fluid" width="112"></span></center>
          <?php
}
?>
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

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="user-image"
                                 alt="User Image">
                            <span class="hidden-xs"> <?php echo $usuario['papell']; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">

                                <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="img-circle"
                                     alt="User Image">

                                <p>
                                     <?php echo $usuario['papell']; ?>

                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?php
                                    if ($usuario['id_rol'] == 4) {?>
                                        <a href="../sauxiliares/editar_perfil/editar_perfil_saux.php?id_usua=<?php echo $usuario['id_usua'];?>" class="btn btn-default btn-flat">MIS DATOS</a>
                                     <?php
                                    }else  {?>

                                        <a href="../sauxiliares/editar_perfil/editar_perfil_alma.php?id_usua=<?php echo $usuario['id_usua'];?>" class="btn btn-default btn-flat">MIS DATOS</a>
                                    <?php }?>
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
                    <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p><?php echo $usuario['papell']; ?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> ACTIVO</a>
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class=" treeview">
                    <a href="../sauxiliares/AlmacenC/lista_productos.php">
                        <i class="fa fa-folder"></i> <span>CATÁLOGO DE PRODUCTOS</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <li class=" treeview">
                    <a href="../sauxiliares/AlmacenC/entrada_almacen.php">
                        <i class="fa fa-folder"></i> <span>ENTRADAS DE ALMACÉN</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <li class=" treeview">
                    <a href="../sauxiliares/AlmacenC/surtir_almacen.php">
                        <i class="fa fa-folder"></i> <span>SURTIR PEDIDOS</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="../sauxiliares/AlmacenC/inventario.php">
                        <i class="fa fa-folder"></i> <span>DETALLE DE INVENTARIO</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <li class=" treeview">
                    <a href="../sauxiliares/AlmacenC/caducado.php">
                        <i class="fa fa-folder"></i> <span>REVISAR CADUCIDAD</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="../sauxiliares/AlmacenC/devoluciones.php">
                        <i class="fa fa-folder"></i> <span>DEVOLUCIONES</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                 <li class="treeview">
                    <a href="../sauxiliares/AlmacenC/compras.php">
                        <i class="fa fa-folder"></i> <span>COMPRAS</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
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
                        <h4>ALMACEN CENTRAL</h4>
                    </STRONG></li>
            </ol>
        </nav>

        <!-- Main content -->
        <section class="content">
            <section class="content container-fluid">
                <div class="content box">
                    <!-- CONTENIDOO -->
                    <div class="row">
                        <div class="col-lg-4 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Lista de Productos"
                                           href="../sauxiliares/AlmacenC/lista_productos.php"><img class="card-img-top"
                                           src="../img/lista.png"
                                           alt="Lista de Productos"
                                           height="150"
                                           width="200"/></a>
                                    </center>
                                    <center>
                                        <h3 class="catdp">CATÁLOGO DE PRODUCTOS</h3>
                                    </center>

                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Entradas de Almacén" href="../sauxiliares/AlmacenC/entrada_almacen.php"><img
                                            class="card-img-top" src="../img/entrada_almacen.jpg"
                                           alt="Entradas de Almacén" height="150" width="200"/></a>
                                    </center>
                                    <center>
                                        <h3>ENTRADAS DE ALMACÉN</h3>
                                    </center>

                                </div>

                            </div>
                        </div>

                        <div class="col-lg-4 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Surtir Pedidos" href="../sauxiliares/AlmacenC/surtir_almacen.php"><img
                                                    class="card-img-top" src="../img/surtir_almacen.jpg"
                                                    alt="Surtir Pedidos" height="150" width="200"/></a>
                                    </center>
                                    <center>
                                        <h3>SURTIR PEDIDOS</h3>
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xs-6 inventario">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Existencias"
                                           href="../sauxiliares/AlmacenC/inventario.php"><img
                                                    class="card-img-top" src="../img/inventario.PNG"
                                                    alt="Existencias" height="150" width="160"/></a>
                                    </center>
                                    <center>
                                        <h3 class="dinventario">DETALLE DE INVENTARIO</h3>
                                    </center>
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-4 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Productos Caducados"
                                           href="../sauxiliares/AlmacenC/caducado.php"><img class="card-img-top"
                                               src="../img/caducado.webp"
                                               alt="Productos caducados"
                                               height="150"
                                               width="200"/></a>
                                    </center>
                                    <center>
                                        <h3>REVISAR CADUCIDAD</h3>
                                    </center>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-4 col-xs-6 cdev">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Devoluciones" href="../sauxiliares/AlmacenC/devoluciones.php"><img
                                                        class="card-img-top" src="../img/dev.jpg"
                                                        alt="Devoluciones"
                                                        height="150" width="160"/></a>
                                    </center>
                                    <center>
                                        <h3>DEVOLUCIONES</h3>
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Compras" href="../sauxiliares/AlmacenC/compras.php"><img
                                                        class="card-img-top" src="../img/compras.jpg"
                                                        alt="Compras"
                                                        height="150" width="160"/></a>
                                    </center>
                                    <center>
                                        <h3>COMPRAS</h3>
                                    </center>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>


            </section><!-- /.content -->
    </div><!-- /.content-wrapper -->


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-4 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Lista de Productos"
                                           href="../sauxiliares/AlmacenC/lista_productos.php"><img class="card-img-top"
                                           src="../img/lista.png"
                                           alt="Lista de Productos"
                                           height="150"
                                           width="200"/></a>
                                    </center>
                                    <center>
                                        <h3>CATÁLOGO DE PRODUCTOS</h3>
                                    </center>

                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Entradas de Almacén" href="../sauxiliares/AlmacenC/entrada_almacen.php"><img
                                            class="card-img-top" src="../img/entrada_almacen.jpg"
                                           alt="Entradas de Almacén" height="150" width="200"/></a>
                                    </center>
                                    <center>
                                        <h3>ENTRADAS DE ALMACÉN</h3>
                                    </center>

                                </div>

                            </div>
                        </div>

                        <div class="col-lg-4 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Surtir Pedidos" href="../sauxiliares/AlmacenC/surtir_almacen.php"><img
                                                    class="card-img-top" src="../img/surtir_almacen.jpg"
                                                    alt="Surtir Pedidos" height="150" width="200"/></a>
                                    </center>
                                    <center>
                                        <h3>SURTIR PEDIDOS</h3>
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <a title="Existencias"
                                           href="../sauxiliares/AlmacenC/inventario.php"><img
                                                    class="card-img-top" src="../img/inventario.PNG"
                                                    alt="Existencias" height="150" width="160"/></a>
                                    </center>
                                    <center>
                                        <h3>DETALLE DE INVENTARIO</h3>
                                    </center>
                                </div>
                            </div>
                        </div>



                            <div class="col-lg-4 col-xs-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <center>
                                            <a title="Productos Caducados"
                                               href="../sauxiliares/AlmacenC/caducado.php"><img class="card-img-top"
                                               src="../img/caducado.webp"
                                               alt="Productos caducados"
                                               height="150"
                                               width="200"/></a>
                                        </center>
                                        <center>
                                            <h3>REVISAR CADUCIDAD</h3>
                                        </center>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-4 col-xs-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <center>
                                            <a title="Devoluciones" href="../sauxiliares/AlmacenC/devoluciones.php"><img
                                                        class="card-img-top" src="../img/dev.jpg"
                                                        alt="Devoluciones"
                                                        height="150" width="160"/></a>
                                        </center>
                                        <center>
                                            <h3>DEVOLUCIONES</h3>
                                        </center>

                                    </div>

                                </div>
                            </div>

                    </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>

                </div>
            </div>
        </div>
    </div>

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
