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
<strong><center>EDITAR CLIENTE</center></strong>
</div>
<p>
<?php
$id_cliente=@$_GET['id_cliente'];
$resultado = $conexion ->query("SELECT * FROM c_cliente WHERE id_c_cliente=".$id_cliente)or die($conexion->error);
  if(mysqli_num_rows($resultado) > 0 ){ //se mostrara si existe mas de 1
    $f=mysqli_fetch_row($resultado);
}
?>
<div class="container">
  <div class="row">
    <div class="col-sm">
    <strong>*RFC</strong>
<input type="text" name="rfc" class="form-control" value="<?php echo $f[2];?>" >
    </div>
    <div class="col-sm">
     <strong>*Razón social</strong>
<input type="text" name="razon_s" class="form-control" value="<?php echo $f[3];?>" >
    </div>
    <div class="col-sm">
    <strong>Calle</strong>
<input type="text" name="calle" class="form-control" value="<?php echo $f[4];?>">
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
   
    <div class="col-sm">
     <strong>No. Exterior</strong>
<input type="text" name="no_ext" class="form-control" value="<?php echo $f[5];?>">
    </div>
    <div class="col-sm">
     <strong>No. Interior</strong>
<input type="text" name="no_int" class="form-control" value="<?php echo $f[6];?>">
    </div>
     <div class="col-sm">
   
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
   
        <?php
                       // include("../../registro_pac_fac.php")
                        ?>

     <div class="col-sm-4">
     <strong>Código postal</strong>
     <input type="number" class="form-control" name="cod_postal" value="<?php echo $f[9];?>">
<!--<select name="cod_postal" class="form-control" data-live-search="true" id="cod_postal" style="width : 100%;heigth:100%;">
              <option value="">Seleccionar</option>
                <?php
         include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_colonia GROUP BY c_CodigoPostal";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_CodigoPostal'] . "'>".$row['c_CodigoPostal']."
                </option>"; 
                } ?>
            </select>-->
    </div>
    
    <!--<div class="col-sm-4">
     <div id="select2lista"></div>
    </div>-->

    <div class="col-sm">
     <strong>Régimen fiscal</strong>
<select name="reg_fiscal" class="form-control" data-live-search="true" id="mibuscador3" style="width : 100%; heigth : 100%">
    <option value="<?php echo $f[11];?>"><?php echo $f[11];?></option>
              <option value="">Seleccionar</option>
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_regimenfiscal order by c_RegimenFiscal ASC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_RegimenFiscal'] . "'>".$row['c_RegimenFiscal']." - ".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
  </div>
</div>
</section>
<hr>
<center>
<input type="submit" class="btn btn-success" role="button" name="guardar" value="Editar cliente">
</center>
</form>
</div>

<?php 

 if (isset($_POST['guardar'])) {

//
//$fecha_actual = date("Y-m-d H:i:s");

//$nom_c= mysqli_real_escape_string($conexion, (strip_tags($_POST["nom_c"], ENT_QUOTES)));
$rfc= mysqli_real_escape_string($conexion, (strip_tags($_POST["rfc"], ENT_QUOTES)));
$razon_s= mysqli_real_escape_string($conexion, (strip_tags($_POST["razon_s"], ENT_QUOTES)));
$calle= mysqli_real_escape_string($conexion, (strip_tags($_POST["calle"], ENT_QUOTES)));
$no_ext= mysqli_real_escape_string($conexion, (strip_tags($_POST["no_ext"], ENT_QUOTES)));
$no_int= mysqli_real_escape_string($conexion, (strip_tags($_POST["no_int"], ENT_QUOTES)));
$cod_postal= mysqli_real_escape_string($conexion, (strip_tags($_POST["cod_postal"], ENT_QUOTES)));
$reg_fiscal= mysqli_real_escape_string($conexion, (strip_tags($_POST["reg_fiscal"], ENT_QUOTES)));
//$estado= mysqli_real_escape_string($conexion, (strip_tags($_POST["estado"], ENT_QUOTES)));
//$municipio= mysqli_real_escape_string($conexion, (strip_tags($_POST["municipios"], ENT_QUOTES)));
//$asenta= mysqli_real_escape_string($conexion, (strip_tags($_POST["asenta"], ENT_QUOTES)));

include "conexionbdf.php";

 $sql2 = "UPDATE c_cliente SET rfc='$rfc', razon_s='$razon_s', calle='$calle', no_ext='$no_ext', no_int='$no_int', cod_postal='$cod_postal', reg_fiscal='$reg_fiscal' WHERE id_c_cliente= ".$id_cliente;
  $result = $conexion->query($sql2);
  echo '<script type="text/javascript">window.location.href ="cat_clientes.php";</script>';

} 

 ?>


  </div>


  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
<script src="js/jquery-3.3.1.min.js"></script>
  

  <script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador1').select2();
    });
    $(document).ready(function () {
        $('#mibuscador2').select2();
    });
    $(document).ready(function () {
        $('#cod_postal').select2();
    });
</script>
<script>
    document.querySelector('#id_estado').addEventListener('change', event => {
        fetch('../../municipios.php?id_estado=' + event.target.value)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Error en la respuesta');
                }//en if
                return res.json();
            })
            .then(datos => {
                let html = '<option value=""> Seleccionar municipio</option>';
                if (datos.data.length > 0) {
                    for (let i = 0; i < datos.data.length; i++) {
                        html += `<option value="${datos.data[i].id}">${datos.data[i].nombre}</option>`;
                    }//end for
                }//end if
                document.querySelector('#municipios').innerHTML = html;
            })
            .catch(error => {
                console.error('Ocurrió un error ' + error);
            });
    });
</script>
 

 <script type="text/javascript">
   $(document).ready(function () {
        $('#cod_postal').select2();
    });
   
  $(document).ready(function(){ 
    $('#cod_postal').val(1);
    recargarLista();

    $('#cod_postal').change(function(){
      recargarLista();
    });
  })
</script>
<script type="text/javascript">
  function recargarLista(){
    $.ajax({
      type:"POST",
      url:"datos.php",
      data:"asenta=" + $('#cod_postal').val(),
      success:function(r){
        $('#select2lista').html(r);
      }
    });
  }
</script>


 


</body>
</html>