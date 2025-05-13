<?php
include "../../conexionbd.php"; //Incluimos la conexión a la base de datos
include("../header_administrador.php");
if (!isset($_GET['texto'])) { // si no existe un texto escrito por el metodo get te regresara a la página principal
    header("Location: registro_pac.php");
}
?>
<!DOCTYPE html>

    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
              integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
              crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
                integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
                crossorigin="anonymous"></script>
        <!--  Bootstrap  -->
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
              integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
              crossorigin="anonymous">

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
            $(document).ready(function () {
                $("#search").keyup(function () {
                    _this = this;
                    // Show only matching TR, hide rest of them
                    $.each($("#mytable tbody tr"), function () {
                        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                            $(this).hide();
                        else
                            $(this).show();
                    });
                });
            });
        </script>


        <title>Creación del Paciente </title>
        <link rel="shortcut icon" href="logp.png">
    </head>


    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col"><h2 class="h5"><font color="black">Resultados de búsqueda de Nombre del
                            paciente:</font><br> <font color="#407959"><?php echo $_GET['texto']; ?></font></h2>
                    <!-- Imprimos el texto que escribimos en el buscador--></div>
                </i>
                <div class="col">
                    <form action="./busqueda_pac.php" class="site-block-top-search" method="GET">

                    </form>
                </div>
            </div>

            <h2>

                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                              id="side"></i></a>
            </h2>
            <br>

            <?php
            //Hacemos la consulta a la base de datos y buscamos en cada registro de la base de datos un patron que sea similar a lo que estamos escribiendo el el buscador
            $resultado = $conexion->query("select paciente.*, estados.nombre, estado_nac.nom_est_nac, municipios.nombre_m
from paciente inner join estados 
on paciente.id_edo=estados.id_edo
inner join estado_nac on paciente.id_edo_nac=estado_nac.id_edo_nac
inner join municipios on paciente.id_mun=municipios.id_mun where
nom_pac like '%" . $_GET['texto'] . "%'
order by Id_exp DESC") or die($conexion->error);
            if (mysqli_num_rows($resultado) > 0) { // si encuentra resultados
                while ($fila = mysqli_fetch_array($resultado)) { // mientras encuentre coincidencias se podran imprimir los registros
                    ?>

                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search"
                               placeholder="Buscar...">
                    </div>

                    <div class="table-responsive">

                        <table class="table table-responsive table-hover">
                            <thead class="thead">
                            <tr>
                                <th scope="col">No. Expediente</th>
                                <th scope="col">Curp</th>
                                <th scope="col">Primer Apellido</th>
                                <th scope="col">Segundo Apellido</th>
                                <th scope="col">Nombre(s)</th>
                                <th scope="col">Fecha de Nacimiento</th>
                                <th scope="col">Estado de Nacimiento</th>
                                <th scope="col">Sexo</th>
                                <th scope="col">Tipo de sangre</th>
                                <th scope="col">Nacionalidad</th>
                                <th scope="col">Estado de Residencia</th>
                                <th scope="col">Municipio</th>
                                <th scope="col">Localidad</th>
                                <th scope="col">Direccion</th>
                                <th scope="col">Ocupacion</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Fecha</th>

                            </tr>

                            </thead>
                            <tbody>
                            <tr>
                                <td scope="row" id="letra" align="center"><a
                                            href="dat_ingreso.php?Id_exp=<?php echo $fila['Id_exp']; ?>">
                                        <strong><?php echo $fila['Id_exp']; ?></strong></td>
                                <td><strong><?php echo $fila['curp']; ?></strong></td>
                                <td><strong><?php echo $fila['papell']; ?></strong></td>
                                <td><strong><?php echo $fila['sapell']; ?></strong></td>
                                <td><strong><?php echo $fila['nom_pac']; ?></strong></td>
                                <td><strong><?php echo $fila['fecnac']; ?></strong></td>
                                <td><strong>
                                        <center><?php echo $fila['id_edo_nac']; ?>
                                            <br><?php echo $fila['nom_est_nac']; ?></center>
                                    </strong></td>
                                <td><strong>
                                        <center><?php echo $fila['sexo']; ?></center>
                                    </strong></td>
                                <td><strong>
                                        <center><?php echo $fila['tip_san']; ?></center>
                                    </strong></td>
                                <td><strong>
                                        <center><?php echo $fila['nac']; ?></strong></td>
                                <td><strong>
                                        <center><?php echo $fila['id_edo']; ?><br><?php echo $fila['nombre']; ?>
                                        </center>
                                    </strong></td>
                                <td><strong>
                                        <center><?php echo $fila['id_mun']; ?><br><?php echo $fila['nombre_m']; ?>
                                        </center>
                                    </strong></td>
                                <td><strong>
                                        <center><?php echo $fila['loc']; ?></center>
                                    </strong></td>
                                <td><strong><?php echo $fila['dir']; ?></strong></td>
                                <td><strong><?php echo $fila['ocup']; ?></strong></td>
                                <td><strong><?php echo $fila['tel']; ?></strong></td>
                                <td><strong><?php echo $fila['fecha']; ?></strong></td>


                            </tbody>
                        </table>
                    </div>


                <?php }
            } else { //si no hay coincidencias entonces se imprime el siguiente mensaje
                echo '<h2>No se encontraron resultados</h2>';
            } ?>
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