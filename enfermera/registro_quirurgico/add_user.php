<?php 
 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('connection.php');



$tipo = $_POST['tipo'];
$fecha_inst = $_POST['fecha_inst'];
$instalo = $_POST['instalo'];
$cultivo = $_POST['cultivo'];
$dispositivos = $_POST['dispositivos'];

$fr = date("Y-m-d H:i");

$sql = "INSERT INTO `cate_enf_ter` (id_atencion,id_usua,dispositivos,tipo,fecha_inst,instalo,cultivo,fecha_registro,tip) values ('$id_atencion', '$id_usua', '$dispositivos', '$tipo','$fecha_inst', '$instalo','$cultivo','$fr','Quirofano')";


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