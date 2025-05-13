<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");
if (isset($_GET['id_atencion'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
  $resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp  WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);
  if (mysqli_num_rows($resultado) > 0) { //se mostrara si existe mas de 1
    $f = mysqli_fetch_row($resultado);
  } else {
    header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
  }
} else {
  header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />

  <link rel="stylesheet" type="text/css" href="css/select2.css">
  <script src="jquery-3.1.1.min.js"></script>
  <script src="js/select2.js"></script>
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


  <title>DATOS NURGEN </title>
</head>

<body>

  <div class="col-sm-12">
    <div class="container">
      <div class="row">
        <div class="col">
          <hr>
          <h2><strong>NOTAS DE EVOLUCIÓN</strong></h2>
          <hr>
          <?php

          include "../../conexionbd.php";

          $resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);

          ?>
          <?php
          while ($f1 = mysqli_fetch_array($resultado1)) {

          ?>
            <div class="container">
              <div class="row">
                <div class="col-sm-5">
                  NO.EXPEDIENTE: <td><strong><?php echo $f1['Id_exp']; ?></strong></td>
                </div>
                <div class="col-sm">
                  ADMISIÓN: <td><strong><?php echo $f1['id_atencion']; ?></strong></td>
                </div>
                <div class="col-sm">
                </div>
              </div>
            </div>
            <div class="container">

              <div class="row">
                <div class="col-sm-5">
                  PACIENTE:
                  <td><strong><?php echo $f1['papell']; ?></strong></td>
                  <td><strong><?php echo $f1['sapell']; ?></strong></td>
                  <td><strong><?php echo $f1['nom_pac']; ?></strong></td>
                </div>

                <div class="col-sm-5">
                  FECHA DE NACIMIENTO:
                  <td><strong><?php echo $f1['fecnac']; ?></strong></td>
                </div>
                <div class="col-sm">
                  EDAD:
                  <td><strong><?php echo $f1['edad']; ?></strong></td>
                </div>
              </div>
            </div>
            <hr>
          <?php
          }
          ?>

        </div>
        <div class="col-3">
          <?php
          
          $fecha_actual = date("Y-m-d H:i:s");
          ?>
          <hr>
          <div class="form-group">
            <label for="fecha">Fecha y Hora del Sistema:</label>
            <input type="datetime" name="fec_hc" value="<?= $fecha_actual ?>" class="form-control" disabled>
          </div>
        </div>
      </div>

      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">

          <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="true">NOTA DE EVOLUCIÓN</a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <!--INICIO DE NOTA DE EVOLUCION-->
        <div class="tab-pane fade show active" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

          <?php $id_cli = $_GET['id_atencion'];
          $_SESSION['ambiente'] = $id_cli;
          $id_usua = $_GET['id_usua']; ?>

          <form action="insertar_nota_evolucion.php?id_atencion=<?php echo $_GET['id_atencion']; ?>&id_usua=<?php echo $_GET['id_usua']; ?>" method="POST">
            <br>
            <div class="container -12">
              <div class="row col-6">
                <div class="col-sm">

                  <!--<strong>No. Admisión:</strong>-->
                  <?php $id_cli = $_GET['id_atencion']; ?>
                  <input type="hidden" name="id_atencion" class="form-control" value="<?php echo $id_cli ?>" readonly placeholder="No. De expediente">
                </div>
              </div>
            </div>

            <p><strong>TIPO DE NOTA DE EVOLUCIÓN</strong></p>
            <div class="container">
              <div class="row">
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="ingre" value="NOTA DE INGRESO HOSPITALIZACION">
                    <label class="form-check-label" for="ingre">
                      NOTA DE INGRESO HOSPITALIZACIÓN
                    </label>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="alta" value="NOTA DE ALTA DE HOSPITALIZACION">
                    <label class="form-check-label" for="alta">
                      NOTA DE ALTA DE HOSPITALIZACIÓN
                    </label>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="parto" value="NOTA POST-PARTO">
                    <label class="form-check-label" for="parto">
                      NOTA POST-PARTO
                    </label>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="neon" value="NOTA NEONATOLOGICA">
                    <label class="form-check-label" for="neon">
                      NOTA NEONATOLÓGICA
                    </label>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="valor" value="NOTA DE VALORACION CIRUGIA GENERAL">
                    <label class="form-check-label" for="valor">
                      NOTA DE VALORACIÓN CIRUGÍA GENERAL
                    </label>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="notevol" value="NOTA DE EVOLUCION">
                    <label class="form-check-label" for="notevol">
                      NOTA DE EVOLUCIÓN
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="container">
              <div class="row">
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="resumen" value="NOTA RESUMEN DE EVOLUCION Y ESTADO ACTUAL">
                    <label class="form-check-label" for="resumen">
                      NOTA RESUMEN DE EVOLUCIÓN Y ESTADO ACTUAL
                    </label>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="notpre" value="NOTA PREOPERATORIA">
                    <label class="form-check-label" for="notpre">
                      NOTA PREOPERATORIA
                    </label>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="notpost" value="NOTA POSTOPERATORIA">
                    <label class="form-check-label" for="notpost">
                      NOTA POSTOPERATORIA
                    </label>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="pretrans" value="NOTA PRE-TRANSFUSION SANGUINEA">
                    <label class="form-check-label" for="pretrans">
                      NOTA PRE-TRANSFUSIÓN SANGUÍNEA
                    </label>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="ptrans" value="NOTA POST-TRANSFUSION SANGUINEA">
                    <label class="form-check-label" for="ptrans">
                      NOTA POST-TRANSFUSIÓN SANGUÍNEA
                    </label>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="tip_ev" id="transs" value="NOTA TRANSFUSION SANGUINEA">
                    <label class="form-check-label" for="transs">
                      NOTA TRANSFUSIÓN SANGUÍNEA
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <br>

            <div class="row">
              <div class="col-1">
                <center><strong><label for="exampleFormControlTextarea1"><br>
                      <font size="5" color="#407959">P</font>
                    </label></strong></center>
              </div>
              <div class=" col-10">
                <div class="form-group">
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="problema" rows="3" placeholder="PROBLEMA EJ: DIAGNÓSTICO PRESUNCIONAL"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-1">
                <center><strong><label for="exampleFormControlTextarea1"><br>
                      <font size="5" color="#407959">S</font>
                    </label></strong></center>
              </div>
              <div class=" col-10">
                <div class="form-group">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="subjetivo" placeholder="SUBJETIVO EJ: MANIFESTACIONES DEL PACIENTE"></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-1">
                <center><strong><label for="exampleFormControlTextarea1"><br>
                      <font size="5" color="#407959">O</font>
                    </label></strong></center>
              </div>
              <div class=" col-10">
                <div class="form-group">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="objetivo" placeholder="OBJETIVO EJ: EXPLORACIÓN FÍSICA EN EL MOMENTO DE LA VISITA"></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-1">
                <center><strong><label for="exampleFormControlTextarea1"><br>
                      <font size="5" color="#407959">A</font>
                    </label></strong></center>
              </div>
              <div class=" col-10">
                <div class="form-group">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="analisis" placeholder="ANÁLISIS EJ: DIAGNÓSTICO AL QUE SE VA A LLEGAR E INTERPRETACIÓN DE ESTUDIOS DE GABINETE Y LABORATORIO"></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-1">
                <center><strong><label for="exampleFormControlTextarea1"><br>
                      <font size="5" color="#407959">P</font>
                    </label></strong></center>
              </div>
              <div class=" col-10">
                <div class="form-group">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="plan" placeholder="PLAN EJ: LO QUE SE HARA CON EL PACIENTE"></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-1">
                <center><strong><label for="exampleFormControlTextarea1"><br>
                      <font size="5" color="#407959">PX</font>
                    </label></strong></center>
              </div>
              <div class=" col-10">
                <div class="form-group">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="px" placeholder="PRONÓSTICO EJ: PRONÓSTICO PARA LA VIDA Y PARA LA FUNCIÓN"></textarea>
                </div>
              </div>
            </div>

            <div class="form-group col-12">
              <center><button type="submit" class="btn btn-primary">GUARDAR</button></center>
            </div>


            <br>
            <br>
          </form>
        </div>

        <!--TERMINO DE NOTA DE EVOLUCION-->

      </div>
    </div>

  </div>
  </div>
  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>

  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

  <script>
    document.oncontextmenu = function() {
      return false;
    }
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#mibuscador').select2();
    });
  </script>


</body>

</html>