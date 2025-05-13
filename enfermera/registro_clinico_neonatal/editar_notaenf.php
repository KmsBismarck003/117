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
                <tr><strong><center>EDITAR NOTA DE ENFEMERÍA</center></strong>
            </div>
        
          
            <br>
            <?php
            $id = $_GET['id'];

            $sql = "SELECT * from nota_enf_obs where id_enf_obs   = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

  <div class="row">
       <div class="col-sm">  
              <label for="clave">Fecha de reporte:</label>
           <input type="date" name="fecha" class="form-control" value="<?php echo $row_datos['fecha']; ?>">
          
           </div>
      
    <div class="col-sm">
     <div class="form-group">
                  <label for="clave">Hora:</label>
                  <select class="form-control" name="hora" style="width : 100%; heigth : 100%" required="">
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
    <div class="col-sm-7">
      <div class="form-group">
                  <label for="clave">Cuidados de enfermería:</label>
                  <textarea name="cuidenf" class="form-control" rows="5"><?php echo $row_datos['cuidenf']; ?></textarea>
                 
                </div>
    </div>
    <div class="col-sm-7">
      <div class="form-group">
                  <label for="clave">Nota de enfermería:</label>
                  <textarea name="notaenf" class="form-control" rows="5"><?php echo $row_datos['notaenf']; ?></textarea>
                 
                </div>
    </div>
  </div>
</div>
                <center><input type="submit" name="edit" class="btn btn-success" value="Guardar">
                  <a href="nota_bebes.php" class="btn btn-danger">Cancelar</a>
                </center>
<br>
          </div>
        <?php } ?>
        </form>
        </div>
        <div class="col-md-2"></div>
   
      <?php

      if (isset($_POST['edit'])) {
 $fecha    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
        $hora    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES))); 
        $notaenf    = mysqli_real_escape_string($conexion, (strip_tags($_POST["notaenf"], ENT_QUOTES))); 
        $cuidenf    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cuidenf"], ENT_QUOTES))); 

$hora_med = strval($hora);
if($hora_med=='8' || $hora_med=='9' || $hora_med=='10' ||$hora_med=='11' ||$hora_med=='12' ||$hora_med=='13'){
        $turno="MATUTINO";
    } else if ($hora_med=='14' || $hora_med=='15' || $hora_med=='16' ||$hora_med=='17' ||$hora_med=='18' ||$hora_med=='19'||$hora_med=='20'){
        $turno="VESPERTINO";
    }else if ($hora_med=='21' || $hora_med=='22' || $hora_med=='23' ||$hora_med=='24' ||$hora_med=='1' ||$hora_med=='2'||$hora_med=='3'||$hora_med=='4'||$hora_med=='5'||$hora_med=='6'||$hora_med=='7'){
        $turno="NOCTURNO";
    }

        $sql2 = "UPDATE nota_enf_obs SET fecha = '$fecha',hora = '$hora',turno = '$turno',notaenf = '$notaenf',cuidenf = '$cuidenf' WHERE id_enf_obs= $id";
        $result = $conexion->query($sql2);

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Nota de enfermería editada correctamente...</p>";
        echo '<script type="text/javascript">window.location.href = "nota_bebes.php";</script>';
      }
      ?>

  </section>

  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>


</body>

</html>