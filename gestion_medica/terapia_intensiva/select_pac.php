<?php
session_start();
$id_atencion = $_GET['id_atencion'];
$_SESSION['ambiente'] = $id_atencion;

//echo '<script>window.location.href = "../../template/menu_enfermera.php?'.$_SESSION['ambiente'].'"</script>';
echo '<script>window.location.href = "../../template/menu_medico.php"</script>';
