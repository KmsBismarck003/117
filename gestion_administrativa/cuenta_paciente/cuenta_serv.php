<?php
session_start();
include "../../conexionbd.php";
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
      <br>
       <a type="submit" class="btn btn-danger btn-block col-md-2" href="../cuenta_paciente/valida_cta_serv.php">REGRESAR</a>      
      <br>
      <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                            <tr><strong><center>CUENTAS PAGADAS</center></strong>
      </div>
      <br>
      
        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
        </div>
        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">

            <thead class="thead" style="background-color: #2b2d7f; color:white;">
              <tr>
                <th>SERVICIO</th>
                <th>PACIENTE</th>
                <th>FECHA DE CIERRE</th>
                <th>VALIDADA</th>
                <th>RECIBO DE PAGO</th>
              </tr>
            </thead>
            <tbody>
              <?php

              include "../../conexionbd.php";

              $query = "SELECT DISTINCT(p.nombre), cta.*,m.* FROM cta_pagada_serv cta, metodo_pserv m, pago_serv p where cta.id_atencion=m.id_pac and m.id_pac=p.id_pac";
              $result = $conexion->query($query);
              //$result = mysql_query($query);
              while ($row = $result->fetch_assoc()) {
                $date=date_create($row['fecha_cierre']);
                echo '<tr>'
                  . '<td>' . $row['id_pac'] . '</td>'
                  . '<td>' . $row['nombre'] . '</td>'
                  . '<td>' . date_format($date,"d-m-Y h:i") . '</td>'
                  . '<td>' . $row['cta_cerrada'] . '</td>'
                  . '<td><a type="submit" class="btn btn-danger btn-sm" href="../pago_servicios/pdf_pago_servicios.php?id_pac=' . $row['id_pac'] . '" target="blank" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td></td>';
                echo '</tr>';
              }
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