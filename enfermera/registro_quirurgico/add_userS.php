<?php 
 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('connection.php');



$hora = $_POST['hora'];
$sistg = $_POST['sistg'];
$diastg= $_POST['diastg'];
$fcardg = $_POST['fcardg'];
$satg = $_POST['satg'];
$glic = $_POST['glic'];
$fechare= $_POST['fechare'];

$fr = date("Y-m-d H:i");

$sql = "INSERT INTO `dat_quir_grafico` (id_atencion,id_usua,hora,sistg,diastg,fcardg,satg,fecha_g,fechare,glic) values ('$id_atencion', '$id_usua', '$hora', '$sistg','$diastg', '$fcardg','$satg','$fr','$fechare','$glic')";


$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
if($query ==true)
{
   
    $data = array(
        'status'=>'true',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'false',
      
    );

    echo json_encode($data);
} 

?>