<?php
session_start();
include "../../conexionbd.php";
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

    <title>Editar Usuario</title>
    
    <style>
        /* =============== ESTILOS MODERNOS PARA EDITAR USUARIO =============== */
        
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

        /* Header de información del usuario */
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

        /* Header principal modernizado */
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

        /* Secciones del formulario */
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

        .section-title {
            color: #2b2d7f;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 25px;
            border-bottom: 3px solid #2b2d7f;
            padding-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Estilos para formularios */
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

        .form-group label i {
            color: #2b2d7f;
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }

        .form-control {
            border: 4px solid #e9ecef;
            border-radius: 10px;
            padding: 15px 18px;
            font-size: 15px;
            font-weight: 500;
            background: white;
            color: #495057;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2b2d7f;
            box-shadow: 0 0 0 0.3rem rgba(43, 45, 127, 0.25);
            transform: translateY(-2px);
        }

        .form-control:hover {
            border-color: #2b2d7f;
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
            font-weight: 600;
        }

        /* Campos de archivo */
        .file-upload-container {
            border: 4px dashed #2b2d7f;
            border-radius: 15px;
            padding: 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            text-align: center;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .file-upload-container:hover {
            border-color: #1a1d5f;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            transform: translateY(-2px);
        }

        .form-control-file {
            width: 100%;
            padding: 10px;
            border: 2px solid #2b2d7f;
            border-radius: 8px;
            background: white;
            font-weight: 600;
        }

        /* Botones modernizados */
        .btn-container {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
        }

        .btn-success-custom {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }

        .btn-success-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(40, 167, 69, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-danger-custom {
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
            margin: 10px;
        }

        .btn-danger-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(220, 53, 69, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Mensajes de alerta */
        .alert {
            border-radius: 15px;
            padding: 20px;
            font-weight: 600;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
            
            .btn-success-custom, .btn-danger-custom {
                display: block;
                margin: 10px auto;
                width: 80%;
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
    <form action="" method="POST" enctype="multipart/form-data"> 
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
                    <p><i class="fas fa-user-circle" style="color: #2b2d7f; margin-right: 10px;"></i><strong>Usuario:</strong> <?php echo $f[2];?></p>
                </div>
                <div class="col-md-6">
                    <p><i class="fas fa-id-card" style="color: #2b2d7f; margin-right: 10px;"></i><strong>Nombre completo:</strong> <?php echo $f[3];?></p>
                    <p><i class="fas fa-calendar-alt" style="color: #2b2d7f; margin-right: 10px;"></i><strong>Fecha de nacimiento:</strong> <?php  $date = date_create($f[5]); echo date_format($date,"d/m/Y");?></p>
                </div>
            </div>
        </div>

        <!-- Header principal -->
        <div class="thead">
            <i class="fas fa-user-edit"></i> EDITAR USUARIO
        </div>
        <!-- Sección: Datos Personales -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-user"></i> Datos Personales
            </h5>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><i class="fas fa-id-card"></i> CURP:</label>
                        <input type="text" name="curp_u" class="form-control" value="<?php echo $f[1];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-user-tag"></i> Primer Apellido:</label>
                        <input type="text" name="papell" class="form-control" value="<?php echo $f[3];?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-user-tag"></i> Segundo Apellido:</label>
                        <input type="text" name="sapell" class="form-control" value="<?php echo $f[4];?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-signature"></i> Nombre:</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo $f[2];?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Fecha de nacimiento:</label>
                        <input type="date" name="fecnac" value="<?php echo $f[5];?>" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Teléfono:</label>
                        <input type="text" name="tel" class="form-control" value="<?php echo $f[9];?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> E-mail:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $f[10];?>">
                    </div>
                </div>
            </div>
        </div>
        <!-- Sección: Datos Profesionales -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-briefcase"></i> Datos Profesionales
            </h5>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-certificate"></i> Cédula profesional:</label>
                        <input type="text" name="cedp" class="form-control" value="<?php echo $f[7];?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-stethoscope"></i> Función:</label>
                        <input type="text" name="cargp" class="form-control" value="<?php echo $f[8];?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-user-md"></i> Prefijo:</label>
                        <input type="text" name="pre" class="form-control" value="<?php echo $f[11];?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Datos del Sistema -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-cogs"></i> Datos del Sistema
            </h5>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-user-circle"></i> Usuario:</label>
                        <input type="text" name="usu" class="form-control" value="<?php echo $f[18];?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Contraseña:</label>
                        <input type="password" name="pass" class="form-control" value="<?php echo $f[12];?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><i class="fas fa-user-shield"></i> Rol de acceso:</label>
                        <?php 
                        $usuario=$_SESSION['login'];
                        $rol=$usuario['id_rol'];
                        if($rol == 1 ){
                            $resultado1 = $conexion ->query("SELECT * FROM rol where id_rol!=5")or die($conexion->error); ?>
                            <select name="id_rol" class="form-control" required>
                                <option value="<?php echo $f[13];?>"><?php echo $f[13];?></option>
                                <option value="">Seleccionar</option>
                                <?php foreach ($resultado1 as $opciones):?>
                                    <option value="<?php echo $opciones['id_rol']?>"><?php echo $opciones['rol']?></option>
                                <?php endforeach?>
                            </select>
                        <?php }elseif($rol == 5){
                            $resultado1 = $conexion ->query("SELECT * FROM rol")or die($conexion->error); ?>
                            <select name="id_rol" class="form-control" required>
                                <option value="<?php echo $f[13];?>"><?php echo $f[13];?></option>
                                <option value="">Seleccionar</option>
                                <?php foreach ($resultado1 as $opciones):?>
                                    <option value="<?php echo $opciones['id_rol']?>"><?php echo $opciones['rol']?></option>
                                <?php endforeach?>
                            </select>
                        <?php }elseif($rol == 12){
                            $resultado1 = $conexion ->query("SELECT * FROM rol where id_rol=2 or id_rol=3 or id_rol=12")or die($conexion->error); ?>
                            <select name="id_rol" class="form-control" required>
                                <option value="<?php echo $f[13];?>"><?php echo $f[13];?></option>
                                <option value="">Seleccionar</option>
                                <?php foreach ($resultado1 as $opciones):?>
                                    <option value="<?php echo $opciones['id_rol']?>"><?php echo $opciones['rol']?></option>
                                <?php endforeach?>
                            </select>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Archivos -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-file-upload"></i> Archivos
            </h5>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-image"></i> Imagen del perfil:</label>
                        <div class="file-upload-container">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 24px; color: #2b2d7f; margin-bottom: 10px;"></i>
                            <p style="color: #2b2d7f; font-weight: 600; margin-bottom: 10px;">Seleccionar nueva imagen del perfil</p>
                            <input type="file" class="form-control-file" id="img_perfil" name="img_perfil">
                            <small style="color: #6c757d;">Formatos: JPG, PNG, JPEG (Max: 2MB)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-signature"></i> Firma digitalizada:</label>
                        <div class="file-upload-container">
                            <i class="fas fa-pen-fancy" style="font-size: 24px; color: #2b2d7f; margin-bottom: 10px;"></i>
                            <p style="color: #2b2d7f; font-weight: 600; margin-bottom: 10px;">Seleccionar nueva firma digitalizada</p>
                            <input type="file" class="form-control-file" id="firma" name="firma">
                            <small style="color: #6c757d;">Formatos: JPG, PNG, JPEG (Max: 1MB)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="btn-container">
            <button type="submit" name="guardar" class="btn-success-custom">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <a href="alta_usuarios.php" class="btn-danger-custom">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>

    </form>
</div>
<?php
if (isset($_POST['guardar'])) {
    $curp_u    = mysqli_real_escape_string($conexion, (strip_tags($_POST["curp_u"], ENT_QUOTES)));
    $nombre    = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $papell    = mysqli_real_escape_string($conexion, (strip_tags($_POST["papell"], ENT_QUOTES)));
    $sapell   = mysqli_real_escape_string($conexion, (strip_tags($_POST["sapell"], ENT_QUOTES)));
    $fecnac    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecnac"], ENT_QUOTES)));
    $cedp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cedp"], ENT_QUOTES)));
    $cargp   = mysqli_real_escape_string($conexion, (strip_tags($_POST["cargp"], ENT_QUOTES)));
    $tel    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel"], ENT_QUOTES)));
    $email    = mysqli_real_escape_string($conexion, (strip_tags($_POST["email"], ENT_QUOTES)));
    $pre    = mysqli_real_escape_string($conexion, (strip_tags($_POST["pre"], ENT_QUOTES)));
    $usu    = mysqli_real_escape_string($conexion, (strip_tags($_POST["usu"], ENT_QUOTES)));
    $pass    = mysqli_real_escape_string($conexion, (strip_tags($_POST["pass"], ENT_QUOTES)));
    $id_rol    = mysqli_real_escape_string($conexion, (strip_tags($_POST["id_rol"], ENT_QUOTES)));

    //imagen1 EDITAR
    if($_FILES['img_perfil']['name']!=''){
        $nombr = $_FILES['img_perfil']['name'];
        $carpeta="../../imagenes/";
        $temp=explode('.' ,$nombr);
        $extension= end($temp);
        $img=time().'.'.$extension;

        if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
            if(move_uploaded_file($_FILES['img_perfil']['tmp_name'], $carpeta.$img)){
                $fila= $conexion->query('select img_perfil from reg_usuarios where id_usua='.$_GET['id_usua']);
                $id=mysqli_fetch_row($fila);
                if(file_exists('../../imagenes/'.$id[0])){
                    unlink('../../imagenes/'.$id[0]);
                }
                $conexion->query("update reg_usuarios set img_perfil='".$img."' where id_usua=".$_GET['id_usua']);
            }
        }
    }

    //firma EDITAR
    if($_FILES['firma']['name']!=''){
        $nombrf = $_FILES['firma']['name'];
        $carpetaf="../../imgfirma/";
        $tempf=explode('.' ,$nombrf);
        $extensionf= end($tempf);
        $imgf=time().'.'.$extensionf;

        if($extensionf=='jpg' || $extensionf=='png' || $extensionf=='jpeg'){
            if(move_uploaded_file($_FILES['firma']['tmp_name'], $carpetaf.$imgf)){
                $filaf= $conexion->query('select firma from reg_usuarios where id_usua='.$_GET['id_usua']);
                $id=mysqli_fetch_row($filaf);
                if(file_exists('../../imgfirma/'.$id[0])){
                    unlink('../../imgfirma/'.$id[0]);
                }
                $conexion->query("update reg_usuarios set firma='".$imgf."' where id_usua=".$_GET['id_usua']);
            }
        }
    }

    $sql2 = "UPDATE reg_usuarios SET curp_u='$curp_u' , nombre='$nombre', papell='$papell', sapell='$sapell', fecnac='$fecnac', tel='$tel', email='$email', pre='$pre', usuario='$usu',pass='$pass', id_rol=$id_rol, cedp='$cedp', cargp='$cargp' WHERE id_usua= ".$_GET['id_usua'];
    $result = $conexion->query($sql2);
    echo "<div class='alert alert-success' style='position: fixed; top: 20px; right: 20px; z-index: 9999;'><i class='fas fa-check'></i> Usuario actualizado correctamente</div>";
    echo '<script type="text/javascript">setTimeout(function(){ window.location ="alta_usuarios.php"; }, 2000);</script>';
}
?>

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
    
    // Validación de archivos
    $('#img_perfil, #firma').change(function() {
        var file = this.files[0];
        var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        var maxSize = 2 * 1024 * 1024; // 2MB
        
        if (file) {
            if (!allowedTypes.includes(file.type)) {
                alert('Solo se permiten archivos JPG, JPEG y PNG');
                this.value = '';
                return;
            }
            
            if (file.size > maxSize) {
                alert('El archivo no debe superar los 2MB');
                this.value = '';
                return;
            }
        }
    });
    
    // Efecto para contenedores de archivo
    $('.file-upload-container').hover(function() {
        $(this).addClass('shadow-lg');
    }, function() {
        $(this).removeClass('shadow-lg');
    });
    
    // Confirmación antes de guardar
    $('form').submit(function(e) {
        if (!confirm('¿Está seguro de que desea guardar los cambios?')) {
            e.preventDefault();
        }
    });
});
</script>

</body>
</html>