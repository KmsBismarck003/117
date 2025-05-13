<?php
session_start();
include "../../conexionbd.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];

            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];

            $mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["mat"], ENT_QUOTES)));
            
            if(isset($_POST['inicio'])){$inicio=$_POST['inicio'];}else{ $inicio=0;}
            if(isset($_POST['dentro'])){$dentro=$_POST['dentro'];}else{ $dentro=0;}
            if(isset($_POST['fuera'])){$fuera=$_POST['fuera'];}else{ $fuera=0;}
       
            $total =  mysqli_real_escape_string($conexion, (strip_tags($_POST["total"], ENT_QUOTES)));
            $fechare =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fechare"], ENT_QUOTES)));


$resultado3 = $conexion->query("SELECT * from textiles WHERE id_atencion=$id_atencion and mat='$mat' ORDER BY id_text Desc") or die($conexion->error);
while($f3 = mysqli_fetch_array($resultado3)){
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

            $mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["mat"], ENT_QUOTES)));
          if(isset($_POST['inicio'])){$inicio=$_POST['inicio'];}else{ $inicio=0;}
            if(isset($_POST['dentro'])){$dentro=$_POST['dentro'];}else{ $dentro=0;}
            if(isset($_POST['fuera'])){$fuera=$_POST['fuera'];}else{ $fuera=0;}
            $total =  mysqli_real_escape_string($conexion, (strip_tags($_POST["total"], ENT_QUOTES)));
            $fechare =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fechare"], ENT_QUOTES)));
           $totali=$dentro+$fuera;

    $fecha_actual = date("Y-m-d H:i:s");
$ingresar2 = mysqli_query($conexion, 'INSERT INTO textiles (id_atencion,mat,inicio,dentro,fuera,total,text_fecha,id_usua,fechare,iniciototal) values (' . $id_atencion . ',"' . $mat . '","' . $inicio . '","' . $dentro . '","' . $fuera . '","' . $inicio . '","'.$fecha_actual.'",' . $id_usua .',"'.$fechare.'","' . $inicio . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
echo mysqli_query($conexion,$ingresar2);


}else if($id_at!=null and $matt==$mat or $id_at!=null and $dentroo==$dentro or $id_at!=null and $fueraa==$fuera){
    
    $mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["mat"], ENT_QUOTES)));
       $dentro =  mysqli_real_escape_string($conexion, (strip_tags($_POST["dentro"], ENT_QUOTES)));
        $fuera =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fuera"], ENT_QUOTES)));
          $totali=$dentro+$fuera+$totall;
    $actualizar = mysqli_query($conexion,"UPDATE textiles SET inicio=CONCAT(inicio,'"."+ ".$inicio."'),dentro=CONCAT(dentro+$dentro),fuera=CONCAT(fuera+$fuera),total=CONCAT(total+$inicio),id_usua2=$id_usua,iniciototal=CONCAT(iniciototal+$inicio) WHERE id_atencion='$id_at' and mat='$mat'");
    echo mysqli_query($conexion,$actualizar);

} else{
   
     $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];

            $mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["mat"], ENT_QUOTES)));
          if(isset($_POST['inicio'])){$inicio=$_POST['inicio'];}else{ $inicio=0;}
            if(isset($_POST['dentro'])){$dentro=$_POST['dentro'];}else{ $dentro=0;}
            if(isset($_POST['fuera'])){$fuera=$_POST['fuera'];}else{ $fuera=0;}
            $total =  mysqli_real_escape_string($conexion, (strip_tags($_POST["total"], ENT_QUOTES)));
            $fechare =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fechare"], ENT_QUOTES)));
            $totali=$dentro+$fuera;

    $fecha_actual = date("Y-m-d H:i:s");
$ingresar2 = mysqli_query($conexion, 'INSERT INTO textiles (id_atencion,mat,inicio,dentro,fuera,total,text_fecha,id_usua,fechare) values (' . $id_atencion . ',"' . $mat . '","' . $inicio . '","' . $dentro . '","' . $fuera . '","' . $totali . '","'.$fecha_actual.'",' . $id_usua .',"'.$fechare.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
echo mysqli_query($conexion,$ingresar2);

}






          ?>