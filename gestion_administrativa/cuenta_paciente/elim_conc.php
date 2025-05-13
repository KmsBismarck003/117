<?php 
include "conexionbdf.php";
  $id_e = @$_GET['id_co'];
  $id_at = @$_GET['id_atencion'];
  $sql2 = "DELETE  FROM gen_concepto WHERE id_conce = $id_e";
          $result = $conexion->query($sql2);

echo '<script type="text/javascript">window.location.href ="facturacion.php?id_atencion='.$id_at.'";</script>';

?>  