<?php
session_start();
require "../../estados.php";
include "../../conexionbd.php";
include "../../gestion_administrativa/header_administrador.php";

$usuario = $_SESSION['login'];



$id_expp=$_GET['id'];
$nom=$_GET['nombre'];
$papell=$_GET['papell'];
$sapell=$_GET['sapell'];


?>


<!DOCTYPE html>
<div>

    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />


        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
        </script>
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

        <title>Nuevo Paciente </title>
        <link rel="shortcut icon" href="logp.jpg">




        <style type="text/css">
        #contenido {
            display: none;
        }

        .thead {
            background-color: #2b2d7f;
            color: white;
            font-size: 22px;
            padding: 10px;
            text-align: center;
        }
        </style>
    </head>
    <div class="container">
        <div class="row">
            <div class="col-sm-1">
                <a href="../global_pac/pac_global.php" class="btn btn-danger btn-sm">Regresar</a>
            </div>
            <div class="col-sm-4">
                <form action="" method="POST">

            </div>
        </div>
    </div>

    <p>
    <div>
        
        <div class="container">
            <div class="thead">
            <strong>
                <center>DATOS DEL PACIENTE</center>
            </strong>
        </div>
            <div class="container-fluid">
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <?php
$resultado=$conexion->query("SELECT * FROM paciente p, estados e, municipios m where p.id_edo=e.id_edo and p.id_mun=m.id_mun and p.Id_exp=$id_expp ORDER by Id_exp DESC LIMIT 1") or die($conexion->error);

/*$resultado=$conexion->query("select paciente.*, estados.nombre, estado_nac.nom_est_nac, municipios.nombre_m
from paciente inner join estados 
on paciente.id_edo=estados.id_edo
inner join estado_nac on paciente.id_edo_nac=estado_nac.id_edo_nac
inner join municipios on paciente.id_mun=municipios.id_mun ORDER by Id_exp DESC LIMIT 1") or die($conexion->error);*/
while ($row1 = mysqli_fetch_array($resultado)) {
                            ?>
                            <label for="fecha">Fecha y hora:</label>
                            <input type="datetime" name="fecha" value="<?php echo $row1['fecha'] ?>"
                                class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="Id_exp">Folio:</label>
                            <input type="text" value="<?php echo $row1['Id_exp'] ?>" name="folio" placeholder="FOLIO"
                                id="folio" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <!--                        <label for="Id_exp">Expediente:</label>-->
                            <input type="hidden" value="<?php echo $row1['Id_exp'] ?>" name="Id_exp"
                                placeholder="Expediente" id="Id_exp" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                    </div>

                </div>
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="curp">Curp:</label>
                            <input type="text" name="curp" placeholder="Curp" id="curp" class="form-control"
                                value="<?php echo $row1['curp']?>" onkeypress="return Curp(event);" maxlength="18"
                                minlength="18" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="papell">Primer apellido:</label>
                            <input type="text" name="papell" placeholder="APELLIDO PATERNO" id="papell"
                                class="form-control" value="<?php echo $row1['papell']?>"
                                onkeypress="return SoloLetras(event);" maxlength="50" disabled>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="sapell">Segundo apellido:</label>
                            <input type="text" name="sapell" placeholder="APELLIDO MATERNO" id="sapell"
                                class="form-control" value="<?php echo $row1['sapell']?>"
                                onkeypress="return SoloLetras(event);" maxlength="50" required disabled>
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

                            <input type="date" value="<?php echo $row1['fecnac']?>" name="fecnac"
                                placeholder="Fecha de nacimiento" id="fecnac" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="edad">Edad:</label>
                            <input type="text" name="edad" placeholder="Edad" id="edad" class="form-control"
                                value="<?php echo $row1['edad']?>" onkeypress="return SoloNumeros(event);" required
                                maxlength="3" minlength="1" disabled>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Género:</label>
                            <select name="sexo" class="form-control" required disabled="">
                                <option value=""><?php echo $row1['sexo'] ?></option>


                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Tipo de sangre:</label>
                            <select id="tip_san" class="form-control" name="tip_san" required disabled>
                                <option value=""><?php echo $row1['tip_san'] ?></option>
                            </select>

                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="dir">Direccón:</label>
                            <input type="text" name="dir" placeholder="Dirección" id="dir" class="form-control" required
                                style="text-transform:uppercase;" value="<?php echo $row1['dir'] ?>" maxlength="50"
                                disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Estado de residencia:</label>
                            <select id="id_estado" class="form-control" name="id_edo" required disabled>
                                <option value=""><?php echo $row1['nombre'] ?></option>

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group ">
                            <label for="">Municipio:</label>
                            <select id="municipios" class="form-control" name="id_mun" required disabled>
                                <option value=""><?php echo $row1['nombre_m'] ?></option>
                            </select>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="loc">Localidad:</label>
                            <input type="text" name="loc" placeholder="Localidad" id="loc" class="form-control" required
                                value="<?php echo $row1['loc'] ?>" onkeypress="return SoloLetras(event);" maxlength="50"
                                disabled>
                        </div>
                    </div>
                </div>
                <div class="row">


                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="ocup">Ocupación:</label>
                            <input type="text" name="ocup" placeholder="Ocupación" id="ocup" class="form-control"
                                required value="<?php echo $row1['ocup'] ?>" onkeypress="return SoloLetras(event);"
                                maxlength="50" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="tel">Teléfono:</label>
                            <input type="text" name="tel" value="<?php echo $row1['tel'] ?>"
                                placeholder="Teléfono 10 digitos" id="tel" class="form-control"
                                onkeypress="return SoloNumeros(event);" required disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="religion">Religión:</label>
                            <select name="religion" class="form-control" disabled="">
                                <option value=""><?php echo $row1['religion'] ?></option>

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="edociv">Estado civil:</label>
                            <select name="edociv" class="form-control" required disabled="">
                                <option value=""><?php echo $row1['edociv'] ?></option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
                    <tr><strong>
                            <center>DATOS DEL RESPONSABLE</center>
                        </strong>
                </div>
                <br>
                <div class="row">

                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="resp">Nombre completo del responsable:</label>
                            <input type="text" name="resp" placeholder="Responsable" id="resp" class="form-control"
                                required value="<?php echo $row1['resp'] ?>" onkeypress="return SoloLetras(event);"
                                maxlength="40" disabled>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="paren">Parentesco: </label>
                            <select name="paren" class="form-control" required disabled="">
                                <option value=""><?php echo $row1['paren'] ?></option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="tel_resp">Teléfono:</label>
                            <input type="text" name="tel_resp" placeholder="Teléfono 10 digitos" id="tel_resp"
                                value="<?php echo $row1['tel_resp'] ?>" class="form-control"
                                onkeypress="return SoloNumeros(event);" required disabled>
                        </div>

                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="dom_resp">Dirección del responsable:</label>
                            <input type="text" value="<?php echo $row1['dom_resp'] ?>" name="dom_resp"
                                placeholder="Dirección del Responsable" id="dom_resp" class="form-control" required
                                disabled>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
                    <tr><strong>
                            <center>HOJA FRONTAL</center>
                        </strong>
                </div>
                <br>
                <div class="form-group">
                    <?php

$resultado11=$conexion->query("SELECT * from dat_ingreso where Id_exp=$id_expp") or die($conexion->error);
while ($row22=mysqli_fetch_array($resultado11)) {
$iid=$row22['id_atencion'];
//echo $iid;
}

$resultado1=$conexion->query("SELECT * FROM paciente p, dat_ingreso e, reg_usuarios m where e.id_usua=m.id_usua and p.Id_exp=$id_expp and e.id_atencion=$iid ORDER by id_atencion desc LIMIT 1") or die($conexion->error);

        while ($row2=mysqli_fetch_array($resultado1)) {
                     $especialidad=$row2['especialidad'];
                     $alergias=$row2['alergias'];   
                     $tipo_a=$row2['tipo_a'];   
                     $area=$row2['area'];   
                     $motivo_atn=$row2['motivo_atn'];   
                     $id_usua=$row2['id_usua'];                        
                                    ?>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="id_usua">Médico tratante:</label>
                                <select name="id_usua" data-live-search="true" class="form-control" id="mibuscador2"
                                    onchange="mostrar(this.value);">
                                    <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                                          ?>
                                    <option value="" disabled="" selected="">Seleccionar</option>

                                    <?php foreach ($resultado1 as $opciones):?>
                                    <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?>
                                    </option>

                                    <?php endforeach?>
                                    <option value="OTRO">Otros</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="id_usua2">Médico tratante 2:</label>
                                <select name="id_usua2" data-live-search="true" class="form-control" id="mibuscador2"
                                    onchange="mostrar(this.value);">
                                    <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                                          ?>
                                    <option value="" disabled="" selected="">Seleccionar</option>

                                    <?php foreach ($resultado1 as $opciones):?>
                                    <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?>
                                    </option>

                                    <?php endforeach?>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="id_usua3">Médico tratante 3:</label>
                                <select name="id_usua3" data-live-search="true" class="form-control" id="mibuscador2"
                                    onchange="mostrar(this.value);">
                                    <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                                          ?>
                                    <option value="" disabled="" selected="">Seleccionar</option>

                                    <?php foreach ($resultado1 as $opciones):?>
                                    <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?>
                                    </option>

                                    <?php endforeach?>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="id_usua4">Médico tratante 4:</label>
                                <select name="id_usua4" data-live-search="true" class="form-control" id="mibuscador2"
                                    onchange="mostrar(this.value);">
                                    <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                                          ?>
                                    <option value="" disabled="" selected="">Seleccionar</option>

                                    <?php foreach ($resultado1 as $opciones):?>
                                    <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?>
                                    </option>

                                    <?php endforeach?>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="id_usua5">Médico tratante 5:</label>
                                <select name="id_usua5" data-live-search="true" class="form-control" id="mibuscador2"
                                    onchange="mostrar(this.value);">
                                    <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                                          ?>
                                    <option value="" disabled="" selected="">Seleccionar</option>

                                    <?php foreach ($resultado1 as $opciones):?>
                                    <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?>
                                    </option>

                                    <?php endforeach?>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="habitacion">Área de atención:</label>
                                <select id="cama" name="habitacion" class="form-control" enabled="" required>
                                    <?php
                                         $resultado1 = $conexion ->query("SELECT * FROM cat_camas where estatus='LIBRE' order by num_cama ASC")or die($conexion->error);
                                          ?>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($resultado1 as $opciones):?>
                                    <option value="<?php echo $opciones['id']?>"><?php echo $opciones['num_cama']?>
                                        <?php echo $opciones['tipo']?></option>

                                    <?php endforeach?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="container" id="contenido">
                        <h5>Registro de nuevo médico </h5>
                        <div class="row">

                            <div class="col-sm-4">
                                <label> Nombre completo:</label>
                                <input type="text" name="papell_med" class="form-control" placeholder="Nombre completo">
                            </div>


                        </div>
                        <hr>
                    </div>





                    <?php } ?>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="motivo_atn">Motivo de atención:</label><br>
                                <select name="motivo_atn" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Hospitalización">Hospitalización</option>
                                    <option value="Consulta">Consulta</option>
                                    <option value="Atención Ambulatoria">Atención Ambulatoria</option>
                                    <option value="Atención de urgencias">Atención de urgencias</option>
                                    r<option value="Endoscopía">Endoscopía</option>
                                    <option value="Cirugía programada">Cirugía programada</option>
                                    <option value="Cirugía de urgencia">Cirugía de urgencia</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="alergias">Alergias:</label>
                                <input type="text" placeholder="Alergias del paciente" name="alergias"
                                    class="form-control" onkeypress="return SoloLetras(event);" required>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="tipo_a">Servicio:</label>
                            <select name="tipo_a" data-live-search="true" class="form-control" id="mibuscador3"
                                required>
                                <?php
                                $resultadoaseg = $conexion->query("SELECT * FROM cat_espec WHERE espec_activo='SI' ORDER BY espec ASC") or die($conexion->error);
                                ?>
                                <option value="">Seleccionar </option>
                                <?php foreach ($resultadoaseg as $opcionesaseg): ?>


                                <option value="<?php echo $opcionesaseg['espec'] ?>">
                                    <?php echo $opcionesaseg['espec'] ?></option>

                                <?php endforeach ?>
                            </select>
                            <!--      <select name="tipo_a"class="form-control" required >
                                            <option value="">Seleccionar</option> 
                                            <option value="QUIRURGICO">QUIRÚRGICA</option>
                                            <option value="TRATAMIENTO MEDICO">TRATAMIENTO MÉDICO</option>
                                        </select> -->
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="referido"> Referido por:</label>

                            <select name="referido" class="form-control" required onchange="habilitar(this.value);">
                                <option value="">Seleccionar</option>
                                <option value="FAMILIAR O CONOCIDO">FAMILIAR O CONOCIDO</option>
                                <option value="MEDICO">MEDICO</option>
                                <option value="INTERNET">INTERNET</option>
                                <option value="REDES SOCIALES">REDES SOCIALES</option>
                                <option value="AUTOBUS">AUTOBUS</option>
                                <option value="ESPECTACULAR">ESPECTACULAR</option>
                                <option value="VALLAS">VALLAS</option>
                                <option value="REFERIDO CMT">REFERIDO CMT</option>
                                <option value="YA ES PACIENTE">YA ES PACIENTE</option>
                                <option value="OTRO">OTRO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
                    <tr><strong>
                            <center>DEPÓSITOS A LA CUENTA</center>
                        </strong>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <?php
    $resultadofin = $conexion->query("SELECT * FROM dat_financieros where id_atencion=$iid ORDER by id_datfin DESC LIMIT 1") or die($conexion->error);
    while ($row3=mysqli_fetch_array($resultadofin)) {
        $iddf=$row3['id_atencion'];
        $asegu=$row3['aseg'];
        $resp=$row3['resp'];
        $dir_resp=$row3['dir_resp'];
        $id_edo=$row3['id_edo'];
        $id_mun=$row3['id_mun'];
        $tel_res=$row3['tel'];
        $aval=$row3['aval'];
        $banco=$row3['banco'];
        $deposito=$row3['deposito'];
        $letra=$row3['dep_l'];
        $id_usu=$row3['id_usua'];
            
        //echo $iddf;
     ?>


                            <label for="aseg">Aseguradora: </label><br>
                            <select name="aseg" class="form-control" required>
                                <?php
                                $resultadoaseg = $conexion->query("SELECT * FROM cat_aseg WHERE aseg_activo='SI' ORDER BY aseg ASC") or die($conexion->error);
                                ?>
                                <option value="">Seleccionar </option>
                                <?php foreach ($resultadoaseg as $opcionesaseg): ?>


                                <option value="<?php echo $opcionesaseg['aseg'] ?>"><?php echo $opcionesaseg['aseg'] ?>
                                </option>

                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="aval">Detalle:</label><br>
                            <input type="text" name="aval" id="aval" placeholder="Banco, No. de tarjeta, etc." value=""
                                maxlength="60" style="text-transform:capitalize;"
                                onkeyup="javascript:this.value=this.value.ucfirst();" class="form-control">
                        </div>
                    </div>

                </div>




                <div class="row">
                    <div class="col-sm-5">

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
                    <?php
                        
                        $fecha_actual = date("d-m-Y");
                        ?>
                    <div class="col-sm-5">
                        <div class="form-group">

                            <label for="fec_deposito">Fecha:</label><br>
                            <input type="text" name="fec_deposito" placeholder="Fecha de Desposito" id="fec_deposito"
                                class="form-control" value="<?php echo $fecha_actual ?>" disabled>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="deposito">Cantidad $ (Número)</label><br>
                            <input type="text" name="deposito" id="deposito" maxlength="13" minlength="0"
                                onkeypress="return SoloNumeros(event);" required class="form-control number">
                        </div>
                    </div>

                    <!-- <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="dep_l">CANTIDAD CON LETRA:</label><br>
                                    <input type="text" name="dep_l"  id="dep_l"
                                           style="text-transform:uppercase;" value=""maxlength="150" 
                                           onkeypress="return SoloLetras(event);" 
                                           onkeyup="javascript:this.value=this.value.toUpperCase();" required
                                           class="form-control">
                                </div>
                            </div>-->
                </div>
                <center>
                    <hr>
                    <button type="submit" class="btn btn-success btn-md" name="nvisita">Abrir nueva visita</button>
                </center>
                <?php } ?>
                <div>
                </div>
                <hr>

                </form>
                <div class="row">
                    <div class="col-sm-4">
                        <?php 
      $res_dat = $conexion ->query("SELECT Id_exp FROM paciente ORDER by Id_exp DESC LIMIT 1")or die($conexion->error);
   if(mysqli_num_rows($res_dat) > 0 ){ //se mostrara si existe mas de 1
          $fila=mysqli_fetch_row($res_dat);
          $id_exp=$fila[0];
          }
                    ?>
                        <!-- <a href="../cartas_consentimientos/consent_lis_pac.php?Id_exp=<?php echo $id_exp; ?>"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i><font id="letra"> Visualizar documentos</font></button>-->
                    </div>
                    <!-- <div class="col-sm-4">
                    <a href="../gestion_pacientes/ine.php?Id_exp=<?php echo $id_exp; ?>">
                        <button type="button" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i><font id="letra">Agregar ine</font></button>
                </div>-->

                </div>
                <hr>


            </div>

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


<script>
document.oncontextmenu = function() {
    return false;

}
</script>
<script type="text/javascript">
function mostrar(value) {
    if (value == "OTRO" || value == true) {
        // habilitamos
        document.getElementById('contenido').style.display = 'block';
    } else if (value != "OTRO" || value == false) {
        // deshabilitamos
        document.getElementById('contenido').style.display = 'none';
    }
}
</script>
<SCRIPT LANGUAGE="JavaScript">
history.forward()
</SCRIPT>
<?php
if (isset($_POST['nvisita'])) {


$fecha_actual = date("Y-m-d H:i:s");

$id_usuap    = mysqli_real_escape_string($conexion, (strip_tags($_POST["id_usua"], ENT_QUOTES)));

if (isset($_POST['id_usua2'])){$id_usua2=$_POST['id_usua2'];}else{$id_usua2=0;}
if (isset($_POST['id_usua3'])){$id_usua3=$_POST['id_usua3'];}else{$id_usua3=0;}
if (isset($_POST['id_usua4'])){$id_usua4=$_POST['id_usua4'];}else{$id_usua4=0;}
if (isset($_POST['id_usua5'])){$id_usua5=$_POST['id_usua5'];}else{$id_usua5=0;}



$areap    = mysqli_real_escape_string($conexion, (strip_tags($_POST["area"], ENT_QUOTES)));
$motivo_atnp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["motivo_atn"], ENT_QUOTES)));
$especialidadp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["especialidad"], ENT_QUOTES)));
$alergiasp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["alergias"], ENT_QUOTES)));
$id_cam    = mysqli_real_escape_string($conexion, (strip_tags($_POST["habitacion"], ENT_QUOTES)));
$tipo_ap    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo_a"], ENT_QUOTES)));
$referido    = mysqli_real_escape_string($conexion, (strip_tags($_POST["referido"], ENT_QUOTES)));

$asegp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["aseg"], ENT_QUOTES)));
$avalp   = mysqli_real_escape_string($conexion, (strip_tags($_POST["aval"], ENT_QUOTES)));
$bancop   = mysqli_real_escape_string($conexion, (strip_tags($_POST["banco"], ENT_QUOTES)));
$depositop   = mysqli_real_escape_string($conexion, (strip_tags($_POST["deposito"], ENT_QUOTES)));

$depositop;
require_once "CifrasEnLetras.php";
$v=new CifrasEnLetras(); 
//Convertimos el total en   letras
$letrap=($v->convertirEurosEnLetras($depositop));



if($id_usuap=="OTRO"){
    
    $papell_med   = mysqli_real_escape_string($conexion, (strip_tags($_POST["papell_med"], ENT_QUOTES)));
    //$sapell_med   = mysqli_real_escape_string($conexion, (strip_tags($_POST["sapell_med"], ENT_QUOTES)));
    //$nom_med   = mysqli_real_escape_string($conexion, (strip_tags($_POST["nom_med"], ENT_QUOTES)));
    
 
     //$nombre = $_POST['nombre'];
      
$ingresar_usu = mysqli_query($conexion, 'insert into reg_usuarios(papell,id_rol) values("'.$papell_med.'","2")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


$buscar = $conexion ->query("SELECT id_usua FROM reg_usuarios ORDER by id_usua DESC LIMIT 1")or die($conexion->error);
while ($row= $buscar->fetch_assoc()) {
  $id_usua=$row['id_usua'];
}

}

$resultado5d = $conexion->query("SELECT * FROM cat_camas WHERE id = $id_cam ") or die($conexion->error);
 while ($f5 = mysqli_fetch_array($resultado5d)) {
 $cobro_cve=$f5["serv_cve"];
 $ubica=$f5["tipo"];
 }

$ingresard=mysqli_query($conexion,'insert into dat_ingreso(Id_exp,fecha,alergias,tipo_a,id_usua,motivo_atn,fecha_cama,aseg,id_usua2,id_usua3,id_usua4,id_usua5,referido) values ("'.$id_expp.'","'.$fecha_actual.'","'.$alergiasp.'","'.$tipo_ap.'",'.$id_usuap.',"'.$motivo_atnp.'","'.$fecha_actual.'","'.$asegp.'",'.$id_usua2.','.$id_usua3.','.$id_usua4.','.$id_usua5.',"'.$referido.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));


$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.folio, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias, di.id_atencion FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.Id_exp =$id_expp";

          $result_pac = $conexion->query($sql_pac);

          while ($row_pac = $result_pac->fetch_assoc()) {
            $id_exp = $row_pac['Id_exp'];
            $id_aten = $row_pac['id_atencion'];
          }

if(isset($_POST['habitacion'])){
          //// update de  camas id_atencion
      $sql2 = "UPDATE cat_camas SET estatus = 'OCUPADA', id_atencion= $id_aten WHERE id = $id_cam";
      $result = $conexion->query($sql2);

            ///// tomar el registro de camas  habitacion y id_atencion
      $resultado3 = $conexion ->query("SELECT habitacion, id_atencion FROM cat_camas WHERE id = $id_cam ")or die($conexion->error);


  if(mysqli_num_rows($resultado3) > 0 ){ //se mostrara si existe mas de 1
      $f3=mysqli_fetch_row($resultado3);
      $habitacion=$f3[0];
      $id_at=$f3[1];
  }else{header("Location: ../registro_pac.php"); //te regresa a la página principal
   } 

  $sql3 = "UPDATE dat_ingreso SET cama='1', area='$ubica', especialidad='$ubica'  WHERE id_atencion = $id_aten";
      $result = $conexion->query($sql3);
} 





$fecha_actualp = date("Y-m-d H:i:s"); 

$fecha_actual2 = date("Y-m-d H:i:s"); 
     //$ingresarfin=mysqli_query($conexion,'insert into dat_financieros(id_atencion) values ("'.$iddf.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion)); 

$ingresarfin=mysqli_query($conexion,'insert into dat_financieros(id_atencion,aseg,resp,dir_resp,id_edo,id_mun,tel,aval,banco,deposito,dep_l,fec_deposito,fecha,id_usua) values ("'.$id_aten.'","'.$asegp.'","'.$resp.'","'.$dir_resp.'",'.$id_edo.','.$id_mun.',"'.$tel_res.'","'.$avalp.'","'.$bancop.'",'.$depositop.',"'.$letrap.'","'.$fecha_actualp.'","'.$fecha_actual2.'",'.$id_usu.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion)); 


if($area=="TRIAGE"){
  
$fecha_actuald = date("Y-m-d H:i:s");
 $ingresar3=mysqli_query($conexion,'insert into dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,id_usua,centro_cto,vdesc) values ('.$id_aten.',"S","11","'.$fecha_actuald.'","1",'.$id_usu.',"'.$ubica.'","SERVICIOS HOSPITALARIOS")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

}

 
$fech_actua = date("Y-m-d H:i:s"); 

$ingresar3=mysqli_query($conexion,'insert into dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,id_usua,centro_cto,vdesc) values ('.$id_aten.',"S","'.$cobro_cve.'","'.$fech_actua.'",1,'.$id_usu.',"'.$ubica.'","SERVICIOS HOSPITALARIOS")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion)); 


 echo '<script type="text/javascript">window.location.href ="../global_pac/pac_global.php" ;</script>';
}




?>
</body>


</html>