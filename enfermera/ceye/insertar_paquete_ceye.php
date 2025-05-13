<?php
include '../../conexionbd.php';
if (isset($_GET['nom'])) {
    $paq_nombre = $_GET['nom'];
    echo $_GET['nom'];
} else {
    $paq_nombre = ($_POST['nompaq']);
}
if (
        isset($_POST['material_id']) and
        isset($_POST['cantidad'])


    ) {

        echo $_POST['material_id'];
        echo $_POST['cantidad'];


        $paq_materialid = ($_POST['material_id']);
        $paq_cantidad = ($_POST['cantidad']);

        // echo 'insert into cat_servicios (serv_cve,serv_costo,serv_umed,serv_activo) values("' . $serv_cve . '","' . $serv_desc . '","' . $serv_costo . '","' . $serv_umed . '","SI")';
        //return 'fifkyfyf';
    $ingresar=mysqli_query($conexion,'insert into paquetes_ceye (nombre,material_id,cantidad) values("' .  $paq_nombre . '" , '.$paq_materialid .','. $paq_cantidad.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));
      //  echo 'insert into paquete_ceye (nombre,material_id,cantidad) values("' . $paq_nombre . '" , ' . $paq_materialid . ',' . $paq_cantidad . ')';

   header ('location: insert_paquete_ceye.php?nom='.$paq_nombre);

        //  }//si no se enviaron datos


    } else {

        header ('location:  insert_paquete_ceye.php');
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
        } else {
            echo '<script type="text/javascript">
					alert("Error volver a intentar por favor");
					window.location.href="cat_servicios.php";
					</script>';
        }

    }

