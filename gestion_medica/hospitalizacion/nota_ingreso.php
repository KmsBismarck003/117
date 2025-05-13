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


<style type="text/css">
   
    .modal-lg { max-width: 65% !important; }
</style>
</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 22px;">
<strong><center>NOTA DE INGRESO</center></strong>
</div>

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
      $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by id_ne DESC LIMIT 1";
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
        <div class="col-sm-4">
          Talla: <strong><?php echo $talla ?></strong>
        </div>
        <div class="col-sm-3">
      Área: <strong><?php echo $area ?></strong>
    </div>
      </div>


    </div>
            <?php
          } else {
            echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
          }
            ?>
<form action="insertar_nota_ingreso.php" method="POST">

                <div class="row col-6">
                    <div class="col-sm">
                      
                        <!--<strong>No. Admisión:</strong>-->
                        
                        <input type="hidden" name="id_atencion" class="form-control" value="<?php echo $_SESSION['hospital'] ?>"
                               readonly placeholder="No. De expediente">
                    </div>
                </div>
          
        
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

<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center>
</div>

<div class="container"> 
    <div class="row">
    
    <div class="col-sm-2"><center>Presión arterial:</center>
     <div class="row">
         <div class="col">
            <input type="text" class="form-control" value="<?php echo $f5['p_sistol'];?>" disabled>
         </div> /
         <div class="col">
            <input type="text" class="form-control" value="<?php echo $f5['p_diastol'];?>" disabled>
         </div>
        
    </div> mmHG   /   mmHG
    </div>
    <div class="col-sm-2">
      Frecuencia cardiaca:<input type="text" class="form-control" value="<?php echo $f5['fcard'];?>" disabled> Latidos por minuto
    </div>
    <div class="col-sm-3">
      Frecuencia respiratoria:<input type="text" class="form-control" value="<?php echo $f5['fresp'];?>" disabled> Respiraciones por minuto
    </div>
    <div class="col-sm-2">
     Temperatura:<input type="text" class="form-control" value="<?php echo $f5['temper'];?>" disabled>°C
    </div>
    <div class="col-sm-3">
     Saturación de oxígeno:<input type="text"  class="form-control" value="<?php echo $f5['satoxi'];?>" disabled>%
    </div>
    
  </div>
</div>
<?php }
?>
<?php 
}else{
                        
  ?>

<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center>
</div>

<div class="container"> 
  <div class="row">
    <div class="col-sm-2"><center>Presión arterial:</center>
        <div class="row">
            <div class="col"><input type="text" class="form-control" name="p_sistol" required=""></div> /
            <div class="col"><input type="text" class="form-control" name="p_diastol" required=""></div>
        </div>mmHG   /   mmHG
    </div>
    <div class="col-sm-2">
      Frecuencia cardiaca:<input type="text" class="form-control" name="fcard" required="">
      Latidos por minuto
    </div>
    <div class="col-sm-3">
      Frecuencia respiratoria:<input type="text" class="form-control" name="fresp" required="">
      Respiraciones por minuto
    </div>
    <div class="col-sm-2">
     Temperatura:<input type="text" class="form-control"  name="temper" required="">°C
    </div>
    <div class="col-sm-2">
     Saturación oxígeno:<input type="text"  class="form-control" name="satoxi" required="">%
    </div>
  </div>
</div>

<?php } ?>
 <hr>
<div class="row">

    <div class=" col"> <STRONG>Motivo de ingreso hospitalario:</STRONG><div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone">
</button></i>
       <button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
       <button type="button" class="btn btn-success btn-sm" id="playa"><i class="fas fa-play"></button></i>
      </div>

     <div class="form-group">

    <textarea class="form-control" id="texto" name="mot_ingreso" rows="3" required=""></textarea>
     <script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btnPlayTextmo = document.getElementById('playa');

  btnPlayTextmo.addEventListener('click', () => {
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

    <div class=" col"> <STRONG> Resumen del interrogatorio:</STRONG>
        <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="btns"><i class="fas fa-microphone"></button></i>
       <button type="button" class="btn btn-primary btn-sm" id="btnstop"><i class="fas fa-microphone-slash"></button></i>
       <button type="button" class="btn btn-success btn-sm" id="playinteee"><i class="fas fa-play"></button></i>
      </div>
     <div class="form-group">
    <textarea class="form-control" id="resu" name="resinterr_i" rows="3"  required=""></textarea>
     <script type="text/javascript">
const btns = document.getElementById('btns');
const btnstop = document.getElementById('btnstop');
const resu = document.getElementById('resu');

const btnPlayTexress = document.getElementById('playinteee');

  btnPlayTexress.addEventListener('click', () => {
          leerTexto(resu.value);
  });

  function leerTexto(resu){
      const speech = new SpeechSynthesisUtterance();
      speech.text= resu;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
     let res = new webkitSpeechRecognition();
      res.lang = "es-ES";
      res.continuous = true;
      res.interimResults = false;

      res.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        resu.value += frase;
      }

      btns.addEventListener('click', () => {
        res.start();
      });

      btnstop.addEventListener('click', () => {
        res.abort();
      });
</script>
  </div>
    </div>
</div>
 <div class="row">

    <div class=" col"><STRONG>Exploración física y estado mental:</STRONG>
        <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="grabar"><i class="fas fa-microphone"></button></i>
       <button type="button" class="btn btn-primary btn-sm" id="detener"><i class="fas fa-microphone-slash"></button></i>
       <button type="button" class="btn btn-success btn-sm" id="playmentall"><i class="fas fa-play"></button></i>
      </div>
     <div class="form-group">
    <textarea class="form-control" id="exp" rows="3" name="expfis_i" required=""></textarea>
    <script type="text/javascript">
const grabar = document.getElementById('grabar');
const detener = document.getElementById('detener');
const exp = document.getElementById('exp');

const btnPlayTexppx = document.getElementById('playmentall');

  btnPlayTexppx.addEventListener('click', () => {
          leerTexto(exp.value);
  });

  function leerTexto(exp){
      const speech = new SpeechSynthesisUtterance();
      speech.text= exp;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rese = new webkitSpeechRecognition();
      rese.lang = "es-ES";
      rese.continuous = true;
      rese.interimResults = false;

      rese.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        exp.value += frase;
      }

      grabar.addEventListener('click', () => {
        rese.start();
      });

      detener.addEventListener('click', () => {
        rese.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">

    <div class=" col"><STRONG>Resultado de estudios de los servicios auxiliares de diagnóstico tratamiento:</STRONG>
         <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="bgra"><i class="fas fa-microphone">
</button></i>
       <button type="button" class="btn btn-primary btn-sm" id="bdet"><i class="fas fa-microphone-slash"></button></i>
       <button type="button" class="btn btn-success btn-sm" id="playserv"><i class="fas fa-play"></button></i>
      </div>
     <div class="form-group">
    <textarea class="form-control" id="aux" rows="3" name="resaux_i" required=""></textarea>
    <script type="text/javascript">
const bgra = document.getElementById('bgra');
const bdet = document.getElementById('bdet');
const aux = document.getElementById('aux');

const btnPlayTexuax = document.getElementById('playserv');

  btnPlayTexuax.addEventListener('click', () => {
          leerTexto(aux.value);
  });

  function leerTexto(aux){
      const speech = new SpeechSynthesisUtterance();
      speech.text= aux;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let raux = new webkitSpeechRecognition();
      raux.lang = "es-ES";
      raux.continuous = true;
      raux.interimResults = false;

      raux.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        aux.value += frase;
      }

      bgra.addEventListener('click', () => {
        raux.start();
      });

      bdet.addEventListener('click', () => {
        raux.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">

    <div class=" col-6"><STRONG> <button type="button" class="btn btn-success btn-sm" id="playdia1"><i class="fas fa-play"></button></i> Diagnóstico:</STRONG>
     <div class="form-group">
        <select name="diagprob_i" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%">
            <option value="">Seleccionar</option>
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_diag ORDER by id_cie10";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['diagnostico'] . "'>" . $row['id_cie10'] .' - '. $row['diagnostico'] . "</option>";
}
 ?></select>
  </div>
    </div>
<script type="text/javascript">
const mibuscador = document.getElementById('mibuscador');
const btnPlayTe1 = document.getElementById('playdia1');

  btnPlayTe1.addEventListener('click', () => {
          leerTexto(mibuscador.value);
  });

  function leerTexto(mibuscador){
      const speech = new SpeechSynthesisUtterance();
      speech.text= mibuscador;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

</script>
    <div class="col-6">
<strong>Describir: </strong><button type="button" class="btn btn-danger btn-sm" id="describirdg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopdescri"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playdbir"><i class="fas fa-play"></button></i>
<textarea class="form-control" name="des_diag" id="desgiag"></textarea>
<script type="text/javascript">
const describirdg = document.getElementById('describirdg');
const stopdescri = document.getElementById('stopdescri');
const desgiag = document.getElementById('desgiag');

const btnPlayTedes = document.getElementById('playdbir');

  btnPlayTedes.addEventListener('click', () => {
          leerTexto(desgiag.value);
  });

  function leerTexto(desgiag){
      const speech = new SpeechSynthesisUtterance();
      speech.text= desgiag;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let rdesdi = new webkitSpeechRecognition();
      rdesdi.lang = "es-ES";
      rdesdi.continuous = true;
      rdesdi.interimResults = false;

      rdesdi.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        desgiag.value += frase;
      }

      describirdg.addEventListener('click', () => {
        rdesdi.start();
      });

      stopdescri.addEventListener('click', () => {
        rdesdi.abort();
      });
</script>
</div>
</div>

<div class="row">
    <div class="col"><STRONG>Plan de estudio y/o tratamiento:</STRONG>
        <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="bpg"><i class="fas fa-microphone"></button></i>
       <button type="button" class="btn btn-primary btn-sm" id="bpd"><i class="fas fa-microphone-slash"></button></i>
       <button type="button" class="btn btn-success btn-sm" id="playtrattt"><i class="fas fa-play"></button></i>
      </div>
     <div class="form-group">
    <textarea class="form-control" id="plan" rows="3" name="plan_i"  required=""></textarea>
     <script type="text/javascript">
const bpg = document.getElementById('bpg');
const bpd = document.getElementById('bpd');
const plan = document.getElementById('plan');

const btnPlayTedepl = document.getElementById('playtrattt');

  btnPlayTedepl.addEventListener('click', () => {
          leerTexto(plan.value);
  });

  function leerTexto(plan){
      const speech = new SpeechSynthesisUtterance();
      speech.text= plan;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let fp = new webkitSpeechRecognition();
      fp.lang = "es-ES";
      fp.continuous = true;
      fp.interimResults = false;

      fp.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        plan.value += frase;
      }

      bpg.addEventListener('click', () => {
        fp.start();
      });

      bpd.addEventListener('click', () => {
        fp.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">

    <div class=" col"><STRONG>Pronóstico:</STRONG>
        <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="bgpro"><i class="fas fa-microphone">
</button></i>
       <button type="button" class="btn btn-primary btn-sm" id="bdico"><i class="fas fa-microphone-slash"></button></i>
       <button type="button" class="btn btn-success btn-sm" id="playprotico"><i class="fas fa-play"></button></i>
      </div>
     <div class="form-group">
    <textarea class="form-control" id="ti" rows="3" name="pron_i" required="" ></textarea>
    <script type="text/javascript">
const bgpro = document.getElementById('bgpro');
const bdico = document.getElementById('bdico');
const ti = document.getElementById('ti');

const btnPlayTti = document.getElementById('playprotico');

  btnPlayTti.addEventListener('click', () => {
          leerTexto(ti.value);
  });

  function leerTexto(ti){
      const speech = new SpeechSynthesisUtterance();
      speech.text= ti;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }

     let pron = new webkitSpeechRecognition();
      pron.lang = "es-ES";
      pron.continuous = true;
      pron.interimResults = false;

      pron.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        ti.value += frase;
      }

      bgpro.addEventListener('click', () => {
        pron.start();
      });

      bdico.addEventListener('click', () => {
        pron.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">

    <div class=" col-sm-9">
<strong><button type="button" class="btn btn-success btn-sm" id="playgiiua"><i class="fas fa-play"></button></i> Guía de práctica clínica:</strong>

<div class="form-group">

     <div class="form-group">
        <select name="guia" class="form-control" data-live-search="true" id="mibuscador11" onchange="ShowSelected();" style="width : 100%; heigth : 100%">
            <option value="">Seleccionar guía clínica</option>
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM gpclinica ORDER by id_gpc";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
echo "<option value='" . $row['gpc'] . "'>" . $row['cve_gpc'] . "- " .$row['gpc']."</option>";
}
 ?></select>
  </div>

</div>
</div>
 <script type="text/javascript">
const mibuscador11 = document.getElementById('mibuscador11');
const btnPlay11 = document.getElementById('playgiiua');

  btnPlay11.addEventListener('click', () => {
          leerTexto(mibuscador11.value);
  });

  function leerTexto(mibuscador11){
      const speech = new SpeechSynthesisUtterance();
      speech.text= mibuscador11;
      speech.volume=1;
      speech.rate=1;
      speech.pitch=0;
      window.speechSynthesis.speak(speech);
  }
</script>
<div class="col-sm-3">
<p></p>
<button type="button" class="btn btn bg-navy" data-toggle="modal" data-target=".bd-example-modal-lg"><strong>Links de guía de práctica clínica</strong></button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header content-center">
        <h4><b>Guía de práctica clínica</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
         <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
            </div>
     <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
                    <th scope="col"><center>Clave</center></th>
                    <th scope="col"><center>Guía & Link</center></th>
                </tr>
                </thead>
                <tbody>
<?php
$sql_diag="SELECT * FROM gpclinica ORDER by id_gpc";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){            
    ?>
                    <tr> 
<td class="fondo"><strong><?php echo $row['cve_gpc'];?></strong></td>
<td class="fondo"><a href="<?php echo $row['link']?>" target=”_blank”><strong><?php echo $row['gpc'];?></strong></td></a>   
                    </tr>
                <?php
                }
                ?>
                </tbody>
              
            </table>
            </div>
  </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Regresar</button>
      </div>
    </div>
  </div>
</div>

</div>

</div>
<hr>
<div class="form-group col-12">
<center><button type="submit" class="btn btn-primary">Firmar</button>
<button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button></center>
</div>


<br>
<br>
</form>


   <!--TERMINO DE NOTA DE EVOLUCION-->

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
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
    $(document).ready(function () {
        $('#mibuscador11').select2();
    });
</script>
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

</body>
</html>