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


    <title>DATOS NURGEN </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                
<div class="thead" style="background-color: #0c675e; color: white; font-size: 24px;">
<strong><center>NOTA DE EVOLUCIÓN</center></strong>
</div>
                <hr>
<?php

    include "../../conexionbd.php";

    if (isset($_GET['id_atencion'])) {
      $id_atencion = $_GET['id_atencion'];

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
   <a href="nueva_receta_hosp.php?id_atencion=<?php echo $id_atencion?>"><button type="button" class="btn btn-danger">NUEVA CONSULTA EXTERNA</button></a>
</font>
<hr>
</div>
        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
      }
        ?>
        </div>

<div class="tab-content" id="nav-tabContent">
   <!--INICIO DE NOTA DE EVOLUCION-->
<div class="tab-pane fade show active" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
          <form action="insertar_nota_evolucion.php" method="POST">

                    
                        <!--<strong>No. Admisión:</strong>-->
                        <input type="hidden" name="id_atencion" class="form-control" value="<?php echo $_SESSION['hospital'] ?>"
                               readonly placeholder="No. De expediente">
                 

 <?php 

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=$id_atencion ORDER by id_sig DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
      $atencion=$f5['id_sig'];
    }
    ?>
    <?php
if (isset($atencion)) {
                        ?>
<?php 

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=$id_atencion ORDER by id_sig DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
     
    
    ?>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
                <div class="container"> 
  <div class="row">
    
      
    
    <div class="col-sm-3"><br><center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="number" class="form-control" value="<?php echo $f5['p_sistol'];?>" disabled></div> /
  <div class="col"><input type="number" class="form-control" value="<?php echo $f5['p_diastol'];?>" disabled></div>
 
</div>
    </div>
    <div class="col-sm">
      FRECUENCIA CARDIACA:<input type="number" class="form-control" value="<?php echo $f5['fcard'];?>" disabled>
    </div>
    <div class="col-sm">
      FRECUENCIA RESPIRATORIA:<input type="number" class="form-control" value="<?php echo $f5['fresp'];?>" disabled>
    </div>
    <div class="col-sm">
     <br>TEMPERATURA:<input type="cm-number" class="form-control" value="<?php echo $f5['temper'];?>" disabled>
    </div>
    <div class="col-sm">
     SATURACIÓN OXÍGENO:<input type="number"  class="form-control" value="<?php echo $f5['satoxi'];?>" disabled>
    </div>
    <div class="col-sm-1">
     PESO KILOS:<input type="cm-number" class="form-control" value="<?php echo $f5['peso'];?>" disabled>
    </div>
    <div class="col-sm-1">
     TALLA METROS:<input type="cm-number" class="form-control" value="<?php echo $f5['talla'];?>" disabled>
    </div>
  </div>
</div>
<?php }
?>
<?php 
}else{
                        
  ?>
  <div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
                <div class="container"> 
  <div class="row">
    <div class="col-sm-3"><br><center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="number" class="form-control" name="p_sistol" ></div> /
  <div class="col"><input type="number" class="form-control" name="p_diastol"></div>
 
</div>
    </div>
    <div class="col-sm">
      FRECUENCIA CARDIACA:<input type="number" class="form-control" name="fcard">
    </div>
    <div class="col-sm">
      FRECUENCIA RESPIRATORIA:<input type="number" class="form-control" name="fresp">
    </div>
    <div class="col-sm">
     <br>TEMPERATURA:<input type="cm-number" class="form-control"  name="temper">
    </div>
    <div class="col-sm">
     SATURACIÓN OXÍGENO:<input type="number"  class="form-control" name="satoxi">
    </div>
    <div class="col-sm-1">
     PESO KILOS:<input type="cm-number" class="form-control"  name="peso">
    </div>
    <div class="col-sm-1">
     TALLA METROS:<input type="cm-number" class="form-control" name="talla" >
    </div>
  </div>
</div>

<?php } ?>

 <hr>
<br>

<?php 

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from dat_nevol WHERE id_atencion=$id_atencion  ORDER BY id_ne DESC") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
     
    
    ?>
  
<div class="row">
    <div class=" col-10">
    <strong><font color="#407959">FECHA Y HORA DE REGISTRO DE NOTA:</font> <?php $fech_n=date_create($f5['fecha_nu']); echo date_format($fech_n,"d-m-Y, H:i:s.")?></strong>
    </div>
</div>
<p>
<!--<strong>TIPO DE NOTA DE EVOLUCIÓN</strong>
<input type="text" name="" class="form-control"  name="tip_ev"><br>-->
  <div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#407959">P</font></label></strong></center>
    </div>
    <div class=" col-10">
     <strong><font color="black">PACIENTE: DESCRIBIR AL PACIENTE (EDAD,GÉNERO, DIAGNÓSTICOS Y TRATAMIENTOS PREVIOS)</font></strong>
     <div class="form-group">
      
    <textarea class="form-control" id="exampleFormControlTextarea1" name="problema" rows="3" disabled=""><?php echo $f5['problema']?></textarea>
  </div>
    </div>
</div>


 <div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#407959">S</font></label></strong></center>
    </div>
    <div class=" col-10">
      <strong><font color="black">SUBJETIVO: DESCRIBIR LA SINTOMATOLOGÍA DEL PACIENTE, HÁBITOS, A QUE ATRIBUYE EL PADECIMIENTO ACTUAL, ETC.</font></strong>
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="subjetivo"  class="form-control" id="exampleFormControlTextarea1" rows="3" name="subjetivo" disabled><?php echo $f5['subjetivo'] ?></textarea>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#407959">O</font></label></strong></center>
    </div>
    <div class=" col-10">
      <strong><font color="black">OBJETIVO: DESCRIBIR LA EXPLORACIÓN FÍSICA</font></strong>
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="objetivo" placeholder="OBJETIVO: DESCRIBIR LA EXPLORACIÓN FÍSICA" disabled><?php echo $f5['objetivo'] ?></textarea>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#407959">A</font></label></strong></center>
    </div>
    <div class=" col-10">
          <strong><font color="black">ANÁLISIS: LOS DIAGNÓSTICOS PROBABLES Y DEFINITIVOS Y LOS ARGUMENTOS, CORRELACIÓN DE LOS ESTUDIOS DE LABORATORIO Y GABINETE CON EL PADECIMIENTO ACTUAL</font></strong>
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="analisis" placeholder="ANÁLISIS: LOS DIAGNÓSTICOS PROBABLES Y DEFINITIVOS Y LOS ARGUMENTOS, CORRELACIÓN DE LOS ESTUDIOS DE LABORATORIO Y GABINETE CON EL PADECIMIENTO ACTUAL" disabled=""><?php echo $f5['analisis'] ?></textarea>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#407959">P</font></label></strong></center>
    </div>
    <div class=" col-10">
<strong><font color="black">PLAN: DESCRIBIR TRATAMIENTO Y RECOMENDACIONES INDICADAS AL PACIENTE, ANOTAR LOS MEDICAMENTOS CON SU DOSIS DE MANERA DETALLADA</font></strong>      
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="plan" placeholder="PLAN: DESCRIBIR TRATAMIENTO Y RECOMENDACIONES INDICADAS AL PACIENTE, ANOTAR LOS MEDICAMENTOS CON SU DOSIS DE MANERA DETALLADA" disabled=""><?php echo $f5['plan'] ?></textarea>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#407959">PX</font></label></strong></center>
    </div>
    <div class=" col-10">
      <strong><font color="black">PRONÓSTICO: PARA LA VIDA Y PARA LA FUNCIÓN</font></strong>
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="px" placeholder="PRONÓSTICO: PARA LA VIDA Y PARA LA FUNCIÓN" disabled=""><?php echo $f5['px']?></textarea>
  </div>
    </div>
</div>

<div class="row">
    <div class=" col"><STRONG>DIAGNÓSTICO(S)</STRONG>
     <div class="form-group">
       <?php echo $f5['diagprob_i']?>
  </div>
    </div>
</div>


<div class="row">
<div class=" col">
  <STRONG>GUIA DE PRÁCTICA CLÍNICA</STRONG>
    <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="guia" placeholder="GUIA DE PRACTICA CLÍNICA" disabled=""><?php echo $f5['guia'] ?></textarea>
    </div>
</div>
</div>


<div class="row">
<div class="col-3">
<center><strong><label for="edosalud"><font size="5"color="#407959"><hr>ESTADO DE SALUD:</font></label></strong></center>
    </div>
<div class=" col-5">
  <hr>
<?php echo $f5['edosalud'] ?>
</div>

</div>
<hr>
<?php } ?>




<br>
<br>
</form>
</div>

   <!--TERMINO DE NOTA DE EVOLUCION-->

</div>
</div>
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