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

$usuario = $_SESSION['login'];

?>

<!DOCTYPE html>
<div>
    <head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
             <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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

    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>

     <link rel="stylesheet" href="../global_pac/css_busc/estilos2.css">
    <script src="../global_pac/js_busc/jquery.js"></script>
    <script src="../global_pac/js_busc/jquery.dataTables.min.js"></script>
        <title>NUEVO PACIENTE </title>

<script>
        function habilitar(value)
        {
            if(value=="HOSPITALIZACIÓN" || value=="CONSULTA" || value==true)
            {
                // habilitamos
                document.getElementById("cama").disabled=false;
            }else if(value=="TRIAGE"  || value==false){
                // deshabilitamos
                document.getElementById("cama").disabled=true;
            }
        }
    </script>
    <script>
            // Write on keyup event of keyword input element
            $(document).ready(function() {
                $("#search").keyup(function() {
                    _this = this;
                    // Show only matching TR, hide rest of them
                    $.each($("#mytable tbody tr"), function() {
                        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                            $(this).hide();
                        else
                            $(this).show();
                    });
                });
            });
        </script>
      <style type="text/css">
    #contenido{
        display: none;
    }
</style>

    </head>
<body>
   
       
     <div class="container">
        <a href="../gestion_pacientes/registro_pac.php" class="btn btn-danger btn-sm">Regresar</a>
       <hr>
       <?php if(isset($_GET['error'])){
?>          
    <div class="alert alert-danger alert-dismissible fade show col-sm-4" role="alert">
            <?php echo $_GET['error'];?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
            </div>
<?php }?>
      <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>DATOS DEL PACIENTE</center></strong>
      </div>
      <p>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <?php
                        
                        $fecha_actual = date("d-m-Y H:i:s");
                        ?>
                        <label for="fecha">Fecha y hora de registro:</label>
                        <input type="datetime" name="fecha" value="<?= $fecha_actual ?>" class="form-control" disabled>
                    </div>
                </div>
                <div class="col-sm">
                     <br>
    <input type="search" id="input-search" class="form-control" placeholder="Buscar paciente">
    <div class="content-search">
        <div class="content-table">
            <table id="table">
                <thead>
                    <tr>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                <?php
//SELECT p.*, d.* from paciente p, dat_ingreso d WHERE d.Id_exp=p.Id_exp order by p.Id_exp DESC

    $sql_diag="SELECT pa.*,da.* from paciente pa, dat_ingreso da where da.Id_exp=pa.Id_exp order by pa.Id_exp desc";

                $result_diag=$conexion->query($sql_diag);
                while($row = mysqli_fetch_array($result_diag)){
                    $nombre_rec=$row['nom_pac'].' '.$row['papell'].' '.$row['sapell'];
                    //$id_atencion=$row['id_atencion'];
                    ?>
                    <tr>
                        <td ><a href="../gestion_pacientes/vista_pacientet.php?id=<?php echo $row['Id_exp'] ?>&nombre=<?php echo $row['nom_pac'];?>&papell=<?php echo $row['papell']; ?>&sapell=<?php echo $row['sapell']; ?>" style="background:#2b2d7f; color:white;"><?php echo $nombre_rec ?></td>
                    </tr>
                    <?php
                }
         ?>
                </tbody>
            </table>
        </div>
    </div>
                    <div class="form-group">
                        <!--<label for="Id_exp">EXPEDIENTE:</label>-->
                        <input type="hidden" name="Id_exp" id="Id_exp" class="form-control" disabled>
                    </div>

                </div>
            </div>

    
            <form action="insertar_paciente.php?id_usu=<?php echo $usuario['id_usua'] ?>" method="POST" onsubmit="return checkSubmit();">
                <div class="row">

              <!--  <div class="col-sm-2">
                        <div class="form-group">
                            <label for="folio">Folio:</label>
                          <input type="number" name="folio" id="folio" class="form-control">
                        </div>
                    </div>-->


                    <!--<div class="col-sm-3">
                        <div class="form-group">
                            <label for="curp">CURP:</label>
                            <input type="text" name="curp" id="curp" class="form-control"
                                   style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();"
                                   onkeypress="return Curp(event);" maxlength="18" minlength="18">
                        </div>
                    </div>-->
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="papell">Primer apellido:</label>
                            <input type="text" name="papell"  id="papell" class="form-control" 
                                   placeholder="Apellido Paterno" 
                                   value="" onkeypress="return SoloLetras(event);" onkeypress="return SoloLetras(event);" style="text-transform:capitalize;"
                                   onkeyup="javascript:this.value=this.value.ucfirst();" 
                                    maxlength="50" required>
                        </div>

                    </div>
                    <div class="col-sm-4">
                       
                            <label for="sapell">Segundo apellido:</label>
                            <input type="text" name="sapell" id="sapell"
                                   class="form-control" 
                                   placeholder="Apellido Materno" 
                                   value="" onkeypress="return SoloLetras(event);" onkeypress="return SoloLetras(event);" style="text-transform:capitalize;"
                                   onkeyup="javascript:this.value=this.value.ucfirst();" 
                                   maxlength="50" required>
                       
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="nom_pac">Nombre (s):</label>
                            <input type="text" name="nom_pac" id="nom_pac" class="form-control"
                                   placeholder="Nombre del Paciente" 
                                   value="" onkeypress="return SoloLetras(event);" style="text-transform:capitalize;"
                                   onkeyup="javascript:this.value=this.value.ucfirst();"
                                   maxlength="50" required>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="row">
                    
                    
                    <div class="col-sm-3">
                        
                            <label for="fecnac">Fecha de nacimiento:</label>
                    
                          <input type="date" name="fecnac"  id="fecnac" class="form-control" required>
                        
                    </div>
             


 

                    <div class="col-sm-3">
                       
                            <label for="estado">Estado de nacimiento:</label>
                            <select id="estado" name="estado" class="form-control">
                                            <option value="" disabled selected>Selecciona el estado</option>
                                            <option value="AS">Aguascalientes</option>
                                            <option value="BC">Baja California</option>
                                            <option value="BS">Baja California Sur</option>
                                            <option value="CC">Campeche</option>
                                            <option value="CL">Coahuila</option>
                                            <option value="CM">Colima</option>
                                            <option value="CS">Chiapas</option>
                                            <option value="CH">Chihuahua</option>
                                            <option value="DF">Ciudad de México</option>
                                            <option value="DG">Durango</option>
                                            <option value="GT">Guanajuato</option>
                                            <option value="GR">Guerrero</option>
                                            <option value="HG">Hidalgo</option>
                                            <option value="JC">Jalisco</option>
                                            <option value="MC">Estado de México</option>
                                            <option value="MN">Michoac&aacute;n</option>
                                            <option value="MS">Morelos</option>
                                            <option value="NT">Nayarit</option>
                                            <option value="NL">Nuevo Le&oacute;n</option>
                                            <option value="OC">Oaxaca</option>
                                            <option value="PL">Puebla</option>
                                            <option value="QT">Quer&eacute;taro</option>
                                            <option value="QR">Quintana Roo</option>
                                            <option value="SP">San Luis Potos&iacute;</option>
                                            <option value="SL">Sinaloa</option>
                                            <option value="SR">Sonora</option>
                                            <option value="TC">Tabasco</option>
                                            <option value="TS">Tamaulipas</option>
                                            <option value="TL">Tlaxcala</option>
                                            <option value="VZ">Veracruz</option>
                                            <option value="YN">Yucat&aacute;n</option>
                                            <option value="ZS">Zacatecas</option>
                                            <option value="OT">Otros</option>

                                        </select>
                        
                    </div>
                     <div class="col-sm-3">
           
                            <label for="">Género:</label>
                            <select name="sexo" class="form-control" required>
                                <option value="">Seleccionar</option>
                                <option value="H">Hombre</option>
                                <option value="M">Mujer</option>
                                <option value="Se desconoce">Se desconoce</option>

                            </select>
                      
                        </div>
                </div>

                <div class="row">
<div class="col-sm-3">
                        <div class="form-group"><br>
                            <label for="dir">Dirección:</label>
                            <input type="text" name="dir"  id="dir" class="form-control" required
                                   placeholder="Domicilio del Paciente" style="text-transform:capitalize;"
                                   onkeyup="javascript:this.value=this.value.ucfirst();"
                                   value="" maxlength="100"
                                   >
                        </div>
                    </div>
                    <div class="col-sm">
                    <div class="form-group">
                        <?php
                        include("../../registro_pac.php")
                        ?>
</div>

                    </div>
                </div>
                <div class="row">
                    <!--   
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Tipo de Sangre:</label>
                            <select id="tip_san" class="form-control" name="tip_san" required>
                                <option value="">Seleccionar</option>
                                <option value="O Rh(-)">O Rh(-)</option>
                                <option value="O Rh(+)">O Rh(+)</option>
                                <option value="A Rh(-)">A Rh(-)</option>
                                <option value="A Rh(+)">A Rh(+)</option>
                                <option value="B Rh(-)">B Rh(-)</option>
                                <option value="B Rh(+)">B Rh(+)</option>
                                <option value="AB Rh(-)">AB Rh(-)</option>
                                <option value="AB Rh(+)">AB Rh(+)</option>
                                <option value="No especificado">No especificado</option>
                            </select>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="ocup">Ocupación</label>
                            <input type="text" name="ocup" id="ocup" class="form-control"
                                   required value=""
                                   onkeypress="return SoloLetras(event);" onkeypress="return SoloLetras(event);" style="text-transform:capitalize;"
                                   onkeyup="javascript:this.value=this.value.ucfirst();" maxlength="50" placeholder="Ocupación">
                        </div>
                    </div>-->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="tel">Teléfono del paciente:</label>
                            <input type="text" name="tel" id="tel" placeholder="Teléfono a 10 dígitos"       class="form-control" onkeypress="return SoloNumeros(event);"
                                   required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="religion">Religión:</label>
                            <select name="religion" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="Católica">Católica</option>
                                <option value="Católica">Cristiana</option>
                                <option value="Protestante">Protestante</option>
                                <option value="Testigo de Jehová">Testigo de Jehová</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="edociv">Estado civil:</label>
                            <select name="edociv" class="form-control" required>
                                <option value="">Seleccionar</option>
                                 <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Viudo">Viudo</option>
                                    <option value="Divorciado">Divorciado</option>
                                    <option value="Unión libre">Unión libre</option>
                            </select>
                        </div>
                    </div>

                    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                      <tr><strong><center>DATOS DEL RESPONSABLE</center></strong>
                    </div>
      <p>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="resp">Nombre completo:</label>
                                <input type="text" name="resp" id="resp" class="form-control"
                                       placeholder="Nombre completo del responsable" 
                                       required value=""
                                       onkeypress="return SoloLetras(event);" onkeypress="return SoloLetras(event);" style="text-transform:capitalize;"
                                   onkeyup="javascript:this.value=this.value.ucfirst();" maxlength="40">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="paren">Parentesco:</label>
                                <select name="paren" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Abuelo">Abuelo</option>
                                    <option value="Padre">Padre</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Tío">Tío</option>
                                    <option value="Esposo">Esposo</option>
                                    <option value="Esposa">Esposa</option>
                                    <option value="Hijo">Hijo</option>
                                    <option value="Hermano">Hermano</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="tel_resp">Teléfono:</label>
                                <input type="text" name="tel_resp" id="tel_resp"
                                       placeholder="Teléfono del responsable a 10 dígitos " 
                                       class="form-control" onkeypress="return SoloNumeros(event);" required>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="dom_resp">Dirección del responsable:</label>
                                <input type="text" placeholder="Domicilio del responsable" name="dom_resp" id="dom_resp" class="form-control" style="text-transform:capitalize;"
                                   onkeyup="javascript:this.value=this.value.ucfirst();" required >
                            </div>
                        </div>
                    </div>
    
                    <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                         <tr><strong><center>HOJA FRONTAL</center></strong>
                    </div>
                    <p>
                         <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                  <label for="id_usua">Médico tratante:</label>
                                <select name="id_usua" data-live-search="true" class="form-control" id="mibuscador2" onchange="mostrar(this.value);">
                                         <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                                          ?>
                                        <option value="" disabled="" selected="">Seleccionar</option>

                                        <?php foreach ($resultado1 as $opciones):?>
                                         <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
                                        
                                           <?php endforeach?>
                                          <option value="OTRO">Otros</option>
                                  </select>
                                </div>
                              </div>

 <div class="col-sm-5">
                                <div class="form-group">
                                  <label for="id_usua2">Médico tratante 2:</label>
                                <select name="id_usua2" data-live-search="true" class="form-control" id="mibuscador2" onchange="mostrar(this.value);">
                                         <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                                          ?>
                                        <option value="" disabled="" selected="">Seleccionar</option>

                                        <?php foreach ($resultado1 as $opciones):?>
                                         <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
  
                                           <?php endforeach?>
                                          
                                  </select>
                                </div>
                              </div>

 <div class="col-sm-5">
                                <div class="form-group">
                                  <label for="id_usua3">Médico tratante 3:</label>
                                <select name="id_usua3" data-live-search="true" class="form-control" id="mibuscador2" onchange="mostrar(this.value);">
                                         <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                                          ?>
                                        <option value="" disabled="" selected="">Seleccionar</option>

                                        <?php foreach ($resultado1 as $opciones):?>
                                         <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
  
                                           <?php endforeach?>
                                          
                                  </select>
                                </div>
                              </div>
 <div class="col-sm-5">
                                <div class="form-group">
                                  <label for="id_usua4">Médico tratante 4:</label>
                                <select name="id_usua4" data-live-search="true" class="form-control" id="mibuscador2" onchange="mostrar(this.value);">
                                         <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                                          ?>
                                        <option value="" disabled="" selected="">Seleccionar</option>

                                        <?php foreach ($resultado1 as $opciones):?>
                                         <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
  
                                           <?php endforeach?>
                                          
                                  </select>
                                </div>
                              </div>

 <div class="col-sm-5">
                                <div class="form-group">
                                  <label for="id_usua5">Médico tratante 5:</label>
                                <select name="id_usua5" data-live-search="true" class="form-control" id="mibuscador2" onchange="mostrar(this.value);">
                                         <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                                          ?>
                                        <option value="" disabled="" selected="">Seleccionar</option>

                                        <?php foreach ($resultado1 as $opciones):?>
                                         <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
  
                                           <?php endforeach?>
                                          
                                  </select>
                                </div>
                              </div>
                                 <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="area">Área:</label>
                                        <select name="area"class="form-control" required onchange="habilitar(this.value);" >
                                        <option value="">Seleccionar</option> 
                                        <option value="HOSPITALIZACIÓN">HOSPITALIZACIÓN</option>
                                        <!--<option value="QUIRÓFANO">AMBULATORIO</option>-->
                                        <option value="CONSULTA">CONSULTA</option>
                                        
                                        </select>
                                    </div>

                            </div>
</div>
<div class="container" id="contenido">
    <h5>Registro de nuevo médico </h5>
  <div class="row">
    
    <div class="col-sm-4">
       <label> Nombre completo:</label>
        <input type="text" name="papell_med" class="form-control" placeholder="Nombre completo" >
    </div>
   
 
</div> <hr> 
</div>

                    <div class="row">
                              <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="motivo_atn">Motivo de atención:</label><br>
                                    <input type="text" name="motivo_atn" class="form-control"  style="text-transform:capitalize;" onkeyup="javascript:this.value=this.value.ucfirst();" required placeholder="Motivo de atención"> 

                                </div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label for="especialidad"> Tratamiento en:</label>
                                
                                    <select name="especialidad" class="form-control" required onchange="habilitar(this.value);" >
                                        <option value="">Seleccionar</option> 
                                        <option value="HOSPITALIZACIÓN">HOSPITALIZACIÓN</option>
                                        <option value="QUIRÓFANO">QUIRÓFANO</option>
                                        <option value="CONSULTA">CONSULTA</option>
                                        <option value="AMBULATORIO">AMBULATORIO</option>
                                        <option value="ENDOSCOPIA">ENDOSCOPIA</option>
                                        <option value="OBSERVACIÓN">OBSERVACIÓN</option>
                                        </select>
                              </div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label for="alergias">Alergias:</label>
                                <input type="text" placeholder="Alergias del paciente" name="alergias" class="form-control" onkeypress="return SoloLetras(event);" style="text-transform:capitalize;"
                                   onkeyup="javascript:this.value=this.value.ucfirst();" onkeypress="return SoloLetras(event);" required >
                              </div>

                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                  <label for="habitacion" >Espacio de atención:</label>
                                <select id="cama" name="habitacion" class="form-control" disabled="" required >
                                         <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM cat_camas where estatus='LIBRE' order by num_cama ASC")or die($conexion->error);
                                          ?>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($resultado1 as $opciones):?>
                                         <option value="<?php echo $opciones['id']?>"><?php echo $opciones['num_cama']?> <?php echo $opciones ['estatus']?> <?php echo $opciones['tipo']?></option>
        
                                           <?php endforeach?>
                                  </select>
                                </div>
                              </div>
                      </div>
                      <div class="row">
                           <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="tipo_a">Servicio:</label>
                                    <select name="tipo_a" data-live-search="true" class="form-control" id="mibuscador3"required>
                                        <?php
                                $resultadoaseg = $conexion->query("SELECT * FROM cat_espec WHERE espec_activo='SI' ORDER BY espec ASC") or die($conexion->error);
                                ?>
                                <option value="">Seleccionar </option>
                                <?php foreach ($resultadoaseg as $opcionesaseg): ?>


                                    <option value="<?php echo $opcionesaseg['espec'] ?>"><?php echo $opcionesaseg['espec'] ?></option>

                                <?php endforeach ?>
                                    </select>
                                  <!--      <select name="tipo_a"class="form-control" required >
                                            <option value="">Seleccionar</option> 
                                            <option value="QUIRURGICO">QUIRÚRGICA</option>
                                            <option value="TRATAMIENTO MEDICO">TRATAMIENTO MÉDICO</option>
                                        </select> -->
                                </div>
                            </div>
                      </div>
                      
                      
                      <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                            <tr><strong><center>DATOS FINANCIEROS</center></strong>
                      </div>
      <p>
              <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="aseg">Aseguradora: </label><br>
                                    <select name="aseg" class="form-control" required>
                                        <?php
                                $resultadoaseg = $conexion->query("SELECT * FROM cat_aseg WHERE aseg_activo='SI' ORDER BY aseg ASC") or die($conexion->error);
                                ?>
                                <option value="">Seleccionar </option>
                                <?php foreach ($resultadoaseg as $opcionesaseg): ?>


                                    <option value="<?php echo $opcionesaseg['id_aseg'] ?>"><?php echo $opcionesaseg['aseg'] ?></option>

                                <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                                           
                        </div>
                  <!--      <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="dir_resp">DIRECCIÓN: </label><br>
                                    <input type="text" name="dir_resp" 
                                           id="dir_resp"
                                           placeholder="DIRECCIÓN DE QUIEN REALIZA EL DEPÓSITO" 
                                           style="text-transform:uppercase;" value=""
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" required
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="tel_rf">TELÉFONO: </label><br>
                                    <input type="text" name="tel_rf"  id="tel"
                                           placeholder="TELÉFONO DE QUIEN REALIZA EL DEPÓSITO" 
                                           style="text-transform:uppercase;" value=""maxlength="12" minlength="12" 
                                           onkeypress="return SoloNumeros(event);" 
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" 
                                           class="form-control">
                                </div>
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="banco">Forma de pago:</label><br>
                                    <select name="banco" class="form-control" required>
                                        <option value="">Seleccionar</option>
                                        <option value="EFECTIVO">EFECTIVO</option>
                                        <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                        <option value="DEPOSITO">DEPOSITO</option>
                                        <option value="TARJETA">TARJETA</option>
                                        <option value="ASEGURADORA">ASEGURADORA</option>
                                        <option value="OTROS">OTROS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="aval">Detalle:</label><br>
                                    <input type="text" name="aval" id="aval"
                                           placeholder="Banco, No. de tarjeta, etc."  value="" maxlength="60"
                                          style="text-transform:capitalize;"
                                   onkeyup="javascript:this.value=this.value.ucfirst();" class="form-control">
                                </div>
                            </div>    
                            <?php
                       
                        $fecha_actual = date("d-m-Y");

                        ?>
                            <div class="col-sm-5">
                             <div class="form-group">

                                    <label for="fec_deposito">Fecha:</label><br>
                                    <input type="text" name="fec_deposito" placeholder="Fecha de Desposito"

                                           id="fec_deposito"
                                           class="form-control" value="<?php echo $fecha_actual ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                 <div class="form-group">
                                    <label for="deposito">Cantidad $ (Número)</label><br>
                                    <input type="text" name="deposito"  id="deposito"
                                           maxlength="13" minlength="0" 
                                           onkeypress="return SoloNumeros(event);"  required
                                           class="form-control number">
                                </div>
                            </div>
                        </div>

                <div>
                </div>
                <hr> 
                <center>
                     <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="../gestion_pacientes/registro_pac.php" class="btn btn-danger">Cancelar</a>
                   

                </center>
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
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>

<script>
    document.querySelector('#id_estado').addEventListener('change', event => {
        fetch('../../municipios.php?id_estado=' + event.target.value)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Error en la respuesta');
                }//en if
                return res.json();
            })
            .then(datos => {
                let html = '<option value=""> Seleccionar municipio</option>';
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

<!--<script type="text/javascript">
const number = document.querySelector('.number');

function formatNumber (n) {
    n = String(n).replace(/\D/g, "");
  return n === '' ? n : Number(n).toLocaleString();
}
number.addEventListener('keyup', (e) => {
    const element = e.target;
    const value = element.value;
  element.value = formatNumber(value);
});

</script>-->
<script>document.oncontextmenu = function () {
        return false;
    }</script>

    <script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador2').select2();
    });
</script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador3').select2();
    });
</script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador4').select2();
    });
</script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador5').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>
<script type="text/javascript">
        function mostrar(value)
        {
            if(value=="OTRO" || value==true)
            {
                // habilitamos
                document.getElementById('contenido').style.display = 'block';
            }else if(value!="OTRO" || value==false){
                // deshabilitamos
                document.getElementById('contenido').style.display = 'none';
            }
        }
    </script>
 <SCRIPT LANGUAGE="JavaScript">
history.forward()
</SCRIPT>
<script type="text/javascript">
       enviando = false; //Obligaremos a entrar el if en el primer submit
    
    function checkSubmit() {
        if (!enviando) {
            enviando= true;
            return true;
        } else {
            //Si llega hasta aca significa que pulsaron 2 veces el boton submit
            alert("Guardando Paciente... Por favor espere...");
            return false;
        }
    }
</script>
</body>

<script src="../global_pac/js_busc/search.js"></script>
</html>