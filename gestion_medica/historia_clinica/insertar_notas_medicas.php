<?php
//se establece una conexion a la base de datos
include '../../conexionbd.php';
//si se han enviado datos
$id_usua = $_GET['id_usua'];
$id_atencion = $_GET['id_atencion'];

if (
    isset($_POST['nu_motivo']) and
    isset($_POST['nu_edom']) and
    isset($_POST['p_sistolica']) and
    isset($_POST['p_diastolica']) and
    isset($_POST['f_card']) and
    isset($_POST['f_resp']) and
    isset($_POST['temp']) and
    isset($_POST['sat_oxigeno']) and
    isset($_POST['peso']) and
    isset($_POST['talla']) and
    isset($_POST['nu_int']) and
    isset($_POST['nu_explora']) and
    isset($_POST['nu_lab']) and
    isset($_POST['nu_gabi']) and
    isset($_POST['nu_res_o']) and
    isset($_POST['id_cie_10']) and
    isset($_POST['nu_indica']) and
    isset($_POST['nu_pro']) and
    isset($_POST['destino'])) {
    //$Id_exp = ($_POST['Id_exp']);
    //  $fec_hc = ($_POST['fec_hc']);
    $nu_motivo = ($_POST['nu_motivo']);
    $nu_edom = ($_POST['nu_edom']);
    $p_sistolica = ($_POST['p_sistolica']);
    $p_diastolica = ($_POST['p_diastolica']);
    $f_card = ($_POST['f_card']);
    $f_resp = ($_POST['f_resp']);
    $temp = ($_POST['temp']);
    $sat_oxigeno= ($_POST['sat_oxigeno']);
    $peso = ($_POST['peso']);
    $talla = ($_POST['talla']);
    $nu_int = ($_POST['nu_int']);
    $nu_explora = ($_POST['nu_explora']);
    $nu_lab = ($_POST['nu_lab']);
    $nu_gabi = ($_POST['nu_gabi']);
    $nu_res_o = ($_POST['nu_res_o']);
    $id_cie_10 = ($_POST['id_cie_10']);
    $nu_indica = ($_POST['nu_indica']);
    $nu_pro = ($_POST['nu_pro']);
    $destino = ($_POST['destino']);
   

$fecha_actual = date("Y-m-d H:i:s");

    $ingresar = mysqli_query($conexion, 'INSERT INTO  dat_nurgen (id_atencion,fecha_nu,nu_motivo,nu_edom,p_sistolica,p_diastolica,f_card,f_resp,temp,sat_oxigeno,peso,talla,nu_int,nu_explora, nu_lab,nu_gabi,nu_res_o,id_cie_10,nu_indica,nu_pro,destino,id_usua) values (' . $id_atencion . ' ,"'.$fecha_actual.'"," ' . $nu_motivo . '" ," ' . $nu_edom . '" , "' . $p_sistolica . '" , "' . $p_diastolica . '" , "' . $f_card . '" , "' . $f_resp . ' ", "' . $temp . ' ", "' . $sat_oxigeno . '" , "' . $peso . '" ," ' . $talla . '", "' . $nu_int . '" , "' . $nu_explora . '" , "' . $nu_lab . '" , "' . $nu_gabi . '" , "' . $nu_res_o . '" , "' . $id_cie_10 . '" , "' . $nu_indica . '" ,"' . $nu_pro . '" , "' . $destino . '" ,' . $id_usua . ') ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

    //redirección
    header('location: dat_nurgen.php');
} //si no se enviaron datos

else {
    header('location: ../../template/menu_medico.php');
}
