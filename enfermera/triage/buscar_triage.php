<?php
session_start();
include "../../conexionbd.php";
include("../header_enfermera.php");

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

    <title>Menu Gestión Médica </title>
    <link rel="shortcut icon" href="logp.png">
</head>
<div class="container">

</div>

<div>

    <!-- Right side column. Contains the navbar and content of the page -->

    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col col-12">

                    <a href="vista_usuario_triage.php" class="btn btn-danger">Regresar...</a>
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                                      id="side"></i></a>
                    <p/>
                     <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 22px;">
                           <tr><strong><center>CONSULTAR TRIAGE</center></strong>
                     </div>
                     <br>

                    <div class="text-center">
                    </div>
                    
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                                      id="side"></i></a>
                    
                   
                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search"
                               placeholder="BUSCAR...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead">
                            <tr>
                                <th scope="col">Fecha de registro</th>
                                <th scope="col">Expediente</th>
                                <th scope="col">Nombre del paciente</th>
                                
                                <th scope="col">Fecha de nacimiento</th>
                                
                                <th scope="col">Pdf</th>
                                
                              <!--  <th scope="col">Update</th>  -->
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage,triage.fecha_t
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage ORDER BY fecha_t DESC
") or die($conexion->error);
$usuario = $_SESSION['login'];
                            while ($f = mysqli_fetch_array($resultado)) { 

$id_atencion = $f['id_atencion'];

$sql_urgen = "SELECT * FROM dat_c_urgen u where id_atencion = $id_atencion";
$result_urgen = $conexion->query($sql_urgen);

while ($row_urgen = $result_urgen->fetch_assoc()) {
  $diab_pa = $row_urgen['diab_pa'];
 $diab_ma = $row_urgen['diab_ma'];
 $diab_ab = $row_urgen['diab_ab'];

  $hip_pa = $row_urgen['hip_pa'];
   $hip_ma = $row_urgen['hip_ma'];
    $hip_ab = $row_urgen['hip_ab'];

  $can_pa = $row_urgen['can_pa'];
    $can_ma = $row_urgen['can_ma'];
      $can_ab = $row_urgen['can_ab'];


  $motcon_cu = $row_urgen['motcon_cu'];
  $trau_cu = $row_urgen['trau_cu'];
  $trans_cu = $row_urgen['trans_cu'];
  $adic_cu = $row_urgen['adic_cu'];
  $quir_cu = $row_urgen['quir_cu'];
    $aler_cu = $row_urgen['aler_cu'];
  $pad_cu = $row_urgen['pad_cu'];
  $exp_cu = $row_urgen['exp_cu'];
  $diag_cu = $row_urgen['diag_cu'];

  $gestas_cu = $row_urgen['gestas_cu'];
  $partos_cu = $row_urgen['partos_cu'];
  $ces_cu = $row_urgen['ces_cu'];
  $abo_cu = $row_urgen['abo_cu'];
  $fecha_fur = $row_urgen['fecha_fur'];

  $proc_cu = $row_urgen['proc_cu'];
  $med_cu = $row_urgen['med_cu'];
  $anproc_cu = $row_urgen['anproc_cu'];
  $trat_cu = $row_urgen['trat_cu'];
  $do_cu = $row_urgen['do_cu'];
  $dis_cu = $row_urgen['dis_cu'];
  $fecha_urgen = $row_urgen['fecha_urgen'];
  
}

$sql_urgen2 = "SELECT * FROM recetaurgen where id_atencion = $id_atencion";
$result_urgen2 = $conexion->query($sql_urgen2);

while ($row_urgen2 = $result_urgen2->fetch_assoc()) {
$id_rec_urgen = $row_urgen2['id_rec_urgen'];
}
?>


                        <tr>
                        <td><strong><?php $date = date_create($f['fecha_t']);
                                            echo date_format($date, "d/m/Y H:i"); ?></strong></td>
                        <td><strong><?php echo $f['Id_exp']; ?></strong></td>
                        <td><strong><?php echo $f['nom_pac'].' ' .$f['papell'].' '.$f['sapell']; ?></strong></td>
                        
                        <td><strong><?php $date = date_create($f[5]);echo date_format($date, "d/m/Y"); ?></strong></td>
                        
                        <td><a type="submit" class="btn btn-danger btn-sm" href="pdf_triage.php?tri= <?php echo $f['id_triage'] ?>&id=<?php echo $f['id_atencion']; ?>&id_med=<?php echo $usuario['id_usua'] ?>&rec=<?php echo $id_rec_urgen ?>"target="_blank"><span class="fa fa-file-pdf-o"style="font-size:28px"></span></a></td>

                        <!--<td><a type="submit" class="btn btn-danger btn-sm" href="pdf_consulta_urgencias.php?tri=<?php  echo $f['id_atencion']; ?>&id_med=<?php echo $usuario['id_usua'] ?>&rec=<?php echo $id_rec_urgen ?>"target="_blank"><span class="fa fa-file-pdf-o"style="font-size:28px"></span></a></td>-->



               <!--         <td><a type="submit" class="btn btn-warning btn-sm" href="../updates_urgencias/update_triage.php?id_atencion=<?php echo $f['id_atencion']; ?>&id_triage=<?php echo $f['id_triage'] ?>"><span class="fa fa-pencil-square-o"style="font-size:28px"></span></a></td>    -->

                        </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>


        </div>

    </section><!-- /.content -->


</div><!-- ./wrapper -->
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