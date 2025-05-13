<?php 
 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('connection.php');



$horae = $_POST['horae'];
$fechae = $_POST['fechae'];
$solucionese= $_POST['solucionese'];
$volumene = $_POST['volumene'];


$fr = date("Y-m-d H:i");


$sqlr = "SELECT * FROM reg_usuarios WHERE id_usua='$id_usua' LIMIT 1";
$queryr = mysqli_query($con,$sqlr);

while($rowr = mysqli_fetch_assoc($queryr))

{
   $id_u=$rowr['papell'] . ' '. $rowr['sapell'];
}
$sql = "INSERT INTO `egresos_quir` (id_usua,id_atencion,fecha,soluciones,hora,volumen,fecha_registro) values ('$id_u', '$id_atencion', '$fechae','$solucionese', '$horae','$volumene','$fr')";


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