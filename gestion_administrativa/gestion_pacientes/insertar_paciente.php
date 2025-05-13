<?php
//se establece una conexion a la base de datos
include '../../conexionbd.php';

//curp

require 'Curp.php';

 


if (isset($_POST['nom_pac']) || isset($_POST['papell']) || isset($_POST['sapell']) ||
        isset($_POST['fecnac'])|| isset($_POST['sexo']) || isset($_POST['estado'])) {


$fecnac = $_POST['fecnac'];
$originalDate =$fecnac;
$diase = date("d", strtotime($originalDate));

$originalDatemes =$fecnac;
$mes = date("m", strtotime($originalDatemes));

$originalDateanio =$fecnac;
$annio = date("Y", strtotime($originalDateanio));
/*$diasee = date_create($fecnac);
$diase=date_format($diasee, "d");
$mese = date_create($fecnac);
$mes=date_format($mese, "m");
$annioo = date_create($fecnac);
 $annio=date_format($annioo, "Y");*/

    $nombres = $_POST['nom_pac'];
    $apellido1 = $_POST['papell'];
    $apellido2 = $_POST['sapell'];
    $diase;
    $mes;
    $annio;
    $sexo = $_POST['sexo'];
    $edo = $_POST['estado'];
    if ($diase != "" && $mes != "" && $annio != "" && $sexo != "" && $edo != "") {
        $curp = new Curp();
        $stringCURP = $curp->generarCURP($nombres, $apellido1, $apellido2, $diase, $mes, $annio, $sexo, $edo);


        //echo '<script>alertify.alert("CURP GENERADO", "' . $stringCURP . '", function(){ alertify.success("Ok"); });</script>';
        echo '<script>alert("CURP GENERADO: '. $stringCURP .'");</script>';
    } else {
        echo '<script>alert("Llenar todos los campos.");</script>';
    }
} else {
    echo '<script>alert("Llenar todos los campos.");</script>';
}


//curp

//si se han enviado datos
$id_usu=$_GET['id_usu'];

/*if (isset($_POST['curp'])) {
  $curp = ($_POST['curp']);
} else {
  $curp = "";
}*/

if (isset($_POST['l_indigena'])) {
  $l_indigena = ($_POST['l_indigena']);
} else {
  $l_indigena = "";
}


if (
  isset($_POST['papell']) and
  isset($_POST['sapell']) and
  isset($_POST['nom_pac']) and
  isset($_POST['fecnac']) and
  isset($_POST['sexo']) and
  isset($_POST['estado']) and
  isset($_POST['id_edo']) and
  isset($_POST['id_mun']) and
  isset($_POST['loc']) and
  isset($_POST['dir']) and
  /* isset($_POST['tip_san']) and
 isset($_POST['ocup']) and */
  isset($_POST['tel']) and
  isset($_POST['religion']) and
  isset($_POST['edociv']) and
  isset($_POST['resp']) and
  isset($_POST['paren']) and
  isset($_POST['tel_resp']) and
  isset($_POST['motivo_atn']) and
  isset($_POST['alergias']) and
  isset($_POST['tipo_a']) and
 
  isset($_POST['aseg']) and
  isset($_POST['aval']) and
  isset($_POST['banco']) and
  isset($_POST['deposito'])
){

$deposito =$_POST['deposito'];     
//Incluímos la clase pago
$deposito;
require_once "CifrasEnLetras.php";
$v=new CifrasEnLetras(); 
//Convertimos el total en letras
$letra=($v->convertirEurosEnLetras($deposito));
 


            $nom_pac = ($_POST['nom_pac']);
            $papell = ($_POST['papell']);
            $sapell = ($_POST['sapell']);
            $fecnac = ($_POST['fecnac']);    
            $estado = ($_POST['estado']);
            $sexo = ($_POST['sexo']);
            $id_edo = ($_POST['id_edo']);
            $id_mun = ($_POST['id_mun']);
            $loc = ($_POST['loc']);
            $dir = ($_POST['dir']);
       /*   $folio = ($_POST['folio']);
            $ocup = ($_POST['ocup']);
            $tip_san = ($_POST['tip_san']); */
            $tel = ($_POST['tel']);
            $religion = ($_POST['religion']);
            $edociv = ($_POST['edociv']);
            $resp = ($_POST['resp']);
            $paren = ($_POST['paren']);
            $tel_resp = ($_POST['tel_resp']);
            $dom_resp = ($_POST['dom_resp']);
////////////////// admisión
$papell_med = $_POST['papell_med'];
//$nombre = $_POST['nombre'];
     //$pass = $_POST['pass'];
   // $sapell_med = $_POST['sapell_med'];
   //  $nom_med = $_POST['nom_med'];

            $id_usua=($_POST['id_usua']);

if (isset($_POST['id_usua2'])){$id_usua2=$_POST['id_usua2'];}else{$id_usua2=0;}
if (isset($_POST['id_usua3'])){$id_usua3=$_POST['id_usua3'];}else{$id_usua3=0;}
if (isset($_POST['id_usua4'])){$id_usua4=$_POST['id_usua4'];}else{$id_usua4=0;}
if (isset($_POST['id_usua5'])){$id_usua5=$_POST['id_usua5'];}else{$id_usua5=0;}






           // $recibio=($_POST['recibio']);
          
            $motivo_atn=($_POST['motivo_atn']);
           
            $alergias=($_POST['alergias']);
            $tipo_a=($_POST['tipo_a']);
          
            $id_cam = $_POST['habitacion'];
///////////////// datos financieros 
            $aseg = $_POST['aseg'];
            if (isset($_POST['dir_resp'])) {
            $dir_resp=$_POST['dir_resp'];
            }else{
              $dir_resp=" ";
            }

            if (isset($_POST['tel_rf'])) {
            $tel_res=$_POST['tel_rf'];
            }else{
              $tel_res=" ";
            }
            

            if (isset($_POST['aval'])) {
             $aval =$_POST['aval'];
            }else{
              $aval=" ";
            }
            
            $banco =$_POST['banco'];
            $deposito =$_POST['deposito'];
           // $dep_l =$_POST['dep_l'];
            //$fec_deposito =$_POST['fec_deposito'];
            $id_usu = $_GET['id_usu'];
          

           function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
        $bisiesto=true;
        return $bisiesto;
 }

 function calculaedad($fecnac)
 {


$fecha_actual = date("Y-m-d");
$fecha_nac=$fecnac;
$fecha_de_nacimiento =strval($fecha_nac);

// separamos en partes las fechas
$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
$array_actual = explode ( "-", $fecha_actual );

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

//ajuste de posible negativo en $días
if ($dias < 0)
{
    --$meses;

    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
    switch ($array_actual[1]) {
           case 1:     $dias_mes_anterior=31; break;
           case 2:     $dias_mes_anterior=31; break;
           case 3:     
               if (bisiesto($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
               
           case 4:     $dias_mes_anterior=31; break;
           case 5:     $dias_mes_anterior=30; break;
           case 6:     $dias_mes_anterior=31; break;
           case 7:     $dias_mes_anterior=30; break;
           case 8:     $dias_mes_anterior=31; break;
           case 9:     $dias_mes_anterior=31; break;
           case 10:    $dias_mes_anterior=30; break;
           case 11:    $dias_mes_anterior=31; break;
           case 12:    $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

 if($anos > "0" ){
   $edad = $anos." años";
}elseif($anos <="0" && $meses>"0"){
   $edad = $meses." meses";
    
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    $edad = $dias." días";
}

 return $edad;
}


$edad = calculaedad($fecnac);
           
$fecha_actual = date("Y-m-d H:i:s");

$papell = ucfirst($papell);
$sapell = ucfirst($sapell);
$nom_pac = ucfirst($nom_pac);
$loc = ucfirst($loc);
$dir = ucfirst($dir);
//$ocup = ucfirst($ocup);
$resp = ucfirst($resp);
$dom_resp = ucfirst($dom_resp);


$sql1="SELECT * FROM paciente WHERE papell= $papell and sapell= $sapell and nom_pac= $nom_pac and fecnac=$fecnac";        
$resultadof=$conexion->query($sql1);
$fila = mysqli_num_rows($resultadof);

if($fila==0){

$ingresar = mysqli_query($conexion, 'insert into paciente(curp,papell,sapell,nom_pac,fecnac,edad,id_edo_nac,sexo,nac,id_edo,id_mun,loc,dir,tel,fecha,h_clinica,religion,l_indigena,edociv,resp,paren,tel_resp,dom_resp) values("' . $stringCURP . '","' . $papell . '","' . $sapell . '","' . $nom_pac . '","' . $fecnac . '","' . $edad . '","' . $estado . '","' . $sexo . '","MEXICANA","' . $id_edo . '","' . $id_mun . '","' . $loc . '","' . $dir . '","' . $tel . '","'.$fecha_actual.'","NO","' . $religion . '","' . $l_indigena . '","' . $edociv . '","' . $resp . '","' . $paren . '","' . $tel_resp . '","' . $dom_resp . '")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

}else{
     header ("location: paciente.php?error=Este paciente ya ha sido registrado");
}




    if ($ingresar) { // ingresar admision
        $resultado1 = $conexion ->query("SELECT * FROM paciente ORDER by Id_exp DESC LIMIT 1")or die($conexion->error);
           if(mysqli_num_rows($resultado1) > 0 ){ //se mostrara si existe mas de 1
               $fila=mysqli_fetch_row($resultado1);
               $id_exp=$fila[0];
                }else
                {
                 header("Location: ../registro_pac.php"); //te regresa a la página principal
                }

$sql20 = "UPDATE paciente SET folio= $id_exp WHERE id_exp = $id_exp";
      $resultt = $conexion->query($sql20);

if($sexo=="M"){
    $sql2 = "UPDATE paciente SET sexo = 'Mujer' WHERE id_exp = $id_exp";
        $result = $conexion->query($sql2);
}else if($sexo=="H"){
    $sql2 = "UPDATE paciente SET sexo = 'Hombre' WHERE id_exp = $id_exp";
        $result = $conexion->query($sql2);
}




if($id_usua=="OTRO"){
 $papell_med = $_POST['papell_med'];
    $sapell_med = $_POST['sapell_med'];
     $nom_med = $_POST['nom_med'];
  
     //$nombre = $_POST['nombre'];
      
$ingresar_usu = mysqli_query($conexion, 'insert into reg_usuarios(nombre,papell,sapell,id_rol) values("'.$nom_med.'","'.$papell_med.'","'.$sapell_med.'","2")') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


$buscar = $conexion ->query("SELECT id_usua FROM reg_usuarios ORDER by id_usua DESC LIMIT 1")or die($conexion->error);
while ($row= $buscar->fetch_assoc()) {
  $id_usua=$row['id_usua'];
}

}


$resu_seg = $conexion ->query("SELECT aseg FROM cat_aseg WHERE id_aseg = $aseg ")or die($conexion->error);
  if(mysqli_num_rows($resu_seg) > 0 ){ //se mostrara si existe mas de 1
      $f3=mysqli_fetch_row($resu_seg);
      $asegu=$f3[0];
  }
 
  
 // Aquí se quitó el área para que tome el que corresponde en cat_camas y la especialidad
   $ingresar=mysqli_query($conexion,'insert into dat_ingreso(Id_exp,fecha,alergias,tipo_a,id_usua,fecha_cama,aseg,id_usua2,id_usua3,id_usua4,id_usua5,motivo_atn) values ('.$id_exp.',"'.$fecha_actual.'","'.$alergias.'","'.$tipo_a.'",'.$id_usua.',"'.$fecha_actual.'","'.$asegu.'",'.$id_usua2.','.$id_usua3.','.$id_usua4.','.$id_usua5.',"'.$motivo_atn.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));
                       // ingresar datos financieros

 
                       // ingresar datos financieros

    if($ingresar){
         $resultado1 = $conexion ->query("SELECT id_atencion FROM dat_ingreso ORDER by id_atencion DESC LIMIT 1")or die($conexion->error);
   if(mysqli_num_rows($resultado1) > 0 ){ //se mostrara si existe mas de 1
          $fila=mysqli_fetch_row($resultado1);
          $id_at=$fila[0];
        
          }else{ header("Location: ../registro_pac.php"); //te regresa a la página principal
        }



  /////////////////////////////////////////////////////
   //
   //
   ////////////////////////////////////////////////////     
  //// validacion si encuentra resultado en habitacion  
  if(isset($_POST['habitacion'])){
          //// update de  camas id_atencion
      $sql2 = "UPDATE cat_camas SET estatus = 'OCUPADA', id_atencion= $id_at WHERE id = $id_cam";
      $result = $conexion->query($sql2);

            ///// tomar el registro de camas  habitacion y id_atencion
      $resultado3 = $conexion ->query("SELECT * FROM cat_camas WHERE id = $id_cam ")or die($conexion->error);

  if(mysqli_num_rows($resultado3) > 0 ){ //se mostrara si existe mas de 1
      $f3=mysqli_fetch_row($resultado3);
      $habitacion=$f3[0];
      $id_at=$f3[5];
        //$cobro_cve=$fila[9];
  }else{header("Location: ../registro_pac.php"); //te regresa a la página principal
   } 

$resultado5 = $conexion->query("SELECT * FROM cat_camas WHERE id = $id_cam ") or die($conexion->error);
 while ($f5 = mysqli_fetch_array($resultado5)) {
 $cobro_cve=$f5["serv_cve"];
 $ubica=$f5["tipo"];
 }

            //// ingresar habitacion en insumo y id_atencion en id_atencion de la tabla dat_ctapac 

$fecha_actual = date("Y-m-d H:i:s");     
  
     $ingresar3=mysqli_query($conexion,'insert into dat_ctapac(id_atencion,prod_serv,insumo,cta_fec,cta_cant,id_usua,centro_cto) values ('.$id_at.',"S","'.$cobro_cve.'","'.$fecha_actual.'",1,'.$id_usu.',"'.$ubica.'")') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion)); 
  
   $sql3 = "UPDATE dat_ingreso SET cama='1', area='$ubica', especialidad='$ubica' WHERE id_atencion = $id_at";
      $result = $conexion->query($sql3);
} 
///////////////////////////////////////////////////////////////////////
//                                            
//                                  
////////////////////////////////////////////////////////////////////////
                           ///// selecciona ultimo registro de la Tabla pacientes                     
       $resultado2 = $conexion ->query("SELECT resp,id_edo, id_mun FROM paciente ORDER by Id_exp DESC LIMIT 1")or die($conexion->error);
  
  if(mysqli_num_rows($resultado2) > 0 ){ //se mostrara si existe mas de 1
      $fila1=mysqli_fetch_row($resultado2);
      $resp=$fila1[0];
      $id_edo=$fila1[1];
      $id_mun=$fila1[2];
  }else{ header("Location: ../registro_pac.php"); //te regresa a la página principal
  }
                          ///// ingresar los campos de la tabla paciente en la tabla dat_financieros y crear registro

  
 $fecha_actual = date("Y-m-d H:i:s");


$fecha_actual2 = date("Y-m-d H:i:s"); 
     $ingresar=mysqli_query($conexion,'insert into dat_financieros(id_atencion,aseg,resp,dir_resp,id_edo,id_mun,tel,aval,banco,deposito,dep_l,fec_deposito,fecha,id_usua) values ('.$id_at.',"'.$asegu.'","'.$resp.'","'.$dir_resp.'",'.$id_edo.','.$id_mun.',"'.$tel_res.'","'.$aval.'","'.$banco.'",'.$deposito.',"'.$letra.'","'.$fecha_actual.'","'.$fecha_actual2.'",'.$id_usu.')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion)); 

     
                                                       //redireccion
      header ('location: ../gestion_pacientes/vista_paciente.php');
     }else{ echo 'error al isertar datos dinancieros';
}
} 
    else 
    {
  echo 'error al insertar';
    }
} 
    else 
    {
  header('location: ../gestion_pacientes/vista_paciente.php');
}
