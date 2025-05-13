<?php
include '../../conexionbd.php';

if (isset($_POST['aseg'])) {


    $aseg = ($_POST['aseg']);
    $tip_precio = ($_POST['tip_precio']);
  
$ingresar=mysqli_query($conexion,'insert into cat_aseg (aseg,tip_precio,aseg_activo) 
    values("' . $aseg . '","' .$tip_precio. '","SI")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

     header ('location: aseguradora.php');

    //  }//si no se enviaron datos


} else {
     header ('location: aseguradora.php');
}



if (@$_GET['q'] == 'estatus') {
    $id = $_GET['eid'];
    $est = $_GET['est'];
    if ($est == 'NO') {
        $sql = "UPDATE `cat_aseg` SET `aseg_activo`='SI' WHERE `id_aseg` = '$id'";
    } else {
        $sql = "UPDATE `cat_aseg` SET `aseg_activo`='NO' WHERE `id_aseg` = '$id'";
    }
    $result = $conexion->query($sql);
    if ($result) {
        echo '<script type="text/javascript">
					alert("Estatus guardado exitosamente");
					window.location.href="../aseguradora.php";
					</script>';
    }else{
        echo '<script type="text/javascript">
					alert("Error volver a intentar por favor");
					window.location.href="../aseguradora.php";
					</script>';
    }

}

