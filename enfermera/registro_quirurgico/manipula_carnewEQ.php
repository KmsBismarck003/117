<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
$id_atencion = $_REQUEST['id_atencion'];
$id_atencion = $_POST['id_atencion'];

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.fecha, di.area, di.alta_med, di.alta_adm, di.valida, di.correo, di.correo_encuesta  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
          $correo = $row_pac['correo'];
          $correo_encuesta = $row_pac['correo_encuesta'];
        }


 $sql2 = "SELECT * FROM cart_serv , cat_servicios , item_type where cart_serv.servicio_id = cat_servicios.id_serv and cat_servicios.tipo= item_type.item_type_id and paciente = $id_atencion";
  $result = $conexion->query($sql2);
  while ($row_stock = $result->fetch_assoc()) {
    $servicio_id = $row_stock['servicio_id'];
    $cart_qty = $row_stock['cart_qty'];
    $cart_id = $row_stock['id'];
    $serv_desc = $row_stock['serv_desc'];
    
$fecha_actual = date("Y-m-d H:i:s");

    $sql_insert_cuenta = "INSERT INTO dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,cta_tot,id_usua,cta_activo,centro_cto)VALUES('$id_atencion','S','$servicio_id','$fecha_actual','$cart_qty',0.00,'$id_usua','SI','QUIRÓFANO')";
  echo mysqli_query($conexion,$sql_insert_cuenta);
  
  //INSERT A EQUIPOS CEYE  
//INSERT A EQUIPOS CEYE 
  
$fecha_actual = date("Y-m-d H:i:s");
$fecha_registro = date("Y-m-d");

$sql_insert_e = "INSERT INTO equipos_ceye(cart_id,id_atencion,id_usua,serv_id,nombre,tiempo,fecha_registro)VALUES('$cart_id','$id_atencion','$id_usua','$servicio_id','$serv_desc','$cart_qty','$fecha_registro')";
echo mysqli_query($conexion,$sql_insert_e);
  }




  $sql_delCart = "DELETE FROM cart_serv WHERE paciente = $id_atencion";
 // $result_delCart = $conexion->query($sql_delCart);
echo mysqli_query($conexion,$sql_delCart);
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



//anterior






?>