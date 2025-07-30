<?php
session_start();
include "../../conexionbd.php";

// Consulta inicial para llenar la tabla
$resultado = $conexion->query("SELECT paciente.*, dat_ingreso.id_atencion, triage.id_triage
FROM paciente 
INNER JOIN dat_ingreso ON paciente.Id_exp = dat_ingreso.Id_exp
INNER JOIN triage ON dat_ingreso.id_atencion = triage.id_atencion") or die($conexion->error);

$usuario = $_SESSION['login'];

// Determinar el header según el rol del usuario
if ($usuario['id_rol'] == 7) {
  include "../header_farmaciaq.php";
} else if ($usuario['id_rol'] == 3) {
  include "../../enfermera/header_enfermera.php";
} else if ($usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
  include "../header_farmaciaq.php";
} else {
  echo "<script>window.location='../../index.php';</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
  <section class="content container-fluid">
    <div class="container box">
      <div class="content">
        <br>
        <center>
          <h1>SALIDAS POR MEDICAMENTO (QUIROFANO)</h1>
        </center>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #0c675e; color:white;">
              <tr>
                <th>FECHA</th>
                <th>MEDICAMENTO</th>
                <th>LOTE</th>
                <th>CADUCIDAD</th>
                <th>PACIENTE</th>
              </tr>
            </thead>
            <tbody>
              <div class="container">
                <form method="POST" id="medicamentos">
                  <div class="row">
                    <div class="col-sm-2">
                      <label>Fecha Inicial:</label>
                      <input type="date" class="form-control" name="inicial" required>
                    </div>
                    <div class="col-sm-2">
                      <label>Fecha Final:</label>
                      <input type="date" class="form-control" name="final" required>
                    </div>
                    <div class="col-sm-4">
                      <br>
                      <button type="submit" class="btn btn-success">SELECCIONAR</button>
                    </div>
                  </div>
                </form>
                <br>
              </div>
              <?php
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtener las fechas del formulario
                $inicial = mysqli_real_escape_string($conexion, strip_tags($_POST["inicial"], ENT_QUOTES));
                $final = mysqli_real_escape_string($conexion, strip_tags($_POST["final"], ENT_QUOTES));

                // Ajustar la fecha final para incluir el último día completo
                $final = date("Y-m-d", strtotime($final . "+ 1 day"));

                // Consulta para obtener las salidas por rango de fechas
                $resultado2 = $conexion->query("SELECT s.*, di.id_atencion, di.Id_exp, p.*
                  FROM salidas_almacenq s
                  INNER JOIN dat_ingreso di ON s.id_atencion = di.id_atencion
                  INNER JOIN paciente p ON di.Id_exp = p.Id_exp
                  WHERE salida_fecha BETWEEN '$inicial' AND '$final'
                ") or die($conexion->error);


                // Mostrar los resultados en la tabla
                while ($row = $resultado2->fetch_assoc()) {
                  $paciente = $row['nom_pac'] . " " . $row['papell'] . " " . $row['sapell'];
                  $fecha = date_create($row['date_sold']);
                  echo '<tr>'
                    . '<td>' . date_format($fecha, 'd/m/Y H:i') . '</td>'
                    . '<td>' . $row['generic_name'] . '</td>'
                    . '<td>' . $row['existe_lote'] . '</td>'
                    . '<td>' . $row['existe_caducidad'] . '</td>'
                    . '<td>' . $paciente . '</td>'
                    . '</tr>';
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <footer class="main-footer">
    <?php include("../../template/footer.php"); ?>
  </footer>
</body>

</html>ñ