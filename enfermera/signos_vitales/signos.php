<?php
session_start();
//include "../../conexionbd.php";
include "../header_enfermera.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);

?>
<!DOCTYPE html>
<html>

<head>
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">



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
  <script>
    // Write on keyup event of keyword input element
    $(document).ready(function() {
      $("#search_dep").keyup(function() {
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
  <title>Registro de signos vitales</title>
  <style type="text/css">
    #contenido{
        display: none;
    }
     #contenido3{
        display: none;
    }
     #contenido4{
        display: none;
    }

</style>
 <style>
    td.fondo {
      background-color: info;
    }
  </style>
  <style>
    td.fondo2 {
      background-color: green !important;
    }
  </style>
  
</head>

<body>
  <section class="content container-fluid">

    <?php

    include "../../conexionbd.php";

    if (isset($_SESSION['pac'])) {
      $id_atencion = $_SESSION['pac'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias,p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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

        $sql_pac = "SELECT * FROM  dat_ingreso WHERE id_atencion =$id_atencion";

          $result_pac = $conexion->query($sql_pac);

          while ($row_pac = $result_pac->fetch_assoc()) {
            $fingreso = $row_pac['fecha'];
             $fegreso = $row_pac['fec_egreso'];
             $alta_med = $row_pac['alta_med'];
             $alta_adm = $row_pac['alta_adm'];
             $activo = $row_pac['activo'];
             $valida = $row_pac['valida'];
          }

if($alta_med=='SI' && $alta_adm=='SI' && $activo=='NO' && $valida=='SI'){
    
    $sql_est = "SELECT DATEDIFF('$fegreso', '$fingreso') as estancia FROM dat_ingreso where id_atencion = $id_atencion";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
         $estancia = $row_est['estancia'];
       
      }
}else{
    
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
}
      
function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}

//date_default_timezone_set('America/Guatemala');
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
<div class="container ">
        
   
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                 <tr><strong><center>CONSULTAR Y REGISTRAR SIGNOS VITALES</center></strong>
            </div>
           
         
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
  $cama = $row_hab['num_cama']; 
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
$result_vit = $conexion->query($sql_vit);
while ($row_vit = $result_vit->fetch_assoc()) {
$peso=$row_vit['peso'];
}if(!isset($peso)){
    $peso=0;
}   echo $peso;?></strong>
    </div>
   <div class="col-sm">
      Talla: <strong><?php $sql_vitt =" SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_vitt = $conexion->query($sql_vitt); 
while ($row_vitt = $result_vitt->fetch_assoc()) {
$talla=$row_vitt['talla'];
}
if(!isset($talla)){
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
      Estado de salud: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud DESC LIMIT 1";
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
  </font>

        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../../template/select_pac_enf.php";</script>';
      }
        ?>
        </div>
<body>
  <hr>
  
<br>

<form action="" method="POST">
 <div class="container-fluid">
<div class="container">
   
    <?php if($peso==0 and $talla==0){ ?>
    
    <form action="" method="POST" id="pesoytalla">
      <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
   <tr class="table-primary">
            <th colspan="9"><center><h5><strong>REGISTRAR PESO Y TALLA</strong></h5></center></th>
         </tr>
         <tr class="table-active">
      <!--<th scope="col" class="col-sm-1"><center>Tipo</center></th>-->
      <th scope="col"><center>Peso</center></th>
      <th scope="col"><center>Talla</center></th>
            <th scope="col"><center></center></th>
      </tr>
         </thead>
          <tbody>
    <tr>
<td><div class="col"><input type="text" class="form-control" id="peso" name="peso" =""></div></td>
<td><input type="text" class="form-control" name="talla" =""></td>
<td> <center>
     <input type="submit" name="btnpeso" class="btn btn-block btn-success btn-sm" value="Guardar">
    </center></td>
    </tr>
        
    </table>
    </div>
    </form>
    <?php
       if (isset($_POST['btnpeso'])) {
            include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];
    
$peso =  mysqli_real_escape_string($conexion, (strip_tags($_POST["peso"], ENT_QUOTES)));
$talla =  mysqli_real_escape_string($conexion, (strip_tags($_POST["talla"], ENT_QUOTES)));
    
$sqlp = "UPDATE dat_hclinica SET peso ='$peso', talla ='$talla' WHERE Id_exp=$id_exp and id_hc=$id_hc";
$resultp = $conexion->query($sqlp);

echo '<script type="text/javascript">window.location.href = "signos.php";</script>';
    }
    ?>
    
    <?php }
    ?>
      <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-primary">
            <th colspan="9"><center><h5><strong>REGISTRAR SIGNOS VITALES</strong></h5></center></th>
                
         </tr>
    <tr class="table-active">
      <!--<th scope="col" class="col-sm-1"><center>Tipo</center></th>-->
      <th scope="col" class="col-sm-1"><center>Hora</center></th>
      <th scope="col" class="col-sm-2"><center>Presón arterial</center></th>
      <th scope="col" class="col-sm-1"><center>Frecuencia cardiaca</center></th>
      <th scope="col" class="col-sm-1"><center>Frecuencia respiratoria</center></th>
     <th scope="col" class="col-sm-1"><center>Temperatura</center></th>
     <th scope="col" class="col-sm-1"><center>Saturación oxígeno</center></th>
     <?php if ($pac_sexo= 'Mujer') {?>
     <th scope="col" class="col-sm-1"><center>Frecuencia cardiaca fetal</center></th>
     <?php }?>
        <th scope="col" class="col-sm-1"><center><img src="../../imagenes/caras.png" width="250"> Nivel de dolor</center></th>
     
    </tr>
  </thead>
  <tbody>
    <tr>


      <td>
        <select class="form-control" name="hora_med" style="width : 100%; heigth : 100%" required="">
        <option value="">Seleccionar hora</option>
         <option value="8">8:00 A.M.</option>
         <option value="9">9:00 A.M.</option>
  <option value="10">10:00 A.M.</option>
  <option value="11">11:00 A.M.</option>
  <option value="12">12:00 A.M.</option>
  <option value="13">13:00 P.M.</option>
  <option value="14">14:00 P.M.</option>
  <option value="15">15:00 P.M.</option>
  <option value="16">16:00 P.M.</option>
  <option value="17">17:00 P.M.</option>
  <option value="18">18:00 P.M.</option>
  <option value="19">19:00 P.M.</option>
  <option value="20">20:00 P.M.</option>
  <option value="21">21:00 P.M.</option>
  <option value="22">22:00 P.M.</option>
  <option value="23">23:00 P.M.</option>
  <option value="24">24:00 A.M.</option>
  <option value="1">1:00 A.M.</option>
  <option value="2">2:00 A.M.</option>
  <option value="3">3:00 A.M.</option>
  <option value="4">4:00 A.M.</option>
  <option value="5">5:00 A.M.</option>
  <option value="6">6:00 A.M.</option>
  <option value="7">7:00 A.M.</option>
 

        </select>
      </td>
      <td>
<div class="row">
  <div class="col losInputTAM"><input type="number" class="form-control" id="sist" name="sist_mat" =""></div> /
  <div class="col losInputTAM"><input type="number" class="form-control" id="diast" name="diast_mat" =""></div>
 
</div></td>
      <td><input type="number" class="form-control" name="freccard_mat" ="">
    </div></td>
      <td><input type="number" class="form-control" name="frecresp_mat" ="">
    </div></td>
<td><input type="cm-number" class="form-control" name="temper_mat" onkeypress='return event.charCode != 44'>
    </div></td>
<td><input type="number"  class="form-control col-sm-12" name="satoxi_mat" min="1" pattern="^[0-9]+" onkeypress='return event.charCode != 45'>
<td><input type="number" class="form-control" name="freccard_fet" ="">
    </div></td>
    
    <td>
        <select class="form-control col-sm-12" name="niv_dolor" ="">
            <option value="">Seleccionar nivel de dolor</option>
             <option value="10">10</option>
             <option value="9">9</option>
             <option value="8">8</option>
             <option value="7">7</option>
             <option value="6">6</option>
             <option value="5">5</option>
             <option value="4">4</option>
             <option value="3">3</option>
             <option value="2">2</option>
             <option value="1" >1</option>
         
              <option value="0">0</option>
             
        </select>
   
        
    </div></td>
     
    </tr>
  </tbody>
</table>

<div class="container">
  <div class="row">
    <div class="col-sm-2">
     <strong>Fecha de reporte:</strong>
    </div>
    <div class="col-sm-3">
      <input type="date" value="<?php echo $fecha_actual = date("Y-m-d") ?>" name="fecha" class="form-control" required>
    </div>
   
  </div>
</div>



     </div><p></p>
     <center>
     <input type="submit" name="btnagregar" class="btn btn-block btn-success col-3" value="Agregar">
    </center>
    </form>
</div>

<?php

          if (isset($_POST['btnagregar'])) {
            include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];

$fecha =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
$hora_med =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_med"], ENT_QUOTES)));
$sist_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["sist_mat"], ENT_QUOTES)));
//$diast_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["diast_mat"], ENT_QUOTES)));
$freccard_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["freccard_mat"], ENT_QUOTES)));
$frecresp_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["frecresp_mat"], ENT_QUOTES)));
$temper_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["temper_mat"], ENT_QUOTES)));
$satoxi_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["satoxi_mat"], ENT_QUOTES)));
$niv_dolor =  mysqli_real_escape_string($conexion, (strip_tags($_POST["niv_dolor"], ENT_QUOTES)));
$freccard_fet =  mysqli_real_escape_string($conexion, (strip_tags($_POST["freccard_fet"], ENT_QUOTES)));


if (isset($_POST['diast_mat'])){$diast_mat=$_POST['diast_mat'];}else{$diast_mat='';}


if($hora_med=='8' ||$hora_med=='9' || $hora_med=='10' || $hora_med=='11'|| $hora_med=='12'|| $hora_med=='13' || $hora_med=='14'){
$turno="MATUTINO";
} else if ($hora_med=='15' || $hora_med=='16' || $hora_med=='17'|| $hora_med=='18'|| $hora_med=='19' || $hora_med=='20' || $hora_med=='21') {
  $turno="VESPERTINO";
}else if ($hora_med=='22' || $hora_med=='23' || $hora_med=='24'|| $hora_med=='1'|| $hora_med=='2' || $hora_med=='3' || $hora_med=='4' || $hora_med=='5' || $hora_med=='6' || $hora_med=='7') {
    $turno="NOCTURNO";
}

//date_default_timezone_set('America/Guatemala');
$fecha_actual = date("Y-m-d H:i a");

if ($hora_med == '1' || $hora_med == '2' || $hora_med == '3' || $hora_med == '4' || $hora_med == '5' || $hora_med == '6' || $hora_med == '7') {
   // Restamos un día a la fecha actual
   $yesterday = date('Y-m-d', strtotime('-1 day')) ; 
} else { 
   $yesterday = date("Y-m-d"); 
}

 $tam=($sist_mat + $diast_mat)/2;

$ingresarsignos = mysqli_query($conexion, 'INSERT INTO signos_vitales (
  id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,niv_dolor,hora,tipo,fecha_registro,fcardf,tam) values (' . $id_atencion . ' , ' . $id_usua . ' ,"' . $fecha. '", "' . $sist_mat . '" , "' . $diast_mat . '" , "' . $freccard_mat . '" , "' . $frecresp_mat . '" , "' . $temper_mat . '", "' . $satoxi_mat . '","' . $niv_dolor . '",' . $hora_med . ',"' . $area . '","' . $fecha_actual . '","' . $freccard_fet . '","' .$tam . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


           echo '<script type="text/javascript">window.location.href = "signos.php";</script>';
          }
          ?>    
          <div class="col col-12">
          
            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
            </div>
               <?php


?>
            <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
              
                    <th scope="col">Pdf</th>
                     <th scope="col">Fecha de registro</th>
                    <th scope="col">Fecha de reporte</th>
                    
                    <th scope="col">Tipo</th>
                    
                </tr>
                </thead>
                <tbody>

<?php
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$usua=$usuario['id_usua'];
$id_atencion=$_SESSION['pac'];
$resultado = $conexion->query("SELECT fecha,id_atencion,id_usua,hora,id_sig,p_sistol,p_diastol,fcard,fresp,temper,satoxi,niv_dolor, tipo,fecha_registro from signos_vitales s WHERE s.id_atencion=$id_atencion group by fecha ORDER BY id_sig DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_usua=$f['id_usua'];
      $resultado_usua = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua=$id_usua") or die($conexion->error);
        while($row = mysqli_fetch_array($resultado_usua)){

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias,p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

      $result_pac = $conexion->query($sql_pac);

      while ($row_pac = $result_pac->fetch_assoc()) {
        
      


?>          
                    <tr>
<td class="fondo"><a href="../signos_vitales/signos_vitales.php?id_ord=<?php echo $f['id_sig'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usua?>&fecha=<?php echo $f['fecha']?>&idexp=<?php echo $row_pac['Id_exp']?>"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></td>

         <td class="fondo"><strong><?php $daterr=date_create($f['fecha_registro']); echo date_format($daterr,"d-m-Y H:i a");?></strong></td>             
                       
<td class="fondo"><strong><?php $date=date_create($f['fecha']); echo date_format($date,"d-m-Y");?></strong></td>

<td class="fondo"><strong><?php echo $f['tipo'];?></strong></td>
<!--<td class="fondo"><strong><?php echo $row['nombre'].' '.$row['papell'].' '.$row['sapell']?></strong></td>-->
                    </tr>
                    <?php
}
    }
        }
                ?>
                
                </tbody>
              
            </table>
            </div>
<!-- FastClick -->

  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>
</body>
</html>