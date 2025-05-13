<?php
session_start();
include "../../conexionbd.php";
include "../header_enfermera.php";

$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];

?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">
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

    <style>
        td.fondo {
            background-color: red !important;
        }
    </style>

</head>

<body>

<section class="content container-fluid">

    <div class="container box">
        <div class="content">
            <br>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <strong><center>SALIDAS DE QUIRÓFANO

         </center></strong>
      </div><br>


            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>

            <div class="table-responsive">
                <!--<table id="myTable" class="table table-striped table-hover">-->

                <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #2b2d7f; color:white;">
                    <tr>
                        <th><font color="white">Expediente</th>
                        <th><font color="white">Id_atencion</th>
                        <th><font color="white">Paciente</th>
                        <th><font color="white">Fecha de ingreso</th>
                        
                    </tr>
                    </thead>
                    <tbody>
    
                                  <!--PAGINADOR-->
                        <?php 

$limite= 50; 
$totalQuery = $conexion->query('select count(DISTINCT paciente) FROM sales_ceye')or die($conexion->error);
$totalProductos = mysqli_fetch_row($totalQuery);
$totalBotones = round($totalProductos[0] /$limite); 
//die($totalBotones); numero de botones que saldran
if(isset($_GET['limite'])){
$resultado = $conexion->query("SELECT DISTINCT s.paciente= di.id_atencion,di.*, p.* FROM sales_ceye s, dat_ingreso di, paciente p WHERE s.paciente = di.id_atencion and di.Id_exp = p.Id_exp ORDER BY di.id_atencion DESC limit ".$_GET['limite'].",".$limite)or die($conexion -> error);
}else{
    
$resultado = $conexion->query("SELECT DISTINCT s.paciente= di.id_atencion,di.*, p.* FROM sales_ceye s, dat_ingreso di, paciente p WHERE s.paciente = di.id_atencion and di.Id_exp = p.Id_exp ORDER BY di.id_atencion DESC limit ".$limite)or die($conexion -> error); 
}
while($fila = mysqli_fetch_array($resultado)){
  $fecing = date_create($fila['fecha']);
  echo '<tr>'
                            . '<td><a type="submit" class="btn btn-danger btn-sm" href="select_fecha_vista.php?id_atencion=' . $fila['id_atencion'] . '">' . $fila['Id_exp'] . '</a></td>'
                            . '<td>' . $fila['id_atencion'] . '</a></td>'
                            . '<td>' . $fila['papell'] . " " .  $fila['sapell']. " " . $fila['nom_pac'] . '</td>'
                            . '<td>' . date_format($fecing,"m/m/Y H:i") . '</a></td>';
                        echo '</tr>';
}
?>
                        
                        
                        
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<div class="row" data-aos="fade-up" id="botones">
              <div class="col-md-12 text-center">
                <div class="site-block-27">
                  <ul>
                      <font color="steelblue">Seleccionar páginas para más busquedas</font><hr>
                   
<?php
if(isset($_GET['limite'])){ 
if($_GET['limite']>0){ 
echo '<li><a href="salidas.php?limite='.($_GET['limite']-50).'">&lt;</a></li>';
    } }
    for($k=0;$k<$totalBotones;$k++){ 
echo '<li><a href="salidas.php?limite='.($k*50).'">'.($k+1).'</a></li>'; 
}
if(isset($_GET['limite'])){ 
if($_GET['limite']+50<$totalBotones*50){ 
echo'<li><a href="salidas.php?limite='.($_GET['limite']+50).'">&gt;</a></li>';   
    }
}else{
echo'<li><a href="salidas.php?limite=50">&gt;</a></li>';
}
?>
                    
                   
                  </ul>
                </div>
              </div>
            </div>
            <br>
</div>

<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>

<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
<script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>

</html>