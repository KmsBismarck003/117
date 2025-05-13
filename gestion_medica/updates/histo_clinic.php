<?php 
session_start();
include"../header_medico.php";
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!--  Bootstrap  -->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

  <!---
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
-->
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
  <title>EDITAR HISTORIA CLÍNICA</title>
</head>
<div class="container">
<div class="row">
<div class="col">
    <hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 24px;"><strong><center>HISTORIA CLÍNICA  </center> </strong></div>
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



      function calculaedad($fechanacimiento)
{
  list($ano, $mes, $dia) = explode("-", $fechanacimiento);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($ano_diferencia > 0 )
      return ($ano_diferencia . ' AÑOS');
  else if ($mes_diferencia > 0 || $ano_diferencia < 0)
      return ($mes_diferencia . ' MESES');
   else if ($dia_diferencia > 0 || $mes_diferencia < 0 || $ano_diferencia < 0)
      return ($dia_diferencia . ' DÍAS');
}

      $edad = calculaedad($pac_fecnac);

    ?>
 <font size="2">
         
  <div class="row">
    <div class="col-sm-2">
      EXPEDIENTE: <strong><?php echo $id_exp?> </strong>
    </div>
    <div class="col-sm-6">
     PACIENTE: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm-4">
      FECHA DE INGRESO: <strong><?php echo date_format($date, "d-m-Y H:i:s") ?></strong>
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
      FECHA DE  NACIMIENTO: <strong><?php echo date_format($date1, "d-m-Y") ?></strong>
    </div>
    <div class="col-sm-4">
      EDAD: <strong><?php if($anos > "0" ){
   echo $anos." AÑOS";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." MESES";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." DIAS";
}
?></strong>
    </div>
    
   
      <div class="col-sm-2">
      HABITACIÓN: <strong><?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);                                                                                    while ($row_hab = $result_hab->fetch_assoc()) {
  echo $row_hab['num_cama'];
} ?></strong>
    </div>
    
  </div>

</font>
 <font size="2">
  <div class="row">
     <div class="col-sm-8">
      DIAGNÓSTICO MÉDICO: <strong><?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
$result_mot = $conexion->query($sql_mot);                                                                                    while ($row_mot = $result_mot->fetch_assoc()) {
  echo $row_mot['motivo_atn'];
} ?></strong>
    </div>
  </div>

</font>
 <font size="2">
  <div class="row">
    <div class="col-sm-4">
      ALERGIAS: <strong><?php echo $alergias ?></strong>
    </div>
     <div class="col-sm-4">
      ESTADO DE SALUD: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud ASC LIMIT 1";
$result_edo = $conexion->query($sql_edo);while ($row_edo = $result_edo->fetch_assoc()) {
  echo $row_edo['edo_salud'];
} ?></strong>
    </div>
    <div class="col-sm-3">
      TIPO DE SANGRE: <strong><?php echo $pac_tip_sang ?></strong>
    </div>
  </div>
</font>
<?php $sql_edo = "SELECT * from signos_vitales where id_atencion=$id_atencion ORDER by id_sig ASC LIMIT 1";
$result_edo = $conexion->query($sql_edo);
while ($row_edo = $result_edo->fetch_assoc()) {
  $peso=$row_edo['peso'];
  $talla=$row_edo['talla'];
} ?>
 <font size="2">
  <div class="row">
     <div class="col-sm-4">
      PESO: <strong><?php echo $peso ?></strong>
    </div>
    <div class="col-sm-3">
      TALLA: <strong><?php echo $talla ?></strong>
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
</div>
</div>
<?php 
$id_hc=$_GET['id_hc'];
$hclinica="SELECT * FROM dat_hclinica WHERE id_hc=$id_hc";
$result=$conexion->query($hclinica);
while ($row=$result->fetch_assoc()) {
     $id_usua=$row['id_usua'];
 ?>
<body>
<form action="" method="POST" enctype="multipart"> 
<div class="container">
<div class="container">
 <div class="row">
 	<div class="form-group"><br>
        <label for="tip_hc">TIPO DE INTERROGATORIO</label>
        <select class="form-control" id="tip_hc" name="tip_hc">
            <option value="<?php echo $row['tip_hc'] ?>"><?php echo $row['tip_hc'] ?></option>
            <option value="DIRECTO">DIRECTO</option>
            <option value="INDIRECTO">INDIRECTO</option>
        </select>
    </div>
 </div>
</div>
 <div class="container">

<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;"><strong><center>ANTECEDENTES HEREDO FAMILIARES</center></strong></div>
                    <p>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="hc_abu">ABUELOS</label>
                                    <select class="form-control" id="hc_abu" name="hc_abu">
                                        <option value="<?php echo $row['hc_abu'] ?>"><?php echo $row['hc_abu'] ?></option>
                                        <option value="DIABETES TIPO 2">DIABETES TIPO 2</option>
                                        <option value="HIPERTENSIÓN ARTERIAL">HIPERTENSIÓN ARTERIAL</option>
                                        <option value="ONCOLOGICOS (CANCER CEREBRAL)">CÁNCER CEREBRAL</option>
                                        <option value="CANCER PULMONAR">CÁNCER PULMONAR</option>
                                        <option value="CANCER ESTOMACAL">CÁNCER ESTOMACAL</option>
                                        <option value="CANCER DE HIGADO">CÁNCER DE HIGADO</option>
                                        <option value="CANCER DE COLON">CÁNCER DE COLON</option>
                                        <option value="CANCER CERVICOUTERINO">CÁNCER CERVICOUTERINO</option>
                                        <option value="CANCER (OTROS)">CÁNCER (OTROS)</option>
                                        <option value="FÍSICOS">FÍSICOS</option>
                                        <option value="NINGUNA">NINGUNA</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">OTROS</label>
                                    <textarea name="hc_her_o" class="form-control" rows="5"><?php echo $row['hc_her_o'] ?></textarea>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="hc_pad">PADRES</label>
                                    <select class="form-control" id="hc_pad" name="hc_pad">
                                        <option value="<?php echo $row['hc_pad'] ?>"><?php echo $row['hc_pad'] ?></option>
                                        <option value="DIABETES TIPO 2">DIABETES TIPO 2</option>
                                        <option value="HIPERTENSIÓN ARTERIAL">HIPERTENSIÓN ARTERIAL</option>
                    <option value="ONCOLOGICOS (CANCER CEREBRAL)">CÁNCER CEREBRAL</option>
                    <option value="CANCER PULMONAR">CÁNCER PULMONAR</option>
                    <option value="CANCER ESTOMACAL">CÁNCER ESTOMACAL</option>
                    <option value="CANCER DE HIGADO">CÁNCER DE HIGADO</option>
                    <option value="CANCER DE COLON">CÁNCER DE COLON</option>
                    <option value="CANCER CERVICOUTERINO">CÁNCER CERVICOUTERINO</option>
                    <option value="CANCER (OTROS)">CÁNCER (OTROS)</option>
                                        <option value="FÍSICOS">FÍSICOS</option>
                                        <option value="NINGUNA">NINGUNA</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="hc_her">HERMANOS</label>
                                    <select class="form-control" id="hc_her" name="hc_her">
                                        <option value="<?php echo $row['hc_her'] ?>"><?php echo $row['hc_her'] ?></option>
                                        <option value="DIABETES TIPO 2">DIABETES TIPO 2</option>
                                        <option value="HIPERTENSIÓN ARTERIAL">HIPERTENSIÓN ARTERIAL</option>
                                    <option value="ONCOLOGICOS (CANCER CEREBRAL)">CÁNCER CEREBRAL</option>
                    <option value="CANCER PULMONAR">CÁNCER PULMONAR</option>
                    <option value="CANCER ESTOMACAL">CÁNCER ESTOMACAL</option>
                    <option value="CANCER DE HIGADO">CÁNCER DE HIGADO</option>
                    <option value="CANCER DE COLON">CÁNCER DE COLON</option>
                    <option value="CANCER CERVICOUTERINO">CÁNCER CERVICOUTERINO</option>
                    <option value="CANCER (OTROS)">CÁNCER (OTROS)</option>
                                        <option value="FÍSICOS">FÍSICOS</option>
                                        <option value="NINGUNA">NINGUNA</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;"><strong><center>ANTECEDENTES PERSONALES NO PATOÓLOGICOS</center></strong></div>
                        <p>
                        <div class="row">
                            <div class="col">
                              <div class="form-group">
                                    <label for="hc_ali">ALIMENTACIÓN EN CANTIDAD Y CÁLIDAD</label>
                                    <select class="form-control" id="hc_ali" name="hc_ali">
                                        <option value="<?php echo $row['hc_ali'] ?>"><?php echo $row['hc_ali'] ?></option>
                                        <option value="BUENA">BUENA</option>
                                        <option value="REGULAR">REGULAR</option>
                                        <option value="MALA">MALA</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="hc_zoo">ZOONOSIS</label>
                                    <select class="form-control" id="hc_zoo" name="hc_zoo">
                                        <option value="<?php echo $row['hc_zoo'] ?>"><?php echo $row['hc_zoo'] ?></option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="hc_act">ACTIVIDAD FÍSICA</label>
                                    <select class="form-control" id="hc_act" name="hc_act">
                                        <option value="<?php echo $row['hc_act'] ?>"><?php echo $row['hc_act'] ?></option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="hc_zoo_cual">CUALES</label>
                                    <textarea name="hc_zoo_cual" class="form-control" rows="5"><?php echo $row['hc_zoo_cual'] ?></textarea>
                                </div>
                                <div class="form-group"><br><br><br><br>
                                    <label for="hc_otro">OTROS</label>
                                    <textarea name="hc_otro" class="form-control" rows="5"><?php echo $row['hc_otro']?></textarea>
                                </div>
                            </div>
                        </div>
                        
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;"><strong><center>ANTECEDENTES PERSONALES PATOLÓGICOS</center></strong></div>
                        <p>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="hc_ale">ALÉRGICOS</label>
                                    <input type="text" name="hc_ale" class="form-control" value="<?php echo $row['hc_ale'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="hc_tra">TRANSFUSIONALES</label>
                                    <select class="form-control" id="hc_tra" name="hc_tra" required>
                                        <option value="<?php echo $row['hc_tra'] ?>"><?php echo $row['hc_tra'] ?></option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                                <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">OTRAS ENFERMEDADES</label>
  <input type="text" name="hc_enf" class="form-control" value="<?php echo $row['hc_enf'] ?>">
</div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hc_adic">ADICCIONES</label>
                                    <select class="form-control" id="hc_adic" name="hc_adic">
                                        <option value="<?php echo $row['hc_adic'] ?>"><?php echo $row['hc_adic'] ?></option>
                                        <option value="NINGUNA">NINGUNA</option>
                                        <option value="ALCOHOL">ALCOHOL</option>
                                        <option value="DROGAS">DROGAS</option>
                                        <option value="TABACO">TABACO</option>
                                        <option value="OTRAS">OTRAS</option>
                                    </select>
                                </div>
                                <br>
                                <!--<div class="form-group">
                                    <label for="hc_tra_fecha">FECHA DE ÚLTIMA TRANFUSIÓN</label>
                                    <input type="date" class="form-control" name="hc_tra_fecha"
                                           aria-describedby="emailHelp">
                                </div>-->
                               
                                <br><br>
                                <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">HOSPITALIZACIONES/CIRUGÍAS/TRAUMATISMOS</label>
  <input type="text" name="hc_pato" class="form-control" value="<?php echo $row['hc_pato'] ?>">
</div>
                            </div>
                        
 <?php
  include "../../conexionbd.php";

$resultado1 = $conexion->query("select paciente.*, dat_ingreso.especialidad, dat_ingreso.area, dat_ingreso.motivo_atn, dat_ingreso.fecha, dat_ingreso.id_atencion
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp WHERE id_atencion=" . $_SESSION['hospital']) or die($conexion->error);

                    while ($f1 = mysqli_fetch_array($resultado1)) {
                    $sexo=$f1['sexo'];
                    }
                           if($sexo=='MUJER'){
                        ?>
<div class="container">
    <div class="row">
        <div class="col">                              
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;"><strong><center>ANTECEDENTES GINECO / OBSTÉTRICOS</center></strong></div>
   <p>
   <label>
            <div class="container">
                  <div class="row">
                        <div class="col-sm">
                             <label for="hc_ges">GESTAS</label><br>
                                <input type="text" name="hc_ges" placeholder="Gestas" value="<?php ECHO $row['hc_ges'] ?>"style="text-transform:uppercase;" onkeypress="return SoloNumeros(event);" maxlength="2"   class="form-control"><br>
                        </div>
                      <div class="col-sm">
                              <label for="hc_par">PARTOS</label><br>
                              <input type="text" name="hc_par" placeholder="Partos" value="<?php echo $row['hc_par'] ?>" style="text-transform:uppercase;" onkeypress="return SoloNumeros(event);" maxlength="2" class="form-control"><br>
                         </div>
                         <div class="col-sm">
                               <label for="hc_ces">CESÁREAS</label><br>
                               <input type="text" name="hc_ces" placeholder="Cesareas" value="<?php echo $row['hc_ces'] ?>" style="text-transform:uppercase;" onkeypress="return SoloNumeros(event);" maxlength="2" class="form-control"> <br>
                                                  </div>
                      <div class="col-sm">
                               <label for="hc_abo">ABORTOS</label><br>
                               <input type="text" name="hc_abo" placeholder="Abortos" value="<?php echo $row['hc_abo'] ?>" style="text-transform:uppercase;" onkeypress="return SoloNumeros(event);"  maxlength="2" class="form-control"><br> 
                         </div>
                         <div class="col-sm">
                          <label for="hc_fechafur">FECHA FUR</label><br>
                          <input type="date" name="hc_fechafur" value="<?php echo $row['hc_fechafur'] ?>"class="form-control"><br> 
                         </div>
                    </div>    
            </div>
        </div>
    </div>
</div>
    <?php } ?>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                                    <hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
<strong><center>PADECIMIENTO ACTUAL</center></strong>
</div>
        <br>
        <label for="hc_pade">DESCRIPCIÓN</label>
        <textarea name="hc_pade" class="form-control" rows="5"><?php echo $row['hc_pade'] ?></textarea>
    </div>
</div>

                            <div class="col-12">
                                <div class="form-group">
                                    <hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
<strong><center>INTERROGATORIO POR APARATOS Y SISTEMAS</center></strong>
</div>
                                    <br>
                                 <label for="hc_apa">DESCRIPCIÓN</label>
                                 <textarea name="hc_apa" class="form-control" rows="5"><?php echo $row['hc_apa'] ?></textarea>
                                </div>
                            </div>
                          
                            <div class="col-12">
                                <div class="form-group">
                                    <hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
<strong><center>EXPLORACIÓN FÍSICA</center></strong>
</div>
                                    <br>

                                    <label for="hc_explora">DESCRIPCIÓN</label>
                                    <textarea name="hc_explora" class="form-control" rows="5"><?php echo $row['hc_explora'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
<strong><center>RESULTADOS PREVIOS Y ACTUALES</center></strong>
</div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="hc_lab">LABORATORIO</label>
                                    <textarea name="hc_lab" class="form-control" rows="5"><?php echo $row['hc_lab'] ?></textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hc_gabi">GABINETE</label>
                                    <textarea name="hc_gabi" class="form-control" rows="5"><?php echo $row['hc_gabi'] ?></textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hc_res_o">OTROS RESULTADOS</label>
                                    <textarea name="hc_res_o" class="form-control" rows="5"><?php echo $row['hc_res_o'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
<strong><center>DIAGNÓSTICOS</center></strong>
</div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="id_cie_10">IMPRESIÓN DIAGNÓSTICA</label>
                                    <textarea name="id_cie_10" class="form-control" rows="5"><?php echo $row['id_cie_10'] ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
<strong><center>PRONÓSTICOS</center></strong>
</div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="hc_vid">PRONÓSTICO PARA LA VIDA</label>
                                    <select name="hc_vid" class="form-control" id="mibuscador" style="width : 100%; heigth : 100%">
                                       
                        <option value="<?php echo $row['hc_vid'] ?>"><?php echo $row['hc_vid'] ?></option>
                        <option value="BUENO">BUENO</option>
                        <option value="MALO">MALO</option>
                        <option value="RESERVADO">RESERVADO</option>
                    
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hc_def">PRONÓSTICO PARA LA FUNCIÓN</label>
                                    <select name="hc_def" class="form-control" id="mibuscador" style="width : 100%; heigth : 100%">
                        <optionvalue="<?php echo $row['hc_def'] ?>"><?php echo $row['hc_def'] ?></option>
                        <option value="BUENO">BUENO</option>
                        <option value="MALO">MALO</option>
                        <option value="RESERVADO">RESERVADO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hc_dis">DISCAPACIDAD</label>
                                    <textarea name="hc_dis" class="form-control" rows="5"><?php echo $row['hc_dis'] ?></textarea>
                                </div>
                                <br><br>
                            </div>
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
<div class="thead" style="background-color: #0c675e; color: white; font-size: 19px;">
  <center><strong>SIGNOS VITALES</strong></center><p>
</div>
                <div class="container"> 
  <div class="row">
    
      
    
    <div class="col-sm-2"><br><center>PRESIÓN ARTERIAL:</center>
     <div class="row">
  <div class="col"><input type="text" class="form-control" value="<?php echo $f5['p_sistol'];?>" disabled></div> /
  <div class="col"><input type="text" class="form-control" value="<?php echo $f5['p_diastol'];?>" disabled></div>
 
</div>
    </div>
    <div class="col-sm-2">
      FRECUENCIA CARDIACA:<input type="text" class="form-control" value="<?php echo $f5['fcard'];?>" disabled>
    </div>
    <div class="col-sm-2">
      FRECUENCIA RESPIRATORIA:<input type="text" class="form-control" value="<?php echo $f5['fresp'];?>" disabled>
    </div>
    <div class="col-sm-2">
     <br>TEMPERATURA:<input type="text" class="form-control" value="<?php echo $f5['temper'];?>" disabled>
    </div>
    <div class="col-sm-2">
     SATURACIÓN OXÍGENO:<input type="text"  class="form-control" value="<?php echo $f5['satoxi'];?>" disabled>
    </div>
    <?php 
} }                     
  ?>
    <div class="col-sm-1"> 
     <br>PESO:<input type="text" class="form-control" name="peso" value="<?php echo $row['peso'] ?>">
    </div>
    <div class="col-sm-1">
     <br>TALLA:<input type="cm-number" class="form-control" name="talla" value="<?php echo $row['talla'] ?>">
    </div>
  </div>
</div>

    <hr>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="hc_te">TERAPEÚTICA EMPLEADA Y RESULTADOS PREVIOS</label>
                <textarea name="hc_te" class="form-control" rows="5"><?php echo $row['hc_te'] ?></textarea>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="hc_ta">TERAPEÚTICA ACTUAL</label>
                <textarea name="hc_ta" class="form-control" rows="5"><?php echo $row['hc_ta'] ?></textarea>
            </div>
                            
        </div>

    </div>

       <?php 
       $date=date_create($row['fec_hc']);
        ?>
      <div class="row">
          <div class="col-sm-4">
              <div class="form-group">
                 <strong> <label>FECHA REGISTRO : </label></strong><br>
                 <input type="date" name="fecha" value="<?php echo date_format($date,"Y-m-d") ?>" class="form-control">
             </div>
           </div>
           <div class="col-sm-4">
              <div class="form-group">
                 <strong> <label>HORA REGISTRO :</label></strong><br>
                 <input type="time" name="hora" value="<?php echo date_format($date,"H:i:s") ?>" class="form-control">
             </div>
           </div>
       <?php 
   }
$select="SELECT * FROM reg_usuarios where id_usua=$id_usua";
$resultado=$conexion->query($select);
while ($row_doc=$resultado->fetch_assoc()) {
    $doctor=$row_doc['nombre'].' '.$row_doc['papell'].' '.$row_doc['sapell'];
    $id_doc=$row_doc['id_usua'];
}

        ?>
          <div class="col-sm-4">
              <div class="form-group">
                 <strong> <label>MÉDICO QUE REGISTRÓ: </label></strong><br>
                 <select name="medico" class="form-control" >
                     <option value="<?php echo $id_doc ?>"><?php echo $doctor ?></option>
                     <option></option>
                     <option value=" ">SELECCIONAR MEDICO :</option>
                     <?php 
                      $select="SELECT * FROM reg_usuarios where id_rol=2 || id_rol=12";
                      $resultado=$conexion->query($select);
                      foreach ($resultado as $row ) {
                      ?>
                      <option value="<?php echo $row['id_usua'] ?>"><?php echo $row['nombre'].' '.$row['papell'].' '.$row['sapell']; ?></option>
                  <?php } ?>
                 </select>
             </div>
           </div>
       </div> 
    <center>
        <hr>
     <button type="submit" name="guardar" class="btn btn-success">GUARDAR</button>
            <button type="button" class="btn btn-danger" onclick="history.back()">CANCELAR</button>
        </center>
        <br>
</div>
</div>
</form>


 <?php 
  if (isset($_POST['guardar'])) {

        $tip_hc    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tip_hc"], ENT_QUOTES))); //Escanpando caracteres
        $hc_abu    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_abu"], ENT_QUOTES))); //Escanpando caracteres
        $hc_her_o   = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_her_o"], ENT_QUOTES)));
        $hc_pad    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_pad"], ENT_QUOTES))); //Escanpando caracteres
        $hc_her    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_her"], ENT_QUOTES)));
        $hc_ali    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_ali"], ENT_QUOTES)));
	    $hc_zoo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_zoo"], ENT_QUOTES)));
	    $hc_act    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_act"], ENT_QUOTES)));
        $hc_zoo_cual    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_zoo_cual"], ENT_QUOTES)));
        $hc_otro    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_otro"], ENT_QUOTES)));
        $hc_ale    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_ale"], ENT_QUOTES)));
        $hc_tra    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_tra"], ENT_QUOTES)));
        $hc_enf   = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_enf"], ENT_QUOTES)));
        $hc_adic    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_adic"], ENT_QUOTES)));
        $hc_pato    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_pato"], ENT_QUOTES)));
        $hc_ges    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_ges"], ENT_QUOTES)));
        $hc_par    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_par"], ENT_QUOTES)));
        $hc_ces    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_ces"], ENT_QUOTES)));
        $hc_abo    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_abo"], ENT_QUOTES)));
        $hc_fechafur    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_fechafur"], ENT_QUOTES)));
        $hc_pade    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_pade"], ENT_QUOTES)));
        $hc_apa    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_apa"], ENT_QUOTES)));
        $hc_explora    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_explora"], ENT_QUOTES)));
        $hc_lab    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_lab"], ENT_QUOTES)));
        $hc_gabi    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_gabi"], ENT_QUOTES)));
        $hc_res_o    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_res_o"], ENT_QUOTES)));
        $id_cie_10    = mysqli_real_escape_string($conexion, (strip_tags($_POST["id_cie_10"], ENT_QUOTES)));
        $hc_vid    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_vid"], ENT_QUOTES)));
        $hc_def    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_def"], ENT_QUOTES)));
        $hc_dis    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_dis"], ENT_QUOTES)));
        $hc_te    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_te"], ENT_QUOTES)));
        $hc_ta    = mysqli_real_escape_string($conexion, (strip_tags($_POST["hc_ta"], ENT_QUOTES)));

        $fecha= mysqli_real_escape_string($conexion,(strip_tags($_POST["fecha"], ENT_QUOTES)));
        $hora= mysqli_real_escape_string($conexion,(strip_tags($_POST["hora"], ENT_QUOTES)));
        $medico= mysqli_real_escape_string($conexion,(strip_tags($_POST["medico"], ENT_QUOTES)));

        $peso= mysqli_real_escape_string($conexion,(strip_tags($_POST["peso"], ENT_QUOTES)));
        $talla= mysqli_real_escape_string($conexion,(strip_tags($_POST["talla"], ENT_QUOTES)));
       
       $merge = $fecha.' '.$hora;


$fecha_actual = date("Y-m-d H:i:s");

        $sql2 = "UPDATE dat_hclinica SET id_usua='$medico',fec_hc='$merge',tip_hc='$tip_hc', hc_abu='$hc_abu', hc_her_o='$hc_her_o', hc_pad='$hc_pad', hc_her='$hc_her', hc_ali='$hc_ali' , hc_zoo='$hc_zoo', hc_act='$hc_act', hc_zoo_cual='$hc_zoo_cual', hc_otro='$hc_otro', hc_ale='$hc_ale', hc_tra='$hc_tra', hc_enf='$hc_enf', hc_adic='$hc_adic', hc_pato='$hc_pato', hc_ges='$hc_ges', hc_par='$hc_par', hc_ces='$hc_ces', hc_abo='$hc_abo', hc_fechafur='$hc_fechafur', hc_pade='$hc_pade', hc_apa='$hc_apa', hc_explora='$hc_explora', hc_lab='$hc_lab', hc_gabi='$hc_gabi', hc_res_o='$hc_res_o', id_cie_10='$id_cie_10', hc_vid='$hc_vid', hc_def='$hc_def', hc_dis='$hc_dis', hc_te='$hc_te', hc_ta='$hc_ta',peso='$peso', talla='$talla' WHERE id_hc= $id_hc";
        $result = $conexion->query($sql2);
        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> DATO EDITADO CORRECTAMENTE...</p>";
        echo '<script type="text/javascript">window.location ="../cartas_consentimientos/consent_medico.php"</script>';
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