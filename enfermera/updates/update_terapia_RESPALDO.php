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
          
            <div class="thead" style="background-color: #0c675e; color: white; font-size: 25px;">
                 <tr><strong><center>REGISTRO CLÍNICO DE ENFERMERÍA CUIDADOS INTENSIVOS</center></strong>
        </div>
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
      FECHA DE NACIMIENTO: <strong><?php echo date_format($date, "d-m-Y") ?></strong>
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

      PESO: <strong><?php $sql_vit = "SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
      
$result_vit = $conexion->query($sql_vit);                                                                                    while ($row_vit = $result_vit->fetch_assoc()) {
    $peso=$row_vit['peso'];

} if (!isset($peso)){
    $peso=0;
   
}   echo $peso;?></strong>
    </div>
  
      <div class="col-sm">
      TALLA: <strong><?php $sql_vitt =" SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_vitt = $conexion->query($sql_vitt);                                                                                    while ($row_vitt = $result_vitt->fetch_assoc()) {
    $talla=$row_vitt['talla'];
 
} if (!isset($talla)){
    
    $talla=0;
}   echo $talla;?></strong>
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
      EXPEDIENTE: <strong><?php echo $id_exp?> </strong>
    </div>
     <div class="col-sm">
    SEGURO: <strong><?php $sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha DESC limit 1";
            $result_aseg = $conexion->query($sql_aseg);
                while ($row_aseg = $result_aseg->fetch_assoc()) {
                echo $row_aseg['aseg'];
            }
                 ?></strong>
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
<div class="tab-content" id="nav-tabContent">
<?php  
$id_enf_mat=$_GET['id_enf_mat'];
$select="SELECT * FROM enf_ter where id_enf_mat=$id_enf_mat";
$result=$conexion->query($select);
while ($row=$result->fetch_assoc()) {
 ?>
  <!--INICIO MATUTINO-->
<form action="insertar_reg_ter.php" method="POST">
    <div class="row">
        <div class="col-sm-4">
            <label>TURNO : </label>
            <input type="text" name="turno" value="<?php echo $row['turno'] ?>" class="form-control" disabled>
        </div>
    </div>
<br><hr>
    <div class="row">
                    <div class="col-sm-4">
                        <label class="control-label"><strong>FECHA:</strong> </label>
                        <input type="date" class="form-control" name="fecha_m" value="<?php echo $row['fecha_m'] ?>" class="form-control">
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label"><strong>HORA:</strong></label>
                       <select class="form-control" name="hora_m">
                       <center>
                        <option value="<?php echo $row['hora_m'] ?>"><?php echo $row['hora_m'] ?></option>
                        <option></option>
                        <option>SELECCIONA UNA HORA</option>
                        <option value="08:00:00">08:00</option>
                        <option value="09:00:00">09:00</option>
                        <option value="10:00:00">10:00</option>
                        <option value="11:00:00">11:00</option>
                        <option value="12:00:00">12:00</option>
                        <option value="13:00:00">13:00</option> 
                       </center>                           
                       </select>
                    </div>

<div class="col-sm-3">
            <input type="hidden" name="turno" value="MATUTINO">
        </div>    
  </div>
                    <hr>
<!--
 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Peso: </label>
                            <input type="text" class="form-control" name="peso_m" step="0.01" placeholder="Kg." id="peso" minlength="0.0"  onkeypress="return SoloNumeros(event);"
                                   class="form-control-sm" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Talla: </label>
                            <input type="text" class="form-control" onkeypress="return SoloNumeros(event);" name="talla_m" step="1" placeholder="CM." id="talla"
                                   class="form-control-sm" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col-md-3">
                        <legend class="col-form-label col-sm-12 pt-0">CASO MÉDICO LEGAL:</legend>
                <?php if ($row['medlegal_m'] == "SI") {?>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" class="form-control" type="radio" name="medlegal_m" id="medlegal"
                                       value="SI" checked>SI
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" class="form-control" type="radio" name="medlegal_m" id="medlegal"
                                       value="NO">NO
                            </div>
                        </div>
                <?php }else{ ?>
                    <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" class="form-control" type="radio" name="medlegal_m" id="medlegal"
                                       value="SI" >SI
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" class="form-control" type="radio" name="medlegal_m" id="medlegal"
                                       value="NO"checked>NO
                            </div>
                        </div>
                <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <legend class="col-form-label col-sm-12 pt-0">CÓDIGO MATER:</legend>
                        <?php if ($row['codigomater_m'] == "SI") {?>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" class="form-control" type="radio" name="codigomater_m" id="codigomater"
                                       value="SI" checked>SI
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" class="form-control" type="radio" name="codigomater_m" id="codigomater"
                                       value="NO">NO
                            </div>
                        </div>
                <?php }else{ ?>
                    <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" class="form-control" type="radio" name="codigomater_m" id="codigomater"
                                       value="SI" >SI
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" class="form-control" type="radio" name="codigomater_m" id="codigomater"
                                       value="NO"checked>NO
                            </div>
                        </div>
                <?php } ?>
                        
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">ASC: </label>
                            <input type="text" class="form-control" name="asc_m" step="0.01" placeholder="" id="asc"
                                   class="form-control-sm" value="<?php echo $row['asc_m'] ?>" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">IMC: </label>
                            <input type="text" class="form-control" name="imc_m" step="1" placeholder="" id="imc"
                                   class="form-control-sm" value="<?php echo $row['imc_m'] ?>">
                        </div>
                    </div>
                </div>
                <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                 <tr><strong><center>ESCALAS DE VALORACIÓN PARA CUIDADOS ESPECÍFICOS DE SEGURIDAD Y PROTECCIÓN</center></strong>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-bordered">
  <thead class="thead">
     <tr class="table-warning">
      <th colspan="18"><center><h5><strong>VALORACIÓN CLÍNICA DE ENFERMERÍA</strong></h5></center></th>
    </tr>
    <tr class="table-active">
                                <th>NIVELES DE DEPENDENCIA</th>
                                <th>FUENTE DE DIFICULTAD</th>
                            </tr>
                            </thead >
                            <tbody>
                            <tr>
                                <td>1. TOTALMENTE DEPENDIENTE</td>
                                <td>C. CONOCIMIENTO</td>
                            </tr>
                            <tr>
                                <td>2. PARCIALMENTE DEPENDIENTE</td>
                                <td>F. Fuerza</td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>3. INDEPENDIENTE</td>
                                <td>V. VOLUNTAD</td>
                            </tr>
                            </tfoot>
                        </table><br>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">OXIGENACIÓN: </label>
                                    <input maxlength="2" class="form-control"  type="text" name="oxigenacion_m"  placeholder="OXIGENACIÓN" id="oxigenacion" class="form-control-sm" value="<?php echo $row['oxigenacion_m'] ?>" required>
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">HIDRATACIÓN: </label>
                                    <input maxlength="2" class="form-control" type="text" name="hidratacion_m"  placeholder="HIDRATACIÓN" id="hidratacion" class="form-control-sm" value="<?php echo $row['hidratacion_m'] ?>" required>
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ALIMENTACIÓN: </label>
                                    <input maxlength="2" class="form-control" type="text" name="alimentacion_m"  placeholder="ALIMENTACIÓN" id="alimentacion" class="form-control-sm" value="<?php echo $row['alimentacion_m'] ?>" required>
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ELIMINACIÓN: </label>
                                    <input maxlength="2" class="form-control" type="text" name="eliminacion_m"  placeholder="ELIMINACIÓN" id="eliminacion" class="form-control-sm" value="<?php echo $row['eliminacion_m'] ?>" required>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <br>
                                    <label class="col-sm-12 control-label">ACTIVIDAD Y DESCANSO: </label>
                                    <input maxlength="2" class="form-control" type="text" name="actydesc_m"  placeholder="ACTIVIDAD Y DESCANSO" id="actydesc" class="form-control-sm" value="<?php echo $row['actydesc_m'] ?>" required>
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">SOLEDAD E INTERACCIÓN SOCIAL: </label>
                                    <input maxlength="2"  type="text" name="sol_m"  placeholder="SOLEDAD E INTERACCIÓN" id="seis"  class="form-control" value="<?php echo $row['sol_m'] ?>" required>
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <br>
                                    <label class="col-sm-12 control-label">AUTOCONCEPTO: </label>
                                    <input maxlength="2" type="text" name="autoconcepto_m"  placeholder="AUTOCONCEPTO" id="autoconcepto"
                                           class="form-control" value="<?php echo $row['autoconcepto_m'] ?>" required>
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-sm-14 control-label">PREVENCIÓN DE RIESGO DE SALUD: </label>
                                    <input maxlength="2" type="text" name="prev_m"  placeholder="PREVENCIÓN DE RIESGOS" id="pdrds"
                                           class="form-control" value="<?php echo $row['prev_m'] ?>" required>
                                </div>

                            </div>
                        
                        </div><hr>
                        <div >
                            <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                                 <tr><strong><center>VALORACIÓN DEL DOLOR (EVA)</center></strong>
                            </div> 
                            <center>
                                  <img src="../../imagenes/caras.png" height="200">
                            </center>                
                     </div><br>
                     <div class="row">
                         <div class="col">
                                <caption>RESULTADO EVA:</caption>
                                <input type="text"  name="resval_m" onkeypress="return SoloNumeros(event);" required="" class="form-control" value="<?php echo $row['resval_m'] ?>">
                            </div>
                            <div class="col">

                                    <label>LABORATORIOS DE CONTROL:</label>
                                    <input type="text" name="labdecontrol_m" class="form-control" value="<?php echo $row['labdecontrol_m'] ?>">
                            </div>
                     </div>


                    </div>
                </div>
                <hr>
<div class="table-responsive">
<table class="table table-bordered">
  <thead class="thead">
     <tr class="table-warning">
      <th colspan="18"><center><h5><strong>CONTROL DE DISPOSITIVOS INVASIVOS</strong></h5></center></th>
    </tr>
    <tr class="table-active">
      <th scope="col" colspan="1"><center>DISPOSITIVOS</center></th>
      <th scope="col" colspan="1" >CALIBRE</th>
      <th scope="col" colspan="2">SITIO DE INSTALACIÓN</th>
      <th scope="col" colspan="9">NOMBRE DE QUIEN INSTALO</th>
      <th scope="col" colspan="2">DATOS DE CURACIÓN</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" colspan="1">C. VENOSO CENTRAL</th>
        <td colspan="1"><input type="text" name="calv_m" class="form-control" value="<?php echo $row['calv_m'] ?>"></td>
        <td colspan="2"><input type="text" name="sitv_m" class="form-control" value="<?php echo $row['sitv_m'] ?>"></td>
        <td colspan="9"><input type="text" name="nomv_m" class="form-control" value="<?php echo $row['nomv_m'] ?>"></td>
        <td colspan="1"><input type="text" name="datv_m" class="form-control" value="<?php echo $row['datv_m'] ?>"></td>

    </tr>
    <tr>
      <th scope="row" colspan="1">C. PERIFERICO 1</th>
         <td colspan="1"><input type="text" name="calp_m" class="form-control" value="<?php echo $row['calp_m'] ?>"></td>
         <td colspan="2"><input type="text" name="sitp_m" class="form-control" value="<?php echo $row['sitp_m'] ?>"></td>
         <td colspan="9"><input type="text" name="nomp_m" class="form-control" value="<?php echo $row['nomp_m'] ?>"></td>
         <td colspan="1"><input type="text" name="datp_m" class="form-control" value="<?php echo $row['datp_m'] ?>"></td>
    </tr>
    <tr>
      <th scope="row" colspan="1">C. PERIFERICO 2</th>
        <td colspan="1"><input type="text" name="calp2_m" class="form-control" value="<?php echo $row['calp2_m'] ?>"></td>
        <td colspan="2"><input type="text" name="sitp2_m" class="form-control" value="<?php echo $row['sitp2_m'] ?>"></td>
        <td colspan="9"><input type="text" name="nomp2_m" class="form-control" value="<?php echo $row['nomp2_m'] ?>"></td>
        <td colspan="1"><input type="text" name="datp2_m" class="form-control" value="<?php echo $row['datp2_m'] ?>"></td>
    </tr>
    <tr>
      <th scope="row" colspan="1">T. ENDOTRAQUEAL</th>
        <td colspan="1"><input type="text" name="cale_m" class="form-control" value="<?php echo $row['cale_m'] ?>"></td>
        <td colspan="2"><input type="text" name="site_m" class="form-control" value="<?php echo $row['site_m'] ?>"></td>
        <td colspan="9"><input type="text" name="nome_m" class="form-control" value="<?php echo $row['nome_m'] ?>"></td>
        <td colspan="1"><input type="text" name="date_m" class="form-control" value="<?php echo $row['date_m'] ?>"></td>
    </tr>
    <tr>
      <th scope="row" colspan="1">SONDA VESICAL</th>
        <td colspan="1"><input type="text" name="cals_m" class="form-control" value="<?php echo $row['cals_m'] ?>"></td>
        <td colspan="2"><input type="text" name="sits_m" class="form-control" value="<?php echo $row['sits_m'] ?>"></td>
        <td colspan="9"><input type="text" name="noms_m" class="form-control" value="<?php echo $row['noms_m'] ?>"></td>
        <td colspan="1"><input type="text" name="dats_m" class="form-control" value="<?php echo $row['dats_m'] ?>"></td>
    </tr>
    <tr>
      <th scope="row" colspan="1">S. NASO U OROGÁSTRICA</th>
         <td colspan="1"><input type="text" name="caln_m" class="form-control" value="<?php echo $row['caln_m'] ?>"></td>
         <td colspan="2"><input type="text" name="sitn_m" class="form-control" value="<?php echo $row['sitn_m'] ?>"></td>
         <td colspan="9"><input type="text" name="nomn_m" class="form-control" value="<?php echo $row['nomn_m'] ?>"></td>
         <td colspan="1"><input type="text" name="datn_m" class="form-control" value="<?php echo $row['datn_m'] ?>"></td>
    </tr>
  </tbody>
</table>
</div>
<hr>
  <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                 <tr><strong><center>VALORACIÓN DE LA PIEL</center></strong>
  </div>

  <div class="container">
  <div class="row">
<?php if ($row['quem_m']=="SI") { ?>
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="SI" name="quem_m" id="quemadura" checked>
  <label class="form-check-label" for="quemadura">
    A) QUEMADURAS
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="SI" name="quem_m" id="quemadura">
  <label class="form-check-label" for="quemadura">
    A) QUEMADURAS
  </label>
    </div>
<?php } ?>
<?php if ($row['uls_m']=="SI") { ?>
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="SI" name="uls_m" id="herida" checked>
  <label class="form-check-label" for="herida">
    F) ULSERA POR PRESIÓN
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="SI" name="uls_m" id="herida">
  <label class="form-check-label" for="herida">
    F) ULSERA POR PRESIÓN
  </label>
    </div>
<?php } ?>
    
<?php if ($row['nec_m']=="SI") { ?>
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="SI" name="nec_m" id="enfisema" checked>
  <label class="form-check-label" for="enfisema">
    K) NECROSIS
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="SI" name="nec_m" id="enfisema">
  <label class="form-check-label" for="enfisema">
    K) NECROSIS
  </label>
    </div>
<?php } ?>
    
  </div>
</div>

<div class="container">
  <div class="row">
<?php if ($row['her_m']=="SI") { ?>
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="SI" name="her_m" id="ulcera" checked>
  <label class="form-check-label" for="ulcera">
    B) HERIDA QUIRÚRGICA
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
      <input class="form-check-input" type="checkbox" value="SI" name="her_m" id="ulcera">
  <label class="form-check-label" for="ulcera">
    B) HERIDA QUIRÚRGICA
  </label>
    </div>
<?php } ?>
    
    <?php if ($row['tub_m']=="SI") { ?>
        <div class="col-sm">
      <input class="form-check-input" name="tub_m" type="checkbox" value="SI" id="dermo" checked>
  <label class="form-check-label" for="dermo">
    G) TUBOS Y DENAJES
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
      <input class="form-check-input" name="tub_m" type="checkbox" value="SI" id="dermo">
  <label class="form-check-label" for="dermo">
    G) TUBOS Y DENAJES
  </label>
    </div>
<?php } ?>
    
    <?php if ($row['der_m']=="SI") { ?>
        <div class="col-sm">
      <input class="form-check-input" name="der_m" type="checkbox" value="SI" id="hematoma" checked>
  <label class="form-check-label" for="hematoma">
    L) DERMOESCORIACIÓN
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
      <input class="form-check-input" name="der_m" type="checkbox" value="SI" id="hematoma">
  <label class="form-check-label" for="hematoma">
    L) DERMOESCORIACIÓN
  </label>
    </div>
<?php } ?>
    
     
  </div>
</div>
<div class="container">
  <div class="row">
    <?php if ($row['ras_m']=="SI") { ?>
        <div class="col-sm">
      <input class="form-check-input" name="ras_m"  type="checkbox" value="SI" id="ciano" checked>
  <label class="form-check-label" for="ciano">
    C) RASH
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
      <input class="form-check-input" name="ras_m"  type="checkbox" value="SI" id="ciano">
  <label class="form-check-label" for="ciano">
    C) RASH
  </label>
    </div>
<?php } ?>
    
    <?php if ($row['eq_m']=="SI") { ?>
        <div class="col-sm">
        <input class="form-check-input" name="eq_m" type="checkbox" value="SI" id="rash" checked>
  <label class="form-check-label" for="rash">
    H) EQUIMOSIS
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
        <input class="form-check-input" name="eq_m" type="checkbox" value="SI" id="rash">
  <label class="form-check-label" for="rash">
    H) EQUIMOSIS
  </label>
    </div>
<?php } ?>
    
    <?php if ($row['enf_m']=="SI") { ?>
        <div class="col-sm">
      <input class="form-check-input" name="enf_m" type="checkbox" value="SI" id="fracturas" checked>
  <label class="form-check-label" for="fracturas">
    M) ENFISEMA SUBCUTÁNEO
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
      <input class="form-check-input" name="enf_m" type="checkbox" value="SI" id="fracturas">
  <label class="form-check-label" for="fracturas">
    M) ENFISEMA SUBCUTÁNEO
  </label>
    </div>
<?php } ?>
    
  </div>
</div>
<div class="container">
  <div class="row">
    <?php if ($row['ema_m']=="SI") { ?>
        <div class="col-sm">
      <input class="form-check-input" name="ema_m" type="checkbox" value="SI" id="quir" checked>
  <label class="form-check-label" for="quir">
    D) HEMATOMA
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
      <input class="form-check-input" name="ema_m" type="checkbox" value="SI" id="quir">
  <label class="form-check-label" for="quir">
    D) HEMATOMA
  </label>
    </div>
<?php } ?>
  <?php if ($row['frac_m']=="SI") { ?>
            <div class="col-sm">
        <input class="form-check-input" name="frac_m" type="checkbox" value="SI" id="equi" checked>
  <label class="form-check-label" for="equi">
    I) FRACTURA
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
        <input class="form-check-input" name="frac_m" type="checkbox" value="SI" id="equi">
  <label class="form-check-label" for="equi">
    I) FRACTURA
  </label>
    </div>
<?php } ?>
    
    <?php if ($row['acc_m']=="SI") { ?>
            <div class="col-sm">
      <input class="form-check-input" name="acc_m" type="checkbox" value="SI" id="previas" checked>
  <label class="form-check-label" for="previas">
    N) ACCESOS VASCULARES
  </label>
    </div>
<?php }else{?>
        <div class="col-sm">
      <input class="form-check-input" name="acc_m" type="checkbox" value="SI" id="previas">
  <label class="form-check-label" for="previas">
    N) ACCESOS VASCULARES
  </label>
    </div>
<?php } ?>

  </div>
</div>
<div class="container">
  <div class="row">
    <?php if ($row['pete_m']=="SI") { ?>
        <div class="col-sm">
      <input class="form-check-input" name="pete_m" type="checkbox" value="SI" id="quir" checked>
  <label class="form-check-label" for="quir">
    E) PETEQUIAS
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
      <input class="form-check-input" name="pete_m" type="checkbox" value="SI" id="quir">
  <label class="form-check-label" for="quir">
    E) PETEQUIAS
  </label>
    </div>
<?php } ?>
    
    <?php if ($row['ede_m']=="SI") { ?>
        <div class="col-sm">
        <input class="form-check-input" name="ede_m" type="checkbox" value="SI" id="equi" checked>
  <label class="form-check-label" for="equi">
    J) EDEMIA
  </label>
    </div>
<?php }else{?>
    <div class="col-sm">
        <input class="form-check-input" name="ede_m" type="checkbox" value="SI" id="equi">
  <label class="form-check-label" for="equi">
    J) EDEMIA
  </label>
    </div>
<?php } ?>
    
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
<?php if($row['fron_m']=="FRONTAL"){?>
     <br><br><input class="form-check-input" type="checkbox" value="FRONTAL" id="fron" name="fron_m" checked>
  <label class="form-check-label" for="fron">
    1. FRONTAL
  </label><br>
<?php }else{?>
     <br><br><input class="form-check-input" type="checkbox" value="FRONTAL" id="fron" name="fron_m">
  <label class="form-check-label" for="fron">
    1. FRONTAL
  </label><br>
<?php } ?>

<?php if($row['mal_m']=="MALAR"){?>
   <input class="form-check-input" name="mal_m" type="checkbox" value="MALAR" id="malar" checked>
  <label class="form-check-label" for="malar">
    2. MALAR
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="mal_m" type="checkbox" value="MALAR" id="malar">
  <label class="form-check-label" for="malar">
    2. MALAR
  </label><br>
<?php } ?>

<?php if($row['man_m']=="MANDIBULAR"){?>
   <input class="form-check-input" name="man_m" type="checkbox" value="MANDIBULAR" id="mandi" checked>
  <label class="form-check-label" for="mandi">
    3. MANDIBULAR
  </label><br><br><p>
<?php }else{?>
   <input class="form-check-input" name="man_m" type="checkbox" value="MANDIBULAR" id="mandi">
  <label class="form-check-label" for="mandi">
    3. MANDIBULAR
  </label><br><br><p>
<?php } ?>

<?php if($row['del_m']=="DELTOIDEA"){?>
   <input class="form-check-input" name="del_m" type="checkbox" value="DELTOIDEA" id="delto" checked>
  <label class="form-check-label" for="delto">
    4. DELTOIDEA
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="del_m" type="checkbox" value="DELTOIDEA" id="delto">
  <label class="form-check-label" for="delto">
    4. DELTOIDEA
  </label><br>
<?php } ?>

<?php if($row['pec_m']=="PECTORAL"){?>
   <input class="form-check-input" name="pec_m" type="checkbox" value="PECTORAL" id="pec" checked>
  <label class="form-check-label" for="pec">
   5. PECTORAL
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="pec_m" type="checkbox" value="PECTORAL" id="pec">
  <label class="form-check-label" for="pec">
   5. PECTORAL
  </label><br>
<?php } ?>

<?php if($row['est_m']=="ESTERNAL"){?>
   <input class="form-check-input" name="est_m" type="checkbox" value="ESTERNAL" id="ester" checked>
  <label class="form-check-label" for="ester">
    6. ESTERNAL
  </label><br><br><br>
<?php }else{?>
   <input class="form-check-input" name="est_m" type="checkbox" value="ESTERNAL" id="ester">
  <label class="form-check-label" for="ester">
    6. ESTERNAL
  </label><br><br><br>
<?php } ?>

<?php if($row['ant_m']=="ANTEBRAZO"){?>
   <input class="form-check-input" name="ant_m" type="checkbox" value="ANTEBRAZO" id="ante" checked>
  <label class="form-check-label" for="ante">
    7. ANTEBRAZO
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="ant_m" type="checkbox" value="ANTEBRAZO" id="ante">
  <label class="form-check-label" for="ante">
    7. ANTEBRAZO
  </label><br>
<?php } ?>

<?php if($row['mu_m']=="MUÑECA"){?>
   <input class="form-check-input" name="mu_m" type="checkbox" value="MUÑECA" id="muñeca" checked>
  <label class="form-check-label" for="muñeca">
    8. MUÑECA
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="mu_m" type="checkbox" value="MUÑECA" id="muñeca">
  <label class="form-check-label" for="muñeca">
    8. MUÑECA
  </label><br>
<?php } ?>


<?php if($row['mano_m']=="MANO (PALMA)"){?>
   <input class="form-check-input" name="mano_m" type="checkbox" value="MANO (PALMA)" id="mano" checked>
  <label class="form-check-label" for="mano">
    9. MANO (PALMA)
  </label><br><br><br><p>
<?php }else{?>
   <input class="form-check-input" name="mano_m" type="checkbox" value="MANO (PALMA)" id="mano">
  <label class="form-check-label" for="mano">
    9. MANO (PALMA)
  </label><br><br><br><p>
<?php } ?>

<?php if($row['mus_m']=="MUSLO"){?>   
    <input class="form-check-input" name="mus_m" type="checkbox" value="MUSLO" id="muslo" checked>
  <label class="form-check-label" for="muslo">
  10. MUSLO
  </label><br>
<?php }else{?>   <input class="form-check-input" name="mus_m" type="checkbox" value="MUSLO" id="muslo">
  <label class="form-check-label" for="muslo">
  10. MUSLO
  </label><br>
<?php } ?>

<?php if($row['rod_m']=="RODILLA"){?>
   <input class="form-check-input" name="rod_m" type="checkbox" value="RODILLA" id="rodilla" checked>
  <label class="form-check-label" for="rodilla">
  11. RODILLA
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="rod_m" type="checkbox" value="RODILLA" id="rodilla">
  <label class="form-check-label" for="rodilla">
  11. RODILLA
  </label><br>
<?php } ?>

<?php if($row['pier_m']=="PIERNA"){?>
    <input class="form-check-input" name="pier_m" type="checkbox" value="PIERNA" id="pierna" checked>
  <label class="form-check-label" for="pierna">
  12. PIERNA
  </label>
<?php }else{?>
    <input class="form-check-input" name="pier_m" type="checkbox" value="PIERNA" id="pierna">
  <label class="form-check-label" for="pierna">
  12. PIERNA
  </label>
<?php } ?>
   
    </div>
    <div class="col-sm">
    <img src="../../imagenes/cuerpofrontal.jpg" height="485">
    </div>
    <div class="col-sm-2">
      <br>
<?php if($row['pri_m']=="PIRAMIDE NASAL"){?>
      <input class="form-check-input" name="pri_m" type="checkbox" value="PIRAMIDE NASAL" id="nasa" checked>
  <label class="form-check-label" for="nasa">
  13. PIRAMIDE NASAL
  </label><br>
<?php }else{?>
      <input class="form-check-input" name="pri_m" type="checkbox" value="PIRAMIDE NASAL" id="nasa">
  <label class="form-check-label" for="nasa">
  13. PIRAMIDE NASAL
  </label><br>
<?php } ?>

<?php if($row['max_m']=="MAXILAR SUPERIOR"){?>
    <input class="form-check-input" name="max_m" type="checkbox" value="MAXILAR SUPERIOR" id="maxi" checked>
  <label class="form-check-label" for="maxi">
  14. MAXILAR SUPERIOR
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="max_m" type="checkbox" value="MAXILAR SUPERIOR" id="maxi">
  <label class="form-check-label" for="maxi">
  14. MAXILAR SUPERIOR
  </label><br>
<?php } ?>

<?php if($row['men_m']=="MENTON"){?>
    <input class="form-check-input" name="men_m" type="checkbox" value="MENTON" id="menton" checked>
  <label class="form-check-label" for="menton">
  15. MENTON
  </label><br><br><br>
<?php }else{?>
    <input class="form-check-input" name="men_m" type="checkbox" value="MENTON" id="menton">
  <label class="form-check-label" for="menton">
  15. MENTON
  </label><br><br><br>
<?php } ?>

<?php if($row['ac_m']=="ACROMIAL"){?>
    <input class="form-check-input" name="ac_m" type="checkbox" value="ACROMIAL" id="acromial" checked>
  <label class="form-check-label" for="acromial">
  16. ACROMIAL
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="ac_m" type="checkbox" value="ACROMIAL" id="acromial">
  <label class="form-check-label" for="acromial">
  16. ACROMIAL
  </label><br>
<?php } ?>

<?php if($row['bra_m']=="BRAZO"){?>
    <input class="form-check-input" name="bra_m" type="checkbox" value="BRAZO" id="brazo" checked>
  <label class="form-check-label" for="brazo">
  17. BRAZO
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="bra_m" type="checkbox" value="BRAZO" id="brazo">
  <label class="form-check-label" for="brazo">
  17. BRAZO
  </label><br>
<?php } ?>

<?php if($row['pli_m']=="PLIEGUE DEL CODO"){?>
    <input class="form-check-input" name="pli_m" type="checkbox" value="PLIEGUE DEL CODO" id="pliegue" checked>
  <label class="form-check-label" for="pliegue">
  18. PLIEGUE DEL CODO
  </label><br><br><br>
<?php }else{?>
    <input class="form-check-input" name="pli_m" type="checkbox" value="PLIEGUE DEL CODO" id="pliegue">
  <label class="form-check-label" for="pliegue">
  18. PLIEGUE DEL CODO
  </label><br><br><br>
<?php } ?>

<?php if($row['abd_m']=="ABDOMEN"){?>
    <input class="form-check-input" name="abd_m" type="checkbox" value="ABDOMEN" id="adbo" checked>
  <label class="form-check-label" for="adbo">
  19. ABDOMEN
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="abd_m" type="checkbox" value="ABDOMEN" id="adbo">
  <label class="form-check-label" for="adbo">
  19. ABDOMEN
  </label><br>
<?php } ?>

<?php if($row['reg_m']=="REGIÓN INGUINAL"){?>
    <input class="form-check-input" name="reg_m" type="checkbox" value="REGIÓN INGUINAL" id="inguinal" checked>
  <label class="form-check-label" for="inguinal">
  20. REGIÓN INGUINAL
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="reg_m" type="checkbox" value="REGIÓN INGUINAL" id="inguinal">
  <label class="form-check-label" for="inguinal">
  20. REGIÓN INGUINAL
  </label><br>
<?php } ?>

<?php if($row['pub_m']=="REGIÓN PUBIANA"){?>
    <input class="form-check-input" name="pub_m" type="checkbox" value="REGIÓN PUBIANA" id="pub" checked>
  <label class="form-check-label" for="pub">
  21. REGIÓN PUBIANA
  </label><br>
  <p>
<?php }else{?>
    <input class="form-check-input" name="pub_m" type="checkbox" value="REGIÓN PUBIANA" id="pub">
  <label class="form-check-label" for="pub">
  21. REGIÓN PUBIANA
  </label><br>
  <p>
<?php } ?>

<?php if($row['pde_m']=="PRIMER DEDO"){?>
    <input class="form-check-input" name="pde" type="checkbox" value="PRIMER DEDO" id="pdedo" checked>
  <label class="form-check-label" for="pdedo">
  22. PRIMER DEDO
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="pde" type="checkbox" value="PRIMER DEDO" id="pdedo">
  <label class="form-check-label" for="pdedo">
  22. PRIMER DEDO
  </label><br>
<?php } ?>

<?php if($row['sde_m']=="SEGUNDO DEDO"){?>
    <input class="form-check-input" name="sde_m" type="checkbox" value="SEGUNDO DEDO" id="sdedo" checked>
  <label class="form-check-label" for="sdedo">
  23. SEGUNDO DEDO
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="sde_m" type="checkbox" value="SEGUNDO DEDO" id="sdedo">
  <label class="form-check-label" for="sdedo">
  23. SEGUNDO DEDO
  </label><br>
<?php } ?>

<?php if($row['tde_m']=="TERCER DEDO"){?>
    <input class="form-check-input" name="tde_m" type="checkbox" value="TERCER DEDO" id="tdedo" checked>
  <label class="form-check-label" for="tdedo">
  24. TERCER DEDO
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="tde_m" type="checkbox" value="TERCER DEDO" id="tdedo">
  <label class="form-check-label" for="tdedo">
  24. TERCER DEDO
  </label><br>
<?php } ?>

<?php if($row['cde_m']=="CUARTO DEDO"){?>
    <input class="form-check-input" name="cde_m" type="checkbox" value="CUARTO DEDO" id="cdedo" checked>
  <label class="form-check-label" for="cdedo">
  25. CUARTO DEDO
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="cde_m" type="checkbox" value="CUARTO DEDO" id="cdedo">
  <label class="form-check-label" for="cdedo">
  25. CUARTO DEDO
  </label><br>
<?php } ?>

<?php if($row['qde_m']=="QUINTO DEDO"){?>
    <input class="form-check-input" name="qde_m" type="checkbox" value="QUINTO DEDO" id="qdedo" checked>
  <label class="form-check-label" for="qdedo">
  26. QUINTO DEDO
  </label><br><p>
<?php }else{?>
    <input class="form-check-input" name="qde_m" type="checkbox" value="QUINTO DEDO" id="qdedo">
  <label class="form-check-label" for="qdedo">
  26. QUINTO DEDO
  </label><br><p>
<?php } ?>

<?php if($row['tob_m']=="TOBILLO"){?>
    <input class="form-check-input" name="tob_m" type="checkbox" value="TOBILLO" id="tobillo" checked>
  <label class="form-check-label" for="tobillo">
  27. TOBILLO
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="tob_m" type="checkbox" value="TOBILLO" id="tobillo">
  <label class="form-check-label" for="tobillo">
  27. TOBILLO
  </label><br>
<?php } ?>

<?php if($row['pie_m']=="PIE (DORSO)"){?>
    <input class="form-check-input" name="pie_m" type="checkbox" value="PIE (DORSO)" id="dorso" checked>
  <label class="form-check-label" for="dorso">
  28. PIE (DORSO)
  </label><br>
<?php }else{?>
    <input class="form-check-input" name="pie_m" type="checkbox" value="PIE (DORSO)" id="dorso">
  <label class="form-check-label" for="dorso">
  28. PIE (DORSO)
  </label><br>
<?php } ?>
    </div>
  </div>
</div>
</font>
<hr>
<font size="2">
<div class="container">
  <div class="row">
      <div class="col-sm-2">
<?php if($row['par_m']=="PARIETAL"){?>
     <br><br><br><input class="form-check-input" name="par_m" type="checkbox" value="PARIETAL" id="parietal" checked>
  <label class="form-check-label" for="parietal">
    29. PARIETAL
  </label><br>
<?php }else{?>
     <br><br><br><input class="form-check-input" name="par_m" type="checkbox" value="PARIETAL" id="parietal">
  <label class="form-check-label" for="parietal">
    29. PARIETAL
  </label><br>
<?php } ?>

<?php if($row['occ_m']=="OCCIPITAL"){?>
   <input class="form-check-input" name="occ_m" type="checkbox" value="OCCIPITAL" id="occipital" checked>
  <label class="form-check-label" for="occipital">
  30. OCCIPITAL
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="occ_m" type="checkbox" value="OCCIPITAL" id="occipital">
  <label class="form-check-label" for="occipital">
  30. OCCIPITAL
  </label><br>
<?php } ?>

<?php if($row['nuca_m']=="NUCA"){?>
   <input class="form-check-input" name="nuca_m" type="checkbox" value="NUCA" id="nuca" checked>
  <label class="form-check-label" for="nuca">
    31. NUCA
  </label><br><br><br>
<?php }else{?>
   <input class="form-check-input" name="nuca_m" type="checkbox" value="NUCA" id="nuca">
  <label class="form-check-label" for="nuca">
    31. NUCA
  </label><br><br><br>
<?php } ?>

<?php if($row['braz_m']=="BRAZO"){?>
   <input class="form-check-input" name="braz_m" type="checkbox" value="BRAZO" id="brazo2" checked>
  <label class="form-check-label" for="brazo2">
    32. BRAZO
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="braz_m" type="checkbox" value="BRAZO" id="brazo2">
  <label class="form-check-label" for="brazo2">
    32. BRAZO
  </label><br>
<?php } ?>

<?php if($row['codo_m']=="CODO"){?>
   <input class="form-check-input" name="codo_m" type="checkbox" value="CODO" id="codo2" checked>
  <label class="form-check-label" for="codo2">
   33. CODO
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="codo_m" type="checkbox" value="CODO" id="codo2">
  <label class="form-check-label" for="codo2">
   33. CODO
  </label><br>
<?php } ?>

<?php if($row['ante_m']=="ANTEBRAZO"){?>
   <input class="form-check-input" name="ante_m" type="checkbox" value="ANTEBRAZO" id="ante2" checked>
  <label class="form-check-label" for="ante2">
    34. ANTEBRAZO
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="ante_m" type="checkbox" value="ANTEBRAZO" id="ante2">
  <label class="form-check-label" for="ante2">
    34. ANTEBRAZO
  </label><br>
<?php } ?>

<?php if($row['mune_m']=="MUÑECA"){?>
   <input class="form-check-input" name="mune_m" type="checkbox" value="MUÑECA" id="muñeca2" checked>
  <label class="form-check-label" for="muñeca2">
    35. MUÑECA
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="mune_m" type="checkbox" value="MUÑECA" id="muñeca2">
  <label class="form-check-label" for="muñeca2">
    35. MUÑECA
  </label><br>
<?php } ?>

<?php if($row['mane_m']=="MANO (DORSO)"){?>
   <input class="form-check-input" name="mano2_m" type="checkbox" value="MANO (DORSO)" id="mano2" checked>
  <label class="form-check-label" for="mano2">
    36. MANO (DORSO)
  </label><br><br><br><br><br><br>
<?php }else{?>
   <input class="form-check-input" name="mano2_m" type="checkbox" value="MANO (DORSO)" id="mano2">
  <label class="form-check-label" for="mano2">
    36. MANO (DORSO)
  </label><br><br><br><br><br><br>
<?php } ?>

<?php if($row['plieg_m']=="PLIEGUE POPLITEO"){?>
   <input class="form-check-input" name="plieg_m" type="checkbox" value="PLIEGUE POPLITEO" id="pop" checked>
  <label class="form-check-label" for="pop">
    37. PLIEGUE POPLITEO
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="plieg_m" type="checkbox" value="PLIEGUE POPLITEO" id="pop">
  <label class="form-check-label" for="pop">
    37. PLIEGUE POPLITEO
  </label><br>
<?php } ?>

<?php if($row['piern_m']=="PIERNA"){?>
   <input class="form-check-input" name="piern_m" type="checkbox" value="PIERNA" id="pierna2" checked>
  <label class="form-check-label" for="pierna2">
  38. PIERNA
  </label><br>
<?php }else{?>
   <input class="form-check-input" name="piern_m" type="checkbox" value="PIERNA" id="pierna2">
  <label class="form-check-label" for="pierna2">
  38. PIERNA
  </label><br>
<?php } ?>

<?php if($row['piep_m']=="PIE (PLANTA)"){?>
   <input class="form-check-input" name="piep_m" type="checkbox" value="PIE (PLANTA)" id="planta" checked>
  <label class="form-check-label" for="planta">
  39. PIE (PLANTA)
  </label>
<?php }else{?>
   <input class="form-check-input" name="piep_m" type="checkbox" value="PIE (PLANTA)" id="planta">
  <label class="form-check-label" for="planta">
  39. PIE (PLANTA)
  </label>
<?php } ?>
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
<p>
        <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                 <tr><strong><center>MEDICIONES CLÍNICAS</center></strong>
        </div>
                
            <div class="row">
                <div class="col">
                            <label >GLASGOW: </label>
                            <input type="number" name="glas_m"  placeholder="GLASGOW" id="tam" class="form-control"
                                   style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" required> 
                </div>
                
                <div class="col">
                    <label>GLICEMIA CAPILAR MG/DL:</label><br>
                    <input type="text" name="glic_m" required="" placeholder="GLICEMIA" class="form-control">
                </div>
                <div class="col">
                    <label>PRESIÓN INTRACRANEAL:</label><br>
                    <input type="text" name="pres_m" required="" placeholder="PRESIÓN" class="form-control">
                </div>
            </div><br>
               <div class="row">
                <div class="col">
                    <label>PRESIÓN DE PERFUSIÓN CEREBRAL:</label><br>
                    <input type="number" name="presper_m" required="" placeholder="PERFUSIÓN" class="form-control">
                </div>
        <div class="col">
            <br><label>PRESIÓN INTRAABDOMINAL:</label>
            <input type="" name="presint_m" required="" placeholder="PRESIÓN INTRAABDOMINAL:" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control">
        </div>
        <div class="col">
            <br><label>PERÍMETRO ABDOMINAL:</label>
            <input type="" name="per_m" required="" placeholder="PERÍMETRO ABDOMINAL" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" >
        </div>
        <div class="col">
            <label>PRESIÓN DE PERFUSIÓN ABDOMINAL:</label>
            <input type="" name="preper_m" class="form-control" placeholder="PRESIÓN DE PERFUSIÓN ABDOMINAL" required="" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" >
        </div>
    </div><br>
        <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                 <tr><strong><center>SIGNOS VITALES</center></strong>
        </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                             <br><center><label for="p_sistolica">PRESIÓN ARTERIAL: </label></center>
                             <div class="row">
              <div class="col">
                  <div class="row">
                      <div class="col losInputTAM">
                         <input type="text" placeholder="MM" class="form-control" id="sist" name="pdiast_m" required="">
                      </div> /
                      <div class="col losInputTAM">
                         <input type="text" placeholder="HG" class="form-control" id="diast" name="psist_m" required="">
                      </div>
                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col">
                        <div class="form-group">
                            <br><label for="f_card">FRECUENCIA CARDIACA:</label>
                            <input type="number" name="f_card_m" placeholder="Frecuencia cardiaca" id="f_card"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div>
                        </div>
                   
                    <div class="col">
                        <div class="form-group">
                            <label for="f_resp">FRECUENCIA RESPIRATORIA:</label>
                            <input type="number" name="f_resp_m" placeholder="FRECUENCIA RESPIRATORIA" id="f_resp"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div>
                    </div>
                     <div class="col">
                        <div class="form-group">
                            <br><label for="temp">TEMPERATURA:</label>
                            <input type="number" name="temp_m" placeholder="TEMPERATURA" id="temp" class="form-control"  style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="sat_oxigeno">SATURACIÓN DE OXÍGENO: </label>
                            <input type="number" name="sat_oxigeno_m" placeholder="SATURACIÓN DE OXÍGENO" id="sat_oxigeno"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div>
                    </div>
                </div>
                <div class="row">
         
         <div class="col">
                        <div class="form-group">
                            <br><label>TAM: </label>
                            <div class="col inputTotalTAM"><input type="text" class="form-control" id="tam_m" name="tam_m" disabled="" placeholder="mmHG"></div>
                        </div>
        </div>  
        <div class="col">
                        <div class="form-group">
                            <br><label for="sat_oxigeno">PVC cm H2O: </label>
                            <input type="number" name="pvc_m" placeholder="PVC cm H2O" id="pvc" class="form-control"
                                   style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div>
        </div>    
    </div><br>
    <br>
                    <div class="row">
                  <table class="table table-bordered">
  <thead>
     <tr class="table-warning">
      <th colspan="5"><center><h5><strong>VALORACIÓN PUPILAR</strong></h5></center></th>
    </tr>
    <tr class="table-active">
      <th scope="col"><center>VARIABLE</center></th>
      <th scope="col"><center>OJO DERECHO</center></th>
      <th scope="col"><center>OJO IZQUIERDO</center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><center>TAMAÑO</center></th>
      <td><input type="number" name="tamd_m" class="form-control" required placeholder="TAMAÑO MM" min="1" max="9"></td>
      <td><input type="number" name="tami_m" class="form-control" required placeholder="TAMAÑO MM" min="1" max="9"></td>
     
    </tr>
    <tr>
      <th scope="row"><center>SIMETRIA</center></th>
      <td><input type="text" name="simd_m" class="form-control" placeholder="SIMETRIA" required></td>
      <td><input type="text" name="simi_m" class="form-control" placeholder="SIMETRIA" required></td>
      
    </tr>
   <tr>
      <th colspan="5"><center><img src="../../imagenes/val_pupilar.jpg" height="110"></center></th>
    </tr>
  </tbody>
</table>  
                
                </div>
     <div class="row">
         <div class="col-sm-8"><hr>
            <table class="table table-bordered table-striped" id="mytable">
     <thead class="thead">
    <tr class="table-warning">
      <th colspan="5"><center><h5><strong>ESCALA DE AGITACIÓN SEDACIÓN RASS</strong></h5></center></th>
    </tr>
    <tr class="table-active">
                            <th>PUNTOS</th>
                            <th>CATEGORÍAS</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>+4</td>
                                <td>COMBATIVO</td>
                            </tr>
                            <tr>
                                <td>+3</td>
                                <td>MUY AGITADO</td>
                            </tr>
                            <tr>
                                <td>+2</td>
                                <td>AGITADO</td>
                            </tr>
                             <tr>
                                <td>+1</td>
                                <td>INQUIETO</td>
                            </tr>
                            <tr>
                                <td>0</td>
                                <td>ALERTA Y TRANQUILO</td>
                            </tr>
                            <tr>
                                <td>-1</td>
                                <td>SOMNOLIENTO</td>
                            </tr>
                            <tr>
                                <td>-2</td>
                                <td>SEDACIÓN LIGERA</td>
                            </tr>
                           <tr>
                                <td>-3</td>
                                <td>SEDACIÓN MODERADA</td>
                            </tr>
                            
                            <tr>
                                <td>-4</td>
                                <td>SEDACIÓN PROFUNDA</td>
                            </tr>
                            
                            <tr>
                                <td>-5</td>
                                <td>NO ESTIMULABLE</td>
                            </tr>
                           
                        </table><br>

                    </div>
                    <div class="col-sm-4"><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    <label>Escala de Agitación - Sedación RASS</label>
                    <input type="number" name="agit_m" placeholder="Agitación" class="form-control">
                </div>
                </div>
                <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                    <tr><strong><center>PERFIL HEMODINÁMICO</center></strong>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>PAPM </label>
                            <input type="number" name="papm_m"  id="glicemia"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" >
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="sat_oxigeno">PCP : </label>
                            <input type="number" name="pcp_m" placeholder="mm/hg" id="insulino"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" >
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="sat_oxigeno">RVP: </label>
                            <input type="number" name="rvp_m" placeholder="din-s/cm5" id="capillar"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" >
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="sat_oxigeno">RVS: </label>
                            <input type="text" name="rvs_m" placeholder="din-s/cm5" id="coloracion"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" >
                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col">
                            <label for="sat_oxigeno">GC: </label>
                            <input type="text" name="gc_m" placeholder="L/min" id="coloracion"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" >
                        </div>
                     <div class="col">
                            <label for="sat_oxigeno">IC: </label>
                            <input type="text" name="ic_m" placeholder="L/min/m2" id="coloracion"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" >
                        </div>
                         <div class="col">
                            <label for="sat_oxigeno">VS: </label>
                            <input type="text" name="vs_m" placeholder="ml" id="coloracion"
                                   class="form-control" style="text-transform:uppercase;" value=""
                                   onkeyup="javascript:this.value=this.value.toUpperCase();" >
                        </div>
                </div><br>
 <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
      <tr><strong><center>PARÁMETROS VENTILATORIOS</center></strong>
 </div>
<div class="row">
    <div class="col">
        <label>MODO VENTILATORIO:</label>
        <input type="text" name="vent_m" placeholder="MODO VENTILATORIO" class="form-control" style="text-transform:uppercase;" value=""
         onkeyup="javascript:this.value=this.value.toUpperCase();" >
    </div>
     <div class="col">
        <label>VOLUMEN CORRIENTE:</label>
        <input type="text" name="vol_m" placeholder="VOLUMEN CORRIENTE" class="form-control" style="text-transform:uppercase;" value=""
         onkeyup="javascript:this.value=this.value.toUpperCase();" >
    </div>
     <div class="col">
        <label>FRECUENCIA RESPIRATORIA:</label>
        <input type="number" name="frec_m" placeholder="FRECUENCIA RESPIRATORIA" class="form-control" style="text-transform:uppercase;" value=""
         onkeyup="javascript:this.value=this.value.toUpperCase();" >
    </div>
     <div class="col">
        <label>FIO2:</label>
        <input type="text" name="fio_m" placeholder="FIO2" class="form-control" style="text-transform:uppercase;" value=""
         onkeyup="javascript:this.value=this.value.toUpperCase();" >
    </div>
</div><br>
<div class="row">
    <div class="col">
        <label>PEEP:</label>
        <input type="text" name="peep_m" placeholder="PEEP" class="form-control" style="text-transform:uppercase;" value=""
         onkeyup="javascript:this.value=this.value.toUpperCase();" >
    </div>
     <div class="col">
        <label>PRESIÓN INSPIRATORIA:</label>
        <input type="text" name="presins_m" placeholder="PRESIÓN INSPIRATORIA" class="form-control" style="text-transform:uppercase;" value=""
         onkeyup="javascript:this.value=this.value.toUpperCase();" >
    </div>
     <div class="col">
        <label>PRESIÓN PICO:</label>
        <input type="text" name="prespico_m" placeholder="PRESIÓN PICO" class="form-control" value="" style="text-transform:uppercase;" 
         onkeyup="javascript:this.value=this.value.toUpperCase();" >
    </div>
</div>
<hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                 <tr><strong><center>REGISTRO DE MEDICAMENTOS</center></strong>
</div>
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
    <tr>
      
      <th scope="col"><center>MEDICAMENTO</center></th>
      <th scope="col"><center>DOSIS</center></th>
      <th scope="col"><center>VÍA</center></th>
      <th scope="col"><center>FRECUENCIA</center></th>
      <th scope="col"><center>HORARIO</center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
     
      <td><input type="text" name="medicam_mat" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dosis_mat" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="via_mat" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec_mat" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="horario_mat" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>
    <tr>
 
      <td><input type="text" name="medicam_mat2" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dosis_mat2" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="via_mat2" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec_mat2" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="horario_mat2" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>
    <tr>
      
      <td><input type="text" name="medicam_mat3" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dosis_mat3" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="via_mat3" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec_mat3" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="horario_mat3" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>
     <tr>
      
      <td><input type="text" name="medicam_mat4" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dosis_mat4" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="via_mat4" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec_mat4" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="horario_mat4" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>
     <tr>
  
      <td><input type="text" name="medicam_mat5" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="dosis_mat5" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="via_mat5" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="frec_mat5" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
      <td><input type="text" name="horario_mat5" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
    </tr>

  </tbody>
</table>
</div>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
     <tr><strong><center>INGRESOS</center></strong>
</div>
<div class="container"> 
    <div class="row">
    <div class="col-sm-6">
      TIPO DE DIETA:<input name="diet_m" type="text" class="form-control">
    </div>
   </div> 
  <div class="row">
    <div class="col-sm">VÍA ORAL:
     <div class="row">
  <div class="col"><div class="losInput7"><input name="oral_m" type="text" placeholder="0" class="form-control"></div></div>
</div>
    </div>
    <div class="col-sm">
      VÍA ENTERAL:<div class="losInput7"><input name="ent_m" type="text" placeholder="0" class="form-control"></div>
    </div>
    <div class="col-sm">
      HEMODERIVADOS:<div class="losInput7"><input name="hemo_m" type="text" placeholder="0" class="form-control"></div>
    </div>
    <div class="col-sm">
     VÍA PARENTERAL:<div class="losInput7"><input name="parent_m" type="text" placeholder="0" class="form-control"></div>
    </div>
  </div>
</div><p>
<div class="container"> 
  <div class="row">
    <div class="col-sm">MEDICAMENTOS:
     <div class="row">
  <div class="col"><div class="losInput7"><input type="text" name="med_m" placeholder="0" class="form-control"></div></div>
</div>
    </div>
    <div class="col-sm">
      ESPACIOS EN BLANCO:<div class="losInput7"><input type="text" name="esp_m" placeholder="0" class="form-control"></div>
    </div>
    <div class="col-sm">
      <strong>INGRESO PARCIAL TOTAL:</strong><div class="inputTotal7"><input name="ing_m" placeholder="0" type="text" class="form-control" disabled=""></div>
    </div>    
  </div>
</div>
<hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
     <tr><strong><center>EGRESOS</center></strong>
</div>
<div class="container"> 
  <div class="row">
    <div class="col-sm">DIURESIS:
     <div class="row">
  <div class="col"><div class="losInput8"><input type="text" name="diu_m"placeholder="0" class="form-control"></div></div>
</div>
    </div>
    <div class="col-sm">
      EVACUACIONES:<div class="losInput8"><input type="text" name="eva_m" placeholder="0" class="form-control"></div>
    </div>
    <div class="col-sm">
      SANGRADO:<div class="losInput8"><input type="text" name="sang_m" placeholder="0" class="form-control"></div>
    </div>
    <div class="col-sm">
     VÓMITO:<div class="losInput8"><input name="vom_m" type="text" placeholder="0" class="form-control"></div>
    </div>
  </div>
</div>
<p>
<div class="container"> 
  <div class="row">
    <div class="col-sm"><center>ASPIRACIÓN BOCA / CANULA:</center>
     <div class="row">
  <div class="col"><div class="losInput8"><input type="text" name="aspboc_m" placeholder="0" class="form-control"></div></div>
</div>
    </div>
    <div class="col-sm">
      C GÁSTRICO:<div class="losInput8"><input type="text" name="gast_m" placeholder="0" class="form-control"></div>
    </div>
    <div class="col-sm">
      DRENAJE:<div class="losInput8"><input name="dren_m" type="text" placeholder="0" class="form-control"></div>
    </div>
    <div class="col-sm">
     PERDIDAS INSENSIBLES:<div class="losInput8"><input type="text" placeholder="0" name="perd_m" class="form-control"></div>
    </div>
  </div>
</div>
<p>
<div class="container"> 
  <div class="row">
    <div class="col-sm-3"><center><strong>EGRESO PARCIAL TOTAL:</strong></center>
     <div class="row">
  <div class="col"><div class="inputTotal8"><input type="text" placeholder="0" name="egpar_m" class="form-control" disabled></div></div>
</div>
    </div>   
  </div>
</div>
<hr>
<br>
<div class="row">
    <table class="table table-bordered table-striped" id="mytable">
     <thead class="thead">
    <tr class="table-warning">
      <th colspan="5"><center><h5><strong>ESCALAS DE VALORACIÓN DE RIESGOS DE ÚLCERAS POR PRESIÓN (NORTON)</strong></h5></center></th>
    </tr>
    <tr class="table-active">
      <th scope="col"><center>ESCALA</center></th>
      <th scope="col"><center>PARÁMETRO</center></th>
      <th scope="col"><center>CAL.</center></th>
      <th scope="col"><center>VALOR</center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" class="col-sm-3"><center>ESTADO FÍSICO GENERAL</center></th>
      <td>BUENO: RELLENO CAPILAR RÁPIDO<br>MEDIANO: RELLENO CAPILAR LENTO <br> REGULAR: LIGERO EDEMA<br>MUY MALO: EDEMA GENERALIZADO</td>
      <td><center>4<br>3<br>2<br>1</center></td>

      <td class="col-sm-1"><div class="losInput"><input type="text" name="estfis_m" class="form-control" maxlength="1"onkeypress='return event.charCode >= 49 && event.charCode <= 52'></div></td>
    </tr>
    <tr>
      <th scope="row"><center><br><br><br>ESTADO MENTAL</center></th>
      <td>ALERTA<br>APÁTICO<br>CONFUSO<br>ESTUPUROSO Y COMATOSO</td>
      <td><center>4<br>3<br>2<br>1</center></td>
     <td><br><br><br><div class="losInput"><input type="text" name="estmen_m" class="form-control" maxlength="1"onkeypress='return event.charCode >= 49 && event.charCode <= 52'></div></td>
    </tr>
    <tr>
      <th scope="row"><center><br>ACTIVIDAD</center></th>
      <td>AMBULANTE<br>CAMINA CON AYUDAa<br>SENTADO<br>ENCAMADO</td>
      <td><center>4<br>3<br>2<br>1</center></td>
        <td><br><div class="losInput"><input type="text" name="act_m" class="form-control" maxlength="1"onkeypress='return event.charCode >= 49 && event.charCode <= 52'></div></td>
    </tr>
    <tr>
      <th scope="row"><center>MOVILIDAD</center></th>
      <td>TOTAL<br>DISMINUIDA<br>MUY LIMITADA<br>INMOVIL</td>
      <td><center>4<br>3<br>2<br>1</center></td>
        <td><div class="losInput"><input type="text" name="mov_m" class="form-control" maxlength="1"onkeypress='return event.charCode >= 49 && event.charCode <= 52'></div></td>
    </tr>
    <tr>
      <th scope="row"><center><br>INCONTINENCIA</center></th>
      <td>NINGUNA<br>OCASIONAL<br>URINARIA O FECAL<br>URINARIA Y FECAL</td>
      <td><center>4<br>3<br>2<br>1</center></td>
        <td><br><div class="losInput"><input type="text" name="inc_m" class="form-control" maxlength="1"onkeypress='return event.charCode >= 49 && event.charCode <= 52'></div></td>
    </tr>
     <tr>
      <th colspan="2"></th>
      <th colspan="1"><center><h5><strong>TOTAL:</strong></h5></center></th>
      <th colspan="1"><center> <div class="inputTotal"><input type="text" name="tot_m" class="form-control" disabled></div></center></th>
    </tr>

 <tr>
      <th colspan="1"></th>
      <th colspan="1"><center>CLASIFICACIÓN DEL RIESGO</center></th>
      <th colspan="3"><center><input type="text" name="clasriesg_m" class="form-control"></center></th>
    </tr>

     <tr>
      <th colspan="2"><center>NOMBRE DE ENFERMERA (O) QUE VALORA</center></th>
      <th colspan="3"><center><input type="text" name="nomenf_m" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></center></th>
    </tr>
 <tr class="table-danger">
      <th colspan="5"><center><font size="2">INTERPRETACIÓN: &nbsp; &nbsp; &nbsp; 5-11 PUNTOS: MUY ALTO RIESGO <strong> &nbsp; &nbsp; &nbsp; 12-14 PUNTOS: RIESGO EVIDENTE </strong>&nbsp; &nbsp; &nbsp;MAS DE 14 PUNTOS: RIESGO MINIMO </font></center></th>
    </tr>
  </tbody>
</table>
</div>
<br>
<hr>
<br>
<div class="row">
    <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
    <tr class="table-warning">
      <th colspan="5"><center><h5><strong>ESCALA DE RIESGO DE CAIDAS (I.H. DOWNTON)</strong></h5></center></th>
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

      <td class="col-sm-1"><div class="losInput2"><input type="text" name="caidas_m" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 49'></div></td>
    </tr>
    <tr>
      <th scope="row"><center><br><br><br>MEDICAMENTOS</center></th>
      <td>NINGUNO<br>TRANQUILIZANTES-SEDANTE<br>DIURÉTICOS<br>HIPOTENSORES(NO DIURÉTICOS)<br>ANTIPARKSONIANOS<br>ANTIDEPRESIVOS<br>OTROS MEDICAMENTOS</td>
      <td><center>0<br>1<br>2<br>3<br>4<br>5<br>6</center></td>
     <td><br><br><br><div class="losInput2"><input type="text" name="medi_m" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 54'></div></td>
    </tr>
    <tr>
      <th scope="row"><center><br>DÉFICITS SENSORIALES</center></th>
      <td>NINGUNO<br>ALTERACIONES VISUALES<br>ALTERACIONES AUDITIVAS<br>EXTREMIDADES (ICTUS..)</td>
      <td><center>0<br>1<br>2<br>3</center></td>
        <td><br><div class="losInput2"><input type="text" name="defic_m" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 51'></div></td>
    </tr>
    <tr>
      <th scope="row"><center>ESTADO MENTAL</center></th>
      <td>ORIENTADO<br>CONFUSO</td>
      <td><center>0<br>1</center></td>
        <td><div class="losInput2"><input type="text" name="estement_m" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 49'></div></td>
    </tr>
    <tr>
      <th scope="row"><center><br>DEAMBULACIÓN</center></th>
      <td>NORMAL<br>SEGURA CON AYUDA<br>INSEGURA CON AYUDA / SIN AYUDA<br>IMPOSIBLE</td>
      <td><center>0<br>1<br>2<br>3</center></td>
        <td><br><div class="losInput2"><input type="text" name="deamb_m" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 51'></div></td>
    </tr>
     <tr>
      <th colspan="2"></th>
      <th colspan="1"><center><h5><strong>TOTAL:</strong></h5></center></th>
      <th colspan="1"><center> <div class="inputTotal2"><input type="text" name="total_m" class="form-control" disabled></div></center></th>
    </tr>

 <tr>
      <th colspan="1"></th>
      <th colspan="1"><center>CLASIFICACIÓN DEL RIESGO</center></th>
      <th colspan="3"><center><input type="text" name="classresg_m" class="form-control"></center></th>
    </tr>

     <tr>
      <th colspan="2"><center>NOMBRE DE ENFERMERA (O) QUE VALORA</center></th>
      <th colspan="3"><center><input type="text" name="nom_enf_m" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></center></th>
    </tr>

     <tr>
    <th colspan="2"><center>INTERVENCIONES / RECOMENDACIONES PARA PREVENCIÓN DE RIESGO DE CAÍDA</center></th>
    <th colspan="3"><center><input type="text" name="interv_m" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></center></th>
    </tr>
 <tr class="table-danger">
      <th colspan="5"><center><font size="2">INTERPRETACIÓN: TODOS LOS PACIENTES CON <strong>3 O MÁS </strong>PUNTOS EN ESTA CALIFICACIÓN SE CONSIDERAN DE <strong>ALTO RIESGO PARA CAIDA</strong></font></center></th>
    </tr>
  </tbody>
</table>
</div>
<div class="row">
    <center><strong>NOTAS DE CUIDADOS DE ENFERMERÍA</strong></center><br>
    <textarea placeholder="NOTAS DE ENFERMERÍA" class="form-control" name="cuidenf" rows="5" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
</div> 

<hr>
<br><br>

  <div class="form-group col-12">
<center><button type="submit" class="btn btn-primary">FIRMAR</button>
<button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button></center>
</div>
</form>
<!--TERMINO MATUTINO-->

</div>
</form>
<?php } ?>
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
        function mostrar3(value)
        {
            if(value=="AGREGAR3" || value==true)
            {
                // habilitamos
                document.getElementById('contenido3').style.display = 'block';
            }else if(value=="DISMINUIR3" || value==false){
                // deshabilitamos
                document.getElementById('contenido3').style.display = 'none';
            }
        }

        $('.losInput7 input').on('change', function(){
  var total = 0;
  $('.losInput7 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal7 input').val(total.toFixed());
});


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


                $('.losInput9 input').on('change', function(){
  var total = 0;
  $('.losInput9 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal9 input').val(total.toFixed());
});


                        $('.losInput10 input').on('change', function(){
  var total = 0;
  $('.losInput10 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal10 input').val(total.toFixed());
});

   $('.losInput11 input').on('change', function(){
  var total = 0;
  $('.losInput11 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal11 input').val(total.toFixed());
});

        $('.losInput12 input').on('change', function(){
  var total = 0;
  $('.losInput12 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal12 input').val(total.toFixed());
});

        $('.losInput input').on('change', function(){
  var total = 0;
  $('.losInput input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal input').val(total.toFixed());
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

         $('.losInput3 input').on('change', function(){
  var total = 0;
  $('.losInput3 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal3 input').val(total.toFixed());
});

          $('.losInput4 input').on('change', function(){
  var total = 0;
  $('.losInput4 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal4 input').val(total.toFixed());
});

 $('.losInput5 input').on('change', function(){
  var total = 0;
  $('.losInput5 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal5 input').val(total.toFixed());
});

  $('.losInput6 input').on('change', function(){
  var total = 0;
  $('.losInput6 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal6 input').val(total.toFixed());
});
    </script>

      <script type="text/javascript">
  

$('.losInputTAM input').on('change', function(){
  var total = 0;
  var sist, diast, tam;
  var string = "mmHG";
   sist=document.getElementById("sist").value;
   diast=document.getElementById("diast").value;
   $('.losInputTAM input').each(function() {
    if($( this ).val() != "")
    {
   //parseInt(total= (sist+diast)); 
   total = total + parseInt($( this ).val()) /2;
    }
  });
  $('.inputTotalTAM input').val(total.toFixed(0)+ " " +string );

});

$('.losInputTAM2 input').on('change', function(){
  var total = 0;
  var sist, diast, tam;
  var string = "mmHG";
   sist=document.getElementById("sist").value;
   diast=document.getElementById("diast").value;
   $('.losInputTAM2 input').each(function() {
    if($( this ).val() != "")
    {
   //parseInt(total= (sist+diast)); 
   total = total + parseInt($( this ).val()) /2;
    }
  });
  $('.inputTotalTAM2 input').val(total.toFixed(0)+ " " +string );

});


$('.losInputTAM3 input').on('change', function(){
  var total = 0;
  var sist, diast, tam;
  var string = "mmHG";
   sist=document.getElementById("sist").value;
   diast=document.getElementById("diast").value;
   $('.losInputTAM3 input').each(function() {
    if($( this ).val() != "")
    {
   //parseInt(total= (sist+diast)); 
   total = total + parseInt($( this ).val()) /2;
    }
  });
  $('.inputTotalTAM3 input').val(total.toFixed(0)+ " " +string );

});

</script>

</body>

</html>