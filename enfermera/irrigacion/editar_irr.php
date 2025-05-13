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
   <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                <tr><strong><center>EDITAR IRRIGACIÓN</center></strong>
            </div><br>
        <div class="row">
        
<p></p>
            <?php
            $id = $_GET['id'];

            $sql = "SELECT * from irrigacion where id_irrigacion = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
<div class="col-sm-2">  
              <label for="clave3">Fecha de reporte:</label>
           <input type="date" name="fecha_reporte" class="form-control" id="clave3" value="<?php echo $row_datos['fecha_reporte']; ?>">
           </div>
           <p></p>
<div class="container">
  <div class="row">
       
      
    <div class="col-sm-1">
     <div class="form-group">
                  <label for="clave4">Bolsa:</label>
                   <input type="text" name="bolsa" class="form-control" id="clave4" value="<?php echo $row_datos['bolsa']; ?>">
                </div>
    </div>
    <div class="col-sm-3">
   <div class="form-group">
                  <label for="clave5">Solución:</label>
    <select class="form-control" name="solucion" style="width : 100%; heigth : 100%" required="" id="clave5">
        <option value="<?php echo $row_datos['solucion']; ?>"><?php echo $row_datos['solucion']; ?></option>
         <option value="HEMODERIVADOS">HEMODERIVADOS</option>
         <option value="SOLUCION BASE">SOLUCIÓN BASE</option>
  <option value="MEDICAMENTOS">MEDICAMENTOS</option>
  <option value="VIA ORAL">VIA ORAL</option>
  <option value="AMINAS">AMINAS</option>
  <option value="INFUSIONES">INFUSIONES</option>
   <option value="NUTRICION ENTERAL">NUTRICIÓN ENTERAL</option>
 <option value="NUTRICION PARENTERAL">NUTRICIÓN PARENTERAL</option>
  <option value="CARGAS">CARGAS</option>
        </select>              
                </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
                  <label for="clave6">Hora entrada:</label>
                  <input type="time" size="30" name="hora_entrada"  id="clave6" class="form-control" 
                  value="<?php echo $row_datos['hora_entrada']; ?>" required>
                </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
                  <label for="clave7">Hora salida:</label>
                  <input type="time" size="30" name="hora_salida"  id="clave7" class="form-control" 
                  value="<?php echo $row_datos['hora_salida']; ?>" required>
                </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
                  <label for="clave8">Volumen entrada:</label>
                  <input type="text" size="30" name="vol_entrada"  id="clave8" class="form-control" 
                  value="<?php echo $row_datos['vol_entrada']; ?>" required>
                </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
                  <label for="clave9">Volumen salida:</label>
                  <input type="text" size="30" name="vol_salida"  id="clave9" class="form-control" 
                  value="<?php echo $row_datos['vol_salida']; ?>" required>
                </div>
    </div>
  </div>
</div>
                <center><input type="submit" name="edit" class="btn btn-success" value="Guardar">
                  <a href="reg_clin.php" class="btn btn-danger">Cancelar</a>
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
            $fecha_reporte =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_reporte"], ENT_QUOTES)));
            $bolsa =  mysqli_real_escape_string($conexion, (strip_tags($_POST["bolsa"], ENT_QUOTES)));
            $solucion =  mysqli_real_escape_string($conexion, (strip_tags($_POST["solucion"], ENT_QUOTES)));
            $hora_entrada =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_entrada"], ENT_QUOTES)));
            $hora_salida =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_salida"], ENT_QUOTES)));
            $vol_entrada =  mysqli_real_escape_string($conexion, (strip_tags($_POST["vol_entrada"], ENT_QUOTES)));
            $vol_salida =  mysqli_real_escape_string($conexion, (strip_tags($_POST["vol_salida"], ENT_QUOTES)));
            $balance=$vol_entrada-$vol_salida;

        $sql2 = "UPDATE irrigacion SET fecha_reporte = '$fecha_reporte', bolsa = '$bolsa',solucion = '$solucion',hora_entrada = '$hora_entrada',hora_salida = '$hora_salida' ,vol_entrada = '$vol_entrada' ,vol_salida = '$vol_salida',balance = '$balance' WHERE id_irrigacion = $id";
        $result = $conexion->query($sql2);

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato editado correctamente...</p>";
        echo '<script type="text/javascript">window.location.href = "nota_irrigacion.php";</script>';
      }
      ?>
    </div>
  </section>

  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>


</body>

</html>