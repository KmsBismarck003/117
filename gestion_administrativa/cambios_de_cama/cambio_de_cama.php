<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../index.php");
}

include("../header_administrador.php");
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
    td.fondo {
      background-color: red !important;
    }
    td.cuenta{
      background-color: yellow; !important;
    }
  </style>
  <style>
    td.fondo2 {
      background-color: green !important;
    }
  </style>

</head>

<body>
  <section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->
<div class="container box">
  <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                     <tr><center><strong>CENSO DE PACIENTES</strong></center>

  </div>
</div>

    <div class="container box">
      <div class="container-fluid">
        <center><strong>HOSPITALIZACIÓN</strong></center>

        <div class="row">
          <br />

          <div class="col-md-4">
            <input type="text" class="form-control pull-right" id="search" placeholder="Buscar">
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mytable">
              <thead class="thead">
                <tr>
                  <center>
                    <th scope="col">Cambio</th>
                  </center>
                  <center>
                    <th scope="col">Habitación</th>
                  </center>
                  <th scope="col">
                    <center>Fecha ingreso</center>
                  </th>
                  <th scope="col">
                    <center>Paciente</center>
                  </th>
                  <th scope="col">
                    <center>Edad</center>
                  </th>
                  <th scope="col">
                    <center>Diagnóstico</center>
                  </th>
                  <th scope="col">
                    <center>Expediente</center>
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
                    $usuario = $_SESSION['login'];
                    $id_usua= $usuario['id_usua'];
                    $rol= $usuario['id_rol'];
                    $sql_tabla = "SELECT p.fecnac,p.Id_exp, p.papell, p.sapell,p.nom_pac, df.aseg, di.fecha, di.motivo_atn, di.alta_med,ru.pre, ru.nombre as nom_doc from dat_ingreso di, dat_financieros df, paciente p, reg_usuarios ru WHERE p.Id_exp = di.Id_exp and di.id_atencion=df.id_atencion and di.id_usua = ru.id_usua and di.id_atencion = $id_at_cam LIMIT 1";
                    $result_tabla = $conexion->query($sql_tabla);
                    $rowcount = mysqli_num_rows($result_tabla);
                    if ($rowcount != 0) {
                      while ($row_tabla = $result_tabla->fetch_assoc()) {
                        $alta=$row_tabla['alta_med'];
                        if($alta=='SI'){
                          echo '<td></td>';
                         echo '<td class="fondo2"> <font color="white" size="2">' . $row['num_cama'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['fecha'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['nom_pac'] . ' ' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . calculaedad($row_tabla['fecnac']) .'</font></font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['motivo_atn'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['Id_exp'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['alta_med'] . '</font></td>';
                        echo '<tr>';
                        }else{
                          echo '<td class="fondo"> <a type="submit" class="btn btn-success btn-sm" href="cambio.php?id_cama='.$row['num_cama'] .'&id_atencion='.$row['id_atencion'].'&tipo='.$row['tipo'].'&hab='.$row['habitacion'].'"><img src="https://img.icons8.com/office/16/000000/hospital-bed.png"/></a></td>';
                         echo '<td class="fondo"><font color="white" size="2">' . $row['num_cama'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['fecha'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['nom_pac'] . ' ' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . calculaedad($row_tabla['fecnac']) . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['motivo_atn'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['Id_exp'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['alta_med'] . '</font></td>';
                        echo '<tr>';
                        }
                      }
                    } else {
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
    <div class="container box">
      <div class="container-fluid">
        <center><strong>TERAPIA INTENSIVA </strong></center>

        <div class="row">
          <br />
          <div class="col-md-4">
            <input type="text" class="form-control pull-right" id="search" placeholder="Buscar">
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mytable">
              <thead class="thead">
                <tr>
                  <center>
                    <th scope="col">Cambio</th>
                  </center>
                  <center>
                    <th scope="col">Habitación</th>
                  </center>
                  <th scope="col">
                    <center>Fecha ingreso</center>
                  </th>
                  <th scope="col">
                    <center>Paciente</center>
                  </th>
                  <th scope="col">
                    <center>Edad</center>
                  </th>
                  <th scope="col">
                    <center>Diagnóstico</center>
                  </th>
                  <th scope="col">
                    <center>Expediente</center>
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
                  $sql = "SELECT * from cat_camas where TIPO ='TERAPIA' ORDER BY num_cama ASC ";
                  $result = $conexion->query($sql);
                  while ($row = $result->fetch_assoc()) {
                    $id_at_cam = $row['id_atencion'];
                    $usuario = $_SESSION['login'];
                    $id_usua= $usuario['id_usua'];
                    $rol= $usuario['id_rol'];
                    $sql_tabla = "SELECT p.fecnac,p.Id_exp, p.papell, p.sapell,p.nom_pac, df.aseg, di.fecha, di.motivo_atn, di.alta_med,ru.pre, ru.nombre as nom_doc from dat_ingreso di, dat_financieros df, paciente p, reg_usuarios ru WHERE p.Id_exp = di.Id_exp and di.id_atencion=df.id_atencion and di.id_usua = ru.id_usua and di.id_atencion = $id_at_cam LIMIT 1";
                    $result_tabla = $conexion->query($sql_tabla);
                    $rowcount = mysqli_num_rows($result_tabla);
                    if ($rowcount != 0) {
                      while ($row_tabla = $result_tabla->fetch_assoc()) {
                        $alta=$row_tabla['alta_med'];
                        if($alta=='SI'){
                         echo '<td></td>';
                         echo '<td class="fondo2"> <font color="white" size="2">' . $row['num_cama'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['fecha'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['nom_pac'] . ' ' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . calculaedad($row_tabla['fecnac']) .'</font></font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['motivo_atn'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['Id_exp'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['alta_med'] . '</font></td>';
                        echo '<tr>';
                        }else{
                          echo '<td class="fondo"> <a type="submit" class="btn btn-success btn-sm" href="cambio.php?id_cama='.$row['num_cama'] .'&id_atencion='.$row['id_atencion'].'&tipo='.$row['tipo'].'&hab='.$row['habitacion'].'"><img src="https://img.icons8.com/office/16/000000/hospital-bed.png"/></a></td>';
                         echo '<td class="fondo"><font color="white" size="2">' . $row['num_cama'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['fecha'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['nom_pac'] . ' ' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . calculaedad($row_tabla['fecnac']) . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['motivo_atn'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['Id_exp'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['alta_med'] . '</font></td>';
                        echo '<tr>';
                        }
                      }
                    } else {
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
       <!-- <div class="container box">
      <div class="container-fluid">
        <center><strong>UCIN </strong></center>

        <div class="row">
          <br />
          <div class="col-md-4">
            <input type="text" class="form-control pull-right" id="search" placeholder="Buscar">
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mytable">
              <thead class="thead">
                <tr>
                  <center>
                    <th scope="col">CAMBIO</th>
                  </center>
                  <center>
                    <th scope="col">HAB.</th>
                  </center>
                  <th scope="col">
                    <center>FECHA DE INGRESO</center>
                  </th>
                  <th scope="col">
                    <center>PACIENTE</center>
                  </th>
                  <th scope="col">
                    <center>EDAD</center>
                  </th>
                  <th scope="col">
                    <center>DIAGNÓSTICO</center>
                  </th>
                  <th scope="col">
                    <center>EXP.</center>
                  </th>
                  <th scope="col">
                    <center>MÉDICO TRATANTE</center>
                  </th>
                  <th scope="col">
                    <center>ALTA MÉDICA</center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php
                  $sql = "SELECT * from cat_camas where TIPO ='UCIN' ORDER BY num_cama ASC ";
                  $result = $conexion->query($sql);
                  while ($row = $result->fetch_assoc()) {
                    $id_at_cam = $row['id_atencion'];
                    $usuario = $_SESSION['login'];
                    $id_usua= $usuario['id_usua'];
                    $rol= $usuario['id_rol'];
                    $sql_tabla = "SELECT p.fecnac,p.Id_exp, p.papell, p.sapell,p.nom_pac, df.aseg, di.fecha, di.motivo_atn, di.alta_med,ru.pre, ru.nombre as nom_doc from dat_ingreso di, dat_financieros df, paciente p, reg_usuarios ru WHERE p.Id_exp = di.Id_exp and di.id_atencion=df.id_atencion and di.id_usua = ru.id_usua and di.id_atencion = $id_at_cam LIMIT 1";
                    $result_tabla = $conexion->query($sql_tabla);
                    $rowcount = mysqli_num_rows($result_tabla);
                    if ($rowcount != 0) {
                      while ($row_tabla = $result_tabla->fetch_assoc()) {
                        $alta=$row_tabla['alta_med'];
                        if($alta=='SI'){
                         echo '<td></td>';
                         echo '<td class="fondo2"> <font color="white" size="2">' . $row['num_cama'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['fecha'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['nom_pac'] . ' ' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . calculaedad($row_tabla['fecnac']) .'</font></font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['motivo_atn'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['Id_exp'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['alta_med'] . '</font></td>';
                        echo '<tr>';
                        }else{
                          echo '<td class="fondo"> <a type="submit" class="btn btn-success btn-sm" href="cambio.php?id_cama='.$row['num_cama'] .'&id_atencion='.$row['id_atencion'].'&tipo='.$row['tipo'].'&hab='.$row['habitacion'].'"><img src="https://img.icons8.com/office/16/000000/hospital-bed.png"/></a></td>';
                         echo '<td class="fondo"><font color="white" size="2">' . $row['num_cama'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['fecha'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['nom_pac'] . ' ' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . calculaedad($row_tabla['fecnac']) . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['motivo_atn'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['Id_exp'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['alta_med'] . '</font></td>';
                        echo '<tr>';
                        }
                      }
                    } else {
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
    </div>-->
    <div class="container box">
      <div class="container-fluid">
        <center><strong>URGENCIAS</strong></center>

        <div class="row">
          <br />

          <div class="col-md-4">
            <input type="text" class="form-control pull-right" id="search" placeholder="Buscar">
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mytable">
              <thead class="thead">
                 <tr>
                  <center>
                    <th scope="col">Cambio</th>
                  </center>
                  <center>
                    <th scope="col">Habitación</th>
                  </center>
                  <th scope="col">
                    <center>Fecha ingreso</center>
                  </th>
                  <th scope="col">
                    <center>Paciente</center>
                  </th>
                  <th scope="col">
                    <center>Edad</center>
                  </th>
                  <th scope="col">
                    <center>Diagnóstico</center>
                  </th>
                  <th scope="col">
                    <center>Expediente</center>
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
                  $sql = "SELECT * from cat_camas where TIPO ='URGENCIAS' ORDER BY num_cama ASC ";
                  $result = $conexion->query($sql);
                  while ($row = $result->fetch_assoc()) {
                    $id_at_cam = $row['id_atencion'];
                    $usuario = $_SESSION['login'];
                    $id_usua= $usuario['id_usua'];
                    $rol= $usuario['id_rol'];
                    $sql_tabla = "SELECT p.fecnac,p.Id_exp, p.papell, p.sapell,p.nom_pac, df.aseg, di.fecha, di.motivo_atn, di.alta_med,ru.pre, ru.nombre as nom_doc from dat_ingreso di, dat_financieros df, paciente p, reg_usuarios ru WHERE p.Id_exp = di.Id_exp and di.id_atencion=df.id_atencion and di.id_usua = ru.id_usua and di.id_atencion = $id_at_cam LIMIT 1";
                    $result_tabla = $conexion->query($sql_tabla);
                    $rowcount = mysqli_num_rows($result_tabla);
                    if ($rowcount != 0) {
                      while ($row_tabla = $result_tabla->fetch_assoc()) {
                        $alta=$row_tabla['alta_med'];
                        if($alta=='SI'){
                         echo '<td></td>';
                         echo '<td class="fondo2"> <font color="white" size="2">' . $row['num_cama'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['fecha'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['nom_pac'] . ' ' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . calculaedad($row_tabla['fecnac']) .'</font></font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['motivo_atn'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['Id_exp'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</font></td>';
                        echo '<td class="fondo2"><font color="white" size="2">' . $row_tabla['alta_med'] . '</font></td>';
                        echo '<tr>';
                        }else{
                          echo '<td class="fondo"> <a type="submit" class="btn btn-success btn-sm" href="cambio.php?id_cama='.$row['num_cama'] .'&id_atencion='.$row['id_atencion'].'&tipo='.$row['tipo'].'&hab='.$row['habitacion'].'"><img src="https://img.icons8.com/office/16/000000/hospital-bed.png"/></a></td>';
                         echo '<td class="fondo"><font color="white" size="2">' . $row['num_cama'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['fecha'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['nom_pac'] . ' ' . $row_tabla['papell'] . ' ' . $row_tabla['sapell'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . calculaedad($row_tabla['fecnac']) . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['motivo_atn'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['Id_exp'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['pre'] . ' ' . $row_tabla['nom_doc'] . '</font></td>';
                        echo '<td class="fondo"><font color="white" size="2">' . $row_tabla['alta_med'] . '</font></td>';
                        echo '<tr>';
                        }
                      }
                    } else {
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