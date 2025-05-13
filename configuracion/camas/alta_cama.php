<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../index.php");
}

include("../header_configuracion.php");
?>

<head>
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

  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>



</head>

<body>
  <section class="content container-fluid">
    <div class="container box">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <h3>Agregar habitación</h3>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="col-sm-12 control-label">Habitación:</label>
                <input id="num_cama" placeholder ="Número de habitación"name="num_cama" type="number" min="0" required class="form-control col-sm-6">
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Estatus: </label>
                <div class="col-md-6">
                  <select name="estatus" class="form-control" required>
                    <option value="LIBRE">LIBRE</option>
                    <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Área: </label>
                <div class="col-md-6">
                  <select name="tipo" class="form-control" required>
                    <option value="HOSPITALIZACIÓN">HOSPITALIZACIÓN</option>
                    <option value="OBSERVACIÓN">OBSERVACIÓN</option>
                    <option value="TERAPIA INTENSIVA">TERAPIA INTENSIVA</option>
                    <option value="ENDOSCOPÍA">ENDOSCOPÍA</option>
                    <option value="CONSULTA">CONSULTA</option>
                    
                  <!--  <option value="UCIN">UCIN</option>
                    <option value="CUNEROS">CUNEROS</option>-->
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Habitación: </label>
                <div class="col-md-6">
                  <select name="hab" class="form-control" required>
                    <option value="1">CUARTO ESTÁNDAR</option>
                    <option value="7">ESTANCIA EN OBSERVACIÓN</option>
                    <option value="3">TERAPIA INTENSIVA</option>
                    <option value="980">ENDOSCOPÍA</option>
                    <option value="11">CONSULTA</option>
                    
                  </select>
                </div>
              </div>
                <div class="form-group">
                <label class="col-sm-3 control-label">Piso:</label>
                <input id="piso" placeholder ="Piso"name="piso" type="number" min="0" required class="form-control col-sm-6">
              </div>

                <div class="form-group">
                <label class="col-sm-3 control-label">Sección:</label>
                <input class="form-control col-sm-6" id="sección" placeholder ="Sección"name="seccion" type="number" min="0" required>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-4">
                  <input type="submit" name="add" class="btn btn-success" value="Guardar">
                  <a href="../camas/cat_camas.php" class="btn btn-danger">Cancelar</a>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-2"></div>
        </div>
        <?php

        if (isset($_POST['add'])) {
          $num_cama    = mysqli_real_escape_string($conexion, (strip_tags($_POST["num_cama"], ENT_QUOTES))); //Escanpando caracteres 
          $estatus    = mysqli_real_escape_string($conexion, (strip_tags($_POST["estatus"], ENT_QUOTES))); //Escanpando caracteres 
          $tipo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES))); //Escanpando caracteres 
          $hab    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hab"], ENT_QUOTES))); //Escanpando caracteres 
          $piso    = mysqli_real_escape_string($conexion, (strip_tags($_POST["piso"], ENT_QUOTES))); //Escanpando caracteres 
          $seccion    = mysqli_real_escape_string($conexion, (strip_tags($_POST["seccion"], ENT_QUOTES))); //Escanpando caracteres 

          $sql2 = "INSERT INTO cat_camas(num_cama,estatus,tipo,habitacion,id_atencion,piso,seccion,serv_cve)VALUES($num_cama,'$estatus', '$tipo','$hab',0, '$piso','$seccion','$hab')";
          $result = $conexion->query($sql2);

          echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
          echo '<script type="text/javascript">window.location.href="cat_camas.php";
          </script>';
        }
        ?>
      </div>
    </div>
  </section>
  </div>
  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>


</body>

</html>