<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../index.php");
}

include "../header_enfermera.php";
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
         
          <div>
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                <tr><strong><center>EDITAR TEXTILES</center></strong>
            </div>
            <br>
            <?php
            $id = $_GET['id_text'];

            $sql = "SELECT * from textiles where id_text = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">


  <div class="row">
    <div class="col-sm-2"><center>
                  <label for="mat">Material:</label></center>
  <div class="row">
    <div class="col-sm">

<select data-live-search="true" class="form-control" name="mat" id="mat" style="width : 100%; heigth : 100%">
        <option value="<?php echo $row_datos['mat']; ?>"><?php echo $row_datos['mat']; ?></option>
        <option value="Gasas">Gasas</option>
        <option value="Compresas">Compresas</option>
        <option value="Push">Push</option>
        <option value="Cotonoides">Cotonoides</option>
        <option value="Instrumental">Instrumental</option>
        <option value="Agujas">Agujas</option>
       <option value="Otros">Otros</option>
        </select>

    </div>
    
</div>
    </div>
     <div class="col-sm-2">
      <label for="inicio">Inicio:</label>
      <input class="form-control" id="inicio" value="<?php echo $row_datos['inicio']; ?>" name="inicio" style="width : 100%; heigth : 100%" required="">
    </div>
    <div class="col-sm-2">
      <label for="dentro">Dentro:</label>
      <input class="form-control" id="dentro" value="<?php echo $row_datos['dentro']; ?>" name="dentro" style="width : 100%; heigth : 100%" required="">
    </div>
    <div class="col-sm-2">
      <label for="fuera">Fuera:</label>
      <input class="form-control" id="fuera" value="<?php echo $row_datos['fuera']; ?>" name="fuera" style="width : 100%; heigth : 100%" required="">
    </div>
    <div class="col-sm-2">
      <label for="total">Total:</label>
      <input class="form-control" id="total" value="<?php echo $row_datos['total']; ?>" name="total" style="width : 100%; heigth : 100%" required="">
    </div>
  </div>
<hr>
                <center><input type="submit" name="edit" class="btn btn-success" value="Guardar">
                  <a href="vista_enf_quirurgico.php" class="btn btn-danger">Cancelar</a>
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

        $mat    = mysqli_real_escape_string($conexion, (strip_tags($_POST["mat"], ENT_QUOTES))); 
        $inicio    = mysqli_real_escape_string($conexion, (strip_tags($_POST["inicio"], ENT_QUOTES))); 
        $dentro    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dentro"], ENT_QUOTES)));
        $fuera    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fuera"], ENT_QUOTES))); 
         $total    = mysqli_real_escape_string($conexion, (strip_tags($_POST["total"], ENT_QUOTES)));

$sql2 = "UPDATE textiles SET mat = '$mat', inicio = '$inicio',dentro = '$dentro',fuera = '$fuera',total = '$total' WHERE id_text = $id";
  $result = $conexion->query($sql2);

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location.href = "nav_textiles.php";</script>';
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