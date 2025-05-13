<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");

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

    <title>NOTA ANESTESICA </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">

<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong> 2DA EVALUACIÓN, INMEDIATAMENTE ANTES DEL PROCEDIMIENTO ANESTÉSICO</strong></center><p>
</div> 
                

<?php

include "../../conexionbd.php";

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);

?>
  <?php
                    while ($f1 = mysqli_fetch_array($resultado1)) {

                        ?>
<div class="container"> 
                        <div class="row">
      <div class="col-sm-6">
 NO.EXPEDIENTE : <td><strong><?php echo $f1['Id_exp']; ?></strong></td><br>
PACIENTE : <td><strong><?php echo $f1['papell']; ?></strong></td>
<td><strong><?php echo $f1['sapell']; ?></strong></td>
<td><strong><?php echo $f1['nom_pac']; ?></strong></td><br>
SEXO : <td><strong><?php echo $f1['sexo']; ?></strong></td><br>
   
    </div>

    <div class="col-sm-4">
<?php $date = date_create($f1['fecha']);
$date1 = date_create($f1['fecnac']);
                                     ?>
      FECHA DE INGRESO : <td><strong><?php echo date_format($date, "d/m/Y"); ?></strong></td><br>
      FECHA DE NACIMIENTO : <td><strong><?php echo date_format($date1, "d/m/Y"); ?></strong></td><br>
      EDAD : <td><strong><?php echo $f1['edad']; ?></strong></td><br>  
    <?php  
                    }
                    ?> 
    </div>

<?php
$resultado2 = $conexion->query("select * from cat_camas WHERE id_atencion=" .$_GET['id_atencion']) or die($conexion->error);
while ($f2 = mysqli_fetch_array($resultado2)) {
?>
  <div class="col">
<?php  
 if(isset($f2)){
    $cama=$f2['num_cama'];
  }else{
    $cama='Sin Cama';
  }
 ?>
HABITACIÓN : <td><strong><?php echo $cama; ?></strong></td> 

<?php
}
?>
    </div>
    
    
  </div>

</div>
<hr>
 </div>   
 <div class="row">
            <div class="col-sm-10">
                <?php
                
                $fecha_actual = date("Y-m-d H:i:s");
                ?>
                
                <div class="form-group">
                    <label for="fecha">FECHA Y HORA ACTUAL:</label>
                    <input type="datetime" name="fec_hc" value="<?= $fecha_actual ?>" class="form-control" disabled>
                </div>
            </div>
        </div>



  
      <div class="container">  <!--INICIO DE CONSULTA DE URGENCIAS-->


    
<form action="insertar_2da_evaluacion.php?id_atencion= <?php echo $_GET['id_atencion'] ?>" method="POST">

<div class="container">
  <div class="row">
    <div class="col-sm-6">
     FECHA: <input type="date" name="fecha2" id="fecha2" required class="form-control col-sm-5">
    </div>
    <div class="col-sm-4">
     HORA: <input type="time" name="hora2" id="hora2" required class="form-control col-sm-8">
    </div>
  </div>
</div><hr>
<div class="container">
  <div class="row">
    <div class="col-sm-7">
     CUENTA CON CONSENTIMIENTO INFORMADO PARA ANESTESIA Y/O SEDACIÓN
    </div>
    <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="ansed" id="flexRadioDefault1" value="SI" required>
  <label class="form-check-label" for="flexRadioDefault1">
   SI
  </label>
</div>
    </div>
    <div class="col-sm-3">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="ansed" id="flexRadioDefault1" value="NO" required>
  <label class="form-check-label" for="flexRadioDefault1">
    NO
  </label>
</div>
    </div>
  </div>
</div>

<hr>
<div class="container">
  <div class="row">
    <div class="col-sm-7">
     SE CORROBORÓ LA IDENTIFICACIÓN DEL PACIENTE, SU ESTADO ACTUAL, EL DIAGNÓSTICO Y EL PROCEDMIENTO PROGRAMADO ANTES DEL INICIO DE LA ANESTESIA
    </div>
    <div class="col-sm-2">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="diaproc" id="anest" value="SI" required>
  <label class="form-check-label" for="anest">
   SI
  </label>
</div>
    </div>
    <div class="col-sm-3">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="diaproc" id="anest2" value="NO" required>
  <label class="form-check-label" for="anest2">
    NO
  </label>
</div>
    </div>
  </div>
</div>
<hr>
<div class="row">
  <div class="col"><br><strong>SIGNOS VITALES:</strong></div>
 
    <div class="row">
      <div class="col">
      TA:<br><input required type="number" name="sist" placeholder="mmHg"  id="p_sistolica"  value=""   required> / <label for="p_sistolica"><input required type="number" name="diast"   placeholder="mmHg" id="p_diastolica"   value="" required>
      </div>
    </div>
  <div class="col">FC: <input type="text" name="freccard" class="form-control" required></div>
  <div class="col">FR: <input type="text" name="frecresp" class="form-control" required></div>
    <div class="col">TEMP: <input type="text" name="temp" class="form-control" required></div>
  <div class="col">SAT OXÍGENO: <input type="text" name="spo2" class="form-control" required></div>
</div>
<hr>
<div class="row">
  <div class="col">MEDICACIÓN PREANESTÉSICA <input required type="text" name="med_pre" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    <input  type="text" name="med_pre2" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>

  <div class="col"><br>DOSIS <input required type="text" name="dosis" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    <input type="text" name="dosis2" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>

  <div class="col"><br>VÍA <input required type="text" name="via" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

    <input type="text" name="via2" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>

  <div class="col"><br>FECHA <input required type="date" name="fechamedi" class="form-control">
    <input type="date" name="fechamedi2" class="form-control">
  </div>
   <div class="col"><br>HORA <input required type="time" name="horamedi" class="form-control">
    <input type="time" name="horamedi2" class="form-control">
  </div>
  <div class="col"><br>EFECTO <input required type="text" name="efect" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    <input type="text" name="efect2" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
</div>
<hr>
<div class="row">
  <div class="col"><h6><br><strong>VERIFICACIÓN DEL EQUIPO Y MONITOREO ANTES DE LA ANESTESIA</strong></div>
    <div class="col"><label>HORA:</label> <input type="time" name="hora_ver" class="form-control-small col-4"></div>
  </div>
<hr>

<div class="row">
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="apan" id="apar" value="SI" >
  <label class="form-check-label" for="apar">
   APARATO ANESTESIA
  </label>
</div>
</div>
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="circ" id="circuito" value="SI">
  <label class="form-check-label" for="circuito">
   CIRCUITO
  </label>
</div>
</div>
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="fugas" id="fugas" value="SI">
  <label class="form-check-label" for="fugas">
   FUGAS
  </label>
</div>
</div>
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="cal" id="cal" value="SI">
  <label class="form-check-label" for="cal">
   CAL SODADA
  </label>
</div>
</div>
</div>

<div class="row">
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="vent" id="venti" value="SI">
  <label class="form-check-label" for="vent">
   VENTILADOR
  </label>
</div>
</div>
    <div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="para" id="parame" value="SI">
  <label class="form-check-label" for="parame">
   PARÁMETROS VENTILATORIOS
  </label>
</div>
</div>
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="flujo" id="flujo" value="SI">
  <label class="form-check-label" for="flujo">
   FLUJÓMETROS
  </label>
</div>
</div>
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="vapo" id="vap" value="SI">
  <label class="form-check-label" for="vap0">
   VAPORIZADORES
  </label>
</div>
</div>
</div>

<div class="row">
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="fuen" id="fuentea" value="SI">
  <label class="form-check-label" for="fuentea">
   FUENTE DE O2 Y ALARMAS
  </label>
</div>
</div>
    <div class="col-9">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="fuent" id="fuentee" value="SI">
  <label class="form-check-label" for="fuentee">
   FUENTE DE ENERGÍA Y ALARMAS
  </label>
</div>
</div>
</div>

<div class="row">
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="ecg" id="ecg" value="SI">
  <label class="form-check-label" for="ecg">
   ECG
  </label>
</div>
</div>
    <div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="pani" id="pani" value="SI">
  <label class="form-check-label" for="pani">
   PANI
  </label>
</div>
</div>
<div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="spo" id="sp" value="SI">
  <label class="form-check-label" for="sp">
   SP O2
  </label>
</div>
</div>
<div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="co2" id="co" value="SI">
  <label class="form-check-label" for="co">
   CO2FE
  </label>
</div>
</div>
</div><p></p>
<strong>OPCIONALES:</strong>
<div class="row">
    <div class="col"><div class="form-check">
  <input class="form-check-input" type="checkbox" name="ana" id="ana" value="SI">
  <label class="form-check-label" for="ana">
   ANALIZADOR DE GASES RESP
  </label>
</div>
</div>
    <div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="indice" id="indi" value="SI">
  <label class="form-check-label" for="indi">
   ÍNDICE BIESPECTRAL
  </label>
</div>
</div>
<div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="bomba" id="bomba" value="SI">
  <label class="form-check-label" for="bomba">
   BOMBA DE INFUSIÓN
  </label>
</div>
</div>
<div class="col">
      <div class="form-check">
  <input class="form-check-input" type="checkbox" name="moni" id="mon" value="SI">
  <label class="form-check-label" for="mon">
   MONITOR DE RELAJACIÓN
  </label>
</div>
</div>
</div><br>
<label for="exampleFormControlTextarea1">OBSERVACIONES:</label>
    <textarea class="form-control" name="obser" id="exampleFormControlTextarea1" required rows="4" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
    <br>
    
  <hr>

 
<center>
                       <div class="form-group col-6">
                            <button type="submit" class="btn btn-primary">FIRMAR</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button>
                        </div>
</center>
                        <br>
                        </form>
</div> <!--TERMINO DE NOTA MEDICA div container-->
  
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


<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>


</body>
</html>