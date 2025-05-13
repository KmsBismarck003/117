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
            <h1>¿Estás seguro de que deseas eliminar la cama?</h1>
            <?php
            $id = $_GET['id'];

            $sql = "SELECT id,estatus,tipo, num_cama, habitacion from cat_camas where id = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Número de cama: </label>
                  <div class="col-md-6">
                    <input type="text" name="num_cama" class="form-control" value="<?php echo $row_datos['num_cama'] ?>" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Estatus: </label>
                  <div class="col-md-6">
                    <input type="text" name="estatus" class="form-control" value="<?php echo $row_datos['estatus'] ?>" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Tipo: </label>
                  <div class="col-md-6">
                    <input type="text" name="tipo" class="form-control" value="<?php echo $row_datos['tipo'] ?>" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Habitación: </label>
                  <div class="col-md-6">
                    <input type="text" name="tipo" class="form-control" value="<?php echo $row_datos['habitacion'] ?>" disabled>
                  </div>
                </div>
              <?php
            }
              ?>
              <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-4">
                  <input type="submit" name="del" class="btn btn-warning" value="Eliminar Datos">
                  <a href="../../template/menu_configuracion.php" class="btn btn-danger">Cancelar</a>
                </div>
              </div>
              </form>
          </div>
          <div class="col-md-2"></div>
        </div>
        <?php

        if (isset($_POST['del'])) {
          /*  $num_cama    = mysqli_real_escape_string($conexion, (strip_tags($_POST["num_cama"], ENT_QUOTES))); //Escanpando caracteres 
  $estatus    = mysqli_real_escape_string($conexion, (strip_tags($_POST["estatus"], ENT_QUOTES))); //Escanpando caracteres 
  $tipo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES))); //Escanpando caracteres 
*/
          $sql2 = "DELETE FROM cat_camas WHERE id = $id";
          $result = $conexion->query($sql2);

          echo "<p class='alert alert-danger' id='mensaje'> <i class=' fa fa-check'></i> Dato eliminado correctamente...</p>";
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