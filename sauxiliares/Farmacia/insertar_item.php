<?php
include '../../conexionbd.php';

if (isset($_POST['nomitem']) and
    isset($_POST['precio']) and
    isset($_POST['codigo']) AND
    isset($_POST['fabricante']) and
    isset($_POST['contenido']) and
    isset($_POST['tipo']) and
isset($_POST['controlado'])
) {

    $prod_nombre = ($_POST['nomitem']);;
    $prod_precio = ($_POST['precio']);;
    $prod_codigo = ($_POST['codigo']);
    $prod_fabricante = ($_POST['fabricante']);
    $prod_contenido = ($_POST['contenido']);
    $prod_tipo = ($_POST['tipo']);
    $controlado = ($_POST['controlado']);
   // echo 'insert into cat_servicios (serv_cve,serv_costo,serv_umed,serv_activo) values("' . $serv_cve . '","' . $serv_desc . '","' . $serv_costo . '","' . $serv_umed . '","SI")';
    //return 'fifkyfyf';
     $ingresar=mysqli_query($conexion,'insert into item (item_name,item_price,item_code,item_brand,item_grams,item_type_id,controlado) values("' .  $prod_nombre . '","' .  $prod_precio . '","' .  $prod_codigo. '","' .  $prod_fabricante . '","' .  $prod_contenido . '","' .  $prod_tipo . '","' .  $controlado . '")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));


     header ('location: lista_productos.php');

    //  }//si no se enviaron datos


} else {

     header ('location: lista_productos.php');
}



if (@$_GET['q'] == 'estatus') {
    $id = $_GET['eid'];
    $est = $_GET['est'];
    if ($est == 'NO') {
        $sql = "UPDATE `cat_servicios` SET `serv_activo`='SI' WHERE `id_serv` = '$id'";
    } else {
        $sql = "UPDATE `cat_servicios` SET `serv_activo`='NO' WHERE `id_serv` = '$id'";
    }
    $result = $conexion->query($sql);
    if ($result) {
        echo '<script type="text/javascript">
					alert("Estatus guardado exitosamente");
					window.location.href="cat_servicios.php";
					</script>';
    }else{
        echo '<script type="text/javascript">
					alert("Error volver a intentar por favor");
					window.location.href="cat_servicios.php";
					</script>';
    }

}

