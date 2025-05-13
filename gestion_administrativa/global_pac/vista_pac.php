<?php
session_start();
require "../../estados.php";
include "../../conexionbd.php";
include "../header_administrador.php";

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

        <script src="../../js/jquery-3.3.1.min.js"></script>
        <script src="../../js/jquery-ui.js"></script>
        <script src="../../js/popper.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        <script src="../../js/jquery.magnific-popup.min.js"></script>
        <script src="../../js/aos.js"></script>
        <script src="../../js/main.js"></script>

        <title>Nuevo Paciente </title>
        <link rel="shortcut icon" href="logp.jpg">



<script>
        function habilitar(value)
        {
            if(value=="HOSPITALIZACIÓN" || value==true)
            {
                // habilitamos
                document.getElementById("cama").disabled=false;
            }else if(value=="QUIROFANO" || value=="TRIAGE"  || value==false){
                // deshabilitamos
                document.getElementById("cama").disabled=true;
            }
        }
    </script>

    </head>
    <div class="container ">
        <div class="row">
    <div class="col-sm-1">
                    <a href="pac_global.php"><button type="button" class="btn btn-danger btn-sm"><font id="letra">Regresar</font></button></a>
                </div> 
                <div class="col-sm-3">
<?php 
$id_exp=$_GET['id_exp'];
$id_atencion=$_GET['id_atencion'];
?>
                    <!--<a href="../cartas_consentimientos/consent_lis_pac_glob.php?Id_exp=<?php echo $id_exp; ?>"><button type="button" class="btn btn-danger"><img src="https://img.icons8.com/fluency/48/000000/document.png"/><font id="letra"> Imprimir documentos</font></button></a>-->
                </div>
                
                  
             <br>
             
                  <!--<div class="col-sm">
                      <a type="submit" href="../cuenta_paciente/cuenta.php?id_atencion=<?php echo $id_atencion ?>" target="_blank"><button class="btn btn-danger"><img src="https://img.icons8.com/fluency/48/000000/document.png"/><font id="letra">Imprimir cuenta</font></button></a>
                  </div>-->
              </div>
              <hr>
    </div>

    <div>
<div class="container box">
    <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
         <tr><strong><center>DATOS DEL PACIENTE</center></strong>
      </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
<?php

$id_exp=$_GET['id_exp'];
$resultado=$conexion->query("SELECT * FROM paciente p, estados e, municipios m where p.Id_exp=$id_exp and p.id_edo=e.id_edo and p.id_mun=m.id_mun ") or die($conexion->error);

/*$resultado=$conexion->query("select paciente.*, estados.nombre, estado_nac.nom_est_nac, municipios.nombre_m
from paciente inner join estados 
on paciente.id_edo=estados.id_edo
inner join estado_nac on paciente.id_edo_nac=estado_nac.id_edo_nac
inner join municipios on paciente.id_mun=municipios.id_mun ORDER by Id_exp DESC LIMIT 1") or die($conexion->error);*/
while ($row1 = mysqli_fetch_array($resultado)) {
                            ?>
                        <label for="fecha">Fecha y hora:</label>
                        <input type="datetime" name="fecha" value="<?php echo $row1['fecha'] ?>" class="form-control" disabled>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="Id_exp">Expediente:</label>
                        <input type="text" value="<?php echo $row1['Id_exp'] ?>" name="Id_exp" placeholder="Expediente" id="Id_exp" class="form-control"
                               disabled>
                    </div>
                </div>
            </div>
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="curp">CURP:</label>
                            <input type="text" name="curp" placeholder="Curp" id="curp" class="form-control"
                                    value="<?php echo $row1['curp']?>"
                                   
                                   onkeypress="return Curp(event);" maxlength="18" minlength="18" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="papell">Primer apellido:</label>
                            <input type="text" name="papell" placeholder="APELLIDO PATERNO" id="papell"
                                   class="form-control"  value="<?php echo $row1['papell']?>"
                                   onkeypress="return SoloLetras(event);" maxlength="50"
                                    disabled>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="sapell">Segundo apellido:</label>
                            <input type="text" name="sapell" placeholder="APELLIDO MATERNO" id="sapell"
                                   class="form-control"  value="<?php echo $row1['sapell']?>"
                                   onkeypress="return SoloLetras(event);" maxlength="50"
                                    required disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="nom_pac">Nombre(s):</label>
                            <input type="text" name="nom_pac" placeholder="NOMBRES(s)" id="nom_pac" class="form-control"
                                    value="<?php echo $row1['nom_pac']?>" onkeypress="return SoloLetras(event);"
                                   maxlength="50" required disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="fecnac">Fecha de nacimiento:</label>
                    
                          <input type="date" value="<?php echo $row1['fecnac']?>" name="fecnac" placeholder="Fecha de nacimiento" id="fecnac"
                                   class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="edad">Edad:</label>
                            <input type="text" name="edad" placeholder="Edad" id="edad" class="form-control"
                                    value="<?php echo $row1['edad']?>"
                                   
                                   onkeypress="return SoloNumeros(event);" required maxlength="3" minlength="1" disabled>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Género:</label>
                            <input type="text" name="tip_san" id="tip_san" class="form-control" disabled value="<?php echo $row1['sexo'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Tipo de sangre:</label>
                            <input type="text" name="tip_san" id="tip_san" class="form-control" disabled value="<?php echo $row1['tip_san'] ?>">
                        </div>
                   
                    </div>
                </div>

                <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
            <label for="">Estado de residencia:</label>
            <input type="text" name="" class="form-control" value="<?php echo $row1['nombre'] ?>" disabled>
            
        </div>
    </div>
        <div class="col-sm-4">
            <div class="form-group ">
                <label for="">Municipio:</label>
                <input type="text" name="" class="form-control" value="<?php echo $row1['nombre_m'] ?>" disabled>
            </div>
             
        </div>
        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="loc">Localidad:</label>
                               <input type="text" name="loc" placeholder="Localidad" id="loc" class="form-control" required  value="<?php echo $row1['loc'] ?>" disabled>
                            </div>
                        </div>
    </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="dir">Dirección:</label>
                            <input type="text" name="dir" placeholder="Dirección" id="dir" class="form-control" required
                                 value="<?php echo $row1['dir'] ?>" maxlength="50"
                                    disabled>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="ocup">Ocupación:</label>
                            <input type="text" name="ocup" placeholder="Ocupación" id="ocup" class="form-control"
                                   required  value="<?php echo $row1['ocup'] ?>"
                                   onkeypress="return SoloLetras(event);" maxlength="50"
                                disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="tel">Teléfono:</label>
                            <input type="text" name="tel" value="<?php echo $row1['tel'] ?>" placeholder="Teléfono 10 digitos" id="tel"
                                   class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="religion">Religión:</label>
                            <input type="text" name="" value="<?php echo $row1['religion'] ?>" disabled class="form-control">
                            
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="edociv">Estado civil:</label>
                            <input type="text" name="" value="<?php echo $row1['edociv'] ?>" disabled class="form-control">
                            
                        </div>
                    </div>
               </div>
              <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
                      <tr><strong><center>DATOS DEL RESPONSABLE</center></strong>
              </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="resp">Nombre completo del responsable:</label>
                                <input type="text" name="resp" placeholder="Responsable" id="resp" class="form-control"
                                       required  value="<?php echo $row1['resp'] ?>"
                                        maxlength="40"
                                        disabled>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="paren">Parentesco: </label>
                                <input type="text" name="tip_san" id="tip_san" class="form-control" disabled value="<?php echo $row1['paren'] ?>">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="tel_resp">Teléfono:</label>
                                <input type="text" name="tel_resp" placeholder="Teléfono 10 digitos" id="tel_resp" value="<?php echo $row1['tel_resp'] ?>" 
                                       class="form-control" required disabled>
                            </div>

                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="dom_resp">Dirección del responsable:</label>
                                <input type="text" value="<?php echo $row1['dom_resp'] ?>" name="dom_resp" placeholder="Dirección del Responsable" id="dom_resp" class="form-control"  required disabled>
                            </div>
                        </div>
                    </div>
    <?php } ?>
            <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
         <tr><strong><center>HOJA FRONTAL</center></strong>
      </div>
 <?php
 $id_atencion=$_GET['id_atencion'];
$resultado1=$conexion->query("SELECT dat_ingreso.*, reg_usuarios.* from dat_ingreso inner join reg_usuarios on dat_ingreso.id_usua=reg_usuarios.id_usua where dat_ingreso.id_atencion=$id_atencion") or die($conexion->error);
        while ($row2=mysqli_fetch_array($resultado1)) {
                                               
                                    ?>
                         <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                  <label for="id_usua">Médico tratante:</label>
                    <input type="text" name="tip_san" id="tip_san" class="form-control" disabled value=" <?php echo $row2['papell']?> <?php echo $row2['sapell']?>">
                               
                                </div>
                              </div>

                                 <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="area">Área:</label>
         <input type="text" name="tip_san" id="tip_san" class="form-control" disabled value="<?php echo $row2['area']?>">
                                       
                                    </div>

                            </div>
</div>
                    <div class="row">
                              <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="motivo_atn">Diagnóstico:</label><br>
                                    <input type="text" name="motivo_atn" class="form-control" value="<?php echo $row2['motivo_atn']?>" placeholder="Diagnostico" required disabled > 

                                </div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label for="especialidad"> Tratamiento médico quirúrgico:</label>
                                <input type="text" name="especialidad" value="<?php echo $row2['especialidad']?>" class="form-control" placeholder="Tratamiento Médico" required disabled>
                              </div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label for="alergias"> Alergias:</label>
                                <input type="text" name="alergias" value="<?php echo $row2['alergias']?>" class="form-control" disabled placeholder="Alergias" required>
                              </div>
                            </div>
                            <?php } ?>
                            <div class="col-sm-5">
                                <div class="form-group">
<?php
$id_atencion=$_GET['id_atencion'];
     $res_dat = $conexion ->query("SELECT id_atencion FROM dat_ingreso WHERE id_atencion=$id_atencion")or die($conexion->error);
   if(mysqli_num_rows($res_dat) > 0 ){ //se mostrara si existe mas de 1
          $fila=mysqli_fetch_row($res_dat);
          $id_at=$fila[0];
          }
    $res_cam = $conexion ->query("SELECT num_cama,habitacion FROM cat_camas where id_atencion=$id_at ")or die($conexion->error);
    if(isset($res_cam)){
        if(mysqli_num_rows($res_cam) > 0 ){ //se mostrara si existe mas de 1
          $fila1=mysqli_fetch_row($res_cam);
          $numcam=$fila1[0];
          $hab=$fila1[1];
          }
      }else{
        $numcam='';
          $hab='';
      }
     
     if(isset($hab)){
     $res_serv = $conexion ->query("SELECT serv_desc FROM cat_servicios where id_serv=$hab")or die($conexion->error);
     if(mysqli_num_rows($res_serv) > 0 ){ //se mostrara si existe mas de 1
          $fila1=mysqli_fetch_row($res_serv);
          $tipo_serv=$fila1[0];
          }
}else{
    $tipo_serv=' Habitacion';
    $numcam='Sin';
}
                                          ?>
                                
                                    <label for="habitacion" >Habitación:</label>
     <input type="text" name="tip_san" id="tip_san" class="form-control" disabled value="<?php echo $numcam ?> <?php echo $tipo_serv?>">
                                
                                         
                                  
                                </div>
                              </div>
                      </div>
                      <div class="row">
                           <div class="col-sm-5">
                                <div class="form-group">
<?php
$id_atencion=$_GET['id_atencion'];
$resultado1=$conexion->query("SELECT dat_ingreso.*, reg_usuarios.*
from dat_ingreso inner join reg_usuarios on dat_ingreso.id_usua=reg_usuarios.id_usua where dat_ingreso.id_atencion=$id_atencion") or die($conexion->error);
        while ($row2=mysqli_fetch_array($resultado1)) {
                                               
                                    ?>
                                    <label for="tipo_a">Servicio:</label>
<input type="text" name="tip_san" id="tip_san" class="form-control" disabled value="<?php echo $row2['tipo_a'] ?>">
                                </div>
                            </div> <?php } ?>
                      </div>
                      
            <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
                      <tr><strong><center>DEPÓSITOS A LA CUENTA</center></strong>
            </div>
           
               <?php
    $resultadofin = $conexion->query("SELECT * FROM dat_financieros where id_atencion=$id_atencion") or die($conexion->error);
    while ($row3=mysqli_fetch_array($resultadofin)) {
     ?>
      <br><hr>
              <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">


                                    <label for="aseg">Aseguradora: </label><br>
 <input type="text" name="tip_san" id="tip_san" class="form-control" disabled value="<?php echo $row3['aseg'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="aval">Nombre completo:</label><br>
                                    <input type="text" name="aval" placeholder="Nombre del Aval" id="aval"
                                           value="<?php echo $row3['aval'] ?>" maxlength="40"
                                           onkeypress="return SoloLetras(event);" required
                                           class="form-control" disabled>
                                </div>
                            </div>                      
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="banco">Forma de pago:</label><br>
                                    <select name="banco" class="form-control" required disabled="">
                                        <option value=""><?php echo $row3['banco'] ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                             <div class="form-group">
                                    <label for="fec_deposito">Fecha:</label><br>
                                    <input type="date" name="fec_deposito" placeholder="Fecha de Desposito"
                                           id="fec_deposito"
                                           class="form-control" value="<?php echo $row3['fec_deposito'] ?>" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                             <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="deposito">Cantidad $</label><br>
                                    <input type="number" name="deposito" placeholder="Dep. inicial" id="deposito"
                                           value="<?php echo $row3['deposito'] ?>" maxlength="13" minlength="1" required
                                           class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="dep_l">Cantidad con letra:</label><br>
                                    <input type="text" name="dep_l" placeholder="Dep. con letra" id="dep_l"
                                            value="<?php echo $row3['dep_l'] ?>"maxlength="150" required
                                           class="form-control" disabled>
                                </div>
                            </div>
                        </div> 
                        <?php } ?>     
        </div>
</div><br>
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

    }
</script>
      
</body>


</html>