<?php
session_start();
include "../../conexionbd.php";
include "../../configuracion/header_configuracion.php";

if( isset($_GET['id_simg'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
  $resultado = $conexion ->query("SELECT * FROM img_sistema WHERE id_simg=".$_GET['id_simg'])or die($conexion->error);
  if(mysqli_num_rows($resultado) > 0 ){ //se mostrara si existe mas de 1
    $f=mysqli_fetch_row($resultado);

  }else{
    header("location: alta_usuarios.php"); //te regresa a la página principal
  }
}else{
  header("location: alta_usuarios.php"); //te regresa a la página principal
}
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
    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function(){
            $("#search").keyup(function(){
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function() {
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
    </script>

</head>

<body>
<div class="container-fluid">
    <form action="" method="POST" enctype="multipart/form-data"> 
    <div class="row">       
                
         </div> 
        
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
            <tr><strong><center>EDITAR IMAGENES</center></strong>
      </div><br>
<div class="container-fluid">
     

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
<div class="col-sm-4"><br>
    <label for="img_dpdf"><strong><font size="2">Imagen derecha de pdf</font></strong></label>
    <input type="file" class="form-control-file" id="img_dpdf" name="img_dpdf">
</div>
<div class="col-sm-4"><br>
    <label for="img_cuerpo"><strong><font size="2">Imagen del body (cuerpo)</font></strong></label>
    <input type="file" class="form-control-file" id="img_cuerpo" name="img_cuerpo">
</div>
             </div>                
       </div>
<hr>

    <center>
            <button type="submit" name="editar" class="btn btn-success">Guardar</button>
            <a href="imgsistema.php" class="btn btn-danger">Cancelar</a>
    </center>

</form>
</div>
<br>

<?php
if (isset($_POST['editar'])) {
        
//imagen1 EDITAR
    if($_FILES['img_base']['name']!=''){
    $nombr = $_FILES['img_base']['name'];
    $carpeta="img/";
//imagen1.jpg
            $temp=explode('.' ,$nombr);
        $extension= end($temp);
        $img=time().'.'.$extension;

        if($extension=='jpg' || $extension=='png' || $extension=='jpeg'|| $extension=='PNG' || $extension=='JPEG' || $extension=='JPG'){

        if(move_uploaded_file($_FILES['img_base']['tmp_name'], $carpeta.$img)){
            $fila= $conexion->query('select img_base from img_sistema where id_simg='.$_GET['id_simg']);
            $id=mysqli_fetch_row($fila);
            if(file_exists('img/'.$id[0])){
            unlink('img/'.$id[0]);
                }
            $conexion->query("update img_sistema set img_base='".$img."' where id_simg=".$_GET['id_simg']);
                }
            }//llave tipo archivo
        }    //llave si no esta vacio

//img2 EDITAR
        if($_FILES['img_ipdf']['name']!=''){
    $nombrf = $_FILES['img_ipdf']['name'];
    $carpetaf="img2/";

        $tempf=explode('.' ,$nombrf);
        $extensionf= end($tempf);
        $imgf=time().'.'.$extensionf;

        if($extensionf=='jpg' || $extensionf=='png' || $extensionf=='jpeg' || $extensionf=='JPG' || $extensionf=='PNG' || $extensionf=='JPEG'){

        if(move_uploaded_file($_FILES['img_ipdf']['tmp_name'], $carpetaf.$imgf)){
            $filaf= $conexion->query('select img_ipdf from img_sistema where id_simg='.$_GET['id_simg']);
            $id=mysqli_fetch_row($filaf);
            if(file_exists('img2/'.$id[0])){
            unlink('img2/'.$id[0]);
                }
            $conexion->query("update img_sistema set img_ipdf='".$imgf."' where id_simg=".$_GET['id_simg']);
                }
            }//llave tipo archivo
        }    //llave si no esta vacio

//imagen3
        //img2 EDITAR
        if($_FILES['img_cpdf']['name']!=''){
    $nombrff = $_FILES['img_cpdf']['name'];
    $carpetaff="img3/";

        $tempff=explode('.' ,$nombrff);
        $extensionfc= end($tempff);
        $imgfc=time().'.'.$extensionfc;

        if($extensionfc=='jpg' || $extensionfc=='png' || $extensionfc=='jpeg' || $extensionfc=='JPG' || $extensionfc=='PNG' || $extensionfc=='JPEG'){

        if(move_uploaded_file($_FILES['img_cpdf']['tmp_name'], $carpetaff.$imgfc)){
            $filafa= $conexion->query('select img_cpdf from img_sistema where id_simg='.$_GET['id_simg']);
            $ida=mysqli_fetch_row($filafa);
            if(file_exists('img3/'.$ida[0])){
            unlink('img3/'.$ida[0]);
                }
            $conexion->query("update img_sistema set img_cpdf='".$imgfc."' where id_simg=".$_GET['id_simg']);
                }
            }//llave tipo archivo
        }    //llave si no esta vacio

//imagen4derecha
        //img2 EDITAR
        if($_FILES['img_dpdf']['name']!=''){
    $nombrff = $_FILES['img_dpdf']['name'];
    $carpetaff="img4/";

        $tempff=explode('.' ,$nombrff);
        $extensionfc= end($tempff);
        $imgfc=time().'.'.$extensionfc;

        if($extensionfc=='jpg' || $extensionfc=='png' || $extensionfc=='jpeg' || $extensionfc=='JPG' || $extensionfc=='PNG' || $extensionfc=='JPEG'){

        if(move_uploaded_file($_FILES['img_dpdf']['tmp_name'], $carpetaff.$imgfc)){
            $filafa= $conexion->query('select img_dpdf from img_sistema where id_simg='.$_GET['id_simg']);
            $ida=mysqli_fetch_row($filafa);
            if(file_exists('img4/'.$ida[0])){
            unlink('img4/'.$ida[0]);
                }
            $conexion->query("update img_sistema set img_dpdf='".$imgfc."' where id_simg=".$_GET['id_simg']);
                }
            }//llave tipo archivo
        }    //llave si no esta vacio

//imagen5body
        //img2 EDITAR
        if($_FILES['img_cuerpo']['name']!=''){
    $nombrff = $_FILES['img_cuerpo']['name'];
    $carpetaff="img5/";

        $tempff=explode('.' ,$nombrff);
        $extensionfc= end($tempff);
        $imgfc=time().'.'.$extensionfc;

        if($extensionfc=='jpg' || $extensionfc=='png' || $extensionfc=='jpeg' || $extensionfc=='JPG' || $extensionfc=='PNG' || $extensionfc=='JPEG'){

        if(move_uploaded_file($_FILES['img_cuerpo']['tmp_name'], $carpetaff.$imgfc)){
            $filafa= $conexion->query('select img_cuerpo from img_sistema where id_simg='.$_GET['id_simg']);
            $ida=mysqli_fetch_row($filafa);
            if(file_exists('img5/'.$ida[0])){
            unlink('img5/'.$ida[0]);
                }
            $conexion->query("update img_sistema set img_cuerpo='".$imgfc."' where id_simg=".$_GET['id_simg']);
                }
            }//llave tipo archivo
        }    //llave si no esta vacio

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location ="imgsistema.php"</script>';
      }
?>
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