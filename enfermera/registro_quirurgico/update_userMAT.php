<?php 

 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('connection.php');


$medicam_mat= $_POST['medicam_matm'];
$cart_qty= $_POST['cart_qtym'];
$cart_surtido= $_POST['cart_qtyM'];

$id = $_POST['id'];
$fr = date("Y-m-d H:i");

$sql = "UPDATE `cart_mat` SET  `cart_qty`='$cart_qty',`cart_surtido`='$cart_surtido' , `cart_fecha`= '$fr' WHERE id='$id' ";
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