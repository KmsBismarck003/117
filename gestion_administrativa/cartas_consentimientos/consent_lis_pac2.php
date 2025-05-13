<?php
session_start();
//include "../../conexionbd.php";
include "../header_administrador.php";
//$Id_exp=$_GET['Id_exp'];
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="gb18030">
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

  <title>Alta de usuarios </title>

</head>

<body>
  <section class="content container-fluid">


    <div class="container box">
      <div class="content">

        <?php

        include "../../conexionbd.php";


        // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

        //  $result = $conn->query($sql);

        $resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        ?>


        <!--Fin de los filtros-->

                    <button type="button" class="btn btn-danger btn-sm" onclick="history.back()">Regresar</button>
                   
              
        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR">
        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #2b2d7f;color:white;">
              <tr>
                <th>Expediente.</th>
                <th>Paciente</th>
                <th>Fecha de ingreso</th>
                <th>Hoja inicial</th>
                <th>Hoja frontal</th>
                <th>Contrato servicios</th>
                <th>Consentimiento <br> Datos personales</th>
                <th>Ficha identificación</th>
             <!--   <th>Expediente completo</th>-->
              </tr>
            </thead>
            <tbody>

              <?php
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion, DI.fecha FROM paciente P, dat_ingreso DI WHERE  DI.activo ='SI' AND DI.Id_exp=P.Id_exp ORDER BY DI.fecha DESC") or die($conexion->error);

             // $resultado2 = $conexion->query("select paciente.*, dat_ingreso.*
          //   from dat_ingreso 
            //  inner join paciente on dat_ingreso.Id_exp=paciente.Id_exp
              // where dat_ingreso.activo='SI'&& dat_ingreso.Id_exp=$Id_exp ") or die($conexion->error);
              while ($row = $resultado2->fetch_assoc()) {
                $date1 =  date_create($row['fecha']);
                echo '<tr>'
                  . '<td>' . $row['Id_exp'] . '</td>'
                  . '<td>' . $row['papell'] . ' '. $row['sapell'] . ' ' .$row['nom_pac'].'</td>'
                   . '<td>' . date_format($date1,"d/m/Y H:i a") . '</td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../../gestion_administrativa/cartas_consentimientos/pdf_hoja_inicial.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                       style="font-size:20px"></span></a>
                  </strong></td>'
                  . '<td> <strong>
                   <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_hoja_frontal.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                       style="font-size:20px"></span></a>
                  </strong></td>' 

                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_dat_finan.php?id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>'
                  
                   . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_dat_personales.php?id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>'
  
  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_ficha_identifica.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>' . '</tr>';
                  }  ?>
                  <!--
       <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_expediente_completo.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong>-->
               
              

            


            </tbody>
          </table>

        </div>

  </section>
  
  </div>

   
</body>

</html>