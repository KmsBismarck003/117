<?php 

 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('connection.php');



$hora = $_POST['hora'];
$sistg= $_POST['sistg'];
$diastg= $_POST['diastg'];
$fcardg= $_POST['fcardg'];
$satg = $_POST['satg'];
$glic= $_POST['glic'];
$fechare = $_POST['fechare'];



$id = $_POST['id'];

$sql = "UPDATE `dat_quir_grafico` SET  `hora`='$hora' , `sistg`= '$sistg', `diastg`='$diastg',  `fcardg`='$fcardg', `satg`='$satg', `glic`='$glic', `fechare`='$fechare'  WHERE id='$id' ";
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