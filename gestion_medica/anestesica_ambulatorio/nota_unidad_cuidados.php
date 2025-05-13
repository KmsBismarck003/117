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
  <center><strong>NOTA DE RECUPERACIÓN</strong></center><p>
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


   
<form action="insertar_unidcuid.php?id_atencion= <?php echo $_GET['id_atencion'] ?>" method="POST">
<div class="container">
  <div class="row">
    <div class="col-sm"><br>
     <strong>SIGNOS VITALES</strong>
    </div>
    <div class="col-sm">TA:
      <div class="row">
  <div class="col"><input type="text" name="t_sisto" class="form-control"></div> /
  <div class="col"><input type="text" name="t_diasto" class="form-control"></div>
 
</div>
    </div>
    <div class="col-sm">
      FC:<input type="text" name="fc_un" class="form-control">
    </div>
    <div class="col-sm">
     FR:<input type="text" name="fr_un" class="form-control">
    </div>
    <div class="col-sm">
      TEMP:<input type="text" name="temp_un" class="form-control">
    </div>
    <div class="col-sm">
      PULSO:<input type="text" name="pul_un" class="form-control">
    </div>
    <div class="col-sm">
      SAT OXÍGENO:<input type="text" name="sp_un" class="form-control">
    </div>
  </div>
</div>
  <hr>
  <div class="row">
  <div class="col"> ESTADO GENERAL:<input type="text" name="est_un" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
  <div class="col">ESTADO DE CONCIENCIA:<input type="text" name="con_un" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
</div><hr>
<div class="row">
  <div class="col">PERMEABILIDAD DE LA VÍA ÁREA:<input type="text" name="via_un" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
  <div class="col">PERMEBAILIDAD DE VENICLISIS:<input type="text" name="veni_un" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
  <div class="col">PERMEABILIDAD DE SONDAS Y DRENAJES:<input type="text" name="son_un" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
</div><hr>
<div class="row">
  <div class="col">CONTINGENCIAS Y MANEJO:<input type="text" name="man_un" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
  <div class="col">RESUMEN DEL TRATAMIENTO:<input type="text" name="trat_un" class="form-control"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
  <div class="col">DIAGNÓSTICOS FINALES Y SU FUNDAMENTO:<input type="text" name="fun_un" class="form-control"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
</div><hr>
<div class="row">
  <div class="col">MOTIVO DEL EGRESO: (INCLUIR ALDRETE)<input type="text" name="mot_un" class="form-control"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
  <div class="col">PROBLEMAS CLÍNICOS PENDIENTES Y EL PLAN TERAPÉUTICO DETALLADO:<input type="text" name="tera_un" class="form-control"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
</div>

<hr>
<div class="row">
  <div class="col-5"><strong>EGRESO DE LA UNIDAD DE RECUPERACIÓN:</strong></div>
  FECHA:<div class="col"><input type="date" name="fecha_un" class="form-control col-9"></div>
  HORA:<div class="col"><input type="time" name="hora_un" class="form-control col-7"></div>
</div><br>
<div class="row">
  <div class="col">  <div class="form-check">
  <input class="form-check-input" type="radio" name="rec_un" id="hab" value="HABITACION">
  <label class="form-check-label" for="hab">
    A: HABITACIÓN
  </label>
</div></div>
  <div class="col">  <div class="form-check">
  <input class="form-check-input" type="radio" name="rec_un" id="dom" value="DOMICILIO">
  <label class="form-check-label" for="dom">
    DOMICILIO
  </label>
</div></div>
  <div class="col">  <div class="form-check">
  <input class="form-check-input" type="radio" name="rec_un" id="otro" value="OTRO">
  <label class="form-check-label" for="otro">
    OTRO
  </label>
</div></div>
  (ESPECIFICAR):<div class="col-5"><input type="text" name="esp_un" class="form-control"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
</div>
<hr>

<div class="form-group">
<center><h6><strong>NOTA DE EVOLUCIÓN POST-ANESTÉSICA DE 24 HRS. Y 48 HRS. (SI ES NECESARIO)</strong></h6></center>
    <textarea class="form-control" name="notevo_un" id="exampleFormControlTextarea1" rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div><hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size:19px;">
  <center><strong>ALDRETE</strong></center><p>
</div> 
<div class="container">
  <div class="row">
    <div class="col-sm">
     <br><hr><br><strong>ACTIVIDAD MUSCULAR</strong>
     <br>
     
     <hr>
     <strong>RESPIRACIÓN</strong>
     <br><br>
     <hr><br>
     <strong>CIRCULACIÓN</strong>
     <br><br>
     <hr>
     <strong>ESTADO DE CONCIENCIA</strong>
     <hr>
     <strong>SATURACIÓN DE OXÍGENO</strong>
     <hr>
    </div>
    <div class="col-3"><strong><center>TIEMPO (MINUTOS)</center></strong><hr><br>
      <font size="1"><p>MOVS. VOLUNTARIOS AL LLAMADO (4 EXTREMIDADES)
      MOVS. VOLUNTARIOS AL LLAMADO (2 EXTREMIDADES)
      COMPLETAMENTE INMÓVIL</p></font>
      <hr>
      <font size="1"><p>RESPIRACIONES AMPLIAS Y CAPAZ DE TOSER
      RESPIRACIONES LIMITADAS<br>
    APNEA</p></font><hr>
 <br>
 <font size="1"><p>PRESIÓN ARTERIAL + -20% DEL NIVEL BASAL
 PRESIÓN ARTERIAL + -21 - 49% DEL NIVEL BASAL
PRESIÓN ARTERIAL + -50% DEL NIVEL BASAL</p></font><hr>

 <font size="1"><p>COMPLETAMENTE DESPIERTO<br>
 RESPONDE AL SER LLAMADO<br>
NO RESPONDE</p></font><hr>


<font size="1"><p>MANTIENE SAT. DE O2 > 92% CON AIRE AMBIENTE
NECESITA O2 PARA MANTENER LA SAT DE O2 > 90%
SATURACIÓN DE O2 < 90% CON SUPLEMENTO DE OXÍGENO</p></font><hr>

<font size="5"><p><strong>TOTAL DEL ALDRETE</strong></p></font><hr>

    </div>
    <div class="col-sm col-1">
      <br>
      <hr><br>
     <font size="1"><strong><p>= 2<br>
     = 1<br>
   = 0</p></strong></font>
   <hr>
     <font size="1"><strong><p>= 2<br>
     = 1<br>
   = 0</p></strong></font>
 <hr>
      <br>
     <font size="1"><strong><p>= 2<br>
     = 1<br>
   = 0</p></strong></font>
<hr>
      
     <font size="1"><strong><p>= 2<br>
     = 1<br>
   = 0</p></strong></font>
<hr>
    
     <font size="1"><strong><p>= 2<br>
     = 1<br>
   = 0</p></strong></font>









    </div>
   <div class="col-sm">
    <center>0</center><hr><br><div class="losInput">
      <input  type="text" name="nt" id="num1" class="form-control" maxlength="1" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
      <div class="inputTotal"><input type="text" name="t" value="" class="form-control" disabled="">
    </div>
  </div>
     <div class="col-sm">
    <center>5</center><hr><br><div class="losInput2">
      <input type="text" name="nt2" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt2" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt2" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct2" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st2" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
<div class="inputTotal2">
    <input type="text" name="t2" class="form-control" disabled="">
  </div>
    </div>
     <div class="col-sm">
    <center>10</center><hr><br>
<div class="losInput3">
    <input type="text" name="nt3" class="form-control" maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
    <input type="text" name="dt3" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
    <input type="text" name="tt3" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
    <input type="text" name="ct3" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
    <input type="text" name="st3" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
<div class="inputTotal3">
    <input type="text" name="t3" class="form-control" disabled=""></div>
    </div>
    <div class="col-sm">
    <center>15</center><hr><br><div class="losInput4">
      <input type="text" name="nt4" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt4" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt4" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct4" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st4" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
      <div class="inputTotal4">
        <input type="text" name="t4" class="form-control" disabled=""></div>
    </div>
    <div class="col-sm">
    <center>20</center><hr><br><div class="losInput5">
      <input type="text" name="nt5" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt5" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt5" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct5" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st5" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
      <div class="inputTotal5"><input type="text" name="t5" class="form-control" disabled=""></div>
    </div>
    <div class="col-sm">
    <center>25</center><hr><br><div class="losInput6">
      <input type="text" name="nt6" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt6" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt6" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct6" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st6" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
      <div class="inputTotal6"><input type="text" name="t6" class="form-control" disabled=""></div>
    </div>
    <div class="col-sm">
    <center>30</center><hr><br><div class="losInput7">
      <input type="text" name="nt7" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="dt7" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="tt7" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="ct7" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br>
      <input type="text" name="st7" class="form-control"maxlength="1"onkeypress='return event.charCode >= 48 && event.charCode <= 57'/><br><br></div>
      <div class="inputTotal7"><input type="text" name="t7" class="form-control" disabled=""></div>
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
<script>
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
function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;        
}
</script>


</body>
</html>