<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../index.php");
}

include "../header_labo.php";
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
                <tr><strong><center>EDITAR SERVICIO</center></strong>
            </div>
            <br>
            <?php
            $id = $_GET['id'];

            $sql = "SELECT serv_cve,serv_costo,serv_costo2,serv_costo3, serv_desc, serv_umed,tipo from cat_servicios where id_serv = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="clave">Clave:</label>
                  <input type="text" size="30" name="clave" placeholder="Clave de Servicio" id="clave"  value="<?php echo $row_datos['serv_cve']; ?>" required class="form-control">
                </div>

                <div class="form-group">
                  <label for="descripcion">Nombre:</label>
                  <input type="text" name="descripcion" placeholder="Descripción" id="descripcion" 
                  value="<?php echo $row_datos['serv_desc']; ?>" required class="form-control">
                </div>
                <div class="form-group">
                  <label for="costo">Precio 1:</label>
                  <input type="number" min="0" step="0.01" name="costo" placeholder="PRECIO" id="costo"  value="<?php echo $row_datos['serv_costo']; ?>" required class="form-control">
                </div>
                <div class="form-group">
                  <label for="costo2">Precio 2:</label>
                  <input type="number" min="0" step="0.01" name="costo2" placeholder="PRECIO 2" id="costo2"  value="<?php echo $row_datos['serv_costo2']; ?>" required class="form-control">
                </div>
                <div class="form-group">
                  <label for="costo3">Precio 3:</label>
                  <input type="number" min="0" step="0.01" name="costo3" placeholder="PRECIO 3" id="costo3"  value="<?php echo $row_datos['serv_costo3']; ?>" required class="form-control">
                </div>
                <div class="form-group">
                  <label for="costo3">Precio 4:</label>
                  <input type="number" min="0" step="0.01" name="costo4" placeholder="PRECIO 4" id="costo4"  value="<?php echo $row_datos['serv_costo4']; ?>" required class="form-control">
                </div>
                <div class="form-group">
                  <label for="med">Unidad de medida:</label>
                  <select name="med" class="form-control" required>
                    <option value="<?php echo $row_datos['serv_umed'] ?>"><?php echo $row_datos['serv_umed'] ?> </option>
                     <option value="CONSULTA">CONSULTA</option>
                     <option value="DIA">DIA</option>
                     <option value="EQUIPO">EQUIPO</option>
                     <option value="ESTUDIO">ESTUDIO</option>
                     <option value="HORA">HORA</option>
                     <option value="MATERIAL">MATERIAL</option>
                     <option value="SERVICIO">SERVICIO</option>
                     <option value="TOMOGRAFIA">TOMOGRAFIA</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="">Tipo:</label>
                 
                    <select id="item-type" name="tipo" class="form-control">
                      <?php  $query = "SELECT * FROM service_type s, cat_servicios c where c.tipo=s.ser_type_id and c.id_serv = $id";
                      $results = $conexion->query($query);
                      while ($rows = $results->fetch_assoc()) {
                      $tipo=$rows['tipo'] ?>
                      <option value="<?php echo $rows['tipo'] ?>"><?php echo $rows['ser_type_desc'] ?></option><?php } ?>
                      
                      <?php
                      $query = "SELECT * FROM `service_type` where ser_type_id!=$tipo ";
                      $result = $conexion->query($query);
                      while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['ser_type_id'] . "'>" . $row['ser_type_desc'] . "</option>";
                      }
                      ?>
                    </select>
                  
                </div>

                <center><input type="submit" name="edit" class="btn btn-success" value="Guardar">
                  <a href="cat_servicios.php" class="btn btn-danger">Cancelar</a>
                </center>

          </div>
        <?php } ?>
        </form>
        </div>
        <div class="col-md-2"></div>
      </div>
      <?php

      if (isset($_POST['edit'])) {

        $serv_cve    = mysqli_real_escape_string($conexion, (strip_tags($_POST["clave"], ENT_QUOTES))); //Escanpando caracteres 
        $serv_desc    = mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES))); //Escanpando caracteres 
        $serv_costo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["costo"], ENT_QUOTES))); //Escanpando caracteres 
         $serv_costo2    = mysqli_real_escape_string($conexion, (strip_tags($_POST["costo2"], ENT_QUOTES))); //Escanpando caracteres 
          $serv_costo3    = mysqli_real_escape_string($conexion, (strip_tags($_POST["costo3"], ENT_QUOTES))); //Escanpando caracteres 
        $serv_umed    = mysqli_real_escape_string($conexion, (strip_tags($_POST["med"], ENT_QUOTES))); //Escanpando caracteres 
        $serv_type    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES))); //Escanpando caracteres 

        $sql2 = "UPDATE cat_servicios SET serv_cve = '$serv_cve', serv_desc = '$serv_desc', serv_costo = $serv_costo, serv_costo2 = $serv_costo2, serv_costo3 = $serv_costo3, serv_umed = '$serv_umed', tipo= $serv_type  WHERE id_serv = $id";
        $result = $conexion->query($sql2);

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location.href = "cat_servicios.php";</script>';
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