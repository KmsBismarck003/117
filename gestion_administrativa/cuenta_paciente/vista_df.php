<?php
session_start();
include "../../conexionbd.php";
include '../../conn_almacen/Connection.php';
include "../../gestion_administrativa/header_administrador.php";
$usuario = $_SESSION['login'];
$usuario1 = $usuario['id_usua'];
$rol = $usuario['id_rol'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <link rel="icon" href="../../imagenes/SIF.PNG">
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

    <title>Menu Gestión administrativa </title>
    <link rel="shortcut icon" href="logp.png">
    
    <!-- Estilos modernos para vista_df.php -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .container-fluid {
            padding: 20px;
        }
        
        /* Botones modernos */
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }
        
        /* Header mejorado */
        .thead {
            background: linear-gradient(135deg, #2b2d7f 0%, #3c3f8f 100%) !important;
            color: white !important;
            font-size: 18px !important;
            padding: 20px !important;
            border-radius: 10px !important;
            margin-bottom: 20px !important;
            box-shadow: 0 4px 15px rgba(43, 45, 127, 0.3) !important;
            text-align: center !important;
        }
        
        /* Buscador mejorado */
        .form-group {
            margin: 20px 0;
        }
        
        #search {
            border-radius: 25px !important;
            border: 2px solid #e9ecef !important;
            padding: 12px 20px !important;
            font-size: 16px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
        }
        
        #search:focus {
            border-color: #2b2d7f !important;
            box-shadow: 0 0 0 0.2rem rgba(43, 45, 127, 0.25) !important;
            outline: none !important;
        }
        
        /* Tabla mejorada */
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            background: white;
            margin: 20px 0;
        }
        
        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #2b2d7f 0%, #3c3f8f 100%);
            color: white;
            border: none;
            padding: 15px 12px;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
            font-size: 13px;
        }
        
        /* Botones de acción mejorados */
        .table .btn-sm {
            padding: 8px 12px;
            margin: 2px;
            border-radius: 6px;
            font-size: 16px;
        }
        
        /* Colores especiales para celdas */
        .table td[bgcolor="green"] {
            background: linear-gradient(135deg, #27ae60, #2ecc71) !important;
            color: white !important;
            border-radius: 6px;
            font-weight: 600;
        }
        
        .table td[style*="background:grey"] {
            background: linear-gradient(135deg, #7f8c8d, #95a5a6) !important;
            color: white !important;
            border-radius: 6px;
            font-weight: 600;
        }
        
        /* Números y totales */
        .table td font[color="red"] {
            color: #e74c3c !important;
            font-weight: 700 !important;
            font-size: 16px !important;
        }
        
        /* Animaciones suaves */
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
        
        .table-responsive {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Responsividad mejorada */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 10px;
            }
            
            .table {
                font-size: 11px;
            }
            
            .btn {
                padding: 6px 12px;
                font-size: 12px;
            }
            
            .thead {
                font-size: 16px !important;
                padding: 15px !important;
            }
        }
        
        /* Card wrapper para mejor presentación */
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        /* Header de página mejorado */
        .page-header {
            background: linear-gradient(135deg, #2b2d7f 0%, #667eea 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(43, 45, 127, 0.3);
        }
        
        .page-header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 24px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
    </style>
</head>

<div class="container-fluid">
    <!-- Header de página moderno -->
    <div class="page-header">
        <h1><i class="fas fa-file-invoice-dollar"></i> CUENTA DE PACIENTES ACTIVOS</h1>
    </div>

    <!-- Botones de acción -->
    <div class="content-card">
        <div class="row align-items-center">
            <div class="col-md-3">
                <button type="button" class="btn btn-danger" onclick="history.back()">
                    <i class="fas fa-arrow-left"></i> Regresar
                </button>
            </div>
            <?php if ($usuario['id_usua'] == 1) { ?>
                <div class="col-md-6">
                    <a href="vista_pagadas.php" class="btn btn-primary">
                        <i class="fas fa-check-circle"></i> Cuentas Pagadas
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="excel_cuentas_activas.php" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Exportar Excel
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Buscador mejorado -->
    <div class="content-card">
        <div class="row">
            <div class="col-md-6">
                <h5><i class="fas fa-search"></i> Buscar en la tabla</h5>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" id="search" placeholder="🔍 Buscar por nombre, expediente, habitación...">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-striped table-hover" id="mytable">
            <thead>
                <tr>
                    <th scope="col"><i class="fas fa-cogs"></i> Acciones</th>
                    <th scope="col"><i class="fas fa-file-medical"></i> Exp</th>
                    <th scope="col"><i class="fas fa-hashtag"></i> ID Atención</th>
                    <th scope="col"><i class="fas fa-bed"></i> Hab</th>
                    <th scope="col"><i class="fas fa-user"></i> Paciente</th>
                    <th scope="col"><i class="fas fa-user-md"></i> Médico</th>
                    <th scope="col"><i class="fas fa-stethoscope"></i> Especialidad</th>
                    <th scope="col"><i class="fas fa-building"></i> Cliente</th>
                    <th scope="col"><i class="fas fa-calculator"></i> Subtotal</th>
                    <th scope="col"><i class="fas fa-percent"></i> IVA</th>
                    <th scope="col" style="background: linear-gradient(135deg, #27ae60, #2ecc71); color: white;">
                        <i class="fas fa-dollar-sign"></i> Total
                    </th>
                    <th scope="col"><i class="fas fa-money-bill"></i> Anticipos</th>
                    <th scope="col"><i class="fas fa-calendar"></i> Fecha Ingreso</th>
                </tr>
            </thead>
            <tbody>

            <?php
                        $resultado = $conexion->query("SELECT * from cat_camas c, dat_ingreso di, paciente p  WHERE c.id_atencion=di.id_atencion and p.Id_exp=di.Id_exp and di.activo='SI'  ORDER BY di.fecha DESC") or die($conexion->error);
                        while ($f = $resultado->fetch_assoc()) {
                            $nombre=$f['papell'].' '.$f['sapell'].' ' .$f['nom_pac'];
                            $id_atencion=$f['id_atencion'];
                            $id_exp = $f['Id_exp'];
                            $cama = $f['num_cama'];
                            $date = date_create($f['fecha']);
                            $fecing = date_format($date, "d/m/Y h:i A");
                            $asegura = $f['aseg'];
                            $medico = $f['id_usua'];
                            $especialidad = $f['tipo_a'];
                            $total = 0;
                            $iva = 0;
                            $totalg12 = 0;
                            $totalg12h = 0;
                            $totaliva = 0;
                            $Stotal = 0;
                            $costo = 0;
                            $subtotal_costo = 0;
                            $total_costos = 0;
                            $totallab = 0;
                            $totalimg = 0;
                            $total_gasto = 0;
                            $num_gasto=0;
                            
                            
                            $resultadom = $conexion ->query("SELECT * FROM reg_usuarios WHERE id_usua = $medico ") or die($conexion->error);
                            while($filam = mysqli_fetch_array($resultadom)){ 
                                $nom_medico=$filam["pre"].'. '.$filam["papell"];
                             }
                                                        // Initialize $tr with a default value
                            $tr = 0; // Default to 0 or another fallback value that makes sense in your context
                            $resultadot = $conexion->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$asegura'") or die($conexion->error);
                            if ($resultadot && mysqli_num_rows($resultadot) > 0) {
                                while ($filat = mysqli_fetch_array($resultadot)) { 
                                    $tr = $filat["tip_precio"];
                                }
                            }
       
                            $resultado3 = $conexion->query("SELECT * FROM dat_ctapac where id_atencion = $id_atencion ORDER BY id_atencion") or die($conexion->error);
                            while ($row3 = $resultado3->fetch_assoc()) {
                                $flag = $row3['prod_serv'];
                                $insumo = $row3['insumo'];
                                $cant = $row3['cta_cant'];
                                $precioh = $row3['cta_tot'];
                                $precio = 0;
                                $iva = 0;
                                $subtottal = 0;
                                $preciog12 = 0;
                                $subtotalg12 = 0;
                                $preciolab = 0;
                                $subtotallab = 0;
                                $precioimg = 0;
                                $subtotalimg = 0;
                                $preciog12h = 0;
                                $subtotalg12h = 0;
                                $costo = 0;
                                $subtotal_costo = 0;
                                $tip_s = ' ';
                                $tip_servi=' ';
                                $Stotal=0;
                               
                             
                if ($insumo == 0 && 
                    $flag != 'S' && 
                    $flag != 'H' && 
                    $flag != 'P' && 
                    $flag != 'PC') {
                    $precio = $precioh;
                    $subtottal = $precio * $cant;
                    $iva = $subtottal * 0.16;
                } elseif ($flag == 'H') {
                    $preciog12h = $precioh;
                    $subtotalg12h = $preciog12h * $cant;
                    $iva = 0.00;
                } elseif ($flag == 'S') {
                    $resultado_serv = $conexion->query("SELECT * FROM cat_servicios WHERE id_serv = $insumo") or die($conexion->error);
                    while ($row_serv = $resultado_serv->fetch_assoc()) {
                        $tip_servi = $row_serv['tip_insumo'];
                        
                        // Use $tr with a fallback to $precioh if $tr is invalid or undefined
                        if ($tr == 1) {
                            $precio = $row_serv['serv_costo'];
                        } elseif ($tr == 2) {
                            $precio = $row_serv['serv_costo2'];
                        } elseif ($tr == 3) {
                            $precio = $row_serv['serv_costo3'];
                        } elseif ($tr == 4) {
                            $precio = $row_serv['serv_costo4'];
                        } else {
                            $precio = $precioh; // Fallback price
                        }
                        
                        if ($precio == 0) {
                            $precio = $precioh;
                        }
                        
                        $subtottal = $precio * $cant;
                        $iva = $subtottal * 0.16;
                        
                        $tip_s = $row_serv['tipo'];
                        
                        if ($insumo == 1 || $insumo == 3) {
                            $num_gasto = $num_gasto + 1;
                        }
                        
                        if ($tip_servi == "RENTA EQUIPO") {
                            $preciog12 = $precioh;
                            $subtotalg12 = ($preciog12 * $cant) * 1.16;
                        }
                    }
                } elseif ($flag == 'P' || $flag == 'PC') {
                    $costo = 0;
                    $precio = $precioh;
                    $subtottal = $precio * $cant;
                    $iva = $subtottal * 0.16;
                }
                
                $totalg12    = $totalg12 + $subtotalg12;
                $totalg12h   = $totalg12h + $subtotalg12h;
                
                $total      = $total + $subtottal;
                $totaliva   = $totaliva + $iva;
                
                if ($tip_s == '1') {$totallab = $totallab + $subtottal + $iva;}
                if ($tip_s == '2') {$totalimg = $totalimg + $subtottal + $iva;}
               
            }
            $total = $total +  + $totalg12h; 
            $Stotal = ($total + $totaliva);
         
           
                        
        $sql_tabla = "SELECT deposito FROM dat_financieros WHERE id_atencion=$id_atencion ORDER BY id_atencion";
        $result_tabla = $conexion->query($sql_tabla);
        $subtottaldep=0;
        $totaldep=0;
        while ($row_tabla = $result_tabla->fetch_assoc()) {
            $subtotaldep=$row_tabla['deposito'];
            $totaldep=$totaldep+$subtotaldep;
        }
        ?>
            <tr>
                <td style="text-align: center;">
                    <div class="btn-group" role="group">
                        <a href="detalle_cuenta.php?id_at=<?php echo $id_atencion ?>&id_exp=<?php echo $id_exp ?>&id_usua=<?php echo $usuario1; ?>&rol=<?php echo $rol ?>" 
                           class="btn btn-warning btn-sm" title="Ver Detalle">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="cuenta.php?id_atencion=<?php echo $id_atencion ?>&id_usua=<?php echo $usuario1 ?>" 
                           target="_blank" class="btn btn-danger btn-sm" title="Generar PDF">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </div>
                </td>
                <td><strong><?php echo $id_exp; ?></strong></td>
                <td style="background: linear-gradient(135deg, #6c757d, #95a5a6); color: white; border-radius: 6px; text-align: center;">
                    <strong><?php echo $id_atencion; ?></strong>
                </td>
                <td style="background: linear-gradient(135deg, #27ae60, #2ecc71); color: white; border-radius: 6px; text-align: center;">
                    <strong><?php echo $cama; ?></strong>
                </td>
                <td><strong><?php echo $nombre; ?></strong></td>
                <td><strong><?php echo $nom_medico; ?></strong></td>
                <td><strong><?php echo $especialidad; ?></strong></td>
                <td><strong><?php echo $asegura; ?></strong></td>
                <td style="text-align: right;"><strong>$<?php echo number_format($total, 2); ?></strong></td>
                <td style="text-align: right;"><strong>$<?php echo number_format($totaliva, 2); ?></strong></td>
                <td style="text-align: center; font-weight: bold; background: linear-gradient(135deg, #e8f5e8, #f1f8e9); border-radius: 6px;">
                    <span style="color: #e74c3c; font-size: 16px; font-weight: 700;">
                        $<?php echo number_format($Stotal, 2); ?>
                    </span>
                </td>
                <td style="text-align: right;"><strong>$<?php echo number_format($totaldep, 2); ?></strong></td>
                <td><strong><?php echo $fecing; ?></strong></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $("#alerts").hide(500);
    }, 500);
});
</script>
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