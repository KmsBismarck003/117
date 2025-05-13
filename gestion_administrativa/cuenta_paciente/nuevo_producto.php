<?php
session_start();
//include "../../conexionbd.php";
include "../header_facturacion.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];
$id_usua=$usuario['id_usua'];
//$id_at = $_GET['id_atencion'];
if (isset($_GET['id_datfin'])) {
  $id_datfin=$_GET['id_datfin'];
}else{

}


include "conexionbdf.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
 <link rel="stylesheet" type="text/css" href="../../gestion_medica/hospitalizacion/css/select2.css">
 <script src="../../gestion_medica/hospitalizacion/js/select2.js"></script>
   <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <script src="jquery-3.1.1.min.js"></script>
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


  <title>Facturación</title>
  
</head>

<body>
  

  <div class="container">
    <form action="" method="POST">
  <section class="content container-fluid">
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 22px;">
<strong><center>NUEVO PRODUCTO</center></strong>
</div>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm text-bold">
*Clave de producto-servicio
<select name="c_prodserv" class="form-control" data-live-search="true" id="mibuscador11" onchange="ShowSelected();" style="width : 100%; heigth : 100%" required>
            <option value="">Seleccionar Clave de producto-servicio</option>
<?php

$sql_diag="SELECT * FROM c_claveprodserv ORDER by id_cveps";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
echo "<option value='" . $row['c_claveprodserv'] . "'>" . $row['c_claveprodserv'] . "- " .$row['Descripcion']."</option>";
}
 ?></select>
</div>
<div class="col-sm-1">
  </div>
<div class="col-sm text-bold">
Descripción
<input class="form-control" name="descripcion" required>
</div>
</div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm text-bold">
*Clave de unidad
<select name="c_unidad" class="form-control" data-live-search="true" id="mibuscador1" onchange="ShowSelected();" style="width : 100%; heigth : 100%">
            <option value="">Seleccionar Clave de unidad</option>
<?php

$sql_diag="SELECT * FROM c_claveunidad ORDER by Id_cveuni";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
echo "<option value='" . $row['c_cveuni'] . "'>" . $row['c_cveuni'] . "- " .$row['Descripcion']."</option>";
}
 ?></select>
</div>
<div class="col-sm-1">
  </div>
<div class="col-sm text-bold">
Precio
<input class="form-control" name="precio">
</div>
</div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm text-bold">
Número de identificación
<input class="form-control" name="num_iden">
</div>
<div class="col-sm-1">
  </div>
<div class="col-sm text-bold">
Unidad
<input class="form-control" name="unidad">
</div>
</div>
<hr>
<center>
  <a href="cat_productos.php "class="btn btn-danger" type="submit" rol="button">Regresar </a>
<button class="btn btn-primary" type="submit" value="guardar" name="guardar" rol="button">Guardar </button>
</center>
</div>

</section>

</form>
</div>

<?php 

 if (isset($_POST['guardar'])) {


//$fecha_actual = date("Y-m-d H:i:s");

$c_prodserv= mysqli_real_escape_string($conexion, (strip_tags($_POST["c_prodserv"], ENT_QUOTES)));
$descripcion= mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES)));

$insertcon=mysqli_query($conexion,'INSERT INTO c_claveprodserv(c_claveprodserv,Descripcion) values ("'.$c_prodserv.'","'.$descripcion.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));
  echo '<script type="text/javascript">window.location.href ="cat_productos.php";</script>';

} 

 ?>


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
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>

  <script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador11').select2();
    });
   $(document).ready(function () {
        $('#mibuscador1').select2();
    });
</script>

 


</body>
</html>