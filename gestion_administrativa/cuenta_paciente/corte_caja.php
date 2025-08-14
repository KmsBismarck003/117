<?php
session_start();
//include "../conexionbd.php";

$usuario = $_SESSION['login'];
include "../../gestion_administrativa/header_administrador.php";

$resultado=$conexion->query("select * from reg_usuarios") or die($conexion->error);
?>
<!DOCTYPE html>
<html>
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
            max-width: 1000px;
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
            padding: 40px;
        }
        
        .report-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }
        
        .report-card:hover {
            border-color: #2b2d7f;
            box-shadow: 0 8px 25px rgba(43, 45, 127, 0.1);
        }
        
        .report-card h5 {
            color: #2b2d7f;
            font-weight: 600;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #2b2d7f;
            font-size: 20px;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #2b2d7f 0%, #3949ab 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(43, 45, 127, 0.3);
            color: white;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(43, 45, 127, 0.4);
            color: white;
        }
        
        .btn-excel {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            color: white;
        }
        
        .btn-excel:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            color: white;
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
        
        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #2b2d7f;
            box-shadow: 0 0 0 0.2rem rgba(43, 45, 127, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: #2b2d7f;
            margin-bottom: 8px;
        }
        
        .date-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        
        .btn-container {
            display: flex;
            gap: 15px;
            align-items: end;
        }
        
        .icon-excel {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }
        
        @media (max-width: 768px) {
            .content-section {
                padding: 20px;
            }
            .report-card {
                padding: 20px;
            }
            .btn-container {
                flex-direction: column;
                gap: 10px;
            }
            .header-section h2 {
                font-size: 22px;
            }
        }
    </style>

    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function () {
            $("#search").keyup(function () {
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function () {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
    </script>
    <title>Corte de Caja - Reportes Financieros</title>
</head>
<body>

<div class="container-fluid">
    <a class="btn-back" onclick="history.back()">
        <i class="fas fa-arrow-left"></i> Regresar
    </a>
    
    <div class="main-container">
        <div class="header-section">
            <h2>
                <i class="fas fa-cash-register"></i>
                CORTE DE CAJA - REPORTES FINANCIEROS
            </h2>
        </div>
        
        <div class="content-section">
            <form action="pdf_cortecaja.php" target="_blank" method="POST">
                <div class="report-card">
                    <h5><i class="fas fa-calendar-alt"></i> Reporte por Rango de Fechas</h5>
                    
                    <div class="date-container">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label for="anio" class="form-label">Fecha Inicial:</label>
                                <input type="date" class="form-control" name="anio" id="anio" required>
                            </div>
                            <div class="col-md-3">
                                <label for="aniofinal" class="form-label">Fecha Final:</label>
                                <input type="date" class="form-control" name="aniofinal" id="aniofinal" required>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-container">
                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="fas fa-file-pdf"></i> Generar PDF
                                    </button>
                                    <a href="excel_corte.php" class="btn btn-excel">
                                        <img src="https://img.icons8.com/color/24/000000/ms-excel.png" class="icon-excel" alt="Excel"/>
                                        Exportar Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/main.js"></script>

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

<script>
    // Establecer fecha actual como valor por defecto
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const fechaInicialInput = document.getElementById('anio');
        const fechaFinalInput = document.getElementById('aniofinal');
        
        if (!fechaInicialInput.value) {
            fechaInicialInput.value = today;
        }
        if (!fechaFinalInput.value) {
            fechaFinalInput.value = today;
        }
    });
</script>

</body>
</html>