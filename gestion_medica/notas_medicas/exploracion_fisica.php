<?php
session_start();
include "../../conexionbd.php";
include("../header_medico.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>Exámenes de Laboratorio y Gabinete - Instituto de Enfermedades Oculares</title>
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

    <script>
        $($document).ready(function() {
            $("#search").keyup(function() {
                var valor = $(this).val().toLowerCase();
                $("#mytable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
                });
            });
        });
    </script>
    <style>
        .modal-lg {
            max-width: 70% !important;
        }

        .botones {
            margin-bottom: 5px;
        }

        .thead {
            background-color: #2b2d7f;
            color: white;
            font-size: 22px;
            padding: 10px;
            text-align: center;
        }

        .accordion .card {
            border: none;
        }

        .accordion .card-header {
            background-color: #e9ecef;
            cursor: pointer;
        }
    </style>
</head>

<body>

   <div class="container">
    <div class="thead">
        <strong><center>EXPLORACIÓN FÍSICA </center></strong>
    </div>

    <form action="insertar_refraccion.php" method="POST" onsubmit="return checkSubmit();">

        <!-- EXPLORACIÓN FÍSICA -->
<div class="form-row mt-2">
    <div class="form-group col-md-3">
        <label><strong>Peso (kg)</strong></label>
        <input type="number" step="0.01" class="form-control" name="peso" required>
    </div>
    <div class="form-group col-md-3">
        <label><strong>Talla (cm)</strong></label>
        <input type="number" step="0.01" class="form-control" name="talla" required>
    </div>
    <div class="form-group col-md-3">
        <label><strong>IMC</strong></label>
        <input type="number" step="0.01" class="form-control" name="imc">
    </div>
    <div class="form-group col-md-3">
        <label><strong>Circunferencia de Cintura (cm)</strong></label>
        <input type="number" step="0.01" class="form-control" name="cintura">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-3">
        <label><strong>Presión Sistólica (mm Hg)</strong></label>
        <input type="number" class="form-control" name="presion_sistolica">
    </div>
    <div class="form-group col-md-3">
        <label><strong>Presión Diastólica (mm Hg)</strong></label>
        <input type="number" class="form-control" name="presion_diastolica">
    </div>
    <div class="form-group col-md-3">
        <label><strong>Frecuencia Cardiaca (x')</strong></label>
        <input type="number" class="form-control" name="frecuencia_cardiaca">
    </div>
    <div class="form-group col-md-3">
        <label><strong>Frecuencia Respiratoria (x')</strong></label>
        <input type="number" class="form-control" name="frecuencia_respiratoria">
    </div>
</div>

<div class="form-row d-flex justify-content-center">
    <div class="form-group col-md-3">
        <label><strong>Temperatura (°C)</strong></label>
        <input type="number" step="0.1" class="form-control" name="temperatura">
    </div>
    <div class="form-group col-md-3">
        <label><strong>Saturacion de Oxigeno (%)</strong></label>
        <input type="number" class="form-control" name="spo2">
    </div>
    <div class="form-group col-md-3">
        <label><strong>Glucemia (mg/dL)</strong></label>
        <input type="number" step="0.01" class="form-control" name="glucemia">
    </div>
</div>

        <div class="form-group">
            <label><strong>¿Glucosa medida en ayunas?</strong></label><br>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="glucosa_ayunas" value="1">
                <label class="form-check-label">Sí</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="glucosa_ayunas" value="0" checked>
                <label class="form-check-label">No</label>
            </div>
            
        </div>

        <div class="form-group">
    <label><strong>¿El paciente tiene alguna dificultad?</strong></label><br>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" name="dificultad" value="1" id="dificultad_si">
        <label class="form-check-label" for="dificultad_si">Sí</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" name="dificultad" value="0" id="dificultad_no" checked>
        <label class="form-check-label" for="dificultad_no">No</label>
    </div>
</div>

<div class="form-group" id="campo_dificultad_especifica" style="display: none;">
    <label><strong>Especifique la dificultad</strong></label>
    <input type="text" class="form-control" name="dificultad_especifica">
</div>

<script>
    function toggleCampoDificultad() {
        const valorSeleccionado = document.querySelector('input[name="dificultad"]:checked').value;
        const campo = document.getElementById('campo_dificultad_especifica');
        campo.style.display = valorSeleccionado === "1" ? 'block' : 'none';
    }

    document.querySelectorAll('input[name="dificultad"]').forEach((radio) => {
        radio.addEventListener('change', toggleCampoDificultad);
    });

    window.addEventListener('DOMContentLoaded', toggleCampoDificultad);
</script>


        <div class="form-row">
            <div class="form-group col-md-4">
                <label><strong>Tipo de dificultad</strong></label>
                <input type="text" class="form-control" name="tipo_dificultad">
            </div>
            <div class="form-group col-md-4">
                <label><strong>Grado</strong></label>
                <input type="text" class="form-control" name="grado_dificultad">
            </div>
            <div class="form-group col-md-4">
                <label><strong>Origen</strong></label>
                <input type="text" class="form-control" name="origen_dificultad">
            </div>
        </div>

        <div class="form-group">
            <label><strong>Tuberculosis Pulmonar probable</strong></label>
            <select class="form-control" name="tuberculosis_probable">
                <option value="SI">SI</option>
                <option value="NO" selected>NO</option>
                <option value="SE DESCONOCE">SE DESCONOCE</option>
            </select>
        </div>

        <div class="form-group">
            <label><strong>Hábito Exterior</strong></label>
            <textarea class="form-control" name="habito_exterior" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label><strong>Exploración</strong></label>
            <textarea class="form-control" name="exploración" rows="3"></textarea>
        <div class="form-group mt-3">
            <label for="detalles_laser_izquierdo"><strong>Detalles del Tratamiento:</strong></label>
            <div class="botones mb-2">
                <button type="button" class="btn btn-danger btn-sm" id="re_izquierdo_grabar"><i class="fas fa-microphone"></i></button>
                <button type="button" class="btn btn-primary btn-sm" id="re_izquierdo_detener"><i class="fas fa-microphone-slash"></i></button>
                <button type="button" class="btn btn-success btn-sm" id="play_re_izquierdo"><i class="fas fa-play"></i></button>
            </div>
            <textarea class="form-control" name="detalles_refraccion_visual" id="detalles_refraccion_visual" rows="4" placeholder="Ej. Observación de agudeza visual, recomendación de lentes, seguimiento de tratamiento"></textarea>
        </div>
    </form>
</div>

    <script>
        const det_re_derecho_grabar = document.getElementById('re_derecho_grabar');
        const det_re_derecho_detener = document.getElementById('re_derecho_detener');
        const detalles_re_derecho = document.getElementById('detalles_laser_derecho');
        const btn_det_derecho = document.getElementById('play_re_derecho');

        btn_det_derecho.addEventListener('click', () => {
            leerTexto(detalles_re_derecho.value);
        });

        let recognition_det_laser_derecho = new webkitSpeechRecognition();
        recognition_det_laser_derecho.lang = "es-ES";
        recognition_det_laser_derecho.continuous = true;
        recognition_det_laser_derecho.interimResults = false;
        recognition_det_laser_derecho.onresult = (event) => {
            const results = event.results;
            const frase = results[results.length - 1][0].transcript;
            detalles_re_derecho.value += frase;
        };

        det_re_derecho_grabar.addEventListener('click', () => {
            recognition_det_laser_derecho.start();
        });

        det_re_derecho_detener.addEventListener('click', () => {
            recognition_det_laser_derecho.abort();
        });

        function leerTexto(texto) {
            const speech = new SpeechSynthesisUtterance();
            speech.text = texto;
            speech.volume = 1;
            speech.rate = 1;
            speech.pitch = 0;
            window.speechSynthesis.speak(speech);
        }
    </script>
    </div>


    <center class="mt-3">
        <button type="submit" class="btn btn-primary">Firmar</button>
        <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
    </center>
    </form>
    </div>

    <script>
        let enviando = false;

        function checkSubmit() {
            if (!enviando) {
                enviando = true;
                return true;
            } else {
                alert("El formulario ya se esta enviando");
                return false;
            }
        }
    </script>
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
</body>

</html>