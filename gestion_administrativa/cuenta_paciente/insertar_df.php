<?php
include '../../conexionbd.php';
require "../../estados.php";

$aseg = $_POST['aseg'];
$aval =$_POST['aval'];
$banco =$_POST['banco'];
$deposito =$_POST['deposito'];
$dep_l =$_POST['dep_l'];
$fec_deposito =$_POST['fec_deposito'];


    $resultado1 = $conexion ->query("SELECT id_atencion FROM dat_ingreso ORDER by id_atencion DESC LIMIT 1")or die($conexion->error);
  
  if(mysqli_num_rows($resultado1) > 0 ){ //se mostrara si existe mas de 1
    $fila=mysqli_fetch_row($resultado1);
     $id_at=$fila[0];
  }else{
    header("Location: ../registro_pac.php"); //te regresa a la página principal
  }

  $resultado2 = $conexion ->query("SELECT resp, tel_resp, id_edo, id_mun, dir FROM paciente ORDER by Id_exp DESC LIMIT 1")or die($conexion->error);
  
  if(mysqli_num_rows($resultado2) > 0 ){ //se mostrara si existe mas de 1
    $fila1=mysqli_fetch_row($resultado2);
    $resp=$fila1[0];
    $tel_resp=$fila1[1];
    $id_edo=$fila1[2];
    $id_mun=$fila1[3];
    $dir_resp=$fila1[4];

  }else{
    header("Location: ../registro_pac.php"); //te regresa a la página principal
  }

$fecha_actual = date("Y-m-d H:i:s");
    $ingresar=mysqli_query($conexion,'insert into dat_financieros(id_atencion,aseg,resp,dir_resp,id_edo,id_mun,tel,aval,banco,deposito,dep_l,fec_deposito,fecha) values
    ('.$id_at.',"'.$aseg.'","'.$resp.'","'.$dir_resp.'",'.$id_edo.','.$id_mun.',"'.$tel_resp.'","'.$aval.'","'.$banco.'",'.$deposito.',"'.$dep_l.'","'.$fec_deposito.'","'.$fecha_actual.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));


    //redireccion
    header ('location: ../gestion_pacientes/registro_pac.php');
?>