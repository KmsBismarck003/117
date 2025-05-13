<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

$id_atencion = $_REQUEST['paciente'];

  $sql2 = "SELECT * FROM cart_almacen WHERE paciente = $id_atencion and tipo != 'QUIROFANO'";
  $result = $conexion->query($sql2);

  while ($row_stock = $result->fetch_assoc()) {
    $cart_id = $row_stock['id'];
    $item_id = $row_stock['item_id'];
    $cart_qty = $row_stock['cart_qty'];
    $cart_surtido = $row_stock['cart_surtido'];
    $cart_price = $row_stock['cart_price'];
    
    $fecha_mat = $row_stock['enf_fecha'];
    $hora_med  = $row_stock['cart_hora'];
    $turno     = $row_stock['turno'];
    $med_nom   = $row_stock['medicam_mat'];
    $dosis     = $row_stock['dosis_mat'];
    $unimed    = $row_stock['unimed'];
    $via       = $row_stock['via_mat'];
    $fechahora = $row_stock['cart_fecha'];
    $tipo      = $row_stock['tipo'];
    $otro      = $row_stock['otro'];
  
    $qty=$cart_qty;
    $qty_salida=$cart_qty;
    
    $solicitante = $row_stock['id_usua'];
    
    if ($qty > 0) {
    
    $sql3 = "SELECT * FROM item WHERE item_id = '".$row_stock['item_id']."'";
    $resulti = $conexion->query($sql3);
    while ($row_stocki = $resulti->fetch_assoc()) {
    $item_id = $row_stocki['item_id'];
    $item_code = $row_stocki['item_code'];
    $item_name = $row_stocki['item_name'];
    $item_brand = $row_stocki['item_brand'];
    $item_grams = $row_stocki['item_grams'];
    $item_type = $row_stocki['item_type'];
    $grupo = $row_stocki['grupo'];
    
    $fecha_actual = date("Y-m-d H:i:s");
    
    $sql4 = "SELECT id_usua, papell FROM reg_usuarios where id_usua = $solicitante ";
    $result4 = $conexion->query($sql4);
    while ($row_usua = $result4->fetch_assoc()) {
    $sol = $row_usua['papell'];
    }

    if ($material_id <> 1124) {
    $sql_insert = "INSERT INTO sales(item_id,item_code,generic_name,brand,gram,type,qty,surtido,price,date_sold,paciente,id_usua,solicita,fecha_solicitud) VALUES('$item_id','$item_code','$item_name','$item_brand','$item_grams','$item_type',$cart_qty,$cart_surtido,$cart_price,'$fecha_actual',$id_atencion,$id_usua,'$sol','$fecha_actual')";
  
    mysqli_query($conexion,$sql_insert);

    if($grupo=="MEDICAMENTOS"){
          $sql_insert_cuenta = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,cta_tot,id_usua,cta_activo,centro_cto)
          VALUES('$id_atencion','P','$item_id','$fecha_actual','$cart_qty',$cart_price,'$id_usua','SI','$tipo')";
    }else if($grupo!="MEDICAMENTOS"){
    
        $sql_insert_cuenta = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,cta_tot,id_usua,cta_activo,centro_cto)
        VALUES('$id_atencion','P','$item_id','$fecha_actual','$cart_qty',$cart_price,'$id_usua','SI','$tipo')";
    }

    /*************************** Inserta solicitar al almacen desde FARMACIA  **********************/   
    include "../../conexionalma.php";
    if ($material_id <> 1124) {
        $cart_uniquid = uniqid();
        $sqlalm = "INSERT INTO cart_recib(item_id,cart_qty,destino,cart_uniqid,almacen,confirma)VALUES
              ('$item_id','$cart_qty','TOLUCA','$cart_uniquid','FARMACIA','SI')";
        echo mysqli_query($conexion_almacen,$sqlalm);
    }
    
    mysqli_query($conexion,$sql_insert_cuenta);

    $existenciasc=0;
    $salidasc=0;
    $sql2c = $conexion->query("SELECT * FROM stock where stock.item_id=$item_id") or die('<p>Error al encontrar stock FARMACIA</p><br>' . mysqli_error($conexion));
        while ($row_stockc = $sql2c->fetch_assoc()) {
          $existenciasc = $row_stockc['stock_qty'];
          $salidasc = $row_stockc['stock_salidas'];
          $existec = "SI";
        }
    
        $stock_finalc = 0;
        $salidas_finalc = 0;
        if ($existec === "SI") {
            $stock_finalc = $existenciasc - $qty;
            $salidas_finalc = $salidasc + $qty_salida;
            $sql3c = "UPDATE stock set stock_qty=$stock_finalc, stock_salidas=$salidas_finalc, stock_added='$fecha_actual',id_usua=$id_usua where stock.item_id = $item_id";
            $result3c = $conexion->query($sql3c);
        }
        else {
            $ingresar = mysqli_query($conexion, 'insert into stock (item_id,stock_qty,stock_salidas,stock_added,id_usua) values(' . $item_id . ',' . $qty . ',' . $qty_salida . ',"' . $fecha_actual . '",' . $id_usua . ')') or die('<p>Error al registrar stock FARMACIA</p><br>' . mysqli_error($conexion));
        }
    }        
 

  }


$sql_delCart = "DELETE FROM cart_almacen WHERE id = $cart_id";

mysqli_query($conexion,$sql_delCart);
    }
}
echo '<script type="text/javascript">window.location.href = "orderqx.php?paciente=' . $id_atencion . '";</script>';
?>