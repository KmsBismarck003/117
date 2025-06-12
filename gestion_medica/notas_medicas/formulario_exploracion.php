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
      Formulario de Exploración Clínica - Párpados, Órbita y Vías Lagrimales
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
        <!-- Formulario de exploración -->

        <h4 class="section-title">Nueva Exploración: Párpados, Órbita y Vías Lagrimales</h4>
    <div class="card-body">
        <form action="procesar_formulario.php" method="POST">
                <!-- Hidden Inputs -->
    <input type="hidden" name="id_exp" value="<?= htmlspecialchars($pac_id_exp) ?>">
    <input type="hidden" name="id_usua" value="<?= htmlspecialchars($pac_id_usua) ?>">
    <input type="hidden" name="id_atencion" value="<?= htmlspecialchars($id_atencion) ?>">
 <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Distancia Margen Reflejo 1 (mm)</label>
                    <input type="number" step="0.01" name="distancia_margen_reflejo_1" class="form-control" placeholder="mm">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Distancia Margen Reflejo 2 (mm)</label>
                    <input type="number" step="0.01" name="distancia_margen_reflejo_2" class="form-control" placeholder="mm">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Altura del Surco (mm)</label>
                    <input type="number" step="0.01" name="altura_surco" class="form-control" placeholder="mm">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Exposición Escleral Superior (mm)</label>
                    <input type="number" step="0.01" name="exposicion_escleral_superior" class="form-control" placeholder="mm">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Exposición Escleral Inferior (mm)</label>
                    <input type="number" step="0.01" name="exposicion_escleral_inferior" class="form-control" placeholder="mm">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Distancia Ceja-Pestaña (mm)</label>
                    <input type="number" step="0.01" name="distancia_ceja_pestana" class="form-control" placeholder="mm">
                </div>
            </div>

            <!-- Ojo Derecho -->
            <h5>Ojo Derecho</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Apertura Palpebral (mm)</label>
                    <input type="number" step="0.01" name="apertura_palpebral" class="form-control" placeholder="mm">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Hendidura Palpebral (mm)</label>
                    <input type="number" step="0.01" name="hendidura_palpebral" class="form-control" placeholder="mm">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Función del Músculo Elevador (mm)</label>
                    <input type="number" step="0.01" name="funcion_musculo_elevador" class="form-control" placeholder="mm">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Fenómeno de Bell</label>
                    <select name="fenomeno_bell" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Normal">Normal</option>
                        <option value="Patológico">Patológico</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Función del Músculo Elevador</label>
                    <input type="number" step="0.01" name="exoftalmometria" class="form-control" placeholder="mm">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Laxitud Horizontal</label>
                    <select name="laxitud_horizontal" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Normal">Normal</option>
                        <option value="Leve">Leve</option>
                        <option value="Moderada">Moderada</option>
                        <option value="Severa">Severa</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Laxitud Vertical</label>
                    <select name="laxitud_vertical" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Normal">Normal</option>
                        <option value="Leve">Leve</option>
                        <option value="Moderada">Moderada</option>
                        <option value="Severa">Severa</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Desplazamiento Ocular</label>
                    <select name="desplazamiento_ocular" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Enoftalmos">Enoftalmos</option>
                        <option value="Exoftalmos">Exoftalmos</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Maniobra de Valsalva</label>
                    <select name="maniobra_vatsaha" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>

            <!-- Ojo Izquierdo -->
            <h5 class="mt-4">Ojo Izquierdo</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Apertura Palpebral (mm)</label>
                    <input type="number" step="0.01" name="apertura_palpebral_oi" class="form-control" placeholder="mm">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Hendidura Palpebral (mm)</label>
                    <input type="number" step="0.01" name="hendidura_palpebral_oi" class="form-control" placeholder="mm">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Función del Músculo Elevador (mm)</label>
                    <input type="number" step="0.01" name="funcion_musculo_elevador_oi" class="form-control" placeholder="mm">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Fenómeno de Bell</label>
                    <select name="fenomeno_bell_oi" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Normal">Normal</option>
                        <option value="Patológico">Patológico</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Desplazamiento Ocular</label>
                    <select name="desplazamiento_ocular_oi" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Enoftalmos">Enoftalmos</option>
                        <option value="Exoftalmos">Exoftalmos</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Laxitud Horizontal</label>
                    <select name="laxitud_horizontal_oi" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Normal">Normal</option>
                        <option value="Leve">Leve</option>
                        <option value="Moderada">Moderada</option>
                        <option value="Severa">Severa</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Laxitud Vertical</label>
                    <select name="laxitud_vertical_oi" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Normal">Normal</option>
                        <option value="Leve">Leve</option>
                        <option value="Moderada">Moderada</option>
                        <option value="Severa">Severa</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Maniobra de Valsalva</label>
                    <select name="maniobra_vatsaha_oi" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>

            <!-- Observaciones -->
<div class="mb-3">
    <label for="observaciones" class="form-label">Observaciones</label>
    <textarea class="form-control" name="observaciones" id="observaciones" rows="4" placeholder="Detalles adicionales del examen..."></textarea>
    <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="startDictado"><i 
        class="fas fa-microphone"></i></button>
        <button type="button" class="btn btn-primary btn-sm" id="stopDictado"><i
        class="fas fa-microphone-slash"></i></button>
        <button type="button" class="btn btn-success btn-sm" id="play_med_izquierdo"><i
        class="fas fa-play"></i></button>
    <small id="estadoDictado" class="form-text text-muted">Dictado apagado</small>
</div>

            <!-- Botones -->
            <button type="submit" class="btn btn-success">FIRMAR</button>
            <a href="../hospitalizacion/vista_pac_hosp.php" class="btn btn-danger">Cancelar</a>
        </form>
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
document.addEventListener('DOMContentLoaded', function () {
    const observaciones = document.getElementById('observaciones');
    const startBtn = document.getElementById('startDictado');
    const stopBtn = document.getElementById('stopDictado');
    const estado = document.getElementById('estadoDictado');

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    
    if (!SpeechRecognition) {
        estado.textContent = 'El dictado por voz no es compatible con este navegador.';
        startBtn.disabled = true;
        stopBtn.disabled = true;
        return;
    }

    const recognition = new SpeechRecognition();
    recognition.lang = 'es-MX'; // Puedes cambiarlo a 'es-ES' o según tu preferencia
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
        observaciones.value = observaciones.value + transcript;
    };

    startBtn.addEventListener('click', () => {
        recognition.start();
    });

    stopBtn.addEventListener('click', () => {
        recognition.stop();
    });
});
</script>
</body>
</html>
