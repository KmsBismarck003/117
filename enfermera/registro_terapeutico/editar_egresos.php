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
                <tr><strong><center>EDITAR EGRESOS</center></strong>
            </div>
        <div class="row">
        
           
            <br>
            <?php
            $id = $_GET['id'];

            $sql = "SELECT * from eg_enf_ter where id_eg_ter = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

<div class="container">
  <div class="row">
      <div class="col-sm">  
              <label for="clave">Fecha de reporte:</label>
           <input type="date" name="fecha" class="form-control" value="<?php echo $row_datos['fecha_eg']; ?>">
          
           </div>
    <div class="col-sm">
     <div class="form-group">
                  <label for="clave">Hora:</label>
                  <select class="form-control" name="hora_eg" style="width : 100%; heigth : 100%" required="">
        <option value="<?php echo $row_datos['hora_eg']; ?>"><?php echo $row_datos['hora_eg']; ?></option>
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
  <option value="8">8:00 A.M.</option>

        </select>
                </div>
    </div>
    <div class="col-sm">
   <div class="form-group">
                  <label for="clave">Descripción:</label>
    <select class="form-control" name="des_eg" style="width : 100%; heigth : 100%" required="">
        <option value="<?php echo $row_datos['des_eg']; ?>"><?php echo $row_datos['des_eg']; ?></option>
        <option value="ORINA">ORINA</option>
  <option value="VOMITO">VOMITO</option>
  <option value="SANGRADO">SANGRADO</option>
  <option value="SONDA NASOGASTRICA">SONDA NASOGASTRICA</option>
  <option value="HERIDA QUIRURGICA">SONDA. T</option>
  <option value="EVACUACIONES">EVACUACIONES</option>
  <option value="DRENAJES">COLOSTOMIA</option>
  <option value="BIOVAC">BIOVAC IZQUIERDO</option>
  <option value="BIOVAC DER">BIOVAC DERECHO</option>
  <option value="DRENOVAC">DRENOVAC</option>
  <option value="PENROSE IZQ">PENROSE IZQUIERDO</option>
    <option value="PENROSE DER">PENROSE DERECHO</option>
  <option value="SARATOGA">SARATOGA</option>
  <option value="ESTOMAS">ILEOSTOMIAS</option>
        </select>              
                </div>
    </div>
    <div class="col-sm">
      <div class="form-group">
                  <label for="clave">Cantidad:</label>
                  <input type="text" size="30" name="cant_eg"  id="clave" class="form-control" 
                  value="<?php echo $row_datos['cant_eg']; ?>" required>
                </div>
    </div>
    <div class="col-sm">
      <div class="form-group">
                  <label for="clave">Características:</label>
                  <textarea name="carac" class="form-control"><?php echo $row_datos['carac']; ?></textarea>
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
 $fecha    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES))); 
        $hora_eg    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_eg"], ENT_QUOTES))); 
        $des_eg    = mysqli_real_escape_string($conexion, (strip_tags($_POST["des_eg"], ENT_QUOTES))); 
        $cant_eg    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cant_eg"], ENT_QUOTES))); 
$carac    = mysqli_real_escape_string($conexion, (strip_tags($_POST["carac"], ENT_QUOTES)));

        $sql2 = "UPDATE eg_enf_ter SET hora_eg = '$hora_eg', des_eg = '$des_eg',cant_eg = '$cant_eg',carac='$carac',fecha_eg='$fecha' WHERE id_eg_ter= $id";
        $result = $conexion->query($sql2);

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location.href = "reg_terapeutico.php";</script>';
      }
      ?>

  </section>
  </div>
  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>


</body>

</html>