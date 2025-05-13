<?php
session_start();
include "../../conexionbd.php";


$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];


if ($usuario['id_rol'] == 7) {
    include "../header_farmacia.php";
} else if ($usuario['id_rol'] == 3) {
    include "../../enfermera/header_enfermera.php";
} else if ($usuario['id_rol'] == 4 or 5) {
    include "../header_farmacia.php";
} else {
    //session_unset();
    // session_destroy();
    echo "<script>window.Location='../../index.php';</script>";

}


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
<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">

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

    <style>
        td.fondo {
            background-color: red !important;
        }
    </style>
<?php
$resultado1 = $conexion->query("SELECT * FROM cart order by cart_id DESC" ) or die($conexion->error);
        while ($f1 = mysqli_fetch_array($resultado1)) {
         $cart_id=$f1['cart_id'];
          $confirmado=$f1['confirmado'];
        
       if($confirmado=='No' && $usuario['id_rol']==4 || $confirmado=='No' && $usuario['id_rol']==7)
            {
            }?>
<audio>
<source src="alerta.mp3" type="audio/mp3" autoplay></audio>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    
    <script>
$(document).ready(function() {
 var myAudio= document.createElement('audio');
 var myMessageAlert = "";
 myAudio.src = './alerta.mp3';
 myAudio.addEventListener('ended', function(){
    alert(myMessageAlert);
 });
function Myalert(message) { 
    myAudio.play();
    myMessageAlert = message;
} 
Myalert("Mensaje");
function alert(message) { 
  myAudio.play();
  myMessageAlert = message;
} 
alert("Mensaje");

                        swal({
                            title: "SURTIR VALES DE FARMACIA", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                                window.location.href = "./order.php";
                            }
                        });
                    });
 function refrescar(tiempo){
    //Cuando pase el tiempo elegido la página se refrescará 
    setTimeout("location.reload(true);", tiempo);
  }
  //Podemos ejecutar la función de este modo
  //La página se actualizará dentro de 10 segundos
  refrescar(180000);
</script>
                
                
<?php } ?>
</head>

<body>


<div class="container">
         <?php
            if ($usuario1['id_rol'] == 4) {
                ?>
               <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="../../template/menu_farmacia.php">Regresar</a>
                   </div>
               </div>
                <?php
            } else if ($usuario1['id_rol'] == 7) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger" href="../../template/menu_farmacia.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            } else if ($usuario1['id_rol'] == 5) {

                ?>
                <div class="row">
                   <div class="col-sm-4">
                       <a type="submit" class="btn btn-danger"
                   href="../../template/menu_farmacia.php">Regresar</a>
                   </div>
               </div>
                

                <?php
            }

            ?>
            
            
            <br>
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
            <tr><strong><center>SALIDAS DE MEDICAMENTOS POR PACIENTE</center></strong>
        </div>
        <br>
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="excelsalidas.php">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Exportar Salidas a Excel:</strong>
                    </div>
                    <div class="col-sm-2">
                        <input type="date" class="form-control" name="date1" id = "date1" required>
                    </div>
                    <div class="col-sm-2">
                        <input type="date" class="form-control" name="date2" id = "date2" required>
                    </div>
                    <div class="col-sm-4">
                        <img src="https://img.icons8.com/color/48/000000/ms-excel.png"/>
                        <strong>
                            <input type="submit" class="btn btn-warning" name="btnexcel" id = "btnexcel" value="Exportar">
                        </strong>    
                    </div>
                </div>
            </div>
        </form>
    </div>
<section class="content container-fluid">

    <div class="container box">
        <div class="content">
            
            <form action"" method="GET">
                <input type="text" placeholder="Buscar por Apellido Paterno" name="nombreb" class="form-control  col-sm-5">
                
            </form>




            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search"
                       placeholder="Buscar...">
            </div>


<?php if (isset($_GET['nombreb'])){
  $NombrePac=$_GET['nombreb'];
?> 

<div class="table-responsive">
                <!--<table id="myTable" class="table table-striped table-hover">-->

                <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #2b2d7f; color:white;">
                    <tr>
                        <th><font color="white">Expediente</th>
                        <th><font color="white">Paciente</th>
                    </tr>
                    </thead>
                    <tbody>
                        
  <?php 

$resultado = $conexion->query("SELECT DISTINCT s.paciente= di.id_atencion,di.*, p.* FROM sales s, dat_ingreso di, paciente p WHERE s.paciente = di.id_atencion and p.papell like '%$NombrePac%'  and di.Id_exp = p.Id_exp ORDER BY di.id_atencion DESC")or die($conexion -> error); 

while($fila = mysqli_fetch_array($resultado)){
    
   echo '<tr>'
                            . '<td><a type="submit" class="btn btn-danger btn-sm" href="select_fecha_vista.php?id_atencion=' . $fila['id_atencion'] . '">' . $fila['Id_exp'] . '</a></td>'
                            . '<td>' . $fila['papell'] . " " . $fila['sapell']  . " " .$fila['nom_pac']. '</td>';
                        echo '</tr>';
}
?>
                        
                        
                        
               
                    </tbody>
                </table>
            </div>
<?php }else{ ?>





            <div class="table-responsive">
                <!--<table id="myTable" class="table table-striped table-hover">-->

                <table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #2b2d7f; color:white;">
                    <tr>
                        <th><font color="white">Expediente</th>
                        <th><font color="white">Paciente</th>
                    </tr>
                    </thead>
                    <tbody>
                        
  <?php 

$limite= 40; 
$totalQuery = $conexion->query('select count(DISTINCT paciente) FROM sales')or die($conexion->error);
$totalProductos = mysqli_fetch_row($totalQuery);
$totalBotones = round($totalProductos[0] /$limite); 
//die($totalBotones); numero de botones que saldran
if(isset($_GET['limite'])){
$resultado = $conexion->query("SELECT DISTINCT s.paciente= di.id_atencion,di.*, p.* FROM sales s, dat_ingreso di, paciente p WHERE s.paciente = di.id_atencion and di.Id_exp = p.Id_exp ORDER BY di.id_atencion DESC limit ".$_GET['limite'].",".$limite)or die($conexion -> error);
}else{
    
$resultado = $conexion->query("SELECT DISTINCT s.paciente= di.id_atencion,di.*, p.* FROM sales s, dat_ingreso di, paciente p WHERE s.paciente = di.id_atencion and di.Id_exp = p.Id_exp ORDER BY di.id_atencion DESC limit ".$limite)or die($conexion -> error); 
}
while($fila = mysqli_fetch_array($resultado)){
    
   echo '<tr>'
                            . '<td><a type="submit" class="btn btn-danger btn-sm" href="select_fecha_vista.php?id_atencion=' . $fila['id_atencion'] . '">' . $fila['Id_exp'] . '</a></td>'
                            . '<td>' . $fila['papell'] . " " . $fila['sapell']  . " " .$fila['nom_pac']. '</td>';
                        echo '</tr>';
}
?>
                        
                        
                        
               
                    </tbody>
                </table>
            </div>
            
            <?php } ?>
        </div>
    </div>
</section>

<div class="row" data-aos="fade-up" id="botones">
              <div class="col-md-12 text-center">
                <div class="site-block-27">
                  <ul>
                  <font color="steelblue">Seleccionar páginas para más busquedas</font><hr>

<?php
if(isset($_GET['limite'])){ 
if($_GET['limite']>0){ 
echo '<li><a href="salidas.php?limite='.($_GET['limite']-40).'">&lt;</a></li>';
    } }
    for($k=0;$k<$totalBotones;$k++){ 
echo '<li><a href="salidas.php?limite='.($k*40).'">'.($k+1).'</a></li>'; 
}
if(isset($_GET['limite'])){ 
if($_GET['limite']+40<$totalBotones*40){ 
echo'<li><a href="salidas.php?limite='.($_GET['limite']+40).'">&gt;</a></li>';   
    }
}else{
echo'<li><a href="salidas.php?limite=40">&gt;</a></li>';
}
?>
</ul>
                </div>
              </div>
            </div>
</div>

<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>

<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  
  
<script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- FastClick -->
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

</body>

</html>