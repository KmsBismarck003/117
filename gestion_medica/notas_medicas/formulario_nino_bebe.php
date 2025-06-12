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
</head>
<body>
  <div class="container mt-3">
    <!-- Encabezado con clase .thead -->
    <div class="thead">
      Formulario de Exploración Clínica - Niño/Bebé
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

    <h4 class="section-title">Exploración NIÑO/BEBÉ</h4>

    <form action="guardar_ninoBebe.php" method="POST">
  <!-- Hidden Inputs -->
  <input type="hidden" name="id_exp" value="<?= htmlspecialchars($pac_id_exp) ?>">
  <input type="hidden" name="id_usua" value="<?= htmlspecialchars($pac_id_usua) ?>">
  <input type="hidden" name="id_atencion" value="<?= htmlspecialchars($id_atencion) ?>">

  <div class="row">
    <!-- Ojo Derecho -->
    <div class="col-md-6">
      <h5>Ojo Derecho (OD)</h5>

      <!-- Reflejo Fotomotor OD -->
      <div class="form-group">
        <label for="reflejo_od">Reflejo Fotomotor</label>
        <div class="input-group">
          <input type="text" class="form-control" id="reflejo_od" name="reflejo_od" placeholder="Ej: Presente, Ausente">
          <div class="input-group-append">
            <button type="button" class="btn btn-danger btn-sm btn-start-dictado" data-target="reflejo_od"><i class="fas fa-microphone"></i></button>
            <button type="button" class="btn btn-primary btn-sm btn-stop-dictado" data-target="reflejo_od"><i class="fas fa-microphone-slash"></i></button>
            <button type="button" class="btn btn-success btn-sm btn-play-dictado" data-target="reflejo_od"><i class="fas fa-play"></i></button>
          </div>
        </div>
        <small class="estado-dictado form-text text-muted" id="estado-reflejo_od">Dictado apagado</small>
      </div>

      <div class="form-group">
        <label for="eje_visual_od">Eje Visual</label>
        <input type="text" class="form-control" id="eje_visual_od" name="eje_visual_od" placeholder="Ej: 0°, 15° exo">
      </div>

      <div class="form-group">
        <label for="fijacion_od">Fijación</label>
        <select class="form-control" id="fijacion_od" name="fijacion_od">
          <option value="">Seleccione una opción</option>
          <option value="Central">Central</option>
          <option value="Excéntrica">Excéntrica</option>
          <option value="Inestable">Inestable</option>
          <option value="Ausente">Ausente</option>
        </select>
      </div>

      <div class="form-group">
        <label for="esquiascopia_od">Esquiascopia</label>
        <input type="text" class="form-control" id="esquiascopia_od" name="esquiascopia_od" placeholder="Ej: +1.00 -0.50 x 180">
      </div>

      <!-- Posición Compensadora OD -->
      <div class="form-group">
        <label for="posicion_od">Posición Compensadora</label>
        <div class="input-group">
          <input type="text" class="form-control" id="posicion_od" name="posicion_od" placeholder="Ej: Inclinación de cabeza a la derecha">
          <div class="input-group-append">
            <button type="button" class="btn btn-danger btn-sm btn-start-dictado" data-target="posicion_od"><i class="fas fa-microphone"></i></button>
            <button type="button" class="btn btn-primary btn-sm btn-stop-dictado" data-target="posicion_od"><i class="fas fa-microphone-slash"></i></button>
            <button type="button" class="btn btn-success btn-sm btn-play-dictado" data-target="posicion_od"><i class="fas fa-play"></i></button>
          </div>
        </div>
        <small class="estado-dictado form-text text-muted" id="estado-posicion_od">Dictado apagado</small>
      </div>
    </div>

    <!-- Ojo Izquierdo -->
    <div class="col-md-6">
      <h5>Ojo Izquierdo (OI)</h5>

      <!-- Reflejo Fotomotor OI -->
      <div class="form-group">
        <label for="reflejo_oi">Reflejo Fotomotor</label>
        <div class="input-group">
          <input type="text" class="form-control" id="reflejo_oi" name="reflejo_oi" placeholder="Ej: Presente, Ausente">
          <div class="input-group-append">
            <button type="button" class="btn btn-danger btn-sm btn-start-dictado" data-target="reflejo_oi"><i class="fas fa-microphone"></i></button>
            <button type="button" class="btn btn-primary btn-sm btn-stop-dictado" data-target="reflejo_oi"><i class="fas fa-microphone-slash"></i></button>
            <button type="button" class="btn btn-success btn-sm btn-play-dictado" data-target="reflejo_oi"><i class="fas fa-play"></i></button>
          </div>
        </div>
        <small class="estado-dictado form-text text-muted" id="estado-reflejo_oi">Dictado apagado</small>
      </div>

      <div class="form-group">
        <label for="eje_visual_oi">Eje Visual</label>
        <input type="text" class="form-control" id="eje_visual_oi" name="eje_visual_oi" placeholder="Ej: 0°, 10° eso">
      </div>

      <div class="form-group">
        <label for="fijacion_oi">Fijación</label>
        <select class="form-control" id="fijacion_oi" name="fijacion_oi">
          <option value="">Seleccione una opción</option>
          <option value="Central">Central</option>
          <option value="Excéntrica">Excéntrica</option>
          <option value="Inestable">Inestable</option>
          <option value="Ausente">Ausente</option>
        </select>
      </div>

      <div class="form-group">
        <label for="esquiascopia_oi">Esquiascopia</label>
        <input type="text" class="form-control" id="esquiascopia_oi" name="esquiascopia_oi" placeholder="Ej: +0.50 -1.00 x 90">
      </div>

      <!-- Posición Compensadora OI -->
      <div class="form-group">
        <label for="posicion_oi">Posición Compensadora</label>
        <div class="input-group">
          <input type="text" class="form-control" id="posicion_oi" name="posicion_oi" placeholder="Ej: Cabeza inclinada hacia izquierda">
          <div class="input-group-append">
            <button type="button" class="btn btn-danger btn-sm btn-start-dictado" data-target="posicion_oi"><i class="fas fa-microphone"></i></button>
            <button type="button" class="btn btn-primary btn-sm btn-stop-dictado" data-target="posicion_oi"><i class="fas fa-microphone-slash"></i></button>
            <button type="button" class="btn btn-success btn-sm btn-play-dictado" data-target="posicion_oi"><i class="fas fa-play"></i></button>
          </div>
        </div>
        <small class="estado-dictado form-text text-muted" id="estado-posicion_oi">Dictado apagado</small>
      </div>
    </div>
  </div>

  <div class="mt-4">
    <button type="submit" class="btn btn-primary">Firmar Exploración</button>
    <a href="../hospitalizacion/vista_pac_hosp.php" class="btn btn-secondary">Cancelar</a>
  </div>
</form>

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
    <script>
  const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
  recognition.lang = 'es-ES';
  recognition.continuous = false;
  recognition.interimResults = false;

  let currentTargetInput = null;

  document.querySelectorAll('.btn-start-dictado').forEach(btn => {
    btn.addEventListener('click', () => {
      const inputId = btn.getAttribute('data-target');
      currentTargetInput = document.getElementById(inputId);
      const estado = document.getElementById('estado-' + inputId);
      recognition.start();
      estado.textContent = 'Escuchando...';
    });
  });

  document.querySelectorAll('.btn-stop-dictado').forEach(btn => {
    btn.addEventListener('click', () => {
      recognition.stop();
      const inputId = btn.getAttribute('data-target');
      const estado = document.getElementById('estado-' + inputId);
      estado.textContent = 'Dictado detenido';
    });
  });

  document.querySelectorAll('.btn-play-dictado').forEach(btn => {
    btn.addEventListener('click', () => {
      const inputId = btn.getAttribute('data-target');
      const texto = document.getElementById(inputId).value;
      const estado = document.getElementById('estado-' + inputId);
      if (texto.trim() !== '') {
        const speech = new SpeechSynthesisUtterance(texto);
        speech.lang = 'es-ES';
        window.speechSynthesis.speak(speech);
        estado.textContent = 'Reproduciendo dictado';
      }
    });
  });

  recognition.onresult = function(event) {
    const result = event.results[0][0].transcript;
    if (currentTargetInput) {
      currentTargetInput.value = result;
      document.getElementById('estado-' + currentTargetInput.id).textContent = 'Texto insertado por dictado';
    }
  };

  recognition.onerror = function(event) {
    if (currentTargetInput) {
      document.getElementById('estado-' + currentTargetInput.id).textContent = 'Error en el dictado: ' + event.error;
    }
  };
</script>

</body>
</html>
