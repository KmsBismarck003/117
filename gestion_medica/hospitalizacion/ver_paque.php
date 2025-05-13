<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");
 $nom=$_GET['nom'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>


    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css"
          type="text/css"/>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>


    <title>DATOS NURGEN </title>
</head>
<body>
    <div class="thead" style="background-color: #0c675e; color: white; font-size: 24px;">
  <center><strong>PAQUETE: <?php echo  $nom ?></strong></center><p>
</div>
  <div class="container box">
            <div class="table-responsive">
                <!--<table id="myTable" class="table table-striped table-hover">-->

                <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #0c675e">
                    <tr>
                        <th><font color="white">CLAVE</font></th>
                        <th><font color="white">ESTUDIO</font></th>
                        <th><font color="white">CANTIDAD</font></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $nom=$_GET['nom'];
                    $sql = 'SELECT serv_cve, serv_desc , cantidad FROM paquetes_labo p, cat_servicios m where m.id_serv=p.estudio_id and p.nombre = "'.$nom.'"';

                     $result = $conexion->query($sql);
                 //   $resultado2 = $conexion->query('SELECT  material_nombre, cantidad FROM paquetes_ceye p, material_ceye m where m.material_id=p.material_id and p.nombre = "$nombre_paq"') or die($conexion->error);
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {

                        echo '<tr>'
                            . '<td>' . $row['serv_cve'] . '</td>'
                            . '<td>' . $row['serv_desc'] . '</td>'
                        . '<td>' . $row['cantidad'] . '</td>';

                         echo '</tr>';
                        $no++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
</div>

</div>
<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>

<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

<script>
    document.oncontextmenu = function () {
        return false;
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>


</body>
</html>