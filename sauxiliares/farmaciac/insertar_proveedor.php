<?php
include '../../conexionbd.php';
include '../../conn_almacen/Connection.php';

if (isset($_POST['nom_prov']) and
    isset($_POST['tel_prov']) and
    isset($_POST['dir_prov']) AND
    isset($_POST['email_prov']) and
    isset($_POST['cont_prov']) and
    isset($_POST['lic_prov']) 
) {

    $nom_prov = ($_POST['nom_prov']);;
    $tel_prov = ($_POST['tel_prov']);;
    $dir_prov = ($_POST['dir_prov']);
    $email_prov = ($_POST['email_prov']);
    $cont_prov = ($_POST['cont_prov']);
    $lic_prov = ($_POST['lic_prov']);
   
     $ingresar=mysqli_query($conexion,'insert into proveedores (nom_prov,tel_prov,dir_prov,email_prov,cont_prov,lic_prov) values("' .  $nom_prov . '","' .  $tel_prov . '","' .  $dir_prov. '","' .  $email_prov . '","' .  $cont_prov . '","' .  $lic_prov . '")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));


     header ('location: proveedores.php');

    //  }//si no se enviaron datos


} else {

     header ('location: proveedores.php');
}



if (@$_GET['q'] == 'estatus') {
    $id = $_GET['eid'];
    $est = $_GET['est'];
    if ($est == 'NO') {
        $sql = "UPDATE `proveedores` SET `activo`='SI' WHERE `idProveedor` = '$id'";
    } else {
        $sql = "UPDATE `proveedores` SET `activo`='NO' WHERE `idProveedor` = '$id'";
    }
    $result = $conexion->query($sql);
    if ($result) {
        echo '<script type="text/javascript">
					alert("Estatus guardado exitosamente");
					window.location.href="proveedores.php";
					</script>';
    }else{
        echo '<script type="text/javascript">
					alert("Error volver a intentar por favor");
					window.location.href="proveedores.php";
					</script>';
    }

}

