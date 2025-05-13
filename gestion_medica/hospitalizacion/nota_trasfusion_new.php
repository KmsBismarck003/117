<?php
session_start();
include "../../conexionbd.php";
include("../header_medico.php");
 
if (isset($_SESSION['hospital'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
    $resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp  WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);
    if (mysqli_num_rows($resultado) > 0) { //se mostrara si existe mas de 1
        $f = mysqli_fetch_row($resultado);

    } else {
        header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
    }
}

$usuario = $_SESSION['login'];
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

    <title>BANCO DE SANGRE </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>NOTA DE TRANSFUCIÓN</center></strong>
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

      function calculaedad($fechanacimiento)
{
  list($ano, $mes, $dia) = explode("-", $fechanacimiento);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($ano_diferencia > 0 )
      return ($ano_diferencia . ' AÑOS');
  else if ($mes_diferencia > 0 || $ano_diferencia < 0)
      return ($mes_diferencia . ' MESES');
   else if ($dia_diferencia > 0 || $mes_diferencia < 0 || $ano_diferencia < 0)
      return ($dia_diferencia . ' DÍAS');
}

      $edad = calculaedad($pac_fecnac);

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
<?php $sql_edo = "SELECT * from signos_vitales where id_atencion=$id_atencion ORDER by id_sig ASC LIMIT 1";
$result_edo = $conexion->query($sql_edo);
while ($row_edo = $result_edo->fetch_assoc()) {
  $peso=$row_edo['peso'];
  $talla=$row_edo['talla'];
} ?>
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
 
 <div class="container">  <!--INICIO -->

<form action="insert_tras_new.php" method="POST">

<div class="container">
  <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>PRE-TRANSFUSIONAL</strong></center><p>
</div>
  <div class="row">
    <div class="col-sm">
        <div class="form-group">
           <label>FECHA DE TRANSFUSIÓN:</label><br>
           <input type="date" name="fec_tras" class="form-control">
        </div>
    </div>
    <div class="col-sm">
        <div class="form-group">
           <label>NÚMERO DE UNIDADES:</label><br>
           <input type="number" name="num_tras" placeholder="NUMERO DE UNIDADES" class="form-control">
        </div>
    </div>
    <div class="col-sm">
        <div class="form-group">
           <label>CONTENIDO (CANTIDAD):</label><br>
           <input type="text" name="cont_tras" placeholder="CONTENIDO (CANTIDAD)" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
        </div>
    </div>


        <div class="col-sm-3">
          <div class="form-group">
             <label>FOLIO:</label><br>
             <input type="text" name="fol_tras" placeholder="FOLIO" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
          </div>
        </div>
    </div><hr>
    <div class="row">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>COMPONENTE SANGUINEO</strong></center><p>
</div>
          </div>
        </div>
        <div class="row">
         <div class="col-sm-4">
          <label>PAQUETE GLOBULAR:</label><br>
          <input type="radio" name="comp_sang" value="PAQUETE GLOBULAR" placeholder="PAQUETE GLOBULAR"  >
         </div>
         <div class="col-sm-4">
          <label>PLASMA:</label><br>
          <input type="radio" name="comp_sang" value="PLASMA" placeholder="PLASMA"  >
         </div>
         <div class="col-sm-4">
          <label>CRIOPRECIPITADO:</label><br>
          <input type="radio" name="comp_sang" value="CRIOPRECIPITADO" placeholder="CRIOPRECIPITADO"  >
         </div>
       </div><hr>
        </div>
    </div>
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label>HOMOGLOBINA:</label>
        <input type="cm-number" name="hb_tras" placeholder="HB" class="form-control" >
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label>HEMATOCRITO:</label>
        <input type="cm-number" name="hto_tras" placeholder="HTO" class="form-control" >
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label>GRUPO SANGUINEO:</label>
        <input type="text" name="san_tras" placeholder="GRUPO SANGUINEO" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
      </div>
    </div>
  </div><hr>
 <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
 <div class="container"> 
   <div class="row">
    <div class="col-sm-4">
      <center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="text" name="sisto_pre" class="form-control" value=""></div> /
  <div class="col"><input type="text" name="diasto_pre" class="form-control" value=""></div>
 
</div>
    </div>
    <div class="col-sm-4">
      FRECUENCIA CARDIACA:<input type="text" name="fc_pre" class="form-control" value="">
    </div>
   <!-- <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" name="fr_tras" class="form-control" value="">
    </div>-->
    <div class="col-sm-4">
     TEMPERATURA:<input type="text" name="temp_pre" class="form-control" value="">
    </div>
   <!-- <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="text" name="sat_tras"  class="form-control" value="">
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" name="peso_tras" class="form-control" value="" >
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" name="talla_tras" class="form-control" value="" >
    </div>-->
  </div>
</div>
  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label>HORA DE INICIO</label><br>
        <input type="time" name="inicio_tras" class="form-control">
      </div>
    </div>
  </div>
    <div class="row">
    <div class="col">
      <div class="form-group">
        <div class="form-group">
        <label>NOMBRE COMPLETO DEL MEDICO QUE INDICA LA TRANSFUSIÓN :</label><br>
        <input type="text" name="med_tras" placeholder="MEDICO QUE INDICA LA TRASFUSIÓN" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
      </div>
      </div>
    </div>
  </div>
    <div class="row">
    <div class="col">
      <div class="form-group">
        <label>NOMBRE COMPLETO DE QUIEN REALIZA LA TRANSFUSIÓN :</label><br>
        <input type="text" name="medi_tras" placeholder="MEDICO QUE REALIZÓ LA TRASFUSIÓN" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
      </div>
    </div>
  </div>
    <div class="row">
    <div class="col">
      <div class="form-group">
        <br>ESTADO GENERAL DEL PACIENTE:<textarea class="form-control" rows="3" value="" name="edo_tras" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
      </div>
    </div><br>
  </div><hr>
  <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>TRANSFUSIONAL</strong></center><p>
</div>
 
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
                <div class="container"> 
  <div class="row">
    <div class="col-sm-4">
      <center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="text" name="sisto_tras" class="form-control" value=""></div> /
  <div class="col"><input type="text" name="diasto_tras" class="form-control" value=""></div>
 
</div>
    </div>
    <div class="col-sm-4">
      FRECUENCIA CARDIACA:<input type="text" name="fc_tras" class="form-control" value="">
    </div>
   <!-- <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" name="fr_tras" class="form-control" value="">
    </div>-->
    <div class="col-sm-4">
     TEMPERATURA:<input type="text" name="temp_tras" class="form-control" value="">
    </div>
   <!-- <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="text" name="sat_tras"  class="form-control" value="">
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" name="peso_tras" class="form-control" value="" >
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" name="talla_tras" class="form-control" value="" >
    </div>-->
  </div>
</div><hr>
    <div class="row">
    <div class="col">
      <div class="form-group">
        <br>EVOLUCIÓN :<textarea class="form-control" rows="3" type="text" placeholder="EVOLUCIÓN" name="ev_tras" class="form-control" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" ></textarea>


      </div>
    </div>
  </div>
    <div class="row">
    <div class="col">
      <div class="form-group">
        <br>COMPLICACIONES :<textarea type="text" placeholder="COMPLICACIONES" name="com_tras" class="form-control" value="" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" ></textarea>
      </div>

      
    </div>
  </div><hr>

   <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>POST-TRANSFUSIONAL</strong></center><p>
</div>
 
 <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
              
  <div class="row">
    <div class="col-sm-4"><br><center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" name="p_sistol" ></div> /
  <div class="col"><input type="text" class="form-control" name="p_diastol"></div>
 
</div>
    </div>
    <div class="col-sm-4">
     <br> FRECUENCIA CARDIACA:<input type="text" class="form-control" name="fcard">
    </div>
   <!-- <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" class="form-control" name="fresp">
    </div>-->
    <div class="col-sm-4">
     <br>TEMPERATURA:<input type="text" class="form-control"  name="temper">
    </div>
   <!-- <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="text"  class="form-control" name="satoxi">
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" class="form-control"  name="peso">
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" class="form-control" name="talla" >
    </div>-->
  </div>
<hr>
    <div class="row">
    <div class="col">
      <div class="form-group">
        <br>VOLUMEN TRANSFUNDIDO:<input type="text" class="form-control" value="" name="vol_tras" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <br>HORA DE TERMINO:<input type="time" class="form-control" value="" name="fin_tras" >
      </div>
    </div>
    
  </div>  
  <div class="row">
    <div class="col">
      <div class="form-group">
       
        <br>EVOLUCIÓN :<textarea class="form-control" rows="3" type="text" placeholder="EVOLUCIÓN" name="ev_traspost" class="form-control" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" ></textarea>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="form-group">
        <br>COMPLICACIONES :<textarea type="text" placeholder="COMPLICACIONES POST-TRANSFUSIONALES" name="com_traspost" class="form-control" value="" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" >
          </textarea> 

       
      </div>
    </div>
  </div>
 
  
  <div class="row">
    <div class="col">
      <div class="form-group">
        <br>OBSERVACIONES:<textarea class="form-control" value="" rows="3" name="ob_tras" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea> 
      </div>
    </div>
  </div>
</div>
<hr>
<div class="container">
  <div class="row">
    <div class="col-sm">  
    <p style = "font-family:arial;">
       <strong>RECOMENDACIONES :</strong><br>
       1.-EL SERVICIO CLINICO DEBERA MANTENER LA UNIDAD EN TEMPERATURAS Y CONDICIONES ADECUADAS QUE ASEGUREN SU VIABILIDAD.<br>
       2.-ANTES DE CADA TRANSFUSIÓN DEBERA VERIFICARSE LA IDENTIDAD DEL RECEPTOR Y DE LA UNIDAD DESIGNADA PARA ESTE.<br>
       3.-NO SE DEBERA AGREGAR A LA UNIDAD NINGUN MEDICAMENTO O SOLUCIÓN, INCLUSO LAS DESTINADAS PARA USO INTRAVENOSO, CON EXCEPCIÓN DE SOLUCIÓN SALINA AL 0.9% CUANDO ASI SEA NECESARIO.<br>
       4.-LA TRANSFUSIÓN DE CADA UNIDAD NO DEBERA EXCEDER DE 4 HORAS.<br>
       5.-LOS FILTROS DEBERÁN CAMBIARSE CADA 6 HRS. O CUANDO HUBIESEN TRANSFUNDIDO 4 UNIDADES.<br>
       6.-DE PRESENTARSE UNA REACCIÓN TRANSFUCIONAL,SUSPENDER INMEDIATAMENTE LA TRANSFUCIÓN, NOTIFICAR AL MEDICO ENCARGADO Y REPORTAR AL BANCO DE SANGRE, SIGUIENDO LAS INSTRUCCIONES SEÑALADAS EN EL FORMATO DE REPORTE QUE ACOMPAÑA A LA UNIDAD.<br>
       7.-EN CASO DE NO TRANSFUNDIR LA UNIDAD, REGRESARLA AL BANCO DE SANGRE O SERVICIO DE TRANSFUSIÓN PREFERENTEMENTE ANTES DE TRANSCURRIDAS 2 HORAS A PARTIR DE QUE LA UNIDAD SALIO DEL BANCO DE SANGRE O DEL SERVICIO DE TRANSFUSIÓN.  
    </p>  
    </div>
  </div> 
</div>

</div>


<hr>


<center>
                       <div class="form-group col-6">
                            <button type="submit" class="btn btn-primary">FIRMAR</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button>
                        </div>
</center>
                        <br>
                        </form>
</div> <!--TERMINO DE div container-->
                  
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



</body>
</html>