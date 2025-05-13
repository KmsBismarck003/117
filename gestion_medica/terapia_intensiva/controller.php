<?php
$flag = $_SESSION['ambiente'];
if ($flag != null) {
  // echo '<script type="text/javascript"> window.location.href="nota_de_evolucion.php?id_atencion=' . $_SESSION['ambiente'] . '&id_usua=' . $_SESSION['id_usua'] . '";</script>';
  echo 1;
} else {
  echo '<script type="text/javascript"> window.location.href="lista_prueba.php";</script>';
}
