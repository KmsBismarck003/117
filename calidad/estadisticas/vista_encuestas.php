<?php
session_start();
//include "../conexionbd.php";
include "../header_calidad.php";
$resultado=$conexion->query("select * from reg_usuarios") or die($conexion->error);
?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/aos.js"></script>
    <script src="../js/main.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function(){
            $("#search").keyup(function(){
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function() {
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
    </script>

    <title> ESTADISTICAS </title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>




    <div class="row">
        <div class="col  col-12">
            <h2>
             
                <center><font id="letra"><i class="fa fa-question-circle"></i> RESULTADOS DE LA ENCUESTA</font></h2></center>

</h2></div></div>

<section class="content container-fluid">
    <div class="container box">
        <div class="content">




              <?php

include "../../conexionbd.php";

$resultado = $conexion->query("select dat_ingreso.*,encuestas.*,paciente.*
from dat_ingreso inner join encuestas on dat_ingreso.id_atencion=encuestas.id_atencion
inner join paciente on dat_ingreso.Id_exp=paciente.Id_exp order by fecenc DESC")or die($conexion -> error);

?>
            <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead table-success">
                <tr>
                    <th scope="col">DATOS</th>
                      <th scope="col">NOMBRE DEL PACIENTE</th>
                    <th scope="col">EXPEDIENTE</th>
                    <th scope="col">FECHA</th>
                    <th scope="col">HORA</th>
                </tr>
                </thead>
                <tbody>

                <?php
                while($f = mysqli_fetch_array($resultado)){
                  $id_encuesta=$f['id_encuesta'];
 $id_atencion=$f['id_atencion'];
  $Id_exp=$f['Id_exp'];
                    ?>

                    <tr>
                        <td><a href="res_encuestas.php?id_encuesta=<?php echo $id_encuesta; ?>&id_exp=<?php echo $Id_exp ?>&id_atencion=<?php echo $id_atencion ?>&nombre=<?php echo $f['papell']. ' ' .$f['sapell']. ' ' . $f['nom_pac']; ?>" target="_blank" ><button type="button" class="btn btn-danger"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></td>
                              <td><strong><?php echo $f['papell']. ' ' .$f['sapell']. ' ' . $f['nom_pac'];?></strong></td>
                        <td><strong><?php echo $f['Id_exp'];?></strong></td>
                        <td><strong><?php $date=date_create($f['fecenc']); echo date_format($date,"d/m/Y");?></strong></td>
                        <td><strong><?php $date=date_create($f['fecenc']); echo date_format($date,"h:i");;?></strong></td>
                    </tr>
                    <?php
                }

                ?>
                </tbody>
              
            </table>
            </div>



</body>
</html>