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
      Formulario de Exploración Clínica - Segmento Anterior 
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
    <h4 class="section-title">Exploración Segmento Anterior</h4>
    <form action="guardar_seg_ant.php" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
        <!-- Hidden Inputs -->
    <input type="hidden" name="id_exp" value="<?= htmlspecialchars($pac_id_exp) ?>">
    <input type="hidden" name="id_usua" value="<?= htmlspecialchars($pac_id_usua) ?>">
    <input type="hidden" name="id_atencion" value="<?= htmlspecialchars($id_atencion) ?>">

  <h4 class="mb-4">Exploración Clínica - Segmento Anterior (OD / OI)</h4>

  <?php
    $campos = [
      "parpados" => "Párpados",
      "conj_tarsal" => "Conjuntiva Tarsal",
      "conj_bulbar" => "Conjuntiva Bulbar",
      "cornea" => "Córnea",
      "camara_anterior" => "Cámara Anterior",
      "iris" => "Iris",
      "pupila" => "Pupila",
      "cristalino" => "Cristalino",
      "gonioscopia" => "Gonioscopía"
    ];

    $placeholders = [
      "parpados" => "SIN ALTERACIONES",
      "conj_tarsal" => "SIN ALTERACIONES",
      "conj_bulbar" => "NORMOCROMICA",
      "cornea" => "Transparente",
      "camara_anterior" => "FORMADA SIN CELULARIDAD O FLARE",
      "iris" => "SIN ALTERACIONES",
      "pupila" => "ISOCÓRICA, NORMOREFLÉCTICA",
      "cristalino" => "SIN OPACIDADES",
      "gonioscopia" => "ÁNGULO ABIERTO"
    ];

foreach ($campos as $campo => $label) {
  echo "
  <div class='row mb-3'>
    <div class='col'>
      <label for='{$campo}_od' class='form-label'>{$label} OD</label>
      <input type='text' name='{$campo}_od' id='{$campo}_od' class='form-control' placeholder='{$placeholders[$campo]}'>
      <div class='mt-2'>
        <button type='button' class='btn btn-danger btn-sm' id='startDictado_{$campo}_od'>
          <i class='fas fa-microphone'></i>
        </button>
        <button type='button' class='btn btn-primary btn-sm' id='stopDictado_{$campo}_od'>
          <i class='fas fa-microphone-slash'></i>
        </button>
        <button type='button' class='btn btn-success btn-sm' id='playDictado_{$campo}_od'>
          <i class='fas fa-play'></i>
        </button>
        <small id='estadoDictado_{$campo}_od' class='form-text text-muted'>Dictado apagado</small>
      </div>
    </div>

    <div class='col'>
      <label for='{$campo}_oi' class='form-label'>{$label} OI</label>
      <input type='text' name='{$campo}_oi' id='{$campo}_oi' class='form-control' placeholder='{$placeholders[$campo]}'>
      <div class='mt-2'>
        <button type='button' class='btn btn-danger btn-sm' id='startDictado_{$campo}_oi'>
          <i class='fas fa-microphone'></i>
        </button>
        <button type='button' class='btn btn-primary btn-sm' id='stopDictado_{$campo}_oi'>
          <i class='fas fa-microphone-slash'></i>
        </button>
        <button type='button' class='btn btn-success btn-sm' id='playDictado_{$campo}_oi'>
          <i class='fas fa-play'></i>
        </button>
        <small id='estadoDictado_{$campo}_oi' class='form-text text-muted'>Dictado apagado</small>
      </div>
    </div>
  </div>
  ";
}
  ?>

  <!-- LOCS III para ambos ojos -->
  <h5 class="mt-4">LOCS III - Cristalino</h5>
  <?php
    $locs = ["no" => "NO", "nc" => "NC", "c" => "C", "p" => "P"];
    foreach ($locs as $key => $label) {
      echo "<div class='row mb-3'>
              <div class='col'>
                <label for='locs_{$key}_od' class='form-label'>{$label} OD</label>
                <select name='locs_{$key}_od' id='locs_{$key}_od' class='form-select'>
                  <option value=''>Seleccione</option>";
      for ($i = 1; $i <= 5; $i++) echo "<option value='$i'>$i</option>";
      echo    "</select>
              </div>
              <div class='col'>
                <label for='locs_{$key}_oi' class='form-label'>{$label} OI</label>
                <select name='locs_{$key}_oi' id='locs_{$key}_oi' class='form-select'>
                  <option value=''>Seleccione</option>";
      for ($i = 1; $i <= 5; $i++) echo "<option value='$i'>$i</option>";
      echo    "</select>
              </div>
            </div>";
    }
  ?>

<div class="row mb-3">
  <div class="col">
    <label for="dibujo_od" class="form-label">Dibujo OD</label>
    <input type="file" name="dibujo_od" id="dibujo_od" class="form-control">
  </div>
  <div class="col">
    <label for="dibujo_oi" class="form-label">Dibujo OI</label>
    <input type="file" name="dibujo_oi" id="dibujo_oi" class="form-control">
  </div>
</div>

<div class="mb-3">
    <label for="observaciones" class="form-label">Observaciones</label>
    <textarea name="observaciones" id="observaciones" rows="3" class="form-control" placeholder="Observaciones..."></textarea>
    <button type="button" class="btn btn-danger btn-sm" id="startDictado">
        <i class="fas fa-microphone"></i>
    </button>
    <button type="button" class="btn btn-primary btn-sm" id="stopDictado">
        <i class="fas fa-microphone-slash"></i>
    </button>
    <button type="button" class="btn btn-success btn-sm" id="playDictado">
        <i class="fas fa-play"></i>
    </button>
    <small id="estadoDictado" class="form-text text-muted">Dictado apagado</small>
</div>

  <div class="d-flex justify-content-between">
    <button type="reset" class="btn btn-secondary">Borrar</button>
    <button type="submit" class="btn btn-primary">Guardar</button>
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
function toggleInput(checkboxId, inputId) {
    const checkbox = document.getElementById(checkboxId);
    const input = document.getElementById(inputId);
    if (checkbox.checked) {
        input.value = '';
        input.disabled = true;
    } else {
        input.disabled = false;
    }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!SpeechRecognition) {
        document.querySelectorAll('[id^="estadoDictado_"]').forEach(el => {
            el.textContent = '❌ Dictado por voz no compatible con este navegador.';
        });
        document.querySelectorAll('[id^="startDictado_"], [id^="stopDictado_"], [id^="play_med_"]').forEach(btn => btn.disabled = true);
        return;
    }

    const recognition = new SpeechRecognition();
    recognition.lang = 'es-MX';
    recognition.interimResults = true;
    recognition.continuous = true;

    let currentInput = null;
    let currentEstado = null;

    recognition.onresult = function (event) {
        let transcript = '';
        for (let i = event.resultIndex; i < event.results.length; ++i) {
            transcript += event.results[i][0].transcript;
        }
        if (currentInput) {
            currentInput.value += transcript;
        }
    };

    recognition.onstart = () => {
        if (currentEstado) currentEstado.textContent = '🎙️ Dictado en curso...';
    };
    recognition.onend = () => {
        if (currentEstado) currentEstado.textContent = '⏹️ Dictado detenido';
    };
    recognition.onerror = (e) => {
        if (currentEstado) currentEstado.textContent = `❌ Error: ${e.error}`;
    };

    // Start dictation buttons
    document.querySelectorAll('[id^="startDictado_"]').forEach(btn => {
        btn.addEventListener('click', () => {
            const idBase = btn.id.replace('startDictado_', '');
            currentInput = document.getElementById(idBase);
            currentEstado = document.getElementById('estadoDictado_' + idBase);
            recognition.start();
        });
    });

    // Stop dictation buttons
    document.querySelectorAll('[id^="stopDictado_"]').forEach(btn => {
        btn.addEventListener('click', () => {
            recognition.stop();
        });
    });

    // Play buttons - lectura en voz alta
    document.querySelectorAll('[id^="playDictado_"]').forEach(btn => {
        btn.addEventListener('click', () => {
            const idBase = btn.id.replace('playDictado_', '');
            const input = document.getElementById(idBase);
            if (!input) return;

            const texto = input.value.trim();
            if (!texto) return;

            const utterance = new SpeechSynthesisUtterance(texto);
            utterance.lang = 'es-MX';
            speechSynthesis.speak(utterance);
        });
    });
});
</script>
<!-- observaciones  -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const observaciones = document.getElementById('observaciones');
    const startBtn = document.getElementById('startDictado');
    const stopBtn = document.getElementById('stopDictado');
    const playBtn = document.getElementById('playDictado');
    const estado = document.getElementById('estadoDictado');

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!SpeechRecognition) {
        estado.textContent = '❌ El dictado por voz no es compatible con este navegador.';
        startBtn.disabled = true;
        stopBtn.disabled = true;
        playBtn.disabled = true;
        return;
    }

    const recognition = new SpeechRecognition();
    recognition.lang = 'es-MX'; // Ajustable según tu región
    recognition.interimResults = true;
    recognition.continuous = true;

    recognition.onstart = () => estado.textContent = '🎙️ Dictado en curso...';
    recognition.onend = () => estado.textContent = '⏹️ Dictado detenido';
    recognition.onerror = (e) => estado.textContent = `❌ Error: ${e.error}`;

    recognition.onresult = function (event) {
        let transcript = '';
        for (let i = event.resultIndex; i < event.results.length; ++i) {
            transcript += event.results[i][0].transcript;
        }
        observaciones.value += transcript;
    };

    startBtn.addEventListener('click', () => {
        recognition.start();
    });

    stopBtn.addEventListener('click', () => {
        recognition.stop();
    });

    playBtn.addEventListener('click', () => {
        const texto = observaciones.value.trim();
        if (!texto) return;

        // Detener el reconocimiento si está activo
        recognition.abort();

        const utterance = new SpeechSynthesisUtterance(texto);
        utterance.lang = 'es-MX';
        speechSynthesis.speak(utterance);
    });
});
</script>