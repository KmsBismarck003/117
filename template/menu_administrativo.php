
<?php
include "../conexionbd.php";
session_start();
//
if (!isset($_SESSION['login'])) {
  // remove all session variables
  session_unset();
  // destroy the session
  session_destroy();
  header('Location: ../index.php');
}
$usuario = $_SESSION['login'];
//$resultado = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='" . $usuario . "'") or die($conexion->error);
if (!($usuario['id_rol'] == 1 || $usuario['id_rol'] == 5 || $usuario['id_rol'] == 12 || $usuario['id_rol'] == 9)) {
  session_unset();
  session_destroy();
  // echo "<script>window.Location='../index.php';</script>";
  header('Location: ../index.php');
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>INEO Metepec</title>
  <link rel="icon" href="../imagenes/SIF.PNG">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Font Awesome Icons -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- Morris chart -->
  <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
  <!-- jvectormap -->
  <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
  <!-- Daterange picker -->
  <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
  <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<?php 
$resultado = $conexion->query("select paciente.*, dat_ingreso.id_atencion, triage.id_triage
from paciente 
inner join dat_ingreso on paciente.Id_exp=dat_ingreso.Id_exp
inner join triage on dat_ingreso.id_atencion=triage.id_atencion where id_triage=id_triage
") or die($conexion->error);

$usuario = $_SESSION['login'];

    //$rol=$usuario['id_rol'];

?>

  <style>
   .imageni{
       width:200px;
   }
   .laboi{
       width:200px;
   }

.patoi{
    width:200px;
}
  
    .botonimagen {
      background-image: url(../imagenes/admision.png);
      background-repeat: no-repeat;
      height: 100px;
      width: 100px;
      background-position: center;
    }

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
      max-width: 15000px;
      height: auto;
      display: flex;
      overflow-y: scroll;
      column-gap: 0.5em;
      column-rule: 1px solid white;
      column-width: 140px;
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

     @media screen and (max-width: 980px){
       
    .ges{
        width:200px;
       margin-left:-50px;   
    }
    .ge{
        width:80px;
        height: auto;
     
    }
     .pac{
        font-size: 9px;
       margin-left:-10px;    
    }
    /*censo*/
     .censo{
        width:200px;
        margin-top: -85.6px;
       margin-left:63px;   
    }
    .cen{
        width:70px;
        height: auto;
     
    }
     .so{
        font-size: 10px;
       margin-left:-1px;    
    }
/*serv aux*/
     .serv{
        width:200px;
        margin-top: -86px;
       margin-left:180px;   
    }
    .ser{
        width:70px;
        height: auto;
     
    }
     .se{
        font-size: 9px;
       margin-left:-2px;    
    }

/*config*/
     .conf{
        width:200px;
        margin-top: -150px;
       margin-left:-43px;   
    }
    .con{
        width: 90px;
        height: 60px;
     
    }
     .co{
        font-size: 9px;
       margin-left:-2px;    
    }

/*Cuentas*/
     .cuen{
        width:200px;
        margin-top: -91px;
       margin-left:77px;   
    }
    .cue{
        width: 80px;
        height: 60px;
     
    }
     .cu{
        font-size: 9.5px;
       margin-left:-2px;    
    }

/*vales*/
     .vales{
        width:200px;
        margin-top: -91px;
       margin-left:198px;   
    }
    .vale{
        width: 80px;
        height: 60px;
     
    }
     .val{
        font-size: 9px;
       margin-left:-2px;    
    }
    
   .imageni{
       width:100px;
   }
   .laboi{
       width:100px;
   }

.patoi{
    width:100px;
}

h4{
     font-size: 9px;
}

.far2{
    width:100px;
    height: 100px;
}

.quir2{
    width:100px;
      height: 100px;
}



}



  </style>

  <!-- Estilos modernos para el menú administrativo -->
  <style>
    /* Estilos modernos para el menú administrativo */
    .content {
      padding: 20px;
    }

    .container {
      max-width: 1200px;
    }

    .card {
      transition: all 0.3s ease !important;
      border: none !important;
      overflow: hidden;
      border-radius: 15px !important;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
      background: white;
      height: 100%;
    }

    .card:hover {
      transform: translateY(-10px) !important;
      box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
    }

    .card a {
      text-decoration: none !important;
    }

    .card .fa {
      transition: all 0.3s ease;
    }

    .card:hover .fa {
      transform: scale(1.1);
    }

    .card:hover div[style*="background"] {
      transform: scale(1.05);
    }

    /* Responsividad mejorada */
    @media (max-width: 768px) {
      .col-sm-4 {
        margin-bottom: 20px;
      }
      
      .card div[style*="background"] {
        width: 80px !important;
        height: 80px !important;
      }
      
      .card .fa {
        font-size: 30px !important;
      }
      
      .card h4, .card h5 {
        font-size: 16px !important;
      }
    }

    /* Estilos adicionales para modales */
    .modal-xl {
      max-width: 1200px;
    }

    .modal-content {
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .modal-header {
      border: none !important;
    }

    .modal-footer {
      border: none !important;
    }

    /* Efectos específicos para iconos de servicios auxiliares */
    .card[style*="linear-gradient"] div[style*="background"] {
      transition: all 0.3s ease;
    }

    .card[style*="linear-gradient"]:hover div[style*="background"] {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 12px 25px rgba(0,0,0,0.15) !important;
    }

    /* Animación pulso para iconos */
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    .card:hover .fa {
      animation: pulse 1s infinite;
    }
  </style>
  </style>
</head>

<body class=" hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <!-- <img src="dist/img/logo.jpg" alt="logo">-->

      <?php
      if ($usuario['id_rol'] == 1) {
      ?>

        <a href="menu_administrativo.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SI</b>MA</span>
          <!-- logo for regular state and mobile devices -->
<?php
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_simg=$f['id_simg'];
?>
            <center><span class="fondo"><img src="../configuracion/admin/img/<?php echo $f['img_base']?>" alt="imgsistema" class="img-fluid" width="112"></span></center>
          <?php
}
?>
        </a>
      <?php
      } else if ($usuario['id_rol'] == 5) {

      ?>
        <a href="menu_gerencia.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SI</b>MA</span>
          <!-- logo for regular state and mobile devices -->
         <?php
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_simg=$f['id_simg'];
?>
            <center><span class="fondo"><img src="../configuracion/admin/img/<?php echo $f['img_base']?>" alt="imgsistema" class="img-fluid" width="112"></span></center>
          <?php
}
?>
        </a>
      <?php }elseif($usuario['id_rol'] == 12) { ?>
         <a href="menu_residente.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SI</b>MA</span>
          <!-- logo for regular state and mobile devices -->
         <?php
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_simg=$f['id_simg'];
?>
            <center><span class="fondo"><img src="../configuracion/admin/img/<?php echo $f['img_base']?>" alt="imgsistema" class="img-fluid" width="112"></span></center>
          <?php
}
?>
        </a>
      <?php }elseif($usuario['id_rol'] == 9) { ?>
         <a href="menu_imagenologia.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SI</b>MA</span>
          <!-- logo for regular state and mobile devices -->
         <?php
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_simg=$f['id_simg'];
?>
            <center><span class="fondo"><img src="../configuracion/admin/img/<?php echo $f['img_base']?>" alt="imgsistema" class="img-fluid" width="112"></span></center>
          <?php
}
?>
        </a>
      <?php
      } else
        //session_unset();
        session_destroy();
      echo "<script>window.Location='../index.php';</script>";
      ?>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>


        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="user-image" alt="User Image">
                <span class="hidden-xs">  <?php echo $usuario['papell']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">

                  <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="img-circle" alt="User Image">

                  <p>
                   <?php echo $usuario['papell']; ?>

                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="../gestion_administrativa/editar_perfil/editar_perfil.php?id_usua=<?php echo $usuario['id_usua'];?>" class="btn btn-default btn-flat">MIS DATOS</a>
                  </div>
                  <div class="pull-right">
                    <a href="../cerrar_sesion.php" class="btn btn-default btn-flat">CERRAR SESIÓN</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="../imagenes/<?php echo $usuario['img_perfil']; ?>" class="img-circle" alt="User Image" />
          </div>
          <div class="pull-left info">
            <p> <?php echo $usuario['papell']; ?></p>

            <a href="#"><i class="fa fa-circle text-success"></i> ACTIVO</a>
          </div>
        </div>


        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
           
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-user-friends"></i> <span>ADMINISTRATIVO</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="../gestion_administrativa/gestion_pacientes/registro_pac.php"><i class="fa fa-user-plus"></i> 
              GESTIÓN DE PACIENTES</a></li>
              <li><a href="../gestion_administrativa/censo/tabla_censo.php"><i class="fa fa-list-alt" aria-hidden="true"></i> 
              CENSO</a></li>
             
            </ul>
          </li>

         <!-- <li class="treeview">
              <li><a href="../gestion_administrativa/cuenta_paciente/vista_df.php"><i class="fa fa-donate"></i> CUENTAS</a></li>
          </li>-->
          
          <li class="treeview">
            <a href="#">
              <i class="fa fa-donate"></i> <span>GESTIÓN DE CUENTAS</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="../gestion_administrativa/cuenta_paciente/vista_df.php"><i class="fa fa-donate"></i> CUENTA DE PACIENTES</a></li>
            <!--  <li><a href="../gestion_administrativa/pago_servicios/pago_servicios.php"><i class="fa fa-usd" aria-hidden="true"></i> PAGO DE SERVICIOS</a></li>-->
              <li><a href="../gestion_administrativa/presupuesto/presupuesto.php"><i class="fa fa-file-invoice-dollar"></i> PRESUPUESTOS</a></li>
              <li><a href="../gestion_administrativa/cuenta_paciente/corte_caja.php"><i class="fa fa-file-invoice-dollar"></i> CORTE DE CAJA</a></li>
            </ul>
            
          </li>
        </ul>


      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <!--AQUI VA QUE PUESTO TIENE-->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: #2b2d7f; border: none; border-radius: 0; padding: 15px 25px; margin-bottom: 30px;">
          <li class="breadcrumb-item active" aria-current="page"><STRONG>
              <h4 style="color: white; margin: 0; font-weight: 600;">ADMINISTRATIVO</h4>
            </STRONG></li>
        </ol>
      </nav>

   
            <div class="content box">
              <!-- CONTENIDO -->

<div class="container">
  <div class="row">
    <!-- GESTIÓN DE PACIENTES -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
      <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #E8F4FD 0%, #E1F5FE 100%); transition: all 0.3s ease;">
        <div class="card-body d-flex flex-column justify-content-center">
          <div style="margin-bottom: 20px;">
            <a href="../gestion_administrativa/gestion_pacientes/registro_pac.php" title="Gestión de Pacientes" style="text-decoration: none;">
              <div style="background: #B3E5FC; width: 120px; height: 120px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                <i class="fa fa-users" style="font-size: 48px; color: #0277BD;"></i>
              </div>
              <h4 style="color: #0277BD; font-weight: 600; margin: 0;">GESTIÓN DE PACIENTES</h4>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- GESTIÓN DE CUENTAS -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
      <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #F3E5F5 0%, #FCE4EC 100%); transition: all 0.3s ease;">
        <div class="card-body d-flex flex-column justify-content-center">
          <div style="margin-bottom: 20px;">
            <a href="#" data-toggle="modal" data-target="#exampleModal" title="Cuentas" style="text-decoration: none;">
              <div style="background: #F8BBD9; width: 120px; height: 120px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                <i class="fa fa-calculator" style="font-size: 48px; color: #C2185B;"></i>
              </div>
              <h4 style="color: #C2185B; font-weight: 600; margin: 0;">GESTIÓN DE CUENTAS</h4>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- CENSO -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
      <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #E8F5E8 0%, #F1F8E9 100%); transition: all 0.3s ease;">
        <div class="card-body d-flex flex-column justify-content-center">
          <div style="margin-bottom: 20px;">
            <a href="../gestion_administrativa/censo/tabla_censo.php" title="Censo" style="text-decoration: none;">
              <div style="background: #C8E6C9; width: 120px; height: 120px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                <i class="fa fa-bed" style="font-size: 48px; color: #388E3C;"></i>
              </div>
              <h4 style="color: #388E3C; font-weight: 600; margin: 0;">CENSO</h4>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>



<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title" style="color: white; font-weight: 600;">
                        <i class="fa fa-hospital-o"></i> Servicios Auxiliares
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div class="row">
                        <!-- FARMACIA -->
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #E8F5E8 0%, #F1F8E9 100%); transition: all 0.3s ease;">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <div style="margin-bottom: 20px;">
                                        <a href="../template/menu_farmacia.php" title="Farmacia" style="text-decoration: none;">
                                            <div style="background: #C8E6C9; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                                                <i class="fa fa-medkit" style="font-size: 40px; color: #388E3C;"></i>
                                            </div>
                                            <h5 style="color: #388E3C; font-weight: 600; margin: 0;">FARMACIA</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CEYE -->
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #E8F4FD 0%, #E1F5FE 100%); transition: all 0.3s ease;">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <div style="margin-bottom: 20px;">
                                        <a href="../template/menu_ceye.php" title="CEYE" style="text-decoration: none;">
                                            <div style="background: #B3E5FC; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                                                <i class="fa fa-shield" style="font-size: 40px; color: #0277BD;"></i>
                                            </div>
                                            <h5 style="color: #0277BD; font-weight: 600; margin: 0;">CEYE</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ALMACÉN CENTRAL -->
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #FFF3E0 0%, #FFECB3 100%); transition: all 0.3s ease;">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <div style="margin-bottom: 20px;">
                                        <a href="../template/menu_almacencentral.php" title="Almacén Central" style="text-decoration: none;">
                                            <div style="background: #FFE0B2; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                                                <i class="fa fa-cubes" style="font-size: 40px; color: #F57C00;"></i>
                                            </div>
                                            <h5 style="color: #F57C00; font-weight: 600; margin: 0;">ALMACÉN CENTRAL</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- IMAGENOLOGÍA -->
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #F3E5F5 0%, #FCE4EC 100%); transition: all 0.3s ease;">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <div style="margin-bottom: 20px;">
                                        <a href="../template/menu_imagenologia.php" title="Imagenología" style="text-decoration: none;">
                                            <div style="background: #F8BBD9; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                                                <i class="fa fa-search" style="font-size: 40px; color: #C2185B;"></i>
                                            </div>
                                            <h5 style="color: #C2185B; font-weight: 600; margin: 0;">IMAGENOLOGÍA</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- LABORATORIO -->
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #F3E5F5 0%, #E8EAF6 100%); transition: all 0.3s ease;">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <div style="margin-bottom: 20px;">
                                        <a href="../template/menu_laboratorio.php" title="Laboratorio" style="text-decoration: none;">
                                            <div style="background: #D1C4E9; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                                                <i class="fa fa-flask" style="font-size: 40px; color: #7B1FA2;"></i>
                                            </div>
                                            <h5 style="color: #7B1FA2; font-weight: 600; margin: 0;">LABORATORIO</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border: none; padding: 20px;">
                    <button type="button" class="btn" data-dismiss="modal" style="background: #6c757d; color: white; border-radius: 25px; padding: 8px 25px;">
                        <i class="fa fa-times"></i> CERRAR
                    </button>
                </div>
            </div>
        </div>
    </div>
          </section><!-- /.content -->


        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
      <?php
      include("footer.php");
      ?>
    </footer>

  </div><!-- ./wrapper -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="border-radius: 15px; border: none;">
        <div class="modal-header" style="background: linear-gradient(135deg, #C2185B 0%, #E91E63 100%); border-radius: 15px 15px 0 0;">
          <h5 class="modal-title" style="color: white; font-weight: 600;">
            <i class="fa fa-calculator"></i> Gestión de Cuentas
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 30px;">
          <div class="row">
            <!-- CUENTA DE PACIENTES -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
              <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #E8F4FD 0%, #E1F5FE 100%); transition: all 0.3s ease;">
                <div class="card-body d-flex flex-column justify-content-center">
                  <div style="margin-bottom: 20px;">
                    <a href="../gestion_administrativa/cuenta_paciente/vista_df.php" title="Cuenta del Paciente" style="text-decoration: none;">
                      <div style="background: #B3E5FC; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <i class="fa fa-file-text" style="font-size: 40px; color: #0277BD;"></i>
                      </div>
                      <h5 style="color: #0277BD; font-weight: 600; margin: 0;">CUENTA DE PACIENTES</h5>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- PRESUPUESTOS -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
              <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #FFF3E0 0%, #FFECB3 100%); transition: all 0.3s ease;">
                <div class="card-body d-flex flex-column justify-content-center">
                  <div style="margin-bottom: 20px;">
                    <a href="../gestion_administrativa/presupuesto/presupuesto.php" title="Presupuestos" style="text-decoration: none;">
                      <div style="background: #FFE0B2; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <i class="fa fa-money" style="font-size: 40px; color: #F57C00;"></i>
                      </div>
                      <h5 style="color: #F57C00; font-weight: 600; margin: 0;">PRESUPUESTOS</h5>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- CORTE DE CAJA -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
              <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #E8F5E8 0%, #F1F8E9 100%); transition: all 0.3s ease;">
                <div class="card-body d-flex flex-column justify-content-center">
                  <div style="margin-bottom: 20px;">
                    <a href="../gestion_administrativa/cuenta_paciente/corte_caja.php" title="Corte de caja" style="text-decoration: none;">
                      <div style="background: #C8E6C9; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <i class="fa fa-cash-register" style="font-size: 40px; color: #388E3C;"></i>
                      </div>
                      <h5 style="color: #388E3C; font-weight: 600; margin: 0;">CORTE DE CAJA</h5>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border: none; padding: 20px;">
          <button type="button" class="btn" data-dismiss="modal" style="background: #6c757d; color: white; border-radius: 25px; padding: 8px 25px;">
            <i class="fa fa-times"></i> CERRAR
          </button>
        </div>
      </div>
    </div>
  </div>

<!-- ./wrapper2 -->

<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title" style="color: white; font-weight: 600;">
                    <i class="fa fa-money"></i> Cuentas y Servicios Pagados
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="row">
                    <!-- CUENTAS PAGADAS -->
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                        <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #E8F5E8 0%, #F1F8E9 100%); transition: all 0.3s ease;">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <div style="margin-bottom: 20px;">
                                    <a href="../gestion_administrativa/cuenta_paciente/valida_cta.php" title="Cuentas Pagadas" style="text-decoration: none;">
                                        <div style="background: #C8E6C9; width: 120px; height: 120px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                                            <i class="fa fa-check-circle" style="font-size: 50px; color: #388E3C;"></i>
                                        </div>
                                        <h4 style="color: #388E3C; font-weight: 600; margin: 0;">CUENTAS PAGADAS</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SERVICIOS PAGADOS -->
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                        <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #E8F4FD 0%, #E1F5FE 100%); transition: all 0.3s ease;">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <div style="margin-bottom: 20px;">
                                    <a href="../gestion_administrativa/cuenta_paciente/valida_cta_serv.php" title="Servicios Pagados" style="text-decoration: none;">
                                        <div style="background: #B3E5FC; width: 120px; height: 120px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                                            <i class="fa fa-credit-card" style="font-size: 50px; color: #0277BD;"></i>
                                        </div>
                                        <h4 style="color: #0277BD; font-weight: 600; margin: 0;">SERVICIOS PAGADOS</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border: none; padding: 20px;">
                <button type="button" class="btn" data-dismiss="modal" style="background: #6c757d; color: white; border-radius: 25px; padding: 8px 25px;">
                    <i class="fa fa-times"></i> CERRAR
                </button>
            </div>
        </div>
    </div>
</div>

  <!-- ./wrapper2 -->

<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title" style="color: white; font-weight: 600;">
                    <i class="fa fa-truck"></i> Servicios de Salida
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="row">
                    <!-- FARMACIA -->
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                        <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #E8F5E8 0%, #F1F8E9 100%); transition: all 0.3s ease;">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <div style="margin-bottom: 20px;">
                                    <a href="../sauxiliares/Farmacia/salidas.php" title="Farmacia" style="text-decoration: none;">
                                        <div style="background: #C8E6C9; width: 120px; height: 120px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                                            <i class="fa fa-shopping-cart" style="font-size: 50px; color: #388E3C;"></i>
                                        </div>
                                        <h4 style="color: #388E3C; font-weight: 600; margin: 0;">FARMACIA</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- QUIRÓFANO -->
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                        <div class="card text-center h-100 shadow-sm" style="border: none; border-radius: 15px; background: linear-gradient(135deg, #E8F4FD 0%, #E1F5FE 100%); transition: all 0.3s ease;">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <div style="margin-bottom: 20px;">
                                    <a href="../sauxiliares/Ceye/salidas.php" title="Quirófano" style="text-decoration: none;">
                                        <div style="background: #B3E5FC; width: 120px; height: 120px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                                            <i class="fa fa-heartbeat" style="font-size: 50px; color: #0277BD;"></i>
                                        </div>
                                        <h4 style="color: #0277BD; font-weight: 600; margin: 0;">QUIRÓFANO</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border: none; padding: 20px;">
                <button type="button" class="btn" data-dismiss="modal" style="background: #6c757d; color: white; border-radius: 25px; padding: 8px 25px;">
                    <i class="fa fa-times"></i> CERRAR
                </button>
            </div>
        </div>
    </div>
</div>

  <!-- jQuery 2.1.3 -->
  <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- FastClick -->
  <script src='plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="dist/js/app.min.js" type="text/javascript"></script>
  <!-- Sparkline -->
  <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
  <!-- jvectormap -->
  <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
  <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
  <!-- daterangepicker -->
  <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
  <!-- datepicker -->
  <script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
  <!-- SlimScroll 1.3.0 -->
  <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <!-- ChartJS 1.0.1 -->
  <script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard2.js" type="text/javascript"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js" type="text/javascript"></script>


</body>

</html>