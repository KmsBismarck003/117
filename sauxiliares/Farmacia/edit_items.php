<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

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
            <h1>Editar Productos</h1>
            <?php
            $id = $_GET['id'];

            $sql = "SELECT item_id, item_name,item_price, item_type_id, item_code,item_brand,item_grams from item where item_id = $id";
            $result = $conexion->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                  <label class="control-label col-sm-6" for="">NOMBRE DEL PRODUCTO:</label>
                  <div class="col-sm-9">
                    <input type="text" maxlength="50" name="nomproducto" class="form-control" id="item-name" placeholder="Ingresa el nombre generico" value="<?php echo $row_datos['item_name']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="">PRECIO:</label>
                  <div class="col-sm-9">
                    <input type="number" min="0.1" name="precio" step="any" class="form-control" id="item-price" placeholder="Ingresa el precio" value="<?php echo $row_datos['item_price']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-3" for="">CÓDIGO:</label>
                  <div class="col-sm-9">
                    <input type="text" maxlength="50" name="codigo" class="form-control" id="code" placeholder="Ingresa el código" value="<?php echo $row_datos['item_code']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-3" for="">FABRICANTE:</label>
                  <div class="col-sm-9">
                    <input type="text" maxlength="50" name="fabricante" class="form-control" id="brand" placeholder="Ingresa el fabricante" value="<?php echo $row_datos['item_brand']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-6" for="">CONTENIDO MG/ML:</label>
                  <div class="col-sm-9">
                    <input type="number" min="0" name="contenido" maxlength="50" class="form-control" id="grams" placeholder="Ingresa los gramos" value="<?php echo $row_datos['item_grams']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-3" for="">TIPO:</label>
                  <div class="col-sm-9">
                    <select id="item-type" class="btn btn-default" name="tipo">
                      <?php
                      $query = "SELECT * FROM `item_type`";
                      $result = $conexion->query($query);
                      //$result = mysql_query($query);
                      while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['item_type_id'] . "'>" . $row['item_type_desc'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">&nbsp;</label>
                  <div class="col-sm-12">
                    <a href="../Farmacia/lista_productos.php" class="btn btn-danger">CANCELAR</a>
                    <input type="submit" name="edit" class="btn btn-success" value="GUARDAR">

                  </div>
                </div>


          </div>
        <?php } ?>
        </form>
        </div>
        <div class="col-md-2"></div>
      </div>
      <?php

      if (isset($_POST['edit'])) {

        $prod_nombre    = mysqli_real_escape_string($conexion, (strip_tags($_POST["nomproducto"], ENT_QUOTES))); //Escanpando caracteres
        $prod_precio    = mysqli_real_escape_string($conexion, (strip_tags($_POST["precio"], ENT_QUOTES))); //Escanpando caracteres
        $prod_codigo   = mysqli_real_escape_string($conexion, (strip_tags($_POST["codigo"], ENT_QUOTES))); //Escanpando caracteres
        $prod_fabricante    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fabricante"], ENT_QUOTES))); //Escanpando caracteres
        $prod_contenido    = mysqli_real_escape_string($conexion, (strip_tags($_POST["contenido"], ENT_QUOTES)));
        $prod_tipo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES)));

        $sql2 = "UPDATE item SET item_name = '$prod_nombre', item_price = $prod_precio, item_code = '$prod_codigo', item_brand = '$prod_fabricante' , item_grams = '$prod_contenido', item_type_id = $prod_tipo  WHERE item_id = $id";
        // echo $sql2;
        // return 'hbgk';
        $result = $conexion->query($sql2);
        echo '<script type="text/javascript">window.location ="lista_productos.php"</script>';
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