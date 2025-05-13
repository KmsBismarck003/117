<?php
session_start();
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];


if (@$_GET['q'] == 'del_car') {
  $paciente = $_GET['paciente'];
  $id = $_GET['cart_id'];

  $sql1 = "DELETE FROM cart_mat WHERE id = $id";
  $result1 = $conexion->query($sql1);

  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
  echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
  echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
  echo '<script>
                  $(document).ready(function() {
                      swal({
                          title: "Material eliminado correctamente", 
                          type: "success",
                          confirmButtonText: "ACEPTAR"
                      }, function(isConfirm) { 
                          if (isConfirm) {
                              window.location.href = "orderqx.php?paciente=' . $paciente . '";
                          }
                      });
                  });
              </script>';
}
?>