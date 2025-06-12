<?php
session_start();
include "../../conexionbd.php";
include "../header_medico.php";

if (!isset($_SESSION['hospital'])) {
    header("Location: ../login.php");
    exit();
}

if ($conexion) {
    $id_atencion = $_SESSION['hospital'];
    $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.folio, p.tel, p.fecnac, p.tip_san, di.fecha, di.area, di.alta_med, di.activo, p.sexo, di.alergias, p.ocup, di.id_usua
                FROM paciente p
                INNER JOIN dat_ingreso di ON p.Id_exp = di.Id_exp
                WHERE di.id_atencion = ?";
    $stmt = $conexion->prepare($sql_pac);
    $stmt->bind_param("i", $id_atencion);
    $stmt->execute();
    $result_pac = $stmt->get_result();
    while ($row_pac = $result_pac->fetch_assoc()) {
        $pac_papell = $row_pac['papell'];
        $pac_sapell = $row_pac['sapell'];
        $pac_nom_pac = $row_pac['nom_pac'];
        $pac_folio = $row_pac['folio'];
        $pac_fecha_ingreso = $row_pac['fecha'];
        $pac_fecnac = $row_pac['fecnac'];
        $activo = $row_pac['activo'];
        $pac_id_exp = $row_pac['Id_exp'];
        $pac_sexo = $row_pac['sexo'];
        $pac_tip_san = $row_pac['tip_san'];
        $pac_ocup = $row_pac['ocup'];
        $pac_tel = $row_pac['tel'];
        $pac_dir = $row_pac['dir'];
        $pac_area = $row_pac['area'];
        $pac_alta_med = $row_pac['alta_med'];
        $pac_alergias = $row_pac['alergias'];
        $pac_id_usua = $row_pac['id_usua'];
    }

    $stmt->close();
    $conexion->close();
} else {
    echo '<p style="color: red;">Error de conexión a la base de datos</p>';
}
?>
  <link rel="stylesheet" type="text/css" href="css/select2.css">
    <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFMw5uZjQz4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/select2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldLv/Pr4nhuBviF5jGqQK/5i2Q5iZ64dxBl+zOZ" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>
  <style>
    .thead {
      background-color: #2b2d7f;
      color: white;
      font-size: 22px;
      padding: 10px;
      text-align: center;
    }
    .section-title {
      margin-top: 30px;
      margin-bottom: 20px;
      font-weight: 600;
      color: #2b2d7f;
      border-bottom: 2px solid #2b2d7f;
      padding-bottom: 5px;
    }
  </style>
  <div class="container mt-5">
    <!-- Información del Paciente -->
         <div class="thead">
      Formulario de Exploración Clínica - Mediciones de la Cornea
    </div>
<div class="row mt-4">
      <div class="col-md-6">
        <p><strong>Nombre del Paciente:</strong> <?= htmlspecialchars($pac_nom_pac . ' ' . $pac_papell . ' ' . $pac_sapell) ?></p>
        <p><strong>Fecha de Nacimiento:</strong> <?= htmlspecialchars($pac_fecnac) ?></p>
        <p><strong>Sexo:</strong> <?= htmlspecialchars($pac_sexo) ?></p>
        <p><strong>Tipo de Sangre:</strong> <?= htmlspecialchars($pac_tip_san) ?></p>
        <p><strong>Ocupación:</strong> <?= htmlspecialchars($pac_ocup) ?></p>
        <p><strong>Teléfono:</strong> <?= htmlspecialchars($pac_tel) ?></p>
        <p><strong>Dirección:</strong> <?= htmlspecialchars($pac_dir) ?></p>
      </div>
      <div class="col-md-6">
        <p><strong>Fecha de Ingreso:</strong> <?= htmlspecialchars($pac_fecha_ingreso) ?></p>
        <p><strong>Área:</strong> <?= htmlspecialchars($pac_area) ?></p>
        <p><strong>Alta Médica:</strong> <?= htmlspecialchars($pac_alta_med) ?></p>
        <p><strong>Alergias:</strong> <?= htmlspecialchars($pac_alergias) ?></p>
        <p><strong>Estado del Paciente:</strong> <?= htmlspecialchars($activo) ?></p>
        <input type="hidden" name="id_exp" value="<?= htmlspecialchars($pac_id_exp) ?>">
      </div>
    </div>
    <!-- Formulario de Mediciones -->
        <div class="section-title">
            <h4 class="mb-0">Mediciones de la Córnea</h4>
        </div>
        <div class="card-body">
            <form action="guardar_mediciones_cornea.php" method="POST">
    <!-- Hidden Inputs -->
    <input type="hidden" name="id_exp" value="<?= htmlspecialchars($pac_id_exp) ?>">
    <input type="hidden" name="id_usua" value="<?= htmlspecialchars($pac_id_usua) ?>">
    <input type="hidden" name="id_atencion" value="<?= htmlspecialchars($id_atencion) ?>">

    <h5 class="text-primary">Ojo Derecho (OD)</h5>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Diámetro corneal vertical</label>
            <input type="text" name="od_dcv" class="form-control" placeholder="Ej: 11.5 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Diámetro corneal horizontal</label>
            <input type="text" name="od_dch" class="form-control" placeholder="Ej: 12.0 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Pupilar fotópico</label>
            <input type="text" name="od_dpf" class="form-control" placeholder="Ej: 3.0 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Pupilar mesópico</label>
            <input type="text" name="od_dpm" class="form-control" placeholder="Ej: 5.5 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Microscopía</label>
            <input type="text" name="od_micro" class="form-control" placeholder="Ej: Endotelio 2600 cels/mm²" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Paquimetría</label>
            <input type="text" name="od_paq" class="form-control" placeholder="Ej: 540 µm" required>
        </div>
    </div>

    <h5 class="text-success">Ojo Izquierdo (OI)</h5>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Diámetro corneal vertical</label>
            <input type="text" name="oi_dcv" class="form-control" placeholder="Ej: 11.7 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Diámetro corneal horizontal</label>
            <input type="text" name="oi_dch" class="form-control" placeholder="Ej: 12.1 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Pupilar fotópico</label>
            <input type="text" name="oi_dpf" class="form-control" placeholder="Ej: 3.2 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Pupilar mesópico</label>
            <input type="text" name="oi_dpm" class="form-control" placeholder="Ej: 5.7 mm" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Microscopía</label>
            <input type="text" name="oi_micro" class="form-control" placeholder="Ej: Endotelio 2550 cels/mm²" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Paquimetría</label>
            <input type="text" name="oi_paq" class="form-control" placeholder="Ej: 530 µm" required>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-success">Guardar Registro</button>
        <a href="../hospitalizacion/vista_pac_hosp.php" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

        </div>
    </div>
</div>


<footer class="main-footer mt-5">
    <?php include("../../template/footer.php"); ?>
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
</body>
</html>
