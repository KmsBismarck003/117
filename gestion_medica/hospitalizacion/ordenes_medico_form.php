<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");


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


<div class="col-sm-12">
    <div class="container">
        <div class="row">

            <div class="col">
                 <div class="thead" style="background-color: #0c675e; color: white; font-size: 24px;">
  <center><strong>ÓRDENES DEL MÉDICO (INDICACIONES)</strong></center><p>
</div>
             
                <hr>
                <?php

                include "../../conexionbd.php";

                $resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);

                ?>
                <?php
                while ($f1 = mysqli_fetch_array($resultado1)) {

                    ?>

                    <div class="row">


                        <div class="col-sm"> FECHA:
                            <?php
                            
                            $fecha_actual = date("d-m-Y");
                            ?>
                            <strong><?= $fecha_actual ?></strong>

                        </div>

                        <div class="col-sm">
                            FECHA DE NACIMIENTO:
                            <td><strong><?php echo $f1['fecnac']; ?></strong></td>
                        </div>


                    </div>


                    <!--<div class="row">
    <div class="col-sm-5">
        NO.EXPEDIENTE: <td><strong><?php //echo $f1['Id_exp']; ?></strong></td>
    </div>
    <div class="col-sm">
     ADMISIÓN: <td><strong><?php //echo $f1['id_atencion']; ?></strong></td>
    </div>

  </div>-->


                    <div class="row">
                        <div class="col-sm">
                            PACIENTE:
                            <td><strong><?php echo $f1['papell']; ?></strong></td>
                            <td><strong><?php echo $f1['sapell']; ?></strong></td>
                            <td><strong><?php echo $f1['nom_pac']; ?></strong></td>
                        </div>
                        <div class="col-sm">
                            EDAD:
                            <td><strong><?php echo $f1['edad']; ?></strong></td>
                        </div>

                        <!--<div class="col-sm">
       HABITACIÓN:
                            <td><strong><?php //echo $f1['edad']; ?></strong></td>
    </div>-->
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            DIAGNÓSTICO:
                            <td><strong><?php echo $f1['motivo_atn']; ?></strong></td>
                        </div>
                         <div class="col-sm">
                            TIPO DE SANGRE:
                            <td><strong><?php echo $f1['tip_san']; ?></strong></td>
                        </div>

                    </div>

                    <hr>
                    <?php
                }
                ?>

            </div>
            <div class="col-3">
                <?php
                
                $fecha_actual = date("Y-m-d H:i:s");
                ?>
                
                <div class="form-group">
                    <label for="fecha">FECHA Y HORA ACTUAL:</label>
                    <input type="datetime" name="fec_hc" value="<?= $fecha_actual ?>" class="form-control" disabled>
                </div>
                
            </div>
        </div>

 
 
        <form action="insertar_ordenes_medico.php" method="POST">
<?php 

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_sig DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
      $atencion=$f5['id_sig'];
    }
    ?>
    <?php
if (isset($atencion)) {
                        ?>
<?php 

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=" . $_SESSION ['hospital'].".ORDER by id_sig DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
     
    
    ?>
    <div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
                <div class="container"> 
  <div class="row">
    
      
    
    <div class="col-sm-2"><br><center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" value="<?php echo $f5['p_sistol'];?>" disabled></div> /
  <div class="col"><input type="text" class="form-control" value="<?php echo $f5['p_diastol'];?>" disabled></div>
 
</div>
    </div>
    <div class="col-sm-2">
      FRECUENCIA CARDIACA:<input type="text" class="form-control" value="<?php echo $f5['fcard'];?>" disabled>
    </div>
    <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" class="form-control" value="<?php echo $f5['fresp'];?>" disabled>
    </div>
    <div class="col-sm-2">
     <br>TEMPERATURA:<input type="text" class="form-control" value="<?php echo $f5['temper'];?>" disabled>
    </div>
    <div class="col-sm-2"><br>
     SATURACIÓN OXÍGENO:<input type="text"  class="form-control" value="<?php echo $f5['satoxi'];?>" disabled>
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" class="form-control" value="<?php echo $f5['peso'];?>" disabled>
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" class="form-control" value="<?php echo $f5['talla'];?>" disabled>
    </div>
  </div>
</div>
<?php }
?>
<?php 
}else{
                        
  ?>
   <div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
                <div class="container"> 
  <div class="row">
    <div class="col-sm-2"><br><center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" name="p_sistol" ></div> /
  <div class="col"><input type="text" class="form-control" name="p_diastol"></div>
 
</div>
    </div>
    <div class="col-sm-2">
      FRECUENCIA CARDIACA:<input type="text" class="form-control" name="fcard">
    </div>
    <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" class="form-control" name="fresp">
    </div>
    <div class="col-sm-2">
     <br>TEMPERATURA:<input type="text" class="form-control"  name="temper">
    </div>
    <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="text"  class="form-control" name="satoxi">
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" class="form-control"  name="peso">
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" class="form-control" name="talla" >
    </div>
  </div>
</div>

<?php } ?>
<hr>
<!--<?php
                            //
                            //$fecha_actual2 = date("d-m-Y H:i:s");
                            ?>

            <div class="row">
                <div class="col-sm-3">
                    FECHA Y HORA: <input class="form-control" disabled value="<?php// $fecha_actual2 ?>*/" >
                </div>
                <div class="col-sm-3">
                    HORA: <input type="time" name="hora_ord" class="form-control">
                </div>
            </div>-->
            <div class="row">
 <div class="col-sm-3">
    <a href="ordenes_medico.php"><button type="button" class="btn btn-primary">REGISTRO DE INDICACIONES</button></a>
  </div>
 <?php
 $usuario = $_SESSION['login'];
    if ($usuario['id_rol'] == 12) {
            ?>
 <div class="col-sm">
    <a href="ordenes_medico.php"><button type="button" class="btn btn-primary">REGISTRO DE INDICACIONES VERBALES</button></a>
  </div>
            <?php
            } 
            ?>
        </div>
        
          <div class="col col-12">
          
            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
            </div>
               <?php

include "../../conexionbd.php";
$id_atencion=$_SESSION['hospital'];
$resultado = $conexion->query("SELECT * from dat_ordenes_med WHERE id_atencion=$id_atencion ORDER BY id_ord_med DESC") or die($conexion->error);
$usuario = $_SESSION['login'];
?>
            <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-success">
              
                    <th scope="col">PDF</th>
                    <th scope="col">DATOS</th>
                    <th scope="col">FOLIO</th>
                    <th scope="col">FECHA</th>
                    <th scope="col">HORA</th>
                    <th scope="col">TIPO</th>
                </tr>
                </thead>
                <tbody>

                <?php
                while($f = mysqli_fetch_array($resultado)){
                     if($f['visto']== "NO" && $f['tipo']== "MEDICO"){
                    ?>
                    
                    <tr>
                        <td class="fondo"><a href="../../gestion_medica/pdf/pdf_ordenes_medico.php?id_ord=<?php echo $f['id_ord_med'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua'] ?>" target="_blank"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></td>
                        <td class="fondo"><a href="ordenes_vista.php?id_ord=<?php echo $f['id_ord_med'];?>"><button type="button" class="btn btn-danger"> <i class="fa fa-heartbeat" aria-hidden="true"></i> </button></td>
                        <td class="fondo"><strong><?php echo $f['id_atencion'];?></strong></td>
                        <td class="fondo"><strong><?php $date=date_create($f['fecha_ord']); echo date_format($date,"d/m/Y");?></strong></td>
                        <td class="fondo"><strong><?php echo $f['hora_ord'];?></strong></td>
                        <td class="fondo"><strong>MEDICO</strong></td>
                    </tr>
                    <?php
                }elseif ($f['visto']== "NO" && $f['tipo']== "VERB") {
                 
                ?>
                <tr>
                        <td class="fondo"><a href="../pdf/pdf_ordmed_verb.php?id_ord=<?php echo $f['id_ord_med'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua'] ?>" target="_blank"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></td>
                        <td class="fondo"><a href="ordenes_vista.php?id_ord=<?php echo $f['id_ord_med'];?>"><button type="button" class="btn btn-danger"> <i class="fa fa-heartbeat" aria-hidden="true"></i> </button></td>
                        <td class="fondo"><strong><?php echo $f['id_atencion'];?></strong></td>
                        <td class="fondo"><strong><?php $date=date_create($f['fecha_ord']); echo date_format($date,"d/m/Y");?></strong></td>
                        <td class="fondo"><strong><?php echo $f['hora_ord'];?></strong></td>
                        <td class="fondo"><strong>VERBALES</strong></td>
                    </tr>
                  <?php }elseif ($f['visto']== "SI" && $f['tipo']== "MEDICO") {
                     ?>
                    <tr>
                        <td><a href="../pdf/pdf_ordenes_medico.php?id_ord=<?php echo $f['id_ord_med'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua'] ?>" target="_blank"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></a></td>
                        
                        <td ><a href="ordenes_vista.php?id_ord=<?php echo $f['id_ord_med'];?>"><button type="button" class="btn btn-danger"> <i class="fa fa-heartbeat" aria-hidden="true"></i> </button></a></td>
                        <td ><strong><?php echo $f['id_atencion'];?></strong></td>
                        <td ><strong><?php $date=date_create($f['fecha_ord']); echo date_format($date,"d/m/Y");?></strong></td>
                        <td ><strong><?php echo $f['hora_ord'];?></strong></td>
                        <td><strong>MEDICO</strong></td>
                    </tr>
                  <?php }elseif ($f['visto']== "SI" && $f['tipo']== "VERB") {?>
                    <tr>
                        <td><a href="../pdf/pdf_ordmed_verb.php?id_ord=<?php echo $f['id_ord_med'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua'] ?>" target="_blank"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></a></td>
                        
                        <td ><a href="ordenes_medico.php?id_ord=<?php echo $f['id_ord_med'];?>"><button type="button" class="btn btn-danger"> <i class="fa fa-heartbeat" aria-hidden="true"></i> </button></a></td>
                        <td ><strong><?php echo $f['id_atencion'];?></strong></td>
                        <td ><strong><?php $date=date_create($f['fecha_ord']); echo date_format($date,"d/m/Y");?></strong></td>
                        <td ><strong><?php echo $f['hora_ord'];?></strong></td>
                        <td><strong>VERBALES</strong></td>
                    </tr>

                  <?php }
                  } ?>
                </tbody>
              
            </table>
            </div>
      <hr>
<br><br>
<div class="form-group col-12">
  <center>
<button type="button" class="btn btn-danger" onclick="history.back()">REGRESAR...</button></center>
</div><br>
      
</div>

            <br>
            <br>
        </form>


        <!--TERMINO DE NOTA DE EVOLUCION-->


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