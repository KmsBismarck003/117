<?php
session_start();

include("../../conexionbd.php ");
include("../header_medico.php");
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

<section class="content container-fluid">
  <div class="container box">
    <div class="content">
      <center>
        <a href="../../template/menu_enfermera.php" class="btn btn-primary">REGRESAR...</a>


      </center>
      <h3>Disponibilidad de camas de hospitalización</h3>
      <div class="row">
        <?php
        $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where tipo="HOSPITALIZACION" ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          if ($estaus == "LIBRE") {
        ?>
            <!--
            <div class="col-lg-2 col-xs-4">
              <div class="alert alert-success" role="alert">
                <h7>Habitación: <?php //echo $num_cama 
                                ?></h7>
                <h7>Estatus: <?php //echo $estaus 
                              ?></h7>
                <a href="#" class="small-box-footer"><i style="font-size:50px;" class="fa fa-bed"></i></a>
                <br />
              </div>
            </div>-->
          <?php
          } elseif ($estaus == "NO_DISPONIBLE") {
          ?>
            <!--
            <div class="col-lg-2 col-xs-4">
              <div class="alert alert-warning" role="alert">
                <h7>Número de cama: <?php //echo $num_cama 
                                    ?></h7>
                 <h7>Estatus: NO DISPONIBLE</h7>
                <a href="#" class="small-box-footer"><i style="font-size:50px;" class="fa fa-bed"></i></a>
              </div>
            </div>-->
          <?php
          } else {
          ?>
            <div class="col-lg-2 col-xs-4">
              <div class="alert alert-danger" role="alert">
                <h7>Habitación: <?php echo $num_cama ?></h7><br>
                <!--  <h7>Estatus: OCUPADA</h7>-->
                <?php
                $sql_pac = "SELECT p.nom_pac, p.papell,p.sapell, di.Id_exp from dat_ingreso di, paciente p, cat_camas cc where $id_atencion = di.id_atencion and di.Id_exp = p.Id_exp";
                $result_pac = $conexion->query($sql_pac);
                while ($row_cam = $result_pac->fetch_assoc()) {
                  $nombre_pac = $row_cam['nom_pac'] . ' ' . $row_cam['papell'];
                }
                ?>
                <h7>Paciente: <?php echo $nombre_pac ?></h7>
                <br />
                <a href="select_pac.php?id_atencion=<?php echo $id_atencion ?>" class="small-box-footer"><i style="font-size:50px;" class="fa fa-bed"></i></a>
              </div>
            </div>
        <?php
          }
        }
        ?>
      </div>
    </div>

  </div>
</section>
</div>
<footer class="main-footer">
  <?php
  include("../../template/footer.php");
  ?>
</footer>
<script>
  document.oncontextmenu = function() {
    return false;
  }
</script>
</body>

</html>