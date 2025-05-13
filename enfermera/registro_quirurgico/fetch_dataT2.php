<?php 
session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
    include('connection.php');
$output= array();

$sql = "SELECT * FROM textiles WHERE id_atencion=$id_atencion and cirugia=2";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
	0 => 'id',
	1 => 'id_atencion',
	2 => 'mat',
	3 => 'inicio',
	4 => 'dentro',
	5 => 'fuera',
	6 => 'total',
	7 => 'text_fecha',
	8 => 'id_usua',
	9 => 'fechare',
	10 => 'id_usua2',
	11 => 'iniciototal',
);



/*if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE dispositivos like '%".$search_value."%'";
	$sql .= " OR tipo like '%".$search_value."%'";
	$sql .= " OR fecha_inst like '%".$search_value."%'";
	$sql .= " OR instalo like '%".$search_value."%'";
	$sql .= " OR id_atencion like '%".$search_value."%'";
}*/

if(isset($_POST['order']))
{
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .=  " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY id desc";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$query = mysqli_query($con,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();



while($row = mysqli_fetch_assoc($query))
{
   
    
	$sub_array = array();
	$sub_array[] = $row['id'];
	$sub_array[] = $row['text_fecha'];
	$sub_array[] = $row['fechare'];
	$sub_array[] = $row['mat'];
	$sub_array[] = $row['inicio'];
	$sub_array[] = $row['dentro'];
	$sub_array[] = $row['fuera'];
	$sub_array[] = $row['total'];
	
//	if($sub_array[10]=="0"){
	    //$sub_array[] = $row['id_usua'];
	//}else{
	$sub_array[] = $row['id_usua'] .'' . $row['id_usua2'];
//	}
	
	$sub_array[] = '<a href="javascript:void();" data-id="'.$row['id'].'"  class="btn btn-warning btn-sm editbtnT" >Editar</a>  <a href="javascript:void();" data-id="'.$row['id'].'"  class="btn btn-danger btn-sm deleteBtnT" >Eliminar</a>';
	$data[] = $sub_array;

}
$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
