<?php
// Habilitar reporte de errores para debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

include "../../conexionbd.php";
session_start();
ob_start();

$usuario = $_SESSION['login'];
$id_usua = $usuario['id_usua'];
date_default_timezone_set('America/Guatemala');

if (isset($usuario['id_rol'])) {
  if ($usuario['id_rol'] == 11 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5 || $usuario['id_rol'] == 1) {
    include "../header_farmaciah.php";
  } else {
    session_unset();
    session_destroy();
    echo "<script>window.location='../../index.php';</script>";
    exit();
  }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["id_solicitud"])) {
  $stmt = $conexion->prepare("DELETE FROM cart_fh WHERE id_recib = ?");
  $stmt->bind_param("i", $_POST["id_solicitud"]);
  echo json_encode(["success" => $stmt->execute()]);
  $stmt->close();
}

$id_atencion = isset($_GET['id_atencion']) ? intval($_GET['id_atencion']) : 0;

$sql = "
  SELECT 
    cr.id_recib AS ID,
    ia.item_name AS Medicamento,
    CONCAT(ia.item_name, ' (', ia.item_grams, ')') AS Medicamento,
    cr.fecha AS FechaSolicitud,
    cr.almacen AS SubAlmacen,
    cr.id_atencion AS Atencion,
    cr.solicita AS Solicitan,
    cr.nom_pac AS Nom_Pac,
    GROUP_CONCAT(ea.existe_lote ORDER BY ea.existe_caducidad ASC SEPARATOR ', ') AS Lotes,
    GROUP_CONCAT(ea.existe_caducidad ORDER BY ea.existe_caducidad ASC SEPARATOR ', ') AS Caducidades,
    GROUP_CONCAT(ea.existe_qty ORDER BY ea.existe_caducidad ASC SEPARATOR ', ') AS TotalEntradasPorLote,
    GROUP_CONCAT(ea.existe_id ORDER BY ea.existe_caducidad ASC SEPARATOR ', ') AS ExisteIds,

    COALESCE((
      SELECT SUM(existe_qty) 
      FROM existencias_almacenh 
      WHERE item_id = cr.item_id
    ), 0) AS TotalEntradasGeneral,

    COALESCE((
      SELECT SUM(entrega) 
      FROM carrito_entradash 
      WHERE id_recib = cr.id_recib
    ), 0) AS Entrega

  FROM 
    cart_fh cr
  LEFT JOIN 
    existencias_almacenh ea 
      ON cr.item_id = ea.item_id 
      AND ea.existe_qty > 0
  JOIN 
    item_almacen ia 
      ON cr.item_id = ia.item_id
  WHERE 
    cr.confirma = 'SI' 
    AND cr.id_atencion = $id_atencion
  GROUP BY 
    cr.id_recib, 
    ia.item_name,
    ia.item_grams,
    cr.fecha, 
    cr.almacen, 
    cr.solicita, 
    cr.id_atencion, 
    cr.nom_pac
  ORDER BY 
    ia.item_name, 
    cr.id_recib, 
    cr.fecha ASC
";



$resultados = $conexion->query($sql);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $lotesSeleccionados = isset($_POST['lotes']) ? $_POST['lotes'] : [];
  $fechaActual = date('Y-m-d H:i:s');
  if (empty($lotesSeleccionados)) {
    echo "<script>
      alert('Error: No se seleccionaron lotes.');
      window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
    </script>";
    exit;
  }


  if (!empty($lotesSeleccionados)) {
    foreach ($lotesSeleccionados as $idRecib => $jsonData) {
      $data = json_decode($jsonData, true);
      if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        die('Error al decodificar el JSON: ' . json_last_error_msg());
      }
      if (json_last_error() === JSON_ERROR_NONE) {
        $lotes = $data['lotes'];
        $total = $data['total'];




        // Obtener datos de cart_fh
        $queryCartRecib = "SELECT item_id,id_atencion,fecha, solicita, almacen,id_usua FROM cart_fh WHERE id_recib = ?";
        $stmtCartRecib = $conexion->prepare($queryCartRecib);
        $stmtCartRecib->bind_param('i', $idRecib);
        $stmtCartRecib->execute();
        $resultCartRecib = $stmtCartRecib->get_result();
        $cartRecibData = $resultCartRecib->fetch_assoc();
        if (!$cartRecibData) {
          echo "<script>
            alert('Error: No se encontró el registro de la tabla cart_fh con id_recib: " . $idRecib . "');
            window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
          </script>";
          exit;
        }


        $stmtCartRecib->close();




        if ($cartRecibData) {
          $solicitaCartRecib = intval($cartRecibData['solicita']);
          $Id_Atencion = intval($cartRecibData['id_atencion']);
          $fecha_solicitud = $cartRecibData['fecha'];

          $almacenCartRecib = $cartRecibData['almacen'];
          $itemIdCartRecib = $cartRecibData['item_id'];
          $Solicita = $cartRecibData['id_usua'];


          $queryItemAlmacen = "
          SELECT 
              item_name, 
              item_price 
          FROM 
              item_almacen 
          WHERE 
              item_id = ?
      ";
          $stmt = $conexion->prepare($queryItemAlmacen);
          $stmt->bind_param("i", $itemIdCartRecib);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
            $itemData = $result->fetch_assoc();
            $itemName = $itemData['item_name'];
            $salidaCostsu = $itemData['item_price'];
          } else {
            echo "<script>
              alert('Error: No se encontró el ítem con ID " . $itemIdCartRecib . "');
              window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
            </script>";
            exit;
          }
          if (!isset($itemData['item_name']) || !isset($itemData['item_price'])) {
            echo "<script>
              alert('Error: No se encontraron los datos del ítem en la tabla item_almacen');
              window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
            </script>";
            exit;
          }

          foreach ($lotes as $lote) {
            $loteNombre = $lote['lote'];
            $cantidadLote = intval($lote['cantidad']);
            $existeId = $lote['existe_id'];





            // Consulta para obtener las existencias
            $selectExistenciasQuery = "SELECT existe_qty, existe_salidas, item_id FROM existencias_almacenh WHERE existe_id = ?";
            $stmtSelect = $conexion->prepare($selectExistenciasQuery);
            $stmtSelect->bind_param('i', $existeId);
            $stmtSelect->execute();
            $stmtSelect->bind_result($existeQty, $existeSalidas, $itemIdCartRecib);
            $stmtSelect->fetch();


            // Calcular nuevos valores
            $nuevaExistenciaQty = $existeQty - $cantidadLote;
            $nuevaExistenciaSalidas = $existeSalidas + $cantidadLote;


            if (!isset($existeQty) || !isset($existeSalidas)) {
              echo "<script>
                alert('Error: No se encontraron las existencias para el existe_id: " . $existeId . "');
                window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
              </script>";
              exit;
            }

            $stmtSelect->close();

            // Validar si el total no es igual a la cantidad solicitada
            if ($total != $solicitaCartRecib) {
              echo "<script>
              alert('Error: El total no coincide con la cantidad solicitada.');
              window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
            </script>";
              exit;
            }


            // Validar si hay suficiente stock
            if ($existeQty < $cantidadLote) {
              echo "<script>
                alert('Error: El lote \"$loteNombre\" no tiene suficiente stock. Disponible: $existeQty, requerido: $cantidadLote.');
                window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
                </script>";
              exit;
            }
            if (!isset($existeQty)) {
              echo "<script>
                alert('Error: No se encontró la existencia de stock para el lote: " . $loteNombre . "');
                window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
              </script>";
              exit;
            }




            // Consulta para obtener los datos de la tabla existencias_almacenh a partir de existe_id
            $queryExistencias = "
                SELECT 
                    existe_qty, 
                    existe_salidas, 
                    item_id, 
                    existe_caducidad,
                    ubicacion_id 
                FROM 
                    existencias_almacenh 
                WHERE 
                    existe_id = ?
                ";

            $stmtExistencias = $conexion->prepare($queryExistencias);

            if (!$stmtExistencias) {
              echo "<script>
                alert('Error al preparar la consulta de existencias: " . $conexion->error . "');
                window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
              </script>";
              exit;
            }

            $stmtExistencias->bind_param('i', $existeId);

            $stmtExistencias->execute();

            $resultExistencias = $stmtExistencias->get_result();

            $existencia = $resultExistencias->fetch_assoc();

            $caducidad = $existencia['existe_caducidad'] ?? null;
            $ubicacionId = $existencia['ubicacion_id'] ?? null;

            $stmtExistencias->close();

            if ($total == $solicitaCartRecib) {
              // Iniciar transacción
              $conexion->autocommit(FALSE);
              
              try {
                // Insertar en kardex_almacenh
              $insert_kardex = "
                INSERT INTO kardex_almacenh (
                    kardex_fecha,
                    item_id,
                    kardex_lote,
                    kardex_caducidad,
                    kardex_inicial,
                    kardex_entradas,
                    kardex_salidas,
                    kardex_qty,
                    kardex_dev_stock,
                    kardex_dev_merma,
                    kardex_movimiento,
                    kardex_ubicacion,
                    kardex_destino,
                    id_surte
                ) VALUES (NOW(), ?, ?, ?, 0, 0, ?, 0, 0, 0, 'Surtir Paciente', ?, 'FARMACIA', ?)
                ";

              // Preparar la consulta
              $stmt_kardex = $conexion->prepare($insert_kardex);
              if (!$stmt_kardex) {
                throw new Exception("Error al preparar la consulta de Kardex: " . $conexion->error);
              }

              // Vincular los parámetros
              if (!$stmt_kardex->bind_param(
                "issiis",
                $itemIdCartRecib,
                $loteNombre,
                $caducidad,
                $cantidadLote,
                $ubicacionId,
                $id_usua
              )) {
                throw new Exception("Error al enlazar los parámetros de Kardex: " . $stmt_kardex->error);
              }

              // Ejecutar la consulta
              if (!$stmt_kardex->execute()) {
                throw new Exception("Error al ejecutar la consulta de Kardex: " . $stmt_kardex->error);
              }
              // Insertar en salidas_almacenh


              $queryInsercion = "
                INSERT INTO salidas_almacenh (
                    item_id, 
                    item_name, 
                    salida_fecha, 
                    salida_lote, 
                    salida_caducidad, 
                    salida_qty, 
                    salida_costsu, 
                    id_usua, 
                    id_atencion, 
                    solicita, 
                    fecha_solicitud,
                    tipo,
                    salio
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

              // Preparar la consulta
              $stmtInsertSalida = $conexion->prepare($queryInsercion);
              if (!$stmtInsertSalida) {
                throw new Exception("Error al preparar la consulta de Salidas: " . $conexion->error);
              }

              // Variables para los valores fijos
              $tipoSalida = 'Surtir Paciente';
              $salioDestino = 'FARMACIA';

              // Vincular los parámetros
              if (!$stmtInsertSalida->bind_param(
                "issssdiiissss",
                $itemIdCartRecib,
                $itemName,
                $fechaActual,
                $loteNombre,
                $caducidad,
                $cantidadLote,
                $salidaCostsu,
                $id_usua,
                $Id_Atencion,
                $Solicita,
                $fecha_solicitud,
                $tipoSalida,
                $salioDestino
              )) {
                throw new Exception("Error al enlazar los parámetros de Salidas: " . $stmtInsertSalida->error);
              }

              // Ejecutar la consulta
              if (!$stmtInsertSalida->execute()) {
                throw new Exception("Error al ejecutar la consulta de Salidas: " . $stmtInsertSalida->error);
              }

              // Obtener el salida_id recién insertado
              $salidaId = $stmtInsertSalida->insert_id;
              if (!$salidaId) {
                throw new Exception("Error al obtener el ID de la salida insertada: " . $stmtInsertSalida->error);
              }

              // Cerrar la consulta
              $stmtInsertSalida->close();
              // Insertar en dat_ctapac con el salida_id correspondiente
              $insertDatCtapacQuery = "
              INSERT INTO dat_ctapac (
                  id_atencion, 
                  prod_serv, 
                  insumo, 
                  cta_fec, 
                  cta_cant, 
                  cta_tot, 
                  id_usua, 
                  cta_activo, 
                  salida_id, 
                  existe_lote, 
                  existe_caducidad
              ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
          ";

              // Preparar la consulta
              $stmtInsertDatCtapac = $conexion->prepare($insertDatCtapacQuery);
              if (!$stmtInsertDatCtapac) {
                throw new Exception("Error al preparar la consulta de dat_ctapac: " . $conexion->error);
              }

              $prodServ = 'P';
              $ctaActivo = 'SI';

              // Vincular los parámetros
              if (!$stmtInsertDatCtapac->bind_param(
                'isssddsssss',
                $Id_Atencion,
                $prodServ,
                $itemIdCartRecib,
                $fecha_solicitud,
                $cantidadLote,
                $salidaCostsu,
                $id_usua,
                $ctaActivo,
                $salidaId,
                $loteNombre,
                $caducidad
              )) {
                throw new Exception("Error al enlazar los parámetros de dat_ctapac: " . $stmtInsertDatCtapac->error);
              }

              // Ejecutar la consulta
              if (!$stmtInsertDatCtapac->execute()) {
                throw new Exception("Error al ejecutar la consulta de dat_ctapac: " . $stmtInsertDatCtapac->error);
              }

              // Cerrar la consulta
              $stmtInsertDatCtapac->close();

              // Consulta para actualizar existencias
              $updateExistenciasQuery = "UPDATE existencias_almacenh SET existe_qty = ?, existe_fecha=?, existe_salidas = ? WHERE existe_id = ?";
              $stmtUpdateExistencias = $conexion->prepare($updateExistenciasQuery);
              if (!$stmtUpdateExistencias) {
                throw new Exception("Error al preparar la consulta de actualización de existencias: " . $conexion->error);
              }
              
              if (!$stmtUpdateExistencias->bind_param('isii', $nuevaExistenciaQty, $fechaActual, $nuevaExistenciaSalidas, $existeId)) {
                throw new Exception("Error al enlazar parámetros de actualización de existencias: " . $stmtUpdateExistencias->error);
              }
              
              if (!$stmtUpdateExistencias->execute()) {
                throw new Exception("Error al actualizar existencias: " . $stmtUpdateExistencias->error);
              }
              
              $stmtUpdateExistencias->close();

              $delete_cart_fh = "DELETE FROM cart_fh WHERE id_recib = ?";
              $stmt_delete_cart_fh = $conexion->prepare($delete_cart_fh);
              if (!$stmt_delete_cart_fh) {
                throw new Exception("Error al preparar la consulta de eliminación del carrito: " . $conexion->error);
              }
              
              if (!$stmt_delete_cart_fh->bind_param("i", $idRecib)) {
                throw new Exception("Error al enlazar parámetros de eliminación del carrito: " . $stmt_delete_cart_fh->error);
              }
              
              if (!$stmt_delete_cart_fh->execute()) {
                throw new Exception("Error al eliminar del carrito: " . $stmt_delete_cart_fh->error);
              }

              // Si llegamos aquí, todas las operaciones fueron exitosas
              $conexion->commit();
              $conexion->autocommit(TRUE);

              // Inserta los datos en la tabla `cart_recib`

              /*           $ingresar2 = mysqli_query($conexion, "INSERT INTO cart_recib(item_id, solicita, almacen,id_usua,confirma)
         VALUES ($itemIdCartRecib, $cantidadLote, 'FARMACIA',$id_usua,'SI')")
                or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));*/
                
              } catch (Exception $e) {
                // Si hay algún error, hacer rollback
                $conexion->rollback();
                $conexion->autocommit(TRUE);
                
                echo "<script>
                  alert('Error en el procesamiento: " . $e->getMessage() . "');
                  window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
                </script>";
                exit;
              }
            }
          }
        } else {
          echo "<p>No se seleccionaron lotes.</p>";
        }
      }
    }
  }

  $conexion->close();

  echo "<script>
      alert('Datos insertados correctamente');
      window.location.href = 'surtir_med.php?id_atencion=" . $id_atencion . "';
    </script>";
  exit();
}





?>
<!DOCTYPE html>
<html lang="es">



<body>
  <a href="../../template/menu_farmaciahosp.php"

    style='color: white; margin-left: 20px; margin-bottom: 1px; background-color: #d9534f; 
          border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; display: inline-block;'>
    Regresar
  </a>

  <section class="content container-fluid">

    <hr>
    <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
      <strong>
        <center>SURTIR PACIENTE</center>
      </strong>
    </div>
    <br>
    <div class="table-container">

      <form method="post" id="formSurtir" action="">
        <table class="table table-bordered table-striped" id="mytable">
          <thead class="thead" style="background-color: #0c675e">
            <tr>
              <th class="col-id">
                <font color="white">ID</font>
              </th>
              <th class="col-fecha">
                <font color="white">Fecha de solicitud</font>
              </th>
              <th class="col-medicamentos">
                <font color="white">Medicamento</font>
              </th>
              <th class="col-atencion">
                <font color="white">ID.ATENCION</font>
              </th>
              <th class="col-PAC">
                <font color="white">Paciente</font>
              </th>
              <th class="col-solicitan">
                <font color="white">Solicitan</font>
              </th>

              <th class="col-parcial">
                <font color="white">Enviar</font>
              </th>
              <th class="col-lote">
                <font color="white">Lote</font>
              </th>
              <th class="col-caducidad">
                <font color="white">Caducidad</font>
              </th>
              <th class="col-existencias">
                <font color="white">Existencias.Lote/Total</font>
              </th>
              <th class="col-surtir">
                <font color="white">Surtir</font>
              </th>
              <th class="col-seleccionar">
                <input type="checkbox" id="check-todos" style="width: 20px; height: 20px;" onclick="marcarTodos(this)">
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($resultados && $resultados->num_rows > 0) {
              $index = 1;
              while ($fila = $resultados->fetch_assoc()) {
                $lotes = explode(',', $fila['Lotes']);
                $caducidades = explode(',', $fila['Caducidades']);
                $entradasPorLote = explode(',', $fila['TotalEntradasPorLote']);
                $totalGeneral = $fila['TotalEntradasGeneral'];
                $idRecib = $fila['ID'];
                $solicita = $fila['Solicitan'];
                $entrega = $fila['Entrega'];
                $existeIds = explode(',', $fila['ExisteIds']); // Añadido para obtener los existe_id


                echo "<tr>";
                echo "<td class='col-id'>{$fila['ID']}</td>";
                echo "<td class='col-fecha'>{$fila['FechaSolicitud']}</td>";
                echo "<td class='col-medicamentos'>{$fila['Medicamento']}</td>";
                echo "<td class='col-atencion'>{$fila['Atencion']}</td>";
                echo "<td class='col-PAC'>{$fila['Nom_Pac']}</td>";
                echo "<td class='col-solicitan'>{$fila['Solicitan']}</td>";
                echo "<td class='col-parcial'>
                <span id='enviar-{$idRecib}'>0</span>
                <button type='button' onclick='borrarValorEnviar({$idRecib})' class='borrar-btn'>Borrar</button>
              </td>";
                echo "<td class='col-lote'>
               <select name='lote[{$fila['ID']}]' id='lote-{$fila['ID']}' class='lote-select' onchange=\"actualizarExistencias(this, {$totalGeneral}, {$index})\">
        <option value='' disabled selected>lote</option>";

                foreach ($lotes as $key => $lote) {
                  $caducidad = $caducidades[$key];
                  $entradas = $entradasPorLote[$key];
                  $existeId = $existeIds[$key];
                  echo "<option value='{$lote}' data-existe-id='{$existeId}' data-lote='{$lote}' data-entradas='{$entradas}' data-caducidad='{$caducidad}'>{$lote}</option>";
                }

                echo "</select>";
                echo "<td class='col-caducidad' id='caducidad_{$index}'>Seleccionar lote</td>";
                echo "<td id='existencias_{$index}' class='col-existencias'>Seleccionar lote</td>";
                echo "<td class='col-surtir'>
                <input 
                    type='number' 
                    name='cantidad_surtir[{$idRecib}]' 
                    id='cantidad-surtir-{$idRecib}' 
                    min='1' 
                    max='{$solicita}' 
                    oninput='validarCantidad(this, {$solicita}, {$entrega});' 
                    class='input-uniform cantidad-input'>
                    
              </td>";

                echo "<td class='col-seleccionar'><input type='checkbox' name='items_seleccionados[]' value='{$fila['ID']}' style='width: 20px; height: 20px;' class='item-checkbox' data-id='{$fila['ID']}'></td>";
                echo "</tr>";
                $index++;
              }
            } else {
              echo "<tr><td colspan='11' style='text-align: center;'>No hay datos disponibles</td></tr>";
            }
            ?>
          </tbody>
        </table>
        <div style="display: flex; flex-direction: column; align-items: flex-end; padding-top: 10px; gap: 10px;">

          <button type="button" class="enviar" onclick="agregarSeleccionados()" style="margin-right: 10px;">
            Agregar seleccionados
          </button>

          <button type="button" class="eliminar" onclick="eliminarSeleccionados()" style="margin-right: 10px; background-color: #dc3545;">
            Eliminar seleccionados
          </button>

          <button type="submit" id="btnEnviar" class="enviar" style="margin-right: 10px;">
            Enviar
          </button>

          <div id="datosSurtirOutput" style="margin-top: 20px; padding: 10px; display: flex; justify-content: center; align-items: center; width: 100%;">
          </div>

        </div>

    </div>
    </form>

    </div>
  </section>
</body>

</html>
<script>


  // Actualizar existencias y caducidad al cambiar de lote
  function actualizarExistencias(selectElement, totalGeneral, index) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    
    if (selectedOption.value === '') {
      // Si no hay lote seleccionado, mostrar mensaje por defecto
      document.getElementById('existencias_' + index).innerText = 'Seleccionar lote';
      document.getElementById('caducidad_' + index).innerText = 'Seleccionar lote';
    } else {
      // Si hay un lote seleccionado, mostrar los datos correspondientes
      const totalEntradasLote = selectedOption.getAttribute('data-entradas');
      const caducidad = selectedOption.getAttribute('data-caducidad');

      // Actualizar la celda de existencias con el valor del lote seleccionado y el total general
      document.getElementById('existencias_' + index).innerText = totalEntradasLote + ' / ' + totalGeneral;

      // Actualizar la celda de caducidad con la fecha de caducidad del lote seleccionado
      document.getElementById('caducidad_' + index).innerText = caducidad;
    }
  }
</script>


<script>
  // Objeto global para almacenar las cantidades surtidas por idRecib
  let datosSurtir = {};



  function validarCantidad(input, solicita, entrega) {
    const id = input.id.split('-')[2]; // Obtener el ID desde el input
    const valor = parseInt(input.value) || 0;

    // Obtener el total acumulado en datosSurtir para este ID, o inicializarlo en 0 si no existe
    const totalActual = datosSurtir[id]?.total || 0;

    // Calcular el resto que aún se puede surtir
    const entregaRestante = solicita - totalActual;

    // Validar la cantidad ingresada
    if (valor > entregaRestante || valor < 1) {
      alert("La cantidad debe estar entre 1 y " + entregaRestante + ".");
      input.value = ''; // Limpiar el valor si es inválido
    }
  }


  function actualizarVistaDatosSurtir() {
    const output = document.getElementById('datosSurtirOutput');
    output.innerHTML = ''; // Limpia el contenido previo

    // Verifica si hay datos en `datosSurtir`
    if (Object.keys(datosSurtir).length === 0) {
      output.textContent = 'No hay datos surtidos actualmente.';
      return;
    }

    // Construye una tabla para mostrar los datos
    let table = '<table style="width: 40%; border-collapse: collapse; text-align: center; float: right; margin-right: 20px;">';
    table += `
        <thead>
            <tr style="background-color: #0c675e; color: white;">
                <th style="border: 1px solid #ccc; padding: 8px; width: 1%;">ID</th>
                <th style="border: 1px solid #ccc; padding: 8px; width: 1%;">Total</th>
                <th style="border: 1px solid #ccc; padding: 8px; width: 2%;">Lotes</th>
            </tr>
        </thead>
        <tbody>
    `;

    for (const [id, datos] of Object.entries(datosSurtir)) {
      // Construye la lista de lotes para este ID
      const lotes = datos.lotes.map(lote =>
        `Lote: ${lote.lote}, Cantidad: ${lote.cantidad}`
      ).join('<br>');

      table += `
            <tr>
                <td style="border: 1px solid #ccc; padding: 8px; width: 1%;">${id}</td>
                <td style="border: 1px solid #ccc; padding: 8px; width: 1%;">${datos.total}</td>
                <td style="border: 1px solid #ccc; padding: 8px; width: 2%;">${lotes}</td>
            </tr>
        `;
    }

    table += '</tbody></table>';
    output.innerHTML = table;
  }

  function agregarSurtir(idRecib) {
    const input = document.getElementById(`cantidad-surtir-${idRecib}`);
    const valorSurtir = parseInt(input.value) || 0;

    const loteSelect = document.getElementById(`lote-${idRecib}`);
    const loteSeleccionado = loteSelect ? loteSelect.value : null;

    const checkbox = document.querySelector(`.item-checkbox[data-id="${idRecib}"]`);
    const checkboxMarcado = checkbox && checkbox.checked;

    if (checkboxMarcado) {
      if (valorSurtir > 0 && loteSeleccionado) {
        if (!datosSurtir[idRecib]) {
          datosSurtir[idRecib] = {
            total: 0,
            lotes: []
          };
        }

        // Verificar si el lote ya existe en el arreglo de lotes
        const loteExistente = datosSurtir[idRecib].lotes.find(lote => lote.lote === loteSeleccionado);

        if (loteExistente) {
          // Si el lote ya existe, sumar la cantidad
          loteExistente.cantidad += valorSurtir;
        } else {
          // Si no existe, agregar un nuevo lote
          datosSurtir[idRecib].lotes.push({
            lote: loteSeleccionado,
            cantidad: valorSurtir,
            existe_id: loteSelect.options[loteSelect.selectedIndex].getAttribute('data-existe-id')
          });
        }

        // Actualizar el total
        datosSurtir[idRecib].total += valorSurtir;
        document.getElementById(`enviar-${idRecib}`).textContent = datosSurtir[idRecib].total;

        // Limpiar el input y el select
        input.value = '';
        loteSelect.value = '';
        
        // Resetear las columnas de caducidad y existencias cuando se limpia el select
        const row = loteSelect.closest('tr');
        const rowIndex = Array.from(row.parentNode.children).indexOf(row) + 1;
        document.getElementById('existencias_' + rowIndex).innerText = 'Seleccionar lote';
        document.getElementById('caducidad_' + rowIndex).innerText = 'Seleccionar lote';
      } else {
        alert('Por favor, ingrese una cantidad válida y seleccione un lote.');
      }
    } else {
      if (datosSurtir[idRecib]) {
        delete datosSurtir[idRecib];
        document.getElementById(`enviar-${idRecib}`).textContent = 0;
      }
    }

    // Actualizar vista en pantalla
    actualizarVistaDatosSurtir();
    console.log("Datos en memoria:", datosSurtir);
    guardarEnSesion();
  }

  // Modifica `borrarValorEnviar` para actualizar la vista
  function borrarValorEnviar(id) {
    delete datosSurtir[id];
    document.getElementById(`enviar-${id}`).textContent = '0';
    actualizarVistaDatosSurtir();
    console.log("Datos después de borrar:", datosSurtir);
  }

  function guardarEnSesion() {
    // Verificar si hay datos en datosSurtir
    if (Object.keys(datosSurtir).length === 0) {
      alert('No hay datos para guardar.');
      return; // No hacer nada si no hay datos
    }
    
    document.getElementById("btnEnviar").addEventListener("click", function() {
      // Verificar si hay datos en datosSurtir
      if (Object.keys(datosSurtir).length === 0) {
        alert("No hay datos para guardar.");
        return; // No hacer nada si no hay datos
      }

      console.log("Datos antes de enviar:", datosSurtir); // Verifica el contenido

      // Crear un formulario oculto dinámico
      const form = document.getElementById("formSurtir"); // Usar el formulario existente

      // Limpia el formulario
      while (form.firstChild) {
        form.removeChild(form.firstChild);
      }

      // Convierte `datosSurtir` en campos ocultos
      for (let idRecib in datosSurtir) {
        const data = datosSurtir[idRecib];

        // Combina todos los datos en un solo campo oculto
        const inputData = document.createElement("input");
        inputData.type = "hidden";
        inputData.name = `lotes[${idRecib}]`;

        // Serializa los datos como JSON
        inputData.value = JSON.stringify({
          lotes: data.lotes.map(lote => ({
            lote: lote.lote,
            cantidad: lote.cantidad,
            existe_id: lote.existe_id // Incluye el existe_id aquí
          })),
          total: data.total,
        });

        form.appendChild(inputData);
      }

      // Envía el formulario
      console.log("enviar:", form); // Depuración
      form.submit();
    });
  }


  if (typeof datosRecibidos !== 'undefined') {
    console.log('Lotes recibidos:', datosRecibidos.lotes);
    console.log('Total:', datosRecibidos.total);
  }

  function marcarTodos(checkboxPrincipal) {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(cb => {
      if (!cb.disabled) {
        cb.checked = checkboxPrincipal.checked;
      }
    });
  }

  function agregarSeleccionados() {
    const checkboxes = document.querySelectorAll('.item-checkbox:checked');
    if (checkboxes.length === 0) {
      alert("Selecciona al menos un registro para agregar.");
      return;
    }

    checkboxes.forEach(checkbox => {
      const id = checkbox.getAttribute('data-id');
      agregarSurtir(id);
      checkbox.checked = false;
    });

    const checkboxTodos = document.getElementById('check-todos');
    if (checkboxTodos && checkboxTodos.checked) {
      checkboxTodos.checked = false;
    }

    actualizarVistaDatosSurtir();
  }

  function eliminarSeleccionados() {
    const checkboxes = document.querySelectorAll('.item-checkbox:checked');
    if (checkboxes.length === 0) {
      alert("Selecciona al menos un registro para eliminar.");
      return;
    }

    if (!confirm(`¿Estás seguro de eliminar ${checkboxes.length} solicitud(es)?`)) {
      return;
    }

    const idsToDelete = Array.from(checkboxes).map(cb => cb.getAttribute('data-id'));
    let eliminados = 0;

    idsToDelete.forEach(idSolicitud => {
      fetch("surtir_med.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: new URLSearchParams({
            eliminar_solicitud: "true",
            id_solicitud: idSolicitud
          })
        })
        .then(response => response.json())
        .then(data => {
          eliminados++;
          if (eliminados === idsToDelete.length) {
            alert(`${eliminados} solicitud(es) eliminada(s) correctamente.`);
            location.reload();
          }
        })
        .catch(error => {
          console.error("Error al eliminar la solicitud:", error);
          eliminados++;
          if (eliminados === idsToDelete.length) {
            alert("Proceso completado. Algunas eliminaciones pueden haber fallado.");
            location.reload();
          }
        });
    });
  }
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
  .borrar-btn,
  button.enviar,
  button.eliminar {
    background-color: #0c675e;
    color: white;
    border: none;
    padding: 5px;
    font-size: 15px;
    cursor: pointer;
    text-align: center;
  }

  button.enviar,
  button.eliminar {
    padding: 10px 20px;
  }

  button.enviar:hover {
    background-color: #094c42;
  }

  button.eliminar {
    background-color: #dc3545;
  }

  button.eliminar:hover {
    background-color: #c82333;
  }

  table {
    table-layout: fixed;
    width: 120%;
    border-collapse: collapse;
    border: 1px solid #ddd;
  }

  th,
  td {
    padding: 8px;
    text-align: center;
    border: 1px solid #ddd;
  }

  .table-container {
    width: 100%;
    overflow-x: auto;
  }

  .input-uniform {
    width: 100%;
    box-sizing: border-box;
    padding: 5px;
  }

  .col-seleccionar,
  .col-id,
  .col-medicamentos,
  .col-fecha,
  .col-almacen,
  .col-solicitan,
  .col-lote,
  .col-caducidad,
  .col-existencias,
  .col-surtir,
  .col-parcial,
  .col-atencion,
  .col-PAC {
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-seleccionar {
    width: 50px;
  }

  .col-id {
    width: 60px;
  }

  .col-medicamentos {
    width: 125px;
  }

  .col-fecha {
    width: 100px;
  }

  .col-almacen {
    width: 100px;
  }

  .col-solicitan {
    width: 90px;
  }

  .col-lote {
    width: 100px;
  }

  .col-caducidad {
    width: 105px;
  }

  .col-existencias {
    width: 150px;
  }

  .col-surtir {
    width: 100px;
  }

  .col-parcial {
    width: 83px;
  }

  .col-atencion {
    width: 75px;
  }

  .col-PAC {
    width: 140px;
  }
</style>