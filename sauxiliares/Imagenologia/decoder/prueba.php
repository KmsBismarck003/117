

<script src="html5-qrcode.min.js"></script>
<style>
  .result{
    background-color: green;
    color:#fff;
    padding:20px;
  }
  .row{
    display:flex;
  }
</style>
<div class="row">
  <div class="col">
    <div style="width:500px;" id="reader"></div>
  </div>
  <div class="col" style="padding:20px;">
    <h4> RESULTADO</h4>
    <div id="result">Resultado</div>
  
  </div>
</div>

<script type="text/javascript">
function onScanSuccess(qrCodeMessage) {
   document.getElementById('result').innerHTML = '<input class="resulta form-control" type="text" name="linkt" value='+qrCodeMessage+'><form action="?link='+ encodeURIComponent(qrCodeMessage)+ '"  method="POST" enctype="multipart/form-data"><input type="submit" class="btn btn-md btn-block btn-success" value="Guardar Qr" name="y"></form>';
  
     

}
function onScanError(errorMessage) {
  //handle scan error
}
var html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess, onScanError);
</script>

<br>

    <?php
   
    include "../../../conexionbd.php";
      
if (isset($_POST['y'])) {
 
$link=$_GET['link'];
 
   
 $link = mysqli_real_escape_string($conexion, (strip_tags($_GET["link"], ENT_QUOTES)));
 ECHO $link;
 
    $id_usua= 2;
$sql2 = "UPDATE notificaciones_imagen SET realizado = 'Si',link='$link',id_usua_resul ='$id_usua' WHERE not_id = 18";
                $result = $conexion->query($sql2);
}
    
    
    
    
    
    
    
    





?>









