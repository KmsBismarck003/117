    <?php
    session_start();
    
    include "../header_administrador.php";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
       <meta charset="UTF-8">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
              integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
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
              integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


        <script src="../../js/jquery-3.3.1.min.js"></script>
        <script src="../../js/jquery-ui.js"></script>
        <script src="../../js/popper.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        <script src="../../js/jquery.magnific-popup.min.js"></script>
        <script src="../../js/aos.js"></script>
        <script src="../../js/main.js"></script>


         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
     
        <link rel="shortcut icon" href="logp.png">

<style>
    .dropdwn {
      float: left;
      overflow: hidden;
    }

    .dropdwn .dropbtn {
      cursor: pointer;
      font-size: 16px;
      border: none;
      outline: none;
      color: white;
      padding: 14px 16px;
      background-color: inherit;
      font-family: inherit;
      margin: 0;
    }

    .navbar a:hover,
    .dropdwn:hover .dropbtn,
    .dropbtn:focus {
      background-color: #367fa9;
    }

    .dropdwn-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdwn-content a {
      float: none;
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      text-align: left;
    }

    .dropdwn-content a:hover {
      background-color: #ddd;
    }

    .show {
      display: block;
    }

    * {
      box-sizing: border-box;
    }

    .todo-container {
      max-width: 10000px;
      height: auto;
      display: flex;
      overflow-y: scroll;
      column-gap: 0.5em;
      column-rule: 10px solid white;
      column-width: 100px;
      column-count: 7;
    }

    .status {
      width: 25%;
      background-color: #ecf0f5;
      position: relative;
      padding: 60px 1rem 0.5rem;
      height: 100%;

    }

    .status h4 {
      position: absolute;
      top: 0;
      left: 0;
      background-color: #0b3e6f;
      color: white;
      margin: 0;
      width: 100%;

      padding: 0.5rem 1rem;
    }

    .alert{
         padding-right:64px;
         padding-left:6px;
     }
.nod{

        font-size: 10px;
     }

     .aaa{
      padding-bottom:0.1px;
     }
     .all{
      margin-right:-77px;

     }
        
    @media screen and (max-width: 980px){
     
    .container{
        width:610px;
       margin-left:-20px;
      
        
    }
     .alert{
         padding-right: 38px;
         padding-left: 10px;
     }
     .nompac{
         margin-left:-3px;
        font-size: 10px;

     }
     .nod{
        font-size: 6px;
     }
}
  </style>
    </head>

<div class="container-fluid">
  
    <a href="../cuenta_paciente/vista_ahosp.php"><button class="btn btn-danger btn-sm" role="button" >Regresar</button></a>
    <p>

<section>
  <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
   <center><strong>HOSPITALIZACIÓN</strong></center><p>
  </div> 

<div class="container box col-12">
        <div class= "row">
        
       
        <?php
        $sql = 'SELECT * from cat_camas where piso=1 and seccion=1 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
          $intendencia = $row['intendencia'];

          if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $esta ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "EN PROCESO DE LIBERA"){
            $pr="POR LIBERAR";
?>

             <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
               
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">

                <i style="font-size:25px;" class="fa fa-bed"></i>
                
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
        <?php
          }
        }
        ?>      

        <?php
        $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=1 and seccion=2 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
            $intendencia = $row['intendencia'];
  if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $esta ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "EN PROCESO DE LIBERA"){
            $pr="POR LIBERAR";
?>

             <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
               
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">

                <i style="font-size:25px;" class="fa fa-bed"></i>
                
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
        <?php
          }
        }
        ?>      

</div>
</div>
       
<!--<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>HOSPITALIZACIÓN PISO 2</strong></center><p>
</div>-->
<div class="container box col-12">
        <div class= "row">
        
       
        <?php
        $sql = 'SELECT * from cat_camas where piso=2 and seccion=1 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
          $intendencia = $row['intendencia'];

          if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $esta ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "EN PROCESO DE LIBERA"){
            $pr="POR LIBERAR";
?>

             <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
               
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">

                <i style="font-size:25px;" class="fa fa-bed"></i>
                
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
        <?php
          }
        }
        ?>      

        <?php
        $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=2 and seccion=2 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
            $intendencia = $row['intendencia'];
  if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $esta ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "EN PROCESO DE LIBERA"){
            $pr="POR LIBERAR";
?>

             <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
               
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">

                <i style="font-size:25px;" class="fa fa-bed"></i>
                
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
        <?php
          }
        }
        ?>      

</div>
</div>

<!--<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>HOSPITALIZACIÓN PISO 3</strong></center><p>
</div>-->
<div class="container box col-12">
        <div class= "row">
        
       
        <?php
        $sql = 'SELECT * from cat_camas where piso=3 and seccion=1 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
          $intendencia = $row['intendencia'];

          if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $esta ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "EN PROCESO DE LIBERA"){
            $pr="POR LIBERAR";
?>

             <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
               
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">

                <i style="font-size:25px;" class="fa fa-bed"></i>
                
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
        <?php
          }
        }
        ?>      

        <?php
        $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=3 and seccion=2 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
            $intendencia = $row['intendencia'];
  if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $esta ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "EN PROCESO DE LIBERA"){
            $pr="POR LIBERAR";
?>

             <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
               
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">

                <i style="font-size:25px;" class="fa fa-bed"></i>
                
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
        <?php
          }
        }
        ?>      

</div>
</div>
            

<!-- camas de Terapia -->
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <strong><center>TERAPIA INTENSIVA</center></strong>
</div>         
<div class="container box col-12">
        <div class= "row">
        
       
        <?php
        $sql = 'SELECT * from cat_camas where piso=4 and seccion=1 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
          $intendencia = $row['intendencia'];

          if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $esta ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "EN PROCESO DE LIBERA"){
            $pr="POR LIBERAR";
?>

             <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
               
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">

                <i style="font-size:25px;" class="fa fa-bed"></i>
                
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
        <?php
          }
        }
        ?>      

        <?php
        $sql = 'SELECT id,estatus,tipo,num_cama, id_atencion from cat_camas where piso=4 and seccion=2 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
            $intendencia = $row['intendencia'];
  if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $esta ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "EN PROCESO DE LIBERA"){
            $pr="POR LIBERAR";
?>

             <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
               
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">

                <i style="font-size:25px;" class="fa fa-bed"></i>
                
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
        <?php
          }
        }
        ?>      

</div>
</div>

<!-- camas de urgencias -->
            
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <strong><center>OBSERVACIÓN</center></strong>
</div>         

<div class="container box col-12">
        <div class= "row">
        
       
        <?php
        $sql = 'SELECT * from cat_camas where piso=5 and seccion=1 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
          $intendencia = $row['intendencia'];

          if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $esta ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "EN PROCESO DE LIBERA"){
            $pr="POR LIBERAR";
?>

             <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
               
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">

                <i style="font-size:25px;" class="fa fa-bed"></i>
                
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
        <?php
          }
        }
        ?>      
 
        <div class="col-lg-1.9 col-sm-2">
            <center><strong><div class="thead" style="background-color: white; color: BLACK; font-size: 20px;"><p> SALA <br> DE <br> CHOQUE</p></div></strong>
            </center>
        </div>
 

        <?php
        $sql = 'SELECT * from cat_camas where piso=5 and seccion=2 ORDER BY num_cama ASC';
        $result = $conexion->query($sql);
        $result = $conexion->query($sql);
        //  $id_atencion = $_GET['id_atencion'];
        while ($row = $result->fetch_assoc()) {
          $num_cama = $row['num_cama'];
          $id_atencion = $row['id_atencion'];
          $estaus = $row['estatus'];
          $biomedica = $row['biomedica'];
          $mantenimiento = $row['mantenimiento'];
          $serv_generales = $row['serv_generales'];
          $intendencia = $row['intendencia'];

  if ($estaus == "LIBRE" or $estaus == "Libre") {
        ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-success" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "MANTENIMIENTO" or $estaus == "Mantenimiento") {
             $esta = "NO DISPONIBLE";
          ?>
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-danger" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $esta ?></font></h7>
                <br>
                <br>
              </div>
            </div>
          <?php
          } elseif ($estaus == "EN PROCESO DE LIBERA"){
            $pr="POR LIBERAR";
?>

             <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert-warning" role="alert">
                <a href="#" class="small-box-footer"><i style="font-size:25px;" class="fa fa-bed"></i></a>
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="1"><?php echo $pr ?></font></h7>
                <br>
                <br>
              </div>
            </div>
<?php
          }else{
          ?>
               
            <div class="col-lg-1.9 col-xs-1">
              <div class="alert alert" role="alert" style="background-color: #2b2d7f; color:white;">

                <i style="font-size:25px;" class="fa fa-bed"></i>
                
                <h7><font size="3"><?php echo $num_cama ?></font></h7>
                <br>
                <h7><font size="2"><?php echo $estaus ?></font></h7>
                <br>
                <br>
              </div>
            </div>
        <?php
          }
        }
        ?>      

</div>
</div>


  </div>
</div>
                       
</div>

</section>
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
