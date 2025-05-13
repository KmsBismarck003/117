<?php
session_start();
$id_atencion = $_GET['id_atencion'];
$id_usua = $_GET['usuareg']; // del login

//paciente dat ingreso
$id_usua1 = $_GET['usuapac'];
$id_usua2 = $_GET['usuareg2'];
$id_usua3 = $_GET['usuareg3'];
$id_usua4 = $_GET['usuareg4'];
$id_usua5 = $_GET['usuareg5'];

$_SESSION['hospital'] = $id_atencion;

$usuario = $_SESSION['login'];


//echo '<script>window.location.href = "../../template/menu_enfermera.php?'.$_SESSION['ambiente'].'"</script>';

if($id_usua==$id_usua1 || $id_usua==$id_usua2 || $id_usua==$id_usua3 || $id_usua==$id_usua4 || $id_usua==$id_usua5 || $usuario['id_rol'] == 5 || $usuario['id_rol'] == 12){

echo '<script>window.location.href = "../hospitalizacion/vista_pac_hosp.php"</script>';
}else{

echo'
           
             <center><img src="../../imagenes/wave.png" height="1900"  alt="Sanatorio"></center> 
         
          ';


	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "No tienes acceso a este paciente", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                             window.location.href = "../../template/menu_medico.php";
                            } 
                        });
                    });
                </script>';
          

}