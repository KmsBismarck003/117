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
                <tr><strong><center>EDITAR CATÉTERES</center></strong>
            </div>
            <br>
            <?php
            $id = $_GET['id_cate_ter'];

            $sql = "SELECT * from cate_enf_ter where id = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>  
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

<div class="container">
  <div class="row">
    <div class="col-sm-3">
     <div class="form-group">
                  <label for="Dispisitivos">Dispositivos:</label>
                <select name="dispositivos" id="Dispisitivos" class="form-control" required>
         <option value="<?php echo $row_datos['dispositivos']; ?>"><?php echo $row_datos['dispositivos']; ?></option>
         <option value="CATETER CENTRAL">Catéter central</option>
          <option value="CATETER PERIFERICO">Catéter periferico</option>
           <option value="SONDA VESICAL">Sonda vesical</option>
            <option value="SONDA NASOGASTRICA">Sonda nasogástrica</option>
             <option value="OTROS">Otros</option>
      </select>
                </div>
    </div>
    <div class="col-sm-1">
   <div class="form-group">
                  <label for="tipo">Tipo:</label>
                   <input type="text" size="30" name="tipo"  id="tipo" class="form-control" 
                  value="<?php echo $row_datos['tipo']; ?>" required>
                </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
                  <label for="fechin">Fecha instalación:</label>
                  <input type="date" size="30" name="fecha_inst"  id="fechin" class="form-control" 
                  value="<?php echo $row_datos['fecha_inst']; ?>" required>
                </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group">
                  <label for="inst">Instalo:</label>
                  <input type="text" size="30" name="instalo"  id="inst" class="form-control" 
                  value="<?php echo $row_datos['instalo']; ?>" required>
                </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
                  <label for="dii">Dias instalados:</label>
                  <input type="text" size="30" name="dias_inst"  id="dii" class="form-control" 
                  value="<?php echo $row_datos['dias_inst']; ?>" required>
                </div>
    </div>
<div class="col-sm-2">
      <div class="form-group">
                  <label for="fechcam">Fecha de cambio:</label>
                  <input type="date" size="30" name="fecha_cambio"  id="fechcam" class="form-control" 
                  value="<?php echo $row_datos['fecha_cambio']; ?>" required>
                </div>
    </div>
<div class="col-sm-9">
      <div class="form-group">
                  <label for="cultivo">Observaciones</label>
                  <textarea name="cultivo" rows="1" id="cultivo" class="form-control" required><?php echo $row_datos['cultivo']; ?></textarea>
                </div>
    </div>

  </div>
</div>
                <center><input type="submit" name="edit" class="btn btn-success" value="Guardar">
                  <a href="reg_terapeutico.php" class="btn btn-danger">Cancelar</a>
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

$dispositivos    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dispositivos"], ENT_QUOTES)));
$tipo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES))); 
$fecha_inst    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_inst"], ENT_QUOTES)));
$instalo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["instalo"], ENT_QUOTES)));
$dias_inst    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dias_inst"], ENT_QUOTES)));
$fecha_cambio    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_cambio"], ENT_QUOTES)));
$cultivo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cultivo"], ENT_QUOTES))); 

        $sql2 = "UPDATE cate_enf_ter SET dispositivos = '$dispositivos', tipo = '$tipo',fecha_inst = '$fecha_inst',instalo = '$instalo',dias_inst = '$dias_inst',fecha_cambio = '$fecha_cambio',cultivo = '$cultivo' WHERE id = $id";
        $result = $conexion->query($sql2);

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location.href = "reg_terapeutico.php";</script>';
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