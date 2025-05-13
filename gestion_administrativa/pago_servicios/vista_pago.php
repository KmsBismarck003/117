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
		<div class="row">
			<div class="form-group">
			 <a href="pago_servicios.php"><button type="button" class="btn btn-danger">Regresar</button></center></a>
			</div>
		</div>
	</div>
	<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                         <tr><strong><center>PAGO DE SERVICIOS REGISTRADOS</center></strong>
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
                <th>Folio</th>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Personal</th>
                <th>Tipo</th>
                <th>Recibo</th>
                <th>Facturación</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $usuario = $_SESSION['login'];
              $id_usua=$usuario['id_usua'];
              $resultado4 = $conexion->query("SELECT * FROM cta_pagada_serv ORDER BY fecha_cierre desc") or die($conexion->error);
              $total_dep = 0;
              $no = 1;
              while ($row4 = $resultado4->fetch_assoc()) {
                $fecha=date_create($row4['fecha']);
                $tipo=$row4['tipo'];
                $idusu=$row4['id_usua'];
                $id_atencion=$row4['id_atencion'];
                $id_cta=$row4['id_cta_pag_serv'];
                
                $select="SELECT * FROM reg_usuarios where id_usua=$idusu";
                $result=$conexion->query($select);
                while ($row=$result->fetch_assoc()) {
                    $usuario=$row['papell'].' '.$row['sapell'];
                }
                
                echo '<tr>'
                  . '<td>' . $row4['id_cta_pag_serv']  . '</td>'
                  . '<td>' . date_format($fecha,"d-m-Y H:i:s") . '</td>'
                  . '<td>' . $row4['nombre'] . '</td>'
                  . '<td>' . $usuario . '</td>'
                  . '<td>' . $tipo . '</td>';
                echo '<td> <a type="submit" class="btn btn-danger btn-sm" href="pdf_pago_servicios.php?id_cta='.$id_cta.'&tipo='.$tipo.'" target="_blank">
                  <span class="fa fa-file-pdf-o"</span></a></td>';
                  
                  echo '<td><a type="submit" class="btn btn-success btn-sm"
                     href="../cuenta_paciente/facturacion_serv.php?id_atencion=' . $id_atencion . '" target="_blank"><span class="fa fa-file"</span></a></td>';
                
                echo '</tr>';
              }
              ?>
            </tbody>
          </table>

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