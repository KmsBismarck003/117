<?php
session_start();
include "../../conexionbd.php";

$usuario = $_SESSION['login'];

if ($usuario['id_rol'] == 7) {
  include "../header_farmaciah.php";
} else if ($usuario['id_rol'] == 3) {
  include "../../enfermera/header_enfermera.php";
} else if ($usuario['id_rol'] == 4 or $usuario['id_rol'] == 5) {
  include "../header_farmaciah.php";
} else {
  echo "<script>window.location='../../index.php';</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>INSUMOS SURTIDOS</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#search").keyup(function() {
        _this = this;
        $.each($("#mytable tbody tr"), function() {
          if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
          else
            $(this).show();
        });
      });
    });
  </script>
</head>

<body>
  <section class="content container-fluid">
    <div class="container box">
      <div class="content">
        <br>
        <center>
          <h1>INSUMOS SURTIDOS AL PACIENTE </h1>
        </center>

        <!-- FILTROS -->
        <div class="mb-3">
          <a href="?id_atencion=<?= $_GET['id_atencion'] ?>&fecha=<?= $_GET['fecha'] ?>&filtro=FARMACIA" class="btn btn-primary">Mostrar FARMACIA</a>
          <a href="?id_atencion=<?= $_GET['id_atencion'] ?>&fecha=<?= $_GET['fecha'] ?>&filtro=QUIROFANO" class="btn btn-danger">Mostrar QUIRÓFANO</a>
          <a href="?id_atencion=<?= $_GET['id_atencion'] ?>&fecha=<?= $_GET['fecha'] ?>&filtro=EQUIPO" class="btn btn-success">Mostrar EQUIPO</a>
          <a href="?id_atencion=<?= $_GET['id_atencion'] ?>&fecha=<?= $_GET['fecha'] ?>" class="btn btn-secondary">Mostrar TODO</a>
        </div>

        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #0c675e; color:white;">
              <tr>
                <th>SOLICITÓ</th>
                <th>FECHA SOL.</th>
                <th>SURTIÓ</th>
                <th>FECHA</th>
                <th>MÉDICAMENTO</th>
                <th>LOTE</th>
                <th>CADUCIDAD</th>
                <th>CANTIDAD</th>
                <th>SALIDA</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $id_atencion = $_GET['id_atencion'] ?? null;
              $fecha = $_GET['fecha'] ?? null;
              $filtro = $_GET['filtro'] ?? null;

              $fecha1 = date("Y-m-d 00:00:00", strtotime($fecha));
              $fecha2 = date("Y-m-d 00:00:00", strtotime($fecha . "+ 1 day"));

              $query = "SELECT * FROM dat_ingreso di 
                        JOIN paciente p ON di.Id_exp = p.Id_exp 
                        WHERE di.id_atencion = ?";
              $stmt = $conexion->prepare($query);
              $stmt->bind_param("i", $id_atencion);
              $stmt->execute();
              $resultado1 = $stmt->get_result();
              $paciente = "Paciente no encontrado";
              while ($row_pac = $resultado1->fetch_assoc()) {
                $paciente = $row_pac['nom_pac'] . " " . $row_pac['papell'] . " " . $row_pac['sapell'];
              }

              echo '<tr><h4><strong>PACIENTE: ' . htmlspecialchars($paciente) . '</strong></h4></tr>';
            
            
            if ($filtro <> 'EQUIPO') {
              $sql = "SELECT * FROM salidas_almacenh 
                      WHERE id_atencion='$id_atencion' 
                      AND (fecha_solicitud BETWEEN '$fecha1' AND '$fecha2')";

              if ($filtro == 'FARMACIA' || $filtro == 'QUIROFANO') {
                $sql .= " AND salio = '$filtro' ";
              }

              $resultado2 = $conexion->query($sql) or die($conexion->error);
              while ($row = $resultado2->fetch_assoc()) {

                $solicita = "CIRUGIA";
                $id_usuas = $row['solicita'];
                $result = $conexion->query("SELECT nombre, papell, sapell FROM reg_usuarios WHERE id_usua = $id_usuas");
                if ($usuas = $result->fetch_assoc()) {
                  $solicita = $usuas['nombre'] . ' ' . $usuas['papell'] . ' ' . $usuas['sapell'];
                }

                $surte = "CIRUGIA";
                $id_usua = $row['id_usua'];
                $result = $conexion->query("SELECT nombre, papell, sapell FROM reg_usuarios WHERE id_usua = $id_usua");
                if ($usua = $result->fetch_assoc()) {
                  $surte = $usua['nombre'] . ' ' . $usua['papell'] . ' ' . $usua['sapell'];
                }

                echo '<tr>'
                  . '<td bgcolor="red"><font color="white">' . $solicita . '</td>'
                  . '<td bgcolor="red"><font color="white">' . $row['fecha_solicitud'] . '</td>'
                  . '<td bgcolor="green"><font color="white">' . $surte . '</td>'
                  . '<td bgcolor="green"><font color="white">' . $row['salida_fecha'] . '</td>'
                  . '<td bgcolor="blue"><font color="white">' . $row['item_name'] . '</td>'
                  . '<td bgcolor="purple"><font color="white">' . $row['salida_lote'] . '</td>'
                  . '<td bgcolor="purple"><font color="white">' . $row['salida_caducidad'] . '</td>'
                  . '<td bgcolor="blue"><font color="white">' . $row['salida_qty'] . '</td>'
                  . '<td bgcolor="gray"><font color="white">' . $row['salio'] . '</td>'
                  . '</tr>';
              }}
              ?>
            </tbody>
          </table>
        </div>

        <!-- TABLA DE EQUIPO -->
        <?php if (isset($_GET['filtro']) && $_GET['filtro'] === 'EQUIPO') { ?>
          <h4 class="mt-5">Listado de EQUIPOS</h4>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead class="thead" style="background-color: #0c675e; color:white;">
                <tr>
                  <th>NO.</th>
                  <th>SURTIÓ</th>
                  <th>FECHA</th>
                  <th>EQUIPO</th>
                  <th>TIPO</th>
                  <th>CANTIDAD</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $resultado3 = $conexion->query("SELECT * FROM dat_ctapac 
                  WHERE id_atencion = $id_atencion 
                  AND prod_serv = 'S' 
                  AND insumo NOT IN (1,2,3,4,8)") or die($conexion->error);

                while ($row3 = $resultado3->fetch_assoc()) {
                  $insumo = $row3['insumo'];
                  $fecha_surtido = $row3['cta_fec'];
                  $cantidad = $row3['cta_cant'];
                  $id_usua = $row3['id_usua'];

                  $resUsuario = $conexion->query("SELECT nombre, papell, sapell FROM reg_usuarios WHERE id_usua = $id_usua");
                  $surte = "N/A";
                  if ($row_usua = $resUsuario->fetch_assoc()) {
                    $surte = $row_usua['nombre'] . ' ' . $row_usua['papell'] . ' ' . $row_usua['sapell'];
                  }

                  $resEquipo = $conexion->query("SELECT serv_desc,tipo FROM cat_servicios WHERE id_serv = $insumo and tipo = 4");
                  $descripcion = "CIRUGIA";
                  if ($row_eq = $resEquipo->fetch_assoc()) {
                    $descripcion = $row_eq['serv_desc'];
                  

                  echo "<tr>
                          <td>$no</td>
                          <td>$surte</td>
                          <td>$fecha_surtido</td>
                          <td>$descripcion</td>
                          <td>EQUIPO</td>
                          <td>$cantidad</td>
                        </tr>";
                  $no++;
                }}
                ?>
              </tbody>
            </table>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <footer class="main-footer">
    <?php include("../../template/footer.php"); ?>
  </footer>
</body>

</html>
