<?php
session_start();
include "../../conexionbd.php";

date_default_timezone_set('America/Guatemala');

$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 9) {
    include "../header_imagen.php";

} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_imagen.php";
} else {
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}
$id_usua = $_GET['id_usua'];

?>

<head>
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

    <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- FastClick -->
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</head>

<div>
    <div class="row">
        <div class="col-md-2"></div>
            <div class="col-md-8">
                <h1>Subir código Qr</h1>
                <?php
                $id = $_GET['not_id'];
                $sql = "SELECT * FROM notificaciones_imagen where realizado = 'NO'";
                $result = $conexion->query($sql);
                ?>
                       
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
                    <div class="col-sm-6">
                        <div style="width:450px;" id="reader"></div>
                    </div>
                    <div class="col-6">
                        <h4> RESULTADO</h4>
                        <div id="result">Resultado</div>
                    </div>
                </div>
                <script type="text/javascript">
                    function onScanSuccess(qrCodeMessage) {
                    document.getElementById('result').innerHTML = '<input class="resulta form-control" disabled type="text" name="linkt" value='+qrCodeMessage+'><form action="?link='+ encodeURIComponent(qrCodeMessage)+ '"  method="POST" enctype="multipart/form-data"><input type="hidden" name="id" value="<?php echo $id ?> "><input type="hidden" name="id_usua" value=" <?php echo $id_usua;?> "><input type="submit" class="btn btn-md btn-block btn-success" value="Guardar Qr" name="y"></form>';
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
                    $fecha_actual = date("Y-m-d H:i:s");
                    $link=$_GET['link'];
                    $link=$_GET['link'];
                    $id=$_POST['id'];
                    $id_usua=$_POST['id_usua'];
                    $link = mysqli_real_escape_string($conexion, (strip_tags($_GET["link"], ENT_QUOTES)));
                    
                    $sql2 = "UPDATE notificaciones_imagen SET realizado = 'Si',link='$link',fecha_resul='$fecha_actual',id_usua_resul ='$id_usua' WHERE not_id = $id";
                    $result = $conexion->query($sql2);
                    
                    $sql_img = "SELECT id_atencion, sol_estudios FROM notificaciones_imagen WHERE not_id = $id";
                    $result_img = $conexion->query($sql_img);
                    while ($row_img = $result_img->fetch_assoc()) {
                        $id_atencion = $row_img['id_atencion'];
                        $sol_estudios = $row_img['sol_estudios'];
                    }
                    
                    $sql_aseg = "SELECT aseg, area from dat_ingreso where id_atencion =$id_atencion";
                    $result_aseg = $conexion->query($sql_aseg);
                    while ($row_aseg = $result_aseg->fetch_assoc()) {
                        $at=$row_aseg['aseg'];
                        $area=$row_aseg['area'];
                    }
 
                    $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
                    while($filat = mysqli_fetch_array($resultadot)){ 
                        $tr=$filat["tip_precio"];
                    }

                    $sql_servi = "SELECT * from cat_servicios where serv_desc='$sol_estudios'";
                    $result_servi = $conexion->query($sql_servi);
                    while ($row_servi = $result_servi->fetch_assoc()) {
                        $id_cta = $row_servi['id_serv'];
                        if ($tr==1) $precio = $row_servi['serv_costo'];
                        if ($tr==2) $precio = $row_servi['serv_costo2'];
                        if ($tr==3) $precio = $row_servi['serv_costo3'];
                        if ($tr==4) $precio = $row_servi['serv_costo4'];
                        $cta_cant = 1;
                        $activo = "SI";
                        $prodserv = "S";
                    }
                    
                    $registracta = mysqli_query($conexion,'INSERT INTO dat_ctapac
                    (id_atencion,prod_serv,insumo,cta_fec,cta_cant, cta_tot, id_usua, cta_activo,centro_cto,vdesc)VALUES 
                    ('.$id_atencion.',"'.$prodserv.'",'.$id_cta.',"'.$fecha_actual.'",
                    '.$cta_cant.','.$precio.','.$id_usua.',"'.$activo.'","'.$area.'","IMAGENOLOGIA")')or die('<p>Error al registrar cuenta imagen</p><br>' . mysqli_error($conexion));     
    
                    echo '<script type="text/javascript">window.location ="../../../template/menu_imagenologia.php"</script>';  
                } ?>
                <hr>
            </div>
        </div>
    </div>
</div>

<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>

</body>

</html>