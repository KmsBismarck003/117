<?php
session_start();
include "../../conexionbd.php";

if (!isset($_SESSION['hospital'])) {
    header("Location: ../login.php");
    exit();
}

// Add your database insertion logic here
header("Location: examenes_gab.php?success=1");
exit();
?>