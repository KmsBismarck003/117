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

<title>Menu de Servicios Auxiliares</title>
<link rel="shortcut icon" href="logp.png">
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
    <div class="col-2"><br>
     <a href="index.php"><button class="btn btn-outline-danger " id="letra"> Salir de la sesion</button></a>
    </div>
  </div>
</div>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 collapse show d-md-flex pt-10 pl-0 min-vh-100" id="sidebar">

            <ul class="nav flex-column flex-nowrap overflow-hidden">

                <div class="dropdown">
  <button class="btn btn-outline-light dropdown-toggle my-2 my-sm-12 col-md-15 col-12" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Laboratorio <br> y banco de sangre </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="triage.php">Interface con <br>expediente clinico <br> electronico</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="cons_inf.php">Control de <br> solicitud de estudio</a>
        <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="h_clinica">Visor de resultados<br> de estudio en ECE</a>
  </div>
</div>
                
<div class="dropdown">
  <button class="btn btn-outline-light dropdown-toggle my-sm-12 col-md-15 col-12" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Rayos"X" <br>Tomografia </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="admicion.php">Control de <br> solicitud de estudio</a>
        <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="h_clinica.php">Reporte de <br> diagnostico por <br> el radiologo</a>
  </div>
</div>
                
<div class="dropdown">
  <button class="btn btn-outline-light dropdown-toggle my-2 my-sm-12 col-md-15 col-12" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Nutrición </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="cons_inf.php">Control de menus</a>
        <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="h_clinica.php">Control de dietas <br> de pacientes</a>
        <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="insumos.php">Monitoreo de dietas <br> de pacientes</a>
  </div>
</div>
                
<div class="dropdown">
  <button class="btn btn-outline-light dropdown-toggle my-2 my-sm-12 col-md-15 col-12" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Existencias CEvE </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="cons_inf.php">Control de instrumental</a>
        <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="h_clinica.php">Control de materia<br> de curación y <br> medicamento</a>
        <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="insumos.php">Control de existencias</a>
        <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="receta_amb.php">Entradas y salidas</a>
  </div>
</div>
                
<div class="dropdown">
  <button class="btn btn-outline-light dropdown-toggle my-2 my-sm-12 col-md-15 col-12" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Farmacia </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="cons_inf.php">Surtimiento de Recetas</a>
        <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="h_clinica.php">Control de medicamentos <br> y material de curación</a>
        <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="insumos.php">Control de entradas y salidas</a>
  </div>
</div>
                             <hr><hr><hr><hr><hr><hr><hr><hr>
            <li class="nav-item"><a href="menu.php"><button class="btn btn-outline-light my-2 my-sm-12 col-12"id="letra"><i class="fa fa-undo" aria-hidden="true"></i> MENU</button></a></li> 
        <hr><hr><hr>
            </ul>
        </div>
       
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="rounded img-fluid" src="imagenes/sanatorio.jpg" width="1100" alt="First slide" id"car">
    </div>
    <div class="carousel-item">
      <img class="rounded img-fluid" src="imagenes/sin.png" width="1110" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="rounded img-fluid" src="imagenes/sillas.jpg" width="1100" align="center" alt="Third slide">
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