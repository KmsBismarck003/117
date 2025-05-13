<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 10) {
    include "../header_labo.php";

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_labo.php";
} else {
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function () {
            $("#search").keyup(function () {
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function () {
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
    if ($usuario1['id_rol'] == 10) {

        ?>
        <a type="submit" class="btn btn-danger" href="../../template/menu_laboratorio.php">Regresar</a>

        <?php
    } else if ($usuario1['id_rol'] == 5) {

        ?>
        <a type="submit" class="btn btn-danger" href="../../template/menu_gerencia.php">Regresar</a>

        <?php
    }else

    ?>
    <br>
    <br>
<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 25px;">
         <tr><strong><center>ESTUDIOS DE LABORATORIO PENDIENTES</center></strong>
      </div><br>

</div>

<section class="content">
   <section class="content container-fluid">
                <div class="content box">
                    <!-- CONTENIDOO -->
                    
                   

                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:25%" id="search" placeholder="Buscar...">
                    </div>
                    <br>

                    <div class="table-responsive">
                        <!--<table id="myTable" class="table table-striped table-hover">-->

                        <table class="table table-bordered table-striped" id="mytable">

                            <thead class="thead" style="background-color: #2b2d7f; color:white;">
                            <tr>

                                <th>Habitación</th>
                                <th>Paciente</th>
                                <th>Médico tratante</th>
                                <th>Fecha solicitud</th>
                                <th>Solicitante</th>
                                <th>Estudio(s)</th>
                                <th>Solicitud de estudio</th> 
                                <th>Subir Resultado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php   

                            //include "../conexionbd.php";

                            $query = "SELECT * FROM notificaciones_labo n, reg_usuarios u where n.realizado = 'NO' and n.id_usua = u.id_usua and activo= 'SI' order by fecha_ord DESC ";
                            $result = $conexion->query($query);
                            $no = 1;

                            while ($row = $result->fetch_assoc()) {
                                $habi = $row['habitacion'];
                                $id_atencion = $row['id_atencion'];
                                 
                            if ($habi <> 0)  {
           
                        
                                
                                $query_pac = "SELECT * FROM dat_ingreso d, paciente p where d.id_atencion = $id_atencion and d.Id_exp = p.Id_exp";
                                $result_pac = $conexion->query($query_pac);

                                while ($row_pac = $result_pac->fetch_assoc()) {
                                    $pac = $row_pac['papell'] . ' ' . $row_pac['sapell'] . ' ' . $row_pac['nom_pac'];
                                    $fecha_orden = date_create($row['fecha_ord']);
                                    $tratante = $row_pac['id_usua'];
                                }
                                $sql_reg_usrt = "SELECT * from reg_usuarios where id_usua=$tratante";
                                $result_reg_usrt = $conexion->query($sql_reg_usrt);
                                while ($row_reg_usrt = $result_reg_usrt->fetch_assoc()) {
                                    $prefijo = $row_reg_usrt['pre'];
                                    $nom_tratante = $row_reg_usrt['papell'];
                                    $cedula = $row_reg_usrt['cedp'];
                                }
                                echo '<tr>'
                                    . '<td class="fondosan" style="color:white;">' . $row['habitacion'] . '</td>'
                                    . '<td class="fondosan" style="color:white;">' . $pac . '</td>'
                                    . '<td class="fondosan" style="color:white;">' . $prefijo . '. ' . $nom_tratante . '   </td>'
                                    . '<td class="fondosan" style="color:white;">' . date_format($fecha_orden,"d/m/Y H:i a") . '</td>'
                                    . '<td class="fondosan" style="color:white;">' . $row['papell'] . ' ' . $row['sapell'] . ' ' . '</td>'
                                    . '<td class="fondosan" style="color:white;">'. $row['sol_estudios'].' '. $row['det_labo'] . '</td>'
                                    . '<td class="fondosan" style="color:white;">
                                    <center><a href="../Laboratorio/pdf_solicitud_estu.php?id_atencion='.$row['id_atencion'].'&notid='.$row['not_id'].'&medico='.$row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nombre'].'&paciente='.$pac.'&tipo='.$row['sol_estudios'].'" target="_blank" ><button type="button" class="btn btn-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></td></center>';

                                echo '<td class="fondosan" style="color:white;"><center>'
                                    . ' <a href="../Laboratorio/subir_resultado.php?not_id=' . $row['not_id'] . '" title="Editar datos" class="btn btn-success "><span class="fa fa-cloud-upload" aria-hidden="true"></span></a>';
                                echo '</center></td></tr>';
                                $no++;
                            } else  {
                            
                                $query_rec = "SELECT * FROM receta_ambulatoria where id_rec_amb = $id_atencion ";
                                $result_rec = $conexion->query($query_rec);

                                while ($row_rec = $result_rec->fetch_assoc()) {
                                    $pac = $row_rec['papell_rec'] . ' ' . $row_rec['sapell_rec'] . ' ' . $row_rec['nombre_rec'];
                                    $habitacion = "C.EXT";
                                }
                                echo '<tr>'

                                    . '<td class="fondo" style="color:white;">' . $pac . '</td>'
                                    . '<td class="fondo" style="color:white;">' . $habitacion . '</td>'
                                    . '<td class="fondo" style="color:white;">' . $row['fecha_ord'] . '</td>'
                                    . '<td class="fondo" style="color:white;">' . $row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nombre'] . '</td>'
                                    . '<td class="fondo" style="color:white;"><a style="color: white;" href="../sauxiliares/Laboratorio/ver_paquete.php?nom=' . $row['sol_estudios'] . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> ' . $row['sol_estudios'] . '</a></td>'
                                    . '<td class="fondo" style="color:white;">' . $row['realizado'] . '</td>';

                                echo '<td class="fondo" style="color:white;"><center>'
                                    . ' <a href="../sauxiliares/Laboratorio/subir_resultado.php?not_id=' . $row['not_id'] . '" title="Editar datos" class="btn btn-success "><span class="fa fa-cloud-upload" aria-hidden="true"></span></a>';
                                echo '</center></td></tr>';
                                $no++;

                        }
                        
                       
                        
                    }
                            ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </section><!-- /.content -->
</section>
    </div><!-- /.content-wrapper -->

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