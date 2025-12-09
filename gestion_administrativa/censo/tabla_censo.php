<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../index.php");
}

include("../header_administrador.php");
?>

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

    <style>
        .fondo {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            font-weight: 500;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }

        .fondo:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
            transform: translateY(-1px);
        }

        .fondo2 {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            font-weight: 500;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }

        .fondo2:hover {
            background: linear-gradient(135deg, #e67e22, #d35400);
            transform: translateY(-1px);
        }

        .fondo3 {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            font-weight: 500;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }

        .fondo3:hover {
            background: linear-gradient(135deg, #2980b9, #21618c);
            transform: translateY(-1px);
        }

        .cuenta {
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
            color: white;
            font-weight: 500;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }

        .cuenta:hover {
            background: linear-gradient(135deg, #7f8c8d, #6c7b7d);
            transform: translateY(-1px);
        }

        /* Botones de Acción */
        .action-btn {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.25);
        }

        .btn-warning.action-btn {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            border: none;
        }

        .btn-success.action-btn {
            background: linear-gradient(135deg, #27ae60, #229954);
            border: none;
        }

        .btn-danger.action-btn {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card-body {
                padding: 10px;
            }

            .table-responsive {
                font-size: 12px;
            }

            .action-btn {
                width: 35px;
                height: 35px;
                font-size: 12px;
            }
        }
    </style>

  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>


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

    .section-header {
        background: linear-gradient(135deg, #2b2d7f 0%, #3949ab 100%);
        color: white;
        padding: 15px 20px;
        margin: 20px 0 0 0;
        border-radius: 10px 10px 0 0;
        font-size: 18px;
        font-weight: 600;
        text-align: center;
    }

    .census-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin: 20px;
        overflow: hidden;
    }

    .search-container {
        padding: 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
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

    .btn-print {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        text-decoration: none;
        display: inline-block;
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        color: white;
        text-decoration: none;
    }

    .table-container {
        background: white;
        overflow-x: auto;
    }

    .table {
        margin: 0;
    }

    .table thead th {
        background: #2b2d7f;
        color: white;
        border: none;
        padding: 15px 8px;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        font-size: 13px;
    }

    .table tbody td {
        padding: 10px 6px;
        vertical-align: middle;
        text-align: center;
        border-color: #e9ecef;
        font-size: 12px;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }

    /* Estados de camas mejorados */
    td.fondo {
        background: linear-gradient(135deg, #2b2d7f 0%, #3949ab 100%) !important;
        color: white !important;
        font-weight: 500;
    }

    td.fondo2 {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        color: white !important;
        font-weight: 500;
    }

    td.fondo3 {
        background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%) !important;
        color: white !important;
        font-weight: 500;
    }

    td.cuenta {
        background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%) !important;
        color: white !important;
        font-weight: 500;
    }

    .action-btn {
        margin: 2px;
        border-radius: 6px;
        padding: 8px 12px;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ffb302 100%);
        border: none;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
    }

    .status-indicator {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .status-occupied { background: #2b2d7f; }
    .status-discharged { background: #28a745; }
    .status-maintenance { background: #dc3545; }
    .status-releasing { background: #fd7e14; }
    .status-available { background: #6c757d; }

    .legend-container {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin: 20px;
        border: 1px solid #e9ecef;
    }

    .legend-item {
        display: inline-flex;
        align-items: center;
        margin: 5px 15px 5px 0;
        font-size: 12px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .main-container {
            margin: 10px;
            border-radius: 10px;
        }

        .census-section {
            margin: 10px;
        }

        .header-section {
            padding: 20px 15px;
        }

        .header-section h2 {
            font-size: 22px;
        }

        .table thead th,
        .table tbody td {
            padding: 6px 3px;
            font-size: 10px;
        }

        .action-btn {
            padding: 6px 8px;
            margin: 1px;
        }
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
</head>

<body>
  <div class="container-fluid">
    <a class="btn-back" onclick="history.back()">
        <i class="fas fa-arrow-left"></i> Regresar
    </a>

    <div class="main-container">
        <div class="header-section">
            <h2>
                <i class="fas fa-hospital-user"></i>
                CENSO ADMINISTRATIVO DE PACIENTES
            </h2>
        </div>

        <!-- Leyenda de estados -->
        <div class="legend-container">
            <strong>Leyenda de Estados:</strong>
            <div class="mt-2">
                <span class="legend-item">
                    <span class="status-indicator status-occupied"></span>
                    Ocupado - Sin Alta
                </span>
                <span class="legend-item">
                    <span class="status-indicator status-discharged"></span>
                    Ocupado - Con Alta
                </span>
                <span class="legend-item">
                    <span class="status-indicator status-maintenance"></span>
                    Mantenimiento
                </span>
                <span class="legend-item">
                    <span class="status-indicator status-releasing"></span>
                    Por Liberar
                </span>
                <span class="legend-item">
                    <span class="status-indicator status-available"></span>
                    Disponible
                </span>
            </div>
        </div>

        <!-- Botón de impresión general -->
        <div style="padding: 0 20px 20px 20px;">
            <a href="../../gestion_administrativa/censo/pdf_censo_comp.php" class="btn-print" target="_blank">
                <i class="fas fa-print"></i> Imprimir Censo Completo
            </a>
        </div>

        <!-- Sección Hospitalización -->
        <div class="census-section">
            <div class="section-header">
                <i class="fas fa-hospital"></i> HOSPITALIZACIÓN - GESTIÓN ADMINISTRATIVA
            </div>

            <div class="search-container">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="search" placeholder="🔍 Buscar paciente, habitación o médico...">
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-striped table-hover" id="mytable">
                    <thead>
                        <tr>
                            <th>Cuenta</th>
                            <th>Cambiar</th>
                            <th>Hab</th>
                            <th>Fecha Ingreso</th>
                            <th>Paciente</th>
                            <th>Edad</th>
                            <th>Motivo Ingreso</th>
                            <th>Exp</th>
                            <th>Médico Tratante</th>
                            <th>Alta Médica</th>
                            <th>Aviso de Alta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $sql = "SELECT * from cat_camas where TIPO ='HOSPITALIZACION' ORDER BY num_cama ASC ";
                            $result = $conexion->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                $id_at_cam = $row['id_atencion'];
                                $estatus = $row['estatus'];
                                $usuario = $_SESSION['login'];
                                $id_usua= $usuario['id_usua'];
                                $rol= $usuario['id_rol'];
                                $sql_tabla = "SELECT p.fecnac,p.Id_exp,p.folio, p.papell, p.sapell,p.nom_pac, di.fecha, di.motivo_recepcion, di.alta_med,ru.pre, ru.papell as nom_doc from dat_ingreso di, paciente p, reg_usuarios ru WHERE p.Id_exp = di.Id_exp and di.id_usua = ru.id_usua and di.id_atencion = $id_at_cam LIMIT 1";
                                $result_tabla = $conexion->query($sql_tabla);
                                $rowcount = mysqli_num_rows($result_tabla);
                                if ($rowcount != 0) {
                                    while ($row_tabla = $result_tabla->fetch_assoc()) {
                                        $alta=$row_tabla['alta_med'];
                                        if($alta=='SI'){
                                            echo '<td><a class="btn btn-warning action-btn" href="../cuenta_paciente/detalle_cuenta.php?id_at='.$id_at_cam.'&id_exp='. $row_tabla['folio'].'&id_usua='.$id_usua.'&rol='.$rol.'" title="Ver Cuenta"><i class="fas fa-dollar-sign"></i></a></td>';
                                            echo '<td><a class="btn btn-success action-btn" href="cambio.php?id_cama='.$row['num_cama'] .'&id_atencion='.$row['id_atencion'].'&tipo='.$row['tipo'].'&hab='.$row['habitacion'].'" title="Cambiar Cama"><i class="fas fa-bed"></i></a></td>';
                                            echo '<td class="fondo2">' . $row['num_cama'] . '</td>';
                                            echo '<td class="fondo2">' . date('d/m/Y H:i', strtotime($row_tabla['fecha'])) . '</td>';
                                            echo '<td class="fondo2">' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . ' ' .$row_tabla['nom_pac'] . '</td>';
                                            echo '<td class="fondo2">' . calculaedad($row_tabla['fecnac']) .'</td>';
                                            echo '<td class="fondo2">' . $row_tabla['motivo_recepcion'] . '</td>';
                                            echo '<td class="fondo2">' . $row_tabla['folio'] . '</td>';
                                            echo '<td class="fondo2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</td>';
                                            echo '<td class="fondo2">✅ ' . $row_tabla['alta_med'] . '</td>';
                                            echo '<td>-</td>';
                                            echo '</tr>';
                                        } else {
                                            echo '<td><a class="btn btn-warning action-btn" href="../cuenta_paciente/detalle_cuenta.php?id_at='.$id_at_cam.'&id_exp='. $row_tabla['folio'].'&id_usua='.$id_usua.'&rol='.$rol.'" title="Ver Cuenta"><i class="fas fa-dollar-sign"></i></a></td>';
                                            echo '<td><a class="btn btn-success action-btn" href="cambio.php?id_cama='.$row['num_cama'] .'&id_atencion='.$row['id_atencion'].'&tipo='.$row['tipo'].'&hab='.$row['habitacion'].'" title="Cambiar Cama"><i class="fas fa-bed"></i></a></td>';
                                            echo '<td class="fondo">' . $row['num_cama'] . '</td>';
                                            echo '<td class="fondo">' . date('d/m/Y H:i', strtotime($row_tabla['fecha'])) . '</td>';
                                            echo '<td class="fondo">' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . ' ' .$row_tabla['nom_pac']  . '</td>';
                                            echo '<td class="fondo">' . calculaedad($row_tabla['fecnac']) . '</td>';
                                            echo '<td class="fondo">' . $row_tabla['motivo_recepcion'] . '</td>';
                                            echo '<td class="fondo">' . $row_tabla['folio'] . '</td>';
                                            echo '<td class="fondo">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</td>';
                                            echo '<td class="fondo">❌ ' . $row_tabla['alta_med'] . '</td>';
                                            echo '<td><a class="btn btn-danger action-btn" href="aviso_alta.php?id_atencion='.$id_at_cam.'" title="Aviso de Alta"><i class="fa fa-plus-square"></i></a></td>';
                                            echo '</tr>';
                                        }
                                    }
                                } elseif($estatus=="MANTENIMIENTO"){
                                    echo '<td class="cuenta">-</td>';
                                    echo '<td class="cuenta">-</td>';
                                    echo '<td class="cuenta">' . $row['num_cama'] . '</td>';
                                    echo '<td class="cuenta">🔧</td>';
                                    echo '<td class="cuenta">HABITACIÓN EN</td>';
                                    echo '<td class="cuenta">MANTENIMIENTO</td>';
                                    echo '<td class="cuenta">NO DISPONIBLE</td>';
                                    echo '<td class="cuenta">-</td>';
                                    echo '<td class="cuenta">-</td>';
                                    echo '<td class="cuenta">-</td>';
                                    echo '<td class="cuenta">-</td></tr>';
                                } elseif($estatus=="EN PROCESO DE LIBERA"){
                                    echo '<td class="fondo3">-</td>';
                                    echo '<td class="fondo3">-</td>';
                                    echo '<td class="fondo3">' . $row['num_cama'] . '</td>';
                                    echo '<td class="fondo3">⏳</td>';
                                    echo '<td class="fondo3">HABITACIÓN</td>';
                                    echo '<td class="fondo3">POR LIBERAR</td>';
                                    echo '<td class="fondo3">-</td>';
                                    echo '<td class="fondo3">-</td>';
                                    echo '<td class="fondo3">-</td>';
                                    echo '<td class="fondo3">-</td>';
                                    echo '<td class="fondo3">-</td></tr>';
                                } else {
                                    echo '<td>-</td>';
                                    echo '<td>-</td>';
                                    echo '<td>' . $row['num_cama'] . '</td>';
                                    echo '<td>✅</td>';
                                    echo '<td colspan="7" style="text-align: center; color: #28a745; font-weight: 600;">HABITACIÓN DISPONIBLE</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Agregar tooltips a los botones
            $('[title]').tooltip();
        });
    </script>

</section>

<footer class="main-footer">
    <?php

 function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
        $bisiesto=true;
        return $bisiesto;
 }

 function calculaedad($fecnac)
 {

$fecha_actual = date("Y-m-d");
$fecha_nac=$fecnac;
$fecha_de_nacimiento =strval($fecha_nac);

// separamos en partes las fechas
$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
$array_actual = explode ( "-", $fecha_actual );

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

//ajuste de posible negativo en $días
if ($dias < 0)
{
    --$meses;

    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
    switch ($array_actual[1]) {
           case 1:     $dias_mes_anterior=31; break;
           case 2:     $dias_mes_anterior=31; break;
           case 3:
               if (bisiesto($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }

           case 4:     $dias_mes_anterior=31; break;
           case 5:     $dias_mes_anterior=30; break;
           case 6:     $dias_mes_anterior=31; break;
           case 7:     $dias_mes_anterior=30; break;
           case 8:     $dias_mes_anterior=31; break;
           case 9:     $dias_mes_anterior=31; break;
           case 10:    $dias_mes_anterior=30; break;
           case 11:    $dias_mes_anterior=31; break;
           case 12:    $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

 if($anos > "0" ){
   $edad = $anos." años";
}elseif($anos <="0" && $meses>"0"){
   $edad = $meses." meses";

}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    $edad = $dias." días";
}

 return $edad;
}

    include("../../template/footer.php");
    ?>
  </footer>

  <script>
    document.oncontextmenu = function() {
      return false;
    }
  </script>
  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>

</html>
