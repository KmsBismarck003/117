<?php
session_start();
include "../../conexionbd.php";

// Consulta para obtener los medicamentos desde la tabla `item_almacen`
$resultado = $conexion->query("
    SELECT * FROM item_almacen
") or die($conexion->error);

$usuario = $_SESSION['login'];

// Incluye el encabezado correspondiente según el rol del usuario
if ($usuario['id_rol'] == 8) {
    include "../header_farmaciaq.php";
} else if ($usuario['id_rol'] == 3) {
    include "../../enfermera/header_enfermera.php";
} else if ($usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
    include "../header_farmaciaq.php";
} else {
    echo "<script>window.Location='../../index.php';</script>";
    exit;
}

// Variables para fechas y medicamento
$fecha_inicial = isset($_POST['inicial']) ? $_POST['inicial'] : null;
$fecha_final = isset($_POST['final']) ? $_POST['final'] : null;
$item_id = isset($_POST['item_id']) ? mysqli_real_escape_string($conexion, $_POST['item_id']) : null;


// Determinar si se presionó el botón "ULT.REGISTROS"
if (isset($_POST['ult_registros'])) {
    // Si se presionó "ULT.REGISTROS", obtener los últimos 20 registros
    $query = "
        SELECT 
            ka.kardex_fecha AS fecha,
            ia.item_name AS item_name,
            ka.kardex_lote AS lote,
            ka.kardex_caducidad AS caducidad,
            ka.kardex_inicial,
            ka.kardex_entradas,
            ka.kardex_salidas,
            ka.kardex_qty,
            ka.kardex_dev_stock,
            ka.kardex_dev_merma,
            ka.kardex_movimiento,
            ua.nombre_ubicacion AS kardex_ubicacion,
            ka.kardex_destino,
            ka.id_usua,
            ka.id_surte
        FROM kardex_almacenq ka
        INNER JOIN item_almacen ia ON ka.item_id = ia.item_id
        LEFT JOIN ubicaciones_almacen ua ON ka.kardex_ubicacion = ua.ubicacion_id
        ORDER BY ka.kardex_fecha DESC LIMIT 20
    ";
} else {
    // Consulta general con filtros si no se presionó "ULT.REGISTROS"
    $query = "
        SELECT 
            ka.kardex_fecha AS fecha,
            ia.item_name AS item_name,
            ka.kardex_lote AS lote,
            ka.kardex_caducidad AS caducidad,
            ka.kardex_inicial,
            ka.kardex_entradas,
            ka.kardex_salidas,
            ka.kardex_qty,
            ka.kardex_dev_stock,
            ka.kardex_dev_merma,
            ka.kardex_movimiento,
            ua.nombre_ubicacion AS kardex_ubicacion,
            ka.kardex_destino,
            ka.id_usua,
            ka.id_surte
        FROM kardex_almacenq ka
        INNER JOIN item_almacen ia ON ka.item_id = ia.item_id
        LEFT JOIN ubicaciones_almacen ua ON ka.kardex_ubicacion = ua.ubicacion_id
    ";

    // Aplicar filtros de fechas y medicamento
    if ($fecha_inicial && $fecha_final && $item_id) {
        $query .= " WHERE ka.kardex_fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND ia.item_id = '$item_id'";
    } elseif ($item_id) {
        $query .= " WHERE ia.item_id = '$item_id'";
    } elseif ($fecha_inicial && $fecha_final) {
        $query .= " WHERE ka.kardex_fecha BETWEEN '$fecha_inicial' AND '$fecha_final'";
    }
}

$resultado2 = $conexion->query($query) or die($conexion->error);

$totalExistencia = 0;
if ($item_id) {
    $query_existencia = "
        SELECT SUM(existe_qty) AS totalExistencia 
        FROM existencias_almacenQ 
        WHERE item_id = '$item_id'
    ";
    $resultado_existencia = $conexion->query($query_existencia) or die($conexion->error);

    if ($row_existencia = $resultado_existencia->fetch_assoc()) {
        $totalExistencia = $row_existencia['totalExistencia'] ?? 0;
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .total-row {
            background-color: #0c675e;
            color: white;
        }

        .ultima-existencia {
            background-color: #0c675e;
            color: white;
        }

        .table-responsive {
            max-height: 80vh;
            overflow-y: auto;
        }

        .container.box {
            max-width: 95%;
        }
    </style>
</head>

<body>
    <section class="content container-fluid">
        <a href="../../template/menu_farmaciaq.php"

            style='color: white; margin-left: 26px; margin-bottom: 1px; background-color: #d9534f; 
      border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; display: inline-block;'>
            Regresar
        </a>
        <div class="container box">
            <div class="content">
                <div class="thead" style="background-color: #0c675e; margin: 5px auto; padding: 5px; color: white; width: fit-content; text-align: center; border-radius: 5px;">
                    <h1 style="font-size: 26px; margin: 2;">KARDEX</h1>
                </div>
                <br><br>
                <form method="POST" id="medicamentos" style="margin-bottom: 20px;">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label>Fecha Inicial:</label>
                            <input type="date" class="form-control" name="inicial" value="<?= $fecha_inicial ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Fecha Final:</label>
                            <input type="date" class="form-control" name="final" value="<?= $fecha_final ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Medicamento:</label>
                            <select name="item_id" class="form-control" id="mibuscador" style="height: 0px; width: 200px;">
                                <option value="">Seleccione un medicamento</option>
                                <?php
                                $sql = "SELECT * FROM item_almacen";
                                $result = $conexion->query($sql);
                                while ($row_datos = $result->fetch_assoc()) {
                                    echo "<option value=" . $row_datos['item_id'] . ">" . $row_datos['item_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success custom-btn">SELECCIONAR</button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col text-center">
                            <button type="submit" name="ult_registros" class="btn btn-success mr-2 custom-btn">ULT.REGISTROS</button>

                            <a href="entradas_almacenq_historial.php" class="btn btn-success mr-2 custom-btn">RESURTIMIENTO</a>
                            <a href="salidas_almacenq_historial.php" class="btn btn-success mr-2 custom-btn">SALIDAS</a>

                            <a href="devoluciones_almacenq_historial.php" class="btn btn-success mr-2 custom-btn">DEVOLUCIONES</a>
                            <a href="mermas_almacenq_historial.php" class="btn btn-success custom-btn">MERMAS</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead" style="background-color: #0c675e; color:white;">
                            <tr>
                                <th>FECHA</th>
                                <th>MEDICAMENTO</th>
                                <th>LOTE</th>
                                <th>CADUCIDAD</th>
                                <th>INICIAL</th>
                                <th>RESURTIMIENTO</th>
                                <th>SALIDA</th>
                                <th>DEV. STOCK</th>
                                <th>DEV. MERMA</th>
                                <th>MOVIMIENTO</th>
                                <th>UBICACIÓN</th>
                                <th>DESTINO</th>
                                <th>U.RECIBE</th>
                                <th>U.SURTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $resultado2->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($row['fecha'])) ?></td>
                                    <td><?= $row['item_name'] ?></td>
                                    <td><?= $row['lote'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['caducidad'])) ?></td>
                                    <td><?= $row['kardex_inicial'] ?></td>
                                    <td><?= $row['kardex_entradas'] ?></td>
                                    <td><?= $row['kardex_salidas'] ?></td>
                                    <td><?= $row['kardex_dev_stock'] ?></td>
                                    <td><?= $row['kardex_dev_merma'] ?></td>
                                    <td><?= $row['kardex_movimiento'] ?></td>
                                    <td><?= $row['kardex_ubicacion'] ?></td>
                                    <td><?= $row['kardex_destino'] ?></td>
                                    <td><?= $row['id_usua'] ?></td>
                                    <td><?= $row['id_surte'] ?></td>
                                </tr>
                                <?php $totalExistencia += $row['kardex_qty']; ?>
                            <?php } ?>
                        </tbody>
                        <?php if ($item_id) { ?>
                            <tfoot>
                                <tr class="total-row">
                                    <td colspan="7" style="text-align: right;"><strong>Total Existencia:</strong></td>
                                    <td><strong><?= $totalExistencia ?></strong></td>
                                    <td colspan="7"></td>
                                </tr>
                            </tfoot>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#mibuscador').select2({
            placeholder: "Seleccione un medicamento",
            allowClear: true
        });
    });
</script>

</html>