<?php
include "../conexionbd.php";
session_start();

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
date_default_timezone_set('America/Guatemala');

if (isset($usuario['id_rol'])) {
    if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
        include "../sauxiliares/header_farmaciaq.php";
    } else {
        session_unset();
        session_destroy();
        echo "<script>window.location='../index.php';</script>";
        exit();
    }
}

?>

<!-- Additional CSS for farmacia menu -->
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- Font Awesome Icons 6.0.0 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" type="text/css" />
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

<style>
    body {
        background: #f5f5f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .farmacia-container {
        padding: 30px;
        background: #ffffff;
        min-height: 100vh;
        margin: 0;
    }

    .farmacia-card {
        border-radius: 20px;
        padding: 40px 20px;
        margin: 20px 0;
        text-decoration: none;
        transition: all 0.4s ease;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        height: 220px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
        border: none;
    }

    .farmacia-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 20px;
        padding: 2px;
        background: rgba(255, 255, 255, 0.5);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: exclude;
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
    }

    .farmacia-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .farmacia-card.surtir {
        background: #e3f2fd;
        color: #1565c0;
    }

    .farmacia-card.existencias {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .farmacia-card.kardex {
        background: #e8f5e8;
        color: #388e3c;
    }

    .farmacia-card.caducidades {
        background: #fff3e0;
        color: #f57c00;
    }

    .farmacia-card.devoluciones {
        background: #fce4ec;
        color: #c2185b;
    }

    .farmacia-card.confirmar {
        background: #ffebee;
        color: #d32f2f;
    }

    .farmacia-card.pedir {
        background: #e0f2f1;
        color: #00796b;
    }

    .farmacia-card.salidas {
        background: #e8eaf6;
        color: #3f51b5;
    }

    .farmacia-card.inventario {
        background: #fff8e1;
        color: #ff8f00;
    }

    .farmacia-card:hover.surtir {
        background: #bbdefb;
    }

    .farmacia-card:hover.existencias {
        background: #e1bee7;
    }

    .farmacia-card:hover.kardex {
        background: #c8e6c9;
    }

    .farmacia-card:hover.caducidades {
        background: #ffe0b2;
    }

    .farmacia-card:hover.devoluciones {
        background: #f8bbd9;
    }

    .farmacia-card:hover.confirmar {
        background: #ffcdd2;
    }

    .farmacia-card:hover.pedir {
        background: #b2dfdb;
    }

    .farmacia-card:hover.salidas {
        background: #c5cae9;
    }

    .farmacia-card:hover.inventario {
        background: #ffecb3;
    }

    .farmacia-icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px auto;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .farmacia-card:hover .farmacia-icon-circle {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .farmacia-card i {
        font-size: 32px;
        opacity: 0.9;
    }

    .farmacia-card h4 {
        font-size: 15px;
        font-weight: 600;
        margin: 0;
        letter-spacing: 0.5px;
        line-height: 1.3;
        text-transform: uppercase;
    }

    @media (max-width: 768px) {
        .farmacia-container {
            padding: 15px;
        }

        .farmacia-card {
            margin: 15px 0;
            padding: 30px 15px;
            height: 180px;
        }

        .farmacia-icon-circle {
            width: 60px;
            height: 60px;
        }

        .farmacia-card i {
            font-size: 24px;
        }

        .farmacia-card h4 {
            font-size: 13px;
        }
    }
</style>

<!-- Main content -->
<section class="content">

<div class="d-flex justify-content-start" style="margin:3px;">
    <div class="d-flex">
        <!-- Botón Regresar -->
        <a href="../../template/menu_sauxiliares.php"
            style="color: white; background: linear-gradient(135deg, #2b2d7f 0%, #1a1c5a 100%);
            border: none; border-radius: 8px; padding: 10px 16px; cursor: pointer; display: inline-block;
            text-decoration: none; box-shadow: 0 2px 8px rgba(43, 45, 127, 0.3);
            transition: all 0.3s ease; margin-top: 5px; margin-bottom: 5px; margin-right: 10px;">
            ← Regresar
        </a>
    </div>
</div>

    <div class="farmacia-container">
        <div class="row">
            <!-- Surtir Medicamentos -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="../sauxiliares/farmaciaq/surtir_pacienteq.php" class="farmacia-card surtir">
                    <div class="farmacia-icon-circle">
                        <i class="fas fa-hand-holding-medical"></i>
                    </div>
                    <h4>SURTIR MEDICAMENTOS</h4>
                </a>
            </div>

            <!-- Existencias -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="../sauxiliares/farmaciaq/existenciasq.php" class="farmacia-card existencias">
                    <div class="farmacia-icon-circle">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h4>EXISTENCIAS</h4>
                </a>
            </div>

            <!-- Kardex -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="../sauxiliares/farmaciaq/kardexq.php" class="farmacia-card kardex">
                    <div class="farmacia-icon-circle">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>KARDEX</h4>
                </a>
            </div>



            <!-- Devoluciones -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="../sauxiliares/farmaciaq/devolucionesq.php" class="farmacia-card devoluciones">
                    <div class="farmacia-icon-circle">
                        <i class="fas fa-undo"></i>
                    </div>
                    <h4>DEVOLUCIONES</h4>
                </a>
            </div>

            <!-- Confirmar de Recibido -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="../sauxiliares/farmaciaq/confirmar_envioq.php" class="farmacia-card confirmar">
                    <div class="farmacia-icon-circle">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4>CONFIRMAR DE RECIBIDO</h4>
                </a>
            </div>

            <!-- Pedir Almacén -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="../sauxiliares/farmaciaq/pedir_almacenq.php" class="farmacia-card pedir">
                    <div class="farmacia-icon-circle">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h4>PEDIR ALMACÉN</h4>
                </a>
            </div>

            <!-- Salidas Medicamentos -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="../sauxiliares/farmaciaq/salidasq.php" class="farmacia-card salidas">
                    <div class="farmacia-icon-circle">
                        <i class="fas fa-file-export"></i>
                    </div>
                    <h4>SALIDAS MEDICAMENTOS</h4>
                </a>
            </div>


    </div>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->



</div><!-- ./wrapper -->

</body>

</html>
