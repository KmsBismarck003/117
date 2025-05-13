<?php
session_start();
//include "../../conexionbd.php";
include "../header_medico.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);

?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">



    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
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
  <script>
    // Write on keyup event of keyword input element
    $(document).ready(function() {
      $("#search_dep").keyup(function() {
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
  <title>SIGNOS VITALES</title>
  <style type="text/css">
    #contenido{
        display: none;
    }
     #contenido3{
        display: none;
    }
     #contenido4{
        display: none;
    }
</style>
  
</head>

<body> 
 <font size="2">
  <div class="container">
  <div class="row">
    <div class="col-12">
                
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
<strong><center>REGISTRO GRÁFICO TRANS-ANESTÉSICO</center></strong>
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
      Fecha de  nacimiento: <strong><?php echo date_format($date1, "d-m-Y") ?></strong>
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
    
<body>
  <div class="container">  <!--INICIO DE CONSULTA DE URGENCIAS-->

<form action="insertar_trans_grafico.php" method="POST">
 <div class="row">
    <div class="col-sm-3">
<?php 
$id_trans_graf=0;
$resultado3 = $conexion->query("SELECT * from dat_trans_grafico WHERE id_atencion=$id_atencion ORDER BY id_trans_graf Desc") or die($conexion->error);

                while($f3 = mysqli_fetch_array($resultado3)){
$id_trans_graf=$f3['id_trans_graf'];
                }
                   
if($id_trans_graf==null){
    
    ?>
    <br><br>
<strong> Registro Inicial:</strong> <?php echo 1; ?>
<?php }

else if($id_trans_graf>0){
$resultado3 = $conexion->query("SELECT * from dat_trans_grafico WHERE id_atencion=$id_atencion ORDER BY cuenta Desc limit 1") or die($conexion->error);

                while($f3 = mysqli_fetch_array($resultado3)){
$cuenta=$f3['cuenta'];
                }
                ?>
<br><br>
          <strong> Siguiente registro:</strong> <?php echo $cuenta+1; ?>

          <?php } ?>

      <!--<strong><br>Hora:</strong>
      <select class="form-control" name="hora" required>
  <option value=""><strong>Seleccionar una hora</strong></option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
  <option value="32">32</option>
  <option value="33">33</option>
  <option value="34">34</option>
  <option value="35">35</option>
  <option value="36">36</option>
  <option value="37">37</option>
  <option value="38">38</option>
  <option value="39">39</option>
  <option value="40">40</option>
  <option value="41">41</option>
  <option value="42">42</option>
  <option value="43">43</option>
  <option value="44">44</option>
  <option value="45">45</option>
  <option value="46">46</option>
  <option value="47">47</option>
  <option value="48">48</option>
</select>-->
    </div>
  <div class="col-sm-2"><br>
      <strong>Inicio anestesia:</strong>
    <input type="time" name="ina" class="form-control">
  </div>
   <div class="col-sm-2"><br>
      <strong>Inicio operación:</strong>
    <input type="time" name="ino" class="form-control">
  </div>
   <div class="col-sm-2">
      <strong>Término operación:</strong>
    <input type="time" name="top" class="form-control">
  </div>
   <div class="col-sm-2"><br>
      <strong>Término anestesia:</strong>
    <input type="time" name="ta" class="form-control">
  </div>
  </div>
  <hr>

<div class="row">

    <div class="col"><strong><center>Técnica anestesica</center></strong><p>
  <div class="row">
     <div class="col-sm">
      <label for="s">Sedación / tiva</label>
    <input type="checkbox" name="tiva" value="SI" id="s" >
    </div>
    <div class="col-sm">
    <label for="l">Local</label>
    <input type="checkbox"  name="tanest" value="SI" id="l"> 
    </div>
    <div class="col-sm">
      <label for="r">Regional</label>
    <input type="checkbox" name="regional" value="SI" id="r"> 
    </div>
    <div class="col-sm">
      <label for="g">General</label>
    <input type="checkbox" name="general" value="SI" id="g" >
    </div>
  </div>
  <hr>
  </div>
  <!--<div class="col">
    <strong>DIAGNÓSTICO POST-OPERATORIO</strong> <input type="text" name="diagposto" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>
  <div class="col">
    <strong>OPERACIÓN REALIZADA</strong> <input type="text" name="opreal" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
  </div>-->
</div>
<p>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>SIGNOS VITALES</center></strong>
</div><p>
<div class="container"> 
  <div class="row">
    <div class="col-sm-2"><br><center><strong>Presión arterial:</strong></center>
     <div class="row">
  <div class="col losInputTAM"><input type="text" class="form-control" id="sist" name="sistg" required="" placeholder="SISTOLICA"></div> /
  <div class="col losInputTAM"><input type="text" class="form-control" id="diast" name="diastg" required="" placeholder="DIASTOLICA"></div>
 
</div>
    </div>
    <div class="col-sm-2">
      <strong>Frecuencia cardiaca</strong>:<input type="text" class="form-control" name="fcardg" required="" placeholder="PULSO">
    </div>
   <div class="col-sm-3"><br>
      <strong>Frecuencia respiratoria</strong>:<input type="text" class="form-control" name="frespg" required="" placeholder="FRECUENCIA RESPIRATORIA">
    </div>
     <div class="col-sm-3"><br>
      <strong>Saturación oxigeno</strong>:<input type="text" class="form-control" name="satg" required="" placeholder="SATURACIÓN OXIGENO">
    </div>
    <div class="col-sm-2"><br>
      <strong>Temperatura</strong>:<input type="text" class="form-control" name="tempg" required="" placeholder="TEMPERATURA">
    </div>
   
   
  </div>
</div>
<hr>
 
<center>
                       <div class="form-group col-6">
                            <button type="submit" class="btn btn-success">Agregar</button>
                             <a href="../nota_anestesica/ver_grafica.php" role="button" class="btn btn-warning">Ver gráfica</a>
                           <!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
  Término de cirugia
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Término de cirugia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       ¿Estas seguro que quieres salir? ¿ha términado la cirugia?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">No, Regresar!</button>
        <a href="../hospitalizacion/vista_pac_hosp.php"><button type="button" class="btn btn-danger">Si, quiero salir!</button></a>
      </div>
    </div>
  </div>
</div>
                     
                        </div>
</center>
                        <hr>
                        </form>
</div> <!--TERMINO DE NOTA MEDICA div container-->
<div class="container">
    <div class="row">
        
            
            
         

            <!--<div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar...">
            </div>-->
            <!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="container" >
  <div class="row">
  
 <div class="col-sm-12">
     <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
         <tr><strong><center>GRÁFICO / SIGNOS VITALES</center></strong>
</div>
      <p>
    
    <canvas id="grafica"></canvas>
    <script src="script.js"></script>
    </div>
    
   
  
  </div>
</div>-->
    <?php

include "../../conexionbd.php";
$id_atencion=$_SESSION['hospital'];
$resultado = $conexion->query("SELECT * from dat_trans_grafico WHERE id_atencion=$id_atencion ORDER BY id_trans_graf ASC") or die($conexion->error);
$usuario = $_SESSION['login'];
?>
            <div class="table-responsive">
<br>
            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
                <tr>
                  <th scope="col">No.</th>
                    <th scope="col">Fecha de nota</th>
                     <th scope="col">Hora</th>
                    <th scope="col">Presión arterial</th>
                    <th scope="col">Frecuencia cardiaca</th>
                    <th scope="col">Frecuencia respiratoria</th>
                    <th scope="col">Temperatura</th>
                    <th scope="col">Sat. Oxígeno</th>
                    <th scope="col">Técnica anestésica / local</th>
                    <th scope="col">Técnica anestésica / regional</th>
                    <th scope="col">Técnica anestésica / general</th>
                    <th scope="col">Inicio anestesia</th>
                    <th scope="col">Inicio operación</th>
                    <th scope="col">Término operación</th>
                    <th scope="col">Término anestesia</th>
                  
                </tr>
                </thead>
                <tbody>

                <?php
                $no=1;
                while($f = mysqli_fetch_array($resultado)){
                   
                    ?>

                    <tr>
                      <td><strong><?php  echo $no?></strong></td>
                        <td><strong><?php $date=date_create($f['fecha_g']); echo date_format($date,"d/m/Y H:i:s");?></strong></td>
                        <td><strong><?php echo $f['cuenta'];?></strong></td>
                        <td><strong><?php echo $f['sistg'];?>/<?php echo $f['diastg'];?></strong></td>
                        <td><strong><?php echo $f['fcardg'];?></strong></td>
                        <td><strong><?php echo $f['frespg'];?></strong></td>
                        <td><strong><?php echo $f['tempg'];?> °C</strong></td>
                        <td><strong><?php echo $f['satg'];?> %</strong></td>
                        <td><strong><?php echo $f['tanest'];?></strong></td>
                        <td><strong><?php echo $f['regional'];?></strong></td>
                        <td><strong><?php echo $f['general'];?></strong></td>
                        <td><strong><?php echo $f['ina'];?></strong></td>
                        <td><strong><?php echo $f['ino'];?></strong></td>
                        <td><strong><?php echo $f['top'];?></strong></td>
                        <td><strong><?php echo $f['ta'];?></strong></td>
                    
                       <?php $no++; ?>
                    </tr>
                    <?php
                }

                ?>
                </tbody>
              
            </table>
            </div>

        </div>
    </div>
    
</div>

<div class="container">
  <form action="" method="POST" id="medicamentos">
      <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-primary">
            <th colspan="7"><center><h5><strong>REGISTRAR MEDICAMENTOS ADMINISTRADOS AL PACIENTE</strong></h5></center></th>
         </tr>
    <tr class="table-active">
      <!--<th scope="col-4"><center>Tipo</center></th>-->
      <th scope="col-4"><center>Hora</center></th>
      <th scope="col-1"><center>Medicamento</center></th>
      <th scope="col"><center>Dósis</center></th>
      <th scope="col"><center>Unidad de medida</center></th>
      <th scope="col"><center>Vía</center></th>
      <th scope="col"><center>Otros</center></th>
    
      <th scope="col"><center></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <input type="time" class="form-control" name="hora_med" required>
      
      </td>
      <td><select data-live-search="true" class="selectpicker form-control" name="med" id="mibuscador" style="width : 100%; heigth : 100%" required="">
         <?php
         $sql = "SELECT * FROM item, stock where item.controlado = 'NO' AND item.item_id = stock.item_id and stock.stock_qty != 0 ORDER BY item.item_name ASC";
              $result = $conexion->query($sql);
                echo"<option value=''>Seleccionar medicamento</option>";
               while ($row_datos = $result->fetch_assoc()) {
              
                 echo "<option value='" . $row_datos['item_name'] . "'>" . $row_datos['item_name'] . "</option>";
                }
          ?></select></td>
      <td><input type="text" name="dosis" class="form-control"></td>

 <td>

<select name="unimed" class="form-control">
  <option value="">Seleccionar unidad de medida</option>
  <option value="Gota">Gota</option>
  <option value="Microgota">Microgota</option>
  <option value="Litro">Litro</option>
  <option value="Mililitro">Mililitro</option>
 <option value="Microlitro">Microlitro</option>
  <option value="Centimetro cubico">Centímetro cúbico</option>
   <option value="Dracma liquida">Dracma líquida</option>
    <option value="Onza liquida">Onza líquida</option>
     <option value="Kilogramo">Kilogramo</option>
      <option value="Gramo">Gramo</option>
       <option value="Miligramo">Miligramo</option>
        <option value="Microgramo">Microgramo</option>
<option value="Microgramo de HA">Microgramo de HA</option>
<option value="Nanogramo">Nanogramo</option>
<option value="Libra">Libra</option>
<option value="Onza">Onza</option>
<option value="Masa molar">Masa molar</option>
<option value="Milimol">Milimol</option>
<option value="Miliequivalente">Miliequivalente</option>
<option value="Unidad">Unidad</option>
<option value="Miliunidad">Miliunidad</option>
<option value="Unidad internacional">Unidad internacional</option>
<option value="Unidad">Unidad</option>

</select>

</td>

      <td>
<select name="via" class="form-control">
  <option value="">Seleccionar vía</option>
  <option value="INTRAVENOSA">INTRAVENOSA</option>
  <option value="INTRAMUSCULAR">INTRAMUSCULAR</option>
  <option value="INTRAOSEA">INTRAOSEA</option>
  <option value="INTRADERMICA">INTRADÉRMICA</option>
  <option value="NASAL">NASAL</option>
  <option value="OTICA">ÓTICA</option>
  <option value="ORAL">ORAL</option>
  <option value="SUBLINGUAL">SUBLINGUAL</option>
  <option value="SUBTERMICA">SUBDÉRMICA</option>
  <option value="SUBCUTANEA">SUBCUTANEA</option>
  <option value="SONDA">SONDA</option>
  <option value="NEBULIZACION">NEBULIZACIÓN</option>
  <option value="RECTAL">RECTAL</option>
  <option value="TOPICO">TÓPICO</option>
</select>
      </td>
      <td>
<textarea name="otro" class="form-control" rows="1">
</textarea> </td>
      
      <td><input type="submit" name="btnagregar" class="btn btn-block btn-success" value="Agregar"></td>
    </tr>
  </tbody>
</table>
<?php $fecha_actual = date("Y-m-d"); ?>
<div class="container">
  <div class="row">
    <div class="col-sm-2">
      <strong>Fecha de reporte:</strong>
    </div>
    <div class="col-sm-3">
      <input type="date" name="fecha_mat" value="<?php echo $fecha_actual ?>" class="form-control">
    </div>
    
  </div>
</div>
     </div>
     
    </form>
</div>
<?php

          if (isset($_POST['btnagregar'])) {
            include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['hospital'];

           $fecha_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_mat"], ENT_QUOTES)));
            $hora_med =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_med"], ENT_QUOTES)));
            $med =  mysqli_real_escape_string($conexion, (strip_tags($_POST["med"], ENT_QUOTES)));
            $dosis =  mysqli_real_escape_string($conexion, (strip_tags($_POST["dosis"], ENT_QUOTES)));
            $via =  mysqli_real_escape_string($conexion, (strip_tags($_POST["via"], ENT_QUOTES)));
            $otro =  mysqli_real_escape_string($conexion, (strip_tags($_POST["otro"], ENT_QUOTES)));
           $unimed =  mysqli_real_escape_string($conexion, (strip_tags($_POST["unimed"], ENT_QUOTES)));

if( ($hora_med>='08:00'and $hora_med<='08:59') || 
        ($hora_med>='09:00'and $hora_med<='09:59') || 
        ($hora_med>='10:00'and $hora_med<='10:59') || 
        ($hora_med>='11:00'and $hora_med<='11:59') || 
        ($hora_med>='12:00'and $hora_med<='12:59') || 
        ($hora_med>='13:00'and $hora_med<='13:59')){
        $turno="MATUTINO";
    } else if ( ($hora_med>='14:00'and $hora_med<='14:59') || 
        ($hora_med>='15:00'and $hora_med<='15:59') || 
        ($hora_med>='16:00'and $hora_med<='16:59') || 
        ($hora_med>='17:00'and $hora_med<='17:59') || 
        ($hora_med>='18:00'and $hora_med<='18:59') || 
        ($hora_med>='19:00'and $hora_med<='19:59') ||
        ($hora_med>='20:00'and $hora_med<='20:59') ){
        $turno="VESPERTINO";
    }else if ( ($hora_med>='21:00'and $hora_med<='21:59') || 
        ($hora_med>='22:00'and $hora_med<='22:59') || 
        ($hora_med>='23:00'and $hora_med<='23:59') || 
        ($hora_med>='24:00'and $hora_med<='24:59') || 
        ($hora_med>='01:00'and $hora_med<='01:59') || 
        ($hora_med>='02:00'and $hora_med<='02:59') ||
        ($hora_med>='03:00'and $hora_med<='03:59') ||
        ($hora_med>='04:00'and $hora_med<='04:59') ||
        ($hora_med>='05:00'and $hora_med<='5:59') || 
        ($hora_med>='06:00'and $hora_med<='006:59') ||
        ($hora_med>='07:00'and $hora_med<='07:59') ){
        $turno="NOCTURNO";
    }
$fecha_actual = date("Y-m-d");

$fechahora = date("Y-m-d H:i");
       $ingresar9 = mysqli_query($conexion, 'INSERT INTO medica_trans (id_atencion,fecha,hora,turno,medicamento,dosis,unimed,via,id_usua,fecha_registro,otro) values (' . $id_atencion . ' , "' . $fecha_mat . '","' . $hora_med . '","' . $turno . '","' . $med . '","' . $dosis . '","' . $unimed . '","' . $via . '",' . $id_usua .',"'.$fechahora.'","'.$otro.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

           echo '<script type="text/javascript">window.location.href = "nota_registro_grafico.php";</script>';
          }
          ?>

 <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
            </div>
             <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
              
                    <th scope="col">Pdf</th>
                    <th scope="col">Medicamento</th>
                    <th scope="col">Dósis</th>
                    <th scope="col">Unidad de medida</th>
                    <th scope="col">Vía</th>
                     <th scope="col">Fecha de registro</th>
                    <th scope="col">Fecha de reporte</th>
                    <th scope="col">Hora</th> 
                   <th scope="col"></th>
                    <th scope="col">Registró</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                </tr>
                </thead>
                <tbody>

<?php
include "../../conexionbd.php";
$id_atencion=$_SESSION['hospital'];
$resultado = $conexion->query("SELECT * from medica_trans m , reg_usuarios r WHERE m.id_atencion=$id_atencion and m.id_usua=r.id_usua ORDER BY id_mtrans DESC") or die($conexion->error);
$usuario = $_SESSION['login'];
while($f = mysqli_fetch_array($resultado)){   

    $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion") or die($conexion->error);

            
              while ($row = $resultado2->fetch_assoc()) {             
    ?>
                    <tr>
                        <td class="fondo"><a href="../../enfermera/pdf/pdf_medicamentos.php?id_ord=<?php echo $f['id_med_reg'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usuario['id_usua']?>&fecha=<?php echo $f['fecha_mat'];?>&id_exp=<?php echo $row['Id_exp'];?>" target="_blank"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></a></td>
                        <td class="fondo"><strong><?php echo $f['medicamento'];?></strong></td>
                         <td class="fondo"><strong><?php echo $f['dosis'];?></strong></td>
                          <td class="fondo"><strong><?php echo $f['unimed'];?></strong></td>
                         <td class="fondo"><strong><?php echo $f['via'];?></strong></td>
                         <td class="fondo"><strong><?php $dater=date_create($f['fecha_registro']); echo date_format($dater,"d/m/Y H:i a");?></strong></td>
                        <td class="fondo"><strong><?php $date=date_create($f['fecha']); echo date_format($date,"d/m/Y");?></strong></td>
                        <td class="fondo"><strong><?php echo $f['hora'];?></strong></td>
                        <td class="fondo"><strong><?php echo $f['otro'];?></strong></td>
                        <td class="fondo"><strong><?php echo $f['papell'].' '.$f['sapell']?></strong></td>

<td><a href="edit_med.php?id_med_reg=<?php echo $f['id_mtrans'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>

<td><a href="el_med.php?id_med_reg=<?php echo $f['id_mtrans'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-danger">X </button></td>

                    </tr>
                    <?php
                }
                 }
                ?>
                
                </tbody>
              
            </table>
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
      
 



<script>

const $grafica = document.querySelector("#grafica");
// Las etiquetas son las que van en el eje X. 
const etiquetas = ["1", "2", "3", "4","5", "6", "7", "8","9", "10", "11", "12","13", "14", "15", "16","17", "18", "19", "20","21", "22", "23", "24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48"]
// Podemos tener varios conjuntos de datos
const presion = {
    label: "PRESIÓN SISTOLICA",
    data: [<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=34") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>,<?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>, <?php 
$resp = $conexion->query("select sistg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['sistg'];

 } ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
    borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
    borderWidth: 1,// Ancho del borde
};
const frec = {
    label: "PRESIÓN DIASTOLICA",
   data: [<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=34") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>,<?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>, <?php 
$resp = $conexion->query("select diastg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['diastg'];

 } ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(255, 159, 64, 0.2)',// Color de fondo
    borderColor: 'rgba(255, 159, 64, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

const fresp = {
    label: "FRECUENCIA CARDIACA",
    data: [<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=34") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>,<?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>, <?php 
$resp = $conexion->query("select fcardg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['fcardg'];

 } ?>],// La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(25, 159, 64, 0.2)',// Color de fondo
    borderColor: 'rgba(25, 159, 64, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

const temp = {
    label: "FRECUENCIA RESPIRATORIA",
    data: [<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=34") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>,<?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>, <?php 
$resp = $conexion->query("select frespg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['frespg'];

 } ?>],// La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(255, 5, 164, 0.2)',// Color de fondo
    borderColor: 'rgba(255, 5, 164, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

const sat = {
    label: "SATURACIÓN OXÍGENO",
    data: [<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=34") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>,<?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>, <?php 
$resp = $conexion->query("select satg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['satg'];

 } ?>],// La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(255, 5, 4, 0.2)',// Color de fondo
    borderColor: 'rgba(255, 5, 4, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

const niv = {
    label: "TEMPERATURA",
    data: [<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=1") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=2") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=3") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=4") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=5") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=6") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=7") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=8") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=9") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=10") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=11") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=12") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=13") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=14") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=15") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=16") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=17") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=18") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=19") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=20") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=21") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=22") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=23") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=24") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=25") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=26") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=27") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=28") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=29") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=30") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=31") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=32") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=33") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=35") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=36") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=37") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=38") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=39") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=40") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=41") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=42") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=43") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=44") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>,<?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=45") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=46") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=47") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>, <?php 
$resp = $conexion->query("select tempg from dat_trans_grafico where id_atencion=$id_atencion and hora=48") or die($conexion->error);
while ($resp_r = mysqli_fetch_array($resp)) {

echo $resp_r['tempg'];

 } ?>],// La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(155, 125, 224, 0.2)',// Color de fondo
    borderColor: 'rgba(155, 125, 224, 1)',// Color del borde
    borderWidth: 1,// Ancho del borde
};

new Chart($grafica, {
    type: 'line',// Tipo de gráfica
    data: {
        labels: etiquetas,
        datasets: [
            presion,
            frec,
            fresp,
            temp,
            sat,
            niv
            // Aquí más datos...
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
        },
    }
});
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>
  
</body>
</html>