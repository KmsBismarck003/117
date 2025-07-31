<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../index.php");
}

include("../header_configuracion.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

  <script src="../../js/jquery-3.3.1.min.js"></script>
  <script src="../../js/jquery-ui.js"></script>
  <script src="../../js/popper.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/jquery.magnific-popup.min.js"></script>
  <script src="../../js/aos.js"></script>
  <script src="../../js/main.js"></script>

  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

  <style>
    .form-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 15px;
    }
    .form-header {
      background-color: #2b2d7f;
      color: white;
      font-size: 1.5rem;
      font-weight: bold;
      text-align: center;
      padding: 10px;
      border-radius: 5px 5px 0 0;
      width: 100%;
    }
    .form-group {
      margin-bottom: 10px;
    }
    .form-group label {
      font-weight: 600;
      margin-bottom: 5px;
    }
    .form-group select,
    .form-group input {
      font-size: 0.9rem;
    }
    .price-group {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
    }
    .btn-group {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 15px;
    }
    .alert {
      margin-top: 15px;
      padding: 10px;
      border-radius: 5px;
    }
  </style>

  <script>
    $(document).ready(function() {
        $('#item-type').change(function() {
            var desc = $(this).find('option:selected').data('desc');
            $('#tip_insumo').val(desc);
        });
    });
  </script>
</head>

<body>
  <section class="container">
    <div class="container">
      <div class="form-header">EDITAR SERVICIO</div>
      <?php
      $id = isset($_GET['id']) ? $conexion->real_escape_string($_GET['id']) : '';
      $sql = "SELECT s.*, t.ser_type_desc, p.nom_prov 
              FROM cat_servicios s 
              LEFT JOIN service_type t ON s.tipo = t.ser_type_id 
              LEFT JOIN proveedores p ON s.proveedor = p.id_prov 
              WHERE s.id_serv = '$id'";
      $result = $conexion->query($sql);
      if ($result && $row_datos = $result->fetch_assoc()) {
      ?>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="clave">Clave:</label>
            <input type="text" name="clave" placeholder="Clave de Servicio" id="clave" value="<?php echo htmlspecialchars($row_datos['serv_cve']); ?>" required class="form-control">
          </div>
          <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" placeholder="Descripción" id="descripcion" value="<?php echo htmlspecialchars($row_datos['serv_desc']); ?>" required class="form-control">
          </div>
          <div class="form-group">
            <label>Precios:</label>
            <div class="price-group">
              <div>
                <label for="costo">Precio 1:</label>
                <input type="number" min="0" step="0.01" name="costo" placeholder="Precio 1" id="costo" value="<?php echo htmlspecialchars($row_datos['serv_costo']); ?>" required class="form-control">
              </div>
              <div>
                <label for="costo2">Precio 2 (AXA):</label>
                <input type="number" min="0" step="0.01" name="costo2" placeholder="Precio 2" id="costo2" value="<?php echo htmlspecialchars($row_datos['serv_costo2']); ?>" class="form-control">
              </div>
              <div>
                <label for="costo3">Precio 3 (GNP):</label>
                <input type="number" min="0" step="0.01" name="costo3" placeholder="Precio 3" id="costo3" value="<?php echo htmlspecialchars($row_datos['serv_costo3']); ?>" class="form-control">
              </div>
              <div>
                <label for="costo4">Precio 4 (Rentas):</label>
                <input type="number" min="0" step="0.01" name="costo4" placeholder="Precio 4" id="costo4" value="<?php echo htmlspecialchars($row_datos['serv_costo4']); ?>" class="form-control">
              </div>
              <div>
                <label for="costo5">Precio 5:</label>
                <input type="number" min="0" step="0.01" name="costo5" placeholder="Precio 5" id="costo5" value="<?php echo htmlspecialchars($row_datos['serv_costo5']); ?>" class="form-control">
              </div>
              <div>
                <label for="costo6">Precio 6:</label>
                <input type="number" min="0" step="0.01" name="costo6" placeholder="Precio 6" id="costo6" value="<?php echo htmlspecialchars($row_datos['serv_costo6']); ?>" class="form-control">
              </div>
              <div>
                <label for="costo7">Precio 7:</label>
                <input type="number" min="0" step="0.01" name="costo7" placeholder="Precio 7" id="costo7" value="<?php echo htmlspecialchars($row_datos['serv_costo7']); ?>" class="form-control">
              </div>
              <div>
                <label for="costo8">Precio 8:</label>
                <input type="number" min="0" step="0.01" name="costo8" placeholder="Precio 8" id="costo8" value="<?php echo htmlspecialchars($row_datos['serv_costo8']); ?>" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="med">Unidad de medida:</label>
            <select name="med" class="form-control" required>
              <option value="<?php echo htmlspecialchars($row_datos['serv_umed']); ?>"><?php echo htmlspecialchars($row_datos['serv_umed']); ?></option>
              <option value="CONSULTA">CONSULTA</option>
              <option value="EQUIPO">EQUIPO</option>
              <option value="ESTUDIO">ESTUDIO</option>
              <option value="HORA">HORA</option>
              <option value="SERVICIO">SERVICIO</option>
            </select>
          </div>
          <div class="form-group">
            <label for="tipo">Tipo:</label>
            <select id="item-type" name="tipo" class="form-control" required>
              <option value="<?php echo htmlspecialchars($row_datos['tipo']); ?>" data-desc="<?php echo htmlspecialchars($row_datos['ser_type_desc']); ?>"><?php echo htmlspecialchars($row_datos['ser_type_desc']); ?></option>
              <?php
              $query = "SELECT * FROM `service_type` WHERE ser_type_id != '" . $conexion->real_escape_string($row_datos['tipo']) . "'";
              $result = $conexion->query($query);
              if ($result) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . htmlspecialchars($row['ser_type_id']) . "' data-desc='" . htmlspecialchars($row['ser_type_desc']) . "'>" . htmlspecialchars($row['ser_type_desc']) . "</option>";
                }
              } else {
                echo "<option value=''>Error cargando tipos</option>";
              }
              ?>
            </select>
            <input type="hidden" name="tip_insumo" id="tip_insumo" value="<?php echo htmlspecialchars($row_datos['ser_type_desc']); ?>">
          </div>
          <div class="form-group">
            <label for="proveedor">Proveedor:</label>
            <select name="proveedor" id="proveedor" class="form-control" required>
              <?php
              $proveedor_id = $row_datos['proveedor'];
              $proveedor_name = $row_datos['nom_prov'] ? htmlspecialchars($row_datos['nom_prov']) : 'Sin proveedor';
              echo "<option value='" . htmlspecialchars($proveedor_id) . "'>" . $proveedor_name . "</option>";
              $query_prov = "SELECT id_prov, nom_prov FROM proveedores WHERE id_prov != '" . $conexion->real_escape_string($proveedor_id) . "'";
              $result_prov = $conexion->query($query_prov);
              if ($result_prov) {
                while ($row_prov = $result_prov->fetch_assoc()) {
                  echo "<option value='" . htmlspecialchars($row_prov['id_prov']) . "'>" . htmlspecialchars($row_prov['nom_prov']) . "</option>";
                }
              } else {
                echo "<option value=''>Error cargando proveedores</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="grupo">Grupo:</label>
            <select name="grupo" id="grupo" class="form-control" required>
              <option value="<?php echo htmlspecialchars($row_datos['grupo']); ?>"><?php echo htmlspecialchars($row_datos['grupo']); ?></option>
              <?php
              $grupos = ["SERVICIOS HOSPITALARIOS", "IMAGENOLOGIA"];
              foreach ($grupos as $grupo) {
                if ($grupo != $row_datos['grupo']) {
                  echo "<option value='" . htmlspecialchars($grupo) . "'>" . htmlspecialchars($grupo) . "</option>";
                }
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="codigo_sat">Código SAT:</label>
            <input type="text" name="codigo_sat" id="codigo_sat" value="<?php echo htmlspecialchars($row_datos['codigo_sat']); ?>" required class="form-control">
          </div>
          <div class="form-group">
            <label for="c_cveuni">Clave Unidad:</label>
            <input type="text" name="c_cveuni" id="c_cveuni" value="<?php echo htmlspecialchars($row_datos['c_cveuni']); ?>" required class="form-control">
          </div>
          <div class="form-group text-center">
            <input type="submit" name="edit" class="btn btn-success" value="Guardar">
            <a href="../servicios/cat_servicios.php" class="btn btn-danger">Cancelar</a>
          </div>
        </form>
      <?php } else { ?>
        <p class='alert alert-danger'>No se encontró el servicio con ID <?php echo htmlspecialchars($id); ?>.</p>
      <?php } ?>
      <?php
      if (isset($_POST['edit'])) {
        $serv_cve = mysqli_real_escape_string($conexion, (strip_tags($_POST["clave"], ENT_QUOTES)));
        $serv_desc = mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
        $serv_costo = mysqli_real_escape_string($conexion, (strip_tags($_POST["costo"], ENT_QUOTES)));
        $serv_costo2 = isset($_POST['costo2']) && $_POST['costo2'] !== '' ? mysqli_real_escape_string($conexion, (strip_tags($_POST["costo2"], ENT_QUOTES))) : 0;
        $serv_costo3 = isset($_POST['costo3']) && $_POST['costo3'] !== '' ? mysqli_real_escape_string($conexion, (strip_tags($_POST["costo3"], ENT_QUOTES))) : 0;
        $serv_costo4 = isset($_POST['costo4']) && $_POST['costo4'] !== '' ? mysqli_real_escape_string($conexion, (strip_tags($_POST["costo4"], ENT_QUOTES))) : 0;
        $serv_costo5 = isset($_POST['costo5']) && $_POST['costo5'] !== '' ? mysqli_real_escape_string($conexion, (strip_tags($_POST["costo5"], ENT_QUOTES))) : 0;
        $serv_costo6 = isset($_POST['costo6']) && $_POST['costo6'] !== '' ? mysqli_real_escape_string($conexion, (strip_tags($_POST["costo6"], ENT_QUOTES))) : 0;
        $serv_costo7 = isset($_POST['costo7']) && $_POST['costo7'] !== '' ? mysqli_real_escape_string($conexion, (strip_tags($_POST["costo7"], ENT_QUOTES))) : 0;
        $serv_costo8 = isset($_POST['costo8']) && $_POST['costo8'] !== '' ? mysqli_real_escape_string($conexion, (strip_tags($_POST["costo8"], ENT_QUOTES))) : 0;
        $serv_umed = mysqli_real_escape_string($conexion, (strip_tags($_POST["med"], ENT_QUOTES)));
        $serv_type = mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES)));
        $proveedor = mysqli_real_escape_string($conexion, (strip_tags($_POST["proveedor"], ENT_QUOTES)));
        $grupo = mysqli_real_escape_string($conexion, (strip_tags($_POST["grupo"], ENT_QUOTES)));
        $codigo_sat = mysqli_real_escape_string($conexion, (strip_tags($_POST["codigo_sat"], ENT_QUOTES)));
        $c_cveuni = mysqli_real_escape_string($conexion, (strip_tags($_POST["c_cveuni"], ENT_QUOTES)));
        $c_nombre = "SERVICIO";
        $tasa = 0.16;

        $query_tipo = "SELECT ser_type_desc FROM service_type WHERE ser_type_id = '$serv_type'";
        $result_tipo = $conexion->query($query_tipo);
        $tip_insumo = ($result_tipo && $row_tipo = $result_tipo->fetch_assoc()) ? $row_tipo['ser_type_desc'] : '';

        $sql2 = "UPDATE cat_servicios SET 
                  serv_cve = '$serv_cve', 
                  serv_desc = '$serv_desc', 
                  serv_costo = '$serv_costo', 
                  serv_costo2 = '$serv_costo2', 
                  serv_costo3 = '$serv_costo3', 
                  serv_costo4 = '$serv_costo4', 
                  serv_costo5 = '$serv_costo5', 
                  serv_costo6 = '$serv_costo6', 
                  serv_costo7 = '$serv_costo7', 
                  serv_costo8 = '$serv_costo8', 
                  serv_umed = '$serv_umed', 
                  tipo = '$serv_type', 
                  tip_insumo = '$tip_insumo', 
                  proveedor = '$proveedor', 
                  grupo = '$grupo', 
                  codigo_sat = '$codigo_sat', 
                  c_cveuni = '$c_cveuni', 
                  c_nombre = '$c_nombre', 
                  tasa = '$tasa' 
                  WHERE id_serv = '$id'";
        $result = $conexion->query($sql2);

        if ($result) {
          echo "<p class='alert alert-success'> <i class='fa fa-check'></i> Dato actualizado correctamente...</p>";
          echo '<script type="text/javascript">window.location.href = "cat_servicios.php";</script>';
        } else {
          echo "<p class='alert alert-danger'> <i class='fa fa-times'></i> Error al actualizar, por favor intenta de nuevo...</p>";
        }
      }
      ?>
    </div>
    </div>
  </section>
  <footer class="main-footer">
    <?php include("../../template/footer.php"); ?>
  </footer>
</body>
</html>