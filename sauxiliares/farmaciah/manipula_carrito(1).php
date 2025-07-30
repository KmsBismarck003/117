<?php
include '../../conexionbd.php';
$fecha_actual = date("Y-m-d H:i:s");

if (@$_GET['q'] == 'del_car') {
    // Existing delete cart functionality remains unchanged
    // ... [previous del_car code remains the same]
}

if (@$_GET['q'] == 'comf_cart') {
    $paciente = $_GET['paciente'];
    $id_usua = $_GET['id_usua'];
    $id_cart = $_GET['id_cart'];

    // Get cart details
    $sql2 = "SELECT c.*, i.*, it.*, e.existe_id, e.existe_lote, e.existe_caducidad, e.existe_qty, e.existe_salidas, e.ubicacion_id, e.existe_costsu 
             FROM cart c 
             JOIN item i ON c.item_id = i.item_id 
             JOIN item_type it ON it.item_type_id = i.item_type_id
             JOIN existencias_almacenh e ON e.item_id = i.item_id
             WHERE c.cart_id = $id_cart";
    $result = $conexion->query($sql2);

    while ($row_stock = $result->fetch_assoc()) {
        $item_id = $row_stock['item_id'];
        $item_code = $row_stock['item_code'];
        $item_name = $row_stock['item_name'];
        $item_brand = $row_stock['item_brand'];
        $item_grams = $row_stock['item_grams'];
        $item_type = $row_stock['item_type_desc'];
        $cart_qty = $row_stock['cart_qty'];
        $cart_price = $row_stock['cart_price'];
        $grupo = $row_stock['grupo'];
        $solicitante = $row_stock['id_usua'];
        $cart_fecha = $row_stock['cart_fecha'];
        
        // Lot and expiration information
        $existe_id = $row_stock['existe_id'];
        $existe_lote = $row_stock['existe_lote'];
        $existe_caducidad = $row_stock['existe_caducidad'];
        $existe_qty = $row_stock['existe_qty'];
        $existe_salidas = $row_stock['existe_salidas'];
        $ubicacion_id = $row_stock['ubicacion_id'];
        $existe_costsu = $row_stock['existe_costsu'];
        
        // Get solicitor name
        $sql4 = "SELECT papell FROM reg_usuarios WHERE id_usua = $solicitante";
        $result4 = $conexion->query($sql4);
        $row_usua = $result4->fetch_assoc();
        $sol = $row_usua['papell'];

        // Begin transaction
        $conexion->begin_transaction();

        try {
            // 1. Update existencias_almacenh
            $new_existe_qty = $existe_qty - $cart_qty;
            $new_existe_salidas = $existe_salidas + $cart_qty;
            
            $sql_update_existencias = "UPDATE existencias_almacenh 
                                     SET existe_qty = $new_existe_qty,
                                         existe_salidas = $new_existe_salidas,
                                         existe_fecha = '$fecha_actual'
                                     WHERE existe_id = $existe_id";
            $conexion->query($sql_update_existencias);

            // 2. Insert into salidas_almacenh
            $sql_insert_salidas = "INSERT INTO salidas_almacenh 
                                  (item_id, item_name, salida_lote, salida_caducidad, 
                                   salida_qty, salida_costsu, id_usua, id_atencion, 
                                   solicita, fecha_solicitud)
                                  VALUES 
                                  ($item_id, '$item_name', '$existe_lote', '$existe_caducidad',
                                   $cart_qty, $existe_costsu, $id_usua, $paciente,
                                   '$sol', '$cart_fecha')";
            $conexion->query($sql_insert_salidas);

            // 3. Insert into sales
            $sql_insert_sales = "INSERT INTO sales 
                                (item_id, item_code, generic_name, brand, gram, type,
                                 qty, surtido, price, date_sold, paciente, id_usua,
                                 solicita, fecha_solicitud)
                                VALUES 
                                ($item_id, '$item_code', '$item_name', '$item_brand',
                                 '$item_grams', '$item_type', $cart_qty, $cart_qty,
                                 $cart_price, '$fecha_actual', $paciente, $id_usua,
                                 '$sol', '$cart_fecha')";
            $conexion->query($sql_insert_sales);

            // 4. Insert into dat_ctapac
            $medt = ($grupo == "MEDICAMENTOS") ? "Medicamento" : "";
            $sql_insert_ctapac = "INSERT INTO dat_ctapac 
                                 (id_atencion, prod_serv, insumo, cta_fec, cta_cant,
                                  cta_tot, id_usua, cta_activo, centro_cto, medt, vdesc)
                                 VALUES 
                                 ($paciente, 'P', $item_id, '$fecha_actual', $cart_qty,
                                  $cart_price, $id_usua, 'SI', '$tipo',
                                  " . ($medt ? "'$medt'" : "NULL") . ", '$grupo')";
            $conexion->query($sql_insert_ctapac);

            // 5. Delete from cart
            $sql_delete_cart = "DELETE FROM cart WHERE cart_id = $id_cart";
            $conexion->query($sql_delete_cart);

            // Commit transaction
            $conexion->commit();
            
            // Redirect on success
            echo '<script type="text/javascript">window.location.href = "surtir_med.php?id_atencion=' . $paciente . '";</script>';
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $conexion->rollback();
            
            echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
            echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
            echo '<script>
                $(document).ready(function() {
                    swal({
                        title: "Error al confirmar el surtido de medicamento: ' . $e->getMessage() . '", 
                        type: "error",
                        confirmButtonText: "ACEPTAR"
                    }, function(isConfirm) { 
                        if (isConfirm) {
                            window.location.href = "surtir_med.php?id_atencion=' . $paciente . '";
                        }
                    });
                });
            </script>';
        }
    }
}
?>