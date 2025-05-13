<?php
session_start();
include "../../conexionbd.php";
include "../../configuracion/header_configuracion.php";
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
    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
   

</head>
<body>
<div class="thead" style="background-color: #2b2d72; color: white; font-size: 20px;">
<tr><strong><center>IMAGENES DEL SISTEMA</center></strong>
</div><br>

<?php 
$id_simg=0;
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_simg=$f['id_simg'];
   }
?>
<?php if ($id_simg>=1) {
    
}else{

    ?>

<div class="container-fluid">
<form action="" method="POST" enctype="multipart/form-data"> 
<div class="container">
<div class="row">
<div class="col-sm-4">  
    <label for="img_base"><strong><font size="2">Imagen del perfil</font></strong></label>
    <input type="file" class="form-control-file" id="img_base" name="img_base">
</div>
<div class="col-sm-4">
    <label for="img_ipdf"><strong><font size="2">Imagen izquierda de pdf</font></strong></label>
    <input type="file" class="form-control-file" id="img_ipdf" name="img_ipdf">
</div>
<div class="col-sm-4">
    <label for="img_cpdf"><strong><font size="2">Imagen central de pdf</font></strong></label>
    <input type="file" class="form-control-file" id="img_cpdf" name="img_cpdf">
</div>
</div>                
</div>

<hr>
<div class="container">
  <div class="row">
   <div class="col-sm-4">
    <label for="img_dpdf"><strong><font size="2">Imagen derecha de pdf</font></strong></label>
    <input type="file" class="form-control-file" id="img_dpdf" name="img_dpdf">
</div>
  <div class="col-sm-4">
    <label for="img_cuerpo"><strong><font size="2">Imagen del body (cuerpo)</font></strong></label>
    <input type="file" class="form-control-file" id="img_cuerpo" name="img_cuerpo">
</div>
  </div>
</div>
<hr>
<center><button type="submit" name="guardar" class="btn btn-success">Guardar</button></center>
</form>
</div>
<?php } ?>
<br>

<?php
if (isset($_POST['guardar'])) {

$name = $_FILES['img_base']['name'];
  $carpeta = "img/";
  $temp = explode('.', $name);
  $extension = end($temp);
  $nombreFinal = time() . '.' . $extension;

  $trasera = $_FILES['img_ipdf']['name'];
  $carpetatrasera = "img2/";
  $temptrasera = explode('.', $trasera);
  $extensiontrasera = end($temptrasera);
  $nombreFinaltrasera = time() . '.' . $extensiontrasera;

  $namer = $_FILES['img_cpdf']['name'];
  $carpetar = "img3/";
  $tempr = explode('.', $namer);
  $extensionr = end($tempr);
  $nombreFinalr = time() . '.' . $extensionr;

  $traserar = $_FILES['img_dpdf']['name'];
  $carpetatraserar = "img4/";
  $temptraserar = explode('.', $traserar);
  $extensiontraserar = end($temptraserar);
  $nombreFinaltraserar = time() . '.' . $extensiontraserar;

  $cuerpo = $_FILES['img_cuerpo']['name'];
  $carpeta5 = "img5/";
  $temptcu = explode('.', $cuerpo);
  $extensioncu = end($temptcu);
  $nombrecuerpo = time() . '.' . $extensioncu;

  if ($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg' || $extension == 'PNG' || $extension == 'JPG' || $extension == 'JPEG') {
    if (move_uploaded_file($_FILES['img_base']['tmp_name'], $carpeta . $nombreFinal)) {
      if (move_uploaded_file($_FILES['img_ipdf']['tmp_name'], $carpetatrasera . $nombreFinaltrasera)) {
        if (move_uploaded_file($_FILES['img_cpdf']['tmp_name'], $carpetar . $nombreFinalr)) {
          if (move_uploaded_file($_FILES['img_dpdf']['tmp_name'], $carpetatraserar . $nombreFinaltraserar)) {
            if (move_uploaded_file($_FILES['img_cuerpo']['tmp_name'], $carpeta5 . $nombrecuerpo)) {

    $ingresar = mysqli_query($conexion,'insert into img_sistema(img_base,img_ipdf,img_cpdf,img_dpdf,img_cuerpo) values ("' . $nombreFinal . '","' . $nombreFinaltrasera . '","' . $nombreFinalr . '","' . $nombreFinaltraserar . '","' . $nombrecuerpo . '")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

echo '<script type="text/javascript">window.location ="imgsistema.php"</script>';
         //header('location: imgsistema.php');

      
          
          }else {
            echo 'Error';
                 } //si no se enviaron datos
        } else {
          echo 'Error';
                }
      } else {
        echo 'Error';
            }
    } else {
      echo 'Error';
        }     
  } else{
echo 'Error';
      }
  }
}
?>
<div class="table-responsive">
<div class="container">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
              
                    <th scope="col">Imagen del perfil</th>
                    <th scope="col">Imagen izquierda de pdf</th>
                    <th scope="col">Imagen central de pdf</th>
                    <th scope="col">Imagen derecha de pdf</th>
                    <th scope="col">Imagen del body (cuerpo)</th>
                    <th scope="col">Editar</th>
                </tr>
                </thead>
                <tbody>

<?php
include "../../conexionbd.php";

$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_simg=$f['id_simg'];
?>          
                    <tr>

<td class="fondo"><img src="img/<?php echo $f['img_base']?>" alt="User Image" width="90"></td>
<td class="fondo"><img src="img2/<?php echo $f['img_ipdf']?>" alt="User Image" width="90"></td>
<td class="fondo"><img src="img3/<?php echo $f['img_cpdf']?>" alt="User Image" width="90"></td>
<td class="fondo"><img src="img4/<?php echo $f['img_dpdf']?>" alt="User Image" width="90"></td>
<td class="fondo"><img src="img5/<?php echo $f['img_cuerpo']?>" alt="User Image" width="70"></td>

<td class="fondo"><a href="editar_img.php?id_simg=<?php echo $f['id_simg'];?>"><button type="button" class="btn btn-warning"> <i class="fa fa-edit" style="font-size:28px"  aria-hidden="true"></i> </button></td>
                    </tr>
                    <?php
}
    
                ?>
                
                </tbody>
              
            </table>
</div>
            </div>
 </div>
<footer class="main-footer">
<?php
include("../../template/footer.php");
?>
</footer>
<script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
</body>
</html>