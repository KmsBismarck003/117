<?php 
 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('../../conexionbd.php');



$horai = $_POST['horai'];
$fechai = $_POST['fechai'];
$soluciones= $_POST['soluciones'];
$volumen = $_POST['volumen'];


$fr = date("Y-m-d H:i");


$sqlr = "SELECT * FROM reg_usuarios WHERE id_usua='$id_usua' LIMIT 1";
$queryr = mysqli_query($conexion,$sqlr);

while($rowr = mysqli_fetch_assoc($queryr))

{
   $id_u=$rowr['papell'] . ' '. $rowr['sapell'];
}
$sql = "INSERT INTO `ingresos_quir` (id_usua,id_atencion,fecha,tipo,soluciones,hora,volumen,fecha_registro) values ('$id_u', '$id_atencion', '$fechai', 'QUIROFANO','$soluciones', '$horai','$volumen','$fr')";


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