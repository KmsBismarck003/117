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



// Consulta SQL para obtener el total de entradas por cada lote y el total general de entradas por medicamento
$sql = "
  SELECT 
    cr.id_recib AS ID,
    ia.item_name AS Medicamento,
    cr.fecha AS FechaSolicitud,
    cr.almacen AS SubAlmacen,
    cr.id_atencion AS Atencion,
    cr.solicita AS Solicitan,
    cr.nom_pac AS Nom_Pac,
    GROUP_CONCAT(ea.existe_lote ORDER BY ea.existe_caducidad ASC) AS Lotes,
    GROUP_CONCAT(ea.existe_caducidad ORDER BY ea.existe_caducidad ASC) AS Caducidades,
    GROUP_CONCAT(ea.existe_qty ORDER BY ea.existe_caducidad ASC) AS TotalEntradasPorLote,
    GROUP_CONCAT(ea.existe_id ORDER BY ea.existe_caducidad ASC) AS ExisteIds,

    (SELECT SUM(existe_qty) 
     FROM existencias_almacenh 
     WHERE item_id = cr.item_id) AS TotalEntradasGeneral,
    (SELECT SUM(entrega) 
     FROM carrito_entradash 
     WHERE id_recib = cr.id_recib) AS Entrega -- Sumar todos los valores de entrega para el id_recib
FROM 
    cart_fh cr
LEFT JOIN 
    existencias_almacenh ea ON cr.item_id = ea.item_id AND ea.existe_qty > 0
JOIN
    item_almacen ia ON cr.item_id = ia.item_id
WHERE 
    cr.confirma = 'SI'
GROUP BY 
    cr.id_recib, ia.item_name, cr.fecha, cr.almacen, cr.solicita
ORDER BY 
    ia.item_name, cr.id_recib, cr.fecha ASC;

";





$resultados = $conexion->query($sql);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $lotesSeleccionados = isset($_POST['lotes']) ? $_POST['lotes'] : [];
  $fechaActual = date('Y-m-d H:i:s');

  // Convertir la variable a JSON


  if (!empty($lotesSeleccionados)) {
    foreach ($lotesSeleccionados as $idRecib => $jsonData) {
      $data = json_decode($jsonData, true);

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
            die("Error: No se encontró el ítem con ID $itemIdCartRecib.");
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
            $stmtSelect->close();

            // Validar si hay suficiente stock
            if ($existeQty < $cantidadLote) {
              echo "<script>
                alert('Error: El lote \"$loteNombre\" no tiene suficiente stock. Disponible: $existeQty, requerido: $cantidadLote.');
                window.location.href = 'surtir_med.php';
                </script>";
              exit;
            }


            // Calcular nuevos valores
            $nuevaExistenciaQty = $existeQty - $cantidadLote;
            $nuevaExistenciaSalidas = $existeSalidas + $cantidadLote;


            // Consulta para actualizar existencias
            $updateExistenciasQuery = "UPDATE existencias_almacenh SET existe_qty = ?, existe_fecha=?, existe_salidas = ? WHERE existe_id = ?";
            $stmtUpdateExistencias = $conexion->prepare($updateExistenciasQuery);
            $stmtUpdateExistencias->bind_param('isii', $nuevaExistenciaQty, $fechaActual, $nuevaExistenciaSalidas, $existeId);
            $stmtUpdateExistencias->execute();
            $stmtUpdateExistencias->close();


            $queryExistencias = "
                          SELECT existe_qty, existe_salidas, item_id ,existe_caducidad 
                          FROM existencias_almacenh 
                          WHERE existe_lote = ? AND item_id = ?";
            $stmtExistencias = $conexion->prepare($queryExistencias);
            $stmtExistencias->bind_param('si', $loteNombre, $itemIdCartRecib);
            $stmtExistencias->execute();
            $resultExistencias = $stmtExistencias->get_result();
            $existencia = $resultExistencias->fetch_assoc();
            $stmtExistencias->close();

            if ($total == $solicitaCartRecib) {
              $caducidad = $existencia['existe_caducidad'];




              // Consulta para obtener el valor actual de kardex_qty del lote seleccionado
              $selectKardexQtyQuery = "SELECT kardex_qty FROM kardex_almacenh WHERE kardex_lote = ? AND item_id = ? AND kardex_caducidad = ? ORDER BY kardex_id DESC LIMIT 1";
              $stmtSelectKardex = $conexion->prepare($selectKardexQtyQuery);
              $stmtSelectKardex->bind_param('sis', $loteNombre, $itemIdCartRecib, $caducidad);
              $stmtSelectKardex->execute();
              $resultSelectKardex = $stmtSelectKardex->get_result();



              $row = $resultSelectKardex->fetch_assoc();
              $kardexQtyActual = $row['kardex_qty'];

              // Calcular el nuevo valor de kardex_qty
              $nuevoKardexQty = $kardexQtyActual - $cantidadLote;



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
                    kardex_destino,
                    id_surte
                ) VALUES (NOW(), ?, ?, ?, 0, 0, ?, ?,0,0, 'Salida', 'FARMACIA',?)
                ";
              $stmt_kardex = $conexion->prepare(query: $insert_kardex);

              $stmt_kardex->bind_param(
                "issiii",
                $itemIdCartRecib,
                $loteNombre,
                $caducidad,
                $cantidadLote,
                $nuevoKardexQty,
                $id_usua

              );
              $stmt_kardex->execute();


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
                    fecha_solicitud
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
             ";

              $stmtInsertSalida = $conexion->prepare($queryInsercion);
              $stmtInsertSalida->bind_param(
                "issssdiisss",
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
              );

              $stmtInsertSalida->execute();

              // Obtener el salida_id recién insertado
              $salidaId = $stmtInsertSalida->insert_id; // Obtener el ID generado automáticamente
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

              $stmtInsertDatCtapac = $conexion->prepare($insertDatCtapacQuery);
              $prodServ = 'P';
              $ctaActivo = 'SI';

              $stmtInsertDatCtapac->bind_param(
                'isssddsssss',
                $Id_Atencion,
                $prodServ,
                $itemIdCartRecib,
                $fecha_solicitud,
                $cantidadLote,
                $salidaCostsu,
                $id_usua,
                $ctaActivo,
                $salidaId, // Usamos el ID recién insertado
                $loteNombre,
                $caducidad
              );

              $stmtInsertDatCtapac->execute();
              $stmtInsertDatCtapac->close();

              // Actualiza 'enviado' a 'SI'
              $updateQuery = "UPDATE cart_fh SET enviado = 'SI' WHERE id_recib = ?";
              $stmtUpdate = $conexion->prepare($updateQuery);
              $stmtUpdate->bind_param('i', $idRecib);
              $stmtUpdate->execute();
              $stmtUpdate->close();

              $delete_cart_fh = "DELETE FROM cart_fh WHERE id_recib = ?";
              $stmt_delete_cart_fh = $conexion->prepare($delete_cart_fh);
              $stmt_delete_cart_fh->bind_param("i", $idRecib);
              $stmt_delete_cart_fh->execute();


              // Inserta los datos en la tabla `cart_recib`
              $ingresar2 = mysqli_query($conexion, "INSERT INTO cart_recib(item_id, solicita, almacen,id_usua,confirma)
          VALUES ($itemIdCartRecib, $cantidadLote, 'FARMACIA',$id_usua,'SI')")
                or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
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
      window.location.href = 'surtir_med.php';
    </script>";
  exit();
}





?>
<!DOCTYPE html>
<html lang="es">



<body>
  <a href="../../template/menu_farmaciah.php"

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
              <th class="col-surtir">
                <font color="white">Agregar</font>
              </th>
              <th class="col-seleccionar"></th>

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
                  $existeId = $existeIds[$key]; // Obtener el existe_id correspondiente
                  echo "<option value='{$lote}' data-existe-id='{$existeId}' data-lote='{$lote}' data-entradas='{$entradas}' data-caducidad='{$caducidad}'>{$lote}</option>";
                }

                echo "</select>";
                echo "<td class='col-caducidad' id='caducidad_{$index}'>{$caducidades[0]}</td>";
                echo "<td id='existencias_{$index}' class='col-existencias'>{$entradasPorLote[0]} / {$totalGeneral}</td>";
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

                // El botón "Agregar" está dentro del bucle, lo que permite tener uno por cada fila
                echo "<td><button type='button' class='enviar' onclick='agregarSurtir({$idRecib})' style='padding: 4px 8px; font-size: px;'>Agregar</button></td>";
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
        <div style="text-align: right; padding-top: 10px;">
          <button type="submit" id="btnEnviar" class="enviar">Enviar</button>

          <div id="datosSurtirOutput" style="margin-top: 20px; padding: 10px; display: flex; justify-content: center; align-items: center;">
          </div>

      </form>

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
    const totalEntradasLote = selectedOption.getAttribute('data-entradas');
    const caducidad = selectedOption.getAttribute('data-caducidad');

    // Actualizar la celda de existencias con el valor del lote seleccionado y el total general
    document.getElementById('existencias_' + index).innerText = totalEntradasLote + ' / ' + totalGeneral;

    // Actualizar la celda de caducidad con la fecha de caducidad del lote seleccionado
    document.getElementById('caducidad_' + index).innerText = caducidad;
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
</script>



<style>
  .borrar-btn {
    background-color: #0c675e;
    color: white;
    border: none;
    padding: 5px;
    font-size: 12px;
    cursor: pointer;
    margin-left: 6px;
    text-align: center;

  }


  table {
    table-layout: fixed;
    width: 120%;
    /* Aumenta el ancho para forzar el desplazamiento horizontal */
    border-collapse: collapse;
  }

  .col-seleccionar {
    width: 50px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-id {
    width: 60px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-medicamentos {
    width: 125px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-fecha {
    width: 100px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-almacen {
    width: 100px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-solicitan {
    width: 90px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-lote {
    width: 80px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-caducidad {
    width: 100px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }


  .col-existencias {
    width: 150px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-surtir {
    width: 100px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-parcial {
    width: 83px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-atencion {
    width: 75px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }

  .col-PAC {
    width: 140px;
    text-align: center;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
  }


  .input-uniform {
    width: 100%;
    box-sizing: border-box;
    padding: 5px;
  }

  th,
  td {
    padding: 8px;
    text-align: center;
  }

  .table-container {
    width: 100%;
    overflow-x: auto;
  }

  table {
    border: 1px solid #ddd;
  }

  th,
  td {
    border: 1px solid #ddd;
    /* Borde en las celdas */
  }

  button.enviar {
    background-color: #0c675e;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
  }

  button.enviar:hover {
    background-color: #094c42;
    /* Un color ligeramente más oscuro para el hover */
  }
</style>