<?php 
 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('connection.php');

$medicam_mat= $_POST['medicam_matm'];
$cart_qty= $_POST['cart_qtym'];

$cart_uniquid = uniqid();
$fr = date("Y-m-d H:i");

$sqlr = "SELECT aseg FROM dat_ingreso WHERE id_atencion='$id_atencion'";
$queryr = mysqli_query($con,$sqlr);
while($rowr = mysqli_fetch_assoc($queryr)){
  $at = $rowr['aseg'];
}

$sqlrc = "SELECT tip_precio FROM cat_aseg WHERE aseg='$at'";
$queryrc = mysqli_query($con,$sqlrc);
while($rowrc = mysqli_fetch_assoc($queryrc)){
  $tr = $rowrc['tip_precio'];
}

$sqlrs = "SELECT * FROM stock_ceye s WHERE s.item_id='$medicam_mat'";
$queryrs = mysqli_query($con,$sqlrs);
while($rowrs = mysqli_fetch_assoc($queryrs)){
  $stock_id = $rowrs['stock_id'];
   $stock_qty = $rowrs['stock_qty'];
}

$sqlrsi = "SELECT * FROM material_ceye WHERE material_id='$medicam_mat'";
$queryrsi = mysqli_query($con,$sqlrsi);
while($rowrsi = mysqli_fetch_assoc($queryrsi)){
 $med_nom = $rowrsi['material_nombre'].', '.$rowrsi['material_contenido'];

               if($tr==1){
            $precio=$rowrsi['material_precio'];
        }else if ($tr==2){
            $precio=$rowrsi['material_precio2'];
        }else if ($tr==3){
            $precio=$rowrsi['material_precio3'];
        }
}
       
        
$sql = "INSERT INTO `cart_mat` (material_id,cart_qty,cart_price,cart_stock_id,id_usua,cart_uniqid,paciente,cart_fecha,medicam_mat) values ('$medicam_mat', '$cart_qty', '$precio', '$stock_id','$id_usua', '$cart_uniquid', '$id_atencion','$fr','$med_nom')";
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