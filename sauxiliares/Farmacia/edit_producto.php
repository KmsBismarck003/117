<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
if ($usuario['id_rol'] == 7) {
    include "../header_farmacia.php";

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_farmacia.php";
} else{
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}
?>

<head>
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

  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</head>

<body>
  <section class="content container-fluid">
    <div class="container box">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <h1>EDITAR PRODUCTO</h1>
            <?php
            $id = $_GET['id'];

            $sql = "SELECT * from item i, item_type it where i.item_id = $id and i.item_type_id=it.item_type_id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="clave">NOMBRE DEL ARTICULO</label>
                  <input type="text" size="30" name="nombre" class="form-control" style="text-transform:uppercase;" value="<?php echo $row_datos['item_name']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                </div>
                <div class="form-group">
                  <label for="clave">PRECIO</label>
                  <input type="text" size="30" name="precio" class="form-control" style="text-transform:uppercase;" value="<?php echo $row_datos['item_price']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                </div>
                <?php } ?>

       <?php
          $id = $_GET['id'];
          $sql = "SELECT * from item i, item_type it where i.item_id = $id and i.item_type_id=it.item_type_id";
          $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
        ?>
                <div class="form-group">
                  <label for="clave">TIPO</label>
                  <select id="cama" name="tipo" class="form-control">
                        <option value="<?php echo $row_datos['item_type_id']; ?>"><?php echo $row_datos['item_type_desc']; ?></option>
         <?php } ?>
         <?php 
                         $id = $_GET['id'];
                           $sql = "SELECT * from item_type ";
                           $result = $conexion->query($sql);
                        foreach ($result as $opciones):?>
                        <option value="<?php echo $opciones['item_type_id']?>"><?php echo $opciones['item_type_desc']?></option>
                   <?php endforeach?>
                  </select>
                </div>
         <?php
            $id = $_GET['id'];

            $sql = "SELECT * from item i, item_type it where i.item_id = $id and i.item_type_id=it.item_type_id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
                <div class="form-group">
                  <label for="clave">CÓDIGO</label>
                  <input type="text" size="30" name="cod" class="form-control" style="text-transform:uppercase;" value="<?php echo $row_datos['item_code']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                </div>
                <div class="form-group">
                  <label for="clave">FABRICANTE</label>
                  <input type="text" size="30" name="fab" class="form-control" style="text-transform:uppercase;" value="<?php echo $row_datos['item_brand']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                </div>
                <div class="form-group">
                  <label for="clave">CONTENIDO</label>
                  <input type="text" size="30" name="cont" class="form-control" style="text-transform:uppercase;" value="<?php echo $row_datos['item_grams']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                </div>
                <div class="form-group">
                  <label for="clave">CONTROLADO</label>
                  <input type="text" size="30" name="contr" class="form-control" style="text-transform:uppercase;" value="<?php echo $row_datos['controlado']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                </div>
                
                   <center><input type="submit" name="edit" class="btn btn-success" value="Guardar Datos">
                    <button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button></center></center> 
                 
          </div>
        <?php } ?>
        </form> 
        </div>
        <div class="col-md-2"></div>
      </div>
      <?php

      if (isset($_POST['edit'])) {
        $id = $_GET['id'];

        $nombre    = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES)));
        $precio    = mysqli_real_escape_string($conexion, (strip_tags($_POST["precio"], ENT_QUOTES)));
        $tipo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES)));
        $cod    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cod"], ENT_QUOTES)));
        $fab    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fab"], ENT_QUOTES)));
        $cont    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cont"], ENT_QUOTES)));
        $contr    = mysqli_real_escape_string($conexion, (strip_tags($_POST["contr"], ENT_QUOTES)));
         //Escanpando caracteres  

          $sql2 = "UPDATE item SET item_name = '$nombre', item_price = '$precio', item_type_id = '$tipo', item_code ='$cod', item_brand = '$fab', item_grams = '$cont', controlado = '$contr'  WHERE item_id = $id";
        $result = $conexion->query($sql2);

        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location.href="lista_productos.php";</script>';
      }
      ?>
    </div>
  </section>
  </div>
  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>


</body>

</html>