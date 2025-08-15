<?php
// Versión limpia de salidasPorAjusteq.php
session_start();
include "../../conexionbd.php";
ob_start();

$usuario = isset($_SESSION['login']) ? $_SESSION['login'] : null;
if (!$usuario) {
  header('Location: ../../index.php');
  exit;
}

// Incluir header de farmaciaq
if (isset($usuario['id_rol'])) {
  if (in_array($usuario['id_rol'], [7, 4, 5])) {
    include "../header_farmaciaq.php";
  } else {
    session_unset();
    session_destroy();
    header('Location: ../../index.php');
    exit;
  }
}

date_default_timezone_set('America/Guatemala');

// Procesamiento del form de ajuste
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['medicamento'], $_POST['motivo'], $_POST['cantidad'])) {
  list($existe_id, $item_id, $existe_lote, $existe_caducidad) = explode('|', $_POST['medicamento']);
  $motivo = $_POST['motivo'];
  $cantidad = (int)$_POST['cantidad'];

  $stmt = $conexion->prepare("SELECT existe_qty, ubicacion_id FROM existencias_almacenq WHERE existe_id = ?");
  $stmt->bind_param('i', $existe_id);
  $stmt->execute();
  $res = $stmt->get_result();
  $row = $res->fetch_assoc();

  if ($row && $row['existe_qty'] >= $cantidad) {
    $nuevo_stock = $row['existe_qty'] - $cantidad;
    $ubicacion_id = $row['ubicacion_id'];

    $conexion->autocommit(FALSE);
    try {
      $fecha_salida = date('Y-m-d H:i:s');
      $tipo = 'Salida por Ajuste';

      $stmt_insert = $conexion->prepare(
        "INSERT INTO salidas_almacenq (item_id, item_name, salida_fecha, salida_lote, salida_caducidad, salida_qty, salida_costsu, id_usua, tipo, motivo, salio)
                 SELECT ?, ia.item_name, ?, ?, ?, ?, ia.item_costs, ?, ?, ?, 'FARMACIA' FROM item_almacen ia WHERE ia.item_id = ?"
      );
      $stmt_insert->bind_param('isssiissi', $item_id, $fecha_salida, $existe_lote, $existe_caducidad, $cantidad, $usuario['id_usua'], $tipo, $motivo, $item_id);
      if (!$stmt_insert->execute()) throw new Exception($stmt_insert->error);

      $stmt_kardex = $conexion->prepare(
        "INSERT INTO kardex_almacenq (kardex_fecha, item_id, kardex_lote, kardex_caducidad, kardex_inicial, kardex_entradas, kardex_salidas, kardex_qty, kardex_movimiento, kardex_ubicacion, id_usua, motivo)
                 VALUES (?, ?, ?, ?, 0, 0, ?, 0, 'Salida por Ajuste', ?, ?, ?)"
      );
      $stmt_kardex->bind_param('sissiiis', $fecha_salida, $item_id, $existe_lote, $existe_caducidad, $cantidad, $ubicacion_id, $usuario['id_usua'], $motivo);
      if (!$stmt_kardex->execute()) throw new Exception($stmt_kardex->error);

      $stmt_update = $conexion->prepare("UPDATE existencias_almacenq SET existe_qty = ?, existe_salidas = existe_salidas + ? WHERE existe_id = ?");
      $stmt_update->bind_param('iii', $nuevo_stock, $cantidad, $existe_id);
      if (!$stmt_update->execute()) throw new Exception($stmt_update->error);

      $conexion->commit();
      $conexion->autocommit(TRUE);
      header('Location: salidasPorAjusteq.php?success=1');
      exit;
    } catch (Exception $e) {
      $conexion->rollback();
      $conexion->autocommit(TRUE);
      error_log('Error ajuste: ' . $e->getMessage());
      header('Location: salidasPorAjusteq.php?error=1');
      exit;
    }
  } else {
    header('Location: salidasPorAjusteq.php?error=1');
    exit;
  }
}

// Listado de salidas por ajuste
$registros_por_pagina = 20;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;
$query_total = "SELECT COUNT(*) AS total FROM salidas_almacenq WHERE tipo = 'Salida por Ajuste'";
$res_total = $conexion->query($query_total) or die($conexion->error);
$total_registros = $res_total->fetch_assoc()['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);
$offset = ($pagina - 1) * $registros_por_pagina;

 // Traer registros de salidas por ajuste y añadir item_grams desde item_almacen
 $query = "SELECT s.*, ia.item_grams FROM salidas_almacenq s LEFT JOIN item_almacen ia ON ia.item_id = s.item_id WHERE s.tipo = 'Salida por Ajuste' ORDER BY s.salida_fecha DESC LIMIT $registros_por_pagina OFFSET $offset";
 $resultado = $conexion->query($query) or die($conexion->error);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Salidas por Ajuste</title>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #2b2d7f;
      --primary-dark: #1f2166;
      --primary-light: #3f418a;
    }

    .page-header {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      color: white;
      padding: 20px;
      border-radius: 15px;
      margin-bottom: 20px;
      box-shadow: 0 8px 32px rgba(43, 45, 127, 0.3);
      text-align: center;
    }

    .page-header h1 {
      margin: 0;
      font-size: 2rem;
      font-weight: 700;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .form-container {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .form-control {
      border-radius: 8px;
      border: 2px solid #e9ecef;
      padding: 10px 15px;
    }

    /* Make each form column use column layout; inputs start at top */
    .form-container .row>[class*="col-"] {
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      /* items start at top by default */
    }

    /* Button column: push button to bottom and to the right */
    .form-container .btn-col {
      justify-content: flex-end;
      /* push to bottom of the column */
      align-items: flex-end;
      /* align horizontally to the right */
      display: flex;
      /* ensure flex context */
      flex-direction: column;
    }

    .label-custom {
      font-weight: 600;
      color: var(--primary-dark);
      margin-bottom: 8px;
    }

    .btn-custom {
      border-radius: 8px;
      padding: 8px 14px;
      font-weight: 600;
    }

    .btn-primary {
      background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
      color: white;
      border: none;
    }

    .btn-secondary {
      background: linear-gradient(45deg, #6c757d, #545b62);
      color: white;
      border: none;
    }

    .table thead th {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      color: white;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="page-header">
      <h1><i class="fas fa-tools"></i> SALIDAS POR AJUSTE</h1>
    </div>
    <div class="d-flex justify-content-end" style="margin: 20px 0;">
      <div class="d-flex">
        <!-- Botón Regresar -->
        <a href="kardexq.php"
          style="color: white; background: linear-gradient(135deg, #2b2d7f 0%, #1a1c5a 100%);
            border: none; border-radius: 8px; padding: 10px 16px; cursor: pointer; display: inline-block; 
            text-decoration: none; box-shadow: 0 2px 8px rgba(43, 45, 127, 0.3); 
            transition: all 0.3s ease; margin-right: 10px;">
          ← Regresar
        </a>

      </div>
    </div>
    <div class="form-container">
      <form method="POST" action="">
        <div class="row align-items-end">

          <!-- Medicamento -->
          <div class="col-lg-6">
            <label class="label-custom">Medicamento:</label>
            <select name="medicamento" class="form-control" required id="medSelect" style="white-space: normal;">
              <option value="">Seleccione un medicamento</option>
              <?php
              $res = $conexion->query("SELECT ea.existe_id, ia.item_id, ia.item_name, ia.item_grams, ea.existe_lote, ea.existe_caducidad, ea.existe_qty, ia.item_costs 
                                   FROM existencias_almacenq ea 
                                   JOIN item_almacen ia ON ia.item_id = ea.item_id 
                                   WHERE ea.existe_qty > 0 
                                   ORDER BY ia.item_name, ea.existe_caducidad ASC");
              while ($r = $res->fetch_assoc()):
                $value = $r['existe_id'] . '|' . $r['item_id'] . '|' . $r['existe_lote'] . '|' . $r['existe_caducidad'];
                $grams = isset($r['item_grams']) && $r['item_grams'] !== '' ? ' (' . $r['item_grams'] . ')' : '';
                $label = htmlspecialchars("{$r['item_name']}{$grams} - Lote: {$r['existe_lote']} - Vence: {$r['existe_caducidad']} - Stock: {$r['existe_qty']}");
              ?>
                <option value="<?= $value ?>"><?= $label ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <!-- Motivo -->
          <div class="col-lg-2">
            <label class="label-custom">Motivo:</label>
            <select id="motivoSelect" name="motivo" class="form-control" required style="white-space: normal; width:100%;">
              <option value="">Seleccione motivo</option>
              <option value="Caducidad">Caducidad</option>
              <option value="Consumo Interno">Consumo Interno</option>
              <option value="Ajuste de Inventario">Ajuste de Inventario</option>
            </select>
          </div>

          <!-- Cantidad -->
          <div class="col-lg-2">
            <label class="label-custom">Cantidad:</label>
            <input type="number" name="cantidad" class="form-control" required>
          </div>

          <!-- Botón -->
          <div class="col-lg-2">
            <button type="submit" class="btn btn-primary btn-custom w-100" style="margin-top: 25px;">
              Registrar Ajuste
            </button>
          </div>



        </div>
      </form>
    </div>


    <br>

    <div class="table-responsive form-container">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>FECHA</th>
            <th>ITEMID</th>
            <th>MEDICAMENTO</th>
            <th>LOTE</th>
            <th>CADUCIDAD</th>
            <th>CANTIDAD</th>
            <th>MOTIVO</th>
            <th>IDUSUARIO</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $resultado->fetch_assoc()): ?>
            <tr>
              <td><?= date('d/m/Y H:i', strtotime($row['salida_fecha'])); ?></td>
              <td><?= $row['item_id']; ?></td>
              <?php $gramsRow = isset($row['item_grams']) && $row['item_grams'] !== '' ? ' (' . $row['item_grams'] . ')' : ''; ?>
              <td><?= htmlspecialchars($row['item_id'] . ' - ' . $row['item_name'] . $gramsRow); ?></td>
              <td><?= $row['salida_lote']; ?></td>
              <td><?= date('d/m/Y', strtotime($row['salida_caducidad'])); ?></td>
              <td><?= $row['salida_qty']; ?></td>
              <td><?= $row['motivo']; ?></td>
              <td><?= $row['id_usua']; ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Paginación simple -->
    <div class="pagination" style="margin-top:12px; text-align:center;">
      <?php
      if ($total_paginas > 1) {
        for ($i = 1; $i <= $total_paginas; $i++) {
          echo '<a href="?pagina=' . $i . '" class="btn btn-custom" style="margin:2px;">' . $i . '</a>';
        }
      }
      ?>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#medSelect').select2({
        placeholder: '🔍 Seleccione un medicamento...',
        width: '100%'
      });
      // Inicializar motivo con Select2 para que la selección sea visible
      if ($('#motivoSelect').length) {
        $('#motivoSelect').select2({
          placeholder: 'Seleccione motivo',
          width: '100%',
          minimumResultsForSearch: Infinity // oculta el cuadro de búsqueda
        });
      }
    });
  </script>
</body>

</html>