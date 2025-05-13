<?php
//se establece una conexion a la base de datos
include '../../conexionbd.php';
//si se han enviado datos

$id_usua=($_POST['id_usua']);
$area=($_POST['area']);
$motivo_atn=($_POST['motivo_atn']);
$especialidad=($_POST['especialidad']);
$alergias=($_POST['alergias']);

      $resultado1 = $conexion ->query("SELECT * FROM paciente ORDER by Id_exp DESC LIMIT 1")or die($conexion->error);
  
  if(mysqli_num_rows($resultado1) > 0 ){ //se mostrara si existe mas de 1
    $fila=mysqli_fetch_row($resultado1);
     $id_exp=$fila[0];
  }else{
    header("Location: ../registro_pac.php"); //te regresa a la página principal
  }


   
    $ingresar=mysqli_query($conexion,'insert into dat_ingreso(Id_exp,especialidad,alergias,id_usua,area,motivo_atn) values
    ('.$id_exp.',"'.$especialidad.'","'.$alergias.'","'.$id_usua.'","'.$area.'","'.$motivo_atn.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));


    //redirección
    header ('location: ../cuenta_paciente/dat_financieros.php');

?>