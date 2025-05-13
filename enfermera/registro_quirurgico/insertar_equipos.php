<?php
session_start();
        include "../../conexionbd.php";
        $usuario = $_SESSION['login'];
        $id_usua= $usuario['id_usua'];
        $id_atencion = $_SESSION['pac'];
        $serv_id =  mysqli_real_escape_string($conexion, (strip_tags($_POST["serv"], ENT_QUOTES))); //Escanpando caracteres
        $cart_uniquid = uniqid();
        $qty_serv =  mysqli_real_escape_string($conexion, (strip_tags($_POST["qty_serv"], ENT_QUOTES))); //Escanpando caracteres

  
        $fecha_actual = date("Y-m-d H:i:s");
        $sql_pac = "SELECT p.Id_exp, di.id_atencion FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";
        $result_pac = $conexion->query($sql_pac);
        while ($row_pac = $result_pac->fetch_assoc()) {
          $paciente1 = $row_pac['Id_exp'];
        }
        $sql_in_serv = "INSERT INTO cart_serv(servicio_id,cart_qty,id_usua,cart_uniqid,paciente,cart_fecha)VALUES($serv_id,$qty_serv,$id_usua,'$cart_uniquid', $id_atencion,'$fecha_actual');";
            // echo $sql2;
            echo mysqli_query($conexion,$sql_in_serv);
        //$result_cart_serv = $conexion->query($sql_in_serv);
        $sql_stock = "SELECT * FROM cat_servicios where id_serv=$serv_id ";
            //echo $sql_stock;
        $result_stock = $conexion->query($sql_stock);
        while ($row_stock = $result_stock->fetch_assoc()) {
            $serv_desc = $row_stock['serv_desc'];
        }

        $sql_cartid = "SELECT * FROM cart_serv where paciente=$id_atencion ORDER BY cart_id DESC LIMIT 1 ";
            //echo $sql_cartid;
        $result_cartid = $conexion->query($sql_cartid);
        while ($row_cartid = $result_cartid->fetch_assoc()) {
            $cart_id = $row_cartid['cart_id'];
        }

  
        $fecha_actual = date("Y-m-d H:i:s");
            $fecha_registro = date("Y-m-d");
        $ingresar2 = mysqli_query($conexion, 'INSERT INTO equipos_ceye (cart_id,id_atencion,id_usua,serv_id,nombre,tiempo,fecha,fecha_registro) values ('.$cart_id.',' . $id_atencion . ',' . $id_usua .',"' . $serv_id . '","'.$serv_desc.'",' . $qty_serv .',"'.$fecha_actual.'","'.$fecha_registro.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
     
         
         
         echo mysqli_query($conexion,$ingresar2);
    
    ?>