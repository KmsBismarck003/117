<?php
//se establece una conexion a la base de datos
include '../../conexionbd.php';
//si se han enviado datos
$id_usua = $_GET['id_usua'];

$nombre_rec=$_POST['nombre_rec'];
$papell_rec=$_POST['papell_rec'];
$sapell_rec=$_POST['sapell_rec'];



$fecnac_rec=$_POST['fecnac_rec'];
$sexo_rec=$_POST['sexo_rec'];
$alergia_rec=$_POST['alergia_rec'];

$p_sistolica = ($_POST['p_sistolica']);
    $p_diastolica = ($_POST['p_diastolica']);
    $f_card = ($_POST['f_card']);
    $f_resp = ($_POST['f_resp']);
    $temp = ($_POST['temp']);
    $sat_oxigeno = ($_POST['sat_oxigeno']);
    $peso = ($_POST['peso']);
    $talla = ($_POST['talla']);

$esp=$_POST['esp'];

if (isset($_POST['detesp'])) {
  $detesp=$_POST['detesp'];
}else{
  $detesp=' ';
}

if (isset($_POST['med_cont'])) {
  $med_cont=$_POST['med_cont'];
}else{
  $med_cont=' ';
}


$receta_rec=$_POST['receta_rec'];

/*$problema=$_POST['problema'];*/
$subjetivo=$_POST['subjetivo'];
$objetivo=$_POST['objetivo'];
$analisis=$_POST['analisis'];
$plan=$_POST['plan'];
$px=$_POST['px'];

$med_rec=$_POST['med_rec'];
/*$reg_ssa_rec=$_POST['reg_ssa_rec'];*/
$aseg=$_POST['aseg'];


$fec_pcita=$_POST['fec_pcita'];
$hor_pcita=$_POST['hor_pcita'];

function calculaedad($fechanacimiento)
{
  list($ano, $mes, $dia) = explode("-", $fechanacimiento);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($ano_diferencia > 0 )
      return ($ano_diferencia . ' AÑOS');
  else if ($mes_diferencia > 0 || $ano_diferencia < 0)
      return ($mes_diferencia . ' MESES');
   else if ($dia_diferencia > 0 || $mes_diferencia < 0 || $ano_diferencia < 0)
      return ($dia_diferencia . ' DÍAS');
}

            $edad = calculaedad($fecnac_rec);


$fecha_actual = date("Y-m-d H:i:s");

$insert=mysqli_query($conexion,'INSERT INTO receta_ambulatoria (id_usua,fecha,nombre_rec,papell_rec,sapell_rec,fecnac_rec,edad,sexo_rec,especialidad,detesp,alerg_rec,receta_rec,med_rec,aseguradora,fec_pcita,hor_pcita,subjetivo,objetivo,analisis,plan,px,p_sistolica,p_diastolica,f_card,f_resp,temp,sat_oxigeno,peso,talla,med_cont) VALUES ('.$id_usua.',"'.$fecha_actual.'","'.$nombre_rec.'","'.$papell_rec.'","'.$sapell_rec.'","'.$fecnac_rec.'","'.$edad.'","'.$sexo_rec.'","'.$esp.'","'.$detesp.'","'.$alergia_rec.'","'.$receta_rec.'","'.$med_rec.'","'.$aseg.'","'.$fec_pcita.'","'.$hor_pcita.'","'.$subjetivo.'","'.$objetivo.'","'.$analisis.'","'.$plan.'","'.$px.'", ' . $p_sistolica . ' , ' . $p_diastolica . ' , ' . $f_card . ' , ' . $f_resp . ' , ' . $temp . ' , ' . $sat_oxigeno . ' , ' . $peso . ' , ' . $talla . ',"' . $med_cont . '")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

   
$fecha= date("Y-m-d H:i:s");
    $select="SELECT * FROM reg_usuarios where id_usua=$id_usua";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $usuario=$row['nombre'].' '.$row['papell'].' '.$row['sapell'];
    }

$nombre=$nombre_rec.' '.$papell_rec.' '.$sapell_rec;


  $insert="INSERT INTO pserv(nombre,fecha,usuario,tipo) values('$nombre','$fecha','$usuario','RECETA')";
$result_insert=$conexion->query($insert);

    $select="SELECT * FROM receta_ambulatoria order by id_rec_amb DESC LIMIT 1";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $id_amb=$row['id_rec_amb'];
    }

//echo '<script type="text/javascript">window.location.href = "receta_ambulatoria.php";</script>';

echo '<script >window.open("pdf_receta_only.php?id='.$id_amb.'", "RECETA AMBULATORIA", "width=1000, height=1000")</script>'.
 '<script type="text/javascript">window.location.href ="receta_ambulatoria.php" ;</script>';
//header('location: receta_pdf.php?id_amb="'.$id_amb.'"');
