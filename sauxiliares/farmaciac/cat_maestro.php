<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../../conexionbd.php";
include "../header_farmaciac.php";

if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$usuario = $_SESSION['login'];

if (!in_array($usuario['id_rol'], [4, 5, 11])) {
    echo "<script>window.Location='../../index.php';</script>";
    exit();
}

// Variables para la paginación
$items_per_page = 600; // Número de registros por página
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// Consulta para obtener el total de registros
$total_items_query = "SELECT COUNT(*) as total FROM item_almacen";
$total_items_result = $conexion->query($total_items_query);
$total_items_row = $total_items_result->fetch_assoc();
$total_items = $total_items_row['total'];

// Calcular el número total de páginas
$total_pages = ceil($total_items / $items_per_page);

// Consulta para obtener los datos de la página actual
$paginated_query = "SELECT i.*, t.item_type_desc FROM item_almacen i 
    LEFT JOIN item_type t ON t.item_type_id = i.item_type_id
    LIMIT $items_per_page OFFSET $offset";
$resultado2 = $conexion->query($paginated_query);

// Lógica para mostrar solo 5 páginas en la navegación
$max_links = 5; // Número máximo de enlaces de paginación visibles
$start_page = max(1, $current_page - floor($max_links / 2));
$end_page = min($total_pages, $start_page + $max_links - 1);
$start_page = max(1, $end_page - $max_links + 1); // Ajustar si llegamos al límite superior
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMA Venecia Metepec</title>
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
            background-color: #f8f9fa;
        }

        .header {
            background-color: #2b2d7f;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
        }

        .btn-danger {
            margin: 10px 0;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table thead th {
            background-color: #2b2d7f;
            color: white;
        }

        .table tbody tr {
            background-color: #ffffff;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        .modal-header {
            background-color: #2b2d7f;
            color: white;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#search").keyup(function() {
                let searchTerm = $(this).val().toLowerCase();
                $("#mytable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchTerm) > -1);
                });
            });
        });
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="header">PRODUCTOS DE FARMACIA CENTRAL</div>
        <div class="responsive">
            <div class="row mt-3 mb-3">
                <div class="col-sm-4">
                    <a class="btn btn-danger" href="../../template/menu_farmaciacentral.php">Regresar</a>
                </div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="search" placeholder="Buscar..." style="width: 300px;">
            </div>
            <div class="form-group mb-3">
                <a href="excel_item_almacen.php" class="btn btn-warning btn-lg btn-custom-size">
                    <img src="https://img.icons8.com/color/48/000000/ms-excel.png" width="30" /> Exportar a Excel
                </a>
                <button type="button" class="btn btn-primary btn-lg btn-custom-size" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-plus"></i> Nuevo Producto
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="mytable">
                    <thead>
                        <tr>
                            <th>Editar</th>
                            <th>Id</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Presentación</th>
                            <th>Contenido</th>
                            <th>Proveedor</th>
                            <th>Factor</th>
                            <th>Surte</th>
                            <th>Máximo</th>
                            <th>Reorden</th>
                            <th>Mínimo</th>
                            <th>Costo</th>
                            <th>Costo <br>Unitario</th>
                            <th>Precio</th>
                            <th>Subfamilia</th>
                            <th>Grupo</th>
                            <th>Tipo</th>
                            <th>Tempertura</th>
                            <th>Alerta</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $resultado2->fetch_assoc()) {
                            $eid = $row['item_id'];
                            echo '<tr>'
                                . '<td><a href="edit_items.php?id=' . $eid . '" class="btn btn-warning btn-sm"><span class="fa fa-edit"></span></a></td>'
                                . '<td>' . $row['item_id'] . '</td>'
                                . '<td>' . $row['item_code'] . '</td>'
                                . '<td>' . $row['item_name'] . '</td>'
                                . '<td>' . $row['item_grams'] . '</td>'
                                . '<td>' . $row['contenido'] . '</td>'
                                . '<td>' . $row['id_prov'] . '</td>'
                                . '<td>' . $row['factor'] . '</td>'
                                . '<td>' . $row['item_type_desc'] . '</td>'
                                . '<td>' . $row['item_max'] . '</td>'
                                . '<td>' . $row['reorden'] . '</td>'
                                . '<td>' . $row['item_min'] . '</td>'
                                . '<td>$' . number_format($row['item_costs'], 2) . '</td>'
                                . '<td>$' . number_format($row['cost_unit'], 2) . '</td>'
                                . '<td>$' . number_format($row['item_price'], 2) . '</td>'
                                . '<td>' . $row['subfamilia'] . '</td>'
                                . '<td>' . $row['grupo'] . '</td>'
                                . '<td>' . $row['tipo'] . '</td>'
                                . '<td>' . $row['temperatura'] . '</td>'
                                . '<td>' . $row['alerta'] . '</td>'
                                . '<td>' . $row['activo'] . '</td>'
                                . '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Paginación -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page - 1 ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page + 1 ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <!-- Modal Insertar -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="insertar_item.php" method="POST" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="item-code">Código:</label>
                                <input type="text" name="item_code" class="form-control" id="item-code" placeholder="Código del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="item-name">Descripción:</label>
                                <input type="text" name="item_name" class="form-control" id="item-name" placeholder="Descripción del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="item-comercial">Nombre Comercial:</label>
                                <input type="text" name="item_comercial" class="form-control" id="item-comercial" placeholder="Nombre comercial" required>
                            </div>
                            <div class="form-group">
                                <label for="item-grams">Presentación (g):</label>
                                <input type="text" name="item_grams" class="form-control" id="item-grams" placeholder="Presentación en gramos" required>
                            </div>
                            <div class="form-group">
                                <label for="id_prov">Proveedor:</label>
                                <select name="id_prov" class="form-control" id="id-prov" required>
                                    <option value="">Selecciona un proveedor</option>
                                    <?php
                                    // Consulta para obtener los proveedores
                                    $resultado_proveedores = $conexion->query("SELECT id_prov, nom_prov FROM proveedores") or die($conexion->error);
                                    while ($row_prov = $resultado_proveedores->fetch_assoc()) {
                                        echo '<option value="' . $row_prov['id_prov'] . '">' . htmlspecialchars($row_prov['nom_prov']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="factor">Factor:</label>
                                <input type="text" name="factor" class="form-control" id="factor" placeholder="Factor" required>
                            </div>
                            <div class="f orm-group">
                                <label for="item-type">Surte:</label>
                                <select name="item_type_id" class="form-control" id="item-type" required>
                                    <option value="">Selecciona un tipo</option>
                                    <?php
                                    // Consulta para obtener los tipos
                                    $tipo_resultado = $conexion->query("SELECT item_type_id, item_type_desc FROM item_type") or die($conexion->error);
                                    while ($tipo = $tipo_resultado->fetch_assoc()) {
                                        echo '<option value="' . $tipo['item_type_id'] . '">' . $tipo['item_type_desc'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="item-max">Máximo:</label>
                                <input type="number" name="item_max" class="form-control" id="item-max" placeholder="Máximo" required>
                            </div>
                            <div class="form-group">
                                <label for="reorden">Reorden:</label>
                                <input type="number" name="reorden" class="form-control" id="reorden" placeholder="Reorden" required>
                            </div>
                            <div class="form-group">
                                <label for="item-min">Mínimo:</label>
                                <input type="number" name="item_min" class="form-control" id="item-min" placeholder="Mínimo" required>
                            </div>
                            <div class="form-group">
                                <label for="item-price">Costo:</label>
                                <input type="number" step="0.01" name="item_costs" class="form-control" id="item-cost" placeholder="Costo del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="item-price">Precio:</label>
                                <input type="number" step="0.01" name="item_price" class="form-control" id="item-price" placeholder="Precio del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="subfamilia">Subfamilia:</label>
                                <input type="text" name="subfamilia" class="form-control" id="subfamilia" placeholder="Subfamilia" required>
                            </div>
                            <div class="form-group">
                                <label for="grupo">Grupo:</label>
                                <select name="grupo" class="form-control" id="grupo" required>
                                    <option value="">Selecciona un tipo</option>
                                    <option value="MATERIALES">MATERIALES</option>
                                    <option value="MEDICAMENTOS">MEDICAMENTOS</option>
                                    <option value="INSUMOS">INSUMOS</option>
                                    <option value="SOLUCIONES FISIOLÓGICAS">SOLUCIONES FISIOLÓGICAS</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tipo">Tipo:</label>
                                <select name="tipo" class="form-control" id="tipo" required>
                                    <option value="">Selecciona un tipo</option>
                                    <option value="GENÉRICO">GENÉRICO</option>
                                    <option value="PATENTE">PATENTE</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="activo">Activo:</label>
                                <select name="activo" class="form-control" id="activo" required>
                                    <option value="SI">Sí</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar Producto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- FastClick -->
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
</body>

</html>
