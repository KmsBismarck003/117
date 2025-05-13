  <?php 
session_start();
include "../../conexionbd.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];

            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];
  
  //$tipo =  mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES)));
            $hora_i =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_i"], ENT_QUOTES)));
            $hora_t =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_t"], ENT_QUOTES)));
            $sol =  mysqli_real_escape_string($conexion, (strip_tags($_POST["sol"], ENT_QUOTES)));
            $tcate =  mysqli_real_escape_string($conexion, (strip_tags($_POST["tcate"], ENT_QUOTES)));
            $sol_fecha =  mysqli_real_escape_string($conexion, (strip_tags($_POST["sol_fecha"], ENT_QUOTES)));
            $vol =  mysqli_real_escape_string($conexion, (strip_tags($_POST["vol"], ENT_QUOTES)));
$pvc =  mysqli_real_escape_string($conexion, (strip_tags($_POST["pvc"], ENT_QUOTES)));
//date_default_timezone_set('America/Guatemala');
$fecha_actual = date("Y-m-d");

//date_default_timezone_set('America/Guatemala');
$fechahora = date("Y-m-d H:i a");
       $ingresar9 = mysqli_query($conexion, 'INSERT INTO sol_enf (id_atencion,id_usua,tipo,hora_i,hora_t,sol,tcate,vol,sol_fecha,pvc,fecha_registro) values (' . $id_atencion . ' ,' . $id_usua .', "QUIROFANO","' . $hora_i . '","' . $hora_t . '","' . $sol . '","' . $tcate . '","' . $vol . '","'.$sol_fecha.'","'.$pvc.'","'.$fechahora.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
       
echo mysqli_query($conexion,$ingresar9);
          
          
?>