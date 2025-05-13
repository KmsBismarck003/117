<?php
session_start();
include "../../conexionbd.php";
include("../header_medico.php");
$resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE dat_ingreso.area='EGRESO DE URGENCIAS'") or die($conexion->error);
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />

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
  <title>Menu Gestión Médica </title>
  <link rel="shortcut icon" href="logp.png">
</head>
<div class="container">
</div>

<body>

  <?php
  function calculaedad($fechanacimiento)
  {
    list($ano, $mes, $dia) = explode("-", $fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
      $ano_diferencia--;
    return $ano_diferencia;
  }

  $id_atencion = $_SESSION['hospital'];


  $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.fecha, di.area, di.alta_med, p.sexo, p.tip_san  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

  $result_pac = $conexion->query($sql_pac);

  while ($row_pac = $result_pac->fetch_assoc()) {
    $pac_nom =  $row_pac['papell'] . ' ' . $row_pac['sapell'] . ' ' . $row_pac['nom_pac'];
    $pac_fecnac = $row_pac['fecnac'];
    $pac_fecnac1 = '"' . $row_pac['fecnac'] . '"';
    $pac_fecing = $row_pac['fecha'];
    $area = $row_pac['area'];
    $alta_med = $row_pac['alta_med'];
    $exp = $row_pac['Id_exp'];
    $sexo = $row_pac['sexo'];
    $tipo_sang = $row_pac['tip_san'];
  }

  $date = date_create($pac_fecnac);
  $edad = calculaedad($pac_fecnac);

  $usuario = $_SESSION['login'];
  $usuario2 = $usuario['id_usua'];

  if ($sexo == "MUJER") {
  ?>


    <section class="content container-fluid">
      <center>
        <h3>UNIDAD DE TOCO-CIRUGÍA</h3>
      </center>
      <div class="row">
        <div class="col-sm-6">
          NO.EXPEDIENTE : <td><strong><?php echo $exp ?></strong></td><br>
          PACIENTE : <td><strong><?php echo $pac_nom ?></strong></td><br>
          SEXO : <td><strong><?php echo $sexo ?></strong></td><br>

        </div>

        <div class="col-sm-6">
          TIPO DE SANGRE : <td><strong><?php echo $tipo_sang ?></strong></td><br>
          FECHA DE NACIMIENTO : <td><strong><?php echo date_format($date, "d/m/Y"); ?></strong></td><br>
          EDAD : <td><strong><?php echo $edad ?></strong></td><br>
        </div>
      </div>
      <br>
      <div class="container box">
        <div class="content">

          <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <div class="form-group">
                    <label for="f_card">Frecuencia cardiaca en reposo:</label><br>
                    <input type="number" min="0" step="1" name="f_card" placeholder="Frecuencia cardiaca" id="f_card" class="form-control-sm" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <div class="form-group">
                    <label for="f_card_fetal">Frecuencia cardiaca Fetal:</label><br>
                    <input type="number" min="0" step="1" name="f_card_fetal" placeholder="Frecuencia cardiaca Fetal" id="f_card_fetal" class="form-control-sm" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="contracciones">Contracciones en 10/minutos: </label><br>
                  <input type="number" min="0" value="0" step="1" name="contracciones" placeholder="Contracciones en 10/minutos" id="contracciones" class="form-control-sm" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="oxitocina">MU/Oxitocina: </label><br>
                  <input type="number" min="0" step="1" value="0" name="oxitocina" placeholder="MU/Oxitocina" id="oxitocina" class="form-control-sm" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="p_sistolica">Tensión Arterial: </label>
                  <input type="number" name="p_sistolica" min="0" step="1" placeholder="mmHg" id="p_sistolica" class="form-control-sm" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" required> /
                  <label for="p_sistolica"><input type="number" name="p_diastolica" placeholder="mmHg" id="p_diastolica" min="0" step="1" class="form-control-sm" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                    <label for="p_diastolica">mmHg</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <div class="form-group">
                    <label for="pulso">Pulso:</label><br>
                    <input type="number" name="pulso" min="0" step="1" placeholder="Pulso" id="pulso" class="form-control-sm" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="temp">Temperatura: </label><br>
                  <input type="number" min="30" step="0.1" max="50" name="temp" placeholder="Temperatura" id="temp" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="dilatacion_p">Dilatación y Posición : </label><br>
                  <select class="form-control" name="dilatacion_p" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="altura_p">Altura de la Presentación: </label><br>
                  <select class="form-control" name="altura_p" required>
                    <option value="I">I</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
                    <option value="IV">IV</option>
                  </select>
                </div>
              </div>
            </div>
            <center>
              <div class="col-sm-4">
                <input type="submit" name="btntoco-cir" class="btn btn-block btn-success" value="Guardar datos">
              </div>
            </center>
          </form>
        </div>
      </div>
      <?php
      if (isset($_POST['btntoco-cir'])) {

        $f_card = mysqli_real_escape_string($conexion, (strip_tags($_POST["f_card"], ENT_QUOTES))); //Escanpando caracteres
        $f_card_fetal = mysqli_real_escape_string($conexion, (strip_tags($_POST["f_card_fetal"], ENT_QUOTES))); //Escanpando caracteres
        $contracciones = mysqli_real_escape_string($conexion, (strip_tags($_POST["contracciones"], ENT_QUOTES))); //Escanpando caracteres
        $oxitocina = mysqli_real_escape_string($conexion, (strip_tags($_POST["oxitocina"], ENT_QUOTES))); //Escanpando caracteres
        $p_sistolica = mysqli_real_escape_string($conexion, (strip_tags($_POST["p_sistolica"], ENT_QUOTES))); //Escanpando caracteres
        $p_diastolica = mysqli_real_escape_string($conexion, (strip_tags($_POST["p_diastolica"], ENT_QUOTES))); //Escanpando caracteres
        $pulso = mysqli_real_escape_string($conexion, (strip_tags($_POST["pulso"], ENT_QUOTES))); //Escanpando caracteres
        $temp = mysqli_real_escape_string($conexion, (strip_tags($_POST["temp"], ENT_QUOTES))); //Escanpando caracteres
        $dilatacion_p = mysqli_real_escape_string($conexion, (strip_tags($_POST["dilatacion_p"], ENT_QUOTES))); //Escanpando caracteres
        $altura_p = mysqli_real_escape_string($conexion, (strip_tags($_POST["altura_p"], ENT_QUOTES))); //Escanpando caracteres


$fecha_actual = date("Y-m-d H:i:s");

        $sql_toco_cir = 'INSERT INTO u_toco_cir(id_atencion, fecha, frec_car, frec_car_fet,contracciones,mu_oxitocina,p_sistolica,p_diastolica,pulso,temp,dilatacion,a_presentacion,id_usua)VALUES(' . $id_atencion . ',"' . $fecha_actual . '",' . $f_card . ',' . $f_card_fetal . ',' . $contracciones . ',' . $oxitocina . ',' . $p_sistolica . ', ' . $p_diastolica . ', ' . $pulso . ', ' . $temp . ', ' . $dilatacion_p . ',"' . $altura_p . '",' . $usuario2 . ');';
        // echo $sql_toco_cir;

        $result_toco_dir = $conexion->query($sql_toco_cir);

        echo '<script type="text/javascript"> window.location.href="nota_toco-cir.php";</script>';
      }
      ?>

      <div class="container box">
        <div class="content">
          <div class="table-responsive">
            <!--<table id="myTable" class="table table-striped table-hover">-->
            <table class="table table-bordered table-striped" id="mytable">
              <thead class="thead" style="background-color: #0c675e; color: white;">
                <tr>
                  <th>HORAS DE <br> LABOR</th>
                  <th>FECHA</th>
                  <th>F.C.R.</th>
                  <th>F.C. FETAL</th>
                  <th>CONTRACCIONES <br>
                    en 10/MIN</th>
                  <th>MU/ <br> OXITOCINA</th>
                  <th>T.A</th>
                  <th>PULSO</th>
                  <th>TEMP</th>
                  <th>DILATACIÓN</th>
                  <th>ALTURA DE <br> PRESENTACIÓN</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $resultado2 = $conexion->query("SELECT * from u_toco_cir where id_atencion = $id_atencion") or die($conexion->error);
                $no = 1;
                while ($row = $resultado2->fetch_assoc()) {
                  $date = date_create($row['fecha']);

                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . date_format($date, "d/m/Y") . '</td>'
                    . '<td>' . $row['frec_car'] . '</td>'
                    . '<td>' . $row['frec_car_fet'] . '</td>'
                    . '<td>' . $row['contracciones'] . '</td>'
                    . '<td>' . $row['mu_oxitocina'] . '</td>'
                    . '<td>' . $row['p_sistolica'] . '/' . $row['p_diastolica'] . '</td>'
                    . '<td>' . $row['pulso'] . '</td>'
                    . '<td>' . $row['temp'] . '</td>'
                    . '<td>' . $row['dilatacion'] . '</td>'
                    . '<td>' . $row['a_presentacion'] . '</td>';
                  echo '</tr>';
                  $no++;
                }
                ?>
              </tbody>
            </table>
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
  <?php
  } else {

    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "Solo de permite seleccionar mujeres", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                                window.location.href = "../../template/menu_medico.php";
                            }
                        });
                    });
                </script>';
  }
  ?>
  <script>
    document.oncontextmenu = function() {
      return false;
    }
  </script>
  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>

</html>