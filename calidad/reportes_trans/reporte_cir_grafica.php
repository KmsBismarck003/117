<?php
include '../../conexionbd.php';

$mes = @$_POST['mes'];
$anio = @$_POST['anio'];
$diagn = @$_POST['diag'];
mysqli_set_charset($conexion, "utf8");

  ?>
  <?php
session_start();
//include "../conexionbd.php";
include "../header_calidad.php";


if ($mes==1) {
    $mess='ENERO';
  }

 if ($mes==2) {
    $mess='FEBRERO';
  }
   if ($mes==3) {
    $mess='MARZO';
  }
 if ($mes==4) {
    $mess='ABRIL';
  }
  if ($mes==5) {
    $mess='MAYO';
  }
   if ($mes==6) {
    $mess='JUNIO';
  }
   if ($mes==7) {
    $mess='JULIO';
  }
   if ($mes==8) {
    $mess='AGOSTO';
  }
   if ($mes==9) {
    $mess='SEPTIMBRE';
  }
   if ($mes==10) {
    $mess='OCTUBRE';
  }
   if ($mes==11) {
    $mess='NOVIEMBRE';
  }
   if ($mes==12) {
    $mess='DICIEMBRE';
  }
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

    <title> ALTA DE USUARIOS </title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>




    <div class="container">
  <div class="row">
    <div class="col-sm">
      <img src="../../imagenes/logo.jpg" height="50" width="165">
    </div>
    <div class="col-sm-8">
      <div class="thead">
     <h3><center><font id="letra"> GRÁFICA DE CIRUGIAS REALIZADAS
DEL MES DE <?php echo $mess ?></font></h3></center>
   </div>
    </div>
    <div class="col-sm">
     
    </div>
  </div>
</div>
            <h2>
             



<section class="content container-fluid">
    <div class="container box">
        <div class="content">




<!-- consulta 1-->
 <?php 
 

$diag_postop = '';
$cuantos = '';


 $sql_tabla = "SELECT diag_postop, COUNT(diag_postop) as cuantos FROM `dat_not_inquir`
 WHERE MONTH(fecha)=$mes and YEAR(fecha)=$anio GROUP BY 1 HAVING COUNT(diag_postop)>=1 ORDER BY cuantos DESC";

$result2 = $conexion->query($sql_tabla);
while ($f2 = $result2->fetch_assoc()) {

$cuantos = $cuantos . '"'. $f2['cuantos'].'",';

$diag_postop = $diag_postop . '"'. $f2['diag_postop'].'",';
}
$diag_postop = trim($diag_postop,",");
$cuantos = trim($cuantos,",");




 $sql_tabla3 = "SELECT count(diag_postop) as sum FROM `dat_not_inquir` 
 WHERE MONTH(fecha)=$mes and YEAR(fecha)=$anio";
$result3 = $conexion->query($sql_tabla3);
while ($f3 = $result3->fetch_assoc()) {
$sum=$f3['sum'];
}


?>

 







<div class="container" id="contenidoago">
  <div class="row">
    <div class="col-sm">
     <div class="bg-info text-black " style="max-width: 100rem;">
  <div class="card-body">

<h5 class="card-title"><span id="idVendidos">
<font size="5" color="white">TOTAL DE CIRUGIAS: <strong> <?php echo $sum?></strong></font>
</span></h5>
  </div>
</div>  
    </div>
  </div>
<hr>
<div class="container" >
  <div class="row">
    <div class="col-sm-12"><h4 class="text-center"></h4></div>
 <div class="col-sm-11">
      <h6 class="text-center"></h6>
       <canvas id="20" class="grafica"></canvas>
    </div>
  </div>
</div>
            </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<br>
</div>
</div>
    </div>

    <footer class="main-footer">
        <?php
        include("../../template/footer.php");
        ?>
    </footer>

<script src="../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- FastClick -->
<script src='../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../template/dist/js/app.min.js" type="text/javascript"></script>

<script src="../js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



<script>
                var ctx = document.getElementById("20").getContext('2d');
                var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php echo $diag_postop?>],
                    datasets: 
                    [{
                        label: 'CIRUGIAS',
                        data: [<?php echo $cuantos; ?>],
                       backgroundColor: [

                'rgba(255, 99, 132, 0.2)',
                'rgba(0, 155, 125, 0.2)',
                'rgba(245, 208, 51, 0.4)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
                        borderWidth: 2
                    }]

                },
             
                options: {
                    scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
                    tooltips:{mode: 'index'},
                    legend:{display: true, position: 'fixed', labels: {fontColor: 'rgb(255,25,255)', fontSize: 26}}
                }
            });
            </script>


</body>
</html> 