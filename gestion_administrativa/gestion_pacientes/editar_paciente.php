<?php 
include '../../conexionbd.php';


$Id_exp=$_POST['id'];
$curp = $_POST['curp'];
$nom_pac =$_POST['nom_pac'];
            $papell = $_POST['papell'];
            $sapell = $_POST['sapell'];
            $fecnac = $_POST['fecnac'];
            $edad = $_POST['edad'];
            $sexo = $_POST['sexo'];
            $tip_san = $_POST['tip_san'];
            $loc = $_POST['loc'];
            $dir = $_POST['dir'];
            $ocup = $_POST['ocup'];
            $tel = $_POST['tel'];
            $religion = $_POST['religion'];
            $edociv = $_POST['edociv'];
            $resp = $_POST['resp'];
            $paren = $_POST['paren'];
            $tel_resp = $_POST['tel_resp'];

 
$actualizar = "UPDATE paciente set curp='$curp', papell='$papell', sapell='$sapell', nom_pac='$nom_pac', fecnac='$fecnac', edad='$edad', sexo='$sexo', tip_san='$tip_san', loc='$loc', dir='$dir', ocup='$ocup', tel='$tel', religion='$religion', edociv='$edociv', resp='$resp', paren='$paren', tel_resp='$tel_resp' WHERE Id_exp= '$Id_exp' ";

     // $editar=mysqli_query($conexion,'UPDATE paciente SET curp="'.$curp.'", papell="'.$papell.'", sapell="'.$sapell.'", nom_pac="'.$nom_pac.'", fecnac="'.$fecnac.'", edad="'.$edad.'", sexo="'.$sexo.'", tip_san="'.$tip_san.'", loc="'.$loc.'", dir="'.$dir.'", ocup="'.$ocup.'", tel="'.$tel.'", religion="'.$religion.'", edociv="'.$edociv.'", resp="'.$resp.'", paren="'.$paren.'", tel_resp="'.$tel_resp.'" WHERE Id_exp= "'.$Id_exp.'" ');
$resultado=mysqli_query($conexion,$actualizar);
            header("Location: ./registro_pac.php");

?>
