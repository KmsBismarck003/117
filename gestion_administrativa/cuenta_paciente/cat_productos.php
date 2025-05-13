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

    

    
  <section class="content container-fluid">
<a class="btn btn-primary" href="nuevo_producto.php">Nuevo producto</a>
<p>
<table class="table table-striped">
                <thead class="thead" style="background-color: #2b2d7f; color:white;">
              
                    <th scope="col">Clave prod/serv</th>
                      <th scope="col">Descripción</th> 
                       
                  <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody>
                  <?php 

$resultado = $conexion->query("SELECT * from c_claveprodserv") or die($conexion->error);
              while ($row = $resultado->fetch_assoc()) { 
               ?>
                  <tr> 
                    <td class="fondo"><strong><font size="4"><?php echo $row['c_claveprodserv'];?></font></strong>
</td>
<td class="fondo"><strong><font size="4"><?php echo $row['Descripcion'];?></font></strong>
</td>


</tr>
<?php } ?>
</tbody>
              
            </table>
</section>
   


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
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>

  <script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador1').select2();
    });   
</script>


</body>
</html>