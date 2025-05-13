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

    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function() {
            $("#search").keyup(function() {
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function() {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
    </script>
  <title>Facturación</title>
  
</head>

<body>
  

  <div class="container">

   <div class="col-sm-2">
            <a type="submit" class="btn btn-danger btn-sm" onclick="history.back()"><font color="white">Regresar</font></a>
        </div>  
        
          <div class="form-group">
                    <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
                </div>

    
  <section class="content container-fluid">
      
<a class="btn btn-primary" href="nuevo_cliente.php">Nuevo Cliente</a>
<p>
<table class="table table-striped" id="mytable">
                <thead class="thead" style="background-color: #2b2d7f; color:white;">
             
                    <th scope="col">RFC</th>
                    <th scope="col">Razón social</th>
                    <th scope="col">Calle</th> 
                    <th scope="col">No. Exterior</th>
                    <th scope="col">No. Interior</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Municipio</th>
                    <th scope="col">Código postal</th>
                    <!--<th scope="col">Asentamiento</th>-->
                    <th scope="col">Régimen fiscal</th>
                    <th scope="col">Editar</th>
                       
                 
                </tr>
                </thead>

                <tbody>
                  <?php 


$resultado = $conexion->query("SELECT * from c_cliente") or die($conexion->error);

              while ($row = $resultado->fetch_assoc()) { 
               ?>
                  <tr> 
                   
<td class="fondo"><strong><font size="4"><?php echo $row['rfc'];?></font></strong></td>
<td class="fondo"><strong><font size="4"><?php echo $row['razon_s'];?></font></strong></td>
<td class="fondo"><strong><font size="4"><?php echo $row['calle'];?></font></strong></td>
<td class="fondo"><strong><font size="4"><?php echo $row['no_ext'];?></font></strong></td>
<td class="fondo"><strong><font size="4"><?php echo $row['no_int'];?></font></strong></td>
<td class="fondo"><strong><font size="4"><?php echo $row['estado'];?></font></strong></td>
<td class="fondo"><strong><font size="4"><?php echo $row['municipio'];?></font></strong></td>
<td class="fondo"><strong><font size="4"><?php echo $row['cod_postal'];?></font></strong></td>
<!--<td class="fondo"><strong><font size="4"><?php echo $row['asentamiento'];?></font></strong></td>-->
<td class="fondo"><strong><font size="4"><?php echo $row['reg_fiscal'];?></font></strong></td>
<td> <a href="editar_cliente.php?id_cliente=<?php echo $row['id_c_cliente']?>" title="Editar cliente" class="btn btn-warning btn-sm "><span class="fa fa-edit" aria-hidden="true"></span></a></td>
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