<?php
session_start();
include "../../conexionbd.php";
include("../header_administrador.php");

if( isset($_GET['id_usua'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
  $resultado = $conexion ->query("SELECT * FROM reg_usuarios WHERE id_usua=".$_GET['id_usua'])or die($conexion->error);
  if(mysqli_num_rows($resultado) > 0 ){ //se mostrara si existe mas de 1
    $f=mysqli_fetch_row($resultado);

  }else{
    header("location: header_administrativo.php"); //te regresa a la página principal
  }
}else{
  header("location: header_administrativo.php"); //te regresa a la página principal
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">

    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function(){
            $("#search").keyup(function(){
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function() {
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
    </script>

</head>
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
<body>
<div class="container-fluid">
    <form action="" method="POST" enctype="multipart/form-data">
    <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?php
                        $id_usua= $_GET['id_usua'];
                        ?>
                        <input type="hidden" name="id_usua" placeholder="Expediente" id="id_usua" class="form-control" value="<?php echo $id_usua ?>"
                               disabled>
                    </div>
                </div>
         </div>
         <div class="row">
    <div class="col">
       No: <strong><?php echo $f[0];?></strong> <br>
        Usuario: <strong><?php echo $f[2];?></strong><br>
        Nombre completo: <strong><?php echo $f[3];?></strong><br>
        Fecha de nacimiento:<strong> <?php  $date = date_create($f[5]);
 echo date_format($date,"d/m/Y");?></strong>

    </div>

  </div> <br>
        <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
            <tr><strong><center>EDITAR USUARIO</center></strong>
      </div><br>
<div class="container-fluid">
       <div class="row">

             <div class="col-sm-4">
                <div class="form-group">
                    <label>CURP:</label><br>
                    <input type="text" name="curp_u" class="form-control" value="<?php echo $f[1];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                    <label>NOMBRE:</label><br>
                    <input type="text" name="nombre" class="form-control" value="<?php echo $f[2];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                    <label>PRIMER APELLIDO:</label><br>
                    <input type="text" name="papell" class="form-control" value="<?php echo $f[3];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
       </div>

       <div class="row">
             <div class="col-sm-4">
                <div class="form-group">
                    <label>SEGUNDO APELLIDO:</label><br>
                    <input type="text" name="sapell" class="form-control" value="<?php echo $f[4];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                        <div class="form-group">
                            <label for="fecnac">FECHA DE NACIMIENTO:</label>

                          <input type="date" name="fecnac" value="<?php echo $f[5];?>" id="fecnac"
                                   class="form-control" required>
                        </div>
                    </div>


             <div class="col-sm-4">
                <div class="form-group">
                   <label>CÉDULA PROFESIONAL:</label><br>
                    <input type="text" name="cedp" class="form-control" value="<?php echo $f[7];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                    <label>FUNCIÓN:</label><br>
                    <input type="text" name="cargp" class="form-control" value="<?php echo $f[8];?>" style="text-transform:uppercase;"onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                    <label>TELÉFONO:</label><br>
                    <input type="text" name="tel" class="form-control" value="<?php echo $f[9];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>

             <div class="col-sm-4">
                <div class="form-group">
                    <label>E-mail :</label><br>
                    <input type="text" name="email" class="form-control" value="<?php echo $f[10];?>">
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                    <label>PREFIJO:</label><br>
                    <input type="text" name="pre" class="form-control" value="<?php echo $f[11];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                    <label>CONTRASEÑA:</label><br>
                    <input type="password" name="pass" class="form-control" value="<?php echo $f[12];?>" >
                </div><br>
             </div>

             <div class="col-sm-4">

             </div>

              <div class="col-sm-4">
    <label for="img_perfil"><strong><font size="2">SELECCIONAR IMAGEN DE PERFIL</font></strong></label>
    <input type="file" class="form-control-file" id="img_perfil" name="img_perfil">
    </div>
<div class="col-sm-4">
    <label for="firma"><strong><font size="2">SELECCIONAR FIRMA</font></strong></label>
    <input type="file" class="form-control-file" id="firma" name="firma">
    </div>
             </div>
       </div>
<hr>

    <center>
            <button type="submit" name="guardar" class="btn btn-success">GUARDAR</button>
            <a href="../../template/menu_administrativo.php" class="btn btn-danger">CANCELAR</a>
    </center>

</form>
</div>
<br>

<?php
if (isset($_POST['guardar'])) {

        $curp_u    = mysqli_real_escape_string($conexion, (strip_tags($_POST["curp_u"], ENT_QUOTES))); //Escanpando caracteres
        $nombre    = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES))); //Escanpando caracteres
        $papell    = mysqli_real_escape_string($conexion, (strip_tags($_POST["papell"], ENT_QUOTES))); //Escanpando caracteres
        $sapell   = mysqli_real_escape_string($conexion, (strip_tags($_POST["sapell"], ENT_QUOTES))); //Escanpando caracteres

          $fecnac    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecnac"], ENT_QUOTES)));

          $cedp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cedp"], ENT_QUOTES)));

          $cargp   = mysqli_real_escape_string($conexion, (strip_tags($_POST["cargp"], ENT_QUOTES)));
           $tel    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel"], ENT_QUOTES)));
          $email    = mysqli_real_escape_string($conexion, (strip_tags($_POST["email"], ENT_QUOTES)));
          $pre    = mysqli_real_escape_string($conexion, (strip_tags($_POST["pre"], ENT_QUOTES)));
          $pass    = mysqli_real_escape_string($conexion, (strip_tags($_POST["pass"], ENT_QUOTES)));


//imagen1 EDITAR
        if($_FILES['img_perfil']['name']!=''){
    $nombr = $_FILES['img_perfil']['name'];
    $carpeta="../../imagenes/";
//imagen1.jpg
            $temp=explode('.' ,$nombr);
        $extension= end($temp);
        $img=time().'.'.$extension;

        if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){

        if(move_uploaded_file($_FILES['img_perfil']['tmp_name'], $carpeta.$img)){
            $fila= $conexion->query('select img_perfil from reg_usuarios where id_usua='.$_GET['id_usua']);
            $id=mysqli_fetch_row($fila);
            if(file_exists('../../imagenes/'.$id[0])){
            unlink('../../imagenes/'.$id[0]);
                }
            $conexion->query("update reg_usuarios set img_perfil='".$img."' where id_usua=".$_GET['id_usua']);
                }
            }//llave tipo archivo
        }    //llave si no esta vacio

//firma EDITAR
        if($_FILES['firma']['name']!=''){
    $nombrf = $_FILES['firma']['name'];
    $carpetaf="../../imgfirma/";
//firma.jpg
            $tempf=explode('.' ,$nombrf);
        $extensionf= end($tempf);
        $imgf=time().'.'.$extensionf;

        if($extensionf=='jpg' || $extensionf=='png' || $extensionf=='jpeg'){

        if(move_uploaded_file($_FILES['firma']['tmp_name'], $carpetaf.$imgf)){
            $filaf= $conexion->query('select firma from reg_usuarios where id_usua='.$_GET['id_usua']);
            $id=mysqli_fetch_row($filaf);
            if(file_exists('../../imgfirma/'.$id[0])){
            unlink('../../imgfirma/'.$id[0]);
                }
            $conexion->query("update reg_usuarios set firma='".$imgf."' where id_usua=".$_GET['id_usua']);
                }
            }//llave tipo archivo
        }    //llave si no esta vacio



        $sql2 = "UPDATE reg_usuarios SET curp_u='$curp_u' , nombre='$nombre', papell='$papell', sapell='$sapell', fecnac='$fecnac', tel='$tel', email='$email', pre='$pre', pass='$pass', cedp='$cedp', cargp='$cargp' WHERE id_usua= ".$_GET['id_usua'];
     // echo $sql2;
      // return 'hbgk';
        $result = $conexion->query($sql2);
        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location ="../../template/menu_administrativo.php"</script>';
      }
?>
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
