<?php
include '../../conexionbd.php';

if (isset($_POST['diag'])
) {


    $diag = ($_POST['diag']);
    $id_cie10 = ($_POST['id_cie10']);
   // echo 'insert into cat_servicios (serv_cve,serv_costo,serv_umed,serv_activo) values("' . $serv_cve . '","' . $serv_desc . '","' . $serv_costo . '","' . $serv_umed . '","SI")';
    //return 'fifkyfyf';
     $ingresar=mysqli_query($conexion,'insert into cat_diag (diagnostico,id_cie10) values("' . $diag . '","' . $id_cie10 . '")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

     header ('location: cat_diagnosticos.php');

    //  }//si no se enviaron datos


} else {
     header ('location: cat_diagnosticos.php');
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

