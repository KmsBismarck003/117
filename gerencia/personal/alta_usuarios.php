<?php
session_start();
include "../conexionbd.php";

$resultado=$conexion->query("select * from reg_usuarios") or die($conexion->error);
?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<!--  Bootstrap  -->
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />
<title>Alta de usuarios </title>
<link rel="shortcut icon" href="logp.png">
</head>
<br>
<div class="container">
  <div class="row">
    <div class="col-sm">
      
    </div>
    <div class="col-8">
      <div class="card" style="width: 26rem; text-align:center;">
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><img class="img-fluid" class="rounded" src="imagenes/logo.jpg" height="190" width="250"></li>
  </ul>
</div>
    </div>
    
  </div>
</div>
<body>

  

<div class="container-fluid">
    <div class="row">
        <div class="col-2 collapse show d-md-flex pt-10 pl-0 min-vh-100" id="sidebar">

            <ul class="nav flex-column flex-nowrap overflow-hidden">
              <li class="nav-item"><a href="index.php"><button class="btn btn-light my-2 my-sm-12 col-12" id="letra"><i class="fa fa-sign-in"></i> Iniciar sesión</button></a></li>
            
        <hr><hr><hr>
               
            </ul>
        </div>
        <div class="col pt-5 col-9">
            <h2>
                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                <center><font id="letra"><i class="fa fa-user-plus"></i> Alta de Usuarios</font></h2></center><hr>


<div class="row">
 
  <div class="col-12">
      <center><button type="button" class="btn btn-primary col-md-" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i><font id="letra"> Nuevo Usuario</font></button></div></center>
</div>
<br><br><br>
            <center><p id="letra">Derechos Reservados</p></center>
        </div>
    </div>
</div>

<!-- Modal Insertar -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="insertar_usuario.php" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      
      </div>
      <div class="modal-body">

 <div class="form-group">
            <label for="curp_u">CURP</label>
            <input type="text" size="18" name="curp_u" placeholder="Curp" id="curp_u" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
          </div> 

 <div class="form-group">
            <label for="rfc">RFC</label>
            <input type="text" size="12" name="rfc" placeholder="RFC" id="rfc" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
          </div> 

      <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre" id="nombre" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
          </div>   
          <div class="form-group">
            <label for="papell">Primer Apellido</label>
            <input type="text" name="papell" placeholder="Primer Apellido" id="papell" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
          </div>
<div class="form-group">
            <label for="sapell">Segundo Apellido</label>
            <input type="text" name="sapell" placeholder="Segundo Apellido" id="sapell" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" required>
          </div>
<div class="form-group">
            <label for="fecha">Fecha de Nacimiento</label>
            <input type="date" name="fecnac" placeholder="Fecha de nacimiento" id="fecha" class="form-control" required>
          </div>

<div class="form-group">
<label for="">Sexo:</label>
<select name="sexo"class="form-control" required >
<option value="">Seleccionar Sexo</option>
<option value="HOMBRE">HOMBRE</option>
<option value="MUJER">MUJER</option>
<option value="SIN INFORMACION">SIN INFORMACION</option>
 	
</select>
</div>

<div class="form-group">
            <label for="mat">Matricula</label>
            <input type="text" size="10" name="mat" placeholder="Matricula" id="mat" class="form-control" required>
          </div>
<div class="form-group">
            <label for="cedp">Cedula Profesional</label>
            <input type="text" name="cedp" placeholder="Cedula profesional" id="cedp" class="form-control" required>
          </div>
<div class="form-group">
            <label for="cargp">Cargo Profesional</label>
            <input type="text" name="cargp" placeholder="Cargo profesional" id="cargp" class="form-control" required>
          </div>
<div class="form-group">
            <label for="tel">Telefono</label>
            <input type="tel"  name="tel" placeholder="Telefono" id="tel" class="form-control" required>
          </div>
<div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="E-mail" id="email" class="form-control" required>
          </div>

        <div class="form-group">
<label for="nacionalidad">Nacionalidad:</label>
<select name="nac"class="form-control" required >
<option value="">Seleccionar Nacionalidad</option>
<option value="MEXICANA">MEXICANA</option>
<option value="EXTRANJERO">EXTRANJERO</option> 	
</select>
</div>

      <div class="form-group">
<label for="pre">Prefijo:</label>
<select name="pre"class="form-control" required >
<option value="">Seleccionar Prefijo</option>
<option value="DRA">DRA</option>
<option value="DR">DR</option> 	
<option value="LIC">LIC</option> 
<option value="ENF">ENF</option> 
<option value="ING">ING</option> 
<option value="NO APLICA">NO APLICA</option> 	
</select>
</div>


<div class="form-group">
            <label for="rol">Rol (puesto)</label>
            <input type="text" name="rol" placeholder="Rol" id="rol" class="form-control" required>
          </div>

<div class="form-group">
            <label for="pass">Contraseña</label>
            <input type="password" name="pass" placeholder="Contraseña" id="pass" class="form-control" required>
          </div>  

          <div class="form-group">
            <label for="img_perfil">Imagen de perfil del Usuario</label>
            <input type="file" name="img_perfil" id="img_perfil" class="form-control">
          </div>
          
          <div class="form-group">
            <label for="firma">Firma</label>
            <input type="file" name="firma" id="firma" class="form-control">
          </div>        
          
          <div class="form-group">
<label for="id_usua">Acceso A:</label>
<select name="id_rol"class="form-control" required >
<?php
 $resultado1 = $conexion ->query("SELECT * FROM rol")or die($conexion->error);
?>
<option value="">Seleccionar acceso</option>
<?php foreach ($resultado1 as $opciones):?>


	<option value="<?php echo $opciones['id_rol']?>"><?php echo $opciones['rol']?></option>
	
	<?php endforeach?>
</select>
</div>

<!--<label>ACCESO A:</label>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
  <label class="form-check-label" for="flexCheckDefault">Enfermeria  </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
  <label class="form-check-label" for="flexCheckDefault">Hospitalizacion</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
  <label class="form-check-label" for="flexCheckDefault">Urgencias</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
  <label class="form-check-label" for="flexCheckDefault">Quirofano</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
  <label class="form-check-label" for="flexCheckDefault">Farmacia</label>
</div>-->


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Regresar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div>







<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>

</body>
</html>