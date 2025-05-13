    <?php
    session_start();
    require "../../estados.php";
    include "../../conexionbd.php";
    include "../header_administrador.php";
    if( isset($_GET['Id_exp'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
        $id_exp=$_GET['Id_exp'];
           $id_atencion=$_GET['id_atencion'];
      $resultado = $conexion ->query("SELECT * FROM paciente p, dat_ingreso i WHERE p.Id_exp=".$_GET['Id_exp']." and i.id_atencion=".$_GET['id_atencion'] )or die($conexion->error);
      if(mysqli_num_rows($resultado) > 0 ){ //se mostrara si existe mas de 1
        $f=mysqli_fetch_row($resultado);

      }else{
        header("location: registro_pac.php"); //te regresa a la página principal
      }
    }else{
      header("location: registro_pac.php"); //te regresa a la página principal
    }
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
              <style type="text/css">
        #contenido{
            display: none;
        }
    </style>
        <title>EDITAR PACIENTE</title>
        <link rel="shortcut icon" href="logp.png">
    </head> 
    <body>
    <div class="container-fluid">
         <div class="row">
        <div class="col">
           Folio: <strong><?php echo $f[28];?></strong> 
           Paciente: <strong><?php echo $f[2];?>
          <?php echo $f[3];?>
          <?php echo $f[4];?></strong><br>
          
           Fecha de nacimiento:<strong> <?php  $date = date_create($f[5]);
     echo date_format($date,"d/m/Y");?></strong>
        </div>
      
      </div>
        <form action="" method="POST">
            <div class="row">       
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php
                            $Id_exp= $_GET['Id_exp'];
                            ?>
                            <input type="hidden" name="Id_exp" placeholder="EXPEDIENTE" id="Id_exp" class="form-control" value="<?php echo $Id_exp ?>" 
                                   disabled>
                        </div>
                    </div>
             </div>
             <div>
                <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                    <tr><strong><center>DATOS DEL PACIENTE</center></strong>
                </div>
            </div>
                        <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="curp">Curp:</label>
                                <input type="text" name="curp" placeholder="CURP" id="curp" class="form-control"
                                        value="<?php echo $f[1];?>"
                                       
                                       onkeypress="return Curp(event);" maxlength="18" minlength="18">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="papell">Primer apellido:</label>
                                <input type="text" name="papell"  id="papell"
                                       placeholder="APELLIDO PATERNO"
                                       class="form-control" value="<?php echo $f[2];?>"
                                       onkeypress="return SoloLetras(event);" maxlength="50"
                                        required>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="sapell">Segundo apellido:</label>
                                <input type="text" name="sapell"  id="sapell"
                                       class="form-control" value="<?php echo $f[3];?>"
                                       onkeypress="return SoloLetras(event);" maxlength="50"
                                        required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nom_pac">Nombre(s):</label>
                                <input type="text" name="nom_pac"  id="nom_pac" class="form-control"
                                        value="<?php echo $f[4];?>" onkeypress="return SoloLetras(event);" maxlength="50" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="fecnac">Fecha de nacimiento:</label>
                        
                              <input type="date" name="fecnac" value="<?php echo $f[5];?>" id="fecnac"
                                       class="form-control" required>
                            </div>
                        </div>
                    
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Género:</label>
                                <select name="sexo" class="form-control"  required>
                                    <option value="<?php echo $f[8];?>"><?php echo $f[8];?> </option>
                                    <option value="">Seleccionar género</option>
                                    <option value="HOMBRE">Hombre</option>
                                    <option value="MUJER">Mujer</option>
                                    <option value="SIN INFORMACION">Sin información</option>

                                </select>
                            </div>
                        </div>
                      <!--  <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Tipo de sangre:</label>
                                <select id="tip_san" class="form-control" name="tip_san" required>
                                    <option value="<?php echo $f[9];?>"><?php echo $f[9];?> </option>
                                    <option value="">Seleccionar tipo de sangre</option>
                                    <option value="O Rh(-)">O Rh(-)</option>
                                    <option value="O Rh(+)">O Rh(+)</option>
                                    <option value="A Rh(-)">A Rh(-)</option>
                                    <option value="A Rh(+)">A Rh(+)</option>
                                    <option value="B Rh(-)">B Rh(-)</option>
                                    <option value="B Rh(+)">B Rh(+)</option>
                                    <option value="AB Rh(-)">AB Rh(-)</option>
                                    <option value="AB Rh(+)">AB Rh(+)</option>
                                    <option value="NO ESPECIFICADO">No especificado</option>
                                </select>

                            </div>
                        </div>-->
                    
                        
                     <!--   <div class="col-sm-4">
                            <div class="form-group">
                                <label for="ocup">Ocupación:</label>
                                <input type="text" name="ocup" id="ocup" class="form-control"
                                       required  value="<?php echo $f[15];?>"
                                       onkeypress="return SoloLetras(event);" maxlength="50"
                                       >
                            </div>
                        </div>-->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="tel">Teléfono:</label>
                                <input type="text" name="tel" value="<?php echo $f[16];?>" id="tel"
                                       class="form-control" onkeypress="return SoloNumeros(event);"
                                        required>
                            </div>
                        </div>
                   
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="religion">Religión:</label>
                                <select name="religion" class="form-control">
                                    <option value="<?php echo $f[19];?>"><?php echo $f[19];?></option>
                                    <option value="">Seleccionar religón</option>
                                    <option value="Católico">Católico</option>
                                    <option value="Cristiano">Cristiano</option>
                                    <option value="Protestante">Protestante</option>
                                    <option value="Testigo de Jehová">Testigo de jehová</option>
                                    <option value="Otra">Otra</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="edociv">Estado civil:</label>
                                <select name="edociv" class="form-control" required>
                                    <option value="<?php echo $f[21];?>"><?php echo $f[21];?></option>
                                    <option value="">Seleccionar estado civil</option>
                                    <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Viudo">Viudo</option>
                                    <option value="Divorciado">Divorciado</option>
                                    <option value="Unión libre">Unión libre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="dir">Dirección:</label>
                                <input type="text" name="dir" id="dir" class="form-control" required
                                        value="<?php echo $f[14];?>" maxlength="150"
                                       >
                            </div>
                        </div>

                    </div>
                     <hr> <div>
                        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                          <tr><strong><center>DATOS DEL RESPONSABLE</center></strong>
                        </div>
                        </div><hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="resp">Nombre completo del responsable:</label>
                                    <input type="text" name="resp" placeholder="RESPONSABLE" id="resp" class="form-control"
                                           required  value="<?php echo $f[22];?>"
                                           onkeypress="return SoloLetras(event);" maxlength="40"
                                           >
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="paren">Parentesco: </label>
                                    <select name="paren" class="form-control" required>
                                        <option value="<?php echo $f[23];?>"><?php echo $f[23];?></option>
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
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="tel_resp">Teléfono:</label>
                                    <input type="text" name="tel_resp" 
                                    value="<?php echo $f[24];?>" id="tel_resp"
                                           class="form-control" onkeypress="return SoloNumeros(event);" required>
                                </div>
                            </div>
                        </div>
                    
                             <div class="col-sm">
                                <div class="form-group">
                                    <label for="dom_resp">Dirección del responsable:</label>
                                    <input type="text" placeholder="DOMICILIO DEL RESPONSABLE" value="<?php echo $f[25];?>" name="dom_resp" id="dom_resp" class="form-control" required >
                                </div>
                            </div>
                     
    <?php 
    $ingreso="SELECT * FROM dat_ingreso where id_atencion=$id_atencion";
    $ingresoR=$conexion->query($ingreso);
    while ($row=$ingresoR->fetch_assoc()) {
        $med=$row['id_usua'];
         $med2=$row['id_usua2'];
          $med3=$row['id_usua3'];
           $med4=$row['id_usua4'];
            $med5=$row['id_usua5'];
            
     ?>
                        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                             <tr><strong><center>HOJA FRONTAL</center></strong>
                        </div><p>
                             <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <?php 
                                         $medico="";
                                           $usuario="SELECT * FROM reg_usuarios where id_usua=$med";
                                            $usua=$conexion->query($usuario);
                                            while ($rowu=$usua->fetch_assoc()) {
                                            $medico=$rowu['papell'].' '.$rowu['sapell'];
                                            }
                                         ?>
                                      <label for="id_usua">Médico tratante:</label>
                                    <select name="id_usua" data-live-search="true" class="form-control" id="mibuscador2" onchange="mostrar(this.value);">
                                        <option value="<?php echo $row['id_usua'] ?>"><?php echo $medico ?></option>
                                        <option></option>
                                             <?php
                                             $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where (id_rol=2 or id_rol=12) and 
                                             u_activo = 'SI' ORDER BY papell ASC ")or die($conexion->error);
                                              ?>
                                            <option value="" disabled="">Seleccionar médico</option>

                                            <?php foreach ($resultado1 as $opciones):?>
                                             <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
      
                                               <?php endforeach?>
                                               <option value="OTRO">Otros</option>
                                      </select>
                                    </div>
                                  </div>
<div class="col-sm-5">
                                    <div class="form-group">
                                        <?php
                                         $medico2=""; 
                                           $usuario2="SELECT * FROM reg_usuarios where id_usua=$med2";
                                            $usua2=$conexion->query($usuario2);
                                            while ($rowu2=$usua2->fetch_assoc()) {
                                            $medico2=$rowu2['papell'].' '.$rowu2['sapell'];
                                            }
                                         ?>
                                      <label for="id_usua2">Médico tratante 2:</label>
                                    <select name="id_usua2" data-live-search="true" class="form-control" id="mibuscador2">
                                        <option value="<?php echo $med2 ?>"><?php echo $medico2 ?></option>
                                        <option></option>
                                             <?php
                                             $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where (id_rol=2 or id_rol=12) and 
                                             u_activo = 'SI' ORDER BY papell ASC")or die($conexion->error);
                                              ?>
                                            <option value="" disabled="">Seleccionar médico</option>

                                            <?php foreach ($resultado1 as $opciones):?>
                                             <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
      
                                               <?php endforeach?>
                                            
                                      </select>
                                    </div>
                                  </div>

<div class="col-sm-5">
                                    <div class="form-group">
                                        <?php 
                                        $medico3="";
                                           $usuario3="SELECT * FROM reg_usuarios where id_usua=$med3";
                                            $usua3=$conexion->query($usuario3);
                                            while ($rowu3=$usua3->fetch_assoc()) {

                                            $medico3=$rowu3['papell'].' '.$rowu3['sapell'];
                                            }
                                         ?>
                                      <label for="id_usua3">Médico tratante 3:</label>
                                    <select name="id_usua3" data-live-search="true" class="form-control" id="mibuscador2">
                                        <option value="<?php echo $med3;?>"><?php echo $medico3; ?></option>
                                        <option></option>
                                             <?php
                                             $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where (id_rol=2 or id_rol=12) and 
                                             u_activo = 'SI' ORDER BY papell ASC")or die($conexion->error);
                                              ?>
                                            <option value="" disabled="">Seleccionar médico</option>

                                            <?php foreach ($resultado1 as $opciones):?>
                                             <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
      
                                               <?php endforeach?>
                                            
                                      </select>
                                    </div>
                                  </div>

<div class="col-sm-5">
                                    <div class="form-group">
                                        <?php 
                                        $medico4="";
                                           $usuario4="SELECT * FROM reg_usuarios where id_usua=$med4";
                                            $usua4=$conexion->query($usuario4);
                                            while ($rowu4=$usua4->fetch_assoc()) {

                                            $medico4=$rowu4['papell'].' '.$rowu4['sapell'];
                                            }
                                         ?>
                                      <label for="id_usua4">Médico tratante 4:</label>
                                    <select name="id_usua4" data-live-search="true" class="form-control" id="mibuscador2">
                                        <option value="<?php echo $med4;?>"><?php echo $medico4; ?></option>
                                        <option></option>
                                             <?php
                                             $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where (id_rol=2 or id_rol=12) and 
                                             u_activo = 'SI' ORDER BY papell ASC")or die($conexion->error);
                                              ?>
                                            <option value="" disabled="">Seleccionar médico</option>

                                            <?php foreach ($resultado1 as $opciones):?>
                                             <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
      
                                               <?php endforeach?>
                                            
                                      </select>
                                    </div>
                                  </div>


<div class="col-sm-5">
                                    <div class="form-group">
                                        <?php 
                                        $medico5="";
                                           $usuario5="SELECT * FROM reg_usuarios where id_usua=$med5";
                                            $usua5=$conexion->query($usuario5);
                                            while ($rowu5=$usua5->fetch_assoc()) {

                                            $medico5=$rowu5['papell'].' '.$rowu5['sapell'];
                                            }
                                         ?>
                                      <label for="id_usua5">Médico tratante 5:</label>
                                    <select name="id_usua5" data-live-search="true" class="form-control" id="mibuscador2">
                                        <option value="<?php echo $med5;?>"><?php echo $medico5; ?></option>
                                        <option></option>
                                             <?php
                                             $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where (id_rol=2 or id_rol=12) and 
                                             u_activo = 'SI' ORDER BY papell ASC")or die($conexion->error);
                                              ?>
                                            <option value="" disabled="">Seleccionar médico</option>

                                            <?php foreach ($resultado1 as $opciones):?>
                                             <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
      
                                               <?php endforeach?>
                                            
                                        </select>
                                        </div>
                                    </div>
                                    

    </div>
    <div class="container" id="contenido">
        <h5>NUEVO MEDICO (DATOS)</h5>
      <div class="row">
    
        <div class="col-sm-4">
            <label>Nombre completo:</label>
            <input type="text" name="nom_med" class="form-control" placeholder="Nombre completo" >
        </div>
    </div> <hr> 
    </div>

                        <div class="row">
                                  <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="motivo_atn">Motivo de atención:</label><br>
                                        <input type="text" name="motivo_atn" class="form-control" value="<?php echo $row['motivo_atn'] ?>"  onkeypress="return SoloLetras(event);"  required > 

                                    </div>
                                </div>
                               
                                <div class="col-sm-5">
                                  <div class="form-group">
                                    <label for="alergias"> Alergias:</label>
                                    <input type="text" placeholder="ALERGÍAS QUE TIENE EL PACIENTE" value="<?php echo $row['alergias'] ?>" name="alergias" class="form-control" onkeypress="return SoloLetras(event);" required >
                                  </div>

                                </div>
                           <!--     <div class="col-sm-5">
                                    <div class="form-group">
                                      <label for="habitacion" >HABITACIÓN:</label>
                                    <select id="cama" name="habitacion" class="form-control"  required >
                                        <?php
                                        $atencion="SELECT id_atencion FROM dat_ingreso where Id_exp=$id_exp";
    $result=$conexion->query($atencion);
    while ($row_at=$result->fetch_assoc()) {
        $id_atencion=$row_at['id_atencion'];
    }
    $resultado1 = $conexion ->query("SELECT * FROM cat_camas where id_atencion=$id_atencion")or die($conexion->error);
    while ($row_cama=$resultado1->fetch_assoc()) {
        $cama=$row_cama['id'];
        $num_cama=$row_cama['num_cama'];
        $tipo=$row_cama['tipo'];
    ?>
                                        <option value="<?php// echo $row_cama['id']; ?>"><?php// echo $num_cama.':'.$tipo ?></option>
                                    <?php } ?>
                                        <option></option>
    <?php
    $resultado1 = $conexion ->query("SELECT * FROM cat_camas where estatus='LIBRE' AND tipo!='URGENCIAS' order by num_cama ASC")or die($conexion->error);
    ?>
                                            <option value="">SELECCIONAR HABITACIÓN</option>
                                            <?php foreach ($resultado1 as $opciones):?>
                                             <option value="<?php //echo $opciones['id']?>"><?php //echo $opciones['num_cama']?> <?php// echo $opciones ['estatus']?> <?php //echo $opciones['tipo']?></option>
            
                                               <?php endforeach?>
                                      </select>
                                    </div>
                                  </div>-->
                          </div>
                          <div class="row">
                              <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="tipo_a">Especialidad:</label>
                                        <select name="tipo_a" class="form-control" required>
                                            <?php
                                            $tipo_a=$row['tipo_a'];
                                    $resultadoaseg = $conexion->query("SELECT * FROM cat_espec WHERE espec_activo='SI' and espec!='$tipo_a'") or die($conexion->error);

                                    ?>
                                    <option value="<?php echo $row['tipo_a'] ?>"><?php echo $row['tipo_a'] ?></option>
                                    <option></option>
                                    <option value="" disabled="">Seleccionar </option>
                                    <?php foreach ($resultadoaseg as $opcionesaseg): ?>


                                        <option value="<?php echo $opcionesaseg['espec'] ?>"><?php echo $opcionesaseg['espec'] ?></option>

                                    <?php endforeach ?>
                                        </select>
                                      <!--      <select name="tipo_a"class="form-control" required >
                                                <option value="">SELECCIONAR</option> 
                                                <option value="QUIRURGICO">QUIRÚRGICA</option>
                                                <option value="TRATAMIENTO MEDICO">TRATAMIENTO MÉDICO</option>
                                            </select> -->
                                    </div>
                                </div>
                          </div>
                          <?php } ?>
                          <?php 
    $finan="SELECT * FROM dat_financieros df, dat_ingreso d where df.id_atencion=d.id_atencion and d.Id_exp=$id_exp ORDER by id_datfin ASC LIMIT 1";
    $finanR=$conexion->query($finan);
    while ($row=$finanR->fetch_assoc()) {
        $med=$row['id_usua'];
     ?>
                          <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                                <tr><strong><center>DEPÓSITOS A LA CUENTA</center></strong>
                          </div>
          
                  <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="aseg">ASEGURADORA: </label><br>
                                        <select name="aseg" class="form-control" required>
                                            <?php
                                    $resultadoaseg = $conexion->query("SELECT * FROM cat_aseg WHERE aseg_activo='SI'") or die($conexion->error);
                                    ?>
                                    <option value="<?php echo $row['aseg'] ?>"><?php echo $row['aseg'] ?></option>
                                    <option></option>
                                    <option value="" disabled="">SELECCIONAR </option>
                                    <?php foreach ($resultadoaseg as $opcionesaseg): ?>


                                        <option value="<?php echo $opcionesaseg['aseg'] ?>"><?php echo $opcionesaseg['aseg'] ?></option>

                                    <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                              <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="aval">NOMBRE COMPLETO:</label><br>
                                        <input type="text" name="aval" id="aval"
                                               placeholder="NOMBRE COMPLETO DE QUIEN REALIZA EL DEPÓSITO" value="<?php echo $row['aval'] ?>" value="" maxlength="40"
                                               onkeypress="return SoloLetras(event);" 
                                                required
                                               class="form-control">
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
                                        <label for="banco">FORMA DE PAGO:</label><br>
                                        <select name="banco" class="form-control" required>
                                            <option value="<?php echo $row['banco'] ?>"> <?php echo $row['banco'] ?></option>
                                            <option></option>
                                            <option value="">Seleccionar</option>
                                            <option value="EFECTIVO">EFECTIVO</option>
                                            <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                            <option value="DEPOSITO">DEPOSITO</option>
                                            <option value="TARJETA">TARJETA</option>
                                            <option value="ASEGURADORA">ASEGURADORA</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>




                            <div class="row">
                                 <div class="col-sm-5">
                                     <div class="form-group">
                                        <label for="deposito">CANTIDAD $</label><br>
                                        <input type="text" name="deposito"  id="deposito"
                                               maxlength="13" minlength="1" value="<?php echo $row['deposito'] ?>"
                                               onkeypress="return SoloNumeros(event);" 
                                               onkeyup="javascript:this.value=this.value.toUpperCase();" required
                                               class="form-control number">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="dep_l">CANTIDAD CON LETRA:</label><br>
                                        <input type="text" name="dep_l"  id="dep_l"
                                                value="<?php echo $row['dep_l'] ?>" maxlength="150" 
                                               onkeypress="return SoloLetras(event);" 
                                                required
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <?php } ?>                  
                    <div>
                    </div>
                        </div>

                   <center>
                        <button type="submit" name="guardar" class="btn btn-success">GUARDAR</button>
                        <a href="../gestion_pacientes/registro_pac.php" class="btn btn-danger">CANCELAR</a>
                   </center><br>
        </form>      
    </div>

          <?php

          if (isset($_POST['guardar'])) {
    $usuario=$_SESSION['login'];
    $id_usu=$usuario['id_usua'];

    $atencion="SELECT id_atencion FROM dat_ingreso where Id_exp=$id_exp";
    $result=$conexion->query($atencion);
    while ($row=$result->fetch_assoc()) {
        $id_atencion=$row['id_atencion'];
    }
    /*paciente*/
            $curp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["curp"], ENT_QUOTES))); //Escanpando caracteres
            $papell    = mysqli_real_escape_string($conexion, (strip_tags($_POST["papell"], ENT_QUOTES))); //Escanpando caracteres
            $sapell   = mysqli_real_escape_string($conexion, (strip_tags($_POST["sapell"], ENT_QUOTES))); //Escanpando caracteres
            $nom_pac    = mysqli_real_escape_string($conexion, (strip_tags($_POST["nom_pac"], ENT_QUOTES))); //Escanpando caracteres
              $fecnac    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecnac"], ENT_QUOTES)));
             // $edad    = mysqli_real_escape_string($conexion, (strip_tags($_POST["edad"], ENT_QUOTES)));
              $sexo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["sexo"], ENT_QUOTES)));

              $tip_san    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tip_san"], ENT_QUOTES)));
               $ocup    = mysqli_real_escape_string($conexion, (strip_tags($_POST["ocup"], ENT_QUOTES)));
              $religion    = mysqli_real_escape_string($conexion, (strip_tags($_POST["religion"], ENT_QUOTES)));
              $dir    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dir"], ENT_QUOTES)));
              $tel    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel"], ENT_QUOTES)));
              $edociv    = mysqli_real_escape_string($conexion, (strip_tags($_POST["edociv"], ENT_QUOTES)));
              $resp   = mysqli_real_escape_string($conexion, (strip_tags($_POST["resp"], ENT_QUOTES)));
              $paren    = mysqli_real_escape_string($conexion, (strip_tags($_POST["paren"], ENT_QUOTES)));
              $tel_resp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel_resp"], ENT_QUOTES)));
              $dom_resp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dom_resp"], ENT_QUOTES)));
    /*ingreso*/
           $id_usua= mysqli_real_escape_string($conexion, (strip_tags($_POST["id_usua"], ENT_QUOTES)));

$id_usua2 = mysqli_real_escape_string($conexion, (strip_tags($_POST["id_usua2"], ENT_QUOTES)));
$id_usua3 = mysqli_real_escape_string($conexion, (strip_tags($_POST["id_usua3"], ENT_QUOTES)));
$id_usua4 = mysqli_real_escape_string($conexion, (strip_tags($_POST["id_usua4"], ENT_QUOTES)));
$id_usua5 = mysqli_real_escape_string($conexion, (strip_tags($_POST["id_usua5"], ENT_QUOTES)));


            //$area    = mysqli_real_escape_string($conexion, (strip_tags($_POST["area"], ENT_QUOTES))); //Escanpando caracteres
            $motivo_atn   = mysqli_real_escape_string($conexion, (strip_tags($_POST["motivo_atn"], ENT_QUOTES))); //Escanpando caracteres
          
              $alergias    = mysqli_real_escape_string($conexion, (strip_tags($_POST["alergias"], ENT_QUOTES)));
    /*if ($_POST['habitacion']) {
        $id_cam    = mysqli_real_escape_string($conexion, (strip_tags($_POST["habitacion"], ENT_QUOTES)));
    }*/

              $tipo_a    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo_a"], ENT_QUOTES)));
    /*nuevo doc*/
    //$papell_med    = mysqli_real_escape_string($conexion, (strip_tags($_POST["papell_med"], ENT_QUOTES))); //Escanpando caracteres
    //$sapell_med    = mysqli_real_escape_string($conexion, (strip_tags($_POST["sapell_med"], ENT_QUOTES))); //Escanpando caracteres
    $nom_med   = mysqli_real_escape_string($conexion, (strip_tags($_POST["nom_med"], ENT_QUOTES))); //Escanpando caracteres
    /*financieros*/     
             $aseg    = mysqli_real_escape_string($conexion, (strip_tags($_POST["aseg"], ENT_QUOTES))); //Escanpando caracteres
            $aval    = mysqli_real_escape_string($conexion, (strip_tags($_POST["aval"], ENT_QUOTES))); //Escanpando caracteres
            $banco   = mysqli_real_escape_string($conexion, (strip_tags($_POST["banco"], ENT_QUOTES))); //Escanpando caracteres
              $deposito    = mysqli_real_escape_string($conexion, (strip_tags($_POST["deposito"], ENT_QUOTES)));
             // $edad    = mysqli_real_escape_string($conexion, (strip_tags($_POST["edad"], ENT_QUOTES)));
              $dep_l    = mysqli_real_escape_string($conexion, (strip_tags($_POST["dep_l"], ENT_QUOTES)));

     function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
        $bisiesto=true;
        return $bisiesto;
 }

 function calculaedad($fecnac)
 {

$fecha_actual = date("Y-m-d H:i:s");
$fecha_nac=$fecnac;
$fecha_de_nacimiento =strval($fecha_nac);

// separamos en partes las fechas
$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
$array_actual = explode ( "-", $fecha_actual );

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

//ajuste de posible negativo en $días
if ($dias < 0)
{
    --$meses;

    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
    switch ($array_actual[1]) {
           case 1:     $dias_mes_anterior=31; break;
           case 2:     $dias_mes_anterior=31; break;
           case 3:     
               if (bisiesto($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
               
           case 4:     $dias_mes_anterior=31; break;
           case 5:     $dias_mes_anterior=30; break;
           case 6:     $dias_mes_anterior=31; break;
           case 7:     $dias_mes_anterior=30; break;
           case 8:     $dias_mes_anterior=31; break;
           case 9:     $dias_mes_anterior=31; break;
           case 10:    $dias_mes_anterior=30; break;
           case 11:    $dias_mes_anterior=31; break;
           case 12:    $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

 if($anos > "0" ){
   $edad = $anos." años";
}elseif($anos <="0" && $meses>"0"){
   $edad = $meses." meses";
    
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    $edad = $dias." días";
}

 return $edad;
}


$edad = calculaedad($fecnac);
                if ($edad< 0) {
                    $edad = '0';
                }

              $sql_paciente = "UPDATE paciente SET curp='$curp', papell='$papell', sapell='$sapell', nom_pac='$nom_pac', fecnac='$fecnac', edad='$edad' , sexo='$sexo', tip_san='$tip_san', dir='$dir', ocup='$ocup', tel='$tel', religion='$religion', edociv='$edociv', resp='$resp', paren='$paren', tel_resp='$tel_resp', dom_resp='$dom_resp' WHERE Id_exp= $Id_exp";
            $result_paciente = $conexion->query($sql_paciente);

    if($id_usua=="OTRO"){
    //$papell_med    = mysqli_real_escape_string($conexion, (strip_tags($_POST["papell_med"], ENT_QUOTES))); //Escanpando caracteres
    //$sapell_med    = mysqli_real_escape_string($conexion, (strip_tags($_POST["sapell_med"], ENT_QUOTES))); //Escanpando caracteres
    $nom_med   = mysqli_real_escape_string($conexion, (strip_tags($_POST["nom_med"], ENT_QUOTES))); //Escanpando caracteres
    $ingresar_usu = mysqli_query($conexion, 'insert into reg_usuarios(nombre,papell,sapell,id_rol) values("'.$nom_med.'","2")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


    $buscar = $conexion ->query("SELECT id_usua FROM reg_usuarios ORDER by id_usua DESC LIMIT 1")or die($conexion->error);
    while ($row= $buscar->fetch_assoc()) {
      $id_usua=$row['id_usua'];
    }

    }

    /* if(isset($id_cam)){
              //// update de  camas id_atencion
          $sql2 = "UPDATE cat_camas SET estatus = 'OCUPADA', id_atencion= $id_atencion WHERE id = $id_cam";
          $result = $conexion->query($sql2);

                ///// tomar el registro de camas  habitacion y id_atencion
          $resultado3 = $conexion ->query("SELECT habitacion, id_atencion FROM cat_camas WHERE id = $id_cam ")or die($conexion->error);

      if(mysqli_num_rows($resultado3) > 0 ){ //se mostrara si existe mas de 1
          $f3=mysqli_fetch_row($resultado3);
          $habitacion=$f3[0];
          $id_at=$f3[1];
      }else{header("Location: ../registro_pac.php"); //te regresa a la página principal
       } 

                //// ingresar habitacion en insumo y id_atencion en id_atencion de la tabla dat_ctapac 

               
    $fecha_actual = date("Y-m-d H:i:s");     
      $ingresar3=mysqli_query($conexion,'insert into dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,id_usua) values ('.$id_at.',"S","'.$habitacion.'","'.$fecha_actual.'","1",'.$id_usu.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion)); 
      
      $sql3 = "UPDATE dat_ingreso SET cama='1' WHERE id_atencion = $id_at";
          $result = $conexion->query($sql3);
    } 
    if($area=="TRIAGE"){
     
    $fecha_actual = date("Y-m-d H:i:s");
     $ingresar3=mysqli_query($conexion,'insert into dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,id_usua) values ('.$id_at.',"S","8","'.$fecha_actual.'","1",'.$id_usu.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

    }

    if($area=="QUIROFANO"){
       
    $fecha_actual = date("Y-m-d H:i:s");
     $ingresar4=mysqli_query($conexion,'insert into dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,id_usua) values ('.$id_at.',"S","5","'.$fecha_actual.'","1",'.$id_usu.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));
    }

    $sql_diagnostico = "UPDATE diag_pac SET id_usua='$id_usua', diag_paciente='$motivo_atn' WHERE Id_exp= $id_atencion ORDER BY id_diag ASC LIMIT 1";
            $result_diagnostico = $conexion->query($sql_diagnostico);*/

              $sql_ingreso = "UPDATE dat_ingreso SET id_usua='$id_usua', motivo_atn='$motivo_atn', alergias='$alergias', tipo_a='$tipo_a',aseg='$aseg',id_usua2='$id_usua2',id_usua3='$id_usua3',id_usua4='$id_usua4',id_usua5='$id_usua5' WHERE id_atencion= $id_atencion";
            $result_ingreso = $conexion->query($sql_ingreso);


            $sql_financieros = "UPDATE dat_financieros SET aseg='$aseg',  resp='$resp', aval='$aval', banco='$banco', deposito='$deposito', dep_l='$dep_l' WHERE id_atencion= $id_atencion ORDER BY id_datfin ASC LIMIT 1";
            $result_finan = $conexion->query($sql_financieros);

            echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
            echo '<script type="text/javascript">window.location ="registro_pac.php"</script>';
          }
          ?>


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

    <script>document.oncontextmenu = function () {
            return false;
        }</script>

    </body> 
    </html>  