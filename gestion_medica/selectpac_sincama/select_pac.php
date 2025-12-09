    <?php
    session_start();
    include "../../conexionbd.php";
    include "../header_medico.php";

    $usuario = $_SESSION['login'];
    $usuario1 = $usuario['id_usua'];

    ?>
    <!DOCTYPE html>
    <html>
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
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
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


         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script>
            // Write on keyup event of keyword input element
            $(document).ready(function() {
                $("#search").keyup(function() {
                    _this = this;
                    // Show only matching TR, hide rest of them
                    $.each($("#mytable tbody tr"), function() {
                        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                            $(this).hide();
                        else
                            $(this).show();
                    });
                });
            });
        </script>


        <title>Creación de Paciente</title>
        <link rel="shortcut icon" href="logp.png">


    </head>

    <?php
      if ($usuario['id_rol'] == 5||$usuario['id_rol'] == 12) {
      ?>
    <div class="container">
            <div class="row">
                  <div class="col col-12">
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    <br>
                   <center>

                        <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
                                <tr><strong><center>PACIENTES REGISTRADOS</center></strong>
                        </div>
                        <hr>
                    </center>


                    <h2>
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    </h2>


                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
                    </div><br>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead" style="background-color: #2b2d7f; color:white;">
                        <tr>
                            <th scope="col">SELECCIONAR</th>
                            <th scope="col">CAMA ALTA</th>
                            <th scope="col">EXP.</th>
                            <th scope="col">ID ATENCIÓN</th>
                            <th scope="col">NOMBRE</th>
                            <th scope="col">EDAD</th>
                            <th scope="col">FECHA DE INGRESO</th>
                            <th scope="col">DIAGNÓSTICO</th>
                            <th scope="col">MEDICO TRATANTE</th>
                            <th scope="col">FECHA DE EGRESO</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                         $resultado = $conexion->query("SELECT p.*,p.papell as papell_pac ,p.sapell as sapell_pac, d.*, d.fecha as fechaing, r.*, r.papell as papell_doc, r.sapell as sapell_doc from paciente p, dat_ingreso d, reg_usuarios r WHERE d.Id_exp=p.Id_exp and d.cama=0 and d.id_usua=r.id_usua order by d.fecha DESC") or die($conexion->error);

                        while ($f = mysqli_fetch_array($resultado)) {

                            $fecha_quir = date("d-m-Y H:i:s");


                            ?>

                            <tr>
                                <td>
                                    <center>
                                        <a href="../hospitalizacion/select_pac.php?id_atencion=<?php echo $f['id_atencion']; ?>"><button type="button" class="btn btn-primary "><i class="fa fa-hand-o-up" aria-hidden="true"></i></button></a></center></td>
                                         <td><font size="2"><strong><?php echo $f['cama_alta']; ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['Id_exp']; ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['id_atencion']; ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['papell_pac'].' '.$f['sapell_pac'].' '.$f['nom_pac']; ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['edad']; ?></strong></font></td>
                                <td><font size="2"><strong><?php $date = date_create($f['fechaing']); echo date_format($date, "d/m/Y"); ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['motivo_atn'] ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['papell_doc'].' '.$f['sapell_doc']; ?></strong></font></td>
                                <td><font size="2"><strong><?php $date = date_create($f['fec_egreso']); echo date_format($date, "d/m/Y"); ?></strong></font></td>
                            </tr>
                            <?php

                        }

                        ?>
                        </tbody>
                    </table>
                    </div>

                </div>
            </div>
        </div>
    <?php } else  if ($usuario['id_rol'] == 2) { ?>


        <div class="container">
            <div class="row">
                  <div class="col col-12">
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    <br>
                   <center>

                        <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
                                <tr><strong><center>PACIENTES REGISTRADOS</center></strong>
                        </div>
                        <hr>
                    </center>


                    <h2>
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    </h2>


                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
                    </div><br>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead" style="background-color: #2b2d7f; color:white;">
                        <tr>
                            <th scope="col">SELECCIONAR</th>
                             <th scope="col">CAMA ALTA.</th>
                            <th scope="col">EXP.</th>
                            <th scope="col">NOMBRE</th>
                            <th scope="col">EDAD</th>
                            <th scope="col">FECHA DE INGRESO</th>
                            <th scope="col">DIAGNÓSTICO</th>
                            <th scope="col">MEDICO TRATANTE</th>
                            <th scope="col">FECHA DE EGRESO</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                         $resultado = $conexion->query("SELECT p.*,p.papell as papell_pac ,p.sapell as sapell_pac, d.*, d.fecha as fechaing, r.*, r.papell as papell_doc, r.sapell as sapell_doc from paciente p, dat_ingreso d, reg_usuarios r WHERE d.Id_exp=p.Id_exp and d.cama=0 and (d.id_usua=$usuario1 || d.id_usua2=$usuario1 || d.id_usua3=$usuario1 || d.id_usua4=$usuario1 || d.id_usua5=$usuario1) and d.id_usua=r.id_usua order by d.fec_egreso DESC") or die($conexion->error);

                        while ($f = mysqli_fetch_array($resultado)) {

$fecha_quir = date("d-m-Y H:i:s");


$fecha1 = new DateTime($f['fec_egreso']);//fecha inicial
$fecha2 = new DateTime($fecha_quir);//fecha de cierre

$intervalo = $fecha1->diff($fecha2);

  $intervalo->format('%d %m %h');//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos


  $hor=$intervalo->format('%h horas');
   $dd=$intervalo->format('%d');
   $mm=$intervalo->format('%m');
 if($dd==0 and $mm==0 and $f['fec_egreso']!=null){
                            ?>

                            <tr>
                                <td>
                                    <center>
                                        <a href="../hospitalizacion/select_pac.php?id_atencion=<?php echo $f['id_atencion']; ?>"><button type="button" class="btn btn-primary "><i class="fa fa-hand-o-up" aria-hidden="true"></i></button></a></center></td>
                                         <td><font size="2"><strong><?php echo $f['cama_alta']; ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['Id_exp']; ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['papell_pac'].' '.$f['sapell_pac'].' '.$f['nom_pac']; ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['edad']; ?></strong></font></td>
                                <td><font size="2"><strong><?php $date = date_create($f['fechaing']); echo date_format($date, "d/m/Y"); ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['motivo_atn'] ?></strong></font></td>
                                <td><font size="2"><strong><?php echo $f['papell_doc'].' '.$f['sapell_doc']; ?></strong></font></td>
                                <td><font size="2"><strong><?php $date = date_create($f['fec_egreso']); echo date_format($date, "d/m/Y"); ?></strong></font></td>
                            </tr>
                            <?php
                        }
                        }

                        ?>
                        </tbody>
                    </table>
                    </div>

                </div>
            </div>
        </div>
     <?php } ?>


    </div>
    <footer class="main-footer">
        <?php
        include("../../template/footer.php");
        ?>
    </footer>

    <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- FastClick -->
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
    </body>
    </html>
