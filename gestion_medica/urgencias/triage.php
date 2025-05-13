<?php
session_start();
include "../../conexionbd.php";
include "../header_medico.php";
if( isset($_GET['id_atencion'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
  $resultado = $conexion ->query("SELECT paciente.*, dat_ingreso.* FROM paciente
  inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp 
  WHERE id_atencion=".$_GET['id_atencion'])or die($conexion->error);
  
  if(mysqli_num_rows($resultado) > 0 ){ //se mostrara si existe mas de 1
    $f=mysqli_fetch_row($resultado);

  }else{
    header("Location: ../vista_usuario_triage.php"); //te regresa a la página principal
  }
}else{
  header("Location: ../vista_usuario_triage.php"); //te regresa a la página principal
}
$usuario = $_SESSION['login'];
//$resultado=$conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='".$usuario."'") or die($conexion->error);


?>
<!DOCTYPE html>
<html>
<head>

<meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <link rel="stylesheet" type="text/css" href="../hospitalizacion/css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="../hospitalizacion/js/select2.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>

<!-- boton despliegue-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   <!-- estilo de boton -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <!-- estilo de menu links -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

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

#cero{
position: absolute;
top: -140px; left: 55px;  
 font-size: 20px;
}

#doso{
position: absolute;
top: -140px; left: 145px;  
 font-size: 20px;
}

#cuatroc{
position: absolute;
top: -140px; left: 240px;  
 font-size: 20px;
}

#seis{
position: absolute;
top: -140px; left: 330px;  
 font-size: 20px;
}

#ocho{
position: absolute;
top: -140px; left: 425px;  
 font-size: 20px;
}
#diez{
position: absolute;
top: -140px; left: 509px;  
 font-size: 20px;
}

#rojo{
  font-size: 25px;
  background-color: red;

}

#amarillo{
  font-size: 25px;
  background-color: yellow;

}

#verde{
  font-size: 25px;
  background-color: green;

}
</style>
<script>
        function habilitar(value){

            if(value=="OBSERVACION" || value==true){
                // habilitamos
                document.getElementById("cama2").disabled=false;
                document.getElementById("cama2").style.visibility = "visible";

            }else if(value!="OBSERVACION"   || value==false){
                // deshabilitamos
                document.getElementById("cama2").disabled=true;
                document.getElementById("cama2").style.visibility = "hidden";
            }

            if(value=="HOSPITALIZACION" || value==true){
                // habilitamos
                document.getElementById("cama").disabled=false;
                 document.getElementById("cama").style.visibility = "visible";
            }else if(value!="HOSPITALIZACION"   || value==false){
                // deshabilitamos
                document.getElementById("cama").disabled=true;
                document.getElementById("cama").style.visibility = "hidden";
            }
            if(value=="CONSULTA DE URGENCIAS" || value==true){
                // habilitamos
                document.getElementById("cama3").disabled=false;
                document.getElementById("cama3").style.visibility = "visible";
            }else if(value!="CONSULTA DE URGENCIAS"   || value==false){
                // deshabilitamos
                document.getElementById("cama3").disabled=true;
                document.getElementById("cama3").style.visibility = "hidden";
            }

        }
    </script>

</head>
<body>

  <div class="container">
<div class="thead col col-12" style="background-color: #2b2d7f ; color: white; font-size: 26px; align-content: center;">
  <h2><center><strong>TRIAGE</strong></center></h2>
</div>
</div>
<p>
  <div class="container">
  <div class="row">
    <div class="col-sm">
     Nombre del Paciente: <strong><?php echo $f[2];?>
      <?php echo $f[3];?>
      <?php echo $f[4];?></strong><br>
    </div>
    
    <div class="col-sm">
    Fecha de nacimiento:<strong> <?php  $date = date_create($f[5]);
 echo date_format($date,"d/m/Y");?></strong>
    </div>
  </div>
</div>
<hr>

<?php 
$resultadot = $conexion->query("SELECT * from triage WHERE id_atencion=".$_GET['id_atencion']." ORDER BY id_triage DESC") or die($conexion->error);
while($fila = mysqli_fetch_array($resultadot)){  
    $triage=$fila['id_triage'];
    $id_att=$fila['id_atencion'];
}
if(isset($triage)){
   ?>
   
     <form action="insertar_triage_consulta.php?id_usu=<?php echo $usuario['id_usua'] ?>" method="POST">
  <div class="container">
    <div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       
      <strong >REGISTRAR NOTA DE CONSULTA Y RECETA</strong>

      </button>
    </h2>
   
      <br>
    <input type="hidden" name="id_atencion" class="form-control" value="<?php echo $id_att?>" readonly  placeholder="Folio de admisión" >
     
  <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>ANTECEDENTES HEREDO FAMILIARES</center></strong>
  </div>
<p>

<div class="row">
    <div class="col-sm">
    <strong> Antecedentes heredo familiares</strong>
     <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="hfg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopahf"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play14"><i class="fas fa-play"></button></i>
</div>
<textarea name="diab_pa" class="form-control" id="txtfanher"></textarea>
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
<hr>
  
  <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>ANTECEDENTES PERSONALES NO PATOLÓGICOS</center></strong>
  </div>
<p>
<div class="container">
<div class="row">

</div>
</div>
    <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>Antecedentes personales no patológicos:</strong></label>
    <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="otrosg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detan"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play15"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtno" rows="3" name=" otro_cu"></textarea>
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

<hr>
  

<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>ANTECEDENTES PERSONALES PATOLÓGICOS</center></strong>
  </div>
<p>

  <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>Quirúrgicos:</strong></label>
    <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="quirg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="deos"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play16"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtir" rows="3" name=" quir_cu"></textarea>
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
  <div class="form-group">
<label for="exampleFormControlTextarea1"><strong>Traumáticos:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="trag"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detti"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play17"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txttrauma" rows="3" name=" trau_cu"></textarea>
<script type="text/javascript">
const trag = document.getElementById('trag');
const detti = document.getElementById('detti');
const txttrauma = document.getElementById('txttrauma');

const btn18 = document.getElementById('play17');

btn18.addEventListener('click', () => {
        leerTexto(txttrauma.value);
});

function leerTexto(txttrauma){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txttrauma;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let ret = new webkitSpeechRecognition();
      ret.lang = "es-ES";
      ret.continuous = true;
      ret.interimResults = false;

      ret.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txttrauma.value += frase;
      }

      trag.addEventListener('click', () => {
        ret.start();
      });

      detti.addEventListener('click', () => {
        ret.abort();
      });
</script> 
  </div>

<div class="form-group">
<label for="exampleFormControlTextarea1"><strong>Otros antecedentes personales patológicos:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="oapg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detpp"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play18"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtap" rows="3" name=" despatol"></textarea>
<script type="text/javascript">
const oapg = document.getElementById('oapg');
const detpp = document.getElementById('detpp');
const txtap = document.getElementById('txtap');

const btn19 = document.getElementById('play18');

btn19.addEventListener('click', () => {
        leerTexto(txtap.value);
});

function leerTexto(txtap){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtap;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let reap = new webkitSpeechRecognition();
      reap.lang = "es-ES";
      reap.continuous = true;
      reap.interimResults = false;

      reap.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtap.value += frase;
      }

      oapg.addEventListener('click', () => {
        reap.start();
      });

      detpp.addEventListener('click', () => {
        reap.abort();
      });
</script> 
</div>
<!--
  <div class="row">
    <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="checkbox" name="trans_cu" id="flexRadioDefault4" value="SI">
  <label class="form-check-label" for="flexRadioDefault4">
    TRANSFUSIONALES
  </label>
</div>
    </div>

<div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="checkbox" name="aler_cu" id="alergicos" value="SI">
  <label class="form-check-label" for="alergicos">
    ALERGICOS
  </label>
</div>
    </div>

</div>

  <textarea row="1" class="form-control" name="despatol"></textarea>
  <hr>-->
<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>PADECIMIENTO ACTUAL</center></strong>
</div>
<p>

<div class="form-group">
<label for="txttu"><strong>Padecimiento actual:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="padeg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detapt"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play19"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txttu" rows="3" name="pad_cu"></textarea>
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

<div class="form-group">
<label for="txtica"><strong>Exploración física:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="expg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detef"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play20"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtica" rows="3" name="exp_cu"></textarea>
<script type="text/javascript">
const expg = document.getElementById('expg');
const detef = document.getElementById('detef');
const txtica = document.getElementById('txtica');

const btn21 = document.getElementById('play20');

btn21.addEventListener('click', () => {
        leerTexto(txtica.value);
});

function leerTexto(txtica){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtica;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let resiex = new webkitSpeechRecognition();
      resiex.lang = "es-ES";
      resiex.continuous = true;
      resiex.interimResults = false;

      resiex.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtica.value += frase;
      }

      expg.addEventListener('click', () => {
        resiex.start();
      });

      detef.addEventListener('click', () => {
        resiex.abort();
      });
</script>
</div>


<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>DIAGNÓSTICOS</center></strong>
  </div>
<p>      

<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="play21"><i class="fas fa-play"></button></i> Diagnóstico principal:</strong></label>
            <select name="diag_cu" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%">
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
<div class="col-6">
<strong>Describir: </strong><button type="button" class="btn btn-danger btn-sm" id="describirdg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopdescri"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play22"><i class="fas fa-play"></button></i>
<textarea class="form-control" name="des_diag" id="desgiag"></textarea>
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
<div class="row">
    <div class="col-12">
        <div class="form-group">
  <label for="id_cie_10"><strong>Diagnósticos previos:
  <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="previosg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="diapstop"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play23"><i class="fas fa-play"></button></i>
</div></strong></label>
<textarea class="form-control" name="diag2" id="txtnop"></textarea>
<script type="text/javascript">
const previosg = document.getElementById('previosg');
const diapstop = document.getElementById('diapstop');
const txtnop = document.getElementById('txtnop');

const btn24 = document.getElementById('play23');

btn24.addEventListener('click', () => {
        leerTexto(txtnop.value);
});

function leerTexto(txtnop){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtnop;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
     let rediaosprev = new webkitSpeechRecognition();
      rediaosprev.lang = "es-ES";
      rediaosprev.continuous = true;
      rediaosprev.interimResults = false;

      rediaosprev.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtnop.value += frase;
      }

      previosg.addEventListener('click', () => {
        rediaosprev.start();
      });

      diapstop.addEventListener('click', () => {
        rediaosprev.abort();
      });
</script>           
        </div>
    </div>
</div>
                 
       <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>RECETA MÉDICA</center></strong>
  </div>           
<div class="row">

<p>
    <div class="form-group">
<label for="txtdi"><strong>Medicamentos y cuidados en el hogar:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="mig"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="deteeh"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play24"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtdi" rows="5" name="med_cu"></textarea>
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
<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>TRATAMIENTO Y PLAN </center></strong>
  </div>
<p>
    <div class="form-group">
      <label for="txtapo"><strong>Análisis y pronósticos:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="apg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detlis"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play25"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtapo" rows="3" name="anproc_cu"></textarea>
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

 
      <div class="form-group">
    <label for="txtyp"><strong>Tratamiento y plan:</strong></label>
    <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="tryg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detpy"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play26"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtyp" rows="3" name="trat_cu"></textarea>
<script type="text/javascript">
const tryg = document.getElementById('tryg');
const detpy = document.getElementById('detpy');
const txtyp = document.getElementById('txtyp');

const btn27 = document.getElementById('play26');

btn27.addEventListener('click', () => {
        leerTexto(txtyp.value);
});

function leerTexto(txtyp){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtyp;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let retpan = new webkitSpeechRecognition();
      retpan.lang = "es-ES";
      retpan.continuous = true;
      retpan.interimResults = false;

      retpan.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtyp.value += frase;
      }

      tryg.addEventListener('click', () => {
        retpan.start();
      });

      detpy.addEventListener('click', () => {
        retpan.abort();
      });
</script>
  </div>

<div class="form-group">
<label for="txtoye"><strong>Observaciones y estudios:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="estudiosg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="dettud"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play27"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtoye" rows="3" name="do_cu"></textarea>
<script type="text/javascript">
const estudiosg = document.getElementById('estudiosg');
const dettud = document.getElementById('dettud');
const txtoye = document.getElementById('txtoye');

const btn28 = document.getElementById('play27');

btn28.addEventListener('click', () => {
        leerTexto(txtoye.value);
});

function leerTexto(txtoye){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtoye;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}


     let resery = new webkitSpeechRecognition();
      resery.lang = "es-ES";
      resery.continuous = true;
      resery.interimResults = false;

      resery.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtoye.value += frase;
      }

      estudiosg.addEventListener('click', () => {
        resery.start();
      });

      dettud.addEventListener('click', () => {
        resery.abort();
      });
</script>
   </div>
<div class="COL-2"> <center>
            <button type="submit" class="btn btn-primary">Firmar</button>
             <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
            </center>
        </div>
        <br>
    


</div>
</form>
   <?php }else{?>
  



  <form action="insertar_triage.php?id_usu=<?php echo $usuario['id_usua'] ?>" method="POST">
  <div class="container">
<table class="table" align="center">
  <thead class="thead-dark">
    <tr>
      
      <th scope="col"></th>
      <th scope="col"><center>CLASIFICACIÓN DEL TRIAGE</center></th>
      <th scope="col"><center>SELECCIONAR</center></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"></th>
      <td><img src="../../imagenes/rojo.png" width="600" high="400" align="right"></td>

      <td>

        <div class="form-check">
          <br><br><center>
  <input class="form-check-input" type="radio" name="urgencia" id="rojo" value="ROJO (Máxima prioridad)" required="">
  <label for="rojo"></label></center>
</div>
</td>
    </tr>
    <tr>
      <th scope="row"></th>
      <td><img src="../../imagenes/amarillo.png" width="600" high="400" align="right"></td>
      <td><div class="form-check">
        <br><br><center>
  <input class="form-check-input" type="radio" name="urgencia" id="amarillo" value="AMARILLO (Urgencia calificada)">
 <label for="amarillo"></label></center>
 
</div></td>
    
    </tr>
    <tr>
      <th scope="row"></th>
      <td><img src="../../imagenes/verde.png" width="600" high="400" align="right"></td>
      <td><div class="form-check">
        <br><br><center>
  <input class="form-check-input" type="radio" name="urgencia" id="verde" value="VERDE (Urgencia sentida)">
  
  <label for="verde"></label>  </center>
  
  </div></td>
      
    </tr>
  </tbody>
</table>
</div>
 
<div class="container-fluid">
    <div class="row">
<div class="col-sm-1"></div>

<div class="col-sm-10" id="colocacion">

    <div class="col">

<div class="row">
    <div class="col-sm">
      <!--MÉDICO: <strong> <?php //echo $usuario['nombre'];?> <?php echo $usuario['papell'];?> <?php echo $usuario['sapell'];?></strong>-->
    </div>
    <div class="col-sm">

     <!--ID: <strong><?php //echo $usuario['id_usua'];?></strong><br>-->
    </div>
  </div>


    <!-- NO. EXPEDIENTE: <strong><?php //echo $f[0];?></strong><br>-->
     
      


    </div>
    
    



<div class="row">
    <div class="col">
        <?php $id_a=$_GET['id_atencion'];?>
        <!--FOLIO DE ADMISIÓN:-->
<input type="hidden" name="id_atencion" class="form-control" value="<?php echo $id_a?>" readonly  placeholder="Folio de admisión" >
    </div>
  </div>



<div class="row">

<div class="col-8">

<div class="row">
  <div class="col-sm-4">
   <button type="button" class="btn btn-success btn-sm" id="play"><i class="fas fa-play"></button></i> Presión arterial: <h7 id='resultado'></h7>
  </div>
  <div class="col-sm-2">
   <input type="number" name="p_sistolica" id="p_sistolica" class="form-control" value="" min="0"  max="250" required onkeyup="validarEmail(this)"> 
  </div>
  <div class="col-sm-1">
      <label for="p_diastolica">/</label>
  </div>
  <div class="col-sm-2">
     <input type="number" name="p_diastolica" id="p_diastolica" class="form-control" value="" min="0" max="180" required onkeyup="validarEmail(this)">
    </div>

    <div class="col-sm">
      mmHg
    </div>
</div>
<script type="text/javascript">
const p_sistolica = document.getElementById('p_sistolica');
const btn1 = document.getElementById('play');

btn1.addEventListener('click', () => {
        leerTexto(p_sistolica.value);
});

function leerTexto(p_sistolica){
    const speech = new SpeechSynthesisUtterance();
    speech.text= p_sistolica;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

const p_diastolica = document.getElementById('p_diastolica');
const btn2 = document.getElementById('play');

btn2.addEventListener('click', () => {
        leerTexto(p_diastolica.value);
});

function leerTexto(p_diastolica){
    const speech = new SpeechSynthesisUtterance();
    speech.text= p_diastolica;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>

<p>


  <div class="row">
    <div class="col-sm">
     <label for="f_card"><button type="button" class="btn btn-success btn-sm" id="play2"><i class="fas fa-play"></button></i> Frecuencia cardiaca: <h7 id='resultado2'></h7></label>
    </div>
    <div class="col-sm-4">
 <input type="number" name="f_card" placeholder="" id="f_card" class="form-control" value="" min="0" max="150" required onkeyup="validarfreccar(this)">
    </div>
    <div class="col-sm">
    <label for="f_card">Latidos por minuto</label>
    </div>
  </div>
<script type="text/javascript">
const f_card = document.getElementById('f_card');
const btn3 = document.getElementById('play2');

btn3.addEventListener('click', () => {
        leerTexto(f_card.value);
});

function leerTexto(f_card){
    const speech = new SpeechSynthesisUtterance();
    speech.text= f_card;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

</script>
<p>
  <div class="row">
    <div class="col-sm">
 <label for="f_resp"><button type="button" class="btn btn-success btn-sm" id="play3"><i class="fas fa-play"></button></i>Frecuencia respiratoria: <h7 id='resultado3'></h7>
</label>
    </div>
    <div class="col-sm">
<input type="number" name="f_resp" placeholder="" id="f_resp" min="0" max="100" class="form-control" value="" required onkeyup="validarfrecresp(this)">
    </div>
    <div class="col-sm">
<label for="f_resp">Respiraciones por minuto</label>
    </div>
  </div>
  <script type="text/javascript">
const f_resp = document.getElementById('f_resp');
const btn4 = document.getElementById('play3');

btn4.addEventListener('click', () => {
        leerTexto(f_resp.value);
});

function leerTexto(f_resp){
    const speech = new SpeechSynthesisUtterance();
    speech.text= f_resp;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<p>


  <div class="row">
    <div class="col-sm">
<label for="temp"><button type="button" class="btn btn-success btn-sm" id="play4"><i class="fas fa-play"></button></i> Temperatura: <h7 id='resultado4'></h7></label>
    </div>
    <div class="col-sm">
<input type="cm-number" name="temp" min="0" max="46" placeholder="" id="temp" class="form-control" required onkeyup="validartem(this)">
    </div>
    <div class="col-sm">
<label for="temp">°C</label>
    </div>
  </div>
  <script type="text/javascript">
const temp = document.getElementById('temp');
const btn5 = document.getElementById('play4');

btn5.addEventListener('click', () => {
        leerTexto(temp.value);
});

function leerTexto(temp){
    const speech = new SpeechSynthesisUtterance();
    speech.text= temp;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<p>

  <div class="row">
    <div class="col-sm">
<label for="sat_oxigeno"><button type="button" class="btn btn-success btn-sm" id="play5"><i class="fas fa-play"></button></i> Saturación oxígeno: <h7 id='resultado5'></h7></label>
    </div>
    <div class="col-sm">
<input type="number" name="sat_oxigeno" placeholder="" min="0" max="100" id="sat_oxigeno" class="form-control" value="" required onkeyup="validarsat(this)">
    </div>
    <div class="col-sm">
<label for="sat_oxigeno">%</label>
    </div>
  </div>
  <script type="text/javascript">
const sat_oxigeno = document.getElementById('sat_oxigeno');
const btn6 = document.getElementById('play5');

btn6.addEventListener('click', () => {
        leerTexto(sat_oxigeno.value);
});

function leerTexto(sat_oxigeno){
    const speech = new SpeechSynthesisUtterance();
    speech.text= sat_oxigeno;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<p>

  <div class="row">
    <div class="col-sm-4">
    <label class="form-check-label" for="sig"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sin signos vitales</strong>
  </label> 
    </div>&nbsp;
    <div class="col-sm">
    <div class="form-check">
  <input class="form-check-input" type="checkbox" value="1" id="sig" name="sig">
</div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script>
            $('#sig').on('change', function() {
            if ($(this).is(':checked') ) {
                $( "#p_sistolica").prop( "disabled", true );
                $('#p_sistolica').val(0);
                $( "#p_diastolica").prop( "disabled", true );
                $('#p_diastolica').val(0);
                $( "#f_card").prop( "disabled", true );
                $('#f_card').val(0);
                $( "#f_resp").prop( "disabled", true );
                $('#f_resp').val(0);
                $( "#temp").prop( "disabled", true );
                $('#temp').val(0);
                $( "#sat_oxigeno").prop( "disabled", true );
                $('#sat_oxigeno').val(0);
             } else {
                $( "#p_sistolica").prop( "disabled", false );
                $('#p_sistolica').val('');
                $( "#p_diastolica").prop( "disabled", false );
                $('#p_diastolica').val('');
                $( "#f_card").prop( "disabled", false );
                $('#f_card').val('');
                $( "#f_resp").prop( "disabled", false );
                $('#f_resp').val('');
                $( "#temp").prop( "disabled", false );
                $('#temp').val('');
                $( "#sat_oxigeno").prop( "disabled", false );
                $('#sat_oxigeno').val('');
            }
  
             
});
</script>

<p>

  <div class="row">
    <div class="col-sm">
<label for="peso"><button type="button" class="btn btn-success btn-sm" id="play6"><i class="fas fa-play"></button></i> Peso: </label>
    </div>
    <div class="col-sm">
<input type="cm-number" name="peso"  placeholder="" id="peso" class="form-control" required>
    </div>
    <div class="col-sm">
<label for="peso">Kilos</label>
    </div>
  </div>
  <script type="text/javascript">
const peso = document.getElementById('peso');
const btn7 = document.getElementById('play6');

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
<p>

  <div class="row">
    <div class="col-sm">
<label for="talla"><button type="button" class="btn btn-success btn-sm" id="play7"><i class="fas fa-play"></button></i> Talla: </label>
    </div>
    <div class="col-sm">
<input type="cm-number" name="talla" placeholder="" id="talla" required class="form-control">
    </div>
    <div class="col-sm">
<label for="Talla">Metros</label>
    </div>
  </div>
<script type="text/javascript">
const talla = document.getElementById('talla');
const btn8 = document.getElementById('play7');

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
<hr>
<script type="text/javascript">
function validarRango(elemento){
  var numero = parseInt(elemento.value,10);
  //Validamos que se haya ingresado solo numeros
 
  //Validamos que se cumpla el rango
  if(numero<0 || numero>10){
    alert('SOLO SE PERMITE EL SIGUIENTE RANGO: 0 - 10');
elemento.focus();
elemento.select();


  }


}


</script>

<div class="container">
  <div class="row">
    <div class="col-sm">
   <h6> <center><strong>VALORACIÓN DEL DOLOR - ESCALA VISUAL ANÁLOGA (EVA)</strong></center></h6>
    </div>
    
  </div>
</div>
<div class="container">
  <div class="row">
     <center>
    <div class="col-sm">
   <img src="../../imagenes/caras.png" width="550">
    </div>
    </center>
    <div class="col-sm-3">
<input class="form-check-input" type="radio" name="niv_dolor" id="cero" value="0" required>
<input class="form-check-input" type="radio" name="niv_dolor" id="doso" value="2">
<input class="form-check-input" type="radio" name="niv_dolor" id="cuatroc" value="4">
<input class="form-check-input" type="radio" name="niv_dolor" id="seis" value="6">
<input class="form-check-input" type="radio" name="niv_dolor" id="ocho" value="8">
<input class="form-check-input" type="radio" name="niv_dolor" id="diez" value="10">
    </div>
  </div>
</div>



</div>

<div class="col-sm-4">
<hr>
<h6><strong>Antecedentes:</strong></h6>
  
 <div class="form-check">
  <input class="form-check-input" type="checkbox" name="diab" value="SI" id="diab">
  <label class="form-check-label" for="diab">
    Diabetes
  </label>
</div>

 <div class="form-check">
  <input class="form-check-input" type="checkbox" name="h_arterial" value="SI" id="h_arterial">
  <label class="form-check-label" for="h_arterial">
    Hipertensión arterial
  </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" name="enf_card_pulm" value="SI" id="enf_card_pulm">
  <label class="form-check-label" for="enf_card_pulm">
    Enfermedades cardiacas/pulmonares
  </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" name="cancer" value="SI" id="cancer">
  <label class="form-check-label" for="cancer">
    Cáncer
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" name="emb" value="SI" id="emb">
  <label class="form-check-label" for="emb">
    Embarazo
  </label>
</div>
<hr>
<label for="otro"><strong>Otro:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="utrog"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detort"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play8"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" rows="12" name="otro" id="txtu"></textarea>
<script type="text/javascript">
const utrog = document.getElementById('utrog');
const detort = document.getElementById('detort');
const txtu = document.getElementById('txtu');

const btn9 = document.getElementById('play8');

btn9.addEventListener('click', () => {
        leerTexto(txtu.value);
});

function leerTexto(txtu){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtu;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let reutro = new webkitSpeechRecognition();
      reutro.lang = "es-ES";
      reutro.continuous = true;
      reutro.interimResults = false;

      reutro.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtu.value += frase;
      }

      utrog.addEventListener('click', () => {
        reutro.start();
      });

      detort.addEventListener('click', () => {
        reutro.abort();
      });
</script>
</div>
 <div class="col-sm-12"><h6><strong><hr><button type="button" class="btn btn-success btn-sm" id="play9"><i class="fas fa-play"></button></i> Escala Glasgow:</h6></strong>
<!--
<script type="text/javascript">
function validarRango1(elemento){
  var numero = parseInt(elemento.value,15);
  //Validamos que se haya ingresado solo numeros

  //Validamos que se cumpla el rango
  if(numero<3 || numero>15){
    alert('SOLO SE PERMITE EL SIGUIENTE RANGO: 3 - 15');
elemento.focus();
elemento.select();
  }
}
</script>-->

<div class="form-group">
        <select class="form-control" name="val_total" id="val_total" style="width : 100%; heigth : 100%">
   <option value="">Seleccionar</option>
  <option value="Leve">Leve 15-13</option>
  <option value="Moderado">Moderado 12-9</option>
  <option value="Grave">Grave <9</option>
</select>   
           
          </div>
<script type="text/javascript">
const val_total = document.getElementById('val_total');
const btn10 = document.getElementById('play9');

btn10.addEventListener('click', () => {
        leerTexto(val_total.value);
});

function leerTexto(val_total){
    const speech = new SpeechSynthesisUtterance();
    speech.text= val_total;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<strong><label for="edo_clin">Motivo de atención:</label></strong>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play10"><i class="fas fa-play"></button></i>
</div> 
<textarea class="form-control" rows="3" cols="100" name="edo_clin" value="" required="" id="texto"></textarea><br>
<script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btn11 = document.getElementById('play10');

btn11.addEventListener('click', () => {
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
<!--<strong><label for="imp_diag">IMPRESIÓN DIAGNÓSTICA:</label></strong>
<textarea class="form-control" rows="3" name="imp_diag"  value=""  required=""></textarea>-->

<div class="container">
  <div class="row">
    <div class="col-sm">
      <strong><label for="destino"><button type="button" class="btn btn-success btn-sm" id="play11"><i class="fas fa-play"></button></i> Estado neurológico:</label></strong>
<select class="form-control" name="imp_diag" id="txtimp_diag">
   <option value="">Seleccionar</option>
  <option value="Alerta">Alerta</option>
  <option value="Verbal">Verbal</option>
  <option value="Dolor">Dolor</option>
  <option value="Inconsiente">Inconsiente</option>
</select>
    </div>
    <div class="col-sm">
     <img src="../../img/avdi.jpg" width="360">
    </div>
    <script type="text/javascript">
const txtimp_diag = document.getElementById('txtimp_diag');
const btn12 = document.getElementById('play11');

btn12.addEventListener('click', () => {
        leerTexto(txtimp_diag.value);
});

function leerTexto(txtimp_diag){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtimp_diag;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  </div>
</div>


<hr>
<div class="row">
  <div class="col-sm-4">
       <strong><label for="destino"><button type="button" class="btn btn-success btn-sm" id="play12"><i class="fas fa-play"></button></i> Destino del paciente:</label></strong>
       <select name="destino"class="form-control" id="txtdestttt" required onclick="habilitar(this.value);" required>
         <option value="">Seleccionar</option>
         <option  value="Hospitalización">Asignar habitación</option>
         <option  value="Egreso">Egreso</option>
       </select>
     <!--  <input type="text" name="destino" class="form-control">-->
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
  <div class="col-sm-4">
      <label for="habitacion"><STRONG><button type="button" class="btn btn-success btn-sm" id="play13"><i class="fas fa-play"></button></i> Asignar Habitación:</STRONG></label>
      <select id="cama" name="habitacion" class="form-control">
          <option value="">Seleccionar</option>
<?php
             $resultado1 = $conexion ->query("SELECT * FROM cat_camas where estatus='LIBRE' order by num_cama ASC")or die($conexion->error);?>
             
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
<hr>
     <div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       
      <strong >REGISTRAR NOTA DE CONSULTA Y RECETA</strong>

      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <br>
    
     
  <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>ANTECEDENTES HEREDO FAMILIARES</center></strong>
  </div>
<p>

<div class="row">
    <div class="col-sm">
    <strong> Antecedentes heredo familiares</strong>
     <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="hfg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopahf"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play14"><i class="fas fa-play"></button></i>
</div>
<textarea name="diab_pa" class="form-control" id="txtfanher"></textarea>
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
<hr>
  
  <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>ANTECEDENTES PERSONALES NO PATOLÓGICOS</center></strong>
  </div>
<p>
<div class="container">
<div class="row">

</div>
</div>
    <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>Antecedentes personales no patológicos:</strong></label>
    <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="otrosg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detan"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play15"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtno" rows="3" name=" otro_cu"></textarea>
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

<hr>
  

<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>ANTECEDENTES PERSONALES PATOLÓGICOS</center></strong>
  </div>
<p>

  <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>Quirúrgicos:</strong></label>
    <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="quirg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="deos"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play16"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtir" rows="3" name=" quir_cu"></textarea>
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
  <div class="form-group">
<label for="exampleFormControlTextarea1"><strong>Traumáticos:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="trag"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detti"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play17"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txttrauma" rows="3" name=" trau_cu"></textarea>
<script type="text/javascript">
const trag = document.getElementById('trag');
const detti = document.getElementById('detti');
const txttrauma = document.getElementById('txttrauma');

const btn18 = document.getElementById('play17');

btn18.addEventListener('click', () => {
        leerTexto(txttrauma.value);
});

function leerTexto(txttrauma){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txttrauma;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let ret = new webkitSpeechRecognition();
      ret.lang = "es-ES";
      ret.continuous = true;
      ret.interimResults = false;

      ret.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txttrauma.value += frase;
      }

      trag.addEventListener('click', () => {
        ret.start();
      });

      detti.addEventListener('click', () => {
        ret.abort();
      });
</script> 
  </div>

<div class="form-group">
<label for="exampleFormControlTextarea1"><strong>Otros antecedentes personales patológicos:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="oapg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detpp"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play18"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtap" rows="3" name=" despatol"></textarea>
<script type="text/javascript">
const oapg = document.getElementById('oapg');
const detpp = document.getElementById('detpp');
const txtap = document.getElementById('txtap');

const btn19 = document.getElementById('play18');

btn19.addEventListener('click', () => {
        leerTexto(txtap.value);
});

function leerTexto(txtap){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtap;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let reap = new webkitSpeechRecognition();
      reap.lang = "es-ES";
      reap.continuous = true;
      reap.interimResults = false;

      reap.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtap.value += frase;
      }

      oapg.addEventListener('click', () => {
        reap.start();
      });

      detpp.addEventListener('click', () => {
        reap.abort();
      });
</script> 
</div>
<!--
  <div class="row">
    <div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="checkbox" name="trans_cu" id="flexRadioDefault4" value="SI">
  <label class="form-check-label" for="flexRadioDefault4">
    TRANSFUSIONALES
  </label>
</div>
    </div>

<div class="col-sm">
     <div class="form-check">
  <input class="form-check-input" type="checkbox" name="aler_cu" id="alergicos" value="SI">
  <label class="form-check-label" for="alergicos">
    ALERGICOS
  </label>
</div>
    </div>

</div>

  <textarea row="1" class="form-control" name="despatol"></textarea>
  <hr>-->
<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>PADECIMIENTO ACTUAL</center></strong>
</div>
<p>

<div class="form-group">
<label for="txttu"><strong>Padecimiento actual:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="padeg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detapt"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play19"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txttu" rows="3" name="pad_cu"></textarea>
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

<div class="form-group">
<label for="txtica"><strong>Exploración física:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="expg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detef"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play20"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtica" rows="3" name="exp_cu"></textarea>
<script type="text/javascript">
const expg = document.getElementById('expg');
const detef = document.getElementById('detef');
const txtica = document.getElementById('txtica');

const btn21 = document.getElementById('play20');

btn21.addEventListener('click', () => {
        leerTexto(txtica.value);
});

function leerTexto(txtica){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtica;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let resiex = new webkitSpeechRecognition();
      resiex.lang = "es-ES";
      resiex.continuous = true;
      resiex.interimResults = false;

      resiex.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtica.value += frase;
      }

      expg.addEventListener('click', () => {
        resiex.start();
      });

      detef.addEventListener('click', () => {
        resiex.abort();
      });
</script>
</div>


<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>DIAGNÓSTICOS</center></strong>
  </div>
<p>      

<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="id_cie_10"><strong><button type="button" class="btn btn-success btn-sm" id="play21"><i class="fas fa-play"></button></i> Diagnóstico principal:</strong></label>
            <select name="diag_cu" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%">
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
<div class="col-6">
<strong>Describir: </strong><button type="button" class="btn btn-danger btn-sm" id="describirdg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="stopdescri"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play22"><i class="fas fa-play"></button></i>
<textarea class="form-control" name="des_diag" id="desgiag"></textarea>
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
<div class="row">
    <div class="col-12">
        <div class="form-group">
  <label for="id_cie_10"><strong>Diagnósticos previos:
  <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="previosg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="diapstop"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play23"><i class="fas fa-play"></button></i>
</div></strong></label>
<textarea class="form-control" name="diag2" id="txtnop"></textarea>
<script type="text/javascript">
const previosg = document.getElementById('previosg');
const diapstop = document.getElementById('diapstop');
const txtnop = document.getElementById('txtnop');

const btn24 = document.getElementById('play23');

btn24.addEventListener('click', () => {
        leerTexto(txtnop.value);
});

function leerTexto(txtnop){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtnop;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
     let rediaosprev = new webkitSpeechRecognition();
      rediaosprev.lang = "es-ES";
      rediaosprev.continuous = true;
      rediaosprev.interimResults = false;

      rediaosprev.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtnop.value += frase;
      }

      previosg.addEventListener('click', () => {
        rediaosprev.start();
      });

      diapstop.addEventListener('click', () => {
        rediaosprev.abort();
      });
</script>           
        </div>
    </div>
</div>
                 
       <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>RECETA MÉDICA</center></strong>
  </div>           
<div class="row">

<p>
    <div class="form-group">
<label for="txtdi"><strong>Medicamentos y cuidados en el hogar:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="mig"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="deteeh"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play24"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtdi" rows="5" name="med_cu"></textarea>
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
<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 19px;">
       <tr><strong><center>TRATAMIENTO Y PLAN </center></strong>
  </div>
<p>
    <div class="form-group">
      <label for="txtapo"><strong>Análisis y pronósticos:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="apg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detlis"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play25"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtapo" rows="3" name="anproc_cu"></textarea>
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

 
      <div class="form-group">
    <label for="txtyp"><strong>Tratamiento y plan:</strong></label>
    <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="tryg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="detpy"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play26"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtyp" rows="3" name="trat_cu"></textarea>
<script type="text/javascript">
const tryg = document.getElementById('tryg');
const detpy = document.getElementById('detpy');
const txtyp = document.getElementById('txtyp');

const btn27 = document.getElementById('play26');

btn27.addEventListener('click', () => {
        leerTexto(txtyp.value);
});

function leerTexto(txtyp){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtyp;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let retpan = new webkitSpeechRecognition();
      retpan.lang = "es-ES";
      retpan.continuous = true;
      retpan.interimResults = false;

      retpan.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtyp.value += frase;
      }

      tryg.addEventListener('click', () => {
        retpan.start();
      });

      detpy.addEventListener('click', () => {
        retpan.abort();
      });
</script>
  </div>

<div class="form-group">
<label for="txtoye"><strong>Observaciones y estudios:</strong></label>
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="estudiosg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="dettud"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="play27"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" id="txtoye" rows="3" name="do_cu"></textarea>
<script type="text/javascript">
const estudiosg = document.getElementById('estudiosg');
const dettud = document.getElementById('dettud');
const txtoye = document.getElementById('txtoye');

const btn28 = document.getElementById('play27');

btn28.addEventListener('click', () => {
        leerTexto(txtoye.value);
});

function leerTexto(txtoye){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtoye;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}


     let resery = new webkitSpeechRecognition();
      resery.lang = "es-ES";
      resery.continuous = true;
      resery.interimResults = false;

      resery.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtoye.value += frase;
      }

      estudiosg.addEventListener('click', () => {
        resery.start();
      });

      dettud.addEventListener('click', () => {
        resery.abort();
      });
</script>
   </div>

    </div>
  </div>
 
</div>   



</div>
</div>
<hr>
 
        <div class="COL-2"> <center>
            <button type="submit" class="btn btn-primary">Firmar</button>
             <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
            </center>
        </div>
        <br>
        <br>


   

</div>

</form>
<?php }?>
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