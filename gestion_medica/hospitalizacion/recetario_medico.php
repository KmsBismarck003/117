<?php
session_start();


include "../../conexionbd.php";
include("../header_medico.php");
if (isset($_SESSION['hospital'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
    $resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp  WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);
    if (mysqli_num_rows($resultado) > 0) { //se mostrara si existe mas de 1
        $f = mysqli_fetch_row($resultado);

    } else {
        header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
    }
} else {
    header("Location: ./consulta_urgencias.php"); //te regresa a la página principal
}

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


    <title>DATOS NURGEN </title>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
                <hr>
                 <div class="thead col col-12" style="background-color: #2b2d7f; color: white; font-size: 26px; align-content: center;"><strong>RECETARIO MÉDICO</strong></div>
                
<?php

    include "../../conexionbd.php";

    if (isset($_SESSION['hospital'])) {
      $id_atencion = $_SESSION['hospital'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.folio, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
        $folio = $row_pac['folio'];
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
         
  <div class="row">
    <div class="col-sm-2">
      Expediente: <strong><?php echo $folio?> </strong>
    </div>
    <div class="col-sm-6">
     Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm-4">
      Fecha de ingreso: <strong><?php echo date_format($date, "d/m/Y H:i:s") ?></strong>
    </div>
  </div>

     
  <div class="row">
    <div class="col-sm-4">
       <?php $date1 = date_create($pac_fecnac);
   ?>
    <!-- INICIO DE FUNCION DE CALCULAR EDAD -->
<?php 

function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}


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
               if (bisiesto($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
               
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


 ?>
 <!-- TERMINO DE FUNCION DE CALCULAR EDAD -->
      Fecha de nacimiento: <strong><?php echo date_format($date1, "d/m/Y") ?></strong>
    </div>
    <div class="col-sm-4">
      Edad: <strong><?php if($anos > "0" ){
   echo $anos." años";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." meses";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." días";
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
      Días estancia: <strong><?php echo $estancia ?> Dias</strong>
    </div>
  </div>


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

<?php $sql_edo = "SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_edo = $conexion->query($sql_edo);
while ($row_edo = $result_edo->fetch_assoc()) {
  $peso=$row_edo['peso'];
  $talla=$row_edo['talla'];
} 
if (!isset($peso)){
    $peso=0;
    $talla=0;
}?>
 
  <div class="row">
     <div class="col-sm-4">
      Peso: <strong><?php echo $peso ?></strong>
    </div>
    <div class="col-sm-3">
      Talla: <strong><?php echo $talla ?></strong>
    </div>
  </div>


</div>
        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
      }
        ?>

<hr>
</div>
          <form action="insertar_receta.php" method="POST">
<hr>
 
<div class="row">
    <div class=" col">
     <div class="form-group">
        <label><strong><button type="button" class="btn btn-success btn-sm" id="playa"><i class="fas fa-play"></button></i> Alergia a medicamentos : </strong></label>
       
        <input type="text" name="alerg" id="txtpa" class="form-control" value="<?php echo $alergias;?>" disabled> 
  </div>
    </div>
</div>
 <script type="text/javascript">
  const txtpa = document.getElementById('txtpa');
  const btnPlayTexta = document.getElementById('playa');

  btnPlayTexta.addEventListener('click', () => {
          leerTexto(txtpa.value);
  });

  function leerTexto(txtpa){
      const speech = new SpeechSynthesisUtterance();
      speech.text= txtpa;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
  </script>
<?php 
$id_at=$_SESSION['hospital'];
include "../../conexionbd.php";
$resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=$id_at ORDER by id_sig DESC LIMIT 1") or die($conexion->error);

     while ($f5 = mysqli_fetch_array($resultado5)) {
      $atencion=$f5['id_sig'];
    }
if (isset($atencion)) {

include "../../conexionbd.php";
$resultado5=$conexion->query("select * from signos_vitales WHERE id_atencion=$id_at ORDER by id_sig DESC LIMIT 1") or die($conexion->error);
     while ($f5 = mysqli_fetch_array($resultado5)) {
    ?>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
<div class="container"> 
  <div class="row">
    <div class="col-sm-2"><br><center><button type="button" class="btn btn-success btn-sm" id="play2"><i class="fas fa-play"></button></i>Presión arterial:</center>
     <div class="row">
  <div class="col"><input type="text" id="p_sistol" class="form-control" value="<?php echo $f5['p_sistol'];?>" disabled></div> /
  <div class="col"><input type="text" id="p_diastol" class="form-control" value="<?php echo $f5['p_diastol'];?>" disabled></div>
 
</div>
    </div>
 <script type="text/javascript">
  const p_sistol = document.getElementById('p_sistol');
  const btn1 = document.getElementById('play2');

  btn1.addEventListener('click', () => {
          leerTexto(p_sistol.value);
  });

  function leerTexto(p_sistol){
      const speech = new SpeechSynthesisUtterance();
      speech.text= p_sistol;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

   const p_diastol = document.getElementById('p_diastol');
  const btn2 = document.getElementById('play2');

  btn2.addEventListener('click', () => {
          leerTexto(p_diastol.value);
  });

  function leerTexto(p_diastol){
      const speech = new SpeechSynthesisUtterance();
      speech.text= p_diastol;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
  </script>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="play3"><i class="fas fa-play"></button></i> Frecuencia cardiaca:<input type="text" id="fcard" class="form-control" value="<?php echo $f5['fcard'];?>" disabled>
    </div>
<script type="text/javascript">
  const fcard = document.getElementById('fcard');
  const btn3 = document.getElementById('play3');

  btn3.addEventListener('click', () => {
          leerTexto(fcard.value);
  });

  function leerTexto(fcard){
      const speech = new SpeechSynthesisUtterance();
      speech.text= fcard;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
  </script>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="play4"><i class="fas fa-play"></button></i> Frecuencia Respiratoria:<input type="text" id="fresp" class="form-control" value="<?php echo $f5['fresp'];?>" disabled>
    </div>
<script type="text/javascript">
  const fresp = document.getElementById('fresp');
  const btn4 = document.getElementById('play4');

  btn4.addEventListener('click', () => {
          leerTexto(fresp.value);
  });

  function leerTexto(fresp){
      const speech = new SpeechSynthesisUtterance();
      speech.text= fresp;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
  </script>
    <div class="col-sm-2">
     <br><button type="button" class="btn btn-success btn-sm" id="play5"><i class="fas fa-play"></button></i> Temperatura:<input type="text" id="temper" class="form-control" value="<?php echo $f5['temper'];?>" disabled>
    </div>
<script type="text/javascript">
  const temper = document.getElementById('temper');
  const btn5 = document.getElementById('play5');

  btn5.addEventListener('click', () => {
          leerTexto(temper.value);
  });

  function leerTexto(temper){
      const speech = new SpeechSynthesisUtterance();
      speech.text= temper;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
  </script>
    <div class="col-sm-2">
    <button type="button" class="btn btn-success btn-sm" id="play6"><i class="fas fa-play"></button></i> Saturación oxígeno:<input type="text" id="satoxi" class="form-control" value="<?php echo $f5['satoxi'];?>" disabled>
    </div>
<script type="text/javascript">
  const satoxi = document.getElementById('satoxi');
  const btn6 = document.getElementById('play6');

  btn6.addEventListener('click', () => {
          leerTexto(satoxi.value);
  });

  function leerTexto(satoxi){
      const speech = new SpeechSynthesisUtterance();
      speech.text= satoxi;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
  </script>
    <div class="col-sm-1">
     <button type="button" class="btn btn-success btn-sm" id="play7"><i class="fas fa-play"></button></i> Peso:<input type="text" class="form-control" id="peso" value="<?php echo $f5['peso'];?>" disabled>
    </div>
<script type="text/javascript">
  const peso = document.getElementById('peso');
  const btn7 = document.getElementById('play7');

  btn7.addEventListener('click', () => {
          leerTexto(peso.value);
  });

  function leerTexto(peso){
      const speech = new SpeechSynthesisUtterance();
      speech.text= peso;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
  </script>
    <div class="col-sm-1">
    <button type="button" class="btn btn-success btn-sm" id="play8"><i class="fas fa-play"></button></i>Talla:<input type="text" class="form-control" id="talla" value="<?php echo $f5['talla'];?>" disabled>
    </div>
  </div>
</div>
<script type="text/javascript">
  const talla = document.getElementById('talla');
  const btn8 = document.getElementById('play8');

  btn8.addEventListener('click', () => {
          leerTexto(talla.value);
  });

  function leerTexto(talla){
      const speech = new SpeechSynthesisUtterance();
      speech.text= talla;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
  </script>
<?php }} ?><br>
<div class="row">
    <div class=" col">
     <div class="form-group">
        Receta
        <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play9"><i class="fas fa-play"></button></i>
</div> 
    <textarea class="form-control" id="texto" rows="25" name="receta"></textarea>
    <script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btn9 = document.getElementById('play9');

  btn9.addEventListener('click', () => {
          leerTexto(texto.value);
  });

  function leerTexto(texto){
      const speech = new SpeechSynthesisUtterance();
      speech.text= texto;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

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
    </div>
</div>
<div class="row">
    <div class=" col">
     <div class="form-group">
        <label><strong><button type="button" class="btn btn-success btn-sm" id="play10"><i class="fas fa-play"></button></i> Medidas Higiénicas-dietéticas : </strong></label>
        <input type="text" name="medi" id="medi" class="form-control">
  </div>
    </div>
</div>
  <script type="text/javascript">
const medi = document.getElementById('medi');

const btn10 = document.getElementById('play10');

  btn10.addEventListener('click', () => {
          leerTexto(medi.value);
  });

  function leerTexto(medi){
      const speech = new SpeechSynthesisUtterance();
      speech.text= medi;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

</script>
<strong><label> Fecha y hora de próxima cita</label></strong>
<div class="row">
    <div class="col-sm-4">
        <input type="date" name="fec_pcita" class="form-control" required="">
    </div>
    <div class="col-sm-4">
        <input type="time" name="hor_pcita" class="form-control">
    </div>
</div>
<?php  
$usuario = $_SESSION['login'];
//$resultado = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='" . $usuario . "'") or die($conexion->error);
?>
<hr>

  <div class="row">
    <div class="col align-self-start">
   <strong><button type="button" class="btn btn-success btn-sm" id="play11"><i class="fas fa-play"></button></i> Médico:</strong> 
   <input type="text" name="" class="form-control" value="<?php echo $usuario['nombre'];?> <?php echo $usuario['papell'];?> <?php echo $usuario['sapell'];?>" disabled id="medicon"> 
    </div>
 <script type="text/javascript">
const medicon = document.getElementById('medicon');

const btn11 = document.getElementById('play11');

  btn11.addEventListener('click', () => {
          leerTexto(medicon.value);
  });

  function leerTexto(medicon){
      const speech = new SpeechSynthesisUtterance();
      speech.text= medicon;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
    <div class="col align-self-center">
      <strong><button type="button" class="btn btn-success btn-sm" id="play12"><i class="fas fa-play"></button></i> Cedula profesional:</strong><input type="text" name="" class="form-control" value="<?php echo $usuario['cedp'];?>" disabled="" id="cedpro">
    </div>
<script type="text/javascript">
const cedpro = document.getElementById('cedpro');

const btn12 = document.getElementById('play12');

  btn12.addEventListener('click', () => {
          leerTexto(cedpro.value);
  });

  function leerTexto(cedpro){
      const speech = new SpeechSynthesisUtterance();
      speech.text= cedpro;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
    <div class="col align-self-end">
     <strong><button type="button" class="btn btn-success btn-sm" id="play13"><i class="fas fa-play"></button></i> Reg S.S.A:</strong><input type="text" name="reg_ssa" id="reg_ssa" class="form-control"> 
    </div>
  </div><br>
  <script type="text/javascript">
const reg_ssa = document.getElementById('reg_ssa');

const btn13 = document.getElementById('play13');

  btn13.addEventListener('click', () => {
          leerTexto(reg_ssa.value);
  });

  function leerTexto(reg_ssa){
      const speech = new SpeechSynthesisUtterance();
      speech.text= reg_ssa;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
<center><strong>Firma:<br></strong><img src="../../imgfirma/<?php echo $usuario['firma']; ?>" width="100" /></center>
<hr>
<div class="container">
  <div class="row">
    <div class="col align-self-start">
    </div>
     <button type="submit" class="btn btn-primary">Firmar y guardar</button> &nbsp;
<button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
    <div class="col align-self-end">
    </div>
  </div>
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