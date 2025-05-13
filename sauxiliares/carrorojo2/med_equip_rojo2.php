<?php
include '../../conexionbd.php';

$paciente1 = $_POST['paciente'];
$query = "SELECT * from paciente where Id_exp = $paciente1";
                $result = $conexion->query($query);
                while ($row = $result->fetch_assoc()) {
                  $id_exp=$row['Id_exp'];
                  $nombre=$row['nom_pac'];
                  $papell=$row['papell'];
                  $sapell=$row['sapell'];
                }
  echo '<script type="text/javascript">window.location.href = "medicamentos_paciente.php?id_exp='.$id_exp.'";</script>';
?>

