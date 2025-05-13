<?php
session_start();
include "../../conexionbd.php";
include("../../enfermera/header_enfermera.php");

$num_cama=@$_GET['num_cama'];

if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
}
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




    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>



    <title>Asignar habitacion </title>
    <link rel="shortcut icon" href="logp.png">

    <style type="text/css">
    .modal-lg { max-width: 75% !important; }

</style>
</head>


<body>
    <div class="container">
        <div class="row">
            <div class="col col-12">
               
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
                
               
                <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
                  <strong><center>DISPONIBILIDAD DE CAMAS</center></strong>
                </div>
               
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars" id="side"></i></a>
            </div>
        </div>
    </div>
<div class="container">
    <br><div class="container">
        <div class="thead" style="background-color: white; color: black; font-size: 20px;">
                  <strong>LISTA DE CAMAS</strong>
                </div>
            </div>
            <hr>
            <?php 

$re1 = $conexion->query("SELECT * FROM cat_camas where num_cama=$num_cama order by num_cama DESC LIMIT 1") or die($conexion->error);
while ($ro1 = mysqli_fetch_array($re1)) {
    $nocama=$ro1['num_cama'];

    }

$serv = $conexion->query("SELECT * FROM servicios_generales where cama=$nocama") or die($conexion->error);
while ($fr = mysqli_fetch_array($serv)) {
$id_sgen=$fr['id_sgen'];
$realizado2=$fr['realizado'];
$seguropac2=$fr['seguropac'];
$fecha_egreso=$fr['fecha_egreso'];
}
$id_sgen;
if($seguropac2=='No') {
    
$resultado = $conexion->query("SELECT * FROM cat_camas where num_cama=$nocama") or die($conexion->error);
             ?>
                <table class="table table-bordered table-striped table-responsive">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Fecha de egreso</th>
                            <th scope="col">Área</th>
                            <th scope="col">Cama</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Tipo de limpieza</th>
                            <th scope="col">Servicios generales</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($f = mysqli_fetch_array($resultado)) {



$fecha_actual = date("d-m-Y H:i");
                       
                    $tipo=$f['tipo'];
                    $num_cama=$f['num_cama'];
                    $motivo=$f['motivo'];
                        ?>

                            <tr>
                              
                                <td><?php echo $id_sgen;?></td>
                               <td class="col-sm-2"><?php 
                                $fechegreso=date_create($fecha_egreso);

                                echo date_format($fechegreso,'d-m-Y H:i')?></td>
                                <td><?php echo $f['tipo'];?></td>
                                <td><?php echo $f['num_cama'];?></td>
                                <td> <center><?php echo $f['motivo']; ?></center></td>
                                <td><p><center>/</center></strong></td>
                                

<td><center><!--<button type="button" class="btn btn" data-toggle="modal" data-target=".bd-example-modal-lg">--><img src="../../img/cr.png" width="60px"></center></button></td>



 
                            </tr>

                        <?php
                        
                    }
}else {
    ?>

    <?php
$resultado = $conexion->query("SELECT * FROM cat_camas where num_cama=$nocama") or die($conexion->error);
             ?>
                <table class="table table-bordered table-responsive">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Fecha de egreso</th>
                            <th scope="col">Área</th>
                            <th scope="col">Cama</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Tipo de limpieza</th>
                            <th scope="col">Servicios generales</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($f = mysqli_fetch_array($resultado)) {

$serv1 = $conexion->query("SELECT * FROM servicios_generales where realizado='Si' and  cama=$nocama order by id_sgen DESC LIMIT 1") or die($conexion->error);
while ($fr = mysqli_fetch_array($serv1)) {


$fecha_actual = date("d-m-Y H:i");
                       
                    $tipo=$f['tipo'];
                    $num_cama=$f['num_cama'];
                    $motivo=$f['motivo'];
                        ?>

                            <tr>

                                <td><?php echo $fr['id_sgen'];?></td>
                              <td class="col-sm-2"><?php 
                                $fechegreso=date_create($fecha_egreso);

                                echo date_format($fechegreso,'d-m-Y H:i')?></td>
                                <td><?php echo $f['tipo'];?></td>
                                <td><?php echo $f['num_cama'];?></td>
                                <td> <center><?php echo $f['motivo']; ?></center></td>
                                <td><center><?php echo $fr['t_limpieza']; ?></center></strong></td>
                                <td><center><font size="2"><?php $fu=date_create($fr['fecha']); echo date_format($fu,'d-m-Y H:i')?></font><img src="../../img/cv.png" width="60px"></center></td>
<?php
                        }
                    }
?>
                       
                    </tbody>
                </table>

    <?php
}



                        ?>
                       
                    </tbody>
                </table>

        </div>



<div class="container">
<!--MANTENIMIENTO-->
<!--MANTENIMIENTO-->
<!--MANTENIMIENTO-->
<?php 
$re1 = $conexion->query("SELECT * FROM cat_camas where num_cama=$num_cama order by num_cama DESC LIMIT 1") or die($conexion->error);
while ($ro1 = mysqli_fetch_array($re1)) {
    $nocama=$ro1['num_cama'];

    }
$man = $conexion->query("SELECT * FROM mantenimiento where cama=$nocama") or die($conexion->error);
while ($row_m = mysqli_fetch_array($man)) {
$id_man=$row_m['id_man'];
$realizado4=$row_m['realizado'];
$seguropac4=$row_m['seguropac'];
$fecha_egreso=$row_m['fecha_egreso'];
}
$id_man;
if($seguropac4=='No') {
$resultado2 = $conexion->query("SELECT * FROM cat_camas where num_cama=$nocama") or die($conexion->error);
 ?>

 <table class="table table-bordered table-striped table-responsive">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Fecha de egreso</th>
                            <th scope="col">Área</th>
                            <th scope="col">Cama</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Tipo de limpieza</th>
                            <th scope="col">Mantenimiento</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($f2 = mysqli_fetch_array($resultado2)) {



$fecha_actual2 = date("d-m-Y H:i");
                       
                    $tipo=$f2['tipo'];
                    $num_cama=$f2['num_cama'];
                    $motivo=$f2['motivo'];
                        ?>

                            <tr>
                            
                                <td><?php echo $id_man;?></td>
                               <td class="col-sm-2"><?php 
         $fechegreso=date_create($fecha_egreso);  
  echo date_format($fechegreso,'d-m-Y H:i')?></td>
                                <td><?php echo $f2['tipo'];?></td>
                                <td><?php echo $f2['num_cama'];?></td>
                                <td> <center><?php echo $f2['motivo']; ?></center></td>
                                <td><center>/</center></strong></td>
                                <td><center><!--<button type="button" class="btn btn" data-toggle="modal" data-target=".bd-example-modal-lg1">--><img src="../../img/llr.png" width="60px"></center></button></td>



                                 
                            </tr>
                        </tbody>
                    </table>

                <?php }
                }else{
                ?>
    <?php
$resultado = $conexion->query("SELECT * FROM cat_camas where num_cama=$nocama") or die($conexion->error);
             ?>
                <table class="table table-bordered table-responsive">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Fecha de egreso</th>
                            <th scope="col">Área</th>
                            <th scope="col">Cama</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Tipo de limpieza</th>
                            <th scope="col">Mantenimiento</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($f = mysqli_fetch_array($resultado)) {

$serv1 = $conexion->query("SELECT * FROM mantenimiento where realizado='Si' and cama=$nocama order by id_man DESC LIMIT 1") or die($conexion->error);
while ($fr = mysqli_fetch_array($serv1)) {


$fecha_actual = date("d-m-Y H:i");
                       
                    $tipo=$f['tipo'];
                    $num_cama=$f['num_cama'];
                    $motivo=$f['motivo'];
                        ?>

                            <tr>

                                <td><?php echo $fr['id_man'];?></td>
                               <td class="col-sm-2"><?php 
         $fechegreso=date_create($fecha_egreso);  
  echo date_format($fechegreso,'d-m-Y H:i')?></td>
                                <td><?php echo $f['tipo'];?></td>
                                <td><?php echo $f['num_cama'];?></td>
                                <td> <center><?php echo $f['motivo']; ?></center></td>
                                <td><center><?php echo $fr['t_limpieza']; ?></center></strong></td>
                                <td><center><font size="2"><?php $fu=date_create($fr['fecha']); echo date_format($fu,'d-m-Y H:i')?></font><img src="../../img/llv.png" width="50px"></center></td>
<?php
                        }
                    }
                }
?>
                       
                    </tbody>
                </table>
</font>


<!--BIOMÉDICA-->
<!--BIOMÉDICA-->
<!--BIOMÉDICA-->


<?php 

$re1 = $conexion->query("SELECT * FROM cat_camas where num_cama=$num_cama order by num_cama DESC LIMIT 1") or die($conexion->error);
while ($ro1 = mysqli_fetch_array($re1)) {
    $nocama=$ro1['num_cama'];

    }

$manb = $conexion->query("SELECT * FROM biomedica where cama=$nocama") or die($conexion->error);
while ($row_mb = mysqli_fetch_array($manb)) {
$id_bio=$row_mb['id_bio'];
$realizado5=$row_mb['realizado'];
$seguropac5=$row_mb['seguropac'];
$fecha_egreso=$row_mb['fecha_egreso'];
}
$id_bio;

if($seguropac5=='No') {
$resultado2 = $conexion->query("SELECT * FROM cat_camas where num_cama=$nocama order by num_cama DESC LIMIT 1") or die($conexion->error);
 ?>
<div class="container">
 <table class="table table-bordered table-striped table-responsive">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Fecha de egreso</th>
                            <th scope="col">Área</th>
                            <th scope="col">Cama</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Tipo de limpieza</th>
                            <th scope="col">Biomédica</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($f2 = mysqli_fetch_array($resultado2)) {



$fecha_actual2 = date("d-m-Y H:i");
                       
                    $tipo=$f2['tipo'];
                    $num_cama=$f2['num_cama'];
                    $motivo=$f2['motivo'];
                        ?>

                            <tr>
                            
                                <td><?php echo $id_bio;?></td>
                               <td class="col-sm-2"><?php 
         $fechegreso=date_create($fecha_egreso);  
  echo date_format($fechegreso,'d-m-Y H:i')?></td>
                                <td><?php echo $f2['tipo'];?></td>
                                <td><?php echo $f2['num_cama'];?></td>
                                <td> <center><?php echo $f2['motivo']; ?></center></td>
                                <td><center>/</center></strong></td>
                                <td><center><!--<button type="button" class="btn btn" data-toggle="modal" data-target=".bd-example-modal-lg2">--><img src="../../img/mr.png" width="50px"></center></button></td>


                            </tr>
                        </tbody>
                    </table>
                    </div>
                <?php }
                }else {
                ?>
    <?php
$resultado = $conexion->query("SELECT * FROM cat_camas where num_cama=$nocama") or die($conexion->error);
             ?>
                <table class="table table-bordered table-responsive">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Fecha de egreso</th>
                            <th scope="col">Área</th>
                            <th scope="col">Cama</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Tipo de limpieza</th>
                            <th scope="col">Biomédica</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($f = mysqli_fetch_array($resultado)) {

$serv1 = $conexion->query("SELECT * FROM biomedica where realizado='Si' and cama=$num_cama order by id_bio DESC LIMIT 1") or die($conexion->error);
while ($fr = mysqli_fetch_array($serv1)) {


$fecha_actual = date("d-m-Y H:i");
                       
                    $tipo=$f['tipo'];
                    $num_cama=$f['num_cama'];
                    $motivo=$f['motivo'];
                        ?>

                            <tr>

                                <td><?php echo $fr['id_bio'];?></td>
                              <td class="col-sm-2"><?php 
         $fechegreso=date_create($fecha_egreso);  
  echo date_format($fechegreso,'d-m-Y H:i')?></td>
                                <td><?php echo $f['tipo'];?></td>
                                <td><?php echo $f['num_cama'];?></td>
                                <td> <center><?php echo $f['motivo']; ?></center></td>
                                <td><center><?php echo $fr['t_limpieza']; ?></center></strong></td>
                                <td><center><font size="2"><?php $fu=date_create($fr['fecha']); echo date_format($fu,'d-m-Y H:i')?></font><img src="../../img/mv.png" width="50px"></center></td>
<?php
                        }
                    }
                }
?>
                     
                    </tbody>
                </table>

    







<?php
$realizado='';
$realizado2='';
$realizado3='';



$r1 = $conexion->query("SELECT * FROM servicios_generales where cama=$nocama") or die($conexion->error);
while ($rowr = mysqli_fetch_array($r1)) {
    $realizado=$rowr['realizado'];
    $seguropac=$rowr['seguropac'];
    //echo $realizado;
}
$r2 = $conexion->query("SELECT * FROM mantenimiento where cama=$nocama") or die($conexion->error);
while ($rowr2 = mysqli_fetch_array($r2)) {
    $realizado2=$rowr2['realizado'];
    $seguropac2=$rowr2['seguropac'];
    //echo $realizado2;
}
$r3 = $conexion->query("SELECT * FROM biomedica where cama=$nocama") or die($conexion->error);
while ($rowr3 = mysqli_fetch_array($r3)) {
    $realizado3=$rowr3['realizado'];
     $seguropac3=$rowr3['seguropac'];
    //echo $realizado3;
}

if($seguropac=='Si' AND $seguropac2=='Si' and $seguropac3=='Si'){ 
?>

<form action="" method="POST">
<center><button type="submit" class="btn btn-success col-6" name="liberar" style="font-size: 22px;">Liberar cama</button></center>
</form>

<?php
if (isset($_POST['liberar'])) {
 $sql2 = "UPDATE cat_camas SET estatus = 'LIBRE', motivo='',mantenimiento='',biomedica='',serv_generales='' WHERE num_cama = $nocama";
      $result = $conexion->query($sql2);

//$sql2 = "UPDATE servicios_generales SET realizado = 'te' WHERE cama = $num_cama";
      $result = $conexion->query($sql2);
echo '<script type="text/javascript">window.location.href ="../../template/menu_enfermera.php";</script>';
}


?>

<?php }else if($seguropac=="No"){
?>
<center><div class="thead" style="background-color: red; color: WHITE; font-size: 19px;">
                  <strong>COMPLETAR FORMULARIO DE SERVICIOS GENERALES PARA LIBERAR CAMA</strong>
                </div></center>




<?php }else if($seguropac2=="No"){
?>
<center><div class="thead" style="background-color: red; color: WHITE; font-size: 19px;">
                  <strong>COMPLETAR FORMULARIOS DE MANTENIMIENTO PARA LIBERAR CAMA</strong>
                </div></center>




<?php }else if($seguropac3=="No"){
?>
<center><div class="thead" style="background-color: red; color: WHITE; font-size: 19px;">
                  <strong>COMPLETAR FORMULARIOS DE BIOMÉDICA PARA LIBERAR CAMA</strong>
                </div></center>




<?php } ?>
<hr>
<div class="container">
<!--LISTA DE REGISTROS-->

        <div class="thead" style="background-color: white; color: black; font-size: 17px;">
                  <strong> LISTA DE REGISTROS SERVICIOS GENERALES</strong>
                </div>
         <?php 
$resultador = $conexion->query("SELECT * FROM servicios_generales where cama=$nocama") or die($conexion->error);
             ?>
                <table class="table table-bordered table-striped table-responsive">
                    <thead class="thead">
                        <tr>

                            <th scope="col">Id</th>
                            <th scope="col">Fecha y hora</th>
                            
                            <th scope="col">Tipo de limpieza</th>
                            <th scope="col">Cama</th>
                            <th scope="col">Colchón</th>
                            <th scope="col">Buro</th>
                            <th scope="col">Mesa de puente</th>
                            <th scope="col">Cabecera</th>
                            <th scope="col">Segura para uso con paciente</th>
                            <th scope="col">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($fr = mysqli_fetch_array($resultador)) {

$fecha_actual = date("d-m-Y H:i");
                       
                   
                        ?>

                            <tr>
                               <!-- <td scope="row" id="letra" align="center"><a href="../censo/dispo_camas_asigna.php?id_atencion=<?php echo $f['id']; ?>"><strong> <button type="button" class="btn btn-danger"> <i class="fa fa-bed" aria-hidden="true"></i> </button></td>-->
                                <td><?php echo $fr['id_sgen'];?></td>
                                <td class="col-sm-2"><?php $fu=date_create($fr['fecha']); echo  date_format($fu,'d-m-Y H:i')?></td>
                               
                                <td><?php echo $fr['t_limpieza']; ?></strong></td>
                              <td><?php echo $fr['cama'];?></td>
                                <td><?php echo $fr['lcolchon']; ?></strong></td>
                                <td><?php echo $fr['lburo']; ?></strong></td>
                                <td><?php echo $fr['lmesapuente']; ?></strong></td>
                                <td><?php echo $fr['lcabecera']; ?></strong></td>
                                <td><?php echo $fr['seguropac']; ?></strong></td>
                                <td><?php echo $fr['observaciones']; ?></strong></td>

<?php
                        }

                        ?>
                       
                    </tbody>
                </table>
            </div>
            
            
            <hr>
            <div class="container">
        <div class="thead" style="background-color: white; color: black; font-size: 17px;">
                  <strong> LISTA DE REGISTROS MANTENIMIENTO</strong>
                </div>
         <?php 
$resultador = $conexion->query("SELECT * FROM mantenimiento where cama=$nocama") or die($conexion->error);
             ?>
                <table class="table table-bordered table-striped table-responsive">
                    <thead class="thead">
                        <tr>

                            <th scope="col">Id</th>
                            <th scope="col">Fecha y hora</th>
                            <th scope="col">Tipo de limpieza</th>
                            <th scope="col">Segura para uso con paciente</th>
                            <th scope="col">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($fr = mysqli_fetch_array($resultador)) {

$fecha_actual = date("d-m-Y H:i");
                       
                   
                        ?>

                            <tr>
                               <!-- <td scope="row" id="letra" align="center"><a href="../censo/dispo_camas_asigna.php?id_atencion=<?php echo $f['id']; ?>"><strong> <button type="button" class="btn btn-danger"> <i class="fa fa-bed" aria-hidden="true"></i> </button></td>-->
                                <td><?php echo $fr['id_man'];?></td>
                                <td class="col-sm-2"><?php $fu=date_create($fr['fecha']); echo  date_format($fu,'d-m-Y H:i')?></td>
                                <td><?php echo $fr['t_limpieza']; ?></strong></td>
                                <td><?php echo $fr['seguropac']; ?></strong></td>
                                <td><?php echo $fr['observaciones']; ?></strong></td>
                                

<?php
                        }

                        ?>
                       
                    </tbody>
                </table>
            </div><hr>

<div class="container">
        <div class="thead" style="background-color: white; color: black; font-size: 17px;">
                  <strong> LISTA DE REGISTROS BIOMÉDICA</strong>
                </div>
         <?php 
$resultador = $conexion->query("SELECT * FROM biomedica where cama=$nocama") or die($conexion->error);
             ?>
                <table class="table table-bordered table-striped table-responsive">
                    <thead class="thead">
                        <tr>

                            <th scope="col">Id</th>
                            <th scope="col">Fecha y hora</th>
                            <th scope="col">Tipo de limpieza</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Segura para uso con paciente</th>
                            <th scope="col">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($fr = mysqli_fetch_array($resultador)) {

$fecha_actual = date("d-m-Y H:i");
                       
                   
                        ?>

                            <tr>
                               <!-- <td scope="row" id="letra" align="center"><a href="../censo/dispo_camas_asigna.php?id_atencion=<?php echo $f['id']; ?>"><strong> <button type="button" class="btn btn-danger"> <i class="fa fa-bed" aria-hidden="true"></i> </button></td>-->
                                <td><?php echo $fr['id_bio'];?></td>
                                <td class="col-sm-2"><?php $fu=date_create($fr['fecha']); echo  date_format($fu,'d-m-Y H:i')?></td>                              
                                <td><?php echo $fr['t_limpieza']; ?></strong></td>
                                <td><?php echo $fr['marca']; ?></strong></td>
                                <td><?php echo $fr['modelo']; ?></strong></td>
                                <td><?php echo $fr['seguropac']; ?></strong></td>
                                <td><?php echo $fr['observaciones']; ?></strong></td>
                                

<?php
                        }

                        ?>
                       
                    </tbody>
                </table>
            </div><br>
</div>

</div>

    <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- FastClick -->
    <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>


</body>

</html>