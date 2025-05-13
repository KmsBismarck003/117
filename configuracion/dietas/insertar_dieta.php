<?php
include '../../conexionbd.php';

if (isset($_POST['dieta'])) {


    $dieta = ($_POST['dieta']);
  
$ingresar=mysqli_query($conexion,'insert into cat_dietas (dieta,dieta_activo) values("' . $dieta . '","SI")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

     header ('location: cat_dietas.php');

    //  }//si no se enviaron datos


} else {
     header ('location: cat_dietas.php');
}



if (@$_GET['q'] == 'estatus') {
    $id = $_GET['eid'];
    $est = $_GET['est'];
    if ($est == 'NO') {
        $sql = "UPDATE `cat_dietas` SET `dieta_activo`='SI' WHERE `id_dieta` = '$id'";
    } else {
        $sql = "UPDATE `cat_dietas` SET `dieta_activo`='NO' WHERE `id_dieta` = '$id'";
    }
    $result = $conexion->query($sql);
    if ($result) {
        echo '<script type="text/javascript">
					alert("Estatus guardado exitosamente");
					window.location.href="../cat_dietas.php";
					</script>';
    }else{
        echo '<script type="text/javascript">
					alert("Error volver a intentar por favor");
					window.location.href="../cat_dietas.php";
					</script>';
    }

}

