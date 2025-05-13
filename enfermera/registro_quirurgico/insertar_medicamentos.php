<?php
session_start();
        include "../../conexionbd.php";
        $usuario = $_SESSION['login'];
        $id_usua= $usuario['id_usua'];
        $id_atencion = $_SESSION['pac'];
        $item_id =  mysqli_real_escape_string($conexion, (strip_tags($_POST["med"], ENT_QUOTES)));
        $dosis =  mysqli_real_escape_string($conexion, (strip_tags($_POST["dosis"], ENT_QUOTES)));
        $via =  mysqli_real_escape_string($conexion, (strip_tags($_POST["via"], ENT_QUOTES)));
        $frec =  mysqli_real_escape_string($conexion, (strip_tags($_POST["frec"], ENT_QUOTES)));
         $otro =  mysqli_real_escape_string($conexion, (strip_tags($_POST["otro"], ENT_QUOTES)));
            //$hora =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES))); //Escanpando caracteres
        $cart_uniquid = uniqid();
        $qty =  mysqli_real_escape_string($conexion, (strip_tags($_POST["qty"], ENT_QUOTES))); //Escanpando caracteres
        
    
        $fecha_actual = date("Y-m-d H:i:s");
        $sql_pac = "SELECT p.Id_exp, di.id_atencion FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";
        $result_pac = $conexion->query($sql_pac);
        while ($row_pac = $result_pac->fetch_assoc()) {
            $paciente1 = $row_pac['Id_exp'];
        }

        $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
        $result_aseg = $conexion->query($sql_aseg);
        while ($row_aseg = $result_aseg->fetch_assoc()) {
             $at=$row_aseg['aseg']; 
        }
        $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
        while($filat = mysqli_fetch_array($resultadot)){ 
            $tr=$filat["tip_precio"];
        }
      
        $sql_stock = "SELECT * FROM stock_ceye s where $item_id = s.item_id ";
            //echo $sql_stock;
        $result_stock = $conexion->query($sql_stock);
        while ($row_stock = $result_stock->fetch_assoc()) {
              $stock_id = $row_stock['stock_id'];
              $stock_qty = $row_stock['stock_qty'];
        }

        $sql_stock = "SELECT * FROM material_ceye where material_id=$item_id ";
            //echo $sql_stock;
        $result_stock = $conexion->query($sql_stock);
        while ($row_stock = $result_stock->fetch_assoc()) {
            $mat_nom = $row_stock['material_nombre'].', '.$row_stock['material_contenido'];
            if ($tr==1) $precio = $row_stock['material_precio'];
            if ($tr==2) $precio = $row_stock['material_precio2'];
            if ($tr==3) $precio = $row_stock['material_precio3'];
        }
            // echo $stock_qty - $qty;
        if (($stock_qty - $qty) >= 0) {
            $sql2 = "INSERT INTO cart_ceye(material_id,cart_qty,cart_price,cart_stock_id,id_usua,cart_uniqid,paciente,cart_fecha)VALUES($item_id,$qty,$precio,$stock_id,$id_usua,'$cart_uniquid', $id_atencion,'$fecha_actual');";
            //  echo $sql2;
           
           
            //$result_cart = $conexion->query($sql2);
            
            
            $stock = $stock_qty - $qty;
            //$sql3 = "UPDATE stock_ceye set stock_qty=$stock where stock_id = $stock_id";
            //$result3 = $conexion->query($sql3);
             echo mysqli_query($conexion,$sql2);
        }
        else {
                
                echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
                echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
                echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
                echo '<script>
                      $(document).ready(function() {
                          swal({
                              title: "Verificar existencias en quirófano", 
                              type: "success",
                              confirmButtonText: "ACEPTAR"
                          }, function(isConfirm) { 
                              if (isConfirm) {
                                window.location.href = "nav_med.php";
                              }
                          });
                      });
                </script>';   
             
        }
        $existe = "NO";
       
        $sql_cartid = "SELECT * FROM cart_ceye where paciente=$id_atencion ORDER BY cart_id DESC LIMIT 1 ";
            //echo $sql_cartid;
        $result_cartid = $conexion->query($sql_cartid);
        while ($row_cartid = $result_cartid->fetch_assoc()) {
              $cart_id = $row_cartid['cart_id'];
              $existe = "SI";
        }
        if ($existe === "SI") { 
    
      
        $fecha_actual = date("Y-m-d H:i:s");
        
           $unimed =  mysqli_real_escape_string($conexion, (strip_tags($_POST["unimed"], ENT_QUOTES)));
        
        $ingresar2 = mysqli_query($conexion, 'INSERT INTO medicamentos_ceye (cart_id,id_atencion,id_usua,dosis,material_id,mat_nom,via,frecuencia,cantidad,fecha,unimed) values ('.$cart_id.',' . $id_atencion . ',' . $id_usua .',"' . $dosis . '",' . $item_id . ',"' . $mat_nom . '","' . $via . '","' . $frec . '",' . $qty .',"'.$fecha_actual.'","'.$unimed.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

//insert a medica enf //insert a medica enf//insert a medica enf//insert a medica enf//insert a medica enf//insert a medica enf//insert a medica enf

 $fecha_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_mat"], ENT_QUOTES)));
            $hora_med =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_med"], ENT_QUOTES)));
         
            
if($hora_med=='08:00' || $hora_med=='09:00' || $hora_med=='10:00'|| $hora_med=='11:00'|| $hora_med=='12:00' || $hora_med=='13:00' ){
$turno="MATUTINO";
} else if ($hora_med=='14:00' || $hora_med=='15:00' || $hora_med=='16:00'|| $hora_med=='17:00'|| $hora_med=='18:00' || $hora_med=='19:00' || $hora_med=='20:00') {
  $turno="VESPERTINO";
}else if ($hora_med=='21:00' || $hora_med=='22:00' || $hora_med=='23:00'|| $hora_med=='00:00'|| $hora_med=='01:00' || $hora_med=='02:00' || $hora_med=='03:00' || $hora_med=='04:00' || $hora_med=='05:00' || $hora_med=='06:00' || $hora_med=='07:00') {
    $turno="NOCTURNO";
}

$fechahora = date("Y-m-d H:i");
       $ingresar9 = mysqli_query($conexion, 'INSERT INTO medica_enf (id_atencion,fecha_mat,hora_mat,turno,medicam_mat,dosis_mat,unimed,via_mat,frec_mat,id_usua,enf_fecha,tipo,otro,cantidad,cart_id,material_id,material) values (' . $id_atencion . ' , "' . $fecha_mat . '","' . $hora_med . '","' . $turno . '","' . $mat_nom . '","' . $dosis . '","' . $unimed . '","' . $via . '","' . $frec . '",' . $id_usua .',"'.$fechahora.'","QUIROFANO","'.$frec.'","' . $qty . '",'.$cart_id.','.$item_id.',"Si") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

 echo mysqli_query($conexion,$ingresar9);
           echo mysqli_query($conexion,$ingresar2);
        }
    
?>