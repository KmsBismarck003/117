<?php
include '../../conexionbd.php';
$id_serv=$_POST['id_s'];
$id_paquete=$_POST['id_p'];
$nombre_paq=$_POST['nom'];

$serv="DELETE FROM cat_servicios WHERE id_serv=$id_serv";
$resultado=$conexion->query($serv);

$paquete="DELETE FROM paquetes_labo WHERE id_paquete=$id_paquete";
$resultado=$conexion->query($paquete);

   header ('location: ver_paquete.php?nom='.$nombre_paq);

        //  }//si no se enviaron datos







