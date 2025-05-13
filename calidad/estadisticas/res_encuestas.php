<?php
session_start();
//include "../conexionbd.php";
include "../header_calidad.php";
$resultado=$conexion->query("select * from reg_usuarios") or die($conexion->error);
$id_encuesta=@$_GET['id_encuesta'];
$id_exp=@$_GET['id_exp'];
$id_atencion=@$_GET['id_atencion'];
$nombre=@$_GET['nombre'];
?>

<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/aos.js"></script>
    <script src="../js/main.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        // Write on keyup event of keyword input element
        $(document).ready(function(){
            $("#search").keyup(function(){
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#mytable tbody tr"), function() {
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
    </script>
<style type="text/css">
#t{
 position: relative;
 left: 245px;  
}

#insa{
 position: relative;
 left: 425px;  
}

#verde{
 position: relative;
 left: 58px;  
}

</style>
    <title> ESTADISTICAS </title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>




    <div class="row">
        <div class="col  col-12">
            <h2>
             
                <center><font id="letra"> RESULTADOS DE LA ENCUESTA DEL PACIENTE: <strong> <?php echo $nombre ?></strong></font></h2></center>

</h2></div></div>

<section class="content container-fluid">
    <div class="container box">
        <div class="content">




              <?php
//echo $id_encuesta;

include "../../conexionbd.php";

$resultado = $conexion->query("select dat_ingreso.*,encuestas.*,paciente.*
from dat_ingreso inner join encuestas on dat_ingreso.id_atencion=encuestas.id_atencion
inner join paciente on dat_ingreso.Id_exp=paciente.Id_exp where encuestas.id_atencion=$id_atencion")or die($conexion -> error);

?>
<?php
                while($f = mysqli_fetch_array($resultado)){
                  $id_encuesta=$f['id_encuesta'];
 $id_atencion=$f['id_atencion'];
  $Id_exp=$f['Id_exp'];
                    ?>



       <section class="content container-fluid">
    <div class="container box">
        <div class="content">

<table class="table">
  <thead>
    
    <input type="hidden" name="id_atencion" value="<?php echo $id_at_cam;?>">
    <tr class="table-secondary">
      <th scope="col"><font size="2">1. ELIGA UNA CALIFICACIÓN  SI FUE ATENDIDO CON RESPETO POR PARTE DEL PERSONAL DE:</font></th>
      <th scope="col" ><img src="en.png" width="550"></th>
    
    </tr>
  </thead>
  <tbody>
    <tr>
        
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>RECEPCIÓN</strong></center></td>
      
      <td>

<?php if($f['resrep']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['resrep']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['resrep']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><center><font size="2">INSATISFECHO</font></center></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
 
   </td>
      
    </tr>
    <tr>
    <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>ENFERMERÍA</strong></center></td>
      <td>

<?php if($f['resenf']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['resenf']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['resenf']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>

</td>
         
    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>MÉDICO</strong></center></td>
      <td>
    <?php if($f['resmed']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['resmed']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['resmed']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>

    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>OTRO PERSONAL DEL SANATORIO</strong></center></td>
       <td>
         <?php if($f['resotro']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['resotro']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['resotro']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>

    </tr>
    <tr class="table-secondary">
      <th scope="col" colspan="2"><font size="2">2. ELIGA UNA CALIFICACIÓN  SI FUE ATENDIDO AL MOMENTO DE SOLICITARLO  POR PARTE DEL PERSONAL DE:</font></th>
     
     
    </tr>
  </thead>
  <tbody>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>RECEPCIÓN</strong></center></td>
      <td>
   <?php if($f['solrec']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['solrec']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['solrec']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>
     
    </tr>
    <tr>
         <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>ENFERMERÍA</strong></center></td>
     <td>
       <?php if($f['solenf']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['solenf']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['solenf']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>
    
    </tr>
    <tr>
    <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>MÉDICO</strong></center></td>
     <td>
      <?php if($f['solmed']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['solmed']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['solmed']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>
 
    </tr>
    <tr>
     <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>OTRO PERSONAL DEL SANATORIO</strong></center></td>
    <td>
        <?php if($f['solotro']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['solotro']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['solotro']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>

    </tr>
    <tr class="table-secondary">
      <th scope="col" colspan="2"><font size="2">3. BRINDE SU GRADO DE SATISFACCIÓN CON LA CALIDAD DE LA ATENCIÓN RECIBIDA:</font></th>
      
     
    </tr>
  </thead>
  <tbody>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>RECEPCIÓN</strong></center></td>
     <td>
          <?php if($f['brrec']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['brrec']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['brrec']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>

    </tr>
    <tr>
        <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>ENFERMERÍA</strong></center></td>
     <td>
        <?php if($f['brenf']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['brenf']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['brenf']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>
          
    </tr>
    <tr>
           <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>MÉDICO</strong></center></td>
    <td>
          <?php if($f['brmed']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['brmed']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['brmed']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>

    </tr>
    <tr>
         <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>OTRO PERSONAL DEL SANATORIO</strong></center></td>
        <td>
         <?php if($f['brotro']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['brotro']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['brotro']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>
 
    </tr>
    <tr class="table-secondary">
      <th scope="col" colspan="2"><font size="2">4. ELIGA UNA CALIFICACIÓN DE LOS SERVICIOS RECIBIDOS DE:</font></th>
      
     
    </tr>
  </thead>
  <tbody>
    <tr>
     <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>INSTALACIONES DEL HOSPITAL</strong></center></td>
        <td>
       <?php if($f['servins']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['servins']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['servins']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>
     
    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>LIMPIEZA DE HABITACIÓN</strong></center></td>
       <td>
        <?php if($f['servlim']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['servlim']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['servlim']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>
     
    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>ROPA DE LA HABITACIÓN</strong></center></td>
      <td>
       <?php if($f['servropa']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['servropa']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['servropa']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>

    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>SERVICIO DE ALIMENTACIÓN</strong></center></td>
      <td>
      <?php if($f['servali']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['servali']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['servali']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>

    </tr>
     <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>SERVICIO DE LABORATORIO</strong></center></td>
      <td>
        <?php if($f['lab']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['lab']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['lab']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>

    </tr>
     <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>SERVICIO DE IMAGENOLOGÍA</strong></center></td>
      <td>
       <?php if($f['imagen']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['imagen']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['imagen']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>
 
    </tr>
     <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>SERVICIO DE VIGILANCIA</strong></center></td>
      <td>
      <?php if($f['vig']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['vig']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['vig']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>

    </tr>
    <tr class="table-secondary">
      <th scope="col" colspan="2"><font size="2">5. ELIGA UNA ESCALA DE RECOMENDACIÓN:</font></th>
  
     
    </tr>
  </thead>
  <tbody>
    <tr>
        <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><center><strong>RECOMENDARÍA USTED AL SANATORIO VENECIA A OTRAS PERSONAS</strong></center></td>
     
         <td>
     <?php if($f['recsan']==10){
echo'
<div class="container">
  <div class="row">
  <div class="col-sm" id="verde">
     <label class="option_item">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="2">SATISFECHO</font></div> 
    </div>
    </label>
    </div>';
} else if ($f['recsan']==9){
     echo' <div class="col-sm" id="t">
     <label class="option_item">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="2">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>';
} else if($f['recsan']<=8){
 echo'<div class="col-sm" id="insa">
     <label class="option_item">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="2">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
  </div>';
}
?>
</td>
      
    </tr>
   <tr class="table-secondary">
      <th scope="col"><font size="2">6. OBSERVACIONES:</font></th>
      <td scope="col"><textarea rows="2" class="form-control" disabled style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"><?php echo $f['obs'];?></textarea></td>
     
    </tr>
   <?php
                }
                ?> 
  </tbody>
</table>

           

            </div>

</section>    



</body>
</html>