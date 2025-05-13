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
  
    <div class="container box">
      <div class="container">

        <div class="row">
         
          <div>
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                <tr><strong><center>EDITAR SIGNOS VITALES</center></strong>
            </div>
            <br>
            <?php
            $id = $_GET['id_sig'];

            $sql = "SELECT * from signos_vitales where id_sig = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

<div class="container">
  <div class="row">
    <div class="col-sm-2">
     <div class="form-group">
                  <label for="hor">Hora:</label>
                  <select class="form-control" id="hor" name="hora" style="width : 100%; heigth : 100%" required="">
        <option value="<?php echo $row_datos['hora']; ?>"><?php echo $row_datos['hora']; ?></option>
  <option value="8">8:00 A.M.</option>        
  <option value="9">9:00 A.M.</option>
  <option value="10">10:00 A.M.</option>
  <option value="11">11:00 A.M.</option>
  <option value="12">12:00 A.M.</option>
  <option value="13">13:00 P.M.</option>
  <option value="14">14:00 P.M.</option>
  <option value="15">15:00 P.M.</option>
  <option value="16">16:00 P.M.</option>
  <option value="17">17:00 P.M.</option>
  <option value="18">18:00 P.M.</option>
  <option value="19">19:00 P.M.</option>
  <option value="20">20:00 P.M.</option>
  <option value="21">21:00 P.M.</option>
  <option value="22">22:00 P.M.</option>
  <option value="23">23:00 P.M.</option>
  <option value="24">24:00 A.M.</option>
  <option value="1">1:00 A.M.</option>
  <option value="2">2:00 A.M.</option>
  <option value="3">3:00 A.M.</option>
  <option value="4">4:00 A.M.</option>
  <option value="5">5:00 A.M.</option>
  <option value="6">6:00 A.M.</option>
  <option value="7">7:00 A.M.</option>


        </select>
                </div>
    </div>
    <div class="col-sm-2">
   <div class="form-group">
                  <label for="pa">Presión arterial:</label>
  <div class="row">
    <div class="col-sm">
    <input type="text" size="30" name="p_sistol"  id="pa" class="form-control" 
                  value="<?php echo $row_datos['p_sistol']?>" required>
    </div>/
    <div class="col-sm">
                  <input type="text" size="30" name="p_diastol"  id="pa" class="form-control" 
                  value="<?php echo $row_datos['p_diastol']?>" required>
    </div>
    
  </div>


                </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
                  <label for="fc">Frecuencia cardiaca:</label>
                  <input type="text" size="30" name="fcard"  id="fc" class="form-control" 
                  value="<?php echo $row_datos['fcard']; ?>" required>
                </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group">
                  <label for="res">Frecuencia respiratoria:</label>
                  <input type="text" size="30" name="fresp"  id="res" class="form-control" 
                  value="<?php echo $row_datos['fresp']; ?>" required>
                </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
                  <label for="tura">Temperatura:</label>
                  <input type="text" size="30" name="temper"  id="tura" class="form-control" 
                  value="<?php echo $row_datos['temper']; ?>" required>
                </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
                  <label for="satoxi">Saturación oxígeno:</label>
                  <input type="text" size="30" name="satoxi"  id="satoxi" class="form-control" 
                  value="<?php echo $row_datos['satoxi']; ?>" required>
                </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
                  <label for="niv_dolor">Nivel dolor:</label>
                  <input type="text" size="30" name="niv_dolor"  id="niv_dolor" class="form-control" 
                  value="<?php echo $row_datos['niv_dolor']; ?>" required>
                </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group">
                  <label for="niv_dolor">Fecha:</label>
                  <input type="date" size="30" name="fecha" id="fecha" class="form-control" 
                  value="<?php echo $row_datos['fecha']; ?>" required>
                </div>
    </div>
     <div class="col-sm-3">
      <div class="form-group">
                  <label for="tipo">Tipo:</label>
                  <select name="tipo" id="tipo" class="form-control">
                      <option value="<?php echo $row_datos['tipo']; ?>"><?php echo $row_datos['tipo']; ?></option>
                      <option value="HOSPITALIZACIÓN">HOSPITALIZACIÓN</option>
                      <option value="TERAPIA INTENSIVA">TERAPIA INTENSIVA</option>
                      <option value="QUIROFANO">QUIROFANO</option>
                      <option value="RECUPERACIÓN">RECUPERACIÓN</option>
                      <option value="OBSERVACIÓN">OBSERVACIÓN</option>
                  </select>
                  
      </div>
    </div>
  </div>
</div>
                <center><input type="submit" name="edit" class="btn btn-success btn-sm" value="Guardar">
               

<button type="button" class="btn btn-danger btn-sm" onclick="history.back()">Regresar...</button>


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

        $hora    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES))); 
        $p_sistol    = mysqli_real_escape_string($conexion, (strip_tags($_POST["p_sistol"], ENT_QUOTES))); 
        $p_diastol    = mysqli_real_escape_string($conexion, (strip_tags($_POST["p_diastol"], ENT_QUOTES)));
        $fcard    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fcard"], ENT_QUOTES)));
        $fresp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fresp"], ENT_QUOTES)));
        $temper    = mysqli_real_escape_string($conexion, (strip_tags($_POST["temper"], ENT_QUOTES)));
        $satoxi    = mysqli_real_escape_string($conexion, (strip_tags($_POST["satoxi"], ENT_QUOTES))); 
        $niv_dolor    = mysqli_real_escape_string($conexion, (strip_tags($_POST["niv_dolor"], ENT_QUOTES))); 
        $fecha    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
        $tipo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES)));
      
        $tam=( $p_sistol + $p_diastol)/2;
        
        $sql2 = "UPDATE signos_vitales SET fecha = '$fecha',p_sistol = '$p_sistol', p_diastol = '$p_diastol',fcard = '$fcard',fresp = '$fresp', temper = '$temper',satoxi = '$satoxi',niv_dolor = '$niv_dolor',hora = '$hora',tipo = '$tipo', tam = '$tam' WHERE id_sig = $id";
        $result = $conexion->query($sql2);

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location.href = "signos.php";</script>';
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