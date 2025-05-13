<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];




if ($usuario['id_rol'] == 9) {
    include "../header_imagen.php";

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_imagen.php";
} else{
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>

<!DOCTYPE html>
<html>

<head>

    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>




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


</head>

<body>

<div class="container-fluid">

    <?php
    if ($usuario1['id_rol'] == 4) {
        ?>

        <a type="submit" class="btn btn-danger" href="../../template/menu_sauxiliares.php">REGRESAR</a>

        <?php
    } else if ($usuario1['id_rol'] == 10 || $usuario1['id_rol'] == 12 ) {

        ?>
        <a type="submit" class="btn btn-danger" href="../../template/menu_laboratorio.php">REGRESAR</a>

        <?php
    } else if ($usuario1['id_rol'] == 5) {

        ?>
        <a type="submit" class="btn-sm btn-danger" href="../../template/menu_gerencia.php">REGRESAR</a>

        <?php
    }else

    ?>
    <br>
    <br>


<section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->


    <div class="container box">
        <div class="content">


            <?php

            include "../../conexionbd.php";


            // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

            //  $result = $conn->query($sql);

            //    $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);
            ?>


            <!--Fin de los filtros-->


            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>
<br>
        <!-- INICIO ESTUDIOS IMAGENOLOGIA-->
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>ESTUDIOS DE IMAGENOLOGÍA</strong></center><p>
</div> 

       
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="mytable">
                    <thead class="thead" style="background-color: #2b2d7f; color:white;">
                    <tr>
                        <th>Paciente</th>
                        <th>Habitación</th>
                        <th>Fecha solicitud</th>
                        <th>Solicitante</th>
                        <th>Estudio</th>
                        <th>Ver</th>
                        <th>Informe</th>
                        <th>Editar</th>
                        <th>Solicitud</th> 
                        <th>Fecha resultado</th>
                        <th>Atendió solicitud</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include "../../conexionbd.php";
                    
                    $usuario = $_SESSION['login'];
                    $id_usua_log= $usuario['id_usua'];

                    $query_log = "SELECT * FROM reg_usuarios where id_usua= $id_usua_log ";
                    $result_log = $conexion->query($query_log);

                    while ($row_log = $result_log->fetch_assoc()) {
                        $pac_log = $row_log['papell'] . ' ' . $row_log['sapell'];
                    }


         
  $query = "SELECT * FROM notificaciones_imagen n, reg_usuarios u where n.realizado = 'Si' and n.activo = 'SI' and n.id_usua = u.id_usua ORDER BY not_id desc";
                    $result = $conexion->query($query);
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                     $not_id = $row['not_id'];
                     $habi = $row['habitacion'];
                     $id_atencion = $row['id_atencion'];
                     $interpretado = $row['interpretado'];
                     $pac_imagen = $row['sol_estudios'];
                     $id_usua_resul = $row['id_usua_resul'];

                     $sql_dat_ingi = "SELECT * from cat_servicios where serv_desc='$pac_imagen'";
                     $result_dat_inga = $conexion->query($sql_dat_ingi);

                     while ($row_dat_ingu = $result_dat_inga->fetch_assoc()) {
                    //$desc = $row_dat_ingu['serv_desc'];
                    $tipins = $row_dat_ingu['tip_insumo'];
  
                    }

                     $query_log = "SELECT * FROM reg_usuarios where id_usua= $id_usua_resul ";
                     $result_log = $conexion->query($query_log);

                    while ($row_log = $result_log->fetch_assoc()) {
                        $pac_log = $row_log['papell'] . ' ' . $row_log['sapell']; }
                    
                    if ($habi <> 0)  {
                    $query_pac = "SELECT * FROM dat_ingreso d, paciente p where d.id_atencion = $id_atencion and d.Id_exp = p.Id_exp";
                    $result_pac = $conexion->query($query_pac);
                      

                    while ($row_pac = $result_pac->fetch_assoc()) {
                        $pac = $row_pac['papell'] . ' ' . $row_pac['sapell'] . ' ' . $row_pac['nom_pac'];
                                }

                        echo '<tr>'

                            . '<td >' . $row['id_atencion'] . ' ' . $pac . '</td>'
                            . '<td >' . $row['habitacion'] . '</td>'
                            . '<td >' . $row['fecha_ord'] . '</td>'
                            . '<td >' . $row['papell'] . ' ' . $row['sapell']. '</td>'
                            . '<td >' . $pac_imagen. ' ' . $tipins.'</td>'


                          
                            . '<td class="fondo" style="color:white; font-size:30px;" ><a href="' . $row['link']  . '" target="_blank" title="Ver estudio"><center><i class="fa fa-eye" aria-hidden="true" ></i></center></a></td>';
                             //. '<td >' . $row['not_id'] . '</td>';

  
if($row['interpretado']=="Si"){
    echo '<td class="fondo" style="color:white;"><center>'
                            . ' <a  href="../../sauxiliares/Imagenologia/dwv/tests/pacs/viewer.php?not_id=' . $not_id . '&id_atencion=' . $row['id_atencion'] . '"
                     title="Ver informe" class="btn btn-success"><span class="fa fa-file-pdf-o" aria-hidden="true"> <i class="fa fa-check" aria-hidden="true"></i></span></a>';
                        echo '</center></td>';
    echo '<td class="fondo" style="color:white;"><center>'
                            . ' <a  href="../../sauxiliares/Imagenologia/editar_resultado.php?not_id=' . $not_id . '&id_atencion=' . $row['id_atencion'] . '"
                      title="Editar resultado" class="btn btn-danger"><span class="fa fa-edit" aria-hidden="true"></span></a>';
                        echo '</center></td>';
    echo ' <td class="fondo" style="color:white;">
    <center>
        <a href="../Imagenologia/pdf_solicitud_estu.php?id_atencion='.$row['id_atencion'].'&notid='.$row['not_id'].'&medico='.$row['papell'] .'&paciente='.$pac.'" target="_blank" >
        <button type="button" class="btn btn-success">
        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
        </button></td>
    </center>';

}else if($row['interpretado']=="No"){
    echo '<td class="fondo" style="color:white;"><center>'
                            . ' <a  href=""
                      title="No disponible" class="btn btn-danger"><span class="fa fa-file-pdf-o" aria-hidden="true"> <i class="fa fa-times" aria-hidden="true"></i></span></a>';
                        echo '</center></td>';
}


   


                        $no++;
                       echo  '<td >' . $row['fecha_resul'] . '</td>'
                           . '<td >' . $pac_log .  '</td></tr>';
                      } else  {
                            
                                $query_rec = "SELECT * FROM receta_ambulatoria where id_rec_amb = $id_atencion ";
                                $result_rec = $conexion->query($query_rec);

                                while ($row_rec = $result_rec->fetch_assoc()) {
                                    $pac = $row_rec['papell_rec'] . ' ' . $row_rec['sapell_rec'] . ' ' . $row_rec['nombre_rec'];
                                    $habitacion = "C.EXT";
                                }
                                 echo '<tr>'

                            . '<td >' . $row['id_atencion'] . ' ' . $pac . '</td>'
                            . '<td >' . $habitacion . '</td>'
                            . '<td >' . $row['fecha_ord'] . '</td>'
                            . '<td >' . $row['papell'] . ' ' . $row['sapell'] . '</td>'
                            . '<td >' . $pac_imagen. '</td>'
                            . '<td >' . $row['realizado'] . '</td>';
                             //. '<td >' . $row['not_id'] . '</td>';

   echo '<td class="fondo" style="color:white;"><center>'
                            . ' <a  href="../../sauxiliares/Imagenologia/dwv/tests/pacs/editar_resultado.php?not_id=' . $not_id . '&id_atencion=' . $row['id_atencion'] . '"
                      title="Editar resultado" class="btn btn-danger"><span class="fa fa-edit" aria-hidden="true"></span></a>';
                        echo '</center></td>';

   echo '<td class="fondo" style="color:white;"><center>'
                            . ' <a  href="../../sauxiliares/Imagenologia/dwv/tests/pacs/viewer.php?not_id=' . $not_id . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank" title="Ver resultado" class="btn btn-danger"><span class="fa fa-eye" aria-hidden="true"></span></a>';
                        echo '</center></td>';


                        $no++;
                       echo  '<td >' . $row['fecha_resul'] . '</td>'
                           . '<td >' . $pac_log .  '</td></tr>';
                } }  ?>
                    </tbody>
                </table>

            </div>
        
   
</div>
 <!-- TERMINO ESTUDIOS IMAGENOLOGIA-->   
        </div>
    </div>

</section>
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