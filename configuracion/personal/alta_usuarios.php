<?php
session_start();
//include "../../conexionbd.php";
include "../header_configuracion.php";
$resultado=$conexion->query("select * from reg_usuarios") or die($conexion->error);

$usuario=$_SESSION['login'];
$rol=$usuario['id_rol'];
$id_usu=$usuario['id_usua'];
?>
<!DOCTYPE html>
<html> 

<head><meta charset="gb18030">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBn                                           }elseif($rol == 12){
                                $resultado1 = $conexion ->query("SELECT * FROM rol where id_rol=2 or id_rol=3 or id_rol=12")or die($conexion->error); ?>
                                <select name="id_rol" class="form-control select-custom" required>
                                    <option value="">🔐 Seleccionar Rol de Acceso</option>
                                    <?php foreach ($resultado1 as $opciones):?>
                                        <option value="<?php echo $opciones['id_rol']?>">👤 <?php echo $opciones['rol']?></option>
                                    <?php endforeach?>
                                </select>     }elseif($rol == 5){
                                $resultado1 = $conexion ->query("SELECT * FROM rol")or die($conexion->error); ?>
                                <select name="id_rol" class="form-control select-custom" required>
                                    <option value="">🔐 Seleccionar Rol de Acceso</option>
                                    <?php foreach ($resultado1 as $opciones):?>
                                        <option value="<?php echo $opciones['id_rol']?>">👤 <?php echo $opciones['rol']?></option>
                                    <?php endforeach?>
                                </select>ew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

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

    <style>
        /* Estilos modernos para lista de personal */
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Contenedor principal */
        .main-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(43, 45, 127, 0.1);
            margin: 20px auto;
            overflow: hidden;
            max-width: 95%;
        }

        /* Header mantenido como está pero mejorado */
        .thead {
            background: linear-gradient(135deg, #2b2d7f 0%, #3b3f8f 100%) !important;
            color: white !important;
            font-size: 24px !important;
            padding: 25px !important;
            text-align: center !important;
            margin: 0 !important;
            border-radius: 15px 15px 0 0 !important;
        }

        /* Área de botones moderna */
        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Botón de exportar Excel moderno */
        .btn-excel-modern {
            background: linear-gradient(135deg, #00f525ff 0%, #00f525ff 100%);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-excel-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 152, 0, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Botón nuevo usuario moderno */
        .btn-nuevo-modern {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-nuevo-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
            color: white;
        }

        /* Campo de búsqueda moderno */
        .search-container {
            padding: 20px 30px;
            background: white;
            border-bottom: 1px solid #e9ecef;
        }

        .search-input {
            border: 2px solid #e9ecef;
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 300px;
            margin-left: auto;
            display: block;
        }

        .search-input:focus {
            border-color: #2b2d7f;
            box-shadow: 0 0 0 0.3rem rgba(43, 45, 127, 0.15);
            outline: none;
        }

        /* Tabla moderna */
        .table-container {
            padding: 30px;
            background: white;
        }

        .table-modern {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .table-modern thead th {
            background: linear-gradient(135deg, #2b2d7f 0%, #3b3f8f 100%);
            color: white;
            font-weight: 600;
            padding: 18px 15px;
            border: none;
            text-align: center;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f3f4;
        }

        .table-modern tbody tr:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table-modern tbody td {
            padding: 15px;
            vertical-align: middle;
            border: none;
            font-size: 14px;
            color: #495057;
        }

        /* Botones de acción modernos */
        .btn-action-modern {
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 2px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-edit-modern {
            background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
            color: white;
        }

        .btn-edit-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-view-modern {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
        }

        .btn-view-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-status-active {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }

        .btn-status-active:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-status-inactive {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .btn-status-inactive:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Modal moderno */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, #2b2d7f 0%, #3b3f8f 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px 30px;
        }

        .modal-title {
            font-weight: 600;
            font-size: 20px;
        }

        .modal-body {
            padding: 30px;
        }

        .modal-body h6 {
            color: #2b2d7f;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }

        .modal-body h6 i {
            margin-right: 10px;
            color: #2b2d7f;
        }

        .form-group {
            margin-bottom: 25px;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-group:hover {
            background: rgba(43, 45, 127, 0.03);
            transform: translateX(5px);
        }

        .form-group label {
            color: #2b2d7f;
            font-weight: 700;
            margin-bottom: 12px;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group label i {
            color: #2b2d7f;
            margin-right: 10px;
            width: 18px;
            text-align: center;
            font-size: 16px;
        }

        .form-control {
            border: 4px solid #e9ecef;
            border-radius: 10px;
            padding: 15px 18px;
            transition: all 0.3s ease;
            font-size: 15px;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #2b2d7f;
            box-shadow: 0 0 0 0.3rem rgba(43, 45, 127, 0.25);
            transform: translateY(-2px);
        }

        /* Estilos especiales para select normales (no custom) */
        .form-control select:not(.select-custom),
        select.form-control:not(.select-custom) {
            border: 4px solid #e9ecef;
            border-radius: 10px;
            padding: 15px 18px;
            font-size: 15px;
            font-weight: 600;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232b2d7f' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 45px;
        }

        .form-control select:not(.select-custom):focus,
        select.form-control:not(.select-custom):focus {
            border-color: #2b2d7f;
            box-shadow: 0 0 0 0.3rem rgba(43, 45, 127, 0.25);
            transform: translateY(-2px);
        }

        .form-control select:not(.select-custom):hover,
        select.form-control:not(.select-custom):hover {
            border-color: #2b2d7f;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        /* Estilos especiales para select-custom (prefijo y rol) */
        .select-custom {
            border: 5px solid #2b2d7f !important;
            border-radius: 12px !important;
            padding: 18px 20px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            background: #ffffff !important;
            color: #2b2d7f !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(43, 45, 127, 0.1);
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232b2d7f' stroke-width='4' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 18px center !important;
            background-size: 20px !important;
            padding-right: 55px !important;
            height: auto !important;
            min-height: 60px !important;
        }

        .select-custom:focus {
            border-color: #1a1d5f !important;
            box-shadow: 0 0 0 0.4rem rgba(43, 45, 127, 0.3) !important;
            transform: translateY(-3px) !important;
            background: #f8f9fa !important;
            outline: none !important;
        }

        .select-custom:hover {
            border-color: #1a1d5f !important;
            background: #f8f9fa !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(43, 45, 127, 0.15);
        }

        .select-custom option {
            padding: 10px;
            font-weight: 600;
            color: #2b2d7f;
            background: white;
        }

        /* Estilos especiales para inputs de archivo */
        .form-control[type="file"] {
            border: 4px dashed #2b2d7f;
            border-radius: 12px;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            text-align: center;
            font-weight: 600;
            color: #2b2d7f;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-control[type="file"]:hover {
            border-color: #1a1d5f;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            transform: translateY(-2px);
        }

        .form-control[type="file"]:focus {
            border-color: #1a1d5f;
            box-shadow: 0 0 0 0.3rem rgba(43, 45, 127, 0.25);
        }

        /* Contenedor personalizado para archivos */
        .file-upload-container {
            position: relative;
            border: 4px dashed #2b2d7f;
            border-radius: 15px;
            padding: 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-container:hover {
            border-color: #1a1d5f;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(43, 45, 127, 0.15);
        }

        .file-upload-container input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0;
        }

        .file-upload-text {
            color: #2b2d7f;
            font-weight: 600;
        }

        .file-upload-text i {
            color: #2b2d7f;
            display: block;
            margin-bottom: 10px;
        }

        .file-upload-text p {
            margin: 10px 0 5px 0;
            font-size: 16px;
            font-weight: 700;
        }

        .file-upload-text small {
            color: #6c757d;
            font-size: 12px;
            font-weight: 500;
        }

        .modal-footer {
            padding: 20px 30px;
            border-top: 1px solid #e9ecef;
        }

        .modal-footer .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            margin: 0 5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                align-items: stretch;
            }
            
            .btn-excel-modern,
            .btn-nuevo-modern {
                justify-content: center;
                width: 100%;
            }
            
            .search-input {
                max-width: 100%;
            }
            
            .table-container {
                padding: 15px;
                overflow-x: auto;
            }
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .main-container {
            animation: fadeIn 0.5s ease-in-out;
        }

        /* ESTILOS PRIORITARIOS PARA SELECT-CUSTOM */
        select.select-custom,
        .select-custom {
            display: block !important;
            width: 100% !important;
            height: 60px !important;
            border: 5px solid #2b2d7f !important;
            border-radius: 12px !important;
            padding: 15px 50px 15px 20px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            background: #ffffff !important;
            color: #2b2d7f !important;
            box-shadow: 0 4px 15px rgba(43, 45, 127, 0.1) !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232b2d7f' stroke-width='4' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 18px center !important;
            background-size: 20px !important;
            cursor: pointer !important;
            z-index: 1 !important;
        }

        select.select-custom:hover,
        .select-custom:hover {
            border-color: #1a1d5f !important;
            background: #f8f9fa !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(43, 45, 127, 0.15) !important;
        }

        select.select-custom:focus,
        .select-custom:focus {
            border-color: #1a1d5f !important;
            box-shadow: 0 0 0 0.4rem rgba(43, 45, 127, 0.3) !important;
            transform: translateY(-3px) !important;
            background: #f8f9fa !important;
            outline: none !important;
        }
    </style>
</head>

<body>
<div class="main-container">
    <!-- Header mantenido como está -->
    <div class="thead">
        <strong>LISTA DE PERSONAL</strong>
    </div>

    <!-- Área de botones modernizada -->
    <div class="action-buttons">
        <div>
            <?php if($id_usu == 1){?>
                <a href="excelpersonal.php" class="btn-excel-modern">
                    <i class="fas fa-file-excel"></i>
                    <span>Exportar a Excel</span>
                </a>
            <?php }?>
        </div>
        <div>
            <button type="button" class="btn-nuevo-modern" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-plus"></i>
                <span>Nuevo usuario</span>
            </button>
        </div>
    </div>

<!-- Modal Moderno -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="insertar_usuario.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-user-plus"></i> NUEVO USUARIO
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Columna 1: Datos personales -->
                    <div class="col-md-6">
                        <h6 style="color: #2b2d7f; font-weight: 600; margin-bottom: 15px;">
                            <i class="fas fa-user"></i> Datos Personales
                        </h6>
                        
                        <div class="form-group">
                            <label for="curp_u"><i class="fas fa-id-card"></i> CURP:</label>
                            <input type="text" size="18" name="curp_u" id="curp_u" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div> 

                        <div class="form-group">
                            <label for="papell"><i class="fas fa-user-tag"></i> Primer Apellido:</label>
                            <input type="text" name="papell" id="papell" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="sapell"><i class="fas fa-user-tag"></i> Segundo Apellido:</label>
                            <input type="text" name="sapell" id="sapell" class="form-control" required>
                        </div> 
                        
                        <div class="form-group">
                            <label for="nombre"><i class="fas fa-signature"></i> Nombre(s):</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="fecha"><i class="fas fa-calendar-alt"></i> Fecha de nacimiento:</label>
                            <input type="date" name="fecnac" id="fecha" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="tel"><i class="fas fa-phone"></i> Teléfono:</label>
                            <input type="number" name="tel" id="tel" class="form-control" required>
                        </div>
                    </div>

                    <!-- Columna 2: Datos profesionales y sistema -->
                    <div class="col-md-6">
                        <h6 style="color: #2b2d7f; font-weight: 600; margin-bottom: 15px;">
                            <i class="fas fa-briefcase"></i> Datos Profesionales
                        </h6>

                        <div class="form-group">
                            <label for="cedp"><i class="fas fa-certificate"></i> Cédula profesional:</label>
                            <input type="text" name="cedp" id="cedp" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="cargp"><i class="fas fa-stethoscope"></i> Especialidad:</label>
                            <input type="text" name="cargp" id="cargp" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> E-mail:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="pre"><i class="fas fa-user-md"></i> Prefijo:</label>
                            <select name="pre" class="form-control select-custom" required>
                                <option value="">🔹 Seleccionar Prefijo</option>
                                <option value="Dra">👩‍⚕️ Dra</option>
                                <option value="Dr">👨‍⚕️ Dr</option>
                                <option value="Lic">🎓 Lic</option>
                                <option value="L.N">👶 L.N.</option>
                                <option value="Psic">🧠 Psic</option>   
                                <option value="Enf">💉 Enf</option> 
                                <option value="I.Q">🔬 I.Q</option> 
                                <option value="Rad">📡 Rad</option>
                                <option value="C">📋 C.</option>
                                <option value="Ing">⚙️ Ing.</option> 
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="usuario"><i class="fas fa-user-circle"></i> Usuario:</label>
                            <input type="text" name="usuario" id="usuario" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="pass"><i class="fas fa-lock"></i> Contraseña:</label>
                            <input type="password" name="pass" id="pass" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Sección de archivos y rol -->
                <div class="row">
                    <div class="col-md-6">
                        <h6 style="color: #2b2d7f; font-weight: 600; margin-bottom: 15px;">
                            <i class="fas fa-file-upload"></i> Archivos
                        </h6>
                        
                        <div class="form-group">
                            <label for="img_perfil"><i class="fas fa-image"></i> Imagen del perfil:</label>
                            <div class="file-upload-container">
                                <input type="file" name="img_perfil" id="img_perfil" class="form-control" required="" accept="image/*">
                                <div class="file-upload-text">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 24px; margin-bottom: 8px;"></i>
                                    <p>Seleccionar imagen del perfil</p>
                                    <small>Formatos: JPG, PNG, GIF (Max: 2MB)</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="firma"><i class="fas fa-signature"></i> Firma digitalizada:</label>
                            <div class="file-upload-container">
                                <input type="file" name="firma" id="firma" class="form-control" required="" accept="image/*">
                                <div class="file-upload-text">
                                    <i class="fas fa-pen-fancy" style="font-size: 24px; margin-bottom: 8px;"></i>
                                    <p>Seleccionar firma digitalizada</p>
                                    <small>Formatos: JPG, PNG (Max: 1MB)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 style="color: #2b2d7f; font-weight: 600; margin-bottom: 15px;">
                            <i class="fas fa-shield-alt"></i> Permisos
                        </h6>
                        
                        <div class="form-group">
                            <label for="id_usua"><i class="fas fa-user-shield"></i> Rol de acceso:</label>
                            <?php 
                            $usuario=$_SESSION['login'];
                            $rol=$usuario['id_rol'];
                            if($rol == 1 ){
                                $resultado1 = $conexion ->query("SELECT * FROM rol where id_rol!=5")or die($conexion->error); ?>
                                <select name="id_rol" class="form-control select-custom" required>
                                    <option value="">🔐 Seleccionar Rol de Acceso</option>
                                    <?php foreach ($resultado1 as $opciones):?>
                                        <option value="<?php echo $opciones['id_rol']?>">👤 <?php echo $opciones['rol']?></option>
                                    <?php endforeach?>
                                </select>
                            <?php }elseif($rol == 5){
                                $resultado1 = $conexion ->query("SELECT * FROM rol")or die($conexion->error); ?>
                                <select name="id_rol" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($resultado1 as $opciones):?>
                                        <option value="<?php echo $opciones['id_rol']?>"><?php echo $opciones['rol']?></option>
                                    <?php endforeach?>
                                </select>
                            <?php }elseif($rol == 12){
                                $resultado1 = $conexion ->query("SELECT * FROM rol where id_rol=2 or id_rol=3 or id_rol=12")or die($conexion->error); ?>
                                <select name="id_rol" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($resultado1 as $opciones):?>
                                        <option value="<?php echo $opciones['id_rol']?>"><?php echo $opciones['rol']?></option>
                                    <?php endforeach?>
                                </select>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-top: 2px solid #2b2d7f;">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="fas fa-save"></i> Guardar Usuario
                </button>
                <button type="button" class="btn btn-secondary-custom" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
    </div>
    </form>

  </div>
</div>

<section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->


    <div class="container box">
        <div class="content">


            <?php

            include "../../conexionbd.php";
            $resultado2=$conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
            ?>

            <!-- Campo de búsqueda moderno -->
            <div class="search-container">
                <input type="text" class="search-input" id="search" placeholder="🔍 Buscar personal...">
            </div>

            <!-- Tabla moderna -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-modern" id="mytable">
                        <thead>
                            <tr>
                                <th>Editar</th>
                                <th>Ver datos</th>
                                <th>Id</th>
                                <th>Usuario</th>
                                <th>Primer apellido</th>
                                <th>Segundo apellido</th>
                                <th>Nombre(s)</th>                       
                                <th>Cédula profesional</th>
                                <th>Función</th>
                                <th>Activo</th>
                            </tr>
                        </thead>
                        <tbody>

                    <?php
                    $resultado2=$conexion->query("SELECT id_usua, curp_u, nombre,papell,sapell,fecnac,mat,cedp,cargp,tel,email,u_activo,usuario FROM reg_usuarios") or die($conexion->error);

                    $no = 1;
                    while ($row = $resultado2->fetch_assoc()) {
                         $eid = $row['id_usua'];
                        echo '<tr>'
                        . '<td><a href="editar_usuario.php?id_usua=' . $row['id_usua'] . '" title="Editar datos" class="btn-action-modern btn-edit-modern"><i class="fas fa-edit"></i></a></td>'
                        . '<td><a href="mostrar_usuario.php?id_usua=' . $row['id_usua'] . '" title="Mostrar datos" class="btn-action-modern btn-view-modern"><i class="fas fa-eye"></i></a></td>'
                        . '<td><span style="font-weight: 600; color: #2b2d7f;">' . $row['id_usua'] . '</span></td>'
                        . '<td><strong>'. $row['usuario'] . '</strong></td>'
                        . '<td>' . $row['papell']. '</td>'
                        . '<td>' . $row['sapell']. '</td>'
                        . '<td>' . $row['nombre'] . '</td>'
                        . '<td><span style="color: #17a2b8; font-weight: 500;">' . $row['cedp'] . '</span></td>'
                        . '<td><span style="color: #28a745; font-weight: 500;">' . $row['cargp'] . '</span></td>';
                        ?>
                        <td>
                            <?php
                            if ((strpos($row['u_activo'], 'NO') !== false)) {
                                echo '<a class="btn-action-modern btn-status-inactive" href="activo.php?q=estatus&eid=' . $eid . '&est=' . $row['u_activo'] . '" title="Activar usuario"><i class="fas fa-power-off"></i></a>';
                            } else {
                                echo '<a class="btn-action-modern btn-status-active" href="activo.php?q=estatus&eid=' . $eid . '&est=' . $row['u_activo'] . '" title="Desactivar usuario"><i class="fas fa-power-off"></i></a>';
                            }
                            ?>
                        </td>
                        <?php
                        echo '</tr>';
                        $no++;
                    }
                    ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
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

<script>
$(document).ready(function() {
    // Asegurar que los select-custom se muestren correctamente
    $('.select-custom').each(function() {
        $(this).css({
            'display': 'block',
            'visibility': 'visible',
            'opacity': '1',
            'z-index': '999'
        });
    });
    
    // Debug: Verificar si los selects están cargados
    console.log('Selects encontrados:', $('.select-custom').length);
    
    // Añadir eventos para mejorar la funcionalidad
    $('.select-custom').on('focus', function() {
        $(this).css('transform', 'translateY(-3px)');
    }).on('blur', function() {
        $(this).css('transform', 'translateY(0)');
    });
});
</script>


</body>
</html>