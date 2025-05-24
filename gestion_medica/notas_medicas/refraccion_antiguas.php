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
    <script src="https://kit.fontawesome.com/e547be4475.js" crossorigin="anonymous"></script>


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
        <div class="thead"><strong>
                <center>REFRACCION VISUAL ANTIGUAS</center>
            </strong></div>
        <form action="insertar_refraccion.php" method="POST" onsubmit="return checkSubmit();">
            <div class="card-header" id="headingRight">
                <div class="accordion mt-3" id="eyeAccordion">
                    <div class="card" id="ojoDerecho">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapseRight" aria-expanded="false" aria-controls="collapseRight"><i class="fa-solid fa-eye"></i>
                                    Ojo Derecho
                                </button>
                            </h2>
                        </div>

                        <div id="collapseRight" class="collapse" aria-labelledby="headingRight" data-parent="#eyeAccordion">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="tipo_derecho"><strong>Tipo de Examen</strong></label>
                                    <select class="form-control" name="tipo_derecho" id="tipo_derecho">
                                        <option value="Selecciona">Selecciona</option>
                                        <option value="Esferómetro">Esferómetro</option>
                                        <option value="Autorrefractómetro">Autorrefractómetro</option>
                                        <option value="Retinoscopía">Retinoscopía</option>
                                        <option value="Queratometría">Queratometría</option>
                                        <option value="Foróptero">Foróptero</option>
                                        <option value="Cartilla de Snellen">Cartilla de Snellen</option>
                                        <option value="Lentes de prueba">Lentes de prueba</option>
                                        <option value="Refracción Subjetiva">Refracción Subjetiva</option>
                                        <option value="Refracción Objetiva">Refracción Objetiva</option>
                                        <option value="Topografía Corneal">Topografía Corneal</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>

                                <h5 class="mt-3"><strong>Refracción Lejana - Ojo Derecho</strong></h5>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="av_lejana_Derecho">AV Lejana</label>
        <select class="form-control" name="av_lejana_Derecho" id="av_lejana_Derecho">
            <option value="">Seleccionar</option>
            <option value="20/20">20/20</option>
            <option value="20/25">20/25</option>
            <option value="20/30">20/30</option>
            <option value="20/40">20/40</option>
            <option value="20/50">20/50</option>
        </select>
    </div>
    <div class="col-md-6 form-group">
        <label for="av_lejana_lentes_Derecho">AV con Lentes</label>
        <select class="form-control" name="av_lejana_lentes_Derecho" id="av_lejana_lentes_Derecho">
            <option value="">Seleccionar</option>
            <option value="20/20">20/20</option>
            <option value="20/25">20/25</option>
            <option value="20/30">20/30</option>
            <option value="20/40">20/40</option>
            <option value="20/50">20/50</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-2 form-group">
        <label for="esf_lejana_Derecho">Esf</label>
        <input type="text" class="form-control" name="esf_lejana_Derecho" id="esf_lejana_Derecho">
    </div>
    <div class="col-md-2 form-group">
        <label for="cil_lejana_Derecho">Cil</label>
        <input type="text" class="form-control" name="cil_lejana_Derecho" id="cil_lejana_Derecho">
    </div>
    <div class="col-md-2 form-group">
        <label for="eje_lejana_Derecho">Eje</label>
        <input type="text" class="form-control" name="eje_lejana_Derecho" id="eje_lejana_Derecho">
    </div>
    <div class="col-md-2 form-group">
        <label for="add_lejana_Derecho">Add</label>
        <input type="text" class="form-control" name="add_lejana_Derecho" id="add_lejana_Derecho">
    </div>
    <div class="col-md-2 form-group d-flex align-items-center">
        <input type="checkbox" name="prisma_lejana_Derecho" id="prisma_lejana_Derecho">
        <label for="prisma_lejana_Derecho" class="ml-2 mb-0">Prisma</label>
    </div>
</div>

<h5 class="mt-4"><strong>Refracción Cercana - Ojo Derecho</strong></h5>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="av_cercana_Derecho">AV Cercana</label>
        <select class="form-control" name="av_cercana_Derecho" id="av_cercana_Derecho">
            <option value="">Seleccionar</option>
            <option value="20/20">20/20</option>
            <option value="20/25">20/25</option>
            <option value="20/30">20/30</option>
            <option value="20/40">20/40</option>
            <option value="20/50">20/50</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-2 form-group">
        <label for="esf_cercana_Derecho">Esf</label>
        <input type="text" class="form-control" name="esf_cercana_Derecho" id="esf_cercana_Derecho">
    </div>
    <div class="col-md-2 form-group">
        <label for="cil_cercana_Derecho">Cil</label>
        <input type="text" class="form-control" name="cil_cercana_Derecho" id="cil_cercana_Derecho">
    </div>
    <div class="col-md-2 form-group">
        <label for="eje_cercana_Derecho">Eje</label>
        <input type="text" class="form-control" name="eje_cercana_Derecho" id="eje_cercana_Derecho">
    </div>
    <div class="col-md-2 form-group">
        <label for="add_cercana_Derecho">Add</label>
        <input type="text" class="form-control" name="add_cercana_Derecho" id="add_cercana_Derecho">
    </div>
    <div class="col-md-2 form-group d-flex align-items-center pt-4">
        <input type="checkbox" name="prisma_cercana_Derecho" id="prisma_cercana_Derecho">
        <label for="prisma_cercana_Derecho" class="ml-2 mb-0">Prisma</label>
    </div>
</div>
                                <div class="form-group mt-3">
                                    <label for="detalles_laser_derecho"><strong>Detalles del Tratamiento:</strong></label>
                                    <div class="botones mb-2">
                                        <button type="button" class="btn btn-danger btn-sm" id="re_derecho_grabar"><i class="fas fa-microphone"></i></button>
                                        <button type="button" class="btn btn-primary btn-sm" id="re_derecho_detener"><i class="fas fa-microphone-slash"></i></button>
                                        <button type="button" class="btn btn-success btn-sm" id="play_re_derecho"><i class="fas fa-play"></i></button>
                                    </div>
<textarea class="form-control" name="detalles_refraccion_visual" id="detalles_refraccion_visual" rows="4" placeholder="Ej. Observación de agudeza visual, recomendación de lentes, seguimiento de tratamiento"></textarea>
                                </div>
                            </div>
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

    <div class="card" id="ojoIzquierdo">
        <div class="card-header">
            <h2 class="mb-0">
                <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapseLeft" aria-expanded="false" aria-controls="collapseLeft"><i class="fa-solid fa-eye"></i>
                    Ojo Izquierdo
                </button>
            </h2>
        </div>
        <div id="collapseLeft" class="collapse" data-parent="#eyeAccordion">
            <div class="card-body">
                <div class="form-group">
                    <label for="tipo_izquierdo"><strong>Tipo de Examen</strong></label>
                    <select class="form-control" name="tipo_izquierdo" id="tipo_izquierdo">
                        <option value="Selecciona">Selecciona</option>
                        <option value="Esferómetro">Esferómetro</option>
                        <option value="Autorrefractómetro">Autorrefractómetro</option>
                        <option value="Retinoscopía">Retinoscopía</option>
                        <option value="Queratometría">Queratometría</option>
                        <option value="Foróptero">Foróptero</option>
                        <option value="Cartilla de Snellen">Cartilla de Snellen</option>
                        <option value="Lentes de prueba">Lentes de prueba</option>
                        <option value="Refracción Subjetiva">Refracción Subjetiva</option>
                        <option value="Refracción Objetiva">Refracción Objetiva</option>
                        <option value="Topografía Corneal">Topografía Corneal</option>
                        <option value="Otros">Otros</option>
                    </select>
                </div>

<h5 class="mt-4"><strong>Refracción Lejana - Ojo Izquierdo</strong></h5>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="av_lejana_Izquierdo">AV Lejana</label>
        <select id="av_lejana_Izquierdo" name="av_lejana_Izquierdo" class="form-control">
            <option value="">Seleccionar</option>
            <option value="20/20">20/20</option>
            <option value="20/25">20/25</option>
            <option value="20/30">20/30</option>
            <option value="20/40">20/40</option>
            <option value="20/50">20/50</option>
        </select>
    </div>
    <div class="col-md-6 form-group">
        <label for="av_lejana_lentes_Izquierdo">AV con Lentes</label>
        <select id="av_lejana_lentes_Izquierdo" name="av_lejana_lentes_Izquierdo" class="form-control">
            <option value="">Seleccionar</option>
            <option value="20/20">20/20</option>
            <option value="20/25">20/25</option>
            <option value="20/30">20/30</option>
            <option value="20/40">20/40</option>
            <option value="20/50">20/50</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-2 form-group">
        <label for="esf_lejana_Izquierdo">Esf</label>
        <input type="text" class="form-control" name="esf_lejana_Izquierdo" id="esf_lejana_Izquierdo">
    </div>
    <div class="col-md-2 form-group">
        <label for="cil_lejana_Izquierdo">Cil</label>
        <input type="text" class="form-control" name="cil_lejana_Izquierdo" id="cil_lejana_Izquierdo">
    </div>
    <div class="col-md-2 form-group">
        <label for="eje_lejana_Izquierdo">Eje</label>
        <input type="text" class="form-control" name="eje_lejana_Izquierdo" id="eje_lejana_Izquierdo">
    </div>
    <div class="col-md-2 form-group">
        <label for="add_lejana_Izquierdo">Add</label>
        <input type="text" class="form-control" name="add_lejana_Izquierdo" id="add_lejana_Izquierdo">
    </div>
    <div class="col-md-2 form-group d-flex align-items-center">
        <input type="checkbox" name="prisma_lejana_Izquierdo" id="prisma_lejana_Izquierdo">
        <label for="prisma_lejana_Izquierdo" class="ml-2 mb-0">Prisma</label>
    </div>
</div>

<h5 class="mt-4"><strong>Refracción Cercana - Ojo Izquierdo</strong></h5>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="av_cercana_Izquierdo">AV Cercana</label>
        <select id="av_cercana_Izquierdo" name="av_cercana_Izquierdo" class="form-control">
            <option value="">Seleccionar</option>
            <option value="20/20">20/20</option>
            <option value="20/25">20/25</option>
            <option value="20/30">20/30</option>
            <option value="20/40">20/40</option>
            <option value="20/50">20/50</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-2 form-group">
        <label for="esf_cercana_Izquierdo">Esf</label>
        <input type="text" class="form-control" name="esf_cercana_Izquierdo" id="esf_cercana_Izquierdo">
    </div>
    <div class="col-md-2 form-group">
        <label for="cil_cercana_Izquierdo">Cil</label>
        <input type="text" class="form-control" name="cil_cercana_Izquierdo" id="cil_cercana_Izquierdo">
    </div>
    <div class="col-md-2 form-group">
        <label for="eje_cercana_Izquierdo">Eje</label>
        <input type="text" class="form-control" name="eje_cercana_Izquierdo" id="eje_cercana_Izquierdo">
    </div>
    <div class="col-md-2 form-group">
        <label for="add_cercana_Izquierdo">Add</label>
        <input type="text" class="form-control" name="add_cercana_Izquierdo" id="add_cercana_Izquierdo">
    </div>
    <div class="col-md-2 form-group d-flex align-items-center">
        <input type="checkbox" name="prisma_cercana_Izquierdo" id="prisma_cercana_Izquierdo">
        <label for="prisma_cercana_Izquierdo" class="ml-2 mb-0">Prisma</label>
    </div>
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

                <script>
                    const det_re_izquierdo_grabar = document.getElementById('re_izquierdo_grabar');
                    const det_re_izquierdo_detener = document.getElementById('re_izquierdo_detener');
                    const detalles_re_izquierdo = document.getElementById('detalles_laser_izquierdo');
                    const btn_det_izquierdo = document.getElementById('play_re_izquierdo');

                    btn_det_izquierdo.addEventListener('click', () => {
                        leerTextoIzquierdo(detalles_re_izquierdo.value);
                    });

                    let recognition_det_laser_izquierdo = new webkitSpeechRecognition();
                    recognition_det_laser_izquierdo.lang = "es-ES";
                    recognition_det_laser_izquierdo.continuous = true;
                    recognition_det_laser_izquierdo.interimResults = false;
                    recognition_det_laser_izquierdo.onresult = (event) => {
                        const results = event.results;
                        const frase = results[results.length - 1][0].transcript;
                        detalles_re_izquierdo.value += frase;
                    };

                    det_re_izquierdo_grabar.addEventListener('click', () => {
                        recognition_det_laser_izquierdo.start();
                    });

                    det_re_izquierdo_detener.addEventListener('click', () => {
                        recognition_det_laser_izquierdo.abort();
                    });

                    function leerTextoIzquierdo(texto) {
                        const speech = new SpeechSynthesisUtterance();
                        speech.text = texto;
                        speech.volume = 1;
                        speech.rate = 1;
                        speech.pitch = 0;
                        window.speechSynthesis.speak(speech);
                    }
                </script>
            </div>
        </div>
    </div>

    <!--<div class="accordion mt-3" id="refraccionAccordion">
        <div class="card" id="refraccionActualCard">
            <div class="card-header" id="headingRefraccionActual">
                <h2 class="mb-0">
                    <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapseRefraccionActual" aria-expanded="false" aria-controls="collapseRefraccionActual">
                        Refracción Actual
                    </button>
                </h2>
            </div>

            <div id="collapseRefraccionActual" class="collapse" aria-labelledby="headingRefraccionActual" data-parent="#refraccionAccordion">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="av_binocular">AV Binocular</label>
                            <input type="text" class="form-control" name="av_binocular" id="av_binocular">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="av_sin_correccion">AV sin Corrección</label>
                            <input type="text" class="form-control" name="av_sin_correccion" id="av_sin_correccion">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="av_estenopeico">AV Estenopeico</label>
                            <input type="text" class="form-control" name="av_estenopeico" id="av_estenopeico">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="av_corr_propia">AV Corrección Propia</label>
                            <input type="text" class="form-control" name="av_corr_propia" id="av_corr_propia">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="av_mejor_corr">AV Mejor Corregida</label>
                            <input type="text" class="form-control" name="av_mejor_corr" id="av_mejor_corr">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="av_potencial">AV Potencial</label>
                            <input type="text" class="form-control" name="av_potencial" id="av_potencial">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div> -->
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