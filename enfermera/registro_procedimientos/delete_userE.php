<?php 
include('../../conexionbd.php');

$user_id = $_POST['id'];
$sql = "DELETE FROM egresos_quir WHERE id='$user_id'";
$delQuery =mysqli_query($conexion,$sql);
if($delQuery==true)
{
	 $data = array(
        'status'=>'success',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'failed',
      
    );

    echo json_encode($data);
} 

?>