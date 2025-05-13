<?php
session_start();
require "../../estados.php";
include "../../conexionbd.php";
include "../../gestion_administrativa/header_administrador.php";
$resultado=$conexion->query("select paciente.*, estados.nombre, estado_nac.nom_est_nac, municipios.nombre_m
from paciente inner join estados 
on paciente.id_edo=estados.id_edo
inner join estado_nac on paciente.id_edo_nac=estado_nac.id_edo_nac
inner join municipios on paciente.id_mun=municipios.id_mun") or die($conexion->error);

 $resultado1 = $conexion ->query("SELECT * FROM paciente ORDER by Id_exp DESC LIMIT 1")or die($conexion->error);
  
  if(mysqli_num_rows($resultado1) > 0 ){ //se mostrara si existe mas de 1
    $fila=mysqli_fetch_row($resultado1);

  }else{
    header("Location: ../registro_pac.php"); //te regresa a la página principal
  }


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

        <title>Hoja Frontal </title>
        <link rel="shortcut icon" href="logp.jpg">
    </head>

    <div>
       <center>
                    <h2>Hoja Frontal</h2>
                </center>
        <div class="container-fluid">
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
            <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                        <?php
                        
                            $fecha_actual=date("d-m-Y H:i:s");
                            ?>
                         <label for="fecha">Fecha y Hora de Ingreso:</label>
                        <input type="datetime" name="fecha" value="<?= $fecha_actual?>" class="form-control" disabled>
                    </div>
                     </div> 
                       
                      <div class="col-sm-5">
                                      <div class="form-group">

                                              <label for="Id_exp">No Expediente:</label>
                                              <input type="text" name="Id_exp" placeholder="Expediente" value="<?php echo $fila[0] ?>" id="Id_exp" class="form-control" disabled>
                                      </div> 
                            </div>  
                    </div>
                    <form action="insertar_ingreso.php" method="POST">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                  <label for="id_usua">Medico Tratante:</label>
                                  <select name="id_usua"class="form-control" required >
                                         <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where id_rol=2")or die($conexion->error);
                                          ?>
                                        <option value="">Seleccionar doctor</option>
                                        <?php foreach ($resultado1 as $opciones):?>
                                         <option value="<?php echo $opciones['id_usua']?>"><?php echo $opciones['nombre']?> <?php echo $opciones ['papell']?> <?php echo $opciones['sapell']?></option>
  
                                           <?php endforeach?>
                                  </select>
                                </div>
                              </div>

 <div class="col-sm-5">
 <div class="form-group">
<label for="area">Servicio:</label>
<select name="area"class="form-control" required >
<option value="">Seleccionar Servicio</option> 
 <option value="HOSPITALIZACIÓN">HOSPITALIZACIÓN</option>
   <option value="AMBULATORIO">AMBULATORIO</option>
     <option value="TRIAGE">URGENCIAS</option>
  <option value="CONSULTA EXTERNA">CONSULTA EXTERNA</option>
</select>
</div>
                            </div>
</div>
<div class="row">
                              <div class="col-sm-5">
                                <div class="form-group">
<label for="motivo_atn">Diagnostico:</label><br>
<input type="text" name="motivo_atn" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  placeholder="Diagnostico" required > 

</div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label for="especialidad"> Tratamiento Medico Quirúrgico</label>
                                <input type="text" name="especialidad" class="form-control" placeholder="Tratamiento Medico" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  required  >
                              </div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label for="alergias"> Alergias</label>
                                <input type="text" name="alergias" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  placeholder="Alergias" required >
                              </div>

                            </div>
                      </div>
              
                      
                <div>
                        <center>
                            <button type="submit" class="btn btn-success">GUARDAR</button>
                            
                        </center>
                </div>
            </div>

            </form>

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