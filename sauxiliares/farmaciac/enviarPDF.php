<?php

/*
        $to3="bellagenio68@gmail.com";
        $subject3='Prueba de envio correo Sanatorio venecia';
        $header3='MIME-Version: 1.0'."\r\n";
        $from3='https://simavenecia.com/';
        $header3.="Content-type: text/html; charset=iso-8859-1\r\n";
        $header3.="X-Mailer:PHP/".phpversion();
        $message3.='<html><body>
        <h3 style="color:black;">Buen dia,</h3>';
        $message3.='<h3 style="color:black;">
        Se notifica nueva orden de compra  para que se solicite al proveedor.
</h3></body></html>';
$message3=utf8_decode($message3);

if(mail($to3,$subject3,$message3,$header3))
     echo "Mensaje enviado correctamente";
   
   }else{
          echo "No se pudo enviar el email";
    }*/
    
    // Configuración del correo
    $to = "bellagenio68@gmail.com";
    $subject = 'Detalles de la Orden de Compra #';
    $boundary = md5(time()); // Crear un boundary único para separar partes del correo
    //$headers = "From: https://simavenecia.com/ \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers.="X-Mailer:PHP/".phpversion();

    // Construcción del mensaje
    $message = "--$boundary\r\n";
    $message .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $message .= "<html><body>";
    $message .= "<h3>Buen día,</h3>";
    $message .= "<p>Adjunto encontrarás los detalles de la orden de compra enviado por farmacia del Sanatorio Venecia Metepec.</p>";
    $message .= "</body></html>\r\n";

    // Adjuntar el archivo PDF
  /*  $file_content = file_get_contents($output_path);
    $encoded_file = chunk_split(base64_encode($file_content));
    $message .= "--$boundary\r\n";
    $message .= "Content-Type: application/pdf; name=\"detalle_orden_compra_$id_compra.pdf\"\r\n";
    $message .= "Content-Transfer-Encoding: base64\r\n";
    $message .= "Content-Disposition: attachment; filename=\"detalle_orden_compra_$id_compra.pdf\"\r\n\r\n";
    $message .= $encoded_file . "\r\n";
    $message .= "--$boundary--";*/

    // Enviar el correo
    if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('La orden de compra se ha actualizado y se ha enviado el correo con el PDF.'); window.location.href = 'ordenes_compra.php';</script>";
    } else {
        echo "<script>alert('No se pudo enviar el email'); window.location.href = 'ordenes_compra.php';</script>";
    }

?>
