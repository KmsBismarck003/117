<?php
session_start();
include "../../conexionbd.php";

// Verifica si la sesión está activa
if (!isset($_SESSION['login'])) {
    echo "<script>window.location='../../index.php';</script>";
    exit;
}

// Clase principal para manejar devoluciones
class DevolucionesPendientes
{
    private $conexion;
    private $id_usua;

    public function __construct($conexion, $id_usua)
    {
        $this->conexion = $conexion;
        $this->id_usua = $id_usua;
    }

    // Obtiene los datos de devoluciones pendientes
    public function obtenerDevoluciones()
    {
        $query = "
            SELECT d.*, i.item_name, d.existe_lote, d.existe_caducidad, salida_id
            FROM devoluciones_almacenh d
            JOIN item_almacen i ON d.item_id = i.item_id
        ";
        return $this->conexion->query($query);
    }

    // Renderiza el contenido de la tabla
    public function renderizarTabla($datos)
    {
        if ($datos && $datos->num_rows > 0) {
            while ($row = $datos->fetch_assoc()) {
                $fecha = date_create($row['fecha']);
                $fecha = date_format($fecha, 'd/m/Y H:i');

                echo "<tr>";
                echo "<td>{$row['id_atencion']}</td>";
                echo "<td>{$row['salida_id']}</td>";
                echo "<td>{$row['item_name']}</td>";
                echo "<td>{$row['dev_id']}</td>";
                echo "<td>{$fecha}</td>";
                echo "<td>{$row['item_id']}</td>";
                echo "<td>{$row['item_code']}</td>";
                echo "<td>{$row['dev_qty']}</td>";
                echo "<td>{$row['cant_inv']}</td>";
                echo "<td>{$row['cant_mer']}</td>";
                echo "<td>{$row['motivoi']}</td>";
                echo "<td>{$row['motivom']}</td>";
                echo "<td>{$row['existe_lote']}</td>";
                echo "<td>{$row['existe_caducidad']}</td>";
                echo "<td>";
                echo "<button class='btn btn-success btn-sm' data-toggle='modal' data-target='#inventarioModal{$row['dev_id']}'><i class='fas fa-check'></i> Inventario</button> ";
                echo "<button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#mermaModal{$row['dev_id']}'><i class='fas fa-times'></i> Merma</button>";
                echo "</td>";
                echo "</tr>";

                $this->renderizarModal($row, 'inventario');
                $this->renderizarModal($row, 'merma');
            }
        } else {
            echo "<tr><td colspan='15' class='text-center'>No hay datos en la tabla 'devoluciones_almacenh'</td></tr>";
        }
    }

    // Renderiza los modales de inventario y merma
    private function renderizarModal($row, $tipo)
    {
        $action = $tipo === 'inventario' ? 'valida_dev.php' : 'registrar_merma.php';
        $modalTitle = $tipo === 'inventario' ? 'Confirmar para Inventario' : 'Confirmar para Merma';
        $cantidadName = $tipo === 'inventario' ? 'cant_inv' : 'merma_qty';
        $motivoName = $tipo === 'inventario' ? 'motivoi' : 'merma_motivo';
        $buttonClass = $tipo === 'inventario' ? 'btn-success' : 'btn-danger';
        $buttonText = $tipo === 'inventario' ? 'Confirmar' : 'Confirmar';

        echo "<div class='modal fade' id='{$tipo}Modal{$row['dev_id']}' tabindex='-1' aria-labelledby='{$tipo}Label' aria-hidden='true'>
            <div class='modal-dialog'>
                <form action='{$action}' method='POST'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>{$modalTitle}</h5>
                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        </div>
                        <div class='modal-body'>
                            <input type='hidden' name='id_dev' value='{$row['dev_id']}'>
                            <input type='hidden' name='item_id' value='{$row['item_id']}'>
                            <input type='hidden' name='dev_qty' value='{$row['dev_qty']}'>
                            <input type='hidden' name='salida' value='{$row['salida_id']}'>
                            <input type='hidden' name='lote' value='{$row['existe_lote']}'>
                            <input type='hidden' name='caducidad' value='{$row['existe_caducidad']}'>
                            <strong>Cantidad: <input type='number' name='{$cantidadName}' class='form-control' required></strong>
                            <strong>Motivo: <input type='text' name='{$motivoName}' class='form-control' required></strong>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                            <button type='submit' class='btn {$buttonClass}'>{$buttonText}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>";
    }
}

// Instancia de la clase
$devolucionesPendientes = new DevolucionesPendientes($conexion, $_SESSION['login']['id_usua']);
$datosDevoluciones = $devolucionesPendientes->obtenerDevoluciones();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet">
    <title>Devoluciones Pendientes</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-4">
                <a href="../../template/menu_farmaciahosp.php" class="btn btn-danger">Regresar</a>
            </div>
            <div class="col-md-4">
                <a href="pdf_devoluciones.php" class="btn btn-success" target="_blank">Imprimir Reporte</a>
            </div>
            <div class="col-md-4">
                <a href="exceldevoluciones.php" class="btn btn-success">Exportar a Excel</a>
            </div>
        </div>

        <div class="form-group my-3">
            <input type="text" id="search" class="form-control" placeholder="Buscar...">
        </div>

        <div class="mx-4 mt-4">
            <h3 class="text-center text-primary">Devoluciones Pendientes</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID Paciente</th>
                            <th>Salida</th>
                            <th>Nombre</th>
                            <th>ID Devolución</th>
                            <th>Fecha</th>
                            <th>ID Ítem</th>
                            <th>Código</th>
                            <th>Cantidad Devuelta</th>
                            <th>Cantidad Inventario</th>
                            <th>Cantidad Merma</th>
                            <th>Motivo Inventario</th>
                            <th>Motivo Merma</th>
                            <th>Lote</th>
                            <th>Caducidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $devolucionesPendientes->renderizarTabla($datosDevoluciones); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
