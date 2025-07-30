<?php
session_start();
ob_start();
include "../../conexionbd.php";
date_default_timezone_set('America/Guatemala');

$usuario = $_SESSION['login'];

if ($usuario['id_rol'] == 7) {
  include "../header_farmaciah.php";
} elseif ($usuario['id_rol'] == 3) {
  include "../../enfermera/header_enfermera.php";
} elseif ($usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
  include "../header_farmaciah.php";
} else {
  echo "<script>window.location='../../index.php';</script>";
  exit;
}

if (isset($_SESSION['login']['id_usua'])) {
  $id_usua = $_SESSION['login']['id_usua'];
} else {
  echo "Error: No se pudo obtener el ID del usuario logueado.";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['medicamento'], $_POST['motivo'], $_POST['cantidad'])) {
  list($existe_id, $item_id, $existe_lote, $existe_caducidad) = explode('|', $_POST['medicamento']);
  $motivo = $_POST['motivo'];
  $cantidad = $_POST['cantidad'];

  $stmt = $conexion->prepare("SELECT ea.existe_qty, ea.ubicacion_id, ia.item_name, ia.item_costs 
                              FROM existencias_almacenh ea
                              JOIN item_almacen ia ON ia.item_id = ea.item_id
                              WHERE existe_id = ?");
  $stmt->bind_param('i', $existe_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if ($row && $row['existe_qty'] >= $cantidad) {
    $nuevo_stock = $row['existe_qty'] - $cantidad;
    $ubicacion_id = $row['ubicacion_id'];
    $item_name = $row['item_name'];
    $item_costsu = $row['item_costs'];

    // Iniciar transacción
    $conexion->autocommit(FALSE);

    try {
      // Preparar todas las consultas antes de ejecutar
      $stmt_update = $conexion->prepare("UPDATE existencias_almacenh SET existe_qty = ?, existe_salidas = existe_salidas + ? WHERE existe_id = ?");
      if (!$stmt_update) {
        throw new Exception("Error al preparar la consulta de actualización de existencias: " . $conexion->error);
      }

      $fecha_salida = date('Y-m-d H:i:s');
      $id_atencion = NULL;
      $solicita = NULL;
      $fecha_solicitud = NULL;
      $tipo = 'Salida por Ajuste';

      $stmt_insert = $conexion->prepare("INSERT INTO salidas_almacenh 
                                         (item_id, item_name, salida_fecha, salida_lote, salida_caducidad, salida_qty, salida_costsu, id_usua, id_atencion, solicita, fecha_solicitud, tipo, motivo,salio) 
                                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,'FARMACIA')");
      if (!$stmt_insert) {
        throw new Exception("Error al preparar la consulta de inserción en salidas_almacenh: " . $conexion->error);
      }

      $stmt_kardex = $conexion->prepare("INSERT INTO kardex_almacenh 
                                         (kardex_fecha, item_id, kardex_lote, kardex_caducidad, kardex_inicial, kardex_entradas, kardex_salidas, kardex_qty, kardex_dev_stock, kardex_dev_merma, kardex_movimiento, kardex_ubicacion, kardex_destino, id_usua, id_surte, motivo) 
                                         VALUES (?, ?, ?, ?, 0, 0, ?, 0, 0, 0, 'Salida por Ajuste', ?, NULL, ?, NULL, ?)");
      if (!$stmt_kardex) {
        throw new Exception("Error al preparar la consulta de inserción en kardex_almacenh: " . $conexion->error);
      }

      // Ejecutar las consultas en orden
      // 1. Insertar en salidas_almacenh
      $stmt_insert->bind_param('issssisisssss', $item_id, $item_name, $fecha_salida, $existe_lote, $existe_caducidad, $cantidad, $item_costsu, $id_usua, $id_atencion, $solicita, $fecha_solicitud, $tipo, $motivo);
      if (!$stmt_insert->execute()) {
        throw new Exception("Error al insertar en salidas_almacenh: " . $stmt_insert->error);
      }

      // 2. Insertar en kardex_almacenh
      $stmt_kardex->bind_param('sissisis', $fecha_salida, $item_id, $existe_lote, $existe_caducidad, $cantidad, $ubicacion_id, $id_usua, $motivo);
      if (!$stmt_kardex->execute()) {
        throw new Exception("Error al insertar en kardex_almacenh: " . $stmt_kardex->error);
      }

      // 3. Actualizar existencias (solo si las inserciones fueron exitosas)
      $stmt_update->bind_param('iii', $nuevo_stock, $cantidad, $existe_id);
      if (!$stmt_update->execute()) {
        throw new Exception("Error al actualizar existencias: " . $stmt_update->error);
      }

      // Si llegamos aquí, todas las operaciones fueron exitosas
      $conexion->commit();
      $conexion->autocommit(TRUE);

      ob_clean();
      header("Location: salidasPorAjusteh.php?success=1");
      exit;
    } catch (Exception $e) {
      // Si hay algún error, hacer rollback
      $conexion->rollback();
      $conexion->autocommit(TRUE);

      // Log del error (opcional)
      error_log("Error en salidasPorAjusteh.php: " . $e->getMessage());

      ob_clean();
      header("Location: salidasPorAjusteh.php?error=1");
      exit;
    }
  } else {
    ob_clean();
    header("Location: salidasPorAjusteh.php?error=1");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salidas por Ajuste</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <style>
    .total-row {
      background-color: #0c675e;
      color: white;
    }

    .ultima-existencia {
      background-color: #0c675e;
      color: white;
    }

    .table-responsive {
      max-height: 80vh;
      overflow-x: auto;
      overflow-y: auto;
      width: 100%;
    }

    .container.box {
      max-width: 98%;
      width: 98%;
      margin: 0 auto;
    }

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .table {
      font-size: 12px;
      min-width: 100%;
    }

    .table th,
    .table td {
      padding: 4px 6px;
      white-space: nowrap;
      text-align: center;
      vertical-align: middle;
    }

    .table th {
      font-size: 11px;
      font-weight: bold;
    }

    .pagination a {
      padding: 8px 12px;
      text-decoration: none;
      background-color: #0c675e;
      color: white;
      border-radius: 5px;
      margin: 0 5px;
    }

    .pagination a:hover {
      background-color: #084c47;
    }

    .pagination .current {
      background-color: #ff7f50;
      color: white;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <section class="content container-fluid">
    <div class="container mt-5 p-4" style="background: #f8f9fa; border-radius: 10px;">
      <div class="mb-3 text-left">
        <a class="btn btn-danger" href="salidas_almacenh_historial.php">Regresar</a>
      </div>
      <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 10px; position: relative;">
        <div class="thead" style="background-color: #0c675e; padding: 5px; color: white; text-align: center; border-radius: 5px;">
          <h1 style="font-size: 26px; margin: 2;">Salidas por Ajuste</h1>
        </div>
      </div>
      <form method="POST" action="" class="p-4 rounded" style="background: #f4f4f4; border: 1px solid #ccc;">
        <h5>Salida por Ajuste</h5>
        <div class="form-group">
          <label>Medicamento:</label>
          <select name="medicamento" class="form-control" required>
            <option value="">Seleccione un medicamento</option>
            <?php
            $res = $conexion->query("SELECT ea.existe_id, ia.item_id, ia.item_name, ia.item_grams, ea.existe_lote, ea.existe_caducidad, ea.existe_qty, ia.item_costs
                                    FROM existencias_almacenh ea
                                    JOIN item_almacen ia ON ia.item_id = ea.item_id
                                    WHERE ea.existe_qty > 0
                                    ORDER BY ia.item_name, ea.existe_caducidad ASC");
            while ($row = $res->fetch_assoc()):
              $value = $row['existe_id'] . "|" . $row['item_id'] . "|" . $row['existe_lote'] . "|" . $row['existe_caducidad'];
              $label = "{$row['item_name']} ({$row['item_grams']}) - Lote: {$row['existe_lote']} - Vence: {$row['existe_caducidad']} - Stock: {$row['existe_qty']} - Costo:" . number_format($row['item_costs'], 2);
            ?>
              <option value="<?= htmlspecialchars($value) ?>" data-qty="<?= $row['existe_qty'] ?>"><?= htmlspecialchars($label) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Motivo:</label>
          <select name="motivo" class="form-control" required>
            <option value="">Seleccione un motivo</option>
            <option value="Caducidad">Caducidad</option>
            <option value="Consumo Interno">Consumo Interno</option>
            <option value="Ajuste de Inventario">Ajuste de Inventario</option>
          </select>
        </div>

        <div class="form-group">
          <label>Cantidad:</label>
          <input type="number" name="cantidad" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Registrar Ajuste</button>
      </form>

      <div class="container mt-4 p-3" style="background: #fff; border: 1px solid #ccc; border-radius: 8px;">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h5 class="text-dark">AJUSTE DE MEDICAMENTOS</h5>
          <input type="text" id="buscar-ajustes" class="form-control" style="width: 200px;" placeholder="BUSCAR LOTE...">
        </div>

        <?php
        // Paginación para ajustes
        $registros_por_pagina_ajustes = 20;
        $pagina_ajustes = isset($_GET['pagina_ajustes']) ? (int)$_GET['pagina_ajustes'] : 1;
        if ($pagina_ajustes < 1) {
          $pagina_ajustes = 1;
        }

        // Calcular el número total de registros de ajustes
        $query_total_ajustes = "SELECT COUNT(*) AS total FROM salidas_almacenh WHERE tipo = 'Salida por Ajuste'";
        $resultado_total_ajustes = $conexion->query($query_total_ajustes) or die($conexion->error);
        $total_registros_ajustes = $resultado_total_ajustes->fetch_assoc()['total'];

        // Calcular el total de páginas
        $total_paginas_ajustes = ceil($total_registros_ajustes / $registros_por_pagina_ajustes);

        // Asegurar que la página esté dentro del rango
        if ($pagina_ajustes > $total_paginas_ajustes && $total_paginas_ajustes > 0) {
          $pagina_ajustes = $total_paginas_ajustes;
        }

        // Calcular el desplazamiento (OFFSET)
        $offset_ajustes = ($pagina_ajustes - 1) * $registros_por_pagina_ajustes;
        if ($offset_ajustes < 0) {
          $offset_ajustes = 0;
        }

        // Consulta con LIMIT y OFFSET para obtener los registros paginados
        $query_ajustes = "SELECT * FROM salidas_almacenh WHERE tipo = 'Salida por Ajuste' ORDER BY salida_fecha DESC LIMIT $registros_por_pagina_ajustes OFFSET $offset_ajustes";
        $ajustes = $conexion->query($query_ajustes);
        ?>

        <div class="table-responsive">
          <table class="table table-bordered table-hover text-center" id="tabla-ajustes">
            <thead class="thead-dark">
              <tr>
                <th>FECHA</th>
                <th>MEDICAMENTO</th>
                <th>LOTE</th>
                <th>CADUCIDAD</th>
                <th>CANTIDAD</th>
                <th>MOTIVO</th>
                <th>TIPO</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($ajustes && $ajustes->num_rows > 0):
                while ($r = $ajustes->fetch_assoc()):
              ?>
                  <tr>
                    <td><?= date('d/m/Y H:i', strtotime($r['salida_fecha'])) ?></td>
                    <td><?= htmlspecialchars($r['item_name']) ?></td>
                    <td><?= htmlspecialchars($r['salida_lote']) ?></td>
                    <td><?= date('d/m/Y', strtotime($r['salida_caducidad'])) ?></td>
                    <td><?= intval($r['salida_qty']) ?></td>
                    <td><?= htmlspecialchars($r['motivo']) ?></td>
                    <td><?= htmlspecialchars($r['tipo']) ?></td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center">No hay registros de ajustes.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <div class="pagination">
          <?php
          // Mostrar enlaces para la primera página
          if ($pagina_ajustes > 1) {
            echo "<a href='?pagina_ajustes=1'>&laquo; Primera</a>";
          }

          // Mostrar páginas cercanas a la actual
          $pagina_inicio = max(1, $pagina_ajustes - 5);
          $pagina_fin = min($total_paginas_ajustes, $pagina_ajustes + 5);

          for ($i = $pagina_inicio; $i < $pagina_ajustes; $i++) {
            echo "<a href='?pagina_ajustes=$i'>$i</a>";
          }

          // Página actual
          echo "<a href='?pagina_ajustes=$pagina_ajustes' class='current'>$pagina_ajustes</a>";

          for ($i = $pagina_ajustes + 1; $i <= $pagina_fin; $i++) {
            echo "<a href='?pagina_ajustes=$i'>$i</a>";
          }

          // Mostrar enlace para la última página
          if ($pagina_ajustes < $total_paginas_ajustes) {
            echo "<a href='?pagina_ajustes=$total_paginas_ajustes'>Última &raquo;</a>";
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <script>
    $(document).ready(function() {
      $("#buscar-ajustes").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tabla-ajustes tr").filter(function() {
          $(this).toggle($(this).find('td:nth-child(4)').text().toLowerCase().indexOf(value) > -1);
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $("form").submit(function(event) {
        // Obtener la cantidad ingresada
        var cantidad = parseFloat($("input[name='cantidad']").val());

        // Obtener el medicamento seleccionado
        var medicamento = $("select[name='medicamento']").val();
        var dataQty = $("select[name='medicamento'] option[value='" + medicamento + "']").data('qty');

        // Validar que la cantidad no exceda la cantidad disponible
        if (cantidad > dataQty) {
          alert("La cantidad no puede ser mayor que la cantidad disponible en inventario.");
          event.preventDefault(); // Prevenir el envío del formulario
        }
      });
    });
  </script>

</body>

</html>