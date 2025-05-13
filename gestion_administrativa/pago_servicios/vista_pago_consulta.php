<?php 
session_start();

include "../../conexionbd.php";
include "../../gestion_administrativa/header_administrador.php";

 ?>
<!DOCTYPE html>
<html>
<head>

<meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
     <meta name="viewport" content=”text/html; charset=ISO-8859-1″/>
    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>
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
    hr.new4 {
      border: 1px solid red;
    }
  </style>

	<meta charset="utf-8">
	<title></title>
</head>
<body>
    <div class="container">
     <div class="container">
        <div class="row">
            <div class="col-sm-4">
             <a href="pago_servicios.php"><button type="button" class="btn btn-danger">REGRESAR</button></center></a>
            </div>
        </div>
    </div>   
    </div><hr>
	<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                         <tr><strong><center>PAGO DE CONSULTAS</center></strong>
    </div>
	<hr>
      <div class="container">
          <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #2b2d7f; color: white;">
              <tr>
                <th>#</th>
                <th>Fecha de consulta</th>
                <th>Nombre</th>
                <th>Fecha de nacimiento</th>
                <th>Aseguradora</th>
                <th>Pagar</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $usuario = $_SESSION['login'];
              $id_usua=$usuario['id_usua'];
        $select="SELECT * FROM receta_ambulatoria where pagado='NO' ORDER BY fecha DESC";
        $result=$conexion->query($select);
        $no = 1;
        while ($row=$result->fetch_assoc()) {
                $nombre=$row['nombre_rec'].' '.$row['papell_rec'].' '.$row['sapell_rec'];
                $fecha=date_create($row['fecha']);
                $fecnac=date_create($row['fecnac_rec']);
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . date_format($fecha,"d-m-Y H:i a") . '</td>'
                  . '<td>' . $nombre . '</td>'
                  . '<td>' . date_format($fecnac,"d-m-Y H:i a"). '</td>'
                  . '<td>' . $row['aseguradora'] . '</td>';
                  echo '<td><strong><a type="submit" class="btn btn-danger btn-sm" href="pago_consulta_externa.php?id_pac=' . $row['id_rec_amb'] . '&nombre=' . $nombre . '&id_amb=' . $row['id_rec_amb'] . '"><span class = "fa fa-file-text"></span></a></td>';
                echo '</tr>';
                $no++;
              
          }
              ?>
            </tbody>
          </table>

        </div>
      </div>
	
    </div>
    <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
<script>
    document.oncontextmenu = function () {
        return false;
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador2').select2();
    });
</script>
</body>
</html>