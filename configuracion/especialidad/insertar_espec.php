<?php
include '../../conexionbd.php';

if (isset($_POST['espec'])) {


    $espec = ($_POST['espec']);
  
$ingresar=mysqli_query($conexion,'insert into cat_espec (espec,espec_activo) values("' . $espec . '","SI")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

     header ('location: cat_espec.php');

    //  }//si no se enviaron datos


} else {
     header ('location: cat_espec.php');
}



if (@$_GET['q'] == 'estatus') {
    $id = $_GET['eid'];
    $est = $_GET['est'];
    if ($est == 'NO') {
        $sql = "UPDATE `cat_espec` SET `espec_activo`='SI' WHERE `id_espec` = '$id'";
    } else {
        $sql = "UPDATE `cat_espec` SET `espec_activo`='NO' WHERE `id_espec` = '$id'";
    }
    $result = $conexion->query($sql);
    if ($result) {
        echo '<script type="text/javascript">
					alert("Estatus guardado exitosamente");
					window.location.href="../cat_espec.php";
					</script>';
    }else{
        echo '<script type="text/javascript">
					alert("Error volver a intentar por favor");
					window.location.href="../cat_espec.php";
					</script>';
    }

}

