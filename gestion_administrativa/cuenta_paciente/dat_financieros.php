<?php
session_start();
require "../../estados.php";
include "../../conexionbd.php";
include "../../gestion_administrativa/header_administrador.php";


 $resultado1 = $conexion ->query("select paciente.*, estados.nombre, estado_nac.nom_est_nac, municipios.nombre_m
from paciente  inner join estados 
on paciente.id_edo=estados.id_edo
inner join estado_nac on paciente.id_edo_nac=estado_nac.id_edo_nac
inner join municipios on paciente.id_mun=municipios.id_mun ORDER by Id_exp DESC LIMIT 1")or die($conexion->error);
 
$usuario = $_SESSION['login'];


?>

<!DOCTYPE html>
<div>
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
              integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
              crossorigin="anonymous">
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
              integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
              crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen"/>
        <script src="../js/soloLetras.js"></script>

        <title>Depósitos a la Cuenta </title>
        <link rel="shortcut icon" href="logp.jpg">
    </head>

    <div>
               <?php 
                          while($fila = mysqli_fetch_array($resultado1)){
                            ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2"></div>
                <center>
                    <div class="col" id="colocacion2"><h2>Depósitos a la Cuenta</h2><hr>
                </center>
</div>
               <div class="row">
                        <div class="col-sm">
                          No. Expediente: <strong><?php echo $fila[0];?></strong><br>
                          Nombre del paciente: <strong><?php echo $fila[2];?>
                                                       <?php echo $fila[3];?>
                                                         <?php echo $fila[4];?></strong><br>
      
                          Fecha de Nacimiento:<strong> <?php  $date = date_create($fila[5]);
                          echo date_format($date,"d/m/Y");?></strong>
                        </div>
                     </div><hr>
                    <div class="col-sm-3">
                        <?php
                        
                        $fecha_actual = date("d-m-Y H:i:s");
                        ?>

                        <div class="form-group">
                            <label for="fecha">Fecha y Hora de Depósito:</label>
                            <input type="datetime" name="fecha" value="<?= $fecha_actual ?>" class="form-control"
                                   disabled>
                        </div>
                    </div>
                    <div class="container">
                    <form action="insertar_df.php" method="POST">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="aseg">Aseguradora: </label><br>
                                    <select name="aseg" class="form-control" required>
                                        <option value="">Seleccionar Aseguradora</option>
                                        <option value="ALICO">ALICO</option>
                                        <option value="BANORTE GENERALI">BANORTE GENERALI</option>
                                        <option value="GNP">GNP</option>
                                        <option value="MAPFRE">MAPFRE</option>
                                        <option value="METLIFE">METLIFE</option>
                                        <option value="SEGUROS MONTERREY">SEGUROS MONTERREY</option>
                                        <option value="SURA">SURA</option>
                                        <option value="NINGUNA">NINGUNA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="resp">Nombre del Responsable del paciente: </label><br>
                                    <input type="text" name="resp" placeholder="Responsable" id="resp"
                                           style="text-transform:uppercase;" value="<?php echo $fila[22] ?>" maxlength="50" 
                                           onkeypress="return SoloLetras(event);" 
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" disabled
                                           class="form-control">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="dir_resp">Dirección del responsable: </label><br>
                                    <input type="text" name="dir_resp" placeholder="Dirección del Responsable"
                                           id="dir_resp"
                                           style="text-transform:uppercase;" value="<?php echo $fila[14] ?>"
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" required
                                           class="form-control" disabled>
                                </div>
                            </div>
                          
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="id_edo">Estado: </label><br>
                               
                                    <input type="text" name="id_edo" placeholder="Estado"
                                           id="id_edo"
                                           style="text-transform:uppercase;" value=" <?php echo $fila['nombre'] ?> "
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" required
                                           class="form-control" disabled>
                 
                                </div>
                            </div>
                        </div>
                
                            <div class="row">
                                <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="id_mun">Municipio: </label><br>
                                    <input type="text" name="id_mun" placeholder="Municipio"
                                           id="id_mun"
                                           style="text-transform:uppercase;" value="<?php echo $fila['nombre_m'] ?>"
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" required
                                           class="form-control" disabled>
                                </div>
                               </div> 
                               <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="tel">Telefono del responsable : </label><br>
                                    <input type="text" name="tel" placeholder="Telefono" id="tel"
                                           style="text-transform:uppercase;" value="<?php echo $fila[24] ?>"maxlength="12" minlength="12" 
                                           onkeypress="return SoloNumeros(event);" 
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" disabled
                                           class="form-control">
                                </div>
                            </div>
                            </div>
                        
                        <div class="row">
                            
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="aval">Nombre del aval :</label><br>
                                    <input type="text" name="aval" placeholder="Nombre del Aval" id="aval"
                                           style="text-transform:uppercase;" value="" maxlength="40"
                                           onkeypress="return SoloLetras(event);" 
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" required
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="banco">Forma de Pago</label><br>
                                    <select name="banco" class="form-control" required>
                                        <option value="">Seleccionar Forma de Pago</option>
                                        <option value="EFECTIVO">EFECTIVO</option>
                                        <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                        <option value="DEPOSITO">DEPOSITO</option>
                                        <option value="TARJETA DEBITO">TARJETA DEBITO</option>
                                        <option value="TARJETA CREDITO">TARJETA CRÈDITO</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            
                            <div class="col-sm-5">
                             <div class="form-group">
                                    <label for="fec_deposito">Fecha de Depósito</label><br>
                                    <input type="date" name="fec_deposito" placeholder="Fecha de Desposito"
                                           id="fec_deposito"
                                           class="form-control" value="" required>
                                </div>
                            </div>
                             <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="deposito">Depósito Inicial $</label><br>
                                    <input type="number" name="deposito" placeholder="Dep. inicial" id="deposito"
                                           value="" maxlength="13" minlength="1" 
                                           onkeypress="return SoloNumeros(event);" 
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" required
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                           
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="dep_l">Cantidad con letra $</label><br>
                                    <input type="text" name="dep_l" placeholder="Dep. con letra" id="dep_l"
                                           style="text-transform:uppercase;" value=""maxlength="150" 
                                           onkeypress="return SoloLetras(event);" 
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" required
                                           class="form-control">
                                </div>
                            </div>
                            
                        </div>

                       

                        <center>
                          <a href="../cuenta_paciente/vista_df.php" class="btn btn-danger">REGRESAR</a>
                            <button type="submit" class="btn btn-success">GUARDAR</button>
                            
                        </center>
                </div><br>
            </div>                               <?php
                }
                ?>

            </form>
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
                    fetch('../../municipios.php?id_estado=' + event.target.value)
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


            <script>document.oncontextmenu = function () {
                    return false;
                }</script>
            </body>


            </html>