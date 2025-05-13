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
    <title>DETALLE DE LA CUENTA</title>
    <style>
        hr.new4 {
            border: 1px solid red;
        }
    </style>
</head>

<body>
<section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->

    <?php

    include "../../conexionbd.php";

    if (isset($_SESSION['pac'])) {
      $id_atencion = $_SESSION['pac'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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

      function calculaedad($fechanacimiento)
      {
        list($ano, $mes, $dia) = explode("-", $fechanacimiento);
        $ano_diferencia  = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia   = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
          $ano_diferencia--;
        return $ano_diferencia;
      }

      $edad = calculaedad($pac_fecnac);

    ?>
      <div class="container">
        <div class="content">
          
            <h2>REGISTRO CLÍNICO, ESQUEMA TERAPÉUTICO E INTERVENCIONES DE ENFERMERÍA DE LA UNIDAD DE CUIDADOS INTENSIVOS</h2>
         <hr>
 <font size="2">
         <div class="container">
  <div class="row">
    <div class="col-sm">
     NOMBRE DEL PACIENTE: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    <div class="col-sm">
      ÁREA: <strong><?php echo $area ?></strong>
    </div>
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm">
      FECHA DE INGRESO: <strong><?php echo date_format($date, "d-m-Y H:i:s") ?></strong>
    </div>
  </div>
</div></font>

 <font size="2">
     <div class="container">
  <div class="row">
    <div class="col-sm">
       <?php $date1 = date_create($pac_fecnac);
   ?>
      F. DE NACIMIENTO: <strong><?php echo date_format($date, "d-m-Y") ?></strong>
    </div>
    <div class="col-sm">
      GRUPO Y RH: <strong><?php echo $pac_tip_sang ?></strong>
    </div>
   
      <div class="col-sm">
      HABITACIÓN: <strong><?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);                                                                                    while ($row_hab = $result_hab->fetch_assoc()) {
  echo $row_hab['num_cama'];
} ?></strong>
    </div>
    <div class="col-sm">
      TIEMPO ESTANCIA: <strong><?php echo $estancia ?> Dias</strong>
    </div>
  </div>
</div>
</font>
 <font size="2">
  <div class="container">
  <div class="row">
    <div class="col-sm-3">
      EDAD: <strong><?php echo $edad ?></strong>
    </div>
    <div class="col-sm-3">

      PESO: <strong><?php $sql_vit = "SELECT peso from signos_vitales where id_atencion=$id_atencion ORDER by peso ASC LIMIT 1";
$result_vit = $conexion->query($sql_vit);                                                                                    while ($row_vit = $result_vit->fetch_assoc()) {
  echo $row_vit['peso'];
} ?></strong>
    </div>
  
      <div class="col-sm">
      TALLA: <strong><?php $sql_vitt = "SELECT talla from signos_vitales where id_atencion=$id_atencion ORDER by talla ASC LIMIT 1";
$result_vitt = $conexion->query($sql_vitt);                                                                                    while ($row_vitt = $result_vitt->fetch_assoc()) {
  echo $row_vitt['talla'];
} ?></strong>
    </div>

     <div class="col-sm-4">
      DIAGNÓSTICO MÉDICO: <strong><?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
$result_mot = $conexion->query($sql_mot);                                                                                    while ($row_mot = $result_mot->fetch_assoc()) {
  echo $row_mot['motivo_atn'];
} ?></strong>
    </div>
  </div>
</div>
</font>
 <font size="2">
  <div class="container">
  <div class="row">
    <div class="col-sm">
      GÉNERO: <strong><?php echo $pac_sexo ?></strong>
    </div>
    <div class="col-sm">
      EDO DE CONCIENCIA: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud ASC LIMIT 1";
$result_edo = $conexion->query($sql_edo);                                                                                    while ($row_edo = $result_edo->fetch_assoc()) {
  echo $row_edo['edo_salud'];
} ?></strong>
    </div>
      <div class="col-sm">
      NO. EXPEDIENTE: <strong><?php echo $id_exp?> </strong>
    </div>
     <div class="col-sm">
    SEGURO: <strong><?php $sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha DESC limit 1";
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
    <div class="col-sm">
      ALERGIAS: <strong><?php echo $alergias ?></strong>
    </div>
   
  </div>
</div></font>
<hr>
<div class="container">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="btn btn-outline-success" id="nav-home-tab" data-toggle="tab" href="#nav-nota" role="tab" aria-controls="nav-home" aria-selected="true">NOTA</button>

    <button class="btn btn-outline-success" id="nav-profile-tab" data-toggle="tab" href="#nav-med" role="tab" aria-controls="nav-profile" aria-selected="true"> MEDICAMENTOS Y EQUIPOS </button>
    
    <button class="btn btn-outline-success" id="nav-contact-tab" data-toggle="tab" href="#nav-ing" role="tab" aria-controls="nav-contact" aria-selected="true">DISPOSITIVOS INVASIVOS, INGRESOS</button>

    <button class="btn btn-outline-success" id="nav-contact-tab" data-toggle="tab" href="#nav-egr" role="tab" aria-controls="nav-contact" aria-selected="true">INSULINOTERAPIA, GLICEMIA, CISTOCLISIS</button>
  </div>

</div>

<div class="tab-content" id="nav-tabContent">

  <!--INICIO NOTA-->
          <?php
$resultado2 = $conexion->query("SELECT * from dat_not_preop WHERE id_atencion=$id_atencion ORDER BY id_not_preop DESC LIMIT 1 ")or die($conexion->error);
?>

<?php
$resultado3 = $conexion->query("SELECT * from dat_not_inquir WHERE id_atencion=$id_atencion ORDER BY id_not_inquir DESC LIMIT 1" )or die($conexion->error);
?>
<?php
$resultado4 = $conexion->query("SELECT * from dat_trans_anest WHERE id_atencion=$id_atencion ORDER by id_trans_anest  DESC  LIMIT 1" )or die($conexion->error);
?> 
  <div class="tab-pane fade" id="nav-nota" role="tabpanel" aria-labelledby="nav-home-tab">  
<br><br>
<form action="insertar_regquir.php" method="POST">
<div class="container">
  <div class="row">
      
      
                    <div class="col-sm-4">
                        <label class="control-label">Fecha: </label>
                        <input type="date" class="form-control" name="fecha" class="form-control">
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label">Hora: </label>
                        <input type="time" name="hora" class="form-control">
                    </div>
                
  </div>
                    <hr>
                    <center><h3>PREOPERATORIO</h3></center><hr>
  <div class="row">
    <div class="col">
     <div class="form-group">
      <?php
                    while ($fila = mysqli_fetch_array($resultado2)) {

                        ?>
    <label for="exampleFormControlTextarea1"><strong>DIAGNÓSTICO PREOPERATORIO</strong></label>
    <input type="text" class="form-control" value="<?php echo $fila['diag_preop']; ?>"  id="exampleFormControlTextarea1" required rows="3" name="diag_preop" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
    <?php 
  }
  ?>
  </div>
    </div>
     <div class="col-sm">
              <?php
$resultado3 = $conexion->query("select * from dat_not_inquir WHERE id_atencion=". $_SESSION['pac'] )or die($conexion->error);

while ($row = mysqli_fetch_array($resultado3)) {
        ?>
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>SALA</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['sala']?>"  id="exampleFormControlTextarea1" required name="ayud1" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>

  </div>
    </div>
    <div class="col">
       <strong><label>HABITUS EXTERIOR</label><br></strong>
       <input type="text" name="habitus" class="form-control" placeholder="ESTADO DE CONCIENCIA" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
  </div><br>
  <div class="row">
           <?php
$resultado3 = $conexion->query("SELECT * from dat_not_preop WHERE id_atencion=$id_atencion ORDER BY id_not_preop DESC LIMIT 1" )or die($conexion->error);
?>
<?php
                    while ($row = mysqli_fetch_array($resultado3)) {
                        ?>
         <div class="col">
          <strong><label>PROCEDIMIENTO PROGRAMADO</label><br></strong>
             
             <input type="text" placeholder="PROCEDIMIENTO PROGRAMADO" name="" value="<?php echo $row['diag_preop']?>" class="form-control" disabled>         
         </div>
     
     <?php 
  }
  ?>

         <?php
$resultado3=$conexion->query("select paciente.*, dat_ingreso.*,dat_hclinica.*
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join dat_hclinica on dat_hclinica.Id_exp=dat_ingreso.Id_exp  WHERE dat_ingreso.id_atencion=$id_atencion") or die($conexion->error);
?>
<?php
                    while ($row = mysqli_fetch_array($resultado3)) {
                        ?>
         <div class="col">
          <strong><label>OTRAS ENFEMEDADES</label><br></strong>
             
             <input type="text"  name="" placeholder="OTRAS ENFEMEDADES" value="<?php echo $row['hc_enf']?>" class="form-control" disabled>         
         </div>
     
     <?php 
  }
  ?>
  </div><br>
  <div class="row">
         <div class="col">
             <label>PROGRAMA TRANSPLANTE</label><br>
             <input type="text" name="trans" placeholder="PROGRAMA TRANSPLANTE" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
         </div>
         <div class="col">
             <label>PROGRAMA DE CURACIÓN</label><br>
             <input type="text" name="cur" placeholder="PROGRAMA DE CURACIÓN" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
         </div>
     </div><br><br>
     <div class="row">
         <div class="col">
            <div class="row">
                <div class="col">
                  <label>PROTOCOLO CIRÚGIA SEGURA</label><br>
                      <div class="col">    
                 SI&nbsp;&nbsp;<input type="radio" value="SI"  name="cir" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 NO&nbsp;&nbsp;<input type="radio" value="NO" name="cir" >
                      </div>               
                  </div>
            </div>
         </div>
  </div><hr><br>
</div>
                    <center><h3>TRANSOPERATORIO</h3></center><hr><br>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>CIRUGÍA REALIZADA</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['cir_realizada']; ?>" id="exampleFormControlTextarea1" required name="cir_real" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
    <?php
}
?>
  </div>
    </div>
    <div class="col-sm">
      <div class="form-group">
        <?php
        $resultado2 = $conexion->query("select * from dat_not_preop WHERE id_atencion=". $_SESSION['pac'] )or die($conexion->error);
                    while ($fila1 = mysqli_fetch_array($resultado2)) {

                        ?>
    <label><strong>CIRUJANO</strong></label>
    <input type="text" class="form-control" id="exampleFormControlTextarea1" value="<?php echo $fila1['nom_medi_cir']; ?>" required name="cirujano" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled> 
     <?php 
  }
  ?>

  </div>
    </div>
    <div class="col-sm">
              <?php
$resultado3 = $conexion->query("select * from dat_not_inquir WHERE id_atencion=". $_SESSION['pac'] )or die($conexion->error);

while ($row = mysqli_fetch_array($resultado3)) {
        ?>
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>PRIMER AYUDANTE</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['prim_ayudante']?>"  id="exampleFormControlTextarea1" required name="ayud1" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>

  </div>
    </div>
  </div>
</div><br>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>SEGUNDO AYUDANTE</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['seg_ayudante']?>"  id="exampleFormControlTextarea1" required name="ayud2" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
  </div>
  </div>
  <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>TERCER AYUDANTE</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['ter_ayudante']?>"  id="exampleFormControlTextarea1" required name="ayud3" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
  </div>
  </div>
</div>
</div><br>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>ANESTESIÓLOGO</strong></label>
    <input type="text" value="<?php echo $row['anestesiologo']?>" class="form-control" id="exampleFormControlTextarea1" required name="anest" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
  </div>
  
    </div>
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>INSTRUMENTISTA</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['instrumentista']?>" id="exampleFormControlTextarea1" required name="inst" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
  </div>
    </div>
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>CIRCULANTE</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['circulante']?>" id="exampleFormControlTextarea1" required name="circu" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
  </div>
 
    </div>
  </div><br>
  <div class="row">
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>HORA DE LLEGADA AL QUIROFANO</strong></label>
    <input type="text" value="<?php echo $row['hora_llegada_quir']?>" class="form-control" id="exampleFormControlTextarea1" required name="anest" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
  </div>
  
    </div>      <?php 
  }
  ?>

           <?php
                    while ($row = mysqli_fetch_array($resultado4)) {
                        ?>
     <div class="col-sm">                   
    <label for="exampleFormControlTextarea1"><strong>HORA DE INICIO DE ANESTESIA</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['hora']; ?>" id="exampleFormControlTextarea1" required name="cir_real" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
  </div>
    <?php
}
?> 
<?php
$resultado3 = $conexion->query("SELECT * from dat_not_inquir WHERE id_atencion=$id_atencion ORDER BY id_not_inquir DESC LIMIT 1" )or die($conexion->error);
?>
<?php
                    while ($row = mysqli_fetch_array($resultado3)) {
                        ?>
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>TIPO DE ANESTESIA</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['local']?>,<?php echo $row['regional']?>,<?php echo $row['general']?>" id="exampleFormControlTextarea1" required name="circu" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
  </div>
 
    </div>  
  </div>
    <br>
  <div class="row">
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>HORA DE INICIO DE PROCEDIMIENTO</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['hora_llegada_quir']?>" id="exampleFormControlTextarea1" required name="circu" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled>
  </div>
      </div><?php 
  }
  ?>
    <div class="col-sm">
      <div class="form-group">
    <label><strong>HORA DE INICIO DE ISQUEMA</strong></label>
    <input type="time" class="form-control"  required name="in_isq">
  </div>
      </div>
    <div class="col-sm">
      <div class="form-group">
    <label><strong>HORA DE TERMINO DE ISQUEMA</strong></label>
    <input type="time" class="form-control"  id="exampleFormControlTextarea1" required name="ter_isq"  >
  </div>
      </div>
      <div class="col-sm">
      <div class="form-group">
    <label><strong>HORA DE INICIO DE ISQUEMA RENAL</strong></label>
    <input type="time" class="form-control" required name="in_ren" >
  </div>
      </div>
      <div class="col-sm">
      <div class="form-group">
    <label><strong>HORA DE INICIO RED FRIA</strong></label>
    <input type="time" class="form-control" required name="in_fria"  >
  </div>
      </div>
  </div> <br>
  <div class="row">
      <div class="col-sm">
      <div class="form-group">
    <label><strong>HORA DE TERMINO DE ISQUEMA RENAL</strong></label>
    <input type="time" class="form-control" required name="ter_ren"  >
  </div>
      </div>
      <div class="col-sm">
      <div class="form-group">
    <br><label><strong>HORA DE TERMINO RED FRIA</strong></label>
    <input type="time" class="form-control"required name="ter_fria"  >
  </div>
      </div>
    
      <div class="col-sm">
      <div class="form-group">
    <br><label><strong>SITIO PLACA ELECTRO</strong></label>
    <input type="text" class="form-control" required name="elect" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" >
  </div>
      </div>
      <div class="col-sm">
      <div class="form-group">
    <label><strong>POSICIÓN QUIRÚRGICA DEL PACIENTE</strong></label>
    <input type="text" class="form-control"required name="pos" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" >
  </div>
      </div>
  </div><br>
  <div class="row">
    <div class="col-sm">
      <div class="form-group">
    <br><label><strong>ANTISEPTICO UTILIZADO</strong></label>
    <input type="text" class="form-control"  id="exampleFormControlTextarea1" required name="ant" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" >
  </div>
      </div>
      <div class="col-sm">
      <div class="form-group">
    <br><label><strong>AREA QUIRÚRGICA</strong></label>
    <input type="text" class="form-control"  id="exampleFormControlTextarea1" required name="areaquir" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" >
  </div>
      </div>
      <?php
$resultado3 = $conexion->query("SELECT * from dat_not_inquir WHERE id_atencion=$id_atencion ORDER BY id_not_inquir DESC LIMIT 1" )or die($conexion->error);
?>
<?php
                    while ($row = mysqli_fetch_array($resultado3)) {
                        ?>
      <div class="col-sm">
      <div class="form-group">
    <label><strong>HORA TERMINO DE PROCEDIMIENTO</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['hora_salida_quir']?>"  id="exampleFormControlTextarea1" required name="circu" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled >
  </div>
      </div>
      <div class="col-sm">
      <div class="form-group">
    <br><label><strong>PROCEDIMIENTO REALIZADO</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['cir_realizada']?>"  id="exampleFormControlTextarea1" required name="circu" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled >
  </div>
      </div>
      <?php 
  }
  ?>
  </div>
  <div class="row">
       <?php
$resultado5 = $conexion->query("SELECT * from dat_not_inquir WHERE id_atencion=$id_atencion ORDER BY id_not_inquir DESC LIMIT 1" )or die($conexion->error);
?>
<?php
                    while ($row = mysqli_fetch_array($resultado5)) {
                        ?>
                        <div class="col-sm">
      <div class="form-group">
    <br><label><strong>HALLAZGOS</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['nota_preop']?>"  id="exampleFormControlTextarea1" required name="circu" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled >
  </div>
      </div>
      <?php 
  }
  ?>
  </div>
  <div class="row">
    <div class="col">
     <center>TIPO DE CIRÚGIA <br></center> 
      LIMPIA &nbsp;<input type="radio" value="LIMPIA" name="tip_cir" checked="">&nbsp;&nbsp;&nbsp;&nbsp;
      CONTAMINADA &nbsp;<input type="radio" value="CONTAMINADA" name="tip_cir">&nbsp;&nbsp;&nbsp;&nbsp;
      LIMPIA-CONTAMINADA &nbsp;<input type="radio" value="LIMPIA-CONTAMINADA" name="tip_cir">&nbsp;&nbsp;&nbsp;
      SUCIA &nbsp;<input type="radio" value="SUCIA" name="tip_cir">
    </div>
    <div class="col">
     <center>PIEZA PATOLOGÍA <br></center> 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI &nbsp;<input type="radio" value="SI" name="pipat">&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;NO &nbsp;<input type="radio" value="NO" name="pipat" checked="">&nbsp;&nbsp;&nbsp;&nbsp;
  </div>
</div><hr><br>

 <div class="container">

     <th colspan="5"><center><h3>ESCALAS DE VALORACIÓN PARA CUIDADOS ESPECÍFICOS DE SEGURIDAD Y PROTECCIÓN</h3></center></th><hr>
     <center><h3>SIGNOS VITALES</h3></center>
         </tr><hr>
     <div class="row">
         
         <div class="col-sm-3">
         <div class="form-group">
          <center><label for="p_sistolica">Presión Arterial: </label></center>
             <div class="row">
              <div class="col">
                  <div class="row">
                      <div class="col losInputTAM">
                         <input type="text" placeholder="MM" class="form-control" id="sist" name="pdiast" required="">
                      </div> /
                      <div class="col losInputTAM">
                         <input type="text" placeholder="HG" class="form-control" id="diast" name="psist" required="">
                      </div>
                  </div>
                            </div>
                        </div>
                    </div>
            </div>
         <div class="col">
            <div class="form-group">
            <label for="f_resp">Frecuencia Cardiaca:</label>
                <input type="number" name="f_card" placeholder="Frecuencia Cardiaca" id="f_resp" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
             </div>
         </div>
         <div class="col">
                        <div class="form-group">
                            <label for="f_resp">Frecuencia Respiratoria:</label>
                            <input type="number" name="f_resp" placeholder="Frecuencia respiratoria" id="f_resp"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div>
                    </div>
          <div class="col">
           <div class="form-group">
             <label for="temp">Temperatura:</label>
             <input type="number" name="temp" placeholder="Temperatura" id="temp" class="form-control"  style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
            </div>
          </div>
           <div class="col">
                        <div class="form-group">
                            <label for="f_resp">SPO2:</label>
                            <input type="number" name="spo2" placeholder="Frecuencia respiratoria" id="f_resp"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div>
                    </div>          
     </div><hr>
     
    
     
  <!--   <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-warning">
            <th colspan="5"><center><h5><strong>MEDICAMENTOS</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col"><center>MEDICAMENTO</center></th>
      <th scope="col"><center>DOSIS</center></th>
      <th scope="col"><center>VIA</center></th>
      <th scope="col"><center>HORA</center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="text" name="med1_m" class="form-control col-sm-12" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dias1_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec1_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="time" name="" class="form-control"></td>
    </tr>
    <tr>
     <td><input type="text" name="med2_m" class="form-control col-sm-12" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dias2_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec2_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="time" name="" class="form-control"></td>
    </tr>
    <tr>
      <td><input type="text" name="med3_m" class="form-control col-sm-12" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dias3_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec3_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="time" name="" class="form-control"></td>
    </tr>
     <tr>
      <td><input type="text" name="med4_m" class="form-control col-sm-12" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dias4_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec4_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="time" name="" class="form-control"></td>
    </tr>
     <tr>
      <td><input type="text" name="med5_m" class="form-control col-sm-12" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dias5_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec5_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="time" name="" class="form-control"></td>
    </tr>
  </tbody>
</table>
     </div>-->
     <div class="row">
           <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-warning">
            <th colspan="5"><center><h5><strong>CONTROL DE TEXTILES</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col"><center>MATERIALES</center></th>
      <th scope="col"><center>CANTIDAD</center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>GASAS</td>
      <td><input type="number" name="gasas" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>
    <tr>
     <td>COMPRESAS</td>
      <td><input type="number" name="comp" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>
    <tr>
      <td>COTONOIDES</td>
      <td><input type="number" name="cot" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>
     <tr>
      <td>CINTAS DE LINO</td>
      <td><input type="number" name="lino" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>
    <tr>
      <td>GASA NASAL</td>
      <td><input type="number" name="nas" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>
    <tr>
      <td>PUSH</td>
      <td><input type="number" name="pu" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>
  </tbody>
</table>
<center>OBSERVACIONES</center><br><textarea name="ob_mat" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
     </div>
     <hr>
<p><center><strong>EGRESOS</strong><br></center></p>
<div class="container"> 
  <div class="row">
    <div class="col-sm">DIURESIS:
     <div class="row">
  <div class="col"><div class="losInput8"><input type="number" name="diu" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div></div>
</div>
    </div>
    <div class="col-sm">
      EVACUACIONES:<div class="losInput8"><input type="number" name="eva" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
    </div>
    <div class="col-sm">
      SANGRADO:<div class="losInput8"><input type="number" name="sang" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
    </div>
    <div class="col-sm">
     VÓMITO:<div class="losInput8"><input name="vom" type="number" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
    </div>
  </div>
</div>
<p>
<div class="container"> 
  <div class="row">
    <div class="col-sm"><center>ASPIRACIÓN BOCA / CANULA:</center>
     <div class="row">
  <div class="col"><div class="losInput8"><input type="number" name="aspboc" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div></div>
</div>
    </div>
    <div class="col-sm">
      C GÁSTRICO:<div class="losInput8"><input type="number" name="gast" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
    </div>
    <div class="col-sm">
      DRENAJE:<div class="losInput8"><input name="dren" type="number" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
    </div>
    <div class="col-sm">
     PERDIDAS INSENSIBLES:<div class="losInput8"><input type="number" name="perd" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
    </div>
  </div>
</div>
<p>
<div class="container"> 
  <div class="row">
    <div class="col-sm-3"><center><strong>EGRESO PARCIAL TOTAL:</strong></center>
     <div class="row">
  <div class="col"><div class="inputTotal8"><input type="text" name="egpar_t" class="form-control" disabled></div></div>
</div>
    </div>  
  </div>
</div>
<hr>
     <div class="row">
         <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
    <tr class="table-warning">
      <th colspan="5"><center><h5><strong>ESCALA DE RIESGO DE CAIDA</strong></h5></center></th>
    </tr>
    <tr class="table-active">
      <th scope="col"><center>VARIABLE</center></th>
      <th scope="col"><center>OBSERVACIÓN</center></th>
      <th scope="col"><center>CAL.</center></th>
      <th scope="col"><center>VALOR</center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" class="col-sm-3"><center>CAIDAS PREVIAS</center></th>
      <td>NO<br>SI</td>
      <td><center>0<br>1</center></td>

      <td class="col-sm-1"><div class="losInput2"><input type="number" name="caidas" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 49'></div></td>
    </tr>
    <tr>
      <th scope="row"><center><br><br><br>MEDICAMENTOS</center></th>
      <td>NINGUNO<br>TRANQUILIZANTES-SEDANTE<br>DIURÉTICOS<br>HIPOTENSORES(NO DIURÉTICOS)<br>ANTIPARKSONIANOS<br>ANTIDEPRESIVOS<br>OTROS MEDICAMENTOS</td>
      <td><center>0<br>1<br>2<br>3<br>4<br>5<br>6</center></td>
     <td><br><br><br><div class="losInput2"><input type="number" name="medi" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 54'></div></td>
    </tr>
    <tr>
      <th scope="row"><center><br>DÉFICITS SENSORIALES</center></th>
      <td>NINGUNO<br>ALTERACIONES VISUALES<br>ALTERACIONES AUDITIVAS<br>EXTREMIDADES (ICTUS..)</td>
      <td><center>0<br>1<br>2<br>3</center></td>
        <td><br><div class="losInput2"><input type="number" name="defic" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 51'></div></td>
    </tr>
    <tr>
      <th scope="row"><center>ESTADO MENTAL</center></th>
      <td>ORIENTADO<br>CONFUSO</td>
      <td><center>0<br>1</center></td>
        <td><div class="losInput2"><input type="number" name="estement" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 49'></div></td>
    </tr>
    <tr>
      <th scope="row"><center><br>DEAMBULACIÓN</center></th>
      <td>NORMAL<br>SEGURA CON AYUDA<br>INSEGURA CON AYUDA / SIN AYUDA<br>IMPOSIBLE</td>
      <td><center>0<br>1<br>2<br>3</center></td>
        <td><br><div class="losInput2"><input type="number" name="deamb" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 51'></div></td>
    </tr>
     <tr>
      <th colspan="2"></th>
      <th colspan="1"><center><h5><strong>TOTAL:</strong></h5></center></th>
      <th colspan="1"><center> <div class="inputTotal2"><input type="number" name="total" class="form-control" disabled></div></center></th>
    </tr>

 <tr>
      <th colspan="1"></th>
      <th colspan="1"><center>CLASIFICACIÓN DEL RIESGO</center></th>
      <th colspan="3"><center><input type="text" name="classresg" class="form-control"></center></th>
    </tr>

     <tr>
      <th colspan="2"><center>NOMBRE DE ENFERMERA (O) QUE VALORA</center></th>
      <th colspan="3"><center><input type="text" name="nom_enf" class="form-control"></center></th>
    </tr>

     <tr>
    <th colspan="2"><center>INTERVENCIONES / RECOMENDACIONES PARA PREVENCIÓN DE RIESGO DE CAÍDA</center></th>
    <th colspan="3"><center><input type="text" name="interv_m" class="form-control"></center></th>
    </tr>
 <tr class="table-danger">
      <th colspan="5"><center><font size="2">INTERPRETACIÓN: TODOS LOS PACIENTES CON <strong>3 O MÁS </strong>PUNTOS EN ESTA CALIFICACIÓN SE CONSIDERAN DE <strong>ALTO RIESGO PARA CAIDA</strong></font></center></th>
    </tr>
  </tbody>
</table> 
     </div><hr>
     <h5><strong>VALORACIÓN DE LA PIEL</strong></h5><p>

  <div class="container">
  <div class="row">
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="QUEMADURAS" name="quem_m" id="quemadura">
  <label class="form-check-label" for="quemadura">
    A) QUEMADURAS
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="ULSERA POR PRESIÓN" name="uls_m" id="herida">
  <label class="form-check-label" for="herida">
    F) ULSERA POR PRESIÓN
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="NECROSIS" name="nec_m" id="enfisema">
  <label class="form-check-label" for="enfisema">
    K) NECROSIS
  </label>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="HERIDA QUIRÚRGICA" name="her_m" id="ulcera">
  <label class="form-check-label" for="ulcera">
    B) HERIDA QUIRÚRGICA
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" name="tub_m" type="checkbox" value="TUBOS Y DENAJES" id="dermo">
  <label class="form-check-label" for="dermo">
    G) TUBOS Y DENAJES
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" name="der_m" type="checkbox" value="DERMOESCORIACION" id="hematoma">
  <label class="form-check-label" for="hematoma">
    L) DERMOESCORIACIÓN
  </label>
    </div>
     
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <input class="form-check-input" name="ras_m"  type="checkbox" value="RASH" id="ciano">
  <label class="form-check-label" for="ciano">
    C) RASH
  </label>
    </div>
    <div class="col-sm">
        <input class="form-check-input" name="eq_m" type="checkbox" value="EQUIMOSIS" id="rash">
  <label class="form-check-label" for="rash">
    H) EQUIMOSIS
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" name="enf_m" type="checkbox" value="ENFISEMA SUBCUTÁNEO" id="fracturas">
  <label class="form-check-label" for="fracturas">
    M) ENFISEMA SUBCUTÁNEO
  </label>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <input class="form-check-input" name="ema_m" type="checkbox" value="HEMATOMA" id="quir">
  <label class="form-check-label" for="quir">
    D) HEMATOMA
  </label>
    </div>
    <div class="col-sm">
        <input class="form-check-input" name="frac_m" type="checkbox" value="FRACTURA" id="equi">
  <label class="form-check-label" for="equi">
    I) FRACTURA
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" name="acc_m" type="checkbox" value="ACCESOS VASCULARES" id="previas">
  <label class="form-check-label" for="previas">
    N) ACCESOS VASCULARES
  </label>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <input class="form-check-input" name="pete_m" type="checkbox" value="PETEQUIAS" id="quir">
  <label class="form-check-label" for="quir">
    E) PETEQUIAS
  </label>
    </div>
    <div class="col-sm">
        <input class="form-check-input" name="ede_m" type="checkbox" value="EDEMIA" id="equi">
  <label class="form-check-label" for="equi">
    J) EDEMIA
  </label>
    </div>
    <div class="col-sm">
        
    </div>
  </div>
</div>
 <p>
<hr>
<font size="2">
<div class="container">
  <div class="row">
      <div class="col-sm-2">
     <br><br><input class="form-check-input" type="checkbox" value="FRONTAL" id="fron" name="fron_m">
  <label class="form-check-label" for="fron">
    1. FRONTAL
  </label><br>
   <input class="form-check-input" name="mal_m" type="checkbox" value="MALAR" id="malar">
  <label class="form-check-label" for="malar">
    2. MALAR
  </label><br>
   <input class="form-check-input" name="man_m" type="checkbox" value="MANDIBULAR" id="mandi">
  <label class="form-check-label" for="mandi">
    3. MANDIBULAR
  </label><br><br><p>
   <input class="form-check-input" name="del_m" type="checkbox" value="DELTOIDEA" id="delto">
  <label class="form-check-label" for="delto">
    4. DELTOIDEA
  </label><br>
   <input class="form-check-input" name="pec_m" type="checkbox" value="PECTORAL" id="pec">
  <label class="form-check-label" for="pec">
   5. PECTORAL
  </label><br>
   <input class="form-check-input" name="est_m" type="checkbox" value="ESTERNAL" id="ester">
  <label class="form-check-label" for="ester">
    6. ESTERNAL
  </label><br><br><br>
   <input class="form-check-input" name="ant_m" type="checkbox" value="ANTEBRAZO" id="ante">
  <label class="form-check-label" for="ante">
    7. ANTEBRAZO
  </label><br>
   <input class="form-check-input" name="mu_m" type="checkbox" value="MUÑECA" id="muñeca">
  <label class="form-check-label" for="muñeca">
    8. MUÑECA
  </label><br>
   <input class="form-check-input" name="mano_m" type="checkbox" value="MANO (PALMA)" id="mano">
  <label class="form-check-label" for="mano">
    9. MANO (PALMA)
  </label><br><br><br><p>
   <input class="form-check-input" name="mus_m" type="checkbox" value="MUSLO" id="muslo">
  <label class="form-check-label" for="muslo">
  10. MUSLO
  </label><br>
   <input class="form-check-input" name="rod_m" type="checkbox" value="RODILLA" id="rodilla">
  <label class="form-check-label" for="rodilla">
  11. RODILLA
  </label><br>
   <input class="form-check-input" name="pier_m" type="checkbox" value="PIERNA" id="pierna">
  <label class="form-check-label" for="pierna">
  12. PIERNA
  </label>
    </div>
    <div class="col-sm">
    <img src="../../imagenes/cuerpofrontal.jpg" height="495">
    </div>
    <div class="col-sm-2">
      <br>
      <input class="form-check-input" name="pri_m" type="checkbox" value="PIRAMIDE NASAL" id="nasa">
  <label class="form-check-label" for="nasa">
  13. PIRAMIDE NASAL
  </label><br>
    <input class="form-check-input" name="max_m" type="checkbox" value="MAXILAR SUPERIOR" id="maxi">
  <label class="form-check-label" for="maxi">
  14. MAXILAR SUPERIOR
  </label><br>
    <input class="form-check-input" name="men_m" type="checkbox" value="MENTON" id="menton">
  <label class="form-check-label" for="menton">
  15. MENTON
  </label><br><br><br>
    <input class="form-check-input" name="ac_m" type="checkbox" value="ACROMIAL" id="acromial">
  <label class="form-check-label" for="acromial">
  16. ACROMIAL
  </label><br>
    <input class="form-check-input" name="bra_m" type="checkbox" value="BRAZO" id="brazo">
  <label class="form-check-label" for="brazo">
  17. BRAZO
  </label><br>
    <input class="form-check-input" name="pli_m" type="checkbox" value="PLIEGUE DEL CODO" id="pliegue">
  <label class="form-check-label" for="pliegue">
  18. PLIEGUE DEL CODO
  </label><br><br><br>
    <input class="form-check-input" name="abd_m" type="checkbox" value="ABDOMEN" id="adbo">
  <label class="form-check-label" for="adbo">
  19. ABDOMEN
  </label><br>
    <input class="form-check-input" name="reg_m" type="checkbox" value="REGIÓN INGUINAL" id="inguinal">
  <label class="form-check-label" for="inguinal">
  20. REGIÓN INGUINAL
  </label><br>
    <input class="form-check-input" name="pub_m" type="checkbox" value="REGIÓN PUBIANA" id="pub">
  <label class="form-check-label" for="pub">
  21. REGIÓN PUBIANA
  </label><br>
  <p>
    <input class="form-check-input" name="pde" type="checkbox" value="PRIMER DEDO" id="pdedo">
  <label class="form-check-label" for="pdedo">
  22. PRIMER DEDO
  </label><br>
    <input class="form-check-input" name="sde_m" type="checkbox" value="SEGUNDO DEDO" id="sdedo">
  <label class="form-check-label" for="sdedo">
  23. SEGUNDO DEDO
  </label><br>
    <input class="form-check-input" name="tde_m" type="checkbox" value="TERCER DEDO" id="tdedo">
  <label class="form-check-label" for="tdedo">
  24. TERCER DEDO
  </label><br>
    <input class="form-check-input" name="cde_m" type="checkbox" value="CUARTO DEDO" id="cdedo">
  <label class="form-check-label" for="cdedo">
  25. CUARTO DEDO
  </label><br>
    <input class="form-check-input" name="qde_m" type="checkbox" value="QUINTO DEDO" id="qdedo">
  <label class="form-check-label" for="qdedo">
  26. QUINTO DEDO
  </label><br><p>
    <input class="form-check-input" name="tob_m" type="checkbox" value="TOBILLO" id="tobillo">
  <label class="form-check-label" for="tobillo">
  27. TOBILLO
  </label><br>
    <input class="form-check-input" name="pie_m" type="checkbox" value="PIE (DORSO)" id="dorso">
  <label class="form-check-label" for="dorso">
  28. PIE (DORSO)
  </label><br>
 
    </div>
  </div>
</div>
</font>
<hr>
<font size="2">
<div class="container">
  <div class="row">
      <div class="col-sm-2">
     <br><br><br><input class="form-check-input" name="par_m" type="checkbox" value="PARIETAL" id="parietal">
  <label class="form-check-label" for="parietal">
    29. PARIETAL
  </label><br>
   <input class="form-check-input" name="occ_m" type="checkbox" value="OCCIPITAL" id="occipital">
  <label class="form-check-label" for="occipital">
  30. OCCIPITAL
  </label><br>
   <input class="form-check-input" name="nuca_m" type="checkbox" value="NUCA" id="nuca">
  <label class="form-check-label" for="nuca">
    31. NUCA
  </label><br><br><br>
   <input class="form-check-input" name="braz_m" type="checkbox" value="BRAZO" id="brazo2">
  <label class="form-check-label" for="brazo2">
    32. BRAZO
  </label><br>
   <input class="form-check-input" name="codo_m" type="checkbox" value="CODO" id="codo2">
  <label class="form-check-label" for="codo2">
   33. CODO
  </label><br>
   <input class="form-check-input" name="ante_m" type="checkbox" value="ANTEBRAZO" id="ante2">
  <label class="form-check-label" for="ante2">
    34. ANTEBRAZO
  </label><br>
   <input class="form-check-input" name="mune_m" type="checkbox" value="MUÑECA" id="muñeca2">
  <label class="form-check-label" for="muñeca2">
    35. MUÑECA
  </label><br>
   <input class="form-check-input" name="mano2_m" type="checkbox" value="MANO (DORSO)" id="mano2">
  <label class="form-check-label" for="mano2">
    36. MANO (DORSO)
  </label><br><br><br><br><br><br>
   <input class="form-check-input" name="plieg_m" type="checkbox" value="PLIEGUE POPLITEO" id="pop">
  <label class="form-check-label" for="pop">
    37. PLIEGUE POPLITEO
  </label><br>
   <input class="form-check-input" name="piern_m" type="checkbox" value="PIERNA" id="pierna2">
  <label class="form-check-label" for="pierna2">
  38. PIERNA
  </label><br>
   <input class="form-check-input" name="piep_m" type="checkbox" value="PIE (PLANTA)" id="planta">
  <label class="form-check-label" for="planta">
  39. PIE (PLANTA)
  </label>
    </div>
    <div class="col-sm">
  <img src="../../imagenes/cuerpotrasero.jpg" height="505">
    </div>
    <div class="col-sm-2">
      <br><br><br>
      <input class="form-check-input" name="cuello_m" type="checkbox" value="CUELLO POSTERIOR" id="cuello">
  <label class="form-check-label" for="cuello">
  40. CUELLO POSTERIOR
  </label><br>
    <input class="form-check-input" name="regin_m" type="checkbox" value="REGIÓN INTERESCAPULAR" id="inter">
  <label class="form-check-label" for="inter">
  41. REGIÓN INTERESCAPULAR
  </label><br>
    <input class="form-check-input" name="regesc_m" type="checkbox" value="REGIÓN ESCAPULAR" id="esca">
  <label class="form-check-label" for="esca">
  42. REGIÓN ESCAPULAR
  </label><br>
    <input class="form-check-input" name="reginf_m" type="checkbox" value="REGIÓN INFRAESCAPULAR" id="infra">
  <label class="form-check-label" for="infra">
  43. REGIÓN INFRAESCAPULAR
  </label><br><br><br>
    <input class="form-check-input" name="lum_m" type="checkbox" value="LUMBAR" id="lumbar">
  <label class="form-check-label" for="lumbar">
  44. LUMBAR
  </label><br>
    <input class="form-check-input" name="glut_m" type="checkbox" value="GLUTEO" id="gluteo">
  <label class="form-check-label" for="gluteo">
  45. GLUTEO
  </label><br>
    <input class="form-check-input" name="musl_m" type="checkbox" value="MUSLO" id="muslo2">
  <label class="form-check-label" for="muslo2">
  46. MUSLO
  </label><br><br><br><br><br><br><br>
    <input class="form-check-input" name="talon_m" type="checkbox" value="TALÓN" id="talon2">
  <label class="form-check-label" for="talon2">
  47. TALÓN
  </label>
    </div>
  </div>
</div>
</font>
<br>
<p><hr>

                            <center>
                                <h4>Valoración Escala del dolor </h4><br>
                                <img src="../../imagenes/caras.png" height="200">
                            </center>                
                     <br>
            <div class="container">
               <strong><center>TIEMPO EN MINUTOS </center> <br></strong> 
                  <div class="row"><br>
                      <div class="col">
                        Ingreso a recuperación<input type="time" name="ingrecup" class="form-control">
                      </div>
                      <div class="col">
                       <br> 15&nbsp;&nbsp;<input type="text" name="val1" class="form-control" >
                      </div>
                      <div class="col">
                       <br> 30&nbsp;&nbsp;<input type="text" name="val2" class="form-control" >
                      </div>
                      <div class="col">
                       <br> 45&nbsp;&nbsp;<input type="text" name="val3" class="form-control" >
                      </div>
                      <div class="col">
                       <br> 50&nbsp;&nbsp;<input type="text" name="val4" class="form-control" >
                      </div>
                      <div class="col">
                       <br> 60&nbsp;&nbsp;<input type="text" name="val5" class="form-control" >
                      </div> 
                      <div class="col">
                       Egreso de Recuperación<input type="time" name="egrecup" class="form-control" >
                      </div>         
                  </div>
                  <div class="row">
                      <div class="col">
                        <label>Medida para Control de Dolor:</label><br>
                        <input type="text" name="medol" placeholder="Medida para Control de Dolor" class="form-control">
                      </div>
                  </div>
            </div><hr>
<!--     
<center><label><strong>BALANCE TOTAL</strong></label></center><br>
     <div class="row">
         <div class="col">
             Ingresos:<input type="text" name="" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
         </div>
         <div class="col">
             Egresos:<input type="text" name="" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
         </div>
         <div class="col">
             Total:<input type="text" name="" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
         </div>
     </div><hr>-->
     <tr>
   <th ><strong><center>PLANEACIÓN DE LA ATENCIÓN PARA EL PACIENTE DESPUES DE LA CIRUGÍA</center></strong></th><br>
    </tr>
    <td>
      <div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DETPASUE">
 OXIGENOTERAPIA
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="oxi" id="DETPASUE">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DEPRI">
  VALORAR EL NIVEL DE CONCIENCIA
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="con" id="DEPRI">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DETMOVFIS">
  VALORAR COLORACIÓN DE PIEL Y MUCOSAS
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="muc" id="DETMOVFIS">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DETMOVCAMA">
  APOYO VENTILATORIO
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="vent" id="DETMOVCAMA">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DETDEAM">
  CUIDADOS DE ESTOMA
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="est" id="DETDEAM">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DEFAUTOVES">
     CUIDADOS DE CITOCLISIS   
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="cito" id="DEFAUTOVES">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DEFAUTOBAÑO">
  CUIDADOS DE YESO
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="yeso" id="DEFAUTOBAÑO">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DEFAUTOALI">
  CUIDADOS DE HERIDA QUIRÚRGICA
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="herquir" id="DEFAUTOALI">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DEFAUTOWC">
 CUIDADOS DE PACIENTES CON QUEMADURAS
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="quema" id="DEFAUTOWC">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="FAT">
  CUIDADOS DE FIJADORES EXTERNOS
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="ext" id="FAT">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DISGASCAR">
  INFUSIÓN DE MEDICAMENTOS DE RIESGO
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="riesg"id="DISGASCAR">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DETRESESP">
  PRECAUCIÓN DE MOVILIZACIÓN PROTESIS DE CADERA
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="prec" id="DETRESESP">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="RESDISDES">
  CUIDADOS DE DRENAJES (PENROSSE, DRENOVAC, VENTRICULOSTOMIA, ETC...)
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="drena" id="RESDISDES">
    </div>
  </div>
</div> 
</td>
    <td>
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="RIESGINF">
  MOVILIZACIÓN EN BLOQUE
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="bloq" id="RIESGINF">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="DETMUCORAL">
  MOVILIZACIÓN, DEAMBULACIÓN
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="movil" id="DETMUCORAL">
    </div>
  </div>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <label class="form-check-label" for="RESLESION">
  MONITORIZACIÓN CONSTANTES VITALES
  </label>
    </div>
    <div class="col-sm">
       <input class="form-check-input" type="checkbox" value="SI" name="const" id="RESLESION">
    </div>
  </div>
</div>  
    </td><hr>

        <center><label><strong>NOTAS DE ENFERMERIA</strong></label></center><br>
     <div class="row">
         <div class="col">
             Preoperatorio:<textarea placeholder="Preoperatorio" name="not_preop" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
         </div>
         <div class="col">
             Nombre y Firma de Enfermera:<input type="text" placeholder="Nombre completo de Enfermera" name="nom_enf_preop" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
         </div>
     </div><br>
     <div class="row">
        <div class="col">
             Transoperatorio:<textarea placeholder="Transoperatorio" name="not_trans" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
         </div>
         <div class="col">
             Nombre y Firma de Enfermera:<input type="text" placeholder="Nombre completo de Enfermera" name="nom_enf_trans" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
         </div> 
     </div>
     <div class="row">
         <div class="col">
             Postoperatorio:<textarea placeholder="Postoperatorio" name="not_post" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
         </div>
         <div class="col">
             Nombre y Firma de Enfermera:<input type="text" placeholder="Nombre completo de Enfermera" name="nom_enf_post" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
         </div> 
     </div>
     <br>
 </div>

<div class="form-group col-12">
  <center>
<button type="submit" class="btn btn-primary">FIRMAR</button>
<button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button></center>
</div><hr>
      
</div>

</form>
  </div>
<!--TERMINO NOTA-->



<!--INICIO MEDICAMENTOS,ETC-->
  <div class="tab-pane fade" id="nav-med" role="tabpanel" aria-labelledby="nav-profile-tab">
    <br><br>
   
<!-- inicio seccion de medicamentos -->
<hr><br>
<div class="container">
  <form action="" method="POST" id="medicamentos">
      <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-warning">
            <th colspan="7"><center><h5><strong>MEDICAMENTOS</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col"><center>MEDICAMENTO</center></th>
      <th scope="col"><center>DOSIS</center></th>
      <th scope="col"><center>VIA</center></th>
      <th scope="col"><center>FRECUENCIA</center></th>
      <th><center>CANTIDAD CEYE</center></th>
      <th scope="col"><center></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><select data-live-search="true" class="form-control" name="med" required>
         <?php
         $sql = "SELECT * FROM material_ceye, stock_ceye where material_ceye.material_controlado = 'NO' AND material_ceye.material_id = stock_ceye.material_id and stock_ceye.stock_qty != 0";
              $result = $conexion->query($sql);
               while ($row_datos = $result->fetch_assoc()) {
                 echo "<option value='" . $row_datos['material_id'] . "'>" . $row_datos['material_codigo'] . ' ' . $row_datos['material_nombre'] . "</option>";
                }
          ?></select></td>
      <td><input type="text" name="dosis" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="via" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="number" min="1" step="1" class="form-control" name="qty" placeholder="Ingresa la cantidad" required=""></td>
      <td><input type="submit" name="btnagregar" class="btn btn-block btn-success" value="Agregar"></td>
    </tr>
  </tbody>
</table>
     </div>
     
    </form>

<!-- termino seccion de medicamentos-->

<!-- inicio ceye servicios ceye-->

<form action="" method="POST" id="medicamentos">
      <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-warning">
            <th colspan="5"><center><h5><strong>EQUIPOS</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col"><center>EQUIPO</center></th>
      <th scope="col"><center>CANTIDAD</center></th>
      <th scope="col"><center>HORA</center></th>
      <th scope="col"><center></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><select data-live-search="true" name="serv" class="form-control" required>
                                    <?php
                                    $sql_serv = "SELECT * FROM cat_servicios where tipo =4 and serv_activo = 'SI'";
                                    $result_serv = $conexion->query($sql_serv);
                                    while ($row_serv = $result_serv->fetch_assoc()) {
                                        echo "<option value='" . $row_serv['id_serv'] . "'>" . $row_serv['serv_desc'] . "</option>";
                                    }
                                    ?>
                                </select></td>
      <td><input type="text" name="dias1_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec1_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="time" name="" class="form-control"></td>
      <td><input type="submit" name="btnserv" class="btn btn-block btn-success" value="Agregar"></td>
    </tr>
  </tbody>
</table>
     </div>
    </form>  
  <!-- termino de servicios ceye-->
</div>


<?php

          if (isset($_POST['btnagregar'])) {
            include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];
            $item_id =  mysqli_real_escape_string($conexion, (strip_tags($_POST["med"], ENT_QUOTES)));
            $dosis =  mysqli_real_escape_string($conexion, (strip_tags($_POST["dosis"], ENT_QUOTES)));
            $via =  mysqli_real_escape_string($conexion, (strip_tags($_POST["via"], ENT_QUOTES)));
            $frec =  mysqli_real_escape_string($conexion, (strip_tags($_POST["frec"], ENT_QUOTES)));
            //$hora =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES))); //Escanpando caracteres
            $cart_uniquid = uniqid();
            $qty =  mysqli_real_escape_string($conexion, (strip_tags($_POST["qty"], ENT_QUOTES))); //Escanpando caracteres

        $sql_pac = "SELECT p.Id_exp, di.id_atencion FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";
         $result_pac = $conexion->query($sql_pac);
         while ($row_pac = $result_pac->fetch_assoc()) {
          $paciente1 = $row_pac['Id_exp'];
            }

            $sql_stock = "SELECT * FROM stock_ceye s where $item_id = s.material_id ";
            //echo $sql_stock;
            $result_stock = $conexion->query($sql_stock);
            while ($row_stock = $result_stock->fetch_assoc()) {
              $stock_id = $row_stock['stock_id'];
              $stock_qty = $row_stock['stock_qty'];
            }

            $sql_stock = "SELECT * FROM material_ceye where material_id=$item_id ";
            //echo $sql_stock;
            $result_stock = $conexion->query($sql_stock);
            while ($row_stock = $result_stock->fetch_assoc()) {
              $mat_nom = $row_stock['material_nombre'];
            }
            // echo $stock_qty - $qty;
            if (($stock_qty - $qty) >= 0) {

$sql2 = "INSERT INTO cart_ceye(material_id,cart_qty,cart_stock_id,id_usua,cart_uniqid, paciente,cart_fecha)VALUES($item_id,$qty, $stock_id,$id_usua,'$cart_uniquid', $paciente1, NOW());";
            //  echo $sql2;
              $result_cart = $conexion->query($sql2);

              $stock = $stock_qty - $qty;
              $sql3 = "UPDATE stock_ceye set stock_qty=$stock where stock_id = $stock_id";
              $result3 = $conexion->query($sql3);


            }
/*$ingresar2 = mysqli_query($conexion, 'INSERT INTO medica_enf (id_atencion,turno,medicam_mat,dosis_mat,via_mat,frec_mat,id_usua) values (' . $id_atencion . ',"QUIROFANO","' . $mat_nom . '","' . $dosis . '","' . $via . '","' . $frec . '",' . $id_usua .') ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));  */

           echo '<script type="text/javascript">window.location.href = "reg_quirurgico.php";</script>';
          }

          ?>
         <div class="container">
           <div class="table-responsive">
            <!--<table id="myTable" class="table table-striped table-hover">-->

            <table class="table table-bordered table-striped" id="mytable">

              <thead class="thead" style="background-color: #0c675e">
                <tr>
                  <th>NO.</th>
                  <th>Material</th>
                  <th>Cantidad</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];
            $sql_pac = "SELECT p.Id_exp, di.id_atencion FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";
         $result_pac = $conexion->query($sql_pac);
         while ($row_pac = $result_pac->fetch_assoc()) {
          $paciente1 = $row_pac['Id_exp'];
            }
                $resultado2 = $conexion->query("SELECT * from cart_ceye c, material_ceye i where $paciente1 = c.paciente and i.material_id = c.material_id") or die($conexion->error);
                $no = 1;
                while ($row_lista = $resultado2->fetch_assoc()) {
                  $cart_id = $row_lista['cart_id'];
                  $cart_stock_id = $row_lista['cart_stock_id'];
                  $cart_qty = $row_lista['cart_qty'];
                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . $row_lista['material_nombre'] . '</td>'
                    . '<td>' . $cart_qty . '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="../../sauxiliares/Ceye/cargar_paquete.php?q=eliminarquir&paciente= ' . $paciente1 . '&cart_id=' . $cart_id . '&cart_stock_id=' . $cart_stock_id . '&cart_qty=' . $cart_qty . '"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $no++;
                }

                $resultado3 = $conexion->query("SELECT * from cart_serv c, cat_servicios i where $paciente1 = c.paciente and i.id_serv = c.servicio_id") or die($conexion->error);
            
                while ($row_lista_serv = $resultado3->fetch_assoc()) {
                  $cart_id = $row_lista_serv['cart_id'];
                  $cart_qty = $row_lista_serv['cart_qty'];
                  echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . $row_lista_serv['serv_desc'] . '</td>'
                    . '<td>' . $cart_qty . '</td>'
                    . '<td> <a type="submit" class="btn btn-danger btn-sm" href="cargar_paquete.php?q=eliminar_serv&paciente= ' . $paciente1 . '&cart_id=' . $cart_id . '&cart_qty=' . $cart_qty . '"><span class = "fa fa-trash"></span></a></td>';
                  echo '</tr>';
                  $no++;
                }
                ?>
              </tbody>
            </table>
         </div> 
  </div>
</div>
<!--TERMINO MEDICAMENTOS,ETC-->

<!--INICIO INGRESOS-->
  <div class="tab-pane fade" id="nav-ing" role="tabpanel" aria-labelledby="nav-contact-tab">
    <br><br>
    <!-- inicio seccion de dispositivos invasivos-->
<div class="container">
  <form action="" method="POST" id="medicamentos">
  <div class="row">
           <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-warning">
            <th colspan="5"><center><h5><strong>DISPOSITIVOS INVASIVOS</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col"><center>DISPOSITIVO</center></th>
      <th scope="col"><center>CALIBRE</center></th>
      <th scope="col"><center>QUIEN LO INSTALO</center></th>
      <th scope="col"><center>FECHA</center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="text" name="disp1" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="cal1" class="form-control col-sm-12" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="nom1" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="date" name="fecha1" class="form-control"></td>
    </tr>
  </tbody>
</table>
OBSERVACIONES:<br><textarea rows="3" name="frec5_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea> 
     </div>
</form>
<center><button type="submit" name="btn-med" id="medicamentos" class="btn btn-primary">AGREGAR</button></center>
</div>
<!-- termino seccion de dispositivos invasivos--> 
 <hr>   
<form action="" method="POST">
 <div class="container">
    <div class="row">
           <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-warning">
            <th colspan="5"><center><h5><strong>INGRESOS</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col"><center>HORA</center></th>
      <th scope="col"><center>VIA PARENTERAL</center></th>
      <th scope="col"><center>HEMODERIVADOS</center></th>
      <th scope="col"><center></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="time" name="frec1_m" class="form-control"></td>
      <td><input type="text" name="med1_m" class="form-control col-sm-12" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec1_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" ></td>
      <td><center><button type="submit" class="btn btn-primary">AGREGAR</button></td>
    </tr>
  </tbody>
</table>
     </div><hr>
 </div> 
</form><hr>

  </div>
<!--TERMINO INGRESOS-->

<!--INICIO EGRESOS-->
  <div class="tab-pane fade" id="nav-egr" role="tabpanel" aria-labelledby="nav-contact-tab">
    <br><br>
    <!-- inicio glicemia -->
<hr>
<form action="" method="POST">
   <div class="row">
          <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-warning">
            <th colspan="5"><center><h5><strong>GLICEMIA CAP.Mg/dl</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col"><center>Mg/Dl</center></th>
      <th scope="col"><center>HORA</center></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      
      <td><input type="text" name="frec1_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="time" name="frec1_m" class="form-control"></td>
      <td><center><button type="submit" class="btn btn-primary">AGREGAR</button></td>
    </tr>
  </tbody>
</table>
     </div><hr>
</form>
<!-- termino glicemia -->
<!-- inicio insulino terapia-->
<form action="" method="POST">
  <hr>
     <div class="row">
         <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-warning">
            <th colspan="5"><center><h5><strong>INSULINOTERAPIA</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col"><center>DOSIS</center></th>
      <th scope="col"><center>VIA</center></th>
      <th scope="col"><center>HORA</center></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="text" name="med1_m" class="form-control col-sm-12" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dias1_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="time" name="" class="form-control"></td>
      <td><center><button type="submit" class="btn btn-primary">AGREGAR</button></td>
    </tr>
  </tbody>
</table>
     </div>
</form>
<!--termino de insulinoterapia-->
   <hr> 
  <!--inicio de cistoclisis--> 
<form action="" method="POST">
   <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-warning">
            <th colspan="5"><center><h5><strong>CISTOCLISIS CON SOLUCIÓN FISIÓLOGICA 1000ML</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <th scope="col"><center>INGRESOS</center></th>
      <th scope="col"><center>EGRESOS</center></th>
      <th scope="col"><center>CARACTERISTICAS</center></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="text" name="dias1_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec1_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="via1_m" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><center><button type="submit" class="btn btn-primary">AGREGAR</button></center></td>
    </tr>
  </tbody>
</table> 
     </div><hr>
</form>
<!--termino de cistoclisis-->
  </div>
<!--TERMINO EGRESOS-->
</div>
   
 
                

            </form>

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


</body>

</html>