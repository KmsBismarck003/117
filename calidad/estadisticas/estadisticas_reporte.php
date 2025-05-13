<?php
include '../../conexionbd.php';

$mes = @$_POST['mes'];
$anio = @$_POST['anio'];

mysqli_set_charset($conexion, "utf8");

  ?>
  <?php
session_start();
//include "../conexionbd.php";
include "../header_calidad.php";

$resultado=$conexion->query("select * from reg_usuarios") or die($conexion->error);
$sql_dat_eg = "SELECT * from encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result_dat_eg = $conexion->query($sql_dat_eg);

while ($row_dat_eg = $result_dat_eg->fetch_assoc()) {
  $id_encuesta = $row_dat_eg['id_encuesta'];
}

if(isset($id_encuesta)){
    $id_encuesta = $id_encuesta;
  }else{
    $id_encuesta ='sin doc';
  }

if($id_encuesta=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO HAY DATOS PARA ESTADÍSTICAS DE ESTE MES", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                              window.location="estadisticas.php";
                            }
                        });
                    });
                </script>';
}else{
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
     <h3><center><font id="letra"> ESTADÍSTICAS DE LA ENCUESTA DEL MES DE <?php echo $mess ?></font></h3></center>
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
$res = "SELECT fecenc,count(resrep) as rep FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $rep = $f['rep'];
}
$sql_tabla = "SELECT resrep FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$resrep = $f['resrep'];

if($resrep>=9){
  $agsan=$agsan+1;
}else if($resrep<=6){
 $agsanm=$agsanm+1; 
}
}
$rep1= ($agsan*100/$rep)-($agsanm*100/$rep); 
$rep2= ($agsan*100/$rep); 
$rep3= ($agsanm*100/$rep); 
?>

<!-- consulta 2-->
<?php 
$res = "SELECT fecenc,count(resenf) as ren FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $ren = $f['ren'];
}
$sql_tabla = "SELECT resenf FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$resenf = $f['resenf'];

if($resenf>=9){
  $agsan=$agsan+1;
}else if($resenf<=6){
 $agsanm=$agsanm+1; 
}
}
$ren1= ($agsan*100/$ren)-($agsanm*100/$ren); 
$ren2= ($agsan*100/$ren); 
$ren3= ($agsanm*100/$ren); 
?>

<!-- consulta 3-->
<?php 
$res = "SELECT fecenc,count(resmed) as rme FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $rme = $f['rme'];
}
$sql_tabla = "SELECT resmed FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$resmed = $f['resmed'];

if($resmed>=9){
  $agsan=$agsan+1;
}else if($resmed<=6){
 $agsanm=$agsanm+1; 
}
}
$rme1= ($agsan*100/$rme)-($agsanm*100/$rme); 
$rme2= ($agsan*100/$rme); 
$rme3= ($agsanm*100/$rme); 
?>

<!-- consulta 4-->
<?php 
$res = "SELECT fecenc,count(resotro) as ro FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $ro = $f['ro'];
}
$sql_tabla = "SELECT resotro FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$resotro = $f['resotro'];

if($resotro>=9){
  $agsan=$agsan+1;
}else if($resotro<=6){
 $agsanm=$agsanm+1; 
}
}
$ro1= ($agsan*100/$ro)-($agsanm*100/$ro); 
$ro2= ($agsan*100/$ro); 
$ro3= ($agsanm*100/$ro); 
?>

<!-- consulta 5-->
<?php 
$res = "SELECT fecenc,count(solrec) as sre FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $sre = $f['sre'];
}
$sql_tabla = "SELECT solrec FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$solrec = $f['solrec'];

if($solrec>=9){
  $agsan=$agsan+1;
}else if($solrec<=6){
 $agsanm=$agsanm+1; 
}
}
$sre1= ($agsan*100/$sre)-($agsanm*100/$sre); 
$sre2= ($agsan*100/$sre); 
$sre3= ($agsanm*100/$sre); 
?>

<!-- consulta 6-->
<?php 
$res = "SELECT fecenc,count(solenf) as sf FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $sf = $f['sf'];
}
$sql_tabla = "SELECT solenf FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$solenf = $f['solenf'];

if($solenf>=9){
  $agsan=$agsan+1;
}else if($solenf<=6){
 $agsanm=$agsanm+1; 
}
}
$sf1= ($agsan*100/$sf)-($agsanm*100/$sf); 
$sf2= ($agsan*100/$sf); 
$sf3= ($agsanm*100/$sf); 
?>

<!-- consulta 7-->
<?php 
$res = "SELECT fecenc,count(solmed) as sm FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $sm = $f['sm'];
}
$sql_tabla = "SELECT solmed FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$solmed = $f['solmed'];

if($solmed>=9){
  $agsan=$agsan+1;
}else if($solmed<=6){
 $agsanm=$agsanm+1; 
}
}
$sm1= ($agsan*100/$sm)-($agsanm*100/$sm); 
$sm2= ($agsan*100/$sm); 
$sm3= ($agsanm*100/$sm); 
?>

<!-- consulta 8-->
<?php 
$res = "SELECT fecenc,count(solotro) as s FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $s = $f['s'];
}
$sql_tabla = "SELECT solotro FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$solotro = $f['solotro'];

if($solotro>=9){
  $agsan=$agsan+1;
}else if($solotro<=6){
 $agsanm=$agsanm+1; 
}
}
$s1= ($agsan*100/$s)-($agsanm*100/$s); 
$s2= ($agsan*100/$s); 
$s3= ($agsanm*100/$s); 
?>

<!-- consulta 9-->
<?php 
$res = "SELECT fecenc,count(brrec) as brr FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $brr = $f['brr'];
}
$sql_tabla = "SELECT brrec FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$brrec = $f['brrec'];

if($brrec>=9){
  $agsan=$agsan+1;
}else if($brrec<=6){
 $agsanm=$agsanm+1; 
}
}
$brr1= ($agsan*100/$brr)-($agsanm*100/$brr); 
$brr2= ($agsan*100/$brr); 
$brr3= ($agsanm*100/$brr); 
?>

<!-- consulta 10-->
<?php 
$res = "SELECT fecenc,count(brenf) as br FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $br = $f['br'];
}
$sql_tabla = "SELECT brenf FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$brenf = $f['brenf'];

if($brenf>=9){
  $agsan=$agsan+1;
}else if($brenf<=6){
 $agsanm=$agsanm+1; 
}
}
$br1= ($agsan*100/$br)-($agsanm*100/$br); 
$br2= ($agsan*100/$br); 
$br3= ($agsanm*100/$br); 
?>

<!-- consulta 11-->
<?php 
$res = "SELECT fecenc,count(brmed) as bm FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $bm = $f['bm'];
}
$sql_tabla = "SELECT brmed FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$brmed = $f['brmed'];

if($brmed>=9){
  $agsan=$agsan+1;
}else if($brmed<=6){
 $agsanm=$agsanm+1; 
}
}
$bm1= ($agsan*100/$bm)-($agsanm*100/$bm); 
$bm2= ($agsan*100/$bm); 
$bm3= ($agsanm*100/$bm); 
?>

<!-- consulta 12-->
<?php 
$res = "SELECT fecenc,count(brotro) as b FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $b = $f['b'];
}
$sql_tabla = "SELECT brotro FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$brotro = $f['brotro'];

if($brotro>=9){
  $agsan=$agsan+1;
}else if($brotro<=6){
 $agsanm=$agsanm+1; 
}
}
$b1= ($agsan*100/$b)-($agsanm*100/$b); 
$b2= ($agsan*100/$b); 
$b3= ($agsanm*100/$b); 
?>

<!-- consulta 13-->
<?php 
$res = "SELECT fecenc,count(servins) as i FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $i = $f['i'];
}
$sql_tabla = "SELECT servins FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$servins = $f['servins'];

if($servins>=9){
  $agsan=$agsan+1;
}else if($servins<=6){
 $agsanm=$agsanm+1; 
}
}
$e1= ($agsan*100/$i)-($agsanm*100/$i); 
$e2= ($agsan*100/$i); 
$e3= ($agsanm*100/$i); 
?>

<!-- consulta 14-->
<?php 
$res = "SELECT fecenc,count(servlim) as lim FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $lim = $f['lim'];
}
$sql_tabla = "SELECT servlim FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsanl=0;
$agsanml=0; 
while ($f = $result_tabla->fetch_assoc()) {
$servlim = $f['servlim'];

if($servlim>=9){
  $agsanl=$agsanl+1;
}else if($servlim<=6){
 $agsanml=$agsanml+1; 
}
}
$li1= ($agsanl*100/$lim)-($agsanml*100/$lim); 
$li2= ($agsanl*100/$lim); 
$li3= ($agsanml*100/$lim); 
?>

<!-- consulta 15-->
<?php 
$res = "SELECT fecenc,count(servropa) as ropa FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $ropa = $f['ropa'];
}
$sql_tabla = "SELECT servropa FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$servropa = $f['servropa'];

if($servropa>=9){
  $agsan=$agsan+1;
}else if($servropa<=6){
 $agsanm=$agsanm+1; 
}
}
$s= ($agsan*100/$ropa)-($agsanm*100/$ropa); 
$ropa2= ($agsan*100/$ropa); 
$ropa3= ($agsanm*100/$ropa); 
?>

<!-- consulta 16-->
<?php 
$res = "SELECT fecenc,count(servali) as ser FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $ser = $f['ser'];
}
$sql_tabla = "SELECT servali FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$servali = $f['servali'];

if($servali>=9){
  $agsan=$agsan+1;
}else if($servali<=6){
 $agsanm=$agsanm+1; 
}
}
$ser1= ($agsan*100/$ser)-($agsanm*100/$ser); 
$ser2= ($agsan*100/$ser); 
$ser3= ($agsanm*100/$ser); 
 ?>

<!-- consulta 17-->
<?php 
$res = "SELECT fecenc,count(recsan) as totenc FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $totenc = $f['totenc'];
}
$sql_tabla = "SELECT recsan FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$recsan = $f['recsan'];

if($recsan>=9){
  $agsan=$agsan+1;
}else if($recsan<=6){
 $agsanm=$agsanm+1; 
}
}
$tot= ($agsan*100/$totenc)-($agsanm*100/$totenc); 
$tot2= ($agsan*100/$totenc); 
$tot3= ($agsanm*100/$totenc); 
 ?>

<!-- consulta 18-->
<?php 
$res = "SELECT fecenc,count(lab) as la FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $la = $f['la'];
}
$sql_tabla = "SELECT lab FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$lab = $f['lab'];

if($lab>=9){
  $agsan=$agsan+1;
}else if($lab<=6){
 $agsanm=$agsanm+1; 
}
}
$totl= ($agsan*100/$la)-($agsanm*100/$la); 
$totl2= ($agsan*100/$la); 
$totl3= ($agsanm*100/$la); 
 ?>

<!-- consulta 19-->
<?php 
$res = "SELECT fecenc,count(imagen) as im FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $im = $f['im'];
}
$sql_tabla = "SELECT imagen FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$imagen = $f['imagen'];

if($imagen>=9){
  $agsan=$agsan+1;
}else if($imagen<=6){
 $agsanm=$agsanm+1; 
}
}
$totl= ($agsan*100/$im)-($agsanm*100/$im); 
$toti2= ($agsan*100/$im); 
$toti3= ($agsanm*100/$im); 
 ?>
 <!-- consulta 20-->
<?php 
$res = "SELECT fecenc,count(vig) as vi FROM encuestas WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
$result = $conexion->query($res);
while ($f = $result->fetch_assoc()) {
  $vi = $f['vi'];
}
$sql_tabla = "SELECT vig FROM `encuestas` WHERE MONTH(fecenc)=$mes and YEAR(fecenc)=$anio";
  $result_tabla = $conexion->query($sql_tabla);
$agsan=0;
$agsanm=0; 
while ($f = $result_tabla->fetch_assoc()) {
$vig = $f['vig'];

if($vig>=9){
  $agsan=$agsan+1;
}else if($vig<=6){
 $agsanm=$agsanm+1; 
}
}
$totvi= ($agsan*100/$vi)-($agsanm*100/$vi); 
$totvi2= ($agsan*100/$vi); 
$totvi3= ($agsanm*100/$vi); 
 ?>
<div class="container" id="contenidoago">
  <div class="row">
    <div class="col-sm">
     <div class="bg-info text-black " style="max-width: 100rem;">
  <div class="card-body">

<a href="vista_encuestas.php"><h5 class="card-title"><span id="idVendidos">
<font size="3" color="white"><strong>TOTAL DE ENCUESTAS REALIZADAS:</strong> <strong> <?php echo $rep ?></strong></font>
</span></h5></a>

  </div>
</div>  
    </div>
  </div>



<hr>
<div class="container" >
  <div class="row">
    <h4 class="text-center">1. ELIGA UNA CALIFICACIÓN SI FUE ATENDIDO CON RESPETO POR PARTE DEL PERSONAL DE: </h4>
 <div class="col-sm-3"><br>
      <h6 class="text-center"> RECEPCIÓN</h6>
       <canvas id="1" class="grafica"></canvas>
    </div>
     <div class="col-sm-3"><br>
      <h6 class="text-center"> ENFERMERÍA</h6>
       <canvas id="2" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center"> MÉDICO</h6>
       <canvas id="3" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center">OTRO PERSONAL DEL SANATORIO</h6>
       <canvas id="4" class="grafica"></canvas>
    </div>
  </div>
</div>
<hr>
<div class="container" >
  <div class="row">
    <h4 class="text-center">2. ELIGA UNA CALIFICACIÓN SI FUE ATENDIDO AL MOMENTO DE SOLICITARLO POR PARTE DEL PERSONAL DE: </h4>
 <div class="col-sm-3"><br>
      <h6 class="text-center"> RECEPCIÓN</h6>
       <canvas id="5" class="grafica"></canvas>
    </div>
     <div class="col-sm-3"><br>
      <h6 class="text-center"> ENFERMERÍA</h6>
       <canvas id="6" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center"> MÉDICO</h6>
       <canvas id="7" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center">OTRO PERSONAL DEL SANATORIO</h6>
       <canvas id="8" class="grafica"></canvas>
    </div>
  </div>
</div>
<hr>
<div class="container" >
  <div class="row">
    <h4 class="text-center">3. BRINDE SU GRADO DE SATISFACCIÓN CON LA CALIDAD DE LA ATENCIÓN RECIBIDA: </h4>
 <div class="col-sm-3"><br>
      <h6 class="text-center"> RECEPCIÓN</h6>
       <canvas id="9" class="grafica"></canvas>
    </div>
     <div class="col-sm-3"><br>
      <h6 class="text-center"> ENFERMERÍA</h6>
       <canvas id="10" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center"> MÉDICO</h6>
       <canvas id="11" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center">OTRO PERSONAL DEL SANATORIO</h6>
       <canvas id="12" class="grafica"></canvas>
    </div>
  </div>
</div>
<hr>
<div class="container" >
  <div class="row">
    <div class="col-sm-12"><h4 class="text-center">4. ELIGA UNA CALIFICACIÓN DE LOS SERVICIOS RECIBIDOS DE:</h4></div>
 <div class="col-sm-3"><br>
      <h6 class="text-center">INSTALACIONES DEL HOSPITAL</h6>
       <canvas id="13" class="grafica"></canvas>
    </div>
     <div class="col-sm-3"><br>
      <h6 class="text-center">LIMPIEZA DE HABITACIÓN</h6>
       <canvas id="14" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center">ROPA DE LA HABITACIÓN</h6>
       <canvas id="15" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center">SERVICIO DE ALIMENTACIÓN</h6>
       <canvas id="16" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center">SERVICIO DE LABORATORIO</h6>
       <canvas id="18" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center">SERVICIO DE IMAGENOLOGÍA</h6>
       <canvas id="19" class="grafica"></canvas>
    </div>
    <div class="col-sm-3"><br>
      <h6 class="text-center">SERVICIO DE VIGILANCIA</h6>
       <canvas id="20" class="grafica"></canvas>
    </div>
  </div>
</div>
<hr>
<div class="container" >
  <div class="row">
    <div class="col-sm-12"><h4 class="text-center">5. ELIGA UNA ESCALA DE RECOMENDACIÓN:</h4></div>
 <div class="col-sm-3">
      <h6 class="text-center"> RECOMENDARÍA USTED AL SANATORIO VENECIA A OTRAS PERSONAS</h6>
       <canvas id="17" class="grafica"></canvas>
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
var ctx = document.getElementById('1').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($rep3) ?>,<?php echo round($rep2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('2').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($ren3) ?>,<?php echo round($ren2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('3').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($rme3) ?>,<?php echo round($rme2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('4').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($ro3) ?>,<?php echo round($ro2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('5').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($sre3) ?>,<?php echo round($sre2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>


<script>
var ctx = document.getElementById('6').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($sf3) ?>,<?php echo round($sf2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('7').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($sm3) ?>,<?php echo round($sm2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('8').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($s3) ?>,<?php echo round($s2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('9').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($brr3) ?>,<?php echo round($brr2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('10').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($br3) ?>,<?php echo round($br2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>


<script>
var ctx = document.getElementById('11').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($bm3) ?>,<?php echo round($bm2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('12').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($b3) ?>,<?php echo round($b2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('13').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($e3) ?>,<?php echo round($e2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('14').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($li3) ?>,<?php echo round($li2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('15').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [ <?php echo round($ropa3) ?>,<?php echo round($ropa2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<script>
var ctx = document.getElementById('16').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [<?php echo round($ser3) ?>,<?php echo round($ser2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

 <script>
var ctx = document.getElementById('17').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [<?php echo round($tot3)?>,<?php echo round($tot2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('18').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [<?php echo round($totl3)?>,<?php echo round($totl2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('19').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [<?php echo round($toti3)?>,<?php echo round($toti2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<script>
var ctx = document.getElementById('20').getContext('2d');
var idGrafica = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [' % INSATISFECHO',' % SATISFECHO'],
        datasets: [{
            label: '# de Votos',
            data: [<?php echo round($totvi3)?>,<?php echo round($totvi2) ?>],
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
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php }
 ?>
</body>
</html> 