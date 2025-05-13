<?php
include '../../conexionbd.php';

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.fecha, di.area, di.alta_med, di.alta_adm, di.valida,   FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

        $result_pac = $conexion->query($sql_pac);

        while ($row_pac = $result_pac->fetch_assoc()) {
          $pac_papell = $row_pac['papell'];
          $pac_sapell = $row_pac['sapell'];
          $pac_nom_pac = $row_pac['nom_pac'];
          $pac_dir = $row_pac['dir'];
          $pac_id_edo = $row_pac['id_edo'];
          $pac_id_mun = $row_pac['id_mun'];
          $pac_tel = $row_pac['tel'];
          $pac_fecnac = $row_pac['fecnac'];
          $pac_fecing = $row_pac['fecha'];
          
          $alta_med = $row_pac['alta_med'];
          $alta_adm = $row_pac['alta_adm'];
          $valida = $row_pac['valida'];
          $area = $row_pac['area'];
          $id_exp=$row_pac['Id_exp'];
          
        }

if (@$_GET['q'] == 'del_car') {
  $cart_stock_id = $_GET['cart_stock_id'];
  $cart_qty = $_GET['cart_qty'];
  $paciente = $_GET['paciente'];
  $cart_id = $_GET['cart_id'];
  $id_m_enf = $_GET['idmedicaenf'];
  $existec = "NO";

/*
  $sql2 = "SELECT * FROM stock_ceye where stock_id = $cart_stock_id";
  $result = $conexion->query($sql2);

  while ($row_stock = $result->fetch_assoc()) {
    $stock = $row_stock['stock_qty'];
    $salidas = $row_stock['stock_salidas'];
  }

  $stock_final = $stock + $cart_qty;
  $stock_salidas = $salidas + $cart_qty;
*/

  $sql1 = "DELETE FROM cart_ceye WHERE cart_id = $cart_id";
  $result1 = $conexion->query($sql1);

  $sql3 = "DELETE FROM medicamentos_ceye WHERE cart_id = $cart_id";
  $result3 = $conexion->query($sql3);
  
    $sql4 = "DELETE FROM medica_enf WHERE id_med_reg = $id_m_enf";
  $result4 = $conexion->query($sql4);
/*
  $sql2 = "UPDATE stock_ceye set stock_qty=$stock_final, stock_salidas=$stock_salidas where stock_id = $cart_stock_id";
  $result2 = $conexion->query($sql2);*/
  header('location: vista_enf_quirurgico.php');

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

if (@$_GET['q'] == 'comf_cart') 
{
  $paciente = $_GET['paciente'];
  $id_usua = $_GET['id_usua'];
  //$id_cart = $_GET['id_cart'];
  $id_atencion = $_GET['id_atencion'];

  $sql2 = "SELECT * FROM cart_ceye , material_ceye , item_type  where cart_ceye.material_id = material_ceye.material_id and material_ceye.material_tipo=item_type.item_type_id and paciente = $id_atencion";
  $result = $conexion->query($sql2);

  while ($row_stock = $result->fetch_assoc()) {
    $material_id = $row_stock['material_id'];
    $item_id = $row_stock['material_id'];
    $material_codigo = $row_stock['material_codigo'];
    $material_nombre = $row_stock['material_nombre'];
    $material_fabricante = $row_stock['material_fabricante'];
    $material_contenido = $row_stock['material_contenido'];
    $material_tipo = $row_stock['material_tipo'];
    $cart_qty = $row_stock['cart_qty'];
    $cart_price = $row_stock['cart_price'];
    $qty=$cart_qty;
    $qty_salida=$cart_qty;

    

$fecha_actual = date("Y-m-d H:i:s");

    $sql_insert = "INSERT INTO sales_ceye(item_id,item_code,generic_name,brand,gram,type,qty,price,date_sold,paciente,id_usua,fecha_solicitud) VALUES('$material_id','$material_codigo','$material_nombre','$material_fabricante','$material_contenido','$material_tipo',$cart_qty,$cart_price,'$fecha_actual',$id_atencion,$id_usua,'$fecha_actual')";

    $result_insert = $conexion->query($sql_insert);

    $sql_insert_cuenta = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,cta_tot,id_usua,cta_activo,centro_cto)VALUES('$id_atencion','PC','$material_id','$fecha_actual','$cart_qty',$cart_price,'$id_usua','SI','QUIRÓFANO')";
    $result_insert_cuenta = $conexion->query($sql_insert_cuenta);

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
            $ingresar = mysqli_query($conexion, 'insert into stock (item_id,stock_qty,stock_salidas,stock_added,id_usua) values(' . $item_id . ',' . $qty . ',' . $qty_salida . ',"' . $fecha_actual . '",' . $id_usua . ')') or die('<p>Error al registrar stock FARMACIA</p><br>' . mysqli_error($conexion));
        }

  }
/*
 $insertar=mysqli_query($conexion,'INSERT INTO sales_ceye(item_code,generic_name,brand,gram,type,qty,price, paciente) values ("'.$material_id.'","'.$material_nombre.'","'.$material_fabricante.'","'.$material_contenido.'","'.$material_tipo.'","'.$cart_qty.'","'.$material_precio.'","'.$paciente.'")')  or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
*/
  $sql_delCart = "DELETE FROM cart_ceye WHERE paciente = $id_atencion";
  $result_delCart = $conexion->query($sql_delCart);

  

  if ($result_delCart && $result_insert) {

    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "Medicamento Quirúrgico Validado Correctamente", 
                            type: "success",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                            window.location.href = "vista_enf_quirurgico.php";

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
                                title: "Error al confirmar el Medicamento Quirúrgico, Verificar con Ceye", 
                                type: "error",
                                confirmButtonText: "ACEPTAR"
                            }, function(isConfirm) { 
                                if (isConfirm) {
                                window.location.href = "vista_enf_quirurgico.php";

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

  header('location: vista_enf_quirurgico.php');
}

if (@$_GET['q'] == 'comf_cartserv') {
  $paciente = $_GET['paciente'];
  $id_usua = $_GET['id_usua'];
 // $id_cart = $_GET['id_cart'];
  $id_atencion = $_GET['id_atencion'];

  $sql2 = "SELECT * FROM cart_serv , cat_servicios , item_type where cart_serv.servicio_id = cat_servicios.id_serv and cat_servicios.tipo= item_type.item_type_id and paciente = $id_atencion";
  $result = $conexion->query($sql2);
  while ($row_stock = $result->fetch_assoc()) {
    $servicio_id = $row_stock['servicio_id'];
    $cart_qty = $row_stock['cart_qty'];
   
$fecha_actual = date("Y-m-d H:i:s");

    $sql_insert_cuenta = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,cta_tot,id_usua,cta_activo,centro_cto)VALUES('$id_atencion','S','$servicio_id','$fecha_actual','$cart_qty',0.00,'$id_usua','SI','QUIRÓFANO')";
    $result_insert_cuenta = $conexion->query($sql_insert_cuenta);

  }
//INSERT A EQUIPOS CEYE  

  $sql_delCart = "DELETE FROM cart_serv WHERE paciente = $id_atencion";
  $result_delCart = $conexion->query($sql_delCart);

  if ($result_insert_cuenta) {

    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
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
                            window.location.href = "vista_enf_quirurgico.php";

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
                                title: "Error al confirmar el Insumo Quirúrgico, Verificar con Ceye", 
                                type: "error",
                                confirmButtonText: "ACEPTAR"
                            }, function(isConfirm) { 
                                if (isConfirm) {
                                window.location.href = "vista_enf_quirurgico.php";


                                }
                            });
                        });
                    </script>';
  }
}