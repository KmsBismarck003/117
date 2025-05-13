<?php


$servidor="localhost";
$nombreBd="u542863078_msanisidro";
$usuario="u542863078_sima_msi";
$pass="R809b@x/u";
$conexion=new mysqli($servidor,$usuario,$pass,$nombreBd);
$conexion -> set_charset("utf8");
if($conexion-> connect_error){
die("No se pudo conectar");
}
$codigo = rand(1000,9999);
$to="edson_rojo97@hotmail.com"; 

$subject='Registro Exitoso en la pagina de "Mitani Pharma"';
$header='MIME-Version: 1.0'."\r\n";
$from='www.mitanipharma.com';
$header.="Content-type: text/html; charset=iso-8859-1\r\n";
$header.="X-Mailer:PHP/".phpversion();

$message.='<html><body>
    <h2 style="color:black;">Hola '.$_POST['nombre_completo'].' tu registro fue satisfactorio en nuestra Tienda de "Mitani Pharma"</h2>
   <img style="display:block;margin-left: auto; margin-right: auto;" src="https://sanisidro.simahospitales.com/mitani.jpg" />
        <h3 style="color:#6b7db9;">Detalles de tu cuenta</h3>
            <h3 style="color:black;">Te has registrado con el correo electronico de: '.$_POST['correo'].'</h3>';
            
$message.='<h3 style="color:#6b7db9;">Ahora solo queda un paso, ve al siguiente link para verificar tu cuenta...</h3>
 <p>tu código de verificación es :</p>
  <p> <a 
     href="http://localhost/logingrijalva/Sistema-de-login-y-registro-con-auth-token/confirm.php?correo='.$correo.'">
    Verificar cuenta </a> 
    </p>
 <h2 style="color:#6b7db9;">'.$codigo.'</h2>

 </body></html>';
$message=utf8_decode($message);
if(mail($to,$subject,$message,$header)){
      /* Condicion para recojer las variables y enviar el correo*/
//  echo "Mensaje enviado correctamente";
}else{
//  echo "No se pudo enviar el email";
}