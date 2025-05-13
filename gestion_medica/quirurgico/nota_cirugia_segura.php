<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");


?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>
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


    <title>NOTA CIRUGIA SEGURA </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>NOTA CIRUGIA SEGURA (LISTADO DE VERIFICACIÓN DE SEGURIDAD QUIRÚRGICA)</center></strong>
</div>
                <hr>
<?php

    include "../../conexionbd.php";

    if (isset($_SESSION['hospital'])) {
      $id_atencion = $_SESSION['hospital'];

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


    ?>
 <font size="2">
         
  <div class="row">
    <div class="col-sm-2">
      EXPEDIENTE: <strong><?php echo $id_exp?> </strong>
    </div>
    <div class="col-sm-6">
     PACIENTE: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm-4">
      FECHA DE INGRESO: <strong><?php echo date_format($date, "d-m-Y H:i:s") ?></strong>
    </div>
  </div>
</font>
 <font size="2">
     
  <div class="row">
    <div class="col-sm-4">
       <?php $date1 = date_create($pac_fecnac);
   ?>
    <!-- INICIO DE FUNCION DE CALCULAR EDAD -->
<?php 

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
               
                    $dias_mes_anterior=28; break;
                
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

function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}

 ?>
 <!-- TERMINO DE FUNCION DE CALCULAR EDAD -->
      FECHA DE  NACIMIENTO: <strong><?php echo date_format($date1, "d-m-Y") ?></strong>
    </div>
    <div class="col-sm-4">
      EDAD: <strong><?php if($anos > "0" ){
   echo $anos." AÑOS";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." MESES";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." DIAS";
}
?></strong>
    </div>
    
   
      <div class="col-sm-2">
      HABITACIÓN: <strong><?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);                                                                                    while ($row_hab = $result_hab->fetch_assoc()) {
  echo $row_hab['num_cama'];
} ?></strong>
    </div>
    
  </div>

</font>
 <font size="2">
  <div class="row">
     <div class="col-sm-8">
      DIAGNÓSTICO MÉDICO: <strong><?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
$result_mot = $conexion->query($sql_mot);                                                                                    while ($row_mot = $result_mot->fetch_assoc()) {
  echo $row_mot['motivo_atn'];
} ?></strong>
    </div>
    <div class="col-sm">
      TIEMPO ESTANCIA: <strong><?php echo $estancia ?> Dias</strong>
    </div>
  </div>

</font>
 <font size="2">
  <div class="row">
    <div class="col-sm-4">
      ALERGIAS: <strong><?php echo $alergias ?></strong>
    </div>
     <div class="col-sm-4">
      ESTADO DE SALUD: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud ASC LIMIT 1";
$result_edo = $conexion->query($sql_edo);while ($row_edo = $result_edo->fetch_assoc()) {
  echo $row_edo['edo_salud'];
} ?></strong>
    </div>
    <div class="col-sm-3">
      TIPO DE SANGRE: <strong><?php echo $pac_tip_sang ?></strong>
    </div>
  </div>
</font>
<?php $sql_edo = "SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_edo = $conexion->query($sql_edo);
while ($row_edo = $result_edo->fetch_assoc()) {
  $peso=$row_edo['peso'];
  $talla=$row_edo['talla'];
} 
if (!isset($peso)){
    $peso=0;
    $talla=0;
}?>
 <font size="2">
  <div class="row">
     <div class="col-sm-4">
      PESO: <strong><?php echo $peso ?></strong>
    </div>
    <div class="col-sm-3">
      TALLA: <strong><?php echo $talla ?></strong>
    </div>
  </div>
</font>
<hr>
</div>
        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
      }
        ?>
  
      <div class="container">  <!--INICIO DE CONSULTA DE URGENCIAS-->


<form action="insertar_cir_seg.php" method="POST">
               
 

<div class="container">
  <div class="row">
    <div class="col-sm">
     <!--INICIO DE CARD-->
<div class="card" style="width: 19rem;">
  <div class="card-body">
    <center><h6 class="card-title"><strong>ANTES DE LA ADMINISTRACIÓN DE LA ANESTESIA</strong></h6></center><hr>
    <h7 class="card-subtitle text-muted"><strong>ENTRADA</strong> (ENFERMERA Y ANESTESIÓLOGO)</h7><hr>
     <div class="form-check">
  <input class="form-check-input" type="radio" id="URGENCIAS" value="SI" name="entrada_pac_confirm">
  <label class="form-check-label" for="URGENCIAS">
    EL PACIENTE HA CONFIRMADO:
    <ul>
  <li>SU IDENTIDAD</li>
  <li>LOCALIZACIÓN QUIRÚRGICA</li>
  <li>LA OPERACIÓN</li>
  <li>CONSENTIMIENTO INFORMADO</li>
    <ul>
  </label>
</div>
<hr>
<div class="container">
  <div class="row">
    
      <div class="form-check">
  <input class="form-check-input" type="radio" id="lugar" value="LUGAR DEL CUERPO MARCADO" name="lug_noproc">
  <label class="form-check-label" for="lugar">
   LUGAR DEL CUERPO MARCADO
  </label>
</div>
 
    
       <div class="form-check">
  <input class="form-check-input" type="radio" id="noprocede" value="NO PROCEDE" name="lug_noproc">
  <label class="form-check-label" for="noprocede">
    NO PROCEDE
  </label>
</div>
    
    </div>
  </div>
  <hr>
   <div class="form-check">
  <input class="form-check-input" type="radio" id="verificado" value="SI" name="verificado">
  <label class="form-check-label" for="verificado">
    VERIFICADO EQUIPO Y MEDICACIÓN DE LA ANESTESIA
  </label>
</div>
<hr>
 <div class="form-check">
  <input class="form-check-input" type="radio" id="pulsioximetro" value="SI" name="pulsioximetro">
  <label class="form-check-label" for="pulsioximetro">
   PULSIOXIMETRO FUNCIONANDO EN EL PACIENTE
  </label>
</div>
<hr>
 <div class="form-check">
  <input class="form-check-input" type="radio" id="ver_inst" value="SI" name="ver_inst">
  <label class="form-check-label" for="ver_insepro">
   VERIFICADO INSTRUMENTAL/EQUIPO QUIRÚRGICO/PROTÉSIS
  </label>
</div>
   <hr>
    <strong>¿TIENE EL PACIENTE?</strong><br>
    <p>¿ALERGIAS CONOCIDAS?</p>
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="aler_conno" value="NO" name="alerg_con">
  <label class="form-check-label" for="aler_conno">
 NO
  </label>
</div>
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="aler_consi" value="SI" name="alerg_con">
  <label class="form-check-label" for="aler_consi">
   SI
  </label>
</div>
    </div>
  </div>
  <hr>
    <p><strong>¿PROFILAXIS ANTIBIÓTICA EN LOS ÚLTIMOS 60 MINUTOS?</strong></p>
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="profisi" value="SI" name="profilaxis">
  <label class="form-check-label" for="profisi">
 SI
  </label>
</div>
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="profino" value="NO PROCEDE" name="profilaxis">
  <label class="form-check-label" for="profino">
   NO PROCEDE
  </label>
</div>
    </div>
  </div>
  <hr>
    <p><strong>¿DIFICULTAD EN LA VÍA AÉREA/RIESGO DE ASPIRACIÓN?</strong></p>
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="difviano" value="NO" name="dif_via_aerea">
  <label class="form-check-label" for="difviano">
 NO
  </label>
</div>
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="difviasi" value="SI" name="dif_via_aerea">
  <label class="form-check-label" for="difviasi">
   SI, Y EL EQUIPO Y LA ASISTENCIA ESTÁN DISPONIBLES
  </label>
</div>
    </div>
  </div>
<hr>
   <p><strong>¿PUEDE PRECISAR DE CONCENTRACIÓN DE HEMATÍES? ¿MENOS DE 500 ML DE SANGRE (7ML/KG EN NIÑOS)?</strong></p>
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="hematiesno" value="NO" name="con_hematies">
  <label class="form-check-label" for="hematiesno">
 NO
  </label>
</div>
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="hematiessi" value="SI" name="con_hematies">
  <label class="form-check-label" for="hematiessi">
   SI, Y DISPONE DE UNA VÍA DE ACCESO IV ADECUADA/FLUIDOS NECESARIOS.
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
<div class="card" style="width: 19rem;">
  <div class="card-body">
    <h6 class="card-title"><strong>ANTES DE LA INSICIÓN EN LA PIEL</strong></h6><hr>
    <h7 class="card-subtitle mb-2 text-muted"><strong>PAUSA</strong> (Enfermera, Anestesiologo y Cirujano)</h7><hr>
   
      <div class="form-check">
  <input class="form-check-input" type="radio" id="confmp" value="SI" name="confirm_presentes">
  <label class="form-check-label" for="confmp">
   CONFIRMADO QUE TODOS LO MIEMBROS DEL EQUIPO ESTÁN PRESENTES Y PREPARADOS.
  </label>
</div>
<hr>
 <div class="form-check">
  <input class="form-check-input" type="radio" id="ciranes" value="SI" name="confirm_verb">
  <label class="form-check-label" for="ciranes">
    CIRUJANO, ANESTESIOLÓGO Y ENFERMERA HAN CONFIRMADO VERBALMENTE:
    <ul>
  <li>PACIENTE</li>
  <li>SITIO QUIRÚRGICO</li>
  <li>PROCEDIMIENTO</li>
  <li>POSICIÓN</li>
   <li>SONDAJE</li>
    <ul>
  </label>
</div>
<hr>
<strong><p>ANTICIPACIÓN DE SUCESOS CRITICOS</p></strong>
  <div class="form-check">
  <input class="form-check-input" type="radio" id="cirresi" value="SI" name="cir_rep">
  <label class="form-check-label" for="cirresi">
  CIRUJANO REPASA: ¿CUALES SON LOS PASOS CRÍTICOS O INESPERADOS, LA DURACIÓN DE LA INTERVENCIÓN, LA PÉRDIDA DE SANGRE ESPERADA?
  </label>
</div>
<hr>
     <div class="form-check">
  <input class="form-check-input" type="radio" id="anesresi" value="SI" name="anest_resp">
  <label class="form-check-label" for="anesresi">
  ANESTESIÓLOGO REPASA: ¿PRESENTA EL PACIENTE ALGUNA PECULIARIDAD QUE SUSCITE PREOCUPACIÓN?
  </label>
</div>
<hr>
 <div class="form-check">
  <input class="form-check-input" type="radio" id="enfresi" value="SI" name="enf_rep">
  <label class="form-check-label" for="enfresi">
  EL EQUIPO DE ENFERMERIA REVISA: SI SE HA CONFIRMADO LA ESTERILIDAD(CON RESULTADOS DE LOS INDICADORES) Y SI EXISTEM DUDAS O PROBLEMAS RELACIONADOS CON EL INSTRUMENTAL Y LOS EQUIPOS
  </label>
</div>
<hr>

<p><strong>¿SE MUESTRAN LAS IMÁGENES DIAGNOSTICAS ESENCIALES?</strong></p>
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="diag_esesi" value="SI" name="img_diag">
  <label class="form-check-label" for="diag_esesi">
 SI
  </label>
</div>
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="diag_eseno" value="NO PROCEDE" name="img_diag">
  <label class="form-check-label" for="diag_eseno">
  NO PROCEDE
  </label>
</div>
    </div>
  </div>
<hr>
  <div class="form-group">
    <label for="exampleFormControlInput1">PROCEDIMIENTO:</label>
    <input type="text" class="form-control" id="exampleFormControlInput1" value="" placeholder="Procedimiento" name="proced">
  </div><div class="form-group">
                        <label for="dieta"><strong>ESPECIALIDAD:</strong></label>
                        <select class="form-control" name="especialidad" required id="dieta">
                                 <option value="">SELECCIONAR ESPECIALIDAD</option>
                            <option value="NINGUNO">NINGUNO</option>
                            <?php
                            $sql_d = "SELECT * FROM cat_espec WHERE espec_activo='SI'";
                            $result_d = $conexion->query($sql_d);
                            while ($row_d = $result_d->fetch_assoc()) {
                                echo "<option value='" . $row_d['espec'] . "'>" . $row_d['espec'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
  
                    
    <div class="form-group">
    <label for="exampleFormControlInput1">FECHA:</label>
    <input type="datetime-local" class="form-control" id="exampleFormControlInput1" value="" name="fecha" >
  </div>
  </div>
</div>
      <!--TERMINO DE SEGUNDA CAR-->

    </div>
    <div class="col-sm">
     <!--INICIO DE TERCER CAR-->
<div class="card" style="width: 19rem;">
  <div class="card-body">
    <h6 class="card-title"><strong>ANTES DE QUE EL PACIENTE ABANDONE EL QUIROFANO</strong></h6><hr>
    <h7 class="card-subtitle mb-2 text-muted"><strong>SALIDA</strong> (ENFERMERA, ANESTESIOLOGO Y CIRUJANO)</h7><hr>
   <div class="form-check">
  <input class="form-check-input" type="radio" id="enfconsi" value="SI" name="enf_confirm">
  <label class="form-check-label" for="enfconsi">
  LA ENFERMERA CONFIRMA VERBALMENTE CON EL EQUIPO REGISTRADO EL NOMBRE DEL PROCEDIMIENTO
  </label>
</div><hr>
<div class="form-check">
  <input class="form-check-input" type="radio" id="concomsi" value="SI" name="cont_comp_inst">
  <label class="form-check-label" for="concomsi">
CONTAJE DE COMPRESAS, AGUJAS E INSTRUMENTAL CORRECTO
  </label>
</div><hr>
<div class="container">
  <div class="row">
   <div class="form-check">
  <input class="form-check-input" type="radio" id="idegessi" value="SI" name="ident_gest">
  <label class="form-check-label" for="idegessi">
IDENTIFICACIÓN Y GESTIÓN DE LAS MUESTRAS BIÓLOGICAS (NOMBRE, NO, HO, FECHA DE NACIMIENTO)
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" id="idegesno" value="NO PROCEDE" name="ident_gest">
  <label class="form-check-label" for="idegesno">
NO PROCEDE
  </label>
</div> 
   
  </div>
</div>
<hr>
<p><strong>¿HAY ALGÚN PROBLEMA EN RELACIÓN CON EL MATERIAL O LOS EQUIPOS?</strong></p>
  <div class="row">
    <div class="col-sm">
   <div class="form-check">
  <input class="form-check-input" type="radio" id="probmatsi" value="SI" name="problema">
  <label class="form-check-label" for="probmatsi">
SI
  </label>
</div> 
    </div>
    <div class="col-sm-9">
     <div class="form-check">
  <input class="form-check-input" type="radio" id="probmatno" value="NO" name="problema">
  <label class="form-check-label" for="probmatno">
NO
  </label>
</div> 
    </div>
  </div>

<hr>
<div class="form-check">
  <input class="form-check-input" type="radio" id="ciranessi" value="SI" name="rev_cir_enf_anest">
  <label class="form-check-label" for="ciranessi">
CIRUJANO, ANESTESIÓLOGO Y ENFERMERA REVISARON LAS PREOCUPACIONES CLAVES EN LA RECUPERACIÓN Y ATENCIÓN DEL PACIENTE.
  </label>
</div> 
<hr>

<p><strong>¿NECESITA PROFILAXIS TROMBOEMBÓLICA?</strong></p>
  <div class="row">
    <div class="col-sm">
    <div class="form-check">
  <input class="form-check-input" type="radio" id="probmatno" value="SI" name="prof_trombo">
  <label class="form-check-label" for="probmatno">
SI
  </label>
</div> 
    </div>
    <div class="col-sm-9">
      <div class="form-check">
  <input class="form-check-input" type="radio" id="probmatno" value="NO" name="prof_trombo">
  <label class="form-check-label" for="probmatno">
 NO
  </label>
</div> 
    </div>
  </div>
  <hr>
<div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>ETIQUETA IDENTIFICATIVA DEL PACIENTE</strong></label>

    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="ident_pac" placeholder="Etiqueta identificativa del paciente" style="text-transform:uppercase;"></textarea>
  </div>
    <div class="form-group">
    <label for="exampleFormControlInput1">CIRUJANO</label>
    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="NOMBRE" value="" name="fir_cir">
  </div>
    <div class="form-group">
    <label for="exampleFormControlInput1">ANESTESIÓLOGO</label>
    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="NOMBRE" value="" name="fir_anest">
  </div>
    <div class="form-group">
    <label for="exampleFormControlInput1">ENFERMERA</label>
    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="NOMBRE" value="" name="fir_enf">
  </div>
    
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


                      
                         
  
   

</div>

</div>

</div>

<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>

<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

<script>
    document.oncontextmenu = function () {
        return false;
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>


</body>
</html>