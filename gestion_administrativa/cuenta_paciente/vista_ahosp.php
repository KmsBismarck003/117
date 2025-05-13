<?php
session_start();
include "../../conexionbd.php";
include("../../gestion_administrativa/header_administrador.php");


$resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE dat_ingreso.area='HOSPITALIZACION' && dat_ingreso.activo='SI' && dat_ingreso.cama='0'") or die($conexion->error);
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>



    <title>Asignar habitacion </title>
    <link rel="shortcut icon" href="logp.png">
</head>


<body>
    <div class="container">
        <div class="row">


            <div class="col col-12">
               
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                <div class="text-center">
                </div>
               
                    <a href="../gestion_pacientes/registro_pac.php" class="btn btn-danger btn-sm">Regresar</a><hr>            
                
                <div class="row">
                    <div class="col-6"><a href="dispo_camas_ahosp.php"><button type="button" class="btn btn-primary col-md-5" data-target="#exampleModal">
                                <i class="fa fa-plus"></i>
                                <font id="letra">Ver disponibilidad</font>
                            </button>
                    </div>
                </div>

                <br>
                <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                     <tr><strong><center>LISTA DE PACIENTES SIN HABITACIÓN ASIGNADA</center></strong>
                </div>
               
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
              
                

                <table class="table table-responsive table-hover">
                    <thead class="thead">
                        <tr>
                            <th scope="col">HABITACIÓN</th>
                            <th scope="col">EXP.</th>
                            <th scope="col">NOMBRE(S)</th>
                            <th scope="col">FEC. NAC.</th>
                            <th scope="col">EDAD</th>
                            <th scope="col">MOTIVO DE ATENCIÓN</th>
                            <th scope="col">FECHA DE INGRESO</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($f = mysqli_fetch_array($resultado)) {

                        ?>

                            <tr>
                                <td scope="row" id="letra" align="center"><a href="../cuenta_paciente/dispo_camas.php?id_atencion=<?php echo $f['id_atencion']; ?>"><strong> <button type="button" class="btn btn-danger"> <i class="fa fa-bed" aria-hidden="true"></i> </button></td>
                                <td><?php echo $f['Id_exp']; ?></td>
                                <td><?php echo $f['papell'].' '.$f['sapell'].' '.$f['nom_pac']; ?></td>
                                <td><?php $date = date_create($f[5]); echo date_format($date, "d/m/Y"); ?></strong></td>
                                <td> <center><?php echo $f['edad']; ?></center></td>
                                <td><center><?php echo $f['motivo_atn']; ?></center></td>
                                <td> <center><?php $date = date_create($f['fecha']);echo date_format($date, "d/m/Y"); ?></center></td>
                            </tr>
                        <?php
                        }

                        ?>
                       
                    </tbody>
                </table>


                <br>
                <br>

            </div>
        </div>
    </div>




    <script>
        document.querySelector('#id_estado').addEventListener('change', event => {
            fetch('municipios.php?id_estado=' + event.target.value)
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Hubo un error en la respuesta');
                    } //en if
                    return res.json();
                })
                .then(datos => {
                    let html = '<option value="">Seleccionar municipio</option>';
                    if (datos.data.length > 0) {
                        for (let i = 0; i < datos.data.length; i++) {
                            html += `<option value="${datos.data[i].id}">${datos.data[i].nombre}</option>`;
                        } //end for
                    } //end if
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

    <script>
        $(document).ready(function() {
            var idEliminar = -1;
            var idEditar = -1;
            var fila;
            $(".btnEliminar").click(function() {
                Id_expEliminar = $(this).data('Id_exp');
                fila = $(this).parent('td').parent('tr');
            });
            $(".eliminar").click(function() {
                $.ajax({
                    url: 'eliminar_paciente.php',
                    method: 'POST',
                    data: {
                        id: idEliminar
                    }
                }).done(function(res) {
                    $(fila).fadeOut();
                });
            });
            $(".btnEditar").click(function() {
                idEditar = $(this).data('Id_exp');
                var curp = $(this).data('curp');
                var papell = $(this).data('papell');
                var sapell = $(this).data('sapell');
                var nombre = $(this).data('nombre');
                var fecnac = $(this).data('fecnac');
                var edonac = $(this).data('edonac');
                var sexo = $(this).data('sexo');
                var nacorigen = $(this).data('nacorigen');
                var edo = $(this).data('edo');
                var mun = $(this).data('mun');
                var loc = $(this).data('loc');
                var dir = $(this).data('dir');
                var ocup = $(this).data('ocup');
                var tel = $(this).data('tel');
                $("#curpEdit").val(curp);
                $("#papellEdit").val(papell);
                $("#sapellEdit").val(sapell);
                $("#nombreEdit").val(nombre);
                $("#fecnacEdit").val(fecnac);
                $("#edonacEdit").val(edonac);
                $("#sexoEdit").val(sexo);
                $("#nacorigenEdit").val(nacorigen);
                $("#edoEdit").val(edo);
                $("#munEdit").val(mun);
                $("#locEdit").val(loc);
                $("#dirEdit").val(dir);
                $("#ocupEdit").val(ocup);
                $("#telEdit").val(tel);
                $("#Id_expEdit").val(Id_expEditar);

            });
        });
        document.oncontextmenu = function() {
            return false;
        }
    </script>

</body>

</html>