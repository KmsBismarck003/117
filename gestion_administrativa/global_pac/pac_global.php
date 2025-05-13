    <?php
    session_start();
    include "../../conexionbd.php";
    include "../header_administrador.php";
   
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <script src="https://your-site-or-cdn.com/fontawesome/v6.1.1/js/all.js" data-auto-replace-svg="nest"></script>
<meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
             <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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

    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>

    <link rel="stylesheet" href="css_busc/estilos2.css">
    <script src="js_busc/jquery.js"></script>
    <script src="js_busc/jquery.dataTables.min.js"></script>

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
                 <div class="col col-5">
                
                    <a href="../gestion_pacientes/registro_pac.php" class="btn btn-danger btn-sm">Regresar</a>
                   
             
                </div>
                <div class="form-group"> 
                
                    <a href="excelpacientes.php"><button type="button" class="btn btn-warning btn-sm">
                    <img src="https://img.icons8.com/color/48/000000/ms-excel.png" width="42"/><strong>Exportar a excel</strong></button></a>
             
                </div>
                  <div class="col col-12">
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    <br>
                   <center>
                        
                        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                                <tr><strong><center>PACIENTES REGISTRADOS</center></strong>
                        </div>
                        <hr>
                    </center>
<?php
$usuario = $_SESSION['hospital'];
?>


                    
                    <h2>
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                    </h2>


                    <div class="form-group">
                        <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
                    </div><br>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead" style="background-color: #2b2d7f;color:white;">
                        <tr>
                            <th scope="col"><font color="white">Ver Datos</th>
                            <th scope="col"><font color="white">Notas médicas</th>
                            <th scope="col"><font color="white">Exp.</th>
                            <th scope="col"><font color="white">No. Atención</th>
                            <th scope="col"><font color="white">Fec Ingreso</th>
                            <th scope="col"><font color="white">Fec Egreso</th>
                            <th scope="col"><font color="white">Nombre del paciente</th>
                            <th scope="col"><font color="white">Edad</th>
                            <th scope="col"><font color="white">Fec nacimiento</th>
                            <th scope="col"><font color="white">Área</th>
                            <th scope="col"><font color="white">Aseguradora</th>
                           
                            
                          
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                         $resultado = $conexion->query("SELECT p.*, d.* from paciente p, dat_ingreso d WHERE d.Id_exp=p.Id_exp order by p.Id_exp DESC") or die($conexion->error);

                        while ($f = mysqli_fetch_array($resultado)) {
                            $fec_ing = date_create($f['fecha']);
                            if ($f['fec_egreso']<>'NUll'){
                                $fec_egr = date_create($f['fec_egreso']);
                                $fec_egreso = date_format($fec_egr,'d/m/Y H:i a');
                            }
                            else 
                                $fec_egreso = 'Null';
                        ?>
                        
                        
                        <tr>
                                <td ><center><a href="vista_pac.php?id_atencion=<?php echo $f['id_atencion']; ?>&id_exp=<?php echo $f['Id_exp'] ?>"><button type="button" class="btn btn-block"><img src="https://img.icons8.com/fluency/48/000000/documents.png"/></button></a></center></td> 
                                
                                <td> <center>
                                    <a type="submit" class="btn btn-danger btn-sm"
                                    href="consent_lista.php?id_atencion=<?php echo $f['id_atencion']; ?>&id_exp=<?php echo $f['Id_exp'] ?>"
                                    target=""><span class="fa fa-file-pdf-o"
                                    style="font-size:20px"></span></a>
                                </center></td>
                               
                                 
                                <td><strong><?php echo $f['Id_exp']; ?></strong></td>
                                <td><strong><?php echo $f['id_atencion']; ?></strong></td>
                                <td><strong><?php echo date_format($fec_ing,'d/m/Y H:i a'); ?></strong></td>
                                <td><strong><?php echo $fec_egreso?></strong></td>
                                <td><strong><?php echo $f['papell'].' '.$f['sapell'].' '.$f['nom_pac']; ?></strong></td>
                                <td><strong><?php echo $f['edad']; ?></strong></td>
                                <td><strong><?php $date = date_create($f[5]); echo date_format($date, "d/m/Y"); ?></strong></td>
                                <td><strong><?php echo $f['area']; ?></strong></td>
                                <td><strong><?php echo $f['aseg']; ?></strong></td>
                                 
                            </tr>
                        <?php }
                        
                        ?>
                        </tbody>
                    </table>
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
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>

<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
<script>
    document.oncontextmenu = function () {
        return false;
    }
</script>
<script src="js_busc/search.js"></script>
    </body>
    </html>
