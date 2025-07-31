<?php
include '../../conexionbd.php';

if (isset($_POST['clave']) &&
    isset($_POST['descripcion']) &&
    isset($_POST['costo']) &&
    isset($_POST['med']) &&
    isset($_POST['tipo']) &&
    isset($_POST['proveedor']) &&
    isset($_POST['grupo']) &&
    isset($_POST['codigo_sat']) &&
    isset($_POST['c_cveuni'])
) {
    $serv_cve = $_POST['clave'];
    $serv_desc = $_POST['descripcion'];
    $serv_costo = $_POST['costo'];
    $serv_costo2 = isset($_POST['costo2']) && $_POST['costo2'] !== '' ? $_POST['costo2'] : 0;
    $serv_costo3 = isset($_POST['costo3']) && $_POST['costo3'] !== '' ? $_POST['costo3'] : 0;
    $serv_costo4 = isset($_POST['costo4']) && $_POST['costo4'] !== '' ? $_POST['costo4'] : 0;
    $serv_costo5 = isset($_POST['costo5']) && $_POST['costo5'] !== '' ? $_POST['costo5'] : 0;
    $serv_costo6 = isset($_POST['costo6']) && $_POST['costo6'] !== '' ? $_POST['costo6'] : 0;
    $serv_costo7 = isset($_POST['costo7']) && $_POST['costo7'] !== '' ? $_POST['costo7'] : 0;
    $serv_costo8 = isset($_POST['costo8']) && $_POST['costo8'] !== '' ? $_POST['costo8'] : 0;
    $serv_umed = $_POST['med'];
    $serv_tipo = $_POST['tipo'];
    $proveedor = $_POST['proveedor'];
    $grupo = $_POST['grupo'];
    $codigo_sat = $_POST['codigo_sat'];
    $c_cveuni = $_POST['c_cveuni'];
    $c_nombre = "SERVICIO";
    $tasa = 0.16;

    // Fetch ser_type_desc for tip_insumo
    $query_tipo = "SELECT ser_type_desc FROM service_type WHERE ser_type_id = '$serv_tipo'";
    $result_tipo = $conexion->query($query_tipo);
    $tip_insumo = ($result_tipo && $row_tipo = $result_tipo->fetch_assoc()) ? $row_tipo['ser_type_desc'] : '';

    $ingresar = mysqli_query($conexion, "INSERT INTO cat_servicios (serv_cve, serv_desc, serv_costo, serv_costo2, serv_costo3, serv_costo4, serv_costo5, serv_costo6, serv_costo7, serv_costo8, serv_umed, serv_activo, tipo, tip_insumo, proveedor, grupo, codigo_sat, c_cveuni, c_nombre, tasa) 
        VALUES ('$serv_cve', '$serv_desc', '$serv_costo', '$serv_costo2', '$serv_costo3', '$serv_costo4', '$serv_costo5', '$serv_costo6', '$serv_costo7', '$serv_costo8', '$serv_umed', 'SI', '$serv_tipo', '$tip_insumo', '$proveedor', '$grupo', '$codigo_sat', '$c_cveuni', '$c_nombre', '$tasa')") 
        or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

    header('location: cat_servicios.php');
} else {
    header('location: cat_servicios.php');
}

if (@$_GET['q'] == 'estatus') {
    $id = $_GET['eid'];
    $est = $_GET['est'];
    if ($est == 'NO') {
        $sql = "UPDATE `cat_servicios` SET `serv_activo`='SI' WHERE `id_serv` = '$id'";
    } else {
        $sql = "UPDATE `cat_servicios` SET `serv_activo`='NO' WHERE `id_serv` = '$id'";
    }
    $result = $conexion->query($sql);
    if ($result) {
        echo '<script type="text/javascript">
            alert("Estatus guardado exitosamente");
            window.location.href="cat_servicios.php";
            </script>';
    } else {
        echo '<script type="text/javascript">
            alert("Error, volver a intentar por favor");
            window.location.href="cat_servicios.php";
            </script>';
    }
}
?>