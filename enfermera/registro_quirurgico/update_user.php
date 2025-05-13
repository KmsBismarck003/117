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

$id = $_POST['id'];

$sql = "UPDATE `cate_enf_ter` SET  `dispositivos`='$dispositivos' , `tipo`= '$tipo', `fecha_inst`='$fecha_inst',  `instalo`='$instalo', `cultivo`='$cultivo' WHERE id='$id' ";
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