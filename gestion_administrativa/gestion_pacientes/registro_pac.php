    <?php
    session_start();
    require "../../estados.php";
    include "../../conexionbd.php";
    include "../header_administrador.php";
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


        <title>Creación de Paciente</title>
        <link rel="shortcut icon" href="logp.png">


    </head>
        
  <div class="container">
            <div class="row">
                    <div class="col-sm-2">
                         <div class="form-group">
                        <a href="../gestion_pacientes/paciente.php">
                            <button type="button" class="btn btn-primary">
                                <img src="https://img.icons8.com/ios-filled/50/000000/recovery.png" width="35"/><font id="letra">NUEVO PACIENTE</font></button></a>
                        </div>
                    </div>
                   &nbsp;&nbsp;
                    <div class="col-sm-2">
                         <div class="form-group">
                        <a href="../cartas_consentimientos/consent_lis_pac2.php">
                            <button type="button" class="btn btn-danger">
                                <img src="https://img.icons8.com/fluency/48/000000/document.png" width="35"/><font id="letra">IMPRIMIR DOCUMENTOS</font></button></a>
                        </div>
                    </div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 <div class="col-sm-2">
                    <div class="form-group"><a href="../cuenta_paciente/vista_ahosp.php">
                            <button type="button" class="btn" style="background-color:#A4C138; color: white;">
                                <img src="https://img.icons8.com/ios-filled/50/000000/hospital-bed.png" width="35"/><font id="letra">ASIGNAR HABITACIÓN</font></button></a></div>

                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php 
                    $usuario=$_SESSION['login'];
                    $rol=$usuario['id_rol'];
                    if($rol==5 || $rol==1){ ?>
                     <div class="col-sm-2">
                         <div class="form-group">
                        <a href="../global_pac/pac_global.php">
                            <button type="button" class="btn btn-danger btn-sm" style="background-color:#FF5733;"><img src="https://img.icons8.com/doodle/48/000000/group.png" width="40" />VER EXPEDIENTES</button></a>
                        </div>
                    </div>
                <?php } ?> 
               <div class="col-sm">
                    <div class="form-group"><a href="vista_ine.php">
                            <button type="button" class="btn btn-success btn-sm">
                                <img src="https://img.icons8.com/nolan/64/bank-card-back-side.png" width="38"><font id="letra"> SUBIR INE</font></button></a>
                    </div>

                </div>   
            </div>
         
            <div class="row">
                  <div class="col col-12">
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    <br>
                   <center>
                        
                        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                                <tr><strong><center>PACIENTES HOSPITALIZADOS</center></strong></tr>
                        </div>
                      <p>
                    </center>

</div> </div>
 </div> 
<div class="tab-content">

 <div class="responsive">
                    <h2>
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    </h2>


                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
                    </div><br>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead" style="background-color: #2b2d7f">
                        <tr>
                            <th scope="col"><font color="white" size="2">Editar</th>
                            <th scope="col"><font color="white" size="2">Cuenta</th>
                            <th scope="col"><font color="white" size="2">Expediente</th>
                            <th scope="col"><font color="white" size="2">Nombre</th>
                            <th scope="col"><font color="white" size="2">Edad</th>
                            <th scope="col"><font color="white" size="2">Fecha de nacimiento</th>
                            <th scope="col"><font color="white" size="2">Teléfono</th>
                            <th scope="col"><font color="white" size="2">Habitación</th>
                            <th scope="col"><font color="white" size="2">Fecha de ingreso</th>
                            
                                
                        </tr>
                        </thead>
                        <tbody>

                        <?php
$resultado = $conexion->query("SELECT *,d.fecha as fecha_ing from paciente p, dat_ingreso d, cat_camas c WHERE p.Id_exp=d.Id_exp and d.activo='SI' and d.id_atencion=c.id_atencion and (d.area= 'HOSPITALIZACION'||d.area= 'HOSPITALIZACIÓN'||d.area= 'TERAPIA INTENSIVA'||d.area= 'OBSERVACIÓN'||d.area= 'OBSERVACION'||d.area= 'QUIROFANO'||d.area= 'QUIRÓFANO'||d.area= 'ENDOSCOPÍA'||d.area= 'AMBULATORIO') ORDER by d.fecha desc") or die($conexion->error);
                        while ($f = mysqli_fetch_array($resultado)) {

                            ?>
    <tr>
    <td>
    <center>
        <a href="edit_paciente.php?Id_exp=<?php echo $f['Id_exp']; ?>&id_atencion=<?php echo $f['id_atencion']; ?>"><button type="button" class="btn btn-primary "><i class="fa fa-edit"></i></button></a></center></td>     
        <td><center><a type="submit" class="btn btn-warning btn-sm" href="../cuenta_paciente/detalle_cuenta.php?id_at=<?php echo $f['id_atencion'] ?>&id_exp=<?php echo $f['Id_exp'] ?>&id_usua=<?php echo $usuario['id_usua']; ?>&rol=<?php echo $usuario['id_rol'] ?>"><span class="fas fa-dollar-sign" style="font-size:28px"></span></a></center> </td>
        <td><strong><?php echo $f['Id_exp']; ?></strong></td>
        <td><strong><?php echo $f['papell'].' '.$f['sapell'].' '. $f['nom_pac']; ?></strong></td>
        <td><strong><?php echo $f['edad']; ?></strong></td>
        <td><strong><?php $date = date_create($f[5]);
            echo date_format($date, "d/m/Y"); ?><?php $date = date_create($f[5]);
            ?></strong></td>
        <td><strong><?php echo $f['tel']; ?></strong></td>
        <td bgcolor="#2b2d7f"><strong><font color="white"><?php echo $f['num_cama']; ?></font></strong></td>
        <td><strong><font size="2"><?php $date = date_create($f['fecha_ing']);
            echo date_format($date, "d/m/Y h:i A"); ?></strong></td>
        
    </tr>
    <?php
    }?>
    </tbody>
</table>
                    </div>

 </div>
 <!---------------- nav URGENCIAS CONSULTAS-->
<div class="tab-pane fade" id="nav-urg" role="tabpanel" aria-labelledby="nav-urg-tab">

    <h2>
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    </h2>


                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
                    </div><br>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead" style="background-color: #2b2d7f">
                        <tr>
                            <th scope="col"><font color="white" size="2">Editar</th>
                            <th scope="col"><font color="white" size="2">Cuenta</th>
                            <th scope="col"><font color="white" size="2">Expediente</th>
                            <th scope="col"><font color="white" size="2">Nombre</th>
                            <th scope="col"><font color="white" size="2">Edad</th>
                            <th scope="col"><font color="white" size="2">Fecha de nacimiento</th>
                            <th scope="col"><font color="white" size="2">Teléfono</th>
                            <th scope="col"><font color="white" size="2">Estatus</th>
                            <th scope="col"><font color="white" size="2">Fecha de ingreso</th>
                            
                                
                        </tr>
                        </thead>
                        <tbody>

                        <?php
$resultado = $conexion->query("SELECT p.*,d.area, d.fecha as fecha_ing, d.id_atencion from paciente p, dat_ingreso d WHERE p.Id_exp=d.Id_exp and d.activo='SI' and 
(d.area= 'CONSULTA' || d.area= 'ALTA') ORDER by d.fecha desc") or die($conexion->error);
                        while ($f = mysqli_fetch_array($resultado)) {

                            ?>
                            <tr>
                                <td>
                                    <center>
                                        <a href="edit_paciente.php?Id_exp=<?php echo $f['Id_exp']; ?>&id_atencion=<?php echo $f['id_atencion']; ?>"<button type="button" class="btn btn-primary "><i class="fa fa-edit"></i></button></a></center></td>
                                        <td><center><a type="submit" class="btn btn-warning btn-sm" href="../cuenta_paciente/detalle_cuenta.php?id_at=<?php echo $f['id_atencion'] ?>&id_exp=<?php echo $f['Id_exp'] ?>&id_usua=<?php echo $usuario['id_usua']; ?>&rol=<?php echo $usuario['id_rol'] ?>"><span class="fas fa-dollar-sign" style="font-size:28px"></span></a></center> </td>
                                <td><strong><?php echo $f['Id_exp']; ?></strong></td>
                                <td><strong><?php echo $f['papell'].' '.$f['sapell'].' '.$f['nom_pac']; ?></strong></td>
                                <td><strong><?php echo $f['edad']; ?></strong></td>
                                <td><strong><?php $date = date_create($f[5]);
                                        echo date_format($date, "d/m/Y"); ?></strong></td>
                                <td><strong><?php echo $f['tel']; ?></strong></td>
                                <td bgcolor="#2b2d7f"><strong><font color="white"><?php if (isset($f['num_cama'])) {
                                    echo $f['num_cama'];
                                }else{
                                    echo $f['area'];
                                } ?></td>
                                <td><strong><font size="2"><?php $date = date_create($f['fecha_ing']);
                                        echo date_format($date, "d/m/Y h:i A"); ?></strong></td>
                                        
                            </tr>
                            <?php
                        }

                        ?>
                        </tbody>
                    </table>
                    </div>
 
</div>   
<!---------------- nav ambulatorios-->
<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

    <h2>
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    </h2>


                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
                    </div><br>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead" style="background-color: #2b2d7f">
                        <tr>
                             <th scope="col"><font color="white" size="2">Editar</th>
                            <th scope="col"><font color="white" size="2">Expediente</th>
                            <th scope="col"><font color="white" size="2">Nombre</th>
                            <th scope="col"><font color="white" size="2">Edad</th>
                            <th scope="col"><font color="white" size="2">Fecha de nacimiento</th>
                            <th scope="col"><font color="white" size="2">Teléfono</th>
                            <th scope="col"><font color="white" size="2">Habitación</th>
                            <th scope="col"><font color="white" size="2">Fecha de ingreso</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
$resultado = $conexion->query("SELECT * ,d.fecha as fecha_ing  from paciente p, dat_ingreso d WHERE p.Id_exp=d.Id_exp and d.activo='SI' and d.area='QUIROFANO' ORDER by d.fecha desc") or die($conexion->error);
                        while ($f = mysqli_fetch_array($resultado)) {

                            ?>
                            <tr>
                                <td>
                                    <center>
                                        <a href="edit_paciente.php?Id_exp=<?php echo $f['Id_exp']; ?>&id_atencion=<?php echo $f['id_atencion']; ?>"<button type="button" class="btn btn-primary "><i class="fa fa-edit"></i></button></a></center></td>       
                                <td><strong><?php echo $f['Id_exp']; ?></strong></td>
                                <td><strong><?php echo $f['papell'].' '.$f['sapell'].' '.$f['nom_pac']; ?></strong></td>
                                <td><strong><?php echo $f['edad']; ?></strong></td>
                                <td><strong><?php $date = date_create($f[5]);
                                        echo date_format($date, "d/m/Y"); ?></strong></td>
                                <td><strong><?php echo $f['tel']; ?></strong></td>
                                <td><strong><font size="2"><?php $date = date_create($f['fecha_ing']);
                                        echo date_format($date, "d/m/Y h:i A"); ?></strong></td>
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

    <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- FastClick -->
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
    </body>
    </html>
