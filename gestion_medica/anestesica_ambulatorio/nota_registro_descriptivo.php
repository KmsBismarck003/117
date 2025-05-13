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
                
<div class="thead" style="background-color: #0c675e; color: white; font-size: 24px;">
  <center><strong> NOTA REGISTRO DESCRIPTIVO TRANS-ANESTÉSICO</strong></center><p>
</div> 
    <hr>
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

<form action="insertar_trans_anest.php?id_atencion= <?php echo $_GET['id_atencion'] ?>" method="POST">

<hr>
<div class="row">
  <div class="col">
    <strong>ANESTESIÓLOGO</strong> <input type="text" name="anest" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  <div class="col">
    <strong>DIAGNÓSTICO POST-OPERATORIO</strong> <input type="text" name="diagposto" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  <div class="col">
    <strong>OPERACIÓN REALIZADA</strong> <input type="text" name="opreal" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</div><hr>
<div class="row">
  <div class="col">
    <strong>ANESTESIA REALIZADA</strong> <input type="text" name="anestreal" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  <div class="col">
    <strong>POSICIÓN Y CUIDADOS</strong> <input type="text" name="poscui" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</div>
<hr>
<div class="row">
  <div class="col-10">
    <strong>INDUCCIÓN</strong> <input type="text" name="ind" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  <div class="col-2">
    <strong>HORA:</strong> <input type="time" name="hora" class="form-control" required >
  </div>
</div>
<div class="row">
  <div class="col">
    <strong>AGENTES Y DOSIS</strong> <input type="text" name="agdo" class="form-control" required>
  </div>
</div>
<hr>
<center><h6><strong>VÍA ÁREA</strong></h6></center>
<div class="row">
  <div class="col">
    <strong>INTUBACIÓN</strong> <input type="text" name="in" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
   <div class="col">
    <strong>MASCARILLA</strong> <input type="text" name="masc" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</div>
<div class="row">
  <div class="col">
    <strong>CÁNULA</strong> <input type="text" name="can" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  <div class="col">
    <strong>OTRO:</strong> <input type="text" name="otro" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</div>
 <strong>LARINGOSCOPIA:</strong> <input type="text" name="larin" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"><hr>
<div class="row">
  <div class="col">
    <strong>VENTILACIÓN</strong> <input type="text" name="venti" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  <div class="col">
    <strong>CIRCUITO:</strong> <input type="text" name="cir" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  <div class="col"><br>
   <div class="form-check">
  <input class="form-check-input" type="radio" name="esasme" id="es" value="ESPONTANEA" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  <label class="form-check-label" for="es">
    ESPONTÁNEA
  </label>
</div>
  </div>
  <div class="col"><br>
   <div class="form-check">
  <input class="form-check-input" type="radio" name="esasme" id="as" value="ASISTIDA" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  <label class="form-check-label" for="as">
    ASISTIDA
  </label>
</div>
  </div>
  <div class="col"><br>
   <div class="form-check">
  <input class="form-check-input" type="radio" name="esasme" id="me" value="MECANICA" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  <label class="form-check-label" for="me">
    MECÁNICA
  </label>
</div>
  </div>
</div>


<hr>
<div class="row">
  <div class="col">
     <strong>MECÁNICA:</strong> <input type="text" name="mec" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
   <div class="col">
     <strong>MODO:</strong> <input type="text" name="modo" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
   <div class="col">
     <strong>FI O2</strong> <input type="text" name="fl" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
   <div class="col">
     <strong>V.CORRIENTE</strong> <input type="text" name="vcor" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
   <div class="col">
     <strong>FR</strong> <input type="text" name="fr" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
   <div class="col">
     <strong>REL. I:E</strong> <input type="text" name="rel" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
   <div class="col">
     <strong>PEEP</strong> <input type="text" name="peep" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</div><br>
 <strong>COMENTARIOS:</strong> <input type="text" name="com" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
<hr>
<div class="form-group"><strong>MANTENIMIENTO:</strong>
    <textarea class="form-control" required id="exampleFormControlTextarea1" name="mant" rows="2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
  <hr>

<div class="row"><strong>RELAJACIÓN MUSCULAR:</strong>
  <div class="col-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="relaj" id="no" value="NO" required>
  <label class="form-check-label" for="no">
    NO
  </label>
</div>
  </div>
   <div class="col-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="relaj" id="si" value="SI" required>
  <label class="form-check-label" for="si">
    SI
  </label>
</div>
  </div>
   <div class="col">
 <strong>AGENTES:</strong> <input type="text" name="agent" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
   <div class="col">
 <strong>DOSIS TOTAL:</strong> <input type="text" name="dosis" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
   <div class="col">
     <strong>ÚLTIMA DOSIS:</strong> <input type="text" name="ultdosis" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</div>
<br>
<div class="row"><strong>ANTAGONISMO:</strong>
  <div class="col-1">
     <div class="form-check">
  <input class="form-check-input1" type="radio" name="ant" id="no" value="NO" required>
  <label class="form-check-label1" for="no">
    NO
  </label>
</div>
  </div>
   <div class="col-1">
     <div class="form-check">
  <input class="form-check-input1" type="radio" name="ant" id="si" value="SI" required>
  <label class="form-check-label1" for="si">
    SI
  </label>
</div>
  </div>
   <div class="col">
 <strong>AGENTE Y DOSIS:</strong> <input type="text" name="agdos" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  <strong>MONITOREO(OPCIONAL):</strong>
   <div class="col-1">
  <div class="form-check">
  <input class="form-check-input2" type="radio" name="monit" id="si" value="SI" required>
  <label class="form-check-label2" for="si">
    SI
  </label>
</div>
  </div>
   <div class="col-1">
      <div class="form-check">
  <input class="form-check-input2" type="radio" name="monit" id="si" value="NO" required>
  <label class="form-check-label2" for="si">
    NO
  </label>
</div>
  </div>
  
</div>
<div class="row">
<strong>COMENTARIOS:</strong> <input type="text" name="comen" class="form-control" >
</div>
  <hr>
<strong>ANESTESIA REGIONAL</strong><br><br>
  <div class="row">
    <div class="col-4">
      <div class="col">BLOQUEO <input type="text" name="bloq" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
      <div class="col">TÉCNICA <input type="text" name="tec" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
      <div class="col">POSICIÓN <input type="text" name="posi" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
      <div class="col">ASEP Y ANTISEP <input type="text" name="asep" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
      <div class="col">AGUJA <input type="text" name="aguja" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
      <hr>
<div class="col"> B.SIMPÁTICO <input type="text" name="bsim" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
<div class="col"> B.MOTOR <input type="text" name="bmotor" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
    </div>
    <div class="col-3">
      <div class="col">AGENTES Y DOSIS <input type="text" name="agdosi" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
      <div class="col">CATETER <input type="text" name="cate" class="form-control" required required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
      <div class="col">LATENCIA <input type="text" name="lat" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
      <div class="col">DIFUSIÓN <input type="text" name="dif" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
      <br><br><br><BR>
<div class="col">B. SENSITIVO <input type="text" name="bsen" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
    </div>
    <div class="col-5">
      <center><strong>CASO OBSTÉTRICO</strong></center>
      <div class="form-group">
    <textarea class="form-control" name="caso" id="exampleFormControlTextarea1" required rows="18" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
    </div>
  </div>

<div class="col-7"> COMENTARIOS <input type="text" name="coment" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
<hr>
<div class="col">
<div class="form-group"><strong>EMERSIÓN:</strong>
    <textarea class="form-control" name="emer" required id="exampleFormControlTextarea1" rows="2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
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