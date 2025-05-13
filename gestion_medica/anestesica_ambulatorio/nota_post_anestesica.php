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
<div class="thead" style="background-color: #0c675e; color: white; font-size:24px;">
  <center><strong>MANEJO POST-ANESTÉSICO</strong></center><p>
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


   
<form action="insertar_post_anestesica.php?id_atencion= <?php echo $_GET['id_atencion'] ?>" method="POST">


<div class="container">
  <div class="row"><strong>TÉCNICA ANESTÉSICA</strong>
    <div class="col-sm">
      <input type="text" name="tecan_pos" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div><strong>TIEMPO ANESTÉSICO</strong>
    <div class="col-sm">
      <input type="text" name="tiem_pos" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
  </div>
</div>
<hr>
 <div class="row">
    <div class="col-sm-2">
   <br><br><strong>MEDICAMENTOS ADMINISTRADOS</strong>
    </div>
    <div class="col-sm">
       <p><strong>ANESTÉSICOS</strong><input type="text" name="an_pos" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"> </p>
      <strong>ADYUVANTES</strong><input type="text" name="ad_pos" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
  </div>
  <hr>
<div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>CONTINGENCIAS ACCIDENTALES E INCIDENTES ATRIBUIBLES A LA ANESTESIA</strong></label>
    <textarea class="form-control" name="con_pos" id="exampleFormControlTextarea1" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
  <hr>
<div class="form-group">
    <label for="exampleFormControlTextarea2"><strong>BALANCE HÍDRICO</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea2" name="bal_pos" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
<hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size:19px;">
  <center><strong>ESTADO CLÍNICO DEL PACIENTE AL EGRESO DEL QUIRÓFANO</strong></center><p>
</div> 

<div class="container">
  <div class="row">
    <div class="col-sm-3">
    <br> <strong>SIGNOS VITALES</strong>
    </div>
    <div class="col-sm-2">TA:
     <div class="row">
  <div class="col"><input type="text" name="sist_pos" class="form-control"></div> /
  <div class="col"><input type="text" name="dias_pos" class="form-control"></div>
 
</div>
    </div>
    <div class="col-sm-1">
      FC:<input type="text" name="fc_pos" class="form-control">
    </div>
    <div class="col-sm-1">
      FR:<input type="text" name="fr_pos" class="form-control">
    </div>
    <div class="col-sm-1">
     TEMP:<input type="text" name="temp_pos" class="form-control">
    </div>
    <div class="col-sm-1">
     PULSO:<input type="text" name="pul_pos" class="form-control">
    </div>
    <div class="col-sm-3">
     SAT OXÍGENO<input type="text" name="so_pos" class="form-control">
    </div>
  </div>
</div>
<hr>
<div class="container">
  <div class="row">
    <div class="col-sm">
   <strong> VÍA ÁEREA:</strong><input type="text" name="ae_pos" class="form-control"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    <div class="col-sm">
   <strong> SANGRADO ACTIVO ANORMAL:</strong><input type="text" name="san_pos" class="form-control"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    </div>
  </div><br>
  <div class="container">
  <div class="row">
    
    
    
    </div>
  
</div>
<hr>
<strong>LUGAR Y CONDICIONES DE TRASLADO (INCLUIR ALDRETE):</strong><input type="text" name="tras_pos" class="form-control"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"><hr>
<strong>OBSERVACIONES:</strong><input type="text" name="ob_pos" class="form-control"><hr>
<strong>PLAN DE MANEJO Y TRATAMIENTO, INCLUYENDO PROTOCOLO DE ANALGESIA:</strong><input type="text" name="plan_pos" class="form-control"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

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