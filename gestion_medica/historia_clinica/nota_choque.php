<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");
if (isset($_GET['id_atencion'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
    $resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp  WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);
    if (mysqli_num_rows($resultado) > 0) { //se mostrara si existe mas de 1
        $f = mysqli_fetch_row($resultado);

    } else {
        header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
    }
} else {
    header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
}
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
     <style type="text/css">
    #contenido{
        display: none;
    }
</style>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
                <hr>
                <h2><strong>NOTAS DE CHOQUE</strong></h2>
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
    <div class="col-sm-5">
        NO.EXPEDIENTE: <td><strong><?php echo $f1['Id_exp']; ?></strong></td>
    </div>
    <div class="col-sm">
     ADMISIÓN: <td><strong><?php echo $f1['id_atencion']; ?></strong></td>
    </div>
    <div class="col-sm">
    </div>
  </div>
</div>
<div class="container">      
                           
  <div class="row">
    <div class="col-sm-5">
       PACIENTE:
<td><strong><?php echo $f1['papell']; ?></strong></td>
                            <td><strong><?php echo $f1['sapell']; ?></strong></td>
                            <td><strong><?php echo $f1['nom_pac']; ?></strong></td>
    </div>

    <div class="col-sm-5">
      FECHA DE NACIMIENTO:
                            <td><strong><?php echo $f1['fecnac']; ?></strong></td>
    </div>
    <div class="col-sm">
       EDAD:
                            <td><strong><?php echo $f1['edad']; ?></strong></td>
    </div>
  </div>
</div>
<hr>
                        <?php  
                    }
                    ?>             
                        
            </div>
            <div class="col-3">
                <?php
                
                $fecha_actual = date("Y-m-d H:i:s");
                ?>
                <hr>
                <div class="form-group">
                    <label for="fecha">Fecha y Hora del Sistema:</label>
                    <input type="datetime" name="fec_hc" value="<?= $fecha_actual ?>" class="form-control" disabled>
                </div>
            </div>
        </div>

        <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="true">NOTA DE EVOLUCIÓN</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
   <!--INICIO DE NOTA DE EVOLUCION-->
<div class="tab-pane fade show active" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">


    <?php $id_cli = $_GET['id_atencion']; ?>

     <?php $id_usua = $_GET['id_usua']; ?>

          <form action="insertar_nota_choque.php?id_atencion=<?php echo $_GET['id_atencion']; ?>&id_usua=<?php echo $_GET['id_usua']; ?>" method="POST">
<br>
<div class="container -12">
                <div class="row col-6">
                    <div class="col-sm">
                      
                        <!--<strong>No. Admisión:</strong>-->
                        <?php $id_cli = $_GET['id_atencion']; ?>
                        <input type="hidden" name="id_atencion" class="form-control" value="<?php echo $id_cli ?>"
                               readonly placeholder="No. De expediente">
                    </div>
                </div>
            </div>
        
<p><strong>TIPO DE NOTA DE EVOLUCIÓN</strong></p>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="ingre" value="NOTA DE INGRESO HOSPITALIZACION">
  <label class="form-check-label" for="ingre">
<font color="#407959"><strong><u>NOTA DE INGRESO HOSPITALIZACIÓN</u></strong></font>
  </label>
</div>
    </div>
    <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="alta" value="NOTA DE ALTA DE HOSPITALIZACION">
  <label class="form-check-label" for="alta">
   <font color="#407959"><strong><u>NOTA DE EGRESO</u></strong></font>
  </label>
</div>
    </div>
    <div class="col-sm">
    <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="parto" value="NOTA POST-PARTO">
  <label class="form-check-label" for="parto">
    <font color="#407959"><strong><u>NOTA POST_PARTO</u></strong></font>
  </label>
</div>
    </div>
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="neon" value="NOTA NEONATOLOGICA">
  <label class="form-check-label" for="neon">
      <font color="#407959"><strong><u>NOTA NEONATOLÓGICA</u></strong></font>
  </label>
</div>
    </div>
     <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="valor" value="NOTA DE VALORACION CIRUGIA GENERAL">
  <label class="form-check-label" for="valor">
<font color="#407959"><strong><u>NOTA DE VALORACIÓN CIRUGÍA GENERAL</u></strong></font>
  </label>
</div>
    </div>
     <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="notevol" value="NOTA DE EVOLUCION">
  <label class="form-check-label" for="notevol">
<font color="#407959"><strong><u>NOTA DE EVOLUCIÓN</u></strong></font>
  </label>
</div>
    </div>
  </div>
</div>
<br>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="resumen" value="NOTA RESUMEN DE EVOLUCION Y ESTADO ACTUAL">
  <label class="form-check-label" for="resumen">
  <font color="#407959"><strong><u>NOTA RESUMEN DE EVOLUCIÓN Y ESTADO ACTUAL</u></strong></font>
  </label>
</div>
    </div>
    <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="notpre" value="NOTA PREOPERATORIA">
  <label class="form-check-label" for="notpre">
  <font color="#407959"><strong><u>NOTA PREOPERATORIA</u></strong></font>
  </label>
</div>
    </div>
    <div class="col-sm">
    <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="notpost" value="NOTA POSTOPERATORIA">
  <label class="form-check-label" for="notpost">
<font color="#407959"><strong><u>NOTA POSTOPERATORIA</u></strong></font>
  </label>
</div>
    </div>
    <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="pretrans" value="NOTA PRE-TRANSFUSION SANGUINEA">
  <label class="form-check-label" for="pretrans">
 <font color="#407959"><strong><u>NOTA PRE-TRANSFUSIÓN SANGUÍNEA</u></strong></font>
  </label>
</div>
    </div>
     <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="ptrans" value="NOTA POST-TRANSFUSION SANGUINEA">
  <label class="form-check-label" for="ptrans">
<font color="#407959"><strong><u>NOTA POST-TRANSFUSIÓN SANGUÍNEA</u></strong></font>
  </label>
</div>
    </div>
     <div class="col-sm">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="tip_ech" id="transs" value="NOTA TRANSFUSION SANGUINEA">
  <label class="form-check-label" for="transs">
<font color="#407959"><strong><u>NOTA TRANSFUSIÓN SANGUÍNEA</u></strong></font>
  </label>
</div>
    </div>
  </div>
</div>
<hr>
<br>

 <div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#407959">P</font></label></strong></center>
    </div>
    <div class=" col-10">
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" name="problemach" rows="3" placeholder="PACIENTE: DESCRIBIR AL PACIENTE (EDAD,GÉNERO, DIAGNÓSTICOS Y TRATAMIENTOS PREVIOS)" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
    </div>
</div>
 <div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#407959">S</font></label></strong></center>
    </div>
    <div class=" col-10">
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="subjetivoch" placeholder="SUBJETIVO: DESCRIBIR LA SINTOMATOLOGÍA DEL PACIENTE, HÁBITOS, A QUE ATRIBUYE EL PADECIMIENTO ACTUAL, ETC."style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#407959">O</font></label></strong></center>
    </div>
    <div class=" col-10">
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="objetivoch" placeholder="OBJETIVO: DESCRIBIR LA EXPLORACIÓN FÍSICA"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#407959">A</font></label></strong></center>
    </div>
    <div class=" col-10">
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="analisisch" placeholder="ANÁLISIS: LOS DIAGNÓSTICOS PROBABLES Y DEFINITIVOS Y LOS ARGUMENTOS, CORRELACIÓN DE LOS ESTUDIOS DE LABORATORIO Y GABINETE CON EL PADECIMIENTO ACTUAL."style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#407959">P</font></label></strong></center>
    </div>
    <div class=" col-10">
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="planch" placeholder="PLAN: DESCRIBIR TRATAMIENTO Y RECOMENDACIONES INDICADAS AL PACIENTE, ANOTAR LOS MEDICAMENTOS CON SU DOSIS DE MANERA DETALLADA."style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#407959">PX</font></label></strong></center>
    </div>
    <div class=" col-10">
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="pxch" placeholder="PRONÓSTICO: PARA LA VIDA Y PARA LA FUNCIÓN"style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
    </div>
</div>

 <div class="col">
<div class="form-group">
 <label for="id_cie_10"><strong>DESTINO: </strong></label>
    <select name="dest_cu_choque" class="form-control" id="mibuscador" style="width : 50%; heigth : 50%;" onchange="mostrar(this.value);">
        <option value="">SELECCIONAR DESTINO</option>
        <option value="QUIROFANO">QUIRÓFANO</option>
        <option value="HOSPITALIZACION">HOSPITALIZACIÓN</option>
        <option value="EGRESO DE URGENCIAS">EGRESO DE URGENCIAS</option>
    </select>
    </div>
</div>
      <hr>               
<div class="row" id="contenido">
    <div class="col-sm">
     
      <strong><p>TIPO DE INTERVENCIÓN:</p></strong>
     <div class="form-check">
  <input class="form-check-input" type="radio" name="tipo_intervenciony" value="URGENCIA" name="tipocir">
  <label class="form-check-label"  for="URGENCIAS">
    URGENCIA
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio"  name="tipo_intervenciony" value="ELECTIVA" name="tipocir">
  <label class="form-check-label" for="URGENCIAS">
    ELECTIVA
  </label>
</div>
    </div>

  <hr>
  
  <div class="row">
    <div class="col-sm">
     
    <label for="exampleFormControlInput1"><strong>FECHA DE SOLICITUD:</strong></label>
    <input type="date" class="form-control" name="fechay" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="">
  
    </div>
    <div class="col-sm">
     <div class="form-group">
    <label for="exampleFormControlInput1"><strong>HORA DESEADA:</strong></label>
    <input type="time" class="form-control" name="hora_solicitudy" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
    </div>
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlInput1"><strong>INTERVENCIÓN SOLICITADA:</strong></label>
    <input type="text" class="form-control" name="intervencion_soly" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
    </div>
  </div>

  
 
<div class="form-group">
        <label for="id_cie_10"><strong> DIAGNÓSTICO PREOPERATORIO:</strong></label>
        <input type="text" class="form-control" name="diag_preopy" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>


<div class="form-group">
        <label for="cirugia_prog"><strong>CIRUGÍA PROGRAMADA:</strong></label>
        <input type="text" class="form-control" name="cirugia_progy" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>


<hr id="contenido">

<div class="row">

  <div class="col"><strong><center>SANGRE EN</center></strong><hr>
    
  <div class="row">
    <div class="col-sm">
      <label for="exampleFormControlInput1">QUIROFANO:</label>
    <input type="text" class="form-control" name="quirofanoy" required id="exampleFormControlInput1" placeholder="ml." style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    <div class="col-sm">
      <label for="exampleFormControlInput1">RESERVA:</label>
    <input type="text" class="form-control" name="reservay" id="exampleFormControlInput1" required placeholder="ml." style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
  </div>
<hr >
  </div>
  <div class="col"><strong><center>ANESTESIA</center></strong><hr>
  <div class="row">
    <div class="col-sm-4">
    <label for="exampleFormControlInput1">LOCAL</label>
    <input type="text" class="form-control" name="localy" id="exampleFormControlInput1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"> 
    </div>
    <div class="col-sm-4">
      <label for="exampleFormControlInput1">REGIONAL</label>
    <input type="text" class="form-control" name="regionaly" id="exampleFormControlInput1"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"> 
    </div>
    <div class="col-sm-4">
      <label for="exampleFormControlInput1">GENERAL</label>
    <input type="text" class="form-control" name="generaly" id="exampleFormControlInput1"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
  </div>
  <hr>
  </div>
  <div class="col"><br><hr>
<div class="row">
    <div class="col-sm">
      <div class="col-sm">
    <label for="exampleFormControlInput1">Hb:</label>
    <input type="text" class="form-control" name="hby" id="exampleFormControlInput1" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    </div>
    <div class="col-sm">
      <div class="col-sm">
    <label for="exampleFormControlInput1">HTO:</label>
    <input type="text" class="form-control" name="htoy" id="exampleFormControlInput1" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    </div>
  </div>
<hr >
  </div>
  <div class="col"><hr>

<div class="row">
    <div class="col-sm"><br>
       <label for="exampleFormControlInput1">PESO:</label>
    <input type="text" class="form-control" name="pesoy" id="exampleFormControlInput1" required placeholder="KG" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    <?php
$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);
?>
  <?php
                    while ($f1 = mysqli_fetch_array($resultado1)) {

                        ?>
    <div class="col-sm">
      <label for="exampleFormControlInput1">GRUPO Y RH SANGUÍNEO:</label>
<input type="text" class="form-control" name="tipo_sangrey" id="exampleFormControlInput1" value="<?php echo $f1['tip_san']?>"disabled>

    </div>
    <?php
}
?>
  </div>
<hr>
  </div>

</div>

<br>

  <div class="row">
    <div class="col-sm">
      <label for="exampleFormControlTextarea1"><strong>INSTRUMENTAL NECESARIO</strong></label>
    <textarea class="form-control" name="inst_necesarioy" id="exampleFormControlTextarea1" required rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
    </div>
    <div class="col-sm">
      <label for="exampleFormControlTextarea5"><strong>MEDICAMENTOS Y MATERIAL NECESARIO</strong></label>
    <textarea class="form-control" name="medmat_necesarioy" id="exampleFormControlTextarea5" required rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
    </div>
    <div class="col-sm">
      <div class="form-group">
    <label for="exampleFormControlInput1"><strong>NOMBRE DEL JEFE DE SERVICIO</strong></label>
    <input type="text" class="form-control" name="nom_jefe_servy" id="exampleFormControlInput1" required placeholder="Nombre" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
    </div>
  </div>

<hr id="contenido">
<strong><center id="contenido">PROGRAMACIÓN EN QUIROFANO</center></strong><br>

<div class="row">
  <div class="col">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>FECHA DE PROGRAMACIÓN</strong></label>
    <input type="date" class="form-control" name="fecha_progray" id="exampleFormControlInput1" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</div>
  <div class="col">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>HORA</strong></label>
    <input type="time" class="form-control" name="hora_progray"  id="exampleFormControlInput1" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  </div>
  <div class="col">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>SALA</strong></label>
    <select class="form-control" id="sala" name="salay">
                                        <option value="">Seleccionar opción</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
  </div>
  </div>
</div>

<div class="row" >
  <div class="col-6">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>INTERVENCIÓN</strong></label>
    <input type="text" class="form-control" name="intervencion_quiry" id="exampleFormControlInput1" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
</div>
  <div class="col">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>INICIO</strong></label>
    <input type="time" class="form-control" name="inicioy"  id="exampleFormControlInput1" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  
  </div>
</div>
  <div class="col">
    <div class="form-group">
    <label for="exampleFormControlInput1"><strong>TÉRMINO</strong></label>
    <input type="time" class="form-control" name="terminoy"  id="exampleFormControlInput1" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
</div>
  
</div>


    <hr>

    </div> <!--TERMINO DE NOTA MEDICA div container-->
</div>

<div class="form-group col-12">
<center><button type="submit" class="btn btn-primary">GUARDAR</button>
<button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button></center>
</div>


<br>
<br>
</form>


   <!--TERMINO DE NOTA DE EVOLUCION-->

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

<script type="text/javascript">
        function mostrar(value)
        {
            if(value=="QUIROFANO" || value==true)
            {
                // habilitamos
                document.getElementById('contenido').style.display = 'block';
            }else if(value=="HOSPITALIZACION" || value=="EGRESO DE URGENCIAS"  || value==false){
                // deshabilitamos
                document.getElementById('contenido').style.display = 'none';
            }
        }
    </script>

</body>
</html>