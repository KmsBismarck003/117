<?php
include "../../conexionbd.php";
session_start();
ob_start();

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
date_default_timezone_set('America/Guatemala');

if (isset($usuario['id_rol'])) {
    if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
        include "../header_farmaciaq.php";
    } else {
        session_unset();
        session_destroy();
        echo "<script>window.location='../../index.php';</script>";
        exit();
    }
}

// Procesar inserción desde formulario
if (isset($_POST['item_id']) && isset($_POST['qty'])) {
    $item_id = $_POST['item_id'];
    $qty = $_POST['qty'];

    // Inserta los datos en la tabla `cart_recib`
    $ingresar2 = mysqli_query($conexion, "INSERT INTO cart_recib(item_id, solicita, almacen,id_usua) VALUES ($item_id, $qty, 'QUIROFANO',$id_usua)")
        or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

    // Redirige al usuario después de insertar los datos
    echo '<script type="text/javascript">window.location.href = "pedir_almacenq.php";</script>';
    exit(); // Termina el script después de la redirección
}

// Otras acciones: confirmar, eliminar, consultar...
if (isset($_GET['q']) && $_GET['q'] == 'conf' && isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];
    $updateQuery = "UPDATE cart_recib SET confirma = 'SI' WHERE id_recib = ?";
    $stmt = $conexion->prepare($updateQuery);
    $stmt->bind_param('i', $cart_id);

    if ($stmt->execute()) {
        header("Location: pedir_almacenq.php?success_confirm=true");
        exit();
    } else {
        echo "<script>alert('Error al confirmar');</script>";
    }
    $stmt->close();
}

if (isset($_GET['q']) && $_GET['q'] == 'eliminar' && isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];
    $deleteQuery = "DELETE FROM cart_recib WHERE id_recib = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param('i', $cart_id);
    if ($stmt->execute()) {
        header("Location: pedir_almacenq.php?success_delete=true");
        exit();
    } else {
        echo "<script>alert('Error al eliminar el registro');</script>";
    }
    $stmt->close();
}

$resultado = $conexion->query("SELECT * FROM cart_recib c, item_almacen i WHERE i.item_id = c.item_id AND c.almacen = 'QUIROFANO'") or die($conexion->error);

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    echo "<script>alert('Datos insertados correctamente');</script>";
}

if (isset($_GET['success_confirm']) && $_GET['success_confirm'] == 'true') {
    echo "<script>
       alert('Surtido confirmado');
       window.location.href = 'pedir_almacenq.php';
     </script>";
    exit();
}

if (isset($_GET['success_delete']) && $_GET['success_delete'] == 'true') {
    echo "<script>
        alert('Registro eliminado exitosamente');
        window.location.href = 'pedir_almacenq.php';
    </script>";
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedir a Almacén</title>
</head>

<body>
    <br>
    <a href="../../template/menu_farmaciaq.php"
        style='color: white;  margin-left: 30px;background-color: #d9534f; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer;'>Regresar</a>


    <section class="content container-fluid">
        <hr>

        <div class="container">

            <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                <tr><strong>
                        <center>PEDIR A ALMACÉN</center>
                    </strong>
            </div><br>
            <form action="" method="POST" id="medicamentos">
                <div class="row align-items-center d-flex justify-content-between">
                    <div class="col-sm-4">
                        <label class="mb-0">MÉDICAMENTOS:</label>
                        <select name="item_id" class="form-control" data-live-search="true" id="mibuscador" style="height: 38px;">
                            <?php
                            // Consulta con DISTINCT para evitar duplicados y JOIN para obtener el item_name
                            $sql = "
                    SELECT DISTINCT ea.item_id, ia.item_name
                    FROM existencias_almacenq ea
                    INNER JOIN item_almacen ia ON ea.item_id = ia.item_id
                    WHERE ea.item_id IS NOT NULL";
                            $result = $conexion->query($sql);
                            while ($row_datos = $result->fetch_assoc()) {
                                echo "<option value='" . $row_datos['item_id'] . "'>" . $row_datos['item_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label class="mb-0">CANTIDAD:</label>
                        <input type="number" name="qty" class="form-control" style="height: 38px;">
                    </div>
                    <div class="col-sm-4 d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-success">AGREGAR</button>
                    </div>
                </div>
            </form>

        </div>

        <hr>
        <div class="container">
            <div class="table-responsive">
                <h3>Medicamentos (Confirmados y No Confirmados)</h3>
                <table class="table table-bordered table-striped" id="mytable">
                    <thead class="thead" style="background-color: #0c675e">
                        <tr>
                            <th>
                                <font color="white">No.
                            </th>
                            <th>
                                <font color="white">NOMBRE DEL MATERIAL
                            </th>
                            <th>
                                <font color="white">CANTIDAD
                            </th>
                            <th>
                                <font color="white">ESTADO
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row_lista = $resultado->fetch_assoc()) {
                            $estado = ($row_lista['confirma'] == 'SI') ? 'Confirmado' : 'No Confirmado';
                            $action_buttons = ($row_lista['confirma'] == 'NO')
                                ? '<a class="btn btn-success btn-sm" href="?q=conf&cart_id=' . $row_lista['id_recib'] . '"><span class="fa fa-check"></span></a>'
                                : '';
                            $action_buttons .= '&nbsp;';
                            $action_buttons .= '<a class="btn btn-danger btn-sm" href="?q=eliminar&cart_id=' . $row_lista['id_recib'] . '"><span class="fa fa-trash"></span></a>';

                            echo '<tr>'
                                . '<td>' . $no . '</td>'
                                . '<td>' . $row_lista['item_name'] . '</td>'
                                . '<td>' . $row_lista['solicita'] . '</td>'
                                . '<td>' . $estado . '</td>'
                                . '<td>' . $action_buttons . '</td>'
                                . '</tr>';
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>

</html>