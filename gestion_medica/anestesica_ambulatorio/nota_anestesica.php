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
            <div class="col">
                
<div class="thead" style="background-color: #0c675e; color: white; font-size: 24px;">
  <center><strong>  VALORACIÓN PRE-ANESTÉSICA</strong></center><p>
</div>
    <hr>
<?php

include "../../conexionbd.php";

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);

?>
  <?php
                    while ($f1 = mysqli_fetch_array($resultado1)) {

                        ?>
<div class="container"> 
                        <div class="row">
      <div class="col-sm-6">
 NO.EXPEDIENTE : <td><strong><?php echo $f1['Id_exp']; ?></strong></td><br>
PACIENTE : <td><strong><?php echo $f1['papell']; ?></strong></td>
<td><strong><?php echo $f1['sapell']; ?></strong></td>
<td><strong><?php echo $f1['nom_pac']; ?></strong></td><br>
SEXO : <td><strong><?php echo $f1['sexo']; ?></strong></td><br>
   
    </div>

    <div class="col-sm-4">
<?php $date = date_create($f1['fecha']);
$date1 = date_create($f1['fecnac']);
                                     ?>
      FECHA DE INGRESO : <td><strong><?php echo date_format($date, "d/m/Y"); ?></strong></td><br>
      FECHA DE NACIMIENTO : <td><strong><?php echo date_format($date1, "d/m/Y"); ?></strong></td><br>
      EDAD : <td><strong><?php echo $f1['edad']; ?></strong></td><br>  
    <?php  
                    }
                    ?> 
    </div>

<?php
$resultado2 = $conexion->query("select * from cat_camas WHERE id_atencion=" .$_GET['id_atencion']) or die($conexion->error);
while ($f2 = mysqli_fetch_array($resultado2)) {
?>
  <div class="col">
<?php  
 if(isset($f2)){
    $cama=$f2['num_cama'];
  }else{
    $cama='Sin Cama';
  }
 ?>
HABITACIÓN : <td><strong><?php echo $cama; ?></strong></td> 

<?php
}
?>
    </div>
    
    
  </div>

</div>
<hr>
 </div>   
 <div class="row">
            <div class="col-sm-10">
                <?php
                
                $fecha_actual = date("Y-m-d H:i:s");
                ?>
                
                <div class="form-group">
                    <label for="fecha">FECHA Y HORA ACTUAL:</label>
                    <input type="datetime" name="fec_hc" value="<?= $fecha_actual ?>" class="form-control" disabled>
                </div>
            </div>
        </div>
      <div class="container">  <!--INICIO DE CONSULTA DE URGENCIAS-->
<form action="insertar_nota_anest.php?id_atencion= <?php echo $_GET['id_atencion'] ?>" method="POST">
                
<div class="container">
<div class="row">
<div class="col">
<label><strong>DIAGNÓSTICO PREOPERATORIO:</strong></label>
<input type="text"  class="form-control" name="diagpre" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
</div>
<div class="col">
<label><strong>ÁREA:</strong></label>
<input type="text"  class="form-control" name="area" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
</div>
</div>
</div>
<hr>
<div class="row">
 

  <div class="col"> <div class="form-check">
  <input class="form-check-input" type="radio" name="urg" id="flexRadioDefault3" value="URGENCIA" required>
  <label class="form-check-label" for="flexRadioDefault3">
    URGENCIA
  </label>
</div></div>
  <div class="col"><div class="form-check">
  <input class="form-check-input" type="radio" name="urg" id="flexRadioDefault4" value="ELECTIVA" required>
  <label class="form-check-label" for="flexRadioDefault4">
    ELECTIVA
  </label>
</div></div>
<tr>|</tr>
   <div class="col"><strong>INTERROGAROTRIO:</strong></div>
  <div class="col">  <div class="form-check">
  <input class="form-check-input" type="radio" name="inter" id="flexRadioDefault5" value="DIRECTO" required>
  <label class="form-check-label" for="flexRadioDefault5">
    DIRECTO
  </label>
</div>  </div>
   <div class="col col-3">
    <div class="form-check">
  <input class="form-check-input" type="radio" name="inter" id="flexRadioDefault6" value="INDIRECTO" required>
  <label class="form-check-label" for="flexRadioDefault6">
    INDIRECTO
  </label>
</div>
</div>
  
</div>
<hr>
<div class="row">
<div class="col">
<label><strong>PROCEDIMIENTO PROGRAMADO</strong></label>
<input type="text" name="proc_prog" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
</div>
<div class="col">
  <label><strong>MÉDICO RESPONSABLE DEL PROCEDIMIENTO</strong></label>
<input type="text" name="med_proc" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"required>
</div>
<div class="col">
  <label><strong>ANESTESIÓLOGO</strong></label>
<input type="text" name="anest" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
</div>
</div>
<hr>


<div class="row">
  <div class="col">
    <table class="table table-bordered">
  <thead>
    <tr color="red">
      <th scope="col">ANTECEDENTES NO PATOLOGICOS</th>
      <th scope="col">SI</th>
      <th scope="col">NO</th>
 
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>INMUNIZACIONES</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="inmun" id="in" value="SI" required>
  <label class="form-check-label" for="in">

  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="inmun" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
     
    </tr>
    <tr>
      <td>TABAQUISMO</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="tab" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="tab" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
    <tr>
      <td>ALCOHOLISMO</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="alc" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="alc" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
    <tr>
      <td>TRANSFUSIONALES</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="trans" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="trans" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
    <tr>
      <td>ALERGIAS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="alerg" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="alerg" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
    <tr>
      <td>TOXICOMANIAS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="toxi" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="toxi" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>

     <tr>
      <th>ANTECEDENTES PATOLOGICOS</th>
 
    </tr>

 <tr>
      <td>GASTRO/HEPÁTICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="gastro" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="gastro" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>NEUROLÓGICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="neuro" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="neuro" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>NEUMOLÓGICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="neumo" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="neumo" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>RENALES</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="ren" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="ren" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>CARDIOLÓGICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="card" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="card" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>ENDÓCRINOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="end" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="end" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>REUMÁTICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="reu" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="reu" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
   
     <tr>
      <td>NEOPLASICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="neo" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="neo" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>HEMATOLOGICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="herma" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="herma" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>TRAUMÁTICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="trau" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="trau" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>PSIQUIÁTRICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="psi" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="psi" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
      <tr>
      <td>QUIRÚRGICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="quir" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="quir" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
      <tr>
      <td>ANESTÉSICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="aneste" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="aneste" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
      <tr>
      <td>GINECO-OBSTÉTRICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="gin" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="gin" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
      <tr>
      <td>PEDIÁTRICOS</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="ped" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="ped" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
    <th>ANTECEDENTES NEUROLÓGICOS</th>
     <tr>
      <td>CONSCIENTE</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="cons" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="cons" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
     <tr>
      <td>OTRO</td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="otro" id="in2" value="SI" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
      <td><div class="form-check">
  <input class="form-check-input" type="radio" name="otro" id="in2" value="NO" required>
  <label class="form-check-label" for="in2">
   
  </label>
</div></td>
    
    </tr>
  </tbody>
</table>
  </div>

  <div class="col">
    <center><h6><strong>VALORACIÓN DE ANTECEDENTES:</strong></h6></center>
     <div class="form-group">
 
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="36" style="text-transform:uppercase;" name="valant" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
  </div>
 <center><h6><strong>PADECIMIENTO ACTUAL:</strong></h6></center>
   <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" style="text-transform:uppercase;" name="pad_act" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
  </div>

<center><h6><strong>MEDICACIÓN ACTUAL:</strong></h6></center>
   <div class="form-group">
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" style="text-transform:uppercase;" name="med_act" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
  </div>
<div class="row">
  <div class="col-12">
    <h6><strong>AYUNO:</strong></h6>
    <div class="form-group">
   <input type="text"  class="form-control" style="text-transform:uppercase;" name="ayuno" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
 </div>
</div>
  <div class="col"><h6><strong>ESPECIFICAR (OTRO):</strong></h6>
  <div class="form-group">
   <input type="text" class="form-control" style="text-transform:uppercase;" name="esp" onkeyup="javascript:this.value=this.value.toUpperCase();">
 </div>
 </div>
</div>
  </div>
</div>

<hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
  <center><strong> EXPLORACIÓN FÍSICA</strong></center><p>
</div>
<div class="row">
  <div class="col"><strong><br>SIGNOS VITALES</strong></div>
    <div class="row">
      <div class="col">
      TA:<br><input type="number" name="ta_sisto" placeholder="mmHg"  id="p_sistolica"  value=""   required> / <label for="p_sistolica"><input type="number" name="ta_diasto"   placeholder="mmHg" id="p_diastolica"   value="" required>
      </div>
    </div>
  <div class="col">FC:<input type="text" name="fc" class="form-control" placeholder="FC:" required></div>
  <div class="col">FR:<input type="text" name="fr" class="form-control" placeholder="FR:" required></div>
  <div class="col">TEMP:<input type="text" name="tempe" class="form-control" placeholder="TEMP:" required></div>


<div class="col losInput">PESO:<input type="text" name="pes" class="form-control" placeholder="PESO:" required id="pes" minlength="2" maxlength="7"></div>
<div class="col losInput">TALLA:<input type="text" name="tall" class="form-control" placeholder="TALLA:" required id="tall" maxlength="4"></div>

<div class="col inputTotal">IMC:<input type="text" name="imc" class="form-control" placeholder="IMC:" required id="imc" disabled="">
</div>

</div>


            <hr>
<div class="row">
  <div class="col col-2"><strong><br><br>VÍA ÁREA</strong></div>
  <div class="col"><br>MALLAMPATI<input type="text" name="malla" class="form-control" required></div>
  <div class="col"><br>PATIL ALDRETI<input type="text" name="patil" class="form-control" required></div>
  <div class="col"><br>BELLHOUSE-DORE<input type="text" name="bell" class="form-control" required></div>
  <div class="col">DISTANCIA ESTEMOMENTONIANA<input type="text" name="dist" class="form-control"required ></div>
  <div class="col"><br>BUCO-DENTAL<input type="text" name="buco" class="form-control" required></div>
</div>
                    OBSERVACIONES<input type="text" name="obserb" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
        <hr>

  <div class="row">
    <div class="col-sm-3">
   <br><hr>FECHA <input type="date" name="fecha" class="form-control" required>
    </div>
  <div class="col-sm-9">
 <div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
  <center><strong> LABORATORIO</strong></center><p>
</div>
    <div class="row">
  <div class="col">HB<input type="text" name="hb" class="form-control" required></div>
  <div class="col">HTO<input type="text" name="hto" class="form-control" required></div>
  <div class="col">GB<input type="text" name="gb" class="form-control" required></div>
  <div class="col">GR<input type="text" name="gr" class="form-control" required></div>
  <div class="col">PLAQ<input type="text" name="plaq" class="form-control" required></div>
  <div class="col">TP<input type="text" name="tp" class="form-control" required></div>
  <div class="col">TPT<input type="text" name="tpt" class="form-control" required></div>
  
</div>
  <div class="row">
  <div class="col">INR<input type="text" name="inr" class="form-control" required></div>
  <div class="col">GLUC<input type="text" name="gluc" class="form-control" required></div>
  <div class="col">CR<input type="text" name="cr" class="form-control"required></div>
  <div class="col">BUN<input type="text" name="bun" class="form-control" required></div>
  <div class="col">UREA<input type="text" name="urea" class="form-control" required></div>
  <div class="col">E.S.<input type="text" name="es" class="form-control" required></div>
  
</div>
  <div class="row">
  <div class="col">OTROS<input type="text" name="otros" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>

  
</div>

    </div>

</div>

<hr>
<div class="row">
  <div class="col"><strong>GABINETE: </strong><input required type="text" name="gab" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
  <div class="col"><strong>VALORACIÓN CARDIOVASCULAR: </strong><input required type="text" name="valcard" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
</div><br>
<div class="row">
  <div class="col"><strong>CONDICIÓN FÍSICA ASA: </strong><input required type="text" name="condfis" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
  <div class="col"><strong>TIPO DE ANESTESIA PROPUESTA: </strong><input required type="text" name="tipanest" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
</div><br>
<div class="row">
  <div class="col"><strong>INDICACIÓN PREANESTÉSICA: </strong><input required type="text" name="indpre" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
  <div class="col"><strong>OBSERVACIONES: </strong><input required type="text" name="obs" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></div>
</div>
<br>
<!--<strong>NOMBRE COMPLETO DEL RESIDENTE QUE COLABORA EN LA VALORACIÓN: </strong><input required type="text" name="nomres" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">-->

 <strong>NOMBRE COMPLETO DEL ANESTÉSIOLOGO: </strong><input required type="text" name="nomanest" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
 

<hr>


 
<center>
                       <div class="form-group col-6">
                            <button type="submit" class="btn btn-primary">FIRMAR</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button>
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


<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });

$('.losInput input').on('change', function(){
  var total = 0;
  var pes, tall, imc;
   pes=document.getElementById("pes").value;
  tall=document.getElementById("tall").value;
  $('.losInput input').each(function() {
    if($( this ).val() != "")
    {
        parseInt(total=pes/(tall*tall));
    }
  });
   
  $('.inputTotal input').val(total.toFixed(2));

});

</script>


</body>
</html>