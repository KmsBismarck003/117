<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_REQUEST['paciente'];

$sql2 = "SELECT * FROM cart_mat WHERE paciente = $id_atencion";
$result = $conexion->query($sql2);

while ($row_stock = $result->fetch_assoc()) {
    $cart_id = $row_stock['id'];
    $material_id = $row_stock['material_id'];
    $item_id = $row_stock['material_id'];
    $cart_qty = $row_stock['cart_qty'];
    $cart_surtido = $row_stock['cart_surtido'];
    $cart_price = $row_stock['cart_price'];
    $cart_stock_id = $row_stock['cart_stock_id'];
    $cart_uniqid = $row_stock['cart_uniqid'];
   
    $cart_fecha = $row_stock['cart_fecha'];
    
    $fecha_mat = $row_stock['cart_fecha'];
    $hora_med  = "";
    $turno     = "";
    $med_nom   = $row_stock['medicam_mat'];
    $dosis     = "";
    $unimed    ='PIEZA';
    $via       = "";
    $fechahora = $row_stock['cart_fecha'];
    $tipo      ='QUIROFANO';
    $otro      = "";
    
    $qty=$cart_qty;
    $qty_salida=$cart_qty;
    
    $solicitante = $row_stock['id_usua'];
    
    if ($qty > 0) {
    
    $sql3 = "SELECT * FROM material_ceye WHERE material_id = $material_id";
    $resulti = $conexion->query($sql3);
    while ($row_stocki = $resulti->fetch_assoc()) {
    $item_id = $row_stocki['material_id'];
    $item_code = $row_stocki['material_codigo'];
    $item_name = $row_stocki['material_nombre'];
    $item_brand = $row_stocki['material_fabricante'];
    $item_grams = $row_stocki['material_contenido'];
    $item_type = $row_stocki['material_tipo'];
    
    
    $fecha_actual = date("Y-m-d H:i:s");
    
    $sql4 = "SELECT id_usua, papell FROM reg_usuarios where id_usua = $solicitante ";
    $result4 = $conexion->query($sql4);
    while ($row_usua = $result4->fetch_assoc()) {
    $sol = $row_usua['papell'];
    }

  if ($material_id <> 1124) {
    $sql_insert = "INSERT INTO sales_ceye (item_id,item_code,generic_name,brand,gram,type,qty,surtido,price,date_sold,paciente,id_usua,solicita,fecha_solicitud) VALUES('$item_id','$item_code','$item_name','$item_brand','$item_grams','$item_type',$cart_qty,$cart_surtido,$cart_price,'$fecha_actual',$id_atencion,$id_usua,'$sol','$fecha_actual')";
  
    echo mysqli_query($conexion,$sql_insert);

    $sql_insert_cuenta = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,cta_tot,id_usua,cta_activo)VALUES('$id_atencion','PC','$item_id','$fecha_actual','$cart_qty',$cart_price,'$id_usua','SI')";
    
    echo mysqli_query($conexion,$sql_insert_cuenta);

/*************************** modifica existencias  **********************/  
    $existenciasc=0;
    $salidasc=0;
    $sql2c = $conexion->query("SELECT * FROM stock_ceye where item_id=$item_id") or die('<p>Error al encontrar stock CEYE</p><br>' . mysqli_error($conexion));
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
            $sql3c = "UPDATE stock_ceye set stock_qty=$stock_finalc, stock_salidas=$salidas_finalc, stock_added='$fecha_actual',id_usua=$id_usua where item_id = $item_id";
           
            echo mysqli_query($conexion,$sql3c);
        }
        else {
            $ingresar = "INSERT IN TO stock_ceye (item_id,stock_qty,stock_salidas,stock_added,id_usua) VALUES('$item_id','$qty','$qty_salida','$fecha_actual','$id_usua')";
            
            echo mysqli_query($conexion,$ingresar);
        }
  }    
//insert a medica enf //insert a medica enf//insert a medica enf//insert a medica enf//insert a medica enf
        

/*************************** inserta medica_enf **********************/    
$ingresar9 = "INSERT INTO medica_enf 
(id_atencion,
fecha_mat,
medicam_mat,
unimed,
id_usua,
enf_fecha,
tipo,
cantidad,
material_id,
material)
values 
('$id_atencion',
'$fecha_actual',
'$med_nom',
'$unimed',
'$id_usua',
'$cart_fecha',
'$tipo',
'$qty',
'$item_id',
'Si')";

echo mysqli_query($conexion,$ingresar9);

    }  
   
$sql_delCart = "DELETE FROM cart_mat WHERE id = $cart_id";

echo mysqli_query($conexion,$sql_delCart);

    }    
}
?>