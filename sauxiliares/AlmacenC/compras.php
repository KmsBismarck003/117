<?php
session_start();
include "../../conexionbd.php";
include '../../conn_almacen/Connection.php';

$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];
$id_usu= $usuario['id_usua'];

if ($usuario['id_rol'] == 11) {
    include "../header_almacenC.php";
} else if ($usuario['id_rol'] == 4) {
    include "../header_almacenC.php";
} else if ($usuario['id_rol'] == 5) {
    include "../header_almacenC.php";
} else{
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>
<!DOCTYPE html>
<div>

    <head>

        <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />


        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>



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


    </head>


    <div class="container-fluid">

        <?php
        if ($usuario1['id_rol'] == 11) {

            ?>
            <div class="container">
    <div class="row">
        <div class="col-sm-4">
            <a type="submit" class="btn btn-danger" href="../../template/menu_almacencentral.php">Regresar</a>
</div></div></div>
            <?php
        } else if ($usuario1['id_rol'] == 4) {

            ?>
            <div class="container">
    <div class="row">
        <div class="col-sm-4">
            <a type="submit" class="btn btn-danger" href="../../template/menu_almacencentral.php">Regresar</a>
</div></div></div>
            <?php
        }else if ($usuario1['id_rol'] == 5) {

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
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                 <tr><strong><center>COMPRAS PARA ALMACEN CENTRAL</center></strong>
            </div>
        </div>
    </div>
<br>
        
<div class="container">
  <div class="row">
    <div class="col-sm">
     <a href="pdf_compras.php" class="btn btn-md btn-block btn-success" 
     target="_blank">Imprimir reporte de compras pendientes</a>
    </div>
    <div class="col-sm">
      <a href="pdf_comprasr.php" class="btn btn-md btn-block btn-success" 
      target="_blank">Imprimir reporte de compras realizadas</a>
    </div>
   
  </div>
</div>
</div>
        <section class="content container-fluid">
            <div class="container box">
                <div class="content">

                    <?php

                    include "../../conexionbd.php";
                    include '../../conn_almacen/Connection.php';

                    $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);
                    ?>


                    <!--Fin de los filtros-->


                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
                    </div>

                    <div class="table-responsive">
                        <!--<table id="myTable" class="table table-striped table-hover">-->

                        <table class="table table-bordered table-striped" id="mytable">

                            <thead class="thead" style="background-color: #2b2d7f">
                            <tr>
                                <th><font color="white">Código</th>
                                <th><font color="white">Descripción</th>
                                <th><font color="white">Presentación</th>
                                <th><font color="white">Cantidad</th>
                                <th><font color="white">Almacén</th>
                                <th><font color="white">Fecha de solicitud</th>
                                <th><font color="white">Registró</th>
                                <th><font color="white">Comprado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                          

                            $resultado2 = $conexion_almacen->query("SELECT * FROM item_almacen i, compras c,  item_type it where it.item_type_id=i.item_type_id and i.item_id = c.item_id and c.comprado = 'NO' ") or die($conexion->error);
                            $no = 1;
                            while ($row = $resultado2->fetch_assoc()) {
                                $idcompra = $row['id_compra'];
                                $added=date_create($row['fecha_sol']);
                                $id_usua = $row['id_usua'];
                                if ($row['almacen']=="CEYE") {
                                    $almacen = "QUIRÓFANO";}
                                else {
                                    $almacen = $row['almacen'];} 
                                $sql = $conexion->query("SELECT * FROM reg_usuarios r where r.id_usua = $id_usua") or die($conexion->error);
                                 while ($row_usu = $sql->fetch_assoc()) {
                                    $nombre_usu = $row_usu['papell']; 
                                 }
                                echo '<tr>'
                                    . '<td>' . $row['item_code'] . '</td>'
                                    . '<td>' . $row['item_name'] .', ' . $row['item_grams'] . '</td>'
                                    . '<td>' . $row['item_type_desc'] . '</td>'
                                    . '<td>' . $row['compra_qty'] . '</td>'
                                    . '<td>' . $almacen . '</td>'
                                    . '<td>' . date_format($added,"d/m/Y H:i") . '</td>'
                                    . '<td>' . $nombre_usu. '</td>'
                                    .'<td>
                                    <form action="?idc='.$idcompra.'" method="POST">
                                     <button type="submit" name="confirmar" class="btn btn-success btn-block"><span class = "fa fa-check"></span></a></button></form></td>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
 
 <?php

if (isset($_POST['confirmar'])) {
    include "../../conn_almacen/Connection.php";
    $id_c=@$_GET['idc']; 


    $sql4 = $conexion_almacen->query("SELECT * FROM compras c where c.id_compra = $id_c and c.comprado ='NO'") or die('<p>Error al encontrar compras</p><br>' . mysqli_error($conexion));
    while ($row_stock = $sql4->fetch_assoc()) {
       $sql5 = "UPDATE compras set comprado='SI' where compras.id_compra = $id_c";
       $result5 = $conexion_almacen->query($sql5);
    
}
 echo '<script type="text/javascript">window.location.href = "compras.php";</script>';
}

?>


        </section>
    </div>
</div>
</div>
 
</body>

</html>