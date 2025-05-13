<?php

session_start();
include "../../conexionbd.php";

include("../header_medico.php");
$resultado = $conexion->query("select paciente.*, estados.nombre, estado_nac.nom_est_nac, municipios.nombre_m
from paciente inner join estados 
on paciente.id_edo=estados.id_edo
inner join estado_nac on paciente.id_edo_nac=estado_nac.id_edo_nac
inner join municipios on paciente.id_mun=municipios.id_mun WHERE paciente.h_clinica='NO' ") or die($conexion->error);
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



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function () {
            $("#search").keyup(function () {
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function () {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
    </script>


    <title>Menu Gestión Médica </title>
    <link rel="shortcut icon" href="logp.png">
</head>


<div class="container-fluid">
     <a href="../cartas_consentimientos/consent_lista.php" class="btn btn-danger btn-sm">Regresar...</a>
    <div class="row">

        <div class="col col-12">
            <h2>
                <center><font id="letra">Menú Historia Clínica</font>
            </h2>
            <hr>
            </center>

               <div class="row">
                    <div class="col-6"><a href="buscar_hc.php">
                            <button type="button" class="btn btn-primary col-md-8" data-target="#exampleModal">
                                <i class="fa fa-plus"></i><font id="letra"> Buscar Historia Clínica</font></button></a>
                    </div>
               </div>

            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>
            <div class="table-responsive">

                <table class="table table-bordered table-striped" id="mytable">
                    <thead class="thead" style="background-color: seagreen">
                    <tr>
                        <th scope="col"> No. Expediente</th>
                        <th scope="col">
                            <center>Curp</center>
                        </th>
                        <th scope="col">Primer Apellido</th>
                        <th scope="col">Segundo Apellido</th>
                        <th scope="col">Nombre(s)</th>
                        <th scope="col">Fecha de Nacimiento</th>
                        <th scope="col">Edad</th>
                        <!--<th scope="col">Estado de Nacimiento</th>
                        <th scope="col">Sexo</th>
                        <th scope="col">Tipo de sangre</th>
                        <th scope="col">Nacionalidad</th>
                        <th scope="col">Estado de Residencia</th>
                        <th scope="col">Municipio</th>
                        <th scope="col">Localidad</th>
                        <th scope="col">Direccion</th>
                        <th scope="col">Ocupacion</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Fecha y Hora</th>
                        <th scope="col">Religion</th>
                        <th scope="col">Lengua Indigena</th>
                        <th scope="col">Estado Civil</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Parentesco</th>
                        <th scope="col">Telefono del Responsable</th>

                        <th scope="col"><font color="dodgerblue">Editar</font></th>-->
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    while ($f = mysqli_fetch_array($resultado)) {

                        ?>

                        <tr>
                            <td scope="row" id="letra" align="center"><a
                                        href="../historia_clinica/h_clinica.php?Id_exp=<?php echo $f['Id_exp']; ?>">
                                    <strong><?php echo $f['Id_exp']; ?></strong></td>
                            <td><strong><?php echo $f['curp']; ?></strong></td>
                            <td><strong><?php echo $f['papell']; ?></strong></td>
                            <td><strong><?php echo $f['sapell']; ?></strong></td>
                            <td><strong><?php echo $f['nom_pac']; ?></strong></td>
                            <td><strong><?php $date = date_create($f[5]);
                                    echo date_format($date, "d/m/Y"); ?></strong></td>
                            <td><strong>
                                    <center><?php echo $f['edad']; ?></center>
                                </strong></td>
                            <!-- <td><strong>
                       
                        <center><?php //echo $f['id_edo_nac']; ?><br><?php //echo $f['nom_est_nac']; ?>
                                    </center>
                                </strong></td>
                            <td><strong>
                                    <center><?php //echo $f['sexo']; ?></center>
                                </strong></td>
                            <td><strong>
                                    <center><?php //echo $f['tip_san']; ?></center>
                                </strong></td>
                            <td><strong>
                                    <center><?php //echo $f['nac']; ?></strong></td>
                            <td><strong>
                                    <center><?php //echo $f['id_edo']; ?><br><?php //echo $f['nombre']; ?></center>
                                </strong></td>
                            <td><strong>
                                    <center><?php //echo $f['id_mun']; ?><br><?php //echo $f['nombre_m']; ?></center>
                                </strong></td>
                            <td><strong>
                                    <center><?php //echo $f['loc']; ?></center>
                                </strong></td>
                            <td><strong><?php //echo $f['dir']; ?></strong></td>
                            <td><strong><?php //echo $f['ocup']; ?></strong></td>
                            <td><strong><?php //echo $f['tel']; ?></strong></td>
                            <td><strong><?php //echo $f['fecha']; ?></strong></td>
                            <td><strong><?php //echo $f['religion']; ?></strong></td>
                            <td><strong><?php //echo $f['l_indigena']; ?></strong></td>
                            <td><strong><?php //echo $f['edociv']; ?></strong></td>
                            <td><strong><?php //echo $f['resp']; ?></strong></td>
                            <td><strong><?php //echo $f['paren']; ?></strong></td>
                            <td><strong><?php //echo $f['tel_resp']; ?></strong></td>
                        -->

                           <!-- <td>
                                <center>
                                    <button class="btn btn-primary btn-small btnEditar"
                                            data-id="<?php echo $f['Id_exp']; ?>"
                                            data-curp="<?php echo $f['curp']; ?>"
                                            data-papell="<?php echo $f['papell']; ?>"
                                            data-sapell="<?php echo $f['sapell']; ?>"
                                            data-nombre="<?php echo $f['nombre']; ?>"
                                            data-fecnac="<?php echo $f['fecnac']; ?>"
                                            data-fecnac="<?php echo $f['edad']; ?>"
                                            data-edonac="<?php echo $f['edonac']; ?>"
                                            data-sexo="<?php echo $f['sexo']; ?>"
                                            data-nacorigen="<?php echo $f['nacorigen']; ?>"
                                            data-edo="<?php echo $f['id_edo']; ?>"
                                            data-mun="<?php echo $f['id_mun']; ?>"
                                            data-loc="<?php echo $f['loc']; ?>"
                                            data-dir="<?php echo $f['dir']; ?>"
                                            data-ocup="<?php echo $f['ocup']; ?>"
                                            data-tel="<?php echo $f['tel']; ?>"
                                            data-religion="<?php echo $f['religion']; ?>"
                                            data-l_indigena="<?php echo $f['l_indigena']; ?>"
                                            data-edociv="<?php echo $f['edociv']; ?>"
                                            data-resp="<?php echo $f['resp']; ?>"
                                            data-paren="<?php echo $f['paren']; ?>"
                                            data-tel_resp="<?php echo $f['tel_resp']; ?>"

                                            data-toggle="modal" data-target="#modalEditar"><i
                                                class="fa fa-edit"></i>
                                    </button>
                                </center>


                            </td>-->
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

</div>
<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>

<script>
    document.querySelector('#id_estado').addEventListener('change', event => {
        fetch('municipios.php?id_estado=' + event.target.value)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Hubo un error en la respuesta');
                }//en if
                return res.json();
            })
            .then(datos => {
                let html = '<option value="">Seleccionar municipio</option>';
                if (datos.data.length > 0) {
                    for (let i = 0; i < datos.data.length; i++) {
                        html += `<option value="${datos.data[i].id}">${datos.data[i].nombre}</option>`;
                    }//end for
                }//end if
                document.querySelector('#municipios').innerHTML = html;
            })
            .catch(error => {
                console.error('Ocurrió un error ' + error);
            });
    });
</script>

<script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>
</html>