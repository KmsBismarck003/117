<?php
session_start();
include "../../conexionbd.php";
include "../../gestion_administrativa/header_administrador.php";
$resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE  dat_ingreso.activo='SI' AND alta_adm = 'NO'") or die($conexion->error);



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
    hr.new4 {
      border: 1px solid red;
    }
  </style>

    <title>Menu Gestión Administrativa </title>
    <link rel="shortcut icon" href="logp.png">
</head>
 <div class="col-sm-2">
                <a type="submit" class="btn btn-danger btn-sm" onclick="history.back()"><font color="white">Regresar</font></a>
                
            </div>
<div class="container">
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                 <tr><strong><center>FACTURAS</center></strong>
</div>

<?php 
if (isset($_GET['nombre'])) {
    
}else{
 ?>
<br>
    
    <form action="" method="POST">
         <div class="row">
        <div class="container">
            <div class="row">
        <div class="col-sm-2">
            Fecha inicial:
            <input type="date" class="form-control" name="anio" required>
        </div>
         <div class="col-sm-2">
            Fecha final:
            <input type="date" class="form-control" name="aniofinal" required>
        </div>
         <div class="col-sm-4">
            <br><button type="submit" class="btn btn-danger" name="btnpac">Consultar</button>
         </div> 
            </div>
        </div>
    </div>
  </form>
<br>
<?php } ?>
<?php
if (isset($_POST['btnpac'])) {
    include "../../conexionbd.php";
$anio =  mysqli_real_escape_string($conexion, (strip_tags($_POST["anio"], ENT_QUOTES)));
$aniofinal =  mysqli_real_escape_string($conexion, (strip_tags($_POST["aniofinal"], ENT_QUOTES)));
echo '<script type="text/javascript">window.location.href = "facturas_pacientes.php?anio='.$anio.'&anfinal='.$aniofinal.'  ";</script>';
}
?>
<?php
if (isset($_GET['anio'])) {
    $in=$_GET['anio'];
    $anfinal=$_GET['anfinal'];
?>
<div class="container box"><p></p>
    <center><h3>Facturas del: <?php echo $in;?> al <?php echo $anfinal;?></h3></center><br>


<div class="form-group">
                    <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
                </div>
   <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
              
            <thead class="thead" style="background-color: #2b2d7f; color: white;">
              <tr>
                <th>#</th>
               
                <th>Fecha</th>
                
                 <th>Nombre factura</th>
                <th>RFC</th>
                <th>Serie</th>
                <th>Folio</th>
                <th>Total</th>
                <th>XML</th>
                 <!--<th>Cadena original</th>-->
                <th>QR</th>
                <th>Realizar pago (Complemento)</th>
                <th>Ver Factura</th>
                <th>Ver Pago</th>
                 <th>Cancelar factura</th>
                
              </tr>
            </thead>
            <tbody>

              <?php
               
              
              
              include "conexionbdf.php";
            $usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
//$id_at = $_GET['id_atencion'];
$id_at = $_GET['id_atencion'];


              $resultado4 = $conexion->query("SELECT * FROM comprobantes c,gen_factura g where c.estatus='activa' and c.id_atencion =g.id_atencion and c.id_dat_gen_f=g.id_dat_gen_f and (c.fecha BETWEEN '$in' AND '$anfinal') order by id_comp DESC") or die($conexion->error);
             
              $no = 1;
              while ($row4 = $resultado4->fetch_assoc()) {
                //echo $row4['suma'];
                
                // while ($rowpac = $resultado->fetch_assoc()) {
                    
                $fecha=date_create($row4['fecha']);
                echo '<tr>'
                  . '<td>' . $no++ . '</td>'
                  . '<td>' . date_format($fecha,"d-m-Y H:i:s") . '</td>'
                  
                       //. '<td>' . $rowpac['papell'] . ' ' . $rowpac['sapell'] . ' ' . $rowpac['nom_pac'] . '   </td>'
                       
                  . '<td>' . $row4['razon_s'] . '</td>'
                  . '<td>' . $row4['rfc_receptor'] . '</td>'
                  . '<td> ' . $row4['serie'] . '</td>'
                  . '<td> ' . $row4['folio'] . '</td>'
               . '<td> $' . $row4['total'] . '</td>';
                
echo '<td><strong><a type="submit" class="btn btn-primary btn-sm"
                     href="des_xml.php?id_atencion=' . $row4['id_atencion'] . '&id_dat_gen_f=' . $row4['id_comp'].'&id_usua='.$id_usua .'"
                     target="_blank" title="Generar XML"><span class="fa fa-file-text"</span></a></strong></td>';


/*echo '<td><strong><a type="submit" class="btn btn-secondary btn-sm"
                        data-toggle="modal" data-target=".bd-example-modal-lg"
                     target="_blank" title="Generar Cadena"><span class="fa fa-list"</span></a></strong></td>

    '.
$fp = fopen("cadenaOriginal.txt", "r");
$linea = fgets($fp);
echo '<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <center><h5 class="modal-title" id="exampleModalLongTitle">Cadena original del complemento de certificación:</h5></center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body elementoPadre" id="elementoPadre">
'.$linea.'</div> <center>
          
           
        <button type="button" class="btn btn-primary col-5" data-dismiss="modal">Aceptar</button>

           </center>
           <br>
    </div>
  </div>
</div>*/

    echo'</div>
  </div>
</div>
      

      ';
                 

echo '<td><strong><a type="submit" class="btn btn-warning btn-sm"
                     href="des_qr.php?id_atencion=' . $row4['id_atencion'] . '&id_dat_gen_f=' . $row4['id_comp'].'&id_usua='.$id_usua .'"
                     target="_blank" title="Generar QR"><span class="fa fa-qrcode"</span></a></strong></td>';

echo '<td><center><strong><a type="submit" class="btn btn-success btn-sm"
                     href="facturacioncom.php?id_atencion=' . $row4['id_atencion'] . '&id_dat_gen_f=' . $row4['id_comp'].'&id_usua='.$id_usua .'&saldoant='.$row4['total'] .'  "
                     target="_blank" title="Realizar pago"><i class="fa fa-usd" aria-hidden="true"></i></center></a></strong></td>';



    $resultadocom = $conexion->query("SELECT * FROM Complemento where id_atencion = '".$row4['id_atencion']."'") or die($conexion->error);
              while ($row4c = $resultadocom->fetch_assoc()) {
$id_complemento=$row4c['id_complemento'];
}
                if(isset($id_datfin)){
                    echo '<td><strong><a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_factura.php?id_atencion=' . $row4['id_atencion'] . '&id_comp=' . $row4['id_comp'].'&id_usua='.$id_usua .'&id_datfin='.$id_datfin .'&id_f='.$row4['id_dat_gen_f'] .'"
                     target="_blank" title="Ver"><span class="fa fa-file-pdf-o"</span></a></strong></td>';
                   }else{
                       echo '<td><strong><a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_factura.php?id_atencion=' . $row4['id_atencion'] . '&id_comp=' . $row4['id_comp'].'&id_usua='.$id_usua .'&id_datfin='.$id_datfin .'&id_f='.$row4['id_dat_gen_f'] .'"
                     target="_blank" title="Ver"><span class="fa fa-file-pdf-o"</span></a></strong></td>';
                   }
                   
                   if(isset($id_complemento)){ 
                  echo '<td><strong><a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_facturac.php?id_atencion=' . $row4['id_atencion'] . '&id_dat_gen_f=' . $row4['id_comp'].'&id_usua='.$id_usua .'&id_datfin='.$id_datfin .'"
                     target="_blank" title="Ver"><i class="fa fa-usd" aria-hidden="true"></i></a></strong></td>';
                   }else{
                    echo '<td><strong><a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_facturac.php?id_atencion=' . $row4['id_atencion'].'"
                     target="_blank" title="Ver"><i class="fa fa-usd" aria-hidden="true"></i></a></strong></td>';
                   }
                
                  echo'<td>
 <strong><a type="submit" class="btn btn-danger btn-sm"
                     href="cancelar_fact.php?id=' . $row4['id_comp'].'&in='.$in.'&fin='.$anfinal.'" title="Cancelar"><i class="fa fa-minus-square" aria-hidden="true"></i></a></strong></td>';
 

  
              } 
             // }
              ?>
             
             
            
            </tbody>
          </table>

        </div>
 </div>
     <?php
}

?>


  


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



<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador2').select2();
    });
</script>
</body>

</html>