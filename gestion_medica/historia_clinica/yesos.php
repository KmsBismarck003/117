<?php
session_start();
include "../../conexionbd.php";
include ("../header_medico.php");
$resultado=$conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE dat_ingreso.area='YESOS'") or die($conexion->error);
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
                <center><font id="letra">Pacientes Yesos</font></h2> </center>

            <div class="row">
               
            </div>

            <div class="text-center">
            </div>
            <br>
            <h2>
                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
            </h2>

            <div class="form-group">
                <a href="buscar_not_yesos.php"><button type="button" class="btn btn-success btn-sm col-md-5"  data-target="#exampleModal">
                            <i class="fa fa-plus"></i> <font id="letra"> BUSCAR NOTA DE EVOLUCIÓN</font></button></a>
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
            </div>
            <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead">
                <tr>
                    <th scope="col"> Datos</th>
                    <th scope="col"> No. Expediente</th>
                    <th scope="col">Primer Apellido</th>
                    <th scope="col">Segundo Apellido</th>
                    <th scope="col">Nombre(s)</th>
                    <th scope="col">Fecha de Nacimiento</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Tratamiento</th>
                    <th scope="col">Area</th>
                    <th scope="col">Motivo de Atención</th>
                    <th scope="col">Fecha</th>

                </tr>
                </thead>
                <tbody>

                <?php
                while($f = mysqli_fetch_array($resultado)){

                    ?>

                    <tr>
                        <td scope="row" id="letra" align="center">
                            <a href="./nota_yesos.php?id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua'] ?>"><button type="button" class="btn btn-info btn-sm"><i class="fa fa-indent"></i></button></a></td>
                        <td><strong><?php echo $f['Id_exp'];?></strong></td>
                        <td><strong><?php echo $f['papell'];?></strong></td>
                        <td><strong><?php echo $f['sapell'];?></strong></td>
                        <td><strong><?php echo $f['nom_pac'];?></strong></td>
                        <td><strong><?php  $date = date_create($f[5]);
                                echo date_format($date,"d/m/Y");?></strong></td>
                        <td><strong><center><?php echo $f['edad'];?></center></strong></td>
                        <td><strong><center><?php echo $f['especialidad'];?></center></strong></td>
                        <td><strong><center><?php echo $f['area'];?></center></strong></td>
                        <td><strong><center><?php echo $f['motivo_atn'];?></center></strong></td>
                        <td><strong><center><?php echo $f['fecha'];?></center></strong></td>

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




<!-- Modal Insertar -->


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="insertar_paciente.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <?php
                    
                    $fecha_actual=date("d-m-Y h:m:s");
                    ?>
                    <div class="form-group">
                        <label for="fecha">Fecha y Hora del Sistema:</label>
                        <input type="datetime" name="fecha" value="<?= $fecha_actual?>" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="Id_exp">No Expediente:</label>
                        <input type="text" name="Id_exp" placeholder="Expediente" id="Id_exp" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="curp">Curp:</label>
                        <input type="text" name="curp" placeholder="Curp" id="curp" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                    </div>

                    <div class="form-group">
                        <label for="papell">Primer Apellido:</label>
                        <input type="text" name="papell" placeholder="Primer Apellido" id="papell" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                    </div>
                    <div class="form-group">
                        <label for="sapell">Segundo Apellido:</label>
                        <input type="text" name="sapell" placeholder="Segundo Apellido" id="sapell" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                    </div>

                    <div class="form-group">
                        <label for="nom_pac">Nombre(s):</label>
                        <input type="text" name="nom_pac" placeholder="Nombre(s)" id="nom_pac" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                    </div>
                    <div class="form-group">
                        <label for="fecnac">Fecha de Nacimiento:</label>
                        <input type="date" name="fecnac" placeholder="Fecha de nacimiento" id="fecnac" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edad">Edad:</label>
                        <input type="text" name="edad" placeholder="Edad" id="edad" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                    </div>

                    <div class="form-group">
                        <label for="">Estado de Nacimiento:</label>
                        <select id="id_edo_nac" class="form-control" name="id_edo_nac">
                            <option value="">Seleccionar estado</option>
                            <?php
                            foreach ($estados as $estado) {
                                echo '<option value="'.$estado['id'].'">'.$estado['nombre'].'</option>';
                            }//end foreach
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Sexo:</label>
                        <select name="sexo"class="form-control" required >
                            <option value="">Seleccionar Sexo</option>
                            <option value="HOMBRE">HOMBRE</option>
                            <option value="MUJER">MUJER</option>
                            <option value="SIN INFORMACION">SIN INFORMACION</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tipo de Sangre:</label>
                        <select id="id_tip_san" class="form-control" name="tip_san" required>
                            <option value="">Seleccionar tipo de sangre</option>
                            <option value="O Rh(-)">O Rh(-)</option>
                            <option value="O Rh(+)">O Rh(+)</option>
                            <option value="A Rh(-)">A Rh(-)</option>
                            <option value="A Rh(+)">A Rh(+)</option>
                            <option value="B Rh(-)">B Rh(-)</option>
                            <option value="B Rh(+)">B Rh(+)</option>
                            <option value="AB Rh(-)">AB Rh(-)</option>
                            <option value="AB Rh(+)">AB Rh(+)</option>

                        </select>

                    </div>

                    <div class="form-group">
                        <label for="">Nacionalidad:</label>
                        <select name="nac"class="form-control" required >
                            <option value="">Seleccionar Nacionalidad</option>
                            <option value="Mexicana">Mexicana</option>
                            <option value="Extranjero">Extranjero</option>

                        </select>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label for="">Estado de Residencia:</label>
                                <select id="id_estado" class="form-control" name="id_edo" required>
                                    <option value="">Seleccionar estado</option>
                                    <?php
                                    foreach ($estados as $estado) {
                                        echo '<option value="'.$estado['id'].'">'.$estado['nombre'].'</option>';
                                    }//end foreach
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <div class="form-group col-md-15">
                                    <label for="">Municipio:</label>
                                    <select id="municipios" class="form-control" name="id_mun" required>
                                        <option value="">Seleccionar municipio</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="loc">Localidad:</label>
                        <input type="text" name="loc" placeholder="Localidad" id="loc" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="dir">Dirección:</label>
                        <input type="text" name="dir" placeholder="Dirección" id="dir" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ocup">Ocupación:</label>
                        <input type="text" name="ocup" placeholder="Ocupación" id="ocup" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tel">Teléfono:</label>
                        <input type="text" name="tel" placeholder="Teléfono" id="tel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Religión:</label>
                        <select name="religion"class="form-control" required >
                            <option value="">Seleccionar Religión</option>
                            <option value="catolico">CATÓLICO</option>
                            <option value="protestante">PROTESTANTE </option>
                            <option value="testigo">TESTIGOS DE JEHOVÁ</option>
                            <option value="otro">OTROS </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="l_indigena">Lengua indígena:</label>
                        <input type="text" name="l_indigena" placeholder="Lengua Indígena" id="l_indigena" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="">Estado Civil:</label>
                        <select name="edociv"class="form-control" required >
                            <option value="">Selecciona Estado Civil</option>
                            <option value="soltero">SOLTERO</option>
                            <option value="casado">CASADO </option>
                            <option value="viudo">VIUDO</option>
                            <option value="divorciado">DIVORCIADO </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="resp">Nombre del Responsable:</label>
                        <input type="text" name="resp" placeholder="Responsable" id="resp" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="">Parentesco: </label>
                        <select name="paren"class="form-control" required >
                            <option value="">Selecciona Parentesco</option>
                            <option value="abuelo">ABUELO</option>
                            <option value="padre">PADRE</option>
                            <option value="tio">TÍO</option>
                            <option value="conyugue">CÓNYUGE</option>
                            <option value="hijo">HIJO</option>
                            <option value="otro">OTRO</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tel_resp">Teléfono del Responsable:</label>
                        <input type="text" name="tel_resp" placeholder="Teléfono" id="tel_resp" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Regresar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal Eliminar-->
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarLabel">Eliminar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                ¿Desea eliminar el producto?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Regresar</button>
                <button type="submit" class="btn btn-danger eliminar" data-dismiss="modal">Eliminar</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal Editar-->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditar" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="./editar_paciente.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditar">Editar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <input type="hidden" id="Id_expEdit" name="Id_exp">
                    <div class="form-group">
                        <label for="curpEdit">CURP</label>
                        <input type="text" name="curp" placeholder="Curp" id="curpEdit" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>
                    <div class="form-group">
                        <label for="papellEdit">Primer Apellido</label>
                        <input type="text" name="papell" placeholder="Primer Apellido" id="papellEdit" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>


                    <div class="form-group">
                        <label for="sapellEdit">Segundo Apellido</label>
                        <input type="text" name="sapell" placeholder="Segundo Apellido" id="sapellEdit" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>

                    <div class="form-group">
                        <label for="nombreEdit">Nombre</label>
                        <input type="text" name="nombre" placeholder="Nombre" id="nombreEdit" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>

                    <div class="form-group">
                        <label for="fecnacEdit">Fecha de Nacimiento</label>
                        <input type="date" name="fecnac" placeholder="Fecha de nacimiento" id="fecnacEdit" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="edonacEdit">Estado de Nacimiento</label>
                        <input type="text" name="edonac" placeholder="Estado de nacimiento" id="edonacEdit" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="sexoEdit">Sexo</label>
                        <input type="text" name="sexo" placeholder="Sexo" id="sexoEdit" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>

                    <div class="form-group">
                        <label for="nacorigenEdit">Nacionalidad</label>
                        <input type="text" name="nacorigen" placeholder="Nombre" id="nacorigenEdit" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="edoEdit">Estado de Residencia</label>
                        <input type="text" name="edo" placeholder="Estado de residencia" id="edoEdit" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="munEdit">Municipio</label>
                        <input type="text" name="mun" placeholder="Municipio" id="munEdit" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="locEdit">Localidad</label>
                        <input type="text" name="loc" placeholder="Localidad" id="locEdit" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="dirEdit">Direccion</label>
                        <input type="text" name="dir" placeholder="Direccion" id="dirEdit" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="ocupEdit">Ocupacion</label>
                        <input type="text" name="ocup" placeholder="Ocupacion" id="ocupEdit" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="telEdit">Telefono</label>
                        <input type="text" name="tel" placeholder="Telefono" id="telEdit" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Regresar</button>
                    <button type="submit" class="btn btn-primary editar">Guardar</button>
                </div>
        </div>
        </form>
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