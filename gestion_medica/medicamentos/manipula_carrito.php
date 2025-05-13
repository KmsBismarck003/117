<?php
include '../../conexionbd.php';

if (@$_GET['q'] == 'del_car') {
  $cart_stock_id = $_GET['cart_stock_id'];
  $cart_qty = $_GET['cart_qty'];
  $paciente = $_GET['paciente'];
  $cart_id = $_GET['cart_id'];


  $sql2 = "SELECT * FROM stock_ceye where stock_id = $cart_stock_id";
  $result = $conexion->query($sql2);

  while ($row_stock = $result->fetch_assoc()) {
    $stock = $row_stock['stock_qty'];
  }

  $stock_final = $stock + $cart_qty;


  $sql1 = "DELETE FROM cart_ceye WHERE cart_id = $cart_id";
  $result1 = $conexion->query($sql1);

$sql3 = "DELETE FROM medicamentos_ceye WHERE cart_id = $cart_id";
  $result3 = $conexion->query($sql3);

  $sql2 = "UPDATE stock_ceye set stock_qty=$stock_final where stock_id = $cart_stock_id";
  $result2 = $conexion->query($sql2);
  header('location: confirmar.php');

 /* echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
  echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
  echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
  echo '<script>
                  $(document).ready(function() {
                      swal({
                          title: "Insumo Quirúrgico eliminado correctamente", 
                          type: "success",
                          confirmButtonText: "ACEPTAR"
                      }, function(isConfirm) { 
                          if (isConfirm) {
                              window.location.href = "../hospitalizacion/vista_pac_hosp.php";
                          }
                      });
                  });
              </script>';*/
}

if (@$_GET['q'] == 'comf_cart') {
  $paciente = $_GET['paciente'];
  $id_usua = $_GET['id_usua'];
  $id_cart = $_GET['id_cart'];
  $id_atencion = $_GET['id_atencion'];

  $sql2 = "SELECT * FROM cart_ceye , material_ceye , item_type  where cart_ceye.material_id = material_ceye.material_id and paciente = $paciente and cart_ceye.cart_id = $id_cart";
  $result = $conexion->query($sql2);

  while ($row_stock = $result->fetch_assoc()) {
    $material_id = $row_stock['material_id'];
    $material_codigo = $row_stock['material_codigo'];
    $material_nombre = $row_stock['material_nombre'];
    $material_fabricante = $row_stock['material_fabricante'];
    $material_contenido = $row_stock['material_contenido'];
    $material_tipo = $row_stock['material_tipo'];
    $cart_qty = $row_stock['cart_qty'];
    $material_precio = $row_stock['material_precio'];
  }

 /* $insertar=mysqli_query($conexion,'INSERT INTO sales_ceye(item_code,generic_name,brand,gram,type,qty,price, paciente) values ("'.$material_id.'","'.$material_nombre.'","'.$material_fabricante.'","'.$material_contenido.'","'.$material_tipo.'","'.$cart_qty.'","'.$material_precio.'","'.$paciente.'")')  or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));*/

    $sql_insert = "INSERT INTO sales_ceye(item_code,generic_name,brand,gram,type,qty,price, paciente)
    VALUES('$material_codigo','$material_nombre', '$material_fabricante','$material_contenido','$material_tipo',$cart_qty,$material_precio,$paciente)";

    $result_insert = $conexion->query($sql_insert);

$fecha_actual = date("Y-m-d H:i:s");

    $sql_insert_cuenta = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,cta_tot,id_usua,cta_activo)VALUES('$id_atencion','PC','$material_id','$fecha_actual','$cart_qty',0.00,'$id_usua','SI')";
    $result_insert_cuenta = $conexion->query($sql_insert_cuenta);

  $sql_delCart = "DELETE FROM cart_ceye WHERE cart_id = $id_cart";
  $result_delCart = $conexion->query($sql_delCart);

  if ($result_delCart && $result_insert) {
header('location: confirmar.php');
    /*echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "Insumo Quirúrgico Validado Correctamente", 
                            type: "success",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                            window.location.href = "../hospitalizacion/vista_pac_hosp.php";
                            }
                        });
                    });
                </script>';*/
  } else {

    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                        $(document).ready(function() {
                            swal({
                                title: "Error al confirmar el Insumo Quirúrgico, Verificar con Ceye", 
                                type: "error",
                                confirmButtonText: "ACEPTAR"
                            }, function(isConfirm) { 
                                if (isConfirm) {
                                window.location.href = "../hospitalizacion/vista_pac_hosp.php";

                                }
                            });
                        });
                    </script>';
  }
}

if (@$_GET['q'] == 'eliminar_serv') {
  $paciente = $_GET['paciente'];
  $cart_qty = $_GET['cart_qty'];
  $cart_id = $_GET['cart_id'];


  $sql1 = "DELETE FROM cart_serv WHERE cart_id = $cart_id";
  $result1 = $conexion->query($sql1);

  $sql1 = "DELETE FROM equipos_ceye WHERE cart_id = $cart_id";
  $result1 = $conexion->query($sql1);

  header('location: confirmar.php');
}

if (@$_GET['q'] == 'comf_cartserv') {
  $paciente = $_GET['paciente'];
  $id_usua = $_GET['id_usua'];
  $id_cart = $_GET['id_cart'];
  $id_atencion = $_GET['id_atencion'];

  $sql2 = "SELECT * FROM cart_serv , cat_servicios  where cart_serv.servicio_id = cat_servicios.id_serv and paciente = $paciente and cart_serv.cart_id = $id_cart";
  $result = $conexion->query($sql2);

  while ($row_stock = $result->fetch_assoc()) {
    $servicio_id = $row_stock['servicio_id'];
    $cart_qty = $row_stock['cart_qty'];
  }

    $sql_insert_cuenta = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,cta_tot,id_usua,cta_activo)VALUES('$id_atencion','S','$servicio_id','$fecha_actual','$cart_qty',0.00,'$id_usua','SI')";
    $result_insert_cuenta = $conexion->query($sql_insert_cuenta);

  $sql_delCart = "DELETE FROM cart_serv WHERE cart_id = $id_cart";
  $result_delCart = $conexion->query($sql_delCart);

  if ($result_delCart) {
header('location: confirmar.php');
    /*echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "Insumo Quirúrgico Validado Correctamente", 
                            type: "success",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                            window.location.href = "../hospitalizacion/vista_pac_hosp.php";
                            }
                        });
                    });
                </script>';*/
  } else {

    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                        $(document).ready(function() {
                            swal({
                                title: "Error al confirmar el Insumo Quirúrgico, Verificar con Ceye", 
                                type: "error",
                                confirmButtonText: "ACEPTAR"
                            }, function(isConfirm) { 
                                if (isConfirm) {
                                window.location.href = "../hospitalizacion/vista_pac_hosp.php";

                                }
                            });
                        });
                    </script>';
  }
}