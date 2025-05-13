<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 10) {
    include "../header_labo.php";

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_labo.php";
} else {
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


?>

<!DOCTYPE html>


    <head>

        <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


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
    </head>


    <div class="container-fluid">

        <?php
        if ($usuario1['id_rol'] == 4) {
            ?>

            <a type="submit" class="btn btn-primary btn-block" href="../../template/menu_sauxiliares.php">Regresar</a>

            <?php
        } else if ($usuario1['id_rol'] == 10) {

            ?>
            <a type="submit" class="btn btn-primary btn-block" href="../../template/menu_laboratorio.php">Regresar</a>

            <?php
        } else if ($usuario1['id_rol'] == 5) {

            ?>
            <a type="submit" class="btn btn-primary btn-block" href="../../template/menu_gerencia.php">Regresar</a>

            <?php
        }else

        ?>
        <div class="row">

            <div class="col  col-12">
                <h2>
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"
                                                                                                  id="side"></i></a>
                    <center><font id="letra"><i class="fa fa-plus-square"></i> Crear Perfiles de Laboratorio</font>
                </h2>
                </center>
                <hr>
            </div>
        </div>
    </div>


    <div class="content container-fluid">

        <!--------------------------
        | Your Page Content Here |
        -------------------------->


        <div class="container box">
            <div class="content">


                <?php

                include "../../conexionbd.php";


                // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

                //  $result = $conn->query($sql);

                //    $resultado2 = $conexion->query("SELECT id_serv, serv_cve, serv_costo, serv_umed,serv_activo FROM cat_servicios") or die($conexion->error);
                ?>


                <!--Fin de los filtros-->
                <?php
                if (isset($_GET['nom'])){


                ?>
                <form action="insertar_paquete_labo.php?nom=<?php echo $_GET['nom'] ?>" method="POST"
                      enctype="multipart/form-data">

                    <?php
                    }else{
                    ?>
                    <form action="insertar_paquete_labo.php" method="POST" enctype="multipart/form-data">

                        <?php
                        }
                        ?>


                        <input type="hidden" id="item-id">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="">Nombre del Perfil:</label>
                            <div class="col-sm-9">
                                <?php
                                if (isset($_GET['nom'])) {


                                    ?>
                                    <input value="<?php echo $_GET['nom'] ?>" disabled="true"
                                           style="text-transform:uppercase;" type="text" maxlength="50" name="nompaq"
                                           class="form-control" id="item-name" placeholder="Ingresa el nombre">

                                    <?php
                                } else {
                                    ?>
                                    <input style="text-transform:uppercase;" type="text" maxlength="50" name="nompaq"
                                           class="form-control" id="item-name" placeholder="Ingresa el nombre"
                                           required="" autofocus="">


                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="">Estudio:</label>
                            <div class="col-sm-9">
                                <select class="selectpicker" data-live-search="true" name="serv" required>
                                    <?php
                                    $sql_serv = "SELECT * FROM cat_servicios where tipo =1 and serv_activo = 'SI'";
                                    $result_serv = $conexion->query($sql_serv);
                                    while ($row_serv = $result_serv->fetch_assoc()) {
                                        echo "<option value='" . $row_serv['id_serv'] . "'>" . $row_serv['serv_desc'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="">Cantidad:</label>
                            <div class="col-sm-9">
                                <input type="number" maxlength="50" name="cantidad" class="form-control" id="code"
                                       placeholder="Ingresa el cantidad" required="" autofocus="">
                            </div>
                        </div>
                        <center>
                            <div class="modal-footer">
                                <a  href="../../template/menu_laboratorio.php" type="submit" class="btn btn-danger">Salir</a>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Regresar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </center>
                    </form>
                </form>
            </div>
        </div>

    </div>
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