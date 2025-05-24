<?php
session_start();
include "../../conexionbd.php";
include "../header_medico.php";

// Check if user is authenticated
if (!isset($_SESSION['hospital'])) {
    header("Location: ../login.php");
    exit();
}

// Get logged-in user
$usuario = $_SESSION['login'] ?? '';

if ($conexion) {
    $id_atencion = $_SESSION['hospital'];
    $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.folio, p.tel, p.fecnac, p.tip_san, di.fecha, di.area, di.alta_med, di.activo, p.sexo, di.alergias, p.ocup 
                FROM paciente p, dat_ingreso di
                WHERE p.Id_exp=di.Id_exp AND di.id_atencion = ?";
    $stmt = $conexion->prepare($sql_pac);
    $stmt->bind_param("i", $id_atencion);
    $stmt->execute();
    $result_pac = $stmt->get_result();
    while ($row_pac = $result_pac->fetch_assoc()) {
        $pac_papell = $row_pac['papell'];
        $pac_sapell = $row_pac['sapell'];
        $pac_nom_pac = $row_pac['nom_pac'];
        $pac_folio = $row_pac['folio'];
        $pac_fecing = $row_pac['fecha'];
        // Add other variables as needed by header_medico.php
    }
    $stmt->close();
    $conexion->close();
} else {
    echo '<p style="color: red;">Error de conexión a la base de datos</p>';
}
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

<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

<div class="container mt-4">
    <div class="thead"><strong>
                <center>PRUEBAS OFTALMOLÓGICAS</center>
            </strong></div>
    <form action="insertar_refraccion.php" method="POST" onsubmit="return checkSubmit();">

        <br>
       <div class="form-group">
    <label><strong>Tipo de Prueba Oftalmológica</strong></label>
    <select class="form-control" name="tipo_prueba_oftalmologica" required>
        <option value="">Seleccione una prueba oftalmológica</option>
        <option value="Prueba de Agudeza Visual">Prueba de Agudeza Visual</option>
        <option value="Prueba de Ishihara">Prueba de Ishihara (Daltonismo)</option>
        <option value="Prueba de Amsler">Prueba de Amsler (Maculopatías)</option>
        <option value="Farnsworth-Munsell">Farnsworth-Munsell (Color)</option>
        <option value="TRPL">TRPL (Tiempo de Respuesta Pupilar)</option>
        <option value="Schirmer">Prueba de Schirmer (Lágrima)</option>
        <option value="Puntos de Worth">Puntos de Worth (Fusión binocular)</option>
        <option value="Cover Test">Prueba Cover (Estrabismo)</option>
        <option value="Tinción con Fluoresceína">Tinción con Fluoresceína</option>
        <option value="Otras">Otras</option>
    </select>
</div>


        <div class="form-row">
            <div class="form-group col-md-6">
                <label><strong>Resultado</strong></label>
                <input type="text" class="form-control" name="resultado" required>
            </div>
            <div class="form-group col-md-6">
                <label><strong>Fecha de la Prueba</strong></label>
                <input type="date" class="form-control" name="fecha" required>
            </div>
        </div>

        <div class="form-group">
            <label><strong>Observaciones</strong></label>
            <textarea class="form-control" name="observaciones" rows="3" placeholder="Observaciones clínicas relevantes..."></textarea>
        </div>

        <!-- MENÚ TABS -->
        <ul class="nav nav-tabs" id="ojoTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="od-tab" data-toggle="tab" href="#od" role="tab" aria-controls="od" aria-selected="true">Ojo Derecho (OD)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="oi-tab" data-toggle="tab" href="#oi" role="tab" aria-controls="oi" aria-selected="false">Ojo Izquierdo (OI)</a>
            </li>
        </ul>

        <div class="tab-content p-3 border border-top-0" id="ojoTabsContent">
            <!-- Ojo Derecho -->
            <div class="tab-pane fade show active" id="od" role="tabpanel" aria-labelledby="od-tab">
                <!-- Campos OD -->
                <div class="form-group">
                    <label><strong>Estrabismo</strong></label>
                    <input type="text" class="form-control" name="estrabismo_od">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="ojo_preferente" id="od_pref" value="OD">
                    <label class="form-check-label" for="od_pref">Ojo Preferente</label>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Movimientos Oculares</strong></label>
                        <input type="text" class="form-control" name="mov_oculares_od">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Convergencia Ocular</strong></label>
                        <input type="text" class="form-control" name="convergencia_od">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Prueba Cover</strong></label>
                        <input type="text" class="form-control" name="prueba_cover_od">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Visión Estereoscópica</strong></label>
                        <input type="text" class="form-control" name="vision_estereo_od">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Puntos de Worth</strong></label>
                        <input type="text" class="form-control" name="worth_od">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Prueba de Schirmer (mm)</strong></label>
                        <input type="text" class="form-control" name="schirmer_od">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>TRPL (segundos)</strong></label>
                        <input type="text" class="form-control" name="trpl_od">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Tinción con Fluoresceína</strong></label>
                        <input type="text" class="form-control" name="fluoresceina_od">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Sensibilidad al Contraste</strong></label>
                        <input type="text" class="form-control" name="contraste_od">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Prueba Ishihara</strong></label>
                        <input type="text" class="form-control" name="ishihara_od">
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>Prueba Farnsworth-Munsell</strong></label>
                    <input type="text" class="form-control" name="farnsworth_od">
                </div>

                <div class="form-group">
                    <label><strong>Prueba Amsler</strong></label>
                    <select class="form-control" name="amsler_od">
                        <option value="">Resultado</option>
                        <option value="Normal">Normal</option>
                        <option value="Anormal">Anormal</option>
                    </select>
                </div>

            </div>

            <!-- Ojo Izquierdo -->
            <div class="tab-pane fade" id="oi" role="tabpanel" aria-labelledby="oi-tab">
                <!-- Campos OI -->
                <div class="form-group">
                    <label><strong>Estrabismo</strong></label>
                    <input type="text" class="form-control" name="estrabismo_oi">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="ojo_preferente" id="oi_pref" value="OI">
                    <label class="form-check-label" for="oi_pref">Ojo Preferente</label>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Movimientos Oculares</strong></label>
                        <input type="text" class="form-control" name="mov_oculares_oi">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Convergencia Ocular</strong></label>
                        <input type="text" class="form-control" name="convergencia_oi">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Prueba Cover</strong></label>
                        <input type="text" class="form-control" name="prueba_cover_oi">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Visión Estereoscópica</strong></label>
                        <input type="text" class="form-control" name="vision_estereo_oi">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Puntos de Worth</strong></label>
                        <input type="text" class="form-control" name="worth_oi">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Prueba de Schirmer (mm)</strong></label>
                        <input type="text" class="form-control" name="schirmer_oi">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>TRPL (segundos)</strong></label>
                        <input type="text" class="form-control" name="trpl_oi">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Tinción con Fluoresceína</strong></label>
                        <input type="text" class="form-control" name="fluoresceina_oi">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Sensibilidad al Contraste</strong></label>
                        <input type="text" class="form-control" name="contraste_oi">
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Prueba Ishihara</strong></label>
                        <input type="text" class="form-control" name="ishihara_oi">
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>Prueba Farnsworth-Munsell</strong></label>
                    <input type="text" class="form-control" name="farnsworth_oi">
                </div>

                <div class="form-group">
                    <label><strong>Prueba Amsler</strong></label>
                    <select class="form-control" name="amsler_oi">
                        <option value="">Resultado</option>
                        <option value="Normal">Normal</option>
                        <option value="Anormal">Anormal</option>
                    </select>
                </div>

    </form>
</div>

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