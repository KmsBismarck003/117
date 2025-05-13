<?php
session_start();
require "../../estados.php";
include "../../conexionbd.php";
include "../header_administrador.php";
if( isset($_GET['Id_exp'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
  $resultado = $conexion ->query("SELECT * FROM paciente WHERE Id_exp=".$_GET['Id_exp'])or die($conexion->error);
  if(mysqli_num_rows($resultado) > 0 ){ //se mostrara si existe mas de 1
    $f=mysqli_fetch_row($resultado);

  }else{
    header("location: registro_pac.php"); //te regresa a la página principal
  }
}else{
  header("location: registro_pac.php"); //te regresa a la página principal
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function () {
            $("#search").keyup(function () {
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function () {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
    </script>
    <title>AGREGAR INE</title>
    <link rel="shortcut icon" href="logp.png">
</head> 
<body>
<div class="container">
	 <div class="row">
    <div class="col">
       Expediente: <strong><?php echo $f[0];?></strong> <br>
       Paciente: <strong><?php echo $f[2];?>
      <?php echo $f[3];?>
      <?php echo $f[4];?></strong><br>
      
Fecha de nacimiento:<strong> <?php  $date = date_create($f[5]);
 echo date_format($date,"d/m/Y");?></strong>
    </div>
  
  </div>

    <form action="insertar_ine.php?Id_exp=<?php echo $_GET['Id_exp']; ?>" method="POST" enctype="multipart/form-data">
    	<div class="row">       
                <div class="col-sm-4">
                    <div class="form-group">
                        <?php
                        $Id_exp= $_GET['Id_exp'];
                        ?>
                        <input type="hidden" name="Id_exp" placeholder="EXPEDIENTE" id="Id_exp" class="form-control" value="<?php echo $Id_exp ?>" 
                               disabled>
                    </div>
                </div>
         </div>
         <div>
                        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                 <tr><strong><center>AGREGAR INE</center></strong>
            </div>
           
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                           <h3>PACIENTE:</h3>     
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="img_inef">INE FRONTAL</label>
                                <input type="file" name="img_inef" id="img_inef" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="img_inet">INE TRASERA</label>
                                <input type="file" name="img_inet" id="img_inet" class="form-control">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                            <h3>RESPONSABLE: </h3>
                        </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="img_inefr">INE FRONTAL</label>
                                <input type="file" name="img_inefr" id="img_inefr" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="img_inet">INE TRASERA</label>
                                <input type="file" name="img_inetr" id="img_inetr" class="form-control">
                            </div>
                        </div>
                    </div>
               <center>
                <hr>
                  <button type="button" class="btn btn-danger btn-sm" onclick="history.back()">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>

                </center>
   
    </form>      
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


<script>document.oncontextmenu = function () {
        return false;
    }</script>

</body> 
</html>  