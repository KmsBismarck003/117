<?php
session_start();
include "../../conexionbd.php";
include "../header_farmaciah.php";
?>

<!DOCTYPE html>
<html>

<head>

  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script>
    // Write on keyup event of keyword input element
    $(document).ready(function() {
      $("#search").keyup(function() {
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#mytable tbody tr"), function() {
          if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
          else
            $(this).show();
        });
      });
    });
  </script>

<style>
     @media screen and (min-width: 320px) and (max-width: 980px){
   
h4{
    font-size:13px;
}
label{
    font-size:12px;
}
}
</style>

</head>

<body>


  <section class="content container-fluid">

    <div class="container box">
      <div class="content">


          <div class="row">
              <div class="col-sm-4"></div>
              
              <div class="col-sm-4"><a type="submit" class="btn btn-danger btn-block btn-sm"
                                       href="../../template/menu_farmaciahosp.php">Regresar...</a>
              </div>
          </div>
          <br>
        <center>
          <h4>CONSULTAR INDICACIONES MÉDICAS</h4>
        </center>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-sm-6 control-label">SELECCIONAR PACIENTE: </label>
           
                <!--  <select name="serv" class="selectpicker" data-live-search="true"> -->
                <select class="form-control col-sm-3"  data-live-search="true" name="paciente" required>
                    <option value="">SELECCIONAR</option>
                    <?php

                    $query = "SELECT * from paciente p, dat_ingreso di, cat_camas ca where p.Id_exp = di.Id_exp and di.activo='SI' and ca.id_atencion = di.id_atencion";
                    $result = $conexion->query($query);

                    while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_atencion'] . "'> " . $row['num_cama'] . " - " . $row['papell'] . " " . $row['sapell'] . " " . $row['nom_pac'] ." </option>";
                    $cama = $row['num_cama'];
                    }
                    ?>
                </select>

            </div>
                 <input type="submit" name="btnpaciente" class="btn btn-block btn-success col-sm-2 btn-sm" value="SELECCIONAR">
                
        </form>
      </div>
    </div>
    <?php

    include "../../conexionbd.php";
    //    $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);

    if (isset($_POST['btnpaciente'])) {
      $paciente = mysqli_real_escape_string($conexion, (strip_tags($_POST["paciente"], ENT_QUOTES))); //Escanpando caracteres

      echo '<script type="text/javascript"> window.location.href="order_indica.php?paciente=' . $paciente . '";</script>';
    }

    if ((isset($_GET['paciente']))) {
        $paciente1 = $_GET['paciente'];
        $usuario = $_SESSION['login'];
        $usuario2 = $usuario['id_usua'];
        
        $sql_paciente = "SELECT p.nom_pac, p.papell, p.sapell FROM paciente p, dat_ingreso di WHERE p.Id_exp = di.Id_exp and di.id_atencion = $paciente1";

        $result_pac = $conexion->query($sql_paciente);
        while ($row_pac = $result_pac->fetch_assoc()) {
            $pac = $row_pac['papell'] . ' ' . $row_pac['sapell'] . ' ' . $row_pac['nom_pac'] ;
        }
        ?>
        <center>
                <h3>Habitación:  <?php echo $cama .' -  Paciente: '.  $pac ?></h3>
        </center>
        <?php
        
        $resultado5=$conexion->query("select * from dat_ordenes_med WHERE id_atencion=" . $paciente1." ORDER BY id_ord_med DESC") or die($conexion->error);

        while ($f5 = mysqli_fetch_array($resultado5)) {
        ?>

        <div class="container box"><br>
            <div class="container">

            
            <br>

         
          <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="container">
                    <div class="row">
                        <div class=" col">
                            Tipo: <strong><?php echo $f5['tipo']; ?></strong>
                        </div>
                        <div class="col-sm-3">
                            <?php $fech=date_create($f5['fecha_ord']) ?>
                            Fecha: <strong><?php echo date_format($fech, 'd-m-Y'); ?></strong> 
                        </div>
                        <div class="col-sm-3">
                            Hora: <strong><?php echo $f5['hora_ord']; ?></strong>
                        </div>
                    </div>
                    <hr>
                </div>
          
            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f ">Medicamentos:</font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group"><br>
                        <textarea class="form-control" rows="10" disabled><?php echo $f5['med_med']; ?></textarea>
                        
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-2">
                    <center><strong><label for="exampleFormControlTextarea1"><br><font size="3" color="#2b2d7f ">Soluciones:</font></label></strong></center>
                </div>
                <div class=" col-10">
                    <div class="form-group"><br>
                        <textarea class="form-control" rows="5" disabled><?php echo $f5['soluciones']; ?></textarea>
                    </div>
                </div>

            </div>

        
           </div>
          </form>
          <br>
          <br>
          <br>

        </div>
     
    <?php
    }}
    ?>
  </section>
 

  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>

  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>

</html>