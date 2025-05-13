<?php
include '../../conexionbd.php';
 //$clveserv=$_POST['clveserv'];
 //$costo=$_POST['costo'];

 $nombre_paq=$_POST['nom'];
$estudio_id=$_POST['id'];
echo $estudio_id;

$clave=$_POST['clave'];
echo $clave;

$serv_clave = $_POST['serv'];


$paq_cantidad = ($_POST['cantidad']);

 $sql_serv = "SELECT * FROM cat_servicios where serv_cve=".$serv_clave;
                                    $result_serv = $conexion->query($sql_serv);
                                    while ($row_serv = $result_serv->fetch_assoc()) {
                                    $serv_desc=$row_serv['serv_desc'];
                                    $serv_costo=$row_serv['serv_costo'];
                                    $serv_umed=$row_serv['serv_umed'];
                                    $serv_activo=$row_serv['serv_activo'];
                                    $tipo=$row_serv['tipo'];
                                    }


    
//debo guardar el id_serv en estudio_id de cat serv 
$ingresar=mysqli_query($conexion,'insert into cat_servicios (serv_cve,serv_desc,serv_costo,serv_umed,serv_activo,tipo) values("' .  $serv_clave . '" ,"'.$serv_desc .'","'.$serv_costo.'","'.$serv_umed.'","'.$serv_activo.'","'.$tipo.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));
      
 $sql_serv2 = "SELECT * FROM cat_servicios order by id_serv DESC LIMIT 1";
                                    $result_serv2 = $conexion->query($sql_serv2);
                                    while ($row_serv2 = $result_serv2->fetch_assoc()) {
                                      $id_serv=$row_serv2['id_serv'];
                                    }
                                    


$ingresar=mysqli_query($conexion,'insert into paquetes_labo (clave,nombre,estudio_id,cantidad) values('.$clave .',"' .  $nombre_paq . '" , '.$id_serv .','. $paq_cantidad.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));



   header ('location: ver_paquete.php?nom='.$nombre_paq);

        //  }//si no se enviaron datos







