  <?php 
session_start();
include "../../conexionbd.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];

            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];
  
 
            $hora =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES)));
            $fecha =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
            $soluciones =  mysqli_real_escape_string($conexion, (strip_tags($_POST["soluciones"], ENT_QUOTES)));
            $volumen =  mysqli_real_escape_string($conexion, (strip_tags($_POST["volumen"], ENT_QUOTES)));
            

$fecha_actual = date("Y-m-d");

//date_default_timezone_set('America/Guatemala');
$fechahora = date("Y-m-d H:i a");
       $ingresar9i = mysqli_query($conexion, 'INSERT INTO ingresos_quir (id_usua,id_atencion,fecha,tipo,soluciones,hora,volumen,fecha_registro) values (' . $id_usua . ' ,' . $id_atencion .',"' . $fecha . '", "QUIROFANO","' . $soluciones . '","' . $hora . '","' . $volumen . '","' . $fechahora . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
       
echo mysqli_query($conexion,$ingresar9i);
          
          
?>