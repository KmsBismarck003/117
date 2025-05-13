<?php
include '../../conexionbd.php';
include '../../conn_almacen/Connection.php';

$resultado2 = $conexion_almacen->query("SELECT item_id FROM item_almacen order by item_id DESC Limit 1") or die($conexion->error);
    while ($row = $resultado2->fetch_assoc()) { 
        $codigo = $row['item_id'] + 1;   
        $prod_codigo = "P0".$codigo;
    }

if (isset($_POST['nomitem']) and
    isset($_POST['precio']) and
    //isset($_POST['codigo']) AND
    isset($_POST['fabricante']) and
    isset($_POST['contenido']) and
    isset($_POST['minimo']) and
    isset($_POST['maximo']) and
    isset($_POST['tipo']) and
    isset($_POST['controlado'])
) {

    $prod_nombre = ($_POST['nomitem']);
    $prod_precio = ($_POST['precio']);
    $prod_fabricante = ($_POST['fabricante']);
    $prod_contenido = ($_POST['contenido']);
    $prod_minimo = ($_POST['minimo']);
    $prod_maximo = ($_POST['maximo']);
    $prod_tipo = ($_POST['tipo']);
    $controlado = ($_POST['controlado']);
    
    $codigosat = ($_POST['codigosat']);
    $tip_insumo = ($_POST['clasifica']);
    $grupo = ($_POST['grupo']);
   
    $activo = 'SI';
    
    $ingresar2=mysqli_query($conexion_almacen,'insert into item_almacen (item_name,item_price,item_code,item_brand,item_grams,item_type_id,controlado,item_min,item_max,activo,tip_insumo,grupo) values("'.$prod_nombre.'","'.$prod_precio.'","'.$prod_codigo.'","'.$prod_fabricante.'",
        "'. $prod_contenido.'","'.$prod_tipo.'","'.$controlado.'","'.$prod_minimo.'",
        "'. $prod_maximo.'","'.$activo.'","'.$tip_insumo.'","'.$grupo.'")') or die ('<p>Error al registrar Almacen</p><br>'.mysqli_error($conexion_almacen));
   
    $ingresar=mysqli_query($conexion,'insert into item (item_name,item_price,item_code,item_brand,item_grams,item_type_id,controlado,item_min,item_max,activo,tip_insumo,grupo) values("'.$prod_nombre.'","'.$prod_precio.'","'.$prod_codigo.'","'.$prod_fabricante.'",
        "'. $prod_contenido.'","'.$prod_tipo.'","'.$controlado.'","'.$prod_minimo.'",
        "'. $prod_maximo.'","'.$activo.'","'.$tip_insumo.'","'.$grupo.'")') or die ('<p>Error al registrar Farmacia</p><br>'.mysqli_error($conexion));
    
    $ingresar3=mysqli_query($conexion,'insert into material_ceye (material_nombre,material_precio,material_codigo,material_fabricante,material_contenido,material_tipo,material_controlado,item_min,item_max,activo,tip_insumo,grupo) values("' .  $prod_nombre . '","' .  $prod_precio . '","' .  $prod_codigo. '","' .  $prod_fabricante . '","' .  $prod_contenido . '","' .  $prod_tipo . '","' .  $controlado . '","' .  $prod_minimo . '","' .  $prod_maximo . '","' .  $activo . '","' .  $tip_insumo . '","' .  $grupo . '")') or die ('<p>Error al registrar Quirofano</p><br>'.mysqli_error($conexion));



     header ('location: lista_productos.php');

    //  }//si no se enviaron datos


} else {

     header ('location: lista_productos.php');
}




if (@$_GET['q'] == 'estatus') {
    $id = $_GET['eid'];
    $est = $_GET['est'];
    $existencias = 0;
    
    $sql2 = $conexion_almacen->query("SELECT * FROM stock_almacen where stock_almacen.item_id=$id Order by item_id Limit 1") or die('<p>Error al encontrar stock</p><br>' . mysqli_error($conexion_almacen));
    while ($row_stock = $sql2->fetch_assoc()) {
      $existencias = $row_stock['stock_qty'];
    }
   
    if ($est == 'SI') {
        $sql = "UPDATE `item_almacen` SET `activo`='NO' WHERE `item_id` = '$id' && $existencias = 0 ";
    } else {
        $sql = "UPDATE `item_almacen` SET `activo`='SI' WHERE `item_id` = '$id' && $existencias = 0";
    }
    $result = $conexion_almacen->query($sql);
    
        if (!$result) { 
        echo '<script type="text/javascript">
					alert("Estatus guardado exitosamente");
					window.location.href="lista_productos.php";
					</script>';
        }
        else {
            echo '<script type="text/javascript">
					alert("Error, el producto cuenta con existencias");
					window.location.href="lista_productos.php";
					</script>';
        }
    }

