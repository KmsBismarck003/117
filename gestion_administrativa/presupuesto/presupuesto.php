<?php
session_start();
include "../../conexionbd.php";
include "../../gestion_administrativa/header_administrador.php";
$resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE  dat_ingreso.activo='SI' AND alta_adm = 'NO'") or die($conexion->error);
?>
<!DOCTYPE html>
<html>
<head>
     <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>



    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    }

    .main-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        padding: 0;
        overflow: hidden;
    }

    .header-section {
        background: linear-gradient(135deg, #2b2d7f 0%, #3949ab 100%);
        color: white;
        padding: 25px;
        text-align: center;
        margin-bottom: 0;
    }

    .header-section h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .header-section i {
        font-size: 32px;
        margin-right: 15px;
        opacity: 0.9;
    }

    .content-section {
        padding: 30px;
    }

    .form-card {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }

    .form-card:hover {
        border-color: #2b2d7f;
        box-shadow: 0 5px 15px rgba(43, 45, 127, 0.1);
    }

    .form-card h5 {
        color: #2b2d7f;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #2b2d7f;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #2b2d7f 0%, #3949ab 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(43, 45, 127, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(43, 45, 127, 0.4);
    }

    .btn-back {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        color: white;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    .btn-back:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-top: 25px;
    }

    .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #2b2d7f;
        box-shadow: 0 0 0 0.2rem rgba(43, 45, 127, 0.25);
    }

    .select2-container--default .select2-selection--single {
        border: 2px solid #e9ecef !important;
        border-radius: 8px !important;
        height: 46px !important;
        padding: 8px 15px !important;
    }

    .select2-container--default .select2-selection--single:focus {
        border-color: #2b2d7f !important;
    }

    hr.divider {
        border: 0;
        height: 2px;
        background: linear-gradient(135deg, #2b2d7f 0%, #3949ab 100%);
        margin: 30px 0;
        border-radius: 1px;
    }

    .total-section {
        background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%);
        border: 2px solid #28a745;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
        text-align: center;
    }

    .total-amount {
        font-size: 24px;
        font-weight: bold;
        color: #155724;
    }
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

    <title>Presupuestos - Gestión Administrativa</title>
    <link rel="shortcut icon" href="logp.png">
</head>

<div class="container-fluid">
    <a class="btn-back" onclick="history.back()">
        <i class="fas fa-arrow-left"></i> Regresar
    </a>

    <div class="main-container">
        <div class="header-section">
            <h2>
                <i class="fas fa-calculator"></i>
                GESTIÓN DE PRESUPUESTOS
            </h2>
        </div>
        <div class="content-section">
            <?php
                $nombre='PRUEBA';
            ?>

            <!-- Formulario de Servicios -->
            <div class="form-card">
                <h5><i class="fas fa-concierge-bell"></i> Agregar Servicios</h5>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="serv" class="form-label"><strong>Servicio:</strong></label>
                            <select data-live-search="true" id="mibuscador" name="serv" class="form-control" required>
                                <?php
                                    $sql_serv = "SELECT * FROM cat_servicios where serv_activo = 'SI'";
                                    $result_serv = $conexion->query($sql_serv);
                                    while ($row_serv = $result_serv->fetch_assoc()) {
                                        echo "<option value='" . $row_serv['id_serv'] . "'>" . $row_serv['serv_desc'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="cantidad" class="form-label"><strong>Cantidad:</strong></label>
                            <input type="number" name="cantidad" class="form-control" value="" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <input type="submit" name="btnserv" class="btn btn-primary-custom btn-block" value="Agregar">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Formulario de Medicamentos -->
            <div class="form-card">
                <h5><i class="fas fa-pills"></i> Agregar Medicamentos y Materiales</h5>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="med" class="form-label"><strong>Medicamentos y materiales:</strong></label>
                            <select data-live-search="true" id="mibuscador2" name="med" class="form-control" required>
                                <?php
                                    $sql_serv = "SELECT * FROM item ";
                                    $result_serv = $conexion->query($sql_serv);
                                    while ($row_serv = $result_serv->fetch_assoc()) {
                                        echo "<option value='" . $row_serv['item_id'] . "'>" . $row_serv['item_name'] . ', '.$row_serv['item_grams'] . "</option>";
                                    }
                                ?>
                                        </select>
                        </div>
                        <div class="col-md-2">
                            <label for="cantidad2" class="form-label"><strong>Cantidad:</strong></label>
                            <input type="number" name="cantidad" class="form-control" value="" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <input type="submit" name="btnmed" class="btn btn-primary-custom btn-block" value="Agregar">
                        </div>
                    </div>
                </form>
            </div>
            </div>

            <?php
            if (isset($_POST['btnserv'])) {
                include "../../conexionbd.php";
                $nombre='PRUEBA';
                $serv_id =  mysqli_real_escape_string($conexion, (strip_tags($_POST["serv"], ENT_QUOTES)));
                $cantidad =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));

                $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $serv_id") or die($conexion->error);
                while ($row_serv = $resultado_serv->fetch_assoc()) {
                    $descripcion = $row_serv['serv_desc'];
                }

                $fecha_actual = date("Y-m-d H:i:s");
                $ingresar2 = mysqli_query($conexion, 'INSERT INTO presupuesto (fecha,id_pac,nombre,id_serv,servicio,cantidad) values ("'.$fecha_actual.'",1,"'.$nombre.'","' . $serv_id . '","' . $descripcion .'",' . $cantidad . ') ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

                echo '<script type="text/javascript">window.location.href = "presupuesto.php?id_pac=1&nombre='.$nombre.'";</script>';
            }

            if (isset($_POST['btnmed'])) {
                include "../../conexionbd.php";
                $nombre=mysqli_real_escape_string($conexion, (strip_tags($_GET["nombre"], ENT_QUOTES)));
                $item_id =  mysqli_real_escape_string($conexion, (strip_tags($_POST["med"], ENT_QUOTES)));
                $cantidad =  mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));

                $resultado_serv = $conexion->query("SELECT * FROM item where item_id = $item_id") or die($conexion->error);
                while ($row_serv = $resultado_serv->fetch_assoc()) {
                    $item_code = $row_serv['item_code'];
                    $descripcion = $row_serv['item_name'];
                }

                $fecha_actual = date("Y-m-d H:i:s");
                $ingresar2 = mysqli_query($conexion, 'INSERT INTO presupuesto (fecha,id_pac,nombre,id_serv,servicio,cantidad) values ("'.$fecha_actual.'",1,"'.$nombre.'","'. $item_code .'","' . $descripcion .'",' . $cantidad . ') ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

                echo '<script type="text/javascript">window.location.href = "presupuesto.php?id_pac=1&nombre='.$nombre.'";</script>';
            }
            ?>

            <hr class="divider">

            <!-- Tabla de Presupuesto -->
            <div class="table-container">
                <table class="table table-striped table-hover mb-0" id="mytable">
                    <thead style="background-color: #2b2d7f; color: white;">
                        <tr>
                            <th style="padding: 15px;">#</th>
                            <th style="padding: 15px;">Fecha</th>
                            <th style="padding: 15px;">Descripción</th>
                            <th style="padding: 15px;">Cantidad</th>
                            <th style="padding: 15px;">Precio</th>
                            <th style="padding: 15px; text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;

                        include "../../conexionbd.php";

                        $id_pac=1;
                        $resultado3 = $conexion->query("SELECT * from presupuesto p, cat_servicios c where $id_pac=1 and c.id_serv=p.id_serv") or die($conexion->error);

                        $no = 1;
                        while ($row_lista_serv = $resultado3->fetch_assoc()) {
                            $fecha=date_create($row_lista_serv['fecha']);
                            $precio = $row_lista_serv['serv_costo'] * 1.16;
                            $subtottal=$precio*$row_lista_serv['cantidad'];
                            echo '<tr>'
                                . '<td style="padding: 12px;">' . $no . '</td>'
                                . '<td style="padding: 12px;">' . date_format($fecha,"d-m-Y") . '</td>'
                                . '<td style="padding: 12px;">' . $row_lista_serv['servicio'] . '</td>'
                                . '<td style="padding: 12px; text-align: center;">' . $row_lista_serv['cantidad'] . '</td>'
                                . '<td style="padding: 12px; text-align: right;">$' . number_format($subtottal, 2). '</td>'
                                . '<td style="padding: 12px; text-align: center;"> <a class="btn btn-danger btn-sm" href="eliminar.php?q=eliminar_serv&id_presupuesto= ' . $row_lista_serv['id_presupuesto'] . '&id_pac='.$row_lista_serv['id_pac'].'&nombre='.$nombre.'" onclick="return confirm(\'¿Está seguro de eliminar este elemento?\')"><i class="fa fa-trash"></i></a></td>';
                            echo '</tr>';
                            $total= $subtottal + $total;
                            $no++;
                        }

                        $resultado3 = $conexion->query("SELECT * from presupuesto p, item i where id_pac=$id_pac and i.item_code=p.id_serv") or die($conexion->error);
                        while ($row_lista_serv = $resultado3->fetch_assoc()) {
                            $fecha=date_create($row_lista_serv['fecha']);
                            $precio = $row_lista_serv['item_price'] * 1.16;
                            $subtottal=$precio*$row_lista_serv['cantidad'];
                            echo '<tr>'
                                . '<td style="padding: 12px;">' . $no . '</td>'
                                . '<td style="padding: 12px;">' . date_format($fecha,"d-m-Y") . '</td>'
                                . '<td style="padding: 12px;">' . $row_lista_serv['servicio'] . '</td>'
                                . '<td style="padding: 12px; text-align: center;">' . $row_lista_serv['cantidad'] . '</td>'
                                . '<td style="padding: 12px; text-align: right;">$' . number_format($subtottal, 2). '</td>'
                                . '<td style="padding: 12px; text-align: center;"> <a class="btn btn-danger btn-sm" href="eliminar.php?q=eliminar_serv&id_presupuesto= ' . $row_lista_serv['id_presupuesto'] . '&id_pac='.$row_lista_serv['id_pac'].'&nombre='.$nombre.'" onclick="return confirm(\'¿Está seguro de eliminar este elemento?\')"><i class="fa fa-trash"></i></a></td>';
                            echo '</tr>';
                            $total= $subtottal + $total;
                            $no++;
                        }
                        ?>
                        <tr style="background: #f8f9fa; border-top: 3px solid #2b2d7f;">
                            <td colspan="4" style="padding: 15px; text-align: right; font-weight: bold; font-size: 16px; color: #2b2d7f;">TOTAL:</td>
                            <td style="padding: 15px; text-align: right; font-weight: bold; font-size: 18px; color: #28a745;"><?php echo "$ " . number_format($total, 2); ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
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

<script>
    document.oncontextmenu = function () {
        return false;
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador2').select2();
    });
</script>
</body>

</html>
