<?php
session_start();
//include "../../conexionbd.php";
include "../header_administrador.php";
//$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);

$usuario = $_SESSION['login'];
$id_usua=$usuario['id_usua'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


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

  <title>Detalle de la cuenta del paciente</title>
  <style>
    hr.new4 {
      border: 1px solid red;
    }
  </style>
</head>

<body>
  <section class="content container-fluid">

    <div class="container box">
      <div class="content">

        <?php

        include "../../conexionbd.php";
        $usuario1 = $_GET['id_usua'];
        $rol = $_GET['rol'];

        //$resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        
        $id_exp = $_GET['id_exp'];
        $id_atencion = $_GET['id_at'];


        $resultado_total = $conexion->query("SELECT * FROM dat_financieros where id_atencion = $id_atencion") or die($conexion->error);
        $total_dep = 0;
        $no = 1;
        while ($row_total = $resultado_total->fetch_assoc()) {
          $total_dep = $row_total['deposito'] + $total_dep;
        }
        //  $diferencia = $total - $total_dep;


        $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.fecha, di.area, di.alta_med, di.alta_adm, di.valida, di.correo, di.correo_encuesta  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

        $result_pac = $conexion->query($sql_pac);

        while ($row_pac = $result_pac->fetch_assoc()) {
          $pac_papell = $row_pac['papell'];
          $pac_sapell = $row_pac['sapell'];
          $pac_nom_pac = $row_pac['nom_pac'];
          $pac_dir = $row_pac['dir'];
          $pac_id_edo = $row_pac['id_edo'];
          $pac_id_mun = $row_pac['id_mun'];
          $pac_tel = $row_pac['tel'];
          $pac_fecnac = $row_pac['fecnac'];
          $pac_fecing = $row_pac['fecha'];
          $area = $row_pac['area'];
          $alta_med = $row_pac['alta_med'];
          $alta_adm = $row_pac['alta_adm'];
          $valida = $row_pac['valida'];
          $area = $row_pac['area'];
          $id_exp=$row_pac['Id_exp'];
          $correo = $row_pac['correo'];
          $correo_encuesta = $row_pac['correo_encuesta'];
        }
        /*
            
            function evento()
            {
              time();
              $today = strtotime('today 12:00');
              $tomorrow = strtotime('tomorrow 12:00');
              $time_now = time();
              $timeLeft = ($time_now > $today ? $tomorrow : $today) - $time_now;
              return strftime("%H Horas, %M minutos, %S segundos", $timeLeft);
            }

            $tz = new DateTimeZone("America/New_York");
            $date_1 = new DateTime("2019-10-30 15:00:00", $tz);
            $date_2 = new DateTime("2019-11-21 14:30:20", $tz);

            echo $date_2->diff($date_1)->format("%a:%h:%i:%s");
    */


        $fecha_actual = date("Y-m-d H:i:s");
        $sql_now = "SELECT DATE_ADD('$fecha_actual', INTERVAL 11 HOUR) as dat_now FROM dat_ingreso WHERE id_atencion = $id_atencion";

        $result_now = $conexion->query($sql_now);

        while ($row_now = $result_now->fetch_assoc()) {
          $dat_now = $row_now['dat_now'];
        }

        $sql_est = "SELECT DATEDIFF( '$dat_now' , fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";
        $result_est = $conexion->query($sql_est);

        while ($row_est = $result_est->fetch_assoc()) {
          $estancia = $row_est['estancia'];
        }

        $sql_est = "SELECT DATEDIFF( '$dat_now' , fecha_cama) as dia_hab FROM dat_ingreso WHERE id_atencion = $id_atencion";
        $result_est = $conexion->query($sql_est);

        while ($row_est = $result_est->fetch_assoc()) {
          $dia_hab = $row_est['dia_hab'];
        }
        
        $sql_dia_hab = "SELECT * FROM dat_ctapac WHERE
        id_atencion = $id_atencion and prod_serv='S' and insumo= 1 or 
        id_atencion = $id_atencion and prod_serv='S' and insumo= 2 or 
        id_atencion = $id_atencion and prod_serv='S' and insumo= 3 or 
        id_atencion = $id_atencion and prod_serv='S' and insumo= 8 or 
        id_atencion = $id_atencion and prod_serv='S' and insumo= 4  
        Order by id_ctapac DESC LIMIT 1";
        $result_dia_hab = $conexion->query($sql_dia_hab);
         while ($row_dia_hab = $result_dia_hab->fetch_assoc()) {
          $id_cta=$row_dia_hab['id_ctapac'];
          $cta_cant = $row_dia_hab['cta_cant'];
          $insumo = $row_dia_hab['insumo'];
        }
        
        if(isset($id_cta)){
            
            /*
        if ($cta_cant <= $dia_hab && $insumo==1) {
          $sql_dia_hab = "UPDATE dat_ctapac SET cta_cant = $dia_hab  WHERE id_atencion = $id_atencion and prod_serv='S' and insumo=$insumo ";
        $result_dia_hab = $conexion->query($sql_dia_hab);
        }elseif($cta_cant <= $dia_hab && $insumo==2){
              $sql_dia_hab = "UPDATE dat_ctapac SET cta_cant = $dia_hab  WHERE id_atencion = $id_atencion and prod_serv='S' and insumo=$insumo ";
        $result_dia_hab = $conexion->query($sql_dia_hab);
        }elseif($cta_cant <= $dia_hab && $insumo==3){
              $sql_dia_hab = "UPDATE dat_ctapac SET cta_cant = $dia_hab  WHERE id_atencion = $id_atencion and prod_serv='S' and insumo=$insumo ";
        $result_dia_hab = $conexion->query($sql_dia_hab);
        }elseif($cta_cant <= $dia_hab && $insumo==4){
              $sql_dia_hab = "UPDATE dat_ctapac SET cta_cant = $dia_hab  WHERE id_atencion = $id_atencion and prod_serv='S' and insumo=$insumo ";
        $result_dia_hab = $conexion->query($sql_dia_hab);
        }elseif($cta_cant <= $dia_hab && $insumo==8){
              $sql_dia_hab = "UPDATE dat_ctapac SET cta_cant = $dia_hab  WHERE id_atencion = $id_atencion and prod_serv='S' and insumo=$insumo ";
        $result_dia_hab = $conexion->query($sql_dia_hab);
        }*/
        
      }else{
        ?>
        <div class="col-md-12">
         <!--   <div class="alert alert-danger alert-dismissible fade show"><center><strong>PACIENTE SIN HABITACIÓN</strong></center></div>
          </div>-->
        <?php } ?>


<?php 

$sql_encuesta = "SELECT * FROM encuestas where id_atencion = $id_atencion";
$result_encuesta = $conexion->query($sql_encuesta);

while ($row_enc = $result_encuesta->fetch_assoc()) {
  $id_encuesta = $row_enc['id_encuesta'];
}

if(isset($id_encuesta) and $correo_encuesta == 'No'){
 $id_encuesta = 'SI';
  }else{
    $id_encuesta ='NO';
    if ($alta_med=='SI') {
     ?>
        <div class="col-md-12">
            <!--<div class="alert alert-danger alert-dismissible fade show"><center><strong>FALTA LA ENCUESTA</strong></center></div>-->
        </div>
        <?php
        $to3="rh@medicasanisidro.com";
        $subject3='Control de encuestas de Medica "San Isidro"';
        $header3='MIME-Version: 1.0'."\r\n";
        $from3='https://sanisidro.simahospitales.com/';
        $header3.="Content-type: text/html; charset=iso-8859-1\r\n";
        $header3.="X-Mailer:PHP/".phpversion();
        $message3.='<html><body>
        <h3 style="color:black;">Buen dia,</h3>';
        $message3.='<h3 style="color:black;">
        Se notifica alta del paciente: '.$pac_papell.' ' .$pac_sapell.' '.$pac_nom_pac.', para que se le realice su encuesta por favor.
</h3></body></html>';
$message3=utf8_decode($message3);

if(mail($to3,$subject3,$message3,$header3)){ /* Condicion para recojer las variables y enviar el correo*/
        //  echo "Mensaje enviado correctamente";
    $sql_correoe = "UPDATE dat_ingreso SET correo_encuesta='Si' WHERE id_atencion = $id_atencion";
        $result_correoe = $conexion->query($sql_correoe);
    }else{
        //  echo "No se pudo enviar el email";
    }
}
} ?>

<?php
/*********************** surtir farmacia **********************/
$sql_cart = "SELECT * FROM cart where paciente = $id_atencion ORDER BY paciente";
$result_cart = $conexion->query($sql_cart);
while ($row_cart = $result_cart->fetch_assoc()) {
  $cartf_id = $row_cart['cart_id'];
}

    if(isset($cartf_id)){
         ?>
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show"><center><strong>VALES DE MEDICAMENTOS PENDIENTES DE SURTIR POR FARMACIA</strong></center></div>
        </div>
    <?php 
    }else{
        $cartf_id ='nada';
    } ?>
  
  
<?php 
/*********************** enfermera de hospitalizacion sin confirmar **********************/
$sql_cart = "SELECT * FROM cart_enf where paciente = $id_atencion ORDER BY paciente";
$result_cart = $conexion->query($sql_cart);

while ($row_cart = $result_cart->fetch_assoc()) {
  $carth_id = $row_cart['cart_id'];
}

if(isset($carth_id)){
         ?>
<div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show"><center><strong>MEDICAMENTOS DE HOSPITALIZACION SIN CONFIRMAR POR ENFERMERIA</strong></center></div>
          </div>
  <?php }else{
        $carth_id ='nada';
    } ?>

<?php 
/*********************** enfermera de quirofano sin confirmar **********************/
$sql_cart = "SELECT * FROM cart_almacen where paciente = $id_atencion ORDER BY paciente";
$result_cart = $conexion->query($sql_cart);
 
while ($row_cart = $result_cart->fetch_assoc()) {
  $cartq_id = $row_cart['id'];
}

if(isset($cartq_id)){
         ?>
<div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show"><center><strong>MEDICAMENTOS DE QUIROFANO SIN CONFIRMAR POR ENFERMERIA</strong></center></div>
          </div>
  <?php }else{
        $cartq_id ='nada';
    } ?>
  
<?php 
/*********************** enfermera de quirofano sin confirmar **********************/
$sql_cart = "SELECT * FROM cart_serv where paciente = $id_atencion ORDER BY paciente";
$result_cart = $conexion->query($sql_cart);

while ($row_cart = $result_cart->fetch_assoc()) {
  $carte_id = $row_cart['id'];
}

if(isset($carte_id)){
         ?>
<div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show"><center><strong>EQUIPOS DE QUIROFANO SIN CONFIRMAR POR ENFERMERIA</strong></center></div>
          </div>
  <?php }else{
        $carte_id ='nada';
    } ?>
 
<?php 
/*********************** enfermera de quirofano sin confirmar **********************/
$sql_cart = "SELECT * FROM cart_mat where paciente = $id_atencion ORDER BY paciente";
$result_cart = $conexion->query($sql_cart);

while ($row_cart = $result_cart->fetch_assoc()) {
  $cartm_id = $row_cart['id'];
}

if(isset($cartm_id)){
         ?>
<div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show"><center><strong>MATERIALES DE QUIROFANO SIN CONFIRMAR POR ENFERMERIA</strong></center></div>
          </div>
  <?php }else{
        $cartm_id ='nada';
    } ?>
  

  <?php 
  /*********************** MATERIALES de quirofano sin confirmar desde CEYE **********************/
$sql_cart_serv = "SELECT * FROM cart_ceye where paciente = $id_atencion ORDER BY paciente";
$result_cart_serv = $conexion->query($sql_cart_serv);

while ($row_cart_serv = $result_cart_serv->fetch_assoc()) {
  $cartc_id = $row_cart_serv['cart_id'];
}
if(isset($cartc_id)){
         ?>
<div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show"><center><strong>VALES DE MATERIALES Qx PENDIENTES DE SURTIR POR CEYE</strong></center></div>
          </div>
  <?php }else{
        $cartc_id ='nada';
    } ?>
  
  
  
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                         <tr><strong><center>CUENTA DEL PACIENTE</center></strong>
        </div>
        
        <div class="container">
           <div class="row">
             <div class="col-sm-6">
              <label class="control-label">Expediente: </label><strong> &nbsp; <?php echo $id_exp ?></strong>
             </div>
            <div class="col-sm-6">
              <label class="control-label">Paciente:  </label><strong>  &nbsp; 
                <?php echo $pac_papell.' ' .$pac_sapell.' '.$pac_nom_pac ?></strong>
            </div>
          </div>
      
       
          <div class="row">
             <?php
            $pac_fecing=date_create($pac_fecing);
             ?>
            <div class="col-md-6">
          
                 <label class="control-label">Fecha de ingreso: </label><strong>  &nbsp; <?php echo date_format($pac_fecing,"d/m/Y H:i a") ?></strong>
              
            </div>
            <div class="col-md-6">
              
                <label class="control-label">Aseguradora: </label><strong>  &nbsp; 
                  <?php $sql_aseg = "SELECT aseg from dat_ingreso where id_atencion =$id_atencion";
                     $result_aseg = $conexion->query($sql_aseg);
                      while ($row_aseg = $result_aseg->fetch_assoc()) {
                          echo $row_aseg['aseg'];
                          $at=$row_aseg['aseg'];
                      }
                      $resultadot = $conexion ->query("SELECT tip_precio FROM cat_aseg WHERE aseg='$at'")or die($conexion->error);
                      while($filat = mysqli_fetch_array($resultadot)){ 
                      $tr=$filat["tip_precio"];
                      echo ' '.$tr;
                      }
                      ?></strong>
                
            </div>
          </div>
       
          <div class="row">
            <div class="col-md-6">
              
                <label class="control-label">Área: </label><strong> &nbsp; <?php echo $area ?></strong>
             
            </div>
            <div class="col-md-4">
              
                 <label class="control-label">Habitación: </label><strong> &nbsp; <?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
                     $result_hab = $conexion->query($sql_hab);
                      while ($row_hab = $result_hab->fetch_assoc()) {
                        echo $row_hab['num_cama'];
                          } ?></strong>
             
            </div>
            <div class="col-md-6">
             
                <label class="control-label">Días de estancia: </label><strong> &nbsp; <?php echo $estancia ?> días</strong>
              
            </div>
            <!-- <div class="col-md-6">
             
                <label class="control-label">DÍAS DE CAMA: </label><strong> &nbsp; <?php// echo $dia_hab ?> días</strong>
              
            </div>   -->     
          </div> 
        </div>
       </div>
      </div>
      <?php
      $id=$_GET['id'];
      $id_atencion=$_GET['id_at'];
      $id_exp=$_GET['id_exp'];
      $usuario1=$_GET['id_usua'];
      $rol=$_GET['rol'];
      $des=$_GET['des'];
      ?>
      <form action="" method="POST">
      <div class="container">
          <div class="card">
  <div class="card-body">
  <h5 class="modal-title">Editar precio de:  <strong><?php echo $des ?></strong></h5><hr>
  <strong>Precio</strong>
  <input type="number" name="precio" class="form-control col-sm-4" min="0" step="0.01" required>
  
  </div>
  <div class="row">
       <div class="col-sm-1">
           </div>
 <div class="col-sm-1">
          <button type="button"class="btn btn-danger btn-sm" onclick="history.back()">Regresar</button>
          </div>
          <div class="col-sm-6">
             <button type="submit"class="btn btn-success btn-sm" name="editar">Guardar</button>
               </div></div><br>
</div>
         
         
      </div>
      
      </form>
      <?php 
      if (isset($_POST['editar'])) {
          $precio=$_POST['precio'];
          $id=$_GET['id'];
      $id_atencion=$_GET['id_at'];
      $id_exp=$_GET['id_exp'];
      $usuario1=$_GET['id_usua'];
      $rol=$_GET['rol'];
      $des=$_GET['des'];
          
$sql2 = "UPDATE dat_ctapac SET cta_tot='$precio' WHERE id_ctapac= $id";

  $result = $conexion->query($sql2);

  if ($result) {
    echo '<script type="text/javascript"> window.location.href="detalle_cuenta.php?id_at=' . $id_atencion . '&id_exp=' . $id_exp . '&id_usua=' . $usuario1 . '&rol=' . $rol . '";</script>';
  } else {
    echo 'ERROR';
  }
        }
      ?>
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