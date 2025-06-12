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
      Formulario de Exploración Clínica - PRESION INTRAOCULAR
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
<h4 class="section-title">Exploración PIO</h4>

<form method="POST" action="guardar_PIO.php" class="container mt-4">

    <!-- Hidden Inputs -->
    <input type="hidden" name="id_exp" value="<?= htmlspecialchars($pac_id_exp) ?>">
    <input type="hidden" name="id_usua" value="<?= htmlspecialchars($pac_id_usua) ?>">
    <input type="hidden" name="id_atencion" value="<?= htmlspecialchars($id_atencion) ?>">

    <!-- Ojo Derecho -->
    <fieldset class="border p-3 mb-4">
        <legend class="w-auto px-2">Ojo Derecho (OD)</legend>

        <div class="form-group">
            <label for="pio_aplanacion_previa_OD">PIO Aplanación Previa (mmHg)</label>
            <input type="number" step="0.1" min="0" class="form-control" name="pio_aplanacion_previa_OD" id="pio_aplanacion_previa_OD" placeholder="Ej: 14.9" required>
        </div>

        <div class="form-group">
            <label for="pio_tng_previa_OD">PIO TNG Previa (mmHg)</label>
            <input type="number" step="0.1" min="0" class="form-control" name="pio_tng_previa_OD" id="pio_tng_previa_OD" placeholder="Ej: 16.2" required>
        </div>

        <div class="form-group">
            <label for="pio_aplanacion_OD">PIO Aplanación (mmHg)</label>
            <div class="input-group">
                <input type="number" step="0.1" min="0" class="form-control" name="pio_aplanacion_OD" id="pio_aplanacion_OD" placeholder="Ej: 15.0" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <input type="checkbox" id="no_colabora_aplanacion_OD" onchange="toggleInput('no_colabora_aplanacion_OD', 'pio_aplanacion_OD')"> <label for="no_colabora_aplanacion_OD" class="ml-2 mb-0">No Colabora</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="pio_tnc_tipo_OD">Tipo PIO TNC</label>
            <select name="pio_tnc_tipo_OD" id="pio_tnc_tipo_OD" class="form-control" onchange="
                const selected = this.value;
                const input = document.getElementById('pio_tnc_OD');
                input.disabled = (selected === 'No Colabora');
                if(selected === 'No Colabora') input.value = '';
            " required>
                <option value="">Seleccione...</option>
                <option value="Normal">Normal</option>
                <option value="Elevado">Elevado</option>
                <option value="No Colabora">No Colabora</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pio_tnc_OD">PIO TNC (mmHg)</label>
            <input type="number" step="0.1" min="0" class="form-control" name="pio_tnc_OD" id="pio_tnc_OD" placeholder="Ej: 12.0" required>
        </div>

        <div class="form-group">
            <label for="tratamiento_pio_OD">Tratamiento PIO</label>
            <textarea name="tratamiento_pio_OD" id="tratamiento_pio_OD" class="form-control" rows="3" placeholder="Describa tratamiento"></textarea>
             <div class="botones">
<button type="button" class="btn btn-danger btn-sm btn-start-dictado" data-target="tratamiento_pio_OD">
        <i class="fas fa-microphone"></i>
    </button>
    <button type="button" class="btn btn-primary btn-sm btn-stop-dictado" data-target="tratamiento_pio_OD">
        <i class="fas fa-microphone-slash"></i>
    </button>
    <button type="button" class="btn btn-success btn-sm btn-play-dictado" data-target="tratamiento_pio_OD">
        <i class="fas fa-play"></i>
    </button>
    
    <small class="estado-dictado form-text text-muted">Dictado apagado</small>
        </div>

        <div class="form-group">
            <label for="correlacion_paquimetrica_OD">Correlación Paquimétrica a PIO</label>
            <textarea name="correlacion_paquimetrica_OD" id="correlacion_paquimetrica_OD" class="form-control" rows="3" placeholder="Describa correlación"></textarea>
             <div class="botones">
   <button type="button" class="btn btn-danger btn-sm btn-start-dictado" data-target="correlacion_paquimetrica_OD">
        <i class="fas fa-microphone"></i>
    </button>
    <button type="button" class="btn btn-primary btn-sm btn-stop-dictado" data-target="correlacion_paquimetrica_OD">
        <i class="fas fa-microphone-slash"></i>
    </button>
    <button type="button" class="btn btn-success btn-sm btn-play-dictado" data-target="correlacion_paquimetrica_OD">
        <i class="fas fa-play"></i>
    </button>
        </div>
    </fieldset>

    <!-- Ojo Izquierdo -->
    <fieldset class="border p-3 mb-4">
        <legend class="w-auto px-2">Ojo Izquierdo (OI)</legend>

        <div class="form-group">
            <label for="pio_aplanacion_previa_OI">PIO Aplanación Previa (mmHg)</label>
            <input type="number" step="0.1" min="0" class="form-control" name="pio_aplanacion_previa_OI" id="pio_aplanacion_previa_OI" placeholder="Ej: 14.5" required>
        </div>

        <div class="form-group">
            <label for="pio_tng_previa_OI">PIO TNG Previa (mmHg)</label>
            <input type="number" step="0.1" min="0" class="form-control" name="pio_tng_previa_OI" id="pio_tng_previa_OI" placeholder="Ej: 16.0" required>
        </div>

        <div class="form-group">
            <label for="pio_aplanacion_OI">PIO Aplanación (mmHg)</label>
            <div class="input-group">
                <input type="number" step="0.1" min="0" class="form-control" name="pio_aplanacion_OI" id="pio_aplanacion_OI" placeholder="Ej: 15.2" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <input type="checkbox" id="no_colabora_aplanacion_OI" onchange="toggleInput('no_colabora_aplanacion_OI', 'pio_aplanacion_OI')"> <label for="no_colabora_aplanacion_OI" class="ml-2 mb-0">No Colabora</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="pio_tnc_tipo_OI">Tipo PIO TNC</label>
            <select name="pio_tnc_tipo_OI" id="pio_tnc_tipo_OI" class="form-control" onchange="
                const selected = this.value;
                const input = document.getElementById('pio_tnc_OI');
                input.disabled = (selected === 'No Colabora');
                if(selected === 'No Colabora') input.value = '';
            " required>
                <option value="">Seleccione...</option>
                <option value="Normal">Normal</option>
                <option value="Elevado">Elevado</option>
                <option value="No Colabora">No Colabora</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pio_tnc_OI">PIO TNC (mmHg)</label>
            <input type="number" step="0.1" min="0" class="form-control" name="pio_tnc_OI" id="pio_tnc_OI" placeholder="Ej: 13.5" required>
        </div>

<div class="form-group">
    <label for="tratamiento_pio_OI">Tratamiento PIO</label>
    <textarea name="tratamiento_pio_OI" id="tratamiento_pio_OI" class="form-control" rows="3" placeholder="Describa tratamiento"></textarea>
    
    <button type="button" class="btn btn-danger btn-sm btn-start-dictado" data-target="tratamiento_pio_OI">
        <i class="fas fa-microphone"></i>
    </button>
    <button type="button" class="btn btn-primary btn-sm btn-stop-dictado" data-target="tratamiento_pio_OI">
        <i class="fas fa-microphone-slash"></i>
    </button>
    <button type="button" class="btn btn-success btn-sm btn-play-dictado" data-target="tratamiento_pio_OI">
        <i class="fas fa-play"></i>
    </button>
    
    <small class="estado-dictado form-text text-muted">Dictado apagado</small>
</div>

<div class="form-group">
    <label for="correlacion_paquimetrica_OI">Correlación Paquimétrica a PIO</label>
    <textarea name="correlacion_paquimetrica_OI" id="correlacion_paquimetrica_OI" class="form-control" rows="3" placeholder="Describa correlación"></textarea>
    
    <button type="button" class="btn btn-danger btn-sm btn-start-dictado" data-target="correlacion_paquimetrica_OI">
        <i class="fas fa-microphone"></i>
    </button>
    <button type="button" class="btn btn-primary btn-sm btn-stop-dictado" data-target="correlacion_paquimetrica_OI">
        <i class="fas fa-microphone-slash"></i>
    </button>
    <button type="button" class="btn btn-success btn-sm btn-play-dictado" data-target="correlacion_paquimetrica_OI">
        <i class="fas fa-play"></i>
    </button>
    
    <small class="estado-dictado form-text text-muted">Dictado apagado</small>
</div>

    </fieldset>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">FIRMAR</button>
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
        document.querySelectorAll('.estado-dictado').forEach(el => {
            el.textContent = '❌ Dictado por voz no compatible';
        });
        return;
    }

    let recognition = null;
    let currentTarget = null;
    let currentEstado = null;

    function iniciarDictado(textarea, estadoElement) {
        if (recognition) recognition.abort(); // Detener si ya hay uno activo

        recognition = new SpeechRecognition();
        recognition.lang = 'es-ES';
        recognition.interimResults = true;
        recognition.continuous = true;

        currentTarget = textarea;
        currentEstado = estadoElement;

        recognition.onstart = () => currentEstado.textContent = '🎙️ Dictado en curso...';
        recognition.onend = () => currentEstado.textContent = '⏹️ Dictado detenido';
        recognition.onerror = (e) => currentEstado.textContent = `❌ Error: ${e.error}`;

        recognition.onresult = function (event) {
            let transcript = '';
            for (let i = event.resultIndex; i < event.results.length; ++i) {
                transcript += event.results[i][0].transcript;
            }
            currentTarget.value += transcript;
        };

        recognition.start();
    }

    function detenerDictado() {
        if (recognition) recognition.stop();
    }

    document.querySelectorAll('.btn-start-dictado').forEach(btn => {
        btn.addEventListener('click', () => {
            const textarea = document.getElementById(btn.dataset.target);
            const estado = btn.closest('.form-group').querySelector('.estado-dictado');
            iniciarDictado(textarea, estado);
        });
    });

    document.querySelectorAll('.btn-stop-dictado').forEach(btn => {
        btn.addEventListener('click', () => {
            detenerDictado();
            const estado = btn.closest('.form-group').querySelector('.estado-dictado');
            estado.textContent = '⏹️ Dictado detenido';
        });
    });

    document.querySelectorAll('.btn-play-dictado').forEach(btn => {
        btn.addEventListener('click', () => {
            const textarea = document.getElementById(btn.dataset.target);
            const texto = textarea.value.trim();
            if (!texto) return;

            if (recognition) recognition.abort(); // Detener dictado si está en curso

            const utterance = new SpeechSynthesisUtterance(texto);
            utterance.lang = 'es-MX';
            speechSynthesis.speak(utterance);
        });
    });
});
</script>
