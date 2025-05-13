<?php
session_start();
include "../../conexionbd.php";
//include "../header_calidad.php";
$resultado=$conexion->query("select * from reg_usuarios") or die($conexion->error);
$id_at_cam = @$_GET['id_atencion'];
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
     <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
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

    <title> ENCUESTA DE SATISFACCIÓN </title>
<style type="text/css">
body{
  background-color: white;
}

  #v {
    color: white;
    background-color: #407959;
font-size: 17px;}
  #y {
    color: white;
    background-color: #bbb923;
font-size: 17px;}
 #r {
    color: white;
    background-color:#ed3f3f;
font-size: 17px;}

  </style>
</head>

<body>


    <div class="row">
        <div class="col  col-12">
            <h2>
             <br>

<div class="thead" style="background-color: #0c675e; color: white; font-size: 30px;">
                     <tr><center><strong><i class="fa fa-question-circle"></i> ENCUESTA</strong></center>

  </div>
<?//php echo $id_at_cam ?>


</h2></div></div>

<form action="insertar_enc.php" method="POST">
<section class="content container-fluid">
    <div class="container box">
        <div class="content">

<table class="table">
  <thead>
    
    <input type="hidden" name="id_atencion" value="<?php echo $id_at_cam;?>">
    <tr class="table-secondary">
      <th scope="col"><font size="2">1. ELIJA UNA CALIFICACIÓN  SI FUE ATENDIDO CON RESPETO POR PARTE DEL PERSONAL DE:</font></th>
      <th scope="col" ><img src="en.png" width="550"></th>
    
    </tr>
  </thead>
  <tbody>
    <tr>
        
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>RECEPCIÓN</strong></center></td>
      
      <td>
<div class="container">
  <div class="row">

    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resrep" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resrep" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resrep" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div>

   </td>
      
    </tr>
    <tr>
    <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>ENFERMERÍA</strong></center></td>
      <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resenf" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resenf" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resenf" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
     
    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>MÉDICO</strong></center></td>
      <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resmed" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resmed" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resmed" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>OTRO PERSONAL DEL SANATORIO</strong></center></td>
       <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resotro" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resotro" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="resotro" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
    </tr>
    <tr class="table-secondary">
      <th scope="col" colspan="2"><font size="2">2. ELIJA UNA CALIFICACIÓN  SI FUE ATENDIDO AL MOMENTO DE SOLICITARLO  POR PARTE DEL PERSONAL DE:</font></th>
     
     
    </tr>
  </thead>
  <tbody>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>RECEPCIÓN</strong></center></td>
      <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solrec" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solrec" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solrec" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
      
    </tr>
    <tr>
         <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>ENFERMERÍA</strong></center></td>
     <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solenf" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solenf" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solenf" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
     
    </tr>
    <tr>
    <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>MÉDICO</strong></center></td>
     <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solmed" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solmed" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solmed" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
    </tr>
    <tr>
     <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>OTRO PERSONAL DEL SANATORIO</strong></center></td>
    <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solotro" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solotro" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="solotro" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
    </tr>
    <tr class="table-secondary">
      <th scope="col" colspan="2"><font size="2">3. BRINDE SU GRADO DE SATISFACCIÓN CON LA CALIDAD DE LA ATENCIÓN RECIBIDA:</font></th>
      
     
    </tr>
  </thead>
  <tbody>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>RECEPCIÓN</strong></center></td>
     <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brrec" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brrec" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brrec" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
      
    </tr>
    <tr>
        <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>ENFERMERÍA</strong></center></td>
     <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brenf" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brenf" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brenf" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
     
    </tr>
    <tr>
           <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>MÉDICO</strong></center></td>
    <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brmed" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brmed" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brmed" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
    </tr>
    <tr>
         <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>OTRO PERSONAL DEL SANATORIO</strong></center></td>
        <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brotro" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brotro" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="brotro" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
    </tr>
    <tr class="table-secondary">
      <th scope="col" colspan="2"><font size="2">4. ELIJA UNA CALIFICACIÓN DE LOS SERVICIOS RECIBIDOS DE:</font></th>
      
     
    </tr>
  </thead>
  <tbody>
    <tr>
     <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>INSTALACIONES DEL HOSPITAL</strong></center></td>
        <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servins" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servins" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servins" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
      
    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>LIMPIEZA DE HABITACIÓN</strong></center></td>
       <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servlim" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servlim" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servlim" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
     
    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>ROPA DE LA HABITACIÓN</strong></center></td>
      <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servropa" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servropa" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servropa" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>SERVICIO DE ALIMENTACIÓN</strong></center></td>
      <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servali" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servali" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="servali" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>

    </tr>
     <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>SERVICIO DE LABORATORIO</strong></center></td>
      <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="lab" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="lab" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="lab" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
    </tr>
     <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>SERVICIO DE IMAGENOLOGÍA</strong></center></td>
      <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="imagen" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="imagen" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="imagen" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>

    </tr>
     <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>SERVICIO DE VIGILANCIA</strong></center></td>
      <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="vig" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="vig" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="vig" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>

    </tr>
    <tr class="table-secondary">
      <th scope="col" colspan="2"><font size="2">5. ELIJA UNA ESCALA DE RECOMENDACIÓN:</font></th>
  
     
    </tr>
  </thead>
  <tbody>
    <tr>
        <td> &nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><center><strong>RECOMENDARÍA USTED AL SANATORIO VENECIA A OTRAS PERSONAS</strong></center></td>
     
         <td><div class="container">
  <div class="row">
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="recsan" value="10" required="">
      <div class="option_inner facebook">
        <div class="tickmark"></div>
        <div class="icon"><img src="verde.png" width="40"></div>
        <div class="name"><font size="1">SATISFECHO</font></div> 
    </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="recsan" value="9">
      <div class="option_inner twitter">
        <div class="tickmark"></div>
         <div class="icon"><img src="naranja.png" width="40"></div>
        <div class="name"><font size="1">POCO SATISFECHO</font></div>
      </div>
    </label>
    </div>
    <div class="col-sm">
     <label class="option_item">
      <input type="radio" class="checkbox" name="recsan" value="5">
      <div class="option_inner instagram">
        <div class="tickmark"></div>
         <div class="icon"><img src="rojo.png" width="40"></div>
        <div class="name"><font size="1">INSATISFECHO</font></div>
      </div>
      </label>
    </div>
  </div>
</div></td>
      
    </tr>
   <tr class="table-secondary">
      <th scope="col"><font size="2">6. OBSERVACIONES:</font></th>
      <td scope="col"><textarea rows="2" class="form-control" name="obs" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea></td>
     
    </tr>
   
  </tbody>
</table>

           

            </div>

</section>

<div class="form-group col-12">
<center><button type="submit" class="btn btn-primary">ENVIAR</button>
<button type="button" class="btn btn-danger" onclick="window.close();">CANCELAR</button></center>
</div>
<br><br>
</form>
    </div>
<center>
    <footer class="main-footer">
        <?php
        include("../../template/footer.php");
        ?>
    </footer>
</center>
<script src="../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- FastClick -->
<script src='../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../template/dist/js/app.min.js" type="text/javascript"></script>








</body>
</html>