<?php
session_start();
//include "../../conexionbd.php";
include "../../configuracion/header_configuracion.php";

if( isset($_GET['id_usua'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
  $resultado = $conexion ->query("SELECT * FROM reg_usuarios WHERE id_usua=".$_GET['id_usua'])or die($conexion->error);
  if(mysqli_num_rows($resultado) > 0 ){ //se mostrara si existe mas de 1
    $f=mysqli_fetch_row($resultado);

  }else{
    header("location: alta_usuarios.php"); //te regresa a la página principal
  }
}else{
  header("location: alta_usuarios.php"); //te regresa a la página principal
}
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

    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>


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

    <title>Despliega usuario </title>
    
    <style>
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #495057;
        }

        .main-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(43, 45, 127, 0.1);
            margin: 20px;
            padding: 30px;
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Header de datos del usuario modernizado */
        .thead {
            background: linear-gradient(135deg, #2b2d7f 0%, #3b3f8f 100%) !important;
            color: white !important;
            font-size: 24px !important;
            padding: 20px !important;
            border-radius: 15px !important;
            margin-bottom: 30px !important;
            box-shadow: 0 8px 25px rgba(43, 45, 127, 0.3);
            text-align: center;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Información del usuario en la parte superior */
        .user-info-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 3px solid #2b2d7f;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(43, 45, 127, 0.1);
        }

        .user-info-header strong {
            color: #2b2d7f;
            font-weight: 700;
        }

        .user-info-header {
            font-size: 16px;
            line-height: 1.8;
        }

        /* Estilos para formularios */
        .form-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            border-color: #2b2d7f;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(43, 45, 127, 0.15);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            color: #2b2d7f;
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
        }

        .form-control {
            border: 3px solid #e9ecef;
            border-radius: 10px;
            padding: 15px 18px;
            font-size: 15px;
            font-weight: 500;
            background: #f8f9fa;
            color: #495057;
            transition: all 0.3s ease;
        }

        .form-control:disabled {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-color: #2b2d7f;
            color: #2b2d7f;
            font-weight: 600;
        }

        .form-control:focus {
            border-color: #2b2d7f;
            box-shadow: 0 0 0 0.3rem rgba(43, 45, 127, 0.25);
            background: white;
        }

        /* Select especial */
        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232b2d7f' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 45px;
        }

        /* Estilos para imágenes */
        .image-container {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            border: 3px dashed #2b2d7f;
            margin-top: 10px;
        }

        .user-image {
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(43, 45, 127, 0.3);
            border: 4px solid #2b2d7f;
            transition: all 0.3s ease;
        }

        .user-image:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 35px rgba(43, 45, 127, 0.4);
        }

        /* Botón de regresar modernizado */
        .btn-regresar {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 30px 0;
        }

        .btn-regresar:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(220, 53, 69, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-regresar i {
            margin-right: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                margin: 10px;
                padding: 20px;
            }
            
            .thead {
                font-size: 20px !important;
                padding: 15px !important;
            }
            
            .form-control {
                padding: 12px 15px;
            }
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-section {
            animation: slideIn 0.6s ease-in-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>

</head>

<body>
<div class="main-container">
    <form action="" method="POST"> 
        <div class="row">       
            <div class="col-sm-4">
                <div class="form-group">
                    <?php
                    $id_usua= $_GET['id_usua'];
                    ?>
                    <input type="hidden" name="id_usua" placeholder="Expediente" id="id_usua" class="form-control" value="<?php echo $id_usua ?>" disabled>
                </div>
            </div>
        </div> 

        <!-- Información del usuario modernizada -->
        <div class="user-info-header">
            <div class="row">
                <div class="col-md-6">
                    <p><i class="fas fa-hashtag" style="color: #2b2d7f; margin-right: 10px;"></i><strong>No:</strong> <?php echo $f[0];?></p>
                    <p><i class="fas fa-user-circle" style="color: #2b2d7f; margin-right: 10px;"></i><strong>Usuario:</strong> <?php echo $f[18];?></p>
                </div>
                <div class="col-md-6">
                    <p><i class="fas fa-id-card" style="color: #2b2d7f; margin-right: 10px;"></i><strong>Nombre completo:</strong> <?php echo $f[2].' '.$f[3].' '.$f[4];?></p>
                    <p><i class="fas fa-calendar-alt" style="color: #2b2d7f; margin-right: 10px;"></i><strong>Fecha de nacimiento:</strong> <?php  $date = date_create($f[5]); echo date_format($date,"d/m/Y");?></p>
                </div>
            </div>
        </div> 
        <!-- Header de datos del usuario -->
        <div class="thead">
            <i class="fas fa-user-cog"></i> DATOS DEL USUARIO
        </div>

        <!-- Sección: Datos Personales -->
        <div class="form-section">
            <h5 style="color: #2b2d7f; font-weight: 700; margin-bottom: 25px; border-bottom: 3px solid #2b2d7f; padding-bottom: 10px;">
                <i class="fas fa-user"></i> DATOS PERSONALES
            </h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-id-card"></i> CURP:</label>
                        <input type="text" name="curp_u" class="form-control" value="<?php echo $f[1];?>" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Fecha de nacimiento:</label>
                        <input type="text" name="fecnac" class="form-control" value="<?php echo $f[5];?>" disabled>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-user-tag"></i> Primer Apellido:</label>
                        <input type="text" name="papell" class="form-control" value="<?php echo $f[3];?>" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-user-tag"></i> Segundo Apellido:</label>
                        <input type="text" name="sapell" class="form-control" value="<?php echo $f[4];?>" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-signature"></i> Nombre:</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo $f[2];?>" disabled>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Teléfono:</label>
                        <input type="text" name="tel" class="form-control" value="<?php echo $f[9];?>" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> E-mail:</label>
                        <input type="text" name="email" class="form-control" value="<?php echo $f[10];?>" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Datos Profesionales -->
        <div class="form-section">
            <h5 style="color: #2b2d7f; font-weight: 700; margin-bottom: 25px; border-bottom: 3px solid #2b2d7f; padding-bottom: 10px;">
                <i class="fas fa-briefcase"></i> DATOS PROFESIONALES
            </h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-certificate"></i> Cédula profesional:</label>
                        <input type="text" name="cedp" class="form-control" value="<?php echo $f[7];?>" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-stethoscope"></i> Función:</label>
                        <input type="text" name="cargp" class="form-control" value="<?php echo $f[8];?>" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-user-md"></i> Prefijo:</label>
                        <input type="text" name="pre" class="form-control" value="<?php echo $f[11];?>" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Datos del Sistema -->
        <div class="form-section">
            <h5 style="color: #2b2d7f; font-weight: 700; margin-bottom: 25px; border-bottom: 3px solid #2b2d7f; padding-bottom: 10px;">
                <i class="fas fa-cogs"></i> DATOS DEL SISTEMA
            </h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-user-circle"></i> Usuario:</label>
                        <input type="text" name="usuario" class="form-control" value="<?php echo $f[18];?>" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Contraseña:</label>
                        <input type="password" name="pass" class="form-control" value="<?php echo $f[12];?>" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-user-shield"></i> Rol de acceso:</label>
                        <select class="form-control" disabled name="id_rol">
                            <option value="<?php echo $f[13];?>"><?php echo $f[13];?></option>
                            <?php
                            $query = "SELECT * FROM `rol`";
                            $result = $conexion->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id_rol'] . "'>" . $row['rol'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sección: Archivos -->
        <div class="form-section">
            <h5 style="color: #2b2d7f; font-weight: 700; margin-bottom: 25px; border-bottom: 3px solid #2b2d7f; padding-bottom: 10px;">
                <i class="fas fa-images"></i> ARCHIVOS
            </h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-image"></i> Imagen del perfil:</label>
                        <div class="image-container">
                            <img src="../../imagenes/<?php echo $f['15']; ?>" class="user-image" alt="Imagen de Perfil" width="120">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-signature"></i> Firma digitalizada:</label>
                        <div class="image-container">
                            <img src="../../imgfirma/<?php echo $f['16']; ?>" class="user-image" alt="Firma Digital" width="180">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de regresar modernizado -->
        <div class="text-center" style="margin-top: 40px;">
            <a href="alta_usuarios.php" class="btn-regresar">
                <i class="fas fa-arrow-left"></i> Regresar a la Lista
            </a>
        </div>

    </form>
</div>

<footer class="main-footer">
    <?php include("../../template/footer.php"); ?>
</footer>

<script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

<script>
$(document).ready(function() {
    // Animación de entrada para las secciones
    $('.form-section').each(function(index) {
        $(this).delay(200 * index).animate({
            opacity: 1
        }, 600);
    });
    
    // Efecto hover para las imágenes
    $('.user-image').hover(function() {
        $(this).addClass('shadow-lg');
    }, function() {
        $(this).removeClass('shadow-lg');
    });
});
</script>

</body>
</html>