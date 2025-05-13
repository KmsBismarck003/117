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
<script>
        function habilitar(value)
        {
            if(value=="OTROS" || value==true)
            {
                // habilitamos
                document.getElementById("esp").disabled=false;
            }else if(value!="OTROS" || value==false){
                // deshabilitamos
                document.getElementById("esp").disabled=true;
            }
        }
    </script>

    <title>MEDICO </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
                <hr>
                <h2><strong>RECETA DE URGENCIAS</strong></h2>
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
                    
  <div class="row">
    
    
     <div class="col-sm"> FECHA:
                <?php
                
                $fecha_actual = date("d-m-Y");
                ?>
                <strong><?= $fecha_actual ?></strong>
               
            </div>
   
    <div class="col-sm">
     FECHA DE NACIMIENTO:
                            <td><strong><?php  $fecnac=date_create($f1['fecnac']);
                            echo date_format($fecnac,"d-m-Y") ?></strong></td>
    </div>
    
  </div>                           
  <div class="row">
    <div class="col-sm-5">
       PACIENTE:
<td><strong><?php echo $f1['papell']; ?></strong></td>
                            <td><strong><?php echo $f1['sapell']; ?></strong></td>
                            <td><strong><?php echo $f1['nom_pac']; ?></strong></td>
    </div>
  </div>

<hr>
                        <?php  
                    }
                    ?>             
                        
            </div>
            <div class="col-3">
                <?php
                
                $fecha_actual = date("d-m-Y H:i:s");
                ?>
                <hr>
                <div class="form-group">
                    <label for="fecha">FECHA Y HORA ACTUAL:</label>
                    <input type="datetime" name="fec_hc" value="<?= $fecha_actual ?>" class="form-control" disabled>
                </div>
            </div>
        </div>



          <form action="insertar_receta_urgencias.php?id_atencion=<?php echo $_GET['id_atencion']; ?>&id_usua=<?php echo $_GET['id_usua']; ?>" method="POST">
<br>
<div class="row">
    <div class="col">
        <label>ESPECIALIDAD</label><br>
        <select name="esp" class="form-control" required onchange="habilitar(this.value);">
            <option>SELECCIONAR OPCIÓN</option>
         <!--   <option value="CIRUGIA GENERAL Y GASTROENTEROLOGIA"> CIRUGÍA GENERAL Y GASTROENTEROLOGÍA</option>
            <option value="MEDICINA INTERNA">MEDICINA INTERNA</option>
            <option value="PEDIATRIA">PEDIATRÍA</option>
            <option value="NEUROCIRUGIA">NEUROCIRUGÍA</option>
            <option value="MEDICINA FAMILIAR">MEDICINA FAMILIAR</option> -->
            <option value="OTROS">OTROS</option>
            <?php 
               $result=$conexion->query("SELECT * FROM cat_espec WHERE espec_activo='SI'");
            foreach ($result as $row ){?>
                <option value="<?php echo $row['espec'] ?>"><?php echo $row['espec'] ?></option>
        <?php }?>
        </select>
    </div>
    <div class="col">
        <label>DETALLE ESPECIALIDAD (OTROS)</label><br>
        <input type="text" name="detesp" id="esp"  placeholder="DETALLE ESPECIALIDAD" disabled="" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
    </div>
</div>

<div class="row">
    <div class=" col">
     <div class="form-group">
        <label><strong>ALERGIA A MEDICAMENTOS: </strong></label>
        <input type="text" name="alergias" class="form-control"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
    </div>
</div>
<?php 
$id_at=$_GET['id_atencion'];
include "../../conexionbd.php";
$resultado5=$conexion->query("select * from triage WHERE id_atencion=$id_at ORDER by id_triage DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
      $atencion=$f5['id_triage'];
    }
if (isset($atencion)) {

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from triage WHERE id_atencion=$id_at ORDER by id_triage DESC LIMIT 1") or die($conexion->error);
     while ($f5 = mysqli_fetch_array($resultado5)) {
    ?>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
<div class="container"> 
  <div class="row">
    <div class="col-sm-2"><br><center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" value="<?php echo $f5['p_sistolica'];?>" disabled></div> /
  <div class="col"><input type="text" class="form-control" value="<?php echo $f5['p_diastolica'];?>" disabled></div>
 
</div>
    </div>
    <div class="col-sm-2">
      FRECUENCIA CARDIACA:<input type="text" class="form-control" value="<?php echo $f5['f_card'];?>" disabled>
    </div>
    <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" class="form-control" value="<?php echo $f5['f_resp'];?>" disabled>
    </div>
    <div class="col-sm-2">
     <br>TEMPERATURA:<input type="text" class="form-control" value="<?php echo $f5['temp'];?>" disabled>
    </div>
    <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="text"  class="form-control" value="<?php echo $f5['sat_oxigeno'];?>" disabled>
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" class="form-control" value="<?php echo $f5['peso'];?>" disabled>
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" class="form-control" value="<?php echo $f5['talla'];?>" disabled>
    </div>
  </div>
</div>
<?php }} ?><br>
<div class="row">
    <div class=" col">
     <div class="form-group">
    <label> <strong>MEDICAMENTOS:</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="25" name="receta_urgen" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
    </div>
</div>
<div class="row">
    <div class=" col">
     <div class="form-group">
        <label><strong>MEDIDAS HIGIÉNICO-DIETÉTICAS: </strong></label>
        <input type="text" name="med" class="form-control"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
    </div>
</div>
<strong><label> FECHA Y HORA DE PROXIMA CITA</label></strong>
<div class="row">
    <div class="col-sm-4">
        <input type="date" name="fec_pcita" class="form-control">
    </div>
    <div class="col-sm-4">
        <input type="time" name="hor_pcita" class="form-control">
    </div>
</div>
<?php  
$usuario = $_SESSION['login'];
?>
<hr>

  <div class="row">
    <div class="col align-self-start">
   <strong>NOMBRE DEL MÉDICO:</strong> <input type="text" name="" class="form-control" value="<?php echo $usuario['nombre'];?> <?php echo $usuario['papell'];?> <?php echo $usuario['sapell'];?>" disabled> 
    </div>
    <div class="col align-self-center">
      <strong>CÉDULA PROFESIONAL:</strong><input type="text" name="" class="form-control" value="<?php echo $usuario['cedp'];?>" disabled="">
      
    </div> 
    <div class="col align-self-end">
     <strong>REGISTRO S.S.A:</strong><input type="text" name="reg_ssa_urgen" class="form-control"> 
    </div>
  </div><br>
<center><strong>FIRMA DIGITALIZADA:<br></strong><img src="../../imgfirma/<?php echo $usuario['firma']; ?>" width="100" /></center>
<hr>
<div class="container">
  <div class="row">
    <div class="col align-self-start">
    </div>
     <button type="submit" class="btn btn-primary">FIRMAR Y GUARDAR</button> &nbsp;
<button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button>
    <div class="col align-self-end">
    </div>
  </div>
</div>



<br>
<br>
</form>


   <!--TERMINO DE NOTA DE EVOLUCION-->


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