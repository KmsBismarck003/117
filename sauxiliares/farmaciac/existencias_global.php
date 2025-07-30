<?php
session_start();
ob_start(); // Iniciar el buffering de salida
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];

if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
  include "../header_farmaciac.php";
} else {
  echo "<script>window.Location='../../index.php';</script>";
}

// Manejar peticiones AJAX de búsqueda
if (isset($_GET['ajax']) && isset($_GET['search'])) {
  $searchTerm = mysqli_real_escape_string($conexion, $_GET['search']);
  $tab = isset($_GET['tab']) ? $_GET['tab'] : 'normales';
  
  // Limpiar cualquier salida previa
  ob_clean();
  
  if ($tab === 'cero') {
    $query_search = "
      SELECT ia.item_id, ia.item_code, ia.item_name, ia.item_grams, ia.item_max, ia.item_min, ia.reorden, 
             SUM(ea.existe_qty) as cuantos
      FROM existencias_almacen ea
      INNER JOIN item_almacen ia ON ea.item_id = ia.item_id
      WHERE (ia.item_code LIKE '%$searchTerm%' 
             OR ia.item_name LIKE '%$searchTerm%')
      GROUP BY ea.item_id
      HAVING cuantos = 0
      ORDER BY ia.item_code ASC
    ";
  } else {
    $query_search = "
      SELECT ia.item_id, ia.item_code, ia.item_name, ia.item_grams, ia.item_max, ia.item_min, ia.reorden, 
             SUM(ea.existe_qty) as cuantos
      FROM existencias_almacen ea
      INNER JOIN item_almacen ia ON ea.item_id = ia.item_id
      WHERE (ia.item_code LIKE '%$searchTerm%' 
             OR ia.item_name LIKE '%$searchTerm%')
      GROUP BY ea.item_id
      HAVING cuantos > 0
      ORDER BY ia.item_code ASC
    ";
  }

  $resultado_search = $conexion->query($query_search) or die($conexion->error);

  // Solo generar las filas de la tabla
  while ($row_search = $resultado_search->fetch_assoc()) {
    $existencias = $row_search['cuantos'];
    $maximo = $row_search['item_max'];
    $minimo = $row_search['item_min'];
    $reordena = $row_search['reorden'];

    echo '<tr>'
      . '<td>' . $row_search['item_code'] . '</td>'
      . '<td>' . $row_search['item_name'] . ', ' . $row_search['item_grams'] . '</td>'
      . '<td>' . $maximo . '</td>'
      . '<td>' . $reordena . '</td>'
      . '<td>' . $minimo . '</td>';

    if ($tab === 'normales') {
      if ($existencias >= $maximo) {
        echo '<td bgcolor="#28a745">' . $existencias . '</td>';
      } elseif ($existencias < $maximo && $existencias > $minimo) {
        echo '<td bgcolor="#ffc107">' . $existencias . '</td>';
      } elseif ($existencias <= $minimo) {
        echo '<td bgcolor="red" style="color: white;">' . $existencias . '</td>';
      }
    } else {
      echo '<td>' . $existencias . '</td>';
    }

    echo '</tr>';
  }

  exit; // Importante: terminar la ejecución aquí para no enviar HTML adicional
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <meta charset="UTF-8">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
  <script>
    $(document).ready(function() {
      // Verificar si hay parámetro page_cero en la URL o hash #cero para activar el tab correcto
      const urlParams = new URLSearchParams(window.location.search);
      const hash = window.location.hash;
      
      if (urlParams.has('page_cero') || hash === '#cero') {
        // Activar el tab de existencias en 0
        $('#cero-tab').tab('show');
      }

      // Filtrar datos por búsqueda en toda la base de datos
      $("#search").keyup(function() {
        var searchTerm = $(this).val();
        
        if (searchTerm.length > 2) {
          // Determinar qué tab está activo
          var activeTab = $('.nav-link.active').attr('id');
          var isZeroTab = (activeTab === 'cero-tab');
          
          // Realizar búsqueda AJAX en toda la base de datos
          $.ajax({
            url: window.location.pathname,
            type: 'GET',
            data: {
              'search': searchTerm,
              'ajax': 1,
              'tab': isZeroTab ? 'cero' : 'normales'
            },
            dataType: 'html',
            success: function(response) {
              // Limpiar la respuesta para asegurar que solo contenga las filas de la tabla
              var cleanResponse = response.trim();
              
              // Verificar que la respuesta no contenga etiquetas HTML no deseadas
              if (cleanResponse.indexOf('<html>') !== -1 || cleanResponse.indexOf('<!DOCTYPE') !== -1) {
                console.log('Error: La respuesta contiene HTML completo');
                return;
              }
              
              if (isZeroTab) {
                $('#mytable-cero tbody').empty().html(cleanResponse);
                // Ocultar paginación durante búsqueda
                $('#cero .pagination').hide();
              } else {
                $('#mytable tbody').empty().html(cleanResponse);
                // Ocultar paginación durante búsqueda
                $('#normales .pagination').hide();
              }
            },
            error: function(xhr, status, error) {
              console.log('Error en la búsqueda: ' + error);
            }
          });
        } else if (searchTerm.length === 0) {
          // Si no hay término de búsqueda, recargar la página para mostrar todos los resultados
          window.location.reload();
        } else {
          // Para términos de menos de 3 caracteres, usar búsqueda local
          let visibleRows = $("#mytable tbody tr:visible, #mytable-cero tbody tr:visible");
          visibleRows.each(function() {
            let rowText = $(this).text().toLowerCase();
            if (rowText.indexOf(searchTerm.toLowerCase()) === -1)
              $(this).hide();
            else
              $(this).show();
          });
        }
      });

      // Mostrar paginación cuando se cambie de tab
      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('.pagination').show();
      });
    });
  </script>
</head>

<body>
  <div class="container-fluid">
  <div class="container">
    <div class="row">
      <!-- Cambié d-flex justify-content-center a d-flex justify-content-start -->
      <div class="col-0 d-flex justify-content-start">
        <a type="submit" class="btn btn-danger mx-0" href="existencias.php">Regresar</a>
      </div>
    </div>
  </div>

    <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px; text-align: center; padding: 10px; margin: 15px 0;">
      <strong>EXISTENCIAS GLOBALES DE FARMACIA CENTRAL</strong>
    </div>

    <div class="form-group">
      <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
    </div>

    <!-- Tabs para separar existencias normales y existencias globales en 0 -->
    <ul class="nav nav-tabs" id="existenciaTabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="normales-tab" data-toggle="tab" href="#normales" role="tab" aria-controls="normales" aria-selected="true">
          Existencias Globales Normales
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="cero-tab" data-toggle="tab" href="#cero" role="tab" aria-controls="cero" aria-selected="false">
          Existencias Globales en 0
        </a>
      </li>
    </ul>

    <div class="tab-content" id="existenciaTabContent">
      <!-- Tab para existencias globales normales -->
      <div class="tab-pane fade show active" id="normales" role="tabpanel" aria-labelledby="normales-tab">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #0c675e; color: white;">
              <tr>
                <th>
                  <font color="white">Código
                </th>
                <th>
                  <font color="white">Medicamento / Insumo
                </th>
                <th>
                  <font color="white">Máximo
                </th>
                <th>
                  <font color="white">P.reorden
                </th>
                <th>
                  <font color="white">Mínimo
                </th>
                <th>
                  <font color="white">Existencias
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Configuración de la paginación para existencias globales normales
              $records_per_page = 50;
              $query_normales_count = "
                SELECT COUNT(DISTINCT ea.item_id) as total
                FROM existencias_almacen ea
                INNER JOIN item_almacen ia ON ea.item_id = ia.item_id
                WHERE (SELECT SUM(ea2.existe_qty) FROM existencias_almacen ea2 WHERE ea2.item_id = ea.item_id) > 0
              ";
              $result_count = $conexion->query($query_normales_count);
              $total_records = $result_count->fetch_assoc()['total'];
              $total_pages = ceil($total_records / $records_per_page);

              // Obtener la página actual
              $page = isset($_GET['page']) ? $_GET['page'] : 1;
              $start_from = ($page - 1) * $records_per_page;

              // Consulta con limit para obtener solo los registros necesarios
              $query_normales = "
                SELECT ia.item_id, ia.item_code, ia.item_name, ia.item_grams, ia.item_max, ia.item_min, ia.reorden, 
                       SUM(ea.existe_qty) as cuantos
                FROM existencias_almacen ea
                INNER JOIN item_almacen ia ON ea.item_id = ia.item_id
                GROUP BY ea.item_id
                HAVING cuantos > 0
                ORDER BY ia.item_code ASC
                LIMIT $start_from, $records_per_page
              ";
              $resultado_normales = $conexion->query($query_normales) or die($conexion->error);

              // Mostrar las filas de existencias globales normales
              while ($row_normales = $resultado_normales->fetch_assoc()) {
                $existencias = $row_normales['cuantos'];
                $maximo = $row_normales['item_max'];
                $minimo = $row_normales['item_min'];
                $reordena = $row_normales['reorden'];

                // Mostrar fila
                $fila = '<tr>'
                  . '<td>' . $row_normales['item_code'] . '</td>'
                  . '<td>' . $row_normales['item_name'] . ', ' . $row_normales['item_grams'] . '</td>'
                  . '<td>' . $maximo . '</td>'
                  . '<td>' . $reordena . '</td>'
                  . '<td>' . $minimo . '</td>';

                // Cambiar color de "Existencias" según los criterios especificados
                if ($existencias >= $maximo) {
                  $fila .= '<td bgcolor="#28a745">' . $existencias . '</td>';  // Verde
                } elseif ($existencias < $maximo && $existencias > $minimo) {
                  $fila .= '<td bgcolor="#ffc107">' . $existencias . '</td>';  // Amarillo
                } elseif ($existencias <= $minimo) {
                  $fila .= '<td bgcolor="red" style="color: white;">' . $existencias . '</td>';  // Rojo
                }

                $fila .= '</tr>';
                echo $fila;
              }
              ?>
            </tbody>
          </table>
        </div>

        <!-- Paginación para existencias globales normales -->
        <div class="pagination">
          <?php
          // Establecer el rango de páginas a mostrar
          $rango = 5;

          // Determinar el inicio y fin del rango de páginas a mostrar
          $inicio = max(1, $page - $rango);
          $fin = min($total_pages, $page + $rango);

          // Mostrar el enlace a la primera página
          if ($page > 1) {
            echo '<a href="?page=1">&laquo; Primero</a>';
            echo '<a href="?page=' . ($page - 1) . '">&lt; Anterior</a>';
          }

          // Mostrar las páginas dentro del rango
          for ($i = $inicio; $i <= $fin; $i++) {
            echo '<a href="?page=' . $i . '" class="' . ($i == $page ? 'current' : '') . '">' . $i . '</a>';
          }

          // Mostrar el enlace a la siguiente página
          if ($page < $total_pages) {
            echo '<a href="?page=' . ($page + 1) . '">Siguiente &gt;</a>';
            echo '<a href="?page=' . $total_pages . '">Último &raquo;</a>';
          }

          ?>
        </div>
      </div>

      <!-- Tab para existencias globales en 0 -->
      <div class="tab-pane fade" id="cero" role="tabpanel" aria-labelledby="cero-tab">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="mytable-cero">
            <thead class="thead" style="background-color: #0c675e; color: white;">
              <tr>
                <th>
                  <font color="white">Código
                </th>
                <th>
                  <font color="white">Medicamento / Insumo
                </th>
                <th>
                  <font color="white">Máximo
                </th>
                <th>
                  <font color="white">P.reorden
                </th>
                <th>
                  <font color="white">Mínimo
                </th>
                <th>
                  <font color="white">Existencias
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Configuración de la paginación para existencias globales en 0
              $query_cero_count = "
                SELECT COUNT(DISTINCT ea.item_id) as total
                FROM existencias_almacen ea
                INNER JOIN item_almacen ia ON ea.item_id = ia.item_id
                WHERE (SELECT SUM(ea2.existe_qty) FROM existencias_almacen ea2 WHERE ea2.item_id = ea.item_id) = 0
              ";
              $result_cero_count = $conexion->query($query_cero_count);
              $total_records_cero = $result_cero_count->fetch_assoc()['total'];
              $total_pages_cero = ceil($total_records_cero / $records_per_page);

              $page_cero = isset($_GET['page_cero']) ? $_GET['page_cero'] : 1;
              $start_from_cero = ($page_cero - 1) * $records_per_page;

              $query_cero = "
                SELECT ia.item_id, ia.item_code, ia.item_name, ia.item_grams, ia.item_max, ia.item_min, ia.reorden, 
                       SUM(ea.existe_qty) as cuantos
                FROM existencias_almacen ea
                INNER JOIN item_almacen ia ON ea.item_id = ia.item_id
                GROUP BY ea.item_id
                HAVING cuantos = 0
                ORDER BY ia.item_code ASC
                LIMIT $start_from_cero, $records_per_page
              ";
              $resultado_cero = $conexion->query($query_cero) or die($conexion->error);

              // Mostrar filas de existencias globales en 0
              while ($row_cero = $resultado_cero->fetch_assoc()) {
                $existencias = $row_cero['cuantos'];
                $maximo = $row_cero['item_max'];
                $minimo = $row_cero['item_min'];
                $reordena = $row_cero['reorden'];

                // Mostrar fila
                $fila = '<tr>'
                  . '<td>' . $row_cero['item_code'] . '</td>'
                  . '<td>' . $row_cero['item_name'] . ', ' . $row_cero['item_grams'] . '</td>'
                  . '<td>' . $maximo . '</td>'
                  . '<td>' . $reordena . '</td>'
                  . '<td>' . $minimo . '</td>';

                $fila .= '<td>' . $existencias . '</td>'
                  . '</tr>';
                echo $fila;
              }
              ?>
            </tbody>
          </table>
        </div>

        <!-- Paginación para existencias globales en 0 -->
        <div class="pagination">
          <?php
          // Establecer el rango de páginas a mostrar
          $rango = 5;

          // Determinar el inicio y fin del rango de páginas a mostrar
          $inicio_cero = max(1, $page_cero - $rango);
          $fin_cero = min($total_pages_cero, $page_cero + $rango);

          // Mostrar el enlace a la primera página
          if ($page_cero > 1) {
            echo '<a href="?page_cero=1#cero">&laquo; Primero</a>';
            echo '<a href="?page_cero=' . ($page_cero - 1) . '#cero">&lt; Anterior</a>';
          }

          // Mostrar las páginas dentro del rango
          for ($i = $inicio_cero; $i <= $fin_cero; $i++) {
            echo '<a href="?page_cero=' . $i . '#cero" class="' . ($i == $page_cero ? 'current' : '') . '">' . $i . '</a>';
          }

          // Mostrar el enlace a la siguiente página
          if ($page_cero < $total_pages_cero) {
            echo '<a href="?page_cero=' . ($page_cero + 1) . '#cero">Siguiente &gt;</a>';
            echo '<a href="?page_cero=' . $total_pages_cero . '#cero">Último &raquo;</a>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
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
</body>

</html>
