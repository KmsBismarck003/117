<?php
session_start();
include "../../conexionbd.php";
include("../header_gerencia.php");

if( isset($_GET['id_usua'])) { //si existe el id mandado por metodo GET, se hara la consulta donde el id debe ser igual al id mandado por el metodo GET
  $resultado = $conexion ->query("SELECT * FROM reg_usuarios WHERE id_usua=".$_GET['id_usua'])or die($conexion->error);
  if(mysqli_num_rows($resultado) > 0 ){ //se mostrara si existe mas de 1
    $f=mysqli_fetch_row($resultado);

  }else{
    header("location: header_gerencia.php"); //te regresa a la página principal
  }
}else{
  header("location: header_gerencia.php"); //te regresa a la página principal
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

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

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

</head>
<style>
    * {
    box-sizing: border-box;
}

body {
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #0a0a0a 100%) !important;
    font-family: 'Roboto', sans-serif !important;
    min-height: 100vh;
}

/* Efecto de partículas en el fondo */
body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image:
        radial-gradient(circle at 20% 50%, rgba(64, 224, 255, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(64, 224, 255, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 40% 20%, rgba(64, 224, 255, 0.02) 0%, transparent 50%);
    pointer-events: none;
    z-index: 0;
}

.wrapper {
    position: relative;
    z-index: 1;
}

/* Content wrapper */
.content-wrapper {
    background: transparent !important;
    position: relative;
    z-index: 1;
}

/* Container principal del formulario */
.container-fluid {
    background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
    border: 2px solid #40E0FF !important;
    border-radius: 20px !important;
    padding: 30px !important;
    margin: 20px auto !important;
    max-width: 1400px !important;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5),
                0 0 30px rgba(64, 224, 255, 0.2) !important;
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.8s ease-out;
}

.container-fluid::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        45deg,
        transparent,
        rgba(64, 224, 255, 0.05),
        transparent
    );
    transform: rotate(45deg);
    animation: shimmer 3s ease-in-out infinite;
}

@keyframes shimmer {
    0%, 100% { transform: translateX(-100%) rotate(45deg); }
    50% { transform: translateX(100%) rotate(45deg); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Header del título */
.thead {
    background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
    border: 2px solid #40E0FF !important;
    border-radius: 15px !important;
    padding: 20px !important;
    margin: 20px 0 !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    letter-spacing: 2px !important;
    text-transform: uppercase !important;
    box-shadow: 0 8px 25px rgba(64, 224, 255, 0.3),
                inset 0 0 20px rgba(64, 224, 255, 0.1) !important;
    position: relative;
    overflow: hidden;
}

.thead::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(64, 224, 255, 0.1) 0%, transparent 70%);
    animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.thead strong {
    position: relative;
    z-index: 1;
    text-shadow: 0 0 20px rgba(64, 224, 255, 0.5);
}

/* Información del usuario */
.row .col {
    color: #ffffff !important;
    font-size: 1rem;
    line-height: 1.8;
    position: relative;
    z-index: 1;
    padding: 15px;
}

.row .col strong {
    color: #40E0FF !important;
    text-shadow: 0 0 10px rgba(64, 224, 255, 0.5);
}

/* Labels de formulario */
label {
    color: #40E0FF !important;
    font-weight: 600 !important;
    margin-bottom: 8px !important;
    text-shadow: 0 0 10px rgba(64, 224, 255, 0.3);
    letter-spacing: 0.5px;
    text-transform: uppercase;
    font-size: 0.85rem !important;
}

/* Form controls mejorados */
.form-control {
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%) !important;
    border: 2px solid #40E0FF !important;
    border-radius: 10px !important;
    color: #ffffff !important;
    padding: 12px 15px !important;
    font-weight: 500 !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 3px 10px rgba(64, 224, 255, 0.2) !important;
}

.form-control:focus {
    background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
    border-color: #00D9FF !important;
    color: #ffffff !important;
    box-shadow: 0 5px 20px rgba(64, 224, 255, 0.4),
                inset 0 0 15px rgba(64, 224, 255, 0.1) !important;
    outline: none !important;
    transform: translateY(-2px);
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.5) !important;
}

.form-control:disabled {
    background: rgba(64, 224, 255, 0.1) !important;
    border-color: rgba(64, 224, 255, 0.3) !important;
    color: rgba(255, 255, 255, 0.6) !important;
}

/* Input file mejorado */
.form-control-file {
    background: linear-gradient(135deg, #16213e 0%, #0f3460 100%) !important;
    border: 2px solid #40E0FF !important;
    border-radius: 10px !important;
    color: #ffffff !important;
    padding: 10px !important;
    font-weight: 500 !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 3px 10px rgba(64, 224, 255, 0.2) !important;
    cursor: pointer;
}

.form-control-file:hover {
    border-color: #00D9FF !important;
    box-shadow: 0 5px 20px rgba(64, 224, 255, 0.4) !important;
    transform: translateY(-2px);
}

/* Botones mejorados */
.btn {
    border-radius: 25px !important;
    padding: 12px 40px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 1.5px !important;
    transition: all 0.3s ease !important;
    position: relative;
    overflow: hidden;
    margin: 10px !important;
}

.btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn:hover::before {
    width: 300px;
    height: 300px;
}

.btn-success {
    border: 2px solid #00ff88 !important;
    background: linear-gradient(135deg, #0f3a1f 0%, #1a4d2e 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 5px 15px rgba(0, 255, 136, 0.3) !important;
}

.btn-success:hover {
    transform: translateY(-5px) scale(1.05) !important;
    box-shadow: 0 15px 40px rgba(0, 255, 136, 0.5) !important;
    border-color: #00ffaa !important;
    color: #ffffff !important;
}

.btn-danger {
    border: 2px solid #ff4040 !important;
    background: linear-gradient(135deg, #3a0f0f 0%, #4d1a1a 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 5px 15px rgba(255, 64, 64, 0.3) !important;
}

.btn-danger:hover {
    transform: translateY(-5px) scale(1.05) !important;
    box-shadow: 0 15px 40px rgba(255, 64, 64, 0.5) !important;
    border-color: #ff5555 !important;
    color: #ffffff !important;
}

.btn i,
.btn strong {
    position: relative;
    z-index: 1;
}

/* Separador horizontal */
hr {
    border: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, #40E0FF, transparent);
    margin: 30px 0;
    box-shadow: 0 0 10px rgba(64, 224, 255, 0.5);
}

/* Alertas mejoradas */
.alert {
    border-radius: 15px !important;
    border: 2px solid !important;
    font-weight: 600 !important;
    padding: 15px 25px !important;
    margin: 20px 0 !important;
    animation: fadeInDown 0.5s ease-out;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: linear-gradient(135deg, #0f3a1f 0%, #1a4d2e 100%) !important;
    border-color: #00ff88 !important;
    color: white !important;
    box-shadow: 0 5px 20px rgba(0, 255, 136, 0.3);
}

.alert-danger {
    background: linear-gradient(135deg, #3a0f0f 0%, #4d1a1a 100%) !important;
    border-color: #ff4040 !important;
    color: white !important;
    box-shadow: 0 5px 20px rgba(255, 64, 64, 0.3);
}

/* Form groups */
.form-group {
    margin-bottom: 25px !important;
    position: relative;
    z-index: 1;
}

/* Inputs con animación focus */
.form-control:focus + label,
.form-control:not(:placeholder-shown) + label {
    transform: translateY(-25px) scale(0.9);
    color: #00D9FF !important;
}

/* Footer */
.main-footer {
    background: linear-gradient(135deg, #0f3460 0%, #16213e 100%) !important;
    border-top: 2px solid #40E0FF !important;
    color: #ffffff !important;
    box-shadow: 0 -4px 20px rgba(64, 224, 255, 0.2);
    margin-top: 50px;
}

/* Grid responsivo */
.row {
    position: relative;
    z-index: 1;
}

/* Efectos de hover en rows */
.row:hover {
    background: rgba(64, 224, 255, 0.02);
    border-radius: 10px;
    transition: all 0.3s ease;
}

/* Centro de contenido */
center {
    position: relative;
    z-index: 1;
    margin: 30px 0;
}

/* Scrollbar personalizado */
::-webkit-scrollbar {
    width: 12px;
    height: 12px;
}

::-webkit-scrollbar-track {
    background: #0a0a0a;
    border-left: 1px solid #40E0FF;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #40E0FF 0%, #0f3460 100%);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #00D9FF 0%, #40E0FF 100%);
}

/* Responsive */
@media screen and (max-width: 980px) {
    .container-fluid {
        width: 95%;
        margin: 10px auto !important;
        padding: 20px !important;
    }
}

@media screen and (max-width: 768px) {
    .container-fluid {
        padding: 15px !important;
    }

    .thead {
        font-size: 16px !important;
        padding: 15px !important;
    }

    .btn {
        padding: 10px 25px !important;
        font-size: 0.85rem !important;
    }

    label {
        font-size: 0.75rem !important;
    }

    .form-control {
        padding: 10px 12px !important;
    }
}

@media screen and (max-width: 576px) {
    .container-fluid {
        margin: 5px !important;
        padding: 10px !important;
    }

    .btn {
        width: 100%;
        margin: 5px 0 !important;
    }
}

/* Efectos adicionales de glow */
.form-control:focus {
    animation: glow-input 1.5s ease-in-out infinite;
}

@keyframes glow-input {
    0%, 100% {
        box-shadow: 0 3px 10px rgba(64, 224, 255, 0.2);
    }
    50% {
        box-shadow: 0 5px 25px rgba(64, 224, 255, 0.5);
    }
}

/* Animación para los form-groups */
.form-group {
    animation: fadeInUp 0.6s ease-out backwards;
}

.form-group:nth-child(1) { animation-delay: 0.1s; }
.form-group:nth-child(2) { animation-delay: 0.15s; }
.form-group:nth-child(3) { animation-delay: 0.2s; }
.form-group:nth-child(4) { animation-delay: 0.25s; }
.form-group:nth-child(5) { animation-delay: 0.3s; }
.form-group:nth-child(6) { animation-delay: 0.35s; }

/* Mejora visual para strong text */
strong {
    font-weight: 700 !important;
    letter-spacing: 0.5px;
}

/* Estilo para inputs deshabilitados */
input[disabled] {
    cursor: not-allowed !important;
    opacity: 0.7 !important;
}

/* Espaciado mejorado */
.col-sm-4 {
    padding: 0 15px !important;
}
</style>
<body>
<div class="container-fluid">
    <form action="" method="POST" enctype="multipart/form-data">
    <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?php
                        $id_usua= $_GET['id_usua'];
                        ?>
                        <input type="hidden" name="id_usua" placeholder="Expediente" id="id_usua" class="form-control" value="<?php echo $id_usua ?>"
                               disabled>
                    </div>
                </div>
         </div>
         <div class="row">
    <div class="col">
       <i class="fa fa-user"></i> No. USUARIO: <strong><?php echo $f[0];?></strong> <br>
     <i class="fa fa-id-card"></i> NOMBRE DEL USUARIO: <strong><?php echo $f[2];?>
      <?php echo $f[3];?>
      <?php echo $f[4];?></strong><br>

<i class="fa fa-calendar"></i> FECHA DE NACIMIENTO:<strong> <?php  $date = date_create($f[5]);
 echo date_format($date,"d/m/Y");?></strong>

    </div>

  </div> <br>
        <div class="thead">
            <tr><strong><center><i class="fa fa-edit"></i> EDITAR USUARIO</center></strong>
      </div><br>
<div class="container-fluid">
       <div class="row">

             <div class="col-sm-4">
                <div class="form-group">
                    <label><i class="fa fa-id-card-o"></i> CURP:</label><br>
                    <input type="text" name="curp_u" class="form-control" value="<?php echo $f[1];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                    <label><i class="fa fa-user"></i> NOMBRE:</label><br>
                    <input type="text" name="nombre" class="form-control" value="<?php echo $f[2];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                    <label><i class="fa fa-user"></i> PRIMER APELLIDO:</label><br>
                    <input type="text" name="papell" class="form-control" value="<?php echo $f[3];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
       </div>

       <div class="row">
             <div class="col-sm-4">
                <div class="form-group">
                    <label><i class="fa fa-user"></i> SEGUNDO APELLIDO:</label><br>
                    <input type="text" name="sapell" class="form-control" value="<?php echo $f[4];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                        <div class="form-group">
                            <label for="fecnac"><i class="fa fa-calendar"></i> FECHA DE NACIMIENTO:</label>

                          <input type="date" name="fecnac" value="<?php echo $f[5];?>" id="fecnac"
                                   class="form-control" required>
                        </div>
                    </div>


             <div class="col-sm-4">
                <div class="form-group">
                   <label><i class="fa fa-certificate"></i> CÉDULA PROFESIONAL:</label><br>
                    <input type="text" name="cedp" class="form-control" value="<?php echo $f[7];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
       </div>

       <div class="row">
             <div class="col-sm-4">
                <div class="form-group">
                    <label><i class="fa fa-briefcase"></i> FUNCIÓN:</label><br>
                    <input type="text" name="cargp" class="form-control" value="<?php echo $f[8];?>" style="text-transform:uppercase;"onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                    <label><i class="fa fa-phone"></i> TELÉFONO:</label><br>
                    <input type="text" name="tel" class="form-control" value="<?php echo $f[9];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>

             <div class="col-sm-4">
                <div class="form-group">
                    <label><i class="fa fa-envelope"></i> E-MAIL:</label><br>
                    <input type="text" name="email" class="form-control" value="<?php echo $f[10];?>">
                </div>
             </div>
       </div>

       <div class="row">
             <div class="col-sm-4">
                <div class="form-group">
                    <label><i class="fa fa-tag"></i> PREFIJO:</label><br>
                    <input type="text" name="pre" class="form-control" value="<?php echo $f[11];?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                    <label><i class="fa fa-lock"></i> CONTRASEÑA:</label><br>
                    <input type="password" name="pass" class="form-control" value="<?php echo $f[12];?>" >
                </div><br>
             </div>

             <div class="col-sm-4">

             </div>
       </div>

       <div class="row">
              <div class="col-sm-4">
    <label for="img_perfil"><i class="fa fa-image"></i> <strong><font size="2">SELECCIONAR IMAGEN DE PERFIL</font></strong></label>
    <input type="file" class="form-control-file" id="img_perfil" name="img_perfil">
    </div>
<div class="col-sm-4">
    <label for="firma"><i class="fa fa-pencil"></i> <strong><font size="2">SELECCIONAR FIRMA</font></strong></label>
    <input type="file" class="form-control-file" id="firma" name="firma">
    </div>
       </div>
       </div>
<hr>

    <center>
            <button type="submit" name="guardar" class="btn btn-success"><i class="fa fa-save"></i> GUARDAR</button>
            <a href="../../template/menu_gerencia.php" class="btn btn-danger"><i class="fa fa-times"></i> CANCELAR</a>
    </center>

</form>
</div>
<br>

<?php
if (isset($_POST['guardar'])) {

        $curp_u    = mysqli_real_escape_string($conexion, (strip_tags($_POST["curp_u"], ENT_QUOTES))); //Escanpando caracteres
        $nombre    = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES))); //Escanpando caracteres
        $papell    = mysqli_real_escape_string($conexion, (strip_tags($_POST["papell"], ENT_QUOTES))); //Escanpando caracteres
        $sapell   = mysqli_real_escape_string($conexion, (strip_tags($_POST["sapell"], ENT_QUOTES))); //Escanpando caracteres

          $fecnac    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecnac"], ENT_QUOTES)));

          $cedp    = mysqli_real_escape_string($conexion, (strip_tags($_POST["cedp"], ENT_QUOTES)));

          $cargp   = mysqli_real_escape_string($conexion, (strip_tags($_POST["cargp"], ENT_QUOTES)));
           $tel    = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel"], ENT_QUOTES)));
          $email    = mysqli_real_escape_string($conexion, (strip_tags($_POST["email"], ENT_QUOTES)));
          $pre    = mysqli_real_escape_string($conexion, (strip_tags($_POST["pre"], ENT_QUOTES)));
          $pass    = mysqli_real_escape_string($conexion, (strip_tags($_POST["pass"], ENT_QUOTES)));


//imagen1 EDITAR
        if($_FILES['img_perfil']['name']!=''){
    $nombr = $_FILES['img_perfil']['name'];
    $carpeta="../../imagenes/";
//imagen1.jpg
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
            }//llave tipo archivo
        }    //llave si no esta vacio

//firma EDITAR
        if($_FILES['firma']['name']!=''){
    $nombrf = $_FILES['firma']['name'];
    $carpetaf="../../imgfirma/";
//firma.jpg
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
            }//llave tipo archivo
        }    //llave si no esta vacio



        $sql2 = "UPDATE reg_usuarios SET curp_u='$curp_u' , nombre='$nombre', papell='$papell', sapell='$sapell', fecnac='$fecnac', tel='$tel', email='$email', pre='$pre', pass='$pass', cedp='$cedp', cargp='$cargp' WHERE id_usua= ".$_GET['id_usua'];
     // echo $sql2;
      // return 'hbgk';
        $result = $conexion->query($sql2);
        echo "<p class='alert alert-success' id='mensaje'> <i class=' fa fa-check'></i> Dato insertado correctamente...</p>";
        echo '<script type="text/javascript">window.location ="../../template/menu_gerencia.php"</script>';
      }
?>
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
</body>
</html>
