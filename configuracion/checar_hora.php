    <?php

include '../conexionbd.php';




  $resultado1 = $conexion ->query("SELECT TIMESTAMPDIFF(MINUTE,hora_llegada_quir,hora_salida_quir ) as MINUTEs FROM `dat_not_inquir` WHERE 1")or die($conexion->error);
  
  if(mysqli_num_rows($resultado1) > 0 ){ //se mostrara si existe mas de 1
    $fila=mysqli_fetch_row($resultado1);
     $resultado=$fila[0];
  }

$result= 360;
  echo "resultado de busqueda=".$resultado."<br>";

  $res=$resultado/60;

  echo "resultado entre 60 minutos : ".$res." horas <br>";

$decimales=explode(".", $res);

if(isset($decimales[1])){

  if($decimales[1] >= 0){
  $horas=$decimales[0]+1;
  echo "<br>el resultado final es:".$horas."horas";
  }
}else{
      if($res%2 <= 0)
  
  $decimales[0];
   $horas=$decimales[0];
    echo "<br> el resultado es exacto:".$horas."horas";
}


  
  
   
 /* if($resultado1%2 != 0 ){
     echo "<br> se le suma uno <br>";
     echo round($resultado1);
     echo "<br>";
     echo round(($resultado1/60)+0.5);
  }else{
    echo "se queda asi <br> ";
    echo round($resultado1);
  }
                  /*$start_time =strtotime($_POST['hora']);
                  $end_time = strtotime($_POST['hora2']);

                   $total_time = ($end_time - $start_time) / 60 /60 ;
                   $total_time = number_format((float)$total_time, 2);
                   echo round($total_time,2);*/
                  ?>                
                  
