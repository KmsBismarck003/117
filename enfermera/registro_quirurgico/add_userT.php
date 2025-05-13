<?php 
 session_start();
    $usuario = $_SESSION['login'];
    $id_usua = $usuario['id_usua'];
    $id_atencion = $_SESSION['pac'];
include('connection.php');



$fechat= $_POST['fechat'];
$mat = $_POST['mat'];
$inicio= $_POST['inicio'];
$dentro = $_POST['dentro'];
$fuera = $_POST['fuera'];

$fr = date("Y-m-d H:i");



//$sql = "INSERT INTO `textiles` (id_atencion,mat,inicio,dentro,fuera,text_fecha,id_usua,fechare) values ('$id_atencion','$mat','$inicio','$dentro','$fuera','$fr','$id_u','$fechat')";


$resultado3 = "SELECT * from textiles WHERE id_atencion='$id_atencion' and mat='$mat' and cirugia=1 ORDER BY id Desc";
$queryr3 = mysqli_query($con,$resultado3);

while($f3 = mysqli_fetch_assoc($queryr3)){
$id_textt=$f3['id_text'];
$matt=$f3['mat'];
$dentroo=$f3['dentro'];
$fueraa=$f3['fuera'];
$id_at=$f3['id_atencion'];

}

 if($id_at==null){
    $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];


           
          if(isset($_POST['inicio'])){$inicio=$_POST['inicio'];}else{ $inicio=0;}
            if(isset($_POST['dentro'])){$dentro=$_POST['dentro'];}else{ $dentro=0;}
            if(isset($_POST['fuera'])){$fuera=$_POST['fuera'];}else{ $fuera=0;}
           
           $fechat= $_POST['fechat'];


           $totali=$dentro+$fuera;

    $fecha_actual = date("Y-m-d H:i:s");

$sqlru = "SELECT * FROM reg_usuarios WHERE id_usua='$id_usua'";
$queryru = mysqli_query($con,$sqlru);

while($rowru = mysqli_fetch_assoc($queryru))

{
   $id_us=$rowru['papell'];
}

$sql = "INSERT INTO `textiles` (id_atencion,mat,inicio,dentro,fuera,total,text_fecha,id_usua,fechare,iniciototal,cirugia) values ('$id_atencion','$mat','$inicio','$dentro','$fuera','$inicio','$fr','$id_us','$fechat','$inicio',1)";
$query= mysqli_query($con,$sql);
//$ingresar2 = mysqli_query($con, 'INSERT INTO textiles (id_atencion,mat,inicio,dentro,fuera,total,text_fecha,id_usua,fechare,iniciototal) values (' . $id_atencion . ',"' . $mat . '","' . $inicio . '","' . $dentro . '","' . $fuera . '","' . $inicio . '","'.$fecha_actual.'",' . $id_usua .',"'.$fechat.'","' . $inicio . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($con));
//echo mysqli_query($con,$ingresar2);


}else if($id_at!=null and $matt==$mat or $id_at!=null and $dentroo==$dentro or $id_at!=null and $fueraa==$fuera){
    
 $mat = $_POST['mat'];
      $dentro = $_POST['dentro'];
    $fuera = $_POST['fuera'];
          $totali=$dentro+$fuera+$totall;
          
          $sqlro = "SELECT * FROM reg_usuarios WHERE id_usua='$id_usua' LIMIT 1";
$queryro = mysqli_query($con,$sqlro);

while($rowro = mysqli_fetch_assoc($queryro))

{
   $id_u=$rowro['papell'] . ' '. $rowro['sapell'];
}
    $sqlup = "UPDATE `textiles` SET `inicio`=CONCAT(inicio,'"."+ ".$inicio."'),`dentro`=CONCAT(dentro+'$dentro'),`fuera`=CONCAT(fuera+'$fuera'),`total`=CONCAT(total+'$inicio'),`id_usua2`='$id_u',`iniciototal`=CONCAT(iniciototal+$inicio) WHERE `id_atencion`='$id_at' and `mat`='$mat'";
 $query= mysqli_query($con,$sqlup);
 

} else{
   
     $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];

           $mat = $_POST['mat'];
          if(isset($_POST['inicio'])){$inicio=$_POST['inicio'];}else{ $inicio=0;}
            if(isset($_POST['dentro'])){$dentro=$_POST['dentro'];}else{ $dentro=0;}
            if(isset($_POST['fuera'])){$fuera=$_POST['fuera'];}else{ $fuera=0;}
          
            $fechat = $_POST['fechat'];
            $totali=$dentro+$fuera;

    $fecha_actual = date("Y-m-d H:i:s");

$sqlrr = "SELECT * FROM reg_usuarios WHERE id_usua='$id_usua' LIMIT 1";
$queryrr = mysqli_query($con,$sqlrr);

while($rowrr = mysqli_fetch_assoc($queryrr))

{
   $id_up=$rowrr['papell'] . ' '. $rowrr['sapell'];
}
$sqli = "INSERT INTO `textiles` (id_atencion,mat,inicio,dentro,fuera,total,text_fecha,id_usua,fechare,iniciototal,cirugia) values ('$id_atencion','$mat','$inicio','$dentro','$fuera','$totali','$fecha_actual','$id_up','$fechat','$inicio',1)";
$query= mysqli_query($con,$sqli);
}



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