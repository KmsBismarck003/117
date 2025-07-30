<?php 

 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('../../conexionbd.php');



$horae = $_POST['horae'];
$fechae= $_POST['fechae'];
$solucionese= $_POST['solucionese'];
$volumene= $_POST['volumene'];

$fr = date("Y-m-d H:i");

$id = $_POST['id'];


$sqlr = "SELECT * FROM reg_usuarios WHERE id_usua='$id_usua' LIMIT 1";
$queryr = mysqli_query($conexion,$sqlr);

while($rowr = mysqli_fetch_assoc($queryr))

{
  $id_u=$rowr['papell'] . ' '. $rowr['sapell'];
}

$sql = "UPDATE `egresos_quir` SET  `id_usua`='$id_u' ,`fecha`='$fechae' , `soluciones`= '$solucionese', `hora`='$horae',`volumen`='$volumene',`fecha_registro`='$fr' WHERE id='$id' ";
$query= mysqli_query($conexion,$sql);
$lastId = mysqli_insert_id($conexion);
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