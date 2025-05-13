<?php 

 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('connection.php');



$fechat = $_POST['fechat'];
$mat= $_POST['mat'];
$inicio= $_POST['inicio'];
$dentro= $_POST['dentro'];
$fuera= $_POST['fuera'];

$fr = date("Y-m-d H:i");

$id = $_POST['id'];


$sqlr = "SELECT * FROM reg_usuarios WHERE id_usua='$id_usua' LIMIT 1";
$queryr = mysqli_query($con,$sqlr);

while($rowr = mysqli_fetch_assoc($queryr))

{
  $id_u=$rowr['papell'] . ' '. $rowr['sapell'];
}

$sql = "UPDATE `textiles` SET  `mat`='$mat' ,`inicio`='$inicio' ,`dentro`='$dentro' , `fuera`= '$fuera', `total`='$inicio',`text_fecha`='$fr',`fechare`='$fechat',`id_usua2`='$id_u',`iniciototal`='$inicio' WHERE id='$id' ";

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