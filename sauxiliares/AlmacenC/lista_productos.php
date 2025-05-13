<?php
session_start();
include "../../conexionbd.php";

$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];

if ($usuario['id_rol'] == 11) {
    include "../header_almacenC.php";
} else if ($usuario['id_rol'] == 4) {
    include "../header_almacenC.php";
} else if ($usuario['id_rol'] == 5) {
    include "../header_almacenC.php";
}else{
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>

<!DOCTYPE html>
<html>

<head>
    <title>MÉDICA SAN ISIDRO</title>
    <link rel="icon" href="../imagenes/SIF.PNG">
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
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
    <!--  Bootstrap  -->
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


</head>

<body>

<div class="container-fluid">

    <?php
    $usuario = $_SESSION['login'];
  if ($usuario['id_rol'] == 11) {

        ?>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
        <a type="submit" class="btn btn-danger" href="../../template/menu_almacencentral.php">Regresar</a>
</div></div></div>

        <?php
    } else if ($usuario['id_rol'] == 4) {

        ?>
       <div class="container">
    <div class="row">
        <div class="col-sm-4">
        <a type="submit" class="btn btn-danger" href="../../template/menu_almacencentral.php">Regresar</a>
</div></div></div>
        <?php
    }else if ($usuario['id_rol'] == 5) {

        ?>
       <div class="container">
    <div class="row">
        <div class="col-sm-4">
        <a type="submit" class="btn btn-danger" href="../../template/menu_almacencentral.php">Regresar</a>
</div></div></div>
        <?php
    }else

    ?>
    <br>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>PRODUCTOS DE ALMACEN CENTRAL</center></strong>
      </div><br>
      

<div class="container">
    <center>
    <div class="row">
        
        <div class="form-group"> 
            <a href="excelalmacen.php"><button type="button" class="btn btn-warning btn-sm"><img 
                src="https://img.icons8.com/color/48/000000/ms-excel.png" width="42"/><strong>Exportar a excel</strong></button></a>
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                    data-target="#exampleModal"><i class="fa fa-plus"></i><font id="letra"> Nuevo Producto</font> </button>
                   
          
        </div>
      
    </div>   
</div>


<!-- Modal Insertar -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">NUEVO PRODUCTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="insertar_item.php" method="POST" enctype="multipart/form-data">
                     <input type="hidden" id="item-id">
                   <!--<div class="row">
                        <label class="control-label col-sm-3" for="">Código MSI:</label>
                        <div class="col-sm-9">
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" maxlength="50" name="codigo" class="form-control" id="code" placeholder="Ingresa el código" required="" autofocus="">
                        </div>
                    </div>-->
                    <br>
                    <div class="row">
                        <label class="control-label col-sm-3" for="">Descripción:</label>
                        <div class="col-sm-9">
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" maxlength="50" name="nomitem" class="form-control" id="item-name" placeholder="Ingresa la descripción" required="" autofocus="">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="control-label col-sm-3" for="">Contenido:</label>
                        <div class="col-sm-9">
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" min="0" name="contenido" maxlength="50" class="form-control" id="grams" placeholder="Ingresa el contenido" required="" autofocus="">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="control-label col-sm-3" for="">Precio:</label>
                        <div class="col-sm-9">
                            <input type="number" min="0.1" name="precio" step="any" class="form-control" id="item-price" placeholder="Ingresa el precio de venta 1" required="">
                        </div>
                    </div>
                    <br>
                    
                    <div class="row">
                        <label class="control-label col-sm-3" for="">Presentación:</label>
                        <div class="col-sm-9">
                            <select id="item-type" class="form-control" name="tipo">
                                <?php
                                $query = "SELECT * FROM `item_type`";
                                $result = $conexion->query($query);
                                //$result = mysql_query($query);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['item_type_id'] . "'>" . $row['item_type_desc'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="control-label col-sm-3" for="">Controlado:</label>
                        <div class="col-sm-9">
                            <select name="controlado" id="controlado" class="form-control">
                                <option value="NO">No</option>
                                <option value="SI">Si</option>
                            </select>
                        </div>
                    </div>
                    <br>
                   
                    <br>
                    <div class="row">
                        <label class="control-label col-sm-3" for="">Mínimo:</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" name="minimo" maxlength="50" class="form-control" id="minimo" placeholder="Ingresa el mínimo" required="" autofocus="">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="control-label col-sm-3" for="">Máximo:</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" name="maximo" maxlength="50" class="form-control" id="maximo" placeholder="Ingresa el máximo" required="" autofocus="">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="control-label col-sm-3" for="">Clasificación:</label>
                        <div class="col-sm-9">
                            <select name="clasifica" id="clasifica" class="form-control">
                                <option value="ANTISEPTICO">ANTISEPTICO</option>
                                <option value="MATERIAL DE CURACION">MATERIAL DE CURACION</option>
                                <option value="MEDICAMENTO">MEDICAMENTO</option>
                                <option value="MEDICAMENTO ALTO RIESGO">MEDICAMENTO ALTO RIESGO</option>
                                <option value="MEDICAMENTO CONTROLADO">MEDICAMENTO CONTROLADO</option>
                                <option value="NUTRICION">NUTRICION</option>
                                <option value="ORTOPEDIA">ORTOPEDIA</option>
                                <option value="SOLUCIONES">SOLUCIONES</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="control-label col-sm-3" for="">Proveedor:</label>
                        <div class="col-sm-9">
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" maxlength="50" name="fabricante" class="form-control" id="brand" placeholder="Ingresa el nombre del proveedor" required="" autofocus="">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="control-label col-sm-3" for="">Grupo:</label>
                        <div class="col-sm-9">
                            <select name="grupo" id="grupo" class="form-control">
                                <option value="MATERIAL DE CURACION">MATERIAL DE CURACION</option>
                                <option value="MEDICAMENTOS">MEDICAMENTOS</option>
                                <option value="SOLUCIONES">SOLUCIONES</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    
                    <center>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </center>


                </form>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>



<section class="contentain responsive">

        <div class="content">


            <?php

            include "../../conexionbd.php";
            include '../../conn_almacen/Connection.php';

            // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

            //  $result = $conn->query($sql);

          //  $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);
            ?>


            <!--Fin de los filtros-->


            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>

            <div class="table-responsive">
                <!--<table id="myTable" class="table table-striped table-hover">-->

                <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #2b2d7f">
                    <tr>
                        <th><font color="white">#</th>
                        <th><font color="white">Código MSI</th>
                        <th><font color="white">Descripción</th>
                        <th><font color="white">Precio</th>
                        <th><font color="white">U.M.</th>
                        <th><font color="white">Activo</th>
                        <th><font color="white">Editar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
                    //  $result = $conn->query($sql);
                    $resultado2 = $conexion_almacen->query("SELECT * FROM item_almacen i , item_type t where t.item_type_id = i.item_type_id") or die($conexion->error);
                    $no = 1;
                    while ($row = $resultado2->fetch_assoc()) {
                        $eid = $row['item_id'];
                        echo '<tr>'
                            . '<td>' . $row['item_id'] . '</td>'
                            . '<td>' . $row['item_code'] . '</td>'
                            . '<td>' . $row['item_name'] . ', ' . $row['item_grams'] . '</td>'
                            . '<td>' .'$'. $row['item_price'] . '</td>'
                            . '<td>' . $row['item_type_desc'] . '</td>';
                        ?>
    
                        <form class="form-horizontal title1" name="form" action="insertar_item.php?q=estatus"
                          method="POST" enctype="multipart/form-data">
                        <?php
                        echo '<td>';
                        if ((strpos($row['activo'], 'NO') !== false)) {
                            echo '<a type="submit" class="btn btn-danger btn-sm" href="insertar_item.php?q=estatus&eid=' . $eid . '&est=' . $row['activo'] . '"><span class = "fa fa-power-off"></span></a>';

                        } else {
                            echo '<a type="submit" class="btn btn-success btn-sm" href="insertar_item.php?q=estatus&eid=' . $eid . '&est=' . $row['activo'] . '"><span class = "fa fa-power-off"></span></a>';
                        }
                        
                        ?>
                        <?PHP
                        $usuario = $_SESSION['login'];
                        if ($usuario['id_usua'] == 1 || $usuario['id_usua'] == 56) {
                        echo '</td>'
                            . '<td> <a href="edit_items.php?id=' . $eid . '" title="Editar datos" class="btn btn-warning btn-sm "><span class="fa fa-edit" aria-hidden="true"></span></a></td>';
                        echo '</tr>';
                        $no++;
                    }}
                    ?>
                    </tbody>
                </table>

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

</body>
</html>