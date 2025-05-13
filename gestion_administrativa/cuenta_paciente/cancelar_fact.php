<?php
session_start();
include "../../conexionbd.php";
include "../../gestion_administrativa/header_administrador.php";
$resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE  dat_ingreso.activo='SI' AND alta_adm = 'NO'") or die($conexion->error);
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
<style>
    hr.new4 {
      border: 1px solid red;
    }
  </style>

    <title>Menu Gestión Administrativa </title>
    <link rel="shortcut icon" href="logp.png">
</head>
<div class="container">
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                 <tr><strong><center>Cancelar factura</center></strong>
</div>

<?php 
if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $in=$_GET['in'];
    $fin=$_GET['fin'];
    ?>
    

            <br><a href="facturas_pacientes.php?anio=<?php echo $in ?>&anifinal=<?php echo $fin ?>"><button type="submit" class="btn btn-success">Regresar</button></a>
      
    
    <form action="" method="POST">
         <div class="row">
        <div class="container">
            <div class="row">
        <div class="col-sm-12"><p></p>
           <strong>Motivo:</strong>
            <input type="text" class="form-control" name="motivo" required>
        </div>
         
         <div class="col-sm-4">
            <br><button type="submit" class="btn btn-danger" name="canca">Cancelar factura</button>
         </div> 
            </div>
        </div>
    </div>
  </form>
  <?php
}
        include "conexionbdf.php";
      if (isset($_POST['canca'])) {
    $motivo= mysqli_real_escape_string($conexion, (strip_tags($_POST["motivo"], ENT_QUOTES)));
$activar = $conexion->query("update comprobantes set estatus='Cancelada', motivo_cance='$motivo' WHERE id_comp=$id") or die($conexion->error);

 echo '<script type="text/javascript">window.location.href ="facturas_pacientes.php?anio='.$in.'&anfinal='.$fin.'" ;</script>';
}

?>

  


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
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador2').select2();
    });
</script>
</body>

</html>


  
       