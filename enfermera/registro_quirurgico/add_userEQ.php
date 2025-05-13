<?php 
 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('connection.php');



$qty_serv = $_POST['qty_serv'];
$serv= $_POST['serv'];
$cart_uniquid = uniqid();

$fr = date("Y-m-d H:i");

$sql = "INSERT INTO `cart_serv` (servicio_id,cart_qty,id_usua,cart_uniqid,paciente,cart_fecha) values ('$serv', '$qty_serv', '$id_usua', '$cart_uniquid','$id_atencion', '$fr')";

$query= mysqli_query($con,$sql);
/*
$sqlr = "SELECT * FROM cat_servicios WHERE id_serv='$serv'";
$queryr = mysqli_query($con,$sqlr);
while($rowr = mysqli_fetch_assoc($queryr)){
  $serv_desc = $rowr['serv_desc'];
}

$sqlrc = "SELECT * FROM cart_serv WHERE paciente='$id_atencion' ORDER BY id DESC LIMIT 1 ";
$queryrc = mysqli_query($con,$sqlrc);
while($rowrc = mysqli_fetch_assoc($queryrc)){
  $cart_id = $rowrc['id'];
}

$fecha_actual = date("Y-m-d H:i:s");
$fecha_registro = date("Y-m-d");

$sqlC = "INSERT INTO `equipos_ceye` (cart_id,id_atencion,id_usua,serv_id,nombre,tiempo,fecha,fecha_registro) values ('$cart_id', '$id_atencion', '$id_usua', '$serv','$serv_desc', '$qty_serv','$fecha_actual','$fecha_registro')";

*/

//$query= mysqli_query($con,$sqlC);
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