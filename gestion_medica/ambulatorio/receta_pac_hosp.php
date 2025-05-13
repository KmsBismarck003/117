    <?php
    session_start();
    include "../../conexionbd.php";
    include "../header_medico.php";
   
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
              integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
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
              integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


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


        <title>Creación de Paciente</title>
        <link rel="shortcut icon" href="logp.png">


    </head>
        <div class="container">
            <div class="row">
                  <div class="col col-12">
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    <br>
                   <center>
                        
                        <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                                <tr><strong><center>PACIENTES REGISTRADOS</center></strong>
                        </div>
                        <hr>
                    </center>
                
                    
                    <h2>
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    </h2>


                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
                    </div><br>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead" style="background-color: seagreen">
                        <tr>
                            
                            <th scope="col"><font color="white">EXP.</th>
                            <th scope="col"><font color="white">NOMBRE</th>
                            <th scope="col"><font color="white">EDAD</th>
                            <th scope="col"><font color="white">FECHA DE NAC.</th>
                            <th scope="col"><font color="white">FECHA EGRESO.</th>
                            <th scope="col"> <font color="white">RECETA</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                         $resultado = $conexion->query("SELECT p.*, d.* from paciente p, dat_ingreso d WHERE d.Id_exp=p.Id_exp and d.cama=0 order by d.id_atencion DESC") or die($conexion->error);

                        while ($f = mysqli_fetch_array($resultado)) {

                            ?>

                            <tr>     
                                <td><strong><?php echo $f['Id_exp']; ?></strong></td>
                                <td><strong><?php echo $f['papell'].' '.$f['sapell'].' '.$f['nom_pac']; ?></strong></td>
                                <td><strong><?php echo $f['edad']; ?></strong></td>
                                <td><strong><?php $date = date_create($f[5]);echo date_format($date, "d/m/Y"); ?></strong></td> 
                                <td><strong><?php $date = date_create($f['fec_egreso']);echo date_format($date, "d/m/Y"); ?></strong></td>
                                <td><a href="nueva_receta_hosp.php?id_atencion=<?php echo $f['id_atencion']; ?>"><button type="button" class="btn btn-danger "><i class="fa fa-hand-o-up" aria-hidden="true"></i></button></a></td>  
                            </tr>
                            <?php
                        }

                        ?>
                        </tbody>
                    </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal Eliminar-->
        <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEliminarLabel">Eliminar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        ¿DESEA ELIMINAR EL REGISTRO?
                    </div>
                    <div class="modal-footer">
                       
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-danger eliminar" data-dismiss="modal">ELIMINAR</button>

                    </div>
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
