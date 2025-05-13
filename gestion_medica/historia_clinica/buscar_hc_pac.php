<?php
session_start();
include "../../conexionbd.php";
include("../../gestion_medica/header_medico.php");
$resultado = $conexion->query("select paciente.*, dat_hclinica.*
from paciente 
inner join dat_hclinica on paciente.Id_exp=dat_hclinica.Id_exp
where id_hc=" . $_GET['id_hc']) or die($conexion->error);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>
    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>

    <!--<link rel="stylesheet" type="text/css" href="../../css/estilos.css" media="screen" />-->

    <title>Menu Gestión Médica </title>
    <link rel="shortcut icon" href="logp.png">
</head>

    <div class="container-fluid">
        <div class="row">
            <div class="col  col-12">
                <h2>
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                                  id="side"></i></a>
                    <center><font id="letra">Historia Clínica Realizada</font>
                </h2>
                </center>



                <h2>
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                                  id="side"></i></a>
                </h2>
                <hr>

                <table class="table table-bordered table-striped" >
                    <thead class="thead" style="background-color: seagreen">
                    <tr>
                        <th scope="col"> Folio de Historia clínica</th>
                        <th scope="col">No. de Expediente</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Interrogarotio</th>
                        <th scope="col">Ant. Abuelos</th>
                        <th scope="col">Ant. Padres</th>
                        <th scope="col">Ant. hermanos</th>
                        <th scope="col">Otros</th>
                        <th scope="col">Ant. Nacimiento</th>
                        <th scope="col">Zoonosis</th>
                        <th scope="col">Zoo. Cuales</th>
                        <th scope="col">Alimentación</th>
                        <th scope="col">Actividad Física</th>
                        <th scope="col">Otros</th>
                        <th scope="col">Alérgias</th>
                        <th scope="col">Transfucionales</th>
                        <th scope="col">Fecha Transfución</th>
                        <th scope="col">Enfermedades</th>
                        <th scope="col">Enf. Cuales</th>
                        <th scope="col">Adicciones</th>
                        <th scope="col">Adic. Cuales</th>
                        <th scope="col">Hospitalizaciones/ Cirugías</th>
                        <th scope="col">Hosp./ Cir. Cuales</th>
                        <th scope="col">Gestas</th>
                        <th scope="col">Partos</th>
                        <th scope="col">Cesareas</th>
                        <th scope="col">Abortos</th>
                        <th scope="col">Padecimiento Actual</th>
                        <th scope="col">Aparatos y Sistemas</th>
                        <th scope="col">P. Arterial Sistólica</th>
                        <th scope="col">p. Arterial Diastólica</th>
                        <th scope="col">Frecuencia Cardiaca</th>
                        <th scope="col">Frecuencia Respiratoria</th>
                        <th scope="col">Temperatura</th>
                        <th scope="col">Saturación de Oxigeno</th>
                        <th scope="col">Peso</th>
                        <th scope="col">Talla</th>
                        <th scope="col">Exploración física</th>
                        <th scope="col">Laboratorio</th>
                        <th scope="col">Gabinete</th>
                        <th scope="col">Otros</th>
                        <th scope="col">Diagnóstico</th>
                        <th scope="col">Pronostico para la vida</th>
                        <th scope="col">Pronostico para la función</th>
                        <th scope="col">Discapacidad</th>
                        <th scope="col">Terapeutica Empleada y Resultados</th>
                        <th scope="col">Terapeutica Actual</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($f = mysqli_fetch_array($resultado)) {

                        ?>
                        <tr>
                            <td><strong><?php echo $f['id_hc']; ?></strong></td>
                            <td><strong><?php echo $f['Id_exp']; ?></strong></td>
                            <td><strong><?php echo $f['fec_hc']; ?></strong></td>
                            <td><strong><?php echo $f['tip_hc']; ?></strong></td>
                            <td><strong><?php echo $f['hc_abu']; ?></strong></td>
                            <td><strong><?php echo $f['hc_pad']; ?></strong></td>
                            <td><strong><?php echo $f['hc_her']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_her_o']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_nac']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_zoo']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_zoo_cual']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_ali']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_act']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_otro']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_ale']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_tra']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_tra_fecha']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_pato']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_pato_cual']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_adic']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_adic_cual']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_enf']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_enf_cual']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_ges']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_par']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_ces']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_abo']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_pade']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_apa']; ?></center></strong></td>
                            <td><center><strong><?php echo $f['p_sistolica']; ?></strong></center></td>
                            <td><center><strong><?php echo $f['p_diastolica']; ?></strong></center></td>
                            <td><center><strong><?php echo $f['f_card']; ?></strong></center></td>
                            <td><center><strong><?php echo $f['f_resp']; ?></center></center></strong></td>
                            <td><center><strong><?php echo $f['temp']; ?></center></center></strong></td>
                            <td><center><strong><?php echo $f['sat_oxigeno']; ?></center></center></strong></td>
                            <td><center><strong><?php echo $f['peso']; ?></center></strong></center></td>
                            <td><center><strong><?php echo $f['talla']; ?></center></strong></center></td>
                            <td><strong><?php echo $f['hc_explora']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_lab']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_gabi']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_res_o']; ?></center></strong></td>
                            <td><strong><?php echo $f['id_cie_10']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_te']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_vid']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_def']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_dis']; ?></center></strong></td>
                            <td><strong><?php echo $f['hc_ta']; ?></center></strong></td>
                        </tr>
                        <?php
                    }

                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <footer class="main-footer">
        <?php
        include("../../template/footer.php");
        ?>
    </footer>
    <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- FastClick -->
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>


    </body>
</html>
