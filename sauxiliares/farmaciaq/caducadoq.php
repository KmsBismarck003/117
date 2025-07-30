<?php
session_start();
include "../../conexionbd.php";

$usuario = $_SESSION['login'];

if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
    include "../header_farmaciaq.php";
} else {
    echo "<script>window.location='../../index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .thead {
            background-color: #0c675e;
            color: white;
            font-size: 20px;
            text-align: center;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
            border: 1px solid #ddd;
            padding: 12px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .danger { background-color: #ff6b6b !important; }
        .warning { background-color: #ffe066 !important; }
        .orange { background-color: #ffb74d !important; }
        .success { background-color: #81c784 !important; }

        /* Cambiar el fondo al pasar el mouse sobre una fila */
        tbody tr:hover {
            background-color: #d1e7dd;
        }

        /* Input de búsqueda estilizado */
        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            width: 300px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            margin-bottom: 20px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#search").keyup(function() {
                var _this = this;
                $.each($("#mytable tbody tr"), function() {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
    </script>
</head>

<body>

<div class="container-fluid">

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <a class="btn btn-danger" href="../../template/menu_farmaciaq.php">Regresar</a>
            </div>
        </div>
    </div>

    <div class="thead">
        <strong><center>CONTROL DE CADUCIDADES</center></strong>
    </div>

    <div class="search-box">
        <input type="text" class="form-control" id="search" placeholder="Buscar...">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="mytable">
            <thead class="thead">
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Presentación</th>
                    <th>Lote</th>
                    <th>Caducidad</th>
                    <th>Entradas</th>
                    <th>Salidas</th>
                    <th>Devoluciones</th>
                    <th>Existencias</th>
                    <th>Máximo</th>
                    <th>Punto de reorden</th>
                    <th>Mínimo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado2 = $conexion->query("SELECT * FROM item_almacen, existencias_almacenq, item_type WHERE item_type.item_type_id=item_almacen.item_type_id AND item_almacen.item_id = existencias_almacenq.item_id ORDER BY item_almacen.item_id") or die($conexion->error);

                while ($row = $resultado2->fetch_assoc()) {
                    $caducidad = date_create($row['existe_caducidad']);
                    $hoy = new DateTime();
                    $diferencia = $hoy->diff($caducidad);
                    $diasRestantes = $diferencia->days;

                    // Asignar clase de color según los días restantes
                    $colorClase = '';
                    if ($diasRestantes < 30) {
                        $colorClase = 'danger'; // Rojo
                    } elseif ($diasRestantes >= 31 && $diasRestantes <= 60) {
                        $colorClase = 'warning'; // Amarillo
                    } elseif ($diasRestantes >= 61 && $diasRestantes <= 90) {
                        $colorClase = 'orange'; // Naranja
                    } else {
                        continue; // No mostrar elementos con más de 90 días
                    }

                    // Generar la fila de la tabla
                    echo '<tr class="' . $colorClase . '">'
                        . '<td>' . $row['item_code'] . '</td>'
                        . '<td>' . $row['item_name'] . ', ' . $row['item_grams'] . '</td>'
                        . '<td>' . $row['item_type_desc'] . '</td>'
                        . '<td>' . $row['existe_lote'] . '</td>'
                        . '<td>' . date_format($caducidad, "d/m/Y") . '</td>'
                        . '<td>' . $row['existe_entradas'] . '</td>'
                        . '<td>' . $row['existe_salidas'] . '</td>'
                        . '<td>' . $row['existe_devoluciones'] . '</td>'
                        . '<td>' . $row['existe_qty'] . '</td>'
                        . '<td>' . $row['item_max'] . '</td>'
                        . '<td>' . $row['reorden'] . '</td>'
                        . '<td>' . $row['item_min'] . '</td>'
                        . '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="main-footer">
    <?php include("../../template/footer.php"); ?>
</footer>

<script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>
</html>
