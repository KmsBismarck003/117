<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: ./index.php");
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

<link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />

<title>Menu Principal </title>
<link rel="shortcut icon" href="logo.jpg">
</head>
<div class="container">
  <div class="row">
    <div class="col-sm">
      
    </div>
    <div class="col-6">
      <div class="card" style="width: 26rem; text-align:center;">
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><img class="img-fluid" class="rounded" src="imagenes/logo.jpg" height="190" width="250"></li>
    
  </ul>
  </div><br>
  
    </div>
  
    <div class="btn-group" role="group">
         
       <button id="btnGroupDrop1" type="button" class="btn btn-outline-light dropdown-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><font id="letra"> <?php echo $_SESSION['login'];?></button>
     
        	 <div class="dropdown-menu " aria-labelledby="btnGroupDrop1">
        	     
   <div class="col-2">
     <a href="cerrar_sesion.php"><button class="btn btn-outline-danger " id="letra"> Salir de la sesion</button></a>
    </div>
    </div>
   
      </div>
      
   
  </div>
</div>

  
    
  

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 collapse show d-md-flex pt-10 pl-0 min-vh-100" id="sidebar">

            <ul class="nav flex-column flex-nowrap overflow-hidden">
              <li class="nav-item"><a href="menu_gadmin.php"><button class="btn btn-outline-light my-2 my-sm-12 col-12" id="letra" ><i class="fa fa-id-card" aria-hidden="true" ></i> Gestión Administrativa</button></a></li>
                              
                </li>
            <li class="nav-item"><a href="menu_gmedica.php"><button class="btn btn-outline-light my-2 my-sm-12 col-12" id="letra"><i class="fa fa-plus-square" aria-hidden="true"></i> Gestión Médica</button></a></li>

                            <li class="nav-item"><a href="menu_seraux.php"><button class="btn btn-outline-light my-2 my-sm-12 col-12"id="letra"><i class="fa fa-user-md" aria-hidden="true"></i> Servicios Auxiliares</button></a></li>
                            
        <hr><hr><hr>
            </ul>
        </div>
        
    
       <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" id"car">
    <div class="carousel-item active">
      <img class="img-fluid" src="imagenes/sanatorio.jpg" width="1110" align="center" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="img-fluid" src="imagenes/sin.png" width="1110" align="center" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="img-fluid" src="imagenes/sillas.jpg" width="1110" align="center" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
       


<script>
document.oncontextmenu = function(){return false;}

</script>
</body>
</html>