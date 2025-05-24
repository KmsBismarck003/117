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
        <strong><center>RECETA DE LENTES DE CONTACTO</center></strong>
    </div>

    <form method="POST" action="insertar_refraccion.php">

        <!-- Selector principal -->
        <h4 class="mt-2"><strong>Usuario de Lentes de Contacto Suaves</strong></h4>
        <div class="form-group">
            <select class="form-control" name="usuario_lentes_suaves">
                <option value="">Seleccionar</option>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <!-- LENTES SUAVES POR OJO -->
        <h4 class="mt-4"><strong>Lentes de Contacto Suaves</strong></h4>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Usa Lentes Suaves OD (Derecho)</label>
                <select class="form-control" name="usa_lentes_suaves_der">
                    <option value="">Seleccionar</option>
                    <option value="Sí">Sí</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Usa Lentes Suaves OI (Izquierdo)</label>
                <select class="form-control" name="usa_lentes_suaves_izq">
                    <option value="">Seleccionar</option>
                    <option value="Sí">Sí</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3"><label>Esf Der</label><input class="form-control" name="av_suaves_der_esf"></div>
            <div class="form-group col-md-3"><label>Cil Der</label><input class="form-control" name="av_suaves_der_cil"></div>
            <div class="form-group col-md-3"><label>CB Der</label><input class="form-control" name="av_suaves_der_cb"></div>
            <div class="form-group col-md-3"><label>Diam Der</label><input class="form-control" name="av_suaves_der_diam"></div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3"><label>Esf Izq</label><input class="form-control" name="av_suaves_izq_esf"></div>
            <div class="form-group col-md-3"><label>Cil Izq</label><input class="form-control" name="av_suaves_izq_cil"></div>
            <div class="form-group col-md-3"><label>CB Izq</label><input class="form-control" name="av_suaves_izq_cb"></div>
            <div class="form-group col-md-3"><label>Diam Izq</label><input class="form-control" name="av_suaves_izq_diam"></div>
        </div>

        <div class="form-row">
    <div class="form-group col-md-6">
        <label>Tipo Suaves Der</label>
        <select class="form-control" name="tipo_suaves_der">
            <option value="">Seleccionar</option>
            <option value="Esférico">Esférico</option>
            <option value="Tórico">Tórico</option>
            <option value="Multifocal">Multifocal</option>
            <option value="Cosmético">Cosmético</option>
            <option value="Color">Color</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label>Tipo Suaves Izq</label>
        <select class="form-control" name="tipo_suaves_izq">
            <option value="">Seleccionar</option>
            <option value="Esférico">Esférico</option>
            <option value="Tórico">Tórico</option>
            <option value="Multifocal">Multifocal</option>
            <option value="Cosmético">Cosmético</option>
            <option value="Color">Color</option>
        </select>
    </div>
</div>


        <div class="container">
    <div class="thead">
        <strong><center>RECETA DE LENTES DE CONTACTO DUROS</center></strong>
    </div>
        <br>
    <h5><strong>¿Usa Lentes de Contacto Duros?</strong></h5>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>OD (Derecho)</label>
            <select class="form-control" name="usa_lentes_duros_der">
                <option value="">Seleccionar</option>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>OI (Izquierdo)</label>
            <select class="form-control" name="usa_lentes_duros_izq">
                <option value="">Seleccionar</option>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>
    </div>

    <!-- Parámetros Básicos -->
    <h5 class="mt-4"><strong>Parámetros Básicos</strong></h5>
    <div class="form-row">
        <div class="form-group col-md-3"><label>Esf Der</label><input class="form-control" name="av_duros_der_esf"></div>
        <div class="form-group col-md-3"><label>Cil Der</label><input class="form-control" name="av_duros_der_cil"></div>
        <div class="form-group col-md-3"><label>CB Der</label><input class="form-control" name="av_duros_der_cb"></div>
        <div class="form-group col-md-3"><label>Diam Der</label><input class="form-control" name="av_duros_der_diam"></div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3"><label>Esf Izq</label><input class="form-control" name="av_duros_izq_esf"></div>
        <div class="form-group col-md-3"><label>Cil Izq</label><input class="form-control" name="av_duros_izq_cil"></div>
        <div class="form-group col-md-3"><label>CB Izq</label><input class="form-control" name="av_duros_izq_cb"></div>
        <div class="form-group col-md-3"><label>Diam Izq</label><input class="form-control" name="av_duros_izq_diam"></div>
    </div>

<h5><strong>AV con LC Híbrido</strong></h5>
<div class="form-row">
    <div class="form-group col-md-6">
        <label>OD (Derecho)</label>
        <select class="form-control" name="av_con_hibrido_der">
            <option value="">Seleccionar</option>
            <option value="20/20">20/20</option>
            <option value="20/25">20/25</option>
            <option value="20/30">20/30</option>
            <option value="20/40">20/40</option>
            <option value="20/50">20/50</option>
            <option value="20/60">20/60</option>
            <option value="20/70">20/70</option>
            <option value="20/80">20/80</option>
            <option value="20/100">20/100</option>
            <option value="20/200">20/200</option>
            <option value="Cuenta dedos">Cuenta dedos</option>
            <option value="Percepción de luz">Percepción de luz</option>
            <option value="Sin percepción de luz">Sin percepción de luz</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label>OI (Izquierdo)</label>
        <select class="form-control" name="av_con_hibrido_izq">
            <option value="">Seleccionar</option>
            <option value="20/20">20/20</option>
            <option value="20/25">20/25</option>
            <option value="20/30">20/30</option>
            <option value="20/40">20/40</option>
            <option value="20/50">20/50</option>
            <option value="20/60">20/60</option>
            <option value="20/70">20/70</option>
            <option value="20/80">20/80</option>
            <option value="20/100">20/100</option>
            <option value="20/200">20/200</option>
            <option value="Cuenta dedos">Cuenta dedos</option>
            <option value="Percepción de luz">Percepción de luz</option>
            <option value="Sin percepción de luz">Sin percepción de luz</option>
        </select>
    </div>
</div>
<h5 class="mt-4"><strong>Receta LC Híbrido</strong></h5>
    <div class="form-row">
        <div class="form-group col-md-3"><label>VLT/CB Der</label><input class="form-control" name="receta_duros_der_tangente"></div>
        <div class="form-group col-md-3"><label>Diam Der</label><input class="form-control" name="receta_duros_der_altura"></div>
        <div class="form-group col-md-3"><label>Esf Der</label><input class="form-control" name="receta_duros_der_el"></div>
        <div class="form-group col-md-3"><label>Faldilla Der</label><input class="form-control" name="receta_duros_der_or"></div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3"><label>VLT/CB Izq</label><input class="form-control" name="receta_duros_izq_tangente"></div>
        <div class="form-group col-md-3"><label>Diam Izq</label><input class="form-control" name="receta_duros_izq_altura"></div>
        <div class="form-group col-md-3"><label>Esf Izq</label><input class="form-control" name="receta_duros_izq_el"></div>
        <div class="form-group col-md-3"><label>Faldilla Izq</label><input class="form-control" name="receta_duros_izq_or"></div>
    </div>
<!-- Tipo de Lente de Contacto -->
 <div class="thead">
        <strong><center>TIPO DE LENTES DE CONTACTO</center></strong>
    </div>
<h5 class="mt-4"><strong>Tipo de Lente de Contacto</strong></h5>
<div class="form-group">
    <label for="tipo_lente">Selecciona el tipo de lente</label>
    <select class="form-control" id="tipo_lente" onchange="cambiarOpcionesYMarcasYDKAV()">
        <option value="">Seleccionar</option>
        <option value="duros">Lente de Contacto Duros</option>
        <option value="suaves">Lente de Contacto Suaves</option>
        <option value="hibridos">Lente Híbrido</option>
        <option value="esclerales">Lente Escleral</option>
    </select>
</div>

<!-- ¿Qué tipo usa en cada ojo? -->
<h5><strong>¿Qué tipo usa en cada ojo?</strong></h5>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="opciones_od">OD (Derecho)</label>
        <select class="form-control" id="opciones_od" name="opciones_od">
            <option value="">Seleccionar tipo de lente primero</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="opciones_oi">OI (Izquierdo)</label>
        <select class="form-control" id="opciones_oi" name="opciones_oi">
            <option value="">Seleccionar tipo de lente primero</option>
        </select>
    </div>
</div>

<!-- Selección de marcas -->
<h5><strong>Marca por Ojo</strong></h5>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="marca_od">Marca OD (Derecho)</label>
        <select class="form-control" id="marca_od" name="marca_od">
            <option value="">Seleccionar tipo primero</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="marca_oi">Marca OI (Izquierdo)</label>
        <select class="form-control" id="marca_oi" name="marca_oi">
            <option value="">Seleccionar tipo primero</option>
        </select>
    </div>
</div>

<!-- DK y AV solo para Lente Escleral -->
<h5 class="mt-4"><strong>DK y AV para Lente Escleral</strong></h5>
<div class="form-row">
    <div class="form-group col-md-3">
        <label for="dk_od">DK OD (Derecho)</label>
        <select class="form-control" id="dk_od" name="dk_od" disabled>
            <option value="">Seleccionar tipo escleral primero</option>
        </select>
    </div>
    <div class="form-group col-md-3">
        <label for="av_od">AV OD (Derecho)</label>
        <select class="form-control" id="av_od" name="av_od" disabled>
            <option value="">Seleccionar tipo escleral primero</option>
        </select>
    </div>
    <div class="form-group col-md-3">
        <label for="dk_oi">DK OI (Izquierdo)</label>
        <select class="form-control" id="dk_oi" name="dk_oi" disabled>
            <option value="">Seleccionar tipo escleral primero</option>
        </select>
    </div>
    <div class="form-group col-md-3">
        <label for="av_oi">AV OI (Izquierdo)</label>
        <select class="form-control" id="av_oi" name="av_oi" disabled>
            <option value="">Seleccionar tipo escleral primero</option>
        </select>
    </div>
</div>

<script>
    function cambiarOpcionesYMarcasYDKAV() {
        const tipo = document.getElementById("tipo_lente").value;

        const opcionesOD = document.getElementById("opciones_od");
        const opcionesOI = document.getElementById("opciones_oi");
        const marcaOD = document.getElementById("marca_od");
        const marcaOI = document.getElementById("marca_oi");

        const dkOD = document.getElementById("dk_od");
        const avOD = document.getElementById("av_od");
        const dkOI = document.getElementById("dk_oi");
        const avOI = document.getElementById("av_oi");

        const opciones = {
            duros: ["Sí", "No"],
            suaves: ["Diarias", "Quincenales", "Mensuales", "Tóricas", "Multifocales"],
            hibridos: ["Alta AV", "Molestias", "Adaptación incompleta", "No disponible"],
            esclerales: ["Grande", "Pequeña", "Alta elevación", "Con túnel de ventilación"]
        };

        const marcas = {
            duros: ["Boston XO", "Paragon HDS", "Optimum Extra", "Menicon Z"],
            suaves: ["Acuvue Oasys", "Air Optix", "Biofinity", "Dailies Total 1"],
            hibridos: ["SynergEyes A", "UltraHealth", "Duette", "ClearKone"],
            esclerales: ["Zenlens", "Jupiter", "Onefit", "Europa Scleral"]
        };

        // Datos para DK y AV solo para lentes esclerales
        const dkValores = ["28", "29", "30", "31"];
        const avValores = ["8.0", "8.2", "8.4", "8.6"];

        const valores = opciones[tipo] || [];
        const marcasTipo = marcas[tipo] || [];

        function rellenarSelect(select, items, habilitar = true) {
            select.innerHTML = "";
            const defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.textContent = habilitar ? "Seleccionar" : "Seleccionar tipo escleral primero";
            select.appendChild(defaultOption);

            if (habilitar) {
                items.forEach(item => {
                    const opt = document.createElement("option");
                    opt.value = item;
                    opt.textContent = item;
                    select.appendChild(opt);
                });
            }
            select.disabled = !habilitar;
        }

        // Actualizar opciones y marcas
        rellenarSelect(opcionesOD, valores);
        rellenarSelect(opcionesOI, valores);
        rellenarSelect(marcaOD, marcasTipo);
        rellenarSelect(marcaOI, marcasTipo);

        // Solo habilitar y llenar DK y AV si tipo es esclerales
        if (tipo === "esclerales") {
            rellenarSelect(dkOD, dkValores, true);
            rellenarSelect(avOD, avValores, true);
            rellenarSelect(dkOI, dkValores, true);
            rellenarSelect(avOI, avValores, true);
        } else {
            // Deshabilitar y limpiar DK y AV si no es esclerales
            rellenarSelect(dkOD, [], false);
            rellenarSelect(avOD, [], false);
            rellenarSelect(dkOI, [], false);
            rellenarSelect(avOI, [], false);
        }
    }
</script>
    <div class="form-row">
        <div class="form-group col-md-3"><label>Sagita Der</label><input class="form-control" name="receta_duros_der_tangente"></div>
        <div class="form-group col-md-3"><label>Diam Der</label><input class="form-control" name="receta_duros_der_altura"></div>
        <div class="form-group col-md-3"><label>Med Der</label><input class="form-control" name="receta_duros_der_el"></div>
        <div class="form-group col-md-3"><label>Limbal Der</label><input class="form-control" name="receta_duros_der_or"></div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3"><label>Saguita Izq</label><input class="form-control" name="receta_duros_izq_tangente"></div>
        <div class="form-group col-md-3"><label>Diam Izq</label><input class="form-control" name="receta_duros_izq_altura"></div>
        <div class="form-group col-md-3"><label>Med Izq</label><input class="form-control" name="receta_duros_izq_el"></div>
        <div class="form-group col-md-3"><label>Limbal Izq</label><input class="form-control" name="receta_duros_izq_or"></div>
    </div>


    <h5><strong>Detalles del Tratamiento</strong></h5>
    <div class="form-group">
        <div class="botones mb-2">
            <button type="button" class="btn btn-danger btn-sm" id="re_izquierdo_grabar"><i class="fas fa-microphone"></i></button>
            <button type="button" class="btn btn-primary btn-sm" id="re_izquierdo_detener"><i class="fas fa-microphone-slash"></i></button>
            <button type="button" class="btn btn-success btn-sm" id="play_re_izquierdo"><i class="fas fa-play"></i></button>
        </div>
        <textarea class="form-control" name="detalles_refraccion_visual" id="detalles_refraccion_visual" rows="4" placeholder="Ej. Observación de agudeza visual, recomendación de lentes, seguimiento de tratamiento"></textarea>
    </div>
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