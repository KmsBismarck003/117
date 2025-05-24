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
        <strong><center>RECETA DE ANTEOJOS</center></strong>
    </div>

    <form method="POST" action="insertar_refraccion.php">

        <!-- Refracción Lejana -->
        <h4 class="mt-4"><strong>Refracción Lejana</strong></h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th></th><th>Esf</th><th>Cil</th><th>Eje</th><th>Add</th><th>DIP</th><th>Prisma</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>OD</td>
                        <td><input class="form-control" name="esf_lejana_od" type="text"></td>
                        <td><input class="form-control" name="cil_lejana_od" type="text"></td>
                        <td><input class="form-control" name="eje_lejana_od" type="text"></td>
                        <td><input class="form-control" name="add_lejana_od" type="text"></td>
                        <td><input class="form-control" name="dip_lejana_od" type="text"></td>
                        <td><input class="form-check-input" name="prisma_lejana_od" type="checkbox" value="1"></td>
                    </tr>
                    <tr>
                        <td>OI</td>
                        <td><input class="form-control" name="esf_lejana_oi" type="text"></td>
                        <td><input class="form-control" name="cil_lejana_oi" type="text"></td>
                        <td><input class="form-control" name="eje_lejana_oi" type="text"></td>
                        <td><input class="form-control" name="add_lejana_oi" type="text"></td>
                        <td><input class="form-control" name="dip_lejana_oi" type="text"></td>
                        <td><input class="form-check-input" name="prisma_lejana_oi" type="checkbox" value="1"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Refracción Cercana -->
        <h4 class="mt-4"><strong>Refracción Cercana</strong></h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th></th><th>Esf</th><th>Cil</th><th>Eje</th><th>DIP</th><th>Prisma</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>OD</td>
                        <td><input class="form-control" name="esf_cercana_od" type="text"></td>
                        <td><input class="form-control" name="cil_cercana_od" type="text"></td>
                        <td><input class="form-control" name="eje_cercana_od" type="text"></td>
                        <td><input class="form-control" name="dip_cercana_od" type="text"></td>
                        <td><input class="form-check-input" name="prisma_cercana_od" type="checkbox" value="1"></td>
                    </tr>
                    <tr>
                        <td>OI</td>
                        <td><input class="form-control" name="esf_cercana_oi" type="text"></td>
                        <td><input class="form-control" name="cil_cercana_oi" type="text"></td>
                        <td><input class="form-control" name="eje_cercana_oi" type="text"></td>
                        <td><input class="form-control" name="dip_cercana_oi" type="text"></td>
                        <td><input class="form-check-input" name="prisma_cercana_oi" type="checkbox" value="1"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Refracción Intermedia -->
        <h4 class="mt-4"><strong>Refracción Intermedia</strong></h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr><th></th><th>Esf</th><th>Cil</th><th>Eje</th><th>DIP</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>OD</td>
                        <td><input class="form-control" name="esf_intermedia_od" type="text"></td>
                        <td><input class="form-control" name="cil_intermedia_od" type="text"></td>
                        <td><input class="form-control" name="eje_intermedia_od" type="text"></td>
                        <td><input class="form-control" name="dip_intermedia_od" type="text"></td>
                    </tr>
                    <tr>
                        <td>OI</td>
                        <td><input class="form-control" name="esf_intermedia_oi" type="text"></td>
                        <td><input class="form-control" name="cil_intermedia_oi" type="text"></td>
                        <td><input class="form-control" name="eje_intermedia_oi" type="text"></td>
                        <td><input class="form-control" name="dip_intermedia_oi" type="text"></td>
                    </tr>
                </tbody>
            </table>
        </div>

<h4 class="mt-4"><strong>Tipo de Lentes</strong></h4>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="tipo_lente_od">Tipo de Lente OD</label>
        <select class="form-control" name="tipo_lente_od" id="tipo_lente_od">
            <option value="">Seleccione una opción</option>
            <option value="monofocal">Monofocal</option>
            <option value="bifocal">Bifocal</option>
            <option value="progresivo">Progresivo</option>
            <option value="ocupacional">Ocupacional</option>
            <option value="fotocromático">Fotocromático</option>
            <option value="polarizado">Polarizado</option>
            <option value="antirreflejo">Con Antirreflejo</option>
            <option value="lente_contacto">Lente de Contacto</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="tipo_lente_oi">Tipo de Lente OI</label>
        <select class="form-control" name="tipo_lente_oi" id="tipo_lente_oi">
            <option value="">Seleccione una opción</option>
            <option value="monofocal">Monofocal</option>
            <option value="bifocal">Bifocal</option>
            <option value="progresivo">Progresivo</option>
            <option value="ocupacional">Ocupacional</option>
            <option value="fotocromático">Fotocromático</option>
            <option value="polarizado">Polarizado</option>
            <option value="antirreflejo">Con Antirreflejo</option>
            <option value="lente_contacto">Lente de Contacto</option>
        </select>
    </div>
</div>

        <!-- Observaciones -->
        <h4 class="mt-4"><strong>Observaciones</strong></h4>
        <div class="form-group">
            <div class="botones mb-2">
                <button type="button" class="btn btn-danger btn-sm" id="re_izquierdo_grabar"><i class="fas fa-microphone"></i></button>
                <button type="button" class="btn btn-primary btn-sm" id="re_izquierdo_detener"><i class="fas fa-microphone-slash"></i></button>
                <button type="button" class="btn btn-success btn-sm" id="play_re_izquierdo"><i class="fas fa-play"></i></button>
            </div>
            <textarea class="form-control" name="observaciones" rows="3" placeholder="Observaciones generales sobre la receta de anteojos"></textarea>
            
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