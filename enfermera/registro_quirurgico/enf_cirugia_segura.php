<?php
session_start();
//include "../../conexionbd.php";
include "../header_enfermera.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];
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

    <!---
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
  -->
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
    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function () {
            $("#search_dep").keyup(function () {
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
    <title>REGISTRO CLINICO QUIRÚRGICO</title>
    <style>
        hr.new4 {
            border: 1px solid red;
        }
    </style>
</head>

<body>
<section class="content container-fluid">

    <?php

    include "../../conexionbd.php";

    if (isset($_SESSION['pac'])) {
      $id_atencion = $_SESSION['pac'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias, p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

      $result_pac = $conexion->query($sql_pac);

      while ($row_pac = $result_pac->fetch_assoc()) {
        $pac_papell = $row_pac['papell'];
        $pac_sapell = $row_pac['sapell'];
        $pac_nom_pac = $row_pac['nom_pac'];
        $pac_dir = $row_pac['dir'];
        $pac_id_edo = $row_pac['id_edo'];
        $pac_id_mun = $row_pac['id_mun'];
        $pac_tel = $row_pac['tel'];
        $pac_fecnac = $row_pac['fecnac'];
        $pac_fecing = $row_pac['fecha'];
        $pac_tip_sang = $row_pac['tip_san'];
        $pac_sexo = $row_pac['sexo'];
        $area = $row_pac['area'];
        $alta_med = $row_pac['alta_med'];
        $id_exp = $row_pac['Id_exp'];
        $alergias = $row_pac['alergias'];
        $folio = $row_pac['folio'];
      }

      $sql_now = "SELECT DATE_ADD(NOW(), INTERVAL 12 HOUR) as dat_now FROM dat_ingreso WHERE id_atencion = $id_atencion";

      $result_now = $conexion->query($sql_now);

      while ($row_now = $result_now->fetch_assoc()) {
        $dat_now = $row_now['dat_now'];
      }

      $sql_est = "SELECT DATEDIFF( '$dat_now' , fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
        $estancia = $row_est['estancia'];
      }

      ///inicio bisiesto
function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}

date_default_timezone_set('America/Mexico_City');
$fecha_actual = date("Y-m-d");
$fecha_nac=$pac_fecnac;
$fecha_de_nacimiento =strval($fecha_nac);

// separamos en partes las fechas
$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
$array_actual = explode ( "-", $fecha_actual );

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

//ajuste de posible negativo en $días
if ($dias < 0)
{
    --$meses;

    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
    switch ($array_actual[1]) {
           case 1:     $dias_mes_anterior=31; break;
           case 2:     $dias_mes_anterior=31; break;
           case 3:     
               if (bisiesto($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
               
           case 4:     $dias_mes_anterior=31; break;
           case 5:     $dias_mes_anterior=30; break;
           case 6:     $dias_mes_anterior=31; break;
           case 7:     $dias_mes_anterior=30; break;
           case 8:     $dias_mes_anterior=31; break;
           case 9:     $dias_mes_anterior=31; break;
           case 10:     $dias_mes_anterior=30; break;
           case 11:     $dias_mes_anterior=31; break;
           case 12:     $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

//echo "<br>Tu edad es: $anos años con $meses meses y $dias días";

    ?>
      <div class="container">
        <div class="content">
         <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 25px;">
                 <tr><strong><center>NOTA CIRUGIA SEGURA (LISTADO DE VERIFICACIÓN DE SEGURIDAD QUIRÚRGICA)</center></strong>
        </div>
         <hr>
 <font size="2">
         <div class="container">
  <div class="row">
    <div class="col-sm-6">
    Expediente: <strong><?php echo $folio?> </strong>
     Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    <div class="col-sm">
      Área: <strong><?php echo $area ?></strong>
    </div>
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm">
      Fecha de ingreso: <strong><?php echo date_format($date, "d-m-Y") ?></strong>
    </div>
  </div>
</div></font>

 <font size="2">
     <div class="container">
  <div class="row">
    <div class="col-sm">
       <?php $date1 = date_create($pac_fecnac);
   ?>
      Fecha de nacimiento: <strong><?php echo date_format($date1, "d-m-Y") ?></strong>
    </div>
    <div class="col-sm">
      Tipo de sangre: <strong><?php echo $pac_tip_sang ?></strong>
    </div>
   
      <div class="col-sm">
      Habitación: <strong><?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);                                                                                    while ($row_hab = $result_hab->fetch_assoc()) {
  echo $row_hab['num_cama'];
} ?></strong>
    </div>
    <div class="col-sm">
      Tiempo estancia: <strong><?php echo $estancia ?> Dias</strong>
    </div>
  </div>
</div>
</font>
 <font size="2">
  <div class="container">
  <div class="row">
   <div class="col-sm-3">
      Edad: <strong><?php if($anos > "0" ){
   echo $anos." años";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." meses";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." dias";
}
?></strong>
    </div>
    <div class="col-sm-3">

      Peso: <strong><?php $sql_vit = "SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
      
$result_vit = $conexion->query($sql_vit);                                                                                    while ($row_vit = $result_vit->fetch_assoc()) {
    $peso=$row_vit['peso'];

} if (!isset($peso)){
    $peso=0;
   
}   echo $peso;?></strong>
    </div>
  
      <div class="col-sm">
      Talla: <strong><?php $sql_vitt =" SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_vitt = $conexion->query($sql_vitt);                                                                                    while ($row_vitt = $result_vitt->fetch_assoc()) {
    $talla=$row_vitt['talla'];
 
} if (!isset($talla)){
    
    $talla=0;
}   echo $talla;?></strong>
    </div>
 <div class="col-sm">
      Género: <strong><?php echo $pac_sexo ?></strong>
    </div>
     
  </div>
</div>
</font>
 <font size="2">
  <div class="container">
  <div class="row">
    <div class="col-sm-3">
      Alergias: <strong><?php echo $alergias ?></strong>
    </div>
    <div class="col-sm-6">
      Estado de salud: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud ASC LIMIT 1";
$result_edo = $conexion->query($sql_edo);                                                                                    while ($row_edo = $result_edo->fetch_assoc()) {
  echo $row_edo['edo_salud'];
} ?></strong>
    </div>
      
     <div class="col-sm">
    Aseguradora: <strong><?php $sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha DESC limit 1";
$result_aseg = $conexion->query($sql_aseg);
while ($row_aseg = $result_aseg->fetch_assoc()) {
echo $row_aseg['aseg'];
} ?></strong>
    </div>
  </div>
</div>
</font>
 <font size="2">
<div class="container">
  <div class="row">
    <div class="col-sm-4">
   <?php 
$d="";
      $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by diagprob_i ASC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } ?>
    <?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
    $result_mot = $conexion->query($sql_mot);
    while ($row_mot = $result_mot->fetch_assoc()) {
    $m=$row_mot['motivo_atn'];
    } ?>

    <?php if ($d!=null) {
       echo '<td> Diagnóstico: <strong>' . $d .'</strong></td>';
    } else{
          echo '<td"> Motivo de atención: <strong>' . $m .'</strong></td>';
    }?>
    </div>
  </div>
</div></font>
<hr>
 
<form action="insertar_cir_seg.php" method="POST">

  <div class="row">
    <div class="col-sm">
     <!--INICIO DE CARD-->
<div class="card" style="width: 22rem;">
  <div class="card-body">
    <center><h6 class="card-title"><strong>Fase 1: Entrada <p>Antes de la inducción de la anestesia</strong></h6></center><hr>
    <h7 class="card-subtitle text-bold">El cirujano, el anestesiólogo y el personal de enfermería en presencia del paciente han confirmado:</h7><p>
     <div class="form-check">
  <input class="form-check-input" type="checkbox" id="URGENCIAS" value="Si" name="identidad">
  <label class="form-check-label" for="URGENCIAS">
  Su identidad.
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="sitquir" value="Si" name="sitquir">
  <label class="form-check-label" for="sitquir">
    
  El sitio quirúrgico.
  
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="procquir" value="Si" name="procquir">
  <label class="form-check-label" for="procquir">
    
  El procedimiento quirúrgico.
  
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="suconsen" value="Si" name="suconsen">
  <label class="form-check-label" for="suconsen">
    
  Su consentimiento.
  
  </label>
</div>
<hr>
<div class="container">
  <div class="row">
    <strong>¿El personal de enfermería ha confirmado con el cirujano que esté marcado el sitio quirúrgico?</strong>
      <div class="form-check col-4">
  <input class="form-check-input" type="radio" id="lugar" value="Si" name="lug_noproc">
  <label class="form-check-label" for="lugar">
   Si
  </label>
</div>
 
    
       <div class="form-check">
  <input class="form-check-input" type="radio" id="noprocede" value="No procede" name="lug_noproc">
  <label class="form-check-label" for="noprocede">
    No procede
  </label>
</div>
    
    </div>
  </div>
  <hr>
  <strong>El cirujano ha confirmado la realización de asepsia en el sitio quirúrgico:</strong>
   <div class="form-check">
  <input class="form-check-input" type="radio" id="verificado" value="Si" name="circonfase">
  <label class="form-check-label" for="verificado">
    Si
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" id="verificadono" value="No" name="circonfase">
  <label class="form-check-label" for="verificadono">
    No
  </label>
</div>
<hr>
<strong>El anestesiólogo ha completado el control de la seguridad de la anestesia al revisar: medicamentos, equipo (funcionalidad y condiciones óptimas) y el riesgo anestésico del paciente.</strong>
 <div class="form-check">
  <input class="form-check-input" type="radio" id="conseg" value="Si" name="conseg">
  <label class="form-check-label" for="conseg">
   Si
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" id="consegno" value="No" name="conseg">
  <label class="form-check-label" for="consegno">
   No
  </label>
</div>
<hr>

<strong>El anestesiólogo ha colocado y comprobado que funcione el oxímetro de pulso correctamente.</strong>
 <div class="form-check">
  <input class="form-check-input" type="radio" id="oximetro" value="Si" name="oximetro">
  <label class="form-check-label" for="oximetro">
   Si
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" id="oximetrono" value="No" name="oximetro">
  <label class="form-check-label" for="oximetrono">
   No
  </label>
</div>
   <hr>
    <strong>El anestesiólogo ha confirmado si el paciente tiene:</strong><br>
    <p>¿Alergias conocidas?</p>
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="aler_conno" value="No" name="alerg_con">
  <label class="form-check-label" for="aler_conno">
 No
  </label>
</div>
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="aler_consi" value="Si" name="alerg_con">
  <label class="form-check-label" for="aler_consi">
   Si
  </label>
</div>
    </div>
  </div>
  <hr>
   
    <p><strong>¿Vía aérea difícil y/o riesgo de aspiración?</strong></p>
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="difviano" value="No" name="dif_via_aerea">
  <label class="form-check-label" for="difviano">
 No
  </label>
</div>
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="difviasi" value="Si" name="dif_via_aerea">
  <label class="form-check-label" for="difviasi">
   Si, y se cuenta con material, equipo y ayuda disponible.
  </label>
</div>
    </div>
  </div>
<hr>
   <p><strong>¿Riesgo de hemorragia en adultos >500 ml. (niños >7 ml / kg)?</strong></p>
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="hematiesno" value="No" name="reishemo">
  <label class="form-check-label" for="hematiesno">
 No
  </label>
</div>
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="hematiessi" value="Si" name="reishemo">
  <label class="form-check-label" for="hematiessi">
   Si, y se ha previsto la disponibilidad de líquidos y dos vías centrales.
  </label>
</div>
    </div>
  </div>
  <hr>
   <p><strong>¿Posible necesidad de hemoderivados y soluciones disponibles?</strong></p>
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="posned" value="No" name="nechemo">
  <label class="form-check-label" for="posned">
 No
  </label>
</div>
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="cruce" value="Si" name="nechemo">
  <label class="form-check-label" for="cruce">
 Si, y ya se ha realizado el cruce de sangre
  </label>
</div>
    </div>
  </div>

  </div>
</div>
     <!--FIN DE CARD-->
    </div>
    <div class="col-sm">
      <!--INICIO DE SEGUNDA CARD-->
<div class="card" style="width: 22rem;">
  <div class="card-body">
    <h6 class="card-title"><strong><center>Fase 2: Pausa quirúrgica<p>Antes de la incisión cutánea</strong></center></h6><hr>
    <h7 class="card-subtitle mb-2 text-bold">El circulante ha identificado a cada uno de los miembros del quipo quirúrgico para se presenten por su nombre y función, sin omisiones.</h7><p>
   
      <div class="form-check">
  <input class="form-check-input" type="checkbox" id="confmp" value="Si" name="fcirujano">
  <label class="form-check-label" for="confmp">
   Cirujano
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="fayucir" value="Si" name="fayucir">
  <label class="form-check-label" for="fayucir">
   Ayudante de cirujano
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="fanest" value="Si" name="fanest">
  <label class="form-check-label" for="fanest">
  Antestesiólogo
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="Instrumentista" value="Si" name="instrumentista">
  <label class="form-check-label" for="Instrumentista">
   Instrumentista
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="fotros" value="Otros" name="fotros">
  <label class="form-check-label" for="fotros">
   Otros
  </label>
</div>

<hr>
 
    <strong>El cirujano, ha confirmado de manera verbal con el anestesiólogo y el personal de enfermería:</strong>
    
 <div class="form-check">
  <input class="form-check-input" type="checkbox" id="paccorr" value="Si" name="paccorr">
  <label class="form-check-label" for="paccorr">
  Paciente correcto
  </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" id="proccorr" value="Si" name="proccorr">
  <label class="form-check-label" for="proccorr">
    Procedimiento correcto
  </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" id="sitquird" value="Si" name="sitquird">
  <label class="form-check-label" for="sitquird">
    Sitio quirúrgico
  </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" id="encas" value="Si" name="encas">
  <label class="form-check-label" for="encas">
    En caso de órgano bilateral, ha marcado derecho o izquierdo, según corresponda
  </label>
</div>
  
  <div class="form-check">
  <input class="form-check-input" type="checkbox" id="casmul" value="Si" name="casmul">
  <label class="form-check-label" for="casmul">
    En caso de estructura múltiple, ha especificado el nivel a operar.
  </label>
</div>
  
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="poscpac" value="Si" name="poscpac">
  <label class="form-check-label" for="poscpac">
      Posición correcta del paciente.
  </label>
</div>
   
  
  
<hr>
<strong><p>¿El anestesiólogo y el personal de enfermería han verificado que se haya aplicado la profilaxis antibiótica conforme a las indicaciones médicas?</p></strong>
  <div class="form-check">
  <input class="form-check-input" type="radio" id="cirresi" value="Si" name="anverpro">
  <label class="form-check-label" for="cirresi">
  Si
  </label>
</div>

     <div class="form-check">
  <input class="form-check-input" type="radio" id="anesresi" value="No" name="anverpro">
  <label class="form-check-label" for="anesresi">
  No
  </label>
</div>

 <div class="form-check">
  <input class="form-check-input" type="radio" id="enfresi" value="No procede" name="anverpro">
  <label class="form-check-label" for="enfresi">
  No procede
  </label>
</div>
<hr>

<p><strong>El cirujano y el personal de enfermería han verificado que cuenta con los estudios de imagen que requiere?</strong></p>
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="diag_esesi" value="Si" name="img_diag">
  <label class="form-check-label" for="diag_esesi">
 Si
  </label>
</div>
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="diag_eseno" value="No procede" name="img_diag">
  <label class="form-check-label" for="diag_eseno">
  No procede
  </label>
</div>
    </div>
  </div>
<hr>
  <div class="form-group">
    <label for="texto"></i><strong> Previsión de Eventos Críticos:</strong></label>
  <p><strong>El cirujano ha informado:</strong>

<div class="form-check">
  <input class="form-check-input" type="checkbox" id="pasocri" value="Si" name="pasocri">
  <label class="form-check-label" for="pasocri">
  Los pasos críticos o no sistematizados.
</label>
    </div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="durope" value="Si" name="durope">
  <label class="form-check-label" for="durope">
  La duración de la operación.
</label>
    </div>
    <div class="form-check">
  <input class="form-check-input" type="checkbox" id="persangre" value="Si" name="persangre">
  <label class="form-check-label" for="persangre">
  La pérdida de sangre prevista.
</label>
    </div>

<strong>El anestesiólogo ha informado:</strong>
 <div class="form-check">
  <input class="form-check-input" type="checkbox" id="exriesen" value="Si" name="exriesen">
  <label class="form-check-label" for="exriesen">
  La existencia de algún riesgo o enfermedad en el paciente que pueda complicar la cirugía.
</label>
    </div>

<strong>El personal de enfermería ha informado:</strong>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="fechm" value="Si" name="fechm">
  <label class="form-check-label" for="fechm">
 La fecha y método de esterilización del equipo y el instrumental.
    </div>
 
     <div class="form-check">
  <input class="form-check-input" type="checkbox" id="exproble" value="Si" name="exproble">
  <label class="form-check-label" for="exproble">
La existencia de algún problema con el instrumental, los equipos y el conteo del mismo.
    </div> 
  
</div>
</div>
</div>

      <!--TERMINO DE SEGUNDA CAR-->

    </div>
    <div class="col-sm">
     <!--INICIO DE TERCER CAR-->
<div class="card" style="width: 22rem;">
  <div class="card-body">
    <h6 class="card-title"><strong><center>Fase 3: Salida</center><p>Antes de que el paciente salga de quirófano</strong></h6><hr>
    <h7 class="card-subtitle mb-2 text-bold">El cirujano responsable de la atención del paciente, en presencia del anestesiólogo y el personal de enfermería, ha aplicado la Lista de Verificación de la Seguridad de la Cirugía y ha confirmado verbalmente:</h7><p>
   <div class="form-check">
  <input class="form-check-input" type="checkbox" id="nomprocre" value="Si" name="nomprocre">
  <label class="form-check-label" for="nomprocre">
  El nombre del procedimiento realizado:
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="recuento" value="Si" name="recuento">
  <label class="form-check-label" for="recuento">
El recuento completo del instrumental, gasas y agujas.
  </label>
</div>
<div class="container">
  <div class="row">
   <div class="form-check">
  <input class="form-check-input" type="checkbox" id="etqmu" value="Si" name="etqmu">
  <label class="form-check-label" for="etqmu">
El etiquetado de las muestras (nombre completo del paciente, fecha de nacimiento, fecha de cirugía y descripción general).
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="proineq" value="Si" name="proineq">
  <label class="form-check-label" for="proineq">
Los problemas con el instrumental y los equipos que deben ser notificados y resueltos.
  </label>
</div> 
   
  </div>
</div>
<hr>
<p><strong>El cirujano y el anestesiólogo han comentado al personal de enfermería circulante:</strong></p>
  <div class="row">
    
   <div class="form-check">
  <input class="form-check-input" type="checkbox" id="prinrecpost" value="Si" name="prinrecpost">
  <label class="form-check-label" for="prinrecpost">
Los principales aspectos de la recuperación postoperatoria.
  </label>
</div> 
    
     <div class="form-check">
  <input class="form-check-input" type="checkbox" id="plantrat" value="Si" name="plantrat">
  <label class="form-check-label" for="plantrat">
El plan de tratamiento.
  </label>
</div> 
    <div class="form-check">
  <input class="form-check-input" type="checkbox" id="riesgpaci" value="Si" name="riesgpaci">
  <label class="form-check-label" for="riesgpaci">
Los riesgos del paciente.
  </label>
</div> 
  </div>

<hr>
<strong>¿Ocurrieron eventos adversos?</strong>
<div class="form-check">
  <input class="form-check-input" type="radio" id="eventosad" value="Si" name="eventosad">
  <label class="form-check-label" for="eventosad">
Si
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" id="eventosadno" value="No" name="eventosad">
  <label class="form-check-label" for="eventosadno">
No
  </label>
</div> 
<hr>

<strong>¿Se registro el evento adverso?</strong>
<div class="form-check">
  <input class="form-check-input" type="radio" id="eventosada" value="Si" name="reieventad">
  <label class="form-check-label" for="eventosada">
Si
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" id="eventosadnoa" value="No" name="reieventad">
  <label class="form-check-label" for="eventosadnoa">
No
  </label><p>
  ¿Dónde?<input type="text" name="donde" class="form-control">
</div> 

<hr>
<div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>Listado del personal responsable que participó en la aplicación y llenado de esta lista de verificación.</strong></label>


  </div>
    <div class="form-group">
    <label for="cirujano"><button type="button" class="btn btn-success btn-sm" id="playcir"><i class="fas fa-play"></button></i>
 Cirujano(s)</label>
    <input type="text" class="form-control" id="cirujano" value="" name="fir_cir">
  </div>
<script type="text/javascript">
const cirujano = document.getElementById('cirujano');
const btnPlayTextjano = document.getElementById('playcir');

btnPlayTextjano.addEventListener('click', () => {
        leerTexto(cirujano.value);
});

function leerTexto(cirujano){
    const speech = new SpeechSynthesisUtterance();
    speech.text= cirujano;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="form-group">
    <label for="anes"><button type="button" class="btn btn-success btn-sm" id="playtes"><i class="fas fa-play"></button></i> Antestesiólogo(s)</label>
    <input type="text" class="form-control" id="anes" value="" name="fir_anest">
  </div>
<script type="text/javascript">
const anes = document.getElementById('anes');
const btnPlayTextlogo = document.getElementById('playtes');

btnPlayTextlogo.addEventListener('click', () => {
        leerTexto(anes.value);
});

function leerTexto(anes){
    const speech = new SpeechSynthesisUtterance();
    speech.text= anes;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="form-group">
    <label for="enfermera"><button type="button" class="btn btn-success btn-sm" id="playfer"><i class="fas fa-play"></button></i>Personal de Enfermería</label>
    <input type="text" class="form-control" id="enfermera" value="" name="fir_enf">
  </div>
    <script type="text/javascript">
const enfermera = document.getElementById('enfermera');
const btnPlayTxte = document.getElementById('playfer');

btnPlayTxte.addEventListener('click', () => {
        leerTexto(enfermera.value);
});

function leerTexto(enfermera){
    const speech = new SpeechSynthesisUtterance();
    speech.text= enfermera;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  </div>
</div>
     <!--TERMINO DE CAR-->
    </div>
  </div>
</div>



<!--<?php 
//$usuario = $_SESSION['login'];
//$resultado = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='" . $usuario . "'") or die($conexion->error);
 ?>-->



 <hr>

                        <center><div class="form-group col-6">
                            <button type="submit" class="btn btn-primary">FIRMAR Y GUARDAR</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button>
                        </div></center>

                        <br>
                        </form>
</div> <!--TERMINO DE NOTA MEDICA div container-->


            <?php
            } else {
                echo '<script type="text/javascript"> window.location.href="../../template/select_pac_enf.php";</script>';
            }
            ?>
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

<script type="text/javascript">
    $('.losInput8 input').on('change', function(){
  var total = 0;
  $('.losInput8 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal8 input').val(total.toFixed());
});


    $('.losInput2 input').on('change', function(){
  var total = 0;
  $('.losInput2 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal2 input').val(total.toFixed());
});

</script>

</body>

</html>