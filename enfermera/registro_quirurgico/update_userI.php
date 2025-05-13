<?php 

 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('connection.php');



$horai = $_POST['horai'];
$fechai= $_POST['fechai'];
$soluciones= $_POST['soluciones'];
$volumen= $_POST['volumen'];

$fr = date("Y-m-d H:i");

$id = $_POST['id'];


$sqlr = "SELECT * FROM reg_usuarios WHERE id_usua='$id_usua' LIMIT 1";
$queryr = mysqli_query($con,$sqlr);

while($rowr = mysqli_fetch_assoc($queryr))

{
  $id_u=$rowr['papell'] . ' '. $rowr['sapell'];
}

$sql = "UPDATE `ingresos_quir` SET  `id_usua`='$id_u' ,`fecha`='$fechai' , `soluciones`= '$soluciones', `hora`='$horai',`volumen`='$volumen',`fecha_registro`='$fr' WHERE id='$id' ";
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