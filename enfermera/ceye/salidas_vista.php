<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 7) {
    include "../header_ceye.php";
} else if ($usuario['id_rol'] == 3) {
    include "../../enfermera/header_enfermera.php";
} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_ceye.php";
} else{
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>

<!DOCTYPE html>
<html>

<head>

  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
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


</head>

<body>

  <section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->




    <div class="container box">
      <div class="content">
          <br>
        <center>
          <h1>MATERIALES SURTIDOS DE QUIRÓFANO</h1>
        </center>

        <div class="form-group">
          <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
        </div>

        <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">

            <thead class="thead" style="background-color: #2b2d7f; color:white;">
              <tr>
                 <th><font color="white">Registró</th>
                <th><font color="white">Fecha solicitud</th>
                <th><font color="white">Cantidad solicitada</th>
                <th><font color="white">Confirmó</th>
                <th><font color="white">Fecha surtido</th>
                <th><font color="white">Medicamento</th>
                <th><font color="white">Cantidad surtida</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $id_atencion = $_GET['id_atencion'];
              $fecha = $_GET['fecha'];
              $resultado1 = $conexion->query("SELECT * from dat_ingreso di, paciente p where di.id_atencion=$id_atencion and di.Id_exp=p.Id_exp") or die($conexion->error);
              while ($row_pac = $resultado1->fetch_assoc()) {
                $paciente=$row_pac['nom_pac'] . " " . $row_pac['papell'] . " " . $row_pac['sapell'];
              }
             echo'<tr><h4><strong>PACIENTE: '.$paciente.'</strong></h4></tr>';
              $resultado2 = $conexion->query("SELECT s.*,di.id_atencion,di.Id_exp,p.* from sales_ceye s, dat_ingreso di, paciente p where s.paciente=$id_atencion and date(s.fecha_solicitud)='$fecha' and s.paciente=di.id_atencion and di.Id_exp=p.Id_exp ") or die($conexion->error);
              $no = 1;
              $total = 0;
              while ($row = $resultado2->fetch_assoc()) {
                $id_usua = $row['id_usua'];
                $sql4 = "SELECT papell,sapell FROM reg_usuarios where id_usua = $id_usua ";
                $result4 = $conexion->query($sql4);
                while ($row_usua = $result4->fetch_assoc()) {
                  $surte = $row_usua['papell'] . ' ' . $row_usua['sapell'];
                $date=date_create($row['fecha_solicitud'] );
                echo '<tr>'
                  . '<td bgcolor="red"><font color="white">' . $row['solicita']  . '</td>'
                  . '<td bgcolor="red"><font color="white">' . date_format($date,"d-m-Y H:i:s"). '</td>'
                  . '<td bgcolor="red"><font color="white">' . $row['surtido']  . '</td>'
                  . '<td bgcolor="green"><font color="white">' . $surte . '</td>'
                  . '<td bgcolor="green"><font color="white">' . $row['date_sold'] . '</td>'
                  . '<td bgcolor="blue"><font color="white">' . $row['generic_name'] .', '. $row['gram'] . '</td>'
                  . '<td bgcolor="blue"><font color="white">' . $row['qty'] . '</td>';
                echo '</tr>';
                $no++;
              }
              }
              ?>
            </tbody>
          </table>
        </div>
                <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">

            <thead class="thead" style="background-color: #2b2d7f; color:white;">
              <tr>
                <th><font color="white">No.</th>
                <th><font color="white">Surtió</th>
                <th><font color="white">Fecha</th>
                <th><font color="white">Equipo</th>
                  <th><font color="white">Tipo</th>
                <th><font color="white">Cantidad</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $id_atencion = $_GET['id_atencion'];
              $fecha = $_GET['fecha'];
              $resultado3 = $conexion->query("SELECT * FROM dat_ctapac where id_atencion = $id_atencion and date(cta_fec)='$fecha' and prod_serv = 'S' and insumo != 1 and insumo != 2 and insumo != 3 and insumo != 4 and insumo != 8") or die($conexion->error);
            
              while ($row3 = $resultado3->fetch_assoc()) {
                $flag = $row3['prod_serv'];
                $insumo = $row3['insumo'];
                $id_ctapac = $row3['id_ctapac'];
                $fecha = $row3['cta_fec'];
                $cantidad = $row3['cta_cant'];
                $id_usua = $row3['id_usua'];
                $sql4 = "SELECT id_usua, nombre, papell,sapell FROM reg_usuarios where id_usua = $id_usua ";
                $result4 = $conexion->query($sql4);
                while ($row_usua = $result4->fetch_assoc()) {
                  $surte = $row_usua['nombre'] . ' ' . $row_usua['papell'] . ' ' . $row_usua['sapell'];
               if ($flag == 'S') {
                  $resultado_serv = $conexion->query("SELECT * FROM cat_servicios where id_serv = $insumo ") or die($conexion->error);
                  while ($row_serv = $resultado_serv->fetch_assoc()) {
                    $precio = $row_serv['serv_costo'];
                    $descripcion = $row_serv['serv_desc'];
                    $umed = $row_serv['serv_umed'];
                  }
                } 
                echo '<tr>'
                  . '<td>' . $no . '</td>'
                  . '<td>' . $surte . '</td>'
                  . '<td>' . $fecha . '</td>'
                  . '<td> ' . $descripcion . '</td>'
                  . '<td> ' . 'EQUIPO' . '</td>'
                  . '<td>' . $cantidad . '</td>';
                $no++;
              }  }            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  </div>

  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>


  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>

</html>