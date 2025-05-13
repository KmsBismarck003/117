<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];




if ($usuario['id_rol'] == 8) {
  include "../header_ceye.php";
} else if ($usuario['id_rol'] == 4 or 5) {
  include "../header_ceye.php";
} else {
  //session_unset();
  // session_destroy();
  echo "<script>window.Location='../../index.php';</script>";
}


?>

<!DOCTYPE html>
<html>

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

<body>

  <section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->

    <?php
    include "../../conexionbd.php";
    ?>
    <div class="container box">
      <div class="content">
        <div class="content">

          <?php
          if ($usuario1['id_rol'] == 4) {
          ?>

            <a type="submit" class="btn btn-primary btn-block" href="../../template/menu_sauxiliares.php">Regresar</a>

          <?php
          } else if ($usuario1['id_rol'] == 8) {

          ?>
            <a type="submit" class="btn btn-primary btn-block" href="../../template/menu_ceye.php">Regresar</a>

          <?php
          } else if ($usuario1['id_rol'] == 5) {

          ?>
            <a type="submit" class="btn btn-primary btn-block" href="../../template/menu_sauxiliares.php">Regresar</a>

          <?php
          } else

          ?>
          <br>
          <center>
            <h1>Surtir material y medicamentos CEyE</h1>
          </center>
          <div class="row">
            <div class="col-md-6">
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Selecciona un páquete: </label>
                  <div class="col-md-6">
                    <!--  <select name="serv" class="selectpicker" data-live-search="true"> -->
                    <select class="selectpicker" data-live-search="true" name="paquete" required>
                      <?php

                    $query = "SELECT DISTINCt nombre FROM `paquetes_ceye` ";
                    $result = $conexion->query($query);

                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                    }
                      ?>
                    </select>

                  </div>
                </div>
                <div class="col-md-6">
                  <input type="submit" name="btnpaquete" class="btn btn-block btn-success" value="Seleccionar">
                </div>
              </form>
            </div>
            <div class="col-md-6">
              <a type="submit" class="btn btn-primary btn-block" href="surtir_ceye.php">Nuevo</a>
            </div>
          </div>
        </div>
        <?php

        if (isset($_POST['btnpaquete'])) {
          $paquete = mysqli_real_escape_string($conexion, (strip_tags($_POST["paquete"], ENT_QUOTES))); //Escanpando caracteres
          $id_usua = $usuario1['id_usua'];
          echo '<script type="text/javascript">
          window.location.href = "cargar_paquete.php?paquete=' . $paquete . '&id_usua=' . $id_usua . '";
        </script>';
        }

        ?>
      </div>
    </div>

    <?php
    if (isset($_GET['paquete'])) {
    ?>




    <?php
    } else {
    ?>




    <?php
    }
    ?>
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