<?php
session_start();
include "../../conexionbd.php";
include ("../header_medico.php");
$resultado=$conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE dat_ingreso.area='EGRESO DE URGENCIAS'") or die($conexion->error);
$usuario=$_SESSION['login'];
?>   
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://your-site-or-cdn.com/fontawesome/v6.1.1/js/all.js" data-auto-replace-svg="nest"></script>
<meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
             <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
              integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
              crossorigin="anonymous">
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
              integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
              crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>

    <link rel="stylesheet" href="css_busc/estilos2.css">
    
    <script src="js_busc/jquery.js"></script>
    <script src="js_busc/jquery.dataTables.min.js"></script>
       
    <script>
        function habilitar(value)
        {
            if(value=="OTROS" || value==true)
            {
                // habilitamos
                document.getElementById("esp").disabled=false;
            }else if(value!="OTROS" || value==false){
                // deshabilitamos
                document.getElementById("esp").disabled=true;
            }
        }
    </script>
          <style type="text/css">
    #contenido{
        display: none;
    }
</style>
    <title>Menu Gestión Médica </title>
    <link rel="shortcut icon" href="logp.png">
</head>
<div class="container">
</div>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col col-12">
          
                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                 <div class="thead col col-12" style="background-color: #2b2d7f; color: white; font-size: 22px; align-content: center;">
                <center><font id="letra"><strong> NOTA DE CONSULTA </strong></font> </center></div>

            <div class="row">
                
            </div>

            <div class="text-center">
            </div>
            <br>
            <h2>
                <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
            </h2>
            <div class="row">
                
                <div class="col-sm">
                  <center> <a href="buscar_receta.php"><button type="button" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i> <font id="letra"> BUSCAR RECETA MÉDICA</font></button></a>
                           <!-- <a href="buscar_paciente.php"><button type="button" class="btn btn-warning">
                            <i class="fa fa-plus"></i> <font id="letra">CONSULTAS REGISTRADAS</font></button></a>
                            <a href="receta_pac_hosp.php"><button type="button" class="btn btn-primary" >
                            <i class="fa fa-plus"></i> <font id="letra">CONSULTAS EGRESADOS DE HOSPITALIZACIÓN</font></button></a>-->
                            </center>
                </div>
            </div><hr>
            <div class="table-responsive">
<div class="container box">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <?php
                        
                        $fecha_actual = date("d-m-Y H:i:s");
                        ?>
                    <label><strong>FECHA :</strong></label>
                    <input type="datetime" name="fecha" value="<?= $fecha_actual ?>" class="form-control" disabled>
                </div>
            </div>
            <!--  
                <div class="col-sm-4">
     <label><strong>BUSCAR PACIENTE</strong></label><br>
        <select name="pac" class="form-control" data-live-search="true" id="mibuscador" style="width :200%; heigth : 80%" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="">SELECCIONAR PACIENTE</option>
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * from receta_ambulatoria order by id_rec_amb desc ";
$result_diag=$conexion->query($sql_diag);
foreach ($result_diag as $row ) {
    $nombre_rec=$row['nombre_rec'].' '.$row['papell_rec'].' '.$row['sapell_rec'];
?>
<option value="nueva_receta.php?id=<?php// echo $row['id_rec_amb'] ?>"><font size="1"><?php// echo $nombre_rec ?> -- C. EXTERNA</font></option>
<?php } ?>

<?php
include "../../conexionbd.php";
$sql_diag="SELECT p.*, d.* from paciente p, dat_ingreso d WHERE d.Id_exp=p.Id_exp and d.cama=0 order by d.id_atencion DESC";
$result_diag=$conexion->query($sql_diag);
foreach ($result_diag as $f ) {
    $nombre_H=$f['papell'].' '.$f['sapell'].' '.$f['nom_pac'];
?>
<option value="nueva_receta_hosp.php?id_atencion=<?php// echo $f['id_atencion'] ?>"><font size="1"><?php //echo $nombre_H ?> -- HOSP.</font></option>
<?php } ?>
        </select>
    </div>
            -->
</div>
<div class="container">
    
</div>
<form action="" method="POST">
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
             <center><strong>DATOS DEL PACIENTE </strong></center><p>
        </div>
               <div class="row">
                   <div class="col-sm">
                       <div class="form-group">
                           <label><strong>NOMBRE(S) :</strong></label><br>
                           <input type="text" name="nombre_rec" class="form-control" style="text-transform:uppercase;" value=""  
                           onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
                       </div>
                   </div>
                   <div class="col-sm">
                       <div class="form-group">
                           <label><strong>PRIMER APELLIDO :</strong></label><br>
                           <input type="text" name="papell_rec" class="form-control" style="text-transform:uppercase;" value=""  
                           onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
                       </div>
                   </div>
                   <div class="col-sm ">
                       <div class="form-group">
                           <label><strong>SEGUNDO APELLIDO :</strong></label><br>
                           <input type="text" name="sapell_rec" class="form-control" style="text-transform:uppercase;" value=""  
                           onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-sm">
                       <div class="form-group">
                           <label><strong>FECHA DE NACIMIENTO :</strong></label>
                           <input type="date" name="fecnac_rec" class="form-control" required="">
                       </div>
                   </div>
                   <div class="col-sm">
                       <div class="form-group">
                           <label><strong>SEXO :</strong></label>
                           <select name="sexo_rec" class="form-control" required="">
                               <option></option>
                               <option> SELECCIONA OPCION:</option>
                               <option value="MUJER">MUJER</option>
                               <option value="HOMBRE">HOMBRE</option>
                               <option value="SIN INFORMACION">SIN INFORMACIÓN</option>
                           </select>
                       </div>
                   </div>
                   <div class="col-sm">
                                <div class="form-group">
                                    <label for="aseg"><strong>ASEGURADORA:</strong></label><br>
                                    <select name="aseg" class="form-control" required>
                                        <?php
                                $resultadoaseg = $conexion->query("SELECT * FROM cat_aseg WHERE aseg_activo='SI'") or die($conexion->error);
                                ?>
                                <option value="">SELECCIONAR </option>
                                <?php foreach ($resultadoaseg as $opcionesaseg): ?>


                                    <option value="<?php echo $opcionesaseg['aseg'] ?>"><?php echo $opcionesaseg['aseg'] ?></option>

                                <?php endforeach ?>
                                    </select>
                                </div>
                   </div>
               </div>
      
<div class="row">
    <div class="col">
        <label><strong>ESPECIALIDAD</strong></label><br>
        <select name="esp" class="form-control" required onchange="habilitar(this.value);" required="">
            <?php $resultado=$conexion->query("SELECT * FROM cat_espec WHERE espec_activo='SI'") ?>
            <option></option>
            <option>SELECCIONAR OPCIÓN</option>
            <option value="OTROS">OTROS</option>
            <?php foreach ($resultado as $row ):?>
                <option value=" <?php echo $row['espec'] ?>"> <?php echo $row['espec'] ?></option>
            <?php endforeach ?>
           <!-- <option>SELECCIONAR OPCIÓN</option>
            <option value="CIRUGIA GENERAL Y GASTROENTEROLOGIA"> CIRUGÍA GENERAL Y GASTROENTEROLOGÍA</option>
            <option value="MEDICINA INTERNA">MEDICINA INTERNA</option>
            <option value="PEDIATRIA">PEDIATRÍA</option>
            <option value="NEUROCIRUGIA">NEUROCIRUGÍA</option>
            <option value="MEDICINA FAMILIAR">MEDICINA FAMILIAR</option>
            <option value="OTROS">OTROS</option>-->
        </select>
    </div>
    <div class="col">
       <label>DETALLE ESPECIALIDAD (OTROS)</label><br>
        <input type="text" name="detesp" id="esp"  disabled="" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
    </div>
    <div class="col">
        <label><strong>ALERGIA A MEDICAMENTOS:</strong></label>
        <input type="text" name="alergia_rec"  class="form-control"  style="text-transform:uppercase;" 
        onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
    </div>
</div>
<br>
<div class="row">
    <div class="col-4">
        <label><strong>TELÉFONO</strong></label><br>
        <input type="text" name="telefono" id="telefono" placeholder="TELÉFONO"  class="form-control" style="text-transform:uppercase;" 
        onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
    </div>
    <div class="col-4">
        <label><strong>LOCALIDAD</strong></label><br>
        <input type="text" name="localidad" id="localidad" placeholder="LOCALIDAD"  class="form-control" style="text-transform:uppercase;" 
        onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
    </div>
<!--    <div class="col">
        <label><strong>DIAGNÓSTICO</strong></label><br>
        <input type="text" name="diagnostico" id="diagnostico" placeholder="DIAGNÓSTICO" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
         
    </div>-->
   

</div>
<br>

      <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
                <div class="container"> <strong>
  <div class="row">
    <div class="col-sm-2"><br><center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="number" class="form-control" name="p_sistolica" required=""></div> /
  <div class="col"><input type="number" class="form-control" name="p_diastolica" required=""></div>
 
</div>
    </div>
    <div class="col-sm-2">
      FRECUENCIA CARDIACA:<input type="number" class="form-control" name="f_card" onkeypress="return recetaamb(event);" required="">
    </div>
    <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="number" class="form-control" name="f_resp" onkeypress="return recetaamb(event);" required="">
    </div>
    <div class="col-sm-2">
     <br>TEMPERATURA:<input type="cm-number" class="form-control"  name="temp" required="">
    </div>
    <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="number"  class="form-control" name="sat_oxigeno" onkeypress="return recetaamb(event);" required="">
    </div>
    <div class="col-sm-1">
     PESO (KILOS): <input type="cm-number" class="form-control"  name="peso" required="" >
    </div>
    <div class="col-sm-1">
     TALLA METROS:<input type="cm-number" class="form-control" name="talla" required="">
    </div>
  </div> </strong>
</div><br>
               <div class="row">
    <div class=" col">
     <div class="form-group">
        
  </div>
    </div>
</div>
<!--
 < <div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#2b2d7f">P</font></label></strong></center>
    </div>
   <div class=" col-10">
     <strong><font color="black">PACIENTE: DESCRIBIR AL PACIENTE (EDAD,GÉNERO, DIAGNÓSTICOS Y TRATAMIENTOS PREVIOS)</font></strong>
     <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" name="problema" rows="3" placeholder="PACIENTE: DESCRIBIR AL PACIENTE (EDAD,GÉNERO, DIAGNÓSTICOS Y TRATAMIENTOS PREVIOS)" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>
    </div>
</div>-->
 <div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5" color="#2b2d7f">S</font></label></strong></center>
    </div>
    <div class=" col-10">
      <strong><font color="black">SUBJETIVO: DESCRIBIR LA SINTOMATOLOGÍA DEL PACIENTE, HÁBITOS, A QUE ATRIBUYE EL PADECIMIENTO ACTUAL, ETC.
       <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone">
</button></i>
       <button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
      </div>
    </font></strong>
     <div class="form-group">

    <textarea class="form-control" id="texto" rows="3" name="subjetivo" required=""></textarea>
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
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f">O</font></label></strong></center>
    </div>
    <div class=" col-10">
      <strong><font color="black">OBJETIVO: DESCRIBIR LA EXPLORACIÓN FÍSICA </font></strong>
      <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="obg"><i class="fas fa-microphone">
</button></i>
       <button type="button" class="btn btn-primary btn-sm" id="desdet"><i class="fas fa-microphone-slash"></button></i>
      </div>
     <div class="form-group">
    <textarea class="form-control" id="txto" rows="3" name="objetivo" required=""></textarea>
    <script type="text/javascript">
const obg = document.getElementById('obg');
const desdet = document.getElementById('desdet');
const txto = document.getElementById('txto');

     let r = new webkitSpeechRecognition();
      r.lang = "es-ES";
      r.continuous = true;
      r.interimResults = false;

      r.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txto.value += frase;
      }

      obg.addEventListener('click', () => {
        r.start();
      });

      desdet.addEventListener('click', () => {
        r.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f">A</font></label></strong></center>
    </div>
    <div class=" col-10">
          <strong><font color="black">ANÁLISIS: LOS DIAGNÓSTICOS PROBABLES Y DEFINITIVOS Y LOS ARGUMENTOS, CORRELACIÓN DE LOS ESTUDIOS DE LABORATORIO Y GABINETE CON EL PADECIMIENTO ACTUAL.</font></strong>
          <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="ang"><i class="fas fa-microphone">
</button></i>
       <button type="button" class="btn btn-primary btn-sm" id="deta"><i class="fas fa-microphone-slash"></button></i>
      </div>
     <div class="form-group">
<textarea class="form-control" id="txta" rows="3" name="analisis" required=""></textarea>
<script type="text/javascript">
const ang = document.getElementById('ang');
const deta = document.getElementById('deta');
const txta = document.getElementById('txta');

     let ra = new webkitSpeechRecognition();
      ra.lang = "es-ES";
      ra.continuous = true;
      ra.interimResults = false;

      ra.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txta.value += frase;
      }

      ang.addEventListener('click', () => {
        ra.start();
      });

      deta.addEventListener('click', () => {
        ra.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f">P</font></label></strong></center>
    </div>
    <div class=" col-10">
<strong><font color="black">PLAN: DESCRIBIR TRATAMIENTO Y RECOMENDACIONES INDICADAS AL PACIENTE, ANOTAR LOS MEDICAMENTOS CON SU DOSIS DE MANERA DETALLADA.</font></strong>
<div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="plag"><i class="fas fa-microphone">
</button></i>
       <button type="button" class="btn btn-primary btn-sm" id="detpn"><i class="fas fa-microphone-slash"></button></i>
      </div>      
     <div class="form-group">
<textarea class="form-control" id="txtpa" rows="3" name="plan" required=""></textarea>
    <script type="text/javascript">
const plag = document.getElementById('plag');
const detpn = document.getElementById('detpn');
const txtpa = document.getElementById('txtpa');

     let rp = new webkitSpeechRecognition();
      rp.lang = "es-ES";
      rp.continuous = true;
      rp.interimResults = false;

      rp.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtpa.value += frase;
      }

      plag.addEventListener('click', () => {
        rp.start();
      });

      detpn.addEventListener('click', () => {
        rp.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
<div class="col-1">
<center><strong><label for="exampleFormControlTextarea1"><br><font size="5"color="#2b2d7f">PX</font></label></strong></center>
    </div>
    <div class=" col-10">
      <strong><font color="black">PRONÓSTICO: PARA LA VIDA Y PARA LA FUNCIÓN</font></strong>
      <div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="prog"><i class="fas fa-microphone">
</button></i>
       <button type="button" class="btn btn-primary btn-sm" id="detpar"><i class="fas fa-microphone-slash"></button></i>
      </div> 
     <div class="form-group">
<textarea class="form-control" id="txtico" rows="3" name="px" required="" ></textarea>
<script type="text/javascript">
const prog = document.getElementById('prog');
const detpar = document.getElementById('detpar');
const txtico = document.getElementById('txtico');

     let rpto = new webkitSpeechRecognition();
      rpto.lang = "es-ES";
      rpto.continuous = true;
      rpto.interimResults = false;

      rpto.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtico.value += frase;
      }

      prog.addEventListener('click', () => {
        rpto.start();
      });

      detpar.addEventListener('click', () => {
        rpto.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
    <div class=" col">
     <div class="form-group">
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
             <center><strong>M E D I C A M E N T O S</strong></center><p>
        </div>
<div class="botones">
        <button type="button" class="btn btn-danger btn-sm" id="medg"><i class="fas fa-microphone">
</button></i>
       <button type="button" class="btn btn-primary btn-sm" id="detos"><i class="fas fa-microphone-slash"></button></i>
      </div> 
<textarea class="form-control" id="txtm" rows="25" name="receta_rec" required=""></textarea>
<script type="text/javascript">
const medg = document.getElementById('medg');
const detos = document.getElementById('detos');
const txtm = document.getElementById('txtm');

     let rm = new webkitSpeechRecognition();
      rm.lang = "es-ES";
      rm.continuous = true;
      rm.interimResults = false;

      rm.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtm.value += frase;
      }

      medg.addEventListener('click', () => {
        rm.start();
      });

      detos.addEventListener('click', () => {
        rm.abort();
      });
</script>
  </div>
    </div>
</div>

<div class="row">
    <div class="col-sm">
        <center>
     <div class="form-group">
    <input type="button" id="mybutton" class="btn btn-danger btn-sm" onclick="showelemet();" value="MEDICAMENTOS CONTROLADOS"><font id="letra"></font>
  </div>
  </div>
</center>
</div>
<div class="row" id="receta">
    <div class=" col">
     <div class="form-group">
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
             <center><strong>MEDICAMENTOS CONTROLADOS</strong></center><p>
        </div>

<div class="botones">
       <button type="button" class="btn btn-danger btn-sm" id="congr"><i class="fas fa-microphone"></button></i>
       <button type="button" class="btn btn-primary btn-sm" id="detnt"><i class="fas fa-microphone-slash"></button></i>
      </div> 
    <textarea class="form-control" rows="15" name="med_cont" id="txtc"></textarea>
    <script type="text/javascript">
const congr = document.getElementById('congr');
const detnt = document.getElementById('detnt');
const txtc = document.getElementById('txtc');

     let rmc = new webkitSpeechRecognition();
      rmc.lang = "es-ES";
      rmc.continuous = true;
      rmc.interimResults = false;

      rmc.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtc.value += frase;
      }

      congr.addEventListener('click', () => {
        rmc.start();
      });

      detnt.addEventListener('click', () => {
        rmc.abort();
      });
</script>
  </div>
    </div>
</div>
<div class="row">
    <div class=" col">
     <div class="form-group">
        <label><strong>MEDIDAS HIGIÉNICAS-DIETÉTICAS : </strong></label>
        <input type="text" name="med_rec" class="form-control" required="">
  </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-2"></div>
    <div class=" col">
     <div class="form-group">
        <input type="button" id="mybutton1" class="btn btn-danger btn-sm" onclick="showelemet1();" 
        value="SOLICITAR LABORATORIOS"><font id="letra"></font>
     </div>
    </div>

    <div class="col-sm-1"></div>
    <div class=" col">
     <div class="form-group">
        <input type="button" id="mybutton2" class="btn btn-danger btn-sm" onclick="showelemet2();" 
        value="SOLICITAR IMAGENOLOGIA"><font id="letra"></font>
     </div>
    
</div>

</div>
<div class="row" id="labora">
    <div class=" col">
     <div class="form-group">
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
             <center><strong>SOLICITAR LABORATORIOS</strong></center><p>
        </div>
        
        <input type="text" name="sol_labo" class="form-control" >
     </div>
    </div>
</div>


<div class="row" id="imagen">
    <div class=" col">
     <div class="form-group">
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 19px;">
             <center><strong>SOLICITAR IMAGENOLOGIA</strong></center><p>
        </div>
        
        <input type="text" name="sol_img" class="form-control" >
     </div>
    </div>
</div>


<!--
<b>CITA ABIERTA</b>
<input type="checkbox" name="cita" id="check" value="Cita abierta" onchange="javascript:showContent()"  checked="checked" disabled/>
<strong><label> </label></strong>-->

<!--<div class="row">
    <div class="col-sm-4"><strong>FECHA DE PRÓXIMA CITA</strong>
        <input type="datetime-local" name="fec_pcita" class="form-control" id="content" style="display: block;">
    </div>
</div>-->

<!--
<strong><label> </label></strong>
<div class="row">
    <div class="col-sm-4"><strong>FECHA DE PRÓXIMA CITA</strong>
        <input type="date" name="fec_pcita" class="form-control" required="">
    </div>
    <div class="col-sm-2"><strong>HORA :</strong>
        <input type="number" min="00" max="24" name="hor_pcita" class="form-control">
    </div>
    <div class="col-sm-2"><strong>MINUTOS :</strong>
        <input type="number" min="00" max="59" name="min_pcita" class="form-control">
    </div>
</div>-->

<?php  
$usuario = $_SESSION['login'];
?>
<hr>

  <div class="row">
    <div class="col align-self-start">
   <strong>MÉDICO:</strong> <input type="text" name="" class="form-control" value="<?php echo $usuario['papell'];?> <?php echo $usuario['sapell'];?>" disabled> 
    </div>
    <div class="col align-self-center">
      <strong>CED. PROF:</strong><input type="text" name="" class="form-control" value="<?php echo $usuario['cedp'];?>" disabled="">
      
    </div> 
  <!--  <div class="col align-self-end">
     <strong>REG S.S.A:</strong><input type="text" name="reg_ssa_rec" class="form-control" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();"> 
    </div>-->
  </div><br>
<center><strong>FIRMA:<br></strong><img src="../../imgfirma/<?php echo $usuario['firma']; ?>" width="100" /></center>
<hr>

<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <button type="submit" name="guardarR" class="btn btn-danger btn-sm"><font size="3">FIRMAR E IMPRIMIR</font></button>
        </div>
<!--        <div class="col-sm-4">
           <button type="submit" name="guardarRN" class="btn btn-danger btn-sm"><font size="3">FIRMAR, GUARDAR <br>E IMPRIMIR RECETA/NOTA</font></button> 
        </div>
        <div class="col-sm-4">
           <button type="submit" name="guardarRMC" class="btn btn-danger btn-sm"><font size="3">FIRMAR, GUARDAR <br>E IMPRIMIR R.CONTROLADOS</font></button> 
        </div>    -->
    </div><hr>
<div class="row">
    <div class="col-sm">
<center>
<button type="button" class="btn btn-danger btn-sm" onclick="history.back()">CANCELAR</button>
</center>
    </div>     
</div>
</div>
 </form><hr>
<?php 

/*
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
RECETA SOLITA
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
*/
if (isset($_POST['guardarR'])) {
      $usuario=$_SESSION['login'];
      $id_usua=$usuario['id_usua'];
        $nombre_rec    = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre_rec"], ENT_QUOTES)));
        $papell_rec    = mysqli_real_escape_string($conexion, (strip_tags($_POST["papell_rec"], ENT_QUOTES)));
        $sapell_rec  = mysqli_real_escape_string($conexion, (strip_tags($_POST["sapell_rec"], ENT_QUOTES)));
        $fecnac_rec    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecnac_rec"], ENT_QUOTES))); 
        $sexo_rec    = mysqli_real_escape_string($conexion, (strip_tags($_POST["sexo_rec"], ENT_QUOTES)));

        $alergia_rec  = mysqli_real_escape_string($conexion, (strip_tags($_POST["alergia_rec"], ENT_QUOTES)));
        $p_sistolica    = mysqli_real_escape_string($conexion, (strip_tags($_POST["p_sistolica"], ENT_QUOTES))); 
        $p_diastolica    = mysqli_real_escape_string($conexion, (strip_tags($_POST["p_diastolica"], ENT_QUOTES)));

        $f_card    = mysqli_real_escape_string($conexion, (strip_tags($_POST["f_card"], ENT_QUOTES)));
        $f_resp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["f_resp"], ENT_QUOTES)));
        $temp  = mysqli_real_escape_string($conexion, (strip_tags($_POST["temp"], ENT_QUOTES)));
        $sat_oxigeno    = mysqli_real_escape_string($conexion, (strip_tags($_POST["sat_oxigeno"], ENT_QUOTES))); 
        $peso    = mysqli_real_escape_string($conexion, (strip_tags($_POST["peso"], ENT_QUOTES)));

        $talla    = mysqli_real_escape_string($conexion, (strip_tags($_POST["talla"], ENT_QUOTES)));
        $aseg    = mysqli_real_escape_string($conexion, (strip_tags($_POST["aseg"], ENT_QUOTES)));
   /*     $fec_pcita    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fec_pcita"], ENT_QUOTES)));
        $hor_pcita    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hor_pcita"], ENT_QUOTES)));
        $min_pcita    = mysqli_real_escape_string($conexion, (strip_tags($_POST["min_pcita"], ENT_QUOTES)));

        $hor_pcita=$hor_pcita.':'.$min_pcita.':'.'00';*/
        
 /*        $fec_pcita    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fec_pcita"], ENT_QUOTES)));*/
       
    $telefono= mysqli_real_escape_string($conexion, (strip_tags($_POST["telefono"], ENT_QUOTES)));  
    $localidad = mysqli_real_escape_string($conexion, (strip_tags($_POST["localidad"], ENT_QUOTES)));
   /* $diagnostico= mysqli_real_escape_string($conexion, (strip_tags($_POST["diagnostico"], ENT_QUOTES)));*/

    $subjetivo  = mysqli_real_escape_string($conexion, (strip_tags($_POST["subjetivo"], ENT_QUOTES)));
    $objetivo  = mysqli_real_escape_string($conexion, (strip_tags($_POST["objetivo"], ENT_QUOTES)));
    $analisis  = mysqli_real_escape_string($conexion, (strip_tags($_POST["analisis"], ENT_QUOTES)));
    $plan  = mysqli_real_escape_string($conexion, (strip_tags($_POST["plan"], ENT_QUOTES)));
    $px  = mysqli_real_escape_string($conexion, (strip_tags($_POST["px"], ENT_QUOTES)));
    $receta_rec  = mysqli_real_escape_string($conexion, (strip_tags($_POST["receta_rec"], ENT_QUOTES)));
    $med_rec  = mysqli_real_escape_string($conexion, (strip_tags($_POST["med_rec"], ENT_QUOTES)));

     if(isset($_POST["sol_labo"])){
            $sol_labo = mysqli_real_escape_string($conexion, (strip_tags($_POST["sol_labo"], ENT_QUOTES)));
        }else{
            $sol_labo="";
        }

     if(isset($_POST["sol_img"])){
            $sol_img = mysqli_real_escape_string($conexion, (strip_tags($_POST["sol_img"], ENT_QUOTES)));
        }else{
            $sol_img="";
        }

    $esp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["esp"], ENT_QUOTES)));

        if(isset($_POST["detesp"])){
            $detesp  = mysqli_real_escape_string($conexion, (strip_tags($_POST["detesp"], ENT_QUOTES)));
        }else{
            $detesp=" ";
        }

    if(isset($_POST["med_cont"])){
             $med_cont  = mysqli_real_escape_string($conexion, (strip_tags($_POST["med_cont"], ENT_QUOTES)));
        }else{
             $med_cont=" ";
        }

function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
        $bisiesto=true;
        return $bisiesto;
 }

 function calculaedad($fecnac)
 {


$fecha_actual = date("Y-m-d H:i:s");
$fecha_nac=$fecnac;
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
           case 10:    $dias_mes_anterior=30; break;
           case 11:    $dias_mes_anterior=31; break;
           case 12:    $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

 if($anos > "0" ){
   $edad = $anos." AÑOS";
}elseif($anos <="0" && $meses>"0"){
   $edad = $meses." MESES";
    
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    $edad = $dias." DÍAS";
}

 return $edad;
}

$edad = calculaedad($fecnac_rec);


$fecha_actual = date("Y-m-d H:i:s");

$insert=mysqli_query($conexion,'INSERT INTO receta_ambulatoria
(id_usua,
fecha,
nombre_rec,
papell_rec,
sapell_rec,
fecnac_rec,
edad,
sexo_rec,
especialidad,
detesp,
alerg_rec,
receta_rec,
med_rec,
sol_labo,
sol_img,
aseguradora,
subjetivo,
objetivo,
analisis,
plan,
px,
p_sistolica,
p_diastolica,
f_card,
f_resp,temp,
sat_oxigeno,
peso,
talla,
med_cont,
telefono,
localidad) VALUES 
('.$id_usua.',
"'.$fecha_actual.'",
"'.$nombre_rec.'",
"'.$papell_rec.'",
"'.$sapell_rec.'",
"'.$fecnac_rec.'",
"'.$edad.'",
"'.$sexo_rec.'",
"'.$esp.'",
"'.$detesp.'",
"'.$alergia_rec.'",
"'.$receta_rec.'",
"'.$med_rec.'",
"'.$sol_labo.'",
"'.$sol_img.'",
"'.$aseg.'",
"'.$subjetivo.'",
"'.$objetivo.'",
"'.$analisis.'",
"'.$plan.'",
"'.$px.'",
' . $p_sistolica . ' ,
' . $p_diastolica . ' ,
' . $f_card . ' ,
' . $f_resp . ' ,
' . $temp . ' ,
' . $sat_oxigeno .' ,
' . $peso . ' ,
' . $talla . ',
"' . $med_cont . '",
"' . $telefono . '",
"' . $localidad . '")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

    
$fecha= date("Y-m-d H:i:s");
    $select="SELECT * FROM reg_usuarios where id_usua=$id_usua";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $usuario=$row['papell'].' '.$row['sapell'];
    }

$nombre=$nombre_rec.' '.$papell_rec.' '.$sapell_rec;

/*
$insert="INSERT INTO pserv(nombre,fecha,usuario,tipo) values('$nombre','$fecha','$usuario','RECETA')";
$result_insert=$conexion->query($insert);*/

$select="SELECT * FROM receta_ambulatoria order by id_rec_amb DESC LIMIT 1";
$result=$conexion->query($select);
while ($row=$result->fetch_assoc()) {
    $id_amb=$row['id_rec_amb'];
}

if ($sol_labo == "") {
    } else {
$insertarnotlabo=mysqli_query($conexion,'INSERT INTO notificaciones_labo(id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado) values ('.$id_amb.',"Consulta","'.$fecha_actual.'",'.$id_usua.',"'.$sol_labo.'","NO","")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
 }

if ($sol_img == "") {
    } else {
$insertarnotimg=mysqli_query($conexion,'INSERT INTO notificaciones_imagen(id_atencion,habitacion,fecha_ord,id_usua,sol_estudios,realizado,resultado) values ('.$id_amb.',"Consulta","'.$fecha_actual.'",'.$id_usua.',"'.$sol_img.'","NO","")')or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
 }
  echo '<script >window.open("pdf_receta_amb.php?id='.$id_amb.'", "RECETA AMBULATORIA", "width=1000, height=1000")</script>'.
 '<script type="text/javascript">window.location.href ="receta_ambulatoria.php" ;</script>';

}
 ?>
               

      
    </div>       
    </div>
    </div>
    </div>
<?php 

 ?>
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
<script src="js_busc/search.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>

<script type="text/javascript">
    $("#receta").hide();
    function showelemet(){
        let text="";
        if($("#mybutton").text()==="RECETA MEDICAMENTOS CONTROLADOS"){
            $("#receta").show();
            text="OCULTAR RECETA MEDICAMENTOS CONTROLADOS";
        } else{
            $("#receta").hide();
            text="RECETA MEDICAMENTOS CONTROLADOS";
        }
        $("#mybutton").html(text);
    }
</script>

<script type="text/javascript">
    $("#labora").hide();
    function showelemet1(){
        let text="";
        if($("#mybutton1").text()==="SOLICITAR LABORATORIOS"){
            $("#labora").show();
            text="OCULTAR SOLICITAR LABORATORIOS";
        } else{
            $("#labora").hide();
            text="SOLICITAR LABORATORIOS";
        }
        $("#mybutton1").html(text);
    }
</script>

<script type="text/javascript">
    $("#imagen").hide();
    function showelemet2(){
        let text="";
        if($("#mybutton2").text()==="SOLICITAR IMAGENOLOGIA"){
            $("#imagen").show();
            text="OCULTAR SOLICITAR IMAGENOLOGIA";
        } else{
            $("#imagen").hide();
            text="SOLICITAR IMAGENOLOGIA";
        }
        $("#mybutton2").html(text);
    }
</script>


</body>
</html>