<?php  
session_start();
include "../../conexionbd.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];

            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];





$not_recu =  mysqli_real_escape_string($conexion, (strip_tags($_POST["not_recu"], ENT_QUOTES)));

$imagen =  mysqli_real_escape_string($conexion, (strip_tags($_POST["imagen"], ENT_QUOTES)));
$incidentes =  mysqli_real_escape_string($conexion, (strip_tags($_POST["incidentes"], ENT_QUOTES)));
$piezas =  mysqli_real_escape_string($conexion, (strip_tags($_POST["piezas"], ENT_QUOTES)));

//$ter_cir =  mysqli_real_escape_string($conexion, (strip_tags($_POST["ter_cir"], ENT_QUOTES)));
if(isset($_POST['ter_cir'])){$ter_cir=$_POST['ter_cir'];}else{ $ter_cir='';}


//if(isset($_POST['glice'])){$glice=$_POST['glice'];}else{ $glice=0;}
if(isset($_POST['viapar'])){$viapar=$_POST['viapar'];}else{ $viapar=0;}
if(isset($_POST['hemod'])){$hemod=$_POST['hemod'];}else{ $hemod=0;}
if(isset($_POST['egotro'])){$egotro=$_POST['egotro'];}else{ $egotro=0;}


if(isset($_POST['diu'])){$diu=$_POST['diu'];}else{ $diu=0;}
if(isset($_POST['eva'])){$eva=$_POST['eva'];}else{ $eva=0;}
if(isset($_POST['sang'])){$sang=$_POST['sang'];}else{ $sang=0;}
if(isset($_POST['vom'])){$vom=$_POST['vom'];}else{ $vom=0;}
if(isset($_POST['aspboc'])){$aspboc=$_POST['aspboc'];}else{ $aspboc=0;}
if(isset($_POST['gast'])){$gast=$_POST['gast'];}else{ $gast=0;}
if(isset($_POST['dren'])){$dren=$_POST['dren'];}else{ $dren=0;}
if(isset($_POST['otros'])){$otros=$_POST['otros'];}else{$otros=0;}
$egpar_t=$diu+$eva+$sang+$vom+$aspboc+$gast+$dren+$otros;

$inicio_cir =  mysqli_real_escape_string($conexion, (strip_tags($_POST["inicio_cir"], ENT_QUOTES)));
//$asepsia =  mysqli_real_escape_string($conexion, (strip_tags($_POST["asepsia"], ENT_QUOTES)));
if(isset($_POST['cirujano'])){$cirujano=$_POST['cirujano'];}else{$cirujano='';}
if(isset($_POST['anestesiologo'])){$anestesiologo=$_POST['anestesiologo'];}else{$anestesiologo='';}
if(isset($_POST['instrumentista'])){$instrumentista=$_POST['instrumentista'];}else{$instrumentista='';}
if(isset($_POST['circulante'])){$circulante=$_POST['circulante'];}else{$circulante='';}

if(isset($_POST['circulante2'])){$circulante2=$_POST['circulante2'];}else{$circulante2='';}
if(isset($_POST['circulante3'])){$circulante3=$_POST['circulante3'];}else{$circulante3='';}

if(isset($_POST['trauma'])){$trauma=$_POST['trauma'];}else{$trauma='';}
if(isset($_POST['neuro'])){$neuro=$_POST['neuro'];}else{$neuro='';}
if(isset($_POST['maxi'])){$maxi=$_POST['maxi'];}else{$maxi='';}
if(isset($_POST['gastro'])){$gastro=$_POST['gastro'];}else{$gastro='';}
if(isset($_POST['onco'])){$onco=$_POST['onco'];}else{$onco='';}
if(isset($_POST['gine'])){$gine=$_POST['gine'];}else{$gine='';}
if(isset($_POST['bari'])){$bari=$_POST['bari'];}else{$bari='';}

if(isset($_POST['p_a'])){$p_a=$_POST['p_a'];}else{ $p_a='';}
if(isset($_POST['s_a'])){$s_a=$_POST['s_a'];}else{ $s_a='';}
if(isset($_POST['t_a'])){$t_a=$_POST['t_a'];}else{ $t_a='';}

if(isset($_POST['sala'])){$sala=$_POST['sala'];}else{ $sala='';}

if(isset($_POST['fecha_reporte'])){$fecha_reporte=$_POST['fecha_reporte'];}else{ $fecha_reporte='';}

$fecha_actual = date("Y-m-d H:i:s");
$ingresar2 = mysqli_query($conexion, 'INSERT INTO recu (id_atencion,id_usua,not_recu,text_fecha,viapar,hemod,egotro,diu,eva,sang,vom,aspboc,gast,dren,otros,egpar_t,inicio_cir,imagen,incidentes,piezas,ter_cir,cirujano,anestesiologo,instrumentista,circulante,p_a,s_a,t_a,trauma,neuro,maxi,gastro,onco,gine,bari,sala,circulante2,circulante3,nociru) values (' . $id_atencion . ',' . $id_usua .',"' . $not_recu . '","' . $fecha_reporte . '","' . $viapar . '","' . $hemod . '","' . $egotro . '","' . $diu . '","' . $eva . '","' . $sang . '","' . $vom . '","' . $aspboc . '","' . $gast . '","' . $dren . '","' . $otros . '","' . $egpar_t . '","' . $inicio_cir . '","' . $imagen . '","' . $incidentes . '","' . $piezas . '","' . $ter_cir . '","' . $cirujano . '","' . $anestesiologo . '","' . $instrumentista . '","' . $circulante . '","' . $p_a . '","' . $s_a . '","' . $t_a . '","' . $trauma . '","' . $neuro . '","' . $maxi . '","' . $gastro . '","' . $onco . '","' . $gine . '","' . $bari . '","' . $sala . '","' . $circulante2 . '","' . $circulante3 . '","1") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));



           echo mysqli_query($conexion,$ingresar2);
           
           
    $resultado = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua='$id_usua'") or die($conexion->error);
$usuario = $_SESSION['login'];
while($f = mysqli_fetch_array($resultado)){   
     $id_us=$f['papell'];
}

$fechactr = date("Y-m-d H:i");
$ingresar3 = mysqli_query($conexion, 'INSERT INTO control_enf (nom_enf,id_usua,id_atencion,nota,fecha) values ("' . $id_us . '",' . $id_usua . ' ,' . $id_atencion . ',"Nota transoperatoria","' . $fechactr . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));
echo mysqli_query($conexion,$ingresar3);       
           

          ?>