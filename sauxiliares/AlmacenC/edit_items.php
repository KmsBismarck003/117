<?php
session_start();
include "../../conexionbd.php";
include '../../conn_almacen/Connection.php';

$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];

if ($usuario['id_rol'] == 11) {
    include "../header_almacenC.php";

} else if ($usuario['id_rol'] == 5) {
    include "../header_almacenC.php";
} else{
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}
?>

<head>
  <title>MÉDICA SAN ISIDRO</title>
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
            <h1>EDITAR PRODUCTOS</h1>
            <?php
            $id = $_GET['id'];

            $sql = "SELECT * from item_almacen where item_id = $id";
            $result = $conexion_almacen->query($sql);
            while ($row_datos = $result->fetch_assoc()) {
            ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="control-label col-sm-3" for="">Código:</label>
                  <div class="col-sm-9">
                    <input type="text" maxlength="50" name="codigo" class="form-control" id="item-code" value="<?php echo $row_datos['item_code']; ?>"  required="" autofocus="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-6" for="">Descripción:</label>
                  <div class="col-sm-9">
                    <input type="text" maxlength="100" name="descripcion" class="form-control" id="item-name" value="<?php echo $row_datos['item_name']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                </div>
                    <div class="form-group">
                  <label class="control-label col-sm-6" for="">Contenido:</label>
                  <div class="col-sm-9">
                    <input type="text" name="contenido" maxlength="100" class="form-control" id="item-grams" value="<?php echo $row_datos['item_grams']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="">Costo:</label>
                  <div class="col-sm-9">
                    <input type="number" min="0.0O" name="costo" step="any" class="form-control" id="item-cost" value="<?php echo $row_datos['item_cost']; ?>" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="">Precio de venta 1:</label>
                  <div class="col-sm-9">
                    <input type="number" min="0.00" name="precio1" step="any" class="form-control" id="item-price" value="<?php echo $row_datos['item_price']; ?>" required="">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="control-label col-sm-3" for="">Precio de venta 2:</label>
                  <div class="col-sm-9">
                    <input type="number" min="0.00" name="precio2" step="any" class="form-control" id="item-price2" value="<?php echo $row_datos['item_price2']; ?>" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="">Precio de venta 3:</label>
                  <div class="col-sm-9">
                    <input type="number" min="0.00" name="precio3" step="any" class="form-control" id="item-price3" value="<?php echo $row_datos['item_price3']; ?>" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="">Precio de venta 4:</label>
                  <div class="col-sm-9">
                    <input type="number" min="0.00" name="precio4" step="any" class="form-control" id="item-price4" value="<?php echo $row_datos['item_price4']; ?>" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="">Presentación:</label>
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
                  <label class="control-label col-sm-3" for="">Controlado:</label>
                  <div class="col-sm-9">
                    <input type="text" maxlength="50" name="controla" class="form-control" id="controlado" value="<?php echo $row_datos['controlado']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                </div>
                
                               
                <div class="form-group">
                  <label class="control-label col-sm-6" for="">Mínimo:</label>
                  <div class="col-sm-9">
                    <input type="number" min="0" name="minimo" maxlength="50" class="form-control" id="item-min" value="<?php echo $row_datos['item_min']; ?>" required="" autofocus="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-6" for="">Máximo:</label>
                  <div class="col-sm-9">
                    <input type="number" min="0" name="maximo" maxlength="50" class="form-control" id="item-max" value="<?php echo $row_datos['item_max']; ?>"  required="" autofocus="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-6" for="">Tipo de insumo:</label>
                  <div class="col-sm-9">
                    <input type="text" name="tinsumo" maxlength="100" class="form-control" id="tip-insumo" value="<?php echo $row_datos['tip_insumo']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-6" for="">Proveedor:</label>
                  <div class="col-sm-9">
                    <input type="text" name="proveedor" maxlength="100" class="form-control" id="item-brand" value="<?php echo $row_datos['item_brand']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="">Grupo:</label>
                  <div class="col-sm-9">
                    <input type="text" maxlength="100" name="grupos" class="form-control" id="grupo" value="<?php echo $row_datos['grupo']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="">Código SAT:</label>
                  <div class="col-sm-9">
                    <input type="text" maxlength="50" name="csat" class="form-control" id="codigo-sat" value="<?php echo $row_datos['codigo_sat']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                 </div>
                  <div class="form-group">
                  <label class="control-label col-sm-3" for="">Clave Unidad:</label>
                  <div class="col-sm-9">
                    <input type="text" maxlength="100" name="cveuni" class="form-control" id="c-cveuni" value="<?php echo $row_datos['c_cveuni']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                 </div>
                  <div class="form-group">
                  <label class="control-label col-sm-3" for="">Nombre Unidad:</label>
                  <div class="col-sm-9">
                    <input type="text" maxlength="100" name="nombre" class="form-control" id="c-nombre" value="<?php echo $row_datos['c_nombre']; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" required="" autofocus="">
                  </div>
                 </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">&nbsp;</label>
                  <div class="col-sm-12">
                    <a href="../AlmacenC/lista_productos.php" class="btn btn-danger">Cancelar</a>
                    <input type="submit" name="edit" class="btn btn-success" value="Guardar">
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
        $item_codigo   = mysqli_real_escape_string($conexion, (strip_tags($_POST["codigo"], ENT_QUOTES))); //Escanpando caracteres
        $item_descrip    = mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES))); //Escanpando caracteres
        $item_contenido    = mysqli_real_escape_string($conexion, (strip_tags($_POST["contenido"], ENT_QUOTES)));
        $item_costo      = mysqli_real_escape_string($conexion, (strip_tags($_POST["costo"], ENT_QUOTES))); //Escanpando caracteres
        $item_precio1    = mysqli_real_escape_string($conexion, (strip_tags($_POST["precio1"], ENT_QUOTES))); //Escanpando caracteres
        $item_precio2    = mysqli_real_escape_string($conexion, (strip_tags($_POST["precio2"], ENT_QUOTES))); //Escanpando caracteres
        $item_precio3    = mysqli_real_escape_string($conexion, (strip_tags($_POST["precio3"], ENT_QUOTES))); //Escanpando caracteres
        $item_tipo       = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES))); 
        $item_control    = mysqli_real_escape_string($conexion, (strip_tags($_POST["controla"], ENT_QUOTES))); //Escanpando caracteres
       
        $item_minimo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["minimo"], ENT_QUOTES)));
        $item_maximo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["maximo"], ENT_QUOTES)));
        $item_tinsumo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tinsumo"], ENT_QUOTES))); //Escanpando caracteres
        $item_proveedor    = mysqli_real_escape_string($conexion, (strip_tags($_POST["proveedor"], ENT_QUOTES))); //Escanpando caracteres
        $item_grupo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["grupos"], ENT_QUOTES))); //Escanpando caracteres
        $item_csat    = mysqli_real_escape_string($conexion, (strip_tags($_POST["csat"], ENT_QUOTES))); //Escanpando caracteres
        $item_cveuni    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cveuni"], ENT_QUOTES))); //Escanpando caracteres
        $item_nombre    = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES))); //Escanpando caracteres
       
        
        $sql2 = "UPDATE item SET 
          item_code    = '$item_codigo', 
          item_name    = '$item_descrip', 
          item_grams   = '$item_contenido', 
          item_cost    =  $item_costo, 
          item_price   =  $item_precio1, 
          item_price2  =  $item_precio2,
          item_price3  =  $item_precio3, 
          item_type_id =  $item_tipo, 
          controlado   = '$item_control',
         
          item_min     =  $item_minimo, 
          item_max     =  $item_maximo, 
          tip_insumo   = '$item_tinsumo', 
          item_brand   = '$item_proveedor', 
          grupo        = '$item_grupo', 
          codigo_sat   = '$item_csat', 
          c_cveuni     = '$item_cveuni', 
          c_nombre     = '$item_nombre'
        WHERE item_id = $id";
        $result = $conexion->query($sql2);
        
        $sql4 = "UPDATE material_ceye SET 
          material_codigo     = '$item_codigo', 
          material_nombre     = '$item_descrip',
          material_contenido  = '$item_contenido',
          item_cost           =  $item_costo, 
          material_precio     =  $item_precio1, 
          material_precio2    =  $item_precio2, 
          material_precio3    =  $item_precio3, 
          material_tipo       =  $item_tipo,
          material_controlado = '$item_control',
         
          item_min            =  $item_minimo, 
          item_max            =  $item_maximo,  
          tip_insumo          = '$item_tinsumo',
          material_fabricante = '$item_proveedor', 
          grupo               = '$item_grupo',  
          codigo_sat          = '$item_csat', 
          c_cveuni            = '$item_cveuni', 
          c_nombre            = '$item_nombre' 
          WHERE material_id = $id";
        $result = $conexion->query($sql4);
        
        $sql3 = "UPDATE item_almacen SET 
          item_code     = '$item_codigo', 
          item_name     = '$item_descrip', 
          item_grams    = '$item_contenido', 
          item_cost     =  $item_costo, 
          item_price    =  $item_precio1, 
          item_price2   =  $item_precio2,
          item_price3   =  $item_precio3, 
          item_type_id  =  $item_tipo, 
          controlado    = '$item_control', 
         
          item_min      =  $item_minimo, 
          item_max      =  $item_maximo, 
          tip_insumo    = '$item_tinsumo', 
          item_brand    = '$item_proveedor', 
          grupo         = '$item_grupo', 
          codigo_sat    = '$item_csat', 
          c_cveuni      = '$item_cveuni', 
          c_nombre      = '$item_nombre' 
          WHERE item_id =  $id";
        $result = $conexion_almacen->query($sql3);
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