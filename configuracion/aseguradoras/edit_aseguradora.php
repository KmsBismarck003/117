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
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
            <tr><strong><center>EDITAR ASEGURADORA</center></strong>
       </div>
       <br>
            <?php
            $id = $_GET['id'];

            $sql = "SELECT * from cat_aseg where id_aseg = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="clave">Aseguradora:</label>
                  <input type="text" size="30" name="aseg" placeholder="Aseguradora" id="aseg" 
                   value="<?php echo $row_datos['aseg']; ?>" required>
                </div>
                <div class="form-group">
                  <label for="tip_precio">Tipo de precio:</label>
                  <input type="text" size="30" name="tip_precio" placeholder="Tipo de precio" id="tip_precio" 
                   value="<?php echo $row_datos['tip_precio']; ?>" required>
                </div>
                
                   <center><input type="submit" name="edit" class="btn btn-success" value="Guardar">
                    <a href="../aseguradoras/aseguradora.php" class="btn btn-danger">Cancelar</a></center> 
                 
          </div>
        <?php } ?>
        </form> 
        </div>
        <div class="col-md-2"></div>
      </div>
      <?php

      if (isset($_POST['edit'])) {

        $aseg    = mysqli_real_escape_string($conexion, (strip_tags($_POST["aseg"], ENT_QUOTES))); //Escanpando caracteres  
        $tip_precio    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tip_precio"], ENT_QUOTES))); //Escanpando caracteres  

        $sql2 = "UPDATE cat_aseg SET aseg = '$aseg', tip_precio = $tip_precio  WHERE id_aseg = $id";
        $result = $conexion->query($sql2);

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location.href="aseguradora.php";</script>';
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