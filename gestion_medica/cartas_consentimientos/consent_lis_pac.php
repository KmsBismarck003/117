<?php
session_start();
//include "../../conexionbd.php";
include "../header_medico.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
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

  <title>DOCUMENTACIÓN </title>

</head>
<!--seccion urgencias-->

<body>
  <section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->


    <div class="container box">
      <div class="content">


        <?php

        include "../../conexionbd.php";



        // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

        //  $result = $conn->query($sql);

        $resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        ?>


        <!--Fin de los filtros-->

        <center>
          <a href="../../template/menu_medico.php" class="btn btn-danger">REGRESAR...</a>

        </center>
        <div class="form-group">
          <strong>NOTAS MEDICAS</strong>

        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: seagreen">
              <tr>
                <th>Expediente</th>
                <th>Nombre del paciente</th>
                <th>Ficha de Identificación</th>
                <th>Cons. Bajo información</th>
                <th>Cons. Bajo Inf. para proceso anestésico</th>
                <th>Historia Clinica</th>
                <th>Nota de Urgencias</th>
                <th>Nota Neonatologica</th>
                <th>Ordenes del Médico</th>
                <th>Nota de Ingreso</th>
                <th>Nota de Interconsulta</th>
                <th>Nota de Traslado</th>
                <th>Nota de Evolución</th>
                <th>Nota de Posparto</th>
                <th>Nota de Transfusión</th>
                <th>Nota de Egreso</th>
                <th>Aviso de alta</th>
                <th>Receta Medica</th>
                <th>Partograma</th>
                <th>Unidad de <br>toco-cirugía</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp AND DI.activo ='SI' and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                echo '<tr>'
                  . '<td>' . $row['Id_exp'] . '</td>'
                  . '<td>' . $row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nom_pac'] . '</td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../../gestion_administrativa/fichas/pdf_ficha_identifica.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_consent_BI.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_consent_anest.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../historia_clinica/pdf_hclinica.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_not_urgencias.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_neo.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td>  <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/vista_ordenes_med.php"
                     ><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_ingreso.php?Id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_inter.php?Id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'

                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_traslados.php?Id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/vista_evo.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_posparto.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_transf.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_egreso.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_alta.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../hospitalizacion/pdf_recetario_medico_hospitalizacion.php?id_exp=' . $row['Id_exp'] . '&id=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'

                  . '<td> <strong>
              <a type="submit" class="btn btn-danger btn-sm"
                 href="../ginecologia/pdf_partograma.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                 target="_blank"><span class="fa fa-file-pdf-o"
                                       style="font-size:28px"></span></a>
          </strong></td>'
                  . '<td> <strong>
              <a type="submit" class="btn btn-danger btn-sm"
                 href="../ginecologia/pdf_u_toco-cir.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                 target="_blank"><span class="fa fa-file-pdf-o"
                                       style="font-size:28px"></span></a>
          </strong></td>'

                  . '</tr>';
                $no++;
              }

              ?>


            </tbody>
          </table>

        </div>


  </section>
  <section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->


    <div class="container box">
      <div class="content">


        <?php

        include "../../conexionbd.php";



        // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

        //  $result = $conn->query($sql);

        $resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        ?>


        <!--Fin de los filtros-->


        <div class="form-group">
          <strong>NOTAS QUIRÚRGICAS</strong>

        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: seagreen">
              <tr>
                <th>Expediente</th>
                <th>Nombre del paciente</th>
                <th>Nota Preoperatoria</th>
                <th>Intervención Quirurgica</th>
                <th>Cirugía segura</th>
                <th>Nota Postoperatoria</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp AND DI.activo ='SI' and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                echo '<tr>'
                  . '<td>' . $row['Id_exp'] . '</td>'
                  . '<td>' . $row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nom_pac'] . '</td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../quirurgico/pdf_nota_preoperatoria.php?id_exp=' . $row['Id_exp'] . '&id=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../quirurgico/pdf_intervencion_quirurgica.php?id_exp=' . $row['Id_exp'] . '&id=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../quirurgico/pdf_cirugia_segura.php?id_exp=' . $row['Id_exp'] . '&id=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../quirurgico/pdf_nota_postoperatoria.php?id_exp=' . $row['Id_exp'] . '&id=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
              }

              ?>


            </tbody>
          </table>

        </div>


  </section>


  <!--seccion anestesica-->
  <section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->


    <div class="container box">
      <div class="content">


        <?php

        include "../../conexionbd.php";



        // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

        //  $result = $conn->query($sql);

        $resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        ?>


        <!--Fin de los filtros-->


        <div class="form-group">
          <strong>NOTAS ANESTÉSICAS</strong>

        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: seagreen">
              <tr>
                <th>Expediente</th>
                <th>Nombre del paciente</th>
                <th>Valoración Pre-Anestésica</th>
                <th>Evaluación antes del procedimiento Anestésico</th>
                <th>Registro Descriptivo Trans-Anestésico</th>
                <th>Nota de Recuperación</th>
                <th>Nota Post-Anestésica</th>

              </tr>
            </thead>
            <tbody>

              <?php
              $id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp AND DI.activo ='SI' and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                echo '<tr>'
                  . '<td>' . $row['Id_exp'] . '</td>'
                  . '<td>' . $row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nom_pac'] . '</td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_pre_anestesica.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_2da_evaluacion.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_des_transanestesico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_nota_recup.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_postanestesica.php?Id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'





                  . '</tr>';
                $no++;
              }

              ?>


            </tbody>
          </table>

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


</strong><script language=javascript>
function closer() {
var ventana = window.self;
ventana.opener = window.self;
ventana.close();
}
</script>





</body>

</html>