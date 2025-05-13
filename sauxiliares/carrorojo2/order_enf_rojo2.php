<?php
session_start();
include "../../conexionbd.php";
include "../header_ceye.php";


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
    <div class="container box">
      <div class="content">
        <div class="row">
          <div class="col-sm-4"><center><button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button></center>
          </div>
        </div>
        <br>
        <center>
          <h3>BUSCAR PACIENTE</h3>
        </center>
        <form class="form-horizontal" action="med_equip_ceye.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-sm-3 control-label">Paciente: </label>
            <div class="col-md-6">
              <!--  <select name="serv" class="selectpicker" data-live-search="true"> -->
              <select class="selectpicker" data-live-search="true" name="paciente" required>
                <?php

                $query = "SELECT * from paciente p, dat_ingreso di where p.Id_exp = di.Id_exp and di.activo='SI' and di.area='QUIROFANO'";
                $result = $conexion->query($query);
             
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['Id_exp'] . "'>" . $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell'] . "</option>";
                }
                ?>
              </select>

            </div>
          </div>
          <div class="col-md-6">
            <button type="submit" class="btn btn-block btn-success">BUSCAR PACIENTE</button>
          </div>

        </form>
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