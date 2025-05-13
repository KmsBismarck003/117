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


    <title>DATOS NURGEN </title>
    <style type="text/css">
    #contenido{
        display: none;
    }
    .modal-lg { max-width: 65% !important; }
</style>

</head>
<?php if(isset($_SESSION['hospital'])){ ?>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
             
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 22px;">
  <strong><center>CONSULTA</center></strong>
</div>
             
<?php

include "../../conexionbd.php";

 $id_atencion = $_SESSION['hospital'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.folio, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, di.activo, p.sexo, di.alergias FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
        $activo = $row_pac['activo'];
      }

      if ($activo === 'SI') {
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
      }
      else {
          $sql_est = "SELECT DATEDIFF(fec_egreso, fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";
          $result_est = $conexion->query($sql_est);
          while ($row_est = $result_est->fetch_assoc()) {
            if($row_est['estancia']==0){
               $estancia = $row_est['estancia']+1;
            }else{
              $estancia = $row_est['estancia'];
            }
          }
      }

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);

while ($f1 = mysqli_fetch_array($resultado1)) {
$area=$f1['area'];
$pac_fecnac=$f1['fecnac'];

 ?>
<div class="container">
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
$result_hab = $conexion->query($sql_hab);                                                                                    
while ($row_hab = $result_hab->fetch_assoc()) {
  $cama = $row_hab['num_cama'];
  echo $cama;
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
<?php $sql_mot = "SELECT motivo_recepcion from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_recepcion ASC LIMIT 1";
$result_mot = $conexion->query($sql_mot);
while ($row_mot = $result_mot->fetch_assoc()) {
$m=$row_mot['motivo_recepcion'];
} ?>

<?php if ($d!=null) {
   echo '<div class="col-sm-8"> Diagnóstico: <strong>' . $d .'</strong></div>';
} else{
      echo '<div class="col-sm-8"> Motivo de atención: <strong>' . $m .'</strong></div>';
}?>


    
  </div>


  <div class="row">
    <div class="col-sm-4">
      Alergias: <strong><?php echo $alergias ?></strong>
    </div>
  </div>

    
  </div>
</div>

    <?php  
    }
    ?>             
                        
</div>
    
    <form action="insertar_consulta.php?id_usua=<?php echo $usuario['id_usua'] ?>" method="POST">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10" id="colocacion">
                <?php $id_a=$_GET['id_atencion'];?>
                <!--FOLIO DE ADMISIÓN:-->
                <input type="hidden" name="id_atencion" class="form-control" value="<?php echo $id_a?>" readonly  placeholder="Folio de admisión" >
            </div>
        </div>


        <div class="form-group">
            <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
                <center><strong>SIGNOS VITALES</strong></center>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <strong><center><button type="button" class="btn btn-success btn-sm" id="play31">
                    <i class="fas fa-play"></button></i>Presión <br>arterial:</center></strong>
                    <div class="row">
                        <div class="col">
                            <input type="number" name="p_sistolica" id="p_sistolica" class="form-control" value="" min="0"  max="250" required>
                        </div> /
                        <div class="col"> 
                        <input type="number" name="p_diastolica" id="p_diastolica" class="form-control" value="" min="0" max="180" required>
                        </div>
                    </div>
                </div>
                
                <script type="text/javascript">
                    const pre3 = document.getElementById('pre3');
                    const btn32 = document.getElementById('play31');

                    btn32.addEventListener('click', () => {
                    leerTexto(pre3.value);
                    });

                    function leerTexto(pre3){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= pre3;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }

                    const dias34 = document.getElementById('dias34');
                    const btn33 = document.getElementById('play31');

                    btn33.addEventListener('click', () => {
                    leerTexto(dias34.value);
                    });

                    function leerTexto(dias34){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= dias34;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }
                </script>
  
                <div class="col-sm-2"><strong><button type="button" class="btn btn-success btn-sm" id="play32"><i class="fas fa-play"></button></i> Frecuencia <br>cardiaca:</strong>
                    <input type="number" name="f_card" placeholder="" id="f_card" class="form-control" value="" min="0" max="250" required>  
                </div>
                
                <script type="text/javascript">
                    const fcar3 = document.getElementById('fcar3');
                    const btn34 = document.getElementById('play32');
                    btn34.addEventListener('click', () => {
                    leerTexto(fcar3.value);
                    });
                    function leerTexto(fcar3){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= fcar3;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }
                </script>
                
                <div class="col-sm"><strong><button type="button" class="btn btn-success btn-sm" id="play33"><i class="fas fa-play"></button></i> Frecuencia <br>respiratoria:</strong>
                    <input type="number" name="f_resp" placeholder="" id="f_resp" min="0" max="100" class="form-control" value="" required>
                </div>
                <script type="text/javascript">
                    const fresp4 = document.getElementById('fresp4');
                    const btn35 = document.getElementById('play33');
                    btn35.addEventListener('click', () => {
                    leerTexto(fresp4.value);
                    });
                    function leerTexto(fresp4){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= fresp4;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }
                </script>
                
                <div class="col-sm">
                    <br>
                    <strong><button type="button" class="btn btn-success btn-sm" id="play34"><i class="fas fa-play"></button></i> Temperatura:</strong>
                    
                    <input type="cm-number" name="temp" val placeholder="" id="temp" class="form-control" value="" min="34" max="50"required>
                    
                </div>
                <script type="text/javascript">
                    const temp45 = document.getElementById('temp45');
                    const btn36 = document.getElementById('play34');
                    btn36.addEventListener('click', () => {
                    leerTexto(temp45.value);
                    });
                    function leerTexto(temp45){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= temp45;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }
                </script>
                
                 <div class="col-sm"> <strong><button type="button" class="btn btn-success btn-sm" id="play35"><i class="fas fa-play"></button></i> Satutación <br>oxígeno:</strong>
                    <input type="number" name="sat_oxigeno" placeholder="" min="0" max="100" id="sat_oxigeno" class="form-control" value="" required>
                </div>
                <script type="text/javascript">
                    const sato6 = document.getElementById('sato6');
                    const btn37 = document.getElementById('play35');
                    btn37.addEventListener('click', () => {
                    leerTexto(sato6.value);
                    });
                    function leerTexto(sato6){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= sato6;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }
                </script>
                
            </div>
        </div>

        <div container>
            <br>
    
            <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
                <tr><strong> SUBJETIVO: </strong>
            </div>
            <p>
            <div class="row">
                <div class="col-sm">
                    <strong> Describir la sintomatología del paciente, hábitos, a qué atribuye el padecimiento actual, etc.:</strong>
                    <div class="botones">
                        <button type="button" class="btn btn-danger btn-sm" id="hfg"><i class="fas fa-microphone"></button></i>
                        <button type="button" class="btn btn-primary btn-sm" id="stopahf"><i class="fas fa-microphone-slash"></button></i>
                        <button type="button" class="btn btn-success btn-sm" id="play14"><i class="fas fa-play"></button></i>
                    </div>
                    <textarea name="subjetivo" class="form-control" id="txtfanher"></textarea>
                    <script type="text/javascript">
                        const hfg = document.getElementById('hfg');
                        const stopahf = document.getElementById('stopahf');
                        const txtfanher = document.getElementById('txtfanher');
                        const btn15 = document.getElementById('play14');
                        btn15.addEventListener('click', () => {
                        leerTexto(txtfanher.value);
                        });
                        function leerTexto(txtfanher){
                            const speech = new SpeechSynthesisUtterance();
                            speech.text= txtfanher;
                            speech.volume=1;
                            speech.rate=1;
                            speech.pitch=0;
                            window.speechSynthesis.speak(speech);
                        }
                        let rahmres = new webkitSpeechRecognition();
                        rahmres.lang = "es-ES";
                        rahmres.continuous = true;
                        rahmres.interimResults = false;
                        rahmres.onresult = (event) => {
                        const results = event.results;
                        const frase = results[results.length -1][0].transcript;
                        txtfanher.value += frase;
                        }
                        hfg.addEventListener('click', () => {
                        rahmres.start();
                        });
                        stopahf.addEventListener('click', () => {
                        rahmres.abort();
                        });
                    </script>  
                </div>
            </div>
            <br>
            
            <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
                <tr><strong>OBJETIVO:</strong>
            </div>
            <p>
            <div class="form-group">
                <label for="exampleFormControlTextarea1"><strong>Describir la exploración física:</strong></label>
                <div class="botones">
                    <button type="button" class="btn btn-danger btn-sm" id="otrosg"><i class="fas fa-microphone"></button></i>
                    <button type="button" class="btn btn-primary btn-sm" id="detan"><i class="fas fa-microphone-slash"></button></i>
                    <button type="button" class="btn btn-success btn-sm" id="play15"><i class="fas fa-play"></button></i>
                </div>
                <textarea name="objetivo" class="form-control" id="txtno" rows="3" ></textarea>
                <script type="text/javascript">
                    const otrosg = document.getElementById('otrosg');
                    const detan = document.getElementById('detan');
                    const txtno = document.getElementById('txtno');
                    const btn16 = document.getElementById('play15');
                    btn16.addEventListener('click', () => {
                    leerTexto(txtno.value);
                    });
                    function leerTexto(txtno){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= txtno;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }
                    let ro = new webkitSpeechRecognition();
                    ro.lang = "es-ES";
                    ro.continuous = true;
                    ro.interimResults = false;
                    ro.onresult = (event) => {
                    const results = event.results;
                    const frase = results[results.length -1][0].transcript;
                    txtno.value += frase;
                    }
                    otrosg.addEventListener('click', () => {
                    ro.start();
                    });
                    detan.addEventListener('click', () => {
                    ro.abort();
                    });
                </script>  
            </div>

            <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
                <tr><strong>ANÁLISIS:</strong>
            </div>
            <p>
            <div class="form-group">
                <label for="exampleFormControlTextarea1"><strong>Describir los diagnósticos probables y definitivos y los argumentos, correlación de los estudios de laboratorio y gabinete con el padecimiento actual:</strong></label>
                <div class="botones">
                    <button type="button" class="btn btn-danger btn-sm" id="quirg"><i class="fas fa-microphone"></button></i>
                    <button type="button" class="btn btn-primary btn-sm" id="deos"><i class="fas fa-microphone-slash"></button></i>
                    <button type="button" class="btn btn-success btn-sm" id="play16"><i class="fas fa-play"></button></i>
                </div>
                <textarea name="analisis" class="form-control" id="txtir" rows="3" ></textarea>
                <script type="text/javascript">
                    const quirg = document.getElementById('quirg');
                    const deos = document.getElementById('deos');
                    const txtir = document.getElementById('txtir');
                    const btn17 = document.getElementById('play16');
                    btn17.addEventListener('click', () => {
                    leerTexto(txtir.value);
                    });
                    function leerTexto(txtir){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= txtir;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }
                    let rq = new webkitSpeechRecognition();
                    rq.lang = "es-ES";
                    rq.continuous = true;
                    rq.interimResults = false;
                    rq.onresult = (event) => {
                    const results = event.results;
                    const frase = results[results.length -1][0].transcript;
                    txtir.value += frase;
                    }
                    quirg.addEventListener('click', () => {
                    rq.start();
                    });
                    deos.addEventListener('click', () => {
                    rq.abort();
                    });
                </script> 
            </div>

            <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
                <tr><strong>PLAN: </strong>
            </div>
            <p>
            <div class="form-group">
                <label for="txttu"><strong>Describir tratamiento y recomendaciones indicadas al paciente, anotar los medicamentos con su dosis de manera detallada:</strong></label>
                <div class="botones">
                    <button type="button" class="btn btn-danger btn-sm" id="padeg"><i class="fas fa-microphone"></button></i>
                    <button type="button" class="btn btn-primary btn-sm" id="detapt"><i class="fas fa-microphone-slash"></button></i>
                    <button type="button" class="btn btn-success btn-sm" id="play19"><i class="fas fa-play"></button></i>
                </div>
                <textarea name="plan" class="form-control" id="txttu" rows="3" ></textarea>
                <script type="text/javascript">
                    const padeg = document.getElementById('padeg');
                    const detapt = document.getElementById('detapt');
                    const txttu = document.getElementById('txttu');
                    const btn20 = document.getElementById('play19');
                    btn20.addEventListener('click', () => {
                    leerTexto(txttu.value);
                    });
                    function leerTexto(txttu){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= txttu;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }
                    let repac = new webkitSpeechRecognition();
                    repac.lang = "es-ES";
                    repac.continuous = true;
                    repac.interimResults = false;
                    repac.onresult = (event) => {
                    const results = event.results;
                    const frase = results[results.length -1][0].transcript;
                    txttu.value += frase;
                    }
                    padeg.addEventListener('click', () => {
                    repac.start();
                    });
                    detapt.addEventListener('click', () => {
                    repac.abort();
                    });
                </script> 
            </div>
            
            <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
                <tr><strong>PRONÓSTICO: </strong>
            </div>
            <p>
            <div class="form-group">
                <label for="txtapo"><strong>Pronósticos para la vida y para la función:</strong></label>
                <div class="botones">
                    <button type="button" class="btn btn-danger btn-sm" id="apg"><i class="fas fa-microphone"></button></i>
                    <button type="button" class="btn btn-primary btn-sm" id="detlis"><i class="fas fa-microphone-slash"></button></i>
                    <button type="button" class="btn btn-success btn-sm" id="play25"><i class="fas fa-play"></button></i>
                </div>
                <textarea name="pronostico" class="form-control" id="txtapo" rows="3" ></textarea>
                <script type="text/javascript">
                    const apg = document.getElementById('apg');
                    const detlis = document.getElementById('detlis');
                    const txtapo = document.getElementById('txtapo');
                    const btn26 = document.getElementById('play25');
                    btn26.addEventListener('click', () => {
                    leerTexto(txtapo.value);
                    });
                    function leerTexto(txtapo){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= txtapo;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }
                    let rasi = new webkitSpeechRecognition();
                    rasi.lang = "es-ES";
                    rasi.continuous = true;
                    rasi.interimResults = false;
                    rasi.onresult = (event) => {
                    const results = event.results;
                    const frase = results[results.length -1][0].transcript;
                    txtapo.value += frase;
                    }
                    apg.addEventListener('click', () => {
                    rasi.start();
                    });
                    detlis.addEventListener('click', () => {
                    rasi.abort();
                    });
                </script>
            </div>

            <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
                <tr><strong>DIAGNÓSTICOS:</strong>
            </div>
            <p>      

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="play21"><i class="fas fa-play"></button></i> Diagnóstico principal:</strong></label>
                        <select name="diagno" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%">
                            <option value="">Seleccionar</option>
                            <?php
                            include "../../conexionbd.php";
                            $sql_diag="SELECT * FROM cat_diag ORDER by id_cie10";
                            $result_diag=$conexion->query($sql_diag);
                            while($row=$result_diag->fetch_assoc()){
                                echo "<option value='" . $row['diagnostico'] . "'>" . $row['id_cie10'] .' - '. $row['diagnostico'] . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <script type="text/javascript">
                    const mibuscador = document.getElementById('mibuscador');
                    const btn22 = document.getElementById('play21');
                    btn22.addEventListener('click', () => {
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
                <div class="col-12">
                    <strong>Describir: </strong><button type="button" class="btn btn-danger btn-sm" id="describirdg"><i class="fas fa-microphone"></button></i>
                    <button type="button" class="btn btn-primary btn-sm" id="stopdescri"><i class="fas fa-microphone-slash"></button></i>
                    <button type="button" class="btn btn-success btn-sm" id="play22"><i class="fas fa-play"></button></i>
                    <textarea name="diagno_desc" class="form-control" id="desgiag"></textarea>
                    <p></p>
                    <script type="text/javascript">
                        const describirdg = document.getElementById('describirdg');
                        const stopdescri = document.getElementById('stopdescri');
                        const desgiag = document.getElementById('desgiag');
                        const btn23 = document.getElementById('play22');
                        btn23.addEventListener('click', () => {
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

            <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
                <tr><strong>RECETA MÉDICA:</strong>
            </div>           
             <div class="col-12">
                <p>
                <div class="form-group">
                    <label for="txtdi"><strong>Medicamentos y cuidados en el hogar:</strong></label>
                    <div class="botones">
                        <button type="button" class="btn btn-danger btn-sm" id="mig"><i class="fas fa-microphone"></button></i>
                        <button type="button" class="btn btn-primary btn-sm" id="deteeh"><i class="fas fa-microphone-slash"></button></i>
                        <button type="button" class="btn btn-success btn-sm" id="play24"><i class="fas fa-play"></button></i>
                    </div>
                    <textarea name="receta" class="form-control" id="txtdi" rows="10" ></textarea>
                    <script type="text/javascript">
                        const mig = document.getElementById('mig');
                        const deteeh = document.getElementById('deteeh');
                        const txtdi = document.getElementById('txtdi');
                        const btn25 = document.getElementById('play24');
                        btn25.addEventListener('click', () => {
                        leerTexto(txtdi.value);
                        });
                        function leerTexto(txtdi){
                            const speech = new SpeechSynthesisUtterance();
                            speech.text= txtdi;
                            speech.volume=1;
                            speech.rate=1;
                            speech.pitch=0;
                            window.speechSynthesis.speak(speech);
                        }
                        let remcee = new webkitSpeechRecognition();
                        remcee.lang = "es-ES";
                        remcee.continuous = true;
                        remcee.interimResults = false;
                        remcee.onresult = (event) => {
                        const results = event.results;
                        const frase = results[results.length -1][0].transcript;
                        txtdi.value += frase;
                        }
                        mig.addEventListener('click', () => {
                        remcee.start();
                        });
                        deteeh.addEventListener('click', () => {
                        remcee.abort();
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-5">
                <strong><label for="destino"><button type="button" class="btn btn-success btn-sm" id="play12"><i class="fas fa-play"></button></i> 
                Destino del paciente:</label></strong>
                <select name="destino"class="form-control" id="txtdestttt" required onclick="habilitar(this.value);">
                    <option value="">Seleccionar</option>
                    <option  value="HOSPITALIZACIÓN">ASIGNAR HABITACIÓN / CUBÍCULO / AISLADO </option>
                    <option  value="ALTA">ALTA MÉDICA</option>
                </select>
        
                <script type="text/javascript">
                    const txtdestttt = document.getElementById('txtdestttt');
                    const btn13 = document.getElementById('play12');
                    btn13.addEventListener('click', () => {
                    leerTexto(txtdestttt.value);
                    });
                    function leerTexto(txtdestttt){
                        const speech = new SpeechSynthesisUtterance();
                        speech.text= txtdestttt;
                        speech.volume=1;
                        speech.rate=1;
                        speech.pitch=0;
                        window.speechSynthesis.speak(speech);
                    }
                </script>
            </div>
            <div class="col-sm-5">
                <label for="habitacion"><STRONG><button type="button" class="btn btn-success btn-sm" id="play13"><i class="fas fa-play"></button></i> Asignar Habitación:</STRONG></label>
                <select id="cama" name="habitacion" class="form-control">
                    <option value="">Seleccionar</option>
                    <?php
                    $resultado1 = $conexion ->query("SELECT * FROM cat_camas where estatus='LIBRE' AND TIPO <> 'CONSULTA' order by num_cama ASC")or die($conexion->error);?>
                    <?php foreach ($resultado1 as $opciones):?>
                        <option value="<?php echo $opciones['id']?>"><?php echo $opciones['num_cama']?> <?php echo $opciones ['estatus']?> <?php echo $opciones['tipo']?></option>
                    <?php endforeach?>
                </select>
            </div>
        </div>
        <script type="text/javascript">
            const cama = document.getElementById('cama');
            const btn14 = document.getElementById('play13');
            btn14.addEventListener('click', () => {
            leerTexto(cama.value);
            });
            function leerTexto(cama){
                const speech = new SpeechSynthesisUtterance();
                speech.text= cama;
                speech.volume=1;
                speech.rate=1;
                speech.pitch=0;
                window.speechSynthesis.speak(speech);
            }
        </script>
        <br>
        
        <div class="row">
            <div class="col">
                <strong>Referir a Médico Especialista?</strong>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO &nbsp;<input type="radio" value="NO"  checked="" name="referido" class="referir">&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;SI &nbsp;<input type="radio" value="SI" name="referido" class="referir">&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
        <p></p>
        <script type="text/javascript">
            $(document).ready(function(){
            $(".referir").click(function(evento){
            var valor = $(this).val();
            if(valor == 'SI'){
                $("#div1").css("display", "block");
               
            }else{
                $("#div1").css("display", "none");
               
            }});
            });
        </script>

<div class="collapse" id="div1" style="display:none;">
            
<div class="row">            
<div class="col-sm-9">
    <strong> <font size="4" color="#2b2d7f"><button type="button" class="btn btn-success btn-sm" id="play9"><i class="fas fa-play"></button></i> Especialidad:</font></strong>
    <select name="espec" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%" >
        <option value="<?php echo $row['id_espec'] ?>"><?php echo $row['espec'] ?></option>
        <option value="" disabled>Seleccionar</option>
        <?php
        $sql_diag="SELECT * FROM cat_espec";
        $result_diag=$conexion->query($sql_diag);
        while($row=$result_diag->fetch_assoc()){
            echo "<option value='" . $row['espec'] . "'>" . $row['espec'] . "</option>";
        } ?>
    </select>
</div>
</div>

<script type="text/javascript">
const mibuscador = document.getElementById('mibuscador');
const btnPlayTex9 = document.getElementById('play9');

btnPlayTex9.addEventListener('click', () => {
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
            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group">
                        <strong><font size="4" color="#2b2d7f"><label for="id_usua">Seleccionar Médico:</label></strong>
                        </font>
                        <select name="id_usua2" data-live-search="true" class="form-control" id="mibuscador2" onchange="mostrar(this.value);">
                            <?php
                            $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where u_activo='SI' and (id_rol=2 or id_rol=12 or id_rol=0) order by papell ASC")or die($conexion->error);
                            ?>
                            <option value="" disabled="" selected="">Seleccionar</option>
                            <?php foreach ($resultado1 as $opciones):?>
                                <option value="<?php echo $opciones['id_usua']?>"> <?php echo $opciones ['papell']?> </option>
                            <?php endforeach?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <br> 
        <div class="COL-2"> <center>
            <button type="submit" class="btn btn-primary">Firmar</button>
            <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
            </center>
        </div>
        <br><br>
    </div>
    </form>
<?php }else{
echo '<script type="text/javascript"> window.location.href="../../template/select_pac_hosp.php";</script>';

} ?>
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
  function validarEmail(elemento){ 
  var texto = document.getElementById("p_sistolica").value;
  var texto2 = document.getElementById("p_diastolica").value; 

if(texto >250 || texto2>180 || texto<0 || texto2<0) {
document.getElementById("resultado").innerHTML = '<font color="red">inválido </font>';

  } else {
document.getElementById("resultado").innerHTML = '<font color="green">válido </font>';
  }
}

function validarfreccar(elemento){ 
  var texto3 = document.getElementById("f_card").value;

if(texto3 >150 || texto3 <0 ) {
document.getElementById("resultado2").innerHTML = '<font color="red">inválido </font>';
  texto3.focus();
  } else {
document.getElementById("resultado2").innerHTML = '<font color="green">válido </font>';
  }
}

function validarfrecresp(elemento){ 
  var texto4 = document.getElementById("f_resp").value;

if(texto4 >100 || texto4 <0 ) {
document.getElementById("resultado3").innerHTML = '<font color="red">inválido </font>';
  texto4.focus();
  } else {
document.getElementById("resultado3").innerHTML = '<font color="green">válido </font>';
  }
}

function validartem(elemento){ 
  var texto5 = document.getElementById("temp").value;

if(texto5 >46 || texto5 <0 ) {
document.getElementById("resultado4").innerHTML = '<font color="red">inválido </font>';
  texto5.focus();
  } else {
document.getElementById("resultado4").innerHTML = '<font color="green">válido </font>';
  }
}

function validarsat(elemento){ 
  var texto6 = document.getElementById("sat_oxigeno").value;

if(texto6 >100 || texto6 <0 ) {
document.getElementById("resultado5").innerHTML = '<font color="red">inválido </font>';
  texto6.focus();
  } else {
document.getElementById("resultado5").innerHTML = '<font color="green">válido </font>';
  }
}

</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
      $(document).ready(function () {
        $('#mibuscador9').select2();
    });
</script>

</body>

</html>