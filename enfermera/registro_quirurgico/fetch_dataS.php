<?php 
session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
    include('connection.php');
$output= array();

$sql = "SELECT * FROM dat_quir_grafico WHERE id_atencion=$id_atencion";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
	0 => 'id',
	1 => 'hora',
	2 => 'sistg',
	3 => 'diastg',
	4 => 'fcardg',
	5 => 'satg',
	6 => 'fecha_g',
	7 => 'fechare',
	8 => 'glic',
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
	$sub_array[] = $row['fecha_g'];
	$sub_array[] = $row['fechare'];
	$sub_array[] = $row['hora'];
	$sub_array[] = $row['sistg'].'/'.$row['diastg'];
	$sub_array[] = $row['fcardg'];
	$sub_array[] = $row['satg'];
	$sub_array[] = $row['glic'];
	$sub_array[] = '<a href="javascript:void();" data-id="'.$row['id'].'"  class="btn btn-warning btn-sm editbtnS" >Editar</a>  <a href="javascript:void();" data-id="'.$row['id'].'"  class="btn btn-danger btn-sm deleteBtnS" >Eliminar</a>';
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
