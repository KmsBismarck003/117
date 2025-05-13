<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../index.php");
}

include("../header_configuracion.php");
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

</head>

<body>
  <section class="content container-fluid">

    <!--------------------------
    | Your Page Content Here |
    -------------------------->


    <div class="container box">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-10">
            <br />

            
            <a href="alta_cama.php" class="btn btn-md btn-md btn-block btn-primary">Agregar habitación</a>

            <div class="form-group"> <br>
              <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="mytable">
               
                  <thead class="thead" style="background-color: #2b2d7f;color:white;">
                  <tr>
                    <center>
                      <th scope="col">Habitación</th>
                    </center>
                    <th scope="col">
                      <center>Estatus</center>
                    </th>
                    <th scope="col">
                      <center>Área</center>
                    </th>
                    <th scope="col">
                      <center>Piso</center>
                    </th>
                    <th scope="col">
                      <center>Sección</center>
                    </th>
                    <th scope="col">
                      <center>Editar</center>
                    </th>
                     <th scope="col">
                      <center>Eliminar</center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php
                    $sql = "SELECT id,estatus,tipo, num_cama,id_atencion,piso,seccion from cat_camas ORDER BY num_cama ASC ";
                    $result = $conexion->query($sql);
                    while ($row = $result->fetch_assoc()) {
                      if($row['id_atencion'] == 0 && $row['estatus'] == 'LIBRE'){
                        $estatus = $row['estatus'];
                      echo '<td>' . $row['num_cama'] . '</td><td>' . $estatus . '</td>';
                      echo '<td>' . $row['tipo'] . '</td>';
                      echo '<td>' . $row['piso'] . '</td>';
                      echo '<td>' . $row['seccion'] . '</td>';
                      echo '<td> <a type="submit" class="btn btn-success btn-sm" href="edita_cama.php?id=' . $row['id'] . '"><span class = "fa fa-edit"></span></a></td>';
                      echo '<td> <a type="submit" class="btn btn-danger btn-sm" href="elimina_cama.php?id=' . $row['id'] . '"><span class = "fa fa-trash-alt"></span></a></td></tr>';
                      }elseif($row['id_atencion'] != 0 && $row['estatus'] == 'OCUPADA'){
                        $estatus = $row['estatus'];
                      echo '<td>' . $row['num_cama'] . '</td><td>' . $estatus . '</td>';
                      echo '<td>' . $row['tipo'] . '</td>';
                      echo '<td>' . $row['piso'] . '</td>';
                      echo '<td>' . $row['seccion'] . '</td>';
                      echo '<td><font color="red">OCUPADA</font></td>';
                      echo '<td></td></tr>';
                      }elseif($row['estatus'] == 'MANTENIMIENTO'){
                        $estatus = "NO DISPONIBLE";
                      echo '<td bgcolor="yellow">' . $row['num_cama'] . '</td><td bgcolor="yellow">' . $estatus . '</td>';
                      echo '<td bgcolor="yellow">' . $row['tipo'] . '</td>';
                      echo '<td bgcolor="yellow">' . $row['piso'] . '</td>';
                      echo '<td bgcolor="yellow">' . $row['seccion'] . '</td>';
                      echo '<td bgcolor="yellow"> <a type="submit" class="btn btn-success btn-sm" href="edita_cama.php?id=' . $row['id'] . '"><span class = "fa fa-edit"></span></a></td>';
                      echo '<td bgcolor="yellow" ><font color="red"><strong>NO DISPONIBLE </strong></font></td>';
                      echo '<td bgcolor="yellow"></td></tr>';
                      }else{
                        $estatus = "POR LIBERAR";
                      echo '<td bgcolor="orange">' . $row['num_cama'] . '</td><td bgcolor="orange">' . $estatus . '</td>';
                      echo '<td bgcolor="orange">' . $row['tipo'] . '</td>';
                      echo '<td bgcolor="orange">' . $row['piso'] . '</td>';
                      echo '<td bgcolor="orange">' . $row['seccion'] . '</td>';
                      echo '<td bgcolor="orange"> <a type="submit" class="btn btn-success btn-sm" href="edita_cama.php?id=' . $row['id'] . '"><span class = "fa fa-edit"></span></a></td>';
                      echo '<td bgcolor="orange" ><font color="brown"><strong>POR LIBERAR </strong></font></td>';
                      echo '<td bgcolor="orange"></td></tr>';
                      }
                    }
                    ?>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-2"></div>
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

  <script>
    document.oncontextmenu = function() {
      return false;
    }
  </script>
</body>

</html>