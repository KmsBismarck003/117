<?php
session_start();
include "../../conexionbd.php";
include("../header_medico.php");


$usuario = $_SESSION['login'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />

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

  <?php function calculaedad($fechanacimiento)
  {
    list($ano, $mes, $dia) = explode("-", $fechanacimiento);
    $ano_diferencia = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia = date("d") - $dia;
    if ($ano_diferencia > 0) {
      $ano_diferencia--;
      return ($ano_diferencia . " Años");
    } else if ($mes_diferencia > 0 && $ano_diferencia < 0) {
      $mes_diferencia--;
      return ($mes_diferencia . " Meses");
    } elseif ($ano_diferencia <= 0 || $mes_diferencia <= 0 && $dia_diferencia > 0) {
      $dia_diferencia--;
      return ($dia_diferencia . " Días");
    }
  }
  ?>


  <title>Menu Gestión Médica </title>
  <link rel="shortcut icon" href="logp.png">
</head>



<body>
  <div class="container">
    <div class="row">
      <div class="col">

        <h2><strong>PACIENTE </strong></h2>
        <hr>
        <?php

        include "../../conexionbd.php";


        $resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);

        ?>
        <?php
        while ($f1 = mysqli_fetch_array($resultado1)) {


          ?>

          <div class="container">

            <div class="row">
              <div class="col-sm-5">
                Expediente: <td><strong><?php echo $f1['folio']; ?></strong></td>
                Paciente:
                <td><strong><?php echo $f1['nom_pac']; ?></strong></td>
                <td><strong><?php echo $f1['papell']; ?></strong></td> 
                <td><strong><?php echo $f1['sapell']; ?></strong></td><br>
                Género : <td><strong><?php echo $f1['sexo']; ?></strong></td><br>

              </div>

              <div class="col">
                <?php $date = date_create($f1['fecha']);
                $date1 = date_create($f1['fecnac']);
                $edad = calculaedad($f1['fecnac']);
                ?>
                FECHA DE INGRESO : <td><strong><?php echo date_format($date, "d/m/Y"); ?></strong></td> <br>
                FECHA DE NACIMIENTO : <td><strong><?php echo date_format($date1, "d/m/Y"); ?></strong></td><br>


                EDAD : <td><strong><?php echo $edad; ?></strong></td><br>
              <?php
        }
        ?>
            </div>

            <?php
            $resultado2 = $conexion->query("select * from cat_camas WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);
            while ($f2 = mysqli_fetch_array($resultado2)) {
              ?>
              <div class="col">
                <?php
                if (isset($f2)) {
                  $cama = $f2['num_cama'];
                } else {
                  $cama = 'Sin Cama';
                }
                ?>
                HABITACIÓN : <td><strong><?php echo $cama; ?></strong></td>

                <?php
            }
            ?>
            </div>


          </div>
          <!-- Main content -->
          <section class="content">
            <!-- CONTENIDOO -->
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->


              <!-- Wrapper for slides -->
              <div class="carousel-inner">
                <div class="item active">
                  <center><img src="../../imagenes/sin.png" height="300" alt="Sanatorio"></center>
                </div>
              </div>

              <!-- Left and right controls -->
              <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>

          </section><!-- /.content -->
        </div>
      </div>
    </div>
  </div>
  </div>
  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>
  </div>



  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>

</html>