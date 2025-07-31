<?php
session_start();
include "../../configuracion/header_configuracion.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#search").keyup(function () {
                _this = this;
                $.each($("#mytable tbody tr"), function () {
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
    <div class="row">
        <div class="col col-12">
            <h2>
                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                <center><font id="letra"><i class="fa fa-plus-square"></i> CATÁLOGO DE SERVICIOS</font></h2>
            </center>
            <hr>
            <div class="row">
                <div class="col-6">
                    <center>
                        <button type="button" class="btn btn-primary col-md-" data-toggle="modal"
                                data-target="#exampleModal"><i class="fa fa-plus"></i><font id="letra"> Nuevo servicio</font></button>
                </div>
                <div class="col-6">
                    <center>
                        <a href="excel.php"><button type="button" class="btn btn-warning"><img src="https://img.icons8.com/color/48/000000/ms-excel.png"/><strong>Exportar a Excel</strong></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Insertar -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="insertar_servicio.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="clave">Clave:</label>
                        <input type="text" size="15" name="clave" id="clave" value="" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="costo">Precio 1:</label>
                        <input type="number" step="0.01" min="0" name="costo" id="costo" class="form-control" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="costo2">Precio 2 (AXA):</label>
                        <input type="number" step="0.01" min="0" name="costo2" id="costo2" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="costo3">Precio 3 (GNP):</label>
                        <input type="number" step="0.01" min="0" name="costo3" id="costo3" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="costo4">Precio 4 (Rentas):</label>
                        <input type="number" step="0.01" min="0" name="costo4" id="costo4" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="costo5">Precio 5:</label>
                        <input type="number" step="0.01" min="0" name="costo5" id="costo5" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="costo6">Precio 6:</label>
                        <input type="number" step="0.01" min="0" name="costo6" id="costo6" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="costo7">Precio 7:</label>
                        <input type="number" step="0.01" min="0" name="costo7" id="costo7" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="costo8">Precio 8:</label>
                        <input type="number" step="0.01" min="0" name="costo8" id="costo8" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="med">Unidad de medida:</label>
                        <select name="med" class="form-control" required>
                            <option value="">Seleccionar</option>
                            <option value="CONSULTA">CONSULTA</option>
                            <option value="EQUIPO">EQUIPO</option>
                            <option value="ESTUDIO">ESTUDIO</option>
                            <option value="HORA">HORA</option>
                            <option value="SERVICIO">SERVICIO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo:</label>
                        <select id="item-type" class="form-control" name="tipo" required>
                            <option value="">Seleccionar</option>
                            <?php
                            $query = "SELECT * FROM `service_type`";
                            $result = $conexion->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['ser_type_id'] . "' data-desc='" . $row['ser_type_desc'] . "'>" . $row['ser_type_desc'] . "</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" name="tip_insumo" id="tip_insumo" value="">
                    </div>
                    <div class="form-group">
                        <label for="proveedor">Proveedor:</label>
                        <select name="proveedor" id="proveedor" class="form-control" required>
                            <option value="">Seleccionar</option>
                            <?php
                            $query_prov = "SELECT id_prov, nom_prov FROM proveedores";
                            $result_prov = $conexion->query($query_prov);
                            while ($row_prov = $result_prov->fetch_assoc()) {
                                echo "<option value='" . $row_prov['id_prov'] . "'>" . $row_prov['nom_prov'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="grupo">Grupo:</label>
                        <select name="grupo" id="grupo" class="form-control" required>
                            <option value="">Seleccionar</option>
                            <option value="SERVICIOS HOSPITALARIOS">SERVICIOS HOSPITALARIOS</option>
                            <option value="IMAGENOLOGIA">IMAGENOLOGIA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codigo_sat">Código SAT:</label>
                        <input type="text" name="codigo_sat" id="codigo_sat" class="form-control" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="c_cveuni">Clave Unidad:</label>
                        <input type="text" name="c_cveuni" id="c_cveuni" class="form-control" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#item-type').change(function() {
            var desc = $(this).find('option:selected').data('desc');
            $('#tip_insumo').val(desc);
        });
    });
</script>

<section class="content container-fluid">
    <div class="table-responsive">
        <div class="content">
            <?php
            include "../../conexionbd.php";
            $resultado2 = $conexion->query("SELECT s.*, t.ser_type_desc as tipo, p.nom_prov as proveedor FROM cat_servicios s LEFT JOIN service_type t ON s.tipo = t.ser_type_id LEFT JOIN proveedores p ON s.proveedor = p.id_prov ORDER BY id_serv") or die($conexion->error);
            ?>
            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="mytable">
                    <thead class="thead" style="background-color: #2b2d7f;color:white;">
                    <tr>
                        <th>Id</th>
                        <th>Clave</th>
                        <th>Descripción</th>
                        <th>Precio 1</th>
                        <th>Precio 2 <br> AXA</th>
                        <th>Precio 3 <br> GNP</th>
                        <th>Precio 4 <br> Rentas</th>
                        <th>Precio 5</th>
                        <th>Precio 6</th>
                        <th>Precio 7</th>
                        <th>Precio 8</th>
                        <th>U.M.</th>
                        <th>Tipo</th>
                        <!-- <th>Tipo Insumo</th>
                        <th>Proveedor</th>
                        <th>Grupo</th>
                        <th>Código SAT</th>
                        <th>Clave Unidad</th> -->
                        <th>Activo</th>
                        <?php 
                        $usuario = $_SESSION['login'];
                        $rol = $usuario['id_rol'];
                        if ($rol == 5) { ?>
                            <th>Edita</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    while ($row = $resultado2->fetch_assoc()) {
                        $eid = $row['id_serv'];
                        echo '<tr>'
                            . '<td>' . $row['id_serv'] . '</td>'
                            . '<td>' . $row['serv_cve'] . '</td>'
                            . '<td>' . $row['serv_desc'] . '</td>'
                            . '<td>' . $row['serv_costo'] . '</td>'
                            . '<td>' . $row['serv_costo2'] . '</td>'
                            . '<td>' . $row['serv_costo3'] . '</td>'
                            . '<td>' . $row['serv_costo4'] . '</td>'
                            . '<td>' . $row['serv_costo5'] . '</td>'
                            . '<td>' . $row['serv_costo6'] . '</td>'
                            . '<td>' . $row['serv_costo7'] . '</td>'
                            . '<td>' . $row['serv_costo8'] . '</td>'
                            . '<td>' . $row['serv_umed'] . '</td>'
                            . '<td>' . $row['tipo'] . '</td>'
                            /* . '<td>' . $row['tip_insumo'] . '</td>'
                            . '<td>' . $row['proveedor'] . '</td>'
                            . '<td>' . $row['grupo'] . '</td>'
                            . '<td>' . $row['codigo_sat'] . '</td>'
                            . '<td>' . $row['c_cveuni'] . '</td>' */;
                        ?>
                        <form class="form-horizontal title1" name="form" action="insertar_servicio.php?q=estatus"
                              method="POST" enctype="multipart/form-data">
                            <?php
                            echo '<td>';
                            if ((strpos($row['serv_activo'], 'NO') !== false)) {
                                echo '<a type="submit" class="btn btn-danger btn-sm" href="insertar_servicio.php?q=estatus&eid=' . $eid . '&est=' . $row['serv_activo'] . '"><span class="fa fa-power-off"></span></a>';
                            } else {
                                echo '<a type="submit" class="btn btn-success btn-sm" href="insertar_servicio.php?q=estatus&eid=' . $eid . '&est=' . $row['serv_activo'] . '"><span class="fa fa-power-off"></span></a>';
                            }
                            echo '</td>';
                            if ($rol == 5) {
                                echo '<td><a href="edit_servicios.php?id=' . $row['id_serv'] . '" title="Editar datos" class="btn btn-warning btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a></td>';
                            }
                            echo '</tr>';
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<footer class="main-footer">
    <?php include("../../template/footer.php"); ?>
</footer>

<script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
</body>
</html>