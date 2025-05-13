<?php
include '../../conexionbd.php';
if (isset($_GET['nom'])) {
    $paq_nombre = $_GET['nom'];
    echo $_GET['nom'];
} else {
    $paq_nombre = ($_POST['nompaq']);
}
if (
        isset($_POST['serv']) and
        isset($_POST['cantidad'])


    ) {

        echo $_POST['serv'];
        echo $_POST['cantidad'];


        $paq_labo = ($_POST['serv']);
        $paq_cantidad = ($_POST['cantidad']);

        // echo 'insert into cat_servicios (serv_cve,serv_costo,serv_umed,serv_activo) values("' . $serv_cve . '","' . $serv_desc . '","' . $serv_costo . '","' . $serv_umed . '","SI")';
        //return 'fifkyfyf';
    $ingresar=mysqli_query($conexion,'insert into paquetes_labo (nombre,estudio_id,cantidad) values("' .  $paq_nombre . '" , '.$paq_labo .','. $paq_cantidad.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));
      //  echo 'insert into paquete_ceye (nombre,material_id,cantidad) values("' . $paq_nombre . '" , ' . $paq_materialid . ',' . $paq_cantidad . ')';

   header ('location: insert_paquete_labo.php?nom='.$paq_nombre);

        //  }//si no se enviaron datos


    } else {

        header ('location:  insert_paquete_labo.php');
    }





