<?php
session_start();
include "../../conexionbd.php";
include ("../header_medico.php");
$resultado=$conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion, triage.*
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp 
inner join triage on dat_ingreso.id_atencion=triage.id_atencion WHERE triage.destino='QUIROFANO'") or die($conexion->error);
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
        $(document).ready(function(){
            $("#search").keyup(function(){
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function() {
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
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
<div class="container">
</div>
<body>
<div class="container-fluid">
    <div class="row">


        <div class="col col-12">
            <h2>
                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                <center><font id="letra">PACIENTES NOTA POSTOPERATORIA</font></h2> </center>

            <div class="row">
                
            </div>

            <div class="text-center">
            </div>
            <br>
            <h2>
                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
            </h2>

            <div class="form-group">
 <a href="buscar_nota_postoperatoria.php"><button type="button" class="btn btn-success btn-sm col-md-5"  data-target="#exampleModal">
                            <i class="fa fa-plus"></i> <font id="letra"> BUSCAR NOTA POSTOPERATORIA</font></button></a>

                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
            </div>
            <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead">
                <tr>
                    <th scope="col"> Datos</th>
                    <th scope="col"> Folio de Admisión</th>
                   
                    <th scope="col">Primer Apellido</th>
                    <th scope="col">Segundo Apellido</th>
                    <th scope="col">Nombre(s)</th>
                    <th scope="col">Fecha de Nacimiento</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Especialidad</th>
                    <th scope="col">Destino</th>
                    <th scope="col">Motivo de atención</th>
                    <th scope="col">Fecha</th>

                </tr>
                </thead>
                <tbody>

                <?php
                while($f = mysqli_fetch_array($resultado)){

                    ?>

                    <tr>
                        <td> <a href="./nota_postoperatoria.php?id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua'] ?>"><strong> <button type="button" class="btn btn-danger"> <i class="fa fa-heartbeat" aria-hidden="true"></i> </button></td>

                        <td> <?php echo $f['id_atencion'];?></strong></td>

                        
                        <td><strong><?php echo $f['papell'];?></strong></td>
                        <td><strong><?php echo $f['sapell'];?></strong></td>
                        <td><strong><?php echo $f['nom_pac'];?></strong></td>
                        <td><strong><?php  $date = date_create($f[5]);
                                echo date_format($date,"d/m/Y");?></strong></td>
                        <td><strong><center><?php echo $f['edad'];?></center></strong></td>
                        <td><strong><center><?php echo $f['especialidad'];?></center></strong></td>
                        <td><strong><center><?php echo $f['destino'];?></center></strong></td>
                        <td><strong><center><?php echo $f['motivo_atn'];?></center></strong></td>
                        <td><strong><center><?php  $date = date_create($f['fecha']);
                                echo date_format($date,"d/m/Y h:i");?></center></strong></td>

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





<script>
    document.querySelector('#id_estado').addEventListener('change', event => {
        fetch('municipios.php?id_estado='+event.target.value)
            .then(res => {
                if(!res.ok) {
                    throw new Error('Hubo un error en la respuesta');
                }//en if
                return res.json();
            })
            .then(datos => {
                let html = '<option value="">Seleccionar municipio</option>';
                if(datos.data.length > 0) {
                    for (let i = 0; i < datos.data.length; i++) {
                        html += `<option value="${datos.data[i].id}">${datos.data[i].nombre}</option>`;
                    }//end for
                }//end if
                document.querySelector('#municipios').innerHTML = html;
            })
            .catch(error => {
                console.error('Ocurrió un error '+error);
            });
    });
</script>




<script>
    $(document).ready(function(){
        var idEliminar= -1;
        var idEditar=-1;
        var fila;
        $(".btnEliminar").click(function(){
            Id_expEliminar=$(this).data('Id_exp');
            fila=$(this).parent('td').parent('tr');
        });
        $(".eliminar").click(function(){
            $.ajax({
                url: 'eliminar_paciente.php',
                method:'POST',
                data:{
                    id:idEliminar
                }
            }).done(function(res){
                $(fila).fadeOut();
            });
        });
        $(".btnEditar").click(function(){
            idEditar=$(this).data('Id_exp');
            var curp=$(this).data('curp');
            var papell=$(this).data('papell');
            var sapell=$(this).data('sapell');
            var nombre=$(this).data('nombre');
            var fecnac=$(this).data('fecnac');
            var edonac=$(this).data('edonac');
            var sexo=$(this).data('sexo');
            var nacorigen=$(this).data('nacorigen');
            var edo=$(this).data('edo');
            var mun=$(this).data('mun');
            var loc=$(this).data('loc');
            var dir=$(this).data('dir');
            var ocup=$(this).data('ocup');
            var tel=$(this).data('tel');
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
    document.oncontextmenu = function(){return false;}

</script>
<script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>
</html>