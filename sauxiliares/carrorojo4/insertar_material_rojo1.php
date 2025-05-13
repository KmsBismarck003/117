<?php
include '../../conexionbd.php';

if (isset($_POST['nommat']) and
    isset($_POST['precio']) and
    isset($_POST['codigo']) AND
    isset($_POST['fabricante']) and
    isset($_POST['contenido']) and
    isset($_POST['tipo']) and
isset($_POST['controlado']) and
isset($_POST['rentado'])
) {

    $mat_nombre = ($_POST['nommat']);;
    $mat_precio = ($_POST['precio']);;
    $mat_codigo = ($_POST['codigo']);
    $mat_fabricante = ($_POST['fabricante']);
    $mat_contenido = ($_POST['contenido']);
    $mat_tipo = ($_POST['tipo']);
    $controlado = ($_POST['controlado']);
    $rentado = ($_POST['rentado']);
   // echo 'insert into cat_servicios (serv_cve,serv_costo,serv_umed,serv_activo) values("' . $serv_cve . '","' . $serv_desc . '","' . $serv_costo . '","' . $serv_umed . '","SI")';
    //return 'fifkyfyf';
     $ingresar=mysqli_query($conexion,'insert into material_ceye (material_nombre,material_precio,material_codigo,material_fabricante,material_contenido,material_tipo,material_controlado,rentado) values("' .  $mat_nombre . '","' .  $mat_precio . '","' .  $mat_codigo. '","' .  $mat_fabricante . '","' .  $mat_contenido . '","' .  $mat_tipo . '","' .  $controlado . '","' .  $rentado . '")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));


     header ('location: lista_productos_ceye.php');

    //  }//si no se enviaron datos


} else {

     header ('location: lista_productos_ceye.php');
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

