<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../../conexionbd.php";
if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}
include "cat_maestro.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $item_comercial = $_POST['item_comercial'];
    $item_grams = $_POST['item_grams'];
    $id_prov = $_POST['id_prov'];
    $factor = $_POST['factor'];
    $item_type_id = $_POST['item_type_id'];
    $item_max = $_POST['item_max'];
    $reorden = $_POST['reorden'];
    $item_min = $_POST['item_min'];
    $item_costs = $_POST['item_costs'];
    $item_price = $_POST['item_price'];
    $subfamilia = $_POST['subfamilia'];
    $grupo = $_POST['grupo'];
    $tipo = $_POST['tipo'];
    $activo = "SI";

    $cost_unit = $item_costs / $factor;
    $contenido = "";
    $temperatura = "";
    $alerta = "";
    
    $query = "INSERT INTO item_almacen 
    (item_code,item_name,item_comercial,item_grams,id_prov,factor,item_type_id,item_max,reorden,item_min,item_costs,item_price, subfamilia,grupo,tipo,activo,cost_unit,contenido,temperatura,alerta)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("ssssiiiiisssssssdsss", $item_code,$item_name,$item_comercial,$item_grams,$id_prov,$factor,$item_type_id,$item_max,$reorden,$item_min,$item_costs,$item_price,$subfamilia,$grupo,$tipo,$activo,$cost_unit,$contenido,$temperatura,$alerta);
        if ($stmt->execute()) {
            echo '<meta http-equiv="refresh" content="0;url=cat_maestro.php">';
        } else {
            echo 'Error en la ejecución de la consulta: ' . $conexion->error;
        }

    } else {
        echo 'Error en la preparación de la consulta: ' . $conexion->error;
    }
}
