<?php
include '../../conexionbd.php';
date_default_timezone_set('America/Guatemala');

/**** Borrar Carrito de Ceye ****/
if (@$_GET['q'] == 'del_car') {
  $cart_stock_id = $_GET['cart_stock_id'];
  $cart_qty = $_GET['cart_qty'];
  $paciente = $_GET['paciente'];
  $cart_id = $_GET['cart_id'];
  $id_m_enf = $_GET['idmedicaenf'];

  $sql1 = "DELETE FROM cart_ceye WHERE cart_id = $cart_id";
  $result1 = $conexion->query($sql1);

   echo '<script type="text/javascript">window.location.href = "surtir_med.php?id_atencion=' . $paciente . '";</script>';
  
}

/**** Confirmar Carrito de Ceye ****/
if (@$_GET['q'] == 'comf_cart') 
{
  $cart_stock_id = $_GET['cart_stock_id'];
  $cart_qty = $_GET['cart_qty'];
  $paciente = $_GET['paciente'];
  $cart_id = $_GET['id_cart'];
  $id_m_enf = $_GET['idmedicaenf'];    
    
  $id_atencion = $_GET['paciente'];
  $id_usua = $_GET['id_usua'];

  
  $sql2 = "SELECT * FROM cart_ceye c, material_ceye m, item_type it where 
  c.material_id = m.material_id and 
  m.material_tipo = it.item_type_id and 
  c.paciente = $id_atencion and
  c.cart_id = $cart_id";
  $result = $conexion->query($sql2);

  while ($row_stock = $result->fetch_assoc()) {
    $material_id = $row_stock['material_id'];
    $item_id = $row_stock['material_id'];
    $material_codigo = $row_stock['material_codigo'];
    $material_nombre = $row_stock['material_nombre'];
    $material_fabricante = $row_stock['material_fabricante'];
    $material_contenido = $row_stock['material_contenido'];
    $material_tipo = $row_stock['material_tipo'];
    $mat_nom=$row_stock['material_nombre'].' '.$row_stock['material_contenido'];
    $cart_fecha = $row_stock['cart_fecha'];
    $cart_qty = $row_stock['cart_qty'];
    $cart_price = $row_stock['cart_price'];
    $qty=$cart_qty;
    $qty_salida=$cart_qty;
    $tipo='QUIROFANO';
    $unimed='PIEZA';
    $solicitante = $row_stock['id_usua'];
  }
  
   $sql4 = "SELECT id_usua, papell FROM reg_usuarios where id_usua = $solicitante ";
    $result4 = $conexion->query($sql4);
    while ($row_usua = $result4->fetch_assoc()) {
        $sol = $row_usua['papell'];
    }
  
    $fecha_actual = date("Y-m-d H:i:s");
    

    $sql_insert = "INSERT INTO sales_ceye(
        item_id,
        item_code,
        generic_name,
        brand,
        gram,
        type,
        qty,
        price,
        date_sold,
        paciente,
        id_usua,
        solicita,
        fecha_solicitud) VALUES(
        $material_id,
        '$material_codigo',
        '$material_nombre',
        '$material_fabricante',
        '$material_contenido',
        '$material_tipo',
        $cart_qty,
        $cart_price,
        '$fecha_actual',
        $id_atencion,
        $id_usua,
        '$sol',
        '$fecha_actual')";

    $result_insert = $conexion->query($sql_insert);

/*************************** inserta dat_ctapac  **********************/   
     $sql_insert_cuenta = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,cta_tot,id_usua,cta_activo,centro_cto)VALUES('$id_atencion','PC','$item_id','$fecha_actual','$cart_qty',$cart_price,'$id_usua','SI','QUIRÓFANO')";
    
    echo mysqli_query($conexion,$sql_insert_cuenta);


/*************************** inserta medica_enf **********************/    
     $ingresar9 = mysqli_query($conexion, 'INSERT INTO medica_enf 
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
('.$id_atencion.',
"'.$fecha_actual.'",
"'.$mat_nom.'",
"'.$unimed.'",
'.$id_usua .',
"'.$cart_fecha.'",
"'.$tipo.'",
"'.$qty.'",
'.$item_id.',
"Si") ') or die('<p>Error al registrar medica_enf</p><br>' . mysqli_error($conexion));


/*************************** modifica existencias  **********************/   
    $existenciasc=0;
    $salidasc=0;
    $sql2c = $conexion->query("SELECT * FROM stock_ceye where stock_ceye.item_id=$item_id") or die('<p>Error al encontrar stock CEYE</p><br>' . mysqli_error($conexion));
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
            $sql3c = "UPDATE stock_ceye set stock_qty=$stock_finalc, stock_salidas=$salidas_finalc, stock_added='$fecha_actual',id_usua=$id_usua where stock_ceye.item_id = $item_id";
            $result3c = $conexion->query($sql3c);
        }
        else {
            $ingresar = mysqli_query($conexion, 'insert into stock_ceye (item_id,stock_qty,stock_salidas,stock_added,id_usua) values(' . $item_id . ',' . $qty . ',' . $qty_salida . ',"' . $fecha_actual . '",' . $id_usua . ')') or die('<p>Error al registrar stock CEYE</p><br>' . mysqli_error($conexion));
        }

 /*************************** Inserta solicitar al almacen desde CEYE  **********************/   
    include "../../conexionalma.php";
    if ($material_id <> 1124) {
        $cart_uniquid = uniqid();
        $sqlalm = "INSERT INTO cart_recib(item_id,cart_qty,destino,cart_uniqid,almacen,confirma)VALUES
              ('$item_id','$cart_qty','TOLUCA','$cart_uniquid','CEYE','SI')";
        echo mysqli_query($conexion_almacen,$sqlalm);
    }  
  
  
/*************************** Borra el carrito de ceye ya confirmado  **********************/ 

  $sql_delCart = "DELETE FROM cart_ceye WHERE paciente = $id_atencion and cart_id=$cart_id";
  $result_delCart = $conexion->query($sql_delCart);


  if ($result_delCart && $result_insert) {

    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "Material Quirúrgico Confirmado Correctamente", 
                            type: "success",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                            window.location.href = "surtir_med.php?id_atencion='.$paciente.'";

                            }
                        });
                    });
                </script>';
  } else {

    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                        $(document).ready(function() {
                            swal({
                                title: "Error al confirmar el Material Quirúrgico, Verificar existencias", 
                                type: "error",
                                confirmButtonText: "ACEPTAR"
                            }, function(isConfirm) { 
                                if (isConfirm) {
                                window.location.href = "surtir_med.php?id_atencion='.$paciente.'";
                                
                                

                                }
                            });
                        });
                    </script>';
  }
}


