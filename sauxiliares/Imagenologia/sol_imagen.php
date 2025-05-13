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
    include "../header_imagen.php";

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_imagen.php";
} else {
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
     <title>Médica del Ángel Custodio</title>
    <link rel="icon" href="../img/icono.png">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Morris chart -->
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css"/>
    <!-- jvectormap -->
    <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css"/>
    <!-- Daterange picker -->
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <style>
        .dropdwn {
            float: left;
            overflow: hidden;
        }

        .dropdwn .dropbtn {
            cursor: pointer;
            font-size: 16px;
            border: none;
            outline: none;
            color: white;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
        }

        .navbar a:hover,
        .dropdwn:hover .dropbtn,
        .dropbtn:focus {
            background-color: #367fa9;
        }

        .dropdwn-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdwn-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdwn-content a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }

        * {
            box-sizing: border-box;
        }

        .todo-container {
            max-width: 15000px;
            height: auto;
            display: flex;
            overflow-y: scroll;
            column-gap: 0.5em;
            column-rule: 1px solid white;
            column-width: 140px;
            column-count: 7;
        }

        .status {
            width: 25%;
            background-color: #ecf0f5;
            position: relative;
            padding: 60px 1rem 0.5rem;
            height: 100%;

        }

        .status h4 {
            position: absolute;
            top: 0;
            left: 0;
            background-color: #0b3e6f;
            color: white;
            margin: 0;
            width: 100%;

            padding: 0.5rem 1rem;
        }
        td.fondo {
            background-color: red !important;
        }

    </style>
</head>

<body>


    <br>
    <br>
    
        <section class="content">
            <br>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>ESTUDIOS DE IMAGENOLOGÍA PENDIENTES</center></strong>
      </div><br>
       <div class="col-sm-3">
             <a href="../../sauxiliares/Imagenologia/programacion_quir.php"><button type="button" class="btn btn-danger">AGENDA QUIRÚRGICA <i class="fa-solid fa-address-book"></i></button></a>
             </div><br>
            <section class="content container-fluid">
                <div class="content box">
                    <!-- CONTENIDOO -->

                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search"
                               placeholder="Buscar...">
                    </div>
                    <br>

                    <div class="table-responsive">
                        <!--<table id="myTable" class="table table-striped table-hover">-->

                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead" style="background-color: #2b2d7f; color:white;">
                                <tr>
                                <th><font color="white">Habitación</th>
                                <th><font color="white">Paciente</th>
                                <th><font color="white">Fecha de solicitud</th>
                                <th><font color="white">Solicitante</th>
                                <th><font color="white">Estudio(s)</th>
                                <th><font color="white">Realizado</th>
                                <th><font color="white">Interpretado</th>
                                <th><font color="white">Solicitud de estudio</th> 
                                <th><font color="white">Subir Qr</th>
                                <th><font color="white">Ver estudio</th>
                                <th><font color="white">Subir interpretación</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

                            include "../conexionbd.php";



                            $query = " SELECT * FROM notificaciones_imagen n, reg_usuarios u where (n.interpretado = 'NO'|| n.realizado = 'NO') and n.id_usua = u.id_usua AND activo = 'SI' order by fecha_ord DESC ";
                            $result = $conexion->query($query);
                            $no = 1;

                            while ($row = $result->fetch_assoc()) {

                                $habi = $row['habitacion'];
                                $id_atencion = $row['id_atencion'];
                                $es=$row['sol_estudios'].'/ '.$row['det_imagen'] ;
$sql_dat_ingi = "SELECT * from cat_servicios where serv_desc='$es'";
                     $result_dat_inga = $conexion->query($sql_dat_ingi);

                     while ($row_dat_ingu = $result_dat_inga->fetch_assoc()) {
                    //$desc = $row_dat_ingu['serv_desc'];
                    $tipins = $row_dat_ingu['tip_insumo'];
  
                    }


                            if ($habi <> 0)  {
                                $query_pac = "SELECT * FROM dat_ingreso d, paciente p where d.id_atencion = $id_atencion and d.Id_exp = p.Id_exp";
                                $result_pac = $conexion->query($query_pac);

                                while ($row_pac = $result_pac->fetch_assoc()) {
                                    $pac = $row_pac['papell'] . ' ' . $row_pac['sapell'] . ' ' . $row_pac['nom_pac'];
                                }
                                $query_pac = "SELECT * FROM dat_ingreso d, paciente p where d.id_atencion = $id_atencion and d.Id_exp = p.Id_exp";
                                $result_pac = $conexion->query($query_pac);

                                echo '<tr>'
                                    . '<td class="fondo" style="color:white;">' . $row['habitacion'] . '</td>'
                                    . '<td class="fondo" style="color:white;"> ' . $pac . '</td>'
                                    . '<td class="fondo" style="color:white;">' . $row['fecha_ord'] . '</td>'
                                    . '<td class="fondo" style="color:white;">' . $row['papell'] . ' ' . $row['sapell'] . '</td>'
                                    . '<td class="fondo" style="color:white;">' . $es. '</a></td>'
                                    . '<td class="fondo" style="color:white;"><center>' . $row['realizado'] . '</td></center>'
                                    . '<td class="fondo" style="color:white;"><center>' . $row['interpretado'] . '</td></center>'
                                  
                                    .' <td class="fondo" style="color:white;"><center><a href="../sauxiliares/Imagenologia/pdf_solicitud_estu.php?id_atencion='.$row['id_atencion'].'&notid='.$row['not_id'].'&medico='.$row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nombre'].'&paciente='.$pac.'&tipo='.$row['sol_estudios'].'" target="_blank" ><button type="button" class="btn btn-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></td></center>';
                               

                                echo '<td class="fondo" style="color:white;"><center>'
                                    . ' <a href="../sauxiliares/Imagenologia/subir_resultado.php?not_id=' . $row['not_id'] . '&id_usua=' . $row['id_usua'] . '" title="Subir Qr" class="btn btn-success "><span class="fa fa-cloud-upload" aria-hidden="true"></span></a>'

                                    . '<td class="fondo" style="color:white; font-size:30px;" ><a href="' . $row['link']  . '" target="_blank" title="Ver estudio"><center><i class="fa fa-eye" aria-hidden="true" ></i></center></a></td>'
                                
                                    . '<td class="fondo" style="color:white;"><center>'
                                    . ' <a href="../sauxiliares/Imagenologia/subir_interpretacion.php?not_id=' . $row['not_id'] . '&id_usua=' . $row['id_usua'] . '" title="Subir Qr" class="btn btn-success "><i class="fa fa-upload" aria-hidden="true"></i></a>'
                                 ;

                                echo '</center></td></tr>';
                                $no++;
                            
                             } else  {
                                $query_rec = "SELECT * FROM receta_ambulatoria where id_rec_amb = $id_atencion";
                                $result_rec = $conexion->query($query_rec);

                                while ($row_rec = $result_rec->fetch_assoc()) {
                                    $pac = $row_rec['papell_rec'] . ' ' . $row_rec['sapell_rec'] . ' ' . $row_rec['nombre_rec'];
                                    $habitacion = "C.EXT";
                                }
                               echo '<tr>'

                                    . '<td class="fondo" style="color:white;">' . $row['id_atencion'] . ' ' . $pac . '</td>'
                                    . '<td class="fondo" style="color:white;">' . $habitacion . '</td>'
                                    . '<td class="fondo" style="color:white;">' . $row['fecha_ord'] . '</td>'
                                    . '<td class="fondo" style="color:white;">' . $row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nombre'] . '</td>'
                                    . '<td class="fondo" style="color:white;">' . $row['sol_estudios'] . '</a></td>'
                                    . '<td class="fondo" style="color:white;">' . $row['realizado'] . '</td>';

                               

                                echo '<td class="fondo" style="color:white;"><center>'
                                    . ' <a href="../sauxiliares/Imagenologia/subir_resultado.php?not_id=' . $row['not_id'] . '" title="Editar datos" class="btn btn-success "><span class="fa fa-cloud-upload" aria-hidden="true"></span></a>';
                                echo '</center></td></tr>';
                                $no++;

                             } }
                            ?>
                            </tbody>
                        </table>
                    </div>


                </div>

            </section><!-- /.content -->
</section>
   

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