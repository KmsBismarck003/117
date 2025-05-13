<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../index.php");
}

include "../header_medico.php";
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
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                <tr><strong><center>EDITAR EGRESOS</center></strong>
            </div>
            <br>
            <?php
            $id = $_GET['id'];

            $sql = "SELECT * from egresos_anest where id_egresos_anest = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

<div class="container">
  <div class="row">
    <div class="col-sm">
     <div class="form-group">
                  <label for="clave">Hora:</label>
                   <input type="time" name="horaa" class="form-control" value="<?php echo $row_datos['horaa'];?>">
                </div>
    </div>
    <div class="col-sm">
   <div class="form-group">
                  <label for="clave">Descripción:</label>
    <select class="form-control" name="descripcion" style="width : 100%; heigth : 100%" required="">
        <option value="<?php echo $row_datos['descripcion']; ?>"><?php echo $row_datos['descripcion']; ?></option>
         <option value="Dx 5%">Dx 5%</option>
  <option value="Fisiol">Fisiol</option>
  <option value="Hartman">Hartman </option>
  <option value="Gelatina">Gelatina</option>
    <option value="Dextran">Dextran</option>
      <option value="Plasma">Plasma</option>
        <option value="Sangre">Sangre</option>
          <option value="Otros">Otros</option>
        </select>              
                </div>
    </div>
    <div class="col-sm">
      <div class="form-group">
                  <label for="clave">Cantidad:</label>
                  <input type="text" size="30" name="cantidad"  id="clave" class="form-control" 
                  value="<?php echo $row_datos['cantidad']; ?>" required>
                </div>
    </div>
  </div>
</div>
                <center><input type="submit" name="edit" class="btn btn-success" value="Guardar">
                  <a href="nota_unidad_cuidados.php" class="btn btn-danger">Cancelar</a>
                </center>
<br>
          </div>
        <?php } ?>
        </form>
        </div>
        <div class="col-md-2"></div>
      </div>
      <?php

      if (isset($_POST['edit'])) {

        $horaa    = mysqli_real_escape_string($conexion, (strip_tags($_POST["horaa"], ENT_QUOTES))); 
        $descripcion   = mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES))); 
        $cantidad    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES))); 

        $sql2 = "UPDATE egresos_anest SET horaa = '$horaa', descripcion = '$descripcion',cantidad = '$cantidad' WHERE id_egresos_anest = $id";
        $result = $conexion->query($sql2);

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location.href = "nota_unidad_cuidados.php";</script>';
      }
      ?>
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