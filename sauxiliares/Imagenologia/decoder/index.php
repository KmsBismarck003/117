<?php

include "../../../conexionbd.php";


$id= $_POST['id'];
$id_usua= $_POST['id_usua'];
$name = $_FILES['qrimage']['name'];
  $carpeta = "qrcodes/";
  $temp = explode('.', $name);
  $extension = end($temp);
  $nombreFinal = time() . '.' . $extension;



if($extension=='jpg' || $extension=='png' || $extension=='JPG' || $extension=='PNG'|| $extension=='jpeg'|| $extension=='JPEG'){
   if( move_uploaded_file($_FILES['qrimage']['tmp_name'], $carpeta . $nombreFinal)){



date_default_timezone_set('America/Mexico_City');
$fecha_actual = date("Y-m-d H:i:s");


include_once('./lib/QrReader.php');

$dir = scandir('qrcodes');
$ignoredFiles = array(
	'.',
	'..',
	'.DS_Store'
);
foreach($dir as $file) {
    if(in_array($file, $ignoredFiles)) continue;

    print $file;
    print ' --- ';
    $qrcode = new QrReader('qrcodes/'.$file);
    print $text = $qrcode->text();
    print "<br/>";
}



$sql2 = "UPDATE notificaciones_imagen SET realizado = 'Si',resultado = '$nombreFinal',link='$text',fecha_resul = '$fecha_actual' ,id_usua_resul ='$id_usua' WHERE not_id = $id";   

                $result = $conexion->query($sql2);
   echo '<script type="text/javascript">window.location ="../../../template/menu_imagenologia.php"</script>';
                    }
}
                    ?>