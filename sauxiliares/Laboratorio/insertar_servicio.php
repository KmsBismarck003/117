<?php
include '../../conexionbd.php';

if (isset($_POST['clave']) and
    isset($_POST['descripcion']) and
    isset($_POST['costo']) and
    isset($_POST['costo2']) and
    isset($_POST['costo3']) and
    isset($_POST['costo4']) and
    isset($_POST['tipo']) and
    isset($_POST['med'])
) {


    $serv_cve = ($_POST['clave']);;
    $serv_desc = ($_POST['descripcion']);;
    $serv_costo = ($_POST['costo']);
    $serv_costo2 = ($_POST['costo2']);
    $serv_costo3 = ($_POST['costo3']);
    $serv_costo4 = ($_POST['costo4']);
    $serv_umed = ($_POST['med']);
    $serv_tipo = ($_POST['tipo']);
   
     $ingresar=mysqli_query($conexion,'insert into cat_servicios (serv_cve,serv_desc,serv_costo,serv_costo2,serv_costo3,serv_costo4,serv_umed,serv_activo,tipo) values("' . $serv_cve . '","' . $serv_desc . '","' . $serv_costo . '","' . $serv_costo2 . '","' . $serv_costo3 . '","' . $serv_costo4 . '","' . $serv_umed . '","SI","' . $serv_tipo . '")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

     header ('location: cat_servicios.php');

} else {
     header ('location: cat_servicios.php');
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

