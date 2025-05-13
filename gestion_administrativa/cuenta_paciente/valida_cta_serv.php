<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];
$usuario1 = $usuario['id_usua'];
include "../header_administrador.php";

?>

<!DOCTYPE html>
<html>

<head>

  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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

  <style>
    td.fondo {
      background-color: red !important;
    }
  </style>

</head>

<body>

  <section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->
    <div class="container box">
      <div class="content">
            <a type="submit" class="btn btn-danger" href="../../template/menu_administrativo.php">REGRESAR</a>
          
            <a type="submit" class="btn btn-primary" href="../cuenta_paciente/cuenta_serv.php">SERVICIOS PAGADOS</a>
        
        <br>

        <center>
          <h3>SERVICIOS PENDIENTES DE VALIDAR </h3>
        </center>
        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
        </div>
        
                <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #2b2d7f; color: white;">
              <tr>
                <th>FOLIO</th>
                <th>FECHA</th>
                <th>NOMBRE DEL PACIENTE</th>
                <th>PERSONAL VENECIA QUE COBRÓ</th>
                <th>VALIDAR</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $usuario = $_SESSION['login'];
              $id_usua=$usuario['id_usua'];
              $resultado4 = $conexion->query("SELECT p.*,p.nombre as nompac,cta.*, cta.id_usua as cobro, r.* FROM pserv p, cta_pagada_serv cta, reg_usuarios r where p.id_pac=cta.id_atencion and p.activo='NO' and cta.cta_cerrada='NO' and cta.id_usua=r.id_usua") or die($conexion->error);
              $total_dep = 0;
              $no = 1;
              while ($row4 = $resultado4->fetch_assoc()) {
                $fecha=date_create($row4['fecha']);
                echo '<tr>'
                  . '<td>' . $row4['id_pac'] . '</td>'
                  . '<td>' . date_format($fecha,"d-m-Y H:i:s") . '</td>'
                  . '<td>' . $row4['nompac'] . '</td>'
                  . '<td>' . $row4['nombre'].' '.$row4['papell'].' '.$row4['sapell'] .'</td>';
                  echo '<td style="color:white;"><a type="submit" class="btn btn-success btn-sm" href="val_c_serv.php?id_pac_serv=' . $row4['id_pac'] . '&id_usua=' . $usuario1 . '"><span class = "fa fa-check"></span></a></td>';
                echo '</tr>';
                $no++;
              }
              ?>
            </tbody>
          </table>

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

</body>

</html>