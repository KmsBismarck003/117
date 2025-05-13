<?php
//session_start();
include "../../conexionbd.php";
if( isset($_GET['Id_exp'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
  $resultado = $conexion ->query("SELECT * FROM paciente WHERE Id_exp=".$_GET['Id_exp'])or die($conexion->error);
  if(mysqli_num_rows($resultado) > 0 ){ //se mostrara si existe mas de 1
    $f=mysqli_fetch_row($resultado);

  }else{
    header("Location: menu_d_i.php"); //te regresa a la página principal
  }
}else{
  header("Location: menu_d_i.php"); //te regresa a la página principal
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<!--  Bootstrap  -->
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />

<title>Datos de ingreso </title>
<link rel="shortcut icon" href="logp.jpg">
</head>
<br>
<div class="container">

</div>
<body>
<div class="container-fluid">

        <div class="col  col-12">
            <center>
                <h2>
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>

                    <font id="letra"> Admisión de paciente</font></h2>

            </center>

 <div class="row">
    <div class="col">
       No. Expediente: <strong><?php echo $f[0];?></strong> <br>
     Nombre del paciente: <strong><?php echo $f[2];?>
      <?php echo $f[3];?>
      <?php echo $f[4];?></strong><br>
      
Fecha de Nacimiento:<strong> <?php  $date = date_create($f[5]);
 echo date_format($date,"d/m/Y");?></strong>
    </div>
  
  </div>



<br>
<div class="container"> 
<div class="row">
  <div class="col-6"><button type="button" class="btn btn-primary col-md-5" data-toggle="modal" data-target="#exampleModal">
  <i class="fa fa-plus"></i><font id="letra"> NUEVA ADMISIÓN</font></button></div>
</div>
            <div class="text-center">
  </div>
  <br>
            <table class="table table-responsive table-hover">
  <thead class="thead">
    <tr> 
      <th scope="col">Fecha de Admisión</th>
      <th scope="col">Especialidad</th>
      <th scope="col">Área</th>
      <th scope="col">Motivo de Atención</th>
      <th scope="col">Alta Médica</th>
      <th scope="col">Alta Administrativa</th>
      <th scope="col">Fecha de Egreso</th>
<th scope="col">Hora de Egreso</th>
<th scope="col">Motivo de Alta</th>
  
    </tr>
  </thead>
  <!-- Modal Insertar -->
  <!-- Modal Insertar -->
  <!-- Modal Insertar -->
  <!-- Modal Insertar -->
  <!-- Modal Insertar -->
  <!-- Modal Insertar -->
  <!-- Modal Insertar -->
  <!-- Modal Insertar -->
</table>
        </div>
    </div>
</div>




<!-- Modal Insertar -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="insertar_ingreso.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">NUEVA ADMISIÓN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      
      </div>
      <div class="modal-body">
 No. Expediente: <strong><?php echo $f[0];?></strong> <br>
     Nombre del paciente: <strong><?php echo $f[2];?>
      <?php echo $f[3];?>
      <?php echo $f[4];?></strong><br>
Fecha de Nacimiento:<strong> <?php $date = date_create($f[5]);
 echo date_format($date,"d/m/Y");?></strong><hr>
<?php

$fecha_actual=date("d-m-Y H:i:s");
?>
 <div class="form-group">
            <label for="fecha">Fecha y Hora del Sistema</label>
            <input type="datetime" name="fecha" value="<?= $fecha_actual?>" class="form-control" disabled>
          </div>   

 <div class="form-group">
            <label for="Id_exp">Número de expediente: </label>
            
          </div>

<?php $id_ingreso=$_GET['Id_exp'];?>
<input type="text" name="Id_exp" class="form-control" value="<?php echo $id_ingreso?>" readonly  placeholder="No. De expediente" >
<div class="form-group">
<label for="id_usua">Doctores:</label>
<select name="id_usua"class="form-control" required >
<?php
 $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where id_rol=2")or die($conexion->error);
?>
<option value="">Seleccionar doctor</option>
<?php foreach ($resultado1 as $opciones):?>


	<option value="<?php echo $opciones['id_usua']?>"><?php echo $opciones['nombre']?> <?php echo $opciones['papell']?> <?php echo $opciones['sapell']?></option>
	
	<?php endforeach?>
</select>
</div>
<div class="form-group">
<label for="especialidad">Especialidad:</label>
<select name="especialidad"class="form-control" required >
<option value="">Seleccionar Especialidad</option>
	<option value="ANGIOLOGÍA">ANGIOLOGÍA</option>
	<option value="ALGOLOGÍA">ALGOLOGÍA</option>
	<option value="ALERGOLOGÍA">ALERGOLOGÍA</option>
	<option value="CARDIOLOGÍA">CARDIOLOGÍA</option>
	<option value="CIRUGÍA BARIÁTRICA">CIRUGÍA BARIÁTRICA</option>
	<option value="CIRUGÍA GENERAL">CIRUGÍA GENERAL</option>
	<option value="CIRUGÍA PLÁSTICA">CIRUGÍA PLÁSTICA</option>
	<option value="DENTISTAS">DENTISTAS</option>
	<option value="FUNCIÓN VISUAL">FUNCIÓN VISUAL (AGUDEZA VISUAL)</option>
	<option value="GASTOENTEROLOGÍA">GASTOENTEROLOGÍA</option>
	<option value="GERIATRIA">GERIATRIA</option>
	<option value="GINECOLOGÍA">GINECOLOGÍA</option>
	<option value="HOMEOPATÍA">HOMEOPATÍA</option>
	<option value="MEDICINA CRÍTICA">MEDICINA CRÍTICA</option>
	<option value="MEDICINA INTERNA">MEDICINA INTERNA</option>
	<option value="MEDICINA GENERAL">MEDICINA GENERAL</option>
	<option value="NUTRICIÓN">NUTRICIÓN</option>
	<option value="ONCOLOGÍA">ONCOLOGÍA</option>
	<option value="OFTALMOLOGÍA">OFTALMOLOGÍA</option>
	<option value="OTORRINOLARINGOLOGÍA">OTORRINOLARINGOLOGÍA</option>
	<option value="PEDIATRÍA">PEDIATRÍA</option>
	<option value="PROCTOLOGÍA">PROCTOLOGÍA</option>
	<option value="PSICOLOGÍA">PSICOLOGÍA</option>
	<option value="PSIQUIATRÍA">PSIQUIATRÍA</option>
	<option value="TRAUMATOLOGÍA">TRAUMATOLOGÍA</option>
	<option value="UROLOGÍA">UROLOGÍA</option>
</select>
</div>


<div class="form-group">
<label for="area">Area:</label>
<select name="area"class="form-control" required >
<option value="">Seleccionar Área</option>
	<option value="CONSULTA EXTERNA">CONSULTA EXTERNA</option>
	<option value="HOSPITALIZACIÓN">HOSPITALIZACIÓN</option>
	<option value="CLÍNICAS DE ESPECIAlIDAD">CLÍNICAS DE ESPECIAlIDAD</option>
	<option value="TRIAGE">TRIAGE</option>
	<option value="URGENCIAS OBSERVACIÓN">OBSERVACIÓN</option>
	<option value="URGENCIAS CHOQUE">CHOQUE</option>
</select>
</div>

<div class="form-group">
<label for="motivo_atn">Motivo de Atención:</label>
<select name="motivo_atn"class="form-control" required >
<option value="">Seleccionar Motivo de Atención</option>
	<option value="ACCIDENTE">ACCIDENTE</option>
	<option value="ENVENENAMIENTO">ENVENENAMIENTO</option>
	<option value="VIOLENCIA">VIOLENCIA</option>
	<option value="ATENCIÓN MÉDICA">ATENCIÓN MÉDICA</option>
	<option value="ATENCIÓN QUIRURGICA">ATENCIÓN QUIRURGICA</option>
	<option value="PROGRAMADO">PROGRAMADO</option>
	<option value="INTOXICACIÓN">INTOXICACIÓN</option>
	<option value="LESIÓN">LESIÓN</option>
	<option value="EMBARAZO">EMBARAZO</option>
	<option value="OTRAS CAUSAS">OTRAS CAUSAS</option>
</select>
</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">REGRESAR</button>
        <button type="submit" class="btn btn-primary">GUARDAR</button>
      </div>
    </div>
    </form>
  </div>
</div>
      <script>

document.oncontextmenu = function(){return false;}

</script>
</body>
</html>