<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../index.php");
}

include("../header_enfermera.php");
?>

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!--  Bootstrap  -->
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
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script>
    // Write on keyup event of keyword input element
    $(document).ready(function() {
      $("#search").keyup(function() {
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#mytable tbody tr"), function() {
          if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
          else
            $(this).show();
        });
      });
    });
  </script>

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #0a0a0a 100%) !important;
      font-family: 'Roboto', sans-serif !important;
      min-height: 100vh;
    }

    /* Efecto de partículas en el fondo */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image:
          radial-gradient(circle at 20% 50%, rgba(64, 224, 255, 0.03) 0%, transparent 50%),
          radial-gradient(circle at 80% 80%, rgba(64, 224, 255, 0.03) 0%, transparent 50%),
          radial-gradient(circle at 40% 20%, rgba(64, 224, 255, 0.02) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
    }

    .content-wrapper {
      background: transparent !important;
      position: relative;
      z-index: 1;
    }

    /* Contenedor principal */
    .container.box {
      background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
      border: 2px solid #40E0FF !important;
      border-radius: 20px !important;
      padding: 30px !important;
      margin-bottom: 30px !important;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5),
                  0 0 30px rgba(64, 224, 255, 0.2) !important;
      position: relative;
      overflow: hidden;
    }

    .container.box::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(
          45deg,
          transparent,
          rgba(64, 224, 255, 0.05),
          transparent
      );
      transform: rotate(45deg);
      animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
      0%, 100% { transform: translateX(-100%) rotate(45deg); }
      50% { transform: translateX(100%) rotate(45deg); }
    }

    /* Headers de sección */
    .thead {
      background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
      border: 2px solid #40E0FF !important;
      border-radius: 15px !important;
      padding: 20px !important;
      margin-bottom: 25px !important;
      color: #ffffff !important;
      font-weight: 700 !important;
      letter-spacing: 2px !important;
      text-transform: uppercase !important;
      box-shadow: 0 8px 25px rgba(64, 224, 255, 0.3),
                  inset 0 0 20px rgba(64, 224, 255, 0.1) !important;
      position: relative;
      overflow: hidden;
    }

    .thead::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(64, 224, 255, 0.1) 0%, transparent 70%);
      animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.1); opacity: 0.8; }
    }

    .thead strong {
      position: relative;
      z-index: 1;
      text-shadow: 0 0 20px rgba(64, 224, 255, 0.5);
    }

    /* Input de búsqueda mejorado */
    .form-control {
      background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
      border: 2px solid #40E0FF !important;
      border-radius: 25px !important;
      color: #ffffff !important;
      padding: 12px 25px !important;
      font-weight: 500 !important;
      transition: all 0.3s ease !important;
      box-shadow: 0 5px 15px rgba(64, 224, 255, 0.2) !important;
    }

    .form-control:focus {
      background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
      border-color: #00D9FF !important;
      color: #ffffff !important;
      box-shadow: 0 8px 25px rgba(64, 224, 255, 0.4),
                  inset 0 0 15px rgba(64, 224, 255, 0.1) !important;
      outline: none !important;
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.5) !important;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    /* Tabla mejorada */
    .table-responsive {
      border-radius: 15px;
      overflow: hidden;
      margin-top: 25px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .table {
      margin-bottom: 0 !important;
      background: transparent !important;
    }

    .table thead.thead {
      background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
      border: none !important;
    }

    .table thead th {
      background: transparent !important;
      color: #40E0FF !important;
      font-weight: 700 !important;
      text-transform: uppercase !important;
      letter-spacing: 1.5px !important;
      padding: 20px 15px !important;
      border: none !important;
      font-size: 0.9rem !important;
      text-shadow: 0 0 15px rgba(64, 224, 255, 0.5);
      position: relative;
    }

    .table thead th::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, #40E0FF, transparent);
    }

    .table tbody tr {
      transition: all 0.3s ease;
      border-bottom: 1px solid rgba(64, 224, 255, 0.1) !important;
    }

    .table tbody tr:hover {
      transform: scale(1.01);
      box-shadow: 0 5px 20px rgba(64, 224, 255, 0.2);
    }

    .table tbody td {
      padding: 18px 15px !important;
      vertical-align: middle !important;
      border: none !important;
      font-size: 0.95rem !important;
    }

    /* Estilos de celdas ocupadas (azul oscuro) */
    td.fondo {
      background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
      border-left: 4px solid #40E0FF !important;
      color: #ffffff !important;
      position: relative;
      overflow: hidden;
    }

    td.fondo::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(64, 224, 255, 0.1), transparent);
      transition: left 0.5s ease;
    }

    tr:hover td.fondo::before {
      left: 100%;
    }

    td.fondo font {
      position: relative;
      z-index: 1;
    }

    /* Celdas con alta médica (verde) */
    td.fondo2 {
      background: linear-gradient(135deg, #1a4d2e 0%, #0f3a1f 100%) !important;
      border-left: 4px solid #00ff88 !important;
      color: #ffffff !important;
      position: relative;
      overflow: hidden;
    }

    td.fondo2::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(0, 255, 136, 0.1), transparent);
      transition: left 0.5s ease;
    }

    tr:hover td.fondo2::before {
      left: 100%;
    }

    /* Celdas en mantenimiento (rojo) */
    td.cuenta {
      background: linear-gradient(135deg, #4d1a1a 0%, #3a0f0f 100%) !important;
      border-left: 4px solid #ff4040 !important;
      color: #ffffff !important;
      position: relative;
      overflow: hidden;
    }

    td.cuenta::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 64, 64, 0.1), transparent);
      transition: left 0.5s ease;
    }

    tr:hover td.cuenta::before {
      left: 100%;
    }

    /* Celdas en proceso de liberar (naranja) */
    td.fondo3 {
      background: linear-gradient(135deg, #4d3a1a 0%, #3a2a0f 100%) !important;
      border-left: 4px solid #ff9940 !important;
      color: #ffffff !important;
      position: relative;
      overflow: hidden;
    }

    td.fondo3::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 153, 64, 0.1), transparent);
      transition: left 0.5s ease;
    }

    tr:hover td.fondo3::before {
      left: 100%;
    }

    /* Botones mejorados */
    .btn {
      border-radius: 25px !important;
      padding: 10px 25px !important;
      font-weight: 600 !important;
      text-transform: uppercase !important;
      letter-spacing: 1px !important;
      transition: all 0.3s ease !important;
      border: 2px solid #40E0FF !important;
      background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
      color: #ffffff !important;
      box-shadow: 0 5px 15px rgba(64, 224, 255, 0.3) !important;
    }

    .btn:hover {
      transform: translateY(-3px) scale(1.05) !important;
      box-shadow: 0 10px 30px rgba(64, 224, 255, 0.5) !important;
      background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
      border-color: #00D9FF !important;
      color: #ffffff !important;
    }

    .btn-success {
      border-color: #00ff88 !important;
      background: linear-gradient(135deg, #0f3a1f 0%, #1a4d2e 100%) !important;
    }

    .btn-success:hover {
      border-color: #00ffaa !important;
      box-shadow: 0 10px 30px rgba(0, 255, 136, 0.5) !important;
    }

    /* Efectos en íconos de botones */
    .btn img {
      transition: all 0.3s ease;
      filter: drop-shadow(0 0 5px rgba(64, 224, 255, 0.5));
    }

    .btn:hover img {
      transform: scale(1.2) rotate(360deg);
      filter: drop-shadow(0 0 10px rgba(64, 224, 255, 1));
    }

    /* Animaciones de entrada */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .container.box {
      animation: fadeInUp 0.6s ease-out backwards;
    }

    .container.box:nth-child(1) { animation-delay: 0.1s; }
    .container.box:nth-child(2) { animation-delay: 0.2s; }

    /* Scrollbar personalizado */
    ::-webkit-scrollbar {
      width: 12px;
      height: 12px;
    }

    ::-webkit-scrollbar-track {
      background: #0a0a0a;
      border-left: 1px solid #40E0FF;
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(180deg, #40E0FF 0%, #0f3460 100%);
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(180deg, #00D9FF 0%, #40E0FF 100%);
    }

    /* Responsive */
    @media screen and (max-width: 768px) {
      .thead {
        font-size: 16px !important;
        padding: 15px !important;
      }

      .table thead th {
        font-size: 0.75rem !important;
        padding: 12px 8px !important;
      }

      .table tbody td {
        font-size: 0.85rem !important;
        padding: 12px 8px !important;
      }

      .container.box {
        padding: 20px !important;
      }
    }

    /* Footer */
    .main-footer {
      background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
      border-top: 2px solid #40E0FF !important;
      color: #ffffff !important;
      box-shadow: 0 -4px 20px rgba(64, 224, 255, 0.2);
    }
  </style>
</head>

<body>
  <section class="content container-fluid">

    <div class="container box">
      <div class="thead">
        <tr><center><strong><i class="fa fa-exchange"></i> CAMBIO DE HABITACIÓN</strong></center></tr>
      </div>
    </div>

    <div class="container box">
      <div class="container-fluid">
        <div class="thead">
          <tr><center><strong><i class="fa fa-hospital-o"></i> HOSPITALIZACIÓN</strong></center><p>
        </div>

        <div class="row">
          <br />

          <div class="col-md-4">
            <input type="text" class="form-control pull-right" id="search" placeholder="🔍 BUSCAR PACIENTE">
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mytable">
              <thead class="thead">
                <tr>
                  <center>
                    <th scope="col">Cambiar</th>
                  </center>
                  <center>
                    <th scope="col">Habitación</th>
                  </center>
                  <th scope="col">
                    <center>Fecha de Ingreso</center>
                  </th>
                  <th scope="col">
                    <center>Paciente</center>
                  </th>
                  <th scope="col">
                    <center>Edad</center>
                  </th>
                  <th scope="col">
                    <center>Motivo Atención</center>
                  </th>
                  <th scope="col">
                    <center>Exp.</center>
                  </th>
                  <th scope="col">
                    <center>Médico tratante</center>
                  </th>
                  <th scope="col">
                    <center>Alta médica</center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php
                  $sql = "SELECT * from cat_camas where TIPO ='HOSPITALIZACION' ORDER BY num_cama ASC ";
                  $result = $conexion->query($sql);
                  while ($row = $result->fetch_assoc()) {
                    $id_at_cam = $row['id_atencion'];
                    $estatus = $row['estatus'];
                    $usuario = $_SESSION['login'];
                    $id_usua= $usuario['id_usua'];
                    $rol= $usuario['id_rol'];
                    $sql_tabla = "SELECT p.fecnac,p.Id_exp, p.papell, p.sapell,p.nom_pac, df.aseg, di.fecha, di.motivo_atn, di.alta_med,ru.pre, ru.papell as nom_doc from dat_ingreso di, dat_financieros df, paciente p, reg_usuarios ru WHERE p.Id_exp = di.Id_exp and di.id_atencion=df.id_atencion and di.id_usua = ru.id_usua and di.id_atencion = $id_at_cam LIMIT 1";
                    $result_tabla = $conexion->query($sql_tabla);
                    $rowcount = mysqli_num_rows($result_tabla);
                    if ($rowcount != 0) {
                      while ($row_tabla = $result_tabla->fetch_assoc()) {
                        $alta=$row_tabla['alta_med'];

                        $date1 = date_create($row_tabla['fecha']);
                        $fecingr = date_format($date1,"d/m/Y H:i");

                        if($alta=='SI'){
                          echo '<td></td>';
                         echo '<td class="fondo2"> <font color="white" size="2">' . $row['num_cama'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $fecingr. '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['nom_pac'] . ' ' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . calculaedad($row_tabla['fecnac']) .'</font></font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['motivo_atn'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['Id_exp'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['alta_med'] . '</font></td>';
                        echo '<tr>';
                        }else{
                          echo '<td class="fondo"> <a type="submit" class="btn btn-success btn-sm" href="realiza_cambio_hab.php?id_cama='.$row['num_cama'] .'&id_atencion='.$row['id_atencion'].'&tipo='.$row['tipo'].'&hab='.$row['habitacion'].'"><img src="https://img.icons8.com/office/16/000000/hospital-bed.png"/></a></td>';
                         echo '<td class="fondo"><font color="white" size="2">' . $row['num_cama'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $fecingr. '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['nom_pac'] . ' ' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . calculaedad($row_tabla['fecnac']) . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['motivo_atn'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['Id_exp'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['alta_med'] . '</font></td>';
                        echo '<tr>';
                        }
                      }
                    } elseif($estatus=="MANTENIMIENTO"){
                      echo '<td class="cuenta"></td>';
                      echo '<td class="cuenta"><font color="white" size="2">' . $row['num_cama'] . '</td>';
                      echo '<td class="cuenta"><font color="white" size="2">NO</td>';
                      echo '<td class="cuenta"><font color="white" size="2">DISPONIBLE</td>';
                      echo '<td class="cuenta"></td>';
                      echo '<td class="cuenta"></td>';
                      echo '<td class="cuenta"></td>';
                      echo '<td class="cuenta"></td>';
                      echo '<td class="cuenta"></td></tr>';
                    }elseif($estatus=="EN PROCESO DE LIBERA"){
                      echo '<td class="fondo3"></td>';
                      echo '<td class="fondo3">' . $row['num_cama'] . '</td>';
                      echo '<td class="fondo3">POR</td>';
                      echo '<td class="fondo3">LIBERAR</td>';
                      echo '<td class="fondo3"></td>';
                      echo '<td class="fondo3"></td>';
                      echo '<td class="fondo3"></td>';
                      echo '<td class="fondo3"></td>';
                      echo '<td class="fondo3"></td></tr>';
                    }else {
                      echo '<td></td>';
                      echo '<td>' . $row['num_cama'] . '</td>';
                      echo '<td></td>';
                      echo '<td></td>';
                      echo '<td></td>';
                      echo '<td></td>';
                      echo '<td></td>';
                      echo '<td></td>';
                      echo '<td></td>';
                      echo '</tr>';
                    }
                  }
                  ?>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </section>
  </div>
  <footer class="main-footer">
    <?php
    function calculaedad($fechanacimiento)
    {
      list($ano, $mes, $dia) = explode("-", $fechanacimiento);
      $ano_diferencia  = date("Y") - $ano;
      $mes_diferencia = date("m") - $mes;
      $dia_diferencia   = date("d") - $dia;
      if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
      return $ano_diferencia;
    }
    include("../../template/footer.php");
    ?>
  </footer>

  <script>
    document.oncontextmenu = function() {
      return false;
    }
  </script>
  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>

</html>
