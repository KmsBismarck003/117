<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");
$usuario = $_SESSION['login'];
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

    <title>NOTA ANESTESICA </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
           <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>REGISTRO DESCRIPTIVO TRANS-ANESTÉSICO</center></strong>
</div>
                <hr>
<?php

    include "../../conexionbd.php";

    if (isset($_SESSION['hospital'])) {
      $id_atencion = $_SESSION['hospital'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
        $pac_tip_sang = $row_pac['tip_san'];
        $pac_sexo = $row_pac['sexo'];
        $area = $row_pac['area'];
        $alta_med = $row_pac['alta_med'];
        $id_exp = $row_pac['Id_exp'];
        $alergias = $row_pac['alergias'];
      }

      $sql_now = "SELECT DATE_ADD(NOW(), INTERVAL 12 HOUR) as dat_now FROM dat_ingreso WHERE id_atencion = $id_atencion";

      $result_now = $conexion->query($sql_now);

      while ($row_now = $result_now->fetch_assoc()) {
        $dat_now = $row_now['dat_now'];
      }

      $sql_est = "SELECT DATEDIFF( '$dat_now' , fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
        $estancia = $row_est['estancia'];
      }


    ?>
 <font size="2">
         
  <div class="row">
    <div class="col-sm-2">
      Expediente: <strong><?php echo $id_exp?> </strong>
    </div>
    <div class="col-sm-6">
     Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm-4">
      Fecha de ingreso: <strong><?php echo date_format($date, "d-m-Y H:i:s") ?></strong>
    </div>
  </div>
</font>
 <font size="2">
     
  <div class="row">
    <div class="col-sm-4">
       <?php $date1 = date_create($pac_fecnac);
   ?>
    <!-- INICIO DE FUNCION DE CALCULAR EDAD -->
<?php 

$fecha_actual = date("Y-m-d");
$fecha_nac=$pac_fecnac;
$fecha_de_nacimiento =strval($fecha_nac);

// separamos en partes las fechas
$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
$array_actual = explode ( "-", $fecha_actual );

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

//ajuste de posible negativo en $días
if ($dias < 0)
{
    --$meses;

    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
    switch ($array_actual[1]) {
           case 1:     $dias_mes_anterior=31; break;
           case 2:     $dias_mes_anterior=31; break;
           case 3: 
               
                    $dias_mes_anterior=28; break;
               
           case 4:     $dias_mes_anterior=31; break;
           case 5:     $dias_mes_anterior=30; break;
           case 6:     $dias_mes_anterior=31; break;
           case 7:     $dias_mes_anterior=30; break;
           case 8:     $dias_mes_anterior=31; break;
           case 9:     $dias_mes_anterior=31; break;
           case 10:     $dias_mes_anterior=30; break;
           case 11:     $dias_mes_anterior=31; break;
           case 12:     $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

//echo "<br>Tu edad es: $anos años con $meses meses y $dias días";

function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}

 ?>
 <!-- TERMINO DE FUNCION DE CALCULAR EDAD -->
      Fecha de nacimiento: <strong><?php echo date_format($date1, "d-m-Y") ?></strong>
    </div>
    <div class="col-sm-4">
      Edad: <strong><?php if($anos > "0" ){
   echo $anos." años";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." meses";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." dias";
}
?></strong>
    </div>
    
   
      <div class="col-sm-2">
      Habitación: <strong><?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);                                                                                    while ($row_hab = $result_hab->fetch_assoc()) {
  echo $row_hab['num_cama'];
} ?></strong>
    </div>
    
  </div>

</font>
 <font size="2">
  <div class="row">
<?php
$d="";
 $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by diagprob_i ASC LIMIT 1";
$result_motd = $conexion->query($sql_motd);
while ($row_motd = $result_motd->fetch_assoc()) {
    $d=$row_motd['diagprob_i'];
} ?>
<?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
$result_mot = $conexion->query($sql_mot);
while ($row_mot = $result_mot->fetch_assoc()) {
$m=$row_mot['motivo_atn'];
} ?>

<?php if ($d!=null) {
   echo '<div class="col-sm-8"> Diagnóstico: <strong>' . $d .'</strong></div>';
} else{
      echo '<div class="col-sm-8"> Motivo de atención: <strong>' . $m .'</strong></div>';
}?>
    <div class="col-sm">
      Tiempo estancia: <strong><?php echo $estancia ?> Dias</strong>
    </div>
  </div>

</font>
 <font size="2">
  <div class="row">
    <div class="col-sm-4">
      Alergias: <strong><?php echo $alergias ?></strong>
    </div>
     <div class="col-sm-4">
      Estado de salud: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud ASC LIMIT 1";
$result_edo = $conexion->query($sql_edo);while ($row_edo = $result_edo->fetch_assoc()) {
  echo $row_edo['edo_salud'];
} ?></strong>
    </div>
    <div class="col-sm-3">
      Tipo de sangre: <strong><?php echo $pac_tip_sang ?></strong>
    </div>
  </div>
</font>
<?php $sql_edo = "SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_edo = $conexion->query($sql_edo);
while ($row_edo = $result_edo->fetch_assoc()) {
  $peso=$row_edo['peso'];
  $talla=$row_edo['talla'];
} if (!isset($peso)){
    $peso=0;
    $talla=0;
}?>
 <font size="2">
  <div class="row">
     <div class="col-sm-4">
      Peso: <strong><?php echo $peso ?></strong>
    </div>
    <div class="col-sm-3">
      Talla: <strong><?php echo $talla ?></strong>
    </div>
  </div>
</font>
<hr>
</div>
        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
      }
        ?>
      <div class="container">  <!--INICIO DE CONSULTA DE URGENCIAS-->

<form action="insertar_trans_anest.php" method="POST">
<div class="row">
  <div class="col">
    <strong>Anestesiólogo</strong> <input type="text" name="anest" class="form-control" required>
  </div>
  <?php

$resultado2 = $conexion->query("select * from dat_not_preop WHERE id_atencion=" .$_SESSION['hospital']." order by id_not_preop DESC LIMIT 1") or die($conexion->error);

?>
  <?php
                    while ($f2 = mysqli_fetch_array($resultado2)) {

                        ?>

  
  <?php } ?>
    <?php

$resultado2 = $conexion->query("select * from dat_not_inquir WHERE id_atencion=" .$_SESSION['hospital']." order by id_not_inquir DESC LIMIT 1") or die($conexion->error);

?>
  <?php
                    while ($f2 = mysqli_fetch_array($resultado2)) {

                        ?>
                        <div class="col">
    <strong>Diagnóstico post-operatorio</strong> <input type="text" name="diagposto" class="form-control" required value=" <?php echo $f2['diag_preop'];?>" disabled>
  </div>
  <div class="col">
    <strong>Cirugía realizada</strong> <input type="text" name="opreal" class="form-control" required value=" <?php echo $f2['cir_realizada'];?>" disabled>
  </div>
<?php } ?>
</div><hr>
<div class="row">
  <div class="col">
    <strong>Anestesia realizada</strong> <input type="text" name="anestreal" class="form-control" required>
  </div>
  <div class="col">
    <strong>Posición y cuidados</strong> <input type="text" name="poscui" class="form-control" required>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-10">
    <strong>Inducción</strong> <input type="text" name="ind" class="form-control">
  </div>
  <div class="col-2">
    <strong>Hora:</strong> <input type="time" name="hora" class="form-control" required >
  </div>
</div>
<div class="row">
  <div class="col">
    <strong>Agentes y dosis</strong> <input type="text" name="agdo" class="form-control" >
  </div>
</div>
<hr>
<center><h6><strong>Vía aerea</strong></h6></center>
<div class="row">
  <div class="col">
    <strong>Intubación</strong> <input type="text" name="in" class="form-control">
  </div>
   <div class="col">
    <strong>Mascarilla</strong> <input type="text" name="masc" class="form-control">
  </div>
</div>
<div class="row">
  <div class="col">
    <strong>Cánula</strong> <input type="text" name="can" class="form-control">
  </div>
  <div class="col">
    <strong>Otro:</strong> <input type="text" name="otro" class="form-control">
  </div>
</div>
 <strong>Laringoscopia:</strong> <input type="text" name="larin" class="form-control"><hr>
<div class="row">
  <div class="col">
    <strong>Ventilación</strong> <input type="text" name="venti" class="form-control">
  </div>
  <div class="col">
    <strong>Circuito:</strong> <input type="text" name="cir" class="form-control">
  </div>
  <div class="col"><br>
   <div class="form-check">
  <input class="form-check-input" type="radio" name="esasme" id="es" value="ESPONTANEA">
  <label class="form-check-label" for="es">
    Espontánea
  </label>
</div>
  </div>
  <div class="col"><br>
   <div class="form-check">
  <input class="form-check-input" type="radio" name="esasme" id="as" value="ASISTIDA">
  <label class="form-check-label" for="as">
    Asistida
  </label>
</div>
  </div>
  <div class="col"><br>
   <div class="form-check">
  <input class="form-check-input" type="radio" name="esasme" id="me" value="MECANICA">
  <label class="form-check-label" for="me">
    Mecánica
  </label>
</div>
  </div>
</div>


<hr>
<div class="row">
  <div class="col">
     <strong>Mecánica:</strong> <input type="text" name="mec" class="form-control">
  </div>
   <div class="col">
     <strong>Modo:</strong> <input type="text" name="modo" class="form-control">
  </div>
   <div class="col">
     <strong>FI O2</strong> <input type="text" name="fl" class="form-control">
  </div>
   <div class="col">
     <strong>V.Corriente</strong> <input type="text" name="vcor" class="form-control">
  </div>
   <div class="col">
     <strong>FR</strong> <input type="text" name="fr" class="form-control">
  </div>
   <div class="col">
     <strong>REL. I:E</strong> <input type="text" name="rel" class="form-control">
  </div>
   <div class="col">
     <strong>PEEP</strong> <input type="text" name="peep" class="form-control">
  </div>
</div><br>
 <strong>Comentarios:</strong> <input type="text" name="com" class="form-control">
<hr>
<div class="form-group"><strong>Mantenimiento:</strong>
  <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
</div> 
<textarea class="form-control"  id="texto" name="mant" rows="2"></textarea>
<script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

     let recognition = new webkitSpeechRecognition();
      recognition.lang = "es-ES";
      recognition.continuous = true;
      recognition.interimResults = false;

      recognition.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        texto.value += frase;
      }

      btnStartRecord.addEventListener('click', () => {
        recognition.start();
      });

      btnStopRecord.addEventListener('click', () => {
        recognition.abort();
      });
</script>
  </div>
  <hr>

<div class="row"><strong>Relajación muscular:</strong>
  <div class="col-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="relaj" id="no" value="NO" >
  <label class="form-check-label" for="no">
    No
  </label>
</div>
  </div>
   <div class="col-1">
     <div class="form-check">
  <input class="form-check-input" type="radio" name="relaj" id="si" value="SI" >
  <label class="form-check-label" for="si">
    Si
  </label>
</div>
  </div>
   <div class="col">
 <strong>Agentes:</strong> <input type="text" name="agent" class="form-control">
  </div>
   <div class="col">
 <strong>Dosis total:</strong> <input type="text" name="dosis" class="form-control">
  </div>
   <div class="col">
     <strong>Última dosis:</strong> <input type="text" name="ultdosis" class="form-control">
  </div>
</div>
<br>
<div class="row"><strong>Antagonismo:</strong>
  <div class="col-1">
     <div class="form-check">
  <input class="form-check-input1" type="radio" name="ant" id="no" value="NO" >
  <label class="form-check-label1" for="no">
    No
  </label>
</div>
  </div>
   <div class="col-1">
     <div class="form-check">
  <input class="form-check-input1" type="radio" name="ant" id="si" value="SI" >
  <label class="form-check-label1" for="si">
    Si
  </label>
</div>
  </div>
   <div class="col">
 <strong>Agente y dosis:</strong> <input type="text" name="agdos" class="form-control">
  </div>
  <strong>Monitoreo(opcional):</strong>
   <div class="col-1">
  <div class="form-check">
  <input class="form-check-input2" type="radio" name="monit" id="si" value="SI" >
  <label class="form-check-label2" for="si">
    Si
  </label>
</div>
  </div>
   <div class="col-1">
      <div class="form-check">
  <input class="form-check-input2" type="radio" name="monit" id="si" value="NO" >
  <label class="form-check-label2" for="si">
    No
  </label>
</div>
  </div>
  
</div>
<div class="row">
<strong>Comentarios:</strong> <input type="text" name="comen" class="form-control" >
</div>
  <hr>
<strong>Anestesia regional</strong><br><br>
  <div class="row">
    <div class="col-4">
      <div class="col">Bloqueo <input type="text" name="bloq" class="form-control"></div>
      <div class="col">Técnica <input type="text" name="tec" class="form-control"></div>
      <div class="col">Posición <input type="text" name="posi" class="form-control"></div>
      <div class="col">Asep y antisep <input type="text" name="asep" class="form-control"></div>
      <div class="col">Aguja <input type="text" name="aguja" class="form-control"></div>
      <hr>
<div class="col"> B.Simpático <input type="text" name="bsim" class="form-control"></div>
<div class="col"> B.Motor <input type="text" name="bmotor" class="form-control"></div>
    </div>
    <div class="col-3">
      <div class="col">Agentes y dosis <input type="text" name="agdosi" class="form-control"></div>
      <div class="col">Catéter <input type="text" name="cate" class="form-control"></div>
      <div class="col">Latencia <input type="text" name="lat" class="form-control"></div>
      <div class="col">Difusión <input type="text" name="dif" class="form-control"></div>
      <br><br><br><BR>
<div class="col">B. Sensitivo <input type="text" name="bsen" class="form-control"></div>
    </div>
    <div class="col-5">
      <center><strong>Datos del producto / caso obstétrico</strong></center>
      <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="datg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="casos"><i class="fas fa-microphone-slash"></button></i>
</div> 
      <div class="form-group">
<textarea class="form-control" name="caso" id="txtcas"  rows="18"></textarea>
<script type="text/javascript">
const datg = document.getElementById('datg');
const casos = document.getElementById('casos');
const txtcas = document.getElementById('txtcas');

     let redlp = new webkitSpeechRecognition();
      redlp.lang = "es-ES";
      redlp.continuous = true;
      redlp.interimResults = false;

      redlp.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtcas.value += frase;
      }

      datg.addEventListener('click', () => {
        redlp.start();
      });

      casos.addEventListener('click', () => {
        redlp.abort();
      });
</script>
  </div>
    </div>
  </div>

<div class="col-7"> <strong>Comentarios</strong> <input type="text" name="coment" class="form-control"></div>
<hr>
<div class="col">
<div class="form-group"><strong>Emersión:</strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="emerg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="sionst"><i class="fas fa-microphone-slash"></button></i>
</div> 
<textarea class="form-control" name="emer"  id="txteme" rows="2"></textarea>
<script type="text/javascript">
const emerg = document.getElementById('emerg');
const sionst = document.getElementById('sionst');
const txteme = document.getElementById('txteme');

     let erre = new webkitSpeechRecognition();
      erre.lang = "es-ES";
      erre.continuous = true;
      erre.interimResults = false;

      erre.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txteme.value += frase;
      }

      emerg.addEventListener('click', () => {
        erre.start();
      });

      sionst.addEventListener('click', () => {
        erre.abort();
      });
</script>
  </div>
</div>
  <hr>




 
<center>
                       <div class="form-group col-6">
                            <button type="submit" class="btn btn-primary">Firmar y guardar</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
                        </div>
</center>
                        <br>
                        
                        </form>
</div> <!--TERMINO DE NOTA MEDICA div container-->


                      
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