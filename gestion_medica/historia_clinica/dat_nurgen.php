<?php
session_start();
include "../../conexionbd.php";
include("../header_medico.php");
if (isset($_GET['id_atencion'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
    $resultado = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp  WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);
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
    
<style type="text/css">
    #contenido{
        display: none;
    }
</style>

</head>
<body>

<div class="col-sm-12">
    <div class="container">
        <div class="row">
            <div class="col">
                
<div class="thead col col-12" style="background-color: #2b2d7f ; color: white; font-size: 26px; align-content: center;"><strong>CONSULTA (OBSERVACIÓN)</strong></div>
                <hr>
<?php

include "../../conexionbd.php";

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);

?>
  <?php
                    while ($f1 = mysqli_fetch_array($resultado1)) {
                        $sexo=$f1['sexo'];
                          $pac_fecnac=$f1['fecnac'];
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
                      <div class="container">
  <div class="row">
    <div class="col-sm-5">
        EXPEDIENTE: <td><strong><?php echo $f1['folio']; ?></strong></td>
    </div>
    
     <div class="col-sm-5">
       PACIENTE:
<td><strong><?php echo $f1['papell']; ?></strong></td>
                            <td><strong><?php echo $f1['sapell']; ?></strong></td>
                            <td><strong><?php echo $f1['nom_pac']; ?></strong></td>
    </div>
  </div>
</div>
<div class="container">      
                           
  <div class="row">
   

    <div class="col-sm-5">
     FECHA DE NACIMIENTO:<strong> <?php  $date = date_create($f[5]);
 echo date_format($date,"d/m/Y");?></strong>
    </div>
    <div class="col-sm-5">
      EDAD: <strong><?php if($anos > "0" ){
   echo $anos." AÑOS";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." MESES";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." DIAS";
}
?></strong>
    </div>
  </div>
</div>
<hr>
                        <?php  
                    }
                    ?>             
                        
            </div>
            <div class="col-sm-3">
                <?php
                
                $fecha_actual = date("d-m-Y H:i:s");
                ?>
                
                <div class="form-group">
                    <label for="fecha">FECHA Y HORA:</label>
                    <input type="datetime" name="fec_hc" value="<?= $fecha_actual ?>" class="form-control" disabled>
                </div>
            </div>
        </div>



  
      <div class="container">  <!--INICIO DE CONSULTA DE URGENCIAS-->


    <?php $id_cli = $_GET['id_atencion']; ?>

     <?php $id_usua = $_GET['id_usua']; ?>
<form action="insertar_dat_c_urgen.php?id_atencion=<?php echo $_GET['id_atencion']; ?>&id_usua=<?php echo $_GET['id_usua'];?>" method="POST">

                <div class="row col-2">
                    <div class="col-sm">
                       
                        <?php $id_cli = $_GET['id_atencion']; ?>
                        <input type="hidden" name="id_atencion" class="form-control" value="<?php echo $id_cli ?>"
                               readonly placeholder="No. De expediente">
                               
                        <?php $id_usua = $_GET['id_usua']; ?>
                        <input type="hidden" name="id_usua" class="form-control" value="<?php echo $id_usua ?>"
                               readonly placeholder="NO usuario">
                    </div>
                </div>

<?php

include "../../conexionbd.php";

$resultado2=$conexion->query("select * from triage WHERE id_atencion=" . $_GET['id_atencion'].' order by id_triage DESC limit 1') or die($conexion->error);
?>

<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>SIGNOS VITALES</center></strong>
  </div>
<p>

            <div class="container"> 
  <div class="row">
    
      <?php
                    while ($f2 = mysqli_fetch_array($resultado2)) {

                        ?>
    
  <div class="col-sm-2"><br><center>PRESIÓN ARTERIAL:</center>
  <div class="row">
  <div class="col"><input type="text" class="form-control" value="<?php echo $f2['p_sistolica'];?>" disabled></div> /
  <div class="col"><input type="text" class="form-control" value="<?php echo $f2['p_diastolica'];?>" disabled></div>
 
</div>
    </div>
    <div class="col-sm-2">
      FRECUENCIA CARDIACA:<input type="text" class="form-control" value="<?php echo $f2['f_card'];?>" disabled>
    </div>
    <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" class="form-control" value="<?php echo $f2['f_resp'];?>" disabled>
    </div>
    <div class="col-sm-1">
     <br>TEMP:<input type="text" class="form-control" value="<?php echo $f2['temp'];?>" disabled>
    </div>
    <div class="col-sm-2">
     SATURACIÓN DE OXÍGENO:<input type="text"  class="form-control" value="<?php echo $f2['sat_oxigeno'];?>" disabled>
    </div>
    <div class="col-sm-1">
     <br>PESO:<input type="text" class="form-control" value="<?php echo $f2['peso'];?>" disabled>
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="text" class="form-control" value="<?php echo $f2['talla'];?>" disabled>
    </div>
    <div class="col-sm-1">
    ESCALA EVA:<input type="text" class="form-control" value="<?php echo $f2['niv_dolor'];?>" disabled>
    </div>
  </div>
</div>
<?php 
 }
 ?>

<br>
  
  <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>MOTIVO DE CONSULTA:</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="motcon_cu" style="text-transform:uppercase;"></textarea>
  </div>
     
  <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>ANTECEDENTES HEREDO FAMILIARES</center></strong>
  </div>
<p>
  <div class="row">
    <div class="col-sm">
     <strong><p>DIABETES:</p></strong>
     <div class="form-check">
  <input class="form-check-input" type="checkbox" id="PADRE" value="SI" name="diab_pa">
  <label class="form-check-label" for="PADRE">
    PADRE
  </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" id="MADRE" value="SI" name="diab_ma">
  <label class="form-check-label" for="MADRE">
    MADRE
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="ABUELOS" value="SI" name="diab_ab">
  <label class="form-check-label" for="ABUELOS">
    ABUELOS
  </label>
</div>

    </div>
    <div class="col-sm">
     
       <strong><p>HIPERTENSIÓN:</p></strong>
     <div class="form-check">
  <input class="form-check-input" type="checkbox" id="PADRE2" value="SI" name="hip_pa">
  <label class="form-check-label" for="PADRE2">
    PADRE
  </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" id="MADRE2" value="SI" name="hip_ma">
  <label class="form-check-label" for="MADRE2">
    MADRE
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="ABUELOS2" value="SI" name="hip_ab">
  <label class="form-check-label" for="ABUELOS2">
    ABUELOS
  </label>
</div>

    </div>
    <div class="col-sm">
     
  <strong><p>CÁNCER:</p></strong>
     <div class="form-check">
  <input class="form-check-input" type="checkbox" id="PADRE3" value="SI" name="can_pa">
  <label class="form-check-label" for="PADRE3">
    PADRE
  </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" id="MADRE3" value="SI" name="can_ma">
  <label class="form-check-label" for="MADRE3">
    MADRE
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="ABUELOS3" value="SI" name="can_ab">
  <label class="form-check-label" for="ABUELOS3">
    ABUELOS
  </label>
</div>

    </div>
  </div>

<hr>
  

  <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>ANTECEDENTES PERSONALES NO PATOLÓGICOS</center></strong>
  </div>
<p>
<div class="row">

   <div class="col-sm">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="adic_cu" id="adic_cu" value="DROGAS">
        <label class="form-check-label" for="flexRadioDefault1">
         <h6>DROGAS</h6>
         </label>
      </div>
  </div>


   <div class="col-sm">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="tab_cu" id="tab_cu" value="TABACO">
        <label class="form-check-label" for="tab_cu">
        <h6>TABACO</h6>
        </label>
      </div>
   </div>

    <div class="col-sm">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="alco_cu" id="alco_cu" value="ALCOHOL">
        <label class="form-check-label" for="alco_cu">
        <h6>ALCOHOL</h6>
        </label>
      </div>
    </div>

    <!--<div class="col-sm">
      <div class="form-check">   
        <input class="form-check-input" type="checkbox" name="otro_cu" id="flexRadioDefault1" value="OTROS">
        <label class="form-check-label" for="flexRadioDefault1">
        <h6>OTRAS</h6>
        </label>
      </div>
    </div>-->
</div>
    <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>OTROS ANTECEDENTES PERSONALES NO PATOLÓGICOS:</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name=" otro_cu"></textarea>
  
</div>

<hr>
  

<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>ANTECEDENTES PERSONALES PATOLÓGICOS</center></strong>
  </div>
<p>

  <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>QUIRÚRGICOS:</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name=" quir_cu"></textarea>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>TRAUMÁTICOS:</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name=" trau_cu"></textarea>
  </div>

  <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>OTROS ANTECEDENTES PERSONALES PATOLÓGICOS:</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name=" despatol"></textarea>
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
<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>PADECIMIENTO ACTUAL</center></strong>
</div>
<p>

    <div class="form-group">
      <label for="exampleFormControlTextarea1"><strong>PADECIMIENTO ACTUAL:</strong></label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="pad_cu" style="text-transform:uppercase;"></textarea>
    </div>

    <div class="form-group">
      <label for="exampleFormControlTextarea1"><strong>EXPLORACIÓN FÍSICA:</strong></label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="exp_cu" style="text-transform:uppercase;"></textarea>
    </div>


<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>DIAGNÓSTICOS</center></strong>
  </div>
<p>      

<div class="row">
    <div class="col-8">
        <div class="form-group">
            <label for="id_cie_10"><strong>SELECCIONAR DIAGNÓSTICO PRINCIPAL:</strong></label>
            <select name="diag_cu" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%">
                <?php
                include "../../conexionbd.php";
                $sql_diag="SELECT * FROM cat_diag ";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['diagnostico'] . "'>" . $row['diagnostico'] . "</option>";
                } ?>
                
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-8">
        <div class="form-group">
            <label for="id_cie_10"><strong>SELECCIONAR DIAGNÓSTICO SECUNDARIO:</strong></label>
            <select name="diag2" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%">
                <?php
                include "../../conexionbd.php";
                $sql_diag="SELECT * FROM cat_diag ";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['diagnostico'] . "'>" . $row['diagnostico'] . "</option>";
                } ?>
                
            </select>
        </div>
    </div>
</div>
                   
<div class="row">
    <div class="col">
       <hr>
                                        
  <div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>ANTECEDENTES GINECO-OBSTETRÍCOS </center></strong>
  </div>

  <p><label>

    <?php
    include "../../conexionbd.php";

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);

while ($f1 = mysqli_fetch_array($resultado1)) {

    $sexo=$f1['sexo'];
}
        if($sexo=='MUJER'){ ?>
        <div class="row">
                <div class="col-sm">
                    <label for="hc_men">MENARCA:</label><br>
                    <input type="text" name="hc_men" placeholder="Menarca" value=""
                    onkeypress="return SoloNumeros(event);" maxlength="2" class="form-control"><br>
                </div>
                <div class="col-sm">
                    <label for="hc_ritmo">RITMO:</label><br>
                    <input type="text" name="hc_ritmo" placeholder="Ritmo" value=""
                    onkeypress="return SoloNumeros(event);" maxlength="2" class="form-control"><br>
                 </div>
                 <div class="col-sm">
                    <label for="hc_ges">GESTAS:</label><br>
                    <input type="text" name="gestas_cu" placeholder="Gestas" value=""
                    onkeypress="return SoloNumeros(event);" maxlength="2" class="form-control"><br>
                </div>
                <div class="col-sm">
                    <label for="hc_par">PARTOS:</label><br>
                    <input type="text" name="partos_cu" placeholder="Partos" value=""
                    onkeypress="return SoloNumeros(event);" maxlength="2" class="form-control"><br>
                </div>
                <div class="col-sm">
                    <label for="hc_ces">CESÁREAS:</label><br>
                    <input type="text" name="ces_cu" placeholder="Cesareas" value="" 
                    onkeypress="return SoloNumeros(event);" maxlength="2" class="form-control"> <br>
                </div>
                <div class="col-sm">
                    <label for="hc_abo">ABORTOS:</label><br>
                    <input type="text" name="abo_cu" placeholder="Abortos" value=""
                    onkeypress="return SoloNumeros(event);" maxlength="2" class="form-control"><br> 
                </div>
                <div class="col-sm">
                    <label for="hc_abo">FEC. ÚLTIMA REGLA</label><br>
                    <input type="date" name="fecha_fur" value="" class="form-control"><br> 
                </div>
        </div> 

        <?php }else{ ?> 
        <div class="row">
                <div class="col-sm">
                    <label for="hc_desc_hom">DESCRIPCIÓN:</label><br>
                    <textarea name="hc_desc_hom" value="" class="form-control"></textarea><br>
                </div>
        </div>  

        <?php } ?> 
                                    
    </div>
</div>
 <!--                      
 <div class="row">
    div class="col-sm">
     <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>PROCEDIMIENTOS:</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="proc_cu" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" ></textarea>
  </div>
    </div>
</div>
-->
<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>RECETA MÉDICA</center></strong>
  </div>
<p>
    <div class="form-group">
      <label for="exampleFormControlTextarea1"><strong>MEDICAMENTOS:</strong></label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="med_cu" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
    </div>
<div class="thead" style="background-color: #2b2d7f ; color: white; font-size: 20px;">
       <tr><strong><center>TRATAMIENTO Y PLAN </center></strong>
  </div>
<p>
    <div class="form-group">
      <label for="exampleFormControlTextarea1"><strong>ANÁLISIS Y PRONÓSTICOS:</strong></label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="anproc_cu" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
    </div>

 
      <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>TRATAMIENTO Y PLAN:</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="trat_cu" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
  </div>

   <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>OBSERVACIÓNES Y ESTUDIOS:</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="do_cu" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
   </div>
<!--
   <div class="form-group">
    <label for="exampleFormControlTextarea1"><strong>DISCAPACIDADES:</strong></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="dis_cu" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
    </div>
-->
   <div class="form-group">
        <label for="id_cie_10"><strong>DESTINO:</strong></label>
        <input type="text" class="form-control" name="dest_cu">
    </div>

                        

<!-- 
 <div class="row" id="contenido">

<div class="thead" style="background-color: seagreen; color: white; font-size: 20px;">
       <tr><strong><center>DATOS QUIRÚRGICOS</center></strong>
</div>




<div class="col-sm">

  
  <strong><p>TIPO DE INTERVENCIÓN:</p></strong>
     <div class="form-check">
  <input class="form-check-input" type="radio" name="tipo_intervenciony" value="URGENCIA" name="tipocir">
  <label class="form-check-label"  for="URGENCIAS">
    URGENCIA
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio"  name="tipo_intervenciony" value="ELECTIVA" name="tipocir">
  <label class="form-check-label" for="URGENCIAS">
    ELECTIVA
  </label>
</div>
    </div>

  <hr>
   <div class="row">
       <div class="col-sm">
         <label for="exampleFormControlTextarea1"><strong>MATERIALES E INSTRUMENTAL NECESARIO:</strong></label>
       <textarea class="form-control" name="inst_necesarioy" id="exampleFormControlTextarea1"  rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
       </div>
       <div class="col-sm">
         <label for="exampleFormControlTextarea5"><strong>OBSERVACIONES:</strong></label>
       <textarea class="form-control" name="medmat_necesarioy" id="exampleFormControlTextarea5"  rows="3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
       </div>
       <div class="col-sm">
        <div class="form-group">
          <label for="exampleFormControlInput1"><strong>NOMBRE DEL CIRUJANO / JEFE DE SERVICIO:</strong></label>
          <input type="text" class="form-control" name="nom_jefe_servy" id="exampleFormControlInput1"  placeholder="Nombre" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
        </div>
       </div>
     </div>
     

  
 
<div class="form-group">
        <label for="id_cie_10"><strong> DIAGNÓSTICO PREOPERATORIO:</strong></label>
        <input type="text" class="form-control" name="diag_preopy" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>




<hr id="contenido">

<div class="row">

  <div class="col"><strong><center>SANGRE EN</center></strong><hr>
    
  <div class="row">
    <div class="col-sm">
      <label for="exampleFormControlInput1">QUIROFANO:</label>
    <input type="text" class="form-control" name="quirofanoy"  id="exampleFormControlInput1" placeholder="ml." style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    <div class="col-sm">
      <label for="exampleFormControlInput1">RESERVA:</label>
    <input type="text" class="form-control" name="reservay" id="exampleFormControlInput1"  placeholder="ml." style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
  </div>
<hr >
  </div>
  <div class="col"><strong><center>ANESTESIA PROPUESTA</center></strong><hr>
  <div class="row">
    <div class="col-sm-4">
    <label for="exampleFormControlInput1">LOCAL:</label>
    <input type="text" class="form-control" name="localy" id="exampleFormControlInput1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"> 
    </div>
    <div class="col-sm-4">
      <label for="exampleFormControlInput1">REGIONAL:</label>
    <input type="text" class="form-control" name="regionaly" id="exampleFormControlInput1"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"> 
    </div>
    <div class="col-sm-4">
      <label for="exampleFormControlInput1">GENERAL:</label>
    <input type="text" class="form-control" name="generaly" id="exampleFormControlInput1"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
  </div>
  <hr>
  </div>

  </div>
  <div class="col"><hr>

<div class="row">
   
    <?php
$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_GET['id_atencion']) or die($conexion->error);
?>
  <?php
                    while ($f1 = mysqli_fetch_array($resultado1)) {

                        ?>
    <div class="col-sm">
      <label for="exampleFormControlInput1">GRUPO Y FACTOR RH SANGUÍNEO:</label>
<input type="text" class="form-control" name="tipo_sangrey" id="exampleFormControlInput1" value="<?php echo $f1['tip_san']?>"disabled>

    </div>
    <?php
}
?>
  </div>
<hr>
  </div>

</div>

<br>

  

<hr id="contenido">
<strong><center id="contenido">PROGRAMACIÓN EN QUIROFANO</center></strong><br>-->


 <!--TERMINO DE NOTA MEDICA div container-->
    </div>
<hr>
                        <center><div class="form-group col-9">
                            <button type="submit" class="btn btn-primary">FIRMAR Y GUARDAR</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button>
                        </div></center>

                        <br>
                        </form>


                      
                         
  
   

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

<script type="text/javascript">
        function mostrar(value)
        {
            if(value=="QUIROFANO" || value==true)
            {
                // habilitamos
                document.getElementById('contenido').style.display = 'block';
            }else if(value=="HOSPITALIZACION" || value=="EGRESO"  || value==false){
                // deshabilitamos
                document.getElementById('contenido').style.display = 'none';
            }
        }
    </script>
</body>
</html>