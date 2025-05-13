<?php
session_start();
//include "../../conexionbd.php";
$nopac = @$_GET['nopac'];


include "../header_facturacion.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];
$id_usua=$usuario['id_usua'];

$id_atencion = @$_GET['id_at'];
$id_datfin=@$_GET['id_datfin'];
include "conexionbdf.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
 <link rel="stylesheet" type="text/css" href="../../gestion_medica/hospitalizacion/css/select2.css">
 <script src="../../gestion_medica/hospitalizacion/js/select2.js"></script>
   <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <script src="jquery-3.1.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>

<style type="text/css">
.elementoPadre{
width: 750px ; 
word-wrap: break-word ;
}

</style>
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
    
  <title>Facturación</title>
  
</head>

<body>
   
 <div class="form-group">
  Facturas
   <div class="table-responsive">
                    <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
                </div>
   <div class="table-responsive">
          <!--<table id="myTable" class="table table-striped table-hover">-->

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #2b2d7f; color: white;">
              <tr>
                <th>#</th>
                <th>Fecha</th>
                   <th>Nombre paciente</th>
                 <th>Nombre factura</th>
                <th>RFC</th>
                <th>Serie</th>
                <th>Folio</th>
                <th>Total</th>
                <th>XML</th>
                 <!--<th>Cadena original</th>-->
                <th>QR</th>
                <th>Realizar pago (Complemento)</th>
                <th>Nota de crédito (Egreso)</th>
                
                <?php
                
                 $resultado41 = $conexion->query("SELECT * FROM comprobantes c,gen_factura g where c.id_atencion = '$id_at' and g.id_atencion='$id_at' and c.id_dat_gen_f=g.id_dat_gen_f order by id_comp DESC") or die($conexion->error);
               
              while ($row41 = $resultado41->fetch_assoc()) {
                  $id_datco=$row41['id_dat_gen_f'];
              }
                      $resultadoc = $conexion->query("SELECT * FROM comprobante_nc where id_atencion='$id_at' and id_dat_gen_f='$id_datco'") or die($conexion->error);
              while ($rowc = $resultadoc->fetch_assoc()) {
                  $ex=$rowc['id_dat_gen_f'];
              }
                if($ex==$id_datco){
                    ?>
                     <th>Datos nota de crédito</th>
                <?php }else{
                    
                }
                ?>
                
                <th>Ver Factura</th>
                
                
                <th>Ver Pago</th>
                <th>Estatus</th>
                <th>Cancelar factura</th>
                
              </tr>
            </thead>
            <tbody>

              <?php
               $no = 0;
            $usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
//$id_at = $_GET['id_atencion'];
$id_at = $_GET['id_atencion'];
//$resultado4 = $conexion->query("SELECT *,id_atencion,sum(precio) as suma FROM gen_concepto where id_atencion = id_atencion GROUP BY id_atencion") or die($conexion->error);

              $resultado4 = $conexion->query("SELECT * FROM comprobantes c,gen_factura g where c.id_atencion = $id_at and g.id_atencion=$id_at and c.id_dat_gen_f=g.id_dat_gen_f order by id_comp DESC") or die($conexion->error);
               
             
              while ($row4 = $resultado4->fetch_assoc()) {
                  
                  $no++;
                //echo $row4['suma'];
                $fecha=date_create($row4['fecha']);
                $total=$row4['total'];
                echo '<tr>'
                    . '<td>' . $no . '</td>'
                    . '<td>' . date_format($fecha,"d-m-Y H:i:s") . '</td>'
                     . '<td>' . $nopac . '   </td>'
                    . '<td>' . $row4['razon_s'] . '</td>'
                    . '<td>' . $row4['rfc_receptor'] . '</td>'
                    . '<td> ' . $row4['serie'] . '</td>'
                    . '<td> ' . $row4['folio'] . '</td>'
                    . '<td> $' . number_format($total,2) . '</td>';
                    
                
                
echo '<td><strong><a type="submit" class="btn btn-primary btn-sm"
                     href="des_xml.php?id_atencion=' . $row4['id_atencion'] . '&id_dat_gen_f=' . $row4['id_comp'].'&id_usua='.$id_usua .'&ffiscal='.$row4['uuid'] .'"
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

echo '<td><center><strong><a type="submit" class="btn btn-success btn-sm"
                     href="nota_credito.php?id_atencion=' . $row4['id_atencion'] . '&iddat=' . $row4['id_dat_gen_f'].'&id_usua='.$id_usua .'"
                     target="_blank" title="Realizar pago"><i class="fa fa-usd" aria-hidden="true"></i></center></a></strong></td>';

if($ex==$id_datco){
                echo '<td><center><strong><a type="submit" class="btn btn-success btn-sm"
                     href="nota_credito_datos.php?id_atencion=' . $row4['id_atencion'] . '&iddat=' . $row4['id_dat_gen_f'].'&id_usua='.$id_usua .'"
                     target="_blank" title="Ver datos"><i class="fa fa-usd" aria-hidden="true"></i></center></a></strong></td>';
                }
                


    $resultadocom = $conexion->query("SELECT * FROM Complemento where id_atencion = $id_at") or die($conexion->error);
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
                     target="_blank" title="Ver"><i class="fa fa-usd" aria-hidden="true"></i></a></strong></td>'
                     . '<td>' . $row4['estatus'] . '</td>';
                   }else{
                    echo '<td><strong><a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_facturac.php?id_atencion=' . $row4['id_atencion'].'"
                     target="_blank" title="Ver"><i class="fa fa-usd" aria-hidden="true"></i></a></strong></td>'
                     . '<td>' . $row4['estatus'] . '</td>';
                   }
                   
   echo'<td>
 <strong><a type="submit" class="btn btn-danger btn-sm"
                     href="cancelar_factp.php?id=' . $row4['id_comp'].'&in='.$in.'&fin='.$anfinal.'&id_at='.$id_at.'&nopac='.$nopac.'" title="Cancelar"><i class="fa fa-minus-square" aria-hidden="true"></i></a></strong></td>';

              
              }
              ?>
             
             
            
            </tbody>
          </table>

        </div>
 </div>
 
 </body>
</div>

<script>

function pagoOnChange(sel) {
      if (sel.value==="01"){
           divC = document.getElementById("nCuenta");
           divC.style.display = "block";

          

      }else if (sel.value!="02"){

           divC = document.getElementById("nCuenta");
           divC.style.display="none";

      }
}
</script>

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

  <script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador1').select2();
    });
    $(document).ready(function () {
        $('#mibuscador2').select2();
    });
    $(document).ready(function () {
        $('#cod_postal').select2();
    });
</script>
<script>
    document.querySelector('#id_estado').addEventListener('change', event => {
        fetch('../../municipios.php?id_estado=' + event.target.value)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Error en la respuesta');
                }//en if
                return res.json();
            })
            .then(datos => {
                let html = '<option value=""> Seleccionar municipio</option>';
                if (datos.data.length > 0) {
                    for (let i = 0; i < datos.data.length; i++) {
                        html += `<option value="${datos.data[i].id}">${datos.data[i].nombre}</option>`;
                    }//end for
                }//end if
                document.querySelector('#municipios').innerHTML = html;
            })
            .catch(error => {
                console.error('Ocurrió un error ' + error);
            });
    });
</script>
 

 <script type="text/javascript">
  $(document).ready(function(){
    $('#cod_postal').val(1);
    recargarLista();

    $('#cod_postal').change(function(){
      recargarLista();
    });
  })
</script>
<script type="text/javascript">
  function recargarLista(){
    $.ajax({
      type:"POST",
      url:"datos.php",
      data:"asenta=" + $('#cod_postal').val(),
      success:function(r){
        $('#select2lista').html(r);
      }
    });
  }

</script>



 

</body>
</html>